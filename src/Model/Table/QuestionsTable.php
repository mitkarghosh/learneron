<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class QuestionsTable extends Table{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(DB_PREFIX.'questions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		$this->belongsTo('Users',[
							'className'=>'Users',
							'foreignKey'=>'user_id'							
						]);
		$this->belongsTo('QuestionCategories',[
							'className'=>'QuestionCategories',
							'foreignKey'=>'category_id'               
						]);
		$this->hasMany('QuestionTags',[
							'className'=>'QuestionTags',
							'foreignKey'=>'question_id'               
						]);
		$this->hasMany('QuestionAnswer',[
							'className'=>'QuestionAnswer',
							'foreignKey'=>'question_id'               
						]);
		$this->hasMany('QuestionComment',[
							'className'=>'QuestionComment',
							'foreignKey'=>'question_id'               
						]);
		$this->hasMany('AnswerUpvote',[
							'className'=>'AnswerUpvote',
							'foreignKey'=>'question_id'							
						]);
    }

    public function beforeFind(Event $event, Query $query){
    }
}
