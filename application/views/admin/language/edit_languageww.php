<?php
	$this->load->view('templates/header.php');
?>
	<section id="main-content">
          <section class="wrapper">
		        <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                           Edit Language
                          </header>
                          <div class="panel-body">
                              <form class="form-horizontal" id="language_form" role="form">
								  <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 control-label">Language Name</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="lang_name" name="lang_name" placeholder="language name" value="<?php echo $edit_language[0]->lang_name; ?>" required>
                                      </div>
								   </div>
								   <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 control-label">Language Code</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="lang_code" name="lang_code" placeholder="language code" value="<?php echo $edit_language[0]->lang_code; ?>" required>
                                      </div>
								   </div>
								   <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 control-label">Status</label>
                                      <div class="col-lg-6">
                                          <select id="lang_status" name="lang_status" class="form-control">
											<option value="Active"<?php if($edit_language[0]->status == 'Active'){ echo "selected=selected";}?>>Active</option>
											<option value="Inactive"<?php if($edit_language[0]->status == 'Inactive'){ echo "selected=selected";}?>>Inactive</option>
										  </select>
                                      </div>
                                  </div>
								</form><br/><br/><br/>
									<input type="hidden" name="lang_id" id="lang_id" value="<?php echo $edit_language[0]->id; ?>">
									<div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button onclick = "save_language()" class="btn btn-info">Update</button>
										  <button onclick = "clear_category()" class="btn btn-danger">Clear</button>
                                      </div>
                                  </div>
							</div>
                      </section>
                  </div>
              </div>
              <!-- Inline form-->
             
              <!-- page end-->
          </section>
      </section>
	  <style>
	 .logo-len{
		 text-align:center;
	 }
	 </style>
<script>
	var baseUrl = '<?php echo base_url();?>';
	  $(document).ready(function(){
	    $("#language_form").validate({
			rules: {
				lang_name: "required",
				lang_code: "required",
			},
				 
			submitHandler: function(form){
				form.submit();
			}
		 
		});
	});
	
	function save_language(){
		var is_valid	= $('#language_form').valid();
		if(!is_valid)
		{
			return false;
		}
		var filename = baseUrl+'language/save_language';
		var request  = $.ajax({
		  url  : filename,
		  type : "POST",
		  data : {     
				 lang_name     		:  $("#lang_name").val(), 
				 lang_code   		:  $("#lang_code").val(),
				 lang_status   		:  $("#lang_status").val(),
				 lang_id       	    :  $("#lang_id").val(), 

			},
			dataType : "html"
		});
		
		request.done(function(result){
			var output    = jQuery.parseJSON(result);
			
			if(output.flag == 1){	
			location.href = baseUrl+"language";
			}
			if(output.flag == 3){
			swal(
			  'Oops...',
			  'This language already exist!',
			  'error'
			);
			}  
		});
		
		request.fail(function(jqXHR,textStatus){
		  alert(textStatus);
		});     		
	}
	
	function clear_category(){
		$("#lang_name").val("")
		$("#lang_code").val("")
	}
</script>
	<?php
	$this->load->view('templates/footer.php'); ?>