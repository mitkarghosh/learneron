<?php
namespace Admin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HhAgentDetailsFixture
 *
 */
class HhAgentDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'user id that has user type Agent', 'precision' => null, 'autoIncrement' => null],
        'business_code' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'system generated code', 'precision' => null, 'fixed' => null],
        'business_name' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Business name', 'precision' => null, 'fixed' => null],
        'logo' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Business logo', 'precision' => null, 'fixed' => null],
        'business_details' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'business details', 'precision' => null, 'fixed' => null],
        'important_info' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'business important info', 'precision' => null, 'fixed' => null],
        'protected_by' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'opening_times' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'reception/agent meet time', 'precision' => null, 'fixed' => null],
        'postcode' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'agent/business place postcode', 'precision' => null, 'fixed' => null],
        'address' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'agent/business place address', 'precision' => null, 'fixed' => null],
        'voip_numbers' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'example: voip number, voip number, voip number', 'precision' => null, 'fixed' => null],
        'invoice_company_name' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Invoice company name', 'precision' => null, 'fixed' => null],
        'invoice_company_addr' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'invoice comapny address', 'precision' => null, 'fixed' => null],
        'company_vat_number' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'company VAT number', 'precision' => null, 'fixed' => null],
        'company_reg_number' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'company registration number', 'precision' => null, 'fixed' => null],
        'membership_reg_number' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'membership registration number', 'precision' => null, 'fixed' => null],
        'allowed_destination_country' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'storing allowed countries id', 'precision' => null, 'fixed' => null],
        'offer_limit' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'maximum upload limit', 'precision' => null, 'autoIncrement' => null],
        'offer_status' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => 'A', 'collate' => 'latin1_swedish_ci', 'comment' => 'A=>active,I=>inactive', 'precision' => null, 'fixed' => null],
        'agent_last_upload' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Last excel upload date and time', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'update time', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'insert time', 'precision' => null],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'hh_agent_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['hh_users', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
            'user_id' => 1,
            'business_code' => 'Lorem ipsum dolor ',
            'business_name' => 'Lorem ipsum dolor sit amet',
            'logo' => 'Lorem ipsum dolor sit amet',
            'business_details' => 'Lorem ipsum dolor sit amet',
            'important_info' => 'Lorem ipsum dolor sit amet',
            'protected_by' => 'Lorem ipsum dolor sit amet',
            'opening_times' => 'Lorem ipsum dolor sit amet',
            'postcode' => 'Lorem ipsum dolor ',
            'address' => 'Lorem ipsum dolor sit amet',
            'voip_numbers' => 'Lorem ipsum dolor sit amet',
            'invoice_company_name' => 'Lorem ipsum dolor sit amet',
            'invoice_company_addr' => 'Lorem ipsum dolor sit amet',
            'company_vat_number' => 'Lorem ipsum dolor sit amet',
            'company_reg_number' => 'Lorem ipsum dolor sit amet',
            'membership_reg_number' => 'Lorem ipsum dolor sit amet',
            'allowed_destination_country' => 'Lorem ipsum dolor sit amet',
            'offer_limit' => 1,
            'offer_status' => 'Lorem ipsum dolor sit ame',
            'agent_last_upload' => '2016-09-23 10:01:27',
            'modified' => '2016-09-23 10:01:27',
            'created' => '2016-09-23 10:01:27'
        ],
    ];
}
