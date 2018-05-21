<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); ?>
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="row-fluid">
            <div class="span12 ">
              <ul class="site-stats">
                <li class="bg_lo span4"><i class="icon-user"></i> <strong><?php echo $total_user_count->num_rows();?></strong> <small>Total Users</small></li>
                <li class="bg_ls span3"><i class="icon-plus"></i> <strong><?php echo $new_user->num_rows();?></strong> <small>New Users </small></li>
                <li class="bg_lg span4"><i class="icon-shopping-cart"></i> <strong><?php echo $overall_booking->num_rows();?></strong> <small>Total Bookings</small></li>
                <li class="bg_lo span4"><i class="icon-user"></i> <strong><?php echo $total_tasker_count->num_rows();?></strong> <small>Total Taskers</small></li>
                <li class="bg_ls span3"><i class="icon-plus"></i> <strong><?php echo $new_tasker->num_rows();?></strong> <small>New Taskers</small></li>
                <li class="bg_lo span4"><i class="icon-money"></i> <strong><?php echo $overall_admin_profit->row()->tot;?></strong> <small>Admin Profit</small></li>
              </ul>
            </div>
	 <div class="span12 user_table_admin">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5><?php echo $heading;?></h5>
          </div>
          <div class="widget-content nopadding">
			<table id="dynamic-table" class="table table-bordered data-table">
													<thead>
														<tr>
															
															<th>Sno</th>
															<th>Name</th>
															<th>Email</th>
															<th>Last Login Date</th>
															<th>Last Login IP</th>
														</tr>
													</thead>

													<tbody>
														<?php foreach($user->result() as $user_list){?>
														<tr>															
															<td><?php echo $user_list->id;?></td>
															<td><?php echo ucfirst($user_list->first_name);?><?php echo $user_list->last_name;?></td>
															<td><?php echo $user_list->email;?></td>
															<td><?php echo $user_list->last_login_date;?></td>
															<td><?php echo $user_list->last_login_ip;?></td>
														</tr>
														<?php } ?>														
													</tbody>
											</table>
		  </div>
        </div>
      </div>
	  <div class="span12 user_table_admin">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5><?php echo $heading1;?></h5>
          </div>
          <div class="widget-content nopadding">
			<table id="dynamic-table" class="table table-bordered data-table">
													<thead>
														<tr>
															
															<th>Sno</th>
															<th>Name</th>
															<th>Email</th>
															<th>Last Login Date</th>
															<th>Last Login IP</th>
															
														</tr>
													</thead>

													<tbody>
														<?php foreach($user1->result() as $user_list1){?>
														<tr>															
															<td><?php echo $user_list1->id;?></td>
															<td><?php echo ucfirst($user_list1->first_name);?><?php echo $user_list1->last_name;?></td>
															<td><?php echo $user_list1->email;?></td>
															<td><?php echo $user_list1->last_login_date;?></td>
															<td><?php echo $user_list1->last_login_ip;?></td>												
														</tr>
														<?php } ?>														
													</tbody>
											</table>
		  </div>
        </div>
      </div>
    
    		
          </div>
  </div>
</div>
<style>
.row-fluid [class*="span"]:first-child {
    margin-left: 2.5%;
}
.row-fluid .span5 {
    width: 47.17094%;
}
</style>
<?php $this->load->view('admin/common/footer');?>
