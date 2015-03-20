<?php
class Banners extends Admin_Controller {
	function __construct() {
		parent::__construct ();
		
		remove_ssl ();
		$this->auth->check_access ( 'Admin', true );
		
		$this->lang->load ( 'banner' );
		
		$this->load->model ( 'Banner_model' );
		$this->load->helper ( 'date' );
		
		define ( 'TRANSLATABLE', true );
	}
	
	function index() {
		$this->data ['banners'] = $this->Banner_model->get_banners ();
		$this->data ['page_title'] = lang ( 'banners' );
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/banners', $this->data );
	}
	
	function organize() {
		$banners = $this->input->post ( 'banners' );
		$this->Banner_model->organize ( $banners );
	}
	
	function delete($id) {
		$this->Banner_model->delete ( $id );
		
		$this->session->set_flashdata ( 'message', lang ( 'message_delete_banner' ) );
		redirect ( $this->config->item ( 'admin_folder' ) . '/banners' );
	}
	
	/********************************************************************
	this function is called by an ajax script, it re-sorts the banners
	 ********************************************************************/
	
	function form($id = false) {
		
		$config ['upload_path'] = $this->config->item ( 'upload_server_path' ) . 'images/full';
		$config ['allowed_types'] = 'gif|jpg|png';
		$config ['max_size'] = $this->config->item ( 'size_limit' );
		$config ['encrypt_name'] = true;
		$this->load->library ( 'upload', $config );
		
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
		
		//set the default values
		$this->data = array ('id' => $id, 'title' => '', 'enable_on' => '', 'disable_on' => '', 'image' => '', 'link' => '', 'new_window' => false, 'description' => '', 'alt_text' => '', 'template' => 0 );
		
		if ($id) {
			$this->data = ( array ) $this->Banner_model->get_banner ( $id );
			$this->data ['enable_on'] = format_mdy ( $this->data ['enable_on'] );
			$this->data ['disable_on'] = format_mdy ( $this->data ['disable_on'] );
			$this->data ['new_window'] = ( bool ) $this->data ['new_window'];
			$this->data ['description'] = html_entity_decode ( $this->data ['description'] );
		}
		
		$this->data ['page_title'] = lang ( 'banner_form' );
		
		$this->form_validation->set_rules ( 'title', 'lang:title', 'trim|required|full_decode' );
		$this->form_validation->set_rules ( 'enable_on', 'lang:enable_on', 'trim' );
		$this->form_validation->set_rules ( 'disable_on', 'lang:disable_on', 'trim|callback_date_check' );
		$this->form_validation->set_rules ( 'image', 'lang:image', 'trim' );
		$this->form_validation->set_rules ( 'link', 'lang:link', 'trim' );
		$this->form_validation->set_rules ( 'new_window', 'lang:new_window', 'trim' );
		
		$this->form_validation->set_rules ( 'description', 'lang:description', 'trim' );
		$this->form_validation->set_rules ( 'alt_text', 'lang:alt_text', 'trim' );
		$this->form_validation->set_rules ( 'template', 'lang:template', 'trim' );
		
		if ($this->form_validation->run () == false) {
			$this->data ['error'] = validation_errors ();
			$this->load->view ( $this->config->item ( 'admin_folder' ) . '/banner_form', $this->data );
		} else {
			$uploaded = $this->upload->do_upload ( 'image' );
			
			$save ['title'] = $this->input->post ( 'title' );
			$save ['enable_on'] = format_ymd ( $this->input->post ( 'enable_on' ) );
			$save ['disable_on'] = format_ymd ( $this->input->post ( 'disable_on' ) );
			$save ['link'] = $this->input->post ( 'link' );
			$save ['new_window'] = $this->input->post ( 'new_window' );
			
			$save ['description'] = $this->input->post ( 'description' );
			$save ['alt_text'] = $this->input->post ( 'alt_text' );
			$save ['template'] = intval ( $this->input->post ( 'template' ) );
			
			if ($id) {
				$save ['id'] = $id;
				
				//delete the original file if another is uploaded
				if ($uploaded) {
					if ($this->data ['image'] != '') {
						$file = $this->config->item ( 'upload_server_path' ) . 'images/full/' . $this->data ['image'];
						
						//delete the existing file if needed
						if (file_exists ( $file )) {
							unlink ( $file );
						}
					}
				}
			
			} else {
				if (! $uploaded) {
					$this->data ['error'] = $this->upload->display_errors ();
					$this->load->view ( $this->config->item ( 'admin_folder' ) . '/banner_form', $this->data );
					return; //end script here if there is an error
				}
			}
			
			if ($uploaded) {
				$image = $this->upload->data ();
				$save ['image'] = $image ['file_name'];
			}
			
			$this->Banner_model->save_banner ( $save );
			
			$this->session->set_flashdata ( 'message', lang ( 'message_banner_saved' ) );
			
			redirect ( $this->config->item ( 'admin_folder' ) . '/banners' );
		}
	}
	
	function date_check() {
		
		if ($this->input->post ( 'disable_on' ) != '') {
			if (format_ymd ( $this->input->post ( 'disable_on' ) ) <= format_ymd ( $this->input->post ( 'enable_on' ) )) {
				$this->form_validation->set_message ( 'date_check', lang ( 'date_error' ) );
				return FALSE;
			}
		}
		
		return TRUE;
	}
}