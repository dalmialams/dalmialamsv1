<!doctype html>
<!--[if lt IE 8]><html class="no-js lt-ie8"> <![endif]-->
<html class="no-js">

    <body class="welcome_bg">
        <!-- #header -->
        @include('admin.common.header')
        <!-- / #header -->
        <!-- #navbar -->

        @include('admin.common.navbar')

        <!-- / #navbar -->
        <!-- #wrapper -->
        <div id="content">
            <!-- #leftsidebar -->
            {{--@include('admin.common.leftsidebar')--}}
            <!-- / #leftsidebar -->
            <!-- #leftsidebar -->
            {{--@include('admin.common.rightsidebar')--}}
            <!-- / #rightsidebar -->
            <!-- #content -->
            @include('admin.common.pageHeader')
            <!-- / #content -->
        </div>
        <!-- / #wrapper -->
        <script>
            BASE_URL = '<?php url('/'); ?>'
        </script>
        <!-- #leftsidebar -->
        @include('admin.common.footer')
        <!-- / #rightsidebar -->

    </body>
</html>