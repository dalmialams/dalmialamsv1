<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\LandEntryManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\LandDetailsManagement\PaymentModel;
use App\Models\UtilityModel;

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
    public function __construct() {
        parent:: __construct();
        
        $this->allowed_types = [ 'pdf', 'mp4', 'ogg'];
        $this->upload_dir = 'assets\uploads\PaymentDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Payment-Details';
        $this->data['section'] = 'payment';
        $this->data['payment_mode'] = $this->getCodesDetails('payment_mode');
        $this->data['payment_type'] = $this->getCodesDetails('payment_type');
        $this->data['include_script_view'] = 'admin.LandEntryManagement.PaymentDetails.script';
        $this->middleware('auth');
       // echo $this->data['purchase_type_id'];
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Add</span>';
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

        $res = PaymentModel::where(['registration_id' => $reg_uniq_no])->get()->toArray();
        $this->data['paymentLists'] = $res;

        //Payment Edit
        $payment_no = $request->input('payment_no');
        if ($payment_no) {
            $this->data['payment_no'] = $payment_no;
            $payment_data = PaymentModel::where(['id' => $payment_no])->get()->toArray();
            $this->data['payment_data'] = $payment_data[0];
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        }
        if ($this->data['viewMode'] == 'true') {
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        }

        return view('admin.LandEntryManagement.PaymentDetails.add', $this->data);
    }

    /**
     * 
     * @param type $id
     * @return string
     */
    public function edit($id) {
        if (!$id) {
            return 'id is missing';
        }
        $this->data['id'] = $id;
        return view('admin.LandEntryManagement.Registration.edit', $this->data);
    }

    public function processData(Request $request) {
        //  $this->data['purchase_type_id'] = RegistrationModel::where(['id' => $_REQUEST['reg_uniq_no']])->value('purchase_type_id');
        $posted_data = $request->all();
        //t($posted_data);die();
        $reg_type = isset($posted_data['reg_type']) ? $posted_data['reg_type'] : '';
        $posted_payment_data = isset($posted_data['payment']) ? $posted_data['payment'] : '';
        $registration_id = isset($posted_payment_data['registration_id']) ? $posted_payment_data['registration_id'] : '';

        $messages = [
            //'payment.description.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Payment Description is required!</strong></div>',
            'payment.pay_type.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Type is required!</strong></div>',
            'payment.pay_mode.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Mode is required!</strong></div>',
            //'payment.reference_no.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Referance Number is required</strong></div>',
            'payment.pay_date.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Date is required</strong></div>',
            //'payment.pay_bank.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Bank is required</strong></div>',
            'payment.amount.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Amount is required</strong></div>',
            'payment.amount.numeric' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Amount mustbe numeric</strong></div>',
        ];

        $rules = [
            //'payment.description' => 'required',
            'payment.pay_type' => 'required',
            'payment.pay_mode' => 'required',
            //'payment.reference_no' => 'required',
            'payment.pay_date' => 'required',
            //'payment.pay_bank' => 'required',
            'payment.amount' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
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
                if($posted_data['payment_no']){
                    return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id.'&payment_no='.$posted_data['payment_no'])->with('message', $msg)->withInput();
                }else{
                    return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
                }
            }
        }

        if ($posted_data['payment_no']) {

            if ($validator->fails()) {
                return redirect('land-details-entry/payment/add?reg_uniq_no=' . $posted_payment_data['registration_id'] . '&payment_no=' . $posted_data['payment_no'])
                                ->withErrors($validator, 'payment')
                                ->withInput();
            }
            $data_to_insert = $posted_payment_data;
            if (!empty($doc_file)) {
                $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
                $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            }
            $data_to_insert['updated_at'] = Carbon::now();
            //t($data_to_insert);die('akash');
            $update_id = PaymentModel::where(['id' => $posted_data['payment_no']])->update($data_to_insert);
            if ($update_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Payment data update successfully!</strong></div>';
                if ($posted_data['submit_payment'] == 'save_continue') {
                    return redirect('land-details-entry/registration/add')->with('message', $msg);
                } else {
                    return redirect('land-details-entry/payment/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }
            }
        } else {
            if ($validator->fails()) {
                return redirect('land-details-entry/payment/add?reg_uniq_no=' . $posted_payment_data['registration_id'])
                                ->withErrors($validator, 'payment')
                                ->withInput();
            }
            $data_to_insert = $posted_payment_data;
            $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
            $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['updated_at'] = Carbon::now();
            //t($data_to_insert);die('akash');
            $insert_id = PaymentModel::insertGetId($data_to_insert);
            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Payment data saved successfully!</strong></div>';
                if ($posted_data['submit_payment'] == 'save_continue') {

                    if (isset($reg_type) && $reg_type == 'lease') {
                        return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    } else {
                        return redirect('land-details-entry/land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    }
                } else {
                    return redirect('land-details-entry/payment/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }
            }
        }
    }

}
