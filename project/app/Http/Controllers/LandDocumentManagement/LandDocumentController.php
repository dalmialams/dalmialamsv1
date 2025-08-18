<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\LandDocumentManagement;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\LandDocumentModel;
// use App\Models\Common\DistrictModel;
// use App\Models\Common\BlockModel;
// use App\Models\Common\StateModel;
use App\Models\UtilityModel;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;
use Illuminate\Support\Facades\Auth;



/**
 *
 * @author user-98-pc
 */
class LandDocumentController extends Controller
{

    public $upload_dir = '';
    //put your code here
    protected $validationRules = [
        'land_document.document_no' => 'required',
        'land_document.document_type_id' => 'required',
        'land_document.property_id' => 'required',
        'land_document.physical_file_loaction' => 'required',
        'land_document.locker_no' => 'required',
        'land_document.uploaded_date' => 'required',
    ];
    protected $field_names = [
        'land_document.document_no' => 'Document ID',
        'land_document.document_type_id' => 'Document Type',
        'land_document.property_id' => 'Associated Property Id',
        'land_document.physical_file_loaction' => 'Physical File Location',
        'land_document.locker_no' => ' Locker Number',
        'land_document.uploaded_date' => 'Date of Upload',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Land Document Management';
        $this->data['section'] = 'land document';
        $this->upload_dir = 'assets/uploads/LandDocuments';
        $this->allowed_types = ['pdf', 'mp4', 'PDF', 'MP4', 'jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'doc', 'DOC', 'docx', 'DOCX', 'xls', 'XLS', 'xlsx', 'XLSX', 'csv', 'CSV'];

        $this->middleware(function ($request, $next) {

            $this->data['document_type_list'] = $this->getAllDocumentType();
            $this->data['property_id_list'] = $this->getAllPropertyIds();
            return $next($request);
        });


        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
        ini_set('max_execution_time', 18000);
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request)
    {

        //  $this->data['title'] = 'Dalmia-lams::Patta/Add';
        $this->data['pageHeading'] = 'Land Document <span class="text-danger" style="color: #db5565;" >Add </span>';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['include_script_view'] = 'admin.LandDocumentManagement.land_document.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['land_document_data'] = '';
        $this->data['user_name'] = Auth::user()->user_name;
       
        return view('admin.LandDocumentManagement.land_document.add', $this->data);
    }

    public function edit(Request $request)
    {
        $posted_data = $request->all();
        $land_doc_id = isset($posted_data['land_doc_id']) ? decrypt($posted_data['land_doc_id']) : '';

        $this->data['pageHeading'] = 'Land Document <span class="text-danger" >Edit</span>';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['include_script_view'] = 'admin.LandDocumentManagement.land_document.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';


        if (!empty($land_doc_id)) {  /// for edit
            
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('land_document_access') && !$this->hasPermission('land_document_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            // if ($this->data['viewMode'] == 'true') {
            //     return redirect('land-details-entry/land-document/edit?land_doc_id=' . encrypt($land_doc_id));
            // }
            
            $land_document_info = LandDocumentModel::find($land_doc_id)->toArray();
            $fileNameArray = [];
            $this->data['land_document_data'] = $land_document_info;
            $fileNameString = $land_document_info['file_name'];
            if(!empty($fileNameString)){
                $fileNameArray = explode(',', $fileNameString);
            }
            $this->data['document_list'] = $fileNameArray;
            $this->data['pageHeading'] = 'Land Document <span class="text-danger" >Edit</span>';

        }
        $this->data['user_name'] = Auth::user()->user_name;
        return view('admin.LandDocumentManagement.land_document.add', $this->data);
    }

    

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function LandDocumentList(Request $request) {

        $this->data['title'] = 'Dalmia-lams::Land Document/List';
        $this->data['pageHeading'] = 'Land Document <span class="text-danger" >Search</span>';
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.LandDocumentManagement.land_document.listscript';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        
        
        $posted_data = $request->all();
       

        $land_list = LandDocumentModel::selectRaw('
            "T_LAND_DOCUMENT_MASTER"."id" as land_doc_id,
            "T_LAND_DOCUMENT_MASTER"."document_no",
            "T_LAND_DOCUMENT_MASTER"."document_type_id",
            "T_LAND_DOCUMENT_MASTER"."property_id",
            "T_LAND_DOCUMENT_MASTER"."physical_file_loaction",
            "T_LAND_DOCUMENT_MASTER"."locker_no",
            "T_LAND_DOCUMENT_MASTER"."uploaded_by",
            "T_LAND_DOCUMENT_MASTER"."uploaded_date",
            "T_LAND_DOCUMENT_MASTER"."crt_id",
            "T_LAND_DOCUMENT_MASTER"."fl_archive",
            "T_PROPERTY_MASTER"."property_name",
            "T_CODES"."cd_desc" as document_type_name
        ')
        ->leftJoin('T_PROPERTY_MASTER', 'T_PROPERTY_MASTER.id', '=', 'T_LAND_DOCUMENT_MASTER.property_id')
        ->leftJoin('T_CODES', 'T_CODES.id', '=', 'T_LAND_DOCUMENT_MASTER.document_type_id');
        //->where('T_LAND_DOCUMENT_MASTER.fl_archive', 'N');

        if ($posted_data) {
            $allSearchData = isset($posted_data['land_document']) ? $posted_data['land_document'] : [];

            if (!empty($allSearchData['search_document_type_id'])) {
                $land_list->where('T_LAND_DOCUMENT_MASTER.document_type_id', $allSearchData['search_document_type_id']);
                $this->data['search_document_type_id'] = $allSearchData['search_document_type_id'];
            }

            if (!empty($allSearchData['search_document_id'])) {
                $land_list->where('T_LAND_DOCUMENT_MASTER.document_no', 'like', '%' . $allSearchData['search_document_id'] . '%');
                $this->data['search_document_id'] = $allSearchData['search_document_id'];
            }

            if(!empty($allSearchData['search_property_id'])){
                $land_list->where('T_LAND_DOCUMENT_MASTER.property_id', $allSearchData['search_property_id']);
                $this->data['search_property_id'] = $allSearchData['search_property_id'];
            }
        }
        

        $land_record = $land_list->orderBy('T_LAND_DOCUMENT_MASTER.document_no', 'DESC')->get()->toArray();

        
        $this->data['land_document_list'] = $land_record;
           
        return view('admin.LandDocumentManagement.land_document.list', $this->data);
    }

    public function processData(Request $request)
    {
        $posted_data = $request->all();
 
        $fileNameArray = [];
        $filePathArr = [];

        $posted_land_data = isset($posted_data['land_document']) ? $posted_data['land_document'] : '';
       
        $id = isset($posted_data['land_id']) ? decrypt($posted_data['land_id']) : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);


        $all_doc_file = isset($posted_data['doc_file']) ? $posted_data['doc_file'] : [];
        


        if ($id) {

            $previous_patta_info = LandDocumentModel::find($id)->toArray();

            $old_file_name = $previous_patta_info['file_name'] ?? '';
            $old_file_path = $previous_patta_info['file_path'] ?? '';

            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('land_document_access') && !$this->hasPermission('land_document_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('land-details-entry/land-document/edit?land_doc_id=' . encrypt($id))
                    ->withErrors($validator, 'land_document')
                    ->withInput();
            }
            $data_to_update = $posted_land_data;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = LandDocumentModel::where(['id' => $id])->update($data_to_update);


            if (count($all_doc_file)>0) {
                foreach ($all_doc_file as $key => $doc_file) {                
                    $file_name = $doc_file->getClientOriginalName();
                    $file_name = stristr($file_name, '.', true);
                    $ext = $doc_file->getClientOriginalExtension();
                    $new_file_name = $file_name . '_' . time() . '.' . $ext;
                    $file_path = $this->upload_dir . '/' . $new_file_name;
                    $file_path_only = $this->upload_dir . '/';
                    if (in_array($ext, $this->allowed_types)) {
                        $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
                        array_push($fileNameArray, $new_file_name);
                        array_push($filePathArr, $file_path_only);
                    } 
                    // else {
                    //     $msg = UtilityModel::getMessage('This type of files are not allowed!', 'error');
                    // }
                }
            }

            if (count($fileNameArray)>0) {

                $uploadedFileName = implode(',', $fileNameArray);

                if($old_file_name != '' && $old_file_name != null) {
                    $mergeredFileName = $old_file_name . ',' . $uploadedFileName;
                } else {
                    $mergeredFileName = $uploadedFileName;
                }

                if($old_file_path != '' && $old_file_path != null) {
                    $mergeredFilePath = $old_file_path;
                } else {
                    $mergeredFilePath = count($filePathArr) > 0 ? $filePathArr[0] : '';
                }
                
                $update_landDoc = LandDocumentModel::where(['id' => $id])->update(['file_name' => $mergeredFileName, 'file_path' => $mergeredFilePath]);
            }

        
            $msg = UtilityModel::getMessage('Land Document data updated successfully!');

            if ($update) {

                if ($posted_data['update_land_document'] == 'update') {
                    return redirect('land-details-entry/land-document/list')->with('message', $msg);
                } else {
                    return redirect('land-details-entry/land-document/list')->with('message', 'Something went wrong!');
                }
            }else {
                return redirect('land-details-entry/land-document/list')->with('message', 'Something went wrong!');
            }
        } else {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('land_document_access') && !$this->hasPermission('land_document_add')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('land-details-entry/land-document/add')
                    ->withErrors($validator, 'land_document')
                    ->withInput();
            }
            $data_to_insert = $posted_land_data;
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = LandDocumentModel::insertGetId($data_to_insert);

            if (count($all_doc_file)>0) {
                foreach ($all_doc_file as $key => $doc_file) {                
                    $file_name = $doc_file->getClientOriginalName();
                    $file_name = stristr($file_name, '.', true);
                    $ext = $doc_file->getClientOriginalExtension();
                    $new_file_name = $file_name . '_' . time() . '.' . $ext;
                    $file_path = $this->upload_dir . '/' . $new_file_name;
                    $file_path_only = $this->upload_dir . '/';
                    if (in_array($ext, $this->allowed_types)) {
                        $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
                        array_push($fileNameArray, $new_file_name);
                        array_push($filePathArr, $file_path_only);
                    } 
                    // else {
                    //     $msg = UtilityModel::getMessage('This type of files are not allowed!', 'error');
                    // }
                }
            }

            if (count($fileNameArray)>0 && count($filePathArr)>0) {
                $update_landDoc = LandDocumentModel::where(['id' => $insert_id])->update(['file_name' => implode(',', $fileNameArray), 'file_path' => $filePathArr[0]]);
            }

            $msg = UtilityModel::getMessage('Land Document data saved successfully!');
            if ($insert_id) {
                if ($posted_data['save_land_document'] == 'save') {
                    return redirect('land-details-entry/land-document/list')->with('message', $msg);
                } 
                // else if ($posted_data['save_land_document'] == 'save_continue') {
                //     return redirect('land-details-entry/patta/add?patta_uniq_no=' . $insert_id)->with('message', $msg);
                // }
            }
        }
    }

    
    public function view(Request $request)
    {
        $posted_data = $request->all();
        $id = isset($posted_data['land_doc_id']) ? decrypt($posted_data['land_doc_id']) : '';
        $this->data['title'] = 'Dalmia-lams::Land Document/View';
        $this->data['pageHeading'] = 'Land Document Details';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
       
        $this->data['include_script_view'] = 'admin.LandDocumentManagement.land_document.viewscript';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';

        if (empty($id)) {
            return redirect('land-details-entry/land-document/list');
        } else {
            $land_document_info = LandDocumentModel::selectRaw('
                "T_LAND_DOCUMENT_MASTER"."id" as land_doc_id,
                "T_LAND_DOCUMENT_MASTER"."document_no",
                "T_LAND_DOCUMENT_MASTER"."document_type_id",
                "T_LAND_DOCUMENT_MASTER"."property_id",
                "T_LAND_DOCUMENT_MASTER"."physical_file_loaction",
                "T_LAND_DOCUMENT_MASTER"."locker_no",
                "T_LAND_DOCUMENT_MASTER"."uploaded_by",
                "T_LAND_DOCUMENT_MASTER"."uploaded_date",
                "T_LAND_DOCUMENT_MASTER"."crt_id",
                "T_LAND_DOCUMENT_MASTER"."fl_archive",
                "T_PROPERTY_MASTER"."property_name",
                "T_CODES"."cd_desc" as document_type_name,
                "T_LAND_DOCUMENT_MASTER"."file_name",
                "T_LAND_DOCUMENT_MASTER"."file_path"
            ')
            ->leftJoin('T_PROPERTY_MASTER', 'T_PROPERTY_MASTER.id', '=', 'T_LAND_DOCUMENT_MASTER.property_id')
            ->leftJoin('T_CODES', 'T_CODES.id', '=', 'T_LAND_DOCUMENT_MASTER.document_type_id')->where(['T_LAND_DOCUMENT_MASTER.id' => $id])->get()->toArray();

            if (empty($land_document_info)) {
                return redirect('land-details-entry/land-document/list');
            }
            $this->data['land_document_info'] = $land_document_info[0];

            $fileNameArray = [];
            
            $fileNameString = $land_document_info[0]['file_name'] ?? '';
            if(!empty($fileNameString)){
                $fileNameArray = explode(',', $fileNameString);
            }
            $this->data['document_list'] = $fileNameArray;

            return view('admin.LandDocumentManagement.land_document.view', $this->data);
        }
    }

    public function deleteLandDoc(Request $request){
        $poseted_data = $request->all();
        $land_doc_id = isset($poseted_data['land_doc_id']) ? decrypt($poseted_data['land_doc_id']) : '';
        if(!empty($land_doc_id)){
            $delete_id = LandDocumentModel::where(['id' => $land_doc_id])->delete();
            if ($delete_id) {
                //$msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Land Document data deleted successfully!</strong></div>';
                // return redirect('land-details-entry/land-document/list')->with('message', $msg);

                $msg = 'Land Document data deleted successfully!';
                return response()->json(['status' => 'success', 'message' => $msg]);
            }
        }
         else {
            return redirect('land-details-entry/land-document/list');
        }
    }


    private function hasPermission($permission_name)
    {
        $user_obj = new \App\Models\User\UserModel();
        if ($user_obj->ifHasPermission($permission_name, $this->data['current_user_id'])) {
            return true;
        } else {
            return false;
        }
    }


}
