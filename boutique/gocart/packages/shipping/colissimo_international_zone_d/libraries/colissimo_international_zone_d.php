<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class colissimo_international_zone_d {
	var $CI;
	var $cart;
	
	function colissimo_international_zone_d() {
		$this->CI = & get_instance ();
		$this->CI->lang->load ( 'colissimo_international_zone_d' );
	}
	
	function rates() {
		//$method either equals weight or price	
		//this can be set either from some sort of admin panel, or directly here.
		$this->CI->load->library ( 'session' );
		
		// get customer info
		$customer = $this->CI->go_cart->customer ();
		
		//if there is no address set then return blank
		if (empty ( $customer ['ship_address'] )) {
			return array ();
		}
		
		$settings = $this->CI->Settings_model->get_settings ( 'colissimo_international_zone_d' );
		
		if (! ( bool ) $settings ['enabled']) {
			return array ();
		}
		
		$rates = unserialize ( $settings ['rates'] );
		
		$order_weight = $this->get_order_weight ();
		$order_price = $this->get_order_price ();
		
		$countries = $this->CI->Location_model->get_countries ();
		
		$return = array ();
		foreach ( $rates as $rate ) {
			if (( bool ) $rate ['country'] && ($rate ['country'] != $customer ['ship_address'] ['country_id'])) {
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
					if ($key <= $order_weight) {
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
					//$return[$rate['name']] = $val;
					if ($key <= $order_price) {
						break;
					}
				}
			}
		}
		
		return $return;
	}
	
	function install() {
		
		$install = array ();
		$install ['enabled'] = false;
		
		$install ['entity_common_name_fr'] = '';
		$install ['entity_definition_fr'] = '';
		
		$install ['entity_common_name_en'] = '';
		$install ['entity_definition_en'] = '';
		
		$rate = array ();
		$rate [0] = array ();
		$rate [0] ['name'] = 'Example';
		$rate [0] ['method'] = 'weight';
		$rate [0] ['country'] = 0;
		
		// install some example data
		$rate [0] ['rates'] = array ('0.000' => '25.08', '1.000' => '37.72', '2.000' => '50.26', '3.000' => '62.80', '4.000' => '75.34', '5' => '87.88', '6' => '100.42', '7' => '112.96', '8' => '125.50', '9' => '138.04', '10' => '162.74', '15' => '187.44' );
		
		$install ['rates'] = serialize ( $rate );
		
		$this->CI->Settings_model->save_settings ( 'colissimo_international_zone_d', $install );
	}
	
	function uninstall() {
		$this->CI->Settings_model->delete_settings ( 'colissimo_international_zone_d' );
	}
	
	function form() {
		$this->CI->load->helper ( 'form' );
		//this same function processes the form
		if (! $_POST) {
			$settings = $this->CI->Settings_model->get_settings ( 'colissimo_international_zone_d' );
			$settings ['rates'] = unserialize ( $settings ['rates'] );
		} else {
			
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
		
		return $this->CI->load->view ( 'colissimo_international_zone_d_form', $data, true );
	
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
		
		if ($this->CI->config->item ( 'language' ) == 'french') {
			$save ['entity_common_name_fr'] = $_POST ['entity_common_name_fr'];
			$save ['entity_definition_fr'] = $_POST ['entity_definition_fr'];
		} else {
			$save ['entity_common_name_en'] = $_POST ['entity_common_name_en'];
			$save ['entity_definition_en'] = $_POST ['entity_definition_en'];
		}
		
		//we save the settings if it gets here
		$this->CI->Settings_model->save_settings ( 'colissimo_international_zone_d', $save );
		
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
}
