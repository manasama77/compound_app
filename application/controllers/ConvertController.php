<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ConvertController extends CI_Controller
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


		$content    = 'convert/main';
		$vitamin_js = 'convert/main_js';

		if ($is_kyc != "yes") {
			$content    = 'kyc_alert';
			$vitamin_js = null;
		}

		$arr         = $this->M_core->get('member_balance', 'profit_paid, bonus, ratu', ['id_member' => $this->id_member]);
		$profit_paid = $arr->row()->profit_paid;
		$bonus       = $arr->row()->bonus;
		$ratu        = $arr->row()->ratu;

		$data = [
			'title'       => APP_NAME . ' | Konversi',
			'content'     => $content,
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
		$code        = 200;
		$source      = $this->input->post('source');
		$amount_usdt = $this->input->post('amount_usdt');

		$arr_balance = $this->M_core->get('member_balance', 'profit_paid, bonus', ['id_member' => $this->id_member]);
		$profit_paid = $arr_balance->row()->profit_paid;
		$bonus       = $arr_balance->row()->bonus;

		if ($source == "profit_paid") {
			if ($amount_usdt == 0) {
				$code = 404;
				$msg = "Nominal USDT 0";
				echo json_encode(['code' => $code, 'msg' => $msg]);
				exit;
			} elseif ($amount_usdt > $profit_paid) {
				$code = 404;
				$msg = "Saldo Profit Paid tidak mencukupi";
				echo json_encode(['code' => $code, 'msg' => $msg]);
				exit;
			}
		} elseif ($source == "bonus") {
			if ($amount_usdt == 0) {
				$code = 404;
				$msg = "Nominal USDT 0";
				echo json_encode(['code' => $code, 'msg' => $msg]);
				exit;
			} elseif ($amount_usdt > $bonus) {
				$code = 404;
				$msg = "Saldo Bonus tidak mencukupi";
				echo json_encode(['code' => $code, 'msg' => $msg]);
				exit;
			}
		}

		$rate        = $this->M_core->get('app_config', 'rate_usdt_ratu', ['id' => 1])->row()->rate_usdt_ratu;
		$amount_ratu = $rate * $amount_usdt;

		$this->M_convert->reduce_balance($source, $amount_usdt, $this->id_member);
		$this->M_convert->add_balance('ratu', $amount_ratu, $this->id_member);

		$data = [
			'id_member'   => $this->id_member,
			'source'      => $source,
			'amount_usdt' => $amount_usdt,
			'amount_ratu' => $amount_ratu,
			'rate'        => $rate,
			'created_at'  => $this->datetime,
		];
		$exec = $this->M_core->store_uuid('log_convert', $data);

		$msg = "Proses Konversi Berhasil";
		echo json_encode(['code' => $code, 'msg' => $msg]);
	}
}
        
/* End of file  ConvertController.php */
