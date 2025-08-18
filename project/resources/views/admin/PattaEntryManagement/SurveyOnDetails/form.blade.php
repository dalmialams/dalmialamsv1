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
                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Survey No</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('survey[survey_no]', isset($survey_data['survey_no']) ? $survey_data['survey_no'] : '', array('class'=>'form-control required','placeholder' => 'Survey No')) }}
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Total Area</label>
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
                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Purchased Area</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('survey[purchased_area]', isset($survey_data['purchased_area']) ? $survey_data['purchased_area'] : '', array('class'=>'form-control required numbers_only_restrict check_calculation','placeholder' => 'Purchased Area','id'=>'purchased_area','style'=>'text-align:right;')) }}
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

                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Classification</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('survey[classification]', isset($plot_classification) ?$plot_classification : '' , isset($survey_data['classification']) ? $survey_data['classification'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populatesubclassification($(this).val())'))}}
                            </div>

                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group subclassificationList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Sub Classification</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('survey[sub_classification]', isset($sub_classinfo) ? $sub_classinfo : array('' => 'Select') , isset($survey_data['sub_classification']) ? $survey_data['sub_classification'] : '',array('class'=>'form-control select2-minimum required'))}}
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
                            <label class="col-lg-5 col-md-3 control-label" style="color: #db5565" id='total_area_in_level'><?= $reg_data['tot_area']; ?></label>
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
                                <button type="submit" value="save" name="submit_survey" class="btn btn-success">Save</button>
                                <button type="submit" value="save_continue" name="submit_survey" class="btn btn-primary">Save & Continue</button>
                                <?php if (count($surveyLists) > 0) { ?>
                                    <a href="<?= url('land-details-entry/document/add?reg_uniq_no=' . $reg_uniq_no) ?>"><button type="button" class="btn btn-warning">Skip</button></a>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-warning disabled">Skip</button>
                                <?php } ?>
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
                        <th>Survey No</th>
                        <th>Area Unit</th>
                        <th>Area</th>
                        <th>Purchased Area</th>
                        <th>Classification</th>                           
                        <th>Sub Classification</th>                           
                        <th>Purpose</th>
                        <?php if (!$viewMode) { ?><th></th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($surveyLists) {
                        $cumilativeTotalArea = '';
                        $cumilativePurchaseArea = '';
                        foreach ($surveyLists as $key => $value) {
                            ?>
                            <tr>
                                <td><?= $value['survey_no'] ?></td>
                                <td>
                                    <?php
                                    $area_unit = trim($value['area_unit']);
                                    echo $area_unit_name = App\Models\Common\CodeModel::where(['id' => "$area_unit"])->value('cd_desc');
                                    ?>
                                </td>
                                <td style="text-align: right;" class="all_total_area"><?php
                                    $cumilativeTotalArea = $cumilativeTotalArea + $value['total_area'];
                                    echo $value['total_area']
                                    ?></td>
                                <td style="text-align: right;" class="all_total_area"><?php
                                    $cumilativePurchaseArea = $cumilativePurchaseArea + $value['purchased_area'];
                                    echo $value['purchased_area']
                                    ?></td>
                                <td>
                                    <?php
                                    $classification = trim($value['classification']);
                                    echo $classification_name = App\Models\Common\CodeModel::where(['id' => "$classification"])->value('cd_desc');
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $sub_classification = trim($value['sub_classification']);
                                    echo $sub_classification_name = App\Models\Common\SubClassificationModel::where(['id' => "$sub_classification"])->value('sub_name');
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $purpose = trim($value['purpose']);
                                    echo $purpose_name = App\Models\Common\CodeModel::where(['id' => "$purpose"])->value('cd_desc');
                                    ?>
                                </td>
                                <?php if (!$viewMode) { ?>
                                    <td>
                                        <div class="action-buttons">
                                            <a title="Edit" href="<?= url('land-details-entry/survey/add?reg_uniq_no=' . $reg_uniq_no . '&survey_no=' . $value['id']); ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>&nbsp;&nbsp;
                                            <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $reg_uniq_no ?>', '<?= $value['id'] ?>');">
                                                <i class="ace-icon fa fa-times bigger-130"></i>
                                            </a>
                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
                <thead>
                    <tr>
                        <th>Total</th>
                        <th></th>
                        <th class="text-right all_total_area"><?= $cumilativeTotalArea ?></th>
                        <!--<th>Unit</th>-->
                        <th class="text-right all_total_cost"><?= $cumilativePurchaseArea ?></th>
                        <th></th>                           
                        <th></th>
                        <th></th>
                        <?php if (!$viewMode) { ?><th></th><?php } ?>
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



<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->
{{-- $validator --}}