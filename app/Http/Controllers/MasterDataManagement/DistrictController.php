<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MasterDataManagement;

/**
 * Description of DistrictController
 *
 * @author user-98-pc
 */
use App\Http\Controllers\Controller;
use App\Models\Common\DistrictModel;
use App\Http\Controllers\Auth\AuthController;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;

class DistrictController extends Controller {

    //put your code here

    protected $validationRules = [
        'district.state_id' => 'required',
        'district.district_name' => 'required',
    ];

    //put your code here
    public function __construct() {
        parent:: __construct();


        $this->data['include_script_view'] = 'admin.MasterDataManagement.script';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['pageHeading'] = 'Master District Management';
        $this->data['title'] = 'Dalmia-lams::District';
//      $this->data['districts'] = $this->getAllStates();
//      $this->data['area_units'] = $this->getCodesDetails('area_unit');
//      $this->data['purchase_type'] = $this->getCodesDetails('purchase_type');
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
        $this->data['pageHeading'] = 'Master District <span class="text-danger" >Add</span>';


        // $this->districtList(false);

        return view('admin.MasterDataManagement.districtForm', $this->data);
    }

    /**
     * 
     * @return type
     */
    public function edit($id) {
        //  $this->districtList(false);
        if (!$id) {
            return 'id is missing';
        }
        $this->data['title'] = 'Dalmia-lams::District-Edit';
        $this->data['pageHeading'] = 'Master District <span class="text-danger" >Edit</span>';

        $this->data['id'] = $id;
        $this->data['districtDetails'] = $p = DistrictModel::find($id);
        $this->data['stateList'] = $this->getAllStates();
//        t($p->getState->state_name,1);
//        t( $this->data['districtDetails'],1);
        return view('admin.MasterDataManagement.districtForm', $this->data);
    }

    public function districtList($option = true) {
        $district = DistrictModel::where (["fl_archive"=>'N'])->orderBy('state_id')->get();
//        t($district[0]->getState->state_name,1);
        $this->data['title'] = 'Dalmia-lams::District-List';
        $this->data['pageHeading'] = 'Master District <span class="text-danger" >List</span>';

        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
	$this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['districtList'] = $district;
        if ($option)
            return view('admin.MasterDataManagement.district', $this->data);
        else
            return $district;
    }

    public function processData(Request $request) {

        /*
          $districtModel=new DistrictModel;
          $districtModel->attributes=$request->district;
          t($districtModel,1);
          $districtModel->save();
          t($districtModel->attributes);
          t($request->district,1);
         */
        $posted_data = $request->all();


        $posted_district_data = isset($posted_data['district']) ? $posted_data['district'] : '';

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
            return redirect('master/district/management')
                            ->withErrors($validator, 'districtError')
                            ->withInput();
        }
        if ($id) {
            $data_to_update = $posted_district_data;
            //$data_to_insert['updated_id'] = Carbon::now();

            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $updated = DistrictModel::where('id', $id)->update($data_to_update);

            if ($updated) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/district/management')->with('message', $msg);
            }
        } else {


            $data_to_insert = $posted_district_data;
            //$data_to_insert['created_id'] = Carbon::now();
            $data_to_insert['created_at'] = Carbon::now();
            //$data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['crt_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = DistrictModel::insertGetId($data_to_insert);

            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/district/management')->with('message', $msg);
            }
        }
    }

}
