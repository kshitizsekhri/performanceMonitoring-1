<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JobDesignationCompetenciesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JobDesignationCompetenciesTable Test Case
 */
class JobDesignationCompetenciesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\JobDesignationCompetenciesTable
     */
    public $JobDesignationCompetencies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.job_designation_competencies',
        'app.job_designations',
        'app.user_job_designations',
        'app.users',
        'app.competencies',
        'app.competency_questions',
        'app.questions',
        'app.response_groups',
        'app.response_options',
        'app.employee_survey_responses',
        'app.employee_surveys',
        'app.employee_survey_results',
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
        $config = TableRegistry::exists('JobDesignationCompetencies') ? [] : ['className' => JobDesignationCompetenciesTable::class];
        $this->JobDesignationCompetencies = TableRegistry::get('JobDesignationCompetencies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->JobDesignationCompetencies);

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
