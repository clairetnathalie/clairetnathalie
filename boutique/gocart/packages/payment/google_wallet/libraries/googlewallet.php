<?php
/**
 * Class  PayPal
 *
 * @version 1.0
 * @author Martin Maly - http://www.php-suit.com
 * @copyright (C) 2008 martin maly
 * @see  http://www.php-suit.com/paypal
 * 2.10.2008 20:30:40
 
 ** Mofified for compatibility with GoCart, by Clear Sky Designs
 *** Mofified for compatibility with GoCart & Google Wallet, by Inoe Scherer
 
 */

/*
* Copyright (c) 2008 Martin Maly - http://www.php-suit.com
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

// Point to the correct directory
//chdir("..");
// Include all the required files
require_once (FCPATH . 'php/google_checkout/library/googlecart.php');
require_once (FCPATH . 'php/google_checkout/library/googleitem.php');
require_once (FCPATH . 'php/google_checkout/library/googleshipping.php');
require_once (FCPATH . 'php/google_checkout/library/googletax.php');

//The path is relative to your main site index.php file, NOT your controller or view files. 
//CodeIgniter uses a front controller so paths are always relative to the main site index.


class GoogleWallet {
	
	private $API_USERNAME;
	private $API_MERCHANT_KEY;
	private $API_MERCHANT_ID;
	
	private $RETURN_URL;
	private $CANCEL_URL;
	
	private $environment;
	
	public $endpoint;
	public $host;
	private $gate;
	public $trigger_diagnosis;
	public $diagnosis;
	private $currency;
	private $CI;
	
	private $cart;
	private $cart_button;
	private $cart_serial;
	private $redirect_url;
	
	private $connection;
	private $mysqli;
	
	function __construct() {
		
		$this->endpoint = '';
		$this->cart_serial = 'void';
		$this->CI = & get_instance ();
		
		//$this->CI->output->enable_profiler(TRUE);
		

		// retrieve settings
		if ($settings = $this->CI->Settings_model->get_settings ( 'google_wallet' )) {
			$this->API_USERNAME = $settings ['username'];
			$this->API_MERCHANT_KEY = $settings ['merchant_key'];
			$this->API_MERCHANT_ID = $settings ['merchant_id'];
			
			$this->RETURN_URL = $settings ["return_url"];
			$this->CANCEL_URL = $settings ["cancel_url"];
			
			$this->currency = $settings ['currency'];
			
			$this->environment = $settings ['SANDBOX'];
			
			$this->trigger_diagnosis = false;
			
			// Test mode?
			if ($this->environment == '1') {
				//sandbox
				$this->diagnosis = 'https://sandbox.google.com/checkout/api/checkout/v2/merchantCheckout/Merchant/' . $this->API_MERCHANT_ID . '/diagnose';
				
				$this->host = 'https://sandbox.google.com/checkout/api/checkout/v2/merchantCheckout/Merchant/' . $this->API_MERCHANT_ID;
			} else {
				$this->diagnosis = 'https://checkout.google.com/api/checkout/v2/merchantCheckout/Merchant/' . $this->API_MERCHANT_ID . '/diagnose';
				
				$this->host = 'https://checkout.google.com/api/checkout/v2/merchantCheckout/Merchant/' . $this->API_MERCHANT_ID;
			}
		}
		
		$this->connection = array ('host_db' => "localhost", // nom de votre serveur
'user_db' => "webmaster", // nom d'utilisateur de connexion ‡ votre bdd
'password_db' => "m0rebeer", // mot de passe de connexion ‡ votre bdd
'bdd_db' => "mom2mom_db" )// nom de votre bdd
;
	}
	
	/**
	 * @return string URL of the "success" page
	 */
	private function getReturnTo() {
		//return sprintf("%s://%s/".$this->RETURN_URL,
		//$this->getScheme(), $_SERVER['SERVER_NAME']);
		return site_url ( $this->RETURN_URL );
	}
	
	/**
	 * @return string URL of the "cancel" page
	 */
	private function getReturnToCancel() {
		//return sprintf("%s://%s/".$this->CANCEL_URL,
		//$this->getScheme(), $_SERVER['SERVER_NAME']);
		return site_url ( $this->CANCEL_URL );
	}
	
	/**
	 * @return HTTPRequest_gw
	 */
	private function response($merchant_id, $merchant_key, $Authorization_Key, $data) {
		//$r = new HTTPRequest_gw($this->host, $this->endpoint, 'POST', true);
		//$result = $r->connect($data);
		if ($this->environment == '1') {
			if ($this->trigger_diagnosis === true) {
				$result = $this->CI->httprequest_gw->connect_diagnosis ( $merchant_id, $merchant_key, $Authorization_Key, $data );
			} else {
				$result = $this->CI->httprequest_gw->connect ( $merchant_id, $merchant_key, $Authorization_Key, $data );
			}
		} else {
			if ($this->trigger_diagnosis === true) {
				$result = $this->CI->httprequest_gw->connect_diagnosis ( $merchant_id, $merchant_key, $Authorization_Key, $data );
			} else {
				$result = $this->CI->httprequest_gw->connect ( $merchant_id, $merchant_key, $Authorization_Key, $data );
			}
		}
		
		if ($this->trigger_diagnosis !== true) {
			if (! $result) {
				return false;
			} else {
				return $result;
			}
		}
	
	}
	
	/**
	 * Main payment function
	 * 
	 * If OK, the customer is redirected to PayPal gateway
	 * If error, the error info is returned
	 * 
	 * @param float $amount Amount (2 numbers after decimal point)
	 * @param string $desc Item description
	 * @param string $invoice Invoice number (can be omitted)
	 * @param string $currency 3-letter currency code (USD, GBP, CZK etc.)
	 * 
	 * @return array error info
	 */
	
	public function doExpressCheckout($total_amount, $total_items, $invoice_complete_ref, $invoice_quid_2, $cart_contents, $shipping_method, $delivery_company, $shipping_cost, $order_weight) {
		//Create a new shopping cart object
		$merchant_id = $this->API_MERCHANT_ID; // Your Merchant ID
		$merchant_key = $this->API_MERCHANT_KEY; // Your Merchant Key
		

		if ($this->environment == '1') {
			$server_type = "sandbox";
		} else {
			$server_type = "live";
		}
		
		$currency = 'USD'; //$this->currency;
		

		$this->cart = new GoogleCart ( $merchant_id, $merchant_key, $server_type, $currency );
		
		// Specify <edit-cart-url>
		//$this->cart->SetEditCartUrl(site_url('cart/view_cart'));
		

		// Specify "Return to xyz" link
		//$this->cart->SetContinueShoppingUrl(site_url('cart/view_cart'));
		

		// Add <merchant-private-data>
		$this->cart->SetMerchantPrivateData ( new MerchantPrivateData ( array ("quid_2" => $invoice_quid_2 ) ) );
		
		$this->cart->AddGoogleAnalyticsTracking ( 'UA-25854907-1' );
		
		$this->makeXMLItemData ( $this->cart, $cart_contents );
		
		$this->makeXMLShippingData ( $this->cart, $shipping_method, $shipping_cost, $delivery_company );
		
		/*
	    // Display XML data
		echo "<pre>";
		echo htmlentities($this->cart->GetXML());
		echo "</pre>";
		die();
	    */
		
		///*
		$Authorization_Key = base64_encode ( $merchant_id . ':' . $merchant_key );
		
		$result = $this->response ( $merchant_id, $merchant_key, $Authorization_Key, $this->cart->GetXML () );
		
		//echo $result;
		

		if (! $result) {
			$this->cart_serial = 'void';
			return 'void';
		} else {
			$response_xml = simplexml_load_string ( $result );
			$att = 'serial-number';
			$nodeValue = 'redirect-url';
			$gw_serial = ( string ) $response_xml->attributes ()->$att;
			$this->redirect_url = ( string ) $response_xml->$nodeValue;
			$this->cart_serial = $gw_serial;
			
			// Test Google Wallet Payment interface without processing order
			/*
			redirect($this->redirect_url);
			die();
			*/
			
			// Process Order
			return $this->redirect_url;
		}
	
		//*/
	}
	
	public function makeXMLItemData($what, $a) {
		foreach ( $a as $key => &$val ) {
			$categories = simplexml_load_string ( $val ['category_xml_navigation'] );
			$brand = $this->hexa ( $categories->marque [0] );
			$description = $this->hexa ( $val ['description'] );
			
			// Add items to the cart
			$item = new GoogleItem ( 'Mom To Mom | ' . 'Article ' . $val ['article_ID'] . ' | ' . $brand, // Item name
$description, // Item description
$val ['quantity'], // Quantity
($val ['saleprice'] != 0) ? $val ['saleprice'] : $val ['price'], // Unit price
'KG', $val ['weight'] ); // weight
			$item->SetMerchantItemId ( $val ['article_ID'] );
			$what->AddItem ( $item );
		}
	}
	
	public function makeXMLShippingData($what, $shipping_method, $shipping_cost, $delivery_company) {
		if ($shipping_method != 'No Shipping') {
			if (preg_match ( '/COLISSIMO/i', $shipping_method )) {
				$this->mysqli = new mysqli ( $this->connection ['host_db'], $this->connection ['user_db'], $this->connection ['password_db'], $this->connection ['bdd_db'] );
				
				//mysqli_set_charset($this->mysqli, "utf8");
				

				//// check connection ////
				if (mysqli_connect_errno ()) {
					printf ( "Connect failed: %s\n", mysqli_connect_error () );
					exit ();
				}
				
				if (preg_match ( '/COLISSIMO INT/i', $shipping_method )) {
					///*
					// Add shipping options
					$ship = new GoogleFlatRateShipping ( $this->hexa ( $shipping_method ), $shipping_cost );
					//*/
					

					/*
			    	// Add merchant calculations options
				    $what->SetMerchantCalculations(
				        site_url('checkout'), // merchant-calculations-url
				        "false", // merchant-calculated tax
				        "true",  // accept-merchant-coupons
				        "true"); // accept-merchant-gift-certificates
				
				    // Add merchant-calculated-shipping option
				    $ship = new GoogleMerchantCalculatedShipping($this->hexa($shipping_method), // Shippping method
				                                                 $shipping_cost);  // Default, fallback price
			    	*/
					
					$restriction = new GoogleShippingFilters ();
					//$address_filter = new GoogleShippingFilters();
					

					$restriction->SetAllowedWorldArea ( true );
					//$address_filter->SetAllowedWorldArea(true);
					

					if (preg_match ( '/COLISSIMO\sINT\sUSA\s\(ZONE\sC\)/i', $shipping_method )) {
						$restriction->SetAllowUsPoBox ( true );
						$restriction->SetAllowedCountryArea ( "CONTINENTAL_48" );
					
		//$address_filter->SetAllowUsPoBox(true);
					} else {
						$restriction->SetAllowUsPoBox ( false );
					
		//$address_filter->SetAllowUsPoBox(false);
					}
					
					$this_country_iso_3 = preg_replace ( '/COLISSIMO\sINT\s/i', '', preg_replace ( '/\s\(ZONE\s(A|B|C|D){1}\)/i', '', $shipping_method ) );
					
					$sql1 = "SELECT * FROM gc_fr_countries WHERE iso_code_3='$this_country_iso_3'";
					if ($result1 = mysqli_query ( $this->mysqli, $sql1 )) {
						while ( $row1 = $result1->fetch_assoc () ) {
							$this_country_iso_2 = $row1 ['iso_code_2'];
						}
						
						$restriction->AddAllowedPostalArea ( "$this_country_iso_2" );
					
		//$address_filter->AddAllowedPostalArea("$this_country_iso_2");
					}
					
					$ship->AddShippingRestrictions ( $restriction );
					//$ship->AddAddressFilters($address_filter);
					$what->AddShipping ( $ship );
				}
				
				if (preg_match ( '/COLISSIMO FRANCE/i', $shipping_method )) {
					///*
					// Add shipping options
					$ship = new GoogleFlatRateShipping ( $this->hexa ( $shipping_method ), $shipping_cost );
					//*/
					

					/*
			    	// Add merchant calculations options
				    $what->SetMerchantCalculations(
				        site_url('checkout'), // merchant-calculations-url
				        "false", // merchant-calculated tax
				        "true",  // accept-merchant-coupons
				        "true"); // accept-merchant-gift-certificates
				
				    // Add merchant-calculated-shipping option
				    $ship = new GoogleMerchantCalculatedShipping($this->hexa($shipping_method), // Shippping method
				                                                 $shipping_cost);  // Default, fallback price
			    	*/
					
					$restriction = new GoogleShippingFilters ();
					//$address_filter = new GoogleShippingFilters();
					

					$restriction->SetAllowedWorldArea ( false );
					$restriction->SetAllowUsPoBox ( false );
					//$address_filter->SetAllowedWorldArea(false);
					//$address_filter->SetAllowUsPoBox(false);
					

					$this_country_iso_3 = preg_replace ( '/COLISSIMO\sFRANCE\s/i', '', preg_replace ( '/REC\s/i', '', $shipping_method ) );
					
					$sql1 = "SELECT * FROM gc_fr_countries WHERE iso_code_3='$this_country_iso_3'";
					if ($result1 = mysqli_query ( $this->mysqli, $sql1 )) {
						while ( $row1 = $result1->fetch_assoc () ) {
							$this_country_iso_2 = $row1 ['iso_code_2'];
						}
						
						$restriction->AddAllowedPostalArea ( "$this_country_iso_2" );
					
		//$address_filter->AddAllowedPostalArea("$this_country_iso_2");
					}
					
					$ship->AddShippingRestrictions ( $restriction );
					//$ship->AddAddressFilters($address_filter);
					$what->AddShipping ( $ship );
				}
				
				if (preg_match ( '/COLISSIMO OUTRE-MER/i', $shipping_method )) {
					///*
					// Add shipping options
					$ship = new GoogleFlatRateShipping ( $this->hexa ( $shipping_method ), $shipping_cost );
					//*/
					

					/*
			    	// Add merchant calculations options
				    $what->SetMerchantCalculations(
				        site_url('checkout'), // merchant-calculations-url
				        "false", // merchant-calculated tax
				        "true",  // accept-merchant-coupons
				        "true"); // accept-merchant-gift-certificates
				
				    // Add merchant-calculated-shipping option
				    $ship = new GoogleMerchantCalculatedShipping($this->hexa($shipping_method), // Shippping method
				                                                 $shipping_cost);  // Default, fallback price
			    	*/
					
					$restriction = new GoogleShippingFilters ();
					//$address_filter = new GoogleShippingFilters();
					

					$restriction->SetAllowedWorldArea ( false );
					$restriction->SetAllowUsPoBox ( false );
					//$address_filter->SetAllowedWorldArea(false);
					//$address_filter->SetAllowUsPoBox(false);
					

					$this_country_iso_3 = preg_replace ( '/COLISSIMO\sOUTRE-MER\s/i', '', preg_replace ( '/REC\s/i', '', $shipping_method ) );
					
					$sql1 = "SELECT * FROM gc_fr_countries WHERE iso_code_3='$this_country_iso_3'";
					if ($result1 = mysqli_query ( $this->mysqli, $sql1 )) {
						while ( $row1 = $result1->fetch_assoc () ) {
							$this_country_iso_2 = $row1 ['iso_code_2'];
						}
						
						$restriction->AddAllowedPostalArea ( "$this_country_iso_2" );
					
		//$address_filter->AddAllowedPostalArea("$this_country_iso_2");
					}
					
					$ship->AddShippingRestrictions ( $restriction );
					//$ship->AddAddressFilters($address_filter);
					$what->AddShipping ( $ship );
				}
			} else if (preg_match ( '/coursier/i', $shipping_method )) {
				///*
				// Add shipping options
				$ship = new GoogleFlatRateShipping ( $this->hexa ( $shipping_method ), $shipping_cost );
				//*/
				

				/*
		    	// Add merchant calculations options
			    $what->SetMerchantCalculations(
			        site_url('checkout'), // merchant-calculations-url
			        "false", // merchant-calculated tax
			        "true",  // accept-merchant-coupons
			        "true"); // accept-merchant-gift-certificates
			
			    // Add merchant-calculated-shipping option
			    $ship = new GoogleMerchantCalculatedShipping($this->hexa($shipping_method), // Shippping method
			                                                 $shipping_cost);  // Default, fallback price
		    	*/
				
				$restriction = new GoogleShippingFilters ();
				//$address_filter = new GoogleShippingFilters();
				

				$restriction->SetAllowedWorldArea ( false );
				$restriction->SetAllowUsPoBox ( false );
				//$address_filter->SetAllowedWorldArea(false);
				//$address_filter->SetAllowUsPoBox(false);
				

				if (! preg_match ( '/\bbanlieu\b/i', $shipping_method )) {
					$restriction->AddAllowedPostalArea ( "FR", "75*" );
				
		//$address_filter->AddAllowedPostalArea("FR", "75*");
				} else {
					$restriction->AddAllowedPostalArea ( "FR", "77*" );
					$restriction->AddAllowedPostalArea ( "FR", "78*" );
					$restriction->AddAllowedPostalArea ( "FR", "91*" );
					$restriction->AddAllowedPostalArea ( "FR", "92*" );
					$restriction->AddAllowedPostalArea ( "FR", "93*" );
					$restriction->AddAllowedPostalArea ( "FR", "94*" );
					$restriction->AddAllowedPostalArea ( "FR", "95*" );
				
		//$address_filter->AddAllowedPostalArea("FR", "77*");
				//$address_filter->AddAllowedPostalArea("FR", "78*");
				//$address_filter->AddAllowedPostalArea("FR", "91*");
				//$address_filter->AddAllowedPostalArea("FR", "92*");
				//$address_filter->AddAllowedPostalArea("FR", "93*");
				//$address_filter->AddAllowedPostalArea("FR", "94*");
				//$address_filter->AddAllowedPostalArea("FR", "95*");
				}
				
				$ship->AddShippingRestrictions ( $restriction );
				//$ship->AddAddressFilters($address_filter);
				$what->AddShipping ( $ship );
			} else if ($shipping_method == '') {
				$ship = new GooglePickup ( "Pick Up", 0 );
				$what->AddShipping ( $ship );
			}
		} else {
			if (! preg_match ( '/(mom2mom)|(momtomom)|(mom 2 mom)|(mom to mom)/i', $delivery_company )) {
				redirect ( 'checkout' );
			} else {
				$ship = new GooglePickup ( "Pick Up", 0 );
				$what->AddShipping ( $ship );
			}
		}
	}
	
	public function hexa($input) {
		$patterns_description = array ("/\(/i", "/\)/i", "/\</i", "/\>/i", '/"/i', "/'/i", "/&/i", '/é/i', '/è/i', '/ê/i', '/ë/i', '/É/i', '/È/i', '/Ê/i', '/Ë/i', '/ï/i', '/î/i', '/Ï/i', '/Î/i', '/à/i', '/â/i', '/À/i', '/Â/i', '/ô/i', '/ö/i', '/Ô/i', '/Ö/i', '/ù/i', '/ü/i', '/û/i', '/Ù/i', '/Ü/i', '/ç/i', '/Ç/i' );
		$replacements_description = array ('&#x0028;', '&#x0029;', '&#x003C;', '&#x003E;', '&#x0022;', '&#x2019;', '&#x0026;', '&#x00E9;', '&#x00E8;', '&#x00EA;', '&#x00EB;', '&#x00C9;', '&#x00C8;', '&#x00CA;', '&#x00CB;', '&#x00EF;', '&#x00EE;', '&#x00CF;', '&#x00CE;', '&#x00E0;', '&#x00E2;', '&#x00C0;', '&#x00C2;', '&#x00F4;', '&#x00F6;', '&#x00D4;', '&#x00D6;', '&#x00F9;', '&#x00FC;', '&#x00FB;', '&#x00D9;', '&#x00DC;', '&#x00E7;', '&#x00C7;' );
		return preg_replace ( $patterns_description, $replacements_description, $input );
	}
	
	public function doPayment() {
		/*
		
		*/
	}
	
	private function getScheme() {
		$scheme = 'http';
		if (isset ( $_SERVER ['HTTPS'] ) and $_SERVER ['HTTPS'] == 'on') {
			$scheme .= 's';
		}
		return $scheme;
	}
	
	public function get_cart_serial() {
		return $this->cart_serial;
	}
	
	public function get_merchant_id() {
		$this->CI = & get_instance ();
		
		// retrieve settings
		if ($settings = $this->CI->Settings_model->get_settings ( 'google_wallet' )) {
			$communicate_API_MERCHANT_ID = $settings ['merchant_id'];
			return $communicate_API_MERCHANT_ID;
		
		}
	}
	
	public function get_merchant_key() {
		$this->CI = & get_instance ();
		
		// retrieve settings
		if ($settings = $this->CI->Settings_model->get_settings ( 'google_wallet' )) {
			$communicate_API_MERCHANT_KEY = $settings ['merchant_key'];
			return $communicate_API_MERCHANT_KEY;
		}
	}
	
	public function get_environment() {
		$this->CI = & get_instance ();
		
		// retrieve settings
		if ($settings = $this->CI->Settings_model->get_settings ( 'google_wallet' )) {
			$communicate_environment = $settings ['SANDBOX'];
			
			if ($communicate_environment == '1') {
				return "sandbox";
			} else {
				return "live";
			}
		}
	}
	
	public function get_currency() {
		$this->CI = & get_instance ();
		
		// retrieve settings
		if ($settings = $this->CI->Settings_model->get_settings ( 'google_wallet' )) {
			$communicate_currency = $settings ['currency'];
			return $communicate_currency;
		
		}
	}
	
	public function print_r_html($arr) {
		?><pre><?
		print_r ( $arr );
		?></pre><?
	}
}