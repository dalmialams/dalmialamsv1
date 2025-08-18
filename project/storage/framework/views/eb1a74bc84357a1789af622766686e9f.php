<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->land_document->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div><?php echo Session::get('message'); ?></div>
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
            <?php echo Form::open(['url' => url('land-details-entry/land-document/submit-data'),'class' => 'form-horizontal land-document-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"> Document ID  <span class="red" style="color:red">* </span> </label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::text('land_document[document_no]', isset($land_document_data['document_no']) ? $land_document_data['document_no'] : '', array('class'=>'form-control','placeholder' => 'Document ID '))); ?>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label">Document Type <span class="red" style="color:red">* </span></label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::select('land_document[document_type_id]', isset($document_type_list) ?$document_type_list : '' , isset($land_document_data['document_type_id']) ? $land_document_data['document_type_id'] : '',array('class'=>'form-control select2-minimum required' ))); ?>

                        </div>

                    </div>
                </div>
                <div class="row ">

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                        <label class="col-lg-5 col-md-3 control-label"> Associated Property Id <span class="red" style="color:red">* </span></label>
                        <div class="col-lg-7 col-md-9">
                            <?php echo e(Form::select('land_document[property_id]', isset($property_id_list) ?$property_id_list : '' , isset($land_document_data['property_id']) ? $land_document_data['property_id'] : '',array('class'=>'form-control select2-minimum required' ))); ?>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group ">

                        <label class="col-lg-5 col-md-3 control-label"> Physical File Location <span class="red" style="color:red">* </span></label>
                        <div class="col-lg-7 col-md-9">                       
                            <?php echo e(Form::text('land_document[physical_file_loaction]', isset($land_document_data['physical_file_loaction']) ? $land_document_data['physical_file_loaction'] : '', array('class'=>'form-control','placeholder' => 'Physical File Location'))); ?>

                        </div>

                    </div>

                    
                </div>
                <!-- End .row -->

            </div>


            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group ">
                        <label class="col-lg-5 col-md-3 control-label"> Locker Number <span class="red" style="color:red">* </span></label>
                        <div class="col-lg-7 col-md-9">  

                            <?php echo e(Form::text('land_document[locker_no]', isset($land_document_data['locker_no']) ? $land_document_data['locker_no'] : '', array('class'=>'form-control','placeholder' => 'Locker Number'))); ?>


                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group ">
                        <label class="col-lg-5 col-md-3 control-label"> Uploaded By </label>
                        <div class="col-lg-7 col-md-9">  

                            <?php echo e(Form::text('land_document[uploaded_by]', isset($user_name) ? $user_name : '', array('class'=>'form-control','readonly' => '','placeholder' => 'Uploaded By '))); ?>


                        </div>
                    </div>
                    <!-- End .row -->

                </div>
                
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group ">
                        <label class="col-lg-5 col-md-3 control-label"> Date of Upload </label>
                        <div class="col-lg-7 col-md-9">  

                            <?php echo e(Form::date('land_document[uploaded_date]', isset($land_document_data['uploaded_date']) ? date('Y-m-d', strtotime($land_document_data['uploaded_date'])):'', array('class'=>'form-control ','placeholder' => 'Date of Upload'))); ?>


                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label" for="">Upload Document</label>
                        <div class="col-lg-7 col-md-9">
                            <input type="file" name="doc_file[]" id="efive_doc_file" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus" multiple>
                            <small>Allowed Types: pdf, mp4, jpg, png, xlsx, docx, csv </small>

                            
                            <?php if(isset($document_list) && !empty($document_list)): ?>

                                <button type="button" class="btn btn-default mr5 mb10" data-toggle="modal" data-target="#myModal" style="position: relative;top: 5px;background: #51bf87;color: #ffffff;float: right;">View Doc</button>

                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                </button>

                                                <h4 class="modal-title" id="myModalLabel2"> Document List</h4>
                                                
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped" id="land_doc_list_table">
                                                    <thead>

                                                        <tr>
                                                            <th class="text-center">Sr. No</th>
                                                            <th class="text-center">File name </th>                                          
                                                            <th class="text-center"> Download </th>
                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody class="append">
                                                        
                                                            <?php $__currentLoopData = $document_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="parent_tr">
                                                                    <td class="text-center"><?php echo e($key+1); ?> </td>
                                                                    <td class="text-center"><?php echo e($value); ?> </td> 
                                                                    <td class="text-center"><a href="<?php echo e(url($land_document_data['file_path'].$value)); ?>" target="_blank"><i class="ace-icon fa fa-download bigger-130"></i></a> </td> 
                                                                </tr>
                                                            
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- End .row -->

                </div>
            </div>

            <!-- End .form-group  -->
            <input type="hidden" name="land_id" value="<?= isset($land_document_data['id']) ? encrypt($land_document_data['id']) : '' ?>">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">

                            
                            <?php if(isset($land_document_data['id']) && !empty($land_document_data['id'])) { ?>
                                 <button type="submit" value="update" name="update_land_document" class="btn btn-success">Update</button>  
                            <?php } else{ ?>
                                <button type="submit" value="save" name="save_land_document" class="btn btn-success">Save</button>   
                            <?php } ?>
                            <a href="<?= url('land-details-entry/land-document/list') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
        <!-- End .form-group  -->
</div>
<?php /**PATH C:\wamp64\www\dalmia_lams\resources\views/admin/LandDocumentManagement/land_document/form.blade.php ENDPATH**/ ?>