<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Approval;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of ApprovalModel
 *
 * @author user-98-pc
 */
class ApprovalModel extends Model {

    //put your code here
    protected $table = 'T_APPROVAL';
    protected $primaryKey = 'id';
    public $incrementing = false;
    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['APPROVAL_TABLE'];
    // }

}
