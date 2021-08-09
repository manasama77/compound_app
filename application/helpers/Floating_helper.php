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
                        
/* End of file Floating.php */
