<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Subadmin_model extends My_Model
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
	
	function export_user_details($table,$fields_wanted)
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
	
	
	
	
	function get_tasker_count($where1)
	{
		$this->db->select('count(u.id) as total_count');
		$this->db->from(USERS.' as u');
		$this->db->where('u.group','1');
		$this->db->where($where1);
		return $query = $this->db->get();
		
	}
	
	function get_tasker_search_details($where1,$cat_id,$id,$date,$time)
	{
		$this->db->select('u.*,ts.*,(select avg(rate_val) from '.REVIEWS.' where tasker_id=u.id)as rate,(select count(id) from '.BLOCK_DATES.' td where td.tasker_id=u.id and td.task_date="'.$date.'" and td.task_time="0")as block_full,(select count(id) from '.BLOCK_DATES.' td where td.tasker_id=u.id and td.task_date="'.$date.'" and td.task_time="1")as block_m,(select count(id) from '.BLOCK_DATES.' td where td.tasker_id=u.id and td.task_date="'.$date.'" and td.task_time="2")as block_a,(select count(id) from '.BLOCK_DATES.' td where td.tasker_id=u.id and td.task_date="'.$date.'" and td.task_time="3")as block_n');
		$this->db->from(USERS.' as u');
		$this->db->join(TASKER_CATEGORY_SELECTION.' as ts','u.id=ts.user_id','left');
		$this->db->where('ts.task_category_id',$cat_id);
		$this->db->where('u.tasker_completed','1');
		$this->db->where('u.group','1');
		$this->db->where('u.id !=',$id);
		$this->db->having('block_full <= 0');
		$this->db->where($where1);
		$this->db->group_by('u.id');
		return $query = $this->db->get();
		
	}
	
	function gettasker_taskdetails($id,$cat_id)
	{
		$this->db->select('u.*,ts.*');
		$this->db->from(USERS.' as u');
		$this->db->join(TASKER_CATEGORY_SELECTION.' as ts','u.id=ts.user_id','left');
		$this->db->where('ts.task_category_id',$cat_id);
		$this->db->where('u.group','1');
		$this->db->where('u.id =',$id);
		return $query = $this->db->get();
		
	}
	
	function get_booked_status($cat_id,$booking_date,$booking_time)
	{
		$this->db->select('u.tasker_id');
		$this->db->from(BOOKING.' as u');
		$this->db->where('u.task_category_id="'.$cat_id.'" and u.booking_date="'.$booking_date.'" and u.booking_time="'.$booking_time.'" and (u.status="Paid" or u.status="Accept")');
		return $query = $this->db->get();
		
	}
	
	function task_list_load($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function load_transaction_list($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,ct.total_amount as tot');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(TRANSACTION.' as ct','ct.booking_id=b.id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->where('b.status="Paid" or b.status="Cancel"');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
   function export_transaction_list($id)
	{
		$this->db->select('t.first_name as Tasker_name,c.task_name as Task_name,b.booking_date,ct.total_amount as Paid_amount');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(TRANSACTION.' as ct','ct.booking_id=b.id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->where('b.user_id',$id);
        $this->db->where('b.status="Paid" or b.status="Cancel"');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function load_available_balance($id)
	{
		$this->db->select('t.*,b.*,(select sum(amount) from '.TRACKING_PAID.' where tasker_id=b.tasker_id) as paid_amount');
		$this->db->from(BOOKING.' as b');
		$this->db->join(TRANSACTION.' as t','b.id=t.booking_id','left');
		$this->db->where('b.tasker_id',$id);
		$this->db->where('b.status','Paid');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	 function get_user_cancel_list($id)
	{
		$this->db->select('b.*,c.cancel_percentage');
		$this->db->from(BOOKING.' as b');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->where('b.id',$id);
		return $query = $this->db->get();
		
	}
	
}