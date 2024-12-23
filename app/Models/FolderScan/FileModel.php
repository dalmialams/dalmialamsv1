<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\FolderScan;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of RegistrationModel
 *
 * @author user-98-pc
 */
class FileModel extends Model {

    //put your code here
    protected $primaryKey = "id";
    protected $table = "T_FILE_UPLOAD";
    public $incrementing = true;
    public $keyType='string';



    // public function __construct() {
    //     parent::__construct();
    //     $this->table = $this->data['tables']['FILEUPLOAD_TABLE'];
    // }


}
