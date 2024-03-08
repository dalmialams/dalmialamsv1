

<!-- .page-content -->
    <table id="tabletools1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th  class="text-center">State</th>
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
                        $allStateIds = '1';
                        if ($states) {

                            foreach ($states as $key => $value) {
                                if ($value['grand_total_tot_cost'] || $value['grand_total_tot_area_acer']) {
                                    $grandTotalCost += $value['grand_total_tot_cost'];
                                    $grandTotalAreaAcre += $value['grand_total_tot_area_acer'];
                                    $grandTotalAreaHector += $value['grand_total_tot_area_hector'];
                                    $allStateIds = $allStateIds.','.$value['id'];
                                    ?>
                                    <tr>
                                        <td  class="text-left">
                                            <?php if ($filter == '') { ?>
                                                <span class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>"> <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?></span>
                                            <?php } elseif ($filter == 'District') { ?>
                                                <a href="<?= url('dashboard/district?state_id=' . $value['id'] . '&filter=District'); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                    <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?>
                                                </a>
                                            <?php } elseif ($filter == 'Block/Taluk') { ?>
                                                <a href="<?= url('dashboard/block?state_id=' . $value['id'] . '&filter=Block/Taluk'); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                    <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?>
                                                </a>
                                            <?php } elseif ($filter == 'Village') { ?>
                                                <a href="<?= url('dashboard/village?state_id=' . $value['id'] . '&filter=Village'); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                    <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?= url('dashboard/details?state_id=' . $value['id'] . '&filter=' . $filter); ?>" class="context-menu-one btn btn-neutral" tag="<?= $value['id']; ?>">
                                                    <?php echo $name = App\Models\Common\StateModel::where(['id' => "{$value['id']}"])->value('state_name'); ?>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_acer'] ?></td>
                                        <td class="all_total_area" style="text-align: right;"><?= $value['grand_total_tot_area_hector'] ?></td>
                                        <td class="all_percentage" style="text-align: right;"><?= (($grand_total_cost_all)?(($value['grand_total_tot_cost'] * 100) / $grand_total_cost_all):0); ?></td>
                                        <td style="text-align: right;" >
                                             <i class="fa fa-spinner fa-spin" id="<?= $value['id'] ?>" style="font-size:24px;visibility: hidden"></i> &nbsp;
                                            <span class="all_total_cost custom_underline" onmouseover ="totalCostDistribution('<?= $value['id'];?>','','','','<?= $value['id'];?>')"><?= $value['grand_total_tot_cost'] ?>
                                                
                                            </span>
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
                                <?php if (isset($filter) && $filter != '') { ?>
                                    <a href="<?= url('dashboard/totaldetails?filter=' . $filter); ?>" class="context-menu-one btn btn-neutral" style="color: #333333;">Total</a>
                                <?php } else { ?>
                                    <span class="context-menu-one btn btn-neutral"> Total</span>
                                <?php } ?>
                            </th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaAcre ?></th>
                            <th class="all_total_area" style="text-align: right;"><?= $grandTotalAreaHector ?></th>
							<td class="all_percentage" style="text-align: right;">
                            <?php if ($grandTotalCost) { ?>
                                <?= (($grandTotalCost * 100) / $grand_total_cost_all); ?>
                            <?php } ?>
							</td>
                            <th style="text-align: right;">  
                                    <i class="fa fa-spinner fa-spin" id="total" style="font-size:24px;visibility: hidden"></i>&nbsp;
                                    <span class="all_total_cost custom_underline" onmouseover ="totalCostDistribution('<?= $allStateIds;?>','','','','total')"><?= $grandTotalCost ?>
                                    </span>
							</th>
                        </tr>
                    </tfoot>
                </table>

