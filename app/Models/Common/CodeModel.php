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
class CodeModel extends BaseModel {

    //put your code here
      protected $table = null;
    protected $primaryKey = "id";
  
    public $incrementing = true;
    public $keyType = 'string';
    protected $columns = array('cd_type', 'id', 'cd_desc', 'cd_crt_id', 'created_at', 'cd_upd_id', 'updated_at', 'cd_fl_archive', 'cd_order'); // add all columns from you table

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['CODE_TABLE'];
    }

    public function getState() {
        return $this->belongsTo('App\Models\Common\StateModel', 'state_id');
    }

    public function getConvers() {
        return $this->hasOne('App\Models\Common\ConversionModel', 'code_id');
    }

    public function scopeExclude($query, $value = array()) {
        return $query->select(array_diff($this->columns, (array) $value));
    }

}
