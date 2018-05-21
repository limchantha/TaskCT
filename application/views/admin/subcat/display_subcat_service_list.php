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
															<th>Sub Category Name</th>
															<th>Category Name</th>						
															<th>Status</th>
															<th>Featured</th>
															<th>
																<i class="ace-icon fa fa-clock-o bigger-110"></i>
																Update
															</th>
														</tr>
													</thead>

													<tbody>
														<?php $i=1; foreach($task->result() as $task_list){?>
														<tr>															
															<td><?php echo $i;?></td>
															<td><?php echo $task_list->subcat_name;?></td>
															<td><?php echo ucfirst($task_list->task_name);?></td>
															<td><a class="btn btn-<?php echo $task_list->status=='Active'?'success':'danger';?>" href="<?php echo base_url();?>admin/subcat/change_status/<?php echo $task_list->id;?>/<?php echo $task_list->status=='Active'?0:1;?>">
																<?php echo $task_list->status;?></a></td>
															<td style="text-align:center;"><a href="<?php echo base_url();?>admin/subcat/change_featured/<?php echo $task_list->id;?>/<?php if($task_list->featured==0){ echo "1";}else{ echo "0";}?>"<i class="icon icon-star <?php if($task_list->featured=="0"){ echo "black";}else{ echo "gold";}?>"></i></td>	
															<td>
															<div class="hidden-sm hidden-xs action-buttons">
																<?php if($prev==1 || (!empty($Subcat) && in_array('2',$Subcat))){?>												
																
																<a class="btn btn-success" href="<?php echo base_url();?>admin/subcat/add_task_subcategory/<?php echo $task_list->id;?>">
																	Edit
																</a> 
																<?php } ?>	
																<?php if($prev==1 || (!empty($Subcat) && in_array('3',$Subcat))){?>
																
																<a onclick="return confirm('Once deleted cant be recover again...');" class="btn btn-danger" href="<?php echo base_url();?>admin/subcat/delete_task/<?php echo $task_list->id;?>">
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
