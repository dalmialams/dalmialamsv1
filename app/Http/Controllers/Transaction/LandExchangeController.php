<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\PattaModel;
use App\Models\Transaction\LandExchangeModel;
use App\Models\Transaction\LandExchangeSurveyModel;
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
class LandExchangeController extends Controller {

    //put your code here

    protected $validationRules = [

        'land_exchange.state_id' => 'required',
        'land_exchange.district_id' => 'required',
        'land_exchange.block_id' => 'required',
        'land_exchange.village_id' => 'required',
    ];
    protected $field_names = [

        'land_exchange.state_id' => 'State',
        'land_exchange.district_id' => 'District',
        'land_exchange.block_id' => 'Block/Taluk',
        'land_exchange.village_id' => 'Village',
    ];

    public function __construct() {
        parent:: __construct();

        $this->allowed_types = [ 'pdf', 'mp4'];
        $this->upload_dir = 'assets\uploads\LandExchangeDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Transaction-Land Exchange';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        //  $this->data['patta_list'] = $this->getAllPatta();

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

        $this->data['pageHeading'] = 'Land Exchange <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-land-exchange-Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        //Get the survey lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';
        $this->data['include_script_view'] = 'admin.Transaction.LandExchange.script';

        //LandExchange Lists

        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
            $res = LandExchangeModel::whereRaw(" district_id in ($this->assgined_districts_str)")->where(['fl_archive' => 'N'])->get()->toArray();
        } else {
            $res = LandExchangeModel::where(['fl_archive' => 'N'])->get()->toArray();
        }
        // t($res,1);
        $this->data['land_exchanges'] = $res;
        $this->data['id'] = '';

        $res = $request->old();


        return view('admin.Transaction.LandExchange.add', $this->data);
    }

    public function edit(Request $request, $id = null) {

        if (!$id) {
            return redirect('transaction/land-exchange/add');
        } else {
            //t($this->assgined_districts, 1);
            $exists = LandExchangeModel::where(['id' => $id])->get()->toArray();
            $dist_id = LandExchangeModel::where(['id' => $id])->value('district_id');
            if ($this->user_type == 'admin') {
                if (empty($exists)) {
                    return redirect('transaction/land-exchange/add');
                }
            } else {
                if (empty($exists) || !in_array($dist_id, $this->assgined_districts)) {
                    return redirect('unauthorized-access');
                }
            }
        }

        $this->data['pageHeading'] = 'Land Exchange (' . $id . ') <span class="text-danger" >Edit</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-land-exchange-Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        //Get the survey lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';
        $this->data['include_script_view'] = 'admin.Transaction.LandExchange.script';

        //LandExchange Lists
        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
            $res = LandExchangeModel::whereRaw(" district_id in ($this->assgined_districts_str)")->where(['fl_archive' => 'N'])->get()->toArray();
        } else {
            $res = LandExchangeModel::where(['fl_archive' => 'N'])->get()->toArray();
        }
        // t($res,1);
        $this->data['land_exchanges'] = $res;
        $this->data['id'] = $id;


        if ($id) {
            $reserved_survey_ids = [];
            //$this->data['land_exchange_no'] = $land_exchange_no;
            $land_exchange_data = LandExchangeModel::where(['id' => $id])->get()->toArray();
            //t($land_exchange_data,1);
            $this->data['land_exchange_data'] = $land_exchange_data[0];
            $reserved_surveys = LandExchangeModel::find($id)->getExchangedSurveys->toArray();
            $this->data['reserved_surveys'] = $reserved_surveys;
            if (empty($reserved_surveys)) {
                return redirect('transaction/land-exchange/add');
            }

            if ($land_exchange_data[0]['state_id']) {
                $state_id = $land_exchange_data[0]['state_id'];
                $this->data['district_info'] = $this->getAllDistrict($land_exchange_data[0]['state_id']);
            }
            if ($land_exchange_data[0]['district_id']) {
                $district_id = $land_exchange_data[0]['district_id'];
                $this->data['block_info'] = $this->getAllBlock($land_exchange_data[0]['district_id']);
            }
            if ($land_exchange_data[0]['block_id']) {
                $block_id = $land_exchange_data[0]['block_id'];
                $this->data['village_info'] = $this->getAllVillage($land_exchange_data[0]['block_id']);
            }
            if ($land_exchange_data[0]['village_id']) {
                $village_id = $land_exchange_data[0]['village_id'];
                $existing_surveys = LandExchangeSurveyModel::where(['land_exchange_id' => $id])->select('survey_id')->get()->toArray();
//                $this->data['survey_info'] = $survey_info = $this->landEchangeSurvey($land_exchange_data[0]['village_id'], null);
            }
        }




        return view('admin.Transaction.LandExchange.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        // t($posted_data, 1);

        $selected_surveys = isset($posted_data['survey_id']) ? $posted_data['survey_id'] : '';
        $posted_docs = isset($posted_data['survey_files']) ? $posted_data['survey_files'] : '';
        $posted_land_exchange_data = isset($posted_data['land_exchange']) ? $posted_data['land_exchange'] : '';
        $transaction_type = isset($posted_land_exchange_data['trxn_type']) ? $posted_land_exchange_data['trxn_type'] : '';
        unset($posted_land_exchange_data['survey_id']);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        // t($validator,1);
        $ext_arr = [];
        $path_arr = [];
        $file_name_arr = [];
        $file_error = 0;
        // t($posted_docs);
        if (!empty($posted_docs)) {
            foreach ($posted_docs as $key => $value) {
                if (!empty($value)) {
                    $file_name = $value->getClientOriginalName();
                    $file_name = stristr($file_name, '.', true);
                    $ext = $value->getClientOriginalExtension();
                    $ext_arr[] = $ext;
                    $new_file_name = $file_name . $key . '_' . time() . '.' . $ext;
                    // $file_name[] = $new_file_name;
                    array_push($file_name_arr, $new_file_name);
                    $file_path = $this->upload_dir . '/' . $new_file_name;
                    $path_arr[] = $file_path;
                } else {
                    array_push($file_name_arr, '');
                    $ext_arr[] = '';
                    $path_arr[] = '';
                }
            }
        }
        if (!empty($ext_arr)) {
            foreach ($ext_arr as $key => $value) {
                if ($value) {
                    if (!in_array($ext_arr[$key], $this->allowed_types)) {
                        $file_error++;
                    }
                }
            }
        }

        if ($id) {

            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('land_exchange_edit')) {
                    return redirect('unauthorized-access');
                }
            }

            if ($validator->fails()) {
                return redirect('transaction/land-exchange/edit/' . $id)
                                ->withErrors($validator, 'land_exchange')
                                ->withInput();
            }


            if ($file_error > 0) {
                $msg = UtilityModel::getMessage('Some files are not valid!', 'error');
                return redirect('transaction/land-exchange/edit/' . $id)->with('message', $msg);
            }

            if (!empty($path_arr) && $file_error == 0) {
                foreach ($path_arr as $key => $value) {
                    if (!empty($value)) {
                        $upload = UtilityModel::uploadFile($posted_docs[$key], $this->upload_dir, $file_name_arr[$key]);
                    }
                }
            }

            $data_to_update = $posted_land_exchange_data;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = LandExchangeModel::where(['id' => $id])->update($data_to_update);
            $this->addOrEditExchangeSurveys($posted_data, $selected_surveys, $id, $path_arr, $ext_arr, 'edit');
            $msg = UtilityModel::getMessage('Land Exchange data updated successfully!');

            return redirect('transaction/land-exchange/edit/' . $id)->with('message', $msg);
        } else {
            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('land_exchange_add')) {
                    return redirect('unauthorized-access');
                }
            }
            //echo 'asdsa';die();
            if ($validator->fails()) {
                //  echo 'jjjj';die();
                return redirect('transaction/land-exchange/add')
                                ->withErrors($validator, 'land_exchange')
                                ->withInput();
            }
//echo 'hhhh';die();
            //echo $file_error;exit;
            if ($file_error > 0) {
                $msg = UtilityModel::getMessage('Some files are not valid!', 'error');
                return redirect('transaction/land-exchange/add')->with('message', $msg);
            }
            //echo $file_error;
            if (!empty($path_arr) && $file_error == 0) {
                foreach ($path_arr as $key => $value) {
                    if (!empty($value)) {
                        $upload = UtilityModel::uploadFile($posted_docs[$key], $this->upload_dir, $file_name_arr[$key]);
                    }
                }
            }
            //  exit;
            $data_to_insert = $posted_land_exchange_data;
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = LandExchangeModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Land Exchange data saved successfully!');
            if ($insert_id) {
                $this->addOrEditExchangeSurveys($posted_data, $selected_surveys, $insert_id, $path_arr, $ext_arr, 'add');
                return redirect('transaction/land-exchange/add')->with('message', $msg);
            }
        }
    }

    public function addOrEditExchangeSurveys($posted_data, $selected_surveys, $land_exchange_id, $path_arr, $ext_arr, $mode) {
        if ($posted_data && $selected_surveys && $land_exchange_id) {
            $survey_data['land_exchange_id'] = $land_exchange_id;
            if ($selected_surveys) {
                foreach ($selected_surveys as $key => $value) {
//                    if ($mode == 'add') {
//                        $existing_survey = LandExchangeSurveyModel::where(['survey_id' => $value])->get()->toArray();
//                        if (!empty($existing_survey)) {
//                            $delete_survey = LandExchangeSurveyModel::where(['survey_id' => $value])->delete();
//                        }
//                    }
                    $survey_data['survey_id'] = $value;
                    $survey_data['survey_no'] = isset($posted_data['survey_no'][$key]) ? $posted_data['survey_no'][$key] : '';
                    $survey_data['remarks'] = isset($posted_data['remarks'][$key]) ? $posted_data['remarks'][$key] : '';
                    $date_of_exchange = isset($posted_data['date_of_exchange'][$key]) ? $posted_data['date_of_exchange'][$key] : '';
                    if ($date_of_exchange) {
                        $date_of_exchange = str_replace("/", "-", $date_of_exchange);
                        $date_of_exchange = new \DateTime($date_of_exchange);
                        $date_of_exchange = $date_of_exchange->format('Y-m-d');
                    }
                    $survey_data['date_of_exchange'] = $date_of_exchange;
                    $survey_data['transferee'] = isset($posted_data['transferee'][$key]) ? $posted_data['transferee'][$key] : '';
                    $existing_survey = LandExchangeSurveyModel::where(['survey_id' => $value])->get()->toArray();
                    $existing_file_path = isset($existing_survey[0]['file_path']) && !empty($existing_survey[0]['file_path']) ? $existing_survey[0]['file_path'] : '';
                    $existing_file_type = isset($existing_survey[0]['file_type']) && !empty($existing_survey[0]['file_type']) ? $existing_survey[0]['file_type'] : '';
                    //t($existing_survey);
                    if (empty($existing_survey)) {
                        $survey_data['file_path'] = isset($path_arr[$key]) ? $path_arr[$key] : '';
                        $survey_data['file_type'] = isset($ext_arr[$key]) ? $ext_arr[$key] : '';
                        $survey_data['created_at'] = Carbon::now();
                        $survey_data['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $survey_data['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $insert_survey_id = LandExchangeSurveyModel::insertGetId($survey_data);
                    } else {
                        $survey_data['file_path'] = isset($path_arr[$key]) && !empty($path_arr[$key]) ? $path_arr[$key] : $existing_file_path;
                        $survey_data['file_type'] = isset($ext_arr[$key]) && !empty($ext_arr[$key]) ? $ext_arr[$key] : $existing_file_type;
                        $survey_data['updated_at'] = Carbon::now();
                        $survey_data['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $survey_data['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $update = LandExchangeSurveyModel::where(['survey_id' => $value])->update($survey_data);
                    }
                    $update_land_exchange_status_in_survey_table = SurveyModel::where(['id' => $value])->update(['land_exchange_status' => 'Y']);
                }
            }
        }
    }

    public function dropDown(Request $request, $option = true, $json = true) {
        $this->data['typeList'] = $typeList = $request->get('type');
        $this->data['namePrefix'] = $namePrefix = $request->get('namePrefix');
        $this->data['dropdown_type'] = $dropdown_type = $request->get('dropdown_type');
        $this->data['multiple'] = $multiple = $request->get('multiple');
        $trxn_type = $request->get('trxn_type');
        if ($typeList == 'survey_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $surveys = $this->landEchangeSurvey($village_id, 'ajax');
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

    public function landEchangeSurvey($village_id = null, $type = null) {

        if ($village_id && $type == 'ajax') {
            $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
            $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
            if ($registration_ids) {
                $survey_list = SurveyModel::where(['land_exchange_status' => 'N'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
            } else {
                $survey_list = '';
            }
        } else if ($village_id && $type == null) {
            $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
            $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
            if ($registration_ids) {
                $survey_list = SurveyModel::where(['land_exchange_status' => 'N'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->lists('survey_no', 'id')->toArray();
            } else {
                $survey_list = '';
            }
            $survey_list = array_merge(array('' => 'select'), $survey_list);
            return $survey_list;
        }
        return $survey_list;
    }

    public function deleteExchangeSurvey($survey_id, $land_exchange_id) {
        if ($survey_id && $land_exchange_id) {
            $delete = LandExchangeSurveyModel::where(['survey_id' => $survey_id, 'land_exchange_id' => $land_exchange_id])->delete();
            $update_land_exchange_status_in_survey_table = SurveyModel::where(['id' => $survey_id])->update(['land_exchange_status' => 'N']);
        }
        $msg = UtilityModel::getMessage('Land Exchange data deleted successfully!');
        return redirect('transaction/land-exchange/add/' . $land_exchange_id)->with('message', $msg);
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
