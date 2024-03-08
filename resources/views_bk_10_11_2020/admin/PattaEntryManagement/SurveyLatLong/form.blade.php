<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->surveyLatLong->all();
}
?>
<div>{!! Session::get('message')!!}</div>
<?php if (!$viewMode) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <?php
        if ($mesages) {
            foreach ($mesages as $key => $value) {
                echo $value;
            }
        }
        ?>   
        <!-- Start .panel -->
        <div class="panel-body">
            <?php if ($reg_uniq_no) { ?>
                {!! Form::open(['url' => url('land-details-entry/survey-lat-long/submit-data'),'class' => 'form-horizontal survey-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
                <?php
                if ($surveyLists) {
                    //t($surveyLists);
                    if (!$posted_survey_id) {
                        foreach ($surveyLists as $key => $value) {
                            ?>
                            <div class="col-lg-12">
                                <div class="row ">
                                    <!-- Start .row -->
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Survey No</label>
                                        <div class="col-lg-7 col-md-9">                                                                                                                                                                                                                                                                                <!--                                        <input type="text" value="<?= $value['survey_no'] ?>" readonly="">-->
                                            {{ Form::text("surveyLatLong[survey_no][]", isset($value['survey_no']) ? $value['survey_no'] : '', array('class'=>'form-control required','placeholder' => 'Survey No','readonly' => '')) }}
                                            {{ Form::hidden("surveyLatLong[survey_id][]", isset($value['id']) ? $value['id'] : '') }}
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Lat Area</label>
                                        <div class="col-lg-7 col-md-9">
                                            <?php
                                            $lat_arr = '';
                                            $long_arr = '';
                                            if (isset($value->getGeoPosition->latlong)) {
                                                $replace = trim(str_replace(array('MULTIPOLYGON(((', ')))'), ' ', $value->getGeoPosition->latlong));
                                                $lat_long_arr = explode(",", $replace);
                                               // t($lat_long_arr);
                                                if ($lat_long_arr) {
                                                    foreach ($lat_long_arr as $l_key => $l_value) {
                                                        $arr = explode(" ", $l_value);
                                                        $lat_arr[$arr[1]] = $arr[1];
                                                        $long_arr[$arr[0]] = $arr[0];
                                                    }
                                                 //   t($lat_arr);t($long_arr);
                                                }
                                            }
                                            ?>
                                            {{ Form::select("LatLong[$key][lat][]",  (!empty($lat_arr)) ? $lat_arr : ['' => ''], '',array('data-role'=>'tagsinput','class'=>'required numbers_only_restrict','id'=>'lat_'.$key,'multiple'=>'multiple')) }}
                                            <div id="msg_container_lat_<?= $key ?>" style="color: #db5565;font-size: 13px;font-weight: normal;"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Long Area</label>
                                        <div class="col-lg-7 col-md-9">
                                            {{ Form::select("LatLong[$key][long][]",  (!empty($long_arr) )? $long_arr : ['' => ''], '',array('data-role'=>'tagsinput','id'=>'long_'.$key,'class'=>'required numbers_only_restrict', 'multiple'=>'multiple')) }}
                                            <div id="msg_container_long_<?= $key ?>" style="color: #db5565;font-size: 13px;font-weight: normal;"></div>
                                        </div>
                                    </div>


                                </div>
                                <!-- End .row -->

                            </div>                
                            <?php
                        }
                    } else {
                        $index = 0;
                        foreach ($surveyLists as $key => $value) {
                            if ($value['id'] == $posted_survey_id) {
                                ?>
                                <div class="col-lg-12">
                                    <div class="row ">
                                        <!-- Start .row -->
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Survey No</label>
                                            <div class="col-lg-7 col-md-9">

                                                                                                                                                                                                                                                                                        <!--                                        <input type="text" value="<?= $value['survey_no'] ?>" readonly="">-->
                                                {{ Form::text("surveyLatLong[survey_no][]", isset($value['survey_no']) ? $value['survey_no'] : '', array('class'=>'form-control required','placeholder' => 'Survey No','readonly' => '')) }}
                                                {{ Form::hidden("surveyLatLong[survey_id][]", isset($value['id']) ? $value['id'] : '') }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Lat Area</label>
                                            <div class="col-lg-7 col-md-9">
                                                <?php
                                                $lat_arr = '';
                                                $long_arr = '';
                                                if (isset($value->getGeoPosition->latlong)) {
                                                    $replace = trim(str_replace(array('MULTIPOLYGON(((', ')))'), ' ', $value->getGeoPosition->latlong));
                                                    $lat_long_arr = explode(",", $replace);
                                                    if ($lat_long_arr) {
                                                        foreach ($lat_long_arr as $l_key => $l_value) {
                                                            $arr = explode(" ", $l_value);
                                                            $lat_arr[$arr[1]] = $arr[1];
                                                            $long_arr[$arr[0]] = $arr[0];
                                                        }
                                                        
                                                    }
                                                    
                                                }
                                               
                                                ?>
                                                {{ Form::select("LatLong[$index][lat][]",  (!empty($lat_arr)) ? $lat_arr : ['' => ''], '',array('data-role'=>'tagsinput','class'=>'required numbers_only_restrict','id'=>'lat_'.$key,'multiple'=>'multiple')) }}
                                                <div id="msg_container_lat_<?= $key ?>" style="color: #db5565;font-size: 13px;font-weight: normal;"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Long Area</label>
                                            <div class="col-lg-7 col-md-9">
                                                {{ Form::select("LatLong[$index][long][]",  (!empty($long_arr) )? $long_arr : ['' => ''], '',array('data-role'=>'tagsinput','id'=>'long_'.$key,'class'=>'required numbers_only_restrict', 'multiple'=>'multiple')) }}
                                                <div id="msg_container_long_<?= $key ?>" style="color: #db5565;font-size: 13px;font-weight: normal;"></div>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- End .row -->

                                </div>  

                                <?php
                            }
                           
                        }
                    }
                }
                ?>



                <!-- End .form-group  -->

                <!-- End .form-group  -->

                <input type="hidden" name="surveyLatLong[registration_id]" value="<?= isset($reg_uniq_no) ? $reg_uniq_no : '' ?>">
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" value="save" name="submit_surveyLatLong" class="btn btn-success">Save</button>
                                <button type="submit" value="save_continue" name="submit_surveyLatLong" class="btn btn-primary">Save & Continue</button>
                                <?php if (count($surveyLists) > 0) { ?>
                                    <a href="<?= url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no) ?>"><button type="button" class="btn btn-warning">Skip</button></a>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-warning disabled">Skip</button>
                                <?php } ?>
                                <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                <!-- End .form-group  -->
                {!! Form::close() !!}

            <?php } else { ?>
                <div class="alert alert-warning fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="glyphicon glyphicon-warning-sign alert-icon "></i>
                    <strong>Warning!</strong> Please select a proper Registration to add this details.
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php if ($surveyLists) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <div class="panel-heading">
            <h4 class="panel-title">Survey List</h4>
        </div>
        <div class="panel-body">
            <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Survey No</th>
                        <th>Lat Long</th>


                        <?php if (!$viewMode) { ?><th> <a title="View" href="<?= url('land-details-entry/survey-lat-long/view?reg_uniq_no=' . $reg_uniq_no); ?>">
                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                </a>&nbsp;&nbsp;</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($surveyLists) {

                        foreach ($surveyLists as $key => $value) {


                            //t($value->getGeoPosition->latlong,1);
                            // die("i am here");
                            ?>
                            <tr>
                                <td><?= $value['survey_no'] ?></td>

                                <td><?php
                                    if (isset($value->getGeoPosition->latlong))
                                        echo $replace = trim(str_replace(array('MULTIPOLYGON(((', ')))'), ' ', $value->getGeoPosition->latlong));
                                    ?></td>


                                <?php if (!$viewMode) { ?>
                                    <td>
                                        <div class="action-buttons">
                                            <a title="Edit" href="<?= url('land-details-entry/survey-lat-long/add?reg_uniq_no=' . $reg_uniq_no . '&survey_no=' . $value['id']); ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>
                                            <a title="View" href="<?= url('land-details-entry/survey-lat-long/view?reg_uniq_no=' . $reg_uniq_no . '&survey_no=' . $value['id']); ?>">
                                                <i class="ace-icon fa fa-eye bigger-130"></i>
                                            </a>
                                            <a title="Delete" href="javascript:void(0);" onclick="delete_param('<?= $reg_uniq_no ?>', '<?= $value['id'] ?>');">
                                                <i class="ace-icon fa fa-times bigger-130"></i>
                                            </a>

                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>


            </table>

            <?php if ($viewMode) { ?>    
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <a href="<?= url('land-details-entry/registration/list') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


<?php } ?>



<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->
{{-- $validator --}}