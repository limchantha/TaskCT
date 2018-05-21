<?php if($book_details->num_rows()>0){ foreach($book_details->result() as $bd){ ?>
	<div class="col-md-12 col-sm-12 col-xs-12 cancel_task">
		<div class="col-md-10 col-sm-10 col-xs-12">
			<h5><?php echo ucfirst($bd->task_name).' > '.ucfirst($bd->subcat_name);?></h5>
			<p><?php echo $this->lang->line('you_get_request_from'); ?> <?php echo ucfirst($bd->first_name.' '.$bd->last_name);?>.</p>
			<p class="cancel_timing"><big><b><?php echo date('d',strtotime($bd->booking_date));?></b> <?php echo date('M',strtotime($bd->booking_date));?></big><span><?php if($bd->booking_time==0){echo 'Flexible';}
													else if($bd->booking_time==1){echo 'MORNING 8am - 12pm';}
													else if($bd->booking_time==2){echo 'AFTERNOON 12pm - 4pm';}
													else{echo 'EVENING 4pm - 8pm';}?> </span></p>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-12 cac_cel_btn cac_cel_btn_new cac_cel_btn_new<?php echo $bd->id;?>">
			<?php 
			 if($bd->booking_date<date('Y-m-d'))
				  { ?>
			  <b class="task_request_task_pending"><?php echo $this->lang->line('expired'); ?></b>
				 <?php } else {
			if($bd->status=='Pending'){				 
			?>
			<a href="javascript:void(0);" data-id="<?php echo $bd->id;?>" data-status="Accept" class="theme_btn task_accept_decline_btn"><?php echo $this->lang->line('accept'); ?></a>
			<a href="javascript:void(0);" data-id="<?php echo $bd->id;?>" data-status="Declined" class="theme_btn task_accept_decline_btn"><?php echo $this->lang->line('decline'); ?></a>
				 <?php  } else if($bd->status=='Accept'){ ?>
			<b class="task_request_task_completed"><?php echo $this->lang->line('accepted'); ?></b>
			<?php } else if($bd->status=='Declined'){?>
			<b class="task_request_task_pending"><?php echo $this->lang->line('declined'); ?></b>
			<?php } else if($bd->status=='Paid'){?>
			<b class="task_request_task_completed"><?php echo $this->lang->line('task_completed'); ?></b>
			<?php 
			}
			}?>
		</div>
	</div>
<?php } } else { echo 'No enquires found...';}?>
<script>
	$('.task_accept_decline_btn').click(function(){
		var id=$(this).attr('data-id');
		var status=$(this).attr('data-status');
		$.ajax({
							url:baseurl+'site/tasker/save_tasker_request_respond',
							dataType:'html',
							data:{'id':id,'status':status},
							type:'post',						
							success:function(data){
								if(status=="Accept") 	
								{
									$('.cac_cel_btn_new'+id).html('<b class="task_request_task_completed">Accepted</b>');	
								}
								else
								{
									$('.cac_cel_btn_new'+id).html('<b class="task_request_task_pending">Declined</b>');	
								}
								
							}
		});
	});
</script>