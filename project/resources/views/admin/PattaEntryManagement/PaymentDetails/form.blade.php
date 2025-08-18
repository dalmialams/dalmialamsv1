<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->payment->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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
                {!! Form::open(['url' => url('land-details-entry/payment/submit-data'),'class' => 'form-horizontal payment-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Payment Type</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('payment[pay_type]', isset($payment_type) ? $payment_type : '' , isset($payment_data['pay_type']) ? $payment_data['pay_type'] : '',array('class'=>'form-control select2-minimum required'))}}
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Mode</label>
                            <div class="col-lg-7 col-md-9">
                                {{Form::select('payment[pay_mode]', isset($payment_mode) ? $payment_mode : '' , isset($payment_data['pay_mode']) ? $payment_data['pay_mode'] : '',array('class'=>'form-control select2-minimum required','onchange'=>'validatePayment($(this).find("option:selected").text())'))}}
                            </div>

                        </div>


                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">
                    <div class="row">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Amount</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('payment[amount]', isset($payment_data['amount']) ? $payment_data['amount'] : '', array('class'=>'form-control required numbers_only_restrict','placeholder' => 'Amount','style'=>'text-align:right;')) }}
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Ref No</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('payment[reference_no]', isset($payment_data['reference_no']) ? $payment_data['reference_no'] : '', array('class'=>'form-control','placeholder' => 'Ref No')) }}
                            </div>
                        </div>

                    </div>
                    <!-- End .row -->
                </div>

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Date</label>
                            <div class="col-lg-7 col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {{ Form::text('payment[pay_date]', isset($payment_data['pay_date']) ? $payment_data['pay_date'] : '', array('class'=>'form-control required','placeholder' => 'Date','id'=>'basic-datepicker')) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Bank</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::text('payment[pay_bank]', isset($payment_data['pay_bank']) ? $payment_data['pay_bank'] : '', array('class'=>'form-control bank','placeholder' => 'Bank')) }}
                            </div>
                        </div>


                    </div>
                    <!-- End .row -->

                </div>

                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Remarks</label>
                            <div class="col-lg-7 col-md-9">
                                {{ Form::textarea('payment[description]', isset($payment_data['description']) ? $payment_data['description'] : '', array('class'=>'form-control','placeholder' => 'Remarks','size' => '30x3')) }}
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label" for="">Doc Upload</label>
                        <div class="col-lg-7 col-md-9">
                            <input type="file" name="doc_file" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus">
                            <small>Allowed Types :pdf, mp4, ogg</small>
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
                                <button type="submit" value="save" name="submit_payment" class="btn btn-success">Save</button>
                                <button type="submit" value="save_continue" name="submit_payment" class="btn btn-primary">Save & Continue</button>
                                <?php if (count($paymentLists) > 0) { ?>
                                    <a href="<?= url('land-details-entry/registration/add') ?>"><button type="button" class="btn btn-warning">Done</button></a>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-warning disabled">Done</button>
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

<?php if ($paymentLists) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Payment List</h4>
        </div>
        <div class="panel-body">
            <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>Payment Type</th>
                        <th>Mode</th>
                        <th>Date</th>
                        <th>Bank</th>                           
                        <th>Amount</th>
                        <th>Uploaded Document</th>
                        <?php if (!$viewMode) { ?><th></th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($paymentLists) {
                        foreach ($paymentLists as $key => $value) {
                            ?>
                            <tr>
                                <td><?= $value['reference_no'] ?></td>
                                <td>
                                    <?php
                                    $pay_type = trim($value['pay_type']);
                                    echo $pay_type_name = App\Models\Common\CodeModel::where(['id' => "$pay_type"])->value('cd_desc');
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $pay_mode = trim($value['pay_mode']);
                                    echo $pay_mode_name = App\Models\Common\CodeModel::where(['id' => "$pay_mode"])->value('cd_desc');
                                    ?>
                                </td>
                                <td><?= $value['pay_date'] ?></td>
                                <td><?= $value['pay_bank'] ?></td>
                                <td style="text-align: right;"><?= number_format($value['amount']) ?></td>
                                <td>
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
                                    <td>
                                        <div class="action-buttons">
                                            <a title="Edit" href="<?= url('land-details-entry/payment/add?reg_uniq_no=' . $reg_uniq_no . '&payment_no=' . $value['id']); ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
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