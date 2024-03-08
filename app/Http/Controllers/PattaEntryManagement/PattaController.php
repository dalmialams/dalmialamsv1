<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\PattaEntryManagement;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\PattaModel;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\LandDetailsManagement\DocumentModel;
use App\Models\LandDetailsManagement\PaymentModel;
use App\Models\Transaction\MutationModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\Common\DistrictModel;
use App\Models\Common\BlockModel;
use App\Models\Common\StateModel;
use App\Models\UtilityModel;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;

/**
 * Description of PattaController
 *
 * @author user-98-pc
 */
class PattaController extends Controller {

    //put your code here
    protected $validationRules = [
        'patta.state_id' => 'required',
        'patta.patta_no' => 'required',
        'patta.patta_owner' => 'required',
    ];
    protected $field_names = [
        'patta.state_id' => 'State',
        'patta.patta_no' => 'Patta No.',
        'patta.patta_owner' => 'Patta owner',
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Patta';
        $this->data['section'] = 'patta';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();

        $this->data['survey_list'] = $this->getAllSurvey();
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
    public function add(Request $request) {

        //  $this->data['title'] = 'Dalmia-lams::Patta/Add';
        $this->data['pageHeading'] = 'Patta Record <span class="text-danger" >Add</span>';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['include_script_view'] = 'admin.PattaEntryManagement.Patta.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['patta_data'] = '';
        if ($this->data['viewMode'] == 'true') {
            return redirect('land-details-entry/patta/add');
        }
        return view('admin.PattaEntryManagement.Patta.add', $this->data);
    }

    public function edit(Request $request, $id = null) {
        $this->data['pageHeading'] = 'Patta Record <span class="text-danger" >Edit</span>';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['include_script_view'] = 'admin.PattaEntryManagement.Patta.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        if ($this->data['patta_uniq_no']) {  /// for edit
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('patta_access') && !$this->hasPermission('patta_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($this->data['viewMode'] == 'true') {
                return redirect('land-details-entry/patta/edit?patta_uniq_no=' . $this->data['patta_uniq_no']);
            }
            $patta_uniq_no = $this->data['patta_uniq_no'];
            $patta_info = PattaModel::find($patta_uniq_no)->toArray();
            // t($patta_info, 1);
            $this->data['patta_data'] = $patta_info;
            $this->data['pageHeading'] = 'Patta Record <span class="text-danger" >Edit</span>';

            if ($patta_info['state_id']) {
                $this->data['district_info'] = $this->getAllDistrict($patta_info['state_id']);
            }
            if ($patta_info['district_id']) {
                $this->data['block_info'] = $this->getAllBlock($patta_info['district_id']);
            }
            if ($patta_info['block_id']) {
                $this->data['village_info'] = $this->getAllVillage($patta_info['block_id']);
            }
            if ($patta_info['village_id']) {
                $survey_info1 = $this->getAllPattaSurvey('', $patta_info['village_id'], null);
                $survey_info2 = $this->getAllPattaSurvey('', $patta_info['village_id'], $patta_info['survey_id']);
                $this->data['survey_info'] = $survey_info = array_merge($survey_info1, $survey_info2);
                //t( $survey_info,1);
            }
        }
        return view('admin.PattaEntryManagement.Patta.add', $this->data);
    }

    public function view(Request $request, $id = null) {
        $this->data['pageHeading'] = 'Patta Record <span class="text-danger" >Add</span>';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['include_script_view'] = 'admin.PattaEntryManagement.Patta.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';

        if ($this->data['patta_uniq_no']) {  /// for edit
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('patta_access') && !$this->hasPermission('patta_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            $patta_uniq_no = $this->data['patta_uniq_no'];
            $patta_info = PattaModel::find($patta_uniq_no)->toArray();
            // t($patta_info, 1);
            $this->data['patta_data'] = $patta_info;
            $this->data['pageHeading'] = 'Patta Record <span class="text-danger" >Edit</span>';

            if ($patta_info['state_id']) {
                $this->data['district_info'] = $this->getAllDistrict($patta_info['state_id']);
            }
            if ($patta_info['district_id']) {
                $this->data['block_info'] = $this->getAllBlock($patta_info['district_id']);
            }
            if ($patta_info['block_id']) {
                $this->data['village_info'] = $this->getAllVillage($patta_info['block_id']);
            }
            if ($patta_info['village_id']) {
                $this->data['survey_info'] = $survey_info = $this->getAllSurvey('', $patta_info['village_id'], null);
                // t( $survey_info,1);
            }
        }

        if ($this->data['viewMode'] == 'true') {
            $this->data['pageHeading'] = 'Patta Record <span class="text-danger" >View</span>';
        } else {
            return redirect('land-details-entry/patta/view?patta_uniq_no=' . $this->data['patta_uniq_no'] . '&view=true');
        }
        return view('admin.PattaEntryManagement.Patta.add', $this->data);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function pattaList(Request $request) {
        $this->data['title'] = 'Dalmia-lams::Patta/List';
        $this->data['pageHeading'] = 'Patta Record <span class="text-danger" >Search</span>';
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.PattaEntryManagement.Patta.listscript';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';

        //For Search Patta Lists
        $posted_data = $request->all();
        $cond = '1=1 ';

        if ($posted_data) {
        //t($posted_data);

            $allSearchData = $posted_data['patta'];

            if (empty($allSearchData['state_id']) && empty($allSearchData['district_id'])) {
                $assgined_districts = [];
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
                        $assgined_districts_str = ($assgined_districts) ? "'" . implode("','", $assgined_districts) . "'" : '';
                        //t($assgined_districts,1);
                        if ($assgined_districts_str) {
                            $cond.= " AND district_id in ($assgined_districts_str) ";
                        }
                    }
                }
            }
            if (!empty($allSearchData['state_id'])) {
                $cond .= " AND state_id = '{$allSearchData['state_id']}'";
                $this->data['state_id'] = $allSearchData['state_id'];
                $this->data['district_info'] = $this->getAllDistrict($allSearchData['state_id']);
            }
            if (!empty($allSearchData['district_id'])) {
                $cond .= " AND district_id = '{$allSearchData['district_id']}'";
                $this->data['district_id'] = $allSearchData['district_id'];
                $this->data['block_info'] = $this->getAllBlock($allSearchData['district_id']);
            }
            if (!empty($allSearchData['block_id'])) {
                $cond .= " AND block_id = '{$allSearchData['block_id']}'";
                $this->data['block_id'] = $allSearchData['block_id'];
                $this->data['village_info'] = $this->getAllVillage($allSearchData['block_id']);
            }
            if (!empty($allSearchData['village_id'])) {
                $cond .= " AND village_id = '{$allSearchData['village_id']}'";
                $this->data['village_id'] = $allSearchData['village_id'];
                $survey_info = $this->getAllSurvey('', $allSearchData['village_id'], null);
                unset($survey_info['']);
                $this->data['survey_info'] = $survey_info;
                //t($this->data['survey_info'],1);
            }
            if (!empty($posted_data['survey_id'])) {
                // $survey_str = implode(",", $posted_data['survey_id']);
                $survey_numbers = $posted_data['survey_id'];
                $total_surbeys = count($survey_numbers);
                $cond .= " AND ( ";
                $i = 1;
                foreach ($survey_numbers as $key => $value) {
                    if ($i < $total_surbeys) {
                        $cond .= "  survey_id like '%{$value}%' OR ";
                    } else {
                        $cond .= "  survey_id like '%{$value}%'  ";
                    }
                    $i++;
                }
                $cond .= " ) ";
//                echo $cond;
//                exit;
                // $cond .= " AND survey_id like '%{$survey_str}%'";
                $this->data['survey_id'] = $posted_data['survey_id'];
                //t($posted_data['survey_id']);
                // $this->data['village_info'] = $this->getAllVillage($allSearchData['block_id']);
            }
            if (!empty($allSearchData['patta_no'])) {
                $cond .= " AND patta_no like '%{$allSearchData['patta_no']}%'";
                $this->data['patta_no'] = $allSearchData['patta_no'];
            }
            if (!empty($allSearchData['patta_owner'])) {
                $cond .= " AND patta_owner like '%{$allSearchData['patta_owner']}%'";
                $this->data['patta_owner'] = $allSearchData['patta_owner'];
            }
            if (!empty($allSearchData['id'])) {
                $cond .= " AND id = '{$allSearchData['id']}'";
                $this->data['id'] = $allSearchData['id'];
            }

            if (!empty($allSearchData['id'])) {
                $cond .= " AND id = '{$allSearchData['id']}'";
                $this->data['id'] = $allSearchData['id'];
            }

            $cond .= " AND fl_archive = 'N'";

            $res = PattaModel::selectRaw("id,state_id,district_id,block_id,village_id,patta_no,patta_owner,survey_no,survey_id,ip_address,crt_id,date(created_at) as created_at,upd_id,date(updated_at) as updated_at,fl_archive,mutation_status,mutated_survey_id,insert_role_id,update_role_id,unq")->whereRaw($cond)->orderBy('id', 'DESC')->get()->toArray();
            $this->data['patta'] = $res;
            $this->data['dataPresent'] = 'yes';
        } else {
            $this->data['patta'] = '';
            $this->data['dataPresent'] = 'no';
        }
        $patta_no_info = PattaModel::lists('patta_no', 'patta_no')->toArray();
        $patta_no_info = array_merge(array('' => ''), $patta_no_info);
        $this->data['patta_no_info'] = $patta_no_info;
        // t($patta_no_info,1);

        return view('admin.PattaEntryManagement.Patta.list', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();

        $posted_patta_data = isset($posted_data['patta']) ? $posted_data['patta'] : '';
        $survey_id = isset($posted_data['survey_id']) ? implode(",", $posted_data['survey_id']) : '';
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {

            $previous_patta_info = PattaModel::find($id)->toArray();
            $previous_patta_survey_id = $previous_patta_info['survey_id'];

            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('patta_access') && !$this->hasPermission('patta_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('land-details-entry/patta/edit?patta_uniq_no=' . $id)
                                ->withErrors($validator, 'patta')
                                ->withInput();
            }
            $data_to_update = $posted_patta_data;
            $data_to_update['survey_id'] = $survey_id;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = PattaModel::where(['id' => $id])->update($data_to_update);
            //$msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
            $msg = UtilityModel::getMessage('Patta data updated successfully!');
            if ($update) {
                
                //Change the Patta Entry Status in Survey table as a default when edit i.e N
                if ($previous_patta_survey_id) {
                    $all_previous_patta_survey_id = explode(',', $previous_patta_survey_id);
                    $pre_survey_data_update['patta_entry_status'] = 'N';
                    foreach ($all_previous_patta_survey_id as $pval) {
                        SurveyModel::where(['id' => $pval])->update($pre_survey_data_update);
                    }
                }

                //Change the Patta Entry Status in Survey table i.e Y
                if ($survey_id) {
                    $allSurveyPatta = explode(',', $survey_id);
                    $survey_data_update['patta_entry_status'] = 'Y';
                    foreach ($allSurveyPatta as $val) {
                        SurveyModel::where(['id' => $val])->update($survey_data_update);
                    }
                }

                if ($posted_data['save_patta'] == 'save') {
                    return redirect('land-details-entry/patta/edit?patta_uniq_no=' . $id)->with('message', $msg);
                } else if ($posted_data['save_patta'] == 'save_continue') {
                    return redirect('land-details-entry/patta/edit?patta_uniq_no=' . $id)->with('message', $msg);
                }
            }
        } else {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('patta_access') && !$this->hasPermission('patta_add')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('land-details-entry/patta/add')
                                ->withErrors($validator, 'patta')
                                ->withInput();
            }
            $data_to_insert = $posted_patta_data;
            $data_to_insert['survey_id'] = $survey_id;
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            // $data_to_insert['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = PattaModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Patta data saved successfully!');
            if ($insert_id) {

                //Change the Patta Entry Status in Survey table
                if ($survey_id) {
                    $allSurveyPatta = explode(',', $survey_id);
                    $survey_data_update['patta_entry_status'] = 'Y';
                    foreach ($allSurveyPatta as $val) {
                        SurveyModel::where(['id' => $val])->update($survey_data_update);
                    }
                }

                if ($posted_data['save_patta'] == 'save') {
                    return redirect('land-details-entry/patta/add')->with('message', $msg);
                } else if ($posted_data['save_patta'] == 'save_continue') {
                    return redirect('land-details-entry/patta/add?patta_uniq_no=' . $insert_id)->with('message', $msg);
                }
            }
        }
    }

    public function pattaView($id = null) {

        $this->data['title'] = 'Dalmia-lams::Patta/View';
        $this->data['pageHeading'] = 'Patta Details : ' . $id;

        if (empty($id)) {
            return redirect('land-details-entry/patta/list');
        } else {
            //Get Patta Info
            $patta_info = PattaModel::where(['id' => "$id"])->get()->toArray();
            if (empty($patta_info)) {
                return redirect('land-details-entry/patta/list');
            }
            $this->data['reg_info'] = $patta_info[0];

            //Get Survey No Details
            $survey_info = SurveyModel::where(['patta_id' => $id])->get()->toArray();
            $this->data['survey_info'] = $survey_info;
            // t($survey_info,1);
            //Get Document Details
            $all_docs = ($id) ? DocumentModel::where(['patta_id' => "$id"])->get()->toArray() : '';
            $this->data['all_docs'] = $all_docs;

            //Get Payment Details
            $payment_info = PaymentModel::where(['patta_id' => $id])->get()->toArray();
            $this->data['payment_info'] = $payment_info;

            return view('admin.PattaEntryManagement.Patta.view', $this->data);
        }
    }

    public function pattaDelete(Request $request) {

        $query_string = $_SERVER['QUERY_STRING'];
        $patta_no = $request->input('patta_no');

        if (!empty($query_string) && !empty($patta_no)) {
            $data_to_update['fl_archive'] = 'Y';
            $delete_id = PattaModel::where(['id' => $patta_no])->update($data_to_update);
            if ($delete_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Patta data deleted successfully!</strong></div>';
                return redirect('land-details-entry/patta/list?' . $query_string)->with('message', $msg);
            }
        } else {
            return redirect('land-details-entry/registration/add');
        }
    }

    public function pattaMutation(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.PattaEntryManagement.Patta.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['section'] = 'mutation';

        if ($this->data['patta_uniq_no']) {
            $patta_uniq_no = $this->data['patta_uniq_no'];
            $muttation_info = MutationModel::where(['patta_id' => $patta_uniq_no])->get()->toArray();
            $this->data['muttation_info'] = $muttation_info;
            $this->data['pageHeading'] = 'Mutation <span class="text-danger" >View</span>';
            return view('admin.PattaEntryManagement.Patta.pattaMutationList', $this->data);
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

    public function dropDown(Request $request, $option = true, $json = true) {
        $this->data['typeList'] = $typeList = $request->get('type');
        $this->data['namePrefix'] = $namePrefix = $request->get('namePrefix');
        $this->data['dropdown_type'] = $dropdown_type = $request->get('dropdown_type');
        $this->data['multiple'] = $multiple = $request->get('multiple');
        $trxn_type = $request->get('trxn_type');
        if ($typeList == 'survey_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $surveys = $this->getAllPattaSurvey('', $village_id, 'ajax');
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

    public function getAllPattaSurvey($registration_id = null, $village_id = null, $type = null) {

        if ($registration_id) {
            $survey_list = SurveyModel::where(['registration_id' => $registration_id])->orderBy('id')->lists('survey_no', 'survey_no')->toArray();
        } else if ($village_id && $type == 'ajax') {
            $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
            $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
            if ($registration_ids) {
                $survey_list = SurveyModel::where(['mutation_status' => 'N', 'patta_entry_status' => 'N'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
            } else {
                $survey_list = '';
            }
            return $survey_list;
        } else if ($village_id && $type != null) {

            if ($type) {
                $surveyIds = $type ? "'" . implode("','", explode(',', $type)) . "'" : '';
                $survey_list = SurveyModel::whereRaw("id in ($surveyIds)")->orderBy('id')->lists('survey_no', 'id')->toArray();
            } else {
                $survey_list = '';
            }
            $survey_list = array_merge(array('' => 'select'), $survey_list);
            return $survey_list;
            //t($survey_list, 1);
        } else if ($village_id && $type == null) {

            $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
            $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
            if ($registration_ids) {
                $survey_list = SurveyModel::where(['mutation_status' => 'N', 'patta_entry_status' => 'N'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->lists('survey_no', 'id')->toArray();
            } else {
                $survey_list = '';
            }
            $survey_list = array_merge(array('' => 'select'), $survey_list);
            return $survey_list;
            // t($survey_list, 1);
        } else {
            if ($this->user_type == 'admin') {
                $survey_list = SurveyModel::orderBy('id')->lists('survey_no', 'survey_no')->toArray();
            } else {
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
                    $assgined_districts_str = ($assgined_districts) ? "'" . implode("','", $assgined_districts) . "'" : '';
                    //t($assgined_districts,1);
                    if ($assgined_districts_str) {
                        $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->whereRaw("district_id in ($assgined_districts_str)")->get()->toArray();
                        $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
                        $survey_list = SurveyModel::whereRaw("registration_id in ($registration_ids)")->orderBy('id')->lists('survey_no', 'survey_no')->toArray();
                    }
                }
            }
        }

        if ($survey_list) {
            $surveyList[''] = 'Select';
            foreach ($survey_list as $key => $value) {
                $surveyList[$value] = $value;
            }
        } else {
            $surveyList[''] = '';
        }

        return $surveyList;
    }

}
