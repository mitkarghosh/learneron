<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Routing\Router;
/**
 * Sites Controller is for manage all the cms pages and and home page of the site.
 *
 * @property \Admin\Model\Table\Cms $Cms
 */
class SitesController extends AppController
{
	public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->loadComponent('Email');
        $this->Auth->allow();
    }
    
    /**
     * [homePage function is for home page of the site]
     * 
     */
    public function homePage(){
		$this->visitorlogs('Sites','homePage','Front Page');
        $BannersTable = TableRegistry::get('Banners');
		$all_banners = $BannersTable->find('all',['conditions'=>['status'=>'A'],'order'=>['id asc']])->toArray();		
		$QuestionsTable = TableRegistry::get('Questions');
		$total_questions = $QuestionsTable->find('all', ['conditions'=>['status'=>'A']] )->count();
		$UsersTable = TableRegistry::get('Users');
		$total_users = $UsersTable->find('all', ['conditions'=>['status'=>'A']] )->count();
		
		//$featured_question_rightpanel = $this->getFeaturedQuestions();				//mention in AppController
		$featured_question_rightpanel = '';
		$latest_news_rightpanel = $this->getLatestNews();							//mention in AppController
		$question_categories = $this->getTreeQuestionCategoriesSorted();			//mention in AppController
		$recently_most_viewed_questions = $this->getRecentlyMostViewedQuestions();	//mention in AppController
				
		$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id'],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['AnswerUpvote.question_id','AnswerUpvote.answer_id']]]];
		$options['conditions'] 	= ['Questions.status'=>'A'];
		$options['fields'] 		= ['id','name','user_id','category_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
		$options['order'] 		= ['Questions.created DESC'];
		$options['limit'] 		= $this->limitLatestQuestions;
		$latest_questions = $this->paginate($QuestionsTable, $options)->toArray();
		//pr($latest_questions); die;		
		$AdvertisementsTable = TableRegistry::get('Advertisement');
		$advertise = $AdvertisementsTable->find('all',['conditions'=>['page_name'=>'homePage','status'=>'A'],'fields'=>['id','link','page_name','image'],'order'=>['id desc']])->first();
		$this->set(compact('all_banners','total_questions','total_users','featured_question_rightpanel','latest_news_rightpanel','question_categories','latest_questions','recently_most_viewed_questions','advertise'));
    }
	
	//Home page latest question listing -> Pagination page
	public function latestquestionsSearch(){
		$this->visitorlogs('Sites','latestquestionsSearch','More Latest Question Listing For Home Page');	//Log details insertion
        if($this->request->is('post')){
			$QuestionsTable = TableRegistry::get('Questions');
			$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id'],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['AnswerUpvote.question_id','AnswerUpvote.answer_id']]]];
			$options['conditions'] 	= ['Questions.status'=>'A'];
			$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
			$options['order'] 		= ['Questions.created DESC'];
			$options['limit'] 		= $this->limitMostViewedQuestions;		
			$latest_questions = $this->paginate($QuestionsTable, $options)->toArray();
			$this->set(compact('latest_questions'));
        }
    }
	
	//mostViewed function is for home page most_viewed questions tab
    public function mostViewed(){
		$this->visitorlogs('Sites','mostViewed','Most Viewed Question Listing For Home Page');	//Log details insertion
        $BannersTable = TableRegistry::get('Banners');
		$all_banners = $BannersTable->find('all',['conditions'=>['status'=>'A'],'order'=>['id asc']])->toArray();		
		$QuestionsTable = TableRegistry::get('Questions');
		$total_questions = $QuestionsTable->find('all', ['conditions'=>['status'=>'A']] )->count();
		$UsersTable = TableRegistry::get('Users');
		$total_users = $UsersTable->find('all', ['conditions'=>['status'=>'A']] )->count();
		
		//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
		$featured_question_rightpanel = '';
		$latest_news_rightpanel = $this->getLatestNews();				//mention in AppController
		$question_categories = $this->getTreeQuestionCategoriesSorted();//mention in AppController
		
		$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id'],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['AnswerUpvote.question_id','AnswerUpvote.answer_id']]]];
		$options['conditions'] 	= ['Questions.status'=>'A'];
		$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
		$options['order'] 		= ['view DESC'];
		$options['limit'] 		= $this->limitMostViewedQuestions;		
		$most_viewed_questions = $this->paginate($QuestionsTable, $options)->toArray();
		
		$AdvertisementsTable = TableRegistry::get('Advertisement');
		$advertise = $AdvertisementsTable->find('all',['conditions'=>['page_name'=>'homePage','status'=>'A'],'fields'=>['id','link','page_name','image'],'order'=>['id desc']])->first();
		$this->set(compact('all_banners','total_questions','total_users','featured_question_rightpanel','latest_news_rightpanel','question_categories','most_viewed_questions','advertise'));
    }
	
	//Home page most viewed question listing -> Pagination page
	public function mostviewedSearch(){
		if($this->request->is('post')){
			$this->visitorlogs('Sites','mostviewedSearch','More Most Viewed Question Listing For Home Page');	//Log details insertion
			$QuestionsTable = TableRegistry::get('Questions');
			$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'A'],'fields'=>['id','question_id'],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['AnswerUpvote.question_id','AnswerUpvote.answer_id']]]];
			$options['conditions'] 	= ['Questions.status'=>'A'];
			$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
			$options['order'] 		= ['view DESC'];
			$options['limit'] 		= $this->limitMostViewedQuestions;		
			$most_viewed_questions = $this->paginate($QuestionsTable, $options)->toArray();
			$this->set(compact('most_viewed_questions'));
        }
    }
	
	//Un-answered questions for home page
	public function unAnswered(){
		$this->visitorlogs('Sites','unAnswered','Unanswered Question Listing For Home Page');	//Log details insertion
        $BannersTable = TableRegistry::get('Banners');
		$all_banners = $BannersTable->find('all',['conditions'=>['status'=>'A'],'order'=>['id asc']])->toArray();		
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
			$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'I'],'fields'=>['id','question_id'],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['AnswerUpvote.question_id','AnswerUpvote.answer_id']]]];
			$options['conditions'] 	= ['Questions.id NOT IN'=>$unanswered_ids,'Questions.status'=>'A'];
			$options['fields'] 		= ['id','name','user_id','short_description','view','created','QuestionCategories.id','QuestionCategories.name','QuestionCategories.slug'];
			$options['order'] 		= ['Questions.created DESC'];
			$options['limit'] 		= $this->limitLatestQuestions;
			$unanswered_questions 	= $this->paginate($QuestionsTable, $options)->toArray();
		}else{
			$unanswered_questions = array();
		}
		//for getting not answered questions
		
		$AdvertisementsTable = TableRegistry::get('Advertisement');
		$advertise = $AdvertisementsTable->find('all',['conditions'=>['page_name'=>'homePage','status'=>'A'],'fields'=>['id','link','page_name','image'],'order'=>['id desc']])->first();
		$this->set(compact('all_banners','total_questions','total_users','featured_question_rightpanel','latest_news_rightpanel','question_categories','unanswered_questions','advertise'));
    }
	
	//Home page un answered question listing -> Pagination page
	public function unansweredSearch(){
        if($this->request->is('post')){
			$this->visitorlogs('Sites','unansweredSearch','More Unanswered Question Listing For Home Page');	//Log details insertion
			$QuestionsTable = TableRegistry::get('Questions');
			//for getting not answered questions
			$QuestionAnswerTable = TableRegistry::get('QuestionAnswer');
			$unanswered_ids = $QuestionAnswerTable->find('list', [/*'conditions'=>['QuestionAnswer.status'=>'I'],*/ 'group'=>'QuestionAnswer.question_id', 'keyField'=>'id','valueField'=>'question_id'])->toArray();
			if(!empty($unanswered_ids)){
				$options['contain'] 	= ['QuestionCategories','Users'=>['fields'=>['id','name','full_name']],'QuestionTags'=>['fields'=>['id','question_id','tag_id']],'QuestionTags.Tags'=>['fields'=>['id','title','slug']],'QuestionAnswer'=>['conditions'=>['QuestionAnswer.status'=>'I'],'fields'=>['id','question_id'],'AnswerUpvote'=>['conditions'=>['AnswerUpvote.status'=>1],'fields'=>['AnswerUpvote.question_id','AnswerUpvote.answer_id']]]];
				$options['conditions'] 	= ['Questions.id NOT IN'=>$unanswered_ids,'Questions.status'=>'A'];
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
	
	
    //About us page
    public function aboutUs(){
		$this->visitorlogs('Sites','aboutUs','About Us');
    	$cms = TableRegistry::get('Cms');
		$cms_data = $cms->get(3);
        $title = $cms_data->title;
        $meta_keywords = $cms_data->meta_keywords;
        $meta_description = $cms_data->meta_description;
        $this->set(compact('title','cms_data','meta_keywords','meta_description'));
    }
    
	//Contact us page
    public function contactUs(){
		$this->visitorlogs('Sites','contactUs','Contact Us');
    	$title = 'Contact Us';		
		$ContactTable = TableRegistry::get('Contact');
		$contact = $ContactTable->newEntity();
		if($this->request->is('post')){
			$data_to_insert = $ContactTable->patchEntity($contact, $this->request->data);
			if($ContactTable->save($data_to_insert)){
				$settings = $this->getSiteSettings();
				$this->loadComponent('Email');
				$this->Email->contactsAdmin($this->request->data, $settings);
				$this->Flash->success(__('Thank you for your message - we will be back with you soon.'));
				return $this->redirect($this->referer());
			}else{
				$this->Flash->error(__('There was an unexpected error. Try again later or contact the Admin.'));
				return $this->redirect($this->referer());
			}			
        }
		$this->set(compact('contact','title'));
    }
    
	public function faqs(){
		$this->visitorlogs('Sites','faqs','Faqs');
		$title = 'Frequently Ask Questions';
		$faqTable = TableRegistry::get('Faqs');
		$faqs_data = $faqTable->find('all', ['conditions'=>['status'=>'A'],'order'=>['created'=>'ASC']])->toArray();
		$this->set(compact('faqs_data','title','meta_keywords','meta_description'));
    }	

    public function newsletterSignup(){
        $this->viewBuilder()->layout = false;
        $this->render(false);
        if($this->request->is('post')){
			$this->visitorlogs('Sites','newsletterSignup','Newsletter Subscriptions');
            $jsonData = $this->request->input('json_decode');
            $newsletter = TableRegistry::get('NewsletterSubscriptions');
            $is_exist = $newsletter->find('all', ['conditions'=>['email'=>$jsonData->email]])->first();
            if(empty($is_exist)){
                $new_subscribe = $newsletter->newEntity();
                $data['email'] = $jsonData->email;
                $data_to_insert = $newsletter->patchEntity($new_subscribe, $data);
                if($newsletter->save($data_to_insert)){
                    $settings = $this->getSiteSettings();
                    $this->Email->newsletterSubscriptions($jsonData->email, $settings);
                    echo json_encode(['status'=>'success']);
					exit();
                }else{
                    echo json_encode(['status'=>'failed']);
					exit();
                }
            }else{
                echo json_encode(['status'=>'email_exist']);
				exit();
            }
        }
    }
    /**
     * [termsAndConditions this function is for displaying the t&c page]
     * @return [type] [description]
     */
    public function termsAndConditions(){
		$this->visitorlogs('Sites','termsAndConditions','Terms and Conditions');
        $cms = TableRegistry::get('Cms');
        $cms_data = $cms->get(4);
        $title = $cms_data->title;
        $meta_keywords = $cms_data->meta_keywords;
        $meta_description = $cms_data->meta_description;
        $this->set(compact('title','cms_data','meta_keywords','meta_description'));
    }
	
	/**
     * [privacy this function is for displaying the privacy page]
     * @return [type] [description]
     */
    public function privacy(){
		$this->visitorlogs('Sites','privacy','Privacy');
        $cms = TableRegistry::get('Cms');
        $cms_data = $cms->get(5);
        $title = $cms_data->title;
        $meta_keywords = $cms_data->meta_keywords;
        $meta_description = $cms_data->meta_description;
        $this->set(compact('title','cms_data','meta_keywords','meta_description'));
    }
    
}