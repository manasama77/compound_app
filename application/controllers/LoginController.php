<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{

	protected $datetime;
	protected $from;
	protected $from_alias;
	protected $ip_address;
	protected $user_agent;
	protected $csrf;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nested_set', null, 'Nested_set');
		$this->load->library('L_genuine_mail', null, 'genuine_mail');
		$this->load->helper(['cookie', 'string', 'otp_helper', 'domain_helper', 'time_helper']);
		$this->load->model('M_login');
		$this->load->model('M_log_send_email_member');

		$this->datetime   = date('Y-m-d H:i:s');
		$this->from       = EMAIL_ADMIN;
		$this->from_alias = EMAIL_ALIAS;
		$this->ip_address = $this->input->ip_address();
		$this->user_agent = $this->input->user_agent();

		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];

		$this->Nested_set->setControlParams('tree', 'lft', 'rgt', 'id_member', 'id_upline', 'email');
	}


	public function index()
	{
		$cookies = get_cookie(KUE);

		if ($cookies != NULL) {
			$this->_check_cookies($cookies);
		} else {
			$check_session = $this->_check_session();
			if ($check_session === true) {
				redirect('dashboard');
				exit;
			}

			$data = [
				'title' => APP_NAME . ' | Member Sign In',
				'csrf'  => $this->csrf,
			];
			return $this->load->view('login', $data, FALSE);
		}
	}

	public function auth()
	{
		$email    = $this->security->xss_clean($this->input->post('email'));
		$password = $this->security->xss_clean($this->input->post('password'));
		$remember = $this->security->xss_clean($this->input->post('remember'));

		$check = $this->genuine_mail->check($email);
		if ($check !== TRUE) {
			return show_error($check, 404, "Terjadi Kesalahan...");
		}

		$where = [
			'email'      => $email,
			'deleted_at' => null,
		];
		$arr_user = $this->M_core->get('member', 'id, password, fullname, user_id, phone_number, id_upline, is_active, profile_picture, activation_code, created_at, updated_at', $where, null, null, 1);

		if ($arr_user->num_rows() == 0) {
			$this->session->set_flashdata('email_value', $email);
			$this->session->set_flashdata('email_state', 'is-invalid');
			$this->session->set_flashdata('email_state_message', 'Email Not Found');
			redirect('login');
		} elseif ($arr_user->row()->is_active == 'no') {
			if ($arr_user->row()->activation_code == null) {
				$msg = 'Akun Nonaktif';
			} else {
				$msg = 'Akun belum aktif, silahkan aktivasi terlebih dahulu. Untuk melakukan aktivasi silahkan cek email kamu';
				$check = $this->_send_email_activation($arr_user->row()->id, $email);
			}
			$this->session->set_flashdata('email_value', $email);
			$this->session->set_flashdata('email_state', 'is-invalid');
			$this->session->set_flashdata('email_state_message', $msg);
			redirect('login');
		} elseif (password_verify(UYAH . $password, $arr_user->row()->password) == false) {
			$this->session->set_flashdata('email_value', $email);
			$this->session->set_flashdata('email_state', 'is-valid');
			$this->session->set_flashdata('email_state_message', null);
			$this->session->set_flashdata('password_state', 'is-invalid');
			$this->session->set_flashdata('password_state_message', 'Password wrong!');
			redirect('login');
		} else {
			$id = $arr_user->row()->id;

			if ($remember) {
				$this->_set_cookie();
			}

			$this->session->set_userdata([
				SESI . 'id'    => $id,
				SESI . 'email' => $email,
			]);

			$check = $this->_send_otp($id, $email);

			if ($check === true) {
				redirect('otp');
			}

			return show_error('Sistem gagal mengirimkan email OTP, silahkan coba kembali', 500, 'Terjadi Kesalahan...');
		}
	}

	public function otp()
	{
		if (!$this->session->userdata(SESI . 'email')) {
			redirect('logout');
			exit;
		}

		$data = [
			'title' => APP_NAME . ' | OTP',
			'csrf'  => $this->csrf,
		];
		return $this->load->view('otp_login', $data, FALSE);
	}

	public function otp_auth()
	{
		$code  = 500;
		$email = $this->session->userdata(SESI . 'email');
		$otp   = $this->input->post('otp');

		$where = [
			'email'      => $email,
			'otp'        => $otp,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member', '*', $where);

		if ($arr->num_rows() == 1) {
			$code            = 200;
			$id              = $arr->row()->id;
			$fullname        = $arr->row()->fullname;
			$email           = $arr->row()->email;
			$phone_number    = $arr->row()->phone_number;
			$profile_picture = $arr->row()->profile_picture;
			$cookies         = $arr->row()->cookies;
			$is_active       = $arr->row()->is_active;
			$user_id         = $arr->row()->user_id;

			if (is_file(FCPATH . $profile_picture)) {
				$pp = base_url() . 'public/img/pp/' . $profile_picture;
			} else {
				$pp = base_url() . "public/img/pp/default_avatar.svg";
			}

			$this->_set_session($id, $fullname, $email, $phone_number, $cookies, $is_active, $pp, $user_id);
		}

		echo json_encode(['code' => $code]);
	}

	public function otp_resend()
	{
		$email = ($this->session->userdata(SESI . 'email')) ? $this->session->userdata(SESI . 'email') : $this->input->post('email');

		if ($this->session->userdata(SESI . 'id')) {
			$id = $this->session->userdata(SESI . 'id');
		} else {
			$where = [
				'email'      => $email,
				'is_active'  => 'yes',
				'deleted_at' => null,
			];
			$arr = $this->M_core->get('member', 'id', $where);
			$id = $arr->row()->id;
		}

		$status = $this->_send_otp($id, $email);

		echo json_encode([
			'code'   => 200,
			'email'  => $email,
			'status' => $status,
		]);
	}

	public function logout(): void
	{
		delete_cookie(KUE);
		$data = [
			SESI . 'id',
			SESI . 'fullname',
			SESI . 'email',
			SESI . 'phone_number',
			SESI . 'is_active',
			SESI . 'profile_picture',
			SESI . 'user_id',
		];
		$this->session->unset_userdata($data);
		$this->session->set_flashdata('logout', 'Logout Success');
		redirect('login');
	}

	protected function _set_cookie(): string
	{
		$key_cookies = random_string('alnum', 64);
		set_cookie(KUE, $key_cookies, 86400);
		return $key_cookies;
	}

	protected function _set_session($id, $fullname, $email, $phone_number, $cookies, $is_active, $profile_picture, $user_id): void
	{
		$data = [
			SESI . 'id'              => $id,
			SESI . 'fullname'        => $fullname,
			SESI . 'email'           => $email,
			SESI . 'phone_number'    => $phone_number,
			SESI . 'is_active'       => $is_active,
			SESI . 'profile_picture' => $profile_picture,
			SESI . 'user_id'         => $user_id,
		];
		$this->session->set_userdata($data);

		$data = [
			'cookies'    => $cookies,
			'ip_address' => $this->ip_address,
			'user_agent' => $this->user_agent,
			'updated_at' => $this->datetime,
		];
		$where = ['id' => $id];
		$this->M_core->update('member', $data, $where);
	}

	protected function _check_cookies($cookies): void
	{
		$where_cookies = [
			'cookies'    => $cookies,
			'is_active'  => 'yes',
			'ip_address' => $this->ip_address,
			'user_agent' => $this->user_agent,
			'deleted_at' => null,
		];
		$check_cookies = $this->M_core->get('member', '*', $where_cookies);

		if ($check_cookies->num_rows() == 1) {
			$id              = $check_cookies->row()->id;
			$fullname        = $check_cookies->row()->fullname;
			$email           = $check_cookies->row()->email;
			$phone_number    = $check_cookies->row()->phone_number;
			$is_active       = $check_cookies->row()->is_active;
			$profile_picture = $check_cookies->row()->profile_picture;
			$user_id         = $check_cookies->row()->user_id;

			if (is_file(FCPATH . $profile_picture)) {
				$pp = base_url() . 'public/img/pp/' . $profile_picture;
			} else {
				$pp = base_url() . "public/img/pp/default_avatar.svg";
			}

			$this->_set_session($id, $fullname, $email, $phone_number, $cookies, $is_active, $pp, $user_id);
			$this->session->set_flashdata('first_login', 'Login Berhasil, Jangan Pernah Sharing Akun dengan yang lain');
			redirect('dashboard');
		} else {
			delete_cookie(KUE);
			redirect(site_url('logout'));
		}
	}

	protected function _check_session()
	{
		$id    = $this->session->userdata(SESI . 'id');
		$email = $this->session->userdata(SESI . 'email');

		if (!$id && !$email) {
			return false;
		}

		$where = [
			'id'         => $id,
			'email'      => $email,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];

		$count = $this->M_core->count('member', $where);

		if ($count == 0) {
			return false;
		}

		return true;
	}

	protected function _send_otp($id, $to): bool
	{
		$subject = APP_NAME . " | OTP (One Time Password)";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$otp = Generate_otp();

		$data['otp'] = $otp;
		$message = $this->load->view('emails/otp_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_core->update('member', ['otp' => $otp], ['id' => $id]);
		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		if ($is_success == "yes") {
			return true;
		}

		return false;
	}

	public function activate($email, $activation_code)
	{
		$email = urldecode($email);

		$where = [
			'email'      => $email,
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member', 'id, is_active, activation_code', $where);

		if ($arr->num_rows() == 0) {
			return show_error('Email / Akun tidak ditemukan', 404, 'Terjadi Kesalahan!');
		}

		if ($arr->row()->is_active == "yes") {
			return show_error('Akun Sudah Aktif<br /><a href="' . site_url('login') . '" class="btn btn-primary mt-3">Ke Halaman Login</a>', 200, 'Terjadi Kesalahan!');
		}

		if ($arr->row()->activation_code != $activation_code || $arr->row()->activation_code == null) {
			$id = $arr->row()->id;

			$data = [
				'title'   => APP_NAME . ' | Aktivasi Error',
				'id'      => $id,
				'email'   => $email,
				'type'    => 'activation_not_same',
				'message' => 'Kode Aktivasi Sudah Expired',
			];
			return $this->load->view('activation_account_error', $data);
		}

		$data = [
			'is_active'       => 'yes',
			'activation_code' => null,
			'updated_at'      => $this->datetime,
		];
		$exec = $this->M_core->update('member', $data, $where);

		if (!$exec) {
			return show_error('Aktivasi Akun Gagal, silahkan coba kembali', 500, 'Terjadi Kesalahan!');
		}

		return $this->load->view('activation_account_success');
	}

	public function registration($id, $hash)
	{
		$this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|min_length[3]|max_length[100]', [
			'required'  => '%s Wajib Diisi',
			'min_length' => '%s Minimal 3 Karakter',
			'max_length' => '%s Maksimal 100 Karakter',
		]);
		$this->form_validation->set_rules('phone_number', 'No Telepon', 'required|min_length[3]|max_length[20]', [
			'required'  => '%s Wajib Diisi',
			'min_length' => '%s Minimal 3 Karakter',
			'max_length' => '%s Maksimal 20 Karakter',
		]);
		$this->form_validation->set_rules('user_id', 'User ID', 'required|min_length[8]|max_length[8]|callback_check_user_id', [
			'required'  => '%s Wajib Diisi',
			'min_length' => '%s Harus 8 Karakter',
			'max_length' => '%s Harus 8 Karakter',
			'is_unique' => 'KTP %s Telah Terdaftar.'
		]);
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[3]|max_length[100]|is_unique[member.email]', [
			'required'  => '%s Wajib Diisi',
			'min_length' => '%s Minimal 3 Karakter',
			'max_length' => '%s Maksimal 100 Karakter',
			'is_unique' => 'Email %s Telah Terdaftar.'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[16]', [
			'required'  => '%s Wajib Diisi',
			'min_length' => '%s Minimal 4 Karakter',
			'max_length' => '%s Maksimal 16 Karakter',
		]);
		$this->form_validation->set_rules('verify_password', 'Verifikasi Password', 'required|min_length[4]|max_length[16]|matches[password]', [
			'required'  => '%s Wajib Diisi',
			'min_length' => '%s Minimal 4 Karakter',
			'max_length' => '%s Maksimal 16 Karakter',
			'matches'   => '%s Tidak sama dengan Password'
		]);

		if ($this->form_validation->run() == FALSE) {
			$id     = base64_decode($id);
			$hash_b = hash_hmac('sha1', $id, UYAH);

			if ($hash != $hash_b) {
				return show_error("Link Referral Salah", 404);
			}

			$where = [
				'id'         => $id,
				'is_active'  => 'yes',
				'deleted_at' => null,
			];
			$arr = $this->M_core->get('member', 'email, fullname, created_at', $where);

			if ($arr->num_rows() == 0) {
				return show_error("Link Referral Salah", 404);
			}

			$data = [
				'title'        => APP_NAME . ' | Registrasi Member',
				'id'           => $id,
				'email'        => $arr->row()->email,
				'fullname'     => $arr->row()->fullname,
				'member_since' => time_ago(new DateTime($arr->row()->created_at)),
				'arr'          => $arr,
				'csrf'         => $this->csrf,
			];
			return $this->load->view('registration', $data, FALSE);
		} else {
			$this->db->trans_begin();

			$id             = base64_decode($id);
			$fullname       = $this->input->post('fullname');
			$phone_number   = $this->input->post('phone_number');
			$user_id        = strtolower($this->input->post('user_id'));
			$email          = $this->input->post('email');
			$password       = $this->input->post('password');

			$check = $this->genuine_mail->check($email);
			if ($check !== TRUE) {
				return show_error($check, 404, "Terjadi Kesalahan...");
			}

			$data = [
				'email'                => $email,
				'password'             => password_hash(UYAH . $password, PASSWORD_BCRYPT),
				'user_id'              => $user_id,
				'id_card_number'       => null,
				'fullname'             => $fullname,
				'phone_number'         => $phone_number,
				'address'              => null,
				'postal_code'          => null,
				'id_bank'              => null,
				'no_rekening'          => null,
				'id_upline'            => $id,
				'country_code'         => null,
				'profile_picture'      => null,
				'otp'                  => null,
				'is_active'            => 'no',
				'activation_code'      => null,
				'forgot_password_code' => null,
				'is_founder'           => 'no',
				'is_kyc'               => 'no',
				'cookies'              => null,
				'ip_address'           => null,
				'user_agent'           => null,
				'foto_ktp'             => null,
				'foto_pegang_ktp'      => null,
				'created_at'           => $this->datetime,
				'updated_at'           => $this->datetime,
				'deleted_at'           => null,
			];

			$exec = $this->M_core->store_uuid('member', $data);

			if (!$exec) {
				$this->db->trans_rollback();
				return show_error('Tidak Terhubung Dengan Database, Silahkan cek koneksi kamu!', 500, 'Terjadi Kesalahan...');
			}

			$where     = ['email' => $email];
			$arr       = $this->M_core->get('member', 'id', $where);
			$id_member = $arr->row()->id;

			$data                         =  [
				'id_member'                  => $id_member,
				'total_invest_trade_manager' => 0,
				'count_trade_manager'        => 0,
				'total_invest_crypto_asset'  => 0,
				'count_crypto_asset'         => 0,
				'profit_paid'                => 0,
				'profit_unpaid'              => 0,
				'bonus'                      => 0,
				'ratu'                       => 0,
				'self_omset'                 => 0,
				'downline_omset'             => 0,
				'total_omset'                => 0,
				'created_at'                 => $this->datetime,
				'updated_at'                 => $this->datetime,
				'deleted_at'                 => null,
			];

			$exec = $this->M_core->store_uuid('member_balance', $data);

			if (!$exec) {
				$this->db->trans_rollback();
				return show_error('Tidak Terhubung Dengan Database, Silahkan cek koneksi kamu!', 500, 'Terjadi Kesalahan...');
			}

			$add_tree_downline = $this->_add_tree_downline($id_member, $email, $id);

			if ($this->Nested_set->checkIsValidNode($add_tree_downline) == FALSE) {
				$this->db->trans_rollback();
				echo json_encode(['code' => '500', 'msg' => 'Tidak Terhubung Dengan Database, Silahkan cek koneksi kamu!']);
				exit;
			}

			$data_reward = [
				'id_member'     => $id_member,
				'reward_1'      => 'no',
				'reward_1_date' => null,
				'reward_1_done' => 'no',
				'reward_2'      => 'no',
				'reward_2_date' => null,
				'reward_2_done' => 'no',
				'reward_3'      => 'no',
				'reward_3_date' => null,
				'reward_3_done' => 'no',
				'reward_4'      => 'no',
				'reward_4_date' => null,
				'reward_4_done' => 'no',
				'reward_5'      => 'no',
				'reward_5_date' => null,
				'reward_5_done' => 'no',
			];
			$exec = $this->M_core->store('member_reward', $data_reward);

			if (!$exec) {
				$this->db->trans_rollback();
				return show_error('Tidak Terhubung Dengan Database, Silahkan cek koneksi kamu!', 500, 'Terjadi Kesalahan...');
			}

			$check = $this->_send_email_activation($id_member, $email);

			if ($check == "no") {
				$this->db->trans_rollback();
				return show_error('Gagal Mengirimkan Aktivasi Email, Silahkan Pastikan Email <mark>Email Address</mark> Benar', 500, 'Terjadi Kesalahan...');
			}

			$this->db->trans_commit();
			redirect('registration/success');
		}
	}

	protected function _add_tree_downline($id_member, $email, $id_upline)
	{
		$where_upline = ['id_member' => $id_upline];
		$data_upline  = $this->Nested_set->getNodeWhere($where_upline);

		$data_downline = [
			'id_member' => $id_member,
			'email'     => $email,
			'depth'     => $data_upline['depth'] + 1,
		];

		$has_downline = $this->Nested_set->checkNodeHasChildren($data_upline);

		if ($has_downline === true) {
			$exec = $this->Nested_set->appendNewChild($data_upline, $data_downline);
		} else {
			$exec = $this->Nested_set->insertNewChild($data_upline, $data_downline);
		}

		return $exec;
	}

	protected function _send_email_activation($id, $to)
	{
		$subject = APP_NAME . " | Account Activation";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$activation_code         = hash('sha1', UYAH . $to . $this->datetime);
		$data['email']           = $to;
		$data['activation_code'] = $activation_code;

		$message = $this->load->view('emails/activation_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_core->update('member', ['activation_code' => $activation_code], ['id' => $id]);
		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		return $is_success;
	}

	public function registration_success()
	{
		$data = ['title' => APP_NAME . " | Registration Success"];
		$this->load->view('registration_success', $data);
	}

	public function activation_resend()
	{
		$code  = 200;
		$id    = $this->input->post('id');
		$email = $this->input->post('email');

		$check = $this->_send_email_activation($id, $email);

		if ($check == "no") {
			$code = 500;
		}

		echo json_encode(['code' => $code, 'check' => $check]);
	}

	public function forgot_password()
	{
		$data = [
			'title' => APP_NAME . ' | Lupa Password',
			'csrf'  => $this->csrf,
		];
		$this->load->view('forgot_password', $data);
	}

	public function send_forgot_password()
	{
		$code  = 200;
		$email = $this->input->post('email');

		$arr = $this->M_core->get('member', '*', ['email' => $email]);

		if ($arr->num_rows() == 0) {
			echo json_encode(['code' => 404]);
			exit;
		}

		$id = $arr->row()->id;

		$check = $this->_send_email_forgot_password($id, $email);

		if ($check == "no") {
			$code = 500;
		}

		echo json_encode(['code' => $code]);
	}

	protected function _send_email_forgot_password($id, $to)
	{
		$subject = APP_NAME . " | Lupa Password";
		$message = "";

		$this->email->set_newline("\r\n");
		$this->email->from($this->from, $this->from_alias);
		$this->email->to($to);
		$this->email->subject($subject);

		$forgot_password_code         = hash('sha1', UYAH . $to . $this->datetime);
		$data['email']                = $to;
		$data['email_decode']         = base64_encode(UYAH . $to);
		$data['forgot_password_code'] = $forgot_password_code;

		$message = $this->load->view('emails/forgot_password_template', $data, TRUE);

		$this->email->message($message);

		$is_success = ($this->email->send()) ? 'yes' : 'no';

		$this->M_core->update('member', ['forgot_password_code' => $forgot_password_code], ['id' => $id]);
		$this->M_log_send_email_member->write_log($to, $subject, $message, $is_success);

		return $is_success;
	}

	public function reset_password($email, $forgot_password_code)
	{
		$email_decode = urldecode(str_replace(UYAH, "", base64_decode($email)));

		if (!Is_base64($email_decode)) {
			return show_error('Kode Reset Password Salah. Silahkan coba kembali fitur <a href="' . site_url('forgot_password') . '"><mark>Lupa Password</mark></a> ', 403, '[403] - Akses Dibatasi');
		}

		$where = [
			'email'      => $email_decode,
			'is_active'  => 'yes',
			'deleted_at' => null,
		];
		$arr = $this->M_core->get('member', 'id, forgot_password_code', $where);

		if ($arr->num_rows() == 0 || $arr->row()->forgot_password_code != $forgot_password_code) {
			return show_error('Reset Password Salah', 404, 'Terjadi Kesalahan!');
		}

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('verify_password', 'Verify Password', 'required|matches[password]');

		if ($this->form_validation->run() === false) {

			$data = [
				'title' => APP_NAME . ' | Reset Password',
				'email' => $email_decode,
				'csrf'  => $this->csrf,
			];
			return $this->load->view('reset_password', $data);
		} else {
			$password = password_hash(UYAH . $this->input->post('password'), PASSWORD_BCRYPT);

			$data = [
				'password'             => $password,
				'forgot_password_code' => null,
				'updated_at'           => $this->datetime,
			];

			$where = ['email' => $email_decode];

			$exec = $this->M_core->update('member', $data, $where);

			if (!$exec) {
				return show_error('Reset password gagal, Permasalahan Koneksi. Silahkan Coba Kembali', 500, 'Terjadi Kesalahan!');
			}

			$data = [
				'title' => APP_NAME . ' | Reset Password Berhasil',
			];
			return $this->load->view('reset_password_success', $data);
		}
	}

	public function check_user_id($user_id)
	{
		$id_member = base64_decode($this->uri->segment(2));
		$count = $this->M_login->count_user_id($user_id, $id_member);

		if ($count == 0) {
			return TRUE;
		}

		$this->form_validation->set_message('check_user_id', "User ID $user_id Telah Terdaftar, silahkan gunakan User ID lain");
		return FALSE;
	}
}
        
/* End of file  LoginController.php */
