<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");

class NewsCommentsController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
		$this->loadComponent('Admin.AdminEmail');
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'NewsComments', 'action' => 'listData']);
    }

	public function listData(){
		try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('NewsComments'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('NewsComments')))) || $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
			$options = array();
            // ************** start search filter **************** //
			if($this->request->query('search') != NULL){
				$options['conditions'][] = array('NewsComments.comment LIKE' => '%'.$this->request->query('search').'%');
			}
			if($this->request->query('search_by') != NULL){
				$options['conditions'][] = array('NewsComments.news_id' => $this->request->query('search_by'));
			}
			if( $this->request->query('created') != NULL){
				$date_format = date('Y-m-d',strtotime($this->request->query('created')));
				$options['conditions'][] = array('NewsComments.created LIKE' => $date_format.'%');
			}
			if( $this->request->query('search_by_commentuser') != NULL){
				if(is_numeric($this->request->query('search_by_commentuser'))){
					$options['conditions'][] = array('NewsComments.user_id' => $this->request->query('search_by_commentuser'));
				}else{
					$options['conditions'][] = array('NewsComments.email' => $this->request->query('search_by_commentuser'));
				}				
			}
            // *********** end of search filter *********************** //
			
			$newsComment = TableRegistry::get('Admin.NewsComments');
			$options['contain'] = ['News'=>['fields'=>['News.id','News.name']]];
			$options['fields'] 	= ['NewsComments.id','NewsComments.news_id','NewsComments.comment','NewsComments.status','NewsComments.created'];
			$options['order'] 	= array('NewsComments.created'=>'DESC');
            $options['limit'] 	= $this->paginationLimit;
			$newsCommentDetails = $this->paginate($newsComment, $options)->toArray();			
			
			$NewsTable = TableRegistry::get('News');
			$all_news = $NewsTable->find('list', ['conditions'=>[], 'keyField'=>'id','valueField'=>'name'])->toArray();
			
			$newsCommentUsers = $newsComment->find('all', ['contain'=>['Users'=>['fields'=>['id','full_name']]],'conditions'=>[],'fields'=>['id','user_id','name','email']])->toArray();
			$news_comment_users = array();
			if(!empty($newsCommentUsers)){
				foreach($newsCommentUsers as $val){
					if($val['user_id']==0 || $val['user_id']==NULL){
						$news_comment_users[$val['email']] = $val['name'];
					}else if($val['user_id']!=0){
						$news_comment_users[$val['user']['id']] = $val['user']['full_name'];
					}
				}
				asort($news_comment_users);
			}
            $this->set(compact('newsCommentDetails','all_news','news_comment_users'));
            $this->set('_serialize', ['newsCommentDetails']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function editComment($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsComments'))) || (!array_key_exists('edit-comment',$session->read('permissions.'.strtolower('NewsComments')))) || $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('edit-comment'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
        $id = base64_decode($id);
        $existing_data = $NewsCommentsTable->get($id,['contain'=>['Users'=>['fields'=>['id','name']]]]);
		if ($this->request->is(['post', 'put'])) {
			$updated_data = $NewsCommentsTable->patchEntity($existing_data, $this->request->data);
            if ($savedData = $NewsCommentsTable->save($updated_data)) {				
				
				//notification for all news subscriber
				$NewsTable = TableRegistry::get('Admin.News');        
				$existing_news_data = $NewsTable->get($existing_data->news_id);			
				$all_submitter_acccount_setting = $this->getAccountSettingNews();
				if(!empty($all_submitter_acccount_setting)){
					$url = Router::url('/', true).'news/details/'.$existing_news_data['slug'];
					$news_title = $existing_news_data['name'];
					$settings = $this->getSiteSettings();
					foreach($all_submitter_acccount_setting as $to_user){
						$this->AdminEmail->sendPostNewsCommentNotificationEmailToAllUsers($to_user, $url, $settings, $news_title);
					}
				}
				//notification for all news subscriber
				
                $this->Flash->success(__('Comment has been successfully updated.'));
                return $this->redirect(['plugin' => 'admin','controller' => 'news-comments','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Comment is not updated.'));
            }
        }
        $this->set(compact('existing_data'));
        $this->set('_serialize', ['existing_data']);
    }

    public function deleteComment($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsComments'))) || (!array_key_exists('delete-comment',$session->read('permissions.'.strtolower('NewsComments')))) || $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('delete-comment'))!=1) ){
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
			$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
			$comment_data = $NewsCommentsTable->get($id);
			$NewsCommentsTable->delete($comment_data);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Comment successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developersd'));
		}
		exit();
    }

	public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsComments'))) || (!array_key_exists('delete-comment',$session->read('permissions.'.strtolower('NewsComments')))) || $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('delete-comment'))!=1) ){
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
		if(!empty($this->request->data['id'])){
			$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
			foreach($this->request->data['id'] as $val_id){
				$comment_data = $NewsCommentsTable->get($val_id);
				$NewsCommentsTable->delete($comment_data);				
			}
			echo json_encode(array('type' => 'success', 'deleted_ids' => $id, 'delete_count' => '1', 'message' => 'Comments successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developersd'));
		}
        exit();
    }
    
	public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsComments')))) || $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
		if(!empty($this->request->data['id'])){
			if(!is_array($this->request->data['id'])){
				$NewsCommentsTable->updateAll(['status'=>1],  array(1 => 1));
			}else{
				$NewsCommentsTable->updateAll(['status'=>1],  ['News.id IN' => $this->request->data['id']]);
			}
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
		if( (empty($session->read('permissions.'.strtolower('NewsComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsComments')))) || $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);
		if(!empty($this->request->data['id'])) {
			$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
			foreach($this->request->data['id'] as $val_id){
				$NewsCommentsTable->updateAll(['status'=>0], ['NewsComments.id' => $val_id]);				
			}
			echo json_encode(array('type' => 'success', 'inactive_count' => '1', 'message' => 'Comments successfully inactivated'));
		}else{
			echo json_encode(array('type' => 'error', 'inactive_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }

    public function changeStatus($id = NULL, $status = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsComments'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsComments')))) || $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('change-status'))!=1) ){
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
			if($this->request->data['status'] == 0){	//request for making as inactive
				$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
				$query = $NewsCommentsTable->query();
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Comment successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}				
			}
			else if($this->request->data['status'] == 1){
				$NewsCommentsTable = TableRegistry::get('Admin.NewsComments');
				$query = $NewsCommentsTable->query();
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){					
					//notification for all news subscriber
					$NewsTable = TableRegistry::get('Admin.News');
					$dat = $NewsCommentsTable->get($id);
					$existing_news_data = $NewsTable->get($dat['news_id']);
					
					$all_submitter_acccount_setting = $this->getAccountSettingNews();
					if(!empty($all_submitter_acccount_setting)){
						$url = Router::url('/', true).'news/details/'.$existing_news_data['slug'];
						$news_title = $existing_news_data['name'];
						$settings = $this->getSiteSettings();
						foreach($all_submitter_acccount_setting as $to_user){
							$this->AdminEmail->sendPostNewsCommentNotificationEmailToAllUsers($to_user, $url, $settings, $news_title);
						}
					}
					//notification for all news subscriber
					
					echo json_encode(array('type' => 'success', 'message' => 'Comment successfully activated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}
			else{
				echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
			}			
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developer'));
		}
        exit();
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
			$this->loadModel('NewsComment');
            $newsCommentDetails = $this->NewsComment->get($id,['contain'=>['Users'=>['fields'=>['id','name','email']]]])->toArray();
			$comment = html_entity_decode($newsCommentDetails['comment']);
			echo json_encode(array('type' => 'success', 'message' => 'Content data found', 'data' => $newsCommentDetails, 'comment' => $comment));
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
            if($this->AdminEmail->replyNewsCommentSubmittedUser($url,$submitter_name,$email,$message,$settings)){				
                echo json_encode(['status'=>'mail_sent']);
				exit();
            }else{
                echo json_encode(['status'=>'failed']);
				exit();
            }
        }
    }
}