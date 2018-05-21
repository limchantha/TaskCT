<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Reviews_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	function get_reviews()
	{
		$this->db->select('t.first_name as tfname,u.first_name as tname,b.*,c.task_name,r.rate_val,r.comments,r.id as rid,r.status as rstatus,r.featured');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function get_contactus($id="")
	{
		$this->db->select('b.*');
		$this->db->from(CONTACTUS.' as b');
		if($id!=""){
		$this->db->where('id',$id);
		}
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	
}