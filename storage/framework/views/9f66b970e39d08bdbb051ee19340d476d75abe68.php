<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->payment->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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
                <?php echo Form::open(['url' => url('land-details-entry/payment/submit-data'),'class' => 'form-horizontal payment-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Payment Type</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('payment[pay_type]', isset($payment_type) ? $payment_type : '' , isset($payment_data['pay_type']) ? $payment_data['pay_type'] : '',array('class'=>'form-control select2-minimum required'))); ?>

                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Mode</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('payment[pay_mode]', isset($payment_mode) ? $payment_mode : '' , isset($payment_data['pay_mode']) ? $payment_data['pay_mode'] : '',array('class'=>'form-control select2-minimum required','onchange'=>'validatePayment($(this).find("option:selected").text())'))); ?>

                            </div>

                        </div>


                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">
                    <div class="row">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Amount</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::text('payment[amount]', isset($payment_data['amount']) ? $payment_data['amount'] : '', array('class'=>'form-control required numbers_only_restrict','placeholder' => 'Amount','style'=>'text-align:right;'))); ?>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Ref No</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::text('payment[reference_no]', isset($payment_data['reference_no']) ? $payment_data['reference_no'] : '', array('class'=>'form-control','placeholder' => 'Ref No'))); ?>

                            </div>
                        </div>

                    </div>
                    <!-- End .row -->
                </div>

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Date</label>
                            <div class="col-lg-7 col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <?php echo e(Form::text('payment[pay_date]', isset($payment_data['pay_date']) ? $payment_data['pay_date'] : '', array('class'=>'form-control required','placeholder' => 'Date','id'=>'basic-datepicker'))); ?>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Bank</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::text('payment[pay_bank]', isset($payment_data['pay_bank']) ? $payment_data['pay_bank'] : '', array('class'=>'form-control bank','placeholder' => 'Bank'))); ?>

                            </div>
                        </div>


                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Remarks</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::textarea('payment[description]', isset($payment_data['description']) ? $payment_data['description'] : '', array('class'=>'form-control','placeholder' => 'Remarks','size' => '30x3'))); ?>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label" for="">Doc Upload</label>
                            <div class="col-lg-7 col-md-9">
                                <input type="file" name="doc_file" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus">
                                <small>Allowed Types: pdf, mp4</small>
                            </div>
                        </div>

                    </div>
                    <!-- End .row -->

                </div>


                <!-- End .form-group  -->

                <!-- End .form-group  -->
                <input type="hidden" name="payment_no" value="<?= isset($payment_no) ? $payment_no : '' ?>">
                <input type="hidden" name="reg_type" value="<?= isset($purchase_type_id) && ($purchase_type_id == 'CD00144') ? 'lease' : '' ?>">
                <input type="hidden" name="payment[registration_id]" value="<?= isset($reg_uniq_no) ? $reg_uniq_no : '' ?>">
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php if ($registration_converted_flag != 'Y') { ?>
                                <button type="submit" value="save" name="submit_payment" class="btn btn-success">Save</button>
                                <button type="submit" value="save_continue" name="submit_payment" class="btn btn-primary">Save & Continue</button>
                                <?php
                                if (count($paymentLists) > 0) {
                                    if ($user_type !== 'admin') {
                                        if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('lease_details_add', $current_user_id)) {
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
                                        //$skip_url = url('land-details-entry/payment/add?reg_uniq_no=' . $reg_uniq_no);
                                        if (isset($purchase_type_id) && $purchase_type_id == 'CD00144') {
                                            $skip_url = url('land-details-entry/lease/add?reg_uniq_no=' . $reg_uniq_no);
                                        } else {
                                            $skip_url = url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no);
                                        }
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

<?php if ($paymentLists) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Payment List</h4>
        </div>
        <div class="panel-body">
            <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Ref No</th>
                        <th  class="text-center">Payment Type</th>
                        <th  class="text-center">Mode</th>
                        <th  class="text-center">Date</th>
                        <th  class="text-center">Bank</th>                           
                        <th  class="text-center">Amount</th>
                        <th class="text-center">Uploaded Document</th>
                        <?php if (!$viewMode) { ?><th></th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($paymentLists) {
                        $cumilativeTotalAmount = 0;
                        foreach ($paymentLists as $key => $value) {
                            $cumilativeTotalAmount = $cumilativeTotalAmount + $value['amount'];
                            ?>
                            <tr>
                                <td  class="text-center"><?= $value['reference_no'] ?></td>
                                <td  class="text-center">
                                    <?php
                                    $pay_type = trim($value['pay_type']);
                                    echo $pay_type_name = App\Models\Common\CodeModel::where(['id' => "$pay_type"])->value('cd_desc');
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    $pay_mode = trim($value['pay_mode']);
                                    echo $pay_mode_name = App\Models\Common\CodeModel::where(['id' => "$pay_mode"])->value('cd_desc');
                                    ?>
                                </td>
                                <td  class="text-center"><?= $value['pay_date'] ?></td>
                                <td  class="text-center"><?= $value['pay_bank'] ?></td>
                                <td  class="all_total_cost" style="text-align: right;"><?= $value['amount']; ?></td>
                                <td  class="text-center">
                                    <?php
                                    $file_path = isset($value['path']) ? $value['path'] : '';
                                    $file_path = str_replace('\\', '/', $file_path);
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
                                <?php if (!$viewMode) { ?>
                                    <td  class="text-center">
                                        <div class="action-buttons">
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('payment_details_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>   
                                                <a title="Edit" href="<?= url('land-details-entry/payment/edit?reg_uniq_no=' . $reg_uniq_no . '&payment_no=' . $value['id']); ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                            <?php } ?>&nbsp;&nbsp;
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('payment_details_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>  
                                                <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $reg_uniq_no ?>', '<?= $value['id'] ?>');">
                                                    <i class="ace-icon fa fa-times bigger-130"></i>
                                                </a>
                                            <?php } ?>
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
                        <th  class="text-center">Total</th>
                        <th  class="text-center"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th  class="text-center"></th>                           
                        <th  class="all_total_cost" style="text-align: right;"><?= $cumilativeTotalAmount; ?></th>
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



<!--<script type="text/javascript" src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>-->
<?php /* $validator */ ?>