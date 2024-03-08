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

    $mesages = $errors->blockError->all();
}
?>
<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
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

</div>

<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-heading">
        <h4 class="panel-title"></h4>
    </div>
    {!! Form::open(['url' => url('folder/browser'),'class' => 'form-horizontal document-form','method' => 'POST', 'enctype' => 'multipart/form-data','role' => 'form']) !!}       
    <div class="panel-body">
      
        <!--<input type="text" name="folder[folderPath]" value="" class="form-control" />-->
<!--        <span class="input-group-btn">
            <a data-fancybox-type="iframe" href="{{ route('mediabrowser', array('folder', 'sss')) }}" class="btn btn-default mediabrowser-js" type="button"><span class="glyphicon glyphicon-folder-open"></span></a>
        </span>-->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" id="stateList">

                    <label class="col-lg-2 col-md-3 control-label">Path</label>
                    <div class="col-lg-10 col-md-9">
                      {{ Form::text('folder[folderPath]',   '', array('class'=>'form-control required','placeholder' => 'Past the path')) }}
                    </div>

                </div>
          <div class="form-group">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">

                      
                        <button type="submit" value="save" name="save_reg" class="btn btn-success">Save</button>



                    </div>
                </div>
                <!-- End .row -->
            </div>
        </div>
    </div>
     {!! Form::close() !!}
</div>
<?php if(isset($filePathList)) {?>
    <div class="panel panel-default toggle panelMove panelClose panelRefresh">
                                    <!-- Start .panel -->
                                    <div class="panel-heading">
                                        <h4 class="panel-title">List group with links</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="list-group">
                                            <?php 
                                            foreach($filePathList as $key=>$val){
                                                $errorMessage='';
                                                 $errorClass='';
//                                                 t($pathError[$key]);
                                                if(!empty($pathError[$key])){
                                                    $errorMessage=implode(',',$pathError[$key]);
                                                    $errorClass='list-group-item-danger';
                                                }
                                            ?>
                                            <a href="#" class="list-group-item <?=$errorClass ?>"><?= $val ,' [ ',$errorMessage,' ]'?></a>
                                            
                                            <?php } ?>
                                         
                                        </div>
                                    </div>
                                </div>


<?php }?>




@endsection