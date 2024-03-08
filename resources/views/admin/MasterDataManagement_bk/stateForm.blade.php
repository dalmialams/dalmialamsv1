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

    $mesages = $errors->stateError->all();
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
         {{--@include('admin.MasterDataManagement.nav')--}}

        {!! Form::open(['url' => url('master/state/submit-data'),'class' => 'form-horizontal reg-form','method' => 'POST','id'=>'my-form', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
              
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">State Name</label>
                    <div class="col-lg-10 col-md-9">
                        {{ Form::text('state[state_name]', isset($stateDetails['state_name']) ? $stateDetails['state_name'] : '', array('class'=>'form-control ','placeholder' => 'State Name')) }}
                    </div>
                </div>
            </div>
            <!-- End .row -->

        </div>
		  <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
              
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Short Code</label>
                    <div class="col-lg-10 col-md-9">
                        {{ Form::text('state[state_prefix]', isset($stateDetails['state_prefix']) ? $stateDetails['state_prefix'] : '', array('class'=>'form-control ','placeholder' => 'Short Code')) }}
                    </div>
                </div>
            </div>
            <!-- End .row -->

        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
              
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Active</label>
                    <div class="col-lg-10 col-md-9">
                                              {{Form::select('state[fl_archive]', ['N'=>'Yes','Y'=>'No'] , isset($stateDetails['fl_archive']) ? $stateDetails['fl_archive'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val(),"village")'))}}

                    </div>
                </div>
            </div>
            <!-- End .row -->

        </div>
        

        

        <!-- End .form-group  -->

        <!-- End .form-group  -->
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
         <div class="form-group">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        
                        <a href="<?= /*redirect('master/block/management')->with('data','CD00153')*/url('master/state/management') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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


 
@endsection
