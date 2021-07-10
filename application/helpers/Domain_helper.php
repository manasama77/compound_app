<?php
defined('BASEPATH') or exit('No direct script access allowed');

function Domain()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'] . '/' . base_url();
	return $protocol . $domainName;
}
