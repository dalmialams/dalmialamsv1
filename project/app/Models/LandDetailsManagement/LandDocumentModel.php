<?php

namespace App\Models\LandDetailsManagement;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandDocumentModel extends Model {
    use SoftDeletes;
    protected $table = "T_LAND_DOCUMENT_MASTER";
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $keyType='string';


}
