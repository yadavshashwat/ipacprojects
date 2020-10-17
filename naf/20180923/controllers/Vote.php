<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Agenda_model','agenda');
        $this->load->model('Leaders_model','leaders');
        $this->load->model('Register_model','register');
        $this->load->model('User_leader_model','user_leader');
        $this->load->model('Referral_model','referral');



        if(isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])){
            if($_COOKIE['step_agenda'] == '0' && $_COOKIE['step_vote'] =='0'){
                setcookie("path","vote",time() + (10 * 365 * 24 * 60 * 60),"/");
                //                setcookie("step_1","Set the Agenda",time() + (10 * 365 * 24 * 60 * 60),"/");
//                setcookie("step_2","Choose the Leader",time() + (10 * 365 * 24 * 60 * 60),"/");
            }else if($_COOKIE['step_agenda']=='0' && $_COOKIE['step_vote'] == '1'){
//                setcookie("step_1","Choose the Leader",time() + (10 * 365 * 24 * 60 * 60),"/");
//                setcookie("step_2","Set the Agenda",time() + (10 * 365 * 24 * 60 * 60),"/");
                redirect('agenda');
            }else if($_COOKIE['step_agenda']=='1' && $_COOKIE['step_vote'] == '0'){
//                setcookie("step_1","Choose the Leader",time() + (10 * 365 * 24 * 60 * 60),"/");
//                setcookie("step_2","Set the Agenda",time() + (10 * 365 * 24 * 60 * 60),"/");
            }else if($_COOKIE['step_agenda']=='1' && $_COOKIE['step_vote'] == '1'){
                redirect('register');
            }

        }else{
            setcookie("path","vote",time() + (10 * 365 * 24 * 60 * 60),"/");
            setcookie("step_agenda","0",time() + (10 * 365 * 24 * 60 * 60),"/");
            setcookie("step_vote","0",time() + (10 * 365 * 24 * 60 * 60),"/");
        }

        setcookie("on_step","2",time() + (10 * 365 * 24 * 60 * 60),"/");

        //echo '<pre>';print_r($_COOKIE);print_r($_SESSION);exit;  

//        if(isset($_COOKIE['on_step'])){
//            if($_COOKIE['on_step'] == '0'){
//                redirect('/');
//            }else if($_COOKIE['on_step'] == '1'){
//                redirect('agenda');
//            }else if($_COOKIE['on_step'] == '2'){
//                //redirect('vote');
//            }else if($_COOKIE['on_step'] == '3'){
//                redirect('register');
//            }else if($_COOKIE['on_step'] == '4'){
//                redirect('result');
//            }
//        }else{
//           redirect('/');
//        }
    }

    public function index(){
        $data = array();
        $this->load->helper('captcha');

        $args = array(
            'img_path'=>'./captcha/',
            'img_url'=>base_url('captcha'),
            'img_width' => '150',
            'img_height'    => '30',
            'font_path' => './system/fonts/texb.ttf',
            'word_length'   => 4,
            'font_size' => 15,
            'pool'      => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'    => array(
                'background'    => array(0,0,0),
                'border'    => array(0,0,0),
                'text'      => array(255,255,255),
                'grid'      => array(0,0,0)
            )
        );

        $cap = create_captcha($args);
        $data['captcha'] = $cap;
        $_SESSION['captcha_answer'] = $cap['word'];
        $_SESSION['captcha_file']   = $cap['filename'];
        /*$number1 = rand(1,10);
        $number2 = rand(1,10);
        $_SESSION['captcha_answer'] = $number1+$number2;
        $data['math_captcha_question'] = $number1.' + '.$number2.' = ?';*/
        
        $data['title']             = "Vote";
        $data['site_key']          = $this->config->item('site_key');
        if(isset($_SESSION['user']['referral_code']) && isset($_SESSION['user']['referral_owner_id'])){
            $data['referral_code']     = $_SESSION['user']['referral_code'];
            $data['referral_owner_id'] = $_SESSION['user']['referral_owner_id']; 
        }else{
            $data['referral_code']     = 0;
            $data['referral_owner_id'] = 0;
        }  
        $data['session_id']        = session_id();;
        $data['featured_leaders']  = $this->leaders->get_all_featured_leaders();
        $data['other_leaders']     = $this->leaders->get_all_other_leaders();       
        
        ///echo '<pre>';print_r($data);print_r($_SESSION);exit;
        $this->load->view('vote',$data);
    } 

    public function getLeaderInfo(){
        if(!empty($_POST) && isset($_POST['leader_id'])){
            $params = array();
            $params['id'] = $this->input->post('leader_id');
            $getLeadrInfo = $this->leaders->getLeaderInfo($params);
            echo json_encode($getLeadrInfo);exit;
        }
    }

    public function updateLeaderVote(){
        //echo '<pre>';print_r($_POST);exit;
        if(!empty($_POST)){
            //$this->load->library('mathcaptcha');
            $return = array();
            //if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
            if(isset($_POST['captca_code']) && !empty($_POST['captca_code'])){
                /*$secret = $this->config->item('secret_key');
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);  */    

                //if($responseData->success){ 
                $captca_code = $this->input->post('captca_code');

                if ($captca_code == $_SESSION['captcha_answer']){                  
                    if(isset($_POST['vote'])){
                        if($_POST['vote'] == 'on'){
                            $this->load->library('form_validation');
                            $this->form_validation->set_rules('new_leader', 'Name', 'required|xss_clean|trim|addslashes');
                            if ($this->form_validation->run() == FALSE){
                                $return['status'] = 'fail';
                                $return['msg'] = "Please provide valid leader name.";                 
                                echo(json_encode($return));exit;
                            }
                        }
                    }else{
                        $return['status'] = 'fail';
                        $return['msg'] = "Please choose your leader.";                 
                        echo(json_encode($return));exit; 
                    }
                }else{
                    $return['status'] = 'fail';
                    $return['msg'] = "Please provide right captcha code.";                 
                    echo(json_encode($return));exit;
                }            
            }else{
                $return['status'] = 'fail';
                $return['msg'] = "Please insert captcha code.";                 
                echo(json_encode($return));exit;
            }
            unlink('./captcha/'.$_SESSION['captcha_file']);
            $params = array();

            if($_POST['vote'] == 'on'){
                $params = array();
                $params['full_name']  = trim($this->input->post('new_leader'));      
                if(isset($_COOKIE['user_id']) && $_COOKIE['log_in']){
                    $params['added_by_user_id']     = $_COOKIE['user_id'];
                }else{
                    $params['added_by_user_id']     = 0;
                }
                $status = $this->leaders->add_new_leader($params);
            }else{
                $params['leader_id']  = $this->input->post('vote');
                $params['is_new']     = 0;
                $params['session_id'] = $this->input->post('session_id');

                // if(isset($_COOKIE['user_id']) && $_COOKIE['log_in']){
                    // $params['user_id']     = $_COOKIE['user_id'];
                // }else{
                    $params['user_id']     = 0;
                // }

                $params['user_ip']    = $_SERVER['REMOTE_ADDR'];                
                $params['user_tracting_detail'] = json_encode($_SERVER); 

                if(isset($_POST['referral_code'])){
                    $params['referral_code'] = $this->input->post('referral_code'); 
                }
                if(isset($_POST['referral_owner_id'])){
                    $params['referral_owner_id'] = $this->input->post('referral_owner_id');
                }
                     
                $params['created_at']  = date("Y-m-d H:i:s");
                $params['modified_at'] = date("Y-m-d H:i:s");     
                $status = $this->user_leader->add_leader_vote($params);
                //Change by Shashwat start
//Change by shashwat end

            }   

            if($status == "Y"){
                setcookie("step_vote","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                setcookie("on_step","3",time() + (10 * 365 * 24 * 60 * 60),"/");
                $_SESSION['user']['on_step']    = 3;
                $return['status'] = 'success';
                $return['msg']    = "Your vote has been added.";                 
                echo(json_encode($return));exit;
            }
        }
    }

    public function postLeaderVote(){
       // echo '<pre>';print_r($_GET);exit;
        if(!empty($_GET)){
            $return = array();
            
            if($_GET['is_new'] == 'yes'){           
                if (empty($_GET['new_leader_name'])){
                    $return['status'] = 'fail';
                    $return['msg'] = "Please provide valid leader name.";                 
                    echo(json_encode($return));exit;
                }  
            }
            
            $params = array();
            if($_GET['is_new'] == 'yes'){
                $params = array();
                $params['full_name']  = trim($_GET['new_leader_name']);      
                if(isset($_COOKIE['user_id']) && $_COOKIE['log_in']){
                    $params['added_by_user_id']     = $_COOKIE['user_id'];
                }else{
                    $params['added_by_user_id']     = 0;
                }
                $status = $this->leaders->add_new_leader_api($params);
            }else{
                $params['leader_id']  = $_GET['leader_id'];
                $params['is_new']     = 0;
                $params['session_id'] = $_GET['u_id'];

                if(isset($_COOKIE['user_id']) && $_COOKIE['log_in']){
                    $params['user_id']     = $_COOKIE['user_id'];
                }else{
                    $params['user_id']     = 0;
                }

                $params['user_ip']    = $_SERVER['REMOTE_ADDR'];                
                $params['user_tracting_detail'] = json_encode($_SERVER); 
                $params['referral_code'] = ""; 
                $params['referral_owner_id'] = "";                                     
                $params['created_at']  = date("Y-m-d H:i:s");
                $params['modified_at'] = date("Y-m-d H:i:s");     
                $status = $this->user_leader->post_leader_vote($params);
           
            }   

            if($status == "Y"){               
                $return['status'] = 'success';
                $return['msg']    = "Your vote has been added.";                 
                echo(json_encode($return));exit;
            }else{
                $return['status'] = 'fail';
                $return['msg'] = "Unable to vote";                 
                echo(json_encode($return));exit;
            }
        }
    }


    public function addNewLeader(){
        //echo '<pre>';print_r($_POST);exit;
        if(!empty($_POST)){
            $return = array();            

            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
                $secret = $this->config->item('secret_key');
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);      

                if($responseData->success){
                    //email validation

                    $this->load->library('form_validation');

                    $this->form_validation->set_rules('new_leader', 'Name', 'required|xss_clean|trim|addslashes');
                    if ($this->form_validation->run() == FALSE){
                        $return['status'] = 'fail';
                        $return['msg'] = "Please provide valid leader name.";                 
                        echo(json_encode($return));exit;
                    }
                }else{
                    $return['status'] = 'fail';
                    $return['msg'] = "Please confirm you are not robot.";                 
                    echo(json_encode($return));exit;
                }            
            }else{
                $return['status'] = 'fail';
                $return['msg'] = "Please confirm you are not robot.";                 
                echo(json_encode($return));exit;
            }

            $params = array();
            $params['full_name']  = trim($this->input->post('new_leader'));      
            if(isset($_COOKIE['user_id']) && $_COOKIE['log_in']){
                $params['added_by_user_id']     = $_COOKIE['user_id'];
            }else{
                $params['added_by_user_id']     = 0;
            }      
            
            $status = $this->leaders->add_new_leader($params);
            if($status == "Y"){
                
                /*if(isset($_SESSION['user']['id'])){
                    $_SESSION['user']['is_active'] = 1;
                    $session_id =  $this->input->post('session_id');
                    $user_id = $_SESSION['user']['id'];
                    

                    $sql = "UPDATE user_leader_vote 
                            SET user_id = $user_id 
                            WHERE session_id = '$session_id'";
                    $query = $this->db->query($sql);

                    $sql = "UPDATE new_leaders 
                            SET added_by_user_id = $user_id 
                            WHERE added_by_session_id = '$session_id'";
                    $query = $this->db->query($sql);
                }*/
                setcookie("step_vote","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                setcookie("on_step","3",time() + (10 * 365 * 24 * 60 * 60),"/");//register 
                $_SESSION['user']['on_step'] = 3;//register

                //$_SESSION['user']['session_id'] = $this->input->post('session_id');//Already set in agenda
                $return['status'] = 'success';
                $return['msg']    = "Your vote has been added.";                 
                echo(json_encode($return));exit;
            }else{
                $return['status'] = 'fail';
                $return['msg']    = "Your vote has been added.";                 
                echo(json_encode($return));exit;
            }
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

                $this->db->set($update_data);
                $this->db->where('id', $user_details->id);
                $update_result = $this->db->update('users');

                if($update_result){
                    //Send SMS
                    $message = "Your OTP is ".$update_data['otp']." to view results of leader poll on National Agenda Forum (NAF).";
                    $this->register->send_otp($mobile_number, $message);

                    $_SESSION['user']['id'] = $user_details->id;
                    $_SESSION['user']['is_active'] = 0;

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

    public function verify_otp(){
        $return = array();
        if(!empty($_POST)){
            $user_otp = $this->input->post('user_otp');
            
            if(isset($_SESSION['user']['id'])){
                $user_id  = $_SESSION['user']['id'];
                
                $this->db->where(array("id" => $user_id));
                $user_details = $this->db->get('users')->row();
                //dump($user_details);die;
                if(!empty($user_details)){

                    if($user_otp == $user_details->otp && strtotime($user_details->otp_generate_timestamp) < strtotime('+30 minutes',strtotime(Date("Y-m-d H:i:s")))){
                            //Check the user gives a vot or not

                        $status = $this->checkIsVotedById($user_id);
                        //echo $status;exit;
                        if($status == "Y"){

                            $_SESSION['user']['is_active'] = 1;                             
                            $_SESSION['user']['on_step']   = 4;
                            $_SESSION['user']['log_in']    = 1;

                            setcookie("on_step","4",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("user_status","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("log_in","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                            
                            $return['status'] = 'success';
                            $return['msg'] = "result";                 
                            echo(json_encode($return));exit;
                        }else{
                            //$_SESSION['user']['is_active'] = 0;

                            $_SESSION['user']['on_step'] = 1;
                            $_SESSION['user']['is_active'] = 0;                           
                            $_SESSION['user']['log_in'] = 1;

                            setcookie("on_step","2",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("user_status","0",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("log_in","1",time() + (10 * 365 * 24 * 60 * 60),"/");

                            $return['status'] = 'success';
                            $return['msg'] = "vote";                     
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
                    $message = "Your OTP is ".$otp_data['otp']." to view results of leader poll on National Agenda Forum (NAF).";
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

    public function checkIsVotedById($user_id){
        $status = $this->user_leader->checkIsVotedById($user_id);
        return $status;
    }

            
}
?>