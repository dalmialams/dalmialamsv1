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
class PaymentModel extends Model {

    //put your code here
    protected $table = "T_PAYMENT";
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $casts = [
        'path' => 'array',
        'file_type' => 'array'
    ];
    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['PAYMENT_TABLE'];
    // }

    public static function getTotalPaymentOfRegistration($reg_id){
        
    }

}
