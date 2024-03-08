<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use App\Models\Common\StateModel;
use App\Models\Common\DistrictModel;
use App\Models\Common\BlockModel;
use App\Models\Common\VillageModel;
use App\Models\Common\CityModel;
use App\Models\Common\SubClassificationModel;
use App\Models\Common\CodeModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\LandDetailsManagement\PattaModel;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UtilityModel;

class Controller extends BaseController {

    use AuthorizesRequests,
        AuthorizesResources,
        DispatchesJobs,
        ValidatesRequests;

    public $data = [];
    public $user_type = null;
    public $assigned_states = null;
    public $assigned_districts = null;

    function __construct() {


        $this->data['title'] = 'Dalmia-lams';
        $this->data['reg_uniq_no'] = isset($_REQUEST['reg_uniq_no']) ? $_REQUEST['reg_uniq_no'] : '';
        $this->data['patta_uniq_no'] = isset($_REQUEST['patta_uniq_no']) ? $_REQUEST['patta_uniq_no'] : '';
        $this->data['viewMode'] = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';

        if (isset($_REQUEST['reg_uniq_no'])) {
            $unique_id_number = RegistrationModel::where(['id' => $_REQUEST['reg_uniq_no']])->lists('reg_id')->toArray();
            // t($unique_id_number,1);
            $this->data['unique_id_number'] = isset($unique_id_number[0]) ? $unique_id_number[0] : '';
            //$this->data['purchase_type_id'] = RegistrationModel::where(['id' => $_REQUEST['reg_uniq_no']])->value('purchase_type_id');
            $uniqueRegistrationDetails = RegistrationModel::select('purchase_type_id', 'con_parent')->where(['id' => $_REQUEST['reg_uniq_no']])->get()->toArray();
            $this->data['purchase_type_id'] = isset($uniqueRegistrationDetails[0]['purchase_type_id']) ? $uniqueRegistrationDetails[0]['purchase_type_id'] : '';
        }
        $this->data['registration_converted_flag'] = isset($uniqueRegistrationDetails[0]['con_parent']) ? $uniqueRegistrationDetails[0]['con_parent'] : '';
        if (Auth::check()) {


            $user = Auth::user()->toArray();
            $this->data['current_user_id'] = $user['id'];
            // $this->data['current_user_name'] = ($user['user_name']);
            $this->role_id = $this->data['user_role_id'] = ($user['role_id']) ? $user['role_id'] : '';
            $this->role_name = $role_name = ( $this->role_id) ? \App\Models\Role\Role::where(['id' => $this->role_id])->value('name') : '';
            $this->user_type = $this->data['user_type'] = $user['user_type'];
            $this->user_crt_id = $this->data['user_crt_id'] = $user['crt_id'];
            if ($this->user_type !== 'admin') {
                $this->data['current_user_role_name'] = ( $this->role_id) ? \App\Models\Role\Role::where(['id' => $this->role_id])->value('display_name') : '';
                $this->data['current_user_name'] = \App\Models\User\MasterUserModel::where(['email' => $user['user_name']])->value('name');
                $this->assigned_states = $user['state'];
            } else {
                $this->data['current_user_name'] = ($user['user_name']);
            }
            $utility_obj = new UtilityModel();
            $utility_obj->makeMenu($user);
        }
    }

    public function getAllStates() {

        $states = [];
        if ($this->user_type == 'admin') {
            $states = StateModel::where(['fl_archive' => "N"])->orderBy('state_name')->lists('state_name', 'id')->toArray();
			
        } else {
            $assigned_states = $this->assigned_states;
            $assigned_states = explode(",", $assigned_states);
            $state_str = "'" . implode("','", $assigned_states) . "'";
            $states = StateModel::whereRaw("id in ($state_str)")->where(['fl_archive' => "N"])->orderBy('state_name')->lists('state_name', 'id')->toArray();
            // t($state_str, 1);
        }
        $states = array_merge(array('' => 'Select'), $states);
        return $states;
    }

    /**
      $state_id : either single value or comma separated values
      $state_number : for single $state_id use 'single_state' || for comma separated use 'multiple_state'
      $type : use 'ajax' for ajax requested in dropdown else null
     */
    public function getAllDistrictForDropdown($state_id = '', $state_number = 'single_state', $type = null) {
        if (!$state_id) {
            $district = DistrictModel::where(['fl_archive' => "N"])->orderBy('district_name')->lists('district_name', 'id')->toArray();
        } else if ($state_id && $state_number == 'single') {
            $district = DistrictModel::where(['state_id' => "$state_id", 'fl_archive' => "N"])->orderBy('district_name')->lists('district_name', 'id')->toArray();
        } else if ($state_id && $state_number == 'multiple_state' && $type == null) {
            if ($this->user_type == 'admin') {
                $district = DistrictModel::whereRaw("state_id in ({$state_id}) AND fl_archive = 'N'")->orderBy('state_id')->orderBy('district_name')->lists('district_name', 'id')->toArray();
            } else {
                $assigned_states = explode(",", $state_id);
                //t($assigned_states,1);
                $assgined_districts = '';
                foreach ($assigned_states as $key => $value) {
                    $districts = \App\Models\User\AssginedStateDistrictModel::where(['state_id' => str_replace("'", "", $value), 'user_id' => $this->data['current_user_id']])->select('district_id')->get()->toArray();
                    // t($districts);
                    if ($districts) {
                        foreach ($districts as $dist_key => $dist_value) {
                            $assgined_districts[] = $dist_value['district_id'];
                        }
                    }
                }
                $assgined_districts_str = ($assgined_districts) ? "'" . implode("','", $assgined_districts) . "'" : '';
                if ($assgined_districts_str) {
                    $district = DistrictModel::whereRaw("id in ($assgined_districts_str) AND fl_archive = 'N'")->orderBy('state_id')->orderBy('district_name')->lists('district_name', 'id')->toArray();
                } else {
                    $district = '';
                }
            }
            if ($district) {
                foreach ($district as $key => $value) {
                    $state_prefix = DistrictModel::find($key)->getState->state_prefix;
                    $district[$key] = $state_prefix . '-' . $value;
                }
            }
        } else if ($state_id && $state_number == 'multiple_state' && $type == 'ajax') {
            if ($this->user_type == 'admin') {
                $district = DistrictModel::whereRaw("state_id in ({$state_id}) AND fl_archive = 'N'")->select('id as option_code', 'district_name as option_desc')->orderBy('state_id')->orderBy('district_name')->get()->toArray();
            } else {
                $assigned_states = explode(",", $state_id);
                $assgined_districts = '';
                foreach ($assigned_states as $key => $value) {
                    $districts = \App\Models\User\AssginedStateDistrictModel::where(['state_id' => str_replace("'", "", $value), 'user_id' => $this->data['current_user_id']])->select('district_id')->get()->toArray();
                    // t($districts);
                    if ($districts) {
                        foreach ($districts as $dist_key => $dist_value) {
                            $assgined_districts[] = $dist_value['district_id'];
                        }
                    }
                }
                $assgined_districts_str = ($assgined_districts) ? "'" . implode("','", $assgined_districts) . "'" : '';
                if ($assgined_districts_str) {
                    $district = DistrictModel::whereRaw("id in ({$assgined_districts_str}) AND fl_archive = 'N'")->select('id as option_code', 'district_name as option_desc')->orderBy('state_id')->orderBy('district_name')->get()->toArray();
                } else {
                    $district = '';
                }
            }
            //t($district, 1);
            if ($district) {
                foreach ($district as $key => $value) {
                    $value['option_code'];
                    $state_prefix = DistrictModel::find($value['option_code'])->getState->state_prefix;
                    $district[$key]['option_desc'] = $state_prefix . '-' . $value['option_desc'];
                }
            }
            //t($district, 1);
            return $district;
        } else {
            $district = DistrictModel::where(['state_id' => "$state_id", 'fl_archive' => "N"])->orderBy('district_name')->lists('district_name', 'id')->toArray();
        }
        $district = isset($district) ? array_merge(array('' => 'Select'), $district) : '';
        return $district;
    }

    public function getAllDistrict($state_id = '') {
        if (!$state_id) {
            $district = DistrictModel::where(['fl_archive' => "N"])->orderBy('district_name')->lists('district_name', 'id')->toArray();
        } else {
            $district = DistrictModel::where(['state_id' => "$state_id", 'fl_archive' => "N"])->orderBy('district_name')->lists('district_name', 'id')->toArray();
        }
        $district = array_merge(array('' => 'Select'), $district);
        return $district;
    }

    public function getAllBlock($district_id = '') {
        if (!$district_id) {
            $block = BlockModel::where(['fl_archive' => "N"])->orderBy('block_name')->lists('block_name', 'id')->toArray();
        } else {
            $block = BlockModel::where(['district_id' => "$district_id", 'fl_archive' => "N"])->orderBy('block_name')->lists('block_name', 'id')->toArray();
        }
        $block = array_merge(array('' => 'Select'), $block);
        return $block;
    }

    public function getAllVillage($block_id = '') {
        if (!$block_id) {
            $villages = VillageModel::orderBy('village_name')->lists('village_name', 'id')->toArray();
        } else {

            $villages = VillageModel::where(['block_id' => "$block_id"])->orderBy('village_name')->lists('village_name', 'id')->toArray();
        }
        $villages = array_merge(array('' => 'Select'), $villages);
        return $villages;
    }

    public function getAllCity($state_id = '') {
        if (!$state_id) {
            $city = CityModel::where(['fl_archive' => "N"])->orderBy('city_name')->lists('city_name', 'id')->toArray();
        } else {
            $city = CityModel::where(['state_id' => "$state_id", 'fl_archive' => "N"])->orderBy('city_name')->lists('city_name', 'id')->toArray();
        }
        $city = array_merge(array('' => 'Select'), $city);
        return $city;
    }

    public function getAllSubClassification($classification_id = '') {
        if (!$classification_id) {
            $city = SubClassificationModel::where(['fl_archive' => "N"])->orderBy('sub_name')->lists('sub_name', 'id')->toArray();
        } else {
            $city = SubClassificationModel::where(['classification_id' => "$classification_id", 'fl_archive' => "N"])->orderBy('sub_name')->lists('sub_name', 'id')->toArray();
        }
        $city = array_merge(array('' => 'Select'), $city);
        return $city;
    }
	public function getStatesnameById($state_id) {

        $states = [];
        
          $states = StateModel::whereRaw("id in ($state_id)")->get()->toArray();

      
        return isset($states[0]['state_name'])?$states[0]['state_name']:'';
    }
    public function getCodesDetails($type = null) {
        $codes = [];
        $codes = CodeModel::where(['cd_type' => "$type"])->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
        // t($codes);exit;
        $codes = array_merge(array('' => 'select'), $codes);
        return $codes;
    }

    public function getAllSurvey($registration_id = null, $village_id = null, $type = null, $list_with_survey_id = false) {


        if ($registration_id) {
            $survey_list = SurveyModel::where(['registration_id' => $registration_id])->orderBy('id')->lists('survey_no', 'survey_no')->toArray();
        } else if ($village_id && $type == 'ajax') {
            $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
            $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
            if ($registration_ids) {
                $survey_list = SurveyModel::where(['mutation_status' => 'N'])->whereRaw("registration_id in ($registration_ids)")->orderBy('id')->select('id as option_code', 'survey_no as option_desc')->get()->toArray();
            } else {
                $survey_list = '';
            }
            return $survey_list;
        } else if ($village_id && $type == null) {

            $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->where(['village_id' => $village_id])->get()->toArray();
            $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
            if ($registration_ids) {
                $survey_list = SurveyModel::whereRaw("registration_id in ($registration_ids)")->orderBy('id')->lists('survey_no', 'id')->toArray();
            } else {
                $survey_list = '';
            }
            $survey_list = array_merge(array('' => 'select'), $survey_list);
            return $survey_list;
            // t($survey_list, 1);
        } else {
            if ($this->user_type == 'admin') {
                $survey_list = SurveyModel::orderBy('id')->lists('survey_no', 'survey_no')->toArray();
                if ($list_with_survey_id) {

                    $survey_list = SurveyModel::orderBy('id')->lists('survey_no', 'id')->toArray();
                    if ($survey_list) {
                        $surveyList[''] = 'Select';
                        foreach ($survey_list as $key => $value) {
                            $surveyList[$key] = $value;
                        }
                    } else {
                        $surveyList[''] = '';
                    }
                    return $surveyList;
                }
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
                    $assgined_districts_str = isset($assgined_districts) && $assgined_districts ? "'" . implode("','", $assgined_districts) . "'" : '';
                    //t($assgined_districts,1);
                    if ($assgined_districts_str) {
                        $registration_ids = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as id_str")->whereRaw("district_id in ($assgined_districts_str)")->get()->toArray();
                        $registration_ids = isset($registration_ids[0]['id_str']) ? $registration_ids[0]['id_str'] : '';
                        $survey_list = ($registration_ids) ? SurveyModel::whereRaw("registration_id in ($registration_ids)")->orderBy('id')->lists('survey_no', 'survey_no')->toArray() : '';
                        if ($list_with_survey_id) {
                            $survey_list = ($registration_ids) ? SurveyModel::whereRaw("registration_id in ($registration_ids)")->orderBy('id')->lists('survey_no', 'id')->toArray() : '';
                            $survey_list = SurveyModel::orderBy('id')->lists('survey_no', 'id')->toArray();
                            if ($survey_list) {
                                $surveyList[''] = 'Select';
                                foreach ($survey_list as $key => $value) {
                                    $surveyList[$key] = $value;
                                }
                            } else {
                                $surveyList[''] = '';
                            }
                            return $surveyList;
                        }
                    }
                }
            }
        }

        if (isset($survey_list) && $survey_list) {
            $surveyList[''] = 'Select';
            foreach ($survey_list as $key => $value) {
                $surveyList[$value] = $value;
            }
        } else {
            $surveyList[''] = '';
        }

        return $surveyList;
    }

    public function getAllPatta($village_id = null, $type = null) {

        if ($village_id && $type == 'ajax') {

            $patta_list = PattaModel::where(['village_id' => $village_id, 'fl_archive' => 'N'])->whereRaw("mutation_status = 'P' or mutation_status = 'N'")->orderBy('id')->select('id as option_code', 'patta_no as option_desc')->get()->toArray();
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

    public function dropDown(Request $request, $option = true, $json = true) {
        $this->data['typeList'] = $typeList = $request->get('type');
        $this->data['namePrefix'] = $namePrefix = $request->get('namePrefix');
        $this->data['dropdown_type'] = $dropdown_type = $request->get('dropdown_type');
        $this->data['multiple'] = $multiple = $request->get('multiple');
        if ($typeList == 'district_id') {
            $state_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            if ($dropdown_type == 'dualbox') {
                $state_id = "'" . str_replace(array("'", ","), array("\\'", "','"), $state_id) . "'";
                $districts = $this->getAllDistrictForDropdown($state_id, 'multiple_state', 'ajax');
                $this->data['optionList'] = $optionList = $districts;
            } else {
                if ($this->user_type == 'admin') {
                    $districts = StateModel::find($state_id)->districts()->select('id as option_code', 'district_name as option_desc')->orderBy('district_name', 'ASC')->get()->toArray();
                } else {
                    $assigined_districts = \App\Models\User\AssginedStateDistrictModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(district_id)), ',') as dist_id_str")->where(['user_id' => $this->data['current_user_id'], 'state_id' => $state_id])->get()->toArray();
                    $assigined_districts = isset($assigined_districts[0]['dist_id_str']) ? $assigined_districts[0]['dist_id_str'] : '';
                    //$state_str = "'" . implode("','", $assigned_states) . "'";
                    $districts = ($assigined_districts) ? DistrictModel::select('id as option_code', 'district_name as option_desc')->whereRaw("id in ($assigined_districts)")->where(['fl_archive' => 'N'])->orderBy('district_name', 'ASC')->get()->toArray() : [];
                }
                $this->data['optionList'] = $optionList = $districts;
                $this->data['onchange'] = $optionList = 'onchange=populateBlock($(this).val(),"' . $namePrefix . '");';
            }
        } else if ($typeList == 'block_id') {
            $district_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $blocks = DistrictModel::find($district_id)->blocks()->select('id as option_code', 'block_name as option_desc')->orderBy('block_name', 'ASC')->get()->toArray();
            $this->data['optionList'] = $optionList = $blocks;
            // $this->data['onchange'] = $optionList = 'onchange=populateVillage($(this.val(),"' . $namePrefix . '")';
            $this->data['onchange'] = $optionList = 'onchange=populateVillage($(this).val(),"' . $namePrefix . '");';
        } else if ($typeList == 'village_id') {
            $block_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $villages = BlockModel::find($block_id)->villages()->select('id as option_code', 'village_name as option_desc')->orderBy('village_name', 'ASC')->get()->toArray();
            $this->data['optionList'] = $optionList = $villages;
            //$this->data['onchange'] = $optionList = 'onchange=populateSurvey("",$(this).val())';
            $onchange = $request->get('onchange');
            $this->data['onchange'] = ($onchange) ? 'onchange=' . $onchange : "";
        } else if ($typeList == 'survey_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $surveys = $this->getAllSurvey('', $village_id, 'ajax');
            //   t($surveys,1);
            $this->data['optionList'] = $optionList = $surveys;
        } else if ($typeList == 'city') {
            $state_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $cities = StateModel::find($state_id)->cities()->select('id as option_code', 'city_name as option_desc')->orderBy('city_name', 'ASC')->get()->toArray();
            $this->data['optionList'] = $optionList = $cities;
        } else if ($typeList == 'sub_classification') {
            $classification_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');

            $subclissification = $this->getAllSubClassification($classification_id);
            $villages = SubClassificationModel::select('id as option_code', 'sub_name as option_desc')->where(['classification_id' => "$classification_id", 'fl_archive' => "N"])->orderBy('sub_name', 'ASC')->get()->toArray();
            $this->data['optionList'] = $optionList = $villages;
        } else if ($typeList == 'patta_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $pattas = $this->getAllPatta($village_id, 'ajax');
            $this->data['optionList'] = $optionList = $pattas;
            $onchange = $request->get('onchange');
            $this->data['onchange'] = 'onchange=' . $onchange;
        } else if ($typeList == 'registration_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $parentConv = $request->get('parentConv');
            $registration_id = $this->getAllRegistration($village_id, 'ajax', $parentConv);
            $this->data['optionList'] = $optionList = $registration_id;
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

    public function download(Request $request) {
	 if ($this->user_type == 'admin') {
        $file_name = $request->get('path');
        if ($file_name) {
            $file_path = ($file_name);
            return response()->download($file_path);
        } else {
            return 'file name missing';
        }
	 } else {
            return abort(404);
        }
    }

    public function getAllRegistration($village_id = null, $type = null, $parentConv = null) {

        $registration_list = [];

        if ($parentConv == 'con_parent') {
            $cusCond = " con_parent = 'C'";
        } else if ($parentConv == 'lease') {
            $cusCond = " purchase_type_id = 'CD00144'";
        } elseif($parentConv =='hypothecate'){
            $cusCond = " hypothecate_status in('Y','R')";
        }else {
            $cusCond = "1=1";
        }

        if ($this->user_type == 'admin') {
            if ($type == 'ajax') {
                if ($village_id) {
                    $registration_list = RegistrationModel::select('id as option_code', 'id as option_desc')->where(['village_id' => $village_id])->whereRaw($cusCond)->orderBy('id')->get()->toArray();
                } else {
                    $registration_list = RegistrationModel::select('id as option_code', 'id as option_desc')->whereRaw($cusCond)->orderBy('id')->get()->toArray();
                }
            } else {
                if ($village_id) {
                    $registration_list = RegistrationModel::where(['village_id' => $village_id])->whereRaw($cusCond)->orderBy('id')->lists('id', 'id')->toArray();
                } else {
                    $registration_list = RegistrationModel::whereRaw($cusCond)->orderBy('id')->lists('id', 'id')->toArray();
                }
                if($parentConv !='hypothecate')
                $registration_list = array_merge(array('' => 'Select'), $registration_list);
            }
            return $registration_list;
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
                    if ($type == 'ajax') {
                        if ($village_id) {
                            $registration_list = RegistrationModel::select('id as option_code', 'id as option_desc')->where(['village_id' => $village_id])->whereRaw("district_id in ($assgined_districts_str)")->whereRaw($cusCond)->get()->toArray();
                        } else {
                            $registration_list = RegistrationModel::select('id as option_code', 'id as option_desc')->whereRaw("district_id in ($assgined_districts_str)")->whereRaw($cusCond)->get()->toArray();
                        }
                    } else {
                        if ($village_id) {
                            $registration_list = RegistrationModel::where(['village_id' => $village_id])->whereRaw("district_id in ($assgined_districts_str)")->whereRaw($cusCond)->get()->toArray();
                        } else {
                            $registration_list = RegistrationModel::whereRaw("district_id in ($assgined_districts_str)")->whereRaw($cusCond)->get()->toArray();
                        }
                        if($parentConv !='hypothecate')
                        $registration_list = array_merge(array('' => 'Select'), $registration_list);
                    }

                    return $registration_list;
                }
            }
        }
    }

}
