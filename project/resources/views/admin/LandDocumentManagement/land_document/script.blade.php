
<script>


    $(function () {
        $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select',
            // minimumInputLength: 2,
        });
        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });
       
         $('#land_doc_list_table').DataTable({
                 searching: false
            
        });

      


    });


</script>
<?= $validator ?>