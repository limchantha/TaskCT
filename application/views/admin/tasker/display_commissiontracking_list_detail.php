<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); ?>
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
															<th>Tasker Email</th>
															<th>Tasker</th>
															<th>Total Amount</th>
															<th>Admin Amount</th>
															<th>Tasker Amount</th>
															<th>Paid</th>
															<th>Balance</th>
															<th>Payment Status</th>
															
														</tr>
													</thead>

													<tbody>
														<?php $i=1;$tot_task_amount=0; foreach($task->result() as $task_list){?>
														<tr>															
															<td><?php echo $i;?></td>
															<td><?php echo $task_list->email;?></td>
															<td><?php echo $task_list->tname;?></td>
															<td><?php echo $task_list->total_amount;?></td>
															<td><?php echo $task_list->service_fee;?></td>
															<td><?php echo $task_list->total_amount-$task_list->service_fee;?></td>
															<td><?php echo $task_list->paid_amount==""?'0':$task_list->paid_amount;?></td>
															<td><?php echo ($task_list->total_amount-$task_list->service_fee)-$task_list->paid_amount;?></td>
															<td><?php if((($task_list->total_amount-$task_list->service_fee)-$task_list->paid_amount)>0){?>
															<a class="btn btn-success" href="<?php echo base_url();?>admin/tasker/tasker_pay_process/<?php echo $task_list->id;?>">
																Pay</a>
															<?php } else{ echo'-';}?></td>
															
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
