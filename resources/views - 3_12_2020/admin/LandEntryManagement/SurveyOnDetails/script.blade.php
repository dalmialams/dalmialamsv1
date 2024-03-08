<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script>

    function populatesubclassification(classification_id) {
        var value = classification_id;
        $('#classificationList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=survey&type=sub_classification&val=' + value + '&label_name=Sub Classification', data: {'_token': '<?= csrf_token() ?>'}, destination: '.subclassificationList'});
    }
    function populateBlock(district_id) {
        var value = district_id;
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?type=block_id&val=' + value + '&label_name=Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
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
        //------------- Form validation -------------//
        $(".survey-form").validate({
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
        
        
        //For number input comma Separated
        $('#total_area').autoNumeric('init', {mDec: 4,dGroup: 2});
        $('#purchased_area').autoNumeric('init', {mDec: 4,dGroup: 2});
        $('#total_area_in_level').autoNumeric('init', {mDec: 4,dGroup: 2});
        
        $('.survey-form').submit(function(){
            $('.numbers_only_restrict').each(function(i){
                var value = $(this).val();
                if(value!=''){
                    var final_value =  parseFloat(value.replace(/,/g,''));
                    //alert(final_value);
                    $(this).val(final_value);
                }
            });
//            var form = $(this);
//            $('input').each(function(i){
//                var self = $(this);
//                try{
//                    var v = self.autoNumeric('get');
//                    self.autoNumeric('destroy');
//                    self.val(v);
//                }catch(err){
//                    console.log("Not an autonumeric field: " + self.attr("name"));
//                }
//            });
            return true;
        });
        //For number input comma Separated
        
        $(".check_calculation").keyup(function () {
            $('#purchase_area_msg').html("");
            var permission_purchase_area = '<?php echo round(( $reg_data['tot_area'] - $grand_total_purchase_area['grand_total_purchase_area'] ),2)?>';
            

	   var total_area1 = $('#total_area').val();
           var total_area = parseFloat(total_area1.replace(/,/g,''));
           var purchased_area1 = $('#purchased_area').val();  
           var purchased_area = parseFloat(purchased_area1.replace(/,/g,''));
           if(purchased_area > total_area){ 
               $('#purchased_area').val('');
               $('#purchase_area_msg').html("Purchased area can't be more than Total Extent.");
           }
	   else if(purchased_area > permission_purchase_area){
               $('#purchased_area').val('');
               $('#purchase_area_msg').html("Purchased area should not be more than "+permission_purchase_area);
           }
        });
         $('.all_total_cost').autoNumeric('init', {mDec: 4,dGroup: 2});
        $('.all_total_area').autoNumeric('init', {mDec: 4,dGroup: 2});
        
        
        
        
//        $(".check_calculation").keyup(function () {
//            $('#purchase_area_msg').html("");
//           var total_area = parseFloat($('#total_area').val());
//           var purchased_area = parseFloat($('#purchased_area').val());
//           if(purchased_area > total_area){
//               $('#purchased_area').val('');
//               $('#purchase_area_msg').html("Purchased area cannot be more than total area.");
//           }
//        });

           
    });
    
    function delete_param(uniq_no, delete_id) {
            var r = confirm("Do you want to delete?");
            if (r == true) {
                window.location = '<?= url('land-details-entry/survey/delete');?>'+ '?reg_uniq_no='+ uniq_no + '&survey_no=' + delete_id;
            }

            return false;
        }

</script>