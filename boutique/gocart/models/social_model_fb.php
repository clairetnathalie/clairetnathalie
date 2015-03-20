<?php

class Social_model_fb extends CI_Model {
	
	function __construct() {
		parent::__construct ();
		
		$this->db = $this->load->database ( 'french', TRUE );
	}
	
	/*
	public function _checkUser($user)
	{
		$q_user = $this->db->query("SELECT * FROM inscriptions WHERE EMAIL_ADHERENT LIKE '" . $this->db->escape_like_str($user) . "'");
		
		if ($q_user->num_rows() > 0)
		{
			foreach ($q_user->result() as $row)
		  	{
		    	$user_status = 'true';
		   	}
		}
		else 
		{
			$user_status = 'false';
		}
		
		$q_user->free_result();
		
		return array(
		    'user_status' => $user_status
		);
	}
	*/
	
	/*
	public function _getUserPassword($user)
	{
		$query_sql = "SELECT * FROM inscriptions WHERE EMAIL_ADHERENT LIKE '" . $this->db->escape_like_str($user) . "'";
		$query = $this->db->query($query_sql);
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
   			$password = $row['CODE_UTILSAT_ADHERENT'];
   			return $password;
		}
		else
		{
			return null;
		}
		
		$query->free_result();
	}
	*/
	
	/*
	public function _recordUser($titre,$nom,$prenom,$email,$adresse,$ville,$pays,$code_postale,$phone,$password,$lang,$xml_b)
	{
		date_default_timezone_set('Europe/Paris');
		$dateTime = date('Y-m-d H:i:s');  
		$dateTime_string = strval($dateTime);
		
		$insert_data = array('NOM_ADHERENT' => $nom, 'PRENOM_ADHERENT' => $prenom, 'EMAIL_ADHERENT' => $email, 'CODE_UTILSAT_ADHERENT' => $password, 'TITRE_ADHERENT' => $titre,'ADRESSE_ADHERENT' => $adresse, 'VILLE_ADHERENT' => $ville, 'CODE_POSTAL_ADHERENT' => $code_postale, 'PAYS_ADHERENT' => $pays, 'TELEPHONE_ADHERENT' => $phone, 'ID_COMPTE_ADHERENT' => '', 'VALIDAT_COMPTE_ADHERENT' => '0', 'DATE_CREATION_COMPTE_ADHERENT' => $dateTime_string, 'EXTRA_1' => $xml_b, 'EXTRA_2' => $lang, 'EXTRA_3' => '', 'EXTRA_4' => '');
		$insert_str = $this->db->insert_string('inscriptions', $insert_data); 
		$this->db->query($insert_str);
		
		$encrypted_password = sha1($password);
		
		$insert_data = array('firstname' => $prenom, 'lastname' => $nom, 'email' => $email, 'email_subscribe' => 1, 'phone' => $phone, 'company' => '', 'default_billing_address' => null, 'default_shipping_address' => null, 'ship_to_bill_address' => 'true',  'password' => $encrypted_password, 'active' => 1, 'group_id' => 'Shoppers', 'confirmed' => 0);
		$insert_str = $this->db->insert_string('gc_fr_customers', $insert_data); 
		$this->db->query($insert_str);
		$auto_id = $this->db->insert_id();
		
		$insert_data = array('firstname' => $prenom, 'lastname' => $nom, 'email' => $email, 'email_subscribe' => 1, 'phone' => $phone, 'company' => '', 'default_billing_address' => null, 'default_shipping_address' => null, 'ship_to_bill_address' => 'true',  'password' => $encrypted_password, 'active' => 1, 'group_id' => 'Shoppers', 'confirmed' => 0);
		$insert_str = $this->db->insert_string('gc_en_customers', $insert_data); 
		$this->db->query($insert_str);
		
		$this_country_code = null;
		$sql_pays_fr_check = "SELECT code_pays FROM livraison_pays WHERE UPPER(fr) LIKE '%" . strtoupper(ltrim($pays)) . "%' LIMIT 1";
		$query = $this->db->query($sql_pays_fr_check);
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
   			$this_country_code = $row['code_pays'];
		}
		else 
		{
			$sql_pays_en_check = "SELECT code_pays FROM livraison_pays WHERE UPPER(en) LIKE '%" . strtoupper(ltrim($pays)) . "%' LIMIT 1";
			$query = $this->db->query($sql_pays_en_check);
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
   				$this_country_code = $row['code_pays'];
			}
		}
		
		$this_country_id = null;
		if ($this_country_code != null)
		{
			$sql_country_id = "SELECT id FROM gc_fr_countries WHERE iso_code_2 LIKE '%" . $this_country_code . "%' LIMIT 1";
			$query = $this->db->query($sql_country_id);
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
	   			$this_country_id = $row['id'];
			}
		}
		
		$a = array();
		$a['field_data']['company']		= '';
		$a['field_data']['firstname']	= $prenom;
		$a['field_data']['lastname']	= $nom;
		$a['field_data']['email']		= $email;
		$a['field_data']['phone']		= $phone;
		$a['field_data']['address1']	= $adresse;
		$a['field_data']['address2']	= '';
		$a['field_data']['city']		= $ville;
		$a['field_data']['zip']			= $code_postale;
	
		$a['field_data']['zone']			= '';
		$a['field_data']['country']			= ltrim($pays);
		$a['field_data']['country_code']   	= ($this_country_code != null) ? $this_country_code : '';
		$a['field_data']['country_id']  	= ($this_country_id != null) ? $this_country_id : '';
		$a['field_data']['zone_id']			= '';
		
		$field_data = serialize($a['field_data']);
		
		$insert_data = array('customer_id' => $auto_id, 'entry_name' => 'default billing address', 'field_data' => "$field_data");
		$insert_str = $this->db->insert_string('gc_fr_customers_address_bank', $insert_data); 
		$this->db->query($insert_str);
		$auto_id_billing_address = $this->db->insert_id();
		
		$insert_data = array('customer_id' => $auto_id, 'entry_name' => 'default_shipping_address', 'field_data' => "$field_data");
		$insert_str = $this->db->insert_string('gc_fr_customers_address_bank', $insert_data); 
		$this->db->query($insert_str);
		$auto_id_shipping_address = $this->db->insert_id();
		
		$data = array('default_billing_address' => $auto_id_billing_address, 'default_shipping_address' => $auto_id_shipping_address);
		$where = "email = '$email'";
		$update_str = $this->db->update_string('gc_fr_customers', $data, $where); 
		$this->db->query($update_str);
			
		
		$insert_data = array('customer_id' => $auto_id, 'entry_name' => 'default billing address', 'field_data' => "$field_data");
		$insert_str = $this->db->insert_string('gc_en_customers_address_bank', $insert_data); 
		$this->db->query($insert_str);
		$auto_id_billing_address = $this->db->insert_id();
		
		$insert_data = array('customer_id' => $auto_id, 'entry_name' => 'default_shipping_address', 'field_data' => "$field_data");
		$insert_str = $this->db->insert_string('gc_en_customers_address_bank', $insert_data); 
		$this->db->query($insert_str);
		$auto_id_shipping_address = $this->db->insert_id();
		
		$data = array('default_billing_address' => $auto_id_billing_address, 'default_shipping_address' => $auto_id_shipping_address);
		$where = "email = '$email'";
		$update_str = $this->db->update_string('gc_en_customers', $data, $where); 
		$this->db->query($update_str);
	}
	*/
	
	/*
	public function _record_fb_User($titre,$nom,$prenom,$email,$adresse,$ville,$pays,$code_postale,$phone,$password,$lang,$xml_a,$xml_b)
	{
		date_default_timezone_set('Europe/Paris');
		$dateTime = date('Y-m-d H:i:s');  
		$dateTime_string = strval($dateTime);
		
		$insert_data = array('NOM_ADHERENT' => $nom, 'PRENOM_ADHERENT' => $prenom, 'EMAIL_ADHERENT' => $email, 'CODE_UTILSAT_ADHERENT' => $password, 'TITRE_ADHERENT' => $titre,'ADRESSE_ADHERENT' => $adresse, 'VILLE_ADHERENT' => $ville, 'CODE_POSTAL_ADHERENT' => $code_postale, 'PAYS_ADHERENT' => $pays, 'TELEPHONE_ADHERENT' => $phone, 'ID_COMPTE_ADHERENT' => '', 'VALIDAT_COMPTE_ADHERENT' => '0', 'DATE_CREATION_COMPTE_ADHERENT' => $dateTime_string, 'EXTRA_1' => $xml_b, 'EXTRA_2' => $lang, 'EXTRA_3' => $xml_a, 'EXTRA_4' => '');
		$insert_str = $this->db->insert_string('inscriptions', $insert_data);
		$this->db->query($insert_str);
		
		$encrypted_password = sha1($password);
		
		$insert_data = array('firstname' => $prenom, 'lastname' => $nom, 'email' => $email, 'email_subscribe' => 1, 'phone' => $phone, 'company' => '', 'default_billing_address' => null, 'default_shipping_address' => null, 'ship_to_bill_address' => 'true',  'password' => $encrypted_password, 'active' => 1, 'group_id' => 'Shoppers', 'confirmed' => 0);
		$insert_str = $this->db->insert_string('gc_fr_customers', $insert_data); 
		$this->db->query($insert_str);
		$auto_id = $this->db->insert_id();
		
		$insert_data = array('firstname' => $prenom, 'lastname' => $nom, 'email' => $email, 'email_subscribe' => 1, 'phone' => $phone, 'company' => '', 'default_billing_address' => null, 'default_shipping_address' => null, 'ship_to_bill_address' => 'true',  'password' => $encrypted_password, 'active' => 1, 'group_id' => 'Shoppers', 'confirmed' => 0);
		$insert_str = $this->db->insert_string('gc_en_customers', $insert_data); 
		$this->db->query($insert_str);
		
		$sql_pays_fr_check = "SELECT code_pays FROM livraison_pays WHERE UPPER(fr) LIKE '%" . strtoupper(ltrim($pays))  . "%' LIMIT 1";
		$query = $this->db->query($sql_pays_fr_check);
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
   			$this_country_code = $row['code_pays'];
		}
		else 
		{
			$sql_pays_en_check = "SELECT code_pays FROM livraison_pays WHERE UPPER(en) LIKE '%" . strtoupper(ltrim($pays))  . "%' LIMIT 1";
			$query = $this->db->query($sql_pays_en_check);
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
   				$this_country_code = $row['code_pays'];
			}
			else 
			{
				$this_country_code = null;
			}
		}
		
		if ($this_country_code != null)
		{
			$sql_country_id = "SELECT id FROM gc_fr_countries WHERE iso_code_2 LIKE '%" . $this_country_code . "%' LIMIT 1";
			$query = $this->db->query($sql_country_id);
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
	   			$this_country_id = $row['id'];
			}
			else
			{
				$this_country_id = null;
			}
		}
		else 
		{
			$this_country_id = null;
		}
		
		$a = array();
		$a['id']						= 1;
		$a['customer_id']				= $auto_id;
		$a['field_data']['company']		= '';
		$a['field_data']['firstname']	= $prenom;
		$a['field_data']['lastname']	= $nom;
		$a['field_data']['email']		= $email;
		$a['field_data']['phone']		= $phone;
		$a['field_data']['address1']	= $adresse;
		$a['field_data']['address2']	= '';
		$a['field_data']['city']		= $ville;
		$a['field_data']['zip']			= $code_postale;
	
		$a['field_data']['zone']			= '';
		$a['field_data']['country']			= ltrim($pays);
		$a['field_data']['country_code']   	= ($this_country_code != null) ? $this_country_code : '';
		$a['field_data']['country_id']  	= ($this_country_id != null) ? $this_country_id : '';
		$a['field_data']['zone_id']			= '';
		
		$field_data = serialize($a['field_data']);
		
		$insert_data = array('customer_id' => $auto_id, 'entry_name' => 'default billing address', 'field_data' => "$field_data");
		$insert_str = $this->db->insert_string('gc_fr_customers_address_bank', $insert_data); 
		$this->db->query($insert_str);
		$auto_id_billing_address = $this->db->insert_id();
		
		$insert_data = array('customer_id' => $auto_id, 'entry_name' => 'default_shipping_address', 'field_data' => "$field_data");
		$insert_str = $this->db->insert_string('gc_fr_customers_address_bank', $insert_data); 
		$this->db->query($insert_str);
		$auto_id_shipping_address = $this->db->insert_id();
		
		$data = array('default_billing_address' => $auto_id_billing_address, 'default_shipping_address' => $auto_id_shipping_address);
		$where = "email = '$email'";
		$update_str = $this->db->update_string('gc_fr_customers', $data, $where); 
		$this->db->query($update_str);
			
		
		$insert_data = array('customer_id' => $auto_id, 'entry_name' => 'default billing address', 'field_data' => "$field_data");
		$insert_str = $this->db->insert_string('gc_en_customers_address_bank', $insert_data); 
		$this->db->query($insert_str);
		$auto_id_billing_address = $this->db->insert_id();
		
		$insert_data = array('customer_id' => $auto_id, 'entry_name' => 'default_shipping_address', 'field_data' => "$field_data");
		$insert_str = $this->db->insert_string('gc_en_customers_address_bank', $insert_data); 
		$this->db->query($insert_str);
		$auto_id_shipping_address = $this->db->insert_id();
		
		$data = array('default_billing_address' => $auto_id_billing_address, 'default_shipping_address' => $auto_id_shipping_address);
		$where = "email = '$email'";
		$update_str = $this->db->update_string('gc_en_customers', $data, $where); 
		$this->db->query($update_str);
	}
	
	/*
	public function post_wall($url)
	{
	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, $url);
	   curl_setopt($ch, CURLOPT_POST, TRUE);
	   curl_setopt($ch, CURLOPT_HEADER, FALSE);  // Return contents only
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  // return results instead of outputting
	   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Give up after connecting for 10 seconds 
	   curl_setopt($ch, CURLOPT_TIMEOUT, 60);  // Only execute 60s at most
	   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  // Don't verify SSL cert
	   $response = curl_exec($ch);
	   curl_close($ch);
	}
	*/
	
	public function record_wall_post($url, $user_id, $name) {
		if ($user_id != null) {
			$this->db->where ( 'produit', $name );
			$this->db->where ( 'fb_user_id', $user_id );
			$query_check = $this->db->get ( 'fb_wall_posts' );
			if ($query_check->num_rows () > 0) {
			
			} else {
				$insert_data = array ('url' => $url, 'fb_user_id' => $user_id, 'produit' => $name, 'status' => '0' );
				$insert_str = $this->db->insert_string ( 'fb_wall_posts', $insert_data );
				$this->db->query ( $insert_str );
			}
		}
	}
	
	public function _checkPromoAuthApp($user_id) {
		$this->db->where ( 'fb_user_id', $user_id );
		$query_check = $this->db->get ( 'fb_auth_app_promo' );
		if ($query_check->num_rows () > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function _addUserToFbLikeStatus($id, $email, $_user_name, $_user_id, $_photoURL) {
		$this->db->where ( 'fb_user_id', $_user_id );
		$query_check = $this->db->get ( 'fb_like_status' );
		if ($query_check->num_rows () > 0) {
		
		} else {
			$this->db->insert ( 'fb_like_status', array ('id' => $id, 'email' => $email, 'fb_user_name' => $_user_name, 'fb_user_id' => $_user_id, 'fb_photoURL' => $_photoURL, 'fan_page' => '0', 'app_page' => '0' ) );
		}
	}
	
	public function _addUserToFbAuthAppPromo($user_id) {
		//$insert_data = array('id' => $id, 'fb_user_id' => $user_id);
		$insert_data = array ('fb_user_id' => $user_id );
		$insert_str = $this->db->insert_string ( 'fb_auth_app_promo', $insert_data );
		$this->db->query ( $insert_str );
	}
}