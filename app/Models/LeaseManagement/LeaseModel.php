<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\LeaseManagement;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class LeaseModel extends Model {

    //put your code here
    protected $table = "T_LEASE";
    protected $primaryKey = 'id';
    public $incrementing = false;
    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['LEASE_TABLE'];
    // }

}
