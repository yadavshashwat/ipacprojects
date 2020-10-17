<?php
//include 'BaseModel.php';
class Partner_model extends CI_Model {

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
	
	public function getPartnerList($last_index_partner)
    {
        $this->db->cache_off();     
        $sql = "SELECT * FROM partner WHERE id > $last_index_partner and is_active ='1' ORDER BY priority LIMIT 6";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    public function getFirstPartners()
    {
        $this->db->cache_off();
        $sql = "SELECT * FROM partner where is_active ='1' ORDER BY priority LIMIT 4";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
	
	public function getTotalPartnerList(){
        $this->db->cache_off();
        $sql = "SELECT * FROM partner where is_active ='1'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function getPartnerListPriority(){
        $this->db->cache_off();
        $sql = "SELECT *
                FROM partner where is_active ='1' order by priority asc limit 4";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    // Count all record of table "contact_info" in database.
    public function record_count() {
        return $this->db->count_all("partner");
    }

// Fetch data according to per_page limit.
    public function getPartners($limit, $start) {
        $this->db->cache_off();
        $this->db->limit($limit,$start);
        $this->db->order_by("priority", "asc");
        $query = $this->db->get("partner");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

}
?>