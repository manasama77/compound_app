<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WithdrawController extends CI_Controller
{
	protected $date;
	protected $datetime;
	protected $id_member;
	protected $email_member;
	protected $api_link;
	protected $public_key;
	protected $private_key;
	protected $merchant_id;
	protected $ipn_secret_key;
	protected $from;
	protected $from_alias;
	protected $ip_address;
	protected $user_agent;
	protected $csrf;

	public function __construct()
	{
		parent::__construct();
		$this->date           = date('Y-m-d');
		$this->datetime       = date('Y-m-d H:i:s');
		$this->id_member      = $this->session->userdata(SESI . 'id');
		$this->email_member   = $this->session->userdata(SESI . 'email');
		$this->api_link       = CP_API_LINK;
		$this->public_key     = CP_PUB_KEY;
		$this->private_key    = CP_PRV_KEY;
		$this->merchant_id    = CP_MERCH_ID;
		$this->ipn_secret_key = CP_IPN_SEC_KEY;
		$this->from           = EMAIL_ADMIN;
		$this->from_alias     = EMAIL_ALIAS;
		$this->ip_address     = $this->input->ip_address();
		$this->user_agent     = $this->input->user_agent();

		$this->load->library('L_member', null, 'template');
		$this->load->library('L_genuine_mail', null, 'genuine_mail');
		$this->load->helper(['cookie', 'string', 'Otp_helper', 'Domain_helper', 'Time_helper', 'Floating_helper']);
		$this->load->model('M_withdraw');
		$this->load->model('M_dashboard');
		$this->load->model('M_log_send_email_member');

		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];
	}

	public function index()
	{
		$this->_unset_session();
		$arr    = $this->M_dashboard->get_member_balance($this->id_member);
		$profit = check_float($arr->row()->profit);
		$bonus  = check_float($arr->row()->bonus);

		$data = [
			'title'      => APP_NAME . ' | Penarikan',
			'content'    => 'withdraw/main',
			'vitamin_js' => 'withdraw/main_js',
			'profit'     => $profit,
			'bonus'      => $bonus,
			'csrf'       => $this->csrf,
		];
		$this->template->render($data);
	}

	public function auth()
	{
		$this->_unset_session();
		$arr    = $this->M_dashboard->get_member_balance($this->id_member);
		$profit = $arr->row()->profit;
		$bonus  = $arr->row()->bonus;

		$source    = $this->input->post('source');
		$amount    = $this->input->post('amount');
		$coin_type = $this->input->post('coin_type');
		$id_wallet = $this->input->post('wallet_address');

		$code = 500;
		$msg  = "Tidak dapat terhubung dengan Database, silahkan coba kembali!";

		if ($source == "profit") {
			if ($amount > $profit) {
				$msg  = "Saldo Profit Tidak Mencukupi";
			} else {
				$code = 200;
				$msg  = "Success";
			}
		} elseif ($source == "bonus") {
			if ($amount > $bonus) {
				$msg  = "Saldo Bonus Tidak Mencukupi";
			} else {
				$code = 200;
				$msg  = "Success";
			}
		}

		if ($code == 200) {
			$arr_wallet = $this->get_arr_wallet($id_wallet);
			if ($arr_wallet === false) {
				$code = 501;
				echo json_encode(['code' => $code, 'message' => "Wallet tidak ditemukan atau data telah terupdate, silahkan coba kembali!"]);
				exit;
			}

			$wallet_label   = $arr_wallet->row()->wallet_label;
			$wallet_address = $arr_wallet->row()->wallet_address;
			$this->_set_session($source, $amount, $coin_type, $id_wallet, $wallet_label, $wallet_address);
			$this->_send_otp($this->id_member, $this->email_member);
		}

		echo json_encode(['code' => $code, 'message' => $msg]);
	}

	public function otp()
	{
		$source         = $this->session->userdata(SESI . 'source');
		$amount         = $this->session->userdata(SESI . 'amount');
		$coin_type      = $this->session->userdata(SESI . 'coin_type');
		$id_wallet      = $this->session->userdata(SESI . 'id_wallet');
		$wallet_label   = $this->session->userdata(SESI . 'wallet_label');
		$wallet_address = $this->session->userdata(SESI . 'wallet_address');

		if (!isset($source) && !isset($amount) && !isset($coin_type) && !isset($id_wallet) && !isset($wallet_label) && !isset($wallet_address)) {
			$this->_unset_session();
			redirect('withdraw');
			exit;
		}

		$arr_wallet = $this->get_arr_wallet($id_wallet);
		if ($arr_wallet === false) {
			return show_error("Wallet tidak ditemukan atau data telah terupdate, silahkan coba kembali!", 404, "Terjadi Kesalahan");
		}

		$data = [
			'title'          => APP_NAME . ' | OTP Penarikan',
			'content'        => 'withdraw/otp',
			'vitamin_js'     => 'withdraw/otp_js',
			'source'         => $source,
			'amount'         => $amount,
			'wallet_label'   => $wallet_label,
			'wallet_address' => $wallet_address,
			'csrf'           => $this->csrf,
		];
		$this->template->render($data);
	}

	protected function _set_session($source, $amount, $coin_type, $id_wallet, $wallet_label, $wallet_address)
	{
		$data_session = [
			SESI . 'source'         => $source,
			SESI . 'amount'         => $amount,
			SESI . 'coin_type'      => $coin_type,
			SESI . 'id_wallet'      => $id_wallet,
			SESI . 'wallet_label'   => $wallet_label,
			SESI . 'wallet_address' => $wallet_address,
		];
		$this->session->set_userdata($data_session);
	}

	protected function _unset_session()
	{
		$data_session = [
			SESI . 'source',
			SESI . 'amount',
			SESI . 'coin_type',
			SESI . 'id_wallet',
			SESI . 'wallet_source',
			SESI . 'wallet_address',
		];
		$this->session->unset_userdata($data_session);
	}

	public function get_arr_wallet($id_wallet)
	{
		$where_wallet = [
			'id'         => $id_wallet,
			'id_member'  => $this->id_member,
			'deleted_at' => null,
		];
		$arr_wallet = $this->M_core->get('member_wallet', 'wallet_label, wallet_address', $where_wallet);

		if ($arr_wallet->num_rows() == 0) {
			return false;
		}

		return $arr_wallet;
	}

	protected function _send_otp($id, $to): bool
	{
		$subject = APP_NAME . " | OTP (One Time Password)";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$otp = Generate_otp();

		$data['otp'] = $otp;
		$message = $this->load->view('emails/otp_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_core->update('member', ['otp' => $otp], ['id' => $id]);
		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	public function rates()
	{
		// header('Content-Type: application/json');
		$amount    = $this->input->get('amount');
		$coin_type = $this->input->get('coin_type');

		$req = [
			'short'    => 0,
			'accepted' => 1
		];
		$exec = $this->_coinpayments_api_call('rates', $req);

		if ($exec['error'] != "ok") {
			$code = 500;
			$msg = $exec['error'];
			echo json_encode([
				'code' => $code,
				'msg'  => $msg,
			]);
			exit;
		} elseif ($exec['error'] == "ok") {
			$code   = 200;
			$result = 0;

			$rate_usdt = 0;
			foreach ($exec['result']['USDT'] as $key => $val) {
				if ($key == "rate_btc") {
					$rate_usdt = $val;
				}
			}

			$rate_x = 0;
			$tx_fee = 0;
			if ($coin_type == "TRX") {
				foreach ($exec['result']['TRX'] as $key => $val) {
					if ($key == "rate_btc") {
						$rate_x = $val;
					}

					if ($key == "tx_fee") {
						$tx_fee = $val;
					}
				}
			} elseif ($coin_type == "BNB.BSC") {
				foreach ($exec['result']['BNB.BSC'] as $key => $val) {
					if ($key == "rate_btc") {
						$rate_x = $val;
					}

					if ($key == "tx_fee") {
						$tx_fee = $val;
					}
				}
			} elseif ($coin_type == "LTCT") {
				foreach ($exec['result']['LTCT'] as $key => $val) {
					if ($key == "rate_btc") {
						$rate_x = $val;
					}

					if ($key == "tx_fee") {
						$tx_fee = $val;
					}
				}
			}

			if ($rate_x != 0) {
				$result = (($amount * $rate_usdt) / $rate_x) - $tx_fee;
			}

			echo json_encode([
				'code'      => $code,
				'result'    => number_format($result, 8) . " " . strtoupper($coin_type),
				'amount'    => $amount,
				'rate_usdt' => $rate_usdt,
				'rate_x'    => $rate_x,
				'tx_fee'    => $tx_fee,
			]);
		}
	}

	public function render_wallet_label()
	{
		$coin_type = $this->input->get('coin_type');

		$where = [
			'id_member'  => $this->id_member,
			'coin_type'  => $coin_type,
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member_wallet', 'wallet_label', $where, 'updated_at', 'desc', 1);

		if ($arr->num_rows() == 0) {
			$code = 404;
			$data = [];
		} else {
			$code = 200;
			$data = $arr->result();
		}

		echo json_encode(['code' => $code, 'data' => $data]);
	}

	public function render_wallet_address()
	{
		$wallet_label = $this->input->get('wallet_label');

		$where = [
			'id_member'    => $this->id_member,
			'wallet_label' => $wallet_label,
			'deleted_at'   => null,
		];
		$arr = $this->M_core->get('member_wallet', '*', $where, 'updated_at', 'desc', 1);

		if ($arr->num_rows() == 0) {
			$code = 404;
			$data = [];
		} else {
			$code = 200;
			$data = $arr->result();
		}

		echo json_encode(['code' => $code, 'data' => $data]);
	}

	public function process()
	{
		$this->db->trans_begin();

		$source         = $this->session->userdata(SESI . 'source');
		$amount         = $this->session->userdata(SESI . 'amount');
		$coin_type      = $this->session->userdata(SESI . 'coin_type');
		$id_wallet      = $this->session->userdata(SESI . 'id_wallet');
		$wallet_label   = $this->session->userdata(SESI . 'wallet_label');
		$wallet_address = $this->session->userdata(SESI . 'wallet_address');

		$req = ['all' => 0];
		$get_coin_balance = $this->_coinpayments_api_call('balances', $req);

		if ($get_coin_balance['error'] != "ok") {
			$this->db->trans_rollback();
			return show_error('Gagal terhubung dengan server CoinPayments.net, silahkan coba kembali!', 500, "Telah terjadi kesalahan");
		}

		$x        = strtoupper($coin_type);
		$balancef = $get_coin_balance['result'][$x]['balancef'];

		if ($amount > $balancef) {
			$this->_send_alert_balance($coin_type, $amount);
			$this->db->trans_commit();

			$msg = 'Sistem tidak dapat memproses penarikan Anda, dikarenakan nominal banyaknya antrian penarikan saat ini.<br>Silahkan beritahu admin mengenai kedala ini di email <a href="mailto:' . EMAIL_ADMIN_2 . '" target="_blank"><mark>' . EMAIL_ADMIN_2 . '</mark></a> atau tunggu maksimal 24 jam sesudahnya untuk admin memproses kedala tersebut.';
			return show_error($msg, 500, "Telah terjadi kesalahan");
		}

		$note = "Penarikan dari $source senilai $amount USDT ke Coin " . strtoupper($coin_type) . " ke Wallet Address $wallet_address (" . strtoupper($wallet_label) . ")";

		/* 
		NOTES
		If add_tx_fee set to 1, add the coin TX fee to the withdrawal amount so the sender pays the TX fee instead of the receiver.
		*/
		$req = [
			'amount'       => $amount,
			'add_tx_fee'   => 0,
			'currency'     => $coin_type,
			'currency2'    => 'USDT',
			'address'      => $wallet_address,
			'auto_confirm' => 1,
			'note'         => $note,
		];
		$withdraw_process = $this->_coinpayments_api_call('create_withdrawal', $req);

		if ($withdraw_process['error'] != "ok") {
			$this->db->trans_rollback();
			$msg = $withdraw_process['error'];
			if ($withdraw_process['error'] == "That amount is larger than your balance!") {
				$msg = 'Sistem tidak dapat memproses penarikan Anda, dikarenakan nominal banyaknya antrian penarikan saat ini.<br>Silahkan beritahu admin mengenai kedala ini di email <a href="mailto:' . EMAIL_ADMIN_2 . '" target="_blank"><mark>' . EMAIL_ADMIN_2 . '</mark></a> atau tunggu maksimal 24 jam sesudahnya untuk admin memproses kedala tersebut.';
			}
			return show_error($msg, 500, "Telah terjadi kesalahan");
		}

		$tx_id    = $withdraw_process['result']['id'];
		$amount_2 = $withdraw_process['result']['amount'];

		$arr_invoice = $this->_generate_invoice();
		$invoice     = $arr_invoice['invoice'];
		$sequence    = $arr_invoice['sequence'];

		$where_fee = [
			'coin_type' => $coin_type
		];
		$arr_fee           = $this->M_core->get('coinpayment_fee', 'fee', $where_fee);
		$estimation_amount = $amount_2 - $arr_fee->row()->fee;

		$data_withdraw = [
			'invoice'        => $invoice,
			'sequence'       => $sequence,
			'id_member'      => $this->id_member,
			'amount_1'       => $amount,
			'amount_2'       => $estimation_amount,
			'currency_1'     => 'USDT',
			'currency_2'     => $coin_type,
			'source'         => $source,
			'id_wallet'      => $id_wallet,
			'wallet_label'   => $wallet_label,
			'wallet_address' => $wallet_address,
			'state'          => 'pending',
			'tx_id'          => $tx_id,
			'created_at'     => $this->datetime,
			'updated_at'     => $this->datetime,
			'deleted_at'     => null,
		];
		$exec_withdraw = $this->M_core->store('member_withdraw', $data_withdraw);

		if (!$exec_withdraw) {
			$this->db->trans_rollback();
			return show_error('Gagal untuk menyimpan data penarikan ke Database, silahkan coba kembali!', 500, "Telah terjadi kesalahan");
		}

		if ($source == "profit") {
			$exec_reduce = $this->M_withdraw->reduce_member_profit($this->id_member, $amount);
		} elseif ($source == "bonus") {
			$exec_reduce = $this->M_withdraw->reduce_member_bonus($this->id_member, $amount);
		}

		if (!$exec_reduce) {
			$this->db->trans_rollback();
			return show_error('Gagal untuk mengurasi nominal saldo member, silahkan coba kembali!', 500, "Telah terjadi kesalahan");
		}
		$this->db->trans_commit();

		redirect('withdraw/success/' . $tx_id);
	}

	protected function _send_alert_balance($coin_type, $amount): bool
	{
		$subject = APP_NAME . " | Peringatan Saldo " . strtoupper($coin_type);
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to(EMAIL_ADMIN);
		$this->email->subject($subject);

		$data['coin_type'] = $coin_type;
		$data['amount']    = $amount;
		$message           = $this->load->view('emails/alert_balance_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log(EMAIL_ADMIN, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	protected function _generate_invoice()
	{
		$sequence = $this->_get_new_sequence();
		$new_sequence = '';
		if ($sequence >= 0) {
			$new_sequence = "00000" . $sequence;
		} elseif ($sequence > 10) {
			$new_sequence = "0000" . $sequence;
		} elseif ($sequence > 100) {
			$new_sequence = "000" . $sequence;
		} elseif ($sequence > 1000) {
			$new_sequence = "00" . $sequence;
		} elseif ($sequence > 10000) {
			$new_sequence = "0" . $sequence;
		}

		$invoice = "WD-" . date('Ymd') . '-' . $new_sequence;
		$return = [
			'invoice'  => $invoice,
			'sequence' => $sequence,
		];
		return $return;
	}

	protected function _get_new_sequence()
	{
		$exec = $this->M_withdraw->latest_sequence();

		if ($exec->num_rows() > 0) {
			return $exec->row()->max_sequence + 1;
		}

		return 1;
	}

	public function success($tx_id)
	{
		$where = [
			'tx_id'      => $tx_id,
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member_withdraw', '*', $where);

		if ($arr->num_rows() == 0) {
			return show_error("Data Penarikan Tidak Ditemukan", 404, "Telah terjadi kesalahan");
		}

		$data = [
			'title'   => APP_NAME . ' | Permintaan Penarikan Berhasil',
			'content' => 'withdraw/success',
			'arr'     => $arr,
		];
		$this->template->render($data);
	}


	protected function _coinpayments_api_call($cmd, $req = array())
	{
		// Set the API command and required fields
		$req['version'] = 1;
		$req['cmd']     = $cmd;
		$req['key']     = $this->public_key;
		$req['format']  = 'json';

		// Generate the URL query string
		$post_data = http_build_query($req, '', '&');

		// Hash $post_data + $private_key
		$hmac = hash_hmac('sha512', $post_data, $this->private_key);

		// Create cURL handle and initialize
		$ch = NULL;
		$ch = curl_init($this->api_link);
		curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: ' . $hmac));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

		// Execute the call
		$data = curl_exec($ch);

		// Parse and return data if successful.
		if ($data !== FALSE) {
			if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
				// We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
				$result = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
			} else {
				$result = json_decode($data, TRUE);
			}
			if ($result !== NULL && count($result)) {
				return $result;
			} else {
				// If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
				return array('error' => 'Unable to parse JSON result (' . json_last_error_msg() . ')');
			}
		} else {
			return array('error' => 'cURL error: ' . curl_error($ch));
		}

		curl_close($ch);
	}
}
        
/* End of file  WithdrawController.php */
