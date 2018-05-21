<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailtemp extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('cms_model');
		if($this->check_prev('Email',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	

   public function display_email_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Email Template List";
			$this->data['task']=$this->cms_model->get_all_details(EMAIL,array());
			$this->load->view('admin/email/display_email_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
  
	public function delete_email($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->cms_model->commonDelete(EMAIL,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/emailtemp/display_email_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_email($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add Email Template";			
			$this->load->view('admin/email/add_email',$this->data);
			}
			else
			{
			$this->data['heading']="Edit cms page";
			$this->data['service']=$this->cms_model->get_all_details(EMAIL,array('id'=>$id))->row();
			$this->load->view('admin/email/add_email',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    
	public function add_edit_email_insert($id='')
	{
		if($this->checkLogin('A')!='')
		{  
            if(!is_dir('./email'))
			{
				mkdir('./email',0777);
			}
			
			if($id=='')
			{
			$this->cms_model->simple_insert_html(EMAIL,$_POST);
			$news_content_new = str_replace("{","'.",addslashes($_POST['email_desc']));
			$news_id=$this->db->insert_id();
			$news_descripe = str_replace("}",".'",$news_content_new);
			$config = "<?php \$message .= '";
			$config .= "$news_descripe";
			$config .= "';  ?>";
			$file = 'email/email'.$news_id.'.php';
			file_put_contents($file, $config);
			 $this->session->set_flashdata('alert_message', 'Successfully Email Template created');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/emailtemp/display_email_list');
			
			}
			else
			{
			$this->cms_model->update_details_html(EMAIL,$_POST,array('id'=>$id));
			$news_content_new = str_replace("{","'.",addslashes($_POST['email_desc']));
			$news_id=$id;
			$news_descripe = str_replace("}",".'",$news_content_new);
			$config = "<?php \$message .= '";
			$config .= "$news_descripe";
			$config .= "';  ?>";
			$file = 'email/email'.$news_id.'.php';
			file_put_contents($file, $config);
			 $this->session->set_flashdata('alert_message', 'Successfully Email Template updated');
		     $this->session->set_flashdata('error_type', 'success');
			  redirect(base_url().'admin/emailtemp/display_email_list');
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
		$this->cms_model->update_details(CMS,array('status'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/cms/display_cms_list');

	}
   
	

}
