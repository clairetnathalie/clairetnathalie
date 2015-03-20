<?php

class news extends Front_Controller {
	
	var $CI;
	
	function __construct() {
		parent::__construct ();
		
		$this->CI = & get_instance ();
	}
	
	function index() {
		//we don't have a default landing page
		redirect ( 'http://www.facebook.com/pages/Couettabra/125326350915703' );
	}
}