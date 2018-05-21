<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>css/admin/sweetalert.css" />
<div id="content">

<!--breadcrumbs-->
  <div id="content-header">
  <?php if($this->session->flashdata('error_type')!='' && $this->session->flashdata('alert_message')!='' ){?>
<div class="alert <?php if(($this->session->flashdata('error_type')=='error')){?>alert-danger<?php }else{ echo "alert-success";}?>">
			<a class="close" data-dismiss="alert" href="javascript:void(0);">×</a>

		<?php echo( $this->session->flashdata('alert_message'));?>
											<br>
</div>
	<?php } ?>	
    <div id="breadcrumb"> <a href="javascript:void(0);" title="<?php echo $heading;?>" class="tip-bottom"><i class="icon-home"></i> <?php echo $heading;?></a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
 <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5><?php echo $heading;?></h5>
          </div>
          <div class="widget-content nopadding">
			<table id="dynamic-table" class="table table-bordered data-table">
					  <thead>
						 <th><i class="icon_profile"></i> S.No</th>
						 <th><i class="icon_calendar"></i> Language Name</th>
						 <th style="width: 200px;"><i class="icon_mail_alt" ></i> Code</th>
						 <th class="sorting" style="width: 300px;"><i class="icon_pin_alt"></i> Status</th>
						 <th><i class="icon_cogs"></i> Action</th>
					  </thead>
					<tbody>
					  <?php $i = 1; foreach($language_list as $value){ ?>
					  <tr>
						 <td><?php echo $i;?></td>
						 <td><?php echo  $value->lang_name; ?></td>
						 <td><?php echo  $value->lang_code; ?></td>
						 <td><?php echo  $value->status; ?></td>
						 <td>
						  <div class="btn-group">
						      <?php if($prev==1 || (!empty($Language) && in_array('0',$Language))){?>
							  <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/language/language_view/<?php echo $value->lang_code; ?>">View<i class="icon_check_alt2"></i></a>
						      <?php } if($prev==1 || (!empty($Language) && in_array('2',$Language))){ ?>
							  <a class="btn btn-success" href="<?php echo base_url(); ?>admin/language/language_edit/<?php echo $value->id; ?>"> Edit<i class="fa fa-pencil" aria-hidden="true"></i></a>
							  <?php } if($prev==1 || (!empty($Currency) && in_array('3',$Currency))){?>
							  <a class="btn btn-danger" href="javascript:void(0)" onclick="language_delete('<?php echo $value->id; ?>')"> Delete<i class="icon_close_alt2"></i></a>
							  </div>
							  <?php }?>
						  </td>
					  </tr>
					  <?php $i++; } ?>
					                    
				   </tbody>
											</table>
		  </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?php echo base_url();?>js/admin/sweetalert.min.js"></script>  

<script>
var baseUrl = '<?php echo base_url();?>';
		function language_delete(cat_id){
			swal({
			  title: "Are you sure?",
			  text: "Your will not be able to recover this data again!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, delete it!",
			  closeOnConfirm: false
			},
			
			function(){
				exicute_delete(cat_id);
			});
		}

		function exicute_delete(cat_id){
			var filename = baseUrl+'admin/language/delete_language';

			var request  = $.ajax({
				url  : filename,
				type : "POST",
				data : {   
						cat_id   : cat_id, 
					},
				dataType : "html"
			});

			request.done(function(result){
				var output    = jQuery.parseJSON(result);
				if(output.flag == 1){
					swal("Saved!", "Successfully Deleted.!", "success");
					location.href = baseUrl+"admin/language";
				}			
			});
			
			request.fail(function(jqXHR,textStatus){
				alert(textStatus);
			});			
		}
	</script>

</div>
<?php $this->load->view('admin/common/footer');?>
