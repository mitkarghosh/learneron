<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Routing\Router;
require_once(ROOT . DS . 'vendor' . DS ."google-api-php-client". DS ."src". DS ."Google_Client.php");
require_once(ROOT . DS . 'vendor' . DS ."google-api-php-client". DS ."src". DS . 'contrib' . DS . 'Google_Oauth2Service.php');
require_once(ROOT . DS . 'vendor' . DS . "twitter" . DS . "twitteroauth.php");
require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");

class UsersController extends AppController{
	public function beforeFilter(Event $event){
        parent::beforeFilter($event);
		$this->loadComponent('Email');
		$this->Cookie->configKey('User', [
            'expires' => '+10 days',
            'httpOnly' => true
        ]);
		
        $this->Auth->allow(['signup','signupSetting','seeSettingNowUpdate','emailExist','verify','login','forgotPassword','resetPassword','allUsers','search','ajaxLogin','ajaxChangeHeader','getUserPublicDetails','facebookLogin','googleLogin','gplusConfirmLogin','twitterLogin','twittercallback','linkedinLogin','linkedinCallBack','viewSubmissions','cookieConsent']);
		
		$latest_news_rightpanel = $this->getLatestNews();
		//$featured_question_rightpanel = $this->getFeaturedQuestions();
		$featured_question_rightpanel = '';
		$this->set(compact('latest_news_rightpanel','featured_question_rightpanel'));
    }
    
	//All users listing page
    public function allUsers(){
		$this->visitorlogs('Users','allUsers','Users Listing');		//Log details insertion
        $UsersTable = TableRegistry::get('Users');
		$alphabet_options['conditions']	= ['Users.status'=>'A'];
		$alphabet_options['fields']		= ['Users.id','Users.name'];
		$alphabet_options['order'] 		= ['Users.name'=>'ASC'];
		$all_characters = $UsersTable->find('all', $alphabet_options)->toArray();
		$alphabets_only=array();
		if(!empty($all_characters)){
			foreach($all_characters as $characters){
				$key = strtolower(substr($characters['name'],0,1));
				$alphabets_only[$key][] = $characters;
			}
		}		
		$element = '';
		$options['contain']		= ['QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['QuestionAnswer.id','QuestionAnswer.question_id','QuestionAnswer.user_id','QuestionAnswer.status']],'Careereducations'=>['fields'=>['id','user_id','history_type','edu_degree','edu_organization','career_position','career_company']],'Questions'=>['conditions'=>['status'=>'A','user_type'=>'U'],'fields'=>['id','user_id']]];		
		if($this->request->is('get')) {
			if(empty($this->request->query)){
				$options['conditions']	= ['Users.status'=>'A'];
			}else{
				$element = isset($this->request->query['search'])?strtoupper($this->request->query['search']):'';
				$name 	= isset($this->request->query['name'])?$this->request->query['name']:'';
				if($element != ''){
					$options['conditions']	= ['Users.status'=>'A', 'Users.name LIKE'=>$element.'%'];
				}
				else if($name != ''){
					$options['conditions']	= ['Users.status'=>'A', 'Users.name LIKE'=>'%'.$name.'%'];
				}
				else{
					$options['conditions']	= ['Users.status'=>'A'];
				}
			}
		}		
		$options['fields']		= ['Users.id','Users.name','Users.profile_pic','Users.location','Users.full_name','Users.type'];
		$options['order']		= ['Users.name'=>'ASC'];
		$options['limit'] 		= $this->limitUsers;
		$all_users = $this->paginate($UsersTable, $options)->toArray();
		$AdvertisementsTable = TableRegistry::get('Advertisement');
		$advertise = $AdvertisementsTable->find('all',['conditions'=>['page_name'=>'allUsers','status'=>'A'],'fields'=>['id','link','image'],'order'=>['id desc']])->first();
		$this->set(compact('all_users','alphabets_only','element','advertise'));
    }
	
	//All users listing -> Pagination page
	public function search(){
        if($this->request->is('post')){
			$this->visitorlogs('Users','search','More Users',NULL,NULL);	//Log details insertion
			
			$UsersTable = TableRegistry::get('Users');
			$options['contain']		= ['QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['QuestionAnswer.id','QuestionAnswer.question_id','QuestionAnswer.user_id','QuestionAnswer.status']],'Careereducations'=>['fields'=>['id','user_id','history_type','edu_degree','edu_organization','career_position','career_company']],'Questions'=>['conditions'=>['status'=>'A','user_type'=>'U'],'fields'=>['id','user_id']]];
			if(empty($this->request->query)){
				$options['conditions']	= ['Users.status'=>'A'];
			}else{
				$element= isset($this->request->query['search'])?strtoupper($this->request->query['search']):'';
				$name 	= isset($this->request->query['name'])?$this->request->query['name']:'';
				if($element != ''){
					$options['conditions']	= ['Users.status'=>'A', 'Users.name LIKE'=>$element.'%'];
				}
				else if($name != ''){
					$options['conditions']	= ['Users.status'=>'A', 'Users.name LIKE'=>'%'.$name.'%'];
				}
				else{
					$options['conditions']	= ['Users.status'=>'A'];
				}
			}			
			$options['fields']		= ['Users.id','Users.name','Users.profile_pic','Users.location','Users.full_name','Users.type'];
			$options['order']		= ['Users.name'=>'ASC'];
			$options['limit'] 		= $this->limitUsers;
			$all_users = $this->paginate($UsersTable, $options)->toArray();
			//pr($all_users); die;
			$this->set(compact('all_users'));
        }
    }
	
	//Signup page
    public function signup(){
		//$this->visitorlogs('Users','signup');
		$title = 'Sign Up';
		if($this->request->is('post')){	//signup form submit
			if($this->request->data['email'] != ''){
				$this->request->data['type'] = 'N';
				$this->request->data['signup_ip'] = $this->getUserIP();
				$this->request->data['signup_string'] = $this->generateRandomString(3).time().$this->generateRandomString(3);
				if(array_key_exists('is_commercialparty',$this->request->data)){
					$this->request->data['is_commercialparty']  			= 1;
					$this->request->data['commercialparty_checked_time']	= date('Y-m-d H:i:s');
					$this->request->data['commercialparty_unchecked_time']	= '';
					
					$insert_into_term['is_commercialparty']  				= 1;
					$insert_into_term['commercialparty_checked_time']		= date('Y-m-d H:i:s');
					$insert_into_term['commercialparty_unchecked_time']		= '';					
				}else{
					$this->request->data['is_commercialparty']  			= 0;
					$this->request->data['commercialparty_checked_time']	= '';
					$this->request->data['commercialparty_unchecked_time']	= date('Y-m-d H:i:s');
					
					$insert_into_term['is_commercialparty']  				= 0;
					$insert_into_term['commercialparty_checked_time']		= '';
					$insert_into_term['commercialparty_unchecked_time']		= date('Y-m-d H:i:s');
				}
				if(array_key_exists('personal_data',$this->request->data)){
					$this->request->data['personal_data']  					= 'Y';
					$this->request->data['personaldata_checked_time']		= date('Y-m-d H:i:s');
					$this->request->data['personaldata_unchecked_time']		= '';
					
					$insert_into_term['personal_data']  					= 'Y';
					$insert_into_term['personaldata_checked_time']			= date('Y-m-d H:i:s');
					$insert_into_term['personaldata_unchecked_time']		= '';
				}else{
					$this->request->data['personal_data']  					= 'N';
					$this->request->data['personaldata_checked_time']		= '';
					$this->request->data['personaldata_unchecked_time']		= date('Y-m-d H:i:s');
					
					$insert_into_term['personal_data']  					= 'N';
					$insert_into_term['personaldata_checked_time']			= '';
					$insert_into_term['personaldata_unchecked_time']		= date('Y-m-d H:i:s');
				}
				$UsersTable = TableRegistry::get('Users');
				$newUsers = $UsersTable->newEntity();
				$data_to_insert = $UsersTable->patchEntity($newUsers, $this->request->data);
				if($savedData = $UsersTable->save($data_to_insert)){
					$insert_user_id = $savedData->id;
					$this->visitorlogs('Users','signup','Signup',NULL,NULL,$insert_user_id);	//Log details insertion
					$url = Router::url('/', true).'users/verify/'.$this->request->data['signup_string'].'/'.base64_encode(time());
					
					/*insert into terms*/
					$insert_into_term['user_id']							= $insert_user_id;
					$TermTable 		= TableRegistry::get('Term');
					$newterm 		= $TermTable->newEntity();
					$data_insert 	= $newterm->patchEntity($newterm, $insert_into_term);
					$TermTable->save($data_insert);
					
					$settings = $this->getSiteSettings();
					if($this->Email->userRegister($this->request->data['email'], $url, $this->request->data, $settings)){
						echo json_encode(['register'=>'success', 'userid'=>$insert_user_id]);
						exit();
					}
				}else{
					echo json_encode(['register'=>'failed']);
					exit();
				}
			}
    	}
		$this->set(compact('title'));
    }
	//See Setting Now
	public function seeSettingNowUpdate(){
		if($this->request->is('post')){
			$this->request->data['see_setting_page'] = 0;
			$UsersTable = TableRegistry::get('Users');
			$user = $UsersTable->get($this->Auth->user('id'));			
			$updated_data = $UsersTable->patchEntity($user, $this->request->data);
			$UsersTable->save($updated_data);
			echo 'success';
			exit();
    	}
	}
	
	//Signup page
    public function signupSetting(){
		$title = 'Setting';
		if($this->request->is('post')){	//setting form submit
			if($this->request->data['user_id'] != ''){
				if(array_key_exists('is_setting',$this->request->data)){
					$this->request->data['is_setting'] = 1;
				}
				$UsersTable = TableRegistry::get('Users');
				$user = $UsersTable->get($this->request->data['user_id']);			
				$updated_data = $UsersTable->patchEntity($user, $this->request->data);
				$this->visitorlogs('Users','signupSetting','Setting in Signup',NULL,NULL,$this->request->data['user_id']);	//Log details insertion
				if($savedData = $UsersTable->save($updated_data)) {
					echo json_encode(['register'=>'success']);
					exit();
				}else{
					echo json_encode(['register'=>'failed']);
					exit();
				}
			}else{
				echo json_encode(['register'=>'failed']);
				exit();
			}
    	}
		$this->set(compact('title'));
    }
	//emailExist function is for checking user email if it already exist or not
    public function emailExist(){
    	if($this->request->is('post')){
    		$jsonData = $this->request->input('json_decode');
    		if($this->isDataExist('Users', 'email', $jsonData->email)){
	    		echo json_encode(['email'=>'exist']);
	    		die;
	    	}else{
	    		echo json_encode(['email'=>'available']);
	    		die;
	    	}
    	}
    }
	
	//verify email verification after signup
    public function verify($signupString=NULL, $signupTime=NULL){
		$this->viewBuilder()->layout = false;
        $this->render(false);
    	$session = $this->request->session();
		if(!empty($this->Auth->user())){
			return $this->redirect(Router::url(array('controller'=>'Users','action'=>'my-account'), true));
		}
        $signupTime = base64_decode($signupTime);
        $user = TableRegistry::get('Users');
        if ($this->isDataExist('Users', 'signup_string', $signupString)) {
            $duration = time()-$signupTime;
			if($duration > SIGNUP_VERIFY_LINK_TIME){
                $this->Flash->error(__('URL has expired, please contact with the site Owner.'));
                $session->write('from_verify', 'expired');
                return $this->redirect(Router::url(array('controller'=>'Users','action'=>'signup'), true));
            }else{
				$this->visitorlogs('Users','verify','User Account Verification',NULL,NULL);		//Log details insertion
                $query = $user->query();
                $query->update()
                    ->set(['status' => 'A', 'is_verified'=>'1', 'signup_string'=>''])
                    ->where(['signup_string' => $signupString])
                    ->execute();
                $this->Flash->success(__('Your account has been successfully verified, you can login now.'));
                $session->write('from_verify', 'success');
                return $this->redirect(Router::url(array('controller'=>'Users','action'=>'login'), true));
            }
        }else{
			$this->Flash->error(__('Invalid URL or account already activated.'));
            $session->write('from_verify', 'invalid_url');
            return $this->redirect(Router::url(array('controller'=>'Users','action'=>'login'), true));
        }
    }
	
	//Login page
    public function login(){
		//$this->visitorlogs('Users','login');	//Log details insertion
		$title = 'Login';
		$session = $this->request->session();
		$UsersTable = TableRegistry::get('Users');
		if(!empty($this->Auth->user())){
			return $this->redirect(Router::url(array('controller'=>'Users','action'=>'my-account'), true));
		}
		if($this->request->is('post')) {
			$user_data = $this->Users->find('all', ['conditions'=>['Users.email'=>$this->request->data['email']]])->first();
			if(empty($user_data)){
				echo json_encode(['login'=>'user_not_exist']);
				exit();
			}else{
				$userdata = $this->Users->find('all', ['conditions'=>['Users.email'=>$this->request->data['email'], 'Users.status'=>'A']])->first();
				if(empty($userdata)){
					echo json_encode(['login'=>'user_not_activated']);
					exit();
				}else{
					if(empty($this->Auth->user())){
						$user = $this->Auth->identify();
						if($user){
							if(array_key_exists('remember_me', $this->request->data) && $this->request->data['remember_me']==1){
								$session->write('Users.remember_me', $user['id']);
							}else{
								$session->write('Users.remember_me', '');
							}
							$this->visitorlogs('Users','login','Login',NULL,NULL,$user['id']);	//Log details insertion
							if($user['type']=='N'){
								$this->Auth->setUser($user);
								$query = $UsersTable->query();
								$query->update()
								  ->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
								  ->where(['email' => $this->request->data['email']])
								  ->execute();
								  
								$session->write('reset_password','success');
								echo json_encode(['login'=>'success']);
								
								/*if($user['is_setting']==0){
									$session->write('reset_password','success');
									echo json_encode(['login'=>'success']);
								}else{
									$query = $UsersTable->query();
									$query->update()
									  ->set(['is_setting'=>0])
									  ->where(['email' => $this->request->data['email']])
									  ->execute();
									//$session->write('reset_password','success');
									echo json_encode(['login'=>'success_to_setting']);
								}*/
								
								exit();
							}else{
								$session->write('Users.login_condition','failed');
								echo json_encode(['login'=>'failed']);
								exit();
							}
						}else{
							$session->write('Users.login_condition','not_logged_in');
							echo json_encode(['login'=>'not_logged_in']);
							exit();
						}
					}else{
						$session->write('Users.login_condition','already_logged_in');
						echo json_encode(['login'=>'already_logged_in']);
						exit();
					}
				}
			}            
        }
		$this->set(compact('title'));
    }
	//logout function for logout
    public function logout(){
        $session = $this->request->session();
		$UsersTable = TableRegistry::get('Users');
		$query = $UsersTable->query();
		$this->visitorlogs('Users','logout','Logout',NULL,NULL,$this->Auth->user('id'));	//Log details insertion
		$query->update()
			->set(['loggedin_status'=>0])
			->where(['id'=>$this->Auth->user('id')])
			->execute();
        $this->Auth->logout();
        $session->write('Users.logout', 1);
		$session->delete('Users.login_condition');
		return $this->redirect(Router::url('/', true));
    }
	
	//Ajax-Login for Ask Question Page page
    public function ajaxLogin(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		$title = 'Login';
		$session = $this->request->session();
		$UsersTable = TableRegistry::get('Users');
		if(!empty($this->Auth->user())){
			return $this->redirect(Router::url(array('controller'=>'Users','action'=>'my-account'), true));
		}
		if($this->request->is('post')) {
			$user_data = $this->Users->find('all', ['conditions'=>['Users.email'=>$this->request->data['email']]])->first();
			if(empty($user_data)){
				echo json_encode(['login'=>'user_not_exist']);
				exit();
			}else{
				$userdata = $this->Users->find('all', ['conditions'=>['Users.email'=>$this->request->data['email'], 'Users.status'=>'A']])->first();
				if(empty($userdata)){
					echo json_encode(['login'=>'user_not_activated']);
					exit();
				}else{
					if(empty($this->Auth->user())){
						$user = $this->Auth->identify();
						if($user){
							if(array_key_exists('remember_me', $this->request->data) && $this->request->data['remember_me']==1){
								$session->write('Users.remember_me', $user['id']);
							}else{
								$session->write('Users.remember_me', '');
							}
							if($user['type']=='N'){
								$this->Auth->setUser($user);
								$query = $UsersTable->query();
								$query->update()
								  ->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
								  ->where(['email' => $this->request->data['email']])
								  ->execute();
								if($user['is_setting']==0){
									echo json_encode(['login'=>'success']);
								}else{
									$query = $UsersTable->query();
									$query->update()
									  ->set(['is_setting'=>0])
									  ->where(['email' => $this->request->data['email']])
									  ->execute();
									//$session->write('reset_password','success');
									echo json_encode(['login'=>'success_to_setting']);
								}
								exit();
							}else{
								//$session->write('Users.login_condition','failed');
								echo json_encode(['login'=>'failed']);
								exit();
							}
						}else{
							//$session->write('Users.login_condition','not_logged_in');
							echo json_encode(['login'=>'not_logged_in']);
							exit();
						}
					}else{
						//$session->write('Users.login_condition','already_logged_in');
						echo json_encode(['login'=>'already_logged_in']);
						exit();
					}
				}
			}            
        }
		$this->set(compact('title'));
    }
	
	//myAccount function for user dashboard page
	public function myAccount(){
		$title = 'My Account';
		$session = $this->request->session();
		$user_data = $session->read('Auth.Users');
		$UsersTable = TableRegistry::get('Users');		
		$option['contain']	  = ['Careereducations'];
		$option['conditions'] = ['Users.id'=>$user_data['id'], 'Users.status'=>'A'];
		$option['fields'] 	  = ['id','name','profile_pic','location','title','email','full_name','birthday','about_me','type','facebook_link','twitter_link','gplus_link','linkedin_link','see_setting_page','status'];
		$user_related_details = $UsersTable->find('all', $option)->first();
		$this->visitorlogs('Users','myAccount','My Account',NULL,NULL,$user_data['id']);	//Log details insertion
		//pr($user_related_details); die;
		$this->set(compact('user_data','user_related_details','title'));
	}
	
	//editProfile function for user edit profile page
	public function editProfile(){
		$title = 'Edit Profile';
		$session = $this->request->session();
		$user_data = $session->read('Auth.Users');
		$UsersTable = TableRegistry::get('Users');		
		$this->visitorlogs('Users','editProfile','Edit Profile',NULL,NULL,$user_data['id']);	//Log details insertion
		$option['contain']	  = ['Careereducations'];
		$option['conditions'] = ['Users.id'=>$user_data['id']];
		$user_related_details = $UsersTable->find('all', $option)->first();
		$this->request->data = $user_related_details;
		
		$education_details = array(); $career_details = array();
		if(!empty($user_related_details['careereducations'])){
			foreach($user_related_details['careereducations'] as $val){
				if($val['history_type'] == 'E'){
					$education_details[$val['id']]['edu_degree'] 		= $val['edu_degree'];
					$education_details[$val['id']]['edu_organization'] 	= $val['edu_organization'];
					$education_details[$val['id']]['edu_from'] 			= $val['edu_from'];
					$education_details[$val['id']]['edu_to'] 			= $val['edu_to'];
				}
				else if($val['history_type'] == 'C'){
					$career_details[$val['id']]['career_position']	= $val['career_position'];
					$career_details[$val['id']]['career_company'] 	= $val['career_company'];
					$career_details[$val['id']]['career_from'] 	 	= $val['career_from'];
					$career_details[$val['id']]['career_to'] 	 	= $val['career_to'];
				}
			}
		}		
		$this->set(compact('user_data','user_related_details','education_details','career_details','title'));
	}
	//update profile
	public function updateProfile(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is('post')) {
			$session = $this->request->session();
			$user_data = $session->read('Auth.Users');
			$UsersTable = TableRegistry::get('Users');
			$user = $UsersTable->get($user_data['id'], ['contain'=>['Careereducations']]);
			if( $this->request->data['birthday'] != '' ){
				$this->request->data['birthday'] = date('Y-m-d', strtotime($this->request->data['birthday']));
			}else{
				$this->request->data['birthday'] = '';
			}			
			$updated_data = $UsersTable->patchEntity($user, $this->request->data);
            if($savedData = $UsersTable->save($updated_data)) {
				$get_last_insert_id = $savedData->id;
				$this->visitorlogs('Users','updateProfile','Update Profile',NULL,NULL,$user_data['id']);	//Log details insertion
				$CareereducationsTable = TableRegistry::get('Careereducations');
				//education section start//
				if( $this->request->data['education_chk'] == 'education' ){	//checking education section is checked (then update/insert)
					if( array_key_exists('education', $this->request->data) && (!empty($this->request->data['education'])) ){							
						foreach( $this->request->data['education'] as $key_edu_data => $val_edu_data ){
							if($val_edu_data['id'] != ''){
								$education_data = $CareereducationsTable->find('all', ['conditions'=>array('Careereducations.id'=>$val_edu_data['id'], 'Careereducations.user_id'=>$get_last_insert_id, 'Careereducations.history_type'=>'E'),'fields' => []])->first();
								$edu_data['Careereducations']['user_id'] 			= $get_last_insert_id;
								$edu_data['Careereducations']['history_type'] 		= 'E';
								$edu_data['Careereducations']['edu_degree'] 		= $val_edu_data['edu_degree'];
								$edu_data['Careereducations']['edu_organization'] 	= $val_edu_data['edu_organization'];
								$edu_data['Careereducations']['edu_from'] 			= date('Y-m-d', strtotime($val_edu_data['edu_from']));
								$edu_data['Careereducations']['edu_to'] 			= date('Y-m-d', strtotime($val_edu_data['edu_to']));
								$edu_data['Careereducations']['modified'] 			= date('Y-m-d H:i:s');
								$edu_updated_data = $CareereducationsTable->patchEntity($education_data, $edu_data);
								$CareereducationsTable->save($edu_updated_data);
								unset($edu_data); unset($edu_updated_data);
							}else{
								$edu_data['Careereducations']['user_id'] 			= $get_last_insert_id;
								$edu_data['Careereducations']['history_type'] 		= 'E';
								$edu_data['Careereducations']['edu_degree'] 		= $val_edu_data['edu_degree'];
								$edu_data['Careereducations']['edu_organization'] 	= $val_edu_data['edu_organization'];
								$edu_data['Careereducations']['edu_from'] 			= date('Y-m-d', strtotime($val_edu_data['edu_from']));
								$edu_data['Careereducations']['edu_to'] 			= date('Y-m-d', strtotime($val_edu_data['edu_to']));
								$edu_data['Careereducations']['modified'] 			= date('Y-m-d H:i:s');
								$CareereducationsNewEntity = $CareereducationsTable->newEntity();
								$edu_inserted_data = $CareereducationsTable->patchEntity($CareereducationsNewEntity, $edu_data);
								$CareereducationsTable->save($edu_inserted_data);
								unset($edu_data); unset($edu_inserted_data);
							}						
						}
					}
				}else{	//if education not checked the delete existing records if available
					$delete_education_data = $CareereducationsTable->find('list', ['conditions'=>array('Careereducations.user_id'=>$get_last_insert_id, 'Careereducations.history_type'=>'E'),'fields' => ['Careereducations.id']])->toArray();
					if( count($delete_education_data) > 0){
						$CareereducationsTable->deleteAll(['id IN' => $delete_education_data]);
					}
				}
				//education section end//
				//career section start//
				if( $this->request->data['career_chk'] == 'career' ){	//checking career section is checked (then update/insert)
					if( array_key_exists('career', $this->request->data) && (!empty($this->request->data['career'])) ){					
						foreach( $this->request->data['career'] as $key_career_data => $val_career_data ){
							if($val_career_data['id'] != ''){
								$get_career_data = $CareereducationsTable->find('all', ['conditions'=>array('Careereducations.id'=>$val_career_data['id'], 'Careereducations.user_id'=>$get_last_insert_id, 'Careereducations.history_type'=>'C'),'fields' => []])->first();
								$career_data['Careereducations']['user_id'] 		= $get_last_insert_id;
								$career_data['Careereducations']['history_type'] 	= 'C';
								$career_data['Careereducations']['career_position']	= $val_career_data['career_position'];
								$career_data['Careereducations']['career_company'] 	= $val_career_data['career_company'];
								$career_data['Careereducations']['career_from'] 	= date('Y-m-d', strtotime($val_career_data['career_from']));
								$career_data['Careereducations']['career_to'] 		= date('Y-m-d', strtotime($val_career_data['career_to']));
								$career_data['Careereducations']['modified'] 		= date('Y-m-d H:i:s');
								$career_updated_data = $CareereducationsTable->patchEntity($get_career_data, $career_data);
								$CareereducationsTable->save($career_updated_data);
								unset($career_data); unset($career_updated_data);
							}else{
								$career_data['Careereducations']['user_id'] 		= $get_last_insert_id;
								$career_data['Careereducations']['history_type'] 	= 'C';
								$career_data['Careereducations']['career_position']	= $val_career_data['career_position'];
								$career_data['Careereducations']['career_company'] 	= $val_career_data['career_company'];
								$career_data['Careereducations']['career_from'] 	= date('Y-m-d', strtotime($val_career_data['career_from']));
								$career_data['Careereducations']['career_to'] 		= date('Y-m-d', strtotime($val_career_data['career_to']));
								$career_data['Careereducations']['modified'] 		= date('Y-m-d H:i:s');
								$CareersNewEntity = $CareereducationsTable->newEntity();
								$career_inserted_data = $CareereducationsTable->patchEntity($CareersNewEntity, $career_data);
								$CareereducationsTable->save($career_inserted_data);
								unset($career_data); unset($career_inserted_data);
							}
						}						
					}
				}else{
					$delete_career_data = $CareereducationsTable->find('list', ['conditions'=>array('Careereducations.user_id'=>$get_last_insert_id, 'Careereducations.history_type'=>'C'),'fields' => ['Careereducations.id']])->toArray();
					if( count($delete_career_data) > 0){
						$CareereducationsTable->deleteAll(['id IN' => $delete_career_data]);
					}
				}
				//career section end//
				$this->Flash->success(__('Your profile has been successfully updated.'));
               echo json_encode(['edit_profile'=>'success']);
            } else {
               echo json_encode(['edit_profile'=>'error']);
            }
		}
	}
	//delete career-education data
	public function ajaxDeleteCareereducation(){
		$this->viewBuilder()->layout(false);
		$this->render(false);
		$user_id 			= isset($this->request->data['user_id'])?base64_decode($this->request->data['user_id']):'';
		$careereducation_id = isset($this->request->data['careereducation_id'])?base64_decode($this->request->data['careereducation_id']):'';
		$type 				= isset($this->request->data['careereducation_type'])?base64_decode($this->request->data['careereducation_type']):'';
		if($user_id == NULL || $careereducation_id == NULL || $type == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$this->request->allowMethod(['post', 'delete']);
		if($user_id != '' || $careereducation_id != '' || $type != ''){
			$CareereducationsTable = TableRegistry::get('Careereducations');
			$data = $CareereducationsTable->find('all', ['conditions'=>array('Careereducations.id'=>$careereducation_id, 'Careereducations.user_id'=>$user_id, 'Careereducations.history_type'=>$type),'fields' => []])->first();
			$CareereducationsTable->delete($data);
			echo json_encode(array('type' => 'success'));						
		}
		exit();
    }
	
	//changePassword function is for user password change
	public function changePassword(){
		$title = 'Change Password';
		$UsersTable = TableRegistry::get('Users');
		$userdetails = $UsersTable->get($this->Auth->user('id'));
		if($userdetails['type']!='N'){
			return $this->redirect(Router::url(['action'=>'my-account'], true));
		}
		if($this->request->is(['patch', 'post', 'put'])){
			$this->visitorlogs('Users','changePassword','Change Password',NULL,NULL,$this->Auth->user('id'));	//Log details insertion
			$this->request->data['password'] = $this->request->data['new_password'];
			$password = $UsersTable->patchEntity($userdetails, $this->request->data, ['validate' => 'password']);
			if ($UsersTable->save($password)) {
                $this->Flash->success(__('Your password has been successfully updated.'));
                return $this->redirect(Router::url(['controller'=>'Users','action'=>'change-password'], true));
            } else {
                $this->Flash->error(__('Your password is not updated.'));
            }
        }
		$this->set(compact('userdetails','title'));
	}
	
	//forgotPassword for front-end user password reset
    public function forgotPassword(){
		//$this->visitorlogs('Users','forgotPassword','Forgot Password');
		$title = 'Forgot Password';
		if(!empty($this->Auth->user())){
			return $this->redirect(Router::url(array('controller'=>'Users','action'=>'my-account'), true));
		}
    	$user = TableRegistry::get('Users');
        $settings = $this->getSiteSettings();
        if($this->request->is('post')){
			if($this->isDataExist('Users', 'email', $this->request->data['email'])) {
                $user_data = $this->Users->find('all', ['conditions'=>['Users.email'=>$this->request->data['email'], 'Users.status'=>'A']])->first();
                if(empty($user_data)){
					echo json_encode(['status'=>'not_active']);
					exit();
                }else{
					$reset_password_str = $this->generateRandomString(3).time().$this->generateRandomString(3);
					$query = $user->query();
					$query->update()
                      ->set(['forget_password_string' => $reset_password_str])
                      ->where(['email' => $this->request->data['email']])
                      ->execute();
					$this->visitorlogs('Users','forgotPassword','Forgot Password',NULL,NULL,$user_data->id);	//Log details insertion
					$url = Router::url('/', true).'users/reset-password/'.$reset_password_str.'/'.base64_encode(time());
					if($this->Email->resetPassword($this->request->data['email'],$user_data->name, $url, $settings)){
						echo json_encode(['status'=>'success']);
						exit();
					}
                }
            }else{
                echo json_encode(['status'=>'user_not_exist']);
				exit();
            }
        }
		$this->set(compact('title'));
    }
	
	//resetPassword function to set new password after forgot password
    public function resetPassword($forget_password_string=NULL, $reset_time=NULL){
		$title = 'Reset Password';
		$session  = $this->request->session();
		if(!empty($this->Auth->user())){
			return $this->redirect(Router::url(array('controller'=>'Users','action'=>'my-account'), true));
		}
		$user = TableRegistry::get('Users');
		if($forget_password_string==NULL || $reset_time==NULL){
			$this->Flash->error(__('Invalid URL or you have already used, please try again.'));
			$session->write('verify', 'invalid_url');
			return $this->redirect(Router::url(array('controller'=>'Users','action'=>'forgot-password'), true));
		}else if(!empty($this->Auth->user())){
			return $this->redirect(Router::url(array('controller'=>'Users','action'=>'my-account'), true));
		}		
		$userdata = $user->find('all', ['conditions'=>array('forget_password_string'=>$forget_password_string)])->first();
		if(empty($userdata)){
			$this->Flash->error(__('Invalid URL or you have already reset your password.'));
		}else{
			$reset_time = base64_decode($reset_time);
			$duration = time()-$reset_time;
			if(!empty($userdata) && $duration <= LINK_TIME){
				if($this->request->is(['patch', 'post', 'put'])) {
					$this->request->data['forget_password_string'] = '';
					$update_data = $user->patchEntity($userdata, $this->request->data);
					if($user->save($update_data)) {
						//$this->Auth->setUser($update_data);
						$session->write('reset_password','success');
						$this->Flash->success(__('Your password has been successfully updated.'));
						return $this->redirect(Router::url(array('controller'=>'Users','action'=>'login'), true));
					}
				}
			}else if($duration > LINK_TIME){
				$session->write('verify','invalid_url');
				$this->Flash->error(__('URL has expired, please try again.'));
				return $this->redirect(Router::url(array('controller'=>'Users','action'=>'forgot-password'), true));
			}else{
				$session->write('verify','invalid_url');
				$this->Flash->error(__('Invalid URL or you have already used, please try again.'));
				return $this->redirect(Router::url(array('controller'=>'Users','action'=>'forgot-password'), true));
			}
		}
		$this->set(compact('userdata','title'));
    }
	
	//uploadProfilePicture function is for updating user profile picture
    public function uploadProfilePicture(){
        $this->viewBuilder()->layout = false;
        $this->render(false);
		$UsersTable = TableRegistry::get('Users');
        $loggedIn_user = $this->Auth->user();
        if($this->request->is('post')){
        	$handle = new \Upload($this->request->data['image']);
	        $handle->file_new_name_body = $new_name = 'profile_'.time().rand(0,9);
	        $handle->Process('uploads/user_profile_pic');
	        $handle->image_resize         = true;
	        $handle->image_x              = 235;
	        $handle->image_y              = 199;
	        $handle->image_ratio_y        = false;
	        $handle->file_new_name_body = $new_name;
	        $handle->Process('uploads/user_profile_pic/thumb');
	        if($handle->processed){
				$insert_data['profile_pic'] = $data = $handle->file_dst_name;
				$existing_data = $UsersTable->get($loggedIn_user['id'], ['contain'=>[]]);
	            $data_to_insert = $UsersTable->patchEntity($existing_data, $insert_data);
	            if($UsersTable->save($data_to_insert)){
					$user = $UsersTable->get($loggedIn_user['id']);
					$this->Auth->setUser($user);
					$this->visitorlogs('Users','uploadProfilePicture','Update Profile Picture',NULL,NULL,$loggedIn_user['id']);	//Log details insertion
	            	echo json_encode(['data'=>$data]);
					exit();
	            }else{
	            	echo json_encode(['data'=>'failed']);
					exit();
	            }
	            $handle->clean();
	        }else{
	            $data = 'failed';
	        }
	        echo json_encode(['data'=>$data]);
			exit();
        }
    }
	
	//Account settings page
	public function accountSetting(){
		//$this->visitorlogs('Users','accountSetting');
		$title = 'Account Settings';
		$session = $this->request->session();
		$QuestionTable = TableRegistry::get('Questions');
		$question_categories = $this->getQuestionCategoriesSorted();	//mention in AppController
		
		$user_data = $session->read('Auth.Users');
		$UsersTable = TableRegistry::get('Users');
		$user_details = $UsersTable->find('all',['conditions'=>['id'=>$user_data['id']]], ['contain'=>['']])->first()->toArray();
		
		$UserAccountSettingTable = TableRegistry::get('UserAccountSetting');
		$account_settings = $UserAccountSettingTable->newEntity();
				
		$existing_account_settings = $UserAccountSettingTable->find('all',['conditions'=>['user_id'=>$user_data['id']]])->first();
		
		if($this->request->is('post')){	//form submit
			$account_settings = $UserAccountSettingTable->find('all',['conditions'=>['user_id'=>$user_data['id']]])->first();
			$this->visitorlogs('Users','accountSetting','Update Account Setting',NULL,NULL,$user_data['id']);	//Log details insertion
			if(empty($account_settings)){
				$this->request->data['user_id']	= $this->Auth->user('id');
				$settings = $UserAccountSettingTable->newEntity();
				$data_to_insert = $UserAccountSettingTable->patchEntity($settings, $this->request->data);
				if($savedData = $UserAccountSettingTable->save($data_to_insert)){
					$this->Flash->success(__('Account settings successfully updated.'));
					echo json_encode(['submit'=>'success']);
					exit();
				}else{
					$this->Flash->error(__('There was an unexpected error. Try again later or contact the Admin.'));
					echo json_encode(['submit'=>'failed']);
					exit();
				}
			}else{
				$this->request->data['user_id']	= $this->Auth->user('id');
				if(!array_key_exists('response_to_my_question_notification',$this->request->data)){
					$this->request->data['response_to_my_question_notification'] = 0;
				}
				if(!array_key_exists('news_notification',$this->request->data)){
					$this->request->data['news_notification'] = 0;
				}
				if(!array_key_exists('follow_twitter',$this->request->data)){
					$this->request->data['follow_twitter'] = 0;
				}
				if(!array_key_exists('posting_new_question_notification',$this->request->data)){
					$this->request->data['posting_new_question_notification'] = 0;
					$this->request->data['category_id'] = 0;
				}
				$data_to_update = $UserAccountSettingTable->patchEntity($existing_account_settings, $this->request->data);
				if($savedData = $UserAccountSettingTable->save($data_to_update)){
					$this->Flash->success(__('Account settings successfully updated.'));
					echo json_encode(['submit'=>'success']);
					exit();
				}else{
					$this->Flash->error(__('There was an unexpected error. Try again later or contact the Admin.'));
					echo json_encode(['submit'=>'failed']);
					exit();
				}
			}
		}
		$this->set(compact('question_categories','account_settings','user_details','existing_account_settings','title'));
	}
	
	//notifyEmailUpdate function is for notify email update
    public function notifyEmailUpdate(){
        $this->viewBuilder()->layout = false;
        $this->render(false);
		$UsersTable = TableRegistry::get('Users');
        $loggedIn_user = $this->Auth->user();
        if($this->request->is('post')){
			$updated_data['notification_email'] = $this->request->data['notification_email'];
			$existing_data = $UsersTable->get($loggedIn_user['id'], ['contain'=>[]]);
			$data_to_update = $UsersTable->patchEntity($existing_data, $updated_data);
			if($UsersTable->save($data_to_update)){
				$user = $UsersTable->get($loggedIn_user['id']);
				$this->Auth->setUser($user);
				echo json_encode(['update'=>'success']);
				exit();
			}else{
				echo json_encode(['data'=>'failed']);
				exit();
			}
        }
    }
	
	//change the header for question answer page
    public function ajaxChangeHeader(){
		$header_data = $this->Auth->user();
		$this->set(compact('header_data'));
    }
	
	//getUserPublicDetails for showing public information of user
    public function getUserPublicDetails(){
		$user_id = isset($this->request->data['user_id'])?$this->request->data['user_id']:'';
		if($user_id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		if($user_id != ''){
			$UsersTable = TableRegistry::get('Users');		
			$option['contain']	  = ['Careereducations'];
			$option['conditions'] = ['Users.id'=>$user_id];
			$option['fields'] 	  = ['id','name','profile_pic','location','title','email','full_name','birthday','about_me','type','facebook_link','twitter_link','gplus_link','linkedin_link','status'];
			$user_details 		  = $UsersTable->find('all', $option)->first();
			$this->set(compact('user_details'));
		}
    }
	
	//all submitted details for a particular user
	public function viewSubmissions(){
		$this->visitorlogs('Users','viewSubmissions');
		$user_id = $this->Auth->user('id');
		if ($user_id == NULL) {
            //throw new NotFoundException(__('Page not found'));
			return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
		$this->visitorlogs('Users','viewSubmissions','View Submissions',NULL,NULL,$this->Auth->user('id'));	//Log details insertion
		
		//submitted questions start//
		$QuestionTable = TableRegistry::get('Questions');
		$submitted_questions = $QuestionTable->find('all',['contain'=>['QuestionCategories'],'conditions'=>['user_id'=>$user_id],'fields'=>['id','category_id','user_id','name','is_featured','status','created','QuestionCategories.id','QuestionCategories.name'],'order'=>['Questions.id DESC']])->toArray();
		//submitted questions end//
		
		//submitted question comments//
		$QuestionCommentTable = TableRegistry::get('QuestionComment');
		$comment_details = $QuestionCommentTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['QuestionComment.user_id'=>$user_id],'fields'=>['QuestionComment.id','QuestionComment.question_id','QuestionComment.user_id','QuestionComment.comment','QuestionComment.status','QuestionComment.created'],'order'=>['QuestionComment.id DESC']])->toArray();
		//submitted question comments//
		
		//submitted question answers//
		$QuestionAnswersTable = TableRegistry::get('QuestionAnswer');
		$answer_details = $QuestionAnswersTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['QuestionAnswer.user_id'=>$user_id],'fields'=>['QuestionAnswer.id','QuestionAnswer.question_id','QuestionAnswer.user_id','QuestionAnswer.learning_path_recommendation','QuestionAnswer.status','QuestionAnswer.created'],'order'=>['QuestionAnswer.id DESC']])->toArray();
		//submitted question answers//
		
		//submitted answer comments//
		$AnswerCommentTable = TableRegistry::get('AnswerComment');			
		$answer_comment_details = $AnswerCommentTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['AnswerComment.user_id'=>$user_id],'fields'=>['AnswerComment.id','AnswerComment.question_id','AnswerComment.user_id','AnswerComment.comment','AnswerComment.status','AnswerComment.created'],'order'=>['AnswerComment.id DESC']])->toArray();
		//submitted answer comments//
		
		//submitted news comments//
		$NewsCommentTable = TableRegistry::get('NewsComment');			
		$news_comment_details = $NewsCommentTable->find('all',['contain'=>['News'=>['fields'=>['id','name']]],'conditions'=>['NewsComment.user_id'=>$user_id],'fields'=>['NewsComment.id','NewsComment.news_id','NewsComment.user_id','NewsComment.comment','NewsComment.status','NewsComment.created'],'order'=>['NewsComment.id DESC']])->toArray();
		//submitted news comments//
		
		$this->set(compact('submitted_questions','comment_details','answer_details','answer_comment_details','news_comment_details'));
		//pr($answer_comment_details); die;
	}
	
	
	/********************************** Social Login Section Start *********************************/
	
	//facebookLogin function is for login using facebook account for the customer
    public function facebookLogin(){
		$this->viewBuilder()->layout('ajax');
		$this->autoRender = false;
		
		$session = $this->request->session();
		$UsersTable = TableRegistry::get('Users');
		$user = $UsersTable->newEntity();
	  
		if($this->request->is('ajax')){
			$json = json_decode(file_get_contents("php://input"));
			//pr($json); die;
			$email 			= $json->email;
			$full_name 		= $json->name;
			$count_emailq 	= $UsersTable->find('all',array('conditions'=>array('Users.email'=>$json->email,'Users.facebook_id'=>'')));
			$is_exists_email= $count_emailq->count();
        
			if($is_exists_email==1){
				echo json_encode(array('type'=>'error','msg'=>'Email already registered with us.'));
				exit();
			}else{
				$session = $this->request->session();
				$is_exists_email = 0;
				$query = $this->Users->find('all', ['conditions' => ['Users.facebook_id' =>$json->id]]);
				$is_exists_email = $query->count();
				if($is_exists_email==0){
					$profile_pic	= 'http://graph.facebook.com/'.$json->id.'/picture?width=9999';					
					$img_url = file_get_contents($profile_pic);
					$file_name = 'profile_'.time().rand(0,9).'.jpg';
					file_put_contents('uploads/user_profile_pic/'.$file_name, $img_url);
					file_put_contents('uploads/user_profile_pic/thumb/'.$file_name, $img_url);
					
					$data['profile_pic'] 	= $file_name;
					if(strpos($json->name, ' ') !== false){
						$explode					= explode(' ',$json->name);
						$data['name']		= $explode[0];
						$data['full_name']	= $json->name;
					}else{
						$data['name']		= $json->name;
						$data['full_name']   = $json->name;
					}
					$data['type'] 			= 'F';
					$data['email']      	= $json->email;
					$data['facebook_id']    = $json->id;
					$data['is_verified'] 	= 1;
					$data['created']      	= date('Y-m-d H:i:s');
					$data['modified']       = date('Y-m-d H:i:s');
					$data['signup_ip']     	= $_SERVER['REMOTE_ADDR'];
					$data['status'] 		= 'A';
					$data_to_insert = $UsersTable->patchEntity($user,$data,array('validate' => false));			  
					if($UsersTable->save($data_to_insert)) {
						$data['id'] = $data_to_insert->id;
						$query->update()
							->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
							->where(['id' => $data['id']])
							->execute();
						$this->Auth->setUser($data);						
						$this->visitorlogs('Users','facebookLogin','Facebook Login',NULL,NULL,$data['id']);		//Log details insertion
						echo json_encode(array('type'=>'success'));
						exit();
					}else{
						echo json_encode(array('type'=>'error','msg'=> 'Please try again.'));
						exit();
					}
				}else{
					$query->update()
						->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
						->where(['facebook_id' => $json->id])
						->execute();					
					$profile_pic	= 'http://graph.facebook.com/'.$json->id.'/picture?width=9999';					
					$img_url = file_get_contents($profile_pic);
					$file_name = 'profile_'.time().rand(0,9).'.jpg';
					file_put_contents('uploads/user_profile_pic/'.$file_name, $img_url);
					file_put_contents('uploads/user_profile_pic/thumb/'.$file_name, $img_url);
					
					$update_data['profile_pic'] 	= $file_name;
					if(strpos($json->name, ' ') !== false){
						$explode					= explode(' ',$json->name);
						$update_data['name']		= $explode[0];
						$update_data['full_name']	= $json->name;
					}else{
						$update_data['name']		= $json->name;
						$update_data['full_name']   = $json->name;
					}
					$update_data['email']      		= $json->email;
					$update_data['facebook_id']    	= $json->id;
					$update_data['signup_ip']     	= $_SERVER['REMOTE_ADDR'];					
					
					$user_Detail = $UsersTable->find('all',array('conditions'=>array('Users.facebook_id'=>$json->id)))->first();
					$data_to_update = $UsersTable->patchEntity($user_Detail,$update_data);
					$UsersTable->save($data_to_update);
					
					$user_Detail = $UsersTable->find('all',array('conditions'=>array('Users.facebook_id'=>$json->id)))->first();
					$this->Auth->setUser($user_Detail);
					$this->visitorlogs('Users','facebookLogin','Facebook Login',NULL,NULL,$user_Detail['id']);		//Log details insertion
					echo json_encode(array('type'=>'success'));
					exit();
				}
			}
		}
    }
	
	//googleLogin function is for login using google account for the customer
	public function googleLogin() {
		$this->viewBuilder()->layout('ajax');
		$this->autoRender = false;
		$client = new \Google_Client();
		$client->setClientId(GOOGLE_OAUTH_CLIENT_ID);
		$client->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);
		$client->setRedirectUri(GOOGLE_OAUTH_REDIRECT_URI);
		
		$client->setScopes(array(
			"https://www.googleapis.com/auth/userinfo.profile",
			'https://www.googleapis.com/auth/userinfo.email'
		));
		$url = $client->createAuthUrl();
		$this->redirect($url);
	}
	public function gplusConfirmLogin(){
		$this->viewBuilder()->layout('ajax');
        $this->autoRender = false;
		
		$session = $this->request->session();		
        $client = new \Google_Client();
        $client->setClientId(GOOGLE_OAUTH_CLIENT_ID);
        $client->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_OAUTH_REDIRECT_URI);

        $client->setScopes(array(
            "https://www.googleapis.com/auth/userinfo.profile",
            'https://www.googleapis.com/auth/userinfo.email'
        ));
        $client->setApprovalPrompt('auto');

        if(isset($this->request->query['code'])){
            $client->authenticate($this->request->query['code']);
            $this->request->Session()->write('access_token', $client->getAccessToken());
            return $this->redirect(['controller' => 'Users', 'action' => 'gplus-confirm-login']);
        }
        if($this->request->Session()->check('access_token') && ($this->request->Session()->read('access_token'))){
            $client->setAccessToken($this->request->Session()->read('access_token'));
        }
        if($client->getAccessToken()){
            $this->request->Session()->write('access_token', $client->getAccessToken());
            $oauth2 = new \Google_Oauth2Service($client);
            $user = $oauth2->userinfo->get();
            try {
                if(!empty($user)) {
					$UsersTable = TableRegistry::get('Users');
					$count_emailq 	= $UsersTable->find('all',array('conditions'=>array('Users.email'=>$user['email'],'Users.googleplus_id'=>'')));
					$is_exists_email= $count_emailq->count();                    
					if(!empty($count_emailq) && $is_exists_email==1){
						$session->write('email_check','already_exist');
						$this->Flash->error(__("Email already registered with us."));
                        return $this->redirect(['action' => 'login']);
                        exit;
                    }else{
						$session = $this->request->session();
						$is_exists_fb_id = 0;
						$query = $this->Users->find('all', ['conditions' => ['Users.googleplus_id'=>$user['id']]]);
						$is_exists_fb_id = $query->count();
						if($is_exists_fb_id==0){
							$user_data = $this->Users->newEntity();
							$img_url = file_get_contents($user['picture']);
							$file_name = 'profile_'.time().rand(0,9).'.jpg';
							file_put_contents('uploads/user_profile_pic/'.$file_name, $img_url);
							file_put_contents('uploads/user_profile_pic/thumb/'.$file_name, $img_url);
							
							$data['profile_pic'] = $file_name;
							if(strpos($user['name'], ' ') != false){
								$explode			= explode(' ',$user['name']);
								$data['name']		= $explode[0];
								$data['full_name']  = $user['name'];
							}else{
								$data['name']		 = $user['name'];
								$data['full_name']   = $user['name'];
							}
							$data['is_verified'] = 1;
							$data['type'] 		 = 'G';
							$data['email']       = $user['email'];							
							$data['googleplus_id']= $user['id'];
							$data['gplus_link']  = $user['link'];
							$data['created']     = date('Y-m-d H:i:s');
							$data['modified']    = date('Y-m-d H:i:s');
							$data['signup_ip']   = $_SERVER['REMOTE_ADDR'];
							$data['status'] 	 = 'A';
							
							$data_to_insert = $UsersTable->patchEntity($user_data,$data,array('validate' => false));			  
							if($UsersTable->save($data_to_insert)) {
								$data['id'] = $data_to_insert->id;
								$query->update()
									->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
									->where(['id' => $data['id']])
									->execute();
								$this->Auth->setUser($data);
								$this->visitorlogs('Users','gplusConfirmLogin','Google Plus Login',NULL,NULL,$data['id']);	//Log details insertion
								//echo json_encode(array('type'=>'success'));
								return $this->redirect(['action' => 'my-account']);
								exit();
							}else{
								//echo json_encode(array('type'=>'error','msg'=> 'Please try again.'));
								$session->write('email_check','already_exist');
								$this->Flash->error(__("Please try again."));
								return $this->redirect(['action' => 'login']);
								exit();
							}
						}else{
							$query->update()
								->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
								->where(['googleplus_id' => $user['id']])
								->execute();
							$img_url = file_get_contents($user['picture']);
							$file_name = 'profile_'.time().rand(0,9).'.jpg';
							file_put_contents('uploads/user_profile_pic/'.$file_name, $img_url);
							file_put_contents('uploads/user_profile_pic/thumb/'.$file_name, $img_url);
							
							$update_data['profile_pic'] 	= $file_name;
							if(strpos($user['name'], ' ') !== false){
								$explode					= explode(' ',$user['name']);
								$update_data['name']		= $explode[0];
								$update_data['full_name']	= $user['name'];
							}else{
								$update_data['name']		= $user['name'];
								$update_data['full_name']   = $user['name'];
							}
							$update_data['email']       = $user['email'];
							$update_data['is_verified']	= 1;
							$update_data['googleplus_id']= $user['id'];
							$update_data['gplus_link']  = $user['link'];
							$update_data['signup_ip']   = $_SERVER['REMOTE_ADDR'];
							
							$user_Detail = $UsersTable->find('all',array('conditions'=>array('Users.googleplus_id'=>$user['id'])))->first();
							$data_to_update = $UsersTable->patchEntity($user_Detail, $update_data);
							$UsersTable->save($data_to_update);
							
							$user_Detail = $UsersTable->find('all',array('conditions'=>array('Users.googleplus_id'=>$user['id'])))->first();
							$this->Auth->setUser($user_Detail);
							$this->visitorlogs('Users','gplusConfirmLogin','Google Plus Login',NULL,NULL,$user_Detail['id']);	//Log details insertion
							//echo json_encode(array('type'=>'success'));							
							return $this->redirect(['action' => 'my-account']);
							exit();							
						}         
					}
                }
				else{
					$session->write('email_check','already_exist');
					$this->Flash->error('Google informations not found');
                    $this->redirect(['action' => 'login']);
                }
            }catch (\Exception $e) {
				$session->write('email_check','already_exist');
                $this->Flash->error('Google error');
                return $this->redirect(['action'=>'login']);
            }
        }
    }
	
	//twitterLogin function is for login using twitter account for the customer
	public function twitterLogin(){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;
        if(isset($_POST)){
			//Fresh authentication
            $connection = new \TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
            $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
			
			//Received token info from twitter
            $_SESSION['token'] 			= $request_token['oauth_token'];
            $_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
            
			//Any value other than 200 is failure, so continue only if http code is 200
            if($connection->http_code == '200'){
                //redirect user to twitter
                $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
                header('Location: ' . $twitter_url); 
            }else{
                die("error connecting to twitter! try again later!");
            }
		}	
	}
	public function twittercallback(){
		$this->viewBuilder()->layout('ajax');
		$this->autoRender = false;
		
		$session = $this->request->session();
		$UsersTable = TableRegistry::get('Users');
		$user = $UsersTable->newEntity();
		$connection = new \TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		if($connection->http_code == '200'){
			$params = array('include_email' => 'true');
			$user_data = $connection->get('account/verify_credentials',$params);
			try {
				if(!empty($user_data)) {
					$count_emailq 	= $UsersTable->find('all',array('conditions'=>array('Users.email'=>$user_data['email'],'Users.twitter_id'=>'')))->toArray();
					$is_exists_email= count($count_emailq);
					if(!empty($count_emailq) && $is_exists_email==1){
						$session->write('email_check','already_exist');
						$this->Flash->error(__("Email already registered with us."));
						return $this->redirect(['action' => 'login']);
						exit;
					}else{
						$session = $this->request->session();
						$is_exists_twitter_id = 0;
						$query = $this->Users->find('all', ['conditions' => ['Users.twitter_id' =>$user_data['id']]]);
						$is_exists_twitter_id = $query->count();
						if($is_exists_twitter_id==0){
							$userdata = $this->Users->newEntity();
							$new_profile_image = str_replace('_normal', '_400x400', $user_data['profile_image_url']);
							$img_url = file_get_contents($new_profile_image);
							$file_name = 'profile_'.time().rand(0,9).'.jpg';
							file_put_contents('uploads/user_profile_pic/'.$file_name, $img_url);
							file_put_contents('uploads/user_profile_pic/thumb/'.$file_name, $img_url);
							
							$data['profile_pic'] = $file_name;
							if(strpos($user_data['name'], ' ') != false){
								$explode			= explode(' ',$user_data['name']);
								$data['name']		= $explode[0];
								$data['full_name']  = $user_data['name'];
							}else{
								$data['name']		 = $user_data['name'];
								$data['full_name']   = $user_data['name'];
							}
							$data['is_verified'] = 1;
							$data['type'] 		 = 'T';
							$data['email']       = $user_data['email'];							
							$data['twitter_id']	 = $user_data['id'];
							$data['created']     = date('Y-m-d H:i:s');
							$data['modified']    = date('Y-m-d H:i:s');
							$data['signup_ip']   = $_SERVER['REMOTE_ADDR'];
							$data['status'] 	 = 'A';
							
							$data_to_insert = $UsersTable->patchEntity($userdata,$data,array('validate' => false));			  
							if($UsersTable->save($data_to_insert)) {
								$data['id'] = $data_to_insert->id;
								$query->update()
									->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
									->where(['id' => $data['id']])
									->execute();
								$this->Auth->setUser($data);
								$this->visitorlogs('Users','twittercallback','Twitter Login',NULL,NULL,$data['id']);	//Log details insertion
								//echo json_encode(array('type'=>'success'));
								return $this->redirect(['action'=>'my-account']);
								exit();
							}else{
								$session->write('email_check','already_exist');
								$this->Flash->error('Please try again.');
								return $this->redirect(['action' => 'login']);
								exit();
							}
						}else{
							$query->update()
								->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
								->where(['twitter_id' => $user_data['id']])
								->execute();
							$new_profile_image = str_replace('_normal', '_400x400', $user_data['profile_image_url']);
							$img_url = file_get_contents($new_profile_image);
							$file_name = 'profile_'.time().rand(0,9).'.jpg';
							file_put_contents('uploads/user_profile_pic/'.$file_name, $img_url);
							file_put_contents('uploads/user_profile_pic/thumb/'.$file_name, $img_url);
							
							$update_data['profile_pic'] 	= $file_name;
							if(strpos($user_data['name'], ' ') !== false){
								$explode					= explode(' ',$user_data['name']);
								$update_data['name']		= $explode[0];
								$update_data['full_name']	= $user_data['name'];
							}else{
								$update_data['name']		= $user_data['name'];
								$update_data['full_name']   = $user_data['name'];
							}
							$update_data['email']       = $user_data['email'];
							$update_data['is_verified']	= 1;
							$update_data['twitter_id']  = $user_data['id'];
							$update_data['signup_ip']   = $_SERVER['REMOTE_ADDR'];
							
							$user_Detail = $UsersTable->find('all',array('conditions'=>array('Users.twitter_id'=>$user_data['id'])))->first();
							$data_to_update = $UsersTable->patchEntity($user_Detail, $update_data);
							$UsersTable->save($data_to_update);
							
							$user_Detail = $UsersTable->find('all',array('conditions'=>array('Users.twitter_id'=>$user_data['id'])))->first();
							$this->Auth->setUser($user_Detail);
							$this->visitorlogs('Users','twittercallback','Twitter Login',NULL,NULL,$user_Detail['id']);	//Log details insertion
							$session->write('email_check','already_exist');
							return $this->redirect(['action' => 'my-account']);
							exit();							
						}         
					}
				}
				else{
					$session->write('email_check','already_exist');
					$this->Flash->error('Twitter informations not found.');
					$this->redirect(['action' => 'login']);
				}
			}catch (\Exception $e) {
				$session->write('email_check','already_exist');
				$this->Flash->error('Twitter error.');
				return $this->redirect(['action'=>'login']);
			}
			
		}else{
			$session->write('email_check','already_exist');
			$this->Flash->error('Twitter error.');
			return $this->redirect(['action'=>'login']);
		}   
		exit();
	}
	
	//linkedinLogin function is for login using linkedin account for the customer
	public function linkedinLogin(){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;
        if(isset($_POST)){
			$linkedin_url = 'https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id='.CLIENT_ID.'&redirect_uri='.LINKEDIN_OAUTH_CALLBACK.'&state=98765EeFWf45A53sdfKef4233&scope=r_basicprofile r_emailaddress';
			header('Location: ' . $linkedin_url);
		}
	}
	public function linkedinCallBack(){
		$this->viewBuilder()->layout('ajax');
		$this->autoRender = false;
		$session = $this->request->session();		
		if(isset($_GET['code'])){	// get code after authorization
			$url = 'https://www.linkedin.com/uas/oauth2/accessToken'; 
			$param = 'grant_type=authorization_code&code='.$_GET['code'].'&redirect_uri='.LINKEDIN_OAUTH_CALLBACK.'&client_id='.CLIENT_ID.'&client_secret='.CLIENT_SECRET;
			$return = json_decode($this->post_curl($url,$param),true); // Request for access token
			if(array_key_exists('error',$return) && isset($return['error'])){	// if invalid output error
				//$content = 'Some error occured<br><br>'.$return['error_description'].'<br><br>Please Try again.';
				$session->write('email_check','already_exist');
				$this->Flash->error('LinkedIn error.');
				return $this->redirect(['action'=>'login']);
			}
			else{	// token received successfully			
				$url = 'https://api.linkedin.com/v1/people/~:(id,firstName,lastName,pictureUrls::(original),headline,publicProfileUrl,location,industry,positions,email-address)?format=json&oauth2_access_token='.$return['access_token'];
				$user_data = json_decode($this->post_curl($url)); // Request user information on received token
				try{
					if(!empty($user_data)){
						$UsersTable = TableRegistry::get('Users');
						$user = $UsersTable->newEntity();
						$count_emailq 	= $UsersTable->find('all',array('conditions'=>array('Users.email'=>$user_data->emailAddress,'Users.linkedin_id'=>'')))->toArray();
						$is_exists_email= count($count_emailq);
						if(!empty($count_emailq) && $is_exists_email==1){
							$session->write('email_check','already_exist');
							$this->Flash->error(__("Email already registered with us."));
							return $this->redirect(['action' => 'login']);
							exit;
						}else{
							$is_exists_linkedin_id = 0;
							$query = $this->Users->find('all', ['conditions' => ['Users.linkedin_id' =>$user_data->id]]);
							$is_exists_linkedin_id = $query->count();
							if($is_exists_linkedin_id==0){
								$userdata = $this->Users->newEntity();
								if($user_data->pictureUrls->values[0] != ''){
									$img_url = file_get_contents($user_data->pictureUrls->values[0]);
									$file_name = 'profile_'.time().rand(0,9).'.jpg';
									file_put_contents('uploads/user_profile_pic/'.$file_name, $img_url);
									file_put_contents('uploads/user_profile_pic/thumb/'.$file_name, $img_url);									
									$data['profile_pic'] = $file_name;
								}else{
									$data['profile_pic'] = '';
								}
								$data['name']		= $user_data->firstName;
								$data['full_name']  = $user_data->firstName.' '.$user_data->lastName;
								$data['is_verified'] = 1;
								$data['type'] 		 = 'L';
								$data['email']       = $user_data->emailAddress;							
								$data['linkedin_id'] = $user_data->id;
								$data['location'] 	 = $user_data->location->name;
								$data['linkedin_link']= $user_data->publicProfileUrl;
								$data['created']     = date('Y-m-d H:i:s');
								$data['modified']    = date('Y-m-d H:i:s');
								$data['signup_ip']   = $_SERVER['REMOTE_ADDR'];
								$data['status'] 	 = 'A';
								
								$data_to_insert = $UsersTable->patchEntity($userdata,$data,array('validate' => false));			  
								if($UsersTable->save($data_to_insert)) {
									$data['id'] = $data_to_insert->id;
									$query->update()
										->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
										->where(['id' => $data['id']])
										->execute();
									$this->Auth->setUser($data);
									$this->visitorlogs('Users','linkedinCallBack','LinkedIn Login',NULL,NULL,$data['id']);	//Log details insertion
									//echo json_encode(array('type'=>'success'));
									return $this->redirect(['action'=>'my-account']);
									exit();
								}else{
									$session->write('email_check','already_exist');
									$this->Flash->error('Please try again.');
									return $this->redirect(['action' => 'login']);
									exit();
								}
							}else{
								$query->update()
									->set(['loggedin_status'=>1,'loggedin_time'=>date('Y-m-d H:i:s')])
									->where(['linkedin_id' => $user_data->id])
									->execute();
								if($user_data->pictureUrls->values[0] != ''){
									$img_url = file_get_contents($user_data->pictureUrls->values[0]);
									$file_name = 'profile_'.time().rand(0,9).'.jpg';
									file_put_contents('uploads/user_profile_pic/'.$file_name, $img_url);
									file_put_contents('uploads/user_profile_pic/thumb/'.$file_name, $img_url);									
									$update_data['profile_pic'] = $file_name;
								}else{
									$update_data['profile_pic'] = '';
								}
								$update_data['name']		= $user_data->firstName;
								$update_data['full_name']   = $user_data->firstName.' '.$user_data->lastName;
								$update_data['is_verified'] = 1;
								$update_data['type'] 		= 'L';
								$update_data['email']       = $user_data->emailAddress;							
								$update_data['linkedin_id'] = $user_data->id;
								$update_data['location'] 	= $user_data->location->name;
								$update_data['linkedin_link']= $user_data->publicProfileUrl;
								$update_data['signup_ip']   = $_SERVER['REMOTE_ADDR'];
								$update_data['status'] 	 	= 'A';
								
								$user_Detail = $UsersTable->find('all',array('conditions'=>array('Users.linkedin_id'=>$user_data->id)))->first();
								$data_to_update = $UsersTable->patchEntity($user_Detail, $update_data);
								$UsersTable->save($data_to_update);
								
								$user_Detail = $UsersTable->find('all',array('conditions'=>array('Users.linkedin_id'=>$user_data->id)))->first();
								$this->Auth->setUser($user_Detail);
								$this->visitorlogs('Users','linkedinCallBack','LinkedIn Login',NULL,NULL,$user_Detail['id']);	//Log details insertion
								$session->write('email_check','already_exist');
								return $this->redirect(['action' => 'my-account']);
								exit();
							}
						}
					}
					else{
						$session->write('email_check','already_exist');
						$this->Flash->error('LinkedIn informations not found.');
						$this->redirect(['action' => 'login']);
					}
				}catch (\Exception $e) {
					$session->write('email_check','already_exist');
					$this->Flash->error('LinkedIn error.');
					return $this->redirect(['action'=>'login']);
				}
			}
		}
		exit();
	}
	
	public function cookieConsent(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is('post')){
			$CookieConsentTable = TableRegistry::get('CookieConsent');
			$userip = $this->getUserIP(); //'192.168.1.127';
			
			$this->request->data['user_ipaddress'] 	= $userip;
			$this->request->data['cookie_type'] 	= $this->request->data['status'];
			$this->request->data['cookie_time'] 	= date('Y-m-d H:i:s');				
			$this->request->data['withdrawl_status']= 0;
			$this->request->data['created'] 		= date('Y-m-d H:i:s');
			$newEntity 		= $CookieConsentTable->newEntity();
			$insert_data 	= $CookieConsentTable->patchEntity($newEntity, $this->request->data);
			if($savedData 	= $CookieConsentTable->save($insert_data)){
				echo 'success';
				exit();
			}else{
				echo 'error';
				exit();
			}			
		}
	}
	
	public function post_curl($url,$param=""){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		if($param!="")
		curl_setopt($ch,CURLOPT_POSTFIELDS,$param);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
	
}