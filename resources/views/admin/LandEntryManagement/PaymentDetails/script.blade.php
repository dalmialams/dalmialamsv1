
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
        var modePreValue = '<?php if(isset($payment_data['pay_mode'])){echo $payment_data['pay_mode'];}?>';
        if(modePreValue!=''){
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
        
        $('.all_total_cost').autoNumeric('init', {mDec: 4, dGroup: 2});
        
        //------------- Form validation -------------//
        $(".payment-form").validate({
            ignore: null,
            ignore: 'input[type="hidden"]',
                    errorPlacement: function (error, element) {
                        var place = element.closest('.input-group');
                        if (!place.get(0)) {
                            place = element;
                        }
                        if (place.get(0).type === 'checkbox') {
                            place = element.parent();
                        }
                        if (error.text() !== '') {
                            place.after(error);
                        }
                    },
            errorClass: 'help-block',
            rules: {
                email: {
                    required: true,
                    email: true
                },
                text: {
                    required: true,
                },
                select2: "required",
                password: {
                    required: true,
                    minlength: 5
                },
                textarea: {
                    required: true,
                    minlength: 10
                },
                maxLenght: {
                    required: true,
                    maxlength: 10
                },
                rangelenght: {
                    required: true,
                    rangelength: [10, 20]
                },
                url: {
                    required: true,
                    url: true
                },
                range: {
                    required: true,
                    range: [5, 10]
                },
                minval: {
                    required: true,
                    min: 13
                },
                maxval: {
                    required: true,
                    max: 13
                },
                date: {
                    required: true,
                    date: true
                },
                number: {
                    required: true,
                    number: true
                },
                digits: {
                    required: true,
                    digits: true
                },
                ccard: {
                    required: true,
                    creditcard: true
                },
                agree: "required"
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                agree: "Please accept our policy",
                textarea: "Write some info for you",
                select2: "Please select something"
            },
            highlight: function (label) {
                $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (label) {
                $(label).closest('.form-group').removeClass('has-error');
                label.remove();
            }
        });

        $(".numbers_only_restrict").keyup(function () {
            this.value = this.value.replace(/[^0-9\.]/g, "");
        });
        
        $("#basic-datepicker").datepicker({ format: "d/m/yyyy",todayHighlight: true,autoclose: true });
        
         //For number input comma Separated
        $('input[name="payment[amount]"]').autoNumeric('init', {mDec: 4,dGroup: 2});
        
        $('.payment-form').submit(function(){

            var form = $(this);
            $('input').each(function(i){
                var self = $(this);
                try{
                    var v = self.autoNumeric('get');
                    self.autoNumeric('destroy');
                    self.val(v);
                }catch(err){
                    console.log("Not an autonumeric field: " + self.attr("name"));
                }
            });
            return true;
        });
        //For number input comma Separated

    });
    
    function validatePayment(text){
        if(text == 'Cash'){
            $('input[name="payment[pay_bank]"]').removeClass('required');
            $('input[name="payment[pay_bank]"]').parents("div").eq(1).removeClass("has-error");
            $('.bank').next('.help-block').html('');
        }else{
            $('input[name="payment[pay_bank]"]').addClass('required');
        }
    }
    
    
    function delete_param(uniq_no, delete_id) {
            var r = confirm("Do you want to delete?");
            if (r == true) {
                window.location = '<?= url('land-details-entry/payment/delete');?>'+ '?reg_uniq_no='+ uniq_no + '&payment_no=' + delete_id;
            }

            return false;
        }
    

</script>