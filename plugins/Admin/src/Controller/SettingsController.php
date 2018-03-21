<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
 // use Cake\Event\Event;

/**
* To load models
*
*/
use Cake\ORM\TableRegistry;

/**
 * Settings Controller
 *
 * @property \Admin\Model\Table\CommonSetting $HhUsers
 */
class SettingsController extends AppController
{
    /*public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }*/

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index(){
		$session = $this->request->session();
		if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='A') ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->loadModel('Admin.CommonSetting');
        $commonSettings = $this->CommonSetting->find()->first();
        $this->set(compact('commonSettings'));
        if ($this->request->is(['post', 'put'])) {
            if(!array_key_exists('question_approval', $this->request->data)){
                $this->request->data['question_approval'] = 0;
            }
            if(!array_key_exists('question_answer_approval', $this->request->data)){
                $this->request->data['question_answer_approval'] = 0;
            }
			if(!array_key_exists('question_comment_approval', $this->request->data)){
                $this->request->data['question_comment_approval'] = 0;
            }
			if(!array_key_exists('answer_comment_approval', $this->request->data)){
                $this->request->data['answer_comment_approval'] = 0;
            }
			if(!array_key_exists('news_comment_approval', $this->request->data)){
                $this->request->data['news_comment_approval'] = 0;
            }
            $commonDetails = $this->CommonSetting->patchEntity($commonSettings, $this->request->data);
            if ($this->CommonSetting->save($commonDetails)) {
                $this->Flash->success('Common Settings has been successfully updated', ['key' => 'common']);
                return $this->redirect(['plugin' => 'Admin', 'controller' => 'settings', 'action' => 'index']);
            } else {
                $this->Flash->error(__('Common Settings is not updated.'));
            }
        }
    }
}
