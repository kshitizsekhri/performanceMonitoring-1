<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeSurveysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeSurveysTable Test Case
 */
class EmployeeSurveysTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeSurveysTable
     */
    public $EmployeeSurveys;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employee_surveys',
        'app.users',
        'app.employee_survey_responses',
        'app.questions',
        'app.response_groups',
        'app.response_options',
        'app.competency_questions',
        'app.competencies',
        'app.employee_survey_results',
        'app.job_designation_competencies',
        'app.job_designations',
        'app.user_job_designations',
        'app.job_requirement_levels'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EmployeeSurveys') ? [] : ['className' => EmployeeSurveysTable::class];
        $this->EmployeeSurveys = TableRegistry::get('EmployeeSurveys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmployeeSurveys);

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
