<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Bookings_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function load_bookings($status)
	{
		$this->db->select('t.first_name as tname,u.first_name as uname,b.*,c.task_name,r.rate_val,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.status',$status);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function export_bookings($status)
	{
		$this->db->select('u.first_name as User,t.first_name as Tasker,b.id as Booking_No,c.task_name as Task,b.booking_date,b.booking_time,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.status',$status);
		$this->db->order_by('b.id','desc');
		 $query = $this->db->get();
		return $query->result_array();
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