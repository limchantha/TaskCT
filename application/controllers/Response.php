<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Response extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('response_model');
		$url = base_url();
		//$headerStringValue 	= get_headers($url);
		//echo '<pre>';print_r($headerStringValue);exit;
	/* 	$device_id 		= $headerStringValue['device_id'];
		$device_type 	= $headerStringValue['device_type'];
		$pictus_key 	= $headerStringValue['pictus_key'];
		if($pictus_key!='#pictusteam$'){
			echo 'Invalid response.!';exit;
		} */
	}
	
	public function category_details()
	{   
		$task_info 	= $this->response_model->get_category();
		if($task_info->num_rows() > 0){
			foreach($task_info->result() as $row){
				$condition  = array('status'=>'active','task_name'=>$row->task_name);
				$task_info 	= $this->response_model->get_all_details(TASKER_CATEGORY,$condition);
				$sub_cat	= array();
				//$service_img = './images/service_img/'.$row->task_name.'/50x50.png';
				$service_img = base_url().'images/service_img/Handyman/25x25.png';
				/* if(file_exists($service_img)){
					$service_img = base_url().'images/service_img/'.$row->task_name.'/50x50.png';
				}else{
					$service_img = base_url().'images/service_img/noimg.png';
				} */
					
				foreach($task_info->result() as $row){
					if($row->image!=''){
						$cat_img = base_url().'images/site/category/'.$row->image;
					}else{
						$cat_img = base_url().'images/service_img/noimg.png';
					}
					$sub_cat[] = array('id' => $row->id,'task_title' => $row->task_title,'avg_price' => $row->avg_price,'currency_code'=>'USD','image' => $cat_img);	
				}
				$result[] = array('category'=>$row->task_name,'category_image'=>$service_img,'title'=>$sub_cat);	
			}
			$status 	= '1';
			$message	= 'Task information.!';
		}else{
			$result = array();
			$status 	= '0';
			$message	= 'No Data Available.!';
		}
		echo json_encode(array("status" => $status,"message" => $message ,"response"=>$result));
	}
	
	public function register(){
		$data  		= $_POST;
		$ctrldata 	= $this->response_model->register($data);
		$jsonReturn['status'] 	= $ctrldata['flag'];
		$jsonReturn['message'] 	= $ctrldata['msg'];
		$jsonReturn['otp'] 		= $ctrldata['otp'];
		$jsonReturn['response'] = $ctrldata['response'];
		echo json_encode($jsonReturn);
	}
	
	public function resend_otp()
	{
		$data 					= $this->input->post();
		$ctrldata 				= $this->response_model->resend_otp($data);
		$jsonReturn['status'] 	= $ctrldata['flag'];
		$jsonReturn['message'] 	= $ctrldata['msg'];
		$jsonReturn['response'] = $ctrldata['response'];
		echo json_encode($jsonReturn);
	}
	
	public function check_login()
	{
		$data = $this->input->post();
		$ctrldata 	= $this->response_model->check_login($data);
		$jsonReturn['status'] 	= $ctrldata['flag'];
		$jsonReturn['message'] 	= $ctrldata['msg'];
		$jsonReturn['response'] = $ctrldata['response'];
		echo json_encode($jsonReturn);
	}
	
	public function profile_update(){
		$user_id  			= urldecode($_POST['user_id']);
		$user_name   		= urldecode($_POST['fullname']);
		$phone_no   		= urldecode($_POST['phone_no']);
		$email_id   		= urldecode($_POST['email_id']);
		$zipcode   			= urldecode($_POST['zipcode']);
		
		$query 	= "SELECT * FROM ".USERS." WHERE id='".$user_id."' AND  email = '".$email_id."'";
		$result_data 	= $this->db->query($query);
		$rows = $result_data->num_rows();
		if($rows > 0){
			$imgname = '';
        	if(isset($_FILES['image'])){
				$uploaddir  = "images/site/profile/";
				$data 		= file_get_contents($_FILES['image']['tmp_name']);
				$image 		= imagecreatefromstring($data);
				$imgname	= $user_id.".jpg";
				imagejpeg($image,$uploaddir.$imgname);
			}	
			$date_arr	= array('first_name' => $user_name,'phone' => $phone_no,'email' => $email_id,'zipcode' => $zipcode,'photo' => $imgname);
			$condition = array('id' => $user_id);
			$this->response_model->update_details(USERS,$date_arr,$condition);
			
			$query 	= 'SELECT * FROM '.USERS.' WHERE id='.$user_id;
			$result_data 	= $this->db->query($query);
			#echo '<pre>';print_r($result_data->result());exit;
			if($result_data->row()->photo !=''){
				$user_image = base_url ().'images/site/profile/'.$result_data->row()->photo;
			}else{
				$user_image = base_url ().'images/site/profile/avatar.png';
			}
			$jsonReturn['status'] 		= '1';
			$jsonReturn['message'] 		= 'Profile update successfully';
			$jsonReturn['response']		= array('user_id'=>$user_id,'user_image'=>$user_image,'username'=>$user_name,'phone'=>$phone_no,'email'=>$email_id,'zipcode'=>$zipcode);
		}else{
			$jsonReturn['status'] 	= '0';
			$jsonReturn['message'] 	= 'Invalid User Details.!';
			$jsonReturn['response'] = '' ; 
		}
		echo json_encode($jsonReturn);
	}
	
	public function change_password(){
		$user_id  			= urldecode($_POST['user_id']);
		$current_pwd  		= urldecode($_POST['current_password']);
		$new_pwd  			= urldecode($_POST['new_password']);
		$pwd 				= md5($current_pwd);
		
		$query 				= "SELECT * FROM ".USERS." WHERE id='".$user_id."' and password='".$pwd."'";
		$result_data 		= $this->db->query($query);
		$rows 				= $result_data->num_rows();
		if($rows > 0){
			$password = md5($new_pwd);
			$date_arr= array('password' => $password);
			$condition = array('id' => $user_id);
			$this->response_model->update_details(USERS,$date_arr,$condition);
			$jsonReturn['status'] 	= '1';
			$jsonReturn['message'] 	= 'Password changed successfully';
		}else{
			$jsonReturn['status'] 	= '0';
			$jsonReturn['message'] 	= 'Invalid User Details.!';
		}
		echo json_encode($jsonReturn);
	}
	
}
