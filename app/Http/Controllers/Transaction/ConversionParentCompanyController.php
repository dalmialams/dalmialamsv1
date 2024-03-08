<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\DataLogModel;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\LandDetailsManagement\DocumentModel;
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
class ConversionParentCompanyController extends Controller {

    //put your code here

    protected $validationRules = [
        'conversionParCmp.purchaser' => 'required',
        'conversionParCmp.sub_registrar' => 'required',
        //'conversionParCmp.village_id' => 'required',
        'conversionParCmp.legal_entity' => 'required',
    ];
    protected $field_names = [
        'conversionParCmp.purchaser' => 'Name of the Purchaser',
        'conversionParCmp.sub_registrar' => 'Sub Registrar Office',
        //'conversionParCmp.village_id' => 'Village Name',
        'conversionParCmp.legal_entity' => 'Legal Entity',
    ];

    public function __construct() {
        parent:: __construct();

        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Transaction-mutation';
        $this->data['villages'] = $this->getAllVillage();
        $this->data['patta_list'] = $this->getAllPatta();
        $this->data['purchase'] = $this->getPurchaserName('purchaser_name');
        $this->data['sub_registrar_office'] = $this->getCodesDetails('sub_registrar_office');
        $this->data['legal_entry'] = $this->getCodesDetails('legal_entity');
        $this->data['include_script_view'] = 'admin.Transaction.ConversionParentCompany.script';
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

        $this->data['pageHeading'] = 'Conversion To Parent Company <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-conversion-to-parent-company-Add';
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
        //$res = RegistrationModel::where(['fl_archive' => 'N', 'con_parent' => 'C'])->get()->toArray();
        if (isset($this->assgined_districts_str) && !empty($this->assgined_districts_str)) {
            $res = RegistrationModel::whereRaw(" district_id in ($this->assgined_districts_str)")->where(['fl_archive' => 'N', 'con_parent' => 'C'])->get()->toArray();
        } else {
            $res = RegistrationModel::where(['fl_archive' => 'N', 'con_parent' => 'C'])->get()->toArray();
        }
        $this->data['parentLists'] = $res;

        return view('admin.Transaction.ConversionParentCompany.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data); die();
        $posted_conversionParCmp_data = isset($posted_data['conversionParCmp']) ? $posted_data['conversionParCmp'] : '';
        $registration_id = isset($posted_data['registration_id']) ? $posted_data['registration_id'] : '';
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            $msg = UtilityModel::getMessage('Somthing Error Occur!', 'error');
            return redirect('transaction/conversion-parent-company/add')->with('message', $msg);
        } else {
            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('conversion_to_parent_company_add')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('transaction/conversion-parent-company/add')
                                ->withErrors($validator, 'converparentcompany')
                                ->withInput();
            }

            //Get the Registration Nos and Check the Match Feild Value
            if ($registration_id) {
                $all_registration_id = "'" . implode('\',\'', $registration_id) . "'";
                $all_registration_id_without_quotes = implode(',', $registration_id);
                $registration_list = RegistrationModel::where(['fl_archive' => 'N', 'con_parent' => 'N'])->whereRaw("id in ($all_registration_id)")->get()->toArray();

                $vendor = $registration_list[0]['vendor'];
                $purchasing_team_id = $registration_list[0]['purchasing_team_id'];
                $plot_type_id = $registration_list[0]['plot_type_id'];
                $tot_area_unit = $registration_list[0]['tot_area_unit'];
                $state_id = $registration_list[0]['state_id'];
                $district_id = $registration_list[0]['district_id'];
                $block_id = $registration_list[0]['block_id'];
                $village_id = $registration_list[0]['village_id'];
                $tot_area = 0;
                $tot_cost = 0;

                foreach ($registration_list as $val) {
                    $vendor = ($val['vendor'] == $vendor) ? $vendor : '';
                    $tot_area = $tot_area + $val['tot_area'];
                    $tot_cost = $tot_cost + $val['tot_cost'];
                    $purchasing_team_id = ($val['purchasing_team_id'] == $purchasing_team_id) ? $purchasing_team_id : '';
                    $plot_type_id = ($val['plot_type_id'] == $plot_type_id) ? $plot_type_id : '';
                    $tot_area_unit = ($val['tot_area_unit'] == $tot_area_unit) ? $tot_area_unit : '';
                    $state_id = ($val['state_id'] == $state_id) ? $state_id : '';
                    $district_id = ($val['district_id'] == $district_id) ? $district_id : '';
                    $block_id = ($val['block_id'] == $block_id) ? $block_id : '';
                    $village_id = ($val['village_id'] == $village_id) ? $village_id : '';
                }


                //registration Table Part Data Insert and Modify
                $registrationData['legal_entity'] = $posted_conversionParCmp_data['legal_entity'];
                $registrationData['purchase_type_id'] = $registration_list[0]['purchase_type_id'];
                $registrationData['sub_registrar'] = $posted_conversionParCmp_data['sub_registrar'];
                $registrationData['vendor'] = $vendor;
                $registrationData['tot_area'] = $tot_area;
                $registrationData['tot_area_unit'] = $tot_area_unit;
                $registrationData['tot_cost'] = $tot_cost;
                $registrationData['state_id'] = $state_id;
                $registrationData['district_id'] = $district_id;
                $registrationData['block_id'] = $block_id;
                $registrationData['village_id'] = $village_id;
                $registrationData['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                //$registrationData['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                $registrationData['created_at'] = Carbon::now();
                $registrationData['purchaser'] = $posted_conversionParCmp_data['purchaser'];
                $registrationData['purchasing_team_id'] = $purchasing_team_id;
                $registrationData['regn_date'] = date('Y-m-d');
                $registrationData['plot_type_id'] = $plot_type_id;
                $registrationData['con_parent'] = 'C'; //Means this is a converted Parent Company Registration
                $registrationData['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                $reg_insert_id = RegistrationModel::insertGetId($registrationData);

                if ($reg_insert_id) {//For Sucessfully Insert
                    //parent conversion data insert in transaction
                    $parent_conv_data['converted_registration_id'] = $reg_insert_id;
                    $parent_conv_data['old_registration_id'] = $all_registration_id_without_quotes;
                    $parent_conv_data['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                    $parent_conv_data['created_at'] = Carbon::now();
                    $parent_conv_data['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                    $parent_conversion_id = \App\Models\Transaction\ParentConversionModel::insertGetId($parent_conv_data);
                    if ($parent_conversion_id) {
                        foreach ($registration_id as $r_key => $r_value) {
                            $conv_data['old_reg_id'] = $r_value;
                            $conv_data['converted_reg_id'] = $reg_insert_id;
                            $conv_data['transaction_id'] = $parent_conversion_id;
                            $conv_data['created_at'] = Carbon::now();
                            $conv_data['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                            $conv_data['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                            $insert_converted_reg_id = \App\Models\Transaction\ConvertedRegistrationModel::insertGetId($conv_data);
                        }
                    }
                    //Update the Registration table 
                    foreach ($registration_list as $val) {
                        $reg_data_to_update['con_parent'] = 'Y'; //Means this Registration is already Converted to Parent Company
                        $reg_data_to_update['con_reg_id'] = $reg_insert_id;
                        RegistrationModel::where(['id' => $val['id']])->update($reg_data_to_update);
                    }

                    //Replace all previous surveys regstration ids with the new created parent registration ids
                    $all_survey_list = SurveyModel::where(['fl_archive' => 'N'])->whereRaw("registration_id in ($all_registration_id)")->get()->toArray();
                    if ($all_survey_list) {
                        foreach ($all_survey_list as $surKey => $surVal) {
                            //Data Log For future Reference
                            $dataLogInsert['ref_id'] = $surVal['id'];
                            $dataLogInsert['pre_id'] = $surVal['registration_id'];
                            $dataLogInsert['type'] = 'survey';
                            $dataLogInsert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                            $dataLogInsert['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                            $dataLogInsert['created_at'] = Carbon::now();
                            DataLogModel::insertGetId($dataLogInsert);
                            $survey_Data_update['registration_id'] = $reg_insert_id;
                            SurveyModel::where(['id' => $surVal['id']])->update($survey_Data_update);
                        }
                    }

                    //Replace all previous document regstration ids with the new created parent registration ids
                    $all_document_list = DocumentModel::where(['fl_archive' => 'N'])->whereRaw("registration_id in ($all_registration_id)")->get()->toArray();
                    if ($all_document_list) {
                        foreach ($all_document_list as $docKey => $docVal) {

                            //Data Log For future Reference
                            $dataLogInsert['ref_id'] = $docVal['id'];
                            $dataLogInsert['pre_id'] = $docVal['registration_id'];
                            $dataLogInsert['type'] = 'document';
                            $dataLogInsert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                            $dataLogInsert['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                            $dataLogInsert['created_at'] = Carbon::now();
                            DataLogModel::insertGetId($dataLogInsert);

                            $document_Data_update['registration_id'] = $reg_insert_id;
                            DocumentModel::where(['id' => $docVal['id']])->update($document_Data_update);
                        }
                    }



                    $msg = UtilityModel::getMessage('Registraions are sucessfully Converted to Parent Company!');
                    return redirect('land-details-entry/registration/edit?reg_uniq_no=' . $reg_insert_id)->with('message', $msg);
                } else {//Failed
                    $msg = UtilityModel::getMessage('Somthing Error Occur!', 'error');
                    return redirect('transaction/conversion-parent-company/add')->with('message', $msg);
                }
            } else {
                $msg = UtilityModel::getMessage('Please Select Valid Registration Nos', 'error');
                return redirect('transaction/conversion-parent-company/add')->with('message', $msg);
            }
        }
    }

    public function dropDown(Request $request, $option = true, $json = true) {
        $this->data['typeList'] = $typeList = $request->get('type');
        $this->data['namePrefix'] = $namePrefix = $request->get('namePrefix');
        $this->data['dropdown_type'] = $dropdown_type = $request->get('dropdown_type');
        $this->data['multiple'] = $multiple = $request->get('multiple');

        if ($typeList == 'registration_id') {
            $village_id = $request->get('val');
            $purchaser_name = $request->get('purchaser_name');
            $sub_registrar = $request->get('sub_registrar');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $registrations = $this->getAllRegistrationIds($purchaser_name, $sub_registrar, $village_id, 'ajax');
            $this->data['optionList'] = $optionList = $registrations;
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

    public function getAllRegistrationIds($purchaser_name = null, $sub_registrar = null, $village_id = null, $type = null) {
        $registration_list = '';
        if ($purchaser_name && $sub_registrar && $type == 'ajax') {
            $registration_list = RegistrationModel::where(['fl_archive' => 'N', 'con_parent' => 'N', 'purchaser' => $purchaser_name, 'sub_registrar' => $sub_registrar, 'purchase_type_id' => 'CD00142'])->orderBy('id')->select('id as option_code', 'id as option_desc')->get()->toArray();
        }/* elseif($village_id && $type == 'ajax'){
          $registration_list = RegistrationModel::where(['fl_archive'=>'N','village_id'=>$village_id])->orderBy('id')->select('id as option_code', 'id as option_desc')->get()->toArray();
          } */

        return $registration_list;
    }

    public function getPurchaserName($type = null) {
        $codes = [];
        $codes = \App\Models\Common\CodeModel::where(['cd_type' => "$type", 'cd_fl_archive' => 'N', 'subsidiary' => 'N'])->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
        // t($codes);exit;
        $codes = array_merge(array('' => 'select'), $codes);
        return $codes;
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
