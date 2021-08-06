<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WalletController extends CI_Controller
{
	protected $id_member;
	protected $date;
	protected $datetime;
	protected $csrf;

	public function __construct()
	{
		parent::__construct();
		$this->date      = date('Y-m-d');
		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->load->library('L_member', null, 'template');

		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];
	}

	public function index()
	{
		$arr = $this->M_core->get('member_wallet', '*', ['id_member' => $this->id_member]);
		$data = [
			'title'      => APP_NAME . ' | Wallet',
			'content'    => 'wallet/main',
			'vitamin_js' => 'wallet/main_js',
			'arr'        => $arr,
			'csrf'       => $this->csrf,
		];
		$this->template->render($data);
	}

	public function store()
	{
		$code           = 200;
		$coin_type      = $this->input->post('coin_type');
		$wallet_label   = trim($this->input->post('wallet_label'));
		$wallet_address = trim($this->input->post('wallet_address'));

		$where_check = [
			'deleted_at' => null,
			'coin_type'  => $coin_type,
		];
		$check = $this->M_core->count('member_wallet', $where_check);

		if ($check == 1) {
			$code = 201;
			echo json_encode(['code' => $code]);
			exit;
		}

		$data = [
			'id_member'      => $this->id_member,
			'coin_type'      => $coin_type,
			'wallet_label'   => $wallet_label,
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
		$coin_type      = $this->input->post('coin_type_edit');
		$wallet_label   = trim($this->input->post('wallet_label_edit'));
		$wallet_address = trim($this->input->post('wallet_address_edit'));

		$data = [
			'coin_type'      => $coin_type,
			'wallet_label'   => $wallet_label,
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
