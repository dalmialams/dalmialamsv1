
<script>

    function populateDistrict(state_id) {
        var value = state_id;
        $('#stateList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=disputes&type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id) {
        var value = district_id;
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=disputes&type=block_id&val=' + value + '&label_name=Block/Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    function populateVillage(block_id) {
        var value = block_id;
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populateSurvey("",$(this).val())&namePrefix=disputes&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }
    function populateSurvey(reg_id, village_id) {
        var reg_id = reg_id;
        var value = village_id;
        $('.village-list').update({url: '<?= url('transaction/disputes/populate-dropdown') ?>?namePrefix=disputes&multiple=true&type=survey_id&val=' + value + '&label_name=Survey No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '.survey-list'});
    }

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
        
        $(".basic-datepicker").datepicker({ format: "d/m/yyyy",todayHighlight: true,autoclose: true });
    });
    
    
    function validateform(text){
        if(text == 'No'){
            $('button[name="save_inspection"]').removeClass( "disabled" );
            $('select[name="inspection[encroachment_type]"]').select2("enable",false);
        }else{
            $('button[name="save_inspection"]').addClass( "disabled" );
            $('select[name="inspection[encroachment_type]"]').select2("enable",true);
        }
    }
    function validateform1(text){
        if(text==''||text=='select'){
            $('button[name="save_inspection"]').addClass( "disabled" );
        }else{
            $('button[name="save_inspection"]').removeClass( "disabled" );
        }
    }




</script>
{!! $validator !!}