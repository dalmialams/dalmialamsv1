<?php if ($transaction_type == 'hypothecation') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction Type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('hypothecation[trxn_type]', isset($type) ?$type : '' , '' ,array('class'=>'form-control select2-minimum trxn_type','onchange' => 'populateResistration($(this).val())'))); ?>

            </div>
        </div>  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group registration_id">
            <label class="col-lg-5 col-md-3 control-label">Registration No.</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('registration_id[]', isset($all_registrationIds) ?$all_registrationIds : '' ,  '',array('class'=>'form-control select2-minimum','multiple'=>'multiple'))); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Hypothecate With</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('hypothecation[hyp_with]', isset($hypothecate_with) ?$hypothecate_with : '' , '' ,array('class'=>'form-control select2-minimum required'))); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('hypothecation[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('hypothecation[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End .row -->
<?php } else if ($transaction_type == 'disputes') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Litigation type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('disputes[litigation_type]', isset($litigation_type) ?$litigation_type : array('' => 'Select') , '',array('class'=>'form-control select2-minimum ','onchange' => ''))); ?>

            </div>
        </div>  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Hearing Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('disputes[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('disputes[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'land_ceiling') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('land_ceiling[trxn_type]', isset($type) ?$type : array('' => 'Select') , '',array('class'=>'form-control select2-minimum trxn_type','onchange' => 'populateSurveyWithTrxnType()'))); ?>

            </div>
        </div>  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group ceiling_survey_list" id="survey-list">
            <label class="col-lg-5 col-md-3 control-label">Survey No</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('land_ceiling[survey_id]', isset($all_surveys) ?$all_surveys : '' ,  '',array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>

    </div>
    <div class="row">  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('land_ceiling[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('land_ceiling[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'land_conversion') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('land_conversion[trxn_type]', isset($type) ?$type : array('' => 'Select') , '',array('class'=>'form-control select2-minimum trxn_type','onchange' => 'populateSurveyWithTrxnType()'))); ?>

            </div>
        </div>  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group conversion_survey_list" id="survey-list">
            <label class="col-lg-5 col-md-3 control-label">Survey No</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('land_conversion[survey_id]', isset($survey_list) ?$survey_list : '' ,  '',array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>

    </div>
    <div class="row">  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('land_conversion[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('land_conversion[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'land_exchange') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transferee</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::text('land_exchange[transferee]',  '', array('class'=>'form-control','placeholder' => 'Transferee'))); ?>

            </div>
        </div>  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Exchange Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('land_exchange[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('land_exchange[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'land_inspection') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Encroachment</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('land_inspection[encroachment]', isset($encroachment_info) ?$encroachment_info : array('' => 'Select') , '',array('class'=>'form-control select2-minimum ','onchange' => ''))); ?>

            </div>
        </div>  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Encroachment Type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('land_inspection[encroachment_type]', isset($encroachment_type) ?$encroachment_type : array('' => 'Select') , '',array('class'=>'form-control select2-minimum ','onchange' => ''))); ?>

            </div>
        </div>  

    </div>
    <div class="row">  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Inspection Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('land_inspection[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('land_inspection[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'land_reservation') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('land_reservation[trxn_type]', isset($type) ?$type : array('' => 'Select') , '',array('class'=>'form-control select2-minimum trxn_type','onchange' => 'populateSurveyWithTrxnType()'))); ?>

            </div>
        </div> 
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group reservation_survey_list" id="survey-list">
            <label class="col-lg-5 col-md-3 control-label">Survey No</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('land_reservation[survey_id]', isset($survey_list) ?$survey_list : '' ,  '',array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>      
    </div>
    <div class="row"> 
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('land_reservation[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('land_reservation[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'payment') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Payment Type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('payment[payment_type]', isset($payment_type) ?$payment_type : '' , '' ,array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('payment[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('payment[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="payement_reg_list">
            <label class="col-lg-5 col-md-3 control-label">Registration No.</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('payment[registration_id]', isset($all_registrationIds) ?$all_registrationIds : '' ,  '',array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'under_operation') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Operation Type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('under_operation[operation_type]', isset($operation_type) ?$operation_type : '' , '' ,array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>  
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction  Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('under_operation[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('under_operation[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'mutation') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group old_patta_list">
            <label class="col-lg-5 col-md-3 control-label">Old Patta No.</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('mutation[patta_id]', isset($old_patta_no) ?$old_patta_no : '' , '' ,array('class'=>'form-control select2-minimum','onchange' => 'populatePattaSurvey($(this).val())'))); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group mutation_survey_list" id="survey-list">
            <label class="col-lg-5 col-md-3 control-label">Survey No</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('mutation[survey_id]', array('' => 'Select') ,  '',array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>
    </div>
    <div class="row">   
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction  Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('mutation[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('mutation[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'mining_lease') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction Type</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('mining_lease[trxn_type]', isset($type) ?$type : '' , '' ,array('class'=>'form-control select2-minimum trxn_type','onchange' => 'populateSurveyWithTrxnType()'))); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group minning_survey_list" id="survey-list">
            <label class="col-lg-5 col-md-3 control-label">Survey No</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('mining_lease[survey_id]', isset($survey_list) ?$survey_list : '' ,  '',array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>
    </div>
    <div class="row"> 
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction  Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('mining_lease[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('mining_lease[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'lease') { ?>
    <div class="row"> 
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Lease  Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('lease[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('lease[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="lease_reg_list">
            <label class="col-lg-5 col-md-3 control-label">Registration No.</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('lease[registration_id]', isset($all_registrationIds) ?$all_registrationIds : '' ,  '',array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>
    </div>
<?php } else if ($transaction_type == 'coversion_parent') { ?>
    <div class="row">                      
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="conversion_parent_list">
            <label class="col-lg-5 col-md-3 control-label">Registration No.</label>
            <div class="col-lg-7 col-md-9">
                <?php echo e(Form::select('coversion_parent[registration_id]', isset($all_registrationIds) ?$all_registrationIds : '' ,  '',array('class'=>'form-control select2-minimum'))); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
            <label class="col-lg-5 col-md-3 control-label">Transaction  Date (From - To)</label>
            <div class="col-lg-7 col-md-9">
                <div class="input-group">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo e(Form::text('coversion_parent[date_from]',  '', array('class'=>'form-control  start_date','placeholder' => 'From'))); ?>

                        <span class="input-group-addon">to</span>
                        <?php echo e(Form::text('coversion_parent[date_to]',  '', array('class'=>'form-control  end_date','placeholder' => 'To'))); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    $(".select2-minimum").select2({
        //  minimumResultsForSearch: -1,
        allowClear: true
    });
    $(".basic-datepicker").datepicker({
        autoclose: true,
    });

    $(".start_date").datepicker({
        autoclose: true,
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        $('.end_date').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('.end_date').datepicker('setStartDate', null);
    });

    $(".end_date").datepicker({
        autoclose: true,
    }).on('changeDate', function (selected) {
        var endDate = new Date(selected.date.valueOf());
        $('.start_date').datepicker('setEndDate', endDate);
    }).on('clearDate', function (selected) {
        $('.start_date').datepicker('setEndDate', null);
    });

    function populateSurveyWithTrxnType() {
        var village_id = $('#village_id option:selected').val();
        var trxn = $('.trxn option:selected').val();
        var trxn_type = $('.trxn_type option:selected').val();
        if (trxn == 'land_ceiling') {
            $('.village-list').update({url: '<?= url('transaction/land-ceiling/populate-dropdown') ?>?namePrefix=land_ceiling&type=survey_id&val=' + village_id + '&label_name=Survey No.&from_mis=true&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.ceiling_survey_list'});
        } else if (trxn == 'land_conversion') {
            $('.village-list').update({url: '<?= url('transaction/land-conversion/populate-dropdown') ?>?namePrefix=land_conversion&type=survey_id&val=' + village_id + '&label_name=Survey No.&from_mis=true&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.conversion_survey_list'});
        } else if (trxn == 'mining_lease') {
            $('.village-list').update({url: '<?= url('transaction/mining-lease/populate-dropdown') ?>?namePrefix=mining_lease&type=survey_id&val=' + village_id + '&label_name=Survey No.&from_mis=true&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.minning_survey_list'});
        } else if (trxn == 'land_reservation') {
            $('.village-list').update({url: '<?= url('transaction/land-reservation/populate-dropdown') ?>?namePrefix=land_reservation&type=survey_id&val=' + village_id + '&label_name=Survey No.&from_mis=true&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.reservation_survey_list'});
        }

    }


    $('body').delegate('#village_id', 'change', function () {
        var village_id = $(this).val();
        var trxn = $('.trxn option:selected').val();
        var trxn_type = $('.trxn_type option:selected').val();

        if (trxn == 'land_ceiling') {
            $('.village-list').update({url: '<?= url('transaction/land-ceiling/populate-dropdown') ?>?namePrefix=land_ceiling&type=survey_id&val=' + village_id + '&label_name=Survey No.&from_mis=true&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.ceiling_survey_list'});
        } else if (trxn == 'land_conversion') {
            $('.village-list').update({url: '<?= url('transaction/land-conversion/populate-dropdown') ?>?namePrefix=land_conversion&type=survey_id&val=' + village_id + '&label_name=Survey No.&from_mis=true&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.conversion_survey_list'});
        } else if (trxn == 'mining_lease') {
            $('.village-list').update({url: '<?= url('transaction/mining-lease/populate-dropdown') ?>?namePrefix=mining_lease&type=survey_id&val=' + village_id + '&label_name=Survey No.&from_mis=true&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.minning_survey_list'});
        } else if (trxn == 'land_reservation') {
            $('.village-list').update({url: '<?= url('transaction/land-reservation/populate-dropdown') ?>?namePrefix=land_reservation&type=survey_id&val=' + village_id + '&label_name=Survey No.&from_mis=true&trxn_type=' + trxn_type, data: {'_token': '<?= csrf_token() ?>'}, destination: '.reservation_survey_list'});
        } else if (trxn == 'mutation') {
            $('.village-list').update({url: '<?= url('transaction/mutation/populate-dropdown') ?>?onchange=populatePattaSurvey($(this).val())&namePrefix=mutation&type=patta_id&val=' + village_id + '&from_mis=true&label_name=Old Patta No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '.old_patta_list'});
        } else if (trxn == 'coversion_parent') {
            $('.village-list').update({url: '<?= url('populate-dropdown') ?>?namePrefix=coversion_parent&type=registration_id&parentConv=con_parent&val=' + village_id + '&from_mis=true&label_name=Registration No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '#conversion_parent_list'});
        } else if (trxn == 'lease') {
            $('.village-list').update({url: '<?= url('populate-dropdown') ?>?namePrefix=lease&parentConv=lease&type=registration_id&val=' + village_id + '&from_mis=true&label_name=Registration No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '#lease_reg_list'});
        } else if (trxn == 'payment') {
            $('.village-list').update({url: '<?= url('populate-dropdown') ?>?namePrefix=payment&type=registration_id&val=' + village_id + '&from_mis=true&label_name=Registration No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '#payment_reg_list'});
        } else if (trxn == 'hypothecation') {
            $('.village-list').update({url: '<?= url('populate-dropdown') ?>?namePrefix=hypothecation&multiple=true&parentConv=hypothecate&type=registration_id&val=' + village_id + '&from_mis=true&label_name=Registration No.', data: {'_token': '<?= csrf_token() ?>'}, destination: '.registration_id'});
        }

    });
</script>