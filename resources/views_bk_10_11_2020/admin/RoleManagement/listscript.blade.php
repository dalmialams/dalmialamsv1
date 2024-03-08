
<script>

    

    $(function () {
        $(".basic-datepicker").datepicker();
        
        $('.select2').select2({placeholder: 'Select Survey No'});

        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select',
            // minimumInputLength: 2,
        });

        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });
        //------------- Form validation -------------//

      

//        $('#registration_lists_table').DataTable({
//            "oLanguage": {
//                "sSearch": "",
//                "sLengthMenu": "<span>_MENU_</span>"
//            },
//            "sDom": "T<'row'<'col-md-6 col-xs-12 'l><'col-md-6 col-xs-12'f>r>t<'row'<'col-md-4 col-xs-12'i><'col-md-8 col-xs-12'p>>",
//            tableTools: {
//                "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
//                "aButtons": [
//                    {
//                        "sExtends": "csv",
//                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
//                    },
//                    {
//                        "sExtends": "xls",
//                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
//                   },
//                ]
//            }
//        });
        
         $("#start_date").datepicker({
            autoclose: true,
        }).on('changeDate', function (selected) {
            var startDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', startDate);
        }).on('clearDate', function (selected) {
            $('#end_date').datepicker('setStartDate', null);
        });

        $("#end_date").datepicker({
            autoclose: true,
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', endDate);
        }).on('clearDate', function (selected) {
            $('#start_date').datepicker('setEndDate', null);
        });

      

    });

</script>
