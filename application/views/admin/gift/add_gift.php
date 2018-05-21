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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($gift_list)){ echo $gift_list->id; } ?>" id="register-form<?php if(!empty($gift_list)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/gift/add_edit_gift_insert/<?php if(!empty($gift_list)){ echo $gift_list->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
               
                <div class="control-group">
                  <label class="control-label">Gift card Name</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($gift_list)){ echo $gift_list->name; } ?>" name="name" class="ui-wizard-content required input_width" title="Please enter gift card name">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Gift card price</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($gift_list)){ echo $gift_list->price; } ?>" name="price" class="ui-wizard-content required input_width number" title="Please enter gift card price">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Gift Price worth</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($gift_list)){ echo $gift_list->gift_price; } ?>" name="gift_price" class="ui-wizard-content required input_width number" title="Please enter gift price worth">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Gift card booking use limit</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($gift_list)){ echo $gift_list->use_limit; } ?>" name="use_limit" class="ui-wizard-content required input_width number" title="Please enter card limit">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Min Price for gift card use</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($gift_list)){ echo $gift_list->min_price; } ?>" name="min_price" class="ui-wizard-content required input_width number" title="Please enter min price for gift card use for booking">
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
