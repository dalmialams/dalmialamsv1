{{ HTML::style('assets/css/ol.css') }}
{{ HTML::style('assets/css/vector.css') }}	
<style>
.not-matched{
    color:red;	
}
.sorting:before {
    content: none !important;
}
table.table {
    margin-top: 0px !important;
}
.sorting_asc:before {
    content: none !important;
}
.read-mode{
 pointer-events: none;
    opacity: 0.4;	
}
.red-sign{
	text:align:center;
	color:red;
}
</style>

<div>{!! Session::get('message')!!}</div>

<!--<div style="margin-bottom: 8px;">
<button type="button" class="btn btn-success">Import Shape File</button>
<button type="button" class="btn btn-warning">Drop Shape File</button>
</div>-->

<div style="margin-bottom: 8px;text-align:left">
<button type="button" id="shape_data" class="btn btn-success">Shape Data</button>
<button type="button" id="map_data" class="btn btn-warning">Map View</button>

<a style="float:right" class="btn btn-primary" href="<?= url('document-management/document/railway-track') ?>">Shape Zip List</a>
</div>

    <div id="shape_data_view" class="panel panel-primary  toggle panelMove panelClose panelRefresh" style="display:block">
        <div class="row">
            <div class="col-lg-12">
                <!-- col-lg-12 start here -->
                <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
                    <!-- Start .panel -->
                    <div class="panel-heading">
                        <h4 class="panel-title">Shape Data List</h4>
                    </div>
                    <div class="panel-body">
						<table id="shape_data_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
						<?php 
						if(!empty($shpTables->plot_data[0])){						
						$column = $shpTables->plot_data[0];
						unset($column->geom); ?>
						<?php foreach($column as $ky=>$val) { ?>
						<th><?=$ky?></th>
						<?php }} ?>
						</tr>
						</thead>


						<tbody>
						
						<?php 
						if(!empty($shpTables->plot_data)){
						foreach($shpTables->plot_data as $ky=>$value) {																			
						?>
							<tr class="">
							   <?php foreach($column as $k=>$vl){?>
								 <td><?=$value->$k?></td>
							   <?php } ?>	
								 <!--<td><a href="<?=URL('document-management/document/edit-shp-single/'.$value->gid.'/'.$data_id)?>" class="btn btn-warning">Edit</a></td>-->
							</tr>
							   <?php } }else{ ?>
							<tr><td>No Data Found</td></tr>	
							   <?php } ?>					
						</tbody>	
						</table>
                      
                    </div>
                </div>
                <!-- End .panel -->
            </div>
        </div>
    </div>

    <div id="map_data_view" class="panel panel-primary  toggle panelMove panelClose panelRefresh" style="display:block">
        <div class="row">
            <div class="col-lg-12">
                <!-- col-lg-12 start here -->
                <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
                    <!-- Start .panel -->
                    <div class="panel-heading">
                        <h4 class="panel-title">Map View</h4>
                    </div>
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
                </div>
                <!-- End .panel -->
            </div>
        </div>
    </div>
	
	<?php 
	if(isset($imported) && $imported == 'N'){?>
	<div style="margin-bottom: 8px; text-align:right">
	<a class="btn btn-success" onclick="return confirm('Are you sure to import shape file?')" href="<?= url('document-management/document/importShp/'.$table_name.'/railway_track/'.$data_id) ?>"><i class="fa fa-external-link-square" aria-hidden="true"></i> Import Shape File</a>
	
	<a class="btn btn-info" onclick="return confirm('Are you sure to export shape file?')" href="<?= url('document-management/document/data-export-shp/'.$table_name.'/railway_track/'.$data_id) ?>"><i class="fa fa-external-link-square" aria-hidden="true"></i> Export Shape File</a>
	<!--<a class="btn btn-warning" onclick="return confirm('Are you sure to drop shape file?')" href="<?= url('document-management/document/shpDrop/'.$table_name.'/'.$data_id) ?>"><i class="fa fa-times-circle" aria-hidden="true"></i> Drop Shape File</a>-->
	</div>
	<?php } ?>
<br>
		{{ HTML::script('assets/js/jquery-2.1.1.min.js') }}
		{{ HTML::script('assets/js/ol.js') }}

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
	
		

var parcel_boundry_url = '<?php echo URL("document-management/document/shape-map-view/railway_track/");?>/<?= $table_name ?>';
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
			//text : feature.get('pls_plot_no'),
			text : plot_display(feature, resolution)

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
   $("#shape_data").click(function(){
       $("#shape_data_view").css("display","block");
       $("#map_data_view").css("display","none");
   });
   
   $("#shape_file_data").click(function(){
       $("#shape_data_view").css("display","none");
       $("#map_data_view").css("display","none");
   });
   
     $("#map_data").click(function(){
       $("#shape_data_view").css("display","none");
       $("#map_data_view").css("display","block");
	   	   
		$.ajax({
		url:'<?= url('document-management/document/getShpJson') ?>',
		method:"GET",
		dataType: 'json',
		data:{"table_name":'<?= $table_name ?>'},
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
		var minx = data_response[0];
		var miny = data_response[1];
		var maxx = data_response[2];
		var maxy = data_response[3];
		setExtent(minx,miny,maxx,maxy);
		}
		}); 
   });
});
$(function(){
    $("#map_data_view").hide();
   
});
  $(document).ready(function () {
        $('#shape_data_table').DataTable({
			"scrollX": true,
        });
		
    });
$('#shape_data_table tbody').on('mouseover', 'tr', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        html: true
    });
});
        </script>
		
		
  {{ HTML::script('assets/js/measure.js') }}