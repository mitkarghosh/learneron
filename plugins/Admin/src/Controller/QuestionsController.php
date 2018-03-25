<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class QuestionsController extends AppController{
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
		$this->loadComponent('Admin.AdminEmail');		
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'Questions', 'action' => 'listData']);
    }

    public function listData($page = NULL){
		try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('Questions'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('Questions')))) || $session->read('permissions.'.strtolower('Questions').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
            // ************** start search filter **************** //
            if($this->request->query('search') != NULL){
				$options['conditions'][] = array('Questions.name LIKE' => '%'.$this->request->query('search').'%');
			}
			if($this->request->query('search_by') != NULL){
				$options['conditions'][] = array('Questions.category_id' => $this->request->query('search_by'));
			}
			if( $this->request->query('created') != NULL){
				$date_format = date('Y-m-d',strtotime($this->request->query('created')));
				$options['conditions'][] = array('Questions.created LIKE' => $date_format.'%');
			}
			if( $this->request->query('search_by_user') != NULL){
				$options['conditions'][] = array('Questions.user_id' => $this->request->query('search_by_user'));
			}
			if( $this->request->query('search_by_id') != NULL){
				$options['conditions'][] = array('Questions.id' => $this->request->query('search_by_id'));
			}
			// *********** end of search filter *********************** //
			
			$options['contain'] = ['QuestionCategories','QuestionTags.Tags'=>['fields'=>['Tags.id','Tags.title']],'QuestionAnswers'=>['conditions'=>['QuestionAnswers.status'=>'I'],'fields'=>['QuestionAnswers.id','QuestionAnswers.question_id','QuestionAnswers.learning_path_recommendation','QuestionAnswers.status']],'QuestionComments'=>['conditions'=>['QuestionComments.status'=>0],'fields'=>['QuestionComments.id','QuestionComments.question_id','QuestionComments.comment','QuestionComments.status']]];
            $options['fields'] = ['Questions.id','Questions.name','Questions.is_featured','Questions.created','Questions.status','QuestionCategories.id','QuestionCategories.name'];
			$options['order'] = array('Questions.id DESC');
            $options['limit'] = $this->paginationLimit;
			$question_details = $this->paginate($this->Questions, $options);
			$question_categories = $this->getQuestionCategories();			
			
			//$get_all_submitted_user = $this->Questions->find('all',['contain'=>['Users'=>['fields'=>['Users.id','Users.full_name','Users.name']]],'fields'=>['id','user_id'],'group'=>['Users.id']])->toArray();
			$usersTable = TableRegistry::get('Admin.Users');
			$get_all_submitted_user = $usersTable->find('all',['conditions'=>['status'=>'A'],'fields'=>['id','full_name','name'],'order'=>'name asc'])->toArray();
			$get_all_questions_ids = $this->Questions->find('list',['keyFields'=>['id'],'valueFields'=>['id']])->toArray();
			$this->set(compact('question_details','question_categories','get_all_submitted_user','get_all_questions_ids'));
            $this->set('_serialize', ['question_details']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }
	
	//View method
    public function view($id = NULL){
		$this->viewBuilder()->layout = false;
		$this->render(false);
		$session = $this->request->session();		
        $this->request->allowMethod(['post','ajax']);
        if($this->request->is('ajax')){            
            if($id == NULL){
                echo json_encode(array('type' => 'error', 'message' => 'invalid id'));
                exit();
            }
            $questionDetails = $this->Questions->get($id,['contain'=>['Users'=>['fields'=>['id','name','email']]]])->toArray();
			$name = html_entity_decode($questionDetails['name']);
			$short_description = html_entity_decode($questionDetails['short_description']);
			$learning_goal = html_entity_decode($questionDetails['learning_goal']);			
			echo json_encode(array('type' => 'success', 'message' => 'Content Category data found', 'data' => $questionDetails, 'name' => $name, 'short_description' => $short_description, 'learning_goal' => $learning_goal));
            exit();
        }else{
            throw new NotFoundException(__('Page not found'));
        }
    }
	public function replyUser($message = NULL){
		$session = $this->request->session();
		$this->viewBuilder()->layout(false);
		$this->render(false);
		if($this->request->is('post')){
			$submitter_name = isset($this->request->data['submitter_name'])?$this->request->data['submitter_name']:0;
			$email = isset($this->request->data['email'])?$this->request->data['email']:'';
			$message = isset($this->request->data['message'])?$this->request->data['message']:'';
			if($submitter_name == ''){
				throw new NotFoundException(__('Page not found'));
			}			
			$settings = $this->getSiteSettings();
			$url = Router::url('/', true).'view-submissions';
            if($this->AdminEmail->replyQuestionSubmittedUser($url,$submitter_name,$email,$message,$settings)){				
                echo json_encode(['status'=>'mail_sent']);
				exit();
            }else{
                echo json_encode(['status'=>'failed']);
				exit();
            }
        }
    }

    public function addQuestion(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Questions'))) || (!array_key_exists('add-question',$session->read('permissions.'.strtolower('Questions')))) || $session->read('permissions.'.strtolower('Questions').'.'.strtolower('add-question'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$QuestionTable = TableRegistry::get('Admin.Questions');
		$question_categories = $this->getQuestionCategories();
		$TagsTable = TableRegistry::get('Admin.Tags');
		$all_tags = $TagsTable->find('list', ['conditions'=>['Tags.status'=>'A'], 'keyField'=>'id','valueField'=>'title'])->toArray();
		$new_question = $QuestionTable->newEntity();
		if ($this->request->is('post','put')){
			//$this->request->data['user_id'] 	= $this->Auth->user('id');
			$this->request->data['user_type'] 	= 'A';
			$inserted_data = $QuestionTable->patchEntity($new_question, $this->request->data);
			if($savedData = $QuestionTable->save($inserted_data)){
				$get_last_insert_id = $savedData->id;
				if(!empty($this->request->data['tags'])){
					$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
					foreach( $this->request->data['tags'] as $key_tag_data => $val_tag_data ){
						$tag_data['QuestionTags']['question_id'] = $get_last_insert_id;
						//$tag_data['QuestionTags']['user_id'] = $this->Auth->user('id');
						$tag_data['QuestionTags']['tag_id'] = $val_tag_data;
						$TagNewEntity = $QuestionTagsTable->newEntity();
						$inserted_data = $QuestionTagsTable->patchEntity($TagNewEntity, $tag_data);
						$QuestionTagsTable->save($inserted_data);						
					}
				}
				$this->Flash->success(__('New question has been successfully created'));
                return $this->redirect(['plugin' => 'admin','controller' => 'questions','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Question is not created.'));
            }
        }
        $this->set(compact('new_question','question_categories','all_tags'));
        $this->set('_serialize', ['new_question']);
    }
    
    public function editQuestion($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Questions'))) || (!array_key_exists('edit-question',$session->read('permissions.'.strtolower('Questions')))) || $session->read('permissions.'.strtolower('Questions').'.'.strtolower('edit-question'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$id = base64_decode($id);
		$QuestionsTable = TableRegistry::get('Admin.Questions');
		$question_categories = $this->getQuestionCategories();
		$TagsTable = TableRegistry::get('Admin.Tags');
		$all_tags = $TagsTable->find('list', ['conditions'=>['Tags.status'=>'A'], 'keyField'=>'id','valueField'=>'title'])->toArray();
		$existing_data =  $QuestionsTable->get($id,['contain'=>['Users'=>['fields'=>['id','name']], 'QuestionCategories'=>['fields'=>['id','name']], 'QuestionTags'=>['fields'=>['id','question_id','tag_id']]]]);
		if($this->request->is(['post', 'put'])){
			if($this->request->data['is_featured'] != 0){$this->request->data['is_featured'] = 'Y';}else{$this->request->data['is_featured'] = 'N';}
			$new_question = $QuestionsTable->newEntity();
			$inserted_data = $QuestionsTable->patchEntity($existing_data, $this->request->data);
			$send_data = $QuestionsTable->patchEntity($existing_data, $this->request->data);
			if ($savedData = $QuestionsTable->save($inserted_data)) {
				$get_last_insert_id = $savedData->id;
				$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
				$question_tags_data = $QuestionTagsTable->find('list', ['conditions'=>array('QuestionTags.question_id'=>$id),'fields' => ['QuestionTags.id']])->toArray();
				$QuestionTagsTable->deleteAll(['id IN' => $question_tags_data]);
				if(!empty($this->request->data['tags'])){
					$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
					foreach( $this->request->data['tags'] as $key_tag_data => $val_tag_data ){
						$tag_data['QuestionTags']['question_id'] = $get_last_insert_id;
						//$tag_data['QuestionTags']['user_id'] = $this->request->data['user_id'];
						$tag_data['QuestionTags']['tag_id'] = $val_tag_data;
						$TagNewEntity = $QuestionTagsTable->newEntity();
						$inserted_data = $QuestionTagsTable->patchEntity($TagNewEntity, $tag_data);
						$QuestionTagsTable->save($inserted_data);
					}
				}				
				//sending notification to the question submitter person
				if($this->request->data['status'] == 'A'){
					if($send_data['user_type'] == 'U' && $send_data['user_id'] != NULL){
						$get_data = $this->getAccountSetting($send_data['user_id']);
						if(!empty($get_data) && ($get_data->response_to_my_question_notification==1)){
							$UserTable = TableRegistry::get('Admin.Users');
							$user_data = $UserTable->find('all', ['conditions'=>['id'=>$send_data['user_id']],'fields'=>['id','name','email','full_name','notification_email']])->first()->toArray();
							if(!empty($user_data)){
								$url = Router::url('/', true).'questions/details/'.base64_encode($get_last_insert_id);
								$settings = $this->getSiteSettings();
								if($user_data['notification_email'] != '')$user_email = $user_data['notification_email']; else $user_email = $user_data['email'];
								$this->AdminEmail->questionEditNotification($url, $user_email, $user_data, $this->request->data, $settings);
							}
						}
					}
				}
				//sending notification to the question submitter person
                $this->Flash->success(__('Question has been successfully updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'questions','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Question is not updated.'));
            }
        }
        $this->set(compact('existing_data','questions','question_categories','all_tags'));
        $this->set('_serialize', ['existing_data']);
    }
	
	public function changeStatus(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Questions'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Questions')))) || $session->read('permissions.'.strtolower('Questions').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'ajax', 'put']);
		$id = isset($this->request->data['id'])?$this->request->data['id']:'';
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		if($id != ''){
			$QuestionsTable = TableRegistry::get('Admin.Questions');				
			$QuestionsNewEntity = $QuestionsTable->newEntity();
			if($this->request->data['status'] == 'I'){	//request for making this question as inactive
				$update_data = $QuestionsTable->patchEntity($QuestionsNewEntity, $this->request->data);
				if($QuestionsTable->save($update_data)){
					echo json_encode(array('type' => 'success', 'message' => 'Question successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else if($this->request->data['status'] == 'A'){
				$update_data = $QuestionsTable->patchEntity($QuestionsNewEntity, $this->request->data);
				if($QuestionsTable->save($update_data)){
					echo json_encode(array('type' => 'success', 'message' => 'Question successfully activated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
			}				
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }

    public function deleteQuestion($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Questions'))) || (!array_key_exists('delete-question',$session->read('permissions.'.strtolower('Questions')))) || $session->read('permissions.'.strtolower('Questions').'.'.strtolower('delete-question'))!=1) ){
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
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			$question_data = $QuestionsTable->find('all')->where(['Questions.id'=>$id])->count();
			if( $question_data > 0 ){
				$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
				$QuestionTagsTable->deleteAll(['QuestionTags.question_id' => $id]);
				
				$QuestionCommentsTable = TableRegistry::get('Admin.QuestionComments');
				$QuestionCommentsTable->deleteAll(['QuestionComments.question_id' => $id]);
				
				$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
				$QuestionAnswersTable->deleteAll(['QuestionAnswers.question_id' => $id]);
				
				$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
				$AnswerCommentTable->deleteAll(['AnswerComment.question_id' => $id]);
				
				$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
				$AnswerUpvoteTable->deleteAll(['AnswerUpvote.question_id' => $id]);
				
				$question_data = $QuestionsTable->get($id);
				$QuestionsTable->delete($question_data);
				echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Question successfully deleted'));
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
			}			
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }

    public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Questions'))) || (!array_key_exists('delete-question',$session->read('permissions.'.strtolower('Questions')))) || $session->read('permissions.'.strtolower('Questions').'.'.strtolower('delete-question'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        //Set the layout.
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$deleted_question_count = 0; $deleted_question_ids = array();
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
			$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
			$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
			$QuestionCommentsTable = TableRegistry::get('Admin.QuestionComments');
			$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
			$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
			foreach($this->request->data['id'] as $val_id){
				$QuestionTagsTable->deleteAll(['QuestionTags.question_id' => $val_id]);
				$QuestionAnswersTable->deleteAll(['QuestionAnswers.question_id' => $val_id]);				
				$QuestionCommentsTable->deleteAll(['QuestionComments.question_id' => $id]);
				$AnswerCommentTable->deleteAll(['AnswerComment.question_id' => $id]);				
				$AnswerUpvoteTable->deleteAll(['AnswerUpvote.question_id' => $id]);
				
				$question_data = $QuestionsTable->get($val_id);
				$QuestionsTable->delete($question_data);
				$deleted_question_ids[] = $val_id;
				$deleted_question_count++;
			}
			if( (count($this->request->data['id']) == $deleted_question_count) ){
				echo json_encode(array('type' => 'success', 'deleted_ids' => $deleted_question_ids, 'delete_count' => '1', 'message' => 'Question(s) successfully deleted'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'deleted_ids' => $deleted_question_ids, 'delete_count' => '2', 'message' => 'Selected question(s) successfully deleted'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Questions'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Questions')))) || $session->read('permissions.'.strtolower('Questions').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$QuestionsTable = TableRegistry::get('Admin.Questions');
		if(!empty($this->request->data['id'])){
			$QuestionsTable->updateAll(['status'=>'A'],  ['Questions.id IN' => $this->request->data['id']]);
			$ids = $this->request->data['id'];			
			echo json_encode($ids);
		}else{
			$ids = '';
			echo $ids;
		}
        exit();
    }
    
    public function inactiveMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Questions'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Questions')))) || $session->read('permissions.'.strtolower('Questions').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);		
		if(!empty($this->request->data['id'])){
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			if(!empty($this->request->data['id'])){
				$QuestionsTable->updateAll(['status'=>'I'],  ['Questions.id IN' => $this->request->data['id']]);
				$ids = $this->request->data['id'];			
				echo json_encode($ids);
			}else{
				$ids = '';
				echo $ids;
			}
		}else{
			$ids = '';
			echo $ids;
		}
		exit();
    }
}