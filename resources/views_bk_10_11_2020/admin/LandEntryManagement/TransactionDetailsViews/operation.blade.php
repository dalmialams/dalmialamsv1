
<table class="table table-striped survey_list_table">
    <thead>
        <tr>
            <th class="text-center">Survey No</th>                               
            <th class="text-center">Operation</th>                                          
            <th class="text-center">Remarks</th>                                          


        </tr>
    </thead>
    <tbody class="append">
        <?php
        //  $ceiling_surveys = '';
        if ($operation_details) {
            $survey_id = $operation_details['survey_id'];
            ?>
            <tr class="parent_tr">
                <td class="text-center"><?= App\Models\LandDetailsManagement\SurveyModel::where(['id' => "$survey_id"])->value('survey_no'); ?></td>                                  
                <td class="text-center"> 
                    <?php
                    $operation_type = trim($operation_details['operation_type']);
                    echo $operation_type_name = App\Models\Common\CodeModel::where(['id' => "$operation_type"])->value('cd_desc');
                    ?>
                </td>
                <td class="text-center"> 
                    <?= $operation_details['description']; ?>
                </td>

            </tr>

            <?php
        }
        ?>

    </tbody>
</table>