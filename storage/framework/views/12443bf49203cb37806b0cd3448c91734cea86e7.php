<?php $__env->startSection('content'); ?>
<!-- .page-content -->
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->reset_pwd->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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
	<div class="alert alert-info">
		<strong>Password must contain  minimum 8 charecters and one special character one number and texts </strong>
	</div>
<div class="panel panel-primary">
    <!-- Start .panel -->
	
    <?php if ($view_form) { ?>
        <div class="panel-body">

            <?php echo Form::open(['url' => url('submit-reset-password'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>New Password</label>
                        <div class="col-lg-7 col-md-9">

                            <input type="password" class="form-control" id="" name="password[new_password]" placeholder="New Password">
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Confirm New Password</label>
                        <div class="col-lg-7 col-md-9">
                            <input type="password" class="form-control" id="" name="password[cnf_new_password]" placeholder="Confirm Current Password">
                        </div>

                    </div>

                </div>
                <!-- End .row -->
            </div>



            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <input type="hidden" name="encrypted_user_id" value="<?= isset($encrypted_user_id) ? $encrypted_user_id : '' ?>">
                            <input type="hidden" name="password[user_id]" value="<?= isset($user_id) ? $user_id : '' ?>">
                            <input type="hidden" name="password[key]" value="<?= isset($key) ? $key : '' ?>">
                            <button type="submit" value="save" name="submit_user" class="btn btn-success">Save</button>                           
                            <a href="<?= url('forgot-password') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            <!-- End .form-group  -->
            <?php echo Form::close(); ?>

        </div>
    <?php } else { ?>
        <div class="panel-body">
            <?= $msg ?>
        </div>
    <?php } ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>