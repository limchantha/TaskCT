<?php $this->load->view('site/common/header');	?>

<script src="<?php echo base_url();?>js/site/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>js/site/jquery.form.js"></script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>

<div class="grid_3">
  <div class="container">
    <form id="reg" name="reg" method="post" action="javascript:;" enctype="multipart/form-data">
   <div class="services">
   
   	  <div class="col-sm-6 login_left">
      <div class="breadcrumb1">
     <ul>
        <a href="index.html"><i class="fa fa-home home_1"></i></a>
        <span class="divider">&nbsp;|&nbsp;</span>
        <li class="current-page"><?php echo  $this->lang->line('basic_info'); ?></li>
     </ul>
   </div>
	    
	  	    <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('name_prospective'); ?>: <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="name" value="" size="60" maxlength="60" class="form-text">
		    </div>
             <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('email'); ?>:  <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="email" value="" size="60" maxlength="60" class="form-text">
		    </div>
		    <div class="form-group">
		      <label for="edit-pass"><?php echo  $this->lang->line('age'); ?> <span class="form-required" title="This field is required.">*</span></label>
		       <div class="select-block1">
        <select name="age">
        <?php for($i=18; $i<=45; $i++) {?>
          <option value="<?php echo $i; ?>"><?php echo $i?></option>
            <?php } ?>
       </select>
      </div>
		    </div>
		    <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('gender'); ?> <span class="form-required" title="This field is required.">*</span></label>
              <div class="select-block1">
		      <select name="gender">
      
          <option value="M"><?php echo 'Male'?></option>
          <option value="F"><?php echo 'Female'?></option>
           
       </select>
		    </div>
            </div>
		    <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('marital_status'); ?> <span class="form-required" title="This field is required.">*</span></label>
		      <div class="select-block1">
		      <select name="marital_status">
      
          <option value="Single"><?php echo 'Single'?></option>
          <option value="Married"><?php echo 'Married'?></option>
           
       </select>
		    </div>
		    </div>
            <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('date_of_birth'); ?> <span class="form-required" title="This field is required.">*</span></label>
		      <input type="date"  name="dob" value="" size="60" maxlength="60" class="form-text">
		    </div>
            <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('height'); ?> <span class="form-required" title="This field is required.">*</span></label>
		     
              <div class="select-block1">
        <select name="height">
        <?php for($i=4; $i<=7; $i++) {?>
        <?php for($j=1; $j<=12; $j++){ ?>
          <option value="<?php echo $i.' Ft '.$j.' In'; ?>"><?php echo $i.' Ft '.$j.' In'; ?></option>
            <?php } ?>
            <?php } ?>
       </select>
      </div>
		    </div>
            <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('present_address'); ?> <span class="form-required" title="This field is required.">*</span></label>
              <textarea type="text"  name="present_address" value="" style="height: 135px;" class="form-textarea required"></textarea>
		      
		    </div>
            
            <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('permanent_address'); ?> <span class="form-required" title="This field is required.">*</span></label>
              <textarea type="text"  name="permanent_address" value="" style="height: 140px;" class="form-textarea required"></textarea>
		      
		    </div>
            <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('mobile_no'); ?> <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="moblie" value="" size="60" maxlength="60" class="form-text">
		    </div>
        
	  </div>
	  <div class="col-sm-6 login_right">
      <div class="breadcrumb1">
     <ul>
        <a href="index.html"><i class="fa fa-home home_1"></i></a>
        <span class="divider">&nbsp;|&nbsp;</span>
        <li class="current-page"><?php echo  $this->lang->line('community_details'); ?></li>
     </ul>
   </div>
	    
	  	    <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('nationality'); ?>
: <span class="form-required" title="This field is required.">*</span></label>
		      <div class="select-block1">
        <select name="nationality">
            <option value="">Nationality</option>
            <option value="INDIAN">INDIAN</option>
       </select>
      </div>
		    </div>
             <div class="form-group">
		      <label for="edit-name"><?php echo  $this->lang->line('religion'); ?>:  <span class="form-required" title="This field is required.">*</span></label>
		    <div class="select-block1">   <select name="religion">
                      <option value="" label="Select" selected="selected">Select</option>
						<option value="Hindu" label="Hindu">Hindu</option>
						<option value="Muslim - slia" label="Muslim - slia">Muslim - slia</option>
						<option value="Muslim - sunni" label="Muslim - sunni">Muslim - sunni</option>
						<option value="Muslim - other" label="Muslim - other">Muslim - other</option>
						<option value="Christian - catholic" label="Christian - catholic">Christian - catholic</option>
						<option value="Christian - orthodox" label="Christian - orthodox">Christian - orthodox</option>
						<option value="Christian - Prostant" label="Christian - Prostant">Christian - Prostant</option>
						<option value="Christian - others" label="Christian - others">Christian - others</option>
						<option value="Sikh" label="Sikh">Sikh</option>
						<option value="Buddhist" label="Buddhist">Buddhist</option>
						<option value="Jain" label="Jain ">Jain </option>
						<option value="Inter religion" label="Inter religion">Inter religion</option>
						<option value="No religious Belief" label="No religious Belief">No religious Belief</option>
					  </select>
					</div>
					</div>
					<div class="form-group">
					<label for="edit-pass"><?php echo $this->lang->line('caste'); ?> <span class="form-required" title="This field is required.">*</span></label>
					<div class="select-block1">   <select name="caste">
					<option value="" label="Select" selected="selected">Select</option>
						 <option value="" label="Select" selected="selected">Select</option>
						<option value="Adidravida" label="Adidravida">Adidravida</option>
						<option value="Arunthathiyar" label="Arunthathiyar">Arunthathiyar</option>
						<option value="Brahmin - Gurukkal" label="Brahmin - Gurukkal">Brahmin - Gurukkal</option>
						<option value="Brahmin - Iyengar" label="Brahmin - Iyengar">Brahmin - Iyengar</option>
						<option value="Brahmin - Iyer" label="Brahmin - Iyer">Brahmin - Iyer</option>
						<option value="Brahmin - others" label="Brahmin - others">Brahmin - others</option>
						<option value="Chettiar" label="Chettiar">Chettiar</option>
						<option value="Devendra kula vellalar" label="Devendra kula vellalar">Devendra kula vellalar</option>
						<option value="Devar - Mukkulathor" label="Devar - Mukkulathor">Devar - Mukkulathor</option>
						<option value="Gounder" label="Gounder">Gounder</option>
						<option value="Intercaste" label="Intercaste">Intercaste</option>
						<option value="Maruthuvar" label="Maruthuvar">Maruthuvar</option>
						<option value="Madhaliyar" label="Madhaliyar">Madhaliyar</option>
						<option value="Nadar" label="Nadar ">Nadar </option>
						<option value="Naicker" label="Naicker">Naicker</option>
						<option value="Naidu" label="Naidu ">Naidu </option>
						<option value="Pandaram" label="Pandaram">Pandaram</option>
						<option value="Pillai" label="Pillai">Pillai</option>
						<option value="SC" label="SC">SC</option>
						<option value="ST" label="ST">ST</option>
						<option value="Sourashtra" label="Sourashtra">Sourashtra</option>
						<option value="Vellalar" label="Vellalar">Vellalar</option>
						<option value="Viswakarma" label="Viswakarma">Viswakarma</option>
						<option value="Yadav" label="Yadav">Yadav</option>
						<option value="Others" label="Others">Others</option>
					  </select>
		    </div>
		    </div>
		    <div class="form-group">
		      <label for="edit-name">Subcaste <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="sub_caste" value="" size="60" maxlength="60" class="form-text">
		    </div>
            <div class="form-group">
		      <label for="edit-name">Veg / Non Veg <span class="form-required" title="This field is required.">*</span></label>
              <div class="select-block1">   <select name="veg_non_veg">
		       <option value="" label="Select" selected="selected">Select</option>
                      <option value="Veg" label="Veg">Veg</option>
                      <option value="Non Veg" label="Non Veg">Non Veg</option>
                      </select>
                      </div>
		    </div>
            <div class="form-group">
		      <label for="edit-name">Star <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="star" value="" size="60" maxlength="60" class="form-text">
		    </div><div class="form-group">
		      <label for="edit-name">Gothram <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="gothram" value="" size="60" maxlength="60" class="form-text">
		    </div>
            <div class="form-group">
		      <label for="edit-name">Padam <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="padam" value="" size="60" maxlength="60" class="form-text">
		    </div>
            <div class="form-group">
		      <label for="edit-name">Dosham, if any <span class="form-required" title="This field is required.">*</span></label>
		      <div class="select-block1">   <select name="dosham" > <option value="" label="Select" selected="selected">Select</option>                      <option value="Chevvai dosham" label="Chevvai dosham">Chevvai dosham</option>
					  					  <option value="Mangalya dosham" label="Mangalya dosham">Mangalya dosham</option>
					  					  <option value="Kuja dosham" label="Kuja dosham">Kuja dosham</option>
					  					  <option value="Naga dosham" label="Naga dosham">Naga dosham</option>
					  					  <option value="None" label="None">None</option>
                                          </select>
                                          </div>
		    </div>
         
	  </div>
      <div class="col-sm-6 login_right">
      <div class="breadcrumb1">
     <ul>
        <a href="index.html"><i class="fa fa-home home_1"></i></a>
        <span class="divider">&nbsp;|&nbsp;</span>
        <li class="current-page">EDUCATIONAL AND PROFESSIONAL INFORMATION</li>
     </ul>
   </div>
	    
	  	    <div class="form-group">
            
		      <label for="edit-name">Academic / Technical Qualification: <span class="form-required" title="This field is required.">*</span></label>
              <input type="text"  name="degrees" value="" size="60" maxlength="60" class="form-text">
		     
		    </div>
             <div class="form-group">
		      <label for="edit-name">Occupation:  <span class="form-required" title="This field is required.">*</span></label>
              <input type="text"  name="occupation" value="" size="60" maxlength="60" class="form-text">
                
		    </div>
		    <div class="form-group">
		      <label for="edit-pass">Salary income <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="salary" size="60" maxlength="128" class="form-text">
		    </div>
		    
		
	  </div>
      
      <div class="col-sm-6 login_right">
      <div class="breadcrumb1">
     <ul>
        <a href="index.html"><i class="fa fa-home home_1"></i></a>
        <span class="divider">&nbsp;|&nbsp;</span>
        <li class="current-page">FAMILY DETAILS</li>
     </ul>
   </div>
	    
	  	    <div class="form-group">
		      <label for="edit-name">Father's name: <span class="form-required" title="This field is required.">*</span></label>
		      <input type="text"  name="fname" value="" size="60" maxlength="60" class="form-text">
		    </div>
            
		    <div class="form-group">
		      <label for="edit-pass">Mother's name <span class="form-required" title="This field is required.">*</span></label>
		      <input type="password"  name="mother" size="60" maxlength="128" class="form-text">
		    </div>
		    <div class="form-group">
		      <label for="edit-name">No. Of Brothers <span class="form-required" title="This field is required.">*</span></label>
		       <div class="select-block1">
        <select name="brothers">
         <option value="0">0</option>
        <?php for($i=1; $i<=6; $i++) {?>
          <option value="<?php echo $i; ?>"><?php echo $i?></option>
            <?php } ?>
       </select>
      </div>
		    </div>
             <div class="form-group">
            <div class="col-sm-6">
		      <label for="edit-name">No. Married Brothers<span class="form-required" title="This field is required.">*</span></label>
		      <div class="select-block1">
        <select name="mbrothers">
         <option value="0">0</option>
        <?php for($i=1; $i<=6; $i++) {?>
          <option value="<?php echo $i; ?>"><?php echo $i?></option>
            <?php } ?>
       </select>
      </div>
		    </div>
             <div class="col-sm-6">
		      <label for="edit-name">No. Unmarried Brothers <span class="form-required" title="This field is required.">*</span></label> 
              <div class="select-block1">
        <select name="ubrothers">
         <option value="0">0</option>
        <?php for($i=1; $i<=6; $i++) {?>
          <option value="<?php echo $i; ?>"><?php echo $i?></option>
            <?php } ?>
       </select>
      </div>
              </div>
              </div>
		    <div class="form-group">
		      <label for="edit-name">No. Of Sisters <span class="form-required" title="This field is required.">*</span></label>
		      <div class="select-block1">
        <select name="sisters">
         <option value="0">0</option>
        <?php for($i=1; $i<=6; $i++) {?>
          <option value="<?php echo $i; ?>"><?php echo $i?></option>
            <?php } ?>
       </select>
      </div>
		    </div>
            <div class="form-group">
            <div class="col-sm-6">
		      <label for="edit-name">No. Married Sisters<span class="form-required" title="This field is required.">*</span></label>
		       <div class="select-block1">
        <select name="msisters">
         <option value="0">0</option>
        <?php for($i=1; $i<=6; $i++) {?>
          <option value="<?php echo $i; ?>"><?php echo $i?></option>
            <?php } ?>
       </select>
      </div>
		    </div>
             <div class="col-sm-6">
		      <label for="edit-name">No. Unmarried Sisters <span class="form-required" title="This field is required.">*</span></label> 
              <div class="select-block1">
        <select name="usisters">
        <option value="0">0</option>
        <?php for($i=1; $i<=6; $i++) {?>
          <option value="<?php echo $i; ?>"><?php echo $i?></option>
            <?php } ?>
       </select>
      </div>
              </div>
              </div>
			 
		
	  </div>
      <div class="col-sm-6 login_left">
      <div class="breadcrumb1">
     <ul>
        <a href="index.html"><i class="fa fa-home home_1"></i></a>
        <span class="divider">&nbsp;|&nbsp;</span>
        <li class="current-page">PARTNER PREFRENCE:</li>
     </ul>
   </div>
	    
	  	    <div class="form-group">
		      <label for="edit-name">(Enter your future partner expectations within 50 words. Please write clearly only in English): <span class="form-required" title="This field is required.">*</span></label>
		      <textarea type="text" name="expectation" value="" style="height: 135px;" class="form-textarea required"></textarea>
		    </div>
            
           <div class="form-group">
           <img src="images/a5.jpg" class="img-responsive" alt="" width="110" id="images_preview1">
		      <label for="edit-name">Photo Upload:  <span class="form-required" title="This field is required.">*</span></label>
		     
              <input type="file"  name="photo_upload" id="photo_upload" value="" size="60" maxlength="60" class="form-text">
		    </div>
            
            <div class="form-group">
            <img src="images/a5.jpg" class="img-responsive" alt="" id="images_preview2" width="110">
		      <label for="edit-name">Horoscope Upload:  <span class="form-required" title="This field is required.">*</span></label>
		      <input type="file"  name="horoscope_upload" id="horoscope_upload"value="" size="60" maxlength="60" class="form-text">
		    </div>
			  <div class="form-actions">
			    <input type="submit" id="edit-submit" name="op" value="Submit" class="btn_1 submit">
			  </div>
		
	  </div>
	  <div class="clearfix"> </div>
   </div>
    </form>
  </div>
 
</div>
<?php $this->load->view('site/common/footer');?>

<script type='text/javascript'>

var inputLocalFont = document.getElementById("photo_upload");
inputLocalFont.addEventListener("change",previewheader,false);

function previewheader(event){
var fileList = this.files;

var anyWindow = window.URL || window.webkitURL;

	for(var i = 0; i < fileList.length; i++){
	var imgname=event.target.files[i].name;
	var ext=imgname.split('.').pop();
	switch (ext) {
		case 'jpg':
		case 'jpeg':
		case 'png':
		case 'JPG':
		case 'JPEG':
		case 'PNG':					
			break;
		default:
		$('#photo_upload').val('');
			alert('This is not an allowed file type.'); return false;
			
	}
	
	  var objectUrl = anyWindow.createObjectURL(fileList[i]);
	  $('#images_preview1').attr('src',objectUrl);
	  window.URL.revokeObjectURL(fileList[i]);
	  
	}
	//$('#header').append('<li><div class="fileUpload btn btn-primary"><a class="add-ico" href="javascript:void(0);" onclick="header();" data-toggle="modal" data-target="#boatimgs"></a></div></li>');
}

var inputLocalFont1 = document.getElementById("horoscope_upload");
inputLocalFont1.addEventListener("change",previewheader1,false);

function previewheader1(event){
var fileList1 = this.files;

var anyWindow = window.URL || window.webkitURL;

	for(var i = 0; i < fileList1.length; i++){
	var imgname=event.target.files[i].name;
	var ext=imgname.split('.').pop();
	switch (ext) {
		case 'jpg':
		case 'jpeg':
		case 'png':
		case 'JPG':
		case 'JPEG':
		case 'PNG':					
			break;
		default:
		$('#horoscope_upload').val('');
			alert('This is not an allowed file type.'); return false;
			
	}
	
	  var objectUrl = anyWindow.createObjectURL(fileList1[i]);
	  $('#images_preview2').attr('src',objectUrl);
	  window.URL.revokeObjectURL(fileList1[i]);
	  
	}
	//$('#header').append('<li><div class="fileUpload btn btn-primary"><a class="add-ico" href="javascript:void(0);" onclick="header();" data-toggle="modal" data-target="#boatimgs"></a></div></li>');
}

</script>

<script type='text/javascript'>
    /* attach a submit handler to the form */
	
	var jqq = $.noConflict( true );
	
	jqq(document).ready(function() {

		jqq.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Enter letters only")
				 
				jqq("#reg").validate({
			rules: {
				
				firstname: {
					required: true,
					
				},
				lastname: {
					required: true,
					
				},
				moblie: {
					required: true,
				},
				email: {
					required: true,
					email:true,
					 "remote":
                     {
                      url: 'check_email',
                      type: "post",
                      data:
                      {
                          email: function()
                          {
                              return $('#reg :input[name="email"]').val();
                          }
                      }
                    }
				},
				password: {
					required: true,
					minlength: 6,
					
					
				}
				
				
			},
			//set messages to appear inline
			messages: {
			
			firstname:
				{
					required:"Enter your firstname"
				},
				lastname:
				{
					required:"Enter your lastname"
				},
				
				password:
				{
					
		   		    required:"please enter your password",
					minlength: "Should greater then 6 char",
       			},
				email:
				{
					
		   		     remort:"Email-id already exits",
					
       			}
				
				
			},
			
			 errorElement: 'span',
			    submitHandler: function(form)
             {
				 var myform = document.getElementById("reg");
    			 var fd = new FormData(myform );
				$.ajax({
			 url: baseurl + "save_register",
			 type: "POST",
			 dataType: "json", 
			 data: fd,
			 contentType: false,
			 cache: false,
			 processData: false,
			 success: function(json){
				 
    
			  if (json == 'false'){
			   
			   alert('Try again Later');
			   //$('#spnError').show();
			   return false;
			  } 
			 
			  
			  
			  else if (json == 'true') {
				
			 window.location = "<?php echo base_url();?>";
			   
			  }
			  
	 
				 },
			 error: function(){}
			 });
			 
			
			}
			
		

		});
		
   
	   });


	
</script>
<style>
.error {
   color: #ff0000;
   font-size: 12px;
   margin-top: 5px;
   margin-bottom: 0;
}
 
.inputTxtError {
   border: 1px solid #ff0000;
   color: #0e0e0e;
}
</style>