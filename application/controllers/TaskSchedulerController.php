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
		$this->load->helper('Floating_helper');
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
		$this->from_alias     = EMAIL_ALIAS;
		$this->ip_address     = $this->input->ip_address();
		$this->user_agent     = $this->input->user_agent();
	}

	/*
	======================================
	Execute Every Day Every Minutes
	METHOD [GET]
	======================================
	*/
	public function coinpayment_tx_info_tm()
	{
		// if (!$this->input->is_cli_request()) {
		// 	echo "Hanya dapat diakses via CLI";
		// 	exit;
		// }
		// header('Content-Type: application/json');

		$this->db->trans_begin();

		$arr_list = $this->M_trade_manager->get_tm_unpaid();

		if ($arr_list->num_rows() == 0) {
			echo json_encode([
				'code'    => 404,
				'message' => "Tidak Ada Trade Manager yang belum dibayarkan"
			]);
		}

		foreach ($arr_list->result() as $key) :

			$invoice                   = $key->invoice;
			$id_member                 = $key->id_member;
			$member_fullname           = $key->member_fullname;
			$member_email              = $key->member_email;
			$id_package                = $key->id_package;
			$id_konfigurasi            = $key->id_konfigurasi;
			$package_name              = $key->package_name;
			$txn_id                    = $key->txn_id;
			$amount_1                  = $key->amount_1;
			$amount_2                  = $key->amount_2;
			$currency2                 = $key->currency2;
			$state                     = $key->state;

			$req['txid'] = $txn_id;
			$req['full'] = 1; // if set 1 will display checkout information
			$exec = $this->_coinpayments_api_call('get_tx_info', $req);
			if ($exec['error'] != "ok") {
				$this->db->trans_rollback();
				$return = [
					'code'    => 500,
					'message' => $exec['result']['status_text'],
				];
				echo json_encode($return);
				exit;
			}

			$status    = $exec['result']['status'];
			$receivedf = $exec['result']['receivedf'];

			$status = (ENVIRONMENT == "development") ? 100 : $status;

			if ($status == -1) {
				// Cancelled / Timed Out

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'          => 'cancel',
					'receive_amount' => $receivedf,
					'updated_at'     => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec  = $this->M_core->update('member_trade_manager', $data, $where);

				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Gagal update Status Trade Manager',
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

				$description = "[$this->datetime] Member $member_email Paket $package_name Dibatalkan, Pembayaran Melewati Batas Waktu";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_1,
						'amount_transfer'   => $amount_2,
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
							'message' => 'Gagal Menyimpan Log Member Trade Manager',
						]);
						exit;
					}

					// SEND EMAIL PACKAGE CANCEL START
					if (ENVIRONMENT == "production") {
						$this->_send_package_cancel($id_member, $member_email, $invoice, $package_name);
					}
					// SEND EMAIL PACKAGE CANCEL END
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
							'message' => 'Gagal Update Log Member Trade Manager',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER TRADE MANAGER END
			} elseif ($status == 0) {
				// Waiting for buyer funds

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'          => 'waiting payment',
					'receive_amount' => $receivedf,
					'updated_at'     => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_trade_manager', $data, $where);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Gagal Update Log Member Trade Manager',
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

				$description = "[$this->datetime] Member $member_email Paket $package_name Menunggu Pembayaran";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_1,
						'amount_transfer'   => $amount_2,
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
							'message' => 'Gagal Menyimpan Log Member Trade Manager',
						]);
						exit;
					}

					// SEND EMAIL PACKAGE WAITING PAYMENT START
					if (ENVIRONMENT == "production") {
						$this->_send_package_waiting_payment($id_member, $member_email, $invoice, $package_name);
					}
					// SEND EMAIL PACKAGE WAITING PAYMENT END
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
							'message' => 'Gagal Update Log Trade Manager',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER TRADE MANAGER END
			} elseif ($status == 1) {
				//  We have confirmed coin reception from the buyer

				// UPDATE MEMBER TRADE MANAGER START
				$data = [
					'state'          => 'pending',
					'receive_amount' => $receivedf,
					'updated_at'     => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_trade_manager', $data, $where);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Gagal Update Status Trade Manager',
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

				$description = "[$this->datetime] Member $member_email Paket $package_name Pembayaran Sedang di Proses";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_1,
						'amount_transfer'   => $amount_2,
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
							'message' => 'Gagal Menyimpan Log Trade Manager',
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
							'message' => 'Gagal Update Log Trade Manager',
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
						$amount_bonus_upline = ($amount_1 * BONUS_SPONSOR) / 100;
						$this->_distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $member_fullname, $member_email, $id_member, $invoice, $id_package, $package_name, $amount_1, $id_konfigurasi, 'trade manager');
						// PART BONUS SPONSOR END

						// PART QUALIFIKASI LEVEL START
						$member_is_qualified = $this->_update_qualified($id_member, $member_fullname, $member_email, $id_upline, $amount_1, $invoice, $id_package, $package_name, $id_konfigurasi, 'trade manager');
						// PART QUALIFIKASI LEVEL END

						// PART ROYALTY START
						$member_is_royalty = $this->_update_royalty($id_member, $member_fullname, $member_email, $amount_1, $invoice, $id_package, $id_konfigurasi, $package_name, 'trade manager');
						// PART ROYALTY END
					}

					// UPDATE TOTAL OMSET START
					$update_omset = $this->_update_omset($id_member, $amount_1);
					if ($update_omset === false) {
						$this->db->trans_rollback();
						$return = [
							'code'        => 500,
							'status_text' => "Gagal Update Total Omzet Upline",
						];
						echo json_encode($return);
						exit;
					}
					// UPDATE TOTAL OMSET END

					// UPDATE MEMBER TRADE MANAGER START
					$data = [
						'state'          => 'active',
						'receive_amount' => $receivedf,
						'is_qualified'   => $member_is_qualified,
						'is_royalty'     => $member_is_royalty,
						'updated_at'     => $this->datetime,
					];
					$where = ['txn_id' => $txn_id];
					$this->M_core->update('member_trade_manager', $data, $where);
					// UPDATE MEMBER TRADE MANAGER END

					// UPDATE MEMBER BALANCE START
					$this->M_trade_manager->update_member_trade_manager_asset($id_member, $amount_1);
					// UPDATE MEMBER BALANCE END

					// STORE LOG MEMBER TRADE MANAGER START
					$where_count = [
						'id_member' => $id_member,
						'invoice'   => $invoice,
						'state'     => 'active',
					];
					$arr_count = $this->M_core->get('log_member_trade_manager', 'id', $where_count, null, null, 1);

					$description = "[$this->datetime] Member $member_email Paket $package_name Aktif";
					if ($arr_count->num_rows() == 0) {
						$data_log = [
							'id_member'         => $id_member,
							'invoice'           => $invoice,
							'amount_invest'     => $amount_1,
							'amount_transfer'   => $amount_2,
							'currency_transfer' => $currency2,
							'txn_id'            => $txn_id,
							'state'             => 'active',
							'description'       => $description,
							'created_at'        => $this->datetime,
							'updated_at'        => $this->datetime,
						];
						$this->M_core->store_uuid('log_member_trade_manager', $data_log);

						// SEND EMAIL PACKAGE ACTIVE START
						if (ENVIRONMENT == "production") {
							$this->_send_package_active($id_member, $member_email, $invoice, $package_name, 'trade_manager');
						}
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

		$arr_list   = $this->M_crypto_asset->get_ca_unpaid();

		if ($arr_list->num_rows() == 0) {
			echo json_encode([
				'code'    => 404,
				'message' => "Tidak Ada Crypto Asset yang belum dibayarkan"
			]);
		}

		foreach ($arr_list->result() as $key) :

			$invoice         = $key->invoice;
			$id_member       = $key->id_member;
			$member_fullname = $key->member_fullname;
			$member_email    = $key->member_email;
			$id_package      = $key->id_package;
			$id_konfigurasi  = $key->id_konfigurasi;
			$package_name    = $key->package_name;
			$txn_id          = $key->txn_id;
			$amount_1        = $key->amount_1;
			$amount_2        = $key->amount_2;
			$currency2       = $key->currency2;
			$state           = $key->state;

			$req['txid'] = $txn_id;
			$req['full'] = 1; // if set 1 will display checkout information
			$exec = $this->_coinpayments_api_call('get_tx_info', $req);
			if ($exec['error'] != "ok") {
				$this->db->trans_rollback();
				$return = [
					'code'    => 500,
					'message' => $exec['result']['status_text'],
				];
				echo json_encode($return);
				exit;
			}

			$status    = $exec['result']['status'];
			$receivedf = $exec['result']['receivedf'];

			$status = (ENVIRONMENT == "development") ? 100 : $status;

			if ($status == -1) {
				// Cancelled / Timed Out

				// UPDATE MEMBER Crypto Asset START
				$data = [
					'state'          => 'cancel',
					'receive_amount' => $receivedf,
					'updated_at'     => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec  = $this->M_core->update('member_crypto_asset', $data, $where);

				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Gagal update Status Crypto Asset',
					]);
					exit;
				}
				// UPDATE MEMBER Crypto Asset END

				// STORE LOG MEMBER Crypto Asset START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'cancel',
				];
				$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $member_email Paket $package_name Dibatalkan, Pembayaran Melewati Batas Waktu";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_1,
						'amount_transfer'   => $amount_2,
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
							'message' => 'Gagal Menyimpan Log Member Crypto Asset',
						]);
						exit;
					}

					// SEND EMAIL PACKAGE CANCEL START
					if (ENVIRONMENT == "production") {
						$this->_send_package_cancel($id_member, $member_email, $invoice, $package_name);
					}
					// SEND EMAIL PACKAGE CANCEL END
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
							'message' => 'Gagal Update Log Member Crypto Asset',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER Crypto Asset END
			} elseif ($status == 0) {
				// Waiting for buyer funds

				// UPDATE MEMBER Crypto Asset START
				$data = [
					'state'          => 'waiting payment',
					'receive_amount' => $receivedf,
					'updated_at'     => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_crypto_asset', $data, $where);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Gagal Update Log Member Crypto Asset',
					]);
					exit;
				}
				// UPDATE MEMBER Crypto Asset END

				// STORE LOG MEMBER Crypto Asset START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'waiting payment',
				];
				$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $member_email Paket $package_name Menunggu Pembayaran";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_1,
						'amount_transfer'   => $amount_2,
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
							'message' => 'Gagal Menyimpan Log Member Crypto Asset',
						]);
						exit;
					}

					// SEND EMAIL PACKAGE WAITING PAYMENT START
					if (ENVIRONMENT == "production") {
						$this->_send_package_waiting_payment($id_member, $member_email, $invoice, $package_name);
					}
					// SEND EMAIL PACKAGE WAITING PAYMENT END
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
							'message' => 'Gagal Update Log Crypto Asset',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER Crypto Asset END
			} elseif ($status == 1) {
				//  We have confirmed coin reception from the buyer

				// UPDATE MEMBER Crypto Asset START
				$data = [
					'state'          => 'pending',
					'receive_amount' => $receivedf,
					'updated_at'     => $this->datetime,
				];
				$where = ['txn_id' => $txn_id];
				$exec = $this->M_core->update('member_crypto_asset', $data, $where);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Gagal Update Status Crypto Asset',
					]);
					exit;
				}
				// UPDATE MEMBER Crypto Asset END

				// STORE LOG MEMBER Crypto Asset START
				$where_count = [
					'id_member' => $id_member,
					'invoice'   => $invoice,
					'state'     => 'pending',
				];
				$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

				$description = "[$this->datetime] Member $member_email Paket $package_name Pembayaran Sedang di Proses";
				if ($arr_count->num_rows() == 0) {
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => $amount_1,
						'amount_transfer'   => $amount_2,
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
							'message' => 'Gagal Menyimpan Log Crypto Asset',
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
							'message' => 'Gagal Update Log Crypto Asset',
						]);
						exit;
					}
				}
				// STORE LOG MEMBER Crypto Asset END

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
						$amount_bonus_upline = ($amount_1 * BONUS_SPONSOR) / 100;
						$this->_distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $member_fullname, $member_email, $id_member, $invoice, $id_package, $package_name, $amount_1, $id_konfigurasi, 'crypto asset');
						// PART BONUS SPONSOR END

						// PART QUALIFIKASI LEVEL START
						$member_is_qualified = $this->_update_qualified($id_member, $member_fullname, $member_email, $id_upline, $amount_1, $invoice, $id_package, $package_name, $id_konfigurasi, 'crypto asset');
						// PART QUALIFIKASI LEVEL END

						// PART ROYALTY START
						$member_is_royalty = $this->_update_royalty($id_member, $member_fullname, $member_email, $amount_1, $invoice, $id_package, $id_konfigurasi, $package_name, 'crypto asset');
						// PART ROYALTY END
					}

					// UPDATE TOTAL OMSET START
					$update_omset = $this->_update_omset($id_member, $amount_1);
					if ($update_omset === false) {
						$this->db->trans_rollback();
						$return = [
							'code'        => 500,
							'status_text' => "Gagal Update Total Omzet Upline",
						];
						echo json_encode($return);
						exit;
					}
					// UPDATE TOTAL OMSET END

					// UPDATE MEMBER Crypto Asset START
					$data = [
						'state'          => 'active',
						'receive_amount' => $receivedf,
						'is_qualified'   => $member_is_qualified,
						'is_royalty'     => $member_is_royalty,
						'updated_at'     => $this->datetime,
					];
					$where = ['txn_id' => $txn_id];
					$this->M_core->update('member_crypto_asset', $data, $where);
					// UPDATE MEMBER Crypto Asset END

					// UPDATE MEMBER BALANCE START
					$this->M_crypto_asset->update_member_crypto_asset_asset($id_member, $amount_1);
					// UPDATE MEMBER BALANCE END

					// STORE LOG MEMBER Crypto Asset START
					$where_count = [
						'id_member' => $id_member,
						'invoice'   => $invoice,
						'state'     => 'active',
					];
					$arr_count = $this->M_core->get('log_member_crypto_asset', 'id', $where_count, null, null, 1);

					$description = "[$this->datetime] Member $member_email Paket $package_name Aktif";
					if ($arr_count->num_rows() == 0) {
						$data_log = [
							'id_member'         => $id_member,
							'invoice'           => $invoice,
							'amount_invest'     => $amount_1,
							'amount_transfer'   => $amount_2,
							'currency_transfer' => $currency2,
							'txn_id'            => $txn_id,
							'state'             => 'active',
							'description'       => $description,
							'created_at'        => $this->datetime,
							'updated_at'        => $this->datetime,
						];
						$this->M_core->store_uuid('log_member_crypto_asset', $data_log);

						// SEND EMAIL PACKAGE ACTIVE START
						if (ENVIRONMENT == "production") {
							$this->_send_package_active($id_member, $member_email, $invoice, $package_name, 'crypto asset');
						}
						// SEND EMAIL PACKAGE ACTIVE END
					} else {
						$data_log = [
							'description' => $description,
							'updated_at'  => $this->datetime,
						];
						$this->M_core->update('log_member_crypto_asset', $data_log, $where_count);
					}
					// STORE LOG MEMBER Crypto Asset END
				}
			}
		endforeach;

		$this->db->trans_commit();
	}

	protected function _distribusi_sponsor($id_upline, $deleted_at_upline, $amount_bonus_upline, $fullname_upline, $email_upline, $member_fullname, $member_email, $id_member, $invoice, $id_package, $package_name, $amount_1, $id_konfigurasi, $type_package)
	{
		if ($id_upline != null) {
			if ($deleted_at_upline == null) {
				$exec = $this->M_trade_manager->update_member_bonus($id_upline, $amount_bonus_upline);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Gagal Update Member Bonus Sponsor',
					]);
					exit;
				}

				$id_upline_log = $id_upline;
				$desc_log      = "$fullname_upline ($email_upline) Mendapatkan Bonus Sponsor Dari Member $member_fullname ($member_email) Paket $package_name";
			} else {
				$exec = $this->M_trade_manager->update_unknown_balance($amount_bonus_upline);
				if (!$exec) {
					$this->db->trans_rollback();

					echo json_encode([
						'code'    => 500,
						'message' => 'Gagal Update Unknown Balance Bonus Sponsor',
					]);
					exit;
				}

				$id_upline_log = null;
				$desc_log      = "Unknown Balance Mendapatkan Bonus Sponsor Dari Member $member_fullname ($member_email) Paket $package_name";
			}

			// LOG BONUS RECRUITMENT START
			$data_log = [
				'id_member'      => $id_upline_log,
				'id_downline'    => $id_member,
				'type_package'   => $type_package,
				'invoice'        => $invoice,
				'id_package'     => $id_package,
				'id_konfigurasi' => $id_konfigurasi,
				'package_name'   => $package_name,
				'package_amount' => $amount_1,
				'bonus_amount'   => $amount_bonus_upline,
				'state'          => 'get bonus',
				'description'    => $desc_log,
				'created_at'     => $this->datetime,
			];
			$exec = $this->M_core->store_uuid('log_bonus_recruitment', $data_log);
			if (!$exec) {
				$this->db->trans_rollback();

				echo json_encode([
					'code'    => 500,
					'message' => 'Gagal menyimpan Data Log Bonus Sponsor',
				]);
				exit;
			}
			// LOG BONUS RECRUITMENT END
		}
	}

	protected function _update_qualified($id_member, $member_fullname, $member_email, $id_upline, $amount_1, $invoice, $id_package, $package_name, $id_konfigurasi, $type_package)
	{

		$member_is_qualified = "no";

		$arr_ql_sibling_tm = $this->M_trade_manager->get_ql_sibling($id_member, $id_upline);

		// jika data dari trade manager tidak ada yang is_qualified == no
		if ($arr_ql_sibling_tm->num_rows() == 0) {

			// ambil data dari crypto asset
			$arr_ql_sibling_ca = $this->M_crypto_asset->get_ql_sibling($id_member, $id_upline);

			// jika ada ada dari crypto asset yang belum qualified
			if ($arr_ql_sibling_ca->num_rows() > 0) {
				$invoice_ql_sibling        = $arr_ql_sibling_ca->row()->invoice;
				$id_member_ql_sibling      = $arr_ql_sibling_ca->row()->id_member;
				$amount_usd_ql_sibling     = $arr_ql_sibling_ca->row()->amount_1;
				$id_package_ql_sibling     = $arr_ql_sibling_ca->row()->id_package;
				$id_konfigurasi_ql_sibling = $arr_ql_sibling_ca->row()->id_konfigurasi;
				$item_name_ql_sibling      = $arr_ql_sibling_ca->row()->package_name;
				$buyer_email_ql_sibling    = $arr_ql_sibling_ca->row()->member_email;
				$buyer_name_ql_sibling     = $arr_ql_sibling_ca->row()->member_fullname;
				$type_package_2            = 'crypto asset';

				$bonus_grand_upline             = ($amount_1 * BONUS_QL) / 100;
				$amount_usd_ql_sibling_as_bonus = ($amount_usd_ql_sibling * BONUS_QL) / 100;
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
										'message' => 'Gagal Update Member Bonus Kualifikasi Leader Crypto Asset',
									]);
									exit;
								}

								$desc_log_member1 = "$fullname_grand_upline ($email_grand_upline) Mendapatkan Bonus Kualifikasi Leader dari $member_fullname ($member_email) Paket $package_name";
								$desc_log_member2 = "$fullname_grand_upline ($email_grand_upline) Mendapatkan Bonus Kualifikasi Leader dari $buyer_name_ql_sibling ($buyer_email_ql_sibling) Paket $item_name_ql_sibling";
							} else {
								$exec = $this->M_crypto_asset->update_unknown_balance($new_bonus_grand_upline);

								if (!$exec) {
									$this->db->trans_rollback();

									echo json_encode([
										'code'    => 500,
										'message' => 'Gagal Update Unknown Balance Bonus Kualifikasi Leader Crypto Asset',
									]);
									exit;
								}

								$desc_log_member1 = "Unknown Balance Mendapatkan Bonus Kualifikasi Leader dari $member_fullname ($member_email) Paket $package_name";
								$desc_log_member2 = "Unknown Balance Mendapatkan Bonus Kualifikasi Leader dari $buyer_name_ql_sibling ($buyer_email_ql_sibling) Paket $item_name_ql_sibling";
							}

							$data_update_member_trade_manager = [
								'is_qualified' => 'yes',
								'updated_at'   => $this->datetime
							];
							$where_update_member_trade_manager = ['invoice' => $invoice_ql_sibling];
							$exec = $this->M_core->update('member_crypto_asset', $data_update_member_trade_manager, $where_update_member_trade_manager);
							if (!$exec) {
								$this->db->trans_rollback();
								echo json_encode([
									'code'    => 500,
									'message' => 'Gagal Update Status Member Trade Manager Kualifikasi Leader',
								]);
								exit;
							}

							$data_log1 = [
								'id_member'      => $id_grand_upline,
								'id_downline'    => $id_member,
								'type_package'   => $type_package,
								'invoice'        => $invoice,
								'id_package'     => $id_package,
								'id_konfigurasi' => $id_konfigurasi,
								'package_name'   => $package_name,
								'package_amount' => $amount_1,
								'bonus_amount'   => $bonus_grand_upline,
								'state'          => 'get bonus',
								'description'    => $desc_log_member1,
								'created_at'     => $this->datetime,
							];
							$exec = $this->M_core->store_uuid('log_bonus_qualification_level', $data_log1);
							if (!$exec) {
								$this->db->trans_rollback();
								echo json_encode([
									'code'    => 500,
									'message' => 'Gagal Menyimpan Log Bonus Kualifikasi Leader',
								]);
								exit;
							}

							$data_log2 = [
								'id_member'      => $id_grand_upline,
								'id_downline'    => $id_member_ql_sibling,
								'type_package'   => $type_package_2,
								'invoice'        => $invoice_ql_sibling,
								'id_package'     => $id_package_ql_sibling,
								'id_konfigurasi' => $id_konfigurasi_ql_sibling,
								'package_name'   => $item_name_ql_sibling,
								'package_amount' => $amount_usd_ql_sibling,
								'bonus_amount'   => $amount_usd_ql_sibling_as_bonus,
								'state'          => 'get bonus',
								'description'    => $desc_log_member2,
								'created_at'     => $this->datetime,
							];
							$exec = $this->M_core->store_uuid('log_bonus_qualification_level', $data_log2);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Gagal Menyimpan Log Bonus Kualifikasi Leader Pasangan',
								]);
								exit;
							}

							$member_is_qualified = "yes";
						}
					}
				}
			}
		} elseif ($arr_ql_sibling_tm->num_rows() > 0) {
			$invoice_ql_sibling        = $arr_ql_sibling_tm->row()->invoice;
			$id_member_ql_sibling      = $arr_ql_sibling_tm->row()->id_member;
			$amount_usd_ql_sibling     = $arr_ql_sibling_tm->row()->amount_1;
			$id_package_ql_sibling     = $arr_ql_sibling_tm->row()->id_package;
			$id_konfigurasi_ql_sibling = $arr_ql_sibling_tm->row()->id_konfigurasi;
			$item_name_ql_sibling      = $arr_ql_sibling_tm->row()->package_name;
			$buyer_email_ql_sibling    = $arr_ql_sibling_tm->row()->member_email;
			$buyer_name_ql_sibling     = $arr_ql_sibling_tm->row()->member_fullname;
			$type_package_2            = 'trade manager';

			$bonus_grand_upline             = ($amount_1 * BONUS_QL) / 100;
			$amount_usd_ql_sibling_as_bonus = ($amount_usd_ql_sibling * BONUS_QL) / 100;
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
									'message' => 'Gagal Update Member Bonus Kualifikasi Leader Trade Manager',
								]);
								exit;
							}

							$desc_log_member1 = "$fullname_grand_upline ($email_grand_upline) Mendapatkan Bonus Kualifikasi Leader dari $member_fullname ($member_email) Paket $package_name";
							$desc_log_member2 = "$fullname_grand_upline ($email_grand_upline) Mendapatkan Bonus Kualifikasi Leader dari $buyer_name_ql_sibling ($buyer_email_ql_sibling) Paket $item_name_ql_sibling";
						} else {
							$exec = $this->M_trade_manager->update_unknown_balance($new_bonus_grand_upline);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Gagal Update Unknown Balance Bonus Kualifikasi Leader Trade Manager',
								]);
								exit;
							}

							$desc_log_member1 = "Unknown Balance Mendapatkan Bonus Kualifikasi Leader dari $member_fullname ($member_email) Paket $package_name";
							$desc_log_member2 = "Unknown Balance Mendapatkan Bonus Kualifikasi Leader dari $buyer_name_ql_sibling ($buyer_email_ql_sibling) Paket $item_name_ql_sibling";
						}

						$data_update_member_trade_manager  = [
							'is_qualified' => 'yes',
							'updated_at' => $this->datetime
						];
						$where_update_member_trade_manager = ['invoice' => $invoice_ql_sibling];
						$exec = $this->M_core->update('member_trade_manager', $data_update_member_trade_manager, $where_update_member_trade_manager);

						if (!$exec) {
							$this->db->trans_rollback();

							echo json_encode([
								'code'    => 500,
								'message' => 'Gagal Update Status Member Trade Manager Kualifikasi Leader',
							]);
							exit;
						}

						$data_log1 = [
							'id_member'      => $id_grand_upline,
							'id_downline'    => $id_member,
							'type_package'   => $type_package,
							'invoice'        => $invoice,
							'id_package'     => $id_package,
							'id_konfigurasi' => $id_konfigurasi,
							'package_name'   => $package_name,
							'package_amount' => $amount_1,
							'bonus_amount'   => $bonus_grand_upline,
							'state'          => 'get bonus',
							'description'    => $desc_log_member1,
							'created_at'     => $this->datetime,
						];
						$exec = $this->M_core->store_uuid('log_bonus_qualification_level', $data_log1);
						if (!$exec) {
							$this->db->trans_rollback();

							echo json_encode([
								'code'    => 500,
								'message' => 'Gagal Menyimpan Log Bonus Kualifikasi Leader',
							]);
							exit;
						}

						$data_log2 = [
							'id_member'      => $id_grand_upline,
							'id_downline'    => $id_member_ql_sibling,
							'type_package'   => $type_package_2,
							'invoice'        => $invoice_ql_sibling,
							'id_package'     => $id_package_ql_sibling,
							'id_konfigurasi' => $id_konfigurasi_ql_sibling,
							'package_name'   => $item_name_ql_sibling,
							'package_amount' => $amount_usd_ql_sibling,
							'bonus_amount'   => $amount_usd_ql_sibling_as_bonus,
							'state'          => 'get bonus',
							'description'    => $desc_log_member2,
							'created_at'     => $this->datetime,
						];
						$exec = $this->M_core->store_uuid('log_bonus_qualification_level', $data_log2);
						if (!$exec) {
							$this->db->trans_rollback();

							echo json_encode([
								'code'    => 500,
								'message' => 'Gagal Menyimpan Log Bonus Kualifikasi Leader Pasangan',
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

	protected function _update_royalty($id_member, $member_fullname, $member_email, $amount_1, $invoice, $id_package, $id_konfigurasi, $package_name, $type_package)
	{
		$member_is_royalty = "no";

		$arr_self_tree = $this->M_core->get('et_tree', 'lft, rgt, depth', ['id_member' => $id_member]);
		$lft           = $arr_self_tree->row()->lft;
		$rgt           = $arr_self_tree->row()->rgt;
		$depth         = $arr_self_tree->row()->depth;

		$arr_generation = $this->M_core->get('et_tree', 'id_member', ['depth <' => $depth, 'lft <' => $lft, 'rgt >' => $rgt], 'depth', 'desc', 10);

		if ($arr_generation->num_rows() > 1) {
			$itteration_gen = 0;
			foreach ($arr_generation->result() as $key_gen) {
				$id_gen     = $key_gen->id_member;

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
					$generation    = $array_group[$itteration_gen];

					if (in_array($itteration_gen, $array_group)) {
						if (in_array($itteration_gen, $array_group_1)) {
							$bonus_royalty = ($amount_1 * BONUS_G2) / 100;
						} elseif (in_array($itteration_gen, $array_group_2)) {
							$bonus_royalty = ($amount_1 * BONUS_G3_G7) / 100;
						} elseif (in_array($itteration_gen, $array_group_3)) {
							$bonus_royalty = ($amount_1 * BONUS_G8_G11) / 100;
						}

						if ($is_active_gen == "yes") {
							$exec = $this->M_trade_manager->update_member_bonus($id_gen, $bonus_royalty);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Gagal Update Member Bonus Royalty',
								]);
								exit;
							}

							$id_member_log = $id_gen;
							$desc_log      = "$fullname_gen ($email_gen) Mendapatkan Bonus Royalty dari Member Generasi $generation $member_fullname ($member_email) Paket $package_name";
						} else {
							$exec = $this->M_trade_manager->update_unknown_bonus($bonus_royalty);
							if (!$exec) {
								$this->db->trans_rollback();

								echo json_encode([
									'code'    => 500,
									'message' => 'Gagal Update Unknown Balance Bonus Royalty',
								]);
								exit;
							}

							$id_member_log = null;
							$desc_log      = "Unknown Balance Mendapatkan Bonus Royalty dari Member Generasi $generation $member_fullname ($member_email) Paket $package_name";
						}

						$data_log = [
							'id_member'      => $id_member_log,
							'id_downline'    => $id_member,
							'type_package'   => $type_package,
							'invoice'        => $invoice,
							'id_package'     => $id_package,
							'id_konfigurasi' => $id_konfigurasi,
							'package_name'   => $package_name,
							'package_amount' => $amount_1,
							'bonus_amount'   => $bonus_royalty,
							'state'          => 'get bonus',
							'description'    => $desc_log,
							'created_at'     => $this->datetime,
						];
						$exec = $this->M_core->store_uuid('log_bonus_royalty', $data_log);
						if (!$exec) {
							$this->db->trans_rollback();

							echo json_encode([
								'code'    => 500,
								'message' => 'Gagal Menyimpan Log Bonus Royalty',
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

		// update self omset start
		$exec = $this->M_trade_manager->update_self_omset($id_member, $amount_usd);
		if (!$exec) {
			return false;
		}
		// update self omset end

		// update total omset start
		$exec = $this->M_trade_manager->update_total_omset($id_member, $amount_usd);
		if (!$exec) {
			return false;
		}
		// update total omset end

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
						$exec2 = $this->M_trade_manager->update_downline_omset($id_x, $amount_usd);
						$exec3 = $this->M_trade_manager->update_total_omset($id_x, $amount_usd);

						if (!$exec2 && !$exec3) {
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
		$subject = APP_NAME . " | $invoice - Paket $item_name Dibatalkan";
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
		$subject = APP_NAME . " | $invoice - Paket $item_name Menunggu Pembayaran";
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

	protected function _send_package_active($id, $to, $invoice, $item_name, $type): bool
	{
		$subject = APP_NAME . " | $invoice - Paket $item_name Aktif";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$where = [
			'id_member' => $id,
			'invoice'   => $invoice,
		];
		if ($type == "trade_manager") {
			$table = "member_trade_manager";
		} else {
			$table = "member_crypto_asset";
		}
		$data['arr_data'] = $this->M_core->get($table, '*', $where);
		$message = $this->load->view('emails/package_active_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	/*
	=======================================
	Execute Every Day at Every 5 Minutes
	=======================================
	*/
	public function withdraw()
	{
		if (!$this->input->is_cli_request()) {
			echo "Hanya dapat diakses via CLI";
			exit;
		}
		$state = "'pending'";
		$arr = $this->M_withdraw->get_list(null, null, $state);

		if ($arr->num_rows() > 0) {
			$this->db->trans_begin();
			foreach ($arr->result() as $key) {
				$id_member      = $key->id_member;
				$email_member   = $this->M_core->get('member', 'email', ['id' => $id_member])->row()->email;
				$invoice        = $key->invoice;
				$amount_1       = check_float($key->amount_1) . " <small>" . $key->currency_1 . "</small>";
				$amount_2       = check_float($key->amount_2) . " <small>" . $key->currency_2 . "</small>";
				$tx_id          = $key->tx_id;
				$source         = $key->source;
				$id_wallet      = $key->id_wallet;
				$wallet_label   = $key->wallet_label;
				$wallet_address = $key->wallet_address;

				$req       = ['id' => $tx_id];
				$arr_check = $this->_coinpayments_api_call('get_withdrawal_info', $req);

				if ($arr_check['error'] == "ok") {
					if ($arr_check['result']['status'] == 2) {
						$data = [
							'state'      => 'success',
							'updated_at' => $this->datetime,
						];
						$where = ['tx_id' => $tx_id];
						$exec  = $this->M_core->update('member_withdraw', $data, $where);

						if (!$exec) {
							$this->db->trans_rollback();
							echo "tx_id $tx_id Gagal update Status Withdraw";
							exit;
						}

						// SEND EMAIL
						if (ENVIRONMENT == "production") {
							$exec = $this->_send_withdraw_success($id_member, $email_member, $invoice, $amount_1, $amount_2, $tx_id, $source, $wallet_label, $wallet_address);
						}
						$this->db->trans_commit();
					}
				}
			}
		}
	}

	protected function _send_withdraw_success($id_member, $to, $invoice, $amount_1, $amount_2, $tx_id, $source, $wallet_label, $wallet_address): bool
	{
		$subject = APP_NAME . " | Penarikan Berhasil";
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
	Execute Every Day at Every 00:01 AM
	====================================
	*/
	public function disabled_member()
	{
		// if (!$this->input->is_cli_request()) {
		// 	echo "Hanya dapat diakses via CLI";
		// 	exit;
		// }
		$arr = $this->M_member->disabled_member();

		if ($arr === FALSE) {
			echo "Disabled Member Gagal";
		} else {
			echo "Disabled Member Done";
		}
	}

	/*
	====================================
	Execute Every Day at Every 00:02 AM
	====================================
	*/
	public function update_konfigurasi_trade_manager()
	{
		// if (!$this->input->is_cli_request()) {
		// 	echo "Hanya dapat diakses via CLI";
		// 	exit;
		// }
		$this->db->trans_begin();
		$arr = $this->M_trade_manager->get_package(null, $this->date);

		if (count($arr) > 0) {
			foreach ($arr as $key) {
				$id   = $key['id'];
				$name = $key['name'];
				$id_package_trade_manager = $key['id_package_trade_manager'];

				$data = ['is_active' => 'no'];
				$where = [
					'id_package_trade_manager' => $id_package_trade_manager,
					'is_active'                => 'yes',
					'deleted_at'               => null,
				];
				$exec = $this->M_core->update('konfigurasi_trade_manager', $data, $where);

				if (!$exec) {
					$this->db->trans_rollback();
					echo "[" . $id . " - " . $name . "] Gagal Update Konfigurasi Trade Manager";
					exit;
				}

				$data = ['is_active' => 'yes'];
				$where = [
					'id'         => $id,
					'deleted_at' => null,
				];
				$exec = $this->M_core->update('konfigurasi_trade_manager', $data, $where);

				if (!$exec) {
					$this->db->trans_rollback();
					echo "[" . $id . " - " . $name . "] Gagal Update Konfigurasi Trade Manager";
					exit;
				}

				$this->db->trans_commit();
				echo $name . " ID " . $id . " Aktif " . PHP_EOL;
			}
		} else {
			echo "Tidak ada Konfigurasi Terbaru";
		}
	}

	/*
	====================================
	Execute Every Day at Every 00:03 AM
	====================================
	*/
	public function update_konfigurasi_crypto_asset()
	{
		// if (!$this->input->is_cli_request()) {
		// 	echo "Hanya dapat diakses via CLI";
		// 	exit;
		// }
		$this->db->trans_begin();
		$arr = $this->M_crypto_asset->get_package(null, $this->date);

		if (count($arr) > 0) {
			foreach ($arr as $key) {
				$id   = $key['id'];
				$name = $key['name'];
				$id_package_crypto_asset = $key['id_package_crypto_asset'];

				$data = ['is_active' => 'no'];
				$where = [
					'id_package_crypto_asset' => $id_package_crypto_asset,
					'is_active'               => 'yes',
					'deleted_at'              => null,
				];
				$exec = $this->M_core->update('konfigurasi_crypto_asset', $data, $where);

				if (!$exec) {
					$this->db->trans_rollback();
					echo "[" . $id . " - " . $name . "] Gagal Update Konfigurasi Crypto Asset";
					exit;
				}

				$data = ['is_active' => 'yes'];
				$where = [
					'id'         => $id,
					'deleted_at' => null,
				];
				$exec = $this->M_core->update('konfigurasi_crypto_asset', $data, $where);

				if (!$exec) {
					$this->db->trans_rollback();
					echo "[" . $id . " - " . $name . "] Gagal Update Konfigurasi Crypto Asset";
					exit;
				}

				$this->db->trans_commit();
				echo $name . " ID " . $id . " Aktif " . PHP_EOL;
			}
		} else {
			echo "Tidak ada Konfigurasi Terbaru";
		}
	}

	/*
	====================================
	Execute Every Day at Every 00:04 AM
	====================================
	*/
	public function check_trade_manager_expired()
	{
		if (!$this->input->is_cli_request()) {
			echo "Hanya dapat diakses via CLI";
			exit;
		}
		$this->db->trans_begin();
		$arr = $this->M_trade_manager->get_expired_trade_manager();

		if ($arr->num_rows() > 0) {
			$data = [];
			foreach ($arr->result() as $key) {
				$invoice         = $key->invoice;
				$id_member       = $key->id_member;
				$member_fullname = $key->member_fullname;
				$member_email    = $key->member_email;
				$id_package      = $key->id_package;
				$id_konfigurasi  = $key->id_konfigurasi;
				$package_code    = $key->package_code;
				$package_name    = $key->package_name;
				$amount_1        = $key->amount_1;
				$currency1       = $key->currency1;
				$expired_package = $key->expired_package;
				$is_extend       = $key->is_extend;
				$state           = 'expired';

				if ($is_extend == "manual") {
					// REDUCE MEMBER TRADE MANAGER BALANCE START
					$this->M_trade_manager->balance_expired($id_member, $amount_1);
					// REDUCE MEMBER TRADE MANAGER BALANCE END

					// LOG START
					$description = "[$this->datetime] Member $member_fullname ($member_email) Invoice $invoice Paket $package_name Telah Kedaluwarsa Pada Tanggal $expired_package. Investasi Awal Sebesar $amount_1 USDT Telah Dipindahkan ke Profit";
					$data_log = [
						'id_member'         => $id_member,
						'invoice'           => $invoice,
						'amount_invest'     => 0,
						'amount_transfer'   => $amount_1,
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
					$this->_send_package_expired($member_email, $invoice, $package_name, $expired_package);
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
					$this->_send_package_extend($member_email, $invoice, $package_name, $new_expired);
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
			echo "Tidak ada Trade Manager Yang Kedaluwarsa Hari Ini";
		}
	}

	protected function _send_package_expired($to, $invoice, $item_name, $date_expired): bool
	{
		$subject = APP_NAME . " | Invoice $invoice Paket $item_name Kedaluwarsa";
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
		$subject = APP_NAME . " | Invoice $invoice Paket $item_name Diperpanjang";
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

	protected function _send_daily_profit($to, $item_name, $amount, $id_member): bool
	{
		$subject = APP_NAME . " | Package $item_name Pembagian Profit Harian Berhasil";
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

	/*
	====================================
	Execute Every Day at Every 00:05 AM
	====================================
	*/
	public function check_crypto_asset_expired()
	{
		if (!$this->input->is_cli_request()) {
			echo "Hanya dapat diakses via CLI";
			exit;
		}
		$this->db->trans_begin();
		$arr = $this->M_crypto_asset->get_expired_crypto_asset();

		if ($arr->num_rows() > 0) {
			$data = [];
			foreach ($arr->result() as $key) {
				$invoice         = $key->invoice;
				$id_member       = $key->id_member;
				$member_fullname = $key->member_fullname;
				$member_email    = $key->member_email;
				$id_package      = $key->id_package;
				$id_konfigurasi  = $key->id_konfigurasi;
				$package_code    = $key->package_code;
				$package_name    = $key->package_name;
				$amount_1        = $key->amount_1;
				$currency1       = $key->currency1;
				$expired_package = $key->expired_package;
				$amount_profit   = $key->amount_profit;
				$state           = 'expired';

				// UPDATE STATE START
				$nested = [
					'state'      => $state,
					'can_claim'  => 'yes',
					'updated_at' => $this->datetime,
				];
				// UPDATE STATE END

				// LOG START
				$description = "[$this->datetime] Member $member_fullname ($member_email) Paket $package_name Telah Kedaluwarsa Pada $expired_package. Member Kini Dapat Mengajukan Penerimaan Hadiah Asset Rumah.";
				$data_log = [
					'id_member'         => $id_member,
					'invoice'           => $invoice,
					'amount_invest'     => 0,
					'amount_transfer'   => 0,
					'currency_transfer' => null,
					'txn_id'            => null,
					'state'             => $state,
					'description'       => $description,
					'created_at'        => $this->datetime,
					'updated_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_member_crypto_asset', $data_log);
				// LOG END

				// EMAIL EXPIRED START
				$this->_send_package_expired_ca($member_email, $invoice, $package_name, $expired_package);
				// EMAIL EXPIRED END
				array_push($data, $nested);
			}

			$exec = $this->M_crypto_asset->update_state($data);

			if (!$exec) {
				$this->db->trans_rollback();
				exit;
			}

			$this->db->trans_commit();
		} else {
			echo "Tidak ada Crypto Asset Yang Kedaluwarsa Hari Ini";
		}
	}

	protected function _send_package_expired_ca($to, $invoice, $item_name, $date_expired): bool
	{
		$subject = APP_NAME . " | Invoice $invoice Paket $item_name Kedaluwarsa";
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
		$message = $this->load->view('emails/package_expired_ca', $data, TRUE);
		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	/*
	==============================
	Execute Every Day at 00:06 AM
	==============================
	*/
	public function reward()
	{
		if (!$this->input->is_cli_request()) {
			echo "Hanya dapat diakses via CLI";
			exit;
		}

		$arr = $this->M_member->get_data_member_reward();

		if ($arr->num_rows() > 0) :
			$this->db->trans_begin();

			foreach ($arr->result() as $key_arr) :
				$id_member = $key_arr->id; // id_member yang bakal dapat reward
				$lft       = $key_arr->lft;
				$rgt       = $key_arr->rgt;
				$depth     = $key_arr->depth;
				$reward_1  = $key_arr->reward_1;
				$reward_2  = $key_arr->reward_2;
				$reward_3  = $key_arr->reward_3;
				$reward_4  = $key_arr->reward_4;
				$reward_5  = $key_arr->reward_5;

				// REWARD CHECK
				$main_line       = $this->M_member->get_member_main_line($lft, $rgt, $depth + 1);
				$id_main_line    = $main_line->row()->id;
				$omset_main_line = $main_line->row()->total_omset;

				$omset_other_line = 0;
				$other_line = $this->M_member->get_member_other_line($lft, $rgt, $depth + 1, $id_main_line);
				if ($other_line->num_rows() > 0) {
					foreach ($other_line->result() as $key_o) {
						$omset_other_line += $key_o->total_omset;
					}
				}

				if ($reward_1 == "no" && $omset_main_line >= LIMIT_REWARD_1 && $omset_other_line >= LIMIT_REWARD_1) {
					$data = [
						'reward_1'      => 'yes',
						'reward_1_date' => $this->date,
					];
					$where = ['id_member' => $id_member];
					$exec = $this->M_core->update('member_reward', $data, $where);
					if (!$exec) {
						echo "$id_member Gagal Mendapatkan Reward 1";
						$this->db->trans_rollback();
						exit;
					} else {
						echo "$id_member Sukses Mendapatkan Reward 1";
					}
				}

				if ($reward_2 == "no" && $omset_main_line >= LIMIT_REWARD_2 && $omset_other_line >= LIMIT_REWARD_2) {
					$data = [
						'reward_2'      => 'yes',
						'reward_2_date' => $this->date,
					];
					$where = ['id_member' => $id_member];
					$exec = $this->M_core->update('member_reward', $data, $where);
					if (!$exec) {
						echo "$id_member Gagal Mendapatkan Reward 2";
						$this->db->trans_rollback();
						exit;
					} else {
						echo "$id_member Sukses Mendapatkan Reward 2";
					}
				}

				if ($reward_3 == "no" && $omset_main_line >= LIMIT_REWARD_3 && $omset_other_line >= LIMIT_REWARD_3) {
					$data = [
						'reward_3'      => 'yes',
						'reward_3_date' => $this->date,
					];
					$where = ['id_member' => $id_member];
					$exec = $this->M_core->update('member_reward', $data, $where);
					if (!$exec) {
						echo "$id_member Gagal Mendapatkan Reward 3";
						$this->db->trans_rollback();
						exit;
					} else {
						echo "$id_member Sukses Mendapatkan Reward 3";
					}
				}

				if ($reward_4 == "no" && $omset_main_line >= LIMIT_REWARD_4 && $omset_other_line >= LIMIT_REWARD_4) {
					$data = [
						'reward_4'      => 'yes',
						'reward_4_date' => $this->date,
					];
					$where = ['id_member' => $id_member];
					$exec = $this->M_core->update('member_reward', $data, $where);
					if (!$exec) {
						echo "$id_member Gagal Mendapatkan Reward 4";
						$this->db->trans_rollback();
						exit;
					} else {
						echo "$id_member Sukses Mendapatkan Reward 4";
					}
				}

				if ($reward_5 == "no" && $omset_main_line >= LIMIT_REWARD_5 && $omset_other_line >= LIMIT_REWARD_5) {
					$data = [
						'reward_5'      => 'yes',
						'reward_5_date' => $this->date,
					];
					$where = ['id_member' => $id_member];
					$exec = $this->M_core->update('member_reward', $data, $where);
					if (!$exec) {
						echo "$id_member Gagal Mendapatkan Reward 5";
						$this->db->trans_rollback();
						exit;
					} else {
						echo "$id_member Sukses Mendapatkan Reward 5";
					}
				} else {
					echo "Tidak ada Pembagian Hadiah Hari Ini";
				}

			endforeach;
			$this->db->trans_commit();
		else :
			echo "Tidak ada Pembagian Hadiah Hari Ini";
		endif;
	}


	/*
	==============================
	Execute Every Day at 00:31 AM
	==============================
	*/
	public function profit_daily_trade_manager()
	{
		if (!$this->input->is_cli_request()) {
			echo "Hanya Dapat Diakses via CLI";
			exit;
		}

		$where_arr = [
			'state'      => 'active',
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member_trade_manager', '*', $where_arr);

		if ($arr->num_rows() > 0) {
			$this->_distribusi_daily_trade_manager($arr->result());
		} else {
			echo "Tidak Ada Data";
		}
	}

	protected function _distribusi_daily_trade_manager($arr)
	{
		$this->db->trans_begin();

		foreach ($arr as $key) {
			$invoice                  = $key->invoice;
			$id_member                = $key->id_member;
			$id_member                = $key->id_member;
			$member_fullname          = $key->member_fullname;
			$member_email             = $key->member_email;
			$id_package               = $key->id_package;
			$id_konfigurasi           = $key->id_konfigurasi;
			$package_code             = $key->package_code;
			$package_name             = $key->package_name;
			$amount_1                 = $key->amount_1;
			$share_self_percentage    = $key->share_self_percentage;
			$share_self_value         = $key->share_self_value;
			$share_upline_percentage  = $key->share_upline_percentage;
			$share_upline_value       = $key->share_upline_value;
			$share_company_percentage = $key->share_company_percentage;
			$share_company_value      = $key->share_company_value;
			$share_company_value      = $key->share_company_value;
			$expired_package          = $key->expired_package;

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

			$profit_self_per_day_formated = check_float($share_self_value);
			$share_upline_value_formated  = check_float($share_upline_value);
			$share_company_value_formated = check_float($share_company_value);

			$description1  = "$member_fullname ($member_email) Mendapatkan Profit Harian Dari Paket Trade Manager $package_name";
			$description2 = "$fullname_upline ($email_upline) Mendapatkan Profit Harian Dari Downline $member_fullname ($member_email) Paket Trade Manager $package_name";
			$description3  = "Unknown Balance Mendapatkan Profit Harian Dari Downline $member_fullname ($member_email) Paket Trade Manager $package_name";

			$current_datetime_obj = new DateTime($this->datetime);
			$expired_datetime_obj = new DateTime($expired_package);
			$diff                 = $current_datetime_obj->diff($expired_datetime_obj);

			if ($diff->format('%R') == "+") {
				// MEMBER GET PROFIT START
				/* UPDATE MEMBER BALANCE START */
				$exec1 = $this->M_trade_manager->update_member_profit($id_member, $share_self_value);
				/* UPDATE MEMBER BALANCE END */

				/* LOG START */
				$data1 = [
					'id_member'         => $id_member,
					'member_fullname'   => $member_fullname,
					'member_email'      => $member_email,
					'id_downline'       => null,
					'downline_fullname' => null,
					'downline_email'    => null,
					'invoice'           => $invoice,
					'id_package'        => $id_package,
					'id_konfigurasi'    => $id_konfigurasi,
					'package_name'      => $package_name,
					'amount'            => $amount_1,
					'persentase'        => $share_self_percentage,
					'profit'            => $share_self_value,
					'state'             => 'self',
					'description'       => $description1,
					'created_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_profit_trade_manager', $data1);
				/* LOG END */

				/* EMAIL SEND START */
				if (ENVIRONMENT == "production") {
					$this->_send_daily_profit($member_email, $package_name, $share_self_value, $id_member);
				}
				/* EMAIL SEND END */
				// MEMBER GET PROFIT END

				// UPLINE GET PROFIT START
				if ($id_upline != null) {
					$exec2 = $this->M_trade_manager->update_member_profit($id_upline, $share_upline_value);

					/* LOG START */
					$data1 = [
						'id_member'         => $id_upline,
						'member_fullname'   => $fullname_upline,
						'member_email'      => $email_upline,
						'id_downline'       => $id_member,
						'downline_fullname' => $member_fullname,
						'downline_email'    => $member_email,
						'invoice'           => $invoice,
						'id_package'        => $id_package,
						'id_konfigurasi'    => $id_konfigurasi,
						'package_name'      => $package_name,
						'amount'            => $amount_1,
						'persentase'        => $share_upline_percentage,
						'profit'            => $share_upline_value,
						'state'             => 'downline',
						'description'       => $description2,
						'created_at'        => $this->datetime,
					];
					$this->M_core->store_uuid('log_profit_trade_manager', $data1);
					/* LOG END */

					/* EMAIL SEND START */
					if (ENVIRONMENT == "production") {
						$this->_send_daily_profit($email_upline, $package_name, $share_upline_value, $id_upline);
					}
					/* EMAIL SEND END */
				} else {
					$exec2 = $this->M_trade_manager->update_unknown_profit($share_upline_value);

					/* LOG start */
					$data1 = [
						'id_member'         => null,
						'member_fullname'   => null,
						'member_email'      => null,
						'id_downline'       => $id_member,
						'downline_fullname' => $member_fullname,
						'downline_email'    => $member_email,
						'invoice'           => $invoice,
						'id_package'        => $id_package,
						'id_konfigurasi'    => $id_konfigurasi,
						'package_name'      => $package_name,
						'amount'            => $amount_1,
						'persentase'        => $share_upline_percentage,
						'profit'            => $share_upline_value,
						'state'             => 'downline',
						'description'       => $description3,
						'created_at'        => $this->datetime,
					];
					$this->M_core->store_uuid('log_profit_trade_manager', $data1);
					/* LOG end */
				}
				// UPLINE GET PROFIT END

				// COMPANY GET PROFIT START
				$exec3 = $this->M_trade_manager->update_unknown_profit($share_company_value);

				/* LOG start */
				$data1 = [
					'id_member'         => null,
					'member_fullname'   => null,
					'member_email'      => null,
					'id_downline'       => $id_member,
					'downline_fullname' => $member_fullname,
					'downline_email'    => $member_email,
					'invoice'           => $invoice,
					'id_package'        => $id_package,
					'id_konfigurasi'    => $id_konfigurasi,
					'package_name'      => $package_name,
					'amount'            => $amount_1,
					'persentase'        => $share_company_percentage,
					'profit'            => $share_company_value,
					'state'             => 'company',
					'description'       => $description3,
					'created_at'        => $this->datetime,
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
	Execute Every Day at 00:32 AM
	==============================
	*/
	public function profit_daily_crypto_asset()
	{
		if (!$this->input->is_cli_request()) {
			echo "Hanya Dapat Diakses Via CLI";
			exit;
		}

		$where_arr = [
			'state'      => 'active',
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member_crypto_asset', '*', $where_arr);

		if ($arr->num_rows() > 0) {
			$this->_distribusi_daily_crypto_asset($arr->result());
		} else {
			echo "No Crypto Asset Data";
		}
	}

	protected function _distribusi_daily_crypto_asset($arr)
	{
		$this->db->trans_begin();

		foreach ($arr as $key) {
			$invoice                  = $key->invoice;
			$id_member                = $key->id_member;
			$id_member                = $key->id_member;
			$member_fullname          = $key->member_fullname;
			$member_email             = $key->member_email;
			$id_package               = $key->id_package;
			$id_konfigurasi           = $key->id_konfigurasi;
			$package_code             = $key->package_code;
			$package_name             = $key->package_name;
			$amount_1                 = $key->amount_1;
			$share_self_percentage    = $key->share_self_percentage;
			$share_self_value         = $key->share_self_value;
			$share_upline_percentage  = $key->share_upline_percentage;
			$share_upline_value       = $key->share_upline_value;
			$share_company_percentage = $key->share_company_percentage;
			$share_company_value      = $key->share_company_value;
			$share_company_value      = $key->share_company_value;
			$expired_package          = $key->expired_package;

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

			$profit_self_per_day_formated = check_float($share_self_value);
			$share_upline_value_formated  = check_float($share_upline_value);
			$share_company_value_formated = check_float($share_company_value);

			$description1  = "$member_fullname ($member_email) Mendapatkan Profit Harian Dari Paket Crypto Asset $package_name";
			$description2 = "$fullname_upline ($email_upline) Mendapatkan Profit Harian Dari Downline $member_fullname ($member_email) Paket Crypto Asset $package_name";
			$description3  = "Unknown Balance Mendapatkan Profit Harian Dari Downline $member_fullname ($member_email) Paket Crypto Asset $package_name";

			$current_datetime_obj = new DateTime($this->datetime);
			$expired_datetime_obj = new DateTime($expired_package);
			$diff                 = $current_datetime_obj->diff($expired_datetime_obj);

			if ($diff->format('%R') == "+") {
				// MEMBER GET PROFIT START
				/* UPDATE MEMBER BALANCE START */
				$exec1 = $this->M_crypto_asset->update_member_profit_asset($id_member, $share_self_value);
				/* UPDATE MEMBER BALANCE END */

				/* LOG START */
				$data1 = [
					'id_member'         => $id_member,
					'member_fullname'   => $member_fullname,
					'member_email'      => $member_email,
					'id_downline'       => null,
					'downline_fullname' => null,
					'downline_email'    => null,
					'invoice'           => $invoice,
					'id_package'        => $id_package,
					'id_konfigurasi'    => $id_konfigurasi,
					'package_name'      => $package_name,
					'amount'            => $amount_1,
					'persentase'        => $share_self_percentage,
					'profit'            => $share_self_value,
					'state'             => 'self',
					'description'       => $description1,
					'created_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_profit_crypto_asset', $data1);
				/* LOG END */

				/* EMAIL SEND START */
				if (ENVIRONMENT == "production") {
					$this->_send_daily_profit($member_email, $package_name, $share_self_value, $id_member);
				}
				/* EMAIL SEND END */
				// MEMBER GET PROFIT END

				// UPLINE GET PROFIT START
				if ($id_upline != null) {
					$exec2 = $this->M_crypto_asset->update_member_profit($id_upline, $share_upline_value);

					/* LOG START */
					$data1 = [
						'id_member'         => $id_upline,
						'member_fullname'   => $fullname_upline,
						'member_email'      => $email_upline,
						'id_downline'       => $id_member,
						'downline_fullname' => $member_fullname,
						'downline_email'    => $member_email,
						'invoice'           => $invoice,
						'id_package'        => $id_package,
						'id_konfigurasi'    => $id_konfigurasi,
						'package_name'      => $package_name,
						'amount'            => $amount_1,
						'persentase'        => $share_upline_percentage,
						'profit'            => $share_upline_value,
						'state'             => 'downline',
						'description'       => $description2,
						'created_at'        => $this->datetime,
					];
					$this->M_core->store_uuid('log_profit_crypto_asset', $data1);
					/* LOG END */

					/* EMAIL SEND START */
					if (ENVIRONMENT == "production") {
						$this->_send_daily_profit($email_upline, $package_name, $share_upline_value, $id_upline);
					}
					/* EMAIL SEND END */
				} else {
					$exec2 = $this->M_crypto_asset->update_unknown_profit($share_upline_value);

					/* LOG start */
					$data1 = [
						'id_member'         => null,
						'member_fullname'   => null,
						'member_email'      => null,
						'id_downline'       => $id_member,
						'downline_fullname' => $member_fullname,
						'downline_email'    => $member_email,
						'invoice'           => $invoice,
						'id_package'        => $id_package,
						'id_konfigurasi'    => $id_konfigurasi,
						'package_name'      => $package_name,
						'amount'            => $amount_1,
						'persentase'        => $share_upline_percentage,
						'profit'            => $share_upline_value,
						'state'             => 'downline',
						'description'       => $description3,
						'created_at'        => $this->datetime,
					];
					$this->M_core->store_uuid('log_profit_crypto_asset', $data1);
					/* LOG end */
				}
				// UPLINE GET PROFIT END

				// COMPANY GET PROFIT START
				$exec3 = $this->M_crypto_asset->update_unknown_profit($share_company_value);

				/* LOG start */
				$data1 = [
					'id_member'         => null,
					'member_fullname'   => null,
					'member_email'      => null,
					'id_downline'       => $id_member,
					'downline_fullname' => $member_fullname,
					'downline_email'    => $member_email,
					'invoice'           => $invoice,
					'id_package'        => $id_package,
					'id_konfigurasi'    => $id_konfigurasi,
					'package_name'      => $package_name,
					'amount'            => $amount_1,
					'persentase'        => $share_company_percentage,
					'profit'            => $share_company_value,
					'state'             => 'company',
					'description'       => $description3,
					'created_at'        => $this->datetime,
				];
				$this->M_core->store_uuid('log_profit_crypto_asset', $data1);
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
