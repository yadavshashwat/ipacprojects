<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State_districts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Agenda_model', 'agenda');
        $this->load->model('Leaders_model', 'leaders');
        $this->load->model('Register_model', 'register');
        $this->load->model('User_leader_model', 'user_leader');
        $this->load->model('Referral_model', 'referral');
    }

    

    public function index()
    {
        $data = array();
		
		$data['getstatedistricts'] = $this->agenda->getstatedistricts();
		
		$this->load->view('state_districts', $data);
    }

    
}
