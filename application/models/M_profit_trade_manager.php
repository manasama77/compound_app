<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_profit_trade_manager extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('floating_helper');
	}


	public function get_list($id_member)
	{
		$arr = $this->db
			->select([
				'profit_trade_manager.created_at',
				'member.fullname',
				'member.email',
				'profit_trade_manager.invoice',
				'profit_trade_manager.package_name',
				'profit_trade_manager.profit',
				'profit_trade_manager.description',
			])
			->from('log_profit_trade_manager as profit_trade_manager')
			->join('member as member', 'member.id = profit_trade_manager.id_member')
			->where('profit_trade_manager.id_member', $id_member)
			->get();

		if ($arr->num_rows() == 0) {
			$return = [];
		} else {
			$return = [];
			foreach ($arr->result() as $key) {
				$created_at   = $key->created_at;
				$fullname     = $key->fullname;
				$email        = $key->email;
				$invoice      = $key->invoice;
				$package_name = $key->package_name;
				$profit       = check_float($key->profit);
				$description  = $key->description;

				$nested = [
					'created_at'   => $created_at,
					'fullname'     => $fullname,
					'email'        => $email,
					'invoice'      => $invoice,
					'package_name' => $package_name,
					'profit'       => $profit,
					'description'  => $description,
				];
				array_push($return, $nested);
			}
		}

		return $return;
	}
}
                        
/* End of file M_profit_trade_manager.php */
