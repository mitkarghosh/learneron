<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class NewsController extends AppController{
	
	public function beforeFilter(Event $event){
        parent::beforeFilter($event);
		$this->loadComponent('Email');
        $this->Auth->allow();
		$news_cat_data = $this->getNewsCategories();	//mention in AppController
		
		$option['contain']		= ['Users'=>['fields'=>['Users.id','Users.name']]];
		if(isset($this->request->params['pass']) && !empty($this->request->params['pass'][0])){
			$option['conditions']	= ['News.slug !='=>$this->request->params['pass'][0], 'News.status'=>'A'];
		}else{
			$option['conditions']	= ['News.status'=>'A'];
		}
		$option['fields']		= ['News.id','News.user_id','News.name','News.slug','News.description','News.image','News.created'];
		$option['order']		= ['News.created'=>'DESC'];
		$option['limit']		= $this->limitNewsRightPanel;
		$latest_news_rightpanel = $this->News->find('all',$option)->toArray();
		
		//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
		$featured_question_rightpanel = '';
		$this->set(compact('news_cat_data','latest_news_rightpanel','featured_question_rightpanel'));
    }
    
	//All news listing page
    public function newsListing(){
		$this->visitorlogs('News','newsListing','News Listing',NULL,NULL);
        $NewsTable = TableRegistry::get('News');
        $CmsTable = TableRegistry::get('Cms');
        $cms_data = $CmsTable->get(2);
		$title = $cms_data->title;
		$meta_keywords = $cms_data->meta_keywords;
        $meta_description = $cms_data->meta_description;		

		$options['contain']		= ['NewsCategories'=>['fields'=>['NewsCategories.id','NewsCategories.name','NewsCategories.parent_id']], 'NewsCategories.ParentCategory'=>['fields'=>['ParentCategory.id','ParentCategory.name']], 'Users'=>['fields'=>['Users.id','Users.name']],'NewsComment'=>['conditions'=>['NewsComment.status'=>1],'fields'=>['NewsComment.id','NewsComment.news_id']]];
		$options['conditions']	= ['News.status'=>'A'];
		$options['fields']		= ['News.id','News.category_id','News.user_id','News.name','News.slug','News.description','News.image','News.view','News.created'];
		$options['order']		= ['News.created'=>'DESC'];
		$options['limit']		= $this->paginationLimit;
		$all_news = $this->paginate($this->News, $options)->toArray();
		$AdvertisementsTable = TableRegistry::get('Advertisement');
		$advertise = $AdvertisementsTable->find('all',['conditions'=>['page_name'=>'newsListing','status'=>'A'],'fields'=>['id','link','image'],'order'=>['id desc']])->first();
		$this->set(compact('cms_data','title','meta_keywords','meta_description','all_news','advertise'));
    }
	
	//All news listing -> Pagination page
	public function search(){
        if($this->request->is('post')){
			$this->visitorlogs('News','search','More News',NULL,NULL);	//Log details insertion
			
			$options['contain']		= ['NewsCategories'=>['fields'=>['NewsCategories.id','NewsCategories.name','NewsCategories.parent_id']], 'NewsCategories.ParentCategory'=>['fields'=>['ParentCategory.id','ParentCategory.name']], 'Users'=>['fields'=>['Users.id','Users.name']],'NewsComment'=>['conditions'=>['NewsComment.status'=>1],'fields'=>['NewsComment.id','NewsComment.news_id']]];
			$options['conditions']	= ['News.status'=>'A'];
			$options['fields']		= ['News.id','News.category_id','News.user_id','News.name','News.slug','News.description','News.image','News.view','News.created'];
			$options['order']		= ['News.created'=>'DESC'];
			$options['limit']		= $this->paginationLimit;
			$all_news = $this->paginate($this->News, $options)->toArray();
			$this->set(compact('all_news'));
        }
    }
	
	//News details page
	public function details($slug=NULL){
		if($slug=='' && $slug==NULL){
			$this->redirect(['controller' => 'News', 'action' => 'index']);
		}else{
			$NewsTable = TableRegistry::get('News');
			$options['contain'] = ['Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic']],'NewsComment'=>['conditions'=>['NewsComment.status'=>1],'fields'=>['NewsComment.id','NewsComment.user_id','NewsComment.news_id','NewsComment.name','NewsComment.email','NewsComment.status','NewsComment.created']]];
			$options['conditions']= ['slug'=>$slug];
			$news_detail = $NewsTable->find('all',$options)->first()->toArray();
			
			$this->visitorlogs('News','details','News Details',$news_detail['id'],NULL);	//Log details insertion
			
			//comment section start here
			$NewsCommentTable = TableRegistry::get('NewsComment');
			if(!empty($news_detail)){
				$com_options['contain'] 	= ['Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic']]];
				$com_options['conditions'] 	= ['NewsComment.status'=>1];
				$com_options['fields'] 		= ['NewsComment.id','NewsComment.user_id','NewsComment.news_id','NewsComment.name','NewsComment.email','NewsComment.comment','NewsComment.status','NewsComment.created'];
				$com_options['order'] 		= ['NewsComment.created'=>'DESC'];
				$com_options['limit'] 		= $this->limitNewsComments;
				$all_comments = $this->paginate($NewsCommentTable, $com_options);
			}else{
				$all_comments = '';
			}
			//comment section end here
			
			if($news_detail['view'] == '' && $news_detail['view'] == NULL){
				$this->request->data['view'] = 1;
			}else{
				$this->request->data['view'] = ($news_detail['view']) + 1;
			}
			$query = $NewsTable->query();
			$query->update()
				->set(['view' => $this->request->data['view']])
				->where(['id' => $news_detail['id']])
				->execute();
						
			$title = $news_detail['name'];
			$meta_keywords = $news_detail['meta_keywords'];
            $meta_description = $news_detail['meta_description'];
			$this->set(compact('news_detail','all_comments','title','meta_keywords','meta_description'));
		}
    }
	//News Comment
	public function newsCommentSubmission(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is(['post','put'])){
			if(array_key_exists('news_id',$this->request->data) && $this->request->data['news_id'] != ''){
				$this->request->data['news_id'] = isset($this->request->data['news_id'])?base64_decode($this->request->data['news_id']):0;
				$this->request->data['user_ip'] = $this->getUserIP();
				
				$this->visitorlogs('News','details','News Comment', $this->request->data['news_id'],NULL);	//Log details insertion
				
				if(!empty($this->Auth->user())){
					$this->request->data['user_id'] = $this->Auth->user('id');
				}else{
					$this->request->data['user_id'] = 0;
				}				
				$active_permission = $this->getSiteSettings();
				if(!empty($active_permission)){
					if($active_permission['news_comment_approval']==1){
						$this->request->data['status'] = 1;
					}else{
						$this->request->data['status'] = 0;
					}
				}else{
					$this->request->data['status'] 	= 0;
				}
				$NewsCommentTable = TableRegistry::get('NewsComment');
				$news_comment = $NewsCommentTable->newEntity();
				$data_to_insert = $NewsCommentTable->patchEntity($news_comment, $this->request->data);
				
				$NewsTable				= TableRegistry::get('News');
				$option_1['fields']		= ['News.id','News.name','News.slug'];
				$options_1['conditions']= ['News.id'=>$this->request->data['news_id']];
				$news_detail = $NewsTable->find('all',$options_1)->first();
				
				if($NewsCommentTable->save($data_to_insert)){
					//notification for all news subscriber
					$all_submitter_acccount_setting = $this->getAccountSettingNews();
					if(!empty($all_submitter_acccount_setting)){
						$url = Router::url('/', true).'news/details/'.$news_detail['slug'];
						$news_title = $news_detail['name'];
						$settings = $this->getSiteSettings();
						$loggedin_user_data = $this->Auth->user();
						foreach($all_submitter_acccount_setting as $to_user){
							$this->Email->sendPostNewsCommentNotificationEmailToAllUsers($to_user, $url, $settings, $news_title, $loggedin_user_data);
						}					
					}
					//notification for all news subscriber
					if(!empty($active_permission)){
						if($active_permission['news_comment_approval']==1){
							echo json_encode(['comment'=>'success']);
						}else{
							echo json_encode(['comment'=>'success_approval']);
						}
					}else{
						echo json_encode(['comment'=>'success_approval']);
					}					
					exit();					
				}else{
					echo json_encode(['comment'=>'failed']);
					exit();
				}
			}else{
				echo json_encode(['comment'=>'failed']);
				exit();
			}			
		}else{
			echo json_encode(['comment'=>'failed']);
			exit();
		}
	}
	
	//All news comment listing -> Pagination page
	public function searchComments(){
        if($this->request->is('post')){
			$all_comments = '';
			if( (isset($this->request->params)) && (array_key_exists('pass',$this->request->params)) && ($this->request->params['pass'][0] != '') ){
				$slug = $this->request->params['pass'][0];				
				$NewsTable = TableRegistry::get('News');
				$options['conditions']	= ['News.slug'=>$slug];
				$options['fields']		= ['News.id'];
				$news_detail = $NewsTable->find('all',$options)->first()->toArray();				
				if($news_detail['id'] != ''){					
					$this->visitorlogs('News','searchComments','More News Comment',$news_detail['id'],NULL);	//Log details insertion
					$NewsCommentTable = TableRegistry::get('NewsComment');
					$com_options['contain'] 	= ['Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic']]];
					$com_options['conditions'] 	= ['NewsComment.status'=>1];
					$com_options['fields'] 		= ['NewsComment.id','NewsComment.user_id','NewsComment.news_id','NewsComment.name','NewsComment.email','NewsComment.comment','NewsComment.status','NewsComment.created'];
					$com_options['order'] 		= ['NewsComment.created'=>'DESC'];
					$com_options['limit'] 		= $this->limitNewsComments;
					$all_comments = $this->paginate($NewsCommentTable, $com_options);
				}				
			}
			$this->set(compact('all_comments'));
        }
    }
	
	//News category page (after clicking any category) -> News listing under that category
    public function category($slug=NULL){
		$CmsTable = TableRegistry::get('Cms');
        $cms_data = $CmsTable->get(2);
		$title = $cms_data->title;
		$meta_keywords = $cms_data->meta_keywords;
        $meta_description = $cms_data->meta_description;
		
		$NewsCategoryTable = TableRegistry::get('NewsCategories');
		$all_related_ids = array();
		/*$cat_options['contain']	= ['ChildsCategories'=>['fields'=>['id','parent_id']]];
		$cat_options['conditions'] 	= ['status'=>'A', 'slug'=>$slug];
		$cat_options['fields'] 		= ['id','name','parent_id'];
		$category_data = $NewsCategoryTable->find('all',$cat_options)->toArray();
		if(!empty($category_data)){
			foreach($category_data as $main_category){
				$all_related_ids[] = $main_category->id;
				if(!empty($main_category->ChildsCategories)){
					foreach($main_category->ChildsCategories as $child_category){
						$all_related_ids[] = $child_category->id;
					}
				}
			}
		}
		$get_category_name = $category_data[0]->name;
		*/
		
		$cat_options['conditions'] 	= ['status'=>'A', 'slug'=>$slug];
		$cat_options['fields'] 		= ['id','name','parent_id'];
		$category_data = $NewsCategoryTable->find('all',$cat_options)->first()->toArray();
		$get_category_name = $category_data['name'];
		$all_related_ids[] = $category_data['id'];
		
		$this->visitorlogs('News','category','News Category', NULL, $category_data['id']);	//Log details insertion
		
		$options['contain']		= ['NewsCategories'=>['fields'=>['NewsCategories.id','NewsCategories.name','NewsCategories.parent_id']], 'NewsCategories.ParentCategory'=>['fields'=>['ParentCategory.id','ParentCategory.name']], 'Users'=>['fields'=>['Users.id','Users.name']]];
		$options['conditions']	= ['News.status'=>'A', 'News.category_id IN'=>$all_related_ids];
		$options['fields']		= ['News.id','News.category_id','News.user_id','News.name','News.slug','News.description','News.image','News.view','News.created'];
		$options['order']		= ['News.created'=>'DESC'];
		$options['limit']		= $this->paginationLimit;
		$all_news = $this->paginate($this->News, $options)->toArray();
		
    	$this->set(compact('cms_data','title','meta_keywords','meta_description','get_category_name','all_news'));
    }
	
	//Category News listing -> Pagination Page
	public function searchCategoryNews($slug=NULL){
        if($this->request->is('post')){
			$NewsCategoryTable = TableRegistry::get('NewsCategories');
			$all_related_ids = array();
			
			$cat_options['conditions'] 	= ['status'=>'A', 'slug'=>$slug];
			$cat_options['fields'] 		= ['id','name','parent_id'];
			$category_data = $NewsCategoryTable->find('all',$cat_options)->first()->toArray();
			
			$this->visitorlogs('News','searchCategoryNews','More News from Category', NULL, $category_data['id']);	//Log details insertion
			
			$get_category_name = $category_data['name'];
			$all_related_ids[] = $category_data['id'];
			
			$options['contain']		= ['NewsCategories'=>['fields'=>['NewsCategories.id','NewsCategories.name','NewsCategories.parent_id']], 'NewsCategories.ParentCategory'=>['fields'=>['ParentCategory.id','ParentCategory.name']], 'Users'=>['fields'=>['Users.id','Users.name']]];
			$options['conditions']	= ['News.status'=>'A', 'News.category_id IN'=>$all_related_ids];
			$options['fields']		= ['News.id','News.category_id','News.user_id','News.name','News.slug','News.description','News.image','News.view','News.created'];
			$options['order']		= ['News.created'=>'DESC'];
			$options['limit']		= $this->paginationLimit;
			$all_news = $this->paginate($this->News, $options)->toArray();
			
			$this->set(compact('get_category_name','all_news'));
        }
    }
	
	//Edit News Comment
	public function editSubmittedNewsComment($id = NULL){
		if($id == NULL){
            return $this->redirect(['controller' => '/', 'action' => 'viewSubmissions']);
        }
		$this->visitorlogs('News','editSubmittedNewsComment','Edited News Comment', NULL, NULL);	//Log details insertion
		
		$title = 'Edit News Comment';
		$NewsCommentTable = TableRegistry::get('NewsComment');
        $id = base64_decode($id);
        $existing_data = $NewsCommentTable->get($id,['contain'=>['News'=>['fields'=>['id','name']]]]);
		if ($this->request->is(['post', 'put'])) {
			$this->request->data['modified'] = date('Y-m-d H:i:s');
			$updated_data = $NewsCommentTable->patchEntity($existing_data, $this->request->data);
			if ($savedData = $NewsCommentTable->save($updated_data)) {
                $this->Flash->success(__('News comment has been successfully updated.'));
                return $this->redirect(['controller'=>'/','action'=>'view-submissions']);
            } else {
                $this->Flash->error(__('News comment is not updated.'));
            }
        }
        $this->set(compact('existing_data','title'));
        $this->set('_serialize', ['existing_data']);
    }
	
    
}