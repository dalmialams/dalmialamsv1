<style>
.float-container {
    border: 3px solid #fff;
    padding: 10px;
}

.float-child {
  width: 26%;
    float: left;
    padding: 20px;
    border: 1px solid #f5f5f5;
    margin-left: 10px;
}  
.gray{
	color: #ec7e7e;
    font-weight: 800;
}
.green{
    font-weight: 800;
    color: green;
}	
.blue{
	font-weight: 800;
    color: blue;
}
</style>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="mySmallModalLabel">Audit Log View</h4>
    </div>
    <div class="modal-body" >
			<div class="float-container">

			<table id="registration_lists_table2" class="table table-striped table-bordered" cellspacing="0" width="100%" style="background-color:white;">
				<thead>
				  <tr>
														   
					<th> Field</th>
					<th>Old Value</th>                                          
					<th>New Value</th>
				  </tr>
				<tbody>
				
				<?php if(isset($list[0]->new_value) && !empty($list[0]->new_value)): ?>
				<?php foreach($list[0]->new_value as $k=>$info): ?>
			    <?php if((isset($list[0]->old_val[$k]) && $list[0]->old_val[$k]!='') || $info!=''): ?>
				<tr>									   
					<td> <?php if(array_search($k,$commonkeylist)){echo array_search($k,$commonkeylist);}else { echo ucwords(str_replace('_',' ',$k));}?></td>
					<td><?php if(isset($list[0]->old_val[$k])){ echo array_search($list[0]->old_val[$k],$commonkeylist)!=''?array_search($list[0]->old_val[$k],$commonkeylist):$list[0]->old_val[$k];} ?></td>  
					<td><?=array_search($info,$commonkeylist)!=""?array_search($info,$commonkeylist):$info?></td>
				  </tr>
				  <?php endif; ?>
				<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
            </thead>
            <tbody>
			</tbody>
			</table>
			</div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>


<script>
    $(function () {
        $('.all_total_cost').autoNumeric('init', {mDec: 0, dGroup: 0});
        $('.all_total_area').autoNumeric('init', {mDec: 4, dGroup: 2});
        $('.all_percentage').autoNumeric('init', {mDec: 2, dGroup: 2});
    });
</script>
