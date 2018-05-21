<?php $this->load->view('site/common/header');	?>
		<section>
		<div class="clearfix"></div>
			<div class="servicer_detail_base">
                     <div class="container">
                            <div class="service_detail_inner">
                                    <h1><?php echo  $this->lang->line('register_become_tasker'); ?></h1>
                                    <div class="head_tile_scnd">
                                        <h2><?php echo  $this->lang->line('your_own_boss'); ?></h2>
                                    </div>

                                    <p> <?php echo $this->lang->line('your_advantages'); ?><a href="#">  <?php echo  $this->lang->line('servicer_best_practices'); ?> </a> <?php echo $this->lang->line('to_help_you'); ?></p>
                                    <p><?php echo $this->lang->line('order_to_maintain'); ?></p>
									<p><?php echo $this->lang->line('our'); ?> <a href="#"> <?php echo $this->lang->line('terms_of_service'); ?></a> <?php echo $this->lang->line('govern'); ?></p>

                                    <p><?php echo $this->lang->line('best_practices'); ?></p>
									<form id="step1-form" action="<?php echo base_url();?>site/tasker/save_step1">
									 <p class="custom_check">		
									<input type="checkbox" class="required" title="Please select checkbox" id="agree" name="agree" />
                                    <label for="agree"><?php echo $this->lang->line('understand_and_agree'); ?></label>
									<label for="agree" generated="true" class="error checkbox-error"></label>
									</p>
									</form>
                                    <div class="continue_service">
                                        <a href="javascript:void(0);"onclick="save_step1();" class="theme_btn"> <?php echo $this->lang->line('continue'); ?></a>
                                    </div>
                            </div>
                     </div>   
			</div>
			<div class="clearfix"></div>
			<script>
			function save_step1()
			{
				$('#step1-form').submit();
			}
			</script>
	</section>
<?php $this->load->view('site/common/footer');?>