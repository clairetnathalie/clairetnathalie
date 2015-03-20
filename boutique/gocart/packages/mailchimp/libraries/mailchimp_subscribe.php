<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class mailchimp_subscribe {
	var $CI;
	
	function subscribe($senderFirstname, $senderSurname, $senderEmail) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		$preferred_lang = ($this->CI->config->item ( 'language' ) == 'french') ? 'FR' : 'EN';
		
		$merge_vars = array ('PREF_LANG' => "$preferred_lang", 'LNAME' => "$senderSurname", 'FNAME' => "$senderFirstname", 'EMAIL' => "$senderEmail" );
		
		$email_type = 'html';
		$double_optin = true;
		$update_existing = false;
		$replace_interests = true;
		$send_welcome = false;
		
		if ($this->CI->mail_chimp->listSubscribe ( $this->CI->config_mc ['mailchimp_list_id'], $senderEmail, $merge_vars, $email_type, $double_optin, $update_existing, $replace_interests, $send_welcome )) {
			$this->success [] = "Vous êtes désormais inscrit à notre newsletter";
		}
	}
	
	function subscribe_bis($id, $email, $merge_vars = NULL, $email_type = 'html', $double_optin = false, $update_existing = true, $replace_interests = true, $send_welcome = false) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		$this->CI->mail_chimp->listSubscribe ( $id, $email, $merge_vars, $email_type, $double_optin, $update_existing, $replace_interests, $send_welcome );
	}
	
	function getMergeVars($id) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->listMergeVars ( $id );
	}
	
	function getMembersUniqueID($id, $email_address) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->listMemberInfo ( $id, $email_address );
	}
	
	function getSubscribedMembersOfList($id) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->listMembers ( $id );
	}
	
	function getUnsubscribedMembersFromList($id, $status = 'unsubscribed') {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->listMembers ( $id, $status );
	}
	
	function unsubscribeMembersFromList($id, $emails, $delete_member = false, $send_goodbye = false, $send_notify = false) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->listBatchUnsubscribe ( $id, $emails, $delete_member, $send_goodbye, $send_notify );
	}
	
	function subscribeMembersToList($id, $batch, $double_optin = false, $update_existing = false, $replace_interests = false) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->listBatchSubscribe ( $id, $batch, $double_optin, $update_existing, $replace_interests );
	}
	
	function getCampaigns($filters = array(), $start = 0, $limit = 25) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->campaigns ( $filters, $start, $limit );
	}
	
	function campaignSendTest($cid, $test_emails = array()) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->campaignSendTest ( $cid, $test_emails );
	}
	
	function campaignSend($cid) {
		$this->CI = & get_instance ();
		
		$this->CI->config->load ( 'mailchimp', TRUE );
		$this->CI->config_mc = $this->CI->config->item ( 'mailchimp' );
		
		$config = array ('apikey' => $this->CI->config_mc ['mailchimp_apikey'], // Insert your api key
'secure' => FALSE )// Optional (defaults to FALSE)
;
		
		$this->CI->load->library ( 'mailchimp/MCAPI.php', $config, 'mail_chimp' );
		
		return $this->CI->mail_chimp->campaignSendNow ( $cid );
	}
}
