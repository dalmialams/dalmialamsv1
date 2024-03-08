
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->
<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->change_pwd->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div>{!! Session::get('message')!!}</div><br>
<?php
if ($mesages) {
    foreach ($mesages as $key => $value) {
        echo $value;
    }
}
?>   

<div class="panel panel-primary">
    <!-- Start .panel -->
    <div class="panel-body">

        {!! Form::open(['url' => url('submit-change-password'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Current Password</label>
                    <div class="col-lg-7 col-md-9">
                        <input type="password" class="form-control" id="" name="password[current_password]" placeholder="Current Password">

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>New Password</label>
                    <div class="col-lg-7 col-md-9">

                        <input type="password" class="form-control" id="" name="password[new_password]" id="new_password" placeholder="New Password" onKeyUp="checkPasswordStrength();">
                    </div>

                </div>

            </div>
            <!-- End .row -->
        </div>
        <div class="col-lg-12">
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Confirm New Password</label>
                    <div class="col-lg-7 col-md-9">
                        <input type="password" class="form-control" id="" name="password[cnf_new_password]"  id="confirm_password" placeholder="Confirm New Password">
                    </div>

                </div>

            </div>
            <!-- End .row -->
        </div>


        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Save</button>                           
                        <a href="<?= url('change-password') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
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
