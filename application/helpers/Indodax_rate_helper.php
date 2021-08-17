<?php
// $type: usdtidr or trxidr
function indodax_rate($type)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://indodax.com/api/ticker/$type");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	$output = json_decode($output);
	return $output->ticker->last;
}
                        
/* End of file indodax_rate_helper.php */
