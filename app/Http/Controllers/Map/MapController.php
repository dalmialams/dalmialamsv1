<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\Common\StateModel;
use App\Models\Common\DistrictModel;
use App\Models\Common\BlockModel;
use App\Models\Common\VillageModel;
use App\Models\Common\ConversionModel;
use App\Models\Common\CodeModel;
use App\Models\UtilityModel;

use App\Models\LandDetailsManagement\SurveyModel;
use App\Models\LandDetailsManagement\SurveyMapModel;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use File;
use Session;
use ZipArchive;
use Geoserver;
use Config;

use Illuminate\Support\Facades\Schema;
/**
 * Description of AdminController
 *
 * @author user-98-pc
 */
class MapController extends Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->data['pageHeading'] = 'Map';
        $this->data['title'] = 'Dalmia-lams::Map View';
        $states_data = $this->getAllStates();
			if (false !== $key = array_search('Select', $states_data)) {
			unset($states_data[$key]);
			}
		if(!empty($states_data)){
			foreach($states_data as $key => $st_data){
				$whereData = array(array('id',$key) , array('map_exists','N')); 
				$qr_result = StateModel::where($whereData)->get()->toArray();
				if(!empty($qr_result)){
					unset($states_data[$key]);
				}				
			}
		}else{ $states_data = array();}
		
		$this->data['states'] = $states_data;
        $this->data['districts'] = $this->getAllDistrict();
        $this->data['blocks'] = $this->getAllBlock();
        $this->middleware('auth');
    }

    public function landingPage() {

        $this->data['pageHeading'] = '';
        return view('admin.dashboard.landing', $this->data);
    }

    public function map(Request $request) {
		//$geo_url = '192.168.40.199';
		//$geo_url = $_SERVER['HTTP_HOST'];
		//$geo_port = '8080';
		$geo_url = 'landmgmt.dalmiabharat.com';

		//$this->data['geo_url'] = '//'.$geo_url.":".$geo_port.'/geoserver/DALMIA-LAMS/wms';
		$this->data['geo_url'] = '//'.$geo_url.'/geoserver/DALMIA-LAMS/wms';
		$code_master_data = CodeModel::orderBy('id','asc')->get()->toArray();
		$unique_plot_data_list1 = [];
		foreach($code_master_data as $unique_value) $unique_plot_data_list1[$unique_value['cd_type']] = $unique_value;
		$this->data['unique_code_master_list'] = array_values($unique_plot_data_list1);
		//t($code_value_result);die;
		/*foreach ($code_value_result as $key => $value) {
			//t($value['cd_type']);die;
			if($value['cd_type'] == 'document_type' || $value['cd_type'] == 'Land Development Charges' || $value['cd_type'] == 'legal_entity' || $value['cd_type'] == 'payment_mode' || $value['cd_type'] == 'payment_type'
			 || $value['cd_type'] == 'masterdata_type' || $value['cd_type'] == 'purchasing_team' || $value['cd_type'] == 'purchaser_name' || $value['cd_type'] == 'purchaser_name' || $value['cd_type'] == 'purchaser_name'){
			unset($code_value_result[$key]);
			}
		}
		$this->data['unique_code_master_list'] = $code_value_result;
			echo "<pre>";
		print_r($code_value_result);die;*/

		$plot_survey_data = SurveyModel::orderBy('id','asc')->get()->toArray();
		$unique_plot_data_list = [];
		foreach($plot_survey_data as $unique_value) $unique_plot_data_list[$unique_value['classification']] = $unique_value;
		$plot_classification_list = array_values($unique_plot_data_list);
		$code_result = array();
		$code_data = array();
		if(!empty($plot_classification_list)){
		foreach($plot_classification_list as $list_data){
			
			$whereData = array(array('id',$list_data['classification']) , array('cd_fl_archive','N')); 
			$code_result = CodeModel::where($whereData)->get()->toArray();
			if(!empty($code_result)){
			$code_view['code_id'] = $code_result[0]['id'];
			$code_view['code_name'] = $code_result[0]['cd_desc'];			
			$code_view['color_code'] = substr(md5(rand()), 0, 6);
			
			$code_data[]=$code_view;
			}else{
				$code_data = array();
			}

		}
		}else{
			$code_result = array();
			$code_data = array();	
		}
		//echo "<pre>";
		//print_r($code_data);die;
		$this->data['code_data'] = $code_data; 
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';

        return view('admin.map.index', $this->data);
    }
	
	public function getDistrict(Request $request)
	{	
		$state_id = $request->input('state_id');				
		$whereData = array(array('state_id',$state_id) , array('map_exists','Y'), array('fl_archive','N')); 
		$district_result = DistrictModel::where($whereData)->orderBy('district_name','asc')->get()->toArray();
		$select_options = "<option value=''>Select District</option>";
		foreach ($district_result as $key => $value) {
		$select_options .= "<option value='" . $value['id'] . "'>" . $value['district_name'] . "</option>";
		}
		echo $select_options;
	}
	
	public function getClassification(Request $request)
	{	
		$cd_type = $request->input('cd_type');				
		$whereData = array(array('cd_type',$cd_type) , array('cd_fl_archive','N')); 
		$code_value_result = CodeModel::where($whereData)->get()->toArray();
		$select_options = "";
		foreach ($code_value_result as $key => $value) {
		$r = rand(128,255); 
		$g = rand(128,255); 
		$b = rand(128,255); 
		$color_code = "rgb(".$r.",".$g.",".$b.",0.5)";
		//echo $color_code;die;
		$array[$value['id']] = array(
		'color_code' => $color_code,
		'code_desc' => $value['cd_desc']		
		);
		
		//$theme_data = json_encode($array);


		//$select_options .= "<div><i class='colorpick-btn' style='background:#".$color_code."'></i>  " .$value['cd_desc']."</div>";
		
		}
		echo json_encode($array);
	}
	
	/*public function getClassification(Request $request)
	{	
		$cd_type = $request->input('cd_type');				
		$whereData = array(array('cd_type',$cd_type) , array('cd_fl_archive','N')); 
		$code_value_result = CodeModel::where($whereData)->get()->toArray();
		$select_options = "";
		foreach ($code_value_result as $key => $value) {
		//$color_code = substr(md5(rand()), 0, 6);
		
		$r = rand(128,255); 
		$g = rand(128,255); 
		$b = rand(128,255); 
		$color_code = "rgb(".$r.",".$g.",".$b.")";
		
		$array[$value['id']] = array(
		'color_code' => $color_code,
		'code_desc' => $value['cd_desc']		
		);
		
		//$theme_data = json_encode($array);


		//$select_options .= "<div><i class='colorpick-btn' style='background:#".$color_code."'></i>  " .$value['cd_desc']."</div>";
		
		}
		echo json_encode($array);
	}*/
	
	
	    public function getPlotInfo() {
			//echo "hii";die;
        //$this->load->model('region_model');
        $html = '';
		$plotId = 1;
		$coordinate = Input::get('coordinate');	


        //t($coordinate); die('sdsd');
            if ($plotId) {
                //$this->load->model('SurveyModel');
                //$cond = " PLS_PLOT_ID = '" . $plotId . "'";
                $cond = " st_contains(\"T_SURVEY_MAP\".wkb_geometry,ST_GeomFromText('POINT(" . $coordinate[0] . " " . $coordinate[1] . ")',4326)) ";
				//$whereData = " st_contains(\"T_SURVEY_MAP\".wkb_geometry,ST_GeomFromText('POINT(" . $coordinate[0] . " " . $coordinate[1] . ")',4326)) ";
                //$join_cond = array('T_VILLAGE' => array('T_VILLAGE.VLG_ID=T_PLOT.PLS_VILLAGE_ID', 'LEFT'),);
				//$district_result = SurveyModel::where($whereData)->get()->toArray();

       // $plotDetails = SurveyModel::selectRaw("st_contains(\"T_SURVEY_MAP\".wkb_geometry,ST_GeomFromText('POINT(" . $coordinate[0] . " " . $coordinate[1] . ")',4326))");
		
			$plotDetails = SurveyMapModel::whereRaw($cond)->get()->toArray();

			$servey_data = DB::table('SURVEY')
				->leftJoin('SURVEY_MAP', 'SURVEY.id', '=', 'SURVEY_MAP.survey_id')
				->where('SURVEY_MAP.survey_id', '=', $plotDetails[0]['survey_id'])
				->get();
				
			$whereData = array(array('id',$servey_data[0]->classification) , array('cd_fl_archive','N')); 
			$classification_result = CodeModel::where($whereData)->get()->toArray();
			$classification = isset($classification_result[0]['cd_desc'])? $classification_result[0]['cd_desc']:'';

			$whereData2 = array(array('id',$servey_data[0]->zone) , array('cd_fl_archive','N')); 
			$zone_result = CodeModel::where($whereData2)->get()->toArray();
			$zone = isset($classification_result[0]['cd_desc'])? $classification_result[0]['cd_desc'] : '';

			$whereData3 = array(array('id',$servey_data[0]->state) , array('fl_archive','N')); 
			$state_result = StateModel::where($whereData3)->get()->toArray();
			$state_name = isset($state_result[0]['state_name'])? $state_result[0]['state_name'] : '';

			$whereData4 = array(array('id',$servey_data[0]->district) , array('fl_archive','N')); 
			$district_result = DistrictModel::where($whereData4)->get()->toArray();
			$district_name = isset($district_result[0]['district_name'])? $district_result[0]['district_name'] : '';

			$whereData5 = array(array('id',$servey_data[0]->taluk) , array('fl_archive','N')); 
			$block_result = BlockModel::where($whereData5)->get()->toArray();
			$block_name = isset($block_result[0]['block_name'])? $block_result[0]['block_name'] : '';

			$whereData6 = array(array('id',$servey_data[0]->village_id) , array('fl_archive','N')); 
			$village_result = VillageModel::where($whereData6)->get()->toArray();
			$village_name = isset($village_result[0]['village_name'])? $village_result[0]['village_name'] : '';

                //$plotDetails = $this->SurveyModel->fetch($cond);
                //echo $this->db->last_query();
                if (!empty($plotDetails)) {
                   // $PLS_PLOT_TYPE = isset($plotDetails[0]['PLS_PLOT_TYPE']) ? $plotDetails[0]['PLS_PLOT_TYPE'] : '';
                   // $PLS_PLOT_TYPE = $this->all_function->get_dynamic_dropdown('plot_type', $PLS_PLOT_TYPE, true);
				    $extent = DB::select( DB::raw("Select ST_X(ST_Centroid(ST_Transform(wkb_geometry, 4326))) AS long, ST_Y(ST_Centroid(ST_Transform(wkb_geometry, 4326))) AS lat FROM \"T_SURVEY_MAP\" where survey_no ='".$plotDetails[0]['survey_no']."'"));
					$longitude = $extent[0]->long;
					$latitude = $extent[0]->lat;
					$registration_id = $plotDetails[0]['registration_id'];
					
			
                    $html = '<table width="100%"><tbody>
                    <tr><td><b>Survey No: </b></td><td>' . $plotDetails[0]['survey_no'] . '</td></tr>
                    <tr><td><b>Registration No: </b></td><td>' . $registration_id . '</td></tr>
                    <tr><td><b>Latitude: </b></td><td>' . $latitude . '</td></tr>
                    <tr><td><b>Longitude: </b></td><td>' . $longitude . '</td></tr>
                    <tr><td><b>State:</b></td><td>' . $state_name . '</td></tr>
                    <tr><td><b>District:</b></td><td>' . $district_name . '</td></tr>
                    <tr><td><b>Block:</b></td><td>' . $block_name . '</td></tr>
                    <tr><td><b>Village:</b></td><td>' . $village_name . '</td></tr>
                    <tr><td><b>Purchased / Un Purchased:</b></td><td></td></tr>
                    <tr><td><b>Classification of Land:</b></td><td>' . $classification . '</td></tr>
                    <tr><td><b>Zone:</b></td>' . $zone . '<td></td></tr>
                    <tr><td><b>Total Extent of Land:</b></td><td>' . $servey_data[0]->total_area . '</td></tr>
                    <tr><td><b>Guideline Value (Government value) per unit:</b></td><td></td></tr>
                    <tr><td><b>Contiguity, Road Access etc:</b></td><td></td></tr>
                    <tr><td><b>Ownership:</b></td><td></td></tr>';
					if($registration_id != '0'){
					 $html .= '<tr><td></td><td><a class="btn btn-success btn-xs" target="_blank" href="'.URL("land-details-entry/registration/view?reg_uniq_no=".$registration_id."&view=true").'">View</a></td></tr>';
					}else{
					 $html .= '<tr><td></td><td><button class="btn btn-danger btn-xs" style="pointer-events:none;">Not Purchased</button></td></tr>';
					}                  
                        $html .= '</tbody></table>';
                } else {
                    $html = 1;
                }
            } else {
                $html = '<table width="100%"><tbody><tr><td> No data found</td></tr></tbody></table>';
            }
       
        echo (($html == 1) ? $html : $plotDetails[0]['ogc_fid'] . "|" . $html);
    }
	
	public function get_draw_serveyno_json(Request $request) {
		
		$geomjson = $request->input('coordinate');
		
					$cond = " ST_Intersects(ST_setsrid(ST_GeomFromGeoJSON ('".$geomjson."'),4326),\"T_SURVEY_MAP\".wkb_geometry) ";					
					$allPlots = SurveyMapModel::whereRaw($cond)->get()->toArray();
					
					$ogc_fids = implode("','",array_column($allPlots, 'ogc_fid'));
	
					//$ogc_fid = $value['ogc_fid'];
							if ($ogc_fids) {
							$sql = "SELECT row_to_json(fc) as geojson
							FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
							FROM (SELECT 'Feature' As type
							, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
							, row_to_json(lp) As properties
							FROM \"T_SURVEY_MAP\" As lg 
							INNER JOIN (SELECT \"T_SURVEY_MAP\".\"ogc_fid\" as id, \"T_SURVEY_MAP\".\"village\" as village, \"T_SURVEY_MAP\".\"state\" as state, \"T_SURVEY_MAP\".\"survey_no\" as survey_no FROM \"T_SURVEY_MAP\" LEFT JOIN \"T_SURVEY\" ON \"T_SURVEY_MAP\".\"survey_id\"=\"T_SURVEY\".\"id\"";
							$sql .= " where 1=1 ";
     
							$sql = $sql . " AND \"ogc_fid\" IN ('$ogc_fids')";


							$sql = $sql . ") As lp
							ON lg.\"ogc_fid\" = lp.id  ) As f )  As fc;";

							$results = DB::select( DB::raw($sql));

							echo json_encode(json_decode($results[0]->geojson));
							} else {
							echo "No data found";
							}					
					//$data_result['plot_data'] = $plot_no_data;
					//echo json_encode($data_result);			
		}
	
	  public function getPlotGeoJson($plt) {
        //if ($this->input->is_ajax_request()) {
			
        if ($plt) {
            $sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
		, row_to_json(lp) As properties
		FROM \"T_SURVEY_MAP\" As lg 
		INNER JOIN (SELECT \"T_SURVEY_MAP\".\"ogc_fid\" as id, \"T_SURVEY_MAP\".\"village\" as village, \"T_SURVEY_MAP\".\"state\" as state, \"T_SURVEY_MAP\".\"survey_no\" as survey_no FROM \"T_SURVEY_MAP\" LEFT JOIN \"T_SURVEY\" ON \"T_SURVEY_MAP\".\"survey_id\"=\"T_SURVEY\".\"id\"";
            $sql .= " where 1=1 ";

            if (!empty($plt) && $plt != 'null') {
                $sql = $sql . " AND \"ogc_fid\"='$plt'";
            }

            $sql = $sql . ") As lp
		ON lg.\"ogc_fid\" = lp.id  ) As f )  As fc;";
		
		$results = DB::select( DB::raw($sql));

            echo json_encode(json_decode($results[0]->geojson));
        } else {
            echo "No data found";
        }
    }
	
	 public function getPlotSearchGeoJson($plt) {			
        if ($plt) {
            $sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
		, row_to_json(lp) As properties
		FROM \"T_SURVEY_MAP\" As lg 
		INNER JOIN (SELECT \"T_SURVEY_MAP\".\"ogc_fid\" as id, \"T_SURVEY_MAP\".\"village\" as village, \"T_SURVEY_MAP\".\"state\" as state, \"T_SURVEY_MAP\".\"survey_no\" as survey_no FROM \"T_SURVEY_MAP\" LEFT JOIN \"T_SURVEY\" ON \"T_SURVEY_MAP\".\"survey_id\"=\"T_SURVEY\".\"id\"";
            $sql .= " where 1=1 ";

            if (!empty($plt) && $plt != 'null') {
                $sql = $sql . " AND \"survey_id\"='$plt'";
            }

            $sql = $sql . ") As lp
		ON lg.\"ogc_fid\" = lp.id  ) As f )  As fc;";
		//echo $sql;die;
		$results = DB::select( DB::raw($sql));

            echo json_encode(json_decode($results[0]->geojson));
        } else {
            echo "No data found";
        }
    }
	
	
	     
	/*public function get_state_json()
	{	
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
		, row_to_json(lp) As properties
		FROM \"state\" As lg 
		INNER JOIN (SELECT \"ogc_fid\" as id,state_name FROM \"state\"";
		$sql .= " where 1=1 AND wkb_geometry is not null";
		$sql = $sql . ") As lp
		ON lg.\"ogc_fid\" = lp.id  ) As f )  As fc;";
		
		$results = DB::select( DB::raw($sql));

		echo $results[0]->geojson;
		
    }*/	
	
	public function get_state_json(Request $request)
	{
		$survey_no = $request->input('survey_no');				
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
		, row_to_json(lp) As properties
		FROM \"state\" As lg 
		INNER JOIN (SELECT \"ogc_fid\" as id,state_name FROM \"state\"";
		$sql .= " where 1=1 AND wkb_geometry is not null";
		
		if (!empty($survey_no) && $survey_no != 'null') {
		$sql = $sql . " AND \"survey_no\"='$survey_no'";
		}
			
		$sql = $sql . ") As lp
		ON lg.\"ogc_fid\" = lp.id  ) As f )  As fc;";
		
		$results = DB::select( DB::raw($sql));

		echo $results[0]->geojson;
		
    }	
	
	public function getBlock(Request $request)
	{	
		$district_id = $request->input('district_id');				
		$whereData = array(array('district_id',$district_id) ,array('map_exists','Y'), array('fl_archive','N')); 
		$block_result = BlockModel::where($whereData)->orderBy('block_name','asc')->get()->toArray();
		$select_options = "<option value=''>Select Block</option>";
		foreach ($block_result as $key => $value) {
		$select_options .= "<option value='" . $value['id'] . "'>" . $value['block_name'] . "</option>";
		}
		echo $select_options;
	}
	
	public function getSurveyNo(Request $request)
	{	
		$village_id = $request->input('village_id');	
		//$whereData = array(array('village_id',$village_id) , array('fl_archive','N')); 
		//$survey_result = SurveyModel::where($whereData)->get()->toArray();
		
		
		$survey_result = DB::table('SURVEY')
                    ->join('SURVEY_MAP', 'SURVEY.id', '=', 'SURVEY_MAP.survey_id')
                    ->where('SURVEY.village_id', '=', $village_id)
					->where('SURVEY.fl_archive', '=', 'N')
                    ->select('SURVEY.*', 'SURVEY_MAP.*')
                    ->get();
		
		
		
		
		$select_options = "<option value=''>Select Survey No</option>";
		foreach ($survey_result as $key => $value) {
		$select_options .= "<option value='" . $value->id . "'>" . $value->survey_no . "</option>";
		}
		echo $select_options;
	}
	
	public function get_serveyno_json()
	{
		$survey_id = Input::get('survey_id');
//$survey_id = '102/1';		
		$sql = "SELECT st_xmin(wkb_geometry),st_ymin(wkb_geometry),st_xmax(wkb_geometry),st_ymax(wkb_geometry) FROM public.\"T_SURVEY_MAP\"";
		$sql .= " where 1=1 ";
		if (!empty($survey_id) && $survey_id != 'null') {
		$sql = $sql . " AND \"survey_id\"='$survey_id'";
		}		
		$result = DB::select( DB::raw($sql));
		//echo "<pre>";
		//print_r($result[0]);die;
		$data_result['plot_data'] = $result[0];
		
		/*$sql_2 = "Select ST_X(ST_Centroid(ST_Transform(wkb_geometry, 4326))) AS long, ST_Y(ST_Centroid(ST_Transform(wkb_geometry, 4326))) AS lat FROM public.\"T_SURVEY_MAP\"";
		$sql_2 .= " where 1=1 ";
		if (!empty($survey_id) && $survey_id != 'null') {
		$sql_2 = $sql_2 . " AND \"survey_no\"='$survey_id'";
		}		
		$result_2 = DB::select( DB::raw($sql_2));
		$data_result[0]['plot_point_data'] = $result_2[0];	*/
				//print_r($data_result);die;

		echo json_encode($data_result);	
	}
	
	
	public function getVillage(Request $request)
	{	
		$block_id = $request->input('block_id');				
		$whereData = array(array('block_id',$block_id) ,array('map_exists','Y'), array('fl_archive','N')); 
		$village_result = VillageModel::where($whereData)->orderBy('village_name','asc')->get()->toArray();
		$select_options = "<option value=''>Select Village</option>";
		foreach ($village_result as $key => $value) {
		$select_options .= "<option value='" . $value['id'] . "'>" . $value['village_name'] . "</option>";
		}
		echo $select_options;
	}
	
	public function get_classification_json($cd_type=null)
	{		
		
	 /* if (Schema::hasColumn("T_SURVEY", 'area_unit')){
       echo "hiii";die;
      }else{
		       echo "bye";die;
  
	  }*/
	
	 if($cd_type == 'plot_classification'){
		 $cd_type_label = '"T_SURVEY".classification';
		 $cd_query = '"T_SURVEY".classification as theme';		 
	 }else{
		 $cd_type_label = '"T_SURVEY"'.'.'.$cd_type;
		 $cd_query = '"T_SURVEY".'.$cd_type.' as theme';		 
	 }
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.wkb_geometry)::json As geometry
		, row_to_json(lp) As properties
		FROM \"T_SURVEY_MAP\" As lg 
		INNER JOIN (SELECT \"ogc_fid\" as id, \"T_SURVEY_MAP\".village_id, \"T_SURVEY_MAP\".survey_no,".$cd_query.", total_acre FROM \"T_SURVEY_MAP\" LEFT JOIN \"T_SURVEY\" ON \"T_SURVEY_MAP\".\"survey_id\"=\"T_SURVEY\".\"id\"";
		$sql .= " where 1=1";

		$sql = $sql . " AND ".$cd_type_label." is not null";
		
		$sql = $sql . ") As lp
		ON lg.\"ogc_fid\" = lp.id  ) As f )  As fc;";
		//echo $sql;die;

		$results = DB::select( DB::raw($sql));

		echo $results[0]->geojson;
    }
		
	public function getStatePoint() {
		$state_id = Input::get('state_id');
		$html = '';
		$sql = "SELECT st_xmin(wkb_geometry),st_ymin(wkb_geometry),st_xmax(wkb_geometry),st_ymax(wkb_geometry) FROM public.\"T_STATE\"";
		$sql .= " where 1=1 ";
		if (!empty($state_id) && $state_id != 'null') {
		$sql = $sql. " AND \"id\"='$state_id'";
		}		
		$result = DB::select( DB::raw($sql));
		$data_result['plot_point_data'] = $result[0];
		echo json_encode($data_result);	
	}
	
	
	public function getDistrictPoint() {
		$district_id = Input::get('district_id');
		$html = '';
		$sql = "SELECT st_xmin(wkb_geometry),st_ymin(wkb_geometry),st_xmax(wkb_geometry),st_ymax(wkb_geometry) FROM public.\"T_DISTRICT\"";
		$sql .= " where 1=1 ";
		if (!empty($district_id) && $district_id != 'null') {
		$sql = $sql. " AND \"id\"='$district_id'";
		}		
		$result = DB::select( DB::raw($sql));
		$data_result['plot_point_data'] = $result[0];
		echo json_encode($data_result);	
	}
	
	public function uploadKml1(Request $request) {
		if (!empty($shape_file_doc)) {
			
            $this->allowed_types = array('kml');
            $max_size = 204800000; //(b) | upto 200MB size			
            $uploaded_path = 'public/assets/files/kml_data/';
			
			$file_name = $shape_file_doc->getClientOriginalName();
			$ext = $shape_file_doc->getClientOriginalExtension();
			$new_file_name = $file_name . '_' . time() . '.' . $ext;
			$shpzip = str_replace(' ', '_', $new_file_name);
			
            $upload_dir = $uploaded_path;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, TRUE);
            }
			
			if (in_array($ext, $this->allowed_types)) {
				$upload = UtilityModel::uploadFile($shape_file_doc, $uploaded_path, $shpzip);
			 
                    ## Extract the zip file ---- start
                    $zip = new ZipArchive;
				
                    $res = $zip->open($uploaded_path . "/" . $shpzip);

					//print_r($res);die;
                    if ($res === TRUE) {
                        // Unzip path
									
					
                        $dir = $extractpath = "public\\assets\\files\\kml_data\\" . rtrim($shpzip, '.zip') . "\\";
                        mkdir($extractpath, 0777, TRUE);
                        // Extract file
                        $zip->extractTo($extractpath);
                        $zip->close();
                        //zip_entry_close($zip);
						
					
                        $isshpexist = false;

                       
                       
                    } 
                }

            }

	}
	
	public function uploadKml(Request $request)
    {
			$this->allowed_types = ['kml'];
			$kml_input_name = $request->input('kml_input_name');
			//echo $kml_input_name;die;
            $file = $request->file('upload_kml_doc');
			
            $filename  = $file->getClientOriginalName();
			
			//$request->session()->put('kml_layer_name', $kml_input_name);
			//$kml_layer_name =  $request->session()->get('kml_layer_name'); 
			
			//Session::push('kml_layer_name', '".$kml_input_name."');
			//$kml_layer_list = Session::get('kml_layer_name');
			$km_name= array($kml_input_name);
			//Session::set(['kml_layer_name' => $km_name]);
			//$kml_layer_name = Session::get('kml_layer_name');
			
			session(['kml_layer_name' => $km_name]);
			$kml_layer_name = session('kml_layer_name');
			

			
			/*$request->session()->push('kml_layer_name', [
            'layer_name' => $kml_input_name
        ]);*/

			///echo "<pre>";
			//print_r($kml_layer_name);die;
			
			
				$ext = $file->getClientOriginalExtension();
		
            			$new_file_name = $filename . '_' . time() . '.' . $ext;
			$shpzip = str_replace(' ', '_', $new_file_name);
			            $uploaded_path = 'public/assets/files/kml_data/';

            $upload_dir = $uploaded_path;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, TRUE);
            }
			
			if (in_array($ext, $this->allowed_types)) {
				$upload = UtilityModel::uploadFile($file, $uploaded_path, $shpzip);

            return response()->json(["message" => "1","layer_name" => $kml_layer_name]); 
			}			
    }
	
	function exportShp() {
		$fname = 'Plot';
		$filename = 'Plot.zip';
		$this->allowed_types = ['zip'];
	

		$file = File::files(public_path('assets/files/export_shp'));
		if($file){
		foreach ($file as $name) {
		unlink($name);
		}
		}
		//$filename = 'test';
		if ($filename) {
		//$str = '"C:\\Program Files\\PostgreSQL\\9.5\\bin\\pgsql2shp" -f "C:\wamp64\www\dalmia-lams\public\assets\files\export_shp\\' . $filename . '" -h localhost -u postgres -P admin@123 DALMIA_LAMS_DEV public.T_SURVEY_MAP 2>&1';
		$str = '"C:\\Program Files\\PostgreSQL\\9.5\\bin\\pgsql2shp" -f "C:\\Program Files\\OSGeo\\MapGuide\\Web\\www\\Production\\dalmia-lams\\public\\assets\\files\\export_shp\\' . $filename . '" -h 192.168.1.7 -u postgres -P root DALMIA_LAMS_DEV public.T_SURVEY_MAP 2>&1';
		exec($str, $output);
		//print_r($output);
		//echo json_encode($output[1]);
		
		//$this->makezip($filename);
		
				//$dir = $extractpath = "public\\assets\\files\\kml_data\\" . rtrim($shpzip, '.zip') . "\\";
				//mkdir($extractpath, 0777, TRUE);

				$dir = $zippath = public_path('assets/files/export_shp/'. rtrim($filename, '.zip'));

				/*if (!file_exists($dir)) {
				mkdir($zippath, 0777, TRUE);
				}*/
			$ext = 'zip';
			if (in_array($ext, $this->allowed_types)) {

				$zip = new ZipArchive;
				if ($zip->open(public_path('assets/files/export_shp/'.$filename), ZipArchive::CREATE) === TRUE)
				{
				//unlink($name);

				$files = File::files(public_path('assets/files/export_shp'));
				foreach ($files as $key => $value) {
				$relativeNameInZipFile = basename($value);
				$zip->addFile($value, $relativeNameInZipFile);
				}
				$zip->close();
				}
			}

				return response()->download(public_path('assets/files/export_shp/'.$filename));
	
		} else {
            return 'file name missing';
		}
	}
	
	
	public function download1($file_name) {
        //$file_name = $request->get('path');
        if ($file_name) {
            $file_path = ($file_name);
			//echo $file_path;die
			//$file_path = 'C:\\wamp64\\www\\dalmia-lams\\public\\assets\\files\\export_shp\\dummy.pdf';
            return response()->download($file_path);
        } else {
            return 'file name missing';
        }
    }
	
		function makezip($filename) {
//echo $filename;die;			
				$zip = new ZipArchive;
				if ($zip->open(public_path($filename), ZipArchive::CREATE) === TRUE)
				{
				$files = File::files(public_path('assets/files/export_shp'));
				//echo "<pre>";
				//print_r ($files);die;

				foreach ($files as $key => $value) {
				//t($value);die;
				$relativeNameInZipFile = basename($value);
				//echo $relativeNameInZipFile;die;
				$zip->addFile($value, $relativeNameInZipFile);
				}

				$zip->close();
				}

				return response()->download(public_path($filename));
		
		}
		
		public function getZoomGeoJson($vill) {
        //if ($this->input->is_ajax_request()) {
        if (1) {
						
            if ($vill) {
                $sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_SURVEY_MAP\" where 1=1 AND \"village_id\" = '$vill' ";
            } else {
                $sql3 = "";
            }
			$result3 = DB::select( DB::raw($sql3));
            //t($result3);
            if (!empty($result3[0]->st_extent)) {
                echo $extent = str_replace(" ", ",", substr($result3[0]->st_extent, 4, -1));
            } else {
                echo "No data found";
            }
        } else {
            echo "Unauthorised access!";
        }
    }
	
	public function getPlayerGeoJson($layer_name) {
        //if ($this->input->is_ajax_request()) {
        if (1) {
			if($layer_name == 'state_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_STATE\" where wkb_geometry is not null";
			}else if($layer_name == 'district_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_DISTRICT\" where wkb_geometry is not null";
			}else if($layer_name == 'parcel_boundry'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_SURVEY_MAP\" where wkb_geometry is not null";
			}else if($layer_name == 'colony_boundary_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_COLONY_BOUNDARY\" where wkb_geometry is not null";
			}else if($layer_name == 'conveyor_belt_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_CONVEYOR_BELT\" where wkb_geometry is not null";
			}else if($layer_name == 'crusher_location_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_CRUSHER_LOCATION\" where wkb_geometry is not null";
			}else if($layer_name == 'lease_boundary_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_LEASE_BOUNDARY\" where wkb_geometry is not null";
			}else if($layer_name == 'plant_boundary_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_PLANT_BOUNDARY\" where wkb_geometry is not null";
			}else if($layer_name == 'railway_line_boundary_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_RAILWAY_LINE\" where wkb_geometry is not null";
			}else if($layer_name == 'railway_sliding_boundary_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_RAILWAY_SLIDING\" where wkb_geometry is not null";
			}else if($layer_name == 'approach_road_layer'){
			$sql3 = "SELECT st_extent(wkb_geometry) FROM \"T_APPROACH_ROAD\" where wkb_geometry is not null";
			}
			$result3 = DB::select( DB::raw($sql3));
            //t($result3);
            if (!empty($result3[0]->st_extent)) {
                echo $extent = str_replace(" ", ",", substr($result3[0]->st_extent, 4, -1));
            } else {
                echo "No data found";
            }
        } else {
            echo "Unauthorised access!";
        }
    }

	public function exportKml(Request $request) {
		ini_set('max_execution_time', '0');
        $filename = $request->input('filename');
        $ids = $request->input('ids');
		//$ogc_fids = implode("','",$ids);
		//$ids = explode(',',$ids);
		
        if ($filename != "") {
            $edit_sql = "SELECT \"T_SURVEY_MAP\".\"ogc_fid\",\"T_SURVEY_MAP\".\"registration_id\",\"T_SURVEY_MAP\".\"survey_id\",\"T_SURVEY_MAP\".\"survey_no\",\"T_SURVEY_MAP\".\"state\",\"T_SURVEY_MAP\".\"district\",\"T_SURVEY_MAP\".\"taluk\",\"T_SURVEY_MAP\".\"village\",\"T_SURVEY_MAP\".\"village_id\",\"T_SURVEY_MAP\".\"state\",\"T_SURVEY_MAP\".\"village_id\", ST_AsKML(\"T_SURVEY_MAP\".\"wkb_geometry\") FROM \"T_SURVEY_MAP\" LEFT JOIN 
			\"T_VILLAGE\" ON \"T_VILLAGE\".\"id\"=\"T_SURVEY_MAP\".\"village_id\" where \"T_SURVEY_MAP\".\"ogc_fid\" in ($ids)";			
			$query = DB::select( DB::raw($edit_sql));
			$content = '';
		   $string = '';
			   $data = collect($query)->map(function($x){ return (array) $x; })->toArray(); 
										if (!empty($data)) {

				
				
						$string = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
						<kml xmlns=\"http://www.opengis.net/kml/2.2\">
						<Document id=\"root_doc\">
						<Folder>
						<name>plot</name>";
					foreach ($data as $key => $value) {
						
						$servey_data = DB::table('SURVEY')
						->leftJoin('SURVEY_MAP', 'SURVEY.id', '=', 'SURVEY_MAP.survey_id')
						->where('SURVEY_MAP.survey_id', '=', $value['survey_id'])
						->get();

						if($servey_data[0]->classification){
						$whereData = array(array('id',$servey_data[0]->classification) , array('cd_fl_archive','N')); 
						$classification_result = CodeModel::where($whereData)->get()->toArray();
							$classification = isset($classification_result[0]['cd_desc'])? $classification_result[0]['cd_desc']:'';
						}else{
							$classification = '';
						}

						if($servey_data[0]->zone){
						$whereData2 = array(array('id',$servey_data[0]->zone) , array('cd_fl_archive','N')); 
						$zone_result = CodeModel::where($whereData2)->get()->toArray();
							$zone = isset($classification_result[0]['cd_desc'])? $classification_result[0]['cd_desc'] : '';
						}else{
							$zone = '';	
						}
						$registration_id = $value['registration_id'];
						
						if(!empty($value['survey_no'])){
						$extent = DB::select( DB::raw("Select ST_X(ST_Centroid(ST_Transform(wkb_geometry, 4326))) AS long, ST_Y(ST_Centroid(ST_Transform(wkb_geometry, 4326))) AS lat FROM \"T_SURVEY_MAP\" where survey_no ='".$value['survey_no']."'"));
						$longitude = $extent[0]->long;
						$latitude = $extent[0]->lat;
						}else{
							$longitude = '';
							$latitude = '';
						}
						
						//t($value);die;
							$string .= "<Placemark>
							<Style><LineStyle><color>ff0000ff</color></LineStyle><PolyStyle><fill>0</fill></PolyStyle></Style>
							<ExtendedData><SchemaData schemaUrl=\"#plot\">

							<SimpleData name=\"Survey No\">" . $value['survey_no'] . "</SimpleData>
							<SimpleData name=\"Registration No\">" . $registration_id . "</SimpleData>
							<SimpleData name=\"Latitude\">" . $latitude . "</SimpleData>
							<SimpleData name=\"Longitude\">" . $longitude . "</SimpleData>
							<SimpleData name=\"State\">" . $value['state'] . "</SimpleData>
							<SimpleData name=\"District\">" . $value['district'] . "</SimpleData>
							<SimpleData name=\"village\">" . $value['village'] . "</SimpleData>
							<SimpleData name=\"Purchased / Un Purchased\"></SimpleData>
							<SimpleData name=\"Classification of Land\">" . $classification . "</SimpleData>
							<SimpleData name=\"Zone\">" . $zone . "</SimpleData>
							<SimpleData name=\"Total Extent of Land\">" . $servey_data[0]->total_area . "</SimpleData>
							<SimpleData name=\"Guideline Value (Government value) per unit\"></SimpleData>
							<SimpleData name=\"Contiguity, Road Access etc\"></SimpleData>
							<SimpleData name=\"Ownership\"></SimpleData>
							</SchemaData></ExtendedData>
							".$value['st_askml']."
							</Placemark>";                
						}
						$string .= "</Folder>
						</Document>
						</kml>";			

		
                header("Content-Type: application/vnd.google-earth.kml+xml; encoding=utf-8");
                header("Content-Disposition: attachment; filename=$filename.kml");
                echo $string;
            }
        }
    }

}
