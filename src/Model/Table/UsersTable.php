<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
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
							'className'=>'Careereducations',
							'foreignKey'=>'user_id'               
						]);
		$this->hasMany('Questions',[
							'className'=>'Questions',
							'foreignKey'=>'user_id'               
						]);
		$this->hasMany('QuestionAnswer',[
							'className'=>'QuestionAnswer',
							'foreignKey'=>'user_id'               
						]);
    }

    public function beforeFind(Event $event, Query $query){}
	
	public function validationDefault(Validator $validator){     
        $validator
            ->notEmpty('name', 'Please enter your name.');
        $validator
            ->notEmpty('email','Enter your email address.')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'Enter a valid email address.'
            ]);
        $validator
            ->add(
                'email', 
                ['unique' => [
                    'rule' => 'validateUnique', 
                    'provider' => 'table', 
                    'message' => 'Email id already exist, try another.']
                ]
            );
        $validator
            ->notEmpty('password','Enter a password.');
        $validator
            ->notEmpty('confirm_password','Confirm your password.');
        $validator->add('confirm_password', [
            'compare' => [
                'rule' => ['compareWith', 'password'],
                'message' => 'Password does not match.'
            ]
        ]);
        return $validator;
    }
	
	/**
     * [validationPassword function used for change password]
     * @param  Validator $validator [description]
     * @return [type]               [description]
     */
    public function validationPassword(Validator $validator)
    {
        // change password rules *************************************************
        $validator
            ->add('old_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'Old password does not match with the current password!',
            ])
            ->notEmpty('old_password');

        $validator
            ->add('new_password',[
                'match'=>[
                    'rule'=> ['compareWith','confirm_password'],
                    'message'=>'New password does not match!',
                ]
            ])
            ->notEmpty('new_password');
        $validator
            ->add('confirm_password',[
                'match'=>[
                    'rule'=> ['compareWith','new_password'],
                    'message'=>'Confirm password does not match!',
                ]
            ])
            ->notEmpty('confirm_password');
            //***********************************************************************

            return $validator;
    }
	
}
