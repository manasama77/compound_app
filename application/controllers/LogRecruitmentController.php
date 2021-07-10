<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LogRecruitmentController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_member', null, 'template');
		$this->load->library('Nested_set', null, 'Nested_set');
		$this->load->helper('Time_helper');

		$this->load->model('M_member');

		$this->Nested_set->setControlParams('tree', 'lft', 'rgt', 'id_member', 'id_upline', 'email');
	}


	public function index()
	{
		$data_downline = array();
		$id_member  = $this->session->userdata(SESI . 'id');

		$arr_downline = $this->M_member->tree_get_downline($id_member);

		$data = [
			'title'         => APP_NAME . ' | Dashboard',
			'content'       => 'log/recruitment/main',
			'vitamin_js'    => 'log/recruitment/main_js',
			'data_downline' => $arr_downline,
		];

		$this->template->render($data);
	}
}
        
/* End of file LogRecruitmentController.php */
