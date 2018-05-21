<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#error_reporting(E_ALL); ini_set('display_errors', '1');

class Mail_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
		error_reporting(0);
	}

	public function send_user_password($pwd = '', $username,$email) {
		$newsid = '1';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
        if(count($template_values)==1){ 
		$template_values=$template_values[0];
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo']
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => '',
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
		
	}
	function task_booking_info($id)
	{
		$this->db->select('t.first_name as tfirst_name,u.device_id as udevice_id,u.device_type as udevice_type,t.device_id as tdevice_id,t.device_type as tdevicetype,u.task_email as utask_email,t.task_email as ttask_email,t.email as temail,u.email as uemail,u.first_name as ufirst_name,b.*,c.task_name,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id');
		$this->db->join(USERS.' as u','u.id=b.user_id');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id');
		$this->db->where('b.id',$id);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	public function send_booking_emails($bid) { 
		
		try{
		$this->send_user_booking_confirmation($bid);
		$this->send_tasker_booking_confirmation($bid); 
		}
		catch(Exception $e) { }
	}
	public function send_user_booking_confirmation($bid)
	{
		$newsid = '2';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		$booking_info = $this->mail_model->task_booking_info ( $bid );
        if(count($template_values)==1 && $booking_info->row()->utask_email==1){ 
		$template_values=$template_values[0];
		$email=$booking_info->row()->uemail;
		$sub_price=$booking_info->row()->total_amount-$booking_info->row()->service_fee;
		if($booking_info->row()->booking_time==0){$service_time= 'Flexible';}
		else if($booking_info->row()->booking_time==1){$service_time= 'MORNING 8am - 12pm';}
		else if($booking_info->row()->booking_time==2){$service_time= 'AFTERNOON 12pm - 4pm';}
		else{$service_time= 'EVENING 4pm - 8pm';}
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$booking_info->row()->ufirst_name,
				'tasker_name'=>$booking_info->row()->tfirst_name,
				'sub_price'=>$sub_price,
				'service_fee'=>$booking_info->row()->service_fee,
				'total'=>$booking_info->row()->total_amount,
				'service_name'=>$booking_info->row()->task_name,
				'subcat_name'=>$booking_info->row()->subcat_name,				
				'bdate'=>date('d-m-Y',strtotime($booking_info->row()->booking_date)),
				'service_time'=>$service_time,
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => $admin_email,
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}	
	
	public function send_tasker_booking_confirmation($bid)
	{
		$newsid = '3';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		$booking_info = $this->mail_model->task_booking_info ( $bid );
		if($booking_info->row()->tdevice_id!="" && $booking_info->row()->tdevicetype!="")
		{
			if($booking_info->row()->tdevicetype=="ios")
			{
				$msg="You got request from ".$booking_info->row()->ufirst_name." with message ".substr($booking_info->row()->task_description,0,30);
				$this->push_notification_tasker_ios($booking_info->row()->tdevice_id,$msg,"pending_task");
			}
			else
			{
				$msg="You got request from ".$booking_info->row()->ufirst_name." with message ".substr($booking_info->row()->task_description,0,30);
				$this->push_notification_tasker_android($booking_info->row()->tdevice_id,$msg,"pending_task");
			}
		}
        if(count($template_values)==1 && $booking_info->row()->ttask_email==1){ 
		$template_values=$template_values[0];
		$email=$booking_info->row()->temail;
		$sub_price=$booking_info->row()->total_amount-$booking_info->row()->service_fee;
		if($booking_info->row()->booking_time==0){$service_time= 'Flexible';}
		else if($booking_info->row()->booking_time==1){$service_time= 'MORNING 8am - 12pm';}
		else if($booking_info->row()->booking_time==2){$service_time= 'AFTERNOON 12pm - 4pm';}
		else{$service_time= 'EVENING 4pm - 8pm';}
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$booking_info->row()->ufirst_name,
				'tasker_name'=>$booking_info->row()->tfirst_name,
				'sub_price'=>$sub_price,
				'service_fee'=>$booking_info->row()->service_fee,
				'total'=>$booking_info->row()->total_amount,
				'service_name'=>$booking_info->row()->task_name,
				'subcat_name'=>$booking_info->row()->subcat_name,
				'bdate'=>date('d-m-Y',strtotime($booking_info->row()->booking_date)),
				'service_time'=>$service_time,
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => $admin_email,
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	public function send_booking_respond_emails($bid) { 
		
		try{
		$this->send_user_respond_email($bid);
		$this->send_tasker_respond_email($bid);
		}catch(Exception $e) { }
	}
	public function send_user_respond_email($bid)
	{
		$newsid = '4';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		$booking_info = $this->mail_model->task_booking_info ( $bid );
		if($booking_info->row()->tdevice_id!="" && $booking_info->row()->tdevicetype!="")
		{
			if($booking_info->row()->tdevicetype=="ios")
			{   
		        $status=$booking_info->row()->status=="Accept"?"Accepted":"Declined"; 
				$msg="Your task request ".$status." by ".$booking_info->row()->tfirst_name;
				$this->push_notification_user_ios($booking_info->row()->tdevice_id,$msg,"approved_task");
			}
			else
			{
				$msg="Your task request ".$status." by ".$booking_info->row()->tfirst_name;
				$this->push_notification_user_android($booking_info->row()->tdevice_id,$msg,"approved_task");
			}
		}
        if(count($template_values)==1 && $booking_info->row()->utask_email==1){ 
		$template_values=$template_values[0];
		$email=$booking_info->row()->uemail;
		$sub_price=$booking_info->row()->total_amount-$booking_info->row()->service_fee;
		if($booking_info->row()->booking_time==0){$service_time= 'Flexible';}
		else if($booking_info->row()->booking_time==1){$service_time= 'MORNING 8am - 12pm';}
		else if($booking_info->row()->booking_time==2){$service_time= 'AFTERNOON 12pm - 4pm';}
		else{$service_time= 'EVENING 4pm - 8pm';}
		if($booking_info->row()->status=="Accept"){$status= 'Accepted';}
		else if($booking_info->row()->status=="Declined"){$status= 'Declined';}
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$booking_info->row()->ufirst_name,
				'tasker_name'=>$booking_info->row()->tfirst_name,
				'sub_price'=>$sub_price,
				'service_fee'=>$booking_info->row()->service_fee,
				'total'=>$booking_info->row()->total_amount,
				'service_name'=>$booking_info->row()->task_name,
				'subcat_name'=>$booking_info->row()->subcat_name,
				'bdate'=>date('d-m-Y',strtotime($booking_info->row()->booking_date)),
				'service_time'=>$service_time,
				'status'=>$status
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => $admin_email,
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	public function send_tasker_respond_email($bid)
	{
		$newsid = '5';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		$booking_info = $this->mail_model->task_booking_info ( $bid );
        if(count($template_values)==1 && $booking_info->row()->ttask_email==1){ 
		$template_values=$template_values[0];
		$email=$booking_info->row()->temail;
		$sub_price=$booking_info->row()->total_amount-$booking_info->row()->service_fee;
		if($booking_info->row()->booking_time==0){$service_time= 'Flexible';}
		else if($booking_info->row()->booking_time==1){$service_time= 'MORNING 8am - 12pm';}
		else if($booking_info->row()->booking_time==2){$service_time= 'AFTERNOON 12pm - 4pm';}
		else{$service_time= 'EVENING 4pm - 8pm';}
		if($booking_info->row()->status=="Accept"){$status= 'Accepted';}
		else if($booking_info->row()->status=="Declined"){$status= 'Declined';}
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$booking_info->row()->ufirst_name,
				'tasker_name'=>$booking_info->row()->tfirst_name,
				'sub_price'=>$sub_price,
				'service_fee'=>$booking_info->row()->service_fee,
				'total'=>$booking_info->row()->total_amount,
				'service_name'=>$booking_info->row()->task_name,
				'subcat_name'=>$booking_info->row()->subcat_name,
				'bdate'=>date('d-m-Y',strtotime($booking_info->row()->booking_date)),
				'service_time'=>$service_time,
				'status'=>$status
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => $admin_email,
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	public function send_booked_emails($bid) { 
		try{
		$this->send_booked_email_user($bid);
		$this->send_booked_email_tasker($bid);
		}
		catch(Exception $e) { }
	}
	public function send_booked_email_user($bid)
	{
		$newsid = '6';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		$booking_info = $this->mail_model->task_booking_info ( $bid );
        if(count($template_values)==1 && $booking_info->row()->utask_email==1){ 
		$template_values=$template_values[0];
		$email=$booking_info->row()->uemail;
		$sub_price=$booking_info->row()->total_amount-$booking_info->row()->service_fee;
		if($booking_info->row()->booking_time==0){$service_time= 'Flexible';}
		else if($booking_info->row()->booking_time==1){$service_time= 'MORNING 8am - 12pm';}
		else if($booking_info->row()->booking_time==2){$service_time= 'AFTERNOON 12pm - 4pm';}
		else{$service_time= 'EVENING 4pm - 8pm';}
		if($booking_info->row()->status=="Accept"){$status= 'Accepted';}
		else if($booking_info->row()->status=="Declined"){$status= 'Declined';}
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$booking_info->row()->ufirst_name,
				'tasker_name'=>$booking_info->row()->tfirst_name,
				'sub_price'=>$sub_price,
				'service_fee'=>$booking_info->row()->service_fee,
				'total'=>$booking_info->row()->total_amount,
				'service_name'=>$booking_info->row()->task_name,
				'subcat_name'=>$booking_info->row()->subcat_name,
				'bdate'=>date('d-m-Y',strtotime($booking_info->row()->booking_date)),
				'service_time'=>$service_time,
				'status'=>$status
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => $admin_email,
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	public function send_booked_email_tasker($bid)
	{
		$newsid = '7';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		$booking_info = $this->mail_model->task_booking_info ( $bid );
		if($booking_info->row()->tdevice_id!="" && $booking_info->row()->tdevicetype!="")
		{
			if($booking_info->row()->tdevicetype=="ios")
			{
				$msg="Thanks for your great work ".$booking_info->row()->tfirst_name;
				$this->push_notification_tasker_ios($booking_info->row()->tdevice_id,$msg,"completed_task");
			}
			else
			{
				$msg="Thanks for your great work ".$booking_info->row()->tfirst_name;
				$this->push_notification_tasker_android($booking_info->row()->tdevice_id,$msg,"completed_task");
			}
		}
        if(count($template_values)==1 && $booking_info->row()->ttask_email==1){ 
		$template_values=$template_values[0];
		$email=$booking_info->row()->temail;
		$sub_price=$booking_info->row()->total_amount-$booking_info->row()->service_fee;
		if($booking_info->row()->booking_time==0){$service_time= 'Flexible';}
		else if($booking_info->row()->booking_time==1){$service_time= 'MORNING 8am - 12pm';}
		else if($booking_info->row()->booking_time==2){$service_time= 'AFTERNOON 12pm - 4pm';}
		else{$service_time= 'EVENING 4pm - 8pm';}
		if($booking_info->row()->status=="Accept"){$status= 'Accepted';}
		else if($booking_info->row()->status=="Declined"){$status= 'Declined';}
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$booking_info->row()->ufirst_name,
				'tasker_name'=>$booking_info->row()->tfirst_name,
				'sub_price'=>$sub_price,
				'service_fee'=>$booking_info->row()->service_fee,
				'total'=>$booking_info->row()->total_amount,
				'service_name'=>$booking_info->row()->task_name,
				'subcat_name'=>$booking_info->row()->subcat_name,
				'bdate'=>date('d-m-Y',strtotime($booking_info->row()->booking_date)),
				'service_time'=>$service_time,
				'status'=>$status
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => $admin_email,
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	public function cancel_emails($bid,$cancel_amount) { 
		
		try{
		$this->cancel_booked_email_user($bid,$cancel_amount);
		$this->cancel_booked_email_tasker($bid,$cancel_amount); 
		}
		catch(Exception $e) { }
	}
	public function cancel_booked_email_user($bid,$cancel_amount)
	{
		$newsid = '8';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		$booking_info = $this->mail_model->task_booking_info ( $bid );
        if(count($template_values)==1 && $booking_info->row()->utask_email==1){ 
		$template_values=$template_values[0];
		$email=$booking_info->row()->uemail;
		$sub_price=$booking_info->row()->total_amount-$booking_info->row()->service_fee;
		if($booking_info->row()->booking_time==0){$service_time= 'Flexible';}
		else if($booking_info->row()->booking_time==1){$service_time= 'MORNING 8am - 12pm';}
		else if($booking_info->row()->booking_time==2){$service_time= 'AFTERNOON 12pm - 4pm';}
		else{$service_time= 'EVENING 4pm - 8pm';}
		if($booking_info->row()->status=="Accept"){$status= 'Accepted';}
		else if($booking_info->row()->status=="Declined"){$status= 'Declined';}
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$booking_info->row()->ufirst_name,
				'tasker_name'=>$booking_info->row()->tfirst_name,
				'sub_price'=>$sub_price,
				'service_fee'=>$booking_info->row()->service_fee,
				'total'=>$booking_info->row()->total_amount,
				'service_name'=>$booking_info->row()->task_name,
				'subcat_name'=>$booking_info->row()->subcat_name,
				'bdate'=>date('d-m-Y',strtotime($booking_info->row()->booking_date)),
				'service_time'=>$service_time,
				'status'=>$status,
				'camount'=>$cancel_amount/100
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => $admin_email,
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	public function cancel_booked_email_tasker($bid,$cancel_amount)
	{
		$newsid = '9';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		$booking_info = $this->mail_model->task_booking_info ( $bid );
		if($booking_info->row()->tdevice_id!="" && $booking_info->row()->tdevicetype!="")
		{
			if($booking_info->row()->tdevicetype=="ios")
			{
				$msg="Task cancelled by ".$booking_info->row()->ufirst_name;
				$this->push_notification_tasker_ios($booking_info->row()->tdevice_id,$msg,"cancelled_task");
			}
			else
			{
				$msg="Task cancelled by ".$booking_info->row()->ufirst_name;
				$this->push_notification_tasker_android($booking_info->row()->tdevice_id,$msg,"cancelled_task");
			}
		}
        if(count($template_values)==1 && $booking_info->row()->ttask_email==1){ 
		$template_values=$template_values[0];
		$email=$booking_info->row()->temail;
		$sub_price=$booking_info->row()->total_amount-$booking_info->row()->service_fee;
		if($booking_info->row()->booking_time==0){$service_time= 'Flexible';}
		else if($booking_info->row()->booking_time==1){$service_time= 'MORNING 8am - 12pm';}
		else if($booking_info->row()->booking_time==2){$service_time= 'AFTERNOON 12pm - 4pm';}
		else{$service_time= 'EVENING 4pm - 8pm';}
		if($booking_info->row()->status=="Accept"){$status= 'Accepted';}
		else if($booking_info->row()->status=="Declined"){$status= 'Declined';}
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$booking_info->row()->ufirst_name,
				'tasker_name'=>$booking_info->row()->tfirst_name,
				'sub_price'=>$sub_price,
				'service_fee'=>$booking_info->row()->service_fee,
				'total'=>$booking_info->row()->total_amount,
				'service_name'=>$booking_info->row()->task_name,
				'subcat_name'=>$booking_info->row()->subcat_name,
				'bdate'=>date('d-m-Y',strtotime($booking_info->row()->booking_date)),
				'service_time'=>$service_time,
				'camount'=>$cancel_amount/100,
				'status'=>$status
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => $admin_email,
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	
	    public function send_contact_mail($new_array)
		{
			$this->send_contact_admin($new_array);
			$this->send_contact_user($new_array);
		}
	
		public function send_contact_admin($new_array) {
		$newsid = '10';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
        if(count($template_values)==1){ 
		$template_values=$template_values[0];
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'message' =>$new_array['message'],
				'name' => $new_array['name'],
				'mobile' =>$new_array['mobile'],
				'email' => $new_array['email'],
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo']
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
        
		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $sender_email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => '',
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
		
	}
	public function send_contact_user($new_array) {
		$newsid = '11';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
        if(count($template_values)==1){ 
		$template_values=$template_values[0];
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'message' =>$new_array['message'],
				'name' => $new_array['name'],
				'mobile' =>$new_array['mobile'],
				'email' => $new_array['email'],
				'logo' => $this->data['logo']
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $new_array['email'],
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => '',
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
		
	}
	
	public function tasker_registration_email($user)
	{
		$this->tasker_registration_email_to_admin($user);
		$this->tasker_registration_email_to_user($user);
	}
	public function tasker_registration_email_to_admin($user)
	{
		$newsid = '12';$message='';
		$approve_link=base_url()."admin/tasker/change_tasker_completed/".$user->id."/1";
		$template_values = $this->user_model->get_template_details ( $newsid );  
		if(count($template_values)==1){ 
		$template_values=$template_values[0];
		$email=$user->email;
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$user->first_name,
				'approve_link'=>$approve_link
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $sender_email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => '',
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	public function tasker_registration_email_to_user($user)
	{
		$newsid = '13';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		if(count($template_values)==1){ 
		$template_values=$template_values[0];
		$email=$user->email;
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$user->first_name,
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => '',
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
		public function admin_task_approval($user)
	{
		$newsid = '14';$message='';
		$template_values = $this->user_model->get_template_details ( $newsid );  
		if(count($template_values)==1){ 
		$template_values=$template_values[0];
		$email=$user->email;
		$adminnewstemplateArr = array (
				'email_title' => $this->config->item ( 'site_name' ),
				'site_name' => $this->config->item ( 'site_name' ),
				'logo' => $this->data['logo'],
				'username'=>$user->first_name,
				
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['subject'] . '</title>
			<body>';
		include ('./email/email' . $newsid . '.php');

		$message .= '</body>
			</html>';

		$sender_name = $this->config->item ( 'site_name' );
		$sender_email = $this->config->item ( 'admin_email' );
		$admin_email = $this->config->item ( 'admin_email' );

		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $email,
				'subject_message' => $template_values ['subject'],
				'cc_mail_id' => '',
				'body_messages' => $message
		);
       
		$email_send_to_common = $this->user_model->common_email_send ( $email_values );
        }
	}
	
	public function send_feedback($bid)
	{
		try{
		$booking_info = $this->mail_model->task_booking_info ( $bid );
		if($booking_info->row()->tdevice_id!="" && $booking_info->row()->tdevicetype!="")
		{
			if($booking_info->row()->tdevicetype=="ios")
			{
				$msg="You got a feedback from ".$booking_info->row()->ufirst_name;
				$this->push_notification_tasker_ios($booking_info->row()->tdevice_id,$msg,"completed_task");
			}
			else
			{
				$msg="You got a feedback from ".$booking_info->row()->ufirst_name;
				$this->push_notification_tasker_android($booking_info->row()->tdevice_id,$msg,"completed_task");
			}
		}
		}
		catch(Exception $e) { }

	}
	public function send_message_push_user($bid,$msg)
	{
		try{
		$booking_info = $this->mail_model->task_booking_info ( $bid );
		if($booking_info->row()->tdevice_id!="" && $booking_info->row()->tdevicetype!="")
		{
			if($booking_info->row()->tdevicetype=="ios")
			{    
				$msg=$booking_info->row()->tfirst_name.': '.$msg;
				$this->push_notification_user_ios($booking_info->row()->tdevice_id,$msg,"chat_message");
			}
			else
			{
				$msg=$booking_info->row()->tfirst_name.': '.$msg;
				$this->push_notification_user_android($booking_info->row()->tdevice_id,$msg,"chat_message");
			}
		}
		}
		catch(Exception $e) { }

	}
	public function send_message_push_tasker($bid,$msg)
	{
		try{
		$booking_info = $this->mail_model->task_booking_info ( $bid );
		if($booking_info->row()->tdevice_id!="" && $booking_info->row()->tdevicetype!="")
		{
			if($booking_info->row()->tdevicetype=="ios")
			{
				$msg=$booking_info->row()->ufirst_name.': '.$msg;
				$this->push_notification_tasker_ios($booking_info->row()->tdevice_id,$msg,"completed_task");
			}
			else
			{
				$msg=$booking_info->row()->ufirst_name.': '.$msg;
				$this->push_notification_tasker_android($booking_info->row()->tdevice_id,$msg,"completed_task");
			}
		}
		}
		catch(Exception $e) { }

	}
	
	public function push_notification_user_ios($deviceId,$message,$action){
		if($deviceId!=""){
			$this->load->library('Apns');
			$this->apns->send_push_message_user_new($deviceId,$message,$action); 
		}
	}
	public function push_notification_tasker_ios($deviceId,$message,$action){ 
		if($deviceId!=""){
			$this->load->library('Apns'); 
			$this->apns->send_push_message_tasker_new($deviceId,$message,$action);  
		}
	}
	public function push_notification_user_android($deviceId,$message,$action){
		if($deviceId!=""){
			$this->sendPushNotificationToAndroid($deviceId,$message,$action);
		}
	}
	public function push_notification_tasker_android($deviceId,$message,$action){
		if($deviceId!=""){
			$this->sendPushNotificationToAndroid($deviceId,$message,$action);
		}
	}
	
	/*--Push Notification for IOS--*/
	
	/**
     * This function send the notification for Anriod
     * @param string $registration_ids
     * @param string $message 
     * */
    public function sendPushNotificationToAndroid($registration_ids, $message,$action) {
		
        //Google cloud messaging GCM-API url
       $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,
            'action' => $action,
        );
		// Google Cloud Messaging GCM API Key
	 	define("GOOGLE_API_KEY", "AIzaSyBnTCgx2aoEn2zN-1x46Sk9QWeUCqF7EqQ"); 		
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        //var_dump($result);die;
        return $result;
    } 
	
	public function send_text($to,$message){
		if($to!=""){
			try{
			$this->load->library('Messagebird');			
			$country_code=$this->config->item('messagebird_country_code')==""?"91":$this->config->item('messagebird_country_code');
			$from = $country_code.$this->config->item('messagebird_number');
			$to = $country_code.$to; 
			if($this->config->item('messagebird_username')!="" && $this->config->item('messagebird_password')!=""){
				$sms = new MessageBird($this->config->item('messagebird_username'), $this->config->item('messagebird_password'));
				$sms->setSender($from);
				$sms->addDestination($to);
				if($to!=""){
				$sms->sendSms($message);
				}
			}
			/* $sms->sendSms($message);
			if($sms->getResponseCode()){
				echo 'Error:<pre> '; print_r($sms->getResponseCode());
				echo 'Error:<pre> '; print_r($sms->getResponseMessage());
			}
			else{
				#echo 'Sent message to ' . $to;
			} */
			}
			catch(Exception $e) { }
		}
	}
	
}