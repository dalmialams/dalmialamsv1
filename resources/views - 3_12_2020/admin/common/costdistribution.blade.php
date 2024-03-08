<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="mySmallModalLabel">Total Cost Break-up <?=isset($state_name)?$state_name:''?></h4>
    </div>
    <div class="modal-body" >
        <table id="tabletools1" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <?php if ($getAllPaymentCostDistribution) { ?>
                <thead>
                    <tr>
                        <th  class="text-center">Payment Type</th>
                        <th  class="text-center">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grandTotalCost = 0;
                    foreach ($getAllPaymentCostDistribution as $key => $value) {
                        $grandTotalCost += $value;
                        ?>
                        <tr>
                            <td><?= $key; ?></td>
                            <td class="all_total_cost" style="text-align: right;"><?= $value; ?></td>
                        </tr>
                    <?php } ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">Total</th>
                        <th class="all_total_cost" style="text-align: right;"><?= $grandTotalCost ?></th>
                    </tr>
                </tfoot>
            <?php } ?>


        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>


<script>
    $(function () {
        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 0});
        $('.all_total_area').autoNumeric('init', {mDec: 4, dGroup: 2});
        $('.all_percentage').autoNumeric('init', {mDec: 2, dGroup: 0});
    });
</script>
