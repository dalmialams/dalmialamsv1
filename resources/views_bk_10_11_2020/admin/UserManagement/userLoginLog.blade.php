
@extends('admin.layouts.adminlayout')
@section('content')

<!-- .page-content -->
<div class="panel panel-primary">
    <!-- Start .panel -->
    <div class="panel-body">

        {!! Form::open(['url' => url('user-management/user/loginlog'),'class' => 'form-horizontal user-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label">Select User</label>
                    <div class="col-lg-7 col-md-9">
                        {{Form::select('user_name', isset($user_list) ? $user_list : '', isset($user_id) ? $user_id : '',array('class'=>'form-control select2-minimum required'))}}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label">Date (From - To)</label>
                    <div class="col-lg-7 col-md-9">
                        <div class="input-group">
                            <div class="input-daterange input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
<!--                                    <input type="text" class="form-control" name="start" />-->
                                {{ Form::text('start_date', isset($start_date) ? $start_date : '', array('class'=>'form-control required','placeholder' => 'Start Date','id' => 'start_date')) }}
                                <span class="input-group-addon">to</span>
                                {{ Form::text('end_date', isset($end_date) ? $end_date : '', array('class'=>'form-control required','placeholder' => 'End Date','id' => 'end_date')) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End .row -->

        </div>



        <!-- End .form-group  -->


        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">          
        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Search</button>                           
                        <a href="<?= url('user-management/user/log') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        {!! Form::close() !!}
    </div>

</div>
<?php if ($userLoginData) { ?>
    <div class="row">
        <div>{!! Session::get('message')!!}</div>
        <div class="col-lg-12">
            <!-- col-lg-12 start here -->

            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">User Log</h4>
                </div>
                <div class="panel-body">
                    <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th  class="text-center">User</th>
                                <th  class="text-center">Action</th>
                                <th  class="text-center">IP</th>
                                <th  class="text-center">Time Stamp</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($userLoginData as $key => $value) {
                            ?>
                                <tr>                                           
                                    <td  class="text-center"><?= ucwords($value->getUserDetails->user_name) ?></td>
                                    <td  class="text-center"><?= $value->login_type ?></td>
                                    <td  class="text-center"><?= $value->login_ip ?></td>
                                    <td  class="text-center"><?= date('d-m-Y h:s A', strtotime($value->created_at)) ?></td>	
                            </tr>
                            <?php
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End .panel -->
        </div>
    </div>

<?php } ?>
@endsection
