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
			<div class="about_service_base">
                    <?php $this->load->view('site/tasker/profile_header');?> 
				<div class="about_base col-md-12 col-sm-12 col-xs-12 nopadd">
						<div class="container">
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
			<div class="clearfix"></div>
	</section>

<?php $this->load->view('site/common/footer');?>