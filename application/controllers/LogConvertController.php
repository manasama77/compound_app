<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LogConvertController extends CI_Controller
{
	protected $datetime;
	protected $id_member;


	public function __construct()
	{
		parent::__construct();
		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->load->library('L_member', null, 'template');
	}

	public function index()
	{
		$arr = $this->M_core->get('log_convert', '*', ['id_member' => $this->id_member]);
		$data = [
			'title'      => APP_NAME . ' | Konversi',
			'content'    => 'log/convert/main',
			'vitamin_js' => 'log/convert/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  LogConvertController.php */
