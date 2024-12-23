<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\LandEntryManagement;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class RegistrationModel extends Model {

    //put your code here
    protected $table = "T_REGISTRATION";
    protected $primaryKey = 'id';
    public $incrementing = false;
    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['REGISTRATION_TABLE'];
    // }

}
