<style>
div.dt-buttons {
    margin-top: 9px;
	width:30%;
}
.lg-header{
	width: 80%;
	margin-bottom: 12px;
}
.row-header{
	width: 100%;
}
div.dataTables_filter label {
    margin-top: -64px;
}
.kt-widget21__icon {
    display: inline-flex;
    flex-wrap: wrap;
    gap: 12px;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    width: 37px;
    height: 33px;
	cursor:pointer;
   /* border-radius: 50%;*/
}
.kt-bg-fill-brand {
    background-color: #716aca !important;
    color: #ffffff !important;
}
.kt-bg-fill-success {
    background-color: #1dc9b7 !important;
    color: #ffffff !important;
}

</style>
<?php echo Form::open(['class' => 'form-horizontal dash-form','method' => 'GET', 'enctype' => 'multipart/form-data','role' => 'form']); ?>

<div class="col-lg-12 lg-header">
    <div class="row row-header">
        <!-- Start .row -->
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 form-group select_criteria" id="stateList">
              <?php if(isset($state_id)){ ?><input type="hidden" name="state_id" value="<?= isset($state_id) ? $state_id : '' ?>"><?php }?>
                    <?php if(isset($district_id)){ ?><input type="hidden" name="district_id" value="<?= isset($district_id) ? $district_id : '' ?>"><?php }?>
                    <?php if(isset($block_id)){ ?><input type="hidden" name="block_id" value="<?= isset($block_id) ? $block_id : '' ?>"><?php }?>
                    <?php if(isset($village_id)){ ?><input type="hidden" name="village_id" value="<?= isset($village_id) ? $village_id : '' ?>"><?php }?>
            <label class="col-lg-5 col-md-5 control-label">Selection Criteria</label>
           
		<div class="col-lg-7 col-md-7">
			<select class="form-control select2-minimum" name="type" onchange="this.form.submit()" id="purchase_type">
			<option value="">All</option>
			<option value="leased" <?php if(isset($type) && $type=='leased'){echo"selected";}?> >Leased</option>
			<option value="purchased"  <?php if(isset($type) && $type=='purchased'){echo"selected";}?>>Purchased</option>
			</select>
		</div>
        </div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group select_criteria" >
		
		 
		 <div class="col-lg-8 col-md-8">
                <?php /*Form::select('filter', array(''=>'Select','Classification'=>'Classification','District'=>'District','Legal Entity'=>'Legal Entity','Plot Type'=>'Plot Type','Purchasing Team'=>'Purchasing team','Purchase Type'=>'Purchase Type','Purpose'=>'Purpose') , isset($filter) ? $filter : '',array('class'=>'form-control select2-minimum','onchange'=>'this.form.submit()','id'=>'SelectCriteria'))*/ ?>
                <?php echo e(Form::select('filter',array(''=>'Select','State'=>'State','District'=>'District','Block/Taluk'=>'Block/Taluk','Village'=>'Village') , isset($filter) ? $filter : '',array('class'=>'form-control select2-minimum','onchange'=>'this.form.submit()'))); ?>

            </div>
		</div>
		
		
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group" >
			<div>
				<div id="shape_data" href="#" class="kt-widget21__icon kt-bg-fill-brand">
				<i class="fa fa-file-excel-o" title="Grid view"></i>
				</div>

				<div id="map_data" href="#" class="kt-widget21__icon kt-bg-fill-success">
				<i class="fa fa-area-chart" title="Map view"></i>
				</div>		
			</div>	
		</div>
		
		
		
		
		
		
		
    </div>
    <!-- End .row -->
</div>
<?php echo Form::close(); ?>