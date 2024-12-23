
<table class="table table-striped survey_list_table">
    <thead>
        <tr>
            <th class="text-center">Name Of The Purchaser</th>                               
            <th class="text-center">Transfer to Legal Entity </th>                                                                                          
        </tr>
    </thead>
    <tbody class="append">
        <?php
        //  $ceiling_surveys = '';
        if ($conversion_parent_details) {
            $converted_reg_id = $conversion_parent_details['converted_reg_id'];
            $purchser = App\Models\LandDetailsManagement\RegistrationModel::where(['id' => $converted_reg_id])->value('purchaser');
            $purchser_name = App\Models\Common\CodeModel::where(['id' => $purchser])->value('cd_desc');

            $legal_enity_code = App\Models\LandDetailsManagement\RegistrationModel::where(['id' => $converted_reg_id])->value('legal_entity');
            $legaL_enity_name = App\Models\Common\CodeModel::where(['id' => $legal_enity_code])->value('cd_desc');
            ?>
            <tr class="parent_tr">
                <td class="text-center"><?= $purchser_name ?></td>                                  
                <td class="text-center"> 
                    <?= $legaL_enity_name ?>
                </td>

            </tr>

            <?php
        }
        ?>

    </tbody>
</table>