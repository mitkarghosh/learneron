<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class QuestionAnswerTable extends Table{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(DB_PREFIX.'question_answers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		$this->belongsTo('Questions',[
							'className'=>'Questions',
							'foreignKey'=>'question_id'							
						]);
		$this->belongsTo('Users',[
							'className'=>'Users',
							'foreignKey'=>'user_id'							
						]);
		$this->hasMany('AnswerComment',[
							'className'=>'AnswerComment',
							'foreignKey'=>'answer_id'
						]);
		$this->hasMany('AnswerUpvote',[
							'className'=>'AnswerUpvote',
							'foreignKey'=>'answer_id'							
						]);
    }
    public function beforeFind(Event $event, Query $query){}
}