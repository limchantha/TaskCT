<?php $this->load->view('admin/common/header.php'); ?>
<?php $this->load->view('admin/common/sidebar.php'); ?>
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
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>Total Users chart</h5>
          </div>
          <div class="widget-content">
           <div id="pie_chart" style="height:350px;" ></div>
		   </div>
        </div>
      </div>
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>Users details</h5>
          </div>
          <div class="widget-box widget-plain" id="dashboard_user_chart">
      <div class="center">
        <ul class="stat-boxes2">
          <li>
            <div class="left peity_bar_bad"><span><span style="display: none;"><span style="display: none;"><span style="display: none;"><span style="display: none;">3,5,6,16,8,10,6</span><canvas width="50" height="24"></canvas></span>
              <canvas width="50" height="24"></canvas>
              </span><canvas width="50" height="24"></canvas></span><canvas width="50" height="24"></canvas></span></div>
            <div class="right"> <strong><?php echo $new_user->num_rows();?></strong> New Users</div>
          </li>
          <li>
            <div class="left peity_line_good"><span><span style="display: none;"><span style="display: none;"><span style="display: none;"><span style="display: none;">12,6,9,23,14,10,17</span><canvas width="50" height="24"></canvas></span>
              <canvas width="50" height="24"></canvas>
              </span><canvas width="50" height="24"></canvas></span><canvas width="50" height="24"></canvas></span></div>
            <div class="right"> <strong><?php echo $active_user->num_rows();?></strong> Active Users </div>
          </li>
          <li>
            <div class="left peity_bar_good"><span><span style="display: none;">12,6,9,23,14,10,13</span><canvas width="50" height="24"></canvas></span></div>
            <div class="right"> <strong><?php echo $user->num_rows();?></strong> Total Users</div>
          </li>
        </ul>
      </div>
    </div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript" src="<?php echo base_url();?>js/admin/google_graph.js"></script>
    <script type="text/javascript">
       google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php if(!empty($user) && count($user->result())>0){ foreach($user->result() as $use){ ?>
			['<?php echo $use->first_name;?>',     1],  
		  <?php  }} else { ?>
		  ['User',     100]
         <?php } ?> 
        ]);

        var options = {
          title: 'Users details',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
        chart.draw(data, options);
      }
      
    </script>
</div>
<?php $this->load->view('admin/common/footer');?>
