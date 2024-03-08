<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\PaymentDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\LandDetailsManagement\PaymentModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\UtilityModel;
use JsValidator;

/**
 * Description of PaymentDetails
 *
 * @author user-98-pc
 */
class PaymentDetails extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [
        'payment.registration_id' => 'required',
        'payment.pay_type' => 'required',
        'payment.pay_mode' => 'required',
        //'payment.reference_no' => 'required',
        'payment.pay_date' => 'required',
        'payment.amount' => 'required|numeric',
    ];
    protected $field_names = [
        'payment.registration_id' => 'Regn No',
        'payment.pay_type' => 'Payment Type',
        'payment.pay_mode' => 'Mode',
        // 'payment.reference_no' => 'Ref No',
        'payment.pay_date' => 'Date',
        'payment.amount' => 'Amount'
    ];

    public function __construct() {
        parent:: __construct();

        $this->allowed_types = [ 'pdf', 'mp4'];
        $this->upload_dir = 'assets\uploads\PaymentDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Payment-Details';
        $this->data['section'] = 'payment';
        $this->data['payment_mode'] = $this->getCodesDetails('payment_mode');
        $this->data['payment_type'] = $this->getCodesDetails('payment_type');
        $this->data['include_script_view'] = 'admin.PaymentDetails.script';
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

        $this->data['pageHeading'] = 'Payment Details <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Payment/Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        //Referance registration no
        $reg_uniq_no = $request->input('reg_uniq_no');
        $this->data['reg_uniq_no'] = $reg_uniq_no;

        //Get the payment lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {

            $reg_id_arr = RegistrationModel::whereRaw("district_id in ($this->assgined_districts_str)")->orderBy('id')->lists('id', 'id')->toArray();
        } else {
            $reg_id_arr = RegistrationModel::orderBy('id')->lists('id', 'id')->toArray();
        }

        $cond = '(1=1) ';
        if ($this->user_type !== 'admin') {
            $reg_id_str = ($reg_id_arr) ? "'" . implode("','", $reg_id_arr) . "'" : '';
            $reg_id_str ? $cond.= " and registration_id in ($reg_id_str)" : '';
            $this->data['paymentLists'] = $lease = PaymentModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
        } else {
            $this->data['paymentLists'] = $lease = PaymentModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
        }

        $reg_id_arr = array_merge(array('' => 'Select'), $reg_id_arr);
        $this->data['reg_id_arr'] = $reg_id_arr;
        return view('admin.PaymentDetails.add', $this->data);
    }

    /**
     * 
     * @param type $id
     * @return string
     */
    public function edit(Request $request, $id = null) {

        $this->data['pageHeading'] = 'Payment Details <span class="text-danger" >Edit</span>';
        $this->data['title'] = 'Dalmia-lams::Payment/Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        //Referance registration no
        $reg_uniq_no = $request->input('reg_uniq_no');
        $this->data['reg_uniq_no'] = $reg_uniq_no;

        //Get the payment lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {

            $reg_id_arr = RegistrationModel::whereRaw("district_id in ($this->assgined_districts_str)")->orderBy('id')->lists('id', 'id')->toArray();
        } else {
            $reg_id_arr = RegistrationModel::orderBy('id')->lists('id', 'id')->toArray();
        }

        if (!$id) {
            return redirect('payment/add');
        } else {          
            $payment_exist = PaymentModel::where(['id' => $id])->get()->toArray();          
            $payment_reg_id = PaymentModel::where(['id' => $id])->value('registration_id');
            if (empty($payment_exist) && !array_key_exists($payment_reg_id, $reg_id_arr)) {
                return redirect('payment/add');
            }
        }

        $cond = '(1=1) ';
        if ($this->user_type !== 'admin') {
            $reg_id_str = ($reg_id_arr) ? "'" . implode("','", $reg_id_arr) . "'" : '';
            $reg_id_str ? $cond.= " and registration_id in ($reg_id_str)" : '';
            $this->data['paymentLists'] = $lease = PaymentModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
        } else {
            $this->data['paymentLists'] = $lease = PaymentModel::whereRaw($cond)->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray();
        }

        //Payment Edit
        $payment_no = $request->input('payment_no');
        if ($id) {
            $this->data['payment_no'] = $id;
            $payment_data = PaymentModel::where(['id' => $id])->get()->toArray();
            $this->data['payment_data'] = isset($payment_data[0]) ? $payment_data[0] : '';
            //$this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        }

        $reg_id_arr = RegistrationModel::orderBy('id')->lists('id', 'id')->toArray();
        $reg_id_arr = array_merge(array('' => 'Select'), $reg_id_arr);
        $this->data['reg_id_arr'] = $reg_id_arr;
        return view('admin.PaymentDetails.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data);die();
        $posted_payment_data = isset($posted_data['payment']) ? $posted_data['payment'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);

        //Upload doc file
        $doc_file = isset($posted_data['doc_file']) ? $posted_data['doc_file'] : '';
        if (!empty($doc_file)) {
            $file_name = $doc_file->getClientOriginalName();
            $file_name = stristr($file_name, '.', true);
            $ext = $doc_file->getClientOriginalExtension();
            $new_file_name = $file_name . '_' . time() . '.' . $ext;
            $file_path = $this->upload_dir . '/' . $new_file_name;
            if (in_array($ext, $this->allowed_types)) {
                $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
            } else {
                //  $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
                $msg = UtilityModel::getMessage('This type of files are not allowed!', 'error');
                if ($posted_data['payment_no']) {
                    return redirect('payment/edit/' . $posted_data['payment_no'])->with('message', $msg)->withInput();
                } else {
                    return redirect('payment/add')->with('message', $msg)->withInput();
                }
            }
        }

        if ($posted_data['payment_no']) {

            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('payment_edit')) {
                    return redirect('unauthorized-access');
                }
            }

            if ($validator->fails()) {
                return redirect('payment/edit/' . $posted_data['payment_no'])
                                ->withErrors($validator, 'payment')
                                ->withInput();
            }
            $data_to_insert = $posted_payment_data;
            if (!empty($doc_file)) {
                $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
                $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            }
            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['upd_id'] = $this->data['current_user_id'];
            //t($data_to_insert);die('akash');
            $update_id = PaymentModel::where(['id' => $posted_data['payment_no']])->update($data_to_insert);
            if ($update_id) {
                //$msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Payment data update successfully!</strong></div>';
                $msg = UtilityModel::getMessage('Payment data updated successfully!');
                return redirect('payment/edit/' . $posted_data['payment_no'])->with('message', $msg);
            }
        } else {

            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('payment_add')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('payment/add')
                                ->withErrors($validator, 'payment')
                                ->withInput();
            }
            $data_to_insert = $posted_payment_data;
            $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
            $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['crt_id'] = $this->data['current_user_id'];
            $data_to_insert['upd_id'] = $this->data['current_user_id'];
            //t($data_to_insert);die('akash');
            $insert_id = PaymentModel::insertGetId($data_to_insert);
            if ($insert_id) {
                $msg = UtilityModel::getMessage('Payment data saved successfully!');
                if ($posted_data['submit_payment'] == 'save_continue') {
                    return redirect('land-details-entry/registration/add')->with('message', $msg);
                } else {
                    return redirect('payment/add')->with('message', $msg);
                }
            }
        }
    }

    public function paymentDelete(Request $request) {

        $payment_no = $request->input('payment_no');

        if (!empty($payment_no)) {
            //$delete_id = SurveyModel::where('id', '=', $survey_no)->delete();
            $data_to_update['fl_archive'] = 'Y';
            $delete_id = PaymentModel::where(['id' => $payment_no])->update($data_to_update);
            if ($delete_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Payment data deleted successfully!</strong></div>';

                if ($this->user_type == 'admin' || $this->hasPermission('payment_add')) {
                    return redirect('payment/add')->with('message', $msg);
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
