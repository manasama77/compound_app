<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TestController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_test');
	}

	public function index()
	{
		$this->M_test->perbaikan_omset_downline();
	}
}
        
    /* End of file  TestController.php */
