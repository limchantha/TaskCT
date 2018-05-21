<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('payments_model');
		if($this->check_prev('Payments',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_payment_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display payments List";
			$this->data['task']=$this->payments_model->get_all_details(PAYMENTS,array());
			$this->load->view('admin/payments/display_payment_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
  
	public function delete_cms($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->payments_model->commonDelete(CMS,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/cms/display_cms_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_payments($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add Payments";			
			$this->load->view('admin/cms/add_cms',$this->data);
			}
			else
			{
			$this->data['heading']="Edit payments";
			$this->data['service']=$this->payments_model->get_all_details(PAYMENTS,array('id'=>$id))->row();
			$this->load->view('admin/payments/add_payments',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    public function check_email()
	{   $email=$this->input->post('email');
		$t=count($this->payments_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}
	
	public function add_edit_payments_insert($id='')
	{
		if($this->checkLogin('A')!='') 
		{   $name=$_POST['name']; unset($_POST['name']);
			if($_POST['mode']=="on"){$_POST['mode']=1;}else{$_POST['mode']=0;}
			$newarray=array('name'=>$name,'detail'=>json_encode($_POST));			
			 $this->payments_model->update_details(PAYMENTS,$newarray,array('id'=>$id));
			 $this->save_payments(strtolower($name.'_payment'),$_POST);
			 $this->session->set_flashdata('alert_message', 'Successfully updated');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/payments/display_payment_list');
			
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	public function save_payments($name,$new_values)
	{
		$new=''; 
		$get_new_val=$this->payments_model->get_all_details(PAYMENTS,array());
		foreach($get_new_val->result() as $key=>$value){ 
		$new.='$config["'.strtolower($value->name).'_payment"]='.'\''.$value->detail.'\''.';'.PHP_EOL;
		}
		$new='<?php '.$new.'?>';
		file_put_contents('./settings/payment.php',$new);
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
		$this->payments_model->update_details(CMS,array('status'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/cms/display_cms_list');

	}
   public function change_fpage($id,$status)
	{   
		
		$this->payments_model->update_details(CMS,array('footer_menu_status'=>$status),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/cms/display_cms_list');

	}

	

}
