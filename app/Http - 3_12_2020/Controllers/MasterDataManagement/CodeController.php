<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MasterDataManagement;

/**
 * Description of CodeController
 *
 * @author user-98-pc
 */
use App\Http\Controllers\Controller;
use App\Models\Common\CodeModel;
use App\Models\Common\ConversionModel;
use App\Http\Controllers\Auth\AuthController;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;
use Session;

class CodeController extends Controller {

    //put your code here

    protected $validationRules = [
        'code.cd_desc' => 'required',
            // 'convers.convers_value' => 'required',
    ];

    //put your code here
    public function __construct() {
        parent:: __construct();

        $this->data['include_script_view'] = 'admin.MasterDataManagement.script';
        $this->data['data']['cssArr'] = [];
        //$this->data['data']['jsArr'] = [];
        $this->data['pageHeading'] = 'Master Code Management';
        $this->data['title'] = 'Dalmia-lams::State';

        $cdList = CodeModel::groupBy('cd_type')->orderBy('cd_type')->lists('cd_type', 'cd_type')->toArray();
        $this->data['cdList'] = array_map("self::array_value_replace", $cdList);

        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    public static function array_value_replace($value) {

        return ucwords(str_replace('_', ' ', $value));
    }

    /**
     * 
     * @return type
     */
    public function add($codeType = null) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';

        $this->codeList(null, null, false);
        if (Session::has('data'))
            $data = Session::get('data');
        if ($this->user_type !== 'admin') {
            if (!$this->hasPermission($data, $this->data['current_user_id'])) {
                return redirect('unauthorized-access');
            }
        }
        $data = ucwords(str_replace('_', ' ', $data));
        $this->data['pageHeading'] = "Master data <span class='text-danger' > $data Add</span>";

        return view('admin.MasterDataManagement.codeForm', $this->data);
    }

    /**
     * 
     * @return type
     */
    public function edit($id) {

        if (!$id) {
            return 'id is missing';
        }
        $this->data['title'] = 'Dalmia-lams::Code-Edit';
        $this->data['pageHeading'] = 'Master Code <span class="text-danger" >Edit</span>';

        $this->data['id'] = $id;
        $this->data['codeDetails'] = $codeDetails = CodeModel::find($id);
        if ($this->user_type !== 'admin') {
            if (!$this->hasPermission($codeDetails->cd_type, $this->data['current_user_id'])) {
                return redirect('unauthorized-access');
            }
        }
        $this->codeList(['cd_type' => "$codeDetails->cd_type"], null, false);
//        t( $this->data['codeDetails'],1);
        return view('admin.MasterDataManagement.codeForm', $this->data);
    }

    public function codeList($cond = null, $codeType = null, $option = true) {
        if ($this->user_type !== 'admin') {
            if (!$this->hasPermission($codeType, $this->data['current_user_id'])) {
                return redirect('unauthorized-access');
            }
        }
        if ($cond != 'null' && !empty($cond)) {

            $code = CodeModel::where($cond)->orderBy('cd_desc', 'ASC')->get();
        } else if ($codeType != 'null' && !empty($codeType)) {

            $code = CodeModel::where(['cd_type' => "$codeType"])->orderBy('cd_desc', 'ASC')->get();
        } else {
            $code = CodeModel::orderBy('cd_desc', 'ASC')->get();
        }

        $this->data['title'] = 'Dalmia-lams::Code-List';
        if (Session::has('data'))
            $data = Session::get('data');
        $data = ucwords(str_replace('_', ' ', $data));
        $this->data['pageHeading'] = "Master Data <span class='text-danger' > $data </span>";

        // $this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
       // $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['codeList'] = $code;
//        t($code, 1);
        if ($option) {
//              t($this->data['data']['jsArr'],1);
            return view('admin.MasterDataManagement.code', $this->data);
        } else
            return $code;
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_code_data = isset($posted_data['code']) ? $posted_data['code'] : '';
        $code_type = isset($posted_code_data['cd_type']) ? $posted_code_data['cd_type'] : '';
        if ($this->user_type !== 'admin') {
           
            if (!$this->hasPermission($code_type, $this->data['current_user_id'])) {
                return redirect('unauthorized-access');
            }
        }
        $posted_convers_data = isset($posted_data['convers']) ? $posted_data['convers'] : '';
        //t($posted_data, 1);
        //die("i am here");
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';

        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return redirect('master/code/management')
                            ->withErrors($validator, 'codeError')
                            ->withInput();
        }
        if (Session::has('data'))
            $data = Session::get('data');

        if ($id) {
            $data_to_update = $posted_code_data;
            $converse_data_to_update = $posted_convers_data;
            //$data_to_insert['updated_id'] = Carbon::now();

            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['cd_upd_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $updated = CodeModel::where('id', $id)->update($data_to_update);
            if ($data == 'area_unit')
                $converse_updated = ConversionModel::where('code_id', $id)->update($converse_data_to_update);

            if ($updated) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Master data saved successfully!</strong></div>';
                return redirect('master/code/management/null/' . $data)->with('message', $msg);
            }
        } else {
            $data_to_insert = $posted_code_data;
            $convers_data_to_insert = $posted_convers_data;
            $codeModel = new CodeModel;

            $codeModel->setRawAttributes($data_to_insert);
            $codeModel->created_at = Carbon::now();
            //$codeModel->updated_at = Carbon::now();
            $codeModel->cd_crt_id = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $codeModel->insert_role_id = ($this->role_id) ? $this->role_id : 'admin';
            $codeModel->save();

            if ($data == 'area_unit') {
                $converseModel = new ConversionModel;
                $converseModel->setRawAttributes($convers_data_to_insert);
                $converseModel->created_at = Carbon::now();
                $converseModel->updated_at = Carbon::now();
                $codeModel->getConvers()->save($converseModel);
            }
            if ($codeModel->id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Master data saved successfully!</strong></div>';
                return redirect('master/code/management/null/' . $data)->with('message', $msg);
            }
        }
    }

    private function hasPermission($permission_name, $current_user_id) {

        switch ($permission_name) {
            case 'area_unit':

                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_area_unit_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'CD00282': //city
                if (!(\App\Models\UtilityModel::ifHasPermission('master_city_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'CD00146': //district
                if (!(\App\Models\UtilityModel::ifHasPermission('master_district_access', $current_user_id))) {
                    return false;
                }
                break;

            case 'document_type':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_document_type_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'encroachment_type':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_encroachment_type_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'land_usage':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_land_usage_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'land_usage':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_land_usage_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'legal_entity':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_legal_entity_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'litigation_type':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_litigation_type_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'operation':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_operation_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'payment_mode':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_payment_mode_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'payment_type':
                if ((\App\Models\UtilityModel::ifHasPermission('master_data_payment_type_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'plot_classification':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_plot_classification_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'plot_type':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_plot_type_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'purchase_type':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_purchase_type_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'purchaser_name':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_purchaser_name_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'purchasing_team':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_purchasing_team_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'CD00154': //State
                if (!(\App\Models\UtilityModel::ifHasPermission('master_state_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'CD00281': // Sub Classification
                if (!(\App\Models\UtilityModel::ifHasPermission('master_sub_classification_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'sub_registrar_office':
                if (!(\App\Models\UtilityModel::ifHasPermission('master_data_sub_registrar_office_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'CD00153': //Tehsil
                if (!(\App\Models\UtilityModel::ifHasPermission('master_tehsil_access', $current_user_id))) {
                    return false;
                }
                break;
            case 'CD00155': //Village
                if (!(\App\Models\UtilityModel::ifHasPermission('master_village_access', $current_user_id))) {
                    return false;
                }
                break;
            default:
                return true;
        }
        return true;
    }

}
