<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_convert extends CI_Model
{

	public function reduce_balance($source, $amount, $id_member)
	{
		if ($source == "profit_paid") {
			return $this->db->set('profit_paid', 'profit_paid - ' . $amount, false)->where('id_member', $id_member)->update('member_balance');
		} elseif ($source == "bonus") {
			return $this->db->set('bonus', 'bonus - ' . $amount, false)->where('id_member', $id_member)->update('member_balance');
		} elseif ($source == "ratu") {
			return $this->db->set('ratu', 'ratu - ' . $amount, false)->where('id_member', $id_member)->update('member_balance');
		}
	}

	public function add_balance($source, $amount, $id_member)
	{
		if ($source == "ratu") {
			return $this->db->set('ratu', 'ratu + ' . $amount, false)->where('id_member', $id_member)->update('member_balance');
		}
	}
}
                        
/* End of file M_convert.php */
