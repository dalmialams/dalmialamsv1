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
                {!! Form::open(['url' => url('mis/land_inspection'),'class' => 'form-horizontal lease-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
    
    
                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">
    
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('inspection[state_id]', isset($states) ?$states : '' , isset($inspection_data['state_id']) ? $inspection_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))}}
                            </div>
    
                        </div>
    
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">
    
                            <label class="col-lg-5 col-md-3 control-label">District</label>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('inspection[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($inspection_data['district_id']) ? $inspection_data['district_id'] : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))}}
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
    
                                {{Form::select('inspection[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($inspection_data['block_id']) ? $inspection_data['block_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))}}
                            </div>
                        </div>
    
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                            <label class="col-lg-5 col-md-3 control-label">Village</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('inspection[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($inspection_data['village_id']) ? $inspection_data['village_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateSurvey("",$(this).val())'))}}
                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
    
                <div class="col-lg-12">
                    <div class="row">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group survey-list">
                            <label class="col-lg-5 col-md-3 control-label">Survey no.</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('inspection[survey_id]', isset($survey_info) ? $survey_info : array('' => 'Select') , isset($inspection_data['village_id']) ? $inspection_data['village_id'] : '',array('class'=>'form-control select2-minimum '))}}
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Encroachment</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('inspection[encroachment]', isset($encroachment_info) ? $encroachment_info : array('' => 'Select') , isset($inspection_data['encroachment']) ? $inspection_data['encroachment'] : '',array('class'=>'form-control select2-minimum ','onchange'=>'validateform($(this).find("option:selected").text())'))}}
                            </div>
                        </div>
                    </div>
    
                </div>
    
                <div class="col-lg-12">
                    <div class="row">
                        <!-- Start .row -->
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Encroachment Type</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('inspection[encroachment_type]', isset($encroachment_type) ? $encroachment_type : array('' => 'Select') , isset($inspection_data['encroachment_type']) ? $inspection_data['encroachment_type'] : '',array('class'=>'form-control select2-minimum ','onchange'=>'validateform1($(this).find("option:selected").text())'))}}
                            </div>
                        </div>
    
                    </div>
    
                </div>
    
    
                <!-- End .form-group  -->
                <input type="hidden" name="id" value="<?= isset($inspection_no) ? $inspection_no : '' ?>">
    
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
    
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" value="save" name="save_inspection" class="btn btn-success">Export</button>                           
                                <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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
