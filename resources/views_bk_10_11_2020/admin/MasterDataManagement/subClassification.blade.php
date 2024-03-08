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

    $mesages = $errors->sub_classificationError->all();
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

    <div class="panel-body">
        @include('admin.MasterDataManagement.nav')
        <table id="master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th  class="text-center">No</th>
                    <th  class="text-center">Code </th>
                    <th  class="text-center">Classification</th>

                    <th  class="text-center">Sub Classification</th>

                    <th  class="text-center">Active</th>
                    <th  class="text-center">Action <a href="{{ url('master/sub_classification/management/add')}}" class="btn btn-info pull-right">Add</a></th>

                </tr>
            </thead>
<!--                    <tfoot>
                <tr>
                    <th  class="text-center">No</th>
                    <th  class="text-center">State</th>
                    <th  class="text-center">District</th>
                    <th  class="text-center">Block</th>
                    <th  class="text-center">Action</th>
                </tr>
            </tfoot>-->
            <tbody>
                <?php
                if ($sub_classificationList) {
                    foreach ($sub_classificationList as $key => $value) {
                        ?>
                        <tr>
                            <td  class="text-center"><?= ++$key ?></td>
                            <td  class="text-center"><?php
                                echo $value->id;
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                if (isset($value->getClassification)) {
                                    echo $value->getClassification->cd_desc;
                                }
                                ?>
                            </td>

                            <td  class="text-center"><?php
                                echo $value->sub_name;
                                ?>
                            </td>
                            <td  class="text-center"><?php
                                echo ($value->fl_archive == 'N') ? "Yes" : "No";
                                ?>
                            </td>
                            <td  class="text-center"><a href="{{URL::to('master/sub_classification/management/edit/'.$value->id)}}"   > <i class="ace-icon fa fa-pencil bigger-130"></i></a></td>

                        </tr>
                        <?php
//                                  t( $value->getDistrict->district_name,1);;
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</div>
<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->

@endsection
