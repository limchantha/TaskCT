<!DOCTYPE html>
<html lang="en">
    
<head>
        <title><?php echo $this->config->item('site_name');?> - Admin Panel</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo base_url();?>css/admin/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>css/admin/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/admin/login.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/admin/sweetalert.css" />
        <link href="<?php echo base_url();?>css/admin/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" >
				 <div class="control-group normal_text"> <h3><img src="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_logo1');?>" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input name="admin_email" type="text" placeholder="Email" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input name="admin_password" type="password" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <!--<span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>-->
                    <span class="pull-right"><button type="submit"  class="btn btn-success" /> Login</button></span>
                </div>
            </form>
            <form id="recoverform" action="#" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
                </div>
            </form>
        </div>
        
        <script src="<?php echo base_url();?>js/admin/jquery.min.js"></script>  
        <script src="<?php echo base_url();?>js/admin/sweetalert.min.js"></script>  
        <script src="<?php echo base_url();?>js/admin/jquery.validate.js"></script>	
		
		<script type="text/javascript">
			
			$("#loginform").validate({
							rules: {
								admin_email: {
									required: true,
									email: true
								},
								admin_password: {
									required: true,
									minlength: 5
								}
							   },
							messages: {
								login_password: {
									required: "Please provide a password",
									minlength: "Your password must be at least 5 characters long"
								},
								login_email: {
									email:"Please enter a valid email address",
								}
								},
							submitHandler: function(form) {
								$.ajax(
									{
										type: "POST",
										url: '<?php echo base_url();?>admin/admin_settings/admin_login',
										dataType: "json",
										data: $('#loginform').serialize(),
										success: function(data)
										{ 
											if (data['status'] == 1)
											{
											  window.location.href='<?php echo base_url();?>admin/admin_settings/dashboard';								  
											}
											else if (data['status'] == 2)
											{
											   swal('Error',data['message'],'error');
											}
											else
											{
											   swal('Error',data['message'],'error');
											}	
										}
									});
							}
						});
				
		</script>
    </body>

</html>
