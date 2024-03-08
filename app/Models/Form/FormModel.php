<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Form;

use App\Models\BaseModel;

/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class FormModel extends BaseModel {

    //put your code here
    protected $table = null;

//    protected $primaryKey = 'id';
//    public $incrementing = true;
//    public $keyType = 'string';

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['FORM_TABLE'];
    }

}
