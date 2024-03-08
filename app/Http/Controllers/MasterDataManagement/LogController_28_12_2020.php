<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MasterDataManagement;

/**
 * Description of LogController 
 *
 * @author user-98-pc
 */
use App\Http\Controllers\Controller;
use App\Models\Common\DistrictModel;
use App\Http\Controllers\Auth\AuthController;
use Validator;
use Illuminate\Http\Request;
use App\Models\User\MasterUserModel;
use Carbon\Carbon;
use JsValidator;
use DB;
class LogController  extends Controller {

    //put your code here

    protected $validationRules = [
        'district.state_id' => 'required',
        'district.district_name' => 'required',
    ];

    //put your code here
    public function __construct() {
        parent:: __construct();


        $this->data['include_script_view'] = 'admin.MasterDataManagement.script';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['pageHeading'] = 'Master District Management';
        $this->data['title'] = 'Dalmia-lams::District';
//      $this->data['districts'] = $this->getAllStates();
//      $this->data['area_units'] = $this->getCodesDetails('area_unit');
//      $this->data['purchase_type'] = $this->getCodesDetails('purchase_type');
        $this->data['stateList'] = $this->getAllStates();
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function view_logs(Request $Request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['pageHeading'] = 'Audit Log';
		$this->data['users'] = $users = DB::table("USER")->where(['fl_archive' => 'N'])->get();
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->data['include_script_view'] = 'admin.MasterDataManagement.script';
		$postedData = $Request->all();
		$user = isset($postedData['user'])?implode("','",$postedData['user']):'';
		$action = isset($postedData['action'])?implode("','",$postedData['action']):'';
		$from_date = isset($postedData['from_date']) && $postedData['from_date']!=''?date('Y-m-d',strtotime(strtr($postedData['from_date'],'/','-'))):'';
		$to_date = isset($postedData['to_date']) && $postedData['to_date']!=''?date('Y-m-d',strtotime(strtr($postedData['to_date'],'/','-'))):'';
		$module = isset($postedData['module'])?implode("','",$postedData['module']):'';
		
		$where="where 1=1";
		if($user !='')
		{
			$where .=" and session_user_name in ('$user')";
		}
		
		if($from_date!='' && $to_date!='')
		{
			$where .="and date(action_tstamp_stm)>='$from_date' and date(action_tstamp_stm)<='$to_date'";
		}
		else if($from_date!=''  && $to_date=='')
		{
			 $where .=" and date(action_tstamp_stm)>='$from_date'";
		}
		else
		{
			$where .=" and date(action_tstamp_stm) >  CURRENT_DATE - INTERVAL '9 months' ";
		}
		if($action !='All')
		{
			$where .=" and action in ('$action') ";
		}
		
		if($module !='')
		{
			$where .=" and table_name in('$module') ";
		}
		
		
		
		$this->data['user']		 = $user;	
		$this->data['from_date'] = $from_date;
		$this->data['to_date']	 = $to_date;
		$this->data['action']	 = $action;
		$this->data['module']	 = $module;
		
		$results = array();
		 $up_arr =array();
		if(!empty($postedData)){
		$sql = "select * from audit.logged_actions $where  ";
		$results = DB::select( DB::raw($sql));
        
		}
		 $registration_comments =  DB::select("select cols.column_name,(select pg_catalog.obj_description(oid) from pg_catalog.pg_class c where c.relname=cols.table_name) as table_comment,(select pg_catalog.col_description(oid,cols.ordinal_position::int) from pg_catalog.pg_class c where c.relname=cols.table_name) as column_comment from information_schema.columns cols where  cols.table_name in('$module')");
		$state = DB::table('STATE')->get(); 
		$BLOCK = DB::table('BLOCK')->get();
		$DISTRICT = DB::table('DISTRICT')->get();
		$VILLAGE = DB::table('VILLAGE')->get();
		$USER = \App\Models\User\UserModel::get();
		$ROLES = DB::table('ROLES')->get();
		$FAMILY = DB::table('FAMILY')->get();
		$Codes = DB::table('CODES')->get();
		$commonkeylist = array();
		$USER = \App\Models\User\UserModel::get(); 
		foreach($Codes as $Code)
		{
			$commonkeylist[$Code->cd_desc] = $Code->id;
		}	foreach($USER as $USERS)
		{
			$commonkeylist[$USERS->user_name] = $USERS->id;
		}
		 foreach($registration_comments as $regComments)
		{
			$commonkeylist[$regComments->column_comment] = $regComments->column_name;
		}
		
		foreach($state as $states)
		{
			$commonkeylist[$states->state_name] = $states->id;
		}
		foreach($BLOCK as $BLOCKS)
		{
			$commonkeylist[$BLOCKS->block_name] = $BLOCKS->id;
		}
		foreach($DISTRICT as $DISTRICTS)
		{
			$commonkeylist[$DISTRICTS->district_name] = $DISTRICTS->id;
		}
		foreach($VILLAGE as $VILLAGE)
		{
			$commonkeylist[$VILLAGE->village_name] = $VILLAGE->id;
		}
		foreach($USER as $USERS)
		{
			$commonkeylist[$USERS->user_name] = $USERS->id;
		}
		foreach($ROLES as $ROLES)
		{
			$commonkeylist[$ROLES->name] = $ROLES->id;
		}
		foreach($FAMILY as $FAMILYS)
		{
			$commonkeylist[$FAMILYS->member_name] = $FAMILYS->id;
		}
		 
	
		$this->data['commonkeylist'] =$commonkeylist; 
		$this->data['list'] =$results;
		//t($results,1);
		return view('admin.MasterDataManagement.auditLog', $this->data);
	}
	
	public function logDistribution(Request $Request) {

		$this->data['users'] = $users = DB::table("USER")->where(['fl_archive' => 'N'])->get();
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->data['include_script_view'] = 'admin.MasterDataManagement.script';
		$postedData = $Request->all();
		$event_id = isset($postedData['event_id'])?$postedData['event_id']:'';
		
		$where="where 1=1";
		if($event_id !='')
		{
			$where .=" and event_id='$event_id' ";
		}
				
		$results = array();
		 $up_arr =array();
		if(!empty($postedData)){
		$sql = "select * from audit.logged_actions $where  ";
		$results = DB::select( DB::raw($sql));
        
		
		foreach($results as $k=>$rslt)
		{
			//t($rslt);die;
			//raw data
			$rawData = $rslt->row_data;
			$rawData =  (str_replace('"=>"', '":"', $rawData) );
			$rawData =  ('{' . str_replace('=>', ':', $rawData) . '}');
			$rawData =  (str_replace('NULL', 'null', $rawData));
			$result_arr = json_decode($rawData,1);
			$upd_arr = array();	
		    $ne_arr = array();
			$module ='';
		    $submodule =''; 
			$projectId='';
			//$results[$k]->insert_data =$result_arr; 
			//update 
			$updateData = $rslt->changed_fields;
			$updateData =  (str_replace('"=>"', '":"', $updateData) );
			$updateData =  ('{' . str_replace('=>', ':', $updateData) . '}');
			$updateData =  (str_replace('NULL', 'null', $updateData));
			$Updateresult_arr = json_decode($updateData,1);
			//$results[$k]->update_data =$Updateresult_arr; 

           
			//t($Updateresult_arr,1);
			$old_val=array_intersect_key($result_arr,$Updateresult_arr);	
			$new_value=array_intersect_key($Updateresult_arr,$result_arr);
			if(empty($old_val) && empty($new_value))
			{
				$new_value =$result_arr;  
			}
			}
			$results[$k]->old_val = $old_val;
			$results[$k]->new_value = $new_value;
		}
	
		$registration_comments =  DB::select("select cols.column_name,(select pg_catalog.obj_description(oid) from pg_catalog.pg_class c where c.relname=cols.table_name) as table_comment,(select pg_catalog.col_description(oid,cols.ordinal_position::int) from pg_catalog.pg_class c where c.relname=cols.table_name) as column_comment from information_schema.columns cols where  cols.table_name!=''");
		//t($registration_comments,1);
		$state = DB::table('STATE')->get(); 
		$BLOCK = DB::table('BLOCK')->get();
		$DISTRICT = DB::table('DISTRICT')->get();
		$VILLAGE = DB::table('VILLAGE')->get();
		$USER = \App\Models\User\UserModel::get();
		$ROLES = DB::table('ROLES')->get();
		$FAMILY = DB::table('FAMILY')->get();
		
		$commonkeylist = array();
		foreach($registration_comments as $regComments)
		{
			$commonkeylist[$regComments->column_comment] = $regComments->column_name;
		}
		
		foreach($state as $states)
		{
			$commonkeylist[$states->state_name] = $states->id;
		}
		foreach($BLOCK as $BLOCKS)
		{
			$commonkeylist[$BLOCKS->block_name] = $BLOCKS->id;
		}
		foreach($DISTRICT as $DISTRICTS)
		{
			$commonkeylist[$DISTRICTS->district_name] = $DISTRICTS->id;
		}
		foreach($VILLAGE as $VILLAGE)
		{
			$commonkeylist[$VILLAGE->village_name] = $VILLAGE->id;
		}
		foreach($USER as $USERS)
		{
			$commonkeylist[$USERS->user_name] = $USERS->id;
		}
		foreach($ROLES as $ROLES)
		{
			$commonkeylist[$ROLES->name] = $ROLES->id;
		}
		foreach($FAMILY as $FAMILYS)
		{
			$commonkeylist[$FAMILYS->member_name] = $FAMILYS->id;
		}
		
		$this->data['commonkeylist'] =$commonkeylist; 
		$this->data['list'] =$results;
		//t($results,1);
		return view('admin.MasterDataManagement.auditLogDist', $this->data);
	}
	function compareDeepValue($val1, $val2)
{
   return strcmp($val1['key'], $val2['key']);
}
}
