<style>
.v-exists{
color:red;	
}
.sorting:before {
    content: none !important;
}
table.table {
    margin-top: 0px !important;
}
.sorting_asc:before {
    content: none !important;
}
.read-mode{
 pointer-events: none;
    opacity: 0.4;	
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

<div><?php echo Session::get('message'); ?></div>

<div class="panel panel-primary">

    <!-- Start .panel -->
    <div class="panel-body <?php if(!empty($shpTables->plot_data[0])){ echo "";}?>">

<form name="shapeForm" method="post" class="form-horizontal user-form" enctype="multipart/form-data" action="<?= url('document-management/document/submit-data') ?>" autocomplete="off">
<input type="hidden" name="shp_type" value="colony_boundary">
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
 
 <div class="col-lg-12">
           
  <div class="row">					
				
 
			<!-- Start .row -->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
					<label class="col-lg-5 col-md-3 control-label" for="">Upload Shape File</label>
					<div class="col-lg-7 col-md-9">
						<input type="file" name="shape_file_doc" required class="filestyle" data-buttonText="Upload" data-buttonName="btn-danger" data-iconName="fa fa-plus">
						<!--<small>Allowed Types: pdf, mp4</small>-->
					</div>
				</div>	  
			
			
				
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Upload</button>                           
                        <a href="<?= url('document-management/document/colony-boundary') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>

				
            </div>
            <!-- End .row -->
			
			 
			
			
			
        </div>

        </form>
    </div>

</div>


<div class="row">
	<div class="col-lg-12">
		<!-- col-lg-12 start here -->
		<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
			<!-- Start panel -->
			<div class="panel-heading">
				<h4 class="panel-title mg-left">Shape File List</h4>
				<h4 class="panel-title mg-right"><a class="btn btn-success" href="<?= url('document-management/document/manage-shape-data/colony_boundary') ?>">Manage Colony Boundary</a></h4>
			</div>
			<div class="panel-body">
				<table id="shape_data_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Sr. No</th>
						<th>File Name</th>
						<!--<th>Modified File Name</th>-->
						<th>User Name</th>
						<th>Uploaded On</th>
						<th>Imported</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>				
				<?php 
				
						 if(!empty($shpHisTables)){
						foreach ($shpHisTables as $key => $shp_history) {
							$created_id = $shp_history->created_id;
							$user_name = App\Models\User\UserModel::where(['id' => "$created_id"])->value('user_name');
							if($shp_history->imported == 'N'){
								$sty_class = 'danger'; 
							}else if($shp_history->imported == 'Y'){
								$sty_class = 'success'; 
							}else{
								$sty_class = ''; 
							}

						
				     ?>
						<tr>
							<td><?php echo $key+1;?></td>
							<td><?php echo $shp_history->zip_file_name;?></td>
							<!--<td><?php echo $shp_history->modified_file_name;?></td>-->
							<td><?php echo $user_name;?></td>
							<td><?php echo $shp_history->created_at;?></td>
							 <td><button class="btn btn-sm btn-<?= $sty_class ?>"><?php
                                echo ($shp_history->imported == 'N') ? "No" : "Yes";
                                ?></button>
                            </td>
							<td>
								<div class="action-buttons">
									 
										<a style="color:#488d48" title="View" href="<?= url('document-management/document/shape-file-view/' . $shp_history->id .'/' . $shp_history->shp_type); ?>">
											<i class="ace-icon fa fa-eye bigger-130"></i>
										</a>
									&nbsp;&nbsp;
									
										<a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $shp_history->shp_type ?>','<?= $shp_history->id ?>')">
											<i class="ace-icon fa fa-times bigger-130"></i>
										</a>
									
								</div>
							</td>
						</tr>
					<?php } 
					
					} ?>					
				</tbody>	
				</table>
			  
			</div>
		</div>
		<!-- End .panel -->
	</div>
</div>
<?php echo e(HTML::script('assets/js/jquery-2.1.1.min.js')); ?>

<script>	
$(document).ready(function () {
	$('#shape_data_table').DataTable({
		"scrollX": true,
	});
	
});
$('#shape_data_table tbody').on('mouseover', 'tr', function () {
$('[data-toggle="tooltip"]').tooltip({
	trigger: 'hover',
	html: true
});
});
</script>