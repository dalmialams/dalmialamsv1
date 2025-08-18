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
class PropertyModel extends Model {

    //put your code here
    protected $table = "T_PROPERTY_MASTER";
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType='string';


}
