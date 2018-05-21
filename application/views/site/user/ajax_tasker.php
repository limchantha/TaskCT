<?php 
if($tasker_details->num_rows()>0){
foreach($tasker_details->result() as $tasker){
									if($tasker->photo!='')
									{
										$pro_pic=base_url().'images/site/profile/'.$tasker->photo;
									}
									else
									{
										$pro_pic=base_url().'images/site/profile/big_avatar.png';
									}
									$rate=$tasker->rate;
								?>
                                    <div class="col-md-12 col-xs-12 col-sm-12 compare_serv_inner">
                                            <div class="col-md-4 col-sm-4 col-xs-12 compare_img">
                                                    <img src="<?php echo $pro_pic;?>">
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-12 compare_cont">
                                                    <h2><?php echo ucfirst($tasker->first_name);?></h2>
                                                    <span class="review_compare">
                                                        <i class="fa fa-star<?php if($rate<1){echo '-o';}?>" aria-hidden="true"></i>
                                                        <i class="fa fa-star<?php if($rate<2){echo '-o';}?>" aria-hidden="true"></i>
                                                        <i class="fa fa-star<?php if($rate<3){echo '-o';}?>" aria-hidden="true"></i>
                                                        <i class="fa fa-star<?php if($rate<4){echo '-o';}?>" aria-hidden="true"></i>
                                                        <i class="fa fa-star<?php if($rate<5){echo '-o';}?>" aria-hidden="true"></i>
                                                    </span>
                                                    <h5><?php echo $currency_symbol.' '.round($currency_rate*$tasker->price);?>/hr</h5>
                                                    <div class="desc_servicer">
                                                     <p><?php if(strlen($tasker->tasker_description)<115){ echo $tasker->tasker_description;}else {echo substr($tasker->tasker_description,0,115).'...';} ?></p>
                                                    </div>
                                                    <ul class="list-inline">
                                                            <li ><a href="javascript:void(0);" id="ajax_fill_result_<?php echo $tasker->user_id;?>" onclick="book_tasker(<?php echo $tasker->user_id;?>);" class="theme_btn">Select & Continue</a></li>
                                                            <li><a href="<?php echo base_url();?>tasker/<?php echo $tasker->user_id;?>" class="normal_btn profile_viewclick" >View Profile</a></li>
                                                    </ul>
													<?php if($tasker->id_verified=='Yes'){?>	
												   <p class="verified_comp"><span><i class="fa fa-check" aria-hidden="true"></i></span>ID Verified</p>
													<?php }else {?>
                                                    <p class="not_verified_comp"><span><i class="fa fa-remove" aria-hidden="true"></i></span>ID Not Verified</p>
													<?php }  ?>
											</div>
                                    </div>
<?php } }else { echo '<b>No taskers available.</b>';} ?>					    