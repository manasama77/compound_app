<?php

defined('BASEPATH') or exit('No direct script access allowed');

class InitController extends CI_Controller
{

	protected $current_datetime;

	public function __construct()
	{
		parent::__construct();
		$this->current_datetime = date('Y-m-d H: i: s');
	}

	public function init()
	{
		$email      = 'adam.pm77@gmail.com';
		$password   = password_hash(UYAH . 'adam', PASSWORD_BCRYPT);
		$name       = 'Adam PM';
		$role       = 'developer';
		$is_active  = 'yes';
		$cookies    = null;
		$ip_address = null;
		$user_agent = null;
		$created_at = $this->current_datetime;
		$updated_at = $this->current_datetime;
		$deleted_at = null;
		$created_by = null;
		$updated_by = null;
		$deleted_by = null;

		$data = [
			'email'      => $email,
			'password'   => $password,
			'name'       => $name,
			'role'       => $role,
			'is_active'  => $is_active,
			'cookies'    => $cookies,
			'ip_address' => $ip_address,
			'user_agent' => $user_agent,
			'created_at' => $created_at,
			'updated_at' => $updated_at,
			'deleted_at' => $deleted_at,
			'created_by' => $created_by,
			'updated_by' => $updated_by,
			'deleted_by' => $deleted_by,
		];

		$this->M_core->truncate('admin');
		$exec = $this->M_core->store('admin', $data);

		if (!$exec) {
			show_error('Failed Connect to Database', 500, 'Something wrong with your Database Config, please contact Web Developer');
			exit;
		}

		// $last_id = $this->db->insert_id();

		// $this->_send_otp($last_id, $email);

		echo "init admin developer success";
	}

	public function base64()
	{
		$key = 'bioner IPN';
		$result = base64_encode($key);

		echo $result;
	}

	public function country()
	{
		$this->M_core->truncate('country');

		$file = file_get_contents(FCPATH . 'public/country.json');

		$file = json_decode($file);

		foreach ($file as $key) {
			$code = $key->code;
			$name = $key->name;

			$data = [
				'code' => $code,
				'name' => $name,
			];
			$this->M_core->store('country', $data);
		}
	}
}
        
/* End of file  InitController.php */
