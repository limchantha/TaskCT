<?php if($book_details->num_rows()>0){ foreach($book_details->result() as $bd){ /*?>
<div class="col-md-12 col-sm-12 col-xs-12 cancel_task">
		<div class="col-md-10 col-sm-10 col-xs-12 accor_cont_base">
			<h3 class="accord_head"><?php echo ucfirst($bd->task_name);?></h3>
			<p>You’ve booked <b><?php echo ucfirst($bd->first_name.' '.$bd->last_name);?>.</b><?php  
			if($bd->status=='Pending'){ ?>Your Servicer will confirm details within 30 minutes.<?php } ?></p>
			<h5><span><?php echo date('d',strtotime($bd->booking_date));?><small> <?php echo date('M',strtotime($bd->booking_date));?></small></span> <b><?php if($bd->booking_time==0){echo 'Flexible';}
													else if($bd->booking_time==1){echo 'MORNING 8am - 12pm';}
													else if($bd->booking_time==2){echo 'AFTERNOON 12pm - 4pm';}
													else{echo 'EVENING 4pm - 8pm';}?></b></h5>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-12 cac_cel_btn_new cac_cel_btn_new1<?php echo $bd->id;?>">
			<?php 
			 if($bd->booking_date<date('Y-m-d'))
				  { ?>
			  <b class="task_request_task_pending">Expired</b>
				 <?php } else { ?>
			<?php  
			if($bd->status=='Pending'){ 
			      ?>
					<b class="task_request_task_completed">Pending</b>
			
				 <?php  } else if($bd->status=='Accept'){ ?>
			
			<a href="javascript:void(0);" data-id="<?php echo $bd->id;?>" data-status="Cancel" class="theme_btn task_cancel_btn">Cancel</a>
			<?php #if($bd->booking_date==date('Y-m-d')){ ?>
			<a href="javascript:void(0);" data-id="<?php echo $bd->id;?>" data-status="Paid" data-taskerid="<?php echo $bd->tasker_id;?>" class="theme_btn task_done_btn">Task Done</a>
			<?php #} ?>
			<?php } else if($bd->status=='Declined'){?>
			<b class="task_request_task_pending">Declined</b>
			<?php } else if($bd->status=='Cancel'){?>
			<b class="task_request_task_pending">Cancelled</b>
			<?php } else if($bd->status=='Paid'){?>
			<b class="task_request_task_completed">Task Completed</b>
			<?php if($bd->rate_val==''){?><a href="javascript:void(0);" data-toggle="modal" data-target="#review_pop" data-id="<?php echo $bd->id;?>" data-taskerid="<?php echo $bd->tasker_id;?>" class="review_click theme_btn">Review</a>
			<?php } else {?> <b>You reviewed <?php echo $bd->rate_val;?>/5 </b><?php }?>
		    <?php } }?>
		</div>
</div>
 */ ?>
<div class="col-md-12 col-sm-12 col-xs-12 accor_cont_base cancel_task delpast_<?php echo $bd->id;?>">
			<h3 class="accord_head"><?php echo ucfirst($bd->task_name).' > '.ucfirst($bd->subcat_name);?></h3>
			<?php if($bd->rate_val!=''){?>
			<div class="review_star">
					<i class="fa fa-star<?php if($bd->rate_val<1){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<2){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<3){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<4){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<5){ echo '-o'; }?>" aria-hidden="true"></i>
			</div>
			<?php } ?>
			<div class="col-md-12 col-sm-12 col-xs-12 accordian_cont">
				<div class="col-md-8 col-sm-8 col-xs-12 accordian_cont_lft">
				<p><?php if($bd->veh_name!="" && $bd->veh_name!="0" ){ echo "Vehicle Requirement: Need a <b>".$bd->veh_name.'</b>';}?></p>
				<?php if($bd->status=="Paid"){?><p><b><?php echo "SRA00".$bd->id;?> <?php echo '$'.$bd->total_amount;?></b></p><?php }?>
				<?php if($bd->status=="Cancel"){?><p><b>Cancellation charge <?php echo $currency_symbol. round($currency_rate*$bd->cancel_amount);?></b></p><?php }?>
				<p>You’ve cancelled <b> <?php echo ucfirst($bd->first_name.' '.$bd->last_name);?></b> .<?php if($bd->status=='Pending'){ ?>You’ve to confirm it before 30 mins.</p><?php }?></p>
				<h5><span><?php echo date('d',strtotime($bd->booking_date));?>  <br> <small><?php echo date('M',strtotime($bd->booking_date));?></small></span> <b><?php if($bd->booking_time==0){echo 'Flexible';}
				else if($bd->booking_time==1){echo 'MORNING 8am - 12pm';}
				else if($bd->booking_time==2){echo 'AFTERNOON 12pm - 4pm';}
				else{echo 'EVENING 4pm - 8pm';}?> </b></h5>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 accordian_cont_rgt text-right cac_cel_btn_new cac_cel_btn_new1<?php echo $bd->id;?>">
				<ul class="list-inline dashboard_tab_nav">
					<?php 
			 if($bd->booking_date<date('Y-m-d') && $bd->status=='Pending')
				  { ?>
			 <li> <b class="task_cancelled">Expired</b></li>
				 <?php } else { ?>
			<?php  
			if($bd->status=='Pending'){ 
			      ?>
					 <li><b class="task_pending">Pending</b></li>
			
				 <?php  } else if($bd->status=='Accept'){ ?>
			
			 <li><a href="javascript:void(0);" data-id="<?php echo $bd->id;?>" data-status="Cancel" class="theme_btn task_cancel_btn">Cancel</a></li>
			<?php #if($bd->booking_date==date('Y-m-d')){ ?>
			<li>
			<input type="number" name="task_hour_<?php echo $bd->id;?>" id="task_hour_<?php echo $bd->id;?>" />
			<a href="javascript:void(0);" data-id="<?php echo $bd->id;?>" data-status="Paid" data-taskerid="<?php echo $bd->tasker_id;?>" class="theme_btn task_done_btn">Task Done</a></li>
			<?php #} ?>
			<?php } else if($bd->status=='Declined'){?>
			 <li><b class="task_cancelled">Declined</b></li>
			<?php } else if($bd->status=='Cancel'){?>
			 <li><b class="task_cancelled">Cancelled</b></li>
			<?php } else if($bd->status=='Paid'){?>
			 <li><b class="task_accepted">Task Completed</b></li>
			<?php if($bd->rate_val==''){?><li><a href="javascript:void(0);" data-toggle="modal" data-target="#review_pop" data-id="<?php echo $bd->id;?>" data-taskerid="<?php echo $bd->tasker_id;?>" class="review_click theme_btn">Review</a></li>
			<?php }?>
		    <?php } }?>
				</ul>

				</div>
			</div>
		</div>
<?php } } else { echo '<div class="no_task_found"> No tasks found... </div>';}?>
