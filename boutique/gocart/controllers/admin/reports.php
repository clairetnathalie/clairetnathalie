<?php

class Reports extends Admin_Controller {
	
	//this is used when editing or adding a customer
	var $customer_id = false;
	
	function __construct() {
		parent::__construct ();
		remove_ssl ();
		
		$this->auth->check_access ( 'Admin', true );
		
		$this->load->model ( 'Order_model' );
		$this->load->model ( 'Search_model' );
		$this->load->helper ( array ('formatting' ) );
		
		$this->lang->load ( 'report' );
		
		define ( 'TRANSLATABLE', false );
	}
	
	function index() {
		$this->data ['page_title'] = lang ( 'reports' );
		$this->data ['years'] = $this->Order_model->get_sales_years ();
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/reports', $this->data );
	}
	
	function best_sellers() {
		$start = $this->input->post ( 'start' );
		$end = $this->input->post ( 'end' );
		$this->data ['best_sellers'] = $this->Order_model->get_best_sellers ( $start, $end );
		
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/reports/best_sellers', $this->data );
	}
	
	function sales() {
		$year = $this->input->post ( 'year' );
		$this->data ['orders'] = $this->Order_model->get_gross_monthly_sales ( $year );
		$this->load->view ( $this->config->item ( 'admin_folder' ) . '/reports/sales', $this->data );
	}

}