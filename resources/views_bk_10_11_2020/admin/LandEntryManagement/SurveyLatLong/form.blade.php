		{{ HTML::style('assets/css/ol.css') }}
		{{ HTML::style('assets/css/vector.css') }}

		<style>
		.pace.pace-active {
    display: none;
}
@media print {
  body * {
    visibility: hidden;
  }
  #content, #content * {
    visibility: visible;
  }
  #content {
    position: absolute;
    left: 0;
    top: 0;
  }
   #noprint { 
                    display:none;
               } 
}

</style>
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->survey->all();
}
?>
<div>{!! Session::get('message')!!}</div><button id="noprint"  class="btn btn-info"  onclick="window.print()">Print</button>
<div id="printdiv" >
	 <div id="map_data_view" class="panel panel-primary  toggle panelMove panelClose panelRefresh" style="display:block">
        <div class="row">
            <div class="col-lg-12">
                <!-- col-lg-12 start here -->
                <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
                    <!-- Start .panel -->
                    <div class="panel-heading">
                        <h4 class="panel-title">Map View</h4>
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
			
			
        </div>
    </div>


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

</script>
		
		
{{ HTML::script('assets/js/measure.js') }}

