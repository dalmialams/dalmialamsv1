<?php if ($allRegistrationData) { ?>
    <table class="table table-bordered">
        <thead>

            <tr>
                <th class="text-center">Registration No.</th>                               
                <th class="text-center">Legal Entity</th>                               
                <th class="text-center">Name of the Purchaser</th>                               
                <th class="text-center">Purchased Area</th>
                <th class="text-center">Total Cost</th>

            </tr>
        </thead>
        <tbody class="append">
            <?php
            if ($allRegistrationData) {
                foreach ($allRegistrationData as $key => $val) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $val['id'];?></td>
                        <td class="text-center">
                            <?php
                            $legal_entity = $val['legal_entity'];
                            $legal_entity_name = App\Models\Common\CodeModel::where(['id' => "$legal_entity", 'cd_type' => 'legal_entity'])->value('cd_desc');
                            echo $legal_entity_name;
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            $purchaser_name = $val['purchaser'];
                            $purchaser_name = App\Models\Common\CodeModel::where(['id' => "$purchaser_name", 'cd_type' => 'purchaser_name'])->value('cd_desc');
                            echo $purchaser_name;
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            $unit = $val['tot_area_unit'];
                            $unit_name = App\Models\Common\CodeModel::where(['id' => "$unit", 'cd_type' => 'area_unit'])->value('cd_desc');
                            echo $val['tot_area'] . ' (' . $unit_name . ')';
                            ?>
                        </td>
                        <td  class="text-center" style="text-align: right;"><?= number_format($val['tot_cost']) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>
    <?php
}?>