<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SendEmail extends CI_Controller
{
	protected $from;
	protected $from_alias;
	protected $to;


	public function __construct()
	{
		parent::__construct();
		$this->from       = 'adam.pm59@gmail.com';
		$this->from_alias = 'Admin Test';
		$this->to         = 'adam.pm77@gmail.com';

		$this->load->helper('Otp_helper');
		$this->load->model('M_log_send_email');
	}


	public function otp($to = $this->to)
	{
		$subject = APP_NAME . " | OTP (One Time Password)";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data['otp'] = Generate_otp();

		// DEBUG
		$this->load->view('otp_template', $data, FALSE);
		exit;

		// PRODUCTION
		// $message = $this->load->view('otp_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email->write_log($to, $subject, $message, $is_success);
	}
}
        
    /* End of file  SendEmail.php */
