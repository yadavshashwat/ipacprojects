<?php
//include 'BaseModel.php';
class Trending_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

   /* public function getPartnerList(){
        $sql = "SELECT *
                FROM partner";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }*/
	
	/*public function getPartnerList($last_index_partner)
    {
        $sql = "SELECT * FROM partner WHERE id > $last_index_partner and is_active ='1' ORDER BY priority LIMIT 6";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }*/

    public function getFirstTrendings()
    {
    	$this->db->cache_off();
        $sql = "SELECT * FROM trending_banner where is_active ='1' ORDER BY priority";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
	
	public function getTotalTrendingList(){
		$this->db->cache_off();
        $sql = "SELECT * FROM trending_banner where is_active ='1'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    /*public function getPartnerListPriority(){
        $sql = "SELECT *
                FROM partner where is_active ='1' order by priority asc limit 4";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }*/

}
?>