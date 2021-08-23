<?php
function check_float($no, $afterPoint = 8, $minAfterPoint = 0, $thousandSep = ",", $decPoint = ".")
{
	// Same as number_format() but without unnecessary zeros.
	$ret = number_format($no, $afterPoint, $decPoint, $thousandSep);
	if ($afterPoint != $minAfterPoint) {
		while (($afterPoint > $minAfterPoint) && (substr($ret, -1) == "0")) {
			// $minAfterPoint!=$minAfterPoint and number ends with a '0'
			// Remove '0' from end of string and set $afterPoint=$afterPoint-1
			$ret = substr($ret, 0, -1);
			$afterPoint = $afterPoint - 1;
		}
	}
	if (substr($ret, -1) == $decPoint) {
		$ret = substr($ret, 0, -1);
	}
	return $ret;
}

function base64url_encode($data)
{
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data)
{
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
} 
                        
/* End of file Floating.php */
