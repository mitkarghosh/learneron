<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class QuestionCommentsController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
		$this->loadComponent('Admin.AdminEmail');
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'QuestionComments', 'action' => 'listData']);
    }

    public function listData($page = NULL){
		try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('QuestionComments'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('QuestionComments')))) || $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
			$QuestionTable = TableRegistry::get('Questions');
            // ************** start search filter **************** //
            if($this->request->query('search') != NULL){
				$options['conditions'][] = array('QuestionComments.comment LIKE' => '%'.$this->request->query('search').'%');
			}
			if($this->request->query('search_by') != NULL){
				$questions = $QuestionTable->find('list', ['conditions'=>['Questions.name LIKE' => '%'.trim($this->request->query('search_by')).'%'], 'fields'=>['Questions.id']])->toArray();
				$options['conditions'][] = array('question_id IN' => $questions);
			}
			if($this->request->query('search_by_id') != NULL){
				$questions = $QuestionTable->find('list', ['conditions'=>['Questions.id' => $this->request->query('search_by_id')], 'fields'=>['Questions.id']])->toArray();
				$options['conditions'][] = array('question_id IN' => $questions);
			}
			if( $this->request->query('search_by_commentuser') != NULL){
				$options['conditions'][] = array('QuestionComments.user_id' => $this->request->query('search_by_commentuser'));				
			}
			if( $this->request->query('search_by_commentid') != NULL){
				$options['conditions'][] = array('QuestionComments.id' => $this->request->query('search_by_commentid'));				
			}
			// *********** end of search filter *********************** //
			$QuestionCommentTable = TableRegistry::get('Admin.QuestionComments');
			$options['contain'] = ['Users'=>['fields'=>['id','name']],'Questions'=>['fields'=>['id','user_id','name']]];
			$options['fields'] = ['QuestionComments.id','QuestionComments.question_id','QuestionComments.user_id','QuestionComments.comment','QuestionComments.status','QuestionComments.created'];
			$options['order'] = array('QuestionComments.id DESC');
            $options['limit'] = $this->paginationLimit;
			$comment_details = $this->paginate($QuestionCommentTable, $options)->toArray();
			
			/*$QuestionTable = TableRegistry::get('Questions');
			$all_questions = $QuestionTable->find('list', ['conditions'=>[], 'keyField'=>'id','valueField'=>'name'])->toArray();*/
			
			/*$questionCommentUsers = $QuestionCommentTable->find('all', ['contain'=>['Users'=>['fields'=>['id','name']]],'fields'=>['id','user_id']])->toArray();
			$question_comment_users = array();
			if(!empty($questionCommentUsers)){
				foreach($questionCommentUsers as $val){
					if($val['user_id']!=0){
						$question_comment_users[$val['user']['id']] = $val['user']['name'];
					}
				}
				asort($question_comment_users);
			}*/
			$usersTable = TableRegistry::get('Admin.Users');
			$question_comment_users = $usersTable->find('all',['conditions'=>['status'=>'A'],'fields'=>['id','full_name','name'],'order'=>'name asc'])->toArray();
			$all_question_comment_id = $this->QuestionComments->find('list',['keyFields'=>['id'],'valueFields'=>['id']])->toArray();
			$this->set(compact('comment_details','all_questions','question_comment_users','all_question_comment_id'));
            $this->set('_serialize', ['comment_details','all_questions']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }
	
	public function editComment($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionComments'))) || (!array_key_exists('edit-comment',$session->read('permissions.'.strtolower('QuestionComments')))) || $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('edit-comment'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$QuestionCommentTable = TableRegistry::get('Admin.QuestionComments');
        $id = base64_decode($id);
        $existing_data = $QuestionCommentTable->get($id,['contain'=>['Users'=>['fields'=>['id','name','email']]]]);
		if ($this->request->is(['post', 'put'])) {
			$updated_data = $QuestionCommentTable->patchEntity($existing_data, $this->request->data);
			$this->loadModel('QuestionComment');
            if ($savedData = $this->QuestionComment->save($updated_data)) {
                $this->Flash->success(__('Comment has been successfully updated.'));
                return $this->redirect(['plugin' => 'admin','controller' => 'question-comments','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Comment is not updated.'));
            }
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
			$this->loadModel('QuestionComment');
            $questionCommentDetails = $this->QuestionComment->get($id,['contain'=>['Users'=>['fields'=>['id','name','email']]]])->toArray();
			$comment = html_entity_decode($questionCommentDetails['comment']);
			echo json_encode(array('type' => 'success', 'message' => 'Content data found', 'data' => $questionCommentDetails, 'comment' => $comment));
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
		if( (empty($session->read('permissions.'.strtolower('QuestionComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionComments')))) || $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('change-status'))!=1) ){
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
			$QuestionCommentTable = TableRegistry::get('Admin.QuestionComments');
			//pr($this->request->data); die;
			if($this->request->data['status'] == 0){	//request for making this Comment as inactive
				$QuestionCommentTable->updateAll(['status'=>'0'], ['id IN' => $id]);
				echo json_encode(array('type' => 'success', 'message' => 'Comment has been successfully inactivated'));				
			}else if($this->request->data['status'] == 1){
				$QuestionCommentTable->updateAll(['status'=>'1'], ['id IN' => $id]);
				echo json_encode(array('type' => 'success', 'message' => 'Comment has been successfully activated'));
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
			}				
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }

    public function deleteComment($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionComments'))) || (!array_key_exists('delete-comments',$session->read('permissions.'.strtolower('QuestionComments')))) || $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('delete-comment'))!=1) ){
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
			$QuestionCommentTable = TableRegistry::get('Admin.QuestionComments');
			$QuestionCommentTable->deleteAll(['id IN' => $id]);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Comment successfully deleted'));				
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }

    public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionComments'))) || (!array_key_exists('delete-comments',$session->read('permissions.'.strtolower('QuestionComments')))) || $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('delete-comment'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        //Set the layout.
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$QuestionCommentTable = TableRegistry::get('Admin.QuestionComments');
			$QuestionCommentTable->deleteAll(['id IN' => $this->request->data['id']]);			
			echo json_encode(array('type' => 'success', 'deleted_ids' => $this->request->data['id'], 'delete_count' => 1, 'message' => 'Comment(s) successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionComments')))) || $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$QuestionCommentTable = TableRegistry::get('Admin.QuestionComments');
		if(!empty($this->request->data['id'])){
			$QuestionCommentTable->updateAll(['status'=>1],  ['QuestionComments.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('QuestionComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionComments')))) || $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);		
		if(!empty($this->request->data['id'])){
			$QuestionCommentTable = TableRegistry::get('Admin.QuestionComments');
			if(!empty($this->request->data['id'])){
				$QuestionCommentTable->updateAll(['status'=>'I'],  ['QuestionComments.id IN' => $this->request->data['id']]);
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