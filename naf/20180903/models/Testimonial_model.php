<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//include 'BaseModel.php';
class Testimonial_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getTestimonialList($last_index_testimonial)
    {
    	$this->db->cache_off();
        $sql = "SELECT * FROM influencers WHERE id > $last_index_testimonial and is_active ='1' ORDER BY priority LIMIT 6";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    public function getFirstTestimonials()
    {
    	$this->db->cache_off();
        $sql = "SELECT * FROM influencers LIMIT 4";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function getTotalTestimonialList(){
    	$this->db->cache_off();
        $sql = "SELECT * FROM influencers";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function getTestimonialListPriority()
    {
    	$this->db->cache_off();
        $sql = "SELECT * FROM influencers where is_active ='1' order by priority asc limit 4";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    // Count all record of table "contact_info" in database.
    public function record_count() {
        return $this->db->count_all("influencers");
    }

// Fetch data according to per_page limit.
    public function getInfluencers($limit, $start) {
    	$this->db->cache_off();
        $this->db->limit($limit,$start);
        $this->db->order_by("priority", "asc");
        $query = $this->db->get("influencers");
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