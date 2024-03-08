<div class="row " id="noprint">
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <!-- Start .panel -->     
        <div class="panel-body">
            <?php if (isset($viewMode) && $viewMode == 'true') { ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('registration_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/view?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : url('land-details-entry/registration/add') ?>" class="btn <?= isset($section) && ($section == 'registration') ? "btn-primary" : "btn-default" ?>  mr5">Registration</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('survey_no_details_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/survey/view?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'survey') ? "btn-primary" : "btn-default" ?> mr5">Survey No Details</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('document_upload_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>
                    <a  href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/document/view?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'document') ? "btn-primary" : "btn-default" ?> mr5">Document Upload</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('payment_details_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>  
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/payment/view?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'payment') ? "btn-primary" : "btn-default" ?> mr5">Payment Details</a>
                <?php } ?>
				
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('lease_details_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>   
                    <?php if (isset($purchase_type_id) && $purchase_type_id == 'CD00144') { ?>
                        <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/lease/view?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'lease') ? "btn-primary" : "btn-default" ?> mr5">Lease Details</a>
                        <?php
                    }
                }
                ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('geo_tag_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>         
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/survey-lat-long/geo-view?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'survey_lat_long') ? "btn-primary" : "btn-default" ?> mr5">Geo Tag</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('transaction_details_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>  
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/transaction-details?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'transaction') ? "btn-primary" : "btn-default" ?> mr5">Transaction Details</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('audit_details_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>  
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/audit-details?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'audit') ? "btn-primary" : "btn-default" ?> mr5">Audit Details</a>
                <?php } ?>

                <?php if ($registration_converted_flag == 'Y') { ?>
                    <?php
                    if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('new_reg_no_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                        ?> 
                        <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/converted-details?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'converted') ? "btn-primary" : "btn-default" ?> mr5">New Reg No.</a>
                    <?php
                    }
                } elseif ($registration_converted_flag == 'C') {
                    ?>
                    <?php
                    if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('old_reg_no_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                        ?> 
                        <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/converted-details?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'converted') ? "btn-primary" : "btn-default" ?> mr5">Old Reg No.</a>
                    <?php
                    }
                }
                ?>

                <?php if ($registration_converted_flag == 'Y') { ?>
                    <div class="pull-right mr5 text-danger" id="blinkeffect" style="font-size: large;"><strong>CONVERTED</strong></div>
                <?php } else { ?>
                    <div class="pull-right mr5 text-danger" style="font-size: large;"><?= isset($reg_uniq_no) && $reg_uniq_no ? $reg_uniq_no : '' ?></div>
                <?php } ?>
    <!--<div class="pull-right mr5 text-danger" style="font-size: large;"><?= isset($unique_id_number) && $unique_id_number ? $unique_id_number : '' ?></div> -->      
            <?php } else { ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('registration_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/edit?reg_uniq_no=' . $reg_uniq_no) : url('land-details-entry/registration/add') ?>" class="btn <?= isset($section) && ($section == 'registration') ? "btn-primary" : "btn-default" ?>  mr5">Registration</a>
                <?php } ?> 
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('survey_no_details_add', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/survey/add?reg_uniq_no=' . $reg_uniq_no) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'survey') ? "btn-primary" : "btn-default" ?> mr5">Survey No Details</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('document_upload_add', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>
                    <a  href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/document/add?reg_uniq_no=' . $reg_uniq_no) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'document') ? "btn-primary" : "btn-default" ?> mr5">Document Upload</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('payment_details_add', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>  
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/payment/add?reg_uniq_no=' . $reg_uniq_no) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'payment') ? "btn-primary" : "btn-default" ?> mr5">Payment Details</a>
                <?php } ?>
				
				
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('lease_details_add', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>  
                    <?php if (isset($purchase_type_id) && $purchase_type_id == 'CD00144') { ?>
                        <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/lease/add?reg_uniq_no=' . $reg_uniq_no) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'lease') ? "btn-primary" : "btn-default" ?> mr5">Lease Details</a>
                        <?php
                    }
                }
                ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('geo_tag_add', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>      

                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'survey_lat_long') ? "btn-primary" : "btn-default" ?> mr5">Geo Tag</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('transaction_details_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>   
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/transaction-details?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'transaction') ? "btn-primary" : "btn-default" ?> mr5">Transaction Details</a>
                <?php } ?>
                <?php
                if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('audit_details_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                    ?>   
                    <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/audit-details?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'audit') ? "btn-primary" : "btn-default" ?> mr5">Audit Details</a>
                <?php } ?>
    <!--<div class="pull-right mr5 text-danger" style="font-size: large;"><?= isset($unique_id_number) && $unique_id_number ? $unique_id_number : '' ?></div>-->

                <?php if ($registration_converted_flag == 'Y') { ?>
                    <?php
                    if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('new_reg_no_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                        ?>  
                        <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/converted-details?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'converted') ? "btn-primary" : "btn-default" ?> mr5">New Reg No.</a>
                    <?php } ?>
                <?php } elseif ($registration_converted_flag == 'C') { ?>
                    <?php
                    if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('old_reg_no_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                        ?>  
                        <a href="<?= isset($reg_uniq_no) && $reg_uniq_no ? url('land-details-entry/registration/converted-details?reg_uniq_no=' . $reg_uniq_no . '&view=' . $viewMode) : 'javascript:void(0);' ?>" class="btn <?= isset($section) && ($section == 'converted') ? "btn-primary" : "btn-default" ?> mr5">Old Reg No.</a>
                        <?php
                    }
                }
                ?>

                <?php if ($registration_converted_flag == 'Y') { ?>
                    <div class="pull-right mr5 text-danger" id="blinkeffect" style="font-size: large;"><strong>CONVERTED</strong></div>
                <?php } else { ?>
                    <div class="pull-right mr5 text-danger" style="font-size: large;"><?= isset($reg_uniq_no) && $reg_uniq_no ? $reg_uniq_no : '' ?></div>
    <?php } ?>
<?php } ?>
        </div>
    </div>
</div>