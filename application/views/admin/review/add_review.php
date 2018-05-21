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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($review_list)){ echo $review_list->id; } ?>" id="register-form<?php if(!empty($review_list)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/review/add_edit_review_insert/<?php if(!empty($review_list)){ echo $review_list->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
               
                <div class="control-group">
                  <label class="control-label">Tasker Name</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($review_list)){ echo $review_list->name; } ?>" name="name" class="ui-wizard-content required input_width" title="Please enter tasker name">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Tasker Designation</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($review_list)){ echo $review_list->designation; } ?>" name="designation" class="ui-wizard-content required input_width" title="Please enter tasker designation">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Tasker comment</label>
                  <div class="controls">
                    <textarea name="comments" class="ui-wizard-content input_width required" title="Please enter comment"><?php if(!empty($review_list)){ echo $review_list->comments;}?></textarea>
                  </div>
                </div>
               </div>
                <div class="control-group">
                  <label class="control-label">Image</label>
                  <div class="controls">
                    <input  type="file"  name="photo" class="ui-wizard-content"><br/><br/>
					<?php if(!empty($review_list)){ if($review_list->photo!=""){?>
					<div class="form_input"><img  class="display_user_pro" src="<?php if(empty($review_list)){ echo base_url().'images/site/profile/avatar.png';}else{ echo base_url();?>images/site/category/<?php echo $review_list->photo;}?>" width="100px" height="100px"/></div>
					<?php }}?>
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
