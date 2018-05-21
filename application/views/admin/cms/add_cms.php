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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($service)){ echo $service->id; } ?>" id="register-form<?php if(!empty($service)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/cms/add_edit_cms_insert/<?php if(!empty($service)){ echo $service->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Title</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($service)){ echo $service->title; } ?>" name="title" class="ui-wizard-content required input_width" title="Please enter title">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Page content</label>
                  <div class="controls">
                    <textarea name="content" class="ui-wizard-content input_width required siv" title="Please enter content"><?php if(!empty($service)){ echo $service->content;}?></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Footer order</label>
                  <div class="controls">
                    <select name="footer_order" class="ui-wizard-content input_width required ">
						<option value=""></option>
						<option value="row1" <?php if(!empty($service)){ if($service->footer_order=="row1"){ echo "selected";}}?>>Row1</option>
						<option value="row2" <?php if(!empty($service)){ if($service->footer_order=="row2"){ echo "selected";}}?>>Row2</option>
						<option value="row3" <?php if(!empty($service)){ if($service->footer_order=="row3"){ echo "selected";}}?>>Row3</option>
						<option value="services" <?php if(!empty($service)){ if($service->footer_order=="services"){ echo "selected";}}?>>Services</option>
					</select>
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
<script>
$(document).ready(function(){ $('#register-form').validate();});
</script>
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
