<?php

class Products extends Admin_Controller {
	
	private $use_inventory = false;
	
	function __construct() {
		parent::__construct ();
		remove_ssl ();
		
		$this->auth->check_access ( 'Admin', true );
		
		$this->load->model ( 'Product_model' );
		$this->load->model ( 'Connected_products_model' );
		$this->load->helper ( 'form' );
		$this->lang->load ( 'product' );
		
		define ( 'TRANSLATABLE', true );
	}
	
	function index($order_by = "name", $sort_order = "ASC", $code = 0, $page = 0, $rows = 15) {
		
		$this->data ['page_title'] = lang ( 'products' );
		
		$this->data ['code'] = $code;
		$term = false;
		$category_id = false;
		
		//get the category list for the drop menu
		$this->data ['categories'] = $this->Category_model->get_categories_tierd ();
		
		$post = $this->input->post ( null, false );
		$this->load->model ( 'Search_model' );
		if ($post) {
			$term = json_encode ( $post );
			$code = $this->Search_model->record_term ( $term );
			$this->data ['code'] = $code;
		} elseif ($code) {
			$term = $this->Search_model->get_term ( $code );
		}
		
		//store the search term
		$this->data ['term'] = $term;
		$this->data ['order_by'] = $order_by;
		$this->data ['sort_order'] = $sort_order;
		
		$this->data ['products'] = $this->Product_model->products ( array ('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order, 'rows' => $rows, 'page' => $page ) );
		
		//total number of products
		$this->data ['total'] = $this->Product_model->products ( array ('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order ), true );
		
		$this->load->library ( 'pagination' );
		
		$config ['base_url'] = site_url ( $this->config->item ( 'admin_folder' ) . '/products/index/' . $order_by . '/' . $sort_order . '/' . $code . '/' );
		$config ['total_rows'] = $this->data ['total'];
		$config ['per_page'] = $rows;
		$config ['uri_segment'] = 7;
		$config ['first_link'] = 'First';
		$config ['first_tag_open'] = '<li>';
		$config ['first_tag_close'] = '</li>';
		$config ['last_link'] = 'Last';
		$config ['last_tag_open'] = '<li>';
		$config ['last_tag_close'] = '</li>';
		
		$config ['full_tag_open'] = '<div class="pagination"><ul>';
		$config ['full_tag_close'] = '</ul></div>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		
		$config ['prev_link'] = '&laquo;';
		$config ['prev_tag_open'] = '<li>';
		$config ['prev_tag_close'] = '</li>';
		
		$config ['next_link'] = '&raquo;';
		$config ['next_tag_open'] = '<li>';
		$config ['next_tag_close'] = '</li>';
		
		$this->pagination->initialize ( $config );
		
		$this->data ['product_categories'] = array ();
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/products', $this->data );
	}
	
	//basic product search
	function product_autocomplete() {
		$name = trim ( $this->input->post ( 'name' ) );
		$limit = $this->input->post ( 'limit' );
		
		if (empty ( $name )) {
			echo json_encode ( array () );
		} else {
			$results = $this->Product_model->product_autocomplete ( $name, $limit );
			
			$return = array ();
			
			foreach ( $results as $r ) {
				$return [$r->id] = $r->name;
			}
			echo json_encode ( $return );
		}
	
	}
	
	function bulk_save() {
		$products = $this->input->post ( 'product' );
		
		if (! $products) {
			$this->session->set_flashdata ( 'error', lang ( 'error_bulk_no_products' ) );
			redirect ( $this->config->item ( 'admin_folder' ) . '/products' );
		}
		
		foreach ( $products as $id => $product ) {
			$product ['id'] = $id;
			$this->Product_model->save ( $product );
			
			$connected_parent_product = $this->Connected_products_model->get_connected_parent ( $id );
			
			if ($connected_parent_product) {
				if ($connected_parent_product ['connected_product_bool'] == 1) {
					$connected_parent_id_array = ( array ) json_decode ( $connected_parent_product ['connected_parent_product_ids'] );
					$connected_parent_id = $connected_parent_id_array [0];
					$connected_children_product_details_array = objectToArray ( json_decode ( $this->Connected_products_model->get_connected_children_product_details ( $connected_parent_id ) ) );
					
					foreach ( $connected_children_product_details_array as $key => $value ) {
						if ($key == $id) {
							unset ( $connected_children_product_details_array [$id] ['options'] ['quantity'] );
							$connected_children_product_details_array [$id] ['options'] ['quantity'] = $product ['quantity'];
							$this->Connected_products_model->bulk_save_connected_parent_products ( $connected_parent_id, $connected_children_product_details_array );
						}
					}
				}
			}
		}
		
		$this->session->set_flashdata ( 'message', lang ( 'message_bulk_update' ) );
		redirect ( $this->config->item ( 'admin_folder' ) . '/products' );
	}
	
	/*
	function organize()
	{
		$products = $this->input->post('products');
		$this->Product_model->organize($products);
	}
	*/
	
	function form($id = false, $duplicate = false) {
		$this->product_id = $id;
		$this->load->library ( 'form_validation' );
		$this->load->model ( array ('Option_model', 'Category_model', 'Digital_Product_model' ) );
		$this->lang->load ( 'digital_product' );
		$this->form_validation->set_error_delimiters ( '<div class="error">', '</div>' );
		
		//$this->data['categories']		= $this->Category_model->get_categories_tierd();
		//$this->data['product_list']	= $this->Product_model->get_products();
		$this->data ['file_list'] = $this->Digital_Product_model->get_list ();
		
		$this->data ['page_title'] = lang ( 'product_form' );
		
		//default values are empty if the product is new
		$this->data ['id'] = '';
		$this->data ['sku'] = '';
		$this->data ['name'] = '';
		$this->data ['slug'] = '';
		$this->data ['description'] = '';
		$this->data ['excerpt'] = '';
		$this->data ['price'] = '';
		$this->data ['saleprice'] = '';
		$this->data ['weight'] = '';
		$this->data ['track_stock'] = '';
		$this->data ['seo_title'] = '';
		$this->data ['meta'] = '';
		$this->data ['shippable'] = '';
		$this->data ['taxable'] = '';
		$this->data ['fixed_quantity'] = '';
		$this->data ['quantity'] = '';
		$this->data ['enabled'] = 0;
		$this->data ['related_products'] = array ();
		$this->data ['product_categories'] = array ();
		$this->data ['images'] = array ();
		$this->data ['product_files'] = array ();
		
		$this->data ['connected_product_bool'] = 0;
		$this->data ['connected_parent_product_ids'] = array ();
		$this->data ['connected_parents'] = array ();
		
		$this->data ['show_connected_product_bool'] = false;
		$this->data ['show_connected_product_options'] = false;
		
		//create the photos array for later use
		$this->data ['photos'] = array ();
		
		if ($id) {
			// get the existing file associations and create a format we can read from the form to set the checkboxes
			$pr_files = $this->Digital_Product_model->get_associations_by_product ( $id );
			foreach ( $pr_files as $f ) {
				$this->data ['product_files'] [] = $f->file_id;
			}
			
			// get product & options data
			$this->data ['product_options'] = $this->Option_model->get_product_options ( $id );
			$product = $this->Product_model->get_product ( $id );
			$connected_parent_products = $this->Connected_products_model->get_connected_parent_products ( $id );
			
			//if the product does not exist, redirect them to the product list with an error
			if (! $product) {
				$this->session->set_flashdata ( 'error', lang ( 'error_not_found' ) );
				redirect ( $this->config->item ( 'admin_folder' ) . '/products' );
			}
			
			//helps us with the slug generation
			$this->product_name = $this->input->post ( 'slug', $product->slug );
			
			//set values to db values
			$this->data ['id'] = $id;
			$this->data ['sku'] = $product->sku;
			$this->data ['name'] = $product->name;
			$this->data ['seo_title'] = $product->seo_title;
			$this->data ['meta'] = $product->meta;
			$this->data ['slug'] = $product->slug;
			$this->data ['description'] = $product->description;
			$this->data ['excerpt'] = $product->excerpt;
			$this->data ['price'] = $product->price;
			$this->data ['saleprice'] = $product->saleprice;
			$this->data ['weight'] = $product->weight;
			$this->data ['track_stock'] = $product->track_stock;
			$this->data ['shippable'] = $product->shippable;
			$this->data ['quantity'] = $product->quantity;
			$this->data ['taxable'] = $product->taxable;
			$this->data ['fixed_quantity'] = $product->fixed_quantity;
			$this->data ['enabled'] = $product->enabled;
			
			$this->data ['connected_product_bool'] = $connected_parent_products->connected_product_bool;
			
			//make sure we haven't submitted the form yet before we pull in the images/related products from the database
			if (! $this->input->post ( 'submit' )) {
				$this->data ['product_categories'] = $product->categories;
				$this->data ['related_products'] = $product->related_products;
				$this->data ['images'] = ( array ) json_decode ( $product->images );
				$this->data ['connected_parent_product_ids'] = $connected_parent_products->connected_parent_product_ids;
				$this->data ['connected_parents'] = $connected_parent_products->connected_parents;
			}
		}
		
		//if $this->data['related_products'] is not an array, make it one.
		if (! is_array ( $this->data ['related_products'] )) {
			$this->data ['related_products'] = array ();
		}
		if (! is_array ( $this->data ['product_categories'] )) {
			$this->data ['product_categories'] = array ();
		}
		if (! is_array ( $this->data ['connected_parent_product_ids'] )) {
			$this->data ['connected_parent_product_ids'] = array ();
		}
		
		//no error checking on these
		$this->form_validation->set_rules ( 'caption', 'Caption' );
		$this->form_validation->set_rules ( 'primary_photo', 'Primary' );
		
		$this->form_validation->set_rules ( 'sku', 'lang:sku', 'trim' );
		$this->form_validation->set_rules ( 'seo_title', 'lang:seo_title', 'trim' );
		$this->form_validation->set_rules ( 'meta', 'lang:meta_data', 'trim' );
		$this->form_validation->set_rules ( 'name', 'lang:name', 'trim|required|max_length[64]' );
		$this->form_validation->set_rules ( 'slug', 'lang:slug', 'trim' );
		$this->form_validation->set_rules ( 'description', 'lang:description', 'trim' );
		$this->form_validation->set_rules ( 'excerpt', 'lang:excerpt', 'trim' );
		$this->form_validation->set_rules ( 'price', 'lang:price', 'trim|numeric|required|floatval' );
		$this->form_validation->set_rules ( 'saleprice', 'lang:saleprice', 'trim|numeric|floatval' );
		$this->form_validation->set_rules ( 'weight', 'lang:weight', 'trim|numeric|required|floatval' );
		$this->form_validation->set_rules ( 'track_stock', 'lang:track_stock', 'trim|numeric' );
		$this->form_validation->set_rules ( 'quantity', 'lang:quantity', 'trim|required|numeric' );
		$this->form_validation->set_rules ( 'shippable', 'lang:shippable', 'trim|numeric' );
		$this->form_validation->set_rules ( 'taxable', 'lang:taxable', 'trim|numeric' );
		$this->form_validation->set_rules ( 'fixed_quantity', 'lang:fixed_quantity', 'trim|numeric' );
		$this->form_validation->set_rules ( 'enabled', 'lang:enabled', 'trim|numeric' );
		
		$this->form_validation->set_rules ( 'connected_product_bool', 'lang:connected_product', 'trim|numeric' );
		if ($this->input->post ( 'connected_product_bool' ) == '1') {
			$this->form_validation->set_rules ( 'connected_parent_product_ids', 'lang:not_null_connected_product', 'required' );
		}
		
		/*
		if we've posted already, get the photo stuff and organize it
		if validation comes back negative, we feed this info back into the system
		if it comes back good, then we send it with the save item
		
		submit button has a value, so we can see when it's posted
		*/
		
		if ($duplicate) {
			$this->data ['id'] = false;
		}
		if ($this->input->post ( 'submit' )) {
			//reset the product options that were submitted in the post
			$this->data ['product_options'] = $this->input->post ( 'option' );
			$this->data ['related_products'] = $this->input->post ( 'related_products' );
			$this->data ['product_categories'] = $this->input->post ( 'categories' );
			$this->data ['images'] = $this->input->post ( 'images' );
			$this->data ['product_files'] = $this->input->post ( 'downloads' );
			$this->data ['connected_parent_product_ids'] = $this->input->post ( 'connected_parent_product_ids' );
		}
		
		if ($this->form_validation->run () == FALSE) {
			$this->load->view ( $this->config->item ( 'admin_folder' ) . '/product_form', $this->data );
		} else {
			
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
				$slug = $this->Routes_model->validate_slug ( $slug, $product->route_id );
				$route_id = $product->route_id;
			} else {
				$slug = $this->Routes_model->validate_slug ( $slug );
				
				$route ['slug'] = $slug;
				$route_id = $this->Routes_model->save ( $route );
			}
			
			$save ['id'] = $id;
			$save ['sku'] = $this->input->post ( 'sku' );
			$save ['name'] = $this->input->post ( 'name' );
			$save ['seo_title'] = $this->input->post ( 'seo_title' );
			$save ['meta'] = quotes_to_entities ( $this->input->post ( 'meta' ) );
			$save ['description'] = $this->input->post ( 'description' );
			$save ['excerpt'] = $this->input->post ( 'excerpt' );
			$save ['price'] = $this->input->post ( 'price' );
			$save ['saleprice'] = $this->input->post ( 'saleprice' );
			$save ['weight'] = $this->input->post ( 'weight' );
			$save ['track_stock'] = $this->input->post ( 'track_stock' );
			$save ['fixed_quantity'] = $this->input->post ( 'fixed_quantity' );
			$save ['quantity'] = $this->input->post ( 'quantity' );
			$save ['shippable'] = $this->input->post ( 'shippable' );
			$save ['taxable'] = $this->input->post ( 'taxable' );
			$save ['enabled'] = $this->input->post ( 'enabled' );
			$post_images = $this->input->post ( 'images' );
			
			$save ['slug'] = $slug;
			$save ['route_id'] = $route_id;
			
			if ($primary = $this->input->post ( 'primary_image' )) {
				if ($post_images) {
					foreach ( $post_images as $key => &$pi ) {
						if ($primary == $key) {
							$pi ['primary'] = true;
							
							continue;
						}
					}
				}
			}
			
			if ($post_images) {
				foreach ( $post_images as $key => &$pi ) {
					$pi ['caption'] = $pi ['caption'];
				}
			}
			
			$save ['images'] = json_encode ( $post_images );
			
			if ($this->input->post ( 'related_products' )) {
				$save ['related_products'] = json_encode ( $this->input->post ( 'related_products' ) );
			} else {
				$save ['related_products'] = '';
			}
			
			//save categories
			$categories = $this->input->post ( 'categories' );
			if (! $categories) {
				$categories = array ();
			}
			
			// format options
			$options = array ();
			if ($this->input->post ( 'option' )) {
				foreach ( $this->input->post ( 'option' ) as $option ) {
					$options [] = $option;
				}
			
			}
			
			$save_connected ['connected_product_bool'] = $this->input->post ( 'connected_product_bool' );
			
			if ($this->input->post ( 'connected_parent_product_ids' )) {
				$save_connected ['connected_parent_product_ids'] = json_encode ( $this->input->post ( 'connected_parent_product_ids' ) );
			} else {
				$save_connected ['connected_parent_product_ids'] = '';
			}
			
			// save product 
			$product_id = $this->Product_model->save ( $save, $options, $categories );
			
			// save connected child 
			$this->Connected_products_model->save_connected_child_product ( $product_id, $save, $save_connected );
			
			// save connected parent 
			$this->Connected_products_model->save_connected_parent_product ( $product_id, $save, $save_connected );
			
			// add file associations
			// clear existsing
			$this->Digital_Product_model->disassociate ( false, $product_id );
			// save new
			$downloads = $this->input->post ( 'downloads' );
			if (is_array ( $downloads )) {
				foreach ( $downloads as $d ) {
					$this->Digital_Product_model->associate ( $d, $product_id );
				}
			}
			
			//save the route
			$route ['id'] = $route_id;
			$route ['slug'] = $slug;
			$route ['route'] = 'cart/product/' . $product_id;
			
			$this->Routes_model->save ( $route );
			
			$this->session->set_flashdata ( 'message', lang ( 'message_saved_product' ) );
			
			////////////////////////////////////////////////// OPEN GRAPH /////////////////////////////////////////////////// 
			

			if ($post_images) {
				if ($id != 1 && $id != 2) {
					$primary_og = false;
					foreach ( $post_images as $image ) {
						if (isset ( $image ['primary'] )) {
							$primary_og = true;
							$image_og = $image ['filename'];
						}
					}
					if (! $primary_og) {
						//print_r_html($post_images);
						reset ( $post_images );
						$image_og = $post_images [key ( $post_images )] ['filename'];
					
		//print_r_html($image_og);
					//exit;
					}
					
					list ( $width, $height, $type, $attr ) = getimagesize ( base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $image_og ) );
					$src_ratio = round ( $width / $height, 3 );
					//print_r_html(array('width' => $width, 'height' => $height, 'ratio' => $src_ratio));
					//exit;
					

					$dest_width = 1200;
					$dest_height = 630;
					$dest_ratio = round ( $dest_width / $dest_height, 3 );
					
					$save_path = $this->config->item ( 'og_server_path' ) . 'product/' . $id . '/' . $this->session->userdata ( 'lang_scope' ) . '/';
					
					if (file_exists ( $save_path )) {
						deleteDir ( $save_path );
					}
					
					mkdir ( $save_path, 0775, true );
					
					if ($type == 3) //PNG
{
						// Copy 
						$src = imagecreatefrompng ( base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $image_og ) );
						
						// Merge
						$dest = resize_image_centered ( $src, $dest_width, $dest_height, 2 );
						
						// Output
						//header('Content-Type: image/png');
						//imagepng($dest);
						

						// Save
						$save_name = "open_graph_image.png";
						
						$remote_file = $save_path . $save_name;
						imagepng ( $dest, $remote_file, 9 );
						chmod ( $remote_file, 0775 );
					} elseif ($type == 1) //GIF
{
						// Copy 
						$src = imagecreatefromgif ( base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $image_og ) );
						
						// Merge
						$dest = resize_image_centered ( $src, $dest_width, $dest_height, 2 );
						
						// Output
						//header('Content-Type: image/gif');
						//imagegif($dest);
						

						// Save
						$save_name = "open_graph_image.gif";
						
						$remote_file = $save_path . $save_name;
						imagegif ( $dest, $remote_file );
						chmod ( $remote_file, 0775 );
					} elseif ($type == 2) //JPEG
{
						// Copy 
						$src = imagecreatefromjpeg ( base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $image_og ) );
						
						// Merge
						$dest = resize_image_centered ( $src, $dest_width, $dest_height, 2 );
						
						// Output
						//header('Content-Type: image/jpeg');
						//imagejpeg($dest);
						

						// Save
						$save_name = "open_graph_image.jpg";
						
						$remote_file = $save_path . $save_name;
						imagejpeg ( $dest, $remote_file, 100 );
						chmod ( $remote_file, 0775 );
					}
					
					// Free memory
					imagedestroy ( $dest );
					imagedestroy ( $src );
				}
			}
			
			//go back to the product list
			redirect ( $this->config->item ( 'admin_folder' ) . '/products' );
		}
	}
	
	function product_image_form() {
		$this->data ['file_name'] = false;
		$this->data ['error'] = false;
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/iframe/product_image_uploader', $this->data );
	}
	
	function product_image_upload() {
		$this->data ['file_name'] = false;
		$this->data ['error'] = false;
		
		$config ['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= $this->config->item('size_limit');
		$config ['upload_path'] = $this->config->item ( 'upload_server_path' ) . 'images/full';
		$config ['encrypt_name'] = true;
		$config ['remove_spaces'] = true;
		
		$this->load->library ( 'upload', $config );
		
		if ($this->upload->do_upload ()) {
			$upload_data = $this->upload->data ();
			
			$this->load->library ( 'image_lib' );
			/*
			
			I find that ImageMagick is more efficient that GD2 but not everyone has it
			if your server has ImageMagick then you can change out the line
			
			$config['image_library'] = 'gd2';
			
			with
			
			$config['library_path']		= '/usr/bin/convert'; //make sure you use the correct path to ImageMagic
			$config['image_library']	= 'ImageMagick';
			*/
			
			//this is the larger image
			$config ['image_library'] = 'gd2';
			$config ['source_image'] = $this->config->item ( 'upload_server_path' ) . 'images/full/' . $upload_data ['file_name'];
			$config ['new_image'] = $this->config->item ( 'upload_server_path' ) . 'images/medium/' . $upload_data ['file_name'];
			$config ['maintain_ratio'] = TRUE;
			$config ['width'] = 600;
			$config ['height'] = 600;
			$this->image_lib->initialize ( $config );
			$this->image_lib->resize ();
			$this->image_lib->clear ();
			
			//small image
			$config ['image_library'] = 'gd2';
			$config ['source_image'] = $this->config->item ( 'upload_server_path' ) . 'images/medium/' . $upload_data ['file_name'];
			$config ['new_image'] = $this->config->item ( 'upload_server_path' ) . 'images/small/' . $upload_data ['file_name'];
			$config ['maintain_ratio'] = TRUE;
			$config ['width'] = 235;
			$config ['height'] = 235;
			$this->image_lib->initialize ( $config );
			$this->image_lib->resize ();
			$this->image_lib->clear ();
			
			//cropped thumbnail
			$config ['image_library'] = 'gd2';
			$config ['source_image'] = $this->config->item ( 'upload_server_path' ) . 'images/small/' . $upload_data ['file_name'];
			$config ['new_image'] = $this->config->item ( 'upload_server_path' ) . 'images/thumbnails/' . $upload_data ['file_name'];
			$config ['maintain_ratio'] = TRUE;
			$config ['width'] = 150;
			$config ['height'] = 150;
			$this->image_lib->initialize ( $config );
			$this->image_lib->resize ();
			$this->image_lib->clear ();
			
			//cropped tiny
			$config ['image_library'] = 'gd2';
			$config ['source_image'] = $this->config->item ( 'upload_server_path' ) . 'images/thumbnails/' . $upload_data ['file_name'];
			$config ['new_image'] = $this->config->item ( 'upload_server_path' ) . 'images/tiny/' . $upload_data ['file_name'];
			$config ['maintain_ratio'] = TRUE;
			$config ['width'] = 75;
			$config ['height'] = 75;
			$this->image_lib->initialize ( $config );
			$this->image_lib->resize ();
			$this->image_lib->clear ();
			
			$this->data ['file_name'] = $upload_data ['file_name'];
		}
		
		if ($this->upload->display_errors () != '') {
			$this->data ['error'] = $this->upload->display_errors ();
		}
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/iframe/product_image_uploader', $this->data );
	}
	
	function delete($id = false) {
		if ($id) {
			$product = $this->Product_model->get_product ( $id );
			$connected_parent_products = $this->Connected_products_model->get_connected_parent_products ( $id );
			
			//if the product does not exist, redirect them to the customer list with an error
			if (! $product) {
				$this->session->set_flashdata ( 'error', lang ( 'error_not_found' ) );
				redirect ( $this->config->item ( 'admin_folder' ) . '/products' );
			} else {
				// remove the slug
				$this->load->model ( 'Routes_model' );
				$this->Routes_model->remove ( '(' . $product->slug . ')' );
				
				// delete connected products
				$connected_parents = json_decode ( $connected_parent_products->connected_parent_product_ids, true );
				
				if (! empty ( $connected_parents )) {
					foreach ( $connected_parents as $p ) {
						$this->Connected_products_model->delete_connected_parent_product ( $p, $id );
					}
				}
				
				$this->Connected_products_model->delete_connected_child_product ( $id );
				
				//if the product is legit, delete them
				$this->Product_model->delete_product ( $id );
				
				$this->session->set_flashdata ( 'message', lang ( 'message_deleted_product' ) );
				redirect ( $this->config->item ( 'admin_folder' ) . '/products' );
			}
		} else {
			//if they do not provide an id send them to the product list page with an error
			$this->session->set_flashdata ( 'error', lang ( 'error_not_found' ) );
			redirect ( $this->config->item ( 'admin_folder' ) . '/products' );
		}
	}
}
