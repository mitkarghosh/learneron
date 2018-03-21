<?php
namespace Admin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HhUsersFixture
 *
 */
class HhUsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'salutation' => ['type' => 'string', 'length' => 4, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Example: Mrs, Mr, etc. Used Varchar instead of enum for optimising storage', 'precision' => null, 'fixed' => null],
        'first_name' => ['type' => 'string', 'length' => 15, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'first name', 'precision' => null, 'fixed' => null],
        'last_name' => ['type' => 'string', 'length' => 15, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'last name', 'precision' => null, 'fixed' => null],
        'phone' => ['type' => 'string', 'length' => 25, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'mobile number', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'email address', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'cakephp hashed password', 'precision' => null, 'fixed' => null],
        'signup_string' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'string used to verify the signup users email', 'precision' => null, 'fixed' => null],
        'forget_password_string' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'string used to verify the account owner', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => 'C', 'collate' => 'latin1_swedish_ci', 'comment' => '\'C\' => Customer, \'M\' => Merchant, \'A\' => Agent', 'precision' => null, 'fixed' => null],
        'signup_ip' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'ip from where account was created', 'precision' => null, 'fixed' => null],
        'acc_verification_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Account verified date and time', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'update time', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'insert time', 'precision' => null],
        'status' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => 'I', 'collate' => 'latin1_swedish_ci', 'comment' => 'A=>active, I=>inactive, D=>deleted', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'salutation' => 'Lo',
            'first_name' => 'Lorem ipsum d',
            'last_name' => 'Lorem ipsum d',
            'phone' => 'Lorem ipsum dolor sit a',
            'email' => 'Lorem ipsum dolor sit amet',
            'password' => 'Lorem ipsum dolor sit amet',
            'signup_string' => 'Lorem ipsum dolor sit amet',
            'forget_password_string' => 'Lorem ipsum dolor sit amet',
            'type' => 'Lorem ipsum dolor sit ame',
            'signup_ip' => 'Lorem ipsum dolor sit amet',
            'acc_verification_date' => '2016-09-23 09:59:46',
            'modified' => '2016-09-23 09:59:46',
            'created' => '2016-09-23 09:59:46',
            'status' => 'Lorem ipsum dolor sit ame'
        ],
    ];
}
