<?php
namespace Admin\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");
/**
 * Admin Controller
 *
 * @property \Admin\Model\Table\AdminTable $this->Admins
 */
class AdminDetailsController extends AppController
{

    public function beforeFilter(Event $event){
		$this->loadComponent('Admin.AdminEmail');
        parent::beforeFilter($event);
		
		$UsersTable = TableRegistry::get('Admin.Users');
		$query_inactive = $UsersTable->query();
		//if user inactive more than 30 minutes
		$query_inactive->update()
			->set(['loggedin_status'=>0])
			->where(['loggedin_status'=>1,'loggedin_time <'=> date('Y-m-d H:i:s', strtotime('-30 minutes'))])
			->execute();
		$this->Auth->allow(['index', 'login', 'reset', 'logout','resetNewPassword']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'login']);
    }

    /**
    * Login Method
    */
    public function login(){
		$session = $this->request->session();
		//checking if user is already logged in
        if (!empty($this->Auth->user())) {
            // if already logged in than it will redirect
			$session->write('AdminUser',$this->Auth->user());
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
        }
        // Set the layout.
        $this->viewBuilder()->layout('login');
        // checking if the form is submitted with post data
        if ($this->request->is('post')) {
            //checking if user is already logged in
            if (empty($this->Auth->user())) {
                // checking user exist in db
                $user = $this->Auth->identify();
                // if exist than it will return true
                if ($user) {
                    // the user data is inserted into the session and auth logs the user in
                    $this->Auth->setUser($user);
					$session->write('AdminUser',$this->Auth->user());
					// Informing mail to admin - that someone has logged in
                    //$this->loadComponent('Admin.AdminsEmail');
                    //$this->AdminsEmail->loginInform($this->request->data['email']);
                    // redirecting to the login redirect url. Url defined in AppController.php
                    return $this->redirect($this->Auth->redirectUrl());
                }
                // invalid credentials message
                $this->Flash->error(__('Invalid username or password, try again'));
            } else {
                // if already logged in than it will redirect
                return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
            }
        }
    }

    /**
    * Logout Method
    */
    public function logout(){
		$session = $this->request->session();
		$session->write('permissions','');
        // auth logout and redirect to the logout redirect. Url defined in AppController.php
        return $this->redirect($this->Auth->logout());
    }

    /**
    * Forget Password Method
    */
    public function reset(){
        // Set the layout.
        $this->viewBuilder()->layout('login');
        // checking if the form is submitted with post data
        if ($this->request->is('post')) {
			if($this->isDataExist('Admins', 'email', $this->request->data['email'])){
				$AdminsTable = TableRegistry::get('Admin.Admins');
				$admin_data = $AdminsTable->find('all', ['conditions'=>['Admins.email'=>$this->request->data['email'], 'Admins.forget_password_string'=>'','Admins.signup_string'=>'', 'Admins.status'=>'A'],'fields'=>['Admins.id','Admins.first_name','Admins.email']])->first();
				if(empty($admin_data)){
					$this->Flash->error(__('This account is inactive'));
					$this->redirect(['plugin'=>'Admin','controller'=>'AdminDetails','action'=>'reset']);
                }else{
					$reset_password_str = $this->generateRandomString(3).time().$this->generateRandomString(3);					
					$query = $AdminsTable->query();
					$query->update()
						  ->set(['forget_password_string' => $reset_password_str])
						  ->where(['email' => $this->request->data['email']])
						  ->execute();
					$url = Router::url('/admin/', true).'admin-details/reset-new-password/'.$reset_password_str.'/'.base64_encode(time());
					$settings = $this->getSiteSettings();
					$this->loadComponent('Admin.AdminEmail');
					if($this->AdminEmail->resetPassword($this->request->data['email'],$admin_data->first_name, $url, $settings)){
						$this->Flash->success(__('An email has been sent regarding password reset, please check'));
						$this->redirect(['plugin'=>'Admin','controller'=>'AdminDetails','action'=>'reset']);
					}
                }
			}else{
				$this->Flash->error(__('This email id does not associated with us.'));
				$this->redirect(['plugin'=>'Admin','controller'=>'AdminDetails','action'=>'reset']);
			}
        }
    }
	/**
     * [resetNewPassword function to set new password after forgot password]
     */
    public function resetNewPassword($forget_password_string=NULL, $reset_time=NULL){
		// Set the layout.
        $this->viewBuilder()->layout('login');
		$AdminsTable = TableRegistry::get('Admin.Admins');
		if($forget_password_string==NULL || $reset_time==NULL){
			return $this->redirect(Router::url('/admin/', true));
		}elseif(!empty($this->Auth->user())){
			return $this->redirect(Router::url('/admin/admin-details/dashboard', true));
		}
		$admin_data = $AdminsTable->find('all', ['conditions'=>array('forget_password_string'=>$forget_password_string)])->first();
		$reset_time = base64_decode($reset_time);
		$duration = time()-$reset_time;
		if(!empty($admin_data) && $duration<=LINK_TIME){
			if ($this->request->is(['patch', 'post', 'put'])) {
				//$this->request->data['forget_password_string'] = '';
				$password = $AdminsTable->patchEntity($admin_data, $this->request->data);
				if ($AdminsTable->save($password)){
					$admin_data->forget_password_string = NULL;
					$AdminsTable->save($admin_data);
					$this->Flash->success(__('Your password has been successfully updated.'));
					return $this->redirect(Router::url('/admin/admin-details/login/', true));
				} else {
					$this->Flash->error(__('Your password is not updated'));
				}
			}
        }elseif($duration>LINK_TIME){
			//$update_data = $AdminsTable->patchEntity($admin_data, $this->request->data);
			//if ($AdminsTable->save($update_data)) {
				//$admin_data->forget_password_string = NULL;
				//$AdminsTable->save($admin_data);
			$this->Flash->error(__('URL has expired, please try again'));
			return $this->redirect(Router::url('/admin/admin-details/reset/', true));
			//}
        }else{
        	$this->Flash->error(__('Invalid URL or you used it already. Please login correct with details'));
        	return $this->redirect(Router::url('/admin/', true));
        }
    }

    /**
    * Dashboard Method
    */
    public function dashboard(){
        $this->viewBuilder()->layout('dashboard');
		$session = $this->request->session();
		
		//total and inactive users
		$usersTable = TableRegistry::get('Admin.Users');
		$totalusers = $usersTable->find('all',['conditions'=>[],'fields'=>['id','name','email','full_name','profile_pic','status']])->toArray();
		$total_users = count($totalusers);
		$total_inactive_users = $usersTable->find('all',['conditions'=>['status'=>'I']])->count();
		
		//total and unapproved news comment
		$newsCommentTable = TableRegistry::get('Admin.NewsComments');
		$total_news_comments = $newsCommentTable->find('all',['conditions'=>[]])->count();
		$total_inactive_news_comments = $newsCommentTable->find('all',['conditions'=>['status'=>0]])->count();
		
		//total and inactive question
		$questionsTable = TableRegistry::get('Admin.Questions');
		$totalquestions = $questionsTable->find('all',['conditions'=>[],'fields'=>['id','name','status','user_type','created'],'order'=>['created'=>'ASC']])->toArray();
		$total_questions = count($totalquestions);
		$total_inactive_questions = $questionsTable->find('all',['conditions'=>['status'=>'I']])->count();
		
		//total and unapproved question answers
		$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
		$totalquestionanswer = $QuestionAnswersTable->find('all',['conditions'=>[],'fields'=>['id','status','created']])->toArray();
		$total_question_answer = count($totalquestionanswer);
		$total_inactive_question_answer = $QuestionAnswersTable->find('all',['conditions'=>['status'=>'I']])->count();
		
		//total and unapproved question comments
		$QuestionCommentsTable = TableRegistry::get('Admin.QuestionComments');
		$total_question_comments = $QuestionCommentsTable->find('all',['conditions'=>[],'fields'=>['id','status','created']])->toArray();
				
		//Question Posted Monthly barchart 
		$all_question_details = array(); $question_by_admin = 0; $question_by_user = 0; $question_by_facebookuser = 0; $question_by_gplususer = 0; $question_by_twitteruser = 0; $question_by_linkedinuser = 0;
		if(!empty($totalquestions)){
			foreach($totalquestions as $question){
				if($question->user_type=='A'){$question_by_admin++;}else if($question->user_type=='U'){$question_by_user++;}else if($question->user_type=='F'){$question_by_facebookuser++;}else if($question->user_type=='G'){$question_by_gplususer++;}else if($question->user_type=='T'){$question_by_twitteruser++;}else if($question->user_type=='L'){$question_by_linkedinuser++;}
				
				$month = date('M', strtotime($question->created));
				$year = date('Y', strtotime($question->created));
				$month_year = $month.' '.$year;
				$all_question_details[$month_year]['question'][] = $question->id;
			}
		}
		
		//Question Answer vs Question Comment Monthly barchart
		$all_question_answer_comment_details = array();
		if(!empty($totalquestionanswer)){
			foreach($totalquestionanswer as $question_answer){
				$month_qa = date('M', strtotime($question_answer->created));
				$year_qa = date('Y', strtotime($question_answer->created));
				$month_year_qa = $month_qa.' '.$year_qa;
				$all_question_answer_comment_details[$month_year_qa]['answers'][] = $question_answer->id;
			}
		}		
		if(!empty($total_question_comments)){
			foreach($total_question_comments as $question_comment){
				$month_qc = date('M', strtotime($question_comment->created));
				$year_qc = date('Y', strtotime($question_comment->created));
				$month_year_qc = $month_qc.' '.$year_qc;
				$all_question_answer_comment_details[$month_year_qc]['comments'][] = $question_comment->id;
			}
		}
		
		//Recently most viewed questions
		$QuestionsTable = TableRegistry::get('Admin.Questions');		
		$current_date = date('Y-m-d');
		$last_seventh_date = date('Y-m-d', strtotime('-6 days', strtotime($current_date)));	//previous 7th date
		$current_date = date('Y-m-d', strtotime('+1 days', strtotime($current_date)));
		$current_date = "'".$current_date."'";
		$last_seventh_date = "'".$last_seventh_date."'";		
		$question_options['conditions'][]	= ['Questions.status'=>'A'];
		$question_options['conditions'][]	= ['Questions.modified BETWEEN '.$last_seventh_date.' and '.$current_date];
		$question_options['fields']			= ['Questions.id','Questions.name','Questions.modified','Questions.status'];
		$question_options['order']			= ['Questions.modified'=>'DESC'];
		$question_options['limit']			= 5;
		$recently_most_viewed_questions 	= $QuestionsTable->find('all',$question_options)->toArray();
		
		//latest contacted users
		$ContactsTable = TableRegistry::get('Admin.Contacts');
		$latest_contacts = $ContactsTable->find('all',['fields'=>['id','name','email','subject','message','created'],'order'=>['created'=>'DESC'],'limit'=>5])->toArray();
		
		//online users
		$online_users = $usersTable->find('all',['conditions'=>['status'=>'A','loggedin_status'=>1],'fields'=>['id','name','email','full_name','profile_pic','type','status'],'order'=>['created'=>'DESC']])->toArray();
		
		//total and inactive question comment
		$questionsCommentTable = TableRegistry::get('Admin.QuestionComments');
		$totalquestioncomments = $questionsCommentTable->find('all')->count();
		$total_inactive_questioncomments = $questionsCommentTable->find('all',['conditions'=>['status'=>0]])->count();
		
		//total and inactive answer comment
		$answerCommentTable = TableRegistry::get('Admin.AnswerComment');
		$totalanswercomments = $answerCommentTable->find('all')->count();
		$total_inactive_answercomments = $answerCommentTable->find('all',['conditions'=>['status'=>0]])->count();
	
		$this->set(compact('total_news_comments','total_inactive_news_comments','total_users','total_inactive_users','total_questions','total_inactive_questions','total_question_answer','total_inactive_question_answer','all_question_details','all_question_answer_comment_details','question_by_admin','question_by_user','question_by_facebookuser','question_by_gplususer','question_by_twitteruser','question_by_linkedinuser','recently_most_viewed_questions','latest_contacts','online_users','totalquestioncomments','total_inactive_questioncomments','totalanswercomments','total_inactive_answercomments'));
    }

    /**
    * Profile Method
    */
    public function profile(){
        $this->loadModel('Admin.Admins');
        // Default layout is used
        $profile = $this->Admins->get($this->Auth->user('id'), ['contain' => []]);
        // if data is recieved by a form
        if ($this->request->is(['patch', 'post', 'put'])) {
            // validate data
            $profile = $this->Admins->patchEntity($profile, $this->request->data);
            // save data into db table
            if ($data = $this->Admins->save($profile)) {
                $this->Auth->setUser($data);
                // success message
                $this->Flash->success(__('Your profile has been successfully updated.'));
                return $this->redirect($this->referrer);
            } else {
                $this->Flash->error(__('Your profile is not updated'));
            }
        }
        // set data to the page
        $this->set(compact('profile'));
        $this->set('_serialize', ['profile']);
    }

    /**
    * Login email Method
    */
    public function loginEmail(){
        $this->loadModel('Admin.Admins');
        // Default layout is used
        $profile = $this->Admins->get($this->Auth->user('id'), ['contain' => []]);
        // if data is recieved by a form
        if ($this->request->is(['patch', 'post', 'put'])) {
            // validate data
            $profile = $this->Admins->patchEntity($profile, $this->request->data);
            // save data into db table
            if ($this->Admins->save($profile)) {
                // success message
                $this->Flash->success(__('Your login email has been successfully updated.'));
            } else {
                $this->Flash->error(__('Your login email is not updated'));
            }
        }
        // set data to the page
        $this->set(compact('profile'));
        $this->set('_serialize', ['profile']);
    }

    /**
    * Change Password Method
    */
    public function changePassword(){
        $this->loadModel('Admin.Admins');
        // Default layout is used
        $password = $this->Admins->get($this->Auth->user('id'), ['contain' => []]);
        // if data is recieved by a form
        if ($this->request->is(['patch', 'post', 'put'])) {
            // validate data
            $this->request->data['password'] = $this->request->data['new_password'];
            $password = $this->Admins->patchEntity($password, $this->request->data, ['validate' => 'password']);
            // save data into db table
            if ($this->Admins->save($password)) {
                // success message
                $this->Flash->success(__('Your password has been successfully updated.'));
            } else {
                $this->Flash->error(__('Your password is not updated'));
            }
        }
        $this->set(compact('password'));
    }

    public function uploadEditorImage(){
        $this->autoRender = false;
        if($this->request->is('post')){
            $handle = new \Upload($_FILES['image']);
            $handle->file_new_name_body = $new_name = 'editor_'.time().rand(0,9);
            $handle->Process('uploads/editor');
            if ($handle->processed) {
                    echo Router::url("/uploads/editor/", true).$handle->file_dst_name; die();
                $handle->clean();
            }else{
                $data = 'failed';
            }
            echo json_encode(['data'=>$data]); die();
        }
    }	
	
	/********************************** Permission Section Start *********************************/
	public function listSubAdmin(){
        try {
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('AdminDetails'))) || (!array_key_exists('list-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) || $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('list-sub-admin'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            // ************** start search filter **************** //
            if ($this->request->is('get')) {
				if (isset($this->request->query['search']) && !empty($this->request->query['search'])){					
                    $name = explode(' ', $this->request->query['search']);
                    if (isset($name[1])) {
                        if (!empty($name[1])) {
                           $options['conditions']['OR'][] = array('OR' => array('Users.name LIKE' => $name[0].'%'));
                        } else {
                            $options['conditions']['OR'][] = array('OR' => array('Users.name LIKE' => $name[0].'%'));
                        }
                    } else {
                        $options['conditions']['OR'][] = array('OR' => array('Users.name LIKE' => $name[0].'%'));
                    }
                }
			}
			$AdminsTable = TableRegistry::get('Admin.Admins');
			$options['conditions']	= ['Admins.type'=>'A','Admins.id !='=>$this->Auth->user('id')];
			$options['order'] 		= array('Admins.id DESC');
			$options['limit'] 		= $this->paginationLimit;            
			$userDetails = $this->paginate($AdminsTable, $options);
			
			$alphabet_options['conditions']	= ['Admins.status'=>'A','Admins.type'=>'A','Admins.id !='=>$this->Auth->user('id')];
			$alphabet_options['fields']		= ['Admins.id','Admins.first_name'];
			$alphabet_options['order'] 		= ['Admins.first_name'=>'ASC'];
			$all_characters = $AdminsTable->find('all', $alphabet_options)->toArray();
			$alphabets_only=array();
			if(!empty($all_characters)){
				foreach($all_characters as $characters){
					$key = strtolower(substr($characters['first_name'],0,1));
					$alphabets_only[$key][] = $characters;
				}
			}			
			$this->set(compact('userDetails','alphabets_only','session'));
			$this->set('_serialize', ['userDetails']);
		}catch (NotFoundException $e) {
			throw new NotFoundException(__('There is an unexpected error'));
		}
    }
	
	/* Add Sub Admin */
	public function addSubAdmin(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AdminDetails'))) || (!array_key_exists('add-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) || $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('add-sub-admin'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$SubAdminTable = TableRegistry::get('Admin.Admins');
        $user = $SubAdminTable->newEntity();
        if ($this->request->is('post')){
			$check_exist = $SubAdminTable->find('all',['conditions'=>['Admins.email'=>$this->request->data['email'],'Admins.type'=>'A']])->count();
			if($check_exist != 0){
				$this->Flash->error(__("This email id is already associated with us."));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'add-sub-admin']);
			}else{
				$userData = $SubAdminTable->patchEntity($user, $this->request->data);
				$userData['contact_email'] 			= $this->request->data['email'];
				$userData['mail_email'] 			= $this->request->data['email'];
				$userData['type'] 					= 'A';
				$userData['last_login_date']		= date('Y-m-d H:i:s');
				$userData['forget_password_string']	= '';
				$userData['signup_string']			= '';
				$userData['modified'] 				= date('Y-m-d H:i:s');
				$userData['created'] 				= date('Y-m-d H:i:s');
			
				if($savedData = $SubAdminTable->save($userData)){
					$get_last_insert_id = $savedData->id;
					$AdminPermisionsTable = TableRegistry::get('Admin.AdminPermisions');
					
					$settings = $this->getSiteSettings();
					$this->AdminEmail->replySubAdmin($this->request->data,$settings);
					
					/*if(array_key_exists('admin_permisions',$this->request->data)){
						foreach( $this->request->data['admin_permisions'] as $key_data => $val_data ){							
							$data['AdminPermisions']['admin_user_id'] 	= $get_last_insert_id;
							$data['AdminPermisions']['admin_menu_id'] 	= $val_data['admin_menu_id'];
							$data['AdminPermisions']['modified'] 		= date('Y-m-d H:i:s');
							$data['AdminPermisions']['created'] 		= date('Y-m-d H:i:s');
							$AdminPermisionsNewEntity = $AdminPermisionsTable->newEntity();
							$inserted_data = $AdminPermisionsTable->patchEntity($AdminPermisionsNewEntity, $data);
							$AdminPermisionsTable->save($inserted_data);
							unset($data); unset($inserted_data);							
						}
					}*/
					$this->Flash->success(__('New sub admin has been successfully created'));
					return $this->redirect(['plugin' => 'admin', 'controller' => 'AdminDetails', 'action' => 'list-sub-admin']);
				} else {
					$this->Flash->error(__('Sub Admin is not created. There is an unexpected error. Try contacting the developers'));
				}
			}
        }		
		$AdminMenus = TableRegistry::get('Admin.AdminMenus');
		$menus = $AdminMenus->find('all',['contain'=>['Methods'],'conditions'=>['AdminMenus.parent_id'=>0],'order'=>'AdminMenus.sort_order ASC'])->toArray();
		
        $this->set(compact('user','menus'));
        $this->set('_serialize', ['user']);
    }
	
	/* Edit sub admin */
	public function editSubAdmin($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AdminDetails'))) || (!array_key_exists('edit-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) || $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('edit-sub-admin'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        if ($id == NULL) {
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
		$SubAdminTable = TableRegistry::get('Admin.Admins');
		$SubAdminPermissionsTable = TableRegistry::get('Admin.AdminPermisions');
        $user = $SubAdminTable->get($id, ['contain'=>['AdminPermisions']]);
		if (empty($user)) {
            throw new NotFoundException(__('Page not found'));
        }
        // ***** if data recieved by post or put ***** //
        if ($this->request->is(['post', 'put'])) {
			$update_data = $SubAdminTable->patchEntity($user, $this->request->data);
            if ($savedData = $SubAdminTable->save($update_data)) {
				$get_last_insert_id = $savedData->id;
				$SubAdminPermissionsTable->deleteAll(['AdminPermisions.admin_user_id' => $get_last_insert_id]);				
				//insert data into permission table section start//
				if(array_key_exists('admin_permisions',$this->request->data)){
					foreach( $this->request->data['admin_permisions'] as $key_data => $val_data ){							
						$data['AdminPermisions']['admin_user_id'] 	= $get_last_insert_id;
						$data['AdminPermisions']['admin_menu_id'] 	= $val_data['admin_menu_id'];
						$data['AdminPermisions']['modified'] 		= date('Y-m-d H:i:s');
						$data['AdminPermisions']['created'] 		= date('Y-m-d H:i:s');
						$AdminPermisionsNewEntity = $SubAdminPermissionsTable->newEntity();
						$inserted_data = $SubAdminPermissionsTable->patchEntity($AdminPermisionsNewEntity, $data);
						$SubAdminPermissionsTable->save($inserted_data);
						unset($data); unset($inserted_data);							
					}
				}
				//insert data into permission table section end//				
				$this->Flash->success(__('Sub admin has been successfully updated'));
                return $this->redirect(['plugin' => 'Admin', 'controller' => 'admin-details', 'action' => 'list-sub-admin']);
            } else {
                $this->Flash->error(__('Sub admin is not updated. There is an unexpected error. Try contacting the developers'));
            }
        }
		// ***** if data recieved by post or put ***** //
		
		$selected_menus = array();
		if(!empty($user['admin_permisions'])){
			foreach($user['admin_permisions'] as $val){
				$selected_menus[] = $val['admin_menu_id'];
			}
		}		
		$AdminMenus = TableRegistry::get('Admin.AdminMenus');
		$menus = $AdminMenus->find('all',['contain'=>['Methods'],'conditions'=>['AdminMenus.parent_id'=>0],'order'=>'AdminMenus.sort_order ASC'])->toArray();
		
        $this->set(compact('user','menus','selected_menus'));
        $this->set('_serialize', ['user']);
    }
	
	/* Active Multiple Sub admin users */
	public function activeMultipleSubadmin($id = NULL){
		$this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AdminDetails'))) || (!array_key_exists('change-status-subadmin',$session->read('permissions.'.strtolower('AdminDetails')))) || $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('change-status-subadmin'))!=1) ){
			//echo json_encode(array('permission error'));
			//exit();
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post']);
		$AdminsTable = TableRegistry::get('Admin.Admins');
		if(!empty($this->request->data['id'])){
			$AdminsTable->updateAll(['status'=>'A'],  ['Admins.id IN' => $this->request->data['id']]);
			$ids = $this->request->data['id'];			
			echo json_encode($ids);
		}else{
			$ids = '';
			echo $ids;
		}
        exit();
    }
	
	/* InActive Multiple Sub admin users */
	public function inactiveMultipleSubadmin($id = NULL){
		$this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AdminDetails'))) || (!array_key_exists('change-status-subadmin',$session->read('permissions.'.strtolower('AdminDetails')))) || $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('change-status-subadmin'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}        
        $this->request->allowMethod(['post']);		
		if(!empty($this->request->data['id'])){
			$non_activated_users_count=0; $activated_users_count=0;
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			$AdminsTable = TableRegistry::get('Admin.Admins');
			foreach($this->request->data['id'] as $val_id){				
				$question_data = $QuestionsTable->find('all')->where(['Questions.user_id' => $val_id, 'Questions.status' => 'A'])->count();
				if( $question_data == 0 ){
					$AdminsTable->updateAll(['status'=>'I'], ['id' => $val_id]);
					$activated_users_count++;
					$non_activated_users_count = 0;						
				}
				else{
					$activated_users_count = 0;
					$non_activated_users_count++;
					
				}				
			}
			
			if( (count($this->request->data['id']) == $activated_users_count) && ($non_activated_users_count == 0) ){
				echo json_encode(array('type' => 'success', 'delete_count' => '1', 'message' => 'Su admins successfully inactivated'));
			}
			else if( ($activated_users_count == 0) && (count($this->request->data['id']) == $non_activated_users_count) ){
				echo json_encode(array('type' => 'error', 'delete_count' => '2', 'message' => 'Selected sub admin related question(s) exist, inactive question(s) first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'delete_count' => '3', 'message' => 'Some sub admin(s) related question(s) exist, inactive question(s) first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
	
	/* Change status */
	public function changeStatusSubadmin($id = NULL, $status = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AdminDetails'))) || (!array_key_exists('change-status-subadmin',$session->read('permissions.'.strtolower('AdminDetails')))) || $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('change-status-subadmin'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post', 'ajax', 'put']);
		$id = $this->request->data['id'];
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		if($id != ''){
			$AdminsTable = TableRegistry::get('Admin.Admins');
			$query = $AdminsTable->query();
			if($this->request->data['status'] == 'I'){	//request for making this user as inactive
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Sub admin successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else if($this->request->data['status'] == 'A'){
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Sub admin successfully activated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
			}			
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developer'));
		}
        exit();
    }
	
	/* Delete Sub Admin */
	public function deleteUserSubadmin($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AdminDetails'))) || (!array_key_exists('delete-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) || $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('delete-sub-admin'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$this->viewBuilder()->layout(false);
		$this->render(false);		
		$id = isset($this->request->data['id'])?$this->request->data['id']:'';
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$this->request->allowMethod(['post', 'delete']);
		if($id != ''){
			$AdminsTable = TableRegistry::get('Admin.Admins');
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			$question_data = $QuestionsTable->find('all')->where(['user_id'=>$id])->count();
			if( $question_data == 0 ){
				$SubAdminPermissionsTable = TableRegistry::get('Admin.AdminPermisions');
				$delete_data = $SubAdminPermissionsTable->find('list', ['conditions'=>array('AdminPermisions.	admin_user_id'=>$id),'fields' => ['AdminPermisions.id']])->toArray();
				if( count($delete_data) > 0){
					$SubAdminPermissionsTable->deleteAll(['id IN' => $delete_data]);
				}
				$user_data = $AdminsTable->get($id);
				$AdminsTable->delete($user_data);
				echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Sub admin successfully deleted'));
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'Sub admin related question(s) exist, delete question(s) first!!!'));
			}			
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
	
	/* Change password */
	public function changePasswordSubadmin($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AdminDetails'))) || (!array_key_exists('sub-admin-change-password',$session->read('permissions.'.strtolower('AdminDetails')))) || $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('sub-admin-change-password'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
            return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if ($id == NULL) {
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
		if (empty($id)) {
            throw new NotFoundException(__('Page not found'));
        }
		$AdminsTable = TableRegistry::get('Admin.Admins');
		$password = $AdminsTable->get($id);
        // ***** if data recieved by post or put ***** //
        if ($this->request->is(['post', 'put'])){
			$this->request->data['password'] = $this->request->data['new_password'];
            $password = $AdminsTable->patchEntity($password, $this->request->data, ['validate' => 'password']);
			if($AdminsTable->save($password)){
				$this->Flash->success(__('Password successfully updated.'));					
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'list-sub-admin']);					
			}else{
				$this->Flash->error(__('There was an unexpected error. Try again later or contact the developers.'));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'list-sub-admin']);				
			}
        }
		// ***** if data recieved by post or put ***** //		
		$this->set(compact('password'));
        $this->set('_serialize', ['password']);
    }
	
}
