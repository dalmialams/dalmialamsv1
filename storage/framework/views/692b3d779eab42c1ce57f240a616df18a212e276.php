
<script>
    function populateDistrict(state_id) {
        var value = state_id;
        $('#stateList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=mutation&type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id) {
        var value = district_id;
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=mutation&type=block_id&val=' + value + '&label_name=Block/Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    function populateVillage(block_id) {
        var value = block_id;
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populateRegistrationNos($(this).val())&namePrefix=mutation&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }
    function populateRegistrationNos(village_id) {
        var value = village_id;
        $('.village-list').update({url: '<?= url('transaction/audit/populate-dropdown') ?>?onchange=checkExists($(this).val())&namePrefix=auditstatusreg&type=reg_no&val=' + value, data: {'_token': '<?= csrf_token() ?>'}, destination: '.registrationList'});
    }

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
        $(".basic-datepicker").datepicker({
			format: "d/m/yyyy",
			todayHighlight: true,
            autoclose: true,
            endDate: '+0d',
        });
        $('#audit_stat_list_table').DataTable({
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
                        "mColumns": [0, 1, 2, 3]
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [0, 1, 2, 3]
                    },
<?php
if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('audit_status_print', $current_user_id))) {
    ?>
                        {
                            "sExtends": "print",
                            "mColumns": [0, 1, 2, 3]
                        },
    <?php
}
?>
                ]
            }
        });
    });
    function checkExists(registration_id) {

        $.ajax({
            url: '<?= url('transaction/audit/checkExists') ?>',
            type: 'POST',
            data: {
                '_token': '<?= csrf_token() ?>',
                'registration_id': registration_id
            },
            error: function () {
                // $('#info').html('<p>An error has occurred</p>');
            },
            //dataType: 'json',
            success: function (data) {
                //console.log(data)
                if (data != 0) {
                    window.location = '<?= url('transaction/audit/edit?audit_uniq_no='); ?>' + data;
                }
            },
        });
    }

    function openHref(type) {
        var reg_id = $('#uniqueregistrationNumber').val();
       
        if (reg_id) {
            if (type == 'Payment') {
                var url = '<?= url('land-details-entry/payment/view?reg_uniq_no='); ?>' + reg_id + '&view=true';
                window.open(url, '_blank');
            } else if (type == 'Document') {
                var url = '<?= url('land-details-entry/document/view?reg_uniq_no='); ?>' + reg_id + '&view=true';
                window.open(url, '_blank');
            }
        }
    }



</script>
<?php echo $validator; ?>