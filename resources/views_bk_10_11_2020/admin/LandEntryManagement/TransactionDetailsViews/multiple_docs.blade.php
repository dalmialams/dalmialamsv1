<?php
//  $ceiling_surveys = '';
if ($multiple_docs) {
    $file_exist_status = 0;
    foreach ($multiple_docs as $key => $value) {
        $file_path = isset($value['file_path']) ? $value['file_path'] : '';
        $file_path = str_replace('\\', '/', $file_path);
        $file_name = stristr($file_path, '/');
        $file_type = $value['file_type'];
        if (file_exists($file_path)) {
            $file_exist_status++;
        }
    }
    if ($file_exist_status > 0) {
        ?>
        <table class="table table-striped survey_list_table">
            <thead>
                <tr>

                    <th class="text-center">View Doc</th>
                </tr>
            </thead>
            <tbody class="append">
                <?php
                //  $ceiling_surveys = '';

                foreach ($multiple_docs as $key => $value) {
                    ?>
                    <tr class="parent_tr">


                        <td class="text-center">
                            <?php
                            $file_path = isset($value['file_path']) ? $value['file_path'] : '';
                            $file_path = str_replace('\\', '/', $file_path);
                            $file_name = stristr($file_path, '/');
                            $file_type = $value['file_type'];
                            if (file_exists($file_path)) {
                                if ($file_type !== 'pdf') {
                                    $modal_id = 'myModal' . $key;
                                    ?>
                                    <button type="button" class="btn btn-default mr5 mb10" data-toggle="modal" data-target="#<?= $modal_id ?>"><?= str_replace("/", "", $file_name) ?></button>
                                    <div class="modal fade" id="<?= $modal_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" style="margin: 55px auto 0;">
                                            <div class="modal-content">
                                                <!--                                            <div class="modal-header">
                                                                                                <button type="button" class="close" data-dismiss="modal">
                                                                                                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                                                                </button>
                                                                                                <h4 class="modal-title" id="myModalLabel2"><?= str_replace("/", "", $file_name) ?></h4>
                                                                                            </div>-->
                                                <div class="modal-body">
                                                    <p>
                                                        <video width="200" height="150" controls>
                                                            <source src="<?= url($file_path) . '?viewMode=' . 'true' ?>" type="video/<?= $file_type ?>">
                                                        </video> 
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        $file_path = 'ViewerJS/#../' . $file_path;
                                        ?>
                                        <a href="javascript:void(0);"  onclick=" win = window.open('<?= url($file_path) . '?viewMode=' . 'true' ?>', '_blank', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1024,height=768');
                                                win.location"><button type="button" class="btn btn-default"><?= str_replace("/", "", $file_name) ?></button>&nbsp</a>

                                        <?php
                                    }
                                } else {
                                    ?>

                                <?php } ?>
                        </td>
                    </tr>

                    <?php
                }
                ?>

            </tbody>
        </table>
    <?php
    } else {
        echo 'Docs does not exist/not uploaded';
    }
} else {
    ?>
    No docs uploaded
<?php } ?>