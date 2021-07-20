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
		$this->load->model('M_crypto_asset');
		$this->load->model('M_member');
		$this->load->model('M_withdraw');
		$this->load->model('M_log_send_email_member');

		$this->Nested_set->setControlParams('tree', 'lft', 'rgt', 'id_member', 'id_upline', 'email');

		$this->date           = date('Y-m-d');
		$this->datetime       = date('Y-m-d H:i:s');
		$this->api_link       = CP_API_LINK;
		$this->public_key     = CP_PUB_KEY;
		$this->private_key    = CP_PRV_KEY;
		$this->merchant_id    = CP_MERCH_ID;
		$this->ipn_secret_key = CP_IPN_SEC_KEY;
		$this->from           = EMAIL_ADMIN;
		$this->from_alias     = 'Admin Test';
		$this->ip_address     = $this->input->ip_address();
		$this->user_agent     = $this->input->user_agent();
	}


	/*
	==============================
	Execute Every Day at 01:05 AM
	==============================
	*/
	public function profit_daily_trade_manager()
	{
		if (!$this->input->is_cli_request()) {
			echo "profit_daily_trade_manager can only be accessed from the command line";
			exit;
		}

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
			$invoice                = $key->invoice;
			$id_member              = $key->id_member;
			$id_package             = $key->id_package;
			$amount_usd             = $key->amount_usd;
			$profit_self_per_day    = $key->profit_self_per_day;
			$profit_upline_per_day  = $key->profit_upline_per_day;
			$profit_company_per_day = $key->profit_company_per_day;
			$currency1              = $key->currency1;
			$buyer_email            = $key->buyer_email;
			$buyer_name             = $key->buyer_name;
			$item_name              = $key->item_name;
			$expired_at             = $key->expired_at;

			$current_datetime_obj = new DateTime($this->datetime);
			$expired_datetime_obj = new DateTime($expired_at);
			$diff                 = $current_datetime_obj->diff($expired_datetime_obj);

			$id_upline = $this->M_core->get('member', 'id_upline', ['id' => $id_member])->row()->id_upline;

			$email_upline    = null;
			$fullname_upline = null;
			if ($id_upline != null) {
				$where_upline = [
					'id'         => $id_upline,
					'is_active'  => 'yes',
					'deleted_at' => null,
				];
				$arr_upline = $this->M_core->get('member', 'email, fullname', $where_upline);

				if ($arr_upline->num_rows() == 1) {
					$email_upline    = $arr_upline->row()->email;
					$fullname_upline = $arr_upline->row()->fullname;
				}
			}

			$profit_self_per_day_formated = number_format($profit_self_per_day, 8);
			$share_upline_value_formated  = number_format($profit_upline_per_day, 8);
			$share_company_value_formated = number_format($profit_company_per_day, 8);

			$description1  = "$buyer_name ($buyer_email) get daily profit from trade manager package $item_name for $profit_self_per_day_formated $currency1";
			$description2a = "$fullname_upline ($email_upline) get daily profit from downline $buyer_name ($buyer_email) trade manager package $item_name for $share_upline_value_formated $currency1";
			$description2b = "Unknown Balance get daily profit from downline $buyer_name ($buyer_email) trade manager package $item_name for $share_upline_value_formated $currency1";
			$description3  = "Unknown Balance get daily profit from downline $buyer_name ($buyer_email) trade manager package $item_name for $share_company_value_formated $currency1";

			if ($diff->format('%R') == "+") {
				// MEMBER GET PROFIT START
				/* UPDATE MEMBER BALANCE START */
				$exec1 = $this->M_trade_manager->update_member_profit($id_member, $profit_self_per_day);
				/* UPDATE MEMBER BALANCE END */

				/* LOG START */
				$data1 = [
					'id_member'    => $id_member,
					'invoice'      => $invoice,
					'id_package'   => $id_package,
					'package_name' => $item_name,
					'profit'       => $profit_self_per_day,
					'state'        => 'get',
					'description'  => $description1,
					'created_at'   => $this->datetime,
				];
				$this->M_core->store_uuid('log_profit_trade_manager', $data1);
				/* LOG END */

				/* EMAIL SEND START */
				$this->_send_daily_profit($buyer_email, $item_name, $profit_self_per_day);
				/* EMAIL SEND END */
				// MEMBER GET PROFIT END

				// UPLINE GET PROFIT START
				if ($id_upline != null) {
					$exec2 = $this->M_trade_manager->update_member_profit($id_upline, $profit_upline_per_day);

					/* LOG START */
					$data1 = [
						'id_member'    => $id_upline,
						'invoice'      => $invoice,
						'id_package'   => $id_package,
						'package_name' => $item_name,
						'profit'       => $profit_upline_per_day,
						'state'        => 'get',
						'description'  => $description2a,
						'created_at'   => $this->datetime,
					];
					$this->M_core->store_uuid('log_profit_trade_manager', $data1);
					/* LOG END */

					/* EMAIL SEND START */
					$this->_send_daily_profit($email_upline, $item_name, $profit_upline_per_day);
					/* EMAIL SEND END */
				} else {
					$exec2 = $this->M_trade_manager->update_unknown_profit($profit_upline_per_day);

					/* LOG start */
					$data1 = [
						'id_member'    => null,
						'invoice'      => $invoice,
						'id_package'   => $id_package,
						'package_name' => $item_name,
						'profit'       => $profit_upline_per_day,
						'state'        => 'get bonus',
						'description'  => $description2b,
						'created_at'   => $this->datetime,
					];
					$this->M_core->store_uuid('log_profit_trade_manager', $data1);
					/* LOG end */
				}
				// UPLINE GET PROFIT END

				// COMPANY GET PROFIT START
				$exec3 = $this->M_trade_manager->update_unknown_profit($profit_company_per_day);

				/* LOG start */
				$data1 = [
					'id_member'    => null,
					'invoice'      => $invoice,
					'id_package'   => $id_package,
					'package_name' => $item_name,
					'profit'       => $profit_company_per_day,
					'state'        => 'get',
					'description'  => $description3,
					'created_at'   => $this->datetime,
				];
				$this->M_core->store_uuid('log_profit_trade_manager', $data1);
				/* LOG end */
				// COMPANY GET PROFIT END

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
		if (!$this->input->is_cli_request()) {
			echo "greet my only be accessed from the command line";
			exit;
		}

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
	=======================================
	Execute Every Day at Every 5 Minutes
	=======================================
	*/
	public function withdraw()
	{
		if (!$this->input->is_cli_request()) {
			echo "greet my only be accessed from the command line";
			exit;
		}
		$state = "'pending'";
		$arr = $this->M_withdraw->get_list(null, null, $state);

		if ($arr->num_rows() > 0) {
			$this->db->trans_begin();
			foreach ($arr->result() as $key) {
				$id_member    = $key->id_member;
				$email_member = $this->M_core->get('member', 'email', ['id' => $id_member])->row()->email;
				$invoice      = $key->invoice;
				$amount_1     = $key->amount_1 . " " . $key->currency_1;
				$amount_2     = $key->amount_2 . " " . $key->currency_2;
				$tx_id        = $key->tx_id;
				$source       = $key->source;
				$currency_2   = $key->currency_2;
				$id_wallet    = $key->id_wallet;

				$arr_wallet     = $this->M_core->get('member_wallet', '*', ['id' => $id_wallet]);
				$wallet_label   = $arr_wallet->row()->wallet_label;
				$wallet_address = $arr_wallet->row()->wallet_address;

				$req = ['id' => $tx_id];
				$arr_check = $this->_coinpayments_api_call('get_withdrawal_info', $req);

				if ($arr_check['error'] == "ok") {
					if ($arr_check['result']['status'] == 2) {
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
						$exec = $this->_send_withdraw_success($id_member, $email_member, $invoice, $amount_1, $amount_2, $tx_id, $source, $wallet_label, $wallet_address);
						$this->db->trans_commit();
					}
				}
			}
		}
	}

	protected function _send_withdraw_success($id, $to, $invoice, $amount_1, $amount_2, $tx_id, $source, $wallet_label, $wallet_address): bool
	{
		$subject = APP_NAME . " | Withdraw Success";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data['invoice']        = $invoice;
		$data['amount_1']       = $amount_1;
		$data['amount_2']       = $amount_2;
		$data['tx_id']          = $tx_id;
		$data['source']         = $source;
		$data['wallet_label']   = $wallet_label;
		$data['wallet_address'] = $wallet_address;

		$message = $this->load->view('emails/withdraw_success_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	/*
	====================================
	Execute Every Day at Every 00:05 AM
	====================================
	*/
	public function check_trade_manager_expired()
	{
		if (!$this->input->is_cli_request()) {
			echo "greet my only be accessed from the command line";
			exit;
		}
		$this->db->trans_begin();
		$arr = $this->M_trade_manager->get_expired_trade_manager();

		if ($arr->num_rows() > 0) {
			$data = [];
			foreach ($arr->result() as $key) {
				$invoice     = $key->invoice;
				$id_member   = $key->id_member;
				$id_package  = $key->id_package;
				$buyer_email = $key->buyer_email;
				$buyer_name  = $key->buyer_name;
				$item_name   = $key->item_name;
				$amount_usd  = $key->amount_usd;
				$expired_at  = $key->expired_at;
				$is_extend   = $key->is_extend;
				$state       = 'expired';

				if ($is_extend == "manual") {
					// REDUCE MEMBER TRADE MANAGER BALANCE START
					$this->M_trade_manager->balance_expired($id_member, $amount_usd);
					// REDUCE MEMBER TRADE MANAGER BALANCE END

					// LOG START
					$description = "[$this->datetime] Member $buyer_email ($buyer_name) Package $item_name has been Expired at $expired_at. Investment $amount_usd USDT already move to profit";
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => 0,
						'amount_transfer'   => $amount_usd,
						'currency_transfer' => 'USDT',
						'txn_id'            => null,
						'state'             => $state,
						'description'       => $description,
						'created_at'        => $this->datetime,
						'updated_at'        => $this->datetime,
					];
					$this->M_core->store_uuid('log_member_trade_manager', $data_log);
					// LOG END

					// EMAIL EXPIRED START
					$this->_send_package_expired($buyer_email, $invoice, $item_name, $expired_at);
					// EMAIL EXPIRED END

					$nested = compact([
						'invoice',
						'state',
					]);
					array_push($data, $nested);
				} elseif ($is_extend == "auto") {
					$now_obj = new DateTime('now');
					$now_obj->modify('+365 day');

					$new_expired = $now_obj->format('Y-m-d');
					$obj         = ['expired_at' => $new_expired];
					$where       = [
						'invoice'   => $invoice,
						'id_member' => $id_member,
					];
					$this->M_core->update('member_trade_manager', $obj, $where);

					// EMAIL PERPANJANGAN START
					$this->_send_package_extend($buyer_email, $invoice, $item_name, $new_expired);
					// EMAIL PERPANJANGAN END
				}
			}

			$exec = $this->M_trade_manager->update_state($data);

			if (!$exec) {
				$this->db->trans_rollback();
				exit;
			}

			$this->db->trans_commit();
		} else {
			echo "Tidak ada yang Expired Hari Ini";
		}
	}

	/*
	======================================
	Execute Every Day Every Minutes
	METHOD [GET]
	======================================
	*/
	public function coinpayment_tx_info_tm()
	{
		if (!$this->input->is_cli_request()) {
			echo "greet my only be accessed from the command line";
			exit;
		}
		header('Content-Type: application/json');

		$this->db->trans_begin();

		$code                = 200;
		$member_is_qualified = 'no';
		$member_is_royalty   = 'no';

		$arr_list   = $this->M_trade_manager->get_tm_unpaid();

		if ($arr_list->num_rows() == 0) {
			echo json_encode([
				'code'    => 404,
				'message' => "No Unpaid Trade Manager"
			]);
			exit;
		}

		foreach ($arr_list->result() as $key) :

			$invoice                 = $key->invoice;
			$id_member               = $key->id_member;
			$id_package              = $key->id_package;
			$amount_usd              = $key->amount_usd;
			$profit_self_per_day     = $key->profit_self_per_day;
			$profit_upline_per_day   = $key->profit_upline_per_day;
			$profit_company_per_day  = $key->profit_company_per_day;
			$currency1               = $key->currency1;
			$currency2               = $key->currency2;
			$buyer_email             = $key->buyer_email;
			$buyer_name              = $key->buyer_name;
			$item_name               = $key->item_name;
			$state                   = $key->state;
			$txn_id                  = $key->txn_id;
			$amount_coin             = $key->amount_coin;
			$receiver_wallet_address = $key->receiver_wallet_address;
			$is_qualified            = $key->is_qualified;
			$is_royalty              = $key->is_royalty;

			$req['txid'] = $txn_id;
			$req['full'] = 1; // if set 1 will display checkout information
			$exec        = $this->_coinpayments_api_call('get_tx_info', $req);
			if ($exec['error'] != "ok") {
				$this->db->trans_rollback();
				$return = [
					'code'        => 500,
					'message' => $exec['result']['status_text'],
				];
				echo json_encode($return);
				exit;
			}

			$status      = $exec['result']['status'];
			$status_text = $exec['result']['status_text'];

			//adam debug only
			// $status = 100;

			if ($status == -1) {
				// Cancelled / Timed Out

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'      => 'cancel',
					'updated_at' => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_trade_manager', $data, $where);

				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Failed Update State Trade Manager',
					]);
					exit;
				}
				// UPDATE MEMBER TRADE MANAGER END

				// STORE LOG MEMBER TRADE MANAGER START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'cancel',
				];
				$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $buyer_email Package $item_name Canceled, Payment Timeout";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_usd,
						'amount_transfer'   => $amount_coin,
						'currency_transfer' => $currency2,
						'txn_id'            => $txn_id,
						'state'             => 'cancel',
						'description'       => $description,
						'created_at'        => $this->datetime,
						'updated_at'        => $this->datetime,
					];
					$exec = $this->M_core->store_uuid('log_member_trade_manager', $data_log);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Store Log Membe Trade Manager',
						]);
						exit;
					}

					// SEND EMAIL PACKAGE ACTIVE START
					$this->_send_package_cancel($id_member, $buyer_email, $invoice, $item_name);
					// SEND EMAIL PACKAGE ACTIVE END
				} else {
					$data_log = [
						'description' => $description,
						'updated_at'  => $this->datetime,
					];
					$exec = $this->M_core->update('log_member_trade_manager', $data_log, $where_count);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Update Log Membe Trade Manager',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER TRADE MANAGER END
			} elseif ($status == 0) {
				// Waiting for buyer funds

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'      => 'waiting payment',
					'updated_at' => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_trade_manager', $data, $where);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Failed Update State Trade Manager',
					]);
					exit;
				}
				// UPDATE MEMBER TRADE MANAGER END

				// STORE LOG MEMBER TRADE MANAGER START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'waiting payment',
				];
				$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $buyer_email Package $item_name Waiting Payment";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_usd,
						'amount_transfer'   => $amount_coin,
						'currency_transfer' => $currency2,
						'txn_id'            => $txn_id,
						'state'             => 'waiting payment',
						'description'       => $description,
						'created_at'        => $this->datetime,
						'updated_at'        => $this->datetime,
					];
					$exec = $this->M_core->store_uuid('log_member_trade_manager', $data_log);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Store Log Membe Trade Manager',
						]);
						exit;
					}

					// SEND EMAIL PACKAGE ACTIVE START
					$this->_send_package_waiting_payment($id_member, $buyer_email, $invoice, $item_name);
					// SEND EMAIL PACKAGE ACTIVE END
				} else {
					$data_log = [
						'description' => $description,
						'updated_at'  => $this->datetime,
					];
					$exec = $this->M_core->update('log_member_trade_manager', $data_log, $where_count);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Update Log Membe Trade Manager',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER TRADE MANAGER END
			} elseif ($status == 1) {
				//  We have confirmed coin reception from the buyer

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'      => 'pending',
					'updated_at' => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_trade_manager', $data, $where);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Failed Update State Trade Manager',
					]);
					exit;
				}
				// UPDATE MEMBER TRADE MANAGER END

				// STORE LOG MEMBER TRADE MANAGER START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'pending',
				];
				$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $buyer_email Package $item_name Pending";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_usd,
						'amount_transfer'   => $amount_coin,
						'currency_transfer' => $currency2,
						'txn_id'            => $txn_id,
						'state'             => 'pending',
						'description'       => $description,
						'created_at'        => $this->datetime,
						'updated_at'        => $this->datetime,
					];
					$exec = $this->M_core->store_uuid('log_member_trade_manager', $data_log);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Store Log Membe Trade Manager',
						]);
						exit;
					}
				} else {
					$data_log = [
						'description' => $description,
						'updated_at'  => $this->datetime,
					];
					$exec = $this->M_core->update('log_member_trade_manager', $data_log, $where_count);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Update Log Membe Trade Manager',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER TRADE MANAGER END

			} elseif ($status == 100 || $status == 2) {
				//  Payment Complete. We have sent your coins to your payment address or 3rd party payment system reports the payment complete
				if (in_array($state, ['waiting payment', 'pending'])) {

					// PERSIAPAN SEBELUM BAGI-BAGI BONUS START
					$arr_member = $this->M_core->get('member', 'id_upline', ['id' => $id_member]);
					$id_upline  = $arr_member->row()->id_upline;

					$arr_upline = $this->M_core->get('member', 'email, fullname, deleted_at', ['id' => $id_upline]);
					// PERSIAPAN SEBELUM BAGI-BAGI BONUS END

					$member_is_qualified = 'no';
					$member_is_royalty   = 'no';
					if ($arr_upline->num_rows() != 0) {
						$email_upline      = $arr_upline->row()->email;
						$fullname_upline   = $arr_upline->row()->fullname;
						$deleted_at_upline = $arr_upline->row()->deleted_at;

						// PART BONUS SPONSOR START
						$amount_bonus_upline = ($amount_usd * 10) / 100;

						$this->_distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $buyer_name, $buyer_email, $id_member, $invoice, $id_package, $item_name, $amount_usd);
						// PART BONUS SPONSOR END

						// PART QUALIFIKASI LEVEL START
						if ($is_qualified == "no") {
							$member_is_qualified = $this->_update_qualified($id_member, $id_upline, $amount_usd, $invoice, $id_package, $item_name);
						}
						// PART QUALIFIKASI LEVEL END

						// PART ROYALTY START
						if ($is_royalty == "no") {
							$member_is_royalty = $this->_update_royalty($id_member, $amount_usd, $invoice, $id_package, $item_name);

							if ($member_is_royalty == "yes") {
								$data_update_member_trade_manager  = ['is_royalty' => 'yes', 'updated_at' => $this->datetime];
								$where_update_member_trade_manager = ['invoice'    => $invoice];
								$exec = $this->M_core->update('member_trade_manager', $data_update_member_trade_manager, $where_update_member_trade_manager);
								if (!$exec) {
									$this->db->trans_rollback();

									echo json_encode([
										'code'    => 500,
										'message' => 'Failed Update Royalty State Trade Manager',
									]);
									exit;
								}
							}
						}
						// PART ROYALTY END
					}

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

					// UPDATE MEMBER TRADE MANAGER START
					$data = [
						'state'        => 'active',
						'is_qualified' => $member_is_qualified,
						'is_royalty'   => $member_is_royalty,
						'updated_at'   => $this->datetime,
					];
					$where = ['txn_id' => $txn_id];
					$this->M_core->update('member_trade_manager', $data, $where);
					// UPDATE MEMBER TRADE MANAGER END

					// UPDATE MEMBER BALANCE START
					$this->M_trade_manager->update_member_trade_manager_asset($id_member, $amount_usd);
					// UPDATE MEMBER BALANCE END

					// STORE LOG MEMBER TRADE MANAGER START
					$where_count = [
						'id_member' => $id_member,
						'invoice'   => $invoice,
						'state'     => 'active',
					];
					$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

					$description = "[$this->datetime] Member $buyer_email Package $item_name Active";
					if ($arr_count->num_rows() == 0) {
						$data_log = [
							'id_member'         => $id_member,
							'invoice'           => $invoice,
							'amount_invest'     => $amount_usd,
							'amount_transfer'   => $amount_coin,
							'currency_transfer' => $currency2,
							'txn_id'            => $txn_id,
							'state'             => 'active',
							'description'       => $description,
							'created_at'        => $this->datetime,
							'updated_at'        => $this->datetime,
						];
						$this->M_core->store_uuid('log_member_trade_manager', $data_log);

						// SEND EMAIL PACKAGE ACTIVE START
						$this->_send_package_active($id_member, $buyer_email, $invoice, $item_name);
						// SEND EMAIL PACKAGE ACTIVE END
					} else {
						$data_log = [
							'description' => $description,
							'updated_at'  => $this->datetime,
						];
						$this->M_core->update('log_member_trade_manager', $data_log, $where_count);
					}
					// STORE LOG MEMBER TRADE MANAGER END
				}
			}
		endforeach;

		$this->db->trans_commit();
		$this->coinpayment_tx_info_ca();
	}

	protected function coinpayment_tx_info_ca()
	{
		$this->db->trans_begin();

		$code                = 200;
		$member_is_qualified = 'no';
		$member_is_royalty   = 'no';

		$arr_list   = $this->M_crypto_asset->get_ca_unpaid();

		if ($arr_list->num_rows() == 0) {
			echo json_encode([
				'code'    => 404,
				'message' => "No Unpaid Crypto Asset"
			]);
			exit;
		}

		foreach ($arr_list->result() as $key) :

			$invoice                 = $key->invoice;
			$id_member               = $key->id_member;
			$id_package              = $key->id_package;
			$amount_usd              = $key->amount_usd;
			$profit_self_per_day     = $key->profit_self_per_day;
			$profit_upline_per_day   = $key->profit_upline_per_day;
			$profit_company_per_day  = $key->profit_company_per_day;
			$currency1               = $key->currency1;
			$currency2               = $key->currency2;
			$buyer_email             = $key->buyer_email;
			$buyer_name              = $key->buyer_name;
			$item_name               = $key->item_name;
			$state                   = $key->state;
			$txn_id                  = $key->txn_id;
			$amount_coin             = $key->amount_coin;
			$receiver_wallet_address = $key->receiver_wallet_address;
			$is_qualified            = $key->is_qualified;
			$is_royalty              = $key->is_royalty;

			$req['txid'] = $txn_id;
			$req['full'] = 1; // if set 1 will display checkout information
			$exec        = $this->_coinpayments_api_call('get_tx_info', $req);
			if ($exec['error'] != "ok") {
				$this->db->trans_rollback();
				$return = [
					'code'        => 500,
					'message' => $exec['result']['status_text'],
				];
				echo json_encode($return);
				exit;
			}

			$status      = $exec['result']['status'];
			$status_text = $exec['result']['status_text'];

			//adam debug only
			// $status = 100;

			if ($status == -1) {
				// Cancelled / Timed Out

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'      => 'cancel',
					'updated_at' => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_crypto_asset', $data, $where);

				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Failed Update State Crypto Asset',
					]);
					exit;
				}
				// UPDATE MEMBER TRADE MANAGER END

				// STORE LOG MEMBER TRADE MANAGER START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'cancel',
				];
				$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $buyer_email Package $item_name Canceled, Payment Timeout";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_usd,
						'amount_transfer'   => $amount_coin,
						'currency_transfer' => $currency2,
						'txn_id'            => $txn_id,
						'state'             => 'cancel',
						'description'       => $description,
						'created_at'        => $this->datetime,
						'updated_at'        => $this->datetime,
					];
					$exec = $this->M_core->store_uuid('log_member_crypto_asset', $data_log);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Store Log Member Trade Manager',
						]);
						exit;
					}

					// SEND EMAIL PACKAGE ACTIVE START
					$this->_send_package_cancel($id_member, $buyer_email, $invoice, $item_name);
					// SEND EMAIL PACKAGE ACTIVE END
				} else {
					$data_log = [
						'description' => $description,
						'updated_at'  => $this->datetime,
					];
					$exec = $this->M_core->update('log_member_crypto_asset', $data_log, $where_count);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Update Log Member Crypto Asset',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER TRADE MANAGER END
			} elseif ($status == 0) {
				// Waiting for buyer funds

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'      => 'waiting payment',
					'updated_at' => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_crypto_asset', $data, $where);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Failed Update State Crypto Asset',
					]);
					exit;
				}
				// UPDATE MEMBER TRADE MANAGER END

				// STORE LOG MEMBER TRADE MANAGER START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'waiting payment',
				];
				$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $buyer_email Package $item_name Waiting Payment";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_usd,
						'amount_transfer'   => $amount_coin,
						'currency_transfer' => $currency2,
						'txn_id'            => $txn_id,
						'state'             => 'waiting payment',
						'description'       => $description,
						'created_at'        => $this->datetime,
						'updated_at'        => $this->datetime,
					];
					$exec = $this->M_core->store_uuid('log_member_crypto_asset', $data_log);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Store Log Member Crypto Asset',
						]);
						exit;
					}

					// SEND EMAIL PACKAGE ACTIVE START
					$this->_send_package_waiting_payment($id_member, $buyer_email, $invoice, $item_name);
					// SEND EMAIL PACKAGE ACTIVE END
				} else {
					$data_log = [
						'description' => $description,
						'updated_at'  => $this->datetime,
					];
					$exec = $this->M_core->update('log_member_crypto_asset', $data_log, $where_count);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Update Log Member Crypto Asset',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER TRADE MANAGER END
			} elseif ($status == 1) {
				//  We have confirmed coin reception from the buyer

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'      => 'pending',
					'updated_at' => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_crypto_asset', $data, $where);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Failed Update State Crypto Asset',
					]);
					exit;
				}
				// UPDATE MEMBER TRADE MANAGER END

				// STORE LOG MEMBER TRADE MANAGER START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'pending',
				];
				$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $buyer_email Package $item_name Pending";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_usd,
						'amount_transfer'   => $amount_coin,
						'currency_transfer' => $currency2,
						'txn_id'            => $txn_id,
						'state'             => 'pending',
						'description'       => $description,
						'created_at'        => $this->datetime,
						'updated_at'        => $this->datetime,
					];
					$exec = $this->M_core->store_uuid('log_member_crypto_asset', $data_log);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Store Log Member Crypto Asset',
						]);
						exit;
					}
				} else {
					$data_log = [
						'description' => $description,
						'updated_at'  => $this->datetime,
					];
					$exec = $this->M_core->update('log_member_crypto_asset', $data_log, $where_count);
					if (!$exec) {
						$this->db->trans_rollback();

						echo json_encode([
							'code'    => 500,
							'message' => 'Failed Update Log Member Crypto Asset',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER TRADE MANAGER END

			} elseif ($status == 100 || $status == 2) {
				//  Payment Complete. We have sent your coins to your payment address or 3rd party payment system reports the payment complete
				if (in_array($state, ['waiting payment', 'pending'])) {

					// PERSIAPAN SEBELUM BAGI-BAGI BONUS START
					$arr_member = $this->M_core->get('member', 'id_upline', ['id' => $id_member]);
					$id_upline  = $arr_member->row()->id_upline;

					$arr_upline = $this->M_core->get('member', 'email, fullname, deleted_at', ['id' => $id_upline]);
					// PERSIAPAN SEBELUM BAGI-BAGI BONUS END

					$member_is_qualified = 'no';
					$member_is_royalty   = 'no';
					if ($arr_upline->num_rows() != 0) {
						$email_upline      = $arr_upline->row()->email;
						$fullname_upline   = $arr_upline->row()->fullname;
						$deleted_at_upline = $arr_upline->row()->deleted_at;

						// PART BONUS SPONSOR START
						$amount_bonus_upline = ($amount_usd * 10) / 100;

						$this->_distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $buyer_name, $buyer_email, $id_member, $invoice, $id_package, $item_name, $amount_usd);
						// PART BONUS SPONSOR END

						// PART QUALIFIKASI LEVEL START
						if ($is_qualified == "no") {
							$member_is_qualified = $this->_update_qualified($id_member, $id_upline, $amount_usd, $invoice, $id_package, $item_name);
						}
						// PART QUALIFIKASI LEVEL END

						// PART ROYALTY START
						if ($is_royalty == "no") {
							$member_is_royalty = $this->_update_royalty($id_member, $amount_usd, $invoice, $id_package, $item_name);

							if ($member_is_royalty == "yes") {
								$data_update_member_trade_manager  = ['is_royalty' => 'yes', 'updated_at' => $this->datetime];
								$where_update_member_trade_manager = ['invoice'    => $invoice];
								$exec = $this->M_core->update('member_crypto_asset', $data_update_member_trade_manager, $where_update_member_trade_manager);
								if (!$exec) {
									$this->db->trans_rollback();

									echo json_encode([
										'code'    => 500,
										'message' => 'Failed Update Royalty State Trade Manager',
									]);
									exit;
								}
							}
						}
						// PART ROYALTY END
					}

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

					// UPDATE MEMBER CRYPTO ASSET START
					$data = [
						'state'        => 'active',
						'is_qualified' => $member_is_qualified,
						'is_royalty'   => $member_is_royalty,
						'updated_at'   => $this->datetime,
					];
					$where = ['txn_id' => $txn_id];
					$this->M_core->update('member_crypto_asset', $data, $where);
					// UPDATE MEMBER CRYPTO ASSET END

					// UPDATE MEMBER BALANCE START
					$this->M_trade_manager->update_member_trade_manager_asset($id_member, $amount_usd);
					// UPDATE MEMBER BALANCE END

					// STORE LOG MEMBER CRYPTO ASSET START
					$where_count = [
						'id_member' => $id_member,
						'invoice'   => $invoice,
						'state'     => 'active',
					];
					$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

					$description = "[$this->datetime] Member $buyer_email Package $item_name Active";
					if ($arr_count->num_rows() == 0) {
						$data_log = [
							'id_member'         => $id_member,
							'invoice'           => $invoice,
							'amount_invest'     => $amount_usd,
							'amount_transfer'   => $amount_coin,
							'currency_transfer' => $currency2,
							'txn_id'            => $txn_id,
							'state'             => 'active',
							'description'       => $description,
							'created_at'        => $this->datetime,
							'updated_at'        => $this->datetime,
						];
						$this->M_core->store_uuid('log_member_crypto_asset', $data_log);

						// SEND EMAIL PACKAGE ACTIVE START
						$this->_send_package_active($id_member, $buyer_email, $invoice, $item_name);
						// SEND EMAIL PACKAGE ACTIVE END
					} else {
						$data_log = [
							'description' => $description,
							'updated_at'  => $this->datetime,
						];
						$this->M_core->update('log_member_crypto_asset', $data_log, $where_count);
					}
					// STORE LOG MEMBER CRYPTO ASSET END
				}
			}
		endforeach;

		$this->db->trans_commit();
	}

	protected function _distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $buyer_name, $db_buyer_email, $db_id_member, $invoice, $db_id_package, $item_name, $db_amount_usd)
	{
		if ($id_upline != null) {
			if ($deleted_at_upline == null) {
				$exec = $this->M_trade_manager->update_member_bonus($id_upline, $amount_bonus_upline);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Failed Update Member Bonus Sponsor',
					]);
					exit;
				}

				$id_upline_log = $id_upline;
				$desc_log      = "$fullname_upline ($email_upline) get bonus recruitment of member $buyer_name ($db_buyer_email) $amount_bonus_upline USDT";
			} else {
				$exec = $this->M_trade_manager->update_unknown_balance($amount_bonus_upline);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Failed Update Unknown Balance Bonus Sponsor',
					]);
					exit;
				}

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
			$exec = $this->M_core->store_uuid('log_bonus_recruitment', $data_log);
			if (!$exec) {
				$this->db->trans_rollback();

				echo json_encode([
					'code'    => 500,
					'message' => 'Failed Store Log Bonus Recruitment',
				]);
				exit;
			}
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

		// jika data dari trade manager tidak ada yang is_qualified == no
		if ($arr_ql_sibling_tm->num_rows() == 0) {

			// ambil data dari crypto asset
			$arr_ql_sibling_ca = $this->M_crypto_asset->get_ql_sibling($id_member, $id_upline);

			// jika ada ada dari crypto asset yang belum qualified
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
								$exec = $this->M_crypto_asset->update_member_bonus($id_grand_upline, $new_bonus_grand_upline);
								if (!$exec) {
									$this->db->trans_rollback();

									echo json_encode([
										'code'    => 500,
										'message' => 'Failed Update Member Bonus Qualification Leader Crypto Asset',
									]);
									exit;
								}

								$desc_log_member1 = "$fullname_grand_upline ($email_grand_upline) get Bonus Qualification Leader from $fullname_member ($email_member) $bonus_grand_upline USDT";

								$desc_log_member2 = "$fullname_grand_upline ($email_grand_upline) get Bonus Qualification Leader from $buyer_name_ql_sibling ($buyer_email_ql_sibling) $amount_usd_ql_sibling_as_bonus USDT";
							} else {
								$exec = $this->M_crypto_asset->update_unknown_balance($new_bonus_grand_upline);

								if (!$exec) {
									$this->db->trans_rollback();

									echo json_encode([
										'code'    => 500,
										'message' => 'Failed Update Unknown Balance Bonus Qualification Leader Crypto Asset',
									]);
									exit;
								}

								$desc_log_member1 = "Unknown Balance get Bonus Qualification Leader from $fullname_member ($email_member) $bonus_grand_upline USDT";

								$desc_log_member2 = "Unknown Balance get Bonus Qualification Leader from $buyer_name_ql_sibling ($buyer_email_ql_sibling) $amount_usd_ql_sibling_as_bonus USDT";
							}

							$data_update_member_trade_manager = [
								'is_qualified' => 'yes',
								'updated_at' => $this->datetime
							];
							$where_update_member_trade_manager = [
								'invoice' => $invoice_ql_sibling
							];
							$exec = $this->M_core->update('member_crypto_asset', $data_update_member_trade_manager, $where_update_member_trade_manager);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Failed Update Member Trade Manager Qualification Leader State',
								]);
								exit;
							}

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
							$exec = $this->M_core->store_uuid('log_bonus_qualification_level', $data_log1);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Failed Store Log Bonus Qualification Leader',
								]);
								exit;
							}

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
							$exec = $this->M_core->store_uuid('log_bonus_qualification_level', $data_log2);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Failed Store Log Bonus Qualification Leader Sibling',
								]);
								exit;
							}

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
							$exec = $this->M_trade_manager->update_member_bonus($id_grand_upline, $new_bonus_grand_upline);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Failed Update Member Bonus Qualification Leader Trade Manager',
								]);
								exit;
							}

							$desc_log_member1 = "$fullname_grand_upline ($email_grand_upline) get Bonus Qualification Leader from $fullname_member ($email_member) $bonus_grand_upline USDT";

							$desc_log_member2 = "$fullname_grand_upline ($email_grand_upline) get Bonus Qualification Leader from $buyer_name_ql_sibling ($buyer_email_ql_sibling) $amount_usd_ql_sibling_as_bonus USDT";
						} else {
							$exec = $this->M_trade_manager->update_unknown_balance($new_bonus_grand_upline);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Failed Update Unknown Balance Bonus Qualification Leader Trade Manager',
								]);
								exit;
							}

							$desc_log_member1 = "Unknown Balance et Bonus Qualification Leader from $fullname_member ($email_member) $bonus_grand_upline USDT";

							$desc_log_member2 = "Unknown Balance et Bonus Qualification Leader from $buyer_name_ql_sibling ($buyer_email_ql_sibling) $amount_usd_ql_sibling_as_bonus USDT";
						}

						$data_update_member_trade_manager  = [
							'is_qualified' => 'yes',
							'updated_at' => $this->datetime
						];
						$where_update_member_trade_manager = [
							'invoice' => $invoice_ql_sibling
						];
						$exec = $this->M_core->update('member_trade_manager', $data_update_member_trade_manager, $where_update_member_trade_manager);

						if (!$exec) {
							$this->db->trans_rollback();

							echo json_encode([
								'code'    => 500,
								'message' => 'Failed Update Member Trade Manager Qualification Leader State',
							]);
							exit;
						}

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
						$exec = $this->M_core->store_uuid('log_bonus_qualification_level', $data_log1);
						if (!$exec) {
							$this->db->trans_rollback();

							echo json_encode([
								'code'    => 500,
								'message' => 'Failed Store Log Bonus Qualification Leader',
							]);
							exit;
						}

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
						$exec = $this->M_core->store_uuid('log_bonus_qualification_level', $data_log2);
						if (!$exec) {
							$this->db->trans_rollback();

							echo json_encode([
								'code'    => 500,
								'message' => 'Failed Store Log Bonus Qualification Leader Sibling',
							]);
							exit;
						}

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
							$exec = $this->M_trade_manager->update_member_bonus($id_gen, $bonus_royalty);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Failed Update Member Bonus Royalty',
								]);
								exit;
							}

							$id_member_log = $id_gen;
							$desc_log      = "$fullname_gen ($email_gen) get Bonus Royalty of member $fullname_member ($email_member) $bonus_royalty USDT";
						} else {
							$exec = $this->M_trade_manager->update_unknown_bonus($bonus_royalty);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Failed Update Unknown Balance Bonus Royalty',
								]);
								exit;
							}

							$id_member_log = null;
							$desc_log      = "Unknown Balance get Bonus Royalty of member $fullname_member ($email_member) $bonus_royalty USDT";
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
						$exec = $this->M_core->store_uuid('log_bonus_royalty', $data_log);
						if (!$exec) {
							$this->db->trans_rollback();

							echo json_encode([
								'code'    => 500,
								'message' => 'Failed Store Log Bonus Royalty',
							]);
							exit;
						}
					}
				}
				$itteration_gen++;
			}

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

	protected function _send_daily_profit($to, $item_name, $amount): bool
	{
		$subject = APP_NAME . " | Package $item_name Distribution Daily Profit Success";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data = [
			'item_name' => $item_name,
			'amount'    => $amount,
			'datetime'  => $this->datetime,
		];
		$message = $this->load->view('emails/distribution_profit', $data, TRUE);
		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	protected function _send_package_expired($to, $invoice, $item_name, $date_expired): bool
	{
		$subject = APP_NAME . " | Invoice $invoice Package $item_name Expired";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data = [
			'invoice'      => $invoice,
			'item_name'    => $item_name,
			'date_expired' => $date_expired,
		];
		$message = $this->load->view('emails/package_expired', $data, TRUE);
		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	protected function _send_package_extend($to, $invoice, $item_name, $date_expired): bool
	{
		$subject = APP_NAME . " | Invoice $invoice Package $item_name Extend";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$data = [
			'invoice'      => $invoice,
			'item_name'    => $item_name,
			'date_expired' => $date_expired,
		];
		$message = $this->load->view('emails/package_extend', $data, TRUE);
		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
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
