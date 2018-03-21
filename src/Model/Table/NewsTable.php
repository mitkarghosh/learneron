<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class NewsTable extends Table{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(DB_PREFIX.'news');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		$this->belongsTo('NewsCategories',[
							'className'=>'NewsCategories',
							'foreignKey'=>'category_id'
						]);
		$this->belongsTo('Users',[
							'className'=>'Users',
							'foreignKey'=>'user_id'
						]);
		$this->hasMany('NewsComment',[
							'className'=>'NewsComment',
							'foreignKey'=>'news_id'
						]);
    }

    public function beforeFind(Event $event, Query $query){}
}
