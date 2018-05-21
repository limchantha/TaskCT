<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends My_Model
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
	
	
	
	
	function get_tasker_count($lat,$long,$task_id,$sub_task_id,$veh)
	{
		$this->db->select('u.distance,( 3959 * acos( cos( radians('.$lat.') ) 
              * cos( radians( u.lat ) ) 
              * cos( radians( u.long ) - radians('.$long.') ) 
              + sin( radians('.$lat.') ) 
              * sin( radians( u.lat ) ) ) ) AS distance1 ');
		$this->db->from(USERS.' as u');
		$this->db->join(TASKER_CATEGORY_SELECTION.' as ts','u.id=ts.user_id','left');
		$this->db->where('ts.task_category_id',$task_id);
		$this->db->where("FIND_IN_SET('$sub_task_id',ts.subcat_id) !=", 0);
		if($veh){
			$this->db->where("FIND_IN_SET('$veh',u.vehicle_types) !=", 0);
		}
		$this->db->where('u.group','1');
		$this->db->where('u.status',"Active");
		$this->db->where('u.tasker_completed','1');
		$this->db->having('distance1 <= u.distance');		
		#$this->db->where($where1);
		return $query = $this->db->get();
		
	}
	
	function get_tasker_search_details($where1,$cat_id,$subcat_id,$id,$date,$time,$distance,$lat,$long,$order_by)
	{
		
		$this->db->select('u.*,ts.*,( 3959 * acos( cos( radians('.$lat.') ) 
              * cos( radians( u.lat ) ) 
              * cos( radians( u.long ) - radians('.$long.') ) 
              + sin( radians('.$lat.') ) 
              * sin( radians( u.lat ) ) ) ) AS distance1 ,(select avg(rate_val) from '.REVIEWS.' where tasker_id=u.id)as rate,(select count(id) from '.REVIEWS.' where tasker_id=u.id)as rate_count,(select count(id) from '.BLOCK_DATES.' td where td.tasker_id=u.id and td.task_date="'.$date.'" and td.task_time="0")as block_full');
		$this->db->from(USERS.' as u');
		$this->db->join(TASKER_CATEGORY_SELECTION.' as ts','u.id=ts.user_id','left');
		$this->db->where('ts.task_category_id',$cat_id);
		$this->db->where('u.tasker_completed','1');
		$this->db->where("FIND_IN_SET('$subcat_id',ts.subcat_id) !=", 0);
		$this->db->where('u.id !=',$id);
		$this->db->where('u.status',"Active");
		$this->db->having('block_full <= 0 and distance1 <= u.distance');
		$this->db->where($where1);
		$this->db->group_by('u.id');
		if($order_by!='')
		{	
			if($order_by=="price_low")
			{
			$this->db->order_by('ts.price','asc');
			}
			else if($order_by=="price_high")
			{
			$this->db->order_by('ts.price','desc');
			}
			else if($order_by=="most_review")
			{
			$this->db->order_by('rate_count','desc');
			}
			else if($order_by=="highest_ratings")
			{
			$this->db->order_by('rate','desc');
			}
			
		}
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
	function get_unread_message($id)
	{
		$this->db->select('count(n.id) as unreadmessage_count');
		$this->db->from(NOTIFICATION.' as n');
		$this->db->where('n.viewer_id',$id);
		$this->db->where('n.message_status','1');
		$this->db->group_by('n.booking_id');
		$this->db->order_by('n.created','desc');
		return $query = $this->db->get();
		
	}
	
	function get_message_list($id)
	{
		$this->db->select('u.*,n.*,tc.task_name,(select message from '.NOTIFICATION.' where booking_id=n.booking_id and viewer_id="'.$id.'" and message_status="1" order by created desc limit 1 ) as msg,(select created from '.NOTIFICATION.' where booking_id=n.booking_id and viewer_id="'.$id.'" and message_status="1"  order by created desc limit 1) as msg_time ');
		$this->db->from(NOTIFICATION.' as n');
		$this->db->join(USERS.' as u','u.id=n.user_id','left');
		$this->db->join(BOOKING.' as b','n.booking_id=b.id','left');
		$this->db->join(TASKER_CATEGORY.' as tc','tc.id=b.task_category_id','left');
		$this->db->where('n.viewer_id',$id);
		$this->db->group_by('n.booking_id');
		$this->db->order_by('n.created','desc');
		return $query = $this->db->get();
		
	}
	
   function get_unreadmessage_list($id)
	{
		$this->db->select('u.*,n.*,tc.task_name,(select message from '.NOTIFICATION.' where booking_id=n.booking_id and viewer_id="'.$id.'" and message_status="1" order by created desc limit 1 ) as msg,(select created from '.NOTIFICATION.' where booking_id=n.booking_id and viewer_id="'.$id.'" and message_status="1"  order by created desc limit 1) as msg_time ');
		$this->db->from(NOTIFICATION.' as n');
		$this->db->join(USERS.' as u','u.id=n.user_id','left');
		$this->db->join(BOOKING.' as b','n.booking_id=b.id','left');
		$this->db->join(TASKER_CATEGORY.' as tc','tc.id=b.task_category_id','left');
		$this->db->where('n.viewer_id',$id);
		$this->db->group_by('n.booking_id');
		$this->db->where('n.message_status','1');
		$this->db->order_by('n.created','desc');
		return $query = $this->db->get();
		
	}
	
	function message_search_list($id,$search_by,$search_box)
	{
		$this->db->select('u.*,n.*,tc.task_name,(select message from '.NOTIFICATION.' where booking_id=n.booking_id and viewer_id="'.$id.'" and message_status="1" order by created desc limit 1 ) as msg,(select created from '.NOTIFICATION.' where booking_id=n.booking_id and viewer_id="'.$id.'" and message_status="1"  order by created desc limit 1) as msg_time ');
		$this->db->from(NOTIFICATION.' as n');
		$this->db->join(USERS.' as u','u.id=n.user_id','left');
		$this->db->join(BOOKING.' as b','n.booking_id=b.id','left');
		$this->db->join(TASKER_CATEGORY.' as tc','tc.id=b.task_category_id','left');
		$this->db->where('n.viewer_id',$id);
		if($search_box!="")
		{
		$this->db->where('u.first_name like "%'.$search_box.'%" or n.message like "%'.$search_box.'%" or tc.task_name like "%'.$search_box.'%"');	
		}
		$this->db->group_by('n.booking_id');
		
		if($search_by=="unread")
		{
		  $this->db->where('n.message_status','1');
		}
		else if($search_by=="date")
		{
		$this->db->order_by('n.created','desc');
		}
		return $query = $this->db->get();
		
	}
	
	function get_single_message($id,$booking_id)
	{
		$this->db->select('u.*,n.*,tc.task_name');
		$this->db->from(NOTIFICATION.' as n');
		$this->db->join(USERS.' as u','u.id=n.user_id','left');
		$this->db->join(BOOKING.' as b','n.booking_id=b.id','left');
		$this->db->join(TASKER_CATEGORY.' as tc','tc.id=b.task_category_id','left');
		$this->db->where('n.booking_id',$booking_id);
		$this->db->order_by('n.created','asc');
		return $query = $this->db->get();
		
	}
	
	
	function get_booked_status($cat_id,$subcat_id,$booking_date,$booking_time)
	{
		$this->db->select('u.tasker_id');
		$this->db->from(BOOKING.' as u');
		$this->db->where('u.task_category_id="'.$cat_id.'" and u.subcat_id="'.$subcat_id.'" and u.booking_date="'.$booking_date.'" and u.booking_time="'.$booking_time.'" and (u.status="Paid" or u.status="Accept")');
		return $query = $this->db->get();
		
	}
	
	function task_list_load($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function dashboar_user_current_task_list_load($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->where('(b.status="Pending" or b.status="Accept")');
		#$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->where('(b.booking_date >= "'.date('Y-m-d').'" or '.'b.status="Accept")');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function dashboar_user_completed_task_list_load($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val,sc.subcat_name');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->where('(b.status="Paid")');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function dashboard_user_cancel_list($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val,sc.subcat_name,ct.total_amount as cancel_amount');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->join(TRANSACTION.' as ct','ct.booking_id=b.id');
		$this->db->where('b.user_id',$id);
		$this->db->where('(b.status="Cancel")');
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
		$this->db->where('(b.status="Paid" or b.status="Cancel")');
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
        $this->db->where('(b.status="Paid" or b.status="Cancel")');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function load_available_balance($id)
	{
		$this->db->select('b.*,(select sum(amount) from '.TRACKING_PAID.' where tasker_id=b.tasker_id) as paid_amount');
		$this->db->from(BOOKING.' as b');
		/* $this->db->join(TRANSACTION.' as t','b.id=t.booking_id'); */
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
	
	function overall_admin_profit()
	{
		$this->db->select('sum(service_fee) as tot');
		$this->db->from(BOOKING);
		$this->db->where('status','paid');
		return $query = $this->db->get();
		
	}
	
	
}