var googleLayer = new olgm.layer.Google({name:'Google'});
		var osm =  new ol.layer.Tile({
			name:'osm',
			source: new ol.source.OSM(),
			visible: false
		});
		var map = new ol.Map({
			controls: ol.control.defaults({attribution:false}).extend([
			new ol.control.ScaleLine(),
			new ol.control.FullScreen(),
			new ol.control.OverviewMap()
			]),		  
			layers: [googleLayer,osm],
			target: 'map',
			view: new ol.View({
			center: [0, 0],
			zoom: 4,
			zoomFactor: 2
			})
		});
		var olGM = new olgm.OLGoogleMaps({map: map}); // map is the ol.Map instance
        olGM.activate();

		function addPlot(){
			var url = BASE_URL + 'getsuveyjson?reg_no=REG0000003&id=SRV0000019';
			//url = 'http://openlayers.org/en/v3.18.2/examples/data/geojson/countries.geojson';
			var surveySource = new ol.source.Vector({
			url: url,
			format: new ol.format.GeoJSON({
			defaultDataProjection :'EPSG:4326',
			projection: 'EPSG:3857'
			})
			});
			var survey = new ol.layer.Vector({
			name: 'Plot',
			style: styleFunction
			});
			map.addLayer(survey);
		    survey.setSource(surveySource);
			
			url = BASE_URL + 'getsuveyextent?reg_no=REG0000003&id=SRV0000019';			
			
			$.ajax({url:url, async:false, dataType:'json'}).done(function(data){
			setExtent(parseFloat(data.minx), parseFloat(data.miny), parseFloat(data.maxx), parseFloat(data.maxy));
			});			
        }	
		function setExtent(minx, miny, maxx, maxy){
				var bottomLeft = ol.proj.transform([minx, miny], 'EPSG:4326', 'EPSG:3857');
				var topRight = ol.proj.transform([maxx, maxy], 'EPSG:4326', 'EPSG:3857');
				var extent = new ol.extent.boundingExtent([bottomLeft, topRight]);
				map.getView().fit(extent, map.getSize());
		}		
		addPlot();/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


