<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_settings extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('user_model');
		
    }
	public function login()
	{ 
		if($this->checkLogin('A')!='')
		{
		 redirect(base_url().'admin/dashboard');
		}
		$this->load->view('admin/admin_settings/login',$this->data);
	}	
	
	public function logout() {
		
		$userdata = array (
				'gmtech_admin_id' => '',
				'gm_admin_email' => ''
				);
		$this->session->set_userdata ( $userdata );
		$this->session->set_userdata ('gm_admin_id',''); 
		redirect (base_url().'admin');
	}
	
	public function admin_login() {

		$email = $this->input->post ( 'admin_email' );
		$pwd = $this->input->post ( 'admin_password' );
		$pwd = sha1($pwd);
		$condition = array (
					'email' => $email,
					'password' => $pwd
			);
			$checkUser = $this->user_model->get_all_details ( ADMIN, $condition ); #echo $this->db->last_query(); 
			#echo $checkUser->num_rows ();
			if ($checkUser->num_rows () == '1') { 
				$userdata = array (
						'gmtech_admin_id' => $checkUser->row ()->id,
						'gmtech_admin_name' => $checkUser->row ()->firstname,
						'gm_session_prev' => $checkUser->row ()->permission,
						'gm_admin_email' => $checkUser->row ()->email
				);
				$this->session->set_userdata ( $userdata );	
				$this->user_model->save_data();				
				$returnStr ['status'] = 1; 
			}
			else
			{
			
				$returnStr ['message'] = 'Invalid login details';
				$returnStr ['status'] = 2;	
			}
				
		
		echo json_encode ( $returnStr );
	}
	
	public function dashboard()
	{
		if($this->checkLogin('A')!='')
		{
		$id=$this->checkLogin('A');
		$this->data['new_user']=$this->user_model->get_all_details(USERS,array('(created)'=>date('Y-m-d'),'group'=>0));			
		$this->data['new_tasker']=$this->user_model->get_all_details(USERS,array('(created)'=>date('Y-m-d'),'group'=>1));			
		$this->data['overall_booking']=$this->user_model->get_all_details(BOOKING,array('status'=>'Paid'));			
		$this->data['overall_admin_profit']=$this->user_model->overall_admin_profit();			
		$this->data['admin']=$this->user_model->get_all_details(ADMIN,array('id'=>$id))->row();
		$this->data['heading']="Recent Login User List";
		$this->data['user']=$this->user_model->get_all_details(USERS,array('group'=>'0','last_login_date >='=>date('Y-m-d',strtotime("-2 day")))); 
		$this->data['heading1']="Recent Login Tasker List";
		$this->data['user1']=$this->user_model->get_all_details(USERS,array('group'=>'1','last_login_date >='=>date('Y-m-d',strtotime("-2 day"))));
		#echo $this->db->last_query();
		$this->load->view('admin/admin_settings/dashboard',$this->data);
		}
		else
		{
		redirect(base_url().'admin');
		}
	}

	public function edit_admin_settings()
	{
		if($this->checkLogin('A')!='')
		{   $this->data['heading']="Admin Settings";
			$this->data['setting']=$this->user_model->get_all_details(ADMIN_SETTINGS,array('id'=>1))->row();
			$this->load->view('admin/admin_settings/edit_admin_settings',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	public function save_admin_settings($id='')
	{
		if($this->checkLogin('A')!='')
		{  

			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png|ico';
		    $config['max_size'] = 2000;
		    $config['upload_path'] = './images/site/logo';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('site_logo')){
		    	$imgDetails = $this->upload->data();
		    	$_POST['site_logo'] = $imgDetails['file_name'];
			}
			else{
				$_POST['site_logo'] =$this->config->item('site_logo');
			}				
			if ( $this->upload->do_upload('site_logo1')){
		    	$imgDetails1 = $this->upload->data();
		    	$_POST['site_logo1'] = $imgDetails1['file_name'];
			} 
			else{
				$_POST['site_logo1'] =$this->config->item('site_logo1');
			}			
			if ( $this->upload->do_upload('site_favicon')){
		    	$imgDetails2 = $this->upload->data();
		    	$_POST['site_favicon'] = $imgDetails2['file_name'];
			}
			else{
				$_POST['site_favicon'] =$this->config->item('site_favicon');
			}
             foreach($_POST as $key=>$val)
			 {
				 $admin_fill.= '$config["'.$key.'"]="'.addslashes($val).'";'. PHP_EOL;
			 }
			 $admin_fill='<?php '.$admin_fill. '?>';
			 file_put_contents('./settings/admin_settings.php',$admin_fill);	
			 //die;
			 unset($_POST['base_url']);
			 
			 $this->user_model->update_details(ADMIN_SETTINGS,$_POST,array('id'=>1));
			 $this->session->set_flashdata('alert_message', 'Successfully updated');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/admin_settings/dashboard');
			
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    public function edit_admin($id='1')
	{
		if($this->checkLogin('A')!='')
		{   			
			$this->data['heading']="Edit admin details";
			$this->data['user']=$this->user_model->get_all_details(ADMIN,array('id'=>$id))->row();
			$this->load->view('admin/admin_settings/edit_admin',$this->data);
			
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
		
	public function update_password($id='1')
	{  
		if($this->checkLogin('A')!='')
		{  
	         $dataarray=array('email'=>$_POST['email']);	
			 if($_POST['password']!='')
				{
					$dataarray['password']=sha1($_POST['password']); 
				}
			
			 $checksub=$this->user_model->get_all_details(ADMIN,array('email'=>$_POST['email'],'id !='=>$id));
			 if($checksub->num_rows()==0){
			 $this->user_model->update_details(ADMIN,$dataarray,array('id'=>$id));
			 $this->session->set_flashdata('alert_message', 'Successfully updated');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/dashboard');
			 }
			  else
			 {
			 $this->session->set_flashdata('alert_message', ' Email already exist.');
		     $this->session->set_flashdata('error_type', 'error');
			 redirect(base_url().'admin/dashboard'); 
			 }
			
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}

	
}
