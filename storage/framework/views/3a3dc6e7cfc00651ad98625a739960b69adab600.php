
<script>
    $(function () {
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
        $(".numbers_only_restrict").keyup(function () {
            this.value = this.value.replace(/[^0-9\.]/g, "");
        });

        // $("#basic-datepicker").datepicker();

        //date range
        // $(".input-daterange").datepicker();



        //For number input comma Separated
        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 2});
        $('.all_total_area').autoNumeric('init', {mDec: 3, dGroup: 2});

        $('.lease-form').submit(function () {

            var form = $(this);
            $('input').each(function (i) {
                var self = $(this);
                try {
                    var v = self.autoNumeric('get');
                    self.autoNumeric('destroy');
                    self.val(v);
                } catch (err) {
                    // console.log("Not an autonumeric field: " + self.attr("name"));
                }
            });
            return true;
        });
        //For number input comma Separated

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


    function delete_param(uniq_no, delete_id) {
        var r = confirm("Do you want to delete?");
        if (r == true) {
            window.location = '<?= url('land-details-entry/lease/delete'); ?>' + '?reg_uniq_no=' + uniq_no + '&lease_no=' + delete_id;
        }

        return false;
    }


</script>

<?php echo $validator; ?>