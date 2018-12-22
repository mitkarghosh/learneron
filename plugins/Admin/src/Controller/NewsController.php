<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
require_once(ROOT . DS . 'vendor' . DS . "verot/class.upload.php/src" . DS . "class.upload.php");

class NewsController extends AppController{

    public function beforeFilter(Event $event){
		$this->loadComponent('Admin.AdminEmail');
        parent::beforeFilter($event);
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'News', 'action' => 'listData']);
    }

    public function listData($page = NULL){
		try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('News'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('News')))) || $session->read('permissions.'.strtolower('News').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
            // ************** start search filter **************** //
            if($this->request->query('search') != NULL && $this->request->query('search_by') != NULL){
				$options['conditions'] = array('News.name LIKE' => '%'.$this->request->query('search').'%', 'News.category_id' => $this->request->query('search_by'));
			}
			else if($this->request->query('search') != NULL && $this->request->query('search_by') == NULL){
				$options['conditions'] = array('News.name LIKE' => '%'.$this->request->query('search').'%');
			}
			else if($this->request->query('search') == NULL && $this->request->query('search_by') != NULL){
				$options['conditions'] = array('News.category_id' => $this->request->query('search_by'));
			}
            // *********** end of search filter *********************** //
			$options['contain'] = ['NewsCategories','NewsComments'=>['conditions'=>['NewsComments.status'=>0],'fields'=>['NewsComments.id','NewsComments.news_id','NewsComments.status']]];
			$options['fields'] = ['News.id','News.category_id','News.name','News.image','News.created','News.status','NewsCategories.id','NewsCategories.name'];
			$options['order'] = array('News.id desc');
            $options['limit'] = $this->paginationLimit;
			$newsDetails = $this->paginate($this->News, $options);
			//pr($newsDetails); die;
			
			$all_category = $this->getNewsCategories();
            $this->set(compact('newsDetails','all_category'));
            $this->set('_serialize', ['newsDetails']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function addNews(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('News'))) || (!array_key_exists('add-news',$session->read('permissions.'.strtolower('News')))) || $session->read('permissions.'.strtolower('News').'.'.strtolower('add-news'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$NewsTable = TableRegistry::get('Admin.News');
        $new_news = $NewsTable->newEntity();
        $all_category = $this->getNewsCategories();
		if ($this->request->is('post')) {
			if(array_key_exists('image', $this->request->data) && $this->request->data['image']['name']!=''){
                $image_sizes = getimagesize($this->request->data['image']['tmp_name']);
                $handle = new \Upload($this->request->data['image']);
                $handle->file_new_name_body = $new_name = 'news_image_'.time().rand(0,9);
                $handle->Process('uploads/news/');
                $handle->image_resize         = true;
                $handle->image_x              = 271;
                $handle->image_ratio_y        = true;
                $handle->file_new_name_body = $new_name;
                $handle->Process('uploads/news/thumb/');
                if ($handle->processed) {
                    $this->request->data['image'] = $handle->file_dst_name;
                    $handle->clean();
                }
            }
			
			$session = $this->request->session();
			if( $session->read('newsid') != '' ) {
				$news_data = $NewsTable->find('all', ['conditions'=>array('id'=>$session->read('newsid'))])->first();
				if( $news_data != null ){
					$slug = $NewsTable->createSlug($this->request->data['name']);
					$this->request->data['slug'] = $slug;
					$updated_data = $NewsTable->patchEntity($news_data, $this->request->data);
					if ($savedData = $NewsTable->save($updated_data)) {
						if(array_key_exists('status', $this->request->data) && $this->request->data['status']=='A'){
							$UserTable = TableRegistry::get('Admin.Users');
							$user_data = $UserTable->find('all', ['contain'=>['UserAccountSetting'=>['conditions'=>['UserAccountSetting.news_notification'=>1]]],'conditions'=>['is_verified'=>1,'status'=>'A'],'fields'=>['id','name','email','full_name','notification_email']])->toArray();
							if( !empty($user_data) ){						
								$url = Router::url('/', true).'news/details/'.$slug;
								$settings = $this->getSiteSettings();
								foreach($user_data as $key_ud => $val_ud){
									$user_email = '';
									if( !empty($val_ud['user_account_setting']) ){
										$news_title = $this->request->data['name'];
										$to_user	= $val_ud['full_name'];								
										if($val_ud['notification_email'] != ''){
											$user_email = $val_ud['notification_email'];
										}else{
											$user_email = $val_ud['email'];
										}
										$this->AdminEmail->sendPostNewsNotificationEmailToAllUsers($to_user, $url, $settings, $news_title, $user_email);
									}
								}
							}
						}
						$session->delete('newsid');
						$this->Flash->success(__('New News has been successfully created'));
						return $this->redirect(['plugin' => 'admin','controller' => 'news','action' => 'list-data']);
					} else {
						$this->Flash->error(__('News is not created.'));
					}
				}else{
					$slug = $NewsTable->createSlug($this->request->data['name']);
					$this->request->data['slug'] = $slug;
					$inserted_data = $NewsTable->patchEntity($new_news, $this->request->data);
					if ($savedData = $NewsTable->save($inserted_data)) {
						if(array_key_exists('status', $this->request->data) && $this->request->data['status']=='A'){
							$UserTable = TableRegistry::get('Admin.Users');
							$user_data = $UserTable->find('all', ['contain'=>['UserAccountSetting'=>['conditions'=>['UserAccountSetting.news_notification'=>1]]],'conditions'=>['is_verified'=>1,'status'=>'A'],'fields'=>['id','name','email','full_name','notification_email']])->toArray();
							if( !empty($user_data) ){						
								$url = Router::url('/', true).'news/details/'.$slug;
								$settings = $this->getSiteSettings();
								foreach($user_data as $key_ud => $val_ud){
									$user_email = '';
									if( !empty($val_ud['user_account_setting']) ){
										$news_title = $this->request->data['name'];
										$to_user	= $val_ud['full_name'];								
										if($val_ud['notification_email'] != ''){
											$user_email = $val_ud['notification_email'];
										}else{
											$user_email = $val_ud['email'];
										}
										$this->AdminEmail->sendPostNewsNotificationEmailToAllUsers($to_user, $url, $settings, $news_title, $user_email);
									}
								}
							}
						}
						$session->delete('newsid');
						$this->Flash->success(__('New News has been successfully created'));
						return $this->redirect(['plugin' => 'admin','controller' => 'news','action' => 'list-data']);
					} else {
						$this->Flash->error(__('News is not created.'));
					}
				}
			}
			else{				
				$slug = $NewsTable->createSlug($this->request->data['name']);
				$this->request->data['slug'] = $slug;
				$inserted_data = $NewsTable->patchEntity($new_news, $this->request->data);
				if ($savedData = $NewsTable->save($inserted_data)) {
					if(array_key_exists('status', $this->request->data) && $this->request->data['status']=='A'){
						$UserTable = TableRegistry::get('Admin.Users');
						$user_data = $UserTable->find('all', ['contain'=>['UserAccountSetting'=>['conditions'=>['UserAccountSetting.news_notification'=>1]]],'conditions'=>['is_verified'=>1,'status'=>'A'],'fields'=>['id','name','email','full_name','notification_email']])->toArray();
						if( !empty($user_data) ){						
							$url = Router::url('/', true).'news/details/'.$slug;
							$settings = $this->getSiteSettings();
							foreach($user_data as $key_ud => $val_ud){
								$user_email = '';
								if( !empty($val_ud['user_account_setting']) ){
									$news_title = $this->request->data['name'];
									$to_user	= $val_ud['full_name'];								
									if($val_ud['notification_email'] != ''){
										$user_email = $val_ud['notification_email'];
									}else{
										$user_email = $val_ud['email'];
									}
									$this->AdminEmail->sendPostNewsNotificationEmailToAllUsers($to_user, $url, $settings, $news_title, $user_email);
								}
							}
						}
					}
					$this->Flash->success(__('New News has been successfully created'));
					return $this->redirect(['plugin' => 'admin','controller' => 'news','action' => 'list-data']);
				} else {
					$this->Flash->error(__('News is not created.'));
				}
			}
        }
        $this->set(compact('new_news','all_category'));
        $this->set('_serialize', ['new_news','all_category']);
    }

    public function editNews($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('News'))) || (!array_key_exists('edit-news',$session->read('permissions.'.strtolower('News')))) || $session->read('permissions.'.strtolower('News').'.'.strtolower('edit-news'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$NewsTable = TableRegistry::get('Admin.News');
        $id = base64_decode($id);
        $all_category = $this->getNewsCategories();
        $existing_data = $NewsTable->get($id);
		if ($this->request->is(['post', 'put'])) {
			if(array_key_exists('image', $this->request->data) && $this->request->data['image']['name']!=''){
                $handle = new \Upload($this->request->data['image']);
                $handle->file_new_name_body = $new_name = 'news_image_'.time().rand(0,99);
                $handle->Process('uploads/news/');
                $handle->image_resize         = true;
                $handle->image_x              = 271;
                $handle->image_ratio_y        = true;
                $handle->file_new_name_body = $new_name;
                $handle->Process('uploads/news/thumb/');
                if ($handle->processed) {
                    $this->request->data['image'] = $handle->file_dst_name;
                    $handle->clean();
					@unlink(WWW_ROOT."uploads/news/".$existing_data->image);
					@unlink(WWW_ROOT."uploads/news/thumb/".$existing_data->image);
                }
            }else{
                $this->request->data['image'] = $existing_data->image;
            }
			$slug = $NewsTable->createSlug($this->request->data['name'],$id);
			$this->request->data['slug'] = $slug;
            $inserted_data = $NewsTable->patchEntity($existing_data, $this->request->data);
            if ($savedData = $NewsTable->save($inserted_data)) {
                $this->Flash->success(__('News has been successfully Updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'news','action' => 'list-data']);
            } else {
                $this->Flash->error(__('News is not updated.'));
            }
        }
        $this->set(compact('existing_data','all_category'));
        $this->set('_serialize', ['existing_data']);
    }

    public function deleteNews($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('News'))) || (!array_key_exists('delete-news',$session->read('permissions.'.strtolower('News')))) || $session->read('permissions.'.strtolower('News').'.'.strtolower('delete-news'))!=1) ){
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
			$NewsTable = TableRegistry::get('Admin.News');
			$news_data = $NewsTable->get($id);
			@unlink(WWW_ROOT."uploads/news/".$news_data->image);
			@unlink(WWW_ROOT."uploads/news/thumb/".$news_data->image);
			$NewsTable->delete($news_data);
			echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'News successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developersd'));
		}
		exit();
    }

	public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('News'))) || (!array_key_exists('delete-news',$session->read('permissions.'.strtolower('News')))) || $session->read('permissions.'.strtolower('News').'.'.strtolower('delete-news'))!=1) ){
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
			$NewsTable = TableRegistry::get('Admin.News');
			foreach($this->request->data['id'] as $val_id){
				$news_data = $NewsTable->get($val_id);
				@unlink(WWW_ROOT."uploads/news/".$news_data->image);
				@unlink(WWW_ROOT."uploads/news/thumb/".$news_data->image);
				$NewsTable->delete($news_data);				
			}
			echo json_encode(array('type' => 'success', 'deleted_ids' => $id, 'delete_count' => '1', 'message' => 'News successfully deleted'));
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developersd'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('News'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('News')))) || $session->read('permissions.'.strtolower('News').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$NewsTable = TableRegistry::get('Admin.News');
		if(!empty($this->request->data['id'])){
			if(!is_array($this->request->data['id'])){
				$NewsTable->updateAll(['status'=>'A'],  array(1 => 1));
			}else{
				$NewsTable->updateAll(['status'=>'A'],  ['News.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('News'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('News')))) || $session->read('permissions.'.strtolower('News').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);
		if(!empty($this->request->data['id'])) {
			$NewsTable = TableRegistry::get('Admin.News');
			foreach($this->request->data['id'] as $val_id){
				$NewsTable->updateAll(['status'=>'I'], ['News.id' => $val_id]);				
			}
			echo json_encode(array('type' => 'success', 'inactive_count' => '1', 'message' => 'News successfully inactivated'));
		}else{
			echo json_encode(array('type' => 'error', 'inactive_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }

    public function changeStatus($id = NULL, $status = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('News'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('News')))) || $session->read('permissions.'.strtolower('News').'.'.strtolower('change-status'))!=1) ){
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
			if($this->request->data['status'] == 'I'){	//request for making this category as inactive
				$NewsTable = TableRegistry::get('Admin.News');
				$query = $NewsTable->query();
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'News successfully inactivated'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
				}				
			}else if($this->request->data['status'] == 'A'){
				$NewsTable = TableRegistry::get('Admin.News');
				$query = $NewsTable->query();
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'News successfully activated'));
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
	
	
	public function addNewsAsDraft(){
		$this->viewBuilder()->layout(false);
		$this->render(false);
        if ($this->request->is(['post', 'ajax', 'put'])) {
			$NewsTable = TableRegistry::get('Admin.News');
			
			$session = $this->request->session();
			if( $session->read('newsid') != '' ) {
				$news_data = $NewsTable->find('all', ['conditions'=>array('id'=>$session->read('newsid'))])->first();
				if( $news_data != null ) {
					$slug = $NewsTable->createSlug($this->request->data['name']);
					$this->request->data['slug']  = $slug;
					$this->request->data['status']= 'D';
					$updated_data = $NewsTable->patchEntity($news_data, $this->request->data);
					if ($savedData = $NewsTable->save($updated_data)) {
						echo 1;
					}
					else{
						echo 0;
					}
					exit();
				}else{
					$new_news = $NewsTable->newEntity();
					$slug = $NewsTable->createSlug($this->request->data['name']);
					$this->request->data['slug']  = $slug;
					$this->request->data['status']= 'D';
					$inserted_data = $NewsTable->patchEntity($new_news, $this->request->data);
					$savedData = $NewsTable->save($inserted_data);
					$get_last_insert_id = $savedData->id;
					$session->write('newsid',$get_last_insert_id);
					
					echo 1;
					exit();
				}
			}
			else{
				$new_news = $NewsTable->newEntity();
				$slug = $NewsTable->createSlug($this->request->data['name']);
				$this->request->data['slug']  = $slug;
				$this->request->data['status']= 'D';
				$inserted_data = $NewsTable->patchEntity($new_news, $this->request->data);
				if ($savedData = $NewsTable->save($inserted_data)) {
					$get_last_insert_id = $savedData->id;
					$session->write('newsid',$get_last_insert_id);
					echo 1;
				}
				else{
					echo 0;
				}
				exit();
			}
		}		
        exit();
    }
	
	public function editNewsAsDraft(){
		$this->viewBuilder()->layout(false);
		$this->render(false);
        if ($this->request->is(['post', 'ajax', 'put'])) {
			$NewsTable = TableRegistry::get('Admin.News');
			$news_data = $NewsTable->find('all', ['conditions'=>array('id'=>$this->request->data['news_id'])])->first();
			if( $news_data != null ) {
				$slug = $NewsTable->createSlug($this->request->data['name'],$this->request->data['news_id']);
				$this->request->data['slug'] = $slug;
				$updated_data = $NewsTable->patchEntity($news_data, $this->request->data);
				if ($savedData = $NewsTable->save($updated_data)) {
					echo 1;
				}
				else{
					echo 0;
				}
				exit();
			}
		}		
        exit();
    }
}