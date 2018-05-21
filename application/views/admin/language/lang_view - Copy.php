<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to admin management
 * @author Teamtweaks
 *
 */
class Response_model extends CI_Model
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function get_subcategory_list($id){
		$this->db->select('sc.*');
		$this->db->from('subcategory as sc');
		$this->db->where('sc.category',$id);
		$query = $this->db->get();
		return $query;
	}
	
	public function get_check_tabel($table_id,$password){
		$this->db->select('*');
		$this->db->from('tables');
		$this->db->where('table_id',$table_id);
		$this->db->where('status','Active');
		$this->db->where('table_device_key','');
		$this->db->where('table_ud_id_key','');
		$rs 		= $this->db->get();
		$status 	= 1;
		$modeldata['FLAG']  = 0;
		if($rs->num_rows() <= 0 ){
			$modeldata['FLAG']		= 1;
			$modeldata['response']	= 'Invalid Table Id.!';
		}else{
			$this->db->select('*');
			$this->db->from('admin_info');
			$this->db->where('password',$password);
			$this->db->where('id',1);
			$rs1 = $this->db->get();
			if($rs1->num_rows() <= 0 ){
				$modeldata['FLAG'] 		= 2;
				$modeldata['response']	= 'Invalid Password.!';
			}
		}
		if($modeldata['FLAG']==0){
			$modeldata['company_info'] 	= array();
			if($rs->row()->table_type=="Order"){
				$this->db->select('*');
				$this->db->from('company_info');
				$query_rs = $this->db->get();
				$logo = $query_rs->row()->logo;
				$show_img 		= base_url().'uploads/logo_upload/'.$logo;
				$buffer_add = str_replace(array("\r", "\n"), ',', $query_rs->row()->address);
				$modeldata['company_info'] 	= array('company_name'=>$query_rs->row()->company_name,'address'=> $buffer_add,'company_logo'=>$show_img,'email_id'=>$query_rs->row()->email_id,'mobile_no'=>$query_rs->row()->mobile_no,'website_address'=>$query_rs->row()->website_address,'open_time'=>$query_rs->row()->open_time,'close_time'=>$query_rs->row()->close_time,'wifi_user'=>$query_rs->row()->wifi_user,'wifi_pwd'=>$query_rs->row()->wifi_pwd);
			}
			$modeldata['response'] 	= array('table_id'=>$rs->row()->table_id,'table_type'=>$rs->row()->table_type,'device_key'=>$rs->row()->table_device_key,'ud_id'=>$rs->row()->table_ud_id_key);
		}
		return $modeldata;
	}
	
	public function get_sub_catlist($id){
		$this->db->select('sc.*');
		$this->db->from('subcategory as sc');
		$this->db->where('sc.category',$id);
		$this->db->group_by('sc.id');
		$query = $this->db->get();
		return $query;
	}
	
	public function add_to_cart_post($userdata){
		$table_id 	= $userdata['table_id'];
		$food_id	= $userdata['food_id'];
		$food_qty	= $userdata['food_qty'];
		$food_price	= $userdata['price'];
		
		$this->db->select('*');
		$this->db->from('cart_info');
		$this->db->where('table_id',$table_id);
		$this->db->where('food_id',$food_id);
		$rs = $this->db->get();
		
		$this->db->set('table_id',$table_id);
		$this->db->set('food_id',$food_id);
		$this->db->set('food_price',$food_price);
		
		if($rs->num_rows() > 0){
			$update_id  = $rs->row()->id;
			$old_qty  	= $rs->row()->food_qty;
			$data_qty 	= $food_qty+$old_qty;
			$this->db->set('food_qty',$data_qty);
			$update_time = date('Y-m-d h:i:s');
			$this->db->set('updated_date',$update_time);
			$this->db->where('id',$update_id);
			$this->db->update('cart_info');
		}else{
			$this->db->set('food_qty',$food_qty);
			$update_time = date('Y-m-d h:i:s');
			$this->db->set('updated_date',$update_time);
			$this->db->insert('cart_info');
		}
		return true;
	}
	
	public function show_cart_info_post($table_id){
		$query  = "SELECT ci.*,sc.title,sc.photo,sc.price,sc.dish_type,sc.currency_type,sc.description,sc.time FROM cart_info as ci LEFT JOIN subcategory as sc on ci.food_id = sc.food_id WHERE ci.table_id='".$table_id."' /* ORDER BY ci.updated_date DESC */";
		$rs = $this->db->query($query);
		return $rs;
	}
	
	public function edit_cart_info_post($cart_id,$food_qty){
		$this->db->set('food_qty',$food_qty);
		$this->db->where('id',$cart_id);
		$update_time = date('Y-m-d h:i:s');
		$this->db->set('updated_date',$update_time);
		$this->db->update('cart_info');
		return true;
	} 

	public function delete_cart_info_post($cart_id){
		$this->db->where('id',$cart_id);
		$this->db->delete('cart_info');
		return true;
	}   
	
	public function send_order_post($cart_id,$order_id='',$table_id=''){
		$cAstro = 0;
		$crt_arr = explode(',',$cart_id);
		if(empty($order_id)){
			$order_id  	= time();
			$same_order = 0;
		}else{
			$order_id  	= 	$order_id;
			$same_order = 1;
		} 
		
		$total_price  	= 0;
		$final = 0;
		foreach($crt_arr as $ctrid){
			$query  	= "SELECT * FROM cart_info WHERE id = '".$ctrid."'";
			$rs 		= $this->db->query($query);
			$check 		= 0;
			if($rs->num_rows() > 0){
				$check = 1;	
				$food_id  	= $rs->row()->food_id;
				$food_qty 	= $rs->row()->food_qty;
				$table_id 	= $rs->row()->table_id;
				$food_price = $rs->row()->food_price;
				$remo 		= 0;
				$aravinth   = 0;
				if($same_order==1){
					$query1  	= "SELECT * FROM order_items WHERE food_id = '".$food_id."' AND order_id ='".$order_id."' AND status = 'ordered' ORDER BY updated_on DESC";
					$result 	= $this->db->query($query1);
					#echo '<pre>';print_r($result);exit;
					if($result->num_rows() > 0){
						$status_check = $result->row()->status;
						if($status_check=="ordered"){
							$old_qty  	= $result->row()->food_qty;
							$data_qty 	= $food_qty+$old_qty;
							$this->db->set('food_qty',$data_qty);
							$update_time = date('Y-m-d h:i:s');
							$this->db->set('updated_on',$update_time);
							$this->db->where('status','ordered');
							$this->db->where('food_id',$food_id);
							$this->db->update('order_items');
							
							//Notify
							$this->db->set('order_id',$order_id);
							$this->db->set('reason',$food_id.' Food has been added to existing order.!');
							$update_time = date('Y-m-d h:i:s');
							$this->db->set('updated_on',$update_time);
							$this->db->set('food_id',$food_id);
							$this->db->set('action','food_order');
							$this->db->set('table_id',$table_id);
							$this->db->insert('notification');
							$remo = 1;
						}else{
							$aravinth =1;
						}
					}else{
						$query2  	= "SELECT * FROM order_items WHERE order_id ='".$order_id."' AND status !='delivered' ORDER BY updated_on DESC";
						$result2 = $this->db->query($query2);
						
						if($result2->num_rows() <= 0){
							$aravinth 	= 1;
							$cAstro 	= 2;
							$final		= 1;
						}else{
							$aravinth =1;
							$cAstro = 3;
						}
					}
					
					if($aravinth ==1){
						$this->db->set('order_id',$order_id);
						$this->db->set('price',$food_price);
						$this->db->set('food_qty',$food_qty);
						$this->db->set('table_id',$table_id);
						$this->db->set('food_id',$food_id);
						$update_time = date('Y-m-d h:i:s');
						$this->db->set('updated_on',$update_time);
						$this->db->insert('order_items');
						//Notify
						$this->db->set('order_id',$order_id);
						$this->db->set('reason',$food_id.' Food has been added to existing order.!');
						$update_time = date('Y-m-d h:i:s');
						$this->db->set('updated_on',$update_time);
						$this->db->set('food_id',$food_id);
						$this->db->set('action','food_order');
						$this->db->set('table_id',$table_id);
						$this->db->insert('notification');
						$remo 	= 1;
					}
				}
				
				if($remo==0){
					//Order Items Table Insert
					$this->db->set('order_id',$order_id);
					$this->db->set('price',$food_price);
					$this->db->set('food_qty',$food_qty);
					$this->db->set('table_id',$table_id);
					$update_time = date('Y-m-d h:i:s');
					$this->db->set('updated_on',$update_time);
					$this->db->set('food_id',$food_id);
					$this->db->insert('order_items');
					$total_price+=$food_price;
				}	
				//Delete from cart
				$this->db->where('id',$ctrid);
				$this->db->delete('cart_info');
			}
		}
		
		if($check == 1 && $same_order == 0){
			$this->db->set('order_id',$order_id);
			$this->db->set('reason','New Order has been created from '.$table_id);
			$this->db->set('table_id',$table_id);
			$update_time = date('Y-m-d h:i:s');
			$this->db->set('updated_on',$update_time);
			$this->db->set('action','new_order');
			$this->db->insert('notification');
			
			//Food Order Table Insert
			$this->db->set('order_id',$order_id);
			$update_time = date('Y-m-d h:i:s');
			$this->db->set('updated_on',$update_time);
			$this->db->set('total_price',$total_price);
			$this->db->set('table_id',$table_id);
			$this->db->insert('food_order');
		}
		
		if($final==1){
			$cAstro = 2;
		}
		return  $table_id.'~'.$order_id.'~'.$cAstro;
	}

	public function table_cart_clean_post($table_id){
		//Delete from cart
		$this->db->where('table_id',$table_id);
		$this->db->delete('cart_info');
		return  true;
	}
	
	public function check_order_post($order_id){
		$query  = "SELECT * FROM order_items WHERE status='ordered' AND order_id = '".$order_id."'";
		$rs = $this->db->query($query);
		return $rs;
	}
	
	public function order_details_post($order_id){
		$query  = "SELECT oi.order_id,sc.title,oi.table_id,oi.status,sc.food_id,sc.photo,oi.food_qty,sc.price,sc.dish_type,sc.currency_type,sc.description,sc.time FROM order_items as oi LEFT JOIN subcategory as sc ON sc.food_id = oi.food_id WHERE oi.order_id ='".$order_id."' ORDER BY oi.updated_on DESC";
		$rs = $this->db->query($query);
		return $rs;
	}
	
	public function cancel_order_post($order_id,$food_id,$status=''){
		$query = "SELECT oi.order_id,sc.title,oi.table_id,oi.status,sc.food_id,sc.photo,oi.food_qty,sc.price,sc.dish_type,sc.currency_type,sc.description,sc.time FROM order_items as oi LEFT JOIN subcategory as sc ON sc.food_id = oi.food_id WHERE order_id ='".$order_id."' AND oi.status='ordered' AND oi.food_id='".$food_id."'  ORDER BY oi.updated_on DESC";
		$rs = $this->db->query($query);

		if($rs->num_rows() >  0){
			$title = $rs->row()->title;
			$this->db->where('order_id',$order_id);
			$this->db->where('food_id',$food_id);
			$this->db->where('status',$status);
			$this->db->delete('order_items');
			$query1  = "SELECT oi.order_id,sc.title,oi.table_id,oi.status,sc.food_id,sc.photo,oi.food_qty,sc.price,sc.dish_type,sc.currency_type,sc.description,sc.time FROM order_items as oi LEFT JOIN subcategory as sc ON sc.food_id = oi.food_id WHERE oi.order_id ='".$order_id."' ORDER BY oi.updated_on DESC";
			$rs1 	= $this->db->query($query1);
			if($rs1->num_rows() <= 0){
				$this->db->where('order_id',$order_id);
				$this->db->delete('food_order');
			}
			$this->db->set('order_id',$order_id);
			$this->db->set('reason',$title.' has been cancelled by - #'.$rs->row()->table_id);
			$this->db->set('action','cancel');
			$update_time = date('Y-m-d h:i:s');
			$this->db->set('updated_on',$update_time);
			$this->db->set('table_id',$rs->row()->table_id);
			$this->db->insert('notification');
			return  $rs1;
		}else{
			$query1  = "SELECT * FROM order_items WHERE order_id ='".$order_id."'";
			$rs1 	= $this->db->query($query1);
			if($rs1->num_rows() <= 0){
				$this->db->where('order_id',$order_id);
				$this->db->delete('food_order');
			}
			return  false;
		}
	}
	
	public function change_order_post($order_id,$food_id,$status,$old_status){
		$food_arr = explode(',',$food_id);
		foreach($food_arr as $val){
			$this->db->set('status',$status);
			$update_time = date('Y-m-d h:i:s');
			$this->db->set('updated_on',$update_time);
			$this->db->set('old_status',$status);
			$this->db->where('order_id',$order_id);
			$this->db->where('food_id',$val);
			
			$this->db->where('status',$old_status);
			$this->db->update('order_items');
			
			$query1  = "SELECT title FROM subcategory WHERE food_id ='".$val."'";
			$rs1 	= $this->db->query($query1);
			$this->db->set('order_id',$order_id);
			$update_time = date('Y-m-d h:i:s');
			$this->db->set('updated_on',$update_time);
			$this->db->set('reason',$rs1->row()->title.' Status has been changed '.$old_status.' - '.$status.' by kitchen.!');
			$this->db->set('action','change_status');
			
			$this->db->set('food_id',$val);
			$this->db->set('table_id','');
			$this->db->insert('notification');
		}
		return true;
	}
	
	public function ask_bill_post($order_id,$email_id='',$is_promo='',$table_ud_id_key,$table_id=''){
		$this->db->set('customer_email',$email_id);
		$this->db->set('status','payment_request');
		$this->db->set('is_promo',$is_promo);
		$update_time = date('Y-m-d h:i:s');
		$this->db->set('updated_on',$update_time);
		$this->db->where('order_id',$order_id);
		$this->db->update('food_order');
		if($is_promo==1){
			$this->db->set('email_id',$email_id);
			$this->db->insert('promotion_email');
		}
		$query  = "SELECT oi.order_id,sc.title,oi.table_id,oi.status,sc.food_id,sc.photo,oi.food_qty,sc.price,sc.dish_type,sc.currency_type,sc.description,sc.time FROM order_items as oi left join subcategory as sc on sc.food_id = oi.food_id WHERE oi.order_id ='".$order_id."'";
		$rs = $this->db->query($query);
		if($rs->num_rows() >0 ){
			$this->db->set('order_id',$order_id);
			$this->db->set('reason','Bill Request');
			$this->db->set('action','bill_req');
			$update_time = date('Y-m-d h:i:s');
			$this->db->set('updated_on',$update_time);
			$this->db->set('table_id',$table_id);
			$this->db->set('table_ud_id_key',$table_ud_id_key);
			$this->db->insert('notification');
		}
		return $rs;
	}
	
	public function get_fooditem_details($order_id){
		$this->db->select('fl.*,sc.title');
		$this->db->from('order_items as fl');
		$this->db->join('subcategory as sc', 'sc.food_id = fl.food_id','left');
		$this->db->where('fl.order_id',$order_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function update_data($order_id='',$sum='',$tax='',$discount='',$total=''){
		$this->db->set('status','payment_request');
		$this->db->set('price',$sum);
		$this->db->set('tax',$tax);
		$this->db->set('total_price',$total);
		$update_time = date('Y-m-d h:i:s');
		$this->db->set('updated_on',$update_time);
		$this->db->set('discount',$discount);
		$this->db->where('order_id',$order_id);
		$this->db->update('food_order');
		return true;
	}
	
	public function bill_generation_post($order_id){
		$query1 = "SELECT id FROM order_items WHERE status != 'delivered'  AND order_id = '".$order_id."'";
		$rs1 = $this->db->query($query1);
		#print_r($rs1->num_rows());exit;
		$rs = '';
		if($rs1->num_rows() <=0 ){
			$query  = "SELECT oi.order_id,sc.title,oi.table_id,oi.status,sc.food_id,sc.photo,oi.food_qty,sc.price,sc.dish_type,oi.currency_type,sc.description,sc.time FROM order_items as oi left join subcategory as sc on sc.food_id = oi.food_id WHERE oi.order_id ='".$order_id."'";
			$rs = $this->db->query($query);
		}
		return $rs;
	}
	
	public function feedback_rating_post($order_id='',$table_id='',$rating='',$feedback=''){
		$this->db->set('order_id',$order_id);
		$this->db->set('table_id',$table_id);
		$update_time = date('Y-m-d h:i:s');
		$this->db->set('updatedon',$update_time);
		$this->db->set('rating',$rating);
		$this->db->set('feedback',$feedback);
		$this->db->insert('rating_feedback');
		return true;
	} 
	
	public function food_like_post($like,$food_id){
		$query1 = "SELECT likes FROM subcategory WHERE food_id = '".$food_id."'";
		$rs 	= $this->db->query($query1);
		$likess = $rs->row()->likes;
		if($like==1){
			$likess = $likess+1;
		}else if($like==0){
			$likess = $likess-1;
		}
		$this->db->set('likes',$likess);
		$this->db->where('food_id',$food_id);
		$this->db->update('subcategory');
		return true;
	} 

	
	public function call_waiter_post($table_id){
		$this->db->set('reason','# '.$table_id.' Guest Calling....');
		$this->db->set('action','waiter_req');
		$update_time = date('Y-m-d h:i:s');
		$this->db->set('updated_on',$update_time);
		$this->db->set('table_id',$table_id);
		$this->db->insert('notification');
	}
}