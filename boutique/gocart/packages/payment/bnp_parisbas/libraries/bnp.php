<?php
/**
 * Class  BNP
 *
 * @version 1.0
 * @author Inoe Scherer - http://www.flexiness.com
 * @copyright (C) 2013 Inoe Scherer
 * @see  http://www.php-suit.com/paypal
 * 20.01.2013 20:30:40
 
 ** Mofified for compatibility with GoCart, by Flexiness
 
 */

/*
* Copyright (c) 2023 Inoe Scherer - http://www.flexiness.com
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*     * Redistributions of source code must retain the above copyright
*       notice, this list of conditions and the following disclaimer.
*     * Redistributions in binary form must reproduce the above copyright
*       notice, this list of conditions and the following disclaimer in the
*       documentation and/or other materials provided with the distribution.
*     * Neither the name of the <organization> nor the
*       names of its contributors may be used to endorse or promote products
*       derived from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY MARTIN MALY ''AS IS'' AND ANY
* EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
* DISCLAIMED. IN NO EVENT SHALL MARTIN MALY BE LIABLE FOR ANY
* DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
* (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
* LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
* ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
* SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

class Bnp {
	
	private $API_USERNAME;
	private $API_PASSWORD;
	private $API_SIGNATURE;
	
	private $RETURN_URL;
	private $CANCEL_URL;
	
	private $currency;
	private $gate;
	private $CI;
	
	function __construct() {
		
		$this->CI = & get_instance ();
		$this->CI->load->library ( array ('session' ) );
		
		// retrieve settings
		if ($settings = $this->CI->Settings_model->get_settings ( 'mercanet_atos' )) {
			$this->API_USERNAME = $settings ['username'];
			$this->API_PASSWORD = $settings ['password'];
			$this->API_SIGNATURE = $settings ['signature'];
			
			$this->RETURN_URL = $settings ["return_url"];
			$this->CANCEL_URL = $settings ["cancel_url"];
			
			$this->currency = $settings ['currency'];
			
			if ($settings ['SANDBOX']) {
				// Test mode?
				if ($settings ['SANDBOX'] == '1') {
					//sandbox
					$this->gate = 'http://clairetnathalie.com/php/scripts/paiement/call_request_cn.php?';
				} else {
					//live
					$this->gate = 'http://clairetnathalie.com/php/scripts/paiement/call_request_cn.php?';
				}
			} else {
				$this->gate = 'http://clairetnathalie.com/php/scripts/paiement/call_request_cn.php?';
			}
		}
	}
	
	public function doBnpCheckout($total, $quid_2, $customer_email, $customer_id, $ip_address, $product_data) {
		
		if ($this->CI->session->userdata ( 'currency' ) == 'EUR') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( $total, 2, '.', '' ) ) ) );
			
			$currency_code = 978;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'USD') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 840;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'CHF') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 756;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'GBP') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 826;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'CAD') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 124;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'JPY') {
			$total = round ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 0 );
			
			$currency_code = 392;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'MXN') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 484;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'TRY') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 949;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'AUD') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 036;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'NZD') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 574;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'NOK') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 578;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'BRL') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 986;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'ARS') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 032;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'KHR') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 116;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'TWD') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 901;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'SEK') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 752;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'DKK') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 208;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'KRW') {
			$total = round ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 0 );
			
			$currency_code = 410;
		} elseif ($this->CI->session->userdata ( 'currency' ) == 'SGD') {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( ($total * $this->CI->session->userdata ( 'currency_rate' )), 2, '.', '' ) ) ) );
			
			$currency_code = 702;
		} else {
			$total = intval ( preg_replace ( '/\./', '', strval ( number_format ( $total, 2, '.', '' ) ) ) );
			
			$currency_code = 978;
		}
		
		//$product_data = json_encode($product_data);
		$product_data = urlencode ( json_encode ( $product_data ) );
		
		$session_lang_scope = $this->CI->session->userdata ( 'lang_scope' );
		
		if ($session_lang_scope == 'fr') {
			$lang_scope = 'fr';
		} elseif ($session_lang_scope == 'en') {
			$lang_scope = 'en';
		} elseif ($session_lang_scope == 'it') {
			$lang_scope = 'it';
		} elseif ($session_lang_scope == 'es') {
			$lang_scope = 'sp';
		} elseif ($session_lang_scope == 'de') {
			$lang_scope = 'ge';
		} else {
			$lang_scope = 'en';
		}
		
		///*
		$Curl_Session = curl_init ( 'http://clairetnathalie.com/php/scripts/paiement/call_request_cn.php' );
		curl_setopt ( $Curl_Session, CURLOPT_POST, 1 );
		curl_setopt ( $Curl_Session, CURLOPT_POSTFIELDS, "cn_amount=$total&cn_order_id=$quid_2&cn_customer_id=$customer_id&cn_customer_email=$customer_email&cn_mercanet_currency_code=$currency_code&cn_ip_address=$ip_address&cn_product_data=$product_data&cn_language=$lang_scope" );
		//curl_setopt ($Curl_Session, CURLOPT_FOLLOWLOCATION, 1);
		$response = curl_exec ( $Curl_Session );
		curl_close ( $Curl_Session );
		
		//print_r_html($response);
		

		if ($response == 1) {
			die ();
		} else {
			return 'failure';
		}
	
		//*/
	

	/*
		header('Location: '.$this->gate.'cn_amount='.urlencode($total).'&cn_order_id='.urlencode($quid_2).'&cn_customer_id='.urlencode($customer_id).'&cn_customer_email='.urlencode($customer_email).'&cn_mercanet_currency_code='.urlencode($currency_code).'');
		die();
		*/
	
	/*
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// YOU MUST USE RELATIVE PATHS HERE IF ZEND LIBRARY IS INITIATED WITHIN END CONTROLLER AT amf_config.ini
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$cn_amount = $total;
		
		$cn_order_id = $quid_2;
		
		$cn_customer_id = $customer_id;
		
		$cn_customer_email = $customer_email;
		
		$cn_mercanet_currency_code = $currency_code;
		
		print ("<HTML><HEAD><TITLE>MERCANET - Paiement Securise sur Internet</TITLE></HEAD>");
		print ("<BODY bgcolor=#ffffff>");
		print ("<Font color=#000000>");
		print ("<center><H1>MOM TO MOM - MERCANET - Paiement Securise sur Internet</H1></center><br><br>");
	
	
		//		Affectation des param�tres obligatoires
		
		//$webroot = $_SERVER['DOCUMENT_ROOT'];
	
		$parm="merchant_id=052535545900013";
		$parm="$parm merchant_country=fr";
		$parm="$parm amount=$cn_amount";
		$parm="$parm currency_code=$cn_mercanet_currency_code";
	
	
		// Initialisation du chemin du fichier pathfile (� modifier)
		    //   ex :
		    //    -> Windows : $parm="$parm pathfile=c:/repertoire/pathfile";
		    //    -> Unix    : $parm="$parm pathfile=/home/repertoire/pathfile";
		    
		//$parm="$parm pathfile=/var/paiement_sec/mercanet/param/pathfile";
		$parm="$parm pathfile=../../../paiement_sec/mercanet/param/pathfile";
	
		//		Si aucun transaction_id n'est affect�, request en g�n�re
		//		un automatiquement � partir de heure/minutes/secondes
		//		R�f�rez vous au Guide du Programmeur pour
		//		les r�serves �mises sur cette fonctionnalit�
		//
		//		$parm="$parm transaction_id=123456";
		
		
		//$cleansedstring = pregreplace('[\D]', '', $cn_order_id);
		//$cleansedstring = pregreplace("/\d/", "", $cn_order_id);
		//$cleansedstring = ereg_replace("[^0-9]", "", $cn_order_id);
		$cleansedstring = preg_replace("/[^0-9]/", "", $cn_order_id);
		$shortstring = substr($cleansedstring,0,6);
		$parm="$parm transaction_id=$shortstring";
	
		//		Affectation dynamique des autres param�tres
		// 		Les valeurs propos�es ne sont que des exemples
		// 		Les champs et leur utilisation sont expliqu�s dans le Dictionnaire des donn�es
		//
		// 		$parm="$parm normal_return_url=http://www.maboutique.fr/cgi-bin/call_response.php";
		//		$parm="$parm cancel_return_url=http://www.maboutique.fr/cgi-bin/call_response.php";
		//		$parm="$parm automatic_response_url=http://www.maboutique.fr/cgi-bin/call_autoresponse.php";
		//		$parm="$parm language=fr";
		//		$parm="$parm payment_means=CB,2,VISA,2,MASTERCARD,2";
		//		$parm="$parm header_flag=no";
		//		$parm="$parm capture_day=";
		//		$parm="$parm capture_mode=";
		//		$parm="$parm bgcolor=";
		//		$parm="$parm block_align=";
		//		$parm="$parm block_order=";
		//		$parm="$parm textcolor=";
		//		$parm="$parm receipt_complement=";
		//		$parm="$parm caddie=mon_caddie";
		//		$parm="$parm customer_id=";
		//		$parm="$parm customer_email=";
		//		$parm="$parm customer_ip_address=";
		//		$parm="$parm data=";
		//		$parm="$parm return_context=";
		//		$parm="$parm target=";
		//		$parm="$parm order_id=";
	
		$parm="$parm normal_return_url=https://clairetnathalie.com/bnp_gate/bnp_return/shopping-cart/html?order_id=$cn_order_id";
		$parm="$parm cancel_return_url=https://clairetnathalie.com/bnp_gate/bnp_cancel/shopping-cart/html?order_id=$cn_order_id";
		//$parm="$parm normal_return_url=http://clairetnathalie.com/php/scripts/paiement/call_response.php";
		//$parm="$parm cancel_return_url=http://clairetnathalie.com/php/scripts/paiement/call_response.php";
		//$parm="$parm normal_return_url=http://clairetnathalie.com/php/scripts/paiement/call_autoresponse.php";
		//$parm="$parm cancel_return_url=http://clairetnathalie.com/php/scripts/paiement/call_autoresponse.php";
		$parm="$parm automatic_response_url=http://clairetnathalie.com/php/scripts/paiement/call_autoresponse_gocart.php";
		$parm="$parm language=fr";
		$parm="$parm payment_means=CB,2,VISA,2,MASTERCARD,2";
		$parm="$parm header_flag=yes";
		$parm="$parm capture_day=0";
		$parm="$parm capture_mode=AUTHOR_CAPTURE";
		//$parm="$parm bgcolor=";
		$parm="$parm block_align=center";
		//$parm="$parm block_order=";
		//$parm="$parm textcolor=";
		//$parm="$parm receipt_complement=";
		//$parm="$parm caddie=mon_caddie";
		$parm="$parm customer_id=$cn_customer_id";
		$parm="$parm customer_email=$cn_customer_email";
		//$parm="$parm customer_ip_address=";
		//$parm="$parm data=";
		//$parm="$parm return_context=";
		$parm="$parm target=_self";
		$parm="$parm order_id=$cn_order_id";
	
		//		Les valeurs suivantes ne sont utilisables qu'en pr�-production
		//		Elles n�cessitent l'installation de vos fichiers sur le serveur de paiement
		//
		// 		$parm="$parm normal_return_logo=";
		// 		$parm="$parm cancel_return_logo=";
		// 		$parm="$parm submit_logo=";
		// 		$parm="$parm logo_id=";
		// 		$parm="$parm logo_id2=";
		$parm="$parm advert=logo_banner.png";
		// 		$parm="$parm background_id=";
		//		$parm="$parm templatefile=";
	
	
		//		insertion de la commande en base de donn�es (optionnel)
		//		A d�velopper en fonction de votre syst�me d'information
	
		// Initialisation du chemin de l'executable request (� modifier)
		// ex :
		// -> Windows : $path_bin = "c:/repertoire/bin/request";
		// -> Unix    : $path_bin = "/home/repertoire/bin/request";
		//
	
		//$path_bin = "/var/www/vhosts/clairetnathalie.com/cgi-bin/mercanet/request";
		$path_bin = "../cgi-bin/mercanet/request";
	
	
		//	Appel du binaire request
		// La fonction escapeshellcmd() est incompatible avec certaines options avanc�es
	  	// comme le paiement en plusieurs fois qui n�cessite  des caract�res sp�ciaux 
	  	// dans le param�tre data de la requ�te de paiement.
	  	// Dans ce cas particulier, il est pr�f�rable d.ex�cuter la fonction escapeshellcmd()
	  	// sur chacun des param�tres que l.on veut passer � l.ex�cutable sauf sur le param�tre data.
		$parm = escapeshellcmd($parm);	
		$result=exec("$path_bin $parm");
	
		//	sortie de la fonction : $result=!code!error!buffer!
		//	    - code=0	: la fonction g�n�re une page html contenue dans la variable buffer
		//	    - code=-1 	: La fonction retourne un message d'erreur dans la variable error
	
		//On separe les differents champs et on les met dans une variable tableau
	
		$tableau = explode ("!", "$result");
	
		//	r�cup�ration des param�tres
	
		$code = $tableau[1];
		$error = $tableau[2];
		$message = $tableau[3];
	
		//  analyse du code retour
	
	   if (( $code == "" ) && ( $error == "" ) )
	 	{
	  	print ("<BR><CENTER>erreur appel request</CENTER><BR>");
	  	print ("executable request non trouve $path_bin");
	 	}
	
		//	Erreur, affiche le message d'erreur
	
		else if ($code != 0){
			print ("<center><b><h2>Erreur appel API de paiement.</h2></center></b>");
			print ("<br><br><br>");
			print (" message erreur : $error <br>");
		}
	
		//	OK, affiche le formulaire HTML
		else {
			print ("<br><br>");
			
			# OK, affichage du mode DEBUG si activ�
			print (" $error <br>");
			
			print ("  $message <br>");
		}
	
		print ("</BODY></HTML>");
		*/
	}
}