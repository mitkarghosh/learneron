<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class FaqsController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'Faqs', 'action' => 'listData']);
    }

    public function listData($page = NULL){
        try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('Faqs'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('Faqs')))) || $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
            // ************** start search filter **************** //
            if($this->request->query('search') !== NULL && $this->request->query('search_by') !== NULL){
                $options['conditions'] = array($this->request->query('search_by').' LIKE' => '%'.$this->request->query('search').'%');
            }
            // *********** end of search filter *********************** //
			$options['order'] = array('Faqs.created asc');
            $options['limit'] = $this->paginationLimit;
            $faqDetails = $this->paginate($this->Faqs, $options);
            $this->set(compact('faqDetails'));
            $this->set('_serialize', ['faqDetails']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function addFaq(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Faqs'))) || (!array_key_exists('add-faq',$session->read('permissions.'.strtolower('Faqs')))) || $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('add-faq'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$FaqsTable = TableRegistry::get('Admin.Faqs');
        $new_faq = $FaqsTable->newEntity();
        if($this->request->is('post')){
			$slug = $FaqsTable->createSlug($this->request->data['question']);
			$this->request->data['slug'] = $slug;
            $inserted_data = $FaqsTable->patchEntity($new_faq, $this->request->data);
            if ($savedData = $FaqsTable->save($inserted_data)) {
                $this->Flash->success(__('New FAQ has been successfully created'));
                return $this->redirect(['plugin' => 'admin','controller' => 'faqs','action' => 'list-data']);
            } else {
                $this->Flash->error(__('FAQ is not created.'));
            }
        }
        $this->set(compact('new_faq'));
        $this->set('_serialize', ['new_faq']);
    }
    
	public function editFaq($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Faqs'))) || (!array_key_exists('edit-faq',$session->read('permissions.'.strtolower('Faqs')))) || $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('edit-faq'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
		$FaqsTable = TableRegistry::get('Admin.Faqs');
        $existing_faqs = $FaqsTable->get($id);
       if ($this->request->is(['post', 'put'])) {
			$slug = $FaqsTable->createSlug($this->request->data['question'],$id);
			$this->request->data['slug'] = $slug;
            $inserted_data = $FaqsTable->patchEntity($existing_faqs, $this->request->data);
            if ($savedData = $FaqsTable->save($inserted_data)) {
                $this->Flash->success(__('FAQ has been successfully Updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'faqs','action' => 'list-data']);
            } else {
                $this->Flash->error(__('FAQ is not updated.'));
            }
        }
        $this->set(compact('existing_faqs'));
        $this->set('_serialize', ['existing_faqs']);
    }

    public function deleteFaq($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Faqs'))) || (!array_key_exists('delete-faq',$session->read('permissions.'.strtolower('Faqs')))) || $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('delete-faq'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$this->viewBuilder()->layout(false);
		$this->render(false);
		$id = isset($this->request->data['id'])?$this->request->data['id']:'';
        if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
        if($id != ''){
			$this->request->allowMethod(['post', 'delete']);
			$FaqsTable = TableRegistry::get('Admin.Faqs');
			$faq_data = $FaqsTable->get($id);
			$FaqsTable->delete($faq_data);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'FAQ successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }

    public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Faqs'))) || (!array_key_exists('delete-faq',$session->read('permissions.'.strtolower('Faqs')))) || $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('delete-faq'))!=1) ){
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
			$FaqsTable = TableRegistry::get('Admin.Faqs');
			foreach($this->request->data['id'] as $val_id){
				$faq_data = $FaqsTable->get($val_id);
				$FaqsTable->delete($faq_data);				
			}
			echo json_encode(array('type' => 'success', 'deleted_ids' => $id, 'delete_count' => '1', 'message' => 'FAQs successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Faqs'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Faqs')))) || $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$FaqsTable = TableRegistry::get('Admin.Faqs');
		if(!empty($this->request->data['id'])){
			if(!is_array($this->request->data['id'])){
				$FaqsTable->updateAll(['status'=>'A'],  array(1 => 1));
			}else{
				$FaqsTable->updateAll(['status'=>'A'],  ['Faqs.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('Faqs'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Faqs')))) || $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);
		if(!empty($this->request->data['id'])) {
			$FaqsTable = TableRegistry::get('Admin.Faqs');
			foreach($this->request->data['id'] as $val_id){
				$FaqsTable->updateAll(['status'=>'I'], ['Faqs.id' => $val_id]);				
			}
			echo json_encode(array('type' => 'success', 'inactive_count' => '1', 'message' => 'FAQ(s) successfully inactivated'));
		}else{
			echo json_encode(array('type' => 'error', 'inactive_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }

    public function changeStatus($id = NULL, $status = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Faqs'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Faqs')))) || $session->read('permissions.'.strtolower('Faqs').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'ajax', 'put']);
		$id = $this->request->data['id'];
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		if($id != ''){
			if($this->request->data['status'] == 'I'){	//request for making this faq as inactive
				$FaqsTable = TableRegistry::get('Admin.Faqs');
				$query = $FaqsTable->query();
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'FAQ successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else if($this->request->data['status'] == 'A'){
				$FaqsTable = TableRegistry::get('Admin.Faqs');
				$query = $FaqsTable->query();
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'FAQ successfully activated'));
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
}