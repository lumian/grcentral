<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.2
	File:			application\controllers\Logs.php
	Description:	View system logs
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Logs extends CI_Controller {
	
	private $title = '';
	
	public function __construct()
	{
		parent::__construct();
		
		if (!$this->grcentral->is_user())
		{
			redirect(index_page());
		}
		
		$this->lang->load('logs');
		$this->load->model('logger_model');
	}
	
	private function _RenderPage()
	{
		$template_page_data = array(
			'content'		=> $this->content,
		);
		
		$full_page_data = array(
			'title'			=> $this->config->item('site_title', 'grcentral')." - ".lang('main_menu_settings').$this->title,
			'content'		=> $this->load->view('logs/template', $template_page_data, TRUE),
		);
		
		$this->load->view('template', $full_page_data);
	}
	
	// Logs index page
	public function index()
	{
		redirect('/logs/provisioning/');
	}
	
	// Provisioning logs
	public function provisioning()
	{
		$this->load->model('devices_model');
		
		$logs_list = $this->logger_model->get_logs(array('type'=>'provisioning'));
		$devices_query = $this->devices_model->getlist();
		
		if ($devices_query != FALSE)
		{
			foreach($devices_query as $device)
			{
				$devices_list[$device['id']] = $device;
			}
		}
		else
		{
			$devices_list = FALSE;
		}
		
		$page_data = array(
			'devices_list'	=> $devices_list,
			'logs_list'		=> $logs_list
		);
		$this->content = $this->load->view('logs/provisioning', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	// System logs (in development...)
	public function system()
	{
		$page_data = array();
		$this->content = $this->load->view('logs/system', $page_data, TRUE);
		$this->_RenderPage();
	}
}
