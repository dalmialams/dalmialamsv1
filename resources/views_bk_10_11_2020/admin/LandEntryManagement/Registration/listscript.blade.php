
<script>
    function test()
    {
        alert(1);
    }
    function populateDistrict(state_id) {
    var value = state_id;
            $('#stateList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=registration&type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id) {
    var value = district_id;
            $('.districtList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=registration&type=block_id&val=' + value + '&label_name=Block/Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    function populateVillage(block_id) {
    var value = block_id;
            $('.block-list').update({url: '<?= url('populate-dropdown') ?>?namePrefix=registration&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }

    function populatesubclassification(classification_id) {
    var value = classification_id;
            $('#classificationList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=registration&type=sub_classification&val=' + value + '&label_name=Sub Classification', data: {'_token': '<?= csrf_token() ?>'}, destination: '.subclassificationList'});
    }

//    selected_classification = '<?= isset($classification) ? $classification : '' ?>';
//    alert(selected_classification);

    $(function () {
    $(".basic-datepicker").datepicker();
            $('.select2').select2({placeholder: 'Select Survey No'});
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
            $('.all_total_area').autoNumeric('init', {mDec: 4, dGroup: 2});
//        if(selected_classification){
//            populatesubclassification(selected_classification);
//        }


            $('#registration_lists_table').DataTable({
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
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                    },
                    {
                    "sExtends": "xls",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                    },
<?php
if ($user_type == 'admin') {
    ?>
                    {    "sExtends": "csv",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                    },
                    {
                    "sExtends": "xls",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                    },
                        {
                        "sExtends": "print",
                                "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                        },
    <?php
} else {
    if (\App\Models\UtilityModel::ifHasPermission('registration_print', $current_user_id)) {
        ?>
                            {
                            "sExtends": "print",
                                    "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                            },
    <?php
    }
}
?>
                    ]
            }
    });
            $('.transaction-table').DataTable({
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
                            //"mColumns": []
                    },
                    {
                    "sExtends": "xls",
                            // "mColumns": []
                    },
                    ]
            }
    });
            var datapresent = '<?php echo $dataPresent; ?>';
            if (datapresent == 'yes') {
    $('.panel-minimize').trigger('click');
    }

    });

</script>
