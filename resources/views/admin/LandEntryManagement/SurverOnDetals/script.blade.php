<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

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
        $('.select2-minimum').select2({
            placeholder: 'Select state',
            // minimumInputLength: 2,
        });

        $('.reg-form').on('submit', function () {
            var error = 0;
            $('.required').each(function () {
                var thisval = $(this).val();
                if (!thisval) {
                    error++;
                    $(this).parents('.form-group').addClass('has-error');
                } else {
                    $(this).parents('.form-group').removeClass('has-error');
                }
            });
            if (error > 0) {
                return false;
            }
        });
    });

</script>