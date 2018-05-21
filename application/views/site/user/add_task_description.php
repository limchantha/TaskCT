<?php $this->load->view('site/common/header');	?>
		<section>
		<div class="clearfix"></div>
            <div class="service_info_base">
                    <div class="service_info_head">
                            <div class="container">
                                <ul class="list-inline">
									<li class="service_detail active"> <p><?php echo $this->lang->line('service_details'); ?> </p></li>
									<li class="compare_ser mob_res_none"> <p><?php echo $this->lang->line('service_and_price'); ?> </p></li>
									<li class="confirm_hire mob_res_none"> <p><?php echo $this->lang->line('confirm_hire'); ?></p></li>
                                </ul>
                            </div>
                    </div>
					<div class="servicer_info_content">
						<div class="container">
							<h1><?php echo ucfirst($task_category->row()->task_name);?>  <!-- <a href="<?php echo base_url();?>"> (change)</a> --></h1>
							<div class="task_location_base col-md-12 col-sm-12 col-xs-12 ">
										<h2>Task Sub Category</h2>                                        
                                        <h3><i class="fa fa-check-circle" aria-hidden="true"></i> <?php echo $this->lang->line('available_in_your_area'); ?></h3>
										<div class="clearfix"></div>
                                        <p><?php echo $subcat_name;?></p>
							</div>
							<div class="task_location_base col-md-12 col-sm-12 col-xs-12 ">
										<h2><?php echo $this->lang->line('your_task_location'); ?></h2>
                                        
                                       <!-- <h3><i class="fa fa-check-circle" aria-hidden="true"></i> <?php echo $this->lang->line('available_in_your_area'); ?></h3>-->
										<div class="clearfix"></div>
                                        <p><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $task_location;?></p>
							</div>
							<div class="task_location_base tell_us_task col-md-12 col-sm-12 col-xs-12 ">
										<h2><?php echo $this->lang->line('usabout_your_task'); ?></h2>
                                        <textarea class="form-control" name="task_description" id="task_description"></textarea>
										<input type="hidden" id="task_id" value="<?php echo $tid;?>">
                                        <div class="continue_locaion col-md-12 col-sm-12 col-xs-12">
													<a href="javascript:void(0);"  id="add_task_btn" class="theme_btn"><?php echo $this->lang->line('continue'); ?></a>
										</div>
							</div>
						</div>
					</div>
            </div>
		<div class="clearfix"></div>
		<script>
		$('#add_task_btn').click(function(){
		        if($('#task_description').val()=='')
				{
					swal('Error','Enter your task description','error');	return false;
				}
		        var task_id=$('#task_id').val();
				$.ajax({
					url:baseurl+'site/user/save_task_description',
					dataType:'json',
					type:'post',
					data:{'task_description':$('#task_description').val()},
					success:function(data){ 
						$(window).unbind('beforeunload');
						location.href=baseurl+'task_compare/'+task_id;	
						
					}
				});
			});	
			$(window).on("beforeunload", function() {
            return "Are you sure? You didn't finish the booking tasker!";
        });	
	</script>
	</section>

<script>
// for this page only
$('.head_base').css('margin-bottom','1px');
</script>
<?php $this->load->view('site/common/footer');?>