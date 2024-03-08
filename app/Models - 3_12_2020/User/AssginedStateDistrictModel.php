<?php

namespace App\Models\User;

use App\Models\BaseModel;
use DB;
use Input;
use Config;

class AssginedStateDistrictModel extends BaseModel {

    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['ASSIGNED_STATE_DISTRICT_TABLE'];
    }

}
