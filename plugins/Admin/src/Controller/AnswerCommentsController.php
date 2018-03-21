<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class AnswerCommentsController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'AnswerComments', 'action' => 'listData']);
    }

    public function listData($answer_id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AnswerComments'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('AnswerComments')))) || $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('list-data'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$answer_id = base64_decode($answer_id);
		if($answer_id == ''){
			$this->redirect(['plugin' => 'admin', 'controller' => 'QuestionAnswers', 'action' => 'listData']);
		}
		try{
			$options = array();
            // ************** start search filter **************** //
            if($this->request->query('search') != NULL){
				$options['conditions'][] = array('AnswerComment.comment LIKE' => '%'.$this->request->query('search').'%');
			}
			if($this->request->query('search_by_commentuser') != NULL){
				$options['conditions'][] = array('AnswerComment.user_id' => $this->request->query('search_by_commentuser'));
			}
			if($this->request->query('search_by_id') != NULL){
				$options['conditions'][] = array('AnswerComment.id' => $this->request->query('search_by_id'));
			}
			$options['conditions'][] = array('AnswerComment.answer_id'=>$answer_id);
			// *********** end of search filter *********************** //
			$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');			
			$options['contain'] = ['CommentUsers'=>['fields'=>['id','name']]];			
			$options['order'] = array('AnswerComment.id DESC');
			$options['limit'] = $this->paginationLimit;
			$comment_details = $this->paginate($AnswerCommentTable, $options)->toArray();
			
			//$get_all_questions = $AnswerCommentTable->find('all',['contain'=>['Questions'=>['fields'=>['Questions.id','Questions.name']],'Users'=>['fields'=>['Users.id','Users.full_name']],'CommentUsers'=>['fields'=>['CommentUsers.id','CommentUsers.full_name']],'QuestionAnswers'=>['fields'=>['QuestionAnswers.id','QuestionAnswers.learning_path_recommendation']]],'fields'=>['id','user_id','answer_id','answer_user_id','question_id']])->toArray();
			$get_all_questions = $AnswerCommentTable->find('all',['contain'=>['CommentUsers'=>['fields'=>['CommentUsers.id','CommentUsers.full_name']]],'conditions'=>['AnswerComment.answer_id'=>$answer_id],'fields'=>['id','user_id','answer_id','answer_user_id','question_id']])->toArray();
			//pr($get_all_questions); die;
			
			$question_answers = array(); $comment_users = array(); $answer_users = array(); $questions = array(); $all_com_ids = array();
			if(!empty($get_all_questions)){
				foreach($get_all_questions as $key_gaq => $val_gaq){
					$all_com_ids[] = $val_gaq->id;
					/*if(!empty($val_gaq['question_answer'])){
						$question_answers[$val_gaq['question_answer']['id']] = substr(strip_tags($val_gaq['question_answer']['learning_path_recommendation']), 0, 30).'...';
					}*/
					/* blocked to get all users
					if(!empty($val_gaq['comment_user'])){
						if($val_gaq['comment_user']['full_name'] != ''){
							$comment_users[$val_gaq['comment_user']['id']] = $val_gaq['comment_user']['full_name'];
						}						
					} end here*/
					/*if(!empty($val_gaq['user'])){
						if($val_gaq['user']['full_name'] != ''){
							$answer_users[$val_gaq['user']['id']] = $val_gaq['user']['full_name'];
						}						
					}
					if(!empty($val_gaq['question'])){
						$questions[$val_gaq['question']['id']] = $val_gaq['question']['name'];						
					}*/
				}
			}
			$usersTable = TableRegistry::get('Admin.Users');
			$comment_users = $usersTable->find('all',['conditions'=>['status'=>'A'],'fields'=>['id','full_name','name'],'order'=>'name asc'])->toArray();
			$this->set(compact('answer_id','comment_details','question_answers','comment_users','answer_users','questions','all_com_ids'));
            $this->set('_serialize', ['comment_details']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }
	
	public function editAnswerComment($id = NULL, $answerid = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AnswerComments'))) || (!array_key_exists('edit-answer-comment',$session->read('permissions.'.strtolower('AnswerComments')))) || $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('edit-answer-comment'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$id = base64_decode($id);
		$answerid = base64_decode($answerid);
		$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
		$existing_data =  $AnswerCommentTable->get($id,['contain'=>['CommentUsers'=>['fields'=>['id','name']]]]);
		//pr($existing_data); die;
		if($this->request->is(['post', 'put'])){
			$query = $AnswerCommentTable->query();
			$query->update()
				->set(['comment'=>$this->request->data['comment'],'status'=>$this->request->data['status'],'modified'=>date('Y-m-d H:i:s')])
				->where(['id'=>$id])
				->execute();
			$this->Flash->success(__('Answer comment has been successfully updated'));
			return $this->redirect(['plugin' => 'admin','controller' => 'answer-comments','action' => 'list-data',base64_encode($answerid)]);            
        }
        $this->set(compact('existing_data','answerid'));
        $this->set('_serialize', ['existing_data']);
    }

    public function changeStatus(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AnswerComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('AnswerComments')))) || $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('change-status'))!=1) ){
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
			$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');				
			if($this->request->data['status'] == 0){	//request for making this comment as inactive
				$AnswerCommentTable->updateAll(['status'=>0],  ['AnswerComment.id IN' => $id]);
				echo json_encode(array('type' => 'success', 'message' => 'Comment has been successfully inactivated'));
			}else if($this->request->data['status'] == 1){
				$AnswerCommentTable->updateAll(['status'=>1],  ['AnswerComment.id IN' => $id]);
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
		if( (empty($session->read('permissions.'.strtolower('AnswerComments'))) || (!array_key_exists('delete-comment',$session->read('permissions.'.strtolower('AnswerComments')))) || $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('delete-comment'))!=1) ){
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
			$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
			$AnswerCommentTable->deleteAll(['AnswerComment.id IN' => $id]);
				
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Comment successfully deleted'));
			
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }

    public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AnswerComments'))) || (!array_key_exists('delete-comment',$session->read('permissions.'.strtolower('AnswerComments')))) || $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('delete-comment'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        //Set the layout.
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
			$AnswerCommentTable->deleteAll(['AnswerComment.id IN' => $this->request->data['id']]);
			echo json_encode(array('type' => 'success', 'deleted_ids' => $this->request->data['id'], 'delete_count' => 1, 'message' => 'Comment(s) successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'Some error occured'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('AnswerComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('AnswerComments')))) || $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
		if(!empty($this->request->data['id'])){
			$AnswerCommentTable->updateAll(['status'=>1], ['AnswerComment.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('AnswerComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('AnswerComments')))) || $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);		
		if(!empty($this->request->data['id'])){
			$AnswerCommentTable = TableRegistry::get('Admin.AnswerComment');
			if(!empty($this->request->data['id'])){
				$AnswerCommentTable->updateAll(['status'=>0], ['AnswerComment.id IN' => $this->request->data['id']]);
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