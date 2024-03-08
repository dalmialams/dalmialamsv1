
<script>

    function populateDistrict(state_id) {
        var value = state_id;
        $('.append').html('');
        $(".survey_list_table").css("visibility", "hidden");
        $("#survey_id").empty();
        $('#stateList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=land_exchange&type=district_id&val=' + value + '&label_name=District', data: {'_token': '<?= csrf_token() ?>'}, destination: '.districtList'});
    }
    function populateBlock(district_id) {
        var value = district_id;
        $('.append').html('');
        $(".survey_list_table").css("visibility", "hidden");
        $("#survey_id").empty();
        $('.districtList').update({url: '<?= url('populate-dropdown') ?>?namePrefix=land_exchange&type=block_id&val=' + value + '&label_name=Block/Taluk', data: {'_token': '<?= csrf_token() ?>'}, destination: '.block-list'});
    }
    function populateVillage(block_id) {
        var value = block_id;
        $('.append').html('');
        $(".survey_list_table").css("visibility", "hidden");
        $("#survey_id").empty();
        $('.block-list').update({url: '<?= url('populate-dropdown') ?>?onchange=populateSurvey("",$(this).val())&namePrefix=land_exchange&type=village_id&val=' + value + '&label_name=Village', data: {'_token': '<?= csrf_token() ?>'}, destination: '.village-list'});
    }
    function populateSurvey(reg_id, village_id) {
        var reg_id = reg_id;
        var value = village_id;
        $('.village-list').update({url: '<?= url('transaction/land-exchange/populate-dropdown') ?>?namePrefix=land_exchange&type=survey_id&val=' + value + '&label_name=Survey No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '.survey_id'});
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

        $(".basic-datepicker").datepicker({
            autoclose: true,
            endDate: '+0d',
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

        $('body').delegate('#survey_id', 'change', function () {
            //alert($(this).val());
            var txt = $("#survey_id option:selected").text();
            var val = $("#survey_id option:selected").val();

            ///  var append_html = $('.html_to_append').html();
            $('.survey_list_table').css('visibility', 'visible');

            var append_html = ' <tr class="parent_tr">' +
                    '<td class="">' + txt + '</td>' +
                    '<td class="text-center">  {{ Form::text("transferee[]", isset($payment_data["description"]) ? $payment_data["description"] : "", array("class"=>"form-control transferee")) }}  </td>' +
                    '<td class="text-center">  <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>\n\
                      {{ Form::text("date_of_exchange[]", isset($reg_data["regn_date"]) ? $reg_data["regn_date"] :"", array("class"=>"form-control required basic-datepicker exchnge_date","placeholder" => "Date")) }}</div>  </td>' +
                    '<td class="text-center">  {{ Form::text("remarks[]", isset($payment_data["description"]) ? $payment_data["description"] : "", array("class"=>"form-control")) }}  </td>' +
                    '<td class="text-center survey_file_input"><input type="file" class="survey_file_upload" name="survey_files[]"> <div class="allowed_type_trxn">Allowed Types :pdf, mp4</div></td>' +
                    '<td class="text-center"><?php if ($id) echo 'Not Uploaded' ?></td>' +
                    '<td  class="text-center"><a  href="javascript:void(0);" title="Remove">' +
                    '<i class="ace-icon fa fa-times bigger-130  remove-survey" survey_id="' + val + '" survey_no="' + txt + '"></i>' + '</a></td>' +
                    '<input type="hidden"  name="survey_id[]" value="' + val + '">' +
                    '<input type="hidden"  name="survey_no[]" value="' + txt + '">' +
                    '</tr>';
            $('#survey_id option[value=' + val + ']').remove();
            if (txt && val) {
                $('.append').append(append_html);
            }
            $(".basic-datepicker").datepicker({
                autoclose: true,
                endDate: '+0d',
            });
        });

        $('body').delegate('.remove-survey', 'click', function () {
            //$('#survey_id option:selected').removeAttr('selected');
            $(this).parents('.parent_tr').remove();
            var survey_id = $(this).attr('survey_id');
            var survey_no = $(this).attr('survey_no');
            $('#select2-chosen-10').html('Select');
            var parent_tr_length = $('.parent_tr').length;
            // alert(parent_tr_length);
            if (parent_tr_length < 1) {
                $('.survey_list_table').css('visibility', 'hidden');
            }
            $('<option value="' + survey_id + '">' + survey_no + '</option>').appendTo('#survey_id');
        });

        $('.land-exchange-form').on('submit', function () {
            //alert('dfdssdf');
            var exchnge_date_error = 0;
            var transferee_error = 0;
            $('.exchnge_date').each(function () {
                var exchnge_date = $(this).val();
                if (!exchnge_date) {
                    exchnge_date_error++;
                    $(this).css('border-color', 'red')
                } else {
                    $(this).css('border-color', '')
                }
            });
            $('.transferee').each(function () {
                var transferee = $(this).val();
                if (!transferee) {
                    transferee_error++;
                    $(this).css('border-color', 'red')
                } else {
                    $(this).css('border-color', '')
                }
            });


            if (exchnge_date_error > 0 || transferee_error > 0) {
                return false;
            }

        });

        $('.delete-existing-survey').on('click', function () {
            var land_exchange_id = $(this).attr('land_exchange_id');
            var survey_id = $(this).attr('survey_id');

            if (!confirm("Do you want to delete")) {
                return false;
            } else {
                var delete_url = '<?= url('transaction/land-exchange/delete') ?>' + '/' + survey_id + '/' + land_exchange_id;
                window.location = delete_url;
            }
        });
        
          $('#exchange_list_table').DataTable({
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
                        "mColumns": [0, 1, 2, 3, 4, 5]
                    },
                    {
                        "sExtends": "xls",
                        "mColumns": [0, 1, 2, 3, 4, 5]
                    },
<?php
if ($user_type == 'admin' || (\App\Models\UtilityModel::ifHasPermission('land_exchange_print', $current_user_id))) {
    ?>
                        {
                            "sExtends": "print",
                            "mColumns": [0, 1, 2, 3, 4, 5]
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