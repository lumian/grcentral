<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\controllers\Api.php
	Description:	API for GRCentral.
	API version:	v1
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Api extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->grcentral->installed_check('404');
		$this->load->database();
		$this->load->library('logger');
		
		$this->_CheckAccess();
	}
	
	//
	// Checking API access
	//
	private function _CheckAccess()
	{
		$api_enable = $this->settings_model->syssettings_get('api_enable');
		if ($api_enable == 'off' OR $api_enable == FALSE)
		{
			show_404();
		}
		$auth_user = FALSE;
		$client_ip = $this->grcentral->get_client_ip();		
		$api_users = $this->config->item('users', 'api');
		
		if ($api_users != FALSE AND is_array($api_users) AND $client_ip != FALSE)
		{
			foreach($api_users as $row)
			{
				if (isset($row['ip']) AND $row['ip'] == $client_ip)
				{
					$auth_user = $row;
				}
			}
		}
		
		if ($auth_user != FALSE)
		{
			$this->api_user = $auth_user;
		}
		else
		{
			show_404();
		}
	}
	
	//
	// Function for output data
	//
	private function _RenderPage($array_data=NULL)
	{
		if ($array_data != NULL AND is_array($array_data))
		{
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($array_data, JSON_UNESCAPED_UNICODE));
		}
		else
		{
			show_404();
		}
	}
	
	//
	// API v1 start function
	//
	public function v1($query_category=NULL,$param1=NULL,$param2=NULL)
	{
		$result = array(
			'error'			=> TRUE,
			'result'		=> NULL
		);
		
		if (!is_null($query_category))
		{
			if ($query_category == 'phonebook')
			{
				// EN: Get information from phonebook
				// RU: Получение информации из телефонной книги
				if (!is_null($param1) AND $param1 != FALSE AND !is_null($param2) AND $param2 != FALSE)
				{
					$query_result = $this->_v1_phonebook_get($param1, $param2);
				}
			}
			elseif ($query_category == 'devices')
			{
				// EN: Get information about devices
				// RU: Получение информации об устройствах
				if (!is_null($param1) AND $param1 != FALSE AND !is_null($param2) AND $param2 != FALSE)
				{
					$query_result = $this->_v1_device_get($param1, $param2);
				}
			}
			elseif ($query_category == 'device_models')
			{
				// EN: Get information about device models
				// RU: Получение информации о моделях устройств
				if (!is_null($param1) AND $param1 != FALSE AND !is_null($param2) AND $param2 != FALSE)
				{
					$query_result = $this->v1_device_models_get($param1, $param2);
				}
			}
		}
		
		if (isset($query_result) AND isset($query_result['data']) AND isset($query_result['error']))
		{
			if ($query_result['error'] == FALSE AND is_array($query_result['data']))
			{
				$result['error'] = FALSE;
				$result['result'] = $query_result['data'];
			}
		}
		
		$logger_data = array(
			'query'			=> $this->uri->uri_string(),
			'client_ip'		=> $this->grcentral->get_client_ip(),
			'error'			=> $result['error']
		);
		$this->logger->api_get($this->api_user['id'], $logger_data);
		
		$this->_RenderPage($result);
	}
	
	// 
	// Functions for processing API requests
	//
	private function _v1_phonebook_get($type=NULL, $subtype=NULL)
	{
		$this->load->model('phonebook_model');
		
		$result = array(
			'data'		=> NULL,
			'error'		=> TRUE
		);
		
		if (!is_null($type) AND !is_null($subtype))
		{
			if ($type == 'list' AND is_string($subtype))
			{
				if ($subtype == 'all')
				{
					$phonebook = $this->phonebook_model->abonents_getlist();
				}
				elseif ($subtype == 'active')
				{
					$phonebook = $this->phonebook_model->abonents_getlist(array('status'=>'1'));
				}
				else
				{
					$phonebook = FALSE;
				}
				
				if ($phonebook != FALSE)
				{
					foreach($phonebook as $contact)
					{
						$result_data[$contact['id']] = array(
							'first_name'		=> ( isset($contact['first_name']) ? $contact['first_name'] : NULL ),
							'last_name'			=> ( isset($contact['last_name']) ? $contact['last_name'] : NULL ),
							'phone_work'		=> ( isset($contact['phone_work']) ? $contact['phone_work'] : NULL )
						);
					}
				}
			}
			elseif ($type == 'phone' AND is_numeric($subtype))
			{
				$contact_info = $this->phonebook_model->abonent_get(array('phone_work'=>$subtype));
				
				if ($contact_info != FALSE)
				{
					$result_data = array(
						'first_name'		=> ( isset($contact_info['first_name']) ? $contact_info['first_name'] : NULL ),
						'last_name'			=> ( isset($contact_info['last_name']) ? $contact_info['last_name'] : NULL ),
						'phone_work'		=> ( isset($contact_info['phone_work']) ? $contact_info['phone_work'] : NULL )
					);
				}
			}
			else
			{
				$result_data = FALSE;
			}
			
			if ($result_data != FALSE AND is_array($result_data))
			{
				$result = array(
					'data'		=> $result_data,
					'error'		=> FALSE
				);
			}
		}
		return $result;
	}
	
	private function _v1_device_get($type=NULL, $subtype=NULL)
	{
		$this->load->model('devices_model');
		
		$result = array(
			'data'		=> NULL,
			'error'		=> TRUE
		);
		
		if (!is_null($type) AND !is_null($subtype))
		{
			if ($type == 'id' AND is_numeric($subtype))
			{
				$result_data = $this->devices_model->get(array('id'=>$subtype));
			}
			elseif ($type == 'ip' AND filter_var($subtype,FILTER_VALIDATE_IP) != FALSE)
			{
				$result_data = $this->devices_model->get(array('ip_addr'=>$subtype));
			}
			elseif ($type == 'mac' AND mb_strlen($subtype) == '12')
			{
				$result_data = $this->devices_model->get(array('mac_addr'=>$subtype));
			}
			elseif ($type == 'list' AND $subtype == 'active')
			{
				$result_data = $this->devices_model->getlist(array('status_active'=>'1'));
			}
			elseif ($type == 'list' AND $subtype == 'all')
			{
				$result_data = $this->devices_model->getlist();
			}
			else
			{
				$result_data = FALSE;
			}
			
			if ($result_data != FALSE AND is_array($result_data))
			{
				if ($type == 'list')
				{
					foreach($result_data as $data)
					{
						$device_data[] = array(
							'id'							=> ( isset($data['id']) ? $data['id'] : NULL ),
							'mac_addr'						=> ( isset($data['mac_addr']) ? $data['mac_addr'] : NULL ),
							'ip_addr'						=> ( isset($data['ip_addr']) ? $data['ip_addr'] : NULL ),
							'model_id'						=> ( isset($data['model_id']) ? $data['model_id'] : NULL ),
							'status_online'					=> ( isset($data['status_online']) ? $data['status_online'] : NULL ),
							'status_online_changetime'		=> ( isset($data['status_online_changetime']) ? $data['status_online_changetime'] : NULL ),
							'status_active'					=> ( isset($data['status_active']) ? $data['status_active'] : NULL ),
							'descr'							=> ( isset($data['descr']) ? $data['descr'] : NULL ),
							'fw_version'					=> ( isset($data['fw_version']) ? $data['fw_version'] : NULL ),
							'fw_version_pinned'				=> ( isset($data['fw_version_pinned']) ? $data['fw_version_pinned'] : NULL ),
							'params_json_data'				=> ( isset($data['params_json_data']) ? $data['params_json_data'] : NULL )
						);
					}
				}
				else
				{
					$device_data = array(
						'id'							=> ( isset($result_data['id']) ? $result_data['id'] : NULL ),
						'mac_addr'						=> ( isset($result_data['mac_addr']) ? $result_data['mac_addr'] : NULL ),
						'ip_addr'						=> ( isset($result_data['ip_addr']) ? $result_data['ip_addr'] : NULL ),
						'model_id'						=> ( isset($result_data['model_id']) ? $result_data['model_id'] : NULL ),
						'status_online'					=> ( isset($result_data['status_online']) ? $result_data['status_online'] : NULL ),
						'status_online_changetime'		=> ( isset($result_data['status_online_changetime']) ? $result_data['status_online_changetime'] : NULL ),
						'status_active'					=> ( isset($result_data['status_active']) ? $result_data['status_active'] : NULL ),
						'descr'							=> ( isset($result_data['descr']) ? $result_data['descr'] : NULL ),
						'fw_version'					=> ( isset($result_data['fw_version']) ? $result_data['fw_version'] : NULL ),
						'fw_version_pinned'				=> ( isset($result_data['fw_version_pinned']) ? $result_data['fw_version_pinned'] : NULL ),
						'params_json_data'				=> ( isset($result_data['params_json_data']) ? $result_data['params_json_data'] : NULL )
					);
				}
				
				$result = array(
					'data'		=> $device_data,
					'error'		=> FALSE
				);
			}
		}
		return $result;
	}
	
	private function v1_device_models_get($type=NULL, $subtype=NULL)
	{
		$this->load->model('settings_model');
		
		$result = array(
			'data'		=> NULL,
			'error'		=> TRUE
		);
		
		if ($type == 'list' AND $subtype == 'all')
		{
			$result_data = $this->settings_model->models_getlist();
		}
		elseif ($type == 'id' AND is_numeric($subtype))
		{
			$result_data = $this->settings_model->models_get(array('id' => $subtype));
		}
		else
		{
			$result_data = FALSE;
		}
		
		if ($result_data != FALSE AND is_array($result_data))
		{
			if ($type == 'list')
			{
				foreach($result_data as $data)
				{
					$device_models_data[] = array(
						'id'				=> ( isset($data['id']) ? $data['id'] : NULL ),
						'tech_name'			=> ( isset($data['id']) ? $data['tech_name'] : NULL ),
						'friendly_name'		=> ( isset($data['id']) ? $data['friendly_name'] : NULL )
					);
				}
			}
			else
			{
				$device_models_data = array(
					'id'				=> ( isset($result_data['id']) ? $result_data['id'] : NULL ),
					'tech_name'			=> ( isset($result_data['id']) ? $result_data['tech_name'] : NULL ),
					'friendly_name'		=> ( isset($result_data['id']) ? $result_data['friendly_name'] : NULL )
				);
			}
			
			$result = array(
				'data'		=> $device_models_data,
				'error'		=> FALSE
			);
		}
		
		
		return $result;
	}
}
