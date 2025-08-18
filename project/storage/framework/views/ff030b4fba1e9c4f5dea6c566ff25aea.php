<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<?php $__env->startSection('content'); ?>

<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->propertyError->all();
}
?>


<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-heading">
        <h4 class="panel-title">Master Data - Property List</h4>
    </div>
    <div class="panel-body">
        <?php echo $__env->make('admin.MasterDataManagement.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <table id="master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th  class="text-center">No</th>
                    <th  class="text-center">Code</th>
                    <th  class="text-center"> Property Name </th>
                    <th  class="text-center"> Location </th>
                    <th  class="text-center"> Address</th>
                    <th  class="text-center"> State</th>
                    <th  class="text-center"> City </th>
                    <th  class="text-center"> Type </th>
                    <th  class="text-center"> Active </th>
                    <th  class="text-center">Action <a href="<?php echo e(url('master/property/management/add')); ?>" class="btn btn-info pull-right">Add</a></th>

                </tr>
            </thead>

            <tbody>
                <?php
                if ($propertyList) {
                    foreach ($propertyList as $key => $value) {
                        ?>
                        <tr>
                            <td  class="text-center"><?= ++$key ?></td>
                            <td  class="text-center"> <?php echo e($value->propertyId ?? ''); ?> </td>
                            <td  class="text-center"> <?php echo e($value->property_name ?? ''); ?> </td>
                            <td  class="text-center"> <?php echo e($value->property_location?? ''); ?> </td>

                            <td  class="text-center"> <?php echo e($value->property_address?? ''); ?> </td>

                            <td  class="text-center"> <?php echo e($value->state_name?? ''); ?> </td>
                                
                            </td>

                            <td  class="text-center"> <?php echo e($value->city_name ?? ''); ?>

                            </td>

                            <td  class="text-center"> <?php echo e($value->property_type ?? ''); ?>

                            </td>
                            
                            <td  class="text-center"> <?php echo e(isset($value->fl_archive) && $value->fl_archive == 'N' ? "Yes" : "No"); ?> 
                            </td>

                            <td  class="text-center">
                                <a href="<?php echo e(URL::to('master/property/management/edit/'.encrypt($value->propertyId))); ?>"  > <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
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
<!--<script type="text/javascript" src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\dalmia_lams\resources\views/admin/MasterDataManagement/property.blade.php ENDPATH**/ ?>