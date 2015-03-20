<?php

class Social_model_google extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		
		$this->db = $this->load->database ( 'french', TRUE );
	}
	
	public function _addUserToGooglePlusStatus($id, $email, $_user_name, $_user_id, $_photoURL) {
		$this->db->where ( 'g_user_id', $_user_id );
		$query_check = $this->db->get ( 'google_plus_status' );
		if ($query_check->num_rows () > 0) {
		
		} else {
			$this->db->insert ( 'google_plus_status', array ('id' => $id, 'email' => $email, 'g_user_name' => $_user_name, 'g_user_id' => $_user_id, 'g_photoURL' => $_photoURL, 'fan_page' => '0', 'app_page' => '0' ) );
		}
	}
}