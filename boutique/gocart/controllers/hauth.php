<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class HAuth extends Front_Controller {
	
	var $CI;
	
	var $data;
	
	var $_identifier = false;
	var $_displayName = false;
	var $_photoURL = false;
	
	function __construct() {
		parent::__construct ();
		
		//load needed models
		$this->load->model ( array ('Customer_model', 'Social_model_fb' ) );
		//load needed language file
		$this->lang->load ( 'hauth' );
	}
	
	public function index() {
		redirect ( 'secure/login' );
	}
	
	public function home() {
		redirect ( 'secure/login' );
	}
	
	public function login($provider) {
		//log_message('debug', "controllers.HAuth.login($provider) called");
		

		try {
			//log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');
			$this->CI = & get_instance ();
			$this->CI->load->library ( 'HybridAuthLib' );
			
			if ($this->CI->hybridauthlib->providerEnabled ( $provider )) {
				//log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
				$service = $this->CI->hybridauthlib->authenticate ( $provider );
				
				if ($service->isUserConnected ()) {
					//log_message('debug', 'controller.HAuth.login: user authenticated.');
					

					$user_profile = $service->getUserProfile ();
					
					//log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));
					

					$this->data ['user_profile'] = $user_profile;
					
					if ($this->Customer_model->check_email ( $this->data ['user_profile']->email )) {
						$this->Customer_model->login_social ( $this->data ['user_profile']->email, true );
						
						$id = $this->Customer_model->get_customer_id_by_email ( $this->data ['user_profile']->email );
						
						$this->_record_social ( $provider, $id, $this->data ['user_profile'] );
					} else {
						$customer ['firstname'] = $this->data ['user_profile']->firstName;
						$customer ['lastname'] = $this->data ['user_profile']->lastName;
						$customer ['email'] = $this->data ['user_profile']->email;
						$customer ['phone'] = (isset ( $this->data ['user_profile']->phone )) ? $this->data ['user_profile']->phone : '';
						$customer ['company'] = (isset ( $this->data ['user_profile']->company )) ? $this->data ['user_profile']->company : '';
						
						$id = $this->_register_social ( $customer );
						
						$this->_record_social ( $provider, $id, $this->data ['user_profile'] );
					}
					
					$redirect = 'secure/my_account';
					redirect ( $redirect );
				
		//$this->CI->load->view('hauth/done',$this->data);
				} else // Cannot authenticate user
{
					//show_error('Cannot authenticate user');
					

					$redirect = 'secure/my_account';
					redirect ( $redirect );
				}
			} else // This service is not enabled.
{
				//log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
				show_404 ( $_SERVER ['REQUEST_URI'] );
			}
		} catch ( Exception $e ) {
			$error = 'Unexpected error';
			switch ($e->getCode ()) {
				case 0 :
					$error = lang ( 'unspecified_error' );
					break;
				case 1 :
					$error = lang ( 'configuration_error' );
					break;
				case 2 :
					$error = lang ( 'not_properly_configured' );
					break;
				case 3 :
					$error = lang ( 'unknown_or_disabled_provider' );
					break;
				case 4 :
					$error = lang ( 'missing_provider' );
					break;
				case 5 : //log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
					$error = lang ( 'user_has_cancelled_authentication' );
					break;
				case 6 :
					$error = lang ( 'profile_request_failed' );
					$this->config_fb = $this->config->item ( 'facebook' );
					$this->load->library ( 'facebook', $this->config_fb, 'facebook' );
					$fb_app_login_url = $this->facebook->getLoginUrl ( array ('scope' => $this->config_fb ['facebook_default_scope'], 'redirect_uri' => preg_replace ( '/http:\/\//i', 'https://', site_url ( 'hauth/login' ) ), 'display' => 'page' )// popup or page. defaut is page
 );
					redirect ( $fb_app_login_url );
					break;
				case 7 :
					$error = lang ( 'user_not_connected_to_provider' );
					break;
			}
			
			if (isset ( $service )) {
				$service->logout ();
			}
			
			//log_message('error', 'controllers.HAuth.login: '.$error);
			

			//show_error('Error authenticating user.');
			$this->session->set_flashdata ( 'error', $error );
			redirect ( 'secure/login' );
		}
	}
	
	public function checkout($provider) {
		//log_message('debug', "controllers.HAuth.login($provider) called");
		

		try {
			//log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');
			$this->CI->load->library ( 'HybridAuthLib' );
			
			if ($this->CI->hybridauthlib->providerEnabled ( $provider )) {
				//log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
				$service = $this->CI->hybridauthlib->authenticate ( $provider );
				
				if ($service->isUserConnected ()) {
					//log_message('debug', 'controller.HAuth.login: user authenticated.');
					

					$user_profile = $service->getUserProfile ();
					
					//log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));
					

					$this->data ['user_profile'] = $user_profile;
					
					if ($this->Customer_model->check_email ( $this->data ['user_profile']->email )) {
						$this->Customer_model->login_social ( $this->data ['user_profile']->email, true );
						
						$id = $this->Customer_model->get_customer_id_by_email ( $this->data ['user_profile']->email );
						
						$this->_record_social ( $provider, $id, $this->data ['user_profile'] );
					} else {
						$customer ['firstname'] = $this->data ['user_profile']->firstName;
						$customer ['lastname'] = $this->data ['user_profile']->lastName;
						$customer ['email'] = $this->data ['user_profile']->email;
						$customer ['phone'] = (isset ( $this->data ['user_profile']->phone )) ? $this->data ['user_profile']->phone : '';
						$customer ['company'] = (isset ( $this->data ['user_profile']->company )) ? $this->data ['user_profile']->company : '';
						
						$id = $this->_register_social ( $customer );
						
						$this->_record_social ( $provider, $id, $this->data ['user_profile'] );
					}
					
					// i store data to flashdata
					$temp_data = array ();
					$temp_data ['company'] = '';
					$temp_data ['firstname'] = (isset ( $this->data ['user_profile']->firstName )) ? $this->data ['user_profile']->firstName : '';
					$temp_data ['lastname'] = (isset ( $this->data ['user_profile']->lastName )) ? $this->data ['user_profile']->lastName : '';
					$temp_data ['email'] = (isset ( $this->data ['user_profile']->email )) ? $this->data ['user_profile']->email : '';
					$temp_data ['phone'] = (isset ( $this->data ['user_profile']->phone )) ? $this->data ['user_profile']->phone : '';
					$temp_data ['address1'] = (isset ( $this->data ['user_profile']->address )) ? $this->data ['user_profile']->address : '';
					$temp_data ['address2'] = '';
					$temp_data ['city'] = (isset ( $this->data ['user_profile']->city )) ? $this->data ['user_profile']->city : '';
					$temp_data ['zip'] = (isset ( $this->data ['user_profile']->zip )) ? $this->data ['user_profile']->zip : '';
					
					// after storing i redirect it to the controller
					$this->session->set_flashdata ( 'temp_addr_data', json_encode ( $temp_data ) );
					
					$redirect = 'checkout/step_1';
					redirect ( $redirect );
				
		//print_r_html(json_decode($this->session->flashdata('temp_addr_data')));
				

				//$this->CI->load->view('hauth/done',$this->data);
				} else // Cannot authenticate user
{
					show_error ( 'Cannot authenticate user' );
				}
			} else // This service is not enabled.
{
				//log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
				show_404 ( $_SERVER ['REQUEST_URI'] );
			}
		} catch ( Exception $e ) {
			$error = 'Unexpected error';
			switch ($e->getCode ()) {
				case 0 :
					$error = lang ( 'unspecified_error' );
					break;
				case 1 :
					$error = lang ( 'configuration_error' );
					break;
				case 2 :
					$error = lang ( 'not_properly_configured' );
					break;
				case 3 :
					$error = lang ( 'unknown_or_disabled_provider' );
					break;
				case 4 :
					$error = lang ( 'missing_provider' );
					break;
				case 5 : //log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
					$error = lang ( 'user_has_cancelled_authentication' );
					break;
				case 6 :
					$error = lang ( 'profile_request_failed' );
					$this->config_fb = $this->config->item ( 'facebook' );
					$this->load->library ( 'facebook', $this->config_fb, 'facebook' );
					$fb_app_login_url = $this->facebook->getLoginUrl ( array ('scope' => $this->config_fb ['facebook_default_scope'], 'redirect_uri' => preg_replace ( '/http:\/\//i', 'https://', site_url ( 'hauth/checkout' ) ), 'display' => 'page' )// popup or page. defaut is page
 );
					redirect ( $fb_app_login_url );
					break;
				case 7 :
					$error = lang ( 'user_not_connected_to_provider' );
					break;
			}
			
			if (isset ( $service )) {
				$service->logout ();
			}
			
			//log_message('error', 'controllers.HAuth.login: '.$error);
			

			show_error ( 'Error authenticating user.' );
			$redirect = 'checkout/step_1';
			redirect ( $redirect );
		}
	}
	
	public function endpoint() {
		
		//log_message('debug', 'controllers.HAuth.endpoint called.');
		//log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));
		

		if ($_SERVER ['REQUEST_METHOD'] === 'GET') {
			//log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
			$_GET = $_REQUEST;
		}
		
		//log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');
		require_once APPPATH . '/packages/hybridauth/index.php';
	
	}
	
	private function _record_social($provider, $id, $data_user_profile) {
		$this->_identifier = $data_user_profile->identifier;
		$this->_displayName = $data_user_profile->displayName;
		$this->_photoURL = $data_user_profile->photoURL;
		
		if ($provider == 'Facebook') {
			$this->load->model ( array ('Social_model_fb' ) );
			
			$this->Social_model_fb->_addUserToFbLikeStatus ( $id, $data_user_profile->email, $this->_displayName, $this->_identifier, $this->_photoURL );
		}
		
		if ($provider == 'Google') {
			$this->load->model ( array ('Social_model_google' ) );
			
			$this->Social_model_google->_addUserToGooglePlusStatus ( $id, $data_user_profile->email, $this->_displayName, $this->_identifier, $this->_photoURL );
		}
		
		if ($provider == 'LinkedIn') {
			$this->load->model ( array ('Social_model_linkedin' ) );
			
			$this->Social_model_linkedin->_addUserToLinkedInStatus ( $id, $data_user_profile->email, $this->_displayName, $this->_identifier, $this->_photoURL );
		}
	}
	
	private function _register_social($customer, $redirect = false) {
		$save ['id'] = false;
		
		$save ['firstname'] = $customer ['firstname'];
		$save ['lastname'] = $customer ['lastname'];
		$save ['email'] = $customer ['email'];
		$save ['phone'] = $customer ['phone'];
		$save ['company'] = $customer ['company'];
		$save ['active'] = $this->config->item ( 'new_customer_status' );
		$save ['email_subscribe'] = true;
		
		$save ['password'] = sha1 ( uniqid ( mt_rand ( 5, 15 ) ) );
		
		// save the customer info and get their new id
		$id = $this->Customer_model->save ( $save );
		
		/* send an email */
		// get the email template
		$res = $this->db->where ( 'id', '6' )->get ( 'canned_messages' );
		$row = $res->row_array ();
		
		// set replacement values for subject & body
		

		// {customer_name}
		$row ['subject'] = str_replace ( '{customer_name}', $save ['firstname'] . ' ' . $save ['lastname'], $row ['subject'] );
		$row ['content'] = str_replace ( '{customer_name}', $save ['firstname'] . ' ' . $save ['lastname'], $row ['content'] );
		
		// {url}
		$row ['subject'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $row ['subject'] );
		$row ['content'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $row ['content'] );
		
		// {site_name}
		$row ['subject'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $row ['subject'] );
		$row ['content'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $row ['content'] );
		
		$this->load->library ( 'email' );
		
		//$config['mailtype'] = 'html';
		//$this->email->initialize($config);
		

		/*
		$this->email->from($this->config->item('email'), $this->config->item('company_name'));
		$this->email->to($save['email']);
		$this->email->bcc($this->config->item('email'));
		$this->email->subject($row['subject']);
		$this->email->message(html_entity_decode($row['content']));
		
		$this->email->send();
		*/
		
		$row ['content'] = html_entity_decode ( $row ['content'] );
		
		// Edit message model
		// Build our DOMDocument, and load our HTML
		$doc = new DOMDocument ();
		//$doc->loadHTML('<?xml encoding="UTF-8"><div>'.$row['content'].'</div>');
		@$doc->loadHTML ( '<meta http-equiv="content-type" content="text/html; charset=utf-8"><div>' . $row ['content'] . '</div>' );
		//$doc->loadHTML('<div>'.$row['content'].'</div>');
		

		// Preserve a reference to our DIV container
		$div = $doc->getElementsByTagName ( "div" )->item ( 0 );
		
		// New-up an instance of our DOMXPath class
		$xpath = new DOMXPath ( $doc );
		
		// Find all elements whose class attribute has test2
		$elements = $xpath->query ( "//*[contains(@class,'radactor-cn-logo')]" );
		
		// Cycle over each, remove attribute 'class'
		foreach ( $elements as $element ) {
			// Empty out the class attribute value
			// $element->attributes->getNamedItem("class")->nodeValue = '';
			// Or remove the attribute entirely
			// $element->removeAttribute("class");
			

			$element->parentNode->removeChild ( $element );
		}
		
		$doc->encoding = 'UTF-8';
		
		// Output the HTML of our container
		$row ['content'] = $doc->saveHTML ( $div );
		
		$row ['content'] = $this->load->view ( 'subscribe_email_header', $this->data, true ) . $row ['content'] . $this->load->view ( 'order_email_footer', $this->data, true );
		
		/*//////////////////////////////////////////// CONFIRMATION EMAIL THRU MANDRILL SMTP ///////////////////////////////////////////*/
		
		$config_phpmailer ['Host'] = "smtp.mandrillapp.com";
		$config_phpmailer ['Port'] = "25";
		$config_phpmailer ['SMTPSecure'] = "tls";
		$config_phpmailer ['Username'] = "boutique@couettabra.com";
		$config_phpmailer ['Password'] = "EtApXETYhBaLtQFfHI6sNw";
		$config_phpmailer ['SMTPAuth'] = true;
		$config_phpmailer ['Timeout'] = "5";
		
		$phpmailer_data ['ToEmail'] = $save ['email'];
		
		$phpmailer_data ['ToName'] = $save ['firstname'] . ' ' . $save ['lastname'];
		$phpmailer_data ['FromName'] = $this->config->item ( 'company_name' );
		$phpmailer_data ['From'] = $this->config->item ( 'email' );
		//$phpmailer_data['addCC']						= $this->config->item('email_contact');
		$phpmailer_data ['Subject'] = $row ['subject'];
		$phpmailer_data ['Body'] = $row ['content'];
		
		$this->email->init_php_mailer_email ( $config_phpmailer, false );
		$this->email->send_php_mailer_email ( $phpmailer_data, false );
		
		/*//////////////////////////////////////////// CONFIRMATION EMAIL THRU MANDRILL API ////////////////////////////////////////////*/
		
		/*
		$senderEmail	=  $save['email'];
		
		$this->CI =& get_instance();
		$this->CI->load->library('mandrill');
		
		date_default_timezone_set("UTC");
		$sent_date_time = date("Y-m-d H:i:s", time()); 
		
		$this->CI->mandrill = new Mandrill('EtApXETYhBaLtQFfHI6sNw');
	    $message = array(
	        'html' => $row['content'],
	        //'text' => 'Example text content',
	        'subject' => $row['subject'],
	        'from_email' => $this->config->item('email'),
	        'from_name' => $this->config->item('company_name'),
	        'to' => array(
	            array(
	                'email' => $senderEmail,
	                'name' => $this->data['customer']['firstname'].' '.$this->data['customer']['lastname'],
	                'type' => 'to'
	            ),
	            array(
	                'email' => $this->config->item('email_contact'),
	                'name' => $this->config->item('company_name'),
	                'type' => 'cc'
	            )
	        ),
	        'headers' => array('Reply-To' => $this->config->item('email_contact')),
	        'important' => true,
	        'track_opens' => true,
	        'track_clicks' => true,
	        'auto_text' => true,
	        'auto_html' => null,
	        'inline_css' => null,
	        'url_strip_qs' => null,
	        'preserve_recipients' => null,
	        'view_content_link' => null,
	        'bcc_address' => $this->config->item('email_backup_orders'),
	        'tracking_domain' => 'clairetnathalie.com',
	        'signing_domain' => 'clairetnathalie.com',
	        'return_path_domain' => null,
	        'tags' => array('purchased-item'),
	        'subaccount' => null,
	        'google_analytics_domains' => array('clairetnathalie.com'),
	        'google_analytics_campaign' => 'message.from_email@clairetnathalie.com',
	        'metadata' => array('website' => 'www.clairetnathalie.com')
	    );
	    $async = false;
	    $ip_pool = 'Main Pool';
	    //$send_at = $sent_date_time;
	    $result = $this->CI->mandrill->messages->send($message, $async, $ip_pool, $send_at);
		*/
		
		/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
		
		/*
		$this->load->add_package_path(APPPATH.'packages/mandrill/');
		$this->load->library('mandrill_send');
		$this->mandrill_send->send_register($save['lastname'], $save['firstname'], $save['email'], $row['subject'], $row['content']);
		*/
		
		$this->session->set_flashdata ( 'message', sprintf ( lang ( 'registration_thanks' ), $save ['firstname'] ) );
		
		//lets automatically log them in
		$this->Customer_model->login_social ( $save ['email'], true );
		
		if ($save ['email_subscribe']) {
			$this->load->add_package_path ( APPPATH . 'packages/mailchimp/' );
			$this->load->library ( 'mailchimp_subscribe' );
			$this->mailchimp_subscribe->subscribe ( $save ['firstname'], $save ['lastname'], $save ['email'] );
		}
		
		return $id;
	}
	
	function test_send_email() {
		/* send an email */
		// get the email template
		$res = $this->db->where ( 'id', '6' )->get ( 'canned_messages' );
		$row = $res->row_array ();
		
		// set replacement values for subject & body
		

		// {customer_name}
		$row ['subject'] = str_replace ( '{customer_name}', 'Inoe Scherer', $row ['subject'] );
		$row ['content'] = str_replace ( '{customer_name}', 'Inoe Scherer', $row ['content'] );
		
		// {url}
		$row ['subject'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $row ['subject'] );
		$row ['content'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $row ['content'] );
		
		// {site_name}
		$row ['subject'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $row ['subject'] );
		$row ['content'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $row ['content'] );
		
		$this->load->library ( 'email' );
		
		//$config['mailtype'] = 'html';
		//$this->email->initialize($config);
		

		/*
		$this->email->from($this->config->item('email'), $this->config->item('company_name'));
		$this->email->to($save['email']);
		$this->email->bcc($this->config->item('email'));
		$this->email->subject($row['subject']);
		$this->email->message(html_entity_decode($row['content']));
		
		$this->email->send();
		*/
		
		$row ['content'] = html_entity_decode ( $row ['content'] );
		
		// Edit message model
		// Build our DOMDocument, and load our HTML
		$doc = new DOMDocument ();
		//$doc->loadHTML('<?xml encoding="UTF-8"><div>'.$row['content'].'</div>');
		@$doc->loadHTML ( '<meta http-equiv="content-type" content="text/html; charset=utf-8"><div>' . $row ['content'] . '</div>' );
		//$doc->loadHTML('<div>'.$row['content'].'</div>');
		

		// Preserve a reference to our DIV container
		$div = $doc->getElementsByTagName ( "div" )->item ( 0 );
		
		// New-up an instance of our DOMXPath class
		$xpath = new DOMXPath ( $doc );
		
		// Find all elements whose class attribute has test2
		$elements = $xpath->query ( "//*[contains(@class,'radactor-cn-logo')]" );
		
		// Cycle over each, remove attribute 'class'
		foreach ( $elements as $element ) {
			// Empty out the class attribute value
			// $element->attributes->getNamedItem("class")->nodeValue = '';
			// Or remove the attribute entirely
			// $element->removeAttribute("class");
			

			$element->parentNode->removeChild ( $element );
		}
		
		$doc->encoding = 'UTF-8';
		
		// Output the HTML of our container
		$row ['content'] = $doc->saveHTML ( $div );
		
		$row ['content'] = $this->load->view ( 'subscribe_email_header', $this->data, true ) . $row ['content'] . $this->load->view ( 'order_email_footer', $this->data, true );
		
		/*//////////////////////////////////////////// CONFIRMATION EMAIL THRU MANDRILL SMTP ///////////////////////////////////////////*/
		
		$config_phpmailer ['Host'] = "ssl://smtp.googlemail.com";
		$config_phpmailer ['Port'] = "465";
		//$config_phpmailer['Port'] 				= "587"; //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$config_phpmailer ['SMTPSecure'] = "tls";
		$config_phpmailer ['Username'] = "inoescherer@gmail.com";
		$config_phpmailer ['Password'] = "85andinoui";
		$config_phpmailer ['SMTPAuth'] = true;
		$config_phpmailer ['Timeout'] = "5";
		
		$phpmailer_data ['ToEmail'] = $config_phpmailer ['Username'];
		
		$phpmailer_data ['ToName'] = 'Inoe Scherer';
		$phpmailer_data ['FromName'] = $this->config->item ( 'company_name' );
		$phpmailer_data ['From'] = $this->config->item ( 'email' );
		$phpmailer_data ['addCC'] = $this->config->item ( 'email_contact' );
		$phpmailer_data ['Subject'] = $row ['subject'];
		$phpmailer_data ['Body'] = $row ['content'];
		
		$this->email->init_php_mailer_email ( $config_phpmailer, true );
		$this->email->send_php_mailer_email ( $phpmailer_data, true );
	
	}
}

/* End of file hauth.php */
/* Location: ./application/controllers/hauth.php */
