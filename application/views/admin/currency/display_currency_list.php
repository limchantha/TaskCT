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
															<th>Country Name</th>
															<th>Currency Type</th>						
															<th>Currency Symbol</th>
															<th>Currency Rate</th>
															<th>Status</th>
															<th>
																<i class="ace-icon fa fa-clock-o bigger-110"></i>
																Update
															</th>
														</tr>
													</thead>

													<tbody>
														<?php $i=1; foreach($currency_list->result() as $currency){?>
														<tr>															
															<td><?php echo $i;?></td>
															<td><?php echo $currency->country_name;?></td>
															<td><?php echo $currency->currency_type;?></td>
															<td><?php echo $currency->currency_symbols;?></td>
															<td><?php echo $currency->currency_rate;?></td>
															<td><a class="btn btn-<?php echo $currency->status=='Active'?'success':'danger';?>" href="<?php echo base_url();?>admin/currency/change_status/<?php echo $currency->id;?>/<?php echo $currency->status=='Active'?0:1;?>">
																<?php echo $currency->status;?></a></td>													
															
															<td>
															<div class="hidden-sm hidden-xs action-buttons">
															
																<?php if($currency->id==3){ echo "<p style='color:green;text-align:center;'><i class='icon icon-check'></i> Default</p>";}else{ if($prev==1 || (!empty($Currency) && in_array('2',$Currency))){?>												
																
																<a class="btn btn-success" href="<?php echo base_url();?>admin/currency/add_currency/<?php echo $currency->id;?>">
																	Edit
																</a> 
																<?php } ?>	
																<?php if($prev==1 || (!empty($Currency) && in_array('3',$Currency))){?>
																
																<a onclick="return confirm('Once deleted cant be recover again...');" class="btn btn-danger" href="<?php echo base_url();?>admin/currency/delete_currency/<?php echo $currency->id;?>">
																	Delete
																</a>
																<?php } } ?>	
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
