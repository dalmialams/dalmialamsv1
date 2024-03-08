
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
                    <li><a href="<?php echo url('dashboard'); ?>">Dashboard</a></li>
                    <?= $breadcum; ?>
                    <li class="active"><?php echo isset($filter) ? $filter : '' ?></li>
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
                @include('admin.dashboard.selectionCriteria')

                <table id="tabletools1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th  class="text-center">Village</th>
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
                        $allVillageIds = '1';
                        if ($RegDataWithState) {

                            foreach ($RegDataWithState as $key => $value) {
                                if ($value['grand_total_tot_cost']) {
                                    $grandTotalCost += $value['grand_total_tot_cost'];
                                    $grandTotalAreaAcre += $value['grand_total_tot_area_acer'];
                                    $grandTotalAreaHector += $value['grand_total_tot_area_hector'];
                                    $allVillageIds = $allVillageIds.','.$value['id'];
                                    ?>
                                    <tr>
                                        <td  class="text-left">
                                            <a href="<?= url('dashboard/details?state_id=' . $value['get_state']['id'] . '&district_id=' . $value['get_district']['id'] . '&block_id=' . $value['get_block']['id'] . '&village_id=' . $value['id'] . '&filter=' . $filter); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                <span class="context-menu-one btn btn-neutral"  tag="<?= $value['id']; ?>"><?php echo $name = App\Models\Common\VillageModel::where(['id' => "{$value['id']}"])->value('village_name'); ?></span>
                                            </a>
                                        </td>
                                        <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_acer'] ?></td>
                                        <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_hector'] ?></td>
                                        <td class="all_percentage" style="text-align: right;"><?= (($value['grand_total_tot_cost'] * 100) / $grand_total_cost_all); ?></td>
                                        <td style="text-align: right;">
                                            <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i> &nbsp;
                                            <span class="all_total_cost custom_underline" onmouseover ="totalCostDistribution('<?= $state_id; ?>', '<?= $district_id; ?>', '<?= $block_id; ?>', '<?= $value['id']; ?>','<?= $value['id'] ?>')"><?= $value['grand_total_tot_cost'] ?></span></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th  class="text-left">
                                <?php if ($filter == 'State') { ?>
                                    <a href="<?= url('dashboard/totaldetails?state_id=' . $state_id . '&filter=' . $filter); ?>" style="color: #333333;">Total</a>
                                <?php } else if ($filter == 'District') { ?>
                                    <a href="<?= url('dashboard/totaldetails?district_id=' . $district_id . '&filter=' . $filter); ?>" style="color: #333333;">Total</a>
                                <?php } else if ($filter == 'Block/Taluk') { ?>
                                    <a href="<?= url('dashboard/totaldetailsblock_id=' . $block_id . '&filter=' . $filter); ?>" style="color: #333333;">Total</a>
                                <?php } else { ?>
                                    Total
                                <?php } ?>
                            </th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaAcre ?></th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaHector ?></th>
                            <?php if ($grandTotalCost) { ?>
                                <td class="all_percentage" style="text-align: right;"><?= (($grandTotalCost * 100) / $grand_total_cost_all); ?></td>
                            <?php } ?>
                                <th style="text-align: right;">
                                    <i class="fa fa-spinner fa-spin" id="total" style="font-size:24px;visibility: hidden"></i>&nbsp;
                                    <span class="all_total_cost custom_underline" onmouseover ="totalCostDistribution('<?= $state_id; ?>', '<?= $district_id; ?>', '<?= $block_id; ?>', '<?= $allVillageIds; ?>','total')"><?= $grandTotalCost ?></span></th>
                        </tr>
                    </tfoot>
                </table>
                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="displayCostDistributionModal">
                    <div class="modal-dialog" id="displayCostDistributionDetails">

                    </div>
                </div>
            </div>
        </div>

        <!-- End .panel -->
    </div>
</div>

@endsection
