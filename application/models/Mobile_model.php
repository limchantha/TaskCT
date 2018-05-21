<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mobile_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function load_available_balance($id)
	{
		$this->db->select('b.*,(select sum(amount) from '.TRACKING_PAID.' where tasker_id=b.tasker_id) as paid_amount');
		$this->db->from(BOOKING.' as b');
		/* $this->db->join(TRANSACTION.' as t','b.id=t.booking_id','left'); */
		$this->db->where('b.tasker_id',$id);
		$this->db->where('b.status','Paid');
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function export_transaction_list($id,$pageLimitStart,$perpage)
	{
		$this->db->select('t.first_name as Tasker_name,t.photo,c.task_name as Task_name,b.booking_date,b.address,b.booking_time,b.veh_name,ct.total_amount as Paid_amount');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id');
		$this->db->join(TRANSACTION.' as ct','ct.booking_id=b.id');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id');
		$this->db->where('b.user_id',$id);
        $this->db->where('(b.status="Paid" or b.status="Cancel")');
		$this->db->limit($perpage,$pageLimitStart);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function export_transaction_list_tasker($id,$pageLimitStart,$perpage)
	{
		$this->db->select('t.first_name as Tasker_name,t.photo,c.task_name as Task_name,b.booking_date,b.address,b.booking_time,b.veh_name,ct.total_amount as Paid_amount');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.user_id');
		$this->db->join(TRANSACTION.' as ct','ct.booking_id=b.id');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id');
		$this->db->where('b.tasker_id',$id);
        $this->db->where('(b.status="Paid" or b.status="Cancel")');
		$this->db->limit($perpage,$pageLimitStart);
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function get_featured_category()
	{
		$this->db->select('b.*,t.id as subcat_id,t.subcat_name,t.image as subcat_image');
		$this->db->from(TASKER_CATEGORY.' as b');
		$this->db->join(TASKER_SUB_CATEGORY.' as t','b.id=t.cat_id','left');
		$this->db->where('b.status','Active');
		$this->db->where('t.status','Active');
		$this->db->where('t.featured','1');
		return $query = $this->db->get();
		
	}
	
	function get_booked_status($cat_id,$subcat_id,$booking_date,$booking_time)
	{
		$this->db->select('u.tasker_id');
		$this->db->from(BOOKING.' as u');
		$this->db->where('u.task_category_id="'.$cat_id.'" and u.subcat_id="'.$subcat_id.'" and u.booking_date="'.$booking_date.'" and u.booking_time="'.$booking_time.'" and (u.status="Paid" or u.status="Accept")');
		return $query = $this->db->get();
		
	}
	
	function get_tasker_search_details($where1,$cat_id,$subcat_id,$id,$date,$time,$distance,$lat,$long,$order_by,$veh,$pageLimitStart,$perpage)
	{
		
		$this->db->select('u.*,t.admin_percentage,u.id as tasker_id,ts.*,( 3959 * acos( cos( radians('.$lat.') ) 
              * cos( radians( u.lat ) ) 
              * cos( radians( u.long ) - radians('.$long.') ) 
              + sin( radians('.$lat.') ) 
              * sin( radians( u.lat ) ) ) ) AS distance1 ,(select avg(rate_val) from '.REVIEWS.' where tasker_id=u.id)as rate,(select count(id) from '.REVIEWS.' where tasker_id=u.id)as rate_count,(select count(id) from '.BLOCK_DATES.' td where td.tasker_id=u.id and td.task_date="'.$date.'" and td.task_time="0")as block_full');
		$this->db->from(USERS.' as u');
		$this->db->join(TASKER_CATEGORY_SELECTION.' as ts','u.id=ts.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as t','t.id=ts.task_category_id','left');
		$this->db->where('ts.task_category_id',$cat_id);
		$this->db->where('u.tasker_completed','1');
		$this->db->where('u.status',"Active");
		$this->db->where("FIND_IN_SET('$subcat_id',ts.subcat_id) !=", 0);
		$this->db->where('u.id !=',$id);
		$this->db->having('block_full <= 0 and distance1 <= u.distance');
		$this->db->where($where1);
		$this->db->group_by('u.id');
		$this->db->limit($perpage,$pageLimitStart);
		if($veh!=""){
			$this->db->where("FIND_IN_SET('$veh',u.vehicle_types) !=", 0);
		}
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
	function get_reviews_details($id)
	{
		$this->db->select('u.first_name,u.id as user_id,u.last_name,u.photo,b.*');
		$this->db->from(REVIEWS.' as b');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->where('b.tasker_id',$id);
		$this->db->where('b.status','1');
		$this->db->order_by('b.id','desc');
		$this->db->limit(2);
		return $query = $this->db->get();
		
	}
	function get_tasker_booking_details($id,$cat_id)
	{
		$this->db->select('u.*,u.id as tasker_id,t.*');
		$this->db->from(USERS.' as u');
		$this->db->join(TASKER_CATEGORY_SELECTION.' as t','u.id=t.user_id','left');
		$this->db->where('u.status','Active');
		$this->db->where('u.id',$id);
		$this->db->where('t.task_category_id',$cat_id);
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
	
	function dashboar_user_pending_task_list_load($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val,sc.subcat_name,t.photo,b.id as booking_id');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->where('(b.status="Pending")');
		$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	function dashboar_user_approved_task_list_load($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val,sc.subcat_name,t.photo,b.id as booking_id');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->where('(b.status="Accept")');
		$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function dashboar_user_completed_task_list_load($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val,r.comments,sc.subcat_name,t.photo,b.id as booking_id');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.user_id',$id);
		$this->db->where('(b.status="Paid")');
		#$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function dashboar_user_cancelled_task_list_load($id)
	{
		$this->db->select('t.first_name,t.last_name,b.*,c.task_name,r.rate_val,sc.subcat_name,t.photo,b.id as booking_id,ct.total_amount as cancel_amount');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->join(TRANSACTION.' as ct','ct.booking_id=b.id');
		$this->db->where('b.user_id',$id);
		$this->db->where('(b.status="Cancel")');
		#$this->db->where('b.booking_date >=',date('Y-m-d'));
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
	
	
	function tasker_enquires_load_active($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name,b.id as booking_id');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->where('t.id',$id);
		$this->db->where('(b.status ="Accept")');
		$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function tasker_enquires_load_approved($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name,b.id as booking_id');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->where('t.id',$id);
		$this->db->where('(b.status ="Accept")');
		$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function tasker_enquires_load_pending($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name,b.id as booking_id');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->where('t.id',$id);
		$this->db->where('(b.status ="Pending")');
		$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
	function tasker_enquires_load_completed($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name,r.rate_val,b.id as booking_id');
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
	
	function tasker_enquires_load_cancel($id)
	{
		$this->db->select('u.first_name,u.last_name,b.*,c.task_name,sc.subcat_name,b.id as booking_id');
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
		$this->db->select('u.*,n.*,tc.task_name,(select message from '.NOTIFICATION.' where booking_id=n.booking_id and viewer_id="'.$id.'"  order by created desc limit 1 ) as msg,(select created from '.NOTIFICATION.' where booking_id=n.booking_id and viewer_id="'.$id.'"  order by created desc limit 1) as msg_time,b.id as booking_id,b.status as bstatus');
		$this->db->from(NOTIFICATION.' as n');
		$this->db->join(USERS.' as u','u.id=n.user_id','left');
		$this->db->join(BOOKING.' as b','n.booking_id=b.id','left');
		$this->db->join(TASKER_CATEGORY.' as tc','tc.id=b.task_category_id','left');
		$this->db->where('n.viewer_id',$id);
		$this->db->group_by('n.booking_id');
		$this->db->order_by('n.message_status','desc');
		$this->db->order_by('n.created','desc');
		return $query = $this->db->get();
		
	}
	
   function get_retrival_messages($id)
	{
		$this->db->select('u.photo as uphoto,u.first_name,b.address,n.*,');
		$this->db->from(NOTIFICATION.' as n');
		$this->db->join(USERS.' as u','u.id=n.user_id','left');
		$this->db->join(BOOKING.' as b','n.booking_id=b.id','left');
		$this->db->join(TASKER_CATEGORY.' as tc','tc.id=b.task_category_id','left');
		$this->db->where('n.booking_id',$id);
		$this->db->order_by('n.created','asc');
		return $query = $this->db->get();
		
	}
	
   function get_completed_task_info($id)
	{
		$this->db->select('t.first_name,u.first_name as ufirst_name,u.last_name as ulast_name,t.last_name,b.*,c.task_name,r.rate_val,r.comments,sc.subcat_name,t.photo,u.photo as uphoto,b.id as booking_id,ts.task_sub_category');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->join(TASKER_CATEGORY.' as c','b.task_category_id=c.id','left');
		$this->db->join(TASKER_SUB_CATEGORY.' as sc','b.subcat_id=sc.id','left');
		$this->db->join(TASKER_CATEGORY_SELECTION.' as ts','b.tasker_id=ts.user_id and b.task_category_id=ts.task_category_id','left');
		$this->db->join(REVIEWS.' as r','r.booking_id=b.id','left');
		$this->db->where('b.id',$id);
		#$this->db->where('(b.status="Paid")');
		#$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
 
	 function getbookinfo($id)
	{
		$this->db->select('t.id as tid,u.id as uid,t.first_name as tfirst_name,u.first_name as ufirst_name,b.*,t.photo as tphoto,u.photo as uphoto,b.id as booking_id');
		$this->db->from(BOOKING.' as b');
		$this->db->join(USERS.' as t','t.id=b.tasker_id','left');
		$this->db->join(USERS.' as u','u.id=b.user_id','left');
		$this->db->where('b.id',$id);
		#$this->db->where('(b.status="Paid")');
		#$this->db->where('b.booking_date >=',date('Y-m-d'));
		$this->db->order_by('b.id','desc');
		return $query = $this->db->get();
		
	}
	
}