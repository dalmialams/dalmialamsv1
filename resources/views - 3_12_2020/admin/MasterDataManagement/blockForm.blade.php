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

    $mesages = $errors->blockError->all();
}
?>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <div class="panel-heading">
        <h4 class="panel-title"></h4>
    </div>
<?php
if ($mesages) {
    foreach ($mesages as $key => $value) {
        ?>
            <div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong><?php echo $value; ?>!</strong></div>

        <?php
        }
    }
    ?>   
    <div>{!! Session::get('message')!!}</div>
    <!-- Start .panel -->
    <div class="panel-body">
        {{--@include('admin.MasterDataManagement.nav')--}}
        
        {!! Form::open(['url' => url('master/tehsil/submit-data'),'class' => 'form-horizontal reg-form','method' => 'POST','id'=>'my-form', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-5 col-md-3 control-label">State</label>
                    <div class="col-lg-7 col-md-9">
                        {{Form::select('block[state_id]', isset($states) ?$states : '' , isset($blockDetails['state_id']) ? $blockDetails['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val(),"block")'))}}
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                    <label class="col-lg-5 col-md-3 control-label">District</label>
                    <div class="col-lg-7 col-md-9">                       
                        {{Form::select('block[district_id]', isset($districtList) ?$districtList :  [''=>'Select']  , isset($blockDetails['district_id']) ? $blockDetails['district_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateBlock($(this).val())'))}}
                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->


                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label">Block Name</label>
                    <div class="col-lg-7 col-md-9">
                        {{ Form::text('block[block_name]', isset($blockDetails['block_name']) ? $blockDetails['block_name'] : '', array('class'=>'form-control required','placeholder' => 'Block Name')) }}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-5 col-md-3 control-label">Map Available</label>
                    <div class="col-lg-7 col-md-9">
                        {{Form::select('block[map_exists]', ['N'=>'No','Y'=>'Yes'] , isset($blockDetails['map_exists']) ? $blockDetails['map_exists'] : '',array('class'=>'form-control select2-minimum required'))}}
                    </div>

                </div>
            </div>

        </div>
		
		  <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-5 col-md-3 control-label">Active</label>
                    <div class="col-lg-7 col-md-9">
                        <!--{{Form::select('block[fl_archive]', ['N'=>'Yes','Y'=>'No'] , isset($blockDetails['fl_archive']) ? $blockDetails['fl_archive'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val(),"village")'))}}-->
						{{Form::select('block[fl_archive]', ['N'=>'Yes','Y'=>'No'] , isset($blockDetails['fl_archive']) ? $blockDetails['fl_archive'] : '',array('class'=>'form-control select2-minimum required'))}}

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

                        <a href="<?= /* redirect('master/block/management')->with('data','CD00153') */url('master/tehsil/management') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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
