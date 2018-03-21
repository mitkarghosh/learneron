<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class QuestionAnswersController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
		$this->loadComponent('Admin.AdminEmail');
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'QuestionAnswers', 'action' => 'listData']);
    }

    public function listData($page = NULL){
		try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('QuestionAnswers'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('QuestionAnswers')))) || $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
			$QuestionTable = TableRegistry::get('Questions');
            // ************** start search filter **************** //
            if($this->request->query('search') != NULL){
				$options['conditions'][] = array('QuestionAnswers.learning_path_recommendation LIKE' => '%'.$this->request->query('search').'%');
			}
			if($this->request->query('search_by') != NULL){				
				$questions = $QuestionTable->find('list', ['conditions'=>['Questions.name LIKE' => '%'.trim($this->request->query('search_by')).'%'], 'fields'=>['Questions.id']])->toArray();				
				$options['conditions'][] = array('question_id IN' => $questions);
			}
			if($this->request->query('search_by_answerid') != NULL){				
				$options['conditions'][] = array('QuestionAnswers.id' => $this->request->query('search_by_answerid'));
			}
			// *********** end of search filter *********************** //
			
			$options['contain'] = ['Users'=>['fields'=>['id','name']],'Questions'=>['fields'=>['id','user_id','name']],'AnswerComment'=>['conditions'=>['status'=>0],'fields'=>['id','user_id','question_id','answer_id','status']]];
			$options['fields'] = ['QuestionAnswers.id','QuestionAnswers.question_id','QuestionAnswers.user_id','QuestionAnswers.learning_path_recommendation','QuestionAnswers.status','QuestionAnswers.created','QuestionAnswers.question_id'];
			$options['order'] = array('QuestionAnswers.id DESC');
            $options['limit'] = $this->paginationLimit;
			$answer_details = $this->paginate($this->QuestionAnswers, $options)->toArray();
			
			$all_questions = $QuestionTable->find('list', ['conditions'=>[], 'keyField'=>'id','valueField'=>'name'])->toArray();
			$all_question_answer_ids = $this->QuestionAnswers->find('list',['keyFields'=>['id'],'valueFields'=>['id']])->toArray();
			
			$this->set(compact('answer_details','all_questions','all_question_answer_ids'));
            $this->set('_serialize', ['answer_details','all_questions']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }
	
	public function editQuestionAnswer($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionAnswers'))) || (!array_key_exists('edit-question-answer',$session->read('permissions.'.strtolower('QuestionAnswers')))) || $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('edit-question-answer'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$id = base64_decode($id);
		$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
		$existing_data =  $QuestionAnswersTable->get($id,['contain'=>['Users'=>['fields'=>['id','name','email']]]]);
		if($this->request->is(['post', 'put'])){
			$query = $QuestionAnswersTable->query();
			$query->update()
				->set(['learning_path_recommendation'=>$this->request->data['learning_path_recommendation'],'learning_experience'=>$this->request->data['learning_experience'],'learning_utility'=>$this->request->data['learning_utility'],'status'=>$this->request->data['status'],'modified'=>date('Y-m-d H:i:s')])
				->where(['id'=>$id])
				->execute();
			$this->Flash->success(__('Answer has been successfully updated'));
			return $this->redirect(['plugin' => 'admin','controller' => 'question-answers','action' => 'list-data']);            
        }
        $this->set(compact('existing_data'));
        $this->set('_serialize', ['existing_data']);
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
			$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
            $questionanswerDetails = $QuestionAnswersTable->get($id,['contain'=>['Users'=>['fields'=>['id','name','email']]]])->toArray();
			echo json_encode(array('type' => 'success', 'message' => 'Content data found', 'data' => $questionanswerDetails));
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

    public function changeStatus(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionAnswers'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionAnswers')))) || $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('change-status'))!=1) ){
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
			$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');				
			if($this->request->data['status'] == 'I'){	//request for making this answer as inactive
				$QuestionAnswersTable->updateAll(['status'=>'I'],  ['QuestionAnswers.id IN' => $id]);
				echo json_encode(array('type' => 'success', 'message' => 'Answer has been successfully inactivated'));				
			}else if($this->request->data['status'] == 'A'){
				$QuestionAnswersTable->updateAll(['status'=>'A'],  ['QuestionAnswers.id IN' => $id]);
				echo json_encode(array('type' => 'success', 'message' => 'Answer has been successfully activated'));
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
			}				
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }

    public function deleteQuestionAnswer($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionAnswers'))) || (!array_key_exists('delete-question-answer',$session->read('permissions.'.strtolower('QuestionAnswers')))) || $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('delete-question-answer'))!=1) ){
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
			$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
			$data = $QuestionAnswersTable->find('all')->where(['QuestionAnswers.id'=>$id])->count();
			if( $data > 0 ){
				$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
				$AnswerCommentTable->deleteAll(['AnswerComment.answer_id' => $id]);
				
				$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
				$AnswerUpvoteTable->deleteAll(['AnswerUpvote.answer_id' => $id]);
				
				$QuestionAnswersTable->deleteAll(['id IN' => $id]);
				
				echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Answer successfully deleted'));
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
		if( (empty($session->read('permissions.'.strtolower('QuestionAnswers'))) || (!array_key_exists('delete-question-answer',$session->read('permissions.'.strtolower('QuestionAnswers')))) || $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('delete-question-answer'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        //Set the layout.
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
			foreach($this->request->data['id'] as $val_id){
				$data = $QuestionAnswersTable->find('all')->where(['QuestionAnswers.id'=>$val_id])->count();
				if( $data > 0 ){
					$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
					$AnswerCommentTable->deleteAll(['AnswerComment.answer_id' => $val_id]);
					
					$AnswerUpvoteTable = TableRegistry::get('Admin.AnswerUpvote');
					$AnswerUpvoteTable->deleteAll(['AnswerUpvote.answer_id' => $val_id]);
					
					$QuestionAnswersTable->deleteAll(['id IN' => $val_id]);
				}
			}
			echo json_encode(array('type' => 'success', 'deleted_ids' => $this->request->data['id'], 'delete_count' => 1, 'message' => 'Answer(s) successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'Some error occured'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionAnswers'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionAnswers')))) || $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
		if(!empty($this->request->data['id'])){
			$QuestionAnswersTable->updateAll(['status'=>'A'],  ['QuestionAnswers.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('QuestionAnswers'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionAnswers')))) || $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);		
		if(!empty($this->request->data['id'])){
			$QuestionAnswersTable = TableRegistry::get('Admin.QuestionAnswers');
			if(!empty($this->request->data['id'])){
				$QuestionAnswersTable->updateAll(['status'=>'I'],  ['QuestionAnswers.id IN' => $this->request->data['id']]);
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