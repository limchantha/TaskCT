<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('cms_model');
		
    }
	
	

   public function page($value)
	{
			$this->data['content1']=$this->cms_model->get_all_details(CMS,array('url'=>$value));
			if($this->data['content1']->num_rows()>0)
			{
			$this->data['heading']=ucfirst($this->data['content1']->row()->url);			
			$this->load->view('site/cms/content',$this->data);
			}
			else
			{
				redirect();
			}
		
	}	
  
	  public function services()
	{
			$id=$this->uri->segment('3');
			$this->data['content1']=$this->cms_model->get_all_details(TASKER_CATEGORY, array('id'=>$id));
		   	if($this->data['content1']->num_rows()>0)
			{
			$this->data['heading']=ucfirst($this->data['content1']->row()->task_name);			
			$this->load->view('site/cms/service',$this->data);
			}
			else
			{
				redirect();
			}
		
	}	
  
	

	

}
