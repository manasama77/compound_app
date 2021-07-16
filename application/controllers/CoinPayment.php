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
		$this->api_link       	= 'https://www.coinpayments.net/api.php';
		$this->public_key     	= '0d79d9c15454272a3ea638332ff716217b1530d57d2bb8023a0b5835a4c2c6bd';
		$this->private_key    	= '90c986299927C62d1250999244da7fEF08263769818AA8875e90e446f5d78d30';
		$this->merchant_id    	= '12d2c4c617ebe6fb9e401a92ed7039fd';
		$this->ipn_secret_key 	= 'YmlvbmVyIElQTg==';
		$this->debug_email    	= 'adam.pm59@gmail.com';
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

	public function ipn()
	{
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

		if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
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

		if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
			$this->errorAndDie('IPN Mode is not HMAC');
		}

		if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
			$this->errorAndDie('No HMAC signature sent.');
		}

		$request = file_get_contents('php://input');
		if ($request === FALSE || empty($request)) {
			$this->errorAndDie('Error reading POST data');
		}

		if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($merchant_id)) {
			$this->errorAndDie('No or incorrect Merchant ID passed');
		}

		$hmac = hash_hmac("sha512", $request, trim($ipn_secret_key));
		if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
			$this->errorAndDie('HMAC signature does not match');
		}

		// HMAC Signature verified at this point, load some variables.

		$ipn_type    = $_POST['ipn_type'];
		$txn_id      = $_POST['txn_id'];
		$item_name   = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$amount1     = floatval($_POST['amount1']);
		$amount2     = floatval($_POST['amount2']);
		$currency1   = $_POST['currency1'];
		$currency2   = $_POST['currency2'];
		$status      = intval($_POST['status']);
		$status_text = $_POST['status_text'];

		if ($ipn_type != 'button') { // Advanced Button payment
			die("IPN OK: Not a button payment");
		}

		//depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

		// Check the original currency to make sure the buyer didn't change it.
		if ($currency1 != $order_currency) {
			$this->errorAndDie('Original currency mismatch!');
		}

		// Check amount against order total
		if ($amount1 < $order_total) {
			$this->errorAndDie('Amount is less than order total!');
		}

		$where = ['txn_id' => $txn_id];

		if ($status >= 100 || $status == 2) {
			// payment is complete or queued for nightly payout, success
			$state = 'active';
		} else if ($status < 0) {
			//payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
			$state = 'cancel';
		} else {
			//payment is pending, you can optionally add a note to the order page
			$state = 'pending';
		}

		$where = ['txn_id' => $txn_id];
		$data  = [
			'state'       => $state,
			'status_code' => $status,
			'updated_at'  => $this->datetime,
		];
		$this->M_core->update('coinpayment_ipn', $data, $where);

		$data = [
			'state'      => $state,
			'updated_at' => $this->datetime,
		];
		$this->M_core->update('member_trade_manager', $data, $where);

		$where = [
			'id_member' => $this->session->userdata(SESI . 'id'),
			'state'     => 'active',
		];
		$arr = $this->M_core->get('member_trade_manager', 'amount_usd', $where);

		$total_invest_trade_manager = 0;
		$count_trade_manager        = 0;

		if ($arr->num_rows() > 0) {
			foreach ($arr->result() as $key) {
				$total_invest_trade_manager += $key->amount_usd;
				$count_trade_manager++;
			}
		}

		$data = [
			'total_invest_trade_manager' => $total_invest_trade_manager,
			'count_trade_manager'        => $count_trade_manager,
			'updated_at'                 => $this->datetime,
		];
		$where = ['id_member' => $this->session->userdata(SESI . 'id')];
		$this->M_core->update('member_balance', $data, $where);

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

	public function success()
	{
		echo "Success";
	}

	public function cancel()
	{
		echo "Cancel";
	}
}
        
/* End of file  CoinPayment.php */
