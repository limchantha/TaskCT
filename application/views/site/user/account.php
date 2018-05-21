<?php $this->load->view('site/common/header');	?>
<style type="text/css">
	.show_imp
	{
		display: inline-block !important ;
	}
	.hide_imp
	{
		display: none !important;
	}
</style>
		<section>
		  <?php if($this->session->flashdata('error_type')!='' && $this->session->flashdata('alert_message')!='' ){?>
			<div class="alert <?php if(($this->session->flashdata('error_type')=='error')){?>alert-danger<?php }else{ echo "alert-success";}?>">
														<a class="close_box close" data-dismiss="alert" href="javascript:void(0);">×</a>

														<?php echo( $this->session->flashdata('alert_message'));?>
														<br>
			</div>
				<?php } ?>
			<div class="content_base profile_content">
					<div class="container">
                            <div class="col-md-4 col-sm-12 col-xs-12 profile_title nopadd">
                                    <h1><?php echo  $this->lang->line('your_account'); ?></h1>
                            </div>
							<?php /*if($user->group==1){ ?>
							<div class="col-md-8 col-sm-12 col-xs-12 profile_title nopadd" >
                                                
                                 <a href="<?php echo base_url();?>site/tasker/edit_tasker_profile" class="theme_btn"> Tasker Profile Edit</a> 
                                 <a href="<?php echo base_url();?>site/tasker/edit_tasker_taskdetails" class="theme_btn"> Tasks Edit</a> 
                                 <a href="<?php echo base_url();?>site/tasker/edit_credit_card" class="theme_btn"> Change credit card</a> 
								 <?php $st=$user->stripe_user_id==""?"Connect to Stripe":"Reconnect Stripe";?>
								 <a class="theme_btn btn btn-primary" data-loading-text="Connecting..." href="https://connect.stripe.com/oauth/authorize?response_type=code&scope=read_write&client_id=<?php echo $client_id;?>"><?php echo  $st;?></a>
								 <a href="<?php echo base_url();?>block_dates" class="theme_btn"> Block dates</a>
								 
                            </div>
							<?php } */ ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 profile_tab nopadd">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs profile_tab_head col-sm-4 col-xs-12" role="tablist">
								    <li role="presentation" class="active"><a href="#profile" aria-controls="home" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo  $this->lang->line('account'); ?></p></a></li>	 
									<?php if($userDetails->row()->group==1){ ?>
									<li role="presentation"><a href="#profile_document" aria-controls="home" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p>Verify your identity</p></a></li>
									 <li role="presentation"><a id="task_block_tab_button" href="#task_block_tab" onclick="load_block_dates();" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p>Block Dates</p></a></li>
									  <li role="presentation"><a href="#account" onclick="load_available_balance();" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('account_balance'); ?></p></a></li>
									   <?php } ?>	
									   <li role="presentation"><a href="#transaction" onclick="load_transaction_list()" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('transaction'); ?></p></a></li>
									 <?php if($userDetails->row()->group==1){ ?>  
									  <li role="presentation"><a href="#stripe_setting_tab" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('stripe_setting'); ?></p></a></li>
									<?php } ?>										
								    								
                                    <li role="presentation"><a href="#password" aria-controls="profile" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo  $this->lang->line('password'); ?></p></a></li>
									<?php if($userDetails->row()->group==1){ ?>
                                    <!--<li role="presentation"><a href="#task_request" onclick="load_tasker_enquires();" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('task_requests'); ?></p></a></li>-->
                                    <li role="presentation"><a href="#tasks_edit_tab" onclick="load_tasks_edit();" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('tasks_edit'); ?> </p></a></li> 
									<li role="presentation"><a href="#tasker_profile_edit_tab" onclick="load_tasker_profile();" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('tasker_profile_edit'); ?></p></a></li>                                  
									<?php }?>
									
                                    <li role="presentation"><a href="#notification" aria-controls="messages" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('notifications'); ?></p></a></li>  
									<?php if($userDetails->row()->group==0){ ?>
									<li role="presentation"><a href="#change_credit_card_tab" onclick="load_creditcard();" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p>Billing info</p></a></li>
									<li role="presentation"><a href="#gift_card_tab" onclick="load_giftcard();" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p>Gift card</p></a></li>
									<?php }?>
                                    <!--<li role="presentation"><a href="#cancel" onclick="load_task_list();" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('cancel_a_task'); ?></p></a></li>-->
                                   
									 <li role="presentation"><a href="#deactivate" aria-controls="settings" role="tab" data-toggle="tab"> <span class="mob_back">&nbsp;</span> <p><?php echo $this->lang->line('deactivate'); ?></p></a></li>
                                </ul>

                                <!-- Tab panes -->
								<?php 
									if($user->photo!='')
									{
										$pro_pic=base_url().'images/site/profile/'.$user->photo;
									}
									else
									{
										$pro_pic=base_url().'images/site/profile/big_avatar.png';
									}
								   if($user->id_doc!='')
									{
										$pro_pic_doc=base_url().'images/site/profile/doc/'.$user->id_doc;
									}
									else
									{
										$pro_pic_doc=base_url().'images/site/profile/doc/avatar.png';
									}
								?>
                                 
                                <div class="tab-content profile_tab_content col-sm-8 col-xs-12  nopadd">
                                    <!-- Profile -->
                                    <div role="tabpanel" class="tab-pane active profile_cont " id="profile">
                                            <div id="profile_tab1_form">
											<div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('account'); ?></h2>
                                                <a href="javascript:void(0);" id="profile_tab1_edit_button" class="theme_btn"><?php echo $this->lang->line('edit'); ?></a> 
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                <div class="col-md-3 col-sm-4 colxs-12 profile_avatar">
                                                        <img id="edit_pro_image_main" src="<?php echo $pro_pic;?>">
                                                </div>
                                                <div class="col-md-9 col-sm-8 col-xs-12 profile_detail">
                                                        <ul class="list-unstyled">
                                                            <li><i class="fa fa-user" aria-hidden="true"></i> <span id="l_name"><?php echo $user->first_name.' '.$user->last_name;?></span></li>
                                                            <li><i class="fa fa-envelope" aria-hidden="true"></i> <span id="l_email"><?php echo $user->email;?></span></li>
                                                            <li><i class="fa fa-phone" aria-hidden="true"></i> <span id="l_phone" class="cphone"><?php echo $user->phone;?></span></li>
                                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> <span id="l_zipcode" ><?php echo $user->zipcode!=''?$user->zipcode:'-';?></span></li>
                                                        </ul>
                                                </div>
                                            </div>
											</div>
											
											<div id="profile_tab1_edit_form">
											<div class="col-md-12 col-sm-12 col-xs-12 tab_content_title profile_cont">
                                                <h2><?php echo $this->lang->line('update_account'); ?></h2>
												<ul class="list-inline float_right_btn" >
                                                    <li><a href="javascript:void(0);" id="cancel_tab1_btn" class="cancel_btn"><?php echo $this->lang->line('cancel'); ?></a> </li>
                                                    <li><a href="javascript:void(0)" id="save_tab1_btn" class="theme_btn"><?php echo $this->lang->line('save'); ?></a> </li>
												</ul>	
                                             </div>
											 <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content chng_password " >
                                            		
												
                                               <div class="col-md-8 col-sm-8 col-xs-12 nopadd profile_detail otp_verification">
													 <form action="" data-user-id="<?php echo $user->id;?>" method="post" id="profile-tab1-edit-form" novalidate="novalidate">  

                                                        <ul class="list-unstyled update_profile_ul">
                                                            <li> <span class="full_name_class"> <input type="text" name="first_name" value="<?php echo $user->first_name;?>" placeholder="Full Name" class="form-control"> 
                                                                <input type="hidden" name="user_id" value="<?php echo $user->id;?>" placeholder="Full Name" class="form-control"></span></li>
                                                            <li> <span class="email_class"><input type="email" name="email" value="<?php echo $user->email;?>" placeholder="Email Address" class="form-control"></span></li>
                                                            <li><span class="phone_class"><input disabled type="text" name="phone" value="<?php echo $user->phone;?>" placeholder="phone" class="form-control cphone"></span></li>
                                                            <li> <span class="zipcode_class"><input type="text" name="zipcode" value="<?php echo $user->zipcode;?>" placeholder="zipcode" class="form-control"></span></li>
                                                        </ul>                                                    
													</form>  
													<div class="clearfix"></div>
													<form action="" data-user-id="<?php echo $user->id;?>" method="post" id="change_mobile_no" novalidate="novalidate">  
														<h2>Add/Change mobile</h2>
                                                        <ul class="list-unstyled update_profile_ul">
                                                            <li><span class="phone_class"><input type="text" name="change_phone" value="<?php echo $user->phone;?>" placeholder="phone" id="change_phone" class="form-control"></span></li>
															<li><a href="javascript:void(0)" id="change_mobile_btn" class="theme_btn"><?php echo $this->lang->line('save'); ?></a> </li>
                                                        </ul>
														<input type="hidden" name="user_id" value="<?php echo $user->id;?>" />
													</form> 
													<form action="" data-user-id="<?php echo $user->id;?>" method="post" id="change_mobile_otp_form" style="display:none;" novalidate="novalidate">  
														<h2>OTP Verification</h2>
                                                        <ul class="list-unstyled update_profile_ul">
                                                            <li><span class="phone_class"><input type="text" name="otp" id="otpno" placeholder="OTP" class="form-control"></span></li>
															<li><a href="javascript:void(0)" id="change_mobile_otp_btn" class="theme_btn"><?php echo $this->lang->line('save'); ?></a> </li>
                                                        </ul>
														<input type="hidden" name="otp_phone" id="otp_phone" />
													</form> 
                                                </div>
                                                <div class="col-md-4 col-sm-4 colxs-12 profile_avatar text-center upload_edit_btn">
                                                    <img id="edit_pro_image" src="<?php echo $pro_pic;?>">
                                                    <a href="javascript:void(0)" id="upload_btn" class=""><?php echo $this->lang->line('change_photo'); ?></a>
                                                    <form id="profile_picture_form" enctype="multipart/form-data" class="col-md-12 col-sm-6 col-xs-12 nopadd" >
                                                        <input  class="upload_btn_hidden" type="file" id="upload_profile_picture"  name="upload_profile_picture" />
                                                    </form>                                                 
                                                </div>
                                            </div>
											</div>
                                    </div>
									
									<div role="tabpanel" class="tab-pane profile_cont " id="profile_document">
                                            											
											<div id="doc_profile_tab1_edit_form">
											<div class="col-md-12 col-sm-12 col-xs-12 tab_content_title profile_cont">
                                                <h2><?php echo $this->lang->line('document_upload'); ?></h2>
													
                                             </div>
											 <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content chng_password " >
                                            	
                                                <div class="col-md-12 col-sm-12 col-xs-12 document_uplod text-center upload_edit_btn">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 upload_img_bg">
                                                    <img id="edit_doc_image" src="<?php echo $pro_pic_doc;?>">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <a href="javascript:void(0)" id="upload_document_btn" class="theme_btn"><?php echo $this->lang->line('upload_document'); ?></a>
                                                    </div>
                                                    <form id="document_picture_form" enctype="multipart/form-data" class="col-md-12 col-sm-6 col-xs-12 nopadd" >
                                                        <input  class="upload_btn_hidden" type="file" id="upload_document_picture"  name="upload_document_picture" />
                                                    </form>                                                 
                                                </div>
                                            </div>
											</div>
                                    </div>
									<div role="tabpanel" class="tab-pane cancel_base" id="change_credit_card_tab">

                                                 <div class="col-md-12 col-sm-12 col-xs-12 edit_account_credit tab_content_title">
                                                <h2><?php echo $this->lang->line('change_creditcard'); ?></h2>

                                            </div>
											
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                    
                                                    <div id="change_credit_card">
													</div>
                                           </div>
											
                                 </div>
                                    <div role="tabpanel" class="tab-pane cancel_base" id="gift_card_tab">

                                                 <div class="col-md-12 col-sm-12 col-xs-12 edit_account_credit tab_content_title">
                                                <h2 class="gift_balance_head">Gift Cards</h2>
                                                 <p class="pull-right gift_balance">Gift Amount: <?php echo $currency_symbol; echo' '. $currency_rate*$user->gift_amount;?></p>

                                            </div>
											
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                    
                                                    <div id="gift_card">
													</div>
                                           </div>
											
                                 </div>
                                    <!-- password -->
                                     <div role="tabpanel" class="tab-pane chng_password" id="password">
                                         <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('change_password'); ?></h2>
                                                <ul class="list-inline">
                                                    <li><a href="javascript:void(0);" id="cancel_tab2_btn" class="cancel_btn"><?php echo $this->lang->line('cancel'); ?></a> </li>
                                                    <li><a href="javascript:void(0);" id="save_tab2_btn" class="theme_btn"><?php echo $this->lang->line('save'); ?></a> </li>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                             <form id="profile-tab2-edit-form">  
											   <div class="col-md-12 col-sm-12 col-xs-12 nopadd curnt_pass">
                                                      <label><?php echo $this->lang->line('current_password'); ?></label> 
                                                      <input type="password" name="current_password">
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                                                    <ul class="list-inline confm_psw">
														<li class="col-md-7 col-sm-6 col-xs-12"><label><?php echo $this->lang->line('new_password'); ?></label> 
															<input type="password" name="new_password" id="new_password">
														</li>
														<li class="col-md-5 col-sm-6 col-xs-12 nopadd">
															<label><?php echo $this->lang->line('confirm_new_password'); ?></label> 
															<input type="password" name="confirm_password">
														</li>
                                                    </ul>
                                                </div>
											 </form>	
                                            </div>
                                    </div>
                                    <!-- notification -->
                                    <div role="tabpanel" class="tab-pane chng_password notifi_cation" id="notification">
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('notifications'); ?></h2>
                                                <ul class="list-inline">
                                                    <li><a href="javascript:void(0);" id="cancel_tab3_btn" class="cancel_btn"><?php echo $this->lang->line('cancel'); ?></a> </li>
                                                    <li><a href="javascript:void(0);" id="save_tab3_btn" class="theme_btn"><?php echo $this->lang->line('save'); ?></a> </li>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
												 <form id="profile-tab3-edit-form"> 		
												   <div class="col-md-11 col-sm-12 col-xs-12 notifi_inner">
                                                            <div class="form_communcation col-md-4 col-sm-4 col-xs-12 nopadd">
                                                                    <h3><?php echo $this->lang->line('form_of_communication'); ?></h3>
                                                                    <p><?php echo $this->lang->line('task_update'); ?></p>
                                                            </div>
                                                            <div class="form_communcation col-md-4 col-sm-4 col-xs-12 nopadd">
                                                                    <h3 class="text-right"><?php echo $this->lang->line('email'); ?></h3>
                                                                    <p class="custom_check text-right email_check">
																	<input <?php if($user->task_email==1){echo "checked";} ?> type="checkbox" id="email" name="task_email" />
                                                                    <label for="email">&nbsp;</label></p>
                                                            </div>
                                                            <div class="form_communcation col-md-4 col-sm-4 col-xs-12 nopadd">
                                                                    <h3 class="text-center"><?php echo $this->lang->line('sms'); ?></h3>
                                                                    <p class="custom_check text-center">
																	<input <?php if($user->task_sms==1){echo "checked";} ?> type="checkbox" id="sms" name="task_sms" />
                                                                    <label for="sms">&nbsp;</label></p>
                                                            </div>
                                                    </div>
												</form>	
                                            </div>
                                    </div>
                                    <!-- billing -->
                                    <div role="tabpanel" class="tab-pane chng_password exp_date_base" id="billing">
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('edit_billing_info'); ?></h2>
                                                <ul class="list-inline">
                                                    <li><a href="#" class="theme_btn"><?php echo $this->lang->line('cancel'); ?></a> </li>
                                                    <li><a href="#" class="theme_btn"><?php echo $this->lang->line('save'); ?></a> </li>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                                                      <ul class="list-inline confm_psw">
                                                            <li class="col-md-7 col-sm-6 col-xs-12"><label><?php echo $this->lang->line('card_number'); ?></label> 
                                                                <input type="text">
                                                            </li>
                                                            <li class="col-md-5 col-sm-6 col-xs-12 nopadd">
                                                                <label><?php echo $this->lang->line('expiration_date'); ?></label> 
                                                                <ul class="list-inline exp_date">
                                                                  <li> <select><option>Month</option></select></li>
                                                                  <li>  <select><option>Month</option></select><li>
                                                                </ul>
                                                            </li>
                                                    </ul>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                                                    <ul class="list-inline confm_psw">
                                                            <li class="col-md-7 col-sm-6 col-xs-12"><label><?php echo $this->lang->line('security_code'); ?></label> 
                                                                <input type="text">
                                                            </li>
                                                            <li class="col-md-5 col-sm-6 col-xs-12 nopadd">
                                                                <label><?php echo $this->lang->line('postal_code'); ?></label> 
                                                                <input type="text">
                                                            </li>
                                                    </ul>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- cancel -->
                                    <div role="tabpanel" class="tab-pane  cancel_base" id="cancel">

                                                <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('cancel_a_task'); ?></h2>
                                                </div>
												<div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
												<p><?php echo $this->lang->line('to_cancel_a_task'); ?></p>
                                                <div id="user_task_list_ajax">
												</div>
												</div>
                                    </div>
                                    <!-- account -->
                                    <div role="tabpanel" class="tab-pane" id="account">
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('account_balance'); ?></h2>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                <p class="acc_bal"><?php echo $this->lang->line('available_account_balance'); ?> : <span id="user_available_balance_text">$0</span></p>
                                                <p><?php echo $this->lang->line('are_automatically'); ?></p>
                                            </div>
                                    </div>
                                    <!-- transaction -->
                                    <div role="tabpanel" class="tab-pane trans_his" id="transaction">
                                           <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('transaction_history'); ?></h2>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content text-center">
                                                    <a href="<?php echo base_url();?>site/user/export_transaction_list"><span><img src="<?php echo base_url();?>images/site/download_icon.png"></span> <?php echo $this->lang->line('download_transaction_history'); ?></a>
                                                    <div id="transaction_list_ajax">
														<p><?php echo $this->lang->line('have_any_transactions'); ?></p>
												    </div>												
                                            </div> 
                                    </div>
                                    <!-- deactivate -->
                                    <div role="tabpanel" class="tab-pane acc_dact" id="deactivate">
                                               <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('account_deactivation'); ?></h2>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                <p><?php echo $this->lang->line('once_you_have'); ?></p>
                                                 <a href="javascript:void(0);" id="deactivate_btn" class="theme_btn"><?php echo $this->lang->line('deactivate'); ?></a> 
                                            </div> 
                                    </div>
								<?php if($userDetails->row()->group==1){ ?>		
								<div role="tabpanel" class="tab-pane chng_password cancel_base" id="task_request">

                                                 <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('task_requests'); ?></h2>

                                            </div>
											<?php if($userDetails->row()->group==1){ ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                    <p><?php echo $this->lang->line('accept_or_decline'); ?></p>
                                                    <div id="task_enquires_list">
													</div>
                                                    <a href="#" class="goto_dashbrd"><?php echo $this->lang->line('go_to_dashboard'); ?> <img src="<?php echo base_url();?>images/site/goto_icon.png"></a>
                                            </div>
											<?php } ?>
                                    </div>
									
                                 <div role="tabpanel" class="tab-pane  cancel_base" id="tasker_profile_edit_tab">

                                                 <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('tasker_profile_edit'); ?></h2>

                                            </div>
											
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content account_profile_edit">
                                                    
                                                    <div id="tasker_profile_edit">
													</div>
                                           </div>
											
                                 </div>
								<div role="tabpanel" class="tab-pane  cancel_base account_task_edit" id="tasks_edit_tab">

                                                 <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('tasks_edit'); ?></h2>

                                            </div>
											
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                    
                                                    <div id="tasks_edit">
													</div>
                                           </div>
											
                                 </div>
								
								<div role="tabpanel" class="tab-pane  cancel_base stripe_connect" id="stripe_setting_tab">

                                                 <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('stripe_setting'); ?></h2>

                                            </div>
											
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                    
                                                    <div id="stripe_setting">
													<?php $st=$user->stripe_user_id==""?"Connect to Stripe":"Reconnect Stripe";?>
													<a class="theme_btn " data-loading-text="Connecting..." href="https://connect.stripe.com/oauth/authorize?response_type=code&scope=read_write&client_id=<?php echo $client_id;?>"><?php echo  $st;?></a>
													<!--<a class="theme_btn" href="<?php echo base_url();?>site/tasker/cancel_stripe">Cancel</a> -->	
													</div>
                                           </div>
											
                                 </div>
								<div role="tabpanel" class="tab-pane  cancel_base" id="task_block_tab">

                                                 <div class="col-md-12 col-sm-12 col-xs-12 tab_content_title">
                                                <h2><?php echo $this->lang->line('task_block_dates'); ?></h2>

                                            </div>
											
                                            <div class="col-md-12 col-sm-12 col-xs-12 tab_content_content">
                                                    
                                                    <div id="block_dates">
													</div>
                                           </div>
											
                                 </div>
								<?php } ?>	
                                </div>

                            </div>
					</div>
			</div>
		
	</section>
	<script type="text/javascript" src="<?php echo base_url();?>js/site/jquery.form.js"></script>
    <script>
		$('#profile_tab1_edit_button').click(function(){ 
			$("#profile_tab1_form").css('display','none');
			$("#profile_tab1_edit_form").css('display','block');
		});
		$('#deactivate_btn').click(function(){ 
			 swal({   
				 title: "Are you sure?",  
				/*  text: "You Cancel Your Account",  */
				 type: "warning",   
				 showCancelButton: true,
				 confirmButtonColor: "#DD6B55",   
				 confirmButtonText: "Yes",
				 cancelButtonText:"No", 
				 closeOnConfirm: false },
				 function(){   swal("Deactivated!", "Your Account Deactivated Successfully.", "success"); 
				 window.location=baseurl+'site/user/cancelmyaccount';
				 });
		});
		$('#save_tab1_btn').click(function(){ 
		    $("#profile-tab1-edit-form").submit();
		});		
		$('#cancel_tab1_btn').click(function(){ 
		    $("#profile_tab1_edit_form").css('display','none');
			$("#profile_tab1_form").css('display','block');
		});
		$('#save_tab2_btn').click(function(){ 
		    $("#profile-tab2-edit-form").submit();
		});		
		$('#cancel_tab2_btn').click(function(){ 
		    $("#profile-tab2-edit-form").trigger('reset');			
		});
		$('#save_tab3_btn').click(function(){ 
		    $("#profile-tab3-edit-form").submit();
		});		
		$('#cancel_tab3_btn').click(function(){ 
		    $("#profile-tab3-edit-form").trigger('reset');			
		});
	 $('#upload_btn').click(function(){ 
		    $('#upload_profile_picture').click();
		});
    $('#upload_document_btn').click(function(){ 
		    $('#upload_document_picture').click();
		});
		
	$(document).ready(function(){
		$('#upload_document_picture').on('change',function(){
			var user_id=$('#loginCheck').val();
			$('#document_picture_form').ajaxForm({
				url:baseurl+'site/user/upload_document_picture',
				dataType:"json",
				method:'post',
				data:{"user_id":user_id},
				beforeSubmit:function(e){
					$('#edit_doc_image').attr('src',baseurl+'images/site/sivaloader.gif');
				},
				success:function(e){
					if(e['status']==0)
						{
						swal('Error',e['message'],'error');
						}
						else
						{
						swal('Success',e['message'],'success');	
						}
						$('#edit_doc_image').attr('src',e['l_image']);
						
							
				},
				error:function(e){
				}
			}).submit();
		});
	});
	 
	function load_tasker_enquires()
	{
				$.ajax({
						url:baseurl+'site/tasker/tasker_enquires_load',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#task_enquires_list').html('');
						$('#task_enquires_list').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#task_enquires_list').html('');	
							$('#task_enquires_list').html(data);	
							
						}
					});
	}
	
	function load_tasker_profile()
	{ 
				$.ajax({
						url:baseurl+'site/tasker/edit_tasker_profile',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#tasker_profile_edit').html('');
						$('#tasker_profile_edit').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#tasker_profile_edit').html('');	
							$('#tasker_profile_edit').html(data);	
							//initMap();
						}
					});
	}
	function load_tasks_edit()
	{
				$.ajax({
						url:baseurl+'site/tasker/edit_tasker_taskdetails',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#tasks_edit').html('');
						$('#tasks_edit').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#tasks_edit').html('');	
							$('#tasks_edit').html(data);	
							
						}
					});
	}
	function load_creditcard()
	{
				$.ajax({
						url:baseurl+'site/tasker/edit_credit_card',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#change_credit_card').html('');
						$('#change_credit_card').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#change_credit_card').html('');	
							$('#change_credit_card').html(data);	
							
						}
					});
	}
	function load_giftcard()
	{
				$.ajax({
						url:baseurl+'site/user/add_gif_card',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#gift_card').html('');
						$('#gift_card').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#gift_card').html('');	
							$('#gift_card').html(data);	
							
						}
					});
	}
	
	function load_block_dates()
	{
				$.ajax({
						url:baseurl+'site/tasker/block_dates',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#block_dates').html('');
						$('#block_dates').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#block_dates').html('');	
							$('#block_dates').html(data);	
							
						}
					});
	}
	
	function load_task_list()
	{
				$.ajax({
						url:baseurl+'site/user/tasker_list_load',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#user_task_list_ajax').html('');
						$('#user_task_list_ajax').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#user_task_list_ajax').html('');	
							$('#user_task_list_ajax').html(data);	
							
						}
					});
	}
	function load_transaction_list()
	{
				$.ajax({
						url:baseurl+'site/user/load_transaction_list',
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#transaction_list_ajax').html('');
						$('#transaction_list_ajax').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#transaction_list_ajax').html('');	
							//$('#transaction_list_ajax').html(data);	
							
						}
					});
	}
	
	function load_available_balance()
	{
				$.ajax({
						url:baseurl+'site/user/load_available_balance',
						dataType:'html',
						type:'post',
						success:function(data){ 
							$('#user_available_balance_text').html(data);	
							
							
						}
					});
	}
	
	$('.close_box').click(function(){$('.alert').hide(2000);});
	if($('.alert').length>0){ setTimeout(function(){$('.alert').hide(2000);},3000); }
	</script>
	
	<!-- Image crop-->
<script src="<?php echo base_url();?>js/site/croppie.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/site/croppie.css">
<script src="<?php echo base_url();?>js/site/jquery.simplePopup.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/site/exif.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	var urlnew;
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
	
    viewport: {
        width: 200,
        height: 200,
        type: 'square'
    },
    boundary: {
        width: 200,
        height: 200
    }
});
$(document).on('click','.simplePopupClose,.simplePopupBackground',function(){
	$('#upload_profile_picture').val(null); 
});

$('#upload_profile_picture').on('change',function () {    
   $('#pop1').simplePopup();
	var reader = new FileReader(); 
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
			
    	}); 
    	 
		urlnew=e.target.result;		
    }
	
    reader.readAsDataURL(this.files[0]);
  
	
	
});

$('.upload-result').on('click', function (ev) { var imgn;
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
       $('#load').html($('#load').attr('data-loading-text'));
		$.ajax({
			url: "<?php echo base_url();?>site/user/upload_profile_picture",
			type: "POST",
			dataType:"json",
			data: {"image":resp},
			success: function (e) { 
				swal({
                            title: "Success", 
                            text: "Profile image uploaded successfully", 
                            type: "success"},
                            function() {
							imgn=e['l_image'];
							//console.log(imgn);
							$('#edit_pro_image').attr('src',imgn);
							$('#edit_pro_image_main').attr('src',imgn);
							$('.header_logo_ajax').attr('src',imgn);
					        $('.simplePopupClose').click();  
							$('#load').html('Upload');
                        });
						    
							
			}
		});
	});						});
  
});

$(document).on("click","#change_mobile_btn",function(){
	$("#change_mobile_no").submit();
});

$(document).on("click","#change_mobile_otp_btn",function(){
	$("#change_mobile_otp_form").submit();
});

</script>
<script>
	$(document).ready(function(){
        var size_window = $(window).width();
        if(size_window < 767 )
        {
        	$('.profile_tab_head li').click(function(){ 
        		$('.profile_tab_head li').addClass('hide_imp');	
        		$(this).removeClass('hide_imp');	
        		 $(this).addClass('show_imp');
        		
        	})

        	$('.mob_back').click(function(e){  
                
        		$('.profile_tab_head li').removeClass('hide_imp');
        		$('.profile_tab_head li').removeClass('active');
        		$('.profile_tab_content .tab-pane').removeClass('active');
        		


        		$(document).scrollTop(0);
        		e.stopPropagation();
        			
        		
        		
        	})

        	

        }
});


</script>
<!-- Modal -->
<div id="pop1" class="simplePopup custom_picture">
		<div class="container1">
			<div class="panel panel-default">
			  <div class="panel-heading"><?php echo $this->lang->line('profile_image'); ?></div>
			  <div class="panel-body">

				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12  text-center">
						<div id="upload-demo" ></div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<button class="btn btn-success upload-result" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Uploading..."><?php echo $this->lang->line('upload'); ?></button>
					</div>	  		
				</div>
				

			  </div>
			</div>
		</div>
</div>

<!-- Image crop-->
	
<?php $this->load->view('site/common/footer');?>