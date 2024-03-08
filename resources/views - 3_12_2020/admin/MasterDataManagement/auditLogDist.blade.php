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


			<div class="float-child">
			<div class="blue">Field Name</div><br>
			
			<?php if(isset($list) && !empty($list)){
				foreach($list as $k=>$infos){
					
					foreach($infos->common_data as $kk=>$detls){
					 if(isset($kk) && $kk!=''){?>
					<p> <button type="button" class="btn btn-xs btn-outline btn-secondary mb-4" style="background:none">
						<span style="font-size: 13px;font-weight: 600; ">
						<?php if(array_search($kk,$commonkeylist)){ 
							echo array_search($kk,$commonkeylist);
						} else { echo $kk;} 
						?>
						</span>
					</button>
					<?php
					 }
					}
				}
			}
			?>
					</p>
			
			
			
			</div>
			
			<div class="float-child">
			<div class="gray">Old Value</div><br>
			
			<?php if(isset($list) && !empty($list)){
				foreach($list as $k=>$infos){
					
					foreach($infos->common_data as $kk=>$detls){
					 if(isset($kk) && $kk!=''){?>
					<p> <button type="button" class="btn btn-xs btn-outline btn-secondary mb-4" style="background:none">
						
						<?php if(array_search($detls,$commonkeylist)){ 
							echo array_search($detls,$commonkeylist);
						} else { echo $detls;} 
						?>
					</button>
					<?php
					 }
					}
				}
			}
			?>
					</p>
			
			
			
			</div>

			<div class="float-child">
			<div class="green">New Value</div><br>
			<?php if(isset($list) && !empty($list)){
				foreach($list as $k=>$infos){
					
			
			foreach($infos->update_data as $kku=>$updt){
					 if(isset($kku) && $kku!=''){?>
					 <p> <button type="button" class="btn btn-xs btn-outline btn-secondary mb-4" style="background:none">
						
						<?php if(array_search($updt,$commonkeylist)){ 
							echo array_search($updt,$commonkeylist);
						} else { echo $updt;} 
						?>
						</button>
					<?php }
			}}}?>
					</p>
			</div>

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
