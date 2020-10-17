<?php
//include 'BaseModel.php';
class News_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getNewsList(){
        $sql = "SELECT *
                FROM news ORDER BY priority";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }
}
?>