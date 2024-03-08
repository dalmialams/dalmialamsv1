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
use App\Models\LeaseManagement\LeaseModel;
use App\Models\Audit\AuditMasterModel;
use App\Models\Audit\AuditStatusDataModel;
use App\Models\Audit\AuditStatusRegModel;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;
use DB;
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
        'registration.sub_registrar' => 'required_if:registration.purchase_type_id,CD00142',
        'registration.regn_no' => 'required_if:registration.purchase_type_id,CD00142',
    ];
    protected $field_names = [
        'registration.state_id' => 'State',
        'registration.purchasing_team_id' => 'Purchasing Team',
        'registration.purchasing_team_id' => 'Name of the Purchaser',
        'registration.legal_entity' => 'Legal Entity',
        'registration.purchase_type_id' => 'Purchase Type',
        'registration.vendor' => 'Name of the Vendor',
        'registration.tot_area_unit' => 'Total Area Unit',
        'registration.tot_area' => 'Total Area',
        'registration.tot_cost' => 'Total Cost',
        'registration.sub_registrar' => 'Sub Registrar Office',
        'registration.regn_no' => 'Document Regn No'
    ];
    protected $messages = [
        'registration.sub_registrar.required_if' => 'Sub Registrar Office is required',
        'registration.regn_no.required_if' => 'Document Regn No is required'
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Registration';
        $this->data['section'] = 'registration';
        $this->data['states'] = $this->getAllStates();
        // t($this->data['states']);
        $this->data['districts'] = $this->getAllDistrict();
        //t($this->data['districts']);
        $this->data['blocks'] = $this->getAllBlock();
        // t($this->data['districts'],1);
        $this->data['area_units'] = $this->getCodesDetails('area_unit');
        $this->data['purchase_type'] = $this->getCodesDetails('purchase_type');
        $this->data['purchase'] = $this->getCodesDetails('purchaser_name');
        $this->data['legal_entry'] = $this->getCodesDetails('legal_entity');
        $this->data['purchasing_team'] = $this->getCodesDetails('purchasing_team');
        $this->data['plot_type'] = $this->getCodesDetails('plot_type');
        $this->data['plot_classification'] = $this->getCodesDetails('plot_classification');
        $this->data['land_usage'] = $this->getCodesDetails('land_usage');
        $this->data['sub_registrar_office'] = $this->getCodesDetails('sub_registrar_office');
        $this->data['survey_list'] = $this->getAllSurvey();
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, $this->messages, $this->field_names);
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
        return view('admin.LandEntryManagement.Registration.add', $this->data);
    }

    public function edit(Request $request) {
        //  $this->data['title'] = 'Dalmia-lams::Registration/Add';
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Registration.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        if ($this->data['reg_uniq_no'] && $this->data['viewMode'] !== 'true') {  /// for edit
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
                //$this->data['village_info'] = $this->getAllBlock($reg_info['village_id']);
                $this->data['village_info'] = $this->getAllVillage($reg_info['block_id']);
            }
        } else {
            if ($this->user_type !== 'admin') {
                return redirect('unauthorized-access');
            } else {
                return redirect('/land-details-entry/registration/add');
            }
        }

        return view('admin.LandEntryManagement.Registration.add', $this->data);
    }

    public function regView() {

        //  $this->data['title'] = 'Dalmia-lams::Registration/Add';
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Registration.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';

        if ($this->data['reg_uniq_no'] && $this->data['viewMode'] == 'true') {

            $reg_uniq_no = $this->data['reg_uniq_no'];
            $reg_info = RegistrationModel::find($reg_uniq_no)->toArray();
            // t($reg_info, 1);
            $this->data['reg_data'] = $reg_info;
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
            return view('admin.LandEntryManagement.Registration.add', $this->data);
        } else {
            if ($this->user_type !== 'admin') {
                return redirect('unauthorized-access');
            } else {
                return redirect('/land-details-entry/registration/add');
            }
        }
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
        $cond = "1=1 AND fl_archive ='N' ";
		

        if ($posted_data) {
			//t($posted_data,1);
            $allSearchData = $posted_data['registration'];
            if (empty($allSearchData['state_id']) && empty($allSearchData['district_id'])) {
                $assgined_districts_str = UtilityModel::assignedDistricts($this->user_type, $this->assigned_states, $this->data['current_user_id']);
                if ($assgined_districts_str) {
                    $cond.= " AND district_id in ($assgined_districts_str) ";
                }
            }
            //exit;
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
                //$cond .= " AND to_date(regn_date,'DD/MM/YYYY') >= to_date('{$allSearchData['from_date']}','DD/MM/YYYY')";
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", $allSearchData['from_date'])));
                $cond .= " AND regn_date >= '{$start_date}'";
                $this->data['from_date'] = $allSearchData['from_date'];
            }
            if (!empty($allSearchData['to_date'])) {
                //$cond .= " AND to_date(regn_date,'DD/MM/YYYY') <= to_date('{$allSearchData['to_date']}','DD/MM/YYYY')";
                $end_date = date('Y-m-d', strtotime(str_replace("/", "-", $allSearchData['to_date'])));
                $cond .= " AND regn_date <= '{$end_date}'";
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
					//$cond .= " AND id in({$reg_id})";
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

            //echo $cond;
            //exit;
            $res = RegistrationModel::whereRaw($cond)->orderBy('id', 'DESC')->get()->toArray();
            $this->data['registration'] = $res;
            $this->data['dataPresent'] = 'yes';
			//t($res);die();
        } else {
            $this->data['registration'] = '';
            $this->data['dataPresent'] = 'no';
        }

        return view('admin.LandEntryManagement.Registration.list', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data,1);exit;
        $posted_registration_data = isset($posted_data['registration']) ? $posted_data['registration'] : '';
//		$posted_registration_data['regn_date'] = isset($posted_registration_data['regn_date'])?date('Y-m-d',strtotime($posted_registration_data['regn_date'])):'';
        $posted_registration_data['regn_date'] = isset($posted_registration_data['regn_date'])?date('Y-m-d',strtotime(str_replace("/", "-", $posted_registration_data['regn_date']))):'';
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules, $this->messages);
        $validator->setAttributeNames($this->field_names);

        if ($id) {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('registration_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('land-details-entry/registration/edit?reg_uniq_no=' . $id)
                                ->withErrors($validator, 'registration')
                                ->withInput();
            }
            $data_to_update = $posted_registration_data;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = $this->data['current_user_id'];
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            if ($data_to_update['regn_date'] == '') {
                unset($data_to_update['regn_date']);
            }
            $update = RegistrationModel::where(['id' => $id])->update($data_to_update);
            //$msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
            $msg = UtilityModel::getMessage('Registration data updated successfully!');
            if ($update) {
                if ($posted_data['save_reg'] == 'save') {
                    return redirect('land-details-entry/registration/edit?reg_uniq_no=' . $id)->with('message', $msg);
                } else if ($posted_data['save_reg'] == 'save_continue') {
                    //return redirect('land-details-entry/survey/add?reg_uniq_no=' . $id)->with('message', $msg);
                    if ($this->user_type !== 'admin') {
                        if ($this->hasPermission('registration_access') && $this->hasPermission('survey_no_details_add')) {
                            return redirect('land-details-entry/survey/add?reg_uniq_no=' . $id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('document_upload_add')) {
                            return redirect('land-details-entry/document/add?reg_uniq_no=' . $id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('payment_details_add')) {
                            return redirect('land-details-entry/payment/add?reg_uniq_no=' . $id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('lease_details_add')) {
                            if (isset($this->data['purchase_type_id']) && $this->data['purchase_type_id'] == 'CD00144') {
                                return redirect('land-details-entry/lease/add?reg_uniq_no=' . $id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                                return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                                return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $id)->with('message', $msg);
                            } else {
                                return redirect('land-details-entry/registration/edit?reg_uniq_no=' . $id);
                            }
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                            return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                            return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $id)->with('message', $msg);
                        } else {
                            return redirect('land-details-entry/registration/edit?reg_uniq_no=' . $id);
                        }
                    } else {
                        return redirect('land-details-entry/survey/edit?reg_uniq_no=' . $id)->with('message', $msg);
                    }
                }
            }
        } else {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('registration_add')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('land-details-entry/registration/add')
                                ->withErrors($validator, 'registration')
                                ->withInput();
            }
            $data_to_insert = $posted_registration_data;
            $data_to_insert['created_at'] = Carbon::now();
            //$data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['crt_id'] = $this->data['current_user_id'];
            // $data_to_insert['upd_id'] = $this->data['current_user_id'];

            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            if ($data_to_insert['regn_date'] == '') {
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
                    return redirect('land-details-entry/registration/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                } else if ($posted_data['save_reg'] == 'save_continue') {
                    if ($this->user_type !== 'admin') {
                        if ($this->hasPermission('registration_access') && $this->hasPermission('survey_no_details_add')) {
                            return redirect('land-details-entry/survey/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('document_upload_add')) {
                            return redirect('land-details-entry/document/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('payment_details_add')) {
                            return redirect('land-details-entry/payment/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('lease_details_add')) {
                            if (isset($this->data['purchase_type_id']) && $this->data['purchase_type_id'] == 'CD00144') {
                                return redirect('land-details-entry/lease/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                                return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $insert_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                                return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $insert_id)->with('message', $msg);
                            } else {
                                if ($this->hasPermission('registration_access') && $this->hasPermission('registration_edit')) {
                                    return redirect('land-details-entry/registration/edit?reg_uniq_no=' . $insert_id);
                                } else {
                                    return redirect('land-details-entry/registration/add?reg_uniq_no=' . $insert_id);
                                }
                            }
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                            return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $insert_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                            return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $insert_id)->with('message', $msg);
                        } else {
                            if ($this->hasPermission('registration_access') && $this->hasPermission('registration_edit')) {
                                return redirect('land-details-entry/registration/edit?reg_uniq_no=' . $insert_id);
                            } else {
                                return redirect('land-details-entry/registration/add?reg_uniq_no=' . $insert_id);
                            }
                        }
                    } else {
                        return redirect('land-details-entry/survey/add?reg_uniq_no=' . $insert_id)->with('message', $msg);
                    }
                }
            }
        }
    }

    public function transactionDetails() {
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Transaction Details</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction';
        $this->data['section'] = 'transaction';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Registration.script';
        $reg_uniq_no = $this->data['reg_uniq_no'];
        $reg_info = ($reg_uniq_no) ? RegistrationModel::find($reg_uniq_no)->toArray() : '';
        // t($reg_info,1);
        $this->data['dataPresent'] = '';
        $this->data['reg_info'] = ($reg_info) ? $reg_info : '';
        $survey_id_res = ($reg_uniq_no) ? SurveyModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as survey_id_str")
                        ->where(['registration_id' => $reg_uniq_no])->get()->toArray() : '';
        $survey_id_str = isset($survey_id_res[0]['survey_id_str']) ? $survey_id_res[0]['survey_id_str'] : '';

        //conversion to parent company
        $conversion_to_parent_company_details = \App\Models\Transaction\ConvertedRegistrationModel::where(['old_reg_id' => $reg_uniq_no])->get()->toArray();
        //   t($conversion_to_parent_company_details,1);
        $this->data['conversion_to_parent_company_details'] = $conversion_to_parent_company_details;
        /// land ceilling //////
        $ceiling_survey_res = ($survey_id_str) ? \App\Models\Transaction\LandCeilingSurveyModel::whereRaw("survey_id in ($survey_id_str)")->selectRaw("array_to_string(array_agg(distinct (QUOTE_LITERAL(ceiling_id))), ',') as ceiling_id_str")->get()->toArray() : '';
        $ceiling_id_str = isset($ceiling_survey_res[0]['ceiling_id_str']) ? $ceiling_survey_res[0]['ceiling_id_str'] : '';
        $this->data['ceilings'] = $ceilings = ($ceiling_id_str) ? \App\Models\Transaction\LandCeilingModel::whereRaw("id in ($ceiling_id_str)")->where(['fl_archive' => 'N'])->with('getCeilingSurveys')->orderBy('id', 'DESC')->get()->toArray() : '';

        /// land exchange
        $exchange_survey_res = ($survey_id_str) ? \App\Models\Transaction\LandExchangeSurveyModel::whereRaw("survey_id in ($survey_id_str)")->selectRaw("array_to_string(array_agg(distinct (QUOTE_LITERAL(land_exchange_id))), ',') as exchange_id_str")->get()->toArray() : '';
        $exchange_id_str = isset($exchange_survey_res[0]['exchange_id_str']) ? $exchange_survey_res[0]['exchange_id_str'] : '';
        $this->data['exchanges'] = $exchanges = ($exchange_id_str) ? \App\Models\Transaction\LandExchangeModel::whereRaw("id in ($exchange_id_str)")->where(['fl_archive' => 'N'])->with('getExchangedSurveys')->orderBy('id', 'DESC')->get()->toArray() : '';

        /// land conversion
        $conversion_survey_res = ($survey_id_str) ? \App\Models\Transaction\LandConversionSurveyModel::whereRaw("survey_id in ($survey_id_str)")->selectRaw("array_to_string(array_agg(distinct (QUOTE_LITERAL(conversion_id))), ',') as conversion_id_str")->get()->toArray() : '';
        $conversion_id_str = isset($conversion_survey_res[0]['conversion_id_str']) ? $conversion_survey_res[0]['conversion_id_str'] : '';
        $this->data['conversions'] = $conversions = ($conversion_id_str) ? \App\Models\Transaction\LandConversionModel::whereRaw("id in ($conversion_id_str)")->where(['fl_archive' => 'N'])->with('getConversionSurveys')->orderBy('id', 'DESC')->get()->toArray() : '';

        //land inspection
        $inspection_details = ($survey_id_str) ? \App\Models\Transaction\InspectionModel::whereRaw("survey_id in ($survey_id_str)")->orderBy('id', 'DESC')->get()->toArray() : '';
        $this->data['inspection_details'] = $inspection_details;

        //land reservation
        $reservation_survey_res = ($survey_id_str) ? \App\Models\Transaction\LandReservationSurveyModel::whereRaw("survey_id in ($survey_id_str)")->selectRaw("array_to_string(array_agg(distinct (QUOTE_LITERAL(reservation_id))), ',') as reservation_id_str")->get()->toArray() : '';
        $reservation_id_str = isset($reservation_survey_res[0]['reservation_id_str']) ? $reservation_survey_res[0]['reservation_id_str'] : '';
        $this->data['reservations'] = $reservations = ($reservation_id_str) ? \App\Models\Transaction\LandReservationModel::whereRaw("id in ($reservation_id_str)")->where(['fl_archive' => 'N'])->with('getReservedSurveys')->orderBy('id', 'DESC')->get()->toArray() : '';

        //land reservation
        $mining_survey_res = ($survey_id_str) ? \App\Models\Transaction\MiningLeaseSurveyModel::whereRaw("survey_id in ($survey_id_str)")->selectRaw("array_to_string(array_agg(distinct (QUOTE_LITERAL(mining_lease_id))), ',') as mining_id_str")->get()->toArray() : '';
        $mining_id_str = isset($mining_survey_res[0]['mining_id_str']) ? $mining_survey_res[0]['mining_id_str'] : '';
        $this->data['minings'] = $minings = ($mining_id_str) ? \App\Models\Transaction\MiningLeaseModel::whereRaw("id in ($mining_id_str)")->where(['fl_archive' => 'N'])->with('getMiningSurveys')->orderBy('id', 'DESC')->get()->toArray() : '';

        //mutation
        $mutation_survey_res = ($survey_id_str) ? \App\Models\Transaction\MutationSurveyModel::whereRaw("survey_id in ($survey_id_str)")->selectRaw("array_to_string(array_agg(distinct (QUOTE_LITERAL(mutation_id))), ',') as mutation_id_str")->get()->toArray() : '';
        $mutation_id_str = isset($mutation_survey_res[0]['mutation_id_str']) ? $mutation_survey_res[0]['mutation_id_str'] : '';
        $this->data['mutations'] = $mutations = ($mutation_id_str) ? \App\Models\Transaction\MutationModel::whereRaw("id in ($mutation_id_str)")->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray() : '';
//t($mutations, 1);
        //disputes
        $dispute_survey_res = ($survey_id_str) ? \App\Models\Transaction\DisputesSurveyModel::whereRaw("survey_id in ($survey_id_str)")->selectRaw("array_to_string(array_agg(distinct (QUOTE_LITERAL(disputes_id))), ',') as dispute_id_str")->get()->toArray() : '';
        $dispute_id_str = isset($dispute_survey_res[0]['dispute_id_str']) ? $dispute_survey_res[0]['dispute_id_str'] : '';
        $this->data['disputes'] = $disputes = ($dispute_id_str) ? \App\Models\Transaction\DisputesModel::whereRaw("id in ($dispute_id_str)")->where(['fl_archive' => 'N'])->orderBy('id', 'DESC')->get()->toArray() : '';

        //t($disputes,1);
        //under opertion
        $operation_details = ($survey_id_str) ? \App\Models\Transaction\UnderOperationModel::whereRaw("survey_id in ($survey_id_str)")->orderBy('id', 'DESC')->get()->toArray() : '';
        $this->data['operation_details'] = $operation_details;
        // t($operation_details, 1);
        return view('admin.LandEntryManagement.Registration.transaction-details', $this->data);
    }

    public function AuditDetails() {
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Audit Details</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction';
        $this->data['section'] = 'audit';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Registration.listscript';

        //Audit Master data Description
        $masterData = AuditMasterModel::where(['fl_archive' => 'N'])->orderBy('sort_order', 'asc')->get()->toArray();
        $this->data['masterData'] = $masterData;


        $reg_uniq_no = $this->data['reg_uniq_no'];
        $audit_status_reg = AuditStatusRegModel::where(['reg_id' => $reg_uniq_no])->get()->toArray();
        if ($audit_status_reg) {
            $audit_status_data = AuditStatusDataModel::where(['audit_reg_id' => $audit_status_reg[0]['id']])->get()->toArray();
            foreach ($audit_status_data as $key => $val) {
                $final_audit_status_data[$val['audit_id']] = $val;
            }

            $audit_status_reg['data'] = $final_audit_status_data;
        }
        $this->data['audit_data'] = $audit_status_reg;

        $this->data['dataPresent'] = '';
        return view('admin.LandEntryManagement.Registration.audit-details', $this->data);
    }

    public function ConvertedRegistrationDetails() {

        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Converted Details</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction';
        $this->data['section'] = 'converted';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.LandEntryManagement.Registration.listscript';

        //Audit Master data Description
        $masterData = AuditMasterModel::where(['fl_archive' => 'N'])->orderBy('sort_order', 'asc')->get()->toArray();
        $this->data['masterData'] = $masterData;


        $reg_uniq_no = $this->data['reg_uniq_no'];
        $audit_status_reg = AuditStatusRegModel::where(['reg_id' => $reg_uniq_no])->get()->toArray();
        if ($audit_status_reg) {
            $audit_status_data = AuditStatusDataModel::where(['audit_reg_id' => $audit_status_reg[0]['id']])->get()->toArray();
            foreach ($audit_status_data as $key => $val) {
                $final_audit_status_data[$val['audit_id']] = $val;
            }

            $audit_status_reg['data'] = $final_audit_status_data;
        }
        $this->data['audit_data'] = $audit_status_reg;


        $reg_info = ($reg_uniq_no) ? RegistrationModel::find($reg_uniq_no)->toArray() : '';

        if ($reg_info['con_parent'] == 'Y') {
            $RegId = $reg_info['con_reg_id'];
            $requiredDataArray = ($RegId) ? RegistrationModel::where(['con_parent' => 'C', 'id' => $RegId])->get()->toArray() : '';
        } elseif ($reg_info['con_parent'] == 'C') {
            $RegId = $reg_info['id'];
            $requiredDataArray = ($RegId) ? RegistrationModel::where(['con_parent' => 'Y', 'con_reg_id' => $RegId])->get()->toArray() : '';
        } else {
            return redirect('land-details-entry/registration/add');
        }
        //t($requiredDataArray,1);
        $this->data['converted_data'] = $requiredDataArray;
        $this->data['current_registration_data'] = isset($reg_info) ? $reg_info : '';

        $this->data['dataPresent'] = '';
        return view('admin.LandEntryManagement.Registration.converted-details', $this->data);
    }

    public function populateTransactionDetails(Request $request) {
        //echo 'szdfcsadf';
        $posted_data = $request->all();
        $trxn_id = isset($posted_data['trxn_id']) ? $posted_data['trxn_id'] : '';
        $trxn_type = isset($posted_data['trxn_type']) ? $posted_data['trxn_type'] : '';
        $this->data['trxn_id'] = $trxn_id;
        if ($trxn_id && $trxn_type) {
            switch ($trxn_type) {
                case 'ceiling':
                    $ceiling_details = \App\Models\Transaction\LandCeilingSurveyModel::where(['ceiling_id' => $trxn_id])->get()->toArray();
                    $this->data['ceiling_details'] = $ceiling_details;
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.ceiling', $this->data)->render();
                    break;
                case 'conversion':
                    $conversion_details = \App\Models\Transaction\LandConversionSurveyModel::where(['conversion_id' => $trxn_id])->get()->toArray();
                    $this->data['conversion_details'] = $conversion_details;
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.conversion', $this->data)->render();
                    break;
                case 'exchange':
                    $exchange_details = \App\Models\Transaction\LandExchangeSurveyModel::where(['land_exchange_id' => $trxn_id])->get()->toArray();
                    $this->data['exchange_details'] = $exchange_details;
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.exchange', $this->data)->render();
                    break;
                case 'reservation':
                    $reservation_details = \App\Models\Transaction\LandReservationSurveyModel::where(['reservation_id' => $trxn_id])->get()->toArray();
                    $this->data['reservation_details'] = $reservation_details;
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.reservation', $this->data)->render();
                    break;
                case 'inspection':
                    $inspection_details = \App\Models\Transaction\InspectionModel::where(['id' => $trxn_id])->get()->toArray();
                    $this->data['inspection_details'] = isset($inspection_details[0]) ? $inspection_details[0] : '';
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.inspection', $this->data)->render();
                    break;
                case 'mining':
                    $mining_details = \App\Models\Transaction\MiningLeaseSurveyModel::where(['mining_lease_id' => $trxn_id])->get()->toArray();
                    $this->data['mining_details'] = $mining_details;
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.mining', $this->data)->render();
                    break;
                case 'mutation':
                    $mutation_details = \App\Models\Transaction\MutationSurveyModel::where(['mutation_id' => $trxn_id])->get()->toArray();
                    $this->data['mutation_details'] = $mutation_details;
                    // t($mutation_details,1);
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.mutation', $this->data)->render();
                    break;
                case 'operation':
                    $operation_details = \App\Models\Transaction\UnderOperationModel::where(['id' => $trxn_id])->get()->toArray();
                    $this->data['operation_details'] = isset($operation_details[0]) ? $operation_details[0] : '';
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.operation', $this->data)->render();
                    break;
                case 'conversion-parent':
                    $conversion_parent_details = \App\Models\Transaction\ConvertedRegistrationModel::where(['old_reg_id' => $trxn_id])->get()->toArray();
                    // $data['']
                    // t($conversion_parent_details, 1);
                    $this->data['conversion_parent_details'] = isset($conversion_parent_details[0]) ? $conversion_parent_details[0] : '';
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.conversion_parent', $this->data)->render();
                    break;

                case 'disputes':
                    $disputes_details = \App\Models\Transaction\DisputesSurveyModel::where(['disputes_id' => $trxn_id])->get()->toArray();
                    $this->data['disputes_details'] = $disputes_details;
                    echo view('admin.LandEntryManagement.TransactionDetailsViews.disputes', $this->data)->render();
                    break;
                default :
                    break;
            }
        }
    }

    public function populateMultipleDocs(Request $request) {
        $posted_data = $request->all();
        $trxn_id = isset($posted_data['trxn_id']) ? $posted_data['trxn_id'] : '';
        $multiple_docs = \App\Models\Transaction\MultipleDocsModel::where(['reference_id' => $trxn_id])->get()->toArray();
        $this->data['multiple_docs'] = $multiple_docs;
        echo view('admin.LandEntryManagement.TransactionDetailsViews.multiple_docs', $this->data)->render();
    }

    private function hasPermission($permission_name) {
        $user_obj = new \App\Models\User\UserModel();
        if ($user_obj->ifHasPermission($permission_name, $this->data['current_user_id'])) {
            return true;
        } else {
            return false;
        }
    }
 public function regauditView(Request $request)
 {
	 $posted_data = $request->all();
	 $reg_id = $posted_data['id'];
	 $table = $posted_data['table'];
	 $sql = " SELECT * FROM audit.logged_actions where row_data->'id' = '$reg_id' and table_name='$table'";
	 $results = DB::select( DB::raw($sql));
	
		
	//t($results,1);
	 $registration_comments =  DB::select("select cols.column_name,(select pg_catalog.obj_description(oid) from pg_catalog.pg_class c where c.relname=cols.table_name) as table_comment,(select pg_catalog.col_description(oid,cols.ordinal_position::int) from pg_catalog.pg_class c where c.relname=cols.table_name) as column_comment from information_schema.columns cols where  cols.table_name='$table'");
		//t($registration_comments,1);
		$state = DB::table('STATE')->get(); 
		$BLOCK = DB::table('BLOCK')->get();
		$DISTRICT = DB::table('DISTRICT')->get();
		$VILLAGE = DB::table('VILLAGE')->get();
		$USER = \App\Models\User\UserModel::get();
		$ROLES = DB::table('ROLES')->get();
		$FAMILY = DB::table('FAMILY')->get();
		
		$commonkeylist = array();
		foreach($registration_comments as $regComments)
		{
			$commonkeylist[$regComments->column_comment] = $regComments->column_name;
		}
		
		foreach($state as $states)
		{
			$commonkeylist[$states->state_name] = $states->id;
		}
		foreach($BLOCK as $BLOCKS)
		{
			$commonkeylist[$BLOCKS->block_name] = $BLOCKS->id;
		}
		foreach($DISTRICT as $DISTRICTS)
		{
			$commonkeylist[$DISTRICTS->district_name] = $DISTRICTS->id;
		}
		foreach($VILLAGE as $VILLAGE)
		{
			$commonkeylist[$VILLAGE->village_name] = $VILLAGE->id;
		}
		foreach($USER as $USERS)
		{
			$commonkeylist[$USERS->user_name] = $USERS->id;
		}
		foreach($ROLES as $ROLES)
		{
			$commonkeylist[$ROLES->name] = $ROLES->id;
		}
		foreach($FAMILY as $FAMILYS)
		{
			$commonkeylist[$FAMILYS->member_name] = $FAMILYS->member_name;
		}
		
	 $html = '<table id="registration_lists_table2" class="table table-striped table-bordered" cellspacing="0" width="100%" style="background-color:white;">
				<thead>
				  <tr>
					<th>Sl. No.</th>
					<th>Module</th>
															   
					<th>Original Field</th>
					<th>Changed Fields</th>                                          
					<th>Action Taken</th>
					<th>Action Taken By</th>
					<th>Action Taken At</th>
					<th>IP Address</th>

                </tr>
            </thead>
            <tbody>';
	 foreach($results as $k=>$infos)
	 {
		 
		    $rawData = $infos->row_data;
			$rawData =  (str_replace('"=>"', '":"', $rawData) );
			$rawData =  ('{' . str_replace('=>', ':', $rawData) . '}');
			$rawData =  (str_replace('NULL', 'null', $rawData));
			$result_arr = json_decode($rawData,1);
			$upd_arr = array();	
		    $ne_arr = array();
			$module ='';
		    $submodule =''; 
			$projectId='';
			
			//update 
			$updateData = $infos->changed_fields;
			$updateData =  (str_replace('"=>"', '":"', $updateData) );
			$updateData =  ('{' . str_replace('=>', ':', $updateData) . '}');
			$updateData =  (str_replace('NULL', 'null', $updateData));
			$Updateresult_arr = json_decode($updateData,1);
			
			
		//t($commonkeylist,1);	
		$table_name = isset($infos->table_name)?str_replace('T_','',$infos->table_name):'';
				 $html .='<tr>
					<td>'.($k+1).'</td>
					<td>'.$table_name.'</td>
					<td>';
					foreach($result_arr as $kk=>$detls){
					 if(isset($detls) && $detls!=''){ 
					 $html .='<button type="button" class="btn btn-xs btn-outline btn-secondary mb-4">
						<span style="font-size: 14px;font-weight: 900;">';
						 if(array_search($kk,$commonkeylist)){ 
						$html .= array_search($kk,$commonkeylist);
						} else { 
						$html .=  $kk;
						} 
						
						$html .='</span>:';
						 if(array_search($detls,$commonkeylist)){ 
							$html .= array_search($detls,$commonkeylist);
						} else { $html .= $detls;} 
						
					  $html .='</button>';
					 }
					}
					$html .='</td>
					<td>';
					foreach($Updateresult_arr as $kku=>$updt){
					 if(isset($updt) && $updt!=''){
					 $html .=' <button type="button" class="btn btn-xs btn-outline btn-secondary mb-4">
						<span style="font-size: 14px;font-weight: 900;">';
						 if(array_search($kku,$commonkeylist)){ 
							$html .= array_search($kku,$commonkeylist);
						} else { $html .=  $kku;} 
						
						
						$html .='</span>:';
						 if(array_search($updt,$commonkeylist)){ 
							$html .= array_search($updt,$commonkeylist);
						} else { $html .= $updt;} 
						
						$html .='</button>';
					 }
					}
					$html .='</td>
				   
					<td>';
						
						if(isset($infos->action) && $infos->action == 'I'){
							$html .= 'Add';
						}
						 if ($infos->action &&  $infos->action == 'U'){
							$html .= "Update";
						}
					$html .='</td>
					<td>';
					
					 if(array_search($infos->session_user_name,$commonkeylist)){ 
							$html .= array_search($infos->session_user_name,$commonkeylist);
						} else if($infos->session_user_name!='') { $html .= $infos->session_user_name;}
					else
					{
						$html .= 'System';
					}	
					$html .='</td>
					<td>'.date('d/m/Y H:i:A',strtotime($infos->action_tstamp_tx)).'</td>
					 <td>'.$infos->client_addr.'</td>
				</tr>'; 
	 }
	 $html .='</tbody></table>';
	 echo $html;
 }
}
