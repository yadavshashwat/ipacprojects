<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 01/08/18
 * Time: 5:43 PM
 */
//include 'BaseModel.php';
class KPI_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getInflu(){
        $sql = "SELECT count(*) as total_influencers FROM influencers";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result[0]['total_influencers'];
    }

    public function getOrgi(){
        $sql = "SELECT count(*)  as total_partners FROM partner";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result[0]['total_partners'];
    }

    public function getAsso(){
        $sql = "SELECT count(*) as total_users FROM users";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return ($result[0]['total_users'] + 7000);
    }

    public function getHits(){
        $sql = "SELECT * FROM people_Count";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    public function getColleges(){
        $sql = "SELECT count(*) as college_count FROM colleges_2nd";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return ($result[0]['college_count']);
    }

    public function getNomiAgendas(){
        $sql = "SELECT count(*) as num_agendas FROM `agendas_nominated_2nd`";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return ($result[0]['num_agendas']);
    }
    public function getNomiLeaders(){
        $sql = "SELECT count(*) as num_leaders FROM `leaders_nominated_2nd`";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return ($result[0]['num_leaders']);
    }

}
?>