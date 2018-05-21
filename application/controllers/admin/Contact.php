<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('reviews_model');
		if($this->check_prev('Contact',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_contact_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Contact Enquiries List";
			$this->data['task']=$this->reviews_model->get_contactus();
			$this->load->view('admin/contact/display_contact_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
   
	
	  public function view_message($id)
	{
		if($this->checkLogin('A')!='')
		{   
			$this->data['heading']="Enquiry";
			$this->data['task']=$this->reviews_model->get_contactus($id);
			$this->load->view('admin/contact/view_contact',$this->data);
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
			$statu=0;
		}
		else
		{
			$statu=1;
		}
		$this->reviews_model->update_details(REVIEWS,array('status'=>$status),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/review/display_review_list');

	}

	

}
