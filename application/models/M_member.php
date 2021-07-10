<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_member extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nested_set', null, 'Nested_set');
		$this->Nested_set->setControlParams('tree', 'lft', 'rgt', 'id_member', 'id_upline', 'email');
	}


	public function get_data_member($id_member = null)
	{
		$this->db->select([
			'et_member.id',
			'et_member.email',
			'et_member.id_card_number',
			'et_member.fullname',
			'et_member.phone_number',
			'et_member.id_upline',
			'et_member.country_code',
			'et_member.profile_picture',
			'et_member.is_active',
			'et_member.ip_address',
			'et_member.user_agent',
			'et_member.created_at',
			'et_member_balance.total_invest_trade_manager',
			'et_member_balance.total_invest_crypto_asset',
			'et_member_balance.profit',
			'et_member_balance.bonus',
			'et_member_balance.total_omset',
			'et_tree.lft',
			'et_tree.rgt',
			'et_tree.depth',
			'upline.fullname as fullname_upline',
			'upline.email as email_upline',
		]);
		$this->db->from('member');
		$this->db->join('et_member_balance', 'et_member_balance.id_member = et_member.id', 'left');
		$this->db->join('et_tree', 'et_tree.id_member = et_member.id', 'left');
		$this->db->join('et_member as upline', 'upline.id = et_member.id_upline', 'left');

		if ($id_member != null) {
			$this->db->where('member.id', $id_member);
		}

		$this->db->where('member.deleted_at', null);
		$this->db->order_by('member.id', 'desc');
		return $this->db->get();
	}

	public function get_data_downline($id_upline = null)
	{
		$this->db->select([
			'et_member.id',
			'et_member.email',
			'et_member.id_card_number',
			'et_member.fullname',
			'et_member.phone_number',
			'et_member.id_upline',
			'et_member.country_code',
			'et_member.profile_picture',
			'et_member.is_active',
			'et_member.ip_address',
			'et_member.user_agent',
			'et_member_balance.total_invest_trade_manager',
			'et_member_balance.total_invest_crypto_asset',
		]);
		$this->db->from('member');
		$this->db->join('et_member_balance', 'et_member_balance.id_member = et_member.id', 'left');

		if ($id_upline != null) {
			$this->db->where('member.id_upline', $id_upline);
		}

		$this->db->where('member.is_active', 'yes');
		$this->db->where('member.deleted_at', null);
		$this->db->order_by('member.id', 'desc');
		return $this->db->get();
	}

	public function tree_get_downline($id_member, $limit = null)
	{
		$arr1         = $this->db->select(['lft', 'rgt', 'depth'])->where('id_member', $id_member)->get('tree');
		$member_lft   = $arr1->row()->lft;
		$member_rgt   = $arr1->row()->rgt;
		$member_depth = $arr1->row()->depth;

		$where_arr2 = [
			'et_tree.lft >'        => $member_lft,
			'et_tree.rgt <'        => $member_rgt,
			'et_tree.depth >'      => $member_depth,
			'et_member.deleted_at' => null,
		];

		if ($limit != null) {
			$this->db->limit($limit);
		}

		$arr2 = $this->db
			->select([
				'et_member.id as id_downline',

				'et_member.profile_picture as profile_picture_downline',
				'et_member.fullname as fullname_downline',
				'et_member.email as email_downline',
				'et_member.phone_number as phone_number_downline',
				'et_member.created_at as created_at_downline',
				'et_tree.depth as generation_downline',

				'upline.profile_picture as profile_picture_upline',
				'upline.fullname as fullname_upline',
				'upline.email as email_upline',
				'upline.phone_number as phone_number_upline',
			])
			->from('tree')
			->join('et_member', 'et_member.id = et_tree.id_member', 'left')
			->join('et_member as upline', 'upline.id = et_member.id_upline', 'left')
			->where($where_arr2)
			->order_by('et_member.created_at', 'desc')
			->get();

		if ($arr2->num_rows() == 0) {
			return [];
		}

		$arr_data = [];
		foreach ($arr2->result() as $key) {
			$id_downline              = $key->id_downline;
			$profile_picture_downline = $this->_set_pp($key->profile_picture_downline);
			$fullname_downline        = $key->fullname_downline;
			$email_downline           = $key->email_downline;
			$phone_number_downline    = $key->phone_number_downline;
			$created_at_downline      = $key->created_at_downline;
			$generation_downline      = $key->generation_downline - $member_depth;

			$profile_picture_upline = $this->_set_pp($key->profile_picture_upline);
			$fullname_upline        = $key->fullname_upline;
			$email_upline           = $key->email_upline;
			$phone_number_upline    = $key->phone_number_upline;

			$nested = [
				'id_downline' => $id_downline,

				'profile_picture_downline' => $profile_picture_downline,
				'fullname_downline'        => $fullname_downline,
				'email_downline'           => $email_downline,
				'phone_number_downline'    => $phone_number_downline,
				'created_at_downline'      => $created_at_downline,
				'generation_downline'      => $generation_downline,

				'profile_picture_upline' => $profile_picture_upline,
				'fullname_upline'        => $fullname_upline,
				'email_upline'           => $email_upline,
				'phone_number_upline'    => $phone_number_upline,
			];

			array_push($arr_data, $nested);
		}

		return $arr_data;
	}

	public function _set_pp($pp)
	{
		if ($pp == NULL) {
			$pp = base_url('public/img/pp/default_avatar.svg');
		} else {
			$pp = (is_file(FCPATH . 'public/img/pp/default_avatar.svg')) ? base_url('public/img/pp/default_avatar.svg') : $pp;
		}

		return $pp;
	}

	public function get_data_member_reward($id_member = null, $lft = null, $rgt = null, $depth = null, $total_omset = null, $limit = null, $id_exclude = null)
	{
		$this->db->select([
			'member.id',
			'member.fullname',
			'member.email',
			'tree.lft',
			'tree.rgt',
			'tree.depth',
			'balance.total_omset'
		]);
		$this->db->from('et_member AS member');
		$this->db->join('et_member_reward AS reward', 'reward.id_member = member.id', 'left');
		$this->db->join('et_tree AS tree', 'tree.id_member = member.id', 'left');
		$this->db->join('et_member_balance AS balance', 'balance.id_member = member.id', 'left');
		$this->db->where('member.deleted_at', null);
		$this->db->where('member.is_active', 'yes');
		$this->db->where('reward.reward_1', 'no');

		if ($id_member != null) {
			$this->db->where('member.id', $id_member);
		} else {
			if ($lft != null && $rgt != null) {
				$this->db->where('tree.lft >', $lft);
				$this->db->where('tree.rgt <', $rgt);

				if ($depth != null) {
					$this->db->where('tree.depth', $depth);
				}
			}
		}

		if ($total_omset != null) {
			$this->db->where('balance.total_omset >=', $total_omset);
		}

		if ($limit != null) {
			$this->db->limit($limit);
		}

		if ($id_exclude != null) {
			$this->db->where('tree.id_member !=', $id_exclude);
		}

		$this->db->order_by('balance.total_omset', 'desc');
		$query = $this->db->get();

		return $query;
	}
}
                        
/* End of file M_member.php */
