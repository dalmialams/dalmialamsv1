
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


    });
    function delete_param(type,delete_id) {
        var r = confirm("Do you want to delete?");
        if (r == true) {
            window.location = '<?= url('document-management/document/shape-file-remove'); ?>/' + type +'/'+ delete_id;
        }

        return false;
    }

  $(".datepicker").datepicker( {
	 format: "dd-mm-yyyy", // Notice the Extra space at the beginning
	autoclose: true
});
</script>
<?php echo $validator; ?>

