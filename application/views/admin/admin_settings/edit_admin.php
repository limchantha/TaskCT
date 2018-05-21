<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); #error_reporting(0); ?>
<div id="content">

<!--breadcrumbs-->
  <div id="content-header">
  
    <div id="breadcrumb"> <a href="javascript:void(0);" title="<?php echo $heading;?>" class="tip-bottom"><i class="icon-home"></i> <?php echo $heading;?></a>
		
	</div>
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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($user)){ echo $user->id; } ?>" id="subregister-form<?php if(!empty($user)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/admin_settings/update_password/<?php if(!empty($user)){ echo $user->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
               
				<div class="control-group">
                  <label class="control-label">Email</label>
                  <div class="controls">
                    <input autocomplete="off" value="<?php if(!empty($user)){ echo $user->email; } ?>" type="text" name="email"  class="ui-wizard-content email required">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Password</label>
                  <div class="controls">
                    <input  type="password" autocomplete="off" name="password" class="ui-wizard-content <?php if(empty($user)){ echo "required"; } ?>">
                  </div>
                </div>
                
				
              </div>
             
              <div class="form-actions">
                <input id="next" class="btn btn-primary ui-wizard-content ui-formwizard-button" type="submit" value="Save">
                <div id="status"></div>
              </div>
              <div id="submitted"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
	$(document).ready(function() {
    $.validator.addMethod("nameRegex", function(value, element) {
        return this.optional(element) || /^[a-z\- . ]+$/i.test(value);
    }, "Username must contain only letters, numbers, or dashes.");
    $.validator.addMethod("number", function(value, element) {
        return this.optional(element) || /^[0-9\-( ) + ]+$/i.test(value);
    }, "For Eg:1234567890, this field allows numbers,+,hyphen,(),single space only.");
    $("#subregister-form").validate();
    $("#subregister-form-edit").validate();
});
</script>
</div>
<?php $this->load->view('admin/common/footer');?>
