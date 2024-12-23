<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->inspection->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div>{!! Session::get('message')!!}</div>
<?php
if ($mesages) {

    foreach ($mesages as $key => $value) {
        echo $value;
    }
}
?>   
<?php if (!$viewMode) { ?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
        <!-- Start .panel -->
        <div class="panel-body">
            {!! Form::open(['url' => url('transaction/inspection/submit-data'),'class' => 'form-horizontal lease-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}


            <div class="col-lg-12">
                <div class="row ">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('inspection[state_id]', isset($states) ?$states : '' , isset($inspection_data['state_id']) ? $inspection_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val())'))}}
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group districtList">

                        <label class="col-lg-5 col-md-3 control-label">District</label>
                        <div class="col-lg-7 col-md-9">                       
                            {{Form::select('inspection[district_id]', isset($district_info) ?$district_info : array('' => 'Select') , isset($inspection_data['district_id']) ? $inspection_data['district_id'] : '',array('class'=>'form-control select2-minimum','onchange' => 'populateBlock($(this).val())'))}}
                        </div>

                    </div>

                </div>
                <!-- End .row -->

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group block-list">
                        <label class="col-lg-5 col-md-3 control-label">Block/Taluk</label>
                        <div class="col-lg-7 col-md-9">  

                            {{Form::select('inspection[block_id]', isset($block_info) ?$block_info : array('' => 'Select') , isset($inspection_data['block_id']) ? $inspection_data['block_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateVillage($(this).val())'))}}
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group village-list">
                        <label class="col-lg-5 col-md-3 control-label">Village</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('inspection[village_id]', isset($village_info) ? $village_info : array('' => 'Select') , isset($inspection_data['village_id']) ? $inspection_data['village_id'] : '',array('class'=>'form-control select2-minimum ','onchange' => 'populateSurvey("",$(this).val())'))}}
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group survey-list">
                        <label class="col-lg-5 col-md-3 control-label">Survey no.</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('inspection[survey_id]', isset($survey_info) ? $survey_info : array('' => 'Select') , isset($inspection_data['village_id']) ? $inspection_data['village_id'] : '',array('class'=>'form-control select2-minimum '))}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Date</label>
                        <div class="col-lg-7 col-md-9">
                            <div class="input-group paymentValidate">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                {{ Form::text('inspection[insp_date]', isset($inspection_data['insp_date']) ? $inspection_data['insp_date'] : '', array('class'=>'form-control required','placeholder' => 'Date','id'=>'basic-datepicker')) }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Encroachment</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('inspection[encroachment]', isset($encroachment_info) ? $encroachment_info : array('' => 'Select') , isset($inspection_data['encroachment']) ? $inspection_data['encroachment'] : '',array('class'=>'form-control select2-minimum ','onchange'=>'validateform($(this).find("option:selected").text())'))}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Encroachment Type</label>
                        <div class="col-lg-7 col-md-9">
                            {{Form::select('inspection[encroachment_type]', isset($encroachment_type) ? $encroachment_type : array('' => 'Select') , isset($inspection_data['encroachment_type']) ? $inspection_data['encroachment_type'] : '',array('class'=>'form-control select2-minimum ','onchange'=>'validateform1($(this).find("option:selected").text())'))}}
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label">Remarks</label>
                        <div class="col-lg-7 col-md-9">
                            {{ Form::textarea('inspection[description]', isset($inspection_data['description']) ? $inspection_data['description'] : '', array('class'=>'form-control','placeholder' => 'Remarks','size' => '30x3')) }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-5 col-md-3 control-label" for="">Doc Upload</label>
                        <div class="col-lg-7 col-md-9">
                            <input type="file" name="doc_file[]" class="filestyle" data-buttonText="Add file" data-buttonName="btn-danger" data-iconName="fa fa-plus" multiple="multiple">
                            <small>Allowed Types :pdf, mp4, jpeg</small>
                        </div>
                    </div>

                </div>

            </div>


            <!-- End .form-group  -->
            <input type="hidden" name="id" value="<?= isset($inspection_no) ? $inspection_no : '' ?>">

            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="submit" value="save" name="save_inspection" class="btn btn-success disabled">Save</button>                           
                            <a href="<?= url('dashboard') ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </div>
            {!! Form::close() !!}

        </div>

    </div>
<?php } ?>
<?php if (isset($inspectionLists) && !empty($inspectionLists)) { ?>
    <div class="panel panel-primary">
        <!-- Start .panel -->
        <div class="panel-heading">
            <h4 class="panel-title">Inspection List</h4>
        </div>
        <div class="panel-body">
            <table id="inspection_list_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th  class="text-center">Inspection ID No</th>                               
                        <th  class="text-center">State</th>
                        <th  class="text-center hidden">District</th>
                        <th  class="text-center hidden">Taluk</th>                           
                        <th  class="text-center">Village</th>                           
                        <th  class="text-center">Survey No.</th>                           
                        <th  class="text-center">Date</th>                           
                        <th  class="text-center">Encroachment</th>                           
                        <th  class="text-center">Encroachment Type</th>                           
                        <th  class="text-center">Remarks</th>                           
                        <th  class="text-center">Uploaded Document</th>                           
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($inspectionLists) {
                        foreach ($inspectionLists as $key => $value) {
                            $idModal = 'mySmallModal' . $key;
                            //t($value);die();
                            ?>
                            <tr>
                                <td  class="text-center"><?= $value['id'] ?></td>
                                <td  class="text-center"><?php
                                    $state_id = trim($value['state_id']);
                                    echo $state_id ? $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name') : '';
                                    ?>
                                </td>
                                <td  class="text-center hidden">
                                    <?php
                                    $dist_id = trim($value['district_id']);
                                    echo ($dist_id) ? $dist_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name') : '';
                                    ?>
                                </td>
                                <td  class="text-center hidden"> <?php
                                    $block_id = trim($value['block_id']);
                                    echo ($block_id) ? $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name') : '';
                                    ?>
                                </td>
                                <td  class="text-center"><?php
                                    $village_id = trim($value['village_id']);
                                    echo ($village_id) ? $village_name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name') : '';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $allSurveyId = explode(',', $value['survey_id']);
                                    if ($allSurveyId) {
                                        echo '<ul>';
                                        foreach ($allSurveyId as $val) {
                                            echo ($val) ? '<li>' . $survey_name = App\Models\LandDetailsManagement\SurveyModel::where(['id' => "$val"])->value('survey_no') . '</li>' : '';
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                </td>
                                <td  class="text-center"><?= date('d/m/Y', strtotime($value['insp_date'])); ?></td>
                                <td  class="text-center"><?= $value['encroachment'] == 'Y' ? 'Yes' : 'No'; ?></td>
                                <td  class="text-center">
                                    <?php
                                    $encroachment_type = trim($value['encroachment_type']);
                                    echo $encroachment_type_name = App\Models\Common\CodeModel::where(['id' => "$encroachment_type"])->value('cd_desc');
                                    ?>
                                </td>
                                <td  class="text-center"><?= $value['description']; ?></td>
                                <td class="text-center">

                                    <?php
                                    if ($value['documentDteails']) {
                                        foreach ($value['documentDteails']as $keydoc => $valdoc) {
                                            ?>


                                            <?php
                                            $file_path = isset($valdoc['path']) ? $valdoc['path'] : '';
                                            $file_path = str_replace('\\', '/', $file_path);
                                            $file_name = stristr($file_path, '/');
                                            $file_type = $valdoc['file_type'];
                                            if (file_exists($file_path)) {
                                                if ($file_type == 'mp4' || $file_type == 'ogg') {
                                                    $id = 'myModal' . $valdoc['id'];
                                                    ?>
                                                    <button class="btn btn-default mr5 mb10" data-toggle="modal" data-target="#<?= $id ?>" style="margin-top: 10px;"><?= str_replace("/", "", $file_name) ?></button>
                                                    <div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                                    </button>
                                                                    <h4 class="modal-title" id="myModalLabel2"><?= str_replace("/", "", $file_name) ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>
                                                                        <video width="560" height="400" controls>
                                                                            <source src="<?= url($file_path) . '?viewMode=' . $viewMode ?>" type="video/<?= $file_type ?>">
                                                                        </video> 
                                                                    </p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } elseif ($file_type == 'jpg' || $file_type == 'jpeg') {
                                                    $imgid = 'myModal' . $valdoc['id'];
                                                    ?>
                                                    <button class="btn btn-default mr5 mb10" data-toggle="modal" data-target="#<?= $imgid ?>"><?= str_replace("/", "", $file_name) ?></button>
                                                    <div class="modal fade" id="<?= $imgid ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                                    </button>
                                                                    <h4 class="modal-title" id="myModalLabel2"><?= str_replace("/", "", $file_name) ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>
                                                                        <img src="<?= url($file_path); ?>" width="100%" height="100%">
                                                                    </p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else {
                                                    $file_path = 'ViewerJS/#../' . $file_path;
                                                    ?>
                                                    <a href="javascript:void(0);"  onclick=" win = window.open('<?= url($file_path) . '?viewMode=' . $viewMode ?>', '_blank', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1024,height=768');
                                                                                        win.location"><button class="btn btn-default"><?= str_replace("/", "", $file_name) ?></button>&nbsp</a>
                                                       <?php /* str_replace("/", "", $file_name) */ ?>
                                                       <?php
                                                   }
                                               } else {
                                                   ?>
                                                <!--Document does not exist-->
                                            <?php } ?>



                                            <?php
                                        }
                                    } else {
//                                        echo 'Not exist';
                                    }
                                    ?>

                                </td>


                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>

            </table>

        </div>
    </div>
<?php } ?>
