<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MasterDataManagement;

/**
 * Description of PropertyController
 *
 * @author user-98-pc
 */
use App\Http\Controllers\Controller;
use App\Models\Common\CityModel;
use App\Http\Controllers\Auth\AuthController;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;
use App\Models\Common\PropertyModel;



class PropertyController extends Controller {

    protected $validationRules = [
        'property.property_name' => 'required',
        'property.property_location' => 'required',
        'property.state_id' => 'required',
        'property.city_id' => 'required',
        
    ];

    //put your code here
    public function __construct() {
        parent:: __construct();


        $this->data['include_script_view'] = 'admin.MasterDataManagement.script';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['pageHeading'] = 'Master Property Management';
        $this->data['title'] = 'Dalmia-lams::Property';

        $this->middleware(function ($request, $next) {
            $this->data['stateList'] = $this->getAllStates();
            return $next($request);
        });
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add() {

        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['pageHeading'] = 'Master Property <span class="text-danger" >Add</span>';
        return view('admin.MasterDataManagement.propertyForm', $this->data);
    }

    /**
     * 
     * @return type
     */
    public function edit($id) {
        if (!$id) {
            return 'id is missing';
        }
        $this->data['title'] = 'Dalmia-lams::Property-Edit';
        $this->data['pageHeading'] = 'Master Property <span class="text-danger" >Edit</span>';

        $this->data['id'] = $propId= decrypt($id);
        $this->data['property_detail'] = $property =  PropertyModel::find($propId);
        $state_id = $property->state_id ?? '';
        $city = CityModel::where(['state_id' => $state_id ])->orderBy("city_name","asc")->get();
        $this->data['cityList'] = $city;
        return view('admin.MasterDataManagement.propertyForm', $this->data);
    }

    public function propertyList($option = true) {
       
        $property = PropertyModel::select('T_PROPERTY_MASTER.id as propertyId', 'T_PROPERTY_MASTER.property_name','T_PROPERTY_MASTER.property_location','T_PROPERTY_MASTER.property_address','T_PROPERTY_MASTER.state_id','T_PROPERTY_MASTER.city_id','T_PROPERTY_MASTER.property_type','T_PROPERTY_MASTER.fl_archive','T_STATE.state_name','T_CITY.city_name')
        ->leftjoin('T_STATE', 'T_STATE.id', '=', 'T_PROPERTY_MASTER.state_id')
        ->leftjoin('T_CITY', 'T_CITY.id', '=', 'T_PROPERTY_MASTER.city_id')
        ->orderBy("property_name","asc")->get();


        $this->data['title'] = 'Dalmia-lams::Property-List';
        $this->data['pageHeading'] = 'Master Property <span class="text-danger" >List</span>';
 
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
       // $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
	    $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        
     
        $this->data['propertyList'] = $property;
      
        if ($option)
            return view('admin.MasterDataManagement.property', $this->data);
        else
            return $property;
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_property_data = isset($posted_data['property']) ? $posted_data['property'] : '';
        $id = isset($posted_data['id']) ? decrypt($posted_data['id']) : '';
      
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return redirect('master/property/management')
                            ->withErrors($validator, 'propertyError')
                            ->withInput();
        }
        if ($id != '' && $id != null) {
            $data_to_update = $posted_property_data;
            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $updated = PropertyModel::where('id', $id)->update($data_to_update);
            if ($updated) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Property data saved successfully!</strong></div>';
                return redirect('master/property/management')->with('message', $msg);
            }
        } else {

            $data_to_insert = $posted_property_data;
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['crt_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = PropertyModel::insertGetId($data_to_insert);

            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Property data saved successfully!</strong></div>';
                return redirect('master/property/management')->with('message', $msg);
            }
        }
    }

}
