<?php

class Tax_model extends CI_Model {
	var $state = '';
	var $state_taxes;
	
	function __construct() {
		parent::__construct ();
		
		$this->db = $this->load->database ( 'french', TRUE );
		
		$this->state_taxes = $this->config->item ( 'state_taxes' );
		
		$customer = $this->go_cart->customer ();
		
		$tax_type = $this->config->item ( 'tax_address' );
		
		if ($tax_type == 'ship') {
			$this->address = @$customer ['ship_address'];
		} else {
			// this will probably be the same anyway
			$this->address = @$customer ['bill_address'];
		}
	}
	function get_country_tax_rate() {
		$rate = $this->db->where ( 'id', $this->address ['country_id'] )->get ( 'countries' )->row ();
		
		if ($rate) {
			$rate = $rate->tax / 100;
		} else {
			$rate = 0;
		}
		
		return $rate;
	}
	
	function get_zone_tax_rate() {
		$rate = $this->db->where ( 'id', $this->address ['zone_id'] )->get ( 'country_zones' )->row ();
		if ($rate) {
			$rate = $rate->tax / 100;
		} else {
			$rate = 0;
		}
		
		return $rate;
	}
	
	function get_area_tax_rate() {
		$rate = $this->db->where ( array ('code' => $this->address ['zip'], 'zone_id' => $this->address ['zone_id'] ) )->get ( 'country_zone_areas' )->row ();
		if ($rate) {
			$rate = $rate->tax / 100;
		} else {
			$rate = 0;
		}
		
		return $rate;
	}
	
	function get_tax_total() {
		$tax_total = 0;
		$tax_total = $tax_total + $this->get_taxes ();
		
		//return number_format($tax_total, 2, '.', '');
		return $tax_total;
	}
	
	function get_tax_vat_total() {
		$tax_total = 0;
		$tax_total = $tax_total + $this->get_vat_taxes ();
		
		//return number_format($tax_total, 2, '.', '');
		return $tax_total;
	}
	
	function get_additional_tax_total() {
		$tax_total = 0;
		$tax_total = $tax_total + $this->get_additional_taxes ();
		
		//return number_format($tax_total, 2, '.', '');
		return $tax_total;
	}
	
	function get_tax_rate($tax_vat = false) {
		if ($tax_vat == false) {
			//if there is no address yet return 0
			if (empty ( $this->address )) {
				return 0;
			}
			
			$rate = 0;
			
			$rate += $this->get_country_tax_rate ();
			$rate += $this->get_zone_tax_rate ();
			$rate += $this->get_area_tax_rate ();
			
			//returns the total rate not affected by price of merchandise.
			return $rate;
		} else {
			return $this->config->item ( 'vat_tax_rate' );
		}
	}
	
	function get_taxes() {
		$rate = ( float ) $this->get_tax_rate ( false );
		$order_price = ( float ) $this->go_cart->taxable_total ();
		
		//send the price of the taxes back
		return round ( $order_price * $rate, 4 );
	}
	
	function get_vat_taxes() {
		$rate = ( float ) $this->get_tax_rate ( true );
		$order_price = ( float ) $this->go_cart->taxable_total_vat ();
		
		//send the price of the taxes back
		return round ( $order_price * $rate, 4 );
	}
	
	function get_additional_taxes() {
		$rate = ( float ) $this->get_tax_rate ( false );
		$order_price = ( float ) $this->go_cart->taxable_total_add ();
		
		//send the price of the taxes back
		return round ( $order_price * $rate, 4 );
	}
}