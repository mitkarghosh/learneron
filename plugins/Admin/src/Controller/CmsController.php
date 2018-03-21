<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

/**
 * Cms Controller
 *
 * @property \Admin\Model\Table\Cms $Cms
 */
class CmsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        return $this->redirect(['plugin' => 'admin', 'controller' => 'cms', 'action' => 'list-data']);
    }

    /**
     * List Cms method
     *
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function listData(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('cms'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('cms')))) || $session->read('permissions.'.strtolower('cms').'.'.strtolower('list-data'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['get']);
        try {
            $options = [];
            $options['order'] = ['id asc'];
            $options['limit'] = $this->paginationLimit;
            $options['fields'] = ['id','page_section', 'title', 'description', 'modified'];
            $cmsDetails = $this->paginate($this->Cms, $options);
            $this->set(compact('cmsDetails'));
            $this->set('_serialize', ['cmsDetails']);
        } catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Page id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function editCms($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('cms'))) || (!array_key_exists('edit-cms',$session->read('permissions.'.strtolower('cms')))) || $session->read('permissions.'.strtolower('cms').'.'.strtolower('edit-cms'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        if ($id == null) {
            throw new NotFoundException(__('Page not found'));
        }
        $id = base64_decode($id);
        $cmsDetails = $this->Cms->get($id, ['contain' => []]);
        if ($this->request->is(['post', 'put'])) {
            $cmsData = $this->Cms->patchEntity($cmsDetails, $this->request->data);
            if ($this->Cms->save($cmsData)) {
                $this->Flash->success(__('Page has been successfully updated'));
                return $this->redirect(['plugin' => 'Admin', 'controller' => 'cms', 'action' => 'list-data']);
            } else {
                $this->Flash->error(__('Page is not updated.'));
            }
        }
        $this->set(compact('cmsDetails'));
        $this->set('_serialize', ['cmsDetails']);
    }
}
