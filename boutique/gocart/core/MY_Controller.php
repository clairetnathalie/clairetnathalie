<?php

/**
 * The base controller which is used by the Front and the Admin controllers
 */
class Base_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		
		// load the migrations class
		$this->load->library ( 'migration' );
		
		// Migrate to the latest migration file found
		if (! $this->migration->latest ()) {
			log_message ( 'error', 'The migration failed' );
		}
	
	} //end __construct()


} //end Base_Controller


class Front_Controller extends Base_Controller {
	
	//we collect the categories automatically with each load rather than for each function
	//this just cuts the codebase down a bit
	var $categories = '';
	
	//load all the pages into this variable so we can call it from all the methods
	var $pages = '';
	
	// determine whether to display gift card link on all cart pages
	//  This is Not the place to enable gift cards. It is a setting that is loaded during instantiation.
	var $gift_cards_enabled;
	
	var $data = array ();
	
	var $header = 'header';
	
	var $currency;
	var $mercanet_currency_code;
	var $rate;
	var $symbol;
	
	var $language = 'french';
	var $lang_scope = 'fr';
	
	var $locations_data = array ();
	
	var $status_fb_auth;
	var $fb_access_token;
	var $fb_user;
	var $fb_user_name;
	var $fb_user_id;
	var $fb_page_IDs;
	var $fb_app_secret;
	var $fb_app_link;
	var $facebook_default_scope;
	var $fb_user_resources;
	var $fb_status_fanpages;
	var $fb_status_apppage;
	var $fb_signed_request;
	
	var $compactor;
	
	function __construct() {
		
		parent::__construct ();
		
		//load needed models that don't require language settings set
		$this->load->model ( array ('Order_model', 'Settings_model', 'Currency_model', 'Social_model_fb' ) );
		
		$this->_herewego ();
		
		//load GoCart library
		//$this->load->library('Go_cart'); /* already in autoload */
		

		//load needed models that require language settings set first
		$this->load->model ( array ('Product_model', 'Digital_Product_model', 'Gift_card_model', 'Option_model', 'Page_model' ) );
		
		//load helpers
		$this->load->helper ( array ('form_helper', 'formatting_helper' ) );
		
		//////////////////////////////////////////////// CARABINER ////////////////////////////////////////////////
		

		$this->load->library ( 'carabiner' );
		
		//$this->carabiner->empty_cache('both');
		

		/////////////// JS ///////////////
		

		$script = array (array ('script.js-master/src/script.js' ) );
		
		$this->carabiner->group ( 'script_js', array ('js' => $script ) );
		
		/////////////// JS ///////////////
		

		$jquery = array (array ('jquery-1.10.2.min.js' ), array ('jquery.fitvids.js' ) )//,array('jquery-1.10.2.min.map')
		;
		
		$this->carabiner->group ( 'jquery_local', array ('js' => $jquery ) );
		
		/////////////// JS ///////////////
		

		$modnzer = array (array ('modnzer/modernizr.custom.98347.js' ) );
		
		$this->carabiner->group ( 'modnzer_js', array ('js' => $modnzer ) );
		
		/////////////// JS ///////////////
		

		$bootstrap_js = array (array ('bootstrap.min.js' ) );
		
		$this->carabiner->group ( 'bootstrap_js', array ('js' => $bootstrap_js ) );
		
		/////////////// JS ///////////////
		

		$gocart_js = array (array ('squard.js' ), array ('equal_heights.js' ), array ('actual-height/jquery.actual.min.js' ) );
		
		$this->carabiner->group ( 'gocart_js', array ('js' => $gocart_js ) );
		
		/////////////// JS ///////////////
		

		$google_js = array (array ('google/controller_ga_social_tracking.js' ) )//,array('google/conversion.js')
		//,array('http://www.googleadservices.com/pagead/conversion.js')
		;
		
		$this->carabiner->group ( 'google_js', array ('js' => $google_js ) );
		
		/////////////// JS ///////////////
		

		$social_js = array (array ('http://assets.pinterest.com/js/pinit.js' ), //,array('http://platform.tumblr.com/v1/share.js')
		//,array('http://platform.twitter.com/widgets.js')
		array ('https://apis.google.com/js/plusone.js?publisherid=108232619274893307463' ) );
		
		$this->carabiner->group ( 'social_js', array ('js' => $social_js ) );
		
		/////////////// CSS ///////////////
		

		$bootstrap_css = array (array ('bootstrap-cn.min.css' ), array ('bootstrap-responsive.min.css' ), //,array('http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css')
		array ('fonts.min.css' ), array ('styles.min.css' ), array ('social-buttons.min.css' ) );
		
		$this->carabiner->group ( 'bootstrap_css', array ('css' => $bootstrap_css ) );
		
		//$this->carabiner->css('http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css', 'screen', 'http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css', FALSE, TRUE, 'bootstrap_css');
		

		//////////////////////////////////////////////// COMPACTOR ////////////////////////////////////////////////
		

		require_once (APPPATH . 'libraries/compactor.php');
		
		/*
		$this->compactor = new Compactor(array(
			'buffer_echo' => false
		));
		*/
		
		$this->compactor = new Compactor ( array ('use_buffer' => false, 'buffer_echo' => false, 'compact_on_shutdown' => false, 'compress_scripts' => false, 'script_compression_callback' => 'minify' ) );
		
		//////////////////////////////////////////////// PROFILER ////////////////////////////////////////////////
		

		/*
		$this->CI =& get_instance();
		$this->CI->output->enable_profiler(TRUE);
		*/
		
		/*
		$sections = array(
		    'benchmarks' => TRUE,
			'controller_info' => TRUE,
			'http_headers' => TRUE,
		    'post' => TRUE,
			'get' => TRUE,
			'queries' => TRUE,
			'config' => TRUE,
			'session_data' => TRUE
		    );
		
		$this->CI =& get_instance();
		$this->CI->output->enable_profiler(TRUE);
		$this->CI->output->set_profiler_sections($sections);
		*/
		
		//$this->CI =& get_instance();
		//print_r_html($this->CI);
		

		date_default_timezone_set ( 'Europe/Paris' );
		
		//////////////////////////////////////////////// PROFILER ////////////////////////////////////////////////
		

		////////////////////////////////////////////////// CSRF //////////////////////////////////////////////////
		

		/*
		if(!preg_match('/localhost/', current_url()))
		{
			if (isset($_SERVER["REQUEST_URI"])) 
			{
				if(stripos($_SERVER["REQUEST_URI"],'/bnp_gate') === FALSE AND stripos($_SERVER["REQUEST_URI"],'/pp_gate') === FALSE)
			    {
			        $config['csrf_protection'] = TRUE;
			    }
			    else
			    {
			        $config['csrf_protection'] = FALSE;
			    } 
			} 
			else 
			{
			    $config['csrf_protection'] = TRUE;
			}
		}
		*/
		
		/*
		if(!preg_match('/localhost/', current_url()))
		{
			if( (!preg_match('/bnp_gate/', current_url())) && (!preg_match('/pp_gate/', current_url())) )
			{
		        $config['csrf_protection'] = TRUE;
		    }
		    else
		    {
		        $config['csrf_protection'] = FALSE;
		    }
		}
		else 
		{
			$config['csrf_protection'] = FALSE;
		}
		*/
		
		////////////////////////////////////////////////// CSRF //////////////////////////////////////////////////
		

		//fill in our variables
		$this->categories = $this->Category_model->get_categories_tierd ( 0 );
		$this->pages = $this->Page_model->get_pages ();
		
		// check if giftcards are enabled
		$gc_setting = $this->Settings_model->get_settings ( 'gift_cards' );
		if (! empty ( $gc_setting ['enabled'] ) && $gc_setting ['enabled'] == 1) {
			$this->gift_cards_enabled = true;
		} else {
			$this->gift_cards_enabled = false;
		}
		
		//load the theme package
		$this->load->add_package_path ( APPPATH . 'themes/' . $this->config->item ( 'theme' ) . '/' );
	}
	
	/*
	This works exactly like the regular $this->load->view()
	The difference is it automatically pulls in a header and footer.
	*/
	function view($view, $vars = array(), $string = false) {
		if ($string) {
			/*
			$result	 = $this->load->view('header', $vars, true);
			$result	.= $this->load->view($view, $vars, true);
			$result	.= $this->load->view('footer', $vars, true);
			*/
			
			return $this->load->view ( $view, $vars, true );
		} else {
			/*
			$this->load->view($this->header, $vars);
			$this->load->view($view, $vars);
			$this->load->view('footer', $vars);
			*/
			
			$this->load->view ( $view, $vars );
		}
	}
	
	/*
	This function simple calls $this->load->view()
	*/
	function partial($view, $vars = array(), $string = false) {
		if ($string) {
			return $this->load->view ( $view, $vars, true );
		} else {
			$this->load->view ( $view, $vars );
		}
	}
	
	function minify($code) {
		//require_once(APPPATH.'libraries/jsmin.php');
		//return trim(JSMin::minify($code));
		

		//require_once(APPPATH.'libraries/Minifier.php');
		//return trim(JShrink\Minifier::minify($code));
		

		return $code;
	}
	
	function compact_view($html) {
		echo $this->compactor->squeeze ( $html );
	}
	
	function _herewego() {
		if ($this->session->userdata ( 'page_count' ) === FALSE) {
			$this->session->set_userdata ( array ('page_count' => 0 ) );
		} else {
			$this->session->set_userdata ( array ('page_count' => $this->session->userdata ( 'page_count' ) + 1 ) );
		}
		
		$this->config->load ( 'facebook', TRUE );
		$this->config->load ( 'hybridauthlib', TRUE );
		$this->config->load ( 'mailchimp', TRUE );
		$this->config->load ( 'ip_location', TRUE );
		
		$this->config_fb = $this->config->item ( 'facebook' );
		$this->config_ha = $this->config->item ( 'hybridauthlib' );
		$this->config_mc = $this->config->item ( 'mailchimp' );
		$this->config_ip = $this->config->item ( 'ip_location' );
		
		// Data to be used by our CodeIgniter view.
		$this->data ['fb_appId'] = $this->config_fb ['appId'];
		$this->fb_page_IDs = $this->config_fb ['page_IDs'];
		
		$this->load->library ( 'facebook', $this->config_fb, 'facebook' );
		$this->load->library ( 'HybridAuthLib.php', $this->config_ha, 'hybridauthlib' );
		$this->load->library ( 'ip_location/ip2location_lite.php', $this->config_ip, 'ip_location' );
		
		///////////////////////////////////////////// PROFILE FACEBOOK ///////////////////////////////////////////// 
		

		$facebook_default_scope = $this->config->item ( 'facebook_default_scope' );
		
		$facebookJoinApp = $this->facebook->getLoginUrl ( array ('scope' => $this->config_fb ['facebook_default_scope'], //'redirect_uri' => 'https://www.facebook.com/pages/Couettabra/125326350915703',
		'redirect_uri' => preg_replace ( '/http:\/\//i', 'https://', site_url ( 'news' ) ), 'display' => 'page' )// popup or page. defaut is page
 );
		
		$this->data ['fb_join_app'] = $facebookJoinApp;
		
		if ($this->session->userdata ( 'fb_app_login_popup' ) == FALSE) {
			$fb_app_login_url = $this->facebook->getLoginUrl ( array ('scope' => $this->config_fb ['facebook_default_scope'], 'redirect_uri' => preg_replace ( '/http:\/\//i', 'https://', site_url ( 'secure/login' ) ), 'display' => 'popup' )// popup or page. defaut is page
 );
			
			$this->session->set_userdata ( 'fb_app_login_popup', $fb_app_login_url );
			$this->data ['fb_app_link'] = '<a href="' . $fb_app_login_url . '" class="highlight" style="text-decoration: none; cursor: pointer;font-weight:600;">Claire &amp; Nathalie</a>';
		} else {
			$this->data ['fb_app_link'] = '<a href="' . $this->session->userdata ( 'fb_app_login_popup' ) . '" class="highlight" style="text-decoration: none; cursor: pointer;font-weight:600;">Claire &amp; Nathalie</a>';
		}
		
		if (! preg_match ( '/(localhost|test\.clairetnathalie\.com)/', $_SERVER ["HTTP_HOST"] )) {
			$this->status_fb_auth = $this->_profile_auth_fb_user ();
		}
		
		///////////////////////////////////////////// PROFILE FACEBOOK /////////////////////////////////////////////
		

		parse_str ( substr ( strrchr ( urldecode ( $_SERVER ['REQUEST_URI'] ), "?" ), 1 ), $_GET );
		
		///////////////////////////////////////////////// CURRENCY /////////////////////////////////////////////////
		$this_merchant_id = false;
		
		if (count ( $_GET ) > 0) {
			//print_r($_GET);
			

			foreach ( $_GET as $field => $value ) {
				if ($field == 'merchant_id') {
					if ($value == sha1 ( 17252461 )) {
						$this_merchant_id = true;
					} else {
						$this_merchant_id = false;
					}
				} else {
					$this_merchant_id = false;
				}
			}
		}
		
		if ($this_merchant_id || $this->session->userdata ( 'currency' ) == FALSE) {
			$currency_session_data = array ();
			
			if (count ( $_GET ) > 0) {
				foreach ( $_GET as $field => $value ) {
					if ($field == 'currency') {
						$this->currency = strval ( $value );
						
						$this->mercanet_currency_code = $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency );
						$this->rate = $this->Currency_model->get_currency_rate ( $this->currency );
						$this->symbol = $this->Currency_model->get_currency_symbol ( $this->currency );
						
						if ($this->mercanet_currency_code != null || $this->rate != null || $this->symbol != null) {
							$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->mercanet_currency_code, 'currency_rate' => $this->rate, 'currency_symbol' => $this->symbol );
							
							if ($this->currency == 'USD') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'CHF') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'GBP') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'CAD') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'JPY') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 0;
							} elseif ($this->currency == 'MXN') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'TRY') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'AUD') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'NZD') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'NOK') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'BRL') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'ARS') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'KHR') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'TWD') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'SEK') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'DKK') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							} elseif ($this->currency == 'KRW') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 0;
							} elseif ($this->currency == 'SGD') {
								$currency_session_data ['currency_symbol_side'] = 'left';
								$currency_session_data ['currency_decimal_place'] = 2;
							}
						} else {
							$currency_session_data = array ('currency' => 'EUR', 'mercanet_currency_code' => 978, 'currency_rate' => 1, 'currency_symbol' => '€', 'currency_symbol_side' => 'right', 'currency_decimal_place' => 2 );
						}
					}
				}
			} else {
				if ($this->session->userdata ( 'currency' ) == FALSE) {
					if (! preg_match ( '/localhost/', $_SERVER ["HTTP_HOST"] )) {
						if (empty ( $this->locations_data )) {
							//Get errors and locations
							$ip_location_key = $this->config_ip ['apiKey'];
							$this->ip_location->setKey ( $ip_location_key );
							$this->locations_data = $this->ip_location->getCountry ( $_SERVER ['REMOTE_ADDR'] );
							$errors = $this->ip_location->getError ();
						
		//print_r_html('currency : '.$this->locations_data['countryCode']);
						}
						
						if (! empty ( $this->locations_data ) && $this->locations_data ['statusCode'] == 'OK') {
							if ($this->locations_data ['countryCode'] == 'AT' || $this->locations_data ['countryCode'] == 'BE' || $this->locations_data ['countryCode'] == 'CY' || $this->locations_data ['countryCode'] == 'EE' || $this->locations_data ['countryCode'] == 'FI' || $this->locations_data ['countryCode'] == 'FR' || $this->locations_data ['countryCode'] == 'DE' || $this->locations_data ['countryCode'] == 'GR' || $this->locations_data ['countryCode'] == 'IE' || $this->locations_data ['countryCode'] == 'IT' || $this->locations_data ['countryCode'] == 'LV' || $this->locations_data ['countryCode'] == 'LU' || $this->locations_data ['countryCode'] == 'MT' || $this->locations_data ['countryCode'] == 'NL' || $this->locations_data ['countryCode'] == 'PT' || $this->locations_data ['countryCode'] == 'SK' || $this->locations_data ['countryCode'] == 'SI' || $this->locations_data ['countryCode'] == 'ES' || 

							$this->locations_data ['countryCode'] == 'MC' || $this->locations_data ['countryCode'] == 'AD') {
								$this->currency = 'EUR';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => 978, 'currency_rate' => 1, 'currency_symbol' => '€', 'currency_symbol_side' => 'right', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'CH' || $this->locations_data ['countryCode'] == 'LI') {
								$this->currency = 'CHF';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'GB') {
								$this->currency = 'GBP';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'CA') {
								$this->currency = 'CAD';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'JP') {
								$this->currency = 'JPY';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'MX') {
								$this->currency = 'MXN';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'TR') {
								$this->currency = 'TRY';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'AU') {
								$this->currency = 'AUD';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'NZ') {
								$this->currency = 'NZD';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'NO') {
								$this->currency = 'NOK';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'BR') {
								$this->currency = 'BRL';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'AR') {
								$this->currency = 'ARS';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'KH') {
								$this->currency = 'KHR';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'TW') {
								$this->currency = 'TWD';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'SE') {
								$this->currency = 'SEK';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'DK') {
								$this->currency = 'DKK';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'SG') {
								$this->currency = 'SGD';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} elseif ($this->locations_data ['countryCode'] == 'US') {
								$this->currency = 'USD';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							} else {
								/*
								$this->currency = 'EUR';
								
								$currency_session_data = array(
						        	'currency' => 'EUR',
					                'mercanet_currency_code' => 978,
						           	'currency_rate' => 1,
									'currency_symbol' => '€',
									'currency_symbol_side' => 'right',
									'currency_decimal_place' => 2
							   	);
							   	*/
								
								$this->currency = 'USD';
								
								$currency_session_data = array ('currency' => $this->currency, 'mercanet_currency_code' => $this->Currency_model->get_currency_mercanet_currency_code ( $this->currency ), 'currency_rate' => $this->Currency_model->get_currency_rate ( $this->currency ), 'currency_symbol' => $this->Currency_model->get_currency_symbol ( $this->currency ), 'currency_symbol_side' => 'left', 'currency_decimal_place' => 2 );
							}
						}
					} else {
						/*Localhost*/
						
						$this->currency = 'EUR';
						
						$currency_session_data = array ('currency' => 'EUR', 'mercanet_currency_code' => 978, 'currency_rate' => 1, 'currency_symbol' => '€', 'currency_symbol_side' => 'right', 'currency_decimal_place' => 2 );
					}
				}
			}
			
			$this->session->set_userdata ( $currency_session_data );
		
		}
		///////////////////////////////////////////////// CURRENCY /////////////////////////////////////////////////
		

		///////////////////////////////////////////////// LANGUAGE /////////////////////////////////////////////////
		

		if ($this_merchant_id || $this->session->userdata ( 'language' ) == FALSE) {
			$language_session_data = array ();
			
			if ($this->session->userdata ( 'currency' ) == 'USD') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'en';
			} elseif ($this->session->userdata ( 'currency' ) == 'CHF') {
				$this->language = 'french';
				$this->config->set_item ( 'language', 'french' );
				$this->lang_scope = 'fr';
			} elseif ($this->session->userdata ( 'currency' ) == 'GBP') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'en';
			} elseif ($this->session->userdata ( 'currency' ) == 'CAD') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'en';
			} elseif ($this->session->userdata ( 'currency' ) == 'JPY') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'jp';
			} elseif ($this->session->userdata ( 'currency' ) == 'MXN') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'es';
			} elseif ($this->session->userdata ( 'currency' ) == 'TRY') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'tr';
			} elseif ($this->session->userdata ( 'currency' ) == 'AUD') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'en';
			} elseif ($this->session->userdata ( 'currency' ) == 'NZD') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'en';
			} elseif ($this->session->userdata ( 'currency' ) == 'NOK') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'no';
			} elseif ($this->session->userdata ( 'currency' ) == 'BRL') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'pt';
			} elseif ($this->session->userdata ( 'currency' ) == 'ARS') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'es';
			} elseif ($this->session->userdata ( 'currency' ) == 'KHR') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'kh';
			} elseif ($this->session->userdata ( 'currency' ) == 'TWD') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'tw';
			} elseif ($this->session->userdata ( 'currency' ) == 'SEK') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'se';
			} elseif ($this->session->userdata ( 'currency' ) == 'DKK') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'dk';
			} elseif ($this->session->userdata ( 'currency' ) == 'KRW') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'en';
			} elseif ($this->session->userdata ( 'currency' ) == 'SGD') {
				$this->language = 'english';
				$this->config->set_item ( 'language', 'english' );
				$this->lang_scope = 'en';
			} else {
				if ($this->session->userdata ( 'language' ) == FALSE) {
					if (! preg_match ( '/localhost/', $_SERVER ["HTTP_HOST"] )) {
						if (empty ( $this->locations_data )) {
							//Get errors and locations
							$ip_location_key = $this->config_ip ['apiKey'];
							$this->ip_location->setKey ( $ip_location_key );
							$this->locations_data = $this->ip_location->getCountry ( $_SERVER ['REMOTE_ADDR'] );
							$errors = $this->ip_location->getError ();
						
		//print_r_html('language : '.$this->locations_data['countryCode']);
						}
						
						if (! empty ( $this->locations_data ) && $this->locations_data ['statusCode'] == 'OK') {
							if ($this->locations_data ['countryCode'] == 'FR' || $this->locations_data ['countryCode'] == 'BE' || $this->locations_data ['countryCode'] == 'LU' || $this->locations_data ['countryCode'] == 'CH' || $this->locations_data ['countryCode'] == 'LI' || $this->locations_data ['countryCode'] == 'MC' || $this->locations_data ['countryCode'] == 'MA' || $this->locations_data ['countryCode'] == 'TN' || $this->locations_data ['countryCode'] == 'DZ' || $this->locations_data ['countryCode'] == 'BJ' || $this->locations_data ['countryCode'] == 'BF' || $this->locations_data ['countryCode'] == 'CM' || $this->locations_data ['countryCode'] == 'CG' || $this->locations_data ['countryCode'] == 'CI' || $this->locations_data ['countryCode'] == 'GA' || $this->locations_data ['countryCode'] == 'GH' || $this->locations_data ['countryCode'] == 'GN' || $this->locations_data ['countryCode'] == 'GF' || $this->locations_data ['countryCode'] == 'PF' || $this->locations_data ['countryCode'] == 'TF' || $this->locations_data ['countryCode'] == 'ML' || $this->locations_data ['countryCode'] == 'MQ' || $this->locations_data ['countryCode'] == 'NE' || $this->locations_data ['countryCode'] == 'SN' || $this->locations_data ['countryCode'] == 'TG') {
								$this->language = 'french';
								$this->config->set_item ( 'language', 'french' );
								$this->lang_scope = 'fr';
							} elseif ($this->locations_data ['countryCode'] == 'US' || $this->locations_data ['countryCode'] == 'GB' || $this->locations_data ['countryCode'] == 'CA' || $this->locations_data ['countryCode'] == 'AU' || $this->locations_data ['countryCode'] == 'IE' || $this->locations_data ['countryCode'] == 'NZ' || $this->locations_data ['countryCode'] == 'AG' || $this->locations_data ['countryCode'] == 'BS' || $this->locations_data ['countryCode'] == 'BB' || $this->locations_data ['countryCode'] == 'BZ' || $this->locations_data ['countryCode'] == 'BW' || $this->locations_data ['countryCode'] == 'GD' || $this->locations_data ['countryCode'] == 'DM' || $this->locations_data ['countryCode'] == 'FJ' || $this->locations_data ['countryCode'] == 'GM' || $this->locations_data ['countryCode'] == 'GH' || $this->locations_data ['countryCode'] == 'GD' || $this->locations_data ['countryCode'] == 'GY' || $this->locations_data ['countryCode'] == 'IN' || $this->locations_data ['countryCode'] == 'JM' || $this->locations_data ['countryCode'] == 'KE' || $this->locations_data ['countryCode'] == 'KI' || $this->locations_data ['countryCode'] == 'LS' || $this->locations_data ['countryCode'] == 'LR' || $this->locations_data ['countryCode'] == 'MW' || $this->locations_data ['countryCode'] == 'MT' || $this->locations_data ['countryCode'] == 'MH' || $this->locations_data ['countryCode'] == 'MU' || $this->locations_data ['countryCode'] == 'FM' || $this->locations_data ['countryCode'] == 'NA' || $this->locations_data ['countryCode'] == 'NR' || $this->locations_data ['countryCode'] == 'NG' || $this->locations_data ['countryCode'] == 'PK' || $this->locations_data ['countryCode'] == 'PW' || $this->locations_data ['countryCode'] == 'PG' || $this->locations_data ['countryCode'] == 'PH' || $this->locations_data ['countryCode'] == 'RW' || $this->locations_data ['countryCode'] == 'VC' || $this->locations_data ['countryCode'] == 'WS' || $this->locations_data ['countryCode'] == 'SC' || $this->locations_data ['countryCode'] == 'SL' || $this->locations_data ['countryCode'] == 'SG' || $this->locations_data ['countryCode'] == 'SB' || $this->locations_data ['countryCode'] == 'ZA' || $this->locations_data ['countryCode'] == 'SS' || $this->locations_data ['countryCode'] == 'SD' || $this->locations_data ['countryCode'] == 'SZ' || $this->locations_data ['countryCode'] == 'TZ' || $this->locations_data ['countryCode'] == 'TO' || $this->locations_data ['countryCode'] == 'TT' || $this->locations_data ['countryCode'] == 'TV' || $this->locations_data ['countryCode'] == 'UG' || $this->locations_data ['countryCode'] == 'VU' || $this->locations_data ['countryCode'] == 'ZM' || $this->locations_data ['countryCode'] == 'ZW') {
								$this->language = 'english';
								$this->config->set_item ( 'language', 'english' );
								$this->lang_scope = 'en';
							} elseif ($this->locations_data ['countryCode'] == 'IT') {
								$this->language = 'english';
								$this->config->set_item ( 'language', 'english' );
								$this->lang_scope = 'it';
							} elseif ($this->locations_data ['countryCode'] == 'ES' || $this->locations_data ['countryCode'] == 'AR' || $this->locations_data ['countryCode'] == 'MX' || $this->locations_data ['countryCode'] == 'CL' || $this->locations_data ['countryCode'] == 'DO' || $this->locations_data ['countryCode'] == 'NI' || $this->locations_data ['countryCode'] == 'UY' || $this->locations_data ['countryCode'] == 'CO' || $this->locations_data ['countryCode'] == 'PE' || $this->locations_data ['countryCode'] == 'VE' || $this->locations_data ['countryCode'] == 'EC' || $this->locations_data ['countryCode'] == 'GT' || $this->locations_data ['countryCode'] == 'CU' || $this->locations_data ['countryCode'] == 'BO' || $this->locations_data ['countryCode'] == 'HN' || $this->locations_data ['countryCode'] == 'PY' || $this->locations_data ['countryCode'] == 'SV' || $this->locations_data ['countryCode'] == 'CR' || $this->locations_data ['countryCode'] == 'PA' || $this->locations_data ['countryCode'] == 'GQ' || $this->locations_data ['countryCode'] == 'PR') {
								$this->language = 'english';
								$this->config->set_item ( 'language', 'english' );
								$this->lang_scope = 'es';
							} elseif ($this->locations_data ['countryCode'] == 'PT' || $this->locations_data ['countryCode'] == 'BR') {
								$this->language = 'english';
								$this->config->set_item ( 'language', 'english' );
								$this->lang_scope = 'pt';
							} elseif ($this->locations_data ['countryCode'] == 'DE' || $this->locations_data ['countryCode'] == 'AT') {
								$this->language = 'english';
								$this->config->set_item ( 'language', 'english' );
								$this->lang_scope = 'de';
							} elseif ($this->locations_data ['countryCode'] == 'JP') {
								$this->language = 'english';
								$this->config->set_item ( 'language', 'english' );
								$this->lang_scope = 'jp';
							} else {
								$this->language = 'english';
								$this->config->set_item ( 'language', 'english' );
								$this->lang_scope = 'en';
							}
						}
					} else {
						/*Localhost*/
						
						$this->language = 'english';
						$this->config->set_item ( 'language', 'english' );
						$this->lang_scope = 'en';
					}
				}
			}
			
			if (count ( $_GET ) > 0) {
				foreach ( $_GET as $field => $value ) {
					if ($field == 'language') {
						if (strtolower ( strval ( $value ) ) == 'french') {
							$this->language = 'french';
							$this->config->set_item ( 'language', 'french' );
							$this->lang_scope = 'fr';
						} elseif (strtolower ( strval ( $value ) ) == 'english') {
							$this->language = 'english';
							$this->config->set_item ( 'language', 'english' );
							$this->lang_scope = 'en';
						}
					}
					
					if ($field == 'lang') {
						if (strtolower ( strval ( $value ) ) == 'fr') {
							$this->language = 'french';
							$this->config->set_item ( 'language', 'french' );
							$this->lang_scope = 'fr';
						} elseif (strtolower ( strval ( $value ) ) == 'en') {
							$this->language = 'english';
							$this->config->set_item ( 'language', 'english' );
							$this->lang_scope = 'en';
						} elseif (strtolower ( strval ( $value ) ) == 'es') {
							$this->language = 'english';
							$this->config->set_item ( 'language', 'english' );
							$this->lang_scope = 'es';
						} elseif (strtolower ( strval ( $value ) ) == 'it') {
							$this->language = 'english';
							$this->config->set_item ( 'language', 'english' );
							$this->lang_scope = 'it';
						} elseif (strtolower ( strval ( $value ) ) == 'de') {
							$this->language = 'english';
							$this->config->set_item ( 'language', 'english' );
							$this->lang_scope = 'de';
						} elseif (strtolower ( strval ( $value ) ) == 'jp') {
							$this->language = 'english';
							$this->config->set_item ( 'language', 'english' );
							$this->lang_scope = 'jp';
						}
					}
				}
			}
			
			$route_file = APPPATH . 'config/routes' . EXT;
			//$route_file = ($this->language == 'french')?APPPATH.'config/routes_fr'.EXT:APPPATH.'config/routes_en'.EXT;
			

			$language_session_data = array ('language' => $this->language, 'lang_scope' => $this->lang_scope, 'db_active_group' => $this->language, 'route_file_name' => $route_file );
			
			$this->session->set_userdata ( $language_session_data );
		}
		
		if ($this->session->userdata ( 'language' )) {
			if ($this->session->userdata ( 'language' ) == 'french') {
				$this->config->set_item ( 'language', 'french' );
				$this->lang->load ( 'common', 'french' );
			} else {
				$this->config->set_item ( 'language', 'english' );
				$this->lang->load ( 'common', 'english' );
			}
		} else {
			$this->config->set_item ( 'language', 'english' );
			$this->lang->load ( 'common', 'english' );
		}
		
		///////////////////////////////////////////////// LANGUAGE /////////////////////////////////////////////////
		

		////////////////////////////////////////////////// MOBILE //////////////////////////////////////////////////
		

		if ($this->config->item ( 'mobile_user' ) == null) {
			if (strstr ( $_SERVER ['HTTP_USER_AGENT'], 'android' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'iPhone' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'iPod' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'iPad' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'Palm' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'iemobile' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'sony' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'symbian' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'nokia' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'samsung' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'mobile' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'epoc' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'opera' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'palmos' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'blackberry' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'ericsson' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'panasonic' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'philips' )) {
				$this->config->set_item ( 'mobile_user', true );
				
				if (strstr ( $_SERVER ['HTTP_USER_AGENT'], 'iPhone' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'iPod' ) || strstr ( $_SERVER ['HTTP_USER_AGENT'], 'iPad' )) {
					$this->config->set_item ( 'mobile_user_type', 'apple' );
					if ($this->session->userdata ( 'mobile_user_type' ) == FALSE) {
						$this->session->set_userdata ( array ('mobile_user' => true, 'mobile_user_type' => 'apple' ) );
					}
				} else if (strstr ( $_SERVER ['HTTP_USER_AGENT'], 'android' )) {
					$this->config->set_item ( 'mobile_user_type', 'android' );
					if ($this->session->userdata ( 'mobile_user_type' ) == FALSE) {
						$this->session->set_userdata ( array ('mobile_user' => true, 'mobile_user_type' => 'android' ) );
					}
				} else if (strstr ( $_SERVER ['HTTP_USER_AGENT'], 'blackberry' )) {
					$this->config->set_item ( 'mobile_user_type', 'blackberry' );
					if ($this->session->userdata ( 'mobile_user_type' ) == FALSE) {
						$this->session->set_userdata ( array ('mobile_user' => true, 'mobile_user_type' => 'blackberry' ) );
					}
				} else {
					$this->config->set_item ( 'mobile_user_type', null );
					if ($this->session->userdata ( 'mobile_user_type' ) == FALSE) {
						$this->session->set_userdata ( array ('mobile_user' => true, 'mobile_user_type' => 'Generic Mobile' ) );
					}
				}
			} else {
				$this->config->set_item ( 'mobile_user', false );
			}
		}
		
		////////////////////////////////////////////////// OPEN GRAPH //////////////////////////////////////////////////
		

		$save_path = $this->config->item ( 'og_server_path' ) . 'banner/' . $this->session->userdata ( 'lang_scope' ) . '/';
		
		if (file_exists ( $save_path . 'open_graph_image.png' )) {
			$this->data ['open_graph_image'] = $this->config->item ( 'og_url' ) . 'banner/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.png?' . filemtime ( $this->config->item ( 'og_server_path' ) . 'banner/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.png' );
		} elseif (file_exists ( $save_path . 'open_graph_image.gif' )) {
			$this->data ['open_graph_image'] = $this->config->item ( 'og_url' ) . 'banner/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.gif?' . filemtime ( $this->config->item ( 'og_server_path' ) . 'banner/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.gif' );
		} elseif (file_exists ( $save_path . 'open_graph_image.jpg' )) {
			$this->data ['open_graph_image'] = $this->config->item ( 'og_url' ) . 'banner/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.jpg?' . filemtime ( $this->config->item ( 'og_server_path' ) . 'banner/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.jpg' );
		} else {
			$this->data ['open_graph_image'] = theme_img ( 'logo/cn_open_graph_1200x1200px_3.png' );
		}
	}
	
	function _profile_auth_fb_user() {
		$status_fb_auth = false;
		
		$this->fb_user = $this->facebook->getUser ();
		
		if ($this->fb_user) {
			$status_fb_auth = true;
			
			try {
				
				$fb_user_profile = $this->facebook->api ( '/me?fields=id,name,email' );
			} catch ( FacebookApiException $e ) {
				//log_message('error', $e);
				$fb_user_profile = null;
			}
			
			if ($fb_user_profile) {
				
				if ($this->session->userdata ( 'fb_authorized_userid' ) == FALSE) {
					
					$new_session_data = array ('fb_authorized_username' => $fb_user_profile ['name'], 'fb_authorized_userid' => $fb_user_profile ['id'], 'fb_authorized_useremail' => $fb_user_profile ['email'] );
					
					$this->session->set_userdata ( $new_session_data );
					
					$this->fb_user_id = $fb_user_profile ['id'];
					$this->fb_user_name = $fb_user_profile ['name'];
				
				}
			}
			
			if (! isset ( $this->fb_access_token )) {
				try {
					$this->fb_access_token = $this->facebook->getAccessToken ();
				} catch ( FacebookApiException $e ) {
				
		//log_message('error', $e); 
				}
			}
			
			if ($this->session->userdata ( 'fb_status_liked_fanpage' ) == FALSE || $this->session->userdata ( 'fb_status_liked_apppage' ) == FALSE) {
				try {
					$this->fb_user_resources = $this->facebook->api ( "me/likes?access_token=" . $this->fb_access_token );
					$resources = $this->fb_user_resources;
					$this->fb_status_liked_fanpage = null;
					$this->fb_status_liked_apppage = null;
					
					foreach ( $resources ['data'] as $resource ) {
						foreach ( $resource as $key ) {
							if (in_array ( $key, $this->fb_page_IDs )) {
								//echo "has liked fan page";
								$this->fb_status_liked_fanpage = TRUE;
							}
							if ($key == $this->data ['fb_appId']) {
								//echo "has liked app page";
								$this->fb_status_liked_apppage = TRUE;
							}
						}
					}
					
					if ($this->fb_status_liked_fanpage != null) {
						$this->session->set_userdata ( 'fb_status_liked_fanpage', 'liked' );
					} else {
						$this->session->set_userdata ( 'fb_status_liked_fanpage', 'unliked' );
						$this->fb_status_liked_fanpage = FALSE;
					}
					if ($this->fb_status_liked_apppage != null) {
						$this->session->set_userdata ( 'fb_status_liked_apppage', 'liked' );
					} else {
						$this->session->set_userdata ( 'fb_status_liked_apppage', 'unliked' );
						$this->fb_status_liked_apppage = FALSE;
					}
				} catch ( FacebookApiException $e ) {
				
		//log_message('error', $e);
				}
			}
		}
		
		if ($this->session->userdata ( 'fb_authorized_userid' ) != FALSE) {
			$status_fb_auth = true;
			
			$this->fb_user_id = $this->session->userdata ( 'fb_authorized_userid' );
			$this->fb_user_name = $this->session->userdata ( 'fb_authorized_username' );
		}
		
		//if($this->session->userdata('fb_promo_active') == FALSE)
		//{
		if ($this->Coupon_model->check_code ( 'Promo-fb-JoinNTy' ) == true) {
			$this->session->set_userdata ( 'fb_promo_active', 'true' );
		} else {
			$this->session->set_userdata ( 'fb_promo_active', 'false' );
		}
		//}
		

		//if($this->session->userdata('fb_auth_app_promo_already') == FALSE)
		//{
		if ($this->Social_model_fb->_checkPromoAuthApp ( $this->fb_user_id )) {
			$this->session->set_userdata ( 'fb_auth_app_promo_already', 'true' );
		} else {
			$this->session->set_userdata ( 'fb_auth_app_promo_already', 'false' );
		}
		//}
		

		return $status_fb_auth;
	}
}

class Admin_Controller extends Base_Controller {
	function __construct() {
		parent::__construct ();
		
		/*
		$this->CI =& get_instance();
		$this->CI->output->enable_profiler(TRUE);
		*/
		
		/*
		$sections = array(
		    'benchmarks' => TRUE,
			'controller_info' => TRUE,
			'http_headers' => TRUE,
		    'post' => TRUE,
			'get' => TRUE,
			'queries' => TRUE,
			'config' => TRUE,
			'session_data' => TRUE
		    );
		
		$this->CI =& get_instance();
		$this->CI->output->enable_profiler(TRUE);
		$this->CI->output->set_profiler_sections($sections);
		*/
		
		$this->load->library ( 'auth' );
		$this->auth->is_logged_in ( uri_string () );
		
		$this->config->set_item ( 'language', 'french' );
		
		if ($this->session->userdata ( 'db_active_group' ) == FALSE) {
			$session_db_active_group = array ('language' => 'french', 'db_active_group' => 'french', 'route_file_name' => APPPATH . 'config/routes' . EXT )//'route_file_name' => APPPATH.'config/routes_fr'.EXT
			;
			
			$this->session->set_userdata ( $session_db_active_group );
		}
		
		//load the base language file
		$this->lang->load ( 'admin_common' );
		$this->lang->load ( 'goedit' );
		$this->lang->load ( 'common' );
		
		$this->data ['base_url'] = $this->uri->segment_array ();
	}
	
	function english_version($return_controller) {
		$this->set_db_lang_version ( 'english', $this->config->item ( 'admin_folder' ) . '/' . $return_controller );
	}
	
	function french_version($return_controller) {
		$this->set_db_lang_version ( 'french', $this->config->item ( 'admin_folder' ) . '/' . $return_controller );
	}
	
	function set_db_lang_version($lang, $return_url) {
		if ($lang == 'english') {
			$session_db_active_group = array ('language' => 'english', 'lang_scope' => 'en', 'db_active_group' => 'english', 'route_file_name' => APPPATH . 'config/routes' . EXT )//'route_file_name' => APPPATH.'config/routes_en'.EXT
			;
			
			$this->session->set_userdata ( $session_db_active_group );
		} elseif ($lang == 'french') {
			$session_db_active_group = array ('language' => 'french', 'lang_scope' => 'fr', 'db_active_group' => 'french', 'route_file_name' => APPPATH . 'config/routes' . EXT )//'route_file_name' => APPPATH.'config/routes_fr'.EXT
			;
			
			$this->session->set_userdata ( $session_db_active_group );
		}
		
		redirect ( $return_url );
	}
}