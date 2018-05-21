<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('service_model');
		if($this->check_prev('Services',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_service_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Services List";
			$this->data['task']=$this->service_model->get_all_details(TASKER_CATEGORY,array());
			$this->load->view('admin/service/display_service_list',$this->data);
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
			$users=$this->service_model->export_task_details($table,$fields_wanted);
			$this->data['users_detail']=$users['users_detail']->result();
			$this->load->view('admin/service/export_service',$this->data);
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
			
			$this->data['user']=$this->service_model->commonDelete(TASKER_CATEGORY,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/service/display_service_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_task_category($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add Service";			
			$this->load->view('admin/service/add_services',$this->data);
			}
			else
			{
			$this->data['heading']="Edit Service";
			$this->data['service']=$this->service_model->get_all_details(TASKER_CATEGORY,array('id'=>$id))->row();
			$this->load->view('admin/service/add_services',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    public function check_email()
	{   $email=$this->input->post('email');
		$t=count($this->service_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}
	
	public function add_edit_service_insert($id='')
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
				$imgerror="";				
			    list($width, $height) = getimagesize($path.$_POST['image']); 
		    	if($width>=364 && $height>=304){
					if(copy($path.$_POST['image'],$path1.$_POST['image']))
					{
						$this->ImageResizeWithCrop("750","362",$_POST['image'],$path1);
					}
					if(copy($path.$_POST['image'],$path2.$_POST['image']))
					{
						$this->ImageResizeWithCrop("368","362",$_POST['image'],$path2);
					}
					
					if(copy($path.$_POST['image'],$path3.$_POST['image']))
					{
						$this->ImageResizeWithCrop("364","304",$_POST['image'],$path3);
					}
				}
				else
				{
					$imgerror="Upload image morethan 364 X 304";
				}					
				
			}
			$config1['overwrite'] = FALSE;
	    	$config1['allowed_types'] = 'jpg|jpeg|gif|png|ico';
		    $config1['max_size'] = 300;
		    $config1['upload_path'] = './images/site/category/mobile';
		    $this->upload->initialize($config1);
			if ( $this->upload->do_upload('icon')){ 
				$imgDetails = $this->upload->data();/* echo '<pre>'; print_r($imgDetails);die; */
		    	$_POST['icon'] = $imgDetails['file_name'];
				$imgerror1="";				
			    
			}
			if($imgerror==""){	
			if($id=='')
			{
			
			 $this->service_model->simple_insert(TASKER_CATEGORY,$_POST);
			 $this->session->set_flashdata('alert_message', 'Successfully task category created');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/service/display_service_list');
			
			}
			else
			{
			 $this->service_model->update_details(TASKER_CATEGORY,$_POST,array('id'=>$id));
			 $this->session->set_flashdata('alert_message', 'Successfully task category updated');
		     $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/service/display_service_list');
			}
			}
			else
			{
				$this->session->set_flashdata('alert_message', $imgerror);
		        $this->session->set_flashdata('error_type', 'error');
			    redirect(base_url().'admin/service/display_service_list');
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
		$this->service_model->update_details(TASKER_CATEGORY,array('status'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/service/display_service_list');

	}

	public function change_featured($id,$status)
	{   
		
		
		$this->service_model->update_details(TASKER_CATEGORY,array('featured'=>$status),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully featured.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/service/display_service_list');

	}

	

}
