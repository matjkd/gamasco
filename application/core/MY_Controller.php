<?php

class MY_Controller extends CI_Controller {

	function __construct() {
	parent::__construct();
	
	$config_data['config_company_name'] = "Gamasco";
	$config_data['config_address'] = "address";
	$config_data['config_version'] = "0.0.5";
	$config_data['config_email'] = "";
	
	$this->config_email = 'info@thedesigncompany.com';
	$this->config_company_name = 'Gamasco';
	$this->load->vars($config_data);

	}
	

}