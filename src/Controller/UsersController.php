<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Collection\Collection;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class UsersController extends AppController
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    const SUPER_ADMIN_LABEL = 'superAdmin';
    const MANAGEMENT_LABEL = 'manager';
    const EMPLOYEES_LABEL = 'employee';

    public function initialize(){
        parent::initialize();
        $this->Auth->config('authorize', ['Controller']);
        $this->Auth->allow(['add','adminDashboard','signUp']);
    }

    public function signUp(){
        $userTable = $this->loadModel('Integrateideas/User.Users');
        $user = $userTable->newEntity();    
        $this->loadModel('Integrateideas/User.Roles');
        $roles = $this->Roles->find()->where(['Roles.name IS NOT' => 'superAdmin' ])->combine('id', 'label')->toArray();
        $this->loadModel('JobDesignations');
        $jobDesignations = $this->JobDesignations->find()->combine('id','label')->toArray();
        if ($this->request->is('post')) {
            $email = $this->request->data['email'];
            list ($user, $domain) = explode('@', $email);
            $isTwinsparkMail = ($domain == 'twinspark.co');
            if($isTwinsparkMail){
                $userTable = $this->loadModel('Integrateideas/User.Users');
                $user = $userTable->newEntity();
                $user = $userTable->patchEntity($user, $this->request->data);
                if(!$user->errors()){
                    if ($userTable->save($user)) {
                        if(!$userTable->save($user)['job_designation_id']){
                            $userJobDesignationData = ['user_id' => $userTable->save($user)['id'], 'job_designation_id' => '0'];
                        }else{
                            $userJobDesignationData = ['user_id' => $userTable->save($user)['id'], 'job_designation_id' => $userTable->save($user)['job_designation_id']];
                        }
                        $this->loadModel('UserJobDesignations');
                        $userJobDesig = $this->UserJobDesignations->newEntity();
                        $userJobDesig = $this->UserJobDesignations->patchEntity($userJobDesig,$userJobDesignationData);
                        $this->UserJobDesignations->save($userJobDesig);
                        $this->Flash->success(__('The user has been saved.'));
                        return $this->redirect('/integrateideas/user/users/login');
                    }else{
                        $this->Flash->error(__('The user could not be saved. Please, try again.'));
                    }
                }else{
                    $this->Flash->error(__('KINDLY_PROVIDE_VALID_DATA'));
                }
            }else{
               $this->Flash->error(__("Are you sure you work at Twinspark? We don't recognize you!")); 
           }
       }
       $this->set('jobDesignations', $jobDesignations);
       $this->set('roles', $roles);
       $this->set('user', $user);
       $this->set('_serialize', ['user']);


   }

    public function edit($id){
        
        $user = $this->Users->get($id, [
            'contain' => ['UserJobDesignations']
        ]);

        $roles = $this->Users->Roles->find()->where(['id IS NOT' => 1])->all()->combine('id','label')->toArray();

        $jobDesignations = $this->Users->UserJobDesignations->JobDesignations->find()->combine('id','label')->toArray();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $reqData = $this->Users->patchEntity($user, $data,['associated' =>['UserJobDesignations']]);
            if ($this->Users->save($reqData, ['associated' =>['UserJobDesignations']])) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'adminDashboard']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }


        $this->set('jobDesignations', $jobDesignations);
        $this->set('roles', $roles);
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function adminDashboard(){
        $loggedInUser = $this->Auth->User();
        $this->loadModel('UserJobDesignations');
        $userJobDesig = $this->UserJobDesignations->find()
                                                  ->contain('JobDesignations')
                                                  ->all()
                                                  ->combine('user_id', 'job_designation.label')
                                                  ->toArray();
        
        $role = $this->request->session()->read('loginSuccessEvent.role');
        if($role['name'] == self::SUPER_ADMIN_LABEL){
            $this->loadModel('Integrateideas/User.Users');
            $users = $this->Users->find()->contain(['Roles'])->all();
        }
        // pr($role['name']);die;

        $this->set('userJobDesig', $userJobDesig);
        $this->set('loggedInUser', $loggedInUser);
        $this->set('users', $users);
        $this->set('_serialize', ['loggedInUser']);
    }

    
    public function managementDashboard(){
        $loggedInUser = $this->Auth->user();
        $role = $this->request->session()->read('loginSuccessEvent.role');
        if($role['name'] == self::MANAGEMENT_LABEL){
            $this->loadModel('Integrateideas/User.Users');
            $roleLabel = self::SUPER_ADMIN_LABEL;
            $users = $this->Users->find()->contain(['Roles' => function($q)use($roleLabel){
                return $q->where(['Roles.name IS NOT' => $roleLabel]);

            }])->all();
        }
        $this->set('loggedInUser', $loggedInUser);
        $this->set('users', $users);
        $this->set('_serialize', ['users']);
    }    

    public function employeeDashboard(){
        $loggedInUser = $this->Auth->user();
        $this->loadModel('UserJobDesignations');
        $userJobDesignation = $this->UserJobDesignations->findByUserId($loggedInUser['id'])
        ->contain(['JobDesignations'])
        ->first();
        $userJobDesignation = $userJobDesignation['job_designation']['label'];
        
        $this->loadModel('EmployeeSurveys');
        $employeeSurveyId = $this->EmployeeSurveys->findByUserId($loggedInUser['id'])
                                                  ->first();

        $employeeSurveyResult = null;
        if($employeeSurveyId){
        $this->loadModel('EmployeeSurveyResults');
        $employeeSurveyResult = $this->EmployeeSurveyResults->findByEmployeeSurveyId($employeeSurveyId['id'])
                                                            ->all();
        }
        $role = $this->request->session()->read('loginSuccessEvent.role');
        $this->loadModel('UserJobDesignations');
        if($role['name'] == self::EMPLOYEES_LABEL){
            $this->loadModel('Integrateideas/User.Users');
            $roleLabel = self::EMPLOYEES_LABEL;
            $users = $this->Users->find()
                                 ->contain(['Roles' => function($q)use($roleLabel){
                                            return $q->where(['Roles.name' => $roleLabel]);
                                            }])
                                 ->all();

            $this->loadModel('EmployeeSurveys');

        }
        
        $this->set('employeeSurveyResult', $employeeSurveyResult);
        $this->set('userJobDesignation', $userJobDesignation);
        $this->set('loggedInUser', $loggedInUser);
        $this->set('users', $users);
        $this->set('_serialize', ['users']);
    }

    public function employeeSurveys(){
        $loggedInUser = $this->Auth->user();
        $this->loadModel('EmployeeSurveys');
        $employeeSurvey = $this->EmployeeSurveys->findByUserId($loggedInUser['id'])
        ->last();
        
        if(!$employeeSurvey){

            $dataForEmployeeSurvey = ['user_id' => $loggedInUser['id'], 'iteration' => 1];
        }elseif($employeeSurvey['end_time']) {

            $dataForEmployeeSurvey = ['user_id' => $loggedInUser['id'], 'iteration' => $employeeSurvey['iteration'] +1];
        }
        
        if(isset($dataForEmployeeSurvey) && (!$employeeSurvey || $employeeSurvey['end_time'])){
            $employeeSurvey = $this->EmployeeSurveys->newEntity($dataForEmployeeSurvey);
            $employeeSurvey = $this->EmployeeSurveys->save($employeeSurvey);
            if(!$employeeSurvey){
                $this->Flash->error('Oops. Something went wrong.');
            }
        }
        
        if ($this->request->is('post')) {
            $this->Flash->success(__('Survey has been successfully completed.'));
            return $this->redirect(['action' => 'employeeDashboard']);
        }
        $this->loadModel('UserJobDesignations');
        $jobDesignationId = $this->UserJobDesignations->findByUserId($loggedInUser['id'])
        ->first();
        
        $this->loadModel('JobDesignationCompetencies');
        $surveyData = $this->JobDesignationCompetencies->findByJobDesignationId($jobDesignationId['job_designation_id'])
        ->contain(['Competencies.CompetencyQuestions.Questions'])
        ->all();
        
        $this->set('surveyData', $surveyData);
        $this->set('loggedInUser', $loggedInUser);
        $this->set('_serialize', ['users']);
    }

    public function employeeSurveyResults(){

        $loggedInUser = $this->Auth->User();
        $this->loadModel('UserJobDesignations');
        $jobDesignation = $this->UserJobDesignations->findByUserId($loggedInUser['id'])
                                                    ->first();
        
        // pr($jobDesignation['job_designation_id']);die;
        $this->loadModel('EmployeeSurveys');
        $employeeSurveyId = $this->EmployeeSurveys->findByUserId($loggedInUser['id'])
                                                  ->last()
                                                  ->get('id'); 
        // pr($employeeSurveyId['id']);die; 

        $this->loadModel('JobDesignationCompetencies');
        $surveyResultData = $this->JobDesignationCompetencies->findByJobDesignationId($jobDesignation['job_designation_id'])
        ->contain(['Competencies.EmployeeSurveyResults' => function($q) use($employeeSurveyId){
                                            return $q->where(['employee_survey_id' => $employeeSurveyId]);
                                                        },'JobRequirementLevels'])->all();
        
        $achieved_levels = [];
        $required_levels = [];
        $competencies = [];
        foreach ($surveyResultData as $key => $value) {
        
            $competencies[] = $value['competency']['text'];
            $required_levels[] = $value['job_requirement_levels'][0]['required_level'];
            foreach ($value['competency']['employee_survey_results'] as $key => $value1) {
                $achieved_levels[] = $value1['current_level'];
            }
        }
        $data = [ 'competencies' => $competencies,
        'required_levels' => $required_levels,
        'achieved_levels' => $achieved_levels 
        ];
        
        $this->set('data', $data);
        $this->set('_serialize', ['users']);
    }

    
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
            ) {
            $this->set('_serialize', true);
    }
}

public function isAuthorized($user)
{
    return true;
}

}
