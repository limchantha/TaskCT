<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); ?>
<div id="content">
<style>
.form-horizontal .controls {
    margin-left: 200px;
    padding: 16px 0;
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
            <form enctype="multipart/form-data"  class="form-horizontal ui-formwizard" action="#" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Name</label>
                  <div class="controls">
                    <?php echo ucfirst($task->row()->name);?>
                  </div>
                </div>
               
                  <div class="control-group">
                  <label class="control-label">Email</label>
                  <div class="controls">
                    <?php echo $task->row()->email;?>
                  </div>
                </div>
               
                  <div class="control-group">
                  <label class="control-label">Phone</label>
                  <div class="controls">
                    <?php echo $task->row()->phone;?>
                  </div>
                </div>
               
                  <div class="control-group">
                  <label class="control-label">Message</label>
                  <div class="controls">
                    <?php echo $task->row()->message;?>
                  </div>
                </div>
               
                
              </div>
             
              <div class="form-actions">
                <a class="btn btn-success" href="<?php echo base_url()?>admin/contact/display_contact_list/">Back</a>
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
