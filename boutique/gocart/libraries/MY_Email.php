<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class MY_Email extends CI_Email {
	
	var $CI;
	
	public function __construct() {
		$this->CI = & get_instance ();
		
		parent::__construct ();
		
		$this->CI->load->library ( '/PHPMailer_5.2.4/phpmailer' );
	}
	
	public function set_header($header, $value) {
		
		parent::_set_header ( $header, $value );
	}
	
	public function my_print_debugger() {
		$msg = '';
		
		if (count ( $this->_debug_msg ) > 0) {
			foreach ( $this->_debug_msg as $val ) {
				$msg .= $val;
			}
		}
		
		$msg .= "<pre>" . $this->_header_str . "\n" . htmlspecialchars ( $this->_subject ) . "\n" . '</pre>';
		return $msg;
	}
	
	public function my_print_email_headers() {
		$msg = '';
		$msg .= "<pre>" . $this->_header_str . '</pre>';
		return '';
	}
	
	function init_php_mailer_email($config, $debug = false) {
		
		//$this->CI->phpmailer->IsMail(true); 										// Set mailer to use Mail */
		//$this->CI->phpmailer->IsQmail(true); 										// Set mailer to use Qmail */
		//$this->CI->phpmailer->IsSendmail(true); 									// Set mailer to use Sendmail */
		

		$this->CI->phpmailer->isSMTP ( true ); // Set mailer to use SMTP       
		$this->CI->phpmailer->SMTPAuth = true; // Enable SMTP authentication
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		if ($debug) {
			$this->CI->phpmailer->SMTPDebug = 2;
			$this->CI->phpmailer->Debugoutput = 'html'; //Ask for HTML-friendly debug output
			$this->CI->phpmailer->AuthType = 'LOGIN';
		} else {
			$this->CI->phpmailer->SMTPDebug = 0;
		}
		
		//$this->CI->phpmailer->setLanguage('fr', 'language/phpmailer.lang-fr.php');
		

		$this->CI->phpmailer->Host = $config ['Host']; // Specify main and backup server
		$this->CI->phpmailer->Username = $config ['Username']; // SMTP username
		$this->CI->phpmailer->Password = $config ['Password']; // SMTP password
		

		if ($debug) {
			//$this->CI->phpmailer->SMTPSecure 		= $config['SMTPSecure'];     	// Enable encryption, 'ssl' also accepted
			$this->CI->phpmailer->Timeout = $config ['Timeout'];
			$this->CI->phpmailer->Port = $config ['Port'];
		} else {
			$this->CI->phpmailer->SMTPSecure = $config ['SMTPSecure']; // Enable encryption, 'ssl' also accepted
			$this->CI->phpmailer->Timeout = $config ['Timeout'];
			$this->CI->phpmailer->Port = $config ['Port'];
		}
		
		//$this->CI->phpmailer->Encoding 			= "base64";
		$this->CI->phpmailer->CharSet = 'UTF-8';
		
		if ($config ['Host'] == "smtp.mandrillapp.com") {
			/*
			$this->CI->phpmailer->set('X-MC-GoogleAnalytics','clairetnathalie.com');
			$this->CI->phpmailer->set('X-MC-GoogleAnalyticsCampaign','message.from_email@clairetnathalie.com');
			$this->CI->phpmailer->set('X-MC-Track','opens, clicks_all');
			$this->CI->phpmailer->set('X-MC-Autotext','1'); 
			$this->CI->phpmailer->set('X-MC-SigningDomain','clairetnathalie.com'); 
			$this->CI->phpmailer->set('X-MC-Metadata','{ "notification":"purchase order" }');
			*/
			
			$this->CI->phpmailer->addCustomHeader ( 'X-MC-GoogleAnalytics', 'clairetnathalie.com' );
			$this->CI->phpmailer->addCustomHeader ( 'X-MC-GoogleAnalyticsCampaign', 'message.from_email@clairetnathalie.com' );
			$this->CI->phpmailer->addCustomHeader ( 'X-MC-Track', 'opens, clicks_all' );
			$this->CI->phpmailer->addCustomHeader ( 'X-MC-Autotext', '1' );
			$this->CI->phpmailer->addCustomHeader ( 'X-MC-SigningDomain', 'clairetnathalie.com' );
			$this->CI->phpmailer->addCustomHeader ( 'X-MC-Metadata', '{ "notification":"purchase order" }' );
		}
	}
	
	function embed_image_php_mailer($image_data) {
		$this->CI->phpmailer->AddEmbeddedImage ( $image_data ['path'], $image_data ['name'], $image_data ['name'] . '.png' );
	}
	
	function embed_image_string_php_mailer($image_data) {
		$this->CI->phpmailer->AddStringAttachment ( $image_data ['encoded_string'], $image_data ['name'], 'base64', $image_data ['type'] );
	}
	
	function send_php_mailer_email($email_data, $debug = false) {
		
		$this->CI->phpmailer->AddAddress ( $email_data ['ToEmail'], $email_data ['ToName'] );
		$this->CI->phpmailer->FromName = $email_data ['FromName'];
		$this->CI->phpmailer->From = $email_data ['From'];
		if (! $debug) {
			$this->CI->phpmailer->addReplyTo = $email_data ['addCC'];
			$this->CI->phpmailer->addCC = $email_data ['addCC'];
			$this->CI->phpmailer->addBCC = $email_data ['addBCC'];
		}
		$this->CI->phpmailer->Subject = $email_data ['Subject'];
		$this->CI->phpmailer->Body = $email_data ['Body'];
		$this->CI->phpmailer->IsHTML ( true );
		
		if ($debug) {
			if (! $this->CI->phpmailer->Send ()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $this->CI->phpmailer->ErrorInfo;
				exit ();
			}
			echo 'Message has been sent';
		} else {
			$this->CI->phpmailer->Send ();
		}
	}
}
