<?php
class Errors extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('url','cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('landing_model');
		
    } 
	public function index()
	{
		$this->output->set_status_header('404');
		$this->load->view('errors/error_404');
	}
 
	public function error_404()
	{
		$this->output->set_status_header('404');
		$this->load->view('site/common/header',$this->data);
		$this->load->view('errors/error_404',$this->data);
		$this->load->view('site/common/footer',$this->data);
	}
	public function page_missing()
	{
		#$this->output->set_status_header('404');
		$this->load->view('errors/error_404');
	}
}