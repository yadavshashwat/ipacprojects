<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Viewvotes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Agenda_model', 'agenda');
        $this->load->model('Leaders_model', 'leaders');
        $this->load->model('Register_model', 'register');
        $this->load->model('User_leader_model', 'user_leader');
        $this->load->model('Referral_model', 'referral');
    }

    public function leader()
    {
        $data = array();
        $data['title'] = "Leader Votes";

        $data['disable_vote'] = 0;
        $data['disable_agenda'] = 0;
        $data['disable_register'] = 0;

        if ((isset($_COOKIE['after_register']) && $_COOKIE['after_register'] == 1) || (isset($_COOKIE['step_agenda']) && $_COOKIE['step_agenda'] == "1" && isset($_COOKIE['step_vote']) && $_COOKIE['step_vote'] == "1")) {
            $data['disable_vote'] = 1;
            $data['disable_agenda'] = 1;
            $data['disable_register'] = 0;
        }

        if (isset($_COOKIE['after_result']) && $_COOKIE['after_result'] == 1) {
            $data['disable_vote'] = 1;
            $data['disable_agenda'] = 1;
            $data['disable_register'] = 1;
        }

        $this->load->view('viewleadervotes', $data);
    }

    public function index()
    {
        if(isset($_SESSION['view_votes'])){
            $data = array();
            $data['title'] = "View Leader Votes";

            $data['disable_vote'] = 0;
            $data['disable_agenda'] = 0;
            $data['disable_register'] = 0;

            if ((isset($_COOKIE['after_register']) && $_COOKIE['after_register'] == 1) || (isset($_COOKIE['step_agenda']) && $_COOKIE['step_agenda'] == "1" && isset($_COOKIE['step_vote']) && $_COOKIE['step_vote'] == "1")) {
                $data['disable_vote'] = 1;
                $data['disable_agenda'] = 1;
                $data['disable_register'] = 0;
            }

            if (isset($_COOKIE['after_result']) && $_COOKIE['after_result'] == 1) {
                $data['disable_vote'] = 1;
                $data['disable_agenda'] = 1;
                $data['disable_register'] = 1;
            }

            $this->load->view('viewvotes', $data);
        }else{
            redirect('leader_votes');
        }
    }

    public function filtervotes()
    {
        // print_r($_POST);exit;
        $return = array();
        $search_string = $_POST['search_string'];
        if (!empty($search_string)) {
            $sql_user = "SELECT user_name,registration_number,mobile_number FROM users 
                        WHERE registration_number ='$search_string' OR mobile_number = '$search_string'";

            $query = $this->db->query($sql_user);
            $user_data = $query->row_array();
            if (!empty($user_data)) {
                $this->db->cache_off();
                $sql_votes = "SELECT * FROM (SELECT created_at FROM user_leader_vote WHERE referral_code ='{$user_data["registration_number"]}' UNION ALL SELECT created_at FROM new_leaders  WHERE referral_code ='{$user_data["registration_number"]}') my_vote ORDER BY my_vote.created_at DESC";
                $query_vote = $this->db->query($sql_votes);
                $vote_data = $query_vote->result_array();
                if (!empty($vote_data)) {
	                $this->db->cache_off();
                    $sql_votes_by_date = "SELECT DATE(created_at) AS create_date,count(*) AS no_of_votes FROM (SELECT created_at FROM user_leader_vote WHERE referral_code ='{$user_data["registration_number"]}' UNION ALL SELECT created_at FROM new_leaders  WHERE referral_code ='{$user_data["registration_number"]}') my_vote GROUP BY DATE(my_vote.created_at) ORDER BY my_vote.created_at DESC";
                    $query_vote_by_date = $this->db->query($sql_votes_by_date);
                    $vote_data_by_date = $query_vote_by_date->result_array();
                    $return['status'] = 'success';
                    $return['data'] = $vote_data;
                    $return['data_dates'] = $vote_data_by_date;
                    $return['user_name'] = $user_data['user_name'];
                    $return['referral_link'] = base_url().'referral/'.$user_data['registration_number'];
                    $return['mobile_number'] = $user_data['mobile_number'];
                    $return['total_votes'] = count($vote_data);
                    echo(json_encode($return));
                    exit;
                } else {
                    $return['status'] = 'fail';
                    $return['msg'] = 'No Record Found';
                    echo(json_encode($return));
                    exit;
                }

            } else {
                $return['status'] = 'fail';
                $return['msg'] = 'Invalid Refferal Code or Mobile Number.';
                echo(json_encode($return));
                exit;
            }
        } else {
            $return['status'] = 'fail';
            $return['msg'] = 'Please Enter Refferal Code or Mobile Number.';
            echo(json_encode($return));
            exit;
        }
    }

    public function sendotp_leader_vote()
    {
        $mobile_number = $_POST['mobile_number_nct'];
        if (trim($mobile_number) != '') {
            $this->db->cache_off();
            $sql_nct_user = "SELECT * FROM nct_users WHERE mobile_number ='$mobile_number'";
            $query = $this->db->query($sql_nct_user);
            $nct_user_data = $query->row_array();
            $nct_otp = mt_rand(100000, 999999);
            if (!empty($nct_user_data)) {
                $update_data['otp'] = $nct_otp;
                $update_data['otp_generate_timestamp'] = date("Y-m-d H:i:s");
                $this->db->set($update_data);
                $this->db->where('id', $nct_user_data['id']);
                $update_result = $this->db->update('nct_users');
                if ($update_result) {
                    //Send SMS
                    $message = "Your OTP is " . $update_data['otp'] . " to view leader votes for particular referral or mobile number.";
                    $this->register->send_otp($mobile_number, $message);

                    $return['status'] = 'success';
                    $return['msg'] = "OTP has been sent to your mobile number.";
                    echo(json_encode($return));
                    exit;
                } else {
                    $return['status'] = 'fail';
                    $return['msg'] = "Unauthorized access";
                    echo(json_encode($return));
                    exit;
                }
            } else {
                $return['status'] = 'fail';
                $return['msg'] = "Unauthorized access";
                echo(json_encode($return));
                exit;
            }
        } else {
            $return['status'] = 'fail';
            $return['msg'] = 'Please enter valid mobile number.';
            echo(json_encode($return));
            exit;
        }
    }

    public function verifyotp_leader_vote()
    {
        $mobile_number = $_POST['mobile_number_nct'];
        $otp = $_POST['verify_otp_nct'];
        $this->db->cache_off();
        $sql_nct_user = "SELECT * FROM nct_users WHERE mobile_number ='$mobile_number' AND otp = '$otp'";
        $query = $this->db->query($sql_nct_user);
        $nct_user_data = $query->row_array();
        if (!empty($nct_user_data)) {
            $_SESSION['view_votes'] = 'on';
            $return['status'] = 'success';
            $return['msg'] = 'Your OTP has been verified successfully.';
            echo(json_encode($return));
            exit;
        } else {
            $return['status'] = 'fail';
            $return['msg'] = 'Invalid OTP';
            echo(json_encode($return));
            exit;
        }
    }
}
