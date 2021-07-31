<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TradeManagerController extends CI_Controller
{
	protected $date;
	protected $datetime;
	protected $api_link;
	protected $public_key;
	protected $private_key;
	protected $merchant_id;
	protected $ipn_secret_key;
	protected $from;
	protected $from_alias;
	protected $ip_address;
	protected $user_agent;
	protected $id_member;
	protected $member_email;
	protected $member_fullname;
	protected $csrf;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_member', null, 'template');
		$this->load->library('Nested_set', null, 'tree');
		$this->load->model('M_trade_manager');
		$this->load->model('M_log_send_email_member');
		$this->load->helper('Floating_helper');

		$this->date            = date('Y-m-d');
		$this->datetime        = date('Y-m-d H:i:s');
		$this->api_link        = CP_API_LINK;
		$this->public_key      = CP_PUB_KEY;
		$this->private_key     = CP_PRV_KEY;
		$this->merchant_id     = CP_MERCH_ID;
		$this->ipn_secret_key  = CP_IPN_SEC_KEY;
		$this->id_member       = $this->session->userdata(SESI . 'id');
		$this->member_email    = $this->session->userdata(SESI . 'email');
		$this->member_fullname = $this->session->userdata(SESI . 'fullname');

		$this->from       = EMAIL_ADMIN;
		$this->from_alias = EMAIL_ALIAS;
		$this->ip_address = $this->input->ip_address();
		$this->user_agent = $this->input->user_agent();

		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		$this->tree->setControlParams('tree', 'lft', 'rgt', 'id_member', 'id_upline', 'email');
	}


	public function index()
	{
		$data_trade_manager = $this->M_trade_manager->get_member_trade_manager($this->id_member);
		$data = [
			'title'              => APP_NAME . ' | Trade Manager Kamu',
			'content'            => 'trade_manager/main',
			'vitamin_js'         => 'trade_manager/main_js',
			'data_trade_manager' => $data_trade_manager,
			'csrf'               => $this->csrf,
		];
		$this->template->render($data);
	}

	public function detail()
	{
		header('Content-Type: application/json');
		$code    = 200;
		$invoice = $this->input->get('invoice');

		if ($invoice == null) {
			$msg = "Invoice Not Found";
			echo json_encode(['code' => 404, 'msg' => $msg]);
			exit;
		}

		$data_trade_manager = $this->M_trade_manager->get_member_trade_manager(null, $invoice);

		if (count($data_trade_manager) == 0) {
			$msg = "Invoice Not Found";
			echo json_encode(['code' => 404, 'msg' => $msg]);
			exit;
		}

		$return = [];
		foreach ($data_trade_manager as $key) {
			$package                   = $key['package'];
			$amount                    = $key['amount'];
			$profit_per_day            = $key['profit_per_day'];
			$state                     = $key['state'];
			$created_at                = $key['created_at'];
			$expired_at                = $key['expired_at'];
			$is_extend                 = $key['is_extend'];
			$payment_method            = $key['payment_method'];
			$txn_id                    = $key['txn_id'];
			$amount_transfer           = $key['amount_transfer'];
			$profit_montly_percentage  = $key['profit_montly_percentage'];
			$profit_montly_value       = $key['profit_montly_value'];
			$profit_self_percentage    = $key['profit_self_percentage'];
			$profit_self_value         = $key['profit_self_value'];
			$profit_upline_percentage  = $key['profit_upline_percentage'];
			$profit_upline_value       = $key['profit_upline_value'];
			$profit_company_percentage = $key['profit_company_percentage'];
			$profit_company_value      = $key['profit_company_value'];

			$return = [
				'package'                   => $package,
				'amount'                    => $amount,
				'profit_per_day'            => $profit_per_day,
				'state'                     => $state,
				'created_at'                => $created_at,
				'expired_at'                => $expired_at,
				'is_extend'                 => $is_extend,
				'payment_method'            => $payment_method,
				'txn_id'                    => $txn_id,
				'amount_transfer'           => $amount_transfer,
				'profit_montly_percentage'  => $profit_montly_percentage,
				'profit_montly_value'       => $profit_montly_value,
				'profit_self_percentage'    => $profit_self_percentage,
				'profit_self_value'         => $profit_self_value,
				'profit_upline_percentage'  => $profit_upline_percentage,
				'profit_upline_value'       => $profit_upline_value,
				'profit_company_percentage' => $profit_company_percentage,
				'profit_company_value'      => $profit_company_value,
			];
		}

		echo json_encode([
			'code'   => $code,
			'result' => $return,
		]);
	}

	public function add()
	{
		$arr = $this->M_trade_manager->get_package();

		$arr_bg_color = [
			'black',
			'lightblue',
			'red',
			'green',
			'yellow',
			'light',
		];

		$where_member_trade_manager = ['id_member' => $this->id_member];
		$arr_member_trade_manager   = $this->M_core->get('member_trade_manager', 'id_package, state', $where_member_trade_manager);

		$arr_state = [
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
		];

		if ($arr_member_trade_manager->num_rows() > 0) {
			foreach ($arr_member_trade_manager->result() as $key) {
				if ($key->id_package == 1) {
					if (in_array($key->state, ['active'])) {
						$arr_state[0] = '1';
					} elseif (in_array($key->state, ['waiting payment', 'pending', 'inactive', 'expired'])) {
						$arr_state[0] = '2';
					}
				}

				if ($key->id_package == 2) {
					if (in_array($key->state, ['active'])) {
						$arr_state[1] = '1';
					} elseif (in_array($key->state, ['waiting payment', 'pending', 'inactive', 'expired'])) {
						$arr_state[1] = '2';
					}

					for ($x = 0; $x <= 1; $x++) {
						$arr_state[$x] = '2';
					}
				}

				if ($key->id_package == 3) {
					if (in_array($key->state, ['active'])) {
						$arr_state[2] = '1';
					} elseif (in_array($key->state, ['waiting payment', 'pending', 'inactive', 'expired'])) {
						$arr_state[2] = '2';
					}

					for ($x = 0; $x <= 2; $x++) {
						$arr_state[$x] = '2';
					}
				}

				if ($key->id_package == 4) {
					if (in_array($key->state, ['active'])) {
						$arr_state[3] = '1';
					} elseif (in_array($key->state, ['waiting payment', 'pending', 'inactive', 'expired'])) {
						$arr_state[3] = '2';
					}

					for ($x = 0; $x <= 3; $x++) {
						$arr_state[$x] = '2';
					}
				}

				if ($key->id_package == 5) {
					if (in_array($key->state, ['active'])) {
						$arr_state[4] = '1';
					} elseif (in_array($key->state, ['waiting payment', 'pending', 'inactive', 'expired'])) {
						$arr_state[4] = '2';
					}

					for ($x = 0; $x <= 4; $x++) {
						$arr_state[$x] = '2';
					}
				}

				if ($key->id_package == 6) {
					if (in_array($key->state, ['active'])) {
						$arr_state[5] = '1';
					} elseif (in_array($key->state, ['waiting payment', 'pending', 'inactive', 'expired'])) {
						$arr_state[5] = '2';
					}

					for ($x = 0; $x <= 5; $x++) {
						$arr_state[$x] = '2';
					}
				}
			}
		}

		$data = [
			'title'        => APP_NAME . ' | List Paket Trade Manager',
			'content'      => 'trade_manager/add',
			'vitamin_js'   => 'trade_manager/add_js',
			'arr'          => $arr,
			'arr_bg_color' => $arr_bg_color,
			'arr_state'    => $arr_state,
			'csrf'         => $this->csrf,
		];
		$this->template->render($data);
	}

	public function pick($id_konfigurasi_trade_manager = null)
	{
		if ($id_konfigurasi_trade_manager == null) {
			return show_404();
		}

		$id_konfigurasi_trade_manager = str_replace(UYAH, '', base64_decode($id_konfigurasi_trade_manager));

		$where                    = ['id' => $id_konfigurasi_trade_manager];
		$id_package_trade_manager = $this->M_core->get('konfigurasi_trade_manager', 'id_package_trade_manager', $where)->row()->id_package_trade_manager;

		$where_check = [
			'id_member' 	=> $this->id_member,
			'id_package >' 	=> $id_package_trade_manager,
			'state !=' 		=> 'cancel',
			'deleted_at' 	=> null,
		];
		$arr_check = $this->M_core->get('member_trade_manager', '*', $where_check);

		if ($arr_check->num_rows() > 0) {
			return show_error("Tidak dapat memilih paket yang nilai investasinya lebih rendah dari paket yang telah aktif", 503, "Terjadi Kesalahan...");
		}

		$where_check = [
			'id_member'  => $this->id_member,
			'id_package' => $id_package_trade_manager,
			'deleted_at' => null,
		];
		$arr_check = $this->M_core->get('member_trade_manager', '*', $where_check);

		if ($arr_check->num_rows() > 0) {
			foreach ($arr_check->result() as $key) {
				$state = $key->state;

				if (in_array($state, ['waiting payment', 'pending'])) {
					return show_error("Paket ini tidak dapat dipilih dikarenakan masih menunggu proses pembayaran / verifikasi pembayaran oleh sistem", 503, "Terjadi Kesalahan...");
				}
			}
		}

		$arr = $this->M_trade_manager->get_package($id_konfigurasi_trade_manager);

		$data = [
			'title'                        => APP_NAME . ' | Pilih Paket Trade Manager',
			'content'                      => 'trade_manager/pick',
			'vitamin_js'                   => 'trade_manager/pick_js',
			'id_package_trade_manager'     => base64_encode(UYAH . $id_package_trade_manager),
			'id_konfigurasi_trade_manager' => base64_encode(UYAH . $id_konfigurasi_trade_manager),
			'arr'                          => $arr,
			'csrf'                         => $this->csrf,
		];
		$this->template->render($data);
	}

	public function checkout_coinpayment()
	{
		$this->db->trans_begin();

		$id_member       = $this->id_member;
		$member_email    = $this->member_email;
		$member_fullname = $this->member_fullname;
		$id_package      = str_replace(UYAH, '', base64_decode($this->input->post('id_package_trade_manager')));
		$id_config       = str_replace(UYAH, '', base64_decode($this->input->post('id_konfigurasi_trade_manager')));
		$coin_type       = $this->input->post('coin_type');

		$where_check = [
			'id_member' 	=> $this->session->userdata(SESI . 'id'),
			'id_package >' 	=> $id_package,
			'state !=' 		=> 'cancel',
			'state !=' 		=> 'expired',
			'deleted_at' 	=> null,
		];
		$arr_check = $this->M_core->get('member_trade_manager', '*', $where_check);

		if ($arr_check->num_rows() > 0) {
			return show_error("Tidak dapat memilih paket yang nilai investasinya lebih rendah dari paket yang telah aktif", 503, "Terjadi Kesalahan...");
		}

		$where_check = [
			'id_member'  => $this->session->userdata(SESI . 'id'),
			'id_package' => $id_package,
			'deleted_at' => null,
		];
		$arr_check = $this->M_core->get('member_trade_manager', '*', $where_check);

		if ($arr_check->num_rows() > 0) {
			foreach ($arr_check->result() as $key) {
				$state = $key->state;

				if (in_array($state, ['waiting payment', 'pending'])) {
					return show_error("Paket ini tidak dapat dipilih dikarenakan masih menunggu proses pembayaran / verifikasi pembayaran oleh sistem", 503, "Terjadi Kesalahan...");
				}
			}
		}

		$current_date_object = new DateTime($this->date);
		$expired_package     = $current_date_object->modify('+365 day')->format('Y-m-d');

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

		$invoice = "TM-" . date('Ymd') . '-' . $new_sequence;

		$arr_package = $this->M_trade_manager->get_package($id_config);

		if (count($arr_package) == 0) {
			return show_error("Paket tidak ditemukan", 404, "Terjadi Kesalahan");
		}

		$amount                    = $arr_package[0]['amount'];
		$package_code              = $arr_package[0]['code'];
		$package_name              = $arr_package[0]['name'];
		$contract_duration         = $arr_package[0]['contract_duration'];
		$profit_per_month_percent  = $arr_package[0]['profit_per_month_percent'];
		$profit_per_month_value    = $arr_package[0]['profit_per_month_value'];
		$profit_per_day_percentage = $arr_package[0]['profit_per_day_percentage'];
		$profit_per_day_value      = $arr_package[0]['profit_per_day_value'];
		$share_self_percentage     = $arr_package[0]['share_self_percentage'];
		$share_self_value          = $arr_package[0]['share_self_value'];
		$share_upline_percentage   = $arr_package[0]['share_upline_percentage'];
		$share_upline_value        = $arr_package[0]['share_upline_value'];
		$share_company_percentage  = $arr_package[0]['share_company_percentage'];
		$share_company_value       = $arr_package[0]['share_company_value'];

		if ($id_package == 6) {
			$amount                 = $this->input->post('total_transfer');
			$profit_per_month_value = ($amount * $profit_per_month_percent) / 100;
			$profit_per_day_value   = ($amount * $profit_per_day_percentage) / 100;
			$share_self_value       = ($profit_per_day_value * $share_self_percentage) / 100;
			$share_upline_value     = ($profit_per_day_value * $share_upline_percentage) / 100;
			$share_company_value    = ($profit_per_day_value * $share_company_percentage) / 100;
		}

		$data_member_package = [
			'invoice'                   => $invoice,
			'sequence'                  => $sequence,
			'payment_method'            => 'coinpayment',
			'id_member'                 => $id_member,
			'member_fullname'           => $member_fullname,
			'member_email'              => $member_email,
			'id_package'                => $id_package,
			'id_konfigurasi'            => $id_config,
			'package_code'              => $package_code,
			'package_name'              => $package_name,
			'receiver_wallet_address'   => null,
			'txn_id'                    => null,
			'amount_1'                  => $amount,
			'amount_2'                  => 0,
			'currency1'                 => 'USDT',
			'currency2'                 => $coin_type,
			'state'                     => 'waiting payment',
			'timeout'                   => 0,
			'qrcode_url'                => null,
			'status_url'                => null,
			'checkout_url'              => null,
			'expired_package'           => $expired_package,
			'expired_payment'           => null,
			'is_qualified'              => 'no',
			'is_royalty'                => 'no',
			'is_extend'                 => 'auto',
			'profit_per_month_percent'  => $profit_per_month_percent,
			'profit_per_month_value'    => $profit_per_month_value,
			'profit_per_day_percentage' => $profit_per_day_percentage,
			'profit_per_day_value'      => $profit_per_day_value,
			'share_self_percentage'     => $share_self_percentage,
			'share_self_value'          => $share_self_value,
			'share_upline_percentage'   => $share_upline_percentage,
			'share_upline_value'        => $share_upline_value,
			'share_company_percentage'  => $share_company_percentage,
			'share_company_value'       => $share_company_value,
			'created_at'                => $this->datetime,
			'updated_at'                => $this->datetime,
			'deleted_at'                => null,
		];
		$exec = $this->M_core->store('member_trade_manager', $data_member_package);

		if (!$exec) {
			$this->db->trans_rollback();
			return show_error("Tidak terhubung dengan database", 500, "Terjadi Kesalahan");
		}

		$data_package = [
			'amount'          => $amount,
			'coin_type'       => $coin_type,
			'member_email'    => $member_email,
			'member_fullname' => $member_fullname,
			'package_name'    => $package_name,
			'package_code'    => $package_code,
			'invoice'         => $invoice,
		];

		$exec = $this->_create_transaction($data_package);

		if ($exec['code'] == 500) {
			$this->db->trans_rollback();
			return show_error($exec['error'], 500, "Terjadi Kesalahan");
		}

		$txn_id                  = $exec['data']['txn_id'];
		$amount_coin             = $exec['data']['amount'];
		$timeout                 = $exec['data']['timeout'];
		$receiver_wallet_address = $exec['data']['address'];
		$qrcode_url              = $exec['data']['qrcode_url'];
		$checkout_url            = $exec['data']['checkout_url'];
		$status_url              = $exec['data']['status_url'];
		$expired_payment_obj     = new DateTime($this->datetime);
		$expired_payment         = $expired_payment_obj->modify('+' . $timeout . ' second')->format("Y-m-d H:i:s");

		$data = [
			'txn_id'                  => $txn_id,
			'amount_2'                => $amount_coin,
			'receiver_wallet_address' => $receiver_wallet_address,
			'timeout'                 => $timeout,
			'expired_payment'         => $expired_payment,
			'qrcode_url'              => $qrcode_url,
			'checkout_url'            => $checkout_url,
			'status_url'              => $status_url,
		];
		$exec = $this->M_core->update('member_trade_manager', $data, ['invoice' => $invoice]);

		if (!$exec) {
			$this->db->trans_rollback();
			return show_error("Tidak terhubung dengan database", 500, "Terjadi Kesalahan");
		}

		$where_log = [
			'id_member' => $id_member,
			'invoice'   => $invoice,
		];
		$arr_log = $this->M_core->get('log_member_trade_manager', '*', $where_log);

		if ($arr_log->num_rows() == 0) {
			$data_log = [
				'id_member'         => $id_member,
				'invoice'           => $invoice,
				'amount_invest'     => $amount,
				'amount_transfer'   => $amount_coin,
				'currency_transfer' => $coin_type,
				'txn_id'            => $txn_id,
				'state'             => 'waiting payment',
				'description'       => "[$this->datetime] Member $member_email Pick Package $package_name. Waiting for Payment Transfer",
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_member_trade_manager', $data_log);
		} else {
			$data_log = [
				'state'       => 'waiting payment',
				'description' => "[$this->datetime] Member $member_email Memilih Paket $package_name. Menunggu pembayaran",
				'updated_at'  => $this->datetime,
			];
			$this->M_core->update('log_member_trade_manager', $data_log, $where_log);
		}

		$this->db->trans_commit();

		redirect('trade_manager/checkout/' . base64_encode(UYAH . $invoice));
	}

	protected function _create_transaction($data)
	{
		$req['amount']      = $data['amount'];
		$req['currency1']   = 'USDT';
		$req['currency2']   = $data['coin_type'];
		$req['buyer_email'] = $data['member_email'];
		$req['buyer_name']  = $data['member_fullname'];
		$req['item_name']   = $data['package_name'];
		$req['item_number'] = $data['package_code'];
		$req['invoice']     = $data['invoice'];
		$req['custom']      = 'trade_manager';
		$req['ipn_url']     = site_url('coinpayment/ipn/trade_manager/' . $data['invoice']);
		$req['success_url'] = site_url('coinpayment/success/' . $data['invoice']);
		$req['cance_url']   = site_url('coinpayment/cancel/' . $data['invoice']);

		$exec = $this->_coinpayments_api_call('create_transaction', $req);

		if ($exec['error'] == "ok") {
			$code = 200;
		} else {
			$code = 500;
		}

		$result = [
			'code'  => $code,
			'data'  => $exec['result'],
			'error' => $exec['error'],
		];

		return $result;
	}

	protected function _get_new_sequence()
	{
		$exec = $this->M_trade_manager->latest_sequence();

		if ($exec->num_rows() > 0) {
			return $exec->row()->max_sequence + 1;
		}

		return 1;
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
		$ch = curl_init('https://www.coinpayments.net/api.php');
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

	public function checkout($invoice)
	{
		$invoice = str_replace(UYAH, '', base64_decode($invoice));

		$where = ['invoice' => $invoice];
		$arr   = $this->M_core->get('member_trade_manager', '*', $where);

		if ($arr->num_rows() == 0) {
			return show_error("Invoice Tidak Ditemukan", 404, "Terjadi Kesalahan");
		}

		$state = $arr->row()->state;

		$time_left = 0;

		if ($state == "waiting payment") {
			$time_left_obj = new DateTime($arr->row()->created_at);
			$time_left     = $time_left_obj->modify('+' . $arr->row()->timeout . ' seconds')->format('Y-m-d H:i:s');
			$badge_color   = 'info';
			$badge_text    = 'Menunggu Pembayaran';
		} elseif ($state == "pending") {
			$time_left_obj = new DateTime($arr->row()->created_at);
			$time_left     = $time_left_obj->modify('+' . $arr->row()->timeout . ' seconds')->format('Y-m-d H:i:s');
			$badge_color   = 'secondary';
			$badge_text    = 'Pembayaran Sedang Diproses';
		} elseif ($state == "active") {
			$badge_color = 'success';
			$badge_text  = 'Pembayaran Berhasil';
		} elseif ($state == "inactive") {
			$badge_color = 'dark';
			$badge_text  = 'Tidak Aktif';
		} elseif ($state == "cancel") {
			$badge_color = 'warning';
			$badge_text  = 'Transaksi Dibatalkan';
		} elseif ($state == "expired") {
			$badge_color = 'danger';
			$badge_text  = 'Pembayaran Melewati Batas Waktu';
		}

		$state_badge = '<span class="badge badge-' . $badge_color . '">' . strtoupper($badge_text) . '</span>';

		$data = [
			'title'       => APP_NAME . ' | Checkout',
			'content'     => 'trade_manager/checkout',
			'vitamin_js'  => 'trade_manager/checkout_js',
			'arr'         => $arr,
			'time_left'   => $time_left,
			'state'       => $state,
			'state_badge' => $state_badge,
			'csrf'        => $this->csrf,
		];
		$this->template->render($data);
	}

	protected function _update_qualified($id_member, $id_upline, $amount_usd, $invoice, $id_package, $item_name)
	{

		$member_is_qualified = "no";

		$arr_member      = $this->M_core->get('member', 'email, fullname', ['id' => $id_member]);
		$email_member    = $arr_member->row()->email;
		$fullname_member = $arr_member->row()->fullname;

		$arr_ql_sibling = $this->M_trade_manager->get_ql_sibling($id_member, $id_upline);

		if ($arr_ql_sibling->num_rows() > 0) {
			$invoice_ql_sibling     = $arr_ql_sibling->row()->invoice;
			$id_member_ql_sibling   = $arr_ql_sibling->row()->id_member;
			$amount_usd_ql_sibling  = $arr_ql_sibling->row()->amount_usd;
			$id_package_ql_sibling  = $arr_ql_sibling->row()->id_package;
			$item_name_ql_sibling   = $arr_ql_sibling->row()->item_name;
			$buyer_email_ql_sibling = $arr_ql_sibling->row()->buyer_email;
			$buyer_name_ql_sibling  = $arr_ql_sibling->row()->buyer_name;

			$bonus_grand_upline             = ($amount_usd * 5) / 100;
			$amount_usd_ql_sibling_as_bonus = ($amount_usd_ql_sibling * 5) / 100;
			$new_bonus_grand_upline         = $bonus_grand_upline + $amount_usd_ql_sibling_as_bonus;

			if ($new_bonus_grand_upline > 0) {

				$arr_grand_upline       = $this->M_core->get('member', 'id_upline, email, fullname, is_active', ['id' => $id_upline]);
				$id_grand_upline        = $arr_grand_upline->row()->id_upline;
				$email_grand_upline     = $arr_grand_upline->row()->email;
				$fullname_grand_upline  = $arr_grand_upline->row()->fullname;
				$is_active_grand_upline = $arr_grand_upline->row()->is_active;

				if ($arr_grand_upline->num_rows() > 0) {

					if ($id_grand_upline != null) {

						if ($is_active_grand_upline == "yes") {
							$this->M_trade_manager->update_member_bonus($id_grand_upline, $new_bonus_grand_upline);

							$desc_log_member1 = "$fullname_grand_upline ($email_grand_upline) get bonus royalty of member $fullname_member ($email_member) $bonus_grand_upline USDT";

							$desc_log_member2 = "$fullname_grand_upline ($email_grand_upline) get bonus royalty of member $buyer_name_ql_sibling ($buyer_email_ql_sibling) $amount_usd_ql_sibling_as_bonus USDT";
						} else {
							$this->M_trade_manager->update_unknown_balance($new_bonus_grand_upline);

							$desc_log_member1 = "Unknown Balance get bonus royalty of member $fullname_member ($email_member) $bonus_grand_upline USDT";

							$desc_log_member2 = "Unknown Balance get bonus royalty of member $buyer_name_ql_sibling ($buyer_email_ql_sibling) $amount_usd_ql_sibling_as_bonus USDT";
						}

						$data_update_member_trade_manager  = ['is_qualified' => 'yes', 'updated_at' => $this->datetime];
						$where_update_member_trade_manager = ['invoice'      => $invoice_ql_sibling];
						$this->M_core->update('member_trade_manager', $data_update_member_trade_manager, $where_update_member_trade_manager);

						$data_log1 = [
							'id_member'      => $id_grand_upline,
							'id_downline'    => $id_member,
							'type_package'   => 'trade manager',
							'invoice'        => $invoice,
							'id_package'     => $id_package,
							'package_name'   => $item_name,
							'package_amount' => $bonus_grand_upline,
							'state'          => 'get bonus',
							'description'    => $desc_log_member1,
							'created_at'     => $this->datetime,
						];
						$this->M_core->store_uuid('log_bonus_qualification_level', $data_log1);

						$data_log2 = [
							'id_member'      => $id_grand_upline,
							'id_downline'    => $id_member_ql_sibling,
							'type_package'   => 'trade manager',
							'invoice'        => $invoice_ql_sibling,
							'id_package'     => $id_package_ql_sibling,
							'package_name'   => $item_name_ql_sibling,
							'package_amount' => $amount_usd_ql_sibling_as_bonus,
							'state'          => 'get bonus',
							'description'    => $desc_log_member2,
							'created_at'     => $this->datetime,
						];
						$this->M_core->store_uuid('log_bonus_qualification_level', $data_log2);

						$member_is_qualified = "yes";
					}
				}
			}
		}

		return $member_is_qualified;
	}

	protected function _update_royalty($id_member, $amount_usd, $invoice, $id_package, $item_name)
	{
		$member_is_royalty = "no";

		$arr_member      = $this->M_core->get('member', 'fullname, email', ['id' => $id_member]);
		$fullname_member = $arr_member->row()->fullname;
		$email_member    = $arr_member->row()->email;

		$arr_self_tree = $this->M_core->get('et_tree', 'lft, rgt, depth', ['id_member' => $id_member]);
		$lft           = $arr_self_tree->row()->lft;
		$rgt           = $arr_self_tree->row()->rgt;
		$depth         = $arr_self_tree->row()->depth;

		$arr_generation = $this->M_core->get('et_tree', '*', ['depth <' => $depth, 'lft <' => $lft, 'rgt >' => $rgt], 'depth', 'desc', 10);

		if ($arr_generation->num_rows() > 1) {
			$itteration_gen = 0;
			foreach ($arr_generation->result() as $key_gen) {
				$id_gen       = $key_gen->id_member;

				$arr_gen       = $this->M_core->get('member', 'fullname, email, is_active', ['id' => $id_gen, 'deleted_at' => null]);
				$fullname_gen  = $arr_gen->row()->fullname;
				$email_gen     = $arr_gen->row()->email;
				$is_active_gen = $arr_gen->row()->is_active;

				$array_group_1 = [1];
				$array_group_2 = [2, 3, 4, 5, 6];
				$array_group_3 = [7, 8, 9, 10];

				$array_group = array_merge($array_group_1, $array_group_2, $array_group_3);

				if (in_array($itteration_gen, $array_group)) {
					if (in_array($itteration_gen, $array_group_1)) {
						$bonus_royalty = ($amount_usd * 3) / 100;
					} elseif (in_array($itteration_gen, $array_group_2)) {
						$bonus_royalty = ($amount_usd * 1) / 100;
					} elseif (in_array($itteration_gen, $array_group_3)) {
						$bonus_royalty = ($amount_usd * 0.5) / 100;
					}

					if ($is_active_gen == "yes") {
						$this->M_trade_manager->update_member_bonus($id_gen, $bonus_royalty);

						$id_member_log = $id_gen;
						$desc_log = "$fullname_gen ($email_gen) get bonus royalty of member $fullname_member ($email_member) $bonus_royalty USDT";
					} else {
						$this->M_trade_manager->update_unknown_bonus($bonus_royalty);

						$id_member_log = null;
						$desc_log = "Unknown Balance get bonus royalty of member $fullname_member ($email_member) $bonus_royalty USDT";
					}

					$data_log = [
						'id_member'      => $id_member_log,
						'id_downline'    => $id_member,
						'type_package'   => 'trade manager',
						'invoice'        => $invoice,
						'id_package'     => $id_package,
						'package_name'   => $item_name,
						'package_amount' => $bonus_royalty,
						'state'          => 'get bonus',
						'description'    => $desc_log,
						'created_at'     => $this->datetime,
					];
					$this->M_core->store_uuid('log_bonus_royalty', $data_log);
				}
				$itteration_gen++;
			}

			$data_update_member_trade_manager  = ['is_royalty' => 'yes', 'updated_at' => $this->datetime];
			$where_update_member_trade_manager = ['invoice'    => $invoice];
			$this->M_core->update('member_trade_manager', $data_update_member_trade_manager, $where_update_member_trade_manager);

			$member_is_royalty = "yes";
		}

		return $member_is_royalty;
	}

	public function _send_package_active($id, $to, $invoice, $item_name): bool
	{
		$subject = APP_NAME . " | $invoice - Package $item_name Active";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data['arr_data'] = $this->M_core->get('member_trade_manager', '*', ['id_member' => $id]);
		$message = $this->load->view('emails/package_active_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	protected function _update_omset($id_member, $amount_usd)
	{
		$where_member = ['id_member' => $id_member];
		$arr_member   = $this->M_core->get('tree', 'lft, rgt', $where_member);
		$lft          = $arr_member->row()->lft;
		$rgt          = $arr_member->row()->rgt;

		// update omset self start
		$exec = $this->M_trade_manager->update_total_omset($id_member, $amount_usd);
		if (!$exec) {
			return false;
		}
		// update omset self end

		$where_upline = [
			'lft < ' => $lft,
			'rgt > ' => $rgt,
		];
		$arr_upline = $this->M_core->get('tree', 'id_member as id_upline', $where_upline);

		if ($arr_upline->num_rows() > 0) {
			foreach ($arr_upline->result() as $key_upline) {
				$id_upline = $key_upline->id_upline;

				$where_info = [
					'id'         => $id_upline,
					'is_active'  => 'yes',
					'deleted_at' => null,
				];
				$arr_info = $this->M_core->get('member', 'id as id_x', $where_info);

				if ($arr_info->num_rows() > 0) {
					foreach ($arr_info->result() as $key_info) {
						$id_x = $key_info->id_x;
						$exec2 = $this->M_trade_manager->update_total_omset($id_x, $amount_usd);

						if (!$exec2) {
							return false;
						}
					}
				}
			}
		}

		return true;
	}

	public function update_extend()
	{
		$invoice   = $this->input->post('invoice_extend');
		$is_extend = $this->input->post('is_extend_mode');

		$where_count = [
			'id_member' => $this->id_member,
			'invoice' => $invoice,
		];
		$arr_check = $this->M_core->get('member_trade_manager', '*', $where_count);

		if ($arr_check->num_rows() == 0) {
			echo json_encode(['code' => 404, 'status_text' => "Invoice Not Found"]);
			exit;
		}

		$current_obj = new DateTime('now');
		$expired_obj = new DateTime($arr_check->row()->expired_at);
		$diff        = $current_obj->diff($expired_obj);

		if ($diff->format('%R') == "-") {
			echo json_encode(['code' => 500, 'status_text' => "Package Expired"]);
			exit;
		}

		$data = ['is_extend' => $is_extend];
		$exec = $this->M_core->update('member_trade_manager', $data, $where_count);

		if (!$exec) {
			echo json_encode(['code' => 500, 'status_text' => "Update Failed, please try again!"]);
			exit;
		}

		echo json_encode(['code' => 200, 'status_text' => "Update Success"]);
	}
}
        
/* End of file  TradeManagerController.php */
