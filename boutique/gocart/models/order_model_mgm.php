<?php
class order_model_mgm extends CI_Model {
	function __construct() {
		parent::__construct ();
		
		$this->db = $this->load->database ( 'french', TRUE );
	}
	
	function confirm_order_payment_paypal_express($order_id, $paypal_transaction_id, $quid_2) {
		$confirmation_payment = $this->get_confirm_payment ( 'paypal_response', 'TRANSACTIONID', $paypal_transaction_id );
		
		if ($confirmation_payment) {
			date_default_timezone_set ( 'Europe/Paris' );
			$dateTime = date ( 'Y-m-d H:i:s' );
			$dateTime2 = date ( 'Ymd His' );
			
			$this->db->query ( "UPDATE gc_fr_orders SET status='Processing' WHERE order_number='$order_id'" );
		}
	}
	
	function confirm_order_payment_bnp_parisbas($order_id, $quid_2) {
		$confirmation_payment = $this->get_confirm_payment ( 'mercanet_response_auto', 'order_id', $quid_2 );
		
		if ($confirmation_payment) {
			date_default_timezone_set ( 'Europe/Paris' );
			$dateTime = date ( 'Y-m-d H:i:s' );
			$dateTime2 = date ( 'Ymd His' );
			
			$this->db->query ( "UPDATE gc_fr_orders SET status='Processing' WHERE order_number='$order_id'" );
		}
	}
	
	function get_confirm_payment($table, $transaction_key, $transaction_ref) {
		$this->db->set_dbprefix ( '' );
		$result = $this->db->get_where ( $table, array ($transaction_key => $transaction_ref ) )->row ();
		$this->db->set_dbprefix ( 'gc_fr_' );
		
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
}