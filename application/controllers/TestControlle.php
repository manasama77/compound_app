<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TestController extends CI_Controller
{

	public function index()
	{
		echo "a";
		// $this->db->trans_begin();
		// $email = "adam@gmail.com";

		// $data = ['email' => $email];
		// $this->M_core->store('mem', $data);

		// $id = $this->db->insert_id();

		// echo $id;

		// $this->db->trans_rollback();
	}
}
        
/* End of file  TestController.php */
