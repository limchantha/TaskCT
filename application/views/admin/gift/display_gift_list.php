<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); if(!empty(unserialize($previllage))){extract(unserialize($previllage));} ?>
<div id="content">
<style>
.gold
{
	color:gold;
	font-size:14px;
}
.black
{
	color:black;
	font-size:14px;
}
</style>
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
															<th>Name</th>
															<th>price</th>
															<th>Gift Worth price</th>
															<th>Use Limit</th>
															<th>Gift applicable min price</th>
															<th>Status</th>
															<th>
																<i class="ace-icon fa fa-clock-o bigger-110"></i>
																Update
															</th>
														</tr>
													</thead>

													<tbody>
														<?php $i=1; foreach($task->result() as $task_list){ ?>
														<tr>															
															<td><?php echo $i;?></td>
															<td><?php echo ucfirst($task_list->name);?></td>
															<td><?php echo $task_list->price;?></td>
															<td><?php echo $task_list->gift_price;?></td>
															<td><?php echo $task_list->use_limit;?></td>
															<td><?php echo $task_list->min_price;?></td>
															<td><a class="btn btn-<?php echo $task_list->status=='1'?'success':'danger';?>" href="<?php echo base_url();?>admin/gift/change_status/<?php echo $task_list->id;?>/<?php echo $task_list->status=='1'?0:1;?>">
																<?php echo $task_list->status==1?"Active":"Inactive";?></a></td>
															<td>
															<div class="hidden-sm hidden-xs action-buttons">
																	
																<?php if($prev==1 || (!empty($Gift) && in_array('2',$Gift))){?>
																
																<a class="btn btn-success" href="<?php echo base_url();?>admin/gift/add_gift/<?php echo $task_list->id;?>">
																	Edit
																</a>
																<?php } ?>
																<?php if($prev==1 || (!empty($Gift) && in_array('3',$Gift))){?>
																
																<a onclick="return confirm('Once deleted cant be recover again...');" class="btn btn-danger" href="<?php echo base_url();?>admin/gift/delete_gift/<?php echo $task_list->id;?>">
																	Delete
																</a>
																<?php } ?>
															</div>													
														</td>
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
