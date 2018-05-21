<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); if(!empty(unserialize($previllage))){extract(unserialize($previllage));} ?>
<div id="content">

<!--breadcrumbs-->
  <div id="content-header">
  <?php if($this->session->flashdata('error_type')!='' && $this->session->flashdata('alert_message')!='' ){?>
<div class="alert <?php if(($this->session->flashdata('error_type')=='error')){?>alert-danger<?php }else{ echo "alert-success";}?>">
											<a class="close" data-dismiss="alert" href="javascript:void(0);">×</a>

											<?php echo( $this->session->flashdata('alert_message'));?>
											<br>
</div>
	<?php } ?>	
    <div id="breadcrumb"> <a href="javascript:void(0);" title="<?php echo $heading;?>" class="tip-bottom"><i class="icon-home"></i> <?php echo $heading;?></a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
 <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5><?php echo $heading;?></h5>
          </div>
          <div class="widget-content nopadding">
			<table id="dynamic-table" class="table table-bordered data-table">
													<thead>
														<tr>
															
															<th>Sno</th>
															<th>Booking No</th>
															<th>User</th>
															<th>Tasker</th>
															<th>Task Cateogry</th>
															<th>Booked Date</th>
															<th>Booked Time</th>
															<th>Amount</th>
															
														</tr>
													</thead>

													<tbody>
														<?php $i=1; foreach($task->result() as $task_list){?>
														<tr>															
															<td><?php echo $i;?></td>
															<td><?php echo 'SR000'.$task_list->id;?></td>
															<td><?php echo $task_list->uname;?></td>
															<td><?php echo $task_list->tname;?></td>
															<td><?php echo $task_list->task_name.'-'.$task_list->subcat_name;?></td>
															<td><?php echo date('d-M-Y',strtotime($task_list->booking_date));?></td>
															<td><?php if($task_list->booking_time==0){ echo 'Flexible';}else if($task_list->booking_time==1){ echo 'Morning';} else if($task_list->booking_time==2){ echo "Afternoon";} else{ echo "Evening";}?></td>
															<td>$<?php echo $task_list->total_amount;?></td>
															
														</tr>
														<?php $i++;} ?>														
													</tbody>
											</table>
		  </div>
        </div>
      </div>
    </div>
  </div>


</div>
<?php $this->load->view('admin/common/footer');?>
