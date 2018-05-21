<div class="mobile_chat">
<?php $this->load->view('site/common/header');	?>
	<section>
			<div class="message_base col-md-12 col-sm-12 col-xs-12">
					<div class="container">
						<div class="message_inner_base col-md-12 col-sm-12 col-xs-12">
							<h1> Messsage (<span id="new_message"><?php echo $unreadmessage_count;?></span>)</h1>


							<div class="message_inner col-md-12 col-sm-12 col-xs-12">

								<div class="col-md-12 col-sm-12 col-xs-12 chat_tab_cont">
										  <ul class="nav nav-tabs chat_main_tab_ul" role="tablist">
										    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Inbox</a></li>
										    
										  </ul>

										  <!-- Tab panes -->
										  <div class="tab-content chat_tab_cont_panel col-md-12 col-sm-12 col-xs-12">
											    <div role="tabpanel" class="tab-pane active" id="home">
											    	<div class="col-md-3 col-sm-4 col-xs-12 cotntact_lft">
											    		 <div class="col-md-12 col-sm-12 col-xs-12 contact_lft_inner">
											    		 	<div class="chat_search col-md-12 col-sm-12 col-xs-12 nopadd">
											    		 		<div class="back_arrow_base">
											    		 				<a href="<?php echo base_url();?>dashboard">Back </a>
											    		 		</div>
											    		 		<input type="text" name="search" id="search_box" onchange="dosearch('search')" placeholder="Search for message...">
											    		 	</div>
											    		 	<div class="col-md-12 col-sm-12 col-xs-12 filter_chat">
											    		 		 <p class="custom_check"><input type="checkbox" id="all_delete" /> <label for="all_delete"></label></p>

											    		 		 <div class="dropdown filter_dropdown">
																	  <button class="sort_btn" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	   <span class="sort_title">Sort by</span> 
																	    <span class="drop_arrow">&nbsp;</span>
																	  </button>
																	  <ul class="dropdown-menu" aria-labelledby="dLabel">
																	 		<li> <a href="javascript:void(0)" onclick="dosearch('date');"> Date </a></li>
																	    	<li> <a href="javascript:void(0)" onclick="dosearch('unread');"> Unread </a></li>
																	  </ul>
																</div>
																<div class="delete_btn">
																		<a href="javascript:void(0)" id="delbtn"><i class="fa fa-trash" aria-hidden="true"></i></a>

																</div>
											    		 	</div>

											    		 	<ul class="nav nav-tabs chat_list" role="tablist" id="chat_leftbox">
															<?php if($message_list->num_rows()>0){ $i=1;
																  foreach($message_list->result() as $msg){	
																  if($msg->photo!='')
																	{
																		$pro_pic=base_url().'images/site/profile/'.$msg->photo;
																	}
																	else
																	{
																		$pro_pic=base_url().'images/site/profile/avatar.png';
																	}
																?>				
															   <li role="presentation" class="active msg_info limsg_<?php echo $msg->booking_id;?> <?php if($msg->message_status==1){ echo "unread_message";}?>" data-id="<?php echo $msg->booking_id;?>" data-image="<?php echo $pro_pic;?>" data-name="<?php echo ucfirst($msg->first_name);?>" data-receiver_id="<?php echo $msg->user_id;?>">
															    	<div class="chat_profile_img ">
															    		<img src="<?php echo $pro_pic;?>">
															    	</div>
															    	<div class="chat_profile_cont">
															    			<h2><?php echo ucfirst($msg->first_name);?></h2>
															    			<h6><?php echo date('h:i:a',strtotime($msg->created));?></h6>
															    			<h3>looking for <?php echo ucfirst($msg->task_name);?></h3>
															    	</div>
																   <div class="col-md-12 col-sm-12 col-xs-12 nopadd chat_prev_box">
																	  <div class="chat_profile_img ">
																		<p class="custom_check"><input type="checkbox" id="b_<?php echo $msg->booking_id;?>" name="del_checkbox[]" value="<?php echo $msg->booking_id;?>" class="msg_del_btn" data-id="<?php echo $msg->booking_id;?>" /> <label for="b_<?php echo $msg->booking_id;?>"></label></p>
																	   </div>
																	   <div class="chat_profile_cont">
																					<p class="nmsg_<?php echo $msg->booking_id;?>"><?php if(strlen($msg->msg!="")){
																						if(strlen($msg->msg)>150){
																							echo substr($msg->msg,0,150).'...';}
																							else { echo ucfirst($msg->msg);}}
																							else{
																								if(strlen($msg->message)>150){ echo substr($msg->message,0,150).'...';} 
																								else { echo ucfirst($msg->message);}} ?></p>
																		</div>
																	</div>

															    </li>
																<?php $i++; } } else { echo "<p id='no_msg'>No message found in inbox...</p>";}?>
																</ul>	


											    		 </div>
													</div>
													<div class="col-md-9 col-sm-8 col-xs-12 chat_rgt">
								<div class="col-md-12 col-sm-12 col-xs-12 chat_msg_profile_base" id="chat_head">
													<span class="back_btn" > Back </span>

													<?php
															  
																$pro_pic=base_url().'images/site/profile/avatar.png';  
																$fname="Guest";
															  
													?>
															<div class="chat_profile_img ">
																	<img id="chat_head_image" src="<?php echo $pro_pic;?>"> 
															</div>
															 <h6 id="chat_head_name">Guest</h6>

													</div>
													<div class="col-md-12 col-sm-12 col-xs-12 nopadd" id="msg_div">

													</div>
													<div id="chatbox" class="col-md-12 col-sm-12 col-xs-12 chat_textarea">
													<input type="text"  id="text_write" placeholder="Write something to send..." data-id="0" data-receiver_id="0">													
													<input type="submit" id="send_btn" class="send_btn" value="" >
													</div>
													</div>
													
											   </div>
											   
										  </div>

								</div>
									
							</div>
						</div>
					</div>
			</div>
		
	</section>
<div class="clearfix"></div>
<script >
     $(window).on('load',function(){
		 $('#chatbox').hide();
		$('#chat_head').hide();
	 });
	$(document).ready(function(){ 
		$('#text_write').on('keypress', function(e) {
			var code = e.keyCode || e.which;
			if(code==13){
				$('#send_btn').click();
			}
		});		
		
		$(document).on('click','.msg_info',function(){  if($(this).hasClass('new_msg_div')){ $(this).removeClass('new_msg_div');}
			$('#chatbox').show(0); $('#chat_head').show(0);
			$('#chat_head_image').attr('src',$(this).attr('data-image')); 
			$('#chat_head_name').text($(this).attr('data-name')); 
			var booking_id=$(this).attr('data-id'); 
			$('#text_write').attr('data-id',$(this).attr('data-id'));
			$('#text_write').attr('data-receiver_id',$(this).attr('data-receiver_id'));
			$.post('<?php echo base_url();?>site/user/get_message_list',{'booking_id':booking_id},function success(data){ $('#msg_div').html(data); $('.message_converstion_list').animate({scrollTop: $('.message_converstion_list').prop("scrollHeight")}, 0);  });
		});
		
		$('#send_btn').click(function(){ 
			var booking_id=$('#text_write').attr('data-id');  
			var user_id=$('#text_write').attr('data-receiver_id');  
			var message=$('#text_write').val();  
			if(message!=""){
			$.post('<?php echo base_url();?>site/user/sent_message',{'booking_id':booking_id,'user_id':user_id,'message':message},function success(data){ 
			$('#text_write').val('');
			$.post('<?php echo base_url();?>site/user/get_message_list',{'booking_id':booking_id},function success(data){ $('#msg_div').html(data);$('.message_converstion_list').animate({scrollTop: $('.message_converstion_list').prop("scrollHeight")}, 0);  });
			get_unread();
			
			});
			}
		});
		setInterval(function(){	
		get_unread();
		if($('#text_write').attr('data-id')!='' && $('#text_write').attr('data-id')!=0)
		{
		get_message();
		}
		}, 8000);
	})
	
	function dosearch(va)
	{
		new_msg_div='';
		if(va=="date")
		{
			var search_by="date";
			new_msg_div='';
		}
		else if(va=="unread")
		{
			var search_by="unread";
			new_msg_div='new_msg_div';
		}
		else
		{
			var search_by="text";
		}
		var search_box=$('#search_box').val();
		$.post('<?php echo base_url();?>site/user/message_search_list',{'search_by':search_by,'search_box':search_box},function success(data){ 
				$('#new_message').html($.parseJSON(data).count);  
				   $('#chat_leftbox').html('');
				   $('#no_msg').html('');				   
			       $.each($.parseJSON(data).ms, function (i, object) {
					  if($('.limsg_'+object.id).length>0){
					  $('.limsg_'+object.id).remove();}
					  var chatappend='<li role="presentation" class="active '+new_msg_div+' msg_info limsg_'+object.id+'" data-id="'+object.id+'" data-receiver_id="'+object.user_id+'"><div class="chat_profile_img "><img src="'+object.img+'"></div><div class="chat_profile_cont"><h2>'+object.first_name+'</h2><h6>'+object.time+'</h6><h3>looking for '+object.task_name+'</h3></div><div class="col-md-12 col-sm-12 col-xs-12 nopadd chat_prev_box"><div class="chat_profile_img "><p class="custom_check"><input type="checkbox" id="b_'+object.id+'" class="msg_del_btn" data-id="'+object.id+'" /> <label for="b_'+object.id+'"></label></p></div><div class="chat_profile_cont"><p class="nmsg_'+object.id+'">'+object.msg+'  </p></div></div></li>';
					  $('#chat_leftbox').prepend(chatappend);
					 					  
					});
					
				
			})
		
	}
	function get_unread(){
				
			$.post('<?php echo base_url();?>site/user/unreadmessage_count',{},function success(data){ 
				$('#new_message').html($.parseJSON(data).count);  
				
			       $.each($.parseJSON(data).ms, function (i, object) {
					  if($('.limsg_'+object.id).length>0){
					  $('.limsg_'+object.id).remove();}
					  var chatappend='<li role="presentation" class="active new_msg_div msg_info limsg_'+object.id+'" data-id="'+object.id+'" data-receiver_id="'+object.user_id+'"><div class="chat_profile_img "><img src="'+object.img+'"></div><div class="chat_profile_cont"><h2>'+object.first_name+'</h2><h6>'+object.time+'</h6><h3>looking for '+object.task_name+'</h3></div><div class="col-md-12 col-sm-12 col-xs-12 nopadd chat_prev_box"><div class="chat_profile_img "><p class="custom_check"><input type="checkbox" id="b_'+object.id+'" class="msg_del_btn" data-id="'+object.id+'" /> <label for="b_'+object.id+'"></label></p></div><div class="chat_profile_cont"><p class="nmsg_'+object.id+'">'+object.msg+'  </p></div></div></li>';
					  $('#chat_leftbox').prepend(chatappend);
					 					  
					});
					
				
			})
		
		}
		
	function get_message(){
			var booking_id=$('#text_write').attr('data-id'); 	
			$.post('<?php echo base_url();?>site/user/get_message_list',{'booking_id':booking_id},function success(data){ $('#msg_div').html(data);$('.message_converstion_list').animate({scrollTop: $('.message_converstion_list').prop("scrollHeight")}, 0);});
		
		}
	$(function(){
  
  $(".filter_dropdown .dropdown-menu li a").click(function(){
    
    $(".sort_title").text($(this).text());
     $(".sort_title").val($(this).text());
  });

});
	$('.delete_btn').hide();
	 $('#all_delete').click(function(){
                $('.delete_btn').fadeToggle(0);
                $('.filter_dropdown').fadeToggle(0);
				if($(this).is(':checked')){ 
				$('.msg_del_btn').attr('checked',true);
				}
				else
				{
			    $('.msg_del_btn').attr('checked',false);
				}
      });

	 $('.chat_list a').click(function (e) {
  e.preventDefault();
})
	 var wind_size = $( window ).width();
	 	
	 if( wind_size < 567 )
	 	{
	 		$('.msg_info').click(function(){
			$('.cotntact_lft').hide(0);
			$('.chat_rgt').show(0);
			
		});
	 		$('.back_btn').click(function(){
			$('.chat_rgt').hide(0);
			$('.cotntact_lft').show(0);

			
		});
	 	}


var new_array=[];
$('#delbtn').click(function(){
	$('[name="del_checkbox[]"]:checked').each(function(i,ob){
		if(ob.value!=""){
		new_array.push(ob.value);
		}
		
	});
		var bid=$(this).attr('data-id');
	 swal({   
				 title: "Are you sure? Not recover again",  				
				 type: "warning",   
				 showCancelButton: true,
				 confirmButtonColor: "#DD6B55",   
				 confirmButtonText: "Yes",
				 cancelButtonText:"No", 
				 closeOnConfirm: false },
				 function(){   swal("Deleted!", "Messsages deleted Successfully.", "success"); 
				 $.post('<?php echo base_url();?>site/user/inbox_delete',{'new_array':new_array},function(data){
					  location.reload();
				 });
})
})
</script>
<?php $this->load->view('site/common/footer');?>
</div>