<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_trade_manager extends CI_Model
{

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
				'member_trade_manager.id_package',
				'member_trade_manager.item_name',
				'member_trade_manager.buyer_email',
				'member_trade_manager.buyer_name',
				'member_trade_manager.amount_usd',
			])
			->from('member_trade_manager')
			->join('et_member', 'et_member.id = et_member_trade_manager.id_member', 'left')
			->where('et_member_trade_manager.id_member !=', $id_member)
			->where('et_member_trade_manager.is_qualified', 'no')
			->where('et_member_trade_manager.state', 'active')
			->where('et_member_trade_manager.deleted_at', null)
			->where('et_member.id_upline', $id_upline)
			->where('et_member.is_active', 'yes')
			->where('et_member.deleted_at', null)
			->group_by('member_trade_manager.id_member')
			->order_by('et_member_trade_manager.created_at', 'asc')
			->limit(1)
			->get();
	}

	public function update_total_omset($id_member, $total_omset)
	{
		return $this->db->set('total_omset', 'total_omset + ' . $total_omset, false)->where('id_member', $id_member)->update('member_balance');
	}

	public function get_member_trade_manager($id_member = null, $invoice = null)
	{
		$this->db->select('
			mtm.invoice,
			mtm.item_name AS package,
			mtm.amount_usd AS amount,
			mtm.state,
			mtm.created_at,
			mtm.expired_at,
			mtm.is_extend,
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
			mtm.profit_company_per_day AS profit_company_value 
		', false);
		$this->db->from('et_member_trade_manager AS mtm');
		$this->db->join('et_package_trade_manager AS ptm', 'ptm.id = mtm.id_package', 'left');
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
				$state                     = $key->state;
				$created_at                = $key->created_at;
				$expired_at                = $key->expired_at;
				$is_extend                 = $key->is_extend;
				$payment_method            = $key->payment_method;
				$txn_id                    = $key->txn_id;
				$amount_transfer           = check_float($key->amount_transfer);
				$profit_montly_percentage  = check_float($key->profit_montly_percentage);
				$profit_montly_value       = check_float($key->profit_montly_value);
				$profit_per_day            = check_float($key->profit_montly_value / 30);
				$profit_self_percentage    = check_float($key->profit_self_percentage);
				$profit_self_value         = check_float($key->profit_self_value);
				$profit_upline_percentage  = check_float($key->profit_upline_percentage);
				$profit_upline_value       = check_float($key->profit_upline_value);
				$profit_company_percentage = check_float($key->profit_company_percentage);
				$profit_company_value      = check_float($key->profit_company_value);

				$nested = [
					'invoice'                   => $invoice,
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
}
                        
/* End of file M_trade_manager.php */
