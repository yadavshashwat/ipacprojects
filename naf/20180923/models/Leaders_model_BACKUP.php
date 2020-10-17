<?php
//include 'BaseModel.php';
class Leaders_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function update_district(){
        /*$sql = "SELECT district_id 
                FROM state_district";
        //echo $sql;exit;
        $query = $this->db->query($sql);        
        $result = $query->result_array();     
        foreach ($result as $key => $value) {
            $name = $value['district_id'];
            $sql = "INSERT INTO district_master (name,is_active) VALUES('$name',1)";    
            $this->db->query($sql); 
        } */ 

        /*$sql = "SELECT id,name 
                FROM state_master";
        $query = $this->db->query($sql);        
        $result = $query->result_array();

        foreach ($result as $key => $value) {
            $id = $value['id'];
            $state_name = $value['name'];
            $sql = "UPDATE state_district 
                    SET state_id = $id 
                    WHERE state_id = '$state_name'";
            $query = $this->db->query($sql);
        }*/


       /* $sql = "SELECT id,name 
                FROM district_master";
        $query = $this->db->query($sql);        
        $result = $query->result_array();

        foreach ($result as $key => $value) {
            $id = $value['id'];
            $name = $value['name'];
            $sql = "UPDATE state_district 
                    SET district_id = $id 
                    WHERE district_id = '$name'";
            $query = $this->db->query($sql);
        }*/
    }

    public function get_all_leaders_details($offset, $no_of_rows, $search_params){
        /*$sql = "SELECT u.*,c.name as country,s.name as state,ct.name as city
                FROM university_master u 
                JOIN countries c ON u.country = c.id
                JOIN states s ON u.state = s.id               
                JOIN cities ct ON u.city = ct.id
                WHERE u.is_active = 1";*/

        $sql = "SELECT id,full_name,is_feature,total_vote 
                FROM leaders_master 
                WHERE is_active = 1";

        if(isset($search_params["search"])){
            $sql .= " AND ( full_name LIKE '%".$search_params["search"]."%')";
        }

        if(isset($_POST['order'])){
            if($_POST['order'][0]["column"] == 1){
                $sql .= " ORDER BY full_name ".$_POST['order'][0]["dir"];
            }

            if($_POST['order'][0]["column"] == 3){
                $sql .= " ORDER BY total_vote ".$_POST['order'][0]["dir"];
            }
        }

        if($offset != "" && $no_of_rows != "" && $no_of_rows != "-1"){
            $sql .= " LIMIT ".$offset.",".$no_of_rows;
        }
        $query = $this->db->query($sql);        
        $leader_details = $query->result_array();        
        return $leader_details;        
    }

    public function get_leaders_Count($search_params){
        $sql = "SELECT COUNT(*) as count 
                FROM leaders_master
                WHERE is_active = 1";

        if(isset($search_params["search"])){
            $sql .= " AND ( full_name LIKE '%".$search_params["search"]."%')";
        }
        $query = $this->db->query($sql);
        $result =  $query->row_array();
        return $result["count"];
    }

    public function get_all_new_leaders($offset, $no_of_rows, $search_params){

        $sql = "SELECT id,name as leader_name
                FROM new_leaders 
                WHERE is_active = 1";

        if(isset($search_params["search"])){
            $sql .= " AND ( name LIKE '%".$search_params["search"]."%')";
        }

        if(isset($_POST['order'])){
            if($_POST['order'][0]["column"] == 1){
                $sql .= " ORDER BY name ".$_POST['order'][0]["dir"];
            }
        }

        if($offset != "" && $no_of_rows != "" && $no_of_rows != "-1"){
            $sql .= " LIMIT ".$offset.",".$no_of_rows;
        }
        $query = $this->db->query($sql);        
        $leader_details = $query->result_array();        
        return $leader_details;        
    }

    public function get_new_leaders_Count($search_params){
        $sql = "SELECT COUNT(*) as count 
                FROM new_leaders
                WHERE is_active = 1";

        if(isset($search_params["search"])){
            $sql .= " AND ( name LIKE '%".$search_params["search"]."%')";
        }
        $query = $this->db->query($sql);
        $result =  $query->row_array();
        return $result["count"];
    }

    public function get_all_featured_leaders(){
        $sql = "SELECT id,full_name,image_path,is_feature,total_vote 
                FROM leaders_master 
                WHERE is_active = 1 AND is_feature = 1 ORDER BY full_name ASC";
        $query = $this->db->query($sql);        
        $all_leaders = $query->result_array();        
        return $all_leaders; 
    }

    public function getLeaderInfo($params){
        if(!empty($params)){
            $sql = "SELECT id,full_name,image_path 
                    FROM leaders_master 
                    WHERE id = {$params['id']}";
            $query = $this->db->query($sql);        
            $leader_info = $query->row_array();        
            return $leader_info; 
        }
    }

    public function get_total_vote(){
        $sql = "SELECT SUM(total_vote) as total_vote 
                FROM `leaders_master` 
                WHERE is_active = 1";
        $query = $this->db->query($sql);        
        $total_vote = $query->row_array();        
        return $total_vote['total_vote'];
    }

    public function get_top_leaders(){
        $sql = "SELECT id,full_name,total_vote 
                FROM leaders_master 
                WHERE is_active = 1 
                ORDER BY total_vote DESC 
                LIMIT 0,10";
        $query = $this->db->query($sql);        
        $top_leaders = $query->result_array();        
        return $top_leaders; 
    }

    public function get_total_leaders(){
        $sql = "SELECT COUNT(id) total_leaders FROM leaders_master WHERE is_active = 1";
        $query = $this->db->query($sql);        
        $total_leaders = $query->row_array();        
        return $total_leaders['total_leaders'];
    }

    public function get_all_other_leaders(){
        $sql = "SELECT id,full_name 
                FROM leaders_master 
                WHERE is_active = 1 AND is_feature = 0  ORDER BY full_name ASC";
        $query = $this->db->query($sql);        
        $all_leaders = $query->result_array();        
        return $all_leaders; 
    }

    public function add_new_leader($params){
        $sql = "SELECT id FROM leaders_master WHERE full_name = '{$params['full_name']}'";
        $query = $this->db->query($sql);   
        $leader_id = $query->row_array();    
        /*$leader_id = array();*/
        if(!empty($leader_id)){
            $data = array();
            $data['leader_id']   = $leader_id['id'];
            $data['is_new']      = 0;
            $data['session_id']  = $this->input->post('session_id');
            $data['user_id']     = $params['added_by_user_id'];
            $data['user_ip']     = $_SERVER['REMOTE_ADDR'];
            
            if(isset($_POST['referral_code'])){
                $data['referral_code'] = $this->input->post('referral_code'); 
            }
            if(isset($_POST['referral_owner_id'])){
                $data['referral_owner_id'] = $this->input->post('referral_owner_id');
            }

            $data['user_tracting_detail'] = json_encode($_SERVER);      
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['modified_at'] = date("Y-m-d H:i:s");     

            $this->db->trans_start();
            $this->db->insert('user_leader_vote', $data);

            $sql = "UPDATE leaders_master 
                    SET total_vote = total_vote + 1 
                    WHERE id = {$data['leader_id']}";
            $query = $this->db->query($sql);

            if ($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                return "Y";
            }else{
                return "N";
            }
        }else{
            $data = array();
            $data['name'] = $params['full_name'];
            $data['added_by_session_id'] = $this->input->post('session_id');
            $data['added_by_user_id'] = $params['added_by_user_id'];
            $data['is_active']   = 1;
            if(isset($_POST['referral_code'])){
                $data['referral_code'] = $this->input->post('referral_code'); 
            }

            if(isset($_POST['referral_owner_id'])){
                $data['referral_owner_id'] = $this->input->post('referral_owner_id');
            }
            
            $data['created_at']  = date("Y-m-d H:i:s");
            $data['modified_at'] = date("Y-m-d H:i:s"); 
            $this->db->insert('new_leaders', $data);
            //$leader_id = $this->db->insert_id(); 
            return "Y";   
        }
    }

    public function getTotalUserSetAgenda(){
        $sql = "SELECT COUNT(DISTINCT user_id) as total_vote
                FROM user_leader_vote";
        $query = $this->db->query($sql);
        $result =  $query->row_array();
        return $result['total_vote'];
    }

    public function getSelectedLeaderSummary($params){
        $return = array();

        $sql = "SELECT ul.leader_id,l.full_name 
                FROM user_leader_vote ul 
                JOIN leaders_master l ON ul.leader_id = l.id
                WHERE ul.session_id = '{$params['session_id']}'";
        $query = $this->db->query($sql);
        $return['leader_list'] =  $query->row_array();

        $sql = "SELECT name 
                FROM new_leaders 
                WHERE added_by_session_id = '{$params['session_id']}'";
        $query = $this->db->query($sql);
        $new_agenda =  $query->row_array();
        $return['new_leader'] = $new_agenda['name'];
        return $return;
    }
}
?>