<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Common;

use App\Models\BaseModel;
use App\Models\Common\StateModel;
/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class DistrictModel extends BaseModel {

    //put your code here
    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType = 'string';

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['DISTRICT_TABLE'];
    }

    public function blocks() {
        return $this->hasMany('App\Models\Common\BlockModel', 'district_id')->where(['fl_archive' => 'N']);
    }

    public function getState() {
        return $this->belongsTo('App\Models\Common\StateModel', 'state_id');
    }

    public static function getStatePrefix($district_id) {
        
    }

}
