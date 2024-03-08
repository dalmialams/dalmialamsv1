<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\LandReservationSurveyModel;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\Transaction\LandReservationModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\LandDetailsManagement\DocumentModel;
use App\Models\Transaction\HypotheticationModel;
use App\Models\Transaction\HypotheticationRegistrationModel;
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
class HypothecationController extends Controller {

    //put your code here

    protected $validationRules = [
        'hypothecate.hyp_name' => 'required',
        'hypothecate.trxn_type' => 'required',
        'hypothecate.reg_no' => 'required',
        'hypothecate.hyp_with' => 'required',
        'hypothecate.hyp_date' => 'required',
        'hypothecate.value' => 'required|numeric',
    ];
    protected $field_names = [
        'hypothecate.hyp_name' => 'Hypothecate Name',
        'hypothecate.trxn_type' => 'Transaction Type',
        'hypothecate.reg_no' => 'Registration No.',
        'hypothecate.hyp_with' => 'Hypothecate With',
        'hypothecate.hyp_date' => 'Date',
        'hypothecate.value' => 'Value',
    ];

    public function __construct() {
        parent:: __construct();

        $this->allowed_types = [ 'pdf', 'mp4'];
        $this->upload_dir = 'assets\uploads\Hypothecation';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Transaction-Hypothecation';
        $this->data['states'] = $this->getAllStates();
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        $this->data['hypothecate_name'] = $this->getCodesDetails('hypothecate_name');
        $this->data['hypothecate_with'] = $this->getCodesDetails('hypothecate_with');
        //  $this->data['patta_list'] = $this->getAllPatta();
        $this->data['include_script_view'] = 'admin.Transaction.Hypothecation.script';
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

        $this->data['pageHeading'] = 'Hypothecation <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-Hypothecation-Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        //Get the survey lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        //LandReservation Lists
        $res = HypotheticationModel::where(['fl_archive' => 'N'])->get()->toArray();

        // t($res,1);
        $this->data['hypothetication_lists'] = $res;
        $this->data['id'] = '';
        $this->data['type'] = [
            '' => 'Select',
            'Y' => 'Hypothicate',
            'N' => 'Release',
        ];
        return view('admin.Transaction.Hypothecation.add', $this->data);
    }

    public function edit(Request $request, $id = null) {

        if (!$id) {
            return redirect('transaction/hypothecation/add');
        } else {
            //t($this->assgined_districts, 1);
            $exists = HypotheticationModel::where(['id' => $id])->get()->toArray();
            if ($this->user_type == 'admin') {
                if (empty($exists)) {
                    return redirect('transaction/hypothecation/add');
                }
            } else {
                if (empty($exists)) {
                    return redirect('unauthorized-access');
                }
            }
        }

        $this->data['pageHeading'] = (!$id) ? 'Hypothecation <span class="text-danger" >Add</span>' : 'Hypothecation (' . $id . ') <span class="text-danger" >Edit</span>';
        $this->data['title'] = 'Dalmia-lams::Transaction-Hypothecation-Add';
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

        //LandReservation Lists

        $res = HypotheticationModel::where(['fl_archive' => 'N'])->get()->toArray();

        // t($res,1);
        $this->data['hypothetication_lists'] = $res;
        $this->data['id'] = $id;
        $this->data['type'] = [
            '' => 'Select',
            'Y' => 'Hypothicate',
            'N' => 'Release', //In Hypothecation table release is trxn_type = N
        ];

        //LandReservation Edit
        // $land_reservation_no = $request->input('land_reservation_no');
        $this->data['id'] = $id;
        if ($id) {
            $reserved_survey_ids = [];

            $hypothecate_data = HypotheticationModel::where(['id' => $id])->get()->toArray();
            $trxn_type = $hypothecate_data[0]['trxn_type'];
            $trxn_type = ($trxn_type == 'N') ? 'Y' : 'N';
            $this->data['for_check_hypo_rele_doc'] = $trxn_type;
            $this->data['hypothecate_data_data'] = isset($hypothecate_data[0]) ? $hypothecate_data[0] : '';

            if ($hypothecate_data) {
                $related_registration_ids = HypotheticationRegistrationModel::where(['hypothecate_id' => $hypothecate_data[0]['id'], 'fl_archive' => 'N'])->lists('registration_id', 'registration_id')->toArray();
                $related_registration_ids = isset($related_registration_ids) ? $related_registration_ids : '';
                $this->data['related_registration_ids'] = $related_registration_ids;

                $RegistrationIds = isset($related_registration_ids) ? "'" . implode("','", $related_registration_ids) . "'" : '1';
                $allRegistrationData = DocumentModel::whereRaw("registration_id in ($RegistrationIds)")->get()->toArray();
                $this->data['allRegistrationData'] = isset($allRegistrationData) ? $allRegistrationData : '';
            }
        }


        return view('admin.Transaction.Hypothecation.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data, 1);

        $registration_id = isset($posted_data['registration_id']) ? $posted_data['registration_id'] : '';
        $posted_hypothecate_data = isset($posted_data['hypothecate']) ? $posted_data['hypothecate'] : '';
        $posted_payment_docs = isset($posted_hypothecate_data['docs']) ? implode(',', $posted_hypothecate_data['docs']) : '';
        $submitedDocs = isset($posted_hypothecate_data['docs']) ? $posted_hypothecate_data['docs'] : '';


        unset($posted_hypothecate_data['docs']);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);

        //Upload doc file
        $doc_file = isset($posted_data['doc_file']) ? $posted_data['doc_file'] : '';
        if (!empty($doc_file)) {
            $file_name = $doc_file->getClientOriginalName();
            $file_name = stristr($file_name, '.', true);
            $ext = $doc_file->getClientOriginalExtension();
            $new_file_name = $file_name . '_' . time() . '.' . $ext;
            $file_path = $this->upload_dir . '/' . $new_file_name;
            if (in_array($ext, $this->allowed_types)) {
                $upload = UtilityModel::uploadFile($doc_file, $this->upload_dir, $new_file_name);
            } else {
                //  $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
                $msg = UtilityModel::getMessage('This type of files are not allowed!', 'error');
                if ($id) {
                    return redirect('transaction/hypothecation/add')->with('message', $msg)->withInput();
                } else {
                    return redirect('transaction/hypothecation/add')->with('message', $msg)->withInput();
                }
            }
        }


        if ($id) {

            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('hypothecation_edit')) {
                    return redirect('unauthorized-access');
                }
            }

            $data_to_update['payment_docs'] = $posted_payment_docs ? $posted_payment_docs : '';
            $data_to_update['description'] = $posted_hypothecate_data['description'] ? $posted_hypothecate_data['description'] : '';
            if (!empty($doc_file)) {
                $data_to_update['path'] = $file_path;
                $data_to_update['file_type'] = $ext;
            }
            $data_to_update['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $update = HypotheticationModel::where(['id' => $id])->update($data_to_update);

            //Change the status of Document table for Hypothecation
            $date_of_hyp_date = isset($posted_hypothecate_data['hyp_date']) ? $posted_hypothecate_data['hyp_date'] : '';
            if ($date_of_hyp_date) {
                $date_of_hyp_date = str_replace("/", "-", $date_of_hyp_date);
                $date_of_hyp_date = new \DateTime($date_of_hyp_date);
                $date_of_hyp_date = $date_of_hyp_date->format('Y-m-d');
            }
            if ($submitedDocs) {
                foreach ($submitedDocs as $dockey => $docvalue) {
                    $document_data_uptate['hypothecate_status'] = $posted_hypothecate_data['trxn_type'];
                    $document_data_uptate['hypothecate_date'] = $date_of_hyp_date;
                    DocumentModel::where(['id' => $docvalue])->update($document_data_uptate);
                }
            }

            $msg = UtilityModel::getMessage('Hypothecation data updated successfully!');
            return redirect('transaction/hypothecation/edit/' . $id)->with('message', $msg);
        } else {

            if ($this->user_type !== 'admin') {
                if (!$this->hasPermission('hypothecation_add')) {
                    return redirect('unauthorized-access');
                }
            }

            $data_to_insert = $posted_hypothecate_data;
            $date_of_hyp_date = isset($data_to_insert['hyp_date']) ? $data_to_insert['hyp_date'] : '';
            if ($date_of_hyp_date) {
                $date_of_hyp_date = str_replace("/", "-", $date_of_hyp_date);
                $date_of_hyp_date = new \DateTime($date_of_hyp_date);
                $date_of_hyp_date = $date_of_hyp_date->format('Y-m-d');
            }
            $data_to_insert['hyp_date'] = $date_of_hyp_date;
            $data_to_insert['payment_docs'] = $posted_payment_docs ? $posted_payment_docs : '';
            if (!empty($doc_file)) {
                $data_to_insert['path'] = $file_path;
                $data_to_insert['file_type'] = $ext;
            }
            $data_to_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //t($data_to_insert);
            $insert_id = HypotheticationModel::insertGetId($data_to_insert);
            $msg = UtilityModel::getMessage('Hypothecation data saved successfully!');
            if ($insert_id) {

                if ($registration_id) {
                    foreach ($registration_id as $key => $value) {
                        $hypo_reg_data_insert['hypothecate_id'] = $insert_id;
                        $hypo_reg_data_insert['registration_id'] = $value;
                        $hypo_reg_data_insert['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $hypo_reg_data_insert['created_at'] = Carbon::now();
                        $hypo_reg_data_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        HypotheticationRegistrationModel::insertGetId($hypo_reg_data_insert);

                        //Change the status of Registration table for Hypothecation
                        $reg_data_uptate['hypothecate_status'] = ($data_to_insert['trxn_type'] == 'N') ? 'R' : $data_to_insert['trxn_type'];
                        $reg_data_uptate['hypothecate_date'] = $date_of_hyp_date;
                        RegistrationModel::where(['id' => $value])->update($reg_data_uptate);
                    }
                }

                //Change the status of Document table for Hypothecation
                if ($submitedDocs) {
                    foreach ($submitedDocs as $dockey => $docvalue) {
                        $document_data_uptate['hypothecate_status'] = $data_to_insert['trxn_type'];
                        $document_data_uptate['hypothecate_date'] = $date_of_hyp_date;
                        DocumentModel::where(['id' => $docvalue])->update($document_data_uptate);
                    }
                }

                return redirect('transaction/hypothecation/add')->with('message', $msg);
            }
        }
    }

    public function addOrEditReservationSurveys($posted_data, $selected_surveys, $reservation_id, $path_arr, $ext_arr, $transaction_type, $mode) {
        if ($posted_data && $selected_surveys && $reservation_id) {
            $survey_data['reservation_id'] = $reservation_id;
            if ($selected_surveys) {
                foreach ($selected_surveys as $key => $value) {
                    if ($mode == 'add' && ($transaction_type == 'N' || $transaction_type == 'Y')) {
                        $existing_survey = LandReservationSurveyModel::where(['survey_id' => $value])->get()->toArray();
                        if (!empty($existing_survey)) {
                            $delete_survey = LandReservationSurveyModel::where(['survey_id' => $value])->delete();
                        }
                    }
                    $survey_data['survey_id'] = $value;
                    $survey_data['survey_no'] = isset($posted_data['survey_no'][$key]) ? $posted_data['survey_no'][$key] : '';
                    $survey_data['remarks'] = isset($posted_data['remarks'][$key]) ? $posted_data['remarks'][$key] : '';
                    $existing_survey = LandReservationSurveyModel::where(['survey_id' => $value])->get()->toArray();
                    $existing_file_path = isset($existing_survey[0]['file_path']) && !empty($existing_survey[0]['file_path']) ? $existing_survey[0]['file_path'] : '';
                    $existing_file_type = isset($existing_survey[0]['file_type']) && !empty($existing_survey[0]['file_type']) ? $existing_survey[0]['file_type'] : '';
                    //t($existing_survey);
                    if (empty($existing_survey)) {
                        $survey_data['file_path'] = isset($path_arr[$key]) ? $path_arr[$key] : '';
                        $survey_data['file_type'] = isset($ext_arr[$key]) ? $ext_arr[$key] : '';
                        $survey_data['created_at'] = Carbon::now();
                        $survey_data['crt_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $survey_data['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $insert_survey_id = LandReservationSurveyModel::insertGetId($survey_data);
                    } else {
                        $survey_data['file_path'] = isset($path_arr[$key]) && !empty($path_arr[$key]) ? $path_arr[$key] : $existing_file_path;
                        $survey_data['file_type'] = isset($ext_arr[$key]) && !empty($ext_arr[$key]) ? $ext_arr[$key] : $existing_file_type;
                        $survey_data['updated_at'] = Carbon::now();
                        $survey_data['upd_id'] = isset($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
                        $survey_data['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $update = LandReservationSurveyModel::where(['survey_id' => $value])->update($survey_data);
                    }
                    $update_land_reservation_status_in_survey_table = SurveyModel::where(['id' => $value])->update(['land_reservation_status' => $transaction_type]);
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
        if ($typeList == 'registration_id') {
            $village_id = $request->get('val');
            $this->data['label_name'] = $label_name = $request->get('label_name');
            $registrations = $this->populateRegistrationIds('ajax', $trxn_type, $from_mis, $village_id);
            $this->data['optionList'] = $optionList = $registrations;
            $this->data['onchange'] = $optionList = 'onchange=populateResistrationDetails($(this).val());';
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

    public function populateRegistrationIds($type = null, $trxn_type = 'N', $from_mis = null, $village_id=null) {
        $assgined_districts_str = UtilityModel::assignedDistricts($this->user_type, $this->assigned_states, $this->data['current_user_id']);
        if (!$from_mis) {
            if ($trxn_type == 'N') {
                $cuscond = " hypothecate_status in ('N','R')";
            } else {
                $cuscond = " hypothecate_status = 'Y'";
            }
        } else {
            $cuscond = " hypothecate_status = '$trxn_type'";
            if($village_id){
                $cuscond .= " and village_id = '$village_id'";
            }
        }
        if ($type == 'ajax') {
            if ($trxn_type) {
                if ($this->user_type == 'admin') {
                    $registration_list = RegistrationModel::whereRaw($cuscond)->orderBy('id')->select('id as option_code', 'id as option_desc')->get()->toArray();
                } else {
                    $registration_list = ($assgined_districts_str) ? RegistrationModel::whereRaw("district_id in ($assgined_districts_str)")->whereRaw($cuscond)->orderBy('id')->select('id as option_code', 'id as option_desc')->get()->toArray() : '';
                }
            } else {
                $registration_list = '';
            }
        }
        return $registration_list;
    }

    public function deleteReservationSurvey($survey_id, $reservation_id) {
        if ($survey_id && $reservation_id) {
            $delete = LandReservationSurveyModel::where(['survey_id' => $survey_id, 'reservation_id' => $reservation_id])->delete();
            $update_land_reservation_status_in_survey_table = SurveyModel::where(['id' => $survey_id])->update(['land_reservation_status' => 'N']);
        }
        $msg = UtilityModel::getMessage('Land Reservation data deleted successfully!');
        return redirect('transaction/land-reservation/add/' . $reservation_id)->with('message', $msg);
    }

    private function hasPermission($permission_name) {
        $user_obj = new \App\Models\User\UserModel();
        if ($user_obj->ifHasPermission($permission_name, $this->data['current_user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function registrationDetailsTable(Request $request) {

        $getRegistrationIds = $request->get('value');
        $RegistrationIds = isset($getRegistrationIds) ? "'" . implode("','", explode(',', $getRegistrationIds)) . "'" : '1';
        $allRegistrationData = RegistrationModel::whereRaw("id in ($RegistrationIds)")->get()->toArray();
        $this->data['allRegistrationData'] = $allRegistrationData;

        return view('admin.Transaction.Hypothecation.registrationDetailsTable', $this->data);
    }

    public function registrationDocumentDetailsTable(Request $request) {

        $getRegistrationIds = $request->get('value');
        $trxn_type = $request->get('trxn_type');
        $RegistrationIds = isset($getRegistrationIds) ? "'" . implode("','", explode(',', $getRegistrationIds)) . "'" : '1';
        $allRegistrationData = DocumentModel::whereRaw("registration_id in ($RegistrationIds)")->where(['hypothecate_status' => $trxn_type])->get()->toArray();
        $this->data['allRegistrationData'] = $allRegistrationData;

        return view('admin.Transaction.Hypothecation.registrationDocumentDetailsTable', $this->data);
    }

}
