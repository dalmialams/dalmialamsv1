

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
                <?php echo Form::open(['url' => url('land-details-entry/land-document/list'),'class' => 'form-horizontal land-doc-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


                <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" >

                            <label class="col-lg-5 col-md-3 control-label"> Document Type </label>
                            <div class="col-lg-7 col-md-9">
                               <?php echo e(Form::select('land_document[search_document_type_id]', isset($document_type_list) ?$document_type_list : '' , isset($search_document_type_id) ? $search_document_type_id : '',array('class'=>'form-control select2-minimum ' ))); ?>

                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group ">

                            <label class="col-lg-5 col-md-3 control-label">Document Id</label>
                            <div class="col-lg-7 col-md-9">                       
                                <?php echo e(Form::text('land_document[search_document_id]', isset($search_document_id) ? $search_document_id : '', array('class'=>'form-control','placeholder' => 'Document ID '))); ?> 
                            </div>

                        </div>

                    </div>

                    <div class="row ">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" >

                            <label class="col-lg-5 col-md-3 control-label"> Property ID </label>
                            <div class="col-lg-7 col-md-9">
                               <?php echo e(Form::select('land_document[search_property_id]', isset($property_id_list) ?$property_id_list : '' , isset($search_property_id) ? $search_property_id : '',array('class'=>'form-control select2-minimum ' ))); ?>

                            </div>

                        </div>

                    </div>
                    <!-- End .row -->

                </div>
                <!-- End .form-group  -->

                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" value="search" name="search_land_document" class="btn btn-success">Search</button>
                                <a href="<?= url('land-details-entry/land-document/list') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <!-- End .form-group  -->
        </div>


        <?php //if ($dataPresent == 'yes') { ?>
            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading" style="display: flex;align-items: center;">
                    <h4 class="panel-title">Result</h4>
                    <a href="<?= url('land-details-entry/land-document/add') ?>" style="margin-left: 76%;"> <button type="button" class="btn btn-success pull-right" > <i class="fa fa-plus"></i> Add Land Document</button></a>
                </div>
                <div class="panel-body">
                    <table id="land_document_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th  class="text-center"> Document ID </th>                               
                                <th  class="text-center"> Document Type </th>
                                <th  class="text-center"> Associated Property Id </th>
                                <th  class="text-center"> Physical File Location </th>                           
                                <th  class="text-center"> Locker Number</th>
                                <th  class="text-center"> Uploaded By </th>
                                <th  class="text-center"> Date Of Upload </th>                            
                                <th  class="text-center"> Action </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            if ($land_document_list) {

                                foreach ($land_document_list as $key => $value) {
                                    ?>
                                    <tr>
                                        <?php
                                        if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('land_document_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('land_document_access', $current_user_id))) {
                                            ?>
                                            <td  class="text-center"><a href="<?= url('land-details-entry/land-document/view?land_doc_id=' . encrypt($value['land_doc_id']) . '&view=true'); ?>" > <?php echo e($value['document_no']); ?> </a></td>                                 
                                        <?php } else { ?>
                                            <td  class="text-center"> <?php echo e($value['document_no']); ?> </td>
                                        <?php } ?>

                                        <td  class="text-center"><?php echo e($value['document_type_name']); ?></td>
                                        </td>

                                        <td  class="text-center"> <?php echo e($value['property_name']); ?>

                                        </td>

                                        <td  class="text-center"> <?php echo e($value['physical_file_loaction']); ?>

                                        </td>

                                        <td  class="text-center"><?php echo e($value['locker_no']); ?></td>
                                        </td>
           
                                        <td  class="text-center"> <?php echo e($value['uploaded_by']); ?> </td>

                                        <td  class="text-center"> <?php echo e(isset($value['uploaded_date']) ? date('d-m-Y', strtotime($value['uploaded_date'])):''); ?>  </td>

                                        <td  class="text-center"><div class="action-buttons">
                                                <?php
                                                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('land_document_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('land_document_access', $current_user_id))) {
                                                     ?>

                                                    <a title="Edit" href="<?= url('land-details-entry/land-document/edit?land_doc_id=' . encrypt($value['land_doc_id'])) ?>"> <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>

                                                <?php } ?>
                                                &nbsp;&nbsp;
                                                <?php
                                                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('land_document_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('land_document_access', $current_user_id))) {
                                                    ?>

                                                    <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?php echo e(encrypt($value['land_doc_id'])); ?>');">
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
        <?php //} ?>
        <!-- End .panel -->
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\dalmia_lams\resources\views/admin/LandDocumentManagement/land_document/list.blade.php ENDPATH**/ ?>