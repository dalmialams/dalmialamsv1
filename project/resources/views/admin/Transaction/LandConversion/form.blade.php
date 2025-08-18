<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->land_conversion->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div>{!! Session::get('message')!!}</div>
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
            {!! Form::open(['url' => url('transaction/land-conversion/submit-data'),'class' => 'form-horizontal lease-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}


            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Transaction Type</label>
                        <?php
                        $trxn_type = isset($land_conversion_data['trxn_type']) ? $land_conversion_data['trxn_type'] : '';
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('', isset($type) ?$type : '' , $trxn_type ,array('class'=>'form-control select2-minimum required trxn_type','disabled' => true))}}
                                <input type="hidden" name="land_conversion[trxn_type]" value="<?= $trxn_type ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('land_conversion[trxn_type]', isset($type) ?$type : '' , $trxn_type ,array('class'=>'form-control select2-minimum required trxn_type','onchange' => 'if ($("#village_id").val()) {populateSurvey("",$("#village_id").val()) }'))}}
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                        <?php
                        $state_id = isset($land_conversion_data['state_id']) ? $land_conversion_data['state_id'] : '';
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('', isset($states) ?$states : '' , $state_id ,array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())','disabled' => true))}}
                                <input type="hidden" name="land_conversion[state_id]" value="<?= $state_id ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('land_conversion[state_id]', isset($states) ?$states : '' , $state_id ,array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))}}
                            </div>
                        <?php } ?>
                    </div>


                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>District</label>
                        <?php
                        $district_id = isset($land_conversion_data['district_id']) ? $land_conversion_data['district_id'] : '';
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('', isset($district_info) ?$district_info : array('' => 'Select') , $district_id ,array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())','disabled' => true))}}
                                <input type="hidden" name="land_conversion[district_id]" value="<?= $district_id ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">                       
                                {{Form::select('land_conversion[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , $district_id ,array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))}}
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group block-list">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Block/Taluk</label>
                        <?php
                        $block_id = isset($land_conversion_data['block_id']) ? $land_conversion_data['block_id'] : '';
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">  
                                {{Form::select('', isset($block_info) ?$block_info : array('' => 'Select') , $block_id,array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())','disabled' => true))}}
                                <input type="hidden" name="land_conversion[block_id]" value="<?= $block_id ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">  
                                {{Form::select('land_conversion[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , $block_id ,array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))}}
                            </div>
                        <?php } ?>
                    </div>


                </div>
                <!-- End .row -->
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Village</label>
                        <?php
                        $village_id = isset($land_conversion_data['village_id']) ? $land_conversion_data['village_id'] : '';
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('', isset($village_info) ? $village_info : array('' => 'Select') , $village_id,array('class'=>'form-control select2-minimum ','onchange' => 'populateSurvey("",$(this).val())','id' => 'village_id','disabled' => true))}}
                                <input type="hidden" name="land_conversion[village_id]" value="<?= $village_id ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('land_conversion[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , $village_id,array('class'=>'form-control select2-minimum ','onchange' => 'populateSurvey("",$(this).val())','id' => 'village_id'))}}
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group survey_id">
                        <label class="col-lg-5 col-md-3 control-label">Survey No.</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('land_conversion[survey_id]', isset($survey_info) ? $survey_info : array('' => 'Select') , isset($land_conversion_data['village_id']) ? $land_conversion_data['village_id'] : '',array('class'=>'form-control select2-minimum','id' => 'survey_id'))}}
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12">

                <!-- Start .panel -->

                <?php
                if (isset($conversion_surveys) && !empty($conversion_surveys)) {
                    ?>
                    <table class="table table-striped survey_list_table">
                        <thead>

                            <tr>
                                <th class="text-center">Survey No</th>                               
                                <th class="text-center">Remarks</th>                               
                                <th class="text-center">Upload Doc</th>
                                <th class="text-center">View Doc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="append">
                            <?php foreach ($conversion_surveys as $key => $value) { ?>
                                <tr class="parent_tr">
                                    <td class="text-center"><?= $value['survey_no'] ?></td>                                  
                                    <td class="text-center"> 
                                        {{ Form::text("remarks[]", isset($value["remarks"]) ? $value["remarks"] : "", array("class"=>"form-control")) }}
                                    </td>
                                    <td class="text-center survey_file_input"><input type="file" class="survey_file_upload" name="survey_files[]">
                                        <div class="allowed_type_trxn">Allowed Types :pdf, mp4</div>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $file_path = isset($value['file_path']) ? $value['file_path'] : '';
                                        $file_path = str_replace('\\', '/', $file_path);
                                        $file_name = stristr($file_path, '/');
                                        $file_type = $value['file_type'];
                                        if (file_exists($file_path)) {
                                            if ($file_type !== 'pdf') {
                                                $modal_id = 'myModal' . $key;
                                                ?>
                                                <button type="button" class="btn btn-default mr5 mb10" data-toggle="modal" data-target="#<?= $modal_id ?>">View Doc</button>
                                                <div class="modal fade" id="<?= $modal_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                                </button>
                                                                <h4 class="modal-title" id="myModalLabel2"><?= str_replace("/", "", $file_name) ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    <video width="560" height="400" controls>
                                                                        <source src="<?= url($file_path) . '?viewMode=' . 'true' ?>" type="video/<?= $file_type ?>">
                                                                    </video> 
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                $file_path = 'ViewerJS/#../' . $file_path;
                                                ?>
                                                <a href="javascript:void(0);"  onclick=" win = window.open('<?= url($file_path) . '?viewMode=' . 'true' ?>', '_blank', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1024,height=768');
                                                        win.location"><button type="button" class="btn btn-default">View Doc</button>&nbsp</a>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                            Not Uploaded
                                        <?php } ?>
                                    </td>
                                    <td  class="text-center">
                                        <?php
                                        if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('land_conversion_delete', $current_user_id) )) {
                                            ?> 
                                            <a  href="javascript:void(0);" title="Remove">
                                                <i class="ace-icon fa fa-times bigger-130  delete-existing-survey" conversion_id="<?= $value['conversion_id'] ?>" survey_id="<?= $value['survey_id'] ?>"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                            <input type="hidden"  name="survey_id[]" value="<?= $value['survey_id'] ?>">
                            <input type="hidden"  name="survey_no[]" value="<?= $value['survey_no'] ?>">
                            </tr>

                            <?php
                        }
                        ?>

                        </tbody>
                    </table>
                <?php } else { ?>
                    <table class="table table-striped survey_list_table" style="visibility: hidden">
                        <thead>

                            <tr>
                                <th class="text-center">Survey No</th>                              
                                <th class="text-center">Remarks</th>
                                <th class="text-center">Upload Doc</th>
                                <th class="text-center"></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="append">


                        </tbody>
                    </table>

                <?php } ?>
            </div>



            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" value="save" name="save_land_conversion" class="btn btn-success">Save</button>                           
                            <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
<?php } ?>
<?php if (isset($land_conversions) && !empty($land_conversions)) { ?>
    <div class="panel panel-primary">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title">Land Conversion List</h4>
        </div>
        <div class="panel-body">
            <table id="conversion_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Land Conversion No.</th>
                        <th  class="text-center">Transaction Type</th>
                        <th class="text-center">Survey No.</th>
                        <th  class="text-center">State</th>
                        <th  class="text-center">District</th>
                        <th  class="text-center">Block/Taluk</th>                               
                        <th  class="text-center">Village</th>
                        <th  class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($land_conversions) {
                        foreach ($land_conversions as $key => $value) {
                            $assigned_surveys = App\Models\Transaction\LandConversionModel::find($value['id'])->getConversionSurveys->toArray();
                            // t($assigned_surveys);
                            $sruvey_no_arr = [];
                            if (!empty($assigned_surveys)) {
                                foreach ($assigned_surveys as $s_key => $s_value) {
                                    $sruvey_no_arr[] = $s_value['survey_no'];
                                }
                                ?>
                                <tr>
                                    <td  class=""><?= $value['id'] ?></td>
                                    <td  class="text-center"><?= ($value['trxn_type'] == 'Y') ? 'Applied' : 'Obtained' ?></td>
                                    <td class=""><?= !empty($sruvey_no_arr) ? implode(", ", $sruvey_no_arr) : '' ?></td>
                                    <td  class="text-center">
                                        <?php
                                        $state_id = trim($value['state_id']);
                                        echo $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name');
                                        ?>
                                    </td>
                                    <td  class="text-center">
                                        <?php
                                        $dist_id = trim($value['district_id']);
                                        echo $state_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name');
                                        ?>
                                    </td>
                                    <td  class="text-center">
                                        <?php
                                        $block_id = trim($value['block_id']);
                                        echo $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name');
                                        ?>
                                    </td>
                                    <td  class="text-center">  <?php
                                        $village_id = trim($value['village_id']);
                                        echo $village_name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name');
                                        ?>
                                    </td>
                                    <td  class="text-center">
                                        <div class="action-buttons">
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('land_conversion_edit', $current_user_id) )) {
                                                ?> 
                                                <a title="Edit" href="<?= url('transaction/land-conversion/edit/' . $value['id']) ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                            &nbsp;&nbsp;

                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
