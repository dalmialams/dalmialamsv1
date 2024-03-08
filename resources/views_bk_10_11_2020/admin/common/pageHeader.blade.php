<section id="topbar">
    <div class="container">
        <div class="row">
            <!-- .row start -->
            @if (!str_contains(Request::fullUrl(), 'dashboard'))
            <div class="col-md-6 header_no_padding">
                <!-- col-md-6 start here -->
                <h1>{!!@isset($pageHeading)?$pageHeading:''!!}</h1>
            </div>
            <div class="col-md-6 text-right header_no_padding">
                <!-- col-md-6 start here -->
               
                <h1><span class="text-danger">{!!@isset($current_user_name)?$current_user_name:''!!} <?php echo isset($current_user_role_name) ?  ' ('.$current_user_role_name.')' : ''; ?></span></h1>
            </div>
             @endif
            <!-- col-md-6 end here -->
            @if (str_contains(Request::fullUrl(), 'dashboard'))
            <div class="col-md-6 text-left">
                <!-- col-md-6 start here -->
                <ul class="breadcrumb">
                    <li><a href="<?php echo url('dashboard'); ?>">Dashboard</a></li>
                    
                    <li class="active"><?php echo isset($dashboard_search) ? $dashboard_search : '' ?></li>
                </ul>
            </div>
            <div class="col-md-6 text-right">
                <!-- col-md-6 start here -->
                 <h1><span class="text-danger">{!!@isset($current_user_name)?$current_user_name:''!!} <?php echo isset($current_user_role_name) ?  ' ('.$current_user_role_name.')' : ''; ?></span></h1>
            </div>
            @endif

            <!-- col-md-6 end here -->
        </div>
        <!-- / .row -->
    </div>
</section>

<section class="services-preview white-bg">
    <div class="container">
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <!--                <div id="page-header" class="clearfix">
                                    <div class="page-header">
                                        <h2>{!!@isset($pageHeading)?$pageHeading:''!!}</h2>
                                    </div>
                                </div>-->
                <!-- Start .row -->
                <div class="row">
                    @yield('content')
                </div>
            </div>
            <!-- End .page-content-inner -->
        </div>
    </div>
</section>
<!-- / page-content -->

