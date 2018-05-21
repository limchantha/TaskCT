<?php if($book_details->num_rows()>0){ foreach($book_details->result() as $bd){ ?>
<div class="col-md-12 col-sm-12 col-xs-12 cancel_task review_account_show">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<h5><?php echo ucfirst($bd->task_name).' > '.ucfirst($bd->subcat_name);?></h5>
			<?php if($bd->rate_val!=''){?>
			<div class="review_star">
					<i class="fa fa-star<?php if($bd->rate_val<1){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<2){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<3){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<4){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<5){ echo '-o'; }?>" aria-hidden="true"></i>
			</div>
			<?php } ?>
			<p>You’ve booked <?php echo ucfirst($bd->first_name.' '.$bd->last_name);?>.<?php  
			if($bd->status=='Pending'){ ?>Your Servicer will confirm details within 30 minutes.<?php } ?></p>
			<p class="cancel_timing"><big><b><?php echo date('d',strtotime($bd->booking_date));?></b> <?php echo date('M',strtotime($bd->booking_date));?></big><span><?php if($bd->booking_time==0){echo 'Flexible';}
													else if($bd->booking_time==1){echo 'MORNING 8am - 12pm';}
													else if($bd->booking_time==2){echo 'AFTERNOON 12pm - 4pm';}
													else{echo 'EVENING 4pm - 8pm';}?> </span></p>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12 cac_cel_btn_new cac_cel_btn_new1<?php echo $bd->id;?> cancel_new_div">
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
			<b class="task_cancelled">Declined</b>
			<?php } else if($bd->status=='Cancel'){?>
			<b class="task_cancelled">Cancelled</b>
			<?php } else if($bd->status=='Paid'){?>
			<b class="task_accepted">Task Completed</b>
			<?php if($bd->rate_val==''){?><a href="javascript:void(0);" data-toggle="modal" data-target="#review_pop" data-id="<?php echo $bd->id;?>" data-taskerid="<?php echo $bd->tasker_id;?>" class="review_click theme_btn">Review</a>
			<?php } ?> 
		    <?php } }?>
		</div>
</div>
<?php } } else { echo 'No tasks found...';}?>
<script>
$('.task_done_btn').click(function(){
		
	  var id=$(this).attr('data-id');
	  var status=$(this).attr('data-status');
	  var review_tasker_id=$(this).attr('data-taskerid');
	  $(this).prop('disabled',true);
	  $.ajax({
						url:baseurl+'site/user/task_completed',
						dataType:'json',
						data:{'id':id,'status':status},
						type:'post',
						 beforeSend:function(){ 
								$(this).html('<img src="'+baseurl+'images/site/sivaloader.gif" style="margin:0 auto;width:25;height:25px;">');
							   },	
						success:function(data){
							if(data['error_new']!='')
							{   
						          $(this).html('Task done'); 
						         $(this).prop('disabled',false);
								swal('Opps',data['error_new'],'error');
							}
							else
							{
								$('.cac_cel_btn_new1'+id).html('<b class="task_request_task_completed">Task Completed</b>');
								$('#review_book_id').val(id);
								$('#review_tasker_id').val(review_tasker_id);
								$('#review_pop').modal('show');
							}
							
							
						}
					});
	});
	
$('.task_cancel_btn').click(function(){
		
	  var id=$(this).attr('data-id');
	  var status=$(this).attr('data-status');
	  $(this).prop('disabled',true);
	  		
			 swal({   
				 title: "Are you sure?",  
				/*  text: "You Cancel Your Account",  */
				 type: "warning",   
				 showCancelButton: true,
				 confirmButtonColor: "#DD6B55",   
				 confirmButtonText: "Yes",
				 cancelButtonText:"No", 
				 showLoaderOnConfirm: true,
				 closeOnConfirm: false },
				 function(){
					$.ajax({
						url:baseurl+'site/user/get_user_cancel_amount',
						dataType:'json',
						data:{'id':id,'status':status},
						type:'post',						
						success:function(data){
							if(data['error_new']!='')
							{   
						         $(this).prop('disabled',false);
								swal('Opps',data['error_new'],'error');
							}
							else
							{
								$('.cac_cel_btn_new1'+id).html('<b class="task_request_task_completed">Task Cancelled</b>');
								swal({title: "Task Cancelled", text: "Task cancelled successfully", type: "success"},
										   function(){ 
												   //location.href=baseurl+'account';
											   }
										);
							}
							
							
						}
					});					 
				 });
		
	
	});
	$('.rating').on('change',function(){
		$('#rate_val').val($(this).val()); 
	});
	$('.review_click').click(function(){
		$('#review_book_id').val($(this).attr('data-id'));
		$('#review_tasker_id').val($(this).attr('data-taskerid'));
	});
	$('#submit_review').click(function(){
		var bid=$('#review_book_id').val();
		var rate_val=$('#rate_val').val();
		var rate_comments=$('#rate_comments').val();
		if(rate_val=='')
		{
			swal('Error','Please give rating','error'); return false;
		}
		else if(rate_comments=='')
		{
			swal('Error','Please give comments','error'); return false;
		}
		else
		{
				$.ajax({
					url:'<?php echo base_url();?>site/user/save_review',
					type:'post',
					dataType:'html',
					data:$('#rate_form').serialize(),
					success:function(data){
						$('.close').click();
						swal({title: "Reviewed", text: "Review submitted successfully", type: "success"},
										   function(){ 
												   location.href=baseurl+'account';
											   }
										);
					}
				});
		}
	});
</script>
<!-- review popup -->
<form  id="rate_form" method="post">
 <div class="modal review_model" id="review_pop" role="dialog">

    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header"> 
		<h3>Rating for tasker</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		
        <div class="modal-body">
        
		  <div class="form modal_body_bg">
				  
				  <ul class="list-inline modal_ul">
						<li class="col-md-12 col-sm-12 col-xs-12"><label>Rate stars</label> 
							<input type="text" class="rating rating-loading"  value="" data-size="xs" title="">
				            <input type="hidden" id="rate_val" value="" name="rate_val">
				            <input type="hidden" id="review_book_id" value="" name="booking_id">
				            <input type="hidden" id="review_tasker_id" value="" name="tasker_id">
						</li>
						<li class="col-md-12 col-sm-12 col-xs-12 nopadd">
							<label>Comments</label> 
						   <textarea type="text" id="rate_comments" name="comments" placeholder="Comments" class="form-control"></textarea>
						</li>
						<li class="col-md-12 col-sm-12 col-xs-12 modal_submit nopadd">
							   <input type="button" name="submit" class="theme_btn" id="submit_review" value="Submit" />
						</li>
		  </div>
        </div>
      </div>
      
    </div>
  </div>
 </form> 

<!---login end--> 
  
<link rel="stylesheet" href="<?php echo base_url();?>css/site/star-rating.min.css" media="all" type="text/css"/>    
<script src="<?php echo base_url();?>js/site/star-rating.min.js" type="text/javascript"></script>