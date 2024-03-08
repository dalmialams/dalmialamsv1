
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<script>
new_name ='sd';
    $action = '<?= Route::currentRouteName(); ?>';
    $(function () {
        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select state',
            // minimumInputLength: 2,
        });

        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 2});
        $('.all_total_area').autoNumeric('init', {mDec: 3, dGroup: 2});
        $('.all_percentage').autoNumeric('init', {mDec: 2, dGroup: 2});

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
		$('#tabletools1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                filename: new_name
            },
            {
                extend: 'print',
                filename: 'print'
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
        //alert(state_id);exit();
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
                'village_id': village_id
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
