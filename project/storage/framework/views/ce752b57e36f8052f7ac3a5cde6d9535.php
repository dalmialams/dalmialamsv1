<!doctype html>
<!--[if lt IE 8]><html class="no-js lt-ie8"> <![endif]-->
<html class="no-js">

    <body class="welcome_bg">
        <!-- #header -->
        <?php echo $__env->make('admin.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- / #header -->
        <!-- #navbar -->

        <?php echo $__env->make('admin.common.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- / #navbar -->
        <!-- #wrapper -->
        <div id="content">
            <!-- #leftsidebar -->
            
            <!-- / #leftsidebar -->
            <!-- #leftsidebar -->
            
            <!-- / #rightsidebar -->
            <!-- #content -->
            <?php echo $__env->make('admin.common.pageHeader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- / #content -->
        </div>
        <!-- / #wrapper -->
        <script>
            BASE_URL = '<?php url('/'); ?>'
        </script>
        <!-- #leftsidebar -->
        <?php echo $__env->make('admin.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- / #rightsidebar -->

    </body>
</html><?php /**PATH C:\wamp64\www\dalmialamsv1\resources\views/admin/layouts/adminlayout.blade.php ENDPATH**/ ?>