<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
//require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");
/**
 * CookieConsents Controller
 *
 * @property \Admin\Model\Table\CookieConsentTable $CookieConsents
 */
class CookieConsentsController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    /**
     * index method
     * @return \Cake\Network\Response|void Redirects to the list data
     */
    
    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'CookieConsents', 'action' => 'listData']);
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
			if( (empty($session->read('permissions.'.strtolower('CookieConsents'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('CookieConsents')))) || $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('list-data'))!=1) ){
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
            $cookieSectionDetails = $this->paginate($this->CookieConsents, $options);
			//pr($cookieSectionDetails); die;
            $this->set(compact('cookieSectionDetails'));
            $this->set('_serialize', ['cookieSectionDetails']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function changeStatus($id = NULL, $status = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('CookieConsents'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('CookieConsents')))) || $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('change-status'))!=1) ){
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
			$CookieConsentsTable = TableRegistry::get('Admin.CookieConsents');
			$query = $CookieConsentsTable->query();
			if($this->request->data['status'] == 1){	//request for making this user as inactive
				if($query->update()
				->set(['withdrawl_status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Details successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}
			}else if($this->request->data['status'] == 0){
				if($query->update()
				->set(['withdrawl_status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Details successfully activated'));
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
	
	public function deleteCookieConsent($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('CookieConsents'))) || (!array_key_exists('delete-cookie-consent',$session->read('permissions.'.strtolower('CookieConsents')))) || $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('delete-cookie-consent'))!=1) ){
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
			$CookieTable = TableRegistry::get('Admin.CookieConsents');
			$data = $CookieTable->get($id);
			$CookieTable->delete($data);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Cookie consent successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
	
	public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('CookieConsents'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('CookieConsents')))) || $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$BannerSectionsTable = TableRegistry::get('Admin.CookieConsents');
		if(!empty($this->request->data['id'])){
			foreach($this->request->data['id'] as $val_id){
				$BannerSectionsTable->updateAll(['withdrawl_status'=>0], ['CookieConsents.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('CookieConsents'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('CookieConsents')))) || $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);
		if(!empty($this->request->data['id'])) {
			$BannerSectionsTable = TableRegistry::get('Admin.CookieConsents');
			foreach($this->request->data['id'] as $val_id){
				$BannerSectionsTable->updateAll(['withdrawl_status'=>1], ['CookieConsents.id' => $val_id]);				
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
		if( (empty($session->read('permissions.'.strtolower('CookieConsents'))) || (!array_key_exists('delete-cookie-consent',$session->read('permissions.'.strtolower('CookieConsents')))) || $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('delete-cookie-consent'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$deleted_ids = array();
			$CookieTable = TableRegistry::get('Admin.CookieConsents');
			foreach($this->request->data['id'] as $val_id){	
				$data = $CookieTable->get($val_id);
				$CookieTable->delete($data);
				$deleted_ids[] = $val_id;
			}
			echo json_encode(array('type' => 'success', 'deleted_ids' => $deleted_ids, 'message' => 'Cookie consent(s) successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
	
}