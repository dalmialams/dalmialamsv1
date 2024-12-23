<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {
    $mesages = $errors->audit->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
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

        {!! Form::open(['url' => url('user-management/audit/submit-data'),'class' => 'form-horizontal user-form','method' => 'POST', 'enctype' => 'multipart/form-data','form' => 'form']) !!}

        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Sort Order</label>
                    <div class="col-lg-7 col-md-9">
                        {{ Form::text('auditmaster[sort_order]', isset($audit_info['sort_order']) ? $audit_info['sort_order'] : '', array('class'=>'form-control required','placeholder' => 'Sort Order')) }}
                    </div>
                </div>
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Description</label>
                    <div class="col-lg-7 col-md-9">
                        {{ Form::text('auditmaster[description]', isset($audit_info['description']) ? $audit_info['description'] : '', array('class'=>'form-control required','placeholder' => 'Description')) }}
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
                        <button type="submit" value="save" name="submit_audit_master" class="btn btn-success">Save</button>                           
                        <a href="<?= url('user-management/audit/add') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
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
if ($auditMasterLists) {
    ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- col-lg-12 start here -->

            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Audit Mater Lists</h4>
                </div>
                <div class="panel-body">
                    <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>     
                                <th  class="text-center">Sort Order</th>
                                <th  class="text-center">Description</th>
                                <th  class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($auditMasterLists) {
                                foreach ($auditMasterLists as $key => $value) {
                                    ?>
                                    <tr>
                                        <td  class="text-center"><?= $value['sort_order'] ?></td>
                                        <td  class="text-center"><?= $value['description'] ?></td>
                                        <td  class="text-center">  <div class="action-buttons">
                                                <a title="Edit" href="<?= url('user-management/audit/add/' . $value['id']) ?>">
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
