<?php $this->load->view('site/common/header');	?>
	<section>
		<div class="clearfix"></div>
			<div class="servicer_detail_base">
                     <div class="container">
                            <div class="service_detail_inner servicer_detail_2nd_step">
                                    <h1><?php echo $this->lang->line('register_become_tasker'); ?></h1>
                                    <div class="head_tile_scnd">
                                        <h2><?php echo $this->lang->line('registration_processing'); ?></h2>
                                        <div class="progress_base">
                                        <span><?php echo $this->lang->line('registration_completion'); ?> 75%</span>
                                        <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">
                                                <span class="sr-only">60% <?php echo $this->lang->line('complete'); ?></span>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 service_2_content service_4_step nopadd">
									<p><?php echo $this->lang->line('next_step_s'); ?></p>
                                            <div class="col-md-8 col-sm-10 col-xs-12 service_4_step_inner  nopadd">
												<form  id="tasker_payment_form" method="post">  
                                                    <div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('card_number'); ?></label>
                                                            <input type="text" type="number" maxlength="16" name="number" class="form-control">
                                                            <!--<p>For Demo:4111 1111 1111 1111</p>-->
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
																  </select></li>
                                                            </ul>
                                                            <!--<p>For Demo : 10/2025</p>-->
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('security_code'); ?></label>
                                                            <input type="number" name="cvc"  class="form-control">
                                                            <!--<p>For Demo :123</p>-->
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
                                                        <label><?php echo $this->lang->line('postal_code'); ?></label>
                                                        <input type="text" name="address_zip"  class="form-control">
                                                    </div>
												</form>	
                                            </div>
                                    </div>
                                    <div class="continue_service">
                                        <a href="javascript:void(0);" id="confirm_booking_btn" class="theme_btn"> <?php echo $this->lang->line('continue'); ?></a>
                                    </div>
                            </div>
                     </div>   
			</div>
			<div class="clearfix"></div>

			<script>
			$('#confirm_booking_btn').click(function(){
			$('#tasker_payment_form').submit();
		});
		</script>
	</section>
<?php $this->load->view('site/common/footer');?>