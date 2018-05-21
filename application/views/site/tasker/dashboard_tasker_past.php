<?php if($book_details_current->num_rows()>0){ foreach($book_details_current->result() as $bd){ ?>

		<div class="col-md-12 col-sm-12 col-xs-12 accor_cont_base delpast_<?php echo $bd->id;?>">
			<h3 class="accord_head"><?php echo ucfirst($bd->task_name).' > '.ucfirst($bd->subcat_name);?> </h3>
			<?php if($bd->rate_val!=''){?>
			<div class="review_star">
					<i class="fa fa-star<?php if($bd->rate_val<1){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<2){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<3){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<4){ echo '-o'; }?>" aria-hidden="true"></i>
					<i class="fa fa-star<?php if($bd->rate_val<5){ echo '-o'; }?>" aria-hidden="true"></i>
			</div>
			<?php } ?>
			<div class="col-md-12 col-sm-12 col-xs-12 accordian_cont">
				<div class="col-md-9 col-sm-12 col-xs-12 accordian_cont_lft">
				<p><?php if($bd->veh_name!="" && $bd->veh_name!="0" ){ echo "Vehicle Requirement: Need a <b>".$bd->veh_name.'</b>';}?></p>
				<?php if($bd->status=="Paid"){
					 $currency_rate = $this->session->userdata('currency_rate') ;
					$currencyArr = (array)json_decode($bd->currency_json); 
					if(isset($currencyArr[$currency_code])){
						  $currency_rate = $currencyArr[$currency_code];
					}
											
					?>

				<p>
				<span><?php echo "SRA00".$bd->id;?> </span> : <b> <?php echo $currency_symbol.' '.round($currency_rate*$bd->total_amount);?></b>
				</p><?php }?>

				<p><?php echo  $this->lang->line('you_are_booked_by'); ?> <b> <?php echo ucfirst($bd->first_name.' '.$bd->last_name);?></b> .<?php if($bd->status=='Pending'){ ?><?php echo  $this->lang->line('confirm_it_before_mins'); ?>.</p><?php }?></p>
				<h5><span><?php echo date('d',strtotime($bd->booking_date));?>  <br> <small><?php echo date('M',strtotime($bd->booking_date));?></small></span> <b><?php if($bd->booking_time==0){echo 'Flexible';}
				else if($bd->booking_time==1){echo 'MORNING 8am - 12pm';}
				else if($bd->booking_time==2){echo 'AFTERNOON 12pm - 4pm';}
				else{echo 'EVENING 4pm - 8pm';}?> </b></h5>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 accordian_cont_rgt text-right">
				<ul class="list-inline ">
					<li><a href="javascript:void(0);" data-id="<?php echo $bd->id;?>"  class="theme_btn del_btn">Delete</a></li>
				</ul>

				</div>
			</div>
		</div>
<?php } } else { echo '<div class="no_task_found"> '.$this->lang->line('no_enquires_found').'</div>';}?>

<script>
$(document).on('click','.del_btn',function(){
	var bid=$(this).attr('data-id');
	 swal({   
				 title: "Are you sure?",  				
				 type: "warning",   
				 showCancelButton: true,
				 confirmButtonColor: "#DD6B55",   
				 confirmButtonText: "Yes",
				 cancelButtonText:"No", 
				 closeOnConfirm: false },
				 function(){   swal("Deleted!", "Your Task deleted Successfully.", "success"); 
				 $.post('<?php echo base_url();?>site/user/dashboard_past_delete',{'bid':bid},function(data){$('.delpast_'+bid).hide();});
				 });
	
	
});

</script>