function numberFormat(n) {
	return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}	

var styleM = function(feature, resolution) {
	return new ol.style.Style({
	fill: new ol.style.Fill({
	color: 'rgba(255, 255, 255, 0.2)'
	}),
	stroke: new ol.style.Stroke({
	color: '#0080ff',
	width: 3
	}),
	image: new ol.style.Circle({
	radius: 7,
	stroke: new ol.style.Stroke({
		color: 'rgba(0, 0, 0, 0.7)'
	}),			
	fill: new ol.style.Fill({
	  color: '#ffcc33'
	})
	})
	});
}

var source = new ol.source.Vector({wrapX: false});
var mpointsrc = new ol.source.Vector({wrapX: false});	
var mlengthsrc = new ol.source.Vector({wrapX: false});	
var mareasrc = new ol.source.Vector({wrapX: false});

var mlengthlyr = new ol.layer.Vector({
name:'mlengthlyr',				
source: mlengthsrc,
style: styleM
});	
var marealyr = new ol.layer.Vector({
name : 'marealyr',	
source: mareasrc,
style: styleM
});
map.addLayer(mlengthlyr);
map.addLayer(marealyr);
//=============================MEASURE===================================
	var geodesicCheckbox = true;//document.getElementById('geodesic');	
	var draw; // global so we can remove it later
	var listener;
	var wgs84Sphere = new ol.Sphere(6378137);
	var result = 0;
	var cnt = 1;
	var output;
	var measuretype=null;
	var featureID = 0;	
	var sketch;
	var helpTooltipElement='';
	var helpTooltip='';
	var measureTooltipElement='';
	var measureTooltip='';
	var continuePolygonMsg;
	var continueLineMsg;	
    var helpMsg;
    var totalMFeatureCnt = 0;	
	var layerMId;
	
    var pointerMoveHandler = function(evt) {
        if (evt.dragging) {
          return;
        }
        /** @type {string} */
        if (sketch) {
          var geom = (sketch.getGeometry());
          if (geom instanceof ol.geom.Polygon) {
            helpMsg = continuePolygonMsg;
          } else if (geom instanceof ol.geom.LineString) {
            helpMsg = continueLineMsg;
          } else if (geom instanceof ol.geom.Point) {
            helpMsg = continueLineMsg;
          }		  
        }

        helpTooltipElement.innerHTML = helpMsg;
        helpTooltip.setPosition(evt.coordinate);

        $(helpTooltipElement).removeClass('hidden');
    };
	
	var formatLength = function(line) {
        var length;
        if (geodesicCheckbox.checked) {
          var coordinates = line.getCoordinates();
          length = 0;
          var sourceProj = map.getView().getProjection();

          for (var i = 0, ii = coordinates.length - 1; i < ii; ++i) {
            var c1 = ol.proj.transform(coordinates[i], sourceProj, 'EPSG:4326');
            var c2 = ol.proj.transform(coordinates[i + 1], sourceProj, 'EPSG:4326');
            length += wgs84Sphere.haversineDistance(c1, c2);
          }
        } else {
          length = Math.round(line.getLength() * 100) / 100;
        }
        output = 0;
        if (length > 100) {
          output = (Math.round(length / 1000 * 100) / 100) +
              ' ' + 'km';
        } else {
          output = (Math.round(length * 100) / 100) +
              ' ' + 'm';
        }
        return output;
    };
	
    var formatArea = function(polygon) {
        var area;
        if (geodesicCheckbox.checked) {
          var sourceProj = map.getView().getProjection();
          var geom = /** @type {ol.geom.Polygon} */(polygon.clone().transform(
              sourceProj, 'EPSG:4326'));
          var coordinates = geom.getLinearRing(0).getCoordinates();
          area = Math.abs(wgs84Sphere.geodesicArea(coordinates));
        } else {
          area = polygon.getArea();
        }
        output = 0;
        if (area > 10000) {
          output = (Math.round(area / 1000000 * 100) / 100) +
              ' ' + 'km<sup>2</sup>';
        } else {
          output = (Math.round(area * 100) / 100) +
              ' ' + 'm<sup>2</sup>';
        }
        return output;
    };
	
	function removeTip(id){
		helpMsg = '';
		var i = 0;
		map.getOverlays().getArray().slice(0).forEach(function(overlay) {
			i = overlay.get('id');
			if(id == 'all' || id==i )
			map.removeOverlay(overlay);
		});		
	}

	function createHelpTooltip() {
		if (helpTooltipElement) {
		  //map.removeOverlay(helpTooltip);	
		  helpTooltipElement.parentNode.removeChild(helpTooltipElement);
		}
		helpTooltipElement = document.createElement('div');
		helpTooltipElement.className = 'measuretip';
		helpTooltip = new ol.Overlay({
		  element: helpTooltipElement,
		  offset: [15, 0],
		  positioning: 'center-left'
		});
		map.addOverlay(helpTooltip);
		if(helpMsg)
		helpTooltipElement.style.display='';
		else
		helpTooltipElement.style.display='none';			
	}		
	
	function createMeasureTooltip() {
		if (measureTooltipElement) {
		  measureTooltipElement.parentNode.removeChild(measureTooltipElement);
		}
		measureTooltipElement = document.createElement('div');
		measureTooltipElement.className = 'measuretip tooltip-measure';
		measureTooltip = new ol.Overlay({
		  element: measureTooltipElement,
		  offset: [0, -15],
		  positioning: 'bottom-center'
		});
		map.addOverlay(measureTooltip);
	}
	
	function clearMeasure(){
		map.removeInteraction(draw);
		removeTip('all');
		mareasrc.clear();
		mlengthsrc.clear();		
		cnt = 1;
		clearMeasureTable();
	}
	
	function clearMeasureTable(){ // Reformats Odd Even Color for Measure Table
		i=1;
		$("#measure-length tbody tr").each(function(){
		$(this).remove();
		})
		i=1;
		$("#measure-area tbody tr").each(function(){
		$(this).remove();
		})		
	}
		
	var measureSelect;
	function measure(vl){
		$("#dialog_measure").dialog({close: clearMeasure});	
		clearTools();
		var type = 'measure'; //$('#measure-action').val();
		var mfeature = vl;

		layerMId = (mfeature == 'area' ? 'mareasrc' : (mfeature == 'length' ? 'mlengthsrc':'mpointsrc'));	
		var areaLayers = (mfeature == 'area' ? marealyr : (mfeature == 'length' ? mlengthlyr:mpointlyr));			
			
		if(!type || !mfeature){
			  helpMsg = null;
			  createHelpTooltip();
			  measureTooltipElement = null;
			  createMeasureTooltip();
			  clearMeasureTable();
			  measureSelect.getFeatures().clear();
			return;
		}

		
		var geom = mfeature;
		measuretype = geom;
	
		continuePolygonMsg = 'Click To Continue Measuring';
		continueLineMsg = 'Click To Continue Measuring';	
		helpMsg = 'Click To Start Measuring';		

		$('#measure-'+measuretype).show();
		map.on('pointermove', pointerMoveHandler);

	
		//$('#measure-'+measuretype+' > tbody:last').children().remove();	
		
		var type = (measuretype == 'area' ? 'Polygon' : (measuretype == 'length' ? 'LineString':'Point'));
		var sourceT = (measuretype == 'area' ? mareasrc : (measuretype == 'length' ? mlengthsrc:mpointsrc));
		var layerT = (measuretype == 'area' ? 'marealyr' : (measuretype == 'length' ? 'mlengthlyr':'mpointlyr'));		
		
		draw = new ol.interaction.Draw({
		  source: sourceT,
		  type: /** @type {ol.geom.GeometryType} */ (type),
		  style: new ol.style.Style({
			fill: new ol.style.Fill({
			  color: 'rgba(255, 255, 255, 0.2)'
			}),
			stroke: new ol.style.Stroke({
			  color: 'rgba(0, 0, 0, 1)',
			  lineDash: [10, 10],
			  width: 3
			}),
			image: new ol.style.Circle({
			  radius: 5,
			  stroke: new ol.style.Stroke({
				color: 'rgba(0, 0, 0, 0.7)'
			  }),
			  fill: new ol.style.Fill({
				color: 'rgba(255, 255, 255, 0.2)'
			  })
			})
		})
		});
		
		map.addInteraction(draw);
		createMeasureTooltip();
        createHelpTooltip();		

		draw.on('drawstart', function(evt) {
			// set sketch
			sketch = evt.feature;

			/** @type {ol.Coordinate|undefined} */
			var tooltipCoord = evt.coordinate;
			
			if(measuretype=='point'){
				geom = sketch.getGeometry();
				tooltipCoord = geom.getLastCoordinate();
				var sourceProj = map.getView().getProjection();
				var cord = ol.proj.transform(tooltipCoord, sourceProj, 'EPSG:4326');
				output = cord[0]+ " "+ cord[1];
				measureTooltipElement.innerHTML = '<b>'+cnt + '</b>';
				measureTooltipElement.id = 'tip'+layerT+cnt;
				$('#tip'+layerT+cnt).attr('rel','tip'+layerT);
				measureTooltip.setProperties({
					'id': cnt,
				});				
				measureTooltip.setPosition(tooltipCoord);
				return;	
			}

			listener = sketch.getGeometry().on('change', function(evt) {
			var geom = evt.target;

			if (geom instanceof ol.geom.Polygon) {
			output = formatArea(/** @type {ol.geom.Polygon} */ (geom));
			tooltipCoord = geom.getInteriorPoint().getCoordinates();
			} else if (geom instanceof ol.geom.LineString) {
			output = formatLength(/** @type {ol.geom.LineString} */ (geom));
			tooltipCoord = geom.getLastCoordinate();
			}
			//document.getElementById('output').innerHTML = output;
			var res = output.split(" "); 
			measureTooltipElement.innerHTML = '<b>'+cnt + '</b>: ' + numberFormat(parseFloat(output))+' '+res[1];
			measureTooltipElement.id = 'tip'+layerT+cnt;
			$('#tip'+layerT+cnt).attr('rel','tip'+layerT);
			measureTooltip.setProperties({
				'id': cnt,
			});		
            measureTooltip.setPosition(tooltipCoord);
			});
		}, this);
		
        draw.on('drawend', function(evt) {

              measureTooltipElement.className = 'measuretip tooltip-static';
              measureTooltip.setOffset([0, -7]);
              // unset sketch
              sketch = null;
              // unset tooltip so that a new one can be created
              measureTooltipElement = null;
              createMeasureTooltip();
			  
			  featureID = featureID + 1;
			  evt.feature.setProperties({
					'id': featureID,
			  })
			  
			  var coord = evt.feature.getGeometry().getCoordinates();
			  //alert(coord);			  
			  
			  totalMFeatureCnt++;
			  //$('#measurements').show();
			  //$('#'+layerMId).show(); 	

			  var res = output.split(" "); 	
              var clss = ((cnt % 2 == 0)? 'even':'odd');			  

			  if(measuretype=='length' || measuretype=='area'){
				//ol.Observable.unByKey(listener);
				result = parseFloat(result + parseFloat(output));				  
				$('#measure-'+measuretype+' > tbody:last-child').append('<tr class="'+clss+'" name="m-tr-'+cnt+'"><td>'+cnt+': </td><td>'+numberFormat(parseFloat(output))+' '+res[1]+'</td></tr>');
				evt.feature.setProperties({
					'name': numberFormat(parseFloat(output))+' '+res[1],
				})			  
			  }		  
			  cnt++;
        }, this);
			
			$('.india_number_format').autoNumeric('update');
	
	}
	function clearTools(){
		map.removeInteraction(draw);	
		map.removeInteraction(select);	
		map.removeInteraction(measureSelect);		
		removeTip('all');
	}