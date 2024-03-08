<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\LeaseManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaseManagement\LeaseModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\UtilityModel;
use App\Models\Common\StateModel;
use App\Models\Common\DistrictModel;
use App\Models\Common\BlockModel;
use App\Models\Common\VillageModel;
use App\Models\Common\CodeModel;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;

/**
 * Description of RegistrationController
 *
 * @author user-98-pc
 */
class LeaseManagementController extends Controller {

    //put your code here

    protected $validationRules = [
        'lease.registration_id' => 'required',
        'lease.lease_name' => 'required',
        'lease.lessor_name' => 'required',
        'lease.lease_monthly_amount' => 'required|numeric',
        'lease.lease_start_date' => 'required',
        'lease.lease_end_date' => 'required',
        'lease.status' => 'required',
    ];
    protected $field_names = [
        'lease.registration_id' => 'Regn No',
        'lease.lease_name' => 'Lessee',
        'lease.lessor_name' => 'Lessor',
        'lease.lease_monthly_amount' => 'Lease Rent p.a',
        'lease.lease_start_date' => 'Start Date',
        'lease.lease_end_date' => 'End Date',
        'lease.status' => 'Status',
    ];

    public function __construct() {
        parent:: __construct();
        //$this->allowed_types = ['txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'jpg', 'png', 'gif','ods','odt','ots'];
        $this->allowed_types = [ 'pdf', 'mp4'];
        $this->upload_dir = 'assets\uploads\LeaseDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        //$this->data['pageHeading'] = $this->data['reg_uniq_no'] ? 'Registration : '.$this->data['reg_uniq_no'] : 'Land Record Entry';
        $this->data['title'] = 'Dalmia-lams::Lease Management';
        $this->data['section'] = 'lease_management';
        $this->data['area_units'] = $this->getCodesDetails('area_unit');
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->assgined_districts_str = '';

        if ($this->user_type !== 'admin') {

            if ($this->assigned_states) {
                $assigned_states = explode(",", $this->assigned_states);
                //t($assigned_states,1);
                foreach ($assigned_states as $key => $value) {
                    $districts = \App\Models\User\AssginedStateDistrictModel::where(['state_id' => $value, 'user_id' => $this->data['current_user_id']])->select('district_id')->get()->toArray();
                    // t($districts);
                    if ($districts) {
                        foreach ($districts as $dist_key => $dist_value) {
                            $assgined_districts[] = $dist_value['district_id'];
                        }
                    }
                }
                $this->assgined_districts_str = ($assgined_districts) ? "'" . implode("','", $assgined_districts) . "'" : '';
                // t($this->assgined_districts_str,1);
                // $reg_id_arr = RegistrationModel::whereRaw("district_id in ($assgined_districts_str)")->orderBy('id')->lists('id', 'id')->toArray();
            }
        }
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        //  $this->data['title'] = 'Dalmia-lams::Registration/Add';       
        $this->data['pageHeading'] = 'Lease Management <span class="text-danger" >Add</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.Leasemanagement.script';
        $this->data['id'] = '';

        $this->data['lease_data'] = (isset($lease_data) && $lease_data) ? $lease_data : '';
        $cond = '(1=1) ';

        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {

            $reg_id_arr = RegistrationModel::whereRaw("district_id in ($this->assgined_districts_str)")->where(['purchase_type_id' => 'CD00144'])->orderBy('id')->lists('id', 'id')->toArray();
        } else {
            $reg_id_arr = RegistrationModel::where(['purchase_type_id' => 'CD00144'])->orderBy('id')->lists('id', 'id')->toArray();
        }
        //t($reg_id_arr, 1);

        if ($this->user_type !== 'admin') {
            $reg_id_str = ($reg_id_arr) ? "'" . implode("','", $reg_id_arr) . "'" : '';
            $reg_id_str ? $cond.= " and registration_id in ($reg_id_str)" : '';
            $this->data['lease'] = $lease = LeaseModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
        } else {
            $this->data['lease'] = $lease = LeaseModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
        }
        $this->data['status'] = [
            '' => 'Select',
            'Y' => 'Active',
            'N' => 'Inactive'
        ];

        $reg_id_arr = array_merge(array('' => 'Select'), $reg_id_arr);

        $this->data['reg_id_arr'] = $reg_id_arr;

        return view('admin.Leasemanagement.add', $this->data);
    }

    public function edit(Request $request, $id = null) {

        $this->data['pageHeading'] = 'Lease Management <span class="text-danger" >Edit</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.Leasemanagement.script';

        $cond = '(1=1) ';

        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
            $reg_id_arr = RegistrationModel::whereRaw("district_id in ($this->assgined_districts_str)")->where(['purchase_type_id' => 'CD00144'])->orderBy('id')->lists('id', 'id')->toArray();
        } else {
            $reg_id_arr = RegistrationModel::where(['purchase_type_id' => 'CD00144'])->orderBy('id')->lists('id', 'id')->toArray();
        }

        if (!$id) {
            return redirect('lease-management/add');
        } else {
            $lease_exist = LeaseModel::where(['id' => $id])->get()->toArray();
            $lease_reg_id = LeaseModel::where(['id' => $id])->value('registration_id');
            if (empty($lease_exist) && !array_key_exists($lease_reg_id, $reg_id_arr)) {
                return redirect('lease-management/add');
            }
        }

        $this->data['id'] = $id;
        if ($id) {
            $lease_data = LeaseModel::where(['id' => $id])->get()->toArray();
            $lease_data = isset($lease_data[0]) ? $lease_data[0] : '';
            $lease_agreement_date = new \DateTime($lease_data['lease_agreement_date']);
            $lease_data['lease_agreement_date'] = $lease_agreement_date->format('d/m/Y');
            $start_date = new \DateTime($lease_data['lease_start_date']);
            $lease_data['lease_start_date'] = $start_date->format('d/m/Y');
            $end_date = new \DateTime($lease_data['lease_end_date']);
            $lease_data['lease_end_date'] = $end_date->format('d/m/Y');
            $reg_uniq_no = ($id) ? LeaseModel::where(['id' => $id])->value('registration_id') : '';
            $reg_info = ($reg_uniq_no) ? RegistrationModel::find($reg_uniq_no)->toArray() : '';
            // t($reg_info,1);
            $this->data['reg_info'] = ($reg_info) ? $reg_info : '';
        }
        $this->data['lease_data'] = (isset($lease_data) && $lease_data) ? $lease_data : '';
        //t($reg_id_arr, 1);
        if ($this->user_type !== 'admin') {
            $reg_id_str = ($reg_id_arr) ? "'" . implode("','", $reg_id_arr) . "'" : '';
            $reg_id_str ? $cond.= " and registration_id in ($reg_id_str)" : '';
            $this->data['lease'] = $lease = LeaseModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
        } else {
            $this->data['lease'] = $lease = LeaseModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
        }
        $this->data['status'] = [
            '' => 'Select',
            'Y' => 'Active',
            'N' => 'Inactive'
        ];
        $reg_id_arr = array_merge(array('' => 'Select'), $reg_id_arr);

        $this->data['reg_id_arr'] = $reg_id_arr;

        return view('admin.Leasemanagement.add', $this->data);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_lease_data = isset($posted_data['lease']) ? $posted_data['lease'] : '';
        // t($posted_lease_data);
        $registration_id = isset($posted_lease_data['registration_id']) ? $posted_lease_data['registration_id'] : '';
        if (!$registration_id) {
            return redirect('lease-management/add');
        } else {
            $new_start_date = str_replace("/", "-", $posted_lease_data['lease_start_date']);
            $new_start_date = new \DateTime($new_start_date);
            $new_start_date = $new_start_date->format('Y-m-d');

            $new_end_date = str_replace("/", "-", $posted_lease_data['lease_end_date']);
            $new_end_date = new \DateTime($new_end_date);
            $new_end_date = $new_end_date->format('Y-m-d');

            $date_exist_status = 0;

            $id = isset($posted_data['id']) ? $posted_data['id'] : '';
            $validator = Validator::make($request->all(), $this->validationRules);
            $validator->setAttributeNames($this->field_names);
            $doc_file = isset($posted_data['doc_file']) ? $posted_data['doc_file'] : '';
            if (!empty($doc_file)) {
                $file_name = $doc_file->getClientOriginalName();
                $file_name = stristr($file_name, '.', true);
                $ext = $doc_file->getClientOriginalExtension();
                $new_file_name = $file_name . '_' . time() . '.' . $ext;
                $file_path = $this->upload_dir . '/' . $new_file_name;
            }
            if ($id) {
                if ($this->user_type !== 'admin') {
                    if (!$this->hasPermission('lease_edit')) {
                        return redirect('unauthorized-access');
                    }
                }
                if ($validator->fails()) {
                    return redirect('lease-management/edit/' . $id)
                                    ->withErrors($validator, 'lease')
                                    ->withInput();
                }
                if (!empty($doc_file)) {
                    if (in_array($ext, $this->allowed_types)) {
                        $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
                    } else {
                        //  $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
                        $msg = UtilityModel::getMessage('These type of files are not allowed!', 'error');
                        return redirect('lease-management/edit/' . $id)->with('message', $msg)->withInput();
                    }
                }

                $date_range_res = LeaseModel::where('id', '<>', $id)->where(['registration_id' => $registration_id, 'fl_archive' => 'N'])->select('lease_start_date', 'lease_end_date')->get()->toArray();

                $previous_start_date = LeaseModel::where(['id' => $id])->value('lease_start_date');
                $previous_start_date = new \DateTime($previous_start_date);
                $previous_start_date = $previous_start_date->format('Y-m-d');
                $previous_end_date = LeaseModel::where(['id' => $id])->value('lease_end_date');
                $previous_end_date = new \DateTime($previous_end_date);
                $previous_end_date = $previous_end_date->format('Y-m-d');

                if ($previous_start_date !== $new_start_date || $previous_end_date !== $new_end_date) {
                    if ($date_range_res) {
                        $from_user_start_date = new \DateTime($new_start_date);
                        $from_user_end_date = new \DateTime($new_end_date);
                        foreach ($date_range_res as $key => $value) {
                            $lease_start_date = new \DateTime($value['lease_start_date']);
                            $lease_end_date = new \DateTime($value['lease_end_date']);
                            $start_date_exists = UtilityModel::isDateBetweenDates($from_user_start_date, $lease_start_date, $lease_end_date);
                            $end_date_exists = UtilityModel::isDateBetweenDates($from_user_end_date, $lease_start_date, $lease_end_date);
                            $date_array = array(0 => $lease_start_date, 1 => $lease_end_date);
                            $is_within_range = UtilityModel::checkDateRange($date_array, $from_user_start_date, $from_user_end_date);
                            if ($start_date_exists || $end_date_exists || $is_within_range) {
                                $date_exist_status++;
                            }
                        }
                    }
                }
                if ($date_exist_status > 0) {
                    $msg = UtilityModel::getMessage('Lease period overlaps with another date range.Please try with another date range', 'error');
                    return redirect('lease-management/edit/' . $id)->with('message', $msg)->with('message', $msg)->withInput();
                }
                $data_to_update = $posted_lease_data;
                //$data_to_update['lease_agreement_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_agreement_date'])));
                $data_to_update['percentage_escalation'] = (int) $posted_lease_data['percentage_escalation'];
                $data_to_update['lease_start_date'] = $new_start_date;
                $data_to_update['lease_end_date'] = $new_end_date;
                $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                $data_to_update['updated_at'] = Carbon::now();
                // t($data_to_update, 1);
                if (isset($file_path) && $file_path) {
                    $data_to_update['lessor_doc_path'] = $file_path;
                    $data_to_update['file_type'] = isset($ext) ? $ext : '';
                }

                $update = LeaseModel::where(['id' => $id])->update($data_to_update);
                $msg = UtilityModel::getMessage('Lease data updated successfully!');
                return redirect('lease-management/edit/' . $id)->with('message', $msg);
                //$msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
            } else {

                if ($this->user_type !== 'admin') {
                    if (!$this->hasPermission('lease_add')) {
                        return redirect('unauthorized-access');
                    }
                }
                if ($validator->fails()) {
                    return redirect('lease-management/add')
                                    ->withErrors($validator, 'lease')
                                    ->withInput();
                }
                if (!empty($doc_file)) {
                    if (in_array($ext, $this->allowed_types)) {
                        $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
                    } else {
                        //  $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
                        $msg = UtilityModel::getMessage('This type of files are not allowed!', 'error');
                        return redirect('lease-management/add')->with('message', $msg)->withInput();
                    }
                }
                $date_range_res = LeaseModel::where(['registration_id' => $registration_id, 'fl_archive' => 'N'])->select('lease_start_date', 'lease_end_date')->get()->toArray();
                if ($date_range_res) {
                    $from_user_start_date = new \DateTime($new_start_date);
                    $from_user_end_date = new \DateTime($new_end_date);
                    foreach ($date_range_res as $key => $value) {
                        $lease_start_date = new \DateTime($value['lease_start_date']);
                        $lease_end_date = new \DateTime($value['lease_end_date']);
                        $start_date_exists = UtilityModel::isDateBetweenDates($from_user_start_date, $lease_start_date, $lease_end_date);
                        $end_date_exists = UtilityModel::isDateBetweenDates($from_user_end_date, $lease_start_date, $lease_end_date);
                        $date_array = array(0 => $lease_start_date, 1 => $lease_end_date);
                        $is_within_range = UtilityModel::checkDateRange($date_array, $from_user_start_date, $from_user_end_date);
                        if ($start_date_exists || $end_date_exists || $is_within_range) {
                            $date_exist_status++;
                        }
                    }
                }
                if ($date_exist_status > 0) {
                    $msg = UtilityModel::getMessage('Lease period overlaps with another period.Please try with another date range', 'error');
                    return redirect('lease-management/add')->with('message', $msg)->withInput();
                }
                //  exit;
                //t($posted_lease_data);
                $data_to_insert = $posted_lease_data;
                //$data_to_insert['lease_agreement_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_agreement_date'])));
                $data_to_insert['percentage_escalation'] = (int) $posted_lease_data['percentage_escalation'];
                $data_to_insert['lease_start_date'] = $new_start_date;
                $data_to_insert['lease_end_date'] = $new_end_date;
                $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                // $data_to_insert['upd_id'] = $this->data['current_user_id'];
                $data_to_insert['created_at'] = Carbon::now();
                //$data_to_insert['updated_at'] = Carbon::now();
                $data_to_insert['lessor_doc_path'] = isset($file_path) ? $file_path : '';
                $data_to_insert['file_type'] = isset($ext) ? $ext : '';
                //  t($data_to_insert, 1);

                $insert_id = LeaseModel::insertGetId($data_to_insert);
                $msg = UtilityModel::getMessage('Lease data saved successfully!');
                if ($insert_id) {
                    return redirect('lease-management/add')->with('message', $msg);
                }
            }
        }
    }

    public function populateFields(Request $request) {
        $posted_data = $request->all();
        //  t($posted_data);
        $total_area_val = '';
        $tot_area_unit = '';
        $rgistration_date = '';
        $location = '';
        $reg_uniq_no = isset($posted_data['registration_id']) ? $posted_data['registration_id'] : '';
        $reg_info = ($reg_uniq_no) ? RegistrationModel::find($reg_uniq_no)->toArray() : '';
        // t($reg_info);
        $state_name = ($reg_info['state_id']) ? StateModel::where(['id' => $reg_info['state_id']])->value('state_name') : '';
        $district_name = ($reg_info['district_id']) ? DistrictModel::where(['id' => $reg_info['district_id']])->value('district_name') : '';
        $block_name = ($reg_info['block_id']) ? BlockModel::where(['id' => $reg_info['block_id']])->value('block_name') : '';
        $village_name = ($reg_info['village_id']) ? VillageModel::where(['id' => $reg_info['village_id']])->value('village_name') : '';
        if ($state_name) {
            $location.= $state_name;
        }
        if ($district_name) {
            $location.= ',' . $district_name;
        }
        if ($block_name) {
            $location.= ',' . $block_name;
        }
        if ($village_name) {
            $location.= ',' . $village_name;
        }
        $total_area_val = $reg_info['tot_area'];
        $tot_area_unit = $reg_info['tot_area_unit'];
        $tot_area_unit = CodeModel::where(['id' => "$tot_area_unit"])->value('cd_desc');
        $rgistration_date = ($reg_info['regn_date']) ? date('d/m/Y', strtotime($reg_info['regn_date'])) : '';
        echo json_encode([
            'area' => $total_area_val . ' ' . $tot_area_unit,
            'date' => $rgistration_date,
            'location' => $location
        ]);
    }

    public function leaseDelete(Request $request) {

        $lease_no = $request->input('lease_no');

        if (!empty($lease_no)) {
            $data_to_update['fl_archive'] = 'Y';
            $delete_id = LeaseModel::where(['id' => $lease_no])->update($data_to_update);
            if ($delete_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Lease data deleted successfully!</strong></div>';
                if ($this->user_type == 'admin' || $this->hasPermission('lease_add')) {
                    return redirect('lease-management/add')->with('message', $msg);
                } else {
                    return redirect('common-success')->with('message', $msg);
                }
            }
        } else {
            return redirect('land-details-entry/registration/add');
        }
    }

    private function hasPermission($permission_name) {
        $user_obj = new \App\Models\User\UserModel();
        if ($user_obj->ifHasPermission($permission_name, $this->data['current_user_id'])) {
            return true;
        } else {
            return false;
        }
    }

}
