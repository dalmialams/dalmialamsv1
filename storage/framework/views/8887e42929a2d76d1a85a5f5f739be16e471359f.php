<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->audit->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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
            <?php echo Form::open(['url' => url('transaction/audit/submit-data'),'class' => 'form-horizontal lease-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>



            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12">

                        <div class="panel">

                            <div class="panel-heading white-bg">
                                <h3>Audit Status</h3>
                                <div class="col-sm-6 col-xs-12 form-group pull-left">

                                    <label class="control-label pull-left">Reg No.</label>
                                    <div class="col-lg-7 col-md-9 registrationList">
                                        <?php if (isset($audit_data[0]['reg_id'])) { ?>
                                            <?php echo e(Form::select('', isset($reg_id_arr) ?$reg_id_arr : array('' => 'Select') , isset($audit_data[0]['reg_id']) ? $audit_data[0]['reg_id'] : '',array('class'=>'form-control select2-minimum','disabled' => true))); ?>

                                            <input type="hidden" name="auditstatusreg[reg_no]" value="<?= $audit_data[0]['reg_id'] ?>" id="uniqueregistrationNumber">
                                        <?php } else { ?>
                                            <?php echo e(Form::select('auditstatusreg[reg_no]', isset($reg_id_arr) ?$reg_id_arr : array('' => 'Select') , isset($audit_data['reg_id']) ? $audit_data['reg_id'] : '',array('class'=>'form-control select2-minimum','onchange'=>'checkExists($(this).val())','id'=>'uniqueregistrationNumber'))); ?>

                                        <?php } ?>
                                    </div>
                                    <?php if (!isset($audit_data[0]['reg_id'])) { ?>
                                        <div>
                                            <span class="logo" data-toggle="modal" data-target="#auditstatushelp">
                                                <img src="<?php echo e(URL::asset('assets/img/help_icon.png')); ?>" alt="Dalmia Lams">
                                            </span>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                    <tr>                                     
                                        <th class="text-center">Description</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center" width="20%">Date</th>
                                        <th class="text-center">Verified</th>
                                        <th class="text-center">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($masterData as $key => $value) {
                                        $masterid = $value['id'];
                                        ?>
                                        <tr>
                                            <td  class="text-center">
                                                <?= $value['description'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($value['description'] == 'Payment') { ?>
                                                    <a class="btn btn-info btn-xs" href="javascript:void(0);" title="View Details" onclick="openHref('Payment')">
                                                        <i class="fa fa-external-link bigger-130"></i>
                                                    </a>
                                                <?php } elseif ($value['description'] == 'Document') { ?>
                                                    <a class="btn btn-info btn-xs" href="javascript:void(0);" title="View Details" onclick="openHref('Document')">
                                                        <i class="fa fa-external-link bigger-130"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (isset($audit_data['data'][$masterid]['audit_date'])) { ?>
                                                    <?= date('d/m/Y', strtotime($audit_data['data'][$masterid]['audit_date'])) ?>
                                                <?php } else { ?>
                                                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <?php echo e(Form::text('auditstatus['.$masterid.'][audit_date]', isset($audit_data['data']["regn_date"]) ? $reg_data["regn_date"] : date('d/m/Y'), array("class"=>"form-control required basic-datepicker","placeholder" => "Date"))); ?>

                                                    </div>
                                                <?php } ?>

                                            </td>
                                            <td class="text-center">
                                                <?php if (isset($audit_data['data'][$masterid]['verified'])) { ?>
                                                    <?= $audit_data['data'][$masterid]['verified'] == 'Y' ? 'Yes' : 'No'; ?>
                                                <?php } else { ?>
                                                    <?php echo e(Form::select('auditstatus['.$masterid.'][verified]', isset($type) ?$type : '' , '' ,array('class'=>'form-control select2-minimum'))); ?>

                                                <?php } ?>

                                            </td>
                                            <td class="text-center"> 
                                                <?php if (isset($audit_data['data'][$masterid]['remarks'])) { ?>
                                                    <?= $audit_data['data'][$masterid]['remarks']; ?>
                                                <?php } else { ?>
                                                    <?php echo e(Form::text('auditstatus['.$masterid.'][remarks]', isset($value["remarks"]) ? $value["remarks"] : "", array("class"=>"form-control"))); ?>

                                                <?php } ?>

                                            </td>

                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>



            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" value="save" name="save_audit_status" class="btn btn-success">Save</button>                           
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
<?php if (isset($auditStatusLists) && !empty($auditStatusLists)) { ?>
    <div class="panel panel-primary">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title">Audit status List</h4>
        </div>
        <div class="panel-body">
            <table id="audit_stat_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Audit Status ID No</th>                               
                        <th  class="text-center">Registration No.</th>
                        <th  class="text-center">Ip</th>                           
                        <th  class="text-center">Action</th>                           
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($auditStatusLists) {
                        foreach ($auditStatusLists as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><?= $value['id'] ?></td>
                                <td  class="text-center"><?= $value['reg_id'] ?></td>
                                <td  class="text-center"><?= $value['ip_address'] ?></td>
                                <td  class="text-center">
                                    <div class="action-buttons">
                                        <?php
                                        if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('audit_status_edit', $current_user_id) )) {
                                            ?> 
                                            <a title="Edit" href="<?= url('transaction/audit/edit?audit_uniq_no=' . $value['id']); ?>">
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

            <!--Modal-->
            <div class="modal fade" id="auditstatushelp" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">Generate Reg No.</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <div class="row ">
                                    <!-- Start .row -->
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                                        <div class="col-lg-7 col-md-9">
                                            <?php echo e(Form::select('mutation[state_id]', isset($states) ?$states : '' , isset($mutation_data['state_id']) ? $mutation_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))); ?>

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>District</label>
                                        <div class="col-lg-7 col-md-9">                       
                                            <?php echo e(Form::select('mutation[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($mutation_data['district_id']) ? $mutation_data['district_id'] : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))); ?>

                                        </div>

                                    </div>

                                </div>
                                <!-- End .row -->

                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <!-- Start .row -->
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group block-list">
                                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">*</span>Block/Taluk</label>
                                        <div class="col-lg-7 col-md-9">  

                                            <?php echo e(Form::select('mutation[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($mutation_data['block_id']) ? $mutation_data['block_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))); ?>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Village</label>
                                        <div class="col-lg-7 col-md-9">
                                            <?php echo e(Form::select('mutation[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($mutation_data['village_id']) ? $mutation_data['village_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populatePatta($(this).val())'))); ?>

                                        </div>
                                    </div>
                                </div>
                                <!-- End .row -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Modal-->

        </div>
    </div>
<?php } ?>
