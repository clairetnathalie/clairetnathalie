<?php

class bnp_gate extends Front_Controller {
	
	var $CI;
	var $_cart_contents = array ();
	
	function __construct() {
		parent::__construct ();
		
		$this->CI = & get_instance ();
		
		//check to see if they are on a secure URL
		//force_ssl();
		

		$this->load->add_package_path ( APPPATH . 'packages/payment/bnp_parisbas/' );
		$this->load->library ( array ('bnp' ) );
		$this->load->model ( array ('Order_model_mgm' ) );
		$this->load->helper ( 'form_helper' );
	}
	
	function index() {
		//we don't have a default landing page
		redirect ( '' );
	}
	
	/* 
	   Receive postback confirmation from bnp
	   to complete the customer's order.
	*/
	function bnp_return() {
		// Verify the quid_2 with bnp_parisbas
		$quid_2 = $this->go_cart->retrieve_quid_2 ();
		
		if ($quid_2) {
			$confirmation_payment = $this->Order_model_mgm->get_confirm_payment ( 'mercanet_response_auto', 'order_id', $quid_2 );
			
			if ($confirmation_payment) {
				// set a confirmed flag in the gocart payment property
				$this->go_cart->set_payment_confirmed ();
				
				// record paypal transaction_id
				$this->go_cart->set_bnp_transaction_id ( $quid_2 );
				
				// send them back to the cart payment page to finish the order
				// the confirm flag will bypass payment processing and save up
				redirect ( 'checkout/place_order/' );
			} else {
				// Possible fake request; was not verified by bnp_parisbas. Could be due to a double page-get, should never happen under normal circumstances
				$this->session->set_flashdata ( 'message', "<div>BNP Parisbas n'a pas validé votre commande. Soit il a été déjà traité, ou quelque chose d'autre s'est mal passé. Si vous pensez qu'il y a eu une erreur importante, veuillez nous contacter.</div>" );
				redirect ( 'checkout' );
			}
		} else {
			redirect ( '' );
		}
	}
	
	/* 
		Customer cancelled bnp payment
	*/
	function bnp_cancel() {
		//make sure they're logged in if the config file requires it
		if ($this->config->item ( 'require_login' )) {
			$this->Customer_model->is_logged_in ();
		}
		
		// User canceled using bnp, send them back to the payment page
		$cart = $this->session->userdata ( 'cart' );
		$this->session->set_flashdata ( 'message', "<div>Transaction BNP Parisbas annulée, sélectionnez un autre mode de paiement</div>" );
		redirect ( 'checkout' );
	}
	
	function bnp_annuler() {
	
	}
}