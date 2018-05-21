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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($service)){ echo $service->id; } ?>" id="register-form<?php if(!empty($service)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/payments/add_edit_payments_insert/<?php if(!empty($service)){ echo $service->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Name</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($service)){ echo $service->name; } ?>" name="name" class="ui-wizard-content required input_width" title="Please enter title">
                  </div>
                </div>
				<?php if(!empty($service)){ $tar=(json_decode($service->detail,true)); foreach($tar as $key=>$value){ if($key!="mode"){ ?>
                <div class="control-group">
                  <label class="control-label"><?php echo ucfirst(str_replace('_',' ',$key));?> </label>
                  <div class="controls">
                    <input  type="text" value="<?php  echo $value;  ?>" name="<?php echo $key;?>" class="ui-wizard-content required input_width" title="Please enter <?php echo ucfirst(str_replace('_',' ',$key));?> ">
                  </div>
                </div>
                <?php } else {  ?>
				<div class="control-group">
                  <label class="control-label">Account Mode Test/Live</label> 
				 <div class="controls">
					
							<div class="switch">
							<input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-round-flat" <?php if($value==1){echo "checked";}?> name="mode" type="checkbox">
							<label for="cmn-toggle-4"></label>
							</div>
						
						
					</div>

				</div>
				<?php }}} ?>
                 
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
<script>
$(document).ready(function(){ $('#register-form').validate();});
</script>


<?php $this->load->view('admin/common/footer');?>

