@extends('layouts.master')

@section('header_styles')
<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{asset('assets/main/css/bootstrap-extend.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/select2/dist/css/select2.min.css')}}">


<!-- theme style -->
<link rel="stylesheet" href="{{asset('assets/main/css/master_style.css')}}">


<!-- SoftPro admin skins -->
<link rel="stylesheet" href="{{asset('assets/main/css/skins/_all-skins.css')}}">
<!-- owlcarousel-->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.carousel.css')}}">
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/assets/owl.theme.default.css')}}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">


<style>
    ul,
    #myUL {
        list-style-type: none;
    }

    #myUL {
        margin: 0;
        padding: 0;
    }

    .caret {
        cursor: pointer;
        -webkit-user-select: none;
        /* Safari 3.1+ */
        -moz-user-select: none;
        /* Firefox 2+ */
        -ms-user-select: none;
        /* IE 10+ */
        user-select: none;
    }

    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    .caret-down::before {
        -ms-transform: rotate(90deg);
        /* IE 9 */
        -webkit-transform: rotate(90deg);
        /* Safari */
        '
transform: rotate(90deg);
    }

    .nested {
        display: none;
    }

    .active {
        display: block;
    }

    .parent_category {
        background: #3ebfea;
        border: 0px;
        color: #ffffff;
        border-radius: 4px;
        display: block;
        padding: 7px 15px;
    }

    .custom_carret::before {
        color: #fff;
        position: absolute;
    }

    .textparent {
        padding-left: 15px;
    }

    .second_child {
        margin-left: -40px;
    }

    .second_child li {
        display: block;
        border-bottom: 1px solid #ccc;
        padding: 5px;
    }

    .second_child li:hover {
        background: #f3f3f3;
    }

    .custom_tree>li {
        line-height: 24px;
        margin-bottom: 5px;
    }

    .custom_tree {
        margin-top: 10px !important;
    }

    /* style for data table menu */
    .data-table-tool {
        width: 100%;
        /*border:none;*/
    }

    .user-mangment-data-table .dataTables_filter {
        white-space: nowrap;
        float: none;
    }

    .user-mangment-data-table .dataTables_filter label {
        display: block;
        text-align: right;
    }

    .user-mangment-data-table .dataTables_filter input.form-control {
        display: inline-block;
        width: auto;
        margin-right: 0;
    }

    .menu-dropdown {
        position: relative;
        z-index: 2;
        width: 100px;
    }

    .menu-dropdown .btn {
        background: transparent;
        border: none;
        font-size: 20px;
        padding-left: 0;
    }

    .menu-dropdown button.btn.dropdown-toggle:after {
        display: none;
    }
.fixed_footer_buttons {
    position: fixed;
    bottom: 50px;
    text-align: center;
    background: rgba(0,0,0,.2);
    left: 92%;
    padding: 23px 0 30px;
    box-shadow: 0px 0px 5px #aaa;
    border: 1px solid #bdb5b5;
    width: 71px;
    text-align: center;
    z-index: 99999;
}
.fixed_footer_buttons-right {
    position: fixed;
    bottom: 50px;
    text-align: center;
    background: rgba(0,0,0,.2);
    left: 21%;
    padding: 23px 0 30px;
    box-shadow: 0px 0px 5px #aaa;
    border: 1px solid #bdb5b5;
    width: 71px;
    text-align: center;
    z-index: 99999;
}

    /* style for data table menu */
</style>
@stop
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('dashboard')}}"><i class="mdi mdi-home-outline"></i> Home</a></li>
        <li class="breadcrumb-item active">Logs</li>
    </ol>
</section>

<section class="content">
    <!-----------filter data---------------->
    <form id="add_development_plan" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
        <!-- Step 1 -->
        @csrf
        <div class="row">
            <div class="col-12">
                <!-- SELECT2 EXAMPLE -->
                <div class="box box-solid bg-gray">
                    <div class="box-header with-border">
                        <h4 class="box-title">Filter Data</h4>
                        <ul class="box-controls pull-right">
                            <!--<li><a class="box-btn-close" href="#"></a></li>-->
                            <li><a class="box-btn-slide" href="#"></a></li>
                        </ul>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pb-0" style="position:static !important;">
                        <div class="row">
                            
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label>Action Taken By<span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" id="user_id" name="user_id" required>
                                        <option value="">Select</option>
                                        @if(isset($users_list) && !empty($users_list))
                                        @foreach($users_list as $user_list)
                                        <option value="<?= $user_list->id ?>" <?php if (isset($user_id) && $user_list->id == $user_id) {
                                                                                echo "selected";
                                                                            } ?>><?= ucwords(strtolower($user_list->name)) ?></option>
                                        @endforeach
                                        @endif
                                        
                                    </select>
                                </div>
                            </div>
							 <div class="col-md-2 col-12">
								 <div class="form-group">
										<label>Module</label>
										<select class="form-control select2" style="width: 100%;" id="modele_name" name="module_name" onchange="get_submodule(this)">
											<option value="">Select</option> 
											<option value="village">Project/village</option> 
											<option value="Project_approval">Project Approval</option> 
											<option value="land">Land Management</option> 
											<option value="litigation">Litigation</option> 
											<option value="procurement">Procurement/Alienation</option> 
											<option value="document">All Document</option> 
											<option value="action plan">Action Plan</option> 
										</select>									
								 </div>
							 </div>
							  <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label>Sub Module <span class="text-danger">*</span></label>
                                    <select class="form-control select2" style="width: 100%;" id="table_name" name="table_name" >
                                        <option value="">Select</option>  
										<option value="All Documents" <?php if(isset($table_name) && $table_name=='All Documents'){echo"selected";}?>>All Documents</option>
										<option value="action_plan"  <?php if(isset($table_name) && $table_name=='action_plan'){echo"selected";}?>>Action Plan</option>										
                                        <option value="villages" <?php if(isset($table_name) && $table_name=='villages'){echo"selected";}?>>Village</option>
										<option value="taluks" <?php if(isset($table_name) && $table_name=='taluks'){echo"selected";}?>>Taluk</option>
										<option value="villages_survey" <?php if(isset($table_name) && $table_name=='villages_survey'){echo"selected";}?>>Survey</option>
										<option value="project_master" <?php if(isset($table_name) && $table_name=='project_master'){echo"selected";}?>>Project</option>
										<option value="project_entity" <?php if(isset($table_name) && $table_name=='project_entity'){echo"selected";}?>>Project Entity</option>
										<option value="project_survey" <?php if(isset($table_name) && $table_name=='project_survey'){echo"selected";}?>>Project Survey</option>
										<!-- project approval -->
										<option value="prj_aprvl_development_plan" <?php if(isset($table_name) && $table_name=='prj_aprvl_development_plan'){echo"selected";}?>>Development Plan</option>
										<option value="prj_aprvl_betterment_charges" <?php if(isset($table_name) && $table_name=='prj_aprvl_betterment_charges'){echo"selected";}?>>Betterment Charges</option>
										<option value="prj_aprvl_bescom" <?php if(isset($table_name) && $table_name=='prj_aprvl_bescom'){echo"selected";}?>>BESCOM</option>
										<option value="prj_aprvl_bwssb" <?php if(isset($table_name) && $table_name=='prj_aprvl_bwssb'){echo"selected";}?>>BWSSB</option>
										<option value="prj_aprvl_aii" <?php if(isset($table_name) && $table_name=='prj_aprvl_aii'){echo"selected";}?>>AII</option>
										<option value="prj_aprvl_arodrome_mod" <?php if(isset($table_name) && $table_name=='prj_aprvl_arodrome_mod'){echo"selected";}?>>MOD/Aerodrome</option>
										<option value="prj_aprvl_fire" <?php if(isset($table_name) && $table_name=='prj_aprvl_fire'){echo"selected";}?>>Fire</option>
										<option value="prj_aprvl_bsnl" <?php if(isset($table_name) && $table_name=='prj_aprvl_bsnl'){echo"selected";}?>>BSNL</option>
										<option value="prj_aprvl_moef" <?php if(isset($table_name) && $table_name=='prj_aprvl_moef'){echo"selected";}?>>MOEF SEIAA</option>
										<option value="prj_aprvl_cfe" <?php if(isset($table_name) && $table_name=='prj_aprvl_cfe'){echo"selected";}?>>KSPCB CFE</option>
										<option value="prj_aprvl_cfo" <?php if(isset($table_name) && $table_name=='prj_aprvl_cfo'){echo"selected";}?>>KSPCB CFO</option>
										<option value="prj_aprvl_railways" <?php if(isset($table_name) && $table_name=='prj_aprvl_railways'){echo"selected";}?>>Railways</option>
										<option value="prj_aprvl_bp_sanction" <?php if(isset($table_name) && $table_name=='prj_aprvl_bp_sanction'){echo"selected";}?>>BP Section</option>
										<option value="prj_aprvl_rera" <?php if(isset($table_name) && $table_name=='prj_aprvl_rera'){echo"selected";}?>>RERA</option>
										<option value="prj_aprvl_nhai_noc" <?php if(isset($table_name) && $table_name=='prj_aprvl_nhai_noc'){echo"selected";}?>>NHAI</option>
										<option value="prj_aprvl_commencement_certicate" <?php if(isset($table_name) && $table_name=='prj_aprvl_commencement_certicate'){echo"selected";}?>>CC</option>
										<option value="prj_aprvl_oc" <?php if(isset($table_name) && $table_name=='prj_aprvl_oc'){echo"selected";}?>>OC</option>
										<option value="prj_aprvl_others" <?php if(isset($table_name) && $table_name=='prj_aprvl_others'){echo"selected";}?>>OTHER</option>
										<!--land -->
										<option value="land_title_deed_grant" <?php if(isset($table_name) && $table_name=='land_title_deed_grant'){echo"selected";}?>>Grant</option>
										<option value="land_title_deed_inam" <?php if(isset($table_name) && $table_name=='land_title_deed_inam'){echo"selected";}?>>Inam</option>
										<option value="land_title_deed_lrf" <?php if(isset($table_name) && $table_name=='land_title_deed_lrf'){echo"selected";}?>>LRF</option>
										<option value="land_title_executed_deeds" <?php if(isset($table_name) && $table_name=='land_title_executed_deeds'){echo"selected";}?>>Executed Deeds</option>
										<option value="land_title_flow" <?php if(isset($table_name) && $table_name=='land_title_flow'){echo"selected";}?>>Through Court</option>
										<option value="land_title_flow" <?php if(isset($table_name) && $table_name=='land_title_flow'){echo"selected";}?>>Title Flow</option>
										<option value="land_title_report" <?php if(isset($table_name) && $table_name=='land_title_report'){echo"selected";}?>>Title Report</option>
										<option value="family_tree" <?php if(isset($table_name) && $table_name=='family_tree'){echo"selected";}?>>Family</option>
										<option value="family_death_document" <?php if(isset($table_name) && $table_name=='family_death_document'){echo"selected";}?>>Death Certificate</option>
										<option value="family_caste_certificate" <?php if(isset($table_name) && $table_name=='family_caste_certificate'){echo"selected";}?>>Caste Certificate</option>
										<option value="id_proof_document" <?php if(isset($table_name) && $table_name=='id_proof_document'){echo"selected";}?>>ID Proof</option>
										<option value="pan_document" <?php if(isset($table_name) && $table_name=='pan_document'){echo"selected";}?>>PAN</option>
										<option value="aadhar_card" <?php if(isset($table_name) && $table_name=='aadhar_card'){echo"selected";}?>>Aadhar Card</option>
										<option value="land_case_papers_and_details" <?php if(isset($table_name) && $table_name=='land_case_papers_and_details'){echo"selected";}?>>Case Paper</option>
										<option value="Revenue Records" <?php if(isset($table_name) && $table_name=='Revenue Records'){echo"selected";}?>>Revenue Records</option>
										<option value="survey sketch" <?php if(isset($table_name) && $table_name=='survey sketch'){echo"selected";}?>>Survey/Sketch based records</option>
										<option value="City Survey Doc" <?php if(isset($table_name) && $table_name=='City Survey Doc'){echo"selected";}?>>City Survey Doc</option>
										<option value="Endorsement" <?php if(isset($table_name) && $table_name=='Endorsement'){echo"selected";}?>>Endorsement</option>
										<option value="Acquisition" <?php if(isset($table_name) && $table_name=='Acquisition'){echo"selected";}?>>Acquisition</option>
										<option value="land_encumbrance_certificate" <?php if(isset($table_name) && $table_name=='land_encumbrance_certificate'){echo"selected";}?>>Encumbrance Certificate</option>
										<option value="Charges" <?php if(isset($table_name) && $table_name=='Charges'){echo"selected";}?>>Charges/ Addl Deeds</option>
										<option value="Public Notice" <?php if(isset($table_name) && $table_name=='Public Notice'){echo"selected";}?>>Public Notice</option>
										<option value="BBMP/VP Records" <?php if(isset($table_name) && $table_name=='BBMP/VP Records'){echo"selected";}?>>BBMP/VP Records</option>
										<option value="land_miscellaneous" <?php if(isset($table_name) && $table_name=='land_miscellaneous'){echo"selected";}?>>Miscellaneous Document</option>
										<option value="land_clu" <?php if(isset($table_name) && $table_name=='land_clu'){echo"selected";}?>>CLU</option>
										<option value="land_conversion" <?php if(isset($table_name) && $table_name=='land_conversion'){echo"selected";}?>>Conversion</option>
										<!-- litigation-->
										<option value="court_case" <?php if(isset($table_name) && $table_name=='court_case'){echo"selected";}?>>Court Case</option>
										<option value="court_case_assign_external" <?php if(isset($table_name) && $table_name=='court_case_assign_external'){echo"selected";}?>>Court Case Assign External</option>
										<option value="draft_notice_document" <?php if(isset($table_name) && $table_name=='draft_notice_document'){echo"selected";}?>>Draft Notice Document</option>
										<option value="draft_pleading_document" <?php if(isset($table_name) && $table_name=='draft_pleading_document'){echo"selected";}?>>Draft Pleading Document</option>
										<option value="final_notice_document" <?php if(isset($table_name) && $table_name=='final_notice_document'){echo"selected";}?>>Final Notice Document</option>
										<option value="final_pleading_document" <?php if(isset($table_name) && $table_name=='final_pleading_document'){echo"selected";}?>>Final Pleading Document</option>
										<option value="hearing_court" <?php if(isset($table_name) && $table_name=='hearing_court'){echo"selected";}?>>Hearing Court</option>
										<option value="litigation_court_document_counsel" <?php if(isset($table_name) && $table_name=='litigation_court_document_counsel'){echo"selected";}?>>Court Document Counsel</option>
										<option value="litigation_court_document_received" <?php if(isset($table_name) && $table_name=='litigation_court_document_received'){echo"selected";}?>>Court Document Received</option>
										<option value="litigation_notice_document_plan" <?php if(isset($table_name) && $table_name=='litigation_notice_document_plan'){echo"selected";}?>>Document Plan</option>
										<option value="servy_notice" <?php if(isset($table_name) && $table_name=='servy_notice'){echo"selected";}?>>Survey Notice</option>
										<!-- procurement -->
										<option value="land_procurementidentification" <?php if(isset($table_name) && $table_name=='land_procurementidentification'){echo"selected";}?>>Procurement Identification</option>
										<option value="land_preliminary_title_impression" <?php if(isset($table_name) && $table_name=='land_preliminary_title_impression'){echo"selected";}?>>Procurement Preliminary Title Impression</option>
										<option value="land_procurement_negotiation" <?php if(isset($table_name) && $table_name=='land_procurement_negotiation'){echo"selected";}?>>Procurement Negotiation</option>
										<option value="land_procurement_legal_clearance" <?php if(isset($table_name) && $table_name=='land_procurement_legal_clearance'){echo"selected";}?>>Procurement Legal Clearance</option>
										<option value="land_procurement_agreement" <?php if(isset($table_name) && $table_name=='land_procurement_agreement'){echo"selected";}?>>Procurement Agreement</option>
										<option value="land_procurement_condition_precedence" <?php if(isset($table_name) && $table_name=='land_procurement_condition_precedence'){echo"selected";}?>>Procurement Condition Precedence</option>
										<option value="land_procurement_registration" <?php if(isset($table_name) && $table_name=='land_procurement_registration'){echo"selected";}?>>Procurement Registration</option>
										<option value="land_procurement_mutation" <?php if(isset($table_name) && $table_name=='land_procurement_mutation'){echo"selected";}?>>Procurement Mutation</option>
										<!-- alienation-->
										<option value="land_alienation_enquiry" <?php if(isset($table_name) && $table_name=='land_alienation_enquiry'){echo"selected";}?>>Alienation Enquiry</option>
										<option value="land_alienation_preliminary_title_impression" <?php if(isset($table_name) && $table_name=='land_alienation_preliminary_title_impression'){echo"selected";}?>>Alienation Preliminary Title Impression</option>
										<option value="land_alienation_negotiation" <?php if(isset($table_name) && $table_name=='land_alienation_negotiation'){echo"selected";}?>>Alienation Negotiation</option>
										<option value="land_alienation_legal_clearance" <?php if(isset($table_name) && $table_name=='land_alienation_legal_clearance'){echo"selected";}?>>Alienation Legal Clearance</option>
										<option value="land_alienation_agreement" <?php if(isset($table_name) && $table_name=='land_alienation_agreement'){echo"selected";}?>>Alienation Agreement</option>
										<option value="land_alienation_condition_precedence" <?php if(isset($table_name) && $table_name=='land_alienation_condition_precedence'){echo"selected";}?>>Alienation Condition Precedence</option>
										<option value="land_alienation_registration" <?php if(isset($table_name) && $table_name=='land_alienation_registration'){echo"selected";}?>>Alienation Registration</option>
                                    </select>
                                    </select>
                                </div>
                            </div>
                           

                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label>From Date<span class="text-danger">*</span></label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="from_date" required class="form-control pull-right from_date" value="{{isset($from_date)&&$from_date!=''?date('d/m/Y',strtotime(strtr($from_date,'/','-'))):''}}" id="from_date" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label>To Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="to_date" required class="form-control pull-right to_date" value="{{isset($to_date)&&$to_date!=''?date('d/m/Y',strtotime(strtr($to_date,'/','-'))):''}}" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-12 ">
                                <div class="form-group">
                                    <label></label>
                                    <button type="submit" id="" class="btn btn-sm btn-info pull-left" style="margin-top:23px;">Search</button>
                                </div>
                            </div>


                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </form>
    <!-----------filter date---------------->
    <div class="row">
	
        <div class="col-12">
            <div class="tab-content">
                <div class="tab-pane active" id="home4" role="tabpanel">
                    <div class="box box-solid bg-gray">
                        <div class="box-header with-border">
                            <h3 class="box-title">Logs</h3>
                            <!-- <h6 class="subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @if (session('success-msg'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h6><i class="icon fa fa-check"></i> {{session('success-msg')}}</h6>

                            </div>
                            @endif
							
							
                            <?php
                            $pattern = array('prj_aprvl', 'document_table', 'all_documents', 'land', '-', '_', 'padp');
                            ?>
                            <div class="table-responsive user-mangment-data-table box">
								<!-- left right shift -->
								<div class="fixed_footer_buttons slide-left">
									<span class="glyphicon glyphicon-chevron-right "></span>
									
								</div>
								<div class="fixed_footer_buttons-right slide-right">
									<span class="glyphicon glyphicon-chevron-left "></span>
									
								</div>
								<!-- left right shift -->
                                <table id="example" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
											<th>Module</th>
											<th>Sub Module</th>
											<th>Sub Sub Module</th>                                            
                                            <th>Original Field</th>
                                            <th>Changed Fields</th>                                          
                                            <th>Action Taken</th>
                                            <th>Action Taken By</th>
                                            <th>Action Taken At</th>
											<th>IP Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$count=0;
                                        if(isset($list) && !empty($list)){
										
                                        foreach($list as $k=>$infos){
										 $tot_field = count($infos->row_data_details);
											  $tot_upfield = count($infos->update_data_details);
										
										
										
										foreach($infos->row_data_details as $dtk=>$detls) { 
										
										if($infos->action &&  $infos->action == 'U' && !empty($infos->update_data_details)){
											    
												$update_val = isset($infos->update_data_details[$dtk][0]->value)?ucwords(str_replace('_',' ',$infos->update_data_details[$dtk][0]->value)):'';
												
											if($update_val!='' || $dtk==0){ 
											?>
											
										 	
										 <tr>
										  
                                            <td> <?php if($dtk==0){ $count = $count+1; ?>{{$count}} <?php } ?></td>
										  
											
											<td> <?php if($dtk==0){?>{{ucwords(str_replace('_',' ',$infos->module))}} <?php } ?></td>
											 
											
											 <td> <?php if($dtk==0){?>{{isset($infos->sub_module) & $infos->sub_module!=''?ucwords($infos->sub_module):ucwords($infos->table_comment)}} <?php }?></td>
											
                                            
											<td > <?php if($dtk==0){?>{{isset($infos->sub_module) & $infos->sub_module!=''?ucwords($infos->table_comment):''}}<?php }?></td>
											
                                            <td>
											<?php if($dtk==0){?>
											 
											 <div class="clearfix">
											@foreach($infos->row_data_details as $detls1)
											 @if(isset($detls1[0]->column_comment) && $detls1[0]->column_comment!='')
											 <button type="button" class="btn btn-xs btn-outline btn-secondary mb-5">{{isset($detls1[0]->column_comment)?$detls1[0]->column_comment:''}} :{{isset($detls1[0]->value) && $detls1[0]->value!=''?ucwords(str_replace('_',' ',$detls1[0]->value)):''}} </button>
											 @endif
											@endforeach
											</div>
											<?php } ?>
											</td>
										
											</td>
                                            <td>
											
											 <button type="button" class="btn btn-xs btn-outline btn-secondary mb-5">{{isset($infos->update_data_details[$dtk][0]->column_comment)?$infos->update_data_details[$dtk][0]->column_comment:''}} :{{isset($infos->update_data_details[$dtk][0]->value)?ucwords(str_replace('_',' ',$infos->update_data_details[$dtk][0]->value)):''}} </button>
											
											</td>
										
                                            <td><?php if($dtk==0){?>
                                                <?php
                                                if (isset($infos->action) && $infos->action == 'I')
                                                    echo 'Add';
                                                else if ($infos->action &&  $infos->action == 'U')
                                                    echo "Update";
                                                ?>	<?php } ?>
                                            </td>
									
										
                                            <td > <?php if($dtk==0){ ?>{{isset($infos->user)&& $infos->user!=''?get_user_by_id($infos->user):'System'}}  <?php } ?></td>
										
											<td><?php if($dtk==0){?> {{date('d/m/Y',strtotime($infos->action_tstamp_tx))}} <?php } ?></td>
										
											 <td > <?php  if($dtk==0) { ?> {{$infos->ip_addr}}  <?php } ?></td>
										
                                        </tr>
										
										
										<?php 
										}
										}
										
										} 
										}
										
										}?>
										
                                            
                                    </tbody>

                                </table>

                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="tab-pane pad" id="profile4" role="tabpanel">2</div>
                <div class="tab-pane pad" id="messages4" role="tabpanel">3</div>
            </div>

        </div>

    </div>
</section>
@stop

@section('footer_scripts')
<!-- SoftPro admin App -->
<!-- Sparkline -->
<script src="{{asset('assets/assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- owlcarousel -->
<script src="{{asset('assets/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js')}}"></script>
<script src="{{asset('assets/main/js/pages/widget-blog.js')}}"></script>
<script src="{{asset('assets/main/js/pages/list.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('assets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<!-- Bootstrap touchspin -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}">
</script>
<!-- This is data table -->
<script src="{{asset('assets/assets/vendor_components/datatable/datatables.min.js')}}"></script>
<!-- SoftPro admin for Data Table -->
<script src="{{asset('assets/main/js/pages/data-table.js')}}"></script>
<script src="{{asset('assets/main/js/pages/project-table.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('assets/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('assets/assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- SoftPro admin for advanced form element -->
<script src="{{asset('assets/main/js/pages/advanced-form-element.js')}}"></script>

<!---fontawesome online link--->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<!---fontawesome online link--->
<!-- date-range-picker -->
<script src="{{asset('assets/assets/vendor_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('assets/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}">
</script>
<!-- bootstrap color picker -->
<script src="{{asset('assets/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}">
</script>
<!-- bootstrap time picker -->
<script src="{{asset('assets/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- Form validator JavaScript -->
<script src="{{asset('assets/main/js/pages/validation.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset('assets/assets/vendor_plugins/iCheck/icheck.min.js')}}"></script>

<!-- FastClick -->
<script src="{{asset('assets/assets/vendor_components/fastclick/lib/fastclick.js')}}"></script>
<!-- validate  -->
<script src="{{asset('assets/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.min.js')}}">
</script>
<!-- SoftPro admin App -->
<script src="{{asset('assets/main/js/template.js')}}"></script>
<script>
     $('.from_date').datepicker({
        autoclose: true
    });
    $('.to_date').datepicker({
        autoclose: true
    });
    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }
	
$('#add_development_plan').submit(function(e){
	 var user = $('#user_id').val();
	 var from_date =  $('#from_date').val(); 
	 var table_name =  $('#table_name').val();
	 var error =0;
	 if(user == '')
	 {
		  $('#user_id').next().css('border','1px solid red');
		 error =1;
	 }
	 else
	 {
		 $('#user_id').next().css('border','');
		 
	 }
	 if(from_date == '')
	 {
		  $('#from_date').parent().css('border','1px solid red');
		  error =1;
	 }
	 else
	 {
		 $('#from_date').parent().css('border','');
		
	 } 
	 if(table_name == '')
	 {
		  $('#table_name').next().css('border','1px solid red');
		  error =1;
	 }
	 else
	 {
		 $('#table_name').next().css('border','');
		
	 }
	if( error > 0)
	{
		e.preventDefault();
	}
});	

function get_submodule(obj)
{
	var module = $(obj).val();
	var url = "<?= URL('project/get-sub-module')?>";
		$.ajax({
			url: url,
			method: "get",
			data:{'module':module},
			dataType: 'html',
			async: true,

			success: function(data) { 
			$('#table_name').html(data)
			}

		});
}
</script>

@stop