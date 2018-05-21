<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Service_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function export_task_details($table,$fields_wanted)
	{
		$query='SELECT ';
		foreach($fields_wanted as $field)
		{
		if($field=='created')
		{
		$query .='DATE('.$field.') AS created'.',';
		}
		else{
		$query .=$field.',';
		}
		}
		$query=substr($query,0,-1);
		$query .=' FROM '.$table.' order by id desc';
		$data['users_detail']=$this->ExecuteQuery($query);
		
		return $data;
	}
	
}