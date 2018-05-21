<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Gift_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	function get_gift_user()
	{
		$this->db->select('u.first_name as uname,b.*');
		$this->db->from(GIFT_PAID.' as b');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
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