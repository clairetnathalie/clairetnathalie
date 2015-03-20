<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * MojoMotor - by EllisLab
 *
 * @package		MojoMotor
 * @author		MojoMotor Dev Team
 * @copyright	Copyright (c) 2003 - 2012, EllisLab, Inc.
 * @license		http://mojomotor.com/user_guide/license.html
 * @link		http://mojomotor.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------


/**
 * MojoMotor Controller Class
 *
 * @package		MojoMotor
 * @subpackage	Core Library
 * @category	Controllers
 * @author		EllisLab Dev Team
 * @link		http://mojomotor.com
 */
class Mojomotor_Controller extends CI_Controller {
	
	var $CI;
	
	var $config_fb;
	var $config_mc;
	
	var $data = array ();
	var $errors = array ();
	var $success = array ();
	
	var $closing_output = '';
	
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct() {
		parent::__construct ();
		
		$this->load->database ();
		
		$this->load->helper ( array ('url', 'form' ) );
		$this->load->model ( array ('page_model', 'member_model', 'layout_model', 'site_model' ) );
		
		// Some of the libs depend on the models, so load them second.
		$this->load->library ( 'parser' );
		$this->load->library ( 'cp' );
		
		$this->load->vars ( array ('group_id' => $this->session->userdata ( 'group_id' ) ) );
		
		// Global control of profiler
		$this->output->enable_profiler ( $this->config->item ( 'show_profiler' ) );
	}
	
	// --------------------------------------------------------------------
	

	/**
	 * Closing Output
	 *
	 * MojoMotor allows for content to be stored and appended to the output
	 * stream. This function is analogous to append_output(), only for closing
	 * data.
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function closing_output($output = '') {
		$this->closing_output .= $output;
	}
	
	function _herewego() {
		$this->CI = & get_instance ();
		$this->CI->load->library ( 'session' );
		$this->CI->config->load ( 'facebook', TRUE );
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->config_fb = $this->CI->config->item ( 'facebook' );
		$this->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		// Data to be used by our CodeIgniter view.
		$this->data ['fb_appId'] = $this->config_fb ['appId'];
		
		$this->load->library ( 'facebook', $this->config_fb, 'facebook' );
	}
	
	function envoyer() {
		$this->errors = array ();
		$this->success = array ();
		
		$this->_validateFormContactUs ();
		
		// Were there any errors?
		if (count ( $this->errors ) > 0) {
			$this->data ['error_notifications'] = $this->notificationString ( $this->errors );
		} else {
			if ($_POST ['NEWSLETTER'] == 1) {
				$this->_sentMandrill ( $_POST ['LNAME'], $_POST ['FNAME'], $_POST ['EMAIL'], $_POST ['MESSAGE'] ['SUJET'], $_POST ['MESSAGE'] ['BODY'], $_POST ['COPY'] );
				$this->_subscribeMailChimp ( $_POST ['LNAME'], $_POST ['FNAME'], $_POST ['EMAIL'] );
				
				$this->data ['success_notifications'] = $this->notificationString ( $this->success );
			} else {
				$this->_sentMandrill ( $_POST ['LNAME'], $_POST ['FNAME'], $_POST ['EMAIL'], $_POST ['MESSAGE'] ['SUJET'], $_POST ['MESSAGE'] ['BODY'], $_POST ['COPY'] );
				
				$this->data ['success_notifications'] = $this->notificationString ( $this->success );
			}
		}
		
		$this->index ();
	}
	
	function _validateFormContactUs() {
		//BEGIN CONFIG
		// Define which values we are to accept from the form. If you add additional 
		// fields to the form, make sure to add the form name values here.
		$allowedFields = array ('LNAME', 'FNAME', 'EMAIL', 'SUJET', 'MESSAGE', 'COPY', 'NEWSLETTER', 'submit' );
		// Specify the required form fields. The key is the field name and the value 
		// is the error message to display.
		$requiredFields = array ()//example 'join_newsletter' => 'Veuillez cocher cette case.',
		;
		//END CONFIG
		

		//BEGIN FORM VALIDATION
		//////////////////////////////// Code to validate LNAME ////////////////////////////////////
		if (! empty ( $_POST ['LNAME'] )) {
			if (strlen ( $_POST ['LNAME'] ) > 70) {
				$this->errors [] = $this->lang->line ( 'contact_form_lname_error_1' ); //"Votre nom est trop long. Ce champ requiert une chaîne qui ne soit pas plus de 70 caractères en longeur";
			} else {
				if (! preg_match ( "/^[\-a-zA-Z\s\.]*$/i", $_POST ['LNAME'] )) {
					$this->errors [] = $this->lang->line ( 'contact_form_lname_error_2' ); //"L'entrée que vous avez saisi pour votre nom contient des caractères non permis. Ce champ accepte seulement des lettres en minuscules ou majuscules";
				}
			}
		} else {
			$this->errors [] = $this->lang->line ( 'contact_form_lname_error_3' ); //"Veuillez saisir votre nom.";
		}
		
		//////////////////////////////// Code to validate FNAME ////////////////////////////////////
		if (! empty ( $_POST ['FNAME'] )) {
			if (strlen ( $_POST ['FNAME'] ) > 70) {
				$this->errors [] = $this->lang->line ( 'contact_form_fname_error_1' ); // "Votre prénom est trop long. Ce champ requiert une chaîne qui ne soit pas plus de 70 caractères en longeur.";
			} else {
				if (! preg_match ( "/^[\-a-zA-Z\s\.]*$/i", $_POST ['FNAME'] )) {
					$this->errors [] = $this->lang->line ( 'contact_form_fname_error_2' ); // "L'entrée que vous avez saisi pour votre prénom contient des caractères non permis. Ce champ accepte seulement des lettres en minuscules ou majuscules";
				}
			}
		} else {
			$this->errors [] = $this->lang->line ( 'contact_form_fname_error_3' ); // "Veuillez saisir votre prénom.";
		}
		
		//////////////////////////////// Code to validate EMAIL ////////////////////////////////////
		if (! empty ( $_POST ['EMAIL'] )) {
			if (! preg_match ( '/localhost/', current_url () )) {
				if ($this->_check_email ( $_POST ['EMAIL'] ) == false) {
					$this->errors [] = $this->lang->line ( 'contact_form_email_addr_error_1' ); //"Cette adresse email n'est pas valide. Désolé"; 
				}
			}
		} else {
			$this->errors [] = $this->lang->line ( 'contact_form_email_addr_error_2' ); //"Nous avons besoin de votre adresse email pour vous contacter."; 
		}
		
		//////////////////////////////// Code to validate SUJET ////////////////////////////////////
		if (! empty ( $_POST ['MESSAGE'] ['SUJET'] )) {
			if (strlen ( $_POST ['MESSAGE'] ['SUJET'] ) <= 0) {
				$this->errors [] = "Veuillez attribuer un sujet à votre message.";
			}
		} else {
			$this->errors [] = "Le champ sujet ne doit être vide.";
		}
		
		//////////////////////////////// Code to validate MESSAGE ////////////////////////////////////
		if (! empty ( $_POST ['MESSAGE'] ['BODY'] )) {
			if (strlen ( $_POST ['MESSAGE'] ['BODY'] ) <= 0) {
				$this->errors [] = "Veuillez attribuer un corps de texte à votre message.";
			}
		} else {
			$this->errors [] = "Le champ message ne doit être vide.";
		}
	
		//END FORM VALIDATION
	}
	
	function notificationString($alerts) {
		$alertString = '<ul>';
		foreach ( $alerts as $alert ) {
			$alertString .= "<li>$alert</li>";
		}
		$alertString .= '</ul>';
		return $alertString;
	}
	
	function _validateFormSignUpToNewsletter() {
	
	}
	
	function _check_email($email) {
		if (preg_match ( '/^\w[-.\w]*@(\w[-._\w]*\.[a-zA-Z]{2,}.*)$/', $email, $matches )) {
			if (function_exists ( 'checkdnsrr' )) {
				if (checkdnsrr ( $matches [1] . '.', 'MX' ))
					return true;
				if (checkdnsrr ( $matches [1] . '.', 'A' ))
					return true;
			} else {
				if (! empty ( $hostName )) {
					if ($recType == '')
						$recType = "MX";
					exec ( "nslookup -type=$recType $hostName", $result );
					foreach ( $result as $line ) {
						if (eregi ( "^$hostName", $line )) {
							return true;
						}
					}
					return false;
				}
				return false;
			}
		}
		return false;
	}
	
	function _sentMandrill($senderSurname, $senderFirstname, $senderEmail, $subjectEmail, $bodyEmail, $copyEmail) {
		if (! preg_match ( '/localhost/', current_url () )) {
			if ($copyEmail == 1) {
				$this->load->library ( 'mandrill' );
				Mandrill::setApiKey ( $this->config_mc ['mandrill_apikey'] );
				
				$arr = array ('type' => 'messages', 'call' => 'send', 'message' => array ('html' => $bodyEmail, 'text' => $bodyEmail, 'subject' => $subjectEmail, 'from_email' => $this->config_mc ['mandrill_SMTP_Username'], 'from_name' => 'Couettabra mgm', 'to' => array (0 => array ('email' => $senderEmail, 'name' => $senderSurname . ' ' . $senderFirstname ) ), 'headers' => array (), 'track_opens' => true, 'track_clicks' => true, 'auto_text' => true, 'url_strip_qs' => true, 'tags' => array ("nous_contacter" ), 'google_analytics_domains' => array ("couettabra.com", "maison-gueneau-mauger.com" ), 'google_analytics_campaign' => array ("nous_contacter" ), 'metadata' => array () ) );
				
				//Because json_encode() only deals with utf8, it is often necessary to convert all the string values inside an array to utf8. 
				

				$request_json = json_encode ( $this->_utf8_encode_all ( $arr ) );
				
				// tests
				//echo json_encode($arr);
				//$request_json = '{"type":"messages","call":"send","message":{"html": "<h1>example html</h1>", "text": "example text", "subject": "example subject", "from_email": "wes@werxltd.com", "from_name": "example from_name", "to":[{"email": "wes@reasontostand.org", "name": "Wes Widner"}],"headers":{"...": "..."},"track_opens":true,"track_clicks":true,"auto_text":true,"url_strip_qs":true,"tags":["test","example","sample"],"google_analytics_domains":["werxltd.com"],"google_analytics_campaign":["..."],"metadata":["..."]}}';
				

				$ret = Mandrill::call ( ( array ) json_decode ( $request_json ) );
				
				$this->load->library ( 'email' );
				$config ['mailtype'] = 'html';
				$this->email->initialize ( $config );
				
				$this->email->from ( $senderEmail, $senderSurname . ' ' . $senderFirstname );
				
				$this->email->to ( $this->config_mc ['mandrill_SMTP_Username'] );
				//$this->email->cc('another@another-example.com');  
				//$this->email->bcc('them@their-example.com'); 
				

				$this->email->subject ( $subjectEmail );
				$this->email->message ( $bodyEmail );
				
				$this->email->send ();
			} else {
				$this->load->library ( 'email' );
				$config ['mailtype'] = 'html';
				$this->email->initialize ( $config );
				
				$this->email->from ( $senderEmail, $senderSurname . ' ' . $senderFirstname );
				
				$this->email->to ( $this->config_mc ['mandrill_SMTP_Username'] );
				//$this->email->cc('another@another-example.com');  
				//$this->email->bcc('them@their-example.com'); 
				

				$this->email->subject ( $subjectEmail );
				$this->email->message ( $bodyEmail );
				
				$this->email->send ();
			}
		}
		
		$this->success [] = "Votre email a été envoyé";
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
	
	function _subscribeMailChimp($senderSurname, $senderFirstname, $senderEmail) {
		if (! preg_match ( '/localhost/', current_url () )) {
			$mc_config = array ('apikey' => $this->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
			
			$this->load->library ( 'mailchimp/MCAPI', $mc_config, 'mail_chimp' );
			
			$merge_vars = array ('LNAME' => "$senderSurname", 'FNAME' => "$senderFirstname", 'EMAIL' => "$senderEmail" );
			
			$email_type = 'html';
			$double_optin = true;
			$update_existing = false;
			$replace_interests = true;
			$send_welcome = false;
			
			if ($this->mail_chimp->listSubscribe ( $this->config_mc ['mailchimp_list_id'], $senderEmail, $merge_vars, $email_type, $double_optin, $update_existing, $replace_interests, $send_welcome )) {
				$this->success [] = "Vous êtes désormais inscrit à notre newsletter";
			}
		}
	}

}

/* End of file Mojomotor_Controller.php */
/* Location: system/mojomotor/core/Mojomotor_Controller.php */