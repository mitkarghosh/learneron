<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Routing\Router;

class TagsController extends AppController{
	public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->Auth->allow();
		
		$NewsTable = TableRegistry::get('News');
		$option['contain']		= ['Users'=>['fields'=>['Users.id','Users.name']]];
		if(isset($this->request->params['pass']) && !empty($this->request->params['pass'][0])){
			$option['conditions']	= ['News.slug !='=>$this->request->params['pass'][0], 'News.status'=>'A'];
		}else{
			$option['conditions']	= ['News.status'=>'A'];
		}
		$option['fields']		= ['News.id','News.user_id','News.name','News.slug','News.description','News.image','News.created'];
		$option['order']		= ['News.created'=>'DESC'];
		$option['limit']		= $this->limitNewsRightPanel;		
		$latest_news_rightpanel = $NewsTable->find('all',$option)->toArray();
		
		//$featured_question_rightpanel = $this->getFeaturedQuestions();	//mention in AppController
		$featured_question_rightpanel = '';
		$this->set(compact('latest_news_rightpanel','featured_question_rightpanel'));
    }
    
	//Tags listing page
    public function index(){
        $TagsTable = TableRegistry::get('Tags');
		
		/*$options['contain']		= ['QuestionTags','QuestionTags.Questions'=>['conditions'=>['status'=>'A'],'fields'=>['id','status','created']]];
		$options['conditions']	= ['Tags.status'=>'A'];
		$options['order'] 		= ['Tags.title'=>'ASC'];
		$options['limit'] 		= $this->limitTags;
		
		$all_tags = $this->paginate($TagsTable, $options)->toArray();
		//pr($all_tags); die;*/
		
		$element = '';
		$options['contain']		= ['QuestionTags','QuestionTags.Questions'=>['conditions'=>['status'=>'A'],'fields'=>['id','status','created']]];
		if($this->request->is('get')) {
			if(empty($this->request->query)){
				$options['conditions']	= ['Tags.status'=>'A'];
			}else{
				$element = strtoupper($this->request->query['search']);
				$options['conditions']	= ['Tags.status'=>'A', 'Tags.title LIKE'=>$element.'%'];
			}			
		}
		$options['order'] 		= ['Tags.title'=>'ASC'];
		$all_tags = $TagsTable->find('all', $options)->toArray();
		//pr($all_tags); die;
		
		$alphabet_options['conditions']	= ['Tags.status'=>'A'];
		$alphabet_options['fields']		= ['Tags.id','Tags.title'];
		$alphabet_options['order'] 		= ['Tags.title'=>'ASC'];
		$all_characters = $TagsTable->find('all', $alphabet_options)->toArray();
				
		$sorted_array=array(); $alphabets_only=array();
		if(!empty($all_tags)){
			foreach($all_tags as $tags){
				$arraykey = substr($tags['title'],0,1);
				$sorted_array[$arraykey][] = $tags;
			}
		}
		if(!empty($all_characters)){
			foreach($all_characters as $characters){
				$key = substr($characters['title'],0,1);
				$alphabets_only[$key][] = $characters;
			}
		}
		//pr($sorted_array); die;
		$this->set(compact('all_tags','sorted_array','alphabets_only','element'));
    }
	
    
}