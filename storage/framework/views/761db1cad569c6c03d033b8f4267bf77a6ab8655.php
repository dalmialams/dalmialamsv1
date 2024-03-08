<?php $__env->startSection('content'); ?>
<style>
    .welcome_bg{
        background:url('assets/img/login_bg.jpg') no-repeat center bottom;
        background-size:cover;
    }
</style>
<div class="container">
   
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>