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
use App\Models\LandDetailsManagement\FamilyModel;
use App\Models\LandDetailsManagement\PaymentModel;
use App\Models\LandDetailsManagement\RegistrationModel;
use App\Models\UtilityModel;

/**
 * Description of FamilyTree
 *
 * @author user-98-pc
 */
class FamilyTree extends Controller {

    //put your code here
    /**
     * 
     */
    public function __construct() {
        parent:: __construct();

        $this->allowed_types = [ 'jpg', 'png', 'jpeg'];
        $this->upload_dir = 'assets\uploads\FamilyDocs';
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Family-Tree';
        $this->data['section'] = 'family_tree';
        //$this->data['payment_mode'] = $this->getCodesDetails('payment_mode');
        //$this->data['payment_type'] = $this->getCodesDetails('payment_type');
        $this->data['include_script_view'] = 'admin.LandEntryManagement.FamilyTree.script';
        $this->middleware('auth');
        // echo $this->data['purchase_type_id'];
    }

    /**
     * 
     * @return type
     */
    public function add(Request $request) {
//echo "hii";die;
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        $this->data['title'] = 'Dalmia-lams::Family Tree/Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        //Referance registration no
        $reg_uniq_no = $request->input('reg_uniq_no');
        $this->data['reg_uniq_no'] = $reg_uniq_no;

        //Get the payment lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';

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

        $reg_info = RegistrationModel::find($reg_uniq_no)->toArray();
        $this->data['reg_data'] = $reg_info;

        $res = FamilyModel::where(['registration_id' => $reg_uniq_no, 'fl_archive' => "N"])->get()->toArray();
        $this->data['familyLists'] = $res;
		$whereData = array(array('registration_id',$reg_uniq_no) , array('fl_archive','N') , array('gender' ,'Male'), array('relationship_with_owner' ,'!=','wife')); 
		$member_dropdown_list = FamilyModel::where($whereData)->get()->toArray();
		$this->data['member_dropdown_list'] = $member_dropdown_list;
		//print_r($member_dropdown_list);die;



        return view('admin.LandEntryManagement.FamilyTree.add', $this->data);
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
	
	
	public function edit(Request $request) {
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        $this->data['title'] = 'Dalmia-lams::Family Tree/Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        //Referance registration no
        $reg_uniq_no = $request->input('reg_uniq_no');
        $this->data['reg_uniq_no'] = $reg_uniq_no;
        $id = $request->input('id');

        //Get the survey lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
		
        $res = FamilyModel::where(['registration_id' => $reg_uniq_no, 'fl_archive' => 'N'])->get()->toArray();

        $this->data['familyLists'] = $res;
		$this->data['upload_dir'] = $this->upload_dir;	
      
		$hof_data = FamilyModel::where(['registration_id' => $reg_uniq_no,'is_hof' => 'Y', 'fl_archive' => 'N'])->get()->toArray();
		$no_image_path1 = URL("assets/img/profile_man.jpg");
		$no_image_path2 = URL("assets/img/profile_women.jpg");
			$html = 'No Family Tree Found';
			if(!empty($hof_data))
			{
				//$no_image_path = '';
				$memdtlphoto = URL("assets/img/profile_man.jpg");

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

		
        //family Edit
        $id = $request->input('id');
        if ($id) {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('family_tree_edit')) {
                    return redirect('unauthorized-access');
                }
            }
            $this->data['id'] = $id;
            $family_data = FamilyModel::where(['id' => $id])->get()->toArray();
            $this->data['family_data'] = $family_data[0];
			
			$whereData = array(array('registration_id',$reg_uniq_no) , array('id', '!=' ,$id), array('fl_archive','N') , array('gender' ,'Male')); 
			$member_dropdown_list = FamilyModel::where($whereData)->get()->toArray();
				if($family_data[0]['relationship_with_owner'] == 'wife'){
				foreach($member_dropdown_list as $key => $member_data){

				$whereData = array(array('registration_id',$reg_uniq_no) , array('fl_archive','N') , array('owner_id',$member_data['id']) , array('owner_id', '!=' ,$family_data[0]['owner_id']), array('relationship_with_owner' ,'wife')); 
				$result = FamilyModel::where($whereData)->get()->toArray();
				if(count($result) > 0){
				unset($member_dropdown_list[$key]);				
				}
				}
				}
			$this->data['member_dropdown_list'] = $member_dropdown_list;
			
            
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
            //If family edit
        }
        if ($this->data['viewMode'] == 'true') {
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        }

        //get the Registration info
        $reg_info = RegistrationModel::find($reg_uniq_no)->toArray();
        $this->data['reg_data'] = $reg_info;

        return view('admin.LandEntryManagement.FamilyTree.add', $this->data);
    }


	public function get_wife_details($member_id)
	{		
		$wife_data = FamilyModel::where(['owner_id' => $member_id,'relationship_with_owner' => 'wife','fl_archive' => 'N'])->get()->toArray();
		return $wife_data;		 
	}
	
	// check hod
	public function checkIsOwner(Request $request)
	{
		$data = $request->all();		
		$is_owner = $data['is_owner'];
		$edit_id = $data['edit_id'];
		if($edit_id == ''){$edit_id = null;}

		$whereData = array(array('registration_id',$is_owner) ,array('is_hof','Y'), array('fl_archive','N') , array('id' ,'!=',$edit_id)); 
		$result = FamilyModel::where($whereData)->get()->toArray();
		//print_r($result);die;
		if (count($result) >= 1)
			echo 'owner already added';
	}
	
	public function checkExistWife(Request $request)
	{
		$data = $request->all();	
		$edit_id = $data['edit_id'];		
		$registration_id = $data['registration_id'];
		$relationship_with_owner = $data['relationship_with_owner'];
		if($edit_id == ''){		
		$whereData = array(array('registration_id',$registration_id) , array('fl_archive','N') , array('gender' ,'Male')); 
		}else{
		$whereData = array(array('registration_id',$registration_id) , array('fl_archive','N') , array('gender' ,'Male'), array('id' ,'!=',$edit_id)); 
		}
		$member_dropdown_list = FamilyModel::where($whereData)->get()->toArray();
		if($relationship_with_owner == 'wife'){
		foreach($member_dropdown_list as $key => $member_data){

		$whereData = array(array('registration_id',$registration_id) , array('fl_archive','N') , array('owner_id',$member_data['id']) , array('relationship_with_owner' ,'wife')); 
		$result = FamilyModel::where($whereData)->get()->toArray();
		if(count($result) > 0){
		unset($member_dropdown_list[$key]);				
		}
		}
		}
		$select_options = "<option value=''>select</option>";
        foreach ($member_dropdown_list as $key => $value) {
            $select_options .= "<option value='" . $value['id'] . "'>" . $value['member_name'] . "</option>";
        }
        echo $select_options;
	}
	
    public function view(Request $request) {
        $this->data['pageHeading'] = 'Land Record <span class="text-danger" >Edit</span>';
        $this->data['title'] = 'Dalmia-lams::Payment/Add';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-filestyle/bootstrap-filestyle.js';

        //Referance registration no
        $reg_uniq_no = $request->input('reg_uniq_no');
        $this->data['reg_uniq_no'] = $reg_uniq_no;

        //Get the payment lists
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/js/autoNumeric-min.js';
		
		
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

        if ($this->data['viewMode'] == 'true') {
            $this->data['pageHeading'] = 'Land Record <span class="text-danger" >View</span>';
        }

        return view('admin.LandEntryManagement.FamilyTree.add', $this->data);
    }

   public function processData(Request $request) {
        $posted_data = $request->all();
		$id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $check_is_owner = isset($posted_data['check_is_owner']) ? $posted_data['check_is_owner'] : '';
        $posted_registration_data = isset($posted_data['family']) ? $posted_data['family'] : '';
        $reg_info = RegistrationModel::find($posted_registration_data['registration_id'])->toArray();

        $messages = [
            'family.member_name.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Name is required!</strong></div>',
            'family.gender.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Gender is required!</strong></div>',
            'family.contact_number.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Contact Number is required!</strong></div>',
			'family.religion.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Religion is required!</strong></div>',
            'family.present_address.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Present address is required!</strong></div>',
            'family.permanent_address.required' => '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Permanent address is required!</strong></div>',
	   ];

        $rules = [
            'family.member_name' => 'required',
            'family.gender' => 'required',
            'family.contact_number' => 'required',
            'family.religion' => 'required',
            'family.present_address' => 'required',
            'family.permanent_address' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

		$profile_photo = isset($posted_data['profile_photo']) ? $posted_data['profile_photo'] : '';
		if (!empty($profile_photo)) {
			$file_name = $profile_photo->getClientOriginalName();
			$file_name = stristr($file_name, '.', true);
			$ext = $profile_photo->getClientOriginalExtension();
			$new_file_name = $file_name . '_' . time() . '.' . $ext;
			$file_path = $this->upload_dir . '/' . $new_file_name;
			if (in_array($ext, $this->allowed_types)) {
				$upload = UtilityModel::uploadFile($profile_photo, $this->upload_dir, $new_file_name);
			} else {
				//  $msg = '<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong></strong></div>';
				$msg = UtilityModel::getMessage('This type of files are not allowed!', 'error');
				if ($id) {
					return redirect('land-details-entry/family-tree/edit?reg_uniq_no=' . $registration_id . '&id=' . $id)->with('message', $msg)->withInput();
				} else {
					return redirect('land-details-entry/family-tree/add?reg_uniq_no=' . $registration_id)->with('message', $msg)->withInput();
				}
			}
		}



        if ($posted_data['id']) {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('family_tree_edit')) {
                    return redirect('unauthorized-access');
                }
            }

            if ($validator->fails()) {
                return redirect('land-details-entry/family-tree/edit?reg_uniq_no=' . $posted_registration_data['registration_id'] . '&id=' . $posted_data['id'])
                                ->withErrors($validator, 'family')
                                ->withInput();
            }
			
			if ($check_is_owner == '2') {
			$data_to_update_owner['owner_id'] = null;
			$data_to_update_owner['is_hof'] = 'N';
			$update_exist_owner = FamilyModel::where(['registration_id' => $posted_registration_data['registration_id'],'is_hof' => 'Y'])->update($data_to_update_owner);
			}			
            $data_to_insert = $posted_registration_data;			
            if (!empty($profile_photo)) {
                $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
                $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            }

			if ($check_is_owner == '1') {
				$data_to_insert['is_hof'] = 'N';
				$data_to_insert['owner_id'] = $posted_registration_data['owner_id'];
				$data_to_insert['relationship_with_owner'] = $posted_registration_data['relationship_with_owner'];
			}
			/*** if owner checkbox is selected ***/
			else {
				$data_to_insert['is_hof'] = 'Y';
				$data_to_insert['relationship_with_owner'] = 'self';
				$data_to_insert['owner_id'] = null;
			}

            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_insert['upd_id'] = $this->data['current_user_id'];
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
           // t($data_to_insert);die();
            $update_id = FamilyModel::where(['id' => $posted_data['id']])->update($data_to_insert);
            if ($update_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Member data updated successfully!</strong></div>';
                if ($posted_data['submit_family'] == 'save_continue') {
                    // return redirect('land-details-entry/document/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                    if ($this->user_type !== 'admin') {
                        //echo 'not admin';exit;
                        $registration_id = $data_to_insert['registration_id'];
                        if ($this->hasPermission('registration_access') && $this->hasPermission('lease_details_add')) {
                            if (isset($this->data['purchase_type_id']) && $this->data['purchase_type_id'] == 'CD00144') {
                                return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                                return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                                return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else {
                                return redirect('land-details-entry/survey/add?reg_uniq_no=' . $registration_id);
                            }
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                            return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                            return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else {
                            //return redirect('land-details-entry/survey/add?reg_uniq_no=' . $registration_id);
                            return redirect('land-details-entry/family-tree/edit?reg_uniq_no=' . $registration_id . '&id=' . $posted_data['id'])->with('message', $msg);
                        }
                    } else {
                        return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    }
                } else {
                    return redirect('land-details-entry/family-tree/edit?reg_uniq_no=' . $data_to_insert['registration_id'] . '&id=' . $posted_data['id'])->with('message', $msg);
                }
            }
        } else {
            if ($this->user_type !== 'admin') {
                if ($this->hasPermission('registration_access') && !$this->hasPermission('family_tree_add')) {
                    return redirect('unauthorized-access');
                }
            }
            if ($validator->fails()) {
                return redirect('land-details-entry/family-tree/add?reg_uniq_no=' . $posted_registration_data['registration_id'])
                                ->withErrors($validator, 'family')
                                ->withInput();
            }
            $data_to_insert = $posted_registration_data;
			if ($check_is_owner == '2') {
			$data_to_update['owner_id'] = null;
			$data_to_update['is_hof'] = 'N';
			$update_exist_owner = FamilyModel::where(['registration_id' => $posted_registration_data['registration_id'],'is_hof' => 'Y'])->update($data_to_update);
			}
			//echo $check_is_owner;die;
            if (!empty($profile_photo)) {
                $data_to_insert['path'] = isset($file_path) ? str_replace('\\', '/', $file_path) : '';
                $data_to_insert['file_type'] = isset($ext) ? $ext : '';
            }

			if ($check_is_owner == '1') {
				$data_to_insert['is_hof'] = 'N';
				$data_to_insert['owner_id'] = $posted_registration_data['owner_id'];
				$data_to_insert['relationship_with_owner'] = $posted_registration_data['relationship_with_owner'];
			}
			/*** if owner checkbox is selected ***/
			else {
				$data_to_insert['is_hof'] = 'Y';
				$data_to_insert['relationship_with_owner'] = 'self';
				$data_to_insert['owner_id'] = null;
			}			
			
			
            $data_to_insert['created_at'] = Carbon::now();
            // $data_to_insert['updated_at'] = Carbon::now();
           // $data_to_insert['unit_cost'] = $costPerArea;
            $data_to_insert['crt_id'] = $this->data['current_user_id'];
            //$data_to_insert['upd_id'] = $this->data['current_user_id'];
            $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
             //t($data_to_insert);die('akash');
            $insert_id = FamilyModel::insertGetId($data_to_insert);
            if ($insert_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Member data saved successfully!</strong></div>';
                if ($posted_data['submit_family'] == 'save_continue') {
                    //return redirect('land-details-entry/document/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
					$registration_id = $data_to_insert['registration_id'];
                    if ($this->user_type !== 'admin') {
                        //echo 'not admin';exit;
                        
                        if ($this->hasPermission('registration_access') && $this->hasPermission('document_upload_add')) {
                            return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('payment_details_add')) {
                            return redirect('land-details-entry/payment/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('lease_details_add')) {
                            if (isset($this->data['purchase_type_id']) && $this->data['purchase_type_id'] == 'CD00144') {
                                return redirect('land-details-entry/lease/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                                return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                                return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                                return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                            } else {
                                return redirect('land-details-entry/survey/add?reg_uniq_no=' . $registration_id);
                            }
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('geo_tag_add')) {
                            return redirect('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('transaction_details_access')) {
                            return redirect('land-details-entry/registration/transaction-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else if ($this->hasPermission('registration_access') && $this->hasPermission('audit_details_access')) {
                            return redirect('land-details-entry/registration/audit-details?reg_uniq_no=' . $registration_id)->with('message', $msg);
                        } else {
                            return redirect('land-details-entry/survey/add?reg_uniq_no=' . $registration_id);
                        }
                    } else {
                        return redirect('land-details-entry/document/add?reg_uniq_no=' . $registration_id)->with('message', $msg);
                    }
                } else {
                    return redirect('land-details-entry/family-tree/add?reg_uniq_no=' . $data_to_insert['registration_id'])->with('message', $msg);
                }
            }
        }
    }

    public function memberDelete(Request $request) {
        $reg_uniq_no = $request->input('reg_uniq_no');
        $id = $request->input('id');

        if (!empty($reg_uniq_no) && !empty($id)) {
            //$delete_id = SurveyModel::where('id', '=', $survey_no)->delete();
            $data_to_update['fl_archive'] = 'Y';
            $delete_id = FamilyModel::where(['id' => $id])->update($data_to_update);
            if ($delete_id) {
                $msg = '<div class="alert alert-success"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Member deleted successfully!</strong></div>';
                return redirect('land-details-entry/family-tree/add?reg_uniq_no=' . $reg_uniq_no)->with('message', $msg);
            }
        } else {
            return redirect('land-details-entry/registration/add');
        }
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
