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
      <div class="span8">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>Top Taskers</h5>
          </div>
          <div class="widget-content">
           <div id="pie_chart" style="height:350px;" ></div>
		   </div>
        </div>
      </div>
      
      <div class="span4">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>Taskers details</h5>
          </div>
          <div class="widget-box widget-plain" id="dashboard_user_chart">
      <div class="center">
        <ul class="stat-boxes2">
          <li>
            <div class="left peity_bar_bad"><span><span style="display: none;"><span style="display: none;"><span style="display: none;"><span style="display: none;">3,5,6,16,8,10,6</span><canvas width="50" height="24"></canvas></span>
              <canvas width="50" height="24"></canvas>
              </span><canvas width="50" height="24"></canvas></span><canvas width="50" height="24"></canvas></span></div>
            <div class="right"> <strong><?php echo $new_user->num_rows();?></strong> New Taskers</div>
          </li>
          <li>
            <div class="left peity_line_good"><span><span style="display: none;"><span style="display: none;"><span style="display: none;"><span style="display: none;">12,6,9,23,14,10,17</span><canvas width="50" height="24"></canvas></span>
              <canvas width="50" height="24"></canvas>
              </span><canvas width="50" height="24"></canvas></span><canvas width="50" height="24"></canvas></span></div>
            <div class="right"> <strong><?php echo $active_user->num_rows();?></strong> Active Taskers </div>
          </li>
          <li>
            <div class="left peity_bar_good"><span><span style="display: none;">12,6,9,23,14,10,13</span><canvas width="50" height="24"></canvas></span></div>
            <div class="right"> <strong><?php echo $user->num_rows();?></strong> Total Taskers</div>
          </li>
        </ul>
      </div>
    </div>
        </div>
      </div>
    </div>
		<div class="row-fluid">
		 <div class="span12">
				<div class="widget-box">
				  <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
					<h5>Category wise taskers</h5>
				  </div>
				  <div class="widget-content">
				   <div id="top_x_div" style="height:350px;" ></div>
				   </div>
				</div>
			  </div>	
		</div>	  
  </div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
       google.charts.load("current", {packages:["bar"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Completed Tasks'],
          <?php if(!empty($top_tasker) && count($top_tasker->result())>0){ foreach($top_tasker->result() as $ttsker){ if($ttsker->first_name!=""){ ?>
			['<?php echo $ttsker->first_name;?>',    <?php echo $ttsker->donetask_count;?>],  
		  <?php  }}} else { ?>
		  ['No Task ',     0]
         <?php } ?> 
        ]);

       var options = {
          title: 'Top Taskers',
          width: "100%",
          legend: { position: 'none' },
		   colors: ['#dc3912'],
          chart: { title: 'Top Taskers',
                   subtitle: 'popularity by completed tasks' },
          bars: 'vertical', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'bottom', label: 'Taskers'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('pie_chart'));
        chart.draw(data, options);
      }
	  
	  google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Opening Move', 'Percentage'],
           <?php if(!empty($tasker_cat_based) && count($tasker_cat_based->result())>0){ foreach($tasker_cat_based->result() as $cat){ if($cat->task_name!=""){ ?>
			['<?php echo $cat->task_name;?>',    <?php echo $cat->countval;?>],  
		   <?php  }}} else { ?>
		  ['No cat',     0]
         <?php } ?> 
        ]);

        var options = {
          title: 'Category wise taskers',
          width: 900,
          legend: { position: 'none' },
		   colors: ['#dc3912'],
          chart: { title: 'Tasker based on Category',
                   subtitle: 'popularity by percentage' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'bottom', label: 'Percentage'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
      
    </script>
</div>
<?php $this->load->view('admin/common/footer');?>
