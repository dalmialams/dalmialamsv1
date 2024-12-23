<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\LandDetailsManagement;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class SurveyLatLongModel extends Model {

    //put your code here
    protected $table = "T_PLOT_GEOMETRY";
    protected $primaryKey = 'id';
    public $incrementing = false;
    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['PLOTGEOMETRY_TABLE'];
    // }
    
     function getSurveyDetails(){
         return $this->belongsTo('App\Models\LandDetailsManagement\SurveyModel', 'survey_id')->where(['fl_archive'=>'N']);
    }
}
