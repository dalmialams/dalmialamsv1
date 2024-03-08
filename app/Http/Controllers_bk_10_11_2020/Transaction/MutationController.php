<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\PattaModel;
use App\Models\Transaction\MutationModel;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\LandDetailsManagement\RegistrationModel;
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
class MutationController extends Controller {

    //put your code here

    protected $validationRules = [
        'mutation.state_id' => 'required',
        'mutation.patta_id' => 'required',
        'mutation.new_patta_no' => 'required',
        'mutation.new_patta_owner' => 'required',
    ];
    protected $field_names = [
        'mutation.state_id' => 'State',
        'mutation.patta_id' => 'Patta No.',
        'mutation.new_patta_no' => 'New Patta No.',
        'mutation.new_patta_owner' => 'New Patta Owner',
    ];

    public function __construct() {
        parent:: __construct();

        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Transaction-mutation';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        $this->data['patta_list'] = $this->getAllPatta();
        $this->data['include_script_view'] = 'admin.Transaction.Mutation.script';
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

        $this->data['pageHeading'] = 'Mutation <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-mutation-Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';

        //Get the survey lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        //Mutation Lists

        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
            $res = MutationModel::whereRaw(" district_id in ($this->assgined_districts_str)")->where(['fl_archive' => 'N'])->get()->toArray();
        } else {
            $res = MutationModel::where(['fl_archive' => 'N'])->get()->toArray();
        }
        $this->data['mutationLists'] = $res;

        //Mutation Edit
        $mutation_no = $request->input('mutation_no');
        if ($mutation_no) {
            $this->data['mutation_no'] = $mutation_no;
            $mutation_data = MutationModel::where(['id' => $mutation_no])->get()->toArray();
            $this->data['mutation_data'] = $mutation_data[0];

            if ($mutation_data[0]['state_id']) {
                $this->data['district_info'] = $this->getAllDistrict($mutation_data[0]['state_id']);
            }
            if ($mutation_data[0]['district_id']) {
                $this->data['block_info'] = $this->getAllBlock($mutation_data[0]['district_id']);
            }
            if ($mutation_data[0]['block_id']) {
                $this->data['village_info'] = $this->getAllVillage($mutation_data[0]['block_id']);
            }
            if ($mutation_data[0]['village_id']) {
                $this->data['patta_info'] = $patta_info = $this->getAllPatta($mutation_data[0]['village_id'], null);
            }
            if ($mutation_data[0]['patta_id']) {
                $this->data['patta_owner'] = $patta_owner = PattaModel::where(['id' => $mutation_data[0]['patta_id']])->value('patta_owner');
            }

            $this->data['pageHeading'] = 'Mutation <span class="text-danger" >Edit</span>';
        }


        return view('admin.Transaction.Mutation.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data);die();
        $posted_mutation_data = isset($posted_data['mutation']) ? $posted_data['mutation'] : '';
        $survey_id = isset($posted_data['survey_id']) ? implode(",", $posted_data['survey_id']) : '';
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('transaction/mutation/add?mutation_no=' . $id)
                                ->withErrors($validator, 'mutation')
                                ->withInput();
            }
            $data_to_update = $posted_mutation_data;
            $data_to_update['survey_id'] = $survey_id;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = MutationModel::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('Mutation data updated successfully!');
            if ($update) {
                return redirect('transaction/mutation/add?mutation_no=' . $id)->with('message', $msg);
            }
        } else {

            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('mutation_add')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('transaction/mutation/add')
                                ->withErrors($validator, 'mutation')
                                ->withInput();
            }
            $data_to_insert = $posted_mutation_data;
            $data_to_insert['survey_id'] = $survey_id;
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            //$data_to_insert['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //t($data_to_insert);die();
            $insert_id = MutationModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Mutation data saved successfully!');
            if ($insert_id) {

                if ($survey_id) {
                    //Change the Mutation Status in Patta table
                    $patta_info = PattaModel::find($data_to_insert['patta_id'])->toArray();
                    if ($patta_info['mutated_survey_id']) {
                        $insert_mutated_survey_id['mutated_survey_id'] = $patta_info['mutated_survey_id'] . ',' . $survey_id;
                    } else {
                        $insert_mutated_survey_id['mutated_survey_id'] = $survey_id;
                    }

                    $assignedSurveyIds = isset($patta_info['survey_id']) ? explode(",", $patta_info['survey_id']) : '';
                    $updatedSurveyIds = isset($insert_mutated_survey_id['mutated_survey_id']) ? explode(",", $insert_mutated_survey_id['mutated_survey_id']) : '';

                    if (count($assignedSurveyIds) == count($updatedSurveyIds)) {
                        $insert_mutated_survey_id['mutation_status'] = 'Y';
                    } else {
                        $insert_mutated_survey_id['mutation_status'] = 'P';
                    }
                    PattaModel::where(['id' => $data_to_insert['patta_id']])->update($insert_mutated_survey_id);


                    //Change the Mutation Status in Survey table
                    $allPattaSurveyIds = isset($survey_id) ? explode(",", $survey_id) : '';
                    if ($allPattaSurveyIds) {
                        $survey_data_update['mutation_status'] = 'Y';
                        foreach ($allPattaSurveyIds as $val) {
                            SurveyModel::where(['id' => $val])->update($survey_data_update);

                            //Insert The data in Mutation Survey table
                            $mutationSurveyData['survey_no'] = SurveyModel::where(['id' => $val])->value('survey_no');
                            $mutationSurveyData['survey_id'] = $val;
                            $mutationSurveyData['mutation_id'] = $insert_id;
                            $mutationSurveyData['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                            $mutationSurveyData['created_at'] = Carbon::now();
                            $mutationSurveyData['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                            \App\Models\Transaction\MutationSurveyModel::insertGetId($mutationSurveyData);
                        }
                    }
                }
                return redirect('transaction/mutation/add')->with('message', $msg);
            }
        }
    }

    public function populateFields(Request $request) {
        $posted_data = $request->all();
        //  t($posted_data);
        $patta_owner = '';
        $patta_id = isset($posted_data['patta_id']) ? $posted_data['patta_id'] : '';
        $patta_owner = PattaModel::where(['id' => $patta_id])->select('patta_owner')->get()->toArray();
        $patta_owner = isset($patta_owner[0]['patta_owner']) ? $patta_owner[0]['patta_owner'] : '';
        echo json_encode([
            'patta_owner' => $patta_owner
        ]);
    }

    public function dropDown(Request $request, $option = true, $json = true) {
        $this->data['typeList'] = $typeList = $request->get('type');
        $this->data['namePrefix'] = $namePrefix = $request->get('namePrefix');
        $this->data['dropdown_type'] = $dropdown_type = $request->get('dropdown_type');
        $this->data['multiple'] = $multiple = $request->get('multiple');
        $from_mis = $request->get('from_mis');

        if ($typeList == 'survey_id') {
            $patta_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $surveys = $this->getAllPattaSurvey($patta_id, 'ajax', $from_mis);
            $this->data['optionList'] = $optionList = $surveys;
        } else if ($typeList == 'patta_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $pattas = $this->getAllPatta($village_id, 'ajax');
            $this->data['optionList'] = $optionList = $pattas;
            $onchange = $request->get('onchange');
            $this->data['onchange'] = 'onchange=' . $onchange;
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

    public function getAllPattaSurvey($patta_id = null, $type = null, $from_mis = null) {

        if (!$from_mis) {
            if ($patta_id && $type == 'ajax') {
                $patta_info = PattaModel::select('survey_id')->where(['id' => $patta_id])->get()->toArray();
                $servey_ids = isset($patta_info[0]['survey_id']) ? $patta_info[0]['survey_id'] : '';
                $all_survey_id = "'" . implode('\',\'', explode(',', $servey_ids)) . "'";
                $survey_list = SurveyModel::where(['mutation_status' => 'N'])->whereRaw("id in ($all_survey_id)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
            }
        } else {
            if ($patta_id && $type == 'ajax') {
                $patta_info = PattaModel::select('survey_id')->where(['id' => $patta_id])->get()->toArray();
                $servey_ids = isset($patta_info[0]['survey_id']) ? $patta_info[0]['survey_id'] : '';
                $all_survey_id = "'" . implode('\',\'', explode(',', $servey_ids)) . "'";
                $survey_list = SurveyModel::where(['mutation_status' => 'Y'])->whereRaw("id in ($all_survey_id)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
            }
        }

        return $survey_list;
    }

    public function getAllPatta($village_id = null, $type = null) { // Only for mis purpous writen
        if ($village_id && $type == 'ajax') {

            $patta_list = PattaModel::where(['village_id' => $village_id, 'fl_archive' => 'N'])->whereRaw("mutation_status = 'Y' or mutation_status = 'P'")->orderBy('id')->select('id as option_code', 'patta_no as option_desc')->get()->toArray();
            return $patta_list;
        } else if ($village_id && $type == null) {

            $patta_list = PattaModel::where(['village_id' => $village_id, 'fl_archive' => 'N'])->orderBy('id')->lists('patta_no', 'id')->toArray();
            $patta_list = array_merge(array('' => 'select'), $patta_list);
            return $patta_list;
            // t($survey_list, 1);
        } else {
            $patta_list = PattaModel::orderBy('id')->lists('patta_no', 'patta_no')->toArray();
        }

        return $patta_list;
    }

    public function getPattaSurveyDetails(Request $request) {
        $this->data['patta_id'] = $patta_id = $request->get('patta_id');
        $this->data['type'] = $type = $request->get('type');

        if ($patta_id && $type == 'old_patta') {
            $patta_info = PattaModel::select('survey_id')->where(['id' => $patta_id])->get()->toArray();
            $servey_ids = isset($patta_info[0]['survey_id']) ? $patta_info[0]['survey_id'] : '';
            $all_survey_id = "'" . implode('\',\'', explode(',', $servey_ids)) . "'";
            $survey_list = SurveyModel::select('id', 'survey_no')->whereRaw("id in ($all_survey_id)")->orderBy('id')->get()->toArray();
        } elseif ($patta_id && $type == 'new_patta') {
            $patta_info = MutationModel::select('survey_id')->where(['id' => $patta_id])->get()->toArray();
            $servey_ids = isset($patta_info[0]['survey_id']) ? $patta_info[0]['survey_id'] : '';
            $all_survey_id = "'" . implode('\',\'', explode(',', $servey_ids)) . "'";
            $survey_list = SurveyModel::select('id', 'survey_no')->whereRaw("id in ($all_survey_id)")->orderBy('id')->get()->toArray();
        }

        $final_survey_no_list = '<ul>';
        foreach ($survey_list as $val) {
            $final_survey_no_list .= '<li>' . $val['survey_no'] . '</li>';
        }
        $final_survey_no_list .= '</ul>';

        return $final_survey_no_list;
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
