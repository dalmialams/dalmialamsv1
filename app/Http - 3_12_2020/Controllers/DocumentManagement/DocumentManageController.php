<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\DocumentManagement;
use App\Http\Controllers\Controller;
use App\Models\LandDetailsManagement\DocumentModel;
use App\Models\Transaction\DataLogModel;
use App\Models\UtilityModel;
use App\Models\Common\CodeModel;
use App\Models\User\UserModel;

use App\Models\Common\VillageModel;
use App\Models\Common\ShapeHistoryModel;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Carbon\Carbon;
use JsValidator;
use File;
use ZipArchive;

/**
 * Description of DocumentManagement
 *
 * @author user-98-pc
 */
class DocumentManageController extends Controller {

     //put your code here
    public $upload_dir = '';
    protected $validationRules = [
        'document.type' => 'required',
        'document.physical_location' => 'required',
    ];
    protected $field_names = [
        'document.type' => 'Document Type',
        'document.physical_location' => 'Physical Location',
    ];

    public function __construct() {
        parent:: __construct();


        $this->allowed_types = ['pdf', 'mp4','PDF','MP4'];
        $this->upload_dir = 'assets/uploads/LandEntryDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        //$this->data['pageHeading'] = 'Document Upload : '.$this->data['reg_uniq_no'];
        $this->data['title'] = 'Dalmia-lams::Document';
        $this->data['section'] = 'document';
        $this->data['document_type'] = $this->getCodesDetails('document_type');
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    public function documentList(Request $request) {
        //$this->data['title'] = 'Dalmia-lams::Document/Add';
        $this->data['pageHeading'] = 'Document <span class="text-danger" >View</span>';
        $this->data['include_script_view'] = 'admin.DocumentManagement.script';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

		$this->data['doc_type_master'] = CodeModel::where(['cd_fl_archive' => 'N'])->get()->toArray();
		$this->data['doc_location'] = DocumentModel::where(['fl_archive' => 'N'])->get()->toArray();

        $posted_data = $request->all();
        $this->data['document_type'] = $document_type = isset($posted_data['document_type']) ? $posted_data['document_type'] : '';
        $this->data['document_location'] = $document_location = isset($posted_data['document_location']) ? $posted_data['document_location'] : '';
        $start_date = isset($posted_data['start_date']) ? date('Y-m-d',strtotime($posted_data['start_date'])) : '';
		if($start_date != '1970-01-01'){
		$this->data['start_date'] = date('d-m-Y',strtotime($start_date));
		}else{
		$this->data['start_date'] = null;			
		}
		
		$end_date = isset($posted_data['end_date']) ? date('Y-m-d',strtotime($posted_data['end_date'])) : '';
		if($end_date != '1970-01-01'){
		$this->data['end_date'] = date('d-m-Y',strtotime($end_date));
		}else{
		$this->data['end_date'] = null;			
		}
		$all_docs = array() ;

	if((isset($document_type) && $document_type != '')|| (isset($document_location) && $document_location != '')||(isset($start_date) && $start_date != '')||(isset($end_date) && $end_date != ''))
	{
	
		$where = '1=1';
		if ($document_type != '') 
		{
		$where .= " and type = '{$document_type}'";
		}
		if ($document_location != '') {
		$where .= " and physical_location = '{$document_location}'";
		}

		if ($start_date != '' && $start_date != '1970-01-01') {
		$where .= " and created_at >= '{$start_date}'";
		}

		if ($end_date != '' && $end_date != '1970-01-01') {
		$where .= " and created_at <= '{$end_date}'";
		}

		$all_docs = DocumentModel::whereRaw($where)->where('fl_archive','N')->orderBy('created_at','desc')->get();
			//t($all_docs);die;

	}
	else{
		$all_docs = array();
		//$all_docs = DocumentModel::where('fl_archive','N')->orderBy('created_at','desc')->get();
	}
		$this->data['all_docs'] = $all_docs;
        return view('admin.DocumentManagement.add', $this->data);
    }

// shp file list
	public function shape_file_list(){
		$this->data['pageHeading'] = 'Shape File <span class="text-danger" >Upload</span>';
		$this->data['include_script_view'] = 'admin.ShapeFileManagement.script';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
		$this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
		$this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where fl_archive = 'N'") );
	//t($this->data['shpHisTables']);die;
		return view('admin.ShapeFileManagement.add', $this->data);
	}
		
	 public function shpDrop($table) {

        if($table){
			$sql = DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
            if(empty($sql)){
                $msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape file dropped successfully!</strong></div>';				
				return redirect('document-management/document/shape-file-list')->with('message', $msg);

            }else{
                $msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';
				return redirect('document-management/document/shape-file-list')->with('message', $msg);
            }
             
         }else{
            $msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Table not found!</strong></div>';
			return redirect('document-management/document/shape-file-list')->with('message', $msg);
         }
    }
	
	public function importShp($table,$data_id) {

        if($table){
			
			$shpTables = DB::select( DB::raw("select * from shptemp." .$table ."") );
			$val = array();
			if(!empty($shpTables)){
			foreach($shpTables as $key=>$val){
				
			$survey_map_data = DB::select( DB::raw("select * from \"T_SURVEY_MAP\" where registration_id = '".$val->reg_id."' and survey_no = '".$val->surveyno."' and village = '".$val->village."'") );			
			
			if(count($survey_map_data) > 0){
                $msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sorry, survey no with the registration id already exists</strong></div>';				
				return redirect('document-management/document/shape-file-list')->with('message', $msg);
			}
			}
			}
			//t(count($survey_map_data));die;
			$sql = DB::select( DB::raw("INSERT INTO public.\"T_SURVEY_MAP\"(wkb_geometry,registration_id,state,district,taluk,village,survey_no) SELECT st_setsrid(st_Force2D(geom),4326),reg_id,state,district,taluk,village,surveyno from shptemp.".$table."") );
            if(!empty($sql)){
   
				/*DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET \"T_SURVEY_MAP\".state = \"T_STATE\".id from \"T_STATE\" where \"T_SURVEY_MAP\".state = \"T_STATE\".state_name");
				
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET \"T_SURVEY_MAP\".district = \"T_DISTRICT\".id from \"T_DISTRICT\" where \"T_SURVEY_MAP\".district = \"T_DISTRICT\".district_name and \"T_SURVEY_MAP\".state = \"T_DISTRICT\".state_id" );
				
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET \"T_SURVEY_MAP\".taluk = \"T_BLOCK\".id from \"T_BLOCK\" where \"T_SURVEY_MAP\".state = \"T_BLOCK\".state_id and \"T_SURVEY_MAP\".district = \"T_BLOCK\".district_id and \"T_SURVEY_MAP\".taluk = \"T_BLOCK\".block_name");
				
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET \"T_SURVEY_MAP\".village_id = \"T_VILLAGE\".id from \"T_VILLAGE\" where \"T_SURVEY_MAP\".state = \"T_VILLAGE\".state_id and \"T_SURVEY_MAP\".district = \"T_VILLAGE\".district_id and \"T_SURVEY_MAP\".taluk = \"T_VILLAGE\".block_id and \"T_SURVEY_MAP\".village = \"T_VILLAGE\".village_name");
				
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET \"T_SURVEY_MAP\".survey_id = \"T_SURVEY\".id from \"T_SURVEY\" where \"T_SURVEY_MAP\".village = \"T_SURVEY\".village_id and \"T_SURVEY_MAP\".survey_no = \"T_SURVEY\".survey_no");
				
				$sql = DB::select( DB::raw("DROP TABLE shptemp.".$table."") );*/
				
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET state = \"T_STATE\".id from \"T_STATE\" where \"T_SURVEY_MAP\".state = \"T_STATE\".state_name");
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET district = \"T_DISTRICT\".id from \"T_DISTRICT\" where \"T_SURVEY_MAP\".district = \"T_DISTRICT\".district_name");
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET taluk = \"T_BLOCK\".id from \"T_BLOCK\" where \"T_SURVEY_MAP\".taluk = \"T_BLOCK\".block_name");
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET village_id = \"T_VILLAGE\".id from \"T_VILLAGE\" where \"T_SURVEY_MAP\".village = \"T_VILLAGE\".village_name");
				DB::statement("UPDATE public.\"T_SURVEY_MAP\" SET survey_id = \"T_SURVEY\".id from \"T_SURVEY\" where \"T_SURVEY_MAP\".registration_id = \"T_SURVEY\".registration_id and \"T_SURVEY_MAP\".survey_no = \"T_SURVEY\".survey_no");
				
				DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
				
				$data_to_update['imported'] = 'Y';
				$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
				$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);


				$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
				return redirect('document-management/document/shape-file-list')->with('message', $msg);

            }else{
                $msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
				return redirect('document-management/document/shape-file-list')->with('message', $msg);
            }
             
         }else{
                $msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Table not found!</strong></div>';				
				return redirect('document-management/document/shape-file-list')->with('message', $msg);
         }
    }
	
	public function shape_map_view($table_name)
	{	
	//echo "hii";die;
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id,surveyno FROM shptemp.".$table_name."";
		$sql .= " where 1=1 ";
		$sql = $sql . ") As lp
		ON lg.\"gid\" = lp.id  ) As f )  As fc;";
		
		$results = DB::select( DB::raw($sql));

		echo $results[0]->geojson;
    }
	
	public function getShpJson()
	{
		$table_name = Input::get('table_name');
		$sql = "SELECT st_extent(geom) FROM shptemp.".$table_name."";
		$sql .= " where 1=1 ";		
		$result = DB::select( DB::raw($sql));
		$data_result['plot_data'] = $result[0];
		
		echo json_encode($data_result);	
	}
	
	 public function shape_file_view($id) {
        $this->data['pageHeading'] = 'Shape File <span class="text-danger" >View</span>';
		$this->data['include_script_view'] = 'admin.ShapeFileManagement.script';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
		$this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
		$this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
		$this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';
		 
			$shape_file_data = ShapeHistoryModel::where('fl_archive','N')->where('id',$id)->get();
			//t($shape_file_data);die;
			if(count($shape_file_data) > 0){
			$imported = $shape_file_data[0]['imported'];
			$shpzip = $shape_file_data[0]['modified_file_name'];
			$shpzip_file = pathinfo($shpzip, PATHINFO_FILENAME);
			
            $shape_file_doc = 'public/assets/files/shp_data/'.$shpzip;
            $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data');		
            $this->allowed_types = array('zip');
            $ext = 'zip';
			
			  if (file_exists($uploaded_path.'/'.$shpzip_file)) {				  
					$file_dir = scandir($uploaded_path.'/'.$shpzip_file);
											unset($file_dir[0]);
						unset($file_dir[1]);

					//t($file_dir);die;
					foreach (array_filter($file_dir) as $name) {
						//echo $uploaded_path . '/'.$shpzip_file.'/' . $name;die;
					unlink($uploaded_path . '/'.$shpzip_file.'/' . $name);
					}
					rmdir($uploaded_path . '/'.$shpzip_file);
					
               }
			   
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, TRUE);
            }
			
			if (in_array($ext, $this->allowed_types)) {			 
                    ## Extract the zip file ---- start
                    $zip = new ZipArchive;
				
                    $res = $zip->open($shape_file_doc);

					//print_r($res);die;
                    if ($res === TRUE) {
                        // Unzip path
									
					
                        $dir = $extractpath = "public\\assets\\files\\shp_extract_data\\" . rtrim($shpzip, '.zip') . "\\";
                        mkdir($extractpath, 0777, TRUE);
                        // Extract file
                        $zip->extractTo($extractpath);
                        $zip->close();
                        //zip_entry_close($zip);
						
					
                        $isshpexist = false;

                        if (is_dir($dir)) {
							
                            if ($dh = opendir($dir)) {
                                while (($file = readdir($dh)) !== false) {
                                    if (filetype($dir . $file) == 'file' && strtolower(pathinfo($dir . $file, PATHINFO_EXTENSION)) == 'shp') {
                                        $shpfile = $file;
                                        $isshpexist = true;
                                        break;
                                    }
                                }
                                closedir($dh);
                            }
                        }
                        if ($isshpexist) {
						$exist_temp_table = DB::select( DB::raw("select * from information_schema.tables where table_schema = 'shptemp'") );
						if(!empty($exist_temp_table)){
							$sql = DB::select( DB::raw("DROP TABLE shptemp.temp_file") );
						}
							
                           // if (!ini_get('safe_mode'))
							set_time_limit(0);
                            putenv('PGPASSWORD=admin@123');
                            putenv('PGUSER=postgres');
                            putenv('PGHOST=localhost');
                            putenv('PGPORT=5432');
                            putenv('PGDATABASE=DALMIA_LAMS_DEV');
                            $table = preg_replace('/\s/', '', rtrim(strtolower($shpfile), '.shp'));
							$table = 'temp_file';
							$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.' . $table . ' | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
							
							//echo $command;
                           // die();
                           exec($command, $op, $ret);

                            $this->data['table'] = $table;
							
                        }else{
							
							echo "no exist";die;
						}
                    } else {
						$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed to extract Zip File!</strong></div>';				
						return redirect('document-management/document/shape-file-list')->with('message', $msg);
                    }
                }else{
						$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Not a valid file type!</strong></div>';				
						return redirect('document-management/document/shape-file-list')->with('message', $msg);

				}
			}
			
			$shpTables = DB::select( DB::raw("select * from information_schema.tables where table_schema = 'shptemp'") );
			$val = array();
			if(!empty($shpTables)){
			foreach($shpTables as $key=>$val){

			$extent = DB::select( DB::raw("select * from shptemp." .$val->table_name) );			
			$val->plot_data = $extent;	
			$village = VillageModel::where(['fl_archive' => 'N'])->get()->toArray();
			$val->village_data = $village; 
			$table_name = $val->table_name;
			}
			}else{
			$shpTables = array();	
			$table_name = '';			
			}
			$this->data['shpTables'] = $val;
			$this->data['shpTables_list'] = $shpTables;
			$this->data['table_name'] = $table_name;
			$this->data['data_id'] = $id;		
			$this->data['imported'] = $imported;			
			return view('admin.ShapeFileManagement.add_view', $this->data);
    }
	
    /*
     * submit
     */
	 /*
     * submit
     */
	 public function processData(Request $request) {
        $posted_data = $request->all();
	
        $messages = [
            'shapeForm.shape_file_doc.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>File is required!</strong></div>',
	   ];

        $rules = [
            'shapeForm.shape_file_doc' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

		$shape_file_doc = isset($posted_data['shape_file_doc']) ? $posted_data['shape_file_doc'] : '';
		if (!empty($shape_file_doc)) {
			
			$file_input = 'SHP_FILE'; //Name of file type input
            $this->allowed_types = array('zip');
            $max_size = 204800000; //(b) | upto 200MB size			
            $uploaded_path = 'public/assets/files/shp_data/';			
			$file = $shape_file_doc->getClientOriginalName();
			$file_name = pathinfo($file, PATHINFO_FILENAME);
			$ext = $shape_file_doc->getClientOriginalExtension();
			$new_file_name = $file_name . '_' . time() . '.' . $ext;
			$shpzip = str_replace(' ', '_', $new_file_name);
			
            $upload_dir = $uploaded_path;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, TRUE);
            }
			
			if (in_array($ext, $this->allowed_types)) {
				$upload = UtilityModel::uploadFile($shape_file_doc, $uploaded_path, $shpzip);
					$data_to_insert['zip_file_name'] = $file;
					$data_to_insert['modified_file_name'] = $new_file_name;
					$data_to_insert['created_at'] = Carbon::now();
					$data_to_insert['created_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
					$data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
					$insert_id = ShapeHistoryModel::insertGetId($data_to_insert);				
			}else{
					$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Not a valid file type!</strong></div>';				
					return redirect('document-management/document/shape-file-list')->with('message', $msg);
				}
                $msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape file uploaded successfully!</strong></div>';				
				return redirect('document-management/document/shape-file-list')->with('message', $msg);

            }

    }
	
	 public function shape_file_remove($id) {
        if (!empty($id)) {
            $data_to_update['fl_archive'] = 'Y';
			$data_to_update['deleted_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
            $delete_id = ShapeHistoryModel::where(['id' => $id])->update($data_to_update);
            if ($delete_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Data deleted successfully!</strong></div>';
                    return redirect('document-management/document/shape-file-list')->with('message', $msg);
            }
        } else {
                $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';
            return redirect('document-management/document/shape-file-list')->with('message', $msg);
        }
    }
	
    public function unauthorized() {

        $this->data['pageHeading'] = 'Unauthorized Access';
        return view('admin.unauthorized', $this->data);
    }

    public function notFound() {

        $this->data['pageHeading'] = '404 not found';
        return view('404', $this->data);
    }

    public function commonSuccessView() {
        $this->data['pageHeading'] = '';
        return view('admin.common_success_msg', $this->data);
    }

}
