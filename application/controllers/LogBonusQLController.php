<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LogBonusQLController extends CI_Controller
{
	protected $date;
	protected $datetime;
	protected $id_member;
	protected $email_member;


	public function __construct()
	{
		parent::__construct();
		$this->date           = date('Y-m-d');
		$this->datetime       = date('Y-m-d H:i:s');
		$this->id_member      = $this->session->userdata(SESI . 'id');
		$this->email_member   = $this->session->userdata(SESI . 'email');

		$this->load->library('L_member', null, 'template');
		$this->load->helper('floating_helper');
		$this->load->model('M_log_bonus_ql');
	}


	public function index()
	{
		$arr = $this->M_log_bonus_ql->get_log($this->id_member);
		$data = [
			'title'      => APP_NAME . ' | Log Bonus Recruitment',
			'content'    => 'log/bonus_ql/main',
			'vitamin_js' => 'log/bonus_ql/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  LogBonusQLController.php */
