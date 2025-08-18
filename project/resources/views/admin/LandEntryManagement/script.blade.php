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
           
            theme: "classic",
            placeholder: 'Select state',
            // minimumInputLength: 2,
        });
        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });

//        $('.reg-form').on('submit', function () {
//            var error = 0;
//            $('.required').each(function () {
//                var thisval = $(this).val();
//                if (!thisval) {
//                    error++;
//                    $(this).parents('.form-group').addClass('has-error');
//                } else {
//                    $(this).parents('.form-group').removeClass('has-error');
//                }
//            });
//           // alert(error);
//            if (error > 0) {
//                return false;
//            }
//        });

        //Initialize the validation object which will be called on form submit.
        var validobj = $(".reg-form").validate({
            onkeyup: false,
            errorClass: "myErrorClass",
            //put error message behind each form element
            errorPlacement: function (error, element) {
                var elem = $(element);
                error.insertAfter(element);
            },
            //When there is an error normally you just add the class to the element.
            // But in the case of select2s you must add it to a UL to make it visible.
            // The select element, which would otherwise get the class, is hidden from
            // view.
            highlight: function (element, errorClass, validClass) {
                var elem = $(element);
                if (elem.hasClass("select2-offscreen")) {
                    $("#s2id_" + elem.attr("id") + " ul").addClass(errorClass);
                } else {
                    elem.addClass(errorClass);
                }
            },
            //When removing make the same adjustments as when adding
            unhighlight: function (element, errorClass, validClass) {
                var elem = $(element);
                if (elem.hasClass("select2-offscreen")) {
                    $("#s2id_" + elem.attr("id") + " ul").removeClass(errorClass);
                } else {
                    elem.removeClass(errorClass);
                }
            }
        });


    });

    $(document).on("change", ".select2-offscreen", function () {
        if (!$.isEmptyObject(validobj.submitted)) {
            validobj.form();
        }
    });

    $(document).on("select2-opening", function (arg) {
        var elem = $(arg.target);
        if ($("#s2id_" + elem.attr("id") + " ul").hasClass("myErrorClass")) {
            //jquery checks if the class exists before adding.
            $(".select2-drop ul").addClass("myErrorClass");
        } else {
            $(".select2-drop ul").removeClass("myErrorClass");
        }
    });

</script>