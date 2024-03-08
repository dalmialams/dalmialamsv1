<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ApprovalManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Approval\ApprovalModel;
use App\Models\Approval\ApprovalProcessTrackModel;
use App\Models\User\UserModel;
use App\Models\User\UserLoginModel;
use App\Models\User\AssginedStateDistrictModel;
use App\Models\UtilityModel;
use App\Models\Role\Role;
use App\Models\Role\Permission;
use App\Models\Form\FormModel;
use DB;
use Hash;
use JsValidator;


/**
 * Description of ApprovalManagement
 *
 * @author user-98-pc
 */
class ApprovalManageController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [
        //'user.user_name' => 'required',
        'approval.app_year' => 'required',
        'approval.app_month' => 'required',
        'approval.app_title' => 'required',
        'approval.app_type' => 'required',
        'approval.app_desc' => 'required',
    ];
    protected $field_names = [
        //  'user.user_name' => 'Select User',
        'approval.app_year' => 'Year',
        'approval.app_month' => 'Month',
        'approval.app_title' => 'Title',
        'approval.app_type' => 'Type',
        'approval.app_desc' => 'Description',
    ];

    public function __construct() {
        parent:: __construct();
        $this->allowed_types = [ 'pdf', 'doc', 'docs', 'xlsx', 'csv', 'xls'];
        $this->upload_dir = 'assets\uploads\ApprovalDoc';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Approval-Management';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $states = $this->getAllStates();
        unset($states['']);
        $this->data['states'] = $states;
        $this->middleware('auth');
		date_default_timezone_set('Asia/Kolkata');
    }

    public function add($id='') {
        $this->data['pageHeading'] = (!$id) ? 'Approval Management  <span class="text-danger" >Add</span>' : 'Approval Management  <span class="text-danger" >Manage</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';
        $this->data['include_script_view'] = 'admin.ApprovalManagement.script';

        $this->data['id'] = $id;
        if ($id) {
            $approval_info = ApprovalModel::where(['id' => $id])->get()->toArray();

            $this->data['approval_data'] = $approval_info = isset($approval_info[0]) ? $approval_info[0] : '';
            $crt_id = isset($approval_info['crt_id']) ? $approval_info['crt_id'] : '';
            if ($crt_id !== $this->data['current_user_id']) {
                return redirect('unauthorized-access');
            }
        }
		
		$arr_month = 
			array(
				"January"=>"January",
				"February"=>"February",
				"March"=>"March",
				"April"=>"April",
				"May"=>"May",
				"June"=>"June",
				"July"=>"July",
				"August"=>"August",
				"September"=>"September",
				"October"=>"October",
				"November"=>"November",
				"December"=>"December"
			);
		$this->data['month_list'] = $arr_month;
		$approval = ApprovalModel::where(['fl_archive' => 'N'])->get()->toArray();
		$this->data['approval'] = $approval;	
        return view('admin.ApprovalManagement.add', $this->data);
    }

    /*
     * Track approval
     */

    public function approval_track($id = null,$status= null) {
        $this->data['pageHeading'] = (!$id) ? 'Approval Management  <span class="text-danger" >Approval</span>' : 'Approval Management  <span class="text-danger" >Manage</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';
        $this->data['include_script_view'] = 'admin.ApprovalManagement.script';

		$this->data['id'] = $id;
		$this->data['status'] = $status;
       		
		$site_admin_role = $this->role_id;
		if($site_admin_role == 4){
		$apt_recipient_role = $site_admin_role;
		}else if($site_admin_role == 8){
		$apt_recipient_role = $site_admin_role;
		}else if($site_admin_role == 9){
		$apt_recipient_role = $site_admin_role;
		}
				
		$apr_data_list = ApprovalProcessTrackModel::where(['apt_recipient_role' => $apt_recipient_role,'apt_accept_status' => 'pending'])->get()->toArray();
		$this->data['apr_data_list'] = $apr_data_list;	

        return view('admin.ApprovalManagement.approvalTrack', $this->data);
    }
	
	
	
   public function reason_remarks_submit(Request $request) {
        $posted_data = $request->all();
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
		$action_status = isset($posted_data['action_status']) ? $posted_data['action_status'] : '';
		$apt_remarks = isset($posted_data['apt_remarks']) ? $posted_data['apt_remarks'] : '';
        $msg = '';
       /* $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('approval-management/approval/add/' . $id)
                                ->withErrors($validator, 'approval')
                                ->withInput();
            }*/
			
		if($id != '' && $apt_remarks != ''){
			$apr_list = DB::table('APPROVAL_PROCESS_TRACK')
			->join('APPROVAL','APPROVAL.id','=','APPROVAL_PROCESS_TRACK.apt_item_id')
			->where(['APPROVAL_PROCESS_TRACK.id' => $id])
			->get();
			
				if(!empty($apr_list)){	
				$login_user_role = $this->role_id;	
				if($login_user_role == 4){
					
					if($action_status == 'approved'){
						$upd_apr_details['apt_accept_status'] = $action_status;
						$upd_apr_details['apt_remarks'] = $apt_remarks;
						$upd_apr_details['apt_action_date'] = date('Y-m-d H:i:s');

						$results = ApprovalProcessTrackModel::where(['id' => $id])->update($upd_apr_details);
						
							$apr_second_level_data_master = array(
								'apt_type' => $apr_list[0]->app_type,
								'apt_item_id' => $apr_list[0]->id,
								'apt_user_id' => $this->data['current_user_id'],
								'apt_user_role' => $this->data['current_user_id'],
								'apt_recipient_role' => 8,
								'apt_accept_status' => 'pending',
							);					
							$insert_id = ApprovalProcessTrackModel::insertGetId($apr_second_level_data_master); 
							$msg = UtilityModel::getMessage('Successfully approved!');
				
					}else if($action_status == 'rejected'){
						$upd_apr_details['apt_accept_status'] = $action_status;
						$upd_apr_details['apt_remarks'] = $apt_remarks;
						$upd_apr_details['apt_action_date'] = date('Y-m-d H:i:s');
						$results = ApprovalProcessTrackModel::where(['id' => $id])->update($upd_apr_details);

						$upd_mon_apr_details['app_status'] = $action_status;
						$results = ApprovalModel::where(['id' => $apr_list[0]->id])->update($upd_mon_apr_details);
						$msg = UtilityModel::getMessage('Successfully rejected!');
					}	

				}else if($login_user_role == 8){
						
					if($action_status == 'approved'){
						$upd_apr_details['apt_accept_status'] = $action_status;
						$upd_apr_details['apt_remarks'] = $apt_remarks;
						$upd_apr_details['apt_action_date'] = date('Y-m-d H:i:s');

						$results = ApprovalProcessTrackModel::where(['id' => $id])->update($upd_apr_details);
							$apr_second_level_data_master = array(
								'apt_type' => $apr_list[0]->app_type,
								'apt_item_id' => $apr_list[0]->id,
								'apt_user_id' => $this->data['current_user_id'],
								'apt_user_role' => $this->data['current_user_id'],
								'apt_recipient_role' => 9,
								'apt_accept_status' => 'pending',
							);
							$insert_id = ApprovalProcessTrackModel::insertGetId($apr_second_level_data_master); 
							$msg = UtilityModel::getMessage('Successfully approved!');
							
					}else if($action_status == 'rejected'){
						$upd_apr_details['apt_accept_status'] = $action_status;
						$upd_apr_details['apt_remarks'] = $apt_remarks;
						$upd_apr_details['apt_action_date'] = date('Y-m-d H:i:s');
						$results = ApprovalProcessTrackModel::where(['id' => $id])->update($upd_apr_details);

						$upd_mon_apr_details['app_status'] = $action_status;
						$results = ApprovalModel::where(['id' => $apr_list[0]->id])->update($upd_mon_apr_details);
						$msg = UtilityModel::getMessage('Successfully rejected!');
					}				

				}else if($login_user_role == 9){
					
					if($action_status == 'approved'){
						$upd_apr_details['apt_accept_status'] = $action_status;
						$upd_apr_details['apt_remarks'] = $apt_remarks;
						$upd_apr_details['apt_action_date'] = date('Y-m-d H:i:s');

						$results = ApprovalProcessTrackModel::where(['id' => $id])->update($upd_apr_details);

						$upd_mon_apr_details['app_status'] = $action_status;
						$results = ApprovalModel::where(['id' => $apr_list[0]->id])->update($upd_mon_apr_details);
						$msg = UtilityModel::getMessage('Successfully approved!');
					}else if($action_status == 'rejected'){
						$upd_apr_details['apt_accept_status'] = $action_status;
						$upd_apr_details['apt_remarks'] = $apt_remarks;
						$upd_apr_details['apt_action_date'] = date('Y-m-d H:i:s');
						$results = ApprovalProcessTrackModel::where(['id' => $id])->update($upd_apr_details);

						$upd_mon_apr_details['app_status'] = $action_status;
						$results = ApprovalModel::where(['id' => $apr_list[0]->id])->update($upd_mon_apr_details);
						$msg = UtilityModel::getMessage('Successfully rejected!');
					}
				}	
			}
		}
		return redirect('approval-management/approval/track/')->with('message', $msg);
	}
	
    public function processData(Request $request) {
        $approval_data = $request->all();
		$upload_doc = isset($approval_data['upload_doc']) ? $approval_data['upload_doc'] : '';

        $posted_data = $approval_data['approval'];
		
        $id = isset($approval_data['id']) ? $approval_data['id'] : '';

        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('approval-management/approval/add/' . $id)
                                ->withErrors($validator, 'approval')
                                ->withInput();
            }

            $data_to_update = $posted_data;

            $data_to_update['upd_id'] = $this->data['current_user_id'];
            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = ApprovalModel::where(['id' => $id])->update($data_to_update);
            if ($update) {
                $msg = UtilityModel::getMessage('User data updated successfully!');
                return redirect('approval-management/approval/add/')->with('message', $msg);
            } else {
                $msg = UtilityModel::getMessage('Something went wrong!', 'error');
                return redirect('approval-management/approval/add/')->with('message', $msg);
            }
        } else {
			
            if ($validator->fails()) {
                return redirect('approval-management/approval/add/')
                                ->withErrors($validator, 'approval')
                                ->withInput();
            }
            $data_to_insert = $posted_data;  
			

			if (!empty($upload_doc)) {
				$file_name = $upload_doc->getClientOriginalName();
				$file_name = stristr($file_name, '.', true);
				$ext = $upload_doc->getClientOriginalExtension();
				$new_file_name = $file_name . '_' . time() . '.' . $ext;
				$file_path = $this->upload_dir . '/' . $new_file_name;
				if (in_array($ext, $this->allowed_types)) {
					$upload = UtilityModel::uploadFile($upload_doc, $this->upload_dir, $new_file_name);
										
						$data_to_insert['created_at'] = Carbon::now();
						$data_to_insert['updated_at'] = Carbon::now();
						$data_to_insert['crt_id'] = $this->data['current_user_id'];
						$data_to_insert['upd_id'] = $this->data['current_user_id'];
						$data_to_insert['app_status'] = 'pending';
						
						$data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
						$data_to_insert['file_type'] = isset($ext) ? $ext : '';
						$insert_id = ApprovalModel::insertGetId($data_to_insert); 
						$results = ApprovalModel::where(['id' => $insert_id])->get()->toArray();
								
							if($insert_id){
								 $apr_data_master = array(
									'apt_type' => $results[0]['app_type'],
									'apt_item_id' => $results[0]['id'],
									'apt_user_id' => $this->data['current_user_id'],
									'apt_user_role' => $this->data['current_user_id'],
									'apt_recipient_role' => 4,
									'apt_accept_status' => 'pending'
									);	
								$app_channel_insert_id = ApprovalProcessTrackModel::insertGetId($apr_data_master); 
							}						
							$msg = UtilityModel::getMessage('Approval data saved successfully!');
				} else {
					$msg = UtilityModel::getMessage('This type of files are not allowed!', 'error');					
				}
			}			
			return redirect('approval-management/approval/add/')->with('message', $msg);
		}
    }

    public function track_history($id = null) {
        $this->data['pageHeading'] = ($id) ? 'Approval Management  <span class="text-danger" >Approval</span>' : 'Approval Management  <span class="text-danger" >Manage</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';
        $this->data['include_script_view'] = 'admin.ApprovalManagement.script';
		
		date_default_timezone_set('Asia/Kolkata');
		$this->data['id'] = $id;
		$apr_list = DB::table('APPROVAL')
			->join('APPROVAL_PROCESS_TRACK','APPROVAL_PROCESS_TRACK.apt_item_id','=','APPROVAL.id')
			->where(['APPROVAL.id' => $id])
			->get();
			$this->data['history_apr_list'] = $apr_list;
		
			$approval = ApprovalModel::where(['fl_archive' => 'N'])->get()->toArray();
			$this->data['approval'] = $approval;	

		$arr_month = 
			array(
				"January"=>"January",
				"February"=>"February",
				"March"=>"March",
				"April"=>"April",
				"May"=>"May",
				"June"=>"June",
				"July"=>"July",
				"August"=>"August",
				"September"=>"September",
				"October"=>"October",
				"November"=>"November",
				"December"=>"December"
			);
		$this->data['month_list'] = $arr_month;
        return view('admin.ApprovalManagement.add', $this->data);
    }

    public function unauthorized() {

        $this->data['pageHeading'] = 'Unauthorized Access';
        return view('admin.unauthorized', $this->data);
    }

    public function notFound() {

        $this->data['pageHeading'] = '404 not found';
        return view('404', $this->data);
    }

    public function commonSuccessView() {
        $this->data['pageHeading'] = '';
        return view('admin.common_success_msg', $this->data);
    }

}
