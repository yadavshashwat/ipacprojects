<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 01/08/18
 * Time: 5:43 PM
 */
//include 'BaseModel.php';
class People_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getNoOfPeople(){
        $sql = "SELECT *
                FROM people_count";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }

}
?>