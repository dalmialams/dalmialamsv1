<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\LandDetailsManagement;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class RegistrationModel extends Model
{

    //put your code here
    protected $table = "T_REGISTRATION";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $keyType = "string";
    protected $columns = array('id', 'legal_entity');

    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['REGISTRATION_TABLE'];
    // }

    function getGeoPosition()
    {
        return $this->hasOne('App\Models\LandDetailsManagement\SurveyLatLongModel', 'registration_id')->select(DB::raw('*, ST_AsText(wkb_geometry) as latlong '))->where(['fl_archive' => 'N']);
    }

    function getSurvey()
    {
        return $this->hasMny('App\Models\LandDetailsManagement\SurveyLatLongModel', 'registration_id')->where(['fl_archive' => 'N']);
    }


    public static function getTotalAreaCalculation($cond)
    {   
        // echo $cond;die;
        $grand_total_tot_area = self::whereRaw($cond)->get()->toArray();
        

        // t($grand_total_tot_area);
        $purchase_area_unit_value_acer = 0;
        $purchase_area_unit_value_hector = 0;
        $lease_area_unit_value_acer = 0;
        $lease_area_unit_value_hector = 0;
        $returnArray = [];
        if ($grand_total_tot_area) {
            foreach ($grand_total_tot_area as $key => $value) {
                $state_id = isset($value['state_id']) ? $value['state_id'] : '';

                $is_archived = \App\Models\Common\StateModel::where(['id' => $state_id])->value('fl_archive');

                if ($is_archived == 'N') {
                    $tot_area_unit = isset($value['tot_area_unit']) ? $value['tot_area_unit'] : '';
                    $total_area = isset($value['tot_area']) ? $value['tot_area'] : '';

                    /*	print_r($is_archived);
					echo "</br>----";
					print_r($tot_area_unit);
					echo "</br>----";
					print_r($total_area);
						echo "</br>----";
					print_r($tot_area_unit_value);
					die;*/

                    if ($tot_area_unit && $total_area) {
                        $tot_area_unit_value = \App\Models\Common\ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();

                        if ($value['purchase_type_id'] == 'CD00144') {
                            if ($tot_area_unit != 'CD00094') {
                                $convers_value_acre = isset($tot_area_unit_value[0]['convers_value_acer']) ? $tot_area_unit_value[0]['convers_value_acer'] : 0;
                                // $tot_area_unit_value_acer += $total_area * $tot_area_unit_value[0]['convers_value_acer'];
                                $lease_area_unit_value_acer += $total_area * $convers_value_acre;
                                //$tot_area_unit_value_acer += $total_area * $tot_area_unit_value;
                            } else if ($tot_area_unit == 'CD00094') {
                                $lease_area_unit_value_acer += $total_area;
                            }

                            if ($tot_area_unit != 'CD00118') {
                                $convers_value_hector = isset($tot_area_unit_value[0]['convers_value_heactor']) ? $tot_area_unit_value[0]['convers_value_heactor'] : 0;
                                $lease_area_unit_value_hector += $total_area * $convers_value_hector;
                                // $tot_area_unit_value_hector += $total_area * $tot_area_unit_value[0]['convers_value_heactor'];
                                // $tot_area_unit_value_hector += $total_area * $tot_area_unit_value;
                            } else if ($tot_area_unit == 'CD00118') {
                                $lease_area_unit_value_hector += $total_area;
                            }
                        } else {
                            if ($tot_area_unit != 'CD00094') {
                                $convers_value_acre = isset($tot_area_unit_value[0]['convers_value_acer']) ? $tot_area_unit_value[0]['convers_value_acer'] : 0;
                                // $tot_area_unit_value_acer += $total_area * $tot_area_unit_value[0]['convers_value_acer'];
                                $purchase_area_unit_value_acer += $total_area * $convers_value_acre;
                                //$tot_area_unit_value_acer += $total_area * $tot_area_unit_value;
                            } else if ($tot_area_unit == 'CD00094') {
                                $purchase_area_unit_value_acer += $total_area;
                            }

                            if ($tot_area_unit != 'CD00118') {
                                $convers_value_hector = isset($tot_area_unit_value[0]['convers_value_heactor']) ? $tot_area_unit_value[0]['convers_value_heactor'] : 0;
                                $purchase_area_unit_value_hector += $total_area * $convers_value_hector;
                                // $tot_area_unit_value_hector += $total_area * $tot_area_unit_value[0]['convers_value_heactor'];
                                // $tot_area_unit_value_hector += $total_area * $tot_area_unit_value;
                            } else if ($tot_area_unit == 'CD00118') {
                                $purchase_area_unit_value_hector += $total_area;
                            }
                        }
                    }
                }
            }
        }


        $returnArray['grand_total_purchase_area_acer'] = $purchase_area_unit_value_acer;
        $returnArray['grand_total_purchase_area_hector'] = $purchase_area_unit_value_hector;

        $returnArray['grand_total_lease_area_acer'] = $lease_area_unit_value_acer;
        $returnArray['grand_total_lease_area_hector'] = $lease_area_unit_value_hector;

        //

        //$returnArray['grand_total_tot_area_acer'] = array();
        //$returnArray['grand_total_tot_area_hector'] = array();
        //print_r($returnArray);
        //die;
        return $returnArray;
    }

    // public static function getTotalAreaCalculation($cond) {
    //     //echo $cond;
    //     //echo '<br>';
    //     $grand_total_tot_area = self::whereRaw($cond)->get()->toArray();
    //     $tot_area_unit_value_acer = 0;
    //     $tot_area_unit_value_hector = 0;
    //     $returnArray = [];
    //     if ($grand_total_tot_area) {
    //         foreach ($grand_total_tot_area as $key => $value) {
    //             $state_id = isset($value['state_id']) ? $value['state_id'] : '';

    //             $is_archived = \App\Models\Common\StateModel::where(['id' => $state_id])->value('fl_archive');



    //             if ($is_archived == 'N') {
    //                 $tot_area_unit = isset($value['tot_area_unit']) ? $value['tot_area_unit'] : '';
    //                 $total_area = isset($value['tot_area']) ? $value['tot_area'] : '';

    // 			/*	print_r($is_archived);
    // 				echo "</br>----";
    // 				print_r($tot_area_unit);
    // 				echo "</br>----";
    // 				print_r($total_area);
    // 					echo "</br>----";
    // 				print_r($tot_area_unit_value);
    // 				die;*/

    //                 if ($tot_area_unit && $total_area) {
    //                     $tot_area_unit_value = \App\Models\Common\ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();

    // 					//$tot_area_unit_value = 1;

    //                     if ($tot_area_unit != 'CD00094') {
    //                         $convers_value_acre = isset($tot_area_unit_value[0]['convers_value_acer'])?$tot_area_unit_value[0]['convers_value_acer']:0;

    //                         // $tot_area_unit_value_acer += $total_area * $tot_area_unit_value[0]['convers_value_acer'];

    //                         $tot_area_unit_value_acer += $total_area * $convers_value_acre;

    // 						//$tot_area_unit_value_acer += $total_area * $tot_area_unit_value;

    //                     } else if ($tot_area_unit == 'CD00094') {
    //                         $tot_area_unit_value_acer += $total_area;
    //                     }

    //                     if ($tot_area_unit != 'CD00118') {
    //                         $convers_value_hector = isset($tot_area_unit_value[0]['convers_value_heactor'])?$tot_area_unit_value[0]['convers_value_heactor']:0;

    //                         $tot_area_unit_value_hector += $total_area * $convers_value_hector;

    //                         // $tot_area_unit_value_hector += $total_area * $tot_area_unit_value[0]['convers_value_heactor'];
    // 					    // $tot_area_unit_value_hector += $total_area * $tot_area_unit_value;

    //                     } else if ($tot_area_unit == 'CD00118') {
    //                         $tot_area_unit_value_hector += $total_area;
    //                     }
    //                 }
    //             }
    //         }
    //     }


    //     $returnArray['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
    //     $returnArray['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;
    // 	//$returnArray['grand_total_tot_area_acer'] = array();
    //     //$returnArray['grand_total_tot_area_hector'] = array();
    // 	//print_r($returnArray);
    // 	//die;
    //     return $returnArray;
    // }


    public static function getTotalAreaCalculationTwo($cond)
    {

        // DB::enableQueryLog();
        // echo $cond;die;
        $registration = self::whereRaw($cond)->get()->toArray();
        // $query = DB::getQueryLog();
        // dd($query);die;
        $cumilativeTitalArea = 0;
        $cumilativeTitalCost = 0;

        foreach ($registration as $key => $value) {
            $temp = $value['tot_area'];
            if ($value['tot_area_unit'] == 'CD00094') {
                $temp = $value['tot_area'];
            } else {
                $temp = round(($value['tot_area'] * 2.471), 3);
            }
            $valueToDisplay = $temp;
            $cumilativeTitalArea = $cumilativeTitalArea + $valueToDisplay;
        }
        dd($registration);
        // $temp=$value['tot_area'];
        // if($value['tot_area_unit']=='CD00094'){
        //     $temp=$value['tot_area'];
        // }
        // else{
        //     $temp=round(($value['tot_area']*2.471),3);
        // }
        // $valueToDisplay = $temp;
        // $cumilativeTitalArea = $cumilativeTitalArea + $valueToDisplay;
        // echo $valueToDisplay;
    }
}
