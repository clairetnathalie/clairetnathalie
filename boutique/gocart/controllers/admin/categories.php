<?php

class Categories extends Admin_Controller {
	
	function __construct() {
		parent::__construct ();
		
		remove_ssl ();
		$this->auth->check_access ( 'Admin', true );
		$this->lang->load ( 'category' );
		$this->load->model ( 'Category_model' );
		
		define ( 'TRANSLATABLE', true );
	}
	
	function index() {
		//we're going to use flash data and redirect() after form submissions to stop people from refreshing and duplicating submissions
		//$this->session->set_flashdata('message', 'this is our message');
		

		$this->data ['page_title'] = lang ( 'categories' );
		$this->data ['categories'] = $this->Category_model->get_categories_tierd ();
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/categories', $this->data );
	}
	
	//basic category search
	function category_autocomplete() {
		$name = trim ( $this->input->post ( 'name' ) );
		$limit = $this->input->post ( 'limit' );
		
		if (empty ( $name )) {
			echo json_encode ( array () );
		} else {
			$results = $this->Category_model->category_autocomplete ( $name, $limit );
			
			$return = array ();
			foreach ( $results as $r ) {
				$return [$r->id] = $r->name;
			}
			echo json_encode ( $return );
		}
	
	}
	
	function organize($id = false) {
		$this->load->helper ( 'form' );
		$this->load->helper ( 'formatting' );
		
		if (! $id) {
			$this->session->set_flashdata ( 'error', lang ( 'error_must_select' ) );
			redirect ( $this->config->item ( 'admin_folder' ) . '/categories' );
		}
		
		$this->data ['category'] = $this->Category_model->get_category ( $id );
		//if the category does not exist, redirect them to the category list with an error
		if (! $this->data ['category']) {
			$this->session->set_flashdata ( 'error', lang ( 'error_not_found' ) );
			redirect ( $this->config->item ( 'admin_folder' ) . '/categories' );
		}
		
		$this->data ['page_title'] = sprintf ( lang ( 'organize_category' ), $this->data ['category']->name );
		
		$this->data ['category_products'] = $this->Category_model->get_category_products_admin ( $id );
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/organize_category', $this->data );
	}
	
	function process_organization($id) {
		$products = $this->input->post ( 'product' );
		$this->Category_model->organize_contents ( $id, $products );
	}
	
	function form($id = false) {
		
		$config ['upload_path'] = $this->config->item ( 'upload_server_path' ) . 'images/full';
		$config ['allowed_types'] = 'gif|jpg|png';
		$config ['max_size'] = $this->config->item ( 'size_limit' );
		$config ['max_width'] = '1024';
		$config ['max_height'] = '768';
		$config ['encrypt_name'] = true;
		$this->load->library ( 'upload', $config );
		
		$this->category_id = $id;
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_error_delimiters ( '<div class="error">', '</div>' );
		
		$this->data ['categories'] = $this->Category_model->get_categories ();
		$this->data ['page_title'] = lang ( 'category_form' );
		
		//default values are empty if the customer is new
		$this->data ['id'] = '';
		$this->data ['name'] = '';
		$this->data ['slug'] = '';
		$this->data ['description'] = '';
		$this->data ['excerpt'] = '';
		$this->data ['sequence'] = '';
		$this->data ['image'] = '';
		$this->data ['seo_title'] = '';
		$this->data ['meta'] = '';
		$this->data ['parent_id'] = 0;
		$this->data ['error'] = '';
		
		//create the photos array for later use
		$this->data ['photos'] = array ();
		
		if ($id) {
			$category = $this->Category_model->get_category ( $id );
			
			//if the category does not exist, redirect them to the category list with an error
			if (! $category) {
				$this->session->set_flashdata ( 'error', lang ( 'error_not_found' ) );
				redirect ( $this->config->item ( 'admin_folder' ) . '/categories' );
			}
			
			//helps us with the slug generation
			$this->category_name = $this->input->post ( 'slug', $category->slug );
			
			//set values to db values
			$this->data ['id'] = $category->id;
			$this->data ['name'] = $category->name;
			$this->data ['slug'] = $category->slug;
			$this->data ['description'] = $category->description;
			$this->data ['excerpt'] = $category->excerpt;
			$this->data ['sequence'] = $category->sequence;
			$this->data ['parent_id'] = $category->parent_id;
			$this->data ['image'] = $category->image;
			$this->data ['seo_title'] = $category->seo_title;
			$this->data ['meta'] = $category->meta;
		
		}
		
		$this->form_validation->set_rules ( 'name', 'lang:name', 'trim|required|max_length[64]' );
		$this->form_validation->set_rules ( 'slug', 'lang:slug', 'trim' );
		$this->form_validation->set_rules ( 'description', 'lang:description', 'trim' );
		$this->form_validation->set_rules ( 'excerpt', 'lang:excerpt', 'trim' );
		$this->form_validation->set_rules ( 'sequence', 'lang:sequence', 'trim|integer' );
		$this->form_validation->set_rules ( 'parent_id', 'parent_id', 'trim' );
		$this->form_validation->set_rules ( 'image', 'lang:image', 'trim' );
		$this->form_validation->set_rules ( 'seo_title', 'lang:seo_title', 'trim' );
		$this->form_validation->set_rules ( 'meta', 'lang:meta', 'trim' );
		
		// validate the form
		if ($this->form_validation->run () == FALSE) {
			$this->load->view ( $this->config->item ( 'admin_folder' ) . '/category_form', $this->data );
		} else {
			
			$uploaded = $this->upload->do_upload ( 'image' );
			
			if ($id) {
				//delete the original file if another is uploaded
				if ($uploaded) {
					
					if ($this->data ['image'] != '') {
						$file = array ();
						$file [] = $this->config->item ( 'upload_server_path' ) . 'images/full/' . $this->data ['image'];
						$file [] = $this->config->item ( 'upload_server_path' ) . 'images/medium/' . $this->data ['image'];
						$file [] = $this->config->item ( 'upload_server_path' ) . 'images/small/' . $this->data ['image'];
						$file [] = $this->config->item ( 'upload_server_path' ) . 'images/thumbnails/' . $this->data ['image'];
						
						foreach ( $file as $f ) {
							//delete the existing file if needed
							if (file_exists ( $f )) {
								unlink ( $f );
							}
						}
					}
				}
			
			} else {
				if (! $uploaded) {
					$error = $this->upload->display_errors ();
					if ($error != lang ( 'error_file_upload' )) {
						$this->data ['error'] .= $this->upload->display_errors ();
						$this->load->view ( $this->config->item ( 'admin_folder' ) . '/category_form', $this->data );
						return; //end script here if there is an error
					}
				}
			}
			
			if ($uploaded) {
				$image = $this->upload->data ();
				$save ['image'] = $image ['file_name'];
				
				$this->load->library ( 'image_lib' );
				
				//this is the larger image
				$config ['image_library'] = 'gd2';
				$config ['source_image'] = $this->config->item ( 'upload_server_path' ) . 'images/full/' . $save ['image'];
				$config ['new_image'] = $this->config->item ( 'upload_server_path' ) . 'images/medium/' . $save ['image'];
				$config ['maintain_ratio'] = TRUE;
				$config ['width'] = 600;
				$config ['height'] = 600;
				$this->image_lib->initialize ( $config );
				$this->image_lib->resize ();
				$this->image_lib->clear ();
				
				//small image
				$config ['image_library'] = 'gd2';
				$config ['source_image'] = $this->config->item ( 'upload_server_path' ) . 'images/medium/' . $save ['image'];
				$config ['new_image'] = $this->config->item ( 'upload_server_path' ) . 'images/small/' . $save ['image'];
				$config ['maintain_ratio'] = TRUE;
				$config ['width'] = 300;
				$config ['height'] = 300;
				$this->image_lib->initialize ( $config );
				$this->image_lib->resize ();
				$this->image_lib->clear ();
				
				//cropped thumbnail
				$config ['image_library'] = 'gd2';
				$config ['source_image'] = $this->config->item ( 'upload_server_path' ) . 'images/small/' . $save ['image'];
				$config ['new_image'] = $this->config->item ( 'upload_server_path' ) . 'images/thumbnails/' . $save ['image'];
				$config ['maintain_ratio'] = TRUE;
				$config ['width'] = 150;
				$config ['height'] = 150;
				$this->image_lib->initialize ( $config );
				$this->image_lib->resize ();
				$this->image_lib->clear ();
				
				//cropped tiny
				$config ['image_library'] = 'gd2';
				$config ['source_image'] = $this->config->item ( 'upload_server_path' ) . 'images/thumbnails/' . $save ['image'];
				$config ['new_image'] = $this->config->item ( 'upload_server_path' ) . 'images/tiny/' . $save ['image'];
				$config ['maintain_ratio'] = TRUE;
				$config ['width'] = 75;
				$config ['height'] = 75;
				$this->image_lib->initialize ( $config );
				$this->image_lib->resize ();
				$this->image_lib->clear ();
			}
			
			$this->load->helper ( 'text' );
			
			//first check the slug field
			$slug = $this->input->post ( 'slug' );
			
			//if it's empty assign the name field
			if (empty ( $slug ) || $slug == '') {
				$slug = $this->input->post ( 'name' );
			}
			
			$slug = url_title ( convert_accented_characters ( $slug ), 'dash', TRUE );
			
			//validate the slug
			$this->load->model ( 'Routes_model' );
			if ($id) {
				$slug = $this->Routes_model->validate_slug ( $slug, $category->route_id );
				$route_id = $category->route_id;
			} else {
				$slug = $this->Routes_model->validate_slug ( $slug );
				
				$route ['slug'] = $slug;
				$route_id = $this->Routes_model->save ( $route );
			}
			
			$save ['id'] = $id;
			$save ['name'] = $this->input->post ( 'name' );
			$save ['description'] = $this->input->post ( 'description' );
			$save ['excerpt'] = $this->input->post ( 'excerpt' );
			$save ['parent_id'] = intval ( $this->input->post ( 'parent_id' ) );
			$save ['sequence'] = intval ( $this->input->post ( 'sequence' ) );
			$save ['seo_title'] = $this->input->post ( 'seo_title' );
			$save ['meta'] = $this->input->post ( 'meta' );
			
			$save ['route_id'] = intval ( $route_id );
			$save ['slug'] = $slug;
			
			$category_id = $this->Category_model->save ( $save );
			
			//save the route
			$route ['id'] = $route_id;
			$route ['slug'] = $slug;
			$route ['route'] = 'cart/category/' . $category_id . '';
			
			$this->Routes_model->save ( $route );
			
			$this->session->set_flashdata ( 'message', lang ( 'message_category_saved' ) );
			
			//go back to the category list
			redirect ( $this->config->item ( 'admin_folder' ) . '/categories' );
		}
	}
	
	function delete($id) {
		
		$category = $this->Category_model->get_category ( $id );
		//if the category does not exist, redirect them to the customer list with an error
		if ($category) {
			$this->load->model ( 'Routes_model' );
			
			$this->Routes_model->delete ( $category->route_id );
			$this->Category_model->delete ( $id );
			
			$this->session->set_flashdata ( 'message', lang ( 'message_delete_category' ) );
			redirect ( $this->config->item ( 'admin_folder' ) . '/categories' );
		} else {
			$this->session->set_flashdata ( 'error', lang ( 'error_not_found' ) );
		}
	}
}