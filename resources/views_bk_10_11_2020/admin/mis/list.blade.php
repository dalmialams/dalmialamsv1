
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
                {!! Form::open(['url' => url('mis/registration'),'class' => 'form-horizontal reg-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label">State</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[state_id]', isset($states) ?$states : '' , isset($state_id) ? $state_id : '',array('class'=>'form-control select2-minimum','onchange' => 'populateDistrict($(this).val())'))}}
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                            <label class="col-lg-5 col-md-3 control-label">District</label>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('registration[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($district_id) ? $district_id : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))}}
                            </div>

                        </div>

                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">
                    <div class="row">
                        <!-- Start .row -->                   
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group block-list">
                            <label class="col-lg-5 col-md-3 control-label">Block/Taluk</label>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('registration[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($block_id) ? $block_id : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))}}
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                            <label class="col-lg-5 col-md-3 control-label">Village</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($village_id) ? $village_id : '',array('class'=>'form-control select2-minimum ','onchange' => ''))}}
                            </div>
                        </div>                                       
                    </div>
                    <!-- End .row -->
                </div>

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Sub Registrar Office</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[sub_registrar]', isset($sub_registrar_office) ? $sub_registrar_office : '', isset($sub_registrar) ? $sub_registrar : '',array('class'=>'form-control select2-minimum required'))}}

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Regn No</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('registration[regn_no]', isset($regn_no) ? $regn_no : '', array('class'=>'form-control','placeholder' => 'Regn No')) }}
                            </div>
                        </div>
                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Unique No</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('registration[id]', isset($id) ? $id : '', array('class'=>'form-control','placeholder' => 'Unique No')) }}
                            </div>
                        </div>
                        <!--                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                                                <label class="col-lg-5 col-md-3 control-label">Survey No</label>
                                                <div class="col-lg-7 col-md-9">
                                                    {{ Form::text('registration[vendor]', isset($reg_data['vendor']) ? $reg_data['vendor'] : '', array('class'=>'form-control','placeholder' => 'Survey No')) }}
                        
                                                </div>
                                            </div>-->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                            <label class="col-lg-5 col-md-3 control-label">Purchase Type</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[purchase_type_id]', isset($purchase_type) ? $purchase_type : '', isset($purchase_type_id) ? $purchase_type_id : '',array('class'=>'form-control select2-minimum '))}}
                            </div>

                        </div>

                    </div>
                    <!-- End .row -->
                </div>

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Year (From - To)</label>
                            <div class="col-lg-7 col-md-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group paymentValidate">
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                            {{ Form::text('registration[from_date]', isset($from_date) ? $from_date : '', array('class'=>'form-control basic-datepicker','placeholder' => 'From')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group paymentValidate">
                                            <!--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>-->
                                            {{ Form::text('registration[to_date]', isset($to_date) ? $to_date : '', array('class'=>'form-control basic-datepicker','placeholder' => 'To')) }}
                                        </div>
                                    </div>															
                                </div>															

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Legal Entity</label>
                            <div class="col-lg-7 col-md-9">

                                {{Form::select('registration[legal_entity]', isset($legal_entry) ? $legal_entry : '', isset($legal_entity) ? $legal_entity : '',array('class'=>'form-control select2-minimum '))}}
                            </div>
                        </div>
                    </div>
                    <!-- End .row -->

                </div>
                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">

                            <label class="col-lg-5 col-md-3 control-label">Name of the Purchaser</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[purchaser]', isset($purchase) ?$purchase : '' , isset($purchaser) ? $purchaser : '',array('class'=>'form-control select2-minimum'))}}
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                            <label class="col-lg-5 col-md-3 control-label">Purchasing Team</label>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('registration[purchasing_team_id]', isset($purchasing_team) ?$purchasing_team : array('' => 'Select') , isset($purchasing_team_id) ? $purchasing_team_id : '',array('class'=>'form-control select2-minimum'))}}
                            </div>

                        </div>

                    </div>
                    <!-- End .row -->

                </div>


                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <?php
                        if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('survey_no_details_search', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                            ?>  
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">

                                <label class="col-lg-5 col-md-3 control-label">Survey No</label>
                                <div class="col-lg-7 col-md-9">
                                    {{Form::select('registration[survey_no]', isset($survey_list) ?$survey_list : array('' => 'Select') , isset($survey_no) ? $survey_no : '',array('class'=>'form-control select2'))}}
                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">
                                <label class="col-lg-5 col-md-3 control-label">Survey No</label>
                                <div class="col-lg-7 col-md-9">
                                    {{Form::select('registration[survey_no]', isset($survey_list) ?$survey_list : array('' => 'Select') , isset($survey_no) ? $survey_no : '',array('class'=>'form-control select2','disabled' => 'true'))}}
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                            <label class="col-lg-5 col-md-3 control-label">Purpose</label>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('registration[purpose]', isset($land_usage) ?$land_usage : array('' => 'Select') , isset($purpose) ? $purpose : '',array('class'=>'form-control select2-minimum'))}}
                            </div>

                        </div>

                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="classificationList">
                            <label class="col-lg-5 col-md-3 control-label">Classification</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('registration[classification]', isset($plot_classification) ?$plot_classification : '' , isset($classification) ? $classification : '',array('class'=>'form-control select2-minimum','onchange' => 'populatesubclassification($(this).val())'))}}
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group subclassificationList">
                            <label class="col-lg-5 col-md-3 control-label">Sub Classification</label>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('registration[sub_classification]', isset($sub_classinfo) ? $sub_classinfo : array('' => 'Select') , isset($sub_classification) ? $sub_classification : '',array('class'=>'form-control select2-minimum required sub_classification'))}}
                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>

                <!-- End .row -->
                <!-- End .form-group  -->
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" value="search" name="search_reg" class="btn btn-success">Export</button>
                                <a href="<?= url('mis/registration') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
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
