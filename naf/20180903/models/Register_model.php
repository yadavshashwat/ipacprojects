<?php
class Register_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function get_all_state(){
        $sql = "SELECT id,name FROM state_master ORDER BY name ASC";
        $query = $this->db->query($sql);        
        $all_state = $query->result_array();        
        return $all_state; 
    }

    public function get_all_district_in_state($state_id){
        $sql = "SELECT d.id,TRIM(d.name) as district_name 
                FROM `district_master` d 
                JOIN state_district sd ON sd.district_id = d.id 
                WHERE sd.state_id = $state_id";
        $query = $this->db->query($sql);        
        $all_districts = $query->result_array();        
        return $all_districts; 
    }

    public function get_all_collages_in_state_district($state_id,$district_id){
        $sql = "SELECT c.id,TRIM(c.name) as collage_name 
                FROM `collages_master` c 
                JOIN state_collage sc ON sc.collage_id = c.id 
                WHERE sc.state_id = $state_id AND sc.district_id = $district_id";
        $query = $this->db->query($sql);        
        $all_districts = $query->result_array();        
        return $all_districts; 
    }

    public function register_user($params,$session_id){
        if(!empty($params)){
            $this->db->cache_off();
            $this->db->insert('users', $params);        
            $user_id = $this->db->insert_id();

            $registration_number = $user_id.time();
            //SET REGISTRATION NUMBER
            $sql = "UPDATE users 
                    SET registration_number = $registration_number 
                    WHERE id = $user_id";            
            $query = $this->db->query($sql);

            //SET USER ID IN user_leader_vote
            $sql = "UPDATE user_leader_vote 
                    SET user_id = $user_id 
                    WHERE session_id = '$session_id'";
            $query = $this->db->query($sql);

            //SET USER ID IN new_leaders
            $sql = "UPDATE new_leaders 
                    SET added_by_user_id = $user_id 
                    WHERE added_by_session_id = '$session_id'";
            $query = $this->db->query($sql);

            //SET USER ID IN new_agenda
            // $sql = "UPDATE new_agenda 
            //         SET added_by_user_id = $user_id 
            //         WHERE added_by_session_id = '$session_id'";
            // $query = $this->db->query($sql);

            //SET USER ID IN user_agenda
            // $sql = "UPDATE user_agenda 
            //         SET user_id = $user_id 
            //         WHERE user_session_id = '$session_id'";
            // $query = $this->db->query($sql);
            
            $_SESSION['user']['id']        = $user_id;
            $_SESSION['user']['is_active'] = 0;

            setcookie("user_id",$user_id,time() + (10 * 365 * 24 * 60 * 60),"/");
            setcookie("user_status","0",time() + (10 * 365 * 24 * 60 * 60),"/");

            return "Y";                     
        }        
    }

    public function send_otp($mobile_number, $message)
    {
        //return true;
        $ch = curl_init();
        $langcookie = 'en';
        if (isset($_COOKIE['language'])) {
            $langcookie = $_COOKIE['language'];
        }
        if($langcookie=="hi"){
            $url = 'https://mobilnxt.in/api/push?accesskey=3kBIkCsnVD7QtLLSKjWNPfA2MleNUP&to=' . $mobile_number . '&text=' . $message . '&from=IPACTM&unicode=1';
        }else{
            $url = 'https://mobilnxt.in/api/push?accesskey=3kBIkCsnVD7QtLLSKjWNPfA2MleNUP&to=' . $mobile_number . '&text=' . $message . '&from=IPACTM';
        }
        $url = str_replace(" ", '%20', $url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $response = curl_exec($ch);
        return $response;
    }

    public function send_IVR($mobile_number){
        //return true;
        $ch = curl_init();
        $langcookie='en';
        if(isset($_COOKIE['language'])){
            $langcookie=$_COOKIE['language'];
        }
        if($langcookie=="hi"){
            $url = 'http://northernitservice.com/services/mobile_database?user_uid=105&mobileno='.$mobile_number;
        }else{
            $url = 'http://northernitservice.com/services/mobile_database?user_uid=104&mobileno='.$mobile_number;
        }

        $url = str_replace(" ", '%20', $url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        return $response;
    }

    public function get_random_number(){
      return mt_rand(100000, 999999);
    }

    public function get_my_assoc_count($user_id,$referral_code){
        $this->db->cache_off();
        $sql = "SELECT COUNT(id) as total_in_vote 
                FROM user_leader_vote 
                WHERE referral_code = '".$referral_code."' AND referral_owner_id = '".$user_id."'";
        $query = $this->db->query($sql);
        $count1 = $query->row_array();   


        $sql = "SELECT COUNT(id) as total_in_new 
                FROM new_leaders 
                WHERE referral_code = '".$referral_code."' AND referral_owner_id = '".$user_id."'";
        $query = $this->db->query($sql);
        $count2 = $query->row_array();    

        $total = 0;
        $total = $count1['total_in_vote'] + $count2['total_in_new'];
        return $total;
    }

    public function getTotalRegisterUser(){
        $sql = "SELECT COUNT(id) as total_user FROM users WHERE is_active = 1";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result['total_user'];
    }
}
?>