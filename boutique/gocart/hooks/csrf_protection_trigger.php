<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

function csrf_protection_trigger() {
	$CI = & get_instance ();
	//$CI =& load_class('Config', 'core');
	

	if (! preg_match ( '/localhost/', $_SERVER ["HTTP_HOST"] )) {
		if (isset ( $_SERVER ["REQUEST_URI"] )) {
			//if(stripos($_SERVER["REQUEST_URI"],'/bnp_gate') === FALSE AND stripos($_SERVER["REQUEST_URI"],'/pp_gate') === FALSE)
			if ((! preg_match ( '/bnp_gate/', $_SERVER ["REQUEST_URI"] )) && (! preg_match ( '/pp_gate/', $_SERVER ["REQUEST_URI"] ))) {
				$CI->config->set_item ( 'csrf_protection', TRUE );
			} else {
				$CI->config->set_item ( 'csrf_protection', FALSE );
			}
		} else {
			$CI->config->set_item ( 'csrf_protection', TRUE );
		}
	} else {
		$CI->config->set_item ( 'csrf_protection', FALSE );
	}
}
 
/* End of file https.php */
/* Location: ./system/application/hooks/https.php */