<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\controllers\Home.php
	Description:	Home page
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Home extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->grcentral->installed_check();
		$this->load->database();
	}
	
	private function _RenderPage()
	{
		$full_page_data = array(
			'title'			=> $this->config->item('site_title', 'grcentral')." - ".lang('main_menu_home'),
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
