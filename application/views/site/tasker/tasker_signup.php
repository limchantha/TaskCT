<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $heading!=''?$heading:ucfirst($this->config->item('site_name'));?></title>
	<link rel="alternate" href="<?php echo base_url();?>">
    <meta content='<?php echo $this->config->item('site_name');?>' name='author'>
	<meta content='<?php echo $this->config->item('meta_description');?>' name='description'>
	<meta content='<?php echo $this->config->item('meta_keywords');?>' name='keywords'>
	<meta property="fb:app_id" content="<?php echo $this->config->item('fb_app_id');?>">
	<meta property="og:site_name" content="<?php echo ucfirst($this->config->item('site_name'));?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo base_url();?>">
	<meta property="og:title" content="<?php echo $this->config->item('meta_title');?>">
	<meta property="og:description" content="<?php echo $this->config->item('meta_description');?>">
	<meta property="og:image" content="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_logo')!=''?$this->config->item('site_logo'):'logo.png';?>">
	<meta property="og:locale" content="en_US">
    <meta name="twitter:widgets:csp" content="on">
	<meta name="twitter:url" content="<?php echo base_url();?>">
	<meta name="twitter:description" content="<?php echo $this->config->item('meta_description');?>">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="<?php echo $this->config->item('meta_title');?>">
	<meta name="twitter:site" content="<?php echo $this->config->item('twitter_name');?>">
	<meta name="twitter:app:id" content="<?php echo $this->config->item('twitter_app_id');?>">
	<meta name="twitter:app:name:iphone" content="<?php echo ucfirst($this->config->item('site_name'));?>">
	<meta name="twitter:app:name:ipad" content="<?php echo ucfirst($this->config->item('site_name'));?>">
	<meta name="twitter:app:name:googleplay" content="<?php echo ucfirst($this->config->item('site_name'));?>">
	<meta name="twitter:app:id:googleplay" content="<?php echo base_url();?>">
	<meta name="twitter:app:url:iphone" content="<?php echo base_url();?>">
	<meta name="twitter:app:url:ipad" content="<?php echo base_url();?>">
	<meta name="twitter:app:url:googleplay" content="<?php echo base_url();?>">
	<link rel="shortcut icon" sizes="76x76" type="image/x-icon" href="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_favicon')!=''?$this->config->item('site_favicon'):'favicon.ico';?>" />
	<script>
		var baseurl="<?php echo base_url();?>"; 
	</script>	
</head>
<link href="<?php echo base_url();?>css/site/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/site/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/site/developer.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/site/sweetalert.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/site/jquery-3.1.1.min.js"></script>
<body >
<section>
            <div class="col-md-12 col-sm-12 col-xs-12 nopadd signin_base">
                    <div class="container">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center nopadd">
                            <div class="col-md-4 col-sm-3 col-xs-12 logo_base_signup text-left">
                            		<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_logo')!=''?$this->config->item('site_logo'):'logo.png';?>"></a>
                            </div>
                                    <div class="col-md-5 col-sm-8 col-xs-12 sign_start nopadd">
                                     <div class="sign_base sign_in sign_up_tasker_new">
                                     	<div class="sign_up_tasker_heading text-left">
                                     		<h3>Become a Tasker</h3>
                                     		<p>Create an account to get started</p>
                                     	</div>
                                        <form action="" method="post" id="tasker-register-form" novalidate="novalidate">  
										    <input type="text" name="first_name" id="sfirst_name" placeholder="First Name" class="form-control">
                                            <input type="text" name="last_name" id="slast_name"  placeholder="Last Name" class="form-control">
                                            <input type="email" name="email" placeholder="Email Address" class="form-control">
                                            <input type="password" name="password" placeholder="Password" class="form-control">
                                            <input type="text" name="zipcode" id="address_zip" placeholder="Zipcode" class="form-control">
                                            <input type="text" name="phone" id="phone" placeholder="Mobile" class="form-control">
                                            <input type="submit" value="Create Account" class="submit_btn">
                                            <p class="agree_terms">By signing up you agree to our <a href="<?php echo base_url();?>page/terms-and-conditons"> Terms of Use </a> and <a href="<?php echo base_url();?>page/privacy-policy"> Privacy Policy </a></p>
                                        </form>    
                                         <span class="under_line sign_line">&nbsp;</span>
                                            <h4>Already have an account? <a href="<?php echo base_url();?>user_login">Login</a> </h4>
                                      </div>
                                  
                                           
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 get_hired">
                            		<h4>Get Hired</h4>
                            </div>
                    </div>
            </div>
            </div>
            <div class="work_with_service_base col-md-12 col-sm-12 col-xs-12">
            	<div class="container">
            		<div class="col-md-12 col-sm-12 col-xs-12 work_with_service_inner">
            			 <h3 class="text-center">Work with ServiceRabbit</h3>
            			 <div class="col-md-12 col-sm-12 col-xs-12 work_with_sections">
            			 		<div class="col-md-4 col-sm-4 col-xs-12 work_with_sections_1st">
            			 				<div class="work_with_sections_bg">
            			 						<span class="work_image section_1"></span>
            			 						<h6>Find jobs you love</h6>
            			 				</div>
            			 		</div>
            			 		<div class="col-md-4 col-sm-4 col-xs-12 work_with_sections_1st">
            			 				<div class="work_with_sections_bg">
            			 						<span class="work_image section_2"></span>
            			 						<h6>At rates you choose</h6>
            			 				</div>
            			 		</div>
            			 		<div class="col-md-4 col-sm-4 col-xs-12 work_with_sections_1st">
            			 				<div class="work_with_sections_bg">
            			 						<span class="work_image section_3"></span>
            			 						<h6>Make a schedule that fits your life</h6>
            			 				</div>
            			 		</div>
            			 </div>
            		</div>
            	</div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 how_it_signup">
            		<div class="container nopadd">
            				<div class="col-md-12 col-sm-12 col-xs-12 how_it_signup_inner">
            						<h3 class="text-center">How it works</h3>
            						<div class="col-md-12 col-xs-12 col-sm-12 how_sliderbase">
									    <div id="myCarousel" class="carousel slide col-sm-12 col-md-12 col-xs-12" data-ride="carousel">
									      <!-- Wrapper for slides -->
									     

									    <ul class="list_thumbnail_content pull-right">
									      <li data-target="#myCarousel" data-slide-to="0" class="list-group-item active custom_list"><h4><span class="circle_span"></span>Serach for your task easy</h4></li>
									      <li data-target="#myCarousel" data-slide-to="1" class="list-group-item custom_list"><h4><span class="circle_span"></span>Login using social network</h4></li>
									      <li data-target="#myCarousel" data-slide-to="2" class="list-group-item custom_list"><h4><span class="circle_span"></span>Selective locations</h4></li>
									      <li data-target="#myCarousel" data-slide-to="3" class="list-group-item custom_list"><h4><span class="circle_span"></span>Select the tasker you like</h4></li>
									      <li data-target="#myCarousel" data-slide-to="4" class="list-group-item custom_list"><h4><span class="circle_span"></span>Build your tasker profile </h4></li>
									    </ul>
									     <div class="mobile_bg">
									      <div class="carousel-inner ">
									        <div class="item active">
									          <img src="<?php echo base_url();?>images/signup/home.png">
									        </div><!-- End Item -->
									 
									         <div class="item">
									          <img src="<?php echo base_url();?>images/signup/login.png">
									        </div><!-- End Item -->
									        
									        <div class="item">
									          <img src="<?php echo base_url();?>images/signup/form.png">
									        </div><!-- End Item -->
									        
									        <div class="item">
									          <img src="<?php echo base_url();?>images/signup/taskers.png">
									        </div><!-- End Item -->

									        <div class="item">
									          <img src="<?php echo base_url();?>images/signup/profile.png">
									        </div><!-- End Item -->
									                
									      </div><!-- End Carousel Inner -->
									      </div>

									      <!-- Controls -->
									      <div class="carousel-controls">
									          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
									            <span class="glyphicon glyphicon-chevron-left"></span>
									          </a>
									          <a class="right carousel-control" href="#myCarousel" data-slide="next">
									            <span class="glyphicon glyphicon-chevron-right"></span>
									          </a>
									      </div>

									    </div><!-- End Carousel -->
            							
            						</div>	
            				</div>
            		</div>
            </div>
            <div class="popular_categories_base col-md-12 col-sm-12 col-xs-12">
            	<div class="container nopadd">
            		<div class="col-md-12 col-sm-12 col-xs-12 popular_categories_inner">
            			 <h3 class="text-center">Work with ServiceRabbit</h3>
            			 <div class="col-md-12 col-sm-12 col-xs-12 popular_categories_sections">
            			 	    <?php foreach($task_category->result() as $task_cat){ ?>
								<div class="col-md-2 col-sm-2 col-xs-12 popular_category_1">
            			 			<img src="<?php if($task_cat->image=='')echo base_url().'images/site/category/contimg1.png'; else echo base_url().'images/site/category/'.$task_cat->image;?>"/>
            			 			<p><?php echo ucfirst($task_cat->task_name);?></p>
            			 		</div>
            			 		<?php } ?>

            			 </div>
            		</div>
            	</div>
            </div>
            <div class="get_started_base col-md-12 col-sm-12 col-xs-12 ">
            	<div class="container">
            		<div class="col-md-12 col-sm-12 col-xs-12 get_started_inner nopadd">
            			 <h3 class="text-center">Get Started</h3>
            			 <div class="col-md-12 col-sm-12 col-xs-12 get_started_sections nopadd">
            			 		<div class="col-md-4 col-sm-4 col-xs-12 get_started_sections_1st">
            			 				<div class="get_started_sections_bg text-center">
            			 						<span class="started_image section_1"></span>
            			 						<h6>Find jobs you love</h6>
            			 						<p>Complete the registration form and check your email for an invitation to orientation</p>
            			 				</div>
            			 		</div>
            			 		<div class="col-md-4 col-sm-4 col-xs-12 get_started_sections_1st">
            			 				<div class="get_started_sections_bg text-center">
            			 						<span class="started_image section_2"></span>
            			 						<h6>Find jobs you love</h6>
            			 						<p>Complete the registration form and check your email for an invitation to orientation</p>
            			 				</div>
            			 		</div>
            			 		<div class="col-md-4 col-sm-4 col-xs-12 get_started_sections_1st">
            			 				<div class="get_started_sections_bg text-center">
            			 						<span class="started_image section_3"></span>
            			 						<h6>Find jobs you love</h6>
            			 						<p>Complete the registration form and check your email for an invitation to orientation</p>
            			 				</div>
            			 		</div>
            			 </div>
            			 <div class="col-md-12 col-sm-12 col-xs-12 text-center register_btn">
            			  		<a href="#" class="theme_btn">Register Now</a>
            			 </div>
            		</div>
            	</div>
            </div>
            <div class="testmonial_sign_base col-md-12 col-sm-12 col-xs-12">
            	<div class="container">
            		<div class="col-md-12 col-sm-12 col-xs-12 testmonial_sign_inner">
            			 <h3 class="text-center">What Tasker are saying</h3>
            			 <div class="col-md-12 col-sm-12 col-xs-12 testmonial_sign_sections">
            			 		 <?php foreach($tasker_reviewlist->result() as $treview){ ?>
								<div class="col-md-4 col-sm-4 col-xs-12 testmonial_sign_sections_1st">
            			 				<div class="testmonial_sign_base_bg">	
            			 					<p><?php echo substr($treview->comments,0,150);?></p>
            			 						<span class="work_image section_3">
            			 							<img src="<?php if($treview->photo=='')echo base_url().'images/site/profile/avatar.png'; else echo base_url().'images/site/category/'.$treview->photo;?>"/>
            			 						</span>
            			 						<h6><span class="name_test"><?php echo ucfirst($treview->name);?></span> <?php echo ucfirst($treview->designation);?></h6>
            			 						<span class="quote_icon"><i class="fa fa-quote-left" aria-hidden="true"></i></span>
            			 				</div>
            			 		</div>
								 <?php } ?>
            			 		
            			 </div>
            		</div>
            	</div>
            </div>

</section>


<script >
	$(document).ready(function(){
    
	var clickEvent = false;
	$('#myCarousel').carousel({
		interval:   4000	
	}).on('click', '.list_thumbnail_content li', function() {
			clickEvent = true;
			$('.list_thumbnail_content li').removeClass('active');
			$(this).addClass('active');		
	}).on('slid.bs.carousel', function(e) {
		if(!clickEvent) {
			var count = $('.list_thumbnail_content').children().length -1;
			var current = $('.list_thumbnail_content li.active');
			current.removeClass('active').next().addClass('active');
			var id = parseInt(current.data('slide-to'));
			if(count == id) {
				$('.list_thumbnail_content li').first().addClass('active');	
			}
		}
		clickEvent = false;
	});
})

$(window).load(function() {
    var boxheight = $('#myCarousel .carousel-inner').innerHeight();
    var itemlength = $('#myCarousel .item').length;
    var triggerheight = Math.round(boxheight/itemlength+1);
	$('#myCarousel .list-group-item').outerHeight(triggerheight);
});
</script>
<script>
        var sign_pos= $('.sign_inner').offset();
        var sign_top= $('.sign_base').offset();
	    var window_width= $(window).width();
$(document).ready(function(){
				$('.sign_whtspace').offset({left:sign_pos.left + 6});
                $('.sign_whtspace').offset({top:sign_top.top});
   
});
$('#address_zip').keypress(function(event){
            console.log(event.which);
        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault();
        }});

</script>
<?php $this->load->view('site/common/footer');?>
</body>

</html>