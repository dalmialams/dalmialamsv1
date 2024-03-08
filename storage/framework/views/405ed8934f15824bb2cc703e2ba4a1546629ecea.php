
<script>
    $(function () {

        $('.select2').select2({
            placeholder: 'Select',
            // minimumInputLength: 2,
        });

        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select',
            // minimumInputLength: 2,
        });
        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });


    });




</script>
<?php echo $validator; ?>