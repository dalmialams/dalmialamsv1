<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->family->all();
}
?>
<style>
    .family-tree{
    overflow:auto;
  }
		.family-tree ul {
     
      padding-top: 20px; 
      position: relative;			
			transition: all 0.5s;
			-webkit-transition: all 0.5s;
      -moz-transition: all 0.5s;
      display:flex;
      flex-wrap: nowrap;
      justify-content: center;
		}
		.family-tree li {
			float: left; text-align: center;
			list-style-type: none;
			position: relative;
			padding: 20px 40px 0 5px;			
			transition: all 0.5s;
			-webkit-transition: all 0.5s;
			-moz-transition: all 0.5s;
    }
		.family-tree li::before, .family-tree li::after{
			content: '';
			position: absolute; top: 0; right: 50%;
			border-top: 2px solid #1e78b1;
			width: 50%; height: 20px;
		}
		.family-tree li::after{
			right: auto; left: 50%;
			border-left: 2px solid #1e78b1;
		}
		.family-tree li:only-child::after, .family-tree li:only-child::before {
			display: none;
		}
		.family-tree li:only-child{ padding-top: 0;}
		.family-tree li:first-child::before, .family-tree li:last-child::after{
			border: 0 none;
		}
		.family-tree li:last-child::before{
			border-right: 2px solid #1e78b1;
			border-radius: 0 5px 0 0;
			-webkit-border-radius: 0 5px 0 0;
			-moz-border-radius: 0 5px 0 0;
		}
		.family-tree li:first-child::after{
			border-radius: 5px 0 0 0;
			-webkit-border-radius: 5px 0 0 0;
			-moz-border-radius: 5px 0 0 0;
		}
		.family-tree ul ul::before{
			content: '';
			position: absolute; top: 0; left: 50%;
			border-left: 2px solid #1e78b1;
			width: 0; height: 20px;
		}
		.family-tree li a{
			border: 1px solid #94a0b4 ;
			padding: 5px 5px;
			text-decoration: none;
			color: #666;
			font-family: arial, verdana, tahoma;
			font-size: 11px;
			display: inline-block;			
			border-radius: 5px;
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;			
			transition: all 0.5s;
			-webkit-transition: all 0.5s;
			-moz-transition: all 0.5s;
    }
    .parallel-label-box{
      width: 90px;
      height: 110px;
      display: inline-block;
      border: 1px solid #ddd;
      margin: 2px;
      background: #fff;
      position: relative;
    }
    .parallel-label-box:after{
      position: absolute;
      content: attr(data-name);
      bottom: 0;
      left:0;
      right:0;
      padding:2px 2px 3px;
      background:rgb(30, 120, 177);
      color:#fff;
      line-height:12px;
    }
    / Family hover disable /
/* 
		.family-tree li a:hover, .family-tree li a:hover+ul li a {
			background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
		}
		.family-tree li a:hover+ul li::after, 
		.family-tree li a:hover+ul li::before, 
		.family-tree li a:hover+ul::before, 
		.family-tree li a:hover+ul ul::before{
			border-color:  #94a0b4;
    }
*/
  .family-tree li a.active{
    background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
    box-shadow: 0px 0 5px 1px rgba(0,0,0,0.5);
  }
  .photo-link{
	  cursor: pointer;
  }
  input[type="radio"], input[type="checkbox"] {
    margin: 10px 0 0;
}
</style>
<div>{!! Session::get('message')!!}</div>
<?php if (!$viewMode) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <?php
        if ($mesages) {
            foreach ($mesages as $key => $value) {
                echo $value;
            }
        }
        ?>   
        <!-- Start .panel -->
        <div class="panel-body">
            <?php if ($reg_uniq_no) { ?>
                {!! Form::open(['url' => url('land-details-entry/family-tree/submit-data'),'class' => 'form-horizontal family-form','method' => 'POST', 'autocomplete'=>'off', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
			<?php if((isset($family_data['gender']) && $family_data['gender']=='Male') || empty($family_data)){?>
			   <div class="col-lg-12" id="hof_div">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
								<input type="checkbox" id="checkbox_1" name="is_hof" class="chk" value="<?= isset($reg_uniq_no) ? $reg_uniq_no : '' ?>" <?php if (isset($family_data['is_hof']) && $family_data['is_hof'] == "Y") {
									echo "checked";
								} ?>>						
								<label class="col-lg-7 col-md-7 control-label">Owner</label>
								<div id="error" class="text-center" style='color:red'></div>
							</div>
					</div>
				</div>              
			<?php } ?>



			   <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Name</label>
                            <div class="col-lg-7 col-md-9">
								<input type="text" name="family[member_name]" value="<?= isset($family_data['member_name'])  ? $family_data['member_name'] : '' ?>" class="form-control" placeholder="Name" required>
						   </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Gender</label>
                            <div class="col-lg-7 col-md-9">
								<select class="form-control select2-minimum" id="gender" name="family[gender]" onchange="get_relation(this)" required>
								<option value="">select</option>
								<option value='Male' <?php if (isset($family_data['gender']) && $family_data['gender'] == "Male") {
																									echo "selected";
																								} ?>>Male
								</option>
								<option value='Female'  <?php if (isset($family_data['gender']) && $family_data['gender'] == "Female") {
																									echo "selected";
																								} ?>>Female
								</option>
								</select>                               

                            </div>

                        </div>
				</div>
			</div>
			
			 <div class="col-lg-12">
                    <div class="row ">
                        <!-- Start .row -->

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Contact Number</label>
                            <div class="col-lg-7 col-md-9">
								<input type="text" name="family[contact_number]" value="<?= isset($family_data['contact_number'])  ? $family_data['contact_number'] : '' ?>" class="form-control numbers_only_restrict" placeholder="Contact Number" maxlength="10" required>
						   </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Religion</label>
                            <div class="col-lg-7 col-md-9">
								<select class="form-control select2-minimum" name="family[religion]" required>
									<option value="">Select</option>
									<option value="Hinduism" <?php if (isset($family_data['religion']) && $family_data['religion'] == "Hinduism"){ echo ' selected="selected"';}?>>Hinduism</option>
									<option value="Islam" <?php if (isset($family_data['religion']) && $family_data['religion'] == "Islam"){ echo ' selected="selected"';}?>>Islam </option>
									<option value="Christianity" <?php if (isset($family_data['religion']) && $family_data['religion'] == "Christianity"){ echo ' selected="selected"';}?>>Christianity </option>													
									<option value="Sikhism" <?php if (isset($family_data['religion']) && $family_data['religion'] == "Sikhism"){ echo ' selected="selected"';}?>>Sikhism </option>													
									<option value="Buddhism" <?php if (isset($family_data['religion']) && $family_data['religion'] == "Buddhism"){ echo ' selected="selected"';}?>>Buddhism </option>													
									<option value="Jainism" <?php if (isset($family_data['religion']) && $family_data['religion'] == "Jainism"){ echo ' selected="selected"';}?>>Jainism </option>	
									<option value="Zoroastrianism" <?php if (isset($family_data['religion']) && $family_data['religion'] == "Zoroastrianism"){ echo ' selected="selected"';}?>>Zoroastrianism </option>	
									<option value="Other" <?php if (isset($family_data['religion']) && $family_data['religion'] == "Other"){ echo ' selected="selected"';}?>>Other </option>
								</select>
                            </div>

                        </div>
				</div>
			</div>			
			
			
			 <div class="col-lg-12">
						<div class="row ">
                        <!-- Start .row -->

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"> Occupation</label>
                            <div class="col-lg-7 col-md-9">
								<input type="text" name="family[occupation]" value="<?= isset($family_data['occupation'])  ? $family_data['occupation'] : '' ?>" class="form-control" placeholder="Occupation">
						   </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"> Qulaification</label>
                            <div class="col-lg-7 col-md-9">
 								<input type="text" name="family[qulaification]" value="<?= isset($family_data['qulaification'])  ? $family_data['qulaification'] : '' ?>" class="form-control" placeholder="Qulaification">
						   </div>
                        </div>
				</div>
			</div>				
			
			 <div class="col-lg-12">
						<div class="row ">
                        <!-- Start .row -->

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Identification Marks</label>
                            <div class="col-lg-7 col-md-9">
  								<input type="text" name="family[identification_marks]" value="<?= isset($family_data['identification_marks'])  ? $family_data['identification_marks'] : '' ?>" class="form-control" placeholder="Identification Marks">                         
						   </div>
                        </div>

                       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                            <label class="col-lg-5 col-md-3 control-label"> Blood Group</label>
                            <div class="col-lg-7 col-md-9">
								<select class="form-control select2-minimum" name="family[blood_group]">
									<option value="">select</option>
									<option value="A+" <?php if (isset($family_data['blood_group']) && $family_data['blood_group'] == "A+"){ echo ' selected="selected"';}?>>A+</option>
									<option value="B+" <?php if (isset($family_data['blood_group']) && $family_data['blood_group'] == "B+"){ echo ' selected="selected"';}?>>B+ </option>
									<option value="O+" <?php if (isset($family_data['blood_group']) && $family_data['blood_group'] == "O+"){ echo ' selected="selected"';}?>>O+ </option>													
									<option value="AB+" <?php if (isset($family_data['blood_group']) && $family_data['blood_group'] == "AB+"){ echo ' selected="selected"';}?>>AB+ </option>													
									<option value="A-" <?php if (isset($family_data['blood_group']) && $family_data['blood_group'] == "A-"){ echo ' selected="selected"';}?>>A- </option>													
									<option value="B-" <?php if (isset($family_data['blood_group']) && $family_data['blood_group'] == "B-"){ echo ' selected="selected"';}?>>B- </option>	
									<option value="O-" <?php if (isset($family_data['blood_group']) && $family_data['blood_group'] == "O-"){ echo ' selected="selected"';}?>>O- </option>	
									<option value="AB-" <?php if (isset($family_data['blood_group']) && $family_data['blood_group'] == "AB-"){ echo ' selected="selected"';}?>>AB- </option>
									</option>
								</select>                               
                            </div>
                        </div>
				</div>
			</div>				
			
			
			
			 <div class="col-lg-12">
						<div class="row ">
                        <!-- Start .row -->

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Present Address</label>
                            <div class="col-lg-7 col-md-9">
  								<textarea name="family[present_address]" class="form-control" placeholder="Present Address" ><?= isset($family_data['present_address'])  ? $family_data['present_address'] : '' ?></textarea>
						   </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Permanent Address</label>
                            <div class="col-lg-7 col-md-9">
   								<textarea name="family[permanent_address]" class="form-control" placeholder="Permanent Address" required><?= isset($family_data['permanent_address'])  ? $family_data['permanent_address'] : '' ?></textarea>                          
							</div>
                        </div>
				</div>
			</div>	
			
			
			
		<div class="row" id="owner_detail" <?php if (isset($family_data['is_hof']) && $family_data['is_hof'] == "N" || !isset($family_data['is_hof'])) { ?> style="display:initial" <?php } else { ?>style="display:none" <?php } ?>>

			 <div class="col-lg-12">
						<div class="row ">
                        <!-- Start .row -->

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Relation With Member</label>
                            <div class="col-lg-7 col-md-9">
							
							<select class="form-control select2-minimum" name="family[relationship_with_owner]" id="relation" required onchange="get_member(this)">
								<option value="">select</option>
								<?php 
								if(isset($id)){																	
									?>
									
								<?php if(isset($family_data['gender']) && $family_data['gender']=='Female'){?>
								<option value='wife'  <?php if (isset($family_data['relationship_with_owner']) && $family_data['relationship_with_owner'] == "wife") {
										echo "selected";
									} ?>>Wife of</option>
								<?php } ?>	
								<?php if(isset($family_data['gender']) && $family_data['gender']=='Male'){?>

								<option value='son' <?php if (isset($family_data['relationship_with_owner']) && $family_data['relationship_with_owner'] == "son") {
										echo "selected";
									} ?>>Son of</option>
																	<?php } ?>	

								<?php if(isset($family_data['gender']) && $family_data['gender']=='Female'){?>
									
								<option value='daughter' <?php if (isset($family_data['relationship_with_owner']) && $family_data['relationship_with_owner'] == "daughter") {
										echo "selected";
									} ?>>Daughter of</option>
								<?php } ?>		
													
			<?php } else {?>					
						<option value='wife'>Wife of</option>
						<option value='son'>Son of</option>								
						<option value='daughter'>Daughter of</option>
								
			<?php } ?>													
							</select>							
							
							
							
							</div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Family Members</label>
                            <div class="col-lg-7 col-md-9">
								<select class="form-control select2-minimum" id="fam_owner_id" name="family[owner_id]" required>
									<option value="">select</option>
									@if(isset($member_dropdown_list) && !empty($member_dropdown_list))
									@foreach($member_dropdown_list as $list)
										<option value="{{$list['id']}}"  <?php if (isset($family_data['owner_id']) && $list['id'] == $family_data['owner_id']) {
															echo "selected";
														} ?>>
											{{$list['member_name']}}
										</option>
									@endforeach
									@endif
								</select>								
							</div>
                        </div>
				</div>
			</div>	
		</div>	
			
			
			<div class="col-lg-12">
			<div class="row ">
			<!-- Start .row -->
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
					<label class="col-lg-5 col-md-3 control-label" for="">Photo</label>
					<div class="col-lg-7 col-md-9">
						<input type="file" name="profile_photo" class="filestyle" data-buttonText="Upload" data-buttonName="btn-danger" data-iconName="fa fa-plus">
						<!--<small>Allowed Types: pdf, mp4</small>-->
					</div>
				</div>	  
			</div>
			</div>
			
                <!-- End .form-group  -->
				<input type="hidden" name="id" id="id" value="<?= isset($id) ? $id : '' ?>">
                <input type="hidden" name="family[registration_id]" id="registration_id" value="<?= isset($reg_uniq_no) ? $reg_uniq_no : '' ?>">				
				<input type="hidden" name="check_is_owner" id='check_is_owner' value="{{(isset($family_data['is_hof']) && $family_data['is_hof'] == 'Y') ? '2' : '1'}}">
								
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php if ($registration_converted_flag != 'Y') { ?>
                                <button type="submit" value="save" name="submit_family" class="btn btn-success">Save</button>
                                <button type="submit" value="save_continue" name="submit_family" class="btn btn-primary">Save & Continue</button>
                                <?php
                                if (count($familyLists) > 0) {
                                    if ($user_type !== 'admin') {
                                        if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('lease_details_add', $current_user_id)) {
                                            if (isset($purchase_type_id) && $purchase_type_id == 'CD00144') {
                                                $skip_url = url('land-details-entry/lease/add?reg_uniq_no=' . $reg_uniq_no);
                                            } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('geo_tag_add', $current_user_id)) {
                                                $skip_url = url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no);
                                            } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('transaction_details_access', $current_user_id)) {
                                                $skip_url = url('land-details-entry/registration/transaction-details?reg_uniq_no=' . $reg_uniq_no);
                                            } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('audit_details_access', $current_user_id)) {
                                                $skip_url = url('land-details-entry/registration/audit-details?reg_uniq_no=' . $reg_uniq_no);
                                            } else {
                                                $skip_url = '';
                                            }
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('geo_tag_add', $current_user_id)) {
                                            $skip_url = url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no);
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('transaction_details_access', $current_user_id)) {
                                            $skip_url = url('land-details-entry/registration/transaction-details?reg_uniq_no=' . $reg_uniq_no);
                                        } else if (\App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('audit_details_access', $current_user_id)) {
                                            $skip_url = url('land-details-entry/registration/audit-details?reg_uniq_no=' . $reg_uniq_no);
                                        } else {
                                            $skip_url = '';
                                        }
                                    } else {
                                        //return redirect('land-details-entry/survey/add?reg_uniq_no=' . $id)->with('message', $msg);
                                        $skip_url = url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no);
                                    }
                                    if ($skip_url) {
                                        ?>
                                        <a href="<?= $skip_url ?>"><button type="button" class="btn btn-warning">Skip</button></a>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-warning disabled">Skip</button>
                                    <?php } ?>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-warning disabled">Skip</button>
                                <?php } ?>
                                <?php }?>
                                <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                <!-- End .form-group  -->
                {!! Form::close() !!}

            <?php } else { ?>
                <div class="alert alert-warning fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="glyphicon glyphicon-warning-sign alert-icon "></i>
                    <strong>Warning!</strong> Please select a proper Registration to add this details.
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php if ($familyLists) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Family Member List</h4>
        </div>
        <div class="panel-body">
            <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Name</th>
                        <th  class="text-center">Gender</th>
                        <th  class="text-center">Contact Number</th>
                        <th  class="text-center">Religion</th>
                        <th  class="text-center">Occupation</th>
                        <th  class="text-center">Qulaification</th>
                        <th  class="text-center">Identification Marks</th>
                        <th  class="text-center">Blood Group</th>
                        <th  class="text-center">Present Address</th>
                        <th  class="text-center">Permanent Address</th>
                        <th  class="text-center">Photo</th> 
						<th  class="text-center"></th>
                        <?php if (!$viewMode) { ?><th  class="text-center"></th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($familyLists) {
                        foreach ($familyLists as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><?= isset($value['member_name'])  ? $value['member_name'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['gender'])  ? $value['gender'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['contact_number'])  ? $value['contact_number'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['religion'])  ? $value['religion'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['occupation'])  ? $value['occupation'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['qulaification'])  ? $value['qulaification'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['identification_marks'])  ? $value['identification_marks'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['blood_group'])  ? $value['blood_group'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['present_address'])  ? $value['present_address'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['permanent_address'])  ? $value['permanent_address'] : '' ?></td>
							    <td  class="text-center">
                                            <?php
                                            $file_path = str_replace('\\', '/', $value['path']);
                                            $file_name = stristr($file_path, '/');
                                            $file_type = $value['file_type'];
                                            if (file_exists($file_path)) {
                                                if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg') {
                                                    $id = 'myModal' . $key;													
                                                    ?>													
                                                    <a class="photo-link" data-toggle="modal" data-target="#<?= $id ?>">
														<img src="<?= url($file_path) . '?viewMode=' . $viewMode ?>" type="image/<?= $file_type ?>" width="80">							
													</a>
                                                    <div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                                    </button>
                                                                    <h4 class="modal-title" id="myModalLabel2"><?= $value['member_name'] ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>
																			<img src="<?= url($file_path) . '?viewMode=' . $viewMode ?>" type="image/<?= $file_type ?>">
                                                                    </p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else {?>
												No Photo Found
                                               <?php }
                                            } else {
                                                ?>
                                                No Photo Found
                                            <?php } ?>
                                        </td>
                                <?php if (!$viewMode) { ?>
                                    <td  class="text-center">
                                        <div class="action-buttons">                                          
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('family_tree_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>                                            
                                                <a title="Edit" href="<?= url('land-details-entry/family-tree/edit?reg_uniq_no=' . $reg_uniq_no . '&id=' . $value['id']); ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                            &nbsp;&nbsp;
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('family_tree_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>   
                                                <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $reg_uniq_no ?>', '<?= $value['id'] ?>');">
                                                    <i class="ace-icon fa fa-times bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                <?php } ?>
								<td><button type="button" class="btn btn-warning" onclick="get_log_details('<?=$value['id']?>','T_FAMILY')">View Log</button></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
               

            </table>

            <?php if ($viewMode) { ?>    
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <a href="<?= url('land-details-entry/registration/list') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


<?php } ?>

<!-- Family Tree -->

<?php if ($familyLists) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Family Tree</h4>
        </div>
        <div class="panel-body">
            
<div class="family-tree">
            <?php
				
			echo $familytree;

			?>
</div>			
			
			
			
			
			
			
			
			
			<?php if ($viewMode) { ?>    
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <a href="<?= url('land-details-entry/registration/list') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


<?php } ?>
 @include('admin.common.common_auditlog_modal')
<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->
{{-- $validator --}}