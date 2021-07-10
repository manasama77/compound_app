<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_task_scheduler extends CI_Model
{

	public function get_recursive_downline_qualified_level($id_parent)
	{
		$query = "
		with recursive tree (id, fullname, id_upline) as (
			select	parent.id,
					parent.fullname,
					parent.id_upline
			from	et_member parent
			where	parent.id_upline = '$id_parent'

			union all

			select	downline.id,
					downline.fullname,
					downline.id_upline
			from	et_member downline
			inner join tree on downline.id_upline = tree.id
		)
		select * from tree;
		";
	}
}
                        
/* End of file M_task_scheduler.php */
