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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($service)){ echo $service->id; } ?>" id="register-form<?php if(!empty($service)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/subcat/add_edit_servicecat_insert/<?php if(!empty($service)){ echo $service->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Task Category </label>
                  <div class="controls">
                   <select class="cat_id required" name="cat_id" title="Choose Task Category">
						<option value="">Choose Task Category</option>
						<?php foreach($service_list->result() as $service_ls){?>
						<option value="<?php echo $service_ls->id;?>" <?php if(!empty($service)){ if($service->cat_id==$service_ls->id){ echo "selected";}}?>><?php echo ucfirst($service_ls->task_name);?></option>	
						<?php }?>		
				   </select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Sub Category Name</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($service)){ echo $service->subcat_name; } ?>" name="subcat_name" class="ui-wizard-content required input_width" title="Please enter category title">
                  </div>
                </div>
               </div>
             <div class="control-group">
                  <label class="control-label">Image</label>
                  <div class="controls">
                    <input  type="file"  name="image" class="ui-wizard-content"><br/><br/>
					<?php if(!empty($service)){ if($service->image!=""){?>
					<div class="form_input"><img  class="display_user_pro" src="<?php if(empty($service)){ echo base_url().'images/site/profile/avatar.png';}else{ echo base_url();?>images/site/category/<?php echo $service->image;}?>" width="100px" height="100px"/></div>
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
