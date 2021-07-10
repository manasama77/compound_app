<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LogTradeManagerController extends CI_Controller
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
		$this->load->model('M_withdraw');
	}


	public function index()
	{
		$where = ['id_member' => $this->id_member];
		$arr = $this->M_core->get('log_member_trade_manager', '*', $where, 'created_at', 'desc');
		$data = [
			'title'      => APP_NAME . ' | Log Trade Manager',
			'content'    => 'log/trade_manager/main',
			'vitamin_js' => 'log/trade_manager/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  LogTradeManagerController.php */
