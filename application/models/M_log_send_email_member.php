<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_log_send_email_member extends CI_Model
{
	protected $table;


	public function __construct()
	{
		parent::__construct();
		$this->table = "log_send_email_member";
	}


	public function write_log($to = null, $subject = null, $message = null, $status = null, $id_member = null): bool
	{
		if (is_null($to) === TRUE && is_null($subject) === TRUE && is_null($message) === TRUE) {
			return true;
		}

		$data = [
			'mail_to'      => $to,
			'mail_subject' => $subject,
			'mail_message' => $message,
			'is_success'   => $status,
			'created_at'   => date('Y-m-d H:i:s'),
			'created_by'   => $id_member,
		];
		return $this->db->insert($this->table, $data);
	}
}
                        
/* End of file M_log_send_email_member.php */
