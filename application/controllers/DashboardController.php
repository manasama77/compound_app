<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
	protected $id_member;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_member', null, 'template');
		$this->load->library('Nested_set', null, 'Nested_set');
		$this->load->helper('Custom_array_helper');
		$this->load->model('M_dashboard');
		$this->load->model('M_member');
		$this->load->model('M_tree');
		$this->load->helper('Floating_helper');


		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->Nested_set->setControlParams('tree', 'lft', 'rgt', 'id_member', 'id_upline', 'email');
	}


	public function index()
	{
		$data_card            = [];
		$data_latest_downline = [];
		$recruitment_link     = "";

		if (!$this->id_member) {
			redirect('logout');
		}

		$data_card            = $this->_card();
		$data_latest_downline = $this->_latest_downline($this->id_member);
		$recruitment_link     = $this->_generate_recruitment_link();

		$data = [
			'title'                => APP_NAME . " | Dashboard",
			'content'              => 'dashboard/main',
			'vitamin_js'           => 'dashboard/main_js',
			'data_card'            => $data_card,
			'data_latest_downline' => $data_latest_downline,
			'recruitment_link'     => $recruitment_link,
		];

		$this->template->render($data);
	}

	public function downline_detail()
	{
		header('Content-Type: application/json');

		$id_member = $this->input->get('id_member');

		$limit = ($this->input->get('limit')) ?? 5;

		$where_package = [
			'id_member'  => $id_member,
			'deleted_at' => null,
		];
		$arr_package = $this->M_core->get('member_trade_manager', '*', $where_package);

		$data_package = [];
		if ($arr_package->num_rows() > 0) {
			foreach ($arr_package->result() as $key) {
				$package_name     = $key->package_name;
				$amount_1         = check_float($key->amount_1);
				$share_self_value = check_float($key->share_self_value);
				$expired_package  = $key->expired_package;
				$state            = $key->state;

				$now_obj     = new DateTime('now');
				$expired_obj = new DateTime($expired_package);
				$diff        = $now_obj->diff($expired_obj);

				if ($diff->format('%r') == "-") {
					$duration = $diff->format('+%a hari tidak aktif');
				} else {
					$duration = $diff->format('%r%a hari lagi');
				}

				if ($state == "waiting payment") {
					$badge_color = 'info';
					$text        = "Menunggu Pembayaran";
				} elseif ($state == "pending") {
					$badge_color = 'secondary';
					$text        = "Pembayaran Sedang Diproses";
				} elseif ($state == "active") {
					$badge_color = 'success';
					$text        = "Aktif";
				} elseif ($state == "inactive") {
					$badge_color = 'dark';
					$text        = "Tidak Aktif";
				} elseif ($state == "cancel") {
					$badge_color = 'warning';
					$text        = "Transaksi Dibatalkan";
				} elseif ($state == "expired") {
					$badge_color = 'danger';
					$text        = "Pembayaran Melewati Batas Waktu";
				}

				$status_badge = '<span class="badge badge-' . $badge_color . '">' . ucwords($text) . '</span>';

				$nested = [
					'package'        => $package_name,
					'amount'         => $amount_1,
					'profit_per_day' => $share_self_value,
					'duration'       => $duration,
					'status'         => $status_badge,
				];

				array_push($data_package, $nested);
			}
		}

		$data_downline = $this->_latest_downline($id_member, $limit);

		echo json_encode([
			'code'          => 200,
			'data_package'  => $data_package,
			'data_downline' => $data_downline,
		]);
	}

	public function _card()
	{
		$data_balance       = $this->_get_member_balance();
		$count_all_downline = $this->_count_all_downline();

		$return = [
			'data_balance'       => $data_balance,
			'count_all_downline' => $count_all_downline,
		];

		return $return;
	}

	public function _get_member_balance()
	{
		$data_balance = [];

		// GET MEMBER BALANCE
		$arr_balance = $this->M_dashboard->get_member_balance($this->id_member);

		if ($arr_balance->num_rows() > 0) {
			$total_invest_trade_manager = check_float($arr_balance->row()->total_invest_trade_manager);
			$total_invest_crypto_asset  = check_float($arr_balance->row()->total_invest_crypto_asset);
			$profit                     = check_float($arr_balance->row()->profit);
			$bonus                      = check_float($arr_balance->row()->bonus);
			$downline_omset             = check_float($arr_balance->row()->downline_omset);

			$data_balance = [
				'total_invest_trade_manager' => $total_invest_trade_manager,
				'total_invest_crypto_asset'  => $total_invest_crypto_asset,
				'profit'                     => $profit,
				'bonus'                      => $bonus,
				'downline_omset'             => $downline_omset,
			];
		}

		return $data_balance;
	}

	public function _count_all_downline()
	{
		$count = $this->M_dashboard->count_all_downline($this->id_member);
		return check_float($count->row()->count_all_downline);
	}

	public function _latest_downline($id_member, $limit = 5)
	{
		$arr = $this->M_dashboard->get_latest_downline($id_member, null, $limit);
		return $arr;
	}

	public function _generate_recruitment_link()
	{
		$hash             = hash_hmac('sha1', $this->id_member, UYAH);
		$email_encode     = base64_encode($this->id_member);
		$recruitment_link = site_url('registration/' . $email_encode . '/' . $hash);

		return $recruitment_link;
	}
}
        
/* End of file  DashboardController.php */
