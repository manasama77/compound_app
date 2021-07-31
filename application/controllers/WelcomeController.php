<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WelcomeController extends CI_Controller
{

	public function index()
	{
		// return $this->load->view('welcome');
		return $this->load->view('coming_soon');
	}
}
        
    /* End of file  WelcomeController.php */
