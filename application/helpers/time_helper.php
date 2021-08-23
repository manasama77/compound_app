<?php
function time_ago(Datetime $date)
{
	$time_ago = '';

	$diff = $date->diff(new Datetime('now'));


	if (($t = $diff->format("%m")) > 0) {
		$time_ago = $t . ' bulan';
	} elseif (($t = $diff->format("%d")) > 0) {
		$time_ago = $t . ' hari';
	} elseif (($t = $diff->format("%H")) > 0) {
		$time_ago = $t . ' jam';
	} else {
		$time_ago = 'menit';
	}

	return $time_ago . ' yang lalu (' . $date->format('M j, Y') . ')';
}
                        
/* End of file TimeHelper.php */
