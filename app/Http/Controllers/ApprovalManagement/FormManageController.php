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
use App\Models\Form\FormModel;
use App\Models\UtilityModel;
use DB;
use JsValidator;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class FormManageController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [
        'form.form_name' => 'required',
        'form.status' => 'required',
        'form.access_rights' => 'required',
        'form.sort_order' => 'required|numeric',
            // 'form.description' => 'required',
    ];
    protected $field_names = [
        'form.name' => 'Form Name',
        'form.status' => 'Status',
        'form.access_rights' => 'Access Rights',
        'form.sort_order' => 'Sort Order',
            // 'form.description' => 'Description'
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Form-Management';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    public function add($id = null) {
        $this->data['pageHeading'] = (!$id) ? 'Form Management  <span class="text-danger" >Add</span>' : 'Form Management  <span class="text-danger" >Edit</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.FormManagement.script';

        $this->data['id'] = $id;
        if ($id) {
            $form_info = FormModel::where(['id' => $id])->get()->toArray();
            // t($form_info, 1);
            $this->data['form_data'] = isset($form_info[0]) ? $form_info[0] : '';
        }
        $forms = FormModel::where(['fl_archive' => 'N'])->orderBy('sort_order', 'desc')->get()->toArray();
        $this->data['forms'] = $forms;
        $this->data['status'] = [
            '' => 'Select',
            'Y' => 'Active',
            'N' => 'Inactive',
        ];
        //t($forms,1);

        return view('admin.FormManagement.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_form_data = isset($posted_data['form']) ? $posted_data['form'] : '';
        //  t($posted_form_data, 1);
        $form_unique_name = strtolower($posted_form_data['form_name']);
        $form_unique_name = str_replace(" ", "_", $form_unique_name);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('user-management/form/add/' . $id)
                                ->withErrors($validator, 'form')
                                ->withInput();
            }
//            $current_sort_order = FormModel::where(['id' => $id])->value('sort_order');
//            if ($current_sort_order !== $posted_form_data['sort_order']) {
//                $existing_sort_order = FormModel::where(['sort_order' => $posted_form_data['sort_order']])->get()->toArray();
//                if (!empty($existing_sort_order)) {
//                    $msg = UtilityModel::getMessage('Sort order already assigned!', 'error');
//                    return redirect('user-management/form/add/' . $id)->with('message', $msg)->withInput();
//                }
//            }

            $data_to_update = $posted_form_data;
            //$data_to_update['form_name_unique'] = $form_unique_name;
            $data_to_update['updated_at'] = Carbon::now();
            $update = FormModel::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('Form updated successfully!');
            if ($update) {
                return redirect('user-management/form/add/' . $id)->with('message', $msg);
            }
        } else {
            if ($validator->fails()) {
                return redirect('user-management/form/add/')
                                ->withErrors($validator, 'form')
                                ->withInput();
            }
            $existing_form = FormModel::where(['form_name' => $posted_form_data['form_name']])->get()->toArray();
            $existing_sort_order = FormModel::where(['sort_order' => $posted_form_data['sort_order']])->get()->toArray();
            if (!empty($existing_sort_order)) {
                $msg = UtilityModel::getMessage('Sort order already assigned!', 'error');
                return redirect('user-management/form/add/')->with('message', $msg)->withInput();
            }
            if (empty($existing_form)) {
                $data_to_insert = $posted_form_data;
                $data_to_insert['form_name_unique'] = $form_unique_name;
                $data_to_insert['created_at'] = Carbon::now();
                //t($data_to_insert, 1);
                $insert_id = FormModel::insertGetId($data_to_insert);

                $msg = UtilityModel::getMessage('Form data saved successfully!');
                if ($insert_id) {
                    return redirect('user-management/form/add/')->with('message', $msg);
                }
            } else {
                $msg = UtilityModel::getMessage('Form already exists!', 'error');
                return redirect('user-management/form/add/')->with('message', $msg)->withInput();
            }
            // t($data_to_insert);
        }
    }

}
