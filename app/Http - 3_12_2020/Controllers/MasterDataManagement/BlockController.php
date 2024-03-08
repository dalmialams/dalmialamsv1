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
use App\Models\Common\BlockModel;
use App\Http\Controllers\Auth\AuthController;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;

class BlockController extends Controller {

    //put your code here

    protected $validationRules = [
        'block.block_name' => 'required',
        'block.state_id' => 'required',
        'block.district_id' => 'required',
    ];

    //put your code here
    public function __construct() {
        parent:: __construct();


        $this->data['include_script_view'] = 'admin.MasterDataManagement.script';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['pageHeading'] = 'Master TehsilManagement';
        $this->data['title'] = 'Dalmia-lams::Block';

        $this->data['states'] = $this->getAllStates();
//        $this->data['districtList'] = $this->getAllDistrict();


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
        $this->data['pageHeading'] = 'Master Tehsil <span class="text-danger" >Add</span>';
        //$this->blockList(false);
        return view('admin.MasterDataManagement.blockForm', $this->data);
    }

    /**
     * 
     * @return type
     */
    public function edit($id) {
        $this->blockList(false);

        if (!$id) {
            return 'id is missing';
        }
        $this->data['title'] = 'Dalmia-lams::Block-Edit';
        $this->data['pageHeading'] = 'Master Tehsil <span class="text-danger" >Edit</span>';
        $this->data['id'] = $id;
        $this->data['blockDetails'] = BlockModel::find($id);

        $this->data['districtList'] = $this->getAllDistrict($this->data['blockDetails']['state_id']);
//        t( $this->data['blockDetails'],1);
        return view('admin.MasterDataManagement.blockForm', $this->data);
    }

    public function blockList($option = true) {
        $block = BlockModel::where(["fl_archive"=>'N'])->orderBy("block_name","asc")->get();
        $this->data['title'] = 'Dalmia-lams::Block-List';
        $this->data['pageHeading'] = 'Master Tehsil <span class="text-danger" >List</span>';
        //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
	$this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['blockList'] = $block;

        if ($option)
            return view('admin.MasterDataManagement.block', $this->data);
        else
            return $block;
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_block_data = isset($posted_data['block']) ? $posted_data['block'] : '';
        //t($posted_data);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';


//        $validator = Validator::make($request->all(), $this->validationRules, $messages);
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return redirect('master/tehsil/management')
                            ->withErrors($validator, 'blockError')
                            ->withInput();
        }
        if ($id) {
            $data_to_update = $posted_block_data;
            //$data_to_insert['updated_id'] = Carbon::now();

            $data_to_update['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $updated = BlockModel::where('id', $id)->update($data_to_update);
            if ($updated) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Data saved successfully!</strong></div>';
                return redirect('master/tehsil/management')->with('message', $msg);
            }
        } else {


            $data_to_insert = $posted_block_data;
            //$data_to_insert['created_id'] = Carbon::now();
            $data_to_insert['created_at'] = Carbon::now();
            //$data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['crt_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            $insert_id = BlockModel::insertGetId($data_to_insert);

            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registration data saved successfully!</strong></div>';
                return redirect('master/block/management')->with('message', $msg);
            }
        }
    }

}
