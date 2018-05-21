<?php #$this->load->view('site/common/header');	?>
<script src="<?php echo base_url();?>js/site/validate.js"></script>
	<section>
		<div class="clearfix"></div>
			<div class="servicer_detail_base edit_servicer">
                     <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                            <div class="service_detail_inner servicer_detail_2nd_step">
                                <div class="col-md-12 col-sm-12 col-xs-12 service_2_content service_4_step nopadd">
					   
                                         <div class="col-md-12 col-sm-12 col-xs-12 confirm_content">
                                         <form  id="gift_form" method="post">  
											<div class="credit_card_choose">
											<ul class="list-unstyled">
												<?php if($user->stripe_customer_id!=""){?>
												<li>
												<label for="ex_card"> <input type="radio" name="credit_card_type" id="ex_card" value="0"/><?php echo $this->lang->line('existingcard_info'); ?>: <?php echo $card_comp.' XXXXXXXXXXXX'.$card_last;?></label>
												</li> 
												<?php } ?>
												<li>

												
												<label for="new_card"> <input type="radio" name="credit_card_type" id="new_card" checked value="1"/>New Card</label></li>
											</ul>	
											</div>
											<div class="new_credit_card for_demo_purpose" >
													<div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
														<label><?php echo $this->lang->line('card_number'); ?></label>
														<input type="text" type="number" maxlength="16" name="number" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('expiration_date'); ?></label>
                                                            <ul class="list-inline exp_date">
                                                                  <li> <select name="exp_month">
																	<option value="">Month</option>
																	<?php for($i=1;$i<=12;$i++){?>
																		<option value="<?php echo $i;?>"><?php echo $i;?></option>
																	<?php } ?>
																  </select></li>
                                                                  <li>  <select name="exp_year">
																	 <option value="">Year</option>
																	   <?php 
																		   $thisyear=date('Y');
																		   $endofyear=date('Y')+20;
																	   for($i=$thisyear;$i<=$endofyear;$i++){?>
																				<option value="<?php echo $i;?>"><?php echo $i;?></option>
																			<?php } ?>
																  </select><li>
                                                            </ul>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('security_code'); ?></label>
                                                            <input type="number" name="cvc"  class="form-control">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('postal_code'); ?></label>
                                                            <input type="text" name="address_zip"  class="form-control">
                                                            <input type="hidden" name="gift_id" value="<?php echo $gift_card_list->id;?>" class="form-control">
                                                    </div>
											</div>
										</form>	
                                    </div>
									
                                            
                                    </div>
                                    
                                
                                    <div class="continue_service">
                                            <a href="javascript:void(0);" id="gift_btn" class="theme_btn"> Pay</a>
                                    </div>
                            </div>
                     </div>   
			</div>
			<div class="clearfix"></div>

			<script>
			$('#gift_btn').click(function(){
			$('#gift_form').submit();
		});
			$('#ex_card').click(function(){
				$('.new_credit_card').css('display','none');
			});
			$('#new_card').click(function(){
				$('.new_credit_card').css('display','block');
			});
		</script>
	</section>
<?php #$this->load->view('site/common/footer');?>