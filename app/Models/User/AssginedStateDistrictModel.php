<?php

namespace App\Models\User;

use App\Models\BaseModel;
use DB;
use Input;
use Config;
use Illuminate\Database\Eloquent\Model;


class AssginedStateDistrictModel extends Model {

    protected $table = 'T_ASSGINED_STATE_DISTRICTS';
    protected $primaryKey = 'id';
    public $incrementing = false;

    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['ASSIGNED_STATE_DISTRICT_TABLE'];
    // }

}
