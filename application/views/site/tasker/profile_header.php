<?php 
if($user->photo!='')
{
	$pro_pic=base_url().'images/site/profile/'.$user->photo;
}
else
{
	$pro_pic=base_url().'images/site/profile/big_avatar.png';
}
function timeago($datetime,$full = false) {
 $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';

	}
	$avg_rat=0;
	$avper=0;
	if(!empty($reviews)){
	foreach($reviews->result() as $rev){
		$avg_rat+=$rev->rate_val;
	}
	 if($avg_rat!=0)
	 {
		 $avper=($avg_rat/($reviews->num_rows()*5))*100; 
	 }
	 else 
	 {
		 $avper=0;
	 }
	}
	 
?> 
 <div class="container">
                        <div class="servicer_name col-md-12 col-sm-12 col-xs-12 ">
                                <div class="col-md-9 col-sm-8 col-xs-12 name_of_servicer nopadd">
                                        <h1><?php echo  ucfirst($cat_name); ?> <span><?php echo  ucfirst("(".$subcat_name.")"); ?></span></h1>
                                        <ul class="list-inline">
                                            <li><span><i class="fa fa-calendar" aria-hidden="true"></i></span><big><?php echo date('M').' '.date('d');?>:</big><?php echo  $this->lang->line('iam_flexible'); ?></li>
											<li><span><i class="fa fa-map-marker" aria-hidden="true"></i></span><?php echo ucfirst($user->city.' ' .$user->state).','.$user->zipcode;?></li>
                                        </ul>
                                </div>
								<div class="col-md-3 col-sm-4 col-xs-12 hire_price nopadd"><?php if($task_category_top->num_rows()>0){ $i=1; foreach($task_category_top->result() as $task_cat){
										
										$exsisting_check=$this->tasker_model->get_all_details(TASKER_CATEGORY_SELECTION,array('task_category_id'=>$task_cat->id,'user_id'=>$user->id));	
										if($exsisting_check->num_rows()==1)
										{
											$ex_val=$exsisting_check->row();
										}
										else 
										{
											$ex_val='';
										}
										if(!empty($ex_val) && $i==1){ 
								?>
								
										<a href="<?php if($logcheck!=''){?>javascript:void(0);<?php } else { echo base_url().'site/user/set_back_login?url='.base_url().$this->uri->segment(1).'/'.$user->id;}?>" data-id="<?php echo $ex_val->task_category_id;?>" class="theme_btn bookingbtn1" data-subid="<?php echo $subcat_id;?>" data-subname="<?php echo $subcat_name;?>" <?php /*if($logcheck!=''){?> data-toggle="modal" data-target="#add_task_pop" <?php } */?> > <b><?php echo  $this->lang->line('select_for'); ?> </b> $<?php echo $ex_val->price;?>/<?php echo  $this->lang->line('hr'); ?></a>
										<?php } $i++;}} else { echo $this->lang->line('tasks_available'); } ?>
								</div>
                        </div>
                    </div>
					<div class="profile_banner col-md-12 col-sm-12 col-xs-12 nopadd" style="background:url(<?php echo base_url();?>images/site/profile_bg.png)">
							<div class="container">
									<div class="profile_banner_base col-md-12 col-sm-12 col-xs-12 text-center ">
										<img class="pro_avater" src="<?php echo $pro_pic;?>">
										<h2><?php echo  $this->lang->line('hello_am'); ?> <?php echo ucfirst($user->first_name.' '.$user->last_name);?>.</h2>
										<h6><b><?php echo  $this->lang->line('last_online'); ?> :</b><?php echo timeago($user->last_login_date);?></h6>
										<ul class="list-inline">
											<li class="col-md-4 col-sm-4 col-xs-12">
												<div class="col-md-2 col-sm-4 col-xs-3 bnner_icon">
													<i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>
												</div>
												<div class="col-md-10 col-sm-8 col-xs-9 bnner_cont nopadd">
													<h3><?php echo round($avper);?> % <?php echo  $this->lang->line('positive_rating'); ?></h3>
													<p> <?php echo  $this->lang->line('id'); ?> <?php echo ($user->id_verified=="No"?"Not ":"");?> <?php echo  $this->lang->line('verfified'); ?></p>
												</div>
											</li>
											<li class="col-md-4 col-sm-4 col-xs-12">
												<div class="col-md-2 col-sm-4 col-xs-3 bnner_icon">
													<i class="fa fa-check fa-2x" aria-hidden="true"></i>
												</div>
												<div class="col-md-10 col-sm-8 col-xs-9 bnner_cont nopadd">
													<h3> <?php echo  $this->lang->line('i_have_done'); ?> <?php if(!empty($tasks_done)){echo $tasks_done->num_rows();} else { echo "0";}?> <?php echo  $this->lang->line('tasks'); ?>.</h3>
													<p><?php echo  $this->lang->line('been_servicer_since'); ?> <?php echo date('Y',strtotime($user->created));?></p>
												</div>
											</li>
											<li class="col-md-4 col-sm-4 col-xs-12">
												<div class="col-md-2 col-sm-4 col-xs-3 bnner_icon">
													<i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
												</div>
												<div class="col-md-10 col-sm-8 col-xs-9 bnner_cont nopadd">
													<h3><?php echo  $this->lang->line('working_in'); ?> <?php if(!empty($work_city_new->row())){echo $work_city_new->row()->city_name; } else { echo 'New York';}?></h3>
													<p><?php echo  $this->lang->line('have_a_car'); ?>.</p>
												</div>
											</li>
													
										</ul>
									</div>
							</div>
							<div class="profile_banner_layer">&nbsp;</div>
					</div>
					<div class="profile_summary col-md-12 col-sm-12 col-xs-12 nopadd">
							<div class="container">
									<ul class="nav nav-tabs" role="tablist">
										<li role="presentation"  class="active" ><a href="#hireme_tab" aria-controls="home" role="tab" data-toggle="tab" href="<?php echo base_url('hireme/'.$user->id);?>"><?php echo  $this->lang->line('hire_me'); ?></a></li>
										<li  role="presentation" ><a href="#reviews_tab" aria-controls="home" role="tab" data-toggle="tab"><?php echo  $this->lang->line('reviews'); ?></a></li>
										<li role="presentation" ><a href="#about_tab" aria-controls="home" role="tab" data-toggle="tab"><?php echo  $this->lang->line('about'); ?></a></li>
									</ul>
							</div>
					</div>
	<script>
	$(document).ready(function(){
	$('.bookingbtn').click(function(){ 
		$('#task_select_cat').val($(this).attr('data-id')); 
		if($('input[name="subcat_id_'+$(this).attr('data-id')+'"]').is(":checked")){
		if(<?php echo $logcheck;?>==$('#tasker_id').val()){swal('Error','This is your property...','error'); return false;}
	    $.post('<?php echo base_url();?>site/user/check_book',$('#add_task_pop_form').serialize(),function(data){if(data==0){swal('Error','Already Booked','error');}else{ window.location.href="<?php echo base_url();?>booking_confirm";}})
		}
	    else {
			swal('Error',"Please choose sub category","error");
		} 
	});
	$('.bookingbtn1').click(function(){ 
		$('#task_select_cat').val($(this).attr('data-id')); 
		$('#task_select_sub_cat').val($(this).attr('data-subid')); 
		$('#task_select_sub_cat_name').val($(this).attr('data-subname')); 
		if(<?php echo $logcheck;?>==$('#tasker_id').val()){swal('Error','This is your property...','error'); return false;}
	    $.post('<?php echo base_url();?>site/user/check_book',$('#add_task_pop_form').serialize(),function(data){if(data==0){swal('Error','Already Booked','error');}else{ window.location.href="<?php echo base_url();?>booking_confirm";}})
		 
	});
	
	$(document).on('click','.item',function(){
		$('#task_date').val($(this).attr('data-date'));
	});
	$(document).on('click','.subcat-radio-btn',function(){
		$('#task_select_sub_cat').val($(this).val());
		$('#task_select_sub_cat_name').val($(this).attr('data-name'));
	});
	});
	</script>
<form  id="add_task_pop_form" method="post">
 <div class="modal" id="add_task_pop" role="dialog">

    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content"><h3><?php echo  $this->lang->line('add_task'); ?></h3>
        <div class="modal-header"> 
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		
        <div class="modal-body" style="height:350px">
        
		  <div class="form">
				  
				  <ul class="list-inline confm_psw">
						
						<li class="col-md-12 col-sm-6 col-xs-12"> <h3> <?php echo  $this->lang->line('task_date_time'); ?></h3>
							<input type="hidden" id="task_select_cat" value="" name="task_select_cat">
							<input type="hidden" id="task_select_sub_cat" value="" name="task_select_sub_cat">
							<input type="hidden" id="task_select_sub_cat_name" value="" name="task_select_sub_cat_name">
							<input type="hidden" id="tasker_id" value="<?php echo $user->id;?>" name="tasker_id">
				            <form name="search_form" id="search_form" method="post">
                                <div class="sorted_by_inner">
                                       
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
                                        <div class="flexible_am">
											<input type="hidden" id="task_date" name="task_date" value="<?php echo date('Y-m-d');?>"/>
                                            <select class="form-control" id="task_time" name="task_time">											
												<option value="0"><?php echo  $this->lang->line('iam_flexible'); ?></option>
												<option value="1"><?php echo  $this->lang->line('morning'); ?> 8am - 12pm</option>
												<option value="2"><?php echo  $this->lang->line('afternoon'); ?> 12pm - 4pm</option>
												<option value="3"><?php echo  $this->lang->line('evening'); ?> 4pm - 8pm</option>
											</select>
                                        </div>
                                </div>
								</form>
                            </div>						</li>
						
						<li class="col-md-12 col-sm-6 col-xs-12 nopadd">
							   <input type="button" name="submit" class="theme_btn" id="submit_book_new" value="Submit" />
						</li>
		  </div>
        </div>
      </div>
      
    </div>

 </form> 
 <script>

 $('#submit_book_new').click(function(){ if(<?php echo $logcheck;?>==$('#tasker_id').val()){swal('Error','This is your property...','error'); return false;}
	 $.post('<?php echo base_url();?>site/user/check_book',$('#add_task_pop_form').serialize(),function(data){if(data==0){swal('Error','Already Booked','error');}else{ window.location.href="<?php echo base_url();?>booking_confirm";}})
 });
</script>					