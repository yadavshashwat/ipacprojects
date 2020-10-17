<?php
//include 'BaseModel.php';
class User_leader_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function add_leader_vote($params){
        if(!empty($params)){
            $this->db->trans_start();
            $this->db->insert('user_leader_vote', $params);

            $sql = "UPDATE leaders_master 
                    SET total_vote = total_vote + 1 
                    WHERE id = {$params['leader_id']}";
            $query = $this->db->query($sql);

            if($params['referral_code'] != 0){
            $sql = "UPDATE users
                    SET total_ref_vote = total_ref_vote + 1
                    WHERE registration_number = {$params['referral_code']}";
            $query = $this->db->query($sql);
            }

            if ($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                return "Y";
            }else{
                return "N";
            }            
        }        
    }

    public function post_leader_vote($params){
        if(!empty($params)){
            $this->db->trans_start();
            $this->db->insert('user_leader_vote_api', $params);
            $updateview = $this->db->query("update totalview set totalvisit = totalvisit+6 where id=1");
            $sql = "UPDATE leaders_master 
                    SET total_vote = total_vote + 1, total_vote_api = total_vote_api + 1 
                    WHERE id = {$params['leader_id']}";
            $query = $this->db->query($sql);

            if ($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                return "Y";
            }else{
                return "N";
            }            
        }        
    }
    
	
	public function getReferralCode($user_session_id){
		$sql = "SELECT *  
                    FROM user_leader_vote 
                    WHERE session_id = '$user_session_id'";
        $query = $this->db->query($sql);
		$result =  $query->row_array();
		$get_refrral_code=$result['referral_code'];
        return $get_refrral_code;
	}

    public function checkIsVoted($session_id){
        if(!empty($session_id)){

            $sql = "SELECT COUNT(*) as agenda 
                    FROM user_agenda 
                    WHERE user_session_id = '$session_id'";
            $query = $this->db->query($sql);
            $agenda = $query->row_array();

            if($agenda['agenda'] > 0){
                return "Y";exit;
            }

            $sql = "SELECT COUNT(*) as new_agenda 
                    FROM new_agenda 
                    WHERE added_by_session_id = '$session_id'";
            $query = $this->db->query($sql);
            $new_agenda = $query->row_array();
            
            if($new_agenda['new_agenda'] > 0){
                return "Y";exit;
            }

            $sql = "SELECT COUNT(*) as voted 
                    FROM user_leader_vote 
                    WHERE session_id = '$session_id'";
            //echo $sql;exit;
            $query = $this->db->query($sql);
            $voted = $query->row_array();
            
            if($voted['voted'] > 0){
                return "Y";exit;
            }

            $sql = "SELECT COUNT(*) as added 
                    FROM new_leaders 
                    WHERE added_by_session_id = '$session_id'";
            $query = $this->db->query($sql);
            $added = $query->row_array();

            if($added['added'] > 0){
                return "Y";exit;
            }

            return "N";exit;
        }
    }

    public function removeVote($session_id){
        if(!empty($session_id)){

            $this->db->trans_start();

            $sql = "DELETE FROM user_agenda 
                    WHERE user_session_id = '$session_id'";       
            $query = $this->db->query($sql);

            $sql = "DELETE FROM new_agenda 
                    WHERE added_by_session_id = '$session_id'";       
            $query = $this->db->query($sql);            
                        
            $sql = "DELETE FROM new_leaders 
                    WHERE added_by_session_id = '$session_id'";       
            $query = $this->db->query($sql);

            $sql = "SELECT leader_id 
                    FROM user_leader_vote 
                    WHERE session_id = '$session_id'";
            
            $query = $this->db->query($sql);
            $leader_id = $query->row_array();
            if(!empty($leader_id)){
                $sql = "UPDATE leaders_master 
                        SET total_vote = total_vote - 1 
                        WHERE id = {$leader_id['leader_id']} AND total_vote > 0";
                $query = $this->db->query($sql);

                $sql = "DELETE FROM user_leader_vote WHERE session_id = '$session_id'";
                $query = $this->db->query($sql);
            }

            if ($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                return "Y";
            }else{
                return "N";
            } 
        }
    }

    public function get_user_detail($user_id){
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $query = $this->db->query($sql);        
        $user_detail = $query->row_array();        
        return $user_detail; 
    }

    public function checkIsVotedById($user_id){
        if(!empty($user_id)){
            $sql = "SELECT COUNT(*) as voted 
                    FROM user_leader_vote 
                    WHERE user_id = $user_id";
            //echo $sql;exit;
            $query = $this->db->query($sql);
            $voted = $query->row_array();
            
            if($voted['voted'] > 0){
                return "Y";
            }else{
                $sql = "SELECT COUNT(*) as added 
                        FROM new_leaders 
                        WHERE added_by_user_id = $user_id";
                $query = $this->db->query($sql);
                $added = $query->row_array();
                if($added['added'] > 0){
                    return "Y";
                }else{
                    return "N";
                }
            }
        }
    }
}
?>