<?php
class Pages extends Admin_Controller {
	
	function __construct() {
		parent::__construct ();
		
		remove_ssl ();
		
		$this->auth->check_access ( 'Admin', true );
		$this->load->model ( 'Page_model' );
		$this->lang->load ( 'page' );
		
		define ( 'TRANSLATABLE', true );
	}
	
	function index() {
		$this->data ['page_title'] = lang ( 'pages' );
		$this->data ['pages'] = $this->Page_model->get_pages ();
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/pages', $this->data );
	}
	
	/********************************************************************
	edit page
	 ********************************************************************/
	function form($id = false) {
		$this->load->helper ( 'url' );
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
		
		//set the default values
		$this->data ['id'] = '';
		$this->data ['title'] = '';
		$this->data ['menu_title'] = '';
		$this->data ['slug'] = '';
		$this->data ['sequence'] = 0;
		$this->data ['parent_id'] = 0;
		$this->data ['content'] = '';
		$this->data ['seo_title'] = '';
		$this->data ['meta'] = '';
		
		$this->data ['page_title'] = lang ( 'page_form' );
		$this->data ['pages'] = $this->Page_model->get_pages ();
		
		if ($id) {
			
			$page = $this->Page_model->get_page ( $id );
			
			if (! $page) {
				//page does not exist
				$this->session->set_flashdata ( 'error', lang ( 'error_page_not_found' ) );
				redirect ( $this->config->item ( 'admin_folder' ) . '/pages' );
			}
			
			//set values to db values
			$this->data ['id'] = $page->id;
			$this->data ['parent_id'] = $page->parent_id;
			$this->data ['title'] = $page->title;
			$this->data ['menu_title'] = $page->menu_title;
			$this->data ['sequence'] = $page->sequence;
			$this->data ['content'] = $page->content;
			$this->data ['seo_title'] = $page->seo_title;
			$this->data ['meta'] = $page->meta;
			$this->data ['slug'] = $page->slug;
		}
		
		$this->form_validation->set_rules ( 'title', 'lang:title', 'trim|required' );
		$this->form_validation->set_rules ( 'menu_title', 'lang:menu_title', 'trim' );
		$this->form_validation->set_rules ( 'slug', 'lang:slug', 'trim' );
		$this->form_validation->set_rules ( 'seo_title', 'lang:seo_title', 'trim' );
		$this->form_validation->set_rules ( 'meta', 'lang:meta', 'trim' );
		$this->form_validation->set_rules ( 'sequence', 'lang:sequence', 'trim|integer' );
		$this->form_validation->set_rules ( 'parent_id', 'lang:parent_id', 'trim|integer' );
		$this->form_validation->set_rules ( 'content', 'lang:content', 'trim' );
		
		// Validate the form
		if ($this->form_validation->run () == false) {
			$this->load->view ( $this->config->item ( 'admin_folder' ) . '/page_form', $this->data );
		} else {
			$this->load->helper ( 'text' );
			
			//first check the slug field
			$slug = $this->input->post ( 'slug' );
			
			//if it's empty assign the name field
			if (empty ( $slug ) || $slug == '') {
				$slug = $this->input->post ( 'title' );
			}
			
			$slug = url_title ( convert_accented_characters ( $slug ), 'dash', TRUE );
			
			//validate the slug
			$this->load->model ( 'Routes_model' );
			if ($id) {
				$slug = $this->Routes_model->validate_slug ( $slug, $page->route_id );
				$route_id = $page->route_id;
			} else {
				$slug = $this->Routes_model->validate_slug ( $slug );
				$route ['slug'] = $slug;
				$route_id = $this->Routes_model->save ( $route );
			}
			
			$save = array ();
			$save ['id'] = $id;
			$save ['parent_id'] = $this->input->post ( 'parent_id' );
			$save ['title'] = $this->input->post ( 'title' );
			$save ['menu_title'] = $this->input->post ( 'menu_title' );
			$save ['sequence'] = $this->input->post ( 'sequence' );
			$save ['content'] = $this->input->post ( 'content' );
			$save ['seo_title'] = $this->input->post ( 'seo_title' );
			$save ['meta'] = $this->input->post ( 'meta' );
			$save ['route_id'] = $route_id;
			$save ['slug'] = $slug;
			
			//set the menu title to the page title if if is empty
			if ($save ['menu_title'] == '') {
				$save ['menu_title'] = $this->input->post ( 'title' );
			}
			
			//save the page
			$page_id = $this->Page_model->save ( $save );
			
			//save the route
			$route ['id'] = $route_id;
			$route ['slug'] = $slug;
			$route ['route'] = 'cart/page/' . $page_id;
			
			$this->Routes_model->save ( $route );
			
			$this->session->set_flashdata ( 'message', lang ( 'message_saved_page' ) );
			
			//go back to the page list
			redirect ( $this->config->item ( 'admin_folder' ) . '/pages' );
		}
	}
	
	function link_form($id = false) {
		
		$this->load->helper ( 'url' );
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
		
		//set the default values
		$this->data ['id'] = '';
		$this->data ['title'] = '';
		$this->data ['url'] = '';
		$this->data ['new_window'] = false;
		$this->data ['sequence'] = 0;
		$this->data ['parent_id'] = 0;
		
		$this->data ['page_title'] = lang ( 'link_form' );
		$this->data ['pages'] = $this->Page_model->get_pages ();
		if ($id) {
			$page = $this->Page_model->get_page ( $id );
			
			if (! $page) {
				//page does not exist
				$this->session->set_flashdata ( 'error', lang ( 'error_link_not_found' ) );
				redirect ( $this->config->item ( 'admin_folder' ) . '/pages' );
			}
			
			//set values to db values
			$this->data ['id'] = $page->id;
			$this->data ['parent_id'] = $page->parent_id;
			$this->data ['title'] = $page->title;
			$this->data ['url'] = $page->url;
			$this->data ['new_window'] = ( bool ) $page->new_window;
			$this->data ['sequence'] = $page->sequence;
		}
		
		$this->form_validation->set_rules ( 'title', 'lang:title', 'trim|required' );
		$this->form_validation->set_rules ( 'url', 'lang:url', 'trim|required' );
		$this->form_validation->set_rules ( 'sequence', 'lang:sequence', 'trim|integer' );
		$this->form_validation->set_rules ( 'new_window', 'lang:new_window', 'trim|integer' );
		$this->form_validation->set_rules ( 'parent_id', 'lang:parent_id', 'trim|integer' );
		
		// Validate the form
		if ($this->form_validation->run () == false) {
			$this->load->view ( $this->config->item ( 'admin_folder' ) . '/link_form', $this->data );
		} else {
			$save = array ();
			$save ['id'] = $id;
			$save ['parent_id'] = $this->input->post ( 'parent_id' );
			$save ['title'] = $this->input->post ( 'title' );
			$save ['menu_title'] = $this->input->post ( 'title' );
			$save ['url'] = $this->input->post ( 'url' );
			$save ['sequence'] = $this->input->post ( 'sequence' );
			$save ['new_window'] = $this->input->post ( 'new_window' );
			
			//save the page
			$this->Page_model->save ( $save );
			
			$this->session->set_flashdata ( 'message', lang ( 'message_saved_link' ) );
			
			//go back to the page list
			redirect ( $this->config->item ( 'admin_folder' ) . '/pages' );
		}
	}
	
	/********************************************************************
	delete page
	 ********************************************************************/
	function delete($id) {
		
		$page = $this->Page_model->get_page ( $id );
		
		if ($page) {
			$this->load->model ( 'Routes_model' );
			
			$this->Routes_model->delete ( $page->route_id );
			$this->Page_model->delete_page ( $id );
			$this->session->set_flashdata ( 'message', lang ( 'message_deleted_page' ) );
		} else {
			$this->session->set_flashdata ( 'error', lang ( 'error_page_not_found' ) );
		}
		
		redirect ( $this->config->item ( 'admin_folder' ) . '/pages' );
	}
}	