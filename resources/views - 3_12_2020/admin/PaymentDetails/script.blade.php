
<script>

    function populateDistrict(state_id) {
        var value = state_id;
        $('#stateList').update({url: '<?= url('populate-dropdown') ?>?type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id) {
        var value = district_id;
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?type=block_id&val=' + value + '&label_name=Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    $(function () {
        var modePreValue = '<?php if (isset($payment_data['pay_mode'])) {
    echo $payment_data['pay_mode'];
} ?>';
        if (modePreValue != '') {
            var modePreText = $('select[name="payment[pay_mode]"]').find("option:selected").text();
            validatePayment(modePreText);
        }

        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select state',
            // minimumInputLength: 2,
        });
        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });


        $(".numbers_only_restrict").keyup(function () {
            this.value = this.value.replace(/[^0-9\.]/g, "");
        });

        $("#basic-datepicker").datepicker({ format: "d/m/yyyy",todayHighlight: true,autoclose: true });

        //For number input comma Separated
        $('input[name="payment[amount]"]').autoNumeric('init', {mDec: 2, dGroup: 2});

        $('.payment-form').submit(function () {

            var form = $(this);
            $('input').each(function (i) {
                var self = $(this);
                try {
                    var v = self.autoNumeric('get');
                    self.autoNumeric('destroy');
                    self.val(v);
                } catch (err) {
                    console.log("Not an autonumeric field: " + self.attr("name"));
                }
            });
            return true;
        });
        //For number input comma Separated

        $('#payament_lists_table').DataTable({
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
if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('payment_print', $current_user_id))) {
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

    });

    function validatePayment(text) {
        if (text == 'Cash') {
            $('input[name="payment[pay_bank]"]').removeClass('required');
            $('input[name="payment[pay_bank]"]').parents("div").eq(1).removeClass("has-error");
            $('.bank').next('.help-block').html('');
        } else {
            $('input[name="payment[pay_bank]"]').addClass('required');
        }
    }

    function delete_param(delete_id) {
        var r = confirm("Do you want to delete?");
        if (r == true) {
            window.location = '<?= url('payment/delete'); ?>' + '?payment_no=' + delete_id;
        }

        return false;
    }


</script>
<?= $validator ?>