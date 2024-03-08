<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\LandEntryManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaseManagement\LeaseModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\UtilityModel;
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
        'lease.lease_name' => 'required',
        'lease.lessor_name' => 'required',
        'lease.lease_monthly_amount' => 'required|numeric',
        'lease.lease_start_date' => 'required',
        'lease.lease_end_date' => 'required',
        'lease.status' => 'required',
    ];
    protected $field_names = [
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
        $this->allowed_types = ['pdf', 'mp4'];
        $this->upload_dir = 'assets\uploads\LeaseDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Lease Management';
        $this->data['section'] = 'lease';
        $this->data['area_units'] = $this->getCodesDetails('area_unit');
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request, $id = null) {

        //  $this->data['title'] = 'Dalmia-lams::Registration/Add';       
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
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
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Leasemanagement.script';



        $this->data['lease_data'] = (isset($lease_data) && $lease_data) ? $lease_data : '';
        $cond = '(1=1) ';
        $reg_uniq_no = $this->data['reg_uniq_no'];
        $reg_info = ($reg_uniq_no) ? RegistrationModel::find($reg_uniq_no)->toArray() : '';
        // t($reg_info,1);
        $this->data['reg_info'] = ($reg_info) ? $reg_info : '';
        $this->data['lease'] = $lease = LeaseModel::whereRaw($cond)->where(['fl_archive' => 'N', 'registration_id' => $this->data['reg_uniq_no']])->orderBy('id', 'DESC')->get()->toArray();
        //t($lease, 1);
        $this->data['status'] = [
            '' => 'Select',
            'Y' => 'Active',
            'N' => 'Inactive'
        ];

        return view('admin.LandEntryManagement.Leasemanagement.add', $this->data);
        // return view('admin.Leasemanagement.add', $this->data);
    }

    public function edit(Request $request, $id = null) {
        //  $this->data['title'] = 'Dalmia-lams::Registration/Add';       
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
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
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Leasemanagement.script';

        $this->data['id'] = $id;
        if ($id) {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('lease_details_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            $lease_data = LeaseModel::where(['id' => $id])->get()->toArray();
            $lease_data = isset($lease_data[0]) ? $lease_data[0] : '';
            $lease_agreement_date = new \DateTime($lease_data['lease_agreement_date']);
            $lease_data['lease_agreement_date'] = $lease_agreement_date->format('d/m/Y');
            $start_date = new \DateTime($lease_data['lease_start_date']);
            $lease_data['lease_start_date'] = $start_date->format('d/m/Y');
            $end_date = new \DateTime($lease_data['lease_end_date']);
            $lease_data['lease_end_date'] = $end_date->format('d/m/Y');
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        }

        $this->data['lease_data'] = (isset($lease_data) && $lease_data) ? $lease_data : '';
        $cond = '(1=1) ';
        $reg_uniq_no = $this->data['reg_uniq_no'];
        $reg_info = ($reg_uniq_no) ? RegistrationModel::find($reg_uniq_no)->toArray() : '';
        // t($reg_info,1);
        $this->data['reg_info'] = ($reg_info) ? $reg_info : '';
        $this->data['lease'] = $lease = LeaseModel::whereRaw($cond)->where(['fl_archive' => 'N', 'registration_id' => $this->data['reg_uniq_no']])->orderBy('id', 'DESC')->get()->toArray();
        //t($lease, 1);
        $this->data['status'] = [
            '' => 'Select',
            'Y' => 'Active',
            'N' => 'Inactive'
        ];

        return view('admin.LandEntryManagement.Leasemanagement.add', $this->data);
    }

    public function view(Request $request, $id = null) {
        //  $this->data['title'] = 'Dalmia-lams::Registration/Add';       
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
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
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Leasemanagement.script';


        if ($this->data['viewMode'] == 'true') {
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        }
        $this->data['lease_data'] = (isset($lease_data) && $lease_data) ? $lease_data : '';
        $cond = '(1=1) ';
        $reg_uniq_no = $this->data['reg_uniq_no'];
        $reg_info = ($reg_uniq_no) ? RegistrationModel::find($reg_uniq_no)->toArray() : '';
        // t($reg_info,1);
        $this->data['reg_info'] = ($reg_info) ? $reg_info : '';
        $this->data['lease'] = $lease = LeaseModel::whereRaw($cond)->where(['fl_archive' => 'N', 'registration_id' => $this->data['reg_uniq_no']])->orderBy('id', 'DESC')->get()->toArray();
        //t($lease, 1);
        return view('admin.LandEntryManagement.Leasemanagement.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_lease_data = isset($posted_data['lease']) ? $posted_data['lease'] : '';
        //   t($posted_lease_data, 1);
        $registration_id = isset($posted_lease_data['registration_id']) ? $posted_lease_data['registration_id'] : '';

        if (!$registration_id) {
            //return redirect('lease-management/add');
            return redirect('unauthorized-access');
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
                    if ($this->hasPermission('registration_access') && !$this->hasPermission('lease_details_edit')) {
                        return redirect('unauthorized-access');
                    }
                }
                if ($validator->fails()) {
                    return redirect('land-details-entry/lease/edit/' . $id . '?reg_uniq_no=' . $registration_id)
                                    ->withErrors($validator, 'lease')
                                    ->withInput();
                }



                if (!empty($doc_file)) {
                    if (in_array($ext, $this->allowed_types)) {
                        $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
                    } else {
                        //  $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
                        $msg = UtilityModel::getMessage('These type of files are not allowed!', 'error');
                        return redirect('land-details-entry/lease/edit/' . $id . '?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
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
                    return redirect('land-details-entry/lease/edit/' . $id . '?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
                }
                $data_to_update = $posted_lease_data;
                // $data_to_update['lease_agreement_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_agreement_date'])));
                $data_to_update['percentage_escalation'] = (int) $posted_lease_data['percentage_escalation'];
                $data_to_update['lease_start_date'] = $new_start_date;
                $data_to_update['lease_end_date'] = $new_end_date;
                $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                $data_to_update['updated_at'] = Carbon::now();
                $data_to_update['registration_id'] = $registration_id;
                $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                if (isset($file_path) && $file_path) {
                    $data_to_update['lessor_doc_path'] = $file_path;
                    $data_to_update['file_type'] = isset($ext) ? $ext : '';
                }

                $update = LeaseModel::where(['id' => $id])->update($data_to_update);
                $msg = UtilityModel::getMessage('Lease data updated successfully!');
                if ($update) {
                    if ($posted_data['save_lease'] == 'save') {
                        return redirect('land-details-entry/lease/edit/' . $id . '?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    } else if ($posted_data['save_lease'] == 'save_continue') {
                        //return redirect('land-details-entry/lease/add/' . $id . '?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        if ($this->user_type !== 'admin') {
                            if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                                return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                                return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else {
                                return redirect('land-details-entry/lease/edit/' . $id . '?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            }
                        } else {
                            //return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        }
                    }
                }
            } else {
                if ($this->user_type !== 'admin') {
                    if ($this->hasPermission('registration_access') && !$this->hasPermission('lease_details_add')) {
                        return redirect('unauthorized-access');
                    }
                }
                if ($validator->fails()) {
                    return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)
                                    ->withErrors($validator, 'lease')
                                    ->withInput();
                }
                if (!empty($doc_file)) {
                    if (in_array($ext, $this->allowed_types)) {
                        $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
                    } else {
                        //  $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
                        $msg = UtilityModel::getMessage('This type of files are not allowed!', 'error');
                        return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
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
                    return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
                }
                //  exit;
                //t($posted_lease_data);
                $data_to_insert = $posted_lease_data;
                // $data_to_insert['lease_agreement_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_agreement_date'])));
                $data_to_insert['percentage_escalation'] = (int) $posted_lease_data['percentage_escalation'];
                $data_to_insert['lease_start_date'] = $new_start_date;
                $data_to_insert['lease_end_date'] = $new_end_date;
                $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                $data_to_insert['created_at'] = Carbon::now();
                //  $data_to_insert['updated_at'] = Carbon::now();
                $data_to_insert['registration_id'] = $registration_id;
                $data_to_insert['lessor_doc_path'] = isset($file_path) ? $file_path : '';
                $data_to_insert['file_type'] = isset($ext) ? $ext : '';
                // $data_to_insert['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                //  t($data_to_insert, 1);

                $insert_id = LeaseModel::insertGetId($data_to_insert);
                $msg = UtilityModel::getMessage('Lease data saved successfully!');
                if ($insert_id) {
                    if ($posted_data['save_lease'] == 'save') {
                        return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    } else if ($posted_data['save_lease'] == 'save_continue') {
                        //$registration_id = $data_to_insert['registration_id'];
                        if ($this->user_type !== 'admin') {
                            if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                                return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                                return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else {
                                return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id);
                            }
                        } else {
                            //return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        }
                    }
                }
            }
        }
    }

    public function leaseDelete(Request $request) {

        $reg_uniq_no = $request->input('reg_uniq_no');
        $lease_no = $request->input('lease_no');

        if (!empty($reg_uniq_no) && !empty($lease_no)) {
            $data_to_update['fl_archive'] = 'Y';
            $delete_id = LeaseModel::where(['id' => $lease_no])->update($data_to_update);
            if ($delete_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Lease data deleted successfully!</strong></div>';
                return redirect('land-details-entry/lease/add?reg_uniq_no=' . $reg_uniq_no)->with('message', $msg);
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
