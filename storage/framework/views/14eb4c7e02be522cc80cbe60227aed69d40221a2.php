<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<?php $__env->startSection('content'); ?>
<style>
    .select2-container-multi .select2-choices .select2-search-field input {
        padding: 5px;
        margin: 1px 0;
        /* font-family: sans-serif; */
        font-size: 90%;
        color: #666;
        outline: 0;
        border: 0;
        box-shadow: none;
        background: transparent !important;
    }
</style>
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->blockError->all();
}
?>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <?php
    if ($mesages) {
        foreach ($mesages as $key => $value) {
            ?>
            <div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong><?php echo $value; ?>!</strong></div>

            <?php
        }
    }
    ?>   
    <div><?php echo Session::get('message'); ?></div>
    <!-- Start .panel -->

</div>

<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-heading">
        <h4 class="panel-title"> Search Log</h4>
    </div>

    <div class="panel-body">
        <!-- -->
        <?php echo Form::open(['url' => url('master/search/search-log'),'class' => 'form-horizontal contact-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form','autocomplete'=>'off']); ?>

        <div class="col-lg-12">
            <div class="row ">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">

                    <div class="col-lg-2 col-md-2">
                        <select class="form-control select2 select2-minimum"  name="user[]" multiple placeholder="Users">
                            <?php
                            $user = isset($user) ? explode("','", $user) : array();
                            $module = isset($module) ? explode("','", $module) : array();
                            $action = isset($action) ? explode("','", $action) : array();
                            ?>
                            <?php foreach($users as $ulist): ?>
                            <option value="<?= isset($ulist->id) ? $ulist->id : 0 ?>" <?php
                            if (isset($user) && in_array($ulist->id, $user)) {
                                echo"selected";
                            }
                            ?>>
<?= isset($ulist->user_name) ? $ulist->user_name : '' ?>
                            </option>

                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <select  placeholder="Modules" class="form-control select2 select2-minimum" multiple  name="module[]" >

                            <option value="T_MIS_TRANSACTION_HISTORY" <?php
if (isset($module) && in_array('T_SURVEY', $module)) {
    echo"selected";
}
?>>MIS</option>




                        </select>
                    </div>


                    <div class="col-lg-2 col-md-2">
                        <input type="text"  class="form-control basic-datepicker" name="from_date" value="<?= isset($from_date) && $from_date != '' ? date('d/m/Y', strtotime($from_date)) : '' ?>" placeholder="From date">
                    </div>



                    <div class="col-lg-2 col-md-2">
                        <input type="text" class="form-control basic-datepicker" name="to_date" value="<?= isset($to_date) && $to_date != '' ? date('d/m/Y', strtotime($to_date)) : '' ?>" placeholder="To date">
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <button type="submit" id="" class="btn btn-sm btn-info pull-left" >Search</button>
                        <a style="margin-left:3px;" href="" class="btn btn-sm btn-warning pull-left" >Reset</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- -->
        <?php echo Form::close(); ?>

        <table id="master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>User.</th>
                    <th>Table</th>	
                    <th>Action</th>
                    <th>Description</th>					
                    <!--<th>Original Field</th>
                    <th>Changed Fields</th> -->                                         


                </tr>
            </thead>
            <tbody>

                <?php if(isset($list) && !empty($list)): ?>
                <?php foreach($list as $k=>$infos): ?>

                <tr>
                    <td><?php echo e($k+1); ?></td>
                    <?php
                    $where_user = "where id='" . $infos->created_id. "'";
                    $sql_block = "select * from \"T_USER\" $where_user  ";
                    $results_user = DB::select(DB::raw($sql_block));                    
                    ?>
                    <td><?= $results_user[0]->user_name ?></td>
                    <td><?php echo e(isset($infos->mis_type)? $infos->mis_type : ''); ?></td>

                    <td>
                        MIS 
                    </td>
                    <td>
                        <?php
                        $mis_details = json_decode($infos->mis_details, true);
                        foreach ($mis_details as $key => $value) {
                            if ($value['name'] == "state") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_state = "select * from \"T_STATE\" $where  ";
                                $results = DB::select(DB::raw($sql_state));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->state_name . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->state_name;
                                }
                            }

                            if ($value['name'] == "district") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_district = "select * from \"T_DISTRICT\" $where  ";
                                $results = DB::select(DB::raw($sql_district));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->district_name . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->district_name;
                                }
                            }
                            if ($value['name'] == "block") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_block = "select * from \"T_BLOCK\" $where  ";
                                $results = DB::select(DB::raw($sql_block));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->block_name . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->block_name;
                                }
                            }

                            if ($value['name'] == "village") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_village = "select * from \"T_VILLAGE\" $where  ";
                                $results = DB::select(DB::raw($sql_village));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->village_name . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->village_name;
                                }
                            }

                            if ($value['name'] == "sub_registrar") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_cd = "select * from \"T_CODES\" $where  ";
                                $results = DB::select(DB::raw($sql_cd));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->cd_desc . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->cd_desc;
                                }
                            }

                            if ($value['name'] == "purchase_type") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_cd = "select * from \"T_CODES\" $where  ";
                                $results = DB::select(DB::raw($sql_cd));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->cd_desc . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->cd_desc;
                                }
                            }

                            if ($value['name'] == "legal_entity") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_cd = "select * from \"T_CODES\" $where  ";
                                $results = DB::select(DB::raw($sql_cd));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->cd_desc . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->cd_desc;
                                }
                            }

                            if ($value['name'] == "purchaser") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_cd = "select * from \"T_CODES\" $where  ";
                                $results = DB::select(DB::raw($sql_cd));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->cd_desc . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->cd_desc;
                                }
                            }

                            if ($value['name'] == "purchasing_team") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_district = "select * from \"T_DISTRICT\" $where  ";
                                $results = DB::select(DB::raw($sql_district));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->district_name . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->district_name;
                                }
                            }

                            if ($value['name'] == "survey_no") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_survey = "select * from \"T_SURVEY\" $where  ";
                                $results = DB::select(DB::raw($sql_survey));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->survey_no . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->survey_no;
                                }
                            }

                            if ($value['name'] == "sub_classification") {
                                $where = "where id='" . $value['value'] . "'";
                                $sql_sub_cl = "select * from \"sub_classification\" $where  ";
                                $results = DB::select(DB::raw($sql_sub_cl));
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $results[0]->sub_name . ",";
                                } else {
                                    echo $value['name'] . " " . $results[0]->sub_name;
                                }
                            }
                            if ($value['name'] != "sub_classification" && $value['name'] != "state" && $value['name'] != "district" && $value['name'] != "block" && $value['name'] != "village" && $value['name'] != "sub_registrar" && $value['name'] != "purchase_type" && $value['name'] != "legal_entity" && $value['name'] != "purchaser" && $value['name'] != "purchasing_team" && $value['name'] != "survey_no" && $value['name'] != "sub_classification") {
                                if ($key < count($mis_details) - 1) {
                                    echo $value['name'] . " " . $value['value'] . ",";
                                } else {
                                    echo $value['name'] . " " . $value['value'];
                                }
                            }
                        }
                        ?>
                    </td>

                </tr>


                <?php endforeach; ?>
                <?php endif; ?>        
            </tbody>

        </table>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="displayCostDistributionModal">
    <div class="modal-dialog" id="displayCostDistributionDetails">

    </div>
</div>
<!--<script type="text/javascript" src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>