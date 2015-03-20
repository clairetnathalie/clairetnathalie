<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Google_wallet {
	var $CI;
	
	//this can be used in several places
	var $method_name;
	
	var $redirect_url;
	
	function __construct() {
		$this->CI = & get_instance ();
		$this->CI->load->library ( 'session' );
		$this->CI->load->library ( 'googlewallet' );
		$this->CI->load->library ( 'httprequest_gw' );
		$this->CI->lang->load ( 'google_wallet' );
		
		$this->method_name = lang ( 'google_wallet' );
	}
	
	/*
	checkout_form()
	this function returns an array, the first part being the name of the payment type
	that will show up beside the radio button the next value will be the actual form if there is no form, then it should equal false
	there is also the posibility that this payment method is not approved for this purchase. in that case, it should return a blank array 
	*/
	
	//these are the front end form and check functions
	function checkout_form($post = false) {
		$settings = $this->CI->Settings_model->get_settings ( 'google_wallet' );
		$enabled = $settings ['enabled'];
		$merchant_id = $settings ['merchant_id'];
		
		$form = array ();
		if ($enabled) {
			$form ['name'] = $this->method_name;
			
			$form ['form'] = $this->CI->load->view ( 'gw_checkout', array ('merchant_id' => $merchant_id ), true );
			
			return $form;
		
		} else
			return array ();
	
	}
	
	function checkout_check() {
		// Nothing to check in this module
		return false;
	}
	
	function description() {
		return lang ( 'google_wallet' );
	}
	
	//back end installation functions
	function install() {
		$config ['username'] = '';
		$config ['merchant_key'] = '';
		$config ['merchant_id'] = '';
		$config ['currency'] = 'USD'; // default
		

		$config ['SANDBOX'] = true;
		
		$config ['enabled'] = "0";
		
		//not normally user configurable
		$config ['return_url'] = "gw_gate/gw_return/";
		$config ['cancel_url'] = "gw_gate/gw_cancel/";
		
		$this->CI->Settings_model->save_settings ( 'google_wallet', $config );
	}
	
	function uninstall() {
		$this->CI->Settings_model->delete_settings ( 'google_wallet' );
	}
	
	//payment processor
	function process_payment() {
		$process = false;
		
		$store = $this->CI->config->item ( 'company_name' );
		// this will forward the page to the googlewallet interface, leaving gocart behind
		// the user will be sent back and authenticated by the googlewallet gateway controller gw_gate.php
		

		$this->redirect_url = $this->CI->googlewallet->doExpressCheckout ( $this->CI->go_cart->total (), $this->CI->go_cart->total_items (), $store . ' order ' . $this->CI->go_cart->get_quid_2 (), $this->CI->go_cart->get_quid_2 (), $this->CI->go_cart->contents (), $this->CI->go_cart->get_shipping_method (), $this->CI->go_cart->get_delivery_company (), $this->CI->go_cart->get_shipping_cost (), $this->CI->go_cart->order_weight () );
		
		if ($this->redirect_url == 'void') {
			// If we get to this step at all, something went wrong	
			return lang ( 'googlewallet_error' );
		} else {
			redirect ( $this->redirect_url );
		}
	
	}
	
	/* Don't need this step 
	function complete_payment()
	{
		
	}
	*/
	
	//admin end form and check functions
	function form($post = false) {
		//this same function processes the form
		if (! $post) {
			$settings = $this->CI->Settings_model->get_settings ( 'google_wallet' );
		} else {
			$settings = $post;
		}
		//retrieve form contents
		return $this->CI->load->view ( 'google_wallet_form', array ('settings' => $settings ), true );
	}
	
	function check() {
		$error = false;
		
		// The only value that matters is currency code.
		//if ( empty($_POST['']) )
		//$error = "<div>You must enter a valid currency code</div>";
		

		//count the errors
		if ($error) {
			return $error;
		} else {
			//we save the settings if it gets here
			$this->CI->Settings_model->save_settings ( 'google_wallet', $_POST );
			
			return false;
		}
	}
}

