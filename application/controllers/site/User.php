<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('user_model');
		$this->load->model('tasker_model');
		$this->load->model('landing_model');
		$this->load->model('mail_model');
		
    }

	public function user_login()
	{   
		$this->load->library('user_agent');
		$this->session->set_userdata('referrer_url', $this->agent->referrer() ); 
		$this->load->library('facebook'); 
		include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
		$clientId = $this->config->item('gmail_client_id');
        $clientSecret = $this->config->item('gmail_client_secret');
		$redirectUrl = $this->config->item('gmail_redirect_url');
		$gClient = new Google_Client();
        $gClient->setApplicationName('Login to gmtechindia.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
		$this->data['heading']="User Login";
		$this->data['gmail_link']=$gClient->createAuthUrl();
		$this->data['fb_login']=$this->facebook->getLoginUrl(array('display' => 'popup',
                'redirect_uri' => base_url('site/user/fb_response'), 
                'scope' => array("email") ));
		$this->load->view('site/user/user_login',$this->data);
	}
	public function user_signup()
	{
		$this->data['heading']="User Signup";
		$this->load->view('site/user/user_signup',$this->data);
	}
	public function signup_process()
	{   
		$email=$this->input->post('email');
		$t=count($this->user_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
				$_POST['password']=md5($_POST['password']); 
				
				/*otp */
				$_POST['otp']=mt_rand(1000, 9999);	
				
				$this->otp_message($_POST['phone'],$_POST['otp'] );
				/*otp */
				$t=$this->user_model->simple_insert(USERS,$_POST);
       		    $checkUser = $this->user_model->get_all_details(USERS, array('email'=>$email));
				$t1['user_id'] =$checkUser->row ()->id;
			    $userdata = array (
						'gm_user_id' => $checkUser->row ()->id,

						'gm_user_email' => $checkUser->row ()->email
				);
				#$this->session->set_userdata ( $userdata );
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'last_login_date' => mdate ( $datestring, $time ),
						'last_login_ip' => $this->input->ip_address ()
				);
				$condition = array (
						'id' => $checkUser->row ()->id
				);
				$this->user_model->update_details ( USERS, $newdata, $condition );
				
			$t1['result'] ='success';
			
		}
		else
		{
			$t1['result'] = 'error';
		 	
		}
		$t1['redirecturl']='';			
			if($this->session->userData('task_category_id')!='')
			{
				$t1['redirecturl']=base_url().'task_compare/'.$this->session->userData('task_category_id');
			}
	    echo json_encode($t1);
    }
	public function check_email()
	{   $email=$this->input->post('email');
		$t=count($this->user_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}
	
	public function logout() {
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time ();
		$newdata = array (
				'last_logout_date' => mdate ( $datestring, $time )
		);
		$condition = array (
				'id' => $this->checkLogin ( 'U' )
		);
		$this->user_model->update_details( USERS, $newdata, $condition );
		$userdata = array (
				'gm_user_id' => '',
				'gm_user_email' => ''
				);
		$this->session->unset_userdata ( $userdata );
		echo $this->session->set_userdata ('gm_user_id',''); 
		redirect ( base_url () );
	}
	
	public function login_process() {

		$email = $this->input->post ( 'login_email' );
		$pwd = md5 ( $this->input->post ( 'login_password' ) );
		$condition = array (
					'email' => $email,
					'password' => $pwd,
					'status' => 'Active'
			);
		$checkUser = $this->user_model->get_all_details ( USERS, $condition );
		if ($checkUser->num_rows () == '1') {
							
				/*otp */

				$returnStr['otp']=0;
				if($checkUser->row()->otp_verified==0)
				{
					$returnStr['otp']=1;
					$otp=mt_rand(1000, 9999);				
				    $this->otp_message($checkUser->row ()->phone,$otp);
				}
				else
				{
					$userdata = array (
						'gm_user_id' => $checkUser->row ()->id,

						'gm_user_email' => $checkUser->row ()->email
					);
					$this->session->set_userdata ( $userdata );
				}
				/*otp */
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'otp'=>$otp,
						'last_login_date' => mdate ( $datestring, $time ),
						'last_login_ip' => $this->input->ip_address () );
				$condition = array (
						'id' => $checkUser->row ()->id
				);
				$this->user_model->update_details ( USERS, $newdata, $condition );
				$returnStr ['tasker_steps_pending_redirect'] = "";
				$returnStr ['user_id'] = $checkUser->row ()->id;
				
				if($checkUser->row()->group==1)
				{
					if($checkUser->row()->tasker_step1==0)
					{
						$returnStr ['tasker_steps_pending_redirect'] = base_url()."tasker_step1";
					}
					else if($checkUser->row()->tasker_step2==0)
					{
						$returnStr ['tasker_steps_pending_redirect'] = base_url()."tasker_step2/";
					}
					else if($checkUser->row()->tasker_step3==0)
					{
						$returnStr ['tasker_steps_pending_redirect'] = base_url()."tasker_step3/";
					}
					else if($checkUser->row()->tasker_step4==0)
					{
						$returnStr ['tasker_steps_pending_redirect'] = base_url()."tasker_step4/";
					}
				}
				
				
				$returnStr ['status'] = 1;
				
			}
			else
			{
			$condition = array ('email' => $email,'status'=>'Inactive');
			$checkUser1 = $this->user_model->get_all_details ( USERS, $condition );
			if ($checkUser1->num_rows () == '1') 
			{
				$returnStr ['message'] = 'Your Account is Inactive';
				$returnStr ['status'] = 2;
			}
			else  
			{
				$returnStr ['message'] = 'Invalid login details';
				$returnStr ['status'] = 3;	
			}
						}
			$returnStr['redirecturl']='';			
			/* if($this->session->userData('set_back_login_url')!='')
			{
				$returnStr['redirecturl']=$this->session->userData('set_back_login_url');
				$this->session->set_userdata(array('set_back_login_url'=>''));
			}				
			if($this->session->userData('task_category_id')!='')
			{
				$returnStr['redirecturl']=base_url().'task_compare/'.$this->session->userData('task_category_id');
			} */

			if( $this->session->userdata('referrer_url') ) {
			$redirect_back = $this->session->userdata('referrer_url');
			$this->session->unset_userdata('referrer_url');
			$returnStr['redirecturl']=$redirect_back;
		    }	

		
		echo json_encode ( $returnStr );
	}
	
	public function fb_response(){

		$this->load->library('facebook');       
		echo $user = $this->facebook->getUser();
        
        if ($user) {
            try {
                $user_profile = $this->facebook->api('/me/?fields=email,name,id'); 
				$email=$user_profile['email'];
				if($email==""){
					redirect(base_url());
				}
				$t=count($this->user_model->get_single_details(USERS,array('email'),array('email'=>$user_profile['email']))->result());
				if($t<=0)
				{
						
						$filename=now().rand().".jpg";
						$image = file_get_contents("https://graph.facebook.com/".$user_profile['id']."/picture?type=large");
						file_put_contents("images/site/profile/".$filename,$image);					
						$dataarray=array('first_name'=>$user_profile['name'],'email'=>$user_profile['email'],'photo'=>$filename,'facebook'=>$user_profile['id']); 
						/*otp */
						$_POST['otp']=mt_rand(1000, 9999);				
						#$this->otp_message($_POST['phone'],$_POST['otp'] );
						/*otp */
				
						$t=$this->user_model->simple_insert(USERS,$dataarray);
						$checkUser = $this->user_model->get_all_details(USERS, array('email'=>$email));
						$userdata = array (
								'gm_user_id' => $checkUser->row ()->id,

								'gm_user_email' => $checkUser->row ()->email
						);
						#$this->session->set_userdata ( $userdata );
						$datestring = "%Y-%m-%d %h:%i:%s";
						$time = time ();
						$newdata = array (
								'last_login_date' => mdate ( $datestring, $time ),
								'last_login_ip' => $this->input->ip_address ()
						);
						$condition = array (
								'id' => $checkUser->row ()->id
						);
						$this->user_model->update_details ( USERS, $newdata, $condition );
						
						if($checkUser->row()->otp_verified==0)
						{
							redirect(base_url()."site/user/otp_verification/".$checkUser->row()->id."?type=mob");
						}
						
						/* if($this->session->userData('set_back_login_url')!='')
						{
							redirect($this->session->userData('set_back_login_url'));
							$this->session->set_userdata(array('set_back_login_url'=>''));
						}
						if($this->session->userData('task_category_id')!='')
						{
							redirect(base_url().'task_compare/'.$this->session->userData('task_category_id'));
						} */
						if($checkUser->row()->group==1)
						{
							if($checkUser->row()->tasker_step1==0)
							{
								$redirect_back = base_url()."tasker_step1";
								redirect($redirect_back);
							}
							else if($checkUser->row()->tasker_step2==0)
							{
								$redirect_back = base_url()."tasker_step2/";
								redirect($redirect_back);
							}
							else if($checkUser->row()->tasker_step3==0)
							{
								$redirect_back = base_url()."tasker_step3/";
								redirect($redirect_back);
							}
							else if($checkUser->row()->tasker_step4==0)
							{
								$redirect_back= base_url()."tasker_step4/";
								redirect($redirect_back);
							}
							
						}
						
						if( $this->session->userdata('referrer_url') ) {
						$redirect_back = $this->session->userdata('referrer_url');
						$this->session->unset_userdata('referrer_url');
						redirect($redirect_back);
						}	
												
					    redirect(base_url());
				}
				else
				{
					    $checkUser = $this->user_model->get_all_details(USERS, array('email'=>$email));
						if($checkUser->row()->status=="Active")
						{
								
								$datestring = "%Y-%m-%d %h:%i:%s";
								$time = time ();
								$newdata = array (
										'last_login_date' => mdate ( $datestring, $time ),
										'last_login_ip' => $this->input->ip_address ()
								);
								$condition = array (
										'id' => $checkUser->row ()->id
								);
								$this->user_model->update_details ( USERS, $newdata, $condition );
								
								if($checkUser->row()->otp_verified==0)
								{
									$returnStr['otp']=1;
									$otp=mt_rand(1000, 9999);								
									$newdata = array ('otp' => $otp);
									$condition = array ('id' => $checkUser->row ()->id);
								    $this->user_model->update_details ( USERS, $newdata, $condition );
									if($checkUser->row ()->phone!=""){
										$this->otp_message($checkUser->row ()->phone,$otp);
										redirect(base_url()."site/user/otp_verification/".$checkUser->row()->id);
									}
									else
									{
										$this->otp_message($checkUser->row ()->phone,$otp);
										redirect(base_url()."site/user/otp_verification/".$checkUser->row()->id."?type=mob");

									}
								}
								else
								{
									$userdata = array (
										'gm_user_id' => $checkUser->row ()->id,

										'gm_user_email' => $checkUser->row ()->email
									);
									$this->session->set_userdata ( $userdata );
								}
								
								
								
								/* if($this->session->userData('set_back_login_url')!='')
								{
									redirect($this->session->userData('set_back_login_url'));
									$this->session->set_userdata(array('set_back_login_url'=>''));
								}
								if($this->session->userData('task_category_id')!='')
								{
									redirect(base_url().'task_compare/'.$this->session->userData('task_category_id'));
								} */	
								if($checkUser->row()->group==1)
								{
									if($checkUser->row()->tasker_step1==0)
									{
										$redirect_back = base_url()."tasker_step1";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step2==0)
									{
										$redirect_back = base_url()."tasker_step2/";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step3==0)
									{
										$redirect_back = base_url()."tasker_step3/";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step4==0)
									{
										$redirect_back= base_url()."tasker_step4/";
										redirect($redirect_back);
									}
									
								}
								if( $this->session->userdata('referrer_url') ) {
								$redirect_back = $this->session->userdata('referrer_url');
								$this->session->unset_userdata('referrer_url');
								redirect($redirect_back);
								}	
							
								redirect(base_url());
						}
						else
						{
							    echo 'swal("Oops!!","Your account is inactive","error")';
								/* if($this->session->userData('set_back_login_url')!='')
								{
									redirect($this->session->userData('set_back_login_url'));
									$this->session->set_userdata(array('set_back_login_url'=>''));
								}
								if($this->session->userData('task_category_id')!='')
								{
									redirect(base_url().'task_compare/'.$this->session->userData('task_category_id'));
								} */	
								if( $this->session->userdata('referrer_url') ) {
								$redirect_back = $this->session->userdata('referrer_url');
								$this->session->unset_userdata('referrer_url');
								redirect($redirect_back);
								}	
									
										redirect(base_url());
						}	
						
					
				}
				
				
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }

      

	}
	public function google_response(){

		include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
		$clientId = $this->config->item('gmail_client_id');
        $clientSecret = $this->config->item('gmail_client_secret');
        $redirectUrl = $this->config->item('gmail_redirect_url');
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to service rabbit');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
		if (isset($_GET['code'])) {
            $gClient->authenticate(); 
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            $userData['oauth_provider'] = 'google';
			$userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['given_name'];
            $userData['last_name'] = $userProfile['family_name'];
            $userData['email'] = $userProfile['email'];
			$userData['gender'] = $userProfile['gender'];
			$userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = $userProfile['link'];
            $userData['picture_url'] = $userProfile['picture'];
			$email=$userData['email'];
				$t=count($this->user_model->get_single_details(USERS,array('email'),array('email'=>$userData['email']))->result());
				if($t<=0)
				{
						
						$filename=now().rand().".jpg";
						$image = file_get_contents($userData['picture_url']);
						file_put_contents("images/site/profile/".$filename,$image);					
						$dataarray=array('first_name'=>$userData['first_name'],'last_name'=>$userData['last_name'],'email'=>$userData['email'],'photo'=>$filename,'google'=>$userData['oauth_uid'],'otp'=>mt_rand(1000, 9999));
						
						$t=$this->user_model->simple_insert(USERS,$dataarray);
						$checkUser = $this->user_model->get_all_details(USERS, array('email'=>$email));
						$userdata = array (
								'gm_user_id' => $checkUser->row ()->id,

								'gm_user_email' => $checkUser->row ()->email
						);
						#$this->session->set_userdata ( $userdata );
						$datestring = "%Y-%m-%d %h:%i:%s";
						$time = time ();
						$newdata = array (
								'last_login_date' => mdate ( $datestring, $time ),
								'last_login_ip' => $this->input->ip_address ()
						);
						$condition = array (
								'id' => $checkUser->row ()->id
						);
						$this->user_model->update_details ( USERS, $newdata, $condition );
						if($checkUser->row()->otp_verified==0)
						{
							redirect(base_url()."site/user/otp_verification/".$checkUser->row()->id."?type=mob");
						}
						/* if($this->session->userData('set_back_login_url')!='')
						{
							redirect($this->session->userData('set_back_login_url'));
							$this->session->set_userdata(array('set_back_login_url'=>''));
						}
						if($this->session->userData('task_category_id')!='')
						{
							redirect(base_url().'task_compare/'.$this->session->userData('task_category_id'));
						} */	
								if($checkUser->row()->group==1)
								{
									if($checkUser->row()->tasker_step1==0)
									{
										$redirect_back = base_url()."tasker_step1";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step2==0)
									{
										$redirect_back = base_url()."tasker_step2/";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step3==0)
									{
										$redirect_back = base_url()."tasker_step3/";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step4==0)
									{
										$redirect_back= base_url()."tasker_step4/";
										redirect($redirect_back);
									}
									
								}
								if( $this->session->userdata('referrer_url') ) {
								$redirect_back = $this->session->userdata('referrer_url');
								$this->session->unset_userdata('referrer_url');
								redirect($redirect_back);
								}
						
							
							
					redirect(base_url());
				}
				else
				{
					    $checkUser = $this->user_model->get_all_details(USERS, array('email'=>$email));
						if($checkUser->row()->status=="Active")
						{
								
								$datestring = "%Y-%m-%d %h:%i:%s";
								$time = time ();
								$newdata = array (
										'last_login_date' => mdate ( $datestring, $time ),
										'last_login_ip' => $this->input->ip_address ()
								);
								$condition = array (
										'id' => $checkUser->row ()->id
								);
								$this->user_model->update_details ( USERS, $newdata, $condition );
								
								if($checkUser->row()->otp_verified==0)
								{
									$returnStr['otp']=1;
									$otp=mt_rand(1000, 9999);								
									$newdata = array ('otp' => $otp);
									$condition = array ('id' => $checkUser->row ()->id);
								    $this->user_model->update_details ( USERS, $newdata, $condition );
									if($checkUser->row ()->phone!=""){
										$this->otp_message($checkUser->row ()->phone,$otp);
										redirect(base_url()."site/user/otp_verification/".$checkUser->row()->id);
									}
									else
									{
										$this->otp_message($checkUser->row ()->phone,$otp);
										redirect(base_url()."site/user/otp_verification/".$checkUser->row()->id."?type=mob");

									}
								}
								else
								{
									$userdata = array (
										'gm_user_id' => $checkUser->row ()->id,

										'gm_user_email' => $checkUser->row ()->email
									);
									$this->session->set_userdata ( $userdata );
								}
								
								/* if($this->session->userData('set_back_login_url')!='')
								{
									redirect($this->session->userData('set_back_login_url'));
									$this->session->set_userdata(array('set_back_login_url'=>''));
								}
								if($this->session->userData('task_category_id')!='')
								{
									redirect(base_url().'task_compare/'.$this->session->userData('task_category_id'));
								} */	
								if($checkUser->row()->group==1)
								{
									if($checkUser->row()->tasker_step1==0)
									{
										$redirect_back = base_url()."tasker_step1";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step2==0)
									{
										$redirect_back = base_url()."tasker_step2/";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step3==0)
									{
										$redirect_back = base_url()."tasker_step3/";
										redirect($redirect_back);
									}
									else if($checkUser->row()->tasker_step4==0)
									{
										$redirect_back= base_url()."tasker_step4/";
										redirect($redirect_back);
									}
									
								}
								
								if( $this->session->userdata('referrer_url') ) {
								$redirect_back = $this->session->userdata('referrer_url');
								$this->session->unset_userdata('referrer_url');
								redirect($redirect_back);
								}	
							
								redirect(base_url());
							
						}
						else
						{
							    echo 'swal("Oops!!","Your account is inactive","error")';
								/* if($this->session->userData('set_back_login_url')!='')
								{
									redirect($this->session->userData('set_back_login_url'));
									$this->session->set_userdata(array('set_back_login_url'=>''));
								}
								if($this->session->userData('task_category_id')!='')
								{
									redirect(base_url().'task_compare/'.$this->session->userData('task_category_id'));
								} */	
								
								if( $this->session->userdata('referrer_url') ) {
								$redirect_back = $this->session->userdata('referrer_url');
								$this->session->unset_userdata('referrer_url');
								redirect($redirect_back);
								}	
							
								redirect(base_url());
						}
						
				}
        }
        
      

	}
	
	public function dashboard()
	{
		if($this->checkLogin("U")!='')
		{
			$this->data['heading']="Dashboard";
			$id=$this->checkLogin("U");
			$this->data['id']=$id;
			$this->data['task_category']=$this->user_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active'));
			$this->data['task_category1']=$this->landing_model->get_service();
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			if($this->data['user']->group==1)
			{
				
				$this->data['book_details_current']=$this->tasker_model->tasker_enquires_load_current($id); 
				$this->load->view('site/user/tasker_dashboard',$this->data);
			}
			else
			{
				$this->data['book_details_current']=$this->tasker_model->tasker_enquires_load_current($id); 
				$this->load->view('site/user/tasker_dashboard',$this->data);
				#$this->load->view('site/user/dashboard',$this->data);
			}
		}
		else
		{
			redirect(base_url());
		}		
		
	}
	
	public function inbox()
	{
		if($this->checkLogin("U")!='')
		{
			$this->data['heading']="Inbox";
			$id=$this->checkLogin("U");
			$this->data['id']=$id;
			$this->data['message_list']=$this->user_model->get_message_list($id);
			$t= $this->user_model->get_unread_message($id);
			if($t->num_rows()>0)
			{
				$this->data['unreadmessage_count'] =$t->num_rows();
			}
			else
			{
				$this->data['unreadmessage_count']= '0';
			}
			
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->load->view('site/user/inbox',$this->data);
		}
		else
		{
			redirect(base_url());
		}		
		
	}
	
	public function unreadmessage_count()
	{
		$id=$this->checkLogin("U");
		$t= $this->user_model->get_unread_message($id); #echo $this->db->last_query();
		$message_list=$this->user_model->get_unreadmessage_list($id);
		$msg_array=array();
		
		foreach($message_list->result() as $msg)
		{
			if($msg->photo!='')
			{
				$pro_pic=base_url().'images/site/profile/'.$msg->photo;
			}
			else
			{
				$pro_pic=base_url().'images/site/profile/avatar.png';
			}
			$msg_array[]=array('id'=>$msg->booking_id,'user_id'=>$msg->user_id,'task_name'=>ucfirst($msg->task_name),'time'=>date('h:i:a',strtotime($msg->created)),'first_name'=>$msg->first_name,'img'=>$pro_pic,'msg'=>strlen($msg->msg)>60?substr($msg->msg,0,60).'...':$msg->msg);
		}
		$ret["ms"]=$msg_array;
		if($t->num_rows()>0)
		{
			#$ret["count"]= $t->row()->unreadmessage_count;
			$ret["count"]= $t->num_rows();
		}
		else
		{
			$ret["count"]= '0';
		}
		
		echo json_encode($ret);
		
	}
	public function message_search_list()
	{
		$id=$this->checkLogin("U");
		$search_by=$_POST['search_by'];
		$search_box=$_POST['search_box'];
		$t= $this->user_model->get_unread_message($id);
		$message_list=$this->user_model->message_search_list($id,$search_by,$search_box); 
		$msg_array=array();
		
		foreach($message_list->result() as $msg)
		{
			if($msg->photo!='')
			{
				$pro_pic=base_url().'images/site/profile/'.$msg->photo;
			}
			else
			{
				$pro_pic=base_url().'images/site/profile/avatar.png';
			}
			if($msg->msg!=""){
			$msg1=strlen($msg->msg)>60?substr($msg->msg,0,60).'...':$msg->msg;
			}
			else
			{
			$msg1=strlen($msg->message)>60?substr($msg->message,0,60).'...':$msg->message;	
			}
			$msg_array[]=array('id'=>$msg->booking_id,'user_id'=>$msg->user_id,'task_name'=>ucfirst($msg->task_name),'time'=>date('h:i:a',strtotime($msg->created)),'first_name'=>$msg->first_name,'img'=>$pro_pic,'msg'=>$msg1);
		}
		$ret["ms"]=$msg_array;
		if($t->num_rows()>0)
		{
			$ret["count"]= $t->num_rows();
		}
		else
		{
			$ret["count"]= '0';
		}
		
		echo json_encode($ret);
		
	}
	
	public function get_message_list()
	{
		if($this->checkLogin("U")!='')
		{
			$id=$this->checkLogin("U");
			$this->data['id']=$id;
			$booking_id=$_POST['booking_id'];
			$this->user_model->update_details(NOTIFICATION,array('message_status'=>'0'),array('booking_id'=>$booking_id,'viewer_id'=>$id)); 
			$this->data['message_list']=$this->user_model->get_single_message($id,$booking_id);
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->load->view('site/user/ajax_inbox',$this->data);
		}
		else
		{
			redirect(base_url());
		}		
		
	}
	
	public function sent_message()
	{
		if($this->checkLogin("U")!='')
		{
			$id=$this->checkLogin("U");
			$this->data['id']=$id;
			$booking_id=$_POST['booking_id'];
			$user_id=$_POST['user_id'];
			$message=strip_tags($_POST['message']);
			$msg_array=array('title'=>"New Message",'message'=>$message,'viewer_id'=>$user_id,'message_status'=>'1','viewer_status'=>'1','user_id'=>$id,'booking_id'=>$booking_id,'created'=>date('Y-m-d H:i:s'));
			$this->data['message_list']=$this->user_model->simple_insert(NOTIFICATION,$msg_array);
			$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			if($user->group==1){
			  $this->mail_model->send_message_push_user($booking_id,substr($message,0,30));
			}
			else{
			  $this->mail_model->send_message_push_tasker($booking_id,substr($message,0,30));	
			}
			echo 'success';
		}
		else
		{
			redirect(base_url());
		}		
		
	}
	
	public function tasker_past_list_load()
	{
		if($this->checkLogin("U")!='')
		{
			$this->data['heading']="Dashboard";
			$id=$this->checkLogin("U");
			$this->data['id']=$id;
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->data['book_details_current']=$this->tasker_model->tasker_enquires_load_past($id); 
			$this->load->view('site/tasker/dashboard_tasker_past',$this->data);
			
		}
		else
		{
			redirect(base_url());
		}		
		
	}

	public function tasker_completed_list_load()
	{
		if($this->checkLogin("U")!='')
		{
			$this->data['heading']="Dashboard";
			$id=$this->checkLogin("U");
			$this->data['id']=$id;
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->data['book_details_current']=$this->tasker_model->tasker_enquires_load_completed($id);  
			$this->load->view('site/tasker/dashboard_tasker_past',$this->data);
			
		}
		else
		{
			redirect(base_url());
		}		
		
	}

	public function dashboard_past_delete()
	{
		if($this->checkLogin("U")!='')
		{
			
			$id=$this->checkLogin("U");
			$bid=$_POST['bid'];
			$this->user_model->update_details(BOOKING,array('delete_status'=>1),array('id'=>$bid));
			echo "success";
			
		}
		else
		{
			redirect(base_url());
		}		
		
	}
	
	public function inbox_delete()
	{
		if($this->checkLogin("U")!='')
		{  
			$newval=$_POST['new_array'];
			for($i=0;$i<count($newval);$i++){
			$id=$this->checkLogin("U");
			$bid=$newval[$i];
			$this->user_model->commonDelete(NOTIFICATION,array('booking_id'=>$bid));
			}
			echo "success";
			
		}
		else
		{
			redirect(base_url());
		}		
		
	}

	public function account()
	{
		if($this->checkLogin("U")!='')
		{
			$this->data['heading']="My Account";
			$id=$this->checkLogin("U");
			$this->data['id']=$id;
			$stripe_pay=(json_decode($this->config->item('stripe_payment')));
			$this->data['client_id']=$stripe_pay->client_id;
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->load->view('site/user/account',$this->data);
		}
		else
		{
			redirect(base_url());
		}		
		
	}

	public function save_profile_tab1()
	{
		if($this->checkLogin('U')!='')
		{
			
			$email=$_POST['email'];
			unset($_POST['user_id']);
			$id=$this->checkLogin('U');
			$check_email=count($this->user_model->check_mail_profile($email,$id)->result()); 
			if($check_email==0)
			{
				$this->user_model->commonInsertUpdate(USERS,'update',array('user_id','user_password'),$_POST,array('id'=>$id)); 
				$ret['success']=1;
			}
			else
			{
				$ret['error']=1;
			}
			$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$ret['name']=$user->first_name.' '.$user->last_name;
			$ret['email']=$user->email;
			$ret['phone']=$user->phone;
			$ret['zipcode']=$user->zipcode;
			
			
		}
		else
		{
			redirect(base_url());
			$ret['error']=2;
		}
		echo json_encode($ret);
		
	}
	
	public function upload_profile_picture()
	{
		if($this->checkLogin('U')!='')
		{
			$id=$this->checkLogin('U');
			$dataarray=array();
			/* if($_FILES)
			{
				$config['overwrite'] = FALSE;
				$config['remove_spaces'] = TRUE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['max_width']  = '1600';
				$config['max_height']  = '1600';
				$config['upload_path'] = './images/site/profile';
				$this->load->library('upload', $config);
				if ( $this->upload->do_upload('upload_profile_picture')){
					$imgDetailsd = $this->upload->data();
					$dataarray = array('photo'=>$imgDetailsd['file_name']);
					$this->user_model->update_details(USERS,$dataarray,array('id'=>$id));
					$ret['status']=1;
					$ret['message']='Profile picture changed successfully...';
					
				}
				else
				{
					$ret['status']=0;
					$ret['message']=strip_tags($this->upload->display_errors());
				}
				$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
				$img=$user->photo!=''?$user->photo:'avatar.png';
				$ret['l_image']=base_url().'images/site/profile/'.$img;
				
			} */
			
			$data = $_POST['image'];
			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
			$data = base64_decode($data);
			$imageName = mt_rand().'_'.time().'.png';
			file_put_contents('images/site/profile/'.$imageName, $data);
			$dataarray = array('photo'=>$imageName);
			$this->user_model->update_details(USERS,$dataarray,array('id'=>$id));
			$ret['status']=1;
			$ret['message']='Profile picture uploaded successfully...';
			$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$img=$user->photo!=''?$user->photo:'avatar.png';
			$ret['l_image']=base_url().'images/site/profile/'.$img;
			echo json_encode($ret);			
			
		}
		else
		{
			redirect(base_url());
		}	
		
	}
	public function upload_document_picture()
	{
		if($this->checkLogin('U')!='')
		{
			$id=$this->checkLogin('U');
			$dataarray=array();
			if($_FILES)
			{   if(!is_dir('./images/site/profile/doc'))
				{
					mkdir('./images/site/profile/doc',0777);
				}
				$config['overwrite'] = FALSE;
				$config['remove_spaces'] = TRUE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['max_width']  = '1600';
				$config['max_height']  = '1600';
				$config['upload_path'] = './images/site/profile/doc';
				$this->load->library('upload', $config);
				if ( $this->upload->do_upload('upload_document_picture')){
					$imgDetailsd = $this->upload->data();
					$dataarray = array('id_doc'=>$imgDetailsd['file_name']);
					$this->user_model->update_details(USERS,$dataarray,array('id'=>$id));
					$ret['status']=1;
					$ret['message']='Document update successfully...';
					
				}
				else
				{
					$ret['status']=0;
					$ret['message']=strip_tags($this->upload->display_errors());
				}
				$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
				$img=$user->id_doc!=''?$user->id_doc:'avatar.png';
				$ret['l_image']=base_url().'images/site/profile/doc/'.$img;
				
			} 
			echo json_encode($ret);			
			
		}
		else
		{
			redirect(base_url());
		}	
		
	}
	public function check_email_profile()
	{   $email=$this->input->post('email');
	    $id=$this->input->post('id');
		$t=count($this->user_model->get_single_details(USERS,array('id'),array('email'=>$email,'id !='=>$id))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}
	public function check_current_password()
	{   $password=md5($this->input->post('current_password'));
	    $id=$this->checkLogin('U');
		
		$t1=count($this->user_model->get_single_details(USERS,array('id'),array('password'=>'','id'=>$id))->result()); 
		if($t1==1)
		{
			echo "true";die;
		}
		else
		{
				$t=count($this->user_model->get_single_details(USERS,array('id'),array('password'=>$password,'id'=>$id))->result()); 
			    if($t==1)
				{
					echo "true";
				}
				else
				{
					echo "false";
				}
		}
	}		

    public function save_profile_tab2()
	{   
		if($this->checkLogin('U')!='')
		{
			$password=md5($this->input->post('new_password'));
			$id=$this->checkLogin('U');		
			$this->user_model->update_details(USERS,array('password'=>$password),array('id'=>$id)); 
			$ret['status']=1;
			$ret['message']='Password changed successfully...';
	
		}
		else
		{
			$ret['status']=0;
			$ret['message']='Session expired login again...';
		}
		echo json_encode($ret);	
	    

	}
	 public function save_profile_tab3()
	{   
		if($this->checkLogin('U')!='')
		{
			$dataarray=array();	
			$id=$this->checkLogin('U');
			if($_POST)
			{   if(isset($_POST['task_email']))
				{
					if($_POST['task_email']=="on")
				{
					$dataarray['task_email']=1;
				}
				else
				{
					$dataarray['task_email']=0;
				}
				}
				else
				{
					$dataarray['task_email']=0;
				}	
				if(isset($_POST['task_sms']))
				{	
				if( $_POST['task_sms']=="on")
				{
					$dataarray['task_sms']=1;
				}
				else
				{
					$dataarray['task_sms']=0;
				}
				}
				else
				{
					$dataarray['task_sms']=0;
				}	
				
			    $this->user_model->update_details(USERS,$dataarray,array('id'=>$id));
			}
			else
			{
				$dataarray['task_email']=0;
				$dataarray['task_sms']=0;
				$this->user_model->update_details(USERS,$dataarray,array('id'=>$id));
			}		
			
			$ret['status']=1;
			$ret['message']='Notification saved successfully...';
	
		}
		else
		{
			$ret['status']=0;
			$ret['message']='Session expired login again...';
		}
		echo json_encode($ret);	
	    

	}
	
	public function cancelmyaccount()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->user_model->update_details(USERS,array('status'=>'Inactive'),array('id'=>$id));
			redirect(base_url().'logout');
		}
		else
		{
			redirect(base_url());
		}	
	}

	public function add_task($tid)
	{
		/* if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
		 */	
			#$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->data['tid']=$tid;
			$this->data['task_category']=$this->user_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$tid));				
			$this->data['vehicle_list']=$this->user_model->get_all_details(TASKER_VEHICLE, array('status'=>'Active'));				
			$task_details = array (
						'task_category_id' => $tid,
						'cat_name' => ucfirst($this->data['task_category']->row()->task_name)
				);
			$this->session->set_userdata($task_details);			
			$this->data['task_sub_category']=$this->user_model->get_all_details(TASKER_SUB_CATEGORY, array('status'=>'Active','cat_id'=>$tid));	
			$this->load->view('site/user/add_task',$this->data);
		/* }
		else
		{
			redirect(base_url());
		} */	
	}
	
	public function check_tasker_available() {
		$address_new = $this->input->post('city');
		$task_id = $this->input->post('task_id');
		$veh = $this->input->post('veh');
		$veh_name = $this->input->post('veh_name');
		$sub_task_id = $this->input->post('subcat_id');
		$subcat_name = $this->input->post('subcat_name');
		$appartment = $this->input->post('appartment');
		$address = str_replace(" ", "+", $address_new);
		$gmap_key=$this->config->item('gmap_key');
		$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$gmap_key");
		$json = json_decode($json);
		if($json->status=='OK' && isset($json->{'results'}[0]->{'geometry'}->{'bounds'}))
		{
			$newAddress = $json->{'results'}[0]->{'address_components'};
			$retrnstr['lat'] =$lat= $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			$retrnstr['long'] =$long= $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
			$minLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lat'};
		    $minLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lng'};
		    $maxLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lat'};
		    $maxLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lng'};
			$whereLat = '(u.lat BETWEEN "'.$minLat.'" AND "'.$maxLat.'" ) AND (u.long BETWEEN "'.$minLong.'" AND "'.$maxLong.'" )';
			$tot_count=$this->user_model->get_tasker_count($lat,$long,$task_id,$sub_task_id,$veh); /* echo $this->db->last_query(); */
			if($tot_count->num_rows()>0)
			{
				$tot_count=$tot_count->num_rows();
			}
			else 
			{
				$tot_count=0;
			}
			if($tot_count>0)
			{
				$retrnstr['available']='yes';
				$task_details = array (
						'task_category_city' => $address_new,
						'subcat_id' => $sub_task_id,
						'subcat_name' => $subcat_name,
						'veh_id' => $veh,
						'veh_name' => $veh_name,
						'task_appartment'=>$appartment
				);
			    $this->session->set_userdata($task_details);
			}
			else
			{
				$retrnstr['available']='no';
			}
			$retrnstr['status']=$json->status;
		}
		else
		{
			$retrnstr['status']=$json->status;	
			$retrnstr['available']='no';	
		}
		echo json_encode($retrnstr);
	}
	
	public function add_task_description($tid)
	{
		if($this->session->userdata('task_category_city')!='')
		{   
			#$id=$this->checkLogin('U');
			$this->data['tid']=$tid;			
			#$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->data['task_location']=$this->session->userdata('task_category_city');
			$this->data['subcat_name']=$this->session->userdata('subcat_name');
			$this->data['task_category']=$this->user_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$tid));	
			$this->load->view('site/user/add_task_description',$this->data);
		}
		else
		{
			redirect(base_url());
		}	
	}
	public function task_compare($tid)
	{
		/* if($this->checkLogin('U')!='' && $this->session->userdata('task_category_city')!='')
		{   
		 */	$id=$this->checkLogin('U');
			$this->data['tid']=$tid;			
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->data['task_location']=$this->session->userdata('task_category_city');
			$this->data['subcat_name']=$this->session->userdata('subcat_name');
			$this->data['task_category']=$this->user_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$tid));	
			/* $address_new=$this->session->userdata('task_category_city');
			$address = str_replace(" ", "+", $address_new);
			$gmap_key=$this->config->item('gmap_key');
			$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$gmap_key");
			$json = json_decode($json);
			$newAddress = $json->{'results'}[0]->{'address_components'};
			$retrnstr['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			$retrnstr['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
			$minLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lat'};
			$minLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lng'};
			$maxLat = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lat'};
			$maxLong = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lng'};
			$whereLat = '(u.lat BETWEEN "'.$minLat.'" AND "'.$maxLat.'" ) AND (u.long BETWEEN "'.$minLong.'" AND "'.$maxLong.'" )';
			$this->data['tasker_details']=$this->user_model->get_tasker_search_details($whereLat,$this->session->userdata('task_category_id'));
			 */	
				
			$this->load->view('site/user/task_compare',$this->data);
		/* }
		else
		{
			redirect(base_url());
		} */	
	}
	
	public function fetch_tasker_details()
	{
		/* if($this->checkLogin('U')!='')
		{ */
			if($this->checkLogin('U')!='')
			{	
			$id=$this->checkLogin('U');
			}else{ $id=0;}
			$booking_date=$_POST['task_date'];
			$sorting=$_POST['sorting'];
			$distance="";
			$booking_time=$_POST['task_time'];
			$address_new=$this->session->userdata('task_category_city');
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
			$book_check=$this->user_model->get_booked_status($this->session->userdata('task_category_id'),$this->session->userdata('subcat_id'),$booking_date,$booking_time); #echo $this->db->last_query();#print_r($book_check->result());
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
			/* $block_check=$this->user_model->get_all_details(BLOCK_DATES,array('task_category_id'=>$this->session->userdata('task_category_id'),'subcat_id'=>$this->session->userdata('subcat_id'),'task_date'=>$booking_date,'task_time'=>$booking_time));  */
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
			
			 #$whereLat = '(u.lat BETWEEN "'.$minLat.'" AND "'.$maxLat.'" ) AND (u.long BETWEEN "'.$minLong.'" AND "'.$maxLong.'" ) '.$search; 
			 #echo $search;
			if($search!=''){
			$whereLat = "u.group='1' ".$search;
			}
			else{
				$whereLat = "u.group='1'";
			}
			$this->data['tasker_details']=$this->user_model->get_tasker_search_details($whereLat,$this->session->userdata('task_category_id'),$this->session->userdata('subcat_id'),$id,$booking_date,$booking_time,$distance,$lat,$long,$order_by);
			/* echo $this->db->last_query(); */	
			$this->load->view('site/user/ajax_tasker',$this->data);
		/* }
		else
		{
			redirect(base_url());
		} */	
	}
	
	public function save_task_description()
	{
		/* if($this->session->userdata('task_category_city')!='')
		{ */   
			#$id=$this->checkLogin('U');
			$task_details = array (
						'task_description' => $_POST['task_description']						
				);
			$this->session->set_userdata($task_details);
			echo '1';
		/* }
		else
		{
			redirect(base_url());
		} */	
	}
	
	public function book_tasker()
	{
		if($this->checkLogin('U')!='' && $this->session->userdata('task_category_id')!='')
		{   
			$id=$this->checkLogin('U');
			$tasker_id=$_POST['tasker_id'];
			$task_date=$_POST['task_date'];
			$task_time=$_POST['task_time'];
			$task_details = array (
						'tasker_id' => $tasker_id,
						'task_date' => $task_date,
						'task_time'=>$task_time
				);
			$this->session->set_userdata($task_details);
			echo '1';
		}
		else
		{
			redirect(base_url());
		}	
	}
	public function save_date_time()
	{
		   
			
			$task_date=$_POST['task_date'];
			$task_time=$_POST['task_time'];
			$task_details = array (
						'task_date' => $task_date,
						'task_time'=>$task_time
				);
			$this->session->set_userdata($task_details);
			echo '1';
		
	}
	
	public function check_book()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			
			$tasker_id=$_POST['tasker_id'];
			$task_date=$this->session->userdata('task_date');
			$task_time=$this->session->userdata('task_time');
			$task_category_id=$_POST['task_select_cat'];
			$subcat_id=$_POST['task_select_sub_cat'];
			$subcat_name=$_POST['task_select_sub_cat_name'];
			$task_details = array (
						'tasker_id' => $tasker_id,
						'subcat_id' => $subcat_id,
						'subcat_name' => $subcat_name,
						'task_category_id' => $task_category_id
				);
			$booking_details = array (
						'tasker_id' => $tasker_id,
						'booking_date' => $task_date,
						'task_category_id' => $task_category_id,
						'subcat_id' => $subcat_id,
						'status' => "paid",
						'booking_time'=>$task_time
				);
			$check_task=$this->user_model->get_all_details(BOOKING,$booking_details);
			if($check_task->num_rows()==0)
			{
				$this->session->set_userdata($task_details);
				echo '1';
			}
			else
			{
				echo '0';
			}
			
		}
		else
		{
			redirect(base_url());
		}	
	}
	
	public function booking_confirm($tid)
	{
		if($this->checkLogin('U')!='' && $this->session->userdata('tasker_id')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['tasker_id']=$this->session->userdata('tasker_id');		
			$this->data['subcat_name']=$this->session->userdata('subcat_name');	
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->data['task_location']=$this->session->userdata('task_category_city');
			$this->data['task_category']=$this->user_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$this->session->userdata('task_category_id')));
			$this->data['tasker_details']=$this->user_model->gettasker_taskdetails($this->session->userdata('tasker_id'),$this->session->userdata('task_category_id'));
			$this->data['card_comp']='';
			$this->data['card_last']='';
			$get_token=$this->data['user']->stripe_customer_id;
			if($get_token!=""){
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
				$response=json_decode($stripe->customer_info($get_token));
				$res_array=$response->sources->data[0]; 			
				$this->data['card_comp']=$res_array->brand;
				$this->data['card_last']=$res_array->last4;
			}
		
			$this->load->view('site/user/confirm_booking',$this->data);
		}
		else
		{
			redirect(base_url());
		}	
	}
	
	public function save_booking_confirm()
	{
		$ret['error_new']='';
		$id=$this->checkLogin('U');
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
		$credit_card_type=$_POST['credit_card_type'];
		$exp_month=$_POST['exp_month'];
		$exp_year=$_POST['exp_year'];
		$address_zip=$_POST['address_zip'];
		$phone_no=$_POST['address_zip'];
		$card_array=array(
			'number' => $number,
			'cvc' => $cvc,
			'exp_month' => $exp_month,
			'exp_year' => $exp_year,
			'address_zip' => $address_zip,
			'name' => 'siva'
			
		);
		$task_category=$this->user_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$this->session->userdata('task_category_id')));
		$tasker_details=$this->user_model->gettasker_taskdetails($this->session->userdata('tasker_id'),$this->session->userdata('task_category_id'));
		$service_percentage=$task_category->row()->admin_percentage;
		$per_hour=$tasker_details->row()->price;
		$service_fee=(((4*$tasker_details->row()->price)*$service_percentage)/100);
		$total_amount=round((4*$tasker_details->row()->price)+$service_fee);
		$total=$total_amount*100;
		$currency='USD';
		/*currency list*/
		$currencyDetails = $this->user_model->get_all_details(CURRENCY, array('status'=>'Active'));
		$currencyArr = array();
		foreach($currencyDetails->result() as $res){
			$currencyArr[$res->currency_type] = $res->currency_rate;
		}
		$currency_json = json_encode($currencyArr);
		/*currency list*/
		if($credit_card_type==1){
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
			}
			if($ret['error_new']=='')
			{
				$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
				$user_email=$user->email;
				$customer=json_decode($stripe->customer_create($token_id,$user_email));
				if(isset($customer->id))
				{
					$customer_id=$customer->id;
					$enq_array=array(
					'task_category_id'=>$this->session->userdata('task_category_id'),
					'subcat_id'=>$this->session->userdata('subcat_id'),
					'veh_id'=>$this->session->userdata('veh_id'),
					'veh_name'=>$this->session->userdata('veh_name'),
					'user_id'=>$id,
					'tasker_id'=>$this->session->userdata('tasker_id'),
					'task_description'=>$this->session->userdata('task_description'),
					'address'=>$this->session->userdata('task_category_city'),
					'booking_date'=>$this->session->userdata('task_date'),
					'booking_time'=>$this->session->userdata('task_time'),
					'phone_no'=>$phone_no,
					'address_zipcode'=>$address_zip,
					'service_fee'=>$service_fee,
					'service_percentage'=>$service_percentage,
					'total_amount'=>$total_amount,
					'per_hour'=>$per_hour,
					'status'=>'Pending',
					'currency_json'=>$currency_json,
					'created'=>time(),
					'stripe_customer_id'=>$customer_id
					);
					$this->user_model->simple_insert(BOOKING,$enq_array);
					$notifiy_array=array('title'=>'You got request from '.$this->data['userDetails']->row()->first_name,
					'message'=>$this->session->userdata('task_description'),
					'viewer_id'=>$this->session->userdata('tasker_id'),
					'viewer_status'=>'1',
					'message_status'=>'1',
					'booking_id'=>$this->db->insert_id(),
					'user_id'=>$id
					);
					$be_id=$this->db->insert_id();
					$this->user_model->simple_insert(NOTIFICATION,$notifiy_array);
					$this->mail_model->send_booking_emails($be_id);
					$userdata = array (
					'task_category_id' => '',
					'veh_id' => '',
					'veh_name' => '',
					'subcat_id' => '',
					'subcat_name' => '',
					'cat_name' => '',
					'tasker_id' => '',
					'task_description' => '',
					'task_date' => '',
					'task_time' => '',
					'task_category_city' => '' 
					);
					
					$this->session->unset_userdata ( $userdata );
				}
				else
				{
					$ret['error_new']= $customer->error->message;
				}
			}
		
		
		}
		else
		{
			        $id=$this->checkLogin('U');
			        $get_token=$this->user_model->get_all_details(USERS,array('id'=>$id))->row()->stripe_customer_id;
					$response=json_decode($stripe->customer_info($get_token));			        	
					$customer_id=$response->id;	
					$enq_array=array(
					'task_category_id'=>$this->session->userdata('task_category_id'),
					'subcat_id'=>$this->session->userdata('subcat_id'),
					'veh_id'=>$this->session->userdata('veh_id'),
					'veh_name'=>$this->session->userdata('veh_name'),
					'user_id'=>$id,
					'tasker_id'=>$this->session->userdata('tasker_id'),
					'task_description'=>$this->session->userdata('task_description'),
					'address'=>$this->session->userdata('task_category_city'),
					'booking_date'=>$this->session->userdata('task_date'),
					'booking_time'=>$this->session->userdata('task_time'),
					'phone_no'=>$phone_no,
					'address_zipcode'=>$address_zip,
					'service_fee'=>$service_fee,
					'service_percentage'=>$service_percentage,
					'total_amount'=>$total_amount,
					'per_hour'=>$per_hour,
					'status'=>'Pending',
					'currency_json'=>$currency_json,
					'created'=>time(),
					'stripe_customer_id'=>$customer_id
					);
					$this->user_model->simple_insert(BOOKING,$enq_array);
					$notifiy_array=array('title'=>'You got request from '.$this->data['userDetails']->row()->first_name,
					'message'=>$this->session->userdata('task_description'),
					'viewer_id'=>$this->session->userdata('tasker_id'),
					'viewer_status'=>'1',
					'message_status'=>'1',
					'booking_id'=>$this->db->insert_id(),
					'user_id'=>$id
					);
					$be_id=$this->db->insert_id();
					$this->user_model->simple_insert(NOTIFICATION,$notifiy_array);
					$this->mail_model->send_booking_emails($be_id); 
					$userdata = array (
					'task_category_id' => '',
					'veh_id' => '',
					'veh_name' => '',
					'subcat_id' => '',
					'subcat_name' => '',
					'cat_name' => '',
					'tasker_id' => '',
					'task_description' => '',
					'task_date' => '',
					'task_time' => '',
					'task_category_city' => '' 
					);
					
					$this->session->unset_userdata ( $userdata );
		}			
		echo json_encode($ret);
		
		
	}
	
	public function task_completed()
	{
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
		$book_id=$_POST['id'];
		$task_time=$_POST['task_time'];
		$get_booking=$this->user_model->get_all_details(BOOKING,array('id'=>$book_id));
		/*Update amount*/
		$service_percentage=$get_booking->row()->service_percentage;
		$per_hour=$get_booking->row()->per_hour;
		$service_fee=((($task_time*$per_hour)*$service_percentage)/100);
		$total_amount=round(($task_time*$per_hour)+$service_fee);
		$price_update=array('service_fee'=>$service_fee,'total_amount'=>$total_amount,'total_task_hour'=>$task_time);
		$this->user_model->update_details(BOOKING,$price_update,array('id'=>$book_id)); /* echo $this->db->last_query();die; */
		
		/*Update amount*/
		
		/*Gift amount check and update*/
		$check_gift=$this->user_model->get_all_details(GIFT_PAID,array('user_id'=>$get_booking->row()->user_id,'balance_limit !='=>0));
		if($check_gift->num_rows()>0){
			if($total_amount>=$check_gift->row()->min_price && $total_amount>=$check_gift->row()->per_amount){
				
				$total_amount=$total_amount-$check_gift->row()->per_amount;
				$this->user_model->update_details(GIFT_PAID,array('balance_limit'=>$check_gift->row()->balance_limit-1),array('id'=>$check_gift->row()->id));
				$userinfo=$this->user_model->get_all_details(USERS,array('id'=>$get_booking->row()->user_id));
				$this->user_model->update_details(USERS,array('gift_amount'=>$userinfo->row()->gift_amount-$check_gift->row()->per_amount),array('id'=>$get_booking->row()->user_id));
				$this->user_model->simple_insert(GIFT_USER_PAY,array('user_id'=>$get_booking->row()->user_id,'booking_id'=>$book_id,'amount'=>$check_gift->row()->per_amount));
	            		
			}

		}
		/*Gift amount check and update*/
		$amount=$total_amount*100;
		$customer_id=$get_booking->row()->stripe_customer_id;
		$desc='Task id:SRA00'.$get_booking->row()->id;
		$currency_type='USD';
		$charge=json_decode($stripe->charge_customer($amount,$customer_id,$desc,$currency_type));
		if(isset($charge->id))
		{
			$status=$_POST['status'];			
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
		}
		else
		{
			
			$ret['error_new']= $charge->error->message;
		}
		echo json_encode($ret);
		
	}
	
	public function get_user_cancel_amount()
	{   $ret['error_new']='';	
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

		$book_id=$_POST['id'];
		$get_booking=$this->user_model->get_user_cancel_list($book_id);
		$amount=$get_booking->row()->total_amount*100;
		$cancel_amount=round(($amount*$get_booking->row()->cancel_percentage)/100);
		$customer_id=$get_booking->row()->stripe_customer_id;
		$desc='Task cancel id:SRA00'.$get_booking->row()->id;
		$currency_type='USD';
		$charge=json_decode($stripe->charge_customer($cancel_amount,$customer_id,$desc,$currency_type));/*  echo '<pre>';print_r($charge); */
		if(isset($charge->id))
		{
			$status=$_POST['status'];			
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
			
		}
		else
		{
			
			$ret['error_new']= $response->error->message;
		}
		echo json_encode($ret);
	}
	
public function task_amount_refund()
	{
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
		$amount=24*100;		
		$charge_id='ch_1A1AWtJuvKATQ7KnJ7szcUE6';
		$refund=json_decode($stripe->charge_refund($charge_id,$amount));
		echo $charge_id=($refund);
	}
	
	public function tasker_list_load()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['book_details']=$this->user_model->task_list_load($id);
			$this->load->view('site/user/task_list',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function load_transaction_list()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['book_details']=$this->user_model->load_transaction_list($id);
			$this->load->view('site/user/transaction_list',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	public function export_transaction_list()
	{
		$id=$this->checkLogin('U');
			$this->data['users_detail']=$this->user_model->export_transaction_list($id)->result();
			$this->load->view('site/user/export_transaction_list',$this->data);
	}
	
	public function load_available_balance()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['available_bal']=$this->user_model->load_available_balance($id);
			$tot=$t=0;
			if(!empty($this->data['available_bal']->result())){
			foreach($this->data['available_bal']->result() as $av)
			{
				$tot+=$av->total_amount-$av->service_fee;
			}
			$t=$tot-($this->data['available_bal']->row()->paid_amount);
			}
			echo $this->session->userdata('currency_symbol').' '. round($this->session->userdata('currency_rate')*($t),2);
			#$this->load->view('site/user/load_available_balance',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	
	public function get_notification()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$tot['result']=array();
			$tot['success']=0;
			$notification=$this->user_model->get_all_details(NOTIFICATION,array('viewer_id'=>$id,'viewer_status'=>1));
			if($notification->num_rows()>0)
			{				
				foreach($notification->result() as $av)
				{
					$userDetails1=$this->user_model->get_all_details(USERS,array('id'=>$av->user_id));
					if($userDetails1->row()->photo!='')
					{
						$pro_pic=base_url().'images/site/profile/'.$userDetails1->row()->photo;
					}
					else
					{
						$pro_pic=base_url().'images/site/profile/avatar.png';
					}
					$tot['result'][]=array('message'=>$av->message,'title'=>$av->title,'id'=>$av->id,'img'=>$pro_pic);
					$tot['success']=1;
					
				}
			
			}
			echo json_encode($tot);
		}
		else
		{
			redirect(base_url());
		}
	}
	
		
	public function update_notification_status()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$_POST['id'];			
			$notification=$this->user_model->update_details(NOTIFICATION,array('viewer_status'=>0),array('id'=>$id));
			
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function save_review()
	{
		if($this->checkLogin('U')!='')
		{   
			$_POST['user_id']=$this->checkLogin('U');		
			$notification=$this->user_model->simple_insert(REVIEWS,$_POST);
			$this->mail_model->send_feedback($_POST['booking_id']);
			echo 'success';
		}
		else
		{
			echo 'false';
		}
	}
	 
	public function set_back_login($url)
	{
		$user_url=array('set_back_login_url'=>$this->input->get('url'));
		$this->session->set_userdata($user_url);
		redirect('user_login');
	}
	
	public function review_tasker_list_load()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['book_details']=$this->user_model->task_list_load($id); 
			$this->load->view('site/user/dashboard_review_list',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function load_user_completed_list()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['book_details']=$this->user_model->dashboar_user_completed_task_list_load($id); 
			$this->load->view('site/user/dashboard_review_list',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function dashboard_user_cancel_list()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['book_details']=$this->user_model->dashboard_user_cancel_list($id); 
			$this->load->view('site/user/dashboard_user_cancel_list',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function load_user_current_list()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['book_details']=$this->user_model->dashboar_user_current_task_list_load($id); 
			$this->load->view('site/user/dashboard_user_current_list',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	
  public function forgot_password()
	{
		$this->data['heading']="User Password reset";
		$this->load->view('site/user/forgot_password',$this->data);
	}
	
	 public function send_forgot_password()
	 {
		 $email=$_POST['login_email'];
		 $check_user=$this->user_model->get_all_details(USERS,array('email'=>$email));
		 if($check_user->num_rows()>0)
		 {
			$password=time();
			$to = $email;			
			$this->mail_model->send_user_password ( $password,$check_user->row()->first_name,$email );
			$msg="Your new password is ".$password." , login and change your password";
			$this->mail_model->send_text($check_user->row()->phone,$msg);
			$this->user_model->update_details(USERS,array('password'=>md5($password)),array('email'=>$email));	
			$ret['status']=1;
			$ret['message']="Passwor reset successfully. Check your mail";
			
		 }
		 else
		 {
			 $ret['status']=2;
			 $ret['message']="Email id is not found";
		 }
		 echo json_encode($ret);
	 }
	 
	 public function check_existing_card_pay()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['heading']="Tasker Registration process step four";
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
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
			
			if($this->data['user']->stripe_customer_id!=''){
			$response=json_decode($stripe->customer_info($this->data['user']->stripe_customer_id));
			echo $response->id;
			echo '<pre>';print_r($response->id);
			$card_array=array(
			'number' => $number,
			'cvc' => $cvc,
			'exp_month' => $exp_month,
			'exp_year' => $exp_year,
			'address_zip' => $address_zip,
			'name' => 'siva'
			
		);
            $response=json_decode($stripe->card_token_create($card_array,$total,$currency));			
			$charge=json_decode($stripe->charge_customer('2000',$this->data['user']->stripe_customer_id,'Semma Siva','USD'));
			$this->data['card_comp']='';
			$this->data['card_last']='';
			$res_array=$response->sources->data[0]; 			
			$this->data['card_comp']=$res_array->brand;
			$this->data['card_last']=$res_array->last4;
			}
			/* $this->load->view('site/tasker/step4_edit',$this->data); */
		}
		else
		{
			echo "Session loggedout so login again!";
		}
	}
	/* Gift card payment*/
	
	public function add_gif_card()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['user']=$this->user_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->data['gift_card_list']=$this->user_model->get_all_details(GIFT, array('status'=>'1'));
			$this->load->view('site/gift/add_gift_card',$this->data);
		}
		else
		{
			echo "Session loggedout so login again!";
		}
	}
	public function load_card_payment($card_item)
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['gift_card_list']=$this->user_model->get_all_details(GIFT, array('id'=>$card_item))->row();
			$this->data['user']=$this->user_model->get_all_details(USERS, array('id'=>$id))->row();
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
			$this->data['card_comp']='';
			$this->data['card_last']='';
			if($this->data['user']->stripe_customer_id!=''){
			$response=json_decode($stripe->customer_info($this->data['user']->stripe_customer_id)); 
			$res_array=$response->sources->data[0];
			$this->data['card_comp']=$res_array->brand;
			$this->data['card_last']=$res_array->last4;
			}
			$this->load->view('site/gift/card_payment',$this->data);
		}
		else
		{
			echo "Session loggedout so login again!";
		}
	}
	
	public function process_gift_payment()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$ret['error_new']='';
			$credit_card_type=$_POST['credit_card_type'];
			$gift_id=$_POST['gift_id'];
			$gift_card_info=$this->user_model->get_all_details(GIFT, array('id'=>$gift_id))->row();
			$stripe_pay=(json_decode($this->config->item('stripe_payment')));
			$stripe_key=$stripe_pay->stripe_key;
			$stripe_secret=$stripe_pay->stripe_secret;
			$mode=$stripe_pay->mode;
			$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
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
				'name' => $user->first_name
				
			);	
			if($credit_card_type==1){
					
				$total=$gift_card_info->price*100;
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
					$ret['error_new']= $response->error->message;
				}
				if($ret['error_new']=='')
				{
					$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
					$user_email=$user->email;
					$customer=json_decode($stripe->customer_create($token_id,$user_email));
					if(isset($customer->id))
					{
						$customer_id=$customer->id;
						$desc='Gift card $'.$total_amount;
						$currency_type='USD';
						$charge=json_decode($stripe->charge_customer($total,$customer_id,$desc,$currency_type)); 
						if(isset($charge->id))
						{
							$newarray['gift_amount']=$user->gift_amount+$gift_card_info->gift_price;
							$newarray['stripe_customer_id']=$customer_id;
							$giftarray=array('name'=>$user->first_name,'amount'=>$gift_card_info->price,'worth_amount'=>$gift_card_info->gift_price,'per_amount'=>$gift_card_info->per_price,'user_limit'=>$gift_card_info->use_limit,'balance_limit'=>$gift_card_info->use_limit,'user_id'=>$user->id,'transaction_id'=>$charge->id,'min_price'=>$gift_card_info->min_price);
							$this->user_model->update_details(USERS,$newarray,array('id'=>$id));
							$this->user_model->simple_insert(GIFT_PAID,$giftarray);
						    
						}
						else
						{
							$ret['error_new']= $charge->error->message;
						}
					}
					else
					{
						$ret['error_new']= $customer->error->message;
					}
				}
				}
				else
				{
					$amount=$gift_card_info->price*100;
					$user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
					$customer_id=$user->stripe_customer_id;
					$desc='Gift card $'.$total_amount;
					$currency_type='USD';
					$charge=json_decode($stripe->charge_customer($amount,$customer_id,$desc,$currency_type));
					if(isset($charge->id))
					{
						$newarray['gift_amount']=$user->gift_amount+$gift_card_info->gift_price;
						$giftarray=array('name'=>$user->first_name,'amount'=>$gift_card_info->price,'worth_amount'=>$gift_card_info->gift_price,'per_amount'=>$gift_card_info->per_price,'user_limit'=>$gift_card_info->use_limit,'balance_limit'=>$gift_card_info->use_limit,'user_id'=>$user->id,'transaction_id'=>$charge->id,'min_price'=>$gift_card_info->min_price);
						$this->user_model->update_details(USERS,$newarray,array('id'=>$id));
						$this->user_model->simple_insert(GIFT_PAID,$giftarray);
					}
					else
					{
						$ret['error_new']= $charge->error->message;
					}
				}
				
		}
		else
		{
			$ret['status']=0;
		}	
		echo json_encode($ret);
	}
	/* Gift card payment*/
	/*otp **/
	public function test_sms()
	{
		try{
			$to="70970851"; $message="test test test";
			$this->load->library('Messagebird');			
			$country_code=$this->config->item('messagebird_country_code')==""?"855":$this->config->item('messagebird_country_code');
			$from = $country_code.$this->config->item('messagebird_number');
			$to = $country_code.$to; 
			$sms = new MessageBird($this->config->item('messagebird_username'), $this->config->item('messagebird_password'));
			$sms->setSender($from);
			$sms->addDestination($to);
			if($to!=""){
			$sms->sendSms($message);
			if($sms->getResponseCode()){
				echo 'Error:<pre> '; print_r($sms->getResponseCode());
				echo 'Error:<pre> '; print_r($sms->getResponseMessage());
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
		#$this->mail_model->send_text("8248914613",'Otp for taskct.com  use this credential dont share with anyone 123456');
	}
	
	public function otp_message($to,$msg)
	{
		$otpmsg="OTP from ".$this->config->item('site_name')." don't share with anyone otp is".$msg;
		$this->mail_model->send_text($to,$otpmsg);
	}
	public function otp_verification($id)
	{		
		$this->data['user']=$this->user_model->get_all_details(USERS, array('id'=>$id))->row();
		$this->load->view('site/otp/otp_page',$this->data);		
	}

    public function verify_otp()
	{		
		$id=$_POST['user_id'];
		$otp=$_POST['otp'];
		$check_user=$this->user_model->get_all_details(USERS, array('id'=>$id,'otp'=>$otp));
		if($check_user->num_rows()==1){
		$ret['status']=1;
		$userdata = array ('gm_user_id' => $check_user->row()->id,'gm_user_email' => $check_user->row()->email);
		$this->session->set_userdata ( $userdata );
		$this->user_model->update_details(USERS,array('otp_verified'=>1),array('id'=> $check_user->row()->id));
		if($check_user->row()->group==0)
		{
			$ret['rurl']="dashboard";
		}
		else
		{
			if($check_user->row()->tasker_step1==0)
			{
				$ret ['rurl'] ="tasker_step1";
			}
			else if($check_user->row()->tasker_step2==0)
			{
				$ret ['rurl'] ="tasker_step2/";
			}
			else if($check_user->row()->tasker_step3==0)
			{
				$ret ['rurl'] ="tasker_step3/";
			}
			else if($check_user->row()->tasker_step4==0)
			{
				$ret ['rurl'] ="tasker_step4/";
			}
		}
		
		}
		else
		{
			$ret['status']=0;
			$ret['message']="Your otp is incorrect.";
		}
		echo json_encode($ret);
	}
	
	public function resendotp()
	{
	    $id=$_POST['user_id'];
		$otp=mt_rand(1000, 9999);
		$this->user_model->update_details(USERS,array('otp'=>$otp),array('id'=>$id));
		$check_user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();				
		$this->otp_message($check_user->phone,$otp);
		echo "success";
	}
	public function change_otp_mobile()
	{
	    $id=$_POST['user_id'];
	    $phone=$_POST['change_phone'];
		$otp=mt_rand(1000, 9999);
		$this->user_model->update_details(USERS,array('otp'=>$otp),array('id'=>$id));
		$check_user=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();	
		$this->otp_message($phone,$otp);		
		$ret['status']=1;
		echo json_encode($ret);
	}
	
	public function verify_otp_mobile()
	{		
		$id=$this->checkLogin('U');
		$otp=$_POST['otp'];
		$phone=$_POST['otp_phone'];
		$check_user=$this->user_model->get_all_details(USERS, array('id'=>$id,'otp'=>$otp));
		if($check_user->num_rows()==1){
		$ret['status']=1;
		$this->user_model->update_details(USERS,array('otp_verified'=>1,"phone"=>$phone),array('id'=> $check_user->row()->id));
		}
		else
		{
			$ret['status']=0;
			$ret['message']="Your otp is incorrect.";
		}
		echo json_encode($ret);
	}
	
	/*otp*/


}
