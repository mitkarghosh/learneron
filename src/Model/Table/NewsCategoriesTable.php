<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class NewsCategoriesTable extends Table{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(DB_PREFIX.'news_categories');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		$this->belongsTo('ParentCategory',[
                'className'=>'NewsCategories',
                'foreignKey'=>'parent_id',
                'propertyName'=>'ParentCategory'
            ]);
		$this->hasMany('ChildsCategories',[
			'className'=>'NewsCategories',
			'foreignKey'=>'parent_id',
			'propertyName'=>'ChildsCategories'
		]);
		$this->hasMany('News',[
                'className'=>'News',
                'foreignKey'=>'category_id',
            ]);
			
    }

    public function beforeFind(Event $event, Query $query){
    }
}
