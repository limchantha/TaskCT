<?php $this->load->view('site/common/header');	?>
	<section>
			<div class="message_base col-md-12 col-sm12 col-xs-12">
					<div class="container">
						<div class="message_inner_base col-md-12 col-sm-12 col-xs-12">
							<h1> Messsage (<span>2</span>)</h1>


							<div class="message_inner col-md-12 col-sm-12 col-xs-12">

								<div class="col-md-12 col-sm-12 col-xs-12 chat_tab_cont">
										  <ul class="nav nav-tabs" role="tablist">
										    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Inbox</a></li>
										    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Archived</a></li>
										  </ul>

										  <!-- Tab panes -->
										  <div class="tab-content chat_tab_cont_panel col-md-12 col-sm-12 col-xs-12">
											    <div role="tabpanel" class="tab-pane active" id="home">
											    	<div class="col-md-3 col-sm-4 col-xs-12 cotntact_lft">
											    		 <div class="col-md-12 col-sm-12 col-xs-12 contact_lft_inner">
											    		 	<div class="chat_search col-md-12 col-sm-12 col-xs-12 nopadd">
											    		 		<input type="text" name="" placeholder="Search for message...">
											    		 	</div>
											    		 	<div class="col-md-12 col-sm-12 col-xs-12 filter_chat">
											    		 		 <p class="custom_check"><input type="checkbox" id="all_delete" /> <label for="all_delete"></label></p>

											    		 		 <div class="dropdown filter_dropdown">
																	  <button class="sort_btn" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	   <span class="sort_title">Sort by</span> 
																	    <span class="drop_arrow">&nbsp;</span>
																	  </button>
																	  <ul class="dropdown-menu" aria-labelledby="dLabel">
																	 		<li> <a href="javascript:void(0)"> Date </a></li>
																	    	<li> <a href="javascript:void(0)"> Unread </a></li>
																	    	<li><a href="javascript:void(0)"> Newest First </a></li>
																	  </ul>
																</div>
																<div class="delete_btn">
																		<a href="javascript:void(0)">Delete</a>

																</div>
											    		 	</div>

											    		 	<ul class="nav nav-tabs chat_list" role="tablist">
															    <li role="presentation" class="active"><a href="#msg1" aria-controls="home" role="tab" data-toggle="tab">
															    	<div class="chat_profile_img ">
															    		<img src="<?php echo base_url();?>/images/site/chat_img.png">
															    	</div>
															    	<div class="chat_profile_cont">
															    			<h2>Mathew</h2>
															    			<h6>11:45pm</h6>
															    			<h3>looking for handyman</h3>
															    	</div>
															    	<div class="col-md-12 col-sm-12 col-xs-12 nopadd chat_prev_box">
																    	<div class="chat_profile_img ">
																    		<p class="custom_check"><input type="checkbox" id="delete" /> <label for="delete"></label></p>
																    	</div>
																    	<div class="chat_profile_cont">
																    			<p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremq...</p>
																    	</div>
															    	</div>

															    </a></li>
															    <li role="presentation"><a href="#msg2" aria-controls="profile" role="tab" data-toggle="tab">
															    	
															    	<div class="chat_profile_img ">
															    		<img src="<?php echo base_url();?>/images/site/chat_img.png">
															    	</div>
															    	<div class="chat_profile_cont">
															    			<h2>Mathew</h2>
															    			<h6>11:45pm</h6>
															    			<h3>looking for handyman</h3>
															    	</div>
															    	<div class="col-md-12 col-sm-12 col-xs-12 nopadd chat_prev_box">
																    	<div class="chat_profile_img ">
																    		<p class="custom_check"><input type="checkbox" id="delete" /> <label for="delete"></label></p>
																    	</div>
																    	<div class="chat_profile_cont">
																    			<p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremq...</p>
																    	</div>
															    	</div>


															    </a></li>
															    <li role="presentation"><a href="#msg3" aria-controls="messages" role="tab" data-toggle="tab">
															    	<div class="chat_profile_img ">
															    		<img src="<?php echo base_url();?>/images/site/chat_img.png">
															    	</div>
															    	<div class="chat_profile_cont">
															    			<h2>Mathew</h2>
															    			<h6>11:45pm</h6>
															    			<h3>looking for handyman</h3>
															    	</div>
															    	<div class="col-md-12 col-sm-12 col-xs-12 nopadd chat_prev_box">
																    	<div class="chat_profile_img ">
																    		<p class="custom_check"><input type="checkbox" id="delete" /> <label for="delete"></label></p>
																    	</div>
																    	<div class="chat_profile_cont">
																    			<p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremq...</p>
																    	</div>
															    	</div>

															    </a></li>
															    <li role="presentation"><a href="#msg3" aria-controls="settings" role="tab" data-toggle="tab">
															    	
															    	<div class="chat_profile_img ">
															    		<img src="<?php echo base_url();?>/images/site/chat_img.png">
															    	</div>
															    	<div class="chat_profile_cont">
															    			<h2>Mathew</h2>
															    			<h6>11:45pm</h6>
															    			<h3>looking for handyman</h3>
															    	</div>
															    	<div class="col-md-12 col-sm-12 col-xs-12 nopadd chat_prev_box">
																    	<div class="chat_profile_img ">
																    		<p class="custom_check"><input type="checkbox" id="delete" /> <label for="delete"></label></p>
																    	</div>
																    	<div class="chat_profile_cont">
																    			<p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremq...</p>
																    	</div>
															    	</div>
															    </a></li>
															 </ul>	


											    		 </div>
													</div>
													<div class="col-md-9 col-sm-8 col-xs-12 chat_rgt">

													</div>
											   </div>
											    <div role="tabpanel" class="tab-pane" id="profile">...</div>
										  </div>

								</div>
									
							</div>
						</div>
					</div>
			</div>
		
	</section>
<div class="clearfix"></div>
<script >
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
      });

	 $('.chat_list a').click(function (e) {
  e.preventDefault();
})
</script>
<?php $this->load->view('site/common/footer');?>