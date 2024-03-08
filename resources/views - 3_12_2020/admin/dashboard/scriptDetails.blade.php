
<script>
$action='<?= Route::currentRouteName();?>';
    $(function () {
        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select state',
            // minimumInputLength: 2,
        });

        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 2});
        $('.all_total_area').autoNumeric('init', {mDec: 3, dGroup: 2});
        $('.all_percentage').autoNumeric('init', {mDec: 2, dGroup: 2});

        $('#tabletools1').DataTable({
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
        });

    });

    $(function () {
        $.contextMenu({
            selector: '.context-menu-one',
            callback: function (key, options) {
                
               
                var rowvalue = $(this).attr('tag');
                
                var state_id = "{{Request::get('state_id')}}";
                var district_id = "{{Request::get('district_id')}}";
                var block_id = "{{Request::get('block_id')}}";
                 var filter = "{{Request::get('filter')}}";
                 
                if ($action=='details'&&key=='Classification' && state_id && filter=='State') {
                    window.location = '<?= url('dashboard/classification') ?>?state_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(state_id &&key=='Classification'&& filter=='District'){
                    window.location = '<?= url('dashboard/classification') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='district'&&key=='Classification'&& state_id && filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/classification') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(state_id &&key=='Classification'&& filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/classification') ?>?block_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='district'&&key=='Classification'&& state_id && filter=='Village'){
                    window.location = '<?= url('dashboard/classification') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='details'&&key=='Classification'&& state_id && filter=='Village'){
                    window.location = '<?= url('dashboard/classification') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='details'&&key=='Classification'&& district_id && filter=='Village'){
                    window.location = '<?= url('dashboard/classification') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='village'&&key=='Classification'&& block_id && filter=='Village'){
                    window.location = '<?= url('dashboard/classification') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(district_id&&key=='Classification' && filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/classification') ?>?block_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
               
                }else if(block_id &&key=='Classification' && filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/classification') ?>?block_id=' + rowvalue + '&context=' + key;
                }else if(key=='Classification'){
                  
                    window.location = '<?= url('dashboard/classification') ?>?state_id=' + rowvalue + '&context=' + key;
                   
                }
                //////////////////////////////////// Purpose \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
                
                else  if ($action=='details' &&key=='purpose' && state_id && filter=='State') {
                    window.location = '<?= url('dashboard/purpose') ?>?state_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(state_id &&key=='purpose'&& filter=='District'){
                    window.location = '<?= url('dashboard/purpose') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='district'&&key=='purpose'&& state_id && filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/purpose') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(state_id &&key=='purpose'&& filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/purpose') ?>?block_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='district'&&key=='purpose'&& state_id && filter=='Village'){
                    window.location = '<?= url('dashboard/purpose') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='details'&&key=='purpose'&& state_id && filter=='Village'){
                    window.location = '<?= url('dashboard/purpose') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='details'&&key=='purpose'&& district_id && filter=='Village'){
                    window.location = '<?= url('dashboard/purpose') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='village'&&key=='purpose'&& block_id && filter=='Village'){
                    window.location = '<?= url('dashboard/purpose') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(district_id &&key=='purpose'&& filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/purpose') ?>?block_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(block_id&&key=='purpose' && filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/purpose') ?>?block_id=' + rowvalue + '&context=' + key;
                }else if(key=='Purpose'){
                   
                    window.location = '<?= url('dashboard/purpose') ?>?state_id=' + rowvalue + '&context=' + key;
                }
                
                //////////////////////////////////// PurchaseType \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
                
                else  if ($action=='details' &&key=='PurchaseType' && state_id && filter=='State') {
                    window.location = '<?= url('dashboard/purchase_type') ?>?state_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(state_id &&key=='PurchaseType'&& filter=='District'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='district'&&key=='PurchaseType'&& state_id && filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(state_id &&key=='PurchaseType'&& filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?block_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='district'&&key=='PurchaseType'&& state_id && filter=='Village'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?district_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='details'&&key=='PurchaseType'&& state_id && filter=='Village'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='details'&&key=='PurchaseType'&& district_id && filter=='Village'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if($action=='village'&&key=='PurchaseType'&& block_id && filter=='Village'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?village_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(district_id &&key=='PurchaseType'&& filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?block_id=' + rowvalue + '&context=' + key+'&filter=' + filter;
                }else if(block_id&&key=='PurchaseType' && filter=='Block/Taluk'){
                    window.location = '<?= url('dashboard/purchase_type') ?>?block_id=' + rowvalue + '&context=' + key;
                }else if(key=='PurchaseType'){
                   
                    window.location = '<?= url('dashboard/purchase_type') ?>?state_id=' + rowvalue + '&context=' + key;
                }
                
                
                // var m = "clicked: " + key;
                //  window.console && console.log(m) || alert(m); 
                // window.location='<?= url('dashboard') ?>?dashboard_search='+key;
            },
            items: {
                "Classification": {name: "Classification wise"},
                "ParentCompany": {name: "Conversion to Parent Company"},
                "Disputes": {name: "Disputes"},
                "Ceiling": {name: "Land Ceiling"},
                "Exchange": {name: "Land Exchange"},
                "Holding": {name: "Land Holding"},
                "Inspection": {name: "Land Inspection"},
                "Reservation": {name: "Land Reservation"},
                "Mining": {name: "Mining Lease"},
                "Mutation": {name: "Mutation Details"},
                "PurchaseType": {name: "Purchase Type wise"},
                "Purpose": {name: "Purpose wise"},
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

</script>
