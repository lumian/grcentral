<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.2
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
		$this->load->model('settings_model');
		$this->load->model('devices_model');
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
	private function generate_cfg()
	{
		$this->settings_model->syssettings_update(array('cfg_need_apply' => 'off'));
		$devices_list = $this->devices_model->getlist();
		$params_list = $this->settings_model->params_getlist();
		$models_list = $this->settings_model->models_getlist(array('group_data'=>TRUE));
		$servers_list = $this->settings_model->servers_getlist();
		
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
						}
					}
					
					$xml_data[] = array(
						'mac'				=> $device['mac_addr'],
						'params'			=> $params_array
					);
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
	
	private function _clean_dir($dir) {
		$files_list = glob($dir."/*");
		if (count($files_list) > 0)
		{
			foreach ($files_list as $file)
			{      
				if (file_exists($file))
				{
					unlink($file);
				}   
			}
		}
	}
}
