<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->converparentcompany->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div><?php echo Session::get('message'); ?></div>
<?php
if ($mesages) {

    foreach ($mesages as $key => $value) {
        echo $value;
    }
}
?>   
<?php if (!$viewMode) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <!-- Start .panel -->
        <div class="panel-body">
            <?php echo Form::open(['url' => url('transaction/conversion-parent-company/submit-data'),'class' => 'form-horizontal lease-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>



            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Name of the Purchaser</label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::select('conversionParCmp[purchaser]', isset($purchase) ? $purchase : '', isset($reg_data['purchaser']) ? $reg_data['purchaser'] : '',array('class'=>'form-control select2-minimum required','id'=>'purchaser_name','onchange' => 'populateRegistration()'))); ?>

                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Sub Registrar Office</label>
                        <div class="col-lg-7 col-md-9">                       
                            <?php echo e(Form::select('conversionParCmp[sub_registrar]', isset($sub_registrar_office) ? $sub_registrar_office : '', isset($reg_data['sub_registrar']) ? $reg_data['sub_registrar'] : '',array('class'=>'form-control select2-minimum required','id'=>'sub_registrar','onchange' => 'populateRegistration()'))); ?>

                        </div>

                    </div>

                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <!--                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Village</label>
                                            <div class="col-lg-7 col-md-9">
                                                <?php echo e(Form::select('conversionParCmp[village_id]', isset($villages) ? $villages : array('' => 'Select') , isset($mutation_data['village_id']) ? $mutation_data['village_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateRegistration()','id'=>'village_id'))); ?>

                                            </div>
                                        </div>-->

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group block-list">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Transfer to Legal Entity</label>
                        <div class="col-lg-7 col-md-9">  
                            <?php echo e(Form::select('conversionParCmp[legal_entity]', isset($legal_entry) ? $legal_entry : '', isset($reg_data['legal_entity']) ? $reg_data['legal_entity'] : '',array('class'=>'form-control select2-minimum required'))); ?>

                        </div>
                    </div>
                </div>
                <!-- End .row -->
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


            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($mutation_no) ? $mutation_no : '' ?>">

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" value="save" name="save_conversion_parent_company" class="btn btn-success disabled">Save</button>                           
                            <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>

    </div>
<?php } ?>
<?php if (isset($parentLists) && !empty($parentLists)) { ?>
    <div class="panel panel-primary">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title">Conversion to Parent Company List</h4>
        </div>
        <div class="panel-body">
            <table id="cnv_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Unique ID No</th>

                        <th>Regn No.</th>

                        <th>State</th>
                        <th>District</th>
                        <th>Taluk</th>                           
                        <th>Village</th>
                        <th>Purchased Area</th>

                        <th>Cost</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    if ($parentLists) {
                        $cumilativeTitalArea = '';
                        $cumilativeTitalCost = '';
                        foreach ($parentLists as $key => $value) {
                            $tot_area_unit = $value['tot_area_unit'];
                            $tot_area_unit_value = App\Models\Common\ConversionModel::where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->value('convers_value_acer');
                            ?>
                            <tr>
                                <td><?= $value['id'] ?></td>

                                <td><?= $value['regn_no'] ?></td>

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
                                    $valueToDisplay = $value['tot_area'];
                                    $cumilativeTitalArea = $cumilativeTitalArea + $valueToDisplay;
                                    echo $valueToDisplay;
                                    ?></td>

                                <td style="text-align: right;" class="all_total_cost"><?php
                                    $cumilativeTitalCost = $cumilativeTitalCost + $value['tot_cost'];
                                    echo $value['tot_cost'];
                                    ?></td>
                                <td><div class="action-buttons">
                                        <?php
                                        if ($user_type == 'admin' || ((\App\Models\UtilityModel::ifHasPermission('conversion_to_parent_company_edit', $current_user_id) ) && (\App\Models\UtilityModel::ifHasPermission('registration_edit', $current_user_id) ))) {
                                            ?> 
                                            <a title="Edit" href="<?= url('land-details-entry/registration/edit?reg_uniq_no=' . $value['id']) ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>
                                        <?php } ?>
                                    </div>
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

