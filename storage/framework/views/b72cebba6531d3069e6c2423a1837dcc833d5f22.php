<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<?php $__env->startSection('content'); ?>
<style>
.select2-container-multi .select2-choices .select2-search-field input {
    padding: 5px;
    margin: 1px 0;
    /* font-family: sans-serif; */
    font-size: 90%;
    color: #666;
    outline: 0;
    border: 0;
    box-shadow: none;
    background: transparent !important;
}
</style>
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->blockError->all();
}
?>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <?php
    if ($mesages) {
        foreach ($mesages as $key => $value) {
            ?>
            <div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong><?php echo $value; ?>!</strong></div>

            <?php
        }
    }
    ?>   
    <div><?php echo Session::get('message'); ?></div>
    <!-- Start .panel -->

</div>

<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-heading">
        <h4 class="panel-title"> Audit Log</h4>
    </div>

    <div class="panel-body">
        <!-- -->
		<?php echo Form::open(['url' => url('master/audit/audit-log'),'class' => 'form-horizontal contact-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form','autocomplete'=>'off']); ?>

		  <div class="col-lg-12">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                     
                        <div class="col-lg-2 col-md-2">
							<select class="form-control select2 select2-minimum"  name="user[]" multiple placeholder="Users">
							<?php $user = isset($user)?explode("','",$user):array();
							$module = isset($module)?explode("','",$module):array();
							$action = isset($action)?explode("','",$action):array();
							?>
							<?php foreach($users as $ulist): ?>
							<option value="<?=isset($ulist->id)?$ulist->id:0?>" <?php if(isset($user)&& in_array($ulist->id,$user)){echo"selected";}?>>
							<?=isset($ulist->user_name)?$ulist->user_name:''?>
							</option>
							
							<?php endforeach; ?>
							</select>
                        </div>
						<div class="col-lg-2 col-md-2">
							<select  placeholder="Modules" class="form-control select2 select2-minimum" multiple  name="module[]" >
							<option value="T_LAND_CONVERSION" <?php if(isset($module)&& in_array('T_LAND_CONVERSION',$module)){echo"selected";}?>>Conversion</option>
							<option value="T_DISPUTES" <?php if(isset($module)&& in_array('T_DISPUTES',$module)){echo"selected";}?>>Disputes</option>
							<option value="T_HYPOTHECATION" <?php if(isset($module)&& in_array('T_HYPOTHECATION',$module)){echo"selected";}?>>Hypothecation</option>
							<option value="T_LAND_CEILING" <?php if(isset($module)&& in_array('T_LAND_CEILING',$module)){echo"selected";}?>>Land Celling</option>
							<option value="T_LAND_EXCHANGE" <?php if(isset($module)&& in_array('T_LAND_EXCHANGE',$module)){echo"selected";}?>>Land Exchange</option>
							<option value="T_INSPECTION" <?php if(isset($module)&& in_array('T_INSPECTION',$module)){echo"selected";}?>>Land Inspection</option>
							<option value="T_LAND_RESERVATION" <?php if(isset($module)&& in_array('T_LAND_RESERVATION',$module)){echo"selected";}?>>Land Reservation</option>
							<option value="T_LEASE" <?php if(isset($module)&& in_array('T_LEASE',$module)){echo"selected";}?>> Lease</option>
							<option value="T_MINING_LEASE" <?php if(isset($module)&& in_array('T_MINING_LEASE',$module)){echo"selected";}?>>Mining Lease</option>
							<option value="T_OPERATION" <?php if(isset($module)&& in_array('T_OPERATION',$module)){echo"selected";}?>>Operation</option>
							<option value="T_MUTATION" <?php if(isset($module)&& in_array('T_MUTATION',$module)){echo"selected";}?>>Mutation</option>
							<option value="T_FAMILY" <?php if(isset($module)&& in_array('T_FAMILY',$module)){echo"selected";}?>>Owner</option>
							<option value="T_PATTA" <?php if(isset($module)&& in_array('T_PATTA',$module)){echo"selected";}?>>Patta</option>
							<option value="T_REGISTRATION" <?php if(isset($module)&& in_array('T_REGISTRATION',$module)){echo"selected";}?>>Registration</option>
							<option value="T_SURVEY" <?php if(isset($module)&& in_array('T_SURVEY',$module)){echo"selected";}?>>Survey</option>
							
							
							
							
							</select>
                        </div>
                      
						
                        <div class="col-lg-2 col-md-2">
							<input type="text"  class="form-control basic-datepicker" name="from_date" value="<?=isset($from_date) && $from_date!=''?date('d/m/Y',strtotime($from_date)):''?>" placeholder="From date">
                        </div>
						
						
						
                        <div class="col-lg-2 col-md-2">
							<input type="text" class="form-control basic-datepicker" name="to_date" value="<?=isset($to_date) && $to_date!=''?date('d/m/Y',strtotime($to_date)):''?>" placeholder="To date">
                        </div>
						
						  <div class="col-lg-2 col-md-2">
							<select class="form-control select2 select2-minimum" multiple  name="action[]" placeholder="Action Taken">
							<option value="All" <?php if(isset($action) && in_array('All',$action)){ echo"selected";}?>>All</option>
							<option value="I" <?php if(isset($action) && in_array('I',$action)){ echo"selected";}?>>Add</option>
							<option value="U" <?php if(isset($action) && in_array('U',$action)){ echo"selected";}?>>Update</option>
							<option value="D" <?php if(isset($action) && in_array('D',$action)){ echo"selected";}?>>Delete</option>
							
							</select>
                        </div>
						<div class="col-lg-2 col-md-2">
						 <button type="submit" id="" class="btn btn-sm btn-info pull-left" >Search</button>
						 <a style="margin-left:3px;" href="" class="btn btn-sm btn-warning pull-left" >Reset</a>
						 </div>
                    </div>
					
                </div>
            </div>
		<!-- -->
		  <?php echo Form::close(); ?>

        <table id="master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
				  <tr>
					<th>Sl. No.</th>
					<th>User</th>
					<th>Table</th>	
					<th>Action</th>
					<th>Description</th>					
					<!--<th>Original Field</th>
					<th>Changed Fields</th> -->                                         
					<th>IP Address</th>
					<th>Action Taken At</th>

                </tr>
            </thead>
            <tbody>
									
				<?php if(isset($list) && !empty($list)): ?>
				<?php foreach($list as $k=>$infos): ?>
					
				 <tr>
					<td><?php echo e($k+1); ?></td>
					<td>
					<?php
					 if(array_search($infos->session_user_name,$commonkeylist)){ 
							echo array_search($infos->session_user_name,$commonkeylist);
						} else { echo $infos->session_user_name;} ?>
					</td>
					<td><?php echo e(isset($infos->table_name)?str_replace('T_','',$infos->table_name):''); ?></td>
					
					<td>
						<?php
						if (isset($infos->action) && $infos->action == 'I')
							echo 'Add';
						else if ($infos->action &&  $infos->action == 'U')
							echo "Update";
						?>
					</td>
					<td><span class="custom_underline" onmouseover ="auditLogDistribution('<?php echo $infos->event_id ?>')">View</td>
					
					 <td><?php echo e($infos->client_addr); ?></td>
				   
				
					
					<td><?php echo e(date('d/m/Y H:i:A',strtotime($infos->action_tstamp_tx))); ?></td>
				</tr>
				
				
				<?php endforeach; ?>
				<?php endif; ?>        
			</tbody>
            
        </table>
    </div>
</div>

  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="displayCostDistributionModal">
                    <div class="modal-dialog" id="displayCostDistributionDetails">

                    </div>
                </div>
<!--<script type="text/javascript" src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>