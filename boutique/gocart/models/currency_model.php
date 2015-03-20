<?php
class currency_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		
		$this->db = $this->load->database ( 'french', TRUE );
	}
	
	function get_currency_mercanet_currency_code($currency) {
		$query_sql = "SELECT mercanet_currency_code FROM currency_data WHERE currency='$currency'";
		
		$query = $this->db->query ( $query_sql );
		
		if ($query->num_rows () > 0) {
			$row = $query->row_array ();
			$mercanet_currency_code = $row ['mercanet_currency_code'];
			
			if ($mercanet_currency_code != 0) {
				return $mercanet_currency_code;
			} else {
				return null;
			}
		} else {
			return null;
		}
		
		$query->free_result ();
	}
	
	function get_currency_rate($currency) {
		$query_sql = "SELECT rate FROM currency_exchange_ecb_euro WHERE currency='$currency'";
		
		$query = $this->db->query ( $query_sql );
		
		if ($query->num_rows () > 0) {
			$row = $query->row_array ();
			$rate = $row ['rate'];
			return $rate;
		} else {
			return null;
		}
		
		$query->free_result ();
	}
	
	function get_currency_symbol($currency) {
		$query_sql = "SELECT symbol FROM currency_data WHERE currency='$currency'";
		
		$query = $this->db->query ( $query_sql );
		
		if ($query->num_rows () > 0) {
			$row = $query->row_array ();
			$symbol = $row ['symbol'];
			return $symbol;
		} else {
			return null;
		}
		
		$query->free_result ();
	}
	
	function get_currency_decimal($currency) {
		$query_sql = "SELECT decimal_pt FROM currency_data WHERE currency='$currency'";
		
		$query = $this->db->query ( $query_sql );
		
		if ($query->num_rows () > 0) {
			$row = $query->row_array ();
			$symbol = $row ['decimal_pt'];
			return $symbol;
		} else {
			return null;
		}
		
		$query->free_result ();
	}

}