<?php $this->load->view('site/common/header');	?>
	<section>
		<div class="clearfix"></div>
            <div class="service_info_base">
                    <div class="service_info_head">
						<div class="container">
							<ul class="list-inline">
								<li class="service_detail active"> <p><?php echo $this->lang->line('service_details'); ?> </p></li>
								<li class="compare_ser mob_res_none"> <p><?php echo $this->lang->line('service_and_price'); ?> </p></li>
								<li class="confirm_hire mob_res_none"> <p><?php echo $this->lang->line('confirm_hire'); ?> </p></li>
							</ul>
						</div>
                    </div>
					<div class="servicer_info_content">
						<div class="container">
						
							
							
							
							<h1><?php echo ucfirst($task_category->row()->task_name);?> <!--<a href="<?php echo base_url();?>"> (change)</a>--></h1>
							<div class="task_location_base col-md-12 col-sm-12 col-xs-12 ">
							            <h2>Task Sub Category</h2>
										<div class="clearfix"></div>
										<div class="col-md-12 col-sm-12 col-xs-12 serach_location nopadd">
										    <div class="col-md-3 col-sm-3 col-xs-12 choose_subcategory nopadd">
											<select id="subcat_id">
											   <option value="">Choose Sub Category</option>
											   <?php foreach($task_sub_category->result() as $service_ls){?>
												<option value="<?php echo $service_ls->id;?>" ><?php echo ucfirst($service_ls->subcat_name);?></option>	
												<?php }?>
											</select>	
											</div>
										</div>										
										
							            
										<h2><?php echo $this->lang->line('your_task_location'); ?></h2>
										<div class="clearfix"></div>
										<div class="col-md-9 col-sm-8 col-xs-12 serach_location nopadd">
												<input type="text" id="autocomplete_street_address" name="autocomplete_street_address" placeholder="Enter street address" class="form-control">
												<input type="hidden" id="task_id" value="<?php echo $tid;?>">
										</div>
										<div class="col-md-3 col-sm-4 col-xs-12 serach_location">
												<input type="text" name="appartment" id="appartment" placeholder="Unit or Apt #" class="form-control">
										</div>
										
										<!--<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="col-md-4 col-sm-4 col-xs-12 servicer_transport">
													<p class="custom_check"><input type="checkbox" name="vehicle_type[]" value="1" id="veh1">
															<label for="veh1">Bicycle</label></p>                                                        
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12 servicer_transport">
													<p class="custom_check"><input type="checkbox" name="vehicle_type[]" value="2" id="veh2">
															<label for="veh2">Car</label></p>                                                        
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12 servicer_transport">
													<p class="custom_check"><input type="checkbox" name="vehicle_type[]" value="3" id="veh3">
															<label for="veh3">Moving Truck</label></p>                                                        
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12 servicer_transport">
													<p class="custom_check"><input type="checkbox" name="vehicle_type[]" value="4" id="veh4">
															<label for="veh4">Minivan</label></p>                                                        
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12 servicer_transport">
													<p class="custom_check"><input type="checkbox" name="vehicle_type[]" value="5" id="veh5">
															<label for="veh5">Pickup Truck</label></p>                                                        
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12 servicer_transport">
													<p class="custom_check"><input type="checkbox" name="vehicle_type[]" value="6" id="veh6">
															<label for="veh6">Full-size Van</label></p>                                                        
											</div>
										</div>-->
										
										<div class="clearfix"></div>
										<!--<div class=" col-md-12 col-sm-12 col-xs-12 for_demo_purpose">
											<p> For Demo : Use Chennai, Mumbai, Bangalore as location</p>
										</div>-->
										<?php if($task_category->row()->vehicle_required==1){?>
										<h2>Vehicles</h2>
										<div class="clearfix"></div>
										<div class="col-md-12 col-sm-12 col-xs-12 serach_location nopadd">
										    <div class="col-md-3 col-sm-3 col-xs-12 choose_subcategory nopadd">											   
												<select id="vehicle_id">
													<option value="">Choose Vehicle</option>
													<?php foreach($vehicle_list->result() as $veh_list){?>
													<option value="<?php echo $veh_list->id;?>"><?php echo ucfirst($veh_list->vehicle_name);?></option>	
													<?php } ?>		
											    </select>										   
											</div>
										</div>	
										<?php }?>
										<div class="continue_locaion col-md-12 col-sm-12 col-xs-12">
													<a href="javascript:void(0);"  id="add_task_btn" class="theme_btn"><?php echo $this->lang->line('continue'); ?></a>
										</div>
							</div>
							<div class="task_location_base tell_us_task col-md-12 col-sm-12 col-xs-12 ">
										<h2><?php echo $this->lang->line('usabout_your_task'); ?></h2>
										
							</div>
						</div>
					</div>
            </div>
		<div class="clearfix"></div>
	</section>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?php echo $this->config->item('gmap_key');?>"></script>
	<script>
	$(document).ready(function(){
		init_map();
	});
	function init_map() { 
	  autocomplete = new google.maps.places.Autocomplete(
		 (document.getElementById('autocomplete_street_address')),
		  { types: ['geocode'] });
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var data = $("#autocomplete_street_address").serialize();
			return false;
		}
	  );
	}
	$('#add_task_btn').click(function(){
		        <?php if(!empty($userDetails)){ ?>
					var group="<?php echo $userDetails->row()->group;?>"; 
					if(group=="1"){
						
						swal('Error','You need to be a user to book a Tasker','error');	return false;
						
					}
				<?php }?>		
		        
				if($('#subcat_id').val()=='')
				{
					swal('Error','Plese choose sub category','error');	return false;
				}
		        else if($('#autocomplete_street_address').val()=='')
				{
					swal('Error','Enter your street address','error');	return false;
				}
		        var task_id=$('#task_id').val(); 
				/* var val = [];
				$(':checkbox:checked').each(function(i){
				  val[i] = $(this).val();
				}); */
				veh_name="";
				val=$('#vehicle_id').val();
				if(val!="")
				{
					veh_name=$('#vehicle_id option:selected').text();
				}
				
				$.ajax({
					url:baseurl+'site/user/check_tasker_available',
					dataType:'json',
					type:'post',
					data:{'city':$('#autocomplete_street_address').val(),'appartment':$('#appartment').val(),'veh':val,'task_id':task_id,'subcat_id':$('#subcat_id').val(),'subcat_name':$('#subcat_id option:selected').text(),'veh_name':veh_name},
					success:function(data){
						if(data['status']=='OK' && data['available']=='yes')
						{
							 swal({title: "Good news", text: "Service rabbit available in your area", type: "success"},
								   function(){
										  $(window).unbind('beforeunload'); 
										   location.href=baseurl+'add_task_description/'+task_id;
									   }
									);
						}
						else
						{ 
							if(val=="" || $('#vehicle_id').length==0){
							   swal('Error','Shoot! This task is outside of our coverage area.','error');	
							}
							else{	
							   swal('Error','Shoot! Vehicle is not available','error');	
							}							
						}
						
						
					}
				});
			});	
		$(window).on("beforeunload", function() {
            return "Are you sure? You didn't finish the booking tasker!";
        });	
	</script>
	<script>
// for this page only
$('.head_base').css('margin-bottom','1px');
</script>
<?php $this->load->view('site/common/footer');?>