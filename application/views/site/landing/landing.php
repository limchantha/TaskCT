<?php $this->load->view('site/common/header');	?>
<link href="<?php echo base_url();?>css/site/owl.carousel.min.css" rel="stylesheet">
	<section>
			<div class="content_base banner_content_base text-center">
				<div class="banner_home_img">
				<img src="<?php  echo base_url().'images/site/banner_home.png'; ?>">
				</div>
					<div class="container">
						<div class="head_title col-md-12 col-sm-12 col-xs-12 nopadd">
							<h1><?php echo  $this->lang->line('make_your_life'); ?><br><?php echo  $this->lang->line('simple_and_easy'); ?> </h1>
							<span class="under_head">&nbsp;</span>
							<h2><?php echo  $this->lang->line('heading'); ?><br> <?php echo  $this->lang->line('heading1'); ?></h2>
						</div>
						<div class="search_input col-md-6 col-sm-6 col-xs-12 nopadd text-left">
							<input type="text" class="form-control searchbar_inputbox" placeholder="Search for your service.........">
							<ul class="search_dropdown_box search_box_ul" id="myUL">
								<?php foreach($task_category->result() as $task_cat){?>
								<li class="search_li_box" data-val="<?php echo ucfirst($task_cat->task_name);?>" data-url="<?php  echo base_url().'add_task/'.$task_cat->id; ?>">
								<img class="searchbar_img" src="<?php if($task_cat->image=='')echo base_url().'images/site/category/contimg1.png'; else echo base_url().'images/site/category/'.$task_cat->image;?>">
								<?php echo ucfirst($task_cat->task_name);?> </li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="content_base">
					<div class="container">
					<div class="clean_base col-md-12 col-sm-12 col-xs-12 nopadd">
							<?php $i=1; foreach($get_service_featured->result() as $task_cat){?>
							<div class="<?php if($i%2!=0){?>clean_lft col-md-8 col-sm-8 col-xs-12<?php }else {?>clean_rgt col-md-4 col-sm-4 col-xs-12<?php }?>">
							<?php if($i%2!=0){ $tempurl=base_url().'images/site/category/size_big/'.$task_cat->image; } else {$tempurl=base_url().'images/site/category/size_medium/'.$task_cat->image;}
								
								?>
									<img src="<?php if($task_cat->image=='')echo base_url().'images/site/category/contimg1.png'; else echo $tempurl;?>">
									<div class="clean_cont_base">
											<div class="clean_cont_inner">
													<h4><?php echo ucfirst($task_cat->task_name);?></h4>
													<p><?php echo substr($task_cat->task_description,0,30);?></p>
													<a href="<?php echo base_url().'add_task/'.$task_cat->id; ?>" class="theme_btn"> <?php echo  $this->lang->line('book'); ?></a>
											</div>
									</div>
							</div>
							<?php $i++;}?>
							
					</div>
						<div class="img_section col-md-12 col-sm-12 col-xs-12 nopadd">
								<h3><?php echo  $this->lang->line('heading2'); ?></h3>
								<?php foreach($task_category1->result() as $task_cat){?>
								<div class="col-md-4 col-sm-4 col-xs-12 img_base">
										<div class="img_inner">
												<img src="<?php if($task_cat->image=='')echo base_url().'images/site/category/contimg1.png'; else echo base_url().'images/site/category/'.$task_cat->image;?>">
												<div class="img_content">


														<!--<h3><i class="fa <?php if($task_cat->icon==''){ echo 'fa-wrench';} else { echo $task_cat->icon;}?>" aria-hidden="true"></i></h3> -->


														<p><?php echo ucfirst($task_cat->task_name);?></p>
														<a class="theme_btn" href="<?php echo base_url().'add_task/'.$task_cat->id; ?>"> 
														    <?php echo  $this->lang->line('book'); ?>
														</a>
													</div>
												<!--<div class="black_layer col-md-12 col-sm-12 col-xs-12 nopadd">
													
												</div> -->
										</div>
								</div>
								<?php } ?>
								
						</div>
						<!--<div class="col-md-12 col-sm-12 col-xs-12 advantage_section">
								<h4>our advantage</h4>
								<p>We deliver qulaity, relevant services that completly satisfy your need.</p>
								<span class="under_line">&nbsp;</span>
								<div class="advantage_icons">
									<ul class="list-inline">
										<li><h5><img src="<?php echo base_url();?>images/site/time.svg"></h5><big>Save your <br> time</big></li>
										<li><h5><img src="<?php echo base_url();?>images/site/quality.svg"></h5><big>Quality <br> Service</big></li>
										<li><h5><img src="<?php echo base_url();?>images/site/one_place.svg"></h5><big>Everything in <br> one place</big></li>
										<li><h5><img src="<?php echo base_url();?>images/site/24service.svg"></h5><big>24/7 <br> Service</big></li>
										<li><h5><img src="<?php echo base_url();?>images/site/cc.svg"></h5><big>Easy & Secure <br> Payment</big></li>
									</ul>
								</div>
								<div class="service_now col-md-12 col-sm-12 col-xs-12 text-center">
										<a href="#" class="theme_btn">Get Your Service Now!</a>
								</div>
						</div>
						-->
						<div class="col-md-12 col-sm-12 col-xs-12 how_works text-center">
								<h6><?php echo  $this->lang->line('how_it_works'); ?></h6>
								<!--
								<div class="how_icons">
									<ul class="list-inline">
										<li><div class="how_img"> <img src="<?php echo base_url();?>images/site/how_img1.png"></div><p><?php echo  $this->lang->line('search_your'); ?> <br> <?php echo  $this->lang->line('need'); ?></p></li>
										<li><div class="how_img"><img src="<?php echo base_url();?>images/site/how_img2.png"></div><p><?php echo  $this->lang->line('compare'); ?> <br><?php echo  $this->lang->line('quotes'); ?></p></li>
										<li><div class="how_img"><img src="<?php echo base_url();?>images/site/how_img3.png"></div><p><?php echo  $this->lang->line('hire'); ?> <br> <?php echo  $this->lang->line('servicer'); ?> </p></li>
									</ul>
								</div> -->
								<div class="col-md-12 col-xs-12 col-sm-12 how_works_inner nopadd">
										<div class="col-sm-12 col-xs-12 col-md-12 how_section_base nopadd">
											<div class="col-md-5 col-sm-4 col-xs-12 how_section_lft">
												<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
													<img src="<?php echo base_url();?>images/how_1.png">
												</div>
											</div>
											<div class="col-md-7 col-sm-8 col-xs-12 how_section_rgt">
												<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
														<h5><span>1</span>Search your Need</h5>
														<p>Choose from a variety of home services and select the day and time you'd like a qualified Tasker to show up. Give us the details and we'll find you the help.</p>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-xs-12 col-md-12 how_section_base nopadd">
											<div class="col-md-5 col-sm-4 col-xs-12 how_section_lft pull-right margin_rgt_how hidden-xs">
												<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
													<img src="<?php echo base_url();?>images/how_2.png" class="hidden-xs">
												</div>
											</div>
											<div class="col-md-7 col-sm-8 col-xs-12 how_section_rgt">
												<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
														<h5><span>2</span>Search your Need</h5>
														<p>Choose from a variety of home services and select the day and time you'd like a qualified Tasker to show up. Give us the details and we'll find you the help.</p>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-xs-12 col-md-12 how_section_base nopadd">
											<div class="col-md-5 col-sm-4 col-xs-12 how_section_lft hidden-xs">
												<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
													<img src="<?php echo base_url();?>images/how_3.png" >
												</div>
											</div>
											<div class="col-md-7 col-sm-8 col-xs-12 how_section_rgt">
												<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
														<h5><span>3</span>Search your Need</h5>
														<p>Choose from a variety of home services and select the day and time you'd like a qualified Tasker to show up. Give us the details and we'll find you the help.</p>
												</div>
											</div>
										</div>
								</div>
								<div class="col-md-12 col-xs-12 col-sm-12 how_works_inner service_happiness_base">
										<div class="col-sm-12 col-xs-12 col-md-12 how_section_base nopadd">
											<div class="col-md-4 col-sm-4 col-xs-12 how_section_lft">
												<div class="col-md-12 col-sm-12 col-xs-12 nopadd search_icon_custom">
													<img src="<?php echo base_url();?>images/how_4.png">
												</div>
											</div>
											<div class="col-md-8 col-sm-8 col-xs-12 how_section_rgt service_happiness">
												<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
														<h5>Search your Need</h5>
														<p>Choose from a variety of home services and select the day and time you'd like a qualified Tasker to show up. Give us the details and we'll find you the help.</p>
												</div>
											</div>
										</div>
								</div>

						</div>
						</div>
						</div>
						<?php if($review_list->num_rows()>0){ ?>
						<div class="col-md-12 col-sm-12 col-xs-12 testmonial_base">
								<div class="container">
									<div class="col-md-12 col-xs-12 col-sm-12 testmonial_inner">
									<h5 class="text-center">Real People, Real Tasks</h5>
											<div class="owl-carousel owl-theme">
    											<?php foreach($review_list->result() as $rev){ 
													if($rev->uphoto!='')
													{
														$pro_pic=base_url().'images/site/profile/'.$rev->uphoto;
													}
													else
													{
														$pro_pic=base_url().'images/site/profile/big_avatar.png';
													}
												?>
												<div class="item col-lg-12 col-md-12 col-sm-12">
    												<div class="col-md-4 col-sm-4 col-xs-12 profile_pic_testmonial text-center">
    												<img src="<?php echo $pro_pic;?>">
    												</div>
    												<div class="col-md-8 col-sm-8 col-xs-12 content_testmonial">
    														<p><?php echo substr($rev->comments,0,150);?></p>
    														<div class="testomonial_profile">
    															<h3><?php echo ucfirst($rev->tname);?></h3>
    															<h4><?php echo ucfirst($rev->address);?></h4>
    														</div>
    														<div class="testmonial_taskname">
    															<h6>Task: <span><?php echo ucfirst($rev->task_name);?></span></h6>
    														</div>
    												</div>
    											</div>
    											<?php } ?>
    										</div>

									</div>
								</div>
						</div>
						<?php } ?>
						<div class="coming_soon_app col-md-12 col-sm-12 col-xs-12">
							<div class="container">
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="clearfix"></div>
								<div class="col-md-7 col-sm-7 col-xs-12 our_app_coming pull-right">
										<h6><?php echo  $this->lang->line('our_app'); ?></h6>
									<img src="<?php echo base_url();?>images/site/coming_soon.png">
								</div>
								<div class="col-md-5 col-sm-5 col-xs-12 ourapp_img">
									<img src="<?php echo base_url();?>images/site/phone_icon.png">
								</div>
								
							</div>
							</div>
						</div>
						<!--
						<div class="col-md-12 col-sm-12 col-xs-12 most_wanted text-center">
							<h6>most wanted services</h6>
							<span class="under_line">&nbsp;</span>
								<ul class="list-inline">
									<?php foreach($cms_service->result() as $cm1){?>
									<li><a class="theme_btn"  href="<?php echo base_url().'page/'.$cm1->url;?>"><?php echo ucfirst($cm1->title);?></a></li>
									<?php } ?>
								</ul>
						</div> -->
					</div>
			</div>
		<div class="clearfix"></div>
	</section>
	<script src="<?php echo base_url();?>js/site/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/site/owl.carousel.min.js"></script>
	<script>
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    mouseDrag:true,
    nav:true,
    navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
</script>
<script>
$(document).ready(function(){
$('.searchbar_inputbox').click(function(e){
	var e=window.event||e;
	var o = e.srcElement || e.target;
	$('.search_dropdown_box').show(500);
	e.stopPropagation();
});
 
var a=0;	
var url='';     		   
$('.search_li_box').click(function(){
 a=1;  			
 url=$(this).attr('data-url'); 
 window.location.href=url;
});	
$('.searchbar_inputbox').keyup(function() {
value=$(this).val();
  /* $(".search_dropdown_box li").hide().filter(":contains('"+ value +"')").show()
return false;	 */ 
	var input, filter, ul, li, a, i;
	filter = value.toUpperCase();
	ul = document.getElementById("myUL");
	li = ul.getElementsByTagName('li');
	
	for (i = 0; i < li.length; i++) {
		a = li[i];
		if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
			li[i].style.display = "";
		} else {
			li[i].style.display = "none";
		}
	}
})
	
});
</script>
<script>
	$(document).click( function() {
    	$('.search_dropdown_box').hide(500);
  });
</script>

<?php $this->load->view('site/common/footer');?>
