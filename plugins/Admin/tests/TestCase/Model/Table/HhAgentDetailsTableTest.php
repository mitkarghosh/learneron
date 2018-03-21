<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\HhAgentDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\HhAgentDetailsTable Test Case
 */
class HhAgentDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Admin\Model\Table\HhAgentDetailsTable
     */
    public $HhAgentDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.admin.hh_agent_details',
        'plugin.admin.hh_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('HhAgentDetails') ? [] : ['className' => 'Admin\Model\Table\HhAgentDetailsTable'];
        $this->HhAgentDetails = TableRegistry::get('HhAgentDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HhAgentDetails);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
