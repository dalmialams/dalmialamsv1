
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

  $(".datepicker").datepicker( {
	 format: "dd-mm-yyyy", // Notice the Extra space at the beginning
	autoclose: true
});

  $(document).ready(function() {
        var table = $('#village_table').DataTable({});
        table.buttons().container()
            .appendTo('#village_table_wrapper .col-md-6:eq(0)');
    });
</script>
{!! $validator !!}
