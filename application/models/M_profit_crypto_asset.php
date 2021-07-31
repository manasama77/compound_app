<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_profit_crypto_asset extends CI_Model
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
				'profit_crypto_asset.created_at',
				'member.fullname',
				'member.email',
				'profit_crypto_asset.invoice',
				'profit_crypto_asset.package_name',
				'profit_crypto_asset.profit',
				'profit_crypto_asset.description',
			])
			->from('log_profit_crypto_asset as profit_crypto_asset')
			->join('member as member', 'member.id = profit_crypto_asset.id_member')
			->where('profit_crypto_asset.id_member', $id_member)
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
                        
/* End of file M_profit_crypto_asset.php */
