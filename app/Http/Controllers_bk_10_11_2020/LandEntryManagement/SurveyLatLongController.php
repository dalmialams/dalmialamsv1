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
use Illuminate\Support\Facades\Input;
use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\LandDetailsManagement\SurveyMapModel;
use App\Models\LandDetailsManagement\SurveyLatLongModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\Common\SubClassificationModel;
use App\Models\LandDetailsManagement\FamilyModel;
use Illuminate\Support\Facades\DB;

/**
 * Description of SurveyLatLong
 *
 * @author user-98-pc
 */
class SurveyLatLongController extends Controller {

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
        $this->data['title'] = 'Dalmia-lams::Survey-lat-long';
        $this->data['section'] = 'survey_lat_long';
		 $this->upload_dir = 'assets\uploads\FamilyDocs';

        $this->middleware('auth');
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {

        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
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
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-tagsinput/bootstrap-tagsinput.js';
        $res = SurveyMapModel::where(['registration_id' => $reg_uniq_no])->get()->toArray();
       // $res = RegistrationModel::where(['id' => $reg_uniq_no])->get();
        $this->data['surveyLists'] = $res;
		//echo "<pre>";
		//print_r( $this->data['surveyLists']);die;
//       $pp= $res[0]->getGeoPosition;
//       t($pp,1);
//        if ($this->data['viewMode'] == 'true') {
//            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
//        }
        //get the Registration info
        $reg_info = RegistrationModel::find($reg_uniq_no)->toArray();
        $this->data['reg_data'] = $reg_info;

        //$posted_survey_id = $request->get('survey_no');
        //$this->data['posted_survey_id'] = $posted_survey_id;

       // $this->data['include_script_view'] = 'admin.LandEntryManagement.SurveyLatLong.script';
        return view('admin.LandEntryManagement.SurveyLatLong.add', $this->data);
    }
	
	public function serveyJsonView($registration_id)
	{	
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
		, row_to_json(lp) As properties
		FROM \"T_SURVEY_MAP\" As lg 
		INNER JOIN (SELECT \"ogc_fid\" as id,survey_no FROM \"T_SURVEY_MAP\"";
		$sql .= " where 1=1 ";
		if (!empty($registration_id) && $registration_id != 'null') {
		$sql = $sql . " AND \"registration_id\"='$registration_id'";
		}
		$sql = $sql . ") As lp
		ON lg.\"ogc_fid\" = lp.id  ) As f )  As fc;";
		
		$results = DB::select( DB::raw($sql));

		echo $results[0]->geojson;
    }
	public function serveyPlotGeom()
	{
		$reg_uniq_no = Input::get('reg_uniq_no');
		$sql = "SELECT st_extent(wkb_geometry) FROM \"T_SURVEY_MAP\"";
		$sql .= " where 1=1 ";
		if (!empty($reg_uniq_no) && $reg_uniq_no != 'null') {
		$sql = $sql . " AND \"registration_id\"='$reg_uniq_no'";
		}
		$result = DB::select( DB::raw($sql));
		if(!empty($result)){
		$data_result['plot_data'] = $result[0];
		}else{
			$data_result['plot_data'] = array();
		}
		echo json_encode($data_result);	
	}

    public function geoTagView(Request $request) {

        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
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
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-tagsinput/bootstrap-tagsinput.js';
//        $res = SurveyModel::where(['registration_id' => $reg_uniq_no])->get();
        $res = RegistrationModel::where(['id' => $reg_uniq_no])->get();
        $this->data['surveyLists'] = $res;
		
		$survey_res = SurveyModel::where(['registration_id' => $reg_uniq_no, 'fl_archive' => 'N'])->get()->toArray();
        $this->data['surveyPlotData'] = $survey_res;

		//echo "<pre>";
		//print_r($this->data['surveyPlotData']);die;
//       $pp= $res[0]->getGeoPosition;
//       t($pp,1);
        if ($this->data['viewMode'] == 'true') {
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        }

        //get the Registration info
        $reg_info = RegistrationModel::find($reg_uniq_no)->toArray();
        $this->data['reg_data'] = $reg_info;

        $posted_survey_id = $request->get('survey_no');
        $this->data['posted_survey_id'] = $posted_survey_id;

        //family tree 
		$res = FamilyModel::where(['registration_id' => $reg_uniq_no, 'fl_archive' => 'N'])->get()->toArray();
		$this->data['familyLists'] = $res;
		$this->data['upload_dir'] = $this->upload_dir;	
		
        $hof_data = FamilyModel::where(['registration_id' => $reg_uniq_no,'is_hof' => 'Y', 'fl_archive' => 'N'])->get()->toArray();
		$no_image_path1 = URL("assets/img/profile_man.jpg");
		$no_image_path2 = URL("assets/img/profile_women.jpg");
		$html ='No Family Tree Found';
			if(!empty($hof_data))
			{
				$no_image_path1 = URL("assets/img/profile_man.jpg");
				$no_image_path2 = URL("assets/img/profile_women.jpg");
				
				if(!empty($hof_data) && count($hof_data)>0)
				{					
					$hof_name = isset($hof_data[0]['member_name'])?$hof_data[0]['member_name']:'';						
					$hof_photo = isset($hof_data[0]['path'])?$hof_data[0]['path']:$no_image_path1;						

					$html = '<ul>
								<li>
									<a href="javascript:void(0);" class="cat2">
										<span class="parallel-label-box" data-name="'.$hof_name.'"><img src="'. url($hof_photo).'" width="80" height="80"/></span>';
								
								foreach($hof_data as $k=>$family)
								{
									
									$wife_details = $this->get_wife_details($family['id']);					

									if(!empty($wife_details ) && count($wife_details )>0)
									{
									$wife_name = isset($wife_details[0]['member_name'])?$wife_details[0]['member_name']:'';			
									$wife_photo = isset($wife_details[0]['path'])?$wife_details[0]['path']:$no_image_path2;			
									
									$html = $html . '<span class="parallel-label-box" data-name="'.$wife_name.'"><img src="'.url($wife_photo) .'" width="80" height="80"/></span>';
									}
									$html = $html . '</a>';

									if(isset($family['id']) && $family['id']!=''){			
										$children = $this->get_family_child_details($family['id']);
										$html = $html . $children;
									}
								}
							$html = $html .'  </li></ul>';
						}				
				}
			$this->data['familytree'] = $html;
			$res = FamilyModel::where(['registration_id' => $reg_uniq_no, 'fl_archive' => "N"])->get()->toArray();
			$this->data['familyLists'] = $res;
			$whereData = array(array('registration_id',$reg_uniq_no) , array('fl_archive','N') , array('gender' ,'Male'), array('relationship_with_owner' ,'!=','wife')); 
			$member_dropdown_list = FamilyModel::where($whereData)->get()->toArray();
			$this->data['member_dropdown_list'] = $member_dropdown_list;

			
        return view('admin.LandEntryManagement.SurveyLatLong.add', $this->data);
    }
	public function get_wife_details($member_id)
	{		
		$wife_data = FamilyModel::where(['owner_id' => $member_id,'relationship_with_owner' => 'wife','fl_archive' => 'N'])->get()->toArray();
		return $wife_data;		 
	}
	public function get_family_child_details($member_id)
	{
		$no_image_path1 = URL("assets/img/profile_man.jpg");
		$no_image_path2 = URL("assets/img/profile_women.jpg");
		$html ='';
		//$no_image_path = URL("assets/images/no-image.png");

      //  $member_data = FamilyModel::where(['owner_id' => $member_id,'relationship_with_owner', '! = wife','fl_archive' => 'N'])->get()->toArray();
		 
		$whereData = array(array('owner_id',$member_id) ,array('fl_archive','N') , array('relationship_with_owner' ,'!=','wife')); 
		$member_data = FamilyModel::where($whereData)->get()->toArray();
		 
		 if(!empty($member_data) && count($member_data)>0)
		 {
			  $html .= '<ul>';
			 foreach($member_data as $k=>$membrdtls)
			 {
				  $memdtlname = isset($membrdtls['member_name'])?$membrdtls['member_name']:'';
				  $memdtlphoto = isset($membrdtls['path'])?$membrdtls['path']:$no_image_path1;
				  
				  $html .= '<li>
						<a href="javascript:void(0);" class="cat2">
							<span class="parallel-label-box" data-name="'.$memdtlname.'"><img src="'. url($memdtlphoto).'" width="80" height="80"/></span>';

				  $wife_details = $this->get_wife_details($membrdtls['id']);
				  if(!empty($wife_details ) && count($wife_details )>0){
				  $memwfname =  isset($wife_details[0]['member_name'])?$wife_details[0]['member_name']:'';
				  $memwfphoto = isset($wife_details[0]['path'])?$wife_details[0]['path']:$no_image_path2;
				  
					$html .= '<!-- wife section -->
						<span class="parallel-label-box" data-name="'.$memwfname.'"><img src="'.url($memwfphoto).'" width="80" height="80"/></span>';
					}
				  
				  $html .='</a>';
				  $html .=  $this->get_family_child_details($membrdtls['id']);
				  $html .='</li> ';
			 }
			
			 $html .= '</ul>';
		 }
		
		 return $html;
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
        return view('admin.LandEntryManagement.SurveyLatLong.edit', $this->data);
    }

    public function view(Request $request, $id = null) {
        $this->data['include_script_view'] = 'admin.LandEntryManagement.SurveyLatLong.script';
        $this->data['data']['jsArr'][] = ['src' => 'http://maps.google.com/maps/api/js?sensor=true&signed_in=true&libraries=drawing,places', 'type' => 'cdn'];
        //$this->data['data']['jsArr'][] = 'assets/plugins/misc/gmaps/gmaps.js';
        $this->data['data']['jsArr'][] = 'assets/js/ol.js';
        $this->data['data']['jsArr'][] = 'assets/js/ol3gm.js';
        //$this->data['data']['jsArr'][] = 'assets/js/custom.js';

        $reg_uniq_no = $request->input('reg_uniq_no');
        $this->data['reg_uniq_no'] = $reg_uniq_no;

        $id = $request->input('survey_no');
        $this->data['id'] = $id;
        return view('admin.LandEntryManagement.SurveyLatLong.view', $this->data);
    }

    public function rules($request) {
        $rules = [
                //your other rules go here
        ];
        $surveyLatLongs = $request->input();
//t($surveyLatLongs,1);
        if (!empty($surveyLatLongs)) {
            foreach ($surveyLatLongs['surveyLatLong'] as $key => $surveyLatLong) { // add individual rules to each image
                $rules[sprintf('LatLong.%d', $key)] = 'numeric';
                $rules[sprintf('survey_id.%d', $key)] = 'required|numeric';
            }
        }
        return $rules;
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
//        t($posted_data,1);
        $posted_survey_data = isset($posted_data['surveyLatLong']) ? $posted_data['surveyLatLong'] : '';
        $posted_lat_long_data = isset($posted_data['LatLong']) ? $posted_data['LatLong'] : '';

        //  t($posted_lat_long_data,1);
        $messages = [
            // 'surveyLatLong.survey_id.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey No is required!</strong></div>',
            'surveyLatLong.registration_id.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Area Unit is required!</strong></div>',
        ];

        $rules = $this->rules($request);
        $validator = Validator::make($request->all(), $rules, $messages);

//        if (isset($posted_data['survey_no'])) {
        if (isset($posted_data['registration_id'])) {

            if ($validator->fails()) {
                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $posted_survey_data['registration_id'] . '&survey_no=' . $posted_data['survey_no'])
                                ->withErrors($validator, 'survey')
                                ->withInput();
            }

            $data_to_insert = $posted_survey_data;
            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_update['upd_id'] = $this->data['current_user_id'];
            $data_to_insert['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //t($data_to_insert);die('akash');
            $update_id = SurveyModel::where(['id' => $posted_data['survey_no']])->update($data_to_insert);
            if ($update_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey data update successfully!</strong></div>';
                if ($posted_data['submit_surveyLatLong'] == 'save_continue') {
                    // return redirect('land-details-entry/document/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                    $registration_id = $data_to_insert['registration_id'];
                    if ($this->user_type !== 'admin') {
                        if ($this->hasPermission('registration_access') && $this->hasPermission('transaction-details')) {
                            return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit-status')) {
                            return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else {
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id);
                        }
                    } else {
                        //return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    }
                } else {
                    return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }
            }
        } else {

            $data_to_insert['created_at'] = Carbon::now();
            $data_to_insert['crt_id'] = $this->data['current_user_id'];
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //   $data_to_insert['updated_at'] = Carbon::now();


            if (!empty($posted_survey_data['registration_id'])) {


                $data_to_insert['registration_id'] = $posted_survey_data['registration_id'];
                $existing_lat_log_info = SurveyLatLongModel::where(['registration_id' => $posted_survey_data['registration_id']])->get()->toArray();

                $wkb_geometry = isset($existing_lat_log_info[0]['wkb_geometry']) ? $existing_lat_log_info[0]['wkb_geometry'] : '';



                if (!empty($posted_lat_long_data['lat']) && !empty($posted_lat_long_data['long'])) {

                    $lat = $posted_lat_long_data['lat'];
                    $long = $posted_lat_long_data['long'];
                    if (count($lat) == count($long)) {
                        $lat_Long_array = [];
                        foreach ($long as $lkey => $lvalue) {
                            $lat_Long_array[] = $lvalue . ' ' . $lat[$lkey];
                        }
                        $lat_Long_array[] = $long[0] . ' ' . $lat[0];
                        $latlongString = implode(',', $lat_Long_array);
                        $data_to_insert['wkb_geometry'] = DB::raw("ST_GeomFromText('MULTIPOLYGON((($latlongString)))',4326)");
                        if ($wkb_geometry != '') {

                            $update = SurveyLatLongModel::where(['registration_id' => $posted_survey_data['registration_id']])->update($data_to_insert);
                        } else {

                            $insert_id = SurveyLatLongModel::insert($data_to_insert);
                        }
                        //;  
                    } else {
                        $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>No of lat long value is not equal!</strong></div>';
                        return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                    }
                }
            }
            //  exit;

            if (isset($insert_id) || isset($update)) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey data saved successfully!</strong></div>';
                if ($posted_data['submit_surveyLatLong'] == 'save_continue') {
                    //return redirect('land-details-entry/lease/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                    $registration_id = $data_to_insert['registration_id'];
                    if ($this->user_type !== 'admin') {
                        if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                            return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                            return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else {
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id);
                        }
                    } else {
                        //return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    }
                } else {
                    return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }
            } else {
                $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>All submited fields are empty ,Someting went wrong!</strong></div>';
                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
            }
        }
    }

    public function surveyDelete(Request $request) {

        $reg_uniq_no = $request->input('reg_uniq_no');
        $survey_id = $request->input('survey_id');

        $surLatLongDetails = SurveyLatLongModel::where('survey_id', '=', $survey_id)->toArray();

        t($surLatLongDetails, 1);

        if (!empty($reg_uniq_no) && !empty($survey_id) && !empty($surLatLongDetails)) {
            $delete_id = SurveyLatLongModel::where('survey_id', '=', $survey_id)->delete();
            if ($delete_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey data deleted successfully!</strong></div>';
                return redirect('land-details-entry/survey/add?reg_uniq_no=' . $reg_uniq_no)->with('message', $msg);
            }
        } else {
            $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Survey lat log details not present!</strong></div>';
            return redirect('land-details-entry/registration/add?reg_uniq_no=' . $reg_uniq_no)->with('message', $msg);
        }
    }

    public function getGeoJSONSurvey(Request $request) {

        $reg_uniq_no = $request->input('reg_no');
        $survey_id = $request->input('id');

        $sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
		, row_to_json(lp) As properties
		FROM \"T_PLOT_GEOMETRY\" As lg 
		INNER JOIN (SELECT id , survey_no FROM \"T_PLOT_GEOMETRY\"";
        if (!empty($reg_uniq_no)) {
            $sql = $sql . " where registration_id='$reg_uniq_no'";
        }
        if (!empty($survey_id)) {
            $sql = $sql . " and survey_id='$survey_id'";
        }
        $sql = $sql . ") As lp
		ON lg.id = lp.id  ) As f )  As fc;";

        $result = DB::select($sql);
        //t($result,1);
        echo $result[0]->geojson;
    }

    public function getExtentSurvey(Request $request) {

        $reg_uniq_no = $request->input('reg_no');
        $survey_id = $request->input('id');

        $sql = "SELECT ST_XMin(r) AS minx, ST_YMin(r) AS miny, ST_XMax(r) AS maxx,  ST_YMax(r) AS maxy  FROM  (SELECT ST_Collect(wkb_geometry) AS r FROM \"T_PLOT_GEOMETRY\"";
        if (!empty($reg_uniq_no)) {
            $sql = $sql . " where registration_id='$reg_uniq_no'";
        }
        if (!empty($survey_id)) {
            $sql = $sql . " and survey_id='$survey_id'";
        }

        $sql .= ') AS foo';

        $result = DB::select($sql);
        //t($result,1);
        echo json_encode($result[0]);
    }

    private function hasPermission($permission_name) {
        $user_obj = new \App\Models\User\UserModel();
        if ($user_obj->ifHasPermission($permission_name, $this->data['current_user_id'])) {
            return true;
        } else {
            return false;
        }
    }

}
