<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-body">
        {!! Form::open(['url' => url('land-details-entry/registration/submit-data'),'class' => 'form-horizontal reg-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Unique Identification No</label>
                    <div class="col-lg-10 col-md-9">
                        {{ Form::text('id', isset($reg_data['id']) ? $reg_data['id'] : '', array('class'=>'form-control','disabled' => '','placeholder' => 'Unique Identification No')) }}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Legal Entity</label>
                    <div class="col-lg-10 col-md-9">
                        {{ Form::text('registration[legal_entity]', isset($reg_data['legal_entity']) ? $reg_data['legal_entity'] : '', array('class'=>'form-control required','placeholder' => 'Legal Entity')) }}
                    </div>
                </div>
            </div>
            <!-- End .row -->

        </div>

        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-2 col-md-3 control-label">Purchase Type</label>
                    <div class="col-lg-10 col-md-9">
                        {{Form::select('registration[purchase_type_id]', array('' => 'Select','1' => 'Outright Purchase', '2' => 'Lease'), isset($reg_data['purchase_type_id']) ? $reg_data['purchase_type_id'] : '',array('class'=>'form-control select2-minimum required'))}}
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Document Regn No</label>
                    <div class="col-lg-10 col-md-9">
                        {{ Form::text('registration[regn_no]', isset($reg_data['regn_no']) ? $reg_data['regn_no'] : '', array('class'=>'form-control required','placeholder' => 'Document Regn No')) }}
                    </div>
                </div>
            </div>
            <!-- End .row -->
        </div>

        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Sub & Registrar Office</label>
                    <div class="col-lg-10 col-md-9">
                        {{ Form::text('registration[sub_registrar]', isset($reg_data['sub_registrar']) ? $reg_data['sub_registrar'] : '', array('class'=>'form-control required','placeholder' => 'Sub – Registrar Office')) }}

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Name of Vendor</label>
                    <div class="col-lg-10 col-md-9">
                        {{ Form::text('registration[vendor]', isset($reg_data['vendor']) ? $reg_data['vendor'] : '', array('class'=>'form-control required','placeholder' => 'Name of Vendor')) }}

                    </div>
                </div>
            </div>
            <!-- End .row -->

        </div>
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Total Area</label>
                    <div class="col-lg-10 col-md-9">
                        <div class="col-sm-6">
                            {{Form::select('registration[tot_area_unit]', isset($area_units) ? $area_units : '', isset($reg_data['tot_area_unit']) ? $reg_data['tot_area_unit'] : '',array('class'=>'form-control select2-minimum required'))}}
                        </div>
                        <div class="col-sm-6">
                            {{ Form::text('registration[tot_area]', isset($reg_data['tot_area']) ? $reg_data['tot_area'] : '', array('class'=>'form-control required','placeholder' => '')) }}
                        </div>															

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Total Cost</label>
                    <div class="col-lg-10 col-md-9">
                        {{ Form::text('registration[tot_cost]', isset($reg_data['tot_cost']) ? $reg_data['tot_cost'] : '', array('class'=>'form-control required','placeholder' => 'Total Cost')) }}

                    </div>
                </div>
            </div>
            <!-- End .row -->

        </div>

        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-2 col-md-3 control-label">State</label>
                    <div class="col-lg-10 col-md-9">
                        {{Form::select('registration[state_id]', isset($states) ?$states : '' , isset($reg_data['state_id']) ? $reg_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))}}
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                    <label class="col-lg-2 col-md-3 control-label">District</label>
                    <div class="col-lg-10 col-md-9">
                        {{--Form::select('registration[district_id]', array('AK' => 'Alaska', 'HI' => 'Hawaii'), isset($reg_data['district_id']) ? $reg_data['district_id'] : '',array('class'=>'form-control select2-minimum'))--}}

                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>

        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group block-list">

                    <label class="col-lg-2 col-md-3 control-label">Taluk</label>
                    <div class="col-lg-10 col-md-9">
                        

                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-2 col-md-3 control-label">Village</label>
                    <div class="col-lg-10 col-md-9">
                        {{--Form::select('registration[village_id]', array('AK' => 'Alaska', 'HI' => 'Hawaii'), isset($reg_data['village_id']) ? $reg_data['village_id'] : '',array('class'=>'form-control select2-minimum'))--}}

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

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                        <button type="submit" class="btn btn-default">Save form</button>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        {!! Form::close() !!}
    </div>
</div>