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
                                        $option_code = str_replace(' ', '_', $val['option_code']);
                                        $selected = (in_array($option_code, $districts_assigned_to_user)) ? 'selected="selected"' : '';
                                        ?>
                                        <option class="option_val" <?= $selected ?>  value="<?= $option_code ?>"><?= $val['option_desc'] ?></option>
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
<?php } ?>







