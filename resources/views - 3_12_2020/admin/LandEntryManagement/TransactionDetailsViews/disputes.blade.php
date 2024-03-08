
<table class="table table-striped survey_list_table">
    <thead>
        <tr>
            <th class="text-center">Survey No</th>                                                                              
            <th class="text-center">Reminder Date</th>
            <th class="text-center">Next Hearing Date</th>
            <th class="text-center">Litigation Type</th>
            <th class="text-center">Remarks</th>
        </tr>
    </thead>
    <tbody class="append">
        <?php
        //  $ceiling_surveys = '';
        if ($disputes_details) {
            foreach ($disputes_details as $key => $value) {
                $dispute_id = $value['disputes_id'];
                ?>
                <tr class="parent_tr">
                    <td class="text-center"><?= $value['survey_no'] ?></td>                                  
                    <td class="text-center"> 
                        <?php
                        $reminder_date = \App\Models\Transaction\DisputesModel::where(['id' => $dispute_id])->value('reminder_date');
                        echo date('d/m/Y', strtotime($reminder_date));
                        ?>
                    </td>
                    <td class="text-center"> 
                        <?php
                        $next_hear_date = \App\Models\Transaction\DisputesModel::where(['id' => $dispute_id])->value('next_hear_date');
                        echo date('d/m/Y', strtotime($next_hear_date));
                        ?>

                    </td>
                    <td class="text-center"> 
                        <?php
                        //$litigation_type = trim($value['litigation_type']);
                        $litigation_type = \App\Models\Transaction\DisputesModel::where(['id' => $dispute_id])->value('litigation_type');
                        echo $litigation_type_name = App\Models\Common\CodeModel::where(['id' => "$litigation_type"])->value('cd_desc');
                        ?>
                    </td>
                    <td class="text-center"> 
                        <?php
                        echo $description = \App\Models\Transaction\DisputesModel::where(['id' => $dispute_id])->value('description');
                        ?>

                    </td>
                </tr>

                <?php
            }
        }
        ?>

    </tbody>
</table>