<?php

namespace App\Models\User;

use App\Models\BaseModel;
use DB;
use Input;
use Config;
use Illuminate\Database\Eloquent\Model;


class ChangePwdLinkModel extends Model {

    protected $table = 'T_FORGOT_PWD_LINKS';
    protected $primaryKey = 'id';
    public $incrementing = false;

    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['FORGOT_PWD_LINK_TABLE'];
    // }

}
