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
use App\Models\LandDetailsManagement\PaymentModel;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UtilityModel;

class CostDistributionController extends Controller {

    public function __construct() {
        parent:: __construct();
    }

    public function index(Request $request) {


        $posted_data = $request->all();


        $state_id = $posted_data['state_id'] ? "'" . implode("','", explode(',',$posted_data['state_id'])) . "'" : '';
        $district_id = $posted_data['district_id'] ? "'" . implode("','", explode(',',$posted_data['district_id'])) . "'" : '';
        $block_id = $posted_data['block_id'] ? "'" . implode("','", explode(',',$posted_data['block_id'])) . "'" : '';
        $village_id = $posted_data['village_id'] ? "'" . implode("','", explode(',',$posted_data['village_id'])) . "'" : '';

        $total_area_cond = " 1 = 1";
        if (!empty($state_id) && empty($district_id) && empty($block_id) && empty($village_id)) {
            $finalcond = ['state_id' => $state_id];
            $total_area_cond .= " and state_id in ($state_id)";
            $this->data['state_id'] = $state_id;
        } elseif (!empty($state_id) && !empty($district_id) && empty($block_id) && empty($village_id)) {
            $finalcond = ['district_id' => $district_id];
            $total_area_cond .= " and  district_id in ($district_id)";
            $this->data['state_id'] = $state_id;
            $this->data['district_id'] = $district_id;
        } elseif (!empty($state_id) && empty($district_id) && !empty($block_id) && empty($village_id)) {
            $finalcond = ['block_id' => $block_id];
            $total_area_cond .= " and block_id in ($block_id)";
            $this->data['state_id'] = $state_id;
            $this->data['block_id'] = $block_id;
        } elseif (!empty($state_id) && !empty($district_id) && !empty($block_id) && empty($village_id)) {
            $finalcond = ['block_id' => $block_id];
            $total_area_cond .= " and block_id in ($block_id)";
            $this->data['state_id'] = $state_id;
            $this->data['district_id'] = $district_id;
            $this->data['block_id'] = $block_id;
        } elseif (!empty($state_id) && !empty($district_id) && !empty($block_id) && !empty($village_id)) {
            $finalcond = ['village_id' => $village_id];
            $total_area_cond .= " and village_id in ($village_id)";
            $this->data['state_id'] = $state_id;
            $this->data['district_id'] = $district_id;
            $this->data['block_id'] = $block_id;
            $this->data['village_id'] = $village_id;
        } elseif (!empty($state_id) && !empty($district_id) && empty($block_id) && !empty($village_id)) {
            $finalcond = ['village_id' => $village_id];
            $total_area_cond .= " and village_id in ($village_id)";
            $this->data['state_id'] = $state_id;
            $this->data['district_id'] = $district_id;
            $this->data['village_id'] = $village_id;
        } elseif (!empty($state_id) && empty($district_id) && empty($block_id) && !empty($village_id)) {
            $finalcond = ['village_id' => $village_id];
            $total_area_cond .= " and village_id in ($village_id)";
            $this->data['state_id'] = $state_id;
            //$this->data['district_id'] = $district_id;
            $this->data['village_id'] = $village_id;
        }

        $assignStateDistrictLists = $this->assignStateDistrictLists($state_id);

        if ($this->user_type !== 'admin') {
            if (!empty($state_id) && empty($district_id) && empty($block_id) && empty($village_id)) {
                $total_area_cond .= " and  district_id in($assignStateDistrictLists)";
            }
        }
        $registrations = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as reg_id_str")->whereRaw($total_area_cond)->get()->toArray();
        $reg_id_str = isset($registrations[0]['reg_id_str']) ? $registrations[0]['reg_id_str'] : '';

        $this->data['getAllPaymentCostDistribution'] = $getAllPaymentCostDistribution = $this->getAllPaymentCostDistribution($reg_id_str);

        return view('admin.common.costdistribution', $this->data);

        //return $getAllPaymentCostDistribution;
    }

    public function assignStateDistrictLists($state_id = null) {

        if ($state_id) {
            $states = StateModel::whereRaw("id in ($state_id)")->where(['fl_archive' => "N"])
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

    public function getAllPaymentCostDistribution($reg_id_str = null) {

        if ($reg_id_str) {

            $allPaymentType = $this->getCodesDetails('payment_type');
            $resultArray = [];
            $allMisclleneousCost = 0;

            foreach ($allPaymentType as $key => $val) {
                if ($key == 'CD00027') {
                    $allPaymentDetails = PaymentModel::selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw("registration_id in ($reg_id_str)")->where(['pay_type' => $key])->get()->toArray();
                    $resultArray[$val] = isset($allPaymentDetails[0]['grand_total_tot_cost']) ? $allPaymentDetails[0]['grand_total_tot_cost'] : 0;
                } elseif ($key == 'CD00035') {
                    $allPaymentDetails = PaymentModel::selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw("registration_id in ($reg_id_str)")->where(['pay_type' => $key])->get()->toArray();
                    $resultArray[$val] = isset($allPaymentDetails[0]['grand_total_tot_cost']) ? $allPaymentDetails[0]['grand_total_tot_cost'] : 0;
                } elseif ($key == 'CD00566') {
                    $allPaymentDetails = PaymentModel::selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw("registration_id in ($reg_id_str)")->where(['pay_type' => $key])->get()->toArray();
                    $resultArray[$val] = isset($allPaymentDetails[0]['grand_total_tot_cost']) ? $allPaymentDetails[0]['grand_total_tot_cost'] : 0;
                } elseif ($key == 'CD00029') {
                    $allPaymentDetails = PaymentModel::selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw("registration_id in ($reg_id_str)")->where(['pay_type' => $key])->get()->toArray();
                    $resultArray[$val] = isset($allPaymentDetails[0]['grand_total_tot_cost']) ? $allPaymentDetails[0]['grand_total_tot_cost'] : 0;
                } elseif ($key == 'CD00030') {
                    $allPaymentDetails = PaymentModel::selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw("registration_id in ($reg_id_str)")->where(['pay_type' => $key])->get()->toArray();
                    $resultArray[$val] = isset($allPaymentDetails[0]['grand_total_tot_cost']) ? $allPaymentDetails[0]['grand_total_tot_cost'] : 0;
                } elseif ($key == 'CD00039') {
                    $allPaymentDetails = PaymentModel::selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw("registration_id in ($reg_id_str)")->where(['pay_type' => $key])->get()->toArray();
                    $resultArray[$val] = isset($allPaymentDetails[0]['grand_total_tot_cost']) ? $allPaymentDetails[0]['grand_total_tot_cost'] : 0;
                } elseif ($key == 'CD00297') {
                    $allPaymentDetails = PaymentModel::selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw("registration_id in ($reg_id_str)")->where(['pay_type' => $key])->get()->toArray();
                    $resultArray[$val] = isset($allPaymentDetails[0]['grand_total_tot_cost']) ? $allPaymentDetails[0]['grand_total_tot_cost'] : 0;
                } else {
                    $allPaymentDetails = PaymentModel::selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw("registration_id in ($reg_id_str)")->where(['pay_type' => $key])->get()->toArray();
                    $allMisclleneousCost = $allMisclleneousCost + $allPaymentDetails[0]['grand_total_tot_cost'];
                    $resultArray['Misclleneous Chargers'] = $allMisclleneousCost;
                }
            }

            return array_reverse($resultArray);
        } else {
            return "";
        }
    }

}
