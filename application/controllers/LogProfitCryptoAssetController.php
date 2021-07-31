<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LogProfitCryptoAssetController extends CI_Controller
{
	protected $datetime;
	protected $id_member;


	public function __construct()
	{
		parent::__construct();
		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->load->library('L_member', null, 'template');
		$this->load->model('M_profit_crypto_asset');
	}

	public function index()
	{
		$arr = $this->M_profit_crypto_asset->get_list($this->id_member);
		$data = [
			'title'      => APP_NAME . ' | Profit Trade Manager',
			'content'    => 'profit_crypto_asset/main',
			'vitamin_js' => 'profit_crypto_asset/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  LogProfitCryptoAssetController.php */
