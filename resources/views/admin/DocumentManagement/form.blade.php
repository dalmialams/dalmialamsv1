<div class="panel panel-primary">
    <!-- Start .panel -->
    <div class="panel-body">

<form name="approval" method="post" class="form-horizontal user-form" enctype="multipart/form-data" action="<?= url('document-management/document/list') ?>" autocomplete="off">
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
 
 <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"> Document Type</label>
                    <div class="col-lg-7 col-md-9">
						<select class="form-control col-md-7 col-xs-12 select2-minimum" id="document_type" name="document_type" placeholder="Select">
							<option value="">Select</option>
							<?php foreach ($doc_type_master as $key=>$list) { ?>
							<option value="<?php echo $list['id']; ?>" <?php if (isset($document_type) && $document_type == $list['id']){ echo ' selected="selected"';}?>><?php echo $list['cd_desc']; ?></option>
							<?php } ?>
						</select>                    
					</div>

                </div>	
				
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"> Physical Location</label>
                    <div class="col-lg-7 col-md-9">
						<select class="form-control col-md-7 col-xs-12 select2-minimum" id="document_location" name="document_location" placeholder="Select">
							<option value="">Select</option>
							<?php foreach ($doc_location as $key=>$list) { ?>
							<option value="<?php echo $list['physical_location']; ?>" <?php if (isset($document_location) && $document_location == $list['physical_location']){ echo ' selected="selected"';}?>><?php echo $list['physical_location']; ?></option>							
							<?php } ?>
						</select>                    
					</div>

                </div>					
			
				
				
				
				
				
				
</div>	

  <div class="row">					
				
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"> Uploaded (From)</label>
                    <div class="col-lg-7 col-md-9">
					 <div class="input-group">
					                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="start_date" id="start_date" value="<?php if (isset($start_date) && $start_date != '01-01-1970'){ echo $start_date;}else{ echo '';}?>" id="" class="form-control datepicker" placeholder="select date">
								</div>
				   </div>
                </div>
				
			
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"> Uploaded (to)</label>
                    <div class="col-lg-7 col-md-9">
					 <div class="input-group">
					                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="end_date" id="end_date" value="<?php if (isset($end_date) && $end_date != '01-01-1970'){ echo $end_date;}else{ echo '';}?>" id="" class="form-control datepicker" placeholder="select date">
								</div>
				   </div>
                </div>  


  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Search</button>                           
                        <a href="<?= url('document-management/document/list') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>

				
            </div>
            <!-- End .row -->
			
			 
			
			
			
        </div>

        </form>
    </div>

</div>



    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="row">
            <div class="col-lg-12">
                <!-- col-lg-12 start here -->
                <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
                    <!-- Start .panel -->
                    <div class="panel-heading">
                        <h4 class="panel-title">Document List</h4>
                    </div>
                    <div class="panel-body">
                        <table id="tabletools" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
									<th class="text-center">Sr.No</th>
                                    <th  class="text-center">Registration No</th>
                                    <th  class="text-center">Document Type</th>
                                    <th  class="text-center">Document Physical Location</th>
                                    <th  class="text-center">Uploaded Document</th>
                                    <th  class="text-center">Date of Creation</th>
                                    <th  class="text-center">Remarks</th>  
                                </tr>
                            </thead>

                            <tbody>
                                <?php if ($all_docs) {
									foreach ($all_docs as $key => $value) {
                                    ?>
                                    <tr>
										<td class="text-center"><?= $key+1 ?></td>
                                        <td class="text-center">
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('registration_view', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
												$reg_no = trim($value['registration_id']);											
												$reg_unique_no = App\Models\LandDetailsManagement\RegistrationModel::where(['id' => "$reg_no"])->value('id');                  
											   ?>
                                                <a href="<?= url('land-details-entry/registration/view?reg_uniq_no=' . $reg_unique_no . '&view=true'); ?>" ><?= $reg_unique_no ?></a>
                                                <?php
                                            } else {
                                                echo $reg_unique_no;
                                            }
                                            ?>
                                        </td>
							
                                        <td class="text-center"><?php
                                            $type = trim($value['type']);
                                            echo $type_name = App\Models\Common\CodeModel::where(['id' => "$type"])->value('cd_desc');
                                            ?>
                                        </td>
                                        <td class="text-center"><?= $value['physical_location'] ?></td>
                                        <td class="text-center">
                                            <?php
                                            $file_path = $doc_file_path = str_replace('\\', '/', $value['path']);
											$doc_name = basename($file_path);											
                                            $file_name = stristr($file_path, '/');
                                            $file_type = $value['file_type'];
                                            if (file_exists($file_path)) {?>
                                            <div id="project_downloads">
													<table  class="table  table-bordered table-hover">
														<tbody>
															
																	<tr>
																		<td>
																			<?= $doc_name ?> 
																		</td>
																		<td class="center">
																			
																			<button class="btn btn-xs btn-success" type="button" onclick=" win = window.open('<?= url($file_path) . '?viewMode=' . $viewMode ?>', '_blank', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1024,height=768');win.location" title="View">
																			<i class="fa fa-eye bigger-120" aria-hidden="true"></i>
																			</button>  					
																			
																			
																			
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
										 <td  class="text-center"><?php echo (($value['created_at'])? date('d-m-Y',strtotime($value['created_at'])):'N/A'); ?></td>							
                                        <td  class="text-center"><?= $value['remarks'] ?></td> 
             
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                      
                    </div>
                </div>
                <!-- End .panel -->
            </div>
        </div>
    </div>

