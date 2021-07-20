<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TestController extends CI_Controller
{

	public function index()
	{
		$data = [
			'invoice' 	   => 'invoicenya',
			'item_name'    => 'nama paket',
			'date_expired' => date("Y-m-d")
		];
		return $this->load->view('emails/package_extend', $data, FALSE);
	}
}
        
    /* End of file  TestController.php */
