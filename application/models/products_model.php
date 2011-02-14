<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Products_model extends CI_Model {
	  
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_cats()
	{
		$query = $this->db->get('categories');
		return $query->result();
	}
    
    
}
