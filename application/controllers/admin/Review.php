<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('reviews_model');
		if($this->check_prev('Reviews',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_review_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Reviews List";
			$this->data['task']=$this->reviews_model->get_reviews();
			$this->load->view('admin/review/display_review_list',$this->data);
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
			
			$this->data['user']=$this->reviews_model->commonDelete(REVIEWS,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/review/display_review_list');
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
	
	public function change_featured($id,$status)
	{   
		
		
		$this->reviews_model->update_details(REVIEWS,array('featured'=>$status),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully featured.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/review/display_review_list');

	}
	
	public function add_review($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add Review";            
			$this->load->view('admin/review/add_review',$this->data);
			}
			else
			{
			$this->data['heading']="Edit Review";
			$this->data['review_list']=$this->reviews_model->get_all_details(TASKER_REVIEW,array('id'=>$id))->row(); 
			$this->load->view('admin/review/add_review',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	
	public function add_edit_review_insert($id='')
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
			if ( $this->upload->do_upload('photo')){
				$imgDetails = $this->upload->data();
		    	$_POST['photo'] = $imgDetails['file_name'];				
			}
			
			if($id=='')
			{
			
			 $this->reviews_model->simple_insert(TASKER_REVIEW,$_POST);
			 $this->session->set_flashdata('alert_message', 'Successfully task category created');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/review/display_tasker_review_list');
			
			
			}
			else
			{
				
				 $this->reviews_model->update_details(TASKER_REVIEW,$_POST,array('id'=>$id));
				 $this->session->set_flashdata('alert_message', 'Successfully task category updated');
				 $this->session->set_flashdata('error_type', 'success');
				redirect(base_url().'admin/review/display_tasker_review_list'); 
				
			}
			
			
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	public function display_tasker_review_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Reviews List";
			$this->data['task']=$this->reviews_model->get_all_details(TASKER_REVIEW,array()); 
			$this->load->view('admin/review/display_tasker_review_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}

    public function tdelete_task_review($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->reviews_model->commonDelete(TASKER_REVIEW,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/review/display_tasker_review_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 
    
	public function tchange_status($id,$status)
	{   
		
		if($status==0)
		{
			$statu=0;
		}
		else
		{
			$statu=1;
		}
		$this->reviews_model->update_details(TASKER_REVIEW,array('status'=>$status),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/review/display_tasker_review_list');

	}	
   
    


	

}
