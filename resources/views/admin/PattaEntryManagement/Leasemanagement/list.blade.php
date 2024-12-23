
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->
<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="panel panel-primary  toggle panelMove">            
            <div class="panel-heading">
                <h4 class="panel-title">Search Screen</h4>
            </div>
            <div class="panel-body">
                {!! Form::open(['url' => url('lease-management/list'),'class' => 'form-horizontal reg-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']) !!}

                <div class="col-lg-12">
                    <div class="row ">
                      
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Lease Agreement Date</label>
                            <div class="col-lg-7 col-md-9">
                                <div class="input-group paymentValidate">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {{ Form::text('lease[lease_agreement_date]', isset($lease_data['lease_agreement_date']) ? $lease_data['lease_agreement_date'] : '', array('class'=>'form-control required','placeholder' => 'Lease Agreement Date','id'=>'basic-datepicker')) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                            <label class="col-lg-5 col-md-3 control-label">Lease Period (From - To)</label>
                            <div class="col-lg-7 col-md-9">
                                <div class="input-group">
                                    <div class="input-daterange input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          
                                        {{ Form::text('lease[lease_start_date]', isset($lease_data['lease_start_date']) ? $lease_data['lease_start_date'] : '', array('class'=>'form-control required','placeholder' => 'Start Date')) }}
                                        <span class="input-group-addon">to</span>
                                        {{ Form::text('lease[lease_end_date]', isset($lease_data['lease_end_date']) ? $lease_data['lease_end_date'] : '', array('class'=>'form-control required','placeholder' => 'End Date')) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                </div>

                                  
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <button type="submit" value="search" name="search_reg" class="btn btn-success">Search</button>
                                <a href="<?= url('lease-management/list') ?>"><button type="button" class="btn btn-warning">Reset</button></a>
                            </div>
                        </div>
                                                       
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            
        </div>


        <?php if (isset($lease) && !empty($lease)) { ?>
            <div class="panel panel-primary">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Search Result</h4>
                </div>
                <div class="panel-body">
                    <table id="lease_lists_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Lease Unique Id</th>
    <!--                            <th class="hide">Survey No</th>-->
                                <th>Survey No</th>                            
                                <th>Name of Lease</th>
                                <th>Name of Lessor</th>
                                <th>Total Area</th>                           
                                <th>Monthly lease rent amount</th>
                                <th>Agreement Date</th>
                                <th>Period (From - To)</th>
                                <th>Percentage of Escalation</th>
                                <th>Location of land</th>
                                <!--<th>Unit</th>-->
                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($lease as $key => $value) {
                                $tot_area_unit = $value['tot_area_unit'];
                                $tot_area_unit_value = App\Models\Common\ConversionModel::where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->value('convers_value');
                                ?>
                                <tr>
                                    <td><a href="<?= url('lease-management/view/'.$value['id']) ?>"><?= $value['id'] ?></a></td> 
                                    <td><?= $value['survey_no'] ?></td> 
                                    <td><?= $value['lease_name'] ?></td> 
                                    <td><?= $value['lessor_name'] ?></td> 
                                    <td style="text-align: right;" class="all_total_area"><?= $value['tot_area'] * $tot_area_unit_value ?></td> 
                                    <td style="text-align: right;" class="all_total_cost"><?= $value['lease_monthly_amount'] ?></td> 
                                    <td><?= date('d/m/Y', strtotime($value['lease_agreement_date'])) ?></td> 
                                    <td><?= date('d/m/Y', strtotime($value['lease_start_date'])) . ' to ' . date('d/m/Y', strtotime($value['lease_end_date'])) ?></td> 
                                    <td style="text-align: right;"><?= $value['percentage_escalation'], '%' ?></td> 
                                    <td><?= $value['land_location'] ?></td> 

                                    <td>
                                        <div class="action-buttons">
                                            <a title="Edit" href="<?= url('lease-management/add/' . $value['id']) ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
        <!-- End .panel -->
    </div>
</div>


@endsection
