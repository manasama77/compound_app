<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_withdraw extends CI_Model
{

	public function get_list($id_member = null, $tx_id = null, $state = "'pending', 'success', 'cancel'")
	{
		$this->db->from('member_withdraw');
		if ($id_member != null) {
			$this->db->where('id_member', $id_member);
		}

		if ($tx_id != null) {
			$this->db->where('tx_id', $tx_id);
		}

		$this->db->where("state in(" . $state . ")", null, true);

		$this->db->where('deleted_at', null);
		$this->db->order_by('created_at', 'asc');
		$this->db->limit(50);
		$query = $this->db->get();
		return $query;
	}

	public function latest_sequence()
	{
		return $this->db->select('sequence as max_sequence')
			->from('member_withdraw')
			->where("DATE(created_at) = '" . date('Y-m-d') . "'", null, true)
			->where('deleted_at', null)
			->order_by('sequence', 'desc')
			->limit(1)
			->get();
	}

	public function reduce_member_profit($id_member, $profit)
	{
		return $this->db->set('profit', 'profit - ' . $profit, false)->where('id_member', $id_member)->update('member_balance');
	}

	public function reduce_member_bonus($id_member, $bonus)
	{
		return $this->db->set('bonus', 'bonus - ' . $bonus, false)->where('id_member', $id_member)->update('member_balance');
	}
}
                        
/* End of file M_withdraw.php */
