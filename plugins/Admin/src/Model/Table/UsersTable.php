<?php
namespace Admin\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table(DB_PREFIX.'users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		$this->hasMany('Careereducations',[
							'className'=>'Admin.Careereducations',
							'foreignKey'=>'user_id'               
						]);
		$this->hasMany('UserAccountSetting',[
							'className'=>'Admin.UserAccountSetting',
							'foreignKey'=>'user_id'               
						]);
		$this->hasMany('Visitors',[
							'className'=>'Admin.Visitors',
							'foreignKey'=>'user_id'               
						]);
    }
	
    public function beforeFind(Event $event, Query $query){
        //$query->where(['type' => 'C']);
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
            ->allowEmpty('id', true);

        $validator
            ->requirePresence('name', true)
            ->notEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', true)
            ->notEmpty('email');
			
		$validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('status', true)
            ->notEmpty('status');

        return $validator;
    }
	
	public function validationPassword(Validator $validator)
    {
        // change password rules *************************************************
        $validator
            ->add('new_password',[
                'match'=>[
                    'rule'=> ['compareWith','confirm_password'],
                    'message'=>'The passwords does not match!',
                ]
            ])
            ->notEmpty('new_password');
        $validator
            ->add('confirm_password',[
                'match'=>[
                    'rule'=> ['compareWith','new_password'],
                    'message'=>'The passwords does not match!',
                ]
            ])
            ->notEmpty('confirm_password');
            //***********************************************************************

            return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules){
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
