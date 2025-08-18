<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Common;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class CityModel extends Model {

    //put your code here
    protected $table = "T_CITY";
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType='string';
    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['CITY_TABLE'];
    // }

      public function getState() {
        return $this->belongsTo('App\Models\Common\StateModel', 'state_id');
    }
}
