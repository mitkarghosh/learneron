<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
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
			$options['contain'] 	= ['Visitors','Visitors.VisitorLogs','Careereducations','UserAccountSetting','UserAccountSetting.QuestionCategories'];			
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
			
			/*---------Account Settings Section-----------*/
			$objQuestionPosted = $objPHPExcel->createSheet(1); //Setting index when creating
			$objQuestionPosted->getStyle('A1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('B1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('C1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('D1')->getFont()->setBold(true);			
			$objQuestionPosted  ->setCellValue('A1', 'Receive Email Notifications on New Responses to My Questions')
								->setCellValue('B1', 'Subscribe for News & Views')
								->setCellValue('C1', 'Follow us on Twitter')
								->setCellValue('D1', 'Send Me Notifications on Posting New Question in Below Defined Category');
			
			if( !empty($details['user_account_setting']) ){
				$as = 2;
				foreach($details['user_account_setting'] as $val_as){
					if($val_as['response_to_my_question_notification'] == 1) $question_notification = 'Yes'; else $question_notification = 'No';
					if($val_as['news_notification'] == 1) $news_notification = 'Yes'; else $news_notification = 'No';
					if($val_as['follow_twitter'] == 1) $follow_twitter = 'Yes'; else $follow_twitter = 'No';
					if($val_as['posting_new_question_notification'] == 1){
						$catname = $val_as['question_category']['name'];
					}else{
						$catname = '';
					}
					$objQuestionPosted->setCellValue('A'.$as, $question_notification)
								  ->setCellValue('B'.$as, $news_notification)
								  ->setCellValue('C'.$as, $follow_twitter)
								  ->setCellValue('D'.$as, $catname);
					$as++;					
				}
			}								
			$objQuestionPosted->setTitle('Account Settings');
			/*---------Account Settings Section-----------*/
			
			/*---------Educational Details Section-----------*/
			$objQuestionPosted = $objPHPExcel->createSheet(2); //Setting index when creating
			$objQuestionPosted->getStyle('A1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('B1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('C1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('D1')->getFont()->setBold(true);			
			$objQuestionPosted  ->setCellValue('A1', 'Degree, Certificate, or Completion / Finished')
								->setCellValue('B1', 'School, Bootcamp, MOOC, Course or Similar Name')
								->setCellValue('C1', 'From Date')
								->setCellValue('D1', 'To Date');
			
			if( !empty($details['careereducations']) ){
				$ec = 2;
				foreach($details['careereducations'] as $val_ec){
					if( $val_ec['history_type'] == 'E' ){
						$objQuestionPosted->setCellValue('A'.$ec, html_entity_decode(strip_tags($val_ec['edu_degree'])))
									  ->setCellValue('B'.$ec, html_entity_decode(strip_tags($val_ec['edu_organization'])))
									  ->setCellValue('C'.$ec, html_entity_decode(strip_tags($val_ec['edu_from'])))
									  ->setCellValue('D'.$ec, html_entity_decode(strip_tags($val_ec['edu_to'])));
						$ec++;
					}
				}
			}								
			$objQuestionPosted->setTitle('Educational Details');
			/*---------Educational Details Section-----------*/
			
			/*---------Career / Company Details Section-----------*/
			$objQuestionPosted = $objPHPExcel->createSheet(3); //Setting index when creating
			$objQuestionPosted->getStyle('A1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('B1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('C1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('D1')->getFont()->setBold(true);			
			$objQuestionPosted  ->setCellValue('A1', 'Position')
								->setCellValue('B1', 'Company Name')
								->setCellValue('C1', 'From Date')
								->setCellValue('D1', 'To Date');
			
			if( !empty($details['careereducations']) ){
				$ce = 2;
				foreach($details['careereducations'] as $val_ce){
					if( $val_ce['history_type'] == 'C' ){
						$objQuestionPosted->setCellValue('A'.$ce, html_entity_decode(strip_tags($val_ce['career_position'])))
									  ->setCellValue('B'.$ce, html_entity_decode(strip_tags($val_ce['career_company'])))
									  ->setCellValue('C'.$ce, $val_ce['career_from'])
									  ->setCellValue('D'.$ce, $val_ce['career_to']);
						$ce++;
					}
				}
			}								
			$objQuestionPosted->setTitle('Company Details');
			/*---------Career / Company Details Section-----------*/
			
			/*---------QUESTION POSTED-----------*/
			$objQuestionPosted = $objPHPExcel->createSheet(4); //Setting index when creating
			$objQuestionPosted->getStyle('A1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('B1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('C1')->getFont()->setBold(true);
			$objQuestionPosted->getStyle('D1')->getFont()->setBold(true);			
			$objQuestionPosted  ->setCellValue('A1', 'Question No.')
								->setCellValue('B1', 'Question')
								->setCellValue('C1', 'Learning Goal')
								->setCellValue('D1', 'Budget & other constraints')
								->setCellValue('E1', 'Optional input on preferred learning mode')
								->setCellValue('F1', 'Category')
								->setCellValue('G1', 'Created On')
								->setCellValue('H1', 'Status');
			
			$QuestionTable = TableRegistry::get('Admin.Questions');
			$submitted_questions = $QuestionTable->find('all',['contain'=>['QuestionCategories'],'conditions'=>['user_id'=>$id],'fields'=>['id','category_id','user_id','name','learning_goal','budget_constraints','preferred_learning_mode','is_featured','status','created','QuestionCategories.id','QuestionCategories.name'],'order'=>['Questions.id DESC']])->toArray();
			if( !empty($submitted_questions) ){
				$pq = 2;
				foreach($submitted_questions as $val_sq){
					if($val_sq->question_category->name != '') $catname = $val_sq->question_category->name; else $catname = 'N/A';
					if($val_sq->status == 'I') $status = 'Inactive'; else $status = 'Active';
					$objQuestionPosted->setCellValue('A'.$pq, '#'.$val_sq->id)
									  ->setCellValue('B'.$pq, $val_sq->name)
									  ->setCellValue('C'.$pq, html_entity_decode(strip_tags($val_sq->learning_goal)))
									  ->setCellValue('D'.$pq, html_entity_decode(strip_tags($val_sq->budget_constraints)))
									  ->setCellValue('E'.$pq, html_entity_decode(strip_tags($val_sq->preferred_learning_mode)))
									  ->setCellValue('F'.$pq, $catname)
									  ->setCellValue('G'.$pq, date('jS F Y H:i:s', strtotime($val_sq->created)))
									  ->setCellValue('H'.$pq, $status);
					$pq++;
				}
			}								
			$objQuestionPosted->setTitle('Questions Posted');
			/*---------QUESTION POSTED-----------*/
			
			/*---------ANSWER POSTED-----------*/
			$objAnswerPosted = $objPHPExcel->createSheet(5); //Setting index when creating
			$objAnswerPosted->getStyle('A1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('B1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('C1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('D1')->getFont()->setBold(true);			
			$objAnswerPosted->setCellValue('A1', 'Learning Path Recommendation')
							->setCellValue('B1', 'What Was Your Learning Experience')
							->setCellValue('C1', 'What Was Your Learning Utility')
							->setCellValue('D1', 'Question')
							->setCellValue('E1', 'Created On')
							->setCellValue('F1', 'Status');
			
			$QuestionAnswersTable = TableRegistry::get('QuestionAnswer');
			$answer_details = $QuestionAnswersTable->find('all',['contain'=>['Questions'=>['fields'=>['id','user_id','name']]],'conditions'=>['QuestionAnswer.user_id'=>$id],'fields'=>['QuestionAnswer.id','QuestionAnswer.question_id','QuestionAnswer.user_id','QuestionAnswer.learning_path_recommendation','QuestionAnswer.learning_experience','QuestionAnswer.learning_utility','QuestionAnswer.status','QuestionAnswer.created'],'order'=>['QuestionAnswer.id DESC']])->toArray();
			if( !empty($answer_details) ){
				$pa = 2;
				foreach($answer_details as $val_ad){
					if($val_ad->status == 'I') $status = 'Inactive'; else $status = 'Active';
					$objAnswerPosted->setCellValue	('A'.$pa, html_entity_decode(strip_tags($val_ad->learning_path_recommendation)))
									  ->setCellValue('B'.$pa, html_entity_decode(strip_tags($val_ad->learning_experience)))
									  ->setCellValue('C'.$pa, html_entity_decode(strip_tags($val_ad->learning_utility)))
									  ->setCellValue('D'.$pa, $val_ad->question->name)
									  ->setCellValue('E'.$pa, date('jS F Y H:i:s', strtotime($val_ad->created)))
									  ->setCellValue('F'.$pa, $status);
					$pa++;
				}
			}								
			$objAnswerPosted->setTitle('Answers Posted');
			/*---------ANSWER POSTED-----------*/
			
			/*---------COMMENTS POSTED-----------*/
			$objAnswerPosted = $objPHPExcel->createSheet(6); //Setting index when creating
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
									  ->setCellValue('B'.$cd, $val_cd->question['name'])
									  ->setCellValue('C'.$cd, date('jS F Y H:i:s', strtotime($val_cd->created)))
									  ->setCellValue('D'.$cd, $status);
					$cd++;
				}
			}								
			$objAnswerPosted->setTitle('Comments Posted');
			/*---------COMMENTS POSTED-----------*/
			
			/*---------LOG DETAILS-----------*/
			$objAnswerPosted = $objPHPExcel->createSheet(7); //Setting index when creating
			$objAnswerPosted->getStyle('A1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('B1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('C1')->getFont()->setBold(true);
			$objAnswerPosted->getStyle('D1')->getFont()->setBold(true);			
			$objAnswerPosted->setCellValue('A1', 'Page')
							->setCellValue('B1', 'Controller')
							->setCellValue('C1', 'Question Page URL')
							->setCellValue('D1', 'Question Number')
							->setCellValue('E1', 'Visited Date & Time');
			
			$VisitorTable = TableRegistry::get('Admin.Visitors');
			$log_details = $VisitorTable->find('all',['contain'=>['VisitorLogs'=>['fields'=>[]]],'conditions'=>['Visitors.user_id'=>$id]])->first();
			//pr($log_details);die;
			if( !empty($log_details['visitor_logs']) ){
				$ld = 2;
				foreach($log_details['visitor_logs'] as $val_ld){
					$url = ''; $ques_no = '';
					if($val_ld['question_id'] != '' && strpos($val_ld['page_url'], 'questions/details') !== false){
						$url = $val_ld['page_url'];
						$ques_no = '#'.$val_ld['question_id'];
					}
					$objAnswerPosted->setCellValue('A'.$ld, $val_ld['page_name'])
									->setCellValue('B'.$ld, $val_ld['controller'])
									->setCellValue('C'.$ld, $url)
									->setCellValue('D'.$ld, $ques_no)
									->setCellValue('E'.$ld, date('jS F Y H:i:s', strtotime($val_ld['visited_time'])));
					$ld++;
				}
			}								
			$objAnswerPosted->setTitle('Log Details');
			/*---------LOG DETAILS-----------*/
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$file_name= 'User_report_'.time().'.xls';
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename= '.$file_name);
			header('Cache-Control: max-age=0');
			/*header('Expires: Mon, 31 Dec 2030 05:00:00 GMT');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
			header('Cache-Control: cache, must-revalidate');
			header('Pragma: public');
			$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');*/			
			$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			ob_clean();
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
			if( $this->request->data['birthday'] != '' ){
				$this->request->data['birthday']	= date('Y-m-d', strtotime($this->request->data['birthday']));
			}else{
				$this->request->data['birthday']	= '';
			}
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
			if( $this->request->data['birthday'] != '' ){
				$this->request->data['birthday']	= date('Y-m-d', strtotime($this->request->data['birthday']));
			}else{
				$this->request->data['birthday']	= '';
			}
			
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
				foreach($question_data as $qd){
					//delete from question answer respect to question id
					$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
					$ques_answer_data = $QuestionAnswersTable->find('list')->where(['question_id'=>$qd])->toArray();
					if( count($ques_answer_data) > 0){
						$QuestionAnswersTable->deleteAll(['id IN' => $ques_answer_data]);
					}
					//delete from question comments respect to question id
					$QuestionCommentsTable = TableRegistry::get('Admin.QuestionComments');
					$ques_comment_data = $QuestionCommentsTable->find('list')->where(['question_id'=>$qd])->toArray();
					if( count($ques_comment_data) > 0){
						$QuestionCommentsTable->deleteAll(['id IN' => $ques_comment_data]);
					}
					//delete from question tags respect to question id
					$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
					$ques_tags_data = $QuestionTagsTable->find('list')->where(['question_id'=>$qd])->toArray();
					if( count($ques_tags_data) > 0){
						$QuestionTagsTable->deleteAll(['id IN' => $ques_tags_data]);
					}
					//delete from answer comment respect to question id
					$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
					$del_data = $AnswerCommentTable->find('list', ['conditions'=>array('AnswerComment.question_id'=>$qd),'fields' => ['AnswerComment.id']])->toArray();
					if( count($del_data) > 0){
						$AnswerCommentTable->deleteAll(['id IN' => $del_data]);
					}
					//delete from answer upvote respect to question id
					$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
					$del_answerupvote_data = $AnswerUpvoteTable->find('list',['conditions'=>array('question_id'=>$qd),'fields' => ['id']])->toArray();
					if( count($del_answerupvote_data) > 0){
						$AnswerUpvoteTable->deleteAll(['id IN' => $del_answerupvote_data]);
					}
				}
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
			//delete from anonymous user
			$AnonymousUserTable = TableRegistry::get('Admin.AnonymousUsers');				
			$delete_anonymous_user_data = $AnonymousUserTable->find('list',['conditions'=>array('user_id'=>$id),'fields'=>['id']])->toArray();
			if( count($delete_anonymous_user_data) > 0){
				$AnonymousUserTable->deleteAll(['id IN' => $delete_anonymous_user_data]);
			}
			//delete from visitor table
			$VisitorsTable = TableRegistry::get('Admin.VisitorLogs');				
			$del_visitor_data = $VisitorsTable->find('list',['conditions'=>array('user_id'=>$id),'fields'=>['id']])->toArray();
			if( count($del_visitor_data) > 0){
				$VisitorsTable->deleteAll(['id IN' => $del_visitor_data]);
			}
			//delete from visitor logs table
			$VisitorLogsTable = TableRegistry::get('Admin.VisitorLogs');				
			$del_visitor_log_data = $VisitorLogsTable->find('list',['conditions'=>array('user_id'=>$id),'fields'=>['id']])->toArray();
			if( count($del_visitor_log_data) > 0){
				$VisitorLogsTable->deleteAll(['id IN' => $del_visitor_log_data]);
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
					foreach($question_data as $qd){
						//delete from question answer respect to question id
						$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
						$ques_answer_data = $QuestionAnswersTable->find('list')->where(['question_id'=>$qd])->toArray();
						if( count($ques_answer_data) > 0){
							$QuestionAnswersTable->deleteAll(['id IN' => $ques_answer_data]);
						}
						//delete from question comments respect to question id
						$QuestionCommentsTable = TableRegistry::get('Admin.QuestionComments');
						$ques_comment_data = $QuestionCommentsTable->find('list')->where(['question_id'=>$qd])->toArray();
						if( count($ques_comment_data) > 0){
							$QuestionCommentsTable->deleteAll(['id IN' => $ques_comment_data]);
						}
						//delete from question tags respect to question id
						$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
						$ques_tags_data = $QuestionTagsTable->find('list')->where(['question_id'=>$qd])->toArray();
						if( count($ques_tags_data) > 0){
							$QuestionTagsTable->deleteAll(['id IN' => $ques_tags_data]);
						}
						//delete from answer comment respect to question id
						$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
						$del_data = $AnswerCommentTable->find('list', ['conditions'=>array('AnswerComment.question_id'=>$qd),'fields' => ['AnswerComment.id']])->toArray();
						if( count($del_data) > 0){
							$AnswerCommentTable->deleteAll(['id IN' => $del_data]);
						}
						//delete from answer upvote respect to question id
						$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
						$del_answerupvote_data = $AnswerUpvoteTable->find('list',['conditions'=>array('question_id'=>$qd),'fields' => ['id']])->toArray();
						if( count($del_answerupvote_data) > 0){
							$AnswerUpvoteTable->deleteAll(['id IN' => $del_answerupvote_data]);
						}
					}
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
				//delete from anonymous user
				$AnonymousUserTable = TableRegistry::get('Admin.AnonymousUsers');				
				$delete_anonymous_user_data = $AnonymousUserTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields'=>['id']])->toArray();
				if( count($delete_anonymous_user_data) > 0){
					$AnonymousUserTable->deleteAll(['id IN' => $delete_anonymous_user_data]);
				}
				//delete from visitor table
				$VisitorsTable = TableRegistry::get('Admin.VisitorLogs');				
				$del_visitor_data = $VisitorsTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields'=>['id']])->toArray();
				if( count($del_visitor_data) > 0){
					$VisitorsTable->deleteAll(['id IN' => $del_visitor_data]);
				}
				//delete from visitor logs table
				$VisitorLogsTable = TableRegistry::get('Admin.VisitorLogs');				
				$del_visitor_log_data = $VisitorLogsTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields'=>['id']])->toArray();
				if( count($del_visitor_log_data) > 0){
					$VisitorLogsTable->deleteAll(['id IN' => $del_visitor_log_data]);
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
	
	//Delete all user data from database
	public function deleteUserWithSubmission($id = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('delete-user',$session->read('permissions.'.strtolower('Users')))) || $session->read('permissions.'.strtolower('Users').'.'.strtolower('delete-user'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$val_id = $this->request->data['id'];
			
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
				foreach($question_data as $qd){
					//delete from question answer respect to question id
					$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
					$ques_answer_data = $QuestionAnswersTable->find('list')->where(['question_id'=>$qd])->toArray();
					if( count($ques_answer_data) > 0){
						$QuestionAnswersTable->deleteAll(['id IN' => $ques_answer_data]);
					}
					//delete from question comments respect to question id
					$QuestionCommentsTable = TableRegistry::get('Admin.QuestionComments');
					$ques_comment_data = $QuestionCommentsTable->find('list')->where(['question_id'=>$qd])->toArray();
					if( count($ques_comment_data) > 0){
						$QuestionCommentsTable->deleteAll(['id IN' => $ques_comment_data]);
					}
					//delete from question tags respect to question id
					$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
					$ques_tags_data = $QuestionTagsTable->find('list')->where(['question_id'=>$qd])->toArray();
					if( count($ques_tags_data) > 0){
						$QuestionTagsTable->deleteAll(['id IN' => $ques_tags_data]);
					}
					//delete from answer comment respect to question id
					$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
					$del_data = $AnswerCommentTable->find('list', ['conditions'=>array('AnswerComment.question_id'=>$qd),'fields' => ['AnswerComment.id']])->toArray();
					if( count($del_data) > 0){
						$AnswerCommentTable->deleteAll(['id IN' => $del_data]);
					}
					//delete from answer upvote respect to question id
					$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
					$del_answerupvote_data = $AnswerUpvoteTable->find('list',['conditions'=>array('question_id'=>$qd),'fields' => ['id']])->toArray();
					if( count($del_answerupvote_data) > 0){
						$AnswerUpvoteTable->deleteAll(['id IN' => $del_answerupvote_data]);
					}
				}
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
			//delete from anonymous user
			$AnonymousUserTable = TableRegistry::get('Admin.AnonymousUsers');				
			$delete_anonymous_user_data = $AnonymousUserTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields'=>['id']])->toArray();
			if( count($delete_anonymous_user_data) > 0){
				$AnonymousUserTable->deleteAll(['id IN' => $delete_anonymous_user_data]);
			}
			//delete from visitor table
			$VisitorsTable = TableRegistry::get('Admin.VisitorLogs');				
			$del_visitor_data = $VisitorsTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields'=>['id']])->toArray();
			if( count($del_visitor_data) > 0){
				$VisitorsTable->deleteAll(['id IN' => $del_visitor_data]);
			}
			//delete from visitor logs table
			$VisitorLogsTable = TableRegistry::get('Admin.VisitorLogs');				
			$del_visitor_log_data = $VisitorLogsTable->find('list',['conditions'=>array('user_id'=>$val_id),'fields'=>['id']])->toArray();
			if( count($del_visitor_log_data) > 0){
				$VisitorLogsTable->deleteAll(['id IN' => $del_visitor_log_data]);
			}
			
			$user_data = $UsersTable->get($val_id);
			$UsersTable->delete($user_data);
			echo json_encode(array('type' => 'success', 'message' => 'User successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
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
	
	//Make Anonymous User
	public function makeUserAnonymous(){
		$this->viewBuilder()->layout(false);
		$this->render(false);
		/*$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Users'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Users')))) && $session->read('permissions.'.strtolower('Users').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page."));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}*/
        $this->request->allowMethod(['post']);
		
		$AnonymousUserTable = TableRegistry::get('Admin.AnonymousUsers');
		$UsersTable = TableRegistry::get('Admin.Users');
		
		//checking user is already anonymous or not
		$count_user = $AnonymousUserTable->find('all',['conditions'=>['AnonymousUsers.user_id'=>$this->request->data['id']]])->count();
		if( $count_user == 0 ){
			$anonymous_data['AnonymousUsers']['user_id']  		= isset($this->request->data['id'])?$this->request->data['id']:0;

			if($this->request->data['type'] == 'group'){
				$anonymous_data['AnonymousUsers']['usertype'] 	= isset($this->request->data['type'])?$this->request->data['type']:'group';
				$anonymous_data['AnonymousUsers']['slug'] 	 	= 'Anonymous Group';
				
				$this->request->data['name']				= ucwords('Anonymous Group');
				$this->request->data['email']				= 'anonymousgroup@learneron.net';
				$this->request->data['full_name']			= 'Anonymous Group';				
			}
			else if($this->request->data['type'] == 'individual'){
				$slug											= $AnonymousUserTable->createSlug('Anonymous');
				$exploded_value									= explode('-',$slug);
				$anonymous_data['AnonymousUsers']['slug'] 	 	= $slug;
				$anonymous_data['AnonymousUsers']['usertype'] 	= isset($this->request->data['type'])?$this->request->data['type']:'individual';
				$anonymous_data['AnonymousUsers']['unique_id'] 	= $exploded_value[1];
				
				$this->request->data['name']				= ucwords($slug);
				$this->request->data['email']				= $slug.'@learneron.net';
				$this->request->data['full_name']			= 'Anonymous User';
			}
				$this->request->data['profile_pic']			= 'user_no_image.png';
				$this->request->data['location']			= '';
				$this->request->data['title']				= '';
				$this->request->data['birthday']			= '';
				$this->request->data['about_me']			= '';
				$this->request->data['signup_string']		= '';
				$this->request->data['type']				= 'N';
				$this->request->data['facebook_id']			= '';
				$this->request->data['googleplus_id']		= '';
				$this->request->data['twitter_id']			= '';
				$this->request->data['linkedin_id']		= '';
				$this->request->data['facebook_link']		= '';
				$this->request->data['twitter_link']		= '';
				$this->request->data['gplus_link']			= '';
				$this->request->data['linkedin_link']		= '';
				
			$AnonymousUserNewEntity = $AnonymousUserTable->newEntity();
			$anonymous_insert_data = $AnonymousUserTable->patchEntity($AnonymousUserNewEntity, $anonymous_data);
			if($AnonymousUserTable->save($anonymous_insert_data)){		
				$ids = $this->request->data['id'];
				
				$UsersTable->updateAll(['name'=>$this->request->data['name'],'email'=>$this->request->data['email'],'full_name'=>$this->request->data['full_name'],'profile_pic'=>$this->request->data['profile_pic'],'location'=>$this->request->data['location'],'title'=>$this->request->data['title'],'birthday'=>$this->request->data['birthday'],'facebook_id'=>$this->request->data['facebook_id'],'googleplus_id'=>$this->request->data['googleplus_id'],'twitter_id'=>$this->request->data['twitter_id'],'linkedin_id'=>$this->request->data['linkedin_id'],'facebook_link'=>$this->request->data['facebook_link'],'twitter_link'=>$this->request->data['twitter_link'],'gplus_link'=>$this->request->data['gplus_link'],'linkedin_link'=>$this->request->data['linkedin_link']], ['Users.id'=>$this->request->data['id']]);
				
				echo json_encode(array('type' => 'success', 'message' => "You have made that user as Anonymous successfully"));
			}else{
				$ids = '';
				echo json_encode(array('type' => 'error', 'message' => "You have already made that user as Anonymous"));
			}
		}else{
			$count = $AnonymousUserTable->find('all',['conditions'=>['AnonymousUsers.user_id'=>$this->request->data['id']]])->first();			
			if( $count->usertype != $this->request->data['type'] ){
				$id = $this->request->data['id'];
				$UsersTable = TableRegistry::get('Admin.Users');
				$user = $UsersTable->get($id);
				
				if($this->request->data['type'] == 'group'){
					$anonymous_data['AnonymousUsers']['usertype'] 	= isset($this->request->data['type'])?$this->request->data['type']:'group';
					$anonymous_data['AnonymousUsers']['slug'] 	 	= 'Anonymous Group';
					
					$this->request->data['name']					= ucwords('Anonymous Group');
					$this->request->data['email']					= 'anonymousgroup@learneron.net';
					$this->request->data['full_name']				= 'Anonymous Group';
				}
				else if($this->request->data['type'] == 'individual'){
					$slug											= $AnonymousUserTable->createSlug('Anonymous');
					$exploded_value									= explode('-',$slug);
					$anonymous_data['AnonymousUsers']['slug'] 	 	= $slug;
					$anonymous_data['AnonymousUsers']['usertype'] 	= isset($this->request->data['type'])?$this->request->data['type']:'individual';
					$anonymous_data['AnonymousUsers']['unique_id'] 	= $exploded_value[1];
					
					$this->request->data['name']					= ucwords($slug);
					$this->request->data['email']					= $slug.'@learneron.net';
					$this->request->data['full_name']				= 'Anonymous User';
				}
					$this->request->data['signup_string']			= '';
					
					$UsersTable->updateAll(['name'=>$this->request->data['name'],'email'=>$this->request->data['email'],'full_name'=>$this->request->data['full_name'],'signup_string'=>$this->request->data['signup_string']], ['Users.id'=>$this->request->data['id']]);
				
					$updated = $AnonymousUserTable->patchEntity($count, $anonymous_data);
					$AnonymousUserTable->save($updated);
				
				echo json_encode(array('type' => 'success', 'message' => "You have made that user as Anonymous successfully"));
			}
			else{
				$ids = '';
				echo json_encode(array('type' => 'error', 'message' => "You have already made that user as Anonymous"));
			}			
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
