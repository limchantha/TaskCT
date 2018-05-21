<?php #$this->load->view('site/common/header');	?>
<script src="<?php echo base_url();?>js/site/validate.js"></script>
	<section>
		<div class="clearfix"></div>
			<div class="servicer_detail_base edit_servicer">
                     <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                            <div class="service_detail_inner servicer_detail_2nd_step">
                                <div class="col-md-12 col-sm-12 col-xs-12 service_2_content service_4_step nopadd">
					   
                                            <div class="col-md-12 col-sm-12 col-xs-12 service_4_step_inner  nopadd">
												
												  
                                                  
                                                    <div class="col-md-12 col-sm-12 col-xs-12 gift_card">
                                                     <?php if($gift_card_list->num_rows()>0){ foreach($gift_card_list->result() as $gf){?>
                                                    <div class="gift_card_inner" >
                                                          <a href="javascript:void(0);"class="" onclick="load_gift_pay_form(<?php echo $gf->id;?>);">  <h5><?php echo $gf->name;?></h5>
                                                           <h6>  Price: <?php echo $currency_symbol; echo $currency_rate * $gf->price;?> </h6>
                                                           </a>
                                                    </div>
													 <?php } } else { echo "<p>No gift card available.</p>";} ?>
                                                    </div>
												  
                                                    												
                                            </div>
                                            
                                    </div>
                                    
                                
                                 
                            </div>
                     </div>   
			</div>
			<div class="clearfix"></div>

			<script>
			
        
 		function load_gift_pay_form(card_id)
		{
			$.ajax({
						url:baseurl+'site/user/load_card_payment/'+card_id,
						dataType:'html',
						type:'post',
						beforeSend:function(){ 
						$('#gift_card').html('');
						$('#gift_card').html('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
					   },
						success:function(data){ 
							$('#gift_card').html('');	
							$('#gift_card').html(data);	
							
						}
					});
		}
		
		
		</script>
	</section>
<?php #$this->load->view('site/common/footer');?>