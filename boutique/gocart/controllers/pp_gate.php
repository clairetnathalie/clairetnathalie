<?php

class pp_gate extends Front_Controller {
	
	private $connection;
	private $mysqli;
	private $dateTime;
	
	function __construct() {
		parent::__construct ();
		
		//check to see if they are on a secure URL
		//force_ssl();
		

		$this->load->add_package_path ( APPPATH . 'packages/payment/paypal_express/' );
		$this->load->library ( array ('paypal', 'httprequest_pp', 'go_cart' ) );
		$this->load->model ( array ('Order_model_mgm' ) );
		$this->load->helper ( 'form_helper' );
		
		$this->connection = $this->config->item ( 'mysqli_connect' );
		
		date_default_timezone_set ( 'Europe/Paris' );
		$this->dateTime = date ( 'Y-m-d H:i:s' );
	}
	
	function index() {
		//we don't have a default landing page
		redirect ( '' );
	}
	
	/* 
	   Receive postback confirmation from paypal
	   to complete the customer's order.
	*/
	function pp_return() {
		// Verify the transaction with paypal
		$final = $this->paypal->doPayment ();
		
		//print_r($final);
		

		$connected = $this->connect_db ();
		
		if ($connected) {
			//print_r($final);
			

			$serialzed_final_result = serialize ( $final );
			
			$transaction_id = $this->mysqli->real_escape_string ( $final ['TRANSACTIONID'] );
			$acknowledgement = $this->mysqli->real_escape_string ( $final ['ACK'] );
			$transaction_type = $this->mysqli->real_escape_string ( $final ['TRANSACTIONTYPE'] );
			$payment_type = $this->mysqli->real_escape_string ( $final ['PAYMENTTYPE'] );
			$amt = $this->mysqli->real_escape_string ( floatval ( strval ( $final ['AMT'] ) ) );
			if (isset ( $final ['FEEAMT'] )) {
				$feeamt = $this->mysqli->real_escape_string ( floatval ( strval ( $final ['FEEAMT'] ) ) );
			} else {
				$feeamt = 0;
			}
			$taxamt = $this->mysqli->real_escape_string ( floatval ( strval ( $final ['TAXAMT'] ) ) );
			$currencycode = $this->mysqli->real_escape_string ( $final ['CURRENCYCODE'] );
			$payment_status = $this->mysqli->real_escape_string ( $final ['PAYMENTSTATUS'] );
			$pending_reason = $this->mysqli->real_escape_string ( $final ['PENDINGREASON'] );
			$reason_code = $this->mysqli->real_escape_string ( $final ['REASONCODE'] );
			$serialzed_final_result = $this->mysqli->real_escape_string ( $serialzed_final_result );
			
			$sql_check_response_data = "SELECT * FROM paypal_response WHERE TRANSACTIONID='$transaction_id'";
			if ($result_check_response_data = mysqli_query ( $this->mysqli, $sql_check_response_data )) {
				$sql_insert_response_data = "INSERT INTO paypal_response (
					TRANSACTIONID,
					ORDERID, 
					ACK, 
					TRANSACTIONTYPE, 
					PAYMENTTYPE, 
					AMT, 
					FEEAMT, 
					TAXAMT, 
					CURRENCYCODE, 
					PAYMENTSTATUS, 
					PENDINGREASON, 
					REASONCODE, 
					date, 
					response_serial
				) VALUES (
					'$transaction_id',
					'', 
					'$acknowledgement', 
					'$transaction_type', 
					'$payment_type', 
					$amt, 
					$feeamt, 
					$taxamt, 
					'$currencycode', 
					'$payment_status', 
					'$pending_reason', 
					'$reason_code', 
					'$this->dateTime', 
					'$serialzed_final_result'
				)";
				
				mysqli_query ( $this->mysqli, $sql_insert_response_data );
			} else {
				$sql_update_response_data = "UPDATE paypal_response SET 
					ACK='$acknowledgement', 
					TRANSACTIONTYPE='$transaction_type', 
					PAYMENTTYPE='$payment_type', 
					AMT=$amt, 
					FEEAMT=$feeamt, 
					TAXAMT=$taxamt, 
					CURRENCYCODE='$currencycode', 
					PAYMENTSTATUS='$payment_status', 
					PENDINGREASON='$pending_reason', 
					REASONCODE='$reason_code', 
					date='$this->dateTime', 
					response_serial='$serialzed_final_result' WHERE TRANSACTIONID='$transaction_id'";
				
				mysqli_query ( $this->mysqli, $sql_update_response_data );
			}
		
		//printf("Erreur : %s\n", mysqli_error($this->mysqli));
		}
		
		// Process the results
		if ($final ['ACK'] == 'Success') {
			// The transaction is good. Finish order
			

			// set a confirmed flag in the gocart payment property
			$this->go_cart->set_payment_confirmed ();
			
			// record paypal transaction_id
			$this->go_cart->set_paypal_transaction_id ( $final ['TRANSACTIONID'] );
			
			// send them back to the cart payment page to finish the order
			// the confirm flag will bypass payment processing and save up
			redirect ( 'checkout/place_order/' );
		
		} else {
			// Possible fake request; was not verified by paypal. Could be due to a double page-get, should never happen under normal circumstances
			$this->session->set_flashdata ( 'message', "<div>Paypal n'a pas validé votre commande. Soit il a été déjà traité, ou quelque chose d'autre s'est mal passé. Si vous pensez qu'il y a eu une erreur importante, veuillez nous contacter.</div>" );
			redirect ( 'checkout' );
		}
	}
	
	/* 
		Customer cancelled paypal payment
	*/
	function pp_cancel() {
		//make sure they're logged in if the config file requires it
		if ($this->config->item ( 'require_login' )) {
			$this->Customer_model->is_logged_in ();
		}
		
		// User canceled using paypal, send them back to the payment page
		$cart = $this->session->userdata ( 'cart' );
		$this->session->set_flashdata ( 'message', "<div>Transaction Paypal annulée, sélectionnez un autre mode de paiement</div>" );
		redirect ( 'checkout' );
	}
	
	function connect_db() {
		$this->mysqli = new mysqli ( $this->connection ['host_db'], $this->connection ['user_db'], $this->connection ['password_db'], $this->connection ['bdd_db'] );
		mysqli_set_charset ( $this->mysqli, "utf8" );
		//// check connection ////
		if (mysqli_connect_errno ()) {
			//printf("Connect failed: %s\n", mysqli_connect_error());
			//exit();
			return false;
		} else {
			return true;
		}
	}
}