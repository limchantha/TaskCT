<?php if($book_details->num_rows()>0){ foreach($book_details->result() as $bd){ ?>
<div class="col-md-12 col-sm-12 col-xs-12 cancel_task">
		<div class="col-md-10 col-sm-10 col-xs-12">
			<h5><?php echo ucfirst($bd->task_name);?></h5>
			<p>You’ve <?php if($bd->status=='Cancel'){ echo "Cancelled ";} else { echo "Booked";} ?> <?php echo ucfirst($bd->first_name.' '.$bd->last_name);?>. You paid $<?php echo $bd->tot;?></p>
			<p class="cancel_timing"><big><b><?php echo date('d',strtotime($bd->booking_date));?></b> <?php echo date('M',strtotime($bd->booking_date));?></big><span><?php if($bd->booking_time==0){echo 'Flexible';}
													else if($bd->booking_time==1){echo 'MORNING 8am - 12pm';}
													else if($bd->booking_time==2){echo 'AFTERNOON 12pm - 4pm';}
													else{echo 'EVENING 4pm - 8pm';}?> </span></p>
		</div>
		<?php } } else { echo 'No transaction found...';}?>
