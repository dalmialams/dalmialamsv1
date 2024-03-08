<!doctype html>
<!--[if lt IE 8]><html class="no-js lt-ie8"> <![endif]-->
<html class="no-js">

    <body class="welcome_bg">
        <!-- #header -->
        <?php echo $__env->make('admin.common.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- / #header -->
        <!-- #navbar -->

        <?php echo $__env->make('admin.common.navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- / #navbar -->
        <!-- #wrapper -->
        <div id="content">
            <!-- #leftsidebar -->
            <?php /*<?php echo $__env->make('admin.common.leftsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <!-- / #leftsidebar -->
            <!-- #leftsidebar -->
            <?php /*<?php echo $__env->make('admin.common.rightsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <!-- / #rightsidebar -->
            <!-- #content -->
            <?php echo $__env->make('admin.common.pageHeader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- / #content -->
        </div>
        <!-- / #wrapper -->
        <script>
            BASE_URL = '<?php url('/'); ?>'
        </script>
        <!-- #leftsidebar -->
        <?php echo $__env->make('admin.common.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- / #rightsidebar -->

    </body>
</html>