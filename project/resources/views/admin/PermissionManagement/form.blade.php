<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->permission->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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

        {!! Form::open(['url' => url('user-management/permission/submit-data'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','permission' => 'form']) !!}

        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red">* </span>Permission Name</label>
                    <div class="col-lg-7 col-md-9">
                        {{ Form::text('permission[name]', isset($permission_data['display_name']) ? $permission_data['display_name'] : '', array('class'=>'form-control required','placeholder' => 'Permission Name')) }}
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
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Save</button>                           
                        <a href="<?= url('user-management/permission/add') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        {!! Form::close() !!}
    </div>

</div>



<?php
$userLists = '';
if ($permissions) {
    ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- col-lg-12 start here -->

            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Permission Lists</h4>
                </div>
                <div class="panel-body">
                    <table  class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>                               
                                <th>Permission Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($permissions) {
                                foreach ($permissions as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?= $value['display_name'] ?></td> 
                                        <td>  <div class="action-buttons">
                                                <a title="Edit" href="<?= url('user-management/permission/add/' . $value['id']) ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                            </div></td>

                        <!--                                        <td>
                              <a href="<?= url('user-management/user/add/' . $value['id']) ?>">Manage</a>
                          </td>-->
                                    </tr>
                                    <?php
                                }
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
