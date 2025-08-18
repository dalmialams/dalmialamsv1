
<table class="table table-striped survey_list_table">
    <thead>
        <tr>
            <th class="text-center">Survey No</th>                                                                              
            <th class="text-center">New Patta No</th>
            <th class="text-center">New Patta Owner</th>
        </tr>
    </thead>
    <tbody class="append">
        <?php
        //  $ceiling_surveys = '';
        if ($mutation_details) {
            foreach ($mutation_details as $key => $value) {
                $mutation_id = $value['mutation_id'];
                ?>
                <tr class="parent_tr">
                    <td class="text-center"><?= $value['survey_no'] ?></td>                                  
                    <td class="text-center"> 
                        <?php
                        echo $new_patta_no = App\Models\Transaction\MutationModel::where(['id' => $mutation_id])->value('new_patta_no');
                        ?>
                    </td>
                    <td class="text-center"> 
                        <?php
                        echo $new_patta_owner = App\Models\Transaction\MutationModel::where(['id' => $mutation_id])->value('new_patta_owner');
                        ?>
                    </td>
                </tr>

                <?php
            }
        }
        ?>

    </tbody>
</table>