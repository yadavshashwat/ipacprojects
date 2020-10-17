<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Agenda_model','agenda');

        $this->load->model('Leaders_model','leaders');
        $this->load->model('Register_model','register');
        $this->load->model('User_leader_model','user_leader');
        $this->load->model('Referral_model','referral');

		//Commented on 25th July 6AM
        /*if(isset($_COOKIE['on_step'])){
            if($_COOKIE['on_step'] == '1'){

            }else if($_COOKIE['on_step'] == '0'){
                setcookie("on_step","1",time() + (10 * 365 * 24 * 60 * 60),"/"); 
                $_SESSION['user']['on_step'] = 1;
            }else if($_COOKIE['on_step'] == '2'){
                setcookie("on_step","1",time() + (10 * 365 * 24 * 60 * 60),"/"); 
                $_SESSION['user']['on_step'] = 1;
                //redirect('vote');
            }else if($_COOKIE['on_step'] == '3'){
                redirect('register');
            }else if($_COOKIE['on_step'] == '4'){
                redirect('result');
            }
        }else{
           redirect('/');
        }*/

        if(isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])){
            if($_COOKIE['step_agenda'] == '0' && $_COOKIE['step_vote'] =='0'){
                setcookie("path","agenda",time() + (10 * 365 * 24 * 60 * 60),"/");

//                setcookie("step_1","Set the Agenda",time() + (10 * 365 * 24 * 60 * 60),"/");
//                setcookie("step_2","Choose the Leader",time() + (10 * 365 * 24 * 60 * 60),"/");
            }else if($_COOKIE['step_agenda']=='0' && $_COOKIE['step_vote'] == '1'){
//                setcookie("step_1","Choose the Leader",time() + (10 * 365 * 24 * 60 * 60),"/");
//                setcookie("step_2","Set the Agenda",time() + (10 * 365 * 24 * 60 * 60),"/");


            }else if($_COOKIE['step_agenda']=='1' && $_COOKIE['step_vote'] == '0'){
//                setcookie("step_1","Choose the Leader",time() + (10 * 365 * 24 * 60 * 60),"/");
//                setcookie("step_2","Set the Agenda",time() + (10 * 365 * 24 * 60 * 60),"/");
            }else if($_COOKIE['step_agenda']=='1' && $_COOKIE['step_vote'] == '1'){
                redirect('register');
            }

        }else{
            setcookie("path","agenda",time() + (10 * 365 * 24 * 60 * 60),"/");
            setcookie("step_agenda","0",time() + (10 * 365 * 24 * 60 * 60),"/");
            setcookie("step_vote","0",time() + (10 * 365 * 24 * 60 * 60),"/");
//            setcookie("step_1","Set the Agenda",time() + (10 * 365 * 24 * 60 * 60),"/");
//            setcookie("step_2","Choose the Leader",time() + (10 * 365 * 24 * 60 * 60),"/");

        }



        //echo '<pre>';print_r($_COOKIE);print_r($_SESSION);exit;  
		if(isset($_COOKIE['on_step'])){

            if($_COOKIE['on_step'] == '1'){
            }
            else if($_COOKIE['on_step'] == '0'){
                setcookie("on_step","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                $_SESSION['user']['on_step'] = 1;
            }else if($_COOKIE['on_step'] == '2'){
                setcookie("on_step","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                $_SESSION['user']['on_step'] = 1;
                //redirect('vote');
            }else if($_COOKIE['on_step'] == '3'){
//                redirect('register');
            }else if($_COOKIE['on_step'] == '4'){
//                redirect('result');
            }
        }
        else {
                setcookie("on_step","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                $_SESSION['user']['on_step'] = 1;
        }  
    }

    public function index(){
        $data = array();
        $data['title']             = "Agenda";
        $data['site_key']          = $this->config->item('site_key');

        if(isset($_SESSION['user']['referral_code']) && isset($_SESSION['user']['referral_owner_id'])){
            $data['referral_code']     = $_SESSION['user']['referral_code'];
            $data['referral_owner_id'] = $_SESSION['user']['referral_owner_id']; 
        }else{
            $data['referral_code']     = 0;
            $data['referral_owner_id'] = 0;
        }              

        $data['gandhi_agenda_list']       = $this->agenda->getGandhiAgendaList();
        $data['agenda_list']       = $this->agenda->getAgendaList();

        $params['session_id']    = session_id();
        $data['selected_agenda'] = $this->agenda->getSelectedAgenda($params);

        //echo '<pre>';print_r($data);exit;
        $this->load->view('agenda',$data);
    }

    public function addUserAgenda(){
        $return = array();
        if(!empty($_POST)){
            //echo '<pre>';print_r($_POST);exit;
            if(empty($_POST['new_agenda']) && !isset($_POST['agenda_name'])){
                $return['status'] = 'fail';
                $return['msg']    = 'Please choose agenda.';                
                echo(json_encode($return, TRUE));exit;
            }else if(empty($_POST['session_id'])){
                $return['status'] = 'fail';
                $return['msg']    = 'Something Went Wrong. Please try later..';                
                echo(json_encode($return, TRUE));exit;                        
            }  

            $params = array();

            if(!isset($_POST['agenda_name'])){
                $params['agenda_name'] = '';
            }else{
                $params['agenda_name'] = $_POST['agenda_name'];
            }            

            $params['new_agenda']  = $this->input->post('new_agenda');
            $params['session_id']  = $this->input->post('session_id'); //SESSION ID
            $params['user_ip']     = $_SERVER['REMOTE_ADDR'];          //IP ADDRESS

            if(isset($_COOKIE['user_id'])){
                $params['user_id']     = $_COOKIE['user_id'];
            }else{
                $params['user_id']     = 0;
            }

            $params['user_tracting_detail'] = json_encode($_SERVER); 

            if(isset($_POST['referral_code'])){
                $params['referral_code'] = $this->input->post('referral_code'); 
            }
            if(isset($_POST['referral_owner_id'])){
                $params['referral_owner_id'] = $this->input->post('referral_owner_id');
            }
            
            $params['created_at']  = date("Y-m-d H:i:s");
            $params['modified_at'] = date("Y-m-d H:i:s"); 

            //echo '<pre>';print_r($params);exit;    
            $status = $this->agenda->addUserAgenda($params);
            setcookie("step_agenda","1",time() + (10 * 365 * 24 * 60 * 60),"/");

            if($status == 'Y'){
                //SETTING USER SESSION & COOKIE DATA
                setcookie("on_step","2",time() + (10 * 365 * 24 * 60 * 60),"/");//VOTE  
                setcookie("user_session_id",$this->input->post('session_id'),time() + (10 * 365 * 24 * 60 * 60),"/"); 
                
                $_SESSION['user']['on_step']    = 2;//vote
                $_SESSION['user']['session_id'] = $this->input->post('session_id');

                $return['status'] = 'success';
                $return['msg']    = '';                
                echo(json_encode($return, TRUE));exit;
            }else{
                $return['status'] = 'fail';
                $return['msg']    = 'Something Went Wrong. Please Try later.';                
                echo(json_encode($return, TRUE));exit;
            }
        }
    }

    public function postAgenda(){
        //echo "hi";exit;
        //print_r($_GET);
        $return = array();
        $auth_id=$_GET['a'];
        $passcode=$_GET['b'];
        $loginstatus= $this->apiLogin($auth_id, $passcode);
        if($loginstatus == 'Y'){
        if(!empty($_GET)){
            //echo '<pre>';print_r($_POST);exit;
            if(empty($_GET['new_agenda']) && !isset($_GET['agenda_id'])){
                $return['status'] = 'fail';
                $return['msg']    = 'Please choose agenda.';                
                echo(json_encode($return, TRUE));exit;
            }else if(empty($_GET['u_id'])){
                $return['status'] = 'fail';
                $return['msg']    = 'Something Went Wrong. Please try later..';                
                echo(json_encode($return, TRUE));exit;                        
            }  

            $params = array();

            if(!isset($_GET['agenda_id'])){
                $params['agenda_id'] = '';
            }else{
                $params['agenda_id'] = $_GET['agenda_id'];
            }            
            if(!isset($_GET['new_agenda'])){
                $params['new_agenda'] = '';
            }else{
                $params['new_agenda'] = $_GET['new_agenda'];
            }
            $params['session_id']  = $_GET['u_id']; //SESSION ID
            $params['user_ip']     = $_SERVER['REMOTE_ADDR'];          //IP ADDRESS

            // if(isset($_COOKIE['user_id']) && $_COOKIE['log_in']){
                // $params['user_id']     = $_COOKIE['user_id'];
            // }else{
                $params['user_id']     = 0;
            // }

            $params['user_tracting_detail'] = json_encode($_SERVER); 

            $params['referral_code'] = "api"; 
            $params['referral_owner_id'] = "";
            
            $params['created_at']  = date("Y-m-d H:i:s");
            $params['modified_at'] = date("Y-m-d H:i:s"); 

            //echo '<pre>';print_r($params);exit;    
            $status = $this->agenda->postAgenda($params);
            setcookie("step_agenda","1",time() + (10 * 365 * 24 * 60 * 60),"/");

            if($status == 'Y'){
                //SETTING USER SESSION & COOKIE DATA
                setcookie("on_step","2",time() + (10 * 365 * 24 * 60 * 60),"/");//VOTE  
                setcookie("user_session_id",$_GET['u_id'],time() + (10 * 365 * 24 * 60 * 60),"/"); 
                
                $_SESSION['user']['on_step']    = 2;//vote
                $_SESSION['user']['session_id'] = $_GET['u_id'];

                $return['status'] = 'success';
                $return['msg']    = '';                
                echo(json_encode($return, TRUE));exit;
            }else{
                $return['status'] = 'fail';
                $return['msg']    = 'Something Went Wrong. Please Try later.';                
                echo(json_encode($return, TRUE));exit;
            }
        }
        echo(json_encode($return, TRUE));exit;
        }
        else{
            echo(json_encode($return, TRUE));exit;
        }
    }

    public function getUserTotalVotecrn(){
        $getallvotes=$this->agenda->getUserTotalVotecron();
        foreach($getallvotes as $row) {
            if($row['total_ref_vote']!="" && $row['total_ref_vote'] > 0){
            echo $sql = "UPDATE users
                    SET ytotal_ref_vote = '".$row['total_ref_vote']."'
                    WHERE id = '".$row['id']."'";
            $query = $this->db->query($sql);
            }
        }
    }


    public function check_user(){
        $return = array();  
        //echo '<pre>';print_r($_POST);exit;
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
                $return['msg'] = "Invalid Mobile Number.";                 
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
        echo '<pre>';print_r($_POST);print_r($_SESSION);exit;
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
                            $_SESSION['user']['log_in'] = 1;

                            setcookie("on_step","4",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("user_status","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("log_in","1",time() + (10 * 365 * 24 * 60 * 60),"/");

                            $return['status'] = 'success';
                            $return['msg'] = "result";                 
                            echo(json_encode($return));exit;
                        }else{
                            $_SESSION['user']['on_step'] = 1;
                            $_SESSION['user']['is_active'] = 0;                           
                            $_SESSION['user']['log_in'] = 1;

                            setcookie("on_step","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("user_status","0",time() + (10 * 365 * 24 * 60 * 60),"/");
                            setcookie("log_in","1",time() + (10 * 365 * 24 * 60 * 60),"/");

                            $return['status'] = 'success';
                            $return['msg'] = "agenda";                 
                            echo(json_encode($return));exit;
                        }   
                    }else{
                        $return['status'] = 'fail';
                        $return['msg'] = "Invalid OTP.";                 
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
    public function apiLogin($auth_id, $passcode){
        $status = $this->agenda->apiLogin($auth_id, $passcode);
        return $status;
    }
        
}
?>