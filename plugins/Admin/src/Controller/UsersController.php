<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
//require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");
require_once(ROOT . DS . 'vendor' . DS . "Classes" . DS . "PHPExcel.php");

/**
 * Users Controller
 *
 * @property \Admin\Model\Table\UsersTable $User
 */
class UsersController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'list-data']);
    }

    public function listData(){
        try {
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page."));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            // ************** start search filter **************** //
            if ($this->request->is('get')) {
				if (isset($this->request->query['search']) && !empty($this->request->query['search'])){					
                    $name = explode(' ', trim($this->request->query['search']));
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
                /*if (isset($this->request->query['search']) && !empty($this->request->query['search'])) {
					$options['conditions']['OR'][] = array('OR' => array('Users.email LIKE' => '%'.$this->request->query['search'].'%'));
                }*/

                /*if (isset($this->request->query['created_from']) && !empty($this->request->query['created_from']) && isset($this->request->query['created_to']) && !empty($this->request->query['created_to'])) {
                    $options['conditions']['Users.created >='] = date('Y-m-d', strtotime($this->request->query['created_from'])).' 00:00:00';
                    $options['conditions']['Users.created <='] = date('Y-m-d', strtotime($this->request->query['created_to'])).' 23:59:59';
                } else {
                    if (isset($this->request->query['created_from']) && !empty($this->request->query['created_from'])) {
                        $options['conditions']['Users.created >='] = date('Y-m-d', strtotime($this->request->query['created_from'])).' 00:00:00';
                    }

                    if (isset($this->request->query['created_to']) && !empty($this->request->query['created_to'])) {
                        $options['conditions']['Users.created <='] = date('Y-m-d', strtotime($this->request->query['created_to'])).' 23:59:59';
                    }
                }*/
            }
			//pr($options); die;
			//$options['fields'] = array('Users.id', 'Users.name', 'Users.profile_pic ', 'Users.email', 'Users.created', 'Users.status');
			$options['order'] = array('Users.id DESC');
            $options['limit'] = $this->paginationLimit;            
            $userDetails = $this->paginate($this->Users, $options);			
			//pr($userDetails); die;
			
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
            $this->set(compact('userDetails','alphabets_only'));
            $this->set('_serialize', ['userDetails']);
        } catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }
	
	public function downloadReports($id=NULL){
		$this->viewBuilder()->layout('ajax');
		$this->autoRender = false;
		if( !empty($id) ){
			$id = base64_decode($id);
			
			$objPHPExcel = new \PHPExcel();
			$objPHPExcel->getProperties()->setCreator("Tech Times.")
										 ->setLastModifiedBy("Tech Times")
										 ->setTitle("Report")
										 ->setSubject("Report Document")
										 ->setDescription("Report, generated using PHP classes.")
										 ->setKeywords("Report")
										 ->setCategory("all");
			
			/*---------Personal Details-----------*/
			$options['contain'] 	= ['Visitors','Visitors.VisitorLogs'];			
			$options['conditions'] 	= ['Users.id'=>$id];
			$options['order'] 		= ['Users.id'=>'ASC'];
			//$options['fields'] 	= ['Users.*'];
			$UserDetails 			= TableRegistry::get('Admin.Users');
			$details 				= $UserDetails->find('all', $options)->first()->toArray();
			//pr($details); die;
			
			// Set fonts                              
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()
						->setCellValue('A1', 'Nick Name')
						->setCellValue('B1', 'Email')
						->setCellValue('C1', 'Location')
						->setCellValue('D1', 'Title')
						->setCellValue('E1', 'Full Name')
						->setCellValue('F1', 'Birthday')
						->setCellValue('G1', 'About Me')
						->setCellValue('H1', 'Facebook Link')
						->setCellValue('I1', 'Twitter Link')
						->setCellValue('J1', 'Google Plus Link')
						->setCellValue('K1', 'LinkedIn Link')
						->setCellValue('L1', 'Account Created');
			
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('Personal Details');
			
			//Set values
			$objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A2', $details['name'])
                                    ->setCellValue('B2', $details['email'])
                                    ->setCellValue('C2', $details['location'])
                                    ->setCellValue('D2', $details['title'])
                                    ->setCellValue('E2', $details['full_name'])
                                    ->setCellValue('F2', $details['birthday'])
                                    ->setCellValue('G2', $details['about_me'])
                                    ->setCellValue('H2', $details['facebook_link'])
                                    ->setCellValue('I2', $details['twitter_link'])
                                    ->setCellValue('J2', $details['gplus_link'])
                                    ->setCellValue('K2', $details['linkedin_link'])
                                    ->setCellValue('L2', date('jS F Y H:i:s', strtotime($details['created'])));
			/*---------Personal Details-----------*/
			
			/*---------QUESTION POSTED-----------*/
			$objQuestionPosted = $objPHPExcel->createSheet(1); //Setting index when creating
			$objQuestionPosted->getStyle('A1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('B1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('C1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('D1')->getFont()->setBold(true);			
			$objQuestionPosted  ->setCellValue('A1', 'Question')
								->setCellValue('B1', 'Category')
								->setCellValue('C1', 'Created On')
								->setCellValue('D1', 'Status');
			
			$QuestionTable = TableRegistry::get('Admin.Questions');
			$submitted_questions = $QuestionTable->find('all',['contain'=>['QuestionCategories'],'conditions'=>['user_id'=>$id],'fields'=>['id','category_id','user_id','name','is_featured','status','created','QuestionCategories.id','QuestionCategories.name'],'order'=>['Questions.id DESC']])->toArray();
			if( !empty($submitted_questions) ){
				$pq = 2;
				foreach($submitted_questions as $val_sq){
					if($val_sq->question_category->name != '') $catname = $val_sq->question_category->name; else $catname = 'N/A';
					if($val_sq->status == 'I') $status = 'Inactive'; else $status = 'Active';
					$objQuestionPosted->setCellValue('A'.$pq, $val_sq->name)
									  ->setCellValue('B'.$pq, $catname)
									  ->setCellValue('C'.$pq, date('jS F Y H:i:s', strtotime($val_sq->created)))
									  ->setCellValue('D'.$pq, $status);
					$pq++;
				}
			}								
			$objQuestionPosted->setTitle('Questions Posted');
			/*---------QUESTION POSTED-----------*/
			
			/*---------ANSWER POSTED-----------*/
			$objAnswerPosted = $objPHPExcel->createSheet(2); //Setting index when creating
			$objAnswerPosted->getStyle('A1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('B1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('C1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('D1')->getFont()->setBold(true);			
			$objAnswerPosted->setCellValue('A1', 'Answer')
							->setCellValue('B1', 'Question')
							->setCellValue('C1', 'Created On')
							->setCellValue('D1', 'Status');
			
			$QuestionAnswersTable = TableRegistry::get('QuestionAnswer');
			$answer_details = $QuestionAnswersTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['QuestionAnswer.user_id'=>$id],'fields'=>['QuestionAnswer.id','QuestionAnswer.question_id','QuestionAnswer.user_id','QuestionAnswer.learning_path_recommendation','QuestionAnswer.status','QuestionAnswer.created'],'order'=>['QuestionAnswer.id DESC']])->toArray();
			if( !empty($answer_details) ){
				$pa = 2;
				foreach($answer_details as $val_ad){
					if($val_ad->status == 'I') $status = 'Inactive'; else $status = 'Active';
					$objAnswerPosted->setCellValue	('A'.$pa, strip_tags($val_ad->learning_path_recommendation))
									  ->setCellValue('B'.$pa, $val_ad->question->name)
									  ->setCellValue('C'.$pa, date('jS F Y H:i:s', strtotime($val_ad->created)))
									  ->setCellValue('D'.$pa, $status);
					$pa++;
				}
			}								
			$objAnswerPosted->setTitle('Answers Posted');
			/*---------ANSWER POSTED-----------*/
			
			/*---------COMMENTS POSTED-----------*/
			$objAnswerPosted = $objPHPExcel->createSheet(3); //Setting index when creating
			$objAnswerPosted->getStyle('A1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('B1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('C1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('D1')->getFont()->setBold(true);			
			$objAnswerPosted->setCellValue('A1', 'Comment')
							->setCellValue('B1', 'Question')
							->setCellValue('C1', 'Created On')
							->setCellValue('D1', 'Status');
			
			$QuestionCommentTable = TableRegistry::get('QuestionComment');
			$comment_details = $QuestionCommentTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['QuestionComment.user_id'=>$id],'fields'=>['QuestionComment.id','QuestionComment.question_id','QuestionComment.user_id','QuestionComment.comment','QuestionComment.status','QuestionComment.created'],'order'=>['QuestionComment.id DESC']])->toArray();
			if( !empty($comment_details) ){
				$cd = 2;
				foreach($comment_details as $val_cd){
					if($val_cd->status == 'I') $status = 'Inactive'; else $status = 'Active';
					$objAnswerPosted->setCellValue	('A'.$cd, strip_tags($val_cd->comment))
									  ->setCellValue('B'.$cd, $val_cd->question->name)
									  ->setCellValue('C'.$cd, date('jS F Y H:i:s', strtotime($val_cd->created)))
									  ->setCellValue('D'.$cd, $status);
					$cd++;
				}
			}								
			$objAnswerPosted->setTitle('Comments Posted');
			/*---------COMMENTS POSTED-----------*/
			
			/*---------LOG DETAILS-----------*/
			$objAnswerPosted = $objPHPExcel->createSheet(4); //Setting index when creating
			$objAnswerPosted->getStyle('A1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('B1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('C1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('D1')->getFont()->setBold(true);			
			$objAnswerPosted->setCellValue('A1', 'Sl. No.')
							->setCellValue('B1', 'Page')
							->setCellValue('C1', 'Controller')
							->setCellValue('D1', 'Method')
							->setCellValue('E1', 'Visited Date & Time');
			
			$VisitorTable = TableRegistry::get('Admin.Visitors');
			$log_details = $VisitorTable->find('all',['contain'=>['VisitorLogs'=>['fields'=>[]]],'conditions'=>['Visitors.user_id'=>$id]])->first();
			//pr($log_details);die;
			if( !empty($log_details['visitor_logs']) ){
				$ld = 2;
				foreach($log_details['visitor_logs'] as $val_ld){
					$objAnswerPosted->setCellValue('A'.$ld, ($ld-1))
									->setCellValue('B'.$ld, $val_ld['page_name'])
									->setCellValue('C'.$ld, $val_ld['controller'])
									->setCellValue('D'.$ld, $val_ld['method'])
									->setCellValue('E'.$ld, date('jS F Y H:i:s', strtotime($val_ld['visited_time'])));
					$ld++;
				}
			}								
			$objAnswerPosted->setTitle('Log Details');
			/*---------LOG DETAILS-----------*/
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$file_name= 'User_report_'.time().'.xlsx';
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename= '.$file_name);
			header('Cache-Control: max-age=0');
			header('Expires: Mon, 31 Dec 2030 05:00:00 GMT');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
			header('Cache-Control: cache, must-revalidate');
			header('Pragma: public');
			$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');			
			exit();
		}
	}

    public function addUser(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('add-user',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('add-user'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$UsersTable = TableRegistry::get('Admin.Users');
        $user = $UsersTable->newEntity();
        if ($this->request->is('post')) {
			if(array_key_exists('profile_pic', $this->request->data) && $this->request->data['profile_pic']['name']!=''){
                $handle = new \Upload($this->request->data['profile_pic']);
                $handle->file_new_name_body = $new_name = 'profile_'.time().rand(0,99);
                $handle->Process('uploads/user_profile_pic/');
                $handle->image_resize         = true;
                $handle->image_x              = 235;
                $handle->image_ratio_y        = true;
                $handle->file_new_name_body = $new_name;
                $handle->Process('uploads/user_profile_pic/thumb/');
                if ($handle->processed) {
                    $this->request->data['profile_pic'] = $handle->file_dst_name;
                    $handle->clean();
                }
            }else{
                $this->request->data['profile_pic'] = '';
            }
			$this->request->data['birthday']	= date('Y-m-d', strtotime($this->request->data['birthday']));
            $user = $UsersTable->patchEntity($user, $this->request->data);
            if ($savedData = $UsersTable->save($user)) {
				$get_last_insert_id = $savedData->id;
				$CareereducationsTable = TableRegistry::get('Admin.Careereducations');
				//education section start//
				if( $this->request->data['education_chk'] == 'education' ){	//checking education section is checked (then update/insert)
					if( array_key_exists('education', $this->request->data) && (!empty($this->request->data['education'])) ){							
						foreach( $this->request->data['education'] as $key_edu_data => $val_edu_data ){							
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
				//education section end//
				//career section start//
				if( $this->request->data['career_chk'] == 'career' ){	//checking career section is checked (then update/insert)
					if( array_key_exists('career', $this->request->data) && (!empty($this->request->data['career'])) ){					
						foreach( $this->request->data['career'] as $key_career_data => $val_career_data ){							
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
				//career section end//
                $this->Flash->success(__('New user has been successfully created'));
                return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'list-data']);
            } else {
                $this->Flash->error(__('User is not created. There is an unexpected error. Try contacting the developers'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function editUser($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('edit-user',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('edit-user'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        if ($id == NULL) {
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
		$UsersTable = TableRegistry::get('Admin.Users');
        $user = $UsersTable->get($id, ['contain'=>['Careereducations']]);
		//pr($user); die;
        if (empty($user)) {
            throw new NotFoundException(__('Page not found'));
        }
        // ***** if data recieved by post or put ***** //
        if ($this->request->is(['post', 'put'])) {
			if(array_key_exists('profile_pic', $this->request->data) && $this->request->data['profile_pic']['name']!=''){
                $handle = new \Upload($this->request->data['profile_pic']);
                $handle->file_new_name_body = $new_name = 'profile_'.time().rand(0,99);
                $handle->Process('uploads/user_profile_pic/');
                $handle->image_resize         = true;
                $handle->image_x              = 235;
                $handle->image_ratio_y        = true;
                $handle->file_new_name_body = $new_name;
                $handle->Process('uploads/user_profile_pic/thumb/');
                if ($handle->processed) {
                    $this->request->data['profile_pic'] = $handle->file_dst_name;
                    $handle->clean();
					@unlink(WWW_ROOT."uploads/user_profile_pic/".$user->profile_pic);
					@unlink(WWW_ROOT."uploads/user_profile_pic/thumb/".$user->profile_pic);
                }
            }else{
                $this->request->data['profile_pic'] = $user->profile_pic;
            }
			$this->request->data['birthday']	= date('Y-m-d', strtotime($this->request->data['birthday']));
			$inserted_data = $UsersTable->patchEntity($user, $this->request->data);
            if ($savedData = $UsersTable->save($inserted_data)) {
				$get_last_insert_id = $savedData->id;
				$CareereducationsTable = TableRegistry::get('Admin.Careereducations');
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
				$this->Flash->success(__('User profile has been successfully updated'));
                return $this->redirect(['plugin' => 'Admin', 'controller' => 'users', 'action' => 'list-data']);
            } else {
                $this->Flash->error(__('User profile is not updated. There is an unexpected error. Try contacting the developers'));
            }
        }
		// ***** if data recieved by post or put ***** //
		
		$education_details = array(); $career_details = array();
		if(!empty($user['careereducations'])){
			foreach($user['careereducations'] as $val){
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
        $this->set(compact('user','education_details','career_details'));
        $this->set('_serialize', ['user']);
    }

    public function deleteProfilepic($id = NULL){
		$this->viewBuilder()->layout(false);
		$this->render(false);
		
		$id = isset($this->request->data['id'])?base64_decode($this->request->data['id']):'';
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$this->request->allowMethod(['post', 'delete']);
		if($id != ''){
			$this->request->data['profile_pic'] = '';
			$UsersTable = TableRegistry::get('Admin.Users');
			$user_data = $UsersTable->get($id);
			@unlink(WWW_ROOT."uploads/user_profile_pic/".$user_data->profile_pic);
			@unlink(WWW_ROOT."uploads/user_profile_pic/thumb/".$user_data->profile_pic);
			$query = $UsersTable->query();
			if($query->update()
				->set(['profile_pic' => ''])
				->where(['Users.id' => $id])
				->execute()){
				echo json_encode(array('type' => 'success', 'message' => 'Profile picture successfully deleted'));
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting trtyrtyrtyhe developers'));
			}			
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
	
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
			$CareereducationsTable = TableRegistry::get('Admin.Careereducations');
			$data = $CareereducationsTable->find('all', ['conditions'=>array('Careereducations.id'=>$careereducation_id, 'Careereducations.user_id'=>$user_id, 'Careereducations.history_type'=>$type),'fields' => []])->first();
			$CareereducationsTable->delete($data);
			echo json_encode(array('type' => 'success', 'careereducation_id' => $careereducation_id, 'message' => 'Successfully deleted'));						
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
	
	public function deleteUser($id = NULL){
		$this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('delete-user',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('delete-user'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$id = isset($this->request->data['id'])?$this->request->data['id']:'';
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$this->request->allowMethod(['post', 'delete']);
		if($id != ''){
			$UsersTable = TableRegistry::get('Admin.Users');			
			//delete from career
			$CareereducationsTable = TableRegistry::get('Admin.Careereducations');
			$delete_careereducation_data = $CareereducationsTable->find('list', ['conditions'=>array('Careereducations.user_id'=>$id),'fields' => ['Careereducations.id']])->toArray();
			if( count($delete_careereducation_data) > 0){
				$CareereducationsTable->deleteAll(['id IN' => $delete_careereducation_data]);
			}
			//delete from question
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			$question_data = $QuestionsTable->find('list')->where(['user_id'=>$id])->toArray();
			if( count($question_data) > 0){
				$QuestionsTable->deleteAll(['id IN' => $question_data]);
			}
			//delete from question tags
			$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
			$question_tags_data = $QuestionTagsTable->find('list')->where(['user_id'=>$id])->toArray();
			if( count($question_tags_data) > 0){
				$QuestionTagsTable->deleteAll(['id IN' => $question_tags_data]);
			}
			//delete from question comments
			$QuestionCommentsTable = TableRegistry::get('Admin.QuestionComments');
			$question_comment_data = $QuestionCommentsTable->find('list')->where(['user_id'=>$id])->toArray();
			if( count($question_comment_data) > 0){
				$QuestionCommentsTable->deleteAll(['id IN' => $question_comment_data]);
			}			
			//delete from question answer
			$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
			$question_answer_data = $QuestionAnswersTable->find('list')->where(['user_id'=>$id])->toArray();
			if( count($question_answer_data) > 0){
				$QuestionAnswersTable->deleteAll(['id IN' => $question_answer_data]);
			}
			//delete from answer comment
			$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
			$delete_data = $AnswerCommentTable->find('list', ['conditions'=>array('AnswerComment.user_id'=>$id),'fields' => ['AnswerComment.id']])->toArray();
			if( count($delete_data) > 0){
				$AnswerCommentTable->deleteAll(['id IN' => $delete_data]);
			}
			//delete from answer upvote
			$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
			$delete_answerupvote_data = $AnswerUpvoteTable->find('list',['conditions'=>array('user_id'=>$id),'fields' => ['id']])->toArray();
			if( count($delete_answerupvote_data) > 0){
				$AnswerUpvoteTable->deleteAll(['id IN' => $delete_answerupvote_data]);
			}
			//delete from news comment
			$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
			$delete_newscomment_data = $NewsCommentsTable->find('list',['conditions'=>array('user_id'=>$id),'fields' => ['id']])->toArray();
			if( count($delete_newscomment_data) > 0){
				$NewsCommentsTable->deleteAll(['id IN' => $delete_newscomment_data]);
			}
			//delete from user account settings
			$UserAccountSettingTable = TableRegistry::get('Admin.UserAccountSetting');
			$delete_accountsettings_data = $UserAccountSettingTable->find('list',['conditions'=>array('user_id'=>$id),'fields'=>['id']])->toArray();
			if( count($delete_accountsettings_data) > 0){
				$UserAccountSettingTable->deleteAll(['id IN' => $delete_accountsettings_data]);
			}
			$user_data = $UsersTable->get($id);
			$UsersTable->delete($user_data);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'User successfully deleted'));			
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }

    public function deleteMultiple($id = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('delete-user',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('delete-user'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			foreach($this->request->data['id'] as $val_id){
				$UsersTable = TableRegistry::get('Admin.Users');			
				//delete from career
				$CareereducationsTable = TableRegistry::get('Admin.Careereducations');
				$delete_careereducation_data = $CareereducationsTable->find('list', ['conditions'=>array('Careereducations.user_id'=>$val_id),'fields' => ['Careereducations.id']])->toArray();
				if( count($delete_careereducation_data) > 0){
					$CareereducationsTable->deleteAll(['id IN' => $delete_careereducation_data]);
				}
				//delete from question
				$QuestionsTable = TableRegistry::get('Admin.Questions');
				$question_data = $QuestionsTable->find('list')->where(['user_id'=>$val_id])->toArray();
				if( count($question_data) > 0){
					$QuestionsTable->deleteAll(['id IN' => $question_data]);
				}
				//delete from question tags
				$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
				$question_tags_data = $QuestionTagsTable->find('list')->where(['user_id'=>$val_id])->toArray();
				if( count($question_tags_data) > 0){
					$QuestionTagsTable->deleteAll(['id IN' => $question_tags_data]);
				}
				//delete from question comments
				$QuestionCommentsTable = TableRegistry::get('Admin.QuestionComments');
				$question_comment_data = $QuestionCommentsTable->find('list')->where(['user_id'=>$val_id])->toArray();
				if( count($question_comment_data) > 0){
					$QuestionCommentsTable->deleteAll(['id IN' => $question_comment_data]);
				}			
				//delete from question answer
				$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
				$question_answer_data = $QuestionAnswersTable->find('list')->where(['user_id'=>$val_id])->toArray();
				if( count($question_answer_data) > 0){
					$QuestionAnswersTable->deleteAll(['id IN' => $question_answer_data]);
				}
				//delete from answer comment
				$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
				$delete_data = $AnswerCommentTable->find('list', ['conditions'=>array('AnswerComment.user_id'=>$val_id),'fields' => ['AnswerComment.id']])->toArray();
				if( count($delete_data) > 0){
					$AnswerCommentTable->deleteAll(['id IN' => $delete_data]);
				}
				//delete from answer upvote
				$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
				$delete_answerupvote_data = $AnswerUpvoteTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields' => ['id']])->toArray();
				if( count($delete_answerupvote_data) > 0){
					$AnswerUpvoteTable->deleteAll(['id IN' => $delete_answerupvote_data]);
				}
				//delete from news comment
				$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
				$delete_newscomment_data = $NewsCommentsTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields' => ['id']])->toArray();
				if( count($delete_newscomment_data) > 0){
					$NewsCommentsTable->deleteAll(['id IN' => $delete_newscomment_data]);
				}
				//delete from user account settings
				$UserAccountSettingTable = TableRegistry::get('Admin.UserAccountSetting');
				$delete_accountsettings_data = $UserAccountSettingTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields'=>['id']])->toArray();
				if( count($delete_accountsettings_data) > 0){
					$UserAccountSettingTable->deleteAll(['id IN' => $delete_accountsettings_data]);
				}
				$user_data = $UsersTable->get($val_id);
				$UsersTable->delete($user_data);
				
				$deleted_user_ids[] = $val_id;
				$deleted_users_count++;
				$non_deleted_users_count = 0;				
			}			
			if( (count($this->request->data['id']) == $deleted_users_count) && ($non_deleted_users_count == 0) ){
				$deleted_user_ids = $this->request->data['id'];
				echo json_encode(array('type' => 'success', 'deleted_ids' => $deleted_user_ids, 'delete_count' => '1', 'message' => 'User(s) successfully deleted'));
			}
			else if( ($deleted_users_count == 0) && (count($this->request->data['id']) == $non_deleted_users_count) ){
				echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '2', 'message' => 'Selected user(s) related question(s) exist, delete question(s) first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'deleted_ids' => $deleted_user_ids, 'delete_count' => '3', 'message' => 'Some user(s) related question(s) exist, delete question(s) first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Users')))) && $session->read('permissions.'.strtolower('Users').'.'.strtolower('change-status'))!=1) ){
			/*echo json_encode(array('permission error'));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post']);
		$UsersTable = TableRegistry::get('Admin.Users');
		if(!empty($this->request->data['id'])){
			$UsersTable->updateAll(['status'=>'A'],  ['Users.id IN' => $this->request->data['id']]);
			$ids = $this->request->data['id'];			
			echo json_encode($ids);
		}else{
			$ids = '';
			echo $ids;
		}
        exit();
    }
    
	public function inactiveMultiple($id = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('change-status'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post']);		
		if(!empty($this->request->data['id'])){
			$non_activated_users_count=0; $activated_users_count=0;
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			$UsersTable = TableRegistry::get('Admin.Users');
			foreach($this->request->data['id'] as $val_id){				
				$question_data = $QuestionsTable->find('all')->where(['Questions.user_id' => $val_id, 'Questions.status' => 'A'])->count();
				if( $question_data == 0 ){
					$UsersTable->updateAll(['status'=>'I'], ['id' => $val_id]);
					$activated_users_count++;
					$non_activated_users_count = 0;						
				}
				else{
					$activated_users_count = 0;
					$non_activated_users_count++;					
				}				
			}
			
			if( (count($this->request->data['id']) == $activated_users_count) && ($non_activated_users_count == 0) ){
				echo json_encode(array('type' => 'success', 'delete_count' => '1', 'message' => 'Users successfully inactivated'));
			}
			else if( ($activated_users_count == 0) && (count($this->request->data['id']) == $non_activated_users_count) ){
				echo json_encode(array('type' => 'error', 'delete_count' => '2', 'message' => 'Selected user related question(s) exist, inactive question(s) first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'delete_count' => '3', 'message' => 'Some user(s) related question(s) exist, inactive question(s) first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
    
	public function changeStatus($id = NULL, $status = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('change-status'))!=1) ){
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
			$UsersTable = TableRegistry::get('Admin.Users');
			$query = $UsersTable->query();
			if($this->request->data['status'] == 'I'){	//request for making this user as inactive
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'User successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else if($this->request->data['status'] == 'A'){
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'User successfully activated'));
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
	
	public function userAccountSetting($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('user-account-setting',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('user-account-setting'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        if ($id == NULL) {
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
		$UserAccountSettingTable = TableRegistry::get('Admin.UserAccountSetting');
        $existing_account_settings = $UserAccountSettingTable->find('all',['contain'=>['Users'=>['fields'=>['id','email','notification_email']]],'conditions'=>['user_id'=>$id]])->first();
		$QuestionTable = TableRegistry::get('Admin.Questions');
		$question_categories = $this->getQuestionCategories();	//mention in AppController
        if (empty($id)) {
            throw new NotFoundException(__('Page not found'));
        }
        // ***** if data recieved by post or put ***** //
        if ($this->request->is(['post', 'put'])){
			$account_settings = $UserAccountSettingTable->find('all',['conditions'=>['user_id'=>$id]])->first();
			if(empty($account_settings)){
				$this->request->data['user_id']	= $existing_account_settings['user_id'];
				$settings = $UserAccountSettingTable->newEntity();
				$data_to_insert = $UserAccountSettingTable->patchEntity($settings, $this->request->data);
				if($savedData = $UserAccountSettingTable->save($data_to_insert)){
					$this->Flash->success(__('Account settings successfully updated.'));					
					return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'list-data']);					
				}else{
					return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'list-data']);
					$this->Flash->error(__('There was an unexpected error. Try again later or contact the developers.'));					
				}
			}else{
				$this->request->data['user_id']	= $existing_account_settings['user_id'];
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
					return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'list-data']);
				}else{
					return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'list-data']);
					$this->Flash->error(__('There was an unexpected error. Try again later or contact the developers.'));					
				}
			}
        }
		// ***** if data recieved by post or put ***** //		
		$this->set(compact('existing_account_settings','question_categories'));
        $this->set('_serialize', ['existing_account_settings']);
    }
	
	public function userChangePassword($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('user-change-password',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('user-change-password'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        if ($id == NULL) {
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
		if (empty($id)) {
            throw new NotFoundException(__('Page not found'));
        }
		$UserTable = TableRegistry::get('Admin.Users');
		$password = $UserTable->get($id);
        // ***** if data recieved by post or put ***** //
        if ($this->request->is(['post', 'put'])){
			$this->request->data['password'] = $this->request->data['new_password'];
            $password = $UserTable->patchEntity($password, $this->request->data, ['validate' => 'password']);
			if($UserTable->save($password)){
				$this->Flash->success(__('Password successfully updated.'));					
				return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'list-data']);					
			}else{
				$this->Flash->error(__('There was an unexpected error. Try again later or contact the developers.'));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'users', 'action' => 'list-data']);				
			}
        }
		// ***** if data recieved by post or put ***** //		
		$this->set(compact('password'));
        $this->set('_serialize', ['password']);
    }
	
	//all submitted details for a particular user
	public function userSubmittedDetails($user_id=NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('user-submitted-details',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('user-submitted-details'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$user_id = isset($user_id)?base64_decode($user_id):'';
		if ($user_id == NULL) {
            throw new NotFoundException(__('Page not found'));
        }
		//submitted questions start//
		$QuestionTable = TableRegistry::get('Questions');
		$submitted_questions = $QuestionTable->find('all',['contain'=>['QuestionCategories'],'conditions'=>['user_id'=>$user_id],'fields'=>['id','category_id','user_id','name','is_featured','status','created','QuestionCategories.id','QuestionCategories.name'],'order'=>['Questions.id DESC']])->toArray();
		//submitted questions end//
		
		//submitted question comments//
		$QuestionCommentTable = TableRegistry::get('Admin.QuestionComments');
		$comment_details = $QuestionCommentTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['QuestionComments.user_id'=>$user_id],'fields'=>['QuestionComments.id','QuestionComments.question_id','QuestionComments.user_id','QuestionComments.comment','QuestionComments.status','QuestionComments.created'],'order'=>['QuestionComments.id DESC']])->toArray();
		//submitted question comments//
		
		//submitted question answers//
		$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
		$answer_details = $QuestionAnswersTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['QuestionAnswers.user_id'=>$user_id],'fields'=>['QuestionAnswers.id','QuestionAnswers.question_id','QuestionAnswers.user_id','QuestionAnswers.learning_path_recommendation','QuestionAnswers.status','QuestionAnswers.created'],'order'=>['QuestionAnswers.id DESC']])->toArray();		
		//submitted question answers//
		
		//submitted answer comments//
		$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');			
		$answer_comment_details = $AnswerCommentTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['AnswerComment.user_id'=>$user_id],'fields'=>['AnswerComment.id','AnswerComment.question_id','AnswerComment.user_id','AnswerComment.comment','AnswerComment.status','AnswerComment.created'],'order'=>['AnswerComment.id DESC']])->toArray();		
		//submitted answer comments//
		
		$this->set(compact('submitted_questions','comment_details','answer_details','answer_comment_details'));
		//pr($answer_comment_details); die;
	}	
	
}
