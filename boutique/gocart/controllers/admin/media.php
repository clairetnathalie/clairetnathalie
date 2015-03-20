<?php
class Media extends Admin_Controller {
	var $path;
	function __construct() {
		parent::__construct ();
		
		//$this->path	= 'uploads/wysiwyg';
		$this->path = $this->config->item ( 'upload_server_path' ) . 'wysiwyg';
		$this->auth->check_access ( 'Admin', true );
		$this->load->helper ( array ('file', 'form' ) );
		
		define ( 'TRANSLATABLE', false );
	}
	
	function index() {
		$this->data ['root'] = trim ( implode ( '/', array_slice ( $this->uri->segment_array (), 3 ) ), '/' );
		
		if (! is_dir ( $this->path . '/' . $this->data ['root'] )) {
			redirect ( config_item ( 'admin_folder' ) . '/media/index/' );
		}
		
		$this->data ['files'] = array ();
		$files = get_dir_file_info ( $this->path . '/' . $this->data ['root'] );
		
		if (! empty ( $files )) {
			foreach ( $files as $f ) {
				$this->data ['files'] [] = $f ['name'];
			}
		}
		
		natcasesort ( $this->data ['files'] );
		
		$this->load->view ( config_item ( 'admin_folder' ) . '/iframe/media', $this->data );
	}
	
	function embed() {
		//get the file path
		$this->data ['root'] = array_slice ( $this->uri->segment_array (), 3 );
		array_pop ( $this->data ['root'] );
		
		//get the file
		$this->data ['file'] = trim ( implode ( '/', array_slice ( $this->uri->segment_array (), 3 ) ), '/' );
		
		if (! file_exists ( $this->path . '/' . $this->data ['file'] )) {
			$this->set_flashdata ( 'error', 'The requested file could not be found' );
			redirect ( config_item ( 'admin_folder' ) . '/media/index/' );
		}
		
		$this->load->view ( config_item ( 'admin_folder' ) . '/iframe/header', $this->data );
		$this->load->view ( config_item ( 'admin_folder' ) . '/iframe/embed', $this->data );
		$this->load->view ( config_item ( 'admin_folder' ) . '/iframe/footer', $this->data );
	
	}
	
	function edit_image() {
		$this->load->view ( config_item ( 'admin_folder' ) . '/iframe/edit_image' );
	}
	
	function create_subfolder() {
		$root = trim ( $this->input->post ( 'root' ), '/' );
		$folder = trim ( url_title ( $this->input->post ( 'folder-name' ), '-', true ), '/' );
		
		if (empty ( $folder )) {
			$this->session->set_flashdata ( 'error', 'You must submit a folder name.' );
		} elseif (file_exists ( $this->path . '/' . $root . '/' . $folder )) {
			$this->session->set_flashdata ( 'error', 'There requested folder name is already in use.' );
		} else {
			if (mkdir ( $this->path . '/' . $root . '/' . $folder )) {
				$this->session->set_flashdata ( 'message', 'Your subfolder has been successfully created.' );
			} else {
				$this->session->set_flashdata ( 'error', 'There was an error creating your folder.' );
			}
		}
		redirect ( config_item ( 'admin_folder' ) . '/media/index/' . $root );
	}
	
	function move_file() {
		$filename = $this->input->post ( 'filename' );
		$subfolder = $this->input->post ( 'move_to' );
		$root = $this->input->post ( 'root' );
		
		//stop the chance of //
		if (! empty ( $root )) {
			$root .= '/';
		}
		
		$new = $this->path . '/' . $subfolder . '/' . $filename;
		$old = $this->path . '/' . $root . $filename;
		
		if (! file_exists ( $new ) && file_exists ( $old )) {
			rename ( $old, $new );
			echo json_encode ( true );
		} else {
			echo json_encode ( false );
		}
	}
	
	function rename_file() {
		
		$root = trim ( $this->input->post ( 'root' ), '/' );
		$parts = pathinfo ( $this->input->post ( 'new' ) );
		
		$new_filename = url_title ( $parts ['filename'], '-', true );
		if (! empty ( $parts ['extension'] )) {
			$new_filename .= '.' . $parts ['extension'];
		}
		
		$new = $this->path . '/' . $root . '/' . $new_filename;
		$old = $this->path . '/' . $root . '/' . $this->input->post ( 'original' );
		
		if (! empty ( $new_filename ) && ! file_exists ( $new ) && file_exists ( $old )) {
			rename ( $old, $new );
			$this->session->set_flashdata ( 'message', 'Your file has been successfully renamed.' );
		} else {
			$this->session->set_flashdata ( 'error', 'There was an error renaming the requested file.' );
		}
		
		redirect ( config_item ( 'admin_folder' ) . '/media/index/' . $root );
	}
	
	function delete() {
		$root = trim ( $this->input->post ( 'root' ), '/' );
		$file = $this->path . '/' . $root . '/' . $this->input->post ( 'filename' );
		
		if (is_dir ( $file )) {
			delete_files ( $file, TRUE );
			rmdir ( $file );
			$this->session->set_flashdata ( 'message', 'Your folder has been successfully deleted.' );
		} elseif (file_exists ( $file )) {
			unlink ( $file );
			$this->session->set_flashdata ( 'message', 'Your file has been successfully deleted.' );
		}
		
		redirect ( config_item ( 'admin_folder' ) . '/media/index/' . $root );
	}
	
	function upload() {
		$root = trim ( $this->input->post ( 'root' ), '/' );
		
		//$config['upload_path']		= 'uploads/wysiwyg/'.$root;
		$config ['upload_path'] = $this->config->item ( 'upload_server_path' ) . 'wysiwyg/' . $root;
		$config ['allowed_types'] = 'gif|jpg|png';
		$config ['max_size'] = $this->config->item ( 'size_limit' );
		$config ['max_width'] = '1024';
		$config ['max_height'] = '768';
		
		$this->load->library ( 'upload', $config );
		
		if (! $this->upload->do_upload ()) {
			$this->session->set_flashdata ( 'error', $this->upload->display_errors () );
			redirect ( config_item ( 'admin_folder' ) . '/media/index/' . $root );
		} else {
			$this->session->set_flashdata ( 'message', 'Your file has been successfully uploaded.' );
			redirect ( config_item ( 'admin_folder' ) . '/media/index/' . $root );
		}
	}
	
	function redactor_upload() {
		
		$upload_config = array ('upload_path' => $this->config->item ( 'upload_server_path' ) . 'wysiwyg/', 'upload_url' => base_url ( (! preg_match ( '/localhost/', current_url () ) ? '' : 'clairetnathalie/') . IMG_UPLOAD_FOLDER . 'wysiwyg/' ), 'allowed_types' => 'jpg|gif|png', 'overwrite' => false, 'max_size' => $this->config->item ( 'size_limit' ) );
		
		$this->load->library ( 'upload', $upload_config );
		
		if ($this->upload->do_upload ( 'file' )) {
			$data = $this->upload->data ();
			$array = array ('filelink' => $upload_config ['upload_url'] . '/' . $data ['file_name'] );
			echo stripslashes ( json_encode ( $array ) );
		} else {
			//echo json_encode(array('error' => $this->upload->display_errors('', '')));
			echo json_encode ( array ('error' => 'Erreur avec le téléchargement de l\'image' ) );
		}
	}
}	