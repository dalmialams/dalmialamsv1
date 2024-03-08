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

    $mesages = $errors->villageError->all();
}
?>


<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-heading">
        <h4 class="panel-title">Master Data - Village List</h4>
    </div>
    <div class="panel-body">
        <?php echo $__env->make('admin.MasterDataManagement.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <table id="master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th  class="text-center">No</th> 
                    <th  class="text-center">Code </th>
                    <th  class="text-center">State</th>
                    <th  class="text-center">District</th>
                    <th  class="text-center">Block</th>
                    <th  class="text-center">Village</th>
                    <th  class="text-center">Map Available</th>
                    <th  class="text-center">Active</th>
                    <th  class="text-center">Action <a href="<?php echo e(url('master/village/management/add')); ?>" class="btn btn-info pull-right">Add</a></th>

                </tr>
            </thead>
<!--            <tfoot>
                <tr>
                    <th  class="text-center">No</th>
                      <th  class="text-center">State</th>
                    <th  class="text-center">District</th>
                    <th  class="text-center">Block</th>
                    <th  class="text-center">Village</th>
                    <th  class="text-center">Action</th>
                </tr>
            </tfoot>-->
            <tbody>
                <?php
                if ($villageList) {
                    foreach ($villageList as $key => $value) {
                        ?>
                        <tr>
                            <td  class="text-center"><?= ++$key ?></td>
                            <td  class="text-center"><?php
                                echo $value->id;
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                if (isset($value->getState)) {
                                    echo $value->getState->state_name;
                                }
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                if (isset($value->getDistrict)) {
                                    echo $value->getDistrict->district_name;
                                }
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                if (isset($value->getBlock)) {
                                    echo $value->getBlock->block_name;
                                }
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                echo $value->village_name;
                                ?>
                            </td>
							
							<td  class="text-center"><?php
                                echo ($value['map_exists'] == 'Y') ? "Yes" : "No";
                                ?>
                            </td>

                            <td  class="text-center"><?php
                                echo ($value->fl_archive == 'N') ? "Yes" : "No";
                                ?>
                            </td>
                            <td  class="text-center"><a href="<?php echo e(URL::to('master/village/management/edit/'.$value->id)); ?>"  ><i class="ace-icon fa fa-pencil bigger-130"></i></a></td>

                        </tr>
                        <?php
//                                  t( $value->getBlock->block_name,1);;
                    }
                }
                ?>

            </tbody>
        </table>
	
    </div>
</div>
<!--<script type="text/javascript" src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>-->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>