<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->land_reservation->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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
            <?php echo Form::open(['url' => url('transaction/hypothecation/submit-data'),'class' => 'form-horizontal hypothecate-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>



            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Hypothecate Name</label>
                        <?php
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('', isset($hypothecate_name) ?$hypothecate_name : '' , isset($hypothecate_data_data['hyp_name'])? $hypothecate_data_data['hyp_name'] : '' ,array('class'=>'form-control select2-minimum required','disabled' => true))); ?>

                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('hypothecate[hyp_name]', isset($hypothecate_name) ?$hypothecate_name : '' , '' ,array('class'=>'form-control select2-minimum required'))); ?>

                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Transaction Type</label>
                        <?php
                        $trxn_type = isset($hypothecate_data_data['trxn_type']) ? $hypothecate_data_data['trxn_type'] : '';
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('', isset($type) ?$type : '' , $trxn_type ,array('class'=>'form-control select2-minimum required','disabled' => true))); ?>

                                <input type="hidden" name="hypothecate[trxn_type]" value="<?= $trxn_type ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('hypothecate[trxn_type]', isset($type) ?$type : '' , $trxn_type ,array('class'=>'form-control select2-minimum required trxn_type','onchange' => 'populateResistration($(this).val())'))); ?>

                            </div>
                        <?php } ?>
                    </div>

                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group registration_id">
                        <label class="col-lg-5 col-md-3 control-label">Registration No.</label>
                        <?php if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('', isset($related_registration_ids) ? $related_registration_ids : '' , isset($related_registration_ids) ? $related_registration_ids : '' ,array('class'=>'form-control select2-minimum required','disabled' => true,'multiple'=>'multiple'))); ?>

                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('hypothecate[registration_id]', isset($survey_info) ? $survey_info : array('' => 'Select') , isset($land_reservation_data['village_id']) ? $land_reservation_data['village_id'] : '',array('class'=>'form-control select2-minimum','id' => 'survey_id'))); ?>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12 registration_details"></div>

            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Hypothecate With</label>
                        <?php
                        if ($id) {
                            ?>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('', isset($hypothecate_with) ?$hypothecate_with : '' , isset($hypothecate_data_data['hyp_with'])? $hypothecate_data_data['hyp_with'] : '' ,array('class'=>'form-control select2-minimum required','disabled' => true))); ?>

                            </div>
                        <?php } else { ?>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('hypothecate[hyp_with]', isset($hypothecate_with) ?$hypothecate_with : '' , '' ,array('class'=>'form-control select2-minimum required'))); ?>

                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Date</label>
                        <div class="col-lg-7 col-md-9">
                            <div class="input-group">
                                <?php if ($id) {
                                    ?>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <?php echo e(Form::text('', isset($hypothecate_data_data['hyp_date']) ? date('d/m/Y', strtotime($hypothecate_data_data['hyp_date'])) : '', array('class'=>'form-control required','placeholder' => 'Date','id'=>'basic-datepicker','disabled' => true))); ?>

                                    <input type="hidden" name="hypothecate[hyp_date]" value="<?= isset($hypothecate_data_data['hyp_date']) ? date('d/m/Y', strtotime($hypothecate_data_data['hyp_date'])) : ''; ?>">
                                <?php } else { ?>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <?php echo e(Form::text('hypothecate[hyp_date]', isset($hypothecate_data_data['hyp_date']) ? $hypothecate_data_data['hyp_date'] : '', array('class'=>'form-control required','placeholder' => 'Date','id'=>'basic-datepicker'))); ?>

                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Value</label>
                        <div class="col-lg-7 col-md-9">
                            <?php if ($id) {
                                ?>
                                <?php echo e(Form::text('', isset($hypothecate_data_data['value']) ? $hypothecate_data_data['value'] : '', array('class'=>'form-control required numbers_only_restrict autonumeric','placeholder' => 'Value','style'=>'text-align:right','disabled' => true))); ?>

                            <?php } else { ?>
                                <?php echo e(Form::text('hypothecate[value]', isset($hypothecate_data_data['value']) ? $hypothecate_data_data['value'] : '', array('class'=>'form-control required numbers_only_restrict','placeholder' => 'Value','style'=>'text-align:right'))); ?>

                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Remarks</label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::textarea('hypothecate[description]', isset($hypothecate_data_data['description']) ? $hypothecate_data_data['description'] : '', array('class'=>'form-control','placeholder' => 'Remarks','size' => '30x1'))); ?>

                        </div>
                    </div>
                </div>

                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label" for="">Doc Upload</label>
                        <div class="col-lg-7 col-md-9">
                            <input type="file" name="doc_file" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus">
                            <small>Allowed Types :pdf, mp4</small>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-lg-12 registration_document_details"></div>


            <?php if ($id) { ?>
                <div class="col-lg-12">
                    <?php if ($allRegistrationData) { ?>
                        <table class="table table-bordered">
                            <thead>

                                <tr>
                                    <th></th>
                                    <th class="text-center">Registration No.</th>                               
                                    <th class="text-center">Document Type</th>                               
                                    <th class="text-center">Physical Location</th>                               
                                    <th class="text-center">Uploaded Document</th>
                                </tr>
                            </thead>
                            <tbody class="append">
                                <?php
                                if ($allRegistrationData) {
                                    foreach ($allRegistrationData as $key => $value) {
                                        $name_field = 'hypothecate[docs][' . $value['id'] . ']';
                                        $file_path = str_replace('\\', '/', $value['path']);
                                        $file_name = stristr($file_path, '/');
                                        $file_type = $value['file_type'];
                                        $exists_Docs = explode(',', $hypothecate_data_data['payment_docs']);
                                        if ($value['hypothecate_status'] != $for_check_hypo_rele_doc) {
                                            $check_hypo_rele_doc = $value['id'];
                                        } else {
                                            $check_hypo_rele_doc = '';
                                        }
                                        ?>
                                        <tr>
                                            <?php if (file_exists($file_path)) { ?>
                                                <td  class="text-center"> <?php echo e(Form::checkbox($name_field, $value['id'],(in_array($check_hypo_rele_doc,$exists_Docs)) ? true :false)); ?></td>
                                            <?php } else { ?>
                                                <td></td>
                                            <?php } ?>
                                            <td class="text-center"><?= $value['registration_id']; ?></td>
                                            <td  class="text-center"><?php
                                                $type = trim($value['type']);
                                                echo $type_name = App\Models\Common\CodeModel::where(['id' => "$type", 'cd_type' => 'document_type'])->value('cd_desc');
                                                ?>
                                            </td>
                                            <td  class="text-center"><?= $value['physical_location'] ?></td>
                                            <td  class="text-center">
                                                <?php
                                                if (file_exists($file_path)) {
                                                    if ($file_type == 'mp4' || $file_type == 'ogg') {
                                                        $modalid = 'myModal' . $key;
                                                        ?>
                                                        <button type="button" class="btn btn-default mr5 mb10" data-toggle="modal" data-target="#<?= $modalid ?>"><?= str_replace("/", "", $file_name) ?></button>
                                                        <div class="modal fade" id="<?= $modalid ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                                <source src="<?= url($file_path) . '?viewMode=' . $viewMode ?>" type="video/<?= $file_type ?>">
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
                                                        <a href="javascript:void(0);"  onclick=" win = window.open('<?= url($file_path) . '?viewMode=' . $viewMode ?>', '_blank', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1024,height=768');
                                                                                            win.location"><button type="button" class="btn btn-default"><?= str_replace("/", "", $file_name) ?></button>&nbsp</a>
                                                               <!--<a href="<?= url('download-file?path=' . $file_path) ?>"><?= str_replace("/", "", $file_name) ?>&nbsp<i class="glyphicon glyphicon-download-alt"></i></a>-->
                                                        <?php /* str_replace("/", "", $file_name) */ ?>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    Document does not exist
                                                <?php } ?>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    <?php }
                    ?>

                </div>
            <?php } ?>


            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" value="save" name="save_land_reservation" class="btn btn-success">Save</button>                           
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
<?php if (isset($hypothetication_lists) && !empty($hypothetication_lists)) { ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Hypothecation List</h4>
        </div>
        <div class="panel-body">
            <table id="hypothecate_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Hypothecate No.</th>
                        <th  class="text-center">Hypothecate Name</th>
                        <th  class="text-center">Transaction Type</th>
                        <th class="text-center">Registration No.</th>
                        <th class="text-center">Hypothecate With</th>
                        <th class="text-center">Date</th>
                        <th  class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($hypothetication_lists) {
                        foreach ($hypothetication_lists as $key => $value) {
                            $assigned_registration = App\Models\Transaction\HypotheticationModel::find($value['id'])->getHypothecateRegistration->toArray();
                            //t($assigned_registration);
                            $registration_no_arr = [];
                            if (!empty($assigned_registration)) {
                                foreach ($assigned_registration as $r_key => $r_value) {
                                    $registration_no_arr[] = $r_value['registration_id'];
                                }
                                ?>
                                <tr>
                                    <td  class=""><?= $value['id'] ?></td>
                                    <td  class="text-center">
                                        <?php
                                        $name = App\Models\Common\CodeModel::where(['id' => "{$value['hyp_name']}"])->value('cd_desc');
                                        echo isset($name) ? $name : '';
                                        ?>
                                    </td>
                                    <td  class="text-center"><?= ($value['trxn_type'] == 'Y') ? 'Hypothicate' : 'Release' ?></td>
                                    <td class=""><?= !empty($registration_no_arr) ? implode(",", $registration_no_arr) : '' ?></td>
                                    <td  class="text-center">
                                        <?php
                                        $name = App\Models\Common\CodeModel::where(['id' => "{$value['hyp_with']}"])->value('cd_desc');
                                        echo isset($name) ? $name : '';
                                        ?>
                                    </td>
                                    <td  class=""><?= isset($value['hyp_date']) ? date('d/m/Y', strtotime($value['hyp_date'])) : ''; ?></td>

                                    <td  class="text-center">
                                        <div class="action-buttons">
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('hypothecation_edit', $current_user_id) )) {
                                                ?> 
                                                <a title="Edit" href="<?= url('transaction/hypothecation/edit/' . $value['id']) ?>">
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
