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

	public function __construct()
	{
		parent::__construct();
		$this->date           = date('Y-m-d');
		$this->datetime       = date('Y-m-d H:i:s');
		$this->id_member      = $this->session->userdata(SESI . 'id');
		$this->email_member   = $this->session->userdata(SESI . 'email');
		$this->api_link       = 'https://www.coinpayments.net/api.php';
		$this->public_key     = '0d79d9c15454272a3ea638332ff716217b1530d57d2bb8023a0b5835a4c2c6bd';
		$this->private_key    = '90c986299927C62d1250999244da7fEF08263769818AA8875e90e446f5d78d30';
		$this->merchant_id    = '12d2c4c617ebe6fb9e401a92ed7039fd';
		$this->ipn_secret_key = 'YmlvbmVyIElQTg == ';
		$this->from           = EMAIL_ADMIN;
		$this->from_alias     = 'Admin Test';
		$this->ip_address     = $this->input->ip_address();
		$this->user_agent     = $this->input->user_agent();

		$this->load->library('L_member', null, 'template');
		$this->load->library('L_genuine_mail', null, 'genuine_mail');
		$this->load->helper(['cookie', 'string', 'Otp_helper', 'Domain_helper', 'Time_helper']);
		$this->load->model('M_withdraw');
		$this->load->model('M_dashboard');
		$this->load->model('M_log_send_email_member');
	}

	public function index()
	{
		$this->_unset_session();
		$arr    = $this->M_dashboard->get_member_balance($this->id_member);
		$profit = number_format($arr->row()->profit, 8);
		$bonus  = number_format($arr->row()->bonus, 8);

		$data = [
			'title'      => APP_NAME . ' | Withdraw',
			'content'    => 'withdraw/main',
			'vitamin_js' => 'withdraw/main_js',
			'profit'     => $profit,
			'bonus'      => $bonus,
		];
		$this->template->render($data);
	}

	public function otp()
	{
		$source         = $this->session->userdata(SESI . 'source');
		$amount         = $this->session->userdata(SESI . 'amount');
		$receive_coin   = $this->session->userdata(SESI . 'receive_coin');
		$id_wallet      = $this->session->userdata(SESI . 'id_wallet');
		$wallet_host    = $this->session->userdata(SESI . 'wallet_host');
		$wallet_address = $this->session->userdata(SESI . 'wallet_address');

		if (!isset($source) && !isset($amount) && !isset($receive_coin) && !isset($id_wallet) && !isset($wallet_host) && !isset($wallet_address)) {
			$this->_unset_session();
			redirect('withdraw');
			exit;
		}

		$arr_wallet = $this->get_arr_wallet($id_wallet);
		if ($arr_wallet === false) {
			return show_error("Wallet not found or has been updated, try again!", 404, "An Error was Encountered");
		}

		$data = [
			'title'          => APP_NAME . ' | Withdraw OTP',
			'content'        => 'withdraw/otp',
			'vitamin_js'     => 'withdraw/otp_js',
			'source'         => $source,
			'amount'         => $amount,
			'wallet_host'    => $wallet_host,
			'wallet_address' => $wallet_address,
		];
		$this->template->render($data);
	}

	public function _set_session($source, $amount, $receive_coin, $id_wallet, $wallet_host, $wallet_address)
	{
		$data_session = [
			SESI . 'source'         => $source,
			SESI . 'amount'         => $amount,
			SESI . 'receive_coin'   => $receive_coin,
			SESI . 'id_wallet'      => $id_wallet,
			SESI . 'wallet_host'    => $wallet_host,
			SESI . 'wallet_address' => $wallet_address,
		];
		$this->session->set_userdata($data_session);
	}

	public function _unset_session()
	{
		$data_session = [
			SESI . 'source',
			SESI . 'amount',
			SESI . 'receive_coin',
			SESI . 'id_wallet',
			SESI . 'wallet_source',
			SESI . 'wallet_address',
		];
		$this->session->unset_userdata($data_session);
	}

	public function auth()
	{
		$this->_unset_session();
		$arr    = $this->M_dashboard->get_member_balance($this->id_member);
		$profit = $arr->row()->profit;
		$bonus  = $arr->row()->bonus;

		$source       = $this->input->post('source');
		$amount       = $this->input->post('amount');
		$receive_coin = $this->input->post('receive_coin');
		$id_wallet    = $this->input->post('wallet_address');

		$code = 500;
		$msg  = "Can't Connect to Database, please try again!";

		if ($source == "profit") {
			if ($amount > $profit) {
				$msg  = "Insufficient Profit Balance";
			} else {
				$code = 200;
				$msg  = "Success";
			}
		} elseif ($source == "bonus") {
			if ($amount > $bonus) {
				$msg  = "Insufficient Bonus Balance";
			} else {
				$code = 200;
				$msg  = "Success";
			}
		}

		if ($code == 200) {
			$arr_wallet = $this->get_arr_wallet($id_wallet);
			if ($arr_wallet === false) {
				$code = 501;
				echo json_encode(['code' => $code, 'message' => "Wallet not found or has been updated, try again!"]);
				exit;
			}
			$this->_set_session($source, $amount, $receive_coin, $id_wallet, $arr_wallet->row()->wallet_host, $arr_wallet->row()->wallet_address);
			$this->_send_otp($this->id_member, $this->email_member);
		}

		echo json_encode(['code' => $code, 'message' => $msg]);
	}

	public function get_arr_wallet($id_wallet)
	{
		$where_wallet = [
			'id'         => $id_wallet,
			'id_member'  => $this->id_member,
			'deleted_at' => null,
		];
		$arr_wallet = $this->M_core->get('member_wallet', 'wallet_host, wallet_address', $where_wallet);

		if ($arr_wallet->num_rows() == 0) {
			return false;
		}

		return $arr_wallet;
	}

	public function _send_otp($id, $to): bool
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
		$amount       = $this->input->get('amount');
		$receive_coin = $this->input->get('receive_coin');

		$req = [
			'short' => 0,
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
			if ($receive_coin == "trx") {
				foreach ($exec['result']['TRX'] as $key => $val) {
					if ($key == "rate_btc") {
						$rate_x = $val;
					}

					if ($key == "tx_fee") {
						$tx_fee = $val;
					}
				}
			} elseif ($receive_coin == "bnb") {
				foreach ($exec['result']['BNB'] as $key => $val) {
					if ($key == "rate_btc") {
						$rate_x = $val;
					}

					if ($key == "tx_fee") {
						$tx_fee = $val;
					}
				}
			} elseif ($receive_coin == "ltct") {
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
				'result'    => number_format($result, 8) . " " . strtoupper($receive_coin),
				'amount'    => $amount,
				'rate_usdt' => $rate_usdt,
				'rate_x'    => $rate_x,
				'tx_fee'    => $tx_fee,
			]);
		}
	}

	public function _coinpayments_api_call($cmd, $req = array())
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

	public function generate_wallet_host()
	{
		$receive_coin = $this->input->get('receive_coin');

		$where = [
			'id_member'    => $this->id_member,
			'receive_coin' => $receive_coin,
			'deleted_at'   => null,
		];
		$arr = $this->M_core->get('member_wallet', '*', $where, 'updated_at', 'desc', null, 0, 'wallet_host');

		if ($arr->num_rows() == 0) {
			$code = 404;
			$data = [];
		} else {
			$code = 200;
			$data = $arr->result();
		}

		echo json_encode(['code' => $code, 'data' => $data]);
	}

	public function generate_wallet_address()
	{
		$wallet_host = $this->input->get('wallet_host');

		$where = [
			'id_member'   => $this->id_member,
			'wallet_host' => $wallet_host,
			'deleted_at'  => null,
		];
		$arr = $this->M_core->get('member_wallet', '*', $where, 'updated_at', 'desc');

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
		$receive_coin   = $this->session->userdata(SESI . 'receive_coin');
		$id_wallet      = $this->session->userdata(SESI . 'id_wallet');
		$wallet_host    = $this->session->userdata(SESI . 'wallet_host');
		$wallet_address = $this->session->userdata(SESI . 'wallet_address');

		$req = ['all' => 1];
		$get_coin_balance = $this->_coinpayments_api_call('balances', $req);

		if ($get_coin_balance['error'] != "ok") {
			$this->db->trans_rollback();
			return show_error('Failed to get Balances on Coinpayment. Please try again!', 500, "An Error Was Encountered");
		}

		$x        = strtoupper($receive_coin);
		$balancef = $get_coin_balance['result'][$x]['balancef'];
		if ($amount >= $balancef) {
			$this->_send_alert_balance($receive_coin, $amount);
			$this->db->trans_commit();
		}

		$note = "Withdraw from $source worth $amount USDT convert to " . strtoupper($receive_coin) . " to wallet address $wallet_address (" . strtoupper($wallet_host) . ")";

		$req = [
			'amount'       => $amount,
			'add_tx_fee'   => 0,
			'currency'     => $receive_coin,
			'currency2'    => 'usdt',
			'address'      => $wallet_address,
			'auto_confirm' => 1,
			'note'         => $note,
		];
		$withdraw_process = $this->_coinpayments_api_call('create_withdrawal', $req);

		if ($withdraw_process['error'] != "ok") {
			$this->db->trans_rollback();
			$msg = $withdraw_process['error'];
			if ($withdraw_process['error'] == "That amount is larger than your balance!") {
				$msg = "System cannot process your withdraw request, because Insufficient System Balance.<br>Please inform admin about this issue to <mark>" . EMAIL_ADMIN . "</mark>";
			}
			return show_error($msg, 500, "An Error Was Encountered");
		}

		$tx_id    = $withdraw_process['result']['id'];
		$amount_2 = $withdraw_process['result']['amount'];

		$arr_invoice = $this->_generate_invoice();
		$invoice     = $arr_invoice['invoice'];
		$sequence    = $arr_invoice['sequence'];

		$data_withdraw = [
			'invoice'        => $invoice,
			'sequence'       => $sequence,
			'id_member'      => $this->id_member,
			'amount_1'       => $amount,
			'amount_2'       => $amount_2,
			'currency_1'     => 'usdt',
			'currency_2'     => $receive_coin,
			'source'         => $source,
			'id_wallet'      => $id_wallet,
			'wallet_host'    => $wallet_host,
			'wallet_address' => $wallet_address,
			'state'          => 'pending',
			'tx_id'          => $tx_id,
			'created_at'     => $this->datetime,
			'updated_at'     => $this->datetime,
			'deleted_at'     => null,
		];
		$exec_withdraw = $this->M_core->store_uuid('member_withdraw', $data_withdraw);

		if (!$exec_withdraw) {
			$this->db->trans_rollback();
			return show_error('Failed to Store Withdrawal Data on Database. Please try again!', 500, "An Error Was Encountered");
		}

		if ($source == "profit") {
			$exec_reduce = $this->M_withdraw->reduce_member_profit($this->id_member, $amount);
		} elseif ($source == "bonus") {
			$exec_reduce = $this->M_withdraw->reduce_member_bonus($this->id_member, $amount);
		}

		if (!$exec_reduce) {
			$this->db->trans_rollback();
			return show_error('Failed to Reduce Member Balance on Database. Please try again!', 500, "An Error Was Encountered");
		}
		$this->db->trans_commit();

		redirect('withdraw/success/' . $tx_id);
	}

	public function _send_alert_balance($receive_coin, $amount): bool
	{
		$subject = APP_NAME . " | Alert Balance " . strtoupper($receive_coin);
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to(EMAIL_ADMIN);
		$this->email->subject($subject);

		$data['receive_coin'] = $receive_coin;
		$data['amount']       = $amount;
		$message = $this->load->view('emails/alert_balance_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log(EMAIL_ADMIN, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	public function _generate_invoice()
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

		$invoice = "W-" . date('Ymd') . '-' . $new_sequence;
		$return = [
			'invoice'  => $invoice,
			'sequence' => $sequence,
		];
		return $return;
	}

	public function _get_new_sequence()
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
			return show_error("Withdraw Data Not Found", 404, "An Error Was Encountered");
		}

		$data = [
			'title'   => APP_NAME . ' | Withdraw Request Done',
			'content' => 'withdraw/success',
			'arr'     => $arr,
		];
		$this->template->render($data);
	}
}
        
/* End of file  WithdrawController.php */
