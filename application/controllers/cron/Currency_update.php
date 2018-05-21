<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_update extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('user_model');
    }
	
	function index(){
		$curr = $this->user_model->get_all_details('fc_currency',array());
		$from = 'USD';
		foreach($curr->result() as $row){
			$to = $row->currency_type;
			$url = 'http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency='.$from.'&ToCurrency='.$to;
			$url = 'http://www.x-rates.com/calculator/?from='.$from.'&to='.$to.'&amount=1';
		    $data = @file_get_contents( 'http://www.x-rates.com/calculator/?from='.$from.'&to='.$to.'&amount=1');
            preg_match("/<span class=\"ccOutputRslt\">(.*)<\/span>/",$data, $conversion);   
			$rate_value =  (float) filter_var( $conversion[0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) ; 
			if($rate_value >= 0){ 
				$rate = $rate_value;
			}
			else $rate = 0;
			$condition = array('currency_type'=>$row->currency_type);
			$dataArr = array('currency_rate'=>$rate );
			$this->db->where($condition);
			$this->db->update('fc_currency',$dataArr);
		}
		redirect('');	
	}
}
	?>