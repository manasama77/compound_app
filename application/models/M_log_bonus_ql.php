<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_log_bonus_ql extends CI_Model
{

	public function get_log($id_member)
	{
		return $this->db
			->select([
				'member.fullname',
				'log_bonus_qualification_level.type_package as type',
				'log_bonus_qualification_level.package_name as package',
				'log_bonus_qualification_level.description',
			])
			->from('log_bonus_qualification_level')
			->join('member', 'member.id = log_bonus_qualification_level.id_downline', 'left')
			->where('id_member', $id_member)
			->get();
	}
}
                        
/* End of file M_log_bonus_ql.php */
