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
        'lease.percentage_escalation' => 'required',
    ];
    protected $field_names = [
        'lease.lease_name' => 'Lessee',
        'lease.lessor_name' => 'Lessor',
        'lease.lease_monthly_amount' => 'Lease Rent p.a',
        'lease.lease_start_date' => 'Start Date',
        'lease.lease_end_date' => 'End Date',
        'lease.percentage_escalation' => 'Escalation %',
    ];

    public function __construct() {
        parent:: __construct();
        //$this->allowed_types = ['txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'jpg', 'png', 'gif','ods','odt','ots'];
        $this->allowed_types = ['pdf', 'mp4', 'ogg'];
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
        $this->data['pageHeading'] = (empty($id)) ? 'Lease Management <span class="text-danger" >Add</span>' : 'Lease Management <span class="text-danger" >Edit</span>';
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
            $lease_data = LeaseModel::where(['id' => $id])->get()->toArray();
            $lease_data = isset($lease_data[0]) ? $lease_data[0] : '';
            $lease_data['lease_agreement_date'] = date('d/m/Y', strtotime($lease_data['lease_agreement_date']));
            $lease_data['lease_start_date'] = date('d/m/Y', strtotime($lease_data['lease_start_date']));
            $lease_data['lease_end_date'] = date('d/m/Y', strtotime($lease_data['lease_end_date']));
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        }
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

        return view('admin.LandEntryManagement.Leasemanagement.add', $this->data);
        // return view('admin.Leasemanagement.add', $this->data);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
//    public function leaseList(Request $request) {
//        $this->data['title'] = 'Dalmia-lams::Lease/List';
//        $this->data['pageHeading'] = 'Lease <span class="text-danger" >List</span>';
//        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
//        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
//        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
//        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
//        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
//        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
//        $this->data['include_script_view'] = 'admin.LeaseManagement.listscript';
//        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
//        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
//        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
//        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
//
//        $posted_data = $request->all();
//        // t($posted_data);
//        $cond = '(1=1) ';
//        if ($posted_data) {
//            $posted_lease_data = isset($posted_data['lease']) ? $posted_data['lease'] : '';
//            if (!empty($posted_lease_data['lease_start_date']) && !empty($posted_lease_data['lease_end_date'])) {
//                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_start_date'])));
//                $end_date = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_end_date'])));
//                $cond.= " and (lease_start_date between '$start_date' and '$end_date') and (lease_end_date between '$start_date' and '$end_date')";
//            }
//            // t($posted_lease_data,1);
//            $this->data['lease_data'] = $posted_lease_data;
//            $this->data['dataPresent'] = '';
//        } else {
//            $this->data['dataPresent'] = '';
//        }
//
//        $this->data['lease'] = $lease = LeaseModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
//
//        //t($lease,1);
//
//        return view('admin.Leasemanagement.list', $this->data);
//    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_lease_data = isset($posted_data['lease']) ? $posted_data['lease'] : '';
        //   t($posted_lease_data, 1);
        $registration_id = isset($posted_lease_data['registration_id']) ? $posted_lease_data['registration_id'] : '';
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
            if ($validator->fails()) {
                return redirect('land-details-entry/lease/add/' . $id . '?reg_uniq_no=' . $registration_id)
                                ->withErrors($validator, 'lease')
                                ->withInput();
            }
            if (!empty($doc_file)) {
                if (in_array($ext, $this->allowed_types)) {
                    $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
                } else {
                    //  $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
                    $msg = UtilityModel::getMessage('These type of files are not allowed!', 'error');
                    return redirect('land-details-entry/lease/add/' . $id . '?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
                }
            }
            $data_to_update = $posted_lease_data;
            // $data_to_update['lease_agreement_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_agreement_date'])));
            $data_to_update['percentage_escalation'] = (int) $posted_lease_data['percentage_escalation'];
            $data_to_update['lease_start_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_start_date'])));
            $data_to_update['lease_end_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_end_date'])));
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['created_at'] = Carbon::now();
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['registration_id'] = $registration_id;
            if (isset($file_path) && $file_path) {
                $data_to_update['lessor_doc_path'] = $file_path;
                $data_to_update['file_type'] = isset($ext) ? $ext : '';
            }

            $update = LeaseModel::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('Lease data updated successfully!');
            if ($update) {
                if ($posted_data['save_lease'] == 'save') {
                    return redirect('land-details-entry/lease/add/' . $id . '?reg_uniq_no=' . $registration_id)->with('message', $msg);
                } else if ($posted_data['save_lease'] == 'save_continue') {
                    return redirect('land-details-entry/lease/add/' . $id . '?reg_uniq_no=' . $registration_id)->with('message', $msg);
                }
            }
        } else {
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
            //  exit;
            //t($posted_lease_data);
            $data_to_insert = $posted_lease_data;
            // $data_to_insert['lease_agreement_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_agreement_date'])));
            $data_to_insert['percentage_escalation'] = (int) $posted_lease_data['percentage_escalation'];
            $data_to_insert['lease_start_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_start_date'])));
            $data_to_insert['lease_end_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_lease_data['lease_end_date'])));
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['registration_id'] = $registration_id;
            $data_to_insert['lessor_doc_path'] = isset($file_path) ? $file_path : '';
            $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            //  t($data_to_insert, 1);

            $insert_id = LeaseModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Lease data saved successfully!');
            if ($insert_id) {
                if ($posted_data['save_lease'] == 'save') {
                    return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                } else if ($posted_data['save_lease'] == 'save_continue') {
                    return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                }
            }
        }
    }

    public function leaseView($id = null) {

        $this->data['title'] = 'Dalmia-lams::Lease/View';
        $this->data['pageHeading'] = 'Lease Details : ' . $id;

        if (empty($id)) {
            return redirect('lease-management/add');
        } else {
            if ($id) {
                $lease_data = LeaseModel::where(['id' => $id])->get()->toArray();
                $lease_data = isset($lease_data[0]) ? $lease_data[0] : '';
                $lease_data['lease_agreement_date'] = date('d/m/Y', strtotime($lease_data['lease_agreement_date']));
                $lease_data['lease_start_date'] = date('d/m/Y', strtotime($lease_data['lease_start_date']));
                $lease_data['lease_end_date'] = date('d/m/Y', strtotime($lease_data['lease_end_date']));
                //t($lease_data, 1);
                $this->data['lease_data'] = $lease_data;
                // t($lease_data,1);
            }
            return view('admin.LandEntryManagement.Leasemanagement.view', $this->data);
            //return view('admin.Leasemanagement.view', $this->data);
        }
    }

}
