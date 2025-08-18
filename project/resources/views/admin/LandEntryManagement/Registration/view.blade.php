
@extends('admin.layouts.adminlayout')
@section('content')
<!-- .page-content -->

<div class="row">
    <div>{!! Session::get('message')!!}</div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        <div class="row">
            <div class="panel panel-primary  toggle panelMove panelClose panelRefresh text-right">
                <div class="panel-body">
                    <a href="<?= url('land-details-entry/registration/list');?>" class="btn btn-primary mr5 mb10"><i class="glyphicon glyphicon-list"></i> Lists</a>
                    <a href="<?= url('land-details-entry/registration/add?reg_uniq_no='.$reg_info['id']);?>" class="btn btn-primary mr5 mb10"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                </div>
            </div>
        </div>
        <?php if ($reg_info) { ?>
            <div class="panel panel-primary ">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Registration Details</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="30%"><strong>Unique Identification No</strong></td>
                                <td><?= $reg_info['id'] ?></td>
                            
                                <td><strong>Legal Entity</strong></td>
                                <td>
                                    <?php
                                    $legal_entity = $reg_info['legal_entity'];
                                    $legal_entity_name = App\Models\Common\CodeModel::where(['id' => "$legal_entity", 'cd_type' => 'legal_entity'])->value('cd_desc');
                                    echo $legal_entity_name;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Purchase Type</strong></td>
                                <td>
                                    <?php
                                    $purchase_type = $reg_info['purchase_type_id'];
                                    $purchase_type_name = App\Models\Common\CodeModel::where(['id' => "$purchase_type", 'cd_type' => 'purchase_type'])->value('cd_desc');
                                    echo $purchase_type_name;
                                    ?>
                                </td>
                            
                                <td><strong>Name of the Purchaser</strong></td>
                                <td><?php $purchaser_name=$reg_info['purchaser'] ;
								$purchaser_name = App\Models\Common\CodeModel::where(['id' => "$purchaser_name", 'cd_type' => 'purchaser_name'])->value('cd_desc');
                                    echo $purchaser_name;
								?></td>
                            </tr>
                            <tr>
                                <td><strong>Document Regn No</strong></td>
                                <td><?= $reg_info['regn_no'] ?></td>
                            
                                <td><strong>Regn Date</strong></td>
                                <td><?= $reg_info['regn_date'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Sub & Registrar Office</strong></td>
                                <td><?= $reg_info['sub_registrar'] ?></td>
                            
                                <td><strong>Name of Vendor</strong></td>
                                <td><?= $reg_info['vendor'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total Area</strong></td>
                                <td>
                                    <?php
                                    $unit = $reg_info['tot_area_unit'];
                                    $unit_name = App\Models\Common\CodeModel::where(['id' => "$unit", 'cd_type' => 'area_unit'])->value('cd_desc');
                                    echo $reg_info['tot_area'] . ' (' . $unit_name . ')';
                                    ?> 
                                </td>
                            
                                <td><strong>Total Cost</strong></td>
                                <td><?= $reg_info['tot_cost'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>State</strong></td>
                                <td>
                                    <?php
                                    $state_id = trim($reg_info['state_id']);
                                    echo $state_name = App\Models\Common\StateModel::where(['id' => "$state_id"])->value('state_name');
                                    ?>
                                </td>
                            
                                <td><strong>District</strong></td>
                                <td>
                                    <?php
                                    $dist_id = trim($reg_info['district_id']);
                                    echo $state_name = App\Models\Common\DistrictModel::where(['id' => "$dist_id"])->value('district_name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Block/Taluk</strong></td>
                                <td>
                                    <?php
                                    $block_id = trim($reg_info['block_id']);
                                    echo $block_name = App\Models\Common\BlockModel::where(['id' => "$block_id"])->value('block_name');
                                    ?>
                                </td>
                            
                                <td><strong>Village</strong></td>
                                <td>
									  <?php 
                                    $village_id = trim($reg_info['village_id']);
                                    echo $village_name = App\Models\Common\VillageModel::where(['id' => "$village_id"])->value('village_name');
                                    ?>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        <?php if($survey_info){?>
        <div class="panel panel-primary ">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Survey No Details</h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Survey No</th>
                            <th>Area Unit</th>
                            <th>Area</th>
                            <th>Purchased Area</th>
                            <th>Classification</th>                           
                            <th>Purpose</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($survey_info) {
                            foreach ($survey_info as $key => $value) {
                                ?>
                                <tr>
                                    <td><?= $value['survey_no'] ?></td>
                                    <td>
                                        <?php
                                        $area_unit = trim($value['area_unit']);
                                        echo $area_unit_name = App\Models\Common\CodeModel::where(['id' => "$area_unit"])->value('cd_desc');
                                        ?>
                                    </td>
                                    <td><?= $value['total_area'] ?></td>
                                    <td><?= $value['purchased_area'] ?></td>
                                    <td>
                                        <?php
                                        $classification = trim($value['classification']);
                                        echo $classification_name = App\Models\Common\CodeModel::where(['id' => "$classification"])->value('cd_desc');
                                        ?>
                                    </td>
                                    <td><?= $value['purpose'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <?php }?>
        
        <?php if($all_docs){?>
        <div class="panel panel-primary ">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Document Upload</h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Document Type</th>
                            <th>Document Physical Location</th>
                            <th>Uploaded Document</th>
                            <th>Remarks</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_docs as $key => $value) {
                            ?>
                            <tr>
                                <td><?php
                                    $type = trim($value['type']);
                                    echo $type_name = App\Models\Common\CodeModel::where(['id' => "$type", 'cd_type' => 'document_type'])->value('cd_desc');
                                    ?>
                                </td>
                                <td><?= $value['physical_location'] ?></td>
                                <td>
                                    <?php
                                    $file_path = $value['path'];
                                    $file_name = stristr($file_path, '/');
                                    if (file_exists($file_path)) {
                                        ?>
                                        <a href="<?= url('download-file?path=' . $file_path) ?>"><?= str_replace("/", "", $file_name) ?>&nbsp<i class="glyphicon glyphicon-download-alt"></i></a>
                                    <?php } else { ?>
                                        Document does not exist
                                    <?php } ?>
                                </td>
                                <td><?= $value['remarks'] ?></td> 
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php }?>
        
        <?php if($payment_info){?>
        <div class="panel panel-primary ">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Payment Details</h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ref No</th>
                            <th>Mode</th>
                            <th>Remarks</th>
                            <th>Date</th>
                            <th>Bank</th>                           
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($payment_info) {
                            foreach ($payment_info as $key => $value) {
                                ?>
                                <tr>
                                    <td><?= $value['reference_no'] ?></td>
                                    <td>
                                        <?php
                                        $pay_mode = trim($value['pay_mode']);
                                        echo $pay_mode_name = App\Models\Common\CodeModel::where(['id' => "$pay_mode"])->value('cd_desc');
                                        ?>
                                    </td>
                                    <td><?= $value['description'] ?></td>
                                    <td><?= $value['pay_date'] ?></td>
                                    <td><?= $value['pay_bank'] ?></td>
                                    <td><?= number_format($value['amount']) ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <?php }?>

    </div>
</div>


@endsection
