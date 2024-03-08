
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
                                <th  class="text-center">Total Area (Acre)</th>
                                <th  class="text-center">Disputes Area (Acre)</th>
                                <th  class="text-center">Nature of dispute</th>
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
                                        <td class="all_total_area" style="text-align: right;"><?= $val['grand_total_disputes_area_acre'] ?></td>
                                        <td class="all_percentage text-center"><?= $val['litigation_type']; ?></td>
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
