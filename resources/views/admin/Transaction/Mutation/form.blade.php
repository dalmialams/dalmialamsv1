<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->mutation->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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
            {!! Form::open(['url' => url('transaction/mutation/submit-data'),'class' => 'form-horizontal lease-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}


            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('mutation[state_id]', isset($states) ?$states : '' , isset($mutation_data['state_id']) ? $mutation_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))}}
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                        <label class="col-lg-5 col-md-3 control-label">District</label>
                        <div class="col-lg-7 col-md-9">                       
                            {{Form::select('mutation[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($mutation_data['district_id']) ? $mutation_data['district_id'] : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))}}
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

                            {{Form::select('mutation[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($mutation_data['block_id']) ? $mutation_data['block_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))}}
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                        <label class="col-lg-5 col-md-3 control-label">Village</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('mutation[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($mutation_data['village_id']) ? $mutation_data['village_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populatePatta($(this).val())'))}}
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group patta-list">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Patta no.</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('mutation[patta_id]', isset($patta_info) ? $patta_info : array('' => 'Select') , isset($mutation_data['patta_id']) ? $mutation_data['patta_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateFields($(this).val())'))}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Patta Owner</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('pattaowner', isset($patta_owner) ? $patta_owner : '', array('class'=>'form-control required','placeholder' => 'patta owner','readonly' => '')) }}
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

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>New Patta no.</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('mutation[new_patta_no]',isset($mutation_data['new_patta_no']) ? $mutation_data['new_patta_no'] : '', array('class'=>'form-control required','placeholder' => 'patta owner')) }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>New Patta Owner</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('mutation[new_patta_owner]',isset($mutation_data['new_patta_owner']) ? $mutation_data['new_patta_owner'] : '', array('class'=>'form-control required','placeholder' => 'patta owner')) }}
                        </div>
                    </div>

                </div>

            </div>


            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($mutation_no) ? $mutation_no : '' ?>">

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" value="save" name="save_mutation" class="btn btn-success disabled">Save</button>                           
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
<?php if (isset($mutationLists) && !empty($mutationLists)) { ?>
    <div class="panel panel-primary">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title">Mutation List</h4>
        </div>
        <div class="panel-body">
            <table id="mutation_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Mutation ID No</th>                               
                        <th  class="text-center">State</th>
                        <th  class="text-center">District</th>
                        <th  class="text-center">Taluk</th>                           
                        <th  class="text-center">Village</th>                           
                        <th  class="text-center">Patta No</th>                           
                        <th  class="text-center">Patta Owner</th>                           
                        <th  class="text-center">New Patta No</th>                           
                        <th  class="text-center">New Patta Owner</th>                           
                        <?php if (!$viewMode) { ?><th  class="text-center">Status</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($mutationLists) {
                        foreach ($mutationLists as $key => $value) {
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
                                <td  class="text-center custom_underline" onclick="pattasurveyno('<?php echo $value['patta_id']; ?>', 'old_patta');">
                                    <?php
                                    $patta_no = trim($value['patta_id']);
                                    echo ($patta_no) ? $patta_no = App\Models\LandDetailsManagement\PattaModel::where(['id' => "$patta_no"])->value('patta_no') : '';
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    $patta_no = trim($value['patta_id']);
                                    echo ($patta_no) ? $patta_owner = App\Models\LandDetailsManagement\PattaModel::where(['id' => "$patta_no"])->value('patta_owner') : '';
                                    ?>
                                </td>
                                <td  class="text-center custom_underline" onclick="pattasurveyno('<?php echo $value['id']; ?>', 'new_patta');"><?= $value['new_patta_no']; ?></td>
                                <td  class="text-center"><?= $value['new_patta_owner']; ?></td>
                                <?php if (!$viewMode) { ?>
                                    <td  class="text-center">
                                        <div class="action-buttons">
                                            Mutated
                <!--                                            <a title="Edit" href="<?= url('transaction/mutation/add?mutation_no=' . $value['id']); ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>&nbsp;&nbsp;
                                            <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $value['id'] ?>');">
                                                <i class="ace-icon fa fa-times bigger-130"></i>
                                            </a>-->
                                        </div>
                                    </td>
                                <?php } ?>
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

            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="displaySurveyDetailsModal">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="mySmallModalLabel">Survey No. List</h4>
                        </div>
                        <div class="modal-body" id="displaySurveyDetails">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

