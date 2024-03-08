<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\LandEntryManagement;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\DocumentModel;
use App\Models\UtilityModel;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Description of RegistrationController
 *
 * @author user-98-pc
 */
class DocumentUploadController extends Controller {

    //put your code here
    public $upload_dir = '';

    public function __construct() {
        parent:: __construct();

        //$this->allowed_types = ['txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'jpg', 'png', 'gif','ods','odt','ots'];
        $this->allowed_types = [ 'pdf', 'mp4', 'ogg'];
        $this->upload_dir = 'assets\uploads\LandEntryDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        //$this->data['pageHeading'] = 'Document Upload : '.$this->data['reg_uniq_no'];
        $this->data['title'] = 'Dalmia-lams::Document';
        $this->data['section'] = 'document';
        $this->data['document_type'] = $this->getCodesDetails('document_type');
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        //$this->data['title'] = 'Dalmia-lams::Document/Add';
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Add</span>';
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
            $doc_details = DocumentModel::find($doc_id)->toArray();
            $this->data['doc_data'] = $doc_details;
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
            // t($doc_details, 1);
        }
        $all_docs = ($reg_uniq_no) ? DocumentModel::where(['registration_id' => "$reg_uniq_no"])->get()->toArray() : '';
        $this->data['all_docs'] = $all_docs;
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

        $rules = [
            'document.type' => 'required',
            'document.physical_location' => 'required',
                // 'document.remarks' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);


        $field_names = [
            'document.type' => 'Document Type',
            'document.physical_location' => 'Physical Location',
                // 'document.remarks' => 'Remarks',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($field_names);
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
                if($id){
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id.'&doc_id='.$id)->with('message', $msg)->withInput();
                }else{
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
                }
            }
        }
        if ($validator->fails()) {
            if ($registration_id) {
                return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)
                                ->withErrors($validator, 'document')
                                ->withInput();
            } else {
                return redirect('land-details-entry/document/add')
                                ->withErrors($validator, 'document')
                                ->withInput();
            }
        }
        if ($id) {
            $data_to_update = $posted_doc_data;
            if (!empty($doc_file)) {
                $data_to_update['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
                $data_to_update['file_type'] = isset($ext) ? $ext : '';
            }
            $data_to_update['updated_at'] = Carbon::now();
            $update = DocumentModel::where(['id' => $id])->update($data_to_update);
            // $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
            $msg = UtilityModel::getMessage('Document saved successfully!');
            if ($update) {
                if ($posted_data['save_doc'] == 'save') {
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                } else if ($posted_data['save_doc'] == 'save_continue') {
                    return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                }
            }
        } else {

            // t($posted_registration_data);
            $data_to_insert = $posted_doc_data;
            $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
            $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['updated_at'] = Carbon::now();
            $insert_id = DocumentModel::insertGetId($data_to_insert);
            $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Document saved successfully!</strong></div>';
            if ($insert_id) {
                //return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                if ($posted_data['save_doc'] == 'save') {
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                } else if ($posted_data['save_doc'] == 'save_continue') {
                    return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                }
            }
        }
    }

}
