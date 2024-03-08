<?php

namespace App\Models\Role;

use Zizaco\Entrust\EntrustPermission;

class Permission  extends EntrustPermission {

    protected $table = null;

    // protected $primaryKey = 'id';
    public function __construct() {
        parent::__construct();
        //  $tables = Config::get('database.tables');
        $this->table = 'PERMISSIONS';
    }

}
