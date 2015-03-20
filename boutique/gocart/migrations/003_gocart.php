<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Migration_gocart extends CI_migration {
	
	public function up() {
		//add the show field to be NULL by default
		$fields = array ('show' => array ('type' => 'ENUM', 'constraint' => "'0','1'", 'default' => '1' ) );
		
		$this->dbforge->add_column ( 'boxes', $fields );
	
	}
	
	public function down() {
		//none of the changes should effect the product
	}

}
