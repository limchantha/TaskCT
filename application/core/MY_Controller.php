<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
error_reporting(-1);
/**
 * 
 * This controller contains the common functions
 * @author Teamtweaks 
 *
 */ 

date_default_timezone_set('Asia/Kolkata'); 
class MY_Controller extends CI_Controller {  
	public $privStatus;	
	public $data = array();
	function __construct()
    {
        parent::__construct();
		ob_start();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->helper('url');
        $this->load->helper('text');		
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->load->library('session');
		$this->load->model(array('user_model'));
		$this->load->database();
		$this->db->reconnect();
		define('BASEURL',base_url());
        $this->data['logincheck']=$this->checkLogin('U'); 	
        $this->data['logcheck']=$this->checkLogin('U'); 	
        if($this->config->item('site_logo')!=''){
			$this->data['logo'] = base_url()."images/site/logo/".$this->config->item('site_logo');
		}
		else
		{
			$this->data['logo']=base_url()."images/site/logo/logo.png"; 	
        
		}
		 if($this->checkLogin('U')!=''){
			$this->data['userDetails'] = $this->db->query('select * from '.USERS.' where `id`="'.$this->checkLogin('U').'"');
		}
		if($this->checkLogin('A')!='')
		{
			$id=$this->checkLogin('A');
			$this->data['total_user_count']=$this->user_model->get_all_details(USERS,array('group'=>'0'));
			$this->data['total_tasker_count']=$this->user_model->get_all_details(USERS,array('group'=>'1'));
			$this->data['previllage']=$this->session->userdata('gm_session_prev');
			if($id==1){ $this->data['prev']=1;}else{ $this->data['prev']=0;}
		}
		
		if($this->session->userdata('currency_code')=="")
		{
			$GeoCurrencyType = $this->currencyCode();
			$currencyArr = $this->user_model->get_all_details(CURRENCY,array('status'=>'Active','currency_type'=>$GeoCurrencyType));
			if($currencyArr->num_rows()>0){
			    $get_default_currency=$currencyArr;
			}
			else
			{
				$get_default_currency=$this->user_model->get_all_details(CURRENCY,array('default_currency'=>'Yes'));
			}				
            $this->session->set_userdata('currency_code',$get_default_currency->row()->currency_type);
		    $this->session->set_userdata('currency_symbol',$get_default_currency->row()->currency_symbols); 		 
		    $this->session->set_userdata('currency_rate',$get_default_currency->row()->currency_rate); 	
			
		}
		
        $this->data['currency_lists']=$this->user_model->get_all_details(CURRENCY,array('status'=>'Active'));	
        $this->data['currency_code']=$this->session->userdata('currency_code');		
        $this->data['currency_symbol']=$this->session->userdata('currency_symbol');
        $this->data['currency_rate']=$this->session->userdata('currency_rate');
		
		$this->data['cms_row1']=$this->user_model->get_all_details(CMS,array('status'=>'Active','footer_order'=>'row1'));
		$this->data['cms_row2']=$this->user_model->get_all_details(CMS,array('status'=>'Active','footer_order'=>'row2'));
		$this->data['cms_row3']=$this->user_model->get_all_details(CMS,array('status'=>'Active','footer_order'=>'row3'));
		$this->data['cmstask_category']=$this->user_model->get_all_details(TASKER_CATEGORY, array('status'=>'Active'));
		
	}
    public function currencyCode()
	{
	 
		
		 $ip = $_SERVER['REMOTE_ADDR'];

		#$ip = '115.118.170.1'; //IND

		#$ip = '146.185.28.59'; //UK
		 
		$host = "http://www.geoplugin.net/php.gp?ip=$ip";
		 
		 if ( ini_get('allow_url_fopen') ) 
		 {
				$response = file_get_contents($host, 'r');	
		}
			 
		 $data = unserialize($response);

		return $data['geoplugin_currencyCode'];
	
	}	
    public function checkLogin($type=''){
    	if ($type == 'A'){
    		return $this->session->userdata('gmtech_admin_id');
    	}else if ($type == 'N'){
    		return $this->session->userdata('fc_session_admin_name');
    	}else if ($type == 'M'){
    		return $this->session->userdata('fc_session_admin_email');
    	}else if ($type == 'P'){
    		return $this->session->userdata('gm_session_prev');
    	}else if ($type == 'U'){
			$user_check = $this->user_model->get_all_details(USERS,array('id'=>$this->session->userdata('gm_user_id'),'status'=>'Active'));
			if($user_check->num_rows() > 0){
    		return $this->session->userdata('gm_user_id');
			}
			else
				$this->session->unset_userdata('gm_user_id');
    	}else if ($type == 'T'){
    		return $this->session->userdata('fc_session_temp_id');
			
    	}
    }
    
    /**
     * 
     * This function set the error message and type in session
     * @param string $type
     * @param string $msg
     */
    public function setErrorMessage($type='',$msg=''){
    	($type == 'success') ? $msgVal = 'message-green' : $msgVal = 'message-red';
		$this->session->set_flashdata('sErrMSGType', $msgVal);
		$this->session->set_flashdata('sErrMSG', $msg);
    }
   /**
    * 
    * This function check the admin privileges
    * @param String $name	->	Management Name
    * @param Integer $right	->	0 for view, 1 for add, 2 for edit, 3 delete
    */ 
   public function check_prev($name='',$right=''){
   		if(!empty(unserialize($this->data['previllage']))){extract(unserialize($this->data['previllage']));} 
			if($this->data['prev']==1 || (!empty(${$name}) && in_array('0',${$name}))){
			  return TRUE;
			}
			else
			{
				return FALSE;
			}
   }
   
   /**
    * 
    * Generate random string
    * @param Integer $length
    */
   public function get_rand_str($length='6'){
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
   }
   
   /**
    * 
    * Unsetting array element
    * @param Array $productImage
    * @param Integer $position
    */
	public function setPictureProducts($productImage,$position){
		unset($productImage[$position]);
		return $productImage;
	}
	
	/**
	 * 
	 * Resize the image
	 * @param int target_width
	 * @param int target_height
	 * @param string image_name
	 * @param string target_path
	 */
	 public function imageResizeWithSpace($box_w,$box_h,$userImage,$savepath){
			$thumb_file = $savepath.$userImage;
			
			list($w, $h, $type, $attr) = getimagesize($thumb_file);
			
				//print_r($box_w);die;
				$size=getimagesize($thumb_file);
			    switch($size["mime"]){
			        case "image/jpeg":
            			$img = imagecreatefromjpeg($thumb_file); //jpeg file
			        break;
			        case "image/gif":
            			$img = imagecreatefromgif($thumb_file); //gif file
				      break;
			      case "image/png":
			          $img = imagecreatefrompng($thumb_file); //png file
			      break;
				
				  default:
				        $im=false;
				    break;
				}
				
			$new = imagecreatetruecolor($box_w, $box_h);
			if($new === false) {
				//creation failed -- probably not enough memory
				return null;
			}
			$whiteColorIndex = imagecolorexact($new,255,255,255);
			$whiteColor = imagecolorsforindex($new,$whiteColorIndex);
			imagecolortransparent($new,$whiteColor);
		
			$fill = imagecolorallocate($new, 064, 064, 064);
			imagefill($new, 0, 0, $fill);
		
			//compute resize ratio
			$hratio = $box_h / imagesy($img);
			$wratio = $box_w / imagesx($img);
			$ratio = min($hratio, $wratio);
		
			if($ratio > 1.0)
				$ratio = 1.0;
		
			//compute sizes
			$sy = floor(imagesy($img) * $ratio);
			$sx = floor(imagesx($img) * $ratio);
		
			$m_y = floor(($box_h - $sy) / 2);
			$m_x = floor(($box_w - $sx) / 2);
		
			if(!imagecopyresampled($new, $img,
				$m_x, $m_y, //dest x, y (margins)
				0, 0, //src x, y (0,0 means top left)
				$sx, $sy,//dest w, h (resample to this size (computed above)
				imagesx($img), imagesy($img)) //src w, h (the full size of the original)
			) {
				//copy failed
				imagedestroy($new);
				return null;
				
			}
			imagedestroy($i);
			imagejpeg($new, $thumb_file, 90);
			
	}
	public function imageResizeWithSpace1($box_w,$box_h,$userImage,$savepath){
			
			
			
			 $thumb_file = $savepath.$userImage;
			
			 $dist_file = $savepath.'/thumb/'.$userImage;
			 
			 
			 
			$config['source_image']    = $dist_file;
			$config['wm_text'] = 'Rentals';
			$config['wm_type'] = 'text';
			$config['wm_font_path'] = './GILSANUB.TTF';
			$config['wm_font_size']    = '22';
			$config['wm_font_color'] = 'e9b9b9';
			$config['wm_vrt_alignment'] = 'middle';
			$config['wm_hor_alignment'] = 'center';
			$config['wm_padding'] = '0';
			$this->image_lib->initialize($config); 
			$this->image_lib->watermark();
			 
			 
			 
			 
			 
			 
			 
			 
				
			list($w, $h, $type, $attr) = getimagesize($thumb_file);
				
				$size=getimagesize($thumb_file);
			    switch($size["mime"]){
			        case "image/jpeg":
            			$img = imagecreatefromjpeg($thumb_file); //jpeg file
			        break;
			        case "image/gif":
            			$img = imagecreatefromgif($thumb_file); //gif file
				      break;
			      case "image/png":
			          $img = imagecreatefrompng($thumb_file); //png file
			      break;
				
				  default:
				        $im=false;
				    break;
				}
				
			$new = imagecreatetruecolor($box_w, $box_h);
			if($new === false) {
				//creation failed -- probably not enough memory
				return null;
			}
		
		
			$fill = imagecolorallocate($new, 255, 255, 255);
			imagefill($new, 0, 0, $fill);
		
			//compute resize ratio
			$hratio = $box_h / imagesy($img);
			$wratio = $box_w / imagesx($img);
			$ratio = min($hratio, $wratio);
		
			if($ratio > 1.0)
				$ratio = 1.0;
		
			//compute sizes
			$sy = floor(imagesy($img) * $ratio);
			$sx = floor(imagesx($img) * $ratio);
		
			$m_y = floor(($box_h - $sy) / 2);
			$m_x = floor(($box_w - $sx) / 2);
		
			if(!imagecopyresampled($new, $img,
				$m_x, $m_y, //dest x, y (margins)
				0, 0, //src x, y (0,0 means top left)
				$sx, $sy,//dest w, h (resample to this size (computed above)
				imagesx($img), imagesy($img)) //src w, h (the full size of the original)
			) {
				//copy failed
				imagedestroy($new);
				return null;
				
			}
			imagedestroy($i);
			imagejpeg($new, $dist_file, 99);
	}
	/**
	 * 
	 * Resize the image
	 * @param int target_width
	 * @param int target_height
	 * @param string image_name
	 * @param string target_path
	 */
	public function imageResizeWithSpaceold($box_w,$box_h,$userImage,$savepath){
			
			$thumb_file = $savepath.$userImage;
				
			list($w, $h, $type, $attr) = getimagesize($thumb_file);
				
				$size=getimagesize($thumb_file);
			    switch($size["mime"]){
			        case "image/jpeg":
            			$img = imagecreatefromjpeg($thumb_file); //jpeg file
			        break;
			        case "image/gif":
            			$img = imagecreatefromgif($thumb_file); //gif file
				      break;
			      case "image/png":
			          $img = imagecreatefrompng($thumb_file); //png file
			      break;
				
				  default:
				        $im=false;
				    break;
				}
				
			$new = imagecreatetruecolor($box_w, $box_h);
			if($new === false) {
				//creation failed -- probably not enough memory
				return null;
			}
		
		
			$fill = imagecolorallocate($new, 255, 255, 255);
			imagefill($new, 0, 0, $fill);
		
			//compute resize ratio
			$hratio = $box_h / imagesy($img);
			$wratio = $box_w / imagesx($img);
			$ratio = min($hratio, $wratio);
		
			if($ratio > 1.0)
				$ratio = 1.0;
		
			//compute sizes
			$sy = floor(imagesy($img) * $ratio);
			$sx = floor(imagesx($img) * $ratio);
		
			$m_y = floor(($box_h - $sy) / 2);
			$m_x = floor(($box_w - $sx) / 2);
		
			if(!imagecopyresampled($new, $img,
				$m_x, $m_y, //dest x, y (margins)
				0, 0, //src x, y (0,0 means top left)
				$sx, $sy,//dest w, h (resample to this size (computed above)
				imagesx($img), imagesy($img)) //src w, h (the full size of the original)
			) {
				//copy failed
				imagedestroy($new);
				return null;
				
			}
			imagedestroy($i);
			imagejpeg($new, $thumb_file, 99);
			
	}
	
	public function watermarkimages($uploaddir,$image_name){
			$masterURL =$uploaddir.$image_name;
			header('content-type: image/jpeg');
			$path = base_url().'images/logo/'.$this->config->item('watermark');
			$watermark = imagecreatefrompng('images/watermark3.png');
			$watermark_width = imagesx($watermark);
			$watermark_height = imagesy($watermark);
			$image = imagecreatetruecolor($watermark_width, $watermark_height);
			$image = imagecreatefromjpeg($masterURL);
			$size = getimagesize($masterURL);
			$dest_x = $size[0] - $watermark_width - 5;
			$dest_y = $size[1] - $watermark_height - 500;
			imagecopymerge($image, $watermark, $dest_x, $dest_y,0, 0, $watermark_width, $watermark_height,20);
			imagejpeg($image, $masterURL);
	}

	/**
	 * 
	 * Resize the image
	 * @param int target_width
	 * @param int target_height
	 * @param string image_name
	 * @param string target_path
	 */
	public function imageResizeWithSpaceCity($box_w,$box_h,$userImage,$savepath){
			$thumb_file = $savepath.$userImage;
			$dist_file = $savepath.'/thumb/'.$userImage;
			list($w, $h, $type, $attr) = getimagesize($thumb_file);
				$size=getimagesize($thumb_file);
			    switch($size["mime"]){
			        case "image/jpeg":
            			$img = imagecreatefromjpeg($thumb_file); //jpeg file
			        break;
			        case "image/gif":
            			$img = imagecreatefromgif($thumb_file); //gif file
				      break;
			      case "image/png":
			          $img = imagecreatefrompng($thumb_file); //png file
			      break;
				
				  default:
				        $im=false;
				    break;
				}
			$new = imagecreatetruecolor($box_w, $box_h);
			if($new === false) {
				return null;
			}
			$fill = imagecolorallocate($new, 000, 000, 000);
			imagefill($new, 0, 0, $fill);
			$hratio = $box_h / imagesy($img);
			$wratio = $box_w / imagesx($img);
			$ratio = min($hratio, $wratio);
			if($ratio > 1.0)
				$ratio = 1.0;
			$sy = floor(imagesy($img) * $ratio);
			$sx = floor(imagesx($img) * $ratio);
			$m_y = floor(($box_h - $sy) / 2);
			$m_x = floor(($box_w - $sx) / 2);
			if(!imagecopyresampled($new, $img,
				$m_x, $m_y, //dest x, y (margins)
				0, 0, //src x, y (0,0 means top left)
				$sx, $sy,//dest w, h (resample to this size (computed above)
				imagesx($img), imagesy($img)) //src w, h (the full size of the original)
			) {
				imagedestroy($new);
				return null;
			}
			imagedestroy($i);
			imagejpeg($new, $dist_file, 99);
	}

	public function ImageCompress($source_url, $destination_url, $quality=50){
		$info = getimagesize($source_url);
		$savePath = $source_url;
		if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($savePath);
		elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($savePath);
		elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($savePath);
		imagejpeg($image, $savePath, $quality);
	}

	public function getImageShape($width, $height, $target_file){
		list($w, $h) = getimagesize($target_file);
		if($w==$width && $h==$height){
			$option="exact";
		}else if($w>$h){
			$option="landscape";
		}else if($w<$h){
			$option="portrait";
		}else{
			$option="crop";
		}
		return $option;
	}
	
	/*--Push Notification for IOS--*/
	
	public function push_notification_user_ios($deviceId,$message){
		if($deviceId!=""){
			$this->load->library('Apns');
			$this->apns->send_push_message_user($deviceId,$message); 
		}
	}
	public function push_notification_tasker_ios($deviceId,$message){ 
		if($deviceId!=""){
			$this->load->library('Apns'); 
			$this->apns->send_push_message_tasker($deviceId,$message);  
		}
	}
	public function push_notification_user_android($deviceId,$message){
		if($deviceId!=""){
			$this->sendPushNotificationToAndroid($deviceId,$message);
		}
	}
	public function push_notification_tasker_android($deviceId,$message){
		if($deviceId!=""){
			$this->sendPushNotificationToAndroid($deviceId,$message);
		}
	}
	
	/*--Push Notification for IOS--*/
	
	/**
     * This function send the notification for Anriod
     * @param string $registration_ids
     * @param string $message 
     * */
    public function sendPushNotificationToAndroid($registration_ids, $message) {
		
        //Google cloud messaging GCM-API url
       $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,
        );
		// Google Cloud Messaging GCM API Key
	 	define("GOOGLE_API_KEY", "AIzaSyBnTCgx2aoEn2zN-1x46Sk9QWeUCqF7EqQ"); 		
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        //var_dump($result);die;
        return $result;
    } 
	
	
/* 	 function sendPushNotificationToAndroid($registatoin_ids, $message) {
		//Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
		// Google Cloud Messaging GCM API Key
		define("GOOGLE_API_KEY", "AIzaSyBnTCgx2aoEn2zN-1x46Sk9QWeUCqF7EqQ"); 		
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);				
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
		//var_dump($result);die;
        return $result;
    }
	  */
	public function ImageResizeWithCrop($width, $height, $thumbImage, $savePath){
		
		$thumb_file = $savePath.$thumbImage;
		
		$newimgPath = base_url().$savePath.$thumbImage;
		
		/* Get original image x y*/
		list($w, $h) = getimagesize($thumb_file);
		$size=getimagesize($thumb_file);
		/* calculate new image size with ratio */
		$ratio = max($width/$w, $height/$h);
		$h = ceil($height / $ratio);
		$x = ($w - $width / $ratio) / 2;
		$w = ceil($width / $ratio);
		/* new file name */
		$path = $savePath.$thumbImage;
		/* read binary data from image file */
		
		$imgString = file_get_contents($newimgPath);
		/* create image from string */
		$image = imagecreatefromstring($imgString);
		$tmp = imagecreatetruecolor($width, $height);
		imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h); 
	
		/* Save image */
		switch ($size["mime"]) {
			case 'image/jpeg':
				imagejpeg($tmp, $path, 100);
				break;
			case 'image/png':
				imagepng($tmp, $path, 0);
				break;
			case 'image/gif':
				imagegif($tmp, $path);
				break;
			default:
				exit;
			break;
		}
		return $path;
		/* cleanup memory */
		imagedestroy($image);
		imagedestroy($tmp);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}
