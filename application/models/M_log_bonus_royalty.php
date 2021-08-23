<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_log_bonus_royalty extends CI_Model
{

	public function get_log($id_member)
	{
		return $this->db
			->select([
				'downline.user_id as downline_user_id',
				'upline.user_id as upline_user_id',
				'log_bonus_royalty.type_package as type',
				'log_bonus_royalty.package_name as package',
				'log_bonus_royalty.description',
				'log_bonus_royalty.package_amount',
				'log_bonus_royalty.created_at',
			])
			->from('log_bonus_royalty')
			->join('member as downline', 'downline.id = log_bonus_royalty.id_downline', 'left')
			->join('member as upline', 'upline.id = downline.id_upline', 'left')
			->where('log_bonus_royalty.id_member', $id_member)
			->get();
	}
}
                        
/* End of file M_log_bonus_royalty.php */
