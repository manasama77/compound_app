<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LogTransferController extends CI_Controller
{
	protected $datetime;
	protected $id_member;


	public function __construct()
	{
		parent::__construct();
		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->load->library('L_member', null, 'template');
		$this->load->model('M_log_transfer');
	}

	public function index()
	{
		$arr = $this->M_log_transfer->get_data($this->id_member);
		$data = [
			'title'      => APP_NAME . ' | Catatan Transfer',
			'content'    => 'log/transfer/main',
			'vitamin_js' => 'log/transfer/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  LogTransferController.php */
