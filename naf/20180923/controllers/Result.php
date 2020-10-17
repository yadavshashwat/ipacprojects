<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //$this->session->unset_userdata('user');
        $this->load->model('Register_model','register');
        $this->load->model('Leaders_model','leaders');
        $this->load->model('User_leader_model','user_leader');
        $this->load->model('Agenda_model','agenda');
        
        // if(isset($_COOKIE['register_complete'])){
            
        // }else{
        //     redirect('register');
        // }

        
        if(isset($_COOKIE['on_step'])){
            if($_COOKIE['on_step'] == '0'){
                redirect('/');
            }else if($_COOKIE['on_step'] == '1'){ //agenda
                redirect('agenda');
            }else if($_COOKIE['on_step'] == '2'){ //vote
                 redirect('vote');
            }else if($_COOKIE['on_step'] == '3'){ //register
                 redirect('register');
            }else if($_COOKIE['on_step'] == '4' && isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])){
                setcookie("after_result","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                $_SESSION['user']['after_result'] = 1;

                setcookie("after_register","", time()-3600,"/");
                unset($_SESSION['user']['after_register']);
            }else{
                setcookie("on_step","3",time() + (10 * 365 * 24 * 60 * 60),"/");
                $_SESSION['user']['on_step'] = 3;
                redirect('register');
            }
        }else{
           redirect('/'); //home
        }                 
    }


    public function index(){
        $data = array();
        $data['title'] = "Result";       

        $user_id = $_COOKIE['user_id'];
        $data['user_detail'] = $this->user_leader->get_user_detail($user_id);

        
        if(!empty($data['user_detail'])){
            $data['total_votes']  = $this->leaders->get_total_vote();
            $data['top_leaders']  = $this->leaders->get_top_leaders();
            //$data['total_leader'] = $this->leaders->get_total_leaders();

            $data['top_agendas']  = $this->agenda->get_top_agenda();
            $data['total_agenda_vote']  = $this->agenda->get_total_agenda_vote();

            $data['total_agenda_voted_count'] = $this->agenda->getTotalUserSetAgenda();
            $data['total_leader_voted_count'] = $this->leaders->getTotalUserSetAgenda();

            $referral_code = $data['user_detail']['registration_number'];

            $data['my_assoc_count'] = $this->register->get_my_assoc_count($user_id,$referral_code);           
            //echo '<pre>';print_r($data);exit;
            $this->load->view('result',$data);
        }else{
            setcookie("on_step","3",time() + (10 * 365 * 24 * 60 * 60),"/");
            $_SESSION['user']['on_step'] = 3;
            // redirect('register');
        }   
    }

    public function download_result($user_id){
        $user_id      = base64_decode($user_id);

        // Name of your pdf file
        $filename = "NAF-Registration-Receipt.pdf";
        // fetch data from the database
        //$data = $this->YourModel->modelMethod();
        // pass data to view
        $data   = array();
        $data['user_detail'] = $this->user_leader->get_user_detail($user_id);        

        //echo '<pre>';print_r($data);exit;
        $html = $this->load->view('includes/certificate', $data, true);
        //echo $html;exit;
        // load the library
        $this->load->library('M_pdf');

        $this->mpdf=new mPDF('utf-8','A4','','',32,25,27,25,16,13);
        //$this->m_pdf->allow_charset_conversion=true;

        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output($filename, "D");
        //echo "PDF has been generated successfully!";  
    }
        
}
?>