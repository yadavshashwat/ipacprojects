<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('KPI_model','kpi');
		$this->load->model('Trending_model','trending');
        $this->load->model('Agenda_model','agenda');
        $this->load->model('Leaders_model','leaders');
        $this->load->model('Register_model','register');
        $this->load->model('User_leader_model','user_leader');
        $this->load->model('Referral_model','referral');
        $this->load->model('Carousel_model','carousel');
		$this->load->model('Testimonial_model','testimonial');
        $this->load->model('Partner_model','partner');
        //$this->load->model('Banner_model','banner');
        $this->load->model('News_model','news');

        //$this->unset_user_cookie();

        // if(isset($_COOKIE['on_step'])){
        //     if($_COOKIE['on_step'] == '1' || $_COOKIE['on_step'] == '2'){
        //         //setcookie("on_step","0",time() + (10 * 365 * 24 * 60 * 60),"/");
        //         $_SESSION['user']['on_step'] = 0;

        //         if(isset($_COOKIE['user_session_id']) && !empty($_COOKIE['user_session_id'])){
        //             $session_id = $_COOKIE['user_session_id'];
        //             // $status     = $this->checkIsVoted($session_id);
        //             // if($status == "Y"){
        //             //     $this->user_leader->removeVote($session_id);
        //             // }
        //         }
        //     }else if($_COOKIE['on_step'] == '3'){
        //         //redirect('register');
        //         if(isset($_COOKIE['after_register']) && $_COOKIE['after_register'] == 1){
        //             //setcookie("on_step","0",time() + (10 * 365 * 24 * 60 * 60),"/");
        //             //$_SESSION['user']['on_step'] = 0;
        //         }else{
        //             redirect('register');
        //         }

        //     }else if($_COOKIE['on_step'] == '4'){
        //         if(isset($_COOKIE['after_result']) && $_COOKIE['after_result'] == 1){
        //             //setcookie("on_step","0",time() + (10 * 365 * 24 * 60 * 60),"/");
        //             //$_SESSION['user']['on_step'] = 0;
        //             $_SESSION['user']['log_in'] = 0;
        //             setcookie("log_in","1",time() + (10 * 365 * 24 * 60 * 60),"/");
        //         }else{
        //             redirect('result');
        //         }
        //     }
        // }else{
        //     //setcookie("on_step","0",time() + time() + (10 * 365 * 24 * 60 * 60),"/");
        //     //$_SESSION['user']['on_step'] = 0;
        // }
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
        $data['disable_register_new'] = 0;
        if(isset($_COOKIE['register_complete']) && $_COOKIE['register_complete'] == 1){
            $data['disable_register_new'] = 1;
        }
        if((isset($_COOKIE['step_agenda']) && $_COOKIE['step_agenda'] == "1" && isset($_COOKIE['step_vote']) && $_COOKIE['step_vote'] == "1")) {
            $data['disable_vote'] = 1;
            $data['disable_agenda'] = 1;
            $data['disable_register'] = 0;
        }

        // if(isset($_COOKIE['after_result']) && $_COOKIE['after_result'] == 1){
        //     $data['disable_vote'] = 1;
        //     $data['disable_agenda'] = 1;
        //     $data['disable_register'] = 1;
        // }
        $data['top_ten_agendas']  = $this->agenda->get_ten_top_agenda();
		$data['get_top_four_top_agenda']  = $this->agenda->get_top_four_top_agenda();
		$data['get_rest_six_top_agenda']  = $this->agenda->get_rest_six_top_agenda();
		$data['total_agenda_vote']  = $this->agenda->get_total_agenda_vote();
		$data['total_votes']  = $this->leaders->get_total_vote();
        $data['top_six_leaders']  = $this->leaders->get_top_six_leaders();
        $data['total_agenda_voted_count'] = $this->agenda->getTotalUserSetAgenda();
        $data['total_leader_voted_count'] = $this->leaders->getTotalUserSetAgenda();
        $data['total_register_user'] = $this->register->getTotalRegisterUser();  
        $data['total'] = $data['total_agenda_voted_count'] + $data['total_leader_voted_count'] + $data['total_register_user'];
		
		$data['carousel_list']  = $this->carousel->getCarouselList();
		//$data['testimonial_list']  = $this->testimonial->getTestimonialList();


		/****** START TO GET Organization  AND Influencers AND Associates DATA BY BHAVIK  *****/

        $data['Influencers_testimonial']   = $this->testimonial->getTestimonialListPriority();
        $data['Organization_partner']      = $this->partner->getPartnerListPriority();
        $data['Associates_pta_randomiser'] = $this->carousel->getPtarandomiserPriority();



        /*** END TO GET Organization  AND Influencers AND Associates DATA BY BHAVIK ***/




        //$data['partner_list']  = $this->partner->getPartnerList();
        //$data['banner_list']  = $this->banner->getBannerList();
		$data['news']  = $this->news->getNewsList();

		$data['testi_count'] = $this->kpi->getInflu();
        $data['part_count'] = $this->kpi->getOrgi();
        $data['asso_count'] = $this->kpi->getAsso();
        $data['college_count'] = $this->kpi->getColleges();
        $data['nomi_agenda_count'] = $this->kpi->getNomiAgendas();
        $data['nomi_leader_count'] = $this->kpi->getNomiLeaders();
        /** PAGE VIEWS UPDATE LOGIC BY VICTOR AND PRADIP */
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $page = 'https://www.indianpac.com/naf';
        $insertview = $this->db->query("insert into pageview values('','$page','$user_ip')");
        $updateview = $this->db->query("update totalview set totalvisit = totalvisit+1 where page='$page' ");
        $this->db->cache_off();
        $sql = "SELECT * from totalview";
        $query = $this->db->query($sql);
        $result =  $query->row_array();
        $data['people_hits'] = $result;
        /** PAGE VIEWS UPDATE LOGIC BY VICTOR AND PRADIP */

        $data['referral_owner_id'] = 0;
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
                $data['disable_register_new'] = 0;
                if(isset($_COOKIE['register_complete']) && $_COOKIE['register_complete'] == 1){
                    $data['disable_register_new'] = 1;
                }
                if((isset($_COOKIE['step_agenda']) && $_COOKIE['step_agenda'] == "1" && isset($_COOKIE['step_vote']) && $_COOKIE['step_vote'] == "1")) {
                    $data['disable_vote'] = 1;
                    $data['disable_agenda'] = 1;
                    $data['disable_register'] = 0;
                }


                // if((isset($_COOKIE['after_register']) && $_COOKIE['after_register'] == 1) || (isset($_COOKIE['step_agenda']) && $_COOKIE['step_agenda'] == "1" && isset($_COOKIE['step_vote']) && $_COOKIE['step_vote'] == "1")) {
                //     $data['disable_vote']     = 1;
                //     $data['disable_agenda']   = 1;
                //     $data['disable_register'] = 0;
                // }

                if(isset($_COOKIE['after_result']) && $_COOKIE['after_result'] == 1){
                    $data['disable_vote']     = 1;
                    $data['disable_agenda']   = 1;
                    $data['disable_register'] = 1;
                }

                
                $data['title']              = "Home - Referral";
				$data['top_ten_agendas']  = $this->agenda->get_ten_top_agenda();
				$data['get_top_four_top_agenda']  = $this->agenda->get_top_four_top_agenda();
				$data['get_rest_six_top_agenda']  = $this->agenda->get_rest_six_top_agenda();
				$data['total_agenda_vote']  = $this->agenda->get_total_agenda_vote();
				$data['total_votes']  = $this->leaders->get_total_vote();
				$data['top_six_leaders']  = $this->leaders->get_top_six_leaders();
                $data['total_agenda_voted_count'] = $this->agenda->getTotalUserSetAgenda();
                $data['total_leader_voted_count'] = $this->leaders->getTotalUserSetAgenda();
                $data['total_register_user'] = $this->register->getTotalRegisterUser();   
                $data['total'] = $data['total_agenda_voted_count'] + $data['total_leader_voted_count'] + $data['total_register_user'];            
                //echo '<pre>';print_r($data);exit;               
                $data['carousel_list']  = $this->carousel->getCarouselList();
				//$data['testimonial_list']  = $this->testimonial->getTestimonialList();
                //$data['partner_list']  = $this->partner->getPartnerList();
                //$data['banner_list']  = $this->banner->getBannerList();
				$data['news']  = $this->news->getNewsList();
                /*** START TO GET Organization  AND Influencers AND Associates DATA BY BHAVIK ***/

                $data['Influencers_testimonial']   = $this->testimonial->getTestimonialListPriority();
                $data['Organization_partner']      = $this->partner->getPartnerListPriority();
                $data['Associates_pta_randomiser'] = $this->carousel->getPtarandomiserPriority();

                /*** END TO GET Organization  AND Influencers AND Associates DATA BY BHAVIK ***/
                $data['testi_count'] = $this->kpi->getInflu();
                $data['part_count'] = $this->kpi->getOrgi();
                $data['asso_count'] = $this->kpi->getAsso();
                $data['college_count'] = $this->kpi->getColleges();
                $data['nomi_agenda_count'] = $this->kpi->getNomiAgendas();
                $data['nomi_leader_count'] = $this->kpi->getNomiLeaders();
                /** PAGE VIEWS UPDATE LOGIC BY VICTOR AND PRADIP */
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $page = 'https://www.indianpac.com/naf';
                $insertview = $this->db->query("insert into pageview values('','$page','$user_ip')");
                $updateview = $this->db->query("update totalview set totalvisit = totalvisit+1 where page='$page' ");
                $this->db->cache_off();
                $sql = "SELECT * from totalview";
                $query = $this->db->query($sql);
                $result =  $query->row_array();
                $data['people_hits'] = $result;
                /** PAGE VIEWS UPDATE LOGIC BY VICTOR AND PRADIP */
                $data['referral_owner_id'] = $referral_detail['id'];
				$this->load->view('home',$data);
            }else{
                redirect('/');
            }
        }else{
            redirect('/');
        }
    }  

    public function check_user(){
        $return = array();  
        //echo '<pre>';
        if(!empty($_POST)){
            $mobile_number = $this->input->post('pta_mobile_number');
			
                //$user_id = $_COOKIE['user_id'];
                $sql = "SELECT id,otp,otp_generate_timestamp 
                        FROM users 
                        WHERE mobile_number = '$mobile_number'";
                $query = $this->db->query($sql);
                $user_details = $query->row_array();
	//			print_r ($user_details);
	//			echo "Jai Mata Di";
		//		echo $user_details['id'];
			
	$uid_data=$user_details['id'];
			
			
			
            //$this->db->where(array("mobile_number" => $mobile_number, "is_active" => 1));
            //$user_details = $this->db->get('users')->row();

            if(!empty($user_details)){
                //update the OTP and send success message...
                $update_data['otp'] = $this->register->get_random_number();
                $update_data['otp_generate_timestamp'] = date("Y-m-d H:i:s");

                $this->db->set($update_data);
				
                //$this->db->where('id', $user_details->id);
                $this->db->where('id', $uid_data);
                
				$update_result = $this->db->update('users');

                if($update_result){
                    //Send SMS
                    $message = "Your OTP is ".$update_data['otp']." to view results of leader poll on National Agenda Forum (NAF).";
                    $this->register->send_otp($mobile_number, $message);

                    //$_SESSION['user']['id'] = $user_details->id;
					
                    $_SESSION['user']['id'] = $uid_data;
                    $_SESSION['user']['is_active'] = 0;  
					               

 //                   setcookie("user_id",$user_details->id,time() + (10 * 365 * 24 * 60 * 60),"/");
 
                    setcookie("user_id",$uid_data,time() + (10 * 365 * 24 * 60 * 60),"/"); 
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
            if(isset($_COOKIE['user_id'])){
			
                $user_id  = $_COOKIE['user_id'];           
				$QUERY = "SELECT * FROM users WHERE id='".$user_id."' AND otp='".$user_otp."'";
				$query = $this->db->query($QUERY);
				$user_details = $query->result();
                //$user_details = $this->db->get('users')->get();
				//print_r($user_details);exit;
                //dump($user_details);die;
				
                if(!empty($user_details)){
				
                   // if($user_otp == $user_details[0]->otp ){
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
                  //  }else{
                     //   $return['status'] = 'fail';
                      //  $return['msg'] = "Invalid OTP.";                 
                      //  echo(json_encode($return));exit;
                   // }
                }else{
                    $return['status'] = 'fail';
					$return['msg'] = "Invalid OTP.";    
                   // $return['msg'] = "Invalid User Details.";                 
                    echo(json_encode($return));exit;
                }

            }else{
                $return['status'] = 'fail';
                $return['msg'] = "Invalid OTP request.";                 
                echo(json_encode($return));exit;
            }
        }else{
            $return['status'] = 'fail';
            $return['msg'] = "Unable to process request.";                 
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
	
	// Get first 4 partners
	public function getPartners(){
        if(!empty($_GET)){
            $first_partner_data = $this->partner->getFirstPartners();
            echo json_encode($first_partner_data);
        }
    }
	
	public function getTrendings(){
        if(!empty($_GET)){
            $first_trending_data = $this->trending->getFirstTrendings();
            echo json_encode($first_trending_data);
        }
    }
	
	public function next_partners(){
        if(!empty($_POST)){
            $item_count = $this->input->post('item_count');
            $next_partner = $this->partner->getPartnerList($item_count);
            echo json_encode($next_partner);
        }
    }
	
	public function getTotalPartnerCount(){
        if(!empty($_GET)){
            $total_partner_count = $this->partner->getTotalPartnerList();
            echo json_encode($total_partner_count);
        }
    }
	
	public function getTotalTrendingCount(){
        if(!empty($_GET)){
            $total_trending_count = $this->trending->getTotalTrendingList();
            echo json_encode($total_trending_count);
        }
    }
	
	

    // Get first 4 testimonials
    public function getPTA(){
        if(!empty($_GET)){
            $first_testimonial_data = $this->carousel->getCarouselList();
            echo json_encode($first_testimonial_data);
        }
    }

    public function get_resolution(){
        $return = array();
        if(isset($_POST['width']) && isset($_POST['height'])) {
            $width = $_POST['width']+0;

            if($width < 375){
                $query = $this->db->query('SELECT * FROM banner_table WHERE banner_width = 375');
            }elseif ($width < 800 && $width >= 375){
                $query = $this->db->query('SELECT * FROM banner_table WHERE banner_width >= 375 AND banner_width < 800');
            }elseif($width < 1280 && $width >= 800){
                $query = $this->db->query('SELECT * FROM banner_table WHERE banner_width >= 800 AND banner_width < 1280');
            }elseif($width < 1680 && $width >= 1280){
                $query = $this->db->query('SELECT * FROM banner_table WHERE banner_width >= 1280 AND banner_width < 1680');
            }elseif($width < 1920 && $width >= 1680){
                $query = $this->db->query('SELECT * FROM banner_table WHERE banner_width >= 1680 AND banner_width < 1920');
            }elseif($width >= 1920){
                $query = $this->db->query('SELECT * FROM banner_table WHERE banner_width >= 1920');
            }
            echo json_encode(array(
                'outcome'=>'success',
                'data' => $query->result()
            ));
        } else {
            echo json_encode(array('outcome'=>'error','error'=>"Couldn't save dimension info"));
        }
    }

    public function influencers(){
        $data = array();
        $data['title'] = "Influencers";
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

        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = base_url() . "home/influencers";
        $total_row = $this->testimonial->record_count();
        $config['num_links'] = 3;
        $config["total_rows"] = $total_row;
        $config["per_page"] = 12;


        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';



        $config['prev_link'] = 'Previous Page';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';


        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';


        $this->pagination->initialize($config);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["Influencers_testimonial"] = $this->testimonial->getInfluencers($config["per_page"], $start_index);

       // print_r($data);exit;
        $this->load->view('influencers',$data);
    }

    public function organizations(){
        $data = array();
        $data['title'] = "Organizations";
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

        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = base_url() . "home/organizations";
        $total_row = $this->partner->record_count();
        $config['num_links'] = 3;
        $config["total_rows"] = $total_row;
        $config["per_page"] = 12;


        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';



        $config['prev_link'] = 'Previous Page';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';


        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';


        $this->pagination->initialize($config);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['Organization_partner']  = $this->partner->getPartners($config["per_page"], $start_index);
        $this->load->view('organisations',$data);
    }
    
public function associates(){
        $data = array();
        $data['title'] = "Associates";
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

        $this->load->library('pagination');

        $config = array();
        $config["base_url"] = base_url() . "home/associates";
        $total_row = $this->carousel->record_count();
        $config['num_links'] = 3;
        $config["total_rows"] = $total_row;
        $config["per_page"] = 50;

        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = 'Previous Page';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $users = $this->carousel->getAssociates($config["per_page"], $start_index);
        $count_array = count($users);
        for ($i = 0; $i < $count_array; $i++) {
            if (isset($users[$i])) {
                for ($j = $i+1; $j < $count_array; $j++) {
                    if (isset($users[$j])) {
                        //this is where you do your comparison for dupes
                        if ($users[$i]->user_name == $users[$j]->user_name) {
                            unset($users[$j]);
                        }
                    }
                }
            }
        }
        $data['Associates_pta_randomiser'] = $users;
        $this->load->view('associates',$data);
    }


    function search_associates()
    {
        $data = array();
        $data['title'] = "Associates";
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

        // get search string
        $search = ($this->input->post("search_string"))? $this->input->post("search_string") : "NIL";
        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        $this->load->library('pagination');

        // pagination settings
        $config = array();
        $config['base_url'] = site_url("home/search_associates/$search");
        $total_row = $this->carousel->get_users_count($search);
        $config['num_links'] = 3;
        $config["total_rows"] = $total_row;
        $config["per_page"] = $total_row;
        $config["uri_segment"] = 4;
       
        // integrate bootstrap pagination
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = 'Previous Page';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = 'Next Page';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $users = $this->carousel->get_users_search($config['per_page'], $data['page'], $search);
        $count_array = count($users);
        for ($i = 0; $i < $count_array; $i++) {
            if (isset($users[$i])) {
                for ($j = $i+1; $j < $count_array; $j++) {
                    if (isset($users[$j])) {
                        //this is where you do your comparison for dupes
                        if ($users[$i]->user_name == $users[$j]->user_name) {
                            unset($users[$j]);
                        }
                    }
                }
            }
        }
        $data['Associates_pta_randomiser'] = $users;
        //Load view
        $this->load->view('associates',$data);
    }
	
	public function staterefferal(){
		$url = $this->uri->segment(1);
		switch ($url){
			case 'br': redirect('referral/211601532067899');break;
			case 'gj': redirect('referral/338851533209963');break;
            case 'gj2': redirect('referral/212121532073565');break;
            case 'upe1': redirect('referral/170891531226020');break;
            case 'upc2': redirect('referral/211091532005211');break;
            case 'upw3': redirect('referral/211971532071837');break;
            case 'ncr1': redirect('referral/127321531225824');break;
            case 'ncr2': redirect('referral/561281533562899');break;
            case 'pb1': redirect('referral/211391532038686');break;
            case 'ka1': redirect('referral/644901533827810');break;
            case 'ka2': redirect('referral/16541531225374');break;
            case 'kl1': redirect('referral/211021532004243');break;
            case 'ts1': redirect('referral/645661533829560');break;
            case 'tn1': redirect('referral/215381532144586');break;
            case 'tn2': redirect('referral/157841531225966');break;
            case 'rj1': redirect('referral/15851531225372');break;
            case 'mh1': redirect('referral/156191531225960');break;
            case 'mh2': redirect('referral/230121532337425');break;
            case 'mh3': redirect('referral/324881533186542');break;
            case 'ne1': redirect('referral/213381532088235');break;
            case 'cg1': redirect('referral/230971532353580');break;
            case 'mp2': redirect('referral/258271532497534');break;
            case 'mp1': redirect('referral/194651531226113');break;
            case 'jh1': redirect('referral/315541533118230');break;
            case 'od1': redirect('referral/156181531225960');break;
            case 'od2': redirect('referral/377501533288179');break;
            case 'wb1': redirect('referral/646661533833868');break;
            case 'jh2': redirect('referral/646461533832736');break;

            case 'shuats': redirect('referral/213891532094259');break;
            case 'rj2': redirect('referral/157381531225964');break;
            case 'pradip': redirect('referral/731021534076245');break;


			default: redirect('/');
		}
	}

    public function leader_board_details(){
        // print_r($_GET);exit;
        $return = array();
        if(!empty($_GET)){
            // echo 'backend check'; exit;
            $this->db->cache_off();
            // performant query to show leader board
            // beware sql code below
            $sql_referral_rank_data = "SELECT t_final.name,t_final.picture,t_final.college, t_final.t_votes, t_final.t_rank, y_final.y_votes, y_final.y_rank  
FROM (SELECT
    user_name AS NAME,
    collage_name AS college,
    registration_number AS referral,
    profile_pic as picture,
    IF(
        @score = s.total_ref_vote,
        @rank := @rank,
        @rank := @rank +1
    ) AS t_rank,
    @score := s.total_ref_vote t_votes
FROM
    users s,
    (
SELECT
    @score := 0,
    @rank := 0
) t_r
where ref_leader_vote = 1
ORDER BY
    total_ref_vote
DESC
LIMIT 25) t_final
LEFT JOIN (SELECT
    user_name AS NAME,
    collage_name AS college,
    registration_number AS referral,
    IF(
        @y_score = s.ytotal_ref_vote,
        @y_rank := @y_rank,
        @y_rank := @y_rank +1
    ) AS y_rank,
    @y_score := s.ytotal_ref_vote y_votes
FROM
    users s,
    (
SELECT
    @y_score := 0,
    @y_rank := 0
) y_r
where ref_leader_vote = 1
ORDER BY
    ytotal_ref_vote
DESC
LIMIT 25) y_final 
ON t_final.referral = y_final.referral";
            $query = $this->db->query($sql_referral_rank_data);
            $leader_board = $query->result_array();
            $return['status'] = 'success';
            $return['data'] = $leader_board;
            echo json_encode($return);exit;
        }else{
            $return['status'] = 'fail';
            echo json_encode($return);exit;
        }
    }

    /**
     * @author victor
     * @method array_random
     * @param $arr
     * @param $num = 1
     */
    public function array_random($arr, $num = 1){
        // just like playing cards :)
        shuffle($arr);

        $r = array();
        for($i=0; $i < $num; $i++){
            $r[] = $arr[$i];
        }
        return $num == 1 ? $r[0] : $r;
    }

    public function random_testimonials(){
        $return = array();
        if(!empty($_GET)){
            $sql_testimonials = "SELECT author, designation, testimonial, author_image FROM `influencers_2nd` WHERE is_active = '1'";
            $query_testimonials = $this->db->query($sql_testimonials);
            $active_testimonails = $query_testimonials->result_array();
            // Randomly pick only 18 from them
            $random_18_testimonials = $this->array_random($active_testimonails,18);
            // print_r($random_18_testimonials);exit;
            $return['status'] = 'success';
            $return['data'] = $random_18_testimonials;
            echo json_encode($return);exit;
        }else{
            $return['status'] = 'fail';
            echo json_encode($return);exit;
        }
    }

    public function random_partners(){
        $return = array();
        if(!empty($_GET)){
            $sql_partners = "SELECT partner_image_name, bio, partner_name FROM `partner_02` WHERE is_active = '1'";
            $query_partners = $this->db->query($sql_partners);
            $active_partners = $query_partners->result_array();
            // Randomly pick only 18 from them
            $random_18_partners = $this->array_random($active_partners,18);
            // print_r($random_18_testimonials);exit;
            $return['status'] = 'success';
            $return['data'] = $random_18_partners;
            echo json_encode($return);exit;
        }else{
            $return['status'] = 'fail';
            echo json_encode($return);exit;
        }
    }

    public function random_college(){
        $return = array();
        if(!empty($_GET)){
            $sql_colleges = "SELECT * FROM colleges_2nd WHERE is_active='1'";
            $query_colleges = $this->db->query($sql_colleges);
            $active_colleges = $query_colleges->result_array();
            // Randomly pick only 18 from them
            $random_18_colleges = $this->array_random($active_colleges,18);
            // print_r($random_18_testimonials);exit;
            $return['status'] = 'success';
            $return['data'] = $random_18_colleges;
            echo json_encode($return);exit;
        }else{
            $return['status'] = 'fail';
            echo json_encode($return);exit;
        }
    }

    // public function random_youth_driving(){
    //     $return = array();
    //     if(!empty($_GET)){
    //         $sql_youth = "SELECT t_final.name,t_final.picture,t_final.college, t_final.t_votes, t_final.t_rank, y_final.y_votes, y_final.y_rank  
    //         FROM (SELECT
    //             user_name AS NAME,
    //             collage_name AS college,
    //             registration_number AS referral,
    //             profile_pic as picture,
    //             IF(
    //                 @score = s.total_ref_vote,
    //                 @rank := @rank,
    //                 @rank := @rank +1
    //             ) AS t_rank,
    //             @score := s.total_ref_vote t_votes
    //         FROM
    //             users s,
    //             (
    //         SELECT
    //             @score := 0,
    //             @rank := 0
    //         ) t_r
    //         where ref_leader_vote = 1
    //         ORDER BY
    //             total_ref_vote
    //         DESC
    //         LIMIT 25) t_final
    //         LEFT JOIN (SELECT
    //             user_name AS NAME,
    //             collage_name AS college,
    //             registration_number AS referral,
    //             IF(
    //                 @y_score = s.ytotal_ref_vote,
    //                 @y_rank := @y_rank,
    //                 @y_rank := @y_rank +1
    //             ) AS y_rank,
    //             @y_score := s.ytotal_ref_vote y_votes
    //         FROM
    //             users s,
    //             (
    //         SELECT
    //             @y_score := 0,
    //             @y_rank := 0
    //         ) y_r
    //         where ref_leader_vote = 1
    //         ORDER BY
    //             ytotal_ref_vote
    //         DESC
    //         LIMIT 25) y_final 
    //         ON t_final.referral = y_final.referral";
    //         $query_youth = $this->db->query($sql_youth);
    //         $active_youth = $query_youth->result_array();
    //         // Randomly pick only 18 from them
    //         $random_18_youth = $this->array_random($active_youth,18);
    //         // print_r($random_18_testimonials);exit;
    //         $return['status'] = 'success';
    //         $return['data'] = $random_18_youth;
    //         echo json_encode($return);exit;
    //     }else{
    //         $return['status'] = 'fail';
    //         echo json_encode($return);exit;
    //     }
    // }

    public function random_youth_driving(){
        $return = array();
        if(!empty($_GET)){
            $sql_youth = "SELECT image_id, name FROM pta_randomiser WHERE is_active = '1'";
            $query_youth = $this->db->query($sql_youth);
            $active_youth = $query_youth->result_array();
            // Randomly pick only 18 from them
            $random_18_youth = $this->array_random($active_youth,18);
            // print_r($random_18_testimonials);exit;
            $return['status'] = 'success';
            $return['data'] = $random_18_youth;
            echo json_encode($return);exit;
        }else{
            $return['status'] = 'fail';
            echo json_encode($return);exit;
        }
    }

    // public function random_youth_driving(){
    //     $return = array();
    //     // if(!empty($_GET)){
    //         $sql_pta = "SELECT image_id, name FROM `pta_randomiser` WHERE is_active = '1' ORDER BY RAND() limit 8";
    //         $query_pta = $this->db->query($sql_pta);
    //         $active_pta = $query_pta->result_array();
    //         $return['status'] = 'success';
    //         $return['data'] = $active_pta;
    //         echo json_encode($return);exit;
    //     // }else{
    //     //     $return['status'] = 'fail';
    //     //     echo json_encode($return);exit;
    //     // }
    // }


    public function random_news(){
        $return = array();
        // if(!empty($_GET)){
            $sql_news = "SELECT news_link, news_img_name FROM `news_2nd` WHERE active = '1' ORDER BY RAND() limit 8";
            $query_news = $this->db->query($sql_news);
            $active_news = $query_news->result_array();
            $return['status'] = 'success';
            $return['data'] = $active_news;
            echo json_encode($return);exit;
        // }else{
        //     $return['status'] = 'fail';
        //     echo json_encode($return);exit;
        // }
    }
	
	public function home_agenda_leader(){/*
		if(!empty($_POST["state"])){

  echo $_POST["state"];
  $state=$_POST["state"];;
  echo "</br>";
  echo $_COOKIE['ag_ki'];
//  $_POST['state']=
//$_COOKIE['state']="ghghgh";
$cookie_name = "state";
$cookie_value = $_POST["state"];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day


$sql11="SELECT `LEADER`,sum(`AGENDA_VOTES`) as tv FROM `naf_state_dashboard` WHERE `AGENDA`='Kisans' and `STATE`='$state' group by `LEADER` order by tv desc LIMIT 0,5";

$result11=$this->db->query($sql11);
	    $rem11=0;
	    $csum11=0;
		$result111 = $result11->result_array();
		foreach ($result111 as $key4 => $value4) {
	    

	    	$sql21="SELECT sum(`AGENDA_VOTES`) as total FROM `naf_state_dashboard` WHERE `AGENDA`='Kisans' and `STATE`='$state'";
	    	$result21=$this->db->query($sql21);
			$result211 = $result21->result_array();
			foreach ($result211 as $key4 => $row21) {


	        	$sum11=$row21['total'];

	        }


	        echo $value4['LEADER'];
	    	echo "&nbsp";
	    	echo "&nbsp";
	    	echo "&nbsp";

	    	
	    	$lv11=$value4['tv'];
	    	echo $value4['tv'];

	    	$per11=round(($lv11/$sum11)*100,2);
	    	echo "&nbsp";
	    	echo "&nbsp";
	    	echo "&nbsp";


	    	echo $per11;
	    	echo "</br>";
	    	$csum11=$csum11+$value4['tv'];

	    }
echo "Others";
$otc11=$sum11-$csum11;
$otcp11=round(($otc11/$sum11)*100,2);

echo $otc11;
echo "&nbsp";
echo "&nbsp";
echo "&nbsp";

echo $otcp11;
}
	*/}


}
