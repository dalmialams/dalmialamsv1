<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script>
	$(function () {
        $('.select2-minimum').select2({
            placeholder: 'select',
        });
		
		 $(".numbers_only_restrict").keyup(function () {
            this.value = this.value.replace(/[^0-9\.]/g, "");
        });
    });
	
	$('input[type="checkbox"]').click(function() {
		if ($(this).prop("checked") == true) {
			$('#owner_detail').hide();
			$('#check_is_owner').val('2');
			var is_owner = this.value;
			var edit_id = $('#id').val();
			$('#relation').removeAttr('required');	
			$('#fam_owner_id').removeAttr('required');		
			$('#relation').val(null);	
			$('#fam_owner_id').val(null);		
			
			$.ajax({
				url: '<?php echo URL("land-details-entry/family-tree/check-is-owner"); ?>',
				method: "POST",
				data:{
					is_owner: is_owner,
					edit_id: edit_id,
					"_token": "{{ csrf_token() }}",
				},
				success:function(data){
					if(data!='')
					{
						$('#error').text("Head of the Family already added! Do you want to change Head of the Family ?");
						$('#error').show();
					}
				}
			});
		} else if ($(this).prop("checked") == false) {
			$('#owner_detail').show();
			$('#check_is_owner').val('1');
			$('#relation').attr('required', 'required') ;	
			$('#fam_owner_id').attr('required', 'required') ;			
			$('#error').hide();
		}
	});   
 
	function get_relation(obj)
	{
		var gender = $(obj).val();
		var html = '<option value="">select</option>'
		if(gender =="Male"){
			html = html += '<option value="son"> Son of</option>';	
			$('#owner_detail').show();
			//$('#check_is_owner').val('2');
			//$('#relation').removeAttr('required');	
			//$('#fam_owner_id').removeAttr('required');		
			//$('#relation').val(null);	
			//$('#fam_owner_id').val(null);		
			$('#hof_div').show();
		}
		else if(gender =="Female"){
			html = html += '<option value="wife"> Wife of</option>';
			html = html += '<option value="daughter"> Daughter of</option>';
			
			$('#owner_detail').show();
			$('#check_is_owner').val('1');
			$('#relation').attr('required', 'required') ;	
			$('#fam_owner_id').attr('required', 'required') ;			
			$('#error').hide();
			$('#hof_div').hide();

		}
		$('#relation').html(html);
		$("#relation").trigger('change');
	}
	
	function get_member(obj)
	{
		var edit_id = $('#id').val();
		var relationship_with_owner = $(obj).val();
		var registration_id = $('#registration_id').val();
			$.ajax({
					url: '<?php echo URL("land-details-entry/family-tree/check-exist-wife"); ?>',
					method: "POST",
					data:{
						relationship_with_owner: relationship_with_owner,
						registration_id: registration_id,
						edit_id:edit_id,							
						"_token": "{{ csrf_token() }}",
					},
					success:function(data){
						if(data!='')
						{
							$('#fam_owner_id').html(data);
							$("#fam_owner_id").trigger('change');

						}
					}
			});		

	}
	/*function change_val(obj)
	{
	  var val = $(obj).val();	
	  if(val == 'wife'){
		  $('#owner_id').attr('required','') ;
	  }
	  else{
		  $("#owner_id").removeAttr('required');
	  }
	}*/ 
	
    function delete_param(uniq_no, delete_id) {
		var r = confirm("Do you want to delete?");
		if (r == true) {
			window.location = '<?= url("land-details-entry/family-tree/delete");?>'+ '?reg_uniq_no='+ uniq_no + '&id=' + delete_id;
			
		}
		return false;
	}
    
	<?php if(isset($family_data['is_hof']) && $family_data['is_hof']=='Y') : ?>
			$('#relation').removeAttr('required');	
			$('#fam_owner_id').removeAttr('required');		

	<?php elseif(isset($family_data['is_hof']) && $family_data['is_hof']=='N') : ?>
		$('#employ_div').show();
			$('#relation').attr('required', 'required') ;	
			$('#fam_owner_id').attr('required', 'required') ;			
		
	<?php endif; ?>		


</script>