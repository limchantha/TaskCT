<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('url','cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('landing_model');
		$this->load->model('mail_model');
		
    } 
	public function index()
	{
		$this->data['task_category']=$this->landing_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active'));
		$this->data['task_category1']=$this->landing_model->get_service();
		$this->data['get_service_featured']=$this->landing_model->get_service_featured();
		$this->data['review_list']=$this->landing_model->get_reviews();
		$this->data['cms_service']=$this->user_model->get_all_details(CMS,array('status'=>'Active','footer_order'=>'services'));
		$this->load->view('site/landing/landing',$this->data);
	} 
	
	public function contact_us()
	{
		$this->data['heading']="Contact us";
		$this->load->view('site/landing/contact_us',$this->data);
	}
	public function save_contactus()
	{
		$this->landing_model->simple_insert(CONTACTUS,$_POST);
		$new_array=$_POST;
		$check=$this->mail_model->send_contact_mail($new_array);
		echo json_encode(array('result'=>1));
	}
	
}
