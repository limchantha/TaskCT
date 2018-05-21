<?php #$this->load->view('site/common/header');	?>
<script src="<?php echo base_url();?>js/site/validate.js"></script>
<script>
$(document).ready(function(){
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:3,
    nav:true,
    navText:['<i class="fa fa-caret-right" aria-hidden="true"></i> ','<i class="fa fa-caret-left" aria-hidden="true"></i>'],
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
});
 });
 

</script>
      <link id="cal_style" rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/site/flatpickr.min.css">
	  <script type="text/javascript" src="<?php echo base_url();?>js/site/jquery.form.js"></script>
	  <script type="text/javascript" src="<?php echo base_url();?>js/site/flatpickr.js"></script>
	  <script type="text/javascript" src="<?php echo base_url();?>js/site/highlight.pack.js"></script>
	  <script>			
			flatpickr("#calendar-pic", { 
						altInput: false,
						altFormat: "Y-n-j",
						mode: "range",
						minDate: "today",
						inline:true	,
						 "disable": [<?php echo $disabled_dates;?>]
					});
	</script>				
	<section>
		<div class="clearfix"></div>
			<div class="servicer_detail_base block_date_edit account_flex">
                     <div class="col-md-12 col-sm-12 col-xs-12 nopadd ">
                            <div class="service_detail_inner servicer_detail_2nd_step">
                                  <div class="col-md-12 col-sm-12 col-xs-12 service_2_content service_4_step nopadd">
					   
                                            <div class="col-md-12 col-sm-12 col-xs-12 service_4_step_inner  nopadd">
												<form  id="block_dates_frm" method="post">  
												    <div class="col-md-6 col-sm-6 col-xs-12 task_date_head">
													     <h3>Task Date</h3>
														<input type="text" name="task_date" id="calendar-pic"  />
													</div>
                                                    <!--<div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
                                                            <label><?php echo  $this->lang->line('task_category'); ?></label>
                                                            <select class="form-control required" id="task_category_id1" name="task_category_id" required>
															
																<option value="">Select</option>
																<?php foreach($task_cat->result() as $taskcat){?>
																<option value="<?php echo $taskcat->task_category_id;?>"><?php echo $taskcat->task_name;?></option>
																<?php } ?>
															</select>
													<div class="col-md-12 col-sm-12 col-xs-12 flexible_class">
															 <label>Sub Category</label>
                                                            <select class="form-control" id="subcat_id1" name="subcat_id">		<option value="">Choose Sub Category</option>
																
															</select>
													</div>-->
													<div class="col-md-6 col-sm-6 col-xs-12 task_flexible_class">
															 <h3><?php echo  $this->lang->line('time'); ?></h3>
                                                           <!-- <input type="hidden" id="task_date1" name="task_date" value="<?php echo date('Y-m-d');?>"/>-->
                                                            <input type="hidden" id="sub_category_name" name="sub_category_name" />
                                                            <input type="hidden" id="task_category_name" name="task_category_name" />
															<select class="form-control" id="task_time1" name="task_time">		<option value="0"><?php echo  "Full Day"; ?></option>
																<option value="1"><?php echo  $this->lang->line('morning'); ?> 8am - 12pm</option>
																<option value="2"><?php echo  $this->lang->line('afternoon'); ?>  12pm - 4pm</option>
																<option value="3"> <?php echo  $this->lang->line('evening'); ?> 4pm - 8pm</option>
															</select>

															  <div class="continue_service">
                                            <a href="javascript:void(0);" onclick="del_block_date(0);" class="theme_btn"> <?php echo  $this->lang->line('delete'); ?></a>
                                            <a href="javascript:void(0);" id="confirm_booking_btn1" class="theme_btn"> <?php echo  $this->lang->line('save'); ?></a>
                                    </div>
													</div>
                                                    </div>
                                                   <!-- <div class="col-md-6 col-sm-6 col-xs-12 sorted_by_inner">
                                                            <label><?php echo  $this->lang->line('date'); ?></label>
                                                             <div class="date_carousel">
														<?php
														$curdate=date('Y-m-d');		
														$nextyeardate=date('Y-m-d', strtotime("+100 day"));
														$i=1;
														$dates = array (
																	$curdate 
															);
															while ( end ( $dates ) < $nextyeardate ) {
																$dates [] = date ( 'Y-m-d', strtotime ( end ( $dates ) . ' +1 day' ) );
															}
															?>
															<div class="owl-carousel owl-theme">
															
																   <?php
																	
																   foreach($dates as $dt){?>
																   <div class="item <?php if($dt==$curdate) echo 'active';?>" data-date="<?php echo date('Y-m-d',strtotime($dt));?>"><h4><?php echo date('D',strtotime($dt));?></h4><p> <?php echo date('M',strtotime($dt));?>  <?php echo date('d',strtotime($dt));?></p></div>  
																   <?php } ?>	
															</div>
														</div>
                                                    </div>-->
												<!--	<div class="col-md-6 col-sm-6 col-xs-12 servicer_input">
                                                            <label>Time</label>
                                                            <input type="hidden" id="task_date" name="task_date" value="<?php echo date('Y-m-d');?>"/>
															<select class="form-control" id="task_time" name="task_time">											
																<option value="0">I'M FLEXIBLE</option>
																<option value="1">MORNING 8am - 12pm</option>
																<option value="2">AFTERNOON 12pm - 4pm</option>
																<option value="3">EVENING 4pm - 8pm</option>
															</select>
                                                    </div> -->
                                                    
                                    </div>
                                    
                                
                                  
                            </div>
							<div class="clearfix"></div>
							<div class="block_dates">
							<h4><?php echo  $this->lang->line('block_dates_list'); ?></h4>
							<div class="col-md-12 col-sm-12 col-xs-12 tab_content_content" id="block_dates_result">
                                            <?php if($block_dates->num_rows()>0){foreach($block_dates->result() as $eres){?>
											<div class="col-md-3 col-sm-3 col-xs-6 cancel_task  c_<?php echo $eres->id;?>">
													<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
													<h5><?php /*echo ucfirst($eres->task_name).' > '.ucfirst($eres->subcat_name); */?></h5>
												<p class="cancel_timing"><big><b><?php echo date('d',strtotime($eres->task_date))?></b> <?php echo date('M',strtotime($eres->task_date))?></big><span><?php if($eres->task_time==0){echo 'Full Day';}
												else if($eres->task_time==1){echo 'MORNING 8am - 12pm';}
													else if($eres->task_time==2){echo 'AFTERNOON 12pm - 4pm';}
													else{echo 'EVENING 4pm - 8pm';}?> </span></p>
													</div>
													<!--<div class="col-md-2 col-sm-2 col-xs-12 cac_cel_btn cac_cel_btn_new cac_cel_btn_new42 text-right">
																	<b class="task_request_task_completed"><a href="javascript:void(0);" class="trash_btn" onclick="del_block_date('<?php echo $eres->id;?>')"><i class="fa fa-trash" aria-hidden="true"></i></a></b>
																</div> -->
											</div>
											<?php } }else{echo "No list...";} ?>										
																																		</div>
							</div>
                     </div>
						
				</div>
			<div class="clearfix"></div>

			<script>
			$('#confirm_booking_btn1').click(function(){
             if($('#calendar-pic').val()!=""){				
			    $('#block_dates_frm').submit();
			 }
			 else
			 {
				 swal('Error','Choose date','error'); return false;
			 }
		});
		</script>
	</section>
		<link href="<?php echo base_url();?>css/site/owl.carousel.min.css" rel="stylesheet">
	 <script src="<?php echo base_url();?>js/site/owl.carousel.min.js"></script>
	 <script>
	 $(document).on('click','.item',function(){
		$('#task_date1').val($(this).attr('data-date'));
		$('.item').removeClass('active');
	    $(this).addClass('active');
	});
	$(document).on('change','#task_category_id1',function(){
		var mid=$('#task_category_id1').val();
		$('#task_category_name').val($('#task_category_id1 option:selected').html());
		$.post('<?php echo base_url();?>site/tasker/fill_subcat',{'mid':mid},function(date){$('#subcat_id1').html('');$('#subcat_id1').append(date);})
	});
	$(document).on('change','#subcat_id1',function(){
		$('#sub_category_name').val($('#subcat_id1 option:selected').html());
		
	});
	function del_block_date(id)
	{
		var task_val=$('#calendar-pic').val();
		if(task_val=="")
		{
			swal("Error","Choose un block dates","error"); return false;
		}
		$.post('<?php echo base_url();?>site/tasker/del_block_date',{'id':id,'task_date':task_val},function(date){$('#task_block_tab_button').click();});
	};


 
 
</script>

<?php #$this->load->view('site/common/footer');?>