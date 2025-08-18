
<script>

    function populateDistrict(state_id) {
        var value = state_id;
        $('.append').html('');
        $(".survey_list_table").css("visibility", "hidden");
        $("#survey_id").empty();
        $('#stateList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=mining_lease&type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id) {
        var value = district_id;
        $('.append').html('');
        $(".survey_list_table").css("visibility", "hidden");
        $("#survey_id").empty();
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=mining_lease&type=block_id&val=' + value + '&label_name=Block/Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    function populateVillage(block_id) {
        var value = block_id;
        $('.append').html('');
        $(".survey_list_table").css("visibility", "hidden");
        $("#survey_id").empty();
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populateSurvey("",$(this).val())&namePrefix=mining_lease&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }
    function populateSurvey(reg_id, village_id) {
        var reg_id = reg_id;
        var value = village_id;
        $('.append').html('');
        $(".survey_list_table").css("visibility", "hidden");
        var trxn_type = $('.trxn_type option:selected').val();
        //trxn_type = (trxn_type == 'Y') ? 'O' : 'N'; // Y => 'Applied' , O => Obtained
        $('.village-list').update({url: '<?= url('transaction/mining-lease/populate-dropdown') ?>?namePrefix=mining_lease&type=survey_id&val=' + value + '&label_name=Survey No.&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.survey_id'});
    }


    $(function () {
        $('.select2-minimum').select2({
            placeholder: 'Select',
            allowClear: true
        });
        $('.close').on('click', function () {
            $(this).parents('.alert-success').hide();
            $(this).parents('.alert-danger').hide();
        });

        //------------- Dual list box -------------//
        $('.duallistbox').bootstrapDualListbox({
            nonSelectedListLabel: 'Select Survey No',
            selectedListLabel: 'Assigned Survey No',
            preserveSelectionOnMove: 'moved',
            moveOnSelect: true,
        });
        $('.viewdualllistbox').bootstrapDualListbox({
            nonSelectedListLabel: 'All Survey No',
            selectedListLabel: 'Assigned Survey No',
            preserveSelectionOnMove: 'moved',
            moveOnSelect: false,
        });

        $('.mining-lease-form').on('submit', function () {
            //alert('dfdssdf');
            var go_error = 0;
            $('.go').each(function () {
                var go_val = $(this).val();
                if (!go_val) {
                    go_error++;
                    $(this).css('border-color', 'red')
                } else {
                    $(this).css('border-color', '')
                }
                // alert(go_val)
            });
            if (go_error > 0) {
                return false;
            }

        });

        $('body').delegate('#survey_id', 'change', function () {
            //alert($(this).val());
            var txt = $("#survey_id option:selected").text();
            var val = $("#survey_id option:selected").val();

            ///  var append_html = $('.html_to_append').html();
            $('.survey_list_table').css('visibility', 'visible');
            var trxn_type = $('.trxn_type option:selected').val();
            var go_html = (trxn_type == 'Y') ? '<td class="text-center">  {{ Form::text("go[]",  "", array("class"=>"form-control go")) }}  </td>' : '<td class="text-center"> {{ Form::text("go[]",  "", array("class"=>"form-control","disabled" => true)) }} </td>'
            // alert()
            var append_html = ' <tr class="parent_tr">' +
                    '<td class="">' + txt + '</td>' +
                    go_html +
                    '<td class="text-center">  {{ Form::text("remarks[]",  "", array("class"=>"form-control")) }}  </td>' +
                    '<td class="text-center survey_file_input"><input type="file" class="survey_file_upload" name="survey_files[]"> <div class="allowed_type_trxn">Allowed Types :pdf, mp4</div></td>' +
                    '<td class="text-center"><?php if ($id) echo 'Not Uploaded' ?></td>' +
                    '<td  class="text-center"><a  href="javascript:void(0);" title="Remove">' +
                    '<i class="ace-icon fa fa-times bigger-130  remove-survey" survey_id="' + val + '" survey_no="' + txt + '"></i>' + '</a></td>' +
                    '<input type="hidden"  name="survey_id[]" value="' + val + '" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus">' +
                    '<input type="hidden"  name="survey_no[]" value="' + txt + '">' +
                    '</tr>';
            $('#survey_id option[value=' + val + ']').remove();
            if (txt && val) {
                $('.append').append(append_html);
            }
        });

        $('body').delegate('.remove-survey', 'click', function () {
            //$('#survey_id option:selected').removeAttr('selected');
            $(this).parents('.parent_tr').remove();
            var survey_id = $(this).attr('survey_id');
            var survey_no = $(this).attr('survey_no');
            $('#select2-chosen-106').html('Select');
            var parent_tr_length = $('.parent_tr').length;
            if (parent_tr_length < 1) {
                $('.survey_list_table').css('visibility', 'hidden');
            }
            $('<option value="' + survey_id + '">' + survey_no + '</option>').appendTo('#survey_id');
        });



        $('.delete-existing-survey').on('click', function () {
            var mining_lease_id = $(this).attr('mining_lease_id');
            var survey_id = $(this).attr('survey_id');

            if (!confirm("Do you want to delete")) {
                return false;
            } else {
                var delete_url = '<?= url('transaction/mining-lease/delete') ?>' + '/' + survey_id + '/' + mining_lease_id;
                window.location = delete_url;
            }
        });


        $('#mining_list_table').DataTable({
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
<?php
if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('mining_lease_print', $current_user_id))) {
    ?>
                        {
                            "sExtends": "print",
                            "mColumns": [0, 1, 2, 3, 4, 5, 6, 7]
                        },
    <?php
}
?>
                ]
            }
        });


    });


</script>
<?= $validator ?>