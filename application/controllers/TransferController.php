<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TransferController extends CI_Controller
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
		$this->user_id   = $this->session->userdata(SESI . 'user_id');


		$this->load->model('M_convert');
		$this->load->library('L_member', null, 'template');
		$this->load->helper('floating_helper');

		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];
	}

	public function index()
	{
		$is_kyc = $this->M_core->get('member', 'is_kyc', ['id' => $this->id_member])->row()->is_kyc;


		$content     = 'transfer/main';
		$vitamin_css = 'transfer/main_css';
		$vitamin_js  = 'transfer/main_js';

		if ($is_kyc != "yes") {
			$content     = 'kyc_alert';
			$vitamin_css = null;
			$vitamin_js  = null;
		}

		$arr         = $this->M_core->get('member_balance', 'profit_paid, bonus, ratu', ['id_member' => $this->id_member]);
		$profit_paid = $arr->row()->profit_paid;
		$bonus       = $arr->row()->bonus;
		$ratu        = $arr->row()->ratu;

		$data = [
			'title'       => APP_NAME . ' | Transfer',
			'content'     => $content,
			'vitamin_css' => $vitamin_css,
			'vitamin_js'  => $vitamin_js,
			'profit_paid' => $profit_paid,
			'bonus'       => $bonus,
			'ratu'        => $ratu,
			'csrf'        => $this->csrf,
		];
		$this->template->render($data);
	}

	public function store()
	{
		$code           = 200;
		$wallet_address = base64url_decode(trim($this->input->post('wallet_address')));
		$amount_ratu    = $this->input->post('amount_ratu');

		$count_wallet = $this->M_core->count('member', ['id' => $wallet_address]);

		$arr_balance = $this->M_core->get('member_balance', 'ratu', ['id_member' => $this->id_member]);
		$ratu        = $arr_balance->row()->ratu;

		if ($count_wallet == 0) {
			$code = 404;
			$msg = "Wallet Address tidak ditemukan";
			echo json_encode(['code' => $code, 'msg' => $msg]);
			exit;
		} elseif ($wallet_address == $this->id_member) {
			$code = 404;
			$msg = "Tidak dapat mengirimkan ke diri sendiri";
			echo json_encode(['code' => $code, 'msg' => $msg]);
			exit;
		} elseif ($amount_ratu > $ratu) {
			$code = 404;
			$msg = "Saldo RATU tidak mencukupi";
			echo json_encode(['code' => $code, 'msg' => $msg]);
			exit;
		}

		$arr_config        = $this->M_core->get('app_config', 'potongan_transfer', ['id' => 1]);
		$potongan_transfer = $arr_config->row()->potongan_transfer;
		$amount_ratu       = ($amount_ratu - ($amount_ratu * $potongan_transfer / 100));

		$this->M_convert->reduce_balance('ratu', $amount_ratu, $this->id_member);
		$this->M_convert->add_balance('ratu', $amount_ratu, $wallet_address);

		$data = [
			'from'       => $this->id_member,
			'to'         => $wallet_address,
			'amount'     => $amount_ratu,
			'created_at' => $this->datetime,
		];
		$this->M_core->store_uuid('log_transfer', $data);

		$msg = "Proses Transfer Berhasil";
		echo json_encode(['code' => $code, 'msg' => $msg]);
	}
}
        
/* End of file  TransferController.php */
