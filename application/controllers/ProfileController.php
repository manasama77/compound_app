<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProfileController extends CI_Controller
{
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_member', null, 'template');
		$this->load->helper('Time_helper');


		$this->datetime = date('Y-m-d H:i:s');
	}


	public function index()
	{
		$data = [
			'title'      => APP_NAME . ' | Profile',
			'content'    => 'profile/main',
			'vitamin_js' => 'profile/main_js',
		];

		$where = [
			'email' => $this->session->userdata(SESI . 'email')
		];
		$arr = $this->M_core->get('member', '*', $where);
		$country_code = $arr->row()->country_code;
		$is_founder   = $arr->row()->is_founder;
		$created_at   = $arr->row()->created_at;

		$time_ago = time_ago(new DateTime($created_at));

		$arr_country = $this->M_core->get('country', '*');

		$country_name = null;
		if ($country_code != NULL) {
			$country_name = $this->M_core->get('country', 'name', ['code' => $country_code])->row()->name;
		}

		$data['country_name'] = $country_name;
		$data['is_founder']   = $is_founder;
		$data['arr']          = $arr;
		$data['member_since'] = $time_ago;
		$data['arr_country']  = $arr_country;


		$this->template->render($data);
	}

	public function setting_update()
	{
		$code         = 500;
		$email        = $this->session->userdata(SESI . 'email');
		$fullname     = $this->input->post('fullname');
		$phone_number = $this->input->post('phone_number');
		$country_code = $this->input->post('country_code');

		$data  = [
			'fullname'     => $fullname,
			'phone_number' => $phone_number,
			'country_code' => $country_code,
		];
		$where = ['email' => $email];
		$exec  = $this->M_core->update('member', $data, $where);

		$this->session->set_userdata(SESI . 'fullname', $fullname);
		$this->session->set_userdata(SESI . 'phone_number', $phone_number);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function check_current_password()
	{
		$email            = $this->session->userdata(SESI . 'email');
		$current_password = $this->input->post('current_password');
		$code             = 500;

		$where = [
			'email'      => $email,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];
		$exec = $this->M_core->get('member', 'password', $where);

		if ($exec) {
			if ($exec->num_rows() == 1) {
				if (password_verify(UYAH . $current_password, $exec->row()->password)) {
					$code = 200;
				} else {
					$code = 404;
				}
			}
		}

		echo json_encode(['code' => $code]);
	}

	public function update_password()
	{
		$code         = 500;
		$email        = $this->session->userdata(SESI . 'email');
		$new_password = $this->input->post('new_password');

		$data = [
			'password'   => password_hash(UYAH . $new_password, PASSWORD_BCRYPT),
			'updated_at' => $this->datetime
		];

		$where = ['email' => $email];

		$exec = $this->M_core->update('member', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function reset_password()
	{
		$code           = 500;
		$id             = $this->input->post('id');
		$password_reset = $this->input->post('password_reset');

		$data = [
			'password'   => password_hash(UYAH . $password_reset, PASSWORD_BCRYPT),
			'updated_at' => $this->datetime
		];

		$where = ['id' => $id];

		$exec = $this->M_core->update('member', $data, $where);

		if ($exec) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}
}
        
/* End of file  ProfileController.php */
