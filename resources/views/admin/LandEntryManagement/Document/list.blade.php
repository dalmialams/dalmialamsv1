
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->

<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="panel panel-primary  toggle panelMove panelClose panelRefresh">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Registration List</h4>
            </div>
            <div class="panel-body">
                <table id="tabletools" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Unique Identification No</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Taluk</th>                           
                            <th>Village</th>
                            <th>Total Area</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Unique Identification No</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Taluk</th>
                            <th>Village</th>
                            <th>Total Area</th>
                            <th>Total Cost</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        if ($registration) {
                            foreach ($registration as $key => $value) {
                                ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?php
                                        $state_id = trim($value['state_id']);
                                        echo $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $dist_id = trim($value['district_id']);
                                        echo $state_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name');
                                        ?>
                                    </td>
                                    <td> <?php
                                        $block_id = trim($value['block_id']);
                                        echo $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name');
                                        ?></td>
                                    <td></td>
                                    <td>
                                        <?php
                                        $unit = $value['tot_area_unit'];
                                        $unit_name = App\Models\Common\CodeModel::where(['id' => "$unit", 'cd_type' => 'area_unit'])->value('cd_desc');
                                        echo $value['tot_area'] . ' (' . $unit_name . ')';
                                        ?>
                                    </td>
                                    <td><?= $value['tot_cost'] ?></td>
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


@endsection
