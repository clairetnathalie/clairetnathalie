<?php
/**
 * HTTP Request class
 *
 * @version 1.0
 * @author martin maly
 * @copyright (C) 2008 martin maly
 */
/*   Modified for compatibility with GoCart by Clear Sky Designs */
/**
 * Class  HTTPRequest
 *
 * @version 1.0
 * @author martin maly
 * @copyright (C) 2008 martin maly
 * 2.10.2008 20:10:40
 */

class HTTPRequest_gw {
	
	private $host;
	private $host_diagnosis;
	
	private $path;
	private $path_diagnosis;
	private $data;
	private $method = "POST";
	private $port;
	private $rawhost;
	private $rawhost_diagnosis;
	public $ssl = true;
	
	private $header;
	private $content;
	private $parsedHeader;
	private $CI;
	
	function __construct(/* $host, $path, $method = 'POST', $ssl = false, $port = 0 */) {
		
		force_ssl ();
		
		$this->CI = & get_instance ();
		$this->host = $this->CI->googlewallet->host;
		$this->rawhost = $this->host;
		$this->path = $this->CI->googlewallet->endpoint;
		
		$this->host_diagnosis = $this->CI->googlewallet->diagnosis;
		$this->rawhost_diagnosis = $this->host_diagnosis;
		$this->path_diagnosis = $this->CI->googlewallet->endpoint;
	
		//$this->method = strtoupper($method);
	//if ($port) {
	//	$this->port = $port;
	//} else {
	//if (!$this->ssl) $this->port = 80; else $this->port = 443;
	//}
	}
	
	public function connect($merchant_id, $merchant_key, $Authorization_Key, $data) {
		
		/*
		$this->CI->output->set_header('Authorization: Basic '.$Authorization_Key);
		$this->CI->output->set_header('Content-Type: application/xml;charset=UTF-8');
		$this->CI->output->set_header('Accept: application/xml;charset=UTF-8');
		$this->CI->output->set_output($data);
		*/
		
		$ch = curl_init ();
		
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array ("Authorization: Basic '.$Authorization_Key" ) );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array ("Content-Type: application/xml;charset=UTF-8" ) );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array ("Accept: application/xml;charset=UTF-8" ) );
		
		curl_setopt ( $ch, CURLOPT_URL, $this->host );
		curl_setopt ( $ch, CURLOPT_USERPWD, "$merchant_id:$merchant_key" );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 ); // Changing CURLOPT_HEADER to 0 makes it so that only the page content is returned
		curl_setopt ( $ch, CURLOPT_VERBOSE, 1 );
		
		$response = curl_exec ( $ch );
		
		curl_close ( $ch );
		
		if ($response) {
			// Successful
			$response_xml = simplexml_load_string ( $response );
			$att = 'serial-number';
			$gw_serial = ( string ) $response_xml->attributes ()->$att;
			
			$dom = new DOMDocument ();
			$element = $dom->createElementNS ( 'http://checkout.google.com/schema/2', 'notification-acknowledgment', '' );
			$dom->appendChild ( $element );
			$element->setAttribute ( 'serial-number', "$gw_serial" );
			
			$xml_string = '';
			foreach ( $dom->childNodes as $node ) {
				$xml_string = $xml_string . $dom->saveXML ( $node );
			}
			
			$this->CI->output->set_status_header ( '200' );
			$this->CI->output->set_output ( $xml_string );
			
			return $response;
		} else {
			// Not Successful
			$this->CI->output->set_status_header ( '404' );
			
			return false;
		}
	}
	
	function connect_diagnosis($merchant_id, $merchant_key, $Authorization_Key, $data) {
		/*
		$this->CI->output->set_header('Authorization: Basic '.$Authorization_Key);
		$this->CI->output->set_header('Content-Type: application/xml;charset=UTF-8');
		$this->CI->output->set_header('Accept: application/xml;charset=UTF-8');
		$this->CI->output->set_output($data);
		*/
		
		$ch = curl_init ();
		
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array ("Authorization: Basic '.$Authorization_Key" ) );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array ("Content-Type: application/xml;charset=UTF-8" ) );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array ("Accept: application/xml;charset=UTF-8" ) );
		
		curl_setopt ( $ch, CURLOPT_URL, $this->host_diagnosis );
		curl_setopt ( $ch, CURLOPT_USERPWD, "$merchant_id:$merchant_key" );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		
		$response = curl_exec ( $ch );
		
		curl_close ( $ch );
		
		echo $response;
		die ();
	}
}