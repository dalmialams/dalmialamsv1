<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Input;
use Session;
use View;

class BaseModel extends Model {
    #table define start

    protected $data = [];

    public function __construct() {
        parent:: __construct();
        $this->data = [];
        $tables = Config::get('database.tables');
        $this->data['tables'] = $tables;
        
    }

    protected function pre($param, $do_die = FALSE) {
        echo '<pre>';
        print_r($param);
        echo '</pre><br/>';
        if ($do_die === TRUE) {
            die('STOPPED');
        }
    }

}
