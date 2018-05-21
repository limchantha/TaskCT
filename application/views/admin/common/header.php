<!DOCTYPE html>
<html lang="en">
<head>
<title><?php if(isset($heading)&& $heading!=''){ echo $heading.'-';} ?> <?php echo $this->config->item('site_name');?> Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/developer.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/media.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/uniform.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/select2.css" />
<link href="<?php echo base_url();?>css/admin/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/jquery.gritter.css" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script src="<?php echo base_url();?>js/admin/jquery.min.js"></script>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="<?php echo base_url();?>admin"><img src="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_logo1');?>"> <?php echo ucfirst($this->config->item('site_name'));?>
</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" ><i class="icon icon-user"></i>  <span class="text">Welcome <?php echo $this->session->userdata('gmtech_admin_name');?></span></a>
     <!-- <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
        <li class="divider"></li>
        <li><a href="<?php echo base_url();?>admin_settings/logout"><i class="icon-key"></i> Log Out</a></li>
      </ul>-->
    </li>
   <!-- <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
        <li class="divider"></li>
        <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
      </ul>
    </li>-->
    <li class=""><a title="" href="<?php echo base_url()?>admin/admin_settings/dashboard"><i class="icon icon-cog"></i> <span class="text">Dashboard</span></a></li>
    <li class=""><a title="" href="<?php echo base_url()?>admin/admin_settings/edit_admin_settings"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
    <li class=""><a title="" target="_new" href="<?php echo base_url();?>"><i class="icon icon-external-link"></i> <span class="text">View Site</span></a></li>
   <!-- <li class="dropdown"><a title="" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><span class="text">EN</span> <i class="icon icon-angle-down" aria-hidden="true"></i></a> 
	
                <ul class="dropdown-menu" aria-labelledby="dLabel">
                          <li><a href="#">English</a></li>
                          <li><a href="#">English</a></li>
                          <li><a href="#">English</a></li>
                </ul>

	---->

    </li>
    <li class=""><a title="" href="<?php echo base_url();?>admin/admin_settings/logout"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>

  </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>-->