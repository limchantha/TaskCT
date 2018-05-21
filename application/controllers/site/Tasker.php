<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasker extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('tasker_model');
		$this->load->model('mail_model');
		$this->load->model('landing_model');
		
    }

	public function tasker_signup()
	{
		$this->data['heading']="Tasker Signup";
		$this->data['task_category']=$this->landing_model->get_service();
		$this->data['tasker_reviewlist']=$this->landing_model->get_review_list();
		$this->load->view('site/tasker/tasker_signup',$this->data);
	}
	
	
	public function signup_process()
	{   
		$email=$this->input->post('email');
		$t=count($this->tasker_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
				$_POST['group']='1'; 
				$_POST['password']=md5($_POST['password']); 
				/*otp */
				$_POST['otp']=mt_rand(1000, 9999);				
				$this->otp_message($_POST['phone'],$_POST['otp'] );
				/*otp */
				$t=$this->tasker_model->simple_insert(USERS,$_POST);
       		    $checkUser = $this->tasker_model->get_all_details(USERS, array('email'=>$email));
			    $userdata = array (
						'gm_user_id' => $checkUser->row ()->id,

						'gm_user_email' => $checkUser->row ()->email
				);
				#$this->session->set_userdata ( $userdata );
				$t1['user_id'] =$checkUser->row ()->id;
				
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time ();
				$newdata = array (
						'last_login_date' => mdate ( $datestring, $time ),
						'last_login_ip' => $this->input->ip_address ()
				);
				$condition = array (
						'id' => $checkUser->row ()->id
				);
				$this->tasker_model->update_details ( USERS, $newdata, $condition );
				
			$t1['result'] ='success';
		}
		else
		{
			$t1['result'] = 'error';
		 	
		}
	    echo json_encode($t1);
    }
	public function check_email()
	{   $email=$this->input->post('email');
		$t=count($this->tasker_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}
	
	public function tasker_step1()
	{
		$this->data['heading']="Tasker Registration process step one";
		$this->load->view('site/tasker/step1',$this->data);
	}
	
	public function save_step1()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->user_model->update_details(USERS,array('tasker_step1'=>'1'),array('id'=>$id));
			redirect(base_url().'tasker_step2');
		}
		else
		{
			redirect(base_url());
		}	
	}
	public function tasker_step2()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['heading']="Tasker Registration process step two";
			$this->data['tasker_city']=$this->tasker_model->get_all_details(TASKER_CITY, array('status'=>'Active'));
			$this->data['tasker_vehicle']=$this->tasker_model->get_all_details(TASKER_VEHICLE, array('status'=>'Active'));
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->load->view('site/tasker/step2',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function edit_tasker_profile()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['heading']="Tasker Registration process step two";
			$this->data['tasker_city']=$this->tasker_model->get_all_details(TASKER_CITY, array('status'=>'Active'));
			$this->data['tasker_vehicle']=$this->tasker_model->get_all_details(TASKER_VEHICLE, array('status'=>'Active'));
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->load->view('site/tasker/step2_edit',$this->data);
		}
		else
		{
			echo "Session loggedout so login again!";
		}
	}
	
	public function upload_profile_picture()
	{
		if($this->checkLogin('U')!='')
		{
			$id=$this->checkLogin('U');
			$dataarray=array();
			if($_FILES)
			{   print_r($_FILES);die;
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
					$this->tasker_model->update_details(USERS,$dataarray,array('id'=>$id));
					$ret['status']=1;
					$ret['message']='Profile picture changed successfully...';
					
				}
				else
				{
					$ret['status']=0;
					$ret['message']=strip_tags($this->upload->display_errors());
				}
				$user=$this->tasker_model->get_all_details(USERS,array('id'=>$id))->row();
				$img=$user->photo!=''?$user->photo:'avatar.png';
				$ret['l_image']=base_url().'images/site/profile/'.$img;
				
			}
			echo json_encode($ret);	
			
			
		}
		else
		{
			redirect(base_url());
		}	
		
	}
	
	public function save_step2()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$_POST['tasker_step2']=1;
			$vehicle_array=implode(',',$_POST['vehicle_type']);
			unset($_POST['vehicle_type']);
			$_POST['vehicle_types']=$vehicle_array;
		
			 if($_POST['lat']=='' || $_POST['long'] || $_POST['lat']==0 || $_POST['long']==0)	
			{
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
			}
    		 
			 $this->user_model->update_details(USERS,$_POST,array('id'=>$id));
			$ret['status']=1;
		}
		else
		{
			$ret['status']=0;
		}	
		echo json_encode($ret);
	}
	
	public function tasker_step3()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['heading']="Tasker Registration process step two";
			$this->data['tasker_city']=$this->tasker_model->get_all_details(TASKER_CITY, array('status'=>'Active'));
			$this->data['tasker_vehicle']=$this->tasker_model->get_all_details(TASKER_VEHICLE, array('status'=>'Active'));
			$this->data['task_category']=$this->tasker_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active'));
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->data['id']=$id;
			$this->load->view('site/tasker/step3',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	public function edit_tasker_taskdetails()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['heading']="Tasker Registration process step two";
			$this->data['tasker_city']=$this->tasker_model->get_all_details(TASKER_CITY, array('status'=>'Active'));
			$this->data['tasker_vehicle']=$this->tasker_model->get_all_details(TASKER_VEHICLE, array('status'=>'Active'));
			$this->data['task_category']=$this->tasker_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active'));
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->data['id']=$id;
			$this->load->view('site/tasker/step3_edit',$this->data);
		}
		else
		{
			echo "Session loggedout so login again!";
		}
	}
	
	public function save_tasker_category()
	{
		if($this->checkLogin('U')!='')
		{
			$id=$this->checkLogin('U');
			$task_category_id=$_POST['task_category_id'];
			$task_sub_category='';
			if(isset($_POST['task']))
			{
				$task_sub_category=implode(',',$_POST['task']);
			}			
			$subcat_id='';
			if(isset($_POST['subcat_'.$task_category_id]))
			{
				$subcat_id=implode(',',$_POST['subcat_'.$task_category_id]);
			}
           /* 	print_r($subcat_id);die; */	
            /*currency_update*/
			  
			  $price=round($_POST['amount'.$task_category_id]/$this->data['currency_rate'],2);
            /*currency_update*/		   
			$dataarray=array('task_category_id'=>$task_category_id,'user_id'=>$id,'price'=>$price,'task_sub_category'=>$task_sub_category,'tasker_description'=>$_POST['tasker_description_'.$task_category_id],'experience'=>$_POST['experience_'.$task_category_id],'subcat_id'=>$subcat_id);
			$exsisting_check=$this->tasker_model->get_all_details(TASKER_CATEGORY_SELECTION,array('task_category_id'=>$task_category_id,'user_id'=>$id));
			if($exsisting_check->num_rows()==0)
			{
				$this->tasker_model->simple_insert(TASKER_CATEGORY_SELECTION,$dataarray);
				$ret['status']=1;
			}
			else
			{
				$this->tasker_model->update_details(TASKER_CATEGORY_SELECTION,$dataarray,array('task_category_id'=>$task_category_id,'user_id'=>$id));
				$ret['status']=2;
			}
			
			
		}
		else
		{
			$ret['status']=3;
			
		}
		echo json_encode($ret);
	}
	
	public function delete_tasker_category()
	{
		if($this->checkLogin('U')!='')
		{
			$id=$this->checkLogin('U');
			$task_category_id=$_POST['task_category_id'];
			$this->tasker_model->commonDelete(TASKER_CATEGORY_SELECTION,array('user_id'=>$id,'task_category_id'=>$task_category_id));
			$ret['status']=1;
		}
		else
		{
			$ret['status']=2;
			
		}
		echo json_encode($ret);
	}
	
	public function save_step3()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$newarray['tasker_step3']=1;
			$this->user_model->update_details(USERS,$newarray,array('id'=>$id));
			$ret['status']=1;
		}
		else
		{
			$ret['status']=0;
		}	
		echo json_encode($ret);
	}
	
	public function tasker_step4()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['heading']="Tasker Registration process step four";
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->load->view('site/tasker/step4',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function edit_credit_card()
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
			$this->data['card_comp']='';
			$this->data['card_last']='';
			if($this->data['user']->stripe_customer_id!=''){
			$response=json_decode($stripe->customer_info($this->data['user']->stripe_customer_id)); 
			$res_array=$response->sources->data[0];
			$this->data['card_comp']=$res_array->brand;
			$this->data['card_last']=$res_array->last4;
			}
			$this->load->view('site/tasker/step4_edit',$this->data);
		}
		else
		{
			echo "Session loggedout so login again!";
		}
	}
	
	public function save_step4()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$newarray['tasker_step4']=1;			
			$newarray['tasker_completed']=1;			
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
				$ret['error_new']= $response->error->message;
			}
			if($ret['error_new']=='')
			{
				$user=$this->tasker_model->get_all_details(USERS,array('id'=>$id))->row();
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
						$this->tasker_model->update_details(USERS,$newarray,array('id'=>$id));
					
						$userdata = array (
						'task_category_id' => '',
						'tasker_id' => '',
						'task_description' => '',
						'task_date' => '',
						'task_time' => '',
						'task_category_city' => '' 
						);
						 $ret['tasker_automation']="";
						$this->session->unset_userdata ( $userdata );
						if($this->config->item('tasker_automation')==1)
						{
						  $this->tasker_model->update_details(USERS,array('tasker_completed'=>'0'),array('id'=>$id));
						  $this->mail_model->tasker_registration_email($user);
						  $ret['tasker_automation']=1;
						}
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
			$ret['status']=0;
		}	
		echo json_encode($ret);
	}
	

	public function change_creditcard()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
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
				$ret['error_new']= $response->error->message;
			}
			if($ret['error_new']=='')
			{
				$user=$this->tasker_model->get_all_details(USERS,array('id'=>$id))->row();
				$user_email=$user->email;
				$customer=json_decode($stripe->customer_create($token_id,$user_email));
				if(isset($customer->id))
				{
					$customer_id=$customer->id;
					/* if($user->tasker_completed==0)
					{
					$desc='Tasker signup fee $'.$total_amount;
					$currency_type='USD';
					$charge=json_decode($stripe->charge_customer($total,$customer_id,$desc,$currency_type));
					if(isset($charge->id))
					{
						
						$newarray['stripe_customer_id']=$customer_id;
						$newarray['tasker_completed']=1;
						$this->tasker_model->update_details(USERS,$newarray,array('id'=>$id));
					
						
					}
					else
					{
						$ret['error_new']= $charge->error->message;
					}
					} 
					else
					{
						$newarray['stripe_customer_id']=$customer_id;
						$this->tasker_model->update_details(USERS,$newarray,array('id'=>$id));
					}*/
					    $newarray['stripe_customer_id']=$customer_id;
						$this->tasker_model->update_details(USERS,$newarray,array('id'=>$id));
				}
				else
				{
					$ret['error_new']= $customer->error->message;
				}
			}
			
			
		}
		else
		{
			$ret['status']=0;
		}	
		echo json_encode($ret);
	}
	
	public function cancel_stripe()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->tasker_model->update_details(USERS,array('stripe_user_id'=>''),array('id'=>$id));
				
			redirect(base_url().'account');
		}
		else
		{
			redirect(base_url());
		}
	}
	public function get_latlong() {
		$address = $this->input->post('city');
		$zipcode = $this->input->post('zipcode');
		$address = str_replace(" ", "+", $address);
		$gmap_key=$this->config->item('gmap_key');
		$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&&components=postal_code:$zipcode&sensor=false&key=$gmap_key");
		$json = json_decode($json);
		if($json->status=='OK')
		{
			$newAddress = $json->{'results'}[0]->{'address_components'};
			$retrnstr['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			$retrnstr['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
			$retrnstr['status']=$json->status;
		}
		else
		{
			$retrnstr['status']=$json->status;
			$retrnstr['lat'] = 0;
			$retrnstr['long'] = 0;
		}
		echo json_encode($retrnstr);
	}
	
	public function tasker($id)
	{
		/* if($this->checkLogin('U')!='')
		{ */   
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->data['heading']=$this->data['user']->first_name." profile";
			$this->data['tasks']=$this->tasker_model->get_all_details(TASKER_CATEGORY_SELECTION,array('user_id'=>$id));
			$this->data['tasks_done']=$this->tasker_model->get_all_details(BOOKING,array('tasker_id'=>$id,'status'=>"paid"));
			$this->data['work_city_new']=$this->tasker_model->get_all_details(TASKER_CITY,array('id'=>$this->data['user']->work_city)); 
			$this->data['task_category']=$this->tasker_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active'));	
			$this->data['task_category_top']=$this->tasker_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$this->session->userdata('task_category_id')));	
			$this->data['reviews']=$this->tasker_model->get_reviews_details($id);
			$this->data['subcat_name']=$this->session->userdata('subcat_name');
			$this->data['subcat_id']=$this->session->userdata('subcat_id');
			$this->data['cat_name']=$this->session->userdata('cat_name');
			#$this->load->view('site/tasker/tasker_profile',$this->data);
			$this->load->view('site/tasker/tasker_tasks',$this->data);
		/* }
		else
		{
			redirect(base_url());
		} */
	}
	public function hireme($id)
	{
		/* if($this->checkLogin('U')!='')
		{ */   
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->data['heading']=$this->data['user']->first_name." tasks";
			$this->data['tasks']=$this->tasker_model->get_all_details(TASKER_CATEGORY_SELECTION,array('user_id'=>$id));
			$this->data['tasks_done']=$this->tasker_model->get_all_details(BOOKING,array('tasker_id'=>$id,'status'=>"paid"));
			$this->data['work_city_new']=$this->tasker_model->get_all_details(TASKER_CITY,array('id'=>$this->data['user']->work_city));
			$this->data['logcheck']=$this->checkLogin('U');
			$this->data['task_category']=$this->tasker_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active'));	
			$this->data['task_category_top']=$this->tasker_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$this->session->userdata('task_category_id')));	
			$this->data['reviews']=$this->tasker_model->get_reviews_details($id);
			$this->data['subcat_name']=$this->session->userdata('subcat_name');
			$this->data['subcat_id']=$this->session->userdata('subcat_id');
			$this->data['cat_name']=$this->session->userdata('cat_name');
			$this->load->view('site/tasker/tasker_tasks',$this->data);
		/* }
		else
		{
			redirect(base_url());
		} */
	}
	
	public function tasker_reviews($id)
	{
		/* if($this->checkLogin('U')!='')
		{ */   
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->data['heading']=$this->data['user']->first_name." reviews";
			$this->data['tasks']=$this->tasker_model->get_all_details(TASKER_CATEGORY_SELECTION,array('user_id'=>$id));
			$this->data['tasks_done']=$this->tasker_model->get_all_details(BOOKING,array('tasker_id'=>$id,'status'=>"paid"));
			$this->data['work_city_new']=$this->tasker_model->get_all_details(TASKER_CITY,array('id'=>$this->data['user']->work_city)); 
			$this->data['task_category_top']=$this->tasker_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active','id'=>$this->session->userdata('task_category_id')));	
			$this->data['reviews']=$this->tasker_model->get_reviews_details($id);
			$this->data['subcat_name']=$this->session->userdata('subcat_name');
			$this->data['subcat_id']=$this->session->userdata('subcat_id');
			$this->data['cat_name']=$this->session->userdata('cat_name');
			$this->load->view('site/tasker/tasker_review',$this->data);
		/* }
		else
		{
			redirect(base_url());
		} */
	}
	
	public function tasker_enquires_load()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['book_details']=$this->tasker_model->tasker_enquires_load($id);
			$this->load->view('site/tasker/task_request',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	public function save_tasker_request_respond()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$_POST['id'];
			$status=$_POST['status'];			
			$this->tasker_model->update_details(BOOKING,array('status'=>$status),array('id'=>$id));
			
			$get_booking=$this->tasker_model->get_all_details(BOOKING,array('id'=>$id));
			$notifiy_array=array('message'=>'Your task request '.$status.' by '.$this->data['userDetails']->row()->first_name,
				'title'=>'Task request '.$status,
				'viewer_id'=>$get_booking->row()->user_id,
				'viewer_status'=>'1',
				'message_status'=>'1',
				'booking_id'=>$id,
				'user_id'=>$get_booking->row()->tasker_id
				);
			$this->user_model->simple_insert(NOTIFICATION,$notifiy_array);
			$this->mail_model->send_booking_respond_emails($id);	
			echo '1';
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function stripe_response()
	{
		
		if($_SESSION['stripe_user_id_webview']!="")
		{
			 if (isset($_GET['code'])) { 
				$code = $_GET['code'];
				$id=$_SESSION['stripe_user_id_webview'];
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
			  $_SESSION['stripe_user_id_webview']="";
			  redirect(base_url('json/stripe_connect_success'));
			}
			else
			{
				$this->session->set_flashdata('alert_message', 'Stripe not connected try again...');
				$this->session->set_flashdata('error_type', 'error');
				$_SESSION['stripe_user_id_webview']="";
				redirect(base_url('json/stripe_connect_failure'));
			}
		}
		else{
			if (isset($_GET['code'])) { 
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
		}		
	}
	
	public function block_dates()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$this->data['heading']="Tasker date block";
			$this->data['user']=$this->tasker_model->get_all_details(USERS, array('id'=>$id))->row();
			$this->data['block_dates']=$this->tasker_model->get_block_dates($id);
			$disabled_dates='';
			if($this->data['block_dates']->num_rows()>0)
			{   
		        foreach($this->data['block_dates']->result() as $bdates)
				{
					$disabled_dates[]='"'.$bdates->task_date.'"';
				}
				$this->data['disabled_dates']=implode(',',$disabled_dates);
			}
			else{
			$this->data['disabled_dates']='';
			}
			$this->data['task_cat']=$this->tasker_model->get_selected_category($id);
			$this->load->view('site/tasker/block_dates',$this->data);
		}
		else
		{
			redirect(base_url());
		}
	}
	public function getDatesFromRange($start, $end) {
		$dates = array (
				$start 
		);
		while ( end ( $dates ) < $end ) {
			$dates [] = date ( 'Y-m-d', strtotime ( end ( $dates ) . ' +1 day' ) );
		}
		
		return $dates;
	}
	public function insert_block_dates()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$mname=$_POST['task_category_name'];
			$sname=$_POST['sub_category_name']; 
			unset($_POST['sub_category_name']);
			unset($_POST['task_category_name']);
			$task_datelist=explode('to',$_POST['task_date']);
			$current=date('Y-m-d',strtotime($task_datelist[0]));
			$last=date('Y-m-d',strtotime($task_datelist[1]));
			$dates=$this->getDatesFromRange($current,$last);

			foreach($dates as $task_dates){
			$_POST['task_date']	=$task_dates;
			/* $ex_block_dates=$this->tasker_model->get_all_details(BLOCK_DATES, array('tasker_id'=>$id,'task_category_id'=>$_POST['task_category_id'],'subcat_id'=>$_POST['subcat_id'],'task_date'=>$_POST['task_date'],'task_time'=>$_POST['task_time']));	
			 */
			 $ex_block_dates=$this->tasker_model->get_all_details(BLOCK_DATES, array('tasker_id'=>$id,'task_date'=>$_POST['task_date'],'task_time'=>$_POST['task_time']));	
			$ret['res']='';	
			if($ex_block_dates->num_rows()==0)
			{
			$_POST['tasker_id']=$id;
			$this->tasker_model->simple_insert(BLOCK_DATES,$_POST);
			$bid=$this->tasker_model->get_last_insert_id();
			$ex_data=$this->tasker_model->get_all_details(BLOCK_DATES,array('id'=>$bid))->row();
			$ret['error_new']='';
			$ret['res']='';
			}
			else
			{
				$ret['error_new']='Already Exist';
			}
			}
		}
		else
		{
			redirect(base_url());
		}
		echo json_encode($ret);
	}
	public function del_block_date()
	{
		if($this->checkLogin('U')!='')
		{   
			$id=$this->checkLogin('U');
			$task_datelist=explode('to',$_POST['task_date']);
			$current=date('Y-m-d',strtotime($task_datelist[0]));
			$last=date('Y-m-d',strtotime($task_datelist[1]));
			$dates=$this->getDatesFromRange($current,$last);
			foreach($dates as $task_dates){
			$this->tasker_model->commonDelete(BLOCK_DATES,array('tasker_id'=>$id,'task_date'=>$task_dates)); 
			}
			$ret['error_new']="success";
		}
		
		echo json_encode($ret);
	}

	public function fill_subcat()
	{
		if($this->checkLogin('U')!='')
		{   
			$re='';
			$id=$_POST['mid'];
			$res=$this->tasker_model->get_all_details(TASKER_SUB_CATEGORY,array('cat_id'=>$id));
			foreach($res->result() as $res)
			{
				$re.='<option value="'.$res->id.'">'.$res->subcat_name.'</option>';
			}
			echo $re;
		}
		
	}
	/*otp*/
	public function otp_message($to,$msg)
	{
		$otpmsg="OTP from ".$this->config->item('site_name')." don't share with anyone otp is".$msg;
		$this->mail_model->send_text($to,$otpmsg);
	}
	/*otp*/
	
	

}
