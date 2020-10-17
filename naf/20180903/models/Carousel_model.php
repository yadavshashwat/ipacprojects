<?php
//include 'BaseModel.php';
class Carousel_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getCarouselList(){
        $sql = "SELECT DISTINCT image_id,name,id,college_name
                FROM pta_randomiser 
                ORDER BY rand()";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    public function getPtarandomiserPriority(){
        $sql = "SELECT *
                FROM pta_randomiser where is_active ='1' limit 4";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

    // Count all record of table "contact_info" in database.
    public function record_count() {
        return $this->db->count_all("users");
    }

// Fetch data according to per_page limit.
    public function getAssociates($limit, $start) {
        $this->db->limit($limit,$start);
        $this->db->join('state_master', 'state_master.id = users.collage_state_id', 'left');
        $query = $this->db->get("users");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    //fetch books
    function get_users_search($limit, $start, $st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from users left join state_master on state_master.id = users.collage_state_id where user_name like '%$st%' or collage_name like '%$st%'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_users_count($st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from users where user_name like '%$st%' or collage_name like '%$st%'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }


}
?>