
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
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populatePatta($(this).val())&namePrefix=mutation&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }
    function populatePatta(village_id) {
        var value = village_id;
        $('.village-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populateFields($(this).val())&namePrefix=mutation&type=patta_id&val=' + value + '&label_name=Patta No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '.patta-list'});
    }
    function populateSurvey(patta_id) {
        var value = patta_id;
        $('.patta-list').update({url: '<?= url('transaction/mutation/populate-dropdown') ?>?namePrefix=mutation&dropdown_type=dualbox&type=survey_id&val=' + value + '&label_name=Survey No. Selection', data: {'_token': '<?= csrf_token() ?>'}, destination: '.survey_id'});
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
        $(".numbers_only_restrict").keyup(function () {
            this.value = this.value.replace(/[^0-9\.]/g, "");
        });

        // $("#basic-datepicker").datepicker();

        //date range
        // $(".input-daterange").datepicker();
        $(document).delegate('.duallistbox', 'change', function () {
            var dual_value = $(this).val();
            if (dual_value == '' || dual_value == null) {
                $('button[name="save_mutation"]').addClass("disabled");
            } else {
                $('button[name="save_mutation"]').removeClass("disabled");
            }
        })


        //For number input comma Separated
        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 2});
        $('.all_total_area').autoNumeric('init', {mDec: 3, dGroup: 2});



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

        $('#mutation_list_table').DataTable({
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
                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
<?php
if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('mutation_print', $current_user_id))) {
    ?>
                        {
                            "sExtends": "print",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        },
    <?php
}
?>
                ]
            }
        });

    });

    function delete_param(delete_id) {
        var r = confirm("Do you want to delete?");
        if (r == true) {
            window.location = '<?= url('lease-management/delete'); ?>' + '?lease_no=' + delete_id;
        }

        return false;
    }

    function populateFields(patta_id) {
        populateSurvey(patta_id);
        $.ajax({
            url: '<?= url('transaction/mutation/populate-fields') ?>',
            type: 'POST',
            data: {
                '_token': '<?= csrf_token() ?>',
                'patta_id': patta_id
            },
            error: function () {
                // $('#info').html('<p>An error has occurred</p>');
            },
            dataType: 'json',
            success: function (data) {
                //console.log(data)
                $('input[name=pattaowner]').val(data.patta_owner);
            },
        });
    }

    function pattasurveyno(patta_id, type) {

        $.ajax({
            url: '<?= url('transaction/mutation/getPattaSurveyDetails') ?>',
            type: 'POST',
            data: {
                '_token': '<?= csrf_token() ?>',
                'patta_id': patta_id,
                'type': type
            },
            error: function () {
                // $('#info').html('<p>An error has occurred</p>');
            },
            success: function (data) {
                $('#displaySurveyDetails').html('');
                $('#displaySurveyDetails').html(data);
                $('#displaySurveyDetailsModal').modal('show');
            },
        });
    }


</script>
<?php echo $validator; ?>