<?php
class Autoresponder_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	function get_all_session_data() {
		$session_data = $this->db->order_by ( 'last_activity DESC' )->get ( 'sessions' );
		return $session_data->result_array ();
	}
	
	function get_all_order_emails() {
		$order_data = $this->db->select ( 'email' )->where ( 'status !=', 'Pending' )->where ( 'status !=', 'Cancelled' )->get ( 'orders' );
		return $order_data->result_array ();
	}
	
	function get_already_one_day_data() {
		$already_one_day_data = $this->db->select ( 'one_day_list' )->where ( 'id', 1 )->get ( 'autoresponder_one_day_list' )->row ();
		return $already_one_day_data;
	}
	
	function get_already_one_week_data() {
		$already_one_week_data = $this->db->select ( 'one_week_list' )->where ( 'id', 1 )->get ( 'autoresponder_one_week_list' )->row ();
		return $already_one_week_data;
	}
	
	function get_already_one_month_data() {
		$already_one_month_data = $this->db->select ( 'one_month_list' )->where ( 'id', 1 )->get ( 'autoresponder_one_month_list' )->row ();
		return $already_one_month_data;
	}
	
	function update_already_one_day_data($serialized_data) {
		$this->db->where ( 'id', 1 );
		$this->db->set ( 'one_day_list', $serialized_data );
		$this->db->update ( 'autoresponder_one_day_list' );
	}
	
	function update_already_one_week_data($serialized_data) {
		$this->db->where ( 'id', 1 );
		$this->db->set ( 'one_week_list', $serialized_data );
		$this->db->update ( 'autoresponder_one_week_list' );
	}
	
	function update_already_one_month_data($serialized_data) {
		$this->db->where ( 'id', 1 );
		$this->db->set ( 'one_month_list', $serialized_data );
		$this->db->update ( 'autoresponder_one_month_list' );
	}

}