<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\Transaction\UnderOperationModel;
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
class UnderOperationController extends Controller {

    //put your code here

    protected $validationRules = [
        'operation.state_id' => 'required',
        'operation.survey_id' => 'required',
        'operation.operation_type' => 'required',
    ];
    protected $field_names = [
        'operation.state_id' => 'State',
        'operation.survey_id' => 'Survey No.',
        'operation.operation_type' => 'Operation',
    ];

    public function __construct() {
        parent:: __construct();

        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Transaction-Under Operation';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        $this->data['operation_type'] = $this->getCodesDetails('operation');
        $this->data['include_script_view'] = 'admin.Transaction.UnderOperation.script';
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
            }
        }
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        $this->data['pageHeading'] = 'Under Operation <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-Under Operation-Add';
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
            $res = UnderOperationModel::whereRaw(" district_id in ($this->assgined_districts_str)")->where(['fl_archive' => 'N'])->get()->toArray();
        } else {
            $res = UnderOperationModel::where(['fl_archive' => 'N'])->get()->toArray();
        }
        $this->data['operationLists'] = $res;

        return view('admin.Transaction.UnderOperation.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data);die();
        $posted_operation_data = isset($posted_data['operation']) ? $posted_data['operation'] : '';
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('transaction/under-operation/add?operation_no=' . $id)
                                ->withErrors($validator, 'operation')
                                ->withInput();
            }
            $data_to_update = $posted_operation_data;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = UnderOperationModel::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('Operation data updated successfully!');
            if ($update) {
                return redirect('transaction/under-operation/add?operation_no=' . $id)->with('message', $msg);
            }
        } else {

            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('under_operation_add')) {
                    return redirect('unauthorized-access');
                }
            }

            if ($validator->fails()) {
                return redirect('transaction/under-operation/add')
                                ->withErrors($validator, 'operation')
                                ->withInput();
            }
            $data_to_insert = $posted_operation_data;
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
           // $data_to_insert['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //t($data_to_insert);die('akash');
            $insert_id = UnderOperationModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Operation data saved successfully!');
            if ($insert_id) {
                //Change the Operation Status in Survey table
                if ($data_to_insert['survey_id']) {
                    $survey_data_update['operation_status'] = 'Y';
                    SurveyModel::where(['id' => $data_to_insert['survey_id']])->update($survey_data_update);
                }
                return redirect('transaction/under-operation/add')->with('message', $msg);
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
            $surveys = $this->operationSurvey($village_id, 'ajax');
            $this->data['optionList'] = $optionList = $surveys;
            $onchange = $request->get('onchange');
            $this->data['onchange'] = ($onchange) ? 'onchange=' . $onchange : "";
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

    public function operationSurvey($village_id = null, $type = null) {

        if ($village_id && $type == 'ajax') {
            $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
            $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
            if ($registration_ids) {
                $survey_list = SurveyModel::where(['operation_status' => 'N'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
            } else {
                $survey_list = '';
            }
        }
        return $survey_list;
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
