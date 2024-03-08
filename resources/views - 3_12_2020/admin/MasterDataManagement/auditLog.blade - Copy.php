<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

@extends('admin.layouts.adminlayout')
@section('content')

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
    <div>{!! Session::get('message')!!}</div>
    <!-- Start .panel -->

</div>

<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-heading">
        <h4 class="panel-title"> Audit Log</h4>
    </div>

    <div class="panel-body">
        <!-- -->
		{!! Form::open(['url' => url('master/audit/audit-log'),'class' => 'form-horizontal contact-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form','autocomplete'=>'off']) !!}
		  <div class="col-lg-12">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                     
                        <div class="col-lg-2 col-md-2">
							<select class="form-control select2 select2-minimum"  name="user"  placeholder="Select User">
							<option value="">Select</option>
							@foreach($users as $ulist)
							<option value="<?=isset($ulist->id)?$ulist->id:0?>" <?php if(isset($user)&& $user==$ulist->id){echo"selected";}?>>
							<?=isset($ulist->user_name)?$ulist->user_name:''?>
							</option>
							
							@endforeach
							</select>
                        </div>
						<div class="col-lg-2 col-md-2">
							<select  placeholder="Select Module" class="form-control select2 select2-minimum"  name="module" >
							<option value="">Select</option>
							<option value="T_REGISTRATION" <?php if(isset($module)&& $module=='T_REGISTRATION'){echo"selected";}?>>Registration</option>
							<option value="T_SURVEY" <?php if(isset($module)&& $module=='T_SURVEY'){echo"selected";}?>>Survey</option>
							<option value="T_FAMILY" <?php if(isset($module)&& $module=='T_FAMILY'){echo"selected";}?>>Owner</option>
							</select>
                        </div>
                      
						
                        <div class="col-lg-2 col-md-2">
							<input type="text"  class="form-control basic-datepicker" name="from_date" value="<?=isset($from_date) && $from_date!=''?date('d/m/Y',strtotime($from_date)):''?>" placeholder="From date">
                        </div>
						
						
						
                        <div class="col-lg-2 col-md-2">
							<input type="text" class="form-control basic-datepicker" name="to_date" value="<?=isset($to_date) && $to_date!=''?date('d/m/Y',strtotime($to_date)):''?>" placeholder="To date">
                        </div>
						
						  <div class="col-lg-3 col-md-3">
							<select class="form-control select2 select2-minimum"  name="action" placeholder="Action Taken">
							<option value="">Select</option>
							<option value="I" <?php if(isset($action) && $action=='I'){ echo"selected";}?>>Add</option>
							<option value="U" <?php if(isset($action) && $action=='U'){ echo"selected";}?>>Update</option>
							
							</select>
                        </div>
						<div class="col-lg-1 col-md-1">
						 <button type="submit" id="" class="btn btn-sm btn-info pull-left" >Search</button>
						 </div>
                    </div>
					
                </div>
            </div>
		<!-- -->
		  {!! Form::close() !!}
        <table id="master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
				  <tr>
					<th>Sl. No.</th>
					<th>Module</th>
															   
					<th>Original Field</th>
					<th>Changed Fields</th>                                          
					<th>Action Taken</th>
					<th>Action Taken By</th>
					<th>Action Taken At</th>
					<th>IP Address</th>

                </tr>
            </thead>
            <tbody>
									
				@if(isset($list) && !empty($list))
				@foreach($list as $k=>$infos)
					<?php 
						//raw data
						$rawData = $infos->row_data;
						$rawData =  (str_replace('"=>"', '":"', $rawData) );
						$rawData =  ('{' . str_replace('=>', ':', $rawData) . '}');
						$rawData =  (str_replace('NULL', 'null', $rawData));
						$result_arr = json_decode($rawData,1);
						$upd_arr = array();	
						$ne_arr = array();
						$module ='';
						$submodule =''; 
						$projectId='';
						$infos->insert_data =$result_arr; 
						//update 
						$updateData = $infos->changed_fields;
						$updateData =  (str_replace('"=>"', '":"', $updateData) );
						$updateData =  ('{' . str_replace('=>', ':', $updateData) . '}');
						$updateData =  (str_replace('NULL', 'null', $updateData));
						$Updateresult_arr = json_decode($updateData,1);
						$infos->update_data =$Updateresult_arr; 	
						
					?>
				 <tr>
					<td>{{$k+1}}</td>
					<td>{{isset($infos->table_name)?str_replace('T_','',$infos->table_name):''}}</td>
					<td>
					@foreach($infos->insert_data as $kk=>$detls)
					 @if(isset($kk) && $kk!='')
					 <button type="button" class="btn btn-xs btn-outline btn-secondary mb-4">
						<span style="font-size: 14px;font-weight: 900;">
						<?php if(array_search($kk,$commonkeylist)){ 
							echo array_search($kk,$commonkeylist);
						} else { echo $kk;} 
						?>
						</span>
						<?php if(array_search($detls,$commonkeylist)){ 
							echo array_search($detls,$commonkeylist);
						} else { echo $detls;} 
						?>
					</button>
					 @endif
					@endforeach
					</td>
					<td>@foreach($infos->update_data as $kku=>$updt)
					 @if(isset($kku) && $kku!='')
					  <button type="button" class="btn btn-xs btn-outline btn-secondary mb-4">
						<span style="font-size: 14px;font-weight: 900;">
						<?php if(array_search($kku,$commonkeylist)){ 
							echo array_search($kku,$commonkeylist);
						} else { echo $kku;} 
						?>
						
						</span>
						<?php if(array_search($updt,$commonkeylist)){ 
							echo array_search($updt,$commonkeylist);
						} else { echo $updt;} 
						?>
						</button>
					 @endif
					@endforeach
					</td>
				   
					<td>
						<?php
						if (isset($infos->action) && $infos->action == 'I')
							echo 'Add';
						else if ($infos->action &&  $infos->action == 'U')
							echo "Update";
						?>
					</td>
					<td>
					<?php
					 if(array_search($infos->session_user_name,$commonkeylist)){ 
							echo array_search($infos->session_user_name,$commonkeylist);
						} else { echo $infos->session_user_name;} ?>
					</td>
					<td>{{date('d/m/Y H:i:A',strtotime($infos->action_tstamp_tx))}}</td>
					 <td>{{$infos->client_addr}}</td>
				</tr>
				
				
				@endforeach
				@endif        
			</tbody>
            
        </table>
    </div>
</div>
<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->

@endsection
