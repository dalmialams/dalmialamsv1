<?php if ($allRegistrationData) { ?>
    <table class="table table-bordered">
        <thead>

            <tr>
                <th></th>
                <th class="text-center">Registration No.</th>                               
                <th class="text-center">Document Type</th>                               
                <th class="text-center">Physical Location</th>                               
                <th class="text-center">Uploaded Document</th>
            </tr>
        </thead>
        <tbody class="append">
            <?php
            if ($allRegistrationData) {
                foreach ($allRegistrationData as $key => $value) {
                    $name_field = 'hypothecate[docs][' . $value['id'] . ']';
                    $file_path = str_replace('\\', '/', $value['path']);
                    $file_name = stristr($file_path, '/');
                    $file_type = $value['file_type'];
                    ?>
                    <tr>
                        <?php if (file_exists($file_path)) {?>
                        <td  class="text-center"> <?php echo e(Form::checkbox($name_field, $value['id'])); ?></td>
                        <?php }else{?>
                        <td></td>
                        <?php }?>
                        <td class="text-center"><?= $value['registration_id']; ?></td>
                        <td  class="text-center"><?php
                            $type = trim($value['type']);
                            echo $type_name = App\Models\Common\CodeModel::where(['id' => "$type", 'cd_type' => 'document_type'])->value('cd_desc');
                            ?>
                        </td>
                        <td  class="text-center"><?= $value['physical_location'] ?></td>
                        <td  class="text-center">
                            <?php
                            if (file_exists($file_path)) {
                                if ($file_type == 'mp4' || $file_type == 'ogg') {
                                    $id = 'myModal' . $key;
                                    ?>
                                    <button type="button" class="btn btn-default mr5 mb10" data-toggle="modal" data-target="#<?= $id ?>"><?= str_replace("/", "", $file_name) ?></button>
                                    <div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel2"><?= str_replace("/", "", $file_name) ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        <video width="560" height="400" controls>
                                                            <source src="<?= url($file_path) . '?viewMode=' . $viewMode ?>" type="video/<?= $file_type ?>">
                                                        </video> 
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    $file_path = 'ViewerJS/#../' . $file_path;
                                    ?>
                                    <a href="javascript:void(0);"  onclick=" win = window.open('<?= url($file_path) . '?viewMode=' . $viewMode ?>', '_blank', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1024,height=768');
                                                                win.location"><button type="button" class="btn btn-default"><?= str_replace("/", "", $file_name) ?></button>&nbsp</a>
                                           <!--<a href="<?= url('download-file?path=' . $file_path) ?>"><?= str_replace("/", "", $file_name) ?>&nbsp<i class="glyphicon glyphicon-download-alt"></i></a>-->
                                    <?php /* str_replace("/", "", $file_name) */ ?>
                                    <?php
                                }
                            } else {
                                ?>
                                Document does not exist
                            <?php } ?>
                        </td>

                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>
    <?php
}?>