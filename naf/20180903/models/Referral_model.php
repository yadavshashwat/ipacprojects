<?php
//include 'BaseModel.php';
class Referral_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
    
    public function get_referral_detail($referral_code){
		$this->db->cache_off();
        $sql = "SELECT id FROM users 
                WHERE registration_number = '$referral_code'";
        $query = $this->db->query($sql);        
        $referral_detail = $query->row_array();
        //Jai Mata Di        
        return $referral_detail;


    }
}
?>