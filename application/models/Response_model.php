<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Response_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function check_login($userdata)
	{	
		/* $headerStringValue 	= apache_request_headers();
		$device_type 		= $headerStringValue['device_type'];
		$device_key  		= $headerStringValue['device_key'];
		$lang 				= $headerStringValue['lang']; */
		$email_id  			= urldecode($userdata['email_id']);
		$password  			= md5(urldecode($userdata['password']));
		$this->db->select('*');
		$this->db->from(USERS.' as u');
		$this->db->where('u.email',$email_id);
		$this->db->where('u.password',$password);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$id 		= $query->row()->id;
			#$this->db->set('device_type',$device_type);
			#$this->db->set('device_id',$device_key);
			/* $this->db->set('is_verify',1);
			
			$this->db->where('id',$id);
			$this->db->update(USERS); */
			if(!empty($query->row()->photo)){
				$user_image = base_url().'images/site/profile/'.$query->row()->photo;;
			}else{
				$user_image = base_url().'images/upload_img.png';
			}
			$response = array('user_id'=> $id,'username' => $query->row()->first_name,'email' =>$query->row()->email,'phone' => $query->row()->phone,'user_image' => $user_image,'zipcode' => $query->row()->zipcode);
		
			
			$modeldata['msg']			= 'Successfully Login!';
			$modeldata['flag']			= '1';
			$modeldata['response']		= $response;
		}else{
			$modeldata['msg']			= 'Invalid login details!';
			$modeldata['flag']			= '0';
			$modeldata['response']		= '';
		}
		return $modeldata;
	}
	
	public  function get_category(){
		$query 	= "SELECT * FROM ".TASKER_CATEGORY.' GROUP BY task_name ';
		$rs 	= $this->db->query($query);
		return $rs;	
	}
	
	
	
	public function register($userdata){
		/* $headerStringValue 	= apache_request_headers();
		$device_type 		= $headerStringValue['device_type'];
		$device_key  		= $headerStringValue['device_key'];
		$lang 				= $headerStringValue['lang'];
		 */
		$fullname  			= urldecode($userdata['fullname']);
		$phone_no   		= urldecode($userdata['phone_no']);
		$email_id  			= urldecode($userdata['email_id']);
		$password  			= md5(urldecode($userdata['confirm_password']));
		$zipcode  			= urldecode($userdata['zipcode']);
		$otp_code  			= urldecode($userdata['otp_code']);
		if(empty($otp_code)){
			$query 	= "SELECT id FROM ".USERS." WHERE email='".$email_id."'";
			$rs 	= $this->db->query($query);
			if($rs->num_rows() <= 0){
				$code 			= rand(100000, 999999);
				$this->db->set('first_name',$fullname);
				$this->db->set('phone',$phone_no);
				$this->db->set('email',$email_id);
				$this->db->set('password',$password);
				$this->db->set('zipcode',$zipcode);
				$this->db->set('otp_code',$code);
				#$this->db->set('device_type',$device_type);
				#$this->db->set('device_id',$device_key);
				$this->db->insert(USERS);
				$id = $this->db->insert_id();
				if($id > 0){
					$modeldata['msg']			= 'Successfully save!';
					$modeldata['flag']			= '1';
					$modeldata['otp']			= $code;
					$modeldata['response']		= '';
				}else{		
					$modeldata['msg']			= 'Error on insert';
					$modeldata['flag']			= '0';
					$modeldata['otp']			= '';
					$modeldata['response']		= '';
				}
			}else{
					$modeldata['msg']			= 'You account already registered.!';
					$modeldata['flag']			= '0';
					$modeldata['otp']			= '';
					$modeldata['response']		= '';
			}
		}else{ 
			$query 	= "SELECT id,first_name,phone,email,zipcode FROM ".USERS." WHERE email='".$email_id."' AND otp_code=".$otp_code;
			$rs 	= $this->db->query($query);
			if($rs->num_rows() > 0){
				$modeldata['msg']			= 'Successfully Registerd!';
				$modeldata['flag']			= '1';
				$modeldata['otp']			= $otp_code;
				$user_id 	= $rs->row()->id;
				$username 	= $rs->row()->first_name;
				$phone 		= $rs->row()->phone;
				$email 		= $rs->row()->email;
				$zipcode 	= $rs->row()->zipcode;
				if(!empty($rs->row()->photo)){
					$user_image = base_url().'images/site/profile/'.$rs->row()->photo;;
				}else{
					$user_image = base_url().'images/upload_img.png';
				}
				$modeldata['response']		= array('user_id'=>$user_id,'user_image'=>$user_image,'username'=>$username,'phone'=>$phone,'email'=>$email,'zipcode'=>$zipcode);
			}else{
				$modeldata['msg']			= 'Invalid otp code.!';
				$modeldata['flag']			= '0';
				$modeldata['otp']			= '';
				$modeldata['response']		= '';
			}
		}
		return $modeldata;
	}
	
	public function resend_otp($userdata){
		$email_id 	= urldecode($userdata['email_id']);
		$query 		= "SELECT id FROM ".USERS." WHERE email='".$email_id."'";
		$rs 		= $this->db->query($query);
		if($rs->num_rows() > 0){
			$code 	= rand(100000, 999999);
			$this->db->set('otp_code',$code);
			$this->db->where('id',$rs->row()->id);
			$this->db->update(USERS);
			$modeldata['msg']			= 'Successfully Created OTP!';
			$modeldata['flag']			= '1';
			$modeldata['response']		= $code;
		}else{
			$modeldata['msg']			= 'Invalid Email Id.!';
			$modeldata['flag']			= '0';
			$modeldata['response']		= '';
		}
		return $modeldata;
	}
	
	public function update_profile($userdata){
		
		
	}
	
}