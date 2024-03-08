<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\LandEntryManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\Common\SubClassificationModel;
/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class SurveyOnDetails extends Controller {

    //put your code here
    /**
     * 
     */
    public function __construct() {
        parent:: __construct();

        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        //$this->data['pageHeading'] = 'Land Entry Management';
        //$this->data['pageHeading'] = 'Survey No Details : '.$this->data['reg_uniq_no'];
        $this->data['title'] = 'Dalmia-lams::Survey-on-details';
        $this->data['section'] = 'survey';
        $this->data['area_units'] = $this->getCodesDetails('area_unit');
        $this->data['plot_classification'] = $this->getCodesDetails('plot_classification');
        $this->data['land_usage'] = $this->getCodesDetails('land_usage');
        $this->data['include_script_view'] = 'admin.LandEntryManagement.SurveyOnDetails.script';
        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Add</span>';
        $this->data['title'] = 'Dalmia-lams::Survey/Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';

        //Referance registration no
        $reg_uniq_no = $request->input('reg_uniq_no');
        $this->data['reg_uniq_no'] = $reg_uniq_no;

        //Get the survey lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
        $res = SurveyModel::where(['registration_id' => $reg_uniq_no])->get()->toArray();
        $this->data['surveyLists'] = $res;
        
        $grand_total_purchase_area = SurveyModel::selectRaw('sum(purchased_area) as grand_total_purchase_area')->where(['registration_id' => $reg_uniq_no])->get()->toArray();
        $this->data['grand_total_purchase_area'] = $grand_total_purchase_area[0];
        
        //Survey Edit
        $survey_no = $request->input('survey_no');
        if ($survey_no) {
            $this->data['survey_no'] = $survey_no;
            $survey_data = SurveyModel::where(['id' => $survey_no])->get()->toArray();
            $this->data['survey_data'] = $survey_data[0];
            if ($survey_data[0]['classification']) {
                $sub_class = SubClassificationModel::where(['classification_id' => "{$survey_data[0]['classification']}",'fl_archive' => "N"])->orderBy('sub_name')->lists('sub_name', 'id')->toArray();
                $sub_class = array_merge(array('' => 'Select'), $sub_class);
                $this->data['sub_classinfo'] = $sub_class;
            }
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        }
        if($this->data['viewMode']=='true'){
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        }
        
        //get the Registration info
        $reg_info = RegistrationModel::find($reg_uniq_no)->toArray();
        $this->data['reg_data'] = $reg_info;

        return view('admin.LandEntryManagement.SurveyOnDetails.add', $this->data);
    }

    /**
     * 
     * @param type $id
     * @return string
     */
    public function edit($id) {
        if (!$id) {
            return 'id is missing';
        }
        $this->data['id'] = $id;
        return view('admin.LandEntryManagement.Registration.edit', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        //t($posted_data);die();
        $posted_registration_data = isset($posted_data['survey']) ? $posted_data['survey'] : '';
        
        ##############for calculation of cost area wise with respect to regitrstion total cost##########
        $reg_info = RegistrationModel::find($posted_registration_data['registration_id'])->toArray();
        $costPerArea = $reg_info['tot_cost']/$reg_info['tot_area'];
        $costPerArea = round($costPerArea ,3);

        $messages = [
            'survey.survey_no.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey No is required!</strong></div>',
            'survey.area_unit.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Area Unit is required!</strong></div>',
            'survey.total_area.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Area is required</strong></div>',
            'survey.purchased_area.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Purchased Area is required</strong></div>',
            //'survey.total_area.numeric' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Area mustbe numeric</strong></div>',
            'survey.classification.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Classification is required</strong></div>',
        ];

        $rules = [
            'survey.survey_no' => 'required',
            'survey.area_unit' => 'required',
            'survey.total_area' => 'required',
            'survey.purchased_area' => 'required',
            'survey.classification' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($posted_data['survey_no']) {

            if ($validator->fails()) {
                return redirect('land-details-entry/survey/add?reg_uniq_no=' . $posted_registration_data['registration_id'] . '&survey_no=' . $posted_data['survey_no'])
                                ->withErrors($validator, 'survey')
                                ->withInput();
            }
            $data_to_insert = $posted_registration_data;
            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['unit_cost'] = $costPerArea;
            //t($data_to_insert);die('akash');
            $update_id = SurveyModel::where(['id' => $posted_data['survey_no']])->update($data_to_insert);
            if ($update_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey data update successfully!</strong></div>';
                if($posted_data['submit_survey']=='save_continue'){
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }else{
                    return redirect('land-details-entry/survey/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }
            }
        } else {
            if ($validator->fails()) {
                return redirect('land-details-entry/survey/add?reg_uniq_no=' . $posted_registration_data['registration_id'])
                                ->withErrors($validator, 'survey')
                                ->withInput();
            }
            $data_to_insert = $posted_registration_data;
            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['unit_cost'] = $costPerArea;
            //t($data_to_insert);die('akash');
            $insert_id = SurveyModel::insertGetId($data_to_insert);
            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey data saved successfully!</strong></div>';
                if($posted_data['submit_survey']=='save_continue'){
                    return redirect('land-details-entry/document/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }else{
                    return redirect('land-details-entry/survey/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }
                
            }
        }
    }
    
    public function surveyDelete(Request $request) {
        
        $reg_uniq_no = $request->input('reg_uniq_no');
        $survey_no = $request->input('survey_no');
        
        if(!empty($reg_uniq_no) && !empty($survey_no)){
            $delete_id = SurveyModel::where('id', '=', $survey_no)->delete();
            if($delete_id){
               $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey data deleted successfully!</strong></div>'; 
               return redirect('land-details-entry/survey/add?reg_uniq_no=' . $reg_uniq_no)->with('message', $msg);
            }
        }else{
            return redirect('land-details-entry/registration/add'); 
        }
        
    }

}
