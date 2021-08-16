<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

	public function count_user_id($user_id, $id_member)
	{
		$arr = $this->db
			->select('*')
			->from('et_member AS member')
			->where('id_upline', $id_member)
			->where('user_id', $user_id)
			->get();

		return $arr->num_rows();
	}
}
                        
/* End of file M_login.php */
