<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Utility\Inflector;
use Cake\Routing\Router;

class QuestionsController extends AppController{
	public function beforeFilter(Event $event){
        parent::beforeFilter($event);
		$this->loadComponent('Email');
        $this->Auth->allow(['allQuestions','latestquestionsSearch','mostViewedQuestions','mostviewedQuestionsSearch','postQuestion','details','unAnsweredQuestions','unansweredQuestionsSearch','questionCategory','questioncategorySearch','ajaxAllAnswerComments','ajaxAllQuestionComments','questionTag','questiontagSearch']);
    }
    
    public function index(){
        return $this->redirect(['controller' => 'Questions', 'action' => 'postQuestion']);
    }
	
	//post question page
	public function postQuestion(){
		$this->viewBuilder()->layout('postquestion');
		$title = 'Post Question';
		$FaqsTable = TableRegistry::get('Faqs');
		$all_faqs = $FaqsTable->find('all',['conditions'=>['status'=>'A'],'order'=>['id'=>'ASC']])->toArray();
		
		$QuestionTable = TableRegistry::get('Questions');
		$question_categories = $this->getQuestionCategoriesSorted();	//mention in AppController
		
		$TagsTable = TableRegistry::get('Tags');
		$all_tags = $TagsTable->find('list', ['conditions'=>['Tags.status'=>'A'],'order'=>['Tags.title'=>'ASC'], 'keyField'=>'id','valueField'=>'title'])->toArray();
		
		$new_question = $QuestionTable->newEntity();
		$AdvertisementsTable = TableRegistry::get('Advertisement');
		$advertise = $AdvertisementsTable->find('all',['conditions'=>['page_name'=>'postQuestion','status'=>'A'],'fields'=>['id','link','image'],'order'=>['id desc']])->first();
		$this->set(compact('all_faqs','question_categories','all_tags','new_question','title','advertise'));
    }
	
	//Create Tag Slug//
	public function createTagsSlug ($string=NULL, $id=NULL){
		$this->name = 'Tags';
		$slug = Inflector::slug ($string,'-');
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params ['conditions']= array();
		$params ['conditions'][$this->name.'.slug']= $slug;
		if (!is_null($id)){
			$params ['conditions']['not'] = array($this->name.'.id'=>$id);
		}
		$TagsTable = TableRegistry::get('Tags');
		while (count($TagsTable->find('all',$params)->toArray())) {
			if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
				$slug .= '-' . ++$i;
			} else {
				$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
			}
			$params ['conditions'][$this->name . '.slug']= $slug;
		}
		return $slug;
	}
	//Create Tag Slug//
	
	public function postQuestionSubmission(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is('post')){
			if(!empty($this->Auth->user())){
				$QuestionTable = TableRegistry::get('Questions');
				//pr($this->request->data);
				$new_generated_tag_ids = array();
				if( isset($this->request->data['new_tags']) && array_key_exists('new_tags', $this->request->data) ) {
					$TagsTable = TableRegistry::get('Tags');					
					if( strpos($this->request->data['new_tags'], ',') !== false ) {
						$exploded_tags = explode(',',$this->request->data['new_tags']);
						//echo '<pre>'; print_r($exploded_tags); die;
						foreach( $exploded_tags as $key_tag => $val_tag ) {							
							$chk = $TagsTable->find('all',['conditions'=>['title'=>trim($val_tag)]])->first();
							if( count($chk) > 0 ) {
								$new_generated_tag_ids[] = $chk->id;
							}else{
								$slug = $this->createTagsSlug($val_tag);
								$newtag['title'] 	= trim(ucwords($val_tag));
								$newtag['slug'] 	= $slug;
								$newtag['status'] 	= 'A';
								
								$new_tag 		= $TagsTable->newEntity();
								$insertdata 	= $TagsTable->patchEntity($new_tag, $newtag);
								$save 			= $TagsTable->save($insertdata);
								$tag_insert_id 	= $save->id;
								$new_generated_tag_ids[] = $tag_insert_id;
								$tag_insert_id = '';
							}
						}
					}else{
						$chk = $TagsTable->find('all',['conditions'=>['title'=>trim($this->request->data['new_tags'])]])->first();
						if( count($chk) > 0 ) {
							$new_generated_tag_ids[] = $chk->id;
						}else{							
							$slug = $this->createTagsSlug($this->request->data['new_tags']);						
							$newtag['title']	= trim(ucwords($this->request->data['new_tags']));
							$newtag['slug'] 	= $slug;
							$newtag['status'] 	= 'A';
							
							$new_tag 		= $TagsTable->newEntity();
							$inserted_data = $TagsTable->patchEntity($new_tag, $newtag);
							$save = $TagsTable->save($inserted_data);
							$tag_insert_id = $save->id;
							$new_generated_tag_ids[] = $tag_insert_id;
						}
					}
				}
				if( !empty($new_generated_tag_ids) ) {
					$main_tags = $this->request->data['tags'];
					$merge_array = array_merge( $main_tags,$new_generated_tag_ids );
					$this->request->data['tags'] = $merge_array;
				}
				
				$this->request->data['user_id'] 	= $this->Auth->user('id');
				$this->request->data['user_type'] 	= 'U';
				$active_permission = $this->getSiteSettings();	//getting approval permission mentioned in AppController
				if(!empty($active_permission)){
					if($active_permission['question_approval']==1){
						$this->request->data['status'] 		= 'A';
					}else{
						$this->request->data['status'] 		= 'I';
					}
				}else{
					$this->request->data['status'] 		= 'I';
				}
				
				$session = $this->request->session();
				//If session question id exist then update data
				if( $session->read('questionid') != '' ) {
					$qstn_data 		= $QuestionTable->find('all', ['conditions'=>array('id'=>$session->read('questionid'),'user_id'=>$this->Auth->user('id'))])->first();
					$inserted_data 	= $QuestionTable->patchEntity($qstn_data, $this->request->data);
					if($savedData 	= $QuestionTable->save($inserted_data)){
						$get_last_insert_id = $savedData->id;
						$this->visitorlogs('Questions','postQuestionSubmission','Question Submission',NULL,NULL,$this->Auth->user('id'),$get_last_insert_id);	//Log details insertion
						if(!empty($this->request->data['tags'])){
							$QuestionTagsTable = TableRegistry::get('QuestionTags');
							foreach( $this->request->data['tags'] as $key_tag_data => $val_tag_data ){
								$tag_data['QuestionTags']['question_id'] = $get_last_insert_id;
								$tag_data['QuestionTags']['user_id'] = $this->Auth->user('id');
								$tag_data['QuestionTags']['tag_id'] = $val_tag_data;
								$TagNewEntity = $QuestionTagsTable->newEntity();
								$inserted_data = $QuestionTagsTable->patchEntity($TagNewEntity, $tag_data);
								$QuestionTagsTable->save($inserted_data);						
							}
						}
						/* blocked on 22.11.2018
						//Notify users for same category subscribers
						$all_submitter_acccount_setting = $this->getAccountSettingCategoryWise($this->request->data['category_id']);
						if(!empty($all_submitter_acccount_setting)){
							$url = Router::url('/', true).'questions/details/'.base64_encode($get_last_insert_id);
							$question_title = $this->request->data['name'];
							$settings = $this->getSiteSettings();
							$loggedin_user_data = $this->Auth->user();
							$notify_type = 'Post Question';
							foreach($all_submitter_acccount_setting as $to_user){
								$this->Email->sendPostQuestionNotificationEmailToAllUsers($to_user, $url, $settings, $question_title, $loggedin_user_data, $notify_type);
							}					
						}
						*/
						
						$session->delete('questionid');
						
						//if question submitter wants notification for new answer					
						if(!empty($active_permission)){
							if($active_permission['question_approval']==1){
								echo json_encode(['question'=>'success']);
								exit();
							}else{
								echo json_encode(['question'=>'success_approval']);
								exit();
							}
						}else{
							echo json_encode(['question'=>'success_approval']);
							exit();
						}					
					} else {
						echo json_encode(['question'=>'failed']);
						exit();
					}
				}
				//Session questionid empty so insert a new one
				else{
					$new_question 	= $QuestionTable->newEntity();
					$inserted_data 	= $QuestionTable->patchEntity($new_question, $this->request->data);
					if($savedData 	= $QuestionTable->save($inserted_data)){
						$get_last_insert_id = $savedData->id;
						$this->visitorlogs('Questions','postQuestionSubmission','Question Submission',NULL,NULL,$this->Auth->user('id'),$get_last_insert_id);	//Log details insertion
						if(!empty($this->request->data['tags'])){
							$QuestionTagsTable = TableRegistry::get('QuestionTags');
							foreach( $this->request->data['tags'] as $key_tag_data => $val_tag_data ){
								$tag_data['QuestionTags']['question_id'] = $get_last_insert_id;
								$tag_data['QuestionTags']['user_id'] = $this->Auth->user('id');
								$tag_data['QuestionTags']['tag_id'] = $val_tag_data;
								$TagNewEntity = $QuestionTagsTable->newEntity();
								$inserted_data = $QuestionTagsTable->patchEntity($TagNewEntity, $tag_data);
								$QuestionTagsTable->save($inserted_data);						
							}
						}
						/* blocked on 22.11.2018
						//Notify users for same category subscribers
						$all_submitter_acccount_setting = $this->getAccountSettingCategoryWise($this->request->data['category_id']);
						if(!empty($all_submitter_acccount_setting)){
							$url = Router::url('/', true).'questions/details/'.base64_encode($get_last_insert_id);
							$question_title = $this->request->data['name'];
							$settings = $this->getSiteSettings();
							$loggedin_user_data = $this->Auth->user();
							$notify_type = 'Post Question';
							foreach($all_submitter_acccount_setting as $to_user){
								$this->Email->sendPostQuestionNotificationEmailToAllUsers($to_user, $url, $settings, $question_title, $loggedin_user_data, $notify_type);
							}					
						}
						*/
						
						$session->delete('questionid');
						
						//if question submitter wants notification for new answer					
						if(!empty($active_permission)){
							if($active_permission['question_approval']==1){
								echo json_encode(['question'=>'success']);
								exit();
							}else{
								echo json_encode(['question'=>'success_approval']);
								exit();
							}
						}else{
							echo json_encode(['question'=>'success_approval']);
							exit();
						}					
					} else {
						echo json_encode(['question'=>'failed']);
						exit();
					}
				}				
			}else{
				echo json_encode(['question'=>'failed']);
				exit();
			}
        }
	}
	
	public function postQuestionSubmissionAsDraft(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is('post')){
			if(!empty($this->Auth->user())){
				$QuestionTable = TableRegistry::get('Questions');
				
				$new_generated_tag_ids = array();
				if( isset($this->request->data['new_tags']) && !empty($this->request->data['new_tags']) ) {
					$TagsTable = TableRegistry::get('Tags');					
					if( strpos($this->request->data['new_tags'], ',') !== false ) {
						$exploded_tags = explode(',',$this->request->data['new_tags']);
						//echo '<pre>'; print_r($exploded_tags); die;
						foreach( $exploded_tags as $key_tag => $val_tag ) {							
							$chk = $TagsTable->find('all',['conditions'=>['title'=>trim($val_tag)]])->first();
							if( count($chk) > 0 ) {
								$new_generated_tag_ids[] = $chk->id;
							}else{
								$slug = $this->createTagsSlug($val_tag);
								$newtag['title'] 	= trim(ucwords($val_tag));
								$newtag['slug'] 	= $slug;
								$newtag['status'] 	= 'A';
								
								$new_tag 		= $TagsTable->newEntity();
								$insertdata 	= $TagsTable->patchEntity($new_tag, $newtag);
								$save 			= $TagsTable->save($insertdata);
								$tag_insert_id 	= $save->id;
								$new_generated_tag_ids[] = $tag_insert_id;
								$tag_insert_id = '';
							}
						}
					}else{
						$chk = $TagsTable->find('all',['conditions'=>['title'=>trim($this->request->data['new_tags'])]])->first();
						if( count($chk) > 0 ) {
							$new_generated_tag_ids[] = $chk->id;
						}else{							
							$slug = $this->createTagsSlug($this->request->data['new_tags']);						
							$newtag['title']	= trim(ucwords($this->request->data['new_tags']));
							$newtag['slug'] 	= $slug;
							$newtag['status'] 	= 'A';
							
							$new_tag 		= $TagsTable->newEntity();
							$inserted_data = $TagsTable->patchEntity($new_tag, $newtag);
							$save = $TagsTable->save($inserted_data);
							$tag_insert_id = $save->id;
							$new_generated_tag_ids[] = $tag_insert_id;
						}
					}
				}
				if( !empty($new_generated_tag_ids) ) {
					$main_tags = $this->request->data['tags'];
					$merge_array = array_merge( $main_tags,$new_generated_tag_ids );
					$this->request->data['tags'] = $merge_array;
				}
				
				$this->request->data['user_id'] 	= $this->Auth->user('id');
				$this->request->data['user_type'] 	= 'U';
				$this->request->data['status'] 		= 'D';
				
				$session = $this->request->session();
				
				$count_qstn = $QuestionTable->find('all', ['conditions'=>array('id'=>$session->read('questionid'),'user_id'=>$this->Auth->user('id'))])->count();				
				if( $count_qstn > 0 ){	//Update section
					$qstn_data 		= $QuestionTable->find('all', ['conditions'=>array('id'=>$session->read('questionid'),'user_id'=>$this->Auth->user('id'))])->first();
					$data_to_update = $QuestionTable->patchEntity($qstn_data, $this->request->data);					
					
					if($savedData = $QuestionTable->save($data_to_update)){
						$get_last_insert_id = $savedData->id;
						if(!empty($this->request->data['tags'])){
							$QuestionTagsTable = TableRegistry::get('QuestionTags');							
							$QuestionTagsTable->deleteAll([
													'QuestionTags.question_id' => $get_last_insert_id,
													'user_id'				   => $this->Auth->user('id')
												]);
							foreach( $this->request->data['tags'] as $key_tag_data => $val_tag_data ){
								$tag_data['QuestionTags']['question_id'] = $get_last_insert_id;
								$tag_data['QuestionTags']['user_id'] = $this->Auth->user('id');
								$tag_data['QuestionTags']['tag_id'] = $val_tag_data;
								$TagNewEntity = $QuestionTagsTable->newEntity();
								$inserted_data = $QuestionTagsTable->patchEntity($TagNewEntity, $tag_data);
								$QuestionTagsTable->save($inserted_data);						
							}
						}
						echo 1;
						exit();
					}
					else {
						echo 0;
						exit();
					}				
				}
				else{	//Session question id empty so Insert new one
					$new_question = $QuestionTable->newEntity();
					$data_to_insert = $QuestionTable->patchEntity($new_question, $this->request->data);
					
					if($savedData = $QuestionTable->save($data_to_insert)){
						$get_last_insert_id = $savedData->id;
						$session->write('questionid',$get_last_insert_id);
						if(!empty($this->request->data['tags'])){
							$QuestionTagsTable = TableRegistry::get('QuestionTags');							
							foreach( $this->request->data['tags'] as $key_tag_data => $val_tag_data ){
								$tag_data['QuestionTags']['question_id'] = $get_last_insert_id;
								$tag_data['QuestionTags']['user_id'] = $this->Auth->user('id');
								$tag_data['QuestionTags']['tag_id'] = $val_tag_data;
								$TagNewEntity = $QuestionTagsTable->newEntity();
								$inserted_data = $QuestionTagsTable->patchEntity($TagNewEntity, $tag_data);
								$QuestionTagsTable->save($inserted_data);						
							}
						}
						echo 1;
						exit();
					}
					else {
						echo 0;
						exit();
					}
				}				
			}else{
				echo 0;
				exit();
			}
        }
	}
	
	public function getEducationDetails(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		
		$member_id = $this->Auth->user('id');
		$CareereducationsTable = TableRegistry::get('Careereducations');
		$count = $CareereducationsTable->find('all',['conditions'=>['Careereducations.user_id'=>$member_id,'Careereducations.history_type'=>'E']])->count();
		if($count == 0){
			echo '';
			exit();
		}else{
			$data = $CareereducationsTable->find('all',['conditions'=>['Careereducations.user_id'=>$member_id,'Careereducations.history_type'=>'E'],'order'=>['Careereducations.id'=>'ASC']])->toArray();
			$for_view = '';
			foreach($data as $val){
				$for_view .= $val['edu_degree'].' at '.$val['edu_organization'].' from '.date('jS F Y', strtotime($val['edu_from'])).' to '.date('jS F Y', strtotime($val['edu_to'])).'<br />';
			}
			echo $for_view;
			exit();
		}
	}
	
	//Browse all questions (search) page
	public function allQuestions(){
		$this->visitorlogs('Questions','allQuestions','Latest Question Listing',NULL,NULL,NULL,NULL);	//Log details insertion
		$QuestionsTable = TableRegistry::get('Questions');
		//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
		$featured_question_rightpanel = '';
		$latest_news_rightpanel = $this->getLatestNews();				//mention in AppController
		$question_categories = $this->getTreeQuestionCategoriesSorted();//mention in AppController
		
		if($this->request->query('search') != NULL){
			$UsersTable = TableRegistry::get('Users');
			$get_match_users = $UsersTable->find('list',['conditions'=>['OR'=>['Users.name LIKE' => '%'.trim($this->request->query('search')).'%','Users.full_name LIKE' => '%'.trim($this->request->query('search')).'%']]])->toArray();
			if(!empty($get_match_users)){
				$options['conditions'][] = ['OR'=>[
													'Questions.name LIKE' => '%'.$this->request->query('search').'%',
													'Questions.short_description LIKE' => '%'.$this->request->query('search').'%',
													'Questions.user_id IN' => $get_match_users
													]
											];
			}else{			
				$options['conditions'][] = ['OR'=>[
													'Questions.name LIKE' => '%'.$this->request->query('search').'%',
													'Questions.short_description LIKE' => '%'.$this->request->query('search').'%'
													]
											];
			}
		}
		$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id']]];
		$options['conditions'][]= ['Questions.status'=>'A'];
		$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
		$options['order'] 		= ['Questions.created DESC'];
		$options['limit'] 		= $this->limitLatestQuestions;
		$latest_questions = $this->paginate($QuestionsTable, $options)->toArray();
		$total_count=0;
		if($this->request->query('search') != NULL){
			unset($options['limit']);
			$total_count = $QuestionsTable->find('all', $options)->count();
		}
		$AdvertisementsTable = TableRegistry::get('Advertisement');
		$advertise = $AdvertisementsTable->find('all',['conditions'=>['page_name'=>'allQuestions','status'=>'A'],'fields'=>['id','link','image'],'order'=>['id desc']])->first();
		$this->set(compact('featured_question_rightpanel','latest_news_rightpanel','question_categories','latest_questions','total_count','advertise'));
    }
	//Browse all questions page latest question listing -> Pagination page
	public function latestquestionsSearch(){
        if($this->request->is('post')){
			$this->visitorlogs('Questions','latestquestionsSearch','More Latest Question Listing',NULL,NULL,NULL,NULL);	//Log details insertion
			$QuestionsTable = TableRegistry::get('Questions');
			if($this->request->query('search') != NULL){
				$UsersTable = TableRegistry::get('Users');
				$get_match_users = $UsersTable->find('list',['conditions'=>['OR'=>['Users.name LIKE' => '%'.trim($this->request->query('search')).'%','Users.full_name LIKE' => '%'.trim($this->request->query('search')).'%']]])->toArray();
				if(!empty($get_match_users)){
					$options['conditions'][] = ['OR'=>[
														'Questions.name LIKE' => '%'.$this->request->query('search').'%',
														'Questions.short_description LIKE' => '%'.$this->request->query('search').'%',
														'Questions.user_id IN' => $get_match_users
														]
												];
				}else{			
					$options['conditions'][] = ['OR'=>[
														'Questions.name LIKE' => '%'.$this->request->query('search').'%',
														'Questions.short_description LIKE' => '%'.$this->request->query('search').'%'
														]
												];
				}
			}
			$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id']]];
			$options['conditions'][]= ['Questions.status'=>'A'];
			$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
			$options['order'] 		= ['Questions.created DESC'];
			$options['limit'] 		= $this->limitLatestQuestions;
			$latest_questions = $this->paginate($QuestionsTable, $options)->toArray();
			$this->set(compact('latest_questions'));
        }
    }
	
	//mostViewedQuestions function is for Browse all questions page most_viewed questions tab
    public function mostViewedQuestions(){
		$this->visitorlogs('Questions','mostViewedQuestions','Most Viewed Question Listing',NULL,NULL,NULL,NULL);	//Log details insertion
        $QuestionsTable = TableRegistry::get('Questions');
		
		//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
		$featured_question_rightpanel = '';
		$latest_news_rightpanel = $this->getLatestNews();				//mention in AppController
		$question_categories = $this->getTreeQuestionCategoriesSorted();//mention in AppController
		
		if($this->request->query('search') != NULL){
			$UsersTable = TableRegistry::get('Users');
			$get_match_users = $UsersTable->find('list',['conditions'=>['OR'=>['Users.name LIKE' => '%'.trim($this->request->query('search')).'%','Users.full_name LIKE' => '%'.$this->request->query('search').'%']]])->toArray();
			if(!empty($get_match_users)){
				$options['conditions'][] = ['OR'=>[
													'Questions.name LIKE' => '%'.$this->request->query('search').'%',
													'Questions.short_description LIKE' => '%'.$this->request->query('search').'%',
													'Questions.user_id IN' => $get_match_users
													]
											];
			}else{			
				$options['conditions'][] = ['OR'=>[
													'Questions.name LIKE' => '%'.$this->request->query('search').'%',
													'Questions.short_description LIKE' => '%'.$this->request->query('search').'%'
													]
											];
			}
		}
		$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id']]];
		$options['conditions'][]= ['Questions.status'=>'A'];
		$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
		$options['order'] 		= ['view DESC'];
		$options['limit'] 		= $this->limitMostViewedQuestions;
		$most_viewed_questions = $this->paginate($QuestionsTable, $options)->toArray();
		
		if($this->request->query('search') != NULL){
			unset($options['limit']);
			$total_count = $QuestionsTable->find('all', $options)->count();
		}
		$this->set(compact('featured_question_rightpanel','latest_news_rightpanel','question_categories','most_viewed_questions','total_count'));
    }
	//Browse all questions page most viewed question listing -> Pagination page
	public function mostviewedQuestionsSearch(){
        if($this->request->is('post')){
			$this->visitorlogs('Questions','mostviewedQuestionsSearch','More Most Viewed Question Listing',NULL,NULL,NULL,NULL);	//Log details insertion
			$QuestionsTable = TableRegistry::get('Questions');
			if($this->request->query('search') != NULL){
				$UsersTable = TableRegistry::get('Users');
				$get_match_users = $UsersTable->find('list',['conditions'=>['OR'=>['Users.name LIKE' => '%'.trim($this->request->query('search')).'%','Users.full_name LIKE' => '%'.trim($this->request->query('search')).'%']]])->toArray();
				if(!empty($get_match_users)){
					$options['conditions'][] = ['OR'=>[
														'Questions.name LIKE' => '%'.$this->request->query('search').'%',
														'Questions.short_description LIKE' => '%'.$this->request->query('search').'%',
														'Questions.user_id IN' => $get_match_users
														]
												];
				}else{			
					$options['conditions'][] = ['OR'=>[
														'Questions.name LIKE' => '%'.$this->request->query('search').'%',
														'Questions.short_description LIKE' => '%'.$this->request->query('search').'%'
														]
												];
				}
			}
			$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id']]];
			$options['conditions'][]= ['Questions.status'=>'A'];
			$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
			$options['order'] 		= ['view DESC'];
			$options['limit'] 		= $this->limitMostViewedQuestions;		
			$most_viewed_questions = $this->paginate($QuestionsTable, $options)->toArray();
			$this->set(compact('most_viewed_questions'));
        }
    }
	
	//Un-answered questions for question listing page
	public function unAnsweredQuestions(){
		$this->visitorlogs('Questions','unAnsweredQuestions','Unanswered Question Listing',NULL,NULL,NULL,NULL);	//Log details insertion
        $QuestionsTable = TableRegistry::get('Questions');
		$total_questions = $QuestionsTable->find('all', ['conditions'=>['status'=>'A']] )->count();
		$UsersTable = TableRegistry::get('Users');
		$total_users = $UsersTable->find('all', ['conditions'=>['status'=>'A']] )->count();
		
		//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
		$featured_question_rightpanel = '';
		$latest_news_rightpanel = $this->getLatestNews();				//mention in AppController
		$question_categories = $this->getTreeQuestionCategoriesSorted();//mention in AppController
		
		//for getting not answered questions
		$QuestionAnswerTable = TableRegistry::get('QuestionAnswer');
		$unanswered_ids = $QuestionAnswerTable->find('list', [/*'conditions'=>['QuestionAnswer.status'=>'I'],*/ 'group'=>'QuestionAnswer.question_id', 'keyField'=>'id','valueField'=>'question_id'])->toArray();
		if(!empty($unanswered_ids)){
			if($this->request->query('search') != NULL){
				$UsersTable = TableRegistry::get('Users');
				$get_match_users = $UsersTable->find('list',['conditions'=>['OR'=>['Users.name LIKE' => '%'.trim($this->request->query('search')).'%','Users.full_name LIKE' => '%'.trim($this->request->query('search')).'%']]])->toArray();
				if(!empty($get_match_users)){
					$options['conditions'][] = ['OR'=>[
														'Questions.name LIKE' => '%'.$this->request->query('search').'%',
														'Questions.short_description LIKE' => '%'.$this->request->query('search').'%',
														'Questions.user_id IN' => $get_match_users
														]
												];
				}else{			
					$options['conditions'][] = ['OR'=>[
														'Questions.name LIKE' => '%'.$this->request->query('search').'%',
														'Questions.short_description LIKE' => '%'.$this->request->query('search').'%'
														]
												];
				}
			}
			$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'I'],'fields'=>['id','question_id']]];
			$options['conditions'][]= ['Questions.id NOT IN'=>$unanswered_ids,'Questions.status'=>'A'];
			$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
			$options['order'] 		= ['Questions.created DESC'];
			$options['limit'] 		= $this->limitLatestQuestions;
			$unanswered_questions 	= $this->paginate($QuestionsTable, $options)->toArray();
			
			if($this->request->query('search') != NULL){
				unset($options['limit']);
				$total_count = $QuestionsTable->find('all', $options)->count();
			}
		}else{
			$unanswered_questions = array();
		}
		//for getting not answered questions
		$this->set(compact('total_questions','total_users','featured_question_rightpanel','latest_news_rightpanel','question_categories','unanswered_questions','total_count'));
    }
	//Browse all question page unanswered question listing -> Pagination page
	public function unansweredQuestionsSearch(){
        if($this->request->is('post')){
			$this->visitorlogs('Questions','unansweredQuestionsSearch','More Unanswered Question Listing',NULL,NULL,NULL,NULL);	//Log details insertion
			$QuestionsTable = TableRegistry::get('Questions');
			//for getting not answered questions
			$QuestionAnswerTable = TableRegistry::get('QuestionAnswer');
			$unanswered_ids = $QuestionAnswerTable->find('list', [/*'conditions'=>['QuestionAnswer.status'=>'I'],*/ 'group'=>'QuestionAnswer.question_id', 'keyField'=>'id','valueField'=>'question_id'])->toArray();
			if(!empty($unanswered_ids)){
				if($this->request->query('search') != NULL){
					$UsersTable = TableRegistry::get('Users');
					$get_match_users = $UsersTable->find('list',['conditions'=>['OR'=>['Users.name LIKE' => '%'.trim($this->request->query('search')).'%','Users.full_name LIKE' => '%'.trim($this->request->query('search')).'%']]])->toArray();
					if(!empty($get_match_users)){
						$options['conditions'][] = ['OR'=>[
															'Questions.name LIKE' => '%'.$this->request->query('search').'%',
															'Questions.short_description LIKE' => '%'.$this->request->query('search').'%',
															'Questions.user_id IN' => $get_match_users
															]
													];
					}else{			
						$options['conditions'][] = ['OR'=>[
															'Questions.name LIKE' => '%'.$this->request->query('search').'%',
															'Questions.short_description LIKE' => '%'.$this->request->query('search').'%'
															]
													];
					}
				}
				$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'I'],'fields'=>['id','question_id']]];
				$options['conditions'][]= ['Questions.id NOT IN'=>$unanswered_ids,'Questions.status'=>'A'];
				$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
				$options['order'] 		= ['Questions.created DESC'];
				$options['limit'] 		= $this->limitLatestQuestions;
				$unanswered_questions 	= $this->paginate($QuestionsTable, $options)->toArray();
			}else{
				$unanswered_questions = array();
			}
			$this->set(compact('unanswered_questions'));
        }
    }
	
	//questionCategory function is for Browse all questions in a category
    public function questionCategory($slug=NULL){
		if($slug=='' && $slug==NULL){
			$this->redirect(['controller' => 'Questions', 'action' => 'all-questions']);
		}else{
			$QuestionCategoriesTable = TableRegistry::get('QuestionCategories');
			$category_data = $QuestionCategoriesTable->find('all',['conditions'=>['QuestionCategories.slug'=>$slug, 'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug']])->first();
			$QuestionsTable = TableRegistry::get('Questions');
			//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
			$featured_question_rightpanel = '';
			$latest_news_rightpanel = $this->getLatestNews();				//mention in AppController
			$question_categories = $this->getTreeQuestionCategoriesSorted();//mention in AppController
			
			$this->visitorlogs('Questions','questionCategory','Question Category',NULL,NULL,NULL,NULL,$category_data['id']);	//Log details insertion
			
			$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id']]];
			$options['conditions'] 	= ['Questions.category_id'=>$category_data['id'],'Questions.status'=>'A'];
			$options['fields'] 		= ['id','name','category_id','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
			$options['order'] 		= ['Questions.created DESC'];
			$options['limit'] 		= $this->limitLatestQuestions;
			$questions = $this->paginate($QuestionsTable, $options);
			$this->set(compact('featured_question_rightpanel','latest_news_rightpanel','question_categories','questions','category_data'));
		}
    }	
	//questionCategory function is for Browse all questions in a category -> Pagination page
	public function questioncategorySearch($slug=NULL){
		if($this->request->is('post')){
			$QuestionCategoriesTable = TableRegistry::get('QuestionCategories');
			$category_data = $QuestionCategoriesTable->find('all',['conditions'=>['QuestionCategories.slug'=>$slug, 'QuestionCategories.status'=>'A'],'fields'=>['QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug']])->first();
			$QuestionsTable = TableRegistry::get('Questions');
			$this->visitorlogs('Questions','questioncategorySearch','More Question From Category',NULL,NULL,NULL,NULL,$category_data['id']);	//Log details insertion
			$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id']]];
			$options['conditions'] 	= ['Questions.category_id'=>$category_data['id'],'Questions.status'=>'A'];
			$options['fields'] 		= ['id','name','category_id','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
			$options['order'] 		= ['Questions.created DESC'];
			$options['limit'] 		= $this->limitLatestQuestions;
			$questions = $this->paginate($QuestionsTable, $options);
			$this->set(compact('questions','category_data'));
        }
    }
	
	//questions details page
	public function details($id=NULL){
		$this->viewBuilder()->layout('question_details');
		if($id=='' && $id==NULL){
			$this->redirect(Router::url(array('controller'=>'Sites','action'=>'home-page'), true));
		}else{
			$id = base64_decode($id);
			$this->visitorlogs('Questions','details','Question Details',NULL,NULL,NULL,$id,NULL);	//Log details insertion
			$QuestionsTable = TableRegistry::get('Questions');
			//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
			$latest_news_rightpanel = $this->getLatestNews();					//mention in AppController
			
			$options['contain'] 	= ['QuestionCategories'=>['fields'=>['QuestionCategories.id','QuestionCategories.parent_id','QuestionCategories.name','QuestionCategories.slug']],'QuestionCategories.ParentCategory'=>['fields'=>['ParentCategory.id','ParentCategory.parent_id','ParentCategory.name','ParentCategory.slug']],'QuestionTags'=>['fields'=>['QuestionTags.id','QuestionTags.question_id','QuestionTags.tag_id'],'Tags'=>['fields'=>['Tags.id','Tags.title']]],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['QuestionAnswer.id','QuestionAnswer.question_id','QuestionAnswer.user_id','QuestionAnswer.learning_path_recommendation','QuestionAnswer.learning_experience','QuestionAnswer.learning_utility','QuestionAnswer.status','QuestionAnswer.created'],'Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['AnswerUpvote.question_id','AnswerUpvote.answer_id']]],/*'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['AnswerUpvote.question_id','AnswerUpvote.answer_id']],*/'QuestionAnswer.AnswerComment'=>['conditions'=>['AnswerComment.status'=>1],'fields'=>['AnswerComment.id','AnswerComment.user_id','AnswerComment.question_id','AnswerComment.answer_id','AnswerComment.comment','AnswerComment.created'],'Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic']]],'QuestionComment'=>['conditions'=>['QuestionComment.status'=>1],'fields'=>['QuestionComment.id','QuestionComment.question_id','QuestionComment.user_id','QuestionComment.comment','QuestionComment.created'],'Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic']]]];
			
			$options['conditions']	= ['Questions.id'=>$id];
			$options['fields']		= ['Questions.id','Questions.category_id','Questions.user_id','Questions.name','Questions.short_description','Questions.learning_goal','Questions.education_history','Questions.budget_constraints','Questions.preferred_learning_mode','Questions.view','Questions.status','Questions.created'];
			$detail = $QuestionsTable->find('all',$options)->first();
			
			//for similar questions
			$option_sq['contain'] 		= ['Users'=>['fields'=>['Users.id','Users.name','Users.profile_pic']]];			
			$option_sq['conditions']	= ['Questions.id !='=>$id, 'Questions.category_id'=>$detail->category_id, 'Questions.status'=>'A'];
			$option_sq['fields']		= ['Questions.id','Questions.category_id','Questions.user_id','Questions.name','Questions.status'];
			$option_sq['limit']			= $this->limitNewsRightPanel;
			$similar_questions = $QuestionsTable->find('all',$option_sq)->toArray();
			//for similar questions
			
			if($detail['status'] == 'I'){
				$this->redirect(['controller' => 'Questions', 'action' => 'all-questions']);
			}
			
			if($detail['view'] == '' && $detail['view'] == NULL){
				$this->request->data['view'] = 1;
				$this->request->data['modified'] = date('Y-m-d H:i:s');
			}else{
				$this->request->data['view'] = ($detail['view']) + 1;
				$this->request->data['modified'] = date('Y-m-d H:i:s');
			}
			$query = $QuestionsTable->query();
			$query->update()
				->set(['view' => $this->request->data['view'], 'modified' => $this->request->data['modified']])
				->where(['id' => $detail['id']])
				->execute();
				
			$title = $detail['name'];
			$this->set(compact('news_detail','all_comments','detail','latest_news_rightpanel','title','similar_questions'));
		}
	}
	
	//question answer submission
	public function postQuestionAnswer(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is('post')){	//form submit
			if( (array_key_exists('learning_path_recommendation',$this->request->data) && $this->request->data['learning_path_recommendation'] != '') && (array_key_exists('learning_experience',$this->request->data) && $this->request->data['learning_experience'] != '') && (array_key_exists('learning_utility',$this->request->data) && $this->request->data['learning_utility'] != '') && (array_key_exists('question_id',$this->request->data) && $this->request->data['question_id'] != '') ){
				$this->request->data['user_ip'] = $this->getUserIP();
				$active_permission = $this->getSiteSettings();	//getting approval permission mentioned in AppController
				if(!empty($active_permission)){
					if($active_permission['question_approval']==1){
						$this->request->data['status'] 		= 'A';
					}else{
						$this->request->data['status'] 		= 'I';
					}
				}else{
					$this->request->data['status'] 		= 'I';
				}
				$this->request->data['question_id'] = isset($this->request->data['question_id'])?base64_decode($this->request->data['question_id']):0;

				$QuestionsTable			= TableRegistry::get('Questions');
				$option_1['fields']		= ['Questions.id','Questions.user_id','Questions.name','Questions.short_description'];
				$options_1['conditions']= ['Questions.id'=>$this->request->data['question_id']];
				$det = $QuestionsTable->find('all',$options_1)->first();
				if(!empty($det)){
					if($det['user_id'] != $this->Auth->user('id')){
						$this->request->data['user_id'] 	= $this->Auth->user('id');
						$questionAnswersTable = TableRegistry::get('QuestionAnswer');
						
						$session = $this->request->session();
						//If session question id exist then update data
						if( $session->read('questionanswerid') != '' ) {
							$qstn_ansr_data = $questionAnswersTable->find('all', ['conditions'=>array('id'=>$session->read('questionanswerid'),'question_id'=>$this->request->data['question_id'],'user_id'=>$this->Auth->user('id'))])->first();
							$data_to_update = $questionAnswersTable->patchEntity($qstn_ansr_data, $this->request->data);					
							if($savedData = $questionAnswersTable->save($data_to_update)){
								$this->visitorlogs('Questions','postQuestionAnswer','Question Answer Submission',NULL,NULL,NULL,$this->request->data['question_id'],NULL);	//Log details insertion
								//if question submitter wants notification for new answer
								$question_submitter_acccount_setting = $this->getAccountSetting($det->user_id);
								if((!empty($question_submitter_acccount_setting)) && ($question_submitter_acccount_setting['response_to_my_question_notification']==1)){
									$url = Router::url('/', true).'questions/details/'.base64_encode($this->request->data['question_id']);
									$settings = $this->getSiteSettings();
									$UsersTable		= TableRegistry::get('Users');
									$question_submitter_details = $UsersTable->find('all',['conditions'=>['Users.id'=>$det->user_id],'fields'=>['id','name','email','notification_email']])->first();
									$question_title = $det['name'];
									$loggedin_user_data = $this->Auth->user();
									$notify_type = 'Answer';
									$this->Email->sendQuestionNotificationEmail($url, $settings, $question_title, $loggedin_user_data, $question_submitter_details, $notify_type);
								}
								
								$session->delete('questionanswerid');
								
								//if question submitter wants notification for new answer
								if(!empty($active_permission)){
									if($active_permission['question_approval']==1){
										echo json_encode(['submission'=>'success']);
									}else{
										echo json_encode(['submission'=>'success_approval']);
									}
								}else{
									echo json_encode(['submission'=>'success_approval']);
								}
								exit();
							}
							else {
								echo json_encode(['submission'=>'failed']);
								exit();
							}
						}
						//Session question answer id empty so insert a new one
						else{
							$new = $questionAnswersTable->newEntity();
							$data_to_insert = $questionAnswersTable->patchEntity($new, $this->request->data);						
							if($questionAnswersTable->save($data_to_insert)){
								$this->visitorlogs('Questions','postQuestionAnswer','Question Answer Submission',NULL,NULL,NULL,$this->request->data['question_id'],NULL);	//Log details insertion
								//if question submitter wants notification for new answer
								$question_submitter_acccount_setting = $this->getAccountSetting($det->user_id);
								if((!empty($question_submitter_acccount_setting)) && ($question_submitter_acccount_setting['response_to_my_question_notification']==1)){
									$url = Router::url('/', true).'questions/details/'.base64_encode($this->request->data['question_id']);
									$settings = $this->getSiteSettings();
									$UsersTable		= TableRegistry::get('Users');
									$question_submitter_details = $UsersTable->find('all',['conditions'=>['Users.id'=>$det->user_id],'fields'=>['id','name','email','notification_email']])->first();
									$question_title = $det['name'];
									$loggedin_user_data = $this->Auth->user();
									$notify_type = 'Answer';
									$this->Email->sendQuestionNotificationEmail($url, $settings, $question_title, $loggedin_user_data, $question_submitter_details, $notify_type);
								}
								
								$session->delete('questionanswerid');
								
								//if question submitter wants notification for new answer
								if(!empty($active_permission)){
									if($active_permission['question_approval']==1){
										echo json_encode(['submission'=>'success']);
									}else{
										echo json_encode(['submission'=>'success_approval']);
									}
								}else{
									echo json_encode(['submission'=>'success_approval']);
								}
								exit();
							}else{
								echo json_encode(['submission'=>'failed']);
								exit();
							}
						}
					}else{
						echo json_encode(['submission'=>'same_user']);
						exit();
					}
				}else{
					echo json_encode(['submission'=>'failed']);
					exit();
				}				
			}else{
				$this->Flash->error(__('All fields are mandatory.'));
				echo json_encode(['submission'=>'fields_missing']);
				exit();
			}
		}
	}
	
	//question answer submission as DRAFT
	public function postQuestionAnswerASDraft(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is(['post','put'])){	//form submit
			$this->request->data['user_ip'] = $this->getUserIP();
			$this->request->data['status'] 	= 'D';			
			$this->request->data['question_id'] = isset($this->request->data['question_id'])?base64_decode($this->request->data['question_id']):0;
			$QuestionsTable			= TableRegistry::get('Questions');
			$option_1['fields']		= ['Questions.id','Questions.user_id','Questions.name','Questions.short_description'];
			$options_1['conditions']= ['Questions.id'=>$this->request->data['question_id']];
			$det = $QuestionsTable->find('all',$options_1)->first();
			if(!empty($det)){
				if($det['user_id'] != $this->Auth->user('id')){
					$this->request->data['user_id'] = $this->Auth->user('id');
					$questionAnswersTable = TableRegistry::get('QuestionAnswer');
					
					$session = $this->request->session();						
					$count_qstn_ansr = $questionAnswersTable->find('all', ['conditions'=>array('id'=>$session->read('questionanswerid'),'question_id'=>$this->request->data['question_id'],'user_id'=>$this->Auth->user('id'))])->count();
					if( $count_qstn_ansr > 0 ){ //Update section							
						$qstn_ansr_data = $questionAnswersTable->find('all', ['conditions'=>array('id'=>$session->read('questionanswerid'),'question_id'=>$this->request->data['question_id'],'user_id'=>$this->Auth->user('id'))])->first();
						$data_to_update = $questionAnswersTable->patchEntity($qstn_ansr_data, $this->request->data);					
						if($savedData = $questionAnswersTable->save($data_to_update)){
							echo 1;
							exit();
						}else{
							echo 0;
							exit();
						}
					}
					else{	//Session question answer id empty so Insert new one
						$new = $questionAnswersTable->newEntity();
						$data_to_insert = $questionAnswersTable->patchEntity($new, $this->request->data);						
						if($savedData = $questionAnswersTable->save($data_to_insert)){
							$get_last_insert_id = $savedData->id;
							$session->write('questionanswerid',$get_last_insert_id);
							echo 1;
							exit();
						}else{
							echo 0;
							exit();
						}
					}
				}
			}else{
				echo 0;
				exit();
			}			
		}
	}
	
	//question comment submission
	public function postQuestionComment(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is('post')){	//form submit
			if( (array_key_exists('question_id',$this->request->data) && $this->request->data['question_id'] != '') ){
				if(empty($this->Auth->user())){
					echo json_encode(['submission'=>'user_not_logged_in']);
					exit();
				}else{
					$this->request->data['user_ip'] 	= $this->getUserIP();
					$active_permission = $this->getSiteSettings();	//getting approval permission mentioned in AppController
					if(!empty($active_permission)){
						if($active_permission['question_comment_approval']==1){
							$this->request->data['status'] 		= 1;
						}else{
							$this->request->data['status'] 		= 0;
						}
					}else{
						$this->request->data['status'] 		= 0;
					}
					$this->request->data['question_id'] = isset($this->request->data['question_id'])?base64_decode($this->request->data['question_id']):0;
					$this->request->data['comment'] = isset($this->request->data['question_comment'])?$this->request->data['question_comment']:'';					
					$QuestionsTable			= TableRegistry::get('Questions');
					$option['fields']		= ['Questions.id','Questions.user_id','Questions.name','Questions.short_description'];
					$option['conditions']	= ['Questions.id'=>$this->request->data['question_id']];
					$det = $QuestionsTable->find('all',$option)->first();
					if(!empty($det)){
						if($det['user_id'] != $this->Auth->user('id')){
							$QuestionCommentTable	= TableRegistry::get('QuestionComment');
							
							$session = $this->request->session();
							//If session question comment id exist then update data
							if( $session->read('questioncommentid') != '' ){
								
								$options_1['conditions']= ['QuestionComment.id !='=>$session->read('questioncommentid'),'QuestionComment.question_id'=>$this->request->data['question_id'],'QuestionComment.user_id'=>$this->Auth->user('id')];
								$count = $QuestionCommentTable->find('all',$options_1)->count();
								if($count == 0){
									$qstn_comment_data = $QuestionCommentTable->find('all', ['conditions'=>array('id'=>$session->read('questioncommentid'),'question_id'=>$this->request->data['question_id'],'user_id'=>$this->Auth->user('id'))])->first();
									$data_to_update = $QuestionCommentTable->patchEntity($qstn_comment_data, $this->request->data);
									if($QuestionCommentTable->save($data_to_update)){
										$this->visitorlogs('Questions','postQuestionComment','Question Comment Submission',NULL,NULL,NULL,$this->request->data['question_id'],NULL);	//Log details insertion
										//if question submitter wants notification for new share a comment (question)
										$question_submitter_acccount_setting = $this->getAccountSetting($det->user_id);
										if((!empty($question_submitter_acccount_setting)) && ($question_submitter_acccount_setting['response_to_my_question_notification']==1)){
											$url = Router::url('/', true).'questions/details/'.base64_encode($this->request->data['question_id']);
											$settings = $this->getSiteSettings();
											$UsersTable		= TableRegistry::get('Users');
											$question_submitter_details = $UsersTable->find('all',['conditions'=>['Users.id'=>$det->user_id],'fields'=>['id','name','email','notification_email']])->first();
											$question_title = $det['name'];
											$loggedin_user_data = $this->Auth->user();
											$notify_type = 'Comment';
											$this->Email->sendQuestionNotificationEmail($url, $settings, $question_title, $loggedin_user_data, $question_submitter_details, $notify_type);
										}
										
										$session->delete('questioncommentid');
										
										//if question submitter wants notification for new share a comment (question)
										if(!empty($active_permission)){
											if($active_permission['question_comment_approval']==1){
												echo json_encode(['submission'=>'success']);
											}else{
												echo json_encode(['submission'=>'success_approval']);
											}
										}else{
											echo json_encode(['submission'=>'success_approval']);
										}
										exit();
									}else{
										echo json_encode(['submission'=>'failed']);
										exit();
									}
								}else{
									echo json_encode(['submission'=>'already_posted']);
									exit();
								}							
							}
							//Session question comment id empty so insert a new one
							else{
								$options_1['conditions']= ['QuestionComment.question_id'=>$this->request->data['question_id'],'QuestionComment.user_id'=>$this->Auth->user('id')];
								$count = $QuestionCommentTable->find('all',$options_1)->count();
								if($count == 0){
									$this->request->data['user_id'] = $this->Auth->user('id');
									$new = $QuestionCommentTable->newEntity();
									$data_to_insert = $QuestionCommentTable->patchEntity($new, $this->request->data);
									if($QuestionCommentTable->save($data_to_insert)){
										$this->visitorlogs('Questions','postQuestionComment','Question Comment Submission',NULL,NULL,NULL,$this->request->data['question_id'],NULL);	//Log details insertion
										//if question submitter wants notification for new share a comment (question)
										$question_submitter_acccount_setting = $this->getAccountSetting($det->user_id);
										if((!empty($question_submitter_acccount_setting)) && ($question_submitter_acccount_setting['response_to_my_question_notification']==1)){
											$url = Router::url('/', true).'questions/details/'.base64_encode($this->request->data['question_id']);
											$settings = $this->getSiteSettings();
											$UsersTable		= TableRegistry::get('Users');
											$question_submitter_details = $UsersTable->find('all',['conditions'=>['Users.id'=>$det->user_id],'fields'=>['id','name','email','notification_email']])->first();
											$question_title = $det['name'];
											$loggedin_user_data = $this->Auth->user();
											$notify_type = 'Comment';
											$this->Email->sendQuestionNotificationEmail($url, $settings, $question_title, $loggedin_user_data, $question_submitter_details, $notify_type);
										}
										//if question submitter wants notification for new share a comment (question)
										if(!empty($active_permission)){
											if($active_permission['question_comment_approval']==1){
												echo json_encode(['submission'=>'success']);
											}else{
												echo json_encode(['submission'=>'success_approval']);
											}
										}else{
											echo json_encode(['submission'=>'success_approval']);
										}
										exit();
									}else{
										echo json_encode(['submission'=>'failed']);
										exit();
									}
								}else{
									echo json_encode(['submission'=>'already_posted']);
									exit();
								}
							}
						}else{
							echo json_encode(['submission'=>'same_user']);
							exit();
						}
					}
					else{
						echo json_encode(['submission'=>'failed']);
						exit();
					}
				}
			}else{
				$this->Flash->error(__('All fields are mandatory.'));
				echo json_encode(['submission'=>'fields_missing']);
				exit();
			}
		}
	}
	
	//question Comment submission as DRAFT
	public function postQuestionCommentAsDraft(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is(['POST','PUT'])){		//form submit
			$this->request->data['user_ip'] 	= $this->getUserIP();
			$this->request->data['status'] 		= '2';
			$this->request->data['question_id'] = isset($this->request->data['question_id'])?base64_decode($this->request->data['question_id']):0;
			$this->request->data['comment'] 	= isset($this->request->data['question_comment'])?$this->request->data['question_comment']:'';					
			$QuestionsTable			= TableRegistry::get('Questions');
			$option['fields']		= ['Questions.id','Questions.user_id','Questions.name','Questions.short_description'];
			$option['conditions']	= ['Questions.id'=>$this->request->data['question_id']];
			$det = $QuestionsTable->find('all',$option)->first();
			if(!empty($det)){
				if($det['user_id'] != $this->Auth->user('id')){
					$QuestionCommentTable	= TableRegistry::get('QuestionComment');
					
					$session = $this->request->session();
					
					$options_1['conditions']= [
												'QuestionComment.id !=' => $session->read('questioncommentid'),
												'QuestionComment.question_id'=> $this->request->data['question_id'],
												'QuestionComment.user_id'	=> $this->Auth->user('id')
											   ];
					$count = $QuestionCommentTable->find('all',$options_1)->count();
					if($count == 0){
						$count_qstn_cmnt = $QuestionCommentTable->find('all',['conditions'=>['QuestionComment.id' => $session->read('questioncommentid')]])->count();
						if( $count_qstn_cmnt > 0 ){ //Update section							
							$qstn_cmnt_data = $QuestionCommentTable->find('all', ['conditions'=>array('QuestionComment.id'=>$session->read('questioncommentid'))])->first();
							$data_to_update = $QuestionCommentTable->patchEntity($qstn_cmnt_data, $this->request->data);
							if($savedData 	= $QuestionCommentTable->save($data_to_update)){
								echo 1;
								exit();
							}else{
								echo 0;
								exit();
							}
						}
						else{	//Session question comment id empty so Insert new one
							$this->request->data['user_id'] = $this->Auth->user('id');
							$new = $QuestionCommentTable->newEntity();
							$data_to_insert = $QuestionCommentTable->patchEntity($new, $this->request->data);
							if($savedData 	= $QuestionCommentTable->save($data_to_insert)){
								$get_last_insert_id = $savedData->id;
								$session->write('questioncommentid',$get_last_insert_id);
							
								echo 1;
								exit();
							}else{
								echo 0;
								exit();
							}
						}
					}
					else{
						echo 2;
						exit();
					}
				}
			}
		}
	}
	
	//answer comment submission
	public function postAnswerComment(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is('post')){	//form submit
			if( (array_key_exists('question_id',$this->request->data) && $this->request->data['question_id'] != '') && (array_key_exists('answer_id',$this->request->data) && $this->request->data['answer_id'] != '') && (array_key_exists('answer_user_id',$this->request->data) && $this->request->data['answer_user_id'] != '') && (array_key_exists('answer_comment',$this->request->data) && $this->request->data['answer_comment'] != '') ){
				if(empty($this->Auth->user())){
					echo json_encode(['submission'=>'user_not_logged_in']);
					exit();
				}else{
					$this->request->data['user_ip'] 	= $this->getUserIP();
					$active_permission = $this->getSiteSettings();	//getting approval permission mentioned in AppController
					if(!empty($active_permission)){
						if($active_permission['answer_comment_approval']==1){
							$this->request->data['status'] 		= 1;
						}else{
							$this->request->data['status'] 		= 0;
						}
					}else{
						$this->request->data['status'] 		= 0;
					}
					$this->request->data['question_id'] = isset($this->request->data['question_id'])?base64_decode($this->request->data['question_id']):0;
					$this->request->data['answer_id'] 	= isset($this->request->data['answer_id'])?base64_decode($this->request->data['answer_id']):0;
					$this->request->data['answer_user_id'] 	= isset($this->request->data['answer_user_id'])?base64_decode($this->request->data['answer_user_id']):0;
					$this->request->data['comment'] 	= isset($this->request->data['answer_comment'])?$this->request->data['answer_comment']:'';
					
					$this->visitorlogs('Questions','postAnswerComment','Answer Comment Submission',NULL,NULL,NULL,$this->request->data['question_id'],NULL,$this->request->data['answer_id']);	//Log details insertion
					
					$QuestionsTable				= TableRegistry::get('Questions');
					$ques_option['fields']		= ['Questions.id','Questions.user_id','Questions.name','Questions.short_description'];
					$ques_option['conditions']	= ['Questions.id'=>$this->request->data['question_id']];
					$ques_det = $QuestionsTable->find('all',$ques_option)->first();
					
					$QuestionAnswerTable	= TableRegistry::get('QuestionAnswer');
					$option['fields']		= ['QuestionAnswer.id','QuestionAnswer.question_id','QuestionAnswer.user_id'];
					$option['conditions']	= ['QuestionAnswer.question_id'=>$this->request->data['question_id'],'QuestionAnswer.user_id'=>$this->request->data['answer_user_id']];
					$det = $QuestionAnswerTable->find('all',$option)->first();
					if(!empty($det)){
						if($det['user_id'] != $this->Auth->user('id')){
							$AnswerCommentTable	= TableRegistry::get('AnswerComment');
							
							$session = $this->request->session();
							//If session question comment id exist then update data
							if( $session->read('questioncommentid') != '' ){
							
								$options_1['conditions']= ['AnswerComment.id !='=>$session->read('questionanswercommentid'),'AnswerComment.question_id'=>$this->request->data['question_id'],'AnswerComment.answer_id'=>$this->request->data['answer_id'],'AnswerComment.user_id'=>$this->Auth->user('id')];
								$count = $AnswerCommentTable->find('all',$options_1)->count();
								if($count == 0){
							
									$qstn_ansr_comment_data = $AnswerCommentTable->find('all', ['conditions'=>array('id'=>$session->read('questionanswercommentid'),'question_id'=>$this->request->data['question_id'],'user_id'=>$this->Auth->user('id'))])->first();
									$data_to_update = $AnswerCommentTable->patchEntity($qstn_ansr_comment_data, $this->request->data);
									if($AnswerCommentTable->save($data_to_update)){
										//if answer submitter wants notification for new share a comment (answer)
										$question_submitter_acccount_setting = $this->getAccountSetting($this->request->data['answer_user_id']);
										if((!empty($question_submitter_acccount_setting)) && ($question_submitter_acccount_setting['response_to_my_question_notification']==1)){
											$url = Router::url('/', true).'questions/details/'.base64_encode($this->request->data['question_id']);
											$settings = $this->getSiteSettings();
											$UsersTable		= TableRegistry::get('Users');
											$answer_submitter_details = $UsersTable->find('all',['conditions'=>['Users.id'=>$this->request->data['answer_user_id']],'fields'=>['id','name','email','notification_email']])->first();
											$question_title = $ques_det['name'];
											$loggedin_user_data = $this->Auth->user();
											$notify_type = 'Answer Comment';
											$this->Email->sendQuestionNotificationEmail($url, $settings, $question_title, $loggedin_user_data, $answer_submitter_details, $notify_type);
										}
										
										$session->delete('questioncommentid');
										
										//if answer submitter wants notification for new share a comment (answer)
										$active_permission = $this->getSiteSettings();	//getting approval permission mentioned in AppController
										if(!empty($active_permission)){
											if($active_permission['answer_comment_approval']==1){
												echo json_encode(['submission'=>'success']);
											}else{
												echo json_encode(['submission'=>'success_approval']);
											}
										}else{
											echo json_encode(['submission'=>'success_approval']);
										}
										exit();
									}
									else{
										echo json_encode(['submission'=>'failed']);
										exit();
									}
								}
								else{
									echo json_encode(['submission'=>'already_posted']);
									exit();
								}
							}
							//Session question answer comment id empty so insert a new one
							else{
								$options_1['conditions']= ['AnswerComment.question_id'=>$this->request->data['question_id'],'AnswerComment.answer_id'=>$this->request->data['answer_id'],'AnswerComment.user_id'=>$this->Auth->user('id')];
								$count = $AnswerCommentTable->find('all',$options_1)->count();
								if($count == 0){
									$this->request->data['user_id'] = $this->Auth->user('id');
									$new = $AnswerCommentTable->newEntity();
									$data_to_insert = $AnswerCommentTable->patchEntity($new, $this->request->data);
									if($AnswerCommentTable->save($data_to_insert)){
										//if answer submitter wants notification for new share a comment (answer)
										$question_submitter_acccount_setting = $this->getAccountSetting($this->request->data['answer_user_id']);
										if((!empty($question_submitter_acccount_setting)) && ($question_submitter_acccount_setting['response_to_my_question_notification']==1)){
											$url = Router::url('/', true).'questions/details/'.base64_encode($this->request->data['question_id']);
											$settings = $this->getSiteSettings();
											$UsersTable		= TableRegistry::get('Users');
											$answer_submitter_details = $UsersTable->find('all',['conditions'=>['Users.id'=>$this->request->data['answer_user_id']],'fields'=>['id','name','email','notification_email']])->first();
											$question_title = $ques_det['name'];
											$loggedin_user_data = $this->Auth->user();
											$notify_type = 'Answer Comment';
											$this->Email->sendQuestionNotificationEmail($url, $settings, $question_title, $loggedin_user_data, $answer_submitter_details, $notify_type);
										}
										//if answer submitter wants notification for new share a comment (answer)
										$active_permission = $this->getSiteSettings();	//getting approval permission mentioned in AppController
										if(!empty($active_permission)){
											if($active_permission['answer_comment_approval']==1){
												echo json_encode(['submission'=>'success']);
											}else{
												echo json_encode(['submission'=>'success_approval']);
											}
										}else{
											echo json_encode(['submission'=>'success_approval']);
										}
										exit();
									}else{
										echo json_encode(['submission'=>'failed']);
										exit();
									}								
								}else{
									echo json_encode(['submission'=>'already_posted']);
									exit();
								}
							}							
						}else{
							echo json_encode(['submission'=>'same_user']);
							exit();
						}
					}
					else{
						echo json_encode(['submission'=>'failed']);
						exit();
					}
				}
			}else{
				$this->Flash->error(__('All fields are mandatory.'));
				echo json_encode(['submission'=>'fields_missing']);
				exit();
			}
		}
	}
	
	//Answer Comment submission as DRAFT
	public function postAnswerCommentAsDraft(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is(['POST','PUT'])){		//form submit
			$this->request->data['user_ip'] 	= $this->getUserIP();
			$this->request->data['status'] 		= '2';			
			$this->request->data['question_id'] = isset($this->request->data['question_id'])?base64_decode($this->request->data['question_id']):0;
			$this->request->data['answer_id'] 	= isset($this->request->data['answer_id'])?base64_decode($this->request->data['answer_id']):0;
			$this->request->data['answer_user_id'] 	= isset($this->request->data['answer_user_id'])?base64_decode($this->request->data['answer_user_id']):0;
			$this->request->data['comment'] 	= isset($this->request->data['answer_comment'])?$this->request->data['answer_comment']:'';
			
			$QuestionAnswerTable	= TableRegistry::get('QuestionAnswer');
			$option['fields']		= ['QuestionAnswer.id','QuestionAnswer.question_id','QuestionAnswer.user_id'];
			$option['conditions']	= ['QuestionAnswer.question_id'=>$this->request->data['question_id'],'QuestionAnswer.user_id'=>$this->request->data['answer_user_id']];
			$det = $QuestionAnswerTable->find('all',$option)->first();
			if(!empty($det)){
				if($det['user_id'] != $this->Auth->user('id')){
					$AnswerCommentTable	= TableRegistry::get('AnswerComment');
					
					$session = $this->request->session();
					
					$options_1['conditions']= ['AnswerComment.id !=' => $session->read('questionanswercommentid'),'AnswerComment.question_id'=>$this->request->data['question_id'],'AnswerComment.answer_id'=>$this->request->data['answer_id'],'AnswerComment.user_id'=>$this->Auth->user('id')];
					$count = $AnswerCommentTable->find('all',$options_1)->count();					
					if($count == 0){						
						$count_qstn_ansr_cmnt = $AnswerCommentTable->find('all',['conditions'=>['id' => $session->read('questionanswercommentid')]])->count();
						if( $count_qstn_ansr_cmnt > 0 ){ //Update section							
							$qstn_ansr_cmnt_data = $AnswerCommentTable->find('all', ['conditions'=>array('id'=>$session->read('questionanswercommentid'))])->first();
							$data_to_update = $AnswerCommentTable->patchEntity($qstn_ansr_cmnt_data, $this->request->data);
							if($savedData 	= $AnswerCommentTable->save($data_to_update)){
								echo 1;
								exit();
							}else{
								echo 0;
								exit();
							}
						}
						else{	//Session question answer comment id empty so Insert new one
							$this->request->data['user_id'] = $this->Auth->user('id');
							$new = $AnswerCommentTable->newEntity();
							$data_to_insert = $AnswerCommentTable->patchEntity($new, $this->request->data);
							if($savedData 	= $AnswerCommentTable->save($data_to_insert)){
								$get_last_insert_id = $savedData->id;
								$session->write('questionanswercommentid',$get_last_insert_id);
							
								echo 1;
								exit();
							}else{
								echo 0;
								exit();
							}
						}						
					}else{
						echo 2;
						exit();
					}
				}else{
					echo 2;
					exit();
				}
			}
			else{
				echo 2;
				exit();
			}			
		}
	}
	
	//answer upvote submission
	public function ajaxAnswerUpvote(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is('post')){	//form submit
			if( (array_key_exists('question_id',$this->request->data) && $this->request->data['question_id'] != '') && (array_key_exists('answer_id',$this->request->data) && $this->request->data['answer_id'] != '') && (array_key_exists('answer_user_id',$this->request->data) && $this->request->data['answer_user_id'] != '') ){
				if(empty($this->Auth->user())){
					echo json_encode(['submission'=>'user_not_logged_in']);
					exit();
				}else{
					$this->request->data['user_ip'] 	= $this->getUserIP();
					$this->request->data['status'] 		= 1;
					$this->request->data['question_id'] = isset($this->request->data['question_id'])?$this->request->data['question_id']:0;
					$this->request->data['answer_id'] 	= isset($this->request->data['answer_id'])?$this->request->data['answer_id']:0;
					$this->request->data['answer_user_id'] 	= isset($this->request->data['answer_user_id'])?$this->request->data['answer_user_id']:0;
					
					$this->visitorlogs('Questions','ajaxAnswerUpvote','Answer Upvote Submission',NULL,NULL,NULL,$this->request->data['question_id'],NULL,$this->request->data['answer_id']);	//Log details insertion
					
					$AnswerUpvoteTable	= TableRegistry::get('AnswerUpvote');
					$options_1['conditions']= ['AnswerUpvote.question_id'=>$this->request->data['question_id'],'AnswerUpvote.answer_id'=>$this->request->data['answer_id'],'AnswerUpvote.user_id'=>$this->Auth->user('id')];
					$count = $AnswerUpvoteTable->find('all',$options_1)->count();
					if($count == 0){
						$this->request->data['user_id'] = $this->Auth->user('id');
						$new = $AnswerUpvoteTable->newEntity();
						$data_to_insert = $AnswerUpvoteTable->patchEntity($new, $this->request->data);
						if($AnswerUpvoteTable->save($data_to_insert)){
							echo 'success';
							exit();
						}else{
							echo 'failed';
							exit();
						}								
					}else{
						echo 'already_posted';
						exit();
					}
				}
			}
		}
	}
	
	//All answer comments
	public function ajaxAllAnswerComments(){
        if($this->request->is('post')){
			$answer_id = isset($this->request->data['answer_id'])?$this->request->data['answer_id']:0;
			$this->visitorlogs('Questions','ajaxAllAnswerComments','Answer Comment Listing',NULL,NULL,NULL,NULL,NULL,$answer_id);	//Log details insertion
			
			$AnswerCommentTable = TableRegistry::get('AnswerComment');			
			$options['contain'] 	= ['Users'=>['fields'=>['id','name','profile_pic']]];
			$options['conditions'] 	= ['AnswerComment.answer_id'=>$answer_id,'AnswerComment.status'=>1];
			$options['fields'] 		= ['AnswerComment.id','AnswerComment.user_id','AnswerComment.answer_id','AnswerComment.comment','AnswerComment.created'];
			$options['order'] 		= ['AnswerComment.id DESC'];
			$all_comments = $AnswerCommentTable->find('all', $options)->toArray();
			//pr($all_comments); die;
			$this->set(compact('all_comments'));
        }
    }
	
	//All question comments
	public function ajaxAllQuestionComments(){
        if($this->request->is('post')){
			$question_id = isset($this->request->data['question_id'])?base64_decode($this->request->data['question_id']):0;
			$this->visitorlogs('Questions','ajaxAllQuestionComments','Question Comment Listing',NULL,NULL,NULL,$question_id,NULL,NULL);	//Log details insertion
			$QuestionCommentTable = TableRegistry::get('QuestionComment');			
			$options['contain'] 	= ['Users'=>['fields'=>['id','name','profile_pic']]];
			$options['conditions'] 	= ['QuestionComment.question_id'=>$question_id,'QuestionComment.status'=>1];
			$options['fields'] 		= ['QuestionComment.id','QuestionComment.user_id','QuestionComment.comment','QuestionComment.created'];
			$options['order'] 		= ['QuestionComment.id DESC'];
			$all_comments = $QuestionCommentTable->find('all', $options)->toArray();
			//pr($all_comments); die;
			$this->set(compact('all_comments'));
        }
    }
	
	//questionTag function is for Browse all questions in a tag
    public function questionTag($slug=NULL){
		if($slug=='' && $slug==NULL){
			$this->redirect(['controller' => 'Questions', 'action' => 'all-questions']);
		}else{
			$TagsTable = TableRegistry::get('Tags');
			$tagdata = $TagsTable->find('all', ['conditions'=>['Tags.status'=>'A','Tags.slug'=>$slug],'fields'=>['id','title','slug']])->first();
			//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
			$featured_question_rightpanel = '';
			$latest_news_rightpanel = $this->getLatestNews();				//mention in AppController
			$question_categories = $this->getTreeQuestionCategoriesSorted();//mention in AppController
			
			$QuestionTagsTable = TableRegistry::get('QuestionTags');
			$question_ids = $QuestionTagsTable->find('list',['conditions'=>['tag_id'=>$tagdata['id']],'keyField'=>'0','valueField'=>'question_id'])->toArray();
			$this->visitorlogs('Questions','questionTag','Tag Related Questions',NULL,NULL,NULL,NULL,NULL,NULL,$tagdata['id']);	//Log details insertion
			if(!empty($question_ids)){
				$QuestionsTable = TableRegistry::get('Questions');
				$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id']]];
				$options['conditions'] 	= ['Questions.id IN'=>$question_ids,'Questions.status'=>'A'];
				$options['fields'] 		= ['id','name','category_id','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name'];
				$options['order'] 		= ['Questions.created DESC'];
				$options['limit'] 		= $this->limitLatestQuestions;
				$questions = $this->paginate($QuestionsTable, $options);
			}else{
				$questions = array();
			}
			$this->set(compact('featured_question_rightpanel','latest_news_rightpanel','question_categories','questions','tagdata'));
		}
    }
	
	//questiontagSearch function is for Browse all questions in a tag -> Pagination page
	public function questiontagSearch($slug=NULL){
		if($this->request->is('post')){
			$TagsTable = TableRegistry::get('Tags');
			$tagdata = $TagsTable->find('all', ['conditions'=>['Tags.status'=>'A','Tags.slug'=>$slug],'fields'=>['id','title','slug']])->first();
			$this->visitorlogs('Questions','questiontagSearch','More Tag Related Questions',NULL,NULL,NULL,NULL,NULL,NULL,$tagdata['id']);	//Log details insertion
			$QuestionTagsTable = TableRegistry::get('QuestionTags');
			$question_ids = $QuestionTagsTable->find('list',['conditions'=>['tag_id'=>$tagdata['id']],'keyField'=>'0','valueField'=>'question_id']);
			if(!empty($question_ids)){
				$QuestionsTable = TableRegistry::get('Questions');
				$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['id','question_id']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id']]];
				$options['conditions'] 	= ['Questions.id IN'=>$question_ids,'Questions.status'=>'A'];
				$options['fields'] 		= ['id','name','category_id','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name'];
				$options['order'] 		= ['Questions.created DESC'];
				$options['limit'] 		= $this->limitLatestQuestions;
				$questions = $this->paginate($QuestionsTable, $options);
			}else{
				$questions = array();
			}
			$this->set(compact('featured_question_rightpanel','latest_news_rightpanel','question_categories','questions'));
        }
    }
	
	/******************************************* User Edit Section Start ********************************************/
	
	//Edit submitted Question
	public function editSubmittedQuestion($id=NULL){
		if($id == NULL){
            return $this->redirect(['controller' => '/', 'action' => 'viewSubmissions']);
        }
		$this->viewBuilder()->layout('postquestion');
		$title = 'Edit Post Question';
		$FaqsTable = TableRegistry::get('Faqs');
		$all_faqs = $FaqsTable->find('all',['conditions'=>['status'=>'A'],'order'=>['id'=>'ASC']])->toArray();
		
		$id = base64_decode($id);
		$QuestionsTable = TableRegistry::get('Questions');
		$this->visitorlogs('Questions','editSubmittedQuestion','Edited Question',NULL,NULL,NULL,$id,NULL,NULL,NULL);	//Log details insertion
		$question_categories = $this->getQuestionCategoriesSorted();	//mention in AppController
		$TagsTable = TableRegistry::get('Tags');
		//$all_tags = $TagsTable->find('list', ['conditions'=>['Tags.status'=>'A'], 'keyField'=>'id','valueField'=>'title'])->toArray();
		$all_tags = $TagsTable->find('list', [
										'keyField' => 'id',
										'valueField' => 'title'
									])
								->where(['Tags.status' => 'A'])
								->order(['Tags.title' => 'ASC'])
								->toArray();
		$existing_data =  $QuestionsTable->get($id,['contain'=>['Users'=>['fields'=>['id','name']], 'QuestionCategories'=>['fields'=>['id','name']], 'QuestionTags'=>['fields'=>['id','question_id','tag_id']]]]);
		
		if($this->request->is(['post', 'put'])){
			if(array_key_exists('is_featured',$this->request->data)){
				if($this->request->data['is_featured'] != 0){$this->request->data['is_featured'] = 'Y';}else{$this->request->data['is_featured'] = 'N';}
			}
			$new_question = $QuestionsTable->newEntity();
			$this->request->data['modified'] = date('Y-m-d H:i:s');			
			if( $existing_data->status == 'D' ) {
				$this->request->data['status'] = 'A';
			}			
			$inserted_data = $QuestionsTable->patchEntity($existing_data, $this->request->data);
			//$send_data = $QuestionsTable->patchEntity($existing_data, $this->request->data);
			if ($savedData = $QuestionsTable->save($inserted_data)) {
				$get_last_insert_id = $savedData->id;
				$QuestionTagsTable = TableRegistry::get('QuestionTags');
				$question_tags_data = $QuestionTagsTable->find('list', ['conditions'=>array('QuestionTags.question_id'=>$id),'fields' => ['QuestionTags.id']])->toArray();
				$QuestionTagsTable->deleteAll(['id IN' => $question_tags_data]);
				if(!empty($this->request->data['tags'])){
					$QuestionTagsTable = TableRegistry::get('Admin.QuestionTags');
					foreach( $this->request->data['tags'] as $key_tag_data => $val_tag_data ){
						$tag_data['QuestionTags']['question_id'] = $get_last_insert_id;
						$tag_data['QuestionTags']['tag_id'] = $val_tag_data;
						$TagNewEntity = $QuestionTagsTable->newEntity();
						$inserted_data = $QuestionTagsTable->patchEntity($TagNewEntity, $tag_data);
						$QuestionTagsTable->save($inserted_data);
					}
				}				
				//sending notification to the question submitter person
				/*if($this->request->data['status'] == 'A'){
					if($send_data['user_type'] == 'U' && $send_data['user_id'] != NULL){
						$get_data = $this->getAccountSetting($send_data['user_id']);
						if(!empty($get_data) && ($get_data->response_to_my_question_notification==1)){
							$UserTable = TableRegistry::get('Admin.Users');
							$user_data = $UserTable->find('all', ['conditions'=>['id'=>$send_data['user_id']],'fields'=>['id','name','email','full_name','notification_email']])->first()->toArray();
							if(!empty($user_data)){
								$url = Router::url('/', true).'questions/details/'.base64_encode($get_last_insert_id);
								$settings = $this->getSiteSettings();
								if($user_data['notification_email'] != '')$user_email = $user_data['notification_email']; else $user_email = $user_data['email'];
								$this->AdminEmail->questionEditNotification($url, $user_email, $user_data, $this->request->data, $settings);
							}
						}
					}
				}*/
				//sending notification to the question submitter person
                $this->Flash->success(__('Question has been successfully updated'));
                return $this->redirect(['controller' => '/','action' => 'viewSubmissions']);
            } else {
                $this->Flash->error(__('Question is not updated.'));
            }
        }
		$this->set(compact('existing_data','questions','question_categories','all_tags','title','all_faqs'));
        $this->set('_serialize', ['existing_data']);
    }
	
	//Edit Question DRAFT AJAX
	public function editSubmittedQuestionDraft(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is(['POST','PUT'])){
			$new_generated_tag_ids = array();
			if( isset($this->request->data['new_tags']) && !empty($this->request->data['new_tags']) ) {
				$TagsTable = TableRegistry::get('Tags');					
				if( strpos($this->request->data['new_tags'], ',') !== false ) {
					$exploded_tags = explode(',',$this->request->data['new_tags']);
					//echo '<pre>'; print_r($exploded_tags); die;
					foreach( $exploded_tags as $key_tag => $val_tag ) {							
						$chk = $TagsTable->find('all',['conditions'=>['title'=>trim($val_tag)]])->first();
						if( count($chk) > 0 ) {
							$new_generated_tag_ids[] = $chk->id;
						}else{
							$slug = $this->createTagsSlug($val_tag);
							$newtag['title'] 	= trim(ucwords($val_tag));
							$newtag['slug'] 	= $slug;
							$newtag['status'] 	= 'A';
							
							$new_tag 		= $TagsTable->newEntity();
							$insertdata 	= $TagsTable->patchEntity($new_tag, $newtag);
							$save 			= $TagsTable->save($insertdata);
							$tag_insert_id 	= $save->id;
							$new_generated_tag_ids[] = $tag_insert_id;
							$tag_insert_id = '';
						}
					}
				}else{
					$chk = $TagsTable->find('all',['conditions'=>['title'=>trim($this->request->data['new_tags'])]])->first();
					if( count($chk) > 0 ) {
						$new_generated_tag_ids[] = $chk->id;
					}else{							
						$slug = $this->createTagsSlug($this->request->data['new_tags']);						
						$newtag['title']	= trim(ucwords($this->request->data['new_tags']));
						$newtag['slug'] 	= $slug;
						$newtag['status'] 	= 'A';
						
						$new_tag 		= $TagsTable->newEntity();
						$inserted_data = $TagsTable->patchEntity($new_tag, $newtag);
						$save = $TagsTable->save($inserted_data);
						$tag_insert_id = $save->id;
						$new_generated_tag_ids[] = $tag_insert_id;
					}
				}
			}
			if( !empty($new_generated_tag_ids) ) {
				$main_tags = $this->request->data['tags'];
				$merge_array = array_merge( $main_tags,$new_generated_tag_ids );
				$this->request->data['tags'] = $merge_array;
			}
			
			$QuestionsTable   = TableRegistry::get('Questions');
			$existing_data 	  = $QuestionsTable->find('all', ['conditions'=>['id'=>$this->request->data['questionid'],'user_id'=>$this->Auth->user('id')]])->first();
			$updated_data 	  = $QuestionsTable->patchEntity($existing_data, $this->request->data);
			if ($savedData 	  = $QuestionsTable->save($updated_data)) {				
				$get_last_insert_id = $savedData->id;
				if(!empty($this->request->data['tags'])){
					$QuestionTagsTable = TableRegistry::get('QuestionTags');							
					$QuestionTagsTable->deleteAll([
											'QuestionTags.question_id' => $get_last_insert_id,
											'user_id'				   => $this->Auth->user('id')
										]);
					foreach( $this->request->data['tags'] as $key_tag_data => $val_tag_data ){
						$tag_data['QuestionTags']['question_id'] = $get_last_insert_id;
						$tag_data['QuestionTags']['user_id'] = $this->Auth->user('id');
						$tag_data['QuestionTags']['tag_id'] = $val_tag_data;
						$TagNewEntity = $QuestionTagsTable->newEntity();
						$inserted_data = $QuestionTagsTable->patchEntity($TagNewEntity, $tag_data);
						$QuestionTagsTable->save($inserted_data);						
					}
				}
                echo 1;
				exit();
            }
			else{
                echo 0;
				exit();
            }
        }else{
			echo 0;
			exit();
		}
    }
	
	//Edit Question Comment
	public function editSubmittedQuestionComment($id = NULL){
		if($id == NULL){
            return $this->redirect(['controller' => '/', 'action' => 'viewSubmissions']);
        }
		$title = 'Edit Question Comment';
		$QuestionCommentTable = TableRegistry::get('QuestionComment');
        $id = base64_decode($id);
		$existing_data = $QuestionCommentTable->get($id,['contain'=>['Questions'=>['fields'=>['id','name']]]]);
		$this->visitorlogs('Questions','editSubmittedQuestionComment','Edited Question Comment',NULL,NULL,NULL,$existing_data['question_id'],NULL,NULL,NULL);	//Log details insertion
		if ($this->request->is(['post', 'put'])) {			
			$active_permission = $this->getSiteSettings();	//getting approval permission mentioned in AppController
			if(!empty($active_permission)){
				if($active_permission['question_comment_approval']==1){
					$this->request->data['status'] 		= 1;
				}else{
					$this->request->data['status'] 		= 0;
				}
			}else{
				$this->request->data['status'] 		= 0;
			}			
			$this->request->data['modified'] = date('Y-m-d H:i:s');
			$updated_data = $QuestionCommentTable->patchEntity($existing_data, $this->request->data);
			if ($savedData = $QuestionCommentTable->save($updated_data)) {
                $this->Flash->success(__('Question comment has been successfully updated.'));
                return $this->redirect(['controller'=>'/','action'=>'view-submissions']);
            } else {
                $this->Flash->error(__('Question comment is not updated.'));
            }
        }
        $this->set(compact('existing_data','title'));
        $this->set('_serialize', ['existing_data']);
    }
	
	//Edit Question Comment DRAFT AJAX
	public function editSubmittedQuestionCommentDraft(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is(['POST','PUT'])){
			$QuestionCommentTable = TableRegistry::get('QuestionComment');
			$existing_data 	  	  = $QuestionCommentTable->find('all', ['conditions'=>['id'=>$this->request->data['questioncommentid'],'user_id'=>$this->Auth->user('id')]])->first();			
			$updated_data 	  = $QuestionCommentTable->patchEntity($existing_data, $this->request->data);
			if ($savedData 	  = $QuestionCommentTable->save($updated_data)) {
                echo 1;
				exit();
            }
			else{
                echo 0;
				exit();
            }
        }else{
			echo 0;
			exit();
		}
    }
	
	
	//Edit Question Answer
	public function editSubmittedQuestionAnswer($id = NULL){
		if($id == NULL){
            return $this->redirect(['controller' => '/', 'action' => 'viewSubmissions']);
        }
		$title = 'Edit Question Answer';
		$this->viewBuilder()->layout('postquestion');
		$QuestionAnswerTable = TableRegistry::get('QuestionAnswer');
        $id = base64_decode($id);
        $existing_data = $QuestionAnswerTable->get($id,['contain'=>['Questions'=>['fields'=>['id','name']]]]);
		$this->visitorlogs('Questions','editSubmittedQuestionAnswer','Edited Question Answer',NULL,NULL,NULL,$existing_data['question_id'],NULL,NULL,NULL);	//Log details insertion
		if ($this->request->is(['post', 'put'])) {			
			if( $existing_data->status == 'D' ) {
				$this->request->data['status'] = 'A';
			}
			$this->request->data['modified'] = date('Y-m-d H:i:s');
			$updated_data = $QuestionAnswerTable->patchEntity($existing_data, $this->request->data);
			if ($savedData = $QuestionAnswerTable->save($updated_data)) {
                $this->Flash->success(__('Question answer has been successfully updated.'));
                return $this->redirect(['controller'=>'/','action'=>'view-submissions']);
            } else {
                $this->Flash->error(__('Question answer is not updated.'));
            }
        }
        $this->set(compact('existing_data','title'));
        $this->set('_serialize', ['existing_data']);
    }
	
	//Edit Question Answer DRAFT AJAX
	public function editSubmittedQuestionAnswerDraft(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is(['POST','PUT'])){
			$QuestionAnswerTable= TableRegistry::get('QuestionAnswer');
			$existing_data 	  	= $QuestionAnswerTable->find('all', ['conditions'=>['id'=>$this->request->data['questionanswerid'],'user_id'=>$this->Auth->user('id')]])->first();
			$updated_data 	  = $QuestionAnswerTable->patchEntity($existing_data, $this->request->data);
			if ($savedData 	  = $QuestionAnswerTable->save($updated_data)) {
                echo 1;
				exit();
            }
			else{
                echo 0;
				exit();
            }
        }else{
			echo 0;
			exit();
		}
    }
	
	//Edit Question Answer Comment
	public function editSubmittedQuestionAnswerComment($id = NULL){
		if($id == NULL){
            return $this->redirect(['controller' => '/', 'action' => 'viewSubmissions']);
        }
		$title = 'Edit Question Answer Comment';
		$AnswerCommentTable = TableRegistry::get('AnswerComment');
        $id = base64_decode($id);
        $existing_data = $AnswerCommentTable->get($id,['contain'=>['Questions'=>['fields'=>['id','name']],'QuestionAnswer'=>['fields'=>['id','learning_path_recommendation','learning_experience','learning_utility']]]]);
		$this->visitorlogs('Questions','editSubmittedQuestionAnswerComment','Edited Question Answer Comment',NULL,NULL,NULL,$existing_data['question_id'],NULL,NULL,NULL);	//Log details insertion
		if ($this->request->is(['post', 'put'])) {
			if( $existing_data->status == 2 ) {
				$this->request->data['status'] = 1;
			}
			$this->request->data['modified'] = date('Y-m-d H:i:s');
			$updated_data = $AnswerCommentTable->patchEntity($existing_data, $this->request->data);
			if ($savedData = $AnswerCommentTable->save($updated_data)) {
                $this->Flash->success(__('Answer comment has been successfully updated.'));
                return $this->redirect(['controller'=>'/','action'=>'view-submissions']);
            } else {
                $this->Flash->error(__('Answer comment is not updated.'));
            }
        }
        $this->set(compact('existing_data','title'));
        $this->set('_serialize', ['existing_data']);
    }
	
	//Edit Question Answer Comment DRAFT AJAX
	public function editSubmittedQuestionAnswerCommentDraft(){
		$this->viewBuilder()->layout = false;
        $this->render(false);
		if($this->request->is(['POST','PUT'])){
			$AnswerCommentTable= TableRegistry::get('AnswerComment');
			$existing_data 	  	= $AnswerCommentTable->find('all', ['conditions'=>['id'=>$this->request->data['questionanswercommentid'],'user_id'=>$this->Auth->user('id')]])->first();
			$updated_data 	  = $AnswerCommentTable->patchEntity($existing_data, $this->request->data);
			if ($savedData 	  = $AnswerCommentTable->save($updated_data)) {
                echo 1;
				exit();
            }
			else{
                echo 0;
				exit();
            }
        }else{
			echo 0;
			exit();
		}
    }
    
}