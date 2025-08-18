
<script>

    function populateDistrict(state_id) {
        var value = state_id;
        $('#stateList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=patta&type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id) {
        var value = district_id;
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=patta&type=block_id&val=' + value + '&label_name=Block/Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    function populateVillage(block_id) {
        var value = block_id;
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populateSurvey("",$(this).val())&namePrefix=patta&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }
    function populateSurvey(reg_id, village_id) {
        var reg_id = reg_id;
        var value = village_id;
        $('.village-list').update({url: '<?= url('land-details-entry/patta/populate-dropdown') ?>?namePrefix=patta&dropdown_type=dualbox&type=survey_id&val=' + value + '&label_name=Survey No. Selection', data: {'_token': '<?= csrf_token() ?>'}, destination: '.survey_id'});
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

        //------------- Dual list box -------------//
        $('.duallistbox').bootstrapDualListbox({
            nonSelectedListLabel: 'Select Survey No',
            selectedListLabel: 'Assigned Survey No',
            preserveSelectionOnMove: 'moved',
            moveOnSelect: true,
        });
        $('.viewdualllistbox').bootstrapDualListbox({
            nonSelectedListLabel: 'All Survey No',
            selectedListLabel: 'Assigned Survey No',
            preserveSelectionOnMove: 'moved',
            moveOnSelect: false,
        });
        $('select[name="view_survey_name[]_helper1"]').prop('disabled', true);
        $('select[name="view_survey_name[]_helper2"]').prop('disabled', true);
        $('select[name="view_survey_name[]"]').parent().find('.moveall').prop('disabled', true);
        $('select[name="view_survey_name[]"]').parent().find('.move').prop('disabled', true);
        $('select[name="view_survey_name[]"]').parent().find('.removeall').prop('disabled', true);
        $('select[name="view_survey_name[]"]').parent().find('.remove').prop('disabled', true);



    });

    function validateform(text) {
        if (text == 'Lease') {
            $('input[name="patta[regn_no]"]').removeClass('required');
            //$('input[name="patta[regn_date]"]').removeClass('required');
            $('input[name="patta[sub_registrar]"]').removeClass('required');
            $('input[name="patta[regn_no]"]').parents("div").eq(1).removeClass("has-error");
            //$('input[name="patta[regn_date]"]').parents("div").eq(2).removeClass("has-error");
            $('input[name="patta[sub_registrar]"]').parents("div").eq(1).removeClass("has-error");
            $('.paymentValidate').next('.help-block').html('');
        } else {
            $('input[name="patta[regn_no]"]').addClass('required');
            //$('input[name="patta[regn_date]"]').addClass('required');
            $('input[name="patta[sub_registrar]"]').addClass('required');

        }
    }

</script>
<?= $validator ?>