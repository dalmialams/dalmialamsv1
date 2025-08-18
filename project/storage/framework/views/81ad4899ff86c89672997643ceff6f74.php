

<?php $__env->startSection('content'); ?>
<!-- .page-content -->

<div class="row">
    <div><?php echo Session::get('message'); ?></div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="row">
            <div class="panel panel-primary  toggle panelMove panelClose panelRefresh text-right">
                <div class="panel-body">
                    <a href="<?= url('land-details-entry/land-document/list');?>" class="btn btn-primary mr5 mb10"><i class="glyphicon glyphicon-list"></i> Lists</a>
                    <a href="<?= url('land-details-entry/land-document/edit?land_doc_id=' . encrypt($land_document_info['land_doc_id']));?>" class="btn btn-primary mr5 mb10"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                </div>
            </div>
        </div>
        <?php if ($land_document_info) { ?>
            <div class="panel panel-primary ">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Land Document Details</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="30%"><strong> Document ID </strong></td>
                                <td><?= $land_document_info['document_no'] ?></td>
                            
                                <td><strong>Document Type </strong></td>
                                <td>
                                    <?php echo e($land_document_info['document_type_name']); ?>

                                </td>
                            </tr>
                            <tr>
                                <td><strong> Associated Property Id </strong></td>
                                <td>
                                    <?php echo e($land_document_info['property_name']); ?>

                                </td>
                            
                                <td><strong> Physical File Location </strong></td>
                                <td> <?php echo e($land_document_info['physical_file_loaction']); ?> </td>
                            </tr>
                            <tr>
                                <td><strong>Locker Number </strong></td>
                                <td> <?php echo e($land_document_info['locker_no']); ?> </td>
                            
                                <td><strong>Uploaded By  </strong></td>
                                <td> <?php echo e($land_document_info['uploaded_by']); ?> </td>
                            </tr>
                            <tr>
                                <td><strong>Date Of Upload</strong></td>
                                <td> <?php echo e(isset($land_document_info['uploaded_date']) ? date('d-m-Y', strtotime($land_document_info['uploaded_date'])):''); ?>  </td>
                            
                               
                            </tr>
                            


                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-primary ">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title"> Document List </h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped" id="view_land_doc_list_table">
                        <thead>

                            <tr>
                                <th class="text-center">Sr. No</th>
                                <th class="text-center">File name </th>                                          
                                
                                <th class="text-center"> Download </th>
                            
                            </tr>
                        </thead>
                        <tbody class="append">
                                <?php if(isset($document_list) && !empty($document_list)): ?>
                                    <?php $__currentLoopData = $document_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="parent_tr">
                                            <td class="text-center"><?php echo e($key+1); ?> </td>
                                            <td class="text-center"><?php echo e($value); ?> </td> 
                                            <td class="text-center"><a href="<?php echo e(url($land_document_info['file_path'].$value)); ?>" target="_blank"><i class="ace-icon fa fa-download bigger-130"></i></a> </td> 
                                        </tr>
                                    
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

       
        
        

    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\dalmia_lams\resources\views/admin/LandDocumentManagement/land_document/view.blade.php ENDPATH**/ ?>