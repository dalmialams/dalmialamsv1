<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->survey->all();
}
?>
<div>{!! Session::get('message')!!}</div>
<?php if (!$viewMode) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <?php
        if ($mesages) {
            foreach ($mesages as $key => $value) {
                echo $value;
            }
        }
        ?>   
        <!-- Start .panel -->
        <div class="panel-body">
            <?php if ($reg_uniq_no) { ?>
                {!! Form::open(['url' => url('land-details-entry/survey/submit-data'),'class' => 'form-horizontal survey-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Survey No</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('survey[survey_no]', isset($survey_data['survey_no']) ? $survey_data['survey_no'] : '', array('class'=>'form-control required','placeholder' => 'Survey No')) }}
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Total Extent</label>
                            <div class="col-lg-7 col-md-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        {{Form::select('survey[area_unit]', isset($area_units) ?$area_units : '' , isset($survey_data['area_unit']) ? $survey_data['area_unit'] : '',array('class'=>'form-control select2-minimum required'))}}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::text('survey[total_area]', isset($survey_data['total_area']) ? $survey_data['total_area'] : '', array('class'=>'form-control required numbers_only_restrict check_calculation','placeholder' => 'Total Area','id'=>'total_area','style'=>'text-align:right;')) }}
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">
                    <div class="row">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Total Purchased Area</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('survey[purchased_area]', isset($survey_data['purchased_area']) ? round($survey_data['purchased_area'],2) : '', array('class'=>'form-control required numbers_only_restrict check_calculation','placeholder' => 'Purchased Area','id'=>'purchased_area','style'=>'text-align:right;')) }}
                                <div id="purchase_area_msg" style="color: #db5565;font-size: 13px;font-weight: normal;"></div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Purpose</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('survey[purpose]', isset($land_usage) ?$land_usage : '' , isset($survey_data['purpose']) ? $survey_data['purpose'] : '',array('class'=>'form-control select2-minimum required'))}}
                            </div>
                        </div>

                    </div>
                    <!-- End .row -->
                </div>
                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="classificationList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Classification</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('survey[classification]', isset($plot_classification) ?$plot_classification : '' , isset($survey_data['classification']) ? $survey_data['classification'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populatesubclassification($(this).val())'))}}
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group subclassificationList">

                            <label class="col-lg-5 col-md-3 control-label">Sub Classification</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('survey[sub_classification]', isset($sub_classinfo) ? $sub_classinfo : array('' => 'Select') , isset($survey_data['sub_classification']) ? $survey_data['sub_classification'] : '',array('class'=>'form-control select2-minimum'))}}
                            </div>

                        </div>
                    </div>
                    <!-- End .row -->

                </div>
                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label" style="color: #db5565">Total Purchased Area</label>
                            <label class="col-lg-5 col-md-3 control-label" style="color: #db5565" id='total_area_in_level'><?= round($reg_data['tot_area'],2); ?></label>
                        </div>

                    </div>
                    <!-- End .row -->

                </div>


                <!-- End .form-group  -->

                <!-- End .form-group  -->
                <input type="hidden" name="survey_no" value="<?= isset($survey_no) ? $survey_no : '' ?>">
                <input type="hidden" name="survey[registration_id]" value="<?= isset($reg_uniq_no) ? $reg_uniq_no : '' ?>">
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php if ($registration_converted_flag != 'Y') { ?>
                                <button type="submit" value="save" name="submit_survey" class="btn btn-success">Save</button>
                                <button type="submit" value="save_continue" name="submit_survey" class="btn btn-primary">Save & Continue</button>
                                <?php
                                if (count($surveyLists) > 0) {
                                    if ($user_type !== 'admin') {
                                        if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('document_upload_add', $current_user_id)) {
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
                                        $skip_url = url('land-details-entry/document/add?reg_uniq_no=' . $reg_uniq_no);
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
                                <?php }?>
                                <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                <!-- End .form-group  -->
                {!! Form::close() !!}

            <?php } else { ?>
                <div class="alert alert-warning fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="glyphicon glyphicon-warning-sign alert-icon "></i>
                    <strong>Warning!</strong> Please select a proper Registration to add this details.
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php if ($surveyLists) { ?>

    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Survey List</h4>
        </div>
        <div class="panel-body">
            <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Survey No</th>
                        <th  class="text-center">Area Unit</th>
                        <th  class="text-center">Extend</th>
                        <th  class="text-center">Total Purchased Area</th>
                        <th  class="text-center">Classification</th>                           
                        <th  class="text-center">Sub Classification</th>                           
                        <th  class="text-center">Purpose</th>
						<th  class="text-center"></th>
                        <?php if (!$viewMode) { ?><th  class="text-center"></th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($surveyLists) {
                     /*   $cumilativeTotalArea = '';
                        $cumilativePurchaseArea = '';*/
						 $cumilativeTotalArea = 0;
                        $cumilativePurchaseArea = 0;
                        foreach ($surveyLists as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><?= $value['survey_no'] ?></td>
                                <td  class="text-center">
                                    <?php
                                    $area_unit = trim($value['area_unit']);
                                    echo $area_unit_name = App\Models\Common\CodeModel::where(['id' => "$area_unit"])->value('cd_desc');
                                    ?>
                                </td>
                                <td style="text-align: right;" class="all_total_area"><?php
                                    $cumilativeTotalArea = $cumilativeTotalArea + $value['total_area'];
                                    echo number_format($value['total_area'], 4, '.', '');
                                    ?></td>
                                <td style="text-align: right;" class="all_total_area"><?php
                                    $cumilativePurchaseArea = $cumilativePurchaseArea + $value['purchased_area'];
                                    echo number_format($value['purchased_area'], 4, '.', '');

                                    ?></td>
                                <td  class="text-center">
                                    <?php
                                    $classification = trim($value['classification']);
                                    echo $classification_name = App\Models\Common\CodeModel::where(['id' => "$classification"])->value('cd_desc');
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    $sub_classification = trim($value['sub_classification']);
                                    echo $sub_classification_name = App\Models\Common\SubClassificationModel::where(['id' => "$sub_classification"])->value('sub_name');
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    $purpose = trim($value['purpose']);
                                    echo $purpose_name = App\Models\Common\CodeModel::where(['id' => "$purpose"])->value('cd_desc');
                                    ?>
                                </td>
                                <?php if (!$viewMode) { ?>
                                    <td  class="text-center">
                                        <div class="action-buttons">                                          
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('survey_no_details_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>                                            
                                                <a title="Edit" href="<?= url('land-details-entry/survey/edit?reg_uniq_no=' . $reg_uniq_no . '&survey_no=' . $value['id']); ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                            &nbsp;&nbsp;
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('survey_no_details_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>   
                                                <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $reg_uniq_no ?>', '<?= $value['id'] ?>');">
                                                    <i class="ace-icon fa fa-times bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                <?php } ?>
								<td><button type="button" class="btn btn-warning" onclick="get_log_details('<?=$value['id']?>','T_SURVEY')">View Log</button></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
                <thead>
                    <tr>
                        <th  class="text-center">Total</th>
                        <th  class="text-center"></th>
                        <th class="text-right all_total_area"><?= $cumilativeTotalArea ?></th>
                        <!--<th  class="text-center">Unit</th>-->
                        <th class="text-right all_total_cost"><?= $cumilativePurchaseArea ?></th>
                        <th  class="text-center"></th>                           
                        <th  class="text-center"></th>
                        <th  class="text-center"></th>
						 <th  class="text-center"></th>
                        <?php if (!$viewMode) { ?><th  class="text-center"></th><?php } ?>
                    </tr>
                </thead>

            </table>

            <?php if ($viewMode) { ?>    
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <a href="<?= url('land-details-entry/registration/list') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
 @include('admin.common.common_auditlog_modal')
<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->
{{-- $validator --}}

