<?php $this->load->view('site/common/header');
	if($tasker_details->row()->photo!='')
	{
		$pro_pic=base_url().'images/site/profile/'.$tasker_details->row()->photo;
	}
	else
	{
		$pro_pic=base_url().'images/site/profile/big_avatar.png';
	}
	?>
	<section>
		<div class="clearfix"></div>
            <div class="service_info_base">
                    <div class="service_info_head">
                            <div class="container">
                                <ul class="list-inline">
									<li class="service_detail completed_step"> <p><?php echo $this->lang->line('service_details'); ?> </p></li>
									<li class="compare_ser completed_step"> <p><?php echo $this->lang->line('service_and_price'); ?>  </p></li>
									<li class="confirm_hire active"> <p><?php echo $this->lang->line('confirm_hire'); ?></p></li>
                                </ul>
                            </div>
                    </div>
					<div class="cofirm_hire_base">
                            <div class="container">
                                <div class="col-md-12 col-sm-12 col-xs-12 confirm_bse_inner">
                                    <div class="col-md-12 col-sm-12 col-xs-12 confirm_head">
                                        <h1><?php echo ucfirst($task_category->row()->task_name);?><span>(<?php echo $subcat_name;?>)</span></h1>
                                        <h2><?php echo $currency_symbol.' '. round($currency_rate*$tasker_details->row()->price);?>/hr</h2>
										
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 confirm_content">
                                         <form  id="payment_form" method="post">  
											<h6><?php echo $this->lang->line('your_taska_completed'); ?></h6>
											<div class="credit_card_choose">
											<ul class="list-unstyled">
												<?php if($user->stripe_customer_id!=""){?>
												<li>
												<label for="ex_card"> <input type="radio" name="credit_card_type" id="ex_card" value="0"/>
												<?php echo $this->lang->line('existingcard_info'); ?>: <?php echo $card_comp.' XXXXXXXXXXXX'.$card_last;?></label>
												</li> 
												<?php } ?>
												<li>

												
												<label for="new_card"> <input type="radio" name="credit_card_type" id="new_card" checked value="1"/>New Card</label></li>
											</ul>	
											</div>
											<div class="new_credit_card for_demo_purpose" >
													<div class="col-md-4 col-sm-4 col-xs-12 confim_input first_child servicer_input">
															<label><?php echo $this->lang->line('ccredit_card'); ?></label>
															<input type="text" id="number" maxlength="16" name="number" class="form-control">
															<!--<p class="">For Demo:4111 1111 1111 1111</p>-->
													</div>
													<div class="col-md-3 col-sm-3 col-xs-12 confim_input nopadd servicer_input">
														<label><?php echo $this->lang->line('expiration_date'); ?></label>
														<div class="col-md-6 col-sm-6 col-xs-6 confim1">
																<select class="form-control" name="exp_month">
																	<option value="">Month</option>
																	<?php for($i=1;$i<=12;$i++){?>
																		<option value="<?php echo $i;?>"><?php echo $i;?></option>
																	<?php } ?>
																</select>
																
														</div>
														<div class="col-md-6 col-sm-6 col-xs-6 confim1">
															<select class="form-control" name="exp_year">
															   <option value="">Year</option>
															   <?php 
																   $thisyear=date('Y');
																   $endofyear=date('Y')+20;
															   for($i=$thisyear;$i<=$endofyear;$i++){?>
																		<option value="<?php echo $i;?>"><?php echo $i;?></option>
																	<?php } ?>
															</select>
														</div>
														<!--<p class="">For Demo : 10/2025</p>-->
													</div>
													<div class="col-md-5 col-sm-5 col-xs-12 confim_input">
														 <div class="col-md-4 col-sm-6 col-xs-12 confim1 servicer_input">
															 <label><?php echo $this->lang->line('cvvcode'); ?></label>
																<input type="password" id="cvc" maxlength="3" name="cvc" class="form-control">
																 <!--<p class="">For Demo :123</p>-->
														</div>
														 <div class="col-md-8 col-sm-6 col-xs-12 confim1">
															 <label><?php echo $this->lang->line('zipcode'); ?></label>
																<input type="text" name="address_zip"  id="address_zip" class="form-control">
														</div>
													</div>
													<div class="col-md-4 col-sm-4 col-xs-12 confim_input first_child">
															<label><?php echo $this->lang->line('mobile_phone'); ?></label>
															<input type="text" id="mob" name="phone_no" class="form-control">
													</div>
											</div>
										</form>	
                                    </div>
									<div class="confirm_service_details col-md-12 col-sm-12 col-xs-12">
											<div class="col-md-6 col-sm-6 col-xs-12 confirm_service_details_inner">
												<div class="service_confirm">
													<h4><?php echo $this->lang->line('datestime'); ?></h4>
													<p><?php if($this->session->userdata('task_time')==0){echo 'Flexible';}
													else if($this->session->userdata('task_time')==1){echo 'MORNING 8am - 12pm';}
													else if($this->session->userdata('task_time')==2){echo 'AFTERNOON 12pm - 4pm';}
													else{echo 'EVENING 4pm - 8pm';}?></p>
												</div>
												<div class="service_confirm">
													<h4><?php echo $this->lang->line('task_location'); ?></h4>
													<p><?php echo $this->session->userdata('task_category_city');?></p>
												</div>
												<div class="service_confirm">
													<h4><?php echo $this->lang->line('task_description'); ?></h4>
													<p><?php echo $this->session->userdata('task_description');?></p>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12 confirm_service_details_inner">
													<div class="col-md-5 col-sm-5 col-xs-12 confirm_service_img">
														<img src="<?php echo $pro_pic;?>">
													</div>
													<div class="col-md-7 col-sm-7 col-xs-12 confirm_service_cont service_confirm">
														<div class="service_confirm">
															<h4><?php echo $this->lang->line('tasker'); ?></h4>
															<p><?php echo ucfirst($tasker_details->row()->first_name).' '.ucfirst($tasker_details->row()->last_name);?></p>
														</div>
													</div>
											</div>
											<div class="modify_servicer col-md-12 col-sm-12 col-xs-12 text-center">
													<a href="<?php echo base_url();?>add_task/<?php echo $tasker_details->row()->task_category_id;?>"><i class="fa fa-cog " aria-hidden="true"></i> <?php echo $this->lang->line('modify_task'); ?> </a>
											</div>
									</div>
									<div class="confirm_servicer_button col-md-12 col-sm-12 col-xs-12 text-center">
											<a href="javascript:void(0);" id="confirm_booking_btn" class="theme_btn"><?php echo $this->lang->line('confirm_book'); ?></a>
									</div>
                                </div>
								<div class="confirm_desc_base col-md-12 col-xs-12 col-sm-12  ">
										<p><b><?php echo $this->lang->line('charged_only'); ?></b><?php echo $this->lang->line('tasks_havea'); ?><b><?php echo ($task_category->row()->admin_percentage);?><?php echo $this->lang->line('trust_and_support'); ?> </b><?php echo $this->lang->line('added_to_the'); ?><br> <?php echo $this->lang->line('servicers_total'); ?></p>
										<p><?php echo $this->lang->line('para'); ?></p>
								</div>
                            </div>
					</div>
            </div>
		<div class="clearfix"></div>
		<script>
		$('#number,#cvc,#address_zip,#mob').keypress(function(event){
            console.log(event.which);
        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault();
        }});
		$('#confirm_booking_btn').click(function(){
			$(window).unbind('beforeunload');
			$('#payment_form').submit();
		});
		$(window).on("beforeunload", function() {
            return "Are you sure? You didn't finish the booking tasker!";
        });	
		$('#ex_card').click(function(){
			$('.new_credit_card').css('display','none');
		});
		$('#new_card').click(function(){
			$('.new_credit_card').css('display','block');
		});
		</script>
	</section>
<script>
// for this page only
$('.head_base').css('margin-bottom','1px');
</script>
<?php $this->load->view('site/common/footer');?>