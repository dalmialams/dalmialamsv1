<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->patta->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div><?php echo Session::get('message'); ?></div>
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
            <h4 class="panel-title">Patta Details</h4>
        </div>
        <div class="panel panel-primary ">
            <!-- Start .panel -->
            <div class="panel-body">
                <table class="table  table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-center" width="30%"><strong>Unique Identification No</strong></td>
                            <td  class="text-center"><?= isset($patta_data['id']) ? $patta_data['id'] : '' ?></td>
                            <td  class="text-center"><strong>State</strong></td>
                            <td  class="text-center">
                                <?php
                                $state_id = trim(isset($patta_data['state_id']) ? $patta_data['state_id'] : '');
                                echo $state_id ? $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name') : '';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>District</strong></td>
                            <td  class="text-center">
                                <?php
                                $dist_id = trim(isset($patta_data['district_id']) ? $patta_data['district_id'] : '');
                                echo ($dist_id) ? $dist_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name') : '';
                                ?>
                            </td>

                            <td  class="text-center"><strong>Block/Taluk</strong></td>
                            <td  class="text-center">
                                <?php
                                $block_id = trim(isset($patta_data['block_id']) ? $patta_data['block_id'] : '');
                                echo ($block_id) ? $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name') : '';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Village</strong></td>
                            <td  class="text-center">  <?php
                                $village_id = trim(isset($patta_data['village_id']) ? $patta_data['village_id'] : '');
                                echo ($village_id) ? $village_name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name') : '';
                                ?>
                            </td>
                            <td  class="text-center"><strong>Patta no</strong></td>
                            <td  class="text-center"><?= isset($patta_data['patta_no']) ?$patta_data['patta_no'] : '' ?>

                            </td>
                            
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Patta owner</strong></td>
                            <td  class="text-center"><?= isset($patta_data['patta_owner']) ? $patta_data['patta_owner'] : '' ?>
                            </td>
                            <td  class="text-center"><strong></strong></td>
                            <td  class="text-center">
                                <?php
//                                if (isset($survey_info) && !empty($survey_info)) {
//                                    $selected_survey_id = explode(',', $patta_data['survey_id']);
//                                    foreach ($selected_survey_id as $surval) {
//                                        $survey_id = trim($surval);
//                                        $allSurvey_name[] = ($survey_id) ? $survey_name = App\Models\LandDetailsManagement\SurveyModel::where(['id' => "$survey_id"])->value('survey_no') : '';
//                                    }
//                                    echo implode(', ', $allSurvey_name);
//                                }
                                ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
                </br></br></br>
                <div class="col-lg-12 survey_id">
                    <?php
                    if (isset($survey_info) && !empty($survey_info)) {
                        $selected_survey_id = explode(',', $patta_data['survey_id']);
                        //  t($selected_survey_id,1);
                        ?>
                        <div class="row">
                            <!-- Start .row -->
                            <div class="panel panel-default">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"><i class="fa fa-list-alt"></i> Selected Survey No. </h4>
                                </div>
                                <div class="panel-body pt0 pb0">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <select multiple="multiple" name="view_survey_name[]" size="10"  class="viewdualllistbox">
                                                <optgroup>
                                                    <?php
                                                    unset($survey_info['']);
                                                    foreach ($survey_info as $key => $value) {
                                                        ?>
                                                        <option <?= in_array($key, $selected_survey_id) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- End .row -->
                </div>
                
                <?php if ($viewMode) { ?>    
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    <a href="<?= url('land-details-entry/patta/list') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
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
            <?php echo Form::open(['url' => url('land-details-entry/patta/submit-data'),'class' => 'form-horizontal patta-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Patta ID No</label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::text('patta_id', isset($patta_data['patta_id']) ? $patta_data['patta_id'] : '', array('class'=>'form-control','disabled' => '','placeholder' => 'Patta ID No'))); ?>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::select('patta[state_id]', isset($states) ?$states : '' , isset($patta_data['state_id']) ? $patta_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))); ?>

                        </div>

                    </div>
                </div>
                <!-- End .row -->

            </div>


            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                        <label class="col-lg-5 col-md-3 control-label">District</label>
                        <div class="col-lg-7 col-md-9">                       
                            <?php echo e(Form::select('patta[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($patta_data['district_id']) ? $patta_data['district_id'] : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))); ?>

                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group block-list">
                        <label class="col-lg-5 col-md-3 control-label">Block/Taluk</label>
                        <div class="col-lg-7 col-md-9">  

                            <?php echo e(Form::select('patta[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($patta_data['block_id']) ? $patta_data['block_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))); ?>

                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                        <label class="col-lg-5 col-md-3 control-label">Village</label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::select('patta[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($patta_data['village_id']) ? $patta_data['village_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateSurvey("",$(this).val())'))); ?>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Patta no.</label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::text('patta[patta_no]', isset($patta_data['patta_no']) ? $patta_data['patta_no'] : '', array('class'=>'form-control required','placeholder' => 'Patta no.'))); ?>

                        </div>
                    </div>

                </div>

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Patta owner</label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::text('patta[patta_owner]', isset($patta_data['patta_owner']) ? $patta_data['patta_owner'] : '', array('class'=>'form-control required','placeholder' => 'Patta owner'))); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 survey_id">
                <?php
                if (isset($survey_info) && !empty($survey_info)) {
                    $selected_survey_id = explode(',', $patta_data['survey_id']);
                    //  t($selected_survey_id,1);
                    ?>
                    <div class="row">
                        <!-- Start .row -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-heading">
                                <h4 class="panel-title"><i class="fa fa-list-alt"></i> Survey No. Selection</h4>
                            </div>
                            <div class="panel-body pt0 pb0">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <select multiple="multiple" name="survey_id[]" size="10"  class="duallistbox">
                                            <optgroup>
                                                <?php
                                                unset($survey_info['']);
                                                foreach ($survey_info as $key => $value) {
                                                    ?>
                                                    <option <?= in_array($key, $selected_survey_id) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                                                <?php } ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <!-- End .form-group  -->
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End .row -->
            </div>
            <!-- End .row -->
            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($patta_uniq_no) ? $patta_uniq_no : '' ?>">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">

                            <button type="submit" value="save" name="save_patta" class="btn btn-success">Save</button>                          
                            <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
        <!-- End .form-group  -->
    <?php } ?>

    <!-- End .form-group  -->

</div>
