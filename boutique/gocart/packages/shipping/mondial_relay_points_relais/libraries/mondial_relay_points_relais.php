<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class mondial_relay_points_relais {
	var $CI;
	var $cart;
	
	var $customer;
	
	var $order_weight;
	var $order_price;
	
	var $Api_Url;
	var $Api_Login;
	var $Api_Password;
	
	var $order_country_code_iso2;
	var $order_city;
	var $order_zip;
	
	//var $my_post;
	

	function mondial_relay_points_relais() {
		$this->CI = & get_instance ();
		$this->CI->lang->load ( 'mondial_relay_points_relais' );
	
		//$this->my_post = $_POST;
	}
	
	function rates() {
		//$method either equals weight or price	
		//this can be set either from some sort of admin panel, or directly here.
		$this->CI->load->library ( 'session' );
		
		// get customer info
		$this->customer = $this->CI->go_cart->customer ();
		
		//if there is no address set then return blank
		if (empty ( $this->customer ['ship_address'] )) {
			return array ();
		}
		
		$this->order_weight = $this->get_order_weight ();
		$this->order_price = $this->get_order_price ();
		
		$this->order_country_code_iso2 = $this->CI->Location_model->get_iso2 ( $this->customer ['ship_address'] ['country_id'] );
		$this->order_city = $this->customer ['ship_address'] ['city'];
		$this->order_zip = $this->customer ['ship_address'] ['zip'];
		
		//$countries = $this->CI->Location_model->get_countries();
		

		$settings = $this->CI->Settings_model->get_settings ( 'mondial_relay_points_relais' );
		
		if ($settings) {
			if (! ( bool ) $settings ['enabled']) {
				return array ();
			}
			
			$this->Api_Url = $settings ['Api_Url'];
			$this->Api_Login = $settings ['Api_Login'];
			$this->Api_Password = $settings ['Api_Password'];
			
			if (empty ( $settings ['Api_Url'] ) || empty ( $settings ['Api_Login'] ) || empty ( $settings ['Api_Password'] )) {
				return array ();
			}
		}
		
		$rates = unserialize ( $settings ['rates'] );
		
		$return = array ();
		foreach ( $rates as $rate ) {
			if (( bool ) $rate ['country'] && ($rate ['country'] != $this->customer ['ship_address'] ['country_id'])) {
				// if the customer is not in the country specified by this table, then skip it
				continue;
			}
			
			//sort rates highest "From" to lowest
			krsort ( $rate ['rates'] );
			
			if ($rate ['method'] == 'weight') {
				foreach ( $rate ['rates'] as $key => $val ) {
					if ($this->CI->config->item ( 'language' ) == 'french') {
						if ($settings ['entity_common_name_fr'] != '') {
							$return [$rate ['name']] = array ('value' => $val, 'entity_common_name' => $settings ['entity_common_name_fr'], 'entity_description' => $settings ['entity_definition_fr'] );
						} else {
							$return [$rate ['name']] = array ('value' => $val, 'entity_common_name' => $val, 'entity_description' => $settings ['entity_definition_fr'] );
						}
					} elseif ($this->CI->config->item ( 'language' ) == 'english') {
						if ($settings ['entity_common_name_en'] != '') {
							$return [$rate ['name']] = array ('value' => $val, 'entity_common_name' => $settings ['entity_common_name_en'], 'entity_description' => $settings ['entity_definition_en'] );
						} else {
							$return [$rate ['name']] = array ('value' => $val, 'entity_common_name' => $val, 'entity_description' => $settings ['entity_definition_en'] );
						}
					}
					
					//$return[$rate['name']] = $val;
					if ($key <= $this->order_weight) {
						break;
					}
				}
			} elseif ($rate ['method'] == 'price') {
				foreach ( $rate ['rates'] as $key => $val ) {
					if ($this->CI->config->item ( 'language' ) == 'french') {
						if ($settings ['entity_common_name_fr'] != '') {
							$return [$rate ['name']] = array ('value' => $val, 'entity_common_name' => $settings ['entity_common_name_fr'], 'entity_description' => $settings ['entity_definition_fr'] );
						} else {
							$return [$rate ['name']] = array ('value' => $val, 'entity_common_name' => $val, 'entity_description' => $settings ['entity_definition_fr'] );
						}
					} elseif ($this->CI->config->item ( 'language' ) == 'english') {
						if ($settings ['entity_common_name_en'] != '') {
							$return [$rate ['name']] = array ('value' => $val, 'entity_common_name' => $settings ['entity_common_name_en'], 'entity_description' => $settings ['entity_definition_en'] );
						} else {
							$return [$rate ['name']] = array ('value' => $val, 'entity_common_name' => $val, 'entity_description' => $settings ['entity_definition_en'] );
						}
					}
					
					//$return[$rate['name']] = $val;
					if ($key <= $this->order_price) {
						break;
					}
				}
			}
		}
		
		return $return;
	}
	
	function get_points_relais_list() {
		$mondialrelay_config = array ('_APIEndPointUrl' => $this->Api_Url, '_APILogin' => $this->Api_Login, '_APIPassword' => $this->Api_Password, '_Debug' => false );
		
		$this->CI->load->library ( 'mondial_relay/MondialRelayWebAPI', $mondialrelay_config, 'mondial_relay_service' );
		
		$myParcelShopSearchResults = $this->CI->mondial_relay_service->SearchParcelShop ( $this->order_country_code_iso2, $this->order_zip );
		
		if ($myParcelShopSearchResults) {
			return $myParcelShopSearchResults;
		} else {
			return false;
		}
	}
	
	function request_point_relais_map($parcelShopID) {
		$mondialrelay_config = array ('_APIEndPointUrl' => $this->Api_Url, '_APILogin' => $this->Api_Login, '_APIPassword' => $this->Api_Password, '_Debug' => false );
		
		$this->CI->load->library ( 'mondial_relay/MondialRelayWebAPI', $mondialrelay_config, 'mondial_relay_service' );
		
		$myParcelShopMap = $this->CI->mondial_relay_service->GetParcelShopDetails ( $this->order_country_code_iso2, $parcelShopID );
		
		if ($myParcelShopMap) {
			return $myParcelShopMap;
		} else {
			return false;
		}
	}
	
	function mondial_relay_create_shipment($ShipmentDetails, $order_id) {
		$mondialrelay_config = array ('_APIEndPointUrl' => $this->Api_Url, '_APILogin' => $this->Api_Login, '_APIPassword' => $this->Api_Password, '_Debug' => false );
		
		$this->CI->load->library ( 'mondial_relay/MondialRelayWebAPI', $mondialrelay_config, 'mondial_relay_service' );
		
		$myShipment = $this->CI->mondial_relay_service->CreateShipment ( $ShipmentDetails, true );
		
		if ($myShipment) {
			return array ('order_id' => $order_id, 'etiquette' => $myShipment );
		} else {
			return false;
		}
	}
	
	function get_parcel_info_mondiale_relay($ShipmentRef) {
		$mondialrelay_config = array ('_APIEndPointUrl' => $this->Api_Url, '_APILogin' => $this->Api_Login, '_APIPassword' => $this->Api_Password, '_Debug' => true );
		
		$this->CI->load->library ( 'mondial_relay/MondialRelayWebAPI', $mondialrelay_config, 'mondial_relay_service' );
		
		$UserLogin = $this->CI->config->item ( 'MondialRelay_Login' );
		//$UserLogin = $this->CI->config->item('MondialRelay_MotdePasse');
		

		$myTracking = $this->CI->mondial_relay_service->GetShipmentConnectTracingLink ( $ShipmentRef, $UserLogin );
		
		if ($myTracking) {
			return $myTracking;
		} else {
			return false;
		}
	}
	
	function install() {
		
		$install = array ();
		$install ['enabled'] = false;
		
		$install ['Api_Url'] = '';
		$install ['Api_Login'] = '';
		$install ['Api_Password'] = '';
		
		$install ['entity_common_name_fr'] = '';
		$install ['entity_definition_fr'] = '';
		
		$install ['entity_common_name_en'] = '';
		$install ['entity_definition_en'] = '';
		
		$rate = array ();
		$rate [0] = array ();
		$rate [0] ['name'] = 'Example';
		$rate [0] ['method'] = 'price';
		$rate [0] ['country'] = 0;
		
		// install some example data
		$rate [0] ['rates'] = array ('80' => '85.00', '70' => '65.00', '60' => '55.00', '50' => '55.00', '40' => '45.00', '30' => '35.00', '20' => '25.00', '10' => '15.00', '0' => '5.00' );
		
		$install ['rates'] = serialize ( $rate );
		
		$this->CI->Settings_model->save_settings ( 'mondial_relay_points_relais', $install );
	}
	
	function uninstall() {
		$this->CI->Settings_model->delete_settings ( 'mondial_relay_points_relais' );
	}
	
	function form() {
		$this->CI->load->helper ( 'form' );
		//this same function processes the form
		if (! $_POST) {
			$settings = $this->CI->Settings_model->get_settings ( 'mondial_relay_points_relais' );
			$settings ['rates'] = unserialize ( $settings ['rates'] );
		} else {
			$settings ['Api_Url'] = $_POST ['api_url'];
			$settings ['Api_Login'] = $_POST ['api_login'];
			$settings ['Api_Password'] = $_POST ['api_password'];
			
			if ($this->CI->config->item ( 'language' ) == 'french') {
				$settings ['entity_common_name_fr'] = $_POST ['entity_common_name_fr'];
				$settings ['entity_definition_fr'] = $_POST ['entity_definition_fr'];
			} else {
				$settings ['entity_common_name_en'] = $_POST ['entity_common_name_en'];
				$settings ['entity_definition_en'] = $_POST ['entity_definition_en'];
			}
			
			$settings ['enabled'] = $_POST ['enabled'];
			$settings ['rates'] = $_POST ['rates'];
		}
		
		$countries = $this->CI->Location_model->get_countries_menu ();
		
		$data = $settings;
		$data ['countries'] = array (0 => lang ( 'all_countries' ) ) + $countries;
		
		return $this->CI->load->view ( 'mondial_relay_points_relais_form', $data, true );
	}
	
	function check() {
		if (empty ( $_POST )) {
			return '<div>' . lang ( 'empty_post' ) . '</div>';
		}
		
		$save ['enabled'] = $_POST ['enabled'];
		
		$rates = array ();
		foreach ( $_POST ['rate'] as $rate ) {
			if (isset ( $rate ['rates'] )) {
				$rate ['rates'] = $this->organize_rates ( $rate ['rates'] );
			} else {
				$rate ['rates'] = array ();
			}
			
			$rates [] = $rate;
		}
		$save ['rates'] = serialize ( $rates );
		
		$save ['Api_Url'] = $_POST ['api_url'];
		$save ['Api_Login'] = $_POST ['api_login'];
		$save ['Api_Password'] = $_POST ['api_password'];
		
		if ($this->CI->config->item ( 'language' ) == 'french') {
			$save ['entity_common_name_fr'] = $_POST ['entity_common_name_fr'];
			$save ['entity_definition_fr'] = $_POST ['entity_definition_fr'];
		} else {
			$save ['entity_common_name_en'] = $_POST ['entity_common_name_en'];
			$save ['entity_definition_en'] = $_POST ['entity_definition_en'];
		}
		
		//we save the settings if it gets here
		$this->CI->Settings_model->save_settings ( 'mondial_relay_points_relais', $save );
		
		return false;
	
	}
	
	function organize_rates($rates) {
		$new_rates = array ();
		foreach ( $rates as $r ) {
			if (is_numeric ( $r ['from'] ) && is_numeric ( $r ['rate'] )) {
				$new_rates [$r ['from']] = $r ['rate'];
			}
			ksort ( $new_rates );
		}
		return $new_rates;
	}
	
	function organize_post_rates() {
		$rates = array ();
		
		foreach ( $_POST ['from'] as $table => $list ) {
			foreach ( $list as $key => $value ) {
				$rates [$table] [$value] = $_POST ['rate'] [$table] [$key];
			}
			
			// sort the list
			krsort ( $rates [$table] );
		}
		
		return $rates;
	}
	
	function get_order_weight() {
		return $this->CI->go_cart->order_weight ();
	}
	
	function get_order_price() {
		return $this->CI->go_cart->subtotal ();
	}
	
	function get_country_code_iso2() {
		return $this->CI->go_cart->get_country_code_iso2 ();
	}
	
	function get_city() {
		return $this->CI->go_cart->get_city ();
	}
	
	function get_zip() {
		return $this->CI->go_cart->get_zip ();
	}
}
