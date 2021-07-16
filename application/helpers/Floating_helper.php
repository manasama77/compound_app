<?php
function check_float($no)
{
	if (fmod($no, 1) == 0) {
		return number_format($no, 0);
	}

	return number_format($no, 8);
}
                        
/* End of file Floating.php */
