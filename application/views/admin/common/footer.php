<div class="">
<a href="#" class="scrollToTop" style="display: block;"><i class="icon-arrow-up" aria-hidden="true"></i></a></div>
<script>
$(document).ready(function(){
				//Check to see if the window is top if not then display button
				$(window).scroll(function(){
					if ($(this).scrollTop() > 100) {
						$('.scrollToTop').fadeIn();
					} else {
						$('.scrollToTop').fadeOut();
					}
				});

				//Click event to scroll to top
				$('.scrollToTop').click(function(){
					$('html, body').animate({scrollTop : 0},800);
					return false;
				});
			});
			/* $(window).load(function() {
				$("html, body").animate({ scrollTop: $(document).height() }, 500);
			}); */

</script>
<style>
.scrollToTop {
    text-align: center;
    background: whiteSmoke;
    font-weight: bold;
    text-decoration: none;
    position: fixed;
    right: 40px;
    display: none;
    color: #fff;
    padding: 8px 15px;
    bottom: 125px;
    right: 3px;
    position: fixed;
    background: #ccc;
}
</style>
<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> 2017 &copy; <?php echo $this->config->item('site_name');?> . </div>
</div>

<!--end-Footer-part-->
<script>
		var baseurl="<?php echo base_url();?>"; 
	</script>	
<script src="<?php echo base_url();?>js/admin/admin_validation.js"></script>  
<script src="<?php echo base_url();?>js/admin/jquery.validate.js"></script> 
<script src="<?php echo base_url();?>js/admin/excanvas.min.js"></script> 
<script src="<?php echo base_url();?>js/admin/jquery.ui.custom.js"></script> 
<script src="<?php echo base_url();?>js/admin/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>js/admin/jquery.flot.min.js"></script> 
<script src="<?php echo base_url();?>js/admin/jquery.flot.pie.min.js"></script> 
<script src="<?php echo base_url();?>js/admin/jquery.flot.resize.min.js"></script> 
<script src="<?php echo base_url();?>js/admin/jquery.peity.min.js"></script> 
<script src="<?php echo base_url();?>js/admin/main.js"></script> 
<script src="<?php echo base_url();?>js/admin/form_validation.js"></script> 
<script src="<?php echo base_url();?>js/admin/jquery.wizard.js"></script> 
<script src="<?php echo base_url();?>js/admin/jquery.uniform.js"></script> 
<script src="<?php echo base_url();?>js/admin/select2.min.js"></script> 
<script src="<?php echo base_url();?>js/admin/popover.js"></script> 
<script src="<?php echo base_url();?>js/admin/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url();?>js/admin/tables.js"></script> 
<script src="<?php echo base_url();?>js/admin/dash_graph.js"></script> 
</script>
</body>
</html>