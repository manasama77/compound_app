<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_downline extends CI_Model
{

	public function get_max_depth($id_member)
	{
		$result = 0;

		$this->db->select([
			'lft',
			'rgt',
			'depth',
		]);
		$this->db->from('et_tree as tree');
		$this->db->where('tree.id_member', $id_member);
		$query_a = $this->db->get();
		$lft     = $query_a->row()->lft;
		$rgt     = $query_a->row()->rgt;
		$depth   = $query_a->row()->depth;

		$this->db->select('MAX(depth) AS max_depth', false);
		$this->db->from('member AS member');
		$this->db->join('tree AS tree', 'tree.id_member = member.id', 'left');
		$this->db->where('tree.lft >', $lft);
		$this->db->where('tree.rgt <', $rgt);
		$this->db->where('member.is_active', 'yes');
		$this->db->where('member.deleted_at', null);
		$query = $this->db->get();

		if ($query->row()->max_depth > 0) {
			$result = $query->row()->max_depth - $depth;
		}

		return (int)$result;
	}
}
                        
/* End of file M_downline.php */
