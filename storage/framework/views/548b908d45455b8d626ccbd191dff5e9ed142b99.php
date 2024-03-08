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

    $mesages = $errors->codeError->all();
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

<div class="panel panel-primary  toggle panelMove panelClose panelRefresh ">
    <!-- Start .panel -->
	<?php  $segment =  Request::segment(5);  ?>
    <div class="panel-heading">
        <h4 class="panel-title">Master Data - <?= isset( $segment)&& $segment!='' ?ucwords(str_replace('_'," ",$segment)) :'' ?></h4>
    </div>
    <div class="panel-body">
        <?php echo $__env->make('admin.MasterDataManagement.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <table id="master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th  class="text-center">No</th>
                    <!--<th  class="text-center">Code Type</th>-->
                    <th  class="text-center">Code </th>
                    <th  class="text-center">Code Description</th>
                    <?php
                    if (Session::has('data'))
                        $data_type = Session::get('data');

                    if ($data_type == 'area_unit') {
                        ?>
                        <th  class="text-center">Conversion value</th>

                        <?php
                    }
                    ?>
                    <th  class="text-center">Active</th>
                    <?php
                    if ($data_type == 'purchaser_name') {
                        ?>
                        <th  class="text-center">Subsidiary</th>

                        <?php
                    }
                    ?>
                    <th  class="text-center">Action <a href="<?php echo e(url('master/code/management/add')); ?>" class="btn btn-info pull-right">Add</a></th>

                </tr>
            </thead>
<!--            <tfoot>
                <tr>
                    <th  class="text-center">No</th>
                    <th  class="text-center">Code Type</th>
                    <th  class="text-center">Code Description</th>
                    <th  class="text-center">Action</th>
                </tr>
            </tfoot>-->
            <tbody>
                <?php
//                t($codeList,1);
                if ($codeList) {
                    foreach ($codeList as $key => $value) {
                        ?>
                        <tr>
                            <td  class="text-center"><?= ++$key ?></td>

                <!-- <td  class="text-center"><?php
                            echo ucwords(str_replace('_', ' ', $value->cd_type))
                            ?>
                </td> -->
                            <td  class="text-center"><?php
                                echo $value->id;
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                echo $value->cd_desc;
                                ?>
                            </td>
                            <?php
                            if ($data_type == 'area_unit') {
                                ?>
                                <td class="text-right">
                                    <?php
                                    echo isset($value->getConvers->convers_value) ? $value->getConvers->convers_value : '';
                                    ?>
                                </td>

                                <?php
                            }
                            ?>
                            <td  class="text-center">
                                <?php
                                echo ($value->cd_fl_archive == 'N') ? "Yes" : "No";
                                ?>
                            </td>
                            <?php if ($data_type == 'purchaser_name') {?>
                                <td class="text-center">
                                    <?php echo ($value->subsidiary == 'N') ? "No" : "Yes";?>
                                </td>
                            <?php } ?>
                            <td  class="text-center"><a href="<?php echo e(URL::to('master/code/management/edit/'.$value->id)); ?>"   ><i class="ace-icon fa fa-pencil bigger-130"></i></a></td>

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>