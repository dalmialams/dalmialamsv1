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

    $mesages = $errors->propertyError->all();
}
?>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
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
     <div class="panel-heading">
        <h4 class="panel-title"></h4>
    </div>
    <div class="panel-body">
         {{--@include('admin.MasterDataManagement.nav')--}}

        {!! Form::open(['url' => url('master/property/submit-data'),'class' => 'form-horizontal reg-form','method' => 'POST','id'=>'my-form', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

        <div class="col-lg-12">
            <div class="row ">
                
                <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-2 col-md-3 control-label"> Property Name <span class="text-danger" >*</span> </label>
                        <div class="col-lg-10 col-md-9">

                            {{ Form::text('property[property_name]',isset($property_detail['property_name']) ? $property_detail['property_name'] : '', array('class'=>'form-control required','placeholder' => 'Property Name')) }}
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-2 col-md-3 control-label"> Location <span class="text-danger" >*</span> </label>
                        <div class="col-lg-10 col-md-9">
                            {{ Form::text('property[property_location]', isset($property_detail['property_location']) ? $property_detail['property_location'] : '', array('class'=>'form-control required','placeholder' => 'Location')) }}
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-2 col-md-3 control-label"> Address </label>
                        <div class="col-lg-10 col-md-9">

                            {{ Form::textarea('property[property_address]', isset($property_detail['property_address']) ? $property_detail['property_address'] : '', array('class'=>'form-control','placeholder' => 'Address','size' => '30x3')) }}

                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group " >
                        <label class="col-lg-2 col-md-3 control-label"> State <span class="text-danger" >*</span></label>
                        <div class="col-lg-10 col-md-9">
                   
                            <select name="property[state_id]" class="form-control select2-minimum required" id="propertyState"  >                                
                                @if(isset($stateList) && !empty($stateList)) 
                                    @foreach ($stateList as $stKey => $state) 
                                        <option value="{{$stKey}}" @if(isset($property_detail['state_id']) && ($property_detail['state_id'] == $stKey)) {{"selected"}} @endif > {{ $state}}  </option>
                                    @endforeach
                                @endif
                                   
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group cityList ">
                        <label class="col-lg-2 col-md-3 control-label"> City <span class="text-danger" >*</span> </label>
                        <div class="col-lg-10 col-md-9">
                           
                            <select name="property[city_id]" class="form-control select2-minimum required" id="propertyCity" data-placeholder="--Select--" >
                                <option value=""> --Select-- </option>
                                @if(isset($cityList) && !empty($cityList)) 
                                    @foreach ($cityList as $ctKey => $cityval) 
                                        <option value="{{$cityval->id}}" @if(isset($property_detail['city_id']) && ($property_detail['city_id'] == $cityval->id)) {{"selected"}} @endif> {{ $cityval->city_name}}  </option>
                                    @endforeach
                                @endif
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-2 col-md-3 control-label"> Type </label>
                        <div class="col-lg-10 col-md-9">
                            {{ Form::text('property[property_type]', isset($property_detail['property_type']) ? $property_detail['property_type'] : '',  array('class'=>'form-control ','placeholder' => 'Property Type')) }}
                        </div>
                    </div>
                
            </div>

        </div>
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
              
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Active</label>
                    <div class="col-lg-10 col-md-9">

                        <select name="property[fl_archive]" class="form-control select2-minimum" id="fl_archive"  >                                
                            <option value="N" @if(isset($property_detail['fl_archive']) && ($property_detail['fl_archive'] == 'N')) {{"selected"}} @endif > Yes </option>
                            <option value="Y" @if(isset($property_detail['fl_archive']) && ($property_detail['fl_archive'] == 'Y')) {{"selected"}} @endif > No </option>    
                                
                        </select>

                    </div>
                </div>
            </div>
            <!-- End .row -->

        </div>


        <!-- End .form-group  -->

        <!-- End .form-group  -->
        <input type="hidden" name="id" value="<?= isset($id) ? encrypt($id) : '' ?>">
        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">

                        <a href="{{ url('master/property/management') }}"><button type="button" class="btn btn-danger">Cancel</button></a>
                        <button type="submit" value="save" name="save_property" class="btn btn-success">Save</button>



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
