<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_trade_manager extends CI_Model
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('floating_helper');

		$this->datetime = date('Y-m-d H:i:s');
	}

	public function get_package($id = null, $date = null)
	{
		if ($id != null) {
			$this->db->where('konfigurasi_trade_manager.id', $id);
		}

		if ($date != null) {
			$this->db->where('DATE(konfigurasi_trade_manager.tanggal_aktif) =', $date);
			$this->db->where('konfigurasi_trade_manager.is_active', 'no');
		} else {
			$this->db->where('konfigurasi_trade_manager.is_active', 'yes');
		}

		$query = $this->db
			->select([
				'konfigurasi_trade_manager.tanggal_aktif',
				'konfigurasi_trade_manager.id',
				'package_trade_manager.code',
				'package_trade_manager.name',
				'package_trade_manager.amount',
				'package_trade_manager.contract_duration',
				'package_trade_manager.logo',
				'konfigurasi_trade_manager.id_package_trade_manager',
				'konfigurasi_trade_manager.profit_per_month_percent',
				'konfigurasi_trade_manager.profit_per_month_value',
				'konfigurasi_trade_manager.profit_per_day_percentage',
				'konfigurasi_trade_manager.profit_per_day_value',
				'konfigurasi_trade_manager.share_self_percentage',
				'konfigurasi_trade_manager.share_self_value',
				'konfigurasi_trade_manager.share_upline_percentage',
				'konfigurasi_trade_manager.share_upline_value',
				'konfigurasi_trade_manager.share_company_percentage',
				'konfigurasi_trade_manager.share_company_value',
			])
			->from('konfigurasi_trade_manager as konfigurasi_trade_manager')
			->join('package_trade_manager as package_trade_manager', 'package_trade_manager.id = konfigurasi_trade_manager.id_package_trade_manager', 'left')
			->where('deleted_at', null)
			->order_by('package_trade_manager.sequence', 'asc')
			->get();

		$data = [];
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $item) {
				$tanggal_aktif             = $item->tanggal_aktif;
				$id                        = $item->id;
				$code                      = $item->code;
				$name                      = $item->name;
				$amount                    = check_float($item->amount);
				$contract_duration         = $item->contract_duration;
				$logo                      = $item->logo;
				$id_package_trade_manager  = $item->id_package_trade_manager;
				$profit_per_month_percent  = check_float($item->profit_per_month_percent);
				$profit_per_month_value    = check_float($item->profit_per_month_value);
				$profit_per_day_percentage = check_float($item->profit_per_day_percentage);
				$profit_per_day_value      = check_float($item->profit_per_day_value);
				$share_self_percentage     = check_float($item->share_self_percentage);
				$share_self_value          = check_float($item->share_self_value);
				$share_upline_percentage   = check_float($item->share_upline_percentage);
				$share_upline_value        = check_float($item->share_upline_value);
				$share_company_percentage  = check_float($item->share_company_percentage);
				$share_company_value       = check_float($item->share_company_value);

				$nested = compact([
					'tanggal_aktif',
					'id',
					'code',
					'name',
					'amount',
					'contract_duration',
					'logo',
					'id_package_trade_manager',
					'profit_per_month_percent',
					'profit_per_month_value',
					'profit_per_day_percentage',
					'profit_per_day_value',
					'share_self_percentage',
					'share_self_value',
					'share_upline_percentage',
					'share_upline_value',
					'share_company_percentage',
					'share_company_value',
				]);

				array_push($data, $nested);
			}
		}

		return $data;
	}

	public function latest_sequence()
	{
		return $this->db->select('sequence as max_sequence')
			->from('member_trade_manager')
			->where("state IN ('waiting payment', 'active', 'inactive', 'cancel', 'expired')", null, true)
			->where("DATE(created_at) = '" . date('Y-m-d') . "'", null, true)
			->where('deleted_at', null)
			->order_by('sequence', 'desc')
			->limit(1)
			->get();
	}

	public function update_member_profit($id_member, $profit)
	{
		return $this->db->set('profit', 'profit + ' . $profit, false)->where('id_member', $id_member)->update('member_balance');
	}

	public function update_unknown_profit($profit)
	{
		return $this->db->set('amount_profit', 'amount_profit + ' . $profit, false)->where('id', 1)->update('unknown_balance');
	}

	public function update_member_bonus($id_member, $bonus)
	{
		return $this->db->set('bonus', 'bonus + ' . $bonus, false)->where('id_member', $id_member)->update('member_balance');
	}

	public function update_unknown_bonus($bonus)
	{
		return $this->db->set('amount_bonus', 'amount_bonus + ' . $bonus, false)->where('id', 1)->update('unknown_balance');
	}

	public function get_ql_sibling($id_member, $id_upline)
	{
		return $this->db
			->select([
				'member_trade_manager.invoice',
				'member_trade_manager.id_member',
				'member_trade_manager.member_fullname',
				'member_trade_manager.member_email',
				'member_trade_manager.id_package',
				'member_trade_manager.id_konfigurasi',
				'member_trade_manager.package_code',
				'member_trade_manager.package_name',
				'member_trade_manager.amount_1',
			])
			->from('member_trade_manager as member_trade_manager')
			->join('member as member', 'member.id = member_trade_manager.id_member', 'left')
			->where('member_trade_manager.id_member !=', $id_member)
			->where('member_trade_manager.is_qualified', 'no')
			->where('member_trade_manager.state', 'active')
			->where('member_trade_manager.deleted_at', null)
			->where('member.id_upline', $id_upline)
			->where('member.is_active', 'yes')
			->where('member.deleted_at', null)
			->order_by('member_trade_manager.created_at', 'asc')
			->limit(1)
			->get();
	}

	public function update_self_omset($id_member, $self_omset)
	{
		return $this->db
			->set('self_omset', 'self_omset + ' . $self_omset, false)
			->where('id_member', $id_member)
			->update('member_balance');
	}

	public function update_downline_omset($id_member, $downline_omset)
	{
		return $this->db
			->set('downline_omset', 'downline_omset + ' . $downline_omset, false)
			->where('id_member', $id_member)
			->update('member_balance');
	}

	public function update_total_omset($id_member, $total_omset)
	{
		return $this->db
			->set('total_omset', 'total_omset + ' . $total_omset, false)
			->where('id_member', $id_member)
			->update('member_balance');
	}

	public function get_member_trade_manager($id_member = null, $invoice = null)
	{
		$this->db->select('
			member_trade_manager.invoice,
			member_trade_manager.member_fullname,
			member_trade_manager.member_email,
			member_trade_manager.package_code,
			member_trade_manager.package_name,
			member_trade_manager.amount_1,
			member_trade_manager.amount_2,
			member_trade_manager.currency1,
			member_trade_manager.currency2,
			member_trade_manager.state,
			member_trade_manager.expired_package,
			member_trade_manager.is_extend,
			member_trade_manager.profit_per_month_percent,
			member_trade_manager.profit_per_month_value,
			member_trade_manager.profit_per_day_percentage,
			member_trade_manager.profit_per_day_value,
			member_trade_manager.share_self_percentage,
			member_trade_manager.share_self_value,
			member_trade_manager.share_upline_percentage,
			member_trade_manager.share_upline_value,
			member_trade_manager.share_company_percentage,
			member_trade_manager.share_company_value,
			member_trade_manager.txn_id,
			member_trade_manager.created_at,
			member_trade_manager.updated_at,
		', false);
		$this->db->from('member_trade_manager AS member_trade_manager');
		$this->db->where('member_trade_manager.deleted_at', null);

		if ($id_member != null) {
			$this->db->where('member_trade_manager.id_member', $id_member);
		}

		if ($invoice != null) {
			$this->db->where('member_trade_manager.invoice', $invoice);
		}

		$query = $this->db->get();

		$result = [];
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$invoice                   = $key->invoice;
				$member_fullname           = $key->member_fullname;
				$member_email              = $key->member_email;
				$package_code              = $key->package_code;
				$package_name              = $key->package_name;
				$amount_1                  = check_float($key->amount_1);
				$amount_2                  = check_float($key->amount_2);
				$currency1                 = $key->currency1;
				$currency2                 = $key->currency2;
				$state                     = $key->state;
				$expired_package           = $key->expired_package;
				$is_extend                 = $key->is_extend;
				$profit_per_month_percent  = check_float($key->profit_per_month_percent);
				$profit_per_month_value    = check_float($key->profit_per_month_value);
				$profit_per_day_percentage = check_float($key->profit_per_day_percentage);
				$profit_per_day_value      = check_float($key->profit_per_day_value);
				$share_self_percentage     = check_float($key->share_self_percentage);
				$share_self_value          = check_float($key->share_self_value);
				$share_upline_percentage   = check_float($key->share_upline_percentage);
				$share_upline_value        = check_float($key->share_upline_value);
				$share_company_percentage  = check_float($key->share_company_percentage);
				$share_company_value       = check_float($key->share_company_value);
				$txn_id                    = $key->txn_id;
				$created_at                = $key->created_at;
				$updated_at                = $key->updated_at;

				if ($state == "waiting payment") {
					$badge_color   = 'info';
					$badge_text    = 'Menunggu Pembayaran';
				} elseif ($state == "pending") {
					$badge_color   = 'secondary';
					$badge_text    = 'Pembayaran Sedang Diproses';
				} elseif ($state == "active") {
					$badge_color = 'success';
					$badge_text  = 'Aktif';
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

				$state_badge = '<span class="badge badge-' . $badge_color . '">' . ucwords($badge_text) . '</span>';

				$nested = [
					'invoice'                   => $invoice,
					'member_fullname'           => $member_fullname,
					'member_email'              => $member_email,
					'package_code'              => $package_code,
					'package_name'              => $package_name,
					'amount_1'                  => $amount_1,
					'amount_2'                  => $amount_2,
					'currency1'                 => $currency1,
					'currency2'                 => $currency2,
					'state'                     => $state,
					'state_badge'               => $state_badge,
					'expired_package'           => $expired_package,
					'is_extend'                 => $is_extend,
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
					'txn_id'                    => $txn_id,
					'created_at'                => $created_at,
					'updated_at'                => $updated_at,
				];

				array_push($result, $nested);
			}
		}

		return $result;
	}

	public function get_expired_trade_manager()
	{
		return $this->db
			->select('*')
			->from('et_member_trade_manager AS mtm')
			->where('mtm.deleted_at', null)
			->where('mtm.state', 'active')
			->where('mtm.expired_at <=', date('Y-m-d'))
			->get();
	}

	public function update_state($data)
	{
		return $this->db->update_batch('member_trade_manager', $data, 'invoice');
	}

	public function update_member_trade_manager_asset($id_member, $amount)
	{
		return $this->db
			->set('total_invest_trade_manager', 'total_invest_trade_manager + ' . $amount, false)
			->set('count_trade_manager', 'count_trade_manager + 1', false)
			->where('id_member', $id_member)
			->update('member_balance');
	}

	public function get_tm_unpaid()
	{
		return $this->db
			->from('member_trade_manager')
			->where('deleted_at', null)
			->where('state in', "('waiting payment', 'pending')", false)
			->get();
	}

	public function balance_expired($id_member, $amount)
	{
		return $this->db
			->set('total_invest_trade_manager', 'total_invest_trade_manager - ' . $amount, false)
			->set('count_trade_manager', 'count_trade_manager - 1', false)
			->set('profit', 'profit + ' . $amount, false)
			->where('id_member', $id_member)
			->update('member_balance');
	}

	public function get_group_invoice($id_member)
	{
		return $this->db
			->select([
				'member_trade_manager.invoice',
				'package_trade_manager.name',
			])
			->from('member_trade_manager')
			->join('package_trade_manager', 'package_trade_manager.id = member_trade_manager.id_package', 'left')
			->where('member_trade_manager.deleted_at', null)
			->where('id_member', $id_member)
			->group_by('member_trade_manager.invoice')
			->get();
	}
}
                        
/* End of file M_trade_manager.php */
