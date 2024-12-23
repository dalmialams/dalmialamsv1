
<table class="table table-striped survey_list_table">
    <thead>
        <tr>
            <th class="text-center">Survey No</th>                               
            <th class="text-center">Remarks</th>                                          
            <th class="text-center">Encroachment</th>                                          
            <th class="text-center">Encroachment Type</th>                                          
            <th class="text-center">Inspection Date</th>                                          

        </tr>
    </thead>
    <tbody class="append">
        <?php
        //  $ceiling_surveys = '';
        if ($inspection_details) {
            $survey_id = $inspection_details['survey_id'];
            ?>
            <tr class="parent_tr">
                <td class="text-center"><?= App\Models\LandDetailsManagement\SurveyModel::where(['id' => "$survey_id"])->value('survey_no'); ?></td>                                  
                <td class="text-center"> 
                    <?= $inspection_details['description'] ?>
                </td>
                <td class="text-center"> 
                    <?= $inspection_details['encroachment'] == 'Y' ? 'Yes' : 'No'; ?>
                </td>
                <td class="text-center"> 
                    <?php
                    $encroachment_type = trim($inspection_details['encroachment_type']);
                    echo $encroachment_type_name = App\Models\Common\CodeModel::where(['id' => "$encroachment_type"])->value('cd_desc');
                    ?>
                </td>
                <td class="text-center"> 
                    <?= date('d/m/Y', strtotime($inspection_details['insp_date'])); ?>
                </td>
            </tr>

            <?php
        }
        ?>

    </tbody>
</table>