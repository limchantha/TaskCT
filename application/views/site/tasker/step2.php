<?php $this->load->view('site/common/header');	?>
	<section>
		<div class="clearfix"></div>
			<div class="servicer_detail_base">
                     <div class="container">
                            <div class="service_detail_inner servicer_detail_2nd_step">
								 <form id="tasker_profile_picture_form" method="post" enctype="multipart/form-data">
                                    <h1><?php echo $this->lang->line('register_become_tasker'); ?></h1>
                                    <div class="head_tile_scnd">
                                        <h2><?php echo $this->lang->line('about_yourself'); ?></h2>
                                        <div class="progress_base">
                                        <span><?php echo $this->lang->line('registration_completion'); ?> 15%</span>
                                        <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                                <span class="sr-only">60% <?php echo $this->lang->line('complete'); ?></span>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 service_2_content nopadd">
                                    		<?php 
												if($user->photo!='')
												{
													$pro_pic=base_url().'images/site/profile/'.$user->photo;
												}
												else
												{
													$pro_pic=base_url().'images/site/profile/upload_img.png';
												}
											?>
                                            <div class="col-md-4 col-sm-4 col-xs-12 service_photo pull-right">
                                                    <div class="browse_photo">
                                                           
															<label for="upload_img"><img src="<?php echo $pro_pic;?>" id="edit_pro_image" width="170">
                                                            <span class="browse_photo_inner"><?php echo $this->lang->line('update_picture'); ?> </span> </label>
	                                                        <input type="file" class="browse_img" name="upload_profile_picture" id="upload_img">
															
	                                                        
                                                    </div>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-12  nopadd">
                                                    <div class="col-md-6 col-sm-12 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('would_you_like'); ?>?</label>
                                                            <select class="form-control" name="work_city">
																<option value=""><?php echo $this->lang->line('choose_city'); ?></option>
																<?php if(!empty($tasker_city)){ foreach($tasker_city->result() as $tcity){ ?>
																<option <?php if($user->work_city==$tcity->id){ echo 'selected';}?> value="<?php echo $tcity->id;?>"><?php echo $tcity->city_name;?></option>
																<?php } } ?>
															</select>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('home_address'); ?></label>
                                                            <input type="text" value="<?php  echo $user->home;?>" name="home" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('street_address'); ?></label>
                                                            <input type="text" value="<?php  echo $user->street;?>" name="street" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('town_city'); ?></label>
                                                            <input type="text" id="city_latlong" value="<?php  echo $user->city;?>" name="city" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('state'); ?></label>
                                                            <input type="text" value="<?php  echo $user->state;?>" name="state" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('zipcode'); ?></label>
                                                            <input type="text" id="zipcode_latlong" value="<?php  echo $user->zipcode;?>" name="zipcode" class="form-control">
                                                            <input type="hidden"  value="<?php  echo $user->lat;?>" id="lat" name="lat" class="form-control">
                                                            <input type="hidden"  value="<?php  echo $user->long;?>" id="long" name="long" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 servicer_input date_of_birth">
                                                            <label><?php echo $this->lang->line('date_of_birth'); ?></label>
                                                            <input type="text" value="<?php  echo $user->dob;?>" name="dob" id="dob" class="form-control flatpickr">
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 servicer_input">
                                                            <label><?php echo $this->lang->line('phone_type'); ?></label>
                                                            <select name="phone_type" class="form-control">
																<option <?php if($user->phone_type=='Iphone'){ echo 'selected';}?>>Iphone</option>
																<option <?php if($user->phone_type=='Android'){ echo 'selected';}?>>Android</option>																
															</select>
                                                    </div>
													<div class="col-md-6 col-sm-12 col-xs-12 servicer_input date_of_birth">
                                                            <label><?php echo $this->lang->line('dervice_distance'); ?></label>
															 <select name="distance" class="form-control">
																<option value="50"  <?php if($user->distance=='50'){ echo 'selected';}?>>50 Km</option>
																<option value="100" <?php if($user->distance=='100'){ echo 'selected';}?>>100 Km</option>
																<option value="200" <?php if($user->distance=='200'){ echo 'selected';}?>>200 Km</option>
																										
															</select>
                                                            
                                                    </div>
                                            </div>
											
                                    </div>
									
                                                    
									<div class="col-md-12 col-sm-12 col-xs-12 nopadd tasker_task_desc">
										 <div class="col-md-8 col-sm-12 col-xs-12 servicer_input date_of_birth nopadd">
											<label><?php echo $this->lang->line('right_person'); ?></label>
											<textarea name="detail1" class="form-control required" ><?php  echo $user->detail1;?></textarea>
                                         </div>
										 <div class="col-md-8 col-sm-12 col-xs-12 servicer_input date_of_birth nopadd">
											<label><?php echo $this->lang->line('not_servicing'); ?></label>
											<textarea name="detail2" class="form-control required" ><?php  echo $user->detail2;?></textarea>
                                         </div><div class="col-md-8 col-sm-12 col-xs-12 servicer_input date_of_birth nopadd">
											<label><?php echo $this->lang->line('servicing'); ?></label>
											<textarea name="detail3" class="form-control required" ><?php  echo $user->detail3;?></textarea>
                                         </div>
									</div>
									<?php if(!empty($tasker_vehicle)){  ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                                        <p><?php echo $this->lang->line('reliably_use'); ?> ?</p>
                                            <?php
											     if($user->vehicle_types!='')
												 {
													 $user_veh=explode(',',$user->vehicle_types); 
												 }
												 else
												 {
													 $user_veh=array();
												 }
											     
											foreach($tasker_vehicle->result() as $tvehicle){ ?>
											<div class="col-md-6 col-sm-6 col-xs-12 servicer_transport">
                                                <p class="custom_check"><input <?php if(in_array($tvehicle->id,$user_veh)){ echo 'checked';}?> type="checkbox" name="vehicle_type[]" value="<?php echo ($tvehicle->id);?>" id="veh<?php echo ($tvehicle->id);?>">
                                                        <label for="veh<?php echo ($tvehicle->id);?>"><?php echo ucfirst($tvehicle->vehicle_name);?></label></p>
                                                        <p><?php echo ucfirst($tvehicle->service);?></p>
                                                        <h6><?php echo ucfirst($tvehicle->description);?></h6>
                                            </div>
											<?php } ?>
											<label for="vehicle_type" generated="true" class="error" style=""></label>
                                    </div>
									<?php } ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 hear_about nopadd">
                                        <h4><?php echo $this->lang->line('hear_about'); ?> ?</h4>
                                        <ul class="list-unstyled" >
                                            <li><input type="radio" <?php if($user->hear_about=='Referred by a friend'){ echo 'checked';}?> name="hear_about" value="Referred by a friend" id="radio1"> <label for="radio1">Referred by a friend</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Facebook'){ echo 'checked';}?>  name="hear_about" value="Facebook" id="radio2"> <label for="radio2">Facebook</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Google search'){ echo 'checked';}?>  name="hear_about" value="Google search" id="radio3"> <label for="radio3">Google search</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Blog'){ echo 'checked';}?>  name="hear_about" value="Blog" id="radio4"> <label for="radio4">Blog</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Newspaper/Magazine'){ echo 'checked';}?>  name="hear_about" value="Newspaper/Magazine" id="radio5"> <label for="radio5">Newspaper/Magazine</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Bus/Subway ad'){ echo 'checked';}?>  name="hear_about" value="Bus/Subway ad" id="radio6"> <label for="radio6">Bus/Subway ad</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Trade school/college'){ echo 'checked';}?>  name="hear_about" value="Trade school/college" id="radio7"> <label for="radio7">Trade school/college</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Career center'){ echo 'checked';}?>  name="hear_about" value="Career center" id="radio8"> <label for="radio8">Career center</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Craigslist'){ echo 'checked';}?>  name="hear_about" value="Craigslist" id="radio9"> <label for="radio9">Craigslist</label></li>
                                            <li><input type="radio" <?php if($user->hear_about=='Other'){ echo 'checked';}?>  name="hear_about" value="Other" id="radio10"> <label for="radio10">Other</label></li>
                                        </ul>
                                        <label for="hear_about" generated="true" class="error how_did_error"></label>    
                                    </div>
                                    <div class="continue_service">
                                            <a href="javascript:void(0);" id="continue_service" class="theme_btn"><?php echo $this->lang->line('continue'); ?> </a>
                                    </div>
								</form>
                            </div>
                     </div>   
			</div>
			<div class="clearfix"></div>
			<link id="cal_style" rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/site/flatpickr.min.css">
			<script type="text/javascript" src="<?php echo base_url();?>js/site/jquery.form.js"></script>
			<script type="text/javascript" src="<?php echo base_url();?>js/site/flatpickr.js"></script>
			<script type="text/javascript" src="<?php echo base_url();?>js/site/highlight.pack.js"></script>
			<script>		
			/* $(document).ready(function(){
				$('#upload_img').on('change',function(){
					var user_id=$('#loginCheck').val();
					$('#tasker_profile_picture_form').ajaxForm({
						url:baseurl+'site/tasker/upload_profile_picture',
						dataType:"json",
						method:'post',
						data:{"user_id":user_id},
						beforeSubmit:function(e){
							$('#edit_pro_image').attr('src',baseurl+'images/site/sivaloader.gif');
						},
						success:function(e){
							if(e['status']==0)
								{
								swal('Error',e['message'],'error');
								}
								else
								{
								swal('Success',e['message'],'success');	
								}
								$('#edit_pro_image').attr('src',e['l_image']);
								$('.header_logo_ajax').attr('src',e['l_image']);
									
						},
						error:function(e){
						}
					}).submit();
				});
			}); */
			$('#continue_service').click(function(){ $('#tasker_profile_picture_form').submit();});
			
			flatpickr("#dob", { 
						altInput: true,
						altFormat: "Y-n-j"						
					});
			$('#zipcode_latlong').change(function(){
				$.ajax({
					url:baseurl+'site/tasker/get_latlong',
					dataType:'json',
					type:'post',
					data:{'zipcode':$(this).val(),'city':$('#city_latlong').val()},
					success:function(data){
						if(data['status']=='OK')
						{
							$('#lat').val(data['lat']);
						    $('#long').val(data['long']);
						}
						else
						{
							swal('Error','Please enter valid zipcode','error');
							$('#zipcode_latlong').val('');
						}
						
						
					}
				});
			});		
			</script>
				<!-- Image crop-->
<script src="<?php echo base_url();?>js/site/croppie.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/site/croppie.css">
<script src="<?php echo base_url();?>js/site/jquery.simplePopup.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/site/exif.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	var urlnew;
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
	
    viewport: {
        width: 200,
        height: 200,
        type: 'square'
    },
    boundary: {
        width: 200,
        height: 200
    }
});
$(document).on('click','.simplePopupClose,.simplePopupBackground',function(){
	$('#upload_img').val(null); 
});

$('#upload_img').on('change',function () {    
   $('#pop1').simplePopup();
	var reader = new FileReader(); 
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
			
    	}); 
    	 
		urlnew=e.target.result;		
    }
	
    reader.readAsDataURL(this.files[0]);
  
	
	
});

$('.upload-result').on('click', function (ev) { var imgn;
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
       $('#load').html($('#load').attr('data-loading-text'));
		$.ajax({
			url: "<?php echo base_url();?>site/user/upload_profile_picture",
			type: "POST",
			dataType:"json",
			data: {"image":resp},
			success: function (e) { 
				swal({
                            title: "Success", 
                            text: "Profile image uploaded successfully", 
                            type: "success"},
                            function() {
							imgn=e['l_image'];
							//console.log(imgn);
							$('#edit_pro_image').attr('src',imgn);
							$('#edit_pro_image_main').attr('src',imgn);
							$('.header_logo_ajax').attr('src',imgn);
					        $('.simplePopupClose').click();  
							$('#load').html('Upload');
                        });
						    
							
			}
		});
	});						});
  
});

</script>
<!-- Modal -->
<div id="pop1" class="simplePopup custom_picture">
		<div class="container1">
			<div class="panel panel-default">
			  <div class="panel-heading"><?php echo $this->lang->line('profile_image'); ?></div>
			  <div class="panel-body">

				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<div id="upload-demo"></div>
					</div>
					<div class="col-md-8 text-center">
						<button class="btn btn-success upload-result" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Uploading..."><?php echo $this->lang->line('upload'); ?></button>
					</div>	  		
				</div>
				

			  </div>
			</div>
		</div>
</div>

<!-- Image crop-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item('gmap_key');?>"> </script>
     <script>
      // This example creates circles on the map, representing populations in North
      // America.
	  $(document).ready(function(){ initMap();})	
      // First, create an object containing LatLng and population for each city.
	
      
      function initMap() {
        // Create the map.
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
          zoom: 10,
          center: {lat: 41.878, lng: -87.629},
          mapTypeId: 'terrain'
        });

        // Construct the circle for each value in citymap.
        // Note: We scale the area of the circle based on the population.
        
          // Add the circle for this city to the map.
          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: {lat: 41.878, lng: -87.629},
            radius: 10000
          });
       
      }
	
    </script>-->
	</section>
<?php $this->load->view('site/common/footer');?>