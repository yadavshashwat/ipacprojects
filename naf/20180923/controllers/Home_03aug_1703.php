<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Agenda_model','agenda');
        $this->load->model('Leaders_model','leaders');
        $this->load->model('Register_model','register');
        $this->load->model('User_leader_model','user_leader');
        $this->load->model('Referral_model','referral');
        $this->load->model('Carousel_model','carousel');
		$this->load->model('Testimonial_model','testimonial');
        $this->load->model('Partner_model','partner');
		$this->load->model('News_model','news');
        //$this->unset_user_cookie();

        if(isset($_COOKIE['on_step'])){
            if($_COOKIE['on_step'] == '1' || $_COOKIE['on_step'] == '2'){
                //setcookie("on_step","0",time() + (10 * 365 * 24 * 60 * 60),"/");
                //$_SESSION['user']['on_step'] = 0;

                if(isset($_COOKIE['user_session_id']) && !empty($_COOKIE['user_session_id'])){
                    $session_id = $_COOKIE['user_session_id'];
                    $status     = $this->checkIsVoted($session_id);
                    if($status == "Y"){
                        $this->user_leader->removeVote($session_id);
                    }
                }
            }else if($_COOKIE['on_step'] == '3'){
                //redirect('register');
                if(isset($_COOKIE['after_register']) && $_COOKIE['after_register'] == 1){
                    //setcookie("on_step","0",time() + (10 * 365 * 24 * 60 * 60),"/");
                    //$_SESSION['user']['on_step'] = 0;
                }else{
                    redirect('register');
                }

            }else if($_COOKIE['on_step'] == '4'){
                if(isset($_COOKIE['after_result']) && $_COOKIE['after_result'] == 1){
                    //setcookie("on_step","0",time() + (10 * 365 * 24 * 60 * 60),"/");
                    //$_SESSION['user']['on_step'] = 0;
                    $_SESSION['user']['log_in'] = 0;
                    setcookie("log_in","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                }else{
                    redirect('result');
                }
            }
        }else{
            //setcookie("on_step","0",time() + time() + (10 * 365 * 24 * 60 * 60),"/");
            //$_SESSION['user']['on_step'] = 0;
        }
        //echo '<pre>';print_r($_COOKIE);print_r($_SESSION);exit;          
    }

    public function unset_user_cookie(){
        setcookie('user_id', '', time()-3600,"/");
        setcookie('user_status', '', time()-3600,"/");
        setcookie('on_step', '', time()-3600,"/");
        setcookie('user_session_id', '', time()-3600,"/");        
        setcookie('log_in', '', time()-3600,"/");
        setcookie('after_result', '', time()-3600,"/");
        setcookie('after_register', '', time()-3600,"/");
        setcookie('see_result', '', time()-3600,"/");
        //unset($_SESSION['user']);
        //unset($_SESSION['on_step']);
        //echo '<pre>';print_r($_COOKIE);print_r($_SESSION);exit;
    }

    public function checkIsVoted($session_id){
        $status = $this->user_leader->checkIsVoted($session_id);
        return $status;
    }

    public function index(){
        $data = array();
        $data['title'] = "Home";

        if(isset($_SESSION['user']['referral_code'])){
            unset($_SESSION['user']['referral_code']);
        }

        if(isset($_SESSION['user']['referral_owner_id'])){
            unset($_SESSION['user']['referral_owner_id']);
        }

        $data['disable_vote']     = 0;
        $data['disable_agenda']   = 0;
        $data['disable_register'] = 0;

        if((isset($_COOKIE['after_register']) && $_COOKIE['after_register'] == 1) || (isset($_COOKIE['step_agenda']) && $_COOKIE['step_agenda'] == "1" && isset($_COOKIE['step_vote']) && $_COOKIE['step_vote'] == "1")) {
            $data['disable_vote'] = 1;
            $data['disable_agenda'] = 1;
            $data['disable_register'] = 0;
        }

        if(isset($_COOKIE['after_result']) && $_COOKIE['after_result'] == 1){
            $data['disable_vote'] = 1;
            $data['disable_agenda'] = 1;
            $data['disable_register'] = 1;
        }
        
        $data['total_agenda_voted_count'] = $this->agenda->getTotalUserSetAgenda();
        $data['total_leader_voted_count'] = $this->leaders->getTotalUserSetAgenda();
        $data['total_register_user'] = $this->register->getTotalRegisterUser();  
        $data['total'] = $data['total_agenda_voted_count'] + $data['total_leader_voted_count'] + $data['total_register_user'];
		
		$data['carousel_list']  = $this->carousel->getCarouselList();
		/*$data['testimonial_list']  = $this->testimonial->getTestimonialList();*/
        //$data['partner_list']  = $this->partner->getPartnerList();
		$data['news']  = $this->news->getNewsList();
        //echo '<pre>';print_r($data);exit;  
        $this->load->view('home',$data);
    }

    public function referral($referral_code){

        if(!empty($referral_code)){
            $referral_detail = $this->referral->get_referral_detail($referral_code);
            //echo '<pre>';print_r($referral_detail);exit;
            if(!empty($referral_detail)){
                $data = array();
                $_SESSION['user']['referral_code'] = $referral_code;
                $_SESSION['user']['referral_owner_id'] = $referral_detail['id'];

                $data['disable_vote']     = 0;
                $data['disable_agenda']   = 0;
                $data['disable_register'] = 0;

                if((isset($_COOKIE['after_register']) && $_COOKIE['after_register'] == 1) || (isset($_COOKIE['step_agenda']) && $_COOKIE['step_agenda'] == "1" && isset($_COOKIE['step_vote']) && $_COOKIE['step_vote'] == "1")) {
                    $data['disable_vote']     = 1;
                    $data['disable_agenda']   = 1;
                    $data['disable_register'] = 0;
                }

                if(isset($_COOKIE['after_result']) && $_COOKIE['after_result'] == 1){
                    $data['disable_vote']     = 1;
                    $data['disable_agenda']   = 1;
                    $data['disable_register'] = 1;
                }

                
                $data['title']              = "Home - Referral";

                $data['total_agenda_voted_count'] = $this->agenda->getTotalUserSetAgenda();
                $data['total_leader_voted_count'] = $this->leaders->getTotalUserSetAgenda();
                $data['total_register_user'] = $this->register->getTotalRegisterUser();   
                $data['total'] = $data['total_agenda_voted_count'] + $data['total_leader_voted_count'] + $data['total_register_user'];            
                //echo '<pre>';print_r($data);exit;               
                $data['carousel_list']  = $this->carousel->getCarouselList();
				/*$data['testimonial_list']  = $this->testimonial->getTestimonialList();*/
                //$data['partner_list']  = $this->partner->getPartnerList();
				$data['news']  = $this->news->getNewsList();
				$this->load->view('home',$data);
            }else{
                redirect('/');
            }
        }else{
            redirect('/');
        }
    }  

    public function check_user(){

/*----NEW CODE-EDITIED BY RAJESH---*/
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
                    $_SESSION['user']['id'] = $user_details->id;
                    $_SESSION['user']['is_active'] = 0;                    

                    setcookie("user_id",$user_details->id,time() + (10 * 365 * 24 * 60 * 60),"/");
                    setcookie("user_status","0",time() + (10 * 365 * 24 * 60 * 60),"/");

                    $return['status'] = 'success';
                        $user_id=$user_details->id;
                   $status = $this->checkIsVotedById($user_id);
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
   
	 
/*----NEW CODE-EDITIED BY RAJESH  END---*/	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 /*----------------OLD CODE----------------------------------------------------
	 
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
                $return['msg'] = "User doesn't exist.";                 
                echo(json_encode($return));exit;
            }
        }else{
            $return['status'] = 'fail';
            $return['msg'] = "Invalid request.";                 
            echo(json_encode($return));exit;
        }
   
   
   
   
   
   
   ---------------------------------------------------*/
   
   
   
   
   
   
   
    }  

    public function verify_otp(){
        $return = array();
        //echo '<pre>';print_r($_POST);print_r($_SESSION);exit;
        if(!empty($_POST)){
            $user_otp = $this->input->post('user_otp');
			
			
			
			/*$mobile_number = $this->input->post('pta_mobile_number');
                $user_id = $_COOKIE['user_id'];
                $sql12 = "SELECT otp,otp_generate_timestamp 
                        FROM users 
                        WHERE id = $user_id AND mobile_number = '$mobile_number'";
                $query = $this->db->query($sql12);
                $otp_data = $query->row_array();
			
			*/
			
			            
            if(isset($_SESSION['user']['id']))
			{
                $user_id  = $_SESSION['user']['id'];
                
                $this->db->where(array("id" => $user_id));
				$user_details = $this->db->get('users')->row();
			     				
                //dump($user_details);die;
                if(!empty($user_details)){

                    if($user_otp == $user_details->otp && strtotime($user_details->otp_generate_timestamp) < strtotime('+30 minutes',strtotime(Date("Y-m-d H:i:s"))))

//                    if($user_otp == $otp_data->otp && strtotime($otp_data->otp_generate_timestamp) < //strtotime('+30 minutes',strtotime(Date("Y-m-d H:i:s"))))

					
					{
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
                    }
					
					else{
						//$return['status'] = 'success';
                        $return['status'] = 'fail';
                        $return['msg'] = "Invalid OTP.".$user_details->otp."";                 
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
	
	// Get first 4 testimonials
    public function getTestimonials(){
        if(!empty($_GET)){
            $first_testimonial_data = $this->testimonial->getFirstTestimonials();
            echo json_encode($first_testimonial_data);
        }
    }

    public function next_testimonials(){
        if(!empty($_POST)){
            $item_count = $this->input->post('item_count');
            $next_testimonial = $this->testimonial->getTestimonialList($item_count);
            echo json_encode($next_testimonial);
        }
    }
    public function getTotalTestimonialCount(){
        if(!empty($_GET)){
            $total_testimonial_count = $this->testimonial->getTotalTestimonialList();
            echo json_encode($total_testimonial_count);
        }
    }

    // Get first 4 testimonials
    public function getPTA(){
        if(!empty($_GET)){
            $first_testimonial_data = $this->carousel->getCarouselList();
            echo json_encode($first_testimonial_data);
        }
    }
	
}
