<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MasterDataManagement;

/**
 * Description of CityController
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

class CityController extends Controller {

    //put your code here

    protected $validationRules = [
        'city.city_name' => 'required',
    ];

    //put your code here
    public function __construct() {
        parent:: __construct();


        $this->data['include_script_view'] = 'admin.MasterDataManagement.script';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['pageHeading'] = 'Master City Management';
        $this->data['title'] = 'Dalmia-lams::City';
//        $this->data['citys'] = $this->getAllCitys();
//        $this->data['area_units'] = $this->getCodesDetails('area_unit');
//        $this->data['purchase_type'] = $this->getCodesDetails('purchase_type');
        $this->data['stateList'] = $this->getAllStates();
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
        $this->cityList(false);
        $this->data['pageHeading'] = 'Master City <span class="text-danger" >Add</span>';
        return view('admin.MasterDataManagement.cityForm', $this->data);
    }

    /**
     * 
     * @return type
     */
    public function edit($id) {
        $this->cityList(false);
        if (!$id) {
            return 'id is missing';
        }
        $this->data['title'] = 'Dalmia-lams::City-Edit';
        $this->data['pageHeading'] = 'Master City <span class="text-danger" >Edit</span>';

        $this->data['id'] = $id;
        $this->data['cityDetails'] = CityModel::find($id);
//        t( $this->data['cityDetails'],1);
        return view('admin.MasterDataManagement.cityForm', $this->data);
    }

    public function cityList($option = true) {
       
        $city = CityModel::orderBy("city_name","asc")->get();
        $this->data['title'] = 'Dalmia-lams::City-List';
        $this->data['pageHeading'] = 'Master City <span class="text-danger" >List</span>';
 
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
       // $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
	$this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        
     
        $this->data['cityList'] = $city;
      
        if ($option)
            return view('admin.MasterDataManagement.city', $this->data);
        else
            return $city;
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_city_data = isset($posted_data['city']) ? $posted_data['city'] : '';
        //t($posted_data);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        /* $messages = [
          'registration.legal_entity.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Legal Entity is required!</strong></div>',
          'registration.purchase_type_id.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Purchase Type is required!</strong></div>',
          'registration.regn_no.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Document Regn No is required</strong></div>',
          'registration.regn_no.integer' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Document Regn No should be in digits</strong></div>',
          'registration.sub_registrar.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sub & Registrar Office is required</strong></div>',
          'registration.vendor.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Name of Vendor is required</strong></div>',
          'registration.tot_area_unit.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Total Area unit is required</strong></div>',
          'registration.tot_area.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Total Area value is required</strong></div>',
          'registration.tot_area.numeric' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Total Area value should be like (1,0.12,1.5 etc)</strong></div>',
          'registration.tot_cost.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Total Cost is required</strong></div>',
          'registration.tot_cost.numeric' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Total Cost should be like (1,0.12,1.5 etc)</strong></div>',
          ]; */


//        $validator = Validator::make($request->all(), $this->validationRules, $messages);
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return redirect('master/city/management')
                            ->withErrors($validator, 'cityError')
                            ->withInput();
        }
        if ($id) {
            $data_to_update = $posted_city_data;
            //$data_to_insert['updated_id'] = Carbon::now();

            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $updated = CityModel::where('id', $id)->update($data_to_update);
            if ($updated) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/city/management')->with('message', $msg);
            }
        } else {


            $data_to_insert = $posted_city_data;
            //$data_to_insert['created_id'] = Carbon::now();
            $data_to_insert['created_at'] = Carbon::now();
            //$data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['crt_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = CityModel::insertGetId($data_to_insert);

            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/city/management')->with('message', $msg);
            }
        }
    }

}
