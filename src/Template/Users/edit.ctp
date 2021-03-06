<?= $this->Html->css('/select2-3.5.2/select2.css') ?>
<?= $this->Html->css('/select2-bootstrap/select2-bootstrap.css') ?>
<?= $this->Html->script('/select2-3.5.2/select2.min.js') ?>
<div class="row">
<div class="col-lg-12">
    <div class="hpanel">
        <div class="panel-heading">
        <?= __('Edit User') ?>
        </div>
        <div class="panel-body">
            <?= $this->Form->create($user, ['data-toggle'=>'validator','class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
            <?= $this->Form->hidden('userId',['value' => $user->id]);?>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                <?= $this->Form->label('first_name', __('First Name'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                        <?= $this->Form->input('first_name', ['label' => false,'required' => true,'class' => ['form-control m-b']]); ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                <?= $this->Form->label('last_name', __('Last Name'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                        <?= $this->Form->input('last_name', ['label' => false,'required' => true,'class' => ['form-control m-b']]); ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                <?= $this->Form->label('email', __('Email'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                        <?= $this->Form->input('email', ['label' => false,'required' => true,'class' => ['form-control m-b']]); ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                <?= $this->Form->label('phone', __('Phone'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                        <?= $this->Form->input('phone', ['label' => false,'required' => true,"placeholder" => "1(800)233-2742",'class' => ['form-control m-b']]); ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                <?= $this->Form->label('username', __('Username'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                        <?= $this->Form->input('username', ['label' => false,'required' => true,'class' => ['form-control m-b']]); ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                <?= $this->Form->label('password', __('Password'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                        <div class="">
                          <a data-toggle="modal" id="changePasswordButton" class="btn btn-primary" data-target="#changePassword">Change Password</a>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <?= $this->Form->label('name', __('Roles'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                       <?= $this->Form->input('role_id', ['id'=>'role_type_id','label' => false, 'required' => true, 'class' => ['form-control']]); ?>
                    </div>
                </div>
                <div id="job_designation_div">
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <?= $this->Form->label('name', __('Job Designation'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                    <?= $this->Form->select('user_job_designation.job_designation_id',$jobDesignations ,['label' => false, 'required' => true, 'class' => ['form-control']]); ?>
                    </div>
                </div>
                </div>
                <div id="reporting_manager_div">
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <?= $this->Form->label('name', __('Add your Reporting Managers'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                       <?= $this->Form->select('manager_subordinate_data.reporting_managers', $reportingManagers,['id'=>'reporting_manager_id','label' => false, 'value' => $setManagerData ? $setManagerData:null,'class' => ['form-control','js-source-states-2'], 'multiple'=> 'multiple']); ?>
                    </div>
                </div>
                </div>  
                <div id="subordinate_div">
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <?= $this->Form->label('name', __('Add your Subordinates'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                       <?= $this->Form->select('manager_subordinate_data.subordinates', $subordinates,['id'=>'subordinate_id','label' => false, 'value'=>$setSubordinateData ? $setSubordinateData:null, 'class' => ['form-control','js-source-states-2'], 'multiple'=> 'multiple']); ?>
                    </div>
                </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                <?= $this->Form->label('status', __('Status'), ['class' => ['col-sm-2', 'control-label']]); ?>
                    <div class="col-sm-10">
                        <?= $this->Form->input('status', ['label' => false,'class' => ['form-control m-b']]); ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                    <?= $this->Form->button(__('Submit'), ['id'=>'check_submit','class' => ['btn', 'btn-primary']]) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['id'=>'check_cancel','class' => ['btn', 'btn-danger']]);?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <?= $this->Form->create(null, ['class' => 'form-horizontal','data-toggle'=>"validator"]) ?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?= __('CHANGE PASSWORD')?></h4>
        </div>

        <div class="modal-body">
          <div class="alert" id="rsp_msg" style=''></div>
          <div class="form-group">
            <?= $this->Form->label('name', __('Old Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
            <div class="col-sm-8">
              <?= $this->Form->input("old_pwd", array(
                  "label" => false,
                  'required' => true,
                  'id'=>'old_pwd',
                  "type"=>"password",
                  "class" => "form-control",'data-minlength'=>8,
                  'placeholder'=>"Enter Old Password"));
              ?>
            </div>
          </div>

          <div class="form-group">
            <?= $this->Form->label('name', __('New Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
            <div class="col-sm-8">
              <?= $this->Form->input("new_pwd", array(
                "label" => false,
                'id'=>'new_pwd',
                "type"=>"password",
                'required' => true,
                "class" => "form-control",'data-minlength'=>8,
                'placeholder'=>"Enter New Password"));
              ?>
            </div>
          </div>

          <div class="form-group">
            <?= $this->Form->label('name', __('Confirm New Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
            <div class="col-sm-8">
              <?= $this->Form->input("cnf_new_pwd", array(
                "label" => false,
                "type"=>"password",
                'id'=>'cnf_new_pwd',
                'required' => true,
                "class" => "form-control",'data-minlength'=>8,'data-match'=>"#new_pwd",'data-match-error'=>"__('MISMATCH')",'placeholder'=>"Confirm Password"));
              ?>
            </div>
          </div>
        </div>
        <div class="modal-footer text-center">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary'], 'type' => 'button','id'=>"saveUserPassword"]) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#job_designation_div').hide();
    $('#job_designation_id').val(" ");
    $('#job_designation_div').hide();
    onChange();
});
 function onChange(){
    prodVal = $('#role_type_id').val();
        console.log(prodVal);
        if (prodVal == 3)
        {
            $('#job_designation_id').prop("disabled", false);
            $('#job_designation_div').show();
            $('#reporting_manager_div').show();
            $('#reporting_manager_id').prop("disabled", false);
            $('#subordinate_div').hide();
            $('#subordinate_id').prop("disabled", true);
        }
        else if(prodVal == 4)
        {
            $('#job_designation_id').prop("disabled", false);
            $('#job_designation_div').show();
            $('#reporting_manager_id').prop("disabled", false);
            $('#reporting_manager_div').show();
            $('#subordinate_id').prop("disabled", false);
            $('#subordinate_div').show();


        }    
        else
        {  
            $('#job_designation_id').prop("disabled", true);
            $('#job_designation_div').hide();
            $('#reporting_manager_id').prop("disabled", true);
            $('#reporting_manager_div').hide();
            $('#subordinate_id').prop("disabled", true);
            $('#subordinate_div').hide();
           
        }
}

    $('#role_type_id').change(function(){
         onChange();  
    });
    $('#reporting_manager_id').change(function(){
         onChange();  
    });
    $(function(){
        $(".js-source-states-2").select2();
    });
</script>