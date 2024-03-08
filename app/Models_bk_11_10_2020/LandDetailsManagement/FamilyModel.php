<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\LandDetailsManagement;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class FamilyModel extends BaseModel {

    //put your code here
    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['FAMILY_TABLE'];
    }

    /*function getGeoPosition() {
        return $this->hasOne('App\Models\LandDetailsManagement\SurveyLatLongModel', 'survey_id')->select(DB::raw('*, ST_AsText(wkb_geometry) as latlong '))->where(['fl_archive' => 'N']);
    }

    public function getRegistration() {
        return $this->belongsTo('App\Models\LandDetailsManagement\RegistrationModel', 'registration_id');
    }

    public function getClassification() {
        return $this->belongsTo('App\Models\Common\CodeModel', 'classification');
    }

    public static function surveyTotalAreaDetails($survey_id_str, $trxn_type) {
        $returnArray = [];
        if (!$survey_id_str) {
            return $returnArray;
        }
        $survey_id_arr = explode(",", $survey_id_str);
        $survey_id_str = "'" . implode("','", $survey_id_arr) . "'";
        switch ($trxn_type) {
            case 'mutation':
                $total_mutated_area_acre = 0;
                $total_mutated_area_hectare = 0;
                foreach ($survey_id_arr as $key => $value) {
                    $survey_info = self::where(['id' => $value])->get()->toArray();
                    $survey_info = isset($survey_info[0]) ? $survey_info[0] : '';


                   // t($survey_info);
                    $area_unit = isset($survey_info['area_unit']) ? $survey_info['area_unit'] : '';
                    $purchased_area = isset($survey_info['purchased_area']) ? $survey_info['purchased_area'] : '';
                    

                    if ($area_unit && $purchased_area) {
                        $purchased_area_unit_value = \App\Models\Common\ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$area_unit", 'fl_archive' => 'N'])->get()->toArray();
                        // t($purchased_area_unit_value);
                        if ($area_unit != 'CD00094') {
                            $total_mutated_area_acre += $purchased_area * $purchased_area_unit_value[0]['convers_value_acer'];
                        } else if ($area_unit == 'CD00094') {
                            $total_mutated_area_acre += $purchased_area;
                        }
                        if ($area_unit != 'CD00118') {
                            $total_mutated_area_hectare += $purchased_area * $purchased_area_unit_value[0]['convers_value_heactor'];
                        } else if ($area_unit == 'CD00118') {
                            $total_mutated_area_hectare += $purchased_area;
                        }
                    }

                    // $area_unit = 
                }

                $returnArray['grand_total_mutated_area_acre'] = $total_mutated_area_acre;
                $returnArray['grand_total_mutated_area_hectare'] = $total_mutated_area_hectare;
                break;
                
                case 'disputes':
                $total_disputes_area_acre = 0;
                $total_disputes_area_hectare = 0;
                foreach ($survey_id_arr as $key => $value) {
                    $survey_info = self::where(['id' => $value])->get()->toArray();
                    $survey_info = isset($survey_info[0]) ? $survey_info[0] : '';


                   // t($survey_info);
                    $area_unit = isset($survey_info['area_unit']) ? $survey_info['area_unit'] : '';
                    $purchased_area = isset($survey_info['purchased_area']) ? $survey_info['purchased_area'] : '';
                    

                    if ($area_unit && $purchased_area) {
                        $purchased_area_unit_value = \App\Models\Common\ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$area_unit", 'fl_archive' => 'N'])->get()->toArray();
                        // t($purchased_area_unit_value);
                        if ($area_unit != 'CD00094') {
                            $total_disputes_area_acre += $purchased_area * $purchased_area_unit_value[0]['convers_value_acer'];
                        } else if ($area_unit == 'CD00094') {
                            $total_disputes_area_acre += $purchased_area;
                        }
                        if ($area_unit != 'CD00118') {
                            $total_disputes_area_hectare += $purchased_area * $purchased_area_unit_value[0]['convers_value_heactor'];
                        } else if ($area_unit == 'CD00118') {
                            $total_disputes_area_hectare += $purchased_area;
                        }
                    }

                    // $area_unit = 
                }

                $returnArray['grand_total_disputes_area_acre'] = $total_disputes_area_acre;
                $returnArray['grand_total_disputes_area_hectare'] = $total_disputes_area_hectare;
                break;

            default:
                break;
        }

        $grand_total_tot_area = self::whereRaw(" id in ($survey_id_str)")->get()->toArray();
        //    t($grand_total_tot_area, 1);
        $tot_area_unit_value_acer = 0;
        $tot_area_unit_value_hector = 0;

        $total_purchased_area_acre = 0;
        $total_purchased_area_hectare = 0;



        return $returnArray;
    }
*/
}
