<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('bookings_model');
		if($this->check_prev('Bookings',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_complete_bookings_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Completed bookings List";
			$this->data['task']=$this->bookings_model->load_bookings("Paid");
			$this->load->view('admin/bookings/display_booking_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
  public function display_pending_bookings_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Pending bookings List";
			$this->data['task']=$this->bookings_model->load_bookings("Pending");
			$this->load->view('admin/bookings/display_booking_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
  public function display_cancel_bookings_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Cancelled bookings List";
			$this->data['task']=$this->bookings_model->load_bookings("Cancel");
			$this->load->view('admin/bookings/display_booking_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
  public function export_bookings_list($status)
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']=$status;
			$this->data['users_detail']=$this->bookings_model->export_bookings("Paid");
			$this->load->view('admin/bookings/export_bookings',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
  
	
	

}
