
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->

<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <?php if (isset($lease_data) && !empty($lease_data)) { ?>
            <div class="panel panel-primary ">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Lease Details</h4>
                </div>
                <div class="panel-body">

                    <table class="table table-bordered">                        
                        <tbody>
                            <?php
                            $tot_area_unit = $lease_data['tot_area_unit'];
                            $tot_area_unit_value = App\Models\Common\ConversionModel::where(['code_id' => "$tot_area_unit", 'fl_archive' => 'N'])->value('convers_value');
                            ?>
                            <tr>
                                <td><strong>Survey No</strong></td>
                                <td><?= $lease_data['survey_no'] ?></td>

                                <td><strong>Name of Lease</strong></td>
                                <td><?= $lease_data['lease_name'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Name of Lessor</strong></td>
                                <td><?= $lease_data['lessor_name'] ?></td>

                                <td><strong>Total Area</strong></td>
                                <td><?= $lease_data['tot_area'] * $tot_area_unit_value ?></td>
                            </tr>
                            <tr>
                                <td><strong>Monthly lease rent amount</strong></td>
                                <td><?= $lease_data['lease_monthly_amount'] ?></td>

                                <td><strong>Agreement Date</strong></td>
                                <td><?= $lease_data['lease_agreement_date'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Lease Period (From - To)</strong></td>
                                <td><?= $lease_data['lease_start_date'] . ' to ' . $lease_data['lease_end_date'] ?></td>

                                <td><strong>Percentage of Escalation</strong></td>
                                <td><?= $lease_data['percentage_escalation'] . '%' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Location of land</strong></td>
                                <td><?= $lease_data['land_location'] ?></td>

                                <td><strong>Land Title Document Lessor</strong></td>
                                <td> 
                                    <?php
                                    $file_path = $lease_data['lessor_doc_path'];
                                    $file_name = stristr($file_path, '/');
                                    if (file_exists($file_path)) {
                                        ?>
                                        <a href="<?= url('download-file?path=' . $file_path) ?>"><?= str_replace("/", "", $file_name) ?>&nbsp<i class="glyphicon glyphicon-download-alt"></i></a>
                                    <?php } else { ?>
                                        Document does not exist
                                    <?php } ?>
                                </td>
                            </tr>
    
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="panel panel-primary ">
                No data found
            </div>
        <?php } ?>
    </div>
</div>
@endsection
