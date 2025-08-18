
@extends('admin.layouts.adminlayout')
@section('content')
<div class="col-lg-12">
        <!-- col-lg-12 start here -->


        <div class="panel panel-primary  toggle panelMove">

            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Edit Shp Data</h4>
            </div>
            <div class="panel-body">
			<form method="post" action="{{URL('document-management/document/shape-file-update')}}" accept-charset="UTF-8" class="form-horizontal reg-form" enctype="multipart/form-data" role="form" autocomplete="off">
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                

                <div class="col-lg-12">
                    <div class="row ">
                       <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">

                            <label class="col-lg-5 col-md-3 control-label">District</label>
                            <div class="col-lg-7 col-md-9">
                              <div class="row">
                                    <input class="form-control basic-datepicker" placeholder="District" name="district" type="text" value="<?=isset($shpData->district)?$shpData->district:''?>">														
                                </div> 
                            </div>

                        </div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">

                            <label class="col-lg-5 col-md-3 control-label">State</label>
                            <div class="col-lg-7 col-md-9">
                              <div class="row">
                                    <input class="form-control basic-datepicker" placeholder="State" name="state" type="text" value="<?=isset($shpData->state)?$shpData->state:''?>">														
                                </div> 
                            </div>

                        </div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">

                            <label class="col-lg-5 col-md-3 control-label">Survey No</label>
                            <div class="col-lg-7 col-md-9">
                              <div class="row">
                                    <input class="form-control basic-datepicker" placeholder="Survey No" name="survey_no" type="text" value="<?=isset($shpData->surveyno)?$shpData->surveyno:''?>">														
                                </div> 
                            </div>

                        </div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">

                            <label class="col-lg-5 col-md-3 control-label">Village</label>
                            <div class="col-lg-7 col-md-9">
                              <div class="row">
                                    <input class="form-control basic-datepicker" placeholder="Village" name="village" type="text" value="<?=isset($shpData->village)?$shpData->village:''?>">														
                                </div> 
                            </div>

                        </div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">

                            <label class="col-lg-5 col-md-3 control-label">Taluk</label>
                            <div class="col-lg-7 col-md-9">
                              <div class="row">
                                    <input class="form-control basic-datepicker" placeholder="taluk" name="Taluk" type="text" value="<?=isset($shpData->taluk)?$shpData->taluk:''?>">														
                                </div> 
                            </div>

                        </div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="">

                            <label class="col-lg-5 col-md-3 control-label">Reg Id</label>
                            <div class="col-lg-7 col-md-9">
                              <div class="row">
                                    <input class="form-control basic-datepicker" placeholder="Reg Id" name="regid" type="text" value="<?=isset($shpData->reg_id)?$shpData->reg_id:''?>">														
                                </div> 
                            </div>
	
                        </div>
                       
                    </div>
                    <!-- End .row -->
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
								<input type="hidden" name="gid" value="<?=isset($shpData->gid)?$shpData->gid:''?>">
								<input type="hidden" name="data_id" value="<?=isset($data_id)?$data_id:''?>">
                                <button type="submit" value="search" name="search_reg" class="btn btn-success">Submit</button>
                                
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                </form>
				
				  </div>  </div>  </div>
@endsection
