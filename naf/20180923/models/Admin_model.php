<?php
include 'BaseModel.php';
class Admin_model extends BaseModel {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function check_admin_detail($admin_email,$admin_password){
        $sql = "SELECT id,name,email_id 
                FROM super_admin 
                WHERE email_id = ? AND password = ? AND is_active = ?";
        $query = $this->db->query($sql, array($admin_email, $admin_password, '1'));        
        $user_detail = $query->row_array();

        if(count($user_detail)>0){

            $ip = $_SERVER['REMOTE_ADDR'];
            $last_login = date("Y-m-d H:i:s");
            $sql = "UPDATE super_admin SET last_login = '$last_login',ip_address = '$ip' WHERE id = {$user_detail['id']}";
            $query = $this->db->query($sql);

            return $user_detail;
        }else{
        }
    }


    public function generateOTP($length = 9, $add_dashes = false, $available_sets = 'luds'){
        
            $sets = array();
            if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
            if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
            if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
            if(strpos($available_sets, 's') !== false)
            $sets[] = '!#@$%&';

            $all = '';
            $password = '';
            foreach($sets as $set)
            {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
            }

            $all = str_split($all);
            for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

            $password = str_shuffle($password);

            if(!$add_dashes)
            return $password;

            $dash_len = floor(sqrt($length));
            $dash_str = '';
            while(strlen($password) > $dash_len)
            {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
            }
            $dash_str .= $password;
            return $dash_str;
        }   
    
    
}
?>