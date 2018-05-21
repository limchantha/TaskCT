<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('url','cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('landing_model');
		$this->load->model('mail_model');
		
    } 
	public function change_currency($type)
	{
		$get_currency=$this->landing_model->get_all_details(CURRENCY, array('status'=>'Active','currency_type'=>$type)); echo $this->db->last_query();
		$this->session->set_userdata('currency_code',$get_currency->row()->currency_type);
		$this->session->set_userdata('currency_symbol',$get_currency->row()->currency_symbols);
		$this->session->set_userdata('currency_rate',$get_currency->row()->currency_rate);
		$remo = $_SERVER['HTTP_REFERER'];
		redirect($remo);
	} 
	
	
	
}
