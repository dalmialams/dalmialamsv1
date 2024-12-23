<?php
if ($dropdown_type == 'dualbox') {
    ?>

    <div class="row">
        <!-- Start .row -->
        <div class="panel panel-default">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-list-alt"></i> <?= str_replace('_', ' ', $label_name) ?></h4>
            </div>
            <div class="panel-body pt0 pb0">

                <div class="form-group">
                    <div class="col-lg-12">
                        <select multiple="multiple" name="<?= $typeList ?>[]" size="10"  class="duallistbox">
                            <optgroup>
                                <?php
                                if ($optionList) {
                                    foreach ($optionList as $key => $val) {
                                        ?>
                                        <option class="option_val"  value="<?= str_replace(' ', '_', $val['option_code']) ?>"><?= $val['option_desc'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </optgroup>
                        </select>
                       
                    </div>
                </div>
                <!-- End .form-group  -->

            </div>
        </div>

        <!-- End .row -->
    </div>
    <script>
        $('.duallistbox').bootstrapDualListbox({
            nonSelectedListLabel: 'Select',
            selectedListLabel: 'Assigned',
            preserveSelectionOnMove: 'moved',
            moveOnSelect: true,
        });

    </script>
    <?php } else { ?>
    <label class="col-lg-5 col-md-3 control-label"><?= str_replace('_', ' ', $label_name) ?></label>
    <div class="col-lg-7 col-md-9">
            <?php if ($multiple == 'true') { ?>
            <select class="select2-minimum form-control" multiple="true" name="<?= $typeList ?>[]" id="<?= $typeList ?>" <?= isset($onchange) ? $onchange : '' ?> data-placeholder="Select <?= str_replace('_', ' ', $label_name) ?>" tabindex="1">
                <option value="Select"></option>
                <?php
                if ($optionList) {
                    foreach ($optionList as $key => $val) {
                        ?>
                        <option  value="<?= str_replace(' ', '_', $val['option_code']) ?>"><?= $val['option_desc'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <?php } else { ?>
            <select class="select2-minimum form-control" name="<?= $namePrefix ?>[<?= $typeList ?>]" id="<?= $typeList ?>" <?= isset($onchange) ? $onchange : '' ?> data-placeholder="Select <?= str_replace('_', ' ', $label_name) ?>" tabindex="1">
                <option value=""></option>
                <?php
                if ($optionList) {
                    foreach ($optionList as $key => $val) {
                        ?>
                        <option  value="<?= str_replace(' ', '_', $val['option_code']) ?>"><?= $val['option_desc'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
    <?php } ?>
    </div>
    <script>
        $(".select2-minimum").select2({
            //  minimumResultsForSearch: -1,
            allowClear: true
        });
    </script>
<?php } ?>







