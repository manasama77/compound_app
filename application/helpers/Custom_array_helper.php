<?php
function removeElementWithValue($array, $key, $value)
{
	foreach ($array['result_array'] as $subKey => $subArray) {
		if ($subArray[$key] == $value) {
			unset($array['result_array'][$subKey]);
		}
	}
	return $array;
}

function removeElementWithValueDefault($array, $key, $value)
{
	foreach ($array as $subKey => $subArray) {
		if ($subArray[$key] == $value) {
			unset($array[$subKey]);
		}
	}
	return $array;
}
                        
/* End of file Custom_array.php */
