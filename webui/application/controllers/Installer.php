<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.4
	File:			application\controllers\Installer.php
	Description:	Installer
	
	2020-2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Installer extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ($this->config->item('system_installed') === TRUE)
		{
			show_404();
		}
		
		$this->content = FALSE;
	}
	
	private function _RenderPage()
	{
		$full_page_data = array(
			'title'			=> $this->config->item('site_title', 'grcentral').' Installer',
			'content'		=> $this->content,
			'step'			=> $this->step
		);
		
		$this->load->view('installer', $full_page_data);
	}
	
	public function index()
	{
		$this->step = 'welcome';
		$this->_RenderPage();
	}
	
	public function step($step=NULL)
	{
		$page_data = FALSE;
		// List of files for checking
		
		$check_files = array(
			'config_main'		=> './application/config/config.php',
			'config_grcentral'	=> './application/config/grcentral.php',
			'config_database'	=> './application/config/database.php',
			'storage_cfg'		=> $this->config->item('storage_path','grcentral').'cfg/',
			'storage_fw'		=> $this->config->item('storage_path','grcentral').'fw/',
			'storage_pb'		=> $this->config->item('storage_path','grcentral').'phonebook/'
		);
			
		if (is_null($step))
		{
			redirect('installer/step/1');
		}
		if ($step == '1')
		{
			$status_ok = TRUE;
			
			foreach($check_files as $key => $path)
			{
				if (is_writable($path))
				{
					$check_result[] = array(
						'name'			=> $path,
						'write'			=> TRUE
					);
				}
				else
				{
					$check_result[] = array(
						'name'			=> $path,
						'write'			=> FALSE
					);
					$status_ok = FALSE;
				}
			}
			
			$page_data = array(
				'check_result'		=> $check_result,
				'status_ok'			=> $status_ok
			);
		}
		elseif ($step == '2')
		{
			$status_ok = NULL;
			$status_db_ok = NULL;
			
			// WebUI access
			$default_value['admin_login']			= $this->config->item('login', 'auth');
			$default_value['admin_password']		= $this->config->item('password', 'auth');
			
			// System settings
			$default_value['system_domain']			= $this->input->server('HTTP_HOST', TRUE);
			$default_value['system_language']		= $this->config->item('language');
			$default_value['system_keep_logs']		= $this->config->item('keep_logs', 'cron');
			
			// Database settings
			$default_value['database_hostname']		= 'localhost';
			$default_value['database_username']		= 'root';
			$default_value['database_password']		= '';
			$default_value['database_name']			= 'grcentral';
			
			// Available languages
			$this->load->helper('directory');
			$lang_dir = './application/language/';
			$lang_dir_array = directory_map($lang_dir, 1);
			
			foreach($lang_dir_array as $key => $value)
			{
				if (is_dir($lang_dir.$value))
				{
					$language_list[] = mb_substr($value,0,mb_strlen($value)-1);
				}
			}
			
			if ($this->input->post())
			{
				$post_data = $this->input->post();
				
				foreach($default_value as $key => $value)
				{
					if (isset($post_data[$key]) AND $post_data[$key] != '' AND is_string($post_data[$key]))
					{
						$input_settings[$key] = $post_data[$key];
					}
					else
					{
						break;
					}
				}
				
				if (count($default_value) === count($input_settings))
				{
					// Config main replace:
					$config_main_array = file($check_files['config_main']);
					$config_main_replace = array(
						'base_url'			=> 'http://'.$input_settings['system_domain'].'/',
						'cookie_domain'		=> $input_settings['system_domain'],
						'language'			=> $input_settings['system_language']
					);
					
					$config_main_result = $this->config_strings_replace($config_main_array, $config_main_replace);
					$config_main_put = file_put_contents($check_files['config_main'], $config_main_result);
					
					// Config grcentral replace:
					$config_grcentral_array = file($check_files['config_grcentral']);
					$config_grcentral_replace = array(
						'login'				=> $input_settings['admin_login'],
						'password'			=> $input_settings['admin_password'],
						'keep_logs'			=> $input_settings['system_keep_logs']
					);
					
					$config_grcentral_result = $this->config_strings_replace($config_grcentral_array, $config_grcentral_replace);
					$config_grcentral_put = file_put_contents($check_files['config_grcentral'], $config_grcentral_result);
					
					// Config database replace:
					$config_database_array = file($check_files['config_database']);
					$config_database_replace = array(
						'hostname'			=> $input_settings['database_hostname'],
						'username'			=> $input_settings['database_username'],
						'password'			=> $input_settings['database_password'],
						'database'			=> $input_settings['database_name']
					);
					
					$connect_mysql = @mysqli_connect($input_settings['database_hostname'], $input_settings['database_username'], $input_settings['database_password'], $input_settings['database_name']);
					
					if ($connect_mysql === FALSE)
					{
						$status_db_ok = FALSE;
						$status_ok = FALSE;
					}
					else
					{
						$config_database_result = $this->config_strings_replace($config_database_array, $config_database_replace, '=>');
						$config_database_put = file_put_contents($check_files['config_database'], $config_database_result);
						
						// Fill database:
						$db_dump = file_get_contents('./storage/installer/mysql_install.sql');
						mysqli_multi_query($connect_mysql, $db_dump);
						mysqli_close($connect_mysql);
						
						$status_db_ok = TRUE;
						$status_ok = TRUE;
					}
				}
				else
				{
					$status_ok = FALSE;
				}
			}
			else
			{
				$post_data = $default_value;
			}
			
			$page_data = array(
				'post_data'			=> $post_data,
				'language_list'		=> $language_list,
				'status_ok'			=> $status_ok,
				'status_db_ok'		=> $status_db_ok
			);
		}
		elseif ($step == '3')
		{
			$config_grcentral_array = file($check_files['config_grcentral']);
			$config_grcentral_replace = array(
				'system_installed'	=> TRUE
			);
			$config_grcentral_result = $this->config_strings_replace($config_grcentral_array, $config_grcentral_replace);
			$config_grcentral_put = file_put_contents($check_files['config_grcentral'], $config_grcentral_result);
			
			$this->load->database();
			$this->settings_model->syssettings_default();
		}
		
		$this->content = $page_data;
		$this->step = $step;
		$this->_RenderPage();
	}
	
	private function config_strings_replace($strings_array, $replace_array, $delimiter = '=')
	{
		$result_text = '';
		
		foreach($strings_array as $string)
		{
			if (mb_stripos(trim($string), '/*', 0) === 0 OR mb_stripos(trim($string), '*', 0) === 0 OR mb_stripos(trim($string), '|', 0) === 0)
			{
				$result_text .= $string;
			}
			else
			{
				$replace_data = FALSE;
				
				foreach($replace_array as $key => $value)
				{
					if (mb_strripos($string, $key, 0))
					{
						$replace_data = $value;
						break;
					}
				}
				if ($replace_data != FALSE)
				{
					$string_array = explode($delimiter, $string);
					if ($delimiter == '=')
					{
						$end_string = ';';
					}
					else
					{
						$end_string = ',';
					}
					
					if (is_array($string_array) AND isset($string_array[0]) AND isset($string_array[1]))
					{
						if ($replace_data === TRUE OR $replace_data === FALSE)
						{
							$result_text .= $string_array[0].$delimiter.' '.($replace_data === TRUE ? "TRUE" : "FALSE");
						}
						else
						{
							$result_text .= $string_array[0].$delimiter.' \''.$replace_data.'\'';
						}
						$result_text .= $end_string."\r\n";
					}
				}
				else
				{
					$result_text .= $string;
				}
			}
		}
		return $result_text;
	}
}
