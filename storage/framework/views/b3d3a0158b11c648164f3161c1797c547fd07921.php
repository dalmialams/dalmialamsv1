<?php $__env->startSection('content'); ?>
<!-- .page-content -->
<?php echo $__env->make('admin.ShapeFileManagement.shape_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('admin.ShapeFileManagement.RailwayTrack.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>