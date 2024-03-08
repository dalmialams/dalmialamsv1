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
class ConversionModel extends BaseModel {

    //put your code here
    protected $table = null;
    public $incrementing = true;
    protected $primaryKey = 'id';
  public $keyType='string';
    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['CONVERSION_TABLE'];
    }

    public function getCodeDetails() {
        return $this->belongsTo('App\Models\Common\CodeModel', 'code_id');
    }

}
