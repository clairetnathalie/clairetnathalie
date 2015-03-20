<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class mandrill_send {
	var $CI;
	
	function send_register($senderSurname, $senderFirstname, $senderEmail, $subjectEmail, $bodyEmail) {
		$this->CI = & get_instance ();
		
	/*
		$this->CI->load->config('mandrill');
		$this->CI->load->library('mandrill');
		
		$mandrill_ready = NULL;
		
		try {
		
		    $this->CI->mandrill->init( $this->CI->config->item('mandrill_api_key') );
		    $mandrill_ready = TRUE;
		
		} catch(Mandrill_Exception $e) {
		
		    $mandrill_ready = FALSE;
		
		}
		
		if( $mandrill_ready ) {
		
		    //Send us some email!
		    $email = array(
		        'html' => '<p>'.$bodyEmail.'<p>', //Consider using a view file
		        'text' => $bodyEmail,
		        'subject' => $subjectEmail,
		        'from_email' => $this->CI->config->item('email'),
		        'from_name' => $this->CI->config->item('company_name'),
		        //'to' => array(array('email' => 'joe@example.com' )) //Check documentation for more details on this one
		        //'to' => array(array('email' => 'joe@example.com' ),array('email' => 'joe2@example.com' )) //for multiple emails
		        'to' => array(array('email' => $senderEmail,'name' => $senderSurname . ' ' . $senderFirstname ))
		        );
		
		    $result = $this->CI->mandrill->messages_send($email);
		}
		*/
	
	/*
		$this->CI->config->load('mandrill',TRUE);
		$this->CI->config_ma = $this->CI->config->item('mandrill');
		
		$this->CI->load->library('mandrill/Mandrill.php');
		Mandrill::setApiKey($this->CI->config_ma['mandrill_apikey']);
				
		$arr = array(
			'type' => 'messages', 
			'call' => 'send', 
			'message' => array (
				'html' => $bodyEmail, 
				'text' => $bodyEmail, 
				'subject' => $subjectEmail, 
				'from_email' => $this->CI->config_ma['mandrill_SMTP_Username'], 
				'from_name' => $this->CI->config->item('company_name'), 
				'to' => array (
					0 => array (
			    		'email' => $senderEmail,
						'name' => $senderSurname . ' ' . $senderFirstname
					)	
				),
				'headers' => array (), 
				'track_opens' => true,
				'track_clicks' => true,
				'auto_text' => true,
				'url_strip_qs' => true,
				'tags' => array ("confirm_souscription"),
				'google_analytics_domains' => array ("couettabra.com", "maison-gueneau-mauger.com, , "clairetnathalie.com"),
				'google_analytics_campaign' => array ("confirm_souscription"),
				'metadata' => array ()
			)
		);
		
		//Because json_encode() only deals with utf8, it is often necessary to convert all the string values inside an array to utf8. 

		$request_json = json_encode($this->_utf8_encode_all($arr));
		
		// tests
		//echo json_encode($arr);
		//$request_json = '{"type":"messages","call":"send","message":{"html": "<h1>example html</h1>", "text": "example text", "subject": "example subject", "from_email": "wes@werxltd.com", "from_name": "example from_name", "to":[{"email": "wes@reasontostand.org", "name": "Wes Widner"}],"headers":{"...": "..."},"track_opens":true,"track_clicks":true,"auto_text":true,"url_strip_qs":true,"tags":["test","example","sample"],"google_analytics_domains":["werxltd.com"],"google_analytics_campaign":["..."],"metadata":["..."]}}';

		$ret = Mandrill::call((array) json_decode($request_json));
		*/
	}
	
	function _utf8_encode_all($dat) // -- It returns $dat encoded to UTF8
{
		if (is_string ( $dat ))
			return utf8_encode ( $dat );
		if (! is_array ( $dat ))
			return $dat;
		$ret = array ();
		foreach ( $dat as $i => $d )
			$ret [$i] = $this->_utf8_encode_all ( $d );
		return $ret;
	}
}
