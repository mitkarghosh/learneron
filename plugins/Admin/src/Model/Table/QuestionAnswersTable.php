<?php
namespace Admin\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class QuestionAnswersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config){
        parent::initialize($config);
		
        $this->table(DB_PREFIX.'question_answers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		$this->belongsTo('Questions',[
							'className'=>'Admin.Questions',
							'foreignKey'=>'question_id'							
						]);
		$this->hasMany('AnswerComment',[
							'className'=>'Admin.AnswerComment',
							'foreignKey'=>'answer_id'							
						]);
		$this->belongsTo('Users',[
							'className'=>'Admin.Users',
							'foreignKey'=>'user_id'							
						]);
    }

    public function beforeFind(Event $event, Query $query){
    }
    public function buildRules(RulesChecker $rules){
        
    }
}