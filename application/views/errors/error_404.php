<style>
.class_404{
min-height:500px!important;	

}
.class_404 img{
padding-top:80px;
}	
</style>
<div class="container text-center class_404">
<img src="<?php echo base_url();?>images/404.png"/>
</div>
<script>
$(document).ready(function(){
	var total_height=($(window).height());
var tot=($('footer').height())+($('header').height());
var main=total_height-tot; 
$('.class_404').prop('style','min-height:'+main+'px !important');
});

</script>
