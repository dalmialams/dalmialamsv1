<?php

/*
 * To forgot this license header, choose License Headers in Project Properties.
 * To forgot this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

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
use Excel;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class MisController extends Controller {

    //put your code here
    /**
     * 
     */
//    protected $validationRules = [
//        'password.user_name' => 'required',
//    ];
//    protected $field_names = [
//        'password.user_name' => 'User Name',
//    ];
//    protected $reset_pwd_validation_rules = [
//        'password.new_password' => 'required|alpha_dash',
//        'password.cnf_new_password' => 'required|same:password.new_password|alpha_dash',
//    ];
//    protected $reset_pwd_field_names = [
//        'password.new_password' => 'New Password',
//        'password.cnf_new_password' => 'Confirm New Password',
//    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Track-Management';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $this->data['states'] = $this->getAllStates();

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
        $this->data['survey_list'] = $this->getAllSurvey(null, null, null, true);
//        t($this->data['survey_list'],1);
    }

    public function registration(Request $request) {
        $this->data['title'] = 'Dalmia-lams::MIS';
        $this->data['pageHeading'] = 'MIS <span class="text-danger" >Search</span>';
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.mis.listscript';
//        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';

        //For Search Registration Lists
        $posted_data = $request->all();
        $cond = "1=1 AND fl_archive ='N' ";

        if ($posted_data) {

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
            $registrations = RegistrationModel::whereRaw($cond)->orderBy('id', 'ASC')->get()->toArray();
            $registratiion_ids = RegistrationModel::selectRaw("array_to_string(array_agg(distinct QUOTE_LITERAL(id)), ',') as id_str")->whereRaw($cond)->get()->toArray();
            //   t($registratiion_ids,1);
            $reg_id_str = isset($registratiion_ids[0]['id_str']) ? $registratiion_ids[0]['id_str'] : '1';
            $survey_number_details = SurveyModel::whereRaw("registration_id in ($reg_id_str)")->orderBy('registration_id', 'ASC')->orderBy('survey_no', 'ASC')->get()->toArray();
            // t($survey_number_details, 1);
            $document_details = DocumentModel::whereRaw("registration_id in ($reg_id_str)")->orderBy('registration_id', 'ASC')->get()->toArray();
            $payment_details = PaymentModel::whereRaw("registration_id in ($reg_id_str)")->orderBy('registration_id', 'ASC')->get()->toArray();
            $audit_reg_details = \App\Models\Audit\AuditStatusRegModel::where(['fl_archive' => 'N'])->whereRaw("reg_id in ($reg_id_str)")->orderBy('reg_id', 'ASC')->get()->toArray();
            //t($audit_reg_details,1);
            $this->data['registration'] = $registrations;
            //t($payment_details, 1);
            $reg_array = [
                [
                    'Reg No', 'Legal Entity',
                    'Purchase Type', 'Name of Purchaser', 'Purchasing Team', 'Plot Type',
                    'Doc Regn No', 'Regn Date', 'Sub Registrar Office', 'Name of Vendor', 'Purchased Area Unit', 'Purchased Area Value',
                    'Total Cost', 'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];
            if ($registrations) {
                foreach ($registrations as $key => $value) {

                    $legal_entity = \App\Models\Common\CodeModel::where(['id' => $value['legal_entity'], 'cd_type' => 'legal_entity'])->value('cd_desc');
                    $purchase_type = \App\Models\Common\CodeModel::where(['id' => $value['purchase_type_id'], 'cd_type' => 'purchase_type'])->value('cd_desc');
                    $purchaser_name = \App\Models\Common\CodeModel::where(['id' => $value['purchaser'], 'cd_type' => 'purchaser_name'])->value('cd_desc');
                    $purchasing_team = \App\Models\Common\CodeModel::where(['id' => $value['purchasing_team_id'], 'cd_type' => 'purchasing_team'])->value('cd_desc');
                    $plot_type = \App\Models\Common\CodeModel::where(['id' => $value['plot_type_id'], 'cd_type' => 'plot_type'])->value('cd_desc');
                    $sub_registrar_office = \App\Models\Common\CodeModel::where(['id' => $value['sub_registrar'], 'cd_type' => 'sub_registrar_office'])->value('cd_desc');
                    $sub_registrar_office = \App\Models\Common\CodeModel::where(['id' => $value['sub_registrar'], 'cd_type' => 'sub_registrar_office'])->value('cd_desc');
                    $purchased_area_unit = \App\Models\Common\CodeModel::where(['id' => $value['tot_area_unit'], 'cd_type' => 'area_unit'])->value('cd_desc');
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    $regn_date = ($value['regn_date']) ? date("d/m/Y", strtotime($value['regn_date'])) : '';
                    $reg_array[] = [
                        $value['id'], $legal_entity, $purchase_type, $purchaser_name, $purchasing_team, $plot_type, $value['regn_no'],
                        $regn_date, $sub_registrar_office, $value['vendor'], $purchased_area_unit, (double) $value['tot_area'], (double) $value['tot_cost'],
                        $state, $district, $block, $village
                    ];
                }
            }

            $survey_array = [
                [
                    'Reg No', 'Survey No', 'Extend Unit', 'Extend Value', 'Purchased Area', 'Purpose', 'Classification', 'Sub-Classification',
                    'Mutation Status', 'Encroachment', 'Land Reservation Status', 'Operation Status', 'Dispute Status', 'Mining Status',
                    'Land Ceiling Status', 'Land Conversion Status', 'Land Exchnage Status'
                ]
            ];

            if ($survey_number_details) {
                foreach ($survey_number_details as $key => $value) {
                    $extend_unit = \App\Models\Common\CodeModel::where(['id' => $value['area_unit'], 'cd_type' => 'area_unit'])->value('cd_desc');
                    $purpose = \App\Models\Common\CodeModel::where(['id' => $value['purpose'], 'cd_type' => 'land_usage'])->value('cd_desc');
                    $classification = \App\Models\Common\CodeModel::where(['id' => $value['classification'], 'cd_type' => 'land_usage'])->value('cd_desc');
                    $sub_classification = \App\Models\Common\SubClassificationModel::where(['id' => $value['sub_classification'], 'classification_id' => $value['classification']])->value('sub_name');
                    $mutation_status = ($value['mutation_status'] == 'Y') ? 'Mutated' : 'Not Mutated';
                    $encroachment = ($value['inspection_status'] == 'Y') ? 'Yes' : 'No';
                    $land_reservation_status = ($value['land_reservation_status'] == 'Y') ? 'Reserved' : 'Dereserved';
                    $operation_status = ($value['inspection_status'] == 'Y') ? 'Yes' : 'No';
                    $dispute_status = ($value['disputes_status'] == 'Y') ? 'Yes' : 'No';
                    //$mining_status = ($value['disputes_status'] == 'Y') ? 'Yes' : 'No';
                    if ($value['mining_applied_status'] == 'Y') {
                        $mining_status = 'Applied';
                    } else if ($value['mining_applied_status'] == 'O') {
                        $mining_status = 'Obtained';
                    } else {
                        $mining_status = 'Not Applied';
                    }
                    if ($value['land_ceiling_status'] == 'Y') {
                        $ceiling_status = '37-A Applied';
                    } else if ($value['land_ceiling_status'] == 'O') {
                        $ceiling_status = '37-A Obtained';
                    } else {
                        $ceiling_status = 'Not Applied';
                    }
                    if ($value['land_conversion_status'] == 'Y') {
                        $conversion_status = 'Applied';
                    } else if ($value['land_conversion_status'] == 'O') {
                        $conversion_status = 'Obtained';
                    } else {
                        $conversion_status = 'Not Applied';
                    }
                    $land_exchange_status = ($value['land_exchange_status'] == 'Y') ? 'Yes' : 'No';
                    $survey_array[] = [
                        $value['registration_id'], $value['survey_no'], $extend_unit, (double) $value['total_area'], (double) $value['purchased_area'], $purpose, $classification, $sub_classification,
                        $mutation_status, $encroachment, $land_reservation_status, $operation_status, $dispute_status, $mining_status, $ceiling_status, $conversion_status,
                        $land_exchange_status
                    ];
                }
            }

            $document_array = [
                [
                    'Reg No', 'Doc Type', 'Physical Location'
                ]
            ];

            if ($document_details) {
                foreach ($document_details as $key => $value) {
                    $doc_type = \App\Models\Common\CodeModel::where(['id' => $value['type'], 'cd_type' => 'document_type'])->value('cd_desc');
                    $document_array[] = [
                        $value['registration_id'], $doc_type, $value['physical_location']
                    ];
                }
            }

            $payment_array = [
                [
                    'Reg No', 'Payment Type', 'Mode', 'Amount', 'Ref No', 'Date', 'Bank', 'Remarks'
                ]
            ];

            if ($payment_details) {
                foreach ($payment_details as $key => $value) {
                    $payment_type = \App\Models\Common\CodeModel::where(['id' => $value['pay_type'], 'cd_type' => 'payment_type'])->value('cd_desc');
                    $payment_mode = \App\Models\Common\CodeModel::where(['id' => $value['pay_mode'], 'cd_type' => 'payment_mode'])->value('cd_desc');
                    $payment_array [] = [
                        $value['registration_id'], $payment_type, $payment_mode, (double) $value['amount'], $value['reference_no'], $value['pay_date'], $value['pay_bank'], $value['description']
                    ];
                }
            }

            $audit_array = [
                [
                    'Reg No', 'Description', 'Date', 'Verified', 'Remarks', 'Audited By'
                ]
            ];

            if ($audit_reg_details) {
                foreach ($audit_reg_details as $key => $value) {
                    $reg_no = $value['reg_id'];
                    $audit_status_details = \App\Models\Audit\AuditStatusDataModel::where(['audit_reg_id' => $value['id']])->get()->toArray();
                    // t($audit_status_details);

                    if ($audit_status_details) {
                        foreach ($audit_status_details as $a_key => $a_value) {
                            $description = \App\Models\Audit\AuditMasterModel::where(['id' => $a_value['audit_id']])->value('description');
                            $audit_date = date("d/m/Y", strtotime($a_value['audit_date']));
                            $verified = ($a_value['verified'] == 'Y') ? 'Yes' : 'No';
                            $user_email = \App\Models\User\UserModel::where(['id' => $a_value['crt_id']])->value('user_name');
                            $audit_array[] = [
                                $reg_no, $description, $audit_date, $verified, $a_value['remarks'], $user_email
                            ];
                        }
                    }
                }
            }
            // exit;
            //t($survey_array, 1);
            $file_name = 'MIS_' . date('d.m.Y');
            Excel::create($file_name, function($excel) use($reg_array, $survey_array, $document_array, $payment_array, $audit_array) {
                $excel->sheet('Registration', function($sheet) use($reg_array) {
                    $sheet->fromArray($reg_array, null, 'A1', false, false);
                    $total_rows = count($reg_array) + 1;
                    $sheet->cells('L1:L' . $total_rows, function($cells) {
                        $cells->setAlignment('right');
                    });
                    $sheet->cells('M1:M' . $total_rows, function($cells) {
                        $cells->setAlignment('right');
                    });
                });
                $excel->sheet('Survey Details', function($sheet) use($survey_array) {
                    $sheet->fromArray($survey_array, null, 'A1', false, false);
                    $total_rows = count($survey_array) + 1;
                    $sheet->cells('D1:D' . $total_rows, function($cells) {
                        $cells->setAlignment('right');
                    });
                    $sheet->cells('E1:E' . $total_rows, function($cells) {
                        $cells->setAlignment('right');
                    });
                });
                $excel->sheet('Doc Details', function($sheet) use($document_array) {
                    $sheet->fromArray($document_array, null, 'A1', false, false);
                });
                $excel->sheet('Payment Details', function($sheet) use($payment_array) {
                    $sheet->fromArray($payment_array, null, 'A1', false, false);
                    $total_rows = count($payment_array) + 1;
                    $sheet->cells('D1:D' . $total_rows, function($cells) {
                        $cells->setAlignment('right');
                    });
                });
                $excel->sheet('Audit Details', function($sheet) use($audit_array) {
                    $sheet->fromArray($audit_array, null, 'A1', false, false);
                });
            })->export('xls');

            //t($registrations, 1);
        }

        $this->data['dataPresent'] = 'yes';
        return view('admin.mis.list', $this->data);
    }

    public function transaction(Request $request) {
        $this->data['title'] = 'Dalmia-lams::MIS';
        $this->data['pageHeading'] = 'MIS <span class="text-danger" >Transaction</span>';
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.mis.listscript';
//        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';

        $transaction_arr = [
            '' => 'Select',
            'all' => 'Select All',
            'coversion_parent' => 'Conversion To Parent Company',
            'disputes' => 'Disputes',
            'hypothecation' => 'Hypothecation',
            'land_ceiling' => 'Land Ceiling',
            'land_conversion' => 'Land Conversion',
            'land_exchange' => 'Land Exchange',
            'land_inspection' => 'Land Inspection',
            'land_reservation' => 'Land Reservation',
            'lease' => 'Lease',
            'mining_lease' => 'Mining Lease',
            'mutation' => 'Mutation',
            'payment' => 'Payment',
            'under_operation' => 'Under Operation'
        ];
        $this->data['transaction_arr'] = $transaction_arr;
        $all_surveys = $this->getAllSurvey(null, null, null, true);
        // t($all_surveys,1);
        $this->data['all_surveys'] = $all_surveys;
        $posted_data = $request->all();
        //   t($posted_data,1);
        $cond = "1=1  ";
        if ($posted_data) {
            $allSearchData = $posted_data['registration'];
            $selected_transaction = isset($allSearchData['trxn']) ? $allSearchData['trxn'] : '';
            $selected_survey_id = isset($allSearchData['survey_id']) ? $allSearchData['survey_id'] : '';

            if (empty($allSearchData['state_id']) && empty($allSearchData['district_id'])) {
                $assgined_districts_str = UtilityModel::assignedDistricts($this->user_type, $this->assigned_states, $this->data['current_user_id']);
                if ($assgined_districts_str) {
                    $cond.= " AND district_id in ($assgined_districts_str) ";
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
            }

            $registratiion_ids = RegistrationModel::selectRaw("array_to_string(array_agg(distinct QUOTE_LITERAL(id)), ',') as id_str")->whereRaw($cond)->get()->toArray();
            //   t($registratiion_ids,1);
            $reg_id_str = isset($registratiion_ids[0]['id_str']) ? $registratiion_ids[0]['id_str'] : "'1'";

            $posted_disputes_data = isset($posted_data['disputes']) ? $posted_data['disputes'] : '';
            // t($posted_disputes_data);
            $disputes_cond = ' 1=1';
            if ($posted_disputes_data) {
                $disputes_cond.= isset($posted_disputes_data['litigation_type']) && $posted_disputes_data['litigation_type'] ? " and litigation_type = '{$posted_disputes_data['litigation_type']}'" : '';
                $hearing_from_date = isset($posted_disputes_data['date_from']) && $posted_disputes_data['date_from'] ? str_replace("/", "-", $posted_disputes_data['date_from']) : '';
                $hearing_from_date = ($hearing_from_date) ? new \DateTime($hearing_from_date) : '';
                $hearing_from_date = ($hearing_from_date) ? $hearing_from_date->format('Y-m-d') : '';
                $hearing_to_date = isset($posted_disputes_data['date_to']) && $posted_disputes_data['date_to'] ? str_replace("/", "-", $posted_disputes_data['date_to']) : '';
                $hearing_to_date = ($hearing_to_date) ? new \DateTime($hearing_to_date) : '';
                $hearing_to_date = ($hearing_to_date) ? $hearing_to_date->format('Y-m-d') : '';
                $disputes_cond.= ($hearing_from_date && $hearing_to_date) ? " and next_hear_date between '$hearing_from_date' and '$hearing_to_date' " : '';
            }

            //  echo $disputes_cond;exit;

            $dispute_details = \App\Models\Transaction\DisputesModel::whereRaw($cond)->whereRaw($disputes_cond)->orderBy('id', 'ASC')->get()->toArray();

            $dispute_array = [
                [
                    'Transaction ID', 'Survey No.', 'Date', 'Reminder Date', 'Next Hearing Date', 'Litigation Type', 'Remarks',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];

            if ($dispute_details) {
                foreach ($dispute_details as $key => $value) {
                    if ($selected_survey_id) {
                        $survey_res = \App\Models\Transaction\DisputesSurveyModel::where(['disputes_id' => $value['id'], 'survey_id' => $selected_survey_id])->get()->toArray();
                    } else {
                        $survey_res = \App\Models\Transaction\DisputesSurveyModel::where(['disputes_id' => $value['id']])->get()->toArray();
                    }
                    // t($survey_res);
                    $survey_str = isset($survey_res[0]['survey_str']) ? $survey_res[0]['survey_str'] : '';
                    $dispute_date = ($value['disp_date']) ? date('d/m/Y', strtotime($value['disp_date'])) : '';
                    $reminder_date = ($value['reminder_date']) ? date('d/m/Y', strtotime($value['reminder_date'])) : '';
                    $hearing_date = ($value['next_hear_date']) ? date('d/m/Y', strtotime($value['next_hear_date'])) : '';
                    $litigation_type = \App\Models\Common\CodeModel::where(['id' => $value['litigation_type'], 'cd_type' => 'litigation_type'])->value('cd_desc');
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    if ($survey_res) {
                        foreach ($survey_res as $s_key => $s_value) {
                            $dispute_array[] = [
                                $s_value['disputes_id'], $s_value['survey_no'], $dispute_date, $reminder_date, $hearing_date, $litigation_type, $value['description'],
                                $state, $district, $block, $village
                            ];
                        }
                    }
                }
                //exit;
            }
            // t($dispute_array, 1);
            $posted_ceiling_data = isset($posted_data['land_ceiling']) ? $posted_data['land_ceiling'] : '';
            // t($posted_ceiling_data,1);
            $ceiling_cond = ' 1=1';
            $posted_ceiling_survey_id = isset($posted_ceiling_data['survey_id']) && $posted_ceiling_data['survey_id'] ? $posted_ceiling_data['survey_id'] : '';
            if ($posted_ceiling_data) {
                $ceiling_cond .= isset($posted_ceiling_data['trxn_type']) && $posted_ceiling_data['trxn_type'] ? " and trxn_type = '{$posted_ceiling_data['trxn_type']}' " : '';
                // $ceiling_cond .= isset($posted_ceiling_data['survey_id']) && $posted_ceiling_data['survey_id'] ? " and survey_id = '{$posted_ceiling_data['survey_id']}' " : '';
                $trxn_from_date = isset($posted_ceiling_data['date_from']) && $posted_ceiling_data['date_from'] ? str_replace("/", "-", $posted_ceiling_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_ceiling_data['date_to']) && $posted_ceiling_data['date_to'] ? str_replace("/", "-", $posted_ceiling_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $ceiling_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }
            //  echo $ceiling_cond;
            $land_ceiling_details = \App\Models\Transaction\LandCeilingModel::whereRaw($cond)->whereRaw($ceiling_cond)->orderBy('id', 'ASC')->get()->toArray();
            // t($land_ceiling_details, 1);
            $ceiling_array = [
                [
                    'Transaction ID', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];

            if ($land_ceiling_details) {
                foreach ($land_ceiling_details as $key => $value) {
                    //  echo $value['id'];
                    if ($posted_ceiling_survey_id) {
                        $survey_res = \App\Models\Transaction\LandCeilingSurveyModel::where(['ceiling_id' => $value['id'], 'survey_id' => $posted_ceiling_survey_id])->get()->toArray();
                    } else if ($selected_survey_id) {
                        $survey_res = \App\Models\Transaction\LandCeilingSurveyModel::where(['ceiling_id' => $value['id'], 'survey_id' => $selected_survey_id])->get()->toArray();
                    } else {
                        $survey_res = \App\Models\Transaction\LandCeilingSurveyModel::where(['ceiling_id' => $value['id']])->get()->toArray();
                    }
                    //print_r($survey_res);
                    $transaction_type = ($value['trxn_type'] == 'Y') ? '37-A Applied' : '37-A Obtained';
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    if ($survey_res) {
                        foreach ($survey_res as $s_key => $s_value) {
                            $ceiling_array[] = [
                                $s_value['ceiling_id'], $s_value['survey_no'], $transaction_type, $transaction_date, $s_value['remarks'],
                                $state, $district, $block, $village
                            ];
                        }
                    }
                }
                // exit;
            }


            //start for land conversion
            // t($ceiling_array, 1);
            $posted_conversion_data = isset($posted_data['land_conversion']) ? $posted_data['land_conversion'] : '';
            $conversion_cond = ' 1=1';
            $posted_conversion_survey_id = isset($posted_conversion_data['survey_id']) && $posted_conversion_data['survey_id'] ? $posted_conversion_data['survey_id'] : '';
            if ($posted_conversion_data) {
                $conversion_cond .= isset($posted_conversion_data['trxn_type']) && $posted_conversion_data['trxn_type'] ? " and trxn_type = '{$posted_conversion_data['trxn_type']}' " : '';
                // $ceiling_cond .= isset($posted_ceiling_data['survey_id']) && $posted_ceiling_data['survey_id'] ? " and survey_id = '{$posted_ceiling_data['survey_id']}' " : '';
                $trxn_from_date = isset($posted_conversion_data['date_from']) && $posted_conversion_data['date_from'] ? str_replace("/", "-", $posted_conversion_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_conversion_data['date_to']) && $posted_conversion_data['date_to'] ? str_replace("/", "-", $posted_conversion_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $conversion_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }

            $land_conversion_details = \App\Models\Transaction\LandConversionModel::whereRaw($cond)->whereRaw($conversion_cond)->orderBy('id', 'ASC')->get()->toArray();
            $conversion_array = [
                [
                    'Transaction ID', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];

            if ($land_conversion_details) {
                foreach ($land_conversion_details as $key => $value) {
                    //  echo $value['id'];
                    if ($posted_conversion_survey_id) {
                        $survey_res = \App\Models\Transaction\LandConversionSurveyModel::where(['conversion_id' => $value['id'], 'survey_id' => $posted_conversion_survey_id])->get()->toArray();
                    } else if ($selected_survey_id) {
                        $survey_res = \App\Models\Transaction\LandConversionSurveyModel::where(['conversion_id' => $value['id'], 'survey_id' => $selected_survey_id])->get()->toArray();
                    } else {
                        $survey_res = \App\Models\Transaction\LandConversionSurveyModel::where(['conversion_id' => $value['id']])->get()->toArray();
                    }

                    //print_r($survey_res);
                    $transaction_type = ($value['trxn_type'] == 'Y') ? 'Applied' : 'Obtained';
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    if ($survey_res) {
                        foreach ($survey_res as $s_key => $s_value) {
                            $conversion_array[] = [
                                $s_value['conversion_id'], $s_value['survey_no'], $transaction_type, $transaction_date, $s_value['remarks'],
                                $state, $district, $block, $village
                            ];
                        }
                    }
                }
            }
            //end for land conversion
            //start for land exchange
            $posted_exchange_data = isset($posted_data['land_exchange']) ? $posted_data['land_exchange'] : '';
            // t($posted_exchange_data, 1);
            $exchange_cond = ' 1=1';

            $land_exchnage_details = \App\Models\Transaction\LandExchangeModel::whereRaw($cond)->whereRaw($exchange_cond)->orderBy('id', 'ASC')->get()->toArray();
            // t($land_exchnage_details, 1);
            $exchange_array = [
                [
                    'Transaction ID', 'Survey No.', 'Transaction Date', 'Transferee', 'Date Of Exchange', 'Remarks',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];
            if ($land_exchnage_details) {
                $survey_cond = ' 1= 1';
                $exchange_from_date = isset($posted_exchange_data['date_from']) && $posted_exchange_data['date_from'] ? str_replace("/", "-", $posted_exchange_data['date_from']) : '';
                $exchange_from_date = ($exchange_from_date) ? new \DateTime($exchange_from_date) : '';
                $exchange_from_date = ($exchange_from_date) ? $exchange_from_date->format('Y-m-d') : '';
                $exchange_to_date = isset($posted_exchange_data['date_to']) && $posted_exchange_data['date_to'] ? str_replace("/", "-", $posted_exchange_data['date_to']) : '';
                $exchange_to_date = ($exchange_to_date) ? new \DateTime($exchange_to_date) : '';
                $exchange_to_date = ($exchange_to_date) ? $exchange_to_date->format('Y-m-d') : '';
                $exchange_cond .= ($exchange_from_date && $exchange_to_date) ? " and date_of_exchange BETWEEN '$exchange_from_date' and '$exchange_to_date' " : '';
                foreach ($land_exchnage_details as $key => $value) {
                    if ($selected_survey_id) {
                        $survey_cond.= " and survey_id = '$selected_survey_id' ";
                    }
                    if (isset($posted_exchange_data['transferee']) && $posted_exchange_data['transferee']) {
                        $survey_cond.= " and transferee like '{$posted_exchange_data['transferee']}'";
                    }
                    if ($exchange_from_date && $exchange_to_date) {
                        $survey_cond.= " and date_of_exchange BETWEEN '$exchange_from_date' and '$exchange_to_date' ";
                    }
                    $survey_res = \App\Models\Transaction\LandExchangeSurveyModel::where(['land_exchange_id' => $value['id']])->whereRaw($survey_cond)->get()->toArray();
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    if ($survey_res) {
                        foreach ($survey_res as $s_key => $s_value) {
                            $date_of_exchange = ($s_value['date_of_exchange']) ? date('d/m/Y', strtotime($s_value['date_of_exchange'])) : '';
                            $exchange_array[] = [
                                $s_value['land_exchange_id'], $s_value['survey_no'], $transaction_date, $s_value['transferee'], $date_of_exchange, $s_value['remarks'],
                                $state, $district, $block, $village
                            ];
                        }
                    }
                }
            }
            //end for land exchange
            //t($exchange_array,1);
            // start for land inspection
            $posted_inspection_data = isset($posted_data['land_inspection']) ? $posted_data['land_inspection'] : '';

            $inspection_cond = ' 1=1 ';
            if ($posted_inspection_data) {
                $inspection_cond.= isset($posted_inspection_data['encroachment']) && $posted_inspection_data['encroachment'] ? " and encroachment = '{$posted_inspection_data['encroachment']}' " : '';
                $inspection_cond.= isset($posted_inspection_data['encroachment_type']) && $posted_inspection_data['encroachment_type'] ? " and encroachment_type = '{$posted_inspection_data['encroachment_type']}' " : '';

                $inspection_from_date = isset($posted_inspection_data['date_from']) && $posted_inspection_data['date_from'] ? str_replace("/", "-", $posted_inspection_data['date_from']) : '';
                $inspection_from_date = ($inspection_from_date) ? new \DateTime($inspection_from_date) : '';
                $inspection_from_date = ($inspection_from_date) ? $inspection_from_date->format('Y-m-d') : '';
                $inspection_to_date = isset($posted_inspection_data['date_to']) && $posted_inspection_data['date_to'] ? str_replace("/", "-", $posted_inspection_data['date_to']) : '';
                $inspection_to_date = ($inspection_to_date) ? new \DateTime($inspection_to_date) : '';
                $inspection_to_date = ($inspection_to_date) ? $inspection_to_date->format('Y-m-d') : '';
                $inspection_cond.= ($inspection_from_date && $inspection_to_date) ? " and insp_date BETWEEN '$inspection_from_date' and '$inspection_to_date' " : '';
            }
            $inspection_cond.= $selected_survey_id ? " and survey_id = '$selected_survey_id' " : '';
            $land_inspection_details = \App\Models\Transaction\InspectionModel::whereRaw($cond)->whereRaw($inspection_cond)->orderBy('id', 'ASC')->get()->toArray();
            // t($land_inspection_details, 1);
            $inspection_array = [
                [
                    'Transaction ID', 'Survey No.', 'Transaction Date', 'Inspection Date', 'Encroachment', 'Encroachment Type', 'Remarks',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];
            if ($land_inspection_details) {
                foreach ($land_inspection_details as $key => $value) {
                    $survey_no = SurveyModel::where(['id' => $value['survey_id']])->value('survey_no');
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $inspection_date = ($value['insp_date']) ? date('d/m/Y', strtotime($value['insp_date'])) : '';
                    $encroachment = ($value['encroachment'] == 'Y') ? 'Yes' : 'No';
                    $encroachment_type = \App\Models\Common\CodeModel::where(['id' => $value['encroachment_type'], 'cd_type' => 'encroachment_type'])->value('cd_desc');
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    $inspection_array [] = [
                        $value['id'], $survey_no, $transaction_date, $inspection_date, $encroachment, $encroachment_type, $value['description'],
                        $state, $district, $block, $village
                    ];
                }
            }
            //t($inspection_array, 1);
            // end for land inspection
            //start for land reservation
            $posted_reservation_data = isset($posted_data['land_reservation']) ? $posted_data['land_reservation'] : '';

            $reservation_cond = ' 1=1';
            $posted_reservation_survey_id = isset($posted_reservation_data['survey_id']) && $posted_reservation_data['survey_id'] ? $posted_reservation_data['survey_id'] : '';
            if ($posted_reservation_data) {
                $reservation_cond .= isset($posted_reservation_data['trxn_type']) && $posted_reservation_data['trxn_type'] ? " and trxn_type = '{$posted_reservation_data['trxn_type']}' " : '';
                // $ceiling_cond .= isset($posted_ceiling_data['survey_id']) && $posted_ceiling_data['survey_id'] ? " and survey_id = '{$posted_ceiling_data['survey_id']}' " : '';
                $trxn_from_date = isset($posted_reservation_data['date_from']) && $posted_reservation_data['date_from'] ? str_replace("/", "-", $posted_reservation_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_reservation_data['date_to']) && $posted_reservation_data['date_to'] ? str_replace("/", "-", $posted_reservation_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $reservation_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }
            $land_reservation_details = \App\Models\Transaction\LandReservationModel::whereRaw($cond)->whereRaw($reservation_cond)->orderBy('id', 'ASC')->get()->toArray();
            // t($land_reservation_details, 1);
            $reservation_array = [
                [
                    'Transaction ID', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];
            if ($land_reservation_details) {
                foreach ($land_reservation_details as $key => $value) {
                    if ($posted_reservation_survey_id) {
                        $survey_res = \App\Models\Transaction\LandReservationSurveyModel::where(['reservation_id' => $value['id'], 'survey_id' => $posted_reservation_survey_id])->get()->toArray();
                    } else if ($selected_survey_id) {
                        $survey_res = \App\Models\Transaction\LandReservationSurveyModel::where(['reservation_id' => $value['id'], 'survey_id' => $selected_survey_id])->get()->toArray();
                    } else {
                        $survey_res = \App\Models\Transaction\LandReservationSurveyModel::where(['reservation_id' => $value['id']])->get()->toArray();
                    }
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $transaction_type = ($value['trxn_type'] == 'Y') ? 'Reserved' : 'Dereserved';
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    if ($survey_res) {
                        foreach ($survey_res as $s_key => $s_value) {
                            $reservation_array[] = [
                                $s_value['reservation_id'], $s_value['survey_no'], $transaction_type, $transaction_date, $s_value['remarks'],
                                $state, $district, $block, $village
                            ];
                        }
                    }
                }
            }
            //t($reservation_array, 1);
            //end for land reservation
            //Start For Under Opertaion
            $posted_under_operation_data = isset($posted_data['under_operation']) ? $posted_data['under_operation'] : '';
            $under_operation_cond = ' 1=1';

            $posted_under_operation_survey_id = isset($selected_survey_id) && $selected_survey_id ? $selected_survey_id : '';

            if ($posted_under_operation_data) {
                $under_operation_cond .= isset($posted_under_operation_data['operation_type']) && $posted_under_operation_data['operation_type'] ? " and operation_type = '{$posted_under_operation_data['operation_type']}' " : '';
                $under_operation_cond .= isset($posted_under_operation_survey_id) && $posted_under_operation_survey_id ? " and survey_id = '{$posted_under_operation_survey_id}' " : '';
                $trxn_from_date = isset($posted_under_operation_data['date_from']) && $posted_under_operation_data['date_from'] ? str_replace("/", "-", $posted_under_operation_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_under_operation_data['date_to']) && $posted_under_operation_data['date_to'] ? str_replace("/", "-", $posted_under_operation_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $under_operation_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }

            $under_operation_cond .= $selected_survey_id ? " and survey_id = '{$selected_survey_id}' " : '';
            $under_opertaion_details = \App\Models\Transaction\UnderOperationModel::whereRaw($cond)->whereRaw($under_operation_cond)->orderBy('id', 'ASC')->get()->toArray();
            $operation_array = [
                [
                    'Transaction ID', 'Survey No.', 'Transaction Date', 'Operation Type', 'Remarks',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];
            if ($under_opertaion_details) {
                foreach ($under_opertaion_details as $key => $value) {
                    $survey_no = SurveyModel::where(['id' => $value['survey_id']])->value('survey_no');
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $operation_type = \App\Models\Common\CodeModel::where(['id' => $value['operation_type'], 'cd_type' => 'operation'])->value('cd_desc');
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    $operation_array [] = [
                        $value['id'], $survey_no, $transaction_date, $operation_type, $value['description'],
                        $state, $district, $block, $village
                    ];
                }
            }
            //End For Under Opertaion
            //Start For Lease
            $posted_lease_data = isset($posted_data['lease']) ? $posted_data['lease'] : '';
            $lease_cond = ' 1=1';
            $posted_lease_reg_id = isset($posted_lease_data['registration_id']) ? $posted_lease_data['registration_id'] : '';
            if ($posted_lease_data) {
                $trxn_from_date = isset($posted_lease_data['date_from']) && $posted_lease_data['date_from'] ? str_replace("/", "-", $posted_lease_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_lease_data['date_to']) && $posted_lease_data['date_to'] ? str_replace("/", "-", $posted_lease_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $lease_cond .= ($trxn_from_date && $trxn_to_date) ? " and lease_start_date >= '$trxn_from_date' and lease_end_date <= '$trxn_to_date' " : '';
            }
            if ($posted_lease_reg_id) {
                $lease_details = \App\Models\LeaseManagement\LeaseModel::whereRaw("registration_id = '$posted_lease_reg_id'")->whereRaw($lease_cond)->get()->toArray();
            } else {
                $lease_details = \App\Models\LeaseManagement\LeaseModel::whereRaw("registration_id in ($reg_id_str)")->whereRaw($lease_cond)->get()->toArray();
            }
            // t($lease_details, 1);
            $lease_array = [
                [
                    'Lease ID', 'Regn No.', 'Lessee', 'Lessor', 'Lease Rent p.a.', 'Period (From - To)', 'Escalation %', 'Status'
                ]
            ];
            if ($lease_details) {
                foreach ($lease_details as $key => $value) {
                    $lease_start_date = new \DateTime($value['lease_start_date']);
                    $lease_start_date = $lease_start_date->format('d/m/Y');

                    $lease_end_date = new \DateTime($value['lease_end_date']);
                    $lease_end_date = $lease_end_date->format('d/m/Y');
                    $lease_date_range = $lease_start_date . ' to ' . $lease_end_date;
                    $status = ($value['status'] == 'Y') ? 'Active' : 'Not Active';
                    $lease_array [] = [
                        $value['id'], $value['registration_id'], $value['lease_name'], $value['lessor_name'], (double) $value['lease_monthly_amount'],
                        $lease_date_range, $value['percentage_escalation'], $status
                    ];
                }
            }
            //End For Lease

            $posted_payment_data = isset($posted_data['payment']) ? $posted_data['payment'] : '';
            $payment_cond = ' 1=1';
            $posted_payment_reg_id = isset($posted_payment_data['registration_id']) ? $posted_payment_data['registration_id'] : '';
            if ($posted_payment_data) {
                $payment_cond .= isset($posted_payment_data['payment_type']) && $posted_payment_data['payment_type'] ? " and pay_type = '{$posted_payment_data['payment_type']}' " : '';
                $trxn_from_date = isset($posted_payment_data['date_from']) && $posted_payment_data['date_from'] ? str_replace("/", "-", $posted_payment_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_payment_data['date_to']) && $posted_payment_data['date_to'] ? str_replace("/", "-", $posted_payment_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $payment_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }
            if ($posted_payment_reg_id) {
                $payment_details = PaymentModel::whereRaw("registration_id = '$posted_payment_reg_id'")->whereRaw($payment_cond)->orderBy('registration_id', 'ASC')->get()->toArray();
            } else {
                $payment_details = PaymentModel::whereRaw("registration_id in($reg_id_str)")->whereRaw($payment_cond)->orderBy('registration_id', 'ASC')->get()->toArray();
            }


            $payment_array = [
                [
                    'Transaction ID', 'Registration No.', 'Transaction Date', 'Payment Type', 'Mode', 'Amount', 'Ref No',
                    'Date', 'Bank', 'Remarks'
                ]
            ];
            if ($payment_details) {
                foreach ($payment_details as $key => $value) {
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $pay_mode = \App\Models\Common\CodeModel::where(['id' => $value['pay_mode'], 'cd_type' => 'payment_mode'])->value('cd_desc');
                    $payment_type = \App\Models\Common\CodeModel::where(['id' => $value['pay_type'], 'cd_type' => 'payment_type'])->value('cd_desc');
                    $payment_array [] = [
                        $value['id'], $value['registration_id'], $transaction_date, $payment_type, $pay_mode, (double) $value['amount'], $value['reference_no'],
                        $value['pay_date'], $value['pay_bank'], $value['description']
                    ];
                }
            }

            //Start For Mining Lease
            $posted_mining_lease_data = isset($posted_data['mining_lease']) ? $posted_data['mining_lease'] : '';
            $mining_lease_cond = ' 1=1';

            $posted_mining_lease_survey_id = isset($posted_mining_lease_data['survey_id']) && $posted_mining_lease_data['survey_id'] ? $posted_mining_lease_data['survey_id'] : '';

            if ($posted_mining_lease_data) {
                if (isset($posted_mining_lease_data['trxn_type']) && $posted_mining_lease_data['trxn_type'] == 'N') {
                    $trxn_type = 'Y';
                } elseif (isset($posted_mining_lease_data['trxn_type']) && $posted_mining_lease_data['trxn_type'] == 'Y') {
                    $trxn_type = 'N';
                } else {
                    $trxn_type = '';
                }

                $mining_lease_cond .= $trxn_type ? " and trxn_type = '$trxn_type' " : '';
                $trxn_from_date = isset($posted_mining_lease_data['date_from']) && $posted_mining_lease_data['date_from'] ? str_replace("/", "-", $posted_mining_lease_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_mining_lease_data['date_to']) && $posted_mining_lease_data['date_to'] ? str_replace("/", "-", $posted_mining_lease_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $mining_lease_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }

            $mining_lease_details = \App\Models\Transaction\MiningLeaseModel::whereRaw($cond)->whereRaw($mining_lease_cond)->orderBy('id', 'ASC')->get()->toArray();

            $mining_array = [
                [
                    'Transaction ID', 'Survey No.', 'Transaction Type', 'Transaction Date', 'GO', 'Remarks',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];
            if ($mining_lease_details) {
                foreach ($mining_lease_details as $key => $value) {

                    if ($posted_mining_lease_survey_id) {
                        $survey_res = \App\Models\Transaction\MiningLeaseSurveyModel::where(['mining_lease_id' => $value['id'], 'survey_id' => $posted_mining_lease_survey_id])->get()->toArray();
                    } else if ($selected_survey_id) {
                        $survey_res = \App\Models\Transaction\MiningLeaseSurveyModel::where(['mining_lease_id' => $value['id'], 'survey_id' => $selected_survey_id])->get()->toArray();
                    } else {
                        $survey_res = \App\Models\Transaction\MiningLeaseSurveyModel::where(['mining_lease_id' => $value['id']])->get()->toArray();
                    }

                    $transaction_type = ($value['trxn_type'] == 'Y') ? 'Obtained' : 'Applied';
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';

                    if ($survey_res) {
                        foreach ($survey_res as $s_key => $s_value) {
                            //$go = ($value['trxn_type'] == 'N') ? $s_value['go'] : '';
                            $mining_array[] = [
                                $s_value['mining_lease_id'], $s_value['survey_no'], $transaction_type, $transaction_date, $s_value['go'], $s_value['remarks'],
                                $state, $district, $block, $village
                            ];
                        }
                    }
                }
            }
            //End For Mining Lease
            //Start For Mutation
            $posted_mutation_data = isset($posted_data['mutation']) ? $posted_data['mutation'] : '';
            $mutation_cond = ' 1=1';

            $posted_mutation_survey_id = isset($posted_mutation_data['survey_id']) && $posted_mutation_data['survey_id'] ? $posted_mutation_data['survey_id'] : '';

            if ($posted_mutation_data) {
                $mutation_cond .= isset($posted_mutation_data['patta_id']) && $posted_mutation_data['patta_id'] ? " and patta_id = '{$posted_mutation_data['patta_id']}' " : '';
                $trxn_from_date = isset($posted_mutation_data['date_from']) && $posted_mutation_data['date_from'] ? str_replace("/", "-", $posted_mutation_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_mutation_data['date_to']) && $posted_mutation_data['date_to'] ? str_replace("/", "-", $posted_mutation_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $mutation_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }
            $mutation_details = \App\Models\Transaction\MutationModel::whereRaw($cond)->whereRaw($mutation_cond)->orderBy('id', 'ASC')->get()->toArray();

            $mutation_array = [
                [
                    'Transaction ID', 'Patta No.', 'Patta Owner', 'New Patta No.', 'New Patta Owner', 'Survey No.', 'Transaction Date',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];
            if ($mutation_details) {
                foreach ($mutation_details as $key => $value) {

                    if ($posted_mutation_survey_id) {
                        $survey_res = \App\Models\Transaction\MutationSurveyModel::where(['mutation_id' => $value['id'], 'survey_id' => $posted_mutation_survey_id])->get()->toArray();
                    } else if ($selected_survey_id) {
                        $survey_res = \App\Models\Transaction\MutationSurveyModel::where(['mutation_id' => $value['id'], 'survey_id' => $selected_survey_id])->get()->toArray();
                    } else {
                        $survey_res = \App\Models\Transaction\MutationSurveyModel::where(['mutation_id' => $value['id']])->get()->toArray();
                    }
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $state = \App\Models\Common\StateModel::where(['id' => $value['state_id']])->value('state_name');
                    $district = \App\Models\Common\DistrictModel::where(['id' => $value['district_id']])->value('district_name');
                    $block = \App\Models\Common\BlockModel::where(['id' => $value['block_id']])->value('block_name');
                    $village = \App\Models\Common\VillageModel::where(['id' => $value['village_id']])->value('village_name');
                    $patta_no = \App\Models\LandDetailsManagement\PattaModel::where(['id' => $value['patta_id']])->value('patta_no');
                    $patta_owner = \App\Models\LandDetailsManagement\PattaModel::where(['id' => $value['patta_id']])->value('patta_owner');
                    if ($survey_res) {
                        foreach ($survey_res as $s_key => $s_value) {
                            $mutation_array[] = [
                                $value['id'], $patta_no, $patta_owner, $value['new_patta_no'], $value['new_patta_owner'], $s_value['survey_no'], $transaction_date,
                                $state, $district, $block, $village
                            ];
                        }
                    }
                }
            }
            //End For Mutation
            //Start For Hypothecation
            $posted_hypothecation_data = isset($posted_data['hypothecation']) ? $posted_data['hypothecation'] : '';
            $hypothecation_cond = ' 1=1';

            $posted_hypothecation_registration_id = isset($posted_data['registration_id']) && $posted_data['registration_id'] ? "'" . implode("','", $posted_data['registration_id']) . "'" : '';
            if (!empty($posted_hypothecation_registration_id)) {
                $reg_id_str = $posted_hypothecation_registration_id;
            }

            if ($posted_hypothecation_data) {

                if (isset($posted_hypothecation_data['trxn_type']) && $posted_hypothecation_data['trxn_type'] == 'Y') {
                    $trxn_type = 'Y';
                } elseif (isset($posted_hypothecation_data['trxn_type']) && $posted_hypothecation_data['trxn_type'] == 'R') {
                    $trxn_type = 'N';
                } else {
                    $trxn_type = '';
                }

                $hypothecation_cond .= $trxn_type ? " and trxn_type = '$trxn_type' " : '';
                $hypothecation_cond .= isset($posted_hypothecation_data['hyp_with']) && $posted_hypothecation_data['hyp_with'] ? " and hyp_with = '{$posted_hypothecation_data['hyp_with']}' " : '';
                $trxn_from_date = isset($posted_hypothecation_data['date_from']) && $posted_hypothecation_data['date_from'] ? str_replace("/", "-", $posted_hypothecation_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_hypothecation_data['date_to']) && $posted_hypothecation_data['date_to'] ? str_replace("/", "-", $posted_hypothecation_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $hypothecation_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }

            $hypothetication_details = \App\Models\Transaction\HypotheticationModel::whereRaw($hypothecation_cond)->orderBy('id', 'ASC')->get()->toArray();
            $hypothetication_array = [
                [
                    'Transaction ID', 'Transaction Date', 'Hypothecate Name', 'Transaction Type', 'Registration No.', 'Hypothecate With', 'Date', 'Value', 'Remarks'
                ]
            ];
            if ($hypothetication_details) {
                foreach ($hypothetication_details as $key => $value) {
                    $registration_res = \App\Models\Transaction\HypotheticationRegistrationModel::where(['hypothecate_id' => $value['id'], 'fl_archive' => 'N'])->whereRaw("registration_id in($reg_id_str)")->get()->toArray();

                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $hypo_name = \App\Models\Common\CodeModel::where(['id' => $value['hyp_name'], 'cd_type' => 'hypothecate_name'])->value('cd_desc');
                    $hypo_with = \App\Models\Common\CodeModel::where(['id' => $value['hyp_with'], 'cd_type' => 'hypothecate_with'])->value('cd_desc');
                    $trxn_type = ($value['trxn_type'] == 'Y') ? 'Hypothicate' : 'Release';
                    $date = ($value['hyp_date']) ? date('d/m/Y', strtotime($value['hyp_date'])) : '';

                    if ($registration_res) {
                        foreach ($registration_res as $r_key => $r_value) {
                            $hypothetication_array[] = [
                                $value['id'], $transaction_date, $hypo_name, $trxn_type, $r_value['registration_id'], $hypo_with, $date, (double) $value['value'], $value['description']
                            ];
                        }
                    }
                }
            }
            //End For Hypothecation
            //Start For Conversion To Parent Company
            $posted_coversion_parent_data = isset($posted_data['coversion_parent']) ? $posted_data['coversion_parent'] : '';
            $coversion_parent_cond = ' 1=1';

            if ($posted_coversion_parent_data) {
                $coversion_parent_cond .= isset($posted_coversion_parent_data['registration_id']) && $posted_coversion_parent_data['registration_id'] ? " and converted_registration_id = '{$posted_coversion_parent_data['registration_id']}' " : '';
                $trxn_from_date = isset($posted_coversion_parent_data['date_from']) && $posted_coversion_parent_data['date_from'] ? str_replace("/", "-", $posted_coversion_parent_data['date_from']) : '';
                $trxn_from_date = ($trxn_from_date) ? new \DateTime($trxn_from_date) : '';
                $trxn_from_date = ($trxn_from_date) ? $trxn_from_date->format('Y-m-d') : '';
                $trxn_to_date = isset($posted_coversion_parent_data['date_to']) && $posted_coversion_parent_data['date_to'] ? str_replace("/", "-", $posted_coversion_parent_data['date_to']) : '';
                $trxn_to_date = ($trxn_to_date) ? new \DateTime($trxn_to_date) : '';
                $trxn_to_date = ($trxn_to_date) ? $trxn_to_date->format('Y-m-d') : '';
                $coversion_parent_cond .= ($trxn_from_date && $trxn_to_date) ? " and created_at BETWEEN '$trxn_from_date' and '$trxn_to_date' " : '';
            }

            $parent_details = \App\Models\Transaction\ParentConversionModel::where(['fl_archive' => 'N'])->whereRaw("converted_registration_id in($reg_id_str)")->whereRaw($coversion_parent_cond)->orderBy('id', 'ASC')->get()->toArray();

            $parent_array = [
                [
                    'Transaction ID', 'Converted ID', 'Transaction Date', 'Old Registration No.', 'Purchaser', 'Legal Entity', 'Sub Registrar Office', 'Purchased Area', 'Cost',
                    'State', 'District', 'Block/Taluk', 'Village'
                ]
            ];
            if ($parent_details) {
                foreach ($parent_details as $key => $value) {
                    $registration_res = RegistrationModel::where(['id' => $value['converted_registration_id']])->get()->toArray();
                    $transaction_date = ($value['created_at']) ? date('d/m/Y', strtotime($value['created_at'])) : '';
                    $purchaser_name = isset($registration_res[0]['purchaser']) ? \App\Models\Common\CodeModel::where(['id' => $registration_res[0]['purchaser'], 'cd_type' => 'purchaser_name'])->value('cd_desc') : '';
                    $legal_entity = isset($registration_res[0]['legal_entity']) ? \App\Models\Common\CodeModel::where(['id' => $registration_res[0]['legal_entity'], 'cd_type' => 'legal_entity'])->value('cd_desc') : '';
                    $sub_registrar = isset($registration_res[0]['sub_registrar']) ? \App\Models\Common\CodeModel::where(['id' => $registration_res[0]['sub_registrar'], 'cd_type' => 'sub_registrar_office'])->value('cd_desc') : '';
                    $purchased_area = isset($registration_res[0]['tot_area']) ? $registration_res[0]['tot_area'] : '';
                    $cost = isset($registration_res[0]['tot_cost']) ? $registration_res[0]['tot_cost'] : '';
                    $state = isset($registration_res[0]['state_id']) ? \App\Models\Common\StateModel::where(['id' => $registration_res[0]['state_id']])->value('state_name') : '';
                    $district = isset($registration_res[0]['district_id']) ? \App\Models\Common\DistrictModel::where(['id' => $registration_res[0]['district_id']])->value('district_name') : '';
                    $block = isset($registration_res[0]['block_id']) ? \App\Models\Common\BlockModel::where(['id' => $registration_res[0]['block_id']])->value('block_name') : '';
                    $village = isset($registration_res[0]['village_id']) ? \App\Models\Common\VillageModel::where(['id' => $registration_res[0]['village_id']])->value('village_name') : '';

                    if ($registration_res) {
                        foreach ($registration_res as $r_key => $r_value) {
                            $parent_array[] = [
                                $value['id'], $value['converted_registration_id'], $transaction_date, $value['old_registration_id'], $purchaser_name, $legal_entity, $sub_registrar, (double) $purchased_area, (double) $cost,
                                $state, $district, $block, $village
                            ];
                        }
                    }
                }
            }
            //End For Conversion To Parent Company
            if ($selected_transaction == 'all') {
                $file_name = 'MIS_TRANSACTION_ALL_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($dispute_array, $ceiling_array, $conversion_array, $exchange_array, $inspection_array, $reservation_array
                        , $lease_array, $mining_array, $operation_array, $payment_array, $mutation_array, $hypothetication_array, $parent_array) {
                    $excel->sheet('Disputes', function($sheet) use($dispute_array) {
                        $sheet->fromArray($dispute_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Land Ceiling', function($sheet) use($ceiling_array) {
                        $sheet->fromArray($ceiling_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Land Conversion', function($sheet) use($conversion_array) {
                        $sheet->fromArray($conversion_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Land Exchange', function($sheet) use($exchange_array) {
                        $sheet->fromArray($exchange_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Land Inspection', function($sheet) use($inspection_array) {
                        $sheet->fromArray($inspection_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Land Reservation', function($sheet) use($reservation_array) {
                        $sheet->fromArray($reservation_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Mining Lease', function($sheet) use($mining_array) {
                        $sheet->fromArray($mining_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Lease', function($sheet) use($lease_array) {
                        $sheet->fromArray($lease_array, null, 'A1', false, false);
                        $total_rows = count($lease_array) + 1;
                        $sheet->cells('G1:G' . $total_rows, function($cells) {
                            $cells->setAlignment('right');
                        });
                    });
                    $excel->sheet('Under Operation', function($sheet) use($operation_array) {
                        $sheet->fromArray($operation_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Payment', function($sheet) use($payment_array) {
                        $sheet->fromArray($payment_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Mutation', function($sheet) use($mutation_array) {
                        $sheet->fromArray($mutation_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Hypothecation', function($sheet) use($hypothetication_array) {
                        $sheet->fromArray($hypothetication_array, null, 'A1', false, false);
                    });
                    $excel->sheet('Conversion To Parent Company', function($sheet) use($parent_array) {
                        $sheet->fromArray($parent_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'hypothecation') {
                $file_name = 'MIS_TRANSACTION_HYPOTHECATION_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($hypothetication_array) {
                    $excel->sheet('Hypothecation', function($sheet) use($hypothetication_array) {
                        $sheet->fromArray($hypothetication_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'disputes') {
                $file_name = 'MIS_TRANSACTION_DISPUTES_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($dispute_array) {
                    $excel->sheet('Disputes', function($sheet) use($dispute_array) {
                        $sheet->fromArray($dispute_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'land_ceiling') {
                $file_name = 'MIS_TRANSACTION_CEILING_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($ceiling_array) {
                    $excel->sheet('Land Ceiling', function($sheet) use($ceiling_array) {
                        $sheet->fromArray($ceiling_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'land_conversion') {
                $file_name = 'MIS_TRANSACTION_CONVERSION_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($conversion_array) {
                    $excel->sheet('Land Conversion', function($sheet) use($conversion_array) {
                        $sheet->fromArray($conversion_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'land_exchange') {
                $file_name = 'MIS_TRANSACTION_EXCHANGE_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($exchange_array) {
                    $excel->sheet('Land Exchange', function($sheet) use($exchange_array) {
                        $sheet->fromArray($exchange_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'land_inspection') {
                $file_name = 'MIS_TRANSACTION_INSPECTION_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($inspection_array) {
                    $excel->sheet('Land Inspection', function($sheet) use($inspection_array) {
                        $sheet->fromArray($inspection_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'land_reservation') {
                $file_name = 'MIS_TRANSACTION_RESERVATION_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($reservation_array) {
                    $excel->sheet('Land Reservation', function($sheet) use($reservation_array) {
                        $sheet->fromArray($reservation_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'payment') {
                $file_name = 'MIS_TRANSACTION_PAYMENT_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($payment_array) {
                    $excel->sheet('Payment', function($sheet) use($payment_array) {
                        $sheet->fromArray($payment_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'under_operation') {
                $file_name = 'MIS_TRANSACTION_UNDER_OPERATION_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($operation_array) {
                    $excel->sheet('Under Operation', function($sheet) use($operation_array) {
                        $sheet->fromArray($operation_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'mutation') {
                $file_name = 'MIS_TRANSACTION_MUTATION_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($mutation_array) {
                    $excel->sheet('Mutation', function($sheet) use($mutation_array) {
                        $sheet->fromArray($mutation_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'mining_lease') {
                $file_name = 'MIS_TRANSACTION_MINING_LEASE_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($mining_array) {
                    $excel->sheet('Mining Lease', function($sheet) use($mining_array) {
                        $sheet->fromArray($mining_array, null, 'A1', false, false);
                    });
                })->export('xls');
            } else if ($selected_transaction == 'lease') {
                $file_name = 'MIS_TRANSACTION_LEASE_' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($lease_array) {
                    $excel->sheet('Lease', function($sheet) use($lease_array) {
                        $sheet->fromArray($lease_array, null, 'A1', false, false);
                        $total_rows = count($lease_array) + 1;
                        $sheet->cells('G1:G' . $total_rows, function($cells) {
                            $cells->setAlignment('right');
                        });
                    });
                })->export('xls');
            } else if ($selected_transaction == 'coversion_parent') {
                $file_name = 'MIS_TRANSACTION_CONVERSION_TO_PARENT' . date('d.m.Y');
                Excel::create($file_name, function($excel) use($parent_array) {
                    $excel->sheet('Conversion To Parent Company', function($sheet) use($parent_array) {
                        $sheet->fromArray($parent_array, null, 'A1', false, false);
                    });
                })->export('xls');
            }
        }
        $this->data['dataPresent'] = 'yes';
        return view('admin.mis.transaction', $this->data);
    }

    public function common(Request $request, $option = true, $json = true) {

        $this->data['transaction_type'] = $transaction_type = $request->get('val');
        $all_surveys = $this->getAllSurvey(null, null, null, true);
        // t($all_surveys,1);
        $this->data['all_surveys'] = $all_surveys;


        if ($transaction_type == 'hypothecation') {
            $this->data['type'] = [
                '' => 'Select',
                'Y' => 'Hypothicate',
                'R' => 'Release',
            ];
            $this->data['hypothecate_with'] = $this->getCodesDetails('hypothecate_with');
            $all_registrationIds = $this->getAllRegistration(null, null, 'hypothecate');
            $this->data['all_registrationIds'] = $all_registrationIds;
        } else if ($transaction_type == 'disputes') {
            $this->data['litigation_type'] = $this->getCodesDetails('litigation_type');
        } else if ($transaction_type == 'land_ceiling') {
            $this->data['type'] = [
                '' => 'Select',
                'Y' => '37-A Applied',
                'N' => '37-A Obtained',
            ];
        } else if ($transaction_type == 'land_conversion') {
            $this->data['type'] = [
                '' => 'Select',
                'Y' => 'Applied',
                'N' => 'Obtained',
            ];
        } else if ($transaction_type == 'land_inspection') {
            $this->data['encroachment_info'] = [
                '' => 'Select',
                'Y' => 'Yes',
                'N' => 'No',
            ];
            $this->data['encroachment_type'] = $this->getCodesDetails('encroachment_type');
        } else if ($transaction_type == 'payment') {
            $this->data['payment_type'] = $this->getCodesDetails('payment_type');
            $all_registrationIds = $this->getAllRegistration();
            $this->data['all_registrationIds'] = $all_registrationIds;
        } else if ($transaction_type == 'under_operation') {
            $this->data['operation_type'] = $this->getCodesDetails('operation');
        } else if ($transaction_type == 'mutation') {
            $old_patta_no = \App\Models\LandDetailsManagement\PattaModel::where(['fl_archive' => 'N'])->whereRaw("mutation_status = 'Y' or mutation_status = 'P'")->orderBy('patta_no')->lists('patta_no', 'id')->toArray();
            $old_patta_no = array_merge(array('' => 'select'), $old_patta_no);
            $this->data['old_patta_no'] = $old_patta_no;
        } else if ($transaction_type == 'mining_lease') {
            $this->data['type'] = [
                '' => 'Select',
                'Y' => 'Applied',
                'N' => 'Obtained',
            ];
        } else if ($transaction_type == 'land_reservation') {
            $this->data['type'] = [
                '' => 'Select',
                'Y' => 'Reserved',
                'N' => 'Dereserved',
            ];
        } else if ($transaction_type == 'coversion_parent') {
            $all_registrationIds = $this->getAllRegistration(null, null, 'con_parent');
            $this->data['all_registrationIds'] = $all_registrationIds;
        } else if ($transaction_type == 'lease') {
            $all_registrationIds = $this->getAllRegistration(null, null, 'lease');
            $this->data['all_registrationIds'] = $all_registrationIds;
        }


        if ($option == 'true')
            return view('admin.mis.common', $this->data);
        else {
            if ($json == 'true') {

                echo json_encode($optionList);
            } else {
                return $optionList;
            }
        }
    }

}
