<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
/**
 * Tags Controller
 *
 * @property \Admin\Model\Table\TagsTable $Tags
 */
class TagsController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);		
    }

    /**
     * index method
     * @return \Cake\Network\Response|void Redirects to the list data
     */
    
    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'Tags', 'action' => 'listData']);
    }

    public function listData($page = NULL){
		try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
            // ************** start search filter **************** //
            $options['order'] = array('Tags.title ASC');
			if($this->request->query('search') !== NULL){
				$options['conditions'] = array('Tags.title LIKE' => '%'.$this->request->query('search').'%');
            }
			// *********** end of search filter *********************** //
            $options['fields'] = ['Tags.id','Tags.title','Tags.created','Tags.status'];
            $options['limit'] = $this->paginationLimit;
			$tag_details = $this->paginate($this->Tags, $options);
			$this->set(compact('tag_details'));
            $this->set('_serialize', ['tag_details']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function addTag(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('add-tag',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('add-tag'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$TagsTable = TableRegistry::get('Admin.Tags');
        $new_tag = $TagsTable->newEntity();
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('add-tag',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('add-tag'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if ($this->request->is('post','put')){
			$slug = $TagsTable->createSlug($this->request->data['title']);	//Define in TagTable Model
			$this->request->data['slug'] = $slug;
			$inserted_data = $TagsTable->patchEntity($new_tag, $this->request->data);
			if($savedData = $TagsTable->save($inserted_data)){
				$this->Flash->success(__('New tag has been successfully created'));
                return $this->redirect(['plugin' => 'admin','controller' => 'tags','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Tag is not created.'));
            }
        }
        $this->set(compact('new_tag'));
        $this->set('_serialize', ['new_tag']);
    }
    
    public function editTag($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('edit-tag',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('edit-tag'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$id = base64_decode($id);
		$TagsTable = TableRegistry::get('Admin.Tags');
		$existing_tags =  $TagsTable->get($id);
		
        if($this->request->is(['post', 'put'])){			
			$slug = $TagsTable->createSlug($this->request->data['title'],$id);	//Define in TagTable Model
			$this->request->data['slug'] = $slug;
            $inserted_data = $TagsTable->patchEntity($existing_tags, $this->request->data);
            if ($savedData = $TagsTable->save($inserted_data)) {
                $this->Flash->success(__('Tag has been successfully updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'tags','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Tag is not updated.'));
            }
        }
        $this->set(compact('existing_tags'));
        $this->set('_serialize', ['existing_tags']);
    }
	
	public function changeStatus($id = NULL, $status = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('change-status'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$this->request->allowMethod(['post', 'ajax', 'put']);
		$id = isset($this->request->data['id'])?$this->request->data['id']:'';
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		if($id != ''){
			if($this->request->data['status'] == 'I'){	//request for making this tag as inactive
				$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
				$question_tag_data = $QuestionTagsTable->find('all')->where(['tag_id' => $id])->count();
				if($question_tag_data == 0){
					$TagsTable = TableRegistry::get('Admin.Tags');
					$query = $TagsTable->query();
					if($query->update()
					->set(['status' => $this->request->data['status']])
					->where(['id' => $id])
					->execute()){
						echo json_encode(array('type' => 'success', 'message' => 'Tag successfully inactivated'));
					}else{
						echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
					}
				}
				else{
					echo json_encode(array('type' => 'error', 'message' => 'Tag related question(s) exist, delete tag from question(s) first!!!'));
				}
			}else if($this->request->data['status'] == 'A'){
				$TagsTable = TableRegistry::get('Admin.Tags');
				$query = $TagsTable->query();
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Tag Successfully Activated'));
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

    public function deleteTag($id = NULL){
		$this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('delete-tag',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('delete-tag'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$id = isset($this->request->data['id'])?$this->request->data['id']:'';
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$this->request->allowMethod(['post', 'delete']);
		if($id != ''){
			$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
			$question_tag_data = $QuestionTagsTable->find('all')->where(['tag_id' => $id])->count();
			if( $question_tag_data == 0 ){
				$TagsTable = TableRegistry::get('Admin.Tags');
				$tag_data = $TagsTable->get($id);
				$TagsTable->delete($tag_data);
				echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Tag successfully deleted'));
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'Tag related question(s) exist, delete tag from question(s) first!!!'));
			}			
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }

    public function deleteMultiple($id = NULL){
        //Set the layout.
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('delete-tag',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('delete-tag'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$this->request->allowMethod(['post', 'delete']);		
		if(!empty($this->request->data['id'])){
			$non_deleted_tags_count = 0; $deleted_tags_count = 0; $deleted_tag_ids = array();
			$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
			$TagsTable = TableRegistry::get('Admin.Tags');
			foreach($this->request->data['id'] as $val_id){
				$question_tag_data = $QuestionTagsTable->find('all')->where(['tag_id' => $val_id])->count();
				if( $question_tag_data == 0 ){
					$tag_data = $TagsTable->get($val_id);
					$TagsTable->delete($tag_data);					
					$deleted_tag_ids[] = $val_id;
					$deleted_tags_count++;
					$non_deleted_tags_count = 0;
				}
				else{
					$deleted_tags_count = 0;
					$non_deleted_tags_count++;
					
				}
			}
			if( (count($this->request->data['id']) == $deleted_tags_count) && ($non_deleted_tags_count == 0) ){
				$deleted_tag_ids = $this->request->data['id'];
				echo json_encode(array('type' => 'success', 'deleted_ids' => $deleted_tag_ids, 'delete_count' => '1', 'message' => 'Tags successfully deleted'));
			}
			else if( ($deleted_tags_count == 0) && (count($this->request->data['id']) == $non_deleted_tags_count) ){
				echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '2', 'message' => 'Selected tag(s) related question(s) exist, delete tag(s) from question(s) or delete question(s) first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'deleted_ids' => $deleted_tag_ids, 'delete_count' => '3', 'message' => 'Some tag(s) related question(s) exist, delete tag(s) from question(s) or delete question(s) first!!!'));
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
		if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('change-status'))!=1) ){
			/*echo json_encode(array('permission error'));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$this->request->allowMethod(['post']);
		$TagsTable = TableRegistry::get('Admin.Tags');
		if(!empty($this->request->data['id'])){
			$TagsTable->updateAll(['status'=>'A'],  ['Tags.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('Tags'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Tags')))) || $session->read('permissions.'.strtolower('Tags').'.'.strtolower('change-status'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post']);
		if(!empty($this->request->data['id'])){
			$non_activated_tags_count = 0; $activated_tags_count = 0;
			$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
			$TagsTable = TableRegistry::get('Admin.Tags');
			foreach($this->request->data['id'] as $val_id){
				$question_data = $QuestionTagsTable->find('all')->where(['tag_id' => $val_id])->count();
				if( $question_data == 0 ){
					$TagsTable->updateAll(['status'=>'I'], ['Tags.id' => $val_id]);
					$activated_tags_count++;
					$non_activated_tags_count = 0;
				}
				else{
					$activated_tags_count = 0;
					$non_activated_tags_count++;
					
				}
			}
			if( (count($this->request->data['id']) == $activated_tags_count) && ($non_activated_tags_count == 0) ){
				echo json_encode(array('type' => 'success', 'delete_count' => '1', 'message' => 'Tags successfully inactivated'));
			}
			else if( ($activated_tags_count == 0) && (count($this->request->data['id']) == $non_activated_tags_count) ){
				echo json_encode(array('type' => 'error', 'delete_count' => '2', 'message' => 'Selected tag(s) related question(s) exist, inactive question(s) first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'delete_count' => '3', 'message' => 'Some tag(s) related question(s) exist, inactive question(s) first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
}