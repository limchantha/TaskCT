<?php $this->load->view('admin/common/header.php'); ?>
<?php 
$this->lang->load($selectedLanguage, $selectedLanguage);
$this->load->view('admin/common/sidebar.php'); 
?>
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/sweetalert.css" />
<div id="content">
<!--breadcrumbs-->
	<div id="content-header">
		<div id="breadcrumb"> <a href="javascript:void(0);" title="<?php echo $heading;?>" class="tip-bottom"><i class="icon-home"></i> <?php echo $heading;?></a> </div>
	</div>
<!--End-breadcrumbs-->
<div class="container-fluid">
    <div class="row-fluid">
		<div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
            <h5><?php echo $heading;?></h5>
          </div>
          <div class="widget-content nopadding">
            <form  id="language_form" class="form-horizontal ui-formwizard" method="post" action ="<?php echo base_url(); ?>admin/language/add_new_lang" id="lang_form">
				<?php 
				$loopNumber = 0;
				foreach(array_slice($file_key_values,1) as $val) {  ?>
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label"><?php echo stripslashes($file_lang_values[$loopNumber]); ?></label>
                  <div class="controls">
					 <input type="text" classui-wiza="rd-content" id="lang_name" name="lang_name[]" placeholder="language name" value="<?php  echo stripslashes($this->lang->line($val)); ?>" required>
					<input type="hidden" id="lang_key" name="lang_key[]" value="<?php echo $val;  ?>">
                  </div>
                </div>
              </div>
			  <?php 
				$loopNumber = $loopNumber+1; 
				}
				?>
			   <input type="hidden" value="<?php echo $selectedLanguage;?>" name="selectedLanguage"/>
              <div class="form-actions">
			  <input  type="hidden" id="lang_id" name="lang_id" value="">
			  <button type="submit" class="btn btn-primary ui-wizard-content ui-formwizard-button">Update</button>
                <div id="status"></div>
              </div>
              <div id="submitted"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?php echo base_url();?>js/admin/sweetalert.min.js"></script>  

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
		var filename = baseUrl+'admin/language/save_language';
		var request  = $.ajax({
		  url  : filename,
		  type : "POST",
		  data : {     
				 lang_name     		:  $("#lang_name").val(), 
				 lang_code   		:  $("#lang_code").val(),
				 lang_status   		:  $("#lang_status").val(),
				 lang_id   			:  $("#lang_id").val(),

			},
			dataType : "html"
		});
		
		request.done(function(result){
			var output    = jQuery.parseJSON(result);
			
			if(output.flag == 1){	
				location.href = baseUrl+"admin/language";
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

</script>
</div>
<?php $this->load->view('admin/common/footer');?>
