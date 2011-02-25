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
    
    function get_product($title)
	{
			
		$this->db->where('menu', $title);
		$query = $this->db->get('products');
		if($query->num_rows == 1);
			{
				return $query->result();
			}
		
		return FALSE;
	}
	
	function get_all_products()
	{
			$this->db->join('cat_links', 'cat_links.product_id=products.product_id');
		$query = $this->db->get('products');
		if($query->num_rows > 0);
			{
				return $query->result();
			}
		
		return FALSE;
	}
}
