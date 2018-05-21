<?php $this->load->view('site/common/header');	?>
	<section>
			<div class="content_base aft_login_content">
					<div class="container">
						<div class="head_title col-md-12 col-sm-12 col-xs-12 nopadd text-center">
                            <h1>Welcome to Service Rabbit, <?php echo $user->first_name==''?'Guest':ucfirst($user->first_name);?></h1>
						</div>
						<div class="search_input col-md-12 col-sm-12 col-xs-12 nopadd">
							<input type="text" class="form-control searchbar_inputbox" placeholder="Search for your service.........">
							<ul class=" search_dropdown_box search_box_ul" id="myUL">
								<?php foreach($task_category->result() as $task_cat){?>
								<li class="search_li_box" data-val="<?php echo ucfirst($task_cat->task_name);?>" data-url="<?php echo base_url().'add_task/'.$task_cat->id;?>">
								<img class="searchbar_img" src="<?php if($task_cat->image=='')echo base_url().'images/site/category/contimg1.png'; else echo base_url().'images/site/category/'.$task_cat->image;?>">
								<?php echo ucfirst($task_cat->task_name);?> </li>
								<?php } ?>
							</ul>
						</div>
                        <div class="col-md-12 col-sm-12 col-xs-12 current_task_tab_base">
                        			<div class="tab_inner_currenttask">
                        				<div class="dashboard_tab_mob">
										  <ul class="nav nav-tabs" role="tablist">
										    <?php if($user->group==1){?><li role="presentation" class="active"><a href="#current" aria-controls="current" role="tab" data-toggle="tab">Current Tasks</a></li>
										    <li role="presentation"><a href="#completetask" onclick="completetask();" aria-controls="completetask" role="tab" data-toggle="tab">Completed Tasks</a></li> 
											<li role="presentation"><a href="#pasttask" aria-controls="pasttask" onclick="load_task_past_list()" role="tab" data-toggle="tab">Cancelled Tasks</a></li>					    
											<?php } else {?>
										   
											<li role="presentation" class="active"><a href="#user_current" aria-controls="current" role="tab" data-toggle="tab" id="utask" aria-controls="user_current"   onclick="load_user_current_list()">Current Tasks</a></li>
										    <li role="presentation"><a href="#reviewtask" id="rtask" onclick="reviewtask();" aria-controls="completetask" role="tab" data-toggle="tab">Completed Tasks</a></li>
											<li role="presentation"><a href="#canceluser" aria-controls="canceluser" onclick="dashboard_user_cancel_list()" role="tab" data-toggle="tab">Cancelled Tasks</a></li>	
											<?php } ?>
										  </ul>
										  </div>
										  <!-- Tab panes -->
										  <div class="tab-content col-md-12 col-xs-12 col-sm-12">
										    <?php if($user->group==1){?>
										    <div role="tabpanel" class="tab-pane active" id="current">
										    			<?php if($book_details_current->num_rows()>0){ foreach($book_details_current->result() as $bd){ ?>
														<div class="col-md-12 col-sm-12 col-xs-12 accor_cont_base">
											    			<h3 class="accord_head"><?php echo ucfirst($bd->task_name).' > '.ucfirst($bd->subcat_name);?></h3>
											    			<div class="col-md-12 col-sm-12 col-xs-12 accordian_cont">
											    				<div class="col-md-9 col-sm-12 col-xs-12 accordian_cont_lft">
																<p><?php if($bd->veh_name!="" && $bd->veh_name!="0" ){ echo "Vehicle Requirement: Need a <b>".$bd->veh_name.'</b>';}?></p>
																<?php if($bd->status=="Paid"){?><p><b><?php echo "SRA00".$bd->id;?> <?php echo '$'.$bd->total_amount;?></b></p><?php }?>
											    				<p>You are booked by <b> <?php echo ucfirst($bd->first_name.' '.$bd->last_name);?></b> .
																<?php if($bd->status=='Pending'){ ?>You’ve to confirm it before 30 mins.</p><?php }?>
											    				<h5><span><?php echo date('d',strtotime($bd->booking_date));?> <br> <small><?php echo date('M',strtotime($bd->booking_date));?></small></span> <b><?php if($bd->booking_time==0){echo 'Flexible';}
													else if($bd->booking_time==1){echo 'MORNING 8am - 12pm';}
													else if($bd->booking_time==2){echo 'AFTERNOON 12pm - 4pm';}
													else{echo 'EVENING 4pm - 8pm';}?> </b></h5>
											    				</div>
											    				<div class="col-md-3 col-sm-3 col-xs-12 accordian_cont_rgt text-right cac_cel_btn_new<?php echo $bd->id;?>">
											    				<?php  if($bd->status=='Pending'){ ?>
																		<a href="javascript:void(0);" data-id="<?php echo $bd->id;?>" data-status="Accept" class="theme_btn task_accept_decline_btn">Accept</a>
																		<a href="javascript:void(0);" data-id="<?php echo $bd->id;?>" data-status="Declined" class="theme_btn task_accept_decline_btn">Decline</a>	
																<?php  } else if($bd->status=='Accept'){ ?>	
																<a href="#" class="task_accepted">Task Accepted</a>
																<?php } else if($bd->status=='Declined'){?>
																<a href="#" class="task_cancelled">Task Declined</a>
																<?php } else if($bd->status=='Cancel'){?>
																<a href="#" class="task_cancelled">Task Cancelled</a>
																<?php } else if($bd->status=='Paid'){?>
																<a href="#" class="task_accepted">Task Completed</a>
																<?php } ?>
											    				</div>
											    			</div>
										    			</div>
														<?php }} else{?>
														<div class="col-md-12 col-sm-12 col-xs-12">
											    			<div class="no_task_found">No Task available...</div>
											    		</div>
														<?php }?>
										    </div>
										    <div role="tabpanel" class="tab-pane" id="pasttask">
										    		   
										    			
										    </div>
										    <div role="tabpanel" class="tab-pane" id="completetask">

										    </div>
											<?php } else{ ?>
											<div role="tabpanel" class="tab-pane active" id="user_current">
										    		   
										    			
										    </div>
										    <div role="tabpanel" class="tab-pane" id="reviewtask">

										    </div>
											
											<div role="tabpanel" class="tab-pane" id="canceluser">
										    		   
										    			
										    </div>
										    <?php }?>
										  </div>

								</div>		
                        </div>

						
					</div>
			</div>
		
	</section>
<script>
$(window).on('load',function(){
	<?php if($user->group!=1){?>
	$('#utask').click();
	/* load_user_current_list(); */
	<?php }?>
});
/* $(document).ready(function(){
	
$('.searchbar_inputbox').click(function(){
	var e=window.event||e;
	$('.search_dropdown_box').show(500);
	e.stopPropagation();
});
var a=0;	
var url='';     		   
$('.search_li_box').click(function(){
 a=1;  			
 url=$(this).attr('data-url'); 
 window.location.href=url;
});	
$('.searchbar_inputbox').keyup(function() {
value=$(this).val();
 
	var input, filter, ul, li, a, i;
	filter = value.toUpperCase();
	ul = document.getElementById("myUL");
	li = ul.getElementsByTagName('li');
	
	for (i = 0; i < li.length; i++) {
		a = li[i];
		if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
			li[i].style.display = "";
		} else {
			li[i].style.display = "none";
		}
	}
})
	
}); */
$(document).ready(function(){
$('.searchbar_inputbox').click(function(e){
	var e=window.event||e;
	var o = e.srcElement || e.target;
	$('.search_dropdown_box').show(500);
	e.stopPropagation();
});
 
var a=0;	
var url='';     		   
$('.search_li_box').click(function(){
 a=1;  			
 url=$(this).attr('data-url'); 
 window.location.href=url;
});	
$('.searchbar_inputbox').keyup(function() {
value=$(this).val();
  /* $(".search_dropdown_box li").hide().filter(":contains('"+ value +"')").show()
return false;	 */ 
	var input, filter, ul, li, a, i;
	filter = value.toUpperCase();
	ul = document.getElementById("myUL");
	li = ul.getElementsByTagName('li');
	
	for (i = 0; i < li.length; i++) {
		a = li[i];
		if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
			li[i].style.display = "";
		} else {
			li[i].style.display = "none";
		}
	}
})
	
});
$('.task_accept_decline_btn').click(function(){
		
	  var id=$(this).attr('data-id');
	  var status=$(this).attr('data-status');
	  $(this).html('<img src="'+baseurl+'images/site/sivaloader.gif" style="margin:0 auto;width:25;height:25px;">');
	  $.ajax({
						url:baseurl+'site/tasker/save_tasker_request_respond',
						dataType:'html',
						data:{'id':id,'status':status},
						type:'post',						
						success:function(data){
							 $(this).html('Task done');
							if(status=="Accept") 	
							{
								$('.cac_cel_btn_new'+id).html('<a href="#" class="task_accepted">Task Accepted</a>');	
							}
							else
							{
								$('.cac_cel_btn_new'+id).html('<a href="#" class="task_cancelled">Task Declined</a>');	
							}
							
						}
					});
	});
	
	function load_task_past_list()
	{
				$.ajax({
						url:baseurl+'site/user/tasker_past_list_load',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#pasttask').html('');
						$('#pasttask').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#pasttask').html('');	
							$('#pasttask').html(data);	
							
						}
					});
	}
    function completetask()
	{
				$.ajax({
						url:baseurl+'site/user/tasker_completed_list_load',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#completetask').html('');
						$('#completetask').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#completetask').html('');	
							$('#completetask').html(data);	
							
						}
					});
	}
 function reviewtask()
	{
				$.ajax({
						url:baseurl+'site/user/load_user_completed_list',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#reviewtask').html('');
						$('#reviewtask').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#reviewtask').html('');	
							$('#reviewtask').html(data);	
							
						}
					});
	}
	 function load_user_current_list()
	{
				$.ajax({
						url:baseurl+'site/user/load_user_current_list',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#user_current').html('');
						$('#user_current').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#user_current').html('');	
							$('#user_current').html(data);	
							
						}
					});
	}
 function dashboard_user_cancel_list()
	{
				$.ajax({
						url:baseurl+'site/user/dashboard_user_cancel_list',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#canceluser').html('');
						$('#canceluser').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#canceluser').html('');	
							$('#canceluser').html(data);	
							
						}
					});
	}
</script>
<script>
	$(document).click( function(e) {
    	$('.search_dropdown_box').hide(500);
  });
</script>
<script src="<?php echo base_url();?>js/site/jquery-ui.min.js"></script>
<script>
  /*$('.accordian_cont').hide();
			  $(document).ready(function(){
				$('.accord_head').click(function(){
					$(this).next().slideToggle(200);
					$(this).parent().siblings().children().next().slideUp();
				})
			}); */

</script>
<script>
$(document).on('click','.task_done_btn',function(){
		
	  var id=$(this).attr('data-id');
	  var task_hour=$('#task_hour_'+id).val(); 
	  if(task_hour=="" || task_hour=="0")
	  {
		  swal("Error","Please enter total task time","error"); return false;
	  }
	  var status=$(this).attr('data-status');
	  var review_tasker_id=$(this).attr('data-taskerid');
	  $(this).prop('disabled',true);
	   $(this).html('<img src="'+baseurl+'images/site/sivaloader.gif" style="margin:0 auto;width:25;height:25px;">');
	  $.ajax({
						url:baseurl+'site/user/task_completed',
						dataType:'json',
						data:{'id':id,'status':status,'task_time':task_hour},
						type:'post',
						 beforeSend:function(){ 
								$(this).html('<img src="'+baseurl+'images/site/sivaloader.gif" style="margin:0 auto;width:25;height:25px;">');
							   },	
						success:function(data){
							 $(this).html('Task done');
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
	
$(document).on('click','.task_cancel_btn',function(){
		
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
	
	$(document).on('change','.rating',function(){
		$('#rate_val').val($(this).val()); 
	});
	$(document).on('click','.review_click',function(){
		$('#review_book_id').val($(this).attr('data-id'));
		$('#review_tasker_id').val($(this).attr('data-taskerid'));
	});
	$(document).on('click','#submit_review',function(){
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
												   location.href=baseurl+'dashboard';
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
<?php $this->load->view('site/common/footer');?>