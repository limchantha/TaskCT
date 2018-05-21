<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Upload extends CI_Upload
{
    public $multi = 'all';

    /**
     * Hold multiple errors
     * @var array
     */
    public $multi_errors = array();
    /**
     * keep track if the upload was finished or not
     * @var bool
     */
    public $finished = FALSE;
    /**
     * a temporary string that will be appended to the errors when one or more files is/are not uploaded
     * @var string
     */
    public $tempString;
    /**
     * an array that will contain all the data regarding the successfully uploaded files
     * @var array
     */
    public $uploadedFiles = array();

    function __construct($config = array())
    {
        parent::__construct($config);
        if(array_key_exists('multi',$config))
        {
            $this->set_multi($config['multi']);
        }
    }

    public function do_upload($field = 'userfile') {

        if (!isset($_FILES[$field])) {
            return false;
        }
        // check if it's a multiple upload. if not then fall back to CI do_upload()
        if (!is_array($_FILES[$field]['name'])) {
            return parent::do_upload($field);
        }
        // also if it is a multiple upload input type, verify if only one file was uploaded, and if yes give it to the CI do_upload()
        elseif(sizeof($_FILES[$field]['name'])==1)
        {
            $files = $_FILES[$field];
            $_FILES[$field]['name'] = $files['name'][0];
            $_FILES[$field]['type'] = $files['type'][0];
            $_FILES[$field]['tmp_name'] = $files['tmp_name'][0];
            $_FILES[$field]['error'] = $files['error'][0];
            $_FILES[$field]['size'] = $files['size'][0];
            return $this->do_upload($field);
        }
        // else do the magic
        else
        {
            $files = $_FILES[$field];
            foreach ($files['name'] as $key => $value)
            {
                $_FILES[$field]['name'] = $files['name'][$key];
                $_FILES[$field]['type'] = $files['type'][$key];
                $_FILES[$field]['tmp_name'] = $files['tmp_name'][$key];
                $_FILES[$field]['error'] = $files['error'][$key];
                $_FILES[$field]['size'] = $files['size'][$key];
                if ($this->do_upload($field))
                {
                    // if the upload was successfull add an element to the uploadedFiles array that contains the data regarding the uploaded file
                    $this->uploadedFiles[] = $this->data();
                }
                else
                {
                    // if the upload was unsuccessfull, set a temporary string that will contain the name of the file in question. The string will later be used by the modified display_errors() method
                    $this->tempString = 'File: ' . $_FILES[$field]['name'].' - Error: ';
                    // keep the errors in the multi_errors array
                    $this->multi_errors[] = $this->display_errors('', '');

                }
                // now we decide if we continue uploading depending on the "multi" key inside the configuration
                switch($this->multi)
                {
                    case 'all':
                        if(sizeof($this->multi_errors)>0 && sizeof($this->uploadedFiles>0))
                        {
                            foreach($this->uploadedFiles as $dataFile)
                            {
                                if(file_exists($dataFile['full_path'])) unlink($dataFile['full_path']);
                            }
                            break 2;
                        }
                        break;
                    case 'halt':
                        if(sizeof($this->multi_errors)>0) break 2;
                        break;
                    //case 'ignore':
                    default :
                        break;
                }
            }
            if(sizeof($this->multi_errors)>0 && $this->multi == 'all' )
            {
                return FALSE;
            }
            // at the end of the uploads, change the finished variable to true so that the class will know it finished it's main job
            $this->finished = TRUE;
            return TRUE;
        }
    }

    public function data($index = NULL)
    {
        //first we loook if the files were uploaded. if they were we just return the array with the data regarding the uploaded files
        if($this->finished === TRUE)
        {
            return $this->uploadedFiles;
        }
        // if the files were not uploaded, then we update the data
        $data = array(
            'file_name'		=> $this->file_name,
            'file_type'		=> $this->file_type,
            'file_path'		=> $this->upload_path,
            'full_path'		=> $this->upload_path.$this->file_name,
            'raw_name'		=> str_replace($this->file_ext, '', $this->file_name),
            'orig_name'		=> $this->orig_name,
            'client_name'		=> $this->client_name,
            'file_ext'		=> $this->file_ext,
            'file_size'		=> $this->file_size,
            'is_image'		=> $this->is_image(),
            'image_width'		=> $this->image_width,
            'image_height'		=> $this->image_height,
            'image_type'		=> $this->image_type,
            'image_size_str'	=> $this->image_size_str,
        );

        if ( ! empty($index))
        {
            return isset($data[$index]) ? $data[$index] : NULL;
        }

        return $data;
    }

    public function display_errors($open = '<p>', $close = '</p>')
    {
        if($this->finished === TRUE)
        {
            return $this->multi_errors;
        }
        $append = $this->tempString;
        $this->tempString = '';

        return (count($this->error_msg) > 0) ? $open . $append . implode($close . $open, $this->error_msg) . $close : '';

    }

    public function set_multi($course)
    {
        $options = array('all', 'halt','ignore');
        if(in_array($course,$options))
        {
            $this->multi = $course;
        }
        return $this;
    }
	
			/**
			 * Set Multiple Upload Data
			 *
			 * @access	protected
			 * @return	void
			 */
				protected function set_multi_upload_data(){
					$this->_multi_upload_data[] = array(
						"file_name"			=> $this->file_name,
						"file_type"			=> $this->file_type,
						"file_path"			=> $this->upload_path,
						"full_path"			=> $this->upload_path.$this->file_name,
						"raw_name"			=> str_replace($this->file_ext, "", $this->file_name),
						"orig_name"			=> $this->orig_name,
						"client_name"		=> $this->client_name,
						"file_ext"			=> $this->file_ext,
						"file_size"			=> $this->file_size,
						"is_image"			=> $this->is_image(),
						"image_width"		=> $this->image_width,
						"image_height"		=> $this->image_height,
						"image_type"		=> $this->image_type,
						"image_size_str"	=> $this->image_size_str
					);
				}
				
				
			/**
			 * Get Multiple Upload Data
			 *
			 * @access	public
			 * @return	array
			 */
				public function get_multi_upload_data(){
					return $this->_multi_upload_data;
				}
				
				
			/**
			 * Multile File Upload
			 *
			 * @access	public
			 * @param	string
			 * @return	mixed
			 */
				public function do_multi_upload($field){
					//Is $_FILES[$field] set? If not, no reason to continue.
					if(!isset($_FILES[$field])){ return false; }
					
					//Is this really a multi upload?
					if(!is_array($_FILES[$field]["name"])){
						//Fallback to do_upload method.
						return $this->do_upload($field);
					}
					
					//Is the upload path valid?
					if(!$this->validate_upload_path()){
						//Errors will already be set by validate_upload_path() so just return FALSE
						return FALSE;
					}
					
					//Every file will have a separate entry in each of the $_FILES associative array elements (name, type, etc).
					//Loop through $_FILES[$field]["name"] as representative of total number of files. Use count as key in
					//corresponding elements of the $_FILES[$field] elements.
					for($i=0; $i<count($_FILES[$field]["name"]); $i++){
						//Was the file able to be uploaded? If not, determine the reason why.
						if(!is_uploaded_file($_FILES[$field]["tmp_name"][$i])){
							//Determine error number.
							$error = (!isset($_FILES[$field]["error"][$i])) ? 4 : $_FILES[$field]["error"][$i];
							
							//Set error.
							switch($error){
								//UPLOAD_ERR_INI_SIZE
								case 1:
									$this->set_error("upload_file_exceeds_limit");
								break;
								//UPLOAD_ERR_FORM_SIZE
								case 2:
									$this->set_error("upload_file_exceeds_form_limit");
								break;
								//UPLOAD_ERR_PARTIAL
								case 3:
									$this->set_error("upload_file_partial");
								break;
								//UPLOAD_ERR_NO_FILE
								case 4:
									$this->set_error("upload_no_file_selected");
								break;
								//UPLOAD_ERR_NO_TMP_DIR
								case 6:
									$this->set_error("upload_no_temp_directory");
								break;
								//UPLOAD_ERR_CANT_WRITE
								case 7:
									$this->set_error("upload_unable_to_write_file");
								break;
								//UPLOAD_ERR_EXTENSION
								case 8:
									$this->set_error("upload_stopped_by_extension");
								break;
								default:
									$this->set_error("upload_no_file_selected");
								break;
							}
							
							//Return failed upload.
							return FALSE;
						}
						
						//Set current file data as class variables.
						$this->file_temp	= $_FILES[$field]["tmp_name"][$i];
						$this->file_size	= $_FILES[$field]["size"][$i];
						$this->_file_mime_type($_FILES[$field], $i);
						$this->file_type	= preg_replace("/^(.+?);.*$/", "\\1", $this->file_type);
						$this->file_type	= $this->file_type;
						$this->file_name	= $this->_prep_filename($_FILES[$field]["name"][$i]);
						$this->file_ext		= $this->get_extension($this->file_name);
						$this->client_name	= $this->file_name;
						
						//Is the file type allowed to be uploaded?
						if(!$this->is_allowed_filetype()){
							$this->set_error("upload_invalid_filetype");
							return FALSE;
						}
						
						//If we're overriding, let's now make sure the new name and type is allowed.
						//Check if a filename was supplied for the current file. Otherwise, use it's given name.
						if(!empty($this->_multi_file_name_override[$i])){
							$this->file_name = $this->_prep_filename($this->_multi_file_name_override[$i]);
							
							//If no extension was provided in the file_name config item, use the uploaded one.
							if(strpos($this->_multi_file_name_override[$i], ".") === FALSE){
								$this->file_name .= $this->file_ext;
							//An extension was provided, lets have it!
							} else {
								$this->file_ext = $this->get_extension($this->_multi_file_name_override[$i]);
							}
							
							if(!$this->is_allowed_filetype(TRUE)){
								$this->set_error("upload_invalid_filetype");
								return FALSE;
							}
						}
						
						//Convert the file size to kilobytes.
						if($this->file_size > 0){
							$this->file_size = round($this->file_size/1024, 2);
						}
						
						//Is the file size within the allowed maximum?
						if(!$this->is_allowed_filesize()){
							$this->set_error("upload_invalid_filesize");
							return FALSE;
						}
						
						//Are the image dimensions within the allowed size?
						//Note: This can fail if the server has an open_basdir restriction.
						if(!$this->is_allowed_dimensions()){
							$this->set_error("upload_invalid_dimensions");
							return FALSE;
						}
						
						//Sanitize the file name for security.
					//	$this->file_name = $this->clean_file_name($this->file_name);
						
						//Truncate the file name if it's too long
						if($this->max_filename > 0){
							$this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
						}
						
						//Remove white spaces in the name
						if($this->remove_spaces == TRUE){
							$this->file_name = preg_replace("/\s+/", "_", $this->file_name);
						}
						
						/* Validate the file name
						 * This function appends an number onto the end of
						 * the file if one with the same name already exists.
						 * If it returns false there was a problem.
						 */
							$this->orig_name = $this->file_name;
							if($this->overwrite == FALSE){
								$this->file_name = $this->set_filename($this->upload_path, $this->file_name);
								if($this->file_name === FALSE){
									return FALSE;
								}
							}
							
						/* Run the file through the XSS hacking filter
						 * This helps prevent malicious code from being
						 * embedded within a file.  Scripts can easily
						 * be disguised as images or other file types.
						 */
							if($this->xss_clean){
								if($this->do_xss_clean() === FALSE){
									$this->set_error("upload_unable_to_write_file");
									return FALSE;
								}
							}
							
						/* Move the file to the final destination
						 * To deal with different server configurations
						 * we'll attempt to use copy() first.  If that fails
						 * we'll use move_uploaded_file().  One of the two should
						 * reliably work in most environments
						 */
							if(!@copy($this->file_temp, $this->upload_path.$this->file_name)){
								if(!@move_uploaded_file($this->file_temp, $this->upload_path.$this->file_name)){
									$this->set_error("upload_destination_error");
									return FALSE;
								}
							}
						
						/* Set the finalized image dimensions
						 * This sets the image width/height (assuming the
						 * file was an image).  We use this information
						 * in the "data" function.
						 */
							$this->set_image_properties($this->upload_path.$this->file_name);
							
						//Set current file data to multi_file_upload_data.
						$this->set_multi_upload_data();
					}
					
					//Return all file upload data.
					return TRUE;
			}
}
/* End of file MY_Upload.php */
/* Location: ./application/libraries/MY_Upload.php */