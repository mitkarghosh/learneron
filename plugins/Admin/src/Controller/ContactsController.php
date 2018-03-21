<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");

class ContactsController extends AppController{

    public function beforeFilter(Event $event){
        $this->loadComponent('Admin.AdminEmail');
        parent::beforeFilter($event);
    }

    /**
     * index method
     * @return \Cake\Network\Response|void Redirects to the list data
     */
    
    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'Contacts', 'action' => 'listData']);
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
			if( (empty($session->read('permissions.'.strtolower('Contacts'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('Contacts')))) || $session->read('permissions.'.strtolower('Contacts').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
            // ************** start search filter **************** //
            $options['order'] = array('created desc');
			if($this->request->query('search') !== null && $this->request->query('search_by') !== null){
				$options['conditions'] = array($this->request->query('search_by').' LIKE' => '%'.$this->request->query('search').'%');
			}
            $options['limit'] = $this->paginationLimit;
            $contactDetails = $this->paginate($this->Contacts, $options);
			//pr($contactDetails); die;
            $this->set(compact('contactDetails'));
            $this->set('_serialize', ['contactDetails']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    //View method
    public function view($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Contacts'))) || (!array_key_exists('reply',$session->read('permissions.'.strtolower('Contacts')))) || $session->read('permissions.'.strtolower('Contacts').'.'.strtolower('reply'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post','ajax']);
        if($this->request->is('ajax')){
            $this->viewBuilder()->layout = false;
            $this->render(false);
            if($id == NULL){
                echo json_encode(array('type' => 'error', 'message' => 'invalid id'));
                exit();
            }
            $contactsDetails = $this->Contacts->get($id,['contain'=>['ContactReply']])->toArray();
			$user_message = html_entity_decode($contactsDetails['message']);
			$admin_reply = '';
			if(!empty($contactsDetails['contact_reply'])){
				foreach($contactsDetails['contact_reply'] as $key => $reply){
					$admin_reply .= '<div class="adminreply" title="'.date('dS F Y',strtotime($reply['created'])).'">'.html_entity_decode($reply['reply_message']).'</div><hr>';
				}
			}
            $contactsDetails['modified'] = date('jS F Y',strtotime($contactsDetails['modified']));
            $contactsDetails['created'] = date('jS F Y',strtotime($contactsDetails['created']));
            echo json_encode(array('type' => 'success', 'message' => 'Content Category data found', 'data' => $contactsDetails, 'user_message' => $user_message, 'admin_reply' => $admin_reply));
            exit();
        }else{
            throw new NotFoundException(__('Page not found'));
        }
    }
	
    public function replyUsers($id = NULL, $message = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Contacts'))) || (!array_key_exists('reply',$session->read('permissions.'.strtolower('Contacts')))) || $session->read('permissions.'.strtolower('Contacts').'.'.strtolower('reply'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$this->viewBuilder()->layout(false);
		$this->render(false);
		if($this->request->is('post')){
			$id = isset($this->request->data['id'])?$this->request->data['id']:0;
			$message = isset($this->request->data['message'])?$this->request->data['message']:'';
			if($id == 0){
				throw new NotFoundException(__('Page not found'));
			}
			
			$data['ContactReply']['contact_id'] 	= $id;
			$data['ContactReply']['reply_message'] 	= $message;
			$data['ContactReply']['created'] 		= date('Y-m-d H:i:s');			
			$ContactReplyTable 	= TableRegistry::get('Admin.ContactReply');	
			$newEntity 			= $ContactReplyTable->newEntity();
			$inserted_data 		= $ContactReplyTable->patchEntity($newEntity, $data);
			$ContactReplyTable->save($inserted_data);
			
			$ContactsTable = TableRegistry::get('Admin.Contacts');
			$udata = $ContactsTable->get($id);
            $settings = $this->getSiteSettings();
            if($this->AdminEmail->replyCustomer($udata->email,$message,$settings)){				
                echo json_encode(['status'=>'mail_sent']);
				exit();
            }else{
                echo json_encode(['status'=>'failed']);
				exit();
            }
        }
    }
    
	//Delete method
    public function deleteContacts($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Contacts'))) || (!array_key_exists('delete-contacts',$session->read('permissions.'.strtolower('Contacts')))) || $session->read('permissions.'.strtolower('Contacts').'.'.strtolower('delete-contacts'))!=1) ){
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
			$ContactsTable = TableRegistry::get('Admin.Contacts');
			$data = $ContactsTable->get($id);
			$ContactsTable->delete($data);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Contact successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
	
	public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('Contacts'))) || (!array_key_exists('delete-contacts',$session->read('permissions.'.strtolower('Contacts')))) || $session->read('permissions.'.strtolower('Contacts').'.'.strtolower('delete-contacts'))!=1) ){
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
			$ContactsTable = TableRegistry::get('Admin.Contacts');
			$ContactsTable->deleteAll(['Contacts.id IN' => $this->request->data['id']]);            
			echo json_encode(array('type' => 'success', 'deleted_ids' => $id, 'delete_count' => '1', 'message' => 'Contacts successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
}