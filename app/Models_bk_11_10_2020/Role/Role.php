<?php

namespace App\Models\Role;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

    protected $table = null;

    // protected $primaryKey = 'id';
    public function __construct() {
        parent::__construct();
        //  $tables = Config::get('database.tables');
        $this->table = 'ROLES';
    }

}
