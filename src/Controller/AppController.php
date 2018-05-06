<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
//use Cake\Controller\Component\CookieComponent;
use Cake\Event\Event;
use Crypt\Crypt;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public $paginationLimit = 5;
	
	public $limitNewsRightPanel = 5;
	
	public $limitQuestionRightPanel = 5;
	
	public $limitTags = 5;
	
	public $limitUsers = 5;
	
	public $limitMostViewedQuestions = 5;
	
	public $limitLatestQuestions = 5;
	
	public $limitNewsComments = 5;
    
    public function initialize()
    {
        parent::initialize();
        $this->addCrpyt();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Cookie->name = 'RememberMe';
        $this->Cookie->time = 3600*720;  // or '30 days'
        $this->Cookie->path = '/learneron/';
        $this->Cookie->domain = 'localhost';
        $this->Cookie->secure = false;  // i.e. only sent if using secure HTTPS
        $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
        $this->Cookie->httpOnly = true;

        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => '/'
            ],
            'loginRedirect' => [
                'controller' => 'users',
                'action' => 'myAccount'
            ],
            'logoutRedirect' => [
                'controller' => '/'
            ],
            'authError' => 'Invalid Credentials.',
            'authenticate' => [
                'Form' => [
                    'userModel' => DB_PREFIX.'users',
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    'scope' => [DB_PREFIX.'users.status' => 'A']
                ]
            ],
            'storage' => [
                            'className' => 'Session',
                            'key' => 'Auth.Users'
                        ]
        ]);
        // access auth data as $Auth in view page
        
        $site_settings = $this->getSiteSettings();
        $this->RememberMe();
        $this->set('Auth', $this->Auth->user());
		
		$user_related_details = '';
		if(!empty($this->Auth->user())){
			$userdata = $this->request->session()->read('Auth.Users');
			$UsersTable = TableRegistry::get('Users');
			$user_related_details = $UsersTable->get($userdata['id']);
		}		
		$terms_and_conditions	= $this->getTermsAndConditions();
		$personal_data 			= $this->getPersonalData();
		$cookie_data 			= $this->getCookieConsent();
		
		$UsersTable = TableRegistry::get('Users');
		$query_inactive = $UsersTable->query();
		$query_active = $UsersTable->query();
		//if user inactive more than 30 minutes
		$query_inactive->update()
			->set(['loggedin_status'=>0])
			->where(['loggedin_status'=>1,'loggedin_time <'=> date('Y-m-d H:i:s', strtotime('-30 minutes'))])
			->execute();
		//when user refresh then set loggedin status to 1 and current datetime
		$query_active->update()
			->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
			->where(['id'=>$this->Auth->user('id')])
			->execute();
		
		//Cookie Consent
		$get_details = '';
		$CookieConsentTable = TableRegistry::get('CookieConsent');
		$userip = $this->getUserIP();//'192.168.1.127';
		$get_details = $CookieConsentTable->find('all', ['conditions'=>array('CookieConsent.user_ipaddress'=>$userip,'CookieConsent.withdrawl_status'=>0)])->first();		
		$this->set(compact('site_settings','user_related_details','terms_and_conditions','personal_data','get_details','cookie_data'));
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event){
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
    /**
     * [RememberMe function is for checking whether user clicked on remember me or not previously.]
     */
    public function RememberMe(){
        $session = $this->request->session();
        if($session->read('Users.remember_me')!=''){
			$this->Cookie->write('RememberMe', $session->read('Users.remember_me'));
			$session->delete('Users.remember_me');
        }
        if($session->read('Users.logout')!=''){
          $this->Cookie->delete('RememberMe');
          $session->delete('Users.logout');
        }
        $user = TableRegistry::get('Users');
        if($this->Cookie->read('RememberMe')!=''){
          $user_data = $user->get($this->Cookie->read('RememberMe'));
          return $this->Auth->setUser($user_data);
        }
    }

    /**
     * [addCrpyt for password hassing]
     */
    public function addCrpyt(){
        require_once(ROOT . '/vendor' . DS  . 'Crypt' . DS . 'Crypt.php');
        /*
        * usage to hash $this->Crypt->hash(stringToHash)
        * usage to unhash $this->Crypt->unhash(hashedString)
        */
        $this->Crypt = new Crypt();
    }

    /**
     * [getSiteSettings for getting website settings.]
     * @return [Array Object] [all website settings data from the database]
     */
    public function getSiteSettings(){
        $settings = TableRegistry::get('Admin.CommonSetting');
        $site_settings = $settings->find('all')->first();
        return $site_settings;
    }
	
	/**
     * [getFeaturedQuestions for rightpanel]
     */
    public function getFeaturedQuestions(){
		$QuestionsTable = TableRegistry::get('Questions');
		$question_options['contain']	= ['Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic','Users.type']]];
		$question_options['conditions']	= ['Questions.is_featured'=>'Y', 'Questions.status'=>'A'];
		$question_options['fields']		= ['Questions.id','Questions.name','Questions.slug'];
		$question_options['order']		= ['Questions.created'=>'DESC'];
		$question_options['limit']		= $this->limitQuestionRightPanel;
		$featured_question_rightpanel 	= $QuestionsTable->find('all',$question_options)->toArray();
        return $featured_question_rightpanel;
    }
	
	/**
     * [getLatestMostViewedQuestions for rightpanel to show last 7 days viewed question]
     */
    public function getRecentlyMostViewedQuestions(){
		$QuestionsTable = TableRegistry::get('Questions');		
		$current_date = date('Y-m-d');
		$last_seventh_date = date('Y-m-d', strtotime('-6 days', strtotime($current_date)));	//previous 7th date
		$current_date = date('Y-m-d', strtotime('+1 days', strtotime($current_date)));
		$current_date = "'".$current_date."'";
		$last_seventh_date = "'".$last_seventh_date."'";		
		$question_options['contain']				= ['Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic','Users.type']]];
		$question_options['conditions'][]			= ['Questions.status'=>'A'];
		$question_options['conditions'][]			= ['Questions.modified BETWEEN '.$last_seventh_date.' and '.$current_date];
		$question_options['fields']					= ['Questions.id','Questions.name','Questions.slug','Questions.modified','Questions.status'];
		$question_options['order']					= ['Questions.modified'=>'DESC'];
		$question_options['limit']					= $this->limitQuestionRightPanel;		
		$recently_most_viewed_question_rightpanel 	= $QuestionsTable->find('all',$question_options)->toArray();
		return $recently_most_viewed_question_rightpanel;
    }
	
	/**
     * [getLatestNews for rightpanel]
     */
    public function getLatestNews(){
		$NewsTable = TableRegistry::get('News');
		$option['contain']		= ['Users'=>['fields'=>['Users.id','Users.name']]];
		$option['conditions']	= ['News.status'=>'A'];
		$option['fields']		= ['News.id','News.user_id','News.name','News.slug','News.description','News.image','News.created'];
		$option['order']		= ['News.created'=>'DESC'];
		$option['limit']		= $this->limitNewsRightPanel;
		$latest_news_rightpanel = $NewsTable->find('all',$option)->toArray();
        return $latest_news_rightpanel;
    }
	
	/**
     * [getNewsCategories function is for getting all active news categories]
     */
    public function getNewsCategories(){
		$NewsCategoriesTable = TableRegistry::get('NewsCategories');
        $news_cat_data = $NewsCategoriesTable->find('all', ['contain'=>['News'=>['fields'=>['News.id','News.category_id']]],'conditions'=>['NewsCategories.status'=>'A'],'fields'=>['NewsCategories.id','NewsCategories.name','NewsCategories.slug'], 'order'=>['NewsCategories.name ASC']])->toArray();	
		return $news_cat_data;
    }
	
	/**
     * [getQuestionCategories function is for getting all active question categories]
     */
    public function getQuestionCategories(){
		$QuestionCategoriesTable = TableRegistry::get('QuestionCategories');
        $question_cat_data = $QuestionCategoriesTable->find('all', ['contain'=>['Questions'=>['conditions'=>['Questions.status'=>'A'],'fields'=>['Questions.id','Questions.category_id','Questions.status']]],'conditions'=>['QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'], 'order'=>['QuestionCategories.name ASC']])->toArray();
		return $question_cat_data;
    }
	
	/*
	For Question Management
	*/
    public function getQuestionCategoriesSorted(){
        /*$categoryTable = TableRegistry::get('Admin.QuestionCategories');
        $cat_data = $categoryTable->find('all', ['conditions'=>['QuestionCategories.parent_id'=>0,'QuestionCategories.status'=>'A']])->toArray();
		if(!empty($cat_data)){
			foreach($cat_data as $category){
				$child_cat_data = $categoryTable->find('all', ['conditions'=>['QuestionCategories.parent_id'=>$category->id, 'QuestionCategories.status'=>'A'], ['order'=>['NewsCategories.id'=>'desc']]])->toArray();
				$data[$category->id] = $category->name;
				if(!empty($child_cat_data)){
					foreach($child_cat_data as $child_data){
						$data[$child_data->id] = '__'.$child_data->name;
					}
				}
            }
        }else{
            $data = Array();
        }*/
		$QuestionParentCategories = TableRegistry::get('Admin.QuestionCategories');
        $cat_level_1 = $QuestionParentCategories->find('all', ['conditions'=>['QuestionCategories.parent_id'=>0,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name']])->toArray();	//category level 1
		if( count($cat_level_1) >0 ):
			foreach($cat_level_1 as $cat_1){
				$data[$cat_1->id] = $cat_1->name;
				$cat_level_2 = $QuestionParentCategories->find('all', ['conditions'=>['QuestionCategories.parent_id'=>$cat_1->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name']])->toArray();	//category level 2
				if( count($cat_level_2) >0 ):
					foreach($cat_level_2 as $cat_2){
						$data[$cat_2->id] = '_'.$cat_2->name;
						$cat_level_3 = $QuestionParentCategories->find('all', ['conditions'=>['QuestionCategories.parent_id'=>$cat_2->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name']])->toArray();																		//category level 3
						if( count($cat_level_3) >0 ):
							foreach($cat_level_3 as $cat_3){
								$data[$cat_3->id] = '__'.$cat_3->name;
								$cat_level_4 = $QuestionParentCategories->find('all', ['conditions'=>['QuestionCategories.parent_id'=>$cat_3->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name']])->toArray();																		//category level 4
								if( count($cat_level_4) >0 ):
									foreach($cat_level_4 as $cat_4){
										$data[$cat_4->id] = '___'.$cat_4->name;
									}
								endif;
							}
						endif;
					}
				endif;
			}
		else :
			$data = '';
		endif;
        return $data;
    }
	
	/**
     * [getTimeAgo for qestions to get X mins ago, X hours ago, X days ago]
     */
    /*public function getTimeAgo($past_time=NULL){
		//echo date('Y-m-d H:i:s', time()); die;
		$etime = time() - $past_time;
		if($etime < 1){
			return 'less than '.$etime.' second ago';
		}
		$time_table = array(12 * 30 * 24 * 60 * 60	=> 'year',
							30 * 24 * 60 * 60 	  	=> 'month',
						    24 * 60 * 60			=> 'day',
						    60 * 60			  	  	=> 'hour',
							60				  	  	=> 'min',
							1					  	=> 'second'						
		);
		foreach($time_table as $secs => $str){
			$get = $etime / $secs;
			if($get >= 1){
				$ago = round( $get );
				return $ago.' '.$str.($ago > 1 ? 's' : ''). ' ago';
			}
		}
    }*/
	
	/**
     * [getUserIP function is for to get user ip address]
     */
    public function getUserIP(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
		return $ip;
    }

    /**
     * [generateRandomString to generate a random string all over the site sing this function]
     * @param  integer $length [length of the string default 10 ]
     * @return [String]
     */
    public function generateRandomString($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * [isDataExist for check if any data exist in the database or not]
     * @param  [string]  $modelName     [model name]
     * @param  [string]  $fieldName [field name which need to check]
     * @param  [stsing]  $data      [data to check]
     * @return boolean            [will return true if email exist]
     */
    public function isDataExist($modelName = NULL, $fieldName = NULL, $data = NULL){
        $tbl_reg = TableRegistry::get($modelName);
        $data = $tbl_reg->find('all', array('conditions'=>array($modelName.'.'.$fieldName => $data)))->toArray();
        if (empty($data)) {
            return false;
        } else {
            return true;
        }
    }
    
    //getAccountSetting function is for getting Account Details of user
    public function getAccountSetting($user_id=NULL){
		$UserAccountSettingTable = TableRegistry::get('UserAccountSetting');
		$account_data = $UserAccountSettingTable->find('all', ['conditions'=>['user_id'=>$user_id],'fields'=>['user_id','response_to_my_question_notification','news_notification','follow_twitter','posting_new_question_notification','category_id']])->first();
		return $account_data;
    }
	
	//getAccountSettingCategoryWise function is for getting Account Details of all user
    public function getAccountSettingCategoryWise($category_id=NULL){
		$UserAccountSettingTable = TableRegistry::get('UserAccountSetting');
		$account_data = $UserAccountSettingTable->find('all', ['contain'=>['Users'=>['fields'=>['Users.id','Users.name','Users.title','Users.email','Users.notification_email']]],'conditions'=>['category_id'=>$category_id],'fields'=>['user_id','response_to_my_question_notification','news_notification','follow_twitter','posting_new_question_notification','category_id']]);
		return $account_data;
    }
	
	//getAccountSettingNews function is for getting Account Details of all user who wants news notification
    public function getAccountSettingNews(){
		$UserAccountSettingTable = TableRegistry::get('UserAccountSetting');
		$account_data = $UserAccountSettingTable->find('all', ['contain'=>['Users'=>['fields'=>['Users.id','Users.name','Users.title','Users.email','Users.notification_email']]],'conditions'=>['news_notification'=>1],'fields'=>['user_id','response_to_my_question_notification','news_notification','follow_twitter','posting_new_question_notification','category_id']]);
		return $account_data;
    }
	
	//getTermsAndConditions
	public function getTermsAndConditions(){
        $CmsTable = TableRegistry::get('Cms');
        $data = $CmsTable->find('all',['conditions'=>['id'=>4],'fields'=>['id','description']])->first()->toArray();
		return $data;
    }
	
	//getPersonalData
	public function getPersonalData(){
        $CmsTable = TableRegistry::get('Cms');
        $data = $CmsTable->find('all',['conditions'=>['id'=>7],'fields'=>['id','description']])->first()->toArray();
		return $data;
    }
	
	//getCookieConsent
	public function getCookieConsent(){
        $CmsTable = TableRegistry::get('Cms');
        $data = $CmsTable->find('all',['conditions'=>['id'=>8],'fields'=>['id','description']])->first()->toArray();
		return $data;
    }
	
	public function getTreeQuestionCategoriesSorted(){
        $QuestionParentCategories = TableRegistry::get('QuestionCategories');
        $cat_level_1 = $QuestionParentCategories->find('all', ['contain'=>['Questions'=>['conditions'=>['Questions.status'=>'A'],'fields'=>['Questions.id','Questions.category_id','Questions.status']]],'conditions'=>['QuestionCategories.parent_id'=>0,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id','QuestionCategories.name','QuestionCategories.slug'], 'order'=>['QuestionCategories.name ASC']])->toArray();	//category level 1
		if( count($cat_level_1) >0 ):
			foreach($cat_level_1 as $cat_1){
				$data[$cat_1->slug] = $cat_1->name.' ('.count($cat_1->questions).')';
				$cat_level_2 = $QuestionParentCategories->find('all',['contain'=>['Questions'=>['conditions'=>['Questions.status'=>'A'],'fields'=>['Questions.id','Questions.category_id','Questions.status']]],'conditions'=>['QuestionCategories.parent_id'=>$cat_1->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name','QuestionCategories.slug']])->toArray();																			//category level 2
				if( count($cat_level_2) >0 ):
					foreach($cat_level_2 as $cat_2){
						$data[$cat_2->slug] = '*'.$cat_2->name.' ('.count($cat_2->questions).')';
						$cat_level_3 = $QuestionParentCategories->find('all', ['contain'=>['Questions'=>['conditions'=>['Questions.status'=>'A'],'fields'=>['Questions.id','Questions.category_id','Questions.status']]],'conditions'=>['QuestionCategories.parent_id'=>$cat_2->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id','QuestionCategories.name','QuestionCategories.slug']])->toArray();																	//category level 3
						if( count($cat_level_3) >0 ):
							foreach($cat_level_3 as $cat_3){
								$data[$cat_3->slug] = '**'.$cat_3->name.' ('.count($cat_3->questions).')';
								$cat_level_4 = $QuestionParentCategories->find('all', ['contain'=>['Questions'=>['conditions'=>['Questions.status'=>'A'],'fields'=>['Questions.id','Questions.category_id','Questions.status']]],'conditions'=>['QuestionCategories.parent_id'=>$cat_3->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name','QuestionCategories.slug']])->toArray();								//category level 4
								if( count($cat_level_4) >0 ):
									foreach($cat_level_4 as $cat_4){
										$data[$cat_4->slug] = '***'.$cat_4->name.' ('.count($cat_4->questions).')';
									}
								endif;
							}
						endif;
					}
				endif;
			}
		else :
			$data = '';
		endif;
        return $data;
    }
	
	public function visitorlogs($controller_name=NULL, $method_name=NULL, $page_name=NULL, $news_id=NULL, $news_category_id=NULL, $userid=NULL, $questionid=NULL, $question_category_id=NULL, $answer_id=NULL, $tag_id=NULL){
		$loggedin_user_id 		= $this->Auth->user('id');
		$VisitorTable 			= TableRegistry::get('Visitor');
		$VisitorLogTable 		= TableRegistry::get('VisitorLog');
		$current_url 			= Router::url( $this->here, true );
		$get_ip 				= $this->getUserIP();
		//$controller 			= isset($this->request->params)?$this->request->params['controller']:'';
		//$method 				= isset($this->request->params)?$this->request->params['action']:'';
		$controller 			= isset($controller_name)?$controller_name:'';
		$method 				= isset($method_name)?$method_name:'';
		$page_name 				= isset($page_name)?$page_name:'';
		$news_id 				= isset($news_id)?$news_id:'';
		$news_category_id 		= isset($news_category_id)?$news_category_id:'';
		$user_id 				= isset($userid)?$userid:'';
		$question_id 			= isset($questionid)?$questionid:'';
		$question_category_id 	= isset($question_category_id)?$question_category_id:'';
		$answer_id 				= isset($answer_id)?$answer_id:'';
		$tag_id 				= isset($tag_id)?$tag_id:'';
		
		if( $loggedin_user_id == '' ){
			//First checking is for USER IP is already exist or not
			$check_visitor_ip = $VisitorTable->find('all',['conditions'=>['Visitor.user_ipaddress'=>$get_ip]])->first();
			if( count($check_visitor_ip) > 0 ){
				$visitor_last_id = $check_visitor_ip->id;
				//checking url for a particular day exist or not
				$count = $VisitorLogTable->find('all',['conditions'=>['VisitorLog.visitor_id'=>$visitor_last_id,'VisitorLog.page_url'=>$current_url,'VisitorLog.visited_time LIKE'=>date('Y-m-d').'%']])->count();
				if( $count == 0 ){
					$visitor_log_data['visitor_id'] 				= $visitor_last_id;
					$visitor_log_data['page_name'] 					= $page_name;
					$visitor_log_data['page_url'] 					= $current_url;
					$visitor_log_data['controller'] 				= $controller;
					$visitor_log_data['method'] 					= $method;
					if($controller == 'News'){
						$visitor_log_data['news_id'] 				= $news_id;
						$visitor_log_data['news_category_id'] 		= $news_category_id;						
					}
					else if($controller == 'Questions'){
						$visitor_log_data['question_id']			= $question_id;
						$visitor_log_data['question_category_id'] 	= $question_category_id;
						$visitor_log_data['answer_id'] 				= $answer_id;
						$visitor_log_data['tag_id'] 				= $tag_id;
					}
					$visitor_log_data['user_id'] 					= $user_id;
					$visitor_log_data['visited_time'] 				= date('Y-m-d H:i:s');
					$VisitorLogNewEntity 							= $VisitorLogTable->newEntity();
					$insert_log 									= $VisitorLogTable->patchEntity($VisitorLogNewEntity, $visitor_log_data);
					$VisitorLogTable->save( $insert_log );
				}				
			}else{
				$visitor_data['user_id'] 				= 0;
				$visitor_data['user_ipaddress'] 		= $get_ip;
				$VisitorNewEntity 						= $VisitorTable->newEntity();
				$insert 								= $VisitorTable->patchEntity($VisitorNewEntity, $visitor_data);

				if( $saved_data = $VisitorTable->save($insert) ){
					$visitor_last_id 								= $saved_data->id;					
					$visitor_log_data['visitor_id'] 				= $visitor_last_id;
					$visitor_log_data['page_name'] 					= $page_name;
					$visitor_log_data['page_url'] 					= $current_url;
					$visitor_log_data['controller'] 				= $controller;
					$visitor_log_data['method'] 					= $method;
					if($controller == 'News'){
						$visitor_log_data['news_id'] 				= $news_id;
						$visitor_log_data['news_category_id'] 		= $news_category_id;
					}
					else if($controller == 'Questions'){
						$visitor_log_data['question_id']			= $question_id;
						$visitor_log_data['question_category_id'] 	= $question_category_id;
						$visitor_log_data['answer_id'] 				= $answer_id;
						$visitor_log_data['tag_id'] 				= $tag_id;
					}
					$visitor_log_data['user_id'] 					= $user_id;
					$visitor_log_data['visited_time'] 				= date('Y-m-d H:i:s');
					$VisitorLogNewEntity 							= $VisitorLogTable->newEntity();
					$insert_log 									= $VisitorLogTable->patchEntity($VisitorLogNewEntity, $visitor_log_data);
					$VisitorLogTable->save( $insert_log );
				}
			}
		}
		else{
			//First checking is for USER ID is already exist or not
			$check_visitor_id = $VisitorTable->find('all',['conditions'=>['Visitor.user_id'=>$loggedin_user_id]])->first();
			if( count($check_visitor_id) > 0 ){
				$visitor_last_id = $check_visitor_id->id;
				//checking url for a particular day exist or not
				$count = $VisitorLogTable->find('all',['conditions'=>['VisitorLog.visitor_id'=>$visitor_last_id,'VisitorLog.page_url'=>$current_url,'VisitorLog.visited_time LIKE'=>date('Y-m-d').'%']])->count();
				if( $count == 0 ){
					$visitor_log_data['visitor_id'] 				= $visitor_last_id;
					$visitor_log_data['page_name'] 					= $page_name;
					$visitor_log_data['page_url'] 					= $current_url;
					$visitor_log_data['controller'] 				= $controller;
					$visitor_log_data['method'] 					= $method;
					if($controller == 'News'){
						$visitor_log_data['news_id'] 				= $news_id;
						$visitor_log_data['news_category_id'] 		= $news_category_id;
					}
					else if($controller == 'Questions'){
						$visitor_log_data['question_id']			= $question_id;
						$visitor_log_data['question_category_id'] 	= $question_category_id;
						$visitor_log_data['answer_id'] 				= $answer_id;
						$visitor_log_data['tag_id'] 				= $tag_id;
					}
					$visitor_log_data['user_id'] 					= $loggedin_user_id;
					$visitor_log_data['visited_time'] 				= date('Y-m-d H:i:s');
					$VisitorLogNewEntity 							= $VisitorLogTable->newEntity();
					$insert_log 									= $VisitorLogTable->patchEntity($VisitorLogNewEntity, $visitor_log_data);
					$VisitorLogTable->save( $insert_log );
				}				
			}else{
				$visitor_data['user_id'] 							= $loggedin_user_id;
				$visitor_data['user_ipaddress'] 					= $get_ip;
				$VisitorNewEntity 									= $VisitorTable->newEntity();
				$insert 											= $VisitorTable->patchEntity($VisitorNewEntity, $visitor_data);
				if( $saved_data = $VisitorTable->save($insert) ){
					$visitor_last_id 								= $saved_data->id;					
					$visitor_log_data['visitor_id'] 				= $visitor_last_id;
					$visitor_log_data['page_name'] 					= $page_name;
					$visitor_log_data['page_url'] 					= $current_url;
					$visitor_log_data['controller'] 				= $controller;
					$visitor_log_data['method'] 					= $method;
					if($controller == 'News'){
						$visitor_log_data['news_id'] 				= $news_id;
						$visitor_log_data['news_category_id'] 		= $news_category_id;
					}
					else if($controller == 'Questions'){
						$visitor_log_data['question_id']			= $question_id;
						$visitor_log_data['question_category_id'] 	= $question_category_id;
						$visitor_log_data['answer_id'] 				= $answer_id;
						$visitor_log_data['tag_id'] 				= $tag_id;
					}
					$visitor_log_data['user_id'] 					= $loggedin_user_id;
					$visitor_log_data['visited_time'] 				= date('Y-m-d H:i:s');
					$VisitorLogNewEntity 							= $VisitorLogTable->newEntity();
					$insert_log 									= $VisitorLogTable->patchEntity($VisitorLogNewEntity, $visitor_log_data);
					$VisitorLogTable->save( $insert_log );
				}
			}
		}
	}
    
}