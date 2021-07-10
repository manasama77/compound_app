<?php
defined('BASEPATH') or exit('No direct script access allowed');

function Generate_otp()
{
	$otp = rand(100_000, 999_999);
	return $otp;
}

function Is_base64($s)
{
	return (bool) preg_match('/^[a-zA-Z0-9@].{1,}$/', $s);
}
                        
/* End of file Helper_otp.php */
