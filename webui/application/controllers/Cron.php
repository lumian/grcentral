<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\controllers\Cron.php
	Description:	Cron jabs for GRCentral.
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Cron extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Loading models:
		$this->load->model('devices_model');
		$this->load->model('phonebook_model');
		$this->load->model('logger_model');
	}
	
	public function webcron($query=NULL)
	{
		if (!$this->grcentral->is_user())
		{
			redirect(index_page());
		}
		$result = FALSE;
		
		if (!is_null($query))
		{
			$json_data['query'] = $query;
			if ($query == 'gencfg')
			{
				$result = $this->generate_cfg();
			}
			elseif ($query == 'genpb')
			{
				$result = $this->generate_pb();
			}
			elseif ($query == 'clean_logs')
			{
				$result = $this->clean_logs();
			}
			elseif ($query == 'ping_devices')
			{
				$result = $this->ping_devices();
			}
			else
			{
				show_404();
			}
			
			if ($result == TRUE)
			{
				$json_data['result'] = 'success';
				
			}
			else
			{
				$json_data['result'] = 'error';
			}
			echo json_encode($json_data);
		}
		else
		{
			show_404();
		}
	}
	
	public function clicron($type=NULL)
	{
		$result = FALSE;
		
		if ($this->input->is_cli_request())
		{
			if ($type == 'gencfg')
			{
				$result = $this->generate_cfg();
			}
			elseif ($type == 'genpb')
			{
				$result = $this->generate_pb();
			}
			elseif ($type == 'clean_logs')
			{
				$result = $this->clean_logs();
			}
			elseif ($type == 'ping_devices')
			{
				$result = $this->ping_devices();
			}
			else
			{
				echo "Error: Type not found";
			}
		}
		else
		{
			echo "Error: Only CLI requests are allowed.";
		}
		if ($result == TRUE)
		{
			echo "Task completed: ".$type.PHP_EOL;
		}
		else
		{
			echo "Error";
		}
	}
	
	//
	// Service functions
	//
	// Generating config files and collect phonebook
	private function generate_cfg()
	{
		$this->settings_model->syssettings_update(array('cfg_need_apply' => 'off'));
		$devices_list = $this->devices_model->getlist();
		$params_list = $this->settings_model->params_getlist();
		$models_list = $this->settings_model->models_getlist(array('group_data'=>TRUE));
		$servers_list = $this->settings_model->servers_getlist();
		
		// Phonebook integration (check system settings)
		$pb_collect_account = $this->settings_model->syssettings_get('pb_collect_accounts');
		$pb_abonents_list = $this->phonebook_model->abonents_getlist();
		
		if ($devices_list != FALSE AND $params_list != FALSE AND $models_list != FALSE AND $servers_list != FALSE)
		{
			$xml_path = $this->config->item('storage_path', 'grcentral').'cfg';
			$this->_clean_dir($xml_path);
			
			$xml_data = FALSE;
			
			foreach ($devices_list as $device)
			{
				$model_info = $models_list[$device['model_id']];
				if ($model_info['params_group_id'] != '0' AND $device['status_active'] == '1')
				{
					$params_id = $model_info['params_group_id'];
					$params_array_src = json_decode($params_list[$params_id]['params_json_data'], TRUE);
					$params_array = array();
					
					foreach($params_array_src as $param_string)
					{
						if (mb_stripos($param_string, "=") != FALSE)
						{
							$string_array = explode("=", $param_string);
							$key = trim($string_array[0]);
							$param = trim($string_array[1]);
							$params_array[$key] = $param;
						}
					}
					
					if (isset($device['params_json_data']) AND !is_null($device['params_json_data']) AND $device['params_json_data'] != "")
					{
						$device_params_array_src = json_decode($device['params_json_data'], TRUE);
						foreach($device_params_array_src as $device_param_string)
						{
							if (mb_stripos($device_param_string, "=") != FALSE)
							{
								$device_string_array = explode("=", $device_param_string);
								$key = trim($device_string_array[0]);
								$param = trim($device_string_array[1]);
								$params_array[$key] = $param;
							}
						}
					}
					
					if (isset($params_array['P2']))
					{
						// Update admin password in DB for CTI
						$this->devices_model->edit($device['id'], array('admin_password' => $params_array['P2']));
					}
					else
					{
						// Clear admin password in DB.
						$this->devices_model->edit($device['id'], array('admin_password' => ''));
					}
					
					$accounts_array = json_decode($device['accounts_data'], TRUE);
					// Get params from DB
					$params_db = array(
						'acc_atatus'	=> explode(",", $model_info['params_conf_acc_atatus']),
						'acc_name'		=> explode(",", $model_info['params_conf_acc_name']),
						'srv_main'		=> explode(",", $model_info['params_conf_srv_main']),
						'srv_reserve'	=> explode(",", $model_info['params_conf_srv_reserve']),
						'sip_userid'	=> explode(",", $model_info['params_conf_sip_userid']),
						'sip_authid'	=> explode(",", $model_info['params_conf_sip_authid']),
						'sip_passwd'	=> explode(",", $model_info['params_conf_sip_passwd']),
						'show_name'		=> explode(",", $model_info['params_conf_show_name']),
						'acc_display'	=> explode(",", $model_info['params_conf_acc_display']),
						'voicemail'		=> explode(",", $model_info['params_conf_voicemail'])
					);
					
					if ($accounts_array != NULL)
					{
						foreach($accounts_array as $acc_num=>$acc_info)
						{
							$acc_index = $acc_num - 1;
							// Account Active
							if (isset($params_db['acc_atatus'][$acc_index]) AND $params_db['acc_atatus'][$acc_index] != "P0")
							{
								$params_array[$params_db['acc_atatus'][$acc_index]]	= $acc_info['active'];
							}
							// Account Name
							if (isset($params_db['acc_name'][$acc_index]) AND $params_db['acc_name'][$acc_index] != "P0")
							{
								$params_array[$params_db['acc_name'][$acc_index]]	= $acc_info['name'];
							}
							// SIP Server
							if (isset($params_db['srv_main'][$acc_index]) AND $params_db['srv_main'][$acc_index] != "P0")
							{
								$params_array[$params_db['srv_main'][$acc_index]]	= $servers_list[$acc_info['voipsrv1']]['server'];
							}
							// Secondary SIP Server
							if (isset($params_db['srv_reserve'][$acc_index]) AND $params_db['srv_reserve'][$acc_index] != "P0")
							{
								$params_array[$params_db['srv_reserve'][$acc_index]]	= $servers_list[$acc_info['voipsrv2']]['server'];
							}
							// SIP User ID
							if (isset($params_db['sip_userid'][$acc_index]) AND $params_db['sip_userid'][$acc_index] != "P0")
							{
								$params_array[$params_db['sip_userid'][$acc_index]]	= $acc_info['userid'];
							}
							// Authenticate ID
							if (isset($params_db['sip_authid'][$acc_index]) AND $params_db['sip_authid'][$acc_index] != "P0")
							{
								$params_array[$params_db['sip_authid'][$acc_index]]	= $acc_info['authid'];
							}
							// Authenticate Password
							if (isset($params_db['sip_passwd'][$acc_index]) AND $params_db['sip_passwd'][$acc_index] != "P0")
							{
								$params_array[$params_db['sip_passwd'][$acc_index]]	= $acc_info['password'];
							}
							// Name							
							if (isset($params_db['show_name'][$acc_index]) AND $params_db['show_name'][$acc_index] != "P0")
							{
								$params_array[$params_db['show_name'][$acc_index]]	= $acc_info['name'];
							}
							// Account Display
							if (isset($params_db['acc_display'][$acc_index]) AND $params_db['acc_display'][$acc_index] != "P0")
							{
								$params_array[$params_db['acc_display'][$acc_index]]	= '1';
							}
							// Voice Mail Access Number
							if (!is_null($servers_list[$acc_info['voipsrv1']]['voicemail_number']) AND isset($params_db['voicemail'][$acc_index]) AND $params_db['voicemail'][$acc_index] != "P0")
							{
								$params_array[$params_db['voicemail'][$acc_index]]	= $servers_list[$acc_info['voipsrv1']]['voicemail_number'];
							}
							
							// Phonebook integration (collect data)
							if ($pb_collect_account == 'on')
							{
								// If the subscriber is already present in the database, we update the data about it
								if (isset($pb_abonents_list[$acc_info['userid']]) AND $pb_abonents_list[$acc_info['userid']]['data_source'] == 'accounts')
								{
									$abonent_db_info = $pb_abonents_list[$acc_info['userid']];
									$abonent_new_info = NULL;
									
									// Get subscriber name from account info (data format: "First_Name Last_Name"
									$abonent_name_explode = explode(' ', $acc_info['name']);
									if (isset($abonent_name_explode[0])) { $abonent_name['first_name'] =  $abonent_name_explode[0]; } else { $abonent_name['first_name'] = "N/A"; }
									if (isset($abonent_name_explode[1])) { $abonent_name['last_name'] =  $abonent_name_explode[1]; } else { $abonent_name['last_name'] = ""; }
									
									// We check the data for the need to update it in the database
									if ($abonent_db_info['first_name'] != $abonent_name['first_name'] OR $abonent_db_info['last_name'] != $abonent_name['last_name'] OR $abonent_db_info['external_id'] != $device['id'] OR $abonent_db_info['status'] != $acc_info['active'])
									{
										$pb_update_data[] = array(
											'id'				=> $pb_abonents_list[$acc_info['userid']]['id'],
											'first_name'		=> $abonent_name['first_name'],
											'last_name'			=> $abonent_name['last_name'],
											'external_id'		=> $device['id'],
											'status'			=> $acc_info['active']
										);
									}
								}
								// If the subscriber is not found in the database, then add it.
								if (!isset($pb_abonents_list[$acc_info['userid']]))
								{
									$abonent_name_explode = explode(' ', $acc_info['name']);
									if (isset($abonent_name_explode[0])) { $abonent_name['first_name'] =  $abonent_name_explode[0]; } else { $abonent_name['first_name'] = "N/A"; }
									if (isset($abonent_name_explode[1])) { $abonent_name['last_name'] =  $abonent_name_explode[1]; } else { $abonent_name['last_name'] = ""; }
									
									$pb_add_data[] = array(
										'first_name'		=> $abonent_name['first_name'],
										'last_name'			=> $abonent_name['last_name'],
										'phone_work'		=> $acc_info['userid'],
										'data_source'		=> 'accounts',
										'external_id'		=> $device['id'],
										'status'			=> $acc_info['active']
									);
								}
								$pb_check_abonents_data[$acc_info['userid']] = $acc_info['userid'];
							}
						}
						
					}
					
					$xml_data[] = array(
						'mac'				=> $device['mac_addr'],
						'params'			=> $params_array
					);
				}
			}
			
			// Phonebook integration
			
			// We perform data reconciliation to clear irrelevant subscribers
			if (isset($pb_abonents_list) AND is_array($pb_abonents_list))
			{
				foreach($pb_abonents_list as $abonent)
				{
					// We only check integrated subscribers
					if ($abonent['data_source'] == 'accounts')
					{
						if (!isset($pb_check_abonents_data[$abonent['phone_work']]))
						{
							echo "Del: ".$abonent['phone_work'].PHP_EOL;
							$pb_delete_data[] = $abonent['id'];
						}
					}
				}
				// Deleting data
				if (isset($pb_delete_data) AND is_array($pb_delete_data))
				{
					$this->phonebook_model->abonent_del_batch($pb_delete_data);
				}
			}
			
				
			if ($pb_collect_account == 'on')
			{
				// Updating data
				if (isset($pb_update_data) AND is_array($pb_update_data))
				{
					$this->phonebook_model->abonent_edit_batch($pb_update_data);
				}
				// Adding data
				if (isset($pb_add_data) AND is_array($pb_add_data))
				{
					$this->phonebook_model->abonent_add_batch($pb_add_data);
				}
			}
			
			if (is_array($xml_data))
			{
				foreach($xml_data as $xml)
				{
					$put_data = '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL;
					$put_data .= '<gs_provision version="1">'.PHP_EOL;
					$put_data .= '	<mac>'.$xml['mac'].'</mac>'.PHP_EOL;
					$put_data .= '	<config version="1">'.PHP_EOL;
					
					foreach($xml['params'] as $key=>$value)
					{
						$put_data .= '		<'.$key.'>'.$value.'</'.$key.'>'.PHP_EOL;
					}
					
					$put_data .= '	</config>'.PHP_EOL;
					$put_data .= '</gs_provision>'.PHP_EOL;
					
					$xml_file = $xml_path.'/cfg'.$xml['mac'].'.xml';
					file_put_contents($xml_file, $put_data);
					chmod($xml_file, 0666);
				}
				return TRUE;
			}
		}
		return FALSE;
	}
	
	// Generating phonebook
	private function generate_pb()
	{
		$pb_generation = $this->settings_model->syssettings_get('pb_generate_enable');
		
		$xml_path = $this->config->item('storage_path', 'grcentral').'phonebook';
		$this->_clean_dir($xml_path);
		
		if ($pb_generation == 'off')
		{
			return FALSE;
		}
		
		$pb_list = $this->phonebook_model->abonents_getlist(array('status' => '1'));
		
		if ($pb_list != FALSE AND count($pb_list) > 0)
		{
			foreach ($pb_list as $abonent)
			{
				$xml_data[] = array(
					'id'			=> $abonent['id'],
					'first_name'	=> $abonent['first_name'],
					'last_name'		=> $abonent['last_name'],
					'phone_work'	=> $abonent['phone_work']
				);
			}
		}
		
		if (isset($xml_data) AND is_array($xml_data))
		{
			// XML header:
			$put_data = '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL;
			$put_data .= '<AddressBook>'.PHP_EOL;
			$put_data .= ' <pbgroup>'.PHP_EOL;
			$put_data .= '  <id>0</id>'.PHP_EOL;
			$put_data .= '  <name>Default</name>'.PHP_EOL;
			$put_data .= ' </pbgroup>'.PHP_EOL;
			
			foreach($xml_data as $row)
			{
				// XML Contact data
				$put_data .= ' <Contact>'.PHP_EOL;
				$put_data .= '  <id>'.$row['id'].'</id>'.PHP_EOL;
				$put_data .= '  <FirstName>'.$row['first_name'].'</FirstName>'.PHP_EOL;
				$put_data .= '  <LastName>'.$row['last_name'].'</LastName>'.PHP_EOL;
				$put_data .= '  <Frequent>0</Frequent>'.PHP_EOL;
				$put_data .= '  <Phone type="Work">'.PHP_EOL;
				$put_data .= '   <phonenumber>'.$row['phone_work'].'</phonenumber>'.PHP_EOL;
				$put_data .= '   <accountindex>1</accountindex>'.PHP_EOL;
				$put_data .= '  </Phone>'.PHP_EOL;
				$put_data .= '  <Group>0</Group>'.PHP_EOL;
				$put_data .= '  <Primary>0</Primary>'.PHP_EOL;
				$put_data .= ' </Contact>'.PHP_EOL;
			}
			$put_data .= '</AddressBook>'.PHP_EOL;
			$xml_file = $xml_path.'/phonebook.xml';
			file_put_contents($xml_file, $put_data);
			
			return TRUE;
		}
		return FALSE;
	}
	
	// Clean logs
	private function clean_logs()
	{
		// Read the config
		$keep_logs = $this->config->item('keep_logs', 'cron');
		
		// Calculating dates
		$current_date = date('Y-m-d H:i:s');
		$remove_before_date = date('Y-m-d H:i:s', strtotime($current_date. " - ".$keep_logs." day"));
		
		// DB query
		$result = $this->logger_model->clean_logs('provisioning', $remove_before_date);
		if ($result === TRUE)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	// Ping devices
	public function ping_devices()
	{
		$devices_list = $this->devices_model->getlist();
		
		if (count($devices_list) > 0)
		{
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
			{
				$windows_os = TRUE;
			}
			else
			{
				$windows_os = FALSE;
			}
			
			foreach ($devices_list as $device)
			{
				$status_online = '0';
				
				if ($device['status_active'] == '1')
				{
					if ($windows_os == TRUE)
					{
						// Windows OS
						$cmd = "ping -n 1 ".$device['ip_addr'];
					}
					else
					{
						// non Windows OS
						$cmd = "ping -c 1 ".$device['ip_addr'];
					}
					
					exec($cmd, $ping_output, $ping_result);
					
					if ($ping_result == 0)
					{
						$status_online = '1';
					}
				}
				$this->devices_model->update_monitoring_status($device['id'], $status_online);
			}
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	private function _clean_dir($dir)
	{
		$files_list = glob($dir."/*");
		if (count($files_list) > 0)
		{
			foreach ($files_list as $file)
			{      
				if (file_exists($file) AND $file != 'index.html')
				{
					unlink($file);
				}   
			}
		}
	}
}
