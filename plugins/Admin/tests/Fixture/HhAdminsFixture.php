<?php
namespace Admin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HhAdminsFixture
 *
 */
class HhAdminsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'first_name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'first name', 'precision' => null, 'fixed' => null],
        'last_name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'last name', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'email id', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'cakephp hashed password', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 2, 'null' => true, 'default' => 'AM', 'collate' => 'latin1_swedish_ci', 'comment' => 'SA=>super admin, AM=>merchant account manager', 'precision' => null, 'fixed' => null],
        'last_login_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'last login time', 'precision' => null],
        'forget_password_string' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'forget password string require to verify account owner', 'precision' => null, 'fixed' => null],
        'signup_string' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'signup string to verify account owner', 'precision' => null, 'fixed' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'update time', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'insert time', 'precision' => null],
        'status' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'A=>Active,I=>Inactive,V=>Verified,NV=>not-verified,D=>deleted', 'precision' => null, 'fixed' => null],
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
            'first_name' => 'Lorem ipsum dolor sit amet',
            'last_name' => 'Lorem ipsum dolor sit amet',
            'email' => 'Lorem ipsum dolor sit amet',
            'password' => 'Lorem ipsum dolor sit amet',
            'type' => '',
            'last_login_date' => '2016-09-23 12:06:52',
            'forget_password_string' => 'Lorem ipsum dolor sit amet',
            'signup_string' => 'Lorem ipsum dolor sit amet',
            'modified' => '2016-09-23 12:06:52',
            'created' => '2016-09-23 12:06:52',
            'status' => ''
        ],
    ];
}
