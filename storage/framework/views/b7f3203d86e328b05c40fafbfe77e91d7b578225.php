<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->user->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div><?php echo Session::get('message'); ?></div><br>
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

        <?php echo Form::open(['url' => url('master-user/submit-data'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','user' => 'form']); ?>


        <div class="col-lg-12">
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Name</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('user[name]', isset($user_data['name']) ? $user_data['name'] : '', array('class'=>'form-control required','placeholder' => 'Name'))); ?>

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Email</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('user[email]', isset($user_data['email']) ? $user_data['email'] : '', array('class'=>'form-control required','placeholder' => 'Email'))); ?>

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
                        <a href="<?= url('user-management/user/add') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        <?php echo Form::close(); ?>

    </div>

</div>



<?php
//$users = '';
if ($users) {
    ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- col-lg-12 start here -->

            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">User Lists</h4>
                </div>
                <div class="panel-body">
                    <table id="tabletools"  class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>                               
                                <th  class="text-center">Name</th>
                                <th  class="text-center">Email</th>
                                <th  class="text-center">Assigned</th>
                                <th  class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($users) {
                                foreach ($users as $key => $value) {
                                    ?>
                                    <tr>
                                        <td  class="text-center"><?= $value['name'] ?></td>
                                        <td  class="text-center"><?= $value['email'] ?></td>
                                        <td  class="text-center"><?= $value['assigned'] == 'N' ? '<span class="label label-success mr10 mb10">Yes</span>' : '<span class="label label-warning mr10 mb10">No</span>' ?></td>
                                        <td  class="text-center">  <div class="action-buttons">
                                                <?php
                                                if (!$value['assigned']) {
                                                    ?>
                                                    <a title="Edit" href="<?= url('master-user/add/' . $value['id']) ?>">
                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>&nbsp;
                                                    <a title="Remove" href="javascript:void(0);">
                                                        <i id="<?= $value['id'] ?>"  class="ace-icon fa fa-times bigger-130  delete-user"></i>
                                                    </a>
                                                <?php } ?>
                                            </div>
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

            <!-- End .panel -->
        </div>
    </div>
<?php } ?>
