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
class RegistrationModel extends BaseModel {

    //put your code here
    protected $table = null;
    protected $primaryKey = "id";
    public $incrementing = true;
    public $keyType = "string";
    protected $columns = array('id', 'legal_entity');

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['REGISTRATION_TABLE'];
    }

    function getGeoPosition() {
        return $this->hasOne('App\Models\LandDetailsManagement\SurveyLatLongModel', 'registration_id')->select(DB::raw('*, ST_AsText(wkb_geometry) as latlong '))->where(['fl_archive' => 'N']);
    }

    function getSurvey() {
        return $this->hasMny('App\Models\LandDetailsManagement\SurveyLatLongModel', 'registration_id')->where(['fl_archive' => 'N']);
    }

    public static function getTotalAreaCalculation($cond) {
        //echo $cond;
        //echo '<br>';
        $grand_total_tot_area = self::whereRaw($cond)->get()->toArray();
        $tot_area_unit_value_acer = 0;
        $tot_area_unit_value_hector = 0;
        $returnArray = [];
        if ($grand_total_tot_area) {
            foreach ($grand_total_tot_area as $key => $value) {
                $state_id = isset($value['state_id']) ? $value['state_id'] : '';
                $is_archived = \App\Models\Common\StateModel::where(['id' => $state_id])->value('fl_archive');
                if ($is_archived == 'N') {
                    $tot_area_unit = isset($value['tot_area_unit']) ? $value['tot_area_unit'] : '';
                    $total_area = isset($value['tot_area']) ? $value['tot_area'] : '';
                    if ($tot_area_unit && $total_area) {
                        $tot_area_unit_value = \App\Models\Common\ConversionModel::select('convers_value_acer', 'convers_value_heactor')->where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->get()->toArray();
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
                    }
                }
            }
        }
        $returnArray['grand_total_tot_area_acer'] = $tot_area_unit_value_acer;
        $returnArray['grand_total_tot_area_hector'] = $tot_area_unit_value_hector;
		//$returnArray['grand_total_tot_area_acer'] = array();
        //$returnArray['grand_total_tot_area_hector'] = array();
        return $returnArray;
    }

}
