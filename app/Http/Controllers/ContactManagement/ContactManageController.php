<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ContactManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Contact\ContactModel;
use App\Models\UtilityModel;
use DB;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class ContactManageController extends Controller {

    //put your code here
    /**
     * 
     */
    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Contact-Management';
        $this->data['include_script_view'] = 'admin.ContactManagement.script';
        $this->data['states'] = $this->getAllStates();
    }

    /**
     * 
     * Show the User lists
     */
    public function index(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['pageHeading'] = 'Contact Details <span class="text-danger" >Add</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';

        $contact = ContactModel::where(['fl_archive' => 'N'])->get()->toArray();
        $this->data['contactLists'] = $contact;

        //Contact Edit
        $contact_no = $request->input('contact_no');
        if ($contact_no) {
            $this->data['contact_no'] = $contact_no;
            $contact_data = ContactModel::where(['id' => $contact_no])->get()->toArray();
            $this->data['contact_data'] = $contact_data[0];

            if ($contact_data[0]['state_id']) {
                $this->data['city_info'] = $this->getAllCity($contact_data[0]['state_id']);
            }

            $this->data['pageHeading'] = 'Contact Details <span class="text-danger" >Edit</span>';
        }

        return view('admin.ContactManagement.add', $this->data);
    }

    public function processData(Request $request) {

        $posted_data = $request->all();
        //t($posted_data);die();
        $posted_contact_data = isset($posted_data['contact']) ? $posted_data['contact'] : '';

        $rules = [
            'contact.name' => 'required',
        ];
        $field_names = [
            'contact.name' => 'Name',
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($field_names);

        if ($posted_data['contact_no']) {

            if ($validator->fails()) {
                return redirect('contact?contact_no=' . $posted_data['contact_no'])
                                ->withErrors($validator, 'contact')
                                ->withInput();
            }
            $data_to_update = $posted_contact_data;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //t($data_to_insert);die('akash');
            $update_id = ContactModel::where(['id' => $posted_data['contact_no']])->update($data_to_update);
            if ($update_id) {
                $msg = UtilityModel::getMessage('Contact data update successfully!');
                return redirect('contact')->with('message', $msg);
            }
        } else {
            if ($validator->fails()) {
                return redirect('contact')
                                ->withErrors($validator, 'contact')
                                ->withInput();
            }

            $data_to_insert = $posted_contact_data;
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = ContactModel::insertGetId($data_to_insert);
            if ($insert_id) {
                $msg = UtilityModel::getMessage('Contact data saved successfully!');
                return redirect('contact')->with('message', $msg);
            }
        }
    }

}
