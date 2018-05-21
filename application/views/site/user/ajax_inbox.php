<ul class="list-unstyled message_converstion_list" role="tablist">
	<?php if($message_list->num_rows()>0){ $i=1;
		  foreach($message_list->result() as $msg){	
		 
		?>				
	   <li class="msg_list" data-id="<?php echo $msg->booking_id;?>">
			
					<div class="msg_inner_conversation<?php if($msg->viewer_id!=$id){echo "msg_left";}else{ echo "msg_right";}?> ">
						<div class="<?php if($msg->viewer_id!=$id){echo "msg_left";}else{ echo "msg_right";}?>"> <p> <?php echo ucfirst($msg->message);?> </p> </div>
					</div>	
			
		</li>
		<?php $i++; } } else { echo "No message found in inbox...";}?>
</ul>
<script>
$(document).on('click','.msg_info',function(){  
			$('#chat_head_image').attr('src',$(this).attr('data-image')); 
            $('#chat_head_name').text($(this).attr('data-name')); });
</script>	