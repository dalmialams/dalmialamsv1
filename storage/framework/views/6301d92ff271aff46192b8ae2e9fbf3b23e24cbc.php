<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->role->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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

<div class="panel panel-primary">
    <!-- Start .panel -->
    <div class="panel-body">

        <?php echo Form::open(['url' => url('user-management/role/submit-data'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Role Name</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('role[name]', isset($role_data['display_name']) ? $role_data['display_name'] : '', array('class'=>'form-control required','placeholder' => 'Role Name'))); ?>

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Status</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::select('role[status]', isset($status) ? $status : '', isset($role_data['status']) ? $role_data['status'] : '',array('class'=>'form-control select2-minimum required'))); ?>

                    </div>

                </div>

            </div>
            <!-- End .row -->
        </div>

        <!-- End .form-group  -->
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">          
        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Save</button>                           
                        <a href="<?= url('user-management/role/add') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        <?php echo Form::close(); ?>

    </div>

</div>



<?php
$userLists = '';
if ($roles) {
    ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- col-lg-12 start here -->

            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Role Lists</h4>
                </div>
                <div class="panel-body">
                    <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>                               
                                <th  class="text-center">Role Name</th>
                                <th  class="text-center">Status</th>
                                <th  class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($roles) {
                                foreach ($roles as $key => $value) {
                                    ?>
                                    <tr>
                                        <td  class="text-center"><?= $value['display_name'] ?></td>
                                        <td  class="text-center"><?= $value['fl_archive'] == 'N' ? '<span class="label label-success mr10 mb10">Active</span>' : '<span class="label label-warning mr10 mb10">Inactive</span>' ?></td>
                                        <td  class="text-center">  <div class="action-buttons">
                                                <a title="Edit" href="<?= url('user-management/role/add/' . $value['id']) ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>&nbsp;
<!--                                                <a title="Remove" href="javascript:void(0);">
                                                    <i role_id="<?= $value['id'] ?>"  class="ace-icon fa fa-times bigger-130  delete-role"></i>
                                                </a>-->
                                            </div></td>

                                                            <!--                                        <td  class="text-center">
                                                                  <a href="<?= url('user-management/user/add/' . $value['id']) ?>">Manage</a>
                                                              </td>-->
                                    </tr>
                                    <?php
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
<?php } ?>
