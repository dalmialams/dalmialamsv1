<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

@extends('admin.layouts.adminlayout')
@section('content')

<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->codeError->all();
}
?>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <div class="panel-heading">
        <h4 class="panel-title"></h4>
    </div>
    <?php
    if ($mesages) {
        foreach ($mesages as $key => $value) {
            ?>
            <div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong><?php echo $value; ?>!</strong></div>

            <?php
        }
    }
    ?>   
    <div>{!! Session::get('message')!!}</div>
    <!-- Start .panel -->
    <div class="panel-body">
        {{--@include('admin.MasterDataManagement.nav')--}}

        {!! Form::open(['url' => url('master/code/submit-data'),'class' => 'form-horizontal reg-form','method' => 'POST','id'=>'my-form', 'enctype' => 'multipart/form-data','role' => 'form']) !!}


        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->


                <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-2 col-md-3 control-label">Code Value</label>
                    <div class="col-lg-10 col-md-9">
                        <?php
                        if (Session::has('data'))
                            $data = Session::get('data');
                        ?>
                        {{ Form::hidden('code[cd_type]', isset($codeDetails['cd_type']) ? $codeDetails['cd_type'] : $data, array('class'=>'form-control required','placeholder' => 'Code Description')) }}
                        {{ Form::text('code[cd_desc]', isset($codeDetails['cd_desc']) ? $codeDetails['cd_desc'] : '', array('class'=>'form-control required','placeholder' => 'Code Description')) }}
                    </div>
                </div>
                <?php if ($data == 'area_unit') { ?>
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-2 col-md-3 control-label">Code Conversion (Acre)</label>
                        <div class="col-lg-10 col-md-9">

                            {{ Form::text('convers[convers_value_acer]', isset($codeDetails->getConvers->convers_value_acer) ? $codeDetails->getConvers->convers_value_acer : 0, array('class'=>'form-control required','placeholder' => 'convers value acre')) }}
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 form-group">
                        <label class="col-lg-2 col-md-3 control-label">Code Conversion (Hectare)</label>
                        <div class="col-lg-10 col-md-9">
                            {{ Form::text('convers[convers_value_heactor]', isset($codeDetails->getConvers->convers_value_heactor) ? $codeDetails->getConvers->convers_value_heactor : 0, array('class'=>'form-control required','placeholder' => 'convers hectare')) }}
                        </div>

                    </div>
                <?php } ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-2 col-md-3 control-label">Active</label>
                    <div class="col-lg-10 col-md-9">
                        {{Form::select('code[cd_fl_archive]', ['N'=>'Yes','Y'=>'No'] , isset($codeDetails['cd_fl_archive']) ? $codeDetails['cd_fl_archive'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateDistrict($(this).val(),"village")'))}}
                    </div>

                </div>
                <?php if ($data == 'purchaser_name') { ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" id="stateList">

                        <label class="col-lg-2 col-md-3 control-label">Subsidiary</label>
                        <div class="col-lg-10 col-md-9">
                            {{Form::select('code[subsidiary]', ['N'=>'No','Y'=>'Yes'] , isset($codeDetails['subsidiary']) ? $codeDetails['subsidiary'] : '',array('class'=>'form-control select2-minimum required'))}}
                        </div>

                    </div>
                <?php } ?>
            </div>

        </div>
        <!--        <div class="col-lg-12">
                    <div class="row ">
                       
                      
                      
                    </div>
                   
                </div>
        -->





        <!-- End .form-group  -->

        <!-- End .form-group  -->
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">

        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">

                        <a href="<?= /* redirect('master/block/management')->with('data','CD00153') */url('master/code/management/null/' . $data) ?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                        <button type="submit" value="save" name="save_reg" class="btn btn-success">Save</button>



                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>

        <!-- End .form-group  -->
        {!! Form::close() !!}
    </div>
</div>



@endsection
