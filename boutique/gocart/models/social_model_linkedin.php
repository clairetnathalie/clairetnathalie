<?php

class Social_model_linkedin extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		
		$this->db = $this->load->database ( 'french', TRUE );
	}
	
	public function _addUserToLinkedInStatus($id, $email, $_user_name, $_user_id, $_photoURL) {
		$this->db->where ( 'li_user_id', $_user_id );
		$query_check = $this->db->get ( 'linkedin_status' );
		if ($query_check->num_rows () > 0) {
		
		} else {
			$this->db->insert ( 'linkedin_status', array ('id' => $id, 'email' => $email, 'li_user_name' => $_user_name, 'li_user_id' => $_user_id, 'li_photoURL' => $_photoURL, 'fan_page' => '0', 'app_page' => '0' ) );
		}
	}
}