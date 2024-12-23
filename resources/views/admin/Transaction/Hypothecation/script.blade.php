
<script>

    function populateResistration(trxn_type) {
        trxn_type = (trxn_type == 'N') ? 'Y' : 'N';
        $('.village-list').update({url: '<?= url('transaction/hypothecation/populate-dropdown') ?>?namePrefix=hypothecate&type=registration_id&multiple=true&label_name=Registration No.&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.registration_id'});
        populateResistrationDetails(null);
    }

    function populateResistrationDetails(value) {
        var trxn_type = $('.trxn_type option:selected').val();
        trxn_type = (trxn_type == 'N') ? 'Y' : 'N';
        $('.registration_id').update({url: '<?= url('transaction/hypothecation/populate-registrationDetailsTable') ?>?value=' + value, data: {'_token': '<?= csrf_token() ?>'}, destination: '.registration_details'});
        $('.registration_id').update({url: '<?= url('transaction/hypothecation/populate-registrationDocumentDetailsTable') ?>?&trxn_type=' + trxn_type + '&value=' + value, data: {'_token': '<?= csrf_token() ?>'}, destination: '.registration_document_details'});
    }

    $(function () {
        $('.select2-minimum').select2({
            placeholder: 'Select',
            allowClear: true
        });
        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });

        $("#basic-datepicker").datepicker({ format: "d/m/yyyy",todayHighlight: true,autoclose: true });


        $(".numbers_only_restrict").keyup(function () {
            this.value = this.value.replace(/[^0-9\.]/g, "");
        });

        $('input[name="hypothecate[value]"]').autoNumeric('init', {mDec: 2, dGroup: 2});
        $('.autonumeric').autoNumeric('init', {mDec: 2, dGroup: 2});

        $('.hypothecate-form').submit(function () {

            $('.numbers_only_restrict').each(function (i) {
                var value = $(this).val();
                if (value != '') {
                    var final_value = parseFloat(value.replace(/,/g, ''));
                    //alert(final_value);
                    $(this).val(final_value);
                }
            });

            return true;
        });



    });

    function validateform1(text) {
        if (text == '' || text == 'select') {
            $('button[name="save_inspection"]').addClass("disabled");
        } else {
            $('button[name="save_inspection"]').removeClass("disabled");
        }
    }
    $('#hypothecate_list_table').DataTable({
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
                    "mColumns": [0, 1, 2, 3, 4, 5]
                },
                {
                    "sExtends": "xls",
                    "mColumns": [0, 1, 2, 3, 4, 5]
                },
<?php
if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('land_exchange_print', $current_user_id))) {
    ?>
                    {
                        "sExtends": "print",
                        "mColumns": [0, 1, 2, 3, 4, 5]
                    },
    <?php
}
?>
            ]
        }
    });



</script>
<?= $validator ?>