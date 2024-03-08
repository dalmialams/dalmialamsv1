<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\FolderScan;

use App\Http\Controllers\Controller;
//use App\Models\LandDetailsManagement\DocumentModel;
//use App\Models\UtilityModel;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use MediaBrowser;
use Illuminate\Contracts\Filesystem\Filesystem;
use Storage;
use File;
use App\Models\Common\StateModel;
use App\Models\Common\DistrictModel;
use App\Models\Common\BlockModel;
use App\Models\Common\VillageModel;
use App\Models\FolderScan\FileModel;
use App\Models\LandDetailsManagement\DocumentModel;

//use Illuminate\Support\Facades\Storage;
/**
 * Description of FolderScan
 *
 * @author user-98-pc
 */
class FolderScanController extends Controller {

    //put your code here
    public $upload_dir = '';

    public function __construct() {
        parent:: __construct();

        $this->allowed_types = ['txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'jpg', 'png', 'gif'];
        $this->upload_dir = 'assets\uploads\LandEntryDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        //$this->data['pageHeading'] = 'Document Upload : '.$this->data['reg_uniq_no'];
        $this->data['title'] = 'Dalmia-lams::Folder Scan';
        $this->data['section'] = 'document';
        $this->data['document_type'] = $this->getCodesDetails('document_type');
    }

    public function browserDir(Request $request, Filesystem $fileSystem) {
        $this->data['pageHeading'] = 'Folder  <span class="text-danger" > Browser </span>';
        //$this->data['include_script_view'] = 'admin.LandEntryManagement.Document.script';
        $this->data['appData']['cssArr'][] = 'assets/packages/spescina/mediabrowser/dist/mediabrowser-include.min.css';
        $this->data['data']['jsArr'][] = 'assets/packages/spescina/mediabrowser/dist/mediabrowser-include.min.js';

//        t($_POST,1);
        $posted_data = $request->all();
        $posted_files_data = isset($posted_data['folder']) ? $posted_data['folder'] : '';
//       t($posted_files_data,1);
       if(!empty($posted_files_data))
        $this->moveFile($posted_files_data['folderPath'],$fileSystem );
//       t($this->data,1);
         //$this->data['data']['jsArr'][] = 'assets/plugins/charts/sparklines/jquery.sparkline.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        return view('admin.FolderScan.browserDir', $this->data);
    }

    public function moveFile($givenFilePath=null,$fileSystem) {
	
	
	
      

        $filePath = $givenFilePath;
        // File::copy('E:/Koushik/dalmia-lams/readme.Koushik',base_path('/').'/readme.Koushik');
        // die();
        //$filesss=$fileSystem->copy($filePath,'');
        // $files= $storage::disk('D3')->get($filePath);
        //$fileSystem->move("readme.Koushik","I am koushik Santra");
        $fileList = Storage::disk('D3')->allFiles($filePath);
        $errros = [];
        $dataArray = [];
		//t($fileList,1);
        foreach ($fileList as $listkey => $listvalue) {
            $pathArray = explode('/', $listvalue);
			$fileName=explode('.', $pathArray[(count($pathArray)-1)]);
			//t($fileName);
			$distintFileName[]=$pathArray[(count($pathArray)-1)];
			$pathArray[]=$listvalue;
			$pathArray=array_merge($pathArray,$fileName);
			$fileModel=new FileModel;
			foreach ($pathArray as $pathKey => $pathValue) {
				$fileModel->setAttribute("colm".($pathKey+1), $pathValue);
				
			}
			$fileModel->save();
			//t($fileModel,1);
           /* foreach ($pathArray as $pathKey => $pathValue) {
                switch ($pathKey) {
                    case 0:
                        $stateDetails = StateModel::where('state_prefix', $pathValue)->first();
                        if (!isset($stateDetails->id))
                            $errros[$listkey][$pathKey] = "State Not Found";
                        else
                            $dataArray[$listkey][$pathKey]['state_id'] = $stateDetails->id;
                        break;
                    case 1:
                        $districtDetails = DistrictModel::where('district_name', $pathValue)->first();
                        if (!isset($districtDetails->id))
                            $errros[$listkey][$pathKey] = "District Not Found";
                        else
                            $dataArray[$listkey][$pathKey]['district_id'] = $districtDetails->id;
                        break;
                    case 2:
                        $blockDetails = BlockModel::where('block_name', $pathValue)->first();
                        if (!isset($blockDetails->id))
                            $errros[$listkey][$pathKey] = "Block Not Found";
                        else
                            $dataArray[$listkey][$pathKey]['block_id'] = $blockDetails->id;
                        break;
                    case 3:
                        $villageDetails = VillageModel::where('village_name', $pathValue)->first();
                        if (!isset($villageDetails->id))
                            $errros[$listkey][$pathKey] = "Village Not Found";
                        else
                            $dataArray[$listkey][$pathKey]['village_id'] = $villageDetails->id;
                        break;
                    case 4:
                        $dataArray[$listkey][$pathKey]['regn_no'] = $pathValue;
                    case 5:
                        $dataArray[$listkey][$pathKey]['doc_name'] = $pathValue;
                }
                $dataArray[$listkey][]['doc_path'] = $listvalue;
            }*/
			 //t($dataArray);
          // t($pathArray,1);
		    $this->data['pathArray'][] = $pathArray;
        }
		echo "Total File= ".count($distintFileName);
t(array_unique($distintFileName),1);
t( $this->data['pathArray'],1);
       // 
       
      ///  $this->data['filePathList'] = $fileList;
      ///  $this->data['pathError'] = $errros;
//          t($fileList);
//          t($errros);
//           t($dataArray);
        //  t($filesss) ;
//     
//        die("i am here");
//        if(empty($errros)){
//           return reditect()->back();
//        }

        
    }
	
	

    public function insertFile(Filesystem $fileSystem) {
		
		
		$fileList= FileModel:: get()->toArray();
		
		foreach($fileList as $filekey=>$filevalue){
			$fileeXPLODE=explode('.',$filevalue['colm1']);
			$this->upload_dir = isset($this->upload_dir) ? str_replace('\\', '/', $this->upload_dir) : '';
			$this->filePath=$this->upload_dir.'/'.$fileeXPLODE[0].'_'.$filekey.'_'.time().'.'.$fileeXPLODE[1];
			
			 if(File::copy($filevalue['colm3'].'\/'.$filevalue['colm1'],$this->filePath)){ 
			 $documentModel=new DocumentModel;
			 	$documentModel->setAttribute("registration_id", $filevalue['colm4']);
				$documentModel->setAttribute("type", $filevalue['colm2']);
				$documentModel->setAttribute("path", $this->filePath);
				$documentModel->setAttribute("physical_location", $filevalue['colm3']);
			$documentModel->save();
			}
		}
		//t($fileModel,1);
        t($_REQUEST);
    }

}
