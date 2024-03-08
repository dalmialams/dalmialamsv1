<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MasterDataManagement;

/**
 * Description of StateController
 *
 * @author user-98-pc
 */
use App\Http\Controllers\Controller;
use App\Models\Common\StateModel;
use App\Http\Controllers\Auth\AuthController;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;

class StateController extends Controller {

    //put your code here

    protected $validationRules = [
        'state.state_name' => 'required',
        'state.state_prefix' => 'required',
        'state.fl_archive' => 'required',
    ];

    //put your code here
    public function __construct() {
        parent:: __construct();


        $this->data['include_script_view'] = 'admin.MasterDataManagement.script';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['pageHeading'] = 'Master State Management';
        $this->data['title'] = 'Dalmia-lams::State';
//        $this->data['states'] = $this->getAllStates();
//        $this->data['area_units'] = $this->getCodesDetails('area_unit');
//        $this->data['purchase_type'] = $this->getCodesDetails('purchase_type');
//        $this->data['stateList'] = $this->getAllStates();
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

        $this->stateList(false);
        $this->data['pageHeading'] = 'Master State <span class="text-danger" >Add</span>';


        return view('admin.MasterDataManagement.stateForm', $this->data);
    }

    /**
     * 
     * @return type
     */
    public function edit($id) {
        $this->stateList(false);
        if (!$id) {
            return 'id is missing';
        }
        $this->data['title'] = 'Dalmia-lams::State-Edit';
        $this->data['pageHeading'] = 'Master State <span class="text-danger" >Edit</span>';

        $this->data['id'] = $id;
        $this->data['stateDetails'] = StateModel::find($id);
//        t( $this->data['stateDetails'],1);
        return view('admin.MasterDataManagement.stateForm', $this->data);
    }

    public function stateList($option = true) {
        $state = StateModel::orderBy("state_name", "asc")->get()->toArray();
        $this->data['title'] = 'Dalmia-lams::State-List';
        $this->data['pageHeading'] = 'Master State <span class="text-danger" >List</span>';

        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
	$this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';

        $this->data['stateList'] = $state;
        if ($option)
            return view('admin.MasterDataManagement.state', $this->data);
        else
            return $state;
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_state_data = isset($posted_data['state']) ? $posted_data['state'] : '';
        //t($posted_data);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
       
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return redirect('master/state/management')
                            ->withErrors($validator, 'stateError')
                            ->withInput();
        }
        if ($id) {
            $data_to_update = $posted_state_data;
            //$data_to_insert['updated_id'] = Carbon::now();

            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $updated = StateModel::where('id', $id)->update($data_to_update);
            if ($updated) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/state/management')->with('message', $msg);
            }
        } else {


            $data_to_insert = $posted_state_data;
            //$data_to_insert['created_id'] = Carbon::now();
            $data_to_insert['created_at'] = Carbon::now();
            //$data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['crt_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = StateModel::insertGetId($data_to_insert);

            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/state/management')->with('message', $msg);
            }
        }
    }

}
