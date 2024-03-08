<!DOCTYPE html>
<html lang="en">
    @extends('admin.layouts.adminlayout')
@section('content')
    <!-- begin::Head -->
    <head>
		{{ HTML::style('assets/css/ol.css') }}
		{{ HTML::style('assets/css/vector.css') }}

        <style type="text/css">
		/*@media print {
			body * {
			visibility: hidden;
			}
			@page {
				size: auto !important;
				max-height:100%;
				max-width:100%;
			}
			#content,#content * {
				visibility: visible;
			}
			#content {
				position: absolute;
				left: 0;
				top: 0;
			}
		}*/
		
				
		
@media print {

body * {
visibility: visible;
}

#content, #content * {
visibility: visible;
}
#content {
position:absolute;
/*width:300px;*/
z-index:15;
left:3%;
right:20%;
/* margin:-150px 0 0 -150px;*/
}

.docs-tooltip {
visibility: hidden !important;
display:none !important;
}
[data-tooltip] {
visibility: hidden !important;
display:none !important;
}
.logo { display:block;margin-bottom:35px; float:left;} 

#header{
margin-top:19px;
margin-left:19px;

}
#noprint { 
display:none;
} 
#topbar { 
display:none !important;
} 
.site-nav { 
display:none;
} 
#footer { 
display:none !important;
} 
.form-group { 
display:none;
}
.page_title { 
display:none !important;
}

.responsive-menu-toggle { 
display:none !important;
}
.panel-title{
font-weight:600 !important;
margin-top:12px;
}	
.print_title{
display:block !important;
font-size:22px;
margin-bottom:12px;
margin-top:12px;
text-align:center;
}
a[href]:after {
content: none !important;
}


@page { 				size: auto !important;
margin-top: 30px; margin-bottom: 30px;
}

}
	

		
		
			.kt-aside--fixed .kt-wrapper{
			padding:0;
			}
			.kt-aside--fixed.kt-aside--minimize .kt-wrapper{
			padding:0 !important;
			}
			/*.kt-container{
			padding: 0 !important;
			}*/
			.popup-img{ margin-left: 7px; margin-top: 12px;}
			.labels12 {
			color: rgb(76,96,157);
			background-color: white;
			font-size: 14px;
			font-weight: bold;
			text-align: center;
			padding: 2px 5px;    
			border: 1px solid rgb(76,96,157);
			white-space: nowrap;
			}
			.treeview li {
			line-height: 5px;	
			padding-bottom: 6px;
			margin-bottom: 0;
			}
			#footer .footer-copyright {
			background: #303946;
			padding: 15px 0;
			display:none;
			} 			
			.colorpick-btn {
			display: inline-block;
			width: 12px;
			height: 12px;
			margin: 0;
			padding: 0;
			border-radius: 0;
			position: relative;
			}
			.colorpick-btn-round {
			display: inline-block;
			width: 12px;
			height: 12px;
			margin: 0;
			padding: 0;
			border-radius: 50%;
			position: relative;
			}			
.ol-popup-closer:after {
				content: "✖" !important;
			}

			#map{
			width: 100%;
			height: calc( 100vh - 140px ) !important;
			position: relative;
			/*padding: 0px 15px 0 15px;*/
			background: #f9f9fc;
			}

			//For Layers Legend
			.custom_button_div .dropdown-menu {
			left: -126px;
			}

			.stzoom{
	color: #3B77B0;
    font-size: 16px;
    padding-left: 4px;
}

			.form_group_div div{
			float:left;
			/*display:inline-block;*/
			width:180px;
			margin-left: 2px;
			}

			.form_group_div select{
			width:180px;
			margin:0;
			}
			.searchButton {
			width: 40px;
			margin-top: 1px;
			height: 33px;
			border: 1px solid #00B4CC;
			background: #00B4CC;
			text-align: center;
			color: #fff;
			border-radius: 0 5px 5px 0;
			cursor: pointer;
			font-size: 16px;
			}
			.myclass{
			display:inline-block;
			width: 54px;
			height: 22px;
			}
			.colorpick-btn {
			display: inline-block;
			width: 12px;
			height: 12px;
			margin: 0;
			padding: 0;
			border-radius: 0;
			position: relative;
			}
			.colorpick-btn-round {
			display: inline-block;
			width: 12px;
			height: 12px;
			margin: 0;
			padding: 0;
			border-radius: 50%;
			position: relative;
			}
			.stzoom{
			color: #3B77B0;
			font-size: 16px;
			padding-left: 4px;
			}
			.custom_line{
			font-size: 11px;
			line-height: 15px;
			}
			label {
			color: #ff3c3c !important;
			}
			.page_title{
			width:100% !important;
			float:left;
			margin-bottom: 5px;
			}
			.title_left{
			width:70%;
			float:left;
			/*margin-left: 14px;*/
			}
			.dropdown-toggle::after {
    display: none !important;
   
}
			.title_right{
			width:30%;
			float:right;
			/*margin-right: 15px;*/
			}
			/*.title_right {
			width: 100%;
			float: right;
			display: block;
			position: absolute;
			right: 26px;
			top: 25px;
			z-index: 9;
			}*/
			//For Layers Legend

			.filter-table-top table tr td{
			vertical-align: middle;
			}
			.filter-table-top table tr td .form-coontrol{
			height: 30px;
			}
			.filter-icon a.btn{
			font-size: 20px;
			padding: 2px 8px 2px 12px;
			margin-left: 15px;
			}
			.filter-table-top{
			border-bottom: 1px solid #ddd;
			}
			.filter-table-top .table{
			margin-bottom: 0;
			background: #fff;
			}
			.filter-table .table tr th{
			font-weight: 500;
			}
			.filter-table{
			max-height: 300px;
			overflow: auto;
			}
			#custom_overlay {
			position: fixed;
			width: 100%;
			height: 100vh;
			background: rgba(0,0,0,.9);
			z-index: 9;
			text-align: center;
			}
			#custom_overlay > div {
			top: 50%;
			left: 50%;
			text-align: center;
			margin-top: -21.5px;
			margin-left: -21.5px;
			position: absolute;
			}
			#content #topbar {
			display: none;
			}
			
			.ol-popup {
				min-width: 360px;
			}
			.pace.pace-active {
    display: none;
}
input[type=checkbox] {
    position: relative !important;
    left: 0 !important;
    opacity: 1 !important;
}
.box-body {
    padding: 0 !important;
}

.legend-gap{
margin-left: 17px;	
}
.content {
    padding: 7px 30px 0px 30px;
}
.custom_list_on_map{
	position: absolute;
	z-index: 99999;
	background: #fff;
	right: 0px;
	width: 254px;
	border: 1px solid #D9DEE4;
	padding:5px;
	top: 45px;
	    overflow-y: auto;
    height: calc( 100vh - 181px );
	}
.nor-icon {
    position: absolute;
    bottom: 13px;
    z-index: 999;
    float: left;
    right: unset;
    background-color: rgba(255,255,255,0.4);
    padding: 5px;
	margin-left: 12px;
    border-radius: 2px;
}

.ui-dialog-titlebar-close {
  background: url("http://code.jquery.com/ui/1.10.3/themes/smoothness/images/ui-icons_888888_256x240.png") repeat scroll -93px -128px rgba(0, 0, 0, 0);
  border: medium none;
}
.ui-dialog-titlebar-close:hover {
  background: url("http://code.jquery.com/ui/1.10.3/themes/smoothness/images/ui-icons_222222_256x240.png") repeat scroll -93px -128px rgba(0, 0, 0, 0);
}
.st-cent{
display: block !important;
margin: 0 auto !important;
}
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button {
    font-family: Verdana,Arial,sans-serif;
    font-size: 0.9em !important;
}
			
        </style>
		<base href="">
		<meta charset="utf-8" />
		<title>Dalmia-lams::Map</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		{{ HTML::style('assets/css/style.bundle.css') }}
		{{ HTML::style('assets/frontend/css/flaticon/flaticon.css') }}
		{{ HTML::style('assets/frontend/css/flaticon2/flaticon.css') }}
		{{ HTML::style('assets/plugins/font-awesome/css/font-awesome.min.css') }}

		
        
    </head>
    
    <!-- begin::Body -->
    <!--<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">-->
    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-aside--minimize">

        
       <!-- begin:: Page -->

        

        <!-- end:: Header Mobile -->
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

                <!-- begin:: Aside -->
                <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
                

                <!-- end:: Aside -->
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
					<input type="hidden" name="lat" id="lat">
					<input type="hidden" name="lon" id="lon">
                   
                   

                        <!-- end:: Subheader -->
						

                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" style="position: relative;">
							<div class="col-xs-12">
								 <div class="row" style="margin-top: 6px;">						
									<div class="page_title">						
									 <div class="title_left" id="title_left">			  			  
												<!--  Filter   -->
													
													  <input type="hidden" name="search" value="search">
														<div class="row">
															<div class="col-xs-12 col-sm-12 col-md-12 col-xl-12">
																														
																<div class="form_group_div">																							
																	 <div><select class="form-control select2-minimum" id="state_id" name="state_id" data-placeholder="Select State" onchange ="getDistrict()">
																	 <option></option>
																	 	<?php foreach ($states as $key => $states_data) { ?>
																		<option value="<?php echo $key;?>"><?php echo $states_data;?></option>
																		<?php } ?>									 
																	 </select>
</div>
																		<div style="margin-left:-1px !important;"></div>
																</div>																
																<div class="form_group_div">																							
																	 <div><select class="form-control select2-minimum" id="district_id" name="district_id" data-placeholder="Select District" onchange ="getBlock()">
																	 <option>Select District</option>
																	 									 
																	 </select></div>
																	<div style="margin-left:-1px !important;"></div>
																</div>
																<div class="form_group_div">																							
																	<div><select class="form-control select2-minimum" id="block_id" name="block_id" data-placeholder="Select Block" onchange ="getVillage()">
																	<option>Select Block/Taluk</option></select></div>
																	<div style="margin-left:-1px !important;"></div>
																</div>
																<div class="form_group_div">																							
																	<div><select class="form-control select2-minimum" id="village_id" name="village_id" data-placeholder="Select Village" onchange ="getSurveyPlot(this)">
																	<option>Select Village</option></select></div>
																	<div style="margin-left:-1px !important;"></div>
																</div>
																<div class="form_group_div">																							
																	<div><select class="form-control select2-minimum" id="survey_id" name="survey_id" data-placeholder="Select Survey No" onchange ="getSurveyPlotJson()">
																	<option>Select Survey No</option></select></div>
																	<div style="margin-left:-1px !important;"></div>
																</div>
															</div>	
														</div>		
													
												<!-- Filter End -->												
							  </div>
                            <div class="title_right">
                                <div class="button_group">
                                    <div class="btn-group pull-right">
                                        <!--<button type="button" class="btn btn-primary" onclick="openModalPlots();">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Initial Map View">
                                                <span class="fa fa-list-alt"></span>
                                            </span>
                                        </button>-->
                                        <button type="button" class="btn btn-primary" onclick="setExtent(67.9737167358398011,7.9312300682067898,97.5616378784179972,37.2809371948241974)">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Initial Map View">
                                                <span class="fa fa-arrows-alt"></span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="getPlotTooltip()" title="Tooltip">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Tooltip">
                                                <span class="fa fa-info-circle"></span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="measure('length')" title="Measure Length">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Measure Length">
                                                <span class="flaticon2-zig-zag-line-sign"></span>
                                            </span>
                                        </button>	
                                        <button type="button" class="btn btn-primary" onclick="measure('area')" title="Measure Area">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Measure Area">
                                                <span class="flaticon2-hexagonal"></span>
                                            </span>
                                        </button>
                                       
                                       <button type="button" id="noprint" class="btn btn-info" onclick="printMap()" title="Print Map">

                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Print Map">
                                                <span class="fa fa-print"></span>
                                            </span>
                                        </button>
										 <button type="button" class="btn btn-primary" onclick="drawBuffer()" title="Buffer">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Buffer">
                                                <span class="fa fa-gg-circle"></span>
                                            </span>
                                        </button>
										 <button type="button" class="btn btn-primary" title="Map Theme" onclick="classification_filter()">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Map Theme">
                                                <span class="fa fa-ticket"></span>
                                            </span>
                                        </button>
										
											
										 <button type="button" class="btn btn-primary" title="Export to SHP"  onclick="location.href='{{ url('map/exportShp') }}'">
										 
										 
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Export to SHP">
                                                <span class="fa fa-download"></span>
                                            </span>
                                        </button>
										
											
										<!-- <button type="button" class="btn btn-primary" title="Export to KML"  onclick="location.href='{{ url('map/exportKml') }}'">-->
										 
										 <button type="button" class="btn btn-primary" title="Export to KML" onclick="exportKML()">
										 
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Export to KML">
                                                <span class="fa fa-download"></span>
                                            </span>
                                        </button>
										
										 <button type="button" class="btn btn-primary" title="Upload KML File" onclick="upload_kml_file()">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Upload KML File">
                                                <span class="fa fa-upload"></span>
                                            </span>
                                        </button>
										
										 <button type="button" class="btn btn-primary" title="Multi Selection" onclick="multi_selection_filter()">
                                            <span class="docs-tooltip" data-toggle="tooltip" data-original-title="Multi Selection">
                                                <span class="fa fa-search"></span>
                                            </span>
                                        </button>
										
                                        						
                                    </div>
                                </div>	
                            </div>
						</div>
						</div>
						</div>
						<div class="clearfix"></div>							
                            <!--Begin::Dashboard 1-->

                            <!--Begin::Row-->
						
                           <div id="content">
 <div style="text-align:center">
                        <h4 class="panel-title" style="text-align:center;"><span id="print_title" class="print_title" style="display:none;"></span></h4>
                    </div>
							<div class="row">	
                                    <!--For legend display-->
									
																		

									<div class="col-sm-10">
                                    <div id="map"><div id="info"></div>
									
									</div> 
									<div class="nor-icon"><img src="<?= url('assets/img/PinClipart.com_needle-clipart_5272209.png')?>" width= "30"></div>

									</div>
									
									<div class="col-sm-2">
										<table class="table" id="layer_legend">
											<thead>
												<tr><th>Layer Legend </th>
													</td></tr>
											</thead>
											<tbody>	                                              
												<tr>
													<td>
														<span><input type="checkbox" class="layer" checked="true" id="parcel_boundry_id" value="parcel_boundry"> <i class="colorpick-btn" style="border:2px solid #fc8256;"></i><span id="parcel_boundry" class="fa fa-search-plus stzoom zoom-to-layer"></span>  Survey</span>
													</td>
													
												 </tr>
												 <tr>
													
													<td>
														<span><input type="checkbox" class="layer" checked="true" id="state_layer_id" value="state_layer"> <i class="colorpick-btn" style="border:2px solid #8B4513;"></i><span id="state_layer" class="fa fa-search-plus stzoom zoom-to-layer"></span>  State</span>
													</td>
												 </tr>
												 
												  <tr>
													
													<td>
														<span><input type="checkbox" class="layer" checked="true" id="district_layer_id" value="district_layer"> <i class="colorpick-btn" style="border:2px solid #8B4513;"></i><span id="district_layer" class="fa fa-search-plus stzoom zoom-to-layer"></span>  District</span>
													</td>																										
												 </tr>
												  
												 <tr>
												<td>	
												<span id="legend_map_theme_type"></span>
												  <span id="legend_map_theme_value" style="display: block;margin: 0 auto;margin-left: 32px;"></span>
												    </td>																										
												 </tr>                                           
											
											</tbody>
										</table>
										<table>
											<thead>
											<tr><th>Raster layers </th>
													</td></tr>
											</thead>
											<tbody>	
												<tr>
													
													<td>
														<span><input type="checkbox" class="layer" checked="true" id="layer_Resource_AndhraPradesh_id" value="layer_Resource_AndhraPradesh"> <span id="layer_Resource_AndhraPradesh" class="fa fa-search-plus stzoom zoom-to-layer"></span>  Resource AndhraPradesh</span>
													</td>																										
												 </tr>
												 <tr>
													
													<td>
														<span><input type="checkbox" class="layer" checked="true" id="layer58N1_id" value="layer58N1"> <span id="layer58N1" class="fa fa-search-plus stzoom zoom-to-layer"></span> 58N1</span>
													</td>																										
												 </tr>
												 <tr>
													
													<td>
														<span><input type="checkbox" class="layer" checked="true" id="layer58M4_id" value="layer58M4"> <span id="layer58M4" class="fa fa-search-plus stzoom zoom-to-layer"></span>  58M4</span>
													</td>																										
												 </tr>	<tr>
													
													<td>
														<span><input type="checkbox" class="layer" checked="true" id="layer58J13_id" value="layer58J13"> <span id="layer58J13" class="fa fa-search-plus stzoom zoom-to-layer"></span> 58J13</span>
													</td>																										
												 </tr>	
												 
											</tbody>	  
										</table>
											<select class="form-control" id="bing-select">
												<option value="Aerial" selected>Select Base Map</option>												
												<option value="Aerial">Aerial</option>
												<option value="AerialWithLabels">Aerial with labels</option>
												<option value="Road">Road</option>
											</select>										
									</div>
									
                                    <div id="mouse-position"></div>
                                    <div id="progress"></div>
									
									</div>
									</div>
                                
                                    <div id="popup" class="ol-popup">
                                        <a href="javascript:void(0);" id="popup-closer" class="ol-popup-closer"></a>
                                        <div id="popup-content"></div>
                                    </div>
																	
                              
                               </div>
                        </div>
                                                    

                            <!--End::Row-->



                            <!--End::Row-->

                            <!--End::Dashboard 1-->

                        <!-- end:: Content -->
                    </div>

                    <!-- begin:: Footer -->

                    <?php //$this->load->view('common/footer');  ?>
                    <!-- end:: Footer -->
                </div>
      
<!-- Modal -->
<div id="dialog" title="Buffer" style="display:none">
	<div class="row">
		<div class="col-sm-6 form-group">
		<select id="unit" class="slider form-control select2-minimum">
		<option value="km">Km</option>
		<option value="mtr">Mtr</option>
		</select>
		</div>			
		<div class="col-sm-6 form-group">
		<input type="text" value="" class="form-control" id="range_val" data-show-value="true" autocomplete="off">
		</div>
	</div>	
	<div class="row">
		<div class="col-sm-12 text-center">
			<button type="button" onclick="change_air_circle()" class="btn btn-sm btn-info">Draw</button>	
			<button type="button" onclick="clearDraw()" class="btn btn-sm btn-info"> Clear</button>
		</div>
	</div>	
</div>
<div id="dialog_measure" title="Measure" style="display:none">
	<div class="row">
		<div class="col-sm-12 form-group">
			<table id="measure-length"><tbody></tbody></table>
			<table id="measure-area"><tbody></tbody></table>			
		</div>
	</div>	
	<div class="row">
		<div class="col-sm-12 text-center">	
			<button type="button" onclick="clearMeasure()" class="btn btn-sm btn-info"> Clear</button>
		</div>
	</div>	
</div>
<!-- classification --->
<div id="dialog_classification" title="Map Theme" style="display:none">
	<div class="row">
			<div class="col-sm-12 form-group">
				<select class="slider form-control select2-minimum" id="cd_type">
				<option value="">Select</option>
				<?php foreach($unique_code_master_list as $code_value){?>
				<option value="<?= $code_value['cd_type'] ?>"><?= ucwords(str_replace("_"," ",$code_value['cd_type'])) ?></option>
				<?php } ?>
				</select>
			</div>
			
			<div id="code_value" style="display: block;margin: 0 auto;"></div>
			
			
			
			
			
			
			<div class="col-sm-12 form-group">
				<button type="button" onclick="filter_plot_classification()" class="btn btn-sm btn-info st-cent">Generate</button>		
			</div>
	
</div>
</div>

<div id="dialog_shape_result" title="Export" style="display:none">
<p>Successfully Exported</p>
</div>

<div id="dialog_kml_result" title="Success" style="display:none">
<p>Successfully Uploaded</p>
</div>

<div id="dialog_plot" title="Plot Information" style="display:none">
</div>


<div id="upload_kml_file1" title="Upload KML File" style="display:none;">
                {!! Form::open(['class' => 'form-horizontal kml_upload_form','method' => 'POST', 'id' => 'kml_upload_form','autocomplete'=>'off', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

	<div class="row" style="margin: 0 auto;">
			<div class="col-sm-12 form-group">
				<input type="text" name="kml_input_name" class="form-control" id="kml_input_name" required placeholder="Enter File Name">
			</div>
			
			<div class="col-sm-12 form-group">
				<input type="file" name="upload_kml_doc" class="form-control" id="upload_kml_doc" style="overflow: hidden;">
			</div>
			<div class="col-sm-12 form-group">
				<button type="button" onclick="upload_kml_data()" class="btn btn-sm btn-info st-cent">Upload</button>		
			</div>	
</div>
                {!! Form::close() !!}

</div>


<!-- classification --->
<div id="multi_selection_dialog" title="Multi Selection" style="display:none">
	<div class="row" style="background: #f6f6f6;padding-top: 5px;">					
			<div class="col-sm-12 form-group" style="display:block">
			<div style="float:left;font-size: 14px;">Selection Tools</div>
			<div style="float:right;">
				<a onclick="map_draw_feature('Rectangle')" title="Select by Box"><i class="fa fa-th" aria-hidden="true" style="cursor: pointer;"></i></a>
				<a onclick="map_draw_feature('Polygon')" title="Select by Polygon"><i class="fa fa-area-chart" aria-hidden="true" style="margin-left: 6px;cursor: pointer;"></i></a>
				<a onclick="map_draw_feature('Circle')" title="Select by Circle"><i class="fa fa-circle-o" aria-hidden="true"  style="margin-left: 6px;cursor: pointer;"></i></a>
			</div>
			</div>
	</div>
	<div class="row">
		<div class="col-sm-12 text-center">
			<button type="button" onclick="removeSelectedFeature()" class="btn btn-sm btn-info"> Clear</button>
		</div>
	</div>
</div>


               <!-- begin::Quick Panel -->
		{{ HTML::script('assets/js/jquery-2.1.1.min.js') }}
		{{ HTML::script('assets/js/ol.js') }}
		{{ HTML::script('assets/plugins/forms/select2/select2.js') }}


        <script>
		var select, selectFeatureClick;
		var draw;
		var container = document.getElementById('popup');
		var content = document.getElementById('popup-content');
		var closer = document.getElementById('popup-closer');
		//var googleLayer = new olgm.layer.Google({name:'Google'});
		var osm = new ol.layer.Tile({
			title: 'OSM Standard',
			name: 'osmMap',
			source: new ol.source.OSM(),
			visible: false,
		});

		var bingLayer = new ol.layer.Tile({
			name: 'bingLayer',
			preload: Infinity,
			visible: true,
			source: new ol.source.BingMaps({
				key: 'As1PsQi-MQ8I4ziLMIa_KHmzlmP4gG9KLoWaFuoF0Aj4DixiotNvmvQfLdfC1OHv',
				imagerySet: 'AerialWithLabels',
				

			})
		});

		var mousePositionControl = new ol.control.MousePosition({
			coordinateFormat: ol.coordinate.createStringXY(6),
			projection: 'EPSG:4326',
			// comment the following two lines to have the mouse position
			// be placed within the map.
			className: 'custom-mouse-position',
			target: document.getElementById('mouse-position'),
			undefinedHTML: '&nbsp;'
		});


		//================================TOOLTIP==================================

		/**
		 * Create an overlay to anchor the popup to the map.
		 */
		var plotTooltip = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
			element: container,
			autoPan: true,
			autoPanAnimation: {
				duration: 250
			}
		}));


	
		/**
		 * Add a click handler to hide the popup.
		 * @return {boolean} Don't follow the href.
		 */
		closer.onclick = function () {
			plotTooltip.setPosition(undefined);
			//map.removeInteraction(Select);
			plotselect.setSource(undefined);
			closer.blur();
			return false;
		};

		//================================LOAD BAR==================================

		function Progress(el) {
			this.el = el;
			this.loading = 0;
			this.loaded = 0;
		}

		Progress.prototype.addLoading = function () {
			if (this.loading === 0) {
				this.show();
			}
			++this.loading;
			this.update();
		};

		Progress.prototype.addLoaded = function () {
			var this_ = this;
			setTimeout(function () {
				++this_.loaded;
				this_.update();
			}, 100);
		};

		Progress.prototype.update = function () {
			var width = (this.loaded / this.loading * 100).toFixed(1) + '%';
			this.el.style.width = width;
			if (this.loading === this.loaded) {
				this.loading = 0;
				this.loaded = 0;
				var this_ = this;
				setTimeout(function () {
					this_.hide();
				}, 500);
			}
		};

		Progress.prototype.show = function () {
			this.el.style.visibility = 'visible';
		};

		Progress.prototype.hide = function () {
			if (this.loading === this.loaded) {
				this.el.style.visibility = 'hidden';
				this.el.style.width = 0;
			}
		};

		var progress = new Progress(document.getElementById('progress'));

		bingLayer.getSource().on('tileloadstart', function (event) {
			progress.addLoading();
		});

		bingLayer.getSource().on('tileloadend', function (event) {
			progress.addLoaded();
		});
	
	
	function zoomToLayerExtent(lyr){
	var pan = ol.animation.pan({
	duration: 2000,
	source: map.getView().getCenter()
	});
			
	var layer;
	var layers = map.getLayers();
	var length = layers.getLength();
	for (var i = 0; i < length; i++) {
	if (lyr === layers.item(i).get('name')) {
		var extent = layers.item(i).getSource().getExtent();
		if(extent[0] != 'Infinity'){
		//map.beforeRender(pan);	
		map.getView().fit(extent, map.getSize(),{
		  padding: [10, 10, 10, 10],
		  constrainResolution: false
		});
		return;
		}
	}
	}
}
		//layer layer58N1
			var layer58N1 = new ol.layer.Tile({
			visible: true,
			name: 'layer58N1',
			crossOrigin: 'anonymous',			
			source: new ol.source.TileWMS({
			url: '<?php echo $geo_url;?>',
			params: {
				'FORMAT': 'image/png',
				'VERSION': '1.1.1',
				tiled: true,
				"LAYERS": 'DALMIA-LAMS:58N1',
				"exceptions": 'application/vnd.ogc.se_inimage',
				tilesOrigin: 78.9986519 + "," + 10.7515248455812
			}
			})
			});
		//layer Layer58M4
			var layer58M4 = new ol.layer.Tile({
			visible: true,
			name: 'layer58M4',	
			crossOrigin: 'anonymous',			
			source: new ol.source.TileWMS({
			url: '<?php echo $geo_url;?>',
			params: {
				'FORMAT': 'image/png',
				'VERSION': '1.1.1',
				tiled: true,
				"LAYERS": 'DALMIA-LAMS:58M4',
				"exceptions": 'application/vnd.ogc.se_inimage',
				tilesOrigin: 78.9986519 + "," + 10.7515248455812
			}
			})
			});
		//layer layer58J13
			var layer58J13 = new ol.layer.Tile({
			visible: true,
			name: 'layer58J13',
			crossOrigin: 'anonymous',			
			source: new ol.source.TileWMS({
			url: '<?php echo $geo_url;?>',
			params: {
				'FORMAT': 'image/png',
				'VERSION': '1.1.1',
				tiled: true,
				"LAYERS": 'DALMIA-LAMS:58J13',
				"exceptions": 'application/vnd.ogc.se_inimage',
				tilesOrigin: 78.9986519 + "," + 10.7515248455812
			}
			})
			});
			//layer Resource_AndhraPradesh
			var layer_Resource_AndhraPradesh = new ol.layer.Tile({
			visible: true,
			name: 'layer_Resource_AndhraPradesh',
			crossOrigin: 'anonymous',
			source: new ol.source.TileWMS({
			url: '<?php echo $geo_url;?>',
			params: {
				'FORMAT': 'image/png',
				'VERSION': '1.1.1',
				tiled: true,
				"LAYERS": 'DALMIA-LAMS:Resource_AndhraPradesh',
				"exceptions": 'application/vnd.ogc.se_inimage',
				tilesOrigin: 78.9986519 + "," + 10.7515248455812
			}
			})
			});
			
			var parcel_boundry = new ol.layer.Tile({
			visible: true,
			name: 'parcel_boundry',
			source: new ol.source.TileWMS({
				url: '<?php echo $geo_url;?>',
				params: {
					'FORMAT': 'image/png',
					'VERSION': '1.1.1',
					tiled: true,
					"LAYERS": 'DALMIA-LAMS:T_SURVEY_MAP',
					"exceptions": 'application/vnd.ogc.se_inimage',
					tilesOrigin: 79.1550598144531 + "," + 11.0369215011597
				}
			})
		});
		
		
		var classification_boundry = new ol.layer.Tile({
			visible: true,
			name: 'classification_boundry',
			source: new ol.source.TileWMS({
				url: '<?php echo $geo_url;?>',
				params: {
					'FORMAT': 'image/png',
					'VERSION': '1.1.1',
					tiled: true,
					"LAYERS": 'DALMIA-LAMS:survey_map_classification',
					"exceptions": 'application/vnd.ogc.se_inimage',
					tilesOrigin: 79.1550598144531 + "," + 11.0369215011597
				}
			})
		});
		
		var state_layer = new ol.layer.Tile({
			visible: true,
			name: 'state_layer',
			source: new ol.source.TileWMS({
				url: '<?php echo $geo_url;?>',
				params: {
					'FORMAT': 'image/png',
					'VERSION': '1.1.1',
					tiled: true,
					"LAYERS": 'DALMIA-LAMS:T_STATE',
					"exceptions": 'application/vnd.ogc.se_inimage',
					tilesOrigin: 79.1550598144531 + "," + 11.0369215011597
				}
			})
		});
		
		
		var district_layer = new ol.layer.Tile({
			visible: true,
			name: 'district_layer',
			crossOrigin: 'anonymous',
			source: new ol.source.TileWMS({
				url: '<?php echo $geo_url;?>',
				params: {
					'FORMAT': 'image/png',
					'VERSION': '1.1.1',
					tiled: true,
					"LAYERS": 'DALMIA-LAMS:T_DISTRICT',
					"exceptions": 'application/vnd.ogc.se_inimage',
					tilesOrigin: 79.1550598144531 + "," + 11.0369215011597
				}
			})
		});
		
		

		
///


		var plotselect = new ol.layer.Vector({
			name: 'plotselect',
			
			style: function (feature, resolution) {
				var style = new ol.style.Style({
					fill: new ol.style.Fill({
						color: 'rgba(255, 255, 255, 0.1)',
					}),
					stroke: new ol.style.Stroke({
						color: 'blue',
						width: 3
					})
				});
				return style;
			},
			visible: true
		});
		
		
		var plotselect_draw = new ol.layer.Vector({
			name: 'plotselect_draw',
			
			style: function (feature, resolution) {
				var style = new ol.style.Style({
					fill: new ol.style.Fill({
						color: 'rgba(255, 255, 255, 0.1)',
					}),
					stroke: new ol.style.Stroke({
						color: 'green',
						width: 2
					})
				});
				return style;
			},
			visible: true
		});
		
		var map = new ol.Map({
			controls: ol.control.defaults({attribution: false}).extend([
				new ol.control.ScaleLine(),
				mousePositionControl
			]),
			//interactions: olgm.interaction.defaults(),
			layers: [
				bingLayer, layer_Resource_AndhraPradesh,layer58N1,layer58M4,layer58J13,parcel_boundry,district_layer,state_layer,plotselect,plotselect_draw
			],
			target: 'map',
			view: new ol.View({
				maxZoom: 19,
				minZoom: 1,
				zoom: 19
			})
		});
		var draw;
		var buffer;
		function drawBuffer() {
		var value = 'Point';
		 var bufferSource = new ol.source.Vector({wrapX: false});
		 buffer = new ol.layer.Vector({
			source: bufferSource,
				style: new ol.style.Style({
				fill: new ol.style.Fill({
				color: 'rgba(255, 255, 255, 0.2)'
				}),
				stroke: new ol.style.Stroke({
				color: '#ffcc33',
				width: 2
				}),
				image: new ol.style.Circle({
				radius: 7,
				fill: new ol.style.Fill({
				color: '#ffcc33'
				})
				})
				})

		  });

		  draw = new ol.interaction.Draw({
			source: bufferSource,
			type: /** @type {ol.geom.GeometryType} */ value
		  });
		  map.addInteraction(draw);			  
		  map.addLayer(buffer);

			this.draw.on('drawend', function( evt ){
			var geometry = evt.feature.getGeometry();
			//var center = geometry.getCenter();
			var getCoordinates = geometry.getCoordinates();
			var lon = getCoordinates[0].toFixed(2);
			var lat = getCoordinates[1].toFixed(2);			
			document.getElementById("lat").value = lat;
			document.getElementById("lon").value = lon;			
		});
		  $("#dialog").dialog({close: dialogremoveLayer});
		}
		
		
		
		function removeLayer(lyr) {
			//var lyr = 'circleLayer';
			var layers = map.getLayers();
			var length = layers.getLength();
			for (var i = 0; i < length; i++) {
				if (lyr === layers.item(i).get('name')) {
				map.removeLayer(layers.item(i));
				break;
				}
				
			}
		}
		function clearDraw(){
		  var lyr = 'circleLayer';
			var layers = map.getLayers();
			var length = layers.getLength();
			for (var i = 0; i < length; i++) {
				if (lyr === layers.item(i).get('name')) {
				map.removeLayer(layers.item(i));
				break;
				}
				
			}
			map.removeInteraction(draw);				
		}
		
			function removeSelectedFeature() {
				/*var features = vectorSource.getFeatures();
var lastFeature = features[features.length - 1];
vectorSource.removeFeature(lastFeature);*/

//for(var i = features.length -1; i >= 0; i--)
var features = vectorSource.getFeatures();
 for (var i = features.length -1; i >= 0; i--){
       vectorSource.removeFeature( features[i] );
	   			map.removeInteraction(draw1);				
			plotselect_draw.setSource(undefined);

   }

			}

		
		function change_air_circle()
		{
			var lat = document.getElementById("lat").value;
			var lon = document.getElementById("lon").value;
			
			//alert(lat);
			//alert(lon);
			if(lat != '' && lon != ''){			
				var obj = document.getElementById("range_val");
				
				var r_val = $(obj).val();
				//alert(r_val);
				var unit = document.getElementById("unit").value;
				
				if(unit == 'km'){
				var range_val = parseInt($(obj).val())*parseInt(1000);
				}else if(unit == 'mtr'){
				var range_val = parseInt($(obj).val());
				}		
				
			

				var latlng =  lon +'|'+lat;				
					if(unit == 'km'){
						$(obj).parent().next().children().text(r_val+' km');
					}else if(unit == 'mtr'){
						$(obj).parent().next().children().text(r_val+' mtr');
					}
					drawCircleInMeter(map,latlng,range_val,unit);
			}else{
				alert('Please mark a point location to create buffer !');
				document.getElementById("myRange").value="0";
			}			
		}
		
		var drawCircleInMeter = function(map,latlong, rad, unit) {
			if(unit=='km'){
				var rad_bs = (rad/1000)+' km';
			}else if(unit=='mtr'){
				var rad_bs =  (rad)+' mtr'
			}

			var x = latlong.split("|");
			var lat = parseFloat(x[0]);
			var lng = parseFloat(x[1]);
			var center = [lat,lng];
		//center = ol.proj.transform(center, 'EPSG:4326', 'EPSG:3857');

		var view = map.getView();
		var projection = view.getProjection();
		var resolutionAtEquator = view.getResolution();
		//var center = map.getView().getCenter();
		//var pointResolution = projection.getPointResolution(resolutionAtEquator, center);
		//var resolutionFactor = resolutionAtEquator/pointResolution;
		var radius = (rad / ol.proj.METERS_PER_UNIT.m) * 1;


        var circle = new ol.geom.Circle(center, radius);
        var circleFeature = new ol.Feature(circle);
        // Source and vector layer

        var circleSource = new ol.source.Vector({});
        circleSource.addFeature(circleFeature);
        var circleLayer = new ol.layer.Vector({
			name: 'circleLayer',
            source: circleSource,
			style: function (feature, resolution){
			var style = new ol.style.Style({
			fill: new ol.style.Fill({
				color: 'rgba(100, 20, 0, 0.2)',
			}),			
			stroke: new ol.style.Stroke({
				color: '#ff3300',
				width: 3
			})					
			});
			return style;		
			}
        });
		map.getLayers().forEach(function (layer) {
		if (layer.get('name') != undefined & layer.get('name') === 'circleLayer') {
		map.removeLayer(layer);
		}
		});
		//map.removeLayer(circleLayer);
        map.addLayer(circleLayer);
		zoomToLayerExtent('circleLayer');
		var geom;
		map.getLayers().forEach(function (layer) {
			if (layer.get('name') != undefined & layer.get('name') === 'circleLayer') {
				var features = layer.getSource().getFeatures();
				geom = features[0].getGeometry().getLastCoordinate();
			}						
		});
		var points = [ center, geom ];
		var featureLine = new ol.Feature({
			geometry: new ol.geom.LineString(points)
		});
		var vectorLine = new ol.source.Vector({});
		vectorLine.addFeature(featureLine);

		var vectorLineLayer = new ol.layer.Vector({
			name : 'vectorLineLayer',
			source: vectorLine,
			style: new ol.style.Style({
				fill: new ol.style.Fill({ color: '#00FF00', weight: 4 }),
				stroke: new ol.style.Stroke({ color: '#00FF00', width: 2 }),
				text : new ol.style.Text({
					fill: new ol.style.Fill({ color: '#00FF00'}),
					font : 'Bold 10px Arial',
					offsetY : 12,
					text : rad_bs
				})
			})
		});	
		map.getLayers().forEach(function (layer) {
		if (layer.get('name') != undefined & layer.get('name') === 'vectorLineLayer') {
		map.removeLayer(layer);
		}
		});		
		map.removeLayer(vectorLineLayer);			
		map.addLayer(vectorLineLayer);			
    }
	function dialogremoveLayer() {
			var lyr = 'circleLayer';
			var layers = map.getLayers();
			var length = layers.getLength();
			for (var i = 0; i < length; i++) {
				if (lyr === layers.item(i).get('name')) {
				map.removeLayer(layers.item(i));
				break;
				}
				
			}
		}
	
	function classification_filter(){		
			  $("#dialog_classification").dialog();	
	}
	function multi_selection_filter(){		
			  $("#multi_selection_dialog").dialog({close: removeSelectedFeature});	
	}
	function upload_kml_file(){	
		$('#kml_upload_form input[type="text"]').val('');
		$('#kml_upload_form #upload_kml_doc').val('');
		$("#upload_kml_file1").dialog();	
		// $("#upload_kml_file1").val("");	

	}	
	
	function exportKML(){
		
		var filename = prompt('Please enter .kml file name to export.');
		//alert(filename);
		var get_ids = localStorage.getItem("get_ids");
        //window.location.href = "http://localhost/dalmia-lams/map/exportKml?filename=" + filename+"&ids="+get_ids;
		window.location.href = '<?php echo URL("map/exportKml?filename=");?>' + filename+"&ids="+get_ids;

		}
		
	
	function exportShp(){
			 if (confirm('Are you want to export?')) {
			 $.ajax({
				url:'exportShp',
				method:"GET",
				dataType: 'json',
				//data: {'state_id': state_id},
				success:function(response)
				{

					if(response.zip) {
						var a = document.createElement("a");
            a.href = response.zip;
                                a.download = response.zip;
                                document.body.appendChild(a);
                                a.target = "_blank";
                                a.click();
        }



					
				/*if(data == 1){
					$("#dialog_shape_result").dialog({
					width : 200,
					height: 200,
					modal : true
					});
					
				}*/
				
				}
			   }); 
				
		}
	}
	
	function filter_plot_classification()
	{		
		var cd_type = $('#cd_type').val();
			if(cd_type != ''){
			$.ajax({
			url: 'getClassification',
			type: 'GET',
			dataType: 'json',
			data: {'cd_type': cd_type},
			success:function(data)
			{
			var data_response = JSON.stringify(data);
			var parse_data_response = JSON.parse(data_response);
			//alert(parse_data_response);
			var html_li = '';
			
			for (var key in parse_data_response) {

			//alert(parse_data_response[key].color_code);
			html_li += '<i class="colorpick-btn" style="border:2px solid #8B4513;background:'+parse_data_response[key].color_code+'"></i>  <span>'+parse_data_response[key].code_desc+'</span><br>';
			}
			
			$('#code_value').html(data);
			$('#legend_map_theme_value').html(html_li);
			
			var cd_type1 = cd_type.split("_").join(" ");
			var cd_type1 = cd_type1.replace(/(^\w{1})|(\s{1}\w{1})/g, match => match.toUpperCase());
			
			
			
			var html = '<input type="checkbox" class="layer" checked="true" id="" value="classification_layer"> <i class="colorpick-btn" style="border:2px solid #8B4513;"></i><span id="classification_layer" class="fa fa-search-plus stzoom zoom-to-layer"></span> '+cd_type1;
			$('#legend_map_theme_type').html(html);
			
				var classification_url = '<?php echo URL("map/get-classification-json");?>/'+cd_type;
				var color1 ;
				var classification_layer1 = new ol.layer.Vector({
				name : 'classification_layer',
				source: new ol.source.Vector({
				url: classification_url,
				format: new ol.format.GeoJSON({
				defaultDataProjection :'EPSG:4326',
				projection: 'EPSG:3857'
				})
				}),
				style: function (feature, resolution){	
				//alert('started');
				//alert(feature.get('theme'));
				for (var key in parse_data_response) {
					if(feature.get('theme') == key){
						//alert(feature.get('theme'));
						//alert('hii');
						//alert(key);
						color1 = parse_data_response[key].color_code;
						//alert(color1);
					}
					
				}
				//alert('no res');
					//alert(color1);
				var style = new ol.style.Style({
				fill: new ol.style.Fill({
				color: color1,
				}),			
				stroke: new ol.style.Stroke({
				color: color1,
				width: 1
				})				
				});	
				return style;
				},
				visible: true
				});
				//map.removeLayer(classification_layer1);
				removeLayer('classification_layer');
				map.addLayer(classification_layer1);
				parcel_boundry.setZIndex(999);
				classification_layer1.setZIndex(parseInt(this.value, 10) || 0);	
				//classification_layer1.setZIndex(9999);
				zoomToLayerExtent('classification_layer');
				
				$('.layer').on( "click",function (index) {
				setLayerVisibility($(this).val(), $(this).prop('checked'));
		});

			}
			});
		}
		
	   
			   

	}   
			   
		
		
	function upload_kml_data()
	{
			
			var kml_upload_form = $("#kml_upload_form")[0];
			$.ajax({
			url: 'uploadKml',
			type: "post",
			data: new FormData(kml_upload_form),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			success: function (response)
			{
			if(response.message == 1){				
				/* $("#upload_kml_file1").dialog('close');
					$("#dialog_kml_result").dialog({
					width : 200,
					height: 200,
					modal : true
					});
				*/
				$("#upload_kml_file1").dialog('close');
				alert('KML file successfully uploaded');
				
				var kml_layer_name = response.layer_name;
				
					var file = document.getElementById("upload_kml_doc").files[0];
					var kml_layer_name = document.getElementById("kml_input_name").value;
					if (file) {

					var reader = new FileReader();
					reader.onload = function () {

					var kml_layer = new ol.layer.Vector({
					name : kml_layer_name,	
					source: new ol.source.Vector({
					url: reader.result,
					format: new ol.format.KML()
					})
					});
					map.addLayer(kml_layer);
					
					//kml_layer_name.events.register('loadend', kml_layer_name, function(evt){map.zoomToExtent(kml_layer_name.getDataExtent())})
					
					//kml_layer.events.register("loadend", kml_layer, function (e) {
						//alert('jii');
					zoomToLayerExtent(kml_layer_name);

					//}); 
					
					}
					reader.readAsDataURL(file);

					}
					
					
					var html = '<tr><td><span><input type="checkbox" class="layer" checked="true" value="'+kml_layer_name+'"><span id="'+kml_layer_name+'" class="fa fa-search-plus stzoom zoom-to-layer"></span> '+kml_layer_name+'</span></td></tr>';
					$('#layer_legend tbody').append(html);
					

					
					$('.layer').on( "click",function (index) {
					setLayerVisibility($(this).val(), $(this).prop('checked'));
					});
					
					//zoomToLayerExtent(kml_layer_name);

				
			}
			}
			});
		}
		
		var draw1;
		var buffer1;
var vectorSource;
		function map_draw_feature(draw_type){	
			map.removeInteraction(draw1);
			
			var value = draw_type;

			var geometryFunction = null;
			if (draw_type === 'Rectangle') {
				value = 'Circle';
				geometryFunction = ol.interaction.Draw.createBox();
			}
			else if (draw_type === 'Circle') {			
				geometryFunction = ol.interaction.Draw.createRegularPolygon(32);
			}
			var source = new ol.source.Vector({wrapX: false});
			draw1 = new ol.interaction.Draw({
				source: source,
				type: /** @type {ol.geom.GeometryType} */ value,
				geometryFunction: geometryFunction
			});
			map.addInteraction(draw1);			  

			draw1.on('drawend', function(evt) {

				var geoJsonGeom = new ol.format.GeoJSON();    
				var coords = geoJsonGeom.writeGeometry(evt.feature.getGeometry().transform('EPSG:3857', 'EPSG:4326'));
				var format = new ol.format.GeoJSON();
				vectorSource = new ol.source.Vector({
				strategy: ol.loadingstrategy.bbox,
				loader: function(extent, resolution, projection) {
						$.ajax({
							url:'get-draw-serveyno-json',
							method: "post",
							dataType: 'json',
							async: false,
							data: {
								"coordinate": coords,
								"_token": "{{ csrf_token() }}",
							},
							success: function (response) {								
								var features = format.readFeatures(response,
								{dataProjection: 'EPSG:4326',
								featureProjection: 'EPSG:3857'});
								vectorSource.addFeatures(features);
								//alert(response.features.length);
								var get_ids = [];
									for(var featureCount=0; featureCount < response.features.length; featureCount++){
										console.log(response.features[featureCount].properties.id);
										get_ids.push(response.features[featureCount].properties.id);
									} 
								
								localStorage.setItem("get_ids", get_ids);
								//var get_ids = localStorage.getItem("get_ids");
								//alert(startTime);
							}
						});
				}
				});
				plotselect_draw.setSource(vectorSource);

			});
			//console.log(pp);				   
		}

      /**
       * Handle change event.
       */
     
		/*var select = new ol.interaction.Select({
		 layers: [plot]
		 });
		 map.addInteraction(select);*/

		//setExtent(43.6162575, 3.0761851, 43.6951488, 3.1635315);
		setExtent(67.9737167358398011,7.9312300682067898,97.5616378784179972,37.2809371948241974);
		function setExtent(minx,miny,maxx,maxy){
			var minx = parseFloat(minx);
			var miny = parseFloat(miny);
			var maxx = parseFloat(maxx);
			var maxy = parseFloat(maxy);
			var bottomLeft = ol.proj.transform([minx, miny], 'EPSG:4326', 'EPSG:3857');
			var topRight = ol.proj.transform([maxx, maxy], 'EPSG:4326', 'EPSG:3857');
			var extent = new ol.extent.boundingExtent([bottomLeft, topRight]);
			map.getView().fit(extent, map.getSize(),{
			padding: [50, 50, 50, 50],
			constrainResolution: true,
			});
		}
		function printMap()
		{
		var print_title = prompt('Please enter title');
		if(print_title == '' || print_title == null){
		alert('Please provide a title');
		}else{
		$('#print_title').html(print_title);
		//document.getElementById( 'print_title' ).style.display = 'block';
		window.print();
		}
		}
		function zoomIn() {
			map.getView().setZoom(map.getView().getZoom() + 1);
		}
		function zoomOut() {
			map.getView().setZoom(map.getView().getZoom() - 1);
		}
		
		$('.layer').on( "click",function (index) {
			setLayerVisibility($(this).val(), $(this).prop('checked'));
		});
		$('#bing-select').change(function (index) {
			//alert($(this).val());
			var bingSource = new ol.source.BingMaps({
				key: 'As1PsQi-MQ8I4ziLMIa_KHmzlmP4gG9KLoWaFuoF0Aj4DixiotNvmvQfLdfC1OHv',
				imagerySet: $(this).val()
			});
			bingLayer.setSource(bingSource);
		});
		
		function setLayerVisibility(lyr, tf) {
			var layers = map.getLayers();
			var length = layers.getLength();
			for (var i = 0; i < length; i++) {
				if (lyr === layers.item(i).get('name')) {
					//alert(lyr);
					//alert(layers.item(i).get('name'));
					
					layers.item(i).setVisible(tf);
					break;
				}
			}
		}

		//                                                                        $('.minimize').on('click', function () {
		//                                                                            var tagval = $(this).attr('tag');
		//
		//                                                                            if (tagval == 'minimize') {
		//                                                                                $(this).attr('tag', 'maximize');
		//                                                                                $('#frm2').css("display", "block");
		//                                                                                $(this).html('<i class="kt-menu__ver-arrow la la-angle-double-up"></i></a>');
		//                                                                            } else {
		//                                                                                $(this).attr('tag', 'minimize');
		//                                                                                $('#frm2').css("display", "none");
		//                                                                                $(this).html('<i class="kt-menu__ver-arrow la la-angle-double-down"></i></a>');
		//                                                                            }
		//                                                                        });
		
		
		
        </script>
		
        <script>
		
 $('#range_val').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
  });

		 $('.select2-minimum').select2({
            placeholder: 'select',
        });

	
			

            function updateFilter(layer, id, ths) {

                /*if (!supportsFiltering) {
                 return;
                 }*/

                var filterType = 'cql';
                var filter = id + ' = ' + "'" + ths + "'";

                // by default, reset all filters
                var filterParams = {
                    'FILTER': null,
                    'CQL_FILTER': null,
                    'FEATUREID': null
                };
                if (filter.replace(/^\s\s*/, '').replace(/\s\s*$/, '') != "") {
                    if (filterType == "cql") {
                        filterParams["CQL_FILTER"] = filter;
                    }
                    if (filterType == "ogc") {
                        filterParams["FILTER"] = filter;
                    }
                    if (filterType == "fid")
                        filterParams["FEATUREID"] = filter;
                }
                // merge the new filter definitions
                map.getLayers().forEach(function (lyr) {
                    if (lyr.get('name') == layer)
                        lyr.getSource().updateParams(filterParams);
                });
            }
			
			
          function zoomToVillage(ths) {
				var url = '<?php echo URL("map/getZoomGeoJson"); ?>/'+ ths;
                $.ajax({
                    method: "get",
                    url: url,
                    success: function (data, textStatus, jqXHR) {
                        var x = data.split(",");
                        setExtent(parseFloat(x[0]), parseFloat(x[1]), parseFloat(x[2]), parseFloat(x[3]));
                    }
                });
            }
			
			function zoomToPlayer(ths) {
				var url = '<?php echo URL("map/zoomToPlayer"); ?>/'+ ths;
                $.ajax({
                    method: "get",
                    url: url,
                    success: function (data, textStatus, jqXHR) {
                        var x = data.split(",");
                        setExtent(parseFloat(x[0]), parseFloat(x[1]), parseFloat(x[2]), parseFloat(x[3]));
                    }
                });
            }
			function getSurveyPlotJson() {
			var survey_id = $('#survey_id').val();
			if(survey_id != ''){			
			 $.ajax({
				url:'get-serveyno-json',
				method:"GET",
				dataType: 'json',
				data:{"survey_id":survey_id},
				success:function(data)
				{
					data_response = JSON.stringify(data.plot_data);
					parse_data_response = JSON.parse(data_response);
					var minx = parse_data_response.st_xmin;
					var miny = parse_data_response.st_ymin;
					var maxx = parse_data_response.st_xmax;
					var maxy = parse_data_response.st_ymax;

					setExtent(minx,miny,maxx,maxy);
					//selectPlot(survey_id);
					
				}
			   }); 
				selectPlotSearch(survey_id);

			}
		}
		 function getClassificationData() {
			var cd_type = $('#cd_type').val();
			//$('#code_value').select2().trigger('change');
			if(cd_type != ''){
			$.ajax({
			url: 'getClassification',
			type: 'GET',
			data: {'cd_type': cd_type},
			success:function(data)
			{
			$('#code_value').html(data);
			$('#legend_map_theme_value').html(data);
			
			var html = '<input type="checkbox" class="layer" checked="true" id="" value=""> <i class="colorpick-btn" style="border:2px solid #8B4513;"></i> '+cd_type;

			$('#legend_map_theme_type').append(html);
						
			
			//$("#code_value").trigger('change');
			}
			});
		}
		//else { $('#code_value').html('<option value="">Select</option>');}	

		}
		
		
          

         
             function selectPlot(id) {
				var url = '<?php echo URL("map/getPlotGeoJson"); ?>/'+ id;
				//alert(url);
                var source = new ol.source.Vector({
                    url: url,
                    format: new ol.format.GeoJSON({
                        defaultDataProjection: 'EPSG:4326',
                        projection: 'EPSG:3857'
                    })
                });
                plotselect.setSource(source);
            }
			
			
			 function selectPlotSearch(id) {
				var url = '<?php echo URL("map/getPlotSearchGeoJson"); ?>/'+ id;
				//alert(url);
                var source = new ol.source.Vector({
                    url: url,
                    format: new ol.format.GeoJSON({
                        defaultDataProjection: 'EPSG:4326',
                        projection: 'EPSG:3857'
                    })
                });
                plotselect.setSource(source);
            }
            /*function getPlotTooltip() {
                map.addOverlay(plotTooltip);
                map.on('singleclick', function (evt) {
                    console.log(evt);
                    var coord = evt.coordinate;

                    var coordinate1 = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');

                    var url = "http://182.74.36.11/hoori/common/plot_popup/PL0000000002";
                    $.ajax({
                        method: "get",
                        url: url,
                        data: {coordinate: coordinate1},
                        success: function (data, textStatus, jqXHR) {
                            if (data != 1) {
                                $('#popup').show();
                                var ret = data.split("|");
                                content.innerHTML = ret[1];
                                plotTooltip.setPosition(coord);
                                selectPlot(ret[0]);
                            }
                        }
                    });
                });
            }*/
			
			
			  function getPlotTooltip() {
                map.addOverlay(plotTooltip);
                map.on('singleclick', function (evt) {
					
					evt.preventDefault();
                    console.log(evt);
                    var coord = evt.coordinate;

                    var coordinate1 = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');

                    var url = '<?php echo URL("map/getPlotInfo"); ?>';
                    $.ajax({
                        method: "get",
                        url: url,
                        data: {coordinate: coordinate1},
                        success: function (data, textStatus, jqXHR) {
                            if (data != 1) {
                                $('#popup').show();
                                var ret = data.split("|");
                                content.innerHTML = ret[1];
                                plotTooltip.setPosition(coord);
                                selectPlot(ret[0]);
                            }
                        }
                    });

                });
            }
			
			
			
			
			
            $(document).ready(function () {
                // Detect pagination click
                $('#pagination').on('click', 'a', function (e) {
                    e.preventDefault();
                    var pageno = $(this).attr('data-ci-pagination-page');
                    loadPagination(pageno);
                });
            });

            // Load pagination
            /*function loadPagination(pagno) {
                var village_id = $('#village_id').val();
                
                $.ajax({
                    url: 'http://182.74.36.11/hoori/common/get_village_plot/' + pagno,
                    type: 'get',
                    data: {village_id: village_id},
                    dataType: 'json',
                    success: function (response) {
                        //alert(response.count);
                        $('#pagination').html(response.pagination);
                        
                        createTable(response.result, response.row);
                    }
                });
            }*/

            // Create table list
            function createTable(result, sno) {
                sno = Number(sno);
                $('#kt_table_3 tbody').empty();

                for (index in result) {
                    var VLG_NAME = result[index].VLG_NAME;
                    var DISTRICT_NAME = result[index].DISTRICT_NAME;
                    var PLS_PLOT_ID = result[index].PLS_PLOT_ID;
                    var PLS_PLOT_NO = result[index].PLS_PLOT_NO;
                    var PLS_PLOT_TYPE = result[index].PLS_PLOT_TYPE;
                    var PLS_TOTAL_AREA = result[index].PLS_TOTAL_AREA;
                    var url_plot='village/plot-details?page_id=plot_detail&plot_id='+PLS_PLOT_ID;
                    var url='http://182.74.36.11/hoori/'+url_plot;
                    var tr = "<tr>";
                    tr += '<td><a href="javascript:zoomToPlot(\'' + PLS_PLOT_ID + '\')"><i class="flaticon2-search"></i></a></td>';
                    tr += "<td>" + DISTRICT_NAME + "</td>";
                    tr += "<td>" + VLG_NAME + "</td>";                   
                    tr += "<td> <a target='_blank' href='"+url+"'>"+ PLS_PLOT_NO + "</a></td>";
                    tr += "<td>" + PLS_PLOT_TYPE + "</td>";
                    tr += "<td>" + PLS_TOTAL_AREA + "</td>";
                    tr += "</tr>";
                    $('#kt_table_3 tbody').append(tr);

                }
            }

            function populateVilages(ths) {
                var district_id = $(ths).val();
                //alert(district_id);
                if (district_id) {
                    $.ajax({
                        url: baseUrl + 'common/get_village_under_district',
                        type: 'GET',
                        data: {'district_id': district_id},
                        success: function (data) {
                            //var select_box = '<select class="form-control" name="village[VIL_SUBDISTRICT_ID]" id="select_subdistrict">' + data + '</select>';
                            $('#village_id').html(data);
                        }
                    });
                }
            }

            function openModalPlots() {
                var district_id = $('#district').val();
                var village_id = $('#village_id').val();
                if (district_id=="" && !village_id=="") {                    
                    alert("Please select district and village to view the Plot List");
                     $('#kt_modal_2').modal('hide');
                } else {
                    var modalDiv = $('#kt_modal_2');
                    modalDiv.modal({backdrop: false, show: true});

                    $('#kt_modal_2').draggable({
                        handle: ".modal-header"
                    });
                     $('#kt_modal_2').modal('hide');
                }
            }
			
			function zoomToCordinate(latlong){
			var x = latlong.split("|");
			var lat = parseFloat(x[0]);
			var lng = parseFloat(x[1]);	
			map.getView().setCenter(ol.proj.transform([lat,lng], 'EPSG:4326', 'EPSG:3857'));
			map.getView().setZoom(15);
			}
			
			$(document).on('click', ".zoom-to-layer", function(index) {
				var layer_value = $(this).attr("id");
				if(layer_value == 'state_layer'){
					zoomToPlayer('state_layer');					
				}else if(layer_value == 'district_layer'){
					zoomToPlayer('district_layer');					
				}else if(layer_value == 'parcel_boundry'){
					zoomToPlayer('parcel_boundry');					
				}else{			   
					zoomToLayerExtent($(this).attr("id"));
				}
			});



        </script>
		
		<script type="text/javascript">
		/*$(document).ready(function () {
		baseUrl = 'http://182.74.36.11/hoori/';
		setTimeout(function ()
		{
			$('.alert').hide('slow');
		}, 4000);
		});*/

	

		function sidemenu() {
			var x = document.getElementById("ularea");
			if (x.style.display === "none") {
			x.style.display = "block";
			} else {
			x.style.display = "none";
			}
		}

		function getDistrict() {
			var state_id = $('#state_id').val();
			if(state_id != ''){
			$.ajax({
			url: 'getDistrict',
			type: 'GET',
			data: {'state_id': state_id},
			success:function(data)
			{
			$('#district_id').html(data);
			}
			});
			
			
			 $.ajax({
				url:'getStatePoint',
				method:"GET",
				dataType: 'json',
				data: {'state_id': state_id},
				success:function(data)
				{					
					data_response = JSON.stringify(data.plot_point_data);
					parse_data_response = JSON.parse(data_response);
					var minx = parse_data_response.st_xmin;
					var miny = parse_data_response.st_ymin;
					var maxx = parse_data_response.st_xmax;
					var maxy = parse_data_response.st_ymax;

					setExtent(minx,miny,maxx,maxy);
				}
			   });

			updateFilter('state_layer', 'state_id', state_id);
			updateFilter('district_layer', 'state_id', state_id);

		}
		else { $('#district_id').html('<option value="">Select District</option>');}	
		
		}

		function getBlock() {
			var district_id = $('#district_id').val();
			if(district_id != ''){
			$.ajax({
			url: 'getBlock',
			type: 'GET',
			data: {'district_id': district_id},
			success:function(data)
			{
			$('#block_id').html(data);
			}
			});
			
			 $.ajax({
				url:'getDistrictPoint',
				method:"GET",
				dataType: 'json',
				data: {'district_id': district_id},
				success:function(data)
				{					
					data_response = JSON.stringify(data.plot_point_data);
					parse_data_response = JSON.parse(data_response);
					var minx = parse_data_response.st_xmin;
					var miny = parse_data_response.st_ymin;
					var maxx = parse_data_response.st_xmax;
					var maxy = parse_data_response.st_ymax;

					setExtent(minx,miny,maxx,maxy);
					updateFilter('district_layer', 'district_id', district_id);	
				}
			   }); 


			}
			else { $('#block_id').html('<option value="">Select Block</option>');}	

		}

		function getVillage() {
			var block_id = $('#block_id').val();
			if(block_id != ''){
			$.ajax({
			url: 'getVillage',
			type: 'GET',
			data: {'block_id': block_id},
			success:function(data)
			{
			$('#village_id').html(data);
			}
			});
			}
			else { $('#village_id').html('<option value="">Select village</option>');}
		}
		
		function getSurveyPlot(ths) {
			var village_id = $('#village_id').val();
			var state_id = $('#state_id').val();
			
				if(village_id != ''){
					$.ajax({
					url: 'getSurveyNo',
					type: 'GET',
					data: {'village_id': village_id},
					success:function(data)
					{
					$('#survey_id').html(data);
					}
				});
			
				updateFilter('district_layer', 'state_id', state_id);
				updateFilter('parcel_boundry', 'village_id', village_id);

                zoomToVillage(village_id);				
			}
			else { $('#survey_id').html('<option value="">Select Survey No</option>');}
						      		
		}
		
		function getSurveyPlotJson() {
			var survey_id = $('#survey_id').val();
			if(survey_id != ''){			
			 $.ajax({
				url:'get-serveyno-json',
				method:"GET",
				dataType: 'json',
				data:{"survey_id":survey_id},
				success:function(data)
				{
					data_response = JSON.stringify(data.plot_data);
					parse_data_response = JSON.parse(data_response);
					var minx = parse_data_response.st_xmin;
					var miny = parse_data_response.st_ymin;
					var maxx = parse_data_response.st_xmax;
					var maxy = parse_data_response.st_ymax;

					setExtent(minx,miny,maxx,maxy);
					//selectPlot(survey_id);
					
				}
			   }); 
				selectPlotSearch(survey_id);

			}
		}
		 

		</script>
		

		{{ HTML::script('assets/js/measure.js') }}
		
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		
        <!--end::Page Scripts -->
    </body>

    <!-- end::Body -->
</html>