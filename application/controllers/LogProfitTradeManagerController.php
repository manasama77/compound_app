<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LogProfitTradeManagerController extends CI_Controller
{
	protected $datetime;
	protected $id_member;


	public function __construct()
	{
		parent::__construct();
		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->load->library('L_member', null, 'template');
		$this->load->model('M_profit_trade_manager');
	}

	public function index()
	{
		$arr = $this->M_profit_trade_manager->get_list($this->id_member);
		$data = [
			'title'      => APP_NAME . ' | Profit Trade Manager',
			'content'    => 'profit_trade_manager/main',
			'vitamin_js' => 'profit_trade_manager/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  LogProfitTradeManagerController.php */
