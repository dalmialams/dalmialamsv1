<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MasterDataManagement;

/**
 * Description of BlockController
 *
 * @author user-98-pc
 */
use App\Http\Controllers\Controller;
use App\Models\Common\SubClassificationModel;
use App\Http\Controllers\Auth\AuthController;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;

class SubClassificationController extends Controller {

    //put your code here

    protected $validationRules = [
        'sub_classification.sub_name' => 'required',
        'sub_classification.classification_id' => 'required',
    ];

    //put your code here
    public function __construct() {
        parent:: __construct();


        $this->data['include_script_view'] = 'admin.MasterDataManagement.script';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['pageHeading'] = 'Master Sub Classification Management';
        $this->data['title'] = 'Dalmia-lams::Block';

        $this->data['states'] = $this->getAllStates();
        $this->data['classificationList'] = $this->getCodesDetails('plot_classification');


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
        $this->data['pageHeading'] = 'Master Sub Classification <span class="text-danger" >Add</span>';
        //$this->sub_classificationList(false);
        return view('admin.MasterDataManagement.subClassificationForm', $this->data);
    }

    /**
     * 
     * @return type
     */
    public function edit($id) {
        $this->sub_classificationList(false);

        if (!$id) {
            return 'id is missing';
        }
        $this->data['title'] = 'Dalmia-lams::Block-Edit';
        $this->data['pageHeading'] = 'Master Sub Classification <span class="text-danger" >Edit</span>';
        $this->data['id'] = $id;
        $this->data['sub_classificationDetails'] = SubClassificationModel::find($id);

        $this->data['districtList'] = $this->getAllDistrict($this->data['sub_classificationDetails']['state_id']);
//        t( $this->data['sub_classificationDetails'],1);
        return view('admin.MasterDataManagement.subClassificationForm', $this->data);
    }

    public function sub_classificationList($option = true) {
        $sub_classification = SubClassificationModel::where(["fl_archive"=>'N'])->orderBy("sub_name","asc")->get();
     
        $this->data['title'] = 'Dalmia-lams::Sub-Classification-List';
        $this->data['pageHeading'] = 'Master Sub Classification <span class="text-danger" >List</span>';
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
	$this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['sub_classificationList'] = $sub_classification;

        if ($option)
            return view('admin.MasterDataManagement.subClassification', $this->data);
        else
            return $sub_classification;
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_sub_classification_data = isset($posted_data['sub_classification']) ? $posted_data['sub_classification'] : '';
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
            return redirect('master/sub_classification/management')
                            ->withErrors($validator, 'sub_classificationError')
                            ->withInput();
        }
        if ($id) {
            $data_to_update = $posted_sub_classification_data;
            //$data_to_insert['updated_id'] = Carbon::now();

            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $updated = SubClassificationModel::where('id', $id)->update($data_to_update);
            if ($updated) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/sub_classification/management')->with('message', $msg);
            }
        } else {


            $data_to_insert = $posted_sub_classification_data;
            //$data_to_insert['created_id'] = Carbon::now();
            $data_to_insert['created_at'] = Carbon::now();
            //$data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['crt_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = SubClassificationModel::insertGetId($data_to_insert);

            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/sub_classification/management')->with('message', $msg);
            }
        }
    }

}
