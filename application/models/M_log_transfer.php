<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_log_transfer extends CI_Model
{

	public function get_data($id_member)
	{
		$query = $this->db
			->select([
				'from_member.user_id AS `from`',
				'to_member.user_id AS `to`',
				'log_transfer.amount',
				'log_transfer.created_at'
			])
			->from('log_transfer as log_transfer')
			->join('member AS from_member', 'from_member.id = log_transfer.`from`', 'left')
			->join('member AS to_member', 'to_member.id = log_transfer.`to`', 'left')
			->where('log_transfer.`from`', $id_member)
			->or_where('log_transfer.`to`', $id_member)
			->get();

		return $query;
	}
}
                        
/* End of file M_log_transfer.php */
