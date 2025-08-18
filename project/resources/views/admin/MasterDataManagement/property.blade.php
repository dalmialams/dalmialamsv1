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

    $mesages = $errors->propertyError->all();
}
?>


<div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
    <!-- Start .panel -->
    <div class="panel-heading">
        <h4 class="panel-title">Master Data - Property List</h4>
    </div>
    <div class="panel-body">
        @include('admin.MasterDataManagement.nav')
        <table id="master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th  class="text-center">No</th>
                    <th  class="text-center">Code</th>
                    <th  class="text-center"> Property Name </th>
                    <th  class="text-center"> Location </th>
                    <th  class="text-center"> Address</th>
                    <th  class="text-center"> State</th>
                    <th  class="text-center"> City </th>
                    <th  class="text-center"> Type </th>
                    <th  class="text-center"> Active </th>
                    <th  class="text-center">Action <a href="{{ url('master/property/management/add')}}" class="btn btn-info pull-right">Add</a></th>

                </tr>
            </thead>

            <tbody>
                <?php
                if ($propertyList) {
                    foreach ($propertyList as $key => $value) {
                        ?>
                        <tr>
                            <td  class="text-center"><?= ++$key ?></td>
                            <td  class="text-center"> {{ $value->propertyId ?? '' }} </td>
                            <td  class="text-center"> {{ $value->property_name ?? '' }} </td>
                            <td  class="text-center"> {{ $value->property_location?? '' }} </td>

                            <td  class="text-center"> {{$value->property_address?? '' }} </td>

                            <td  class="text-center"> {{ $value->state_name?? '' }} </td>
                                
                            </td>

                            <td  class="text-center"> {{ $value->city_name ?? '' }}
                            </td>

                            <td  class="text-center"> {{ $value->property_type ?? ''}}
                            </td>
                            
                            <td  class="text-center"> {{ isset($value->fl_archive) && $value->fl_archive == 'N' ? "Yes" : "No"}} 
                            </td>

                            <td  class="text-center">
                                <a href="{{URL::to('master/property/management/edit/'.encrypt($value->propertyId))}}"  > <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
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
<!--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>-->

@endsection
