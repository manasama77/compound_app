<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WalletController extends CI_Controller
{
	protected $id_member;
	protected $date;
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->date      = date('Y-m-d');
		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->load->library('L_member', null, 'template');
	}

	public function index()
	{
		$arr = $this->M_core->get('member_wallet', '*', ['id_member' => $this->id_member]);
		$data = [
			'title'      => APP_NAME . ' | Wallet Management',
			'content'    => 'wallet/main',
			'vitamin_js' => 'wallet/main_js',
			'arr'        => $arr,
		];
		$this->template->render($data);
	}

	public function store()
	{
		$code = 200;
		$receive_coin   = $this->input->post('receive_coin');
		$wallet_host    = $this->input->post('wallet_host');
		$wallet_address = $this->input->post('wallet_address');

		$data = [
			'id_member'      => $this->id_member,
			'receive_coin'   => $receive_coin,
			'wallet_host'    => $wallet_host,
			'wallet_address' => $wallet_address,
			'created_at'     => $this->datetime,
			'updated_at'     => $this->datetime,
			'deleted_at'     => null,
		];
		$exec = $this->M_core->store_uuid("member_wallet", $data);

		if (!$exec) {
			$code = 500;
		}

		echo json_encode(['code' => $code]);
	}

	public function update()
	{
		$code           = 200;
		$id             = $this->input->post('id_edit');
		$receive_coin   = $this->input->post('receive_coin_edit');
		$wallet_host    = $this->input->post('wallet_host_edit');
		$wallet_address = $this->input->post('wallet_address_edit');

		$data = [
			'receive_coin'   => $receive_coin,
			'wallet_host'    => $wallet_host,
			'wallet_address' => $wallet_address,
			'updated_at'     => $this->datetime,
		];
		$where = [
			'id' => $id,
			'id_member' => $this->id_member,
		];
		$exec = $this->M_core->update("member_wallet", $data, $where);

		if (!$exec) {
			$code = 500;
		}

		echo json_encode(['code' => $code]);
	}

	public function destroy()
	{
		$code           = 200;
		$id             = $this->input->post('id');

		$data = ['deleted_at' => $this->datetime,];
		$where = [
			'id' => $id,
			'id_member' => $this->id_member,
		];
		$exec = $this->M_core->update("member_wallet", $data, $where);

		if (!$exec) {
			$code = 500;
		}

		echo json_encode(['code' => $code]);
	}
}
        
/* End of file  WalletController.php */
