<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->form->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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

        <?php echo Form::open(['url' => url('user-management/form/submit-data'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','form' => 'form']); ?>


        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Sort Order</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('form[sort_order]', isset($form_data['sort_order']) ? $form_data['sort_order'] : '', array('class'=>'form-control required','placeholder' => 'Sort Order'))); ?>

                    </div>
                </div>
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Form Name</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('form[form_name]', isset($form_data['form_name']) ? $form_data['form_name'] : '', array('class'=>'form-control required','placeholder' => 'Form Name'))); ?>

                    </div>
                </div>



            </div>
            <div class="row">
                <!-- Start .row -->


                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Access Rights</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('form[access_rights]', isset($form_data['access_rights']) ? $form_data['access_rights'] : '', array('class'=>'form-control required','placeholder' => 'Access Rights'))); ?>

                        <small>Enter as: X,A,E,V,D,S,P</small>
                    </div>

                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Status</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::select('form[status]', isset($status) ? $status : '', isset($form_data['status']) ? $form_data['status'] : '',array('class'=>'form-control select2-minimum required'))); ?>

                    </div>

                </div>


            </div>
            <div class="row">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label">Group</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::select('form[group]', ['' => 'Select','registration' => 'Registration' ,'transaction' => 'Transaction','patta' => 'Patta', 'master data' => 'Master Data'], isset($form_data['group']) ? $form_data['group'] : '',array('class'=>'form-control select2-minimum required'))); ?>

                    </div>

                </div>


            </div>

        </div>

        <!-- End .form-group  -->
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">          
        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_user" class="btn btn-success">Save</button>                           
                        <a href="<?= url('user-management/form/add') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
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
if ($forms) {
    ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- col-lg-12 start here -->

            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Form Lists</h4>
                </div>
                <div class="panel-body">
                    <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>     
                                <th  class="text-center">Sort Order</th>
                                <th  class="text-center">Form Name</th>
                                <th  class="text-center">Group Name</th>
                                <th class="text-center">Access Rights</th>
                                <th  class="text-center">Status</th>                               
                                <th  class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($forms) {
                                foreach ($forms as $key => $value) {
                                    ?>
                                    <tr>
                                        <td  class="text-center"><?= $value['sort_order'] ?></td>
                                        <td  class="text-center"><?= $value['form_name'] ?></td>
                                        <td  class="text-center"><?= ucfirst($value['group']) ?></td>
                                        <td  class="text-center"><?= $value['access_rights'] ?></td>
                                        <td  class="text-center"><?= $value['status'] == 'Y' ? '<span class="label label-success mr10 mb10">Active</span>' : '<span class="label label-warning mr10 mb10">Inactive</span>' ?></td>                                                                                
                                        <td  class="text-center">  <div class="action-buttons">
                                                <a title="Edit" href="<?= url('user-management/form/add/' . $value['id']) ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
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
