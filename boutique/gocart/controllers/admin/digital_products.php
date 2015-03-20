<?php

class Digital_Products extends Admin_Controller {
	
	function __construct() {
		parent::__construct ();
		$this->lang->load ( 'digital_product' );
		$this->load->model ( 'digital_product_model' );
		
		define ( 'TRANSLATABLE', true );
	}
	
	function index() {
		$this->data ['page_title'] = lang ( 'dgtl_pr_header' );
		$this->data ['file_list'] = $this->digital_product_model->get_list ();
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/digital_products', $this->data );
	}
	
	function form($id = 0) {
		$this->load->helper ( 'form_helper' );
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_error_delimiters ( '<div class="error">', '</div>' );
		
		$this->data = array ('id' => '', 'filename' => '', 'max_downloads' => '', 'title' => '', 'size' => '' );
		if ($id) {
			$this->data = array_merge ( $this->data, ( array ) $this->digital_product_model->get_file_info ( $id ) );
		}
		
		$this->data ['page_title'] = lang ( 'digital_products_form' );
		
		$this->form_validation->set_rules ( 'max_downloads', 'lang:max_downloads', 'numeric' );
		$this->form_validation->set_rules ( 'title', 'lang:title', 'trim|required' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->load->view ( $this->config->item ( 'admin_folder' ) . '/digital_product_form', $this->data );
		} else {
			
			if ($id == 0) {
				$this->data ['file_name'] = false;
				$this->data ['error'] = false;
				
				$config ['allowed_types'] = '*';
				$config ['upload_path'] = 'uploads/digital_uploads'; //$this->config->item('digital_products_path');
				$config ['remove_spaces'] = true;
				
				$this->load->library ( 'upload', $config );
				
				if ($this->upload->do_upload ()) {
					$upload_data = $this->upload->data ();
				} else {
					$this->data ['error'] = $this->upload->display_errors ();
					$this->load->view ( $this->config->item ( 'admin_folder' ) . '/digital_product_form', $this->data );
					return;
				}
				
				$save ['filename'] = $upload_data ['file_name'];
				$save ['size'] = $upload_data ['file_size'];
			} else {
				$save ['id'] = $id;
			}
			
			$save ['max_downloads'] = set_value ( 'max_downloads' );
			$save ['title'] = set_value ( 'title' );
			
			$this->digital_product_model->save ( $save );
			
			redirect ( $this->config->item ( 'admin_folder' ) . '/digital_products' );
		}
	}
	
	function delete($id) {
		$this->digital_product_model->delete ( $id );
		
		$this->session->set_flashdata ( 'message', lang ( 'message_deleted_file' ) );
		redirect ( $this->config->item ( 'admin_folder' ) . '/digital_products' );
	}

}