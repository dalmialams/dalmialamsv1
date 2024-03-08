
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
    function delete_param(uniq_no, delete_id) {
        var r = confirm("Do you want to delete?");
        if (r == true) {
            window.location = '<?= url('land-details-entry/document/delete'); ?>' + '?reg_uniq_no=' + uniq_no + '&document_no=' + delete_id;
        }

        return false;
    }

</script>
<?php echo $validator; ?>

