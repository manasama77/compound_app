<?php
defined('BASEPATH') or exit('No direct script access allowed');

class L_member
{

	protected $ci;
	protected $id_member;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('M_core', 'mcore');
		$this->ci->load->helper(['cookie', 'string', 'floating_helper', 'indodax_rate_helper']);
		$this->id_member = $this->ci->session->userdata(SESI . 'id');
	}

	public function render($data)
	{
		$check_cookies = $this->check_cookies();

		if ($check_cookies === TRUE) {
			$this->render_view($data);
		} else {
			$check_session = $this->check_session();

			if ($check_session === TRUE) {
				$this->render_view($data);
			} else {
				$this->reject();
			}
		}
	}

	protected function check_cookies()
	{
		$cookies = get_cookie(KUE);

		if ($cookies === NULL) {
			return FALSE;
		} else {
			$where = [
				'cookies'    => $cookies,
				'is_active'  => 'yes',
				'deleted_at' => null,
			];
			$arr = $this->ci->mcore->get('member', '*', $where);

			if ($arr->num_rows() == 1) {
				$id              = $arr->row()->id;
				$email           = $arr->row()->email;
				$fullname        = $arr->row()->fullname;
				$phone_number    = $arr->row()->phone_number;
				$cookies_db      = $arr->row()->cookies;
				$is_active       = $arr->row()->is_active;
				$profile_picture = $arr->row()->profile_picture;
				$user_id         = $arr->row()->user_id;

				if ($profile_picture == NULL) {
					$profile_picture = base_url('public/img/pp/default_avatar.svg');
				} else {
					$profile_picture = (is_file(FCPATH . 'public/img/pp/default_avatar.svg')) ? base_url('public/img/pp/default_avatar.svg') : $profile_picture;
				}

				if ($cookies == $cookies_db) {
					return $this->reset_session($id, $email, $fullname, $phone_number, $is_active, $profile_picture, $user_id);
				}
				return FALSE;
			} else {
				return FALSE;
			}
		}
	}

	public function check_session()
	{
		$id              = $this->ci->session->userdata(SESI . 'id');
		$fullname        = $this->ci->session->userdata(SESI . 'fullname');
		$email           = $this->ci->session->userdata(SESI . 'email');
		$phone_number    = $this->ci->session->userdata(SESI . 'phone_number');
		$is_active       = $this->ci->session->userdata(SESI . 'is_active');
		$profile_picture = $this->ci->session->userdata(SESI . 'profile_picture');
		$user_id         = $this->ci->session->userdata(SESI . 'user_id');

		if ($id && $email && $fullname && $phone_number && $is_active && $profile_picture && $user_id) {
			if ($is_active == "yes") {
				return TRUE;
			} else {
				return false;
			}
		}
		return FALSE;
	}

	public function render_view($data)
	{
		if (file_exists(APPPATH . 'views/pages/member/' . $data['content'] . '.php')) {
			$where_trade_manager = [
				'id_member'  => $this->ci->session->userdata(SESI . 'id'),
				'state'      => 'active',
				'deleted_at' => null,
			];
			$data['aside_count_trade_manager'] = $this->ci->M_core->count('member_trade_manager', $where_trade_manager);
			$data['aside_count_crypto_asset']  = $this->ci->M_core->count('member_crypto_asset', $where_trade_manager);
			$data['x_app']                     = $this->ci->M_core->get('app_config', '*', ['id' => 1]);
			$data['x_usdt_idr']                = indodax_rate('usdtidr');
			$data['x_trx_idr']                 = indodax_rate('trxidr');
			$data['x_wallet_address']          = base64url_encode($this->id_member);
			$this->ci->load->view('layouts/member/main', $data, FALSE);
		} else {
			show_404();
		}
	}

	public function reject()
	{
		$this->ci->session->set_flashdata('expired', 'Sesi berakhir');
		redirect('logout');
	}

	protected function reset_session($id, $email, $fullname, $phone_number, $is_active, $profile_picture, $user_id)
	{
		$this->ci->session->set_userdata(SESI . 'id', $id);
		$this->ci->session->set_userdata(SESI . 'email', $email);
		$this->ci->session->set_userdata(SESI . 'fullname', $fullname);
		$this->ci->session->set_userdata(SESI . 'phone_number', $phone_number);
		$this->ci->session->set_userdata(SESI . 'is_active', $is_active);
		$this->ci->session->set_userdata(SESI . 'profile_picture', $profile_picture);
		$this->ci->session->set_userdata(SESI . 'user_id', $user_id);

		return $this->check_session();
	}
}
                                                
/* End of file L_member.php */
