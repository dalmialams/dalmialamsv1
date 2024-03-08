
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
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
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?namePrefix=registration&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }

    $(function () {
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

        $("#basic-datepicker").datepicker({
            format: "yyyy-m-d"
        });


        //For number input comma Separated
        $('input[name="registration[tot_area]"]').autoNumeric('init', {mDec: 4, dGroup: 2});
        //$('input[name="registration[tot_cost]"]').autoNumeric('init', {mDec: 2, dGroup: 2});

        $('.reg-form').submit(function () {

            $('.numbers_only_restrict').each(function (i) {
                var value = $(this).val();
                if (value != '') {
                    var final_value = parseFloat(value.replace(/,/g, ''));
                    //alert(final_value);
                    $(this).val(final_value);
                }
            });

            /*var form = $(this);
             $('input').each(function(i){
             var self = $(this);
             try{
             var v = self.autoNumeric('get');
             self.autoNumeric('destroy');
             self.val(v);
             }catch(err){
             console.log("Not an autonumeric field: " + self.attr("name"));
             }
             });*/
            return true;
        });
        //For number input comma Separated


    });

    function validateform(text) {
        if (text == 'Lease') {
            $('input[name="registration[regn_no]"]').removeClass('required');
            //$('input[name="registration[regn_date]"]').removeClass('required');
            $('input[name="registration[sub_registrar]"]').removeClass('required');
            $('input[name="registration[regn_no]"]').parents("div").eq(1).removeClass("has-error");
            //$('input[name="registration[regn_date]"]').parents("div").eq(2).removeClass("has-error");
            $('input[name="registration[sub_registrar]"]').parents("div").eq(1).removeClass("has-error");
            $('.paymentValidate').next('.help-block').html('');
        } else {
            $('input[name="registration[regn_no]"]').addClass('required');
            //$('input[name="registration[regn_date]"]').addClass('required');
            $('input[name="registration[sub_registrar]"]').addClass('required');

        }
    }

    function populateTransactionDetails(trxn_id, trxn_type) {
        var id = '#' + trxn_id;
        $(id).css('visibility', 'visible');
        $.ajax({
            url: '<?= url('land-details-entry/registration/populate-transaction-details') ?>',
            type: 'POST',
            data: {
                '_token': '<?= csrf_token() ?>',
                'trxn_id': trxn_id,
                'trxn_type': trxn_type
            },
            error: function () {
                // $('#info').html('<p>An error has occurred</p>');
            },
            success: function (data) {
                $(id).css('visibility', 'hidden');
                $('.modal_box').css('visibility', 'visible');
                $('#displaySurveyDetails').html('');
                $('#displaySurveyDetails').html(data);
                $('#mySmallModalLabel').html('Transaction Details (' + trxn_id + '}')
                //  $('#displaySurveyDetailsModal').modal('show');
                $('#displaySurveyDetailsModal').modal('show', function () {
                    $(this).find('.modal-body').css({
                        width: 'auto', //probably not needed
                        height: 'auto', //probably not needed 
                        'max-height': '100%'
                    });
                });
            },
        });
    }

    function populateMultipleDocs(trxn_id) {
        var id = '#' + trxn_id+'_docs';
        $(id).css('visibility', 'visible');
        $.ajax({
            url: '<?= url('land-details-entry/registration/populate-multiple-docs') ?>',
            type: 'POST',
            data: {
                '_token': '<?= csrf_token() ?>',
                'trxn_id': trxn_id,
            },
            error: function () {
                // $('#info').html('<p>An error has occurred</p>');
            },
            success: function (data) {
                $(id).css('visibility', 'hidden');
                $('.modal_box_multiple_docs').css('visibility', 'visible');
                $('#multiple_docs').html('');
                $('#multiple_docs').html(data);
                //$('#mySmallModalLabel').html('Transaction List (' + trxn_id + '}')
                //  $('#displaySurveyDetailsModal').modal('show');
                $('#multiple_docs_modal').modal('show', function () {
                    $(this).find('.modal-body').css({
                        width: 'auto', //probably not needed
                        height: 'auto', //probably not needed 
                        'max-height': '100%'
                    });
                });
            },
        });
    }


</script>
<?= $validator ?>