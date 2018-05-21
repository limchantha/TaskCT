<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language_model extends My_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function get_language_list(){
		$query  = 'SELECT * FROM lang';
		$rs 	= $this->db->query($query); 
		return $rs->result();
	}
	
	public function edit_language($id){
		$query  = 'SELECT * FROM lang WHERE id="'.$id.'"';
		$rs 	= $this->db->query($query); 
		return $rs->result();
	}
	
	public function save_language($lang_data){
		$lang_code = $lang_data['lang_code'];
		if($lang_data['lang_id'] == ''){
			$query = 'SELECT * FROM lang WHERE lang_name="'.$lang_data['lang_name'].'" and lang_code ="'.$lang_code.'"';
			$language = $this->db->query($query);
			$language_result = $language->result();
			$cnt = $language->num_rows();
			if($cnt > 0){
				$modeldata['msg']= 'Already Exists!';
				$modeldata['flag']=3;
			}else{
			$languagDirectory = APPPATH."language/".$lang_code;
			if(!is_dir($languagDirectory))
			{
				mkdir($languagDirectory,0777); 
				$filePath_past  = APPPATH."language/en/en_lang.php";
				$filePath = APPPATH."language/".$lang_code."/".$lang_code."_lang.php";
				file_put_contents($filePath, '');
				copy($filePath_past, $filePath);
			}
			$this->db->set('lang_name',$lang_data['lang_name']);
			$this->db->set('lang_code',$lang_code);
			$this->db->set('status',$lang_data['lang_status']);
			$this->db->insert('lang');
			$id = $this->db->insert_id();
			if($id > 0)	
			{
				$modeldata['msg']= 'Successfully save!';
				$modeldata['flag']=1;
			}
			else
			{		
				$modeldata['msg']= 'Error on insert';
				$modeldata['flag']=0;
			}
			}
		}else{
			$current_date = date('Y-m-d H:i:s');
			$this->db->set('lang_name',$lang_data['lang_name']);
			$this->db->set('lang_code',$lang_code);
			$this->db->set('status',$lang_data['lang_status']);
			$this->db->set('updated_date',$current_date);
			$this->db->where('id',$lang_data['lang_id']);
			$this->db->update('lang');
			$modeldata['msg']= 'Successfully Update!';
			$modeldata['flag']=1;
		}
		return $modeldata;
	}
	
	public function delete_language($id){
		$query  = 'DELETE FROM lang WHERE id = '.$id;
		$this->db->query($query);
		$modeldata['msg']= 'Successfully Deleted!';
		$modeldata['flag']=1;
		return $modeldata;
	}
	
	public function update_default_language($lang_data){
		$query = 'select * from lang where default_lang="default"';
		$check_default = $this->db->query($query);
		$cnt = $check_default->num_rows();
		if($cnt > 0){
			$query = 'select * from lang where id="'.$lang_data['lang_name'].'"';
			$language = $this->db->query($query);
			$language_result = $language->result();
		if($language_result[0]->default_lang == 'default'){
			$this->db->set('default_lang','default');
			$this->db->where('id',$lang_data['lang_name']);
			$this->db->update('lang');
			$modeldata['msg']= 'Successfully Update!';
			$modeldata['flag']=1;
		}else{
			$this->db->set('default_lang','');
			$this->db->where('status','Active');
			$this->db->update('lang');
			$this->db->set('default_lang','default');
			$this->db->where('id',$lang_data['lang_name']);
			$this->db->update('lang');
			$modeldata['msg']= 'Successfully Update!';
			$modeldata['flag']=1;
		}
		}else{
			$this->db->set('default_lang','default');
			$this->db->where('id',$lang_data['lang_name']);
			$this->db->update('lang');
			$modeldata['msg']= 'Successfully Update!';
			$modeldata['flag']=1;
		}
		return $modeldata;
	}
}