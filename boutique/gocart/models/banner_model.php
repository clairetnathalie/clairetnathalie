<?php
class Banner_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		
		$db_active_group = $this->session->userdata ( 'db_active_group' ) ? $this->session->userdata ( 'db_active_group' ) : 'french';
		$this->db = $this->load->database ( $db_active_group, TRUE );
	}
	
	function get_banners($limit = false) {
		if ($limit) {
			$this->db->limit ( $limit );
		}
		return $this->db->order_by ( 'sequence ASC' )->get ( 'banners' )->result ();
	}
	
	function get_homepage_banners($limit = false) {
		$banners = $this->db->order_by ( 'sequence ASC' )->get ( 'banners' )->result ();
		$count = 1;
		$return = array ();
		
		foreach ( $banners as $banner ) {
			if ($banner->enable_on == '0000-00-00') {
				$enable_test = false;
				$enable = '';
			} else {
				$eo = explode ( '-', $banner->enable_on );
				$enable_test = $eo [0] . $eo [1] . $eo [2];
				$enable = $eo [1] . '-' . $eo [2] . '-' . $eo [0];
			}
			
			if ($banner->disable_on == '0000-00-00') {
				$disable_test = false;
				$disable = '';
			} else {
				$do = explode ( '-', $banner->disable_on );
				$disable_test = $do [0] . $do [1] . $do [2];
				$disable = $do [1] . '-' . $do [2] . '-' . $do [0];
			}
			
			$curDate = date ( 'Ymd' );
			
			if ((! $enable_test || $curDate >= $enable_test) && (! $disable_test || $curDate < $disable_test)) {
				$return [] = $banner;
			}
			
			if (count ( $return ) == $limit) {
				break;
			}
		}
		return $return;
	}
	
	function get_banner($id) {
		$this->db->where ( 'id', $id );
		$result = $this->db->get ( 'banners' );
		$result = $result->row ();
		
		if ($result) {
			if ($result->enable_on == '0000-00-00') {
				$result->enable_on = '';
			}
			
			if ($result->disable_on == '0000-00-00') {
				$result->disable_on = '';
			}
			
			return $result;
		} else {
			return array ();
		}
	}
	
	function delete($id) {
		
		$banner = $this->get_banner ( $id );
		if ($banner) {
			$this->db->where ( 'id', $id );
			$this->db->delete ( 'banners' );
			
			return 'The "' . $banner->title . '" banner has been removed.';
		} else {
			return 'The banner could not be found.';
		}
	}
	
	function get_next_sequence() {
		$this->db->select ( 'sequence' );
		$this->db->order_by ( 'sequence DESC' );
		$this->db->limit ( 1 );
		$result = $this->db->get ( 'banners' );
		$result = $result->row ();
		if ($result) {
			return $result->sequence + 1;
		} else {
			return 0;
		}
	}
	
	function save_banner($data) {
		if (isset ( $data ['id'] )) {
			$this->db->where ( 'id', $data ['id'] );
			$this->db->update ( 'banners', $data );
		} else {
			$data ['sequence'] = $this->get_next_sequence ();
			$this->db->insert ( 'banners', $data );
		}
	}
	
	function organize($banners) {
		foreach ( $banners as $sequence => $id ) {
			$data = array ('sequence' => $sequence );
			$this->db->where ( 'id', $id );
			$this->db->update ( 'banners', $data );
		}
		
		/*Resize dimensions of 1st banner image for proper display as Facebook Open Graph image*/
		$top_banner = $this->get_homepage_banners ( 1 );
		
		list ( $width, $height, $type, $attr ) = getimagesize ( base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $top_banner [0]->image ) );
		$src_ratio = round ( $width / $height, 3 );
		
		$dest_width = 1200;
		$dest_height = 630;
		$dest_ratio = round ( $dest_width / $dest_height, 3 );
		
		$save_path = $this->config->item ( 'og_server_path' ) . 'banner/' . $this->session->userdata ( 'lang_scope' ) . '/';
		
		if (file_exists ( $save_path )) {
			deleteDir ( $save_path );
		}
		
		mkdir ( $save_path, 0775, true );
		
		if ($type == 3) /*PNG*/
		{
			// Copy 
			$src = imagecreatefrompng ( base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $top_banner [0]->image ) );
			
			// Merge
			$dest = resize_image_centered ( $src, $dest_width, $dest_height, 2 );
			
			// Save
			$save_name = "open_graph_image.png";
			
			$remote_file = $save_path . $save_name;
			imagepng ( $dest, $remote_file, 9 );
			chmod ( $remote_file, 0775 );
		} elseif ($type == 1) /*GIF*/
		{
			// Copy 
			$src = imagecreatefromgif ( base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $top_banner [0]->image ) );
			
			// Merge
			$dest = resize_image_centered ( $src, $dest_width, $dest_height, 2 );
			
			// Save
			$save_name = "open_graph_image.gif";
			
			$remote_file = $save_path . $save_name;
			imagegif ( $dest, $remote_file );
			chmod ( $remote_file, 0775 );
		} elseif ($type == 2) /*JPEG*/
		{
			// Copy 
			$src = imagecreatefromjpeg ( base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'images/full/' . $top_banner [0]->image ) );
			
			// Merge
			$dest = resize_image_centered ( $src, $dest_width, $dest_height, 2 );
			
			// Output
			//header('Content-Type: image/jpg');
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