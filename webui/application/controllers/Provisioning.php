<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\controllers\Provisioning.php
	Description:	Processing requests from the devices. Returns configs and firmware.
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Provisioning extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->grcentral->installed_check();
		$this->load->database();
		
		//
		// Loading models and library
		//
		$this->load->model('devices_model');
		$this->load->library('logger');
		
		//
		// Collecting device info
		// 
		// $this->device_info['useragent']		Device information obtained from the useragent.
		// $this->device_info['db']				Device information obtained from the database based on the information about the useragent.
		// $this->device_info['client']			Device information obtained from the server environment.
		//
		
		$this->device_info['useragent'] = $this->_useragent2devicedata($_SERVER['HTTP_USER_AGENT']);
		if ($this->device_info['useragent'] != FALSE AND isset($this->device_info['useragent']['model']) AND isset($this->device_info['useragent']['version']) AND isset($this->device_info['useragent']['mac']) AND (mb_strlen($this->device_info['useragent']['mac']) == '12'))
		{
			$this->device_info['db'] = $this->devices_model->get(array('mac_addr' => $this->device_info['useragent']['mac']));
		}
		else
		{
			$this->device_info['db'] = FALSE;
		}
		$this->device_info['client'] = array(
			'ip_addr'	=> $this->grcentral->get_client_ip()
		);
		
		//
		// Update info about device in DB
		//
		if ($this->device_info['db'] != FALSE)
		{
			$this->_check_access_device();
			$this->_update_device_info();
		}
	}
	
	//
	// Query functions
	//

	// Processing CFG requests
	public function cfg($get_file=NULL)
	{
		// Check system settings:
		$cfg_enable_get = $this->settings_model->syssettings_get('cfg_enable_get');
		if ($cfg_enable_get == 'off') { show_404(); }
		
		// If file not request then show 404 error
		if (is_null($get_file)) { show_404(); }
		
		// If the device information is received, we continue
		if ($this->device_info['useragent'] != FALSE)
		{
			// If the device is found in the database, we continue
			if ($this->device_info['db'] != FALSE)
			{
				// If the requested file matches the configuration file template, then continue
				if ($get_file == 'cfg'.$this->device_info['db']['mac_addr'].'.xml' AND $this->device_info['db']['status_active'] == '1')
				{
					// If config file is readable, then download...
					if (is_readable($this->config->item('storage_path', 'grcentral').'cfg/'.$get_file))
					{
						// Logging
						$this->logger->device_get_cfg($this->device_info['db']['id'], array('fw_version'=>$this->device_info['useragent']['version']));
						// Download file:
						$this->grcentral->forcedownload($get_file, $this->config->item('storage_path', 'grcentral').'cfg/'.$get_file);
					}
					else
					{
						// Displaying the 404 error
						show_404();
					}
				}
				else
				{
					// Displaying the 404 error
					show_404();
				}
			}
			else
			{
				// Check system settings
				$auto_add_devices = $this->settings_model->syssettings_get('auto_add_devices');
				if ($auto_add_devices == 'off') { show_404(); }
				
				// Getting model info from DB
				$model_info = $this->settings_model->models_get(array('tech_name' => $this->device_info['useragent']['model']));
				
				// Forming an array with data
				$add_data['mac_addr']			= $this->device_info['useragent']['mac'];
				$add_data['ip_addr']			= $this->device_info['client']['ip_addr'];
				$add_data['status_active']		= '0';
				$add_data['descr']				= "AutoAdd";
				$add_data['fw_version']			= $this->device_info['useragent']['version'];
				$add_data['fw_version_pinned']	= '0';
				
				if ($model_info === FALSE)
				{
					$add_data['model_id'] = '0';
				}
				else 
				{
					$add_data['model_id'] = $model_info['id'];
				}
				$this->devices_model->add($add_data);
			}
		}
		else
		{
			// If the device information could not be obtained, we give the error 404.
			show_404();
		}
	}
	
	// Processing FW requests (language.txt file, ringX.bin files, update files)
	public function fw($get_file=NULL)
	{
		// Check system settings
		$fw_enable_update = $this->settings_model->syssettings_get('fw_enable_update');
		if ($fw_enable_update == 'off') { show_404(); }
		
		if (is_null($get_file)) { show_404(); }

		// If the device information is received, we continue
		if ($this->device_info['useragent'] != FALSE)
		{
			// Get the language.txt file
			if ($get_file == 'language.txt')
			{
				// In the development...
				show_404();
			}
			// Get the rings file
			elseif ($get_file == 'ring1.bin' OR $get_file == 'ring2.bin' OR $get_file == 'ring3.bin' OR $get_file == 'ring4.bin' OR $get_file == 'ring5.bin')
			{
				$file_path = $this->config->item('storage_path', 'grcentral').'rings/'.$get_file;
				
				if (is_readable($file_path))
				{
					$this->grcentral->forcedownload($get_file, $file_path);
				}
				else
				{
					show_404();
				}
			}
			elseif (mb_stripos($get_file, '.bin') != FALSE)
			{
				// If the device is not found in the database, then check the settings
				if ($this->device_info['db'] == FALSE)
				{
					// If the "update only for friends" setting is enabled, we display a 404 error.
					$fw_update_only_friend = $this->settings_model->syssettings_get('fw_update_only_friend');
					if ($fw_update_only_friend == 'on')
					{
						show_404();
					}
				}
				
				// If the device is not active, then we display a 404 error.
				if ($this->device_info['db'] != FALSE AND $this->device_info['db']['status_active'] == '0')
				{
					show_404();
				}
				
				// Checking the device model in the database
				$model_info = $this->settings_model->models_get(array('tech_name' => $this->device_info['useragent']['model']));
				
				// If the device model is found in the database, we continue
				if ($model_info != FALSE AND isset($model_info['group_id']))
				{
					// Getting a list of updates for the selected device group.
					$fw_list = $this->settings_model->fw_getlist(array('group_id' => $model_info['group_id']));
					
					// If the update file names is found in the database, we continue
					if ($fw_list != FALSE AND is_array($fw_list))
					{
						// We check the array and look for a match to the requested file.
						foreach($fw_list as $fw)
						{
							if ($fw['file_name'] == $get_file)
							{
								$get_file_found = TRUE;
								break;
							}
						}
						// If the name of the requested file is found in the database, we continue
						if (isset($get_file_found) AND $get_file_found === TRUE)
						{
							// We check the list of updates from the database and create the resulting array
							foreach($fw_list as $fw)
							{
								// If the device is in the database and firmware pinning is enabled
								if ($this->device_info['db'] != FALSE AND $this->device_info['db']['fw_version_pinned'] != '0')
								{
									// If the firmware version corresponds to the version of pinned firmware
									if ($fw['version'] == $this->device_info['db']['fw_version_pinned'])
									{
										// We write information about the pinned firmware in a special array
										$update_firmware['pinned'] = $fw;
									}
								}
								
								// If the firmware is active
								if ($fw['status'] == '1')
								{
									// We write information about the active firmware in a special array
									$update_firmware['active'] = $fw;
								}
							}
							
							// If there is information about the pinned firmware
							if (isset($update_firmware['pinned']) AND is_array($update_firmware['pinned']))
							{
								// We give the pinned firmware
								$give_firmware = $update_firmware['pinned'];
							}
							// If there is information about the active firmware
							elseif (isset($update_firmware['active']) AND is_array($update_firmware['active']))
							{
								// We give the active firmware
								$give_firmware = $update_firmware['active'];
							}
							else
							{
								// We don't give anything away.
								$give_firmware = FALSE;
							}
							
							// If the information for the device upgrade is received correctly, then we give the file to download
							if (isset($give_firmware) AND $give_firmware != FALSE AND isset($give_firmware['file_name']) AND isset($give_firmware['file_name_real']))
							{
								// If firmware file is readable...
								if (is_readable($this->config->item('storage_path', 'grcentral').'fw/'.$give_firmware['file_name_real']))
								{
									if ($this->device_info['db'] != FALSE)
									{
										// Logging:
										$this->logger->device_get_fw($this->device_info['db']['id'], array('fw_version'=>$this->device_info['useragent']['version']));
									}
									// Download file
									$this->grcentral->forcedownload($give_firmware['file_name'],$this->config->item('storage_path', 'grcentral').'fw/'.$give_firmware['file_name_real']);
									exit;
								}
							}
						}
					}
				}
			}
		}
		show_404();
	}
	
	// Processing Phonebook requests
	public function pb()
	{
		// Check system settings
		$pb_generation = $this->settings_model->syssettings_get('pb_generate_enable');
		if ($pb_generation == 'off') { show_404(); }
		
		if ($this->device_info['useragent'] != FALSE AND $this->device_info['db'] != FALSE AND $this->device_info['db']['status_active'] == '1')
		{
			// Logging
			$this->logger->device_get_pb($this->device_info['db']['id'], array('fw_version' => $this->device_info['useragent']['version']));
			// Download file
			$this->grcentral->forcedownload('phonebook.xml',$this->config->item('storage_path', 'grcentral').'phonebook/phonebook.xml');
			exit;
		}
		else
		{
			show_404();
		}
	}
	
	//
	// Service functions
	//
	private function _useragent2devicedata($string=NULL)
	{
		// Function for converting user agent to an array with information about the device
		if (!is_null($string) AND is_string($string))
		{
			$info_array = FALSE;
			
			// Exploding a string and forming an array from it
			$source_array = explode(' ', $string);
			
			// If Grandstream knocks on our door, we continue...
			if (isset($source_array[0]) AND $source_array[0] == 'Grandstream')
			{
				// Parsing the array
				foreach ($source_array as $id => $name)
				{
					if ($name == 'HW')		{ $info_array['model']		= htmlspecialchars($source_array[$id+1]); }
					if ($name == 'SW')		{ $info_array['version']	= htmlspecialchars($source_array[$id+1]); }
					if ($name == 'DevId')	{ $info_array['mac']		= htmlspecialchars($source_array[$id+1]); }
				}
				// If an array with information is formed, we give it back
				if (isset($info_array['model']) AND isset($info_array['version']) AND isset($info_array['mac']))
				{
					return $info_array;
				}
			}
		}
		return FALSE;
	}
	
	private function _update_device_info()
	{
		if ($this->device_info['db'] != FALSE)
		{
			// Update info about device firmware version
			$this->devices_model->edit($this->device_info['db']['id'], array('fw_version' => $this->device_info['useragent']['version']));
			
			$auto_update_ip_addr = $this->settings_model->syssettings_get('auto_update_ip_addr');
			if ($auto_update_ip_addr == 'on')
			{
				$this->devices_model->edit($this->device_info['db']['id'], array('ip_addr' => $this->device_info['client']['ip_addr']));
			}
		}
	}
	
	private function _check_access_device()
	{
		if ($this->device_info['db'] != FALSE)
		{
			$access_device_by_ip = $this->settings_model->syssettings_get('access_device_by_ip');
			if ($access_device_by_ip == 'on')
			{
				if ($this->device_info['db']['ip_addr'] != $this->device_info['client']['ip_addr'])
				{
					show_404();
				}
			}
		}
	}
}
