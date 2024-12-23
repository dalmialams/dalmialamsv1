<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->operation->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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
            {!! Form::open(['url' => url('transaction/under-operation/submit-data'),'class' => 'form-horizontal lease-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}


            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('operation[state_id]', isset($states) ?$states : '' , isset($operation_data['state_id']) ? $operation_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))}}
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                        <label class="col-lg-5 col-md-3 control-label">District</label>
                        <div class="col-lg-7 col-md-9">                       
                            {{Form::select('operation[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($operation_data['district_id']) ? $operation_data['district_id'] : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))}}
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

                            {{Form::select('operation[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($operation_data['block_id']) ? $operation_data['block_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))}}
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                        <label class="col-lg-5 col-md-3 control-label">Village</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('operation[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($operation_data['village_id']) ? $operation_data['village_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateSurvey("",$(this).val())'))}}
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group survey-list">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Survey no.</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('operation[survey_id]', isset($survey_info) ? $survey_info : array('' => 'Select') , isset($operation_data['survey_id']) ? $operation_data['survey_id'] : '',array('class'=>'form-control select2-minimum '))}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Operation</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('operation[operation_type]', isset($operation_type) ? $operation_type : array('' => 'Select') , isset($operation_data['operation_type']) ? $operation_data['operation_type'] : '',array('class'=>'form-control select2-minimum '))}}
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Remarks</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::textarea('operation[description]', isset($operation_data['description']) ? $operation_data['description'] : '', array('class'=>'form-control','placeholder' => 'Remarks','size' => '30x3')) }}
                        </div>
                    </div>

                </div>

            </div>


            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($operation_no) ? $operation_no : '' ?>">

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" value="save" name="save_operation" class="btn btn-success disabled">Save</button>                           
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
<?php if (isset($operationLists) && !empty($operationLists)) { ?>
    <div class="panel panel-primary">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title">Under Operation List</h4>
        </div>
        <div class="panel-body">
            <table id="operation_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Operation ID No</th>                               
                        <th  class="text-center">State</th>
                        <th  class="text-center">District</th>
                        <th  class="text-center">Taluk</th>                           
                        <th  class="text-center">Village</th>                           
                        <th  class="text-center">Survey No.</th>                           
                        <th  class="text-center">Operation</th>                           
                        <th  class="text-center">Remarks</th>                           
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($operationLists) {
                        foreach ($operationLists as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><?= $value['id'] ?></td>
                                <td  class="text-center"><?php
                                    $state_id = trim($value['state_id']);
                                    echo $state_id ? $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name') : '';
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    $dist_id = trim($value['district_id']);
                                    echo ($dist_id) ? $dist_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name') : '';
                                    ?>
                                </td>
                                <td  class="text-center"> <?php
                                    $block_id = trim($value['block_id']);
                                    echo ($block_id) ? $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name') : '';
                                    ?>
                                </td>
                                <td  class="text-center"><?php
                                    $village_id = trim($value['village_id']);
                                    echo ($village_id) ? $village_name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name') : '';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $allSurveyId = explode(',', $value['survey_id']);
                                    if ($allSurveyId) {
                                        echo '<ul>';
                                        foreach ($allSurveyId as $val) {
                                            echo ($val) ? '<li>' . $survey_name = App\Models\LandDetailsManagement\SurveyModel::where(['id' => "$val"])->value('survey_no') . '</li>' : '';
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    $operation_type = trim($value['operation_type']);
                                    echo $operation_type_name = App\Models\Common\CodeModel::where(['id' => "$operation_type"])->value('cd_desc');
                                    ?>
                                </td>
                                <td  class="text-center"><?= $value['description']; ?></td>

                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>

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
