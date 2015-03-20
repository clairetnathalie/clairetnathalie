<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Bnp_parisbas {
	var $CI;
	
	//this can be used in several places
	var $method_name;
	
	private $connection;
	private $mysqli;
	private $dateTime;
	
	function __construct() {
		$this->CI = & get_instance ();
		$this->CI->load->library ( array ('session', 'bnp', 'Go_cart' ) );
		$this->CI->lang->load ( 'bnp_parisbas' );
		$this->CI->load->model ( array ('Order_model_mgm' ) );
		
		$this->method_name = lang ( 'bnp_parisbas' );
	}
	
	/*
	checkout_form()
	this function returns an array, the first part being the name of the payment type
	that will show up beside the radio button the next value will be the actual form if there is no form, then it should equal false
	there is also the posibility that this payment method is not approved for this purchase. in that case, it should return a blank array 
	*/
	
	//these are the front end form and check functions
	function checkout_form($post = false) {
		$settings = $this->CI->Settings_model->get_settings ( 'bnp_parisbas' );
		$enabled = $settings ['enabled'];
		
		$form = array ();
		if ($enabled) {
			$form ['name'] = $this->method_name;
			
			$form ['form'] = $this->CI->load->view ( 'bnp_checkout', array (), true );
			
			return $form;
		
		} else
			return array ();
	
	}
	
	function checkout_check() {
		// Nothing to check in this module
		return false;
	}
	
	function description() {
		return lang ( 'bnp_parisbas' );
	}
	
	//back end installation functions
	function install() {
		$config ['username'] = '';
		$config ['password'] = '';
		;
		$config ['signature'] = '';
		$config ['currency'] = 'EUR'; // default
		

		$config ['SANDBOX'] = true;
		
		$config ['enabled'] = "0";
		
		//not normally user configurable
		$config ['return_url'] = "";
		$config ['cancel_url'] = "";
		
		$this->CI->Settings_model->save_settings ( 'bnp_parisbas', $config );
	}
	
	function uninstall() {
		$this->CI->Settings_model->delete_settings ( 'bnp_parisbas' );
	}
	
	//payment processor
	public function process_payment() {
		$process = false;
		
		$store = $this->CI->config->item ( 'company_name' );
		
		$quid_2 = $this->CI->go_cart->get_quid_2 ();
		
		$customer = $this->CI->go_cart->customer ();
		$customer_email = $customer ['email'];
		$customer_id = (empty ( $customer ['id'] )) ? 'INCONNU' : $customer ['id'];
		//return print_r_html($customer);
		

		$ip_address = $this->CI->session->userdata ( 'ip_address' );
		
		$product_data = array ();
		$pre_product_data = $this->CI->go_cart->contents ();
		foreach ( $pre_product_data as $product ) {
			foreach ( $product as $key => $value ) {
				if ($key == 'description') {
					unset ( $product ['description'] );
				}
				if ($key == 'excerpt') {
					unset ( $product ['excerpt'] );
				}
				if ($key == 'related_products') {
					unset ( $product ['related_products'] );
				}
				if ($key == 'seo_title') {
					unset ( $product ['seo_title'] );
				}
				if ($key == 'meta') {
					unset ( $product ['meta'] );
				}
				if ($key == 'name') {
					$product ['name'] = urlencode ( $value );
				}
				if ($key == 'images') {
					$image_array = array ();
					$image_array = objectToArray ( json_decode ( $value ) );
					
					foreach ( $image_array as $key2 => $value2 ) {
						foreach ( $value2 as $key3 => $value3 ) {
							if ($key3 == 'alt') {
								$image_array [$key2] [$key3] = urlencode ( $value3 );
							}
							if ($key3 == 'caption') {
								$image_array [$key2] [$key3] = urlencode ( $value3 );
							}
						}
					}
					
					$product ['images'] = json_encode ( $image_array );
				}
				if ($key == 'options') {
					foreach ( $product ['options'] as $key2 => $value2 ) {
						$product ['options'] [$key2] = urlencode ( $value2 );
					}
				}
				if ($key == 'gc_info') {
					foreach ( $product ['gc_info'] as $key2 => $value2 ) {
						if ($key2 == 'to_name') {
							$product ['gc_info'] [$key2] = urlencode ( $value2 );
						}
						if ($key2 == 'to_email') {
							$product ['gc_info'] [$key2] = urlencode ( $value2 );
						}
						if ($key2 == 'from') {
							$product ['gc_info'] [$key2] = urlencode ( $value2 );
						}
						if ($key2 == 'personal_message') {
							$product ['gc_info'] [$key2] = urlencode ( $value2 );
						}
					}
				}
			}
			
			$product_data [] = $product;
		}
		
		//return $product_data;
		

		///*
		// this will forward the page to the bnp interface, leaving gocart behind
		// the user will be sent back and authenticated by the bnp_parisbas gateway controller bnp_gate.php
		$response = $this->CI->bnp->doBnpCheckout ( $this->CI->go_cart->total (), $quid_2, $customer_email, $customer_id, $ip_address, $product_data );
		
		// If we get to this step at all, something went wrong	
		if ($response == 'failure') {
			return lang ( 'bnp_parisbas_error' );
		} else {
			return false;
		}
	
		//*/
	}
	
	public function complete_payment($data) {
		$order_id = $data ['order_id'];
		
		$quid_2 = $this->CI->go_cart->get_quid_2 ();
		
		$response = $this->CI->Order_model_mgm->confirm_order_payment_bnp_parisbas ( $order_id, $quid_2 );
		
		if ($response) {
			return $response;
		}
	}
	
	//admin end form and check functions
	function form($post = false) {
		//this same function processes the form
		if (! $post) {
			$settings = $this->CI->Settings_model->get_settings ( 'bnp_parisbas' );
		} else {
			$settings = $post;
		}
		//retrieve form contents
		return $this->CI->load->view ( 'bnp_parisbas_form', array ('settings' => $settings ), true );
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
			$this->CI->Settings_model->save_settings ( 'bnp_parisbas', $_POST );
			
			return false;
		}
	}
}

