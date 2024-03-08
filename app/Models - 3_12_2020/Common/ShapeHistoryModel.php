<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Common;

use App\Models\BaseModel;
use Auth;

/**
 * Description of ShapeHistoryModel
 *
 * @author user-98-pc
 */
class ShapeHistoryModel extends BaseModel {

    //put your code here
    protected $table = null;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType = 'string';

    public function __construct() {
        parent::__construct();
        $this->table = $this->data['tables']['SHP_HISTORY_TABLE'];
    }

}
