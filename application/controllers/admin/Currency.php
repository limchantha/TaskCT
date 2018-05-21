<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(1);
class Currency extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('currency_model');
		if($this->check_prev('Currency',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_currency_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Currency List";
			$this->data['currency_list']=$this->currency_model->get_all_details(CURRENCY,array());
			$this->load->view('admin/currency/display_currency_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
   public function export_task_list()
	{
		if($this->checkLogin('A')!='')
		{   
	
			$fields_wanted=array('id','task_name','task_title','avg_price','status','admin_percentage','cancel_percentage');
			$table=TASKER_CATEGORY;
			$users=$this->currency_model->export_task_details($table,$fields_wanted); 
			$this->data['users_detail']=$users->result();
			$this->load->view('admin/currency/export_service',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	

	public function delete_currency($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->currency_model->commonDelete(CURRENCY,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/currency/display_currency_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_currency($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add Currency";            
			$this->load->view('admin/currency/add_currency',$this->data);
			}
			else
			{
			$this->data['heading']="Edit Currency";
			$this->data['currency']=$this->currency_model->get_all_details(CURRENCY,array('id'=>$id))->row(); 
			$this->load->view('admin/currency/add_currency',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    
	
	public function add_edit_currency_insert($id='')
	{
		if($this->checkLogin('A')!='')
		{ 
			
			
			if($id=='')
			{
			 $check_service=$this->currency_model->get_all_details(CURRENCY,array('currency_type'=>$_POST['currency_type'])); 
			 if($check_service->num_rows()<=0){
			 $this->currency_model->simple_insert(CURRENCY,$_POST);
			 $this->session->set_flashdata('alert_message', 'Successfully currency added');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/currency/display_currency_list');
			 }
			 else
			 {
			 $this->session->set_flashdata('alert_message', 'Currency already exist...');
		     $this->session->set_flashdata('error_type', 'error');
			 redirect(base_url().'admin/currency/display_currency_list'); 
			 }
			
			}
			else
			{
				$check_service=$this->currency_model->get_all_details(CURRENCY,array('currency_type'=>$_POST['currency_type'],'id !='=>$id));
			    if($check_service->num_rows()<=0){
				 $this->currency_model->update_details(CURRENCY,$_POST,array('id'=>$id));
				 $this->session->set_flashdata('alert_message', 'Successfully currency updated');
				 $this->session->set_flashdata('error_type', 'success');
				 redirect(base_url().'admin/currency/display_currency_list'); 
				 }
				 else
				 {
				 $this->session->set_flashdata('alert_message', 'Currency already exist...');
				 $this->session->set_flashdata('error_type', 'error');
				 redirect(base_url().'admin/currency/display_currency_list'); 
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
		$this->currency_model->update_details(CURRENCY,array('status'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/currency/display_currency_list');

	}

	

	

}
