<?php

namespace App\Models\User;

use App\Models\BaseModel;
use DB;
use Input;
use Config;

class MasterUserModel extends BaseModel {

    //use EntrustUserTrait; 

    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function __construct() {
        parent::__construct();
        $tables = Config::get('database.tables');
        $this->table = isset($tables['MASTER_USER_TABLE']) && !empty($tables['MASTER_USER_TABLE']) ? $tables['MASTER_USER_TABLE'] : 'MASTER_USER';
    }

   

}
