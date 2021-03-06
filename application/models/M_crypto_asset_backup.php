<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_crypto_asset extends CI_Model
{

	public function latest_sequence()
	{
		return $this->db->select('sequence as max_sequence')
			->from('member_crypto_asset')
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

	public function update_member_profit_crypto_asset($invoice, $profit)
	{
		return $this->db->set('profit_asset', 'profit_asset + ' . $profit, false)->where('invoice', $invoice)->update('member_crypto_asset');
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
				'et_member_crypto_asset.invoice',
				'et_member_crypto_asset.id_member',
				'et_member_crypto_asset.id_package',
				'et_member_crypto_asset.item_name',
				'et_member_crypto_asset.buyer_email',
				'et_member_crypto_asset.buyer_name',
				'et_member_crypto_asset.amount_usd',
			])
			->from('et_member_crypto_asset')
			->join('et_member', 'et_member.id = et_member_crypto_asset.id_member', 'left')
			->where('et_member_crypto_asset.id_member !=', $id_member)
			->where('et_member_crypto_asset.is_qualified', 'no')
			->where('et_member_crypto_asset.state', 'active')
			->where('et_member_crypto_asset.deleted_at', null)
			->where('et_member.id_upline', $id_upline)
			->where('et_member.is_active', 'yes')
			->where('et_member.deleted_at', null)
			->group_by('et_member_crypto_asset.id_member')
			->order_by('et_member_crypto_asset.created_at', 'asc')
			->limit(1)
			->get();
	}

	public function update_total_omset($id_member, $total_omset)
	{
		return $this->db->set('total_omset', 'total_omset + ' . $total_omset, false)->where('id_member', $id_member)->update('member_balance');
	}

	public function get_member_crypto_asset($id_member = null, $invoice = null)
	{
		$this->db->select('
			mtm.invoice,
			mtm.item_name AS package,
			mtm.amount_usd AS amount,
			mtm.profit_self_per_day AS profit_per_day,
			mtm.state,
			mtm.created_at,
			mtm.expired_at,
			mtm.payment_method,
			mtm.txn_id,
			mtm.amount_coin as amount_transfer,
			ptm.profit_per_month_percent AS profit_montly_percentage,
			( mtm.amount_usd * 15 / 100 ) AS profit_montly_value,
			(( mtm.amount_usd * 15 / 100 ) / 30 ) AS profit_daily_value,
			ptm.share_self_percentage AS profit_self_percentage,
			mtm.profit_self_per_day AS profit_self_value,
			ptm.share_upline_percentage AS profit_upline_percentage,
			mtm.profit_upline_per_day AS profit_upline_value,
			ptm.share_company_percentage AS profit_company_percentage,
			mtm.profit_company_per_day AS profit_company_value,
			mtm.profit_asset
		', false);
		$this->db->from('et_member_crypto_asset AS mtm');
		$this->db->join('et_package_crypto_asset AS ptm', 'ptm.id = mtm.id_package', 'left');
		$this->db->where('mtm.deleted_at', null);

		if ($id_member != null) {
			$this->db->where('mtm.id_member', $id_member);
		}

		if ($invoice != null) {
			$this->db->where('mtm.invoice', $invoice);
		}

		$query = $this->db->get();

		$result = [];
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$invoice                   = $key->invoice;
				$package                   = $key->package;
				$amount                    = check_float($key->amount);
				$profit_per_day            = check_float($key->profit_per_day);
				$state                     = $key->state;
				$created_at                = $key->created_at;
				$expired_at                = $key->expired_at;
				$payment_method            = $key->payment_method;
				$txn_id                    = $key->txn_id;
				$amount_transfer           = check_float($key->amount_transfer);
				$profit_montly_percentage  = check_float($key->profit_montly_percentage);
				$profit_montly_value       = check_float($key->profit_montly_value);
				$profit_self_percentage    = check_float($key->profit_self_percentage);
				$profit_self_value         = check_float($key->profit_self_value);
				$profit_upline_percentage  = check_float($key->profit_upline_percentage);
				$profit_upline_value       = check_float($key->profit_upline_value);
				$profit_company_percentage = check_float($key->profit_company_percentage);
				$profit_company_value      = check_float($key->profit_company_value);
				$profit_asset              = check_float($key->profit_asset);

				$nested = [
					'invoice'                   => $invoice,
					'package'                   => $package,
					'amount'                    => $amount,
					'profit_per_day'            => $profit_per_day,
					'state'                     => $state,
					'created_at'                => $created_at,
					'expired_at'                => $expired_at,
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
					'profit_asset'              => $profit_asset,
				];

				array_push($result, $nested);
			}
		}

		return $result;
	}

	public function get_expired_crypto_asset()
	{
		return $this->db
			->select('*')
			->from('et_member_crypto_asset AS mca')
			->where('mca.deleted_at', null)
			->where('mca.state', 'active')
			->where('mca.expired_at <=', date('Y-m-d'))
			->get();
	}

	public function update_state($data)
	{
		return $this->db->update_batch('member_cryoto_asset', $data, 'invoice');
	}

	public function update_member_crypto_asset_asset($id_member, $amount)
	{
		return $this->db
			->set('total_invest_crypto_asset', 'total_invest_crypto_asset + ' . $amount, false)
			->set('count_crypto_asset', 'count_crypto_asset + 1', false)
			->where('id_member', $id_member)
			->update('member_balance');
	}

	public function get_ca_unpaid()
	{
		return $this->db
			->from('member_crypto_asset')
			->where('deleted_at', null)
			->where('state in', "('waiting payment', 'pending')", false)
			->get();
	}

	public function get_group_invoice($id_member)
	{
		return $this->db
			->select([
				'member_crypto_asset.invoice',
				'package_crypto_asset.name',
			])
			->from('member_crypto_asset')
			->join('package_crypto_asset', 'package_crypto_asset.id = member_crypto_asset.id_package', 'left')
			->where('member_crypto_asset.deleted_at', null)
			->where('id_member', $id_member)
			->group_by('member_crypto_asset.invoice')
			->get();
	}

	public function get_package($id = null)
	{
		if ($id != null) {
			$this->db->where('konfigurasi_trade_manager.id', $id);
		}

		$query = $this->db
			->select([
				'konfigurasi_trade_manager.id',
				'package_trade_manager.code',
				'package_trade_manager.name',
				'package_trade_manager.amount',
				'package_trade_manager.contract_duration',
				'package_trade_manager.logo',
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
			->where('is_active', 'yes')
			->where('deleted_at', null)
			->order_by('package_trade_manager.sequence', 'asc')
			->get();

		$data = [];
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $item) {
				$id                        = $item->id;
				$code                      = $item->code;
				$name                      = $item->name;
				$amount                    = check_float($item->amount);
				$contract_duration         = $item->contract_duration;
				$logo                      = $item->logo;
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
					'id',
					'code',
					'name',
					'amount',
					'contract_duration',
					'logo',
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
}
                        
/* End of file M_crypto_asset.php */
