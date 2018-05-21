<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tasker_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function check_mail_profile($email,$id)
	{
		$this->db->select('u.id');
		$this->db->from(USERS.' as u');
		$this->db->where('u.email',$email);
		$this->db->where('u.id !='.$id);
		return $query = $this->db->get();
	}
	
	function export_tasker_details($table,$fields_wanted)
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
	
	function tasker_enquires_load($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->where('t.id',$id);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function tasker_enquires_load_current($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->where('t.id',$id);
		$this->db->where('(b.status ="Accept" or b.status="Pending")');
		#$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->where('(b.booking_date >= "'.date('Y-m-d').'" or '.'b.status="Accept")');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function tasker_enquires_load_past($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->where('t.id',$id);
		$this->db->where('b.delete_status','0');
		$this->db->where('b.status','Cancel');
		/* $this->db->where('b.booking_date <',date('Y-m-d')); */
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function tasker_enquires_load_completed($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name,r.rate_val');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('t.id',$id);
		$this->db->where('b.delete_status','0');
		$this->db->where('b.status','Paid');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function get_selected_category($id)
	{
		$this->db->select('b.*,c.task_name');
		$this->db->from(TASKER_CATEGORY_SELECTION.' as b');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function get_block_dates($id)
	{
		$this->db->select('b.*,c.task_name,sc.subcat_name');
		$this->db->from(BLOCK_DATES.' as b');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','sc.id=b.subcat_id','left');
		$this->db->where('b.tasker_id',$id);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function get_reviews_details($id)
	{
		$this->db->select('u.first_name,u.last_name,u.photo,b.*');
		$this->db->from(REVIEWS.' as b');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->where('b.tasker_id',$id);
		$this->db->where('b.status','1');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	
	/*admin side*/
	
	function load_bookings($status)
	{
		$this->db->select('t.first_name as tname,t.email,(select sum(total_amount) from '.BOOKING.' where tasker_id=b.tasker_id and status="Paid") as total_task_amount,(select sum(service_fee) from '.BOOKING.' where tasker_id=b.tasker_id and status="Paid") as total_task_service_fee,(select sum(amount) from '.TRACKING_PAID.' where tasker_id=b.tasker_id) as paid_amount,u.first_name as uname,b.*,c.task_name,r.rate_val');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.status',$status);
		$this->db->group_by('b.tasker_id');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function load_detail_bookings($id)
	{
		$this->db->select('t.first_name as tname,t.email,u.first_name as uname,b.*,c.task_name,tp.amount as paid_amount');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TRACKING_PAID.' as tp','tp.booking_id=b.id','left');
		$this->db->where('b.status','Paid');
		$this->db->where('b.tasker_id',$id);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
    function get_tasker_based_on_cat()
	{
		$this->db->select('b.*,c.task_name,count(b.id) as countval');
		$this->db->from(TASKER_CATEGORY_SELECTION.' as b');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->group_by('c.task_name');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function get_tasker_completed_tasks_graph()
	{
		$this->db->select('t.first_name,count(b.id) as donetask_count,b.*');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id');
		$this->db->where('b.status','Paid');
		$this->db->group_by('b.tasker_id');
		$this->db->limit(10);
		$this->db->order_by('donetask_count','desc');
		return $query = $this->db->get();
		
	}
	
	/*admin side*/
	
	

	
}