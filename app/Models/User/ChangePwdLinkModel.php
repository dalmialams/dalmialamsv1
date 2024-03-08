<?php

namespace App\Models\User;

use App\Models\BaseModel;
use DB;
use Input;
use Config;

class ChangePwdLinkModel extends BaseModel {

    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['FORGOT_PWD_LINK_TABLE'];
    }

}
