<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); ?>
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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($user)){ echo $user->id; } ?>" id="register-form<?php if(!empty($user)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/tasker/add_edit_insert/<?php if(!empty($user)){ echo $user->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Firstname</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($user)){ echo $user->first_name; } ?>" name="first_name" class="ui-wizard-content">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Lastname</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($user)){ echo $user->last_name; } ?>" name="last_name" class="ui-wizard-content">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Password</label>
                  <div class="controls">
                    <input  type="password" name="password" class="ui-wizard-content">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Email</label>
                  <div class="controls">
                    <input value="<?php if(!empty($user)){ echo $user->email; } ?>" type="text" name="email"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Mobile</label>
                  <div class="controls">
                    <input value="<?php if(!empty($user)){ echo $user->phone; } ?>" type="text" name="phone"  class="ui-wizard-content number">
                  </div>
                </div>
				 <div class="control-group">
                  <label class="control-label">Zip Code</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($user)){ echo $user->zipcode; } ?>" name="zipcode"  class="ui-wizard-content">
                    <input  type="hidden" value="1" name="group"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Profile Image</label>
                  <div class="controls">
                    <input  type="file"  name="photo" class="ui-wizard-content"><br/><br/>
					<div class="form_input"><img  class="display_user_pro" src="<?php if(empty($user)){ echo base_url().'images/site/profile/avatar.png';}else{ echo base_url();?>images/site/profile/<?php echo $user->photo;}?>" width="100px" height="100px"/></div>
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

</div>
<?php $this->load->view('admin/common/footer');?>
