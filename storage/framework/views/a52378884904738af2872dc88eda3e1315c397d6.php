
<script>

    function populateRegistration(village_id) {
        //var value = village_id;
        var value = $('#village_id').val();
        var purchaser_name = $('#purchaser_name').val();
        var sub_registrar = $('#sub_registrar').val();
        $('.patta-list').update({url: '<?= url('transaction/conversion-parent-company/populate-dropdown') ?>?namePrefix=conversionParCmp&dropdown_type=dualbox&type=registration_id&val=' + value + '&purchaser_name=' + purchaser_name + '&sub_registrar=' + sub_registrar + '&label_name=Registration No. Selection', data: {'_token': '<?= csrf_token() ?>'}, destination: '.survey_id'});
        $('button[name="save_conversion_parent_company"]').addClass("disabled");
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
        //------------- Form validation -------------//

        $(document).delegate('.duallistbox', 'change', function () {
            var dual_value = $(this).val();
            if (dual_value == '' || dual_value == null) {
                $('button[name="save_conversion_parent_company"]').addClass("disabled");
            } else {
                $('button[name="save_conversion_parent_company"]').removeClass("disabled");
            }
        })




        $('#cnv_list_table').DataTable({
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
                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
                    },
<?php
if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('conversion_to_parent_company_print', $current_user_id))) {
    ?>
                        {
                            "sExtends": "print",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
                        },
    <?php
}
?>
                ]
            }
        });


    });



</script>
<?php echo $validator; ?>