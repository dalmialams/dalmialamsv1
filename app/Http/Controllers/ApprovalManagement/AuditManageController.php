<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Audit\AuditMasterModel;
use App\Models\UtilityModel;
use DB;
use JsValidator;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class AuditManageController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [
        'auditmaster.sort_order' => 'required|numeric',
        'auditmaster.description' => 'required',
    ];
    protected $field_names = [
        'auditmaster.sort_order' => 'Sort Order',
        'auditmaster.description' => 'Description'
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Audit-Master';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    public function add($id = null) {

        $this->data['pageHeading'] = (!$id) ? 'Audit-Master  <span class="text-danger" >Add</span>' : 'Audit-Master  <span class="text-danger" >Edit</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.AuditManagement.script';

        $this->data['id'] = $id;
        if ($id) {
            $audit_info = AuditMasterModel::where(['id' => $id])->get()->toArray();
            // t($audit_info, 1);
            $this->data['audit_info'] = isset($audit_info[0]) ? $audit_info[0] : '';
        }
        $auditMasterLists = AuditMasterModel::where(['fl_archive' => 'N'])->orderBy('sort_order', 'desc')->get()->toArray();
        $this->data['auditMasterLists'] = $auditMasterLists;
        //t($auditMasterLists,1);

        return view('admin.AuditManagement.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_audit_data = isset($posted_data['auditmaster']) ? $posted_data['auditmaster'] : '';
        //t($posted_audit_data, 1);
        $audit_unique_name = strtolower($posted_audit_data['description']);
        $audit_unique_name = str_replace(" ", "_", $audit_unique_name);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('user-management/audit/add/' . $id)
                                ->withErrors($validator, 'audit')
                                ->withInput();
            }

            $existing_description = AuditMasterModel::whereraw("id <> '$id'")->where(['description' => $posted_audit_data['description']])->get()->toArray();
            $existing_sort_order = AuditMasterModel::whereraw("id <> '$id'")->where(['sort_order' => $posted_audit_data['sort_order']])->get()->toArray();
            if (!empty($existing_sort_order)) {
                $msg = UtilityModel::getMessage('Audit Master Sort order already assigned!', 'error');
                return redirect('user-management/audit/add/' . $id)->with('message', $msg)->withInput();
            }
            if (!empty($existing_description)) {
                $msg = UtilityModel::getMessage('Audit Master Description already exists!', 'error');
                return redirect('user-management/audit/add/' . $id)->with('message', $msg)->withInput();
            }

            $data_to_update = $posted_audit_data;
            $data_to_update['audit_description_unique'] = $audit_unique_name;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $update = AuditMasterModel::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('Audit Master Data updated successfully!');
            if ($update) {
                return redirect('user-management/audit/add/' . $id)->with('message', $msg);
            }
        } else {
            if ($validator->fails()) {
                return redirect('user-management/audit/add/')
                                ->withErrors($validator, 'audit')
                                ->withInput();
            }
            $existing_description = AuditMasterModel::where(['description' => $posted_audit_data['description']])->get()->toArray();
            $existing_sort_order = AuditMasterModel::where(['sort_order' => $posted_audit_data['sort_order']])->get()->toArray();
            if (!empty($existing_sort_order)) {
                $msg = UtilityModel::getMessage('Audit Master Sort order already assigned!', 'error');
                return redirect('user-management/audit/add/')->with('message', $msg)->withInput();
            }
            if (empty($existing_description)) {
                $data_to_insert = $posted_audit_data;
                $data_to_insert['audit_description_unique'] = $audit_unique_name;
                $data_to_insert['created_at'] = Carbon::now();
                $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                //t($data_to_insert, 1);
                $insert_id = AuditMasterModel::insertGetId($data_to_insert);

                $msg = UtilityModel::getMessage('Audit Master Data saved successfully!');
                if ($insert_id) {
                    return redirect('user-management/audit/add/')->with('message', $msg);
                }
            } else {
                $msg = UtilityModel::getMessage(' Audit Master Description already exists!', 'error');
                return redirect('user-management/audit/add/')->with('message', $msg)->withInput();
            }
            // t($data_to_insert);
        }
    }

}
