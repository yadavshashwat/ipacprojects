<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Sendmails_model extends CI_Model{

		public function __construct(){
			parent::__construct();
		}

		protected $_config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'relay12.splitmx.com',//ipac.splitmx.com
			'smtp_port' => 25,//25
			'smtp_user' => 'splitmx12/ipac1',//naf@indianpac.com
			'smtp_pass' => 'f8DorfAt8zD32PVn1Sd6k6qW',//Ih1mhGZP?AtZ0AvaEK
			'mailtype' => 'html',
			'charset' => "utf-8"
		);

		
		protected $_sender_email = "pta@indianpac.com";		
		protected $_sender_name = "NAF";

		public function htmlmail($data){

			/*
				1. User name
				2. User email
				3. Subject
				4. Email View      'emails/forgot_password.php'
			*/

			$this->load->library('email', $this->_config);
			$this->email->set_newline("\r\n");
			$this->email->from($this->_sender_email, $this->_sender_name);
			$this->email->to($data['email']); // replace it with receiver mail id
			$this->email->subject($data['subject']); // replace it with relevant subject

			$body = $this->load->view($data["email_view"],$data,TRUE);
			
			$this->email->message($body);
			$result = $this->email->send();
			//dump($result);die;
			return $result;
		}
	}
?>