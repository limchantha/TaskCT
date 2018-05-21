<?php $this->load->view('site/common/header');	?>
<style>
.hidetask
{
	display:none;
}
</style>
		<section>
		<div class="clearfix"></div>
			<div class="servicer_detail_base">
                     <div class="container">
						 <div class="base_for_skill">
                            <div class="service_detail_inner servicer_detail_2nd_step servicer_3_step">
                                    <h1><?php echo $this->lang->line('register_become_tasker'); ?></h1>
                                    <div class="head_tile_scnd">
                                        <h2><?php echo $this->lang->line('your_rates_skills'); ?></h2>
                                        <div class="progress_base">
                                        <span><?php echo $this->lang->line('registration_completion'); ?> 27%</span>
                                        <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 27%;">
                                                <span class="sr-only"></span>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
									<div class="col-md-12 col-sm-12 col-xs-12 nopadd  servicer_skills">
												<p><?php echo $this->lang->line('work_categories_and'); ?></p>
									
                                    <div class="continue_service search_services col-md-12 col-sm-12 col-xs-12 nopadd">
											<input type="text" name="search" id="search_task" placeholder="Search Task" />
                                            
                                    </div>
									</div>
                            </div>
							<div class="accordian_base_skills">
									<?php if($task_category->num_rows()>0){ foreach($task_category->result() as $task_cat){
										
										$exsisting_check=$this->tasker_model->get_all_details(TASKER_CATEGORY_SELECTION,array('task_category_id'=>$task_cat->id,'user_id'=>$id));	
										if($exsisting_check->num_rows()==1)
										{
											$ex_val=$exsisting_check->row();
										}
										else 
										{
											$ex_val='';
										}
										$subcat_list=$this->tasker_model->get_all_details(TASKER_SUB_CATEGORY,array('cat_id'=>$task_cat->id,'status'=>'Active'));
										$exist_subcat=explode(',',$ex_val->subcat_id);
									?>	
									<div class="col-md-12 col-sm-12 col-xs-12 accordian_skills nopadd search_fill" data-result="<?php echo ucfirst($task_cat->task_name);?>" >
										<form id="task_cat_form_<?php echo $task_cat->id;?>" method="post">	
											<input type="hidden" name="task_category_id" value="<?php echo $task_cat->id;?>"/>
											<div class="accordian_head">
												<h5><?php echo ucfirst($task_cat->task_name);?> <i class="fa fa-star" aria-hidden="true"></i> <span><?php echo $this->lang->line('popular_skill'); ?></span><span class="hourly_rate_right_price" id="task_head_<?php echo $task_cat->id;?>"><?php if(!empty($ex_val)){ echo $currency_symbol.' '.round($currency_rate*$ex_val->price).'/hr';}?></span> </h5>
												<p><?php echo ucfirst($task_cat->task_title);?></p>											
											</div>
											<div class="accordian_content">
												<div class="skills_expect nopadd">
													<div class="head_tiltle_skill">
														<h4><?php echo $this->lang->line('skill_expectations'); ?></h4>
													</div>
													<p><?php echo ucfirst($task_cat->task_description);?></p>
													<p class="custom_check"><input type="checkbox" id="agree_skill_<?php echo $task_cat->id;?>" name="agree_skill_<?php echo $task_cat->id;?>" <?php if(!empty($ex_val)){ echo 'checked';}?> />
                                                        <label for="agree_skill_<?php echo $task_cat->id;?>"><?php echo $this->lang->line('fulfill'); ?></label></p>
														<p><label for="agree_skill_<?php echo $task_cat->id;?>" generated="true" class="error"></label>
														</p>
												</div>
												
												<div class="level_of_exp  nopadd sub_category_task">
														<div class="head_tiltle_skill">
															<h4>Sub Category</h4>
														</div>
														<div class="level_exp_input">
															<!--<select multiple name="subcat_<?php echo $task_cat->id;?>[]">
																<option value="">Choose Sub Category</option>
																<?php foreach($subcat_list->result() as $sublist){?>
																<option <?php if(in_array($sublist->id,$exist_subcat)){ echo 'selected';}?> value="<?php echo $sublist->id;?>">
																<?php echo ucfirst($sublist->subcat_name); ?></option>
																<?php }?>
															</select>-->
															<ul class="list-inline">
															<?php $j=1;foreach($subcat_list->result() as $sublist){?>
															<li><p class="custom_check"><input type="checkbox"  name="subcat_<?php echo $task_cat->id;?>[]"  <?php if(in_array($sublist->id,$exist_subcat)){ echo 'checked';}?> id="subcat_<?php echo $task_cat->id.$j;?>" value="<?php echo $sublist->id;?>" />
                                                        		<label for="subcat_<?php echo $task_cat->id.$j;?>" style="display:inline;"><?php echo ucfirst($sublist->subcat_name); ?></label>
															</p>
															
														   </li>
															<?php $j++;}?>
														</ul>
															
												            <p><label for="subcat_<?php echo $task_cat->id;?>[]" generated="true" class="error"></label></p>
														</div>
												
												</div>
												<div class="set_hour nopadd">
														<div class="head_tiltle_skill">
															<h4><?php echo $this->lang->line('set_hourly_rate'); ?></h4>
														</div>
														<ul class="list-inline">
															<li><div class="pull-left"><p><?php echo $currency_symbol;?><input type="text" id="amount<?php echo $task_cat->id;?>" value="<?php if(!empty($ex_val)){ echo  round($currency_rate*$ex_val->price,2);}?>" name="amount<?php echo $task_cat->id;?>">.00/hr</p>
															<p><label for="amount<?php echo $task_cat->id;?>" generated="true" class="error"></label></p>
															</div></li>
															<li><p><?php echo $this->lang->line('most_servicers_experience'); ?> <br> <?php echo $this->lang->line('hired_at'); ?>:<br> <b><?php echo $currency_symbol.' '. round($currency_rate*$task_cat->avg_price,2);?>/hr</b></p></li>
															<li><p><?php echo $this->lang->line('take_home_rate'); ?>: <br><b><?php echo $currency_symbol.' '. round($currency_rate*$task_cat->avg_price,2);?>/hr</b></p></li>
														</ul>
														<div class="tool_tip_show">
																<p class="rate_likely"><?php echo $this->lang->line('you_are'); ?> <span> <?php echo $this->lang->line('likely'); ?> </span> <?php echo $this->lang->line('more_at_this'); ?>! <a href="javascript:void(0);" onclick="show_seehow();"> <?php echo $this->lang->line('see_why'); ?> </a> </p>
																<div class="tool_tip_shape" id="tool_tip_shape<?php echo $task_cat->id;?>">&nbsp;</div>
														</div>	
														<div class="slider_range" id="slider_range<?php echo $task_cat->id;?>">
															<div id="slider-range-min<?php echo $task_cat->id;?>"></div>
															<div class="range_value_slider">
																	<div class="range_1"><p><?php echo $currency_symbol.' '.round($currency_rate *22);?> </p></div>
																	<div class="range_2"><p><?php echo $currency_symbol.' '.round($currency_rate *100);?></p></div>
															</div>
														</div>

												</div>
											    <?php if($task_cat->task_name=="Cleaning"){?>
												<div class="tasks_do nopadd">
													<div class="head_tiltle_skill">
														<h4><?php echo $this->lang->line('set_hourly_rate'); ?></h4>
														<p><?php echo $this->lang->line('will_only_hire_you'); ?></p>
													</div>
													<ul class="list-inline">
													    <?php 
														$task1=$task2=$task3='';
														if(!empty($ex_val)){
															
															if($ex_val->task_sub_category!=''){
															$task_exp=explode(',',$ex_val->task_sub_category);
															foreach($task_exp as $ex){
																if($ex==1)
																{
																	$task1="checked";
																}
															    if($ex==2)
																{
																	$task2="checked";
																}
															    if($ex==3)
																{
																	$task3="checked";
																}
															}
														    }
															}
															?>
														<li><p class="custom_check"><input type="checkbox" <?php echo $task1;?> id="task1" name="task[]" value="1" />
                                                        	<label for="task1"><?php echo $this->lang->line('pickup_truck'); ?></label>
															</p>
															<p><?php echo $this->lang->line('scrub_brushes'); ?></p>
														</li>
														<li><p class="custom_check"><input type="checkbox" <?php echo $task2;?> id="task2" name="task[]" value="2" />
                                                        		<label for="task2"><?php echo $this->lang->line('mop'); ?></label>
															</p>
															<p><?php echo $this->lang->line('bucket_floor_cleaner'); ?></p>
														</li>
														<li><p class="custom_check"><input type="checkbox" <?php echo $task3;?> id="task3" name="task[]" value="3" />
                                                        		<label for="task3"><?php echo $this->lang->line('vacuum'); ?></label>
															</p>
															<p></p>
														</li>
													</ul>
												</div>
												<?php } ?>
												<div class="quick_path  nopadd">
														<div class="head_tiltle_skill">
															<h4><?php echo $this->lang->line('your_quick_pitch'); ?> </h4>
															<h5>250</h5>
														</div>
														<div class="text_area_path">
															<textarea name="tasker_description_<?php echo $task_cat->id;?>" placeholder="Pitch clients on why you are the best person for this type of task."><?php if(!empty($ex_val)){ echo $ex_val->tasker_description;}?></textarea>
														</div>
												</div>
												<div class="level_of_exp  nopadd">
														<div class="head_tiltle_skill">
															<h4><?php echo $this->lang->line('level_of_experience'); ?></h4>
														</div>
														<div class="level_exp_input">
															<select name="experience_<?php echo $task_cat->id;?>">
																<option value=""><?php echo $this->lang->line('experience'); ?></option>
																<option <?php if(!empty($ex_val)){ if($ex_val->experience=='none'){ echo 'selected';}} ?> value="none"><?php echo $this->lang->line('am_willing_to_learn'); ?></option>
																<option <?php if(!empty($ex_val)){ if($ex_val->experience=='some'){ echo 'selected';}} ?> value="some"><?php echo $this->lang->line('myself_around'); ?></option>
																<option <?php if(!empty($ex_val)){ if($ex_val->experience=='part_time'){ echo 'selected';}} ?> value="part_time"><?php echo $this->lang->line('had_parttime_experience'); ?></option>
																<option <?php if(!empty($ex_val)){ if($ex_val->experience=='professional'){ echo 'selected';}} ?> value="professional"><?php echo $this->lang->line('professional_experience'); ?></option>
																<option <?php if(!empty($ex_val)){ if($ex_val->experience=='certified'){ echo 'selected';}} ?> value="certified"><?php echo $this->lang->line('professionally_certified'); ?></option>
															</select>
												            <p><label for="experience_<?php echo $task_cat->id;?>" generated="true" class="error"></label></p>
														</div>
												</div>
												
												<div class="save_cancel_skills">
														<ul class="list-inline">
														<!--	<li><a href="javascript:void(0);" class="cancel_btn"> <?php echo $this->lang->line('cancel'); ?> </a> </li> -->
															<li><a href="javascript:void(0);" onclick="save_tasker_category(<?php echo $task_cat->id;?>);" class="theme_btn"> <?php echo $this->lang->line('save'); ?> </a> </li>
															<?php if(!empty($ex_val)){ ?>
															<li><a href="javascript:void(0);" onclick="delete_tasker_category(<?php echo $task_cat->id;?>);" class="theme_btn"> <?php echo $this->lang->line('delete'); ?> </a> </li>
															<?php } ?>
														</ul>
												</div>
											</div>
										</form>	
									</div>

									
									
			<script>
			$(document).ready(function(){
				$('#search_task').keyup(function(){  var len=$('.search_fill').length; var sval=$(this).val();
					$('.search_fill').each(function(){  
					if($(this).data('result').toUpperCase().indexOf((sval.toUpperCase()))>-1)
					{
						$(this).removeClass('hidetask');
					}
					else
					{
						
						$(this).addClass('hidetask'); 
					}
					})
				});
			});
			function save_tasker_category(id)
			{
				$('#task_cat_form_'+id).submit();
			}
			function delete_tasker_category(id)
			{
				swal({   
				 title: "Are you sure?",  
				 text: "Removing a skill means you will no longer receive these types of tasks and deletes your info for this category. Are you sure you want to continue?", 
				 type: "warning",   
				 showCancelButton: true,
				 confirmButtonColor: "#DD6B55",   
				 confirmButtonText: "Yes",
				 cancelButtonText:"No", 
				 closeOnConfirm: false },
				 function(){   
				             $.ajax(
									{   
										type: "POST",
										url: baseurl+'site/tasker/delete_tasker_category',
										dataType: "json",
										data: {'task_category_id':id},
										success: function(data)
										{  
											if (data['status'] == 1)
											{
											   swal({title: "Success", text: "Skil Removed successfully", type: "success"},
											   function(){ 
													   window.location.reload();
												   }
												);								  
											}
											
											else if (data['status'] == 2)
											{
											   swal('Oops',"Session out login again",'error');
											}
	
										}
									});
				 });

			}
			(function($,W,D)
			{
				var JQUERY4U = {};

				JQUERY4U.UTIL =
				{
					setupFormValidation: function()
					{
						//form validation rules
						$("#task_cat_form_<?php echo $task_cat->id;?>").validate({
							rules: {
								agree_skill_<?php echo $task_cat->id;?>: {
									required: true
								},
								amount<?php echo $task_cat->id;?>: {
									required: true,
									number: true
								},
								tasker_description_<?php echo $task_cat->id;?>: {
									required: true,
									maxlength: 250
								},
								experience_<?php echo $task_cat->id;?>: {
									required: true									
								},
								'subcat_<?php echo $task_cat->id;?>[]': {
									required: true									
								}
							   },
							messages: {
								agree_skill_<?php echo $task_cat->id;?>: {
									required: "Please accept this terms"
								},
								amount<?php echo $task_cat->id;?>: {
									required: "Please enter your price",
									number:"Please enter only number"
								},
								tasker_description_<?php echo $task_cat->id;?>: {
									required: "Please enter your description",
									maxlength:"Maximum limit is 250"
								},
								experience_<?php echo $task_cat->id;?>: {
									required: "Please choose your experience"								
								},
								'subcat_<?php echo $task_cat->id;?>[]': {
									required: "Please choose your sub category"								
								}
								},
							submitHandler: function(form) { 
								$.ajax(
									{   
										type: "POST",
										url: baseurl+'site/tasker/save_tasker_category',
										dataType: "json",
										data: $('#task_cat_form_<?php echo $task_cat->id;?>').serialize(),
										success: function(data)
										{  
											if (data['status'] == 1)
											{
											   swal({title: "Success", text: "Saved successfully", type: "success"},
											   function(){ 
													window.location.reload();
												   }
												);								  
											}
											else if (data['status'] == 2)
											{
											   swal({title: "Success", text: "Updated successfully", type: "success"},
											   function(){ 
													window.location.reload();
												   }
												);								  
											}
											else if (data['status'] == 3)
											{
											   swal('Oops',"Session out login again",'error');
											}
	
										}
									});
							}
						});
					}
				}

				//when the dom has loaded setup form validation rules
				$(D).ready(function($) {
					JQUERY4U.UTIL.setupFormValidation();
				});

			})(jQuery, window, document);
			  $( function() {
				  init_left = $('.ui-slider-range').width();
				 var newLeft = 19;
				 $('#tool_tip_shape<?php echo $task_cat->id;?>').css('left',init_left);
				      <?php if(!empty($ex_val)){  ?>
						var new_price=<?php echo round($currency_rate*$ex_val->price);?>;
					  <?php } else {?>
						var new_price=22;
					  <?php } ?>
				$( "#slider-range-min<?php echo $task_cat->id;?>" ).slider({
				  range: "min",
				  value: new_price,
				  min: Math.ceil(19*<?php echo $currency_rate;?>),
				  max: Math.ceil(100*<?php echo $currency_rate;?>),
				  slide: function( event, ui ) {
					$( "#amount<?php echo $task_cat->id;?>" ).val(ui.value );

					
				yog =$('.ui-slider-range').width();
				wid= (($('#slider_range<?php echo $task_cat->id;?> .ui-slider-range').width()-23.65625)/970)*100;
						 $('#tool_tip_shape<?php echo $task_cat->id;?>').css('left', + wid +'%');
						
						//console.log('yog',yog);
				  }

				});
				
				$( "#amount<?php echo $task_cat->id;?>" ).val($( "#slider-range-min<?php echo $task_cat->id;?>" ).slider( "value" ) );
			  
			  } );
			  </script>
									<?php }} ?>
						    </div>
						     <div class="continue_service accordian_div_cont">
                                            <a href="javascript:void(0);" class="theme_btn" id="save_step3"> <?php echo $this->lang->line('continue'); ?></a>
                                    </div>
                            </div>
                     </div>
                     </div>   
			<div class="clearfix"></div>
			<script src="<?php echo base_url();?>js/site/jquery-ui.min.js"></script>
			
			  <script>
			  $('.accordian_content').hide();
			  $(document).ready(function(){
				$('.accordian_head').click(function(){
					$(this).next().slideToggle(800);

					
					$(this).toggleClass("active");
					if($( this ).hasClass( "active" ))
					{
						$(this).parent().siblings().children().removeClass("active");
					}
					 $(this).parent().siblings().children().next().slideUp();

				});
			});
			
			$('#save_step3').click(function(){ 
			    var i=0;
                $('.hourly_rate_right_price').each(function(){
					if(($(this).html())!="")
					{
						i=i+1;
					}
					
				});
                				
				if(i>0)
				{
					$.ajax(
									{   
										type: "POST",
										url: baseurl+'site/tasker/save_step3',
										dataType: "json",
										data: $('#task_cat_form_<?php echo $task_cat->id;?>').serialize(),
										success: function(data)
										{  
											window.location.href="<?php echo base_url();?>tasker_step4";
	
										}
									});
				}
				else
				{
					swal('Error','Please choose any one service!!','error');
				}
			});
			function show_seehow()
			{
				swal({
				  title: '<i>Maximizing Your Income</i><br/><p>Given your experience on ServiceRabbit, we recommend you set your category rate in this range. Our marketplace data shows you can maximize your take-home earnings when you set a price that reflects your experience.Prices shown in green reflect the rates Clients choose most often among Taskers with similar category experience in your area. Check back here for updated data as you complete more tasks.</p>',
				  type: 'info',
				  html:
					'test',
				 showCancelButton: false,
				  focusConfirm: true,
				  confirmButtonText:
					'Got It!',
				  confirmButtonAriaLabel: 'Thumbs up, great!',
				 
				})
			}
			  </script>


	</section>

<?php $this->load->view('site/common/footer');?>