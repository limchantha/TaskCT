<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); #error_reporting(0); ?>
<div id="content">
<style>
/* input[type="checkbox"] {
    opacity: 22 !important;
}
div.checker {
    margin-right: 32px;
    margin-left: 50px;
}*/
.chexright
{
	float:right;
	margin-right: 37%;
} 
label {
    display: block;
    margin-bottom: 11px;
}
label.inline {
    display: inline-block;
}
</style>
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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($user)){ echo $user->id; } ?>" id="subregister-form<?php if(!empty($user)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/subadmin/add_edit_insert/<?php if(!empty($user)){ echo $user->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Firstname</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($user)){ echo $user->firstname; } ?>" name="firstname" class="ui-wizard-content required">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Lastname</label>
                  <div class="controls">
                    <input  type="text"  value="<?php if(!empty($user)){ echo $user->lastname; } ?>" name="lastname" class="ui-wizard-content required">
                  </div>
                </div>
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
                
				<div class="control-group">
                  <label class="control-label">Access Permissions</label>
                  <div class="controls">
				  <?php if(!empty($user)){ $per_exist= unserialize($user->permission); 
				  
				  }else {$per_exist=array();}  ?>
						<label>Management            
						<ul class="chexright inline">
						 <li class="chexright1 check_view">View </li>
						 <li class="chexright1 check_add">Add</li>
						 <li class="chexright1 check_edit"> Edit </li>
						 <li class="chexright1 check_delete">Delete</li>
						</ul>
            </label>
						<?php $per=explode(',',$this->config->item('permissions')); $i=0; foreach($per as $pr){ ?> 	
						<div ><label  class="inline"><?php echo $pr;?> </label>
						<ul class="chexright inline">
						<li>
						<input title="View" <?php if(!empty($per_exist["$pr"])){if(is_array($per_exist["$pr"])){  if(in_array('0',$per_exist["$pr"])){ echo "checked"; }}}?> type="checkbox" value="0"  name="<?php echo $pr;?>[]" /></li>
						<li>
						<input title="Add" type="checkbox" value="1" <?php if(!empty($per_exist["$pr"])){ if(is_array($per_exist["$pr"])){ if(in_array('1',$per_exist["$pr"])){ echo "checked"; }}}?> name="<?php echo $pr;?>[]" /></li>
						<li>
						<input type="checkbox" title="Edit" value="2"  <?php if(!empty($per_exist["$pr"])){ if(is_array($per_exist["$pr"])){ if(in_array('2',$per_exist["$pr"])){ echo "checked"; }}}?> name="<?php echo $pr;?>[]" /></li>
						<li>
						<input type="checkbox" <?php if(!empty($per_exist["$pr"])){ if(is_array($per_exist["$pr"])){ if(in_array('3',$per_exist["$pr"])){ echo "checked"; }}}?> name="<?php echo $pr;?>[]" title="Delete" value="3" /></li></ul></div>
						<?php $i++;}?>
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
