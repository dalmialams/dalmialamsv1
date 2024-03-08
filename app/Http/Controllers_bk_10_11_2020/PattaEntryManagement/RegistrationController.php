<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\LandEntryManagement;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\LandDetailsManagement\DocumentModel;
use App\Models\LandDetailsManagement\PaymentModel;
use App\Models\Common\DistrictModel;
use App\Models\Common\BlockModel;
use App\Models\Common\StateModel;
use App\Models\UtilityModel;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;

/**
 * Description of RegistrationController
 *
 * @author user-98-pc
 */
class RegistrationController extends Controller {

    //put your code here
    protected $validationRules = [
        'registration.state_id' => 'required',
        'registration.purchasing_team_id' => 'required',
        'registration.purchaser' => 'required',
        'registration.legal_entity' => 'required',
        'registration.purchase_type_id' => 'required',
        'registration.vendor' => 'required',
        'registration.tot_area_unit' => 'required',
        'registration.tot_area' => 'required|numeric',
        'registration.tot_cost' => 'required|numeric',
    ];
    protected $field_names = [
         'registration.state_id' => 'State',
        'registration.purchasing_team_id' => 'Purchasing Team',
        'registration.purchasing_team_id' => 'Name of the Purchaser',
        'registration.legal_entity' => 'Legal Entity',
        'registration.purchase_type_id' => 'Purchase Type',
        'registration.vendor' => 'Name of the Purchaser',
        'registration.tot_area_unit' => 'Total Area Unit',
        'registration.tot_area' => 'Total Area',
        'registration.tot_cost' => 'Total Cost'
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Registration';
        $this->data['section'] = 'registration';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        $this->data['area_units'] = $this->getCodesDetails('area_unit');
        $this->data['purchase_type'] = $this->getCodesDetails('purchase_type');
        $this->data['purchase'] = $this->getCodesDetails('purchaser_name');
        $this->data['legal_entry'] = $this->getCodesDetails('legal_entity');
        $this->data['purchasing_team'] = $this->getCodesDetails('purchasing_team');
        $this->data['plot_type'] = $this->getCodesDetails('plot_type');
        $this->data['plot_classification'] = $this->getCodesDetails('plot_classification');
        $this->data['land_usage'] = $this->getCodesDetails('land_usage');
        $this->data['survey_list'] = $this->getAllSurvey();
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        //  $this->data['title'] = 'Dalmia-lams::Registration/Add';
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Add</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Registration.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        if ($this->data['reg_uniq_no']) {  /// for edit
            $reg_uniq_no = $this->data['reg_uniq_no'];
            $reg_info = RegistrationModel::find($reg_uniq_no)->toArray();
            // t($reg_info, 1);
            $this->data['reg_data'] = $reg_info;
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';

            if ($reg_info['state_id']) {
                $this->data['district_info'] = $this->getAllDistrict($reg_info['state_id']);
            }
            if ($reg_info['district_id']) {
                $this->data['block_info'] = $this->getAllBlock($reg_info['district_id']);
            }
            if ($reg_info['village_id']) {
                $this->data['village_info'] = $this->getAllBlock($reg_info['village_id']);
            }
        }
        if ($this->data['viewMode'] == 'true') {
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        }
        return view('admin.LandEntryManagement.Registration.add', $this->data);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function regList(Request $request) {
        $this->data['title'] = 'Dalmia-lams::Registration/List';
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Search</span>';
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Registration.listscript';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';

        //For Search Registration Lists
        $posted_data = $request->all();
        $cond = '1=1 ';

        if ($posted_data) {

            $allSearchData = $posted_data['registration'];
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
            }
            if (!empty($allSearchData['sub_registrar'])) {
                $cond .= " AND sub_registrar = '{$allSearchData['sub_registrar']}'";
                $this->data['sub_registrar'] = $allSearchData['sub_registrar'];
            }
            if (!empty($allSearchData['regn_no'])) {
                $cond .= " AND regn_no = '{$allSearchData['regn_no']}'";
                $this->data['regn_no'] = $allSearchData['regn_no'];
            }
            if (!empty($allSearchData['id'])) {
                $cond .= " AND id = '{$allSearchData['id']}'";
                $this->data['id'] = $allSearchData['id'];
            }
            if (!empty($allSearchData['purchase_type_id'])) {
                $cond .= " AND purchase_type_id = '{$allSearchData['purchase_type_id']}'";
                $this->data['purchase_type_id'] = $allSearchData['purchase_type_id'];
            }
            if (!empty($allSearchData['purchaser'])) {
                $cond .= " AND purchaser = '{$allSearchData['purchaser']}'";
                $this->data['purchaser'] = $allSearchData['purchaser'];
            }
            if (!empty($allSearchData['legal_entity'])) {
                $cond .= " AND legal_entity = '{$allSearchData['legal_entity']}'";
                $this->data['legal_entity'] = $allSearchData['legal_entity'];
            }
            if (!empty($allSearchData['from_date'])) {
                $cond .= " AND to_date(regn_date,'DD/MM/YYYY') >= to_date('{$allSearchData['from_date']}','DD/MM/YYYY')";
                $this->data['from_date'] = $allSearchData['from_date'];
            }
            if (!empty($allSearchData['to_date'])) {
                $cond .= " AND to_date(regn_date,'DD/MM/YYYY') <= to_date('{$allSearchData['to_date']}','DD/MM/YYYY')";
                $this->data['to_date'] = $allSearchData['to_date'];
            }
            if (!empty($allSearchData['purchaser'])) {
                $cond .= " AND purchaser = '{$allSearchData['purchaser']}'";
                $this->data['purchaser'] = $allSearchData['purchaser'];
            }
            if (!empty($allSearchData['purchasing_team_id'])) {
                $cond .= " AND purchasing_team_id = '{$allSearchData['purchasing_team_id']}'";
                $this->data['purchasing_team_id'] = $allSearchData['purchasing_team_id'];
            }
            if (!empty($allSearchData['survey_no'])) {

               // $survey_no_str = "'" . implode("','", $allSearchData['survey_no']) . "'";
                $survey_no = $allSearchData['survey_no'];
                $reg_id = SurveyModel::selectRaw("array_to_string(array_agg(distinct QUOTE_LITERAL(registration_id)), ',') as id_str")->whereRaw("survey_no like '$survey_no'")->get()->toArray();
                $reg_id_str = isset($reg_id[0]['id_str']) ? $reg_id[0]['id_str'] : '';
                //  t($reg_id, 1);
                if ($reg_id_str) {
                    $cond .= " AND id in({$reg_id_str})";
                }
                $this->data['survey_no'] = $allSearchData['survey_no'];
            }
            if (!empty($allSearchData['purpose'])) {
                $reg_id = SurveyModel::selectRaw("array_to_string(array_agg(distinct QUOTE_LITERAL(registration_id)), ',') as id_str")->where(['purpose' => $allSearchData['purpose']])->get()->toArray();
                $reg_id_str = isset($reg_id[0]['id_str']) ? $reg_id[0]['id_str'] : '';
                //  t($reg_id, 1);
                if ($reg_id_str) {
                    $cond .= " AND id in({$reg_id_str})";
                }
                // $cond .= " AND id = '{$reg_id}'";
                $this->data['purpose'] = $allSearchData['purpose'];
            }
            if (!empty($allSearchData['classification'])) {
                $reg_id = SurveyModel::selectRaw("array_to_string(array_agg(distinct QUOTE_LITERAL(registration_id)), ',') as id_str")->where(['classification' => $allSearchData['classification']])->get()->toArray();
                $reg_id_str = isset($reg_id[0]['id_str']) ? $reg_id[0]['id_str'] : '';
                //   t($reg_id_str, 1);
                if ($reg_id_str) {
                    $cond .= " AND id in({$reg_id_str})";
                }
                // $cond .= " AND id = '{$reg_id}'";
                $this->data['classification'] = $allSearchData['classification'];
                $this->data['sub_classinfo'] = $this->getAllSubClassification($allSearchData['classification']);
            }
            if (!empty($allSearchData['sub_classification'])) {
                $reg_id = SurveyModel::selectRaw("array_to_string(array_agg(distinct QUOTE_LITERAL(registration_id)), ',') as id_str")->where(['sub_classification' => $allSearchData['sub_classification']])->get()->toArray();
                $reg_id_str = isset($reg_id[0]['id_str']) ? $reg_id[0]['id_str'] : '';
                //  t($reg_id, 1);
                if ($reg_id_str) {
                    $cond .= " AND id in({$reg_id_str})";
                }
                // $cond .= " AND id = '{$reg_id}'";
                $this->data['sub_classification'] = $allSearchData['sub_classification'];
            }

            $res = RegistrationModel::whereRaw($cond)->orderBy('id', 'DESC')->get()->toArray();
            $this->data['registration'] = $res;
            $this->data['dataPresent'] = 'yes';
        } else {
            $this->data['registration'] = '';
            $this->data['dataPresent'] = 'no';
        }


        return view('admin.LandEntryManagement.Registration.list', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
       // t($posted_data,1);exit;
        $posted_registration_data = isset($posted_data['registration']) ? $posted_data['registration'] : '';
        
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('land-details-entry/registration/add?reg_uniq_no=' . $id)
                                ->withErrors($validator, 'registration')
                                ->withInput();
            }
            $data_to_update = $posted_registration_data;
            $data_to_update['updated_at'] = Carbon::now();
            if($data_to_update['regn_date'] == ''){
                unset($data_to_update['regn_date']);
            }
            $update = RegistrationModel::where(['id' => $id])->update($data_to_update);
            //$msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
            $msg = UtilityModel::getMessage('Registration data updated successfully!');
            if ($update) {
                if ($posted_data['save_reg'] == 'save') {
                    return redirect('land-details-entry/registration/add?reg_uniq_no=' . $id)->with('message', $msg);
                } else if ($posted_data['save_reg'] == 'save_continue') {
                    return redirect('land-details-entry/survey/add?reg_uniq_no=' . $id)->with('message', $msg);
                }
            }
        } else {
            if ($validator->fails()) {
                return redirect('land-details-entry/registration/add')
                                ->withErrors($validator, 'registration')
                                ->withInput();
            }
            $data_to_insert = $posted_registration_data;
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['updated_at'] = Carbon::now();
            if($data_to_insert['regn_date'] == ''){
                unset($data_to_insert['regn_date']);
            }

            //Create the Registration Unique Id
            $existsData = RegistrationModel::where(['state_id' => $data_to_insert['state_id']])->orderBy('id', 'desc')->take(1)->lists('reg_id')->toArray();
            $sate_prefix = StateModel::where(['id' => "{$data_to_insert['state_id']}"])->lists('state_prefix')->toArray();
            if (!empty($sate_prefix[0])) {
                if (!empty($existsData[0])) {
                    $getPreviousnumber = substr($existsData[0], 2) + 1;
                    $getPreviousnumber = sprintf('%07d', $getPreviousnumber);
                    $unique_reistration_number = $sate_prefix[0] . $getPreviousnumber;
                } else {
                    $unique_reistration_number = $sate_prefix[0] . '0000001';
                }
                $data_to_insert['reg_id'] = $unique_reistration_number;
            }

            $insert_id = RegistrationModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Registration data saved successfully!');
            if ($insert_id) {
                if ($posted_data['save_reg'] == 'save') {
                    return redirect('land-details-entry/registration/add')->with('message', $msg);
                } else if ($posted_data['save_reg'] == 'save_continue') {
                    return redirect('land-details-entry/survey/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                }
            }
        }
    }

    public function regView($id = null) {

        $this->data['title'] = 'Dalmia-lams::Registration/View';
        $this->data['pageHeading'] = 'Land Details : ' . $id;

        if (empty($id)) {
            return redirect('land-details-entry/registration/list');
        } else {
            //Get Registration Info
            $reg_info = RegistrationModel::where(['id' => "$id"])->get()->toArray();
            if (empty($reg_info)) {
                return redirect('land-details-entry/registration/list');
            }
            $this->data['reg_info'] = $reg_info[0];

            //Get Survey No Details
            $survey_info = SurveyModel::where(['registration_id' => $id])->get()->toArray();
            $this->data['survey_info'] = $survey_info;

            //Get Document Details
            $all_docs = ($id) ? DocumentModel::where(['registration_id' => "$id"])->get()->toArray() : '';
            $this->data['all_docs'] = $all_docs;

            //Get Payment Details
            $payment_info = PaymentModel::where(['registration_id' => $id])->get()->toArray();
            $this->data['payment_info'] = $payment_info;

            return view('admin.LandEntryManagement.Registration.view', $this->data);
        }
    }

}
