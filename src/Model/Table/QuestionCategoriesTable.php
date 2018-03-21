<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class QuestionCategoriesTable extends Table{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(DB_PREFIX.'question_categories');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		$this->hasMany('Questions',[
                'className'=>'Questions',
                'foreignKey'=>'category_id',
            ]);
		$this->belongsTo('ParentCategory',[
                'className'=>'QuestionCategories',
                'foreignKey'=>'parent_id',
                'propertyName'=>'ParentCategory'
            ]);			
    }
    public function beforeFind(Event $event, Query $query){}
}