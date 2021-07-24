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
		$this->load->model('M_trade_manager');
	}


	public function index()
	{
		$arr  = $this->M_trade_manager->get_group_invoice();
		$data = [
			'title'      => APP_NAME . ' | Log Trade Manager',
			'content'    => 'log/trade_manager/main',
			'vitamin_js' => 'log/trade_manager/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}

	public function detail($invoice = null)
	{
		if ($invoice == null) {
			return show_404();
		}

		$where = [
			'invoice'    => $invoice,
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member_trade_manager', '*', $where);

		if ($arr->num_rows() == 0) {
			return show_404();
		}

		$data_package_history = [];
		$where                = ['invoice' => $invoice];
		$arr_package          = $this->M_core->get('log_member_trade_manager', '*', $where, 'created_at', 'desc');
		foreach ($arr_package->result() as $key) {
			$dt = new DateTime($key->created_at);
			$data_package_history[$dt->format('Y-m-d')] = [];
		}
		foreach ($arr_package->result() as $key) {
			$state       = $key->state;
			$description = $key->description;
			$created_at  = new DateTime($key->created_at);
			$nested      = compact('state', 'description', 'created_at');
			array_push($data_package_history[$created_at->format('Y-m-d')], $nested);
		}

		$data_profit_history = [];
		$where               = [
			'invoice'   => $invoice,
			'id_member' => $this->id_member
		];
		$arr_profit          = $this->M_core->get('log_profit_trade_manager', '*', $where, 'created_at', 'desc');
		foreach ($arr_profit->result() as $key) {
			$dt = new DateTime($key->created_at);
			$data_profit_history[$dt->format('Y-m-d')] = [];
		}
		foreach ($arr_profit->result() as $key) {
			$state       = $key->state;
			$description = $key->description;
			$created_at  = new DateTime($key->created_at);
			$nested      = compact('state', 'description', 'created_at');
			array_push($data_profit_history[$created_at->format('Y-m-d')], $nested);
		}

		$data = [
			'title'                => APP_NAME . ' | Log Trade Manager - ' . $invoice,
			'content'              => 'log/trade_manager/detail',
			'vitamin_js'           => 'log/trade_manager/detail_js',
			'invoice'              => $invoice,
			'data_package_history' => $data_package_history,
			'data_profit_history'  => $data_profit_history,
		];
		$this->template->render($data);
	}
}
        
/* End of file  LogTradeManagerController.php */
