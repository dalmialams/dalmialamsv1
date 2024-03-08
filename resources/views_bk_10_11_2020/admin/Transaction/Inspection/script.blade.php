
<script>

    function populateDistrict(state_id) {
        var value = state_id;
        $('#stateList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=inspection&type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id) {
        var value = district_id;
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=inspection&type=block_id&val=' + value + '&label_name=Block/Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    function populateVillage(block_id) {
        var value = block_id;
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populateSurvey("",$(this).val())&namePrefix=inspection&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }
    function populateSurvey(reg_id, village_id) {
        var reg_id = reg_id;
        var value = village_id;
        $('.village-list').update({url: '<?= url('transaction/inspection/populate-dropdown') ?>?namePrefix=inspection&type=survey_id&val=' + value + '&label_name=Survey No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '.survey-list'});
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

        $("#basic-datepicker").datepicker({
            format: "yyyy-m-d"
        });

        $('#inspection_list_table').DataTable({
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
if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('land_inspection_print', $current_user_id))) {
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


    function validateform(text) {
        if (text == 'No') {
            $('button[name="save_inspection"]').removeClass("disabled");
            $('select[name="inspection[encroachment_type]"]').select2("enable", false);
        } else {
            $('button[name="save_inspection"]').addClass("disabled");
            $('select[name="inspection[encroachment_type]"]').select2("enable", true);
        }
    }
    function validateform1(text) {
        if (text == '' || text == 'select') {
            $('button[name="save_inspection"]').addClass("disabled");
        } else {
            $('button[name="save_inspection"]').removeClass("disabled");
        }
    }




</script>
{!! $validator !!}