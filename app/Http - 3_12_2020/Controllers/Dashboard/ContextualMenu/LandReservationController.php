<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Dashboard\ContextualMenu;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\Common\StateModel;
use App\Models\Common\DistrictModel;
use App\Models\Common\BlockModel;
use App\Models\Common\VillageModel;
use App\Models\Common\ConversionModel;
use App\Models\Common\CodeModel;
use App\Models\LandDetailsManagement\SurveyModel;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

/**
 * Description of AdminController
 *
 * @author user-98-pc
 */
class LandReservationController extends Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->data['pageHeading'] = 'Dashboard';
        $this->data['title'] = 'Dalmia-lams::Dashboard';
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $posted_data = $request->all();
        // t($posted_data, 1);
        $state_id = isset($posted_data['state_id']) ? $posted_data['state_id'] : '';
        $district_id = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
        $block_id = isset($posted_data['block_id']) ? $posted_data['block_id'] : '';
        $village_id = isset($posted_data['village']) ? $posted_data['village'] : '';

        $filter = isset($posted_data['filter']) ? $posted_data['filter'] : '';
        $context = isset($posted_data['context']) ? $posted_data['context'] : '';
        $dropdown = array('' => 'Select');
        $cond = '1=1';
        $this->data['filter'] = $filter;
        $this->data['breadcum'] = '';
        $total_area_cond = " 1 = 1";
        if (!empty($state_id) && empty($district_id) && empty($block_id) && empty($village_id)) {
            $finalcond = ['state_id' => $state_id];
            $total_area_cond .= " and state_id = '$state_id'";
            $this->data['state_id'] = $state_id;
        } elseif (!empty($state_id) && !empty($district_id) && empty($block_id) && empty($village_id)) {
            $finalcond = ['district_id' => $district_id];
            $total_area_cond .= " and  district_id = '$district_id'";
            $this->data['state_id'] = $state_id;
            $this->data['district_id'] = $district_id;
        } elseif (!empty($state_id) && empty($district_id) && !empty($block_id) && empty($village_id)) {
            $finalcond = ['block_id' => $block_id];
            $total_area_cond .= " and block_id = '$block_id'";
            $this->data['state_id'] = $state_id;
            $this->data['block_id'] = $block_id;
        } elseif (!empty($state_id) && !empty($district_id) && !empty($block_id) && empty($village_id)) {
            $finalcond = ['block_id' => $block_id];
            $total_area_cond .= " and block_id = '$block_id'";
            $this->data['state_id'] = $state_id;
            $this->data['district_id'] = $district_id;
            $this->data['block_id'] = $block_id;
        } elseif (!empty($state_id) && !empty($district_id) && !empty($block_id) && !empty($village_id)) {
            $finalcond = ['village_id' => $village_id];
            $total_area_cond .= " and village_id = '$village_id'";
            $this->data['state_id'] = $state_id;
            $this->data['district_id'] = $district_id;
            $this->data['block_id'] = $block_id;
            $this->data['village_id'] = $village_id;
        } elseif (!empty($state_id) && !empty($district_id) && empty($block_id) && !empty($village_id)) {
            $finalcond = ['village_id' => $village_id];
            $total_area_cond .= " and village_id = '$village_id'";
            $this->data['state_id'] = $state_id;
            $this->data['district_id'] = $district_id;
            $this->data['village_id'] = $village_id;
        } elseif (!empty($state_id) && empty($district_id) && empty($block_id) && !empty($village_id)) {
            $finalcond = ['village_id' => $village_id];
            $total_area_cond .= " and village_id = '$village_id'";
            $this->data['state_id'] = $state_id;
            //$this->data['district_id'] = $district_id;
            $this->data['village_id'] = $village_id;
        }

        if (!empty($state_id) && $context == '' && $filter == 'State') {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        } else if (!empty($state_id) && empty($district_id) && empty($context) && $filter == 'District') {

            return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if (!empty($state_id) && empty($district_id) && $context == '' && $filter == 'Block/Taluk') {
            return redirect('dashboard/block?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if (!empty($state_id) && empty($district_id) && $context == '' && $filter == 'Village') {
            return redirect('dashboard/block?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if (!empty($state_id) && !empty($district_id) && $context == '' && $filter == 'District') {
            return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if (empty($state_id) && !empty($district_id) && $context == '' && $filter == 'State') {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        }
        if (!empty($state_id) && !empty($district_id) && $context == '' && $filter == 'Block/Taluk') {
            return redirect('dashboard/block?state_id=' . $state_id . '&district_id=' . $district_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if (!empty($state_id) && !empty($district_id) && empty($block_id) && $context == '' && $filter == 'Village') {
            return redirect('dashboard/village?state_id=' . $state_id . '&district_id=' . $district_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if (!empty($state_id) && !empty($district_id) && !empty($block_id) && $context == '' && $filter == 'Village') {
            return redirect('dashboard/village?state_id=' . $state_id . '&district_id=' . $district_id . '&block_id=' . $block_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }

        //  $this->redirectToStateDistrictBlockWithFilter($state_id, $district_id, $block_id, $filter, $context);
        $assignStateDistrictLists = $this->assignStateDistrictLists($state_id);
        if ($context == 'reservation') {
            if ($this->user_type == 'admin') {
                $total_area_details = RegistrationModel::getTotalAreaCalculation($total_area_cond);
                $reservation_details = \App\Models\Transaction\LandReservationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as reservation_id_str")->where($finalcond)->get()->toArray();
            } else {
                if (!empty($state_id) && empty($district_id) && empty($block_id)) {
                    $total_area_cond .= " and  district_id in($assignStateDistrictLists)";
                    $reservation_details = \App\Models\Transaction\LandReservationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as reservation_id_str")->whereRaw("district_id in ($assignStateDistrictLists)")->get()->toArray();
                } else {
                    $reservation_details = \App\Models\Transaction\LandReservationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as reservation_id_str")->where($finalcond)->get()->toArray();
                }
                $total_area_details = RegistrationModel::getTotalAreaCalculation($total_area_cond);
            }
//            $registrations = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as reg_id_str")->whereRaw($total_area_cond)->get()->toArray();
//            $reg_id_str = isset($registrations[0]['reg_id_str']) ? $registrations[0]['reg_id_str'] : '';
            if ($reservation_details) {
                $reservation_id_str = isset($reservation_details[0]['reservation_id_str']) ? $reservation_details[0]['reservation_id_str'] : '';
                if ($reservation_id_str) {
                    $reservation_survey = \App\Models\Transaction\LandReservationSurveyModel::selectRaw("array_to_string(array_agg((survey_id)),',') as survey_id_str")->whereRaw("reservation_id in ($reservation_id_str)")->get()->toArray();
                    // t($reservation_survey, 1);
                    $survey_id_str = isset($reservation_survey[0]['survey_id_str']) ? $reservation_survey[0]['survey_id_str'] : '';
                }
            }
            if (isset($survey_id_str) && $survey_id_str) {
                $survey_total_area_details = $this->surveyTotalAreaDetails($survey_id_str);
              //  t($survey_total_area_details,1);
            }
        }
        $this->data['total_area_details'] = isset($total_area_details) ? $total_area_details : '';
        $this->data['survey_total_area_details'] = isset($survey_total_area_details) ? $survey_total_area_details : '';
        $this->data['context'] = $context;
        return view('admin.dashboard.context.reservation', $this->data);
    }

   public function assignStateDistrictLists($state_id = null) {

        if ($state_id) {
            $states = StateModel::whereRaw("id in ('$state_id')")->where(['fl_archive' => "N"])
                            ->with(['assignedDistricts' => function($query) {
                                    $query->selectRaw("array_to_string(array_agg(QUOTE_LITERAL(district_id)), ',') as dist_id_str,state_id")->groupBy('state_id');
                                }])->orderBy('state_name')->get()->toArray();
            $assignStateDistrictLists = isset($states[0]['assigned_districts'][0]['dist_id_str']) ? $states[0]['assigned_districts'][0]['dist_id_str'] : "";
            $assignStateDistrictLists = ($assignStateDistrictLists) ? DistrictModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as dist_id_str")
                            ->whereRaw(" id in ($assignStateDistrictLists)")->where(['fl_archive' => "N"])->get()->toArray() : '';
            return isset($assignStateDistrictLists[0]['dist_id_str']) ? $assignStateDistrictLists[0]['dist_id_str'] : "'1'";
        } else {
            return "'1'";
        }
    }

    public function surveyTotalAreaDetails($survey_id_str) {
        //CD00002
        $returnArray = [];
        if (!$survey_id_str) {
            return $returnArray;
        }
        $survey_id_arr = explode(",", $survey_id_str);
        // $survey_id_str = "'" . implode("','", $survey_id_arr) . "'";
        //  t($survey_id_arr, 1);
        $total_reserved_area_acre = 0;
        $total_reserved_area_hectare = 0;

        $total_unreserved_area_acre = 0;
        $total_unreserved_area_hectare = 0;

        foreach ($survey_id_arr as $key => $value) {
            $survey_info = SurveyModel::where(['id' => $value])->get()->toArray();
            $survey_info = isset($survey_info[0]) ? $survey_info[0] : '';
            //  t($survey_info);
            $reservation_status = isset($survey_info['land_reservation_status']) ? $survey_info['land_reservation_status'] : '';

            $area_unit = isset($survey_info['area_unit']) ? $survey_info['area_unit'] : '';
            $purchased_area = isset($survey_info['purchased_area']) ? $survey_info['purchased_area'] : '';

            if ($area_unit && $purchased_area) {
                $purchased_area_unit_value = \App\Models\Common\ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$area_unit", 'fl_archive' => 'N'])->get()->toArray();
                // t($purchased_area_unit_value);
                if ($reservation_status == 'Y') { //applied
                    if ($area_unit != 'CD00094') {
                        $total_reserved_area_acre += $purchased_area * $purchased_area_unit_value[0]['convers_value_acer'];
                    } else if ($area_unit == 'CD00094') {
                        $total_reserved_area_acre += $purchased_area;
                    }
                    if ($area_unit != 'CD00118') {
                        $total_reserved_area_hectare += $purchased_area * $purchased_area_unit_value[0]['convers_value_heactor'];
                    } else if ($area_unit == 'CD00118') {
                        $total_reserved_area_hectare += $purchased_area;
                    }
                }

                if ($reservation_status == 'N') { //obtained
                    if ($area_unit != 'CD00094') {
                        $total_unreserved_area_acre += $purchased_area * $purchased_area_unit_value[0]['convers_value_acer'];
                    } else if ($area_unit == 'CD00094') {
                        $total_unreserved_area_acre += $purchased_area;
                    }
                    if ($area_unit != 'CD00118') {
                        $total_unreserved_area_hectare += $purchased_area * $purchased_area_unit_value[0]['convers_value_heactor'];
                    } else if ($area_unit == 'CD00118') {
                        $total_unreserved_area_hectare += $purchased_area;
                    }
                }
            }
        }
        $returnArray['total_reserved_area_acre'] = $total_reserved_area_acre;
        $returnArray['total_reserved_area_hectare'] = $total_reserved_area_hectare;

        $returnArray['total_unreserved_area_acre'] = $total_unreserved_area_acre;
        $returnArray['total_unreserved_area_hectare'] = $total_unreserved_area_hectare;

        return $returnArray;
    }

}
