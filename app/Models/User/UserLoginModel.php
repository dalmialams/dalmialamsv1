<?php

namespace App\Models\User;

use App\Models\BaseModel;
use DB;
use Input;
use Config;
use Illuminate\Database\Eloquent\Model;

class UserLoginModel extends Model {

    protected $table = 'T_USER_LOGIN';
    protected $primaryKey = 'id';
    public $incrementing = false;

    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['USER_LOGIN_TABLE'];
    // }
     public function getUserDetails() {
        return $this->belongsTo('App\Models\User\UserModel', 'user_id');
    }

}
