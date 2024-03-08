
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.60/pdfmake.min.js" type="text/javascript"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.60/vfs_fonts.js" type="text/javascript"></script>
  <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
  <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js" type="text/javascript"></script>
  <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
	
	

	<!--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
	
	
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js" type="text/javascript"></script>-->
	
	
	
	
	
	
<script>
	var new_name ='dashboard-'+<?= date('dmY')?>;
    $action = '<?= Route::currentRouteName(); ?>';
    $(function () {
        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select state',
            // minimumInputLength: 2,
        });

        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 0});
        $('.all_total_area').autoNumeric('init', {mDec: 4, dGroup: 2});
        $('.all_percentage').autoNumeric('init', {mDec: 2, dGroup: 2});
        $('.all_total_area_hector').autoNumeric('init', {mDec: 4, dGroup: 2});

       /*  $('#tabletools1').DataTable({
            "oLanguage": {
                "sSearch": "",
                "sLengthMenu": "<span>_MENU_</span>"
            },
            "sDom": "T<'row'<'col-md-6 col-xs-12 'l><'col-md-6 col-xs-12'f>r>t<'row'<'col-md-4 col-xs-12'i><'col-md-8 col-xs-12'p>>",
            tableTools: {
                "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    "copy",
                    "csv",
                    "xls",
                    "print",
                    "select_all",
                    "select_none"
                ]
            }
			
        }); */
		
		var d = new Date();
		var day = d.getDate();
		var x = d.toDateString().substr(4, 3);
		var year = d.getFullYear();
		var today_date = day + ' ' + x + ' ' + year;
		var today_time = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', second:'2-digit'});
		
		
		
		$('#tabletools1').DataTable( { 
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
				messageTop: today_date +', '+today_time+ '                                                                                                                                                                                                                                                                <?=Auth::user()->user_name?>',
                filename: new_name,
			/*	"customize": function(xlsx) {
				var sheet = xlsx.xl.worksheets['sheet1.xml'];
				$('row:eq(0) a', sheet).attr('s','51');
				$('row:eq(1) c', sheet).attr('s','50');
				$('row:eq(2) g', sheet).attr('s','52');
				$('row c[r^="B"]', sheet).attr( 's', '52' );
				$('row c[r^="C"]', sheet).attr( 's', '52' );
				$('row c[r*="3"]', sheet).attr( 's', '2' );
				

				},*/
				
				 customize: function(xlsx) {
                // Get the sheet objects
                var sSh = xlsx.xl['styles.xml'];
                var styleSheet = sSh.childNodes[0];
                numFmts = styleSheet.childNodes[0];
                cellXfs = styleSheet.childNodes[5];
                var sheet = xlsx.xl.worksheets['sheet1.xml'];

                // Set a custom format ID
                var formatID = 100;

                /// In what follows, use "createElementNS" everytime the attribute has an uppercase letter; otherwise, Chrome and Firefox will break the XML by lowercasing it

                // Using this instead of "" (required for Excel 2007+, not for 2003)
                var ns = "http://schemas.openxmlformats.org/spreadsheetml/2006/main";
                // Create a custom number format
                var newNumberFormat = document.createElementNS(ns, "numFmt");
                newNumberFormat.setAttribute("numFmtId", formatID);
                newNumberFormat.setAttribute("formatCode", "0.0000");
                // Append the new format next to the other ones
                numFmts.appendChild(newNumberFormat);

                // Create a custom style
                var lastStyleNum = $('cellXfs xf', sSh).length - 1;
                var styleNum = lastStyleNum + 1;
                var newStyle = document.createElementNS(ns, "xf");
                // Customize style
                newStyle.setAttribute("numFmtId", formatID);
                newStyle.setAttribute("fontId", 6);
                // Alignment (optional)
                var align = document.createElementNS(ns, "alignment");
                align.setAttribute("horizontal", "right");
                newStyle.appendChild(align);
                // Append the style next to the other ones
                cellXfs.appendChild(newStyle);

                // Use the new style on "Age" column
                $('row:not(:eq(1)) c[r^=C]', sheet).attr('s', styleNum);
                $('row:not(:eq(1)) c[r^=B]', sheet).attr('s', styleNum);

				
				$('row c[r*="3"]', sheet).attr( 's', '2' );

				

            },
            },
			 {
                extend: 'print',
				title:new_name,
                messageTop: function () {
                     return '<div class="flexContainer"><div><b>'+today_date +', '+today_time+'</b></div><div style="font-weight:600;font-size:15px;text-align:center;margin-left:20px;"> LMS Dashboard</div><div style="text-align:right;"><b><?=Auth::user()->user_name?></b></div></div>';
                    
                },
                messageBottom: null,
				 customize: function ( win ) {
					  $(win.document.body).children("h1:first").remove();
					},

				},
            
            {
                extend: 'pdfHtml5',
				 //orientation: 'landscape',
				 pageSize: 'A4', //formato stampa
				alignment: "center",
                filename: new_name, customize: function(doc) {
					doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
        doc.content[1].table.widths = [90,90,90,90,90,90,90,90]; 
					doc.content[1].table.widths = 
        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					doc.content.splice(0, 1);										
					doc.pageMargins = [20, 60, 20, 30];
					doc.defaultStyle.fontSize = 7;
					doc.styles.tableHeader.fontSize = 7;
					doc["header"] = function() {
						return {
							columns: [
								{		
                                	alignment: "left",
									fontSize: 10,
									text: [today_date +', '+today_time]
								},
								{
									alignment: "center",
									text: "LMS Dashboard",
									fontSize: 10,
									margin: [50, 0]
								},
                                {		
                                	alignment: "right",
									fontSize: 10,
									text: ["<?=Auth::user()->user_name?>"]
								}
							],
							margin: 20
						};
					};
					
				},
            }        ]
    } );
    });

    $(function () {
        $.contextMenu({
            selector: '.context-menu-one',
            callback: function (key, options) {


                var rowvalue = $(this).attr('tag');

                var state_id = "{{Request::get('state_id')}}";
                var district_id = "{{Request::get('district_id')}}";
                var block_id = "{{Request::get('block_id')}}";
                var village_id = "{{Request::get('village_id')}}";
                var filter = "{{Request::get('filter')}}";

                if ($action == '' && state_id.length == 0 && filter == '') {
                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                }
                else if ($action == '' && state_id.length == 0 && filter == 'State') {
                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                }
                else if ($action == 'details' && state_id.length > 0 && filter == 'State') {
                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + rowvalue + '&context=' + key + '&filter=' + filter;

                } else if ($action == '' && state_id.length == 0 && filter == 'District') {
                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'district' && state_id.length > 0 && district_id.length == 0 && filter == 'District') {
                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'district' && state_id.length > 0 && district_id.length == 0 && filter == 'Block/Taluk') {
                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'details' && state_id.length > 0 && district_id.length > 0 && filter == 'District') {
                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == '' && state_id.length == 0 && district_id.length == 0 && block_id.length == 0 && filter == 'Block/Taluk') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'block' && state_id.length > 0 && district_id.length == 0 && block_id.length == 0 && filter == 'Block/Taluk') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&block_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'block' && state_id.length > 0 && district_id.length > 0 && block_id.length == 0 && filter == 'Block/Taluk') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + district_id + '&block_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'block' && state_id.length > 0 && district_id.length > 0 && block_id.length == 0 && filter == 'Village') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + district_id + '&block_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                }
                else if ($action == 'details' && state_id.length > 0 && district_id.length > 0 && block_id.length > 0 && filter == 'Block/Taluk') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + district_id + '&block_id=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == '' && state_id.length == 0 && district_id.length == 0 && block_id.length == 0 && village_id.length == 0 && filter == 'Village') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + rowvalue + '&district_id=' + district_id + '&block_id=' + block_id + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'village' && state_id.length > 0 && district_id.length == 0 && block_id.length == 0 && village_id.length == 0 && filter == 'Village') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + district_id + '&block_id=' + block_id + '&village=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'village' && state_id.length > 0 && district_id.length > 0 && block_id.length > 0 && village_id.length == 0 && filter == 'Village') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + district_id + '&block_id=' + block_id + '&village=' + rowvalue + '&context=' + key + '&filter=' + filter;
                } else if ($action == 'village' && state_id.length > 0 && district_id.length > 0 && block_id.length == 0 && village_id.length == 0 && filter == 'Village') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + district_id + '&block_id=' + block_id + '&village=' + rowvalue + '&context=' + key + '&filter=' + filter;
                }
                else if ($action == 'details' && state_id.length > 0 && district_id.length > 0 && block_id.length > 0 && village_id.length > 0 && filter == 'Village') {

                    window.location = '<?= url('dashboard') ?>/' + key + '?state_id=' + state_id + '&district_id=' + district_id + '&block_id=' + block_id + '&village=' + rowvalue + '&context=' + key + '&filter=' + filter;
                }

                //////////////////////////////////// Purpose \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

                //////////////////////////////////// PurchaseType \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



                // var m = "clicked: " + key;
                //  window.console && console.log(m) || alert(m); 
                // window.location='<?= url('dashboard') ?>?dashboard_search='+key;
            },
            items: {
                "classification": {name: "Classification wise"},
                "parent_company": {name: "Conversion to Parent Company"},
                "disputes": {name: "Disputes"},
                "ceiling": {name: "Land Ceiling"},
                "exchange": {name: "Land Exchange"},
                "holding": {name: "Land Holding"},
                "inspection": {name: "Land Inspection"},
                "reservation": {name: "Land Reservation"},
                "mining": {name: "Mining Lease"},
                "mutation": {name: "Mutation Details"},
                "purchaseType": {name: "Purchase Type wise"},
                "purpose": {name: "Purpose wise"},
                /*"edit": {name: "Edit", icon: "edit"},
                 "cut": {name: "Cut", icon: "cut"},
                 copy: {name: "Copy", icon: "copy"},
                 "paste": {name: "Paste", icon: "paste"},
                 "delete": {name: "Delete", icon: "delete"},
                 "sep1": "---------",
                 "quit": {name: "Quit", icon: function(){
                 return 'context-menu-icon context-menu-icon-quit';
                 }}*/
            }
        });

        $('.context-menu-one').on('click', function (e) {

            console.log('clicked', this);
        })
    });

    function totalCostDistribution(state_id, district_id, block_id, village_id,element_id) {
        var purchase_type = $('#purchase_type').val();
        var id = '#' + element_id;
//         alert(total_cost);
//        if (total_cost) {
//            id = '#total';
//        }
     //   alert(id);
        $(id).css('visibility', 'visible');

        $.ajax({
            url: '<?= url('costDistribution') ?>',
            type: 'POST',
            data: {
                '_token': '<?= csrf_token() ?>',
                'state_id': state_id,
                'district_id': district_id,
                'block_id': block_id,
                'village_id': village_id,
				'purchase_type':purchase_type
            },
            error: function () {
                // $('#info').html('<p>An error has occurred</p>');
            },
            success: function (data) {
                //alert(data);
                $(id).css('visibility', 'hidden');
                $('#displayCostDistributionDetails').html('');
                $('#displayCostDistributionDetails').html(data);
                $('#displayCostDistributionModal').modal('show');
				
            },
        });
    }

</script>
