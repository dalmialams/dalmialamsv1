<div id="overlay" class="overlay"></div>
<div id="footer">
    <!-- #footer -->
    <div class="footer-copyright">
        <div class="container">
            <p class="pull-left">
            &copy; Copyrights <?php echo date('Y'); ?>.
            </p>
            <p class="pull-right">Powered by
                <a class="mr5" href="http://www.cyber-swift.com"> CyberSwift.</a>
            </p>
        </div>
    </div>
</div>
<div id="back-to-top"><a href="#">Back to Top</a>
</div>
<!-- Javascripts -->
<!-- Load pace first -->
<script src="{{url('assets/plugins/core/pace/pace.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/jquery-2.1.1.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/bootstrap/bootstrap.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/libs/modernizr.custom.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/jRespond.min.js')}}" type="text/javascript"></script>

<script src="{{url('assets/plugins/core/slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js')}}" type="text/javascript"></script>


<script src="{{url('assets/plugins/core/fastclick/fastclick.js')}}" type="text/javascript"></script>
<script src="{{url('assets/plugins/core/velocity/jquery.velocity.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/plugins/core/quicksearch/jquery.quicksearch.js')}}" type="text/javascript"></script>

<script src="{{url('assets/plugins/ui/bootbox/bootbox.js')}}" type="text/javascript"></script>
<script src="{{url('assets/plugins/charts/sparklines/jquery.sparkline.js')}}" type="text/javascript"></script>
<script src="{{url('assets/frontend/js/main.js')}}" type="text/javascript"></script>

<script>
    window.jQuery || document.write('<script src="js/libs/jquery-2.1.1.min.js">\x3C/script>')
</script>
<script src="{{url('assets/js/jquery-ui.js')}}" type="text/javascript"></script>

<script>
    window.jQuery || document.write('<script src="js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
</script>

@if (isset($data['jsArr']))
@foreach ($data['jsArr'] as $jkey => $jvalue)
@if (is_array($jvalue))

@if ($jvalue['type'] == 'cdn')
<script type = "text/javascript" src = "{{$jvalue['src']}}"></script>
@endif

@else

<script src="{{ url($jvalue) }}" type="text/javascript"></script>

@endif
@endforeach
@endif

<script src="{{url('assets/js/main.js')}}" type="text/javascript"></script>


<script>
//get log details
function get_log_details(id,table)
{
	
	url = "<?= URL('land-details-entry/registration/audit-view-details')?>";
	 $.ajax({  
		url:url ,  
		method:"get",  
		data:{"id":id,"table":table}, 
		
		success:function(data){ 
		//alert(data);
			$('#enumeration_dataModal').html(data);  
			$('#enumeration_dataModal').modal("show");
			//$('#enumeration_popup_table').DataTable();
			$('#registration_lists_table2').DataTable( {
			dom: 'Bfrtip',
			"pageLength": 5,
			buttons: [
				{
						extend: "excel",
						className: "btn-sm",
						filename: '',
						exportOptions: {
							//columns: [0, 1, 2, 3, 4, 5, 6]
						columns: ':visible',
						search: 'applied',
						order: 'applied'
						}
				},
			]
			} );			
		}  
		
   });
   
}
</script>

<?php if (isset($include_script_view) && $include_script_view) { ?>
    @include($include_script_view)
<?php } ?>

<?php
if (isset($registerScript)) {

    $scriptReady = '';
    $scriptLoad = '';
    $scriptEmpty = '';


    foreach ($registerScript as $key => $val) {
        if ($val['type'] == 'DOC_READY') {
            $scriptReady = $scriptReady . "\n" . $val['script'];
        }
        if ($val['type'] == 'WINDOW_LOAD') {
            $scriptLoad = $scriptLoad . "\n" . $val['script'];
        }
        if ($val['type'] == 'EMPTY') {
            $scriptEmpty = $scriptEmpty . "\n" . $val['script'];
        }
    }
}
?>

<script type="text/javascript">
<?php if (isset($scriptReady) && !empty($scriptReady)) { ?>
        $(document).ready(function () {
    <?php echo $scriptReady ?>
        })
<?php } if (isset($scriptLoad) && !empty($scriptLoad)) { ?>
        $(window).load(function () {
    <?php echo $scriptLoad ?>
        })
<?php } if (isset($scriptEmpty) && !empty($scriptEmpty)) { ?>

    <?php echo $scriptEmpty ?>

<?php } ?>
</script>
<!-- Custome JS from controleer -->



