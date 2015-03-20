<?php
/* Single page checkout controller*/

class Checkout extends Front_Controller {
	
	var $CI;
	
	function __construct() {
		parent::__construct ();
		
		force_ssl ();
		
		/*make sure the cart isnt empty*/
		if ($this->go_cart->total_items () == 0) {
			redirect ( 'cart/view_cart' );
		}
		
		/*is the user required to be logged in?*/
		if (config_item ( 'require_login' )) {
			$this->Customer_model->is_logged_in ( 'checkout' );
		}
		
		if (! config_item ( 'allow_os_purchase' ) && config_item ( 'inventory_enabled' )) {
			/*double check the inventory of each item before proceeding to checkout*/
			$inventory_check = $this->go_cart->check_inventory ();
			
			if ($inventory_check) {
				/*
				OOPS we have an error. someone else has gotten the scoop on our customer and bought products out from under them!
				we need to redirect them to the view cart page and let them know that the inventory is no longer there.
				*/
				$this->session->set_flashdata ( 'error', $inventory_check );
				redirect ( 'cart/view_cart' );
			}
		}
		
		/* Set no caching
	
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	
		*/
		
		$this->load->library ( 'form_validation' );
	}
	
	function index() {
		/*show address first*/
		$this->step_1 ();
	}
	
	function show_vat_tax_display() {
		$this->go_cart->set_display_tax_vat ( true );
		redirect ( 'checkout/step_4' );
	}
	
	function hide_vat_tax_display() {
		$this->go_cart->set_display_tax_vat ( false );
		redirect ( 'checkout/step_4' );
	}
	
	function step_1() {
		if ($this->session->flashdata ( 'temp_addr_data' ) != FALSE) {
			$return_array = objectToArray ( json_decode ( $this->session->flashdata ( 'temp_addr_data' ) ) );
			
			//print_r_html($return_array);
			

			$this->data ['customer'] ['ship_address'] ['firstname'] = $return_array ['firstname'];
			$this->data ['customer'] ['ship_address'] ['lastname'] = $return_array ['lastname'];
			$this->data ['customer'] ['ship_address'] ['email'] = $return_array ['email'];
			$this->data ['customer'] ['ship_address'] ['phone'] = $return_array ['phone'];
			$this->data ['customer'] ['ship_address'] ['address1'] = $return_array ['address1'];
			$this->data ['customer'] ['ship_address'] ['city'] = $return_array ['city'];
			$this->data ['customer'] ['ship_address'] ['zip'] = $return_array ['zip'];
		} else {
			$this->data ['customer'] = $this->go_cart->customer ();
		}
		
		if (isset ( $this->data ['customer'] ['id'] )) {
			$this->data ['customer_addresses'] = $this->Customer_model->get_address_list ( $this->data ['customer'] ['id'] );
		}
		
		/*require a shipping address*/
		$this->form_validation->set_rules ( 'address_id', 'Shipping Address ID', 'numeric' );
		$this->form_validation->set_rules ( 'firstname', 'lang:address_firstname', 'trim|required|max_length[32]' );
		$this->form_validation->set_rules ( 'lastname', 'lang:address_lastname', 'trim|required|max_length[32]' );
		$this->form_validation->set_rules ( 'email', 'lang:address_email', 'trim|required|valid_email|max_length[128]' );
		
		//$this->form_validation->set_rules('phone', 'lang:address_phone', 'trim|required|max_length[32]');
		$this->form_validation->set_rules ( 'phone', 'lang:address_phone', 'trim|max_length[32]' );
		
		$this->form_validation->set_rules ( 'company', 'lang:address_company', 'trim|max_length[128]' );
		$this->form_validation->set_rules ( 'address1', 'lang:address1', 'trim|required|max_length[128]' );
		$this->form_validation->set_rules ( 'address2', 'lang:address2', 'trim|max_length[128]' );
		$this->form_validation->set_rules ( 'city', 'lang:address_city', 'trim|required|max_length[128]' );
		$this->form_validation->set_rules ( 'country_id', 'lang:address_country', 'trim|required|numeric' );
		
		//$this->form_validation->set_rules('zone_id', 'lang:address_state', 'trim|required|numeric');
		$this->form_validation->set_rules ( 'zone_id', 'lang:address_state', 'trim|numeric' );
		
		/*if there is post data, get the country info and see if the zip code is required*/
		if ($this->input->post ( 'country_id' )) {
			$country = $this->Location_model->get_country ( $this->input->post ( 'country_id' ) );
			if (( bool ) $country->postcode_required) {
				$this->form_validation->set_rules ( 'zip', 'lang:address_postcode', 'trim|required|max_length[10]' );
			}
		} else {
			$this->form_validation->set_rules ( 'zip', 'lang:address_postcode', 'trim|max_length[10]' );
		}
		
		if ($this->form_validation->run () == false) {
			$this->data ['address_form_prefix'] = 'ship';
			if (! $this->config->item ( 'compact_html' )) {
				$this->load->view ( 'header', $this->data );
				$this->load->view ( 'checkout/address_form', $this->data );
				$this->load->view ( 'footer', $this->data );
			} else {
				$this->compact_view ( $this->view ( 'header', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'checkout/address_form', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'footer', $this->data, TRUE ) );
			}
		} else {
			/*load any customer data to get their ID (if logged in)*/
			$customer = $this->go_cart->customer ();
			
			$customer ['ship_address'] ['company'] = $this->input->post ( 'company', TRUE );
			$customer ['ship_address'] ['firstname'] = $this->input->post ( 'firstname', TRUE );
			$customer ['ship_address'] ['lastname'] = $this->input->post ( 'lastname', TRUE );
			$customer ['ship_address'] ['email'] = $this->input->post ( 'email', TRUE );
			$customer ['ship_address'] ['phone'] = $this->input->post ( 'phone', TRUE );
			$customer ['ship_address'] ['address1'] = $this->input->post ( 'address1', TRUE );
			$customer ['ship_address'] ['address2'] = $this->input->post ( 'address2', TRUE );
			$customer ['ship_address'] ['city'] = $this->input->post ( 'city', TRUE );
			$customer ['ship_address'] ['zip'] = $this->input->post ( 'zip', TRUE );
			
			/* get zone / country data using the zone id submitted as state*/
			$country = $this->Location_model->get_country ( set_value ( 'country_id' ) );
			$zone = $this->Location_model->get_zone ( set_value ( 'zone_id' ) );
			
			$customer ['ship_address'] ['zone'] = $zone->code; /*  save the state for output formatted addresses */
			$customer ['ship_address'] ['country'] = $country->name; /*  some shipping libraries require country name */
			$customer ['ship_address'] ['country_code'] = $country->iso_code_2; /*  some shipping libraries require the code */
			$customer ['ship_address'] ['zone_id'] = $this->input->post ( 'zone_id' ); /*  use the zone id to populate address state field value */
			$customer ['ship_address'] ['country_id'] = $this->input->post ( 'country_id' );
			
			/* for guest customers, load the billing address data as their base info as well */
			if (empty ( $customer ['id'] )) {
				$customer ['company'] = $customer ['ship_address'] ['company'];
				$customer ['firstname'] = $customer ['ship_address'] ['firstname'];
				$customer ['lastname'] = $customer ['ship_address'] ['lastname'];
				$customer ['phone'] = $customer ['ship_address'] ['phone'];
				$customer ['email'] = $customer ['ship_address'] ['email'];
			}
			
			if (! isset ( $customer ['group_id'] )) {
				$customer ['group_id'] = 1; /* default group */
			}
			
			/*if there is no address set then return blank*/
			if (empty ( $customer ['bill_address'] )) {
				$customer ['bill_address'] = $customer ['ship_address'];
			}
			
			/* save customer details*/
			$this->go_cart->save_customer ( $customer );
			
			$this->go_cart->set_is_tax_vat ( $customer ['bill_address'] ['country_code'] );
			
			if ($this->config->item ( 'subscribe_to_newsletter_during_checkout_stage' )) {
				if ($this->session->userdata ( 'newsletter_request_confirm_email_already_sent' ) == FALSE) {
					$this->load->add_package_path ( APPPATH . 'packages/mailchimp/' );
					$this->load->library ( 'mailchimp_subscribe' );
					$this->mailchimp_subscribe->subscribe ( $customer ['firstname'], $customer ['lastname'], $customer ['email'] );
					$this->session->set_userdata ( array ('newsletter_request_confirm_email_already_sent' => TRUE ) );
				}
			}
			
			/*send to the next form*/
			redirect ( 'checkout/step_2' );
		}
	}
	
	function billing_address() {
		$this->data ['customer'] = $this->go_cart->customer ();
		
		if (isset ( $this->data ['customer'] ['id'] )) {
			$this->data ['customer_addresses'] = $this->Customer_model->get_address_list ( $this->data ['customer'] ['id'] );
		}
		
		/*require a billing address*/
		$this->form_validation->set_rules ( 'address_id', 'Billing Address ID', 'numeric' );
		$this->form_validation->set_rules ( 'firstname', 'lang:address_firstname', 'trim|required|max_length[32]' );
		$this->form_validation->set_rules ( 'lastname', 'lang:address_lastname', 'trim|required|max_length[32]' );
		$this->form_validation->set_rules ( 'email', 'lang:address_email', 'trim|required|valid_email|max_length[128]' );
		
		//$this->form_validation->set_rules('phone', 'lang:address_phone', 'trim|required|max_length[32]');
		$this->form_validation->set_rules ( 'phone', 'lang:address_phone', 'trim|max_length[32]' );
		
		$this->form_validation->set_rules ( 'company', 'lang:address_company', 'trim|max_length[128]' );
		$this->form_validation->set_rules ( 'address1', 'lang:address1', 'trim|required|max_length[128]' );
		$this->form_validation->set_rules ( 'address2', 'lang:address2', 'trim|max_length[128]' );
		$this->form_validation->set_rules ( 'city', 'lang:address_city', 'trim|required|max_length[128]' );
		$this->form_validation->set_rules ( 'country_id', 'lang:address_country', 'trim|required|numeric' );
		
		//$this->form_validation->set_rules('zone_id', 'lang:address_state', 'trim|required|numeric');
		$this->form_validation->set_rules ( 'zone_id', 'lang:address_state', 'trim|numeric' );
		
		/* if there is post data, get the country info and see if the zip code is required */
		if ($this->input->post ( 'country_id' )) {
			$country = $this->Location_model->get_country ( $this->input->post ( 'country_id' ) );
			if (( bool ) $country->postcode_required) {
				$this->form_validation->set_rules ( 'zip', 'lang:address_postcode', 'trim|required|max_length[10]' );
			}
		} else {
			$this->form_validation->set_rules ( 'zip', 'lang:address_postcode', 'trim|max_length[10]' );
		}
		
		if ($this->form_validation->run () == false) {
			/* show the address form but change it to be for shipping */
			$this->data ['address_form_prefix'] = 'bill';
			if (! $this->config->item ( 'compact_html' )) {
				$this->load->view ( 'header', $this->data );
				$this->load->view ( 'checkout/address_form', $this->data );
				$this->load->view ( 'footer', $this->data );
			} else {
				$this->compact_view ( $this->view ( 'header', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'checkout/address_form', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'footer', $this->data, TRUE ) );
			}
		} else {
			/* load any customer data to get their ID (if logged in) */
			$customer = $this->go_cart->customer ();
			
			$customer ['bill_address'] ['company'] = $this->input->post ( 'company', TRUE );
			$customer ['bill_address'] ['firstname'] = $this->input->post ( 'firstname', TRUE );
			$customer ['bill_address'] ['lastname'] = $this->input->post ( 'lastname', TRUE );
			$customer ['bill_address'] ['email'] = $this->input->post ( 'email', TRUE );
			$customer ['bill_address'] ['phone'] = $this->input->post ( 'phone', TRUE );
			$customer ['bill_address'] ['address1'] = $this->input->post ( 'address1', TRUE );
			$customer ['bill_address'] ['address2'] = $this->input->post ( 'address2', TRUE );
			$customer ['bill_address'] ['city'] = $this->input->post ( 'city', TRUE );
			$customer ['bill_address'] ['zip'] = $this->input->post ( 'zip', TRUE );
			
			/* get zone / country data using the zone id submitted as state */
			$country = $this->Location_model->get_country ( set_value ( 'country_id' ) );
			$zone = $this->Location_model->get_zone ( set_value ( 'zone_id' ) );
			
			$customer ['bill_address'] ['zone'] = $zone->code;
			$customer ['bill_address'] ['country'] = $country->name;
			$customer ['bill_address'] ['country_code'] = $country->iso_code_2;
			$customer ['bill_address'] ['zone_id'] = $this->input->post ( 'zone_id' );
			$customer ['bill_address'] ['country_id'] = $this->input->post ( 'country_id' );
			
			/* for guest customers, load the shipping address data as their base info as well */
			if (empty ( $customer ['id'] )) {
				$customer ['company'] = $customer ['ship_address'] ['company'];
				$customer ['firstname'] = $customer ['ship_address'] ['firstname'];
				$customer ['lastname'] = $customer ['ship_address'] ['lastname'];
				$customer ['phone'] = $customer ['ship_address'] ['phone'];
				$customer ['email'] = $customer ['ship_address'] ['email'];
			}
			
			if (! isset ( $customer ['group_id'] )) {
				$customer ['group_id'] = 1; /* default group */
			}
			
			/*  save customer details */
			$this->go_cart->save_customer ( $customer );
			
			$this->go_cart->set_is_tax_vat ( $customer ['bill_address'] ['country_code'] );
			
			if ($this->config->item ( 'subscribe_to_newsletter_during_checkout_stage' )) {
				if ($this->session->userdata ( 'newsletter_request_confirm_email_already_sent' ) == FALSE) {
					$this->load->add_package_path ( APPPATH . 'packages/mailchimp/' );
					$this->load->library ( 'mailchimp_subscribe' );
					$this->mailchimp_subscribe->subscribe ( $customer ['firstname'], $customer ['lastname'], $customer ['email'] );
					$this->session->set_userdata ( array ('newsletter_request_confirm_email_already_sent' => TRUE ) );
				}
			}
			
			/* send to the next form */
			redirect ( 'checkout/step_2' );
		}
	}
	
	function step_2() {
		/* where to next? Shipping? */
		$shipping_methods = $this->_get_shipping_methods ();
		
		if ($shipping_methods) {
			$this->shipping_form ( $shipping_methods );
		} /* now where? continue to step 3 */
		else {
			$this->step_3 ();
		}
	}
	
	function step_2_point_relais() {
		$this->data ['activate_point_relais_modal'] = true;
		
		$this->step_2 ();
	}
	
	protected function shipping_form($shipping_methods) {
		$this->data ['customer'] = $this->go_cart->customer ();
		
		/* do we have a selected shipping method already? */
		$shipping = $this->go_cart->shipping_method ();
		$this->data ['shipping_code'] = $shipping ['code'];
		$this->data ['shipping_methods'] = $shipping_methods;
		
		$this->form_validation->set_rules ( 'shipping_notes', 'lang:shipping_information', 'trim|xss_clean' );
		$this->form_validation->set_rules ( 'shipping_method', 'lang:shipping_method', 'trim|callback_validate_shipping_option' );
		
		$this->form_validation->set_rules ( 'relais_point_submit' );
		$this->form_validation->set_rules ( 'points-relais' );
		$this->form_validation->set_rules ( 'relais_point_num', 'lang:choose_relay_point' );
		
		if ($this->form_validation->run () == false) {
			if (! $this->config->item ( 'compact_html' )) {
				$this->load->view ( 'header', $this->data );
				$this->load->view ( 'checkout/shipping_form', $this->data );
				$this->load->view ( 'footer', $this->data );
			} else {
				$this->compact_view ( $this->view ( 'header', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'checkout/shipping_form', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'footer', $this->data, TRUE ) );
			}
		} else {
			/* grab initial shipping details! */
			$init_shipping_notes = $this->input->post ( 'shipping_notes', TRUE );
			
			/* set shipping relay point */
			$relais_point_submitted = $this->input->post ( 'relais_point_submit' );
			if ($relais_point_submitted) {
				$relais_point_num = $this->input->post ( 'relais_point_num' );
				
				$relay_shipping_info = $this->get_point_relais_details ( $relais_point_num );
				
				$this->go_cart->set_relay_point ( $relais_point_num, base64_encode ( gzcompress ( $relay_shipping_info ['relay_shipping_info_html'], 9 ) ), base64_encode ( gzcompress ( $relay_shipping_info ['relay_shipping_info_txt'], 9 ) ) );
				
				/* set shipping details! */
				//$reset_shipping_notes = preg_replace('/[\s]*?#-----------------------------------------#[\s\S]*?#-----------------------------------------#[\s]*?/mi', '', $init_shipping_notes);
				//$final_shipping_notes =  $reset_shipping_notes . $relay_shipping_info['relay_shipping_info_txt'];
				//$this->go_cart->set_additional_detail('shipping_notes', $final_shipping_notes);	
				

				$this->go_cart->set_additional_detail ( 'shipping_notes', $init_shipping_notes );
			} else {
				$this->go_cart->unset_relay_point ();
				
				/* set shipping details! */
				//$reset_shipping_notes = preg_replace('/[\s]*?#-----------------------------------------#[\s\S]*?#-----------------------------------------#[\s]*?/mi', '', $init_shipping_notes);
				//$this->go_cart->set_additional_detail('shipping_notes', $reset_shipping_notes);
				

				$this->go_cart->set_additional_detail ( 'shipping_notes', $init_shipping_notes );
			}
			
			/* parse out the shipping information */
			$shipping_method = json_decode ( $this->input->post ( 'shipping_method' ) );
			$shipping_code = md5 ( $this->input->post ( 'shipping_method' ) );
			
			/* set shipping info */
			$this->go_cart->set_shipping ( $shipping_method [0], $shipping_method [1]->num, $shipping_code );
			
			redirect ( 'checkout/step_3' );
		}
	}
	
	/*
		callback for shipping form 
		if callback is true then it's being called for form_Validation
		In that case, set the message otherwise just return true or false
	*/
	function validate_shipping_option($str, $callback = true) {
		$shipping_methods = $this->_get_shipping_methods ();
		
		if ($shipping_methods) {
			foreach ( $shipping_methods as $key => $val ) {
				$check = json_encode ( array ($key, $val ) );
				if ($str == md5 ( $check )) {
					return $check;
				}
			}
		}
		
		/* if we get there there is no match and they have submitted an invalid option */
		$this->form_validation->set_message ( 'validate_shipping_option', lang ( 'error_invalid_shipping_method' ) );
		return FALSE;
	}
	
	private function _get_shipping_methods() {
		$shipping_methods = array ();
		/* do we need shipping? */
		
		if (config_item ( 'require_shipping' )) {
			/* do the cart contents require shipping? */
			if ($this->go_cart->requires_shipping ()) {
				/* ok so lets grab some shipping methods. If none exists, then we know that shipping isn't going to happen! */
				foreach ( $this->Settings_model->get_settings ( 'shipping_modules' ) as $shipping_method => $order ) {
					$this->load->add_package_path ( APPPATH . 'packages/shipping/' . $shipping_method . '/' );
					/* eventually, we will sort by order, but I'm not concerned with that at the moment */
					$this->load->library ( $shipping_method );
					
					$shipping_methods = array_merge ( $shipping_methods, $this->$shipping_method->rates () );
					
					if ($shipping_method == "mondial_relay_points_relais") {
						$points_relais_list = $this->$shipping_method->get_points_relais_list ();
						
						if ($points_relais_list) {
							$this->data ['relay_list'] = $points_relais_list;
							$this->data ['relay_point'] = $this->go_cart->shipping_relay_point_num ();
						} else {
							$this->data ['relay_list'] = null;
						}
					}
				}
				
				//$this->print_r_html($shipping_methods);
				

				/*  Free shipping coupon applied ? */
				if ($this->go_cart->is_free_shipping ()) {
					/*  add free shipping as an option, but leave other options in case they want to upgrade */
					$shipping_methods [lang ( 'free_shipping_basic' )] = "0.00";
				}
				
				/*  Sort shipping array, by price, maintaining index association */
				asort ( $shipping_methods );
				
				/*  format the values for currency display */
				foreach ( $shipping_methods as &$method ) {
					if (is_array ( $method )) {
						$method = array ('num' => $method ['value'], 'str' => format_currency ( $method ['value'] ), 'entity_common_name' => $method ['entity_common_name'], 'entity_description' => $method ['entity_description'] );
					} else {
						$method = array ('num' => $method, 'str' => format_currency ( $method ) );
					}
				}
			
			}
		}
		if (! empty ( $shipping_methods )) {
			/* everything says that shipping is required! */
			return $shipping_methods;
		} else {
			return false;
		}
	}
	
	function get_point_relais_details($parcelShopID) {
		$this->load->add_package_path ( APPPATH . 'packages/shipping/mondial_relay_points_relais/' );
		$this->load->library ( 'mondial_relay_points_relais' );
		
		$relay_pt = $this->mondial_relay_points_relais->request_point_relais_map ( $parcelShopID );
		
		//print_r($relay_pt);
		

		if ($relay_pt) {
			$relay_shipping_info_html = '<fieldset><legend><em>' . lang ( 'shipping_notice_relay_point_1' ) . '</em></legend>';
			$relay_shipping_info_html .= '<br>';
			$relay_shipping_info_html .= '<table style="padding: 10px; width: 100%; height: auto;"><tr style="width:100%;"><td>' . lang ( 'shipping_notice_relay_point_2' ) . '</td></tr>';
			$relay_shipping_info_html .= '<tr style="width: 100%; margin: 0 auto;"><td style="padding: 20px 0; text-align: center;"><p><span style="background: #cccccc; padding: 0 10px;">' . lang ( 'shipping_notice_relay_point_3' ) . $relay_pt->ParcelShopId . '</span></p></td></tr>';
			if (! isset ( $relay_pt->LocalisationDetails )) {
				$relay_shipping_info_html .= '<tr style="width: 100%;"><td><table style="width: 80%; margin-left: auto; margin-right: auto;"><tr style="width: 100%; margin: 0 auto;"><td style="width: 50%; text-align: center;"><address>';
			} else {
				$relay_shipping_info_html .= '<tr style="width: 100%;"><td><table style="width: 80%; margin-left: auto; margin-right: auto;"><tr style="width: 100%; margin: 0 auto;"><td style="width: 100%; text-align: center;"><address>';
			}
			
			if ($relay_pt->Name != '') {
				$relay_shipping_info_html .= '<span><strong>' . trim ( $relay_pt->Name ) . '</strong></span><br>';
			}
			if ($relay_pt->Adress1 != '') {
				$relay_shipping_info_html .= '<span>' . trim ( $relay_pt->Adress1 ) . '</span><br>';
			}
			if ($relay_pt->Adress2 != '') {
				$relay_shipping_info_html .= '<span>' . trim ( $relay_pt->Adress2 ) . '</span><br>';
			}
			
			$relay_shipping_info_html .= '<span>' . trim ( $relay_pt->City ) . ', ' . trim ( $relay_pt->PostCode ) . ' ' . trim ( $relay_pt->CountryCode ) . '</span>';
			$relay_shipping_info_html .= '</address></td>';
			
			if (! isset ( $relay_pt->LocalisationDetails )) {
				$relay_shipping_info_html .= '<td style="width: 50%; text-align: center;">';
				$relay_shipping_info_html .= '<span><small><i>' . trim ( $relay_pt->LocalisationDetails ) . '</i></small></span>';
				$relay_shipping_info_html .= '</td>';
			}
			
			$relay_shipping_info_html .= '</tr></table></td></tr>';
			$relay_shipping_info_html .= '<tr style="width: 100%;"><td style="padding: 20px 0; text-align: center;"><a href="' . trim ( $relay_pt->MapUrl ) . '" target="_blank">' . lang ( 'relay_point_map' ) . '</a></td></tr>';
			$relay_shipping_info_html .= '<tr style="width: 100%;"><td style="width: 100%; text-align: center;">' . lang ( 'relay_point_opening_hours' ) . '</td></tr>';
			$relay_shipping_info_html .= '<tr style="width: 100%;"><td style="width: 100%; text-align: center;"><table style="width: 70%; margin-left: auto; margin-right: auto;"><tr>';
			
			foreach ( $relay_pt->OpeningHours as $key => $val ) {
				if ($this->config->item ( 'language' ) == 'french') {
					if ($key == 'Monday') {
						$key = 'Lundi';
					} elseif ($key == 'Tuesday') {
						$key = 'Mardi';
					} elseif ($key == 'Wednesday') {
						$key = 'Mercredi';
					} elseif ($key == 'Thursday' || $key == 'Thirsday') {
						$key = 'Jeudi';
					} elseif ($key == 'Friday') {
						$key = 'Vendredi';
					} elseif ($key == 'Saturday') {
						$key = 'Samedi';
					} elseif ($key == 'Sunday') {
						$key = 'Dimanche';
					}
				}
				$relay_shipping_info_html .= '<td style="width: 10%; text-align: center;">';
				$relay_shipping_info_html .= '<table style="margin-left: auto; margin-right: auto;"><tr><td style="text-align: center;"><small><strong>' . $key . '</strong></small></td></tr><tr><td style="text-align: center;">';
				
				foreach ( $val as $key2 => $timeslot ) {
					$relay_shipping_info_html .= '<p><small>' . $timeslot . '</small></p>';
				}
				
				$relay_shipping_info_html .= '</td></tr></table>';
				$relay_shipping_info_html .= '</td>';
			}
			
			$relay_shipping_info_html .= '</tr></table>';
			$relay_shipping_info_html .= '</td></tr></table></fieldset>';
			
			//echo $relay_shipping_info_html;
			

			$relay_shipping_info_txt = '';
			//$relay_shipping_info_txt .= "\n\n";
			//$relay_shipping_info_txt .= '#-----------------------------------------#'."\n";
			//$relay_shipping_info_txt .= '<strong>'.lang('shipping_notice_relay_point_1_b').'</strong><br>';
			//$relay_shipping_info_txt .= '<span>'.lang('shipping_notice_relay_point_2').'</span><br>';
			if ($relay_pt->Name != '') {
				$relay_shipping_info_txt .= '<span id="ParcelShopName">' . trim ( $relay_pt->Name ) . '</span><br>' . "\n\r";
			}
			if ($relay_pt->Adress1 != '') {
				$relay_shipping_info_txt .= '<span id="ParcelShopAdress1">' . trim ( $relay_pt->Adress1 ) . '</span><br>' . "\n\r";
			}
			if ($relay_pt->Adress2 != '') {
				$relay_shipping_info_txt .= '<span id="ParcelShopAdress2">' . trim ( $relay_pt->Adress2 ) . '</span><br>' . "\n\r";
			}
			$relay_shipping_info_txt .= '<span><span id="ParcelShopCity">' . trim ( $relay_pt->City ) . '</span>, <span id="ParcelShopPostCode">' . trim ( $relay_pt->PostCode ) . '</span> <span id="ParcelShopCountryCode">' . trim ( $relay_pt->CountryCode ) . '</span></span><br><br>' . "\n\r";
			$relay_shipping_info_txt .= '<span>' . lang ( 'shipping_notice_relay_point_3_b' ) . ' : <span id="ParcelShopId">' . $relay_pt->ParcelShopId . '</span></span>' . "\n\r";
			//$relay_shipping_info_txt .= '#-----------------------------------------#';
			//$relay_shipping_info_txt .= "\n\n";
			

			$respone = array ('relay_shipping_info_html' => $relay_shipping_info_html, 'relay_shipping_info_txt' => $relay_shipping_info_txt );
			
			return $respone;
		} else {
			return false;
		}
	}
	
	function step_3() {
		/*
		Some error checking
		see if we have the billing address
		*/
		$customer = $this->go_cart->customer ();
		if (empty ( $customer ['bill_address'] )) {
			redirect ( 'checkout/step_1' );
		}
		
		/* see if shipping is required and set. */
		if (config_item ( 'require_shipping' ) && $this->go_cart->requires_shipping () && $this->_get_shipping_methods ()) {
			$code = $this->validate_shipping_option ( $this->go_cart->shipping_code () );
			
			if (! $code) {
				redirect ( 'checkout/step_2' );
			}
		}
		
		/* check if a relay point is defined for shipping method info MONDIAL RELAY */
		if (preg_match ( '/MONDIAL RELAY/i', $this->go_cart->shipping_method_name () )) {
			if (! $this->go_cart->shipping_relay_point_num ()) {
				$this->session->set_flashdata ( 'error', lang ( 'choose_relay_point' ) );
				redirect ( 'checkout/step_2' );
			}
		}
		
		if ($payment_methods = $this->_get_payment_methods ()) {
			$this->payment_form ( $payment_methods );
		} /* now where? continue to step 4 */
		else {
			$this->step_4 ();
		}
	}
	
	protected function payment_form($payment_methods) {
		/* find out if we need to display the shipping */
		$this->data ['customer'] = $this->go_cart->customer ();
		$this->data ['shipping_method'] = $this->go_cart->shipping_method ();
		
		/* are the being bounced back? */
		$this->data ['payment_method'] = $this->go_cart->payment_method ();
		
		/* pass in the payment methods */
		$this->data ['payment_methods'] = $payment_methods;
		
		/* require that a payment method is selected */
		$this->form_validation->set_rules ( 'module', 'lang:payment_method', 'trim|required|xss_clean|callback_check_payment' );
		
		$module = $this->input->post ( 'module' );
		if ($module) {
			$this->load->add_package_path ( APPPATH . 'packages/payment/' . $module . '/' );
			$this->load->library ( $module );
		}
		
		if ($this->form_validation->run () == false) {
			if (! $this->config->item ( 'compact_html' )) {
				$this->load->view ( 'header', $this->data );
				$this->load->view ( 'checkout/payment_form', $this->data );
				$this->load->view ( 'footer', $this->data );
			} else {
				$this->compact_view ( $this->view ( 'header', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'checkout/payment_form', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'footer', $this->data, TRUE ) );
			}
		} else {
			$this->go_cart->set_payment ( $module, $this->$module->description () );
			redirect ( 'checkout/step_4' );
		}
	}
	/* callback that lets the payment method return an error if invalid */
	function check_payment($module) {
		$check = $this->$module->checkout_check ();
		
		if (! $check) {
			return true;
		} else {
			$this->form_validation->set_message ( 'check_payment', $check );
		}
	}
	
	private function _get_payment_methods() {
		$payment_methods = array ();
		if ($this->go_cart->total () != 0) {
			foreach ( $this->Settings_model->get_settings ( 'payment_modules' ) as $payment_method => $order ) {
				$this->load->add_package_path ( APPPATH . 'packages/payment/' . $payment_method . '/' );
				$this->load->library ( $payment_method );
				
				$payment_form = $this->$payment_method->checkout_form ();
				
				if (! empty ( $payment_form )) {
					/*Load all available payment methods without distinction*/
					//$payment_methods[$payment_method] = $payment_form;
					

					/*Select particular payment methods according to criteria*/
					if ($payment_method == "paypal_express") {
						$payment_methods [$payment_method] = $payment_form;
					}
					
					//if($payment_method == "bnp_parisbas" && $this->session->userdata('currency') == 'EUR')
					if ($payment_method == "bnp_parisbas") {
						$payment_methods [$payment_method] = $payment_form;
					}
				}
			}
		}
		if (! empty ( $payment_methods )) {
			return $payment_methods;
		} else {
			return false;
		}
	}
	
	function step_4() {
		/* get addresses */
		$this->data ['customer'] = $this->go_cart->customer ();
		
		$this->data ['shipping_method'] = $this->go_cart->shipping_method ();
		
		$this->data ['payment_method'] = $this->go_cart->payment_method ();
		
		$this->go_cart->update_connected_products ();
		
		/* Confirm the sale */
		if (! $this->config->item ( 'compact_html' )) {
			$this->load->view ( 'header', $this->data );
			$this->load->view ( 'checkout/confirm', $this->data );
			$this->load->view ( 'footer', $this->data );
		} else {
			$this->compact_view ( $this->view ( 'header', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'checkout/confirm', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'footer', $this->data, TRUE ) );
		}
	}
	
	function login() {
		$this->Customer_model->is_logged_in ( 'checkout' );
	}
	
	function register() {
		$this->Customer_model->is_logged_in ( 'checkout', 'secure/register' );
	}
	
	function place_order() {
		// retrieve the payment method
		$payment = $this->go_cart->payment_method ();
		$payment_methods = $this->_get_payment_methods ();
		
		$quid_2 = $this->go_cart->get_quid_2 ();
		
		//make sure they're logged in if the config file requires it
		if ($this->config->item ( 'require_login' )) {
			$this->Customer_model->is_logged_in ();
		}
		
		// are we processing an empty cart?
		$contents = $this->go_cart->contents ();
		if (empty ( $contents )) {
			redirect ( 'cart/view_cart' );
		} else {
			//  - check to see if we have a payment method set, if we need one
			if (empty ( $payment ) && $this->go_cart->total () > 0 && ( bool ) $payment_methods == true) {
				redirect ( 'checkout/step_3' );
			}
		}
		
		if (! empty ( $payment ) && ( bool ) $payment_methods == true) {
			if ($payment ['module'] == "paypal_express") {
				//load the payment module
				$this->load->add_package_path ( APPPATH . 'packages/payment/' . $payment ['module'] . '/' );
				$this->load->library ( $payment ['module'] );
				
				// Is payment bypassed? (total is zero, or processed flag is set)
				if ($this->go_cart->total () > 0 && ! isset ( $payment ['confirmed'] )) {
					//run the payment
					$error_status = $this->$payment ['module']->process_payment ();
					if ($error_status !== false) {
						// send them back to the payment page with the error
						$this->session->set_flashdata ( 'error', $error_status );
						redirect ( 'checkout/step_3' );
					}
				}
			}
			if ($payment ['module'] == "bnp_parisbas") {
				//load the payment module
				$this->load->add_package_path ( APPPATH . 'packages/payment/' . $payment ['module'] . '/' );
				$this->load->library ( $payment ['module'] );
				
				// Is payment bypassed? (total is zero, or processed flag is set)
				if ($this->go_cart->total () > 0 && ! isset ( $payment ['confirmed'] )) {
					//run the payment
					

					/*We do this first for bnp payment because of call_autoresponse*/
					$order_id = $this->go_cart->save_order ();
					
					$error_status = $this->$payment ['module']->process_payment ();
					if ($error_status !== false) {
						// send them back to the payment page with the error
						$this->session->set_flashdata ( 'error', $error_status );
						redirect ( 'checkout/step_3' );
					
		//print_r_html($error_status);
					}
				}
			}
		}
		
		if (! empty ( $payment ) && ( bool ) $payment_methods == true) {
			if ($payment ['module'] != "bnp_parisbas") {
				// save the order
				$order_id = $this->go_cart->save_order ();
			}
		}
		
		//$this->data['order_id']			= $order_id;
		$this->data ['order_id'] = $quid_2;
		$this->data ['shipping'] = $this->go_cart->shipping_method ();
		$this->data ['payment'] = $this->go_cart->payment_method ();
		$this->data ['customer'] = $this->go_cart->customer ();
		$this->data ['shipping_notes'] = $this->go_cart->get_additional_detail ( 'shipping_notes' );
		$this->data ['referral'] = $this->go_cart->get_additional_detail ( 'referral' );
		
		$order_downloads = $this->go_cart->get_order_downloads ();
		
		$this->data ['hide_menu'] = true;
		
		// run the complete payment module method once order has been saved
		if (! empty ( $payment )) {
			/*
			if(method_exists($this->$payment['module'], 'complete_payment'))
			{
				$this->$payment['module']->complete_payment($this->data);
			}
			*/
			
			if ($payment ['module'] == "paypal_express") {
				//load the payment module
				$this->load->add_package_path ( APPPATH . 'packages/payment/' . $payment ['module'] . '/' );
				$this->load->library ( $payment ['module'] );
				
				$error_respnse = $this->$payment ['module']->complete_payment ( $this->data );
				
				if ($error_respnse) {
					// mysql error check
					echo $error_respnse;
				}
			}
			if ($payment ['module'] == "bnp_parisbas") {
				//load the payment module
				$this->load->add_package_path ( APPPATH . 'packages/payment/' . $payment ['module'] . '/' );
				$this->load->library ( $payment ['module'] );
				
				$error_respnse = $this->$payment ['module']->complete_payment ( $this->data );
				
				if ($error_respnse) {
					// mysql error check
					echo $error_respnse;
				}
			}
		}
		
		// Send the user a confirmation email
		

		/*
		// - get the email template
		$this->load->model('messages_model');
		$row = $this->messages_model->get_message(7);
		
		$download_section = '';
		if( ! empty($order_downloads))
		{
			// get the download link segment to insert into our confirmations
			$downlod_msg_record = $this->messages_model->get_message(8);
			
			if(!empty($this->data['customer']['id']))
			{
				// they can access their downloads by logging in
				$download_section = str_replace('{download_link}', anchor('secure/my_downloads', lang('download_link')),$downlod_msg_record['content']);
			} else {
				// non regs will receive a code
				$download_section = str_replace('{download_link}', anchor('secure/my_downloads/'.$order_downloads['code'], lang('download_link')), $downlod_msg_record['content']);
			}
		}
		
		$row['content'] = html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		$row['subject'] = str_replace('{customer_name}', $this->data['customer']['firstname'].' '.$this->data['customer']['lastname'], $row['subject']);
		$row['content'] = str_replace('{customer_name}', $this->data['customer']['firstname'].' '.$this->data['customer']['lastname'], $row['content']);
		
		// {url}
		$row['subject'] = str_replace('{url}', $this->config->item('base_url'), $row['subject']);
		$row['content'] = str_replace('{url}', $this->config->item('base_url'), $row['content']);
		
		// {site_name}
		$row['subject'] = str_replace('{site_name}', $this->config->item('company_name'), $row['subject']);
		$row['content'] = str_replace('{site_name}', $this->config->item('company_name'), $row['content']);
			
		// {order_summary}
		$row['content'] = str_replace('{order_summary}', $this->load->view('order_email', $this->data, true), $row['content']);
		
		// {download_section}
		$row['content'] = str_replace('{download_section}', $download_section, $row['content']);
			
		$this->load->library('email');
		
		//$config['mailtype'] = 'html';
		//$this->email->initialize($config);

		$this->email->from($this->config->item('email'), $this->config->item('company_name'));
		
		if($this->Customer_model->is_logged_in(false, false))
		{
			$this->email->to($this->data['customer']['email']);
		}
		else
		{
			$this->email->to($this->data['customer']['ship_address']['email']);
		}
		
		//email the admin
		$this->email->bcc(array($this->config->item('email'), $this->config->item('email_backup_orders')));
		
		$this->email->subject($row['subject']);
		$this->email->message($row['content']);
		
		$this->email->send();
		*/
		
		// Send the user a confirmation email
		

		$this->CI = & get_instance ();
		$this->CI->load->library ( 'email' );
		
		// - get the email template
		$this->load->model ( 'messages_model' );
		$row = $this->messages_model->get_message ( 7 );
		
		$download_section = '';
		if (! empty ( $order_downloads )) {
			// get the download link segment to insert into our confirmations
			$downlod_msg_record = $this->messages_model->get_message ( 8 );
			
			if (! empty ( $this->data ['customer'] ['id'] )) {
				// they can access their downloads by logging in
				$download_section = str_replace ( '{download_link}', anchor ( 'secure/my_downloads', lang ( 'download_link' ) ), $downlod_msg_record ['content'] );
			} else {
				// non regs will receive a code
				$download_section = str_replace ( '{download_link}', anchor ( 'secure/my_downloads/' . $order_downloads ['code'], lang ( 'download_link' ) ), $downlod_msg_record ['content'] );
			}
		}
		
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
		
		$row ['content'] = $this->load->view ( 'order_email_header', $this->data, true ) . $row ['content'] . $this->load->view ( 'order_email_footer', $this->data, true );
		
		// set replacement values for subject & body
		// {customer_name}
		$row ['subject'] = str_replace ( '{customer_name}', $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'], $row ['subject'] );
		$row ['content'] = str_replace ( '{customer_name}', $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'], $row ['content'] );
		
		// {url}
		$row ['subject'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $row ['subject'] );
		$row ['content'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $row ['content'] );
		
		// {site_name}
		$row ['subject'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $row ['subject'] );
		$row ['content'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $row ['content'] );
		
		// {order_summary}
		$row ['content'] = str_replace ( '{order_summary}', $this->load->view ( 'order_email', $this->data, true ), $row ['content'] );
		
		// {download_section}
		$row ['content'] = str_replace ( '{download_section}', $download_section, $row ['content'] );
		
		if (preg_match ( '/localhost/', $_SERVER ["HTTP_HOST"] )) {
			$config_phpmailer ['Host'] = "ssl://smtp.googlemail.com";
			$config_phpmailer ['Port'] = "465";
			//$config_phpmailer['Port'] 				= "587"; //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			$config_phpmailer ['SMTPSecure'] = "tls";
			$config_phpmailer ['Username'] = "inoescherer@gmail.com";
			$config_phpmailer ['Password'] = "85andinoui";
			$config_phpmailer ['SMTPAuth'] = true;
			$config_phpmailer ['Timeout'] = "5";
			
			if ($this->Customer_model->is_logged_in ( false, false )) {
				$phpmailer_data ['ToEmail'] = $config_phpmailer ['Username'];
			} else {
				if ($this->data ['customer'] ['bill_address'] ['email'] != $this->data ['customer'] ['ship_address'] ['email']) {
					$phpmailer_data ['ToEmail'] = $config_phpmailer ['Username'];
				} else {
					$phpmailer_data ['ToEmail'] = $config_phpmailer ['Username'];
				}
			}
			
			$phpmailer_data ['ToName'] = $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'];
			$phpmailer_data ['FromName'] = $this->config->item ( 'company_name' );
			$phpmailer_data ['From'] = $this->config->item ( 'email' );
			$phpmailer_data ['addCC'] = $this->config->item ( 'email_contact' );
			$phpmailer_data ['addBCC'] = $this->config->item ( 'email_backup_orders' );
			$phpmailer_data ['Subject'] = $row ['subject'];
			$phpmailer_data ['Body'] = $row ['content'];
		
		//$this->email->init_php_mailer_email($config_phpmailer, true);
		//$this->email->send_php_mailer_email($phpmailer_data, true);
		

		} else {
			/*//////////////////////////////////////////// CONFIRMATION EMAIL THRU MANDRILL SMTP ///////////////////////////////////////////*/
			
			/*
			$config_phpmailer['Host'] 					= "smtp.mandrillapp.com";
			$config_phpmailer['Port'] 					= "25";
			$config_phpmailer['SMTPSecure'] 			= "tls";
			$config_phpmailer['Username'] 				= "boutique@couettabra.com";
			$config_phpmailer['Password'] 				= "EtApXETYhBaLtQFfHI6sNw";
			$config_phpmailer['SMTPAuth'] 				= true;
			$config_phpmailer['Timeout'] 				= "5";
			
			$this->email->init_php_mailer_email($config_phpmailer, false);
			
			if($this->Customer_model->is_logged_in(false, false))
			{
				$phpmailer_data['ToEmail'] 	 		= $this->data['customer']['email'];
			}
			else
			{
				if($this->data['customer']['bill_address']['email'] != $this->data['customer']['ship_address']['email'])
				{
					$phpmailer_data['ToEmail'] 	  	= $this->data['customer']['bill_address']['email'];
				}
				else
				{
					$phpmailer_data['ToEmail'] 	 	= $this->data['customer']['ship_address']['email'];
				}
			}
			
			$phpmailer_data['ToName'] 						= $this->data['customer']['firstname'].' '.$this->data['customer']['lastname'];
			$phpmailer_data['FromName']						= $this->config->item('company_name');
			$phpmailer_data['From']							= $this->config->item('email');
			$phpmailer_data['addCC']						= $this->config->item('email_contact');
			$phpmailer_data['addBCC']						= $this->config->item('email_backup_orders');
			$phpmailer_data['Subject']						= $row['subject'];
			$phpmailer_data['Body']							= $row['content'];
			
			$this->email->send_php_mailer_email($phpmailer_data, false);
			*/
			
			/*//////////////////////////////////////////// CONFIRMATION EMAIL THRU MANDRILL API ////////////////////////////////////////////*/
			
			if ($this->Customer_model->is_logged_in ( false, false )) {
				$senderEmail = $this->data ['customer'] ['email'];
			} else {
				if ($this->data ['customer'] ['bill_address'] ['email'] != $this->data ['customer'] ['ship_address'] ['email']) {
					$senderEmail = $this->data ['customer'] ['bill_address'] ['email'];
				} else {
					$senderEmail = $this->data ['customer'] ['ship_address'] ['email'];
				}
			}
			
			$this->CI = & get_instance ();
			$this->CI->load->library ( 'mandrill' );
			
			date_default_timezone_set ( "UTC" );
			$sent_date_time = date ( "Y-m-d H:i:s", time () );
			
			$this->CI->mandrill = new Mandrill ( 'EtApXETYhBaLtQFfHI6sNw' );
			$message = array ('html' => $row ['content'], //'text' => 'Example text content',
			'subject' => $row ['subject'], 'from_email' => $this->config->item ( 'email' ), 'from_name' => $this->config->item ( 'company_name' ), 'to' => array (array ('email' => $senderEmail, 'name' => $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'], 'type' => 'to' ), array ('email' => $this->config->item ( 'email_contact' ), 'name' => $this->config->item ( 'company_name' ), 'type' => 'cc' ) ), 'headers' => array ('Reply-To' => $this->config->item ( 'email_contact' ) ), 'important' => true, 'track_opens' => true, 'track_clicks' => true, 'auto_text' => true, 'auto_html' => null, 'inline_css' => null, 'url_strip_qs' => null, 'preserve_recipients' => null, 'view_content_link' => null, 'bcc_address' => $this->config->item ( 'email_backup_orders' ), 'tracking_domain' => 'clairetnathalie.com', 'signing_domain' => 'clairetnathalie.com', 'return_path_domain' => null, 'tags' => array ('purchased-item' ), 'subaccount' => null, 'google_analytics_domains' => array ('clairetnathalie.com' ), 'google_analytics_campaign' => 'message.from_email@clairetnathalie.com', 'metadata' => array ('website' => 'www.clairetnathalie.com' ) );
			$async = false;
			$ip_pool = 'Main Pool';
			$send_at = $sent_date_time;
			//$result = $this->CI->mandrill->messages->send($message, $async, $ip_pool, $send_at);
			$result = $this->CI->mandrill->messages->send ( $message, $async, $ip_pool, null );
			
		/*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
		}
		
		if ($this->config->item ( 'language' ) == 'french') {
			$this->data ['page_title'] = 'Merci d\'avoir acheter avec ' . $this->config->item ( 'company_name' );
		} else {
			$this->data ['page_title'] = 'Thanks for shopping with ' . $this->config->item ( 'company_name' );
		}
		
		$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
		$this->data ['download_section'] = $download_section;
		
		/* get all cart information before destroying the cart session info */
		$this->data ['go_cart'] ['group_discount'] = $this->go_cart->group_discount ();
		$this->data ['go_cart'] ['type_of_group_discount'] = $this->go_cart->get_type_of_group_discount_formula ();
		$this->data ['go_cart'] ['total_items'] = $this->go_cart->total_items ();
		$this->data ['go_cart'] ['subtotal'] = $this->go_cart->subtotal ();
		$this->data ['go_cart'] ['coupon_discount'] = $this->go_cart->coupon_discount ();
		$this->data ['go_cart'] ['order_tax'] = $this->go_cart->order_tax ();
		$this->data ['go_cart'] ['discounted_subtotal'] = $this->go_cart->discounted_subtotal ();
		$this->data ['go_cart'] ['shipping_cost'] = $this->go_cart->shipping_cost ();
		$this->data ['go_cart'] ['gift_card_discount'] = $this->go_cart->gift_card_discount ();
		$this->data ['go_cart'] ['custom_charges'] = $this->go_cart->get_custom_charges ();
		$this->data ['go_cart'] ['total'] = $this->go_cart->total ();
		$this->data ['go_cart'] ['contents'] = $this->go_cart->contents ();
		
		$this->data ['go_cart'] ['tax_is_vat'] = $this->go_cart->get_is_tax_vat ();
		$this->data ['go_cart'] ['taxable_total_vat'] = $this->go_cart->taxable_total_vat ();
		$this->data ['go_cart'] ['total_vat'] = $this->go_cart->total_vat ();
		$this->data ['go_cart'] ['tax_vat'] = $this->go_cart->order_tax_vat ();
		$this->data ['go_cart'] ['total_items'] = $this->go_cart->total_items ();
		$this->data ['go_cart'] ['tax_rate_in_use'] = $this->go_cart->tax_rate_in_use ();
		
		/* remove the cart from the session */
		$this->go_cart->destroy ();
		
		/*  show final confirmation page */
		if (! $this->config->item ( 'compact_html' )) {
			$this->load->view ( 'header', $this->data );
			$this->load->view ( 'order_placed', $this->data );
			$this->load->view ( 'footer', $this->data );
		} else {
			$this->compact_view ( $this->view ( 'header', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'order_placed', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'footer', $this->data, TRUE ) );
		}
	}
	
	function print_r_html($arr) {
		?><pre><?
		print_r ( $arr );
		?></pre><?
	}
	
	function test_send_email() {
		$quid_2 = $this->go_cart->get_quid_2 ();
		
		$this->data ['customer'] = $this->go_cart->customer ();
		
		$this->data ['shipping_method'] = $this->go_cart->shipping_method ();
		
		$this->data ['payment_method'] = $this->go_cart->payment_method ();
		
		// are we processing an empty cart?
		$contents = $this->go_cart->contents ();
		
		$this->data ['order_id'] = $quid_2;
		$this->data ['shipping'] = $this->go_cart->shipping_method ();
		$this->data ['payment'] = $this->go_cart->payment_method ();
		$this->data ['customer'] = $this->go_cart->customer ();
		$this->data ['shipping_notes'] = $this->go_cart->get_additional_detail ( 'shipping_notes' );
		$this->data ['referral'] = $this->go_cart->get_additional_detail ( 'referral' );
		
		$order_downloads = $this->go_cart->get_order_downloads ();
		
		// Send the user a confirmation email
		

		$this->CI = & get_instance ();
		$this->CI->load->library ( 'email' );
		
		// - get the email template
		$this->load->model ( 'messages_model' );
		$row = $this->messages_model->get_message ( 7 );
		
		$download_section = '';
		if (! empty ( $order_downloads )) {
			// get the download link segment to insert into our confirmations
			$downlod_msg_record = $this->messages_model->get_message ( 8 );
			
			if (! empty ( $this->data ['customer'] ['id'] )) {
				// they can access their downloads by logging in
				$download_section = str_replace ( '{download_link}', anchor ( 'secure/my_downloads', lang ( 'download_link' ) ), $downlod_msg_record ['content'] );
			} else {
				// non regs will receive a code
				$download_section = str_replace ( '{download_link}', anchor ( 'secure/my_downloads/' . $order_downloads ['code'], lang ( 'download_link' ) ), $downlod_msg_record ['content'] );
			}
		}
		
		$row ['content'] = html_entity_decode ( $row ['content'] );
		//$row['content'] = mb_convert_encoding(html_entity_decode($row['content']), 'HTML-ENTITIES', 'UTF-8');
		//$row['content'] = htmlspecialchars(mb_convert_encoding($row['content'], 'HTML-ENTITIES', 'UTF-8'));
		//$row['content'] = htmlspecialchars($row['content']);
		

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
		
		$row ['content'] = $this->load->view ( 'order_email_header', $this->data, true ) . $row ['content'] . $this->load->view ( 'order_email_footer', $this->data, true );
		
		// set replacement values for subject & body
		// {customer_name}
		$row ['subject'] = str_replace ( '{customer_name}', $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'], $row ['subject'] );
		$row ['content'] = str_replace ( '{customer_name}', $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'], $row ['content'] );
		
		// {url}
		$row ['subject'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $row ['subject'] );
		$row ['content'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $row ['content'] );
		
		// {site_name}
		$row ['subject'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $row ['subject'] );
		$row ['content'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $row ['content'] );
		
		// {order_summary}
		$row ['content'] = str_replace ( '{order_summary}', $this->load->view ( 'order_email', $this->data, true ), $row ['content'] );
		
		// {download_section}
		$row ['content'] = str_replace ( '{download_section}', $download_section, $row ['content'] );
		
		echo $row ['content'];
		
		/*
		//$this->load->library('email');
		
		$config_mandrill['protocol'] 			= "smtp";
		$config_mandrill['mailtype'] 			= "html";
		$config_mandrill['smtp_host'] 			= "smtp.mandrillapp.com";
		$config_mandrill['smtp_port'] 			= "587";
		$config_mandrill['smtp_user'] 			= "boutique@couettabra.com";
		$config_mandrill['smtp_pass'] 			= "EtApXETYhBaLtQFfHI6sNw";
		$config_mandrill['smtp_timeout'] 		= "5";
		$config_mandrill['charset']  			= "utf-8";
		$config_mandrill['newline'] 			= "\r\n";
		
		$config_gmail['protocol'] 				= "smtp";
		$config_gmail['mailtype'] 				= "html";
		$config_gmail['smtp_host'] 				= "ssl://smtp.googlemail.com";
		$config_gmail['smtp_port'] 				= "465";
		$config_gmail['smtp_user'] 				= "inoescherer@gmail.com";
		$config_gmail['smtp_pass'] 				= "85andinoui";
		//$config_gmail['smtp_crypto'] 			= "tls"; //very important line, don't remove it
		$config_gmail['smtp_timeout'] 			= "5"; //google hint
		$config_gmail['charset']  				= "utf-8";
		$config_gmail['newline'] 				= "\r\n";
		
		$config_inoe_clairetnathalie['protocol'] 	= "smtp";
		$config_inoe_clairetnathalie['mailtype'] 	= "html";
		$config_inoe_clairetnathalie['smtp_host'] 	= "clairetnathalie.com";
		$config_inoe_clairetnathalie['smtp_port'] 	= "25";
		$config_inoe_clairetnathalie['smtp_user'] 	= "inoe@clairetnathalie.com";
		$config_inoe_clairetnathalie['smtp_pass'] 	= "ch0Sen0Ne";
		
		//$this->email->initialize($config_mandrill);
		//$this->email->initialize($config_gmail);
		
		$this->load->library('email', $config_gmail);
		
		$this->email->set_header('_encoding', 'base64');
		
		$this->email->from($this->config->item('email'), $this->config->item('company_name'));
		
		if($this->Customer_model->is_logged_in(false, false))
		{
			$this->email->to($this->data['customer']['email']);
		}
		else
		{
			$this->email->to($this->data['customer']['ship_address']['email']);
		}
		
		//email the admin
		//$this->email->bcc(array($this->config->item('email'), $this->config->item('email_backup_orders')));
		
		$this->email->subject($row['subject']);
		$this->email->message($row['content']);
		
		echo $this->email->my_print_email_headers();
		
		if($this->email->send())
	    {
	      	echo 'Email sent.';
	    }
	    else
	   	{
	     	show_error($this->email->print_debugger());
	   	}
	   	*/
		
		if (preg_match ( '/localhost/', $_SERVER ["HTTP_HOST"] )) {
			$config_phpmailer ['Host'] = "ssl://smtp.googlemail.com";
			$config_phpmailer ['Port'] = "465";
			//$config_phpmailer['Port'] 				= "587"; //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			$config_phpmailer ['SMTPSecure'] = "tls";
			$config_phpmailer ['Username'] = "inoescherer@gmail.com";
			$config_phpmailer ['Password'] = "85andinoui";
			$config_phpmailer ['SMTPAuth'] = true;
			$config_phpmailer ['Timeout'] = "5";
			
			/*
			$path = $this->config->item('upload_server_path').'wysiwyg/email/cn_corner-email-top-left.png';
			$image_data = array(
					'path' => $path,
					'name' => 'top_left_corner',
					'type' => pathinfo($path, PATHINFO_EXTENSION)
				);
			$this->email->embed_image_php_mailer($image_data);
			
			$path = $this->config->item('upload_server_path').'wysiwyg/email/cn_corner-email-bottom-right.png';
			$image_data = array(
					'path' => $path,
					'name' => 'bottom_right_corner',
					'type' => pathinfo($path, PATHINFO_EXTENSION)
				);
			$this->email->embed_image_php_mailer($image_data);
			
			$path = $this->config->item('upload_server_path').'wysiwyg/email/cn_logo-email_top_654x113px.png';
			$image_data = array(
					'path' => $path,
					'name' => 'top_logo',
					'type' => pathinfo($path, PATHINFO_EXTENSION)
				);
			$this->email->embed_image_php_mailer($image_data);
			
			$path = $this->config->item('upload_server_path').'wysiwyg/email/cn_logo-email_bottom_654x20px.png';
			$image_data = array(
					'path' => $path,
					'name' => 'bottom_logo',
					'type' => pathinfo($path, PATHINFO_EXTENSION)
				);
			$this->email->embed_image_php_mailer($image_data);
			*/
			
			/*
			$path = $this->config->item('upload_server_path').'css/order_email_stylesheet.css';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data 	= file_get_contents($path);
			$base64 = 'data:text/' . $type . ';base64,' . base64_encode($data);
			$image_data = array(
					'encoded_string' => $base64,
					'name' => 'order_email_stylesheet',
					'type' => 'text/'.$type
				);
			$this->email->embed_image_string_php_mailer($image_data);
			*/
			
			/*
			$path = $this->config->item('upload_server_path').'wysiwyg/email/cn_corner-email-top-left.png';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data 	= file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			$image_data = array(
					'encoded_string' => $base64,
					'name' => 'top_left_corner',
					'type' => 'image/'.$type
				);
			$this->email->embed_image_string_php_mailer($image_data);
			
			$path = $this->config->item('upload_server_path').'wysiwyg/email/cn_corner-email-bottom-right.png';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data 	= file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			$image_data = array(
					'encoded_string' => $base64,
					'name' => 'bottom_right_corner',
					'type' => 'image/'.$type
				);
			$this->email->embed_image_string_php_mailer($image_data);
			
			$path = $this->config->item('upload_server_path').'wysiwyg/email/cn_logo-email_top_654x113px.png';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data 	= file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			$image_data = array(
					'encoded_string' => $base64,
					'name' => 'top_logo',
					'type' => 'image/'.$type
				);
			$this->email->embed_image_string_php_mailer($image_data);
			
			$path = $this->config->item('upload_server_path').'wysiwyg/email/cn_logo-email_bottom_654x20px.png';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data 	= file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			$image_data = array(
					'encoded_string' => $base64,
					'name' => 'bottom_logo',
					'type' => 'image/'.$type
				);
			$this->email->embed_image_string_php_mailer($image_data);
			*/
			
			if ($this->Customer_model->is_logged_in ( false, false )) {
				$phpmailer_data ['ToEmail'] = $this->data ['customer'] ['email'];
			} else {
				if ($this->data ['customer'] ['bill_address'] ['email'] != $this->data ['customer'] ['ship_address'] ['email']) {
					$phpmailer_data ['ToEmail'] = $this->data ['customer'] ['bill_address'] ['email'];
				} else {
					$phpmailer_data ['ToEmail'] = $this->data ['customer'] ['ship_address'] ['email'];
				}
			}
			
			$phpmailer_data ['ToName'] = $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'];
			$phpmailer_data ['FromName'] = $this->config->item ( 'company_name' );
			$phpmailer_data ['From'] = $this->config->item ( 'email' );
			$phpmailer_data ['addCC'] = $this->config->item ( 'email_contact' );
			$phpmailer_data ['addBCC'] = $this->config->item ( 'email_backup_orders' );
			$phpmailer_data ['Subject'] = $row ['subject'];
			$phpmailer_data ['Body'] = $row ['content'];
			
			$this->email->init_php_mailer_email ( $config_phpmailer, true );
			$this->email->send_php_mailer_email ( $phpmailer_data, true );
		
		} else {
			$config_phpmailer ['Host'] = "smtp.mandrillapp.com";
			$config_phpmailer ['Port'] = "25";
			$config_phpmailer ['SMTPSecure'] = "tls";
			$config_phpmailer ['Username'] = "boutique@couettabra.com";
			$config_phpmailer ['Password'] = "EtApXETYhBaLtQFfHI6sNw";
			$config_phpmailer ['SMTPAuth'] = true;
			$config_phpmailer ['Timeout'] = "5";
			
			if ($this->Customer_model->is_logged_in ( false, false )) {
				$phpmailer_data ['ToEmail'] = $this->data ['customer'] ['email'];
			} else {
				if ($this->data ['customer'] ['bill_address'] ['email'] != $this->data ['customer'] ['ship_address'] ['email']) {
					$phpmailer_data ['ToEmail'] = $this->data ['customer'] ['bill_address'] ['email'];
				} else {
					$phpmailer_data ['ToEmail'] = $this->data ['customer'] ['ship_address'] ['email'];
				}
			}
			
			$phpmailer_data ['ToName'] = $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'];
			$phpmailer_data ['FromName'] = $this->config->item ( 'company_name' );
			$phpmailer_data ['From'] = $this->config->item ( 'email' );
			$phpmailer_data ['addCC'] = $this->config->item ( 'email_contact' );
			$phpmailer_data ['addBCC'] = $this->config->item ( 'email_backup_orders' );
			$phpmailer_data ['Subject'] = $row ['subject'];
			$phpmailer_data ['Body'] = $row ['content'];
			
			//$this->email->init_php_mailer_email($config_phpmailer, true);
			//$this->email->send_php_mailer_email($phpmailer_data, true);
			

			if ($this->Customer_model->is_logged_in ( false, false )) {
				$senderEmail = $this->data ['customer'] ['email'];
			} else {
				if ($this->data ['customer'] ['bill_address'] ['email'] != $this->data ['customer'] ['ship_address'] ['email']) {
					$senderEmail = $this->data ['customer'] ['bill_address'] ['email'];
				} else {
					$senderEmail = $this->data ['customer'] ['ship_address'] ['email'];
				}
			}
			
			$this->CI = & get_instance ();
			$this->CI->load->library ( 'mandrill' );
			
			date_default_timezone_set ( "UTC" );
			$sent_date_time = date ( "Y-m-d H:i:s", time () );
			
			try {
				$this->CI->mandrill = new Mandrill ( 'EtApXETYhBaLtQFfHI6sNw' );
				$message = array ('html' => $row ['content'], //'text' => 'Example text content',
				'subject' => $row ['subject'], 'from_email' => $this->config->item ( 'email' ), 'from_name' => $this->config->item ( 'company_name' ), 'to' => array (array ('email' => $senderEmail, 'name' => $this->data ['customer'] ['firstname'] . ' ' . $this->data ['customer'] ['lastname'], 'type' => 'to' ) ), 'headers' => array ('Reply-To' => $this->config->item ( 'email_contact' ) ), 'important' => true, 'track_opens' => true, 'track_clicks' => true, 'auto_text' => true, 'auto_html' => null, 'inline_css' => null, 'url_strip_qs' => null, 'preserve_recipients' => null, 'view_content_link' => null, //'bcc_address' => $this->config->item('email_backup_orders'),
				'tracking_domain' => 'clairetnathalie.com', 'signing_domain' => 'clairetnathalie.com', 'return_path_domain' => null,
			        /*
			        'merge' => true,
			        'global_merge_vars' => array(
			            array(
			                'name' => 'merge1',
			                'content' => 'merge1 content'
			            )
			        ),
			        'merge_vars' => array(
			            array(
			                'rcpt' => 'recipient.email@example.com',
			                'vars' => array(
			                    array(
			                        'name' => 'merge2',
			                        'content' => 'merge2 content'
			                    )
			                )
			            )
			        ),
			        */
			        'tags' => array ('purchased-item' ), 'subaccount' => null, 'google_analytics_domains' => array ('clairetnathalie.com' ), 'google_analytics_campaign' => 'message.from_email@clairetnathalie.com',
			        /*
			        'recipient_metadata' => array(
			            array(
			                'rcpt' => 'recipient.email@example.com',
			                'values' => array('user_id' => 123456)
			            )
			        ),
			        'attachments' => array(
			            array(
			                'type' => 'text/plain',
			                'name' => 'myfile.txt',
			                'content' => 'ZXhhbXBsZSBmaWxl'
			            )
			        ),
			        'images' => array(
			            array(
			                'type' => 'image/png',
			                'name' => 'IMAGECID',
			                'content' => 'ZXhhbXBsZSBmaWxl'
			            )
			        ),
			        */
			        'metadata' => array ('website' => 'www.clairetnathalie.com' ) );
				$async = false;
				$ip_pool = 'Main Pool';
				//$send_at = $sent_date_time;
				$result = $this->CI->mandrill->messages->send ( $message, $async, $ip_pool, $send_at );
				
				print_r ( $result );
			
			} catch ( Mandrill_Error $e ) {
				// Mandrill errors are thrown as exceptions
				echo 'A mandrill error occurred: ' . get_class ( $e ) . ' - ' . $e->getMessage ();
				// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
				throw $e;
			}
		
		}
	}
}