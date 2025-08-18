<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

@extends('admin.layouts.adminlayout')
@section('content')
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->villageError->all();
}
?>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <?php
    if ($mesages) {
        foreach ($mesages as $key => $value) {?>
    <div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong><?php  echo $value;?>!</strong></div>
           
    <?php     }
    }
    ?>   
    <div>{!! Session::get('message')!!}</div>
    <!-- Start .panel -->
    <div class="panel-body">
     

        {!! Form::open(['url' => url('master/village/submit-data'),'class' => 'form-horizontal reg-form','method' => 'POST','id'=>'my-form', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-5 col-md-3 control-label">State</label>
                    <div class="col-lg-7 col-md-9">
                        {{Form::select('village[state_id]', isset($states) ?$states : '' , isset($villageDetails['state_id']) ? $villageDetails['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val(),"village")'))}}
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                    <label class="col-lg-5 col-md-3 control-label">District</label>
                    <div class="col-lg-7 col-md-9">                       
                        {{Form::select('village[district_id]', isset($districtList) ?$districtList : [''=>'Select'], isset($villageDetails['district_id']) ? $villageDetails['district_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateBlock($(this).val(),"village")'))}}
                    </div>

                </div>
                 
            </div>
            <!-- End .row -->
        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
              
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group  block-list">
                    <label class="col-lg-5 col-md-3 control-label">Block Name</label>
                    <div class="col-lg-7 col-md-9">
                        {{ Form::select('village[block_id]',isset($blockList) ?$blockList : [''=>'Select'] , isset($villageDetails['block_id']) ? $villageDetails['block_id'] : '', ['class'=>'form-control select2-minimum required']) }}
                    </div>
                </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label">Village Name</label>
                    <div class="col-lg-7 col-md-9">
                        {{ Form::text('village[village_name]', isset($villageDetails['village_name']) ? $villageDetails['village_name'] : '', array('class'=>'form-control required','placeholder' => 'Village Name')) }}
                    </div>
                </div>
            </div>
           
        </div>
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
				
				 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-5 col-md-3 control-label">Map Available</label>
                    <div class="col-lg-7 col-md-9">
                        {{Form::select('village[map_exists]', ['N'=>'No','Y'=>'Yes'] , isset($villageDetails['map_exists']) ? $villageDetails['map_exists'] : '',array('class'=>'form-control select2-minimum required'))}}
                    </div>

                </div>
				
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-5 col-md-3 control-label">Active</label>
                    <div class="col-lg-7 col-md-9">
                        <!--{{Form::select('village[fl_archive]', ['N'=>'Yes','Y'=>'No'] , isset($villageDetails['fl_archive']) ? $villageDetails['fl_archive'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val(),"village")'))}}-->
						{{Form::select('village[fl_archive]', ['N'=>'Yes','Y'=>'No'] , isset($villageDetails['fl_archive']) ? $villageDetails['fl_archive'] : '',array('class'=>'form-control select2-minimum required'))}}

                    </div>

                </div>
                  
            </div>
           
        </div>
<!--        <div class="col-lg-12">
            <div class="row ">
               
              
              
            </div>
           
        </div>
        -->
        
        

        

        <!-- End .form-group  -->

        <!-- End .form-group  -->
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
         <div class="form-group">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        
                        <a href="<?= url()->previous() ;/*redirect('master/block/management')->with('data','CD00153')*//*url('master/village/management')*/?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        <button type="submit" value="save" name="save_reg" class="btn btn-success">Save</button>
                     
                       
                       
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        {!! Form::close() !!}
    </div>
</div>


<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->
 
@endsection
