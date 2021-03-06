<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_log_bonus_recruitment extends CI_Model
{

	public function get_log($id_member)
	{
		return $this->db
			->select([
				'member.fullname',
				'member.email',
				'member.user_id',
				'log_bonus_recruitment.type_package as type',
				'log_bonus_recruitment.package_name as package',
				'log_bonus_recruitment.description',
				'log_bonus_recruitment.package_amount',
				'log_bonus_recruitment.bonus_amount',
				'log_bonus_recruitment.created_at',
			])
			->from('log_bonus_recruitment')
			->join('member', 'member.id = log_bonus_recruitment.id_downline', 'left')
			->where('id_member', $id_member)
			->get();
	}
}
                        
/* End of file M_log_bonus_recruitment.php */
