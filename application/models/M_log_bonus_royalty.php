<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_log_bonus_royalty extends CI_Model
{

	public function get_log($id_member)
	{
		return $this->db
			->select([
				'member.fullname',
				'log_bonus_royalty.type_package as type',
				'log_bonus_royalty.package_name as package',
				'log_bonus_royalty.description',
				'log_bonus_royalty.created_at',
			])
			->from('log_bonus_royalty')
			->join('member', 'member.id = log_bonus_royalty.id_downline', 'left')
			->where('id_member', $id_member)
			->get();
	}
}
                        
/* End of file M_log_bonus_royalty.php */
