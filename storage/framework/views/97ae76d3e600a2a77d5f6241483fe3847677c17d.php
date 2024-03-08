

<!-- / page-navbar -->
<div id="header" class="header-fixed">
    <!-- #header -->
    <div class="container-flex">
        <a href="#" class="responsive-menu-toggle">
            <i class="fa fa-reorder"></i>
            <span class="sr-only">Dalmia Lams</span>
        </a>
        <?php
        if (isset($current_user_id) && $current_user_id) {
            if ($user_type == 'admin' || \App\Models\UtilityModel::ifHasPermission('dashboard_access', $current_user_id)) {
                $url = url('dashboard');
            } else {
                $url = url('landing');
            }
        } else {
            $url = url('/');
        }
        ?>
        <a href="<?= $url ?>" class="logo">
            <img src="<?php echo e(URL::asset('assets/img/left_logo.png')); ?>" alt="Dalmia Lams">
        </a>
        <?php if (isset($current_user_id) && $current_user_id) { ?>
            <div class="site-nav">
                <?php echo $MyNavBar->asUl(array('class' => ''),array('class' => 'dropdown-menu right','role' => 'menu')); ?>

            </div>
        <?php } ?>
        <!-- / .site-nav -->

    </div>
    <!-- / .container -->
</div>
