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

.st-level{
	color: #23cf00;
    font-weight: bold;
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
                        if ($states) {

                            foreach ($states as $key => $value) {
                                if ($value['grand_total_tot_cost'] || $value['grand_total_tot_area_acer']) {
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

<!--<br><br>
<div id="printdiv" >
                    <div style="text-align:center">
                        <h4 class="panel-title" style="text-align:center;margin-top:5px"><span id="print_title" class="print_title" style="display:none;"></span></h4>
                    </div>				
				 <div id="map_data_view" class="panel panel-primary  toggle panelMove panelClose panelRefresh" style="display:block">
               
                <div class="panel panel-primary">
                   
					
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
                
 
    </div>
</div>-->

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
	style: function (feature, resolution){
			var style = new ol.style.Style({
		fill: new ol.style.Fill({
			color: 'rgba(255, 255, 255, 0.1)',
		}),			
		stroke: new ol.style.Stroke({
			color: 'orange',
			width: 2
		}),
		text : new ol.style.Text({
			fill: new ol.style.Fill({
			  color: 'white'
			}),				
			stroke: new ol.style.Stroke({
				color: 'rgba(0, 0, 0, 1)',
				width: 3
			}),
			font : 'Normal 10px Arial',
			text : feature.get('state_name'),
		})		
		});
	//if(map.getView().getZoom() > 10){
		return style;
		//}	
	},
	visible: true

 }
 );
		
		
		

		
///



		var map = new ol.Map({
			controls: ol.control.defaults({attribution: false}).extend([
				new ol.control.ScaleLine(),
				mousePositionControl
			]),
			//interactions: olgm.interaction.defaults(),
			layers: [
				bingLayer,state_layer
			],
			target: 'map',
			view: new ol.View({
				maxZoom: 19,
				minZoom: 4,
				zoom: 19
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

        </script>
		
	
		{{ HTML::script('assets/js/measure.js') }}
