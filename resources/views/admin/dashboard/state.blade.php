		{{ HTML::style('assets/css/ol.css') }}
		<!--<link rel="stylesheet" href="https://openlayers.org/en/v3.20.1/css/ol.css" type="text/css">-->
		{{ HTML::style('assets/css/vector.css') }}

<style>
.paging_full_numbers a.paginate_button {
    color: #fff !important;
	    
}
.paging_full_numbers a.paginate_active {
    color: #fff !important;
	
}
.paginate_button  {
 cursor: pointer;
}

button.dt-button, div.dt-button, a.dt-button {
     padding: 4px 8px !important;
}

/*.st-level{
	color: #23cf00;
    font-weight: bold;
}*/



.ol-popup-closer:after {
    content: "✖" !important;
}
.button_group .btn-group.pull-right{margin-bottom:10px;}

#progress {
	position: relative;
	bottom: 0;
	left: 0;
	height: 4px;
	background: rgba(0, 60, 136, 1);
	width: 0;
	transition: width 250ms;
}
.ol-popup {
	position: absolute;
	background-color: #F7F7F7;
	-webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
	filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
	padding: 15px;
	border-radius: 10px;
	border: 3px solid #2A3F54;
	bottom: 12px;
	left: -50px;
	min-width: 295px;
	box-shadow: 0 0 8px #2C557E;
  }
.ol-popup:after, .ol-popup:before {
	top: 100%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
	}
.ol-popup:after {
	border-top-color: white;
	border-width: 10px;
	border-top-color: #F7F7F7;
	left: 48px;
	margin-left: -10px;
	}
.ol-popup:before {
	border-top-color: #2A3F54 ;
	border-width: 14px;
	left: 48px;
	margin-left: -14px;
	}
.ol-popup-closer {
	text-decoration: none;
	position: absolute;
	top: 2px;
	right: 8px;
	}
.ol-popup-closer:after {
	content: "✖";
	}
#popup-content table td{
	color:#111;
	vertical-align:top;
	padding:2px 3px;
	font-size: 12px;
	}

#popup-content table td:first-child{
	white-space:nowrap;
	width: 165px;
	}

#popup-content table tr:last-child td:last-child{
	color:#111;
	}


#popup-content table tr:last-child td:last-child a{
	color:#111;
	padding-top:10px;
	display:inline-block;
	padding:1px 3.5px;
	background:#f6f6f6;
	border:1px solid #aaa;
	text-align: center;
	white-space: nowrap;
	}
#popup-content table tr:last-child td:last-child a:hover{
	background:#fff;
	}

.custom_button_div .dropdown-menu {
	left: -126px;
	}

.custom_list_on_map{
	position: absolute;
	z-index: 99999;
	background: #fff;
	right: 15px;
	width: 236px;
	border: 1px solid #D9DEE4;
	padding:5px;
	    overflow-y: auto;
    height: calc( 100vh - 181px );
	}
.custom_list_on_map table{
	margin-bottom:0 !important;	
}	
	
.select2-container .select2-selection--single {
    height: 34px;
}	
.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 4px;
}
/*.form_group_div{
	width:1100px;
	}*/
.form_group_div div{
	float:left;
	display:inline-block;
	width:135px;
	margin-right: 10px;
	}

/*.form_group_div select{
	width:160px;
	margin:0;
	}
*/
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
    line-height: 12px;
}
/*label {
    color: #ff3c3c !important;
}*/
.page-title .title_left {
    width: 100% !important;
    float: left;
    display: block;
}
.title_right {
    width: 20% !important;
    float: left;
    display: block;
}
.form-control {
    font-size: 13px !important;
}
.chosen-container-single .chosen-single {
    font-size: 13px !important;
	
}
.chosen-container {
    font-size: 13px !important;
}
.page-title .title_right .pull-right {
    margin-bottom: 5px;
}
.chosen-container.chosen-container-single {
    width: 100% !important; 
}
/*tr{
	border-top: 1px solid #ddd !important;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: none !important;
}*/
.page-title .title_right .pull-right {
    margin: 2px 0;
}
/*.col-xs-12, .col-sm-12, .col-md-12, .col-xl-12{
    position: relative;
    min-height: 1px;
    float: left;
    padding-right: 0px !important;
    padding-left: 0px !important;
}*/

input[type=checkbox] {
    position: relative !important;
    left: 0 !important;
    opacity: 1 !important;
}
.box-body {
    padding: 0 !important;
}
.table thead th {
    border-bottom: 1px solid #dee2e6 !important;
}
.legend-gap{
margin-left: 15px;	
}
.content {
    padding: 7px 30px 0px 30px;
}
.pace.pace-active {
    display: none;
}




@media print { 
	html, body {
	width: 1000px;
	height: auto;
	margin:30px 30px 30px 30px;
  }
  #tabletools1 {page-break-inside: avoid;}
  .flexContainer {
 display: flex;                  
  flex-direction: row;            
  flex-wrap: nowrap;              
  justify-content: space-between;
  }
.flexContainer div {
	width: 333px;
}
@page {margin-top: 30px; margin-bottom: 30px;}
}
</style>

<!-- .page-content -->
<div id="list_data_view"  style="display:block">
    <table id="tabletools1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th  class="text-center">State</th>
                            <th  class="text-center">Purchased Area (Acre)</th>
                            <th  class="text-center">Purchased Area (Hectare)</th>
                            <th  class="text-center">% of Total</th>
                            <th  class="text-center">Total Cost</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $grandTotalCost = 0;
                        $grandTotalAreaAcre = 0;
                        $grandTotalAreaHector = 0;
                        $allStateIds = '1';
						//t($states);
                        if (!empty($states) && count($states)>0) {

                            foreach ($states as $key => $value) {
                                if (isset($value['grand_total_tot_cost']) || isset($value['grand_total_tot_area_acer'])) {
                                    $grandTotalCost += $value['grand_total_tot_cost'];
                                    $grandTotalAreaAcre += $value['grand_total_tot_area_acer'];
                                    $grandTotalAreaHector += $value['grand_total_tot_area_hector'];
                                    $allStateIds = $allStateIds.','.$value['id'];
                                    ?>
                                    <tr>
                                        <td  class="text-left">
                                            <?php if ($filter == '') { ?>
                                                <span class="context-menu-one btn btn-neutral st-level" tag="<?= $value['id']; ?>"> <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?></span>
                                            <?php } elseif ($filter == 'District') { ?>
                                                <a href="<?= url('dashboard/district?state_id=' . $value['id'] . '&filter=District'); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                    <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?>
                                                </a>
                                            <?php } elseif ($filter == 'Block/Taluk') { ?>
                                                <a href="<?= url('dashboard/block?state_id=' . $value['id'] . '&filter=Block/Taluk'); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                    <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?>
                                                </a>
                                            <?php } elseif ($filter == 'Village') { ?>
                                                <a href="<?= url('dashboard/village?state_id=' . $value['id'] . '&filter=Village'); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                    <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?= url('dashboard/details?state_id=' . $value['id'] . '&filter=' . $filter); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                    <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_acer'] ?></td>
                                        <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_hector'] ?></td>
                                        <td class="all_percentage" style="text-align: right;"><?= (($grand_total_cost_all)?(($value['grand_total_tot_cost'] * 100) / $grand_total_cost_all):0); ?></td>
                                        <td style="text-align: right;" >
                                             <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i> &nbsp;
                                            <span class="all_total_cost custom_underline" onmouseover ="totalCostDistribution('<?= $value['id'];?>','','','','<?= $value['id'];?>')"><?= $value['grand_total_tot_cost'] ?>
                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>

                    </tbody>

                    <tfoot>
                        <tr>
                            <th  class="text-center">
                                <?php if (isset($filter) && $filter != '') { ?>
                                    <a href="<?= url('dashboard/totaldetails?filter=' . $filter); ?>" class="context-menu-one btn btn-neutral" style="color: #333333;">Total</a>
                                <?php } else { ?>
                                    <span class="context-menu-one btn btn-neutral"> Total</span>
                                <?php } ?>
                            </th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaAcre ?></th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaHector ?></th>
							<td class="all_percentage" style="text-align: right;">
                            <?php if ($grandTotalCost) { ?>
                                <?= (($grandTotalCost * 100) / $grand_total_cost_all); ?>
                            <?php } ?>
							</td>
                            <th style="text-align: right;">  
                                    <i class="fa fa-spinner fa-spin" id="total" style="font-size:24px;visibility: hidden"></i>&nbsp;
                                    <span class="all_total_cost custom_underline" onmouseover ="totalCostDistribution('<?= $allStateIds;?>','','','','total')"><?= $grandTotalCost ?>
                                    </span>
							</th>
                        </tr>
                    </tfoot>
                </table>
</div>
<br></br>
<div id="map_data_view"  style="display:block">
                    <div style="text-align:center">
                        <h4 class="panel-title" style="text-align:center;margin-top:5px"><span id="print_title" class="print_title" style="display:none;"></span></h4>
                    </div>				
				 <div id="map_data_view" class="panel panel-primary  toggle panelMove panelClose panelRefresh" style="display:block">
                <!-- col-lg-12 start here -->
                <div class="panel panel-primary">
                    <!-- Start .panel -->
                    <!--<div class="panel-heading">
                        <h4 class="panel-title" >State Map</h4>
                    </div>-->
					
                    <div class="panel-body">
					 <!--<button type="button" style="margin-left: 10px;margin-bottom: -14px;padding: 0px 7px !important;background-color:rgba(0,60,136,0.5) !important;" class="btn btn-primary" onclick="setExtent(67.9737167358398011,7.9312300682067898,97.5616378784179972,37.2809371948241974)">
                                            <span class="docs-tooltip" title="Initial Map View">
                                                <span class="fa fa-arrows-alt" style="font-size: 7px;"></span>
                                            </span>
                                        </button>-->
                      <div id="map" style="height:400px"><div id="info"></div></div>
					  
										<div id="mouse-position"></div>
										<div id="progress"></div>
											<div id="popup" class="ol-popup">
												<a href="javascript:void(0);" id="popup-closer" class="ol-popup-closer"></a>
													<div id="popup-content"></div>
											</div>
												
                      
                    </div>
					

                </div>
                <!-- End .panel -->
 
    </div>
</div>

		
               <!-- begin::Quick Panel -->
	<!--<script src="https://openlayers.org/en/v3.20.1/build/ol.js"></script>-->
		{{ HTML::script('assets/js/ol.js') }}
		{{ HTML::script('assets/plugins/forms/select2/select2.js') }}
		<!--{{ HTML::script('assets/js/jquery-2.1.1.min.js') }}-->


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
				imagerySet: 'Aerial',
				

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
		  //padding: [10, 10, 10, 10],
		  constrainResolution: false
		});
		return;
		}
	}
	}
}


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
	
	/////// ///////////////
	

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
		
		  

function getMaxPoly(polys) {
  var polyObj = [];
  //now need to find which one is the greater and so label only this
  for (var b = 0; b < polys.length; b++) {
    polyObj.push({ poly: polys[b], area: polys[b].getArea() });
  }
  polyObj.sort(function (a, b) { return a.area - b.area });

  return polyObj[polyObj.length - 1].poly;
}	

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(typeof haystack[i] == 'object') {
            if(arrayCompare(haystack[i], needle)) return true;
        } else {
            if(haystack[i] == needle) return true;
        }
    }
    return false;
}	
<?php
foreach ($states as $key => $value) {
	if (empty($value['grand_total_tot_area_acer'])) {
		unset($states[$key]);
	}
}

?>
var a = [<?php echo "'" . implode ( "', '", array_column($states, 'state_name') ) . "'"; ?>];	
var state_url = '<?php echo URL("dashboard/get_state_json");?>';
var state_layer = new ol.layer.Vector({
	name : 'state_layer',
	source: new ol.source.Vector({
			url: state_url,
			format: new ol.format.GeoJSON({
			defaultDataProjection :'EPSG:4326',
			projection: 'EPSG:3857'
		})
	}),
	style: function (feature, resolution) {
		var fill_color = 'rgba(0, 0, 0, 0)';
		if(inArray([feature.get('state_name')], a)) {
			fill_color = 'rgba(34,139,34, 0.8)';
		}else{
			fill_color = 'rgba(211,211,211, 0.8)';			
		}
		var polyStyleConfig = {
		  stroke: new ol.style.Stroke({
			color: 'orange',
			width: 2
		  }),
		  fill: new ol.style.Fill({
			color: fill_color
		  })
		}
		var textStyleConfig = {
		  text:new ol.style.Text({
			text:resolution < 100000 ? feature.get('state_name') : '' ,
			fill: new ol.style.Fill({ color: "#000000" }),
			stroke: new ol.style.Stroke({ color: "#FFFFFF", width: 2 })
		  }),
		  geometry: function(feature){
			var retPoint;
			if (feature.getGeometry().getType() === 'MultiPolygon') {
			  retPoint =  getMaxPoly(feature.getGeometry().getPolygons()).getInteriorPoint();
			} else if (feature.getGeometry().getType() === 'Polygon') {
			  retPoint = feature.getGeometry().getInteriorPoint();
			}
			console.log(retPoint)
			return retPoint;
		  }
		}
		var textStyle = new ol.style.Style(textStyleConfig);
		var style = new ol.style.Style(polyStyleConfig);
		return [style,textStyle];
	},
	visible: true

 }
 );
 
 
 
 // palnt location
 
	var plant_url = '<?php echo URL("dashboard/get_plant_json");?>';
	var plant_layer = new ol.layer.Vector({
	name : 'plant_layer',
	source: new ol.source.Vector({
			url: plant_url,
			format: new ol.format.GeoJSON({
			defaultDataProjection :'EPSG:4326',
			projection: 'EPSG:3857'
		})
	}),
	style: function (feature, resolution){		
			var style = new ol.style.Style({	
				image: new ol.style.Circle({
					radius: 7,
					fill: new ol.style.Fill({color: 'red'}),
					stroke: new ol.style.Stroke({
					  color: 'white', width: 3
					})
				}),
                text: new ol.style.Text({
                    fill: new ol.style.Fill({
                        color: 'white'
                    }),
                    stroke: new ol.style.Stroke({
                        color: 'rgba(0, 0, 0, 1)',
                        width: 2
                    }),
					offsetY: '21',
                    font: 'Normal 14px Arial',
					text: feature.get('id'),
                })
 	
		});	
		
		return style;

	},
	visible: true
});
		
	
		var map = new ol.Map({
			controls: ol.control.defaults({attribution: false,zoom : false,}).extend([
				new ol.control.ScaleLine()
			]),
			//interactions: olgm.interaction.defaults(),
			layers: [
				state_layer,plant_layer
			],
			target: 'map',
			view: new ol.View({
				maxZoom: 19,
	minZoom: 4,	
	//center: ol.proj.transform(center, 'EPSG:4326', 'EPSG:3857'),
	zoom: 15,
			})
		});

		
		
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
	

	
      /**
       * Handle change event.
       */
     
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
			
			
                map.addOverlay(plotTooltip);
                map.on('singleclick', function (evt) {
					var layerName = null;
					evt.preventDefault();
                    console.log(evt);
                    var coord = evt.coordinate;

                    var coordinate1 = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
					
					var feature = map.forEachFeatureAtPixel( evt.pixel, function ( feature, layer ) {
					if (layer) { 
					layerName = layer.get('name');
					}
					return feature;
					} );
					//alert(layerName);
					if( layerName== 'state_layer'){
					var state_name = feature.get('state_name');
						var url = '<?php echo URL("dashboard/get_state_info"); ?>';
						$.ajax({
						method: "get",
						url: url,
						data: {state_name: state_name},
						success: function (data, textStatus, jqXHR) {
							if (data) {
								var json = $.parseJSON(data); 
								$('#popup').show();
								var html = '<table width="100%">'+
								'<tbody><tr><td><b>State Name :</b></td>'+
								'<td>'+json.state_name+'</td></tr><tr><td><b>Purchased Area (Acre) :</b></td>'+
								'<td>'+json.grand_total_tot_area_acer+'</td></tr><tr><td><b>Purchased Area (Hectare) :</b></td>'+
								'<td>'+json.grand_total_tot_area_hector+'</td></tr><tr><td><b>Total Cost :</b></td>'+
								'<td>'+json.grand_total_cost_all+'</td></tr></tbody></table>';
								content.innerHTML = html; 
								plotTooltip.setPosition(coord);

							}
						}
						});
						}

                               /* $('#popup').show();
                                //var ret = data.split("|");
								var html = '<table width="100%">'+
							'<tbody><tr><td><b>State Name :</b></td>'+
							'<td>4</td></tr><tr><td><b>Purchased Area (Acre) :</b></td>'+
							'<td>5</td></tr><tr><td><b>Purchased Area (Hectare) :</b></td>'+
							'<td>6</td></tr><tr><td><b>Total Cost :</b></td>'+
							'<td>7</td></tr></tbody></table>';
                                content.innerHTML = html;
                                plotTooltip.setPosition(coord);
                               // selectPlot(1);*/
                           

                });
           
		    $("#shape_data").click(function(){
       $("#list_data_view").css("display","block");
       $("#map_data_view").css("display","none");
   });
     $("#map_data").click(function(){
       $("#list_data_view").css("display","none");
       $("#map_data_view").css("display","block");
	 });
	 $(function(){
    $("#map_data_view").hide();
   
});

		
        </script>

		{{ HTML::script('assets/js/measure.js') }}
		
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">