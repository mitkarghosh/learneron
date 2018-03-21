<?php
namespace Admin\Controller;
use Admin\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class QuestionCategoriesController extends AppController{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);		
    }

    public function index(){
        return $this->redirect(['plugin' => 'admin', 'controller' => 'QuestionCategories', 'action' => 'listData']);
    }

    public function listData($page = NULL){
		try{
			$session = $this->request->session();
			if( (empty($session->read('permissions.'.strtolower('QuestionCategories'))) || (!array_key_exists('list-data',$session->read('permissions.'.strtolower('QuestionCategories')))) || $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('list-data'))!=1) ){
				$this->Flash->error(__("You don't have permission to access this page"));
				return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
			}
            $options = array();
            // ************** start search filter **************** //
            if($this->request->query('search') !== NULL){
				$options['conditions'] = array('QuestionCategories.name LIKE' => '%'.$this->request->query('search').'%');
            }
			// *********** end of search filter *********************** //
			$options['contain'] = ['Parent'];
            $options['fields'] = ['QuestionCategories.id','QuestionCategories.parent_id','QuestionCategories.name','QuestionCategories.created','QuestionCategories.status','Parent.id','Parent.name'];
			$options['order'] = array('QuestionCategories.id DESC');
            $options['limit'] = $this->paginationLimit;
			$question_category_details = $this->paginate($this->QuestionCategories, $options);
			$this->set(compact('question_category_details'));
            $this->set('_serialize', ['question_category_details']);
        }catch (NotFoundException $e) {
            throw new NotFoundException(__('There is an unexpected error'));
        }
    }

    public function addQuestionCategory(){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionCategories'))) || (!array_key_exists('add-question-category',$session->read('permissions.'.strtolower('QuestionCategories')))) || $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('add-question-category'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
		$parent_categories = $this->getQuestionParentCategory();
        $new_question_category = $QuestionCategoriesTable->newEntity();
		if ($this->request->is('post','put')){
			$slug = $QuestionCategoriesTable->createSlug($this->request->data['name']);	//Define in QuestionCategoriesTable Model
			$this->request->data['slug'] = $slug;
			$inserted_data = $QuestionCategoriesTable->patchEntity($new_question_category, $this->request->data);
			if($savedData = $QuestionCategoriesTable->save($inserted_data)){
				$this->Flash->success(__('New question category has been successfully created'));
                return $this->redirect(['plugin' => 'admin','controller' => 'question-categories','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Question category is not created.'));
            }
        }
        $this->set(compact('new_question_category','parent_categories'));
        $this->set('_serialize', ['new_question_category']);
    }
    
    public function editQuestionCategory($id = NULL){
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionCategories'))) || (!array_key_exists('edit-question-category',$session->read('permissions.'.strtolower('QuestionCategories')))) || $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('edit-question-category'))!=1) ){
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$id = base64_decode($id);
		$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
		$parent_categories = $this->getQuestionParentCategory();
		$existing_data =  $QuestionCategoriesTable->get($id);
		
        if($this->request->is(['post', 'put'])){
			$slug = $QuestionCategoriesTable->createSlug($this->request->data['name'],$id); //Define in QuestionCategoriesTable Model
			$this->request->data['slug'] = $slug;
            $inserted_data = $QuestionCategoriesTable->patchEntity($existing_data, $this->request->data);
            if ($savedData = $QuestionCategoriesTable->save($inserted_data)) {
                $this->Flash->success(__('Question category has been successfully updated'));
                return $this->redirect(['plugin' => 'admin','controller' => 'question-categories','action' => 'list-data']);
            } else {
                $this->Flash->error(__('Question category is not updated.'));
            }
        }
        $this->set(compact('existing_data','parent_categories'));
        $this->set('_serialize', ['existing_data']);
    }
	
	public function changeStatus(){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionCategories'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionCategories')))) || $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('change-status'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post', 'ajax', 'put']);
		$id = isset($this->request->data['id'])?$this->request->data['id']:'';
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		if($id != ''){
			if($this->request->data['status'] == 'I'){	//request for making this tag as inactive
				$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
				$question_categories_data = $QuestionCategoriesTable->find('all')->where(['parent_id' => $id, 'status' => 'A'])->count();	//if child category exist
				if($question_categories_data == 0){
					$QuestionsTable = TableRegistry::get('Admin.Questions');
					$question_data = $QuestionsTable->find('all')->where(['category_id' => $id, 'status' => 'A'])->count();
					if($question_data == 0){						
						$query = $QuestionCategoriesTable->query();
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
						echo json_encode(array('type' => 'error', 'message' => 'Category related question(s) exist, inactive question(s) first!!!'));
					}
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'Child category(s) exist, inactive child category(s) first!!!'));
				}
			}else if($this->request->data['status'] == 'A'){
				$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
				$query = $QuestionCategoriesTable->query();
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

    public function deleteQuestionCategory($id = NULL){
		$this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionCategories'))) || (!array_key_exists('delete-question-category',$session->read('permissions.'.strtolower('QuestionCategories')))) || $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('delete-question-category'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$id = isset($this->request->data['id'])?$this->request->data['id']:'';
		if($id == NULL){
            throw new NotFoundException(__('Page not found'));
        }
		$this->request->allowMethod(['post', 'delete']);
		if($id != ''){
			$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
			$question_categories_data = $QuestionCategoriesTable->find('all')->where(['parent_id' => $id])->count();	//if child category exist
			if($question_categories_data == 0){
				$QuestionsTable = TableRegistry::get('Admin.Questions');
				$question_data = $QuestionsTable->find('all')->where(['category_id'=>$id])->count();
				if( $question_data == 0 ){
					$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
					$question_categories_data = $QuestionCategoriesTable->get($id);
					$QuestionCategoriesTable->delete($question_categories_data);
					echo json_encode(array('type' => 'success', 'deleted_id' => $id, 'message' => 'Category successfully deleted'));
				}else{
					echo json_encode(array('type' => 'error', 'message' => 'Category related question(s) exist, delete question(s) first!!!'));
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
        //Set the layout.
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionCategories'))) || (!array_key_exists('delete-question-category',$session->read('permissions.'.strtolower('QuestionCategories')))) || $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('delete-question-category'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post', 'delete']);
		if(!empty($this->request->data['id'])){
			$non_deleted_categories_count = 0; $deleted_categories_count = 0; $deleted_category_ids = array();			
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
			foreach($this->request->data['id'] as $val_id){				
				$question_categories_data = $QuestionCategoriesTable->find('all')->where(['parent_id' => $val_id])->count();	//if child category exist
				if($question_categories_data == 0){
					$question_data = $QuestionsTable->find('all')->where(['category_id'=>$val_id])->count();
					if( $question_data == 0 ){
						$question_categories_data = $QuestionCategoriesTable->get($val_id);
						$QuestionCategoriesTable->delete($question_categories_data);					
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
				echo json_encode(array('type' => 'success', 'deleted_ids' => $deleted_category_ids, 'delete_count' => '1', 'message' => 'Category(s) successfully deleted'));
			}
			else if( ($deleted_categories_count == 0) && (count($this->request->data['id']) == $non_deleted_categories_count) ){
				echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '2', 'message' => 'Selected category(s) related question(s) exist, delete question(s) first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'deleted_ids' => $deleted_category_ids, 'delete_count' => '3', 'message' => 'Some category(s) related question(s) exist, delete question(s) first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'deleted_ids' => '', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
        exit();
    }
    
    public function activeMultiple($id = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionCategories'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionCategories')))) || $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('change-status'))!=1) ){
			/*echo json_encode(array('permission error'));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
		$this->request->allowMethod(['post']);		
		$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
		if(!empty($this->request->data['id'])){
			$QuestionCategoriesTable->updateAll(['status'=>'A'],  ['id IN' => $this->request->data['id']]);
			$ids = $this->request->data['id'];			
			echo json_encode($ids);
		}else{
			$ids = '';
			echo $ids;
		}
        exit();
    }
    
    public function inactiveMultiple($id = NULL){
        $this->viewBuilder()->layout(false);
		$this->render(false);
		$session = $this->request->session();
		if( (empty($session->read('permissions.'.strtolower('QuestionCategories'))) || (!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionCategories')))) || $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('change-status'))!=1) ){
			/*echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => "You don't have permission to access this page"));
			exit();*/
			$this->Flash->error(__("You don't have permission to access this page"));
			return $this->redirect(['plugin' => 'admin', 'controller' => 'admin-details', 'action' => 'dashboard']);
		}
        $this->request->allowMethod(['post']);		
		if(!empty($this->request->data['id'])){
			$non_activated_categories_count=0; $activated_categories_count=0;
			$QuestionsTable = TableRegistry::get('Admin.Questions');
			$QuestionCategoriesTable = TableRegistry::get('Admin.QuestionCategories');
			foreach($this->request->data['id'] as $val_id){				
				$question_categories_data = $QuestionCategoriesTable->find('all')->where(['parent_id' => $val_id, 'status' => 'A'])->count();	//if child category exist
				if($question_categories_data == 0){
					$question_data = $QuestionsTable->find('all')->where(['category_id' => $val_id, 'status' => 'A'])->count();
					if( $question_data == 0 ){
						$QuestionCategoriesTable->updateAll(['status'=>'I'], ['QuestionCategories.id' => $val_id]);
						$activated_categories_count++;
						$non_activated_categories_count = 0;						
					}
					else{
						$activated_categories_count = 0;
						$non_activated_categories_count++;
						
					}
				}
				else{
					$activated_categories_count = 0;
					$non_activated_categories_count++;
				}
			}
			
			if( (count($this->request->data['id']) == $activated_categories_count) && ($non_activated_categories_count == 0) ){
				echo json_encode(array('type' => 'success', 'delete_count' => '1', 'message' => 'Categories successfully inactivated'));
			}
			else if( ($activated_categories_count == 0) && (count($this->request->data['id']) == $non_activated_categories_count) ){
				echo json_encode(array('type' => 'error', 'delete_count' => '2', 'message' => 'Selected category related child category(s) or question(s) exist, inactive child category(s) or question(s) first!!!'));
			}
			else{
				echo json_encode(array('type' => 'warning', 'delete_count' => '3', 'message' => 'Some category(s) related child category(s) or question(s) exist, inactive child category(s) or question(s) first!!!'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'delete_count' => '', 'message' => 'There is an unexpected error. Try contacting the developers'));
		}
		exit();
    }
}