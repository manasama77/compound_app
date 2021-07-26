<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DownlineController extends CI_Controller
{
	protected $id_member;
	protected $date;
	protected $datetime;

	public function __construct()
	{
		parent::__construct();
		$this->date      = date('Y-m-d');
		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');

		$this->load->library('L_member', null, 'template');
		$this->load->helper('Floating_helper');
		$this->load->model('M_dashboard');
		$this->load->model('M_downline');
	}

	public function index()
	{
		$max_depth = $this->M_downline->get_max_depth($this->id_member);
		$data = [
			'title'      => APP_NAME . ' Downline Management',
			'content'    => 'downline/main',
			'vitamin_js' => 'downline/main_js',
			'max_depth'  => $max_depth,
		];
		$this->template->render($data);
	}

	public function show()
	{
		$id_member_depth = $this->M_core->get('tree', 'depth', ['id_member' => $this->id_member])->row()->depth;
		$depth           = $this->input->get('depth') + $id_member_depth;
		$arr             = $this->M_dashboard->get_latest_downline($this->id_member, $depth, null);

		$max_depth = $this->M_downline->get_max_depth($this->id_member);

		$data = [
			'title'      => APP_NAME . ' Downline Management',
			'content'    => 'downline/show',
			'vitamin_js' => 'downline/show_js',
			'arr'        => $arr,
			'max_depth'  => $max_depth,
		];
		$this->template->render($data);
	}
}
        
/* End of file  DownlineController.php */
