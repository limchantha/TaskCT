<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subadmin extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('subadmin_model');
		if($this->check_prev('Subadmin',0)==FALSE)
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
			$this->data['user']=$this->subadmin_model->get_all_details(USERS,array('group'=>'0'));
			$this->data['active_user']=$this->subadmin_model->get_all_details(USERS,array('status'=>'Active'));
			$this->data['new_user']=$this->subadmin_model->get_all_details(USERS,array('(created)'=>date('Y-m-d'))); 
			$this->load->view('admin/user/dashboard',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	

   public function display_subadmin_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Admins List";
			$this->data['user']=$this->subadmin_model->get_all_details(ADMIN,array('admin_status'=>'1'));
			$this->load->view('admin/subadmin/display_subadmin_list',$this->data);
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
	
			$fields_wanted=array('id','firstname','lastname','email');
			$table=ADMIN;
			$users=$this->subadmin_model->export_user_details($table,$fields_wanted);
			$this->data['users_detail']=$users['users_detail']->result();
			$this->load->view('admin/user/export_user',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	

	public function delete_subadmin($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->subadmin_model->commonDelete(ADMIN,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/subadmin/display_subadmin_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_subadmin($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add Subadmin";			
			$this->load->view('admin/subadmin/add_subadmin',$this->data);
			}
			else
			{
			$this->data['heading']="Edit Subadmin";
			$this->data['user']=$this->subadmin_model->get_all_details(ADMIN,array('id'=>$id))->row();
			$this->load->view('admin/subadmin/add_subadmin',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    public function check_email()
	{   $email=$this->input->post('email');
		$t=count($this->subadmin_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
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

			
			$email=$_POST['email'];
			$firstname=$_POST['firstname'];
			$lastname=$_POST['lastname'];
			$password=$_POST['password'];
			unset($_POST['email']);
			unset($_POST['firstname']);
			unset($_POST['lastname']);
			unset($_POST['password']);			
			$per=serialize($_POST);					
			$_POST['email']=$email;
			$_POST['firstname']=$firstname;
			$_POST['lastname']=$lastname;
			$_POST['password']=$password;
			/*if($_POST['password']!='')
			{
				$_POST['password']=sha1($_POST['password']); 
			}
			else
			{
				unset($_POST['password']);
			} */
			$dataarray=array('firstname'=>$_POST['firstname'],'lastname'=>$_POST['lastname'],'email'=>$_POST['email'],'permission'=>$per,'admin_status'=>1);	
			 if($_POST['password']!='')
				{
					$dataarray['password']=sha1($_POST['password']); 
				}
			if($id=='')
			{
			 $checksub=$this->subadmin_model->get_all_details(ADMIN,array('email'=>$_POST['email']));
			 if($checksub->num_rows()==0){
			 $this->subadmin_model->simple_insert(ADMIN,$dataarray);
			 $this->session->set_flashdata('alert_message', 'Successfully Subadmin created');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/subadmin/display_subadmin_list');
			 }
			 else
			 {
			 $this->session->set_flashdata('alert_message', ' Subadmin email already exist.');
		     $this->session->set_flashdata('error_type', 'error');
			 redirect(base_url().'admin/subadmin/display_subadmin_list'); 
			 }
			
			}
			else
			{
			 $checksub=$this->subadmin_model->get_all_details(ADMIN,array('email'=>$_POST['email'],'id !='=>$id));
			 if($checksub->num_rows()==0){
			 $this->subadmin_model->update_details(ADMIN,$dataarray,array('id'=>$id));
			 $this->session->set_flashdata('alert_message', 'Successfully subadmin updated');
		     $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/subadmin/display_subadmin_list');
			 }
			  else
			 {
			 $this->session->set_flashdata('alert_message', ' Subadmin email already exist.');
		     $this->session->set_flashdata('error_type', 'error');
			 redirect(base_url().'admin/subadmin/display_subadmin_list'); 
			 }
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
		$t=count($this->subadmin_model->get_single_details(ADMIN,array('id'),array('email'=>$email,'id !='=>$id))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}

	

}
