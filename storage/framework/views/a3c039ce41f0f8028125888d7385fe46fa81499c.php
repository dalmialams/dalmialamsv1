<?php $__env->startSection('content'); ?>
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
    <div><?php echo Session::get('message'); ?></div>
    <div class="col-lg-12">
        <!-- col-lg-12 start here -->
        
        
        <div class="panel panel-primary">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Dashboard</h4>
            </div>
            <div class="panel-body">
              <?php echo $__env->make('admin.dashboard.selectionCriteria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                
                <table id="tabletools1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th  class="text-center"><?= $filter;?></th>
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
                                $uniqueId = $value['id'];
                                if($value['grand_total_tot_cost']){
                                    $grandTotalCost += $value['grand_total_tot_cost'];
                                    $grandTotalAreaAcre += $value['grand_total_tot_area_acer'];
                                    $grandTotalAreaHector += $value['grand_total_tot_area_hector'];
                                ?>
                                <tr>
                                    <td  class="text-left">
                                        <?php if($filter=='District'){
                                         
                                            $name = App\Models\Common\DistrictModel::where(['id' => "{$value['id']}"])->value('district_name');
                                        }elseif($filter=='Village'){
                                            $name = App\Models\Common\VillageModel::where(['id' => "{$value['id']}"])->value('village_name'); 
                                        }elseif($filter=='Legal Entity'){
                                            $name = App\Models\Common\CodeModel::where(['id' => "{$value['id']}"])->value('cd_desc');
                                        }elseif($filter=='State'){
                                            $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name');
                                        }elseif($filter=='Block/Taluk'){
                                            $name = App\Models\Common\BlockModel::where(['id' => "{$value['id']}"])->value('block_name');
                                        }elseif($filter=='Purchase Type'){
                                            $name = App\Models\Common\CodeModel::where(['id' => "{$value['id']}"])->value('cd_desc');
                                        }elseif($filter=='Purpose'){
                                            $name = App\Models\Common\CodeModel::where(['id' => "{$value['id']}"])->value('cd_desc');
                                        }elseif($filter=='Plot Type'){
                                            $name = App\Models\Common\CodeModel::where(['id' => "{$value['id']}"])->value('cd_desc');
                                        }elseif($filter=='Purchasing Team'){
                                            $name = App\Models\Common\CodeModel::where(['id' => "{$value['id']}"])->value('cd_desc');
                                        }elseif($filter=='Classification'){
                                            $name = App\Models\Common\CodeModel::where(['id' => "{$value['id']}"])->value('cd_desc');
                                        }
                                        ?>
                                        <span class="context-menu-one" tag='<?=$value['id']?>'>   <?= $name?></span>
                                 
                                    </td>
                                    <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_acer']?></td>
                                    <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_hector']?></td>
                                    <td class="all_percentage" style="text-align: right;"><?= (($value['grand_total_tot_cost'] * 100)/$grand_total_cost_all);?></td>
                                    <td style="text-align: right;">
                                        <span class="all_total_cost custom_underline" <?php if($filter=='State'){?>onmouseover ="totalCostDistribution('<?= $value['id'];?>','','','')" <?php }elseif($filter=='District'){?>onmouseover ="totalCostDistribution('<?= $state_id;?>','<?= $value['id']; ?>','','')" <?php }elseif($filter=='Block/Taluk'){?>onmouseover ="totalCostDistribution('<?= $state_id;?>','<?= $district_id;?>','<?= $value['id']; ?>','')" <?php }elseif($filter=='Village'){?>onmouseover ="totalCostDistribution('<?= $state_id;?>','<?= $district_id;?>','<?= $block_id;?>','<?= $value['id']; ?>')" <?php }?>><?= $value['grand_total_tot_cost']?></span>
                                    </td>
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
                                <?php if(isset($filter) && $filter == 'District'){?>
                                    <a href="<?= url('dashboard/totaldetails?filter='. $filter);?>" style="color: #333333;">Total</a>
                                <?php }else{?>
                                    Total
                                <?php }?>
                            </th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaAcre?></th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaHector?></th>
                            <?php if($grandTotalCost){?>
                                <td class="all_percentage" style="text-align: right;"><?= (($grandTotalCost * 100)/$grand_total_cost_all);?></td>
                            <?php }?>
                                <th style="text-align: right;"><span class="all_total_cost custom_underline" <?php if($filter=='State'){?>onmouseover ="totalCostDistribution('<?= $uniqueId;?>','','','')" <?php }elseif($filter=='District'){?>onmouseover ="totalCostDistribution('<?= $state_id;?>','<?= $uniqueId; ?>','','')" <?php }elseif($filter=='Block/Taluk'){?>onmouseover ="totalCostDistribution('<?= $state_id;?>','<?= $district_id;?>','<?= $uniqueId; ?>','')" <?php }elseif($filter=='Village'){?>onmouseover ="totalCostDistribution('<?= $state_id;?>','<?= $district_id;?>','<?= $block_id;?>','<?= $uniqueId; ?>')" <?php }?>><?= $grandTotalCost?></span></th>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.adminlayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>