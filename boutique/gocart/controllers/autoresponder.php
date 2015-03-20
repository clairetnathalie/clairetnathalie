<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Autoresponder extends CI_Controller {
	
	var $exclude;
	var $result_order_emails;
	var $dateTime;
	var $one_day;
	var $one_week;
	var $one_month;
	var $now;
	
	var $one_day_array_email = array ();
	var $one_week_array_email = array ();
	var $one_month_array_email = array ();
	var $finished_array_email = array ();
	
	var $one_day_array_fname = array ();
	var $one_week_array_fname = array ();
	var $one_month_array_fname = array ();
	var $finished_array_fname = array ();
	
	var $one_day_array_lname = array ();
	var $one_week_array_lname = array ();
	var $one_month_array_lname = array ();
	var $finished_array_lname = array ();
	
	var $one_day_array_lang = array ();
	var $one_week_array_lang = array ();
	var $one_month_array_lang = array ();
	var $finished_array_lang = array ();
	
	var $cancel_array = array ();
	
	var $already_one_day_array_email = array ();
	var $already_one_week_array_email = array ();
	var $already_one_month_array_email = array ();
	
	var $unsubscribed_array = array ();
	var $subscribed_array = array ();
	
	function __construct() {
		parent::__construct ();
		
		//load needed models
		$this->load->model ( array ('Autoresponder_model' ) );
		
		//exclude email list
		$this->exclude = array ('inoescherer@gmail.com' );
		
		// set the default timezone to use. Available since PHP 5.1
		date_default_timezone_set ( 'Europe/Paris' );
		$this->now = $this->_get_time ();
		$this->one_day = 60 * 60 * 24;
		$this->one_day_plus_three_hours = $this->one_day + (60 * 60 * 3);
		$this->one_week = 60 * 60 * 24 * 7;
		$this->one_week_plus_three_hours = $this->one_week + (60 * 60 * 3);
		$this->one_month = 60 * 60 * 24 * 31;
		$this->one_month_plus_three_hours = $this->one_month + (60 * 60 * 3);
		
		$this->load->add_package_path ( APPPATH . 'packages/mailchimp/' );
		$this->load->library ( 'mailchimp_subscribe' );
	}
	
	public function index() {
		$result_session_data = objectToArray ( $this->Autoresponder_model->get_all_session_data () );
		
		$result_orders = objectToArray ( $this->Autoresponder_model->get_all_order_emails () );
		foreach ( $result_orders as $order ) {
			$this->result_order_emails [] = $order ['email'];
		}
		
		$result_one_day_list = objectToArray ( $this->Autoresponder_model->get_already_one_day_data () );
		if (! empty ( $result_one_day_list ['one_day_list'] )) {
			$this->already_one_day_array_email = unserialize ( $result_one_day_list ['one_day_list'] );
		} else {
			$this->already_one_day_array_email = array ();
		}
		
		$result_one_week_list = objectToArray ( $this->Autoresponder_model->get_already_one_week_data () );
		if (! empty ( $result_one_week_list ['one_week_list'] )) {
			$this->already_one_week_array_email = unserialize ( $result_one_week_list ['one_week_list'] );
		} else {
			$this->already_one_week_array_email = array ();
		}
		
		$result_one_month_list = objectToArray ( $this->Autoresponder_model->get_already_one_month_data () );
		if (! empty ( $result_one_month_list ['one_month_list'] )) {
			$this->already_one_month_array_email = unserialize ( $result_one_month_list ['one_month_list'] );
		} else {
			$this->already_one_month_array_email = array ();
		}
		
		$result_unsub_listMembers = $this->mailchimp_subscribe->getUnsubscribedMembersFromList ( '453c970a52', 'unsubscribed' );
		
		foreach ( $result_unsub_listMembers ['data'] as $unsub_member ) {
			$this->unsubscribed_array [] = $unsub_member ['email'];
		}
		
		$this_session_lang = 'fr';
		
		foreach ( $result_session_data as $session_data ) {
			if (isset ( $session_data ['user_data'] )) {
				$session = unserialize ( $session_data ['user_data'] );
				
				if (is_array ( $session )) {
					if (isset ( $session ['lang_scope'] )) {
						$this_session_lang = $session ['lang_scope'];
					} else {
						if (isset ( $session ['language'] )) {
							if ($session ['language'] == 'french') {
								$this_session_lang = 'fr';
							}
							
							if ($session ['language'] == 'english') {
								$this_session_lang = 'en';
							}
						}
					}
					
					if (isset ( $session ['cart_contents'] )) {
						if (isset ( $session ['cart_contents'] ['customer'] )) {
							//print_r_html($session['cart_contents']['customer']);
							

							if (isset ( $session ['cart_contents'] ['customer'] ['email'] ) && ! in_array ( $session ['cart_contents'] ['customer'] ['email'], $this->exclude )) {
								if (! in_array ( $session ['cart_contents'] ['customer'] ['email'], $this->result_order_emails ) && ! in_array ( $session ['cart_contents'] ['customer'] ['email'], $this->unsubscribed_array )) {
									if ($session_data ['last_activity'] > $this->now - $this->one_day && ! in_array ( $session ['cart_contents'] ['customer'] ['email'], $this->already_one_day_array_email )) {
										$this->one_day_array_email [] = $session ['cart_contents'] ['customer'] ['email'];
										$this->one_day_array_fname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['firstname'];
										$this->one_day_array_lname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['lastname'];
										$this->one_day_array_lang [$session ['cart_contents'] ['customer'] ['email']] = $this_session_lang;
									}
									
									if ($session_data ['last_activity'] > $this->now - $this->one_week && $session_data ['last_activity'] < $this->now - $this->one_day && ! in_array ( $session ['cart_contents'] ['customer'] ['email'], $this->already_one_week_array_email )) {
										$this->one_week_array_email [] = $session ['cart_contents'] ['customer'] ['email'];
										$this->one_week_array_fname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['firstname'];
										$this->one_week_array_lname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['lastname'];
										$this->one_week_array_lang [$session ['cart_contents'] ['customer'] ['email']] = $this_session_lang;
										
									/*
										if(in_array($session['cart_contents']['customer']['email'], $this->already_one_day_array_email) )
										{
											$key = array_search($session['cart_contents']['customer']['email'], $this->already_one_day_array_email);
											unset($this->already_one_day_array_email[$key]); 
										}
										*/
									}
									
									if ($session_data ['last_activity'] > $this->now - $this->one_month && ($session_data ['last_activity'] < $this->now - $this->one_week || $session_data ['last_activity'] < $this->now - $this->one_day) && ! in_array ( $session ['cart_contents'] ['customer'] ['email'], $this->already_one_month_array_email )) {
										$this->one_month_array_email [] = $session ['cart_contents'] ['customer'] ['email'];
										$this->one_month_array_fname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['firstname'];
										$this->one_month_array_lname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['lastname'];
										$this->one_month_array_lang [$session ['cart_contents'] ['customer'] ['email']] = $this_session_lang;
										
									/*
										if(in_array($session['cart_contents']['customer']['email'], $this->already_one_week_array_email) )
										{
											$key = array_search($session['cart_contents']['customer']['email'], $this->already_one_week_array_email);
											unset($this->already_one_week_array_email[$key]); 
										}
										*/
									}
									
									if ($session_data ['last_activity'] < $this->now - $this->one_month) {
										$this->finished_array_email [] = $session ['cart_contents'] ['customer'] ['email'];
										$this->finished_array_fname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['firstname'];
										$this->finished_array_lname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['lastname'];
										$this->finished_array_lang [$session ['cart_contents'] ['customer'] ['email']] = $this_session_lang;
										
									/*
										if(in_array($session['cart_contents']['customer']['email'], $this->already_one_month_array_email) )
										{
											$key = array_search($session['cart_contents']['customer']['email'], $this->already_one_month_array_email);
											unset($this->already_one_month_array_email[$key]); 
										}
										*/
									}
								}
								
								if (in_array ( $session ['cart_contents'] ['customer'] ['email'], $this->result_order_emails ) || in_array ( $session ['cart_contents'] ['customer'] ['email'], $this->unsubscribed_array )
									/*
									|| (    in_array($session['cart_contents']['customer']['email'], $this->already_one_month_array_email)
										 && in_array($session['cart_contents']['customer']['email'], $this->already_one_week_array_email)
										 && in_array($session['cart_contents']['customer']['email'], $this->already_one_day_array_email) )
									*/
								)
								{
									$this->finished_array_email [] = $session ['cart_contents'] ['customer'] ['email'];
									$this->finished_array_fname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['firstname'];
									$this->finished_array_lname [$session ['cart_contents'] ['customer'] ['email']] = $session ['cart_contents'] ['customer'] ['lastname'];
									$this->finished_array_lang [$session ['cart_contents'] ['customer'] ['email']] = $this_session_lang;
								}
							
		//print_r_html($this_session_lang);
							}
						}
					}
				}
			}
		}
		
		$this->data ['print_r'] = true;
		$this->data ['view_email'] = false;
		$this->data ['test_send'] = false;
		$this->data ['production'] = false;
		
		$this->one_day_array_email = array_unique ( $this->one_day_array_email );
		$this->one_week_array_email = array_unique ( $this->one_week_array_email );
		$this->one_month_array_email = array_unique ( $this->one_month_array_email );
		$this->finished_array_email = array_unique ( $this->finished_array_email );
		
		$this->one_day_array_fname = array_unique ( $this->one_day_array_fname );
		$this->one_week_array_fname = array_unique ( $this->one_week_array_fname );
		$this->one_month_array_fname = array_unique ( $this->one_month_array_fname );
		$this->finished_array_fname = array_unique ( $this->finished_array_fname );
		
		$this->one_day_array_lname = array_unique ( $this->one_day_array_lname );
		$this->one_week_array_lname = array_unique ( $this->one_week_array_lname );
		$this->one_month_array_lname = array_unique ( $this->one_month_array_lname );
		$this->finished_array_lname = array_unique ( $this->finished_array_lname );
		
		/*
		$this->one_day_array_lang = array_unique($this->one_day_array_lang);
		$this->one_week_array_lang = array_unique($this->one_week_array_lang);
		$this->one_month_array_lang = array_map("unserialize", array_unique(array_map("serialize", $this->one_month_array_lang)));
		$this->finished_array_lang = array_unique($this->finished_array_lang);
		*/
		
		if ($this->data ['production']) {
			$count = 0;
			foreach ( $this->one_day_array_email as $one_day_member_key => $one_day_member_value ) {
				$merge_vars = array ('FNAME' => $this->one_day_array_fname [$one_day_member_value], 'LNAME' => $this->one_day_array_lname [$one_day_member_value], 'MC_LANGUAGE' => $this->one_day_array_lang [$one_day_member_value], 'STATUS' => '1 DAY' );
				
				$this->mailchimp_subscribe->subscribe_bis ( '453c970a52', $one_day_member_value, $merge_vars, 'html', false, true, true, false );
			}
			foreach ( $this->one_week_array_email as $one_week_member_key => $one_week_member_value ) {
				$merge_vars = array ('FNAME' => $this->one_week_array_fname [$one_week_member_value], 'LNAME' => $this->one_week_array_lname [$one_week_member_value], 'MC_LANGUAGE' => $this->one_week_array_lang [$one_week_member_value], 'STATUS' => '1 WEEK' );
				
				$this->mailchimp_subscribe->subscribe_bis ( '453c970a52', $one_week_member_value, $merge_vars, 'html', false, true, true, false );
			}
			foreach ( $this->one_month_array_email as $one_month_member_key => $one_month_member_value ) {
				$merge_vars = array ('FNAME' => $this->one_month_array_fname [$one_month_member_value], 'LNAME' => $this->one_month_array_lname [$one_month_member_value], 'MC_LANGUAGE' => $this->one_month_array_lang [$one_month_member_value], 'STATUS' => '1 MONTH' );
				
				$this->mailchimp_subscribe->subscribe_bis ( '453c970a52', $one_month_member_value, $merge_vars, 'html', false, true, true, false );
			}
			foreach ( $this->finished_array_email as $finished_member_key => $finished_member_value ) {
				$merge_vars = array ('FNAME' => $this->finished_array_fname [$finished_member_value], 'LNAME' => $this->finished_array_lname [$finished_member_value], 'MC_LANGUAGE' => $this->finished_array_lang [$finished_member_value], 'STATUS' => 'FINISHED' );
				
				$this->mailchimp_subscribe->subscribe_bis ( '453c970a52', $finished_member_value, $merge_vars, 'html', false, true, true, false );
			}
		}
		
		/*
		echo 'List MailChimp'."\n\r";
		print_r_html($this->subscribed_array);
		*/
		
		//$result_subscribe_members = $this->mailchimp_subscribe->getMergeVars('453c970a52');
		//print_r_html($result_subscribe_members);
		

		//$result_subscribe_members = $this->mailchimp_subscribe->subscribedMembersToList('453c970a52', $this->subscribed_array, false, true, true);
		//print_r_html($result_subscribe_members);
		

		//load the theme package
		$this->load->add_package_path ( APPPATH . 'themes/' . $this->config->item ( 'theme' ) . '/' );
		
		if ($this->data ['print_r']) {
			echo 'MailChimp list unsubscribed' . "\n\r";
			print_r_html ( $this->unsubscribed_array );
			echo 'Activity less than a day' . "\n\r";
			print_r_html ( $this->one_day_array_email );
			echo 'Activity less than a week' . "\n\r";
			print_r_html ( $this->one_week_array_email );
			echo 'Activity less than a month' . "\n\r";
			print_r_html ( $this->one_month_array_email );
			echo 'Activity more than a month' . "\n\r";
			print_r_html ( $this->finished_array_email );
		
		//print_r_html($this->mailchimp_subscribe->getCampaigns(array('list_id' => '453c970a52'), 0, 25 ));
		}
		if ($this->data ['view_email']) {
			$this->load->view ( 'autoresponder_email_en', $this->data ); // EN
		//$this->load->view('autoresponder_email_fr', $this->data); // FR
		}
		if ($this->data ['test_send']) {
			print_r_html ( $this->mailchimp_subscribe->campaignSendTest ( '409c40588e', $this->one_day_array_email ) ); // EN
			print_r_html ( $this->mailchimp_subscribe->campaignSendTest ( '5b86dd55b1', $this->one_day_array_email ) ); // FR
		}
		if ($this->data ['production']) {
			$this->mailchimp_subscribe->campaignSend ( '409c40588e' ); // 1 Day EN
			$this->mailchimp_subscribe->campaignSend ( '5b86dd55b1' ); // 1 Day FR
			

			$this->mailchimp_subscribe->campaignSend ( '24681a9daf' ); // 1 Week EN
			$this->mailchimp_subscribe->campaignSend ( 'd1538d004c' ); // 1 Week FR
			

			$this->mailchimp_subscribe->campaignSend ( 'c1374bf27e' ); // 1 Month EN
			$this->mailchimp_subscribe->campaignSend ( 'f8ee789fb9' ); // 1 Month FR
		}
		
	/*
		
		foreach($this->one_day_array_email as $one_day_member_key => $one_day_member_value)
		{
			$this->already_one_day_array_email[] = $one_day_member_value;
		}
		
		$this->Autoresponder_model->update_already_one_day_data(serialize(array_unique($this->already_one_day_array_email)));
		
		foreach($this->one_week_array_email as $one_week_member_key => $one_week_member_value)
		{
			$this->already_one_week_array_email[] = $one_week_member_value;
		}
		
		$this->Autoresponder_model->update_already_one_week_data(serialize(array_unique($this->already_one_week_array_email)));
		
		
		foreach($this->one_month_array_email as $one_month_member_key => $one_month_member_value)
		{
			$this->already_one_month_array_email[] = $one_month_member_value;
		}
		
		$this->Autoresponder_model->update_already_one_month_data(serialize(array_unique($this->already_one_month_array_email)));
		*/
	}
	
	function _get_time() {
		$now = time ();
		$time = mktime ( gmdate ( "H", $now ), gmdate ( "i", $now ), gmdate ( "s", $now ), gmdate ( "m", $now ), gmdate ( "d", $now ), gmdate ( "Y", $now ) );
		
		return $time;
	}

}

/* End of file hauth.php */
/* Location: ./application/controllers/hauth.php */
