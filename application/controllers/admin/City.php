<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('cms_model');
		if($this->check_prev('City',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_city_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display City List";
			$this->data['task']=$this->cms_model->get_all_details(TASKER_CITY,array());
			$this->load->view('admin/city/display_city_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
  
	public function delete_city($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->cms_model->commonDelete(TASKER_CITY,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/city/display_city_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_city($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add City";			
			$this->load->view('admin/city/add_city',$this->data);
			}
			else
			{
			$this->data['heading']="Edit City ";
			$this->data['service']=$this->cms_model->get_all_details(TASKER_CITY,array('id'=>$id))->row();
			$this->load->view('admin/city/add_city',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    public function check_email()
	{   $email=$this->input->post('email');
		$t=count($this->cms_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}
	public function add_edit_city_insert($id='')
	{
		if($this->checkLogin('A')!='')
		{  
            unset($_POST['s2id_autogen2']);
			
			if($id=='')
			{ 
		     $check_ex=$this->cms_model->get_all_details(TASKER_CITY,array('city_name'=>$_POST['city_name']));
			 if($check_ex->num_rows()==0){
			 $this->cms_model->simple_insert(TASKER_CITY,$_POST);
			 $this->session->set_flashdata('alert_message', 'Successfully created');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/city/display_city_list');
			 }
			 else
			 {
				 $this->session->set_flashdata('alert_message', 'Already exist.');
		         $this->session->set_flashdata('error_type', 'error'); 
				 redirect(base_url().'admin/city/display_city_list');
			 }
			
			}
			else
			{
			 $check_ex=$this->cms_model->get_all_details(TASKER_CITY,array('city_name'=>$_POST['city_name'],'id!='=>$id)); 
			 if($check_ex->num_rows()==0){	
			 $this->cms_model->update_details(TASKER_CITY,$_POST,array('id'=>$id));
			 $this->session->set_flashdata('alert_message', 'Successfully updated');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/city/display_city_list');
			 }
			 else
			 {
				 $this->session->set_flashdata('alert_message', 'Already exist.');
		         $this->session->set_flashdata('error_type', 'error'); 
				 redirect(base_url().'admin/city/display_city_list');
			 }
			}
		}
		else
		{
			redirect(base_url().'admin');
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
		$this->cms_model->update_details(TASKER_CITY,array('status'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/city/display_city_list');

	}
  

	

}
