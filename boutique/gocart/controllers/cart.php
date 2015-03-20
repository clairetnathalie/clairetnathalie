<?php

class Cart extends Front_Controller {
	
	function __construct() {
		parent::__construct ();
		
		//make sure we're not always behind ssl
		remove_ssl ();
	}
	
	function index() {
		$this->load->model ( array ('Banner_model', 'box_model', 'connected_products_model', 'Social_model_fb' ) );
		$this->load->helper ( 'directory' );
		
		$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
		$this->data ['banners'] = $this->Banner_model->get_homepage_banners ( 6 );
		$this->data ['boxes'] = $this->box_model->get_homepage_boxes ( 8 );
		
		//$this->data['meta']							= $this->data['page']->meta;
		$this->data ['meta'] = $this->lang->line ( "cn_description_homepage" );
		
		//$this->data['seo_title']					= $this->lang->line("cn_title_homepage1");
		//$this->data['seo_title']					= $this->lang->line("cn_title");
		$this->data ['seo_title'] = $this->lang->line ( "cn_title_homepage2" );
		
		// print_r($this->data['boxes']);
		

		$this->data ['homepage'] = true;
		
		if ($this->config->item ( 'homepage_style_couettabra' )) {
			/*
			if($this->config->item('mobile_user') == true)
			{
				$this->load->view('homepage', $this->data);
			}
			else 
			{
				$this->load->view('homepage_style_plein_ecran', $this->data);
			}
			*/
			
			$this->load->view ( 'homepage_style_plein_ecran', $this->data );
		} else {
			if (! preg_match ( '/localhost/', $_SERVER ["HTTP_HOST"] )) {
				$this->load->view ( 'homepage', $this->data );
			
		//$this->compact_view($this->view('homepage', $this->data, TRUE));
			} else {
				$this->load->view ( 'homepage', $this->data );
			
		//$this->compact_view($this->view('homepage', $this->data, TRUE));
			}
		}
	}
	
	function page($id = false) {
		$this->load->model ( array ('Page_model', 'box_model' ) );
		
		//if there is no page id provided redirect to the homepage.
		$this->data ['page'] = $this->Page_model->get_page ( $id );
		if (! $this->data ['page']) {
			show_404 ();
		}
		$this->data ['base_url'] = $this->uri->segment_array ();
		
		$this->data ['fb_like'] = true;
		
		$this->data ['page_title'] = $this->data ['page']->title;
		$this->data ['page_slug'] = $this->data ['page']->slug;
		
		//$this->data['meta']						= $this->data['page']->meta;
		$this->data ['meta'] = $this->lang->line ( "cn_description_page" );
		
		$this->data ['seo_title'] = (! empty ( $this->data ['page']->seo_title )) ? $this->data ['page']->seo_title : $this->data ['page']->title;
		
		$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$this->data ['boxes'] = $this->box_model->get_homepage_boxes ( 8 );
		
		////////////////////////////////////////////////// OPEN GRAPH /////////////////////////////////////////////////// 
		

		$this->data ['open_graph_image'] = theme_img ( 'logo/cn_open_graph_logo_1200x630px.png' );
		
		////////////////////////////////////////////////// OPEN GRAPH /////////////////////////////////////////////////// 
		

		if (! $this->config->item ( 'compact_html' )) {
			$this->load->view ( 'partial_start', $this->data );
			$this->load->view ( 'page', $this->data );
			$this->load->view ( 'partial_boxes', $this->data );
			$this->load->view ( 'partial_end', $this->data );
		} else {
			$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'page', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
		}
	}
	
	function search($code = false, $page = 0) {
		$this->load->model ( 'Search_model' );
		
		//check to see if we have a search term
		if (! $code) {
			//if the term is in post, save it to the db and give me a reference
			$term = $this->input->post ( 'term', true );
			$code = $this->Search_model->record_term ( $term );
			
			// no code? redirect so we can have the code in place for the sorting.
			// I know this isn't the best way...
			redirect ( 'cart/search/' . $code . '/' . $page );
		} else {
			//if we have the md5 string, get the term
			$term = $this->Search_model->get_term ( $code );
		}
		
		if (empty ( $term )) {
			//if there is still no search term throw an error
			//if there is still no search term throw an error
			$this->session->set_flashdata ( 'error', lang ( 'search_error' ) );
			redirect ( 'cart' );
		}
		$this->data ['page_title'] = lang ( 'search' );
		$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		//fix for the category view page.
		$this->data ['base_url'] = array ();
		
		$sort_array = array ('name/asc' => array ('by' => 'name', 'sort' => 'ASC' ), 'name/desc' => array ('by' => 'name', 'sort' => 'DESC' ), 'price/asc' => array ('by' => 'price', 'sort' => 'ASC' ), 'price/desc' => array ('by' => 'price', 'sort' => 'DESC' ) );
		$sort_by = array ('by' => false, 'sort' => false );
		
		if (isset ( $_GET ['by'] )) {
			if (isset ( $sort_array [$_GET ['by']] )) {
				$sort_by = $sort_array [$_GET ['by']];
			}
		}
		
		if (empty ( $term )) {
			//if there is still no search term throw an error
			$this->load->view ( 'search_error', $this->data );
		} else {
			
			$this->data ['page_title'] = lang ( 'search' );
			$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
			
			//set up pagination
			$this->load->library ( 'pagination' );
			$config ['base_url'] = base_url () . 'cart/search/' . $code . '/';
			$config ['uri_segment'] = 4;
			$config ['per_page'] = 20;
			
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
			
			$result = $this->Product_model->search_products ( $term, $config ['per_page'], $page, $sort_by ['by'], $sort_by ['sort'] );
			$config ['total_rows'] = $result ['count'];
			$this->pagination->initialize ( $config );
			
			$this->data ['products'] = $result ['products'];
			foreach ( $this->data ['products'] as &$p ) {
				$p->images = ( array ) json_decode ( $p->images );
				$p->options = $this->Option_model->get_product_options ( $p->id );
			}
			
			if (! $this->config->item ( 'compact_html' )) {
				$this->load->view ( 'partial_start', $this->data );
				$this->load->view ( 'category', $this->data );
				$this->load->view ( 'partial_boxes', $this->data );
				$this->load->view ( 'partial_end', $this->data );
			} else {
				$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'category', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
			}
		}
	}
	
	function category($id) {
		$this->load->model ( array ('box_model' ) );
		
		//get the category
		$this->data ['category'] = $this->Category_model->get_category ( $id );
		
		if (! $this->data ['category']) {
			show_404 ();
		}
		
		//set up pagination
		$segments = $this->uri->total_segments ();
		$base_url = $this->uri->segment_array ();
		
		if ($this->data ['category']->slug == $base_url [count ( $base_url )]) {
			$page = 0;
			$segments ++;
		} else {
			$page = array_splice ( $base_url, - 1, 1 );
			$page = $page [0];
		}
		
		$this->data ['base_url'] = $base_url;
		$base_url = implode ( '/', $base_url );
		
		$this->data ['boxes'] = $this->box_model->get_homepage_boxes ( 8 );
		
		if ($this->data ['category']->name == 'Housses') {
			$this->data ['subcategories'] = $this->Category_model->get_categories ( 1 );
		
		//$this->data['subcategories']			= $this->Category_model->get_categories_for_housses($this->data['category']->id);
		} else {
			$this->data ['subcategories'] = $this->Category_model->get_categories ( $this->data ['category']->id );
		}
		
		$this->data ['product_columns'] = $this->config->item ( 'product_columns' );
		$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$this->data ['excerpt'] = $this->data ['category']->excerpt;
		
		$sort_array = array ('name/asc' => array ('by' => 'products.name', 'sort' => 'ASC' ), 'name/desc' => array ('by' => 'products.name', 'sort' => 'DESC' ), 'price/asc' => array ('by' => 'products.price', 'sort' => 'ASC' ), 'price/desc' => array ('by' => 'products.price', 'sort' => 'DESC' ) );
		
		if ($this->data ['category']->name == 'Couettabra') {
			$sort_by = array ('by' => 'sequence', 'sort' => 'DESC' );
		} else {
			$sort_by = array ('by' => 'sequence', 'sort' => 'ASC' );
		}
		
		if (isset ( $_GET ['by'] )) {
			if (isset ( $sort_array [$_GET ['by']] )) {
				$sort_by = $sort_array [$_GET ['by']];
			}
		}
		
		//set up pagination
		$this->load->library ( 'pagination' );
		$config ['base_url'] = site_url ( $base_url );
		$config ['uri_segment'] = $segments;
		$config ['per_page'] = 24;
		$config ['total_rows'] = $this->Product_model->count_products ( $this->data ['category']->id );
		
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
		
		//grab the products using the pagination lib
		$this->data ['products'] = $this->Product_model->get_products ( $this->data ['category']->id, $config ['per_page'], $page, $sort_by ['by'], $sort_by ['sort'] );
		//print_r_html($this->data['products']);
		foreach ( $this->data ['products'] as &$p ) {
			$p->images = ( array ) json_decode ( $p->images );
			$p->options = $this->Option_model->get_product_options ( $p->id );
		}
		
		if ($this->config->item ( 'category_style_couettabra' ) && $this->data ['category']->name == 'Couettabra') {
			$this->data ['page_title'] = $this->data ['category']->name;
			
			$this->data ['seo_title'] = (! empty ( $this->data ['category']->seo_title )) ? $this->data ['category']->seo_title : $this->data ['category']->name;
			
			//$this->data['meta']				= $this->data['category']->meta;
			$this->data ['meta'] = $this->lang->line ( "cn_description_category_couettabra" );
			
			/*
			if($this->session->userdata('language') == 'english')
			{
				
			}
			else
			{
				
			}
			*/
			
			if ($this->config->item ( 'mobile_user' ) == true) {
				if (! $this->config->item ( 'compact_html' )) {
					$this->load->view ( 'partial_start', $this->data );
					$this->load->view ( 'category', $this->data );
					$this->load->view ( 'partial_boxes', $this->data );
					$this->load->view ( 'partial_end', $this->data );
				} else {
					$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'category', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
				}
			} else {
				if (! $this->config->item ( 'compact_html' )) {
					$this->load->view ( 'partial_start', $this->data );
					$this->load->view ( 'category_style_couettabra', $this->data );
					$this->load->view ( 'partial_boxes', $this->data );
					$this->load->view ( 'partial_end', $this->data );
				} else {
					$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'category_style_couettabra', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
				}
			}
		} elseif ($this->config->item ( 'category_style_couettabra2' ) && $this->data ['category']->name == 'Couettabra') {
			$this->data ['page_title'] = $this->data ['category']->name;
			
			$this->data ['seo_title'] = (! empty ( $this->data ['category']->seo_title )) ? $this->data ['category']->seo_title : $this->data ['category']->name;
			
			//$this->data['meta']				= $this->data['category']->meta;
			$this->data ['meta'] = $this->lang->line ( "cn_description_category_couettabra" );
			
			/*
			if($this->session->userdata('language') == 'english')
			{
				
			}
			else
			{
				
			}
			*/
			
			if ($this->config->item ( 'mobile_user' ) == true) {
				if (! $this->config->item ( 'compact_html' )) {
					$this->load->view ( 'partial_start', $this->data );
					$this->load->view ( 'category_style_couettabra2b', $this->data );
					$this->load->view ( 'partial_boxes', $this->data );
					$this->load->view ( 'partial_end', $this->data );
				} else {
					$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'category_style_couettabra2b', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
				}
			} else {
				if (! $this->config->item ( 'compact_html' )) {
					$this->load->view ( 'partial_start', $this->data );
					$this->load->view ( 'category_style_couettabra2b', $this->data );
					$this->load->view ( 'partial_boxes', $this->data );
					$this->load->view ( 'partial_end', $this->data );
				} else {
					$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'category_style_couettabra2b', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
				}
			}
		} elseif ($this->config->item ( 'category_style_housses' ) && ($this->data ['category']->name == 'Housses' || $this->data ['category']->name == 'Duvet Covers')) {
			$this->data ['page_title'] = $this->data ['category']->name;
			
			$this->data ['seo_title'] = $this->data ['category']->name;
			
			//$this->data['meta']				= $this->data['category']->meta;
			$this->data ['meta'] = $this->lang->line ( "cn_description_category_couettabra_housses" );
			
			/*
			if($this->session->userdata('language') == 'english')
			{
				
			}
			else
			{
				
			}
			*/
			
			if ($this->config->item ( 'mobile_user' ) == true) {
				if (! $this->config->item ( 'compact_html' )) {
					$this->load->view ( 'partial_start', $this->data );
					$this->load->view ( 'category_style_housses', $this->data );
					$this->load->view ( 'partial_boxes', $this->data );
					$this->load->view ( 'partial_end', $this->data );
				} else {
					$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'category_style_housses', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
				}
			} else {
				if (! $this->config->item ( 'compact_html' )) {
					$this->load->view ( 'partial_start', $this->data );
					$this->load->view ( 'category_style_housses', $this->data );
					$this->load->view ( 'partial_boxes', $this->data );
					$this->load->view ( 'partial_end', $this->data );
				} else {
					$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'category_style_housses', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
				}
			}
		} elseif ($this->config->item ( 'category_style_housses' ) && ($this->data ['category']->name != 'Housses' && $this->data ['category']->name != 'Duvet Covers')) {
			
			if ($this->session->userdata ( 'language' ) == 'english') {
				if ($this->data ['base_url'] [1] == 'the-couettabra-range') {
					$this->data ['page_title'] = 'Couettabra<span class="registered-mark">&#174;</span> - ' . ucwords ( $this->data ['category']->name );
					
					$this->data ['seo_title'] = 'Couettabra - ' . ucwords ( $this->data ['category']->name );
				} elseif ($this->data ['base_url'] [1] == 'duvet-covers') {
					$this->data ['page_title'] = 'Couettabra<span class="registered-mark">&#174;</span> ' . ucwords ( preg_replace ( '/"Couettabra"/', '', $this->data ['category']->name ) );
					
					$this->data ['seo_title'] = ucwords ( preg_replace ( '/"/', '', $this->data ['category']->name ) );
				} else {
					$this->data ['page_title'] = $this->data ['category']->name;
					
					$this->data ['seo_title'] = ucwords ( $this->data ['category']->name );
				}
				
				//$this->data['meta']				= $this->data['category']->meta;
				$this->data ['meta'] = $this->lang->line ( "cn_description_category_couettabra_housses" );
			} else {
				if ($this->data ['base_url'] [1] == 'couettabra') {
					$this->data ['page_title'] = ucfirst ( $this->data ['base_url'] [1] ) . '<span class="registered-mark">&#174;</span> - ' . $this->data ['category']->name;
					
					$this->data ['seo_title'] = $this->data ['base_url'] [1] . ' - ' . $this->data ['category']->name;
				} elseif ($this->data ['base_url'] [1] == 'housses') {
					$this->data ['page_title'] = ucfirst ( $this->data ['base_url'] [1] ) . ' ' . $this->data ['category']->name;
					
					$this->data ['seo_title'] = $this->data ['base_url'] [1] . ' ' . $this->data ['category']->name;
				} else {
					$this->data ['page_title'] = $this->data ['category']->name;
					
					$this->data ['seo_title'] = $this->data ['base_url'] [1] . ' ' . $this->data ['category']->name;
				}
				
				//$this->data['meta']				= $this->data['category']->meta;
				$this->data ['meta'] = $this->lang->line ( "cn_description_category_couettabra_housses" );
			}
			
			/*
			if($this->session->userdata('language') == 'english')
			{
				
			}
			else
			{
				
			}
			*/
			
			if ($this->config->item ( 'mobile_user' ) == true) {
				if (! $this->config->item ( 'compact_html' )) {
					$this->load->view ( 'partial_start', $this->data );
					$this->load->view ( 'category_style_housses', $this->data );
					$this->load->view ( 'partial_boxes', $this->data );
					$this->load->view ( 'partial_end', $this->data );
				} else {
					$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'category_style_housses', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
				}
			} else {
				if (! $this->config->item ( 'compact_html' )) {
					$this->load->view ( 'partial_start', $this->data );
					$this->load->view ( 'category_style_housses', $this->data );
					$this->load->view ( 'partial_boxes', $this->data );
					$this->load->view ( 'partial_end', $this->data );
				} else {
					$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'category_style_housses', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
					$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
				}
			}
		} else {
			$this->data ['page_title'] = $this->data ['category']->name;
			
			$this->data ['seo_title'] = (! empty ( $this->data ['category']->seo_title )) ? $this->data ['category']->seo_title : $this->data ['category']->name;
			
			if (! $this->config->item ( 'compact_html' )) {
				$this->load->view ( 'partial_start', $this->data );
				$this->load->view ( 'category', $this->data );
				$this->load->view ( 'partial_boxes', $this->data );
				$this->load->view ( 'partial_end', $this->data );
			} else {
				$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'category_style_couettabra', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
			}
		}
	}
	
	function product($id) {
		$this->load->model ( array ('box_model' ) );
		
		//get the product
		$this->data ['product'] = $this->Product_model->get_product ( $id );
		
		if (! $this->data ['product'] || $this->data ['product']->enabled == 0) {
			show_404 ();
		}
		
		$this->data ['base_url'] = $this->uri->segment_array ();
		
		$this->data ['boxes'] = $this->box_model->get_homepage_boxes ( 8 );
		
		// load the digital language stuff
		$this->lang->load ( 'digital_product' );
		
		///////////////////////////////////////////////// Connected Products /////////////////////////////////////////////////
		

		if (preg_match ( '/(Kit "Couettabra"|Ensemble Duo|Ensemble Solo|Ensemble Actrices|Double "Couettabra"|Single "Couettabra")/', $this->data ['product']->name )) {
			$orig_options_array = objectToArray ( arrayToObject ( $this->Option_model->get_product_options ( $this->data ['product']->id ) ) );
			//print_r_html($orig_options_array);
			$new_options_array = array ();
			
			// This is where we are going to update the native option data with connected products data
			$this->load->model ( array ('Connected_products_model' ) );
			$connected_children = json_decode ( $this->Connected_products_model->get_connected_product_options ( $this->data ['product']->id ), true );
			
			if (! empty ( $connected_children )) {
				$count1 = 0;
				foreach ( $orig_options_array as $option_type ) {
					foreach ( $option_type as $key => $value ) {
						if ((strtoupper ( $option_type ['name'] ) == 'HOUSSE' || strtoupper ( $option_type ['name'] ) == 'DUVET COVER') && $option_type ['type'] == 'radiolist') {
							if ($key == 'values') {
								$count2 = 0;
								$new_value = array ();
								
								foreach ( $value as $value_option ) {
									$replacement_trigger = 'false';
									
									foreach ( $connected_children as $child_product_option ) {
										if (('HOUSSE "' . strtoupper ( $value_option ['name'] ) . '"') === (strtoupper ( $child_product_option ['name'] )) || ('DUVET COVER "' . strtoupper ( $value_option ['name'] ) . '"') === (strtoupper ( $child_product_option ['name'] ))) //if(preg_match('/HOUSSE "'.strtoupper($value_option['name']).'"/', strtoupper($child_product_option['name'])))
										{
											$replacement_trigger = 'true';
											$replacement_weight = $child_product_option ['options'] ['weight'];
											$replacement_quantity = $child_product_option ['options'] ['quantity'];
											$replacement_image = $child_product_option ['options'] ['image'];
											if (isset ( $child_product_option ['options'] ['caption'] )) {
												$replacement_caption = $child_product_option ['options'] ['caption'];
											} else {
												$replacement_caption = null;
											}
											if (isset ( $child_product_option ['options'] ['excerpt'] )) {
												$replacement_excerpt = $child_product_option ['options'] ['excerpt'];
											} else {
												$replacement_excerpt = null;
											}
											if ($replacement_quantity <= 0) {
												$replacement_trigger = 'out_of_stock';
											}
											$replacement_child_connected_product_id = $child_product_option ['child_connected_product_id'];
										
		//print_r_html($replacement_child_connected_product_id);
										//print_r_html('is array : '.is_array($child_product_option['child_connected_product_id']));
										//print_r_html('is object : '.is_object($child_product_option['child_connected_product_id']));
										//print_r_html('is int : '.is_int($child_product_option['child_connected_product_id']));
										

										}
									}
									
									foreach ( $value_option as $key3 => $value3 ) {
										if ($replacement_trigger != 'out_of_stock') {
											if ($replacement_trigger == 'true') {
												if ($key3 == 'weight') {
													unset ( $new_value [$count2] [$key3] );
													$new_value [$count2] [$key3] = $replacement_weight;
												} else {
													$new_value [$count2] [$key3] = $value3;
												}
												
												$new_value [$count2] ['quantity'] = $replacement_quantity;
												$new_value [$count2] ['child_connected_product_id'] = $replacement_child_connected_product_id;
												$new_value [$count2] ['image'] = $replacement_image;
												if ($replacement_caption != null) {
													$new_value [$count2] ['caption'] = $replacement_caption;
												}
												
												if ($replacement_excerpt != null) {
													$new_value [$count2] ['excerpt'] = $replacement_excerpt;
												}
											} else {
												$new_value [$count2] [$key3] = $value3;
											}
										} else {
											$new_value [$count2] = array ();
										}
									}
									$count2 += 1;
								}
								
								$count_eliminate = 0;
								foreach ( $new_value as $new_value_option ) {
									//print_r_html($new_value_option);
									

									if (empty ( $new_value_option )) {
										unset ( $new_value [$count_eliminate] );
									}
									if (empty ( $new_value_option ['quantity'] )) {
										unset ( $new_value [$count_eliminate] );
									}
									
									$count_eliminate += 1;
								}
								$new_value = array_values ( $new_value );
								//print_r_html($new_value);
								

								$new_options_array [$count1] [$key] = $new_value;
							} else {
								$new_options_array [$count1] [$key] = $value;
							}
						} else {
							$new_options_array [$count1] [$key] = $value;
						}
					}
					$count1 += 1;
				}
			}
			
			if (! empty ( $connected_children )) {
				$this->data ['options'] = arrayToObject ( $new_options_array );
			} else {
				$this->data ['options'] = arrayToObject ( $orig_options_array );
			}
		
		//$this->data['options']	= $this->Option_model->get_product_options($this->data['product']->id);
		//print_r_html($this->Option_model->get_product_options($this->data['product']->id));
		

		//print_r_html($this->data['options']);
		} else {
			$this->data ['options'] = $this->Option_model->get_product_options ( $this->data ['product']->id );
		
		//print_r_html($this->data['options']);
		}
		
		///////////////////////////////////////////////// Connected Products /////////////////////////////////////////////////
		

		///////////////////////////////////////////// FACEBOOK WALL POSTS ///////////////////////////////////////////// 
		if ($this->status_fb_auth) {
			if ($this->session->userdata ( 'fb_posted_already' ) != FALSE) {
				if ($this->session->userdata ( 'fb_posted_already' ) != true) {
					$this->_fb_wall_post ();
				}
			}
		
		//$this->_fb_wall_post();
		}
		///////////////////////////////////////////// FACEBOOK WALL POSTS ///////////////////////////////////////////// 
		

		////////////////////////////////////////////////// OPEN GRAPH /////////////////////////////////////////////////// 
		

		$save_path = $this->config->item ( 'og_server_path' ) . 'product/' . $id . '/' . $this->session->userdata ( 'lang_scope' ) . '/';
		
		if (file_exists ( $save_path . 'open_graph_image.png' )) {
			$this->data ['open_graph_image'] = $this->config->item ( 'og_url' ) . 'product/' . $id . '/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.png?' . filemtime ( $this->config->item ( 'og_server_path' ) . 'product/' . $id . '/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.png' );
		} elseif (file_exists ( $save_path . 'open_graph_image.gif' )) {
			$this->data ['open_graph_image'] = $this->config->item ( 'og_url' ) . 'product/' . $id . '/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.gif?' . filemtime ( $this->config->item ( 'og_server_path' ) . 'product/' . $id . '/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.gif' );
		} elseif (file_exists ( $save_path . 'open_graph_image.jpg' )) {
			$this->data ['open_graph_image'] = $this->config->item ( 'og_url' ) . 'product/' . $id . '/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.jpg?' . filemtime ( $this->config->item ( 'og_server_path' ) . 'product/' . $id . '/' . $this->session->userdata ( 'lang_scope' ) . '/' . 'open_graph_image.jpg' );
		} else {
			$this->data ['open_graph_image'] = theme_img ( 'logo/cn_open_graph_1200x1200px_3.png' );
		}
		
		////////////////////////////////////////////////// OPEN GRAPH /////////////////////////////////////////////////// 
		

		$related = $this->data ['product']->related_products;
		$this->data ['related'] = array ();
		
		$this->data ['posted_options'] = $this->session->flashdata ( 'option_values' );
		
		if ($this->data ['product']->images == 'false') {
			$this->data ['product']->images = array ();
		} else {
			$this->data ['product']->images = array_values ( ( array ) json_decode ( $this->data ['product']->images ) );
		}
		
		if ($this->session->userdata ( 'language' ) == 'english') {
			$this->data ['page_title'] = $this->data ['product']->name;
			
			if (preg_match ( '/Duvet Cover/i', $this->data ['product']->name )) {
				if (! empty ( $this->data ['product']->images [0] )) {
					$primary = $this->data ['product']->images [0];
					if (! empty ( $primary->caption )) {
						$housse_meta = lang ( 'cover_color' ) . $primary->caption;
					}
					
					foreach ( $this->data ['product']->images as $photo ) {
						if (isset ( $photo->primary )) {
							if (! empty ( $photo->caption )) {
								$housse_meta = lang ( 'cover_color' ) . $photo->caption;
							}
						}
					}
				}
				
				$this->data ['meta'] = $housse_meta . ((! empty ( $this->data ['product']->excerpt )) ? ' - "' . $this->data ['product']->excerpt . '"' : '');
				
				$this->data ['seo_title'] = (! empty ( $this->data ['product']->seo_title )) ? $this->data ['product']->seo_title : $this->data ['product']->name;
			} else if (preg_match ( '/Couettabra/i', $this->data ['product']->name )) {
				$this->data ['meta'] = preg_replace ( '!\s+!m', ' ', strip_tags ( preg_replace ( '/\<\/p\>/', '. ', preg_replace ( '/\<br(\s)*(\/)*\>/', ' ', $this->data ['product']->description ) ) ) );
				
				if (preg_match ( '/Single "/i', $this->data ['product']->name )) {
					$this->data ['seo_title'] = (! empty ( $this->data ['product']->seo_title )) ? $this->data ['product']->seo_title : $this->data ['product']->name . ' - ' . $this->lang->line ( "cn_description_product_1_place" );
				} else if (preg_match ( '/Double "/i', $this->data ['product']->name )) {
					$this->data ['seo_title'] = (! empty ( $this->data ['product']->seo_title )) ? $this->data ['product']->seo_title : $this->data ['product']->name . ' - ' . $this->lang->line ( "cn_description_product_2_places" );
				}
			} else {
				$this->data ['meta'] = $this->data ['product']->name . $this->lang->line ( "cn_description_product" );
				
				$this->data ['seo_title'] = (! empty ( $this->data ['product']->seo_title )) ? $this->data ['product']->seo_title : $this->data ['product']->name;
			}
		} else {
			$this->data ['page_title'] = $this->data ['product']->name;
			
			//$this->data['meta']				= $this->data['product']->meta;
			

			if (preg_match ( '/Housse/i', $this->data ['product']->name )) {
				if (! empty ( $this->data ['product']->images [0] )) {
					$primary = $this->data ['product']->images [0];
					if (! empty ( $primary->caption )) {
						$housse_meta = lang ( 'cover_color' ) . $primary->caption;
					}
					
					foreach ( $this->data ['product']->images as $photo ) {
						if (isset ( $photo->primary )) {
							if (! empty ( $photo->caption )) {
								$housse_meta = lang ( 'cover_color' ) . $photo->caption;
							}
						}
					}
				}
				
				$this->data ['meta'] = $housse_meta . ((! empty ( $this->data ['product']->excerpt )) ? ' - "' . $this->data ['product']->excerpt . '"' : '');
				
				$this->data ['seo_title'] = (! empty ( $this->data ['product']->seo_title )) ? $this->data ['product']->seo_title : $this->data ['product']->name;
			} else if (preg_match ( '/Couettabra/i', $this->data ['product']->name )) {
				$this->data ['meta'] = preg_replace ( '!\s+!m', ' ', strip_tags ( preg_replace ( '/\<\/p\>/', '. ', preg_replace ( '/\<br(\s)*(\/)*\>/', ' ', $this->data ['product']->description ) ) ) );
				
				if (preg_match ( '/1 Place/i', $this->data ['product']->name )) {
					$this->data ['seo_title'] = (! empty ( $this->data ['product']->seo_title )) ? $this->data ['product']->seo_title : $this->data ['product']->name . ' - ' . $this->lang->line ( "cn_description_product_1_place" );
				} else if (preg_match ( '/2 Places/i', $this->data ['product']->name )) {
					$this->data ['seo_title'] = (! empty ( $this->data ['product']->seo_title )) ? $this->data ['product']->seo_title : $this->data ['product']->name . ' - ' . $this->lang->line ( "cn_description_product_2_places" );
				}
			} else {
				$this->data ['meta'] = $this->data ['product']->name . $this->lang->line ( "cn_description_product" );
				
				$this->data ['seo_title'] = (! empty ( $this->data ['product']->seo_title )) ? $this->data ['product']->seo_title : $this->data ['product']->name;
			}
		}
		
		$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		if (! $this->config->item ( 'compact_html' )) {
			$this->load->view ( 'partial_start', $this->data );
			$this->load->view ( 'product', $this->data );
			$this->load->view ( 'partial_boxes', $this->data );
			$this->load->view ( 'partial_end', $this->data );
		} else {
			$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'product', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
		}
	}
	
	function add_to_cart() {
		/*
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('option[child_connected_product_id]', 'Child Connected Product ID', 'trim|numeric|required');
		$this->form_validation->set_rules('option[stock_quantity]', 'Child Connected Product Quantity', 'trim|numeric|required');
		*/
		
		// Get our inputs
		$product_id = $this->input->post ( 'id' );
		$quantity = $this->input->post ( 'quantity' );
		$post_options = $this->input->post ( 'option' );
		
		/*
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', 'whoopsie');
			redirect($this->Product_model->get_slug($product_id));
		}
		else
		{
			//print_r_html($post_options);
			//print_r_html($post_options['child_connected_product_id']);
		}
		*/
		
		// Get a cart-ready product array
		$product = $this->Product_model->get_cart_ready_product ( $product_id, $quantity );
		
		/* Edit for error - special chars in caption causing products not to add to cart -  we clear the field entirely */
		$these_images = array ();
		foreach ( $product as $key => &$val ) {
			if ($key == 'images') {
				$images = objectToArray ( json_decode ( $val ) );
				
				foreach ( $images as $key2 => &$val2 ) {
					foreach ( $val2 as $key3 => &$val3 ) {
						if ($key3 == "caption") {
							$val2 ['caption'] = "";
						}
					}
					$these_images [$key2] = $val2;
				}
				
				$images = json_encode ( $these_images );
			
		//var_dump($images);
			}
		}
		
		$product ['images'] = $images;
		//var_dump($product);
		//exit;
		

		//if out of stock purchase is disabled, check to make sure there is inventory to support the cart.
		if (! $this->config->item ( 'allow_os_purchase' ) && ( bool ) $product ['track_stock']) {
			$stock = $this->Product_model->get_product ( $product_id );
			
			//loop through the products in the cart and make sure we don't have this in there already. If we do get those quantities as well
			$items = $this->go_cart->contents ();
			$qty_count = $quantity;
			foreach ( $items as $item ) {
				if (intval ( $item ['id'] ) == intval ( $product_id )) {
					$qty_count = $qty_count + $item ['quantity'];
				}
			}
			
			if ($stock->quantity < $qty_count) {
				//we don't have this much in stock
				$this->session->set_flashdata ( 'error', sprintf ( lang ( 'not_enough_stock' ), $stock->name, $stock->quantity ) );
				$this->session->set_flashdata ( 'quantity', $quantity );
				$this->session->set_flashdata ( 'option_values', $post_options );
				
				redirect ( $this->Product_model->get_slug ( $product_id ) );
			}
		}
		
		// Validate Options 
		// this returns a status array, with product item array automatically modified and options added
		//  Warning: this method receives the product by reference
		$status = $this->Option_model->validate_product_options ( $product, $post_options );
		
		// don't add the product if we are missing required option values
		if (! $status ['validated']) {
			$this->session->set_flashdata ( 'quantity', $quantity );
			$this->session->set_flashdata ( 'error', $status ['message'] );
			$this->session->set_flashdata ( 'option_values', $post_options );
			
			redirect ( $this->Product_model->get_slug ( $product_id ) );
		
		} else {
			
			//Add the original option vars to the array so we can edit it later
			$product ['post_options'] = $post_options;
			
			//is giftcard
			$product ['is_gc'] = false;
			
			// Add the product item to the cart, also updates coupon discounts automatically
			$this->go_cart->insert ( $product );
			
			// go go gadget cart!
			redirect ( 'cart/view_cart' );
		}
	}
	
	function view_cart() {
		$this->go_cart->set_display_tax_vat ( false );
		
		$this->load->model ( array ('box_model' ) );
		$this->data ['boxes'] = $this->box_model->get_homepage_boxes ( 8 );
		
		$this->data ['page_title'] = 'View Cart';
		$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
		$this->data ['meta'] = $this->lang->line ( "cn_description_view_cart" );
		
		if (! $this->config->item ( 'compact_html' )) {
			$this->load->view ( 'partial_start', $this->data );
			$this->load->view ( 'view_cart', $this->data );
			$this->load->view ( 'partial_boxes', $this->data );
			$this->load->view ( 'partial_end', $this->data );
		} else {
			$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'view_cart', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
			$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
		}
	}
	
	function remove_item($key) {
		//drop quantity to 0
		$this->go_cart->update_cart ( array ($key => 0 ) );
		
		redirect ( 'cart/view_cart' );
	}
	
	function update_cart($redirect = false) {
		//if redirect isn't provided in the URL check for it in a form field
		if (! $redirect) {
			$redirect = $this->input->post ( 'redirect' );
		}
		
		// see if we have an update for the cart
		$item_keys = $this->input->post ( 'cartkey' );
		$coupon_code = $this->input->post ( 'coupon_code' );
		$gc_code = $this->input->post ( 'gc_code' );
		
		//get the items in the cart and test their quantities
		$items = $this->go_cart->contents ();
		$new_key_list = array ();
		//first find out if we're deleting any products
		foreach ( $item_keys as $key => $quantity ) {
			if (intval ( $quantity ) === 0) {
				//this item is being removed we can remove it before processing quantities.
				//this will ensure that any items out of order will not throw errors based on the incorrect values of another item in the cart
				$this->go_cart->update_cart ( array ($key => $quantity ) );
			} else {
				//create a new list of relevant items
				$new_key_list [$key] = $quantity;
			}
		}
		$response = array ();
		foreach ( $new_key_list as $key => $quantity ) {
			$product = $this->go_cart->item ( $key );
			//if out of stock purchase is disabled, check to make sure there is inventory to support the cart.
			if (! $this->config->item ( 'allow_os_purchase' ) && ( bool ) $product ['track_stock']) {
				$stock = $this->Product_model->get_product ( $product ['id'] );
				
				//loop through the new quantities and tabluate any products with the same product id
				$qty_count = $quantity;
				foreach ( $new_key_list as $item_key => $item_quantity ) {
					if ($key != $item_key) {
						$item = $this->go_cart->item ( $item_key );
						//look for other instances of the same product (this can occur if they have different options) and tabulate the total quantity
						if ($item ['id'] == $stock->id) {
							$qty_count = $qty_count + $item_quantity;
						}
					}
				}
				if ($stock->quantity < $qty_count) {
					if (isset ( $response ['error'] )) {
						$response ['error'] .= '<p>' . sprintf ( lang ( 'not_enough_stock' ), $stock->name, $stock->quantity ) . '</p>';
					} else {
						$response ['error'] = '<p>' . sprintf ( lang ( 'not_enough_stock' ), $stock->name, $stock->quantity ) . '</p>';
					}
				} else {
					//this one works, we can update it!
					//don't update the coupons yet
					$this->go_cart->update_cart ( array ($key => $quantity ) );
				}
			} else {
				$this->go_cart->update_cart ( array ($key => $quantity ) );
			}
		}
		
		//if we don't have a quantity error, run the update
		if (! isset ( $response ['error'] )) {
			//update the coupons and gift card code
			$response = $this->go_cart->update_cart ( false, $coupon_code, $gc_code );
		
		// set any messages that need to be displayed
		} else {
			$response ['error'] = '<p>' . lang ( 'error_updating_cart' ) . '</p>' . $response ['error'];
		}
		
		//check for errors again, there could have been a new error from the update cart function
		if (isset ( $response ['error'] )) {
			$this->session->set_flashdata ( 'error', $response ['error'] );
		}
		if (isset ( $response ['message'] )) {
			$this->session->set_flashdata ( 'message', $response ['message'] );
		}
		
		if ($redirect) {
			redirect ( $redirect );
		} else {
			redirect ( 'cart/view_cart' );
		}
	}
	
	/***********************************************************
			Gift Cards
			 - this function handles adding gift cards to the cart
	 ***********************************************************/
	
	function giftcard() {
		if (! $this->gift_cards_enabled)
			redirect ( '/' );
		
		// Load giftcard settings
		$gc_settings = $this->Settings_model->get_settings ( "gift_cards" );
		
		$this->load->library ( 'form_validation' );
		
		$this->data ['allow_custom_amount'] = ( bool ) $gc_settings ['allow_custom_amount'];
		$this->data ['preset_values'] = explode ( ",", $gc_settings ['predefined_card_amounts'] );
		
		if ($this->data ['allow_custom_amount']) {
			$this->form_validation->set_rules ( 'custom_amount', 'lang:custom_amount', 'numeric|callback_giftcard_custom_amount_check' );
		}
		
		$this->form_validation->set_rules ( 'amount', 'lang:amount', 'required' );
		$this->form_validation->set_rules ( 'preset_amount', 'lang:preset_amount', 'numeric|callback_giftcard_preset_amount_check' );
		$this->form_validation->set_rules ( 'gc_to_name', 'lang:recipient_name', 'trim|required' );
		$this->form_validation->set_rules ( 'gc_to_email', 'lang:recipient_email', 'trim|required|valid_email' );
		$this->form_validation->set_rules ( 'gc_from', 'lang:sender_email', 'trim|required' );
		$this->form_validation->set_rules ( 'message', 'lang:custom_greeting', 'trim|required' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->load->model ( array ('box_model' ) );
			$this->data ['boxes'] = $this->box_model->get_homepage_boxes ( 8 );
			
			$this->data ['error'] = validation_errors ();
			$this->data ['seo_title'] = lang ( 'giftcard' );
			$this->data ['page_title'] = lang ( 'giftcard' );
			$this->data ['gift_cards_enabled'] = $this->gift_cards_enabled;
			
			$this->data ['meta'] = $this->lang->line ( "cn_description_giftcard" );
			
			if (! $this->config->item ( 'compact_html' )) {
				$this->load->view ( 'partial_start', $this->data );
				$this->load->view ( 'giftcards', $this->data );
				$this->load->view ( 'partial_boxes', $this->data );
				$this->load->view ( 'partial_end', $this->data );
			} else {
				$this->compact_view ( $this->view ( 'partial_start', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'giftcards', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'partial_boxes', $this->data, TRUE ) );
				$this->compact_view ( $this->view ( 'partial_end', $this->data, TRUE ) );
			}
		} else {
			// add to cart
			$card ['price'] = set_value ( set_value ( 'amount' ) );
			
			$card ['id'] = - 1; // just a placeholder
			$card ['sku'] = lang ( 'giftcard' );
			$card ['base_price'] = $card ['price']; // price gets modified by options, show the baseline still...
			$card ['name'] = lang ( 'giftcard' );
			$card ['code'] = generate_code (); // from the string helper
			$card ['excerpt'] = sprintf ( lang ( 'giftcard_excerpt' ), set_value ( 'gc_to_name' ) );
			$card ['weight'] = 0;
			$card ['quantity'] = 1;
			$card ['shippable'] = false;
			$card ['taxable'] = 0;
			$card ['fixed_quantity'] = true;
			$card ['is_gc'] = true; // !Important
			$card ['track_stock'] = false; // !Imporortant
			

			$card ['gc_info'] = array ("to_name" => set_value ( 'gc_to_name' ), "to_email" => set_value ( 'gc_to_email' ), "from" => set_value ( 'gc_from' ), "personal_message" => set_value ( 'message' ) );
			
			// add the card data like a product
			$this->go_cart->insert ( $card );
			
			redirect ( 'cart/view_cart' );
		}
	}
	
	function giftcard_preset_amount_check($amount) {
		return $amount / ( float ) $this->session->userdata ( 'currency_rate' );
	}
	
	function giftcard_custom_amount_check($amount) {
		if ($this->input->post ( 'amount' ) == 'custom_amount') {
			if ($amount != '' && floatval ( $amount ) > 0) {
				return $amount / ( float ) $this->session->userdata ( 'currency_rate' );
			} else {
				$this->form_validation->set_message ( 'giftcard_custom_amount_check', lang ( 'giftcard_amount_is_zero_error' ) );
				return FALSE;
			}
		} else {
			return TRUE;
		}
	}
	
	function _fb_wall_post() {
		if ($this->fb_user_id != null) {
			if (isset ( $data ['product']->images )) {
				$open_graph_image = $this->config->item ( 'upload_url' ) . 'images/medium/' . $data ['product']->images [0]->filename;
			} else {
				$open_graph_image = "https://www.clairetnathalie.com/content/default/assets/img/logo/cn_logo-header_212x45px.png";
			}
			
			if ($this->config->item ( 'language' ) == 'french') {
				/*
	        	if(isset($data['product']->description))
			    {
			    	$descrt = $data['product']->description;
			    }
			    else
			    {
			    	$descrt = "Couettabra - Un nouveau concept confort composé d’une couette et de sa housse à manches longues.";
			    }
			    */
				
				$descrt = $this->lang->line ( "mgm_description" );
				
				/*
			    if (isset($data['seo_title']))
			    {
			    	$name = $data['seo_title'];
			    }
	        	else
			    {
			    	$name = preg_replace('/\//', '' , preg_replace_skip('/(\/|-)/', ' ' , uri_string(), 1));
			    }
			    */
				
				$name = preg_replace ( '/(\/|-)/', ' ', uri_string (), 1 );
				//$name = preg_replace('/\//', '' , preg_replace_skip('/(\/|-)/', ' ' , uri_string(), 1));
				

				$encode_array [] = array ('method' => 'POST', 'relative_url' => "/" . $this->fb_user_id . "/feed", 'body' => http_build_query ( array ('message' => "Voici l'un des produits que je viens de consulter sur " . $this->config->item ( 'company_name' ), 'link' => current_url (), 'picture' => $open_graph_image, 'name' => $name, 'description' => $descrt ) ) );
				
				for($i = 0; $i < count ( $this->fb_page_IDs ); $i += 1) {
					$encode_array [] = array ('method' => 'POST', 'relative_url' => "/" . $this->fb_page_IDs [$i] . "/feed?access_token=" . $this->fb_access_token, 'body' => http_build_query ( array ('message' => $this->fb_user_name . " vient de consulter " . $this->config->item ( 'company_name' ), 'link' => current_url (), 'picture' => $open_graph_image, 'name' => $name, 'description' => $descrt ) ) );
				}
				
				$batched_request = json_encode ( $encode_array );
				$graph_url_publish = "/?batch=" . urlencode ( $batched_request ) . "&access_token=" . $this->fb_access_token . "&method=post";
				$this->Social_model_fb->record_wall_post ( "https://graph.facebook.com/" . $graph_url_publish, $this->fb_user_id, $name );
			} else {
				/*
	        	if(isset($data['product']->description))
			    {
			    	$descrt = $data['product']->description;
			    }
			    else
			    {
			    	$descrt = $this->lang->line("mgm_description");
			    }
			    */
				
				$descrt = $this->lang->line ( "mgm_description" );
				
				/*
			    if (isset($data['seo_title']))
			    {
			    	$name = $data['seo_title'];
			    }
	        	else
			    {
			    	$name = preg_replace('/\//', '' , preg_replace_skip('/(\/|-)/', ' ' , uri_string(), 1));
			    }
			    */
				
				$name = preg_replace ( '/(\/|-)/', ' ', uri_string (), 1 );
				//$name = preg_replace('/\//', '' , preg_replace_skip('/(\/|-)/', ' ' , uri_string(), 1));
				

				$encode_array [] = array ('method' => 'POST', 'relative_url' => "/" . $this->fb_user_id . "/feed", 'body' => http_build_query ( array ('message' => "Check out this item I saw on " . $this->config->item ( 'company_name' ), 'link' => current_url (), 'picture' => $open_graph_image, 'name' => $name, 'description' => $descrt ) ) );
				
				for($i = 0; $i < count ( $this->fb_page_IDs ); $i += 1) {
					$encode_array [] = array ('method' => 'POST', 'relative_url' => "/" . $this->fb_page_IDs [$i] . "/feed?access_token=" . $this->fb_access_token, 'body' => http_build_query ( array ('message' => $this->fb_user_name . " has just checked out " . $this->config->item ( 'company_name' ), 'link' => current_url (), 'picture' => $open_graph_image, 'name' => $name, 'description' => $descrt ) ) );
				}
				
				$batched_request = json_encode ( $encode_array );
				$graph_url_publish = "/?batch=" . urlencode ( $batched_request ) . "&access_token=" . $this->fb_access_token . "&method=post";
				$this->Social_model_fb->record_wall_post ( "https://graph.facebook.com/" . $graph_url_publish, $this->fb_user_id, $name );
			}
			
			if ($this->session->userdata ( 'fb_posted_already' ) == FALSE) {
				$this->session->set_userdata ( 'fb_posted_already', true );
			}
		}
	}
}