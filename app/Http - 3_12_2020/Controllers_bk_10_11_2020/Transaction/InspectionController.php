<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\Transaction\InspectionModel;
use App\Models\Transaction\MultipleDocsModel;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\UtilityModel;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use JsValidator;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class InspectionController extends Controller {

    //put your code here

    protected $validationRules = [
        'inspection.state_id' => 'required',
        'inspection.insp_date' => 'required',
        'inspection.encroachment' => 'required',
            //'inspection.encroachment_type' => 'required',
    ];
    protected $field_names = [
        'inspection.state_id' => 'State',
        'inspection.insp_date' => 'Date',
        'inspection.encroachment' => 'Encroachment',
            //'inspection.encroachment_type' => 'Encroachment Type',
    ];

    public function __construct() {
        parent:: __construct();

        $this->allowed_types = [ 'pdf', 'mp4', 'ogg', 'jpeg', 'jpg'];
        $this->upload_dir = 'assets\uploads\Inspection';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Transaction-inspection';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        $this->data['encroachment_type'] = $this->getCodesDetails('encroachment_type');
        $this->data['include_script_view'] = 'admin.Transaction.Inspection.script';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->assgined_districts = [];
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

                $this->assgined_districts = $assgined_districts;
                //  t($this->assgined_districts,1);
                $this->assgined_districts_str = ($assgined_districts) ? "'" . implode("','", $assgined_districts) . "'" : '';
                // t($this->assgined_districts_str,1);
                //$reg_id_arr = RegistrationModel::whereRaw("district_id in ($assgined_districts_str)")->orderBy('id')->lists('id', 'id')->toArray();
            }
        }
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        $this->data['pageHeading'] = 'Inspection <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-inspection-Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';


        //Get the survey lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        //Mutation Lists
        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
            $res = InspectionModel::whereRaw(" district_id in ($this->assgined_districts_str)")->where(['fl_archive' => 'N'])->get()->toArray();
        } else {
            $res = InspectionModel::where(['fl_archive' => 'N'])->get()->toArray();
        }
        foreach ($res as $k => $v) {
            $documentDteails = MultipleDocsModel::where(['fl_archive' => 'N', 'reference_id' => $v['id']])->get()->toArray();
            $res[$k]['documentDteails'] = $documentDteails;
        }


        $this->data['inspectionLists'] = $res;

        $this->data['encroachment_info'] = [
            '' => 'Select',
            'Y' => 'Yes',
            'N' => 'No',
        ];

        return view('admin.Transaction.Inspection.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data);die();
        $posted_inspection_data = isset($posted_data['inspection']) ? $posted_data['inspection'] : '';
        //$survey_id = isset($posted_data['survey_id']) ? implode(",", $posted_data['survey_id']) : '';
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);


        //Upload doc file
        $alldoc_file = isset($posted_data['doc_file']) ? $posted_data['doc_file'] : '';
        //t($alldoc_file);


        if ($id) {
            if ($validator->fails()) {
                return redirect('transaction/inspection/add?inspection_no=' . $id)
                                ->withErrors($validator, 'inspection')
                                ->withInput();
            }
            $data_to_update = $posted_inspection_data;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
//            t($data_to_update);
//            die();
            $update = InspectionModel::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('Inspection data updated successfully!');
            if ($update) {
                return redirect('transaction/inspection/add?inspection_no=' . $id)->with('message', $msg);
            }
        } else {
            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('land_inspection_add')) {
                    return redirect('unauthorized-access');
                }
            }

            if ($validator->fails()) {
                return redirect('transaction/inspection/add')
                                ->withErrors($validator, 'inspection')
                                ->withInput();
            }
            $data_to_insert = $posted_inspection_data;
            $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
            $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            //$data_to_insert['survey_id'] = $survey_id;
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
           // $data_to_insert['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //t($data_to_insert);die('akash');
            $insert_id = InspectionModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Inspection data saved successfully!');
            if ($insert_id) {

                //Upload the related document
                if (!empty($alldoc_file)) {
                    foreach ($alldoc_file as $dockey => $doc_file) {

                        $file_name = $doc_file->getClientOriginalName();
                        $file_name = stristr($file_name, '.', true);
                        $ext = $doc_file->getClientOriginalExtension();
                        $new_file_name = $file_name . '_' . time() . '.' . $ext;
                        $file_path = $this->upload_dir . '/' . $new_file_name;
                        if (in_array($ext, $this->allowed_types)) {
                            $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);

                            $data_to_upload['inspection_id'] = $insert_id;
                            $data_to_upload['path'] = $file_path;
                            $data_to_upload['file_type'] = $ext;
                            $data_to_upload['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                            $data_to_upload['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                            $data_to_upload['created_at'] = Carbon::now();
                            MultipleDocsModel::insertGetId($data_to_upload);
                        }
                    }
                }

                //Change the Inspection Status in Survey table
                /* if ($survey_id) {
                  $allSurveyPatta = explode(',', $survey_id);
                  $survey_data_update['inspection_status'] = 'Y';
                  foreach ($allSurveyPatta as $val) {
                  SurveyModel::where(['id' => $val])->update($survey_data_update);
                  }
                  } */
                if ($data_to_insert['survey_id']) {
                    $survey_data_update['inspection_status'] = 'Y';
                    SurveyModel::where(['id' => $data_to_insert['survey_id']])->update($survey_data_update);
                }

                return redirect('transaction/inspection/add')->with('message', $msg);
            }
        }
    }

    public function dropDown(Request $request, $option = true, $json = true) {
        $this->data['typeList'] = $typeList = $request->get('type');
        $this->data['namePrefix'] = $namePrefix = $request->get('namePrefix');
        $this->data['dropdown_type'] = $dropdown_type = $request->get('dropdown_type');
        $this->data['multiple'] = $multiple = $request->get('multiple');

        if ($typeList == 'survey_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $surveys = $this->inspectionSurvey($village_id, 'ajax');
            $this->data['optionList'] = $optionList = $surveys;
        }

        if ($option == 'true')
            return view('admin.common.dropdown', $this->data);
        else {
            if ($json == 'true') {

                echo json_encode($optionList);
            } else {
                return $optionList;
            }
        }
    }

    public function inspectionSurvey($village_id = null, $type = null) {

        if ($village_id && $type == 'ajax') {
            $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
            $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
            if ($registration_ids) {
                $survey_list = SurveyModel::where(['inspection_status' => 'N'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
            } else {
                $survey_list = '';
            }
        }
        return $survey_list;
    }

}
