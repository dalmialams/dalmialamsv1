<?php $__env->startSection('content'); ?>
<!-- .page-content -->
<?php echo $__env->make('admin.LandEntryManagement.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div><?php echo Session::get('message'); ?></div>

<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <?php if ($current_registration_data['con_parent'] == 'C') { ?>
        <div class="panel-heading">
            <h4 class="panel-title">Old Registration Details</h4>
        </div>
        <div class="panel-body">
            <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Old Registrtion Nos.</th>
                        <th  class="text-center">Old Purchaser</th>
                        <th  class="text-center">Converted to Legal Entity</th>
                        <th  class="text-center">Date of Conversion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($converted_data as $key => $val) { ?>
                        <tr>
                            <td><?= $val['id']; ?></td>
                            <td>
                                <?php
                                $purchaser_name = $val['purchaser'];
                                $purchaser_name = App\Models\Common\CodeModel::where(['id' => "$purchaser_name", 'cd_type' => 'purchaser_name'])->value('cd_desc');
                                echo $purchaser_name;
                                ?>
                            </td>
                            <td>
                                <?php
                                $legal_entity = $current_registration_data['legal_entity'];
                                $legal_entity_name = App\Models\Common\CodeModel::where(['id' => "$legal_entity", 'cd_type' => 'legal_entity'])->value('cd_desc');
                                echo $legal_entity_name;
                                ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($current_registration_data['regn_date'])); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } elseif ($current_registration_data['con_parent'] == 'Y') { ?>
        <div class="panel-heading">
            <h4 class="panel-title">New Registration Details</h4>
        </div>
        <div class="panel-body">
            <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">New Registrtion Nos.</th>
                        <th  class="text-center">New Purchaser</th>
                        <th  class="text-center">Converted to Legal Entity</th>
                        <th  class="text-center">Date of Conversion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($converted_data as $key => $val) { ?>
                        <tr>
                            <td><?= $val['id']; ?></td>
                            <td>
                                <?php
                                $purchaser_name = $val['purchaser'];
                                $purchaser_name = App\Models\Common\CodeModel::where(['id' => "$purchaser_name", 'cd_type' => 'purchaser_name'])->value('cd_desc');
                                echo $purchaser_name;
                                ?>
                            </td>
                            <td>
                                <?php
                                $legal_entity = $val['legal_entity'];
                                $legal_entity_name = App\Models\Common\CodeModel::where(['id' => "$legal_entity", 'cd_type' => 'legal_entity'])->value('cd_desc');
                                echo $legal_entity_name;
                                ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($val['regn_date'])); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>