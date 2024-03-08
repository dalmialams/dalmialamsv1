<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\Transaction\InspectionModel;
use App\Models\Transaction\MultipleDocsModel;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\Audit\AuditMasterModel;
use App\Models\Audit\AuditStatusDataModel;
use App\Models\Audit\AuditStatusRegModel;
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
class AuditController extends Controller {

    //put your code here

    protected $validationRules = [
        'auditstatusreg.reg_no' => 'required',
    ];
    protected $field_names = [
        'auditstatusreg.reg_no' => 'Registration No.',
    ];

    public function __construct() {
        parent:: __construct();

        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Transaction-Audit';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        $this->data['encroachment_type'] = $this->getCodesDetails('encroachment_type');
        $this->data['include_script_view'] = 'admin.Transaction.Audit.script';
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

        $this->data['pageHeading'] = 'Audit <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-Audit-Add';
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

        //Audit Master data Description
        $masterData = AuditMasterModel::where(['fl_archive' => 'N'])->orderBy('sort_order', 'asc')->get()->toArray();
        $this->data['masterData'] = $masterData;

        $assgined_districts = [];
        $reg_id_arr = '';
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
                $reg_id_arr = RegistrationModel::whereRaw("district_id in ($assgined_districts_str)")->orderBy('id')->lists('id', 'id')->toArray();
            }
        } else {
            $reg_id_arr = RegistrationModel::orderBy('id')->lists('id', 'id')->toArray();
        }

        //All Registration Ids

        $reg_id_arr = ($reg_id_arr) ? array_merge(array('' => 'Select'), $reg_id_arr) : [];
        $this->data['reg_id_arr'] = $reg_id_arr;

        $this->data['type'] = [
            '' => 'Select',
            'Y' => 'Yes',
            'N' => 'No',
        ];

        //Audit status Lists
        $res = AuditStatusRegModel::where(['fl_archive' => 'N'])->get()->toArray();
        $this->data['auditStatusLists'] = $res;

        $this->data['encroachment_info'] = [
            '' => 'Select',
            'Y' => 'Yes',
            'N' => 'No',
        ];

//        //Audit Edit
//        $id = $request->input('audit_uniq_no');
//        if ($id) {
//            $this->data['id'] = $id;
//            $audit_status_reg = AuditStatusRegModel::where(['id' => $id])->get()->toArray();
//            $audit_status_data = AuditStatusDataModel::where(['audit_reg_id' => $audit_status_reg[0]['id']])->get()->toArray();
//            foreach ($audit_status_data as $key => $val) {
//                $final_audit_status_data[$val['audit_id']] = $val;
//            }
//
//            $audit_status_reg['data'] = $final_audit_status_data;
//            $this->data['audit_data'] = $audit_status_reg;
//            //t($this->data['audit_data']);
//            $this->data['pageHeading'] = 'Audit <span class="text-danger" >Edit</span>';
//        }

        return view('admin.Transaction.Audit.add', $this->data);
    }

    public function edit(Request $request) {
        $this->data['pageHeading'] = 'Audit <span class="text-danger" >Edit</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-Audit-Add';
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

        //Audit Master data Description
        $masterData = AuditMasterModel::where(['fl_archive' => 'N'])->orderBy('sort_order', 'asc')->get()->toArray();
        $this->data['masterData'] = $masterData;

        $assgined_districts = [];
        $reg_id_arr = '';
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
                $reg_id_arr = RegistrationModel::whereRaw("district_id in ($assgined_districts_str)")->orderBy('id')->lists('id', 'id')->toArray();
            }
        } else {
            $reg_id_arr = RegistrationModel::orderBy('id')->lists('id', 'id')->toArray();
        }

        //All Registration Ids

        $reg_id_arr = ($reg_id_arr) ? array_merge(array('' => 'Select'), $reg_id_arr) : [];
        $this->data['reg_id_arr'] = $reg_id_arr;

        $this->data['type'] = [
            '' => 'Select',
            'Y' => 'Yes',
            'N' => 'No',
        ];

        //Audit status Lists
        $res = AuditStatusRegModel::where(['fl_archive' => 'N'])->get()->toArray();
        $this->data['auditStatusLists'] = $res;

        $this->data['encroachment_info'] = [
            '' => 'Select',
            'Y' => 'Yes',
            'N' => 'No',
        ];

        //Audit Edit
        $id = $request->input('audit_uniq_no');
        $final_audit_status_data=array();
        if ($id) {
            $this->data['id'] = $id;
            $audit_status_reg = AuditStatusRegModel::where(['id' => $id])->get()->toArray();
            $audit_status_data = AuditStatusDataModel::where(['audit_reg_id' => $audit_status_reg[0]['id']])->get()->toArray();
            foreach ($audit_status_data as $key => $val) {
                $final_audit_status_data[$val['audit_id']] = $val;
            }

            $audit_status_reg['data'] = $final_audit_status_data;
            $this->data['audit_data'] = $audit_status_reg;
            //t($this->data['audit_data']);
            $this->data['pageHeading'] = 'Audit <span class="text-danger" >Edit</span>';
        }

        return view('admin.Transaction.Audit.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data);die();
        $posted_inspection_reg = isset($posted_data['auditstatusreg']) ? $posted_data['auditstatusreg'] : '';
        $posted_inspection_data = isset($posted_data['auditstatus']) ? $posted_data['auditstatus'] : '';

        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);



        if ($id) {
            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('audit_status_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('transaction/audit/edit?audit_uniq_no=' . $id)
                                ->withErrors($validator, 'audit')
                                ->withInput();
            }
            $data_to_update = $posted_inspection_data;


            if ($data_to_update) {
                foreach ($data_to_update as $auditkey => $auditval) {

                    if (!empty($auditval['remarks']) || !empty($auditval['verified'])) {
                        $date_of_audit = isset($auditval['audit_date']) ? $auditval['audit_date'] : '';
                        if ($date_of_audit) {
                            $date_of_audit = str_replace("/", "-", $date_of_audit);
                            $date_of_audit = new \DateTime($date_of_audit);
                            $date_of_audit = $date_of_audit->format('Y-m-d');
                        }
                        $data_to_updateIn_audit_data['audit_reg_id'] = $id;
                        $data_to_updateIn_audit_data['remarks'] = $auditval['remarks'];
                        $data_to_updateIn_audit_data['verified'] = $auditval['verified'];
                        $data_to_updateIn_audit_data['audit_date'] = $date_of_audit;
                        $data_to_updateIn_audit_data['audit_id'] = $auditkey;
                        $data_to_updateIn_audit_data['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $data_to_updateIn_audit_data['created_at'] = Carbon::now();
                        $data_to_updateIn_audit_data['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $final_insert_id = AuditStatusDataModel::insertGetId($data_to_updateIn_audit_data);
                    }
                }
            } else {
                $msg = UtilityModel::getMessage('Audit data Already Added!', 'error');
                return redirect('transaction/audit/edit?audit_uniq_no=' . $id)->with('message', $msg);
            }

            if (isset($final_insert_id)) {
                $msg = UtilityModel::getMessage('Audit data updated successfully!');
                return redirect('transaction/audit/edit?audit_uniq_no=' . $id)->with('message', $msg);
            } else {
                $msg = UtilityModel::getMessage('Please input!', 'error');
                return redirect('transaction/audit/edit?audit_uniq_no=' . $id)->with('message', $msg);
            }
        } else {
            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('audit_status_add')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('transaction/audit/add')
                                ->withErrors($validator, 'audit')
                                ->withInput();
            }
            $data_to_insert = $posted_inspection_data;
            $data_to_insertIn_audit_reg['reg_id'] = $posted_inspection_reg['reg_no'];
            $data_to_insertIn_audit_reg['ip_address'] = $request->getClientIp();
            $data_to_insertIn_audit_reg['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insertIn_audit_reg['created_at'] = Carbon::now();
            $data_to_insertIn_audit_reg['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //t($data_to_insertIn_audit_reg);die('first');
            $insert_id = AuditStatusRegModel::insertGetId($data_to_insertIn_audit_reg);

            if ($insert_id) {
                if(!empty($data_to_insert)){
                foreach ($data_to_insert as $auditkey => $auditval) {

                    if (!empty($auditval['remarks']) || !empty($auditval['verified'])) {
                        $date_of_audit = isset($auditval['audit_date']) ? $auditval['audit_date'] : '';
                        if ($date_of_audit) {
                            $date_of_audit = str_replace("/", "-", $date_of_audit);
                            $date_of_audit = new \DateTime($date_of_audit);
                            $date_of_audit = $date_of_audit->format('Y-m-d');
                        }
                        $data_to_insertIn_audit_data['audit_reg_id'] = $insert_id;
                        $data_to_insertIn_audit_data['remarks'] = $auditval['remarks'];
                        $data_to_insertIn_audit_data['verified'] = $auditval['verified'];
                        $data_to_insertIn_audit_data['audit_date'] = $date_of_audit;
                        $data_to_insertIn_audit_data['audit_id'] = $auditkey;
                        $data_to_insertIn_audit_data['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $data_to_insertIn_audit_data['created_at'] = Carbon::now();
                        $data_to_insertIn_audit_data['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $final_insert_id = AuditStatusDataModel::insertGetId($data_to_insertIn_audit_data);
                    }
                }
            } else {
                $msg = UtilityModel::getMessage('Error Occured!');
                return redirect('transaction/audit/add')->with('error', $msg);
            }
            }


            //t($data_to_insert);die('akash');
            $msg = UtilityModel::getMessage('Audit data saved successfully!');
            if ($final_insert_id) {
                return redirect('transaction/audit/add')->with('message', $msg);
            }
        }
    }

    public function checkExists(Request $request) {
        $registration_id = $request->input('registration_id');
        if ($registration_id) {
            $audit_status_reg = AuditStatusRegModel::where(['reg_id' => $registration_id])->get()->toArray();
            if ($audit_status_reg) {
                return $audit_status_reg[0]['id'];
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function dropDown(Request $request, $option = true, $json = true) {
        $this->data['typeList'] = $typeList = $request->get('type');
        $this->data['namePrefix'] = $namePrefix = $request->get('namePrefix');
        $this->data['dropdown_type'] = $dropdown_type = $request->get('dropdown_type');
        $this->data['multiple'] = $multiple = $request->get('multiple');

        if ($typeList == 'reg_no') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $registrations = $this->getAllRegistrationNos($village_id, 'ajax');
            $this->data['optionList'] = $optionList = $registrations;
            $onchange = $request->get('onchange');
            $this->data['onchange'] = ($onchange) ? 'onchange=' . $onchange : "";
        }

        if ($option == 'true')
            return view('admin.Transaction.Audit.dropdown', $this->data);
        else {
            if ($json == 'true') {

                echo json_encode($optionList);
            } else {
                return $optionList;
            }
        }
    }

    public function getAllRegistrationNos($village_id = null, $type = null) {

        if ($village_id && $type == 'ajax') {
            $registration_list = RegistrationModel::where(['fl_archive' => 'N', 'village_id' => $village_id])->orderBy('id')->select('id as option_code', 'id as option_desc')->get()->toArray();
        }

        return $registration_list;
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
