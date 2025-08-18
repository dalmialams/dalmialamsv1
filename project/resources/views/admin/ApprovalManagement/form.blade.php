<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->user->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div>{!! Session::get('message')!!}</div><br>
<?php
if ($mesages) {
    foreach ($mesages as $key => $value) {
        echo $value;
    }
}
?>   
<style>

	.tags {
    position: absolute;
    /*top: 15px;*/
    left: 27px;
}
.tag1 {
	display: block;
    height: 25px;
    font-size: 13px;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 5.7px;
    padding-bottom: 1px;
    line-height: 1;
    background: #ffc107;
    color: #fff !important;
}

.tag1:after {
    content: " ";
    height: 25px;
    width: 0;
    position: absolute;
    left: 100%;
    top: 0;
    margin: 0;
    pointer-events: none;
    border-top: 14px solid transparent;
    border-bottom: 11px solid transparent;
    border-left: 13px solid #ffc107;
}
	
.tag2 {
	display: block;
    height: 25px;
    font-size: 13px;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 5.7px;
    padding-bottom: 1px;
    line-height: 1;
    background: #1ABB9C;
    color: #fff !important;
}

.tag2:after {
    content: " ";
    height: 25px;
    width: 0;
    position: absolute;
    left: 100%;
    top: 0;
    margin: 0;
    pointer-events: none;
    border-top: 14px solid transparent;
    border-bottom: 11px solid transparent;
    border-left: 13px solid #1ABB9C;
}
.tag3 {
	display: block;
    height: 25px;
    font-size: 13px;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 5.7px;
    padding-bottom: 1px;
    line-height: 1;
    background: #bd2130;
    color: #fff !important;
}
.tag3:after {
    content: " ";
    height: 25px;
    width: 0;
    position: absolute;
    left: 100%;
    top: 0;
    margin: 0;
    pointer-events: none;
    border-top: 14px solid transparent;
    border-bottom: 11px solid transparent;
    border-left: 13px solid #bd2130;
}
.no_pointer{
	pointer-events: none !important;
}

</style>
<div class="panel panel-primary">
    <!-- Start .panel -->
    <div class="panel-body">

<form name="approval" method="post" class="form-horizontal user-form" enctype="multipart/form-data" action="<?= url('approval-management/approval/submit-data') ?>" autocomplete="off">
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
 
 <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Year</label>
                    <div class="col-lg-7 col-md-9">
					 <div class="input-group">
					                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="approval[app_year]" value="" id="datepicker" class="form-control required" placeholder="Year" required>
								</div>
				   </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Month</label>
                    <div class="col-lg-7 col-md-9">
						<select class="form-control col-md-7 col-xs-12 select2-minimum" id="app_month" name="approval[app_month]" placeholder="Select">
							<option value="">Select</option>
							<?php $mon_count=0;foreach ($month_list as $key=>$list) { $mon_count++; ?>
							<option value="<?php echo $key; ?>"><?php echo $list; ?></option>
							<?php } ?>
						</select>                    
					</div>

                </div>

            </div>
            <!-- End .row -->
			
			  <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Title</label>
                    <div class="col-lg-7 col-md-9">
								<input type="text" name="approval[app_title]" value="" class="form-control" placeholder="Title" required>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Type</label>
                    <div class="col-lg-7 col-md-9">
	<select class="form-control select2-minimum" id="app_type" name="approval[app_type]" required>
								<option value="">select</option>
								<option value='MA'>MA
								</option>
								<option value='EMA'>EMA
								</option>
								<option value='Grocery'>Grocery
								</option>
								</select> 
								</div> 

                </div>

            </div>
			
			  <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Description</label>
                    <div class="col-lg-7 col-md-9">
                   <textarea class="form-control required" rows="4" cols="13" name="approval[app_desc]" placeholder="Description"></textarea>
				   </div>
                </div>
				  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label" for=""><span class="red" style="color:red">* </span> File Upload</label>
                        <div class="col-lg-7 col-md-9">
                            <input type="file" name="upload_doc" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus" required>
                            <small>Allowed Types : pdf, doc, docs, xls, xlsx, csv </small>
                        </div>
                    </div>  
            </div>
			
        </div>

        <!-- End .form-group  -->
        <input type="hidden" name="id" value="<?= isset($approval_data['id']) ? $approval_data['id'] : '' ?>">          
        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Save</button>                           
                        <a href="<?= url('approval-management/approval/add') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        </form>
    </div>

</div>

<!-- Approval track history -->

<?php
//$users = '';
if (!empty($history_apr_list)) {
	
    ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- col-lg-12 start here -->

            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Approval History</h4>
                </div>
                <div class="panel-body">
                    <table id="tabletools"  class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>                               
								<th width="150" class="center">Status</th>
								<th class="text-center">Initiated By</th>
								<th class="text-center">User</th>
								<th class="text-center">Date/Time</th>
								<th class="text-center">Remarks</th>					
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($history_apr_list) {
								$i = false;
								$rmv_dup = '';
								$action_date = '';
								$apt_remarks ='';
                                foreach ($history_apr_list as $key => $value) {
									
					$recipient_role = $value->apt_recipient_role;
					$apt_crt_date = App\Models\Approval\ApprovalModel::where(['id' => $value->apt_item_id])->value('created_at');
					
					$apr_crt_id =  $history_apr_list[0]->apt_user_id;
					
					$initiator_name = App\Models\User\UserModel::where(['id' => $apr_crt_id])->value('user_name');
					//echo $initiator_name;die;
					
									if($recipient_role == 4){
									$recipient_name = App\Models\Role\Role::where(['id' => $recipient_role])->value('name');
									}else if($recipient_role == 8){
									$recipient_name = App\Models\Role\Role::where(['id' => $recipient_role])->value('name');
									}if($recipient_role == 9){
									$recipient_name = App\Models\Role\Role::where(['id' => $recipient_role])->value('name');
									}			
									
									if($value->apt_accept_status == 'pending'){
					$status = ucwords($value->apt_accept_status);
					$button_class= 'btn btn-warning btn-xs no-pointer';
					$iclass = 'fa fa-clock-o';		
                    $tag_class = 'tag1';					
				}else if($value->apt_accept_status == 'approved'){
					$status = ucwords($value->apt_accept_status);	
					$button_class= 'btn btn-success btn-xs no-pointer';
					$iclass = 'fa fa-check';	
                    $tag_class = 'tag2';					
                    $action_text = 'on: '.date('d-M-Y',strtotime($apt_crt_date));					
				}else if($value->apt_accept_status == 'rejected'){
					$status = ucwords($value->apt_accept_status);
					$button_class= 'btn btn-danger btn-xs no-pointer';
					$iclass = 'fa fa-times';
                    $tag_class = 'tag3';					
                    $action_text = 'on: '.date('d-M-Y',strtotime($apt_crt_date));
				/*if($value->apt_action_date != null){
					$action_date = date('d-m-Y',strtotime($value->apt_action_date)).'<br> on 'date('H:i:a',strtotime($value->apt_action_date));
				}else{ $action_date = '';}*/
				}
				$i = false;
				if(!$rmv_dup || $initiator_name != $rmv_dup) {
				$i = true;
				}
				$rmv_dup = $initiator_name;					
				
				?>
									
									<tr>
								<td class="text-center" style="line-height: 13px;">


								<div class="tags">
								<a href="" class="<?= $tag_class ?>">
								<i class="<?= $iclass ?>"></i><?= $status ?>
								</a>
								</div>
								</td>
								<?php
								 if($i == true){?>
								<td class="text-center"><span><?= $initiator_name ?></span>
								<br>on: <span><?php echo (($apt_crt_date)? date('d-m-Y',strtotime($apt_crt_date)):'N/A'); ?></span></td>							
								 <?php }else{?>
								<td class="text-center"></td>							
									 
								 <?php } ?>
								 <td class="text-center"><?= $recipient_name ?></td>
								<td class="text-center">
								
								<?php 
								if(!empty($value->apt_action_date)){
								echo (($value->apt_action_date)? date('d-m-Y',strtotime($value->apt_action_date)):'N/A'); ?><br>on <?php echo (($value->apt_action_date)? date('H:i:a',strtotime($value->apt_action_date)):'N/A');?>
								<?php }else{
									echo "N/A";
								}
								?>
								</td>
								<td class="text-center"><?= $value->apt_remarks ?></td>
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
<?php } ?>



<?php
//$users = '';
if (!empty($approval)) {
    ?>
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
                                <th  class="text-center">Year</th>
                                <th  class="text-center">Month</th>
                                <th  class="text-center">Title</th>
                                <th  class="text-center">Type</th>
                                <th  class="text-center">Description</th>
								<th class="text-center">Attachment</th>
                                <th  class="text-center">Initiated By</th>
                                <th  class="text-center">Approval</th>								
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($approval) {
                                foreach ($approval as $key => $value) {
									//t($value);die;
									$id = $value['id'];									
									//$recipient_role = App\Models\Approval\ApprovalProcessTrackModel::where(['apt_item_id' => $id,'apt_accept_status' => 'pending'])->value('apt_recipient_role');									

									$role_data = App\Models\Approval\ApprovalProcessTrackModel::where('apt_item_id',$id)->orderBy('id','desc')->get(); 
									$recipient_role = $role_data[0]->apt_recipient_role;



									$crt_id = $value['crt_id'];									
									$initiator_name = App\Models\User\UserModel::where(['id' => $crt_id])->value('user_name');
									
								
									if($recipient_role == 4){
									$recipient_name = App\Models\Role\Role::where(['id' => $recipient_role])->value('name');
									}else if($recipient_role == 8){
									$recipient_name = App\Models\Role\Role::where(['id' => $recipient_role])->value('name');
									}if($recipient_role == 9){
									$recipient_name = App\Models\Role\Role::where(['id' => $recipient_role])->value('name');
									}
									
                                    ?>
                                    <tr>
                                        <td  class="text-center"><?= $value['app_year'] ?></td>
                                        <td  class="text-center"><?= $value['app_month'] ?></td>
                                        <td  class="text-center"><?= $value['app_title'] ?></td>
                                        <td  class="text-center"><?= $value['app_type'] ?></td>
                                        <td  class="text-center"><?= $value['app_desc'] ?></td>
                                <td  class="text-center">
                                    <?php
                                    $file_path = isset($value['path']) ? $value['path'] : '';
                                    $file_path = str_replace('\\', '/', $file_path);
									$doc_name = basename($file_path);											

                                    $file_name = stristr($file_path, '/');
                                    $file_type = $value['file_type'];
                                    if (file_exists($file_path)) { ?>
                                         <div id="project_downloads">
													<table  class="table  table-bordered table-hover">
														<tbody>
															
																	<tr>
																		<td>
																			<?= $doc_name ?> 
																		</td>
																		<td class="center">												
																			<button class="btn btn-xs btn-info" type="button" onclick="window.open('<?= url('download-file?path=' . $file_path) ?>')" title="Download">
																			<i class="fa fa-download bigger-120"></i>
																			</button>  									
																		</td>																		
																	</tr>
																	
															
														</tbody>
													</table>
												</div>
                                    <?php } else {
                                        ?>
                                        Document does not exist
                                    <?php } ?>
                                </td>										
										
			
										<td  class="text-center"><?= $initiator_name ?><br>on: <?= date('d-M-Y',strtotime($value['created_at'])) ?></td>
										
										<td class="text-center" style="vertical-align: middle;">
										<?php if($value['app_status'] == 'pending'){?>
										<button class="btn btn-warning btn-xs no_pointer"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo ucwords($value['app_status']);?> From <?= $recipient_name ?></button>
										<a href="<?= url('approval-management/approval/track-history/' . $value['id']) ?>" title="Approval History" class="btn btn-primary btn-xs track_history" style="background-color: #080806;"><i class="fa fa-history" aria-hidden="true"></i> Track</a>
										<?php }else if($value['app_status'] == 'approved'){?>
										<button class="btn btn-success btn-xs no_pointer"><i class="fa fa-check" aria-hidden="true"></i> <?php echo ucwords($value['app_status']);?></button>
										<a href="<?= url('approval-management/approval/track-history/' . $value['id']) ?>" title="Approval History" class="btn btn-primary btn-xs track_history" style="background-color: #080806;"><i class="fa fa-check-circle" aria-hidden="true"></i> Approval History</a>
										<?php }else if($value['app_status'] == 'rejected'){?>
										<button class="btn btn-danger btn-xs no_pointer"><i class="fa fa-times" aria-hidden="true"></i> <?php echo ucwords($value['app_status']);?> By <?= $recipient_name ?></button>
										<a href="<?= url('approval-management/approval/track-history/' . $value['id']) ?>" title="Approval History" class="btn btn-primary btn-xs track_history" style="background-color: #080806;"><i class="fa fa-history" aria-hidden="true"></i> Track</a>
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
<?php } ?>

