<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Landing_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_service()
	{
		$this->db->select('u.*');
		$this->db->from(TASKER_CATEGORY.' as u');
		$this->db->where('u.featured','0');
		$this->db->limit(6);
		return $query = $this->db->get();
		
	}
	function get_service_featured()
	{
		$this->db->select('u.*');
		$this->db->from(TASKER_CATEGORY.' as u');
		$this->db->where('u.featured','1');
		$this->db->limit(2);
		return $query = $this->db->get();
		
	}	
	function get_review_list()
	{
		$this->db->select('u.*');
		$this->db->from(TASKER_REVIEW.' as u');
		$this->db->where('u.status','1');
		$this->db->limit(3);
		return $query = $this->db->get();
		
	}	
	
	function get_reviews()
	{
		$this->db->select('t.first_name as tfname,u.first_name as tname,b.*,c.task_name,r.rate_val,r.comments,r.id as rid,r.status as rstatus,r.featured,u.photo as uphoto');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id');
		$this->db->where('r.featured','1');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
}