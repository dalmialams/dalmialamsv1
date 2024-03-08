<?php $__env->startSection('content'); ?>
<!-- .page-content -->
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->forgot_pwd->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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

        <?php echo Form::open(['url' => url('submit-forgot-password'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="form-group">
                    <label class="col-sm-4 control-label" style="text-align:right;"><span class="red" style="color:red">* </span>User Name</label>
                    <div class="col-sm-4">
                        <?php echo e(Form::text('password[user_name]',  '', array('class'=>'form-control required','placeholder' => 'Enter User Name'))); ?>

                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </div>
            <!-- End .row -->
        </div>

        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Submit</button>                           
                        <a href="<?= url('forgot-password') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        <?php echo Form::close(); ?>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>