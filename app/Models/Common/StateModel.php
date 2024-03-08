<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Common;

use App\Models\BaseModel;
use Auth;

/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class StateModel extends BaseModel {

    //put your code here
    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType = 'string';

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['STATE_TABLE'];
    }

    public function districts() {
        return $this->hasMany('App\Models\Common\DistrictModel', 'state_id')->where(['fl_archive' => 'N']);
    }

    public function cities() {
        return $this->hasMany('App\Models\Common\CityModel', 'state_id')->where(['fl_archive' => 'N']);
    }

    public function assignedDistricts() {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = '';
        }
        if ($user_id) {
            return $this->hasMany('App\Models\User\AssginedStateDistrictModel', 'state_id')->where(['fl_archive' => 'N', 'user_id' => $user_id]);
        } else {
            return '';
        }
    }

}
