<?php
class Agenda_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getGandhiAgendaList(){
        $sql = "SELECT id,agenda_name,agenda_name_hindi,agenda_topic,agenda_topic_hindi 
                FROM agenda_master 
                WHERE is_active = 1 AND type_id = 2 
                ORDER BY rand()";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    public function getAgendaList(){
        $sql = "SELECT id,agenda_name,agenda_name_hindi,agenda_topic,agenda_topic_hindi 
                FROM agenda_master 
                WHERE is_active = 1 AND type_id = 1 
                ORDER BY rand() 
                LIMIT 10";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    public function addNewAgenda($params){
    	if(!empty($params)){

            $condition = "";
            if($params['user_id'] != 0){
                $condition = "added_by_user_id = ".$params['user_id'];
            }else{
                $condition = "added_by_session_id = '{$params['session_id']}'";
            }

            /*$sql = "DELETE FROM new_agenda WHERE $condition";
            $query = $this->db->query($sql);*/

            $data = array();
            $data['agenda_name']         = $params['new_agenda'];
            $data['added_by_session_id'] = $params['session_id'];
            $data['added_by_user_id']    = $params['user_id'];
            $data['referral_code']       = $params['referral_code'];
            $data['referral_owner_id']   = $params['referral_owner_id'];
            $data['created_at']          = $params['created_at'];
            $data['modified_at']         = $params['modified_at'];            
            $this->db->insert('new_agenda', $data);
    	}
    }


    public function addNewAgendaapi($params){
        if(!empty($params)){

            $condition = "";
            if($params['user_id'] != 0){
                $condition = "added_by_user_id = ".$params['user_id'];
            }else{
                $condition = "added_by_session_id = '{$params['session_id']}'";
            }

            /*$sql = "DELETE FROM new_agenda WHERE $condition";
            $query = $this->db->query($sql);*/

            $data = array();
            $data['agenda_name']         = $params['new_agenda'];
            $data['added_by_session_id'] = $params['session_id'];
            $data['added_by_user_id']    = $params['user_id'];
            $data['referral_code']       = $params['referral_code'];
            $data['referral_owner_id']   = $params['referral_owner_id'];
            $data['created_at']          = $params['created_at'];
            $data['modified_at']         = $params['modified_at'];            
            $this->db->insert('new_agenda_api', $data);
        }
    }


    public function addUserAgenda($params){
    	if(!empty($params)){
            $this->db->trans_start();
            if(isset($params['new_agenda']) && $params['new_agenda']!=''){
                $this->addNewAgenda($params);
            }            

            $condition = "";
            if($params['user_id'] != 0){
                $condition = "user_id = ".$params['user_id'];
            }else{
                $condition = "user_session_id = '{$params['session_id']}'";
            }

            /*$sql = "DELETE FROM user_agenda WHERE $condition";
            $query = $this->db->query($sql);*/

            if(!empty($params['agenda_name'])){
                foreach ($params['agenda_name'] as $key => $value) {
                    $data = array();
                    $data['user_session_id']     = $params['session_id'];
                    $data['user_id']             = $params['user_id'];
                    $data['agenda_id']           = $value;
                    $data['user_ip']             = $params['user_ip'];
                    $data['user_tracting_detail'] = $params['user_tracting_detail'];
                    $data['referral_code']       = $params['referral_code'];
                    $data['referral_owner_id']   = $params['referral_owner_id'];
                    $data['created_at']          = $params['created_at'];
                    $data['modified_at']         = $params['modified_at'];            
                    $this->db->insert('user_agenda', $data);
					$sql = "UPDATE agenda_master 
                    SET total_vote = total_vote + 1 
                    WHERE id = {$value}";
            		$query = $this->db->query($sql);
                }
            }

            
            if ($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                return "Y";
            }else{
                return "N";
            } 
    	}else{
    		return "N";
    	}
    }

    public function postAgenda($params){
        /** PAGE VIEWS UPDATE LOGIC BY VICTOR AND PRADIP */
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $page = 'https://www.indianpac.com/staging/agenda/';
        $insertview = $this->db->query("insert into pageview values('','$page','$user_ip')");
        $updateview = $this->db->query("update totalview set totalvisit = totalvisit+1 where page='$page' ");
        if(!empty($params)){
            $this->db->trans_start();
            if(isset($params['new_agenda']) && $params['new_agenda']!=''){
                $this->addNewAgendaapi($params);
            }            

            $condition = "";
            if($params['user_id'] != 0){
                $condition = "user_id = ".$params['user_id'];
            }else{
                $condition = "user_session_id = '{$params['session_id']}'";
            }

            /*$sql = "DELETE FROM user_agenda WHERE $condition";
            $query = $this->db->query($sql);*/

            if(!empty($params['agenda_id'])){
                
                    $data = array();
                    $data['user_session_id']     = $params['session_id'];
                    $data['user_id']             = $params['user_id'];
                    $data['agenda_id']           = $params['agenda_id'];
                    $data['user_ip']             = $params['user_ip'];
                    $data['user_tracting_detail'] = $params['user_tracting_detail'];
                    $data['referral_code']       = $params['referral_code'];
                    $data['referral_owner_id']   = $params['referral_owner_id'];
                    $data['created_at']          = $params['created_at'];
                    $data['modified_at']         = $params['modified_at'];            
                    $this->db->insert('user_agenda_api', $data);
               $sql = "UPDATE agenda_master 
                    SET total_vote = total_vote + 1, total_vote_api = total_vote_api + 1 
                    WHERE id =".$params['agenda_id'];
            $query = $this->db->query($sql);
            }

            
            if ($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                return "Y";
            }else{
                return "N";
            } 
        }else{
            return "N";
        }
    }

    public function get_top_agenda(){
		//$this->db->cache_off();
        /*$sql = "SELECT a.id,a.agenda_name,a.agenda_topic, a.agenda_topic_hindi,COUNT(ua.id) as total_vote
                FROM `user_agenda` ua 
                RIGHT JOIN agenda_master a ON ua.agenda_id = a.id AND a.is_active = 1
                GROUP by a.id 
                ORDER BY total_vote DESC ";*/
		/*$sql = "SELECT a.id,a.agenda_name,a.agenda_name_hindi,a.agenda_topic, a.agenda_topic_hindi,count(m.agenda_id) as total_vote from (SELECT * FROM `user_agenda` UNION ALL SELECT * FROM `user_agenda_api`) m RIGHT JOIN agenda_master a ON m.agenda_id = a.id GROUP by m.agenda_id order by total_vote desc";*/
		$sql = "SELECT id,agenda_name,agenda_name_hindi,agenda_topic,agenda_topic_hindi,total_vote 
                FROM agenda_master 
                WHERE is_active = 1 
                ORDER BY total_vote DESC";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }
	
	public function get_ten_top_agenda(){
		$sql = "SELECT id,agenda_name,agenda_name_hindi,agenda_topic,agenda_topic_hindi,total_vote 
                FROM agenda_master 
                WHERE is_active = 1 
                ORDER BY total_vote DESC LIMIT 10";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }
	
	public function get_top_four_top_agenda(){
		$sql = "SELECT id,agenda_name,agenda_name_hindi,agenda_topic,agenda_topic_hindi,total_vote 
                FROM agenda_master 
                WHERE is_active = 1 
                ORDER BY total_vote DESC LIMIT 4";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }
	
	public function get_rest_six_top_agenda(){
		$sql = "SELECT id,agenda_name,agenda_name_hindi,agenda_topic,agenda_topic_hindi,total_vote 
                FROM agenda_master 
                WHERE is_active = 1 
                ORDER BY total_vote DESC LIMIT 4,6";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    public function get_total_agenda_vote(){
        /*$sql = "SELECT COUNT(ua.id) as total_vote
                FROM `user_agenda` ua";*/
		$sql = "SELECT SUM(total_vote) AS total_vote
                FROM agenda_master";
        $query = $this->db->query($sql);
        $result =  $query->row_array();
        return $result['total_vote'];
    }

    public function getTotalUserSetAgenda(){
        /*$sql = "SELECT COUNT(DISTINCT ua.user_id) as total_vote
                FROM `user_agenda` ua";*/
		$sql = "SELECT SUM(total_vote) AS total_vote
                FROM agenda_master";
        $query = $this->db->query($sql);
        $result =  $query->row_array();
        return $result['total_vote'];
    }

    public function getSelectedAgenda($params){
        $return = array();

        $sql = "SELECT agenda_id 
                FROM user_agenda 
                WHERE user_session_id = '{$params['session_id']}'";
        $query = $this->db->query($sql);
        $return['agenda_list'] =  array_column($query->result_array(),'agenda_id');

        $sql = "SELECT agenda_name 
                FROM new_agenda 
                WHERE added_by_session_id = '{$params['session_id']}'";
        $query = $this->db->query($sql);
        $new_agenda =  $query->row_array();
        $return['new_agenda'] = $new_agenda['agenda_name'];
        return $return;
    }  


    public function getSelectedAgendaSummary($params){
        $return = array();

        $sql = "SELECT u.agenda_id,a.agenda_name,a.agenda_name_hindi 
                FROM user_agenda u 
                JOIN agenda_master a ON u.agenda_id = a.id
                WHERE u.user_session_id = '{$params['session_id']}'";
        $query = $this->db->query($sql);
        $return['agenda_list'] =  $query->result_array();

        $sql = "SELECT agenda_name 
                FROM new_agenda 
                WHERE added_by_session_id = '{$params['session_id']}'";
        $query = $this->db->query($sql);
        $new_agenda =  $query->row_array();
        $return['new_agenda'] = $new_agenda['agenda_name'];
        return $return;
    } 
    
    public function apiLogin($auth_id, $passcode){
        if(!empty($auth_id)){
            $sql = "SELECT *  
                    FROM login 
                    WHERE auth_id = '".$auth_id."' and passcode = '".$passcode."'";
            //echo $sql;exit;
            $query = $this->db->query($sql);
            $verify_auth = $query->row_array();
            
            if(($verify_auth['auth_id']==$auth_id) && ($verify_auth['passcode']==$passcode)){
                return "Y";
            }
            else{
                return "N";
            }
        }
    }

    public function getUserTotalVotecron(){
        $this->db->cache_off();
        $sql = "SELECT * FROM users";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
	
	public function getnominatedagendas(){
		$return = array();
		$this->db->cache_off();
		$sql = "SELECT *
                FROM agendas_nominated_2nd";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
		$return=$result;
		return $return;
	}
	
	public function getstatedistricts(){
		$return = array();
		$this->db->cache_off();
		$sql = "SELECT *
                FROM state_dis_india";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
		$return=$result;
		return $return;
	}

}