<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\LandDetailsManagement;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class SurveyMapModel extends BaseModel {

    //put your code here
    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['SURVEY_MAP'];
    }
}
