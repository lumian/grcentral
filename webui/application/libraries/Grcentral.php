<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\libraries\Grcentral.php
	Description:	Small but necessary functions that are used in different system controllers.
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Grcentral {
	
	var $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	// Function for checking whether the user is authorized
	public function is_user()
	{
		$logged_in = $this->CI->session->userdata('logged_in');
		
		if ($logged_in == $this->CI->config->item('login', 'auth'))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	// Function for determining whether settings should be applied.
	public function check_cfg_need_apply()
	{
		$this->CI->load->model('settings_model');
		$need_apply_db = $this->CI->settings_model->syssettings_get('cfg_need_apply');
		
		if ($need_apply_db == 'on')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	// Function for setting the "need apply" flag
	public function set_cfg_need_apply()
	{
		$this->CI->load->model('settings_model');
		$need_apply_db = $this->CI->settings_model->syssettings_update(array('cfg_need_apply' => 'on'));
		
		return TRUE;
	}
	
	// Function for giving files to devices.
	public function forcedownload($file_name=NULL, $file_path=NULL)
	{
		if (!is_null($file_name) AND !is_null($file_path) AND file_exists($file_path))
		{
			$this->CI->load->helper('download');
			$data = file_get_contents($file_path);
			force_download($file_name, $data);
		}
		else
		{
			show_404();
		}
	}
	
	// Get referer
	public function get_local_referer()
	{
		if (isset($_SERVER['HTTP_REFERER']))
		{
			$server_referer = $_SERVER['HTTP_REFERER'];
			$check_referer = strpos($server_referer, $this->CI->config->item('base_url'));
			
			if ($check_referer === 0)
			{
				$local_referer = mb_substr($server_referer, mb_strlen($this->CI->config->item('base_url')));
				return $local_referer;
			}
		}
		return FALSE;
	}
	
	// Convert devices params (text >>> json)
	public function convert_params_text2json($source_data = NULL)
	{
		if ($source_data != NULL)
		{
			$source_data_array = explode(PHP_EOL, $source_data);

			foreach($source_data_array as $string)
			{
				if (trim($string) != "" AND (mb_stripos($string, "#") === FALSE OR mb_stripos($string, "#") != "0"))
				{
					$params_data_array[] = trim($string);
				}
			}
			if (is_array($params_data_array))
			{
				$json_data = json_encode($params_data_array);
				return $json_data;
			}
		}
		return FALSE;
	}
	
	// Validate date
	public function is_date($str=NULL)
	{
		return is_numeric(strtotime($str));
	}
	
	// Get client IP
	public function get_client_ip()
	{
		return $this->CI->input->ip_address();
	}
	
	public function max_size_upload($return='KB')
	{
		$upload_max_filesize = $this->return_bytes(ini_get('upload_max_filesize'));
		$post_max_size = $this->return_bytes(ini_get('post_max_size'));
		
		if ($upload_max_filesize == $post_max_size) { $max_size = $upload_max_filesize; }
		if ($upload_max_filesize < $post_max_size) { $max_size = $upload_max_filesize; }
		if ($upload_max_filesize > $post_max_size) { $max_size = $post_max_size; }
		
		if (isset($max_size) AND $max_size > 0)
		{
			switch ($return)
			{
				case 'B': return $max_size;
				case 'KB': return $max_size / 1024;
				case 'MB': return $max_size / 1024 / 1024;
				case 'GB': return $max_size / 1024 / 1024 / 1024;
			}
		}
		else
		{
			return 0;
		}
	}
	
	// Return bytes
	public function return_bytes($size_str)
	{
		switch (substr ($size_str, -1))
		{
			case 'K': case 'k': return (int)$size_str * 1024;
			case 'M': case 'm': return (int)$size_str * 1048576;
			case 'G': case 'g': return (int)$size_str * 1073741824;
			case 'T': case 't': return (int)$size_str * 1099511627776;
			default: return $size_str;
		}
	}
	
	public function installed_check($action = 'redirect')
	{
		if ($this->CI->config->item('system_installed') != TRUE)
		{
			if ($action == 'redirect')
			{
				redirect('installer');
			}
			elseif ($action == '404')
			{
				show_404();
			}
			else
			{
				echo $this->CI->config->item('site_title', 'grcentral')." is not installed. Please, follow to \"http://<ip_address_of_your_server>/installer\" for install system.".PHP_EOL;
				exit();
			}
		}
	}
}
