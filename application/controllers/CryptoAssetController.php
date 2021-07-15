<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CryptoAssetController extends CI_Controller
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
	protected $to;
	protected $ip_address;
	protected $user_agent;
	protected $id_member;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_member', null, 'template');
		$this->load->library('Nested_set', null, 'tree');
		$this->load->model('M_crypto_asset');
		$this->load->model('M_log_send_email_member');

		$this->date 			= date('Y-m-d');
		$this->datetime 		= date('Y-m-d H:i:s');
		$this->api_link 		= 'https://www.coinpayments.net/api.php';
		$this->public_key 		= '0d79d9c15454272a3ea638332ff716217b1530d57d2bb8023a0b5835a4c2c6bd';
		$this->private_key 		= '90c986299927C62d1250999244da7fEF08263769818AA8875e90e446f5d78d30';
		$this->merchant_id 		= '12d2c4c617ebe6fb9e401a92ed7039fd';
		$this->ipn_secret_key 	= 'YmlvbmVyIElQTg==';
		$this->id_member        = $this->session->userdata(SESI . 'id');

		$this->from       = 'adam.pm59@gmail.com';
		$this->from_alias = 'Admin Test';
		$this->to         = 'adam.pm77@gmail.com';
		$this->ip_address = $this->input->ip_address();
		$this->user_agent = $this->input->user_agent();

		$this->tree->setControlParams('tree', 'lft', 'rgt', 'id_member', 'id_upline', 'email');
	}


	public function index()
	{
		$data_crypto_asset = $this->M_crypto_asset->get_member_crypto_asset($this->id_member);
		$data = [
			'title'             => APP_NAME . ' | List Crypto Asset',
			'content'           => 'crypto_asset/main',
			'vitamin_js'        => 'crypto_asset/main_js',
			'data_crypto_asset' => $data_crypto_asset,
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

		$data_crypto_asset = $this->M_crypto_asset->get_member_crypto_asset(null, $invoice);

		if (count($data_crypto_asset) == 0) {
			$msg = "Invoice Not Found";
			echo json_encode(['code' => 404, 'msg' => $msg]);
			exit;
		}

		$return = [];
		foreach ($data_crypto_asset as $key) {
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
		$where = [
			'is_active' => 'yes',
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('package_crypto_asset', '*', $where);

		$arr_bg_color = [
			'black',
			'lightblue',
			'red',
			'green',
			'yellow',
		];

		$where_member_crypto_asset = ['id_member' => $this->session->userdata(SESI . 'id')];
		$arr_member_crypto_asset   = $this->M_core->get('member_crypto_asset', 'id_package, state', $where_member_crypto_asset);

		$arr_state = [
			'0',
			'0',
			'0',
			'0',
			'0',
			'0',
		];

		if ($arr_member_crypto_asset->num_rows() > 0) {
			foreach ($arr_member_crypto_asset->result() as $key) {
				if ($key->id_package == 1) {
					for ($x = 0; $x < 6; $x++) {
						$arr_state[$x] = '0';
					}
				}

				if ($key->id_package == 2) {
					for ($x = 0; $x < 1; $x++) {
						if ($arr_state[$x] != '1') {
							$arr_state[$x] = '2';
						}
					}
				}

				if ($key->id_package == 3) {
					for ($x = 0; $x < 2; $x++) {
						if ($arr_state[$x] != '1') {
							$arr_state[$x] = '2';
						}
					}
				}

				if ($key->id_package == 4) {
					for ($x = 0; $x < 3; $x++) {
						if ($arr_state[$x] != '1') {
							$arr_state[$x] = '2';
						}
					}
				}

				if ($key->id_package == 5) {
					for ($x = 0; $x < 4; $x++) {
						if ($arr_state[$x] != '1') {
							$arr_state[$x] = '2';
						}
					}
				}

				if ($key->id_package == 6) {
					for ($x = 0; $x < 5; $x++) {
						if ($arr_state[$x] != '1') {
							$arr_state[$x] = '2';
						}
					}
				}

				if (in_array($key->state, ['active', 'waiting payment', 'pending'])) {
					$arr_state[$key->id_package - 1] = '1';
				}
			}
		}

		$data = [
			'title'        => APP_NAME . ' | Add Crypto Asset',
			'content'      => 'crypto_asset/add',
			'vitamin_js'   => 'crypto_asset/add_js',
			'arr'          => $arr,
			'arr_bg_color' => $arr_bg_color,
			'arr_state'    => $arr_state,
		];
		$this->template->render($data);
	}

	public function pick($id)
	{
		$id = str_replace(UYAH, '', base64_decode($id));

		$where_check = [
			'id_member'     => $this->session->userdata(SESI . 'id'),
			'id_package >'     => $id,
			'state !='         => 'cancel',
			'state !='         => 'expired',
			'deleted_at'     => null,
		];
		$arr_check = $this->M_core->get('member_crypto_asset', '*', $where_check);

		if ($arr_check->num_rows() > 0) {
			return show_error("Crypto Asset Package disabled because you can't pick a package that tier lower than active package!", 503, "Something wrong here...");
		}

		$where_check = [
			'id_member'  => $this->session->userdata(SESI . 'id'),
			'id_package' => $id,
			'deleted_at' => null,
		];
		$arr_check = $this->M_core->get('member_crypto_asset', '*', $where_check);

		if ($arr_check->num_rows() > 0) {
			foreach ($arr_check->result() as $key) {
				$state = $key->state;

				if (in_array($state, ['waiting payment', 'pending'])) {
					return show_error("Crypto Asset Package disabled because current package are still waiting for payment", 503, "Something wrong here...");
				}
			}
		}

		$where = [
			'id'         => $id,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('package_crypto_asset', '*', $where);

		$data = [
			'title'      => APP_NAME . ' | Add Crypto Asset',
			'content'    => 'crypto_asset/pick',
			'vitamin_js' => 'crypto_asset/pick_js',
			'id_package' => base64_encode(UYAH . $id),
			'arr'        => $arr,
		];
		$this->template->render($data);
	}

	public function checkout_coinpayment()
	{
		$this->db->trans_begin();

		$id_member      = $this->session->userdata(SESI . 'id');
		$buyer_email    = $this->session->userdata(SESI . 'email');
		$buyer_name     = $this->session->userdata(SESI . 'fullname');
		$id_package     = str_replace(UYAH, '', base64_decode($this->input->post('id_package')));
		$payment_method = $this->input->post('payment_method');
		$coin_type      = $this->input->post('coin_type');

		$where_check = [
			'id_member'     => $this->session->userdata(SESI . 'id'),
			'id_package >'     => $id_package,
			'state !='         => 'cancel',
			'state !='         => 'expired',
			'deleted_at'     => null,
		];
		$arr_check = $this->M_core->get('member_crypto_asset', '*', $where_check);

		if ($arr_check->num_rows() > 0) {
			return show_error("Crypto Asset Package disabled because you can't pick a package that tier lower than active package!", 503, "Something wrong here...");
		}

		$where_check = [
			'id_member'  => $this->session->userdata(SESI . 'id'),
			'id_package' => $id_package,
			'deleted_at' => null,
		];
		$arr_check = $this->M_core->get('member_crypto_asset', '*', $where_check);

		if ($arr_check->num_rows() > 0) {
			foreach ($arr_check->result() as $key) {
				$state = $key->state;

				if (in_array($state, ['waiting payment', 'pending'])) {
					return show_error("Crypto Asset Package disabled because current package are still waiting for payment", 503, "Something wrong here...");
				}
			}
		}

		$current_date_object = new DateTime($this->date);
		$expired_at          = $current_date_object->modify('+365 day')->format('Y-m-d');

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

		$invoice = "INV-" . date('Ymd') . '-' . $new_sequence;

		$where = [
			'id'         => $id_package,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];
		$arr_package = $this->M_core->get('package_crypto_asset', 'amount, name, code, share_self_value, share_upline_value, share_company_value', $where, null, null, 1);

		if ($arr_package->num_rows() == 0) {
			return show_error("Package Not Found", 404, "An Error Was Encountered!");
		}

		$amount                 = $arr_package->row()->amount;
		$item_name              = $arr_package->row()->name;
		$item_number            = $arr_package->row()->code;
		$profit_self_per_day    = $arr_package->row()->share_self_value;
		$profit_upline_per_day  = $arr_package->row()->share_upline_value;
		$profit_company_per_day = $arr_package->row()->share_company_value;

		if ($id_package == 6) {
			$amount                 = $this->input->post('total_transfer');
			$profit_per_month       = ($amount * 15) / 100;
			$profit_per_day         = ($profit_per_month / 30);
			$profit_self_per_day    = ($profit_per_day * 90) / 100;
			$profit_upline_per_day  = ($profit_per_day * 5) / 100;
			$profit_company_per_day = ($profit_per_day * 5) / 100;
		}

		$data_member_package = [
			'invoice'                => $invoice,
			'sequence'               => $sequence,
			'id_member'              => $id_member,
			'id_package'             => $id_package,
			'payment_method'         => $payment_method,
			'amount_usd'             => $amount,
			'profit_self_per_day'    => $profit_self_per_day,
			'profit_upline_per_day'  => $profit_upline_per_day,
			'profit_company_per_day' => $profit_company_per_day,
			'currency1'              => 'USDT',
			'currency2'              => $coin_type,
			'buyer_email'            => $buyer_email,
			'buyer_name'             => $buyer_name,
			'item_name'              => $item_name,
			'state'                  => 'waiting payment',
			'expired_at'             => $expired_at,
			'is_qualified'           => 'no',
			'is_royalt'              => 'no',
			'is_extend'              => 'auto',
			'created_at'             => $this->datetime,
			'updated_at'             => $this->datetime,
			'deleted_at'             => null,
		];
		$exec = $this->M_core->store('member_crypto_asset', $data_member_package);

		if (!$exec) {
			$this->db->trans_rollback();
			return show_error("Connection Failed, Please try again!", 500, "An Error Was Encountered!");
		}

		$data_package = [
			'amount'      => $amount,
			'coin_type'   => $coin_type,
			'buyer_email' => $buyer_email,
			'buyer_name'  => $buyer_name,
			'item_name'   => $item_name,
			'item_number' => $item_number,
			'invoice'     => $invoice,
		];

		$exec = $this->_create_transaction($data_package);

		if ($exec['code'] == 500) {
			$this->db->trans_rollback();
			return show_error("Connection Failed, Please try again!", 500, "An Error Was Encountered!");
		}

		$txn_id      = $exec['data']['txn_id'];
		$amount_coin = $exec['data']['amount'];

		$data = [
			'txn_id'                  => $txn_id,
			'amount_coin'             => $amount_coin,
			'receiver_wallet_address' => $exec['data']['address'],
			'timeout'                 => $exec['data']['timeout'],
			'checkout_url'            => $exec['data']['checkout_url'],
			'status_url'              => $exec['data']['status_url'],
			'qrcode_url'              => $exec['data']['qrcode_url'],
		];
		$exec = $this->M_core->update('member_crypto_asset', $data, ['invoice' => $invoice]);

		if (!$exec) {
			$this->db->trans_rollback();
			return show_error("Connection Failed, Please try again!", 500, "An Error Was Encountered!");
		}

		$where_log = [
			'id_member' => $id_member,
			'invoice'   => $invoice,
		];
		$arr_log = $this->M_core->get('log_member_crypto_asset', '*', $where_log);

		if ($arr_log->num_rows() == 0) {
			$data_log = [
				'id_member'         => $id_member,
				'invoice'           => $invoice,
				'amount_invest'     => $amount,
				'amount_transfer'   => $amount_coin,
				'currency_transfer' => $coin_type,
				'txn_id'            => $txn_id,
				'state'             => 'waiting payment',
				'description'       => "[$this->datetime] Member $buyer_email Pick Package $item_name. Waiting for Payment Transfer",
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_member_crypto_asset', $data_log);
		} else {
			$data_log = [
				'state'             => 'waiting payment',
				'description'       => "[$this->datetime] Member $buyer_email Pick Package $item_name. Waiting for Payment Transfer",
				'updated_at'        => $this->datetime,
			];
			$this->M_core->update('log_member_crypto_asset', $data_log, $where_log);
		}

		$this->db->trans_commit();

		redirect('crypto_asset/checkout/' . base64_encode(UYAH . $invoice));
	}

	public function _create_transaction($data)
	{
		$code = 500;

		$req['amount']      = $data['amount'];
		$req['currency1']   = 'USDT';
		$req['currency2']   = $data['coin_type'];
		$req['buyer_email'] = $data['buyer_email'];
		$req['buyer_name']  = $data['buyer_name'];
		$req['item_name']   = $data['item_name'];
		$req['item_number'] = $data['item_number'];
		$req['invoice']     = $data['invoice'];
		$req['ipn_url']     = site_url('coinpayment/ipn');
		$req['success_url'] = site_url('coinpayment/success');
		$req['cance_url']   = site_url('coinpayment/cancel');

		$exec = $this->_coinpayments_api_call('create_transaction', $req);

		if ($exec['error'] == "ok") {
			$code = 200;

			$data = [
				'txn_id'           => $exec['result']['txn_id'],
				'amount'           => $exec['result']['amount'],
				'receiver_address' => $exec['result']['address'],
				'state'            => 'waiting payment',
				'created_at'       => $this->datetime,
				'updated_at'       => $this->datetime,
				'deleted_at'       => null,
			];

			$this->M_core->store('coinpayment_ipn', $data);
		} else {
			echo show_error($exec['error'], 500, "An Error Was Encountered");
			exit;
		}

		$result = [
			'code'  => $code,
			'data'  => $exec['result'],
			'error' => $exec['error'],
		];

		return $result;
	}

	public function _get_new_sequence()
	{
		$exec = $this->M_crypto_asset->latest_sequence();

		if ($exec->num_rows() > 0) {
			return $exec->row()->max_sequence + 1;
		}

		return 1;
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
		$arr   = $this->M_core->get('member_crypto_asset', '*', $where);

		if ($arr->num_rows() == 0) {
			return show_error("Data Invoice Not Found", 404, "An Error Was Encountered");
		}

		$state = $arr->row()->state;

		$time_left   = 0;

		if ($state == "waiting payment") {
			$time_left_obj = new DateTime($arr->row()->created_at);
			$time_left     = $time_left_obj->modify('+' . $arr->row()->timeout . ' seconds')->format('Y-m-d H:i:s');
			$badge_color   = 'info';
		} elseif ($state == "pending") {
			$time_left_obj = new DateTime($arr->row()->created_at);
			$time_left     = $time_left_obj->modify('+' . $arr->row()->timeout . ' seconds')->format('Y-m-d H:i:s');
			$badge_color   = 'secondary';
		} elseif ($state == "active") {
			$badge_color = 'success';
		} elseif ($state == "inactive") {
			$badge_color = 'dark';
		} elseif ($state == "cancel") {
			$badge_color = 'warning';
		} elseif ($state == "expired") {
			$badge_color = 'danger';
		}

		$state_badge = '<span class="badge badge-' . $badge_color . '">' . strtoupper($state) . '</span>';

		$data = [
			'title'       => APP_NAME . ' | Checkout',
			'content'     => 'crypto_asset/checkout',
			'vitamin_js'  => 'crypto_asset/checkout_js',
			'arr'         => $arr,
			'time_left'   => $time_left,
			'state'       => $state,
			'state_badge' => $state_badge,
		];
		$this->template->render($data);
	}

	public function get_tx_info()
	{
		header('Content-Type: application/json');
		$this->db->trans_begin();

		$code                = 200;
		$member_is_qualified = 'no';
		$member_is_royalty   = 'no';

		$txn_id = $this->input->get('txid');

		$req['txid'] = $txn_id;
		$req['full'] = 0; // if set 1 will display checkout information

		$where_state = ['txn_id' => $txn_id];
		$arr_state   = $this->M_core->get('member_crypto_asset', '*', $where_state);

		$invoice      = $arr_state->row()->invoice;
		$id_member    = $arr_state->row()->id_member;
		$id_package   = $arr_state->row()->id_package;
		$amount_usd   = $arr_state->row()->amount_usd;
		$amount_coin  = $arr_state->row()->amount_coin;
		$currency2    = $arr_state->row()->currency2;
		$buyer_email  = $arr_state->row()->buyer_email;
		$buyer_name   = $arr_state->row()->buyer_name;
		$item_name    = $arr_state->row()->item_name;
		$state_trade  = $arr_state->row()->state;
		$is_qualified = $arr_state->row()->is_qualified;
		$is_royalty   = $arr_state->row()->is_royalty;

		$exec = $this->_coinpayments_api_call('get_tx_info', $req);
		if ($exec['error'] != "ok") {
			$this->db->trans_rollback();
			$return = [
				'code'        => 500,
				'status_text' => $exec['result']['status_text'],
			];
			echo json_encode($return);
			exit;
		}

		$status      = $exec['result']['status'];
		$status_text = $exec['result']['status_text'];

		$status = 100; //adam debug only

		if ($status >= 100 || $status == 2) {
			// payment is complete or queued for nightly payout or success
			$state       = 'active';
			$badge_color = 'success';
			$description = "[$this->datetime] Member $buyer_email Package $item_name Active";

			if ($state_trade != "active") {
				$arr_member = $this->M_core->get('member', 'id_upline', ['id' => $id_member]);
				$id_upline  = $arr_member->row()->id_upline;

				$arr_upline        = $this->M_core->get('member', 'email, fullname, deleted_at', ['id' => $id_upline]);
				$email_upline      = $arr_upline->row()->email;
				$fullname_upline   = $arr_upline->row()->fullname;
				$deleted_at_upline = $arr_upline->row()->deleted_at;

				// PART BONUS SPONSOR START
				if ($arr_upline->num_rows() == 1) {
					$amount_bonus_upline = ($amount_usd * 10) / 100;

					if ($id_upline != null) {

						if ($deleted_at_upline == null) {
							$this->M_crypto_asset->update_member_bonus($id_upline, $amount_bonus_upline);

							$id_upline_log = $id_upline;
							$desc_log      = "$fullname_upline ($email_upline) get bonus recruitment of member $buyer_name ($buyer_email) $amount_bonus_upline USDT";
						} else {
							$this->M_crypto_asset->update_unknown_balance($amount_bonus_upline);

							$id_upline_log = null;
							$desc_log      = "Unknown Balance get bonus recruitment of member $buyer_name ($buyer_email) $amount_bonus_upline USDT";
						}

						$data_log = [
							'id_member'      => $id_upline_log,
							'id_downline'    => $id_member,
							'type_package'   => 'trade manager',
							'invoice'        => $invoice,
							'id_package'     => $id_package,
							'package_name'   => $item_name,
							'package_amount' => $amount_usd,
							'state'          => 'get bonus',
							'description'    => $desc_log,
							'created_at'     => $this->datetime,
						];
						$this->M_core->store_uuid('log_bonus_recruitment', $data_log);
					}
				}
				// PART BONUS SPONSOR END

				// PART QUALIFIKASI LEVEL START
				if ($is_qualified == "no") {
					// adamx
					$member_is_qualified = $this->_update_qualified($id_member, $id_upline, $amount_usd, $invoice, $id_package, $item_name);
				}
				// PART QUALIFIKASI LEVEL END

				// PART ROYALTY START
				if ($is_royalty == "no") {
					$member_is_royalty = $this->_update_royalty($id_member, $amount_usd, $invoice, $id_package, $item_name);
				}
				// PART ROYALTY END

				// UPDATE TOTAL OMSET START
				$update_omset = $this->_update_omset($id_member, $amount_usd);
				if ($update_omset === false) {
					$this->db->trans_rollback();
					$return = [
						'code'        => 500,
						'status_text' => "Failed to Update Upline Sales Turnover",
					];
					echo json_encode($return);
					exit;
				}
				// UPDATE TOTAL OMSET END
			}

			$this->_send_package_active($id_member, $buyer_email, $invoice, $item_name);
		} else if ($status < 0) {
			//payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
			$state = 'cancel';
			$badge_color = 'warning';
			$description = "[$this->datetime] Member $buyer_email Package $item_name Payment Timeout";
		} else {
			//payment is pending, you can optionally add a note to the order page
			$state = 'waiting payment';
			$badge_color = 'secondary';
			$description = "[$this->datetime] Member $buyer_email Pick Package $item_name. Waiting for Payment Transfer";
		}

		$state_badge = '<span class="badge badge-' . $badge_color . '">' . strtoupper($state) . '</span>';

		$where = ['txn_id' => $txn_id];
		$data  = [
			'state'       => $state,
			'status_code' => $status,
			'updated_at'  => $this->datetime,
		];
		$this->M_core->update('coinpayment_ipn', $data, $where);

		$data = [
			'state'        => $state,
			'is_qualified' => $member_is_qualified,
			'is_royalty'   => $member_is_royalty,
			'updated_at'   => $this->datetime,
		];
		$where = ['txn_id' => $txn_id];
		$this->M_core->update('member_crypto_asset', $data, $where);

		$where = [
			'id_member' => $this->session->userdata(SESI . 'id'),
			'state'     => 'active',
		];
		$arr = $this->M_core->get('member_crypto_asset', 'amount_usd, state', $where);

		$total_invest_crypto_asset = 0;
		$count_crypto_asset        = 0;

		if ($arr->num_rows() > 0) {
			foreach ($arr->result() as $key) {
				$total_invest_crypto_asset += $key->amount_usd;
				$count_crypto_asset++;
			}
		}

		$data = [
			'total_invest_crypto_asset' => $total_invest_crypto_asset,
			'count_crypto_asset'        => $count_crypto_asset,
			'updated_at'                 => $this->datetime,
		];
		$where = ['id_member' => $this->session->userdata(SESI . 'id')];
		$this->M_core->update('member_balance', $data, $where);

		$where_count = [
			'id_member' => $this->session->userdata(SESI . 'id'),
			'invoice'   => $invoice,
		];
		$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

		if ($arr_count->num_rows() == 0) {
			$data_log = [
				'id_member'         => $this->session->userdata(SESI . 'id'),
				'invoice'           => $invoice,
				'amount_invest'     => $amount_usd,
				'amount_transfer'   => $amount_coin,
				'currency_transfer' => $currency2,
				'txn_id'            => $txn_id,
				'state'             => $state,
				'description'       => $description,
				'created_at'        => $this->datetime,
				'updated_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_member_crypto_asset', $data_log);
		} else {
			$data_log = [
				'state'             => $state,
				'description'       => $description,
				'updated_at'        => $this->datetime,
			];
			$this->M_core->update('log_member_crypto_asset', $data_log, $where_count);
		}

		$return = [
			'code'        => $code,
			'state'       => $state,
			'status_text' => $status_text,
			'receivedf'   => $exec['result']['receivedf'],
			'coin'        => $exec['result']['coin'],
			'exec'        => $exec,
			'state_badge' => $state_badge,
		];

		$this->db->trans_commit();
		echo json_encode($return);
	}

	protected function _update_qualified($id_member, $id_upline, $amount_usd, $invoice, $id_package, $item_name)
	{

		$member_is_qualified = "no";

		$arr_member      = $this->M_core->get('member', 'email, fullname', ['id' => $id_member]);
		$email_member    = $arr_member->row()->email;
		$fullname_member = $arr_member->row()->fullname;

		$arr_ql_sibling = $this->M_crypto_asset->get_ql_sibling($id_member, $id_upline);

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
							$this->M_crypto_asset->update_member_bonus($id_grand_upline, $new_bonus_grand_upline);

							$desc_log_member1 = "$fullname_grand_upline ($email_grand_upline) get bonus royalty of member $fullname_member ($email_member) $bonus_grand_upline USDT";

							$desc_log_member2 = "$fullname_grand_upline ($email_grand_upline) get bonus royalty of member $buyer_name_ql_sibling ($buyer_email_ql_sibling) $amount_usd_ql_sibling_as_bonus USDT";
						} else {
							$this->M_crypto_asset->update_unknown_balance($new_bonus_grand_upline);

							$desc_log_member1 = "Unknown Balance get bonus royalty of member $fullname_member ($email_member) $bonus_grand_upline USDT";

							$desc_log_member2 = "Unknown Balance get bonus royalty of member $buyer_name_ql_sibling ($buyer_email_ql_sibling) $amount_usd_ql_sibling_as_bonus USDT";
						}

						$data_update_member_crypto_asset  = ['is_qualified' => 'yes', 'updated_at' => $this->datetime];
						$where_update_member_crypto_asset = ['invoice'      => $invoice_ql_sibling];
						$this->M_core->update('member_crypto_asset', $data_update_member_crypto_asset, $where_update_member_crypto_asset);

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
						$this->M_crypto_asset->update_member_bonus($id_gen, $bonus_royalty);

						$id_member_log = $id_gen;
						$desc_log = "$fullname_gen ($email_gen) get bonus royalty of member $fullname_member ($email_member) $bonus_royalty USDT";
					} else {
						$this->M_crypto_asset->update_unknown_bonus($bonus_royalty);

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

			$data_update_member_crypto_asset  = ['is_royalty' => 'yes', 'updated_at' => $this->datetime];
			$where_update_member_crypto_asset = ['invoice'    => $invoice];
			$this->M_core->update('member_crypto_asset', $data_update_member_crypto_asset, $where_update_member_crypto_asset);

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

		$data['arr_data'] = $this->M_core->get('member_crypto_asset', '*', ['id_member' => $id]);
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
		$exec = $this->M_crypto_asset->update_total_omset($id_member, $amount_usd);
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
						$exec2 = $this->M_crypto_asset->update_total_omset($id_x, $amount_usd);

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
		$arr_check = $this->M_core->get('member_crypto_asset', '*', $where_count);

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
		$exec = $this->M_core->update('member_crypto_asset', $data, $where_count);

		if (!$exec) {
			echo json_encode(['code' => 500, 'status_text' => "Update Failed, please try again!"]);
			exit;
		}

		echo json_encode(['code' => 200, 'status_text' => "Update Success"]);
	}
}
        
/* End of file  CryptoAssetController.php */
