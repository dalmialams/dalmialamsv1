<script>
		var createTextStyle = function(feature, resolution) {
			return new ol.style.Text({
			textAlign: 'center',
					textBaseline: 'bottom',
					font: '10px Verdana',
					text: feature.get('survey_no'),
					fill: new ol.style.Fill({color: 'black'}),
					offsetY: 0,
					stroke: new ol.style.Stroke({color: 'white', width: 2})
			});
		}        
		var styleFunction = function(feature, resolution){
			var style = new ol.style.Style({
			stroke: new ol.style.Stroke({
			color: '#ffcc33',
			width: 2
			}),
			fill: new ol.style.Fill({
			color: 'rgba(0, 0, 0, 0.1)'
			}),
			text: createTextStyle(feature, resolution)
			});
			return [style];	
		}
</script>
<script>
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
			var url = BASE_URL + 'getsuveyjson?reg_no=<?=isset($reg_uniq_no)?$reg_uniq_no:''?>&id=<?=isset($id)?$id:''?>';
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
			
			url = BASE_URL + 'getsuveyextent?reg_no=<?=isset($reg_uniq_no)?$reg_uniq_no:''?>&id=<?=isset($id)?$id:''?>';			
			
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
		addPlot();
</script>

<script>

   
    $(function () {
      
        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });
        //------------- Form validation -------------//
       /* $(".survey-form").validate({
            ignore: null,
            ignore: 'input[type="hidden"]',
                    errorPlacement: function (error, element) {
                        var place = element.closest('.input-group');
                        if (!place.get(0)) {
                            place = element;
                        }
                        if (place.get(0).type === 'checkbox') {
                            place = element.parent();
                        }
                        if (error.text() !== '') {
                            place.after(error);
                        }
                    },
            errorClass: 'help-block',
            rules: {
                email: {
                    required: true,
                    email: true
                },
                text: {
                    required: true,
                },
                select2: "required",
                password: {
                    required: true,
                    minlength: 5
                },
                textarea: {
                    required: true,
                    minlength: 10
                },
                maxLenght: {
                    required: true,
                    maxlength: 10
                },
                rangelenght: {
                    required: true,
                    rangelength: [10, 20]
                },
                url: {
                    required: true,
                    url: true
                },
                range: {
                    required: true,
                    range: [5, 10]
                },
                minval: {
                    required: true,
                    min: 13
                },
                maxval: {
                    required: true,
                    max: 13
                },
                date: {
                    required: true,
                    date: true
                },
                number: {
                    required: true,
                    number: true
                },
                digits: {
                    required: true,
                    digits: true
                },
                ccard: {
                    required: true,
                    creditcard: true
                },
                agree: "required"
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                agree: "Please accept our policy",
                textarea: "Write some info for you",
                select2: "Please select something"
            },
            highlight: function (label) {
                $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (label) {
                $(label).closest('.form-group').removeClass('has-error');
                label.remove();
            }
        });*/

        $("form input:text").keyup(function () {
           
            this.value = this.value.replace(/[^-0-9\.]/g, "");
        });
        
        
       
 
    });
    
     function delete_param(uniq_no, delete_id) {
            var r = confirm("Are you sure you want to delete!");
            if (r == true) {
                window.location = '<?= url('land-details-entry/survey-lat-log/delete');?>'+ '?reg_uniq_no='+ uniq_no + '&survey_id=' + delete_id;
            }

            return false;
        }

</script>
<script>
    

    $(function () {
         $(".survey-form").submit(function(event){
  <?php
                if (isset($surveyLists)) {

                    foreach ($surveyLists as $key => $value) {
                        ?>

 
    
         
    


        if($('select#lat_<?=$key?> option').length!=$('select#long_<?=$key?> option').length){
            $('#msg_container_lat_<?=$key?>').text("Please check the length")
            $('#msg_container_long_<?=$key?>').text("Please check the length")
            event.preventDefault();
           
        }else{
             $('#msg_container_lat_<?=$key?>').text("")
            $('#msg_container_long_<?=$key?>').text("")
        }
  
                <?php } }?>
                      })
 });
    
    

</script>