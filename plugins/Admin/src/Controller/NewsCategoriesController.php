<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class NewsCategoriesController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);		
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'NewsCategories', 'action' => 'listData']);
    }

    public function listData($page = NULL){
		try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('NewsCategories'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('NewsCategories')))) || $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
            // ************** start search filter **************** //
            if($this->request->query('search') !== NULL){
				$options['conditions'] = array('name LIKE' => '%'.$this->request->query('search').'%');
            }
			// *********** end of search filter *********************** //
            $options['contain'] = ['Parent'];
			$options['fields'] = ['NewsCategories.id','NewsCategories.parent_id','NewsCategories.created','NewsCategories.name','NewsCategories.status','Parent.id','Parent.name'];
			$options['order'] = array('NewsCategories.id DESC');
            $options['limit'] = $this->paginationLimit;			
			$news_categories_details = $this->paginate($this->NewsCategories, $options);
			//pr($news_categories_details); die;
			$this->set(compact('news_categories_details'));
            $this->set('_serialize', ['news_categories_details']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function addNewsCategory(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsCategories'))) || (!array_key_exists('add-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) || $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('add-news-category'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
		$parent_categories = $this->getNewsParentCategory();
        $new_category = $NewsCategoryTable->newEntity();
		if ($this->request->is('post','put')){
			$slug = $NewsCategoryTable->createSlug($this->request->data['name']);	//Define in NewsCategoriesTable Model
			$this->request->data['slug'] = $slug;
			$inserted_data = $NewsCategoryTable->patchEntity($new_category, $this->request->data);
			if($savedData = $NewsCategoryTable->save($inserted_data)){
				$this->Flash->success(__('New category has been successfully created'));
                return $this->redirect(['plugin' => 'admin','controller' => 'news-categories','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Category is not created.'));
            }
        }
        $this->set(compact('new_category','parent_categories'));
        $this->set('_serialize', ['new_category']);
    }
    
    public function editNewsCategory($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsCategories'))) || (!array_key_exists('edit-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) || $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('edit-news-category'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$id = base64_decode($id);
		$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
		$parent_categories = $this->getNewsParentCategory();
		$existing_data =  $NewsCategoryTable->get($id);
		
        if($this->request->is(['post', 'put'])){			
			$slug = $NewsCategoryTable->createSlug($this->request->data['name'],$id);	//Define in TagTable Model
			$this->request->data['slug'] = $slug;
            $inserted_data = $NewsCategoryTable->patchEntity($existing_data, $this->request->data);
            if ($savedData = $NewsCategoryTable->save($inserted_data)) {
                $this->Flash->success(__('Category has been successfully updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'news-categories','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Category is not updated.'));
            }
        }
        $this->set(compact('existing_data','parent_categories'));
        $this->set('_serialize', ['existing_data']);
    }
	
	public function changeStatus($id = NULL, $status = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsCategories'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsCategories')))) || $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('change-status'))!=1) ){
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
				$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
				$news_categories_data = $NewsCategoryTable->find('all')->where(['parent_id' => $id, 'status' => 'A'])->count();	//if child category exist
				if($news_categories_data == 0){
					$NewsTable = TableRegistry::get('Admin.News');
					$news_data = $NewsTable->find('all')->where(['category_id' => $id, 'status' => 'A'])->count();
					if($news_data == 0){
						$query = $NewsCategoryTable->query();
						if($query->update()
						->set(['status' => $this->request->data['status']])
						->where(['id' => $id])
						->execute()){
							echo json_encode(array('type' => 'success', 'message' => 'Category successfully inactivated'));
						}else{
							echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
						}
					}
					else{
						echo json_encode(array('type' => 'error', 'message' => 'Category related news exist, inactive news first!!!'));
					}
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'Child category(s) exist, inactive child category(s) first!!!'));
				}
			}else if($this->request->data['status'] == 'A'){
				$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
				$query = $NewsCategoryTable->query();
				if($query->update()
				->set(['status' => $this->request->data['status']])
				->where(['id' => $id])
				->execute()){
					echo json_encode(array('type' => 'success', 'message' => 'Category successfully activated'));
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

    public function deleteNewsCategory($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsCategories'))) || (!array_key_exists('delete-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) || $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('delete-news-category'))!=1) ){
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
			$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
			$news_categories_data = $NewsCategoryTable->find('all')->where(['parent_id' => $id])->count();	//if child category exist
			if($news_categories_data == 0){
				$NewsTable = TableRegistry::get('Admin.News');
				$news_data = $NewsTable->find('all')->where(['category_id' => $id])->count();
				if( $news_data == 0 ){
					$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
					$news_category_data = $NewsCategoryTable->get($id);
					$NewsCategoryTable->delete($news_category_data);
					echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Category successfully deleted'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'Category related news exist, delete news first!!!'));
				}
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'Category related child category(s) exist, delete child category(s) first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }

    public function deleteMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsCategories'))) || (!array_key_exists('delete-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) || $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('delete-news-category'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        //Set the layout.
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post', 'delete']);		
		if(!empty($this->request->data['id'])){
			$non_deleted_categories_count = 0; $deleted_categories_count = 0; $deleted_category_ids = array();
			$NewsTable = TableRegistry::get('Admin.News');
			$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
			foreach($this->request->data['id'] as $val_id){
				$news_categories_data = $NewsCategoryTable->find('all')->where(['parent_id' => $id])->count();	//if child category exist
				if($news_categories_data == 0){
					$news_data = $NewsTable->find('all')->where(['category_id' => $val_id])->count();
					if( $news_data == 0 ){
						$news_category_data = $NewsCategoryTable->get($val_id);
						$NewsCategoryTable->delete($news_category_data);					
						$deleted_category_ids[] = $val_id;
						$deleted_categories_count++;
						$non_deleted_categories_count = 0;
					}
					else{
						$deleted_categories_count = 0;
						$non_deleted_categories_count++;
						
					}
				}else{
					$deleted_categories_count = 0;
					$non_deleted_categories_count++;
				}
			}
			if( (count($this->request->data['id']) == $deleted_categories_count) && ($non_deleted_categories_count == 0) ){
				$deleted_category_ids = $this->request->data['id'];
				echo json_encode(array('type' => 'success', 'deleted_ids' => $deleted_category_ids, 'delete_count' => '1', 'message' => 'Categories successfully deleted'));
			}
			else if( ($deleted_categories_count == 0) && (count($this->request->data['id']) == $non_deleted_categories_count) ){
				echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '2', 'message' => 'Selected category(s) related news exist, delete news first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'deleted_ids' => $deleted_category_ids, 'delete_count' => '3', 'message' => 'Some category(s) related news exist, delete news first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('NewsCategories'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsCategories')))) || $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$this->request->allowMethod(['post']);
		$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
		if(!empty($this->request->data['id'])){
			if(!is_array($this->request->data['id'])){
				$NewsCategoryTable->updateAll(['status'=>'A'],  array(1 => 1));
			}else{
				$NewsCategoryTable->updateAll(['status'=>'A'],  ['NewsCategories.id IN' => $this->request->data['id']]);
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
		if( (empty($session->read('permissions.'.strtolower('NewsCategories'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsCategories')))) || $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('change-status'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->viewBuilder()->layout(false);
		$this->render(false);
        $this->request->allowMethod(['post']);
		if(!empty($this->request->data['id'])){
			$non_activated_categories_count = 0; $activated_categories_count = 0;
			$NewsTable = TableRegistry::get('Admin.News');
			$NewsCategoryTable = TableRegistry::get('Admin.NewsCategories');
			foreach($this->request->data['id'] as $val_id){
				$news_categories_data = $NewsCategoryTable->find('all')->where(['parent_id' => $id, 'status' => 'A'])->count();	//if child category exist
				if($news_categories_data == 0){
					$news_data = $NewsTable->find('all')->where(['category_id' => $val_id, 'status' => 'A'])->count();
					if( $news_data == 0 ){
						$NewsCategoryTable->updateAll(['status'=>'I'], ['NewsCategories.id' => $val_id]);
						$activated_categories_count++;
						$non_activated_categories_count = 0;
					}
					else{
						$activated_categories_count = 0;
						$non_activated_categories_count++;
					}
				}else{
					$activated_categories_count = 0;
					$non_activated_categories_count++;
				}
			}
			if( (count($this->request->data['id']) == $activated_categories_count) && ($non_activated_categories_count == 0) ){
				echo json_encode(array('type' => 'success', 'delete_count' => '1', 'message' => 'Categories successfully inactivated'));
			}
			else if( ($activated_categories_count == 0) && (count($this->request->data['id']) == $non_activated_categories_count) ){
				echo json_encode(array('type' => 'error', 'delete_count' => '2', 'message' => 'Selected category(s) related child category(s) or news exist, inactive child category(s) or news first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'delete_count' => '3', 'message' => 'Some category(s) related child category(s) or news exist, inactive child category(s) or news first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
}