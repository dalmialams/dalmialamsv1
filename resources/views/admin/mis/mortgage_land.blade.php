@extends('admin.layouts.adminlayout')
@section('content')
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->land_reservation->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div>{!! Session::get('message')!!}</div>
<?php
if ($mesages) {
    foreach ($mesages as $key => $value) {
        echo $value;
    }
}
?>   
<?php if (!$viewMode) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <!-- Start .panel -->
        <div class="panel-body">
            {!! Form::open(['url' => url('mis/mortgage_land'),'class' => 'form-horizontal hypothecate-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}


            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Mortgage Land</label>
                        <?php
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('', isset($hypothecate_name) ?$hypothecate_name : '' , isset($hypothecate_data_data['hyp_name'])? $hypothecate_data_data['hyp_name'] : '' ,array('class'=>'form-control select2-minimum required','disabled' => true))}}
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('hypothecate[hyp_name]', isset($hypothecate_name) ?$hypothecate_name : '' , '' ,array('class'=>'form-control select2-minimum required'))}}
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Transaction Type</label>
                        <?php
                        $trxn_type = isset($hypothecate_data_data['trxn_type']) ? $hypothecate_data_data['trxn_type'] : '';
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('', isset($type) ?$type : '' , $trxn_type ,array('class'=>'form-control select2-minimum required','disabled' => true))}}
                                <input type="hidden" name="hypothecate[trxn_type]" value="<?= $trxn_type ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('hypothecate[trxn_type]', isset($type) ?$type : '' , $trxn_type ,array('class'=>'form-control select2-minimum required trxn_type','onchange' => 'populateResistration($(this).val())'))}}
                            </div>
                        <?php } ?>
                    </div>

                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group registration_id">
                        <label class="col-lg-5 col-md-3 control-label">Registration No.</label>
                        <?php if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('', isset($related_registration_ids) ? $related_registration_ids : '' , isset($related_registration_ids) ? $related_registration_ids : '' ,array('class'=>'form-control select2-minimum required','disabled' => true,'multiple'=>'multiple'))}}
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('hypothecate[registration_id]', isset($survey_info) ? $survey_info : array('' => 'Select') , isset($land_reservation_data['village_id']) ? $land_reservation_data['village_id'] : '',array('class'=>'form-control select2-minimum','id' => 'survey_id'))}}
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Date</label>
                        <div class="col-lg-7 col-md-9">
                            <div class="input-group">
                                <?php if ($id) {
                                    ?>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {{ Form::text('', isset($hypothecate_data_data['hyp_date']) ? date('d/m/Y', strtotime($hypothecate_data_data['hyp_date'])) : '', array('class'=>'form-control required','placeholder' => 'Date','id'=>'basic-datepicker','disabled' => true)) }}
                                    <input type="hidden" name="hypothecate[hyp_date]" value="<?= isset($hypothecate_data_data['hyp_date']) ? date('d/m/Y', strtotime($hypothecate_data_data['hyp_date'])) : ''; ?>">
                                <?php } else { ?>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {{ Form::text('hypothecate[hyp_date]', isset($hypothecate_data_data['hyp_date']) ? $hypothecate_data_data['hyp_date'] : '', array('class'=>'form-control required','placeholder' => 'Date','id'=>'basic-datepicker')) }}
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12 registration_details"></div>

            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Mortgage Land With</label>
                        <?php
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('', isset($hypothecate_with) ?$hypothecate_with : '' , isset($hypothecate_data_data['hyp_with'])? $hypothecate_data_data['hyp_with'] : '' ,array('class'=>'form-control select2-minimum required','disabled' => true))}}
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('hypothecate[hyp_with]', isset($hypothecate_with) ?$hypothecate_with : '' , '' ,array('class'=>'form-control select2-minimum required'))}}
                            </div>
                        <?php } ?>
                    </div>

                </div>
                <!-- End .row -->

            </div>
            <div class="col-lg-12 registration_document_details"></div>

            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" value="save" name="save_land_reservation" class="btn btn-success">Export</button>                           
                            <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
<?php } ?>

@endsection
