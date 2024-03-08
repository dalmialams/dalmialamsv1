<?php

namespace App\Models\User;

use App\Models\BaseModel;
use DB;
use Input;
use Config;
use Illuminate\Foundation\Auth\User as Authenticatable;

//use Zizaco\Entrust\Traits\EntrustUserTrait;


class UserModel extends Authenticatable {

    //use EntrustUserTrait; 

    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function __construct() {
        parent::__construct();
        $tables = Config::get('database.tables');
        $this->table = isset($tables['USER_TABLE']) && !empty($tables['USER_TABLE']) ? $tables['USER_TABLE'] : 'USER';
    }

    public function getUserLog() {
        return $this->hasMany('App\Models\User\UserLoginModel', 'user_id');
    }

    public function ifHasPermission($permission_name, $user_id) {
        $assigned_permissions = $this->where(['id' => $user_id])->select('permissions')->get()->toArray();
        $assigned_permissions = isset($assigned_permissions[0]['permissions']) ? $assigned_permissions[0]['permissions'] : '';
        $assigned_permissions = ($assigned_permissions) ? explode(",", $assigned_permissions) : [];
        if (in_array($permission_name, $assigned_permissions)) {
            return true;
        } else {
            return false;
        }
    }

}
