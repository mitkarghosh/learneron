<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");
/**
 * Advertisements Controller
 *
 * @property \Admin\Model\Table\BannerSectionsTable $BannerSections
 */
class AdvertisementsController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    /**
     * index method
     * @return \Cake\Network\Response|void Redirects to the list data
     */
    
    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'Advertisements', 'action' => 'listData']);
    }

    /**
     * List Content Category Data
     * @param  string|null $page page type.
     * @return \Cake\Network\Response|void renders view.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
    public function listData($page = NULL){
        try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('Advertisements'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('Advertisements')))) || $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
            // ************** start search filter **************** //
            if($this->request->query('search') !== null && $this->request->query('search_by') !== null){
				$options['conditions'] = array('title LIKE' => '%'.$this->request->query('search').'%');
			}
            // *********** end of search filter *********************** //
            $options['order'] = array('id asc');
            $options['limit'] = $this->paginationLimit;
			$AdvertisementTable = TableRegistry::get('Admin.Advertisement');
            $advertiseDetails = $this->paginate($AdvertisementTable, $options);
            $this->set(compact('advertiseDetails'));
            $this->set('_serialize', ['advertiseDetails']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function addAdvertise(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Advertisements'))) || (!array_key_exists('add-advertise',$session->read('permissions.'.strtolower('Advertisements')))) || $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('add-advertise'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$AdvertisementsSectionsTable = TableRegistry::get('Admin.Advertisement');
        $new_advertise = $AdvertisementsSectionsTable->newEntity();
        if ($this->request->is('post')) {
            if(array_key_exists('image', $this->request->data) && $this->request->data['image']['name']!=''){
                $image_sizes = getimagesize($this->request->data['image']['tmp_name']);
                $handle = new \Upload($this->request->data['image']);
                $handle->file_new_name_body = $new_name = 'advertise_'.time().rand(0,9);
                $handle->Process('uploads/advertisement/');
                $handle->image_resize         = true;
                $handle->image_x              = 728;
                $handle->image_y              = 92;
                //$handle->image_ratio_y        = true;
                $handle->file_new_name_body = $new_name;
                $handle->Process('uploads/advertisement/thumb/');
                if ($handle->processed) {
                    $this->request->data['image'] = $handle->file_dst_name;
                    $handle->clean();
                }
            }
            $inserted_data = $AdvertisementsSectionsTable->patchEntity($new_advertise, $this->request->data);
            if ($savedData = $AdvertisementsSectionsTable->save($inserted_data)) {
                $this->Flash->success(__('New advertise has been successfully created'));
                return $this->redirect(['plugin' => 'admin','controller' => 'advertisements','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Advertise is not created.'));
            }
        }
        $this->set(compact('new_advertise','all_category'));
        $this->set('_serialize', ['new_advertise','all_category']);
    }
    
    public function editAdvertise($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Advertisements'))) || (!array_key_exists('edit-advertise',$session->read('permissions.'.strtolower('Advertisements')))) || $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('edit-advertise'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
		$AdvertisementsSectionsTable = TableRegistry::get('Admin.Advertisement');
        $existing_advertisement = $AdvertisementsSectionsTable->get($id, [
            'contain' => []
        ]);
		if ($this->request->is(['post', 'put'])) {
			if(array_key_exists('image', $this->request->data) && $this->request->data['image']['name']!=''){
                $handle = new \Upload($this->request->data['image']);
                $handle->file_new_name_body = $new_name = 'advertise_'.time().rand(0,99);
                $handle->Process('uploads/advertisement/');
                $handle->image_resize         = true;
                $handle->image_x              = 728;
                $handle->image_y              = 92;
                //$handle->image_ratio_y      = true;
                $handle->file_new_name_body = $new_name;
                $handle->Process('uploads/advertisement/thumb/');
                if ($handle->processed) {
                    $this->request->data['image'] = $handle->file_dst_name;
                    $handle->clean();
					
					@unlink(WWW_ROOT."uploads/advertisement/".$existing_advertisement->image);
					@unlink(WWW_ROOT."uploads/advertisement/thumb/".$existing_advertisement->image);
                }
            }else{
                $this->request->data['image'] = $existing_advertisement->image;
            }
            $updated_data = $AdvertisementsSectionsTable->patchEntity($existing_advertisement, $this->request->data);
            if ($savedData = $AdvertisementsSectionsTable->save($updated_data)) {
                $this->Flash->success(__('Advertise has been successfully updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'Advertisements','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Advertise is not updated.'));
            }
        }
        $this->set(compact('existing_advertisement','id'));
        $this->set('_serialize', ['existing_advertisement']);
    }	
	
	public function changeStatus($id = NULL, $status = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Advertisements'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Advertisements')))) || $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('change-status'))!=1) ){
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
			$AdvertisementsSectionsTable = TableRegistry::get('Admin.Advertisement');
			$query = $AdvertisementsSectionsTable->query();
			if($this->request->data['status'] == 'I'){	//request for making this user as inactive
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Advertisement successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else if($this->request->data['status'] == 'A'){
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Advertisement successfully activated'));
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
	
	public function deleteAdvertise($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Advertisements'))) || (!array_key_exists('delete-advertise',$session->read('permissions.'.strtolower('Advertisements')))) || $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('delete-advertise'))!=1) ){
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
			$AdvertisementsSectionsTable = TableRegistry::get('Admin.Advertisement');
			$data = $AdvertisementsSectionsTable->get($id);
			@unlink(WWW_ROOT."uploads/advertisement/".$data->image);
			@unlink(WWW_ROOT."uploads/advertisement/thumb/".$data->image);
			$AdvertisementsSectionsTable->delete($data);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Advertisement successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
	
	public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Advertisements'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Advertisements')))) || $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$AdvertisementsSectionsTable = TableRegistry::get('Admin.Advertisement');
		if(!empty($this->request->data['id'])){
			foreach($this->request->data['id'] as $val_id){
				$AdvertisementsSectionsTable->updateAll(['status'=>'A'], ['id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('Advertisements'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('Advertisements')))) || $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);
		if(!empty($this->request->data['id'])) {
			$AdvertisementsSectionsTable = TableRegistry::get('Admin.Advertisement');
			foreach($this->request->data['id'] as $val_id){
				$AdvertisementsSectionsTable->updateAll(['status'=>'I'], ['id' => $val_id]);				
			}
			$ids = $this->request->data['id'];
			echo json_encode($ids);
		}else{
			$ids = '';
			echo $ids;
		}
        exit();
    }
	
	public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Advertisements'))) || (!array_key_exists('delete-advertise',$session->read('permissions.'.strtolower('Advertisements')))) || $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('delete-advertise'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$deleted_ids = array();
			$AdvertisementsSectionsTable = TableRegistry::get('Admin.Advertisement');
			foreach($this->request->data['id'] as $val_id){	
				$data = $AdvertisementsSectionsTable->get($val_id);
				@unlink(WWW_ROOT."uploads/advertisement/".$data->image);
				@unlink(WWW_ROOT."uploads/advertisement/thumb/".$data->image);
				$AdvertisementsSectionsTable->delete($data);
				$deleted_ids[] = $val_id;
			}
			echo json_encode(array('type' => 'success', 'deleted_id' => $deleted_ids, 'message' => 'Advertisement successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_id' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
	
}