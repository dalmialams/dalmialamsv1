 @include('admin.common.common_auditlog_modal')

<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->registration->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div>{!! Session::get('message')!!}</div>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <?php
    if ($mesages) {
        foreach ($mesages as $key => $value) {
            echo $value;
        }
    }
    ?>   

    <!-- Start .panel -->
    <?php if (isset($viewMode) && $viewMode == 'true') { ?>
        <div class="panel-heading">
            <h4 class="panel-title">Registration Details</h4>
        </div>
        <div class="panel panel-primary ">
            <!-- Start .panel -->
            <div class="panel-body">
                <table class="table  table-bordered">
                    <tbody>
                        <tr>
                            <td  class="text-center" width="30%"><strong>Unique Identification No</strong></td>
                            <td  class="text-center"><?= $reg_data['id'] ?></td>

                            <td  class="text-center"><strong>Legal Entity</strong></td>
                            <td  class="text-center">
                                <?php
                                $legal_entity = $reg_data['legal_entity'];
                                $legal_entity_name = App\Models\Common\CodeModel::where(['id' => "$legal_entity", 'cd_type' => 'legal_entity'])->value('cd_desc');
                                echo $legal_entity_name;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Purchase Type</strong></td>
                            <td  class="text-center">
                                <?php
                                $purchase_type = $reg_data['purchase_type_id'];
                                $purchase_type_name = App\Models\Common\CodeModel::where(['id' => "$purchase_type", 'cd_type' => 'purchase_type'])->value('cd_desc');
                                echo $purchase_type_name;
                                ?>
                            </td>

                            <td  class="text-center"><strong>Name of the Purchaser</strong></td>
                            <td  class="text-center"><?php
                                //$reg_data['purchaser']

                                $purchaser_name = $reg_data['purchaser'];
                                $purchaser_name = App\Models\Common\CodeModel::where(['id' => "$purchaser_name", 'cd_type' => 'purchaser_name'])->value('cd_desc');
                                echo $purchaser_name;
                                ?></td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Purchasing Team</strong></td>
                            <td  class="text-center">
                                <?php
                                $purchase_team = $reg_data['purchasing_team_id'];
                                $purchase_team_name = App\Models\Common\CodeModel::where(['id' => "$purchase_team", 'cd_type' => 'purchasing_team'])->value('cd_desc');
                                echo $purchase_team_name;
                                ?>
                            </td>

                            <td  class="text-center"><strong>Plot Type</strong></td>
                            <td  class="text-center">
                                <?php
                                $plot_type = $reg_data['plot_type_id'];
                                $plot_type_name = App\Models\Common\CodeModel::where(['id' => "$plot_type", 'cd_type' => 'plot_type'])->value('cd_desc');
                                echo $plot_type_name;
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Document Regn No</strong></td>
                            <td  class="text-center"><?= $reg_data['regn_no'] ?></td>

                            <td  class="text-center"><strong>Regn Date</strong></td>
                            <td  class="text-center"><?php echo (($reg_data['regn_date'])? date('d/m/Y',strtotime($reg_data['regn_date'])):''); ?></td>
							
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Sub Registrar Office</strong></td>
                            <td  class="text-center"><?php
                                $sub_registrar_code = $reg_data['sub_registrar'];
                                echo $sub_registrar_name = App\Models\Common\CodeModel::where(['id' => "$sub_registrar_code", 'cd_type' => 'sub_registrar_office'])->value('cd_desc');
                                ?></td>

                            <td  class="text-center"><strong>Name of Vendor</strong></td>
                            <td  class="text-center"><?= $reg_data['vendor'] ?></td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Purchased Area</strong></td>
                            <td  class="text-center">
                                <?php
                                $unit = $reg_data['tot_area_unit'];
                                $unit_name = App\Models\Common\CodeModel::where(['id' => "$unit", 'cd_type' => 'area_unit'])->value('cd_desc');
                                echo number_format($reg_data['tot_area'],4) . ' (' . $unit_name . ')';
                                ?> 
                            </td>

                            <td  class="text-center"><strong>Total Cost</strong></td>
                            <td  class="text-center" style="text-align: right;"><?= number_format($reg_data['tot_cost'],4) ?></td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>State</strong></td>
                            <td  class="text-center">
                                <?php
                                $state_id = trim($reg_data['state_id']);
                                echo $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name');
                                ?>
                            </td>

                            <td  class="text-center"><strong>District</strong></td>
                            <td  class="text-center">
                                <?php
                                $dist_id = trim($reg_data['district_id']);
                                echo $state_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Block/Taluk</strong></td>
                            <td  class="text-center">
                                <?php
                                $block_id = trim($reg_data['block_id']);
                                echo $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name');
                                ?>
                            </td>

                            <td  class="text-center"><strong>Village</strong></td>
                            <td  class="text-center">  <?php
                                $village_id = trim($reg_data['village_id']);
                                echo $village_name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name');
                                ?>

                            </td>
                        </tr>

                    </tbody>
                </table>
                <?php if ($viewMode) { ?>    
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
									<button type="button" class="btn btn-warning" onclick="get_log_details('<?=$reg_data['id']?>','T_REGISTRATION')">View Log</button>
									<a href="<?= url('land-details-entry/registration/list') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
									
                                </div>
                            </div>
                            <!-- End .row -->
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="panel-body">
            {!! Form::open(['url' => url('land-details-entry/registration/submit-data'),'class' => 'form-horizontal reg-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Unique ID No</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('reg_id', isset($reg_data['id']) ? $reg_data['id'] : '', array('class'=>'form-control','disabled' => '','placeholder' => 'Unique ID No')) }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Legal Entity</label>
                        <div class="col-lg-7 col-md-9">

                            {{Form::select('registration[legal_entity]', isset($legal_entry) ? $legal_entry : '', isset($reg_data['legal_entity']) ? $reg_data['legal_entity'] : '',array('class'=>'form-control select2-minimum required'))}}
                        </div>
                    </div>
                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Purchase Type</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('registration[purchase_type_id]', isset($purchase_type) ? $purchase_type : '', isset($reg_data['purchase_type_id']) ? $reg_data['purchase_type_id'] : '',array('class'=>'form-control select2-minimum required','onchange'=>'validateform($(this).find("option:selected").text())'))}}
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Name of the Purchaser</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('registration[purchaser]', isset($purchase) ? $purchase : '', isset($reg_data['purchaser']) ? $reg_data['purchaser'] : '',array('class'=>'form-control select2-minimum required','onchange'=>'validateform($(this).find("option:selected").text())'))}}
                        </div>
                    </div>

                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Purchasing Team</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('registration[purchasing_team_id]', isset($purchasing_team) ? $purchasing_team : '', isset($reg_data['purchasing_team_id']) ? $reg_data['purchasing_team_id'] : '',array('class'=>'form-control select2-minimum required'))}}
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label">Plot Type</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('registration[plot_type_id]', isset($plot_type) ? $plot_type : '', isset($reg_data['plot_type_id']) ? $reg_data['plot_type_id'] : '',array('class'=>'form-control select2-minimum required'))}}
                        </div>

                    </div>
                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Document Regn No</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('registration[regn_no]', isset($reg_data['regn_no']) ? $reg_data['regn_no'] : '', array('class'=>'form-control paymentValidate','placeholder' => 'Document Regn No')) }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Regn Date</label>
                        <div class="col-lg-7 col-md-9">
                            <div class="input-group paymentValidate">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                {{ Form::text('registration[regn_date]', isset($reg_data['regn_date']) ? date('d/m/Y',strtotime($reg_data['regn_date'])) : '', array('class'=>'form-control required','placeholder' => 'Date','id'=>'basic-datepicker')) }}
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Sub Registrar Office</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('registration[sub_registrar]', isset($sub_registrar_office) ? $sub_registrar_office : '', isset($reg_data['sub_registrar']) ? $reg_data['sub_registrar'] : '',array('class'=>'form-control select2-minimum required'))}}

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Name of Vendor</label>
                        <div class="col-lg-7 col-md-9">
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
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Purchased Area</label>
                        <div class="col-lg-7 col-md-9">
                            <div class="row" style="margin-left:0px;">
                                <div class="col-sm-6 form-group">
                                    {{Form::select('registration[tot_area_unit]', isset($area_units) ? $area_units : '', isset($reg_data['tot_area_unit']) ? $reg_data['tot_area_unit'] : '',array('class'=>'form-control select2-minimum required'))}}
                                </div>
                                <div class="col-sm-6 form-group" style="margin-left:30px;">
                                    {{ Form::text('registration[tot_area]', isset($reg_data['tot_area']) ? number_format($reg_data['tot_area'], 4) : '', array('class'=>'form-control required ','placeholder' => '','style'=>'text-align:right')) }}
                                </div>															
                            </div>															

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Total Cost</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('registration[tot_cost]', isset($reg_data['tot_cost']) ? $reg_data['tot_cost'] : '', array('class'=>'form-control required numbers_only_restrict','placeholder' => 'Total Cost','style'=>'text-align:right')) }}

                        </div>
                    </div>
                </div>
                <!-- End .row -->

            </div>



            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('registration[state_id]', isset($states) ?$states : '' , isset($reg_data['state_id']) ? $reg_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))}}
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                        <label class="col-lg-5 col-md-3 control-label">District</label>
                        <div class="col-lg-7 col-md-9">                       
                            {{Form::select('registration[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($reg_data['district_id']) ? $reg_data['district_id'] : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))}}
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

                            {{Form::select('registration[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($reg_data['block_id']) ? $reg_data['block_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                        <label class="col-lg-5 col-md-3 control-label">Village</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('registration[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($reg_data['village_id']) ? $reg_data['village_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => ''))}}
                        </div>
                    </div>

                </div>

            </div>
            <!-- End .row -->
            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($reg_uniq_no) ? $reg_uniq_no : '' ?>">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <?php if ($registration_converted_flag != 'Y') { ?>
                                <button type="submit" value="save" name="save_reg" class="btn btn-success">Save</button>
                                <button type="submit" value="save_continue" name="save_reg" class="btn btn-primary">Save & Continue</button>
                                <?php
                                if (isset($reg_uniq_no) && !empty($reg_uniq_no)) {
                                    if ($user_type !== 'admin') {
                                        if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('survey_no_details_add', $current_user_id)) {
                                            $skip_url = url('land-details-entry/survey/add?reg_uniq_no=' . $reg_uniq_no);
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('document_upload_add', $current_user_id)) {
                                            $skip_url = url('land-details-entry/document/add?reg_uniq_no=' . $reg_uniq_no);
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('payment_details_add', $current_user_id)) {
                                            $skip_url = url('land-details-entry/payment/add?reg_uniq_no=' . $reg_uniq_no);
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('lease_details_add', $current_user_id)) {
                                            if (isset($purchase_type_id) && $purchase_type_id == 'CD00144') {
                                                $skip_url = url('land-details-entry/lease/add?reg_uniq_no=' . $reg_uniq_no);
                                            } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('geo_tag_add', $current_user_id)) {
                                                $skip_url = url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no);
                                            } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('transaction_details_access', $current_user_id)) {
                                                $skip_url = url('land-details-entry/registration/transaction-details?reg_uniq_no=' . $reg_uniq_no);
                                            } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('audit_details_access', $current_user_id)) {
                                                $skip_url = url('land-details-entry/registration/audit-details?reg_uniq_no=' . $reg_uniq_no);
                                            } else {
                                                $skip_url = '';
                                            }
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('geo_tag_add', $current_user_id)) {
                                            $skip_url = url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no);
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('transaction_details_access', $current_user_id)) {
                                            $skip_url = url('land-details-entry/registration/transaction-details?reg_uniq_no=' . $reg_uniq_no);
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('audit_details_access', $current_user_id)) {
                                            $skip_url = url('land-details-entry/registration/audit-details?reg_uniq_no=' . $reg_uniq_no);
                                        } else {
                                            $skip_url = '';
                                        }
                                    } else {
                                        //return redirect('land-details-entry/survey/add?reg_uniq_no=' . $id)->with('message', $msg);
                                        $skip_url = url('land-details-entry/survey/add?reg_uniq_no=' . $reg_uniq_no);
                                    }
                                    if ($skip_url) {
                                        ?>
                                        <a href="<?= $skip_url ?>"><button type="button" class="btn btn-warning">Skip</button></a>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-warning disabled">Skip</button>
                                    <?php } ?>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-warning disabled">Skip</button>
                                <?php } ?>
                            <?php } ?>
                            <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- End .form-group  -->
    <?php } ?>

    <!-- End .form-group  -->

</div>
<!--                        <button type="submit" class="btn btn-primary">Save</button>
<?php if (isset($id) && $id) { ?>
                                                                                                                           <a href="<?= url('land-details-entry/survey/add?reg_uniq_no=' . $id) ?>"><button type="button" class="btn btn-primary">Continue</button></a>-->
<?php } ?>
