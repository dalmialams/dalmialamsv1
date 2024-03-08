
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->
<section>
    <div class="container">
        <div class="row">
            <!-- col-md-6 end here -->
            <div class="col-md-6 text-left">
                <!-- col-md-6 start here -->
                <ul class="breadcrumb">
                    <li><a href="<?php echo url('dashboard');?>">Dashboard</a></li>
                    <?= $breadcum;?>
                    <li class="active"><?php echo isset($filter) ? $filter : ''?></li>
                </ul>
            </div>
            <!-- col-md-6 end here -->
        </div>
        <!-- / .row -->
    </div>
</section>
<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        
        
        <div class="panel panel-primary">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Dashboard</h4>
            </div>
            <div class="panel-body">
                {!! Form::open(['url' => url('dashboard/legalentity'),'class' => 'form-horizontal dash-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
                    <div class="col-lg-12">
                        <?php if(isset($block_id)){ ?><input type="hidden" name="block_id" value="<?= isset($block_id) ? $block_id : '' ?>"><?php }?>
                        <div class="row ">
                            <!-- Start .row -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group" id="stateList">

                                <label class="col-lg-5 col-md-3 control-label">Selection Criteria</label>
                                <div class="col-lg-7 col-md-9">
                                    {{Form::select('filter', array(''=>'Select','Classification'=>'Classification','Plot Type'=>'Plot Type','Purchasing Team'=>'Purchasing team','Purchase Type'=>'Purchase Type','Purpose'=>'Purpose') , isset($filter) ? $filter : '',array('class'=>'form-control select2-minimum','onchange'=>'this.form.submit()'))}}
                                </div>

                            </div>
                        </div>
                        <!-- End .row -->
                    </div>
                {!! Form::close() !!}

                <table id="tabletools1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th  class="text-center">Legal Entity</th>
                            <th  class="text-center">Purchased Area (Acre)</th>
                            <th  class="text-center">Purchased Area (Hectare)</th>
                            <th  class="text-center">% of Total</th>
                            <th  class="text-center">Total Cost</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                            $grandTotalCost = 0;
                            $grandTotalAreaAcre = 0;
                            $grandTotalAreaHector = 0;
                        if ($RegDataWithState) {
                            
                            foreach ($RegDataWithState as $key => $value) {
                                if($value['grand_total_tot_cost']){
                                    $grandTotalCost += $value['grand_total_tot_cost'];
                                    $grandTotalAreaAcre += $value['grand_total_tot_area_acer'];
                                    $grandTotalAreaHector += $value['grand_total_tot_area_hector'];
                                ?>
                                <tr>
                                    <td  class="text-center">
                                        <?php if($filter==''){?>
                                            <?php echo $name = App\Models\Common\CodeModel::where(['id' => "{$value['id']}"])->value('cd_desc'); ?>
                                            <?php }else{?>
                                            <a href="<?= url('dashboard/details?legal_id=' . $value['id'].'&legal_blk_id='.$block_id . '&filter='.$filter); ?>">
                                                <?php echo $name = App\Models\Common\CodeModel::where(['id' => "{$value['id']}"])->value('cd_desc'); ?>
                                            </a>
                                        <?php }?>
                                    </td>
                                    <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_acer']?></td>
                                    <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_hector']?></td>
                                    <td class="all_percentage" style="text-align: right;"><?= (($value['grand_total_tot_cost'] * 100)/$grand_total_cost_all);?></td>
                                    <td class="all_total_cost" style="text-align: right;"><?= $value['grand_total_tot_cost']?></td>
                                </tr>
                                <?php
                                }
                            }
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th  class="text-center">
                                <?php if (isset($filter) && $filter != '') { ?>
                                    <a href="<?= url('dashboard/totaldetails?block_id='.$block_id.'&filter=' . $filter); ?>" style="color: #333333;">Total</a>
                                <?php } else { ?>
                                    Total
                            <?php } ?>
                            </th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaAcre?></th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaHector?></th>
                            <?php if($grandTotalCost){?>
                            <td class="all_percentage" style="text-align: right;"><?= (($grandTotalCost * 100)/$grand_total_cost_all);?></td>
                            <?php }?>
                            <th class="all_total_cost" style="text-align: right;"><?= $grandTotalCost?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- End .panel -->
    </div>
</div>

@endsection
