<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->document->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>

<div><?php echo Session::get('message'); ?></div>
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
                <?php echo Form::open(['url' => url('land-details-entry/document/submit-data'),'class' => 'form-horizontal document-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>       
                <div class="col-lg-12">
                    <div class="row">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Document Type</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('document[type]', isset($document_type) ? $document_type : '', isset($doc_data['type']) ? $doc_data['type'] : '',array('class'=>'form-control select2-minimum required'))); ?>

                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Physical Location</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::text('document[physical_location]', isset($doc_data['physical_location']) ? $doc_data['physical_location'] : '', array('class'=>'form-control required','placeholder' => 'Physical Location'))); ?>

                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label" for="">Upload Document</label>
                            <div class="col-lg-7 col-md-9">
                                <input type="file" name="doc_file" id="efive_doc_file" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus" >
                                <small>Allowed Types: pdf, mp4</small>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Remarks</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::text('document[remarks]', isset($doc_data['remarks']) ? $doc_data['remarks'] : '', array('class'=>'form-control','placeholder' => 'Remarks'))); ?>


                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
                <!-- End .form-group  -->

                <!-- End .form-group  -->
                <input type="hidden" name="id" value="<?= isset($doc_id) ? $doc_id : '' ?>">
                <input type="hidden" name="document[registration_id]" value="<?= isset($reg_uniq_no) ? $reg_uniq_no : '' ?>">
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php if ($registration_converted_flag != 'Y') { ?>
                                <button type="submit" value="save" id="efive_save_doc" name="save_doc" class="btn btn-success">Save</button>
                                <button type="submit" value="save_continue" name="save_doc" class="btn btn-primary">Save & Continue</button>
                                <?php
                                if (count($all_docs) > 0) {
                                    if ($user_type !== 'admin') {
                                        if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('payment_details_add', $current_user_id)) {
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
                                        $skip_url = url('land-details-entry/payment/add?reg_uniq_no=' . $reg_uniq_no);
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
                <?php echo Form::close(); ?>

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
<?php if ($all_docs) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="row">
            <div class="col-lg-12">
                <!-- col-lg-12 start here -->
                <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
                    <!-- Start .panel -->
                    <div class="panel-heading">
                        <h4 class="panel-title">Document List</h4>
                    </div>
                    <div class="panel-body">
                        <table id="tabletools" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th  class="text-center">Document Type</th>
                                    <th  class="text-center">Document Physical Location</th>
                                    <th  class="text-center">Uploaded Document</th>
                                    <th  class="text-center">Remarks</th>  
                                    <?php if (!$viewMode && $registration_converted_flag!='Y') { ?><th  class="text-center"></th><?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($all_docs as $key => $value) {
                                    ?>
                                    <tr>
                                        <td  class="text-center"><?php
                                            $type = trim($value['type']);
                                            echo $type_name = App\Models\Common\CodeModel::where(['id' => "$type", 'cd_type' => 'document_type'])->value('cd_desc');
                                            ?>
                                        </td>
                                        <td  class="text-center"><?= $value['physical_location'] ?></td>
                                        <td  class="text-center">
                                            <?php
                                            $file_path = str_replace('\\', '/', $value['path']);
                                            $file_name = stristr($file_path, '/');
                                            $file_type = $value['file_type'];
                                            if (file_exists($file_path)) {
                                                if ($file_type == 'mp4' || $file_type == 'ogg') {
                                                    $id = 'myModal' . $key;
                                                    ?>
                                                    <button class="btn btn-default mr5 mb10" data-toggle="modal" data-target="#<?= $id ?>"><?= str_replace("/", "", $file_name) ?></button>
                                                    <div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                            win.location"><button class="btn btn-default"><?= str_replace("/", "", $file_name) ?></button>&nbsp</a>
                                                           <!--<a href="<?= url('download-file?path=' . $file_path) ?>"><?= str_replace("/", "", $file_name) ?>&nbsp<i class="glyphicon glyphicon-download-alt"></i></a>-->
                                                    <?php /* str_replace("/", "", $file_name) */ ?>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                Document does not exist
                                            <?php } ?>
                                        </td>
                                        <td  class="text-center"><?= $value['remarks'] ?></td> 
                                        <?php if (!$viewMode && $registration_converted_flag!='Y') { ?>
                                            <td  class="text-center">
                                                <div class="action-buttons">
                                                    <?php
                                                    if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('document_upload_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                        ?>    
                                                        <a title="Edit" href="<?= url('land-details-entry/document/edit?reg_uniq_no=' . $reg_uniq_no . '&doc_id=' . $value['id']) ?>">
                                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                        </a><?php } ?>
                                                    &nbsp;&nbsp;
                                                    <?php
                                                    if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('document_upload_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                        ?> 
                                                        <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $reg_uniq_no ?>', '<?= $value['id'] ?>');">
                                                            <i class="ace-icon fa fa-times bigger-130"></i>
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
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
                <!-- End .panel -->
            </div>
        </div>
    </div>
<?php } ?>

