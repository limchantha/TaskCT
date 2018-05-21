<?php #$this->load->view('site/common/header');	?>
<script src="<?php echo base_url();?>js/site/validate.js"></script>
	<section>
		<div class="clearfix"></div>
			<div class="servicer_detail_base edit_servicer">
                     <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                            <div class="service_detail_inner servicer_detail_2nd_step">
                                <div class="col-md-12 col-sm-12 col-xs-12 service_2_content service_4_step nopadd">
					   
                                            <div class="col-md-12 col-sm-12 col-xs-12 service_4_step_inner  nopadd">
												<?php if($card_comp!='' && $card_last!=''){?>
												<div><h4><?php echo $this->lang->line('existingcard_info'); ?>: <?php echo $card_comp.' XXXXXXXXXXXX'.$card_last;?></h4></div><hr/>
												<?php } ?>
												<form  id="edit_tasker_payment_form" method="post">  
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
                                                    </div>
												</form>	
                                            </div>
                                            
                                    </div>
                                    
                                
                                    <div class="continue_service">
                                            <a href="javascript:void(0);" id="confirm_booking_btn" class="theme_btn"> <?php echo $this->lang->line('save'); ?></a>
                                    </div>
                            </div>
                     </div>   
			</div>
			<div class="clearfix"></div>

			<script>
			$('#confirm_booking_btn').click(function(){
			$('#edit_tasker_payment_form').submit();
		});
		</script>
	</section>
<?php #$this->load->view('site/common/footer');?>