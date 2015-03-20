<?php

class Orders extends Admin_Controller {
	
	function __construct() {
		parent::__construct ();
		
		remove_ssl ();
		$this->load->model ( 'Order_model' );
		$this->load->model ( 'Search_model' );
		$this->load->model ( 'location_model' );
		$this->load->model ( 'Currency_model' );
		$this->load->helper ( array ('formatting' ) );
		$this->lang->load ( 'order' );
		
		define ( 'TRANSLATABLE', false );
	}
	
	function index($sort_by = 'ordered_on', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
		
		//if they submitted an export form do the export
		if ($this->input->post ( 'submit' ) == 'export') {
			$this->load->model ( 'customer_model' );
			$this->load->helper ( 'download_helper' );
			$post = $this->input->post ( null, false );
			$term = ( object ) $post;
			
			$this->data ['orders'] = $this->Order_model->get_orders ( $term );
			
			foreach ( $this->data ['orders'] as &$o ) {
				$o->items = $this->Order_model->get_items ( $o->id );
			}
			
			force_download_content ( 'orders.xml', $this->load->view ( $this->config->item ( 'admin_folder' ) . '/orders_xml', $this->data, true ) );
			
			//kill the script from here
			die ();
		}
		
		$this->load->helper ( 'form' );
		$this->load->helper ( 'date' );
		$this->data ['message'] = $this->session->flashdata ( 'message' );
		$this->data ['page_title'] = lang ( 'orders' );
		$this->data ['code'] = $code;
		$term = false;
		
		$post = $this->input->post ( null, false );
		if ($post) {
			//if the term is in post, save it to the db and give me a reference
			$term = json_encode ( $post );
			$code = $this->Search_model->record_term ( $term );
			$this->data ['code'] = $code;
			//reset the term to an object for use
			$term = ( object ) $post;
		} elseif ($code) {
			$term = $this->Search_model->get_term ( $code );
			$term = json_decode ( $term );
		}
		
		$this->data ['term'] = $term;
		$this->data ['orders'] = $this->Order_model->get_orders ( $term, $sort_by, $sort_order, $rows, $page );
		$this->data ['total'] = $this->Order_model->get_orders_count ( $term );
		
		$this->load->library ( 'pagination' );
		
		$config ['base_url'] = site_url ( $this->config->item ( 'admin_folder' ) . '/orders/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/' );
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
		
		$this->data ['sort_by'] = $sort_by;
		$this->data ['sort_order'] = $sort_order;
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/orders', $this->data );
	}
	
	function export() {
		$this->load->model ( 'customer_model' );
		$this->load->helper ( 'download_helper' );
		$post = $this->input->post ( null, false );
		$term = ( object ) $post;
		
		$this->data ['orders'] = $this->Order_model->get_orders ( $term );
		
		foreach ( $this->data ['orders'] as &$o ) {
			$o->items = $this->Order_model->get_items ( $o->id );
		}
		
		force_download_content ( 'orders.xml', $this->load->view ( $this->config->item ( 'admin_folder' ) . '/orders_xml', $this->data, true ) );
	
	}
	
	function view($id) {
		$this->load->helper ( array ('form', 'date' ) );
		$this->load->library ( 'form_validation' );
		$this->load->model ( 'Gift_card_model' );
		
		$this->form_validation->set_rules ( 'notes', 'lang:notes' );
		$this->form_validation->set_rules ( 'status', 'lang:status', 'required' );
		
		$message = $this->session->flashdata ( 'message' );
		
		if ($this->form_validation->run () == TRUE) {
			$save = array ();
			$save ['id'] = $id;
			$save ['notes'] = $this->input->post ( 'notes' );
			$save ['status'] = $this->input->post ( 'status' );
			
			$this->data ['message'] = lang ( 'message_order_updated' );
			
			$this->Order_model->save_order ( $save );
		}
		//get the order information, this way if something was posted before the new one gets queried here
		$this->data ['page_title'] = lang ( 'view_order' );
		$this->data ['order'] = $this->Order_model->get_order ( $id );
		
		/*****************************
		 * Order Notification details *
		 ******************************/
		// get the list of canned messages (order)
		$this->load->model ( 'Messages_model' );
		$msg_templates = $this->Messages_model->get_list ( 'order' );
		
		// replace template variables
		foreach ( $msg_templates as $msg ) {
			// fix html
			$msg ['content'] = str_replace ( "\n", '', html_entity_decode ( $msg ['content'] ) );
			
			// {order_number}
			$msg ['subject'] = str_replace ( '{order_number}', $this->data ['order']->order_number, $msg ['subject'] );
			$msg ['content'] = str_replace ( '{order_number}', $this->data ['order']->order_number, $msg ['content'] );
			
			// {url}
			$msg ['subject'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $msg ['subject'] );
			$msg ['content'] = str_replace ( '{url}', $this->config->item ( 'base_url' ), $msg ['content'] );
			
			// {site_name}
			$msg ['subject'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $msg ['subject'] );
			$msg ['content'] = str_replace ( '{site_name}', $this->config->item ( 'company_name' ), $msg ['content'] );
			
			$this->data ['msg_templates'] [] = $msg;
		}
		
		// we need to see if any items are gift cards, so we can generate an activation link
		foreach ( $this->data ['order']->contents as $orderkey => $product ) {
			if (isset ( $product ['is_gc'] ) && ( bool ) $product ['is_gc']) {
				if ($this->Gift_card_model->is_active ( $product ['sku'] )) {
					$this->data ['order']->contents [$orderkey] ['gc_status'] = '[ ' . lang ( 'giftcard_is_active' ) . ' ]';
				} else {
					$this->data ['order']->contents [$orderkey] ['gc_status'] = ' [ <a href="' . base_url () . $this->config->item ( 'admin_folder' ) . '/giftcards/activate/' . $product ['code'] . '">' . lang ( 'activate' ) . '</a> ]';
				}
			}
		}
		
		if (preg_match ( '/MONDIAL RELAY/i', $this->data ['order']->shipping_method )) {
			$this->data ['mondiale_relay_create_shipment_btn'] = true;
			
			$this->data ['mode_de_collecte'] = array (

			'REL' => 'Collecte en Point Relais', 'CCC' => 'Collecte chez le client chargeur / l\'enseigne', 'CDR' => 'Collecte à domicile pour les expéditions standards', 'CDS' => 'Collecte à domicile pour les expéditions lourdes ou volumineuses' );
			
			$this->data ['mode_de_livraison'] = array ('LCC' => 'Livraison chez le client chargeur / l\'enseigne', 'LD1' => 'Livraison à domicile pour les expéditions standards', 'LDS' => 'Livraison à domicile pour les expéditions lourdes ou volumineuses', '24R' => 'Livraison en Point Relais standard', '24L' => 'Livraison en Point Relais XL', '24X' => 'Livraison en Point Relais XXL', 'DRI' => 'Livraison en Colis Drive' );
			
			$this->data ['civilite'] = array ('M' => 'M.', 'MME' => 'Mme', 'MLLE' => 'Mlle' );
			
			$this->data ['taille'] = array ('XS' => 'Très petit', 'S' => 'Petit', 'M' => 'Moyen', 'L' => 'Large', 'XL' => 'Très large', 'XXL' => 'Très très large', '3XL' => 'Enorme' );
		
		} else {
			$this->data ['mondiale_relay_create_shipment_btn'] = false;
		}
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/order', $this->data );
	
	}
	
	function packing_slip($order_id) {
		$this->load->helper ( 'date' );
		$this->data ['order'] = $this->Order_model->get_order ( $order_id );
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/packing_slip.php', $this->data );
	}
	
	function facture($order_id) {
		$this->load->helper ( 'date' );
		$this->data ['order'] = $this->Order_model->get_order ( $order_id );
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/facture_slip.php', $this->data );
	}
	
	function edit_status() {
		$this->auth->is_logged_in ();
		$order ['id'] = $this->input->post ( 'id' );
		$order ['status'] = $this->input->post ( 'status' );
		
		$this->Order_model->save_order ( $order );
		
		echo url_title ( $order ['status'] );
	}
	
	function send_notification($order_id = '') {
		// send the message
		$this->load->library ( 'email' );
		
		$config ['mailtype'] = 'html';
		
		$this->email->initialize ( $config );
		
		$this->email->from ( $this->config->item ( 'email' ), $this->config->item ( 'company_name' ) );
		$this->email->to ( $this->input->post ( 'recipient' ) );
		
		$this->email->subject ( $this->input->post ( 'subject' ) );
		$this->email->message ( html_entity_decode ( $this->input->post ( 'content' ) ) );
		
		$this->email->send ();
		
		$this->session->set_flashdata ( 'message', lang ( 'sent_notification_message' ) );
		redirect ( $this->config->item ( 'admin_folder' ) . '/orders/view/' . $order_id );
	}
	
	function bulk_delete() {
		$orders = $this->input->post ( 'order' );
		
		if ($orders) {
			foreach ( $orders as $order ) {
				$this->Order_model->delete ( $order );
			}
			$this->session->set_flashdata ( 'message', lang ( 'message_orders_deleted' ) );
		} else {
			$this->session->set_flashdata ( 'error', lang ( 'error_no_orders_selected' ) );
		}
		//redirect as to change the url
		redirect ( $this->config->item ( 'admin_folder' ) . '/orders' );
	}
	
	function create_shipment_mondiale_relay($order_id) {
		if (! $this->config->item ( 'redirect_only_to_mondial_relay_interface_for_create_shipment' )) {
			$this->load->library ( 'form_validation' );
			
			$this->form_validation->set_rules ( 'order_id', 'lang:order_id', 'trim|required|numeric' );
			$this->form_validation->set_rules ( 'NDossier', 'lang:numero_commande', 'trim|required|numeric|max_length[15]' );
			$this->form_validation->set_rules ( 'LIV_Rel', 'lang:parcel_shop_id', 'trim|required|numeric|max_length[6]' );
			$this->form_validation->set_rules ( 'LIV_Rel_Pays', 'lang:parcel_shop_country_code', 'trim|required|alpha|max_length[2]' );
			$this->form_validation->set_rules ( 'Dest_Ad2', 'lang:dest_addr2', 'trim|max_length[32]' );
			$this->form_validation->set_rules ( 'Dest_Ad3', 'lang:dest_addr3', 'trim|required|min_length[2]|max_length[32]' );
			$this->form_validation->set_rules ( 'Dest_Ad4', 'lang:dest_addr4', 'trim|max_length[32]' );
			$this->form_validation->set_rules ( 'Dest_Ville', 'lang:dest_city', 'trim|required|alpha_dash|max_length[26]' );
			$this->form_validation->set_rules ( 'Dest_CP', 'lang:dest_post_code', 'trim|required|alpha_dash' );
			$this->form_validation->set_rules ( 'Dest_Pays', 'lang:dest_country', 'trim|required|alpha|max_length[2]' );
			$this->form_validation->set_rules ( 'Dest_Tel1', 'lang:dest_tel', 'trim|required|max_length[13]' );
			$this->form_validation->set_rules ( 'Dest_Mail', 'lang:dest_email', 'trim|valid_email' );
			$this->form_validation->set_rules ( 'mode_de_collecte', 'lang:collection_mode', 'trim|required|alpha_numeric|max_length[3]' );
			$this->form_validation->set_rules ( 'mode_de_livraison', 'lang:delivery_mode', 'trim|required|alpha_numeric|max_length[3]' );
			$this->form_validation->set_rules ( 'taille', 'lang:size', 'trim|alpha_numeric|max_length[3]' );
			$this->form_validation->set_rules ( 'dimension', 'lang:dimension', 'trim|numeric|max_length[3]' );
			$this->form_validation->set_rules ( 'dest_civilite', 'lang:civil_status', 'trim|required|alpha|max_length[4]' );
			$this->form_validation->set_rules ( 'dest_firstname', 'lang:firstname_addressee', 'trim|required|alpha|max_length[13]' );
			$this->form_validation->set_rules ( 'dest_lastname', 'lang:lastname_addressee', 'trim|required|alpha|max_length[13]' );
			$this->form_validation->set_rules ( 'poids', 'lang:shipment_weight', 'trim|required|numeric|decimal[3]' );
			$this->form_validation->set_rules ( 'NbColis', 'lang:number_of_parcels', 'trim|required|numeric|is_natural_no_zero' );
			$this->form_validation->set_rules ( 'CRT_Valeur', 'lang:cash_on_delivery', 'trim|required|numeric|decimal[2]' );
			$this->form_validation->set_rules ( 'Exp_Valeur', 'lang:value', 'trim|numeric|decimal[2]' );
			
			if ($this->form_validation->run () == false) {
				$this->session->set_flashdata ( 'error', validation_errors () );
				redirect ( $this->config->item ( 'admin_folder' ) . '/orders/view/' . $order_id );
			} else {
				$this->load->add_package_path ( APPPATH . 'packages/shipping/mondial_relay_points_relais/' );
				$this->load->library ( 'mondial_relay_points_relais' );
				
				$ShipmentDetails = array ('CollectMode' => ( object ) array ('Mode' => 'CCC', //Obligatoire
//'Mode' 							=> $this->input->post('mode_de_collecte'),											//Obligatoire
				'ParcelShopContryCode' => 'FR', //'ParcelShopId' 				=> '068985'    		//STATION TOTAL - 19 ROUTE DE MAYENNE - LAVAL, 53000 FR
				'ParcelShopId' => '004006' )//MGM SAS - 6 RUE LEONARD DE VINCI - LAVAL, 53000 FR
, 'DeliveryMode' => ( object ) array ('Mode' => '24R', //Obligatoire
//'Mode' 							=> $this->input->post('mode_de_livraison'),											//Obligatoire
				'ParcelShopContryCode' => $this->input->post ( 'LIV_Rel_Pays' ), 'ParcelShopId' => $this->input->post ( 'LIV_Rel' ) ), 'InternalOrderReference' => $this->input->post ( 'NDossier' ), //Faculcative
'InternalCustomerReference' => $this->input->post ( 'order_id' ), //Faculcative
'Sender' => ( object ) array ('Language' => 'FR', //Obligatoire
'Adress1' => strtoupper ( 'Mme Gueneau Claire' ), //Obligatoire
'Adress2' => strtoupper ( 'Maison Gueneau Mauger SAS' ), //Faculcative
'Adress3' => strtoupper ( '6 rue Leonard de Vinci' ), //Obligatoire
'Adress4' => strtoupper ( 'CS 20119' ), //Faculcative
'City' => strtoupper ( 'Laval Cedex' ), //Obligatoire
'PostCode' => '53001', //Obligatoire
'CountryCode' => 'FR', //Obligatoire
'PhoneNumber' => '0243497500', //Obligatoire
'PhoneNumber2' => '0681832166', //Faculcative
'Email' => strtoupper ( 'maisongueneaumauger@gmail.com' ) )//Faculcative
, 'Recipient' => ( object ) array ('Language' => $this->input->post ( 'Dest_Pays' ), //Obligatoire
'Adress1' => mb_strtoupper ( $this->replaceAccents ( $this->input->post ( 'dest_civilite' ) . ' ' . $this->input->post ( 'dest_lastname' ) . ' ' . $this->input->post ( 'dest_firstname' ) ), 'UTF-8' ), //Obligatoire
'Adress2' => mb_strtoupper ( $this->replaceAccents ( $this->input->post ( 'Dest_Ad2' ) ), 'UTF-8' ), //Faculcative
'Adress3' => mb_strtoupper ( $this->replaceAccents ( $this->input->post ( 'Dest_Ad3' ) ), 'UTF-8' ), //Obligatoire
'Adress4' => mb_strtoupper ( $this->replaceAccents ( $this->input->post ( 'Dest_Ad4' ) ), 'UTF-8' ), //Faculcative
'City' => mb_strtoupper ( $this->replaceAccents ( $this->input->post ( 'Dest_Ville' ) ), 'UTF-8' ), //Obligatoire
'PostCode' => $this->input->post ( 'Dest_CP' ), //Obligatoire
'CountryCode' => $this->input->post ( 'Dest_Pays' ), //Obligatoire
'PhoneNumber' => $this->input->post ( 'Dest_Tel1' ), //Obligatoire
'PhoneNumber2' => '', //Faculcative
'Email' => mb_strtoupper ( $this->replaceAccents ( $this->input->post ( 'Dest_Mail' ) ), 'UTF-8' ) )//Faculcative
, 'ShipmentWeight' => number_format ( ( float ) $this->input->post ( 'poids' ) * 1000, 0, '.', '' ), 'ShipmentHeight' => $this->input->post ( 'dimension' ), 'ShipmentPresetSize' => $this->input->post ( 'taille' ), 'NumberOfParcel' => $this->input->post ( 'NbColis' ), 'CostOnDelivery' => number_format ( ( float ) $this->input->post ( 'CRT_Valeur' ) * 100, 0, '.', '' ), 'CostOnDeliveryCurrency' => 'EUR', 'Value' => number_format ( ( float ) $this->input->post ( 'Exp_Valeur' ) * 100, 0, '.', '' ), 'ValueCurrency' => 'EUR', 'InsuranceLevel' => 0, 'DeliveryInstruction' => '', 'CommentOnLabel' => '' );
				
				$response = $this->mondial_relay_points_relais->mondial_relay_create_shipment ( ( object ) $ShipmentDetails, $order_id );
				
				if ($response) {
					//$this->session->set_flashdata('message', lang('shipment_created'));
					//redirect($this->config->item('admin_folder').'/orders/view/'.$order_id);
					

					/*
					$this->load->helper('download');
					$data = file_get_contents('http://www.mondialrelay.com'.$response['etiquette']['WSI2_CreationEtiquetteResult']['URL_Etiquette']); 	// Read the file's contents
					$name = 'etiquette_'.$response['etiquette']['WSI2_CreationEtiquetteResult']['ExpeditionNum'].'.pdf';
					force_download($name, $data);
					*/
					
					$save = array ();
					$save ['id'] = $response ['order_id'];
					$save ['notes'] = 'Numéro d\'expédition Mondial Relay #' . $response ['etiquette'] ['WSI2_CreationEtiquetteResult'] ['ExpeditionNum'] . "\n\r" . 'URL de tracking Mondial Relay';
					$save ['status'] = 'Processing';
					
					$this->Order_model->save_order ( $save );
					
					redirect ( 'http://www.mondialrelay.com' . $response ['etiquette'] ['WSI2_CreationEtiquetteResult'] ['URL_Etiquette'] );
				} else {
					$this->session->set_flashdata ( 'error', 'Whoopsies!!' );
					redirect ( $this->config->item ( 'admin_folder' ) . '/orders/view/' . $order_id );
				}
			
		//print_r((object)$ShipmentDetails);
			}
		} else {
			redirect ( 'https://www.mondialrelay.fr/ww2/espaces/enseigne.aspx', 'refresh' );
		}
	}
	
	function replaceAccents($str) {
		$a = array ('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ' );
		$b = array ('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o' );
		return str_replace ( $a, $b, $str );
	}
	
	function get_parcel_info_mondiale_relay($order_id) {
		if (! $this->config->item ( 'redirect_only_to_mondial_relay_interface_for_parcel_tracking_info' )) {
			$this->load->library ( 'form_validation' );
			
			$this->form_validation->set_rules ( 'order_id', 'lang:order_id', 'trim|required|numeric' );
			$this->form_validation->set_rules ( 'exp_id', 'lang:exp_id', 'trim|required|numeric|max_length[8]' );
			
			if ($this->form_validation->run () == false) {
				$this->session->set_flashdata ( 'error', validation_errors () );
				redirect ( $this->config->item ( 'admin_folder' ) . '/orders/view/' . $order_id );
			} else {
				/*
				$this->session->set_flashdata('error', "Tracking Mondial Relay not implemented yet !");
	    		redirect($this->config->item('admin_folder').'/orders/view/'.$order_id);
	    		*/
				
				$this->load->add_package_path ( APPPATH . 'packages/shipping/mondial_relay_points_relais/' );
				$this->load->library ( 'mondial_relay_points_relais' );
				
				$ShipmentRef = $this->input->post ( 'exp_id' );
				
				$response = $this->mondial_relay_points_relais->get_parcel_info_mondiale_relay ( $ShipmentRef );
				
				if ($response) {
					redirect ( $response, 'refresh' );
				
		//print_r_html($response);
				} else {
					$this->session->set_flashdata ( 'error', 'Whoopsies!!' );
					redirect ( $this->config->item ( 'admin_folder' ) . '/orders/view/' . $order_id );
				}
			}
		} else {
			redirect ( 'https://www.mondialrelay.fr/ww2/espaces/enseigne.aspx', 'refresh' );
		}
	}
}