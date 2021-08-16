<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProfileController extends CI_Controller
{
	protected $datetime;
	protected $csrf;
	protected $id_member;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_member', null, 'template');
		$this->load->helper('Time_helper');

		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->csrf = [
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		];
	}


	public function index()
	{
		$data = [
			'title'      => APP_NAME . ' | Profil',
			'content'    => 'profile/main',
			'vitamin_js' => 'profile/main_js',
			'csrf'       => $this->csrf,
		];

		$where = [
			'email' => $this->session->userdata(SESI . 'email')
		];
		$arr          = $this->M_core->get('member', '*', $where);
		$id_upline    = $arr->row()->id_upline;
		$country_code = $arr->row()->country_code;
		$is_founder   = $arr->row()->is_founder;
		$created_at   = $arr->row()->created_at;
		$user_id      = $arr->row()->user_id;
		$is_kyc       = $arr->row()->is_kyc;

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
		$data['user_id']      = $user_id;
		$data['is_kyc']       = $is_kyc;

		$where_upline = [
			'id' => $id_upline
		];
		$data['arr_upline'] = $this->M_core->get('member', 'fullname, email', $where_upline);

		$data['arr_bank'] = $this->M_core->get('bank', '*', null);
		$this->template->render($data);
	}

	public function setting_update()
	{
		$code         = 500;
		$email        = $this->session->userdata(SESI . 'email');
		$phone_number = $this->input->post('phone_number');
		$address      = $this->input->post('address');
		$postal_code  = $this->input->post('postal_code');
		$id_bank      = $this->input->post('id_bank');
		$no_rekening  = $this->input->post('no_rekening');
		$country_code = $this->input->post('country_code');

		$data  = [
			'phone_number' => $phone_number,
			'address'      => $address,
			'postal_code'  => $postal_code,
			'id_bank'      => $id_bank,
			'no_rekening'  => $no_rekening,
			'country_code' => $country_code,
		];
		$where = ['email' => $email];
		$exec  = $this->M_core->update('member', $data, $where);

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

	public function kyc()
	{
		$arr_negara = $this->M_core->get('country', '*', null);
		$arr_bank   = $this->M_core->get('bank', '*', null);
		$arr_member = $this->M_core->get('member', '*', ['id' => $this->id_member]);

		$data = [
			'title'      => APP_NAME . ' | KYC',
			'content'    => 'profile/kyc',
			'vitamin_js' => 'profile/kyc_js',
			'csrf'       => $this->csrf,
			'arr_negara' => $arr_negara,
			'arr_bank'   => $arr_bank,
			'arr_member' => $arr_member,
		];
		$this->template->render($data);
	}

	public function cek_ktp()
	{
		$id_card_number = $this->input->get('id_card_number');

		$where = [
			'id'             => $this->id_member,
			'id_card_number' => $id_card_number,
		];
		$count = $this->M_core->count('member', $where);

		$code = 500;
		if ($count == 0) {
			$code = 200;
		}

		echo json_encode(['code' => $code]);
	}

	public function kyc_auth()
	{
		$this->db->trans_begin();

		$config['upload_path']            = './protected/ktp/';
		$config['allowed_types']          = 'gif|jpg|png';
		$config['file_name']              = "KTP_" . $this->session->userdata(SESI . 'user_id');
		$config['file_ext_tolower']       = true;
		$config['overwrite']              = false;
		$config['max_size']               = 5120;
		$config['max_filename_increment'] = 10000;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('foto_ktp')) {
			$error = $this->upload->display_errors();
			echo json_encode([
				'code' => 500,
				'msg'  => $error,
			]);
			exit;
		}

		$file_foto_ktp = $this->upload->data()['file_name'];

		$config2['upload_path']            = './protected/member/';
		$config2['allowed_types']          = 'gif|jpg|png';
		$config2['file_name']              = "MEMBER_" . $this->session->userdata(SESI . 'user_id');
		$config2['file_ext_tolower']       = true;
		$config2['overwrite']              = false;
		$config2['max_size']               = 5120;
		$config2['max_filename_increment'] = 10000;

		$this->upload->initialize($config2);

		$this->load->library('upload', $config2);
		if (!$this->upload->do_upload('foto_pegang_ktp')) {
			$error = $this->upload->display_errors();
			echo json_encode([
				'code' => 500,
				'msg'  => $error,
			]);
			exit;
		}

		$file_foto_pegang_ktp = $this->upload->data()['file_name'];

		$fullname        = $this->input->post('fullname');
		$id_card_number  = $this->input->post('id_card_number');
		$country_code    = $this->input->post('country_code');
		$address         = $this->input->post('address');
		$postal_code     = $this->input->post('postal_code');
		$id_bank         = $this->input->post('id_bank');
		$no_rekening     = $this->input->post('no_rekening');
		$foto_ktp        = $file_foto_ktp;
		$foto_pegang_ktp = $file_foto_pegang_ktp;


		$data = [
			'fullname'        => $fullname,
			'id_card_number'  => $id_card_number,
			'country_code'    => $country_code,
			'address'         => $address,
			'postal_code'     => $postal_code,
			'id_bank'         => $id_bank,
			'no_rekening'     => $no_rekening,
			'foto_ktp'        => $foto_ktp,
			'foto_pegang_ktp' => $foto_pegang_ktp,
			'is_kyc'          => 'check',
		];
		$where = ['id' => $this->id_member];
		$exec = $this->M_core->update('member', $data, $where);

		if (!$exec) {
			$this->db->trans_rollback();
			echo json_encode([
				'code' => 500,
				'msg'  => "Proses KYC Gagal, silahkan coba kembali",
			]);
			exit;
		}

		$this->db->trans_commit();
		echo json_encode([
			'code' => 200,
			'msg'  => "Selanjutnya kita akan menginformasikan via Email terkait Lolos / Tidak KYC kamu",
		]);
		exit;
	}
}
        
/* End of file  ProfileController.php */
