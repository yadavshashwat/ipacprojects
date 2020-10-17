<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Register_model','register');
        $this->load->model('Leaders_model','leaders');
        $this->load->model('User_leader_model','user_leader');
        $this->load->model('sendmails_model', 'send_mail');
        $this->load->model('Agenda_model','agenda');
        
        if(isset($_COOKIE['on_step'])){
            if($_COOKIE['on_step'] == '0'){
                if(isset($_COOKIE['after_register']) && $_COOKIE['after_register']){
                    setcookie("on_step","3",time() + (10 * 365 * 24 * 60 * 60),"/");
                    $_SESSION['user']['on_step']    = 3;
                }else{
                    redirect('/');
                }
            }else if($_COOKIE['on_step'] == '1'){ //agenda
                redirect('agenda');
            }else if($_COOKIE['on_step'] == '2'){ //vote
                 redirect('vote');
            }else if($_COOKIE['on_step'] == '4'){ //result
                 redirect('result');
            }else if($_COOKIE['on_step'] == '3'){
                setcookie("after_register","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                $_SESSION['user']['after_register'] = 1;

                if(!isset($_COOKIE['see_result'])){
                    setcookie("see_result","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                }                
                //setcookie("see_result","1",time() + (10 * 365 * 24 * 60 * 60),"/");
            }
        }else{
           redirect('/'); //home
        } 

        if(isset($_COOKIE['user_id']) && isset($_COOKIE['log_in']) && $_COOKIE['log_in']){
            setcookie("on_step","4",time() + (10 * 365 * 24 * 60 * 60),"/");             
            $_SESSION['user']['on_step']    = 4;//register
            $_SESSION['user']['is_active'] = 1;
            setcookie("user_status","1",time() + (10 * 365 * 24 * 60 * 60),"/");
            redirect('result');
        }       

        //echo '<pre>';print_r($_COOKIE);print_r($_SESSION);exit; 
    }

    public function checkIsVoted($session_id){
        $status = $this->user_leader->checkIsVoted($session_id);
        return $status;
    }

    public function index(){
        $data = array();
        $data['title']       = "Register";
        $data['site_key']    = $this->config->item('site_key');
        $data['all_state']   = $this->register->get_all_state();
        $data['total_votes'] = $this->leaders->get_total_vote();
        $data['show_popup']  = 0;
        //$data['show_result']  = $_COOKIE['see_result'];
        $data['total_votes']  = $this->leaders->get_total_vote();
        $data['top_leaders']  = $this->leaders->get_top_leaders();
        //$data['total_leader'] = $this->leaders->get_total_leaders();

        $data['top_agendas']  = $this->agenda->get_top_agenda();
        $data['total_agenda_vote']  = $this->agenda->get_total_agenda_vote();

        $data['total_agenda_voted_count'] = $this->agenda->getTotalUserSetAgenda();
        $data['total_leader_voted_count'] = $this->leaders->getTotalUserSetAgenda();


        $params['session_id'] = $_COOKIE['user_session_id'];
        $data['agenda_selected'] = $this->agenda->getSelectedAgendaSummary($params);
        $data['leader_selected'] = $this->leaders->getSelectedLeaderSummary($params);

        //echo '<pre>';print_r($data);exit;
        $this->load->view('register',$data);
    }

    public function get_all_district_in_state(){
        if(isset($_POST['state_id']) && !empty($_POST['state_id'])){
            $state_id = $this->input->post('state_id');
            $all_districts = $this->register->get_all_district_in_state($state_id);
            echo json_encode($all_districts);exit;
        }
    }

    public function get_all_collages_in_state_district(){
        if(isset($_POST['state_id']) && !empty($_POST['state_id'])){
            $state_id = $this->input->post('state_id');
            $district_id = $this->input->post('district_id');
            $all_collages = $this->register->get_all_collages_in_state_district($state_id,$district_id);
            echo json_encode($all_collages);exit;
        }
    }    

    public function file_check($str){
        //$allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');

        $allowed_mime_type_arr = array('image/jpeg','image/jpg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['profile_pic']['name']);
        if(isset($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please upload your profile pic.');
            return false;
        }
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

    public function submit_register(){        
        //echo '<pre>';print_r($_POST);print_r($_FILES);exit;
        $return = array(); 
        if(!empty($_POST)){
            $this->load->helper('file');      
            $this->load->library('form_validation');

            $this->form_validation->set_rules('regEmail', 'User Email', 'required|valid_email|xss_clean');
            $this->form_validation->set_rules('regName', 'Name', 'required|xss_clean|trim|addslashes');//|regex_match[/^[a-zA-Z ]+$/]
            $this->form_validation->set_rules('regMobile', 'Mobile Number', 'required|trim|numeric|exact_length[10]');
            $this->form_validation->set_rules('regWhatsapp', 'WhatsApp Number', 'required|trim|numeric|exact_length[10]');

            if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name']!=''){
                $this->form_validation->set_rules('profile_pic', '', 'callback_file_check');
            }

            $this->form_validation->set_error_delimiters('', '');

            if ($this->form_validation->run() == TRUE){

                $profile_pic = ""; 
                $error = "";

                if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name']!=''){
                    $path = $this->config->item('upload_path');      
                    if ( !is_dir($path)) 
                    {
                       mkdir($path,0777,true); 
                       chmod($path, 0777);       
                    }

                    $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);           
                    $ramdom_str = $this->generateRandomString();
                    $profile_pic = 'profile_pic_'.$ramdom_str.time().'.'.$ext;
                    $config['upload_path']   = $this->config->item('upload_path'); 
                    $config['allowed_types'] = 'jpeg|jpg|png'; 
                    $config['max_size']      = 1024; 
                    $config['file_name']     = $profile_pic;

                    $this->load->library('upload', $config);
                        
                    if ( ! $this->upload->do_upload('profile_pic')) {                  
                        $error = $this->upload->display_errors();              
                    }
                }

                if(!empty($error)){
                    $return['status'] = 'fail';
                    $return['msg'] = $error;                 
                    echo(json_encode($return));exit;
                }

                $collage_id   = 0;
                $collage_name = trim($this->input->post('regCollName'));

                if(!empty($collage_name)){
                    $sql = "SELECT id,name 
                            FROM collages_master 
                            WHERE name = '$collage_name' AND is_active = 1";

                    $query = $this->db->query($sql);        
                    $collage_detail = $query->row_array();  
                    
                    if(!empty($collage_detail)){
                        $collage_id = $collage_detail['id'];
                    }else{
                        $collage_data = array();
                        $collage_data['name'] = $collage_name;

                        $collage_data['aishe_code']      = '';
                        $collage_data['institute_type']  = '';
                        $collage_data['institute_group'] = '';
                        $collage_data['affilated_to']    = '';
                        
                        $collage_data['is_active'] = 0;
                        $collage_data['created_at'] = date("Y-m-d H:i:s");
                        $collage_data['modified_at'] = date("Y-m-d H:i:s");
                        $this->db->insert('collages_master', $collage_data);        
                        $collage_id = $this->db->insert_id();
                    }    
                }                    

                $date = new DateTime($_POST['regYear'].'-'.$_POST['regMonth'].'-'.$_POST['regDay']);
                $date_of_birth = $date->format('Y-m-d');
                $params = array();
                $params['user_name'] = $this->input->post('regName');
                $params['gender'] = $this->input->post('regGender');
                $params['date_of_birth'] = $date_of_birth;
                $params['mobile_number'] = $this->input->post('regMobile');
                $params['whats_app_number'] = $this->input->post('regWhatsapp');
                $params['user_email'] = $this->input->post('regEmail');

                $params['state_id']    = $this->input->post('regState');
                $params['district_id'] = $this->input->post('regDistrict');

                $params['is_student'] = $this->input->post('regStudType');
                
                $params['collage_state_id'] = $this->input->post('regCollgState');
                $params['collage_district_id'] = $this->input->post('regCollgDistrict');
                //$params['collage_state'] = $this->input->post('regCollgState');
                $params['collage_name'] = trim($this->input->post('regCollName'));
                $params['collage_name_id'] = $collage_id;
                $params['personality_1'] = $this->input->post('personality_1');
                $params['personality_2'] = $this->input->post('personality_2');
                $params['is_active'] = 0;
                $params['is_pta'] = 0;
                $params['user_ip'] = $_SERVER['REMOTE_ADDR'];
                //$session_id = session_id();
                $session_id = $_COOKIE['user_session_id'];

                $params['otp']     = $this->register->get_random_number();
                $params['profile_pic'] = $profile_pic;
                
                //echo $session_id;
                //echo "<pre>";print_r($params);exit;

                //Send SMS
                $message = "Your OTP is ".$params['otp']." for registering as Part Time Associate with I-PAC.";
                
                //Step 1. Check the mobile number alrey exist or not
                $this->db->where(array("mobile_number" => $params['mobile_number']));
                $user_details = $this->db->get("users")->row();

                if(!empty($user_details)){
                    if($user_details->is_active == 0){
                        //Step 2. Update the OTP and show the 
                        $params['otp_generate_timestamp'] = date("Y-m-d H:i:s");
                    
                        $this->db->set($params);
                        $this->db->where('id', $user_details->id);
                        $update_result = $this->db->update('users');

                        $sql = "UPDATE user_leader_vote 
                                SET user_id = $user_details->id 
                                WHERE session_id = '$session_id'";
                        $query = $this->db->query($sql);

                        $sql = "UPDATE new_leaders 
                                SET added_by_user_id = $user_details->id 
                                WHERE added_by_session_id = '$session_id'";
                        $query = $this->db->query($sql);

                        //SET USER ID IN new_agenda
                        $sql = "UPDATE new_agenda 
                                SET added_by_user_id = $user_details->id 
                                WHERE added_by_session_id = '$session_id'";
                        $query = $this->db->query($sql);

                        //SET USER ID IN user_agenda
                        $sql = "UPDATE user_agenda 
                                SET user_id = $user_details->id 
                                WHERE user_session_id = '$session_id'";
                        $query = $this->db->query($sql);                        

                        if($update_result){
                            //Send an OTP and Show the popup

                            $this->register->send_otp($params['mobile_number'], $message);

                            $_SESSION['user']['id'] = $user_details->id;
                            $_SESSION['user']['is_active'] = "0";

                            setcookie("user_id",$user_details->id,time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("user_status","0",time() + (10 * 365 * 24 * 60 * 60),"/");

                            $return['status'] = 'success';
                            $return['msg'] = "Update the OTP and timestamp.";                 
                            echo(json_encode($return));exit;
                        }else{
                            $return['status'] = 'fail';
                            $return['msg'] = "Failed to update data.";                 
                            echo(json_encode($return));exit;
                        }
                    }else{
                        $return['status'] = 'fail';
                        $return['msg'] = "This number has already been registered.";                 
                        echo json_encode($return);exit;
                    }
                }
                
                $params['otp_generate_timestamp'] = date("Y-m-d H:i:s");
                $params['registration_number'] = 0;

                $params['created_at'] = date("Y-m-d H:i:s");
                $params['modified_at'] = date("Y-m-d H:i:s");                

                $status = $this->register->register_user($params,$session_id);

                if($status == "Y"){
                    $this->register->send_otp($params['mobile_number'], $message);
                    $return['status'] = 'success';
                    $return['msg'] = "You have successfully register With us. Please Enter otp to validate.";
                    echo(json_encode($return));exit;
                }else{
                    $return['status'] = 'fail';
                    $return['msg'] = "Something went wrong. Please try later.";                 
                    echo json_encode($return);exit;
                }
            }else{
                $return['status'] = 'php_error';
                $return['msg'] = $this->form_validation->error_array();                
                echo(json_encode($return, TRUE));exit;
            }
        }else{
            $return['status'] = 'fail';
            $return['msg'] = "Please fill all form data.";                 
            echo(json_encode($return));exit;
        }
    }

    public function sendotp(){
        $this->register->send_otp();
    }

    public function verify_otp(){
        $return = array();
        if(!empty($_POST)){
            $user_otp = $this->input->post('user_otp');
            $user_id = $_SESSION['user']['id'];
            if($user_id){
                //Step 1. Select the user details from user id
                //$this->db->select("otp, otp_generate_timestamp, is_active");
                $this->db->where(array("id" => $user_id));
                $user_details = $this->db->get('users')->row();
                //dump($user_details);die;
                if(!empty($user_details)){

                    if($user_otp == $user_details->otp && strtotime($user_details->otp_generate_timestamp) < strtotime('+30 minutes',strtotime(Date("Y-m-d H:i:s")))){

                        //Step 2. Update the User status in Database
                        $update_data['is_active'] = 1;
                        $update_data['modified_at'] = Date("Y-m-d H:i:s");
                        $this->db->set($update_data);
                        $this->db->where('id', $user_id);
                        $update_result = $this->db->update('users');
                        if($update_result){

                            $_SESSION['user']['on_step'] = 4;
                            $_SESSION['user']['is_active'] = 1;
                            setcookie("on_step","4",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("user_status","1",time() + (10 * 365 * 24 * 60 * 60),"/");

                            if($user_details->is_pta == 0){
                                $email_data['user_name'] = $user_details->user_name;
                                $email_data['email'] = $user_details->user_email;
                                $email_data['registration_number'] = $user_details->registration_number;
                                $email_data['subject'] = "I-PAC PTA Registration Confirmation";
                                $email_data['email_view'] = "emails/register_thankyou";
                                $email_result = $this->send_mail->htmlmail($email_data);

                                //Send SMS
                                $message = "Hi ".$user_details->user_name.", Thanks for registering as a PTA with I-PAC. Hope to see you actively participate on the forum. Your unique voting link is:http://www.indianpac.com/naf/referral/".$user_details->registration_number;
                                $this->register->send_otp($user_details->mobile_number, $message);
                            }

                            $return['status'] = 'success';
                            $return['msg'] = "result";                 
                            echo(json_encode($return));exit;
                        }else{
                            $return['status'] = 'fail';
                            $return['msg'] = "Failed to update data.";                 
                            echo(json_encode($return));exit;
                        }
                            
                    }else{
                        $return['status'] = 'fail';
                        $return['msg'] = "Invalid OTP.";                 
                        echo(json_encode($return));exit;
                    }
                }else{
                    $return['status'] = 'fail';
                    $return['msg'] = "Invalid User Details.";                 
                    echo(json_encode($return));exit;
                }

            }else{
                $return['status'] = 'fail';
                $return['msg'] = "Invalid request.";                 
                echo(json_encode($return));exit;
            }
        }else{
            $return['status'] = 'fail';
            $return['msg'] = "Invalid request.";                 
            echo(json_encode($return));exit;
        }
    }

    public function resend_otp(){
        $return = array();  
        if(isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])){
            if(!empty($_POST)){
                $mobile_number = $this->input->post('pta_mobile_number');
                $user_id = $_COOKIE['user_id'];
                $sql = "SELECT otp,otp_generate_timestamp 
                        FROM users 
                        WHERE id = $user_id AND mobile_number = '$mobile_number'";
                $query = $this->db->query($sql);
                $otp_data = $query->row_array();
                if(!empty($otp_data)){
                    $message = $otp_data['otp']." is your OTP (One Time Password) to view the current results for the agenda and the leader poll on National Agenda Forum (NAF)";
                    $this->register->send_otp($mobile_number, $message);

                    $return['status'] = 'success';
                    $return['msg']    = "Update the OTP and timestamp.";                 
                    echo(json_encode($return));exit;
                }else{
                    $return['status'] = 'fail';
                    $return['msg'] = "User doesn't exist.";                 
                    echo(json_encode($return));exit;
                }
            }else{
                $return['status'] = 'fail';
                $return['msg'] = "Please provide mobile number.";                 
                echo(json_encode($return));exit;
            }
        }else{
            $return['status'] = 'fail';
            $return['msg'] = "Invalid request.";                 
            echo(json_encode($return));exit;
        }
    }

    public function check_user(){
        $return = array();
        if(!empty($_POST)){
            $mobile_number = $this->input->post('pta_mobile_number');
            $this->db->where(array("mobile_number" => $mobile_number, "is_active" => 1));
            $user_details = $this->db->get('users')->row();
            if(!empty($user_details)){
                //update the OTP and send success message...
                $update_data['otp'] = $this->register->get_random_number();
                $update_data['otp_generate_timestamp'] = date("Y-m-d H:i:s");

                //$session_id = session_id();

                $session_id = $_COOKIE['user_session_id'];

                $this->db->set($update_data);
                $this->db->where('id', $user_details->id);
                $update_result = $this->db->update('users');

                $sql = "UPDATE user_leader_vote 
                        SET user_id = $user_details->id 
                        WHERE session_id = '$session_id'";
                $query = $this->db->query($sql);

                $sql = "UPDATE new_leaders 
                        SET added_by_user_id = $user_details->id 
                        WHERE added_by_session_id = '$session_id'";
                $query = $this->db->query($sql);

                //SET USER ID IN new_agenda
                $sql = "UPDATE new_agenda 
                        SET added_by_user_id = $user_details->id 
                        WHERE added_by_session_id = '$session_id'";
                $query = $this->db->query($sql);

                //SET USER ID IN user_agenda
                $sql = "UPDATE user_agenda 
                        SET user_id = $user_details->id 
                        WHERE user_session_id = '$session_id'";
                $query = $this->db->query($sql);  

                if($update_result){
                    $message = "Your OTP is ".$update_data['otp']." for registering as Part Time Associate with I-PAC.";

                    $this->register->send_otp($mobile_number, $message);
                    $_SESSION['user']['id'] = $user_details->id;
                    $_SESSION['user']['is_active'] = "0";

                    setcookie("user_id",$user_details->id,time() + (10 * 365 * 24 * 60 * 60),"/");
                    setcookie("user_status","0",time() + (10 * 365 * 24 * 60 * 60),"/");

                    $return['status'] = 'success';
                    $return['msg'] = "Update the OTP and timestamp.";                 
                    echo(json_encode($return));exit;
                }else{
                    $return['status'] = 'fail';
                    $return['msg'] = "Failed to update data.";                 
                    echo(json_encode($return));exit;
                }
            }else{
                $return['status'] = 'fail';
                $return['msg'] = "User doesn't exist.";                 
                echo(json_encode($return));exit;
            }
        }else{
            $return['status'] = 'fail';
            $return['msg'] = "Invalid request.";                 
            echo(json_encode($return));exit;
        }
    }
}
