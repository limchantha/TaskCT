<?php 
	$lang_key 	= $this->session->userdata('pictuslang_key');
	$lang_data 	 = langdata();
	if(isset($lang_key)){
		$lang_key = $lang_key;
	}else{
		$lang_datas  = langdata_default();
		$lang_key 	 = $lang_datas[0]['lang_code'];
		$this->session->set_userdata('lang_key',$lang_key);
	}
	if(!empty($lang_key)){
			$this->lang->load($lang_key, $lang_key);
	}else{
		$this->lang->load('en', 'en');
	}
	?>

<footer>
		<div class="foot_base col-md-12 col-sm-12 col-xs-12 ">
			<div class="container_foot">
				<div class="col-md-12 col-sm-12 col-xs-12 nopadd">
					<div class="col-md-3 col-sm-3 col-xs-12 foot_logo_base">
						<div class="col-md-12 col-sm-12 col-xs-12 footer_ul socio_ul">
							<ul class="list-unstyled hidden-xs">
							    <?php if($logincheck==""){ ?>
								<li><a href="<?php echo base_url().'become-a-tasker';?>">Become Tasker</a></li>
								<?php }?>
								<li><a href="<?php echo base_url()?>page/how-it-work">How it works</a></li>
							</ul>
							<h6>Download our app</h6>
							<ul class="list-inline app_li">
								<li><a href="#"><i class="fa fa-apple fa-3x" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-android fa-3x" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-sm-3 col-xs-12 nopadd hidden-xs">
						<div class="col-md-12 col-sm-12 col-xs-12 footer_ul">
							<ul class="list-unstyled">
								<?php foreach($cms_row1->result() as $cm1){?>
								<li><a href="<?php echo base_url().'page/'.$cm1->url;?>"><?php echo ucfirst($cm1->title);?></a></li>
								<?php } ?>
								<li><a href="<?php echo base_url().'contact_us';?>">Contact Us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12 nopadd hidden-xs">
						<div class="col-md-12 col-sm-12 col-xs-12 footer_ul">
							<ul class="list-unstyled">
								<?php foreach($cms_row2->result() as $cm1){?>
								<li><a href="<?php echo base_url().'page/'.$cm1->url;?>"><?php echo ucfirst($cm1->title);?></a></li>
								<?php } ?>
								</ul>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12 nopadd">
						<div class="col-md-12 col-sm-12 col-xs-12 footer_ul">
							<ul class="list-inline pull-right foot_ul_custom_lang">							
							
							<li class="language dropup"><a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="dollar_icon"><i class="fa fa-<?php echo strtolower($currency_code); ?>" aria-hidden="true"></i></span><?php echo $currency_code; ?> <span class="pull-right">  <i class="fa fa-angle-up" aria-hidden="true"></i> </span></a>
								<ul class="dropdown-menu" aria-labelledby="dLabel1">
									<?php foreach($currency_lists->result() as $curr){ ?>
										<li><a href="<?php echo base_url().'site/currency/change_currency/'.$curr->currency_type; ?>"><?php echo $curr->currency_type; ?></a></li>
									<?php } ?>

								</ul>
							</li> 
							<li class="language dropup"><a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="globe_icon"><i class="fa fa-globe" aria-hidden="true"></i></span>    <?php echo $lang_key; ?> <span class="pull-right">  <i class="fa fa-angle-up" aria-hidden="true"></i> </span></a>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<?php foreach($lang_data as $val){ ?>
										<li><a href="<?php echo base_url().'site/language/lang_set/'.$val['lang_code']; ?>"><?php echo $val['lang_code']; ?></a></li>
									<?php } ?>

								</ul>
							</li>
							</ul>
						</div>
					</div>
					
					<div class="clearfix"></div>
					
				</div>
				
			</div>
			
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 copy_rights_custom_base">
				<div class="container_foot">
					<div class="col-md-6 col-sm-6 col-xs-12 nopadd">
						<img src="<?php echo base_url();?>images/site/logo/<?php echo $this->config->item('site_logo1');?>">
						<div class="copy_right "><p><?php echo $this->config->item('copy_right');?></p>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 nopadd">
						<div class="col-md-12 col-sm-12 col-xs-12 footer_ul custom_copy">
							<ul class="list-unstyled list-inline pull-right">
								<?php foreach($cms_row1->result() as $cm1){?>
								<li><a href="<?php echo base_url().'page/'.$cm1->url;?>"><?php echo ucfirst($cm1->title);?></a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
						
				</div>
				</div>
				</div>
	</footer>
<!--<script src="<?php echo base_url();?>js/site/jquery-3.1.1.min.js"></script>-->
<script src="<?php echo base_url();?>js/site/bootstrap.min.js"></script>

<script src="<?php echo base_url();?>js/site/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/site/validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/site/notification.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/site/sweetalert.min.js"></script>
<script>
var img_width =	$('.img_base img').width();
$('.black_layer').width(img_width);
var img_pos= $('.img_base img').offset();

	
	var window_width= $(window).width()
$(document).ready(function(){
    
        if(window_width < 768 )
		{
				$('.black_layer').offset({left:img_pos.left});
		}
   
});

function redirect_url(val)
{
	
	location.href=val.value;
}

<?php if($logincheck!=""){?>
		get_unread_inbox_icon();
setInterval(function(){ 	
		
		get_unread_inbox_icon();
		
		}, 8000);	
function get_unread_inbox_icon(){
				
			
			$.post('<?php echo base_url();?>site/user/unreadmessage_count',{},function success(data){ 
				if($.parseJSON(data).count>0){
				$('.notify_msg').css('display','inline-block'); 
				}
				else
				{
					$('.notify_msg').css('display','none'); 
				}					
			      
					
				
			})
		
		}		
<?php } ?>		
</script>

<!--notification -->
</body>

</html>