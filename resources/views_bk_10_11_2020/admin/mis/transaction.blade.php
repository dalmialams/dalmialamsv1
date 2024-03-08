
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->

<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->


        <div class="panel panel-primary  toggle panelMove">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Search Screen</h4>
            </div>
            <div class="panel-body">
                {!! Form::open(['url' => url('mis/transaction'),'class' => 'form-horizontal reg-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label">Transactions</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[trxn]', isset($transaction_arr) ?$transaction_arr : '' ,  '',array('class'=>'form-control select2-minimum trxn','id'=>'transaction_type'))}}
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label">State</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[state_id]', isset($states) ?$states : '' , isset($state_id) ? $state_id : '',array('class'=>'form-control select2-minimum','onchange' => 'populateDistrict($(this).val())'))}}
                            </div>

                        </div>


                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                            <label class="col-lg-5 col-md-3 control-label">District</label>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('registration[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($district_id) ? $district_id : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))}}
                            </div>

                        </div>
                        <!-- Start .row -->                   
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group block-list">
                            <label class="col-lg-5 col-md-3 control-label">Block/Taluk</label>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('registration[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($block_id) ? $block_id : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))}}
                            </div>
                        </div>

                    </div>
                    <!-- End .row -->
                </div>
                <div class="col-lg-12">

                    <div class="row">                      
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                            <label class="col-lg-5 col-md-3 control-label">Village</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($village_id) ? $village_id : '',array('class'=>'form-control select2-minimum village','onchange' => '','id' => 'village_id'))}}
                            </div>
                        </div>  
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="survey-list">

                            <label class="col-lg-5 col-md-3 control-label">Survey No</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[survey_id]', isset($all_surveys) ?$all_surveys : '' ,  '',array('class'=>'form-control select2-minimum'))}}
                            </div>

                        </div>
                    </div>
                    <!-- End .row -->
                </div>
                <div class="col-lg-12" id="transaction_type_box">


                </div>

                <!-- End .row -->
                <!-- End .form-group  -->
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" value="search" name="search_reg" class="btn btn-success">Export</button>
                                <a href="<?= url('mis/transaction') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- End .form-group  -->


            <!-- End .form-group  -->
        </div>



    </div>
</div>


@endsection
