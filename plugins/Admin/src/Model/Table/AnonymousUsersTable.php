<?php
namespace Admin\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class AnonymousUsersTable extends Table{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config){
        parent::initialize($config);
		
        $this->table(DB_PREFIX.'anonymous_users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		/*$this->belongsTo('QuestionCategories',[
							'className'=>'Admin.QuestionCategories',
							'foreignKey'=>'category_id'               
						]);
		$this->hasMany('QuestionTags',[
							'className'=>'Admin.QuestionTags',
							'foreignKey'=>'question_id'               
						]);
		$this->hasMany('QuestionAnswers',[
							'className'=>'Admin.QuestionAnswers',
							'foreignKey'=>'question_id'               
						]);
		$this->hasMany('QuestionComments',[
							'className'=>'Admin.QuestionComments',
							'foreignKey'=>'question_id'               
						]);
		$this->belongsTo('Users',[
							'className'=>'Admin.Users',
							'foreignKey'=>'user_id'							
						]);*/
    }

    public function beforeFind(Event $event, Query $query){
    }
    /*public function buildRules(RulesChecker $rules){
        $rules->add($rules->isUnique(['name'], ['message'=>'This question already added.']));
        $rules->add($rules->isUnique(['slug'], ['message'=>'This question already added.']));
        return $rules;
    }*/
	
	public function createSlug($string=NULL, $id=NULL){
		$this->name = 'AnonymousUsers';
		$slug = Inflector::slug ($string,'-');
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params ['conditions']= array();
		$params ['conditions'][$this->name.'.slug']= $slug;
		if (!is_null($id)){
			$params ['conditions']['not'] = array($this->name.'.id'=>$id);
		}
		while (count($this->find('all',$params)->toArray())) {			
			if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
				$slug .= '-' . ++$i;
			} else {
				$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
			}
			$params ['conditions'][$this->name . '.slug']= $slug;
		}
		return $slug;
	}
	
}