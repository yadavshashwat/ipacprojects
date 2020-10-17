<?php
class BaseModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
    public function get_all_universities(){
        $sql = "SELECT u.*
                FROM university_master u 
                WHERE u.is_active = 1";
        $query = $this->db->query($sql);        
        $uni_detail = $query->result_array();
        return $uni_detail;        
    }

    public function get_all_years_in_universities($uni_id){
        $sql = "SELECT y.id,y.name 
                FROM years_master y
                JOIN university_master u ON y.uni_id = u.id
                WHERE y.is_active = ? AND u.id = ?";
        $query = $this->db->query($sql,array(1,$uni_id));        
        $all_years_detail = $query->result_array();
        return $all_years_detail;        
    }
    
    public function get_all_subject_in_universities($uni_id){
        $sql = "SELECT s.id,s.name 
                FROM subject_master s
                JOIN university_master u ON s.university_id = u.id
                WHERE s.is_active = ? AND u.id = ?";
        $query = $this->db->query($sql,array(1,$uni_id));        
        $all_subjects_detail = $query->result_array();
        return $all_subjects_detail;        
    }

    public function get_all_groups(){
        $sql = "SELECT * 
                FROM group_master 
                WHERE is_active = ?";
        $query = $this->db->query($sql,array(1));        
        $all_groups_detail = $query->result_array();
        return $all_groups_detail;        
    }

    public function get_all_remaining_subject_in_year($year_id){
        /*$sql = "SELECT CONCAT(s.id,'_',g.id) as id,CONCAT(s.name,' ',g.name) as name
				FROM subject_master s
				JOIN subject_group sg ON sg.subject_id = s.id
				JOIN group_master g ON sg.group_id = g.id
				JOIN years_master y ON s.year_id = y.id
                WHERE s.is_active = ? AND y.id = ?";*/

            $sql = "SELECT CONCAT(s.id,'_',g.id) as id,CONCAT(s.name,' ',g.name) as name
                    FROM `subject_group` sg
                    LEFT JOIN professor_subject ps ON (sg.subject_id = ps.subject_id AND sg.group_id = ps.group_id)
                    JOIN subject_master s ON s.id = sg.subject_id
                    JOIN group_master g ON g.id = sg.group_id
                    JOIN years_master y ON s.year_id = y.id
                    WHERE ps.id is null AND s.is_active = ? AND y.id = ? ";
        $query = $this->db->query($sql,array(1,$year_id));        
        $all_sub_detail = $query->result_array();
        return $all_sub_detail;        
    }

    

    public function is_prof_email_exist($email_id){
        $this->input->post(NULL, TRUE);
        if( $this->input->post('professor_id') != '' ) {
            $sql = "SELECT id FROM professor_master WHERE email_id = ? and id != ?";
            $query = $this->db->query($sql, array($email_id,$this->input->post('professor_id')));
        }else{
            $sql = "SELECT id FROM professor_master WHERE email_id = ?";
            $query = $this->db->query($sql, array($email_id));
        }
        $user_detail = $query->row_array();
        if(count($user_detail)>0){
            return 'Y';
        }else{
            return 'N';
        }
    }

    public function get_professor_detail($prof_id){
        $sql = "SELECT p.id,p.name,p.email_id,p.overview,p.profile_image_path,p.university_id,
                p.year_id,fp.password,
                GROUP_CONCAT(concat(ps.subject_id,'_',ps.group_id)) as subjects
                FROM professor_master p 
                JOIN forget_password fp ON p.id = fp.user_id AND fp.user_type = 1 
                JOIN professor_subject ps ON p.id = ps.professor_id
                WHERE p.is_active = ? AND p.id = ?
                GROUP BY p.id";
        $query = $this->db->query($sql, array(1,$prof_id));
        $prof_data = $query->row_array();
        return $prof_data;
    }

    public function get_assigned_remaining_subject_in_year($year_id,$prof_id){        
            $sql = "(SELECT CONCAT(s.id,'_',g.id) as id,CONCAT(s.name,' ',g.name) as name
                    FROM `subject_group` sg
                    LEFT JOIN professor_subject ps ON (sg.subject_id = ps.subject_id AND sg.group_id = ps.group_id)
                    JOIN subject_master s ON s.id = sg.subject_id
                    JOIN group_master g ON g.id = sg.group_id
                    JOIN years_master y ON s.year_id = y.id
                    WHERE ps.id IS NULL AND s.is_active = ? AND y.id = ?)
                    UNION
                    ( (SELECT CONCAT(s.id,'_',g.id) as id,CONCAT(s.name,' ',g.name) as name
                    FROM `subject_group` sg
                    LEFT JOIN professor_subject ps ON (sg.subject_id = ps.subject_id AND sg.group_id = ps.group_id) AND ps.professor_id = ?
                    JOIN subject_master s ON s.id = sg.subject_id
                    JOIN group_master g ON g.id = sg.group_id
                    JOIN years_master y ON s.year_id = y.id
                    WHERE ps.id IS NOT NULL AND s.is_active = ? AND y.id = ?)) ";
        $query = $this->db->query($sql,array(1,$year_id,$prof_id,1,$year_id));        
        $all_sub_detail = $query->result_array();
        return $all_sub_detail;        
    }

    public function is_stud_email_exist($email_id){
        $this->input->post(NULL, TRUE);
        if( $this->input->post('student_id') != '' ) {
            $sql = "SELECT id FROM student_master WHERE email_id = ? and id != ?";
            $query = $this->db->query($sql, array($email_id,$this->input->post('student_id')));
        }else{
            $sql = "SELECT id FROM student_master WHERE email_id = ?";
            $query = $this->db->query($sql, array($email_id));
        }
        $user_detail = $query->row_array();
        if(count($user_detail)>0){
            return 'Y';
        }else{
            return 'N';
        }
    }

    public function get_all_subjects_in_year($year_id){
        $sql = "SELECT s.id,s.name 
                FROM subject_master s
                JOIN years_master y ON s.year_id = y.id
                WHERE s.is_active = ? AND y.id = ?";
        $query = $this->db->query($sql,array(1,$year_id));        
        $all_subjects_detail = $query->result_array();
        foreach ($all_subjects_detail as $key => $value) {
            $sql = "SELECT g.id,g.name 
                FROM group_master g
                JOIN subject_group sg ON sg.group_id = g.id
                WHERE sg.subject_id = ?";
            $query = $this->db->query($sql,array($value['id']));        
            $all_subjects_detail[$key]['groups'] = $query->result_array();
        }
        //echo '<pre>';print_r($all_subjects_detail);exit();
        return $all_subjects_detail;   
    }

    public function get_student_detail($stud_id){
        $sql = "SELECT s.id,s.name,s.email_id,s.overview,s.profile_image_path,s.university_id,
                s.year_id,fp.password,
                GROUP_CONCAT(concat(ss.subject_id,'_',ss.group_id)) as subjects
                FROM student_master s 
                JOIN forget_password fp ON s.id = fp.user_id AND fp.user_type = 2 
                JOIN student_subject ss ON s.id = ss.student_id
                WHERE s.is_active = ? AND s.id = ?
                GROUP BY s.id";
        $query = $this->db->query($sql, array(1,$stud_id));
        $stud_data = $query->row_array();
        return $stud_data;
    }

    public function get_subject_in_year_for_ta($year_id){

            $sql = "SELECT CONCAT(s.id,'_',g.id) as id,CONCAT(s.name,' ',g.name) as name
                    FROM `professor_subject` ps 
                    LEFT JOIN ta_subject ts ON ts.subject_id = ps.subject_id AND ts.group_id = ps.group_id
                    JOIN subject_master s ON s.id = ps.subject_id
                    JOIN group_master g ON g.id = ps.group_id
                    JOIN years_master y ON s.year_id = y.id
                    WHERE ts.id IS NULL AND s.is_active = ? AND y.id = ? ";
        $query = $this->db->query($sql,array(1,$year_id));        
        $all_sub_detail = $query->result_array();
        return $all_sub_detail;        
    }

    public function get_assign_othr_subject_in_year_for_ta($year_id,$ta_id){
        $sql = "(
         SELECT  CONCAT(s.id,'_',g.id) as id,CONCAT(s.name,' ',g.name) as name
         FROM `professor_subject` ps 
         LEFT JOIN ta_subject ts ON ts.subject_id = ps.subject_id AND ts.group_id = ps.group_id
         JOIN subject_master s ON s.id = ps.subject_id
         JOIN group_master g ON g.id = ps.group_id
         JOIN years_master y ON s.year_id = y.id
         WHERE ts.id IS NULL AND s.is_active = ? AND y.id = ?
        )
        UNION
        (
            SELECT  CONCAT(s.id,'_',g.id) as id,CONCAT(s.name,' ',g.name) as name
             FROM `professor_subject` ps 
             JOIN ta_subject ts ON ts.subject_id = ps.subject_id AND ts.group_id = ps.group_id
             JOIN subject_master s ON s.id = ps.subject_id
             JOIN group_master g ON g.id = ps.group_id
             WHERE s.is_active = ? AND s.year_id = ? AND ts.id = ?
        )";

        $query = $this->db->query($sql,array(1,$year_id,1,$year_id,$ta_id,));        
        $all_sub_detail = $query->result_array();
        return $all_sub_detail;    
    }

    public function is_ta_email_exist($email_id){
        $this->input->post(NULL, TRUE);
        if( $this->input->post('ta_id') != '' ) {
            $sql = "SELECT id FROM ta_master WHERE email_id = ? and id != ?";
            $query = $this->db->query($sql, array($email_id,$this->input->post('ta_id')));
        }else{
            $sql = "SELECT id FROM ta_master WHERE email_id = ?";
            $query = $this->db->query($sql, array($email_id));
        }
        $user_detail = $query->row_array();
        if(count($user_detail)>0){
            return 'Y';
        }else{
            return 'N';
        }
    }

    public function get_ta_detail($ta_id){
        $sql = "SELECT t.id,t.name,t.email_id,t.overview,t.profile_image_path,t.university_id,
                t.year_id,fp.password,
                GROUP_CONCAT(concat(ts.subject_id,'_',ts.group_id)) as subjects
                FROM ta_master t 
                JOIN forget_password fp ON t.id = fp.user_id AND fp.user_type = 3
                JOIN ta_subject ts ON t.id = ts.ta_id
                WHERE t.is_active = ? AND t.id = ?
                GROUP BY t.id";
        $query = $this->db->query($sql, array(1,$ta_id));
        $ta_data = $query->row_array();
        return $ta_data;
    }

    public function get_subject_in_year_for_video($year_id){
            $sql = "SELECT CONCAT(s.id,'_',g.id) as id,CONCAT(s.name,' ',g.name) as name
                    FROM subject_master s 
                    JOIN subject_group sg on s.id = sg.subject_id
                    JOIN group_master g on g.id = sg.group_id
                    JOIN years_master y ON y.id = s.year_id
                    WHERE s.is_active = ? AND y.id = ?";
        $query = $this->db->query($sql,array(1,$year_id));        
        $all_sub_detail = $query->result_array();
        return $all_sub_detail;        
    }

     public function get_video_detail($v_id){
        $sql = "SELECT v.id,v.title,v.description,v.quality,v.university_id,v.year_id,
                v.video_path,v.duration,
                GROUP_CONCAT(concat(vs.subject_id,'_',vs.group_id)) as subjects
                FROM video_master v 
                JOIN video_subject vs ON v.id = vs.video_id
                WHERE v.is_active = ? AND v.id = ?
                GROUP BY v.id";
        $query = $this->db->query($sql, array(1,$v_id));
        $video_data = $query->row_array();
        return $video_data;
    }
}

?>