<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\PattaModel;
use App\Models\Transaction\MiningLeaseModel;
use App\Models\Transaction\MiningLeaseSurveyModel;
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
class MiningLeaseController extends Controller {

    //put your code here

    protected $validationRules = [
        'mining_lease.trxn_type' => 'required',
        'mining_lease.state_id' => 'required',
        'mining_lease.district_id' => 'required',
        'mining_lease.block_id' => 'required',
        'mining_lease.village_id' => 'required',
    ];
    protected $field_names = [
        'mining_lease.trxn_type' => 'Transaction Type',
        'mining_lease.state_id' => 'State',
        'mining_lease.district_id' => 'District',
        'mining_lease.block_id' => 'Block/Taluk',
        'mining_lease.village_id' => 'Village',
    ];

    public function __construct() {
        parent:: __construct();

        $this->allowed_types = [ 'pdf', 'mp4'];
        $this->upload_dir = 'assets\uploads\MiningLeaseSurveyDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Transaction-Mining Lease';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        //  $this->data['patta_list'] = $this->getAllPatta();
        $this->data['include_script_view'] = 'admin.Transaction.MiningLease.script';
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

        $this->data['pageHeading'] = 'Mining Lease <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-mining-lease-Add';
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
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        //MiningLease Lists

        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
            $res = MiningLeaseModel::whereRaw(" district_id in ($this->assgined_districts_str)")->where(['fl_archive' => 'N'])->get()->toArray();
        } else {
            $res = MiningLeaseModel::where(['fl_archive' => 'N'])->get()->toArray();
        }
        // t($res,1);
        $this->data['mining_leases'] = $res;
        $this->data['id'] = '';
        $this->data['type'] = [
            '' => 'Select',
            'N' => 'Applied',
            'Y' => 'Obtained',
        ];


        return view('admin.Transaction.MiningLease.add', $this->data);
    }

    public function edit(Request $request, $id = null) {

        if (!$id) {
            return redirect('transaction/mining-lease/add');
        } else {
            //t($this->assgined_districts, 1);
            $exists = MiningLeaseModel::where(['id' => $id])->get()->toArray();
            $dist_id = MiningLeaseModel::where(['id' => $id])->value('district_id');
            if ($this->user_type == 'admin') {
                if (empty($exists)) {
                    return redirect('transaction/mining-lease/add');
                }
            } else {
                if (empty($exists) || !in_array($dist_id, $this->assgined_districts)) {
                    return redirect('unauthorized-access');
                }
            }
        }

        $this->data['pageHeading'] = 'Mining Lease (' . $id . ') <span class="text-danger" >Edit</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-mining-lease-Add';
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
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        //MiningLease Lists
        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
            $res = MiningLeaseModel::whereRaw(" district_id in ($this->assgined_districts_str)")->where(['fl_archive' => 'N'])->get()->toArray();
        } else {
            $res = MiningLeaseModel::where(['fl_archive' => 'N'])->get()->toArray();
        }
        // t($res,1);
        $this->data['mining_leases'] = $res;
        $this->data['id'] = $id;
        $this->data['type'] = [
            '' => 'Select',
            'N' => 'Applied',
            'Y' => 'Obtained',
        ];

        //MiningLease Edit
        // $mining_lease_no = $request->input('mining_lease_no');
        $this->data['id'] = $id;
        if ($id) {
            $reserved_survey_ids = [];
            //$this->data['mining_lease_no'] = $mining_lease_no;
            $mining_lease_data = MiningLeaseModel::where(['id' => $id])->get()->toArray();
            $trxn_type = $mining_lease_data[0]['trxn_type'];
            $this->data['trxn_type'] = $trxn_type;
            $this->data['mining_lease_data'] = $mining_lease_data[0];

            $reserved_surveys = MiningLeaseModel::find($id)->getMiningSurveys->toArray();
            $this->data['reserved_surveys'] = $reserved_surveys;
            if (empty($reserved_surveys)) {
                return redirect('transaction/mining-lease/add');
            }

            if ($mining_lease_data[0]['state_id']) {
                $this->data['district_info'] = $this->getAllDistrict($mining_lease_data[0]['state_id']);
            }
            if ($mining_lease_data[0]['district_id']) {
                $this->data['block_info'] = $this->getAllBlock($mining_lease_data[0]['district_id']);
            }
            if ($mining_lease_data[0]['block_id']) {
                $this->data['village_info'] = $this->getAllVillage($mining_lease_data[0]['block_id']);
            }
            if ($mining_lease_data[0]['village_id']) {
                $existing_surveys = MiningLeaseSurveyModel::where(['mining_lease_id' => $id])->select('survey_id')->get()->toArray();
                //t($existing_surveys);
                //  $trxn_type = ($trxn_type == 'Y') ? 'O' : 'N'; // Y => 'Applied' , O => Obtained
                $this->data['survey_info'] = $survey_info = $this->miningLeaseSurvey($mining_lease_data[0]['village_id'], null, $trxn_type);
            }
        }


        return view('admin.Transaction.MiningLease.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        // t($posted_data);

        $selected_surveys = isset($posted_data['survey_id']) ? $posted_data['survey_id'] : '';
        $posted_docs = isset($posted_data['survey_files']) ? $posted_data['survey_files'] : '';
        $posted_mining_lease_data = isset($posted_data['mining_lease']) ? $posted_data['mining_lease'] : '';
        $transaction_type = isset($posted_mining_lease_data['trxn_type']) ? $posted_mining_lease_data['trxn_type'] : '';
        unset($posted_mining_lease_data['survey_id']);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
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
                if (!$this->hasPermission('mining_lease_edit')) {
                    return redirect('unauthorized-access');
                }
            }


            if ($validator->fails()) {
                return redirect('transaction/mining-lease/edit/' . $id)
                                ->withErrors($validator, 'mining_lease')
                                ->withInput();
            }

            if ($file_error > 0) {
                $msg = UtilityModel::getMessage('Some files are not valid!', 'error');
                return redirect('transaction/mining-lease/edit/' . $id)->with('message', $msg);
            }
            //echo $file_error;
            if (!empty($path_arr) && $file_error == 0) {
                foreach ($path_arr as $key => $value) {
                    if (!empty($value)) {
                        $upload = UtilityModel::uploadFile($posted_docs[$key], $this->upload_dir, $file_name_arr[$key]);
                    }
                }
            }

            $data_to_update = $posted_mining_lease_data;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = MiningLeaseModel::where(['id' => $id])->update($data_to_update);
            $this->addOrEditReservationSurveys($posted_data, $selected_surveys, $id, $path_arr, $ext_arr, $transaction_type, 'edit');
            $msg = UtilityModel::getMessage('Mining Lease data updated successfully!');

            return redirect('transaction/mining-lease/edit/' . $id)->with('message', $msg);
        } else {
            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('mining_lease_add')) {
                    return redirect('unauthorized-access');
                }
            }


            if ($validator->fails()) {
                return redirect('transaction/mining-lease/add')
                                ->withErrors($validator, 'mining_lease')
                                ->withInput();
            }

            if ($file_error > 0) {
                $msg = UtilityModel::getMessage('Some files are not valid!', 'error');
                return redirect('transaction/mining-lease/add')->with('message', $msg);
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
            $data_to_insert = $posted_mining_lease_data;
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = MiningLeaseModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Mining Lease data saved successfully!');
            if ($insert_id) {
                $this->addOrEditReservationSurveys($posted_data, $selected_surveys, $insert_id, $path_arr, $ext_arr, $transaction_type, 'add');
                return redirect('transaction/mining-lease/add')->with('message', $msg);
            }
        }
    }

    public function addOrEditReservationSurveys($posted_data, $selected_surveys, $mining_lease_id, $path_arr, $ext_arr, $transaction_type, $mode) {
        if ($posted_data && $selected_surveys && $mining_lease_id) {
            $survey_data['mining_lease_id'] = $mining_lease_id;
            $transaction_type = ($transaction_type == 'N') ? 'Y' : 'O'; // Y => 'Applied' , O => Obtained
            if ($selected_surveys) {
                foreach ($selected_surveys as $key => $value) {
                    if ($mode == 'add' && ($transaction_type == 'N' || $transaction_type == 'Y')) {
                        $existing_survey = MiningLeaseSurveyModel::where(['survey_id' => $value])->get()->toArray();
                        if (!empty($existing_survey)) {
                            $delete_survey = MiningLeaseSurveyModel::where(['survey_id' => $value])->delete();
                        }
                    }
                    $survey_data['survey_id'] = $value;
                    $survey_data['survey_no'] = isset($posted_data['survey_no'][$key]) ? $posted_data['survey_no'][$key] : '';
                    $survey_data['remarks'] = isset($posted_data['remarks'][$key]) ? $posted_data['remarks'][$key] : '';
                    $survey_data['go'] = isset($posted_data['go'][$key]) ? $posted_data['go'][$key] : '';
                    $existing_survey = MiningLeaseSurveyModel::where(['survey_id' => $value])->get()->toArray();
                    $existing_file_path = isset($existing_survey[0]['file_path']) && !empty($existing_survey[0]['file_path']) ? $existing_survey[0]['file_path'] : '';
                    $existing_file_type = isset($existing_survey[0]['file_type']) && !empty($existing_survey[0]['file_type']) ? $existing_survey[0]['file_type'] : '';
                    //t($existing_survey);
                    if (empty($existing_survey)) {
                        $survey_data['file_path'] = isset($path_arr[$key]) ? $path_arr[$key] : '';
                        $survey_data['file_type'] = isset($ext_arr[$key]) ? $ext_arr[$key] : '';
                        $survey_data['created_at'] = Carbon::now();
                        $survey_data['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $survey_data['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $insert_survey_id = MiningLeaseSurveyModel::insertGetId($survey_data);
                    } else {
                        $survey_data['file_path'] = isset($path_arr[$key]) && !empty($path_arr[$key]) ? $path_arr[$key] : $existing_file_path;
                        $survey_data['file_type'] = isset($ext_arr[$key]) && !empty($ext_arr[$key]) ? $ext_arr[$key] : $existing_file_type;
                        $survey_data['updated_at'] = Carbon::now();
                        $survey_data['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $survey_data['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $update = MiningLeaseSurveyModel::where(['survey_id' => $value])->update($survey_data);
                    }

                    $update_mining_applied_status_in_survey_table = SurveyModel::where(['id' => $value])->update(['mining_applied_status' => $transaction_type]);
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
        $from_mis = $request->get('from_mis');
        // $trxn_type = ($trxn_type == 'N') ? 'Y' : 'O'; // Y => 'Applied' , O => Obtained
        if ($typeList == 'survey_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $surveys = $this->miningLeaseSurvey($village_id, 'ajax', $trxn_type, $from_mis);
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

    public function miningLeaseSurvey($village_id = null, $type = null, $trxn_type = 'N', $from_mis = null) {

        if (!$from_mis) {
            if ($village_id && $type == 'ajax') {
                $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
                $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
                if ($registration_ids) {
                    $survey_list = SurveyModel::where(['mining_applied_status' => $trxn_type, 'purpose' => 'CD00002'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
                } else {
                    $survey_list = '';
                }
            } else if ($village_id && $type == null) {
                $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
                $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
                if ($registration_ids) {
                    $survey_list = SurveyModel::where(['mining_applied_status' => $trxn_type, 'purpose' => 'CD00002'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->lists('survey_no', 'id')->toArray();
                } else {
                    $survey_list = '';
                }
                $survey_list = array_merge(array('' => 'select'), $survey_list);
                return $survey_list;
            }
        } else {
            $trxn_type = ($trxn_type == 'N') ? 'O' : $trxn_type;
            if (!$village_id && $type == 'ajax') {
                if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
                    $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->whereRaw(" district_id in ($this->assgined_districts_str)")->get()->toArray();
                } else {

                    $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->get()->toArray();
                }
                $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
                // t($registration_ids,1);

                if ($registration_ids) {
                    $survey_list = SurveyModel::where(['mining_applied_status' => $trxn_type])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
                } else {
                    $survey_list = '';
                }
            } else if ($village_id && $type == 'ajax') {
                $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
                $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
                if ($registration_ids) {
                    $survey_list = SurveyModel::where(['mining_applied_status' => $trxn_type])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
                } else {
                    $survey_list = '';
                }
            }
        }
        return $survey_list;
    }

    public function deleteMiningLeaseSurvey($survey_id, $mining_lease_id) {
        if ($survey_id && $mining_lease_id) {
            $delete = MiningLeaseSurveyModel::where(['survey_id' => $survey_id, 'mining_lease_id' => $mining_lease_id])->delete();
            $update_mining_applied_status_in_survey_table = SurveyModel::where(['id' => $survey_id])->update(['mining_applied_status' => 'N']);
        }
        $msg = UtilityModel::getMessage('Mining Lease data deleted successfully!');
        if ($this->user_type == 'admin' || $this->hasPermission('mining_lease_edit')) {
            return redirect('transaction/mining-lease/edit/' . $mining_lease_id)->with('message', $msg);
        } else {
            return redirect('common-success')->with('message', $msg);
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
