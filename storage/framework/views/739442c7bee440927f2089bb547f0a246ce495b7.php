<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->user->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div><?php echo Session::get('message'); ?></div><br>
<?php
if ($mesages) {
    foreach ($mesages as $key => $value) {
        echo $value;
    }
}
?>   
<?php if (!$viewMode) { ?>
    <div class="panel panel-primary">
        <!-- Start .panel -->
        <div class="panel-body">

            <?php echo Form::open(['url' => url('user-management/user/submit-data'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>

            <div class="col-lg-12">
			<!-- Start .row -->
                <div class="row ">
                    

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Select User</label>
                        <div class="col-lg-7 col-md-9">
                            <?php if (isset($id) && $id) { ?>
                                <?php echo e(Form::text('', isset($user_data['user_name']) ? $user_data['user_name'] : '', array('class'=>'form-control','readonly' => 'true'))); ?>

                            <?php } else { ?>
                                <?php echo e(Form::select('user[user_name][]', isset($user_list) ? $user_list : '', isset($user_data['user_name']) ? $user_data['user_name'] : '',array('class'=>'form-control select2-minimum required','multiple' => '' ))); ?>

                            <?php } ?>
                        </div>
                    </div>
					
					
					  
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Role</label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::select('user[role_id]', isset($roles) ? $roles : '', isset($user_data['role_id']) ? $user_data['role_id'] : '',array('class'=>'form-control select2-minimum required'))); ?>

                        </div>
					
                    </div>
					
                   

                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Status</label>
                        <div class="col-lg-7 col-md-9">

                            <?php echo e(Form::select('user[fl_archive]', isset($status) ? $status : '', isset($user_data['fl_archive']) ? $user_data['fl_archive'] : '',array('class'=>'form-control select2-minimum required'))); ?>


                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Period (From - To)</label>
                        <div class="col-lg-7 col-md-9">
                            <div class="input-group">
                                <div class="input-daterange input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    <!--                                    <input type="text" class="form-control" name="start" />-->
                                    <?php echo e(Form::text('user[start_date]', isset($user_data['start_date']) ? date("d/m/Y",strtotime($user_data['start_date'])) : '', array('class'=>'form-control required','placeholder' => 'Start Date','id' => 'start_date'))); ?>

                                    <span class="input-group-addon">to</span>
                                    <?php echo e(Form::text('user[end_date]', isset($user_data['end_date']) ? date("d/m/Y",strtotime($user_data['end_date'])) : '', array('class'=>'form-control required','placeholder' => 'End Date','id' => 'end_date'))); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>

            <?php if (isset($id) && $id) { ?>

                <?php
                $state_ids = isset($state_id) ? $state_id : '';
                $state_ids = ($state_ids) ? $state_ids : [''];

                $selected_districts = isset($selected_districts) ? $selected_districts : '';
                $selected_districts = ($selected_districts) ? $selected_districts : [''];
                if ($states) {
                    ?>
                    <div class="col-lg-12" id="stateList">
                        <div class="row">
                            <!-- Start .row -->

                            <div class="panel panel-default">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"><i class="fa fa-list-alt"></i> State select section</h4>
                                </div>
                                <div class="panel-body pt0 pb0">

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <select multiple="multiple" name="state[]" size="10"  class="state-duallistbox" onchange="populateDistrict()">
                                                <optgroup>
                                                    <?php foreach ($states as $key => $value) { ?>
                                                        <option <?= in_array($key, $state_ids) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->

                                </div>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                <?php }
                ?>
                <div class="col-lg-12 district_id">
                    <div class="row">
                        <!-- Start .row -->

                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-heading">
                                <h4 class="panel-title"><i class="fa fa-list-alt"></i> District select section</h4>
                            </div>
                            <div class="panel-body pt0 pb0">

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <select multiple="multiple" name="district_id[]" size="10"  class="dist-duallistbox">
                                            <optgroup>
                                                <?php
                                                if ($districts) {
                                                    foreach ($districts as $key => $value) {
                                                        ?>
                                                        <option <?= in_array($key, $selected_districts) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                <!--                                                        <input type="hidden" name="district_names[]" value="<?= $value ?>">-->
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </optgroup>
                                        </select>

                                    </div>
                                </div>
                                <!-- End .form-group  -->

                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            <?php }
            ?>

            <!-- End .form-group  -->

            <?php
            if (isset($id) && $id) {
                $permissions = (!empty($permissions)) ? $permissions : [];
                $master_access_rights = ['X' => 'access', 'A' => 'add', 'E' => 'edit', 'V' => 'view', 'S' => 'search', 'P' => 'print', 'D' => 'delete'];
                if ($forms) {
                    ?>
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="panel">

                                <div class="panel-heading white-bg">
                                    <h3>Access Rights</h3>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>  
                                            <th class="">Group Name</th>
                                            <th class="">Form Name</th>
                                            <th class="">Access</th>
                                            <th class="">Add</th>
                                            <th class="">Edit</th>
                                            <th class="">View</th>                                         
                                            <th class="">Search</th>
                                            <th class="">Print</th>
                                            <th class="">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $user_crt_id = isset($user_data['crt_id']) ? $user_data['crt_id'] : '';
                                        $user_crt_type = \App\Models\User\UserModel::where(['id' => $user_crt_id])->value('user_type');
                                        foreach ($forms as $key => $value) {
                                            $access_rights = explode(',', $value['access_rights']);
                                            // t($access_rights)
                                            ?>
                                            <tr>
                                                <td  class="">
                                                    <?= ucfirst($value['group']) ?>
                                                </td>
                                                <td  class="">
                                                    <?= $value['form_name'] ?>
                                                </td>
                                                <?php
                                                $form_unique_name = $value['form_name_unique'];
                                                foreach ($master_access_rights as $m_key => $m_value) {
                                                    if (in_array($m_key, $access_rights)) {
                                                        $permission_name = $form_unique_name . '_' . $m_value;
                                                        $name_field = 'permission[' . $permission_name . ']';
                                                        if ($user_crt_type == 'admin') {
                                                            ?>
                                                            <td  class=""> <?php echo e(Form::checkbox($name_field, '',(in_array($permission_name,$permissions)) ? true :false)); ?></td>
                                                            <?php
                                                        } else {
                                                            if (App\Models\UtilityModel::ifHasPermission($permission_name, $user_crt_id)) {
                                                                ?>
                                                                <td  class=""> <?php echo e(Form::checkbox($name_field, '',(in_array($permission_name,$permissions)) ? true :false)); ?></td>
                                                            <?php } else {
                                                                ?>
                                                                <td  class=""></td>
                                                                <?php
                                                            }
                                                        }
                                                    } else {
                                                        ?>
                                                        <td  class=""></td>
                                                        <?php
                                                    }
                                                }
                                                ?>           
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <?php
                }
            }
            ?>
            <!-- End .form-group  -->
            <input type="hidden" name="id" id="manage_user_id" value="<?= isset($id) ? $id : '' ?>">          
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                            <button type="submit" value="save" name="submit_user" class="btn btn-success">Save</button>                           
                            <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            <!-- End .form-group  -->
            <?php echo Form::close(); ?>

        </div>

    </div>

<?php } ?>

<?php
//$userLists = '';
if (!isset($id) && !$id) {
    if ($userLists) {
        ?>
        <div class="row">

            <div class="col-lg-12">
                <!-- col-lg-12 start here -->

                <div class="panel panel-primary">
                    <!-- Start .panel -->
                    <div class="panel-heading">
                        <h4 class="panel-title">User Lists</h4>
                    </div>
                    <div class="panel-body">
                        <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  class="text-center">User ID</th>
                                    <th  class="text-center">User Name</th>
                                    <th  class="text-center">Role</th>
                                    <th  class="text-center">Created By</th>
                                    <th  class="text-center">Status</th>
                                    <th  class="text-center">Period</th>                               
                                    <th  class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if ($userLists) {
                                    foreach ($userLists as $key => $value) {
                                        //t($value);
                                        if ($value['user_type'] !== 'admin') {
                                            ?>
                                            <tr>
                                                <td  class="text-center"><?= $value['id'] ?></td>
                                                <td  class="text-center"><?= $value['user_name'] ?></td>
                                                <td  class="text-center"><?= \App\Models\Role\Role::where(['id' => $value['role_id']])->value('display_name') ?></td>
                                                <td  class="text-center"><?= App\Models\User\UserModel::where(['id' => $value['crt_id']])->value('user_name') ?></td>
                                                <td  class="text-center"><?= $value['fl_archive'] == 'N' ? '<span class="label label-success mr10 mb10">Active</span>' : '<span class="label label-warning mr10 mb10">Inactive</span>' ?></td>
                                                <td  class="text-center"><?= date('d/m/Y', strtotime($value['start_date'])) . '   to   ' . date('d/m/Y', strtotime($value['end_date'])) ?></td>
                                                <td  class="text-center">
                                                    <a href="<?= url('user-management/user/add/' . $value['id']) ?>">Manage</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- End .panel -->
            </div>
        </div>
        <?php
    }
}
?>
