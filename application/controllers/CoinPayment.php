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

		$req['amount'] = 100;
		$req['currency1'] = 'USD';
		$req['currency2'] = 'LTCT';
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

			$this->M_core->store('test_ipn', $data);
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

		$req['amount'] = 1;
		$req['add_tx_fee'] = 0; // if 1, TX Fee will given to Sender, if 0, it will reduce from amount transfer
		$req['currency'] = 'LTCT';

		/*
		Optional currency to use to to withdraw 'amount' worth of 'currency2' in 'currency' coin. This is for exchange rate calculation only and will not convert coins or change which currency is withdrawn.
		For example, to withdraw 1.00 USD worth of BTC you would specify 'currency'='BTC', 'currency2'='USD', and 'amount'='1.00' 
		*/
		// $req['currency2'] = 'USD';

		$req['address'] = 'QeGjKpdRu5MBbzy6LMXDP8TPMnSzws6TfL';
		$req['ipn_url'] = site_url('coinpayment/ipn');
		$req['auto_confirm'] = 0; // if set to 1 withdraw will complete without email confirmation
		$req['note'] = 'withdraw from coinpayment to external wallet';

		$exec = $this->coinpayments_api_call('create_withdrawal', $req);

		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
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
		$req['amount'] = 1;
		$req['from'] = 'LTCT';
		$req['to'] = 'LTC';

		/*
		The address to send the funds to. If blank or not included the coins will go to your CoinPayments Wallet.
		*/
		$req['address'] = '';
		$exec = $this->coinpayments_api_call('convert', $req);
		if ($exec['error'] == "ok") {
			$code = 200;
		}

		$result = [
			'code' => $code,
			'data' => $exec['result'],
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function convert_limits()
	{
		header('Content-Type: application/json');
		$code = 500;

		$req['from'] = 'DOGE';
		$req['to'] = 'TRX';

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

	public function ipn_trade_manager()
	{
		$this->db->trans_begin();

		// Fill these in with the information from your CoinPayments.net account.
		$merchant_id    = $this->merchant_id;
		$ipn_secret_key = $this->ipn_secret_key;

		// HMAC Signature verified at this point, load some variables.
		$ipn_version       = $_POST['ipn_version'];
		$ipn_type          = $_POST['ipn_type'];
		$ipn_mode          = $_POST['ipn_mode'];
		$ipn_id            = $_POST['ipn_id'];
		$merchant          = $_POST['merchant'];
		$status            = intval($_POST['status']);
		$status_text       = $_POST['status_text'];
		$txn_id            = $_POST['txn_id'];
		$currency1         = $_POST['currency1'];
		$currency2         = $_POST['currency2'];
		$amount1           = floatval($_POST['amount1']);
		$amount2           = floatval($_POST['amount2']);
		$fee               = $_POST['fee'];
		$buyer_name        = $_POST['buyer_name'];
		$email             = $_POST['email'];
		$item_name         = $_POST['item_name'];
		$item_number       = $_POST['item_number'];
		$invoice           = $_POST['invoice'];
		$received_amount   = floatval($_POST['received_amount']);
		$received_confirms = floatval($_POST['received_confirms']);

		if (!isset($ipn_mode) || $ipn_mode != 'hmac') {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'IPN Mode is not HMAC',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('IPN Mode is not HMAC');
		}

		if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'No HMAC signature sent.',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('No HMAC signature sent.');
		}

		$request = file_get_contents('php://input');
		if ($request === FALSE || empty($request)) {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'Error reading POST data',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('Error reading POST data');
		}

		if (!isset($merchant) || $merchant != trim($merchant_id)) {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'No or incorrect Merchant ID passed',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('No or incorrect Merchant ID passed');
		}

		$hmac = hash_hmac("sha512", $request, trim($ipn_secret_key));
		if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'HMAC signature does not match',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('HMAC signature does not match');
		}

		if ($ipn_type != 'api') {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'IPN OK: Not a API payment',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('IPN OK: Not a API payment');
		}

		//These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field.
		$where_order = [
			'invoice'    => $invoice,
			'txn_id'     => $txn_id,
			'deleted_at' => null
		];
		$arr_order = $this->M_core->get('member_trade_manager', '*', $where_order);

		if ($arr_order->num_rows() == 0) {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'Invoice ' . $invoice . ' Not Found',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('Invoice ' . $invoice . ' Not Found');
		}

		// KELUARKAN HASIL DARI DB TABLE MEMBER TRADE MANAGER
		$db_invoice                 = $arr_order->row()->invoice;
		$db_id_member               = $arr_order->row()->id_member;
		$db_id_package              = $arr_order->row()->id_package;
		$db_payment_method          = $arr_order->row()->payment_method;
		$db_amount_usd              = $arr_order->row()->amount_usd;
		$db_profit_self_per_day     = $arr_order->row()->profit_self_per_day;
		$db_profit_upline_per_day   = $arr_order->row()->profit_upline_per_day;
		$db_profit_company_per_day  = $arr_order->row()->profit_company_per_day;
		$db_currency1               = $arr_order->row()->currency1;
		$db_currency2               = $arr_order->row()->currency2;
		$db_buyer_email             = $arr_order->row()->buyer_email;
		$db_buyer_name              = $arr_order->row()->buyer_name;
		$db_item_name               = $arr_order->row()->item_name;
		$db_state                   = $arr_order->row()->state;
		$db_txn_id                  = $arr_order->row()->txn_id;
		$db_amount_coin             = $arr_order->row()->amount_coin;
		$db_receiver_wallet_address = $arr_order->row()->receiver_wallet_address;
		$db_timeout                 = $arr_order->row()->timeout;
		$db_checkout_url            = $arr_order->row()->checkout_url;
		$db_status_url              = $arr_order->row()->status_url;
		$db_qrcode_url              = $arr_order->row()->qrcode_url;
		$db_expired_at              = $arr_order->row()->expired_at;
		$db_is_qualified            = $arr_order->row()->is_qualified;
		$db_is_royalty              = $arr_order->row()->is_royalty;
		$db_is_extend               = $arr_order->row()->is_extend;

		$order_currency = 'USDT';
		$order_total    = $db_amount_usd;
		// Check the original currency to make sure the buyer didn't change it.
		if ($currency1 != $order_currency) {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'Invoice ' . $invoice . ' Original currency mismatch!',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('Invoice ' . $invoice . ' Original currency mismatch!');
		}

		// Check amount against order total
		if ($amount1 < $order_total) {
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'Invoice ' . $invoice . ' Amount is less than order total!',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			$this->db->trans_commit();

			$this->errorAndDie('Invoice ' . $invoice . ' Amount is less than order total!');
		}

		// VALIDASI TRANSACTION
		if ($status == -1) {
			// Cancelled / Timed Out

			// WRITE LOG IPN START
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'Invoice ' . $invoice . ' Order Canceled / Timeout',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			// WRITE LOG IPN END

			// UPDATE TABLE IPN TRADE MANAGER START
			$data  = [
				'amount'      => $received_amount,
				'state'       => 'cancel',
				'status_code' => $status,
				'updated_at'  => $this->datetime,
			];
			$where = ['txn_id' => $txn_id];
			$this->M_core->update('coinpayment_ipn_trade_manager', $data, $where);
			// UPDATE TABLE IPN TRADE MANAGER END

			// UPDATE MEMBER TRADE MANAGER START
			$data = [
				'state'      => 'cancel',
				'updated_at' => $this->datetime,
			];
			$where = ['txn_id' => $txn_id];
			$this->M_core->update('member_trade_manager', $data, $where);
			// UPDATE MEMBER TRADE MANAGER START

			// STORE LOG MEMBER TRADE MANAGER START
			$description = "[$this->datetime] Member $db_buyer_email Package $item_name Cancel";
			$where_count = [
				'id_member' => $db_id_member,
				'invoice'   => $invoice,
				'state'     => 'cancel',
			];
			$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

			if ($arr_count->num_rows() == 0) {
				$data_log = [
					'id_member'         => $db_id_member,
					'invoice'           => $invoice,
					'amount_invest'     => $db_amount_usd,
					'amount_transfer'   => $db_amount_coin,
					'currency_transfer' => $currency2,
					'txn_id'            => $txn_id,
					'state'             => 'cancel',
					'description'       => $description,
					'created_at'        => $this->datetime,
					'updated_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_member_trade_manager', $data_log);
			} else {
				$data_log = [
					'description' => $description,
					'updated_at'  => $this->datetime,
				];
				$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
			}
			// STORE LOG MEMBER TRADE MANAGER END

			// SEND EMAIL PACKAGE ACTIVE START
			$this->_send_package_cancel($db_id_member, $db_buyer_email, $invoice, $item_name);
			// SEND EMAIL PACKAGE ACTIVE END

		} elseif ($status == 0) {
			// Waiting for buyer funds

			// WRITE LOG IPN START
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'Invoice ' . $invoice . ' Order Waiting Payment',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			// WRITE LOG IPN END

			// UPDATE TABLE IPN TRADE MANAGER START
			$data  = [
				'amount'      => $received_amount,
				'state'       => 'waiting payment',
				'status_code' => $status,
				'updated_at'  => $this->datetime,
			];
			$where = ['txn_id' => $txn_id];
			$this->M_core->update('coinpayment_ipn_trade_manager', $data, $where);
			// UPDATE TABLE IPN TRADE MANAGER END

			// UPDATE MEMBER TRADE MANAGER START
			$data = [
				'state'      => 'waiting payment',
				'updated_at' => $this->datetime,
			];
			$where = ['txn_id' => $txn_id];
			$this->M_core->update('member_trade_manager', $data, $where);
			// UPDATE MEMBER TRADE MANAGER START

			// STORE LOG MEMBER TRADE MANAGER START
			$description = "[$this->datetime] Member $db_buyer_email Package $item_name Waiting Payment";
			$where_count = [
				'id_member' => $db_id_member,
				'invoice'   => $invoice,
				'state'     => 'waiting payment',
			];
			$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

			if ($arr_count->num_rows() == 0) {
				$data_log = [
					'id_member'         => $db_id_member,
					'invoice'           => $invoice,
					'amount_invest'     => $db_amount_usd,
					'amount_transfer'   => $db_amount_coin,
					'currency_transfer' => $currency2,
					'txn_id'            => $txn_id,
					'state'             => 'waiting payment',
					'description'       => $description,
					'created_at'        => $this->datetime,
					'updated_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_member_trade_manager', $data_log);
			} else {
				$data_log = [
					'description' => $description,
					'updated_at'  => $this->datetime,
				];
				$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
			}
			// STORE LOG MEMBER TRADE MANAGER END

			// SEND EMAIL PACKAGE ACTIVE START
			$this->_send_package_waiting_payment($db_id_member, $db_buyer_email, $invoice, $item_name);
			// SEND EMAIL PACKAGE ACTIVE END
		} elseif ($status == 1) {
			//  We have confirmed coin reception from the buyer

			// WRITE LOG IPN START
			$object = [
				'ipn_version'       => $ipn_version,
				'ipn_type'          => $ipn_type,
				'ipn_mode'          => $ipn_mode,
				'ipn_id'            => $ipn_id,
				'merchant'          => $merchant,
				'description'       => 'Invoice ' . $invoice . ' Order Pending',
				'status'            => $status,
				'status_text'       => $status_text,
				'txn_id'            => $txn_id,
				'currency1'         => $currency1,
				'currency2'         => $currency2,
				'amount1'           => $amount1,
				'amount2'           => $amount2,
				'fee'               => $fee,
				'buyer_name'        => $buyer_name,
				'email'             => $email,
				'item_name'         => $item_name,
				'item_number'       => $item_number,
				'invoice'           => $invoice,
				'received_amount'   => $received_amount,
				'received_confirms' => $received_confirms,
				'created_at'        => $this->datetime,
			];
			$this->M_core->store_uuid('log_ipn_trade_manager', $object);
			// WRITE LOG IPN END

			// UPDATE TABLE IPN TRADE MANAGER START
			$data  = [
				'amount'      => $received_amount,
				'state'       => 'pending',
				'status_code' => $status,
				'updated_at'  => $this->datetime,
			];
			$where = ['txn_id' => $txn_id];
			$this->M_core->update('coinpayment_ipn_trade_manager', $data, $where);
			// UPDATE TABLE IPN TRADE MANAGER END

			// UPDATE MEMBER TRADE MANAGER START
			$data = [
				'state'      => 'pending',
				'updated_at' => $this->datetime,
			];
			$where = ['txn_id' => $txn_id];
			$this->M_core->update('member_trade_manager', $data, $where);
			// UPDATE MEMBER TRADE MANAGER START

			// STORE LOG MEMBER TRADE MANAGER START
			$description = "[$this->datetime] Member $db_buyer_email Package $item_name Pending";
			$where_count = [
				'id_member' => $db_id_member,
				'invoice'   => $invoice,
				'state'     => 'pending',
			];
			$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

			if ($arr_count->num_rows() == 0) {
				$data_log = [
					'id_member'         => $db_id_member,
					'invoice'           => $invoice,
					'amount_invest'     => $db_amount_usd,
					'amount_transfer'   => $db_amount_coin,
					'currency_transfer' => $currency2,
					'txn_id'            => $txn_id,
					'state'             => 'pending',
					'description'       => $description,
					'created_at'        => $this->datetime,
					'updated_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_member_trade_manager', $data_log);
			} else {
				$data_log = [
					'description' => $description,
					'updated_at'  => $this->datetime,
				];
				$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
			}
			// STORE LOG MEMBER TRADE MANAGER END

		} elseif ($status == 100 || $status == 2) {
			//  Payment Complete. We have sent your coins to your payment address or 3rd party payment system reports the payment complete
			if (in_array($db_state, ['waiting payment', 'pending'])) {
				// WRITE LOG IPN START
				$object = [
					'ipn_version'       => $ipn_version,
					'ipn_type'          => $ipn_type,
					'ipn_mode'          => $ipn_mode,
					'ipn_id'            => $ipn_id,
					'merchant'          => $merchant,
					'description'       => 'Invoice ' . $invoice . ' Order Active',
					'status'            => $status,
					'status_text'       => $status_text,
					'txn_id'            => $txn_id,
					'currency1'         => $currency1,
					'currency2'         => $currency2,
					'amount1'           => $amount1,
					'amount2'           => $amount2,
					'fee'               => $fee,
					'buyer_name'        => $buyer_name,
					'email'             => $email,
					'item_name'         => $item_name,
					'item_number'       => $item_number,
					'invoice'           => $invoice,
					'received_amount'   => $received_amount,
					'received_confirms' => $received_confirms,
					'created_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_ipn_trade_manager', $object);
				// WRITE LOG IPN END

				// PERSIAPAN SEBELUM BAGI-BAGI BONUS START
				$arr_member = $this->M_core->get('member', 'id_upline', ['id' => $db_id_member]);
				$id_upline  = $arr_member->row()->id_upline;

				$arr_upline        = $this->M_core->get('member', 'email, fullname, deleted_at', ['id' => $id_upline]);
				$email_upline      = $arr_upline->row()->email;
				$fullname_upline   = $arr_upline->row()->fullname;
				$deleted_at_upline = $arr_upline->row()->deleted_at;
				// PERSIAPAN SEBELUM BAGI-BAGI BONUS END

				// PART BONUS SPONSOR START
				if ($arr_upline->num_rows() == 1) {
					$amount_bonus_upline = ($db_amount_usd * 10) / 100;

					$this->_distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $buyer_name, $db_buyer_email, $db_id_member, $invoice, $db_id_package, $item_name, $db_amount_usd);
				}
				// PART BONUS SPONSOR END

				// PART QUALIFIKASI LEVEL START
				if ($db_is_qualified == "no") {
					$member_is_qualified = $this->_update_qualified($db_id_member, $id_upline, $db_amount_usd, $invoice, $db_id_package, $item_name);
				}
				// PART QUALIFIKASI LEVEL END

				// PART ROYALTY START
				if ($db_is_royalty == "no") {
					$member_is_royalty = $this->_update_royalty($db_id_member, $db_amount_usd, $invoice, $db_id_package, $item_name);
				}
				// PART ROYALTY END

				// UPDATE TOTAL OMSET START
				$update_omset = $this->_update_omset($db_id_member, $db_amount_usd);
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

				// UPDATE TABLE IPN TRADE MANAGER START
				$where = ['txn_id' => $txn_id];
				$data  = [
					'amount'      => $received_amount,
					'state'       => 'active',
					'status_code' => $status,
					'updated_at'  => $this->datetime,
				];
				$this->M_core->update('coinpayment_ipn_trade_manager', $data, $where);
				// UPDATE TABLE IPN TRADE MANAGER END

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'        => 'active',
					'is_qualified' => $member_is_qualified,
					'is_royalty'   => $member_is_royalty,
					'updated_at'   => $this->datetime,
				];
				$this->M_core->update('member_trade_manager', $data, $where);
				// UPDATE MEMBER TRADE MANAGER START

				// UPDATE MEMBER BALANCE START
				$this->M_trade_manager->update_member_trade_manager_asset($db_id_member, $db_amount_usd);
				// UPDATE MEMBER BALANCE END

				// STORE LOG MEMBER TRADE MANAGER START
				$description = "[$this->datetime] Member $db_buyer_email Package $item_name Active";
				$where_count = [
					'id_member' => $db_id_member,
					'invoice'   => $invoice,
					'state'     => 'active',
				];
				$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $db_id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $db_amount_usd,
						'amount_transfer'   => $db_amount_coin,
						'currency_transfer' => $currency2,
						'txn_id'            => $txn_id,
						'state'             => 'active',
						'description'       => $description,
						'created_at'        => $this->datetime,
						'updated_at'        => $this->datetime,
					];
					$this->M_core->store_uuid('log_member_trade_manager', $data_log);
				} else {
					$data_log = [
						'description' => $description,
						'updated_at'  => $this->datetime,
					];
					$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
				}
				// STORE LOG MEMBER TRADE MANAGER END

				// SEND EMAIL PACKAGE ACTIVE START
				$this->_send_package_active($db_id_member, $db_buyer_email, $invoice, $item_name);
				// SEND EMAIL PACKAGE ACTIVE END
			}
		}

		$this->db->trans_commit();
		die('IPN OK');
	}

	function errorAndDie($error_msg)
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
	}

	public function success_trade_manager()
	{
		echo "Success";
	}

	public function cancel_trade_manager()
	{
		echo "Cancel";
	}

	protected function _distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $buyer_name, $db_buyer_email, $db_id_member, $invoice, $db_id_package, $item_name, $db_amount_usd)
	{
		if ($id_upline != null) {
			if ($deleted_at_upline == null) {
				$this->M_trade_manager->update_member_bonus($id_upline, $amount_bonus_upline);

				$id_upline_log = $id_upline;
				$desc_log      = "$fullname_upline ($email_upline) get bonus recruitment of member $buyer_name ($db_buyer_email) $amount_bonus_upline USDT";
			} else {
				$this->M_trade_manager->update_unknown_balance($amount_bonus_upline);

				$id_upline_log = null;
				$desc_log      = "Unknown Balance get bonus recruitment of member $buyer_name ($db_buyer_email) $amount_bonus_upline USDT";
			}

			// LOG BONUS RECRUITMENT START
			$data_log = [
				'id_member'      => $id_upline_log,
				'id_downline'    => $db_id_member,
				'type_package'   => 'trade manager',
				'invoice'        => $invoice,
				'id_package'     => $db_id_package,
				'package_name'   => $item_name,
				'package_amount' => $db_amount_usd,
				'state'          => 'get bonus',
				'description'    => $desc_log,
				'created_at'     => $this->datetime,
			];
			$this->M_core->store_uuid('log_bonus_recruitment', $data_log);
			// LOG BONUS RECRUITMENT END
		}
	}

	protected function _update_qualified($id_member, $id_upline, $amount_usd, $invoice, $id_package, $item_name)
	{

		$member_is_qualified = "no";

		$arr_member      = $this->M_core->get('member', 'email, fullname', ['id' => $id_member]);
		$email_member    = $arr_member->row()->email;
		$fullname_member = $arr_member->row()->fullname;

		$arr_ql_sibling_tm = $this->M_trade_manager->get_ql_sibling($id_member, $id_upline);

		if ($arr_ql_sibling_tm->num_rows() == 0) {
			$arr_ql_sibling_ca = $this->M_crypto_asset->get_ql_sibling($id_member, $id_upline);

			if ($arr_ql_sibling_ca->num_rows() > 0) {
				$invoice_ql_sibling     = $arr_ql_sibling_ca->row()->invoice;
				$id_member_ql_sibling   = $arr_ql_sibling_ca->row()->id_member;
				$amount_usd_ql_sibling  = $arr_ql_sibling_ca->row()->amount_usd;
				$id_package_ql_sibling  = $arr_ql_sibling_ca->row()->id_package;
				$item_name_ql_sibling   = $arr_ql_sibling_ca->row()->item_name;
				$buyer_email_ql_sibling = $arr_ql_sibling_ca->row()->buyer_email;
				$buyer_name_ql_sibling  = $arr_ql_sibling_ca->row()->buyer_name;

				$bonus_grand_upline             = ($amount_usd * 5) / 100;
				$amount_usd_ql_sibling_as_bonus = ($amount_usd_ql_sibling * 5) / 100;
				$new_bonus_grand_upline         = $bonus_grand_upline + $amount_usd_ql_sibling_as_bonus;

				if ($new_bonus_grand_upline > 0) {

					$where_grand_upline = [
						'id'         => $id_upline,
						'deleted_at' => null,
					];
					$arr_grand_upline       = $this->M_core->get('member', 'id_upline, email, fullname, is_active', $where_grand_upline);
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
		} elseif ($arr_ql_sibling_tm->num_rows() > 0) {
			$invoice_ql_sibling     = $arr_ql_sibling_tm->row()->invoice;
			$id_member_ql_sibling   = $arr_ql_sibling_tm->row()->id_member;
			$amount_usd_ql_sibling  = $arr_ql_sibling_tm->row()->amount_usd;
			$id_package_ql_sibling  = $arr_ql_sibling_tm->row()->id_package;
			$item_name_ql_sibling   = $arr_ql_sibling_tm->row()->item_name;
			$buyer_email_ql_sibling = $arr_ql_sibling_tm->row()->buyer_email;
			$buyer_name_ql_sibling  = $arr_ql_sibling_tm->row()->buyer_name;

			$bonus_grand_upline             = ($amount_usd * 5) / 100;
			$amount_usd_ql_sibling_as_bonus = ($amount_usd_ql_sibling * 5) / 100;
			$new_bonus_grand_upline         = $bonus_grand_upline + $amount_usd_ql_sibling_as_bonus;

			if ($new_bonus_grand_upline > 0) {

				$where_grand_upline = [
					'id'         => $id_upline,
					'deleted_at' => null,
				];
				$arr_grand_upline       = $this->M_core->get('member', 'id_upline, email, fullname, is_active', $where_grand_upline);
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

		$arr_generation = $this->M_core->get('et_tree', 'id_member', ['depth <' => $depth, 'lft <' => $lft, 'rgt >' => $rgt], 'depth', 'desc', 10);

		if ($arr_generation->num_rows() > 1) {
			$itteration_gen = 0;
			foreach ($arr_generation->result() as $key_gen) {
				$id_gen       = $key_gen->id_member;

				$where_gen = [
					'id'         => $id_gen,
					'deleted_at' => null
				];
				$arr_gen = $this->M_core->get('member', 'fullname, email, is_active', $where_gen);

				if ($arr_gen->num_rows() == 1) {
					$fullname_gen  = $arr_gen->row()->fullname;
					$email_gen     = $arr_gen->row()->email;
					$is_active_gen = $arr_gen->row()->is_active;

					$array_group_1 = [1];
					$array_group_2 = [2, 3, 4, 5, 6];
					$array_group_3 = [7, 8, 9, 10];
					$array_group   = array_merge($array_group_1, $array_group_2, $array_group_3);

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
							$desc_log      = "$fullname_gen ($email_gen) get bonus royalty of member $fullname_member ($email_member) $bonus_royalty USDT";
						} else {
							$this->M_trade_manager->update_unknown_bonus($bonus_royalty);

							$id_member_log = null;
							$desc_log      = "Unknown Balance get bonus royalty of member $fullname_member ($email_member) $bonus_royalty USDT";
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

	protected function _send_package_cancel($id, $to, $invoice, $item_name): bool
	{
		$subject = APP_NAME . " | $invoice - Package $item_name Cancel";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data['arr_data'] = $this->M_core->get('member_trade_manager', '*', ['id_member' => $id]);
		$message = $this->load->view('emails/package_cancel_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	protected function _send_package_waiting_payment($id, $to, $invoice, $item_name): bool
	{
		$subject = APP_NAME . " | $invoice - Package $item_name Waiting Payment";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data['arr_data'] = $this->M_core->get('member_trade_manager', '*', ['id_member' => $id]);
		$message = $this->load->view('emails/package_waiting_payment_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	protected function _send_package_active($id, $to, $invoice, $item_name): bool
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
}
        
/* End of file  CoinPayment.php */
