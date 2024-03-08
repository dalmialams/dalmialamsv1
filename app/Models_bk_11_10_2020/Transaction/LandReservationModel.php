<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Transaction;

use App\Models\BaseModel;

/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class LandReservationModel extends BaseModel {

    //put your code here
    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = false;
    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['RESERVATION_TABLE'];
    }
    
    public function getReservedSurveys(){
        return $this->hasMany('App\Models\Transaction\LandReservationSurveyModel', 'reservation_id')->where(['fl_archive'=>'N']);
    }

}
