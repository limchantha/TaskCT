<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if(isset($heading)){ echo $heading!=''?$heading.' - ':'';echo ucfirst($this->config->item('site_name'));} else { echo ucfirst($this->config->item('site_name')); }?></title>
	<link rel="alternate" href="<?php echo base_url();?>">
    <meta content='<?php echo $this->config->item('site_name');?>' name='author'>
	<meta content='<?php echo $this->config->item('meta_description');?>' name='description'>
	<meta content='<?php echo $this->config->item('meta_keywords');?>' name='keywords'>
	<meta property="fb:app_id" content="<?php echo $this->config->item('fb_app_id');?>">
	<meta property="og:site_name" content="<?php echo ucfirst($this->config->item('site_name'));?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo base_url();?>">
	<meta property="og:title" content="<?php echo $this->config->item('meta_title');?>">
	<meta property="og:description" content="<?php echo $this->config->item('meta_description');?>">
	<meta property="og:image" content="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_logo')!=''?$this->config->item('site_logo'):'logo.png';?>">
	<meta property="og:locale" content="en_US">
    <meta name="twitter:widgets:csp" content="on">
	<meta name="twitter:url" content="<?php echo base_url();?>">
	<meta name="twitter:description" content="<?php echo $this->config->item('meta_description');?>">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="<?php echo $this->config->item('meta_title');?>">
	<meta name="twitter:site" content="<?php echo $this->config->item('twitter_name');?>">
	<meta name="twitter:app:id" content="<?php echo $this->config->item('twitter_app_id');?>">
	<meta name="twitter:app:name:iphone" content="<?php echo ucfirst($this->config->item('site_name'));?>">
	<meta name="twitter:app:name:ipad" content="<?php echo ucfirst($this->config->item('site_name'));?>">
	<meta name="twitter:app:name:googleplay" content="<?php echo ucfirst($this->config->item('site_name'));?>">
	<meta name="twitter:app:id:googleplay" content="<?php echo base_url();?>">
	<meta name="twitter:app:url:iphone" content="<?php echo base_url();?>">
	<meta name="twitter:app:url:ipad" content="<?php echo base_url();?>">
	<meta name="twitter:app:url:googleplay" content="<?php echo base_url();?>">
	<link rel="shortcut icon" sizes="76x76" type="image/x-icon" href="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_favicon')!=''?$this->config->item('site_favicon'):'favicon.ico';?>" />
	<script>
		var baseurl="<?php echo base_url();?>"; 
	</script>	
</head>
<link href="<?php echo base_url();?>css/site/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/site/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/site/developer.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/site/sweetalert.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/site/jquery-3.1.1.min.js"></script>
<body>
	<header>
	<?php 
	$lang_key 	= $this->session->userdata('pictuslang_key');
	$lang_data 	 = langdata();
	if(isset($lang_key)){
		$lang_key = $lang_key;
	}else{
		$lang_datas  = langdata_default();
		$lang_key 	 = $lang_datas[0]['lang_code'];
		$this->session->set_userdata('lang_key',$lang_key);
	}
	if(!empty($lang_key)){
			$this->lang->load($lang_key, $lang_key);
	}else{
		$this->lang->load('en', 'en');
	}
	?>
		<div class="head_base">
                <div class="container">
                	<div class="col-md-12 col-sm-12 col-xs-12 desktop_menu nopadd">
					<div class="col-md-3 col-sm-4 col-xs-12 logo">
						<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_logo')!=''?$this->config->item('site_logo'):'logo.png';?>"></a>
					</div>
					<?php if($logincheck==""){?>
					<div class="col-md-9 col-sm-8 col-xs-12 login">
							<ul class="list-inline pull-right">							
							<?php /*<li class="language dropdown"><a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $lang_key; ?>  <img src="<?php echo base_url();?>images/site/arrow.png"></a>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<?php foreach($lang_data as $val){ ?>
										<li><a href="<?php echo base_url().'site/language/lang_set/'.$val['lang_code']; ?>"><?php echo $val['lang_code']; ?></a></li>
									<?php } ?>

								</ul>
							</li>
							<li class="language dropdown"><a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $currency_code; ?>  <img src="<?php echo base_url();?>images/site/arrow.png"></a>
								<ul class="dropdown-menu" aria-labelledby="dLabel1">
									<?php foreach($currency_lists->result() as $curr){ ?>
										<li><a href="<?php echo base_url().'site/currency/change_currency/'.$curr->currency_type; ?>"><?php echo $curr->currency_type; ?></a></li>
									<?php } ?>

								</ul>
							</li> */ ?>
							<li class="login_a"><a href="<?php echo base_url();?>user_login"><?php echo $this->lang->line('login'); ?></a>
							</li>
							<li><a href="<?php echo base_url();?>become-a-tasker" class="theme_btn"><?php echo $this->lang->line('become_tasker'); ?></a></li>
						</ul>
					</div>
					<?php } else { if(!empty($userDetails)){
							if($userDetails->row()->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$userDetails->row()->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/avatar.png';
							}
							if($userDetails->row()->first_name!='')
							{
								$first_name=$userDetails->row()->first_name;
							}
							else
							{
								$first_name='Guest';
							}		
						?>
					<div class="col-md-9 col-sm-8 col-xs-12 login_aft">	
                        <div class="dropdown drop_custom pull-right dropdown_header">
                            <img class="header_logo_ajax" src="<?php echo $pro_pic;?>">
                            <a href="javascript:void(0);" class="dropdown-toggle drop_head_title" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo BASEURL;?>dashboard"><?php echo $this->lang->line('dashboard'); ?></a></li>
                            	<li><a href="<?php echo BASEURL;?>account"><?php echo $this->lang->line('my_account'); ?></a></li>
                            	<li><a href="<?php echo BASEURL;?>logout"><?php echo $this->lang->line('logout'); ?></a></li>
                              </ul>
                        </div>	
                        <a href="<?php echo BASEURL;?>inbox" class="msg_icon"><i class="fa fa-envelope" aria-hidden="true"></i> <span class="notify_msg"></span> </a>
						<?php /*<div class="col-md-9 col-sm-8 col-xs-12 login">
							<ul class="list-inline pull-right">
							<li class="language dropdown"><a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $lang_key; ?>  <img src="<?php echo base_url();?>images/site/arrow.png"></a>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<?php foreach($lang_data as $val){ ?>
										<li><a href="<?php echo base_url().'site/language/lang_set/'.$val['lang_code']; ?>"><?php echo ucfirst($val['lang_code']); ?></a></li>
									<?php } ?>

								</ul>
							</li>
							<li class="language dropdown"><a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $currency_code; ?>  <img src="<?php echo base_url();?>images/site/arrow.png"></a>
								<ul class="dropdown-menu" aria-labelledby="dLabel1">
									<?php foreach($currency_lists->result() as $curr){ ?>
										<li><a href="<?php echo base_url().'site/currency/change_currency/'.$curr->currency_type; ?>"><?php echo $curr->currency_type; ?></a></li>
									<?php } ?>

								</ul>
							</li>
						</ul>
					</div> */?>
					</div>
					<?php }} ?>
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12 mobile_menu">
						<div class="col-md-3 col-sm-4 col-xs-8 logo text-left">
								<a href="<?php echo base_url();?>" class="pull-left"><img src="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_logo')!=''?$this->config->item('site_logo'):'logo.png';?>"></a>
						</div>
						<?php if($logincheck==""){?>
						<div class="col-md-9 col-sm-8 col-xs-4 login">
							<div id="mySidenav" class="sidenav">
							  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
							  <ul class="list-unstyled pull-right">
								<li class="login_a"><a href="<?php echo base_url();?>user_login"><?php echo $this->lang->line('login'); ?></a></li>
								<li><a href="<?php echo base_url();?>become-a-tasker" class="theme_btn"><?php echo $this->lang->line('become_tasker'); ?></a></li>
							</ul>
							<ul class="list-inline pull-right">
							<li class="language dropdown"><a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $lang_key; ?>  <img src="<?php echo base_url();?>images/site/arrow.png"></a>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<?php foreach($lang_data as $val){ ?>
										<li><a href="<?php echo base_url().'site/language/lang_set/'.$val['lang_code']; ?>"><?php echo $val['lang_code']; ?></a></li>
									<?php } ?>

								</ul>
							</li>
						</ul>
							</div>
						<span onclick="openNav()" class="pull-right nav_icon_mob"><i class="fa fa-align-justify" aria-hidden="true"></i></span>
						</div>
						
						<?php } else { if(!empty($userDetails)){
							if($userDetails->row()->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$userDetails->row()->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/avatar.png';
							}
							if($userDetails->row()->first_name!='')
							{
								$first_name=$userDetails->row()->first_name;
							}
							else
							{
								$first_name='Guest';
							}		
						?>
					<div class="col-md-9 col-sm-8 col-xs-4 login_aft">	
						<div id="mySidenav" class="sidenav">
							  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <div class="dropdown drop_custom pull-right dropdown_header">
                            <img class="header_logo_ajax" src="<?php echo $pro_pic;?>">
                            <a href="javascript:void(0);" class="dropdown-toggle drop_head_title" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo BASEURL;?>dashboard"><?php echo $this->lang->line('dashboard'); ?></a></li>
                            	<li><a href="<?php echo BASEURL;?>account"><?php echo $this->lang->line('my_account'); ?></a></li>
                            	<li><a href="<?php echo BASEURL;?>logout"><?php echo $this->lang->line('logout'); ?></a></li>
                              </ul>
                        </div>	
                        <div class="clearfix"></div>
                        <a href="<?php echo BASEURL;?>inbox" class="msg_icon"><i class="fa fa-envelope" aria-hidden="true"></i> <span class="notify_msg"></span> </a>
						<div class="col-md-9 col-sm-8 col-xs-12 login">
							<ul class="list-inline pull-right">
							<li class="language dropdown"><a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $lang_key; ?>  <img src="<?php echo base_url();?>images/site/arrow.png"></a>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<?php foreach($lang_data as $val){ ?>
										<li><a href="<?php echo base_url().'site/language/lang_set/'.$val['lang_code']; ?>"><?php echo $val['lang_code']; ?></a></li>
									<?php } ?>

								</ul>
							</li>
						</ul>
					</div>
					</div>
					<span onclick="openNav()" class="pull-right nav_icon_mob"><i class="fa fa-align-justify" aria-hidden="true"></i></span>
					</div>
					<?php }} ?>
						
						
					</div>
                </div>
		</div>

		<script type="text/javascript">
			
			/* Open the sidenav */
function openNav() {
    document.getElementById("mySidenav").style.width = "100%";
}

/* Close/hide the sidenav */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
		</script>
	</header>