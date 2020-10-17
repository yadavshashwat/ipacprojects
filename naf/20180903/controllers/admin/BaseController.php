<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->library('form_validation');  
        $this->load->model('Admin_model','admin');   
          
        // Your own constructor code echo '<pre>';print_r($this->session->all_userdata());exit();
    }

    public function sendMail(){
        echo 'here';exit();
        $this->load->library('email');

        $this->email->from('sanket.hepta@gmail.com', 'Brevity Admin');
        $this->email->to('shrikant.hepta@gmail.com');
        //$this->email->cc('shrikant.hepta@gmail.com');
        //$this->email->bcc('them@their-example.com');*/

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        print_r($this->email->send());

        mail("sanket.hepta@gmail.com","Brevity Admin","Testing the email class.");
    }

    public function pre($array){
    	echo '<pre>';print_r($array);exit;
    }
    public function escape_string($str,$conn){
	    $str = $conn->real_escape_string($str);
	    return $str;
	}

	public function generatePassword(){
	    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$*()';
	    $password = '';
	    $max = strlen($characters) - 1;
	    for ($i = 0; $i < 8; $i++) {
	        $password .= $characters[mt_rand(0, $max)];
	    }
	    //return $password; 
	    return '1234';
	}

	public function generateRandomString($length = 4){
	    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	    $str = '';
	    $max = strlen($characters) - 1;
	    for ($i = 0; $i < $length  ; $i++) {
	        $str .= $characters[mt_rand(0, $max)];
	    }
	    return $str; 
	}

	public function encrypt_string($string, $salt) {
	    $key = pack('H*', $salt);    
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_CBC, $iv);
	    return base64_encode($iv . $ciphertext);
	}

	public function decrypt_string($encodedText, $salt) {
	    $key = pack('H*', $salt);
	    $ciphertext_dec = base64_decode($encodedText);
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
	    $ciphertext_dec = substr($ciphertext_dec, $iv_size);
	    return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	}

	public function validate_profile_pic($str){
        //$allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
    	$maxsize = 2 * 1024 * 1024; // 2MB
        $allowed_mime_type_arr = array('image/jpeg','image/jpg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['profile_pic']['name']);
        if(isset($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
            	if($_FILES['profile_pic']['size']>$maxsize){
            		 $this->form_validation->set_message('validate_profile_pic', 'uploaded file size is more than allowed.');
                	return false;
            	}
            	return true;
            }else{
                $this->form_validation->set_message('validate_profile_pic', 'Please select only jpeg/jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('validate_profile_pic', 'Please choose a file to upload.');
            return false;
        }
    }

	public function validate_baner_pic($str){
        //$allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
    	$maxsize = 2 * 1024 * 1024; // 2MB
        $allowed_mime_type_arr = array('image/jpeg','image/jpg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['baner_pic']['name']);
        if(isset($_FILES['baner_pic']['name']) && $_FILES['baner_pic']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
            	if($_FILES['baner_pic']['size']>$maxsize){
            		 $this->form_validation->set_message('validate_baner_pic', 'uploaded file size is more than allowed.');
                	return false;
            	}
            	return true;
            }else{
                $this->form_validation->set_message('validate_baner_pic', 'Please select only jpeg/jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('validate_baner_pic', 'Please choose a file to upload.');
            return false;
        }
    }

    public function validate_intro_video($str){
        //$allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
    	$maxsize = 20 * 1024 * 1024; // 20MB
        $allowed_mime_type_arr = array('video/mp4');
        $mime = get_mime_by_extension($_FILES['intro_video']['name']);

        if(isset($_FILES['intro_video']['name']) && $_FILES['intro_video']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
            	if($_FILES['intro_video']['size']>$maxsize){
            		 $this->form_validation->set_message('validate_intro_video', 'uploaded video size is more than allowed.');
                	return false;
            	}
            	return true;
            }else{
                $this->form_validation->set_message('validate_intro_video', 'Please select only mp4 file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('validate_intro_video', 'Please choose a file to upload.');
            return false;
        }
    }

    

    public function is_prof_email_exist_ajax(){
    	$this->input->post(NULL, TRUE);
    	$str      = $this->input->post('prof_email');
    	$is_exist = $this->admin->is_prof_email_exist($str); 
    	if($is_exist == 'Y'){    		
            echo 'false';
    	}else{
    		echo 'true';
    	}
    }

    public function is_stud_email_exist_ajax(){
        $str = $_POST['stud_email'];
        $is_exist = $this->admin->is_stud_email_exist($str); 
        if($is_exist == 'Y'){           
            echo 'false';
        }else{
            echo 'true';
        }
    }

    public function is_ta_email_exist_ajax(){
        $str = $_POST['ta_email'];
        $is_exist = $this->admin->is_ta_email_exist($str); 
        if($is_exist == 'Y'){           
            echo 'false';
        }else{
            echo 'true';
        }
    }

    public function validate_video($str){
        //$allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $maxsize = 20 * 1024 * 1024; // 20MB
        $allowed_mime_type_arr = array('video/mp4');
        $mime = get_mime_by_extension($_FILES['video']['name']);

        if(isset($_FILES['video']['name']) && $_FILES['video']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                /*if($_FILES['video']['size']>$maxsize){
                     $this->form_validation->set_message('validate_video', 'uploaded video size is more than allowed.');
                    return false;
                }*/
                return true;
            }else{
                $this->form_validation->set_message('validate_video', 'Please select only mp4 file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('validate_video', 'Please choose a file to upload.');
            return false;
        }
    }


    /*
     * file value and type check during validation
     */
    public function file_check($str){
        //$allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');

        $allowed_mime_type_arr = array('image/jpeg','image/jpg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['uni_logo']['name']);
        if(isset($_FILES['uni_logo']['name']) && $_FILES['uni_logo']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }
}
?>