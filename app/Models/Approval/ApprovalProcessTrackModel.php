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
 * Description of ApprovalChannelModel
 *
 * @author user-98-pc
 */
class ApprovalProcessTrackModel extends Model {

    //put your code here
    protected $table = "T_APPROVAL_PROCESS_TRACK";
    protected $primaryKey = 'id';
    public $incrementing = false;
	
    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['APPROVAL_PROCESS_TRACK_TABLE'];
    // }

}
