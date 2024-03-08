<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Common;
use App\Models\BaseModel;

/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class VillageModel extends BaseModel {

    //put your code here
    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = true;
  public $keyType='string';
    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['VILLAGE_TABLE'];
    }
    
    
    public function getState() {
        return $this->belongsTo('App\Models\Common\StateModel', 'state_id');
    }
    public function getDistrict() {
        return $this->belongsTo('App\Models\Common\DistrictModel', 'district_id');
    }
    public function getBlock() {
        return $this->belongsTo('App\Models\Common\BlockModel', 'block_id');
    }

}
