<?php
defined('BASEPATH') or exit('No direct script access allowed');
$hook['post_controller_constructor'][] = array(
	'function' => 'redirect_ssl',
	'filename' => 'ssl.php',
	'filepath' => 'hooks'
);
