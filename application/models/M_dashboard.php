<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{

	public function get_member_balance($id_member)
	{
		$this->db->select([
			'balance.total_invest_trade_manager',
			'balance.total_invest_crypto_asset',
			'balance.profit_paid',
			'balance.profit_unpaid',
			'balance.bonus',
			'balance.ratu',
			'balance.self_omset',
			'balance.downline_omset',
			'balance.total_omset',
		]);

		if ($id_member != null) {
			$this->db->where('balance.id_member', $id_member);
		}
		$this->db->from('member_balance as balance');
		$query = $this->db->get();

		return $query;
	}

	public function count_all_downline($id_member)
	{
		$this->db->select('count(*) as count_all_downline', false);
		$this->db->from('et_member AS member');
		$this->db->join('et_tree AS tree', 'tree.id_member = member.id', 'left');
		$this->db->where('member.is_active', 'yes');
		$this->db->where('member.deleted_at', null);
		$this->db->where(
			'tree.lft >',
			"(SELECT lft FROM et_tree AS self_tree WHERE self_tree.id_member = '$id_member ')",
			false
		);
		$this->db->where(
			'tree.rgt <',
			"(SELECT rgt FROM et_tree AS self_tree WHERE self_tree.id_member = '$id_member')",
			false
		);
		$query = $this->db->get();

		return $query;
	}

	public function get_latest_downline($id_member, $depth = null, $limit = null)
	{
		$this->db->select("
			member.id,
			member.user_id,
			member.profile_picture,
			member.fullname,
			member.email,
			member.phone_number,
			( SELECT upline.fullname FROM et_member AS upline WHERE upline.id = member.id_upline ) AS fullname_upline,
			( SELECT upline.user_id FROM et_member AS upline WHERE upline.id = member.id_upline ) AS user_id_upline,
			( tree.depth - ( SELECT self_tree.depth FROM et_tree AS self_tree WHERE self_tree.id_member = '$id_member' ) ) AS generation,
			balance.self_omset,
			balance.downline_omset,
			balance.total_omset,
			(
			SELECT
				count(*) 
			FROM
				et_member AS downline
				LEFT JOIN et_tree AS downline_tree ON downline_tree.id_member = downline.id 
			WHERE
				downline_tree.lft > tree.lft 
				AND downline_tree.rgt < tree.rgt 
				AND downline.is_active = 'yes' 
				AND downline.deleted_at IS NULL 
			) AS total_downline
		", false);
		$this->db->from('et_member AS member');
		$this->db->join('et_tree AS tree', 'tree.id_member = member.id', 'left');
		$this->db->join('et_member_balance AS balance', 'balance.id_member = member.id', 'left');
		$this->db->where('member.is_active', 'yes');
		$this->db->where('member.deleted_at', null);
		$this->db->where(
			'tree.lft >',
			"(SELECT lft FROM et_tree AS self_tree WHERE self_tree.id_member = '$id_member')",
			false
		);
		$this->db->where(
			'tree.rgt <',
			"(SELECT rgt FROM et_tree AS self_tree WHERE self_tree.id_member = '$id_member')",
			false
		);

		if ($depth != null) {
			$this->db->where('tree.depth', $depth);
		}

		$this->db->order_by('member.created_at', 'DESC');

		if ($limit != null) {
			$this->db->limit($limit);
		}

		$query = $this->db->get();

		$result = [];
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$id              = $key->id;
				$user_id         = $key->user_id;
				$profile_picture = ($key->profile_picture == NULL) ? base_url() . 'public/img/pp/default_avatar.svg' : base_url() . "public/img/pp/$key->profile_picture";
				$fullname        = $key->fullname;
				$email           = $key->email;
				$phone_number    = $key->phone_number;
				$fullname_upline = $key->fullname_upline;
				$user_id_upline  = $key->user_id_upline;
				$generation      = $key->generation;
				$self_omset      = check_float($key->self_omset);
				$downline_omset  = check_float($key->downline_omset);
				$total_omset     = check_float($key->total_omset);
				$total_downline  = check_float($key->total_downline);

				$nested = [
					'id'              => $id,
					'user_id'         => $user_id,
					'profile_picture' => $profile_picture,
					'fullname'        => $fullname,
					'email'           => $email,
					'phone_number'    => $phone_number,
					'fullname_upline' => $fullname_upline,
					'user_id_upline'  => $user_id_upline,
					'generation'      => $generation,
					'self_omset'      => $self_omset,
					'downline_omset'  => $downline_omset,
					'total_omset'     => $total_omset,
					'total_downline'  => $total_downline,
				];
				array_push($result, $nested);
			}
		}

		return $result;
	}
}
                        
/* End of file M_dashboard.php */
