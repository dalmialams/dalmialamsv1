
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
                {!! Form::open(['url' => url('land-details-entry/registration/list'),'class' => 'form-horizontal reg-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

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
                                <button type="submit" value="search" name="search_reg" class="btn btn-success">Search</button>
                                <a href="<?= url('land-details-entry/registration/list') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
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


        <?php if ($dataPresent == 'yes') { ?>
            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Search Result</h4>
                </div>
                <div class="panel-body">
                    <table id="registration_lists_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Unique ID No</th>
                                <th class="hide">Legal Entity</th>
                                <th class="hide">Purchase Type</th>
                                <th class="hide">Name of the Purchaser</th>
                                <th>Regn No.</th>
                                <th class="hide">Regn Date</th>
                                <th class="hide">Sub Registrar Office</th>
                                <th class="hide">Name of Vendor</th>
                                <th class="hide">Purchased Area</th>
                                <!--<th class="hide">Unit</th>-->
                                <th class="hide">Cost</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Taluk</th>                           
                                <th>Village</th>
                                <th>Purchased Area (Acre)</th>
                                <!--<th>Unit</th>-->
                                <th>Cost</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
							
                            <?php
                            if ($registration) {
                                $cumilativeTitalArea = 0;
                                $cumilativeTitalCost = 0;
                                foreach ($registration as $key => $value) {
                                    $tot_area_unit = $value['tot_area_unit'];
                                    $tot_area_unit_value = App\Models\Common\ConversionModel::where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->value('convers_value_acer');
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('registration_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>
                                                <a href="<?= url('land-details-entry/registration/view?reg_uniq_no=' . $value['id'] . '&view=true'); ?>" ><?= $value['id'] ?></a>
                                                <?php
                                            } else {
                                                echo $value['id'];
                                            }
                                            ?>
                                        </td>
                                        <td class="hide"><?php
                                            $legal_entity = $value['legal_entity'];
                                            $legal_entity_name = App\Models\Common\CodeModel::where(['id' => "$legal_entity", 'cd_type' => 'legal_entity'])->value('cd_desc');
                                            echo $legal_entity_name;
                                            ?>
                                        </td>
                                        <td class="hide"><?php
                                            $purchase_type_id = $value['purchase_type_id'];
                                            $purchase_type_id_name = App\Models\Common\CodeModel::where(['id' => "$purchase_type_id", 'cd_type' => 'purchase_type'])->value('cd_desc');
                                            echo $purchase_type_id_name;
                                            ?>
                                        </td>
                                        <td class="hide"><?php
                                            $purchaser_name = $value['purchaser'];
                                            $purchaser_name = App\Models\Common\CodeModel::where(['id' => "$purchaser_name", 'cd_type' => 'purchaser_name'])->value('cd_desc');
                                            echo $purchaser_name;
                                            //$value['purchaser'] 
                                            ?></td>
                                        <td><?= $value['regn_no'] ?></td>
                                        <td class="hide"><?= $value['regn_date'] ?></td>
                                        <td class="hide"><?= $value['sub_registrar'] ?></td>
                                        <td class="hide"><?= $value['vendor'] ?></td>
                                        <td class="hide"><?= $value['tot_area']; ?></td>
            <!--                                    <td class="hide">
                                        <?php
//                                        $unit1 = $value['tot_area_unit'];
//                                        $unit_name1 = App\Models\Common\CodeModel::where(['id' => "$unit1", 'cd_type' => 'area_unit'])->value('cd_desc');
//                                        echo $unit_name1;
                                        ?>
                                        </td>-->
                                        <td class="hide"><?= round($value['tot_cost']) ?></td>
                                        <td><?php
                                            $state_id = trim($value['state_id']);
                                            echo $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name');
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $dist_id = trim($value['district_id']);
                                            echo $state_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name');
                                            ?>
                                        </td>
                                        <td> <?php
                                            $block_id = trim($value['block_id']);
                                            echo $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name');
                                            ?></td>
                                        <td><?php
                                            $village_id = trim($value['village_id']);
                                            echo $vllage_name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name');
                                            ?></td>
                                        <td style="text-align: right;" class="all_total_area"><?php
                                            //$valueToDisplay = $value['tot_area'] * $tot_area_unit_value;
                                            $temp=$value['tot_area'];
                                            if($value['tot_area_unit']=='CD00094'){
                                                $temp=$value['tot_area'];
                                            }
                                            else{
                                                $temp=round(($value['tot_area']*2.471),4);
                                            }
                                            $valueToDisplay = $temp;
                                            $cumilativeTitalArea = $cumilativeTitalArea + $valueToDisplay;
                                            echo $valueToDisplay;
                                            ?></td>
            <!--                                    <td>
                                        <?php
                                        //$unit = $value['tot_area_unit'];
                                        //$unit_name = App\Models\Common\CodeModel::where(['id' => "$unit", 'cd_type' => 'area_unit'])->value('cd_desc');
                                        //echo $unit_name;
                                        ?>
                                        </td>-->
                                        <td style="text-align: right;" class="all_total_cost"><?php
										   //$cumilativeTitalCost=0;
                                            $cumilativeTitalCost = $cumilativeTitalCost + $value['tot_cost'];
                                            echo $value['tot_cost'];
											//echo $current_user_id;
                                            ?></td>
                                        <td>
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('registration_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
												
                                                ?>
                                                <div class="action-buttons">
                                                    <a title="Edit" href="<?= url('land-details-entry/registration/edit?reg_uniq_no=' . $value['id']) ?>">
                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>
                                                </div>
                                                <?php
                                            } else {
                                                echo '';
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                        <thead>
                            <tr>
                                <th>Total</th>
                                <th class="hide"></th>
                                <th class="hide"></th>
                                <th class="hide"></th>
                                <th></th>
                                <th class="hide"></th>
                                <th class="hide"></th>
                                <th class="hide"></th>
                                <th class="hide"></th>
                                <!--<th class="hide">Unit</th>-->
                                <th class="hide"></th>
                                <th></th>
                                <th></th>
                                <th></th>                           
                                <th></th>
                                <th class="text-right all_total_area"><?= isset($cumilativeTitalArea) ? $cumilativeTitalArea : '' ?></th>
                                <!--<th>Unit</th>-->
                                <th class="text-right all_total_cost"><?= isset($cumilativeTitalCost) ? $cumilativeTitalCost : '' ?></th>
                                <th></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        <?php } ?>
        <!-- End .panel -->
    </div>
</div>


@endsection
