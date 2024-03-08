		{{ HTML::style('assets/css/ol.css') }}
		{{ HTML::style('assets/css/vector.css') }}

		<style>
		.pace.pace-active {
    display: none;
}
@media print {
 
    body * {
    visibility: visible;
  }

  #content, #content * {
    visibility: visible;
  }
  #content {
     position:absolute;
         width:300px;
		 height:300px;
         z-index:15;
         top:2%;
         left:5%;
        /* margin:-150px 0 0 -150px;*/
  }
 
@page :first .logo { display:block; } 
@page :first {
  margin-left: 50%;
  margin-top: 50%;
}
/*.logo { display:none; }*/
  #header{
	        margin-top:19px;
			 margin-left:19px;
  
  }
	#noprint { 
		display:none;
	} 
	#topbar { 
		display:none;
	} 
	.site-nav { 
		display:none;
	} 
	#footer { 
		display:none;
	} 
	.form-group { 
		display:none;
	}
	.responsive-menu-toggle { 
		display:none;
	}
	.panel-title{
      font-weight:600 !important;
	}	
	.print_title{
		display:block !important;
		margin-top:10px;
		font-size:20px;
	}
	 a[href]:after {
    content: none !important;
  }
  /* html, body {
    width: 210mm;
    height: 297mm;
  }*/
 
@page { size: auto;  margin: 0mm; }

}

</style>
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->survey->all();
}
?>
<div>{!! Session::get('message')!!}</div><button id="noprint" class="btn btn-info" onclick="printView()">Print</button>
<div id="printdiv" >
                    <div style="text-align:center">
                        <h4 class="panel-title" style="text-align:center;margin-top:5px"><span id="print_title" class="print_title" style="display:none;"></span></h4>
                    </div>

	 <div id="map_data_view" class="panel panel-primary  toggle panelMove panelClose panelRefresh" style="display:block">
                <!-- col-lg-12 start here -->
                <div class="panel panel-primary">
                    <!-- Start .panel -->
                    <div class="panel-heading">
                        <h4 class="panel-title" >Map View</h4>
                    </div>
					<?php if (!empty($surveyLists)) { ?>	
					
                    <div class="panel-body">
                      <div id="map" style="height:400px"><div id="info"></div></div> 
										<div id="mouse-position"></div>
										<div id="progress"></div>
											<div id="popup" class="ol-popup">
												<a href="javascript:void(0);" id="popup-closer" class="ol-popup-closer"></a>
													<div id="popup-content"></div>
											</div>
											<div id="village-popup" class="village-popup">											
												<div id="village-popup-content"></div>
											</div>	
                      
                    </div>
					<?php }else{ ?>
                      <div style="height:200px"><div style="margin-top:70px;text-align:center;">Survey Plot Not Mapped with Registration No</div></div> 
					<?php } ?>

                </div>
                <!-- End .panel -->
 
    </div>
<!-- Registration details --->
	<?php if (!empty($reg_data)) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Registration Details</h4>
        </div>
        <div class="panel panel-primary ">
            <!-- Start .panel -->
            <div class="panel-body">
                <table class="table  table-bordered">
                    <tbody>
                        <tr>
                            <td  class="text-center" width="30%"><strong>Unique Identification No</strong></td>
                            <td  class="text-center"><?= $reg_data['id'] ?></td>

                            <td  class="text-center"><strong>Legal Entity</strong></td>
                            <td  class="text-center">
                                <?php
                                $legal_entity = $reg_data['legal_entity'];
                                $legal_entity_name = App\Models\Common\CodeModel::where(['id' => "$legal_entity", 'cd_type' => 'legal_entity'])->value('cd_desc');
                                echo $legal_entity_name;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Purchase Type</strong></td>
                            <td  class="text-center">
                                <?php
                                $purchase_type = $reg_data['purchase_type_id'];
                                $purchase_type_name = App\Models\Common\CodeModel::where(['id' => "$purchase_type", 'cd_type' => 'purchase_type'])->value('cd_desc');
                                echo $purchase_type_name;
                                ?>
                            </td>

                            <td  class="text-center"><strong>Name of the Purchaser</strong></td>
                            <td  class="text-center"><?php
                                //$reg_data['purchaser']

                                $purchaser_name = $reg_data['purchaser'];
                                $purchaser_name = App\Models\Common\CodeModel::where(['id' => "$purchaser_name", 'cd_type' => 'purchaser_name'])->value('cd_desc');
                                echo $purchaser_name;
                                ?></td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Purchasing Team</strong></td>
                            <td  class="text-center">
                                <?php
                                $purchase_team = $reg_data['purchasing_team_id'];
                                $purchase_team_name = App\Models\Common\CodeModel::where(['id' => "$purchase_team", 'cd_type' => 'purchasing_team'])->value('cd_desc');
                                echo $purchase_team_name;
                                ?>
                            </td>

                            <td  class="text-center"><strong>Plot Type</strong></td>
                            <td  class="text-center">
                                <?php
                                $plot_type = $reg_data['plot_type_id'];
                                $plot_type_name = App\Models\Common\CodeModel::where(['id' => "$plot_type", 'cd_type' => 'plot_type'])->value('cd_desc');
                                echo $plot_type_name;
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Document Regn No</strong></td>
                            <td  class="text-center"><?= $reg_data['regn_no'] ?></td>

                            <td  class="text-center"><strong>Regn Date</strong></td>
                            <td  class="text-center"><?php echo (($reg_data['regn_date'])? date('d/m/Y',strtotime($reg_data['regn_date'])):''); ?></td>
							
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Sub Registrar Office</strong></td>
                            <td  class="text-center"><?php
                                $sub_registrar_code = $reg_data['sub_registrar'];
                                echo $sub_registrar_name = App\Models\Common\CodeModel::where(['id' => "$sub_registrar_code", 'cd_type' => 'sub_registrar_office'])->value('cd_desc');
                                ?></td>

                            <td  class="text-center"><strong>Name of Vendor</strong></td>
                            <td  class="text-center"><?= $reg_data['vendor'] ?></td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Purchased Area</strong></td>
                            <td  class="text-center">
                                <?php
                                $unit = $reg_data['tot_area_unit'];
                                $unit_name = App\Models\Common\CodeModel::where(['id' => "$unit", 'cd_type' => 'area_unit'])->value('cd_desc');
                                echo $reg_data['tot_area'] . ' (' . $unit_name . ')';
                                ?> 
                            </td>

                            <td  class="text-center"><strong>Total Cost</strong></td>
                            <td  class="text-center"><?= number_format($reg_data['tot_cost']) ?></td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>State</strong></td>
                            <td  class="text-center">
                                <?php
                                $state_id = trim($reg_data['state_id']);
                                echo $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name');
                                ?>
                            </td>

                            <td  class="text-center"><strong>District</strong></td>
                            <td  class="text-center">
                                <?php
                                $dist_id = trim($reg_data['district_id']);
                                echo $state_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td  class="text-center"><strong>Block/Taluk</strong></td>
                            <td  class="text-center">
                                <?php
                                $block_id = trim($reg_data['block_id']);
                                echo $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name');
                                ?>
                            </td>

                            <td  class="text-center"><strong>Village</strong></td>
                            <td  class="text-center">  <?php
                                $village_id = trim($reg_data['village_id']);
                                echo $village_name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name');
                                ?>

                            </td>
                        </tr>

                    </tbody>
                </table>
               
            </div>
        </div>
    </div>


<?php } ?>
<!-- Registration Details --->
<!-- family tree-->
			<?php if (!empty($familyLists)) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Family Member List</h4>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Name</th>
                        <th  class="text-center">Gender</th>
                        <th  class="text-center">Contact Number</th>
                        <th  class="text-center">Religion</th>
                        <th  class="text-center">Occupation</th>
                        <th  class="text-center">Qulaification</th>
                        <th  class="text-center">Identification Marks</th>
                        <th  class="text-center">Blood Group</th>
                        <th  class="text-center">Present Address</th>
                        <th  class="text-center">Permanent Address</th>
                        <th  class="text-center">Photo</th> 
						
                        <?php if (!$viewMode) { ?><th  class="text-center"></th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($familyLists) {
                        foreach ($familyLists as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><?= isset($value['member_name'])  ? $value['member_name'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['gender'])  ? $value['gender'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['contact_number'])  ? $value['contact_number'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['religion'])  ? $value['religion'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['occupation'])  ? $value['occupation'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['qulaification'])  ? $value['qulaification'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['identification_marks'])  ? $value['identification_marks'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['blood_group'])  ? $value['blood_group'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['present_address'])  ? $value['present_address'] : '' ?></td>
                                <td  class="text-center"><?= isset($value['permanent_address'])  ? $value['permanent_address'] : '' ?></td>
							    <td  class="text-center">
                                            <?php
                                            $file_path = str_replace('\\', '/', $value['path']);
                                            $file_name = stristr($file_path, '/');
                                            $file_type = $value['file_type'];
                                            if (file_exists($file_path)) {
                                                if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg') {
                                                    $id = 'myModal' . $key;													
                                                    ?>													
                                                    <a class="photo-link" data-toggle="modal" data-target="#<?= $id ?>">
														<img src="<?= url($file_path) . '?viewMode=' . $viewMode ?>" type="image/<?= $file_type ?>" width="80">							
													</a>
                                                    <div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                                    </button>
                                                                    <h4 class="modal-title" id="myModalLabel2"><?= $value['member_name'] ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>
																			<img src="<?= url($file_path) . '?viewMode=' . $viewMode ?>" type="image/<?= $file_type ?>">
                                                                    </p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else {?>
												No Photo Found
                                               <?php }
                                            } else {
                                                ?>
                                                No Photo Found
                                            <?php } ?>
                                        </td>
                                <?php if (!$viewMode) { ?>
                                    <td  class="text-center">
                                        <div class="action-buttons">                                          
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('family_tree_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>                                            
                                                <a title="Edit" href="<?= url('land-details-entry/family-tree/edit?reg_uniq_no=' . $reg_uniq_no . '&id=' . $value['id']); ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                            &nbsp;&nbsp;
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('family_tree_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>   
                                                <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $reg_uniq_no ?>', '<?= $value['id'] ?>');">
                                                    <i class="ace-icon fa fa-times bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                <?php } ?>
								
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>           
            </table>          
        </div>
    </div>


<?php } ?>

<!---- survey plot ----->
	<?php if (!empty($surveyPlotData)) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Survey List</h4>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Survey No</th>
                        <th  class="text-center">Area Unit</th>
                        <th  class="text-center">Extend</th>
                        <th  class="text-center">Total Purchased Area</th>
                        <th  class="text-center">Classification</th>                           
                        <th  class="text-center">Sub Classification</th>                           
                        <th  class="text-center">Purpose</th>
                        <?php if (!$viewMode) { ?><th  class="text-center"></th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($surveyPlotData) {
                        $cumilativeTotalArea = '';
                        $cumilativePurchaseArea = '';
                        foreach ($surveyPlotData as $key => $value) {
                            ?>
                            <tr>
                                <td  class="text-center"><?= $value['survey_no'] ?></td>
                                <td  class="text-center">
                                    <?php
                                    $area_unit = trim($value['area_unit']);
                                    echo $area_unit_name = App\Models\Common\CodeModel::where(['id' => "$area_unit"])->value('cd_desc');
                                    ?>
                                </td>
                                <td style="text-align: right;" class="all_total_area"><?php
                                    $cumilativeTotalArea = $cumilativeTotalArea + $value['total_area'];
                                    echo number_format($value['total_area'], 4, '.', '');
                                    ?></td>
                                <td style="text-align: right;" class="all_total_area"><?php
                                    $cumilativePurchaseArea = $cumilativePurchaseArea + $value['purchased_area'];
                                    echo number_format($value['purchased_area'], 4, '.', '');

                                    ?></td>
                                <td  class="text-center">
                                    <?php
                                    $classification = trim($value['classification']);
                                    echo $classification_name = App\Models\Common\CodeModel::where(['id' => "$classification"])->value('cd_desc');
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    $sub_classification = trim($value['sub_classification']);
                                    echo $sub_classification_name = App\Models\Common\SubClassificationModel::where(['id' => "$sub_classification"])->value('sub_name');
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php
                                    $purpose = trim($value['purpose']);
                                    echo $purpose_name = App\Models\Common\CodeModel::where(['id' => "$purpose"])->value('cd_desc');
                                    ?>
                                </td>
                                <?php if (!$viewMode) { ?>
                                    <td  class="text-center">
                                        <div class="action-buttons">                                          
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('survey_no_details_edit', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>                                            
                                                <a title="Edit" href="<?= url('land-details-entry/survey/edit?reg_uniq_no=' . $reg_uniq_no . '&survey_no=' . $value['id']); ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                            &nbsp;&nbsp;
                                            <?php
                                            if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('survey_no_details_delete', $current_user_id) && \App\Models\UtilityModel::ifHasPermission('registration_access', $current_user_id))) {
                                                ?>   
                                                <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $reg_uniq_no ?>', '<?= $value['id'] ?>');">
                                                    <i class="ace-icon fa fa-times bigger-130"></i>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
                <thead>
                    <tr>
                        <th  class="text-center">Total</th>
                        <th  class="text-center"></th>
                        <th class="text-right all_total_area"><?= $cumilativeTotalArea ?></th>
                        <!--<th  class="text-center">Unit</th>-->
                        <th class="text-right all_total_cost"><?= $cumilativePurchaseArea ?></th>
                        <th  class="text-center"></th>                           
                        <th  class="text-center"></th>
                        <th  class="text-center"></th>
                        <?php if (!$viewMode) { ?><th  class="text-center"></th><?php } ?>
                    </tr>
                </thead>

            </table>

            <?php if ($viewMode) { ?>    
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <a href="<?= url('land-details-entry/registration/list') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


<?php } ?>
</div>
			<!-- family tree-->
		{{ HTML::script('assets/js/jquery-2.1.1.min.js') }}
		{{ HTML::script('assets/js/ol.js') }}


<script>
		var select, selectFeatureClick;
		var draw;
		var container = document.getElementById('popup');
		var content = document.getElementById('popup-content');
		var closer = document.getElementById('popup-closer');
		var osm = new ol.layer.Tile({
			title: 'OSM Standard',
			name: 'osmMap',
			source: new ol.source.OSM(),
			visible: false
		});

		var bingLayer = new ol.layer.Tile({
			name: 'bingLayer',
			preload: Infinity,
			visible: true,
			source: new ol.source.BingMaps({
				key: 'As1PsQi-MQ8I4ziLMIa_KHmzlmP4gG9KLoWaFuoF0Aj4DixiotNvmvQfLdfC1OHv',
				imagerySet: 'AerialWithLabels'

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
	
		

var parcel_boundry_url = '<?php echo URL("land-details-entry/survey-lat-long/jsonView/");?>/<?= $reg_uniq_no ?>';
var parcel_boundry  = new ol.layer.Vector({
	name : 'parcel_boundry ',
	source: new ol.source.Vector({
			url: parcel_boundry_url,
			format: new ol.format.GeoJSON({
			defaultDataProjection :'EPSG:4326',
			projection: 'EPSG:3857'
		})
	}),
	style: function (feature, resolution){		
	var style = new ol.style.Style({
		fill: new ol.style.Fill({
			color: 'transparent',
		}),			
		stroke: new ol.style.Stroke({
			color: 'yellow',
			width: 2
		}),
		text : new ol.style.Text({
			fill: new ol.style.Fill({
			  color: 'white'
			}),				
			stroke: new ol.style.Stroke({
				color: 'rgba(0, 0, 0, 0.5)',
				width: 3
			}),
			font : 'Normal 12px Arial',
			text : feature.get('survey_no'),

		})		
		});		
		if(map.getView().getZoom() > 10){
		return style;
		}	
	},
	visible: true
});

		var plotselect = new ol.layer.Vector({
			name: 'plotselect',
			style: function (feature, resolution) {
				var style = new ol.style.Style({
					fill: new ol.style.Fill({
						color: 'rgba(255, 255, 255, 0.3)',
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

var plot_display = function(feature, resolution) {
	if(map.getView().getZoom() > 15){
	var plot_display_text = feature.get('surveyno');
	return plot_display_text;
	}
};		
		var map = new ol.Map({
			controls: ol.control.defaults({attribution: false}).extend([
				new ol.control.ScaleLine(),
				mousePositionControl
			]),
			//interactions: olgm.interaction.defaults(),
			layers: [
				bingLayer, parcel_boundry
			],
			target: 'map',
			view: new ol.View({
				maxZoom: 19,
				minZoom: 5,
				zoom: 19
			})
		});

		/*var select = new ol.interaction.Select({
		 layers: [plot]
		 });
		 map.addInteraction(select);*/

		//setExtent(43.6162575, 3.0761851, 43.6951488, 3.1635315);
		
		
		setExtent(79.1481880078317,11.0370178286936,79.1892604466139,11.1479852352532);
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
		function printMap() {
			var filename = prompt("Please enter file name", "Map");
			if (!filename)
				return;
			map.once('postcompose', function (event) {
				var canvas = event.context.canvas;
				if (navigator.msSaveBlob) {
					navigator.msSaveBlob(canvas.msToBlob(), filename + '.png');
				} else {
					canvas.toBlob(function (blob) {
						saveAs(blob, filename + '.png');
					});
				}
			});
			map.renderSync();
		}
		function zoomIn() {
			map.getView().setZoom(map.getView().getZoom() + 1);
		}
		function zoomOut() {
			map.getView().setZoom(map.getView().getZoom() - 1);
		}
		
		$('.layer').click(function (index) {
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
					layers.item(i).setVisible(tf);
					break;
				}
			}
		}

	
        </script>
        <script>
		
	
           
          
            function zoomToLayerExtent(lyr) {
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
                        if (extent[0] != 'Infinity') {
                            map.beforeRender(pan);
                            map.getView().fit(extent, map.getSize(), {
                                padding: [10, 10, 10, 10],
                                constrainResolution: false
                            });
                            return;
                        }
                    }
                }
            }

         

	$(document).ready(function(){  
		$.ajax({
		url:'plotGeom',
		method:"GET",
		dataType: 'json',
		data:{"reg_uniq_no":'<?= $reg_uniq_no ?>'},
		success:function(data)
		{		
		data_response = JSON.stringify(data.plot_data.st_extent);
		var data_response = data_response.replace('BOX', '');
		var data_response = data_response.replace('(', '');
		var data_response = data_response.replace(')', '');		
		var data_response = data_response.replace(',', ' ');
		var data_response = data_response.replace('"', '');
		var data_response = data_response.replace('"', '');
		var data_response = data_response.split(" ");
if(data_response != null){	
		var minx = data_response[0];
		var miny = data_response[1];
		var maxx = data_response[2];
		var maxy = data_response[3];
		setExtent(minx,miny,maxx,maxy);
}
		}
		}); 
});

function printView()
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

</script>
		
		
{{ HTML::script('assets/js/measure.js') }}

