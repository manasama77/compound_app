<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TaskSchedulerController extends CI_Controller
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

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nested_set', null, 'Nested_set');
		$this->load->helper('Custom_array_helper');
		$this->load->model('M_trade_manager');
		$this->load->model('M_member');
		$this->load->model('M_withdraw');
		$this->load->model('M_log_send_email_member');

		$this->Nested_set->setControlParams('tree', 'lft', 'rgt', 'id_member', 'id_upline', 'email');

		$this->date           = date('Y-m-d');
		$this->datetime       = date('Y-m-d H:i:s');
		$this->api_link       = 'https://www.coinpayments.net/api.php';
		$this->public_key     = '0d79d9c15454272a3ea638332ff716217b1530d57d2bb8023a0b5835a4c2c6bd';
		$this->private_key    = '90c986299927C62d1250999244da7fEF08263769818AA8875e90e446f5d78d30';
		$this->merchant_id    = '12d2c4c617ebe6fb9e401a92ed7039fd';
		$this->ipn_secret_key = 'YmlvbmVyIElQTg == ';
		$this->from           = EMAIL_ADMIN;
		$this->from_alias     = 'Admin Test';
		$this->ip_address     = $this->input->ip_address();
		$this->user_agent     = $this->input->user_agent();
	}


	/*
	==============================
	Execute Every Day at 00:00 AM
	==============================
	*/
	public function profit_daily_trade_manager()
	{
		$key = "";
		$pass = "";

		$where_arr = [
			'state'      => 'active',
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member_trade_manager', '*', $where_arr);

		if ($arr->num_rows() > 0) {
			$this->_distribusi_daily_trade_manager($arr->result());
		}
	}

	protected function _distribusi_daily_trade_manager($arr)
	{
		$this->db->trans_begin();

		foreach ($arr as $key) {
			$invoice             = $key->invoice;
			$id_member           = $key->id_member;
			$id_package          = $key->id_package;
			$amount_usd          = $key->amount_usd;
			$profit_self_per_day = $key->profit_self_per_day;
			$currency1           = $key->currency1;
			$buyer_email         = $key->buyer_email;
			$buyer_name          = $key->buyer_name;
			$item_name           = $key->item_name;
			$expired_at          = $key->expired_at;

			$current_datetime_obj = new DateTime($this->datetime);
			$expired_datetime_obj = new DateTime($expired_at);
			$diff                 = $current_datetime_obj->diff($expired_datetime_obj);

			$arr_upline = $this->M_core->get('member', 'id_upline, email, fullname', ['id' => $id_member]);

			$id_upline       = "";
			$email_upline    = "";
			$fullname_upline = "";

			if ($arr_upline->row()->id_upline != null) {
				$id_upline       = $arr_upline->row()->id_upline;
				$email_upline    = $arr_upline->row()->email;
				$fullname_upline = $arr_upline->row()->fullname;
			}

			$select_trade_manager     = 'share_upline_percentage, share_upline_value, share_company_percentage, share_company_value';
			$where_trade_manager      = ['id' => $id_package];
			$arr_trade_manager        = $this->M_core->get('package_trade_manager', $select_trade_manager, $where_trade_manager);
			$share_upline_percentage  = $arr_trade_manager->row()->share_upline_percentage;
			$share_upline_value       = $arr_trade_manager->row()->share_upline_value;
			$share_company_percentage = $arr_trade_manager->row()->share_company_percentage;
			$share_company_value      = $arr_trade_manager->row()->share_company_value;

			if ($id_package == 6) {
				$share_upline_value = ($amount_usd * $share_upline_percentage) / 100;
				$share_company_value = ($amount_usd * $share_company_percentage) / 100;
			}

			$profit_self_per_day_formated = number_format($profit_self_per_day, 8);
			$share_upline_value_formated  = number_format($share_upline_value, 8);
			$share_company_value_formated = number_format($share_company_value, 8);

			$description1 = "$buyer_name ($buyer_email) get daily profit from trade manager package $item_name for $profit_self_per_day_formated $currency1";
			$description2a  = "$fullname_upline ($email_upline) get daily profit from downline $buyer_name ($buyer_email) trade manager package $item_name for $share_upline_value_formated $currency1";
			$description2b = "Unknown Balance get daily profit from downline $buyer_name ($buyer_email) trade manager package $item_name for $share_upline_value_formated $currency1";
			$description3 = "Unknown Balance get daily profit from downline $buyer_name ($buyer_email) trade manager package $item_name for $share_company_value_formated $currency1";

			if ($diff->format('%R') == "+") {
				//member get profit start
				$exec1 = $this->M_trade_manager->update_member_profit($id_member, $profit_self_per_day);

				/* LOG start */
				$data1 = [
					'id_member'    => $id_member,
					'invoice'      => $invoice,
					'id_package'   => $id_package,
					'package_name' => $item_name,
					'profit'       => $profit_self_per_day,
					'state'        => 'get bonus',
					'description'  => $description1,
					'created_at'   => $this->datetime,
				];
				$this->M_core->store_uuid('log_profit_trade_manager', $data1);
				/* LOG end */
				//member get profit end

				//upline get profit start
				if ($id_upline != null) {
					$exec2 = $this->M_trade_manager->update_member_profit($id_upline, $share_upline_value);

					/* LOG start */
					$data1 = [
						'id_member'    => $id_upline,
						'invoice'      => $invoice,
						'id_package'   => $id_package,
						'package_name' => $item_name,
						'profit'       => $share_upline_value,
						'state'        => 'get bonus',
						'description'  => $description2a,
						'created_at'   => $this->datetime,
					];
					$this->M_core->store_uuid('log_profit_trade_manager', $data1);
					/* LOG end */
				} else {
					$exec2 = $this->M_trade_manager->update_unknown_profit($share_upline_value);

					/* LOG start */
					$data1 = [
						'id_member'    => null,
						'invoice'      => $invoice,
						'id_package'   => $id_package,
						'package_name' => $item_name,
						'profit'       => $share_upline_value,
						'state'        => 'get bonus',
						'description'  => $description2b,
						'created_at'   => $this->datetime,
					];
					$this->M_core->store_uuid('log_profit_trade_manager', $data1);
					/* LOG end */
				}
				//upline get profit end

				//company get profit start
				$exec3 = $this->M_trade_manager->update_unknown_profit($share_company_value);

				/* LOG start */
				$data1 = [
					'id_member'    => null,
					'invoice'      => $invoice,
					'id_package'   => $id_package,
					'package_name' => $item_name,
					'profit'       => $share_company_value,
					'state'        => 'get bonus',
					'description'  => $description3,
					'created_at'   => $this->datetime,
				];
				$this->M_core->store_uuid('log_profit_trade_manager', $data1);
				/* LOG end */
				//company get profit end

				if (!$exec1 && !$exec2 && !$exec3) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
				}
			}
		}
	}

	/*
	==============================
	Execute Every Day at 00:00 AM
	==============================
	*/
	public function reward()
	{
		$key  = "";
		$pass = "";

		$arr = $this->M_member->get_data_member_reward();

		if ($arr->num_rows() > 0) :

			foreach ($arr->result() as $key_arr) :
				$id_member = $key_arr->id; // id_member yang bakal dapat reward
				$lft       = $key_arr->lft;
				$rgt       = $key_arr->rgt;
				$depth     = $key_arr->depth;

				// REWARD CHECK
				$this->_check_reward($id_member, $lft, $rgt, $depth, LIMIT_REWARD_1);
				$this->_check_reward($id_member, $lft, $rgt, $depth, LIMIT_REWARD_2);
				$this->_check_reward($id_member, $lft, $rgt, $depth, LIMIT_REWARD_3);
				$this->_check_reward($id_member, $lft, $rgt, $depth, LIMIT_REWARD_4);
				$this->_check_reward($id_member, $lft, $rgt, $depth, LIMIT_REWARD_5);

			endforeach;

		endif;
	}

	protected function _check_reward($id_member, $lft, $rgt, $depth, $limit)
	{
		// cari downline g1 yang total omset lebih dari LIMIT_REWARD_X
		$arr_d_reward_1 = $this->M_member->get_data_member_reward(null, $lft, $rgt, $depth + 1, $limit, 1);
		// example jika 1 downline g1 nya ada yang rewardnya minimal Xk
		if ($arr_d_reward_1->num_rows() > 0) {
			$sum_main_line_1 = $arr_d_reward_1->row()->total_omset;

			$id_exclude = $arr_d_reward_1->row()->id;
			$arr_d_reward_1_other = $this->M_member->get_data_member_reward(null, $lft, $rgt, $depth + 1, $limit, null, $id_exclude);

			if ($arr_d_reward_1_other->num_rows() > 0) {
				$sum_other_line_1 = 0;
				foreach ($arr_d_reward_1_other->result() as $key_do) {
					$total_omset_other = $key_do->total_omset;
					$sum_other_line_1 += $total_omset_other;
				}

				if ($sum_main_line_1 >= $limit && $sum_other_line_1 >= $limit) {
					$data = [
						'reward_1' => 'yes',
						'reward_1_date' => $this->datetime,
					];
					$this->M_core->update('member_reward', $data, ['id_member' => $id_member]);
				}
			}
		}
	}

	/*
	==================================
	Execute Every Day at Every 1 Hour
	==================================
	*/
	public function withdraw()
	{
		$state = "'pending'";
		$arr = $this->M_withdraw->get_list(null, null, $state);
		echo '<pre>' . print_r($arr->result(), 1) . '</pre>';

		if ($arr->num_rows() > 0) {
			$this->db->trans_begin();
			foreach ($arr->result() as $key) {
				$id_member    = $key->id_member;
				$email_member = $this->M_core->get('member', 'email', ['id' => $id_member])->row()->email;
				$invoice      = $key->invoice;
				$amount_1     = $key->amount_1 . " " . $key->currency_1;
				$amount_2     = $key->amount_2 . " " . $key->currency_1;
				$tx_id        = $key->tx_id;

				$req = ['id' => $tx_id];
				$arr_check = $this->_coinpayments_api_call('get_withdrawal_info', $req);
				echo '<pre>' . print_r($arr_check, 1) . '</pre>';
				exit;

				if ($arr_check['error'] == "ok") {
					if ($arr_check['result']['status'] == 2) {
						echo '<pre>' . print_r($arr_check, 1) . '</pre>';
						$data = [
							'state'      => 'success',
							'updated_at' => $this->datetime,
						];
						$where = ['tx_id' => $tx_id];
						$exec = $this->M_core->update('member_withdraw', $data, $where);

						if (!$exec) {
							$this->db->trans_rollback();
						}

						// SEND EMAIL
						$this->_send_withdraw_success($id_member, $email_member, $invoice, $amount_1, $amount_2, $tx_id);
						$this->db->trans_commit();
					}
				}
			}
		}
	}

	protected function _send_withdraw_success($id, $to, $invoice, $amount_1, $amount_2, $tx_id): bool
	{
		$subject = APP_NAME . " | Withdraw Success";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data['invoice']  = $invoice;
		$data['amount_1'] = $amount_1;
		$data['amount_2'] = $amount_2;
		$data['tx_id']    = $tx_id;
		return $this->load->view('emails/withdraw_success_template', $data, FALSE);
		// $message         = $this->load->view('emails/withdraw_success_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	/*
	==================================
	Execute Every Day at Every 6 Hour
	==================================
	*/
	public function check_trade_manager_expired()
	{
		$this->db->trans_begin();
		$arr = $this->M_trade_manager->get_expired_trade_manager();

		if ($arr->num_rows() > 0) {
			$data = [];
			foreach ($arr->result() as $key) {
				$invoice     = $key->invoice;
				$id_member   = $key->id_member;
				$buyer_email = $key->buyer_email;
				$item_name   = $key->item_name;
				$amount_usd  = $key->amount_usd;
				$state       = 'expired';

				$this->M_trade_manager->update_member_profit($id_member, $amount_usd);

				$data_log = [
					'id_member'         => $id_member,
					'invoice'           => $invoice,
					'amount_invest'     => 0,
					'amount_transfer'   => $amount_usd,
					'currency_transfer' => 'USDT',
					'txn_id'            => null,
					'state'             => 'expired',
					'description'       => "[$this->datetime] Member $buyer_email Package $item_name Expired at $this->date. Investment $amount_usd USDT already move to profit",
					'created_at'        => $this->datetime,
					'updated_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_member_trade_manager', $data_log);

				$nested = compact([
					'invoice',
					'state',
				]);

				array_push($data, $nested);
			}

			$exec = $this->M_trade_manager->update_state($data);

			if (!$exec) {
				$this->db->trans_rollback();
				exit;
			}

			$this->db->trans_commit();
		}
	}


	/*
	============================
	MASTER COINPAYMENT API CALL
	============================
	*/
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
        
/* End of file  TaskSchedulerController.php */
