<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('mobile_model');
		$this->load->model('user_model');
		$this->load->model('mail_model');
		$headers = apache_request_headers(); 
		if(isset($headers['app_id']) && $headers['app_id']!="#pictus_service_rabbit_01#")
		{
			echo json_encode(array('status'=>0,'message'=>'Authentication failed')); die;
		}
		
    }
	
	public function user_signup()
	{   
		$email=$this->input->post('email');
		if($email!="" || $_POST['password']!=""){
		$t=count($this->mobile_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
				$_POST['password']=md5($_POST['password']); 
				$headers = apache_response_headers();  $check=json_encode($headers);
				$save_array=array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'email'=>$_POST['email'],'password'=>$_POST['password'],'phone'=>$_POST['phone'],'device_type'=>$headers['device_type'],'device_id'=>$headers['device_id'],'zipcode'=>$_POST['zipcode'],'detail3'=>$check);
				$t=$this->mobile_model->simple_insert(USERS,$save_array);
       		    $checkUser = $this->mobile_model->get_all_details(USERS, array('email'=>$email));
			    $userdata = array (
						'user_id' => $checkUser->row ()->id,
						'first_name' => $checkUser->row ()->first_name,
						'last_name' => $checkUser->row ()->last_name,
						'user_id' => $checkUser->row ()->id,
						'pro_pic'=> base_url().'images/site/profile/big_avatar.png',
						'email' => $checkUser->row ()->email
						
				);
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'last_login_date' => mdate ( $datestring, $time ),
						'last_login_ip' => $this->input->ip_address ()
				);
				$condition = array (
						'id' => $checkUser->row ()->id
				);
				$this->mobile_model->update_details ( USERS, $newdata, $condition );
			$t1['message'] = 'Account Created successfully.';	
			$t1['status'] =1;
			$t1['result'] =$userdata;
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Email already exsist.';
		 	
		}
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Please fill all the fields.';
		}
		
	    echo json_encode($t1);
    }
	
	
	
	public function user_login_process() {

		$email = $this->input->post ( 'login_email' );
		$pwd = md5 ( $this->input->post ( 'login_password' ) );
		$condition = array (
					'email' => $email,
					'password' => $pwd,
					'status' => 'Active',
					'group' => '0',
			);
		$checkUser = $this->user_model->get_all_details ( USERS, $condition );
		if ($checkUser->num_rows () == '1') {
				$userdata = array (
						'user_id' => $checkUser->row ()->id,
						'first_name' => $checkUser->row ()->first_name,
						'last_name' => $checkUser->row ()->last_name,
						'user_id' => $checkUser->row ()->id,
						'pro_pic'=> base_url().'images/site/profile/big_avatar.png',
						'email' => $checkUser->row ()->email,
						'group'=> $checkUser->row ()->group
				);
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'last_login_date' => mdate ( $datestring, $time ),
						'last_login_ip' => $this->input->ip_address () );
				$condition = array (
						'id' => $checkUser->row ()->id
				);
				$this->user_model->update_details ( USERS, $newdata, $condition );
				$t1['status'] = 1;
				$t1['result'] =$userdata;
				$t1['message'] = 'Logged in successfully.';	
				
			}
			else
			{
			$condition = array ('email' => $email,'status'=>'Inactive');
			$checkUser1 = $this->user_model->get_all_details ( USERS, $condition );
			if ($checkUser1->num_rows () == '1') 
			{
				$t1['message'] = 'Your Account is Inactive';
				$t1['status'] = 0;
			}
			else  
			{
				$t1['message'] = 'Invalid login details';
				$t1['status'] = 0;	
			}
			}			

		
		echo json_encode ( $t1 );
	}
	
	public function user_profile_info()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
				$userdetail=$checkUser->row();
				if($userdetail->photo!='')
				{
					$pro_pic=base_url().'images/site/profile/'.$userdetail->photo;
				}
				else
				{
					$pro_pic=base_url().'images/site/profile/big_avatar.png';
				}
				$data['user_details']=array('first_name'=>$userdetail->first_name,'last_name'=>$userdetail->last_name,'zipcode'=>$userdetail->zipcode,'pro_pic'=>$pro_pic,'user_type'=>$userdetail->group,'phone'=>$userdetail->phone);
				$data['status']=1;
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function upload_profile_picture(){
	            $email=$_POST['email'];	       
	            $first_name=$_POST['first_name'];	       
	            $last_name=$_POST['last_name'];	       
	            $phone=$_POST['phone'];	       
	            $zipcode=$_POST['zipcode'];	       
				$config['overwrite'] = FALSE;
				$config['remove_spaces'] = TRUE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['max_width']  = '1600';
				$config['max_height']  = '1600';
				$config['upload_path'] = './images/site/profile';
				$this->load->library('upload', $config);
				$dataarray1 = array('first_name'=>$first_name,'last_name'=>$last_name,'phone'=>$phone,'zipcode'=>$zipcode,);
			    $this->user_model->update_details(USERS,$dataarray1,array('email'=>$email));
				$t1['status']=1;
				$t1['message']='Your info saved successfully...';
				if($this->upload->do_upload('upload_profile_picture')){
					$imgDetailsd = $this->upload->data();
					$dataarray = array('photo'=>$imgDetailsd['file_name']);
					$this->user_model->update_details(USERS,$dataarray,array('email'=>$email));
					$t1['status']=1;
					$t1['message']='Profile picture changed successfully...';
					
				}
				
				$user=$this->user_model->get_all_details(USERS,array('email'=>$email))->row(); 
				$img=$user->photo!=''?$user->photo:'avatar.png';
				$userdata = array (
						'user_id' => $user->id,
						'first_name' => $user->first_name,
						'last_name' => $user->last_name,
						'pro_pic'=> base_url().'images/site/profile/'.$img,
						'email' => $user->email,
						'phone' => $user->phone,
						'zipcode' => $user->zipcode,
						'group'=> $user->group
				);
				if($user->group=="1"){
				$tasker_step=0;
				if($user->tasker_step2=="0")
				{
					$tasker_step=1;
				}
				else if($user->tasker_step3=="0")
				{
					$tasker_step=2;
				}
				else if($user->tasker_step4=="0")
				{
					$tasker_step=3;
				}
				else
				{
					$tasker_step=0;
				}
				$userdata = array (
						'user_id' => $user->id,
						'first_name' => $user->first_name,
						'last_name' => $user->last_name,
						'pro_pic'=> base_url().'images/site/profile/'.$img,
						'email' => $user->email,
						'group'=> $user->group,
						'tasker_step'=>$tasker_step
				);
				}
				
				$t1['pro_pic']=base_url().'images/site/profile/'.$img;
				$t1['result'] =$userdata;
			
			echo json_encode ( $t1 );
	
	}

	public function available_balance()
	{
		    $email=$_POST['email'];	
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {	
				$this->data['available_bal']=$this->mobile_model->load_available_balance($checkUser->row()->id);
				$tot=$t=0;
				if(!empty($this->data['available_bal']->result())){
				foreach($this->data['available_bal']->result() as $av)
				{
					$tot+=$av->total_amount-$av->service_fee;
				}
				$t=$tot-($this->data['available_bal']->row()->paid_amount);
				}
				$t1['status']=1;
				$t1['currency_symbol']='$';
				$t1['total_available_balance']='$'.$t;
				
			}
			else
			{
				$t1['status']=0;
				$t1['message']="User not available";	
			}				
			echo json_encode ( $t1 );
		
	}
	
	public function change_user_password()
	{   
		$email=$_POST['email'];	
		$old_password=md5($this->input->post('old_password'));
		$new_password=md5($this->input->post('new_password'));
		$confirm_password=md5($this->input->post('confirm_password'));
		$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
		if ($checkUser->num_rows () == '1') {
			if($checkUser->row()->password==$old_password)
			{
				if($new_password==$confirm_password)
				{		
				$this->user_model->update_details(USERS,array('password'=>$new_password),array('email'=>$email)); 
				$ret['status']=1;
				$ret['message']='Password changed successfully...';	
				}
				else
				{
				$ret['status']=0;
				$ret['message']='Confirm password is wrong';		
				}
			}
			else
			{
			$ret['status']=0;
			$ret['message']='Current password is wrong...';		
			}
		}
		echo json_encode($ret);	    

	}
	
	public function deactivate_myaccount()
	{
			$email=$_POST['email'];	
			$this->user_model->update_details(USERS,array('status'=>'Inactive'),array('email'=>$email));
			$ret['status']=1;
			$ret['message']='Your account deactivated successfully...';	
			echo json_encode($ret);	 
	}
	
	public function save_notification()
	{   
			$email=$_POST['email'];	
		    $notify_type=$_POST['notify_type']; 
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			$id=$checkUser->row()->id;
			if($notify_type=="getinfo"){
				$ret['status']=1;
			    $ret['notification']=array('task_sms'=>$checkUser->row()->task_sms,'task_email'=>$checkUser->row()->task_email);
			}
			else{
				$dataarray=array();
				$dataarray['task_sms']=$_POST['task_sms'];	
				$dataarray['task_email']=$_POST['task_email'];					
				$this->user_model->update_details(USERS,$dataarray,array('id'=>$id));		
				$ret['status']=1;
				$ret['message']='Notification saved successfully...';
			}
	
		
		echo json_encode($ret);	
	    

	}
	
	public function transaction_list()
	{
		    $perpage=5;
			$page=1;
		    $email=$_POST['email'];	
		    $page=$_POST['page'];	
		    $checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			$id=$checkUser->row()->id;
			if($page>0){
			$pageLimitStart=($page*$perpage)-$perpage;			 
			}else{
				$page=1;
				$pageLimitStart=0;				
			}
			$usertrans=$this->mobile_model->export_transaction_list($id,$pageLimitStart,$perpage); 
			$transaction_list=array();
			if($usertrans->num_rows()>0){
			foreach($usertrans->result() as $trans)
			{
				if($trans->photo!='')
				{
					$pro_pic=base_url().'images/site/profile/'.$trans->photo;
				}
				else
				{
					$pro_pic=base_url().'images/site/profile/big_avatar.png';
				}
				if($trans->booking_time==0)
				{
					$btime="I'M FLEXIBLE";
				}
				else if($trans->booking_time==1)
				{
					$btime='MORNING 8am - 12pm';
				}
				else if($trans->booking_time==2)
				{
					$btime='AFTERNOON 12pm - 4pm';
				}
				else if($trans->booking_time==3)
				{
					$btime='EVENING 4pm - 8pm';
				}
				$transaction_list[]=array('takser_name'=>$trans->Tasker_name,'task_name'=>$trans->Task_name,'address'=>$trans->address,'pro_pic'=>$pro_pic,'booking_date'=>$trans->booking_date,'booking_day'=>date('d',strtotime($trans->booking_date)),'booking_month'=>date('M',strtotime($trans->booking_date)),'booking_time'=>$btime,'vehicle'=>$trans->veh_name,'currency_symbol'=>'$','paid_amount'=>$trans->Paid_amount);
			}
			$ret['status']=1;
		    $ret['export_result']=$transaction_list;
			}
			else
			{
			$ret['status']=0;	
			$ret['message']='No transaction found.';
			}
			echo json_encode($ret);	
	}
	
	public function home_page()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
				$get_main_category = $this->user_model->get_all_details ( TASKER_CATEGORY, array ('status' => 'Active'));
				$main_cat_list=array();
				if($get_main_category->num_rows()>0)
				{
					foreach($get_main_category->result() as $mcat){
						if($mcat->icon=="")
						{
							$cat_icon=base_url().'images/site/category/mobile/icon.png';
						}
						else
						{
							$cat_icon=base_url().'images/site/category/mobile/'.$mcat->icon;
						}
						$subcat_list=$this->user_model->get_all_details ( TASKER_SUB_CATEGORY, array ('status' => 'Active','cat_id'=>$mcat->id));
						$subcat_array=array();
							if($subcat_list->num_rows()>0)
							{
								foreach($subcat_list->result() as $scat){
									if($scat->image=="")
									{
										$subcat_image=base_url().'images/site/category/icon.png';
									}
									else
									{
										$subcat_image=base_url().'images/site/category/'.$scat->image;
									}
									$subcat_array[]=array('subcat_id'=>$scat->id,'subcat_name'=>$scat->subcat_name,'subcat_image'=>$subcat_image,'avg_price'=>'$'.$mcat->avg_price);
								}
							}
						
					
					$main_cat_list[]=array('cat_id'=>$mcat->id,'cat_name'=>$mcat->task_name,'cat_title'=>$mcat->task_title,'cat_icon'=>$cat_icon,'subcat_list'=>$subcat_array);
					}
					$featured=$this->mobile_model->get_featured_category();
					$featured_array=array();
					foreach($featured->result() as $fet)
					{
						if($fet->subcat_image=="")
									{
							$fsubcat_image=base_url().'images/site/category/icon.png';
						}
						else
						{
							$fsubcat_image=base_url().'images/site/category/'.$fet->subcat_image;
						}
						$featured_array[]=array('cat_id'=>$fet->id,'subcat_id'=>$fet->subcat_id,'subcat_name'=>$fet->subcat_name,'subcat_image'=>$fsubcat_image,'currency_symbol'=>'$','avg_price'=>$fet->avg_price);
					}
					
				$data['status']=1;
				$data['main_cat_list']=$main_cat_list;
				$data['featured_list']=$featured_array;
				}			
				else{
				$data['status']=0;
				$data['message']="Category Not available";	
				}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function booking_step1()
	{		
			$email=$_POST['email'];
			$cat_id=$_POST['cat_id'];
			$subcat_id=$_POST['subcat_id'];			
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
				$cat_detail=$this->mobile_model->get_all_details(TASKER_CATEGORY,array('id'=>$cat_id));
				$subcat_detail=$this->mobile_model->get_all_details(TASKER_SUB_CATEGORY,array('cat_id'=>$cat_id));
				if($cat_detail->num_rows()==1)
				{   $vehicle_array=array();
				    $subcat_array=array();
				    $timing_array=array();
					if($cat_detail->row()->vehicle_required==1)
					{
						$vehicle_list=$this->user_model->get_all_details(TASKER_VEHICLE, array('status'=>'Active'));
						foreach($vehicle_list->result() as $veh_res){
						$vehicle_array[$veh_res->id]=$veh_res->vehicle_name;
						}
					}
					foreach($subcat_detail->result() as $subcat_list){
						$subcat_array[$subcat_list->id]=$subcat_list->subcat_name;
						}
					$timing_array=array('1'=>'MORNING 8am - 12pm','0'=>"I'M FLEXIBLE",'2'=>'AFTERNOON 12pm - 4pm','3'=>'EVENING 4pm - 8pm');	
					$data['dropdown_data']=array('subcat_list'=>$subcat_array,'vehicle_list'=>$vehicle_array,'timing_list'=>$timing_array);
					$data['status']=1;
				}
				else{
					$data['status']=0;
				    $data['message']="Category not available";
				}
				
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	public function booking_step1_new()
	{		
			$email=$_POST['email'];
			$cat_id=$_POST['cat_id'];
			$subcat_id=$_POST['subcat_id'];			
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
				$cat_detail=$this->mobile_model->get_all_details(TASKER_CATEGORY,array('id'=>$cat_id));
				$subcat_detail=$this->mobile_model->get_all_details(TASKER_SUB_CATEGORY,array('cat_id'=>$cat_id));
				if($cat_detail->num_rows()==1)
				{   $vehicle_array=array();
				    $subcat_array=array();
				    $timing_array=array();
					if($cat_detail->row()->vehicle_required==1)
					{
						$vehicle_list=$this->user_model->get_all_details(TASKER_VEHICLE, array('status'=>'Active'));
						foreach($vehicle_list->result() as $veh_res){
						$vehicle_array[]=array('vehicle_id'=>$veh_res->id,'vehicle_name'=>$veh_res->vehicle_name);
						}
					}
					foreach($subcat_detail->result() as $subcat_list){
						$subcat_array[]=array('subcat_id'=>$subcat_list->id,'subcat_name'=>$subcat_list->subcat_name);
						}
					$timing_array=array(array('time_id'=>'0','name'=>"I'M FLEXIBLE"),array('time_id'=>'1','name'=>'MORNING 8am - 12pm'),array('time_id'=>'2','name'=>'AFTERNOON 12pm - 4pm'),array('time_id'=>'3','name'=>'EVENING 4pm - 8pm'));	
					$data['dropdown_data']=array('subcat_list'=>$subcat_array,'vehicle_list'=>$vehicle_array,'timing_list'=>$timing_array);
					$data['status']=1;
				}
				else{
					$data['status']=0;
				    $data['message']="Category not available";
				}
				
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	public function find_tasker()
	{		
			$email=$_POST['email'];
			$cat_id=$_POST['cat_id'];
			$subcat_id=$_POST['subcat_id'];
			$perpage=5;
			$page=1;
		    $page=$_POST['page'];	
		    if($page>0){
			$pageLimitStart=($page*$perpage)-$perpage;			 
			}else{
				$page=1;
				$pageLimitStart=0;				
			}
			$vehicle_id="";			
			if(isset($_POST['vehicle_id'])){
			$vehicle_id=$_POST['vehicle_id'];
			}
			$booking_date=$_POST['task_date'];	
			$booking_time=$_POST['task_time'];
			$city=$_POST['city'];
			$sorting="price_low";
			
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
				
					$id=$checkUser->row()->id;
					$distance="";					
					$address_new=$city;
					$address = str_replace(" ", "+", $address_new);
					$gmap_key=$this->config->item('gmap_key');
					$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$gmap_key");
					$json = json_decode($json);
					$newAddress = $json->{'results'}[0]->{'address_components'};
					$retrnstr['lat']=$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
					$retrnstr['long']=$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
					$minLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lat'};
					$minLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lng'};
					$maxLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lat'};
					$maxLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lng'};
					$book_check=$this->mobile_model->get_booked_status($cat_id,$subcat_id,$booking_date,$booking_time); 
					$result=$search='';
					if($book_check->num_rows()>0)
					{
						foreach($book_check->result() as $b_check)
						{
							$result.="'".$b_check->tasker_id."',";
						}
						$result.='}';
						$result1=str_replace(',}','',$result); 
						if($result1!='')
						{
							$search = " and u.id NOT IN(".$result1.")";
						}
						else
						{
							$search='';
						}
					}
					#$block_check=$this->user_model->get_all_details(BLOCK_DATES,array('task_category_id'=>$cat_id,'subcat_id'=>$subcat_id,'task_date'=>$booking_date,'task_time'=>$booking_time)); 
					$block_check=$this->user_model->get_all_details(BLOCK_DATES,array('task_date'=>$booking_date,'task_time'=>$booking_time)); 
					$result='';
					if($block_check->num_rows()>0)
					{
						foreach($block_check->result() as $b_check)
						{
							$result.="'".$b_check->tasker_id."',";
						}
						$result.='}';
						$result1=str_replace(',}','',$result); 
						if($result1!='')
						{
							$search = " and u.id NOT IN(".$result1.")";
						}
						else
						{
							$search='';
						}
					}
					$order_by='';
					if($sorting!='')
					{
						$order_by=$sorting;
					}
					
					
					if($search!=''){
					$whereLat = "u.group='1' ".$search;
					}
					else{
						$whereLat = "u.group='1'";
					}
					$tasker_details=$this->mobile_model->get_tasker_search_details($whereLat,$cat_id,$subcat_id,$id,$booking_date,$booking_time,$distance,$lat,$long,$order_by,$vehicle_id,$pageLimitStart,$perpage); 
                    if($tasker_details->num_rows()>0)
					{
						foreach($tasker_details->result() as $tasker_detail)
						{
							if($tasker_detail->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$tasker_detail->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							$tasks_done=$this->mobile_model->get_all_details(BOOKING,array('tasker_id'=>$tasker_detail->tasker_id,'status'=>"paid"));
							$reviews=$this->mobile_model->get_reviews_details($tasker_detail->tasker_id);
							$avg_rat=0;
							$avper=0;
							$review_array=array();
							if(!empty($reviews)){
							foreach($reviews->result() as $rev){
								$avg_rat+=$rev->rate_val;
								if($rev->photo!='')
								{
									$pro_pic=base_url().'images/site/profile/'.$rev->photo;
								}
								else
								{
									$pro_pic=base_url().'images/site/profile/big_avatar.png';
								}
								
								$review_array[]=array('user_id'=>$rev->user_id,'pro_pic'=>$pro_pic,'first_name'=>$rev->first_name,'last_name'=>$rev->last_name,'review_star'=>$rev->rate_val,'review_message'=>$rev->comments,'created'=>date('d-m-Y',strtotime($rev->created)),'date'=>date('M d',strtotime($rev->created)));
							}
							 if($avg_rat!=0)
							 {
								 $avper=($avg_rat/($reviews->num_rows()*5))*100; 
							 }
							 else 
							 {
								 $avper=0;
							 }
							}
							$supply_array=array();
							if($cat_id==8)
							{
								if($tasker_detail->task_sub_category!='')
								{
									if(in_array(1,explode(',',$tasker_detail->task_sub_category)))
									{
										$supply_array[]=array('title'=>'Basic Supplies','description'=>'glass & multi-purpose cleaner sponges, scrub brushes, bucket, rags');
									}
									if(in_array(2,explode(',',$tasker_detail->task_sub_category)))
									{
										$supply_array[]=array('title'=>'Mop','description'=>'with bucket & floor cleaner');
									}
									if(in_array(3,explode(',',$tasker_detail->task_sub_category)))
									{
										$supply_array[]=array('title'=>'Vacuum','description'=>'');
									}
								}
							}
							if($tasker_detail->id_verified=="Yes")
							{
								$id_verified="ID Verified";
							}
							else
							{
								$id_verified="ID Not Verified";
							}
							$tasker_list[]=array('tasker_id'=>$tasker_detail->tasker_id,'pro_pic'=>$pro_pic,'first_name'=>$tasker_detail->first_name,'last_name'=>$tasker_detail->last_name,'review_response_rate'=>round($avper),'id_verified'=>$id_verified,'currency_symbol'=>'$','price'=>$tasker_detail->price,'service_percentage'=>$tasker_detail->admin_percentage,'about'=>$tasker_detail->tasker_description,'service_start_year'=>date('Y',strtotime($tasker_detail->created)),'task_done'=>$tasks_done->num_rows(),'detail1'=>$tasker_detail->detail1,'detail2'=>$tasker_detail->detail2,'detail3'=>$tasker_detail->detail3,'review_array'=>$review_array,'supply_array'=>$supply_array,'currency_code'=>'USD');
						}
						
						
						
						$data['tasker_list']=$tasker_list;
						$data['status']=1;
					}
					else
					{
						$data['status']=0;
						$data['message']="Taskers not available";
					}
					
			
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function booking_page()
	{		
			$email=$_POST['email'];
			$cat_id=$_POST['cat_id'];
			$subcat_id=$_POST['subcat_id'];			
			$tasker_id=$_POST['tasker_id'];			
			$vehicle_id="";			
			if(isset($_POST['vehicle_id'])){
			$vehicle_id=$_POST['vehicle_id'];
			}
			$booking_date=$_POST['task_date'];	
			$booking_time=$_POST['task_time'];
			$city=$_POST['city'];
			$sorting="price_low";
			
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			
			if ($checkUser->num_rows () == '1') {
				$tasker_details = $this->mobile_model->get_tasker_booking_details ($tasker_id,$cat_id);
				         $tasker_detail=$tasker_details->row();
				         if($tasker_detail->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$tasker_detail->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
				$stripe_pay=(json_decode($this->config->item('stripe_payment')));
				$stripe_key=$stripe_pay->stripe_key;
				$stripe_secret=$stripe_pay->stripe_secret;
				$mode=$stripe_pay->mode;
				if($mode==0)
				{
					$config['stripe_key_test_public']         = $stripe_key;
					$config['stripe_key_test_secret']         = $stripe_secret;
					$config['stripe_test_mode']               = TRUE;
					$config['stripe_verify_ssl']              = FALSE;
				}
				else
				{
					$config['stripe_key_live_public']         = $stripe_key;
					$config['stripe_key_live_secret']         = $stripe_secret;
					$config['stripe_test_mode']               = FALSE;
					$config['stripe_verify_ssl']              = FALSE;
				}

				$this->load->library( 'stripe' );
				$stripe = new Stripe( $config );
				$card_exist='No';
				$existing_card_detail=array();
				if($checkUser->row()->stripe_customer_id!=''){
				$response=json_decode($stripe->customer_info($checkUser->row()->stripe_customer_id)); 
				$res_array=$response->sources->data[0];
				$card_exist='Yes';
				$card_comp=$res_array->brand;
				$card_last=$res_array->last4;
				$existing_card_detail=array('card_comp'=>$card_comp,'card_last'=>$card_last);
				}				
				$data['tasker_detail']=array('tasker_id'=>$tasker_detail->tasker_id,'pro_pic'=>$pro_pic,'first_name'=>$tasker_detail->first_name,'last_name'=>$tasker_detail->last_name,'currency_symbol'=>'$','price'=>$tasker_detail->price,'card_exist'=>$card_exist,'existing_card_detail'=>$existing_card_detail);
				$data['status']=1;	
			
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function save_booking_confirm()
	{
		
		$email=$_POST['email'];
		$cat_id=$_POST['cat_id'];
		$subcat_id=$_POST['subcat_id'];			
		$tasker_id=$_POST['tasker_id'];			
		$task_description=$_POST['task_description'];			
		$vehicle_id="";			
		if(isset($_POST['vehicle_id'])){
		$vehicle_id=$_POST['vehicle_id'];
		$vehicle_name = $this->user_model->get_all_details ( TASKER_VEHICLE, array ('id' => $vehicle_id))->row()->vehicle_name;
		}
		$booking_date=$_POST['task_date'];	
		$booking_time=$_POST['task_time'];
		$city=$_POST['city'];
		$credit_card_type=$_POST['credit_card_type'];
		
		$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
		
		if ($checkUser->num_rows () == '1') {
			
			$ret['error_new']='';
			$id=$checkUser->row()->id;
			$stripe_pay=(json_decode($this->config->item('stripe_payment')));
			$stripe_key=$stripe_pay->stripe_key;
			$stripe_secret=$stripe_pay->stripe_secret;
			$mode=$stripe_pay->mode;
			if($mode==0)
			{
				$config['stripe_key_test_public']         = $stripe_key;
				$config['stripe_key_test_secret']         = $stripe_secret;
				$config['stripe_test_mode']               = TRUE;
				$config['stripe_verify_ssl']              = FALSE;
			}
			else
			{
				$config['stripe_key_live_public']         = $stripe_key;
				$config['stripe_key_live_secret']         = $stripe_secret;
				$config['stripe_test_mode']               = FALSE;
				$config['stripe_verify_ssl']              = FALSE;
			}

			$this->load->library( 'stripe' );
			$stripe = new Stripe( $config );
			
			$task_category=$this->user_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$cat_id));
			$tasker_details=$this->mobile_model->gettasker_taskdetails($tasker_id,$cat_id);
			$service_percentage=$task_category->row()->admin_percentage;
			$per_hour=$tasker_details->row()->price;
			$service_fee=(((4*$tasker_details->row()->price)*$service_percentage)/100);
			$total_amount=(4*$tasker_details->row()->price)+$service_fee;
			$total=$total_amount*100;
			$currency='USD';
			if($credit_card_type==1){
				$number=$_POST['number'];
				$cvc=$_POST['cvc'];
				
				$exp_month=$_POST['exp_month'];
				$exp_year=$_POST['exp_year'];
				$address_zip="";			
				$phone_no="";			
				$card_array=array(
					'number' => $number,
					'cvc' => $cvc,
					'exp_month' => $exp_month,
					'exp_year' => $exp_year,
					'address_zip' => $address_zip,
					'name' => $checkUser->row()->first_name
					
				);
				$response=json_decode($stripe->card_token_create($card_array,$total,$currency));
				if(isset($response->id))
				{
					$token_id=$response->id;
				}
				else
				{
					$token_id='';
				}
				if($token_id=='')
				{
					$ret['error_new']= $response->error->message;
					$data['status']=0;
				    $data['message']=$response->error->message;
				}
				if($ret['error_new']=='')
				{
					$user=$checkUser->row();
					$user_email=$user->email;
					$customer=json_decode($stripe->customer_create($token_id,$user_email));
					if(isset($customer->id))
					{
						$customer_id=$customer->id;
						$enq_array=array(
						'task_category_id'=>$cat_id,
						'subcat_id'=>$subcat_id,
						'veh_id'=>$vehicle_id,
						'veh_name'=>$vehicle_name,
						'user_id'=>$id,
						'tasker_id'=>$tasker_id,
						'task_description'=>$task_description,
						'address'=>$city,
						'booking_date'=>$booking_date,
						'booking_time'=>$booking_time,
						'phone_no'=>$phone_no,
						'address_zipcode'=>$address_zip,
						'service_fee'=>$service_fee,
						'service_percentage'=>$service_percentage,
						'total_amount'=>$total_amount,
						'per_hour'=>$per_hour,
						'status'=>'Pending',
						'created'=>time(),
						'stripe_customer_id'=>$customer_id
						);
						$this->user_model->simple_insert(BOOKING,$enq_array);
						$notifiy_array=array('title'=>'You got request from '.$checkUser->row()->first_name,
						'message'=>$task_description,
						'viewer_id'=>tasker_id,
						'viewer_status'=>'1',
						'message_status'=>'1',
						'booking_id'=>$this->db->insert_id(),
						'user_id'=>$id
						);
						$be_id=$this->db->insert_id();
						$this->user_model->simple_insert(NOTIFICATION,$notifiy_array);
						$this->mail_model->send_booking_emails($be_id);
						$data['status']=1;	
			            $data['message']="Successfully booked";	
					}
					else
					{
						$ret['error_new']= $customer->error->message;
						$data['status']=0;
				        $data['message']=$customer->error->message;
					}
				}
				else
					{   $data['status']=0;
				        $data['message']=$ret['error_new'];
					}
			
			
			}
			else
			{
						
						$get_token=$checkUser->row()->stripe_customer_id;
						$response=json_decode($stripe->customer_info($get_token));			        	
						$customer_id=$response->id;	
						$enq_array=array(
						'task_category_id'=>$cat_id,
						'subcat_id'=>$subcat_id,
						'veh_id'=>$vehicle_id,
						'veh_name'=>$vehicle_name,
						'user_id'=>$id,
						'tasker_id'=>$tasker_id,
						'task_description'=>$task_description,
						'address'=>$city,
						'booking_date'=>$booking_date,
						'booking_time'=>$booking_time,
						'phone_no'=>$phone_no,
						'address_zipcode'=>$address_zip,
						'service_fee'=>$service_fee,
						'service_percentage'=>$service_percentage,
						'total_amount'=>$total_amount,
						'per_hour'=>$per_hour,
						'status'=>'Pending',
						'created'=>time(),
						'stripe_customer_id'=>$customer_id
						);
						$this->user_model->simple_insert(BOOKING,$enq_array);
						$notifiy_array=array('title'=>'You got request from '.$checkUser->row()->first_name,
						'message'=>$task_description,
						'viewer_id'=>$tasker_id,
						'viewer_status'=>'1',
						'message_status'=>'1',
						'booking_id'=>$this->db->insert_id(),
						'user_id'=>$id
						);
						$be_id=$this->db->insert_id();
						$this->user_model->simple_insert(NOTIFICATION,$notifiy_array);
						$this->mail_model->send_booking_emails($be_id); 
						$data['status']=1;	
						$data['message']="Successfully booked";	
						
			}
			
			
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}	
		echo json_encode($data);
		
		
	}
	
	public function dashboard_user_task_history_pending()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->dashboar_user_pending_task_list_load($checkUser->row()->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address,'per_hour_price'=>$ptask->per_hour,'currency_code'=>'USD',"currency_symbol"=>'$');
							
						}
						$data['task_pending_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function dashboard_user_task_history_approved()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->dashboar_user_approved_task_list_load($checkUser->row()->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address,'per_hour_price'=>$ptask->per_hour,'currency_code'=>'USD',"currency_symbol"=>'$');
							
						}
						$data['task_pending_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	
	public function dashboard_user_task_history_completed()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->dashboar_user_completed_task_list_load($checkUser->row()->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$review_result="No";
							$review_val="";
							$review_message="";
							if($ptask->rate_val!="")
							{
								$review_val=$ptask->rate_val;
								$review_result="Yes";
								$review_message=$ptask->comments;
							}
							else
							{
								$review_val="";
								$review_result="No";
								$review_message="";
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'review_star'=>$review_val,'review_done'=>$review_result,'review_message'=>$review_message,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address,'total_amount'=>$ptask->total_amount,'currency_code'=>'USD',"currency_symbol"=>'$');
							
						}
						$data['task_pending_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	
	public function dashboard_user_task_history_cancelled()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->dashboar_user_cancelled_task_list_load($checkUser->row()->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address,'cancel_amount'=>$ptask->cancel_amount,'currency_code'=>'USD',"currency_symbol"=>'$');
							
						}
						$data['task_pending_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function user_active_task()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->dashboar_user_approved_task_list_load($checkUser->row()->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address,'per_hour_price'=>$ptask->per_hour,'currency_code'=>'USD',"currency_symbol"=>'$');
							
						}
						$data['task_pending_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function user_cancel_task()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$ret['error_new']='';	
					$stripe_pay=(json_decode($this->config->item('stripe_payment')));
					$stripe_key=$stripe_pay->stripe_key;
					$stripe_secret=$stripe_pay->stripe_secret;
					$mode=$stripe_pay->mode;
					if($mode==0)
					{
						$config['stripe_key_test_public']         = $stripe_key;
						$config['stripe_key_test_secret']         = $stripe_secret;
						$config['stripe_test_mode']               = TRUE;
						$config['stripe_verify_ssl']              = FALSE;
					}
					else
					{
						$config['stripe_key_live_public']         = $stripe_key;
						$config['stripe_key_live_secret']         = $stripe_secret;
						$config['stripe_test_mode']               = FALSE;
						$config['stripe_verify_ssl']              = FALSE;
					}

					$this->load->library( 'stripe' );
					$stripe = new Stripe( $config );

					$book_id=$_POST['booking_id'];
					$get_booking=$this->mobile_model->get_user_cancel_list($book_id);
					$amount=$get_booking->row()->total_amount*100;
					$cancel_amount=round(($amount*$get_booking->row()->cancel_percentage)/100);
					$customer_id=$get_booking->row()->stripe_customer_id;
					$desc='Task cancel id:SRA00'.$get_booking->row()->id;
					$currency_type='USD';
					$charge=json_decode($stripe->charge_customer($cancel_amount,$customer_id,$desc,$currency_type));/*  echo '<pre>';print_r($charge); */
					if(isset($charge->id))
					{
						$status="Cancel";			
						$this->user_model->update_details(BOOKING,array('status'=>$status),array('id'=>$book_id));
						$this->user_model->simple_insert(TRANSACTION,array('booking_id'=>$book_id,'total_amount'=>$cancel_amount/100));
						$get_booking=$this->user_model->get_all_details(BOOKING,array('id'=>$book_id));
						$userdet=$this->user_model->get_all_details(USERS,array('id'=>$get_booking->row()->tasker_id));
						$notifiy_array=array('message'=>'Your task is cancelled by '.$userdet->row()->first_name.'!!!!',
							'title'=>'Task Cancelled ',
							'viewer_id'=>$get_booking->row()->tasker_id,
							'viewer_status'=>'1',
							'message_status'=>'1',
							'booking_id'=>$book_id,
							'user_id'=>$get_booking->row()->user_id
							);
						$this->user_model->simple_insert(NOTIFICATION,$notifiy_array);
						$this->mail_model->cancel_emails($book_id,$cancel_amount);
						$data['status']=1;
				        $data['message']="Task cancelled successfully";
						
					}
					else
					{
						$data['status']=0;
				        $data['message']=$response->error->message;
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
		
	public function task_completed()
	{		
			$email=$_POST['email'];
			$book_id=$_POST['booking_id'];
			$task_time=$_POST['task_hour'];
			if($task_time!=""){
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$stripe_pay=(json_decode($this->config->item('stripe_payment')));
					$stripe_key=$stripe_pay->stripe_key;
					$stripe_secret=$stripe_pay->stripe_secret;
					$mode=$stripe_pay->mode;
					if($mode==0)
					{
						$config['stripe_key_test_public']         = $stripe_key;
						$config['stripe_key_test_secret']         = $stripe_secret;
						$config['stripe_test_mode']               = TRUE;
						$config['stripe_verify_ssl']              = FALSE;
					}
					else
					{
						$config['stripe_key_live_public']         = $stripe_key;
						$config['stripe_key_live_secret']         = $stripe_secret;
						$config['stripe_test_mode']               = FALSE;
						$config['stripe_verify_ssl']              = FALSE;
					}
					$ret['error_new']='';	
					$this->load->library( 'stripe' );
					$stripe = new Stripe( $config );
					$get_booking=$this->user_model->get_all_details(BOOKING,array('id'=>$book_id));
					/*Update amount*/
					$service_percentage=$get_booking->row()->service_percentage;
					$per_hour=$get_booking->row()->per_hour;
					$service_fee=((($task_time*$per_hour)*$service_percentage)/100);
					$total_amount=round(($task_time*$per_hour)+$service_fee);
					$price_update=array('service_fee'=>$service_fee,'total_amount'=>$total_amount,'total_task_hour'=>$task_time);
					$this->user_model->update_details(BOOKING,$price_update,array('id'=>$book_id)); /* echo $this->db->last_query();die; */
					
					/*Update amount*/
					$amount=$total_amount*100;
					$customer_id=$get_booking->row()->stripe_customer_id;
					$desc='Task id:SRA00'.$get_booking->row()->id;
					$currency_type='USD';
					$charge=json_decode($stripe->charge_customer($amount,$customer_id,$desc,$currency_type));
					if(isset($charge->id))
					{
						$status="Paid";			
						$this->user_model->update_details(BOOKING,array('status'=>$status),array('id'=>$book_id));
						$this->user_model->simple_insert(TRANSACTION,array('booking_id'=>$book_id,'total_amount'=>$get_booking->row()->total_amount));
						$get_booking=$this->user_model->get_all_details(BOOKING,array('id'=>$book_id));
						$userdet=$this->user_model->get_all_details(USERS,array('id'=>$get_booking->row()->tasker_id));
						$notifiy_array=array('message'=>'Thanks for your great work  '.$userdet->row()->first_name.'!!!!',
							'title'=>'Task Completed ',
							'viewer_id'=>$get_booking->row()->tasker_id,
							'viewer_status'=>'1',
							'message_status'=>'1',
							'booking_id'=>$book_id,
							'user_id'=>$get_booking->row()->user_id
							);
						$this->user_model->simple_insert(NOTIFICATION,$notifiy_array);
						$this->mail_model->send_booked_emails($book_id);
						$data['status']=1;
						$data['message']="Task done successfully";
					}
					else
					{
						
						$data['status']=0;
						$data['message']=$charge->error->message;
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			}
			else
			{
				
				$data['status']=0;
				$data['message']="Please enter task hour";				
			
			}
			echo json_encode($data);
				
		
	}

			
	public function billing_info()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
				    $id=$userdetail->id;
					$ret['error_new']='';
					$stripe_pay=(json_decode($this->config->item('stripe_payment')));
					$stripe_key=$stripe_pay->stripe_key;
					$stripe_secret=$stripe_pay->stripe_secret;
					$mode=$stripe_pay->mode;
					if($mode==0)
					{
						$config['stripe_key_test_public']         = $stripe_key;
						$config['stripe_key_test_secret']         = $stripe_secret;
						$config['stripe_test_mode']               = TRUE;
						$config['stripe_verify_ssl']              = FALSE;
					}
					else
					{
						$config['stripe_key_live_public']         = $stripe_key;
						$config['stripe_key_live_secret']         = $stripe_secret;
						$config['stripe_test_mode']               = FALSE;
						$config['stripe_verify_ssl']              = FALSE;
					}
                   
					$this->load->library( 'stripe' );
					$stripe = new Stripe( $config );
					$number=$_POST['number'];
					$cvc=$_POST['cvc'];
					$exp_month=$_POST['exp_month'];
					$exp_year=$_POST['exp_year'];
					$address_zip="";
					$card_name=$_POST['card_name'];
					$card_array=array(
						'number' => $number,
						'cvc' => $cvc,
						'exp_month' => $exp_month,
						'exp_year' => $exp_year,
						'address_zip' => $address_zip,
						'name' => $card_name
						
					);	
					if($this->config->item('tasker_signup_fee')!='')
					{
						$total_amount=$this->config->item('tasker_signup_fee');
					}
					else{
						$total_amount=20;
					}	
					$total=$total_amount*100;
					$currency='USD';
					$response=json_decode($stripe->card_token_create($card_array,$total,$currency));
					if(isset($response->id))
					{
						$token_id=$response->id;
					}
					else
					{
						$token_id='';
					}		
					
					if($token_id!='')
					{
						$user_email=$userdetail->email;
						$customer=json_decode($stripe->customer_create($token_id,$user_email));
						if(isset($customer->id))
						{
							    $customer_id=$customer->id;						
								$newarray['stripe_customer_id']=$customer_id;
								$this->user_model->update_details(USERS,$newarray,array('id'=>$id));
								$data['status']=1;
							    $data['message']= "Successfully credit card saved";
						}
						else
						{
							$data['status']=0;
							$data['message']= $customer->error->message;
						}
					}
					else
						{
							$data['status']=0;
							$data['message']=  $response->error->message;
						}
				
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			
			echo json_encode($data);
				
		
	}

    public function tasker_signup()
	{   
		$email=$this->input->post('email');
		if($email!="" || $_POST['password']!=""){
		$t=count($this->mobile_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
				$_POST['password']=md5($_POST['password']); 
				$save_array=array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'email'=>$_POST['email'],'password'=>$_POST['password'],'phone'=>$_POST['phone'],'zipcode'=>$_POST['zipcode'],'device_type'=>$_POST['device_type'],'device_id'=>$_POST['device_id'],'group'=>1);
				$t=$this->mobile_model->simple_insert(USERS,$save_array);
       		    $checkUser = $this->mobile_model->get_all_details(USERS, array('email'=>$email)); #echo '<pre>'; print_r($checkUser->row());
				$tasker_step=0;
				if($checkUser->row ()->tasker_step2=="0")
				{
					$tasker_step=1;
				}
				else if($checkUser->row ()->tasker_step3=="0")
				{
					$tasker_step=2;
				}
				else if($checkUser->row ()->tasker_step4=="0")
				{
					$tasker_step=3;
				}
				else
				{
					$tasker_step=0;
				}
			    $userdata = array (
						'user_id' => $checkUser->row ()->id,
						'first_name' => $checkUser->row ()->first_name,
						'last_name' => $checkUser->row ()->last_name,
						'pro_pic'=> base_url().'images/site/profile/big_avatar.png',
						'email' => $checkUser->row ()->email,
						'tasker_step' => $tasker_step,
						'email' => $checkUser->row ()->email,
						'group'=>1
				);
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'last_login_date' => mdate ( $datestring, $time ),
						'last_login_ip' => $this->input->ip_address ()
				);
				$condition = array (
						'id' => $checkUser->row ()->id
				);
				$this->mobile_model->update_details ( USERS, $newdata, $condition );
				
			$t1['status'] =1;
			$t1['result'] =$userdata;
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Email already exsist.';
		 	
		}
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Please fill all the fields.';
		}
		
	    echo json_encode($t1);
    }
	
	public function tasker_about_us()
	{   
		$email=$this->input->post('email');
		$t=count($this->mobile_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t==1)
		{
			$metro_city_array=array();	
			$city_list=$this->mobile_model->get_all_details(TASKER_CITY,array('status'=>'Active'));	
			if($city_list->num_rows()>0)
			{
				foreach($city_list->result() as $city)
				{
					$metro_city_array[]=array('city_id'=>$city->id,'city_name'=>$city->city_name);
				}
			}
			$t1['metro_city_list'] =$metro_city_array;
			$metro_city_array=array();	
			$vehicle_list=$this->mobile_model->get_all_details(TASKER_VEHICLE,array('status'=>'Active'));	
			if($vehicle_list->num_rows()>0)
			{
				foreach($vehicle_list->result() as $vehicle)
				{
					$vehicle_list_array[]=array('vehicle_id'=>$vehicle->id,'vehicle_name'=>$vehicle->vehicle_name);
				}
			}
			
			$t1['vehicle_list'] =$vehicle_list_array;
			$t1['km_list'] =array(array('value'=>'50','text'=>"50 Kms"),array('value'=>'100','text'=>"100 Kms"),array('value'=>'150','text'=>"150 Kms"),array('value'=>'200','text'=>"200 Kms"));
			$t1['referedby_list'] =array("Referred by a friend","Facebook","Google search","Blog","Newspaper/Magazine","Bus/Subway ad","Trade school/college","Career center","Craigslist","Other");
			$t1['status'] =1;
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
		
	public function save_tasker_about_us()
	{   
		$email=$this->input->post('email');
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email));
        if($t->num_rows()==1)
		{
			$id=$t->row()->id;
			$_POST['tasker_step1']=1;
			$_POST['tasker_step2']=1;
			
				$address = $this->input->post('city');
				$zipcode = $this->input->post('zipcode');
				$address = str_replace(" ", "+", $address);
				$gmap_key=$this->config->item('gmap_key');
				$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&&components=postal_code:$zipcode&sensor=false&key=$gmap_key");
				$json = json_decode($json);
				if($json->status=='OK')
				{
					$newAddress = $json->{'results'}[0]->{'address_components'};
					$_POST['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
					$_POST['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};					
				}
			$vehicle_types=implode(',',json_decode($_POST['vehicle_types']));
    		 $tasker_about_us=array('work_city'=>$_POST['work_city'],'home'=>$_POST['home'],'street'=>$_POST['street'],'city'=>$_POST['city'],'state'=>$_POST['state'],'zipcode'=>$_POST['zipcode'],'lat'=>$_POST['lat'],'long'=>$_POST['long'],'dob'=>date('Y-m-d',strtotime($_POST['dob'])),'distance'=>$_POST['distance'],'detail1'=>$_POST['detail1'],'detail2'=>$_POST['detail2'],'detail3'=>$_POST['detail3'],'hear_about'=>$_POST['hear_about'],'vehicle_types'=>$vehicle_types,'tasker_step1'=>$_POST['tasker_step1'],'tasker_step2'=>$_POST['tasker_step2']);
			 $this->mobile_model->update_details(USERS,$tasker_about_us,array('id'=>$id));
			$t1['status'] =1;
			$t1['message'] ="Successfully fully saved";
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function get_services_listing_inof()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{      $get_main_category = $this->user_model->get_all_details ( TASKER_CATEGORY, array ('status' => 'Active'));
				$main_cat_list=array();
				$sub_cat_list=array();
				if($get_main_category->num_rows()>0)
				{
					foreach($get_main_category->result() as $mcat){
						$subcat_list=$this->user_model->get_all_details ( TASKER_SUB_CATEGORY, array ('status' => 'Active','cat_id'=>$mcat->id));
						$subcat_array=array();
							if($subcat_list->num_rows()>0)
							{
								foreach($subcat_list->result() as $scat){
									
									$subcat_array[]=array('id'=>$scat->id,'sub_cat_name'=>$scat->subcat_name);
								}
							}				
							$main_cat_list[]=array('id'=>$mcat->id,'main_cat_name'=>$mcat->task_name);
							$sub_cat_list[$mcat->id]=$subcat_array;
					}
			$t1['experience_list']=array(array("value"=>"none","text"=>"No experience, but I am willing to learn"),array("value"=>"some","text"=>"Some experience. I have done it for myself around the home"),array("value"=>"part_time","text"=>"I have had part-time experience"),array("value"=>"professional","text"=>"I have had professional experience"),array("value"=>"certified","text"=>"I am professionally certified in this skill"));		
			$t1['main_cat_list'] =$main_cat_list;			
			$t1['sub_cat_list'] =$sub_cat_list;			
			$t1['cleaning_list'] =array(array('id'=>'1','title'=>'Pickup Truck','description'=>'glass & multi-purpose cleaner sponges, scrub brushes, bucket, rags'),array('id'=>'2','title'=>'Mop','description'=>'with bucket & floor cleaner'),array('id'=>'3','title'=>'Vacuum','description'=>'Vacuum cleaner with cleaning tools'));			
			$t1['status'] =1;
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Category not available.';
		 	
		}
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	public function get_subcategory()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{      
	             $main_cat_list=array();
				 $sub_cat_list=array();
				  $catid=$_POST['task_category_id'];
					
						$subcat_list=$this->user_model->get_all_details ( TASKER_SUB_CATEGORY, array ('status' => 'Active','cat_id'=>$catid));
						$subcat_array=array(); 
							if($subcat_list->num_rows()>0)
							{
								foreach($subcat_list->result() as $scat){
									
									$subcat_array[]=array('id'=>$scat->id,'sub_cat_name'=>$scat->subcat_name);
								}
								$t1['sub_cat_list'] =$subcat_array;						
			                    $t1['status'] =1;
							}				
							else
							{
								$t1['status'] =0;
								$t1['message'] = 'Category not available.';
								
							}
			
		}		
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function save_service_category()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{     
				$id=$t->row()->id;
				$task_category_id=$_POST['task_category_id'];
				$task_sub_category=implode(',',json_decode($_POST['task']));
				$subcat_id=implode(',',json_decode($_POST['subcat_id']));
				$dataarray=array('task_category_id'=>$task_category_id,'user_id'=>$id,'price'=>$_POST['price'],'task_sub_category'=>$task_sub_category,'tasker_description'=>$_POST['tasker_description'],'experience'=>$_POST['experience'],'subcat_id'=>$subcat_id);
				$exsisting_check=$this->mobile_model->get_all_details(TASKER_CATEGORY_SELECTION,array('task_category_id'=>$task_category_id,'user_id'=>$id));
				if($exsisting_check->num_rows()==0)
				{
					$this->mobile_model->simple_insert(TASKER_CATEGORY_SELECTION,$dataarray);
					$this->mobile_model->update_details(USERS,array('tasker_step3'=>1),array('id'=>$id));
					$t1['status']=1;
					$t1['message'] = 'Successfully task saved.';
				}
				else
				{
					$this->mobile_model->update_details(TASKER_CATEGORY_SELECTION,$dataarray,array('task_category_id'=>$task_category_id,'user_id'=>$id));
					$this->mobile_model->update_details(USERS,array('tasker_step3'=>1),array('id'=>$id));
					$t1['status']=1;
					$t1['message'] = 'Successfully task updated.';
				}
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function delete_tasker_category()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{     
				$id=$t->row()->id;
				$task_category_id=$_POST['task_category_id'];
				$this->mobile_model->commonDelete(TASKER_CATEGORY_SELECTION,array('user_id'=>$id,'task_category_id'=>$task_category_id));
				$t1['status'] =1;
			    $t1['message'] = 'Task deleted successfully.';
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function get_existing_tasker_info()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{      $get_main_category = $this->user_model->get_all_details ( TASKER_CATEGORY, array ('status' => 'Active'));
				$main_cat_list=array();
				$sub_cat_list=array();
				$vehicle_types=explode(',',($t->row()->vehicle_types));
				$tasker_about_us=array('work_city'=>$t->row()->work_city,'home'=>$t->row()->home,'street'=>$t->row()->street,'city'=>$t->row()->city,'state'=>$t->row()->state,'zipcode'=>$t->row()->zipcode,'dob'=>$t->row()->dob,'distance'=>$t->row()->distance,'detail1'=>$t->row()->detail1,'detail2'=>$t->row()->detail2,'detail3'=>$t->row()->detail3,'hear_about'=>$t->row()->hear_about,'vehicle_types'=>$vehicle_types);
				if($get_main_category->num_rows()>0)
				{
					foreach($get_main_category->result() as $mcat){
						$subcat_list=$this->user_model->get_all_details ( TASKER_CATEGORY_SELECTION, array ('task_category_id'=>$mcat->id,'user_id'=>$t->row()->id));
						$subcat_array=array();
							if($subcat_list->num_rows()>0)
							{
								foreach($subcat_list->result() as $scat){
									
									$subcat_array=array('task_category_id'=>$mcat->id,'task_name'=>$mcat->task_name,'price'=>$scat->price,'subcat_id'=>explode(',',$scat->subcat_id),'experience'=>$scat->experience,"tasker_description"=>trim(preg_replace('/\s+/', ' ', $scat->tasker_description)));
								}
								$main_cat_list[]=$subcat_array;
							}				
							
							}
					$t1['main_cat_list'] =$main_cat_list;			
					$t1['tasker_about_us'] =$tasker_about_us;			
					$t1['status'] =1;
				}
				else
				{
					$t1['status'] =0;
					$t1['message'] = 'Category not available.';
					
				}
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
		
			
	public function tasker_signup_pay()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
				    $id=$userdetail->id;
					$newarray['tasker_step4']=1;			
					$newarray['tasker_completed']=1;			
					$stripe_pay=(json_decode($this->config->item('stripe_payment')));
					$stripe_key=$stripe_pay->stripe_key;
					$stripe_secret=$stripe_pay->stripe_secret;
					$mode=$stripe_pay->mode;
					if($mode==0)
					{
						$config['stripe_key_test_public']         = $stripe_key;
						$config['stripe_key_test_secret']         = $stripe_secret;
						$config['stripe_test_mode']               = TRUE;
						$config['stripe_verify_ssl']              = FALSE;
					}
					else
					{
						$config['stripe_key_live_public']         = $stripe_key;
						$config['stripe_key_live_secret']         = $stripe_secret;
						$config['stripe_test_mode']               = FALSE;
						$config['stripe_verify_ssl']              = FALSE;
					}

					$this->load->library( 'stripe' );
					$stripe = new Stripe( $config );
					$number=$_POST['number'];
					$cvc=$_POST['cvc'];
					$exp_month=$_POST['exp_month'];
					$exp_year=$_POST['exp_year'];
					$address_zip=$_POST['address_zip'];
					$card_array=array(
						'number' => $number,
						'cvc' => $cvc,
						'exp_month' => $exp_month,
						'exp_year' => $exp_year,
						'address_zip' => $address_zip,
						'name' => 'siva'
						
					);	
					if($this->config->item('tasker_signup_fee')!='')
					{
						$total_amount=$this->config->item('tasker_signup_fee');
					}
					else{
						$total_amount=20;
					}	
					$total=$total_amount*100;
					$currency='USD';
					$response=json_decode($stripe->card_token_create($card_array,$total,$currency));
					if(isset($response->id))
					{
						$token_id=$response->id;
					}
					else
					{
						$token_id='';
					}		
					if($token_id=='')
					{
						$ret['message']= $response->error->message;
						$ret['status']= 0;
					}
					if($ret['message']=='')
					{
						$user=$this->mobile_model->get_all_details(USERS,array('id'=>$id))->row();
						$user_email=$user->email;
						$customer=json_decode($stripe->customer_create($token_id,$user_email));
						if(isset($customer->id))
						{
							$customer_id=$customer->id;
							$desc='Tasker signup fee $'.$total_amount;
							$currency_type='USD';
							$charge=json_decode($stripe->charge_customer($total,$customer_id,$desc,$currency_type));
							if(isset($charge->id))
							{
								
								$newarray['stripe_customer_id']=$customer_id;
								$this->mobile_model->update_details(USERS,$newarray,array('id'=>$id));
							
								
								if($this->config->item('tasker_automation')==1)
								{
								  $this->mobile_model->update_details(USERS,array('tasker_completed'=>'0'),array('id'=>$id));
								  $this->mail_model->tasker_registration_email($user);
								 }
								$ret['status']=1;
				                $ret['message']="Signup Completed Successfully";
							}
							else
							{
								$ret['status']=0;
								$ret['message']= $charge->error->message;
							}
						}
						else
						{
							$ret['status']=0;
							$ret['message']= $customer->error->message;
						}
					}
				
			}
			else{
				$ret['status']=0;
				$ret['message']="User not available";				
			}
			
			echo json_encode($ret);
				
		
	}
	
	
	public function tasker_active_task()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->tasker_enquires_load_active($userdetail->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address);
							
						}
						$data['task_active_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	
	public function tasker_pending_task()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->tasker_enquires_load_pending($userdetail->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address);
							
						}
						$data['task_pending_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	
	public function tasker_approved_task()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->tasker_enquires_load_approved($userdetail->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address);
							
						}
						$data['task_approved_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function tasker_completed_task()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->tasker_enquires_load_completed($userdetail->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address,'currency_symbol'=>'$','price'=>$ptask->total_amount);
							
						}
						$data['task_pending_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	public function tasker_enquires_load_cancel()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();
					$pending_task_details=$this->mobile_model->tasker_enquires_load_cancel($userdetail->id);
					if($pending_task_details->num_rows()>0)
					{
						foreach($pending_task_details->result() as $ptask){
							
							if($ptask->photo!='')
							{
								$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
							}
							else
							{
								$pro_pic=base_url().'images/site/profile/big_avatar.png';
							}
							if($ptask->booking_time==0)
							{
								$btime="I'M FLEXIBLE";
							}
							else if($ptask->booking_time==1)
							{
								$btime='MORNING 8am - 12pm';
							}
							else if($ptask->booking_time==2)
							{
								$btime='AFTERNOON 12pm - 4pm';
							}
							else if($ptask->booking_time==3)
							{
								$btime='EVENING 4pm - 8pm';
							}
							$task_pending_array[]=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address);
							
						}
						$data['task_pending_array']=$task_pending_array;
						$data['status']=1;
				    }
					else
					{
						$data['status']=0;
						$data['message']="No task is available";
					}
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	
	public function tasker_task_respond()
	{		
			$email=$_POST['email'];
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			if ($checkUser->num_rows () == '1') {
					$userdetail=$checkUser->row();					
					$id=$_POST['booking_id'];
					$status=$_POST['status'];			
					$this->mobile_model->update_details(BOOKING,array('status'=>$status),array('id'=>$id));
					
					$get_booking=$this->mobile_model->get_all_details(BOOKING,array('id'=>$id));
					$notifiy_array=array('message'=>'Your task request '.$status.' by '.$userdetail->first_name,
						'title'=>'Task request '.$status,
						'viewer_id'=>$get_booking->row()->user_id,
						'viewer_status'=>'1',
						'message_status'=>'1',
						'booking_id'=>$id,
						'user_id'=>$get_booking->row()->tasker_id
						);
					$this->user_model->simple_insert(NOTIFICATION,$notifiy_array);
					$this->mail_model->send_booking_respond_emails($id);
					$data['status']=1;
				    $data['message']="Task status updated successfully";
				    
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
	
	public function get_task_info()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{      
			$userdetail=$t->row();
			$task_category_id=$_POST['task_category_id'];
			$get_category = $this->user_model->get_all_details ( TASKER_CATEGORY_SELECTION, array ('user_id'=>$userdetail->id,'task_category_id'=>$task_category_id));
			if($get_category->num_rows()==1)
			{
				$dataarray=array('task_category_id'=>$task_category_id,'user_id'=>$userdetail->id,'price'=>$get_category->row()->price,'task_sub_category'=>$get_category->row()->task_sub_category,'tasker_description'=>$get_category->row()->tasker_description,'experience'=>$get_category->row()->experience,'subcat_id'=>$get_category->row()->subcat_id);
				$t1['status'] =1;
				$t1['task_info'] = $dataarray;
			}
			else
			{
				$t1['status'] =0;
				$t1['message'] = 'Task is not available.';
			}	
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	
	
	public function get_tasker_info()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{      
			    $userdetail=$t->row();			
				$tasker_about_us=array('work_city'=>$userdetail->work_city,'home'=>$userdetail->home,'street'=>$userdetail->street,'city'=>$userdetail->city,'state'=>$userdetail->state,'zipcode'=>$userdetail->zipcode,'dob'=>date('Y-m-d',strtotime($userdetail->dob)),'distance'=>$userdetail->distance,'detail1'=>$userdetail->detail1,'detail2'=>$userdetail->detail2,'detail3'=>$userdetail->detail3,'hear_about'=>$userdetail->hear_about,'vehicle_types'=>$userdetail->vehicle_types);
				$t1['status'] =1;
				$t1['tasker_info'] = $tasker_about_us;
				
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function get_tasker_document_picture()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{      
			    $userdetail=$t->row();	
				if($userdetail->id_doc!='')
				{
					$pro_pic=base_url().'images/site/profile/doc/'.$userdetail->id_doc;
				}
				else
				{
					$pro_pic=base_url().'images/site/profile/doc/avatar.png';
				}				
				
				$t1['status'] =1;
				$t1['tasker_doc_picture'] = $pro_pic;
				
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	
	public function upload_tasker_document_picture()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{   $id=$t->row()->id;     
			if($_FILES)
			{   if(!is_dir('./images/site/profile/doc'))
				{
					mkdir('./images/site/profile/doc',0777);
				}
				$config['overwrite'] = FALSE;
				$config['remove_spaces'] = TRUE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				/*$config['max_size'] = 2000;
				$config['max_width']  = '1600';
				$config['max_height']  = '1600';*/
				$config['upload_path'] = './images/site/profile/doc';
				$this->load->library('upload', $config);
				if ( $this->upload->do_upload('upload_document_picture')){
					$imgDetailsd = $this->upload->data();
					$dataarray = array('id_doc'=>$imgDetailsd['file_name']);
					$this->user_model->update_details(USERS,$dataarray,array('id'=>$id));
					$t1['status']=1;
					$t1['message']='Document update successfully...';
					
				}
				else
				{
					$t1['status']=0;
					$t1['message']=strip_tags($this->upload->display_errors());
				}
				
				$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
				$img=$user->id_doc!=''?$user->id_doc:'avatar.png';
				$t1['pro_pic_doc']=base_url().'images/site/profile/doc/'.$img;
				
			}
				
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function stripe_setting()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{      
			    $userdetail=$t->row();	
				$st=$userdetail->stripe_user_id==""?"Connect to Stripe":"Reconnect Stripe";
				$stripe_pay=(json_decode($this->config->item('stripe_payment')));
			    $t1['stripe_connect_url']="https://connect.stripe.com/oauth/authorize?response_type=code&scope=read_write&client_id=".$stripe_pay->client_id;
				$t1['status'] =1;
				$t1['stripe_status'] = $st;
				
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	/* public function stripe_response()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{      
			           $userdetail=$t->row();	
					if (isset($_GET['code'])) { // Redirect w/ code
						$code = $_GET['code'];
						$id=$this->checkLogin('U');
						$stripe_pay=(json_decode($this->config->item('stripe_payment')));
						$stripe_key=$stripe_pay->stripe_key;
						$stripe_secret=$stripe_pay->stripe_secret;
						$client_id=$stripe_pay->client_id;
						$mode=$stripe_pay->mode;
						if($mode==0)
						{
							$config['stripe_key_test_public']         = $stripe_key;
							$config['stripe_key_test_secret']         = $stripe_secret;
							$config['stripe_test_mode']               = TRUE;
							$config['stripe_verify_ssl']              = FALSE;
						}
						else
						{
							$config['stripe_key_live_public']         = $stripe_key;
							$config['stripe_key_live_secret']         = $stripe_secret;
							$config['stripe_test_mode']               = FALSE;
							$config['stripe_verify_ssl']              = FALSE;
						}
						$ret['error_new']='';	
						$this->load->library( 'stripe' );
						$stripe = new Stripe( $config );
						  $token_request_body = array(
							'grant_type' => 'authorization_code',
							'client_id' => $client_id,
							'code' => $code,
							'client_secret' => $stripe_key
						  );
					  $req = curl_init('https://connect.stripe.com/oauth/token');
					  curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
					  curl_setopt($req, CURLOPT_SSL_VERIFYPEER,false);
					  curl_setopt($req, CURLOPT_POST, true );
					  curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));
					  $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
					  $resp = json_decode(curl_exec($req), true);
					  curl_close($req);
					  $this->tasker_model->update_details(USERS,array('stripe_user_id'=>$resp['stripe_user_id']),array('id'=>$id));
					  $this->session->set_flashdata('alert_message', 'Stripe connected successfully...');
					  $this->session->set_flashdata('error_type', 'success');
					  redirect(base_url('account'));
					}
					else
					{
						$this->session->set_flashdata('alert_message', 'Stripe not connected try again...');
						$this->session->set_flashdata('error_type', 'error');
						redirect(base_url('account'));
					}
				$t1['status'] =1;
				$t1['stripe_status'] = $st;
				
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    } */
	
	
	public function get_blocked_dates()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{       $id=$t->row()->id;
				$bdate=array();
				$block_dates=$this->mobile_model->get_all_details(BLOCK_DATES,array('tasker_id'=>$id));
				foreach($block_dates->result() as $bdates)
				{
					$bdate[]=array('block_id'=>$bdates->id,'block_date'=>$bdates->task_date,'block_time'=>$bdates->task_time);
				}
				#$timing_array=array('1'=>'MORNING 8am - 12pm','0'=>"I'M FLEXIBLE",'2'=>'AFTERNOON 12pm - 4pm','3'=>'EVENING 4pm - 8pm');
				$timing_array=array(array('time_id'=>'0','name'=>"I'M FLEXIBLE"),array('time_id'=>'1','name'=>'MORNING 8am - 12pm'),array('time_id'=>'2','name'=>'AFTERNOON 12pm - 4pm'),array('time_id'=>'3','name'=>'EVENING 4pm - 8pm'));	
				$t1['bdates']=$bdate;
				$t1['timing_array']=$timing_array;
				$t1['status'] =1;
				
		}
		else
		{
				$t1['status'] =0;
				$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function save_block_date()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{       $id=$t->row()->id;
				#$dates=explode(',',$_POST['task_date']);
				$dates=json_decode($_POST['task_date']);
				
				foreach($dates as $task_dates){ 
				$ex_block_dates=$this->mobile_model->get_all_details(BLOCK_DATES, array('tasker_id'=>$id,'task_date'=>date('Y-m-d',strtotime($task_dates)),'task_time'=>$_POST['task_time']));	
				$ret['res']='';	
				if($ex_block_dates->num_rows()==0)
				{
				$block_array=array('task_date'=>date('Y-m-d',strtotime($task_dates)),'task_time'=>$_POST['task_time'],'tasker_id'=>$id);
				$this->mobile_model->simple_insert(BLOCK_DATES,$block_array);
				}
				}
				$t1['status'] =1;
				$t1['message']="Successfully fully dates blocked";
				
				
		}
		else
		{
				$t1['status'] =0;
				$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function delete_block_dates()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{     
				$id=$_POST['block_id'];
				$this->mobile_model->commonDelete(BLOCK_DATES,array('id'=>$id));
				$t1['status'] =1;
			    $t1['message'] = 'block date deleted successfully.';
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'User not available.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	public function forgot_password()
	{   
		$email=$_POST['email'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{     
			 
				$password=time();
				$to = $email;			
				$this->mail_model->send_user_password ( $password,$t->row()->first_name,$email );
				$this->user_model->update_details(USERS,array('password'=>md5($password)),array('email'=>$email));	
				$t1['status']=1;
				$t1['message']="Passwor reset successfully. Check your mail";
				
			 		
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Email id is not found.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function tasker_login_process() {

		$email = $this->input->post ( 'login_email' );
		$pwd = md5 ( $this->input->post ( 'login_password' ) );
		$condition = array (
					'email' => $email,
					'password' => $pwd,
					'status' => 'Active',
					'group' => '1',
			);
		$checkUser = $this->user_model->get_all_details ( USERS, $condition );
		if ($checkUser->num_rows () == '1') {
			   
			    $tasker_step=0;
				if($checkUser->row ()->tasker_step2=="0")
				{
					$tasker_step=1;
				}
				else if($checkUser->row ()->tasker_step3=="0")
				{
					$tasker_step=2;
				}
				else if($checkUser->row ()->tasker_step4=="0")
				{
					$tasker_step=3;
				}
				else
				{
					$tasker_step=0;
				}
				$userdata = array (
						'user_id' => $checkUser->row ()->id,
						'first_name' => $checkUser->row ()->first_name,
						'last_name' => $checkUser->row ()->last_name,
						'user_id' => $checkUser->row ()->id,
						'pro_pic'=> base_url().'images/site/profile/big_avatar.png',
						'email' => $checkUser->row ()->email,
						'group'=> $checkUser->row ()->group,
						'tasker_step'=>$tasker_step
				);
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'last_login_date' => mdate ( $datestring, $time ),
						'last_login_ip' => $this->input->ip_address () );
				$condition = array (
						'id' => $checkUser->row ()->id
				);
				$this->user_model->update_details ( USERS, $newdata, $condition );
				$t1['status'] = 1;
				$t1['result'] =$userdata;
				$t1['message'] = 'Logged in successfully.';	
				
			}
			else
			{
			$condition = array ('email' => $email,'status'=>'Inactive');
			$checkUser1 = $this->user_model->get_all_details ( USERS, $condition );
			if ($checkUser1->num_rows () == '1') 
			{
				$t1['message'] = 'Your Account is Inactive';
				$t1['status'] = 0;
			}
			else  
			{
				$t1['message'] = 'Invalid login details';
				$t1['status'] = 0;	
			}
			}			

		
		echo json_encode ( $t1 );
	}
	
	public function logout() {

		        $email = $this->input->post ( 'email' );
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'last_logout_date' => mdate ( $datestring, $time )
				);
				$condition = array (
						'email' => $email
				);
				$this->user_model->update_details ( USERS, $newdata, $condition );
				$t1['status'] = 1;
				$t1['message'] = 'Logged out successfully.';	
				
						

		
		echo json_encode ( $t1 );
	}
	
	public function get_existing_card_info()
	{		
			$email=$_POST['email'];
			
			$checkUser = $this->user_model->get_all_details ( USERS, array ('email' => $email));
			
			if ($checkUser->num_rows () == '1') {
				        
				$stripe_pay=(json_decode($this->config->item('stripe_payment')));
				$stripe_key=$stripe_pay->stripe_key;
				$stripe_secret=$stripe_pay->stripe_secret;
				$mode=$stripe_pay->mode;
				if($mode==0)
				{
					$config['stripe_key_test_public']         = $stripe_key;
					$config['stripe_key_test_secret']         = $stripe_secret;
					$config['stripe_test_mode']               = TRUE;
					$config['stripe_verify_ssl']              = FALSE;
				}
				else
				{
					$config['stripe_key_live_public']         = $stripe_key;
					$config['stripe_key_live_secret']         = $stripe_secret;
					$config['stripe_test_mode']               = FALSE;
					$config['stripe_verify_ssl']              = FALSE;
				}

				$this->load->library( 'stripe' );
				$stripe = new Stripe( $config );
				$card_exist='No';
				$existing_card_detail=array();
				if($checkUser->row()->stripe_customer_id!=''){
				$response=json_decode($stripe->customer_info($checkUser->row()->stripe_customer_id)); 
				$res_array=$response->sources->data[0];
				$card_exist='Yes';
				$card_comp=$res_array->brand;
				$card_last=$res_array->last4;
				$existing_card_detail=array('card_comp'=>$card_comp,'card_last'=>$card_last);
				}				
				$data['card_detail']=array('card_exist'=>$card_exist,'existing_card_detail'=>$existing_card_detail);
				$data['status']=1;	
			
			}
			else{
				$data['status']=0;
				$data['message']="User not available";				
			}
			echo json_encode($data);
				
		
	}
	
		
	public function social_login_process() {

		$email = $this->input->post ( 'email' );
		$condition = array (
					'email' => $email,
					'status' => 'Active'
			);
		$checkUser = $this->user_model->get_all_details ( USERS, $condition );
		if ($checkUser->num_rows () == '1') {
				$userdata = array (
						'user_id' => $checkUser->row ()->id,
						'first_name' => $checkUser->row ()->first_name,
						'last_name' => $checkUser->row ()->last_name,
						'user_id' => $checkUser->row ()->id,
						'pro_pic'=> base_url().'images/site/profile/big_avatar.png',
						'email' => $checkUser->row ()->email,
						'group'=> $checkUser->row ()->group
				);
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'last_login_date' => mdate ( $datestring, $time ),
						'last_login_ip' => $this->input->ip_address () );
				$condition = array (
						'id' => $checkUser->row ()->id
				);
				$this->user_model->update_details ( USERS, $newdata, $condition );
				$t1['status'] = 1;
				$t1['result'] =$userdata;
				$t1['message'] = 'Logged in successfully.';	
				
			}
			else
			{
			$condition = array ('email' => $email,'status'=>'Inactive');
			$checkUser1 = $this->user_model->get_all_details ( USERS, $condition );
			if ($checkUser1->num_rows () == '1') 
			{
				$t1['message'] = 'Your Account is Inactive';
				$t1['status'] = 0;
			}
			else  
			{
				$t1['message'] = 'Email not exist with system';
				$t1['status'] = 0;	
			}
			}			

		
		echo json_encode ( $t1 );
	}
	
	public function save_review()
	{   
		#print_r($_POST);die;
		$email=$_POST['email'];
		$booking_id=$_POST['booking_id'];
		$review_star=$_POST['review_star']==""?1:$_POST['review_star']; 
		$comments=$_POST['comments'];
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{     
			    $get_booking_info=$this->mobile_model->get_all_details(BOOKING,array('id'=>$booking_id));
				$review_check=$this->mobile_model->get_all_details(REVIEWS,array('booking_id'=>$booking_id));
				if($review_check->num_rows()==0){
					$review_array=array('booking_id'=>$booking_id,'user_id'=>$get_booking_info->row()->user_id,'tasker_id'=>$get_booking_info->row()->tasker_id,'rate_val'=>$review_star,'comments'=>$comments);
					$notification=$this->user_model->simple_insert(REVIEWS,$review_array);
					$t1['status']=1;
					$t1['message']="Review added successfully.";
				}
				else
				{
					$t1['status']=0;
				    $t1['message']="You already reviewed.";
				}
			 		
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Email id is not found.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
		
	public function inbox()
	{   
		#print_r($_POST);die;
		$email=$_POST['email'];
		
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{       $message_array=array();
				$id=$t->row()->id;
			    $message_list=$this->mobile_model->get_message_list($id); #echo $this->db->last_query();
				$t= $this->user_model->get_unread_message($id); 
				if($t->num_rows()>0)
				{
					$t1['unreadmessage_count'] =$t->row()->unreadmessage_count;
				}
				else
				{
					$t1['unreadmessage_count']= '0';
				}
				
				if($message_list->num_rows()>0){
					foreach($message_list->result() as $mess){ #echo '<pre>'; print_r($mess);
						if($mess->photo!='')
						{
							$pro_pic=base_url().'images/site/profile/'.$mess->photo;
						}
						else
						{
							$pro_pic=base_url().'images/site/profile/avatar.png';
						}
						
						$message_array[]=array('name'=>$mess->first_name,'profile_image'=>$pro_pic,'task_name'=>$mess->task_name,'created_time'=>date('h:i a',strtotime($mess->msg_time)),'message'=>$mess->msg,'booking_id'=>$mess->booking_id);
					}
					$t1['status']=1;
					
					$t1['message_list']=$message_array;
					
				}
				else
				{
					$t1['status']=0;
				    $t1['message']="No Message found.";
				}
			 		
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Email id is not found.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function unreadmessage_count()
	{   
		#print_r($_POST);die;
		$email=$_POST['email'];
		
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{       $message_array=array();
				$id=$t->row()->id;
			    $t= $this->user_model->get_unread_message($id); 
				if($t->num_rows()>0)
				{
					$t1['unreadmessage_count'] =$t->row()->unreadmessage_count;
					$t1['status']=1;
				}
				else
				{
					$t1['unreadmessage_count']= '0';
					$t1['status']=0;
				   
				}
				
			 		
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Email id is not found.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function chat_inner()
	{   
		#print_r($_POST);die;
		$email=$_POST['email'];
		
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{       $message_array=array();
				$id=$t->row()->id;
				$booking_id=$_POST['booking_id'];
			    $ptask=$this->mobile_model->get_completed_task_info($booking_id)->row();
			    $message_list=$this->mobile_model->get_all_details(NOTIFICATION,array('booking_id'=>$booking_id));
				
				if($ptask->photo!='')
				{
					$pro_pic=base_url().'images/site/profile/'.$ptask->photo;
				}
				else
				{
					$pro_pic=base_url().'images/site/profile/big_avatar.png';
				}
				if($ptask->booking_time==0)
				{
					$btime="I'M FLEXIBLE";
				}
				else if($ptask->booking_time==1)
				{
					$btime='MORNING 8am - 12pm';
				}
				else if($ptask->booking_time==2)
				{
					$btime='AFTERNOON 12pm - 4pm';
				}
				else if($ptask->booking_time==3)
				{
					$btime='EVENING 4pm - 8pm';
				}
				
				$booking_info=array('booking_id'=>$ptask->booking_id,'tasker_id'=>$ptask->tasker_id,'first_name'=>$ptask->first_name,'last_name'=>$ptask->last_name,'pro_pic'=>$pro_pic,'cat_name'=>$ptask->task_name,'subcat_name'=>$ptask->subcat_name,'booking_day'=>date('d',strtotime($ptask->booking_date)),'booking_month'=>date('M',strtotime($ptask->booking_date)),'booking_time'=>$btime,'need_vehicle'=>$ptask->veh_name,'city'=>$ptask->address,'total_amount'=>$ptask->total_amount,'currency_code'=>'USD',"currency_symbol"=>'$','status'=>$ptask->status);
				$t1['booking_info']=$booking_info;		
				$t1['chat_user_info']=array('name'=>$ptask->first_name,'profile_image'=>$pro_pic,'city'=>$ptask->address);		
							
				if($message_list->num_rows()>0){
					foreach($message_list->result() as $mess){ #echo '<pre>'; print_r($mess);
												
						if($id==$mess->viewer_id)
						{
							$position="right";
						}
						else
						{
							$position="left";
						}
						$message_array[]=array('message'=>$mess->message,'position'=>$position,'booking_id'=>$mess->booking_id,'created_time'=>date('h:i a',strtotime($mess->msg_time)));
					}
					$t1['status']=1;
					
					$t1['chat_messages']=$message_array;
					
				}
				else
				{
					$t1['status']=0;
				    $t1['message']="No Message found.";
				}
			 		
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Email id is not found.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function test_push_notification()
	{   #header('Content-Type: text/html; charset=utf-8');
		$headers = apache_request_headers(); #echo phpinfo();
		echo '<pre>'.$headers['Test']; print_r($headers);die;
		
		$this->push_notification_user('044A396BA92C8001434211658293311977516840D3CEA01C','TEST');
	}
	
	public function send_message()
	{   
		#print_r($_POST);die;
		$email=$_POST['email'];
		
		$t=$this->mobile_model->get_all_details(USERS,array('email'=>$email)); 
		if($t->num_rows()==1)
		{       
			$id=$t->row()->id;
			$booking_id=$_POST['booking_id'];
			$booking_details=$this->mobile_model->get_all_details(BOOKING,array('id'=>$booking_id,'user_id'=>$id));
			if($booking_details->num_rows()==1)
			{
				$user_id=$booking_details->row()->tasker_id;
			}
			else
			{
				$booking_details=$this->mobile_model->get_all_details(BOOKING,array('id'=>$booking_id));
				$user_id=$booking_details->row()->user_id;
			}
			
			$message=strip_tags($_POST['message']);
			$msg_array=array('title'=>"New Message",'message'=>$message,'viewer_id'=>$user_id,'message_status'=>'1','viewer_status'=>'1','user_id'=>$id,'booking_id'=>$booking_id);
			$this->data['message_list']=$this->user_model->simple_insert(NOTIFICATION,$msg_array);
			$t1['status'] =1;
			$t1['message'] = 'Successfully message sent.';
			 		
		}
		else
		{
			$t1['status'] =0;
			$t1['message'] = 'Email id is not found.';
		 	
		}
		
		
	    echo json_encode($t1);
    }
	
	public function upload_profile_picture_new(){
	            $user_id=$_POST['user_id'];	       
	            $email=$_POST['email'];	       
	            $first_name=$_POST['first_name'];	       
	            $last_name=$_POST['last_name'];	       
	            $phone=$_POST['phone'];	       
	            $zipcode=$_POST['zipcode'];	       
				$config['overwrite'] = FALSE;
				$config['remove_spaces'] = TRUE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['max_width']  = '1600';
				$config['max_height']  = '1600';
				$config['upload_path'] = './images/site/profile';
				$this->load->library('upload', $config);
				$check=$this->user_model->get_all_details(USERS,array('id!='=>$user_id,'email'=>$email));
				if($check->num_rows()==0){
				$dataarray1 = array('first_name'=>$first_name,'last_name'=>$last_name,'phone'=>$phone,'zipcode'=>$zipcode,'email'=>$email);
			    $this->user_model->update_details(USERS,$dataarray1,array('id'=>$user_id));
				$t1['status']=1;
				$t1['message']='Your info saved successfully...';
				if($this->upload->do_upload('upload_profile_picture')){
					$imgDetailsd = $this->upload->data();
					$dataarray = array('photo'=>$imgDetailsd['file_name']);
					$this->user_model->update_details(USERS,$dataarray,array('id'=>$user_id));
					$t1['status']=1;
					$t1['message']='Profile picture changed successfully...';
					
				}
				}
				else
				{
				$t1['status']=0;
				$t1['message']='Email id already exist,try new one.';	
				}
				
				
				$user=$this->user_model->get_all_details(USERS,array('id'=>$user_id))->row(); 
				$img=$user->photo!=''?$user->photo:'avatar.png';
				$userdata = array (
						'user_id' => $user->id,
						'first_name' => $user->first_name,
						'last_name' => $user->last_name,
						'pro_pic'=> base_url().'images/site/profile/'.$img,
						'email' => $user->email,
						'phone' => $user->phone,
						'zipcode' => $user->zipcode,
						'group'=> $user->group
				);
				if($user->group=="1"){
				$tasker_step=0;
				if($user->tasker_step2=="0")
				{
					$tasker_step=1;
				}
				else if($user->tasker_step3=="0")
				{
					$tasker_step=2;
				}
				else if($user->tasker_step4=="0")
				{
					$tasker_step=3;
				}
				else
				{
					$tasker_step=0;
				}
				$userdata = array (
						'user_id' => $user->id,
						'first_name' => $user->first_name,
						'last_name' => $user->last_name,
						'pro_pic'=> base_url().'images/site/profile/'.$img,
						'email' => $user->email,
						'phone' => $user->phone,
						'zipcode' => $user->zipcode,
						'group'=> $user->group,
						'tasker_step'=>$tasker_step
				);
				}
				
				$t1['pro_pic']=base_url().'images/site/profile/'.$img;
				$t1['result'] =$userdata;
			
			echo json_encode ( $t1 );
	
	}
	
	
	
	

	
}
