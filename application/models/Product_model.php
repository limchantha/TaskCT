<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Product_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_properties_published($where1)
	{
		$this->db->select('p.*,pa.img_name,u.email,u.first_name,u.photo,pt.list_value as type ');
		$this->db->from(PROPERTY.' as p');
		$this->db->join(PROPERTY_PHOTO.' as pa',"pa.p_id=p.id","LEFT");
		$this->db->join(PROPERTY_TYPE_VALUES.' as pt',"pt.id=p.property_type","LEFT");
		$this->db->join(USERS.' as u',"u.id=p.user_id");
		$this->db->where('p.id',$where1);
		$this->db->where('p.status',"Publish");
		$this->db->group_by('p.id');
		return $query = $this->db->get();
		
	}
	function get_page()
	{
		 
 		return $this->db->count_all_results('fc_freereg');
	}
	
	function get_page_result($start,$limit)
	{
		$this->db->limit($limit,$start);
		$result	= $this->db->get('fc_freereg');
		return $result	= $result->result();
	}
	
	
	
	
}