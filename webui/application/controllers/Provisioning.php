<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provisioning extends CI_Controller {
	
	private $testmode = FALSE;
	
	public function __construct()
	{
		parent::__construct();
		
		// Loading:
		$this->load->model('settings_model'); // Model for working with a database
		$this->load->model('phones_model'); // Model for working with a database
		$this->load->library('forcedownload'); // Library for giving files to the client
	}
	
	//
	// Query functions
	//
	
	// Processing CFG requests
	public function cfg($get_file=NULL)
	{
		// If the requested file is present
		if (!is_null($get_file))
		{
			// Trying to get phone information from UserAgent
			$phone_info = $this->_useragent2phonedata($_SERVER['HTTP_USER_AGENT']);
			
			// If the phone information is received, we continue
			if ($phone_info != FALSE AND isset($phone_info['model']) AND isset($phone_info['version']) AND isset($phone_info['mac']))
			{
				// Searching for the device in the database
				$phone_info_db = $this->phones_model->get(array('mac_addr' => $phone_info['mac']));
				
				// If the device is found in the database, we continue
				if ($phone_info_db != FALSE)
				{
					// If the requested file matches the configuration file template, then continue
					if ($get_file == 'cfg'.$phone_info_db['mac_addr'].'.xml')
					{
						// 
						if ($phone_info_db['status_active'] == '1')
						{
							$this->phones_model->edit($phone_info_db['id'], array('fw_version' => $phone_info['version']));
							if (is_readable($this->config->item('storage_path', 'grcentral').'cfg/'.$get_file))
							{
								$this->forcedownload->start($get_file, $this->config->item('storage_path', 'grcentral').'cfg/'.$get_file);
							}
							else
							{
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
						// Displaying the 404 error
						show_404();
					}
				}
				else
				{
					// Getting the value from the config
					$auto_add = $this->config->item('auto_add_devices', 'provisioning');
					
					// If auto-adding devices is allowed, we continue
					if ($auto_add === TRUE)
					{
						// Getting model info from DB
						$model_info = $this->settings_model->models_get(array('tech_name' => $phone_info['model']));
						
						// Forming an array with data
						$add_data['mac_addr']		= $phone_info['mac'];
						$add_data['ip_addr']		= $_SERVER['REMOTE_ADDR'];
						$add_data['status_active']	= '0';
						$add_data['descr']			= "AutoAdd";
						$add_data['fw_version']		= $phone_info['version'];
						if ($model_info === FALSE)
						{
							$add_data['model_id'] = '0';
						}
						else 
						{
							$add_data['model_id'] = $model_info['id'];
						}
						$this->phones_model->add($add_data);
					}
					// Displaying the 404 error
					show_404();
				}
			}
			else
			{
				// If the phone information could not be obtained, we give the error 404.
				show_404();
			}
		}
		else
		{
			// If the request is empty, we give an error 404.
			show_404();
		}
	}
	
	// Processing FW requests (language.txt file, rindX.bin files, pdate files)
	public function fw($get_file=NULL)
	{
		// If the requested file is present
		if (!is_null($get_file))
		{
			// Trying to get phone information from UserAgent
			$phone_info = $this->_useragent2phonedata($_SERVER['HTTP_USER_AGENT']);
			
			// If the phone information is received, we continue
			if ($phone_info != FALSE AND isset($phone_info['model']) AND isset($phone_info['version']) AND isset($phone_info['mac']))
			{
				// Get the language.txt file
				if ($get_file == 'language.txt')
				{
					// In the development...
					show_404();
				}
				elseif ($get_file == 'ring1.bin' OR $get_file == 'ring2.bin' OR $get_file == 'ring3.bin' OR $get_file == 'ring4.bin' OR $get_file == 'ring5.bin')
				{
					$file_path = $this->config->item('storage_path', 'grcentral').'rings/'.$get_file;
			
					if (is_readable($file_path))
					{
						$this->forcedownload->start($get_file, $file_path);
					}
					else
					{
						show_404();
					}
				}
				else
				{
					$this->_fw_download_update($phone_info, $get_file);
				}
			}
			else
			{
				// If the phone information could not be obtained, we give the error 404.
				show_404();
			}
		}
		else
		{
			// If the request is empty, we give an error 404.
			show_404();
		}
	}
	
	// Processing Phonebook requests
	public function pb()
	{
		// In the development...
		show_404();
	}
	
	//
	// Service functions
	//
	private function _fw_download_update($phone_info=NULL, $get_file=NULL)
	{
		// Checking the input data
		if (!is_null($phone_info) AND is_array($phone_info) AND isset($phone_info['model']) AND isset($phone_info['version']) AND isset($phone_info['mac']) AND !is_null($get_file) AND is_string($get_file))
		{
			// Checking the phone model in the database
			$model_info = $this->settings_model->models_get(array('tech_name' => $phone_info['model']));
			
			// If the phone model is found in the database, we continue
			if ($model_info != FALSE AND isset($model_info['group_id']))
			{
				// Getting a list of updates for the selected phone group.
				$fw_list = $this->settings_model->fw_getlist(array('group_id' => $model_info['group_id'], 'status' => '1'));
				
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
							// If the version of the current update corresponds to the device version, then we write the information to the array
							if ($fw['version'] == $phone_info['version'])
							{
								$update_firmware['current'] = $fw;
							}
							// Storing information about the initial update
							if ($fw['previous_version'] == '0')
							{
								$update_firmware['starting'] = $fw;
							}
							// If the previous version corresponds to the device version, then we record information about the necessary update
							if ($fw['previous_version'] == $phone_info['version'])
							{
								$update_firmware['upgrade'] = $fw;
							}
						}
						// If a recent update is found, we will initiate an upgrade
						if (isset($update_firmware['upgrade']))
						{
							$put_firmware = $update_firmware['upgrade'];
						}
						// If information about the current version is found and information about the upgrade is not found, we do not upgrade it. Device with the latest firmware version.
						elseif (isset($update_firmware['current']) AND !isset($update_firmware['upgrade']))
						{
							$put_firmware = FALSE;
						}
						// If information about the initial update is found and information about the current version of the device is not found and information about the upgrade is not found, then we give the starting firmware
						elseif (isset($update_firmware['starting']) AND !isset($update_firmware['current']) AND !isset($update_firmware['upgrade']))
						{
							$put_firmware = $update_firmware['starting'];
						}
						else
						{
							show_404(current_url());
						}
						
						// FOR TESTING ONLY:
						if ($this->testmode === TRUE)
						{
							echo "Get file: ".$get_file.PHP_EOL;
							echo "Phone model: ".$model_info['friendly_name'].PHP_EOL;
							echo "Phone sw version: ".$phone_info['version'].PHP_EOL;
							if (isset($put_firmware) AND $put_firmware != FALSE)
							{
								echo "New sw version: ".$put_firmware['version'].PHP_EOL;
								echo "Put file: ".$this->config->item('storage_path', 'grcentral').'fw/'.$put_firmware['file_name_real'].PHP_EOL;
							}
							else
							{
								echo "No new updates";
							}
						}
						else
						{
							// If the information for the device upgrade is received correctly, then we give the file to download
							if (isset($put_firmware) AND $put_firmware != FALSE AND isset($put_firmware['file_name']) AND isset($put_firmware['file_name_real']))
							{
								if (is_readable($this->config->item('storage_path', 'grcentral').'fw/'.$put_firmware['file_name_real']))
								{
									$this->forcedownload->start($put_firmware['file_name'],$this->config->item('storage_path', 'grcentral').'fw/'.$put_firmware['file_name_real']);
								}
								else
								{
									show_404();
								}
							}
							else
							{
								show_404();
							}
						}
						exit;
					}
				}
			}
		}
		show_404();
	}
	
	private function _useragent2phonedata($string=NULL)
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
}
