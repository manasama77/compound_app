<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_test extends CI_Model
{


	public function perbaikan_omset_downline()
	{
		$this->db->trans_begin();

		$member = $this->db
			->select([
				'tree.id_member',
				'tree.lft',
				'tree.rgt',
				'balance.self_omset',
			])
			->from('tree as tree')
			->join('et_member_balance AS balance', 'balance.id_member = tree.id_member', 'left')
			->order_by('tree.lft', 'asc')
			->get();

		foreach ($member->result() as $key) {
			$id_member  = $key->id_member;
			$lft        = $key->lft;
			$rgt        = $key->rgt;
			$self_omset = $key->self_omset;

			$arr_downline = $this->db
				->select([
					'SUM( balance.self_omset ) AS sum_downline_omset'
				])
				->from('et_tree as tree')
				->join('et_member_balance AS balance', 'balance.id_member = tree.id_member', 'left')
				->where('tree.lft >', $lft)
				->where('tree.rgt <', $rgt)
				->order_by('tree.lft', 'asc')
				->get();

			$downline_omset = ($arr_downline->row()->sum_downline_omset == NULL) ? 0 : $arr_downline->row()->sum_downline_omset;
			$total_omset    = $self_omset + $downline_omset;

			$data = [
				'downline_omset' => $downline_omset,
				'total_omset'    => $total_omset,
			];
			$where = ['id_member' => $id_member];
			$exec = $this->db->update('member_balance', $data, $where);

			if (!$exec) {
				$this->db->trans_rollback();
				exit;
			}

			echo $this->db->last_query();
			echo "<br/>";
			$this->db->trans_commit();
		}
	}
}
                        
/* End of file M_test.php */
