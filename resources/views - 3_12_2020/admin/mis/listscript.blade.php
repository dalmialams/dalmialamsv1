<script>

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
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populateSurvey($(this).val())&namePrefix=registration&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }

    function populatesubclassification(classification_id) {
        var value = classification_id;
        $('#classificationList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=registration&type=sub_classification&val=' + value + '&label_name=Sub Classification', data: {'_token': '<?= csrf_token() ?>'}, destination: '.subclassificationList'});
    }

    function populateSurvey(village_id) {
        var value = village_id;
        $('.village-list').update({url: '<?= url('populate-dropdown') ?>?&namePrefix=registration&type=survey_id&val=' + value + '&label_name=Survey No', data: {'_token': '<?= csrf_token() ?>'}, destination: '#survey-list'});
    }

    function populateResistration(trxn_type) {
        //trxn_type = (trxn_type == 'N') ? 'Y' : 'N';
        var village_id = $('#village_id').val();
        $('.village-list').update({url: '<?= url('transaction/hypothecation/populate-dropdown') ?>?namePrefix=hypothecate&type=registration_id&multiple=true&val=' + village_id + '&from_mis=true&label_name=Registration No.&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.registration_id'});
    }
    function populatePattaSurvey(patta_id) {
        var value = patta_id;
        $('.patta-list').update({url: '<?= url('transaction/mutation/populate-dropdown') ?>?namePrefix=mutation&type=survey_id&val=' + value + '&from_mis=true&label_name=Survey No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '.mutation_survey_list'});
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

//        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 2});
//        $('.all_total_area').autoNumeric('init', {mDec: 4, dGroup: 2});
    });

    $('body').delegate('#transaction_type', 'change', function () {

        var value = $(this).val();
        if (value == 'land_ceiling' || value == 'land_conversion' || value == 'mining_lease' || value == 'land_reservation' || value == 'mutation' || value == 'coversion_parent' || value == 'lease' || value == 'payment' || value == 'hypothecation') {
            $('#survey-list').hide();
        } else {
            $('#survey-list').show();
        }
        $('#transaction_type_box').update({url: '<?= url('mis/transaction/populate-box') ?>?val=' + value, data: {'_token': '<?= csrf_token() ?>'}, destination: '#transaction_type_box'});

    });


</script>
