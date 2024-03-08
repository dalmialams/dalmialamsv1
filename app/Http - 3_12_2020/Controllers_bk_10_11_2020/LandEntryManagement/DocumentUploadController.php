<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\LandEntryManagement;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\DocumentModel;
use App\Models\Transaction\DataLogModel;
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
class DocumentUploadController extends Controller {

    //put your code here
    public $upload_dir = '';
    protected $validationRules = [
        'document.type' => 'required',
        'document.physical_location' => 'required',
    ];
    protected $field_names = [
        'document.type' => 'Document Type',
        'document.physical_location' => 'Physical Location',
    ];

    public function __construct() {
        parent:: __construct();


        $this->allowed_types = ['pdf', 'mp4','PDF','MP4'];
        $this->upload_dir = 'assets/uploads/LandEntryDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        //$this->data['pageHeading'] = 'Document Upload : '.$this->data['reg_uniq_no'];
        $this->data['title'] = 'Dalmia-lams::Document';
        $this->data['section'] = 'document';
        $this->data['document_type'] = $this->getCodesDetails('document_type');
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        //$this->data['title'] = 'Dalmia-lams::Document/Add';
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Document.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['reg_uniq_no'] = $reg_uniq_no = $request->get('reg_uniq_no');
        $this->data['doc_id'] = $doc_id = $request->get('doc_id');

        if ($this->data['registration_converted_flag'] == 'Y') {
            $prvDataLog = DataLogModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(ref_id)), ',') as ref_id_str")->where(['pre_id' => "$reg_uniq_no", 'fl_archive' => 'N', 'type' => 'document'])->get()->toArray();
            $prvDataLog_Ids = isset($prvDataLog[0]['ref_id_str']) ? $prvDataLog[0]['ref_id_str'] : '';
            $all_docs = ($prvDataLog_Ids) ? DocumentModel::whereRaw("id in ($prvDataLog_Ids)")->get()->toArray() : '';
            $this->data['all_docs'] = $all_docs;
        } else {
            $all_docs = ($reg_uniq_no) ? DocumentModel::where(['registration_id' => "$reg_uniq_no", 'fl_archive' => 'N'])->get()->toArray() : '';
            $this->data['all_docs'] = $all_docs;
        }


        return view('admin.LandEntryManagement.Document.add', $this->data);
    }

    public function edit(Request $request) {
        //$this->data['title'] = 'Dalmia-lams::Document/Add';
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Document.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['reg_uniq_no'] = $reg_uniq_no = $request->get('reg_uniq_no');
        $this->data['doc_id'] = $doc_id = $request->get('doc_id');
        if ($doc_id) { //edit
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('document_upload_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            $doc_details = DocumentModel::find($doc_id)->toArray();
            $this->data['doc_data'] = $doc_details;
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
            // t($doc_details, 1);
        }
        $all_docs = ($reg_uniq_no) ? DocumentModel::where(['registration_id' => "$reg_uniq_no", 'fl_archive' => 'N'])->get()->toArray() : '';
        $this->data['all_docs'] = $all_docs;


        return view('admin.LandEntryManagement.Document.add', $this->data);
    }

    public function view(Request $request) {
        //$this->data['title'] = 'Dalmia-lams::Document/Add';
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Document.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['reg_uniq_no'] = $reg_uniq_no = $request->get('reg_uniq_no');
        $this->data['doc_id'] = $doc_id = $request->get('doc_id');

        if ($this->data['registration_converted_flag'] == 'Y') {
            $prvDataLog = DataLogModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(ref_id)), ',') as ref_id_str")->where(['pre_id' => "$reg_uniq_no", 'fl_archive' => 'N', 'type' => 'document'])->get()->toArray();
            $prvDataLog_Ids = isset($prvDataLog[0]['ref_id_str']) ? $prvDataLog[0]['ref_id_str'] : '';
            $all_docs = ($prvDataLog_Ids) ? DocumentModel::whereRaw("id in ($prvDataLog_Ids)")->get()->toArray() : '';
            $this->data['all_docs'] = $all_docs;
        } else {
            $all_docs = ($reg_uniq_no) ? DocumentModel::where(['registration_id' => "$reg_uniq_no", 'fl_archive' => 'N'])->get()->toArray() : '';
            $this->data['all_docs'] = $all_docs;
        }
        //t($all_docs, 1);
        if ($this->data['viewMode'] == 'true') {
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        }

        return view('admin.LandEntryManagement.Document.add', $this->data);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function docList() {
        $this->data['title'] = 'Dalmia-lams::Registration/List';
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Document.script';
        //$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $res = RegistrationModel::all()->toArray();
        // t($res);exit;
        $this->data['registration'] = $res;
        return view('admin.LandEntryManagement.Registration.list', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data);
        $posted_doc_data = isset($posted_data['document']) ? $posted_data['document'] : '';

        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $registration_id = isset($posted_doc_data['registration_id']) ? $posted_doc_data['registration_id'] : '';


        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
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
                if ($id) {
                    return redirect('land-details-entry/document/edit?reg_uniq_no=' . $registration_id . '&doc_id=' . $id)->with('message', $msg)->withInput();
                } else {
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
                }
            }
        }

        if ($id) {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('document_upload_edit')) {
                    return redirect('unauthorized-access');
                }
            }

            if ($validator->fails()) {
                return redirect('land-details-entry/document/edit?reg_uniq_no=' . $registration_id . '&doc_id=' . $id)
                                ->withErrors($validator, 'document')
                                ->withInput();
            }
            $data_to_update = $posted_doc_data;
            if (!empty($doc_file)) {
                $data_to_update['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
                $data_to_update['file_type'] = isset($ext) ? $ext : '';
            }
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = $this->data['current_user_id'];
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = DocumentModel::where(['id' => $id])->update($data_to_update);
            // $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
            $msg = UtilityModel::getMessage('Document saved successfully!');
            if ($update) {
                if ($posted_data['save_doc'] == 'save') {
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                } else if ($posted_data['save_doc'] == 'save_continue') {
                    //return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    if ($this->user_type !== 'admin') {
                        if ($this->hasPermission('registration_access') && $this->hasPermission('payment_details_add')) {
                            return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('lease_details_add')) {
                            if (isset($this->data['purchase_type_id']) && $this->data['purchase_type_id'] == 'CD00144') {
                                return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                                return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                                return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else {
                                //return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id);
                                return redirect('land-details-entry/document/edit?reg_uniq_no=' . $registration_id . '&doc_id=' . $id);
                            }
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                            return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                            return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else {
                            return redirect('land-details-entry/document/edit?reg_uniq_no=' . $registration_id . '&doc_id=' . $id);
                        }
                    } else {
                        return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    }
                }
            }
        } else {

            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('document_upload_add')) {
                    return redirect('unauthorized-access');
                }
            }

            if ($validator->fails()) {
                return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)
                                ->withErrors($validator, 'document')
                                ->withInput();
            }

            // t($posted_registration_data);
            $data_to_insert = $posted_doc_data;
            $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
            $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            $data_to_insert['created_at'] = Carbon::now();
            // $data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['crt_id'] = $this->data['current_user_id'];
            // $data_to_insert['upd_id'] = $this->data['current_user_id'];
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = DocumentModel::insertGetId($data_to_insert);
            $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Document saved successfully!</strong></div>';
            if ($insert_id) {
                //return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                if ($posted_data['save_doc'] == 'save') {
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                } else if ($posted_data['save_doc'] == 'save_continue') {
                    //return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    if ($this->user_type !== 'admin') {
                        if ($this->hasPermission('registration_access') && $this->hasPermission('payment_details_add')) {
                            return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('lease_details_add')) {
                            if (isset($this->data['purchase_type_id']) && $this->data['purchase_type_id'] == 'CD00144') {
                                return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                                return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                                return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else {
                                return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id);
                            }
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                            return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                            return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else {
                            return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id);
                        }
                    } else {
                        return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    }
                }
            }
        }
    }

    public function documentDelete(Request $request) {

        $reg_uniq_no = $request->input('reg_uniq_no');
        $document_no = $request->input('document_no');

        if (!empty($reg_uniq_no) && !empty($document_no)) {
            $data_to_update['fl_archive'] = 'Y';
            $delete_id = DocumentModel::where(['id' => $document_no])->update($data_to_update);
            if ($delete_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Document data deleted successfully!</strong></div>';
                return redirect('land-details-entry/document/add?reg_uniq_no=' . $reg_uniq_no)->with('message', $msg);
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
