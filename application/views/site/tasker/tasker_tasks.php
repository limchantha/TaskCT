<?php $this->load->view('site/common/header');

if($user->photo!='')
{
	$pro_pic=base_url().'images/site/profile/'.$user->photo;
}
else
{
	$pro_pic=base_url().'images/site/profile/big_avatar.png';
}	?>

	<section>
		<div class="clearfix"></div>
			<div class="about_service_base ">
                    <?php $this->load->view('site/tasker/profile_header');?> 
					<div class="hireme_base  review_base about_base col-md-12 col-sm-12 col-xs-12 nopadd">
						<div class="container">
							 <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="hireme_tab">
								<?php if($task_category->num_rows()>0){ foreach($task_category->result() as $task_cat){
										
										$exsisting_check=$this->tasker_model->get_all_details(TASKER_CATEGORY_SELECTION,array('task_category_id'=>$task_cat->id,'user_id'=>$user->id));	
										if($exsisting_check->num_rows()==1)
										{
											$ex_val=$exsisting_check->row();
										}
										else 
										{
											$ex_val='';
										}
										if(!empty($ex_val)){ 
								?>	
								<div class="hire_me_inner col-md-12 col-sm-12 col-xs-12 nopadd">
                                    <div class="col-md-9 col-sm-8 col-xs-12 hire_detail">
                                        <h4><?php echo ucfirst($task_cat->task_name);?></h4>
										<div class="subcat-div">
										    <?php 
											$subcat_list=$this->tasker_model->get_all_details(TASKER_SUB_CATEGORY,array('cat_id'=>$task_cat->id,'status'=>'Active'));
											if($subcat_list->num_rows()>0){
											foreach($subcat_list->result() as $subls){
												if(in_array($subls->id,explode(',',$ex_val->subcat_id))){
											?>
											<input type="radio" class="subcat-radio-btn new_checked" data-name="<?php echo $subls->subcat_name;?>"  name="subcat_id_<?php echo $task_cat->id;?>" id="subcat_id_<?php echo $subls->id;?>"  value="<?php echo $subls->id;?>"><label for="subcat_id_<?php echo $subls->id;?>"><?php echo $subls->subcat_name;?></label>
											<?php } } }?>
										</div>
                                        <p><?php echo $ex_val->tasker_description;?></p>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12 hire_price">
                                        <a href="<?php if($logcheck!=''){?>javascript:void(0);<?php } else { echo base_url().'site/user/set_back_login?url='.base_url().'hireme/'.$user->id;}?>" data-id="<?php echo $ex_val->task_category_id;?>" class="theme_btn bookingbtn" <?php /* if($logcheck!=''){?> data-toggle="modal" data-target="#add_task_pop" <?php } */?> > <b>Select for</b> $<?php echo $ex_val->price;?>/hr</a>
                                    </div>
								</div>
								<?php }}} else { echo "No tasks available...";} ?>
								  </div>
								  <div role="tabpanel" class="tab-pane" id="reviews_tab">
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
								  <div role="tabpanel" class="tab-pane" id="about_tab">
									   <div class="col-md-12 col-sm-12 col-xs-12 about_inner nopadd">
										<h4><?php echo $this->lang->line('facts_about'); ?></h4>
										<ul class="list-unstyled">
											<li><i class="fa fa-calendar" aria-hidden="true"></i><span><?php echo $this->lang->line('been_a_servicers'); ?> <b><?php echo $this->lang->line('since'); ?> <?php echo date('Y',strtotime($user->created));?> </b></span></li>
											<li><i class="fa fa-check " aria-hidden="true"></i><span><?php echo $this->lang->line('since'); ?><?php echo $this->lang->line('ihavedone'); ?> <b><?php if(!empty($tasks_done)){echo $tasks_done->num_rows();} else { echo "0";}?> <?php echo $this->lang->line('tasks'); ?></b></span></li>
										   <li><i class="fa fa-comments-o comments_span" aria-hidden="true"></i> <span class=""><?php echo $this->lang->line('ihave'); ?><b> <?php echo $this->lang->line('respond_quickly'); ?> </b> </span></li>
										</ul>
										<h5><?php echo $this->lang->line('am_your_tasker'); ?></h5>
										<h6><?php echo $this->lang->line('right_person'); ?></h6>
										<p><?php echo $user->detail1==""?"No description available":$user->detail1;?></p>
										<h6><?php echo $this->lang->line('not_servicing'); ?></h6>
										<p><?php echo $user->detail2==""?"No description available":$user->detail2;?></p>
										<h6><?php echo $this->lang->line('servicing'); ?></h6>
										<p><?php echo $user->detail3==""?"No description available":$user->detail3;?></p>
									  </div>
								  </div>								  
								</div>
                         </div>
					</div>
			</div>
			<div class="clearfix"></div>
	</section>
<script>
$(document).ready(function(){
	$('.new_checked').click(function(){
		$('.new_checked').prop('checked',false).removeAttr('checked');
		$(this).prop('checked',true);
		
	});
})
</script>
<!---login end--> 
  
<link rel="stylesheet" href="<?php echo base_url();?>css/site/star-rating.min.css" media="all" type="text/css"/>    
<script src="<?php echo base_url();?>js/site/star-rating.min.js" type="text/javascript"></script>
<?php $this->load->view('site/common/footer');?>