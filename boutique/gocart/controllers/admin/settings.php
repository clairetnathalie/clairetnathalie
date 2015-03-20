<?php

class Settings extends Admin_Controller {
	
	function __construct() {
		parent::__construct ();
		remove_ssl ();
		
		$this->auth->check_access ( 'Admin', true );
		$this->load->model ( 'Settings_model' );
		$this->load->model ( 'Messages_model' );
		$this->lang->load ( 'settings' );
		
		define ( 'TRANSLATABLE', false );
	}
	
	function index() {
		//we're going to handle the shipping and payment model landing page with this, basically
		

		//Payment Information
		$payment_order = $this->Settings_model->get_settings ( 'payment_order' );
		$enabled_modules = $this->Settings_model->get_settings ( 'payment_modules' );
		
		$this->data ['payment_modules'] = array ();
		//create a list of available payment modules
		if ($handle = opendir ( APPPATH . 'packages/payment/' )) {
			while ( false !== ($file = readdir ( $handle )) ) {
				//now we eliminate the periods from the list.
				if (! strstr ( $file, '.' )) {
					//also, set whether or not they are installed according to our payment settings
					if (array_key_exists ( $file, $enabled_modules )) {
						$this->data ['payment_modules'] [$file] ['installed'] = true;
						
						$activated = $this->Settings_model->check_setting_active ( $file );
						
						if ($activated) {
							$this->data ['payment_modules'] [$file] ['activated'] = true;
						} else {
							$this->data ['payment_modules'] [$file] ['activated'] = false;
						}
					} else {
						$this->data ['payment_modules'] [$file] ['installed'] = false;
						$this->data ['payment_modules'] [$file] ['activated'] = false;
					}
				}
			}
			closedir ( $handle );
		}
		//now time to do it again with shipping
		$shipping_order = $this->Settings_model->get_settings ( 'shipping_order' );
		$enabled_modules = $this->Settings_model->get_settings ( 'shipping_modules' );
		
		$this->data ['shipping_modules'] = array ();
		//create a list of available shipping modules
		if ($handle = opendir ( APPPATH . 'packages/shipping/' )) {
			while ( false !== ($file = readdir ( $handle )) ) {
				//now we eliminate anything with periods
				if (! strstr ( $file, '.' )) {
					//also, set whether or not they are installed according to our shipping settings
					if (array_key_exists ( $file, $enabled_modules )) {
						$this->data ['shipping_modules'] [$file] ['installed'] = true;
						
						$activated = $this->Settings_model->check_setting_active ( $file );
						
						if ($activated) {
							$this->data ['shipping_modules'] [$file] ['activated'] = true;
						} else {
							$this->data ['shipping_modules'] [$file] ['activated'] = false;
						}
					} else {
						$this->data ['shipping_modules'] [$file] ['installed'] = false;
						$this->data ['shipping_modules'] [$file] ['activated'] = false;
					}
				}
			}
			closedir ( $handle );
		}
		
		$this->data ['canned_messages'] = $this->Messages_model->get_list ();
		
		$this->data ['page_title'] = lang ( 'settings' );
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/settings', $this->data );
	}
	
	function canned_message_form($id = false) {
		$this->data ['page_title'] = lang ( 'canned_message_form' );
		
		$this->data ['id'] = $id;
		$this->data ['name'] = '';
		$this->data ['subject'] = '';
		$this->data ['content'] = '';
		$this->data ['deletable'] = 1;
		
		if ($id) {
			$message = $this->Messages_model->get_message ( $id );
			
			$this->data ['name'] = $message ['name'];
			$this->data ['subject'] = $message ['subject'];
			$this->data ['content'] = $message ['content'];
			$this->data ['deletable'] = $message ['deletable'];
		}
		
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
		
		$this->form_validation->set_rules ( 'name', 'lang:message_name', 'trim|required|max_length[50]' );
		$this->form_validation->set_rules ( 'subject', 'lang:subject', 'trim|required|max_length[100]' );
		$this->form_validation->set_rules ( 'content', 'lang:message_content', 'trim|required' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->data ['errors'] = validation_errors ();
			
			$this->load->view ( $this->config->item ( 'admin_folder' ) . '/canned_message_form', $this->data );
		} else {
			
			$save ['id'] = $id;
			$save ['name'] = $this->input->post ( 'name' );
			$save ['subject'] = $this->input->post ( 'subject' );
			$save ['content'] = $this->input->post ( 'content' );
			
			//all created messages are typed to order so admins can send them from the view order page.
			if ($this->data ['deletable']) {
				$save ['type'] = 'order';
			}
			$this->Messages_model->save_message ( $save );
			
			$this->session->set_flashdata ( 'message', lang ( 'message_saved_message' ) );
			redirect ( $this->config->item ( 'admin_folder' ) . '/settings' );
		}
	}
	
	function delete_message($id) {
		$this->Messages_model->delete_message ( $id );
		
		$this->session->set_flashdata ( 'message', lang ( 'message_deleted_message' ) );
		redirect ( $this->config->item ( 'admin_folder' ) . '/settings' );
	}
}