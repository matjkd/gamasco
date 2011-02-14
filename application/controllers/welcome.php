<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
	}
	
	function index()
	{
		redirect('welcome/home', 'refresh');
	}
	function home()
	{
			
		$data['menu'] = 'home';	
		$data['title'] = 'The GMS Company.';	
		$data['content'] = $this->content_model->get_content($data['menu']);
		$data['main_content'] = "global/content";
		$data['cats'] = $this->products_model->get_cats();
		$data['age'] = '25';
		$data['section2'] = 'global/links';
		$this->load->vars($data);
		$this->load->view('template/main');
	}
	
	function login()
	{
		
		$id = 'login';
		$data['content'] =	$this->content_model->get_content($id);
		
		$data['main_content'] = "user/login_form";
		$data['title'] = "Login to Gamasco";
		
		$data['page'] = "login";
		$this->load->vars($data);
		$this->load->view('template/main');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */