<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CoinPayment extends CI_Controller
{
	protected $datetime;
	protected $api_link;
	protected $public_key;
	protected $private_key;
	protected $merchant_id;
	protected $ipn_secret_key;
	protected $debug_email;

	public function __construct()
	{
		parent::__construct();
		$this->datetime 		= date('Y-m-d H:i:s');
		$this->api_link       	= CP_API_LINK;
		$this->public_key     	= CP_PUB_KEY;
		$this->private_key    	= CP_PRV_KEY;
		$this->merchant_id    	= CP_MERCH_ID;
		$this->ipn_secret_key 	= CP_IPN_SEC_KEY;
		$this->debug_email    	= EMAIL_ADMIN;

		$this->load->model('M_trade_manager');
		$this->load->model('M_crypto_asset');
	}


	public function get_basic_info()
	{
		header('Content-Type: application/json');
		$code = 500;
		$exec = $this->coinpayments_api_call('get_basic_info');
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function rates()
	{
		header('Content-Type: application/json');
		$code = 500;
		$exec = $this->coinpayments_api_call('rates');
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function create_transaction()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['amount'] = 3;
		$req['currency1'] = 'USD';
		$req['currency2'] = 'ETH';
		$req['buyer_email'] = 'adam.pm59@gmail.com';
		$req['buyer_name'] = 'adam';
		$req['item_name'] = 'Starter Pack - Trade Manager';
		$req['item_number'] = 'TM02';
		$req['invoice'] = 'INV-210611-000002';
		$req['custom'] = '2'; // ORDER ID FROM DB
		$req['ipn_url'] = site_url('coinpayment/ipn');
		$req['success_url'] = site_url('coinpayment/success');
		$req['cance_url'] = site_url('coinpayment/cancel');

		$exec = $this->coinpayments_api_call('create_transaction', $req);

		if ($exec['error'] == "ok") {
			$code = 200;
			$data['txn_id']  = $exec['result']['txn_id'];
			$data['amount']  = $exec['result']['amount'];
			$data['address'] = $exec['result']['address'];

			// $this->M_core->store('test_ipn', $data);
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
			'error' => $exec['error'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function callback_address()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['currency'] = 'BTC';
		$req['ipn_url']  = site_url('coinpayment/ipn');
		$req['label']    = APP_NAME . ' BTC WALLET';
		$exec = $this->coinpayments_api_call('get_callback_address', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function get_tx_info()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['txid'] = 'CPFF6MQXPXGGQPRKZETAE0VQ51';
		$req['full'] = 0; // if set 1 will display checkout information
		$exec = $this->coinpayments_api_call('get_tx_info', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		$data = ['status' => $exec['result']['status']];
		$where = ['txn_id' => 'CPFF6MQXPXGGQPRKZETAE0VQ51'];
		$this->M_core->update('test_ipn', $data, $where);

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function get_tx_ids()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['limit'] = 25; // min 1 | max 100 | default 25
		$req['start'] = 0;
		$req['newer'] = 0; // can be set timestamp
		$req['all'] = 0; // if set to 1 get all data from seller or buyer
		$exec = $this->coinpayments_api_call('get_tx_ids', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function balances()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['all'] = 0; // if set to 1 show all coins
		$exec = $this->coinpayments_api_call('balances', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	// create transfer inside coinpayment network
	public function create_transfer()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['amount'] = 1;
		$req['currency'] = 'LTCT';
		$req['merchant'] = ''; // merchant id or $PayByName tag user coinpayment
		$req['auto_confirm'] = 0; // if set to 1 withdraw will complete without email confirmation
		$req['note'] = 'withdraw from and to coinpayment';

		$exec = $this->coinpayments_api_call('create_transfer', $req);

		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function create_withdrawal()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['amount'] = 9;
		$req['add_tx_fee'] = 0; // if 1, TX Fee will given to Sender, if 0, it will reduce from amount transfer
		$req['currency'] = 'USDT';

		/*
		Optional currency to use to to withdraw 'amount' worth of 'currency2' in 'currency' coin. This is for exchange rate calculation only and will not convert coins or change which currency is withdrawn.
		For example, to withdraw 1.00 USD worth of BTC you would specify 'currency'='BTC', 'currency2'='USD', and 'amount'='1.00' 
		*/
		$req['currency2'] = 'USDT';

		$req['address'] = '0xc4b79a7458b393ee8d44a7181daf946492ab2e87';
		$req['ipn_url'] = site_url('coinpayment/ipn');
		$req['auto_confirm'] = 0; // if set to 1 withdraw will complete without email confirmation
		$req['note'] = 'withdraw from coinpayment to external wallet';

		$exec = $this->coinpayments_api_call('create_withdrawal', $req);

		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec,
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function cancel_withdrawal()
	{
		header('Content-Type: application/json');
		$code = 500;

		/*
		The withdrawal ID to cancel. Note the withdrawal must be in the "Awaiting email confirmation" state to be able to be cancelled.
		*/
		$req['id'] = '';
		$exec = $this->coinpayments_api_call('cancel_withdrawal', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function convert()
	{
		header('Content-Type: application/json');
		$code = 500;

		/*
		The withdrawal ID to cancel. Note the withdrawal must be in the "Awaiting email confirmation" state to be able to be cancelled.
		*/
		$req['amount'] = 9;
		$req['from'] = 'USDT';
		$req['to'] = 'ETH';

		/*
		The address to send the funds to. If blank or not included the coins will go to your CoinPayments Wallet.
		*/
		$req['address'] = '0xc4b79a7458b393ee8d44a7181daf946492ab2e87';
		$exec = $this->coinpayments_api_call('convert', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec,
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function convert_limits()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['from'] = 'USDT';
		$req['to'] = 'ETH';

		$exec = $this->coinpayments_api_call('convert_limits', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function get_withdrawal_history()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['limit'] = 25; // min 1 | max 100 | default 25
		$req['start'] = 0;
		$req['newer'] = 0; // can be set timestamp

		$exec = $this->coinpayments_api_call('get_withdrawal_history', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function get_withdrawal_info()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['id'] = 'CWFF3HHYBFZWRG5OFXH6XBRTT7'; // Withdrawal ID like CW...

		$exec = $this->coinpayments_api_call('get_withdrawal_info', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function coinpayments_api_call($cmd, $req = array())
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
		curl_close($ch);

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
	}

	public function ipn()
	{
		// $this->db->trans_begin();

		// // Fill these in with the information from your CoinPayments.net account.
		// $merchant_id    = $this->merchant_id;
		// $ipn_secret_key = $this->ipn_secret_key;

		// if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
		// 	$object = [
		// 		'ipn_version' => $_POST['ipn_version'],
		// 		'ipn_type'    => $_POST['ipn_type'],
		// 		'ipn_mode'    => $_POST['ipn_mode'],
		// 		'ipn_id'      => $_POST['ipn_id'],
		// 		'description' => 'IPN Mode is not HMAC',
		// 		'created_at'  => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('IPN Mode is not HMAC');
		// }

		// if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
		// 	$object = [
		// 		'ipn_version' => $_POST['ipn_version'],
		// 		'ipn_type'    => $_POST['ipn_type'],
		// 		'ipn_mode'    => $_POST['ipn_mode'],
		// 		'ipn_id'      => $_POST['ipn_id'],
		// 		'description' => 'No HMAC signature sent.',
		// 		'created_at'  => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('No HMAC signature sent.');
		// }

		// $request = file_get_contents('php://input');
		// if ($request === FALSE || empty($request)) {
		// 	$object = [
		// 		'ipn_version' => $_POST['ipn_version'],
		// 		'ipn_type'    => $_POST['ipn_type'],
		// 		'ipn_mode'    => $_POST['ipn_mode'],
		// 		'ipn_id'      => $_POST['ipn_id'],
		// 		'description' => 'Error reading POST data',
		// 		'created_at'  => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('Error reading POST data');
		// }

		// if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($merchant_id)) {
		// 	$object = [
		// 		'ipn_version' => $_POST['ipn_version'],
		// 		'ipn_type'    => $_POST['ipn_type'],
		// 		'ipn_mode'    => $_POST['ipn_mode'],
		// 		'ipn_id'      => $_POST['ipn_id'],
		// 		'merchant'    => $_POST['merchant'],
		// 		'description' => 'No or incorrect Merchant ID passed',
		// 		'created_at'  => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('No or incorrect Merchant ID passed');
		// }

		// $hmac = hash_hmac("sha512", $request, trim($ipn_secret_key));
		// if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
		// 	$object = [
		// 		'ipn_version' => $_POST['ipn_version'],
		// 		'ipn_type'    => $_POST['ipn_type'],
		// 		'ipn_mode'    => $_POST['ipn_mode'],
		// 		'ipn_id'      => $_POST['ipn_id'],
		// 		'merchant'    => $_POST['merchant'],
		// 		'description' => 'HMAC signature does not match',
		// 		'created_at'  => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('HMAC signature does not match');
		// }

		// if ($_POST['ipn_type'] != 'api') {
		// 	$object = [
		// 		'ipn_version' => $_POST['ipn_version'],
		// 		'ipn_type'    => $_POST['ipn_type'],
		// 		'ipn_mode'    => $_POST['ipn_mode'],
		// 		'ipn_id'      => $_POST['ipn_id'],
		// 		'merchant'    => $_POST['merchant'],
		// 		'description' => 'IPN OK: Not a API payment',
		// 		'created_at'  => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('IPN OK: Not a API payment');
		// }

		// // HMAC Signature verified at this point, load some variables.
		// $ipn_version       = $_POST['ipn_version'];
		// $ipn_type          = $_POST['ipn_type'];
		// $ipn_mode          = $_POST['ipn_mode'];
		// $ipn_id            = $_POST['ipn_id'];
		// $merchant          = $_POST['merchant'];
		// $status            = intval($_POST['status']);
		// $status_text       = $_POST['status_text'];
		// $txn_id            = $_POST['txn_id'];
		// $currency1         = $_POST['currency1'];
		// $currency2         = $_POST['currency2'];
		// $amount1           = floatval($_POST['amount1']);
		// $amount2           = floatval($_POST['amount2']);
		// $fee               = $_POST['fee'];
		// $buyer_name        = $_POST['buyer_name'];
		// $email             = $_POST['email'];
		// $item_name         = $_POST['item_name'];
		// $item_number       = $_POST['item_number'];
		// $invoice           = $_POST['invoice'];
		// $received_amount   = floatval($_POST['received_amount']);
		// $received_confirms = floatval($_POST['received_confirms']);
		// $custom            = $_POST['custom'];

		// //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field.
		// $where_order = [
		// 	'invoice'    => $invoice,
		// 	'txn_id'     => $txn_id,
		// 	'deleted_at' => null
		// ];

		// if ($custom == 'trade_manager') {
		// 	$arr_order = $this->M_core->get('member_trade_manager', '*', $where_order);
		// } else {
		// 	$arr_order = $this->M_core->get('member_crypto_asset', '*', $where_order);
		// }

		// if ($arr_order->num_rows() == 0) {
		// 	$object = [
		// 		'ipn_version'       => $ipn_version,
		// 		'ipn_type'          => $ipn_type,
		// 		'ipn_mode'          => $ipn_mode,
		// 		'ipn_id'            => $ipn_id,
		// 		'merchant'          => $merchant,
		// 		'description'       => 'Invoice ' . $invoice . ' Not Found',
		// 		'status'            => $status,
		// 		'status_text'       => $status_text,
		// 		'txn_id'            => $txn_id,
		// 		'currency1'         => $currency1,
		// 		'currency2'         => $currency2,
		// 		'amount1'           => $amount1,
		// 		'amount2'           => $amount2,
		// 		'fee'               => $fee,
		// 		'buyer_name'        => $buyer_name,
		// 		'email'             => $email,
		// 		'item_name'         => $item_name,
		// 		'item_number'       => $item_number,
		// 		'invoice'           => $invoice,
		// 		'received_amount'   => $received_amount,
		// 		'received_confirms' => $received_confirms,
		// 		'created_at'        => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('Invoice ' . $invoice . ' Not Found');
		// }

		// // KELUARKAN HASIL DARI DB TABLE MEMBER TRADE MANAGER
		// $db_invoice                 = $arr_order->row()->invoice;
		// $db_id_member               = $arr_order->row()->id_member;
		// $db_id_package              = $arr_order->row()->id_package;
		// $db_payment_method          = $arr_order->row()->payment_method;
		// $db_amount_usd              = $arr_order->row()->amount_usd;
		// $db_profit_self_per_day     = $arr_order->row()->profit_self_per_day;
		// $db_profit_upline_per_day   = $arr_order->row()->profit_upline_per_day;
		// $db_profit_company_per_day  = $arr_order->row()->profit_company_per_day;
		// $db_currency1               = $arr_order->row()->currency1;
		// $db_currency2               = $arr_order->row()->currency2;
		// $db_buyer_email             = $arr_order->row()->buyer_email;
		// $db_buyer_name              = $arr_order->row()->buyer_name;
		// $db_item_name               = $arr_order->row()->item_name;
		// $db_state                   = $arr_order->row()->state;
		// $db_txn_id                  = $arr_order->row()->txn_id;
		// $db_amount_coin             = $arr_order->row()->amount_coin;
		// $db_receiver_wallet_address = $arr_order->row()->receiver_wallet_address;
		// $db_timeout                 = $arr_order->row()->timeout;
		// $db_checkout_url            = $arr_order->row()->checkout_url;
		// $db_status_url              = $arr_order->row()->status_url;
		// $db_qrcode_url              = $arr_order->row()->qrcode_url;
		// $db_expired_at              = $arr_order->row()->expired_at;
		// $db_is_qualified            = $arr_order->row()->is_qualified;
		// $db_is_royalty              = $arr_order->row()->is_royalty;
		// $db_is_extend               = $arr_order->row()->is_extend;

		// $order_currency = 'USDT';
		// $order_total    = $db_amount_usd;
		// // Check the original currency to make sure the buyer didn't change it.
		// if ($currency1 != $order_currency) {
		// 	$object = [
		// 		'ipn_version'       => $ipn_version,
		// 		'ipn_type'          => $ipn_type,
		// 		'ipn_mode'          => $ipn_mode,
		// 		'ipn_id'            => $ipn_id,
		// 		'merchant'          => $merchant,
		// 		'description'       => 'Invoice ' . $invoice . ' Original currency mismatch!',
		// 		'status'            => $status,
		// 		'status_text'       => $status_text,
		// 		'txn_id'            => $txn_id,
		// 		'currency1'         => $currency1,
		// 		'currency2'         => $currency2,
		// 		'amount1'           => $amount1,
		// 		'amount2'           => $amount2,
		// 		'fee'               => $fee,
		// 		'buyer_name'        => $buyer_name,
		// 		'email'             => $email,
		// 		'item_name'         => $item_name,
		// 		'item_number'       => $item_number,
		// 		'invoice'           => $invoice,
		// 		'received_amount'   => $received_amount,
		// 		'received_confirms' => $received_confirms,
		// 		'created_at'        => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('Invoice ' . $invoice . ' Original currency mismatch!');
		// }

		// // Check amount against order total
		// if ($amount1 < $order_total) {
		// 	$object = [
		// 		'ipn_version'       => $ipn_version,
		// 		'ipn_type'          => $ipn_type,
		// 		'ipn_mode'          => $ipn_mode,
		// 		'ipn_id'            => $ipn_id,
		// 		'merchant'          => $merchant,
		// 		'description'       => 'Invoice ' . $invoice . ' Amount is less than order total!',
		// 		'status'            => $status,
		// 		'status_text'       => $status_text,
		// 		'txn_id'            => $txn_id,
		// 		'currency1'         => $currency1,
		// 		'currency2'         => $currency2,
		// 		'amount1'           => $amount1,
		// 		'amount2'           => $amount2,
		// 		'fee'               => $fee,
		// 		'buyer_name'        => $buyer_name,
		// 		'email'             => $email,
		// 		'item_name'         => $item_name,
		// 		'item_number'       => $item_number,
		// 		'invoice'           => $invoice,
		// 		'received_amount'   => $received_amount,
		// 		'received_confirms' => $received_confirms,
		// 		'created_at'        => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	$this->db->trans_commit();

		// 	$this->errorAndDie('Invoice ' . $invoice . ' Amount is less than order total!');
		// }

		// // VALIDASI TRANSACTION
		// if ($status == -1) {
		// 	// Cancelled / Timed Out

		// 	// WRITE LOG IPN START
		// 	$object = [
		// 		'ipn_version'       => $ipn_version,
		// 		'ipn_type'          => $ipn_type,
		// 		'ipn_mode'          => $ipn_mode,
		// 		'ipn_id'            => $ipn_id,
		// 		'merchant'          => $merchant,
		// 		'description'       => 'Invoice ' . $invoice . ' Order Canceled / Timeout',
		// 		'status'            => $status,
		// 		'status_text'       => $status_text,
		// 		'txn_id'            => $txn_id,
		// 		'currency1'         => $currency1,
		// 		'currency2'         => $currency2,
		// 		'amount1'           => $amount1,
		// 		'amount2'           => $amount2,
		// 		'fee'               => $fee,
		// 		'buyer_name'        => $buyer_name,
		// 		'email'             => $email,
		// 		'item_name'         => $item_name,
		// 		'item_number'       => $item_number,
		// 		'invoice'           => $invoice,
		// 		'received_amount'   => $received_amount,
		// 		'received_confirms' => $received_confirms,
		// 		'created_at'        => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	// WRITE LOG IPN END

		// 	// UPDATE TABLE IPN TRADE MANAGER START
		// 	$data  = [
		// 		'amount'      => $received_amount,
		// 		'state'       => 'cancel',
		// 		'status_code' => $status,
		// 		'updated_at'  => $this->datetime,
		// 	];
		// 	$where = ['txn_id' => $txn_id];
		// 	$this->M_core->update('coinpayment_ipn_trade_manager', $data, $where);
		// 	// UPDATE TABLE IPN TRADE MANAGER END

		// 	// UPDATE MEMBER TRADE MANAGER START
		// 	$data = [
		// 		'state'      => 'cancel',
		// 		'updated_at' => $this->datetime,
		// 	];
		// 	$where = ['txn_id' => $txn_id];
		// 	$this->M_core->update('member_trade_manager', $data, $where);
		// 	// UPDATE MEMBER TRADE MANAGER START

		// 	// STORE LOG MEMBER TRADE MANAGER START
		// 	$description = "[$this->datetime] Member $db_buyer_email Package $item_name Cancel";
		// 	$where_count = [
		// 		'id_member' => $db_id_member,
		// 		'invoice'   => $invoice,
		// 		'state'     => 'cancel',
		// 	];
		// 	$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

		// 	if ($arr_count->num_rows() == 0) {
		// 		$data_log = [
		// 			'id_member'         => $db_id_member,
		// 			'invoice'           => $invoice,
		// 			'amount_invest'     => $db_amount_usd,
		// 			'amount_transfer'   => $db_amount_coin,
		// 			'currency_transfer' => $currency2,
		// 			'txn_id'            => $txn_id,
		// 			'state'             => 'cancel',
		// 			'description'       => $description,
		// 			'created_at'        => $this->datetime,
		// 			'updated_at'        => $this->datetime,
		// 		];
		// 		$this->M_core->store_uuid('log_member_trade_manager', $data_log);
		// 	} else {
		// 		$data_log = [
		// 			'description' => $description,
		// 			'updated_at'  => $this->datetime,
		// 		];
		// 		$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
		// 	}
		// 	// STORE LOG MEMBER TRADE MANAGER END

		// 	// SEND EMAIL PACKAGE ACTIVE START
		// 	$this->_send_package_cancel($db_id_member, $db_buyer_email, $invoice, $item_name);
		// 	// SEND EMAIL PACKAGE ACTIVE END

		// } elseif ($status == 0) {
		// 	// Waiting for buyer funds

		// 	// WRITE LOG IPN START
		// 	$object = [
		// 		'ipn_version'       => $ipn_version,
		// 		'ipn_type'          => $ipn_type,
		// 		'ipn_mode'          => $ipn_mode,
		// 		'ipn_id'            => $ipn_id,
		// 		'merchant'          => $merchant,
		// 		'description'       => 'Invoice ' . $invoice . ' Order Waiting Payment',
		// 		'status'            => $status,
		// 		'status_text'       => $status_text,
		// 		'txn_id'            => $txn_id,
		// 		'currency1'         => $currency1,
		// 		'currency2'         => $currency2,
		// 		'amount1'           => $amount1,
		// 		'amount2'           => $amount2,
		// 		'fee'               => $fee,
		// 		'buyer_name'        => $buyer_name,
		// 		'email'             => $email,
		// 		'item_name'         => $item_name,
		// 		'item_number'       => $item_number,
		// 		'invoice'           => $invoice,
		// 		'received_amount'   => $received_amount,
		// 		'received_confirms' => $received_confirms,
		// 		'created_at'        => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	// WRITE LOG IPN END

		// 	// UPDATE TABLE IPN TRADE MANAGER START
		// 	$data  = [
		// 		'amount'      => $received_amount,
		// 		'state'       => 'waiting payment',
		// 		'status_code' => $status,
		// 		'updated_at'  => $this->datetime,
		// 	];
		// 	$where = ['txn_id' => $txn_id];
		// 	$this->M_core->update('coinpayment_ipn_trade_manager', $data, $where);
		// 	// UPDATE TABLE IPN TRADE MANAGER END

		// 	// UPDATE MEMBER TRADE MANAGER START
		// 	$data = [
		// 		'state'      => 'waiting payment',
		// 		'updated_at' => $this->datetime,
		// 	];
		// 	$where = ['txn_id' => $txn_id];
		// 	$this->M_core->update('member_trade_manager', $data, $where);
		// 	// UPDATE MEMBER TRADE MANAGER START

		// 	// STORE LOG MEMBER TRADE MANAGER START
		// 	$description = "[$this->datetime] Member $db_buyer_email Package $item_name Waiting Payment";
		// 	$where_count = [
		// 		'id_member' => $db_id_member,
		// 		'invoice'   => $invoice,
		// 		'state'     => 'waiting payment',
		// 	];
		// 	$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

		// 	if ($arr_count->num_rows() == 0) {
		// 		$data_log = [
		// 			'id_member'         => $db_id_member,
		// 			'invoice'           => $invoice,
		// 			'amount_invest'     => $db_amount_usd,
		// 			'amount_transfer'   => $db_amount_coin,
		// 			'currency_transfer' => $currency2,
		// 			'txn_id'            => $txn_id,
		// 			'state'             => 'waiting payment',
		// 			'description'       => $description,
		// 			'created_at'        => $this->datetime,
		// 			'updated_at'        => $this->datetime,
		// 		];
		// 		$this->M_core->store_uuid('log_member_trade_manager', $data_log);
		// 	} else {
		// 		$data_log = [
		// 			'description' => $description,
		// 			'updated_at'  => $this->datetime,
		// 		];
		// 		$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
		// 	}
		// 	// STORE LOG MEMBER TRADE MANAGER END

		// 	// SEND EMAIL PACKAGE ACTIVE START
		// 	$this->_send_package_waiting_payment($db_id_member, $db_buyer_email, $invoice, $item_name);
		// 	// SEND EMAIL PACKAGE ACTIVE END
		// } elseif ($status == 1) {
		// 	//  We have confirmed coin reception from the buyer

		// 	// WRITE LOG IPN START
		// 	$object = [
		// 		'ipn_version'       => $ipn_version,
		// 		'ipn_type'          => $ipn_type,
		// 		'ipn_mode'          => $ipn_mode,
		// 		'ipn_id'            => $ipn_id,
		// 		'merchant'          => $merchant,
		// 		'description'       => 'Invoice ' . $invoice . ' Order Pending',
		// 		'status'            => $status,
		// 		'status_text'       => $status_text,
		// 		'txn_id'            => $txn_id,
		// 		'currency1'         => $currency1,
		// 		'currency2'         => $currency2,
		// 		'amount1'           => $amount1,
		// 		'amount2'           => $amount2,
		// 		'fee'               => $fee,
		// 		'buyer_name'        => $buyer_name,
		// 		'email'             => $email,
		// 		'item_name'         => $item_name,
		// 		'item_number'       => $item_number,
		// 		'invoice'           => $invoice,
		// 		'received_amount'   => $received_amount,
		// 		'received_confirms' => $received_confirms,
		// 		'created_at'        => $this->datetime,
		// 	];
		// 	$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 	// WRITE LOG IPN END

		// 	// UPDATE TABLE IPN TRADE MANAGER START
		// 	$data  = [
		// 		'amount'      => $received_amount,
		// 		'state'       => 'pending',
		// 		'status_code' => $status,
		// 		'updated_at'  => $this->datetime,
		// 	];
		// 	$where = ['txn_id' => $txn_id];
		// 	$this->M_core->update('coinpayment_ipn_trade_manager', $data, $where);
		// 	// UPDATE TABLE IPN TRADE MANAGER END

		// 	// UPDATE MEMBER TRADE MANAGER START
		// 	$data = [
		// 		'state'      => 'pending',
		// 		'updated_at' => $this->datetime,
		// 	];
		// 	$where = ['txn_id' => $txn_id];
		// 	$this->M_core->update('member_trade_manager', $data, $where);
		// 	// UPDATE MEMBER TRADE MANAGER START

		// 	// STORE LOG MEMBER TRADE MANAGER START
		// 	$description = "[$this->datetime] Member $db_buyer_email Package $item_name Pending";
		// 	$where_count = [
		// 		'id_member' => $db_id_member,
		// 		'invoice'   => $invoice,
		// 		'state'     => 'pending',
		// 	];
		// 	$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

		// 	if ($arr_count->num_rows() == 0) {
		// 		$data_log = [
		// 			'id_member'         => $db_id_member,
		// 			'invoice'           => $invoice,
		// 			'amount_invest'     => $db_amount_usd,
		// 			'amount_transfer'   => $db_amount_coin,
		// 			'currency_transfer' => $currency2,
		// 			'txn_id'            => $txn_id,
		// 			'state'             => 'pending',
		// 			'description'       => $description,
		// 			'created_at'        => $this->datetime,
		// 			'updated_at'        => $this->datetime,
		// 		];
		// 		$this->M_core->store_uuid('log_member_trade_manager', $data_log);
		// 	} else {
		// 		$data_log = [
		// 			'description' => $description,
		// 			'updated_at'  => $this->datetime,
		// 		];
		// 		$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
		// 	}
		// 	// STORE LOG MEMBER TRADE MANAGER END

		// } elseif ($status == 100 || $status == 2) {
		// 	//  Payment Complete. We have sent your coins to your payment address or 3rd party payment system reports the payment complete
		// 	if (in_array($db_state, ['waiting payment', 'pending'])) {
		// 		// WRITE LOG IPN START
		// 		$object = [
		// 			'ipn_version'       => $ipn_version,
		// 			'ipn_type'          => $ipn_type,
		// 			'ipn_mode'          => $ipn_mode,
		// 			'ipn_id'            => $ipn_id,
		// 			'merchant'          => $merchant,
		// 			'description'       => 'Invoice ' . $invoice . ' Order Active',
		// 			'status'            => $status,
		// 			'status_text'       => $status_text,
		// 			'txn_id'            => $txn_id,
		// 			'currency1'         => $currency1,
		// 			'currency2'         => $currency2,
		// 			'amount1'           => $amount1,
		// 			'amount2'           => $amount2,
		// 			'fee'               => $fee,
		// 			'buyer_name'        => $buyer_name,
		// 			'email'             => $email,
		// 			'item_name'         => $item_name,
		// 			'item_number'       => $item_number,
		// 			'invoice'           => $invoice,
		// 			'received_amount'   => $received_amount,
		// 			'received_confirms' => $received_confirms,
		// 			'created_at'        => $this->datetime,
		// 		];
		// 		$this->M_core->store_uuid('log_ipn_trade_manager', $object);
		// 		// WRITE LOG IPN END

		// 		// PERSIAPAN SEBELUM BAGI-BAGI BONUS START
		// 		$arr_member = $this->M_core->get('member', 'id_upline', ['id' => $db_id_member]);
		// 		$id_upline  = $arr_member->row()->id_upline;

		// 		$arr_upline        = $this->M_core->get('member', 'email, fullname, deleted_at', ['id' => $id_upline]);
		// 		$email_upline      = $arr_upline->row()->email;
		// 		$fullname_upline   = $arr_upline->row()->fullname;
		// 		$deleted_at_upline = $arr_upline->row()->deleted_at;
		// 		// PERSIAPAN SEBELUM BAGI-BAGI BONUS END

		// 		// PART BONUS SPONSOR START
		// 		if ($arr_upline->num_rows() == 1) {
		// 			$amount_bonus_upline = ($db_amount_usd * 10) / 100;

		// 			$this->_distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $buyer_name, $db_buyer_email, $db_id_member, $invoice, $db_id_package, $item_name, $db_amount_usd);
		// 		}
		// 		// PART BONUS SPONSOR END

		// 		// PART QUALIFIKASI LEVEL START
		// 		if ($db_is_qualified == "no") {
		// 			$member_is_qualified = $this->_update_qualified($db_id_member, $id_upline, $db_amount_usd, $invoice, $db_id_package, $item_name);
		// 		}
		// 		// PART QUALIFIKASI LEVEL END

		// 		// PART ROYALTY START
		// 		if ($db_is_royalty == "no") {
		// 			$member_is_royalty = $this->_update_royalty($db_id_member, $db_amount_usd, $invoice, $db_id_package, $item_name);
		// 		}
		// 		// PART ROYALTY END

		// 		// UPDATE TOTAL OMSET START
		// 		$update_omset = $this->_update_omset($db_id_member, $db_amount_usd);
		// 		if ($update_omset === false) {
		// 			$this->db->trans_rollback();
		// 			$return = [
		// 				'code'        => 500,
		// 				'status_text' => "Failed to Update Upline Sales Turnover",
		// 			];
		// 			echo json_encode($return);
		// 			exit;
		// 		}
		// 		// UPDATE TOTAL OMSET END

		// 		// UPDATE TABLE IPN TRADE MANAGER START
		// 		$where = ['txn_id' => $txn_id];
		// 		$data  = [
		// 			'amount'      => $received_amount,
		// 			'state'       => 'active',
		// 			'status_code' => $status,
		// 			'updated_at'  => $this->datetime,
		// 		];
		// 		$this->M_core->update('coinpayment_ipn_trade_manager', $data, $where);
		// 		// UPDATE TABLE IPN TRADE MANAGER END

		// 		// UPDATE MEMBER TRADE MANAGER START
		// 		$data = [
		// 			'state'        => 'active',
		// 			'is_qualified' => $member_is_qualified,
		// 			'is_royalty'   => $member_is_royalty,
		// 			'updated_at'   => $this->datetime,
		// 		];
		// 		$this->M_core->update('member_trade_manager', $data, $where);
		// 		// UPDATE MEMBER TRADE MANAGER START

		// 		// UPDATE MEMBER BALANCE START
		// 		$this->M_trade_manager->update_member_trade_manager_asset($db_id_member, $db_amount_usd);
		// 		// UPDATE MEMBER BALANCE END

		// 		// STORE LOG MEMBER TRADE MANAGER START
		// 		$description = "[$this->datetime] Member $db_buyer_email Package $item_name Active";
		// 		$where_count = [
		// 			'id_member' => $db_id_member,
		// 			'invoice'   => $invoice,
		// 			'state'     => 'active',
		// 		];
		// 		$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

		// 		if ($arr_count->num_rows() == 0) {
		// 			$data_log = [
		// 				'id_member'         => $db_id_member,
		// 				'invoice'           => $invoice,
		// 				'amount_invest'     => $db_amount_usd,
		// 				'amount_transfer'   => $db_amount_coin,
		// 				'currency_transfer' => $currency2,
		// 				'txn_id'            => $txn_id,
		// 				'state'             => 'active',
		// 				'description'       => $description,
		// 				'created_at'        => $this->datetime,
		// 				'updated_at'        => $this->datetime,
		// 			];
		// 			$this->M_core->store_uuid('log_member_trade_manager', $data_log);
		// 		} else {
		// 			$data_log = [
		// 				'description' => $description,
		// 				'updated_at'  => $this->datetime,
		// 			];
		// 			$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
		// 		}
		// 		// STORE LOG MEMBER TRADE MANAGER END

		// 		// SEND EMAIL PACKAGE ACTIVE START
		// 		$this->_send_package_active($db_id_member, $db_buyer_email, $invoice, $item_name);
		// 		// SEND EMAIL PACKAGE ACTIVE END
		// 	}
		// }

		// $this->db->trans_commit();
		// die('IPN OK');
	}

	public function errorAndDie($error_msg)
	{
		$cp_debug_email = $this->debug_email;
		if (!empty($cp_debug_email)) {
			$report = 'Error: ' . $error_msg . "\n\n";
			$report .= "POST Data\n\n";
			foreach ($_POST as $k => $v) {
				$report .= "|$k| = |$v|\n";
			}
			mail($cp_debug_email, 'CoinPayments IPN Error', $report);
		}
		die('IPN Error: ' . $error_msg);
		exit;
	}

	public function success($invoice = null)
	{
		if ($invoice == null) {
			return show_error("Invoice Can't empty");
		}

		// cek invoice data here
		echo "Success";
	}

	public function cancel($invoice = null)
	{
		if ($invoice == null) {
			return show_error("Invoice Can't empty");
		}

		// cek invoice data here
		echo "Cancel";
	}
}
        
/* End of file  CoinPayment.php */
