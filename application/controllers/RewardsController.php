<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RewardsController extends CI_Controller
{

	protected $date;
	protected $datetime;
	protected $id_member;


	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_member', null, 'template');
		$this->load->helper('Floating_helper');

		$this->load->model('M_member');


		$this->date      = date('Y-m-d');
		$this->datetime  = date('Y-m-d H:i:s');
		$this->id_member = $this->session->userdata(SESI . 'id');
	}


	public function index()
	{
		$id_member = $this->id_member;
		$arr       = $this->M_core->get('member_reward', '*', ['id_member' => $id_member]);

		$arr_tree = $this->M_core->get('tree', '*', ['id_member' => $id_member]);
		$lft      = $arr_tree->row()->lft;
		$rgt      = $arr_tree->row()->rgt;
		$depth    = $arr_tree->row()->depth;

		$main_line          = $this->M_member->get_data_member_reward(null, $lft, $rgt, $depth + 1, null, 1);
		$id_main_line       = $main_line->row()->id;
		$main_fullname      = $main_line->row()->fullname;
		$main_email         = $main_line->row()->email;
		$downline_main_line = "From Line $main_fullname ($main_email)";
		$omset_main_line    = check_float($main_line->row()->total_omset);

		if ($main_line->row()->total_omset == 0) {
			$downline_main_line = "";
		}

		$other_line = $this->M_member->get_data_member_reward(null, $lft, $rgt, $depth + 1, $id_main_line, 1, $id_main_line);

		$omset_other_line = 0;

		if ($other_line->num_rows() > 0) {
			foreach ($other_line->result() as $key_o) {
				$total_omset_other = $key_o->total_omset;
				$omset_other_line += $total_omset_other;
			}
		}

		$omset_other_line = check_float($omset_other_line);

		$data = [
			'title'              => APP_NAME . ' | Rewards',
			'content'            => 'rewards/main',
			'vitamin_js'         => 'rewards/main_js',
			'arr'                => $arr,
			'downline_main_line' => $downline_main_line,
			'omset_main_line'    => $omset_main_line,
			'omset_other_line'   => $omset_other_line,
		];
		$this->template->render($data);
	}
}
        
    /* End of file  RewardsController.php */
