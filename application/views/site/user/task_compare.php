<?php $this->load->view('site/common/header');	?>
	<link href="<?php echo base_url();?>css/site/owl.carousel.min.css" rel="stylesheet">
	<section>
		<div class="clearfix"></div>
                <div class="service_info_base">
                        <div class="service_info_head">
                            <div class="container">
                                <ul class="list-inline">
					<li class="service_detail completed_step mob_res_none"><p>Service Details </p></li>
					<li class="compare_ser active"> <p>Compare Service and Price </p></li>
					<li class="confirm_hire mob_res_none"> <p>Confirm & Hire </p></li>
                                </ul>
                            </div>
                    </div>
                </div>
            <div class="compare_base">
                <div class="container">
                    <h1><?php echo ucfirst($task_category->row()->task_name);?><span>(<?php echo ucfirst($subcat_name);?>)</span></h1>
					
					<?php
						$curdate=date('Y-m-d');		
						$nextyeardate=date('Y-m-d', strtotime("+365 day"));
						$i=1;
						$dates = array (
									$curdate 
							);
							while ( end ( $dates ) < $nextyeardate ) {
								$dates [] = date ( 'Y-m-d', strtotime ( end ( $dates ) . ' +1 day' ) );
							}
							?>
                    <div class="compare_inner col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-4 col-xs-12 sorted_by">
								<form name="search_form" id="search_form" method="post">
                                <div class="sorted_by_inner">
                                        <div class="recommend">
                                        <h3>sorted by</h3>
                                        <select class="form-control" id="sorting" onchange="init_search();">
										<option value="price_low">Price low to high</option>
										<option value="price_high">Price high to low</option>
										<option value="most_review">Most Reviews</option>
										<option value="highest_ratings">Highest Ratings</option>
										</select>
                                        </div>
                                        <h3>task date & time</h3>
                                        <div class="date_carousel">
                                        
                                            <div class="owl-carousel owl-theme">
											       <?php
													
												   foreach($dates as $dt){?>
												   <div class="item <?php if($dt==$curdate) echo 'active';?>" data-date="<?php echo date('Y-m-d',strtotime($dt));?>"><h4><?php echo date('D',strtotime($dt));?></h4><p> <?php echo date('M',strtotime($dt));?>  <?php echo date('d',strtotime($dt));?></p></div>  
												   <?php } ?>	
                                            </div>
                                        </div>
                                        <div class="flexible_am">
											<input type="hidden" id="task_date" value="<?php echo date('Y-m-d');?>"/>
                                            <select class="form-control" id="task_time" onchange="init_search();">											
												<option value="0">I'M FLEXIBLE</option>
												<option value="1">MORNING 8am - 12pm</option>
												<option value="2">AFTERNOON 12pm - 4pm</option>
												<option value="3">EVENING 4pm - 8pm</option>
											</select>
                                        </div>
                                </div>
								</form>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12 compare_servicer" id="ajax_fill_result">
                                      
                           
							</div>		
                          </div>
                </div>
            </div>
		<div class="clearfix"></div>
	</section>
<script src="<?php echo base_url();?>js/site/owl.carousel.min.js"></script>

<script>
$(document).ready(function(){
	init_search();
});
$('.item').click(function(){
	$('#task_date').val($(this).attr('data-date'));
	$('.item').removeClass('active');
	$(this).addClass('active');
	init_search();
});
function init_search()
{
	       
	        var task_date=$('#task_date').val();
			var task_time=$('#task_time').val();
			var sorting=$('#sorting').val();
			var distance=$('#distance').val();
			save_date_time();
			$.ajax({
					url:baseurl+'site/user/fetch_tasker_details',
					dataType:'html',
					type:'post',
					data:{'task_date':task_date,'task_time':task_time,'distance':distance,'sorting':sorting},
					beforeSend:function(){ 
					$('#ajax_fill_result').html('');
					$('#ajax_fill_result').append('<div class="col-md-12 col-sm-12 col-xs-12 text-center"><img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;"></div>');
                   },
					success:function(data){ 
						$('#ajax_fill_result').html('');	
						$('#ajax_fill_result').append(data);	
						
					}
				});
}

function book_tasker(tasker_id)
{           $(window).unbind('beforeunload');
			<?php if($logincheck==''){?>
			window.location.href=baseurl+'user_login';
			<?php } ?>
			var task_date=$('#task_date').val();
			var task_time=$('#task_time').val();
			
			$.ajax({
					url:baseurl+'site/user/book_tasker',
					dataType:'html',
					type:'post',
					data:{'tasker_id':tasker_id,'task_date':task_date,'task_time':task_time},
					beforeSend:function(){ 
					$('#ajax_fill_result_'+tasker_id).html('<img src="<?php echo base_url();?>images/site/sivaloader.gif" style="margin:0 auto;width:25;height:25px;">');
                   },
					success:function(data){ 
						
						window.location.href='<?php echo base_url();?>booking_confirm';	
						
					}
				});
}


function save_date_time()
{           
			var task_date=$('#task_date').val();
			var task_time=$('#task_time').val();
			
			$.ajax({
					url:baseurl+'site/user/save_date_time',
					dataType:'html',
					type:'post',
					data:{'task_date':task_date,'task_time':task_time},
					
					success:function(data){ 
						
						//window.location.href='<?php echo base_url();?>booking_confirm';	
						
					}
				});
}

//dropdown
  $('.dropdown').on('show.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  });

  $('.dropdown').on('hide.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  });

</script>
<script>
// for this page only
$('.head_base').css('margin-bottom','1px');
</script>
<script>
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    navText:['<i class="fa fa-caret-left" aria-hidden="true"></i>','<i class="fa fa-caret-right" aria-hidden="true"></i>'],
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
})
$(window).on("beforeunload", function() {
            return "Are you sure? You didn't finish the booking tasker!";
        });	

  $(document).on('click','.profile_viewclick',function(){

  	$(window).unbind('beforeunload');
  });

</script>
	
<?php $this->load->view('site/common/footer');?>