<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); ?>
<div id="content">
<style>
input, textarea, .uneditable-input {
    width: 662px;
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
            <form enctype="multipart/form-data" autocomplete="false"  id="register-form" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/admin_settings/save_admin_settings/1" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Admin Email</label>
                  <div class="controls">
                    <input  type="email" value="<?php if(!empty($setting)){ echo $setting->admin_email; } ?>" name="admin_email" class="ui-wizard-content required">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Site Name</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->site_name; } ?>" name="site_name" class="ui-wizard-content">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Meta Title</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->meta_title; } ?>" name="meta_title" class="ui-wizard-content">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Meta Description</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->meta_description; } ?>" name="meta_description" class="ui-wizard-content">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Meta Keywords</label>
                  <div class="controls">
                    <input value="<?php if(!empty($setting)){ echo $setting->meta_keywords; } ?>" type="text" name="meta_keywords"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Site Logo</label>
                  <div class="controls">
                    <input type="file" name="site_logo"  class="ui-wizard-content">
					<br/><br/>
					<div class="form_input"><img  class="" src="<?php if($setting->site_logo==''){ echo base_url().'images/site/profile/avatar.png';}else{ echo base_url();?>images/site/logo/<?php echo $setting->site_logo;}?>" /></div>
                  </div>
                </div>
				 <div class="control-group">
                  <label class="control-label">Site Logo1</label>
                  <div class="controls">
                    <input type="file" name="site_logo1"  class="ui-wizard-content">
					<br/><br/>
					<div class="form_input"><img  class="" src="<?php if($setting->site_logo1==''){ echo base_url().'images/site/profile/avatar.png';}else{ echo base_url();?>images/site/logo/<?php echo $setting->site_logo1;}?>" /></div>
                  </div>
                </div>
				 <div class="control-group">
                  <label class="control-label">Site Favicon</label>
                  <div class="controls">
                    <input type="file" name="site_favicon"  class="ui-wizard-content">
					<br/><br/>
					<div class="form_input"><img  class="" src="<?php if($setting->site_favicon==''){ echo base_url().'images/site/profile/avatar.png';}else{ echo base_url();?>images/site/logo/<?php echo $setting->site_favicon;}?>" /></div>
                  </div>
                </div>
				 <div class="control-group">
                  <label class="control-label">Fb App Id</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->fb_app_id; } ?>" name="fb_app_id"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Fb app secret</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->fb_app_secret; } ?>" name="fb_app_secret"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Twitter app id</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->twitter_app_id; } ?>" name="twitter_app_id"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Twitter Name</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->fb_app_id; } ?>" name="twitter_name"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Home title1</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->home_title1; } ?>" name="home_title1"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Home title2</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->home_title1; } ?>" name="home_title1"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Copy Right</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->copy_right; } ?>" name="copy_right"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Gmail client id</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->gmail_client_id; } ?>" name="gmail_client_id"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Gmail client secret</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->gmail_client_secret; } ?>" name="gmail_client_secret"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Gmail redirect url</label>
                  <div class="controls">
                    <input  type="hidden" value="<?php echo base_url();?>site/user/google_response/" name="gmail_redirect_url"  class="ui-wizard-content">
					<span class="ui-wizard-content">Gmail redirect url: <?php echo base_url();?>site/user/google_response/</span>
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Gmap key</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->gmap_key; } ?>" name="gmap_key"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">SMTP Host</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->smtp_host; } ?>" name="smtp_host"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">SMTP Port</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->smtp_port; } ?>" name="smtp_port"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">SMTP Email</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($setting)){ echo $setting->smtp_user; } ?>" name="smtp_user"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">SMTP Password</label>
                  <div class="controls">
                    <input  type="password" autocomplete="off" value="<?php if(!empty($setting)){ echo $setting->smtp_pass; } ?>" name="smtp_pass"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
				  <label class="control-label">Tasker Signup Verification</label>
				  <?php 
				  if(!empty($setting)){
					if($setting->tasker_automation==1)
					{
						$auto="checked";
						$mannuel="";
					}
					if($setting->tasker_automation==0)
					{
						$auto="";
						$mannuel="checked";
					}
				  }
				  else{
					     $auto="";
						$mannuel="checked";
				  }
					  
				  
				  ?>
				  <div class="controls">
					<label class="line-inline_new">
					  <input  type="radio" <?php echo $auto;?>  name="tasker_automation"  value="1" class="ui-wizard-content">
					  Mannual</label>
					<label class="line-inline_new">
					 <input  type="radio" <?php echo $mannuel;?>   name="tasker_automation"  value="0" class="ui-wizard-content">
					  Automatic</label>
					
				  </div>
				
				</div>
				  <div class="control-group">
                  <label class="control-label">Messagebird Username</label>
                  <div class="controls">
                    <input  type="text" autocomplete="off" value="<?php if(!empty($setting)){ echo $setting->messagebird_username; } ?>" name="messagebird_username"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Messagebird Password</label>
                  <div class="controls">
                    <input  type="text" autocomplete="off" value="<?php if(!empty($setting)){ echo $setting->messagebird_password; } ?>" name="messagebird_password"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Messagebird from Number</label>
                  <div class="controls">
                    <input  type="text" autocomplete="off" value="<?php if(!empty($setting)){ echo $setting->messagebird_number; } ?>" name="messagebird_number"  class="ui-wizard-content">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Messagebird country code</label>
                  <div class="controls">
                    <input  type="text" autocomplete="off" value="<?php if(!empty($setting)){ echo $setting->messagebird_country_code; } ?>" name="messagebird_country_code"  class="ui-wizard-content">
                  </div>
                </div>
				
              </div>
             
              <div class="form-actions">
                 <input  type="hidden" value="<?php echo base_url(); ?>" name="base_url"  class="ui-wizard-content">
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
