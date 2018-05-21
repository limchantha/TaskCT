<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('gift_model');
		if($this->check_prev('Gift',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_gift_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display GIFT List";
			$this->data['task']=$this->gift_model->get_all_details(GIFT,array());
			$this->load->view('admin/gift/display_gift_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
   
   public function display_user_gift_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display User Gift List";
			$this->data['task']=$this->gift_model->get_gift_user();
			$this->load->view('admin/gift/display_user_gift_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
   
	
	public function add_gift($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add gift";            
			$this->load->view('admin/gift/add_gift',$this->data);
			}
			else
			{
			$this->data['heading']="Edit gift";
			$this->data['gift_list']=$this->gift_model->get_all_details(GIFT,array('id'=>$id))->row(); 
			$this->load->view('admin/gift/add_gift',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	
	public function add_edit_gift_insert($id='')
	{
		if($this->checkLogin('A')!='')
		{ 
			if($_POST['use_limit']!=0)
			{
				$_POST['per_price']=round($_POST['gift_price']/$_POST['use_limit']);
			}
			else
			{
				$_POST['per_price']=$_POST['gift_price'];
			}				
			if($id=='')
			{
			 $check_exist=$this->gift_model->get_all_details(GIFT,array('price'=>$_POST['price']));
			 if($check_exist->num_rows()==0){
				 $this->gift_model->simple_insert(GIFT,$_POST);
				 $this->session->set_flashdata('alert_message', 'Successfully gift card created');
				 $this->session->set_flashdata('error_type', 'success');
				 redirect(base_url().'admin/gift/display_gift_list');
			 }
			 else
			 {
				 $this->session->set_flashdata('alert_message', 'gift card price already exist');
				 $this->session->set_flashdata('error_type', 'error');
				 redirect(base_url().'admin/gift/display_gift_list');
		
			 }
			
			
			}
			else
			{
			  $check_exist=$this->gift_model->get_all_details(GIFT,array('price'=>$_POST['price'],"id !="=>$id));
			  if($check_exist->num_rows()==0){
				 $this->gift_model->update_details(GIFT,$_POST,array('id'=>$id));
				 $this->session->set_flashdata('alert_message', 'Successfully gift card updated');
				 $this->session->set_flashdata('error_type', 'success');
				 redirect(base_url().'admin/gift/display_gift_list'); 
			  }
			 else
			 {
				 $this->session->set_flashdata('alert_message', 'gift card price already exist');
				 $this->session->set_flashdata('error_type', 'error');
				 redirect(base_url().'admin/gift/display_gift_list');
		
			 }
			}
			
			
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 public function delete_task_review($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->gift_model->commonDelete(GIFT,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/gift/display_gift_list');
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
		$this->gift_model->update_details(GIFT,array('status'=>$status),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/gift/display_gift_list');

	}
	
	
    


	

}
