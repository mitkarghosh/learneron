<?php

namespace Admin\Controller;

use Cake\Controller\Controller;
use Cake\Network\Exception\NotFoundException;
use Crypt\Crypt;
use Cake\ORM\TableRegistry;

class AppController extends Controller
{

    public $paginationLimit = 10;

    public function initialize()
    {
        parent::initialize();
        // load flash for flash messages
        $this->loadComponent('Flash');
        // auth settings
        $this->loadComponent('Auth', [
	        'loginAction' => [
	            'controller' => 'admin-details',
	            'action' => 'login',
	            'plugin' => 'admin'
	        ],
	        'loginRedirect' => [
	            'controller' => 'admin-details',
	            'action' => 'dashboard',
	            'plugin' => 'admin'
	        ],
            'logoutRedirect' => [
                'controller' => 'admin-details',
                'action' => 'login',
	            'plugin' => 'admin'
            ],
	        'authError' => 'Invalid Credentials.',
	        'authenticate' => [
	            'Form' => [
	                'userModel' => DB_PREFIX.'admins',
	                'fields' => ['username' => 'email', 'password' => 'password'],
	                'scope' => [DB_PREFIX.'admins.status' => 'A']
	            ]
	        ],
	        'storage' => [
	        				'className' => 'Session',
	        				'key' => 'Auth.Admin'
	        			]
	    ]);
        $this->addCrpyt();
		
		$session = $this->request->session();		
		if(empty($session->read('permissions'))){
			if( $this->Auth->user('type') == 'SA' ){	//If SUPER ADMIN
				$adminMenusTable = TableRegistry::get('Admin.AdminMenus');
				$all_menus = $adminMenusTable->find('all',['conditions'=>['status'=>'A'],'fields'=>['id','main_menu_name','menu_name','menu_name_modified','controller_name','method_name','status']])->toArray();
				//pr($all_menus); die;
				if(!empty($all_menus)){
					foreach($all_menus as $key_am => $val_am){
						if($val_am['method_name'] != ''){
							$session->write('permissions.'.strtolower($val_am['controller_name']).'.'.strtolower($val_am['method_name']), 1);
						}
					}
				}
				$session->write('AdminUser',$this->Auth->user());
				
			}else{
				$adminPermisionsTable = TableRegistry::get('Admin.AdminPermisions');
				$all_permissions = $adminPermisionsTable->find('all',['contain'=>['AdminMenus'=>['conditions'=>['AdminMenus.status'=>'A','AdminMenus.is_display'=>'Y'],'fields'=>['AdminMenus.id','AdminMenus.controller_name','AdminMenus.method_name']]],'conditions'=>['AdminPermisions.admin_user_id'=>$this->Auth->user('id')],'fields'=>['AdminPermisions.id','AdminPermisions.admin_user_id','AdminPermisions.admin_menu_id']])->toArray();
				if(!empty($all_permissions)){
					foreach($all_permissions as $key_ap => $val_ap){
						$session->write('permissions.'.strtolower($val_ap['admin_menu']['controller_name']).'.'.strtolower($val_ap['admin_menu']['method_name']), 1);
					}
				}
				$session->write('AdminUser',$this->Auth->user());
			}
		}
    }	
	
    /**
     * Crypt assign
     */
    public function addCrpyt()
    {
        require_once(ROOT . '/vendor' . DS  . 'Crypt' . DS . 'Crypt.php');
        /*
        * usage to hash $this->Crypt->hash(stringToHash)
        * usage to unhash $this->Crypt->unhash(hashedString)
        */
        $this->Crypt = new Crypt();
    }
    /**
     * [getNewsCategiries getting all active blog categories]
     * @return [type] [description]
     */
    public function getNewsCategories(){
        $categoryTable = TableRegistry::get('Admin.NewsCategories');
        $cat_data = $categoryTable->find('all', ['conditions'=>['NewsCategories.parent_id'=>0,'NewsCategories.status'=>'A']])->toArray();
		if(!empty($cat_data)){
			foreach($cat_data as $category){
				$child_cat_data = $categoryTable->find('all', ['conditions'=>['NewsCategories.parent_id'=>$category->id, 'NewsCategories.status'=>'A'], ['order'=>['NewsCategories.id'=>'desc']]])->toArray();
				$data[$category->id] = $category->name;
				if(!empty($child_cat_data)){
					foreach($child_cat_data as $child_data){
						$data[$child_data->id] = '__'.$child_data->name;
					}
				}
            }
        }else{
            $data = Array();
        }
        return $data;
    }
    
    public function isDataExist($modelName = null, $fieldName = null, $data = null){
		$tbl_reg = TableRegistry::get('Admin.'.$modelName);
        $data = $tbl_reg->find('all', array('conditions'=>array($modelName.'.'.$fieldName => $data)))->toArray();
        if (empty($data)) {
            return false;
        } else {
            return true;
        }
    }
    /*
	For Question Category Management
	*/
    public function getQuestionParentCategory(){
		$QuestionParentCategories = TableRegistry::get('Admin.QuestionCategories');
        $cat_level_1 = $QuestionParentCategories->find('all', ['conditions'=>['QuestionCategories.parent_id'=>0,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name']])->toArray();	//category level 1
		if( count($cat_level_1) >0 ):
			foreach($cat_level_1 as $cat_1){
				$data[$cat_1->id]['name'] = $cat_1->name;
				$data[$cat_1->id]['level'] = 1;
				$cat_level_2 = $QuestionParentCategories->find('all', ['conditions'=>['QuestionCategories.parent_id'=>$cat_1->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name']])->toArray();	//category level 2
				if( count($cat_level_2) >0 ):
					foreach($cat_level_2 as $cat_2){
						$data[$cat_2->id]['name'] = '_'.$cat_2->name;
						$data[$cat_2->id]['level'] = 2;
						$cat_level_3 = $QuestionParentCategories->find('all', ['conditions'=>['QuestionCategories.parent_id'=>$cat_2->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name']])->toArray();																		//category level 3
						if( count($cat_level_3) >0 ):
							foreach($cat_level_3 as $cat_3){
								$data[$cat_3->id]['name'] = '__'.$cat_3->name;
								$data[$cat_3->id]['level'] = 3;
								$cat_level_4 = $QuestionParentCategories->find('all', ['conditions'=>['QuestionCategories.parent_id'=>$cat_3->id,'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.parent_id', 'QuestionCategories.name']])->toArray();																		//category level 4
								if( count($cat_level_4) >0 ):
									foreach($cat_level_4 as $cat_4){
										$data[$cat_4->id]['name'] = '___'.$cat_4->name;
										$data[$cat_4->id]['level'] = 4;
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
	
	/*
	For Question Management
	*/
    public function getQuestionCategories(){
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
	
    public function getNewsParentCategory(){
        $NewsParentCategories = TableRegistry::get('Admin.NewsCategories');
		$cat_data = $NewsParentCategories->find('all', ['conditions'=>['NewsCategories.parent_id'=>0],'fields'=>['NewsCategories.id', 'NewsCategories.name']])->toArray();
		if( count($cat_data) >0 ):
			foreach($cat_data as $cat){
				$data[$cat->id] = $cat->name;
			}
		else :
			$data = '';
		endif;
        return $data;
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
     * [getSiteSettings for getting website settings.]
     * @return [Array Object] [all website settings data from the database]
     */
    public function getSiteSettings()
    {
        $settings = TableRegistry::get('Admin.CommonSetting');
        $site_settings = $settings->find('all')->first();
        return $site_settings;
    }	
	
	//getAccountSetting function is for getting Account Details of user
    public function getAccountSetting($user_id=NULL){
		$UserAccountSettingTable = TableRegistry::get('UserAccountSetting');
		$account_data = $UserAccountSettingTable->find('all', ['conditions'=>['user_id'=>$user_id],'fields'=>['user_id','response_to_my_question_notification','news_notification','follow_twitter','posting_new_question_notification','category_id']])->first();
		return $account_data;
    }
	
	//getAccountSettingNews function is for getting Account Details of all user who wants news notification
    public function getAccountSettingNews(){
		$UserAccountSettingTable = TableRegistry::get('UserAccountSetting');
		$account_data = $UserAccountSettingTable->find('all', ['contain'=>['Users'=>['fields'=>['Users.id','Users.name','Users.title','Users.email','Users.notification_email']]],'conditions'=>['news_notification'=>1],'fields'=>['user_id','response_to_my_question_notification','news_notification','follow_twitter','posting_new_question_notification','category_id']])->toArray();
		return $account_data;
    }
	
}