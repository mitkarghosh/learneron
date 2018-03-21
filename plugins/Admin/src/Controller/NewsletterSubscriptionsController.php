<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
/**
 * NewsletterSubscriptions Controller
 *
 * @property \Admin\Model\Table\NewsletterSubscriptionsTable $NewsletterSubscriptions
 */
class NewsletterSubscriptionsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->loadComponent('Admin.AdminEmail');
        parent::beforeFilter($event);
    }

    /**
     * index method
     * @return \Cake\Network\Response|void Redirects to the list data
     */
    
    public function index()
    {
        return $this->redirect(['plugin' => 'admin', 'controller' => 'NewsletterSubscriptions', 'action' => 'listData']);
    }

    /**
     * List Content Category Data
     * @param  string|null $page page type.
     * @return \Cake\Network\Response|void renders view.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
    public function listData($page = null)
    {
        try{
            $options = array();
            // ************** start search filter **************** //
            $options['order'] = array('created desc');
                if($this->request->query('search') !== null && $this->request->query('search_by') !== null){
                    $options['conditions'] = array($this->request->query('search_by').' LIKE' => '%'.$this->request->query('search').'%');
                }
            $options['limit'] = $this->paginationLimit;
            $newsletterSubscriptionDetails = $this->paginate($this->NewsletterSubscriptions, $options);
            $this->set(compact('newsletterSubscriptionDetails'));
            $this->set('_serialize', ['newsletterSubscriptionDetails']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    /**
     * Add Content Category method
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    
    public function addNewsletterSubscription()
    {
        $new_newsletterSubscription = $this->NewsletterSubscriptions->newEntity();
        $all_category = $this->getBlogCategiries();
        if ($this->request->is('post')) {
            $inserted_data = $this->NewsletterSubscriptions->patchEntity($new_newsletterSubscription, $this->request->data);
            if ($savedData = $this->NewsletterSubscriptions->save($inserted_data)) {
                $this->Flash->success(__('New Blog Category has been successfully created'));
                return $this->redirect(['plugin' => 'admin','controller' => 'newsletterSubscriptions','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Blog Category is not created.'));
            }
        }
        $this->set(compact('new_newsletterSubscription','all_category'));
        $this->set('_serialize', ['new_newsletterSubscription','all_category']);
    }

    /**
     * View method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    
    public function view($id = null)
    {
        // *********** allow only post data and ajax request ************ //
        $this->request->allowMethod(['post','ajax']);
        if($this->request->is('ajax')){
            // ********** no layout *********** //
            $this->viewBuilder()->layout = false;
            // ********** no view ********** //
            $this->render(false);
            if($id == null){
                echo json_encode(array('type' => 'error', 'message' => 'invalid id'));
                exit();
            }
            // ******** get data of Agent as an array ******** //
            $newsletterSubscriptionsDetails = $this->NewsletterSubscriptions->get($id,[
                        'contain' => []
                        ])->toArray();
            // **** changing the date format into a better readable format **** //
            $newsletterSubscriptionsDetails['modified'] = date('d M Y',strtotime($newsletterSubscriptionsDetails['modified']));
            $newsletterSubscriptionsDetails['created'] = date('d M Y',strtotime($newsletterSubscriptionsDetails['created']));
            // **** end of changing the date format into a better readable format **** //
            echo json_encode(array('type' => 'success', 'message' => 'Content Category data found', 'data' => $newsletterSubscriptionsDetails));
            exit();
        }else{
            throw new NotFoundException(__('Page not found'));
        }
    }
    public function replyCustomer()
    {
        if($this->request->is('post')){
            $jsonData = $this->request->input('json_decode');
            //pr($jsonData); die;
            $settings = $this->getSiteSettings();
            if($this->AdminEmail->replyCustomer($jsonData->email,$jsonData->message,$settings)){
                echo json_encode(['status'=>'mail_sent']); die;
            }else{
                echo json_encode(['status'=>'faild']); die;
            }
        }
    }
    /**
     * Edit method
     *
     * @param int|null $id Content Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function editNewsletterSubscription($id = null)
    {
        if($id == null){
            throw new NotFoundException(__('Page not found'));
        }
        $id = $this->Crypt->unhash($id);
        $all_category = $this->getBlogCategiries();
        $existing_newsletterSubscriptions = $this->NewsletterSubscriptions->get($id, [
            'contain' => []
        ]);
       if ($this->request->is(['post', 'put'])) {
            $inserted_data = $this->NewsletterSubscriptions->patchEntity($existing_newsletterSubscriptions, $this->request->data);
            if ($savedData = $this->NewsletterSubscriptions->save($inserted_data)) {
                $this->Flash->success(__('NewsletterSubscription has been successfully Updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'newsletterSubscriptions','action' => 'list-data']);
            } else {
                $this->Flash->error(__('NewsletterSubscription is not updated.'));
            }
        }
        $this->set(compact('existing_newsletterSubscriptions','all_category'));
        $this->set('_serialize', ['existing_newsletterSubscriptions']);
    }

    /**
     * Delete method
     *
     * @param int|null $id Content Category id.
     * @return \Cake\Network\Response|null Redirects to referer page.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if($id == null){
            throw new NotFoundException(__('Page not found'));
        }
        $id = $this->Crypt->unhash($id);
        $this->request->allowMethod(['get']);
        $user = $this->NewsletterSubscriptions->get($id);
        $this->NewsletterSubscriptions->delete($user);
        //$this->loadModel('Admin.CouponCommision');
        //$this->CouponCommision->deleteAll(['CouponCommision.newsletterSubscriptions_category_id' => $id]);
        $this->Flash->success('The record is permanently deleted.');
        $this->render(false);
       return $this->redirect(['plugin' => 'admin','controller' => 'newsletterSubscriptions','action' => 'list-data']);
    }

    public function deleteMultiple($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->layout(false);
        $this->request->allowMethod(['post', 'delete']);
        if(!is_array($this->request->data['id'])){
            $this->NewsletterSubscriptions->deleteAll(array("status" => 'A'));
        }else{
            $this->NewsletterSubscriptions->deleteAll(['NewsletterSubscriptions.id IN' => $this->request->data['id']]);
            //$this->loadModel('Admin.CouponCommision');
            //$this->CouponCommision->deleteAll(['CouponCommision.newsletterSubscriptions_category_id' => $id]);
        }
        $this->Flash->success(__('Selected records were permanently deleted.'));
        $this->render(false);
        echo json_encode(array('type' => 'success', 'message' => 'Property Deleted'));
        exit();
    }

    public function status(){
        $this->viewBuilder()->layout(false);
        $this->request->allowMethod(['post', 'ajax', 'put']);
        $jsonData = $this->request->input('json_decode');
        if($jsonData->status == 'A'){
            $jsonData->status = 'I';
        }else{
            $jsonData->status = 'A';
        }
        $query = $this->NewsletterSubscriptions->query();
        if($query->update()
        ->set(['status' => $jsonData->status])
        ->where(['id' => $jsonData->id])
        ->execute()){
            echo json_encode(array('id' => $jsonData->id,'msg' => 'Status successfully changed.', 'data_status' => $jsonData->status, 'status' => 'success', 'class' => 'success'));
        }else{
            echo json_encode(array('msg' => 'There is an unexpected error. Try contacting the developer.', 'status' => 'error', 'class' => 'danger'));
        }
        $this->render(false);
        exit();
    }
}