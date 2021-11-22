<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\controllers\Auth.php
	Description:	Controller for user authorization
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Auth extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->grcentral->installed_check();
		$this->load->database();
	}
	
	public function Index()
	{
		$this->_back_redirect();
	}
	
	public function login()
	{
		$is_user = $this->grcentral->is_user();
		
		if ($is_user == TRUE) 
		{
			$this->_back_redirect();
		}
		
		if (!is_null($this->input->post('login')) AND !is_null($this->input->post('password')))
		{
			$login = htmlspecialchars(trim($this->input->post('login')));
			$password = htmlspecialchars(trim($this->input->post('password')));
			
			if ($this->_check_credentials($login, $password))
			{
				$this->session->set_flashdata('success_result', lang('main_message_authsuccess'));
			}
			else
			{
				$this->session->set_flashdata('error_result', lang('main_message_autherror'));
			}
			
			$this->_back_redirect();
		}
		else
		{
			show_404();
		}
	}
	
	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->set_flashdata('success_result', lang('main_message_authlogout'));
		$this->_back_redirect();
	}
	
	private function _back_redirect()
	{
		if (isset($_SERVER["HTTP_REFERER"]) AND mb_stripos($_SERVER["HTTP_REFERER"],base_url()) == '0')
		{
			redirect($_SERVER["HTTP_REFERER"]);
		}
		else
		{
			redirect(index_page());
		}
	}
	
	private function _check_credentials($login=NULL, $password=NULL)
	{
		if (!is_null($login) AND !is_null($password))
		{
			if ($login == $this->config->item('login', 'auth') AND $password == $this->config->item('password', 'auth'))
			{
				$user_data = array(
					'logged_in'	=> $this->config->item('login', 'auth')
				);
				$this->session->set_userdata($user_data);
				return TRUE;
			}
		}
		return FALSE;
	}
}
