<div class="row">
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <!-- Start .panel -->     
        <div class="panel-body">
            <?php if (isset($viewMode) && $viewMode == 'true') { ?>
                <a href="<?= isset($patta_uniq_no) && $patta_uniq_no ? url('land-details-entry/patta/view?patta_uniq_no=' . $patta_uniq_no . '&view=' . $viewMode) : url('land-details-entry/registration/add') ?>" class="btn <?= isset($section) && ($section == 'patta') ? "btn-primary" : "btn-default" ?>  mr5">Patta Entry</a>
                <?php if (isset($patta_uniq_no) && $patta_uniq_no) { ?>
                    <?php
                    if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('patta_mutation_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('patta_access', $current_user_id))) {
                        ?>  
                        <a href="<?= isset($patta_uniq_no) && $patta_uniq_no ? url('land-details-entry/patta/mutation?patta_uniq_no=' . $patta_uniq_no . '&view=true') : url('land-details-entry/registration/add') ?>" class="btn <?= isset($section) && ($section == 'mutation') ? "btn-primary" : "btn-default" ?> mr5">Patta Mutation</a>            
                    <?php }
                } ?>
    <!--<div class="pull-right mr5 text-danger" style="font-size: large;"><?= isset($unique_id_number) && $unique_id_number ? $unique_id_number : '' ?></div> -->      
            <?php } else { ?>
                <a href="<?= isset($patta_uniq_no) && $patta_uniq_no ? url('land-details-entry/patta/edit?patta_uniq_no=' . $patta_uniq_no) : url('land-details-entry/registration/add') ?>" class="btn <?= isset($section) && ($section == 'patta') ? "btn-primary" : "btn-default" ?>  mr5">Patta Entry</a>
                <?php if (isset($patta_uniq_no) && $patta_uniq_no) { ?>
                    <?php
                    if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('patta_mutation_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('patta_access', $current_user_id))) {
                        ?>  
                        <a href="<?= isset($patta_uniq_no) && $patta_uniq_no ? url('land-details-entry/patta/mutation?patta_uniq_no=' . $patta_uniq_no) : url('land-details-entry/registration/add') ?>" class="btn <?= isset($section) && ($section == 'mutation') ? "btn-primary" : "btn-default" ?> mr5">Patta Mutation</a>

                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</div>