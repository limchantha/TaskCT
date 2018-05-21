<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('user_model');
	    if($this->check_prev('Users',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
		
    }
	
	public function dashboard()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display User List";
			$this->data['user']=$this->user_model->get_all_details(USERS,array('group'=>'0'));
			$this->data['active_user']=$this->user_model->get_all_details(USERS,array('status'=>'Active'));
			$this->data['new_user']=$this->user_model->get_all_details(USERS,array('(created)'=>date('Y-m-d'))); 
			$this->load->view('admin/user/dashboard',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	

   public function display_user_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display User List";
			$this->data['user']=$this->user_model->get_all_details(USERS,array('group'=>'0'));
			$this->load->view('admin/user/display_user_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
   public function export_user_list()
	{
		if($this->checkLogin('A')!='')
		{   
	
			$fields_wanted=array('id','first_name','last_name','email','phone','zipcode','created','last_login_date','last_login_ip');
			$table=USERS;
			$users=$this->user_model->export_user_details($table,$fields_wanted);
			$this->data['users_detail']=$users['users_detail']->result();
			$this->load->view('admin/user/export_user',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	

	public function delete_user($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->user_model->commonDelete(USERS,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/user/display_user_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_user($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add User";			
			$this->load->view('admin/user/add_user',$this->data);
			}
			else
			{
			$this->data['heading']="Edit User";
			$this->data['user']=$this->user_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->load->view('admin/user/add_user',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
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
	
	public function add_edit_insert($id='')
	{
		if($this->checkLogin('A')!='')
		{  

			if($_POST['password']!='')
			{
				$_POST['password']=md5($_POST['password']); 
			}
			else
			{
				unset($_POST['password']);
			}
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000;
		    $config['upload_path'] = './images/site/profile';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('photo')){
		    	$imgDetails = $this->upload->data();
		    	$_POST['photo'] = $imgDetails['file_name'];
			}   
			if($id=='')
			{
			
			 $this->user_model->simple_insert(USERS,$_POST);
			 $this->session->set_flashdata('alert_message', 'Successfully created');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/user/display_user_list');
			
			}
			else
			{
			 $this->user_model->update_details(USERS,$_POST,array('id'=>$id));
			 $this->session->set_flashdata('alert_message', 'Successfully updated');
		     $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/user/display_user_list');
			}
		}
		else
		{
			redirect(base_url().'admin');
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
	
	public function change_status($id,$status)
	{   
		
		if($status==0)
		{
			$statu="Inactive";
		}
		else
		{
			$statu="Active";
		}
		$this->user_model->update_details(USERS,array('status'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/user/display_user_list');

	}

	

}
