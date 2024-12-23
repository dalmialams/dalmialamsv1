<style>
.down-color{ color:#6969d4; }
a:hover, a:focus {
    color: #000 !important;
    text-decoration: underline;
}
.mg-left{
	display: inline-block;
    float: left;
}
.mg-right{
	display: inline-block;
    float: right;
}
</style>



<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-heading">
        <h4 class="panel-title mg-left">Village List</h4>
		<h4 class="panel-title mg-right"><a class="btn btn-success" href="<?= url('document-management/document/shape-file-list') ?>">Shape File List (Survey Plot)</a></h4>
    </div>
    <div class="panel-body">
        <table id="village_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th  class="text-center">No</th> 
                    <th  class="text-center">Code </th>
                    <th  class="text-center">State</th>
                    <th  class="text-center">District</th>
                    <th  class="text-center">Block</th>
                    <th  class="text-center">Village</th>
                    <th  class="text-center">Map Available</th>
                    <th  class="text-center">Active</th>
                    <th  class="text-center">Action </th>

                </tr>
            </thead>
<!--            <tfoot>
                <tr>
                    <th  class="text-center">No</th>
                      <th  class="text-center">State</th>
                    <th  class="text-center">District</th>
                    <th  class="text-center">Block</th>
                    <th  class="text-center">Village</th>
                    <th  class="text-center">Action</th>
                </tr>
            </tfoot>-->
            <tbody>
                <?php
                if ($villageList) {
					//t($villageList);die;
                    foreach ($villageList as $key => $value) {
                        ?>
                        <tr>
                            <td  class="text-center"><?= ++$key ?></td>
                            <td  class="text-center"><?php
                                echo $value->id;
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                if (isset($value->getState)) {
                                    echo $value->getState->state_name;
                                }
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                if (isset($value->getDistrict)) {
                                    echo $value->getDistrict->district_name;
                                }
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                if (isset($value->getBlock)) {
                                    echo $value->getBlock->block_name;
                                }
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                echo $value->village_name;
                                ?>
                            </td>
							
							<td  class="text-center"><?php
                                echo ($value->map_exists == 'Y') ? "Yes" : "No";
                                ?>
                            </td>

                            <td  class="text-center"><?php
                                echo ($value->fl_archive == 'N') ? "Yes" : "No";
                                ?>
                            </td>
                            <td class="text-center">
							<!--<a href="<?= url('document-management/document/manage-village-export/'.$value->id) ?>" class="down-color" title="Village Map View"><i class="ace-icon fa fa-download bigger-130"></i></a>&nbsp;&nbsp;-->
							
							<a onclick="return confirm('Do you want to export this village ?');" href="<?= url('document-management/document/manage-village-export/'.$value->id) ?>" class="down-color" title="Export Village Shape"><i class="ace-icon fa fa-download bigger-130"></i></a>&nbsp;&nbsp;
							<a onclick="return confirm('Do you want to remove all survey data from this village ?');" title="Remove Survey From Village" href="<?= url('document-management/document/manage-village-remove/'.$value->id) ?>"><i class="ace-icon fa fa-remove bigger-130"></i></a>
							</td>

                        </tr>
                        <?php
//                                  t( $value->getBlock->block_name,1);;
                    }
                }
                ?>

            </tbody>
        </table>
	
    </div>
</div>

