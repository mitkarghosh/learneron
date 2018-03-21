<?php
namespace Admin\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CommonSettingTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(DB_PREFIX.'common_settings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function beforeFind(Event $event, Query $query)
    {

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('company_no', 'create')
            ->notEmpty('company_no');

        $validator
            ->requirePresence('vat_no', 'create')
            ->notEmpty('vat_no');

        $validator
            ->requirePresence('facebook_link', 'create')
            ->notEmpty('facebook_link');

        $validator
            ->requirePresence('twitter_link', 'create')
            ->notEmpty('twitter_link');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('pinterest_link', 'create')
            ->notEmpty('pinterest_link');

        $validator
            ->requirePresence('footer_text', 'create')
            ->notEmpty('footer_text');

        return $validator;
    }
}
