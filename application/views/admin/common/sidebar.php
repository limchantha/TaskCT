	<?php
	$lang_key 	= $this->session->userdata('pictuslang_key');
	if(isset($lang_key)){
		$this->lang->load($lang_key, $lang_key);
	}else{
		$this->lang->load('en', 'en');
	}
	?>
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <?php if($prev==1){?>
	<li class="submenu <?php if($this->uri->segment(2)=="admin_settings" && $this->uri->segment(3)!="dashboard"){ echo 'open';}?>"> <a href="#"><i class="icon icon-user"></i> <span>Admin</span> </a>
      <ul>
        <li <?php if($this->uri->segment(3)=="edit_admin_settings"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/admin_settings/edit_admin_settings">Settings</a></li>
        <li <?php if($this->uri->segment(3)=="edit_admin"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/admin_settings/edit_admin">Change Password</a></li>
        
      </ul>
    </li>
	<?php } if(!empty(unserialize($previllage))){extract(unserialize($previllage));} if($prev==1 || (!empty($Subadmin) && in_array('0',$Subadmin))){?>
    <li class="submenu <?php if($this->uri->segment(2)=="subadmin"){ echo 'open';}?>"> <a href="#"><i class="icon icon-user"></i> <span>Sub Admins</span> </a>
      <ul>
        <li <?php if($this->uri->segment(3)=="display_subadmin_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/subadmin/display_subadmin_list">Subadmins List</a></li>
        <?php if($prev==1 || (!empty($Subadmin) && in_array('1',$Subadmin))){ ?>
		<li <?php if($this->uri->segment(3)=="add_user"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/subadmin/add_subadmin">Add Subadmin</a></li>
		<?php } ?>
        <li><a href="<?php echo base_url();?>admin/user/export_subadmin_list">Export Subadmins list</a></li>
      </ul>
    </li>
	<?php } if($prev==1 || (!empty($Users) && in_array('0',$Users))){ ?>
     <li class="submenu <?php if($this->uri->segment(2)=="user"){ echo 'open';}?>"> <a href="#"><i class="icon icon-user"></i> <span>Users</span> <span class="label label-important"><?php echo $total_user_count->num_rows();?></span></a>
      <ul>
        <li <?php if($this->uri->segment(3)=="dashboard"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/user/dashboard">Dashboard</a></li>
        <li <?php if($this->uri->segment(3)=="display_user_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/user/display_user_list">Users List</a></li>
        <?php if($prev==1 || (!empty($Users) && in_array('1',$Users))){ ?>
		<li <?php if($this->uri->segment(3)=="add_user"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/user/add_user">Add User</a></li>
		<?php }?>
        <li><a href="<?php echo base_url();?>admin/user/export_user_list">Export User list</a></li>
      </ul>
    </li>
	<?php } if($prev==1 || (!empty($Taskers) && in_array('0',$Taskers))){ ?>
     <li class="submenu <?php if($this->uri->segment(2)=="tasker" && $this->uri->segment(3)!="commission_tracking" && $this->uri->segment(3)!="commission_tracking_detail"){ echo 'open';}?>"> <a href="#"><i class="icon icon-wrench"></i> <span>Taskers</span> <span class="label label-important"><?php echo $total_tasker_count->num_rows();?></span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="dashboard"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/tasker/dashboard">Dashboard</a></li>
        <li <?php if($this->uri->segment(3)=="display_tasker_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/tasker/display_tasker_list">Taskers List</a></li>
		<?php if($prev==1 || (!empty($Taskers) && in_array('1',$Taskers))){ ?>
	   <li <?php if($this->uri->segment(3)=="add_tasker"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/tasker/add_tasker">Add Tasker</a></li>
		<?php } ?>
        <li><a href="<?php echo base_url();?>admin/tasker/export_tasker_list">Export Taskers list</a></li>
      </ul>

     </li><?php } if($prev==1 || (!empty($Services) && in_array('0',$Services))){ ?>	 
    <li class="submenu <?php if($this->uri->segment(2)=="service"){ echo 'open';}?>"> <a href="#"><i class="icon icon-tasks"></i> <span>Services</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_service_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/service/display_service_list">Services List</a></li>
        <?php if($prev==1 || (!empty($Services) && in_array('1',$Services))){ ?>
		<li <?php if($this->uri->segment(3)=="add_task_category"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/service/add_task_category">Add Services</a></li>
		<?php } ?>
        <li><a href="<?php echo base_url();?>admin/service/export_task_list">Export Services list</a></li>     
      </ul>

     </li>
	 <?php } if($prev==1 || (!empty($Subcat) && in_array('0',$Subcat))){ ?>	 
    <li class="submenu <?php if($this->uri->segment(2)=="subcat"){ echo 'open';}?>"> <a href="#"><i class="icon icon-tasks"></i> <span>Services Sub Category</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_subcat_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/subcat/display_subcat_list">Services Sub Category List</a></li>
        <?php if($prev==1 || (!empty($Subcat) && in_array('1',$Subcat))){ ?>
		<li <?php if($this->uri->segment(3)=="add_task_subcategory"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/subcat/add_task_subcategory">Add Services Sub Category</a></li>
		<?php } ?>
        <li><a href="<?php echo base_url();?>admin/subcat/export_task_list">Export Services Sub Category List</a></li>     
      </ul>

     </li>
    <?php } if($prev==1 || (!empty($Cms) && in_array('0',$Cms))){ ?>
    <li class="submenu <?php if($this->uri->segment(2)=="cms"){ echo 'open';}?>"> <a href="#"><i class="icon icon-tasks"></i> <span>CMS Pages</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_cms_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/cms/display_cms_list">CMS pages List</a></li>
        <?php if($prev==1 || (!empty($Cms) && in_array('1',$Cms))){ ?>
		<li <?php if($this->uri->segment(3)=="add_cms"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/cms/add_cms">Add cms page</a></li><?php } ?>
       </ul>

     </li>
	 <?php } if($prev==1 || (!empty($Email) && in_array('0',$Email))){ ?>
    <li class="submenu <?php if($this->uri->segment(2)=="emailtemp"){ echo 'open';}?>"> <a href="#"><i class="icon icon-envelope"></i> <span>Email templates</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_email_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/emailtemp/display_email_list"> Display Email Templates</a></li>
        <?php if($prev==1 || (!empty($Email) && in_array('1',$Email))){ ?>
		<li <?php if($this->uri->segment(3)=="add_email"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/emailtemp/add_email">Add Email emplate</a></li><?php } ?>
       </ul>

     </li>
	 <?php } if($prev==1 || (!empty($Bookings) && in_array('0',$Bookings))){ ?>
    <li class="submenu <?php if($this->uri->segment(2)=="bookings"){ echo 'open';}?>"> <a href="#"><i class="icon icon-money"></i> <span>Bookings</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_complete_bookings_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/bookings/display_complete_bookings_list">Completed Bookings List</a></li>
        <li <?php if($this->uri->segment(3)=="display_pending_bookings_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/bookings/display_pending_bookings_list">Pending Bookings List</a></li>
        <li <?php if($this->uri->segment(3)=="display_cancel_bookings_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/bookings/display_cancel_bookings_list">Cancelled Bookings List</a></li>
        <li <?php if($this->uri->segment(3)=="export_bookings_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/bookings/export_bookings_list/Paid">Export Completed Bookings List</a></li>
        <li <?php if($this->uri->segment(3)=="export_bookings_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/bookings/export_bookings_list/Pending">Export Pending Bookings List</a></li>
        <li <?php if($this->uri->segment(3)=="export_bookings_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/bookings/export_bookings_list/Cancel">Export Cancelled Bookings List</a></li>
        
       </ul>

     </li>
	 <?php } if($prev==1 || (!empty($Commission) && in_array('0',$Commission))){ ?>
    <li class="submenu <?php if($this->uri->segment(2)=="tasker"){ echo 'open';}?>"> <a href="#"><i class="icon icon-money"></i> <span>Tasker Commission Tracking</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="commission_tracking"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/tasker/commission_tracking">Tasker Commission Tracking</a></li>
     </ul>

     </li>
	 <?php } if($prev==1 || (!empty($Payments) && in_array('0',$Payments))){ ?>
	 <li class="submenu <?php if($this->uri->segment(2)=="payments"){ echo 'open';}?>"> <a href="#"><i class="icon icon-money"></i> <span>Payments</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_payments_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/payments/display_payment_list">Payments List</a></li>
        
       </ul>

     </li>
	 
	  <?php } if($prev==1 || (!empty($Language) && in_array('0',$Language))){ ?>
	 <li class="submenu <?php if($this->uri->segment(2)=="language"){ echo 'open active';} ?>"> <a href="#"><i class="icon icon-tasks"></i> <span>Language</span></a>
		<ul> <?php if($prev==1 || (!empty($Language) && in_array('1',$Language))){ ?>
		<li <?php if($this->uri->segment(3)=="add_language"){ echo 'class="active"';} ?>><a href="<?php echo base_url();?>admin/language/add_language">Add New Language</a></li><?php } ?>
			<li <?php if($this->uri->segment(2)=="language" && $this->uri->segment(3)==""){ echo 'class="active"';} ?>><a href="<?php echo base_url();?>admin/language">Language List</a></li>
       </ul>
     </li>
	  <?php } if($prev==1 || (!empty($Currency) && in_array('0',$Currency))){ ?>
	 <li class="submenu <?php if($this->uri->segment(2)=="currency"){ echo 'open active';} ?>"> <a href="#"><i class="icon icon-tasks"></i> <span>Currency</span></a>
		<ul> <?php if($prev==1 || (!empty($Currency) && in_array('1',$Currency))){ ?>
		<li <?php if($this->uri->segment(3)=="add_currency"){ echo 'class="active"';} ?>><a href="<?php echo base_url();?>admin/currency/add_currency">Add New Currency</a></li><?php }?>
			<li <?php if($this->uri->segment(2)=="currency" && $this->uri->segment(3)==""){ echo 'class="active"';} ?>><a href="<?php echo base_url();?>admin/currency/display_currency_list">Currency List</a></li>
       </ul>
     </li>
	 <?php } if($prev==1 || (!empty($City) && in_array('0',$City))){ ?>
	 <li class="submenu <?php if($this->uri->segment(2)=="city"){ echo 'open active';} ?>"> <a href="#"><i class="icon icon-tasks"></i> <span>City</span></a>
		<ul> <?php if($prev==1 || (!empty($City) && in_array('1',$City))){ ?>
		<li <?php if($this->uri->segment(3)=="add_city"){ echo 'class="active"';} ?>><a href="<?php echo base_url();?>admin/city/add_city">Add New City</a></li><?php }?>
			<li <?php if($this->uri->segment(2)=="city" && $this->uri->segment(3)=="display_city_list"){ echo 'class="active"';} ?>><a href="<?php echo base_url();?>admin/city/display_city_list">City List</a></li>
       </ul>
     </li>
	 
	 <?php } if($prev==1 || (!empty($Reviews) && in_array('0',$Reviews))){ ?>
	 <li class="submenu <?php if($this->uri->segment(2)=="review"){ echo 'open';}?>"> <a href="#"><i class="icon icon-star"></i> <span>Reviews</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_review_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/review/display_review_list">Reviews List</a></li>
        <li <?php if($this->uri->segment(3)=="display_tasker_review_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/review/display_tasker_review_list">Task reviews List</a></li>
         <?php if($prev==1 || (!empty($Reviews) && in_array('1',$Reviews))){ ?>
		<li <?php if($this->uri->segment(3)=="add_review"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/review/add_review">Add tasker review</a></li>
		 <?php } ?>
     </ul>
     </li>
	  <?php } if($prev==1 || (!empty($Gift) && in_array('0',$Gift))){ ?>
	  <li class="submenu <?php if($this->uri->segment(2)=="gift"){ echo 'open';}?>"> <a href="#"><i class="icon icon-gift"></i> <span>Gift card</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_gift_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/gift/display_gift_list">Gift card list</a></li>
        <?php if($prev==1 || (!empty($Gift) && in_array('1',$Gift))){ ?>
		<li <?php if($this->uri->segment(3)=="add_gift"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/gift/add_gift">Add gift card</a></li>
		 <?php } ?>
		<li <?php if($this->uri->segment(3)=="display_user_gift_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/gift/display_user_gift_list">Sold gift card</a></li>
     </ul>
     </li>
	  <?php } if($prev==1 || (!empty($Contact) && in_array('0',$Contact))){ ?>
	 <li class="submenu <?php if($this->uri->segment(2)=="contact"){ echo 'open';}?>"> <a href="#"><i class="icon icon-phone"></i> <span>Contact</span></a>
	 <ul>
        <li <?php if($this->uri->segment(3)=="display_contact_list"){ echo 'class="active"';}?>><a href="<?php echo base_url();?>admin/contact/display_contact_list">Contact List</a></li>
     </ul>
     </li>
	 <?php }?>
    
  </ul>
</div>