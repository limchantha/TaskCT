<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); ?>
<div id="content">
<style>
input[type="radio"] {
    opacity: 22 !important;
	margin-left: 5px !important;
    margin-top: -2px;
}
div.checker {
    margin-right: 32px;
    margin-left: 50px;
}
.chexright
{
	float:right;
	margin-right: 37%;
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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($service)){ echo $service->id; } ?>" id="register-form<?php if(!empty($service)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/service/add_edit_service_insert/<?php if(!empty($service)){ echo $service->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Task Category Name</label>
                  <div class="controls">
                    <input  type="text" required value="<?php if(!empty($service)){ echo $service->task_name; } ?>" name="task_name" class="ui-wizard-content required input_width" title="Please enter category name">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Task Title</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($service)){ echo $service->task_title; } ?>" name="task_title" class="ui-wizard-content required input_width" title="Please enter category title">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Tasker Descrition</label>
                  <div class="controls">
                    <textarea name="task_description" class="ui-wizard-content input_width required siv" title="Please enter category description"><?php if(!empty($service)){ echo $service->task_description;}?></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Average Price</label>
                  <div class="controls">
                    <input value="<?php if(!empty($service)){ echo $service->avg_price; } ?>" type="text" name="avg_price"  class="ui-wizard-content required input_width" title="Please enter average price">
                  </div>
                </div>
				
				 <div class="control-group">
                  <label class="control-label">Admin Percentage</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($service)){ echo $service->admin_percentage; } ?>" name="admin_percentage"  title="Please enter category admin percentage" class="ui-wizard-content number required input_width">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Cancel Percentage</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($service)){ echo $service->cancel_percentage; } ?>" name="cancel_percentage" title="Please enter category cancel percentage"  class="ui-wizard-content number required input_width">
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Image</label>
                  <div class="controls">
                    <input  type="file"  name="image" class="ui-wizard-content"><br/><br/>
					<div class="form_input"><img  class="display_user_pro" src="<?php if(empty($service)){ echo base_url().'images/site/profile/avatar.png';}else{ echo base_url();?>images/site/category/<?php echo $service->image;}?>" width="100px" height="100px"/></div>
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">	Mobile Icon</label>
                  <div class="controls">
                    <input value="<?php if(!empty($service)){ echo $service->icon; } ?>" title="Please enter category icon name" placeholder="fa-camera" type="file" name="icon"  class="ui-wizard-content input_width">
					<?php if(!empty($service)){ if($service->icon!=""){?>
					<div class="form_input"><img  class="display_user_pro" src="<?php if(empty($service)){ echo base_url().'images/site/category/mobile/icon.png';}else{ echo base_url();?>images/site/category/mobile/<?php echo $service->icon;}?>" /></div>
					<?php }}?>
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">Vehicles</label>
                  <div class="controls">
                    Yes<input  type="radio" value="1" name="vehicle_required" <?php if(!empty($service)){ if($service->vehicle_required==1){ echo "checked";} } ?> style="opacity:100 !important"  class="input_width1">
					No<input  type="radio" value="0" name="vehicle_required" <?php if(empty($service)){ echo "checked"; } else { if($service->vehicle_required!=1){ echo "checked";  } } ?> style="opacity:100 !important"   class="input_width1">
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
 <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>
$(document).ready(function(){
	
tinymce.init({
  selector: ".siv",
  height: 150,
  plugins: [
    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern"
  ],

  toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
  toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
  toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",

  menubar: false,
  toolbar_items_size: 'small',

  style_formats: [{
    title: 'Bold text',
    inline: 'b'
  }, {
    title: 'Red text',
    inline: 'span',
    styles: {
      color: '#ff0000'
    }
  }, {
    title: 'Red header',
    block: 'h1',
    styles: {
      color: '#ff0000'
    }
  }, {
    title: 'Example 1',
    inline: 'span',
    classes: 'example1'
  }, {
    title: 'Example 2',
    inline: 'span',
    classes: 'example2'
  }, {
    title: 'Table styles'
  }, {
    title: 'Table row 1',
    selector: 'tr',
    classes: 'tablerow1'
  }],

  templates: [{
    title: 'Test template 1',
    content: 'Test 1'
  }, {
    title: 'Test template 2',
    content: 'Test 2'
  }],
  content_css: [
    '//www.tinymce.com/css/codepen.min.css'
  ]
});
});
</script>
<?php $this->load->view('admin/common/footer');?>
