
<script>

    $(function () {
        $("#basic-datepicker").datepicker();
        $(".input-daterange").datepicker();

        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select state',
            // minimumInputLength: 2,
        });

        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });
        //------------- Form validation -------------//

        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 2});
        $('.all_total_area').autoNumeric('init', {mDec: 3, dGroup: 2});


        $('#lease_lists_table').DataTable({
            "oLanguage": {
                "sSearch": "",
                "sLengthMenu": "<span>_MENU_</span>"
            },
            "sDom": "T<'row'<'col-md-6 col-xs-12 'l><'col-md-6 col-xs-12'f>r>t<'row'<'col-md-4 col-xs-12'i><'col-md-8 col-xs-12'p>>",
            tableTools: {
                "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "csv",
                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                   },
                ]
            }
        });

        var datapresent = '<?= $dataPresent ?>';
        if (datapresent == 'yes') {
            $('.panel-minimize').trigger('click');
        }

    });

</script>
