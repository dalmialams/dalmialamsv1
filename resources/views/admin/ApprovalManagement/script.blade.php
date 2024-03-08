
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


      $("#datepicker").datepicker( {
    format: " yyyy", // Notice the Extra space at the beginning
    viewMode: "years", 
    minViewMode: "years",
	autoclose: true
});



        $('.delete-user').on('click', function () {

            var id = $(this).attr('id');
            if (!confirm("Do you want to delete")) {
                return false;
            } else {
                var delete_url = '<?= url('master-user/delete') ?>' + '/' + id;
                window.location = delete_url;
            }
        });
    });




</script>
{!! $validator !!}