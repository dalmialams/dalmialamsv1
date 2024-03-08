
<script>
    function populateDistrict() {
        var value = $('.state-duallistbox').val();
        var manage_user_id = $('#manage_user_id').val();
        //alert(manage_user_id);      
        $('#stateList').update({url: '<?= url('user-management/user/populate-user-dist-dropdown') ?>?namePrefix=user&dropdown_type=dualbox&type=district_id&val=' + value + '&label_name=District Selection', data: {'_token': '<?= csrf_token() ?>', 'manage_user_id': manage_user_id}, destination: '.district_id'});

    }
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

        //------------- Dual list box -------------//
        $('.state-duallistbox').bootstrapDualListbox({
            nonSelectedListLabel: 'Select',
            selectedListLabel: 'Assigned',
            preserveSelectionOnMove: 'moved',
            moveOnSelect: true,
        });
        //------------- Dual list box -------------//
        $('.dist-duallistbox').bootstrapDualListbox({
            nonSelectedListLabel: 'Select',
            selectedListLabel: 'Assigned',
            preserveSelectionOnMove: 'moved',
            moveOnSelect: true,
        });
        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });



        var date = new Date();
        date.setDate(date.getDate() - 1);

        $("#start_date").datepicker({
            autoclose: true,
			todayHighlight: true,
            startDate: new Date()
        }).on('changeDate', function (selected) {
            var startDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', startDate);
        }).on('clearDate', function (selected) {
            $('#end_date').datepicker('setStartDate', null);
        });
//
        $("#end_date").datepicker({
            autoclose: true,
			todayHighlight: true,
            startDate: new Date()
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', endDate);
        }).on('clearDate', function (selected) {
            $('#start_date').datepicker('setEndDate', null);
        });
    });




</script>
<?php echo $validator; ?>