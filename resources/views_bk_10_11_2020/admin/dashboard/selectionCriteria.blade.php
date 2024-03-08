{!! Form::open(['class' => 'form-horizontal dash-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']) !!}
<div class="col-lg-12">
    <div class="row ">
        <!-- Start .row -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group select_criteria" id="stateList">
              <?php if(isset($state_id)){ ?><input type="hidden" name="state_id" value="<?= isset($state_id) ? $state_id : '' ?>"><?php }?>
                    <?php if(isset($district_id)){ ?><input type="hidden" name="district_id" value="<?= isset($district_id) ? $district_id : '' ?>"><?php }?>
                    <?php if(isset($block_id)){ ?><input type="hidden" name="block_id" value="<?= isset($block_id) ? $block_id : '' ?>"><?php }?>
                    <?php if(isset($village_id)){ ?><input type="hidden" name="village_id" value="<?= isset($village_id) ? $village_id : '' ?>"><?php }?>
            <label class="col-lg-3 col-md-3 control-label">Selection Criteria</label>
            <div class="col-lg-9 col-md-9">
                {{--Form::select('filter', array(''=>'Select','Classification'=>'Classification','District'=>'District','Legal Entity'=>'Legal Entity','Plot Type'=>'Plot Type','Purchasing Team'=>'Purchasing team','Purchase Type'=>'Purchase Type','Purpose'=>'Purpose') , isset($filter) ? $filter : '',array('class'=>'form-control select2-minimum','onchange'=>'this.form.submit()'))--}}
                {{Form::select('filter',array(''=>'Select','State'=>'State','District'=>'District','Block/Taluk'=>'Block/Taluk','Village'=>'Village') , isset($filter) ? $filter : '',array('class'=>'form-control select2-minimum','onchange'=>'this.form.submit()'))}}
            </div>

        </div>
    </div>
    <!-- End .row -->
</div>
{!! Form::close() !!}