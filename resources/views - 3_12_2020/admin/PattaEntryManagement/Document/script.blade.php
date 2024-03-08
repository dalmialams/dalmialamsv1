
<script>   
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
        $(".document-form").validate({
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
                file: {
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


    });

</script>