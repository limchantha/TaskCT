<?php $this->load->view('site/common/header');
	?>
	<section>
	<div class="about_service_base">
		<div class="clearfix"></div>
			<div class="about_service_base">
            <?php $this->load->view('site/tasker/profile_header');?>       
				   <div class="review_base col-md-12 col-sm-12 col-xs-12 nopadd">
						<div class="container">
								<div class="col-md-12 col-sm-12 col-xs-12 review_inner">
									<ul class="list-unstyled">
										<?php if($reviews->num_rows()>0){ foreach($reviews->result() as $rev){
											if($rev->photo!='')
											{
												$pro_pic1=base_url().'images/site/profile/'.$rev->photo;
											}
											else
											{
												$pro_pic1=base_url().'images/site/profile/big_avatar.png';
											}
											?>
										<li>
											<div class="profile_img_review col-md-1 col-sm-3 col-xs-12 nopadd">
													<img src="<?php echo $pro_pic1;?>">
											</div>
											<div class="col-md-11 col-sm-9 col-xs-12 review_inner_cont">
												<h5><?php echo ucfirst($rev->first_name.' '.$rev->last_name);?></h5>
												<div class="review_star">
										                <i class="fa fa-star<?php if($rev->rate_val<1){ echo '-o'; }?>" aria-hidden="true"></i>
														<i class="fa fa-star<?php if($rev->rate_val<2){ echo '-o'; }?>" aria-hidden="true"></i>
														<i class="fa fa-star<?php if($rev->rate_val<3){ echo '-o'; }?>" aria-hidden="true"></i>
														<i class="fa fa-star<?php if($rev->rate_val<4){ echo '-o'; }?>" aria-hidden="true"></i>
														<i class="fa fa-star<?php if($rev->rate_val<5){ echo '-o'; }?>" aria-hidden="true"></i>
												</div>
												<div class="review_content">
														<p><?php echo $rev->comments;?></p>
												</div>
											</div>
										</li>
										<?php }} else { echo "No reviews found...";} ?>
								</ul>
								</div>
						</div>
					</div>
			
					
			</div>
			</div>
			
			<div class="clearfix"></div>
	</section>

<?php $this->load->view('site/common/footer');?>