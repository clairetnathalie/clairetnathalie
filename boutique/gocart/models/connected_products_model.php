<?php
class Connected_products_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		
		$db_active_group = $this->session->userdata ( 'db_active_group' ) ? $this->session->userdata ( 'db_active_group' ) : 'french';
		$this->db = $this->load->database ( $db_active_group, TRUE );
		
		$this->load->helper ( 'formatting_helper' );
	}
	
	/********************************************************************
		Connected Products Management
	 ********************************************************************/
	
	function update_quantity_child_connected_product($child_id, $quantity) {
		$this->db->where ( 'id', $child_id );
		$this->db->update ( 'products', array ('quantity' => intval ( $quantity ) - 1 ) );
	}
	
	function update_quantity_parent_connected_product($parent_id, $child_id, $quantity) {
		$connected_children_product_details = objectToArray ( json_decode ( $this->get_connected_product_options ( $parent_id ) ) );
		$connected_children_product_details [$child_id] ['options'] ['quantity'] = intval ( $quantity ) - 1;
		
		$this->db->where ( 'parent_id', $parent_id );
		$this->db->update ( 'connected_parent', array ('connected_children_product_details' => json_encode ( arrayToObject ( $connected_children_product_details ) ) ) );
	}
	
	function save_connected_child_product($product_id, $product, $save_connected) {
		$this->db->where ( 'child_id', $product_id );
		$this->db->from ( 'connected_child' );
		$count = $this->db->count_all_results ();
		
		if ($count > 0) {
			$this->db->where ( 'child_id', $product_id );
			$this->db->update ( 'connected_child', array ('connected_product_bool' => $save_connected ['connected_product_bool'], 'connected_parent_product_ids' => $save_connected ['connected_parent_product_ids'] ) );
		} else {
			$this->db->insert ( 'connected_child', array ('child_id' => $product_id, 'connected_product_bool' => $save_connected ['connected_product_bool'], 'connected_parent_product_ids' => $save_connected ['connected_parent_product_ids'] ) );
		}
	}
	
	function save_connected_parent_product($product_id, $product, $save_connected) {
		if ($product ['enabled'] == 1 && $product ['quantity'] > 0 && $save_connected ['connected_product_bool'] == 1) {
			$connected_parents = json_decode ( $save_connected ['connected_parent_product_ids'], true );
			
			if (! empty ( $connected_parents )) {
				foreach ( $connected_parents as $p ) {
					if ($product ['images'] == false) {
						$this_image = null;
						$this_caption = '';
					} else {
						$image_array = array_values ( ( array ) json_decode ( $product ['images'] ) );
						
						$this_image = base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . CONTENT_FOLDER . 'default/assets/img/thumbnail_no_picture.png' );
						$this_caption = '';
						
						foreach ( $image_array as $image ) {
							//if(isset($image->primary) && $image->primary == true)
							if (isset ( $image->alt ) && preg_match ( '/thumbnail/', $image->alt )) {
								$this_image = $this->config->item ( 'upload_url' ) . 'images/small/' . $image->filename;
								$this_caption = $image->caption;
							}
						}
					}
					
					$this_exerpt = $product ['excerpt'];
					
					$query_connected_children_product_details = $this->get_connected_children_product_details ( $p );
					
					if ($query_connected_children_product_details) {
						$connected_children_product_details_array = json_decode ( $query_connected_children_product_details, true );
						
						if (! empty ( $connected_children_product_details_array )) {
							if (! in_array ( $product_id, $connected_children_product_details_array )) {
								$connected_children_product_details_array [$product_id] = array ('name' => $product ['name'], 'child_connected_product_id' => $product ['id'], 'slug' => $product ['slug'], 'route_id' => $product ['route_id'], 'options' => array ('weight' => $product ['weight'], 'quantity' => $product ['quantity'], 'image' => $this_image, 'caption' => $this_caption, 'excerpt' => $this_exerpt ) );
								
								$this->db->where ( 'parent_id', $p );
								$this->db->update ( 'connected_parent', array ('connected_children_product_details' => json_encode ( $connected_children_product_details_array ) ) );
							}
						} else {
							$connected_child_product_details [$product_id] = array ('name' => serialize ( $product ['name'] ), 'child_connected_product_id' => $product ['id'], 'slug' => $product ['slug'], 'route_id' => $product ['route_id'], 'options' => array ('weight' => $product ['weight'], 'quantity' => $product ['quantity'], 'image' => $this_image, 'caption' => $this_caption, 'excerpt' => $this_exerpt ) );
							
							$query = $this->db->get_where ( 'connected_parent', array ('parent_id' => $p ) );
							if ($query->num_rows () > 0) {
								$this->db->where ( 'parent_id', $p );
								$this->db->update ( 'connected_parent', array ('connected_children_product_details' => json_encode ( $connected_child_product_details ) ) );
							} else {
								$this->db->insert ( 'connected_parent', array ('parent_id' => $p, 'connected_children_product_details' => json_encode ( $connected_child_product_details ) ) );
							}
						}
					} else {
						$connected_child_product_details [$product_id] = array ('name' => serialize ( $product ['name'] ), 'child_connected_product_id' => $product ['id'], 'slug' => $product ['slug'], 'route_id' => $product ['route_id'], 'options' => array ('weight' => $product ['weight'], 'quantity' => $product ['quantity'], 'image' => $this_image, 'caption' => $this_caption, 'excerpt' => $this_exerpt ) );
						
						$query = $this->db->get_where ( 'connected_parent', array ('parent_id' => $p ) );
						if ($query->num_rows () > 0) {
							$this->db->where ( 'parent_id', $p );
							$this->db->update ( 'connected_parent', array ('connected_children_product_details' => json_encode ( $connected_child_product_details ) ) );
						} else {
							$this->db->insert ( 'connected_parent', array ('parent_id' => $p, 'connected_children_product_details' => json_encode ( $connected_child_product_details ) ) );
						}
					}
				}
			}
		} else {
			$connected_parents = json_decode ( $save_connected ['connected_parent_product_ids'], true );
			
			if (! empty ( $connected_parents )) {
				foreach ( $connected_parents as $p ) {
					$query_connected_children_product_details = $this->get_connected_children_product_details ( $p );
					$connected_children_product_details_array = json_decode ( $query_connected_children_product_details, true );
					
					if (! empty ( $connected_children_product_details_array )) {
						if (array_key_exists ( $product_id, $connected_children_product_details_array )) {
							unset ( $connected_children_product_details_array [$product_id] );
							
							$this->db->where ( 'parent_id', $p );
							$this->db->update ( 'connected_parent', array ('connected_children_product_details' => json_encode ( $connected_children_product_details_array ) ) );
						}
					}
				}
			}
		}
	}
	
	function delete_connected_parent_product($p, $id) {
		// delete connected product
		$query_connected_children_product_details = $this->get_connected_children_product_details ( $p );
		$connected_children_product_details_array = json_decode ( $query_connected_children_product_details, true );
		
		if (! empty ( $connected_children_product_details_array )) {
			if (array_key_exists ( $id, $connected_children_product_details_array )) {
				unset ( $connected_children_product_details_array [$id] );
				
				$this->db->where ( 'parent_id', $p );
				$this->db->update ( 'connected_parent', array ('connected_children_product_details' => json_encode ( $connected_children_product_details_array ) ) );
			}
		}
	}
	
	function delete_connected_child_product($id) {
		$this->db->delete ( 'connected_child', array ('child_id' => $id ) );
	}
	
	/********************************************************************
		Parent Product Details
	 ********************************************************************/
	
	function get_connected_parent($child_id) {
		$query = $this->db->get_where ( 'connected_child', array ('child_id' => $child_id ) );
		
		if ($query->num_rows () > 0) {
			$result = $query->row_array ();
			
			return $result;
		} else {
			return false;
		}
	}
	
	function get_connected_parent_products($child_id) {
		$query = $this->db->get_where ( 'connected_child', array ('child_id' => $child_id ) );
		
		if ($query->num_rows () > 0) {
			$result = $query->row_array ();
			
			$connected_parents = json_decode ( $result ['connected_parent_product_ids'] );
			
			if (! empty ( $connected_parents )) {
				//build the where
				$where = false;
				foreach ( $connected_parents as $p ) {
					if (! $where) {
						$this->db->where ( 'id', $p );
					} else {
						$this->db->or_where ( 'id', $p );
					}
					$where = true;
				}
				
				$result ['connected_parents'] = $this->db->get ( 'products' )->result ();
			} else {
				$result ['connected_parents'] = array ();
			}
			
			return arrayToObject ( $result );
		} else {
			return arrayToObject ( array ('connected_product_bool' => 0, 'connected_parent_product_ids' => '', 'connected_parents' => array () ) );
		}
	}
	
	function bulk_save_connected_parent_products($id, $connected_children_product_details_array) {
		$this->db->where ( 'parent_id', $id );
		$this->db->update ( 'connected_parent', array ('connected_children_product_details' => json_encode ( $connected_children_product_details_array ) ) );
	}
	
	/********************************************************************
		Child Product Details
	 ********************************************************************/
	
	function get_connected_product_options($parent_id) {
		$this->db->where ( 'parent_id', $parent_id );
		$result = $this->db->get ( 'connected_parent' )->row_array ();
		if ($result) {
			return $result ['connected_children_product_details'];
		}
	}
	
	function get_connected_children_product_details($id) {
		$query = $this->db->get_where ( 'connected_parent', array ('parent_id' => $id ) );
		
		if ($query->num_rows () > 0) {
			$result = $query->row_array ();
			return $result ['connected_children_product_details'];
		} else {
			return false;
		}
	}

}