<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CareereducationsTable extends Table{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(DB_PREFIX.'careereducations');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		/*$this->hasMany('Users',[
						'className'=>'Careereducations',
						'foreignKey'=>'user_id'
					   ]);*/
    }

    public function beforeFind(Event $event, Query $query){}
}
