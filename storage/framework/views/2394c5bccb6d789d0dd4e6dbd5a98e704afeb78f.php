<?php $__env->startSection('content'); ?>
<!-- .page-content -->

<div class="row">
    <div><?php echo Session::get('message'); ?></div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->


        <div class="panel panel-primary  toggle panelMove">

            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Search Screen</h4>
            </div>
            <div class="panel-body">
                <?php echo Form::open(['url' => url('land-details-entry/patta/list'),'class' => 'form-horizontal reg-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label">State</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('patta[state_id]', isset($states) ?$states : '' , isset($state_id) ? $state_id : '',array('class'=>'form-control select2-minimum','onchange' => 'populateDistrict($(this).val())'))); ?>

                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                            <label class="col-lg-5 col-md-3 control-label">District</label>
                            <div class="col-lg-7 col-md-9">                       
                                <?php echo e(Form::select('patta[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($district_id) ? $district_id : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))); ?>

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
                                <?php echo e(Form::select('patta[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($block_id) ? $block_id : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))); ?>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                            <label class="col-lg-5 col-md-3 control-label">Village</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('patta[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($village_id) ? $village_id : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateSurvey("",$(this).val())'))); ?>

                            </div>
                        </div>                                       
                    </div>
                    <!-- End .row -->
                </div>

                <div class="col-lg-12">
                    <div class="row">                      

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Patta no.</label>
                            <div class="col-lg-7 col-md-9">
                                <?php /* Form::text('patta[patta_no]', isset($patta_no) ? $patta_no : '', array('class'=>'form-control required','placeholder' => 'Patta no.')) */ ?>
                                <?php echo e(Form::select('patta[patta_no]', isset($patta_no_info) ? $patta_no_info : array('' => 'Select'), isset($patta_no) ? $patta_no : '',array('class'=>'form-control select2-minimum '))); ?>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Patta owner</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::text('patta[patta_owner]', isset($patta_owner) ? $patta_owner : '', array('class'=>'form-control required','placeholder' => 'Patta owner'))); ?>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="row">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Patta ID No</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::text('patta[id]', isset($id) ? $id : '', array('class'=>'form-control required','placeholder' => 'Patta ID No'))); ?>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group survey-list">
                            <label class="col-lg-5 col-md-3 control-label">Survey No.</label>
                            <div class="col-lg-7 col-md-9">
                                <?php echo e(Form::select('survey_id[]', isset($survey_info) ? $survey_info : array('Select' => '') , isset($survey_id) ? $survey_id : '',array('class'=>'form-control select2-minimum ','multiple' => 'true'))); ?>

                            </div>
                        </div> 
                    </div>
                </div>



                <!-- End .row -->
                <!-- End .form-group  -->
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" value="search" name="search_reg" class="btn btn-success">Search</button>
                                <a href="<?= url('land-details-entry/patta/list') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <!-- End .form-group  -->


            <!-- End .form-group  -->
        </div>


        <?php if ($dataPresent == 'yes') { ?>
            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Search Result</h4>
                </div>
                <div class="panel-body">
                    <table id="patta_lists_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th  class="text-center">Patta ID No</th>                               
                                <th  class="text-center">State</th>
                                <th  class="text-center">District</th>
                                <th  class="text-center">Taluk</th>                           
                                <th  class="text-center">Village</th>
    <!--                                <th  class="text-center">Survey No.</th>-->
                                <th  class="text-center">Patta No.</th>
                                <th  class="text-center">Patta Owner</th>                            
                                <th  class="text-center"></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            if ($patta) {

                                foreach ($patta as $key => $value) {
                                    ?>
                                    <tr>
                                        <?php
                                        if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('patta_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('patta_access', $current_user_id))) {
                                            ?>
                                            <td  class="text-center"><a href="<?= url('land-details-entry/patta/view?patta_uniq_no=' . $value['id'] . '&view=true'); ?>" ><?= $value['id'] ?></a></td>                                 
                                        <?php } else { ?>
                                            <td  class="text-center"> <?= $value['id']; ?></td>
                                        <?php } ?>
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
            <!--                                        <td  class="text-center"><?php
                                        $survey_id = trim($value['survey_id']);
                                        echo ($survey_id) ? $survey_name = App\Models\LandDetailsManagement\SurveyModel::where(['id' => "$survey_id"])->value('survey_no') : '';
                                        ?></td>-->
                                        <td  class="text-center"><?= $value['patta_no'] ?></td>
                                        <td  class="text-center"><?= $value['patta_owner'] ?></td>
                                        <td  class="text-center"><div class="action-buttons">
                                                <?php
                                                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('patta_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('patta_access', $current_user_id))) {
                                                    ?>
                                                    <a title="Edit" href="<?= url('land-details-entry/patta/edit?patta_uniq_no=' . $value['id']) ?>">
                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>
                                                <?php } ?>
                                                &nbsp;&nbsp;
                                                <?php
                                                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('patta_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('patta_access', $current_user_id))) {
                                                    ?>
                                                    <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $_SERVER['QUERY_STRING'] ?>', '<?= $value['id'] ?>');">
                                                        <i class="ace-icon fa fa-times bigger-130"></i>
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
                </div>
            </div>
        <?php } ?>
        <!-- End .panel -->
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>