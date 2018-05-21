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
            <form enctype="multipart/form-data" data-user-id="<?php if(!empty($currency)){ echo $currency->id; } ?>" id="register-form<?php if(!empty($currency)){ echo "-edit"; } ?>" class="form-horizontal ui-formwizard" action="<?php echo base_url();?>admin/currency/add_edit_currency_insert/<?php if(!empty($currency)){ echo $currency->id; } ?>" method="post" novalidate="novalidate">
              <div id="form-wizard-1" class="step ui-formwizard-content" style="display: block;">
                <div class="control-group">
                  <label class="control-label">Country Name </label>
                  <div class="controls">
                  <input  type="text" value="<?php if(!empty($currency)){ echo $currency->country_name; } ?>" name="country_name" class="ui-wizard-content required input_width" title="Please enter country name">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Currency Symbol</label>
                  <div class="controls">
                    <input  type="text" value="<?php if(!empty($currency)){ echo $currency->currency_symbols; } ?>" name="currency_symbols" class="ui-wizard-content required input_width" title="Please enter currency symbol">
                  </div>
                </div>
               </div>
             <div class="control-group">
                  <label class="control-label">Currency Code</label>
                  <div class="controls">
                   <input  type="text" value="<?php if(!empty($currency)){ echo $currency->currency_type; } ?>" name="currency_type" class="ui-wizard-content required input_width" title="Please enter currency code">
                  </div>
             </div>
             <div class="control-group">
                  <label class="control-label">Currency Rate (Please enter 1usd rate)</label>
                  <div class="controls">
                   <input  type="text" value="<?php if(!empty($currency)){ echo $currency->currency_rate; } ?>" name="currency_rate" class="ui-wizard-content required input_width" title="Please enter currency rate ">
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
