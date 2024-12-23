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
<div>{!! Session::get('message')!!}</div>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
	<?php
	$shp_lebel = '';	
	$shp_link = '';
	if($shp_type == 'mining_lease_boundary'){
		$shp_lebel = '(Mining Lease Boundary)';
		$shp_link = 'mining-lease-boundary';
	}elseif($shp_type == 'plant_boundary'){
		$shp_lebel = '(Plant Boundary)';
		$shp_link = 'plant-boundary';
	}elseif($shp_type == 'colony_boundary'){
		$shp_lebel = '(Colony Boundary)';
		$shp_link = 'colony-boundary';
	}elseif($shp_type == 'truckyard'){
		$shp_lebel = '(Truckyard)';
		$shp_link = 'truckyard';
	}elseif($shp_type == 'railway_sliding_boundary'){
		$shp_lebel = '(Railway Sliding Boundary)';
		$shp_link = 'railway-sliding-boundary';
	}elseif($shp_type == 'approach_road'){
		$shp_lebel = '(Approach Road)';
		$shp_link = 'approach-road';
	}elseif($shp_type == 'conveyor_belt'){
		$shp_lebel = '(Conveyor Belt)';
		$shp_link = 'conveyor-belt';
	}elseif($shp_type == 'railway_track'){
		$shp_lebel = '(Railway Track)';
		$shp_link = 'railway-track';
	}elseif($shp_type == 'crusher_location'){
		$shp_lebel = '(Crusher Location)';
		$shp_link = 'crusher-location';
	}else{
	    $shp_lebel = '';	
		$shp_link = '';
	}
	
	?>
    <div class="panel-heading">
        <h4 class="panel-title mg-left">Shape Data List</h4>
		<h4 class="panel-title mg-right"><a class="btn btn-success" href="<?= url('document-management/document/'.$shp_link) ?>">Shape File List <?= $shp_lebel ?></a></h4>
    </div>
    <div class="panel-body">
        <table id="village_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th  class="text-center">No</th> 
                    <th  class="text-center">Type </th>
                    <th  class="text-center">Action </th>

                </tr>
            </thead>
            <tbody>
                <?php
                if ($shape_data) {
					//t($villageList);die;
                    foreach ($shape_data as $key => $value) {
                        ?>
                        <tr>
                            <td  class="text-center"><?= ++$key ?></td>
                            <td  class="text-center"><?php
                                echo $shp_type;
                                ?>
                            </td>
                            
                            <td class="text-center">
							<a onclick="return confirm('Do you want to remove ?');" title="Remove" href="<?= url('document-management/document/manage-shape-remove/'.$shp_type.'/'.$value->ogc_fid) ?>"><i class="ace-icon fa fa-remove bigger-130"></i></a>
							</td>

                        </tr>
                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
	
    </div>
</div>

