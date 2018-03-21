<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");
/**
 * BannerSections Controller
 *
 * @property \Admin\Model\Table\BannerSectionsTable $BannerSections
 */
class BannerSectionsController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    /**
     * index method
     * @return \Cake\Network\Response|void Redirects to the list data
     */
    
    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'BannerSections', 'action' => 'listData']);
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
			if( (empty($session->read('permissions.'.strtolower('BannerSections'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('BannerSections')))) || $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('list-data'))!=1) ){
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
            $bannerSectionDetails = $this->paginate($this->BannerSections, $options);
            $this->set(compact('bannerSectionDetails'));
            $this->set('_serialize', ['bannerSectionDetails']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function addBannerSection(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('BannerSections'))) || (!array_key_exists('add-banner-section',$session->read('permissions.'.strtolower('BannerSections')))) || $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('add-banner-section'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$BannerSectionsTable = TableRegistry::get('Admin.BannerSections');
        $new_bannerSection = $BannerSectionsTable->newEntity();
        if ($this->request->is('post')) {
            if(array_key_exists('image', $this->request->data) && $this->request->data['image']['name']!=''){
                $image_sizes = getimagesize($this->request->data['image']['tmp_name']);
                $handle = new \Upload($this->request->data['image']);
                $handle->file_new_name_body = $new_name = 'banner_'.time().rand(0,9);
                $handle->Process('uploads/banner/');
                $handle->image_resize         = true;
                $handle->image_x              = 1336;
                $handle->image_y              = 343;
                //$handle->image_ratio_y        = true;
                $handle->file_new_name_body = $new_name;
                $handle->Process('uploads/banner/thumb/');
                if ($handle->processed) {
                    $this->request->data['image'] = $handle->file_dst_name;
                    $handle->clean();
                }
            }
            $inserted_data = $BannerSectionsTable->patchEntity($new_bannerSection, $this->request->data);
            if ($savedData = $BannerSectionsTable->save($inserted_data)) {
                $this->Flash->success(__('New Banner has been successfully created'));
                return $this->redirect(['plugin' => 'admin','controller' => 'bannerSections','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Banner is not created.'));
            }
        }
        $this->set(compact('new_bannerSection','all_category'));
        $this->set('_serialize', ['new_bannerSection','all_category']);
    }
    
    public function editBannerSection($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('BannerSections'))) || (!array_key_exists('edit-banner-section',$session->read('permissions.'.strtolower('BannerSections')))) || $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('edit-banner-section'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
		$BannerSectionsTable = TableRegistry::get('Admin.BannerSections');
        $existing_bannerSections = $BannerSectionsTable->get($id, [
            'contain' => []
        ]);
		if ($this->request->is(['post', 'put'])) {
			if(array_key_exists('image', $this->request->data) && $this->request->data['image']['name']!=''){
                $handle = new \Upload($this->request->data['image']);
                $handle->file_new_name_body = $new_name = 'banner_'.time().rand(0,99);
                $handle->Process('uploads/banner/');
                $handle->image_resize         = true;
                $handle->image_x              = 1336;
                $handle->image_y              = 343;
                //$handle->image_ratio_y      = true;
                $handle->file_new_name_body = $new_name;
                $handle->Process('uploads/banner/thumb/');
                if ($handle->processed) {
                    $this->request->data['image'] = $handle->file_dst_name;
                    $handle->clean();
                }
            }else{
                $this->request->data['image'] = $existing_bannerSections->image;
            }
            $updated_data = $BannerSectionsTable->patchEntity($existing_bannerSections, $this->request->data);
			//pr($updated_data); die;
            if ($savedData = $BannerSectionsTable->save($updated_data)) {
                $this->Flash->success(__('Banner has been successfully Updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'bannerSections','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Banner is not updated.'));
            }
        }
        $this->set(compact('existing_bannerSections','id'));
        $this->set('_serialize', ['existing_bannerSections']);
    }	
	
	public function changeStatus($id = NULL, $status = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('BannerSections'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('BannerSections')))) || $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('change-status'))!=1) ){
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
			$BannerSectionsTable = TableRegistry::get('Admin.BannerSections');
			$query = $BannerSectionsTable->query();
			if($this->request->data['status'] == 'I'){	//request for making this user as inactive
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Banner successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else if($this->request->data['status'] == 'A'){
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Banner successfully activated'));
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
	
	public function deleteBanner($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('BannerSections'))) || (!array_key_exists('delete-banner',$session->read('permissions.'.strtolower('BannerSections')))) || $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('delete-banner'))!=1) ){
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
			$BannerSectionsTable = TableRegistry::get('Admin.BannerSections');
			$banner_data = $BannerSectionsTable->get($id);
			@unlink(WWW_ROOT."uploads/banner/".$banner_data->image);
			@unlink(WWW_ROOT."uploads/banner/thumb/".$banner_data->image);
			$BannerSectionsTable->delete($banner_data);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Banner successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
	
	public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('BannerSections'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('BannerSections')))) || $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$BannerSectionsTable = TableRegistry::get('Admin.BannerSections');
		if(!empty($this->request->data['id'])){
			foreach($this->request->data['id'] as $val_id){
				$BannerSectionsTable->updateAll(['status'=>'A'], ['BannerSections.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('BannerSections'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('BannerSections')))) || $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);
		if(!empty($this->request->data['id'])) {
			$BannerSectionsTable = TableRegistry::get('Admin.BannerSections');
			foreach($this->request->data['id'] as $val_id){
				$BannerSectionsTable->updateAll(['status'=>'I'], ['BannerSections.id' => $val_id]);				
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
		if( (empty($session->read('permissions.'.strtolower('BannerSections'))) || (!array_key_exists('delete-banner',$session->read('permissions.'.strtolower('BannerSections')))) || $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('delete-banner'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$deleted_ids = array();
			$BannerSectionsTable = TableRegistry::get('Admin.BannerSections');
			foreach($this->request->data['id'] as $val_id){	
				$banner_data = $BannerSectionsTable->get($val_id);
				@unlink(WWW_ROOT."uploads/banner/".$banner_data->image);
				@unlink(WWW_ROOT."uploads/banner/thumb/".$banner_data->image);
				$BannerSectionsTable->delete($banner_data);
				$deleted_ids[] = $val_id;
			}
			echo json_encode(array('type' => 'success', 'deleted_id' => $deleted_ids, 'message' => 'Banner successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_id' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
	
}