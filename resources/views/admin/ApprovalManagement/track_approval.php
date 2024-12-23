<?php
if($status != '') {
	if($status == 'rejected'){
	 $message_label = 'Reason For Rejection';
	}else if($status == 'approved'){
	 $message_label = 'Reason For Approval';
	}


	?>
<div class="panel panel-primary">
    <!-- Start .panel -->
    <div class="panel-body">

       <form method="post" class="form-horizontal user-form" enctype="multipart/form-data" name="approval" action="<?= url('approval-management/approval/track-submit-data')?>">
	   <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
			 <div class="col-lg-12">
						<div class="row ">
                        <!-- Start .row -->

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label class="col-lg-7 col-md-4 control-label" style="font-size: 16px;"><?= $message_label ?></label>                        
                        </div>
                    
				</div>
			</div>

 <div class="col-lg-12">
						<div class="row ">
                        <!-- Start .row -->

                    

                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"> Remarks</label>
                            <div class="col-lg-7 col-md-9">
 								 <textarea rows="4" cols="12" id="apt_remarks" name="apt_remarks" required="required" class="form-control col-md-7 col-xs-12 textarea-label"></textarea>
						   </div>
                        </div>
				</div>
			</div>				

        <!-- End .form-group  -->
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">     
        <input type="hidden" name="action_status" value="<?= isset($status) ? $status : '' ?>">     
        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Save</button>                           
                        <a href="<?= url('approval-management/approval/track') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
       </form>
    </div>

</div>
<?php
} ?>


    <div class="row">

        <div class="col-lg-12">
            <!-- col-lg-12 start here -->

            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Approval Lists</h4>
                </div>
                <div class="panel-body">
                    <table id="tabletools"  class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>                               
								<th class="text-center">Sr. No</th>
								<th class="text-center">Type</th>
								<th class="text-center">Year</th>
								<th class="text-center">Month</th>
								<th class="text-center">Title</th>
								<th class="text-center">Description</th>
								<th class="text-center">Remarks</th>
								<th class="text-center">Attachment</th>
								<th width="80">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($apr_data_list) {
                                foreach ($apr_data_list as $key => $value) {
									$apt_item_id = $value['apt_item_id'];	
									$approval_result = App\Models\Approval\ApprovalModel::where(['id' => "$apt_item_id"])->get()->toArray();	
									$approval_data = $approval_result[0];
                                    ?>
                                    <tr>
										<td><?= $key+1 ?>
                                        <td class="text-center"><?= $approval_data['app_type'] ?></td>
                                        <td class="text-center"><?= $approval_data['app_year'] ?></td>
                                        <td class="text-center"><?= $approval_data['app_month'] ?></td>
                                        <td class="text-center"><?= $approval_data['app_title'] ?></td>
                                        <td class="text-center"><?= $approval_data['app_desc'] ?></td>
                                        <td class="text-center"><?= $value['apt_remarks'] ?></td>										
										<td></td>
										 <td class="center" style="vertical-align: middle;">
									<?php if ($value['apt_accept_status'] == "pending") {?>											
									<a href="<?= url('approval-management/approval/track/' . $value['id'].'/approved') ?>" id="<?php echo $value['id'].'/approved';?>" class="btn btn-success btn-xs remarks_text"><i class="fa fa-check" aria-hidden="true"></i> Approve</a>
									<a href="<?= url('approval-management/approval/track/' . $value['id'].'/rejected') ?>" id="<?php echo $value['id'].'/rejected';?>" style="width: 77px;" class="btn btn-danger btn-xs remarks_text"><i class="fa fa-times" aria-hidden="true"></i> Reject</a>
									<?php }?>

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

            <!-- End .panel -->
        </div>
    </div>