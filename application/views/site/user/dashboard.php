<?php $this->load->view('site/common/header');	?>
	<section>
			<div class="content_base aft_login_content">
					<div class="container">
						<div class="head_title col-md-12 col-sm-12 col-xs-12 nopadd text-center">
                            <h1>Welcome to Service Rabbit, <?php echo $user->first_name==''?'Guest':ucfirst($user->first_name);?></h1>
						</div>
						<div class="search_input col-md-12 col-sm-12 col-xs-12 nopadd">
							<input type="text" class="form-control searchbar_inputbox" placeholder="Search for your service.........">
							<ul class=" search_dropdown_box search_box_ul" id="myUL">
								<?php foreach($task_category->result() as $task_cat){?>
								<li class="search_li_box" data-val="<?php echo ucfirst($task_cat->task_name);?>" data-url="<?php echo base_url().'add_task/'.$task_cat->id;?>">
								<img class="searchbar_img" src="<?php if($task_cat->image=='')echo base_url().'images/site/category/contimg1.png'; else echo base_url().'images/site/category/'.$task_cat->image;?>">
								<?php echo ucfirst($task_cat->task_name);?> </li>
								<?php } ?>
							</ul>
						</div>
                        <div class="col-md-12 col-sm-12 col-xs-12 how_works text-center">
								<h5>How it works ?</h5>
                                <h6>Simple and easy steps with few clicks</h6>
								<div class="how_icons">
									<ul class="list-inline">
										<li><div class="how_img"> <img src="<?php echo base_url();?>images/site/how_img1.png"></div><p>Search your <br> need</p></li>
										<li><div class="how_img"><img src="<?php echo base_url();?>images/site/how_img2.png"></div><p>Compare <br>Quotes</p></li>
										<li><div class="how_img"><img src="<?php echo base_url();?>images/site/how_img3.png"></div><p>Hire <br> Servicer</p></li>
									</ul>
								</div>
						</div>
						<div class="img_section col-md-12 col-sm-12 col-xs-12 nopadd">
								<?php foreach($task_category1->result() as $task_cat){?>
								<div class="col-md-4 col-sm-4 col-xs-12 img_base">
										<div class="img_inner">
												<img src="<?php if($task_cat->image=='')echo base_url().'images/site/category/contimg1.png'; else echo base_url().'images/site/category/'.$task_cat->image;?>">
													<div class="img_content">
													<p><?php echo ucfirst($task_cat->task_name);?></p>
														<a class="theme_btn" href="<?php echo base_url().'add_task/'.$task_cat->id;?>">
														Book 
														</a>
													</div>
												
										</div>
								</div>
								<?php } ?>
								
						</div>
					</div>
			</div>
		
	</section>
<script>
$(document).ready(function(){
$('.searchbar_inputbox').click(function(){
	var e=window.event||e;
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
	$(document).click( function(e) {
    	$('.search_dropdown_box').hide(500);
  });
</script>
<?php $this->load->view('site/common/footer');?>