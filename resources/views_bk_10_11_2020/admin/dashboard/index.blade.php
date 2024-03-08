
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->
<!--<section>
    <div class="container">
        <div class="row">
             col-md-6 end here 
            <div class="col-md-6 text-left">
                 col-md-6 start here 
                <ul class="breadcrumb">
                    <li><a href="<?php echo url('dashboard'); ?>">Dashboard</a></li>
                    <li class="active"><?php echo isset($filter) ? $filter : '' ?></li>
                </ul>
            </div>
             col-md-6 end here 
        </div>
         / .row 
    </div>
</section>-->

<style>
    .dataTables_wrapper .DTTT.btn-group {
        position:relative;
        z-index: 1;
        margin-top: -55px;
    }
    .form-group.select_criteria{margin-bottom: 0px;}
</style>
<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->


        <div class="panel panel-primary">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Dashboard </h4>

            </div>
            <div class="panel-body">


                @include('admin.dashboard.selectionCriteria')
                @include('admin.dashboard.state')

                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="displayCostDistributionModal">
                    <div class="modal-dialog" id="displayCostDistributionDetails">

                    </div>
                </div>

            </div>
        </div>
        <!-- End .panel -->
    </div>
</div>

@endsection
