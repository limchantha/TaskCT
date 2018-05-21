<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasker extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation','session'));		
		$this->load->model('tasker_model');
		$this->load->model('mail_model');
		if($this->check_prev('Taskers',0)==FALSE)
		{
			redirect(base_url('admin'));
		}
    }
	
	public function dashboard()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Taskers List";
			$this->data['user']=$this->tasker_model->get_all_details(USERS,array('group'=>'1'));
			$this->data['tasker_cat_based']=$this->tasker_model->get_tasker_based_on_cat();
			$this->data['top_tasker']=$this->tasker_model->get_tasker_completed_tasks_graph(); #echo $this->db->last_query();
			$this->data['active_user']=$this->tasker_model->get_all_details(USERS,array('status'=>'Active','group'=>'1'));
			$this->data['new_user']=$this->tasker_model->get_all_details(USERS,array('(created)'=>date('Y-m-d'),'group'=>'1')); 
			$this->load->view('admin/tasker/dashboard',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	

   public function display_tasker_list()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Tasker List";
			$this->data['user']=$this->tasker_model->get_all_details(USERS,array('group'=>'1'));
			$this->load->view('admin/tasker/display_tasker_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	
   public function export_tasker_list()
	{
		if($this->checkLogin('A')!='')
		{   
	
			$fields_wanted=array('id','first_name','last_name','email','phone','zipcode','created','last_login_date','last_login_ip');
			$table=USERS;
			$users=$this->tasker_model->export_tasker_details($table,$fields_wanted);
			$this->data['users_detail']=$users['users_detail']->result();
			$this->load->view('admin/tasker/export_tasker',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}	

	public function delete_tasker($id)
	{
		if($this->checkLogin('A')!='')
		{   
			
			$this->data['user']=$this->tasker_model->commonDelete(USERS,array('id'=>$id));
			$this->session->set_flashdata('alert_message', 'Successfully Deleted');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/tasker/display_tasker_list');
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	 

	public function add_tasker($id='')
	{
		if($this->checkLogin('A')!='')
		{   
			if($id=='')
			{
			$this->data['heading']="Add Tasker";			
			$this->load->view('admin/tasker/add_tasker',$this->data);
			}
			else
			{
			$this->data['heading']="Edit Tasker";
			$this->data['user']=$this->tasker_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->load->view('admin/tasker/add_tasker',$this->data);
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    public function check_email()
	{   $email=$this->input->post('email');
		$t=count($this->tasker_model->get_single_details(USERS,array('id'),array('email'=>$email))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}
	
	public function add_edit_insert($id='')
	{
		if($this->checkLogin('A')!='')
		{  

			if($_POST['password']!='')
			{
				$_POST['password']=md5($_POST['password']); 
			}
			else
			{
				unset($_POST['password']);
			}
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000;
		    $config['upload_path'] = './images/site/profile';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('photo')){
		    	$imgDetails = $this->upload->data();
		    	$_POST['photo'] = $imgDetails['file_name'];
			}   
			if($id=='')
			{
			
			 $this->tasker_model->simple_insert(USERS,$_POST);
			 $this->session->set_flashdata('alert_message', 'Successfully created');
		     $this->session->set_flashdata('error_type', 'success');
			 redirect(base_url().'admin/tasker/display_tasker_list');
			
			}
			else
			{
			 $this->tasker_model->update_details(USERS,$_POST,array('id'=>$id));
			 $this->session->set_flashdata('alert_message', 'Successfully updated');
		     $this->session->set_flashdata('error_type', 'success');
			redirect(base_url().'admin/tasker/display_tasker_list');
			}
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
    
	public function check_email_profile()
	{   $email=$this->input->post('email');
	    $id=$this->input->post('id');
		$t=count($this->tasker_model->get_single_details(USERS,array('id'),array('email'=>$email,'id !='=>$id))->result());
        if($t<=0)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}	

	}
	
	public function commission_tracking()
	{
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Display Tasker tracking List";
			$this->data['task']=$this->tasker_model->load_bookings("Paid");
			$this->load->view('admin/tasker/display_commissiontracking_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}

	public function commission_tracking_detail($id)
	{
		if($this->checkLogin('A')!='')
		{   
			$this->data['id']=$id;
			$this->data['heading']="Display Tasker tracking List";
			$this->data['task']=$this->tasker_model->load_detail_bookings($id);
			$this->load->view('admin/tasker/display_commissiontracking_list_detail',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
	}
	
	public function tasker_pay_process($book_id)
	{
		$stripe_pay=(json_decode($this->config->item('stripe_payment')));
		$stripe_key=$stripe_pay->stripe_key;
		$stripe_secret=$stripe_pay->stripe_secret;
		$mode=$stripe_pay->mode;
		if($mode==0)
		{
			$config['stripe_key_test_public']         = $stripe_key;
			$config['stripe_key_test_secret']         = $stripe_secret;
			$config['stripe_test_mode']               = TRUE;
			$config['stripe_verify_ssl']              = FALSE;
		}
		else
		{
			$config['stripe_key_live_public']         = $stripe_key;
			$config['stripe_key_live_secret']         = $stripe_secret;
			$config['stripe_test_mode']               = FALSE;
			$config['stripe_verify_ssl']              = FALSE;
		}
		$ret['error_new']='';	
		$this->load->library( 'stripe' );
		$stripe = new Stripe( $config );
		$get_booking=$this->user_model->get_all_details(BOOKING,array('id'=>$book_id));
		$get_tasker=$this->user_model->get_all_details(USERS,array('id'=>$get_booking->row()->tasker_id));
		if($get_tasker->row()->stripe_user_id=="")
		{
			$this->session->set_flashdata('alert_message', 'Please ask tasker to connect stripe...');
		    $this->session->set_flashdata('error_type', 'error');
			redirect(base_url('admin/tasker/commission_tracking_detail/'.$get_tasker->row()->id));die;
			
		}
		
		$amount=($get_booking->row()->total_amount-$get_booking->row()->service_fee)*100;
		$desc='Task id:SRA00'.$get_booking->row()->id .' Booked payment '.date('m-d-Y');
		$currency_type='USD';
		$charge=json_decode($stripe->transfer_card($amount,$get_tasker->row()->stripe_user_id,$desc,$currency_type)); 
		if(isset($charge->id))
		{
			$status=$_POST['status'];			
		    $this->user_model->simple_insert(TRACKING_PAID,array('booking_id'=>$book_id,'tasker_id'=>$get_booking->row()->tasker_id,'amount'=>($get_booking->row()->total_amount-$get_booking->row()->service_fee)));
			$this->session->set_flashdata('alert_message', 'Amount transfered successfully...');
		    $this->session->set_flashdata('error_type', 'success');
			redirect(base_url('admin/tasker/commission_tracking_detail/'.$get_tasker->row()->id));die;

		}
		else
		{
			
			$this->session->set_flashdata('alert_message', $charge->error->message);
		    $this->session->set_flashdata('error_type', 'error');
			redirect(base_url('admin/tasker/commission_tracking_detail/'.$get_tasker->row()->id));die;
		}
		echo json_encode($ret);
		
	}
	
	public function change_status($id,$status)
	{   
		
		if($status==0)
		{
			$statu="Inactive";
		}
		else
		{
			$statu="Active";
		}
		$this->user_model->update_details(USERS,array('status'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/tasker/display_tasker_list');

	}

	public function change_tasker_completed($id,$status)
	{   
		
		if($status==0)
		{
			$statu="0";
		}
		else
		{
			$statu="1";
			$user=$this->mail_model->get_all_details(USERS,array('id'=>$id))->row();
			$this->mail_model->admin_task_approval($user);
		}
		$this->user_model->update_details(USERS,array('tasker_completed'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully task status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/tasker/display_tasker_list');

	}

	public function id_verified ($id,$status)
	{   
		
		if($status==0)
		{
			$statu="No";
		}
		else
		{
			$statu="Yes";
		}
		$this->user_model->update_details(USERS,array('id_verified'=>$statu),array('id'=>$id));			 
		$this->session->set_flashdata('alert_message', 'Successfully status changed.');
		$this->session->set_flashdata('error_type', 'success');
		redirect(base_url().'admin/tasker/display_tasker_list');

	}

	

	

}
