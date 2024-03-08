<div id="overlay" class="overlay"></div>
<div id="footer">
    <!-- #footer -->
    <div class="footer-copyright">
        <div class="container">
            <p class="pull-left">
                Copyrights 2016.
            </p>
            <p class="pull-right">
                <a class="mr5" href="#">Powered by CyberSwift.</a>
            </p>
        </div>
    </div>
</div>
<div id="back-to-top"><a href="#">Back to Top</a>
</div>
<!-- Javascripts -->
<!-- Load pace first -->
{{ HTML::script('assets/plugins/core/pace/pace.min.js') }}
<!-- Important javascript libs(put in all pages) -->
{{ HTML::script('assets/js/jquery-2.1.1.min.js') }}
<script>
    window.jQuery || document.write('<script src="js/libs/jquery-2.1.1.min.js">\x3C/script>')
</script>
{{ HTML::script('assets/js/jquery-ui.js') }}
<script>
    window.jQuery || document.write('<script src="js/libs/jquery-ui-1.10.4.min.js">\x3C/script>')
</script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/libs/excanvas.min.js"></script>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="js/libs/respond.min.js"></script>
<![endif]-->
{{-- HTML::script('assets/js/jquery.validate.js') --}}
<!-- Bootstrap plugins -->
{{ HTML::script('assets/js/bootstrap/bootstrap.js') }}
<!-- Core plugins ( not remove ) -->
{{ HTML::script('assets/js/libs/modernizr.custom.js') }}
<!-- Handle responsive view functions -->
{{ HTML::script('assets/js/jRespond.min.js') }}
<!-- Custom scroll for sidebars,tables and etc. -->
{{ HTML::script('assets/plugins/core/slimscroll/jquery.slimscroll.min.js') }}
{{ HTML::script('assets/plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js') }}
<!-- Remove click delay in touch -->
{{ HTML::script('assets/plugins/core/fastclick/fastclick.js') }}
<!-- Increase jquery animation speed -->
{{ HTML::script('assets/plugins/core/velocity/jquery.velocity.min.js') }}

<!-- Quick search plugin (fast search for many widgets) -->
{{ HTML::script('assets/plugins/core/quicksearch/jquery.quicksearch.js') }}
<!-- Bootbox fast bootstrap modals -->
{{ HTML::script('assets/plugins/ui/bootbox/bootbox.js') }}


<!--Other plugins ( load only nessesary plugins for every page) -->
{{ HTML::script('assets/plugins/charts/sparklines/jquery.sparkline.js') }}


{{ HTML::script('assets/frontend/js/main.js') }}





<?php // t($data); ?>
@if (isset($data['jsArr']))
@foreach ($data['jsArr'] as $jkey => $jvalue)
@if (is_array($jvalue))

@if ($jvalue['type'] == 'cdn')
<script type = "text/javascript" src = "{{$jvalue['src']}}"></script>
@endif

@else

<script src="{{ URL::asset($jvalue) }}" type="text/javascript"></script>

@endif
@endforeach
@endif
{{ HTML::script('assets/js/main.js') }}

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



