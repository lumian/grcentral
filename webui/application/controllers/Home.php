<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	private function _RenderPage()
	{
		$full_page_data = array(
			'title'			=> $this->config->item('site_title', 'gcentral').' - Home',
			'content'		=> $this->content,
		);
		
		$this->load->view('template', $full_page_data);
	}
	
	public function index()
	{
		$this->content = $this->load->view('main', NULL, TRUE);
		$this->_RenderPage();
	}
}
