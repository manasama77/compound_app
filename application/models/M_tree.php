<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_tree extends CI_Model
{

	public function get_all_generation_downline($id_member)
	{
		$sql = "
		with recursive tree (id, profile_picture, fullname, email, phone_number, id_upline) as (
			select	id,
					profile_picture,
					fullname,
					email,
					phone_number,
					id_upline
			from et_member
			where id_upline = '$id_member'
			union all
			select	p.id,
					p.profile_picture,
					p.fullname,
					p.email,
					p.phone_number,
					p.id_upline
			from et_member p
			inner join tree on p.id_upline = tree.id
			)
		select * from tree
		";

		return $this->db->query($sql);
	}
}
                        
/* End of file M_tree.php */
