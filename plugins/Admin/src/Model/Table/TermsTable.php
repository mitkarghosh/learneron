<?php
namespace Admin\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class TermsTable extends Table{

    public function initialize(array $config){
        parent::initialize($config);
		
        $this->table(DB_PREFIX.'terms');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');		
    }

    public function beforeFind(Event $event, Query $query){
    }
}