<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

       
<script>

    function populateDistrict(state_id,namePrefix) {
        var value = state_id;
       
        $('#stateList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=' + namePrefix + '&type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id,namePrefix) {
        var value = district_id;
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=' + namePrefix + '&type=block_id&val=' + value + '&label_name=Block/Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    function populateVillage(village_id,namePrefix) {
        var value = village_id;
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?namePrefix=' + namePrefix + '&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }


      function populateCity(stateId) {
    // AJAX logic to populate cities...
  }

  $(document).ready(function() {
    $('#propertyState').on('change', function() {
      populateCity(this.value);
    });
  });

   function populateCity(state_id) {
  
        $.ajax({
            url: '<?= url('get-cities-by-state') ?>',
            method: 'POST',
            data: {
                state_id: state_id,
                _token: '<?= csrf_token() ?>'
            },
            success: function(response) {
                console.log(response.optionList);
                $('#propertyCity').html('');

                var html = '<option value=""> Select </option>';
                if (response.optionList.length > 0) {
                    
                    for (i = 0; i < response.optionList.length; i++) {
                        html = html + '<option value="' + response.optionList[i]['option_code'] + '">' + response.optionList[i]['option_desc'] +
                            '</option>';
                    }
                }
                $('#propertyCity').html(html);
            },
            error: function(xhr, status, error) {
                console.error('populateCity AJAX error:', status, error);
            }
        });
    }

   

</script>

<!--<script type="text/javascript" src="{{ URL::asset('assets/vendor/jsvalidation/js/jsvalidation.js', '#my-form')}}"></script>-->

<script>
  $(function () {
        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select',
            // minimumInputLength: 2,
        });
  });
</script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.60/pdfmake.min.js" type="text/javascript"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.60/vfs_fonts.js" type="text/javascript"></script>
  <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
  <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js" type="text/javascript"></script>
  <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
{!! $validator !!}


<script>
$(document).ready( function () {
 var type = $('.select2-minimum option:selected').text(); 
 var tt = type .replace(/[^a-zA-Z ]/g, " ");
 var new_name = 'Master Data - '+tt + '-<?= date('d-m-Y')?>';
  $('#master_table').DataTable( {
        dom: 'Bfrtip',
				//	"scrollX": true,

        buttons: [
            {
                extend: 'excel',
                filename: new_name
            },
			{
                extend: 'pdfHtml5',
                title: new_name
            },
            {
                extend: 'print',
                title: new_name
            }        ]
    });
   $(".basic-datepicker").datepicker();

});
       
	   
	function auditLogDistribution(event_id) {
        $.ajax({
            url: '<?= url('master/audit/logDistribution') ?>',
            type: 'POST',
            data: {
                '_token': '<?= csrf_token() ?>',
                'event_id': event_id,
            },
            error: function () {
                // $('#info').html('<p>An error has occurred</p>');
            },
            success: function (data) {
                //alert(data);
                //$(id).css('visibility', 'hidden');
                //$('#displayCostDistributionDetails').html('');
                $('#displayCostDistributionDetails').html(data);
                $('#displayCostDistributionModal').modal('show');
				
            },
        });
    }
    </script>
 
