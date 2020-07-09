<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Grcentral {
	
	var $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function is_user()
	{
		$logged_in = $this->CI->session->userdata('logged_in');
		
		if ($logged_in == $this->CI->config->item('login', 'auth'))
		{
			return TRUE;
		}
		return FALSE;
	}
}
