<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Subcat_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function export_task_details($table,$fields_wanted)
	{
		$this->db->select('ts.subcat_name,c.task_name,ts.status');
		$this->db->from(TASKER_SUB_CATEGORY.' as ts');
		$this->db->join(TASKER_CATEGORY.' as c','ts.cat_id=c.id');
		$this->db->where('c.status','Active');
		if($id!=""){
		$this->db->where('ts.id',$id);
		}
        $this->db->order_by('ts.id','desc');
		$query = $this->db->get();
		
		
		return $query;
	}
	
	function get_subcatlist($id="")
	{
		$this->db->select('c.id as ccat_id,c.task_name,ts.*');
		$this->db->from(TASKER_SUB_CATEGORY.' as ts');
		$this->db->join(TASKER_CATEGORY.' as c','ts.cat_id=c.id');
		$this->db->where('c.status','Active');
		if($id!=""){
		$this->db->where('ts.id',$id);
		}
        $this->db->order_by('ts.id','desc');
		return $query = $this->db->get();
		
	}
	
}