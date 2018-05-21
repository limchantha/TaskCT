<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(1);
class Subcat extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('service_model');
		$this->load->model('subcat_model');
		if($this->check_prev('Subcat',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_subcat_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Services Subcat List";
			$this->data['task']=$this->subcat_model->get_subcatlist();
			$this->load->view('admin/subcat/display_subcat_service_list',$this->data);
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
			$users=$this->subcat_model->export_task_details($table,$fields_wanted); 
			$this->data['users_detail']=$users->result();
			$this->load->view('admin/subcat/export_service',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	

	public function delete_task($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->service_model->commonDelete(TASKER_SUB_CATEGORY,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/subcat/display_subcat_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_task_subcategory($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add Sub Category";            
			$this->data['service_list']=$this->service_model->get_all_details(TASKER_CATEGORY,array('status'=>'Active')); 		
			$this->load->view('admin/subcat/add_cat',$this->data);
			}
			else
			{
			$this->data['heading']="Edit Sub Category";
			$this->data['service_list']=$this->service_model->get_all_details(TASKER_CATEGORY,array('status'=>'Active')); 
			$this->data['service']=$this->subcat_model->get_subcatlist($id)->row();
			$this->load->view('admin/subcat/add_cat',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    
	
	public function add_edit_servicecat_insert($id='')
	{
		if($this->checkLogin('A')!='')
		{ 
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000;
		    $config['upload_path'] = './images/site/category';
		    $this->load->library('upload', $config);
			$path='images/site/category/';
			$path1='images/site/category/size_big/';
			$path2='images/site/category/size_medium/';
			$path3='images/site/category/size_small/';
			if ( $this->upload->do_upload('image')){
				$imgDetails = $this->upload->data();
		    	$_POST['image'] = $imgDetails['file_name'];				
			}
			
			if($id=='')
			{
			 $check_service=$this->service_model->get_all_details(TASKER_SUB_CATEGORY,array('subcat_name'=>$_POST['subcat_name'],'cat_id'=>$_POST['cat_id'])); 
			 if($check_service->num_rows()<=0){
			 $this->service_model->simple_insert(TASKER_SUB_CATEGORY,$_POST);
			 $this->session->set_flashdata('alert_message', 'Successfully task category created');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/subcat/display_subcat_list');
			 }
			 else
			 {
			 $this->session->set_flashdata('alert_message', 'Sub category already exist...');
		     $this->session->set_flashdata('error_type', 'error');
			 redirect(base_url().'admin/subcat/display_subcat_list'); 
			 }
			
			}
			else
			{
				$check_service=$this->service_model->get_all_details(TASKER_SUB_CATEGORY,array('subcat_name'=>$_POST['subcat_name'],'id !='=>$id,'cat_id'=>$_POST['cat_id']));
			    if($check_service->num_rows()<=0){
				 $this->service_model->update_details(TASKER_SUB_CATEGORY,$_POST,array('id'=>$id));
				 $this->session->set_flashdata('alert_message', 'Successfully task category updated');
				 $this->session->set_flashdata('error_type', 'success');
				 redirect(base_url().'admin/subcat/display_subcat_list'); 
				 }
				 else
				 {
				 $this->session->set_flashdata('alert_message', 'Sub category already exist...');
				 $this->session->set_flashdata('error_type', 'error');
				 redirect(base_url().'admin/subcat/display_subcat_list'); 
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
		$this->service_model->update_details(TASKER_SUB_CATEGORY,array('status'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/subcat/display_subcat_list');

	}

	public function change_featured($id,$status)
	{   
		
		
		$this->service_model->update_details(TASKER_SUB_CATEGORY,array('featured'=>$status),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully featured.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/subcat/display_subcat_list');

	}

	

}
