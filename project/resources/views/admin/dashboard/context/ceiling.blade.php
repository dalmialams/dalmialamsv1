
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
                    <li class="active"><?php echo isset($context) ? $context : '' ?></li>
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
                <?php if ($total_area_details && $survey_total_area_details) { ?>
                    <table id="tabletools1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <?php if (isset($state_id) && $state_id) { ?>
                                    <th  class="text-center">State</th>
                                <?php } ?>
                                <?php if (isset($district_id) && $district_id) { ?>
                                    <th  class="text-center">District</th>
                                <?php } ?>
                                <?php if (isset($block_id) && $block_id) { ?>
                                    <th  class="text-center">Block</th>
                                <?php } ?>
                                <?php if (isset($village_id) && $village_id) { ?>
                                    <th  class="text-center">Village</th>
                                <?php } ?>
                                <th  class="text-center">Purchase Area (Acre)</th>
                                <th  class="text-center">37A Applied (Acre)</th>
                                <th  class="text-center">37A Obtained (Acre)</th>
                                <th  class="text-center">37A not applied (Acre)</th>
                                <th  class="text-center">% pending</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($survey_total_area_details) {
                                foreach ($survey_total_area_details as $key => $val) {
                                    ?>
                                    <tr>
                                        <?php if (isset($state_id) && $state_id) { ?>
                                            <td  class="text-left">
                                                <?php
                                                echo $name = App\Models\Common\StateModel::where(['id' => "{$state_id}"])->value('state_name');
                                                ?>

                                            </td>
                                        <?php } ?>
                                        <?php if (isset($district_id) && $district_id) { ?>
                                            <td  class="text-left">
                                                <?php
                                                echo $name = App\Models\Common\DistrictModel::where(['id' => "$district_id"])->value('district_name');
                                                ?>

                                            </td>
                                        <?php } ?>
                                        <?php if (isset($block_id) && $block_id) { ?>
                                            <td  class="text-left">
                                                <?php
                                                echo $name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name');
                                                ?>

                                            </td>
                                        <?php } ?>
                                        <?php if (isset($village_id) && $village_id) { ?>
                                            <td  class="text-left">
                                                <?php
                                                echo $name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name');
                                                ?>

                                            </td>
                                        <?php } ?>
                                        <td class="all_total_area" style="text-align: right;"><?= $total_area_details['grand_total_tot_area_acer'] ?></td>
                                        <td class="all_total_area" style="text-align: right;"><?= $val['applied_grand_total_ceiling_area_acre'] ?></td>
                                        <td class="all_total_area" style="text-align: right;"><?= $val['obtaine_grand_total_ceiling_area_acre'] ?></td>
                                        <td class="all_total_area" style="text-align: right;"><?= ($total_area_details['grand_total_tot_area_acer'] - ($val['applied_grand_total_ceiling_area_acre'] + $val['obtaine_grand_total_ceiling_area_acre'])); ?></td>
                                        <td class="" style="text-align: right;">
                                            <?php
                                            $pending_area = ($total_area_details['grand_total_tot_area_acer'] - ($val['applied_grand_total_ceiling_area_acre'] + $val['obtaine_grand_total_ceiling_area_acre']));
                                            $pending_percent = (int) ($pending_area * 100) / $total_area_details['grand_total_tot_area_acer'];
                                            echo number_format($pending_percent, 2);
                                            // echo '' . +$pending_percent; //
                                            // echo +$pending_percent;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                        </tbody>

                    </table>
                <?php } else { ?>
                    <div class="text-center text-danger">No data available</div>
                <?php } ?>
            </div>
        </div>
        <!-- End .panel -->
    </div>
</div>

@endsection
