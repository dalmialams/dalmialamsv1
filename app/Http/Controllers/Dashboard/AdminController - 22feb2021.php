<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Dashboard;

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
use Illuminate\Support\Facades\Input;

/**
 * Description of AdminController
 *
 * @author user-98-pc
 */
class AdminController extends Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->data['pageHeading'] = 'Dashboard';
        $this->data['title'] = 'LMS Dashboard';
        $this->middleware('auth');
    }

    public function landingPage() {

        $this->data['pageHeading'] = '';
        return view('admin.dashboard.landing', $this->data);
    }

    public function index(Request $request) {
		DB::enableQueryLog();
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $this->data['data']['cssArr'][] = 'assets/css/jquery.contextMenu.css';

        $this->data['data']['jsArr'][] = 'assets/js/jquery.contextMenu.js';
//        $this->data['data']['jsArr'][] = 'jassets/js/query.ui.position.min.js';

        $posted_data = $request->all();
		$type='';
        $filter_data = '';
        if (isset($posted_data['filter'])) {
            $filter_data = $posted_data['filter'];
            $this->data['filter'] = $filter_data;
        } else {
            $this->data['filter'] = $filter_data;
        }
		if (isset($posted_data['type'])) {
            $type = $posted_data['type'];
            $this->data['type'] = $type;
        } else {
            $this->data['type'] = $type;
        }
		$where='';
		if($type =='leased')
		{
			$where .=" and purchase_type_id='CD00144'";
		}
		else if($type =='purchased')
		{
			$where .=" and purchase_type_id !='CD00144'";
		}
		else
		{
			$where .="and purchase_type_id !=''";
		}
//t($this->assigned_states,1);
        if ($this->user_type !== 'admin') {
            if (isset($this->assigned_states) && !empty($this->assigned_states)) {
                $assigned_states = $this->assigned_states;
                $assigned_states = explode(",", $assigned_states);
                $state_str = "'" . implode("','", $assigned_states) . "'";
                $states = StateModel::whereRaw("id in ($state_str)")->where(['fl_archive' => "N"])
                                ->with(['assignedDistricts' => function($query) {
                                        $query->selectRaw("array_to_string(array_agg(QUOTE_LITERAL(district_id)), ',') as dist_id_str,state_id")->groupBy('state_id');
                                    }])->orderBy('state_name')->get()->toArray();
            //t($states ,1);
			} else {
                $states = '';
            }
        } else {
            $states = StateModel::where(['fl_archive' => "N"])->orderBy('state_name')->get()->toArray();
        }
		
        //t($purchase_type, 1);
        $cond = '1=1';
        $grand_total_cost_all = 0;
        if ($states) {
            foreach ($states as $key => $val) {
                $assigned_districts = isset($val['assigned_districts'][0]['dist_id_str']) ? $val['assigned_districts'][0]['dist_id_str'] : "";
                
                if ($this->user_type !== 'admin') {
					$assignStateDistrictLists = ($assigned_districts) ? DistrictModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as dist_id_str")
                                ->whereRaw(" id in ($assigned_districts)")->where(['fl_archive' => "N"])->get()->toArray() : '';
					$assigned_districts = isset($assignStateDistrictLists[0]['dist_id_str']) ? $assignStateDistrictLists[0]['dist_id_str'] : "'1'";
                    $finalcond = $cond . " AND state_id = '{$val['id']}' and district_id in($assigned_districts)".$where;
                } else {
					$assignStateDistrictLists = DistrictModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as dist_id_str")->where(['fl_archive' => "N"])->get()->toArray();
					$assigned_districts = isset($assignStateDistrictLists[0]['dist_id_str']) ? $assignStateDistrictLists[0]['dist_id_str'] : "'1'";
                    $finalcond = $cond . " AND state_id = '{$val['id']}' and district_id in($assigned_districts)".$where;
                }
				
                //  $grand_total_tot_area = $this->getTotalAreaCalculation($finalcond);
                $grand_total_tot_area = RegistrationModel::getTotalAreaCalculation($finalcond);
                $grand_total_tot_cost = RegistrationModel::join('PAYMENT','PAYMENT.registration_id','=',"REGISTRATION.id",'left')->selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw($finalcond)->get()->toArray();
				//dd(DB::getQueryLog());
                $states[$key]['grand_total_tot_area_acer'] = $grand_total_tot_area['grand_total_tot_area_acer'];
                $states[$key]['grand_total_tot_area_hector'] = $grand_total_tot_area['grand_total_tot_area_hector'];
                $states[$key]['grand_total_tot_cost'] = $grand_total_tot_cost[0]['grand_total_tot_cost'];
                $grand_total_cost_all += $grand_total_tot_cost[0]['grand_total_tot_cost'];
            }
        }
       // t($states,1);
        //t($states);die();
        $this->data['states'] = $states;
        $this->data['grand_total_cost_all'] = isset($grand_total_cost_all) ? $grand_total_cost_all : '';
		//t($grand_total_cost_all,1);
        return view('admin.dashboard.index', $this->data);
    }

    public function getTotalAreaCalculation($cond) {
        //echo $cond;
        //echo '<br>';
        $grand_total_tot_area = RegistrationModel::whereRaw($cond)->get()->toArray();
        $tot_area_unit_value_acer = 0;
        $tot_area_unit_value_hector = 0;
        $returnArray = [];
        foreach ($grand_total_tot_area as $key => $value) {

            $tot_area_unit = isset($value['tot_area_unit']) ? $value['tot_area_unit'] : '';
            $total_area = isset($value['tot_area']) ? $value['tot_area'] : '';

            if ($tot_area_unit && $total_area) {
                $tot_area_unit_value = ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();


                if ($tot_area_unit != 'CD00094') {
                    $tot_area_unit_value_acer += $total_area * $tot_area_unit_value[0]['convers_value_acer'];
                } else if ($tot_area_unit == 'CD00094') {
                    $tot_area_unit_value_acer += $total_area;
                }
                if ($tot_area_unit != 'CD00118') {
                    $tot_area_unit_value_hector += $total_area * $tot_area_unit_value[0]['convers_value_heactor'];
                } else if ($tot_area_unit == 'CD00118') {
                    $tot_area_unit_value_hector += $total_area;
                }

                //$tot_area_unit_value_acer += $value['tot_area'] * $tot_area_unit_value[0]['convers_value_acer'];
                //$tot_area_unit_value_hector += $value['tot_area'] * $tot_area_unit_value[0]['convers_value_heactor'];
            }
        }
        $returnArray['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
        $returnArray['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;

        return $returnArray;
    }

    public function dashboardView(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        $this->data['data']['cssArr'][] = 'assets/css/jquery.contextMenu.css';

        $this->data['data']['jsArr'][] = 'assets/js/jquery.contextMenu.js';
        //$this->data['data']['jsArr'][] = 'jassets/js/query.ui.position.min.js';

        $posted_data = $request->all();

        $state_id = isset($posted_data['state_id']) ? $posted_data['state_id'] : '';
        $district_id = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
        $block_id = isset($posted_data['block_id']) ? $posted_data['block_id'] : '';
        $village_id = isset($posted_data['village_id']) ? $posted_data['village_id'] : '';

        $filter = $posted_data['filter'];

        $dropdown = array('' => 'Select');
//t($_REQUEST);
//die();
        $cond = '1=1';
        if (isset($filter) && $filter != '') {
            if ($filter == 'State' && !empty($state_id) && empty($district_id) && empty($block_id) && empty($village_id)) {
                if ($this->user_type == 'admin') {
                    $allRecordIds = StateModel::where(['fl_archive' => "N", 'id' => $state_id])->orderBy('state_name')->get()->toArray();
                } else {
                    $allRecordIds = StateModel::where(['fl_archive' => "N", 'id' => $state_id])->with(['assignedDistricts' => function($query) {
                                    $query->selectRaw("array_to_string(array_agg(QUOTE_LITERAL(district_id)), ',') as dist_id_str,state_id")->groupBy('state_id');
                                }])->orderBy('state_name')->get()->toArray();
                }
                $cond.= ' AND state_id =';
                $this->data['id'] = $state_id;
            } elseif ($filter == 'State' && !empty($state_id) && empty($district_id) && empty($block_id) && empty($village_id)) {
                return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
            } elseif ($filter == 'State' && !empty($state_id) && !empty($district_id) && empty($block_id) && empty($village_id)) {
                return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
            } elseif ($filter == 'State' && !empty($state_id) && !empty($district_id) && !empty($block_id) && empty($village_id)) {
                return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
            } elseif ($filter == 'State' && !empty($state_id) && !empty($district_id) && !empty($block_id) && !empty($village_id)) {
                return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
            }
            if ($filter == 'District' && !empty($state_id) && !empty($district_id) && empty($block_id) && empty($village_id)) {

                $allRecordIds = DistrictModel::where(['fl_archive' => "N", 'id' => $district_id])->orderBy('district_name')->get()->toArray();
                $cond.= ' AND district_id =';
                $this->data['id'] = $district_id;
            } elseif ($filter == 'District' && !empty($state_id) && empty($district_id) && empty($block_id) && empty($village_id)) {
                return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
            } elseif ($filter == 'District' && !empty($state_id) && !empty($district_id) && !empty($block_id) && empty($village_id)) {
                return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
            } elseif ($filter == 'District' && !empty($state_id) && !empty($district_id) && !empty($block_id) && !empty($village_id)) {
                return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
            }
            if ($filter == 'Block/Taluk' && !empty($state_id) && empty($district_id) && empty($block_id) && empty($village_id)) {

                return redirect('dashboard/block?state_id=' . $state_id . '&district_id=' . $district_id . '&filter=' . $filter);
            } else if ($filter == 'Block/Taluk' && !empty($state_id) && !empty($district_id) && !empty($block_id) && empty($village_id)) {

                $allRecordIds = BlockModel::where(['fl_archive' => "N", 'id' => $block_id])->orderBy('block_name')->get()->toArray();
//               echo  $allRecordIds = BlockModel::where(['fl_archive' => "N", 'id' => $block_id])->orderBy('block_name')->toSql();
                $cond.= ' AND block_id =';
                $this->data['id'] = $block_id;
            } elseif ($filter == 'Block/Taluk' && !empty($state_id) && !empty($district_id) && empty($block_id) && empty($village_id)) {

                return redirect('dashboard/block?state_id=' . $state_id . '&district_id=' . $district_id . '&filter=' . $filter)/* ->with('message', $msg) */;
            } elseif ($filter == 'Block/Taluk' && !empty($state_id) && !empty($district_id) && !empty($block_id) && !empty($village_id)) {

                return redirect('dashboard/block?state_id=' . $state_id . '&district_id=' . $district_id . '&filter=' . $filter)/* ->with('message', $msg) */;
            }
            if ($filter == 'Village' && !empty($state_id) && !empty($district_id) && !empty($block_id) && !empty($village_id)) {

                $allRecordIds = VillageModel::where(['fl_archive' => "N", 'id' => $village_id])->orderBy('village_name')->get()->toArray();
//               echo  $allRecordIds = BlockModel::where(['fl_archive' => "N", 'id' => $block_id])->orderBy('block_name')->toSql();
                $cond.= ' AND village_id =';
                $this->data['id'] = $village_id;
            } elseif ($filter == 'Village' && !empty($state_id) && !empty($district_id) && empty($block_id) && empty($village_id)) {

                return redirect('dashboard/village?state_id=' . $state_id . '&district_id=' . $district_id . '&block_id=' . $block_id . '&filter=' . $filter)/* ->with('message', $msg) */;
            } elseif ($filter == 'Village' && !empty($state_id) && !empty($district_id) && !empty($block_id) && empty($village_id)) {

                return redirect('dashboard/village?state_id=' . $state_id . '&district_id=' . $district_id . '&block_id=' . $block_id . '&filter=' . $filter)/* ->with('message', $msg) */;
            }
        }

        //   t($allRecordIds);
        $grand_total_cost_all = '';

        foreach ($allRecordIds as $key => $val) {
            $assigned_districts = isset($val['assigned_districts'][0]['dist_id_str']) ? $val['assigned_districts'][0]['dist_id_str'] : "'1'";
            if ($this->user_type !== 'admin') {
                if ($assigned_districts !== "'1'") {
                    $finalcond = $cond . "'{$val['id']}' and district_id in ($assigned_districts)";
                } else {
                    $finalcond = $cond . "'{$val['id']}'";
                }
            } else {
                $finalcond = $cond . "'{$val['id']}'";
            }
            $grand_total_tot_area = $this->getTotalAreaCalculation($finalcond);

            $grand_total_tot_cost = RegistrationModel::selectRaw('sum(tot_cost) as grand_total_tot_cost')->whereRaw($finalcond)->get()->toArray();

            $allRecordIds[$key]['grand_total_tot_area_acer'] = $grand_total_tot_area['grand_total_tot_area_acer'];
            $allRecordIds[$key]['grand_total_tot_area_hector'] = $grand_total_tot_area['grand_total_tot_area_hector'];
            $allRecordIds[$key]['grand_total_tot_cost'] = $grand_total_tot_cost[0]['grand_total_tot_cost'];
            $grand_total_cost_all += $grand_total_tot_cost[0]['grand_total_tot_cost'];
        }


        $RegDataWithState = $allRecordIds;
//        t($RegDataWithState);die();
//        t($RegDataWithState);
        $this->data['RegDataWithState'] = $RegDataWithState;
        $this->data['grand_total_cost_all'] = $grand_total_cost_all;
        $this->data['breadcum'] = '';
        $this->data['filter'] = $filter;
        $this->data['state_id'] = $state_id;
        $this->data['district_id'] = $district_id;
        $this->data['block_id'] = $block_id;
        $this->data['village_id'] = $village_id;

        return view('admin.dashboard.details', $this->data);
    }

    public function classification(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';


        $posted_data = $request->all();

        $state_id = isset($posted_data['state_id']) ? $posted_data['state_id'] : '';
        $district_id = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
        $block_id = isset($posted_data['block_id']) ? $posted_data['block_id'] : '';
        $village_id = isset($posted_data['village']) ? $posted_data['village'] : '';
        $filter = isset($posted_data['filter']) ? $posted_data['filter'] : '';
        $context = isset($posted_data['context']) ? $posted_data['context'] : '';

        $dropdown = array('' => 'Select');

        $cond = '1=1';

//        t($posted_data,1);
        $this->data['filter'] = $filter;

        $cond = '1=1';
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

//        t($_REQUEST,1);
        if (!empty($state_id) && $context == '' && $filter == 'State') {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        } else if (!empty($state_id) && empty($district_id) && $context == '' && $filter == 'District') {
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

        $assignStateDistrictLists = $this->assignStateDistrictLists($state_id);

        if ($context == 'classification') {

            $allCllasificationData = SurveyModel::whereHas('getRegistration', function ($query) use ($finalcond) {
                        $query->where($finalcond);
                    })->groupBy('classification')->select('classification')->get()->toArray();


            if ($this->user_type != 'admin') {
                if (!empty($state_id) && empty($district_id) && empty($block_id)) {
                    $total_area_cond .= " and  district_id in($assignStateDistrictLists)";
                }
            }
            $registrations = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as reg_id_str")->whereRaw($total_area_cond)->get()->toArray();
            $reg_id_str = isset($registrations[0]['reg_id_str']) ? $registrations[0]['reg_id_str'] : '';

            $grand_total_cost_all = 0;
            $indivisualTotal = [];
            foreach ($allCllasificationData as $key => $value) {

                $indivisualCllasification = SurveyModel::where(['classification' => $value['classification']])->whereRaw("registration_id in ($reg_id_str)")->get()->toArray();
                $RegDataWithState = [];
                $tot_area_unit_value_acer = 0;
                $tot_area_unit_value_hector = 0;
                $grand_total_tot_cost = 0;

                foreach ($indivisualCllasification as $k => $val) {

                    if (!empty($val)) {


                        $tot_area_unit = $val['area_unit'];
                        $tot_area_unit_value = ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();
                        // t($tot_area_unit_value,1);
                        if ($val['area_unit'] != 'CD00094')
                            $tot_area_unit_value_acer += $val['total_area'] * $tot_area_unit_value[0]['convers_value_acer'];
                        elseif ($val['area_unit'] == 'CD00094')
                            $tot_area_unit_value_acer += $val['total_area'];

                        if ($val['area_unit'] != 'CD00118')
                            $tot_area_unit_value_hector += $val['total_area'] * $tot_area_unit_value[0]['convers_value_heactor'];
                        elseif ($val['area_unit'] == 'CD00118')
                            $tot_area_unit_value_hector += $val['total_area'];

                        $grand_total_tot_cost += $val['unit_cost'] * $val['total_area'];
                    }
                }

                $indivisualTotal[$key]['id'] = $val['classification'];
                $indivisualTotal[$key]['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
                $indivisualTotal[$key]['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;
                $indivisualTotal[$key]['grand_total_tot_cost'] = $grand_total_tot_cost;
                $grand_total_cost_all += $grand_total_tot_cost;
//                t($indivisualTotal,1);
            }
        }

        //t($RegDataWithState);
        $this->data['RegDataWithState'] = $indivisualTotal;
        $this->data['context'] = $context;
        $this->data['dropdown'] = $dropdown;
        $this->data['grand_total_cost_all'] = isset($grand_total_cost_all) ? $grand_total_cost_all : '';
        return view('admin.dashboard.context.classification', $this->data);
    }

    public function purpose(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';


        $posted_data = $request->all();

        $state_id = isset($posted_data['state_id']) ? $posted_data['state_id'] : '';
        $district_id = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
        $block_id = isset($posted_data['block_id']) ? $posted_data['block_id'] : '';
        $village_id = isset($posted_data['village']) ? $posted_data['village'] : '';

        $filter = isset($posted_data['filter']) ? $posted_data['filter'] : '';
        $context = isset($posted_data['context']) ? $posted_data['context'] : '';

        $dropdown = array('' => 'Select');

        $cond = '1=1';

//        t($posted_data,1);
        $this->data['filter'] = $filter;

        $cond = '1=1';
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

//        t($_REQUEST,1);
        if (!empty($state_id) && $context == '' && $filter == 'State') {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        } else if (!empty($state_id) && empty($district_id) && $context == '' && $filter == 'District') {
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

        $assignStateDistrictLists = $this->assignStateDistrictLists($state_id);

        if ($context == 'purpose') {

            $allPurposeData = SurveyModel::whereHas('getRegistration', function ($query) use ($finalcond) {
                        $query->where($finalcond);
                    })->groupBy('purpose')->select('purpose')->get()->toArray();

            if ($this->user_type != 'admin') {
                if (!empty($state_id) && empty($district_id) && empty($block_id)) {
                    $total_area_cond .= " and  district_id in($assignStateDistrictLists)";
                }
            }
            $registrations = RegistrationModel::selectRaw("array_to_string(array_agg(QUOTE_LITERAL(id)), ',') as reg_id_str")->whereRaw($total_area_cond)->get()->toArray();
            $reg_id_str = isset($registrations[0]['reg_id_str']) ? $registrations[0]['reg_id_str'] : '';


            $grand_total_cost_all = 0;
            $indivisualTotal = [];
            foreach ($allPurposeData as $key => $value) {

                $indivisualPurpose = SurveyModel::where(['purpose' => $value['purpose']])->whereRaw("registration_id in ($reg_id_str)")->get()->toArray();
                $RegDataWithState = [];
                $tot_area_unit_value_acer = 0;
                $tot_area_unit_value_hector = 0;
                $grand_total_tot_cost = 0;

                foreach ($indivisualPurpose as $k => $val) {

                    if (!empty($val)) {


                        $tot_area_unit = $val['area_unit'];
                        $tot_area_unit_value = ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();
                        // t($tot_area_unit_value,1);
                        if ($val['area_unit'] != 'CD00094')
                            $tot_area_unit_value_acer += $val['total_area'] * $tot_area_unit_value[0]['convers_value_acer'];
                        elseif ($val['area_unit'] == 'CD00094')
                            $tot_area_unit_value_acer += $val['total_area'];

                        if ($val['area_unit'] != 'CD00118')
                            $tot_area_unit_value_hector += $val['total_area'] * $tot_area_unit_value[0]['convers_value_heactor'];
                        elseif ($val['area_unit'] == 'CD00118')
                            $tot_area_unit_value_hector += $val['total_area'];


                        $grand_total_tot_cost += $val['unit_cost'] * $val['total_area'];
                    }
                }

                $indivisualTotal[$key]['id'] = $val['purpose'];
                $indivisualTotal[$key]['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
                $indivisualTotal[$key]['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;
                $indivisualTotal[$key]['grand_total_tot_cost'] = $grand_total_tot_cost;
                $grand_total_cost_all += $grand_total_tot_cost;
//                t($indivisualTotal,1);
            }
        }

        //t($RegDataWithState);
        $this->data['RegDataWithState'] = $indivisualTotal;
        $this->data['context'] = $context;
        $this->data['dropdown'] = $dropdown;
        $this->data['grand_total_cost_all'] = isset($grand_total_cost_all) ? $grand_total_cost_all : '';
        return view('admin.dashboard.context.purpose', $this->data);
    }

    public function purchaseType(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';


        $posted_data = $request->all();

        $state_id = isset($posted_data['state_id']) ? $posted_data['state_id'] : '';
        $district_id = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
        $block_id = isset($posted_data['block_id']) ? $posted_data['block_id'] : '';
        $village_id = isset($posted_data['village']) ? $posted_data['village'] : '';

        $filter = isset($posted_data['filter']) ? $posted_data['filter'] : '';
        $context = isset($posted_data['context']) ? $posted_data['context'] : '';

        $dropdown = array('' => 'Select');

        $cond = '1=1';

//        t($posted_data,1);
        $this->data['filter'] = $filter;

        $cond = '1=1';
        $this->data['breadcum'] = '';

//t($posted_data,1);

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

//        t($_REQUEST,1);
        if (!empty($state_id) && $context == '' && $filter == 'State') {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        } else if (!empty($state_id) && empty($district_id) && $context == '' && $filter == 'District') {
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

        $assignStateDistrictLists = $this->assignStateDistrictLists($state_id);

        if ($context == 'purchaseType') {

            $allPurchaseTypeData = RegistrationModel::select('purchase_type_id')->groupBy('purchase_type_id')->get()->toArray();

            if ($this->user_type != 'admin') {
                if (!empty($state_id) && empty($district_id) && empty($block_id) && empty($village_id)) {
                    $total_area_cond .= " and  district_id in($assignStateDistrictLists)";
                }
            }

            $grand_total_cost_all = 0;
            $indivisualTotal = [];
            foreach ($allPurchaseTypeData as $key => $value) {

                $indivisualPurchaseType = RegistrationModel::where(['purchase_type_id' => $value['purchase_type_id']])->whereRaw($total_area_cond)->get()->toArray();
                $RegDataWithState = [];
                $tot_area_unit_value_acer = 0;
                $tot_area_unit_value_hector = 0;
                $grand_total_tot_cost = 0;
//                t($indivisualPurchaseType,1);
                foreach ($indivisualPurchaseType as $k => $val) {

                    if (!empty($val)) {

                        $state_id = isset($val['state_id']) ? $val['state_id'] : '';
                        $is_archived = \App\Models\Common\StateModel::where(['id' => $state_id])->value('fl_archive');
                        if ($is_archived == 'N') {

                            $tot_area_unit = $val['tot_area_unit'];
                            $tot_area_unit_value = ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();
                            // t($tot_area_unit_value,1);
                            if ($val['tot_area_unit'] != 'CD00094')
                                $tot_area_unit_value_acer += $val['tot_area'] * $tot_area_unit_value[0]['convers_value_acer'];
                            elseif ($val['tot_area_unit'] == 'CD00094')
                                $tot_area_unit_value_acer += $val['tot_area'];

                            if ($val['tot_area_unit'] != 'CD00118')
                                $tot_area_unit_value_hector += $val['tot_area'] * $tot_area_unit_value[0]['convers_value_heactor'];
                            elseif ($val['tot_area_unit'] == 'CD00118')
                                $tot_area_unit_value_hector += $val['tot_area'];

                            $grand_total_tot_cost += $val['tot_cost'];
                        }
                    }
                }

                $indivisualTotal[$key]['id'] = isset($val['purchase_type_id']) ? $val['purchase_type_id'] : '';
                $indivisualTotal[$key]['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
                $indivisualTotal[$key]['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;
                $indivisualTotal[$key]['grand_total_tot_cost'] = $grand_total_tot_cost;
                $grand_total_cost_all += $grand_total_tot_cost;
//                t($indivisualTotal,1);
            }
        }

        //t($RegDataWithState);
        $this->data['RegDataWithState'] = $indivisualTotal;
        $this->data['context'] = $context;
        $this->data['dropdown'] = $dropdown;
        $this->data['grand_total_cost_all'] = isset($grand_total_cost_all) ? $grand_total_cost_all : '';
        return view('admin.dashboard.context.purchaseType', $this->data);
    }

    public function dashboardTotal(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        $posted_data = $request->all();
        $state_id = isset($posted_data['state_id']) ? $posted_data['state_id'] : '';
        $district_id = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
        $block_id = isset($posted_data['block_id']) ? $posted_data['block_id'] : '';
        $legal_id = isset($posted_data['legal_id']) ? $posted_data['legal_id'] : '';
        $legal_blk_id = isset($posted_data['legal_blk_id']) ? $posted_data['legal_blk_id'] : '';
        $filter = $posted_data['filter'];

        $cond = '1=1';
        if ($filter == 'District') {
            $cond .= " AND district_id <> '' ";
            $select = 'district_name';
            $RegDataWithState = DistrictModel::where(['fl_archive' => "N"])->orderBy('district_name')->lists($select, 'id')->toArray();
        }
        if ($filter == 'Legal Entity') {
            $cond .= " AND legal_entity <> '' ";
            $select = 'legal_entity';
            $RegDataWithState = CodeModel::where(['cd_type' => "legal_entity", 'cd_fl_archive' => 'N'])->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
        }
        if ($filter == 'Plot Type') {
            $cond .= " AND plot_type_id <> '' ";
            $select = 'plot_type_id';
            $RegDataWithState = CodeModel::where(['cd_type' => "plot_type", 'cd_fl_archive' => 'N'])->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
        }
        if ($filter == 'Block/Taluk') {
            $cond .= " AND block_id <> '' ";
            $select = 'block_name';
            $RegDataWithState = BlockModel::where(['fl_archive' => "N"])->orderBy('block_name')->lists($select, 'id')->toArray();
        }
        if ($filter == 'Purchase Type') {
            $cond .= " AND purchase_type_id <> '' ";
            $select = 'purchase_type_id';
            $RegDataWithState = CodeModel::where(['cd_type' => "purchase_type", 'cd_fl_archive' => 'N'])->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
        }
        if ($filter == 'Purchasing Team') {
            $cond .= " AND purchasing_team_id <> '' ";
            $select = 'purchasing_team_id';
            $RegDataWithState = CodeModel::where(['cd_type' => "purchasing_team", 'cd_fl_archive' => 'N'])->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
        }
        if ($filter == 'Purpose') {
            $cond .= " AND land_usage <> '' ";
            $select = 'land_usage';
            $allPurpose = CodeModel::where(['cd_type' => "land_usage", 'cd_fl_archive' => 'N'])->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
        }
        if ($filter == 'Classification') {
            $cond .= " AND plot_classification <> '' ";
            $select = 'land_usage';
            $allPurpose = CodeModel::where(['cd_type' => "plot_classification", 'cd_fl_archive' => 'N'])->orderBy('cd_desc')->lists('cd_desc', 'id')->toArray();
        }



        if ($state_id) {
            $cond = $cond . " AND state_id = '$state_id'";
            $whereRaw = ' "T_REGISTRATION"."state_id" = ' . "'" . $state_id . "'";
            $this->data['state_id'] = $state_id;
            $state_name = StateModel::where(['id' => "$state_id"])->value('state_name');
            $breadcum = "<li><a href='" . url("dashboard?filter=$filter") . "'>$state_name</a></li>";
            $this->data['breadcum'] = $breadcum;
        } elseif ($district_id) {
            $cond = $cond . " AND district_id = '$district_id'";
            $whereRaw = ' "T_REGISTRATION"."district_id" = ' . "'" . $district_id . "'";
            $this->data['district_id'] = $district_id;
            $district_name = DistrictModel::select('district_name', 'state_id')->where(['id' => "$district_id"])->get()->toArray();
            $state_name = StateModel::where(['id' => "{$district_name[0]['state_id']}"])->value('state_name');

            $breadcum = "<li><a href='" . url("dashboard?filter=$filter") . "'>$state_name</a></li>";
            $breadcum .= "<li><a href='" . url("dashboard/district?state_id=" . $district_name[0]['state_id'] . "&filter=$filter") . "'>" . $district_name[0]['district_name'] . "</a></li>";
            $this->data['breadcum'] = $breadcum;
        } elseif ($block_id) {

            $cond = $cond . " AND block_id = '$block_id'";
            $whereRaw = ' "T_REGISTRATION"."block_id" = ' . "'" . $block_id . "'";
            $this->data['block_id'] = $block_id;
            $block_name = BlockModel::select('block_name', 'district_id')->where(['id' => "$block_id"])->get()->toArray();
            $district_name_array = DistrictModel::select('district_name', 'state_id')->where(['id' => "{$block_name[0]['district_id']}"])->get()->toArray();
            $district_name = $district_name_array[0]['district_name'];
            $state_name = StateModel::where(['id' => "{$district_name_array[0]['state_id']}"])->value('state_name');

            $breadcum = "<li><a href='" . url("dashboard?filter=$filter") . "'>$state_name</a></li>";
            $breadcum .= "<li><a href='" . url("dashboard/district?state_id=" . $district_name_array[0]['state_id'] . "&filter=$filter") . "'>" . $district_name_array[0]['district_name'] . "</a></li>";
            $breadcum .= "<li><a href='" . url("dashboard/block?district_id=" . $block_name[0]['district_id'] . "&filter=$filter") . "'>" . $block_name[0]['block_name'] . "</a></li>";
            $this->data['breadcum'] = $breadcum;
        } elseif ($legal_id) {

            $cond = $cond . " AND block_id = '$legal_blk_id' AND legal_entity = '$legal_id'";
            $whereRaw = ' "T_REGISTRATION"."legal_entity" = ' . "'" . $legal_id . "'" . ' AND "T_REGISTRATION"."block_id" = ' . "'" . $legal_blk_id . "'";
            $this->data['legal_id'] = $legal_id;
            $this->data['legal_blk_id'] = $legal_blk_id;

            $legal_name = CodeModel::where(['id' => "$legal_id"])->value('cd_desc');
            $block_name = BlockModel::select('block_name', 'district_id')->where(['id' => "$legal_blk_id"])->get()->toArray();
            $district_name_array = DistrictModel::select('district_name', 'state_id')->where(['id' => "{$block_name[0]['district_id']}"])->get()->toArray();
            $district_name = $district_name_array[0]['district_name'];
            $state_name = StateModel::where(['id' => "{$district_name_array[0]['state_id']}"])->value('state_name');

            $breadcum = "<li><a href='" . url("dashboard?filter=$filter") . "'>$state_name</a></li>";
            $breadcum .= "<li><a href='" . url("dashboard/district?state_id=" . $district_name_array[0]['state_id'] . "&filter=$filter") . "'>" . $district_name_array[0]['district_name'] . "</a></li>";
            $breadcum .= "<li><a href='" . url("dashboard/block?district_id=" . $block_name[0]['district_id'] . "&filter=$filter") . "'>" . $block_name[0]['block_name'] . "</a></li>";
            $breadcum .= "<li><a href='" . url("dashboard/block?block_id=" . $legal_blk_id . "&filter=$filter") . "'>" . $legal_name . "</a></li>";
            $this->data['breadcum'] = $breadcum;
        }


        if ($filter == 'Purpose' || $filter == 'Classification') {

            $allSurveyData = [];
            foreach ($allPurpose as $key => $val) {

                if (!empty($key)) {
                    if ($filter == 'Purpose') {
                        $whereRawCode = ' "T_SURVEY"."purpose" = ' . "'" . $key . "'";
                    } elseif ($filter == 'Classification') {
                        $whereRawCode = ' "T_SURVEY"."classification" = ' . "'" . $key . "'";
                    }
                    if ($state_id || $district_id || $block_id || $legal_id) {
                        $surveyDataArray = DB::table('REGISTRATION')
                                ->join('SURVEY', 'REGISTRATION.id', '=', 'SURVEY.registration_id')
                                ->select('SURVEY.*')
                                ->whereRaw($whereRaw)
                                ->whereRaw($whereRawCode)
                                ->get();

                        $allSurveyData[$key] = $surveyDataArray;
                    } else {
                        $surveyDataArray = DB::table('REGISTRATION')
                                ->join('SURVEY', 'REGISTRATION.id', '=', 'SURVEY.registration_id')
                                ->select('SURVEY.*')
                                ->whereRaw($whereRawCode)
                                ->get();

                        $allSurveyData[$key] = $surveyDataArray;
                    }
                }
            }

            $allSurveyData = json_decode(json_encode((array) $allSurveyData), true);
            //t($allSurveyData,1);
            $RegDataWithState = [];
            $grand_total_cost_all = 0;
            foreach ($allSurveyData as $key => $val) {
                if (!empty($val)) {
                    $tot_area_unit_value_acer = 0;
                    $tot_area_unit_value_hector = 0;
                    $grand_total_tot_cost = 0;
                    foreach ($val as $k => $v) {
                        $tot_area_unit = $v['area_unit'];
                        $tot_area_unit_value = ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();
                        $tot_area_unit_value_acer += $v['total_area'] * $tot_area_unit_value[0]['convers_value_acer'];
                        $tot_area_unit_value_hector += $v['total_area'] * $tot_area_unit_value[0]['convers_value_heactor'];
                        $grand_total_tot_cost += $v['unit_cost'] * $v['total_area'];
                    }
                    $RegDataWithState[$key]['id'] = $key;
                    $RegDataWithState[$key]['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
                    $RegDataWithState[$key]['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;
                    $RegDataWithState[$key]['grand_total_tot_cost'] = $grand_total_tot_cost;
                    $grand_total_cost_all += $grand_total_tot_cost;
                }
            }
        } else {
            $grand_total_cost_all = 0;
            $allDataArray = [];
            foreach ($RegDataWithState as $key => $val) {

                if ($filter == 'District') {
                    $finalcond = $cond . " AND district_id = '{$key}'";
                }
                if ($filter == 'Block/Taluk') {
                    $finalcond = $cond . " AND block_id = '{$key}'";
                }
                if ($filter == 'Legal Entity') {
                    $finalcond = $cond . " AND legal_entity = '{$key}'";
                }
                if ($filter == 'Plot Type') {
                    $finalcond = $cond . " AND plot_type_id = '{$key}'";
                }
                if ($filter == 'Purchase Type') {
                    $finalcond = $cond . " AND purchase_type_id = '{$key}'";
                }
                if ($filter == 'Purchasing Team') {
                    $finalcond = $cond . " AND purchasing_team_id = '{$key}'";
                }

                $grand_total_tot_area = $this->getTotalAreaCalculation($finalcond);

                $grand_total_tot_cost = RegistrationModel::selectRaw('sum(tot_cost) as grand_total_tot_cost')->whereRaw($finalcond)->get()->toArray();

                $allDataArray[$key]['grand_total_tot_area_acer'] = $grand_total_tot_area['grand_total_tot_area_acer'];
                $allDataArray[$key]['grand_total_tot_area_hector'] = $grand_total_tot_area['grand_total_tot_area_hector'];
                $allDataArray[$key]['grand_total_tot_cost'] = $grand_total_tot_cost[0]['grand_total_tot_cost'];
                $grand_total_cost_all += $grand_total_tot_cost[0]['grand_total_tot_cost'];
            }

            $RegDataWithState = $allDataArray;
        }



        $this->data['RegDataWithState'] = $RegDataWithState;
        $this->data['filter'] = $filter;
        $this->data['grand_total_cost_all'] = isset($grand_total_cost_all) ? $grand_total_cost_all : '';
        return view('admin.dashboard.total', $this->data);
    }

    public function dashboardDistrict(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        $this->data['data']['cssArr'][] = 'assets/css/jquery.contextMenu.css';

        $this->data['data']['jsArr'][] = 'assets/js/jquery.contextMenu.js';
        //$this->data['data']['jsArr'][] = 'jassets/js/query.ui.position.min.js';

        $posted_data = $request->all();

        $state_id = $posted_data['state_id'];
        $filter = $posted_data['filter'];
        $this->data['filter'] = $filter;

        $cond = '1=1';


        if ($filter == 'State' && !empty($state_id)) {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        }

        if ($this->user_type == 'admin') {
            $allDistrictIds = DistrictModel::where(['fl_archive' => "N", 'state_id' => $state_id])->orderBy('district_name')->get()->toArray();
        } else {
            $res = StateModel::where(['id' => $state_id])->with(['assignedDistricts' => function($query) {
                            $query->selectRaw("array_to_string(array_agg(QUOTE_LITERAL(district_id)), ',') as dist_id_str,state_id")->groupBy('state_id');
                        }])->get()->toArray();

            $assigned_districts = isset($res[0]['assigned_districts'][0]['dist_id_str']) ? $res[0]['assigned_districts'][0]['dist_id_str'] : '';
            if ($assigned_districts) {
                $allDistrictIds = DistrictModel::whereRaw(" id in ($assigned_districts)")->where(['fl_archive' => "N", 'state_id' => $state_id])->orderBy('district_name')->get()->toArray();
            } else {
                $allDistrictIds = '';
            }
            //   t($assigned_districts, 1);
        }
        //    t($allDistrictIds,1);


        $grand_total_cost_all = '';
        if ($allDistrictIds) {
            foreach ($allDistrictIds as $key => $val) {
                $finalcond = $cond . " AND district_id = '{$val['id']}'";
                $grand_total_tot_area = $this->getTotalAreaCalculation($finalcond);

                $grand_total_tot_cost = RegistrationModel::selectRaw('sum(tot_cost) as grand_total_tot_cost')->whereRaw($finalcond)->get()->toArray();

                $allDistrictIds[$key]['grand_total_tot_area_acer'] = $grand_total_tot_area['grand_total_tot_area_acer'];
                $allDistrictIds[$key]['grand_total_tot_area_hector'] = $grand_total_tot_area['grand_total_tot_area_hector'];
                $allDistrictIds[$key]['grand_total_tot_cost'] = $grand_total_tot_cost[0]['grand_total_tot_cost'];
                $grand_total_cost_all += $grand_total_tot_cost[0]['grand_total_tot_cost'];
            }
        }

        $RegDataWithState = $allDistrictIds;
//        t($RegDataWithState);die();
        //t($RegDataWithState);
        $this->data['RegDataWithState'] = $RegDataWithState;
        $this->data['grand_total_cost_all'] = $grand_total_cost_all;

        $this->data['state_id'] = $state_id;
        return view('admin.dashboard.district', $this->data);
    }

    public function dashboardBlock(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        $this->data['data']['cssArr'][] = 'assets/css/jquery.contextMenu.css';

        $this->data['data']['jsArr'][] = 'assets/js/jquery.contextMenu.js';
        //$this->data['data']['jsArr'][] = 'jassets/js/query.ui.position.min.js';


        $posted_data = $request->all();
        $state_id = isset($posted_data['state_id']) ? $posted_data['state_id'] : '';
        $district_id = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
        $filter = $posted_data['filter'];
        $this->data['filter'] = $filter;

        $cond = '1=1';




        if ($filter == 'State' && !empty($state_id) && empty($district_id) && empty($block_id)) {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        }
        if ($filter == 'State' && !empty($state_id) && !empty($district_id) && empty($block_id)) {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        }
        if ($filter == 'District' && !empty($state_id) && !empty($district_id) && empty($block_id)) {

            return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        } else if ($filter == 'District' && !empty($state_id) && empty($district_id) && empty($block_id)) {

            return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if ($filter == 'Block/Taluk' && !empty($state_id) && empty($district_id) && empty($block_id)) {
            $condArray = ['fl_archive' => "N", 'state_id' => $state_id];
        } else if ($filter == 'Block/Taluk' && !empty($state_id) && !empty($district_id) && empty($block_id)) {
            $condArray = ['fl_archive' => "N", 'district_id' => $district_id];
        }
        if ($filter == 'Village' && !empty($state_id) && empty($district_id) && empty($block_id)) {
            return redirect('dashboard/village?state_id=' . $state_id . '&district_id=' . $district_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }



        if ($this->user_type == 'admin') {
            if (isset($condArray) && !empty($condArray)) {
                $allBlockIds = BlockModel::with(['getDistrict', 'getState'])->where($condArray)->orderBy('block_name')->get()->toArray();
            } else {
                $allBlockIds = BlockModel::with(['getDistrict', 'getState'])->orderBy('block_name')->get()->toArray();
            }
        } else {
            $res = StateModel::where(['id' => $state_id])->with(['assignedDistricts' => function($query) {
                            $query->selectRaw("array_to_string(array_agg(QUOTE_LITERAL(district_id)), ',') as dist_id_str,state_id")->groupBy('state_id');
                        }])->get()->toArray();

            $assigned_districts = isset($res[0]['assigned_districts'][0]['dist_id_str']) ? $res[0]['assigned_districts'][0]['dist_id_str'] : '';
//            if ($assigned_districts) {
//                $allDistrictIds = DistrictModel::whereRaw(" id in ($assigned_districts)")->where(['fl_archive' => "N", 'state_id' => $state_id])->orderBy('district_name')->get()->toArray();
//            } else {
//                $allDistrictIds = '';
//            }
            if ($assigned_districts) {
                if (isset($condArray) && !empty($condArray)) {
                    $allBlockIds = BlockModel::with(['getDistrict', 'getState'])->whereRaw(" district_id in ($assigned_districts)")->where($condArray)->orderBy('block_name')->get()->toArray();
                } else {
                    $allBlockIds = BlockModel::with(['getDistrict', 'getState'])->whereRaw(" district_id in ($assigned_districts)")->orderBy('block_name')->get()->toArray();
                }
            }
            //   t($assigned_districts, 1);
        }

//      t($allBlockIds,1);
        //t($RegDataWithState);
        if (!empty($allBlockIds)) {
            $district_name = isset($allBlockIds) ? $allBlockIds[0]['get_district']['district_name'] : '';
            $state_name = isset($allBlockIds) ? $allBlockIds[0]['get_state']['state_name'] : '';
            $breadcum = "<li><a href='" . url("dashboard?filter=") . "'>$state_name</a></li>";
            $breadcum .= "<li><a href='" . url("dashboard/district?state_id=") . $allBlockIds[0]['get_state']['id'] . "&filter='>" . $district_name . "</a></li>";

            $this->data['breadcum'] = $breadcum;
        }
        $grand_total_cost_all = '';

        foreach ($allBlockIds as $key => $val) {
            $finalcond = $cond . " AND block_id = '{$val['id']}'";
            $grand_total_tot_area = $this->getTotalAreaCalculation($finalcond);
            $grand_total_tot_cost = RegistrationModel::selectRaw('sum(tot_cost) as grand_total_tot_cost')->whereRaw($finalcond)->get()->toArray();
            $allBlockIds[$key]['grand_total_tot_area_acer'] = $grand_total_tot_area['grand_total_tot_area_acer'];
            $allBlockIds[$key]['grand_total_tot_area_hector'] = $grand_total_tot_area['grand_total_tot_area_hector'];
            $allBlockIds[$key]['grand_total_tot_cost'] = $grand_total_tot_cost[0]['grand_total_tot_cost'];
            $grand_total_cost_all += $grand_total_tot_cost[0]['grand_total_tot_cost'];
        }

        $RegDataWithState = $allBlockIds;

//        t($RegDataWithState);die();



        $this->data['RegDataWithState'] = $RegDataWithState;
        $this->data['grand_total_cost_all'] = $grand_total_cost_all;
        $this->data['state_id'] = $state_id;
        $this->data['district_id'] = $district_id;





        return view('admin.dashboard.block', $this->data);
    }

    public function dashboardVillage(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        $this->data['data']['cssArr'][] = 'assets/css/jquery.contextMenu.css';

        $this->data['data']['jsArr'][] = 'assets/js/jquery.contextMenu.js';
        //$this->data['data']['jsArr'][] = 'jassets/js/query.ui.position.min.js';

        $posted_data = $request->all();
        $state_id = isset($posted_data['state_id']) ? $posted_data['state_id'] : '';
        $district_id = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
        $block_id = isset($posted_data['block_id']) ? $posted_data['block_id'] : '';
        $filter = $posted_data['filter'];
        $this->data['filter'] = $filter;

        $cond = '1=1';




        if ($filter == 'State' && !empty($state_id) && !empty($district_id) && empty($block_id)) {
            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        } elseif ($filter == 'State' && !empty($state_id) && empty($district_id) && empty($block_id)) {

            return redirect('dashboard?filter=' . $filter)/* ->with('message', $msg) */;
        }

        if ($filter == 'District' && !empty($state_id) && !empty($district_id) && empty($block_id)) {

            return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        } elseif ($filter == 'District' && !empty($state_id) && empty($district_id) && empty($block_id)) {

            return redirect('dashboard/district?state_id=' . $state_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if ($filter == 'Block/Taluk' && !empty($state_id) && !empty($district_id) && !empty($block_id)) {
            $condArray = ['fl_archive' => "N", 'block_id' => $block_id];
        } elseif ($filter == 'Block/Taluk' && !empty($state_id) && !empty($district_id) && empty($block_id)) {

            return redirect('dashboard/block?state_id=' . $state_id . '&district_id=' . $district_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        } elseif ($filter == 'Block/Taluk' && !empty($state_id) && empty($district_id) && empty($block_id)) {

            return redirect('dashboard/block?state_id=' . $state_id . '&district_id=' . $district_id . '&filter=' . $filter)/* ->with('message', $msg) */;
        }
        if ($filter == 'Village' && !empty($state_id) && !empty($district_id) && !empty($block_id)) {
            $condArray = ['fl_archive' => "N", 'block_id' => $block_id];
        } else if ($filter == 'Village' && !empty($state_id) && !empty($district_id) && empty($block_id)) {

            $condArray = ['fl_archive' => "N", 'district_id' => $district_id];
        } else if ($filter == 'Village' && !empty($state_id) && empty($district_id) && empty($block_id)) {

            $condArray = ['fl_archive' => "N", 'state_id' => $state_id];
        }

        $allVillageIds = VillageModel::with(['getBlock', 'getDistrict', 'getState'])->where($condArray)->orderBy('village_name')->get()->toArray();


        //t($RegDataWithState);
        if (!empty($allVillageIds)) {
            $district_name = isset($allVillageIds) ? $allVillageIds[0]['get_district']['district_name'] : '';
            $state_name = isset($allVillageIds) ? $allVillageIds[0]['get_state']['state_name'] : '';
            $breadcum = "<li><a href='" . url("dashboard?filter=") . "'>$state_name</a></li>";
            $breadcum .= "<li><a href='" . url("dashboard/district?state_id=") . $allVillageIds[0]['get_state']['id'] . "&filter='>" . $district_name . "</a></li>";

            $this->data['breadcum'] = $breadcum;
        } else {
            $this->data['breadcum'] = '';
        }





        $grand_total_cost_all = '';

        foreach ($allVillageIds as $key => $val) {
            $finalcond = $cond . " AND village_id = '{$val['id']}'";
            $grand_total_tot_area = $this->getTotalAreaCalculation($finalcond);

            $grand_total_tot_cost = RegistrationModel::selectRaw('sum(tot_cost) as grand_total_tot_cost')->whereRaw($finalcond)->get()->toArray();

            $allVillageIds[$key]['grand_total_tot_area_acer'] = $grand_total_tot_area['grand_total_tot_area_acer'];
            $allVillageIds[$key]['grand_total_tot_area_hector'] = $grand_total_tot_area['grand_total_tot_area_hector'];
            $allVillageIds[$key]['grand_total_tot_cost'] = $grand_total_tot_cost[0]['grand_total_tot_cost'];
            $grand_total_cost_all += $grand_total_tot_cost[0]['grand_total_tot_cost'];
        }

        $RegDataWithState = $allVillageIds;

//        t($RegDataWithState);die("Uuuu");


        $this->data['state_id'] = $state_id;
        $this->data['district_id'] = $district_id;
        $this->data['block_id'] = $block_id;
        $this->data['RegDataWithState'] = $RegDataWithState;
        $this->data['grand_total_cost_all'] = $grand_total_cost_all;







        return view('admin.dashboard.village', $this->data);
    }

    public function dashboardLegalEntity(Request $request) {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['include_script_view'] = 'admin.dashboard.script';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

        $posted_data = $request->all();

        $block_id = $posted_data['block_id'];
        $filter = $posted_data['filter'];
        $this->data['filter'] = $filter;

        $cond = '1=1';

        if ($filter == 'Plot Type') {
            $cond .= " AND plot_type_id <> '' ";
            $code_type = 'plot_type';
        }
        if ($filter == 'Legal Entity') {
            $cond .= " AND legal_entity <> '' ";
            $code_type = 'legal_entity';
        }
        if ($filter == 'Purchasing Team') {
            $cond .= " AND purchasing_team_id <> '' ";
            $code_type = 'purchasing_team';
        }
        if ($filter == 'Purchase Type') {
            $cond .= " AND purchase_type_id <> '' ";
            $code_type = 'purchase_type';
        }
        if ($filter == '') {
            $cond .= " AND legal_entity <> '' ";
        }

        $allLegalEntityIds = CodeModel::where(['cd_type' => "legal_entity", 'cd_fl_archive' => 'N'])->exclude(['created_at', 'updated_at'])->orderBy('cd_desc')->get()->toArray();


        if ($filter == 'Purpose' || $filter == 'Classification') {


            if ($filter == 'Purpose') {
                $whereRaw = ' "T_SURVEY"."purpose" is not null';
            } elseif ($filter == 'Classification') {
                $whereRaw = ' "T_SURVEY"."classification" is not null ';
            }

            foreach ($allLegalEntityIds as $key => $value) {
                $surveyDataArray = DB::table('REGISTRATION')
                        ->join('SURVEY', 'REGISTRATION.id', '=', 'SURVEY.registration_id')
                        ->select('SURVEY.*')
                        ->where('REGISTRATION.legal_entity', '=', "{$value['id']}")
                        ->where('REGISTRATION.block_id', '=', "{$block_id}")
                        ->whereRaw($whereRaw)
                        ->get();

                $allSurveyData[$value['id']] = $surveyDataArray;
            }

            $allSurveyData = json_decode(json_encode((array) $allSurveyData), true);


            $RegDataWithState = [];
            $grand_total_cost_all = 0;

            foreach ($allSurveyData as $key => $val) {
                if (!empty($val)) {
                    $tot_area_unit_value_acer = 0;
                    $tot_area_unit_value_hector = 0;
                    $grand_total_tot_cost = 0;
                    foreach ($val as $k => $v) {
                        $tot_area_unit = $v['area_unit'];
                        $tot_area_unit_value = ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();
                        $tot_area_unit_value_acer += $v['total_area'] * $tot_area_unit_value[0]['convers_value_acer'];
                        $tot_area_unit_value_hector += $v['total_area'] * $tot_area_unit_value[0]['convers_value_heactor'];
                        $grand_total_tot_cost += $v['unit_cost'] * $v['total_area'];
                    }
                    $RegDataWithState[$key]['id'] = $key;
                    $RegDataWithState[$key]['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
                    $RegDataWithState[$key]['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;
                    $RegDataWithState[$key]['grand_total_tot_cost'] = $grand_total_tot_cost;
                    $grand_total_cost_all += $grand_total_tot_cost;
                }
            }
            //t($RegDataWithState,1);
        } else {

            $grand_total_cost_all = '';

            foreach ($allLegalEntityIds as $key => $val) {
                $finalcond = $cond . " AND block_id = '{$block_id}' AND legal_entity = '{$val['id']}'";
                $grand_total_tot_area = $this->getTotalAreaCalculation($finalcond);

                $grand_total_tot_cost = RegistrationModel::selectRaw('sum(tot_cost) as grand_total_tot_cost')->whereRaw($finalcond)->get()->toArray();

                $allLegalEntityIds[$key]['grand_total_tot_area_acer'] = $grand_total_tot_area['grand_total_tot_area_acer'];
                $allLegalEntityIds[$key]['grand_total_tot_area_hector'] = $grand_total_tot_area['grand_total_tot_area_hector'];
                $allLegalEntityIds[$key]['grand_total_tot_cost'] = $grand_total_tot_cost[0]['grand_total_tot_cost'];
                $grand_total_cost_all += $grand_total_tot_cost[0]['grand_total_tot_cost'];
            }

            $RegDataWithState = $allLegalEntityIds;
        }

        //t($RegDataWithState);

        $block_name = BlockModel::select('block_name', 'district_id')->where(['id' => "$block_id"])->get()->toArray();
        $district_name = DistrictModel::select('district_name', 'state_id')->where(['id' => "{$block_name[0]['district_id']}"])->get()->toArray();
        $state_name = StateModel::where(['id' => "{$district_name[0]['state_id']}"])->value('state_name');
        $breadcum = "<li><a href='" . url("dashboard?filter=") . "'>$state_name</a></li>";
        $breadcum .= "<li><a href='" . url("dashboard/district?state_id=") . $district_name[0]['state_id'] . "&filter='>" . $district_name[0]['district_name'] . "</a></li>";
        $breadcum .= "<li><a href='" . url("dashboard/block?district_id=") . $block_name[0]['district_id'] . "&filter='>" . $block_name[0]['block_name'] . "</a></li>";

        $this->data['breadcum'] = $breadcum;

        $this->data['RegDataWithState'] = $RegDataWithState;
        $this->data['grand_total_cost_all'] = $grand_total_cost_all;
        $this->data['block_id'] = $block_id;
        return view('admin.dashboard.legalEntity', $this->data);
    }

    public function getTotalAreaCalculationCode($cond) {

        $allSurvey = SurveyModel::whereRaw($cond)->get()->toArray();

        $tot_area_unit_value_acer = 0;
        $tot_area_unit_value_hector = 0;
        $grand_total_tot_cost = 0;
        $returnArray = [];
        foreach ($allSurvey as $k => $v) {
            $tot_area_unit = $v['area_unit'];
            $tot_area_unit_value = ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();
            $tot_area_unit_value_acer += $v['total_area'] * $tot_area_unit_value[0]['convers_value_acer'];
            $tot_area_unit_value_hector += $v['total_area'] * $tot_area_unit_value[0]['convers_value_heactor'];
            $grand_total_tot_cost += $v['unit_cost'] * $v['total_area'];
        }

        $returnArray['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
        $returnArray['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;
        $returnArray['grand_total_tot_cost'] = $grand_total_tot_cost;

        return $returnArray;
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
	
	public function get_state_json()
	{	
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
		, row_to_json(lp) As properties
		FROM \"T_STATE\" As lg 
		INNER JOIN (SELECT ogc_fid as id,state_name FROM \"T_STATE\"";
		$sql .= " where 1=1 AND (wkb_geometry is not null)";
		$sql = $sql . ") As lp
		ON lg.ogc_fid = lp.id  ) As f )  As fc;";
		//echo $sql;die;
		$results = DB::select( DB::raw($sql));

		echo $results[0]->geojson;
    }
	
	public function get_state_info()
	{	
		$state_name = Input::get('state_name');
		
		$cond = "state_name = '{$state_name}'";
		$state_data = stateModel::whereRaw($cond)->get()->toArray();
		$state_id = $state_data[0]['id'];
		$grand_total_cost_all = 0;
		$html = '';
		$finalcond = "state_id = '{$state_id}'";	
		$grand_total_tot_area = RegistrationModel::getTotalAreaCalculation($finalcond);
		$grand_total_tot_cost = RegistrationModel::join('PAYMENT','PAYMENT.registration_id','=',"REGISTRATION.id",'left')->selectRaw('sum(amount) as grand_total_tot_cost')->whereRaw($finalcond)->get()->toArray();
		$data_result['grand_total_tot_area_acer'] = number_format($grand_total_tot_area['grand_total_tot_area_acer'],4);
		$data_result['grand_total_tot_area_hector'] = number_format($grand_total_tot_area['grand_total_tot_area_hector'],4);
		$data_result['grand_total_tot_cost'] = $grand_total_tot_cost[0]['grand_total_tot_cost'];
		$grand_total_cost_all += $grand_total_tot_cost[0]['grand_total_tot_cost'];
		$data_result['grand_total_cost_all'] = $grand_total_cost_all;
		$data_result['state_name'] = $state_name;

		echo json_encode($data_result);	
    }

}
