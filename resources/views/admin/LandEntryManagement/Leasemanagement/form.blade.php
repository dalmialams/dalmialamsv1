<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->lease->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div>{!! Session::get('message')!!}</div>
<?php
if ($mesages) {

    foreach ($mesages as $key => $value) {
        echo $value;
    }
}
$total_area_val = '';
$tot_area_unit = '';
$rgistration_date = '';
$location = '';
if ($reg_info) {
    $state_name = ($reg_info['state_id']) ? App\Models\Common\StateModel::where(['id' => $reg_info['state_id']])->value('state_name') : '';
    $district_name = ($reg_info['district_id']) ? App\Models\Common\DistrictModel::where(['id' => $reg_info['district_id']])->value('district_name') : '';
    $block_name = ($reg_info['block_id']) ? App\Models\Common\BlockModel::where(['id' => $reg_info['block_id']])->value('block_name') : '';
    $village_name = ($reg_info['village_id']) ? App\Models\Common\VillageModel::where(['id' => $reg_info['village_id']])->value('village_name') : '';
    if ($state_name) {
        $location.= $state_name;
    }
    if ($district_name) {
        $location.= ',' . $district_name;
    }
    if ($block_name) {
        $location.= ',' . $block_name;
    }
    if ($village_name) {
        $location.= ',' . $village_name;
    }
    $total_area_val = $reg_info['tot_area'];
    $tot_area_unit = $reg_info['tot_area_unit'];
    $tot_area_unit = App\Models\Common\CodeModel::where(['id' => "$tot_area_unit"])->value('cd_desc');
    $rgistration_date = ($reg_info['regn_date']) ? date('d/m/Y', strtotime($reg_info['regn_date'])) : '';
}
?>   
<?php if (!$viewMode) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">


        <!-- Start .panel -->

        <div class="panel-body">
            {!! Form::open(['url' => url('land-details-entry/lease/submit-data'),'class' => 'form-horizontal lease-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Lessee</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('lease[lease_name]', isset($lease_data['lease_name']) ? $lease_data['lease_name'] : '', array('class'=>'form-control required','placeholder' => 'Lessee')) }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">*</span>Lessor</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('lease[lessor_name]', isset($lease_data['lessor_name']) ? $lease_data['lessor_name'] : '', array('class'=>'form-control required','placeholder' => 'Lessor')) }}
                        </div>
                    </div>

                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Total Area</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('total_area', $total_area_val.' '.$tot_area_unit, array('class'=>'form-control required','readonly' => '','placeholder' => 'Total Area')) }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Lease Rent p.a.</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('lease[lease_monthly_amount]', isset($lease_data['lease_monthly_amount']) ? $lease_data['lease_monthly_amount'] : '', array('class'=>'form-control required numbers_only_restrict','placeholder' => 'Lease Rent p.a.','style'=>'text-align:right')) }}
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>   
            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Date</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('rgistration_date', $rgistration_date, array('class'=>'form-control required','readonly' => '','placeholder' => 'Date')) }}

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Lease Period (From - To)</label>
                        <div class="col-lg-7 col-md-9">
                            <div class="input-group">
                                <div class="input-daterange input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    <!--                                    <input type="text" class="form-control" name="start" />-->
                                    {{ Form::text('lease[lease_start_date]', isset($lease_data['lease_start_date']) ? $lease_data['lease_start_date'] : '', array('class'=>'form-control required','placeholder' => 'Start Date','id' => 'start_date')) }}
                                    <span class="input-group-addon">to</span>
                                    {{ Form::text('lease[lease_end_date]', isset($lease_data['lease_end_date']) ? $lease_data['lease_end_date'] : '', array('class'=>'form-control required','placeholder' => 'End Date','id' => 'end_date')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Escalation %</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('lease[percentage_escalation]', isset($lease_data['percentage_escalation']) ? $lease_data['percentage_escalation'] : '', array('class'=>'form-control required','placeholder' => 'Escalation %')) }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Location</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::text('location', $location, array('class'=>'form-control required','placeholder' => 'Location','readonly' => '')) }}
                        </div>
                    </div>

                </div>
                <!-- End .row -->
            </div>
            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label" for="">Doc Upload</label>
                        <div class="col-lg-7 col-md-9">
                            <input type="file" name="doc_file" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus">
                            <small>Allowed Types: pdf, mp4</small>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Status</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('lease[status]', isset($status) ? $status : '', isset($lease_data['status']) ? $lease_data['status'] : '',array('class'=>'form-control select2-minimum required'))}}
                        </div>

                    </div>

                </div>

                <!-- End .row -->
            </div>
            <!-- End .row -->
            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
            <input type="hidden" name="lease[registration_id]" value="<?= isset($reg_uniq_no) ? $reg_uniq_no : '' ?>">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <?php if ($registration_converted_flag != 'Y') { ?>
                            <button type="submit" value="save" name="save_lease" class="btn btn-success">Save</button>
                            <button type="submit" value="save_continue" name="save_lease" class="btn btn-primary">Save & Continue</button>
                            <?php
                            if (isset($lease) && count($lease) > 0) {
                                if ($user_type !== 'admin') {
                                    if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('geo_tag_add', $current_user_id)) {
                                        $skip_url = url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no);
                                    } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('transaction_details_access', $current_user_id)) {
                                        $skip_url = url('land-details-entry/registration/transaction-details?reg_uniq_no=' . $reg_uniq_no);
                                    } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('audit_details_access', $current_user_id)) {
                                        $skip_url = url('land-details-entry/registration/audit-details?reg_uniq_no=' . $reg_uniq_no);
                                    } else {
                                        $skip_url = '';
                                    }
                                } else {
                                    $skip_url = url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no);
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
            {!! Form::close() !!}
        </div>

    </div>
<?php } ?>
<?php if (isset($lease) && !empty($lease)) { ?>
    <div class="panel panel-primary">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title">Lease List</h4>
        </div>
        <div class="panel-body">
            <table id="lease_lists_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
    <!--                        <th  class="text-center">Lease Unique Id</th>-->
    <!--                            <th  class="text-center" class="hide">Survey No</th>-->                                               
                        <th  class="text-center">Lessee</th>
                        <th  class="text-center">Lessor</th>                                             
                        <th  class="text-center">Lease Rent p.a.</th>                      
                        <th  class="text-center">Period (From - To)</th>
                        <th  class="text-center">Escalation %</th>
                        <th  class="text-center">Uploaded Document</th>
                        <th  class="text-center">Location</th>
                        <th  class="text-center">Status</th>
                        <?php if (!$viewMode) { ?><th  class="text-center">Action</th><?php } ?>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($lease as $key => $value) {
                        $start_date = new \DateTime($value['lease_start_date']);
                        $start_date = $start_date->format('d/m/Y');
                        $end_date = new \DateTime($value['lease_end_date']);
                        $end_date = $end_date->format('d/m/Y');
                        ?>
                        <tr>    
                            <td  class="text-center"><?= $value['lease_name'] ?></td> 
                            <td  class="text-center"><?= $value['lessor_name'] ?></td> 
                            <td  class="text-center" style="text-align: right;" class="all_total_cost"><?= $value['lease_monthly_amount'] ?></td> 
                            <td  class="text-center"><?= $start_date . ' to ' . $end_date ?></td> 
                            <td  class="text-center" style="text-align: right;"><?= $value['percentage_escalation'] . '%' ?></td> 

                            <td  class="text-center">
                                <?php
                                $file_path = isset($value['lessor_doc_path']) ? $value['lessor_doc_path'] : '';
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
                            <td  class="text-center"><?= $location ?></td> 
                            <td  class="text-center"><?= $value['status'] == 'Y' ? '<span class="label label-success mr10 mb10">Active</span>' : '<span class="label label-warning mr10 mb10">Inactive</span>' ?></td>
                            <?php if (!$viewMode) { ?>
                                <td  class="text-center">
                                    <div class="action-buttons">
                                        <?php
                                        if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('lease_details_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                            ?>  
                                            <a title="Edit" href="<?= url('land-details-entry/lease/edit/' . $value['id'] . '?reg_uniq_no=' . $reg_uniq_no) ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>
                                        <?php } ?>
                                        &nbsp;&nbsp;
                                        <?php
                                        if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('lease_details_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
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
                    ?>

                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
