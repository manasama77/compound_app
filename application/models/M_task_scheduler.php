<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_task_scheduler extends CI_Model
{
	protected $date;

	public function __construct()
	{
		parent::__construct();
		$this->date = date('Y-m-d');
	}


	public function get_recursive_downline_qualified_level($id_parent)
	{
		$query = "
		with recursive tree (id, fullname, id_upline) as (
			select	parent.id,
					parent.fullname,
					parent.id_upline
			from	et_member parent
			where	parent.id_upline = '$id_parent'

			union all

			select	downline.id,
					downline.fullname,
					downline.id_upline
			from	et_member downline
			inner join tree on downline.id_upline = tree.id
		)
		select * from tree;
		";
	}

	public function release_unpaid_tm()
	{
		$query = $this->db
			->select([
				'log_profit_trade_manager.id',
				'log_profit_trade_manager.id_member',
				'log_profit_trade_manager.profit',
				'log_profit_trade_manager.release_date',
				'member.deleted_at'
			])
			->from('log_profit_trade_manager as log_profit_trade_manager')
			->join('member as member', 'member.id = log_profit_trade_manager.id_member', 'left')
			->where('log_profit_trade_manager.is_unpaid', 'yes')
			->where('log_profit_trade_manager.release_date', $this->date)
			->get();

		if ($query->num_rows() == 0) {
			return false;
		}

		$this->db->trans_begin();

		foreach ($query->result() as $key) {
			$id         = $key->id;
			$id_member  = $key->id_member;
			$profit     = $key->profit;
			$deleted_at = $key->deleted_at;

			if ($id_member != null) {
				if ($deleted_at == null) {
					$q1 = $this->db
						->set('profit_paid', 'profit_paid + ' . $profit, false)
						->set('profit_unpaid', 'profit_unpaid - ' . $profit, false)
						->where('id_member', $id_member)
						->update('member_balance');

					if (!$q1) {
						$this->db->trans_rollback();
						echo "Failed Update Member Balance $id_member, $profit <br/>";
						return false;
					}

					echo $this->db->last_query() . "<br/>";

					$data  = ['is_unpaid' => 'no'];
					$where = ['id'        => $id];
					$q2    = $this->db->update('log_profit_trade_manager', $data, $where);

					if (!$q2) {
						$this->db->trans_rollback();
						echo "Failed Update Log Profit $id, $profit <br/>";
						return false;
					}

					echo $this->db->last_query() . "<br/>";
				}
			} else {
				$q1 = $this->db
					->set('amount_profit_paid', 'amount_profit_paid + ' . $profit, false)
					->set('amount_profit_unpaid', 'amount_profit_unpaid - ' . $profit, false)
					->where('id', '1')
					->update('unknown_balance');

				if (!$q1) {
					$this->db->trans_rollback();
					echo "Failed Update Unknown Balance $profit <br/>";
					return false;
				}

				$data  = ['is_unpaid' => 'no'];
				$where = ['id'        => $id];
				$q2    = $this->db->update('log_profit_trade_manager', $data, $where);

				if (!$q2) {
					$this->db->trans_rollback();
					echo "Failed Update Log Profit $id, $profit <br/>";
					return false;
				}
			}
		}

		$this->db->trans_commit();
		return true;
	}

	public function release_unpaid_ca()
	{
		$query = $this->db
			->select([
				'log_profit_crypto_asset.id',
				'log_profit_crypto_asset.id_member',
				'log_profit_crypto_asset.profit',
				'log_profit_crypto_asset.release_date',
				'member.deleted_at'
			])
			->from('log_profit_crypto_asset as log_profit_crypto_asset')
			->join('member as member', 'member.id = log_profit_crypto_asset.id_member', 'left')
			->where('log_profit_crypto_asset.is_unpaid', 'yes')
			->where('log_profit_crypto_asset.release_date', $this->date)
			->get();

		if ($query->num_rows() == 0) {
			return false;
		}

		$this->db->trans_begin();

		foreach ($query->result() as $key) {
			$id         = $key->id;
			$id_member  = $key->id_member;
			$profit     = $key->profit;
			$deleted_at = $key->deleted_at;

			if ($id_member != null) {
				if ($deleted_at == null) {
					$q1 = $this->db
						->set('profit_paid', 'profit_paid + ' . $profit, false)
						->set('profit_unpaid', 'profit_unpaid - ' . $profit, false)
						->where('id_member', $id_member)
						->update('member_balance');

					if (!$q1) {
						$this->db->trans_rollback();
						echo "Failed Update Member Balance $id_member, $profit <br/>";
						return false;
					}

					$data  = ['is_unpaid' => 'no'];
					$where = ['id'        => $id];
					$q2    = $this->db->update('log_profit_crypto_asset', $data, $where);

					if (!$q2) {
						$this->db->trans_rollback();
						echo "Failed Update Log Profit $id, $profit <br/>";
						return false;
					}
				}
			} else {
				$q1 = $this->db
					->set('amount_profit_paid', 'amount_profit_paid + ' . $profit, false)
					->set('amount_profit_unpaid', 'amount_profit_unpaid - ' . $profit, false)
					->where('id', '1')
					->update('unknown_balance');

				if (!$q1) {
					$this->db->trans_rollback();
					echo "Failed Update Unknown Balance $profit <br/>";
					return false;
				}

				$data  = ['is_unpaid' => 'no'];
				$where = ['id'        => $id];
				$q2    = $this->db->update('log_profit_crypto_asset', $data, $where);

				if (!$q2) {
					$this->db->trans_rollback();
					echo "Failed Update Log Profit $id, $profit <br/>";
					return false;
				}
			}
		}

		$this->db->trans_commit();
		return true;
	}
}
                        
/* End of file M_task_scheduler.php */
