<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends MY_Controller {
		 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('url','cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		
    } 
	
	public function lang_set($lang_key){
		$this->session->set_userdata('pictuslang_key',$lang_key);
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$remo = $_SERVER['HTTP_REFERER'];
			redirect($remo);
		}
		else
		{
			redirect('');
		}
	}
	
	public function index(){
		if($this->checkLogin('A')!='')
		{   
			$id=$this->checkLogin('A');
			$this->data['id']=$id;
			$this->data['heading']="Language List";
			$this->data['language_list'] = $this->language_model->get_language_list();
			$this->load->view('admin/language/language_list',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}	
		
	}
	
	public function language_edit(){
		$id = $this->uri->segment(4);
		$this->data['heading']="Edit Language";
		$this->data['edit_language'] = $this->language_model->edit_language($id);
		$this->load->view('admin/language/edit_language',$this->data);
	}
	
	public function add_language(){
		if($this->checkLogin('A')!='')
		{   
			$this->data['heading']="Add Language";			
			$this->load->view('admin/language/add_language',$this->data);
		}
		else
		{
			redirect(base_url().'admin');
		}
	}	
	
	public function language_view($lang){
		$this->data['heading']="Add Language";		
		$filePath 				= APPPATH."language/en/en_lang.php";		
		$fileValues 			= file_get_contents($filePath);
		$fileKeyValues_explode1 = explode("\$lang['", $fileValues);	
		
		$language_file_keys = array();
		foreach($fileKeyValues_explode1 as $fileKeyValues2)
		{
			$fileKeyValues_explode2 = explode("']", $fileKeyValues2);
			$language_file_keys[] = $fileKeyValues_explode2[0];
		}
		$this->lang->load('en', 'en');
		foreach(array_slice($language_file_keys,1) as $val){
			$language_file_values[] = $this->lang->line($val);
		}
		$this->lang->load($lang, $lang);
		$this->data['file_key_values'] = $language_file_keys;
		$this->data['file_lang_values'] = $language_file_values;
		$this->data['selectedLanguage'] = $lang;
		#echo '<pre>';print_r($lang);exit;
		$this->load->view('admin/language/lang_view',$this->data);
	}
	
	public function save_language(){
		$data = $this->input->post();
		$ctrldata = $this->language_model->save_language($data);	
		echo json_encode($ctrldata);
	}
	
	public function add_new_lang(){
		$getLanguageContentDetails  = $this->input->post('lang_name');
		$getLanguageKeyDetails 		= $this->input->post('lang_key');
		$selectedLanguage 			= $this->input->post('selectedLanguage');
		$loopItem = 0;
		$config = '<?php';
		foreach($getLanguageKeyDetails as $key_val)
		{
			$language_file_values = addslashes(htmlentities($getLanguageContentDetails[$loopItem], ENT_QUOTES, 'UTF-8'));
			$config .= "\n\$lang['$key_val']='$language_file_values'; ";
			$loopItem = $loopItem+1;
		}
		
		$config .= ' ?>';
		$languagDirectory = APPPATH."language/".$selectedLanguage;
		if(!is_dir($languagDirectory))
		{
			mkdir($languagDirectory,0777); 
		}
		
		$filePath = APPPATH."language/".$selectedLanguage."/".$selectedLanguage."_lang.php";
		file_put_contents($filePath, $config);
		$remo = $_SERVER['HTTP_REFERER'];
		redirect($remo);
	}
	
	public function delete_language(){
		$id = $this->input->post('cat_id');
		$ctrldata = $this->language_model->delete_language($id);	
		echo json_encode($ctrldata);
	}
	
	public function change_lang_settings(){
		$ctrldata = $this->language_model->update_default_language($this->input->post());	
		echo json_encode($ctrldata);
	}
}
