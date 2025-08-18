
<script>

    
    $(function () {
        $(".basic-datepicker").datepicker();
            
            $('.select2-minimum').select2({
            theme: "classic",
            placeholder: 'Select',
            // minimumInputLength: 2,
        });
            $('.close').on('click', function () {
                $(this).parents('.alert-success').hide();
                $(this).parents('.alert-danger').hide();
            });

        $('#land_document_list_table').DataTable({
                "oLanguage": {
                "sSearch": "",
                        "sLengthMenu": "<span>_MENU_</span>"
                },
            "sDom": "T<'row'<'col-md-6 col-xs-12 'l><'col-md-6 col-xs-12'f>r>t<'row'<'col-md-4 col-xs-12'i><'col-md-8 col-xs-12'p>>",
            tableTools: {
            "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf",
                    "aButtons": [
                    {
                    "sExtends": "csv",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    {
                    "sExtends": "xls",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    {
                    "sExtends": "print",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
                    },
    
                ]
            }
        });


    });

    function delete_param(delete_id) {

        var r = confirm("Do you want to delete?");
        if (r == true) {
            $.ajax({
                url: '<?= url('land-details-entry/land-document/delete') ?>',
                method: 'POST',
                data: {
                    land_doc_id: delete_id,
                    _token: '<?= csrf_token() ?>'
                },
                success: function(response) {
                    if(response.status == 'success') {
                        alert(response.message);
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('populateCity AJAX error:', status, error);
                }
            });

            return false;
        }
        else {
            return false;
        }
    }

</script>
<?php /**PATH C:\wamp64\www\dalmia_lams\resources\views/admin/LandDocumentManagement/land_document/listscript.blade.php ENDPATH**/ ?>