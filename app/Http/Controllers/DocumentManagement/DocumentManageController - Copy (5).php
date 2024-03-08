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
use App\Models\Common\DistrictModel;
use App\Models\Common\StateModel;
use App\Models\Common\BlockModel;
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
        $this->data['section'] = 'survey_plot';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='survey_plot' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.add', $this->data);
	}
	
	 // Mining Lease Boundary
	public function mining_lease_boundary(){
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
		
        $this->data['section'] = 'mining_lease_boundary';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='mining_lease_boundary' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.MiningLeaseBoundary.add', $this->data);
	}
	
	 // Plant Boundary
	public function plant_boundary(){
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
        
		$this->data['section'] = 'plant_boundary';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='plant_boundary' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.PlantBoundary.add', $this->data);
	}
	
	 // Truckyard
	public function truckyard(){
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

        $this->data['section'] = 'truckyard';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='truckyard' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.Truckyard.add', $this->data);
	}
	
	 // Railway Sliding Boundary
	public function railway_sliding_boundary(){
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

		$this->data['section'] = 'railway_sliding_boundary';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='railway_sliding_boundary' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.RailwaySlidingBoundary.add', $this->data);
	}
	
	// Approach Road
	public function approach_road(){
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

		$this->data['section'] = 'approach_road';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='approach_road' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.ApproachRoad.add', $this->data);
	}
	
	// Conveyor Belt
	public function conveyor_belt(){
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

		$this->data['section'] = 'conveyor_belt';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='conveyor_belt' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.ConveyorBelt.add', $this->data);
	}
	
    // Railway Track
	public function railway_track(){
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

		$this->data['section'] = 'railway_track';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='railway_track' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.RailwayTrack.add', $this->data);
	}

    // Crusher Location
	public function crusher_location(){
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

		$this->data['section'] = 'crusher_location';
		$this->data['shpHisTables'] = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where shp_type='crusher_location' and fl_archive = 'N'") );
		return view('admin.ShapeFileManagement.CrusherLocation.add', $this->data);
	}

    // Drop Shape File	
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
	
	// shape import
	public function importShp($table,$shp_type,$data_id) {

        if($table){
			
			if($shp_type == 'mining_lease_boundary'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_LEASE_BOUNDARY\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
						
						$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
						return redirect('document-management/document/mining-lease-boundary')->with('message', $msg);
					}
					else{
						$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
						return redirect('document-management/document/mining-lease-boundary')->with('message', $msg);
					}
				
			}
			if($shp_type == 'plant_boundary'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_PLANT_BOUNDARY\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
						
						$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
							return redirect('document-management/document/plant-boundary')->with('message', $msg);
						}
						else{
							$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
							return redirect('document-management/document/plant-boundary')->with('message', $msg);
						}
			}elseif($shp_type == 'colony_boundary'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_COLONY_BOUNDARY\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
						
						$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
							return redirect('document-management/document/colony-boundary')->with('message', $msg);
						}
						else{
							$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
							return redirect('document-management/document/colony-boundary')->with('message', $msg);
						}
			}elseif($shp_type == 'railway_sliding_boundary'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_RAILWAY_SLIDING\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
						
						$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
						return redirect('document-management/document/railway-sliding-boundary')->with('message', $msg);
						}
						else{
						$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
						return redirect('document-management/document/railway-sliding-boundary')->with('message', $msg);
						}
			}elseif($shp_type == 'approach_road_boundary'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_APPROACH_ROAD\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
							$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
							return redirect('document-management/document/approach-road')->with('message', $msg);
							}
							else{
							$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
							return redirect('document-management/document/approach-road')->with('message', $msg);
							}
			}elseif($shp_type == 'conveyor_belt_boundary'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_CONVEYOR_BELT\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
							$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
							return redirect('document-management/document/conveyor-belt')->with('message', $msg);
							}
							else{
							$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
							return redirect('document-management/document/conveyor-belt')->with('message', $msg);
							}
			}elseif($shp_type == 'railway_track_boundary'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_RAILWAY_LINE\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
							$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
							return redirect('document-management/document/railway-track')->with('message', $msg);
							}
							else{
							$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
							return redirect('document-management/document/railway-track')->with('message', $msg);
							}
			}elseif($shp_type == 'crusher_location_boundary'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_CRUSHER_LOCATION\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
							$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
							return redirect('document-management/document/crusher-location')->with('message', $msg);
							}
							else{
							$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
							return redirect('document-management/document/crusher-location')->with('message', $msg);
							}
			}elseif($shp_type == 'truckyard'){
				$sql = DB::select( DB::raw("INSERT INTO public.\"T_TRUCKYARD\"(wkb_geometry) SELECT st_setsrid(st_Force2D(geom),4326) from shptemp.".$table."") );	
					if(!empty($sql)){
						DB::select( DB::raw("DROP TABLE shptemp.".$table."") );
						$data_to_update['imported'] = 'Y';
						$data_to_update['imported_by_user_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
						$update_id = ShapeHistoryModel::where(['id' => $data_id])->update($data_to_update);
							$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data imported successfully!</strong></div>';				
							return redirect('document-management/document/truckyard')->with('message', $msg);
							}
							else{
							$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong!</strong></div>';				
							return redirect('document-management/document/truckyard')->with('message', $msg);
							}
			}
			
			else{
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
				
				
				DB::statement("UPDATE public.\"T_STATE\" SET map_exists = 'Y' from \"T_SURVEY_MAP\" where \"T_SURVEY_MAP\".state = \"T_STATE\".id");
				DB::statement("UPDATE public.\"T_DISTRICT\" SET map_exists = 'Y' from \"T_SURVEY_MAP\" where \"T_SURVEY_MAP\".district = \"T_DISTRICT\".id");
				DB::statement("UPDATE public.\"T_BLOCK\" SET map_exists = 'Y' from \"T_SURVEY_MAP\" where \"T_SURVEY_MAP\".taluk = \"T_BLOCK\".id");
				DB::statement("UPDATE public.\"T_VILLAGE\" SET map_exists = 'Y' from \"T_SURVEY_MAP\" where \"T_SURVEY_MAP\".village_id = \"T_VILLAGE\".id");

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
			}
             
         }else{
                $msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Table not found!</strong></div>';				
				return redirect('document-management/document/shape-file-list')->with('message', $msg);
         }
    }
	
	public function shape_map_view($shp_type,$table_name)
	{
		//echo $shp_type;
	if($shp_type == 'mining_lease_boundary'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type == 'plant_boundary'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type == 'colony_boundary'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type == 'truckyard'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type == 'railway_sliding_boundary'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type == 'approach_road'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type == 'conveyor_belt'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type == 'railway_track'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type == 'crusher_location'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id FROM shptemp.".$table_name."";
		
	}elseif($shp_type = 'survey_plot'){
		
		$sql = "SELECT row_to_json(fc) as geojson
		FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		FROM (SELECT 'Feature' As type
		, ST_AsGeoJSON(lg.geom)::json As geometry
		, row_to_json(lp) As properties
		FROM shptemp.".$table_name." As lg 
		INNER JOIN (SELECT \"gid\" as id,surveyno FROM shptemp.".$table_name."";	
	}
		
		$sql .= " where 1=1 ";
		$sql = $sql . ") As lp
		ON lg.\"gid\" = lp.id  ) As f )  As fc;";
		//echo $sql;die;
		
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
	
	 public function shape_file_view($id,$shp_type,$type='') { 
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
		 
			$shape_file_data = ShapeHistoryModel::where('fl_archive','N')->where('id',$id)->orderBy('created_at','desc')->get();
			//t($shape_file_data);die;
			if(count($shape_file_data) > 0){
			$imported = $shape_file_data[0]['imported'];
			$shpzip = $shape_file_data[0]['modified_file_name'];
			$shpzip_file = pathinfo($shpzip, PATHINFO_FILENAME);
		    if($type!='edited'){
			if($shp_type =='mining_lease_boundary'){
			  $shape_file_doc = 'public/assets/files/shp_data/mining_lease_boundary/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/mining_lease_boundary/');
			}elseif($shp_type =='plant_boundary'){
			  $shape_file_doc = 'public/assets/files/shp_data/plant_boundary/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/plant_boundary/');
			}elseif($shp_type =='colony_boundary'){
			  $shape_file_doc = 'public/assets/files/shp_data/colony_boundary/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/colony_boundary/');
			}elseif($shp_type =='truckyard'){
			  $shape_file_doc = 'public/assets/files/shp_data/truckyard/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/truckyard/');
			}elseif($shp_type =='railway_sliding_boundary'){
			  $shape_file_doc = 'public/assets/files/shp_data/railway_sliding_boundary/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/railway_sliding_boundary/');
			}elseif($shp_type =='approach_road'){
			  $shape_file_doc = 'public/assets/files/shp_data/approach_road/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/approach_road/');
			}elseif($shp_type =='conveyor_belt'){
			  $shape_file_doc = 'public/assets/files/shp_data/conveyor_belt/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/conveyor_belt/');
			}elseif($shp_type =='railway_track'){
			  $shape_file_doc = 'public/assets/files/shp_data/railway_track/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/railway_track/');
			}elseif($shp_type =='crusher_location'){
			  $shape_file_doc = 'public/assets/files/shp_data/crusher_location/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/crusher_location/');
			}elseif($shp_type =='survey_plot'){
			  $shape_file_doc = 'public/assets/files/shp_data/'.$shpzip;
			  $uploaded_path = $upload_dir = public_path('assets/files/shp_extract_data/');	
			}			
						
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
											
							if($shp_type =='mining_lease_boundary'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\mining_lease_boundary\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='plant_boundary'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\plant_boundary\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='colony_boundary'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\colony_boundary\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='truckyard'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\truckyard\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='railway_sliding_boundary'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\railway_sliding_boundary\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='approach_road'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\approach_road\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='conveyor_belt'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\conveyor_belt\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='railway_track'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\railway_track\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='crusher_location'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\crusher_location\\" . rtrim($shpzip, '.zip') . "\\";
							}elseif($shp_type =='survey_plot'){
								$dir = $extractpath = "public\\assets\\files\\shp_extract_data\\" . rtrim($shpzip, '.zip') . "\\";
							}
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
								
								foreach($exist_temp_table as $temp_table){
																
									if($temp_table->table_name == 'temp_mining_lease_boundary' && $shp_type =='mining_lease_boundary'){
										if($temp_table->table_name == 'temp_mining_lease_boundary'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_mining_lease_boundary") );
										}
										break;
									}elseif($temp_table->table_name == 'temp_plant_boundary' && $shp_type =='plant_boundary'){
										if($temp_table->table_name == 'temp_plant_boundary'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_plant_boundary") );
										}
										break;
									}elseif($temp_table->table_name == 'temp_colony_boundary' && $shp_type =='colony_boundary'){
										if($temp_table->table_name == 'temp_colony_boundary'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_colony_boundary") );
										}
										break;
									}elseif($temp_table->table_name == 'temp_truckyard' && $shp_type =='truckyard'){
										if($temp_table->table_name == 'temp_truckyard'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_truckyard") );
										}
										break;
									}elseif($temp_table->table_name == 'temp_approach_road' && $shp_type =='approach_road'){
										if($temp_table->table_name == 'temp_approach_road'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_approach_road") );
										}
										break;
									}elseif($temp_table->table_name == 'temp_conveyor_belt' && $shp_type =='conveyor_belt'){
										if($temp_table->table_name == 'temp_conveyor_belt'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_conveyor_belt") );
										}
										break;
									}elseif($temp_table->table_name == 'temp_railway_track' && $shp_type =='railway_track'){
										if($temp_table->table_name == 'temp_railway_track'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_railway_track") );
										}
									}elseif($temp_table->table_name == 'temp_crusher_location' && $shp_type =='crusher_location'){
										if($temp_table->table_name == 'temp_crusher_location'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_crusher_location") );
										}
										break;
									}
									elseif($temp_table->table_name == 'temp_file' && $shp_type =='survey_plot'){
										if($temp_table->table_name == 'temp_file'){
									      $sql = DB::select( DB::raw("DROP TABLE shptemp.temp_file") );	
										}
										break;
									}
								  }
								}
									
								   // if (!ini_get('safe_mode'))
									set_time_limit(0);
									putenv('PGPASSWORD=admin@123');
									putenv('PGUSER=postgres');
									putenv('PGHOST=localhost');
									putenv('PGPORT=5432');
									putenv('PGDATABASE=DALMIA_LAMS');
									$table = preg_replace('/\s/', '', rtrim(strtolower($shpfile), '.shp'));
									$table = 'temp_file';
									
									if($shp_type =='mining_lease_boundary'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_mining_lease_boundary | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
									}elseif($shp_type =='plant_boundary'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_plant_boundary | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
									}elseif($shp_type =='colony_boundary'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_colony_boundary | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
									}elseif($shp_type =='truckyard'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_truckyard | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
									}elseif($shp_type =='approach_road'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_approach_road | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
									}elseif($shp_type =='conveyor_belt'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_conveyor_belt | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
									}elseif($shp_type =='railway_track'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_railway_track | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
									}elseif($shp_type =='crusher_location'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_crusher_location | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';
									}elseif($shp_type =='survey_plot'){
									$command = '"D:\\PostgreSQL\\9.5\\bin\\shp2pgsql" -d "' . base_path().'\\' . $dir . $shpfile . '" shptemp.temp_file | "D:\\PostgreSQL\\9.5\\bin\\psql" -h localhost -d "DALMIA_LAMS" -U postgres';	
									}
									
									//echo $command;
								   // die();
								   exec($command, $op, $ret);

									$this->data['table'] = $table;
									
								}else{
									
									echo "no exist";die;
								}
							} else {
								$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed to extract Zip File!</strong></div>';
                                if($shp_type =='mining_lease_boundary'){								
								return redirect('document-management/document/mining-lease-boundary')->with('message', $msg);
								}elseif($shp_type =='plant_boundary'){								
								return redirect('document-management/document/plant-boundary')->with('message', $msg);
								}elseif($shp_type =='colony_boundary'){								
								return redirect('document-management/document/colony-boundary')->with('message', $msg);
								}elseif($shp_type =='truckyard'){								
								return redirect('document-management/document/truckyard')->with('message', $msg);
								}elseif($shp_type =='approach_road'){								
								return redirect('document-management/document/approach_road')->with('message', $msg);
								}elseif($shp_type =='conveyor_belt'){								
								return redirect('document-management/document/conveyor-belt')->with('message', $msg);
								}elseif($shp_type =='railway_track'){								
								return redirect('document-management/document/railway-track')->with('message', $msg);
								}elseif($shp_type =='crusher_location'){								
								return redirect('document-management/document/crusher-location')->with('message', $msg);
								}elseif($shp_type =='survey_plot'){
								return redirect('document-management/document/shape-file-list')->with('message', $msg);	
								}
							}
			}
						}else{
							$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Not a valid file type!</strong></div>';
								
								if($shp_type =='mining_lease_boundary'){								
								return redirect('document-management/document/mining-lease-boundary')->with('message', $msg);
								}elseif($shp_type =='plant_boundary'){								
								return redirect('document-management/document/plant-boundary')->with('message', $msg);
								}elseif($shp_type =='colony_boundary'){								
								return redirect('document-management/document/colony-boundary')->with('message', $msg);
								}elseif($shp_type =='truckyard'){								
								return redirect('document-management/document/truckyard')->with('message', $msg);
								}elseif($shp_type =='approach_road'){								
								return redirect('document-management/document/approach_road')->with('message', $msg);
								}elseif($shp_type =='conveyor_belt'){								
								return redirect('document-management/document/conveyor-belt')->with('message', $msg);
								}elseif($shp_type =='railway_track'){								
								return redirect('document-management/document/railway-track')->with('message', $msg);
								}elseif($shp_type =='crusher_location'){								
								return redirect('document-management/document/crusher-location')->with('message', $msg);
								}elseif($shp_type =='survey_plot'){
								return redirect('document-management/document/shape-file-list')->with('message', $msg);	
								}									
						} 
			    
			
			$shpTables = DB::select( DB::raw("select * from information_schema.tables where table_schema = 'shptemp'") );
			$val = array();
			//t($shpTables);die;
			if(!empty($shpTables)){
			foreach($shpTables as $key=>$val){
            if($val->table_name == 'temp_mining_lease_boundary' && $shp_type =='mining_lease_boundary'){	
			$extent = DB::select( DB::raw("select * from shptemp.temp_mining_lease_boundary") );		
			$val->plot_data = $extent;
			$table_name = 'temp_mining_lease_boundary';	
            break;			
			}elseif($val->table_name == 'temp_plant_boundary' && $shp_type =='plant_boundary'){	
			$extent = DB::select( DB::raw("select * from shptemp.temp_plant_boundary") );		
			$val->plot_data = $extent;
			$table_name = 'temp_plant_boundary';	
            break;			
			}elseif($val->table_name == 'temp_colony_boundary' && $shp_type =='colony_boundary'){	
			$extent = DB::select( DB::raw("select * from shptemp.temp_colony_boundary") );		
			$val->plot_data = $extent;
			$table_name = 'temp_colony_boundary';	
            break;			
			}elseif($val->table_name == 'temp_mining_lease_boundary' && $shp_type =='truckyard'){	
			$extent = DB::select( DB::raw("select * from shptemp.temp_mining_lease_boundary") );		
			$val->plot_data = $extent;
			$table_name = 'temp_mining_lease_boundary';	
            break;			
			}elseif($val->table_name == 'temp_mining_lease_boundary' && $shp_type =='approach_road'){	
			$extent = DB::select( DB::raw("select * from shptemp.temp_mining_lease_boundary") );		
			$val->plot_data = $extent;
			$table_name = 'temp_mining_lease_boundary';	
            break;			
			}elseif($val->table_name == 'temp_mining_lease_boundary' && $shp_type =='conveyor_belt'){	
			$extent = DB::select( DB::raw("select * from shptemp.temp_mining_lease_boundary") );		
			$val->plot_data = $extent;
			$table_name = 'temp_mining_lease_boundary';	
            break;			
			}elseif($val->table_name == 'temp_mining_lease_boundary' && $shp_type =='railway_track'){	
			$extent = DB::select( DB::raw("select * from shptemp.temp_mining_lease_boundary") );		
			$val->plot_data = $extent;
			$table_name = 'temp_mining_lease_boundary';	
            break;			
			}elseif($val->table_name == 'temp_mining_lease_boundary' && $shp_type =='crusher_location'){	
			$extent = DB::select( DB::raw("select * from shptemp.temp_mining_lease_boundary") );		
			$val->plot_data = $extent;
			$table_name = 'temp_mining_lease_boundary';	
            break;			
			}elseif($val->table_name == 'temp_file' && $shp_type =='survey_plot'){
			$extent = DB::select( DB::raw("select * from shptemp.temp_file") );		
			$val->plot_data = $extent;
			$table_name = 'temp_file';			
			
			//district master
			$district_master = DistrictModel::where(['fl_archive' => 'N'])->get()->toArray();
			$val->district_master = $district_master; 
			
			//state master
			$state_master = StateModel::where(['fl_archive' => 'N'])->get()->toArray();
			$val->state_master = $state_master; 
			
			//taluk master
			$taluk_master = BlockModel::where(['fl_archive' => 'N'])->get()->toArray();
			$val->taluk_master = $taluk_master; 
			
			//village master			
			$village_master = VillageModel::where(['fl_archive' => 'N'])->get()->toArray();
			$val->village_master = $village_master;
			$table_name = 'temp_file';
			break;
			}
			
			
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
			
			if($shp_type =='mining_lease_boundary'){
			$this->data['section'] = 'mining_lease_boundary';
			return view('admin.ShapeFileManagement.MiningLeaseBoundary.add_view', $this->data);
			}elseif($shp_type =='plant_boundary'){
			$this->data['section'] = 'plant_boundary';
			return view('admin.ShapeFileManagement.PlantBoundary.add_view', $this->data);
			}elseif($shp_type =='colony_boundary'){
			$this->data['section'] = 'colony_boundary';
			return view('admin.ShapeFileManagement.ColonyBoundary.add_view', $this->data);
			}elseif($shp_type =='truckyard'){
			$this->data['section'] = 'truckyard';
			return view('admin.ShapeFileManagement.Truckyard.add_view', $this->data);
			}elseif($shp_type =='approach_road'){
			$this->data['section'] = 'approach_road';
			return view('admin.ShapeFileManagement.ApproachRoad.add_view', $this->data);
			}elseif($shp_type =='conveyor_belt'){
			$this->data['section'] = 'conveyor_belt';
			return view('admin.ShapeFileManagement.ConveyorBelt.add_view', $this->data);
			}elseif($shp_type =='railway_track'){
			$this->data['section'] = 'railway_track';
			return view('admin.ShapeFileManagement.RailwayTrack.add_view', $this->data);
			}elseif($shp_type =='crusher_location'){
			$this->data['section'] = 'crusher_location';
			return view('admin.ShapeFileManagement.CrusherLocation.add_view', $this->data);
			}elseif($shp_type =='survey_plot'){
			$this->data['section'] = 'survey_plot';	
			return view('admin.ShapeFileManagement.add_view', $this->data);
			}
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
		$shp_type = isset($posted_data['shp_type']) ? $posted_data['shp_type'] : '';
		
		if (!empty($shape_file_doc)) {
			
			$file_input = 'SHP_FILE'; //Name of file type input
            $this->allowed_types = array('zip');
            $max_size = 204800000; //(b) | upto 200MB size			
           // $uploaded_path = 'public/assets/files/shp_data/';	
			if($shp_type == 'mining_lease_boundary'){
			$uploaded_path = 'public/assets/files/shp_data/mining_lease_boundary';	
			}elseif($shp_type == 'plant_boundary'){
			$uploaded_path = 'public/assets/files/shp_data/plant_boundary';	
			}elseif($shp_type == 'colony_boundary'){
			$uploaded_path = 'public/assets/files/shp_data/colony_boundary';	
			}elseif($shp_type == 'truckyard'){
			$uploaded_path = 'public/assets/files/shp_data/truckyard';	
			}elseif($shp_type == 'railway_sliding_boundary'){
			$uploaded_path = 'public/assets/files/shp_data/railway_sliding_boundary';	
			}elseif($shp_type == 'approach_road'){
			$uploaded_path = 'public/assets/files/shp_data/approach_road';	
			}elseif($shp_type == 'conveyor_belt'){
			$uploaded_path = 'public/assets/files/shp_data/conveyor_belt';	
			}elseif($shp_type == 'railway_track'){
			$uploaded_path = 'public/assets/files/shp_data/railway_track';	
			}elseif($shp_type == 'crusher_location'){
			$uploaded_path = 'public/assets/files/shp_data/crusher_location';	
			}elseif($shp_type == 'survey_plot'){
			$uploaded_path = 'public/assets/files/shp_data/';	
			}

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
					$data_to_insert['shp_type'] = $shp_type;
					$data_to_insert['created_at'] = Carbon::now();
					$data_to_insert['created_id'] = ($this->data['current_user_id']) ? $this->data['current_user_id'] : '';
					$data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
					$insert_id = ShapeHistoryModel::insertGetId($data_to_insert);				
			}else{
					$msg = '<div class="alert alert-danger"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Not a valid file type!</strong></div>';

					if($shp_type =='mining_lease_boundary'){								
					return redirect('document-management/document/mining-lease-boundary')->with('message', $msg);
					}elseif($shp_type =='plant_boundary'){								
					return redirect('document-management/document/plant-boundary')->with('message', $msg);
					}elseif($shp_type =='colony_boundary'){								
					return redirect('document-management/document/colony-boundary')->with('message', $msg);
					}elseif($shp_type =='truckyard'){								
					return redirect('document-management/document/truckyard')->with('message', $msg);
					}elseif($shp_type =='approach_road'){								
					return redirect('document-management/document/approach_road')->with('message', $msg);
					}elseif($shp_type =='conveyor_belt'){								
					return redirect('document-management/document/conveyor-belt')->with('message', $msg);
					}elseif($shp_type =='railway_track'){								
					return redirect('document-management/document/railway-track')->with('message', $msg);
					}elseif($shp_type =='crusher_location'){								
					return redirect('document-management/document/crusher-location')->with('message', $msg);
					}elseif($shp_type =='survey_plot'){
					return redirect('document-management/document/shape-file-list')->with('message', $msg);	
					}
				}
                $msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape file uploaded successfully!</strong></div>';
				
					if($shp_type =='mining_lease_boundary'){								
					return redirect('document-management/document/mining-lease-boundary')->with('message', $msg);
					}elseif($shp_type =='plant_boundary'){								
					return redirect('document-management/document/plant-boundary')->with('message', $msg);
					}elseif($shp_type =='colony_boundary'){								
					return redirect('document-management/document/colony-boundary')->with('message', $msg);
					}elseif($shp_type =='truckyard'){								
					return redirect('document-management/document/truckyard')->with('message', $msg);
					}elseif($shp_type =='approach_road'){								
					return redirect('document-management/document/approach_road')->with('message', $msg);
					}elseif($shp_type =='conveyor_belt'){								
					return redirect('document-management/document/conveyor-belt')->with('message', $msg);
					}elseif($shp_type =='railway_track'){								
					return redirect('document-management/document/railway-track')->with('message', $msg);
					}elseif($shp_type =='crusher_location'){								
					return redirect('document-management/document/crusher-location')->with('message', $msg);
					}elseif($shp_type =='survey_plot'){
					return redirect('document-management/document/shape-file-list')->with('message', $msg);	
					}				
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
	public function edit_shape_file($id,$data_id)
	{ 
		$shpTables =  DB::select( DB::raw("select * from shptemp.temp_file where gid='$id'") );
		$this->data['data_id'] =$data_id;
		$this->data['shpData'] = isset($shpTables[0])?$shpTables[0]:array();
		return view('admin.ShapeFileManagement.edit_shp', $this->data);
	}
	public function update_shape_file(Request $request)
	{
		DB::enableQueryLog();
		$data = $request->all();
		$district = $data['district'];
		$state = $data['state'];
		$surveyno = $data['survey_no'];
		$village = $data['village'];
		$taluk = $data['Taluk'];
		$reg_id = $data['regid'];
		 $gid = $data['gid'];
		 $shpId = $data['data_id'];
		DB::statement("UPDATE shptemp.temp_file SET district = '$district',state='$state',surveyno='$surveyno',village='$village',taluk='$taluk',reg_id='$reg_id'  where gid  = $gid");
		
		$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data updated successfully!</strong></div>';				
		return redirect('document-management/document/shape-file-view/'.$shpId.'/edited')->with('message', $msg);

	}
	
	// export to shp
	function data_export_shp($table,$type,$data_id) {				
		$shape_history_data = DB::select( DB::raw("select * from \"T_SHP_HISTORY\" where id = '".$data_id."' and shp_type='".$type."'") );
		 $export_file_name = $shape_history_data[0]->zip_file_name;
		 $filename = $export_file_name;
		 $this->allowed_types = ['zip'];

			if($type == 'survey_plot'){
				$path_name = 'data_export_shp';
			    $file = File::files(public_path('assets/files/data_export_shp'));
			}elseif($type == 'mining_lease_boundary'){
				$path_name = 'data_export_shp/mining_lease_boundary';
			    $file = File::files(public_path('assets/files/data_export_shp/mining_lease_boundary'));
			}elseif($type == 'plant_boundary'){
				$path_name = 'data_export_shp/plant_boundary';
			    $file = File::files(public_path('assets/files/data_export_shp/plant_boundary'));
			}elseif($type == 'colony_boundary'){
				$path_name = 'data_export_shp/colony_boundary';
			    $file = File::files(public_path('assets/files/data_export_shp/colony_boundary'));
			}elseif($type == 'truckyard'){
				$path_name = 'data_export_shp/truckyard';
			    $file = File::files(public_path('assets/files/data_export_shp/truckyard'));
			}elseif($type == 'railway_sliding_boundary'){
				$path_name = 'data_export_shp/railway_sliding_boundary';
			    $file = File::files(public_path('assets/files/data_export_shp/railway_sliding_boundary'));
			}elseif($type == 'approach_road'){
				$path_name = 'data_export_shp/approach_road';
			    $file = File::files(public_path('assets/files/data_export_shp/approach_road'));
			}elseif($type == 'conveyor_belt'){
				$path_name = 'data_export_shp/conveyor_belt';
			    $file = File::files(public_path('assets/files/data_export_shp/conveyor_belt'));
			}elseif($type == 'railway_track'){
				$path_name = 'data_export_shp/railway_track';
			    $file = File::files(public_path('assets/files/data_export_shp/railway_track'));
			}elseif($type == 'crusher_location'){
				$path_name = 'data_export_shp/crusher_location';
			    $file = File::files(public_path('assets/files/data_export_shp/crusher_location'));
			}
			
			if($file){
				foreach ($file as $name) {
				unlink($name);
				}
			}
		
			if ($filename) {	
			   //$str = '"D:\\PostgreSQL\\9.5\\bin\\pgsql2shp" -f "D:\wamp\www\dalmia-lams\public\assets\files\data_export_shp\\' . $filename . '" -h localhost -u postgres -P admin@123 DALMIA_LAMS shptemp.temp_file 2>&1'; 
			   
			   $str = '"D:\\PostgreSQL\\9.5\\bin\\pgsql2shp" -f "D:\wamp\www\dalmia-lams\public\assets\files\"' . $path_name . '\\' . $filename . '" -h localhost -u postgres -P admin@123 DALMIA_LAMS shptemp.temp_file 2>&1'; 
			   
			   
			   exec($str, $output);
			   $dir = $zippath = public_path('assets/files/data_export_shp/'.$filename);		   
				$zip = new \ZipArchive();
				$files = File::files(public_path('assets/files/data_export_shp'));
				$download = $filename;
				if ($zip->open(public_path('assets/files/data_export_shp/'.$filename), \ZipArchive::CREATE) === TRUE) {
					$files = File::files(public_path('assets/files/data_export_shp'));
					foreach ($files as $file) {
						$file_path = $file;				
						if (! $zip->addFile($file, basename($file))) {
						echo 'Could not add file to ZIP: ' . $file;
						}				
					}
					$zip->close();				
				}else{
					echo "no path";
				}  
        return response()->download(public_path('assets/files/data_export_shp/'.$filename));
		} else {
			return 'file name missing';
		}	
	}
	
	// manage village map list
	
	public function manage_village_map(Request $request) {
        //$this->data['title'] = 'Dalmia-lams::Document/Add';
        $this->data['pageHeading'] = 'Village <span class="text-danger" >Manage</span>';
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

		//$this->data['doc_type_master'] = CodeModel::where(['cd_fl_archive' => 'N'])->get()->toArray();
		//$this->data['doc_location'] = DocumentModel::where(['fl_archive' => 'N'])->get()->toArray();

        $posted_data = $request->all();
        /*$this->data['document_type'] = $document_type = isset($posted_data['document_type']) ? $posted_data['document_type'] : '';
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
		$all_docs = array() ;*/

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

		$all_docs = VillageModel::whereRaw($where)->where('fl_archive','N')->orderBy('created_at','desc')->get();
			//t($all_docs);die;

	}
	else{
		$all_docs = VillageModel::where('fl_archive','N')->orderBy('created_at','desc')->get();
	}
	//t($all_docs);die;
		$this->data['villageList'] = $all_docs;
        return view('admin.ManageVillageMap.add', $this->data);
    }
	
	function manage_village_export($village_id){
		$village_data_list = DB::select( DB::raw("select * from \"T_SURVEY_MAP\" where village_id = '".$village_id."'") );
		//t($village_data_list);die;
		//DB::enableQueryLog();
		$village_data_view = VillageModel::where('id',$village_id)->where('fl_archive','N')->get();
			/*$query = DB::getQueryLog();
			$query = end($query);
			dd($query); */

		//t($village_data_view);die;
		$village_name = $village_data_view[0]->village_name;
		$filename = $village_name.'.zip';
		//echo $village_name;die;
		 $this->allowed_types = ['zip'];

			$file = File::files(public_path('assets/files/village_export_shp'));
				if($file){
				foreach ($file as $name) {
				unlink($name);
				}
			}
		
			if ($filename) {	
			   $str = '"D:\\PostgreSQL\\9.5\\bin\\pgsql2shp" -f "D:\wamp\www\dalmia-lams\public\assets\files\village_export_shp\\'.$filename . '" -h localhost -u postgres -P admin@123 DALMIA_LAMS "SELECT \"T_SURVEY_MAP\".wkb_geometry,\"T_DISTRICT\".district_name as district,\"T_STATE\".state_name as state,\"T_VILLAGE\".village_name as village,\"T_BLOCK\".block_name as taluk,\"T_SURVEY_MAP\".survey_no as surveyno,\"T_SURVEY_MAP\".registration_id as reg_id FROM public.\"T_SURVEY_MAP\" left join \"T_STATE\" on \"T_STATE\".id = \"T_SURVEY_MAP\".state left join \"T_DISTRICT\" on \"T_DISTRICT\".id = \"T_SURVEY_MAP\".district left join \"T_BLOCK\" on \"T_BLOCK\".id = \"T_SURVEY_MAP\".taluk left join \"T_VILLAGE\" on \"T_VILLAGE\".id = \"T_SURVEY_MAP\".village_id  where \"T_SURVEY_MAP\".village_id = \''.$village_id.'\'"';
			   		   
			   exec($str, $output);
			   $dir = $zippath = public_path('assets/files/village_export_shp/'.$filename);		   
				$zip = new \ZipArchive();
				$files = File::files(public_path('assets/files/village_export_shp'));
				$download = $filename;
				if ($zip->open(public_path('assets/files/village_export_shp/'.$filename), \ZipArchive::CREATE) === TRUE) {
					$files = File::files(public_path('assets/files/village_export_shp'));
					foreach ($files as $file) {
						$file_path = $file;				
						if (! $zip->addFile($file, basename($file))) {
						echo 'Could not add file to ZIP: ' . $file;
						}				
					}
					$zip->close();				
				}else{
					echo "no path";
				}  
        return response()->download(public_path('assets/files/village_export_shp/'.$filename));
		} else {
			return 'file name missing';
		}	
	}
	
	public function manage_village_remove($village_id)
	{
		if($village_id != ''){
		DB::statement("DELETE from public.\"T_SURVEY_MAP\" where village_id = '$village_id'");		
		DB::statement("UPDATE public.\"T_VILLAGE\" SET map_exists = 'N' where \"T_VILLAGE\".id = '$village_id'");
		$msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Shape data updated successfully!</strong></div>';				
		return redirect('document-management/document/manage-village-map')->with('message', $msg);
		}
	}
}
