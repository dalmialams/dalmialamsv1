<?php
$mesages = '';
if (isset($errors) && !empty($errors)) {

    $mesages = $errors->contact->all('<div class="alert alert-danger"><a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>:message</strong></div>');
}
?>
<div><?php echo Session::get('message'); ?></div>

<?php
    if ($mesages) {
        foreach ($mesages as $key => $value) {
            echo $value;
        }
    }
    ?>

<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
       
    <div class="panel-heading">
        <h4 class="panel-title">Contact Entry</h4>
    </div>
    <!-- Start .panel -->
    <div class="panel-body">
        
        <?php echo Form::open(['url' => url('contact/submit-data'),'class' => 'form-horizontal contact-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']); ?>


        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Name</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[name]', isset($contact_data['name']) ? $contact_data['name'] : '', array('class'=>'form-control required','placeholder' => 'Name'))); ?>

                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Desig</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[designation]', isset($contact_data['designation']) ? $contact_data['designation'] : '', array('class'=>'form-control required','placeholder' => 'Designation'))); ?>

                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Classifn</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[classification]', isset($contact_data['classification']) ? $contact_data['classification'] : '', array('class'=>'form-control required','placeholder' => 'Classification'))); ?>

                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>RTWF</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[working_field]', isset($contact_data['working_field']) ? $contact_data['working_field'] : '', array('class'=>'form-control required','placeholder' => 'Related to working field'))); ?>

                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Email id</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::email('contact[email_id]', isset($contact_data['email_id']) ? $contact_data['email_id'] : '', array('class'=>'form-control required','placeholder' => 'Email id'))); ?>

                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Mobile No.</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[mobile_no]', isset($contact_data['mobile_no']) ? $contact_data['mobile_no'] : '', array('class'=>'form-control required numbers_only_restrict','placeholder' => 'Mobile No.'))); ?>

                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Resi Tel</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[tel_no]', isset($contact_data['tel_no']) ? $contact_data['tel_no'] : '', array('class'=>'form-control required numbers_only_restrict','placeholder' => 'Residence Tel.'))); ?>

                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>Res Add</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[address]', isset($contact_data['address']) ? $contact_data['address'] : '', array('class'=>'form-control required','placeholder' => 'Residence Address'))); ?>

                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">
                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>State</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::select('contact[state_id]', isset($states) ?$states : '' , isset($contact_data['state_id']) ? $contact_data['state_id'] : '',array('class'=>'form-control select2-minimum required','onchange' => 'populateCity($(this).val())'))); ?>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group cityList">
                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>City</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::select('contact[city]', isset($city_info) ?$city_info : array('' => 'Select') , isset($contact_data['city']) ? $contact_data['city'] : '',array('class'=>'form-control select2-minimum required'))); ?>

                    </div>
                </div>
                
            </div>
            <!-- End .row -->
        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>PIN</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[pin]', isset($contact_data['pin']) ? $contact_data['pin'] : '', array('class'=>'form-control required numbers_only_restrict','placeholder' => 'PIN'))); ?>

                    </div>

                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>IMP 1 to 5</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[importance]', isset($contact_data['importance']) ? $contact_data['importance'] : '', array('class'=>'form-control required numbers_only_restrict check_only_oneinput','placeholder' => 'Importance'))); ?>

                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>EP 1 to 5</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[effective]', isset($contact_data['effective']) ? $contact_data['effective'] : '', array('class'=>'form-control required numbers_only_restrict check_only_oneinput','placeholder' => 'Effective'))); ?>

                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>REL 1 to 5</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[relationship]', isset($contact_data['relationship']) ? $contact_data['relationship'] : '', array('class'=>'form-control required numbers_only_restrict check_only_oneinput','placeholder' => 'Relationship'))); ?>

                            
                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>
        
        <div class="col-lg-12">
            <div class="row ">
                <!-- Start .row -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="col-lg-5 col-md-3 control-label"><span class="red" style="color:red">* </span>LSIC</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::text('contact[source]', isset($contact_data['source']) ? $contact_data['source'] : '', array('class'=>'form-control required','placeholder' => 'Lead source in Company'))); ?>

                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">

                    <label class="col-lg-5 col-md-3 control-label">Remarks</label>
                    <div class="col-lg-7 col-md-9">
                        <?php echo e(Form::textarea('contact[remarks]', isset($contact_data['remarks']) ? $contact_data['remarks'] : '', array('class'=>'form-control','placeholder' => 'remarks','size' => '30x3'))); ?>

                           
                    </div>

                </div>
            </div>
            <!-- End .row -->
        </div>

        

        <!-- End .form-group  -->

        <!-- End .form-group  -->
        <input type="hidden" name="contact_no" value="<?= isset($contact_no) ? $contact_no : '' ?>">
        <div class="form-group">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button type="submit" value="save" name="submit_contact" class="btn btn-success">Save</button>
                        <a href="<?= url('dashboard')?>"><button type="button" class="btn btn-danger">Cancel</button></a>
                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .form-group  -->
        <?php echo Form::close(); ?>

    </div>
    </div>


        <?php if ($contactLists) {?>
    <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
            <div class="panel-heading">
                <h4 class="panel-title">Contact Lists</h4>
            </div>
            <div class="panel-body">
                <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th  class="text-center">Name</th>
                            <th  class="text-center">Desig</th>
                            <th class="hide">Classifn</th>
                            <th  class="text-center">RTWF</th>
                            <th  class="text-center">Email id</th>                           
                            <th  class="text-center">Mobile No</th>
                            <th  class="text-center">Resi Tel</th>
                            <th class="hide">Res Add</th>
                            <th  class="text-center">State</th>
                            <th  class="text-center">City</th>
                            <th  class="text-center">PIN</th>
                            <th class="hide">IMP</th>
                            <th class="hide">EP</th>
                            <th class="hide">REL</th>
                            <th class="hide">LSIC</th>
                            <th class="hide">Remarks</th>
                            <th  class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($contactLists) {
                            foreach ($contactLists as $key => $value) {
                                ?>
                                <tr>
                                    <td  class="text-center"><?= $value['name'] ?></td>
                                    <td  class="text-center"><?= $value['designation'] ?></td>
                                    <td class="hide"><?= $value['classification'] ?></td>
                                    <td  class="text-center"><?= $value['working_field'] ?></td>
                                    <td  class="text-center"><?= $value['email_id'] ?></td>
                                    <td  class="text-center"><?= $value['mobile_no'] ?></td>
                                    <td  class="text-center"><?= $value['tel_no'] ?></td>
                                    <td class="hide"><?= $value['address'] ?></td>
                                    <td  class="text-center">
                                    <?php
                                        $state_id = trim($value['state_id']);
                                        echo $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name');
                                    ?>
                                    </td>
                                    <td  class="text-center">
                                    <?php
                                        $city_id = trim($value['city']);
                                        echo $city_name = App\Models\Common\CityModel::where(['id' => "$city_id"])->value('city_name');
                                    ?>
                                    </td>
                                    <td  class="text-center"><?= $value['pin'] ?></td>
                                    <td class="hide"><?= $value['importance'] ?></td>
                                    <td class="hide"><?= $value['effective'] ?></td>
                                    <td class="hide"><?= $value['relationship'] ?></td>
                                    <td class="hide"><?= $value['source'] ?></td>
                                    <td class="hide"><?= $value['remarks'] ?></td>
                                    <td  class="text-center">
                                        <div class="action-buttons">
                                            <a title="Edit" href="<?= url('contact?contact_no=' . $value['id']) ?>">
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

        
        <?php }?>
    


<!--<script type="text/javascript" src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>-->
<?php /* $validator */ ?>