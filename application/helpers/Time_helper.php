<?php
function time_ago(Datetime $date)
{
	$time_ago = '';

	$diff = $date->diff(new Datetime('now'));


	if (($t = $diff->format("%m")) > 0) {
		$time_ago = $t . ' months';
	} elseif (($t = $diff->format("%d")) > 0) {
		$time_ago = $t . ' days';
	} elseif (($t = $diff->format("%H")) > 0) {
		$time_ago = $t . ' hours';
	} else {
		$time_ago = 'minutes';
	}

	return $time_ago . ' ago (' . $date->format('M j, Y') . ')';
}
                        
/* End of file TimeHelper.php */
