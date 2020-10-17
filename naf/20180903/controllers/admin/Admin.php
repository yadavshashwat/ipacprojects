<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'BaseController.php';
class Admin extends BaseController {

	public function __construct()
    {
        parent::__construct();
    }    

	public function login()
	{	
		if($this->session->has_userdata('admin_login')){
			redirect('admin/university');
		}
        $this->load->view('admin/login');
	}

	public function signout(){
		$this->session->unset_userdata('admin_login');
		redirect('admin-panel/login');
	}

	public function validateAdminDetail(){

		//echo '<pre>';print_r($_SERVER);exit;

        if ($this->form_validation->run('admin_signup') == FALSE){
            $errors = validation_errors();
            echo json_encode(['success'=>'N','message'=>$errors]);
        }else{
			$this->input->post(NULL, TRUE);
			$admin_email    = $this->input->post('admin_email');
			$admin_password = md5($this->input->post('admin_password'));
			
			$detail = $this->admin->check_admin_detail($admin_email,$admin_password);
			if(empty($detail)){
				echo json_encode(['success'=>'N','message'=>'No such user.']);
			}else{
				$this->session->set_userdata('admin_login',$detail);
				echo json_encode(['success'=>'Y','message'=>$detail]);
			}           	
        }
	}	
}
